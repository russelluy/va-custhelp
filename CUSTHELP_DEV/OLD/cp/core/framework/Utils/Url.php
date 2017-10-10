<?php

namespace RightNow\Utils;

/**
 * Methods for retrieving data from the cururent URL, adding items to an existing URL, or generating new URLs.
 */
final class Url extends \RightNow\Internal\Utils\Url
{
    /**
     * This function will check the current URL and add a parameter
     * key if it does not exist. If it does exist, it will replace the
     * existing parameters value
     *
     * @param string $url The current URL to modify
     * @param string $key The parameter key to add
     * @param mixed $value The parameter value to use
     * @return string The url with the new parameter added
     */
    public static function addParameter($url, $key, $value)
    {
        $url = preg_replace("@((:?^|/)$key/)[^/]*@", "\${1}$value", $url, 1, $matched);
        if (!$matched) {
            return "$url/$key/$value";
        }
        return $url;
    }

    /**
     * This function will check the current URL and delete a parameter
     * key if it exists. If it doesn't exist, nothing will happen
     *
     * @param string $url The current URL to modify
     * @param string $key The parameter key to remove
     * @return string The url with the new parameter added
     */
    public static function deleteParameter($url, $key)
    {
        if(stripos($url, "/$key/") !== false)
            return preg_replace('@/'.preg_quote($key).'/[^#/]+@', '', $url);
        return $url;
    }

    /**
     * Returns the current URL including the Protocol, Server and Request URI
     *
     * @param bool $includeUri Whether or not to include request URI as well as hostname
     * @return string The current URL
     */
    public static function getOriginalUrl($includeUri = true) {
        $protocol = self::isRequestHttps() ? 'https' : 'http';
        return "$protocol://{$_SERVER['SERVER_NAME']}" . ($includeUri ? ORIGINAL_REQUEST_URI : '');
    }

    /**
     * Returns the index where parameters begin for the current URL
     * @return int The segment number
     */
    public static function getParameterIndex()
    {
        return get_instance()->config->item('parm_segment');
    }

    /**
     * Searches url parameters for key and returns its value
     * if it exists, null otherwise.
     *
     * This function will work only if the URL parameters are in /key/value format.
     *
     * @param string $key The url key to search for.
     * @return string|null The value associated to the key or null if not found
     */
    public static function getParameter($key)
    {
        $CI = func_num_args() > 1 ? func_get_arg(1) : get_instance(); // Allow unit
        $uriSegments = $CI->uri->uri_to_assoc($CI->config->item('parm_segment'));
        if(array_key_exists($key, $uriSegments))
            return urldecode($uriSegments[$key]);
        return null;
    }

    /**
     * Gets a string containing all of the URL parameters concatenated together.
     *
     * @return string A string containing all of the URL parameters concatenated together.
     */
    public static function getParameterString()
    {
        $CI = func_num_args() > 0 ? func_get_arg(0) : get_instance();
        $uriSegments = $CI->uri->uri_to_assoc($CI->config->item('parm_segment'));
        $toReturn = '';
        foreach ($uriSegments as $key => $value)
        {
            $toReturn .= "/$key/$value";
        }
        return $toReturn;
    }

    /**
     * Same function as getParameter except that it returns a string of the
     * key and value separated by a / to be used in a URL.
     *
     * @param string $key The url key to search for.
     * @param bool $checkPostData Whether the key should be checked in the POST data, too.
     * @return mixed The string of key and value separate by a /, null otherwise
     */
    public static function getParameterWithKey($key, $checkPostData = true)
    {
        $CI = func_num_args() > 2 ? func_get_arg(2) : get_instance(); // Allow unit
        $uriSegments = $CI->uri->uri_to_assoc($CI->config->item('parm_segment'));
        if(array_key_exists($key, $uriSegments))
            return $key . '/' . $uriSegments[$key];
        if($checkPostData && ($postData = $CI->input->post($key)) !== false)
            return $key . '/' . urlencode($postData);
        return null;
    }

    /**
     * Takes a comma separated list of URL parameter keys and builds up
     * a string of their values based on the current URL.
     *
     * @param string $parameterList Comma separated list of parameter keys
     * @param array $excludedParameters List of parameter keys that should be ignored
     * @param bool $checkPostData Whether the key should be checked in the POST data, too.
     * @return string The parameters in key1/value1/key2/value2 format
     */
    public static function getParametersFromList($parameterList, array $excludedParameters=array(), $checkPostData = true)
    {
        $CI = func_num_args() > 3 ? func_get_arg(3) : get_instance(); // Allow unit
        $parameterString = '';
        $parameterList = explode(',', str_replace(' ', '', "$parameterList"));
        for($i = 0; $i < count($parameterList); $i++)
        {
            if(!in_array($parameterList[$i], $excludedParameters))
            {
                $parameterValue = self::getParameterWithKey($parameterList[$i], $checkPostData, $CI);
                if($parameterValue !== null && $parameterValue !== $parameterList[$i] . "/")
                    $parameterString .= '/' . $parameterValue;
            }
        }
        return $parameterString;
    }

    /**
     * Returns the URL sessionParm if it is required to be in the URL
     *
     * @return string The url parameter that goes into the URL
     */
    public static function sessionParameter()
    {
        $CI = get_instance();
        if(!$CI->session || ($CI->session->canSetSessionCookies() && $CI->session->getSessionData('cookiesEnabled')) || $CI->rnow->isSpider())
        {
            return '';
        }
        return $CI->session->getSessionData('sessionString');
    }

    /**
     * Returns the SSO token to log the user into the community. This
     * function will only return the token if RightNow Social is enabled
     * and the user is logged in.
     *
     * @param string $openingCharacter The character to prepend before the URL parameter
     * @param boolean $includeKey Denotes if token key should be included. If false, the $openingCharacter will be ignored
     * @param string $redirectUrl The url to redirect to
     * @return string The SSO token or an empty string if it is not necessary to generate
     */
    public static function communitySsoToken($openingCharacter = '?', $includeKey = true, $redirectUrl = '')
    {
        $CI = get_instance();
        if(Config::getConfig(COMMUNITY_ENABLED) && Config::getConfig(COMMUNITY_BASE_URL) && $CI->session && Framework::isLoggedIn())
        {
            $ssoToken = $CI->model('Social')->generateSsoToken(false, $redirectUrl)->result;
            if($includeKey)
                return "{$openingCharacter}opentoken=$ssoToken";
            return $ssoToken;
        }
        return '';
    }

    /**
     * Return the source path for YUI source files
     *
     * @param string $module The YUI Module path to load
     * @return string The full path to the YUI source files
     */
    public static function getYUICodePath($module = '')
    {
        return YUI_SOURCE_DIR . $module;
    }

    /**
     * Returns the browser path to the core, versioned asset directory and optionally appends the relative path sent in.
     *
     * @param string $path An optional relative path to append onto the base path
     * @return string Path to core assets with optional $path appended
     */
    public static function getCoreAssetPath($path=null){
        if(IS_HOSTED) {
            return "/euf/core/" . CP_FRAMEWORK_VERSION . '.' . CP_FRAMEWORK_NANO_VERSION . "/" . ($path ?: "");
        }
        return "/euf/core/" . ($path ?: "");
    }

    /**
     * Gets all the different filters used for searching from the url and attributes
     * and writes them to the filters array
     *
     * @param array $attributes Array of attributes
     * @param array|null &$filters Array of filters which is modified during the call
     * @return void
     */
    public static function setFiltersFromAttributesAndUrl(array $attributes, &$filters) {
        $reportID = $attributes['report_id'];
        $cacheKey = 'filtersFromUrl' . $reportID;
        $cachedFilters = Framework::checkCache($cacheKey);
        // ignore caching if $filters is set or there are specific keys set in $attributes
        if($cachedFilters !== null && $filters === null && !$attributes['per_page']) {
            $filters = $cachedFilters;
            return;
        }

        //The r_id parameter optionally specifies for which report to apply the URL parameters
        $reportParam = self::getParameter('r_id');
        $addURLFilter = ($reportID == $reportParam || $reportParam == null);
        $urlFilters = array();
        $CI = func_num_args() > 2 ? func_get_arg(2) : get_instance(); /* Enable unit tests */

        //Add in the Search Type filter based on URL or Report Default
        if(($stp = self::getParameter('st')) && $addURLFilter) {
            if(!$st = $CI->model('Report')->getFilterById($reportID, $stp)->result)
                $st = array('fltr_id' => $stp); // needed for widx
        }
        else {
            $st = $CI->model('Report')->getSearchFilterTypeDefault($reportID)->result;
        }
        if($st) {
            $urlFilters['searchType'] = (object)array('filters' => (object)array(
                                                            'rnSearchType' => 'searchType',
                                                            'fltr_id' => $st['fltr_id'],
                                                            'data' => $st['fltr_id'],
                                                            'oper_id' => $st['oper_id'],
                                                            'report_id' => $reportID),
                                                      'type' => 'searchType');
            if($reportID == CP_NOV09_WIDX_DEFAULT || $reportID == CP_WIDX_REPORT_DEFAULT) {
                $urlFilters['webSearchType'] = (object)array('filters' => (object)array('rnSearchType' => 'webSearchType', 'fltr_id' => $st['fltr_id'], 'data' => $st['fltr_id'], 'report_id' => $reportID));
            }
        }

        //Add the Keyword filter based on URL or report default
        $keywordParam = self::getParameter('kw');
        $keywordParam = ($keywordParam !== null) ? $keywordParam : $CI->input->post('kw');
        $kw = null;
        if($keywordParam !== null && $keywordParam !== false && $addURLFilter) {
            $kw = trim($keywordParam);
        }
        else if($word = $CI->model('Report')->getSearchFilterTypeDefault($reportID)->result) {
            $kw = $word['default_value'] ?: '';
        }

        if($kw !== null) {
            $urlFilters['keyword'] = (object)array('filters' => (object)array(
                                                        'rnSearchType' => 'keyword',
                                                        'data' => $kw,
                                                        'report_id' => $reportID),
                                                   'type' => 'keyword');
        }

        //Add in the OrgList filter
        if(($org = self::getParameter('org')) && $addURLFilter) {
            $urlFilters['org'] = (object)array(
                'filters' => (object)array('rnSearchType' => 'org', 'report_id' => $reportID),
                'type' => 'org'
            );
            if (($tableAlias = ($CI->model('Report')->getIncidentAlias($reportID)->result ?: $CI->model('Report')->getAssetAlias($reportID)->result)) &&
                ($profile = $CI->session->getProfile(true)) && $profile->orgID > 0) {
                $orgAlias = $CI->model('Report')->getOrganizationAlias($reportID)->result;
                if($org === '2' && $orgAlias) {
                    $lvl = $profile->orgLevel ?: 1;
                    $urlFilters['org']->filters->fltr_id = "$orgAlias.lvl{$lvl}_id";
                    $urlFilters['org']->filters->oper_id = 1;
                    $urlFilters['org']->filters->val = $profile->orgID;
                }
                else if($org === '1') {
                    $urlFilters['org']->filters->fltr_id = "$tableAlias.org_id";
                    $urlFilters['org']->filters->oper_id = 1;
                    $urlFilters['org']->filters->val = $profile->orgID;
                }
                else {
                    $urlFilters['org']->filters->fltr_id = "$tableAlias.c_id";
                    $urlFilters['org']->filters->oper_id = 1;
                    $urlFilters['org']->filters->val = $profile->contactID;
                }
            }
        }

        //Add in the Sort Filter
        if(($sort = self::getParameter('sort')) && $addURLFilter) {
            $numberArray = explode(',', $sort);
            $urlFilters['sort_args']['filters'] = array(
                'col_id' => intval($numberArray[0]),
                //The sort direction must be either 1 (ascending) or 2 (descending). If we see something higher than 2, change it to a 2. Negative values are handled in cleanse code.
                'sort_direction' => min((intval($numberArray[1]) ?: 1), 2),
                'sort_order' => 1,
            );

            //Special case for external search parameters
            if(($searchTypeParameter = self::getParameter('st')) && $reportID == CP_WIDX_REPORT_DEFAULT)
                $urlFilters['sort_args']['filters']['search_type'] = $searchTypeParameter;
            if ($reportID == CP_NOV09_WIDX_DEFAULT || $reportID == CP_WIDX_REPORT_DEFAULT) {
                $urlFilters['webSearchSort'] = (object)array('filters' => (object)array(
                                                                'rnSearchType' => 'webSearchSort',
                                                                'data' => (object)array('col_id' => intval($numberArray[0])),
                                                                'report_id' => $reportID));
            }
        }

        //Add in the product and category filters
        parent::getProductOrCategoryFilter('p', $addURLFilter, $urlFilters, $reportID, $CI);
        parent::getProductOrCategoryFilter('c', $addURLFilter, $urlFilters, $reportID, $CI);

        if($attributes['filter_type'] === 'pc' || self::getParameter('pc')) {
            parent::getProductCatalogFilter($addURLFilter, $urlFilters, $reportID, $CI);
        }

        //Add in the reporting flags
        if(($page = self::getParameter('page')) && $page > 0 && $addURLFilter) {
            $urlFilters['page'] = $page;
        }

        // The work-around to check for the POST'ed keyword parameter is for our
        // basic (non-JavaScript) page set.
        // If the keyword has been POST'ed assume that the user actively made a search
        // and add the search filter.
        // Note that we are unable to determine that the search filter should be
        // added when the user is selecting a product or category. Only an interaction
        // with the BasicKeywordSearch widget will cause this filter to be set in the basic page set.
        if((($search = self::getParameter('search')) || $CI->input->post("kw") !== false) && $addURLFilter) {
            $urlFilters['search'] = $search ?: '1';
        }
        if ($attributes['per_page'] > 0) {
            $urlFilters['per_page'] = $attributes['per_page'];
        }

        //Finally, add in any custom menu filters
        $urlSegments = $CI->uri->uri_to_assoc($CI->config->item('parm_segment'));
        if ($addURLFilter) {
            foreach($urlSegments as $key => $value) {
                $value = urldecode($value);
                $key = urldecode($key);
                $filter = null;
                if(!in_array($key, array('p', 'c', 'search', 'st', 'kw', 'sort', 'page', 'org'), true))  {
                    $filter = $CI->model('Report')->getFilterByName($reportID, $key)->result;
                }
                if ($filter) {
                    $urlFilters[$key]->filters->fltr_id = $filter['fltr_id'];
                    $urlFilters[$key]->filters->oper_id = $filter['oper_id'];
                    $urlFilters[$key]->filters->report_id = $reportID;
                    $urlFilters[$key]->type = $key;
                    $urlFilters[$key]->filters->rnSearchType = 'filter';
                    $urlFilters[$key]->filters->data = explode(';', $value);
                }
            }
        }

        Framework::setCache($cacheKey, $urlFilters, true);
        if(is_array($filters) && is_array($urlFilters))
            $filters = array_merge($filters, $urlFilters);
        else
            $filters = $urlFilters;
    }

    /**
     * Returns the external login URL with the %error_code%,
     * %next_page%, and %session% variables replaced. If there is no %next_page%
     * variable in the config setting, it will be tacked onto the end of the
     * config value with query string parameters.
     *
     * @param int $errorCode The error code to use in the URL
     * @param string $nextPage The next page parameter to use in the URL
     * @return string The external login with variables replaced
     */
    public static function replaceExternalLoginVariables($errorCode, $nextPage)
    {
        if($errorCode){
            $redirectUrl = Config::getConfig(PTA_ERROR_URL) ?: Config::getConfig(PTA_EXTERNAL_LOGIN_URL);
        }
        else{
            $redirectUrl = Config::getConfig(PTA_EXTERNAL_LOGIN_URL);
        }

        if(!$redirectUrl)
            return null;

        $redirectUrl = str_ireplace('%session%', urlencode(Text::getSubstringAfter(self::sessionParameter(), "session/")), str_ireplace('%error_code%', $errorCode, $redirectUrl));

        $nextPage = urlencode($nextPage);
        if(Text::stringContainsCaseInsensitive($redirectUrl, '%next_page%')){
            $redirectUrl = str_ireplace('%next_page%', $nextPage, $redirectUrl);
        }
        else if($nextPage){
            $redirectUrl .= ((strrchr($redirectUrl, '?')) ? '&' : '?') . "p_next_page=$nextPage";
        }
        return $redirectUrl;
    }

    /**
     * Generates the version name in the lowercase monthyear format (e.g. may2012) expected by resource and documentation links.
     *
     * @param string $version The version to display (e.g. 12.2). If not specified, return current version.
     * @return string Product version
     */
    public static function getProductVersionForLinks($version = null)
    {
        return str_replace(' ', '', strtolower(\RightNow\Internal\Utils\Version::getVersionName($version ?: MOD_BUILD_VER)));
    }

    /**
     * Returns the url for the interface with /app appended
     *  e.g. http://{site}.com/app
     *
     * @param mixed $matchProtocol Indicates if the URL should match the current page, the request, or one of the protocol configs.
     * Defaults to the same value as the current page.
     * Valid values are true, false, 'sameAsRequest' and 'sameAsCurrentPage'.
     * 'sameAsRequest' should be used if including resources (e.g. CSS, images) onto the current page. This looks at the actual connection.
     * 'sameAsCurrentPage' should be used if creating a link to another page in the same security context.  This looks at the current page's protocol.
     * true will use the admin protocol config
     * false will use the enduser protocol config
     * @param string $path Appended to the base URL
     * @return string The URL for the site
     */
    public static function getShortEufAppUrl($matchProtocol = 'sameAsCurrentPage', $path = '')
    {
        if (strlen($path) > 0 && !Text::beginsWith($path, '/')) {
            $path = '/' . $path;
        }
        return self::getShortEufBaseUrl($matchProtocol, '/app' . $path);
    }

    /**
     * Function to determine if a particular page should always force SSL access
     *
     * @param string $request Relative page name (e.g. '/app/utils/login_form')
     * @return bool Whether page should force SSL access
     * @internal
     */
    public static function shouldPageForceSsl($request)
    {
        if(!Config::getConfig(CP_FORCE_PASSWORDS_OVER_HTTPS))
            return false;

        $pregFunction = function($page) use ($request) {
            return preg_match("@^(/app/)?$page(/|#|$)@", $request);
        };
        return $pregFunction(Config::getConfig(CP_LOGIN_URL))
            || $pregFunction("account/setup_password")
            || $pregFunction("account/reset_password");
    }

    /**
     * Returns the base url for the site with the calculated protocol
     *  e.g. http://{site}.com
     *
     * @param mixed $matchProtocol Indicates if the URL should match the current page, the request, or one of the protocol configs.
     * Defaults to the same value as the current page.
     * Valid values are true, false, 'sameAsRequest' and 'sameAsCurrentPage'.
     * 'sameAsRequest' should be used if including resources (e.g. CSS, images) onto the current page. This looks at the actual connection.
     * 'sameAsCurrentPage' should be used if creating a link to another page in the same security context.  This looks at the current page's protocol.
     * true will use the admin protocol config
     * false will use the enduser protocol config
     * @param string $path Appended to the base URL
     * @return string The URL for the site
     */
    public static function getShortEufBaseUrl($matchProtocol = 'sameAsCurrentPage', $path = '')
    {
        static $eufBaseAdminUrl;
        static $eufBaseEndUserUrl;

        if (strlen($path) > 0 && !Text::beginsWith($path, '/'))
        {
            $path = '/' . $path;
        }
        if(self::shouldPageForceSsl($path))
        {
            return parent::calculateEufBaseUrl('shouldBeSecure') . $path;
        }
        if ($matchProtocol === 'sameAsRequest')
        {
            return parent::calculateEufBaseUrl('sameAsRequest') . $path;
        }
        if ($matchProtocol === 'sameAsCurrentPage')
        {
            $matchProtocol = USES_ADMIN_HTTPS_SEC_RULES;
        }
        if ($matchProtocol)
        {
            if (!isset($eufBaseAdminUrl))
            {
                $eufBaseAdminUrl = parent::calculateEufBaseUrl(true);
            }
            return $eufBaseAdminUrl . $path;
        }
        if (!isset($eufBaseEndUserUrl))
        {
            $eufBaseEndUserUrl = parent::calculateEufBaseUrl(false);
        }
        return $eufBaseEndUserUrl . $path;
    }

    /**
     * Returns base URL for Syndicated Widget services
     *  e.g. http://widget.{site}.com/
     *
     * @param bool $requireCachedServer Denotes if we can fall back to using the OE_WEB server if the cached server doesn't exist
     * @param string $path URL path to append to server hostname
     * @param bool $getIP Denotes if the returned URL should be the IP of the server instead of the URL
     * @return string widget service URL
     */
    public static function getCachedContentServer($requireCachedServer = false, $path = '', $getIP = false)
    {
        $useHttps = Config::getConfig(SEC_END_USER_HTTPS);
        if($useHttps || self::isRequestHttps())
            $protocol = 'https';
        else
            $protocol = 'http';

        if($getIP)
            $widgetServer = Config::getConfig(CACHED_CONTENT_SERVER_IP);
        else
            $widgetServer = Config::getConfig(CACHED_CONTENT_SERVER);
        if(!$widgetServer || $widgetServer === '')
        {
            if($requireCachedServer)
                return false;
            $widgetServer = Config::getConfig(OE_WEB_SERVER);
        }
        return "$protocol://$widgetServer$path";
    }

    /**
     * Given a URL, strips the leading "http:" to convert the URL into a
     * network-path reference. ({@link http://tools.ietf.org/html/rfc3986#section-4.2})
     * When the browser loads this URL, it will expand the URL to use the same
     * protocol (HTTP or HTTPS) as the page loading it.  That's useful for
     * syndicated widgets because we don't know whether the hosting page will
     * be secure.  Loading insecure content into a secure page can cause a
     * browser error.
     * URLs beginning with anything other than 'http:' are returned unmodified.
     *
     * @param string $url URL to convert.
     * @return string A network-path reference if the input was an http: URL; otherwise the original input.
     */
    public static function convertInsecureUrlToNetworkPathReference($url) {
        if (!Text::beginsWithCaseInsensitive($url, 'http://'))
            return $url;
        return Text::getSubstringStartingWith($url, '//');
    }

    /**
     * Indicates if the current request was made over HTTPS.
     * @return bool Whether or not the current request was made over HTTPS
     */
    public static function isRequestHttps()
    {
        return (isset($_SERVER['HTTP_RNT_SSL']) && $_SERVER['HTTP_RNT_SSL'] === 'yes') || (!IS_HOSTED && $_SERVER['HTTPS'] === 'on');
    }

    /**
     * Returns the URL of the home page without the hostname and protocol.
     *
     * @param bool $makeAbsolute Indicates if the returned value should include the leading '/app/' part of the URL or only the page name.
     * @return string The URL of the home page without the hostname and protocol.
     */
    public static function getHomePage($makeAbsolute = true)
    {
        $defaultPage = Config::getConfig(CP_HOME_URL);
        if (!$defaultPage)
            $defaultPage = 'home';
        if (!$makeAbsolute)
            return $defaultPage;
        return "/app/$defaultPage";
    }

    /**
     * Determines if the given url is external to CP based on OE_WEB_SERVER
     *
     * @param string $url The url to check
     * @return bool True if external url, false if url is in CP
     */
    public static function isExternalUrl($url)
    {
        $host = Config::getConfig(OE_WEB_SERVER);
        return ($host !== parse_url($url, PHP_URL_HOST));
    }

    /**
     * Determines if redirection to the external URL is permitted
     *
     * @param string $url The URL to check
     * @return bool True if redirection to external URL is permitted, otherwise false
     */
    public static function isRedirectAllowedForHost($url)
    {
        if (!Text::beginsWith($url, 'http') && !Text::beginsWith($url, '//')) {
            return true;
        }

        $redirectHosts = Config::getConfig(CP_REDIRECT_HOSTS);
        if ($redirectHosts === '*') {
            return true;
        }

        if (!$redirectHosts) {
            $validHosts = array();
        }
        else {
            $validHosts = array_map('trim', explode(',', $redirectHosts));
            if (in_array('*', $validHosts)) {
                return true;
            }
        }

        $validHosts[] = $_SERVER['HTTP_HOST']; // should be the same as OE_WEB_SERVER
        if ($communityBaseUrl = trim(Config::getConfig(COMMUNITY_BASE_URL))) {
            $validHosts[] = $communityBaseUrl;
        }

        // parse_url() doesn't handle protocol relative values (ie, //domain.com = NULL)
        if (Text::beginsWith($url, '//')) {
            $url = "http:" . $url;
        }
        $host = parse_url($url, PHP_URL_HOST);
        return self::hostIsAllowed($host, $validHosts);
    }

    /**
     * Redirects the current request if the user is on http and might be logged in on https.
     * Only redirect if request is of type GET because data will get lost in the redirect otherwise
     * @return void
     */
    public static function redirectToHttpsIfNecessary() {
        $CI = get_instance();
        if($CI->session && $CI->session->isProfileFlagCookieSet() && !self::isRequestHttps() && $_SERVER['REQUEST_METHOD'] === 'GET')
            self::redirectIfPageNeedsToBeSecure();
    }

    /**
     * Redirects user to same page if user is not on https and CP_FORCE_PASSWORDS_OVER_HTTPS is enabled.
     * @return void
     */
    public static function redirectIfPageNeedsToBeSecure()
    {
        if(Config::getConfig(CP_FORCE_PASSWORDS_OVER_HTTPS) && !self::isRequestHttps())
        {
            Framework::setLocationHeader(self::deleteParameter('https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], 'session') . self::sessionParameter());
            exit;
        }
    }

    /**
     * Generic function used to redirect the user to our error page but
     * also have support for changing the URL if we're in Facebook mode
     *
     * @param int $errorCode The error code to show
     * @param bool $permanent Denotes if the page move is considered permanent which will use a 301 header code instead of a 302
     * @return void
     * @internal
     */
    public static function redirectToErrorPage($errorCode, $permanent = false)
    {
        if($permanent){
            header($_SERVER['SERVER_PROTOCOL'] . ' 301 Moved Permanently');
        }
        Framework::setLocationHeader("/app/error/error_id/$errorCode" . self::sessionParameter());
        exit;
    }
}
