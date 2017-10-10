<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class EmailAnswerLink extends \RightNow\Libraries\Widget\Base
{
    function __construct($attrs)
    {
        parent::__construct($attrs);

        $this->setAjaxHandlers(array(
            'send_email_ajax' => array(
                'method' => 'emailAnswer',
                'clickstream' => 'email_answer',
            ),
        ));
    }

    function getData()
    {
        if (($answerID = \RightNow\Utils\Url::getParameter('a_id')) === null)
            return false;

        $this->data['js'] = array(
            'answerID' => $answerID,
            'emailAnswerToken' => \RightNow\Utils\Framework::createTokenWithExpiration(146),
            'isProfile' => false,
        );

        if($profile = $this->CI->session->getProfile(true))
        {
            // @codingStandardsIgnoreStart
            $this->data['js']['senderName'] = trim((\RightNow\Utils\Config::getConfig(intl_nameorder)) ? $profile->lastName . ' ' . $profile->firstName : $profile->firstName . ' ' . $profile->lastName);
            // @codingStandardsIgnoreEnd
            $this->data['js']['senderEmail'] = $profile->email;
            $this->data['js']['isProfile'] = true;
        }
        else
        {
            $this->data['js']['senderEmail'] = $this->CI->session->getSessionData('previouslySeenEmail') ?: '';
        }
    }

    /**
     * Emails answer link via Ajax request. Echos out JSON encoded result
     * @param array|null $parameters Post parameters
     */
    static function emailAnswer($parameters)
    {
        \RightNow\Libraries\AbuseDetection::check();
        echo get_instance()->model('Answer')->emailToFriend($parameters['to'], $parameters['name'], $parameters['from'], $parameters['a_id'])->toJson();
    }
}
