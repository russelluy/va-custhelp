<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class SiteFeedback extends \RightNow\Libraries\Widget\Base
{
    function __construct($attrs)
    {
        parent::__construct($attrs);

        $this->setAjaxHandlers(array(
            'submit_site_feedback_ajax' => array(
                'method' => 'submitSiteFeedback',
                'clickstream' => 'site_feedback',
            ),
        ));
    }

    function getData()
    {
        $this->data['js'] = array(
            'f_tok' => \RightNow\Utils\Framework::createTokenWithExpiration(0),
            'isProfile' => false,
            'email' => '',
        );

        if($emailAddress = $this->CI->session->getProfileData('email'))
        {
            $this->data['js']['email'] = $emailAddress;
            $this->data['js']['isProfile'] = true;
        }
        else if($this->CI->session->getSessionData('previouslySeenEmail'))
        {
            $this->data['js']['email'] = $this->CI->session->getSessionData('previouslySeenEmail');
        }
    }

    /**
     * Submit site feedback. Echoes the JSON encoded result.
     * @param array|null $parameters Post parameters
     */
    function submitSiteFeedback($parameters)
    {
        \RightNow\Libraries\AbuseDetection::check();

        $incidentID = $error = null;
        $returnCode = 'error';

        if (count($parameters) && ($formToken = $parameters['f_tok']) && \RightNow\Utils\Framework::isValidSecurityToken($formToken, 0)) {
            $response = $this->CI->model('Incident')->submitFeedback(null, $parameters['rate'], null, null, $parameters['message'], $parameters['email']);
            if ((!$error = $response->error) && ($ID = $response->result->ID)) {
                $returnCode = 'ID';
                $incidentID = $ID;
            }
        }

        echo json_encode(array($returnCode => ($incidentID ?: strval($error) ?: \RightNow\Utils\Config::getMessage(ERROR_REQUEST_ACTION_COMPLETED_MSG))));
    }
}
