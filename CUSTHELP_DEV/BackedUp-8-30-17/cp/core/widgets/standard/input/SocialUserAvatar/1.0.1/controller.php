<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class SocialUserAvatar extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        if (!\RightNow\Utils\Framework::isLoggedIn()) return false;

        $services = array('gravatar');
        $this->data['js']['editingOwnAvatar'] = true;

        $socialUser = $this->CI->model('SocialUser')->get()->result;
        if (($userID = \RightNow\Utils\Url::getParameter('user')) && $userID != $socialUser->ID &&
            ($socialUserFromURL = $this->CI->model('SocialUser')->get($userID)->result) &&
            $socialUserFromURL->SocialPermissions->canUpdateAvatar()) {
                $socialUser = $socialUserFromURL;
                $this->data['js']['editingOwnAvatar'] = false;
                $services = array();
        }

        $this->data['js']['socialUser'] = $socialUser ? $socialUser->ID : null;
        $this->data['js']['defaultAvatar'] = $this->helper('Social')->getDefaultAvatar($socialUser->DisplayName);

        $contact = $this->CI->model('Contact')->getForSocialUser($socialUser->ID)->result;
        $this->data['js']['email'] = array(
            'address' => $contact->Emails[0]->Address,
            'hash' => md5($contact->Emails[0]->Address),
        );

        $this->data['currentAvatar'] = array(
            'url' => $socialUser->AvatarURL,
        );

        // default type to other
        $this->data['currentAvatar']['type'] = 'other';
        foreach ($services as $service) {
            if (\RightNow\Utils\Text::stringContainsCaseInsensitive($socialUser->AvatarURL, $service)) {
                $this->data['currentAvatar']['type'] = $service;
                break;
            }
        }
    }
}