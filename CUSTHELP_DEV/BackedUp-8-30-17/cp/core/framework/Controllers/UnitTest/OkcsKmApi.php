<?php

namespace RightNow\Controllers\UnitTest;

use \RightNow\Utils;
use \RightNow\Controllers\UnitTest\okcs\mockservice\OkcsTestHelper;
use \RightNow\Controllers\UnitTest\okcs\mockservice;
if (IS_HOSTED) {
    exit("Did we ship the unit tests?  That would be sub-optimal.");
}

class OkcsKmApi extends \RightNow\Controllers\Base {

    function __construct()
    {
        parent::__construct(true, '_phonyLogin');
        umask(0);
        require_once CPCORE . 'Controllers/UnitTest/okcs/mockservice/OkcsTestHelper.php';
        
    }

    /**
     * Default function when one is not specified. Generates help text for documentation unit tests
     */
    public function index()
    {
        echo 'Mock Api to help generate static response';
        
    }
    
    public function content()
    {
        $queryParameterArray = explode('/', OkcsTestHelper::getParameterString());
        $queryParameters = OkcsTestHelper::getQueryParameters();
        if(($queryParameterArray[2] === 'content') && ($queryParameterArray[3] === 'filter')){
            
            if(($queryParameters['sortFields'] === 'mostRecent') && $queryParameters['contentState'] === 'PUBLISHED')
            {
                OkcsTestHelper::html_response_code(200);
                header('Content-Type: application/json');
                echo OkcsTestHelper::getFileContents('/mostRecent.txt');
                return;
            }
            elseif(($queryParameters['sortFields'] === 'mostPopular:dateAdded') && $queryParameters['contentState'] === 'PUBLISHED')
            {
                OkcsTestHelper::html_response_code(200);
                header('Content-Type: application/json');
                echo OkcsTestHelper::getFileContents('/mostPopular.txt');
                return;
            }
            elseif(($queryParameters['sortFields'] === 'publishDate_DESC') && $queryParameters['contentState'] === 'PUBLISHED')
            {
                OkcsTestHelper::html_response_code(200);
                if($queryParameters['contentType_referenceKey'] != NULL){
                    $path = '/content/filter/'.$queryParameters['contentType_referenceKey'].'.txt';
                }
                else{
                    OkcsTestHelper::html_response_code(200);
                    $path = '/content/filter/No_content_type.txt';
                }
                header('Content-Type: application/json');
                echo OkcsTestHelper::getFileContents($path);
                return;
            }
            OkcsTestHelper::html_response_code(404);
        }
        elseif($queryParameterArray[2]='content' && $queryParameterArray[3]='answers'){
            if(array_key_exists(4, $queryParameterArray)){
                $path = '/content/'.$queryParameterArray[4].'.txt';
                header('Content-Type: application/json');
                echo OkcsTestHelper::getFileContents($path);
                return;
            }
            OkcsTestHelper::html_response_code(404);
        }
        
    }
    public function repositories(){
        $queryParameters = OkcsTestHelper::getQueryParameters();
        $queryParameterArray = explode('/', OkcsTestHelper::getParameterString());
        if(($queryParameterArray[2] === 'repositories') && ($queryParameterArray[3] === 'default') && ($queryParameterArray[4] === 'available-locales') && ($queryParameters['mode'])==='full'){
            header('Content-Type: application/json');
            echo OkcsTestHelper::getFileContents('/locales.txt');
            return;
        }
        
    }
    
    public function endpoint(){
        $queryParameters = OkcsTestHelper::getParameterString();
        $array = explode("/", $queryParameters);
        $methodCall = str_replace("-", "_", $array[2]);
        self::$methodCall();
    }
    
    public function content_types(){
        $queryParameters = OkcsTestHelper::getQueryParameters();
        $queryParameterArray = explode('/', OkcsTestHelper::getParameterString());
            // retrieves all the channels ex - http://mock-testing.reno.us.oracle.com/ci/unitTest/OkcsKmApi/endpoint/content-types/filter?sortFields=referenceKey
        if(($queryParameterArray[2] === 'content-types') && ($queryParameterArray[3] === 'filter') && ($queryParameters['sortFields']) === 'referenceKey'){
            $path = '/channels.txt';
            header('Content-Type: application/json');
            echo OkcsTestHelper::getFileContents($path);
            return;
        }
        elseif(($queryParameterArray[2] === 'content-types') && ($queryParameterArray[3] === 'filter') && ($queryParameters['mode']) === 'FULL' && $queryParameters['referenceKey'] !== ''){
            $path = '/content_types/refrencekeyChannel/'.$queryParameters['referenceKey'].'.txt';
            header('Content-Type: application/json');
            echo OkcsTestHelper::getFileContents($path);
            return;
        }
        elseif($queryParameterArray[2]='content_types'){
            // retrieves all the content_types for each channel http://mock-testing.reno.us.oracle.com/ci/unitTest/OkcsKmApi/endpoint/content-types/CATEGORY_TEST/categories?mode=FULL
            if(array_key_exists(3, $queryParameterArray) && ($queryParameterArray[4] === "")){
                $path = '/content_types/'.$queryParameterArray[3].'.txt';
                header('Content-Type: application/json');
                echo OkcsTestHelper::getFileContents($path);
                return;
            }
            elseif((array_key_exists(3, $queryParameterArray) && ($queryParameterArray[4] !== ""))){
                if($queryParameterArray[4] === 'categories'){
                    $path = '/content_types/categories/'.$queryParameterArray[3].'.txt';
                    header('Content-Type: application/json');
                    echo OkcsTestHelper::getFileContents($path);
                    return;
                }
                
            }
            
        }
        OkcsTestHelper::html_response_code(404);
    }
    
    public function testing(){
        $okcsImApiUrl ='http://slc01fjo.us.oracle.com:8227/km/api/';
        OkcsTestHelper::updateMockAnswerResults($okcsImApiUrl, range(1000000, 1000053));
    }
    public function categories(){
        $queryParameters = OkcsTestHelper::getQueryParameters();
        $queryParameterArray = explode('/', OkcsTestHelper::getParameterString());
        if(($queryParameterArray[2] === 'categories') && ($queryParameterArray[3] === 'filter') && ($queryParameters['mode']) === 'FULL'){
            header('Content-Type: application/json');
            echo OkcsTestHelper::getFileContents('/categories/filter.txt');
            return;
        }
        elseif(($queryParameterArray[2] === 'categories') && ($queryParameterArray[3] === 'WINDOWS') && ($queryParameterArray[4] === 'children') && ($queryParameters['mode']) === 'FULL'){
            header('Content-Type: application/json');
            echo OkcsTestHelper::getFileContents('/categories/windows.txt');
            return;
        }
        elseif(($queryParameterArray[2] === 'categories') && ($queryParameterArray[3] === 'OPERATING_SYSTEMS') && ($queryParameterArray[4] === 'children') && ($queryParameters['mode']) === 'FULL'){
            header('Content-Type: application/json');
            echo OkcsTestHelper::getFileContents('/categories/OPERATING_SYSTEMS.txt');
            return;
        }
        elseif(($queryParameterArray[2] === 'categories') && ($queryParameterArray[3] === 'COMPANIES') && ($queryParameterArray[4] === 'children') && ($queryParameters['mode']) === 'FULL'){
            header('Content-Type: application/json');
            echo OkcsTestHelper::getFileContents('/categories/COMPANIES.txt');
            return;
        }
        elseif(($queryParameterArray[2] === 'categories') && ($queryParameterArray[4] === 'children')){
            header('Content-Type: application/json');
            echo OkcsTestHelper::getFileContents('/nochildren.txt');
            return;
        }
    }

    public function auth()
    {
        echo OkcsTestHelper::getFileContents('/integration-authorize.txt');
        return;
    }
    
    public function data_forms(){
        $queryParameterArray = explode('/', OkcsTestHelper::getParameterString());
        $path = '/data_forms/'.$queryParameterArray[3].'.txt';
        header('Content-Type: application/json');
        echo OkcsTestHelper::getFileContents($path);
        return;
    }

    protected function _phonyLogin() {
        // Yes, this should do nothing.
    }
   
}