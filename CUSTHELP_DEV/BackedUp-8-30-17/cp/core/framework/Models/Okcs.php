<?php /* Originating Release: May 2016 */

namespace RightNow\Models;
require_once CORE_FILES . 'compatibility/Internal/OkcsSamlAuth.php';

use RightNow\Connect\v1_2 as Connect,
    RightNow\Api,
    RightNow\ActionCapture,
    RightNow\Utils\Text,
    RightNow\Utils\Framework,
    RightNow\Utils\Config,
    RightNow\Utils\Url;

/**
 * Methods for retrieving agent accounts
 */
class Okcs extends Base {
    private $cache;
    private $session = "";
    private $transactionID = 0;
    private $priorTransactionID = 0;
    private $lastViewedPage = 1;
    private $okcsApi;

    const SEARCH_CACHE_KEY = 'SEARCH_RESULT';
    const BROWSE_CACHE_KEY = 'BROWSE_RESULT';
    const LANGUAGE_PREFERENCE_CACHE_KEY = 'LANGUAGE_PREFERENCE';
    const USER_CACHE_KEY = 'OKCS_USER';
    const INVALID_CACHE_KEY = 'invalidCacheKey';
    const SEARCH_ID = 'SEARCH_ID';
    const GUEST_USER = 'GUEST';
    const CHANNEL_SCHEMA_KEY = 'CHANNEL_SCHEMA';
    const DEFAULT_CHANNEL_KEY = 'DEFAULT_CHANNEL';
    const OKCS_DOC_CACHE_KEY = 'OKCS_DOC';
    const OKCS_ADVANCED = 'okcsa-';
    const INVALID_OKCS_USER_KEY = 'INVALID_OKCS_USER_KEY';
    const ANSWER_KEY = 'ANSWER_KEY';
    const CACHE_TIME_IN_SECONDS = 600;

    function __construct() {
        parent::__construct();
        require_once CORE_FILES . 'compatibility/Internal/OkcsApi.php';
        require_once CPCORE . 'Utils/Okcs.php';
        $this->okcsApi = new \RightNow\compatibility\Internal\OkcsApi();
    }

    /**
    * Gets a limited list of articles sorted by the requested filter
    * @param array $filter Filter list to fetch Infomanager articles
    * @return array an array that contains internal articles.
    */
    public function getArticlesSortedBy(array $filter) {
        $localeCode = str_replace("-", "_", $this->getLocaleCode());
        $response = $this->okcsApi->getArticlesSortedBy($filter, $localeCode);
        if ($response->result->errors !== null) {
            $response = $response['response'];
            $results = array_slice($response->results, 0, $limit);
            return $this->getResponseObject($results, 'is_array');
        }
        else if (count($response->results) > 0) {
            foreach ($response->results as $document) {
                if(trim($document->title) === '')
                    $document->title = Config::getMessage(NO_TTLE_LBL);
                $titleUrl = "title/{$document->title}";
                if(!$document->published)
                    $titleUrl .= "/a_status/draft";
                $encryptedTitleParameter = Api::ver_ske_encrypt_fast_urlsafe($titleUrl);
                $document->encryptedTitle = Api::encode_base64_urlsafe($encryptedTitleParameter);
                $document->publishDate = $this->processIMDate($document->publishDate);
                $document->createDate = $this->processIMDate($document->createDate);
                $document->dateAdded = $this->processIMDate($document->dateAdded);
                $document->dateModified = $this->processIMDate($document->dateModified);
                $document->displayEndDate = $this->processIMDate($document->displayEndDate);
                $document->displayStartDate = $this->processIMDate($document->displayStartDate);
            }
        }
        if($filter['categoryRecordID'] !== null && $filter['productRecordID'] !== null) {
            ActionCapture::instrument(self::OKCS_ADVANCED . 'productAndCategory', 'selection', 'info', array('Channel' => $filter['contentType'], 'Category' => $filter['category'], 'CategoryRecordID' => $filter['categoryRecordID']));
        }
        else if($filter['productRecordID'] !== null) {
            ActionCapture::instrument(self::OKCS_ADVANCED . 'product', 'selection', 'info', array('Channel' => $filter['contentType'], 'Product' => $filter['category'], 'ProductRecordID' => $filter['productRecordID']));
        }
        else if($filter['categoryRecordID'] !== null) {
            ActionCapture::instrument(self::OKCS_ADVANCED . 'category', 'selection', 'info', array('Channel' => $filter['contentType'], 'Category' => $filter['category'], 'CategoryRecordID' => $filter['categoryRecordID']));
        }
        $response->hasMore = ($limit !== null && $limit >= 0 ? ($limit <= ($pageNumber + 1) * $pageSize ? 0 : $response->hasMore) : $response->hasMore);
        Framework::setCache(self::BROWSE_CACHE_KEY, $response->hasMore, true);
        return $response;
    }

    /**
    * Gets list of articles
    * @param array $appliedFilters Filter list to fetch Infomanager articles
    * @return array an array that contains internal articles.
    */
    public function getArticles(array $appliedFilters) {
        $rowCount = 0;
        $totalResults = count($this->okcsApi->getArticlesForSiteMap()->results);
        $numberPerPage = $appliedFilters['per_page'] < 0 ? 0 : $appliedFilters['per_page'];
        $pageNumber = (isset($appliedFilters['page'])) ? intval($appliedFilters['page']) : 1;
        $pageNumber = (intval($pageNumber) <= 0) ? 1 : $pageNumber;
        $articles = $this->okcsApi->getArticlesForSiteMap($pageNumber, $numberPerPage);
        $results = array();
        foreach ($articles->results as $document) {
            $link = '/app/' . \RightNow\Utils\Config::getConfig(CP_ANSWERS_DETAIL_URL) . '/a_id/' . $document->answerID;
            $url = "<a href='{$link}'>{$document->answerID}</a>";
            $result = array($url, $rowSize = null, $rowTime = null, $document->title);
            $results['data'][$rowCount++] = $result;
        }
        $results['total_pages'] = ($numberPerPage > 0) ? ceil($totalResults / $numberPerPage) : 0;
        $results['page'] = $pageNumber;
        $this->returnData['total_num'] = $rowCount;
        return $results;
    }

    /**
    * Gets a list of content types
    * @return object|null The Channel Object containg channel list
    */
    public function getChannels() {
        $response = $this->okcsApi->getChannels();
        return $response->result->errors !== null ? $this->getResponseObject($response) : $response;
    }

    /**
    * Gets details of seleted channel
    * @param string $channel Selected Channel
    * @return object|null The Channel Object containg channel details
    */
    public function getChannelDetails($channel) {
        if(is_null($channel) || empty($channel))
            return $this->getResponseObject(null, null, 'Invalid channel');
        $response = $this->okcsApi->getChannelDetails($channel);
        return $response->result->errors !== null ? $response : $this->getResponseObject($response);
    }

    /**
    * Getter method for search session
    * @return object|null Search session
    */
    public function getSession() {
        return $this->session;
    }

    /**
    * Setter method to set the search session
    * @param string $searchSession Search session
    */
    public function setSession($searchSession) {
        $this->session = $searchSession;
    }

    /**
    * Getter method for search transactionID
    * @return int Search transactionID
    */
    public function getTransactionID() {
        return $this->transactionID;
    }

    /**
    * Setter method to set the transactionID
    * @param string $transactionID Search transactionID
    */
    public function setTransactionID($transactionID) {
        $this->transactionID = $transactionID;
    }

    /**
    * Getter method for search priorTransactionID
    * @return int Search priorTransactionID
    */
    public function getPriorTransactionID() {
        return $this->priorTransactionID;
    }

    /**
    * Setter method to set the prior transactionID
    * @param string $priorTransactionID Search priorTransactionID
    */
    public function setPriorTransactionID($priorTransactionID) {
        $this->priorTransactionID = $priorTransactionID;
    }

    /**
    * Gets the content of a document in Info Manager
    * @param array $contentData Content data to fetch content details
    * @return object Info Manager Content Object
    */
    public function getIMContent(array $contentData) {
        if($contentData['searchSession'] === null) {
            return $this->getArticle($contentData['docID'], $contentData['status']);
        }

        $response = $this->okcsApi->getHighlightContent($contentData);
        if($response->errors !== null) {
            return $contentData['answerType'] !== 'HTML' ? $this->getArticle($contentData['docID'], $contentData['status']) : Config::getMessage(ERROR_REQUEST_ACTION_COMPLETED_MSG);
        }
        else if($contentData['answerType'] === 'HTML' && $response->HttpPassThrough !== null) {
            return $response->HttpPassThrough;
        }
        else if($contentData['answerType'] !== 'HTML' && $response->HttpPassThrough === null) {
            return $this->getArticle($contentData['docID'], $contentData['status']);
        }

        return json_decode($response->HttpPassThrough);
    }

    /**
    * Gets the contentSchema of a document
    * @param string $contentTypeId Record ID of contentType
    * @param string $locale Locale of contentType schema
    * @param boolean $isGuestUser True if guest user
    * @return object Content schema object 
    */
    public function getIMContentSchema($contentTypeId, $locale, $isGuestUser = false) {
        if($isGuestUser) {
            $response = $this->okcsApi->getIMContentSchema($contentTypeId, $locale, $isGuestUser);
            return array('contentSchema' => $response->contentSchema->schemaAttributes, 'metaSchema' => $response->metaDataSchema->schemaAttributes);
        }
        $schemaKey = $contentTypeId . "_" . $locale;
        $schema = $this->getMemCache()->get(self::CHANNEL_SCHEMA_KEY . '_' . $schemaKey);
        if(!$schema) {
            $response = $this->okcsApi->getIMContentSchema($contentTypeId, $locale);
            $schema = array('contentSchema' => $response->contentSchema->schemaAttributes, 'metaSchema' => $response->metaDataSchema->schemaAttributes);
            $this->getMemCache()->set(self::CHANNEL_SCHEMA_KEY . '_' . $schemaKey, $schema);
            return $schema;
        }
        return (array)$schema;
    }

    /**
    * Prepares the answer content for display
    * @param string $docID Document ID
    * @param string $highlightedLinkData Highlighted Link Url
    * @param string $answerType Type of the selected answer
    * @param string $locale Locale of the selected answer
    * @return array Details of the content
    */
    public function processIMContent($docID, $highlightedLinkData = '', $answerType = null, $locale = null) {
        $searchSession = null;
        $transactionID = 0;
        $highlightedLink = $this->decodeAndDecryptData($highlightedLinkData);
        $searchSession = $this->getUrlParameter($highlightedLink, 'searchSession');
        $transactionID = $this->getUrlParameter($highlightedLink, 'txn');
        $answerStatus = $this->getUrlParameter($highlightedLink, 'a_status');
        if(empty($answerStatus)) $answerStatus = $highlightedLinkData;
        $highlightedLink = Text::getSubstringAfter($highlightedLink, '/highlightedLink/');

        if(is_null($locale))
            $locale = $this->getLocaleCode();

        $contentData = array(
            'docID' => $docID,
            'searchSession' => $searchSession,
            'highlightedLink' => $highlightedLink,
            'transactionID' => $transactionID,
            'answerType' => $answerType,
            'locale' => $locale,
            'status' => $answerStatus
        );
        $imContent = $this->getIMContent($contentData);

        if($answerType === 'HTML') {
            Framework::setCache(self::OKCS_DOC_CACHE_KEY . '_' . $docID, $imContent, true);
            return $imContent;
        }

        $date = $imContent->published ? $this->processIMDate($imContent->publishDate) : '';
        $imContentData = array(
            'title' => $imContent->title,
            'docID' => $imContent->documentID,
            'answerID' => $imContent->answerID,
            'version' => $imContent->publishedVersion,
            'published' => $imContent->published,
            'publishedDate' => $date,
            'content' => $imContent->xml,
            'metaContent' => $imContent->metaDataXml,
            'contentType' => $imContent->contentType,
            'resourcePath' => $imContent->resourcePath,
            'locale' => $imContent->locale->recordID,
            'error' => $imContent->error
        );
        Framework::setCache(self::OKCS_DOC_CACHE_KEY . '_' . $docID, $imContentData, true);
        ActionCapture::record(self::OKCS_ADVANCED . 'answer', 'view', $imContent->answerID);
        ActionCapture::instrument(self::OKCS_ADVANCED . 'answer', 'view', 'info', array('AnswerID' => $imContent->answerID, 'Channel' => $imContent->contentType->referenceKey));
        return $imContentData;
    }

    /**
    * Method to fetch document Rating
    * @param string $docID Document ID
    * @return array Details of the document rating
    */
    public function getDocumentRating($docID) {
        if(is_null($docID) || empty($docID)){
            Api::phpoutlog("getDocumentRating - Error: DocumentID - " . $docID . " is null or empty");
            return $this->getResponseObject(null, null, 'DocumentID is null or empty');
        }
        if(Framework::isLoggedIn()) {
            $imContent = $this->getIMContent(array('docID' => $docID));
            if($imContent->error !== null) {
                Api::phpoutlog("getDocumentRating - Error: " . $imContent);
                return $imContent;
            }
            if($imContent->owner->recordID !== $this->getUserRecordID()) {
                $ratingID = $this->getChannelDetails($imContent->contentType->referenceKey)->result->results[0]->rating->recordID;
                $response = $this->okcsApi->getDocumentRating($ratingID);
                $response = array('surveyRecordID' => $response->recordID, 'questions' => $response->ratingType !== 0 ? $response->questions : null, 'contentID' => $imContent->recordID, 'locale' => $imContent->locale->recordID);
                return $this->getResponseObject($response, 'is_array');
            }
        }
        return $this->getResponseObject($response, 'is_null');
    }

    /**
    * Formats the milliseconds to date
    * @param float $date Date in millisecond
    * @return date Formatted date
    */
    public function processIMDate($date) {
        // raw value has extra 4 more digits, get only the first 10 digits of publishDate
        $date = strlen($date) > 10 ? substr($date, 0, 10) : $date;
        if (strlen($date) === 10) {
            $date = explode(' ', Framework::formatDate($date));
            $date = $date[0];
        }
        return $date;
    }

    /**
    * Gets the list of supported languages
    * @return object The language object of all the languages supported
    */
    public function getSupportedLanguages() {
        $response = $this->okcsApi->getSupportedLanguages();
        return $response->result->errors !== null ? $this->getResponseObject($response) : $response;
    }

    /**
    * Gets the preferred languages of a user
    * @return object The user locale object
    */
    public function getUserLocale() {
        $userLocale = Text::getLanguageCode();
        $user = $this->getUser();
        if (Framework::isLoggedIn()) {
            $response = $this->okcsApi->getUserLocale($user);
            if($response->errors === null)
                $userLocale = $response->defaultLocale->recordID;
        }
        return $userLocale;
    }

    /**
    * Method to call clickThrough API
    * @param array $clickThroughInput Array of input parameters to call REST API
    * @return object response object
    */
    public function clickThrough(array $clickThroughInput) {
        $trackedUrl = $clickThroughInput['trackedURL'];
        $clickThroughData = '/' . $this->decodeAndDecryptData($trackedUrl);

        $session = $this->getUrlParameter($clickThroughData, 'searchSession');
        if(Text::endsWith($session, '_SEARCH'))
            $session = Text::getSubstringBefore($session, '_SEARCH');

        $transactionID = $this->getUrlParameter($clickThroughData, 'transactionID');
        $priorTransactionID = $this->getUrlParameter($clickThroughData, 'priorTransactionID');
        $trackedUrl = Text::getSubstringAfter($clickThroughData, '/clickThrough/');
        $resultLocale = $clickThroughInput['resultLocale'];
        $localeCode = $this->getLocaleCode();
        $requestLocale = str_replace("-", "_", $this->getLocaleCode());
        $resultLocale = (strlen($resultLocale) !== 0) ? $resultLocale : $localeCode;

        $clickThroughData = array(
            'session' => $session,
            'transactionID' => $transactionID,
            'priorTransactionID' => $priorTransactionID,
            'answerID' => $clickThroughInput['answerID'],
            'docID' => $clickThroughInput['docID'],
            'isUnstructured' => $clickThroughInput['isUnstructured'],
            'localeCode' => $localeCode,
            'trackedUrl' => $trackedUrl,
            'requestLocale' => $requestLocale,
            'resultLocale' => $resultLocale
        );
        $response = $this->okcsApi->clickThrough($clickThroughData);
        return $response->result->errors !== null ? $this->getResponseObject($response) : $this->getResponseObject(true, 'is_bool');
    }

    /**
    * This method is used to store data into the okcs cache
    * @param string $key Cache key
    * @param string $value Key value
    */
    public function cacheData($key, $value) {
        $userCacheKey = $this->CI->session->getSessionData('userCacheKey');
        $isLoggedInUser = Framework::isLoggedIn();
        $keySuffix = $isLoggedInUser ? $this->getLoggedInUser() : self::GUEST_USER;
        if(!$userCacheKey || ($isLoggedInUser && !Text::endsWith($userCacheKey, '_' . $this->getLoggedInUser())) ||
            (!$isLoggedInUser && !Text::endsWith($userCacheKey, '_' . $keySuffix))){
            $cacheKey = $this->okcsApi->cacheUserData(json_encode(array($key => $value)), $action = 'POST');
            if($cacheKey === self::INVALID_CACHE_KEY)
                $this->CI->session->setSessionData(array('userCacheKey' => false));
            else
                $this->CI->session->setSessionData(array('userCacheKey' => $cacheKey . '_' . $keySuffix));
        }
        else {
            $userCacheKey = Text::getSubstringBefore($userCacheKey, '_' . $keySuffix);
            $cacheData = (array)json_decode($this->okcsApi->getCacheData($userCacheKey));
            if($key === self::SEARCH_ID && !is_null($cacheData[$key])) {
                $cacheData[$key] .= ',' . $value;
            }
            else {
                $cacheData[$key] = $value;
            }
            $cacheKey = $this->okcsApi->cacheUserData(json_encode($cacheData), $action = 'PUT', $userCacheKey);
            if($cacheKey === self::INVALID_CACHE_KEY) {
                $cacheKey = $this->okcsApi->cacheUserData(json_encode(array($key => $value)), $action = 'POST');
                if($cacheKey === self::INVALID_CACHE_KEY)
                    $this->CI->session->setSessionData(array('userCacheKey' => false));
                else
                    $this->CI->session->setSessionData(array('userCacheKey' => $cacheKey . '_' . $keySuffix));
            }
        }
    }

    /**
    * This method is used to clear cache on logout
    * @return object|null Deleted cache object
    */
    public function clearCache() {
        $keySuffix = Framework::isLoggedIn() ? $this->getLoggedInUser() : self::GUEST_USER;
        $userCacheKey = $this->CI->session->getSessionData('userCacheKey');
        $userCacheKey = Text::getSubstringBefore($userCacheKey, '_' . $keySuffix);
        $cacheData = (array)json_decode($this->okcsApi->getCacheData($userCacheKey));
        $batchData = array();
        if(!is_null($cacheData) && !empty($cacheData) && !is_null($cacheData[self::SEARCH_ID])) {
            $cacheList = explode(',', $cacheData[self::SEARCH_ID]);
            $cacheListCount = count($cacheList);
            if($cacheListCount > 0) {
                for($count = 0; $count < $cacheListCount; $count++) {
                    $data = array('id' => $count + 1, 'method' => 'DELETE', 'relativeUrl' => "keyValueCache/{$cacheList[$count]}", 'bodyClassName' => null, 'body' => null);
                    array_push($batchData, $data);
                }
            }
        }
        $data = array('id' => $count + 1, 'method' => 'DELETE', 'relativeUrl' => "keyValueCache/{$userCacheKey}", 'bodyClassName' => null, 'body' => null);
        array_push($batchData, $data);
        $postData = array('asynchronous' => false, 'requests' => $batchData);
        return $this->okcsApi->cacheUserData(json_encode($postData), $action = 'DELETE');
    }

    /**
    * This method returns cacheKey value
    * @param string $key Cache key
    * @return false|object cacheKey value
    */
    function getCacheData($key) {
        $userCacheKey = $this->CI->session->getSessionData('userCacheKey');
        $isLoggedInUser = Framework::isLoggedIn();
        $keySuffix = $isLoggedInUser ? $this->getLoggedInUser() : self::GUEST_USER;
        if(!$userCacheKey || ($isLoggedInUser && !Text::endsWith($userCacheKey, '_' . $this->getLoggedInUser())) ||
            (!$isLoggedInUser && !Text::endsWith($userCacheKey, '_' . $keySuffix)))
            return false;
        $userCacheKey = Text::getSubstringBefore($userCacheKey, '_' . $keySuffix);
        $cacheData = json_decode($this->okcsApi->getCacheData($userCacheKey));
        return $cacheData->$key;
    }

    /**
    * Gets answers for a question and then cache them.
    * @param array $filters Search filter list
    * @return array Search result
    */
    public function getSearchResult(array $filters) {
        $searchText = urlencode($filters['query']);
        $selectedLocale = $filters['locale'];
        $searchSession = $filters['session'];
        $transactionID = $filters['transactionID'];
        $facets = $filters['facets'];
        $localeCode = $this->getLocaleCode();
        $requestLocale = str_replace("-", "_", $localeCode);

        // check for SADialog widget search request
        if ($selectedLocale !== 'saDefaultLocale') {
            $requestType = 'SEARCH';
            $user = $this->getUser();
            $cachedLanguage = $this->getCacheData(self::LANGUAGE_PREFERENCE_CACHE_KEY);

            // to set user language preference in the database if user has logged in.
            if(Framework::isLoggedIn() && $cachedLanguage !== $selectedLocale)
                $this->setUserLanguagePreference($selectedLocale, true);
            $this->cacheData(self::LANGUAGE_PREFERENCE_CACHE_KEY, $selectedLocale);
        }
        else {
            $searchSession = $this->getContactSearchSession();
            $requestType = 'SMART_ASSISTANT';
            $selectedLocale = $localeCode;
        }

        $resultLocale = (strlen($selectedLocale) !== 0) ? $selectedLocale : $localeCode;
        $srcQuery = $this->getSourceQuery($_SERVER['HTTP_REFERER']);

        if($transactionID === 0 || is_null($transactionID) || empty($transactionID)) {
            $transactionID = rand(1, PHP_INT_MAX);
            $this->setTransactionID($transactionID);
        }

        $searchFilter = array(
            'searchText' => $searchText,
            'searchSession' => $searchSession,
            'transactionID' => $transactionID,
            'localeCode' => $localeCode,
            'resultLocale' => $resultLocale,
            'requestLocale' => $requestLocale,
            'querySource' => $srcQuery,
            'requestType' => $requestType,
            'facets' => $facets
        );

        $results = $this->okcsApi->getSearchResult($searchFilter);
        if ($results->errors !== null)
            return $results;

        ActionCapture::record(self::OKCS_ADVANCED . 'search', 'keywords', $searchText);
        ActionCapture::instrument(self::OKCS_ADVANCED . 'search', 'keywords', 'info', array('searchText' => $searchText, 'Facets' => $searchFilter->facets, 'RequestType' => 'AskQuestion'));
        $searchSession = $results->session;
        if ($requestType === 'SMART_ASSISTANT')
            $searchSession .= '_SMART_ASSISTANT';

        $this->setSession(Api::encode_base64_urlsafe(Api::ver_ske_encrypt_fast_urlsafe($searchSession)));
        $this->setTransactionID($results->transactionId);
        $this->setPriorTransactionID($results->priorTransactionId);
        
        $searchState = array(
            'session' => $this->getSession(),
            'transactionID' => $results->transactionId,
            'priorTransactionID' => $results->priorTransactionId
        );

        $results = $results->results;
        $page = (int)($results->results[0]->pageNumber);
        $pageMore = (int)($results->results[0]->pageMore);

        $searchData = array(
            'page' => $page,
            'pageMore' => $pageMore,
            'results' => $results,
            'facet' => $results->facets,
            'selectedLocale' => $locale
        );
        $response = array('searchState' => $searchState, 'searchResults' => $searchData);
        Framework::setCache(self::SEARCH_CACHE_KEY, $this->getResponseObject($response), true);
        return $this->getResponseObject($response, 'is_array');
    }

    /**
    * Gets answers to display answers on the new tab/window.
    * @param array $filter Filters to fetch search results
    * @return array Search result
    */
    public function getSearchResultForNewTab(array $filter) {
        $localeCode = $this->getLocaleCode();
        $requestLocale = str_replace("-", "_", $localeCode);
        $resultLocale = (strlen($selectedLocale) !== 0) ? $selectedLocale : $localeCode;

        $transactionID = rand(1, PHP_INT_MAX);
        $this->setTransactionID($transactionID);
        $sessionID = '';
        $searchSession = $this->getSearchSession($sessionID, $locale, $requestLocales, $transactionID);

        $searchFilter = array(
            'kw' => urlencode($filter['kw']),
            'facet' => $filter['facet'],
            'page' => $filter['page'],
            'loc' => $filter['loc'],
            'localeCode' => $localeCode,
            'requestLocale' => $requestLocale,
            'resultLocale' => $resultLocale,
            'searchSession' => $searchSession,
            'transactionID' => $transactionID
        );
        $results = $this->okcsApi->getSearchResultForNewTab($searchFilter);
        if ($results->errors !== null)
            return $results;

        $searchSession = $results->session . '_SEARCH';
        $this->setSession(Api::encode_base64_urlsafe(Api::ver_ske_encrypt_fast_urlsafe($searchSession)));
        $this->setTransactionID($results->transactionId);
        $this->setPriorTransactionID($results->priorTransactionId);
        
        $searchState = array(
            'session' => $this->getSession(),
            'transactionID' => $results->transactionId,
            'priorTransactionID' => $results->priorTransactionId
        );
        
        $results = $results->results;
        $page = (int)($results->results[0]->pageNumber) + 1;
        $pageMore = (int)($results->results[0]->pageMore);
        
        $searchData = array(
            'page' => $page,
            'pageMore' => $pageMore,
            'results' => $results,
            'facet' => $results->facets,
            'selectedLocale' => $locale
        );
        $response = array('searchState' => $searchState, 'searchResults' => $searchData);
        Framework::setCache(self::SEARCH_CACHE_KEY, $this->getResponseObject($response), true);
        return $this->getResponseObject($response, 'is_array');
    }

    /**
    * This method returns search session to perform search on ask question tab
    * @return string Search session
    */
    private function getContactSearchSession() {
        $results = $this->okcsApi->getContactSearchSession(str_replace("_", "-", $this->getLocaleCode()));
        return $results->results && $results->result->error ? $results : $results->session;
    }

    /**
    * This method returns search session to perform search on ask question tab
    * @param string $sessionID New generated sessionID
    * @param string $locale Locale of the selected answer
    * @param string $requestLocales Locale of the search request
    * @param string $transactionID Search transactionID
    * @return string Search session
    */
    private function getSearchSession($sessionID, $locale, $requestLocales, $transactionID) {
        $results = $this->okcsApi->getSearchSession($sessionID, $locale, $requestLocales, $transactionID);
        return $results->results && $results->result->error ? $results : $results->session;
    }

    /**
    * This method refines last performed search result based on the seleted facet.
    * @param array $searchFilter List of search filters
    * @return array Search result response
    */
    public function getAnswersForSelectedFacet(array $searchFilter) {
        if(is_null($searchFilter['facet']) || empty($searchFilter['facet']))
            return $this->getResponseObject(null, null, 'Invalid facet');
        $localeCode = str_replace("_", "-", $this->getLocaleCode());
        $resultLocale = (strlen($searchFilter['resultLocale']) !== 0) ? $searchFilter['resultLocale'] : $localeCode;
        $searchFilter['localeCode'] = $localeCode;
        $searchFilter['resultLocale'] = $resultLocale;

        $results = $this->okcsApi->getAnswersForSelectedFacet($searchFilter);
        if ($results->errors !== null)
            return $results;

        $searchSession = $results->session . '_SEARCH';
        $this->setSession(Api::encode_base64_urlsafe(Api::ver_ske_encrypt_fast_urlsafe($searchSession)));
        $this->setTransactionID($results->transactionId);
        $this->setPriorTransactionID($results->priorTransactionId);
        
        $searchState = array(
            'session' => $this->getSession(),
            'transactionID' => $results->transactionId,
            'priorTransactionID' => $results->priorTransactionId
        );

        $results = $results->results;
        $facets = $results->results->facets;
        $page = (int)($results->results[0]->pageNumber);
        $pageMore = (int)($results->results[0]->pageMore);

        $searchData = array(
            'page' => $page,
            'pageMore' => $pageMore,
            'results' => $results,
            'facet' => $facets
        );
        $response = array('searchState' => $searchState, 'searchResults' => $searchData);
        ActionCapture::record(self::OKCS_ADVANCED . 'search', 'facet', $facets);
        ActionCapture::instrument(self::OKCS_ADVANCED . 'search', 'facet', 'info', array('SearchText' => $searchFilter->searchText, 'Facets' => $facets, 'PageNo' => $searchData->page, 'RequestType' => 'AskQuestion'));
        return $this->getResponseObject($response);
    }

    /**
    * Gets answer data for a requestedPage.
    * @param array $searchFilter List of search filters
    * @return array Search result for the requested page
    */
    public function getSearchPage(array $searchFilter) {
        $searchFilter['localeCode'] = str_replace("_", "-", $this->getLocaleCode());
        $searchFilter['resultLocale'] = (strlen($searchFilter['resultLocale']) !== 0) ? $searchFilter['resultLocale'] : $localeCode;
        $searchFilter['pageDirection'] = ($searchFilter['type'] === 'forward') ? 'next' : 'previous';
        $searchFilter['querySource'] = $this->getSourceQuery($_SERVER['HTTP_REFERER']);
        $results = $this->okcsApi->getSearchPage($searchFilter);

        if ($results->errors !== null)
            return $results;

        $searchSession = $results->session . '_SEARCH';
        $this->setSession(Api::encode_base64_urlsafe(Api::ver_ske_encrypt_fast_urlsafe($searchSession)));
        $searchState = array(
            'session' => $this->getSession(),
            'transactionID' => $results->transactionId,
            'priorTransactionID' => $results->priorTransactionId
        );

        $results = $results->results;
        $page = (int)($results->results[0]->pageNumber);
        $pageMore = (int)($results->results[0]->pageMore);

        $searchData = array(
            'page' => $page,
            'pageMore' => $pageMore,
            'results' => $results,
            'facet' => $results->facets
        );
        $response = array('searchState' => $searchState, 'searchResults' => $searchData);
        ActionCapture::record(self::OKCS_ADVANCED . 'search', 'paging', $searchFilter['page']);
        ActionCapture::instrument(self::OKCS_ADVANCED . 'search', 'paging', 'info', array('SearchText' => $searchFilter->searchText, 'Facets' => $searchData->facet, 'PageNo' => $searchFilter['page'], 'RequestType' => 'AskQuestion'));
        return $this->getResponseObject($response);
    }

    /**
    * Method to get cached answers results.
    * @param array $filters Search filters
    * @return object Search result object
    */
    public function getSearchResultData(array $filters) {
        $searchResultObject = Framework::checkCache(self::SEARCH_CACHE_KEY);
        if (is_null($searchResultObject) && $filters['query'] !== null)
            $searchResultObject = $this->getSearchResult($filters);
        return $searchResultObject;
    }

    /**
    * Method to get cached Info Manager article details.
    * @param string $answerID Answer ID
    * @param string $highlightedLink Highlighted Link Url
    * @param string $answerType Type of the selected answer
    * @param string $locale Locale of InfoManager article
    * @return object|null InfoManager article object
    */
    public function getArticleDetails($answerID, $highlightedLink = '', $answerType = null, $locale = null) {
        if(is_null($locale))
            $locale = str_replace("_", "-", $this->getLocaleCode());
        if($highlightedLink === '')
            $articleDetails = Framework::checkCache(self::OKCS_DOC_CACHE_KEY . '_' . $answerID);
        if (is_null($articleDetails) && (!is_null($answerID) || (!is_null($highlightedLink) && $answerType === 'HTML'))) {
            $articleDetails = $this->processIMContent($answerID, $highlightedLink, $answerType, $locale);
        }
        else {
            ActionCapture::record(self::OKCS_ADVANCED . 'answer', 'view', $answerID);
            if(is_null($answerID))
                ActionCapture::instrument(self::OKCS_ADVANCED . 'answer', 'view', 'info', array('AnswerID' => $answerID, 'Message' => 'AnswerID is null'));
            else if(!is_null($articleDetails))
                ActionCapture::instrument(self::OKCS_ADVANCED . 'answer', 'view', 'info', array('AnswerID' => $answerID, 'Message' => 'Answer Details fetched from cache'));
            else if($answerType !== 'HTML'){
                if(!is_null($highlightedLink))
                    ActionCapture::instrument(self::OKCS_ADVANCED . 'answer', 'view', 'info', array('AnswerID' => $answerID, 'Message' => 'Highlighted link does not correspond to HTML content'));
            }
        }
        return $articleDetails;
    }

    /**
    * This Method returns decoded and decrypted data
    * @param string $answerData Answer data
    * @return string Decoded and decrypted answer data
    */
    public function decodeAndDecryptData($answerData) {
        // @codingStandardsIgnoreStart
        $decodedData = Api::decode_base64_urlsafe($answerData);
        return Api::ver_ske_decrypt($decodedData);
        // @codingStandardsIgnoreEnd
    }
    
    /**
    * This Method returns encrypted and encoded Data
    * @param string $data Data
    * @return string Encrypted and encoded Data
    */
    public function encryptAndEncodeData($data) {
        return Api::encode_base64_urlsafe(Api::ver_ske_encrypt_fast_urlsafe($data));
    }

    /**
    * Method to get cached Info Manager articles.
    * @return object|null InfoManager article object containg article list
    */
    public function getIMArticles() {
        return Framework::checkCache(self::BROWSE_CACHE_KEY);
    }

    /**
    * Method to retrieve user recordID.
    * @return object User record object
    */
    public function getUserRecordID() {
        $user = $this->CI->model('Contact')->get()->result->Login;
        $userRecordID = $this->getCacheData(self::USER_CACHE_KEY);
        if(!$userRecordID) {
            $response = $this->okcsApi->getUserRecordID($user);
            if ($response->result->errors !== null)
                return $response;
            $userRecordID = $response->recordID;
            $this->cacheData(self::USER_CACHE_KEY, $userRecordID);
        }
        return $userRecordID;
    }

    /**
    * Method to retrieve user preferences.
    * @return object User preferred languages object
    */
    public function getUserLanguagePreferences() {
        $user = $this->getUser();
        $preferredLanguages = $this->getCacheData(self::LANGUAGE_PREFERENCE_CACHE_KEY);
        if(Framework::isLoggedIn()) {
            $userRecordID = $this->getUserRecordID();
            if($userRecordID) {
                $response = $this->okcsApi->getUserLanguagePreferences($userRecordID);
                $preferredLanguages = $response->errors !== null ? $response : (count($response->results) === 0 ? null : $response->results[0]);
                $this->cacheData(self::LANGUAGE_PREFERENCE_CACHE_KEY, $preferredLanguages);
                return $preferredLanguages;
            }
            return null;
        }

        return !$preferredLanguages ? null : $preferredLanguages;
    }

    /**
    * Method to format error message
    * @param string $error Error message to be formatted
    * @return string Formatted error message
    */
    public function formatErrorMessage($error) {
        $errorMessage = $error->externalMessage;
        if ($error->errorCode)
            $errorMessage = $error->errorCode . ': ' . $errorMessage . ' - ' . $error->source;
        return $errorMessage;
    }

    /**
    * Method to get contact deflection response
    * @param int $priorTransactionID Prior transactionID
    * @param boolean $deflected If true means case was deflected otherwise question was not answered
    * @param string $session Search session
    * @return object Api response object
    */
    public function  getContactDeflectionResponse($priorTransactionID, $deflected, $session) {
        $contactDeflectionData = array(
            'localeCode' => str_replace("_", "-", $this->getLocaleCode()),
            'resultLocale' => (strlen($resultLocale) !== 0) ? $resultLocale : $localeCode,
            'transactionID' => strlen($transactionID) !== 0 ? $transactionID : $this->getTransactionID(),
            'priorTransactionID' => $priorTransactionID,
            'searchSession' => Text::getSubstringBefore($this->decodeAndDecryptData($session), '_SMART_ASSISTANT'),
            'deflected' => $deflected
        );
        $response = $this->okcsApi->getContactDeflectionResponse($contactDeflectionData);

        ActionCapture::record(self::OKCS_ADVANCED . 'incident', $deflected ? 'deflect' : 'doNotCreateState');
        ActionCapture::instrument(self::OKCS_ADVANCED . 'incident', $deflected ? 'deflect' : 'Filed', 'info');
        if(!$deflected){
            ActionCapture::record(self::OKCS_ADVANCED . 'incident', 'notDeflected');
            ActionCapture::instrument(self::OKCS_ADVANCED . 'incident', 'info', 'notDeflected');
        }
        return $response->result->errors !== null ? $this->getResponseObject($response) : $this->getResponseObject(true, 'is_bool');
    }

    /**
    * Sets the default channel
    * @param string $channel Default channel
    */
    public function setDefaultChannel($channel) {
        $_REQUEST[self::DEFAULT_CHANNEL_KEY] = $channel;
    }

    /**
    * Method to get default channel
    * @return string Default Channel
    */
    public function getDefaultChannel() {
        return $_REQUEST[self::DEFAULT_CHANNEL_KEY];
    }

    /**
    * Method to get categories corresponding to a praticular channel
    * @param string $channelReferenceKey Channel Reference Key
    * @return object Api response object
    */ 
    public function getChannelCategories($channelReferenceKey) {
        $response = $this->okcsApi->getChannelCategories($channelReferenceKey);
        return $response->result->errors !== null ? $response['response'] : $response;
    }

    /**
    * Method to get children corresponding to a perticular category
    * @param string $categoryID CategoryID
    * @return object Api response object
    */ 
    public function getChildCategories($categoryID) {
        $response = $this->okcsApi->getChildCategories($categoryID);
        return $response->result->errors !== null ? $response['response'] : $response;
    }

    /**
    * This method returns answer preview details
    * @param string $docID AnswerID
    * @return array Answer details
    */
    function getAnswerPreviewDetails($docID) {
        $imContent = $this->okcsApi->getArticle($docID, null, $isGuestUser = true);
        $date = $imContent->published ? $this->processIMDate($imContent->publishDate) : '';
        $imContentData = array(
            'title' => $imContent->title,
            'docID' => $imContent->documentID,
            'answerID' => $imContent->answerID,
            'version' => $imContent->publishedVersion,
            'published' => $imContent->published,
            'publishedDate' => $date,
            'content' => $imContent->xml,
            'metaContent' => $imContent->metaDataXml,
            'contentType' => $imContent->contentType,
            'resourcePath' => $imContent->resourcePath,
            'locale' => $imContent->locale->recordID,
            'error' => $imContent->error
        );
        ActionCapture::record(self::OKCS_ADVANCED . 'answer', 'view', $imContent->answerID);
        ActionCapture::instrument(self::OKCS_ADVANCED . 'answer', 'view', 'info', array('AnswerID' => $imContent->answerID, 'Channel' => $imContent->contentType->referenceKey));
        return $imContentData;
    }

    /**
    * This method returns answer data to display on the answer view
    * @param string $docID AnswerID
    * @param string $locale Locale of the answer
    * @param string $searchAnswerData Search answer data
    * @param string $answerData Cached meta data
    * @param boolean $isGuestUser True if guest user
    * @return array Answer details
    */
    public function getAnswerViewData($docID, $locale, $searchAnswerData, $answerData, $isGuestUser = false) {
        if (is_null($docID) && is_null($searchAnswerData)) {
            Framework::setLocationHeader("/app/error/error_id/1");
            return;
        }
        $answer = Framework::checkCache(self::ANSWER_KEY);
        if (!is_null($answer))
            return $answer;
        if(!is_null($searchAnswerData) && !empty($searchAnswerData)){
            if(Text::stringContains($searchAnswerData, '_')) {
                $answerID = Text::getSubstringBefore($searchAnswerData, '_');
                $searchCacheID = Text::getSubstringAfter($searchAnswerData, '_');
                if($searchCacheID !== self::INVALID_CACHE_KEY) {
                    $answerList = (array)json_decode($this->okcsApi->getCacheData($searchCacheID));
                    if ($answerList['user'] === $this->getUser()) {
                        foreach ($answerList as $key => $answer) {
                            if($key === $answerID) {
                                $answerData = $this->decodeAndDecryptData($answer);
                                break;
                            }
                        }
                        $parameterList = explode('/', $answerData);
                        $highlightedLink = Text::getSubstringAfter($answerData, '/highlightedLink/');
                        for($i = 0; $i < count($parameterList); $i = $i + 2) {
                            if($parameterList[$i] === 'type')
                                $answerType = $parameterList[$i + 1];
                        }
                    }
                }
            }
        }
        if (!is_null($docID) || (!is_null($highlightedLink) && $answerType === 'HTML')) {
            if($isGuestUser) {
                $imContent = $this->getAnswerPreviewDetails($docID);
            }
            else {
                $imContent = $this->getArticleDetails($docID, $answer, $answerType, $locale);
            }
            if($answerType !== 'HTML') {
                if (!is_null($imContent['content'])) {
                    $resourcePath = $imContent['resourcePath'];
                    $contentTypeSchema = $this->getIMContentSchema($imContent['contentType']->referenceKey, $imContent['locale'], $isGuestUser);
                    if (is_null($contentTypeSchema->error)) {
                        $content = $schmAttrArr = $schemaAttrList = array();
                        $okcs = new \RightNow\Utils\Okcs();
                        $contentData = $okcs->getAnswerView($imContent['content'], $contentTypeSchema['contentSchema'], "CHANNEL", $resourcePath);
                        $contentXpathCount = $contentData['xpathCount'];
                        $contentSchema = $this->getSchemaAtributes($contentTypeSchema['contentSchema'], $schmAttrArr, $schemaAttrList, $contentXpathCount, 1);
                        $sortedContedData = $this->sortContentData($contentData, $schemaAttrList);
                        array_push($content, array('content' => $sortedContedData, 'contentSchema' => $contentSchema, 'type' => 'CHANNEL'));
                        if(!is_null($imContent['metaContent']) && !empty($imContent['metaContent'])) {
                            $schmAttrArr = $schemaAttrList = array();
                            $metaData = $okcs->getAnswerView($imContent['metaContent'], $contentTypeSchema['metaSchema'], "META", $resourcePath);
                            $contentXpathCount = $metaData['xpathCount'];
                            $metaSchema = $this->getSchemaAtributes($contentTypeSchema['metaSchema'], $schmAttrArr, $schemaAttrList, $contentXpathCount, 1);
                            $metaContedData = $this->sortContentData($metaData, $schemaAttrList);
                            array_push($content, array('content' => $metaContedData, 'contentSchema' => $metaSchema, 'type' => 'META'));
                        }
                        $answer = array(
                            'title' => $imContent['title'],
                            'docType' => $answerType,
                            'docID' => $imContent['docID'],
                            'version' => $imContent['version'],
                            'published' => $imContent['published'] ? Config::getMessage(PUBLISHED_LBL) : Config::getMessage(DRAFT_LBL),
                            'publishedDate' => $imContent['publishedDate'],
                            'data' => $content
                        );
                    }
                }
            }
            else {
                $answer = array('content' => $imContent);
            }
            if (is_null($answer)) {
                Framework::setLocationHeader("/app/error/error_id/1");
                return;
            }
        }
        else if(is_null($docID) && !Text::stringContains($highlightedLink, 'priorTransactionId=')){
            $answer = array('docUrl' => !$highlightedLink ? urldecode(urldecode(Text::getSubstringAfter($answerData, '/url/'))) : $highlightedLink);
            if (is_null($answer['docUrl']) || $answer['docUrl'] === '') {
                Framework::setLocationHeader("/app/error/error_id/1");
                return;
            }
        }
        else{
                Framework::setLocationHeader("/app/error/error_id/1");
                return;
        }
        Framework::setCache(self::ANSWER_KEY, $answer, true);
        return $answer;
    }

    /**
    * This method returns array schema attributes
    * @param array $contentSchema Content Schema
    * @param array &$schmAttrArr Schema
    * @param array &$schemaAttrList Schema Attribute
    * @param array $contentXpathCount Schema Xpath count
    * @param int $depth Schema Xpath Depth
    * @return array Schema attributes
    */
    function getSchemaAtributes($contentSchema, &$schmAttrArr, &$schemaAttrList, $contentXpathCount, $depth) {
        foreach((array)$contentSchema as $contentAttr){
            array_push($schmAttrArr, $contentAttr->xpath);
            $attrXpath = str_replace('//', '', $contentAttr->xpath);
            if($schemaAttrList[$depth] === null){
                $schemaAttrList[$depth] = array();
            }
            for($i = 0; $i < $contentXpathCount[$attrXpath]; $i++){
                $i == 0 ? array_push($schemaAttrList[$depth], $attrXpath) : array_push($schemaAttrList[$depth], $attrXpath . '-' . $i);
            }
            if($contentAttr->children > 0)
                $this->getSchemaAtributes($contentAttr->children, $schmAttrArr, $schemaAttrList, $contentXpathCount, $nextIndex = $depth + 1);
        }
        return $schmAttrArr;
    }
    /**
    * This method returns content data array sorted by attributes
    * @param array $contentData Answer Content
    * @param array $schemaAttrList Schema Attribute
    * @return array Sorted Content
    */
    function sortContentData($contentData, $schemaAttrList){
        $sortedContent = array();
        $schemaPath = $schemaAttrList[1];
        $contentXpaths = array_keys($contentData);
        $xpathIndexes = array_flip($contentXpaths);
        for($i = 0; $i < count($schemaPath); $i++){
            $xpath = str_replace('//', '', $schemaPath[$i]);
            $sortedContent[$xpath] = $contentData[$xpath];
        }
        for($j = 2; $j <= count($schemaAttrList); $j++){
            $schemaPath = $schemaAttrList[$j];
            for($k = count($schemaPath); $k >= 0; $k--){
                $xpath = str_replace('//', '', $schemaPath[$k]);
                $ind = 1;
                while($contentData[$contentXpaths[$xpathIndexes[$xpath] - $ind]]['depth'] >= ($j - 1)){
                    if($contentData[$contentXpaths[$xpathIndexes[$xpath] - $ind]]['depth'] == ($j - 1)){
                        $prevLevelPath = $contentXpaths[$xpathIndexes[$xpath] - $ind];
                        $sortedContent = $this->sortContentAttribute($sortedContent, $xpath, $contentData[$xpath], array_search($prevLevelPath, array_keys($sortedContent)) + 2);
                        break;
                    }
                    $ind++;
                }                
            }
        }
        return $sortedContent;
    }
    /**
    * This method returns content data array sorted by attributes
    * @param array $contentData Content Data Array
    * @param string $xpath Schema Xpath
    * @param array $data Content Data
    * @param int $position Content Data position
    * @return array Sorted Content
    */    
    function sortContentAttribute($contentData, $xpath, $data, $position) {
        $sortedContentData = array_slice($contentData, 0, $position - 1, true) + array($xpath => $data) + array_slice($contentData, $position - 1, count($contentData), true);
        return $sortedContentData;
    }

    /**
    * Method to update article rating
    * @param array $ratingData Rating data array
    * @return object|bool True if the rating was submitted successfully or Api response object
    */
    public function submitRating($ratingData) {
        $surveyRecordID = $ratingData['surveyRecordID'];
        $answerRecordID = $ratingData['answerRecordID'];
        $contentRecordID = $ratingData['contentRecordID'];
        $localeRecordID = $ratingData['localeRecordID'];
        $ratingPercentage = $ratingData['ratingPercentage'];
        $response = $this->okcsApi->submitRating($surveyRecordID, $answerRecordID, $contentRecordID, $localeRecordID);
        ActionCapture::record(self::OKCS_ADVANCED . 'answer', 'rate', $ratingData['answerID']);
        ActionCapture::instrument(self::OKCS_ADVANCED . 'answer', 'rate', 'info', array('answerID' => $ratingData['answerID']));
        ActionCapture::record(self::OKCS_ADVANCED . 'answer', 'rated', $ratingPercentage);
        ActionCapture::instrument(self::OKCS_ADVANCED . 'answer', 'rated', 'info', array('ratingPercentage' => $ratingPercentage));
        return $response->result->errors !== null ? $this->getResponseObject($response) : $this->getResponseObject(true, 'is_bool');
    }

    /**
    * Method to update search rating
    * @param int $rating User rating
    * @param string $feedback User feedback
    * @param int $priorTransactionID Prior TransactionID
    * @param string $searchSession Search Session
    * @return object|bool True if the rating was submitted successfully or Api response object
    */
    public function submitSearchRating($rating, $feedback, $priorTransactionID, $searchSession) {
        $searchSession = $this->decodeAndDecryptData($searchSession);
        $response = $this->okcsApi->submitSearchRating($rating, $feedback, $priorTransactionID, $searchSession);
        ActionCapture::record(self::OKCS_ADVANCED . 'search', 'rated', $rating);
        ActionCapture::instrument(self::OKCS_ADVANCED . 'search', 'rated', 'info', array('Rating' => $rating));
        ActionCapture::record(self::OKCS_ADVANCED . 'searchFeedback', 'submit', $feedback);
        ActionCapture::instrument(self::OKCS_ADVANCED . 'searchFeedback', 'submit', 'info', array('feedback' => $feedback));
        return $response->result->errors !== null ? $this->getResponseObject($response) : $this->getResponseObject(true, 'is_bool');
    }

    /**
    * Gets OKCS search result for SADialog when OKCS_ENABLED is active
    * @param array &$hookData Data from the pre_retrieve_smart_assistant_answers hook having keys:
    *   array 'formData' Form fields
    *   string 'token' value of KnowledgeApiSessionToken
    *   boolean 'canEscalate' value of 'canEscalate' property of SmartAssistant
    *   array 'suggestions' OKCS search results for SmartAssistantDialog widget
    *   int 'transactionID' OKCS search transaction ID
    *   int 'priotTansactionID' OKCS search prior transaction ID
    *   string 'okcsSearchSession' OKCS search session
    * @return string|null Error message, if any
    */
    public function retrieveSmartAssistantRequest(&$hookData) {
        $formData = $hookData['formData'];
        $transactionID = $this->CI->model("Okcs")->getTransactionID();
        $priorTransactionID = $this->CI->model("Okcs")->getPriorTransactionID();

        $filters = array(
            'query' => $formData['Incident.Subject']->value,
            'locale' => 'saDefaultLocale',  // pass this value for OKCS model getSearchResult in case of SmartAssistant request
            'session' => $session,
            'transactionID' => $transactionID
        );

        if(!is_null($formData['Incident.Product']->value) && !empty($formData['Incident.Product']->value))
            $facets = 'CMS-PRODUCT.' . $this->CI->model("Okcs")->getProdCatHierarchy($formData['Incident.Product']->value);

        if(!is_null($formData['Incident.Category']->value) && !empty($formData['Incident.Category']->value))
            $facets .= ',CMS-CATEGORY_REF.' . $this->CI->model("Okcs")->getProdCatHierarchy($formData['Incident.Category']->value);

        if(!is_null($facets) && !empty($facets))
            $filters['facets'] = $facets;

        $resultObject = $this->CI->model("Okcs")->getSearchResult($filters);
        $hookData['apiInvoked'] = true;

        if (count($resultObject->errors))
            return $resultObject->errors[0]->externalMessage;

        $hookData['priorTransactionID'] = $resultObject->result['searchState']['priorTransactionID'];
        $hookData['transactionID'] = $resultObject->result['searchState']['transactionID'];
        $searchSession = $this->decodeAndDecryptData($resultObject->result['searchState']['session']);
        $searchSession = Text::getSubstringBefore($searchSession, '_SMART_ASSISTANT');
        $hookData['okcsSearchSession'] = $resultObject->result['searchState']['session'];
        $fullResults = $resultObject->result['searchResults'];
        $results = $fullResults['results']->results[0]->resultItems;

        // populate data to match the expected data structure for suggestions in SADialog
        $list = array();
        if (!empty($results)) {
            $searchStateUrlData = "/priorTransactionID/{$hookData['priorTransactionID']}/searchSession/{$searchSession}";
            $answerLinks = array();
            $numberOfResults = count($results) < Config::getConfig(SA_NL_MAX_SUGGESTIONS) ? count($results) : Config::getConfig(SA_NL_MAX_SUGGESTIONS);
            for ($i = 0; $i < $numberOfResults; $i++) {
                $hrefUrlData = '';
                $docID = '';
                $answerLocale = '';
                $answerStatus = '';
                $attachmentLink = '';
                $highlightContentFlag = false;

                $linkUrl = is_null($results[$i]->title) && is_null($results[$i]->title->url) ? $results[$i]->link : $results[$i]->title->url;

                if(Text::stringContains($results[$i]->clickThroughLink, 'turl='))
                    $linkUrl = urldecode(Text::getSubstringAfter($results[$i]->clickThroughLink, 'turl='));

                $iqAction = Text::getSubstringAfter($results[$i]->clickThroughLink, '&iq_action=');
                $iqAction = Text::getSubstringBefore($iqAction, '&');
                if (Text::stringContains($linkUrl, 'IM:') !== false) {
                    $articleData = explode(':', $linkUrl);
                    $answerLocale = $articleData[3];
                    $docID = $articleData[6];
                    $title = Text::escapeHtml($results[$i]->title->snippets[0]->text);
                    if(trim($title) === '')
                        $title = Config::getMessage(NO_TTLE_LBL);
                    $clickThrough = 'transactionID/' . ($hookData['transactionID'] + 1) . $searchStateUrlData . '/clickThrough/' . $linkUrl;
                    if(Text::stringContains($linkUrl, '#') !== false) {
                        $answerStatus = $articleData[4];
                        $answerID = strtoupper($answerStatus) === 'PUBLISHED' ? $docID : $docID . "_d";
                        $attachment = Text::getSubstringAfter($linkUrl, '#');
                        if(Text::stringContains($results[$i]->highlightedLink, '#xml=')) {
                            $attachment .= '#xml=' . Text::getSubstringAfter($results[$i]->highlightedLink, '#xml=');
                        }
                        $attachmentLink = $answerID . "/file/" . Api::encode_base64_urlsafe(Api::ver_ske_encrypt_fast_urlsafe($attachment));
                    }
                    if($results[$i]->highlightedLink) {
                        $hrefUrlData = "searchSession/{$searchSession}/txn/{$searchState['transactionID']}/highlightedLink/";
                        $highlightContentFlag = true;
                    }
                    else {
                        $answerStatus = $articleData[4];
                    }
                    $item = array('ID' => $docID, 'title' => $title, 'iqAction' => $iqAction);
                }
                else {
                    $linkText = Text::getSubstringAfter(strrchr($linkUrl, "/"), '/');
                    $title = Text::getSubstringBefore($linkText, '.');
                    $title = urldecode(empty($title) ? $linkUrl : $title);
                    $clickThrough = 'transactionID/' . ($hookData['transactionID'] + 1) . $searchStateUrlData . '/clickThrough/' . $results[$i]->clickThroughLink;
                    if($results[$i]->fileType === 'HTML' && $results[$i]->highlightedLink) {
                        $hrefUrlData = "type/{$results[$i]->fileType}/searchSession/{$searchSession}/txn/{$searchState['transactionID']}/highlightedLink/";
                        $highlightContentFlag = true;
                    }
                    else {
                        $hrefUrlData = 'url/' . $linkUrl;
                        $linkUrl = $results[$i]->highlightedLink;
                    }
                    $item = array('title' => urldecode(empty($title) ? $linkUrl : $title), 'url' => $linkUrl);
                }

                $item['docID'] = $results[$i]->docId;
                $item['answerID'] = $results[$i]->answerId;
                $item['type'] = $results[$i]->fileType;
                $item['clickThrough'] = Api::encode_base64_urlsafe(Api::ver_ske_encrypt_fast_urlsafe($clickThrough));
                $item['iqAction'] = $iqAction;

                if ($results[$i]->highlightedLink && $highlightContentFlag) {
                    $query = parse_url($results[$i]->highlightedLink, PHP_URL_QUERY);
                    parse_str($query, $params);
                    $highlightInfo = $params['highlight_info'];
                    $trackedURL = $params['turl'];
                    $highlightData = "txn/{$hookData['transactionID']}/searchSession/{$searchSession}";
                    $urlData = "priorTransactionId={$hookData['priorTransactionID']}&answerId={$params['answer_id']}&highlightInfo={$highlightInfo}&trackedURL={$trackedURL}";
                    $hrefUrlData .= $urlData;
                    $item['highlightLink'] = Api::encode_base64_urlsafe(Api::ver_ske_encrypt_fast_urlsafe($highlightData . '/highlightedLink/' . $urlData));
                }

                $hrefUrlData = (!empty($answerStatus)) ? "title/{$title}/a_status/{$answerStatus}/{$hrefUrlData}" : "title/{$title}/{$hrefUrlData}";
                if($docID !== '') {
                    $href = '/a_id/' . $docID;
                    $item['imDocID'] = $docID;
                }
                if($attachmentLink !== '') {
                    $item['docID'] = $docID;
                    $answerLinks[$docID] = $item['url'] = $item['href'] = $attachmentLink;
                }
                else {
                    if($answerLocale !== '')
                        $href .= "/loc/{$answerLocale}";
                    $item['href'] = $href . '/s/' . $results[$i]->answerId;
                    $answerLinks[$results[$i]->answerId] = Api::encode_base64_urlsafe(Api::ver_ske_encrypt_fast_urlsafe($hrefUrlData));
                }
                $href = '';
                array_push($list, $item);
            }
        }
        $answerLinks['user'] = $this->getUser();
        $cacheKey = $this->okcsApi->cacheUserData(json_encode($answerLinks), $action = 'POST');
        $isValidCacheKey = ($cacheKey !== self::INVALID_CACHE_KEY);
        if($isValidCacheKey)
            $this->CI->model('Okcs')->cacheData(self::SEARCH_ID, $cacheKey);
        if (count($list) > 0) {
            foreach ($list as &$answer) {
                if(!Text::stringContains($answer['href'], '/s/')) {
                    $answer['url'] = $answer['href'] = '/ci/okcsFattach/get/' . $answer['docID'] . '/' . ($isValidCacheKey ? $cacheKey : 'N');
                }
                else if($isValidCacheKey) {
                    $answer['href'] .= '_' . $cacheKey . '#__highlight';
                }
            }
        }
        $hookData['suggestions'] = array();
        ActionCapture::record(self::OKCS_ADVANCED . 'smartAssistant', 'resultView');
        ActionCapture::instrument(self::OKCS_ADVANCED . 'smartAssistant', 'resultView', 'info');
        array_push($hookData['suggestions'], array('type' => 'AnswerSummary', 'list' => $list));
    }

    /**
    * This method returns hierarchy of the selected product or category.
    * @param int $prodCatExternalID ExternalID of the selected product/category
    * @return string Product/Category hierarchy
    */
    public function getProdCatHierarchy($prodCatExternalID) {
        $prodCatHierarchy = array();
        do {
            $prodCatDetails = $this->okcsApi->getParentCategory($prodCatExternalID);
            array_push($prodCatHierarchy, $prodCatDetails['referenceKey']);
            $prodCatExternalID = $prodCatDetails['parentExternalID'];
        }while($prodCatDetails['parentExternalID']);

        return implode('.', array_reverse($prodCatHierarchy));
    }

    /**
    * This method returns key value from the Url.
    * Sample url format /key1/value1/key2/value2
    * @param string $url Url
    * @param string $key Url parameter key
    * @return string Url parameter value
    */
    private function getUrlParameter($url, $key) {
        if (preg_match("/\/$key\/([^\/]*)(\/|$)/", $url, $matches)) return $matches[1];
    }

    /**
    * Gets the internal article from Info Manager
    * @param string $answerID AnswerID in Info Manager
    * @param string $status Status of the article
    * @return object Info Manager Content Object
    */
    public function getArticle($answerID, $status) {
        if(!is_numeric($answerID))
            return $this->getResponseObject(null, null, 'Invalid answer Id');
        $response = $this->okcsApi->getArticle($answerID, $status);
        return $response;
    }

    /**
    * Method to set user language preferences.
    * @param string $userLanguages Selected languages
    * @param string $retryFlag To decide if we need to retry api in case of 403
    */
    private function setUserLanguagePreference($userLanguages, $retryFlag) {
        $userRecordID = $this->getUserRecordID();
        if($userRecordID !== null) {
            $preferredLanguage = $this->getUserLanguagePreferences();
            if($preferredLanguage->errors === null) {
                $response = $this->okcsApi->setUserLanguagePreference($userLanguages, $preferredLanguage, $userRecordID);
                if($response->errors && $response->errors[0]->errorCode === 'HTTP 409' && $retryFlag === true)
                   $this->setUserLanguagePreference($userLanguages, true);
            }
        }
    }

    /**
    * Method returns mem cache instance.
    * @return object Cache instance
    */
    private function getMemCache() {
        return ($this->cache === null) ? new \RightNow\Libraries\Cache\Memcache(self::CACHE_TIME_IN_SECONDS) : $this->cache;
    }

    /**
    * Method to get anonymousUser
    * @return string Anonymous User
    */
    private function getAnonymousUser() {
        $iniArray = @parse_ini_file(APPPATH . 'config/okcs.ini');
        $user = strtolower(self::GUEST_USER);
        if(!(is_bool($iniArray) && !$iniArray))
            $user = is_null($iniArray['GUEST_USER']) ? $user : $iniArray['GUEST_USER'];
        return $user;
    }

    /**
    * Method to get default locale code
    * @return string Locale code
    */
    private function getLocaleCode() {
        return Text::getLanguageCode();
    }

    /**
    * Sets the desired value for Query source parameter
    * @param string $referer Page referer
    * @return string Search source query
    */
    private function getSourceQuery($referer) {
        $srcQuery = 'quicksearch';
        if ( strpos($referer, 'home') !== false )
            $srcQuery = 'home';
        return $srcQuery;
    }

    /**
    * This method returns logged in or guest user
    * @return string Guest or logged in user id
    */
    private function getUser() {
        return Framework::isLoggedIn() ? $this->CI->model('Contact')->get()->result->Login : $this->getAnonymousUser();
    }

    /**
    * This method returns logged in or guest user
    * @return string Guest or logged in user id
    */
    private function getLoggedInUser() {
        return $this->CI->model('Contact')->get()->result->Login;
    }
}
