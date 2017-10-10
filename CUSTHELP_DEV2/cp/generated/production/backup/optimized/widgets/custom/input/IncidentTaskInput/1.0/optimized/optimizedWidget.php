<? namespace Custom\Widgets\input;
require_once '/cgi-bin/virginamerica.cfg/scripts/cp/generated/production/temp_optimized/widgets/custom/input/ProductCategoryInputCustom/1.0/optimized/optimizedWidget.php';
\RightNow\Utils\Widgets::requireOptimizedWidgetController("standard/output/ProductCategoryDisplay");
use RightNow\Api, RightNow\Connect\v1_2 as Connect;
class IncidentTaskInput extends \RightNow\Libraries\Widget\Base {
function _custom_input_IncidentTaskInput_view ($data) {
extract($data);
?><div id="<?= "rn_{$this->instanceID}"
?>" class="<?= $this->classList ?>">
<div id="<?= "rn_{$this->instanceID}_content"
?>" class="rn_label" >
    <? $instanceName = "rn_{$this->instanceID}";
?>
<br>    
I had a .. <br><br>
<div id="<?= "rn_{$this->instanceID}_Topics"?>" class="rn_IncidentTaskInput_Topics" ></div>
<br>
<div class="rn_IncidentTaskInput_col">
    <select id="<?=
"rn_{$this->instanceID}_select"?>" class="rn_IncidentTaskInput_Select">
 <option value="P">Positive Experience</option>
 <option value="N">Negative Experience</option>
 <option value="E">Idea/Suggestion</option>
 <option value="O">Other</option>
 </select>
</div>
 <div class="rn_IncidentTaskInput_Narrowcol" >
with </div>
<div class="rn_IncidentTaskInput_col2">
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/ProductCategoryInputCustom',
array('label_input' => '','label_nothing_selected' => 'Select a Topic',));
?>
</div>
<div class="rn_IncidentTaskInput_Narrowcol">
<input type="button" class="rn_IncidentTaskInput_Button" id="rn_<?=$this->instanceID?>_TopicButton" value="Add" />
<input type="hidden" id="rn_<?=$this->instanceID?>_TopicIdSelected" value="" />
<input type="hidden" id="rn_<?=$this->instanceID?>_TopicLabelSelected" value="" />
</div>
</div>
    <div class="rn_IncidentTaskInput_col">&nbsp; </div>
    <div class="rn_IncidentTaskInput_Narrowcol">&nbsp; </div>
    <div class="rn_IncidentTaskInput_col2">
        <span class="rn_IncidentTaskInput_Text">Please click "Add" after selecting topic </span>
    </div>
<br
</div><? }
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
function _custom_input_IncidentTaskInput_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.IncidentTaskInput', 'library_name' => 'IncidentTaskInput', 'view_func_name' => '_custom_input_IncidentTaskInput_view', 'meta' => array ( 'controller_path' => 'custom/input/IncidentTaskInput', 'view_path' => 'custom/input/IncidentTaskInput', 'js_path' => 'custom/input/IncidentTaskInput', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/IncidentTaskInput.css', ), 'base_css' => array ( 0 => 'custom/input/IncidentTaskInput/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), 'yui' => array ( 0 => 'panel', 1 => 'gallery-treeview', ), ), 'info' => array ( 'description' => 'facilitates the data capture for Tasks on the Ask a Question page.', ), 'relativePath' => 'custom/input/IncidentTaskInput', 'widget_name' => 'IncidentTaskInput', ), );
$result['meta']['attributes'] = array( 'saveTaskData_ajax_endpoint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajax/widget', 'type' => 'ajax', 'default' => '/ci/ajax/widget', 'inherited' => false, )), );
return $result;
}
