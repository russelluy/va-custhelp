<?php
namespace Custom\Widgets\input;
use RightNow\Api, RightNow\Connect\v1_2 as Connect;
class IncidentTaskInput extends \RightNow\Libraries\Widget\Base {
function __construct($attrs) {
parent::__construct($attrs);
$this->setAjaxHandlers(array( 'saveTaskData_ajax_endpoint' => array( 'method' => 'handle_saveTaskData_ajax_endpoint', 'clickstream' => 'custom_action', ), ));
}
function getData() {
$this->data['attrs']['data_type'] = 'products';
strtolower($this->data['attrs']['data_type']);
if($this->data['attrs']['add_params_to_url']) $this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']);
$all_levels = $this->CI->model('Prodcat')->getHierPopup($this->data['attrs']['data_type'])->result;
$this->data['results'] = array();
$seq = 1;
foreach($all_levels as $value) {
switch($value['level']) {
case 0 : $id1 = $value[1];
$parent = $value[3];
$this->data['results'][$id1] = array('id'=>$id1, 'label'=>$value[0], $seq++, 'parent'=>$parent, 'level'=>$value['level'], 'hierList'=>$value[hier_list]);
break;
case 1 : $id2 = $value[1];
$parent = $value[3];
$this->data['results'][$id1]['subItems'][$id2] = array('id'=>$id2, 'label'=>$value[0], $seq++, 'parent'=>$parent, 'level'=>$value['level'], 'hierList'=>$value[hier_list]);
break;
case 2 : $id3 = $value[1];
$parent = $value[4];
$this->data['results'][$id1]['subItems'][$id2]['subItems'][$id3] = array('id'=>$id3, 'label'=>$value[0], $seq++, 'parent'=>$parent, 'level'=>$value['level'], 'hierList'=>$value[hier_list]);
break;
}
}
}
function handle_getProducts_ajax_endpoint($params) {
$result = Connect\ROQL::query("select Id, Name from ServiceProduct s where parent=28 " )->next();
echo "<select id=\"products\">";
while($record = $result->next()) {
echo " <option value=\"$record[ID]\">$record[Name]</option>";
}
echo "</select> ";
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