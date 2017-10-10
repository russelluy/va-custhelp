<?php

namespace RightNow\Controllers;

use RightNow\Utils\Framework,
    RightNow\ActionCapture,
    RightNow\Utils\Config;

/**
* Generic controller endpoint for standard OKCS widgets to make requests to retrieve data. Nearly all of the
* methods in this controller echo out their data in JSON so that it can be received by the calling JavaScript.
*/
final class OkcsAjaxRequest extends Base
{
    public function __construct()
    {
        parent::__construct();
        require_once CPCORE . 'Utils/Okcs.php';
    }

    /**
    * Method to fetch data through OKCS APIs
    * @internal
    */
    public function getOkcsData() {
        $filters = json_decode($this->input->post('filters'), true);
        if (strlen($this->input->post('doc_id')) !== 0) {
            $this->getIMContent();
        }
        else if (strlen($this->input->post('clickThroughLink')) !== 0) {
            $this->clickThrough();
        }
        else if($filters['channelRecordID']['value'] !== null || $filters['currentSelectedID']['value'] !== null) {
            $this->browseArticles();
        }
        else if (strlen($this->input->post('deflected')) !== 0) {
            $this->getContactDeflectionResponse();
        }
        else if (strlen($this->input->post('categoryId')) !== 0) {
            $this->getChildCategories();
        }
        else if (strlen($this->input->post('surveyRecordID')) !== 0) {
            $this->submitRating();
        }
        else if (strlen($this->input->post('rating')) !== 0) {
            $this->submitSearchRating();
        }
    }

    /**
    * Method to call clickthrough OKCS API.
    */
    private function clickThrough() {
        $clickThroughInput = array(
            'isUnstructured' => $this->input->post('type'),
            'answerID' => $this->input->post('answerID'),
            'docID' => $this->input->post('docID'),
            'trackedURL' => $this->input->post('clickThroughLink'),
            'resultLocale' => $this->input->post('locale'),
            'iqAction' => $this->input->post('iqAction')
        );
        $result = $this->model('Okcs')->clickThrough($clickThroughInput);
        echo $result;
    }

    /**
    * Method to call browseArticles OKCS API.
    */
    private function browseArticles() {
        $filters = json_decode($this->input->post('filters'), true);
        $contentType = $filters['channelRecordID']['value'];
        $currentSelectedID = $filters['currentSelectedID']['value'];
        $productRecordID = $filters['productRecordID']['value'];
        $categoryRecordID = $filters['categoryRecordID']['value'];
        $isProductSelected = $filters['isProductSelected']['value'];
        $isCategorySelected = $filters['isCategorySelected']['value'];
        $categoryFetchFlag = $isProductSelected !== null || $isCategorySelected !== null ? false : true;
        $browsePage = $filters['browsePage']['value'] !== null ? $filters['browsePage']['value'] : 0;
        $pageSize = $filters['pageSize']['value'] !== null ? $filters['pageSize']['value'] : 10;
        $limit = $filters['limit']['value'];
        $columnID = $filters['sortColumn']['value'] !== null ? $filters['sortColumn']['value'] : "publishDate";
        $sortDirection = $filters['sortDirection']['value'] !== null ? $filters['sortDirection']['value'] : "DESC";

        if($productRecordID === null)
            $isProductSelected = null;

        if($categoryRecordID === null)
            $isCategorySelected = null;

        $isSelected = $currentSelectedID === $productRecordID ? $isProductSelected : $isCategorySelected;

        if($isProductSelected)
            $category = $productRecordID;

        if ($isCategorySelected) {
            if($category !== null) {
                $category .= ':' . $categoryRecordID;
            }
            else {
                $category = $categoryRecordID;
            }
        }

        $filter = array(
            'type'             => '',
            'limit'            => $limit,
            'contentType'      => $contentType,
            'category'         => $category,
            'pageNumber'       => $browsePage,
            'pageSize'         => $pageSize,
            'sortColumnId'     => $columnID,
            'sortDirection'    => $sortDirection,
            'categoryRecordID' => $categoryRecordID,
            'productRecordID'  => $productRecordID
        );
        $articleResult = $this->model('Okcs')->getArticlesSortedBy($filter);
        $response = array(
            'error'           => ($articleResult->errors) ? $articleResult->error->errorCode . ': ' .
                                 $articleResult->error->externalMessage : null,
            'articles'        => $articleResult->results,
            'filters'         => '',
            'columnID'        => $columnID,
            'sortDirection'   => $sortDirection,
            'selectedChannel' => $contentType,
            'hasMore'         => $articleResult->hasMore,
            'currentPage'     => $browsePage
        );

        if (strlen($category) === 0 && strlen($currentSelectedID) === 0 && $categoryFetchFlag){
            $categoryResult = $this->model('Okcs')->getChannelCategories($contentType);
            $response["category"] = $categoryResult->results;
        }
        else {
            $response["categoryRecordID"] = $currentSelectedID;
        }
            
        if($isSelected)
            $response["isCategorySelected"] = $isSelected;

        echo json_encode($response);
    }

    /**
    * Method to fetch details of an OKCS IM content
    */
    private function getIMContent() {
        $docID = $this->input->post('doc_id');
        $highlightedLink = $this->input->post('highlightedLink');
        $answerType = $this->input->post('answerType');

        //If highlighting is enabled
        if(strlen($highlightedLink) !== 0) {
            $response = $this->model('Okcs')->processIMContent($docID, $highlightedLink, $answerType);
        }
        else {
            $response = $this->model('Okcs')->processIMContent($docID);
        }

        if ($answerType !== 'HTML' && $response['content'] !== null) {
            $contentTypeSchema = $this->model('Okcs')->getIMContentSchema($response['contentType']->referenceKey, $response['locale']);
            if ($contentTypeSchema->error === null) {
                $okcs = new \RightNow\Utils\Okcs();
                $channelData = $okcs->getAnswerView($response['content'], $contentTypeSchema['contentSchema'], "CHANNEL", $response['resourcePath']);
                $response['content'] = $channelData;
                if($contentTypeSchema['metaSchema'] !== null) {
                    $metaData = $okcs->getAnswerView($response['metaContent'], $contentTypeSchema['metaSchema'], "META", $response['resourcePath']);
                    $response['metaContent'] = $metaData;
                }
            }
            else {
                return false;
            }
        }
        echo json_encode(array(
            'error' => ($response->errors) ? (string) $response->error : null,
            'id' => $docID,
            'contents' => $response
        ));
    }

    /**
    * Method to call getContactDeflectionResponse OKCS API.
    */
    private function getContactDeflectionResponse() {
        $priorTransactionID = $this->input->post('priorTransactionID');
        $deflected = $this->input->post('deflected');
        $session = $this->input->post('okcsSearchSession');
        $response = $this->model('Okcs')->getContactDeflectionResponse($priorTransactionID, $deflected, $session);
        echo json_encode($response); 
    }
    
    /**
    * Method to call getChildCategories OKCS API to pull children of a parent category.
    */
    private function getChildCategories() {
        $categoryID = $this->input->post('categoryId');
        $response = $this->model('Okcs')->getChildCategories($categoryID);
        if($response->results !== null)
            echo json_encode($response->results);
        else
            echo json_encode(array('error' => $response->error));
    }
    
    /**
    * Method to submit Info Manager document rating.
    */
    private function submitRating() {
        $ratingData = array(
            'answerID' => $this->input->post('answerID'),
            'surveyRecordID' => $this->input->post('surveyRecordID'),
            'answerRecordID' => $this->input->post('answerRecordID'),
            'contentRecordID' => $this->input->post('contentRecordID'),
            'localeRecordID' => $this->input->post('localeRecordID'),
            'ratingPercentage' => $this->input->post('ratingPercentage')
        );
        $response = $this->model('Okcs')->submitRating($ratingData);
        echo json_encode($response->results);
    }
    
    /**
    * Method to submit search rating.
    */
    private function submitSearchRating() {
        $rating = $this->input->post('rating');
        $feedback = $this->input->post('feedback');
        $priorTransactionID = $this->input->post('priorTransactionID');
        $okcsSearchSession = $this->input->post('okcsSearchSession');
        $response = $this->model('Okcs')->submitSearchRating($rating, $feedback, $priorTransactionID, $okcsSearchSession);
        echo json_encode($response->results);
    }
}
