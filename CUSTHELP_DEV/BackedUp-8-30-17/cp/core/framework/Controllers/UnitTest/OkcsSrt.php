<?php
namespace RightNow\Controllers\UnitTest;

use RightNow\Utils;


class OkcsSrt extends \RightNow\Controllers\Base {
private $cacheData;
private $cache;
private $apiVersion;

    function __construct()
    {
        parent::__construct(true, '_phonyLogin');
        umask(0);
        require_once CPCORE . 'Controllers/UnitTest/okcs/mockservice/OkcsTestHelper.php';
    }

    public function index(){
        echo "Mock Api Url to help generate static response. Lets add Documentation later";
    }

    public function api(){
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        $queryUrl = $helper->getParameterString();
        $queryParameters = explode("/",$queryUrl);
    if ($queryParameters[2] === 'search' || $queryParameters[2] === 'keyValueCache'){
            $this->apiVersion = $queryParameters[1];
            $methodCall = str_replace("-", "_", $queryParameters[2]);
        }
        else {
            $methodCall = str_replace("-", "_", $queryParameters[1]);
        }
        self::$methodCall();
    }
    
    public function keyValueCache() {
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        $action = $_SERVER['REQUEST_METHOD'];
        $cacheData = array();
        $kmAuthToken = $_SERVER['HTTP_KMAUTHTOKEN'];
        if (!$this->validateToken($kmAuthToken)){
            $helper->html_response_code(400);
        }
        if ($action === 'POST') {
            $queryUrl = explode('/',$helper->getParameterString());
            if (count($queryUrl) >= 1){
                $helper->html_response_code(405);
            }
            $cacheKey = strtoupper(uniqid(rand(),false));
            $postData = json_decode(file_get_contents("php://input"));
            foreach ( $postData as $key => $value){
                $cacheData[$key] = $value;
            }
            $this->getMemCache()->set($cacheKey, $cacheData);
            echo $cacheKey;
        }
        else if ($action === 'PUT') {
            $queryUrl = explode('/',$helper->getParameterString());
            $cacheKey = $queryUrl[1];
            if ($cacheKey === null || $cacheKey === ''){
                $helper->html_response_code(405);
            }
            else{
                $cacheData = $this->getMemCache()->get($cacheKey);
                if ($cacheData === false){
                    $helper->html_response_code(404); 
                }
                else {
                    $cacheData = json_decode(file_get_contents("php://input"), true);
                    $this->getMemCache()->set($cacheKey, $cacheData);
                }
            }
        }
        else if ($action === 'DELETE'){
            $queryUrl = explode('/',$helper->getParameterString());
            $cacheKey = $queryUrl[1];
            if ($cacheKey === null || $cacheKey === ''){
                $helper->html_response_code(405);
            }
            else {
                $cacheData = $this->getMemCache()->get($cacheKey);
                if ($cacheData === false){
                    $helper->html_response_code(404); 
                }
                else {
                    $this->getMemCache()->expire($cacheKey);
                }
            }
        }
        else if ($action === 'GET') {
            $queryUrl = explode('/',$helper->getParameterString());
            $cacheKey = $queryUrl[1];
            if ($cacheKey === null || $cacheKey === ''){
                $helper->html_response_code(405);
            }
            else {
                $cacheData = $this->getMemCache()->get($cacheKey);
                if ($cacheData === false){
                $helper->html_response_code(404);
                }
                else {
                    echo json_encode($cacheData);
                }
            }
        }
    }
    
    public function search(){
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        $kmAuthToken = $_SERVER['HTTP_KMAUTHTOKEN'];
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $helper->html_response_code(405);
        }
        if (!$this->validateToken($kmAuthToken, 'search')){
            $helper->html_response_code(400);
        }
        $queryUrl = $helper->getParameterString();
        $queryParameters = explode("/",$queryUrl);
        if ($this->apiVersion === null){
            $methodCall = str_replace("-", "_", $queryParameters[2]);
            $this->apiVersion = 'latest';
        }
        else{
            $methodCall = str_replace("-", "_", $queryParameters[3]);
        }
        self::$methodCall();
    }
    
    public function ask_question(){
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        $question = $_GET['question'];
        $locale = $_GET['requestLocale'];
        $postData = json_decode(file_get_contents("php://input"), true);
        if(!$this->validateSearchPostData($postData) || !$this->validateLocale($locale)){
            $helper->html_response_code(400);
        }
        else{
            $requestedLocales = $postData['resultLocales'];
            if (preg_match('/^[\d]{3}$/', $question)){
                $helper->html_response_code(intval($question));
            }
            else{
                $resultData = $this->getFile(array('apiVersion' => $this->apiVersion, 'action'=>'Search', 'question' => $question, 'locale' => $requestedLocales, 'page' => 'P1'));
                header("Content-Type:application/json");
                echo fread($resultData['content'], filesize($resultData['path']));
            }
        }
    }
    
    public function page_results(){
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        $direction = $_GET['pageDirection'];
        $currentPage = intval($_GET['pageNumber']);
        $priorTransactionId = $_GET['priorTransactionId'];
        $postData = json_decode(file_get_contents("php://input"), true);
        if(!$this->validateSearchPostData($postData, true)){
            $helper->html_response_code(400);
        }
        else{
            if ($postData['session'] === ('15022487908f6-9cd8-455f-bb51-22a91c1658a7')){
                if ($currentPage === 0 && $direction === 'next'){
                    $resultData = $this->getFile(array('apiVersion' => $this->apiVersion, 'action'=>'Page', 'question' => 'Windows', 'page' => 'P2'));
                    header("Content-Type:application/json");
                    echo fread($resultData['content'], filesize($resultData['path']));
                }
                else if ($currentPage === 0 && $direction === 'previous'){
                    $resultData = $this->getFile(array('apiVersion' => $this->apiVersion, 'action'=>'Page', 'question' => 'Windows', 'page' => 'P1'));
                    header("Content-Type:application/json");
                    echo fread($resultData['content'], filesize($resultData['path']));
                }
            }
            else if ($postData['session'] === ('1502241b1255f-cedc-4a73-96c6-5400231185be')){
                if ($currentPage === 0 && $direction === 'next'){
                    $resultData = $this->getFile(array('apiVersion' => $this->apiVersion, 'action'=>'Page', 'question' => 'Test', 'page' => 'P2'));
                    header("Content-Type:application/json");
                    echo fread($resultData['content'], filesize($resultData['path']));
                }
                else if ($currentPage === 0 && $direction === 'previous'){
                    $resultData = $this->getFile(array('apiVersion' => $this->apiVersion, 'action'=>'Page', 'question' => 'Test', 'page' => 'P1'));
                    header("Content-Type:application/json");
                    echo fread($resultData['content'], filesize($resultData['path']));
                }
            }
            else {
                $helper->html_response_code(404);
            }
        }
    }
    
    private function navigate(){
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        $priorTransactionId = $_GET['priorTransactionid'];
        $facet = $_GET['facet'];
        $facetShowAll = $_GET['facetShowAll'];
        $postData = json_decode(file_get_contents("php://input"), true);
        if(!$this->validateSearchPostData($postData)){
            $helper->html_response_code(400);
        }
        else{
            //First time the facet is selected
            if ($postData['session'] === '15022487908f6-9cd8-455f-bb51-22a91c1658a7'){
                $resultData = $this->getFile(array('apiVersion' => $this->apiVersion, 'action'=>'Facet', 'facet' => $facet, 'locale' => $postData['resultLocales'], 'page' => 'P1'));
                header("Content-Type:application/json");
                echo fread($resultData['content'], filesize($resultData['path']));
            }
            //If a facet is preselected
            else {
                $activeFacet = $this->sessionToFacetMapper($postData['session']);
                if ($activeFacet !== null){
                    if ($activeFacet === $facet){
                        $resultData = $this->getFile(array('apiVersion' => $this->apiVersion, 'action'=>'Facet', 'facet' => null, 'locale' => $postData['resultLocales'], 'page' => 'P1'));
                        header("Content-Type:application/json");
                        echo fread($resultData['content'], filesize($resultData['path']));
                    }
                    else{
                        $resultData = $this->getFile(array('apiVersion' => $this->apiVersion, 'action'=>'Facet', 'facet' => $activeFacet.'-'.$facet, 'locale' => $postData['resultLocales'], 'page' => 'P1'));
                        header("Content-Type:application/json");
                        echo fread($resultData['content'], filesize($resultData['path']));
                    }
                }
                else {
                    $activeFacet = $this->sessionToFacetMapper($postData['session'], $facet);
                    $resultData = $this->getFile(array('apiVersion' => $this->apiVersion, 'action'=>'Facet', 'facet' => $activeFacet, 'locale' => $postData['resultLocales'], 'page' => 'P1'));
                    header("Content-Type:application/json");
                    echo fread($resultData['content'], filesize($resultData['path']));
                }
            }
        }
    }
    
    public function contact_deflection_question(){
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        $question = $_GET['question'];
        $locale = $_GET['locale'];
        $postData = json_decode(file_get_contents("php://input"), true);
        if(!$this->validateSearchPostData($postData)||!$this->validateLocale($locale)){
            $helper->html_response_code(400);
        }
        else{
            $requestedLocales = $postData['resultLocales'];
            if (preg_match('/^[\d]{3}$/', $question)){
                $helper->html_response_code(intval($question));
            }
            else{
                if ($question === 'Windows') {
                    $resultData = $this->getFile(array('apiVersion' => $this->apiVersion, 'action'=>'Deflection', 'question' => $question, 'locale' => $locale));
                    header("Content-Type:application/json");
                    echo fread($resultData['content'], filesize($resultData['path']));
                }
                else {
                    $helper->html_response_code(404);
                }
            }
        }
    }
    
    public function contact_deflection_response(){
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        $priorTransactionId = $_GET['priorTransactionId'];
        $deflected = $_GET['deflected'];
        $postData = json_decode(file_get_contents("php://input"), true);
        if(!$this->validateSearchPostData($postData)||!$this->validateLocale($locale)){
            $helper->html_response_code(400);
            if ($deflected === true){
                if (!array_key_exists('ccaInfo', $postData)){
                    header(' ',true,400);
                    $helper->html_response_code(400);
                }
            }
        }
        else{
            if (isset($priorTransactionId) && isset($deflected)){
                header(' ', true, 204);
                $helper->html_response_code(200);
            }
            else {
                header(' ',true,400);
                $helper->html_response_code(400);
            }
        }
    }
    
    public function highlight_answer(){
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        $keys = array_keys($_GET);
        $priorTransactionId = $_GET['priorTransactionId'];
        $answerID = $_GET['answerId'];
        $highlightInfo = $_GET['highlightInfo'];
        $trackedUrl = $_GET['trackedURL'];
        $isPDF = $_GET['isPDF'];
        $requestLocale = $_GET['requestLocale'];
        $postData = json_decode(file_get_contents("php://input"), true);
        if(!$this->validateSearchPostData($postData)||!$this->validateLocale($locale)){
            $helper->html_response_code(400);
        }
        else{
            $docID = $this->getDocID($highlightLink);
            if ($isPDF === false && $docID != null){
                $resultData = $this->getFile(array('apiVersion' => $this->apiVersion, 'action'=>'Highlight', 'question' => $question, 'locale' => $locale, 'docId' => $DocID));
                header("Content-Type:application/json");
                echo fread($resultData['content'], filesize($resultData['path']));
            }
            else {
                echo null;
            }
        }
    }
    
    public function click_thru(){
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        $priorTransactionId = $_GET['priorTransactionid'];
        $answerId = $_GET['answerId'];
        $isUnstructured = $_GET['isUnstructured'];
        $trackedUrl = $_GET['trackedUrl'];
        $requestLocale = $_GET['requestLocale'];
        $postData = json_decode(file_get_contents("php://input"), true);
        if(!$this->validateSearchPostData($postData)){
            $helper->html_response_code(400);
        }
        else{
            if(isset($priorTransactionId) && isset($answerId) && isset($isUnstructured) && isset($trackedUrl) && isset($requestLocale)){
                header(' ', true, 204);
                $helper->html_response_code(204);
            }
            else{
                header(' ', true, 400);
                $helper->html_response_code(400);
            }
        }
    }
    
    public function record_feedback(){
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        $priorTransactionId = $_GET['priorTransactionId'];
        $userRating = $_GET['userRating'];
        $userFeedback = $_GET['userFeedback'];
        $postData = json_decode(file_get_contents("php://input"), true);
        if (array_key_exists('session',$postData)){
            if (($priorTransactionId !== null && $priorTransactionId !== '') && ($userRating !== null && $userRating !== '')){
                return;
            }
        }
        $helper->html_response_code(400);
    }
    
    private function validateToken($kmAuthToken, $request = null){
        $helper = new \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper();
        if ($kmAuthToken === null||$kmAuthToken === ""){
            return false;
        }
        else {
            $authTokenFileContents = $helper->getFileContents('/integration-authorize.txt');
            $authToken =json_decode($authTokenFileContents);
            if (strpos($kmAuthToken,'siteName') && (strpos($kmAuthToken,$authToken->authenticationToken))){
                if ($request === null){
                    return true;
                }
                else if ($request === 'search'){
                    if (strpos($kmAuthToken,'interfaceId')){
                        return true;
                    }
                    else {
                        header(' ',true,500);
                        echo "Internal Server Error";
                    }
                }
            }
            return true;
        }
    }
    
    private function validateSearchPostData($postData, $checkSession = null){
        if (array_key_exists('session',$postData) && array_key_exists('transactionId',$postData) && array_key_exists('locale',$postData)){
            if (($postData['transactionId'] !== null||$postData['transactionId'] !== '') && $this->validateLocale($postData['locale'])){
                if($checkSession === true){
                    if ($postData['session'] === null){
                        return false;
                    }
                }
                return true;
            }
        }
        return false;
    }
    
    
    private function validateLocale($locale){
        $validLocales = array('en-US', 'cs-CZ', 'he-IL', 'it-IT');
        if (in_array($locale, $validLocales)||in_array(str_replace('_','-',$locale), $validLocales)){
            return true;
        }
        return false;
    }
    
    private function getFile($fileParams){
        if ($fileParams['action'] === 'Search'){
            $resultPath = CPCORE.'Controllers/UnitTest/okcs/mockservice/srt/responses/'.$fileParams['apiVersion'].'/'.$fileParams['action'].'-'.$fileParams['question'].'-'.$fileParams['locale'].'-P1.json';
            $fileContents = fopen($resultPath, "r") or die("Unable to open file!");
            $resultData = array('content' => $fileContents, 'path' => $resultPath);
            return $resultData;
        }
        else if ($fileParams['action'] === 'Page'){
            $resultPath = CPCORE.'Controllers/UnitTest/okcs/mockservice/srt/responses/'.$fileParams['apiVersion'].'/'.$fileParams['action'].'-'.$fileParams['question'].'-'.$fileParams['page'].'.json';
            $fileContents = fopen($resultPath, "r") or die("Unable to open file!");
            $resultData = array('content' => $fileContents, 'path' => $resultPath);
            return $resultData;
        }
        else if ($fileParams['action'] === 'Facet'){
            if ($fileParams['facet'] === null){
                $resultPath = CPCORE.'Controllers/UnitTest/okcs/mockservice/srt/responses/'.$fileParams['apiVersion'].'/'.'Search-Windows-'.$fileParams['locale'].'-P1.json';
            }
            else {
                $resultPath = CPCORE.'Controllers/UnitTest/okcs/mockservice/srt/responses/'.$fileParams['apiVersion'].'/'.$fileParams['action'].'-Windows-'.$fileParams['locale'].'-'.$fileParams['facet'].'-P1.json';
            }
            $fileContents = fopen($resultPath, "r") or die("Unable to open file!");
            $resultData = array('content' => $fileContents, 'path' => $resultPath);
            return $resultData;
        }
        else if ($fileParams['action'] === 'Deflection'){
            $resultPath = CPCORE.'Controllers/UnitTest/okcs/mockservice/srt/responses/'.$fileParams['apiVersion'].'/'.$fileParams['action'].'-'.$fileParams['question'].'-'.$fileParams['locale'].'.json';
            $fileContents = fopen($resultPath, "r") or die("Unable to open file!");
            $resultData = array('content' => $fileContents, 'path' => $resultPath);
            return $resultData;
        }
        else if ($fileParams['action'] === 'Highlight'){
            $resultPath = CPCORE.'Controllers/UnitTest/okcs/mockservice/srt/responses/'.$fileParams['apiVersion'].'/'.$fileParams['action'].'-'.$fileParams['question'].'-'.$fileParams['locale'].'-'.$fileParams['docId'].'.json';
            $fileContents = fopen($resultPath, "r") or die("Unable to open file!");
            $resultData = array('content' => $fileContents, 'path' => $resultPath);
            return $resultData;
        }
    }
    
    private function getDocID($trackedURL){
        $validDocIDs = array('1000001','1000004','1000007','1000021','1000036');
        foreach($validDocIDs as $docID){
            if (strpos($trackedURL, $docID))
            {
                if (!strpos($trackedURL, 'NODES') && !strpos($trackedURL, 'ATTACHMENT'))
                    return $docID;
            }
        }
        return;
    }
    
    private function validateFacets($facet){
        $validDocTypeFacets = array('DOC_TYPES.CMS-XML', 'DOC_TYPES.DOCUMENT', 'DOC_TYPES.PDF', 'DOC_TYPES.PRESENTATION', 'DOC_TYPES.TEXT');
        $validCollectionFacets = array('COLLECTIONS.OKKB-TEST', 'COLLECTIONS.OKKB-MULTIPLE_NODES', 'COLLECTIONS.OKKB-TEST_FILE_ATTACHMENTS', 'COLLECTIONS.OKKB-SOLUTIONS', 'COLLECTIONS.OKKB-NODE_ATRR');
        if (in_array($facet, $validDocTypeFacets)){
            return 'DocType';
        }
        else if (in_array($facet, $validCollectionFacets)){
            return 'Collection';
        }
        return 'Invalid';
    }
    
    private function sessionToFacetMapper($sessionId, $facet = null){
        if ($facet === null){
            switch ($sessionId) {
                case '150223825d1c6-aeda-44eb-970f-fafc5e90a277' : $facet = 'DOC_TYPES.DOCUMENT';
                                                                break;
                case '15022a2796a74-8735-46e6-a19e-571dbbfbfaca' : $facet = 'DOC_TYPES.CMS-XML';
                                                                break;
                case '1502285671370-5b7a-439d-ac26-7bb947b382bc' : $facet = 'COLLECTIONS.OKKB-TEST';
                                                                break;
                case '15022e7be5289-81ac-41b2-b335-1594558d3a1a' : $facet = 'COLLECTIONS.OKKB-SOLUTIONS';
                                                                break;
            }
        }
        else {
            switch ($sessionId) {
                case '1502236ba9543-5dfa-4ea3-ae96-1b6224c650b8' :  if ($facet === 'DOC_TYPES.DOCUMENT'){
                                                                        $facet = 'COLLECTIONS.OKKB-SOLUTIONS';
                                                                    }
                                                                    else if ($facet === 'COLLECTIONS.OKKB-SOLUTIONS'){
                                                                        $facet === 'DOC_TYPES.DOCUMENT';
                                                                    }
                                                                    break;
                case '150220e81198d-478d-465e-ad7f-cfc48eb94b3c' :  if ($facet === 'DOC_TYPES.CMS-XML'){
                                                                        $facet = 'COLLECTIONS.OKKB-TEST';
                                                                    }
                                                                    else if ($facet === 'COLLECTIONS.OKKB-TEST'){
                                                                        $facet = 'DOC_TYPES.CMS-XML';
                                                                    }
                                                                    break;
                case '15022105c0572-f0cd-4398-8c1b-38e7e14ca05a' :  if ($facet === 'DOC_TYPES.CMS-XML'){
                                                                        $facet = 'COLLECTIONS.OKKB-SOLUTIONS';
                                                                    }
                                                                    else if ($facet === 'COLLECTIONS.OKKB-SOLUTIONS'){
                                                                        $facet = 'DOC_TYPES.CMS-XML';
                                                                    }
                                                                    break;
            }
        }
        return $facet;
    }
    
    private function getRequestLocales($locales){
        $requestLocales = explode(',', $locales);
        foreach($requestLocales as $locale){
            $locale = str_replace('_','-',$locale);
            $locale = trim($locale);
        }
        return $requestLocales;
    }
    
    private function getMemCache() {
        return ($this->cache === null) ? new \RightNow\Libraries\Cache\Memcache(600) : $this->cache;
    }
}
?>