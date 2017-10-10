<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class RssIcon extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        //The RSS feed doesn't work if login is required so avoid displaying the widget
        if(\RightNow\Utils\Config::getConfig(CP_CONTACT_LOGIN_REQUIRED)){
            return false;
        }

        $this->data['feedParms'] = '';

        if ($p = \RightNow\Utils\Url::getParameter('p'))
            $this->data['feedParms'] .= "/p/$p";

        if ($c = \RightNow\Utils\Url::getParameter('c'))
            $this->data['feedParms'] .= "/c/$c";
    }
}
