<?php
namespace Custom\Widgets\input;
use RightNow\Api, RightNow\Connect\v1_2 as Connect;
class IncidentTaskInput extends \RightNow\Libraries\Widget\Base {
function __construct($attrs) {
parent::__construct($attrs);
$this->setAjaxHandlers(array( 'saveTaskData_ajax_endpoint' => array( 'method' => 'handle_saveTaskData_ajax_endpoint', 'clickstream' => 'custom_action', ), ));
}
function getData() {
$all_levels = $this->CI->model('Prodcat')->getHierPopup("products")->result;
$this->data['js']['results'] = array();
$seq = 1;
foreach($all_levels as $value) {
$id1 = $value[1];
$parent = $value[3];
$this->data['js']['results'][$id1] = array('id'=>$id1, 'label'=>$value[0], $seq++, 'parent'=>$parent, 'level'=>$value['level'], 'hierList'=>$value[hier_list]);
}
}
function handle_saveTaskData_ajax_endpoint($params) {
if (isset($params)) {
$mySession['topics'] = $params['topics'];
$CI =& get_instance();
$CI->session->setSessionData($mySession);
setcookie('TOPICS', $params['topics'],0,'/');
}
else {
logMessage("hi");
}
echo json_encode(array('result'=>array('status'=>1)));
}
}
?>