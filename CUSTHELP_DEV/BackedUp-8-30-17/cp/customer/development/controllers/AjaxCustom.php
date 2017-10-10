<?php

namespace Custom\Controllers;
use  RightNow\Libraries\AbuseDetection;

class AjaxCustom extends \RightNow\Controllers\Base
{
    //This is the constructor for the custom controller. Do not modify anything within
    //this function.
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Sample function for ajaxCustom controller. This function can be called by sending
     * a request to /ci/ajaxCustom/ajaxFunctionHandler.
     */
    function ajaxFunctionHandler()
    {
        $postData = $this->input->post('post_data_name');
        //Perform logic on post data here
        echo $returnedInformation;
    }
	public function sendForm()
    {
        if (!AbuseDetection::isAbuse($this->input->post('f_tok'))) {
        $data = json_decode($this->input->post('form'));
        $posttopics=json_decode($this->input->post('topics'));
        if(!$data)
        {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
            // Pad the error message with spaces so IE will actually display it instead of a misleading, but pretty, error message.
            Framework::writeContentWithLengthAndExit(json_encode(Config::getMessage(END_REQS_BODY_REQUESTS_FORMATTED_MSG)) . str_repeat("\n", 512));
        }
        if($listOfUpdateRecordIDs = json_decode($this->input->post('updateIDs'), true)){
            $listOfUpdateRecordIDs = array_filter($listOfUpdateRecordIDs);
        }
        $smartAssistant = $this->input->post('smrt_asst');
                $topics = json_decode($this->input->post('topics'));

                        // Remove product from data array
        for($i = 0, $size = count($data); $i < $size; ++$i) {
            if ($data[$i]->name === "Incident.Product") {
                array_splice($data, $i, 1);
                } else {
                    //echo $data[$i]->name. "<br>";
             }
        }
       
        if($posttopics) 
        {
///            print_r($posttopics);
            $mystring = str_replace("\u00a0","",json_encode($posttopics));
            
           $topics= array("topics" => $mystring);
           
           $CI =& get_instance();
          $CI->session->setSessionData($topics);
//        echo $topics;
  //      echo   $CI->session->getSessionData('topics');
   //     exit();
        }
                echo $this->model('Field')->sendForm($data, $listOfUpdateRecordIDs ?: array(), ($smartAssistant === 'true'))->toJson();
    }
    } 
	
	public function chatInfo()
	{
	$CI=get_instance();
	$curr_session = json_decode($this->input->post('form'));
	
	
	$CI->session->setSessionData(array('temp_session' => $curr_session));
	
		AbuseDetection::check($this->input->post('f_tok'));
        $data = json_decode($this->input->post('form'));
		 if(!$data)
        {
            header("HTTP/1.1 400 Bad Request");
            // Pad the error message with spaces so IE will actually display it instead of a misleading, but pretty, error message.
            Framework::writeContentWithLengthAndExit(json_encode(Config::getMessage(END_REQS_BODY_REQUESTS_FORMATTED_MSG)) . str_repeat("\n", 512));
        }
		$incidentID = $this->input->post('i_id');
		$smartAssistant = $this->input->post('smrt_asst');
		 echo $this->model('Field')->sendForm($data, intval($incidentID), ($smartAssistant === 'true'))->toJson();
	}	  
}

