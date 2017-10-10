<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class RecentlyViewedContent extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    protected $urlParameters = array(
        'questions' => array(
            'param' => 'qid',
            'model' => 'SocialQuestion'
        ),
        'answers' => array(
            'param' => 'a_id',
            'model' => 'Answer'
        ),
    );

    function getData() {
        if (!($this->CI->session->canSetSessionCookies() &&
            $sessionUrlParams = $this->CI->session->getSessionData('urlParameters'))) {
            //If cookies are disabled, or there's no data, there's nothing to display.
            return false;
        }

        $sessionUrlParams = $this->getArrayOfUniqueEntries(array_reverse($sessionUrlParams));

        if($urlParamToExclude = $this->findUrlParamsInPage()) {
            unset($sessionUrlParams[array_search($urlParamToExclude, $sessionUrlParams)]);
        }

        $sessionUrlParams = $this->removeUnusedUrlParams($sessionUrlParams);
        $sessionUrlParams = ($this->data['attrs']['content_count'] === 0) ? $sessionUrlParams : array_slice($sessionUrlParams, 0, $this->data['attrs']['content_count']);

        if(count($sessionUrlParams) === 0) {
            return false;
        }

        foreach($sessionUrlParams as $param) {
            if($content = $this->getContentFromID($param)) {
                $this->data['previousContent'][] = $content;
            }
        }

        if(count($this->data['previousContent']) === 0) {
            return false;
        }
    }

    /**
     * Get any url parameters on the current page associated with the types of content being compiled
     * @return array|null Parameter value that was found, or null when no associated params were found
     */
    protected function findUrlParamsInPage() {
        foreach($this->data['attrs']['content_type'] as $contentType) {
            $paramToCheck = $this->urlParameters[$contentType]['param'];
            if($urlParam = \RightNow\Utils\Url::getParameter($paramToCheck)) {
                return array($paramToCheck => $urlParam);
            }
        }
    }

    /**
    * Call into the appropriate model and get the related object
    * @param array $content Answer or SocialQuestion to retrieve. Ex: array('qid' => 20)
    * @return Object|null Answer or SocialQuestion
    */
    protected function getContentFromID(array $content) {
        $contentType = key($content);
        $contentID = $content[$contentType];

        foreach($this->urlParameters as $param) {
            if(in_array($contentType, $param)) {
                $model = $param['model'];
                break;
            }
        }

        if (!($model && $content = $this->CI->model($model)->get($contentID)->result)) {
            return null;
        }

        return $content;
    }

    /**
    * Search sessionUrlParams for any keys not lsited as a content_type to use, and remove them.
    * @param array $sessionUrlParams List of Url Parameters to check against
    * @return array Array of entries consisting of content_types
    */
    protected function removeUnusedUrlParams(array $sessionUrlParams) {
        $paramsToUse = array();

        foreach($this->data['attrs']['content_type'] as $contentType) {
            $paramsToUse[] = $this->urlParameters[$contentType]['param'];
        }

        foreach($sessionUrlParams as $param) {
            if(!in_array(key($param), $paramsToUse)) {
                unset($sessionUrlParams[array_search($param, $sessionUrlParams)]);
            }
        }

        return array_values($sessionUrlParams);
    }

    /**
     * Return a single array of unique entries for the sessionUrlParams array
     * @param array $sessionUrlParams List of Url Parameters to check against
     * @return array Array of unique entries in the $sessionUrlParams array
     */
    private function getArrayOfUniqueEntries(array $sessionUrlParams) {
        $paramList = array();

        foreach($sessionUrlParams as $param) {
            if(!in_array($param, $paramList)) {
                $paramList[] = $param;
            }
        }

        return $paramList;
    }
}