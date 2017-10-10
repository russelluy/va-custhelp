<?php
 namespace Custom\Controllers;
use RightNow\Libraries\AbuseDetection;
class AjaxCustom extends \RightNow\Controllers\Base {
function __construct() {
parent::__construct();
}
function ajaxFunctionHandler() {
$postData = $this->input->post('post_data_name');
echo $returnedInformation;
}
public function sendForm() {
if (!AbuseDetection::isAbuse($this->input->post('f_tok'))) {
$data = json_decode($this->input->post('form'));
$posttopics=json_decode($this->input->post('topics'));
if(!$data) {
header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
Framework::writeContentWithLengthAndExit(json_encode(Config::getMessage((40881))) . str_repeat("\n", 512));
}
if($listOfUpdateRecordIDs = json_decode($this->input->post('updateIDs'), true)){
$listOfUpdateRecordIDs = array_filter($listOfUpdateRecordIDs);
}
$smartAssistant = $this->input->post('smrt_asst');
$topics = json_decode($this->input->post('topics'));
for($i = 0, $size = count($data);
$i < $size;
++$i) {
if ($data[$i]->name === "Incident.Product") {
array_splice($data, $i, 1);
}
else {
}
}
if($posttopics) {
$mystring = str_replace("\u00a0","",json_encode($posttopics));
$topics= array("topics" => $mystring);
$CI =& get_instance();
$CI->session->setSessionData($topics);
}
echo $this->model('Field')->sendForm($data, $listOfUpdateRecordIDs ?: array(), ($smartAssistant === 'true'))->toJson();
}
}
public function chatInfo() {
$CI=get_instance();
$curr_session = json_decode($this->input->post('form'));
$CI->session->setSessionData(array('temp_session' => $curr_session));
AbuseDetection::check($this->input->post('f_tok'));
$data = json_decode($this->input->post('form'));
if(!$data) {
header("HTTP/1.1 400 Bad Request");
Framework::writeContentWithLengthAndExit(json_encode(Config::getMessage((40881))) . str_repeat("\n", 512));
}
$incidentID = $this->input->post('i_id');
$smartAssistant = $this->input->post('smrt_asst');
echo $this->model('Field')->sendForm($data, intval($incidentID), ($smartAssistant === 'true'))->toJson();
}
}
