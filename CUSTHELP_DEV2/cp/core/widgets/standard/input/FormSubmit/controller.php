<?php /* Originating Release: November 2014 */

namespace RightNow\Widgets;
use RightNow\Utils\Text;

class FormSubmit extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        // f_tok is used for ensuring security between data exchanges.
        // Do not remove.
        $this->data['js'] = array(
            'f_tok' => \RightNow\Utils\Framework::createTokenWithExpiration(0, $this->data['attrs']['challenge_required']),
            'formExpiration' => (60000 * (\RightNow\Utils\Config::getConfig(SUBMIT_TOKEN_EXP) - 5)) //warn of form expiration five minutes (in milliseconds) before the token expires
        );
        if ($this->data['attrs']['challenge_required'] && $this->data['attrs']['challenge_location']) {
            $this->data['js']['challengeProvider'] = \RightNow\Libraries\AbuseDetection::getChallengeProvider();
        }
        $this->data['attrs']['add_params_to_url'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']);

        if ($redirect = \RightNow\Utils\Url::getParameter('redirect')) {
            //Check if the redirect location is a fully qualified URL, or just a relative one
            $redirectLocation = urldecode(urldecode($redirect));
            $parsedURL = parse_url($redirectLocation);

            if (!$parsedURL['scheme'] &&
                !Text::beginsWith($parsedURL['path'], '/ci/') &&
                !Text::beginsWith($parsedURL['path'], '/cc/') &&
                !Text::beginsWith($redirectLocation, '/app/')) {
                $redirectLocation = "/app/$redirectLocation";
            }
            $this->data['attrs']['on_success_url'] = $redirectLocation;
        }
    }
}
