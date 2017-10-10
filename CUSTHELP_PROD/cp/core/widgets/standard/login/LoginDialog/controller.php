<?php /* Originating Release: November 2014 */


namespace RightNow\Widgets;

use RightNow\Utils\Text, 
    RightNow\Utils\Url;

class LoginDialog extends \RightNow\Libraries\Widget\Base
{
    function __construct($attrs)
    {
        parent::__construct($attrs);
    }

    function getData()
    {
        if(\RightNow\Utils\Framework::isLoggedIn())
            return false;

        if($redirectLocation = \RightNow\Utils\Url::getParameter('redirect'))
        {
            //We need to check if the redirect location is a fully qualified URL, or just a relative one
            $redirectLocation = urldecode(urldecode($redirectLocation));
            $parsedURL = parse_url($redirectLocation);

            if($parsedURL['scheme'] || (Text::beginsWith($parsedURL['path'], '/ci/') || Text::beginsWith($parsedURL['path'], '/cc/')))
            {
                $this->data['js']['redirectOverride'] = $redirectLocation;
            }
            else
            {
                $this->data['js']['redirectOverride'] = Text::beginsWith($redirectLocation, '/app/') ? $redirectLocation : "/app/$redirectLocation";
            }
        }

        $redirectPage = $this->data['js']['redirectOverride'] ?: ($this->data['attrs']['redirect_url'] ?: $_SERVER['REQUEST_URI']);

        if(\RightNow\Utils\Config::getConfig(CP_FORCE_PASSWORDS_OVER_HTTPS) && !Url::isRequestHttps())
        {
            $this->data['js']['loginLinkOverride'] = Url::addParameter(Url::getShortEufBaseUrl('sameAsRequest', '/app/' . \RightNow\Utils\Config::getConfig(CP_LOGIN_URL) . Url::sessionParameter()), 'redirect', urlencode(urlencode($redirectPage)));
        }

        if($this->data['attrs']['open_login_url'])
        {
            $this->classList->add('rn_AdditionalOpenLogin');
            if (!Text::stringContains($this->data['attrs']['open_login_url'], '/redirect/'))
            {
                $this->data['attrs']['open_login_url'] = Url::addParameter($this->data['attrs']['open_login_url'], 'redirect', urlencode(urlencode($redirectPage)));
            }
        }

        //honor: (1) attribute's value (2) config
        $this->data['attrs']['disable_password'] = $this->data['attrs']['disable_password'] ?: !\RightNow\Utils\Config::getConfig(EU_CUST_PASSWD_ENABLED);
        $this->data['username'] = \RightNow\Utils\Url::getParameter('username');
    }
}
