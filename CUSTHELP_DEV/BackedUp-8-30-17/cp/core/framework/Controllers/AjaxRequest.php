<?php

namespace RightNow\Controllers;

use RightNow\Utils\Framework,
    RightNow\Libraries\AbuseDetection,
    RightNow\Utils\Config;

/**
* Generic controller endpoint for standard widgets to make requests to retrieve data. Nearly all of the
* methods in this controller echo out their data in JSON so that it can be received by the calling JavaScript.
*/
final class AjaxRequest extends Base
{
    public function __construct()
    {
        parent::__construct();

        parent::_setClickstreamMapping(array(
            "getNewFormToken" => "form_token_update",
            "getReportData" => "report_data_service",
            "emailAnswer" => "email_answer",
            "submitAnswerFeedback" => "answer_feedback",
            "submitAnswerRating" => "answer_rating",
            "addOrRenewNotification" => "notification_update",
            "deleteNotification" => "notification_delete",
            "sendForm" => "incident_submit",
            "doLogin" => "account_login",
            "getAnswer" => "answer_view"
        ));
        // Allow account creation, account recovery, and login stuff for users who aren't logged in if CP_CONTACT_LOGIN_REQUIRED is on.
        parent::_setMethodsExemptFromContactLoginRequired(array(
            'sendForm',
            'checkForExistingContact', // Part of the account creation process.
            'doLogin',
            'getChatQueueAndInformation',
        ));
    }

    /**
     * Special case to handle requests to getGuidedAssistanceTree when made from
     * the agent console.
     * @internal
     */
    public function _ensureContactIsAllowed()
    {
        if($this->uri->router->fetch_method() === 'getGuidedAssistanceTree' && is_object($this->_getAgentAccount())){
            return true;
        }
        return parent::_ensureContactIsAllowed();
    }

    /**
     * Perform a search action on a search source. Expects the sourceID to execute, as well as filters
     * to apply to the search source.
     */
    public function search() {
        $filters = json_decode($this->input->post('filters'), true);
        $filters['limit'] = array('value' => $this->input->request('limit'));
        $sourceID = $this->input->post('sourceID');

        $search = \RightNow\Libraries\Search::getInstance($sourceID);
        $search->addFilters($filters);

        echo json_encode($search->executeSearch());
    }

    /**
     * Perform a search action on a report. Expects the report ID to execute, as well as filters and formatting options
     * to apply to the report.
     */
    public function getReportData()
    {
        $filters = $this->input->post('filters');
        $filters = json_decode($filters);
        $filters = (is_object($filters))
            ? get_object_vars($filters)
            : array();

        if(!$this->model('Report')->isValidOrgFilter($filters, $this->session->getProfile(true))) {
            //exit if organization filter is not valid - unauthorized access
            return;
        }

        if($filters['search'] == 1)
            $this->model('Report')->updateSessionforSearch();
        $format = $this->input->post('format');
        $format = json_decode($format);
        $format = is_object($format)
            ? get_object_vars($format)
            : array();

        $reportID = $this->input->post('report_id');
        $reportToken = $this->input->post('r_tok');

        $results = $this->model('Report')->getDataHTML($reportID, $reportToken, $filters, $format)->result;

        /*
         * This request cannot be cached because not all rules that define how the page is rendered are in the POST data:
         * User search preferences, such as the number of results per page, are stored in the contacts table.
         * The Ask a Question tab may be hidden if the user has not searched enough times.
         * The user's profile is updated when they do a search.
         */
        $this->_renderJSON($results);
    }

    /**
    * Retrieves an answer (containing all business object fields) specified by the answer id. Returns the answer
    * object with ID, Question, and Solution fields populated.
    */
    public function getAnswer()
    {
        AbuseDetection::check();
        $answerID = $this->input->request('answerID');
        $this->session->setSessionData(array('answersViewed' => $this->session->getSessionData('answersViewed') + 1));
        Framework::sendCachedContentExpiresHeader();
        // This request cannot be cached because of session tracking and conditional sections
        $answer = $this->model('Answer')->get($answerID);
        if($answer->result){
            $fieldsToReturn = array('ID', 'Question', 'Solution');
            if($answer->result->AnswerType->ID === ANSWER_TYPE_URL){
                $fieldsToReturn[] = 'URL';
            }
            else if($answer->result->AnswerType->ID === ANSWER_TYPE_ATTACHMENT){
                $fieldsToReturn[] = 'FileAttachments.*.ID';
            }

            if($answer->result->GuidedAssistance->ID){
                $fieldsToReturn[] = 'GuidedAssistance.ID';
            }

            $this->_echoJSON($answer->toJson($fieldsToReturn));
        }
        else{
            $this->_echoJSON($answer->toJson());
        }
    }

    /**
     * Create incident from answer feedback. Returns the ID of the incident created or an error message if it failed
     */
    public function submitAnswerFeedback()
    {
        AbuseDetection::check();
        $answerID = $this->input->post('a_id');
        if($answerID === 'null')
            $answerID = null;
        $rate = $this->input->post('rate');
        $message = $this->input->post('message');
        $givenEmail = $this->input->post('email');
        $threshold = $this->input->post('threshold');
        $optionsCount = $this->input->post('options_count');
        $formToken = $this->input->post('f_tok');
        if (!count($_POST) || !$formToken || !Framework::isValidSecurityToken($formToken, 0)){
            $this->_renderJSON(Config::getMessage(ERROR_REQUEST_ACTION_COMPLETED_MSG));
            return;
        }
        $incidentResult = $this->model('Incident')->submitFeedback($answerID, $rate, $threshold, null, $message, $givenEmail, $optionsCount);
        if($incidentResult->result){
            $this->_renderJSON(array('ID' => $incidentResult->result->ID));
            return;
        }
        if($incidentResult->error){
            $this->_renderJSON(array('error' => $incidentResult->error->externalMessage));
            return;
        }
        $this->_renderJSON(Config::getMessage(ERROR_REQUEST_ACTION_COMPLETED_MSG));
    }

    /**
     * Answer rating request. Takes the answer ID, rating and options count and rates the answer via the Answer model
     */
    public function submitAnswerRating()
    {
        $this->_renderJSON(1); // No need to wait for API call before responding
        $answerID = $this->input->post('a_id');
        $rating = $this->input->post('rate');
        $scale = $this->input->post('options_count');
        if($answerID){
            $this->model('Answer')->rate($answerID, $rating, $scale);
        }
    }

    /**
     * Request to delete a product, category or answer notification. Returns a list of errors that might have occured
     */
    public function deleteNotification()
    {
        AbuseDetection::check();
        $response = $this->model('Notification')->delete($this->input->post('filter_type'), $this->input->post('id'), $this->input->post('cid'));
        $this->_renderJSON(array('error' => ($response->errors) ? (string) $response->error : ''));
    }


    /**
     * Request to add or renew a product, category or answer notification. Returns a list of remaining notifications
     * as well as any errors that might have occured.
     */
    public function addOrRenewNotification()
    {
        AbuseDetection::check();
        $response = $this->model('Notification')->add($this->input->post('filter_type'), intval($this->input->post('id')), $this->input->post('cid'));

        $notifications = array();
        // Build a simple array of notifications to send back
        if (is_array($response->result)) {
            foreach ($response->result as $key => $objects) {
                foreach ($objects as $notification) {
                    $connectName = ucfirst($key);
                    $ID = $notification->$connectName->ID;
                    $chain = $summary = '';
                    if ($connectName === 'Answer') {
                        $summary = $notification->$connectName->Summary;
                        $label = Config::getMessage(ANSWER_LBL);
                    }
                    else {
                        $label = ($connectName === 'Product') ? Config::getMessage(PRODUCT_LBL) : Config::getMessage(CATEGORY_LBL);
                        $hierarchy = "{$connectName}Hierarchy";
                        foreach ($notification->$connectName->$hierarchy as $parent) {
                            $chain .= $parent->ID . ',';
                            $summary .= $parent->LookupName . ' / ';
                        }
                        $chain .= $ID;
                        $summary .= $notification->$connectName->LookupName;
                    }
                    $notifications[] = array(
                        'id' => $ID,
                        'type' => $key,
                        'label' => $label,
                        'summary' => $summary,
                        'chain' => $chain,
                        'startDate' => Framework::formatDate($notification->StartTime, 'default', null),
                        'expiration' => $notification->ExpireTime,
                        'rawStartTime' => $notification->StartTime
                    );
                }
            }
        }

        $this->_renderJSON(array(
            'error' => ($response->errors) ? (string) $response->error : null,
            'notifications' => Framework::sortBy($notifications, true, function($n) { return $n['rawStartTime']; }),
            'action' => $response->action,
        ));
    }

    /**
     * Generic form submission handler for submitting contact and incident data. Returns details about the
     * form submission, including errors, IDs of records created, or SA results if an incident is being submitted.
     */
    public function sendForm()
    {
        AbuseDetection::check($this->input->post('f_tok'));
        $data = json_decode($this->input->post('form'));
        if(!$data)
        {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
            // Pad the error message with spaces so IE will actually display it instead of a misleading, but pretty, error message.
            Framework::writeContentWithLengthAndExit(json_encode(Config::getMessage(END_REQS_BODY_REQUESTS_FORMATTED_MSG)) . str_repeat("\n", 512), 'application/json');
        }
        if($listOfUpdateRecordIDs = json_decode($this->input->post('updateIDs'), true)){
            $listOfUpdateRecordIDs = array_filter($listOfUpdateRecordIDs);
        }
        $smartAssistant = $this->input->post('smrt_asst');
        $this->_echoJSON($this->model('Field')->sendForm($data, $listOfUpdateRecordIDs ?: array(), ($smartAssistant === 'true'))->toJson());
    }

    /**
     * Retrieves a new form token that can be used to submit a contact or incident form.
     */
    public function getNewFormToken()
    {
        if($formToken = $this->input->post('formToken'))
        {
            $this->_renderJSON(array(
                'newToken' => Framework::createTokenWithExpiration(0, Framework::doesTokenRequireChallenge($formToken))
            ));
        }
    }

    /**
     * Checks that a contact doesn't already exist with the specified email or login. Returns either an error
     * message if the contact exists, or false if they don't.
     */
    public function checkForExistingContact()
    {
        // This usually gets called from a blur handler when the user tabs out of a form field.
        // That'd be a really awkward time to show a CAPTCHA dialog. Instead, I just report that the
        // contact doesn't exist. Server-side validation will report the error when the form is
        // submitted. This approach not only avoids annoying users, but also limits the ability of a
        // bad guy to launch a dictionary attack to determine the content of our contacts database. The
        // scenario where this is called is during the modified AAQ workflow. In that case, we really do
        // want a real answer, and are willing to show a CAPTCHA to get it. To do that, we post an
        // additional field to say we really want an abuse check to be returned.
        if($this->input->post('checkForChallenge')){
            AbuseDetection::check();
        }
        else if (AbuseDetection::isAbuse()) {
            Framework::writeContentWithLengthAndExit(json_encode(false), 'application/json');
        }
        $token = $this->input->post('contactToken');
        if(Framework::isValidSecurityToken($token, 1) === false){
            $this->_renderJSON(false);
            return;
        }
        $pwReset = $this->input->post('pwReset');
        if($email = $this->input->post('email'))
        {
            $paramType = 'email';
            $param = $email;
        }
        else if(!is_null($login = $this->input->post('login')))
        {
            $paramType = 'login';
            $param = $login;
        }
        $results = $this->model('Contact')->contactAlreadyExists($paramType, $param, $pwReset)->result;
        $this->_renderJSON($results);
    }

    /**
     * Perform the login of a user given their username/password. Returns the result from the
     * login. Either additional redirect information, or an error message.
     */
    public function doLogin()
    {
        AbuseDetection::check();
        $userID = $this->input->post('login');
        $password = $this->input->post('password');
        $sessionID = $this->session->getSessionData('sessionID');
        $widgetID  = $this->input->post('w_id');
        $url = $this->input->post('url');
        $result = $this->model('Contact')->doLogin($userID, $password, $sessionID, $widgetID, $url)->result;
        $this->_renderJSON($result);
    }

    /**
     * Redirects a chat request to the chat server and returns the response. Returns the result
     * from the chat server.
     */
    public function doChatRequest()
    {
        $result = $this->model('Chat')->makeChatRequest();
        if($result)
            echo $result;
    }

    /**
     * AJAX request handler for chat queue retrieval. Fetches queue ID and availability information.
     */
    public function getChatQueueAndInformation()
    {
        if($this->input->request['test'])
            return;

        $chatProduct = $this->input->request('prod');
        $chatCategory = $this->input->request('cat');
        $contactID = intval($this->input->request('c_id'));
        $orgID = intval($this->input->request('org_id'));
        $contactEmail = $this->input->request('contact_email');
        $contactFirstName = $this->input->request('contact_fname');
        $contactLastName = $this->input->request('contact_lname');
        $availType = $this->input->request('avail_type');
        $isCacheable = $this->input->request('cacheable');
        $callback = $this->input->request('callback');
        $interfaceID = \RightNow\Api::intf_id();

        $cacheKey = implode('|', array($chatProduct, $chatCategory, $contactID, $orgID, $contactEmail, $contactFirstName, $contactLastName, $interfaceID));
        $cache = new \RightNow\Libraries\Cache\Memcache(60);

        if (($chatRouteRV = $cache->get($cacheKey)) === false)
        {
            $chatRouteRV = $this->model('Chat')->chatRoute($chatProduct, $chatCategory, $contactID, $orgID, $contactEmail, $contactFirstName, $contactLastName)->result;
            $cache->set($cacheKey, $chatRouteRV);
        }

        $result = $this->model('Chat')->checkChatQueue($chatRouteRV, $availType, $isCacheable)->result;
        $this->sendCORSHeaders();

        // QA ID 121210-000179. If there's a callback, it's going to be in JSON. Send the correct header for the response.
        if($callback)
        {
            header("Content-Type: text/javascript;charset=UTF-8");
            echo "$callback(" . json_encode($result) . ")";
        }
        else
        {
            $this->_renderJSON($result);
        }
    }

    /**
    * Inserts into the widget_stats table
    * @internal
    */
    public function insertWidgetStats()
    {
        $type = $this->input->post('type');
        $widget = $this->input->post('widget');
        $column = $this->input->post('column');
        $action = (object)array('w' => $widget . '', $column => 1);
        $this->model('Clickstream')->insertWidgetStats($type, $action);
    }

    /**
    * Checks whether contact is logged in
    */
    public function validateChatForm()
    {
        AbuseDetection::check($this->input->post('formToken'));
        $this->_renderJSON($this->model('Chat')->chatValidate());
    }

    /**
    * Sends the appropriate response headers for a CORS requests.
    * @param int $cacheTime The total seconds an actual response
    * for a GET/POST request should be cached for
    */
    private function sendCORSHeaders($cacheTime = 12)
    {
        if($_SERVER['REQUEST_METHOD'] === 'OPTIONS')
        {
            //cache OPTIONS requests for 24 hours
            header("Access-Control-Max-Age: " . 86400);
            header("Access-Control-Allow-Headers: RNT_REFERRER,X-Requested-With");
            header("Access-Control-Allow-Methods: GET,POST");
        }
        else if($cacheTime !== 0)
        {
            //cache GET/POST requests for the given amount of time
            header("Expires: " . gmdate('D, d M Y H:i:s', time() + $cacheTime) . "GMT");
        }
        header("Access-Control-Allow-Origin: ".\RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest'));
        header("Access-Control-Allow-Credentials: true");
    }
}
