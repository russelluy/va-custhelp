<?php

namespace RightNow\Controllers;
use RightNow\Utils\Framework,
    RightNow\Utils\Url;

/**
 * Endpoint to handle SSO between CP and the community
 */
final class Social extends Base
{
    const SSO_ERROR_NO_CID = 5;
    const SSO_ERROR_NO_EMAIL = 9;
    const SSO_ERROR_NO_NAME = 10;
    const SSO_ERROR_DUP_EMAIL = 11;
    const SSO_ERROR_UNKNOWN = 12;
    const SSO_ERROR_INVALID_SIG_VERSION = 13;
    const SSO_ERROR_INVALID_SIG = 14;
    const SSO_ERROR_TOKEN_USED = 15;
    const SSO_ERROR_TOKEN_EXPIRED = 16;
    const SSO_ERROR_TOKEN_IP_MISMATCH = 17;

    public function __construct()
    {
        parent::__construct();

        // Allow account creation, account recovery, and login stuff for users who aren't logged in if CP_CONTACT_LOGIN_REQUIRED is on.
        parent::_setMethodsExemptFromContactLoginRequired(array(
            'login',
            'logout',
            'ssoRedirect',
            'ssoError'
        ));

    }

    /**
     * Entry point for when a user hits a community page which requires the user
     * to be logged in, and the user isn't currently logged in.
     *
     * @param string $redirectUrl The URL that the user attempted to navigate to within the community
     */
    public function login($redirectUrl = null)
    {
        if (!$redirectUrl) {
            $this->ssoError();
        }
        //Decode URL since it can contain query string parameters which we will escape for XSS security
        $redirectUrl = htmlspecialchars_decode(urldecode($redirectUrl));
        if(Framework::isLoggedIn())
            $this->ssoRedirect(base64_encode($redirectUrl));
        $loginUrl = $this->_generateLoginUrl($redirectUrl);
        Framework::setLocationHeader($loginUrl);
        exit;
    }

    /**
     * Exit point for when a user logs out from within the community
     * @param string|null $redirectUrl URL to redirect user to after logout within the community
     */
    public function logout($redirectUrl = null)
    {
        Url::redirectToHttpsIfNecessary();

        $redirectUrl = urldecode($redirectUrl);

        if(!$redirectUrl){
            $redirectUrl = \RightNow\Utils\Config::getConfig(COMMUNITY_HOME_URL, 'RNW');
        }

        if(\RightNow\Utils\Config::getConfig(PTA_EXTERNAL_LOGOUT_SCRIPT_URL)){
            $redirectUrl = str_ireplace('%source_page%', urlencode($redirectUrl), \RightNow\Utils\Config::getConfig(PTA_EXTERNAL_LOGOUT_SCRIPT_URL));
        }

        $this->model('Contact')->doLogout('');
        Framework::setLocationHeader($redirectUrl);
        exit;
    }

    /**
     * Redirect point once a user has logged into CP and we're redirecting them
     * to the community with their account information.
     *
     * @param string $redirectUrl Community URL where the user should go after getting logged in. This value is expected to be base_64 encoded.
     */
    public function ssoRedirect($redirectUrl = null)
    {
        if (!$redirectUrl) {
            $this->ssoError();
        }
        $redirectUrl = urldecode(base64_decode($redirectUrl));
        //For security purposes, ensure that the location we're going to has the same hostname as the
        //community.
        $urlDetails = parse_url($redirectUrl);
        $communityUrl = parse_url(\RightNow\Utils\Config::getConfig(COMMUNITY_BASE_URL, 'RNW'));
        if($urlDetails['host'] !== $communityUrl['host'])
            $this->ssoError(self::SSO_ERROR_UNKNOWN);
        if(!Framework::isLoggedIn())
        {
            Framework::setLocationHeader($this->_generateLoginUrl($redirectUrl));
            exit;
        }

        $redirectUrl .= (strstr($redirectUrl, '?')) ? '&opentoken=' : '?opentoken=';
        $ssoToken = $this->model('Social')->generateSsoToken()->result;
        //SSO generation failure, need to redirect to error page
        if($ssoToken === null)
        {
            if($this->session->getProfileData('email') === '')
                $this->ssoError(self::SSO_ERROR_NO_EMAIL);
            else if($this->session->getProfileData('firstName') === '')
                $this->ssoError(self::SSO_ERROR_NO_NAME);
            else if($this->session->getProfileData('lastName') === '')
                $this->ssoError(self::SSO_ERROR_NO_NAME);
        }
        \RightNow\ActionCapture::record('community', 'login');
        Framework::setLocationHeader($redirectUrl . $ssoToken);
        exit;
    }

    /**
     * SSO login error routing function. Parses the passed in error and redirects the user or out
     * @param int $errorCode Error code number
     */
    public function ssoError($errorCode = null)
    {
        $location = '/app/error/error_id/4';
        if(in_array($errorCode, array(
            self::SSO_ERROR_NO_EMAIL,
            self::SSO_ERROR_NO_NAME,
            self::SSO_ERROR_DUP_EMAIL,
            self::SSO_ERROR_INVALID_SIG_VERSION,
            self::SSO_ERROR_INVALID_SIG,
            self::SSO_ERROR_TOKEN_USED,
            self::SSO_ERROR_TOKEN_EXPIRED,
            self::SSO_ERROR_TOKEN_IP_MISMATCH))){
            $location = "/app/error/error_id/sso$errorCode";
        }
        Framework::setLocationHeader($location);
        exit;
    }

    /**
     * Generates the CP login URL. This can either be within CP or to the
     * customers site, if they are using PTA.
     * @param string $url The redirect URL to return to after they have logged in
     * @return string The finalized redirect URL
     */
    private function _generateLoginUrl($url)
    {
        $loginUrl = Url::replaceExternalLoginVariables(0, '/ci/social/ssoRedirect/' . base64_encode($url));
        if(!$loginUrl)
        {
            $url = base64_encode($url);
            $loginUrl = Url::getShortEufBaseUrl('sameAsRequest', '/app/' . \RightNow\Utils\Config::getConfig(CP_LOGIN_URL) . '/redirect/' . urlencode("/ci/social/ssoRedirect/$url") . Url::sessionParameter());
        }
        return $loginUrl;
    }
}
