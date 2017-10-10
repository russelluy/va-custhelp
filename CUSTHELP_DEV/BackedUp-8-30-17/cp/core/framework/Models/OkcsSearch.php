<? /* Originating Release: May 2016 */

namespace RightNow\Models;

use RightNow\Connect\Knowledge\v1 as KnowledgeFoundation,
    RightNow\Libraries\SearchMappers\OkcsSearchMapper,
    RightNow\Utils\Text,
    RightNow\Utils\Framework,
    RightNow\Api;

require_once CPCORE . 'Libraries/SearchMappers/OkcsSearchMapper.php';
require_once CORE_FILES . 'compatibility/Internal/OkcsApi.php';

/**
 * Methods for retrieving search
 */
class OkcsSearch extends SearchSourceBase {

    /**
     * Searches OKCSSEARCH.
     *                         -limit: int
     *                         -offset: int
     *                         -sort: int
     *                         -direction: int
     *                         -product: int id
     *                         -category: int id
     * @return SearchResults instance
     */
    public function __construct() {
        parent::__construct();
        $this->okcsApi = new \RightNow\compatibility\Internal\OkcsApi();
    }

    /**
    * Method to fetch the search results object
    * @param array $filters Filter list to fetch search results
    * @return object|null Search result
    */
    function search (array $filters = array()) {
        $contentSearchPerformed = true;
        if (strlen($filters['searchType']['value']) !== 0 && $filters['searchType']['value'] === 'newTab') {
            $searchResults = $this->performSearch($filters);
        }
        else if (strlen($filters['searchType']['value']) !== 0 && $filters['searchType']['value'] === 'clearFacet') {
            $searchResults = $this->performContentSearch($filters);
        }
        else if (strlen($filters['searchType']['value']) !== 0 && $filters['searchType']['value'] === 'FACET') {
            $searchResults = $this->performFacetSearch($filters);
        }
        // Page request if 'page' param is not null
        else if (strlen($filters['direction']['value']) !== 0 && $filters['direction']['value'] !== '0') {
            $searchResults = $this->performPageSearch($filters);
        }
        // Search request if 'query' param is not null
        else if (strlen($filters['query']['value']) !== 0){
            $searchResults = $this->performContentSearch($filters);
        }
        else {
            $contentSearchPerformed = true;
            $categories = $this->CI->model('Okcs')->getChannelCategories($filters['channelRecordID']['value'])->results;
            $searchResults = array('category' => $categories);
        }
        $filters['sessionKey'] = $this->CI->model('Okcs')->decodeAndDecryptData($searchResults->result['searchState']['session']);
        $resultMap = OkcsSearchMapper::toSearchResults($searchResults, $filters);
        if($contentSearchPerformed) {
            $resultAnswers = $resultMap->searchResults['results']->results[0]->resultItems;
            $answerLinks = array();
            if (count($resultAnswers) > 0) {
                foreach ($resultAnswers as $answer) {
                    if(Text::stringContains($answer->href, 'answer_data')) {
                        $answerLinks[$answer->answerId] = Text::getSubstringAfter($answer->href, '/answer_data/');
                        $answer->href = Text::getSubstringBefore($answer->href, '/answer_data');
                        $answer->href .= '/s/' . $answer->answerId;
                    }
                    else {
                        $answerLinks[$answer->answerId] = $answer->href;
                        $answer->href = '/ci/okcsFattach/get/' . $answer->answerId;
                    }
                }
            }
            $answerLinks['user'] = Framework::isLoggedIn() ? $this->CI->model('Contact')->get()->result->Login : 'guest';
            $cacheKey = $this->okcsApi->cacheUserData(json_encode($answerLinks), $action = 'POST');
            $isValidCacheKey = ($cacheKey !== 'invalidCacheKey');
            if($isValidCacheKey)
                $this->CI->model('Okcs')->cacheData('SEARCH_ID', $cacheKey);
            if(count($resultAnswers) > 0) {
                foreach ($resultAnswers as $answer) {
                    if(!Text::stringContains($answer->href, '/s/')) {
                        $answer->href .= '/' . ($isValidCacheKey ? $cacheKey : 'N');
                    }
                    else if($isValidCacheKey) {
                        $answer->href .= '_' . $cacheKey . '#__highlight';
                    }
                }
            }
        }
        return $this->getResponseObject($resultMap, is_string($searchResults) ? $searchResults : null);
    }

    /**
     * Searches answers for the search text to display in the new tab.
     * @param array $filters Filter values
     * @return string|array Error message or results
     */
    private function performSearch (array $filters) {
        $query = trim($filters['query']['value']);
        if(!$query)
            $query = trim($filters['kw']['value']);
        $searchFilters = array(
            'kw' => $query,
            'loc' => $filters['locale']['value'],
            'facet' => $filters['facet']['value'],
            'page' => $filters['page']['value']
        );
        try {
            $result = $this->CI->model('Okcs')->getSearchResultForNewTab($searchFilters);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return $result;
    }
    
    /**
     * Searches answers for the search text.
     * @param array $filters Filter values
     * @return string|array|null Error message or results
     */
    private function performContentSearch (array $filters) {
        if (!$query = trim($filters['query']['value'])) return null;

        if (!is_null($filters['prod']['value']) && !empty($filters['prod']['value']))
            $facets = 'CMS-PRODUCT.' . trim($filters['prod']['value']);

        if (!is_null($filters['cat']['value']) && !empty($filters['cat']['value'])) {
            $cat = 'CMS-CATEGORY_REF.' . trim($filters['cat']['value']);
            $facets = is_null($facets) ? $cat : $facets . ',' . $cat;
        }
        $searchSession = $this->CI->model('Okcs')->decodeAndDecryptData($filters['okcsSearchSession']['value']);
        if(Text::endsWith($searchSession, '_SEARCH'))
            $searchSession = Text::getSubstringBefore($searchSession, '_SEARCH');

        $filters = array(
            'query' => $query,
            'locale' => !$filters['loc']['value'] ? $filters['locale']['value'] : $filters['loc']['value'],
            'session' => $searchSession,
            'transactionID' => $filters['transactionID']['value'],
            'facets' => $facets
        );

        try {
            $result = $this->CI->model('Okcs')->getSearchResultData($filters);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return $result;
    }
    
    /**
     * Searches answers for the selected facet.
     * @param array $filters Filter values
     * @return string|array Error message or results
     */
    private function performFacetSearch (array $filters) {
        try {
            $searchSession = $this->CI->model('Okcs')->decodeAndDecryptData($filters['okcsSearchSession']['value']);
            if(Text::endsWith($searchSession, '_SEARCH'))
                $searchSession = Text::getSubstringBefore($searchSession, '_SEARCH');
            $facetFilter = array(
                'session' => $searchSession,
                'transactionID' => $filters['transactionID']['value'],
                'priorTransactionID' => $filters['priorTransactionID']['value'],
                'facet' => $filters['facet']['value'],
                'resultLocale' => $filters['loc']['value']
            );
            $result = $this->CI->model('Okcs')->getAnswersForSelectedFacet($facetFilter);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return $result;
    }
    
    /**
     * Searches answers for the requested page.
     * @param array $filters Filter values
     * @return string|array Error message or results
     */
    private function performPageSearch (array $filters) {
        try {
            $searchSession = $this->CI->model('Okcs')->decodeAndDecryptData($filters['okcsSearchSession']['value']);
            if(Text::endsWith($searchSession, '_SEARCH'))
                $searchSession = Text::getSubstringBefore($searchSession, '_SEARCH');
            $pageFilter = array(
                'session' => $searchSession,
                'priorTransactionID' => $filters['priorTransactionID']['value'],
                'page' => intval($filters['page']['value']) - 1,
                'type' => $filters['direction']['value'],
                'resultLocale' => $filters['loc']['value']
            );
            $result = $this->CI->model('Okcs')->getSearchPage($pageFilter);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return $result;
    }
    
    /**
     * For the given filter type name, returns the
     * values for the filter.
     * @param  string $filterType Filter type
     * @return array Filter values
     */
    function getFilterValuesForFilterType ($filterType) {
        $sortOption = new KnowledgeFoundation\ContentSortOptions();
        $metaData = $sortOption::getMetadata();
        if ($filterType === 'sort') {
            $result = $metaData->SortField->named_values;
        }
        else if ($filterType === 'direction') {
            $result = $metaData->SortOrder->named_values;
        }
        return $this->getResponseObject($result, 'is_array');
    }
}

