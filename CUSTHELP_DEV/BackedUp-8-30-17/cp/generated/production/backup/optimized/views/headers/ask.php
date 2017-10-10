<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/standard', 1 => '/euf/assets/themes/standard', 2 => array ( '/euf/assets/themes/standard' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/standard', ), ));
get_instance()->_checkMeta(array('title'=>'' . \RightNow\Utils\Config::msgGetFrom((4519)) . '', 'template'=>'standard.php', 'clickstream'=>'incident_create'));
get_instance()->clientLoader->setJavaScriptModule(get_instance()->meta['javascript_module']);
}
namespace Custom\Libraries\Widgets {
class CustomSharedViewPartials extends \RightNow\Libraries\Widgets\SharedViewPartials {
static function sample_view ($data) {
extract($data);
?>sample custom shared view partial<? }
}
}
namespace Custom\Widgets\chat{
class ChatAgentCustomAvail extends \RightNow\Libraries\Widget\Base {
function _custom_chat_ChatAgentCustomAvail_view ($data) {
extract($data);
?><? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$chatProduct = "";
$chatCategory = "";
$contactID = '';
$orgID = "";
$contactEmail = "";
$contactFirstName = "";
$contactLastName = "";
$availType = "agents";
$isCacheable = "";
$callback = "";
$interfaceID = 1;
$cacheKey = implode('|', array($chatProduct, $chatCategory, $contactID, $orgID, $contactEmail, $contactFirstName, $contactLastName, $interfaceID));
$cache = new \RightNow\Libraries\Cache\Memcache(60);
if (($chatRouteRV = $cache->get($cacheKey)) === false) {
$chatRouteRV = $this->CI->model('Chat')->chatRoute($chatProduct, $chatCategory, $contactID, $orgID, $contactEmail, $contactFirstName, $contactLastName)->result;
$cache->set($cacheKey, $chatRouteRV);
}
$result = $this->CI->model('Chat')->checkChatQueue($chatRouteRV, $availType, $isCacheable)->result;
header("Cache-Control: max-age=0,no-cache,no-store");
if($callback) {
header("Content-Type: text/javascript;charset=UTF-8");
}
$this->data['js']['result']=$result['stats']['availableSessionCount'];
return parent::getData();
}
}
function _custom_chat_ChatAgentCustomAvail_header() {
$result = array( 'js_name' => 'Custom.Widgets.chat.ChatAgentCustomAvail', 'library_name' => 'ChatAgentCustomAvail', 'view_func_name' => '_custom_chat_ChatAgentCustomAvail_view', 'meta' => array ( 'controller_path' => 'custom/chat/ChatAgentCustomAvail', 'view_path' => '', 'js_path' => 'custom/chat/ChatAgentCustomAvail', 'base_css' => array ( 0 => 'custom/chat/ChatAgentCustomAvail/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'relativePath' => 'custom/chat/ChatAgentCustomAvail', 'widget_name' => 'ChatAgentCustomAvail', ), );
$result['meta']['attributes'] = array( );
return $result;
}
}
namespace RightNow\Widgets{
class SmartAssistantDialog extends \RightNow\Libraries\Widget\Base {
function _standard_input_SmartAssistantDialog_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <div class="rn_MessageBox rn_InfoMessage">
        <span id="rn_<?=$this->instanceID;?>_DialogHeading" class="rn_Heading"><??></span>
    </div>
    <div id="rn_<?=$this->instanceID;?>_DialogContent"><?
?></div>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$defaultButtons = array('label_solved_button', 'label_submit_button', 'label_cancel_button');
$cleanUpValue = function($value) {
return strtolower(trim($value));
};
$buttons = array_map($cleanUpValue, array_unique(explode(',', $this->data['attrs']['button_ordering'])));
$displayAsLinks = array_map($cleanUpValue, array_unique(explode(',', $this->data['attrs']['display_button_as_link'])));
$ordering = array();
for($i = 0;
$i < count($buttons);
$i++) {
if(($button = $buttons[$i]) && in_array($button, $defaultButtons) && $this->data['attrs'][$button]) {
unset($defaultButtons[array_search($button, $defaultButtons, true)]);
$this->pushItem($ordering, $button, in_array($button, $displayAsLinks));
}
}
$i = 0;
while(count($ordering) < count($defaultButtons) && $i < count($defaultButtons)) {
$default = $defaultButtons[$i];
if(!array_key_exists($default, $ordering) && $this->data['attrs'][$default]) {
$this->pushItem($ordering, $default, in_array($default, $displayAsLinks));
}
$i++;
}
$this->data['attrs']['button_ordering'] = $ordering;
}
protected function pushItem(array &$orderingArray, $attributeName, $displayAsLink) {
$orderingArray[] = array( 'name' => $attributeName, 'label' => $this->data['attrs'][$attributeName], 'displayAsLink' => $displayAsLink, );
}
}
function _standard_input_SmartAssistantDialog_header() {
$result = array( 'js_name' => 'RightNow.Widgets.SmartAssistantDialog', 'library_name' => 'SmartAssistantDialog', 'view_func_name' => '_standard_input_SmartAssistantDialog_view', 'meta' => array ( 'controller_path' => 'standard/input/SmartAssistantDialog', 'view_path' => 'standard/input/SmartAssistantDialog', 'js_path' => 'standard/input/SmartAssistantDialog', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/SmartAssistantDialog.css', 1 => 'assets/themes/mobile/widgetCss/SmartAssistantDialog.css', ), 'base_css' => array ( 0 => 'standard/input/SmartAssistantDialog/base.css', ), 'js_templates' => array ( 'answerContent' => '<span id="<%= spanID %>" class="rn_Answer rn_AnswerDetail rn_Hidden"> <% if(question) { %> <span class="rn_AnswerSummary"><%= question %></span> <% } %> <span class="rn_AnswerSolution"><%= contents %></span></span>', 'answerLink' => '<a target="_blank" href="<%= href %>" onclick=\'RightNow.ActionCapture.record("smartAssistantResult", "view", <%= answerID %>);\'> <%= text %></a>', 'displayResults' => '<% for(var i = 0, suggestion; i < suggestions.length; i++) { suggestion = suggestions[i]; if(suggestion.type === \'AnswerSummary\') { %>  <div class="rn_Prompt"><%= attrs.label_prompt %> <% if(attrs.accesskeys_enabled && attrs.label_accesskey && attrs.display_answers_inline) { %> <div class="rn_AccesskeyPrompt"><%= accessKeyPrompt %></div> <% } %> </div>  <ul class="rn_List <%= (attrs.display_answers_inline) ? \'rn_InlineAnswers\' : \'\' %>"> <% for(var j = 0; j < suggestion.list.length; j++) { %> <% if(attrs.display_answers_inline) { %>  <li> <% if(attrs.accesskeys_enabled) { %>  <a href="javascript:void(0)" accesskey="<%=j+1%>" data-id="<%=suggestion.list[j].ID%>" class="rn_InlineAnswerLink rn_ExpandAnswer" id="<%=baseDomID + \'_Answer\' + suggestion.list[j].ID %>"> <% } else { %>  <a href="javascript:void(0)" data-id="<%=suggestion.list[j].ID%>" class="rn_InlineAnswerLink rn_ExpandAnswer" id="<%=baseDomID + \'_Answer\' + suggestion.list[j].ID %>"> <% } %> <%= suggestion.list[j].title %> <span class="rn_ScreenReaderOnly" role="alert" id="<%=baseDomID + \'_Answer\' + suggestion.list[j].ID + \'_Alternative\'%>"> <%= attrs.label_collapsed %> </span> </a>  </li>  <% } else { %>  <li>  <a target="_blank" href="<%= \'/app/\' + answerUrl + \'/a_id/\' + suggestion.list[j].ID + sessionParam %>" onclick=\'RightNow.ActionCapture.record("smartAssistantResult", "view", <%=suggestion.list[j].ID%>);\'> <%=suggestion.list[j].title%> </a>  </li>  <% } %> <% } %> </ul> <% } else if(suggestion.type === \'Answer\') { %>  <div class="rn_Answer"> <div class="rn_Summary"><%=suggestion.title%></div> <div class="rn_Solution"><%=suggestion.content%></div> </div>  <% } else { %>  <div class="rn_Response"><%=suggestion.content%></div>  <% } %><% } %>', ), 'template_path' => 'standard/input/SmartAssistantDialog', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4282)', ), 'relativePath' => 'standard/input/SmartAssistantDialog', 'widget_name' => 'SmartAssistantDialog', ), );
$result['meta']['attributes'] = array( 'get_answer_content' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/getAnswer', 'type' => 'AJAX', 'default' => '/ci/ajaxRequest/getAnswer', 'inherited' => false, )), 'label_banner' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3303), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3303), 'inherited' => false, )), 'label_prompt' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1984), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1984), 'inherited' => false, )), 'label_no_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(42065), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(42065), 'inherited' => false, )), 'label_submit_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4781), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4781), 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1699), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1699), 'inherited' => false, )), 'label_solved_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2783), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2783), 'inherited' => false, )), 'label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1967), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1967), 'inherited' => false, )), 'label_collapsed' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(14422), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(14422), 'inherited' => false, )), 'label_expanded' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(14416), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(14416), 'inherited' => false, )), 'label_accesskey' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(19076), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(19076), 'inherited' => false, )), 'label_download_attachment' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40397), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(40397), 'inherited' => false, )), 'label_view_guide' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(47429), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(47429), 'inherited' => false, )), 'solved_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'inherited' => false, )), 'accesskeys_enabled' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'display_answers_inline' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'button_ordering' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'label_solved_button, label_submit_button, label_cancel_button', 'type' => 'STRING', 'default' => 'label_solved_button, label_submit_button, label_cancel_button', 'inherited' => false, )), 'display_button_as_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'label_cancel_button', 'type' => 'STRING', 'default' => 'label_cancel_button', 'inherited' => false, )), 'dialog_width' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '800px', 'type' => 'STRING', 'default' => '800px', 'inherited' => false, )), 'dnc_label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'dnc_label_banner' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'dnc_label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'dnc_redirect_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class FormInput extends \RightNow\Libraries\Widget\Input {
function _standard_input_FormInput_view ($data) {
extract($data);
?><?php ?>
<? switch ($this->dataType): case 'Menu': case 'Boolean': case 'Country': case 'NamedIDLabel': case 'NamedIDOptList': case 'Status': case 'Asset': case 'AssignedSLAInstance':?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/SelectionInput', array('sub_id' => 'selection',));
?>
        <? break;
case 'Date': case 'DateTime':?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/DateInput', array('sub_id' => 'date',));
?>
        <? break;
default: ?>
        <? if ($this->fieldName === 'NewPassword'): ?>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/PasswordInput', array('sub_id' => 'password',));
?>
        <? else: ?>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/TextInput', array('sub_id' => 'text',));
?>
        <? endif;
?>
        <? break;
endswitch;?>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if (parent::getDataType() === false) return false;
if ($this->dataType === 'ServiceProduct' || $this->dataType === 'ServiceCategory') {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((3023)), $this->fieldName));
return false;
}
if ($this->dataType === 'FileAttachmentIncident') {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((3022)), $this->fieldName));
return false;
}
if ($this->dataType === 'SalesProduct') {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((45561)), $this->fieldName));
return false;
}
}
}
function _standard_input_FormInput_header() {
$result = array( 'js_name' => '', 'library_name' => 'FormInput', 'view_func_name' => '_standard_input_FormInput_view', 'meta' => array ( 'controller_path' => 'standard/input/FormInput', 'view_path' => 'standard/input/FormInput', 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:php:sprintf(\\RightNow\\Utils\\Config::getMessage((44076)), \'name\', \'default_value\')', 'urlParameters' => array ( 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), ), ), 'contains' => array ( 0 => array ( 'widget' => 'standard/input/SelectionInput', 'versions' => array ( 0 => '1.2', 1 => '1.3', 2 => '1.4', ), ), 1 => array ( 'widget' => 'standard/input/DateInput', 'versions' => array ( 0 => '1.3', 1 => '1.4', 2 => '1.5', ), ), 2 => array ( 'widget' => 'standard/input/TextInput', 'versions' => array ( 0 => '1.3', 1 => '1.4', ), ), 3 => array ( 'widget' => 'standard/input/PasswordInput', 'versions' => array ( 0 => '1.3', 1 => '1.4', ), ), ), 'relativePath' => 'standard/input/FormInput', 'widget_name' => 'FormInput', ), );
$result['meta']['attributes'] = array( );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Connect, RightNow\Utils\Config;
class SelectionInput extends \RightNow\Libraries\Widget\Input {
function _standard_input_SelectionInput_view ($data) {
extract($data);
?><?php ?>
<? if ($this->data['readOnly']): ?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/FieldDisplay', array('left_justify' => 'true',));
?>
<? else: ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<? if ($this->data['attrs']['label_input'] && $this->data['displayType'] !== 'Radio'): ?>
    <div id="rn_<?= $this->instanceID ?>_LabelContainer">
        <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" id="rn_<?= $this->instanceID ?>_Label" class="rn_Label"><?= $this->data['attrs']['label_input'] ?>
        <? if ($this->data['attrs']['required']): ?>
            <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015))?></span>
        <? endif;
?>
        <? if ($this->data['attrs']['hint']): ?>
            <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
        </label>
    </div>
<? endif;
?>
<? if ($this->data['displayType'] === 'Select'): ?>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" name="<?= $this->data['inputName'] ?>">
    <? if (!$this->data['hideEmptyOption']): ?>
        <option value="">--</option>
    <? endif;
?>
    <? if (is_array($this->data['menuItems'])): ?>
        <? foreach ($this->data['menuItems'] as $key => $item): ?>
            <option value="<?= $key ?>" <?= $this->outputselected($key) ?>><?=\RightNow\Utils\Text::escapeHtml($item);?></option>
        <?
endforeach;
?>
    <? endif;
?>
    </select>
    <? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
        <span id="rn_<?= $this->instanceID ?>_Hint" class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
    <? endif;
?>
<? else: ?>
    <? if ($this->data['displayType'] === 'Checkbox'): ?>
        <input type="checkbox" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" name="<?= $this->data['inputName'] ?>" <?= $this->outputchecked(1) ?> value="1"/>
        <? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
            <span id="rn_<?= $this->instanceID ?>_Hint" class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
    <? else: ?>
        <fieldset>
        <? if ($this->data['attrs']['label_input']): ?>
            <legend id="rn_<?= $this->instanceID ?>_Label" class="rn_Label">
                <?= $this->data['attrs']['label_input'] ?>
                <? if ($this->data['attrs']['required']): ?>
                    <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015))?></span>
                <? endif;
?>
            </legend>
        <? endif;
?>
        <? for($i = 1;
$i >= 0;
$i--): $id = "rn_{$this->instanceID}_{$this->data['js']['name']}_$i";
?>
            <input type="radio" name="<?= $this->data['inputName']?>" id="<?= $id ?>" <?= $this->outputchecked($i) ?> value="<?= $i ?>"/>
            <label for="<?= $id ?>">
            <?= $this->data['radioLabel'][$i] ?>
            <? if ($this->data['attrs']['hint'] && $i === 1): ?>
                <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
            <? endif;
?>
            </label>
        <? endfor;
?>
        <? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
            <span id="rn_<?= $this->instanceID ?>_Hint"  class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
        </fieldset>
    <?endif;
?>
<? endif;
?>
</div>
<? endif;
?>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if (parent::getData() === false) return false;
if(!$this->isValidField()) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((3039)), $this->fieldName));
return false;
}
if($this->fieldName === 'SLAInstance' && !\RightNow\Utils\Framework::isLoggedIn()){
return false;
}
if(!Connect::isCustomField($this->fieldMetaData)) {
if($this->table === 'Incident' && $this->fieldName === 'Status') {
if (!\RightNow\Utils\Url::getParameter('i_id')) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((3021)), $this->data['attrs']['name']));
return false;
}
$this->data['menuItems'] = array(\RightNow\Utils\Config::getMessage((4406)), \RightNow\Utils\Config::getMessage((2143)));
$this->data['hideEmptyOption'] = true;
$this->data['displayType'] = 'Select';
}
}
if($this->dataType === 'Boolean') {
if($this->data['attrs']['display_as_checkbox']) {
$this->data['displayType'] = 'Checkbox';
$this->data['constraints']['isCheckbox'] = true;
}
else {
$this->data['displayType'] = 'Radio';
$this->classList->add('rn_Radio');
}
$this->data['radioLabel'] = array(\RightNow\Utils\Config::getMessage((863)), \RightNow\Utils\Config::getMessage((869)));
if(in_array($this->data['value'], array(true, 'true', '1'), true)) $this->data['checkedIndex'] = 1;
else if(in_array($this->data['value'], array(false, 'false', '0'), true)) $this->data['checkedIndex'] = 0;
else $this->data['checkedIndex'] = -1;
}
else if (!$this->data['menuItems']) {
$this->data['displayType'] = 'Select';
$this->data['menuItems'] = $this->getMenuItems();
}
}
function isValidField() {
return in_array($this->dataType, array('Menu', 'Boolean', 'Country', 'NamedIDLabel', 'NamedIDOptList', 'AssignedSLAInstance', 'Status', 'Asset', 'Product'));
}
public function outputSelected($key) {
if ($this->table === 'Incident' && $this->fieldName === 'Status' && $this->data['displayType'] === 'Select') {
$selected = ($key === 0);
}
else if ($this->dataType === 'Menu') {
$selected = ($key == $this->data['value']->ID);
}
else {
$selected = ($key == $this->data['value']);
}
return $selected ? 'selected="selected"' : null;
}
public function outputChecked($currentIndex) {
if ($this->data['checkedIndex'] === $currentIndex) {
return 'checked="checked"';
}
}
protected function getMenuItems(){
$menuItems = array();
if (!($items = $this->fieldMetaData->named_values)) {
if($this->fieldName === 'StateOrProvince'){
if($this->data['value'] !== null){
list($countryValue) = Connect::getObjectField(array('Contact', 'Address', 'Country', 'ID'));
$countryValue = $this->CI->input->post('Contact_Address_Country') ?: $countryValue ?: \RightNow\Utils\Url::getParameter('Contact.Address.Country');
if($countryValue && ($stateProvinceList = $this->CI->model('Country')->get($countryValue)->result)){
$items = $stateProvinceList->Provinces;
}
}
}
else if($this->fieldName === 'Country'){
$items = array();
$countryItems = $this->CI->model('Country')->getAll()->result;
foreach ($countryItems as $countryItem) $items[] = (object)array('ID' => $countryItem->ID, 'LookupName' => $countryItem->Name);
}
else if($this->fieldName === 'SLAInstance'){
$contact = $this->CI->model('Contact')->get()->result;
$contactSlas = ($contact->Organization && $contact->Organization->ID) ? $contact->Organization->ServiceSettings->SLAInstances : $contact->ServiceSettings->SLAInstances;
$items = array();
if(Connect::isArray($contactSlas)){
foreach($contactSlas as $slaInstance){
if($this->isValidSla($slaInstance)){
$items[] = $slaInstance->NameOfSLA;
}
}
}
}
else if($this->table === 'Asset' && $this->fieldName === 'Status'){
$items = $this->CI->model('Asset')->getAssetStatuses()->result;
}
else if($this->table === 'Incident' && $this->fieldName === 'Asset'){
$items = $this->CI->model('Asset')->getAssets()->result;
}
else{
$field = explode('.', $this->data['inputName']);
$object = array_shift($field);
$items = Connect::getNamedValues($object, implode('.', $field));
}
}
if($items){
foreach ($items as $item) {
$menuItems[$item->ID] = $item->LookupName ?: $item->Name;
}
}
return $menuItems;
}
protected function isValidSla($slaInstance){
$currentTime = time();
return ($slaInstance->StateOfSLA->ID === (2) && $slaInstance->ActiveDate <= $currentTime && ($slaInstance->ExpireDate === null || $slaInstance->ExpireDate > $currentTime) && ($slaInstance->RemainingFromWeb === null || $slaInstance->RemainingFromWeb > 0) && ($slaInstance->RemainingTotal === null || $slaInstance->RemainingTotal > 0));
}
}
function _standard_input_SelectionInput_header() {
$result = array( 'js_name' => 'RightNow.Widgets.SelectionInput', 'library_name' => 'SelectionInput', 'view_func_name' => '_standard_input_SelectionInput_view', 'meta' => array ( 'controller_path' => 'standard/input/SelectionInput', 'view_path' => 'standard/input/SelectionInput', 'js_path' => 'standard/input/SelectionInput', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/SelectionInput.css', 1 => 'assets/themes/mobile/widgetCss/SelectionInput.css', ), 'base_css' => array ( 0 => 'standard/input/SelectionInput/base.css', ), 'js_templates' => array ( 'label' => '<% if (label) { %>  <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <% } %>', 'legend' => '<% if (label) { %>  <%= label %> <% if (required) { %>  <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% } %>', ), 'template_path' => 'standard/input/SelectionInput', 'version' => '1.3.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4196)', ), 'contains' => array ( 0 => array ( 'widget' => 'standard/output/FieldDisplay', 'versions' => array ( 0 => '1.1', ), ), ), 'relativePath' => 'standard/input/SelectionInput', 'widget_name' => 'SelectionInput', ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => false, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => false, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'display_as_checkbox' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace Custom\Widgets\input{
class SelectionRadioInput extends \RightNow\Widgets\SelectionInput {
function _custom_input_SelectionRadioInput_view ($data) {
extract($data);
?><?php ?>
<? if ($this->data['readOnly']): ?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/FieldDisplay', array('left_justify' => 'true',));
?>
<? else: ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<? if ($this->data['attrs']['label_input'] && $this->data['displayType'] !== 'Radio'): ?>
    <div id="rn_<?= $this->instanceID ?>_LabelContainer">
        <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" id="rn_<?= $this->instanceID ?>_Label" class="rn_Label"><?= $this->data['attrs']['label_input'] ?>
        <? if ($this->data['attrs']['required']): ?>
            <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015))?></span>
        <? endif;
?>
        <? if ($this->data['attrs']['hint']): ?>
            <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
        </label>
    </div>
<? endif;
?>
<? if ($this->data['displayType'] === 'Select'): ?>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" name="<?= $this->data['inputName'] ?>">
    <? if (!$this->data['hideEmptyOption']): ?>
        <option value="">--</option>
    <? endif;
?>
    <? if (is_array($this->data['menuItems'])): ?>
        <? foreach ($this->data['menuItems'] as $key => $item): ?>
            <option value="<?= $key ?>" <?= $this->outputselected($key) ?>><?=\RightNow\Utils\Text::escapeHtml($item);?></option>
        <?
endforeach;
?>
    <? endif;
?>
    </select>
    <? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
        <span id="rn_<?= $this->instanceID ?>_Hint" class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
    <? endif;
?>
<? else: ?>
    <? if ($this->data['displayType'] === 'Checkbox'): ?>
        <input type="checkbox" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" name="<?= $this->data['inputName'] ?>" <?= $this->outputchecked(1) ?> value="1"/>
        <? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
            <span id="rn_<?= $this->instanceID ?>_Hint" class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
    <? else: ?>
        <fieldset>
        <? if ($this->data['attrs']['label_input']): ?>
            <legend id="rn_<?= $this->instanceID ?>_Label" class="rn_Label">
                <?= $this->data['attrs']['label_input'] ?>
                <? if ($this->data['attrs']['required']): ?>
                    <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015))?></span>
                <? endif;
?>
            </legend>
        <? endif;
?>
        <? for($i = 1;
$i >= 0;
$i--): $id = "rn_{$this->instanceID}_{$this->data['js']['name']}_$i";
?>
            <input type="radio" name="<?= $this->data['inputName']?>" id="<?= $id ?>" <?= $this->outputchecked($i) ?> value="<?= $i ?>"/>
            <label for="<?= $id ?>">
            <?= $this->data['radioLabel'][$i] ?>
            <? if ($this->data['attrs']['hint'] && $i === 1): ?>
                <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
            <? endif;
?>
            </label>
        <? endfor;
?>
        <? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
            <span id="rn_<?= $this->instanceID ?>_Hint"  class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
        </fieldset>
    <?endif;
?>
<? endif;
?>
</div>
<? endif;
?>
<? }
}
function _custom_input_SelectionRadioInput_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.SelectionRadioInput', 'library_name' => 'SelectionRadioInput', 'view_func_name' => '_custom_input_SelectionRadioInput_view', 'meta' => array ( 'controller_path' => 'custom/input/SelectionRadioInput', 'view_path' => 'custom/input/SelectionRadioInput', 'js_path' => 'custom/input/SelectionRadioInput', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/SelectionRadioInput.css', ), 'base_css' => array ( 0 => 'custom/input/SelectionRadioInput/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/input/SelectionInput', 'components' => array ( 'php' => true, 'view' => true, 'js' => true, 'css' => true, ), ), 'relativePath' => 'custom/input/SelectionRadioInput', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/SelectionInput', ), 'view' => array ( 0 => 'standard/input/SelectionInput', ), 'logic' => array ( 0 => 'standard/input/SelectionInput', ), 'js_templates' => array ( 0 => array ( 'label' => '<% if (label) { %> <rn:block id="preLabel"/> <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %> <rn:block id="preRequired"/> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <rn:block id="postRequired"/> <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <rn:block id="postLabel"/><% } %>', 'legend' => '<% if (label) { %> <rn:block id="preLabel"/> <%= label %> <% if (required) { %> <rn:block id="preRequired"/> <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <rn:block id="postRequired"/> <% } %> <rn:block id="postLabel"/><% } %>', ), ), 'base_css' => array ( 0 => 'standard/input/SelectionInput/base.css', ), 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/SelectionInput.css', 1 => 'assets/themes/mobile/widgetCss/SelectionInput.css', ), 'parent' => 'standard/input/SelectionInput', ), 'widget_name' => 'SelectionRadioInput', 'extends_php' => array ( 0 => 'standard/input/SelectionInput', ), 'extends_js' => array ( 0 => 'standard/input/SelectionInput', ), 'extends_view' => array ( 0 => 'standard/input/SelectionInput', ), 'parent' => 'standard/input/SelectionInput', 'js_templates' => array ( 'label' => '<% if (label) { %>  <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <% } %>', 'legend' => '<% if (label) { %>  <%= label %> <% if (required) { %>  <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% } %>', ), ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => true, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => true, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => true, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'display_as_checkbox' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Connect;
class TextInput extends \RightNow\Libraries\Widget\Input {
function _standard_input_TextInput_view ($data) {
extract($data);
?><?php ?>
<? if ($this->data['readOnly']): ?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/FieldDisplay', array('left_justify' => 'true',));
?>
<? else: ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<? if ($this->data['attrs']['label_input']): ?>
    <div id="rn_<?= $this->instanceID ?>_LabelContainer">
        <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" id="rn_<?= $this->instanceID ?>_Label" class="rn_Label">
        <?= $this->data['attrs']['label_input'] ?>
        <? if ($this->data['attrs']['required']): ?>
            <span class="rn_Required"> <?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015)) ?></span>
        <? endif;
?>
        <? if ($this->data['attrs']['hint']): ?>
            <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
        </label>
    </div>
<? endif;
?>
<? if ($this->data['displayType'] === 'Textarea'): ?>
    <textarea id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" class="rn_TextArea" rows="7" cols="60" name="<?= $this->data['inputName'] ?>" <?= $this->outputconstraints();
?>><?= $this->data['value'] ?></textarea>
<? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
    <span class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
<? endif;
?>
<? else: ?>
    <input type="<?=$this->data['inputType']?>" id="rn_<?=$this->instanceID?>_<?=$this->data['js']['name']?>" name="<?= $this->data['inputName'] ?>" class="rn_<?=$this->data['displayType']?>" <?=$this->outputconstraints();?> <?if($this->data['value']
!== null && $this->data['value'] !== '') echo "value='{$this->data['value']}'";?> />
<?
if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
    <span class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
<? endif;
?>
    <? if ($this->data['attrs']['require_validation']): ?>
    <div class="rn_TextInputValidate">
        <div id="rn_<?= $this->instanceID ?>_LabelValidateContainer">
            <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Validate" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_LabelValidate" class="rn_Label"><?printf($this->data['attrs']['label_validation'], $this->data['attrs']['label_input']) ?>
            <? if ($this->data['attrs']['required']): ?>
                <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015)) ?></span>
            <? endif;
?>
            </label>
        </div>
        <input type="<?= $this->data['inputType'] ?>" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Validate" name="<?= $this->data['inputName'] ?>_Validation" class="rn_<?=$this->data['displayType']?> rn_Validation" <?= $this->outputconstraints();
?> value="<?= $this->data['value'] ?>"/>
    </div>
   <? endif;
?>
<? endif;
?>
</div>
<? endif;
?><? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if (parent::getData() === false) return false;
if (!in_array($this->dataType, array('String', 'Integer', 'Thread'))) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((40366)), $this->fieldName));
return false;
}
if(is_object($this->data['value'])){
$this->data['value'] = '';
}
$displayType = $this->data['displayType'] = $this->determineDisplayType($this->data['inputName'], $this->dataType, $this->constraints);
if ($this->data['attrs']['textarea']) {
if ($displayType === 'Number' || $displayType === 'Email' || ($displayType === 'Text' && Connect::isCustomField($this->fieldMetaData)) || (($regex = $this->constraints['regex']) && \RightNow\Utils\Validation::regex("a\nb", $regex, $this->fieldName))) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((42044)), $this->fieldName, 'textarea'));
return false;
}
$displayType = $this->data['displayType'] = 'Textarea';
}
$this->data['inputType'] = strtolower($displayType);
if($displayType === "Number" && ($this->data['attrs']['maximum_length'] > 0 || $this->data['attrs']['minimum_length'] > 0)){
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((40946)), $this->fieldName));
return false;
}
if($displayType !== "Number" && (isset($this->data['attrs']['maximum_value']) || isset($this->data['attrs']['minimum_value']))){
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((40947)), $this->fieldName));
return false;
}
if (!$this->data['readOnly']) {
if ($maxLength = intval($this->constraints['maxBytes'] ?: $this->constraints['maxLength'])) {
$this->constraints['maxLength'] = $this->data['js']['constraints']['maxLength'] = $maxLength;
}
if($this->data['attrs']['maximum_length'] > 0){
$maxLength = $this->constraints['maxLength'] = $this->data['js']['constraints']['maxLength'] = $this->data['constraints']['maxLength'] = ($maxLength > 0 ? min($maxLength, $this->data['attrs']['maximum_length']) : $this->data['attrs']['maximum_length']);
}
if($this->data['attrs']['minimum_length'] > 0){
if($maxLength > 0 && ($this->data['attrs']['minimum_length'] > $maxLength)){
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((1983)), $this->fieldName, $this->data['attrs']['minimum_length'], $maxLength));
return false;
}
$this->constraints['minLength'] = $this->data['constraints']['minLength'] = $this->data['js']['constraints']['minLength'] = $this->data['attrs']['minimum_length'];
$this->data['attrs']['required'] = $this->data['constraints']['required'] = true;
}
if(isset($this->data['attrs']['maximum_value'])){
$this->constraints['maxValue'] = (isset($this->constraints['maxValue'])) ? min($this->constraints['maxValue'], $this->data['attrs']['maximum_value']) : $this->data['attrs']['maximum_value'];
$this->data['js']['constraints']['maxValue'] = $this->data['constraints']['maxValue'] = $this->constraints['maxValue'];
}
if(isset($this->data['attrs']['minimum_value'])){
$this->constraints['minValue'] = (isset($this->constraints['minValue'])) ? max($this->constraints['minValue'], $this->data['attrs']['minimum_value']) : $this->data['attrs']['minimum_value'];
if(isset($this->constraints['maxValue']) && ($this->data['attrs']['minimum_value'] > $this->constraints['maxValue'])){
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((40945)), $this->fieldName, $this->data['attrs']['minimum_value'], $this->constraints['maxValue']));
return false;
}
$this->data['js']['constraints']['minValue'] = $this->data['constraints']['minValue'] = $this->constraints['minValue'];
}
}
if($this->data['attrs']['require_validation']) {
$this->data['constraints']['requireValidation'] = true;
}
if(!Connect::isCustomField($this->fieldMetaData)) {
if ($this->fieldName === 'NewPassword') {
echo $this->reportError(\RightNow\Utils\Config::getMessage((43060)));
return false;
}
if ($this->fieldName === 'NameFurigana' && LANG_DIR !== 'ja_JP') {
echo $this->reportError(\RightNow\Utils\Config::getMessage((968)));
return false;
}
if(\RightNow\Utils\Text::stringContainsCaseInsensitive($this->data['inputName'], 'Emails.Primary') && !$this->data['value'] && ($previouslySeen = $this->CI->session->getSessionData('previouslySeenEmail'))) {
$this->data['value'] = $previouslySeen;
}
if ($this->data['attrs']['validate_on_blur'] === true) $this->data['js']['previousValue'] = $this->data['value'];
}
if (isset($this->data['js']['mask'])) {
$this->data['maskedValue'] = $this->data['value'];
$this->data['value'] = \RightNow\Libraries\Formatter::applyMask($this->data['value'], $this->data['js']['mask']);
}
$this->data['js']['contactToken'] = \RightNow\Utils\Framework::createTokenWithExpiration(1);
}
public function outputConstraints() {
$attributes = '';
if ($maxLength = $this->constraints['maxLength']) {
$attributes .= "maxlength='{$maxLength}' ";
}
if (array_key_exists('maxValue', $this->constraints)) {
$attributes .= "max='{$this->constraints['maxValue']}' ";
}
if (array_key_exists('minValue', $this->constraints)) {
$attributes .= "min='{$this->constraints['minValue']}' ";
}
if ($this->data['attrs']['required']) {
$attributes .= "required ";
}
if ($this->data['inputName'] === 'Contact.Login') {
$attributes .= "autocorrect='off' autocapitalize='off' ";
}
return trim($attributes);
}
protected function determineDisplayType($fieldName, $dataType, $constraints) {
if (\RightNow\Utils\Text::beginsWith($fieldName, 'Contact.Emails.') || $this->data['js']['email']) {
return 'Email';
}
if ($this->data['js']['url']) {
return 'Url';
}
if ($dataType === 'Integer') {
return 'Number';
}
if ($dataType === 'Thread') {
return 'Textarea';
}
if ($constraints) {
foreach ($constraints as $name => $constraint) {
if ($name === 'maxLength' && $constraint <= 300) {
return 'Text';
}
}
}
return 'Textarea';
}
}
function _standard_input_TextInput_header() {
$result = array( 'js_name' => 'RightNow.Widgets.TextInput', 'library_name' => 'TextInput', 'view_func_name' => '_standard_input_TextInput_view', 'meta' => array ( 'controller_path' => 'standard/input/TextInput', 'view_path' => 'standard/input/TextInput', 'js_path' => 'standard/input/TextInput', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/TextInput.css', 1 => 'assets/themes/mobile/widgetCss/TextInput.css', ), 'base_css' => array ( 0 => 'standard/input/TextInput/base.css', ), 'js_templates' => array ( 'label' => '<% if (label) { %>  <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <% } %>', 'labelValidate' => '<label for="rn_<%= instanceID %>_<%= fieldName %>_Validate" id="rn_<%= instanceID %>_<%= fieldName %>_LabelValidate" class="rn_Label"><%= label %><% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <% } %></label>', ), 'template_path' => 'standard/input/TextInput', 'version' => '1.3.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4197)', ), 'contains' => array ( 0 => array ( 'widget' => 'standard/output/FieldDisplay', 'versions' => array ( 0 => '1.1', ), ), ), 'relativePath' => 'standard/input/TextInput', 'widget_name' => 'TextInput', ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => false, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => false, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'always_show_mask' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'boolean', 'default' => true, 'inherited' => false, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'existing_contact_check_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/checkForExistingContact', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/checkForExistingContact', 'inherited' => false, )), 'require_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'maximum_length' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'int', 'default' => 0, 'min' => 0, 'inherited' => false, )), 'minimum_length' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'int', 'default' => 0, 'min' => 0, 'inherited' => false, )), 'maximum_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'int', 'default' => null, 'inherited' => false, )), 'minimum_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'int', 'default' => null, 'inherited' => false, )), 'label_validation_incorrect' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1671), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(1671), 'inherited' => false, )), 'label_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3358), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3358), 'inherited' => false, )), 'textarea' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace Custom\Widgets\input{
class CustomTextInput extends \RightNow\Widgets\TextInput {
function _custom_input_CustomTextInput_view ($data) {
extract($data);
?><?php ?>
<? if ($this->data['readOnly']): ?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/FieldDisplay', array('left_justify' => 'true',));
?>
<? else: ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<div id="rn_<?= $this->instanceID ?>_child" class="<?= $this->classList ?> rn_TextInput<?=$passwordClass?> <? if(!$this->data['attrs']['always_show']): echo('rn_Hidden');
endif;?>">
<?
if ($this->data['attrs']['label_input']): ?>
    <div id="rn_<?= $this->instanceID ?>_LabelContainer">
        <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" id="rn_<?= $this->instanceID ?>_Label" class="rn_Label">
        <?= $this->data['attrs']['label_input'] ?>
        <? if ($this->data['attrs']['required']): ?>
            <span class="rn_Required"> <?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015)) ?></span>
        <? endif;
?>
        <? if ($this->data['attrs']['hint']): ?>
            <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
        </label>
    </div>
<? endif;
?>
<? if ($this->data['displayType'] === 'Textarea'): ?>
    <textarea id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" class="rn_TextArea" rows="7" cols="60" name="<?= $this->data['inputName'] ?>" <?= $this->outputconstraints();
?>><?= $this->data['value'] ?></textarea>
<? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
    <span class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
<? endif;
?>
<? else: ?>
    <input type="<?=$this->data['inputType']?>" id="rn_<?=$this->instanceID?>_<?=$this->data['js']['name']?>" name="<?= $this->data['inputName'] ?>" class="rn_<?=$this->data['displayType']?>" <?=$this->outputconstraints();?> <?if($this->data['value']
!== null && $this->data['value'] !== '') echo "value='{$this->data['value']}'";?> />
<?
if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
    <span class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
<? endif;
?>
    <? if ($this->data['attrs']['require_validation']): ?>
    <div class="rn_TextInputValidate">
        <div id="rn_<?= $this->instanceID ?>_LabelValidateContainer">
            <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Validate" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_LabelValidate" class="rn_Label"><?printf($this->data['attrs']['label_validation'], $this->data['attrs']['label_input']) ?>
            <? if ($this->data['attrs']['required']): ?>
                <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015)) ?></span>
            <? endif;
?>
            </label>
        </div>
        <input type="<?= $this->data['inputType'] ?>" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Validate" name="<?= $this->data['inputName'] ?>_Validation" class="rn_<?=$this->data['displayType']?> rn_Validation" <?= $this->outputconstraints();
?> value="<?= $this->data['value'] ?>"/>
    </div>
   <? endif;
?>
<? endif;
?>
</div>
</div>
<? endif;
?><? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
return parent::getData();
}
}
function _custom_input_CustomTextInput_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.CustomTextInput', 'library_name' => 'CustomTextInput', 'view_func_name' => '_custom_input_CustomTextInput_view', 'meta' => array ( 'controller_path' => 'custom/input/CustomTextInput', 'view_path' => 'custom/input/CustomTextInput', 'js_path' => 'custom/input/CustomTextInput', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/CustomTextInput.css', ), 'base_css' => array ( 0 => 'custom/input/CustomTextInput/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/input/TextInput', 'components' => array ( 'php' => true, 'view' => true, 'js' => true, ), ), 'relativePath' => 'custom/input/CustomTextInput', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/TextInput', ), 'view' => array ( 0 => 'standard/input/TextInput', ), 'logic' => array ( 0 => 'standard/input/TextInput', ), 'js_templates' => array ( 0 => array ( 'label' => '<% if (label) { %> <rn:block id="preLabel"/> <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %> <rn:block id="preRequired"/> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <rn:block id="postRequired"/> <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <rn:block id="postLabel"/><% } %>', 'labelValidate' => '<rn:block id="preValidateLabel"/><label for="rn_<%= instanceID %>_<%= fieldName %>_Validate" id="rn_<%= instanceID %>_<%= fieldName %>_LabelValidate" class="rn_Label"><%= label %><% if (required) { %> <rn:block id="preValidateRequired"/> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <rn:block id="postValidateRequired"/><% } %></label><rn:block id="postValidateLabel"/>', ), ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/input/TextInput', ), 'widget_name' => 'CustomTextInput', 'extends_php' => array ( 0 => 'standard/input/TextInput', ), 'extends_js' => array ( 0 => 'standard/input/TextInput', ), 'extends_view' => array ( 0 => 'standard/input/TextInput', ), 'parent' => 'standard/input/TextInput', 'js_templates' => array ( 'label' => '<% if (label) { %>  <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <% } %>', 'labelValidate' => '<label for="rn_<%= instanceID %>_<%= fieldName %>_Validate" id="rn_<%= instanceID %>_<%= fieldName %>_LabelValidate" class="rn_Label"><%= label %><% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <% } %></label>', ), ), );
$result['meta']['attributes'] = array( 'always_show' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'display_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'hideon_notequal_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'hideon_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => true, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => true, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => true, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'always_show_mask' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'boolean', 'default' => true, 'inherited' => true, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'existing_contact_check_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/checkForExistingContact', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/checkForExistingContact', 'inherited' => true, )), 'require_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'maximum_length' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'int', 'default' => 0, 'min' => 0, 'inherited' => true, )), 'minimum_length' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'int', 'default' => 0, 'min' => 0, 'inherited' => true, )), 'maximum_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'int', 'default' => null, 'inherited' => true, )), 'minimum_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'int', 'default' => null, 'inherited' => true, )), 'label_validation_incorrect' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1671), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(1671), 'inherited' => true, )), 'label_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3358), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3358), 'inherited' => true, )), 'textarea' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), );
return $result;
}
}
namespace Custom\Widgets\input{
class ToggleVisibleArea extends \RightNow\Widgets\TextInput {
function _custom_input_ToggleVisibleArea_view ($data) {
extract($data);
?><?php ?>
<? if ($this->data['readOnly']): ?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/FieldDisplay', array('left_justify' => 'true',));
?>
<? else: ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<? if (1===2) {
?>
<? if ($this->data['attrs']['label_input']): ?>
    <div id="rn_<?= $this->instanceID ?>_LabelContainer">
        <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" id="rn_<?= $this->instanceID ?>_Label" class="rn_Label">
        <?= $this->data['attrs']['label_input'] ?>
        <? if ($this->data['attrs']['required']): ?>
            <span class="rn_Required"> <?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015)) ?></span>
        <? endif;
?>
        <? if ($this->data['attrs']['hint']): ?>
            <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
        </label>
    </div>
<? endif;
?>
<? if ($this->data['displayType'] === 'Textarea'): ?>
    <textarea id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" class="rn_TextArea" rows="7" cols="60" name="<?= $this->data['inputName'] ?>" <?= $this->outputconstraints();
?>><?= $this->data['value'] ?></textarea>
<? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
    <span class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
<? endif;
?>
<? else: ?>
    <input type="<?=$this->data['inputType']?>" id="rn_<?=$this->instanceID?>_<?=$this->data['js']['name']?>" name="<?= $this->data['inputName'] ?>" class="rn_<?=$this->data['displayType']?>" <?=$this->outputconstraints();?> <?if($this->data['value']
!== null && $this->data['value'] !== '') echo "value='{$this->data['value']}'";?> />
<?
if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
    <span class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
<? endif;
?>
    <? if ($this->data['attrs']['require_validation']): ?>
    <div class="rn_TextInputValidate">
        <div id="rn_<?= $this->instanceID ?>_LabelValidateContainer">
            <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Validate" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_LabelValidate" class="rn_Label"><?printf($this->data['attrs']['label_validation'], $this->data['attrs']['label_input']) ?>
            <? if ($this->data['attrs']['required']): ?>
                <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015)) ?></span>
            <? endif;
?>
            </label>
        </div>
        <input type="<?= $this->data['inputType'] ?>" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Validate" name="<?= $this->data['inputName'] ?>_Validation" class="rn_<?=$this->data['displayType']?> rn_Validation" <?= $this->outputconstraints();
?> value="<?= $this->data['value'] ?>"/>
    </div>
   <? endif;
?>
<? endif;
?>
<? }
else {
?>
<div id="rn_<?=$this->instanceID;?>_child" class="rn_Hidden" >
<p class="fontGotham size5"><?
echo($this->data['attrs']['label']);
?></p>
</div>
<? }
?>
</div>
<? endif;
?><? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
}
}
function _custom_input_ToggleVisibleArea_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.ToggleVisibleArea', 'library_name' => 'ToggleVisibleArea', 'view_func_name' => '_custom_input_ToggleVisibleArea_view', 'meta' => array ( 'controller_path' => 'custom/input/ToggleVisibleArea', 'view_path' => 'custom/input/ToggleVisibleArea', 'js_path' => 'custom/input/ToggleVisibleArea', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ToggleVisibleArea.css', ), 'base_css' => array ( 0 => 'custom/input/ToggleVisibleArea/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/input/TextInput', 'components' => array ( 'php' => true, 'view' => true, 'js' => true, 'css' => true, ), ), 'relativePath' => 'custom/input/ToggleVisibleArea', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/TextInput', ), 'view' => array ( 0 => 'standard/input/TextInput', ), 'logic' => array ( 0 => 'standard/input/TextInput', ), 'js_templates' => array ( 0 => array ( 'label' => '<% if (label) { %> <rn:block id="preLabel"/> <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %> <rn:block id="preRequired"/> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <rn:block id="postRequired"/> <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <rn:block id="postLabel"/><% } %>', 'labelValidate' => '<rn:block id="preValidateLabel"/><label for="rn_<%= instanceID %>_<%= fieldName %>_Validate" id="rn_<%= instanceID %>_<%= fieldName %>_LabelValidate" class="rn_Label"><%= label %><% if (required) { %> <rn:block id="preValidateRequired"/> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <rn:block id="postValidateRequired"/><% } %></label><rn:block id="postValidateLabel"/>', ), ), 'base_css' => array ( 0 => 'standard/input/TextInput/base.css', ), 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/TextInput.css', 1 => 'assets/themes/mobile/widgetCss/TextInput.css', ), 'parent' => 'standard/input/TextInput', ), 'widget_name' => 'ToggleVisibleArea', 'extends_php' => array ( 0 => 'standard/input/TextInput', ), 'extends_js' => array ( 0 => 'standard/input/TextInput', ), 'extends_view' => array ( 0 => 'standard/input/TextInput', ), 'parent' => 'standard/input/TextInput', 'js_templates' => array ( 'label' => '<% if (label) { %>  <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <% } %>', 'labelValidate' => '<label for="rn_<%= instanceID %>_<%= fieldName %>_Validate" id="rn_<%= instanceID %>_<%= fieldName %>_LabelValidate" class="rn_Label"><%= label %><% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <% } %></label>', ), ), );
$result['meta']['attributes'] = array( 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'display_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'toggle_div_name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'hideon_notequal_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => true, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => true, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => true, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'always_show_mask' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'boolean', 'default' => true, 'inherited' => true, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'existing_contact_check_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/checkForExistingContact', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/checkForExistingContact', 'inherited' => true, )), 'require_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'maximum_length' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'int', 'default' => 0, 'min' => 0, 'inherited' => true, )), 'minimum_length' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'int', 'default' => 0, 'min' => 0, 'inherited' => true, )), 'maximum_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'int', 'default' => null, 'inherited' => true, )), 'minimum_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'int', 'default' => null, 'inherited' => true, )), 'label_validation_incorrect' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1671), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(1671), 'inherited' => true, )), 'label_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3358), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3358), 'inherited' => true, )), 'textarea' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), );
return $result;
}
}
namespace Custom\Widgets\input{
class CustomSelectionInput extends \RightNow\Widgets\SelectionInput {
function _custom_input_CustomSelectionInput_view ($data) {
extract($data);
?><?php ?>
<? if ($this->data['readOnly']): ?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/FieldDisplay', array('left_justify' => 'true',));
?>
<? else: ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<div id="rn_<?= $this->instanceID ?>_child" class="<?= $this->classList ?> <? if(!$this->data['attrs']['always_show']): echo('rn_Hidden');
endif;?>">
<?
if ($this->data['attrs']['label_input'] && $this->data['displayType'] !== 'Radio'): ?>
    <div id="rn_<?= $this->instanceID ?>_LabelContainer">
        <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" id="rn_<?= $this->instanceID ?>_Label" class="rn_Label"><?= $this->data['attrs']['label_input'] ?>
        <? if ($this->data['attrs']['required']): ?>
            <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015))?></span>
        <? endif;
?>
        <? if ($this->data['attrs']['hint']): ?>
            <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
        </label>
    </div>
<? endif;
?>
<? if ($this->data['displayType'] === 'Select'): ?>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" name="<?= $this->data['inputName'] ?>">
    <? if (!$this->data['hideEmptyOption']): ?>
        <option value="">--</option>
    <? endif;
?>
    <? if (is_array($this->data['menuItems'])): ?>
        <? foreach ($this->data['menuItems'] as $key => $item): ?>
            <option value="<?= $key ?>" <?= $this->outputselected($key) ?>><?=\RightNow\Utils\Text::escapeHtml($item);?></option>
        <?
endforeach;
?>
    <? endif;
?>
    </select>
    <? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
        <span id="rn_<?= $this->instanceID ?>_Hint" class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
    <? endif;
?>
<? else: ?>
    <? if ($this->data['displayType'] === 'Checkbox'): ?>
        <input type="checkbox" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" name="<?= $this->data['inputName'] ?>" <?= $this->outputchecked(1) ?> value="1"/>
        <? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
            <span id="rn_<?= $this->instanceID ?>_Hint" class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
    <? else: ?>
        <fieldset>
        <? if ($this->data['attrs']['label_input']): ?>
            <legend id="rn_<?= $this->instanceID ?>_Label" class="rn_Label">
                <?= $this->data['attrs']['label_input'] ?>
                <? if ($this->data['attrs']['required']): ?>
                    <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015))?></span>
                <? endif;
?>
            </legend>
        <? endif;
?>
        <? for($i = 1;
$i >= 0;
$i--): $id = "rn_{$this->instanceID}_{$this->data['js']['name']}_$i";
?>
            <input type="radio" name="<?= $this->data['inputName']?>" id="<?= $id ?>" <?= $this->outputchecked($i) ?> value="<?= $i ?>"/>
            <label for="<?= $id ?>">
            <?= $this->data['radioLabel'][$i] ?>
            <? if ($this->data['attrs']['hint'] && $i === 1): ?>
                <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
            <? endif;
?>
            </label>
        <? endfor;
?>
        <? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
            <span id="rn_<?= $this->instanceID ?>_Hint"  class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
        <? endif;
?>
        </fieldset>
    <?endif;
?>
<? endif;
?>
</div>
</div>
<? endif;
?>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
return parent::getData();
}
}
function _custom_input_CustomSelectionInput_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.CustomSelectionInput', 'library_name' => 'CustomSelectionInput', 'view_func_name' => '_custom_input_CustomSelectionInput_view', 'meta' => array ( 'controller_path' => 'custom/input/CustomSelectionInput', 'view_path' => 'custom/input/CustomSelectionInput', 'js_path' => 'custom/input/CustomSelectionInput', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/CustomSelectionInput.css', ), 'base_css' => array ( 0 => 'custom/input/CustomSelectionInput/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/input/SelectionInput', 'components' => array ( 'php' => true, 'view' => true, 'js' => true, 'css' => true, ), ), 'relativePath' => 'custom/input/CustomSelectionInput', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/SelectionInput', ), 'view' => array ( 0 => 'standard/input/SelectionInput', ), 'logic' => array ( 0 => 'standard/input/SelectionInput', ), 'js_templates' => array ( 0 => array ( 'label' => '<% if (label) { %> <rn:block id="preLabel"/> <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %> <rn:block id="preRequired"/> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <rn:block id="postRequired"/> <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <rn:block id="postLabel"/><% } %>', 'legend' => '<% if (label) { %> <rn:block id="preLabel"/> <%= label %> <% if (required) { %> <rn:block id="preRequired"/> <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <rn:block id="postRequired"/> <% } %> <rn:block id="postLabel"/><% } %>', ), ), 'base_css' => array ( 0 => 'standard/input/SelectionInput/base.css', ), 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/SelectionInput.css', 1 => 'assets/themes/mobile/widgetCss/SelectionInput.css', ), 'parent' => 'standard/input/SelectionInput', ), 'widget_name' => 'CustomSelectionInput', 'extends_php' => array ( 0 => 'standard/input/SelectionInput', ), 'extends_js' => array ( 0 => 'standard/input/SelectionInput', ), 'extends_view' => array ( 0 => 'standard/input/SelectionInput', ), 'parent' => 'standard/input/SelectionInput', 'js_templates' => array ( 'label' => '<% if (label) { %>  <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <% } %>', 'legend' => '<% if (label) { %>  <%= label %> <% if (required) { %>  <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% } %>', ), ), );
$result['meta']['attributes'] = array( 'display_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'always_show' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'trigger_change_event' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => true, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => true, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => true, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'display_as_checkbox' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Config, RightNow\Connect\v1_2 as Connect;
class DateInput extends \RightNow\Libraries\Widget\Input {
function _standard_input_DateInput_view ($data) {
extract($data);
?><?php ?>
<? if ($this->data['readOnly']): ?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/FieldDisplay', array('left_justify' => 'true',));
?>
<? else: ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<fieldset>
<? if ($this->data['attrs']['label_input']): ?>
    <legend id="rn_<?= $this->instanceID ?>_Legend" class="rn_Label"><?= $this->data['attrs']['label_input'] ?>
        <? if ($this->data['attrs']['required']): ?>
            <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015))?></span>
        <? endif;
?>
    </legend>
<? endif;
?>
<? if ($this->data['attrs']['hint']): ?>
    <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
<? endif;
?>
<? for ($i = 0;
$i < 3;
$i++): ?>
    <? ?>
    <? if ($this->data['yearOrder'] === $i): ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Year" class="rn_ScreenReaderOnly"><?= $this->data['yearLabel']?></label>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Year" name="<?= $this->data['inputName'] ?>.year">
        <option value=''>--</option>
        <? for ($j = $this->data['attrs']['max_year'];
$j >= $this->data['attrs']['min_year'];
$j--): ?>
        <option value="<?= $j ?>" <?= $this->outputselected(2, $j) ?>><?= $j ?></option>
        <? endfor;
?>
    </select>
    <? ?>
    <? elseif ($this->data['monthOrder'] === $i): ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Month" class="rn_ScreenReaderOnly"><?= $this->data['monthLabel'] ?></label>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Month" name="<?= $this->data['inputName']?>.month">
        <option value=''>--</option>
        <? for ($j = 1;
$j < 13;
$j++): ?>
        <option value="<?= $j ?>" <?= $this->outputselected(0, $j) ?>><?= $j ?></option>
        <? endfor;
?>
    </select>
    <? ?>
    <? else: ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Day" class="rn_ScreenReaderOnly"><?= $this->data['dayLabel'] ?></label>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Day" name="<?= $this->data['inputName']?>.day">
        <option value=''>--</option>
        <? for ($j = 1;
$j < 32;
$j++): ?>
        <option value="<?= $j ?>" <?= $this->outputselected(1, $j) ?>><?= $j ?></option>
        <? endfor;
?>
    </select>
    <? endif;
?>
<? endfor;
?>
<? if ($this->data['displayType'] === 'DateTime'): ?>
    <? ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Hour" class="rn_ScreenReaderOnly"><?= $this->data['hourLabel'] ?></label>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Hour" name="<?= $this->data['inputName']?>.hour">
        <option value=''>--</option>
        <? for ($j = 0;
$j < 24;
$j++): ?>
        <option value="<?= $j ?>" <?= $this->outputselected(3, $j) ?>><?= $j ?></option>
        <? endfor;
?>
    </select>
    <? ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Minute" class="rn_ScreenReaderOnly"><?= $this->data['minuteLabel'] ?></label>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Minute" name="<?= $this->data['inputName']?>.minute">
        <option value=''>--</option>
        <? for ($j = 0;
$j < 60;
$j++): ?>
        <option value="<?= $j ?>" <?= $this->outputselected(4, $j) ?>><?= $j ?></option>
        <? endfor;
?>
    </select>
<? endif;
?>
<? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
    <span class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
<? endif;
?>
</fieldset>
</div>
<? endif;
?>
<? }
protected $minDateConstraint = 86400;
protected $maxDateConstraint = 2147385599;
function __construct($attrs) {
if ($attrs['max_year']) {
try {
$maxYear = $attrs['max_year']->default = Config::getMaxYear();
}
catch (\Exception $e) {
echo $this->reportError($e->getMessage());
$maxYear = $attrs['max_year']->default = date('Y');
}
if (!$attrs['max_year']->value && !$attrs['default_value']->value) {
$attrs['max_year']->value = $maxYear;
}
}
parent::__construct($attrs);
}
function getData() {
if (parent::getData() === false) {
return false;
}
if (!in_array($this->dataType, array('Date', 'DateTime'))) {
echo $this->reportError(sprintf(Config::getMessage((3008)), $this->fieldName));
return false;
}
$this->data['displayType'] = $this->dataType;
$minYear = $this->data['attrs']['min_year'];
$maxYear = $this->data['attrs']['max_year'];
$constraints = $this->getConstraints($this->getMetaConstraints());
if (array_key_exists('min', $constraints) && ($parts = explode('-', $constraints['min'])) && ($minConstraintYear = intval($parts[0])) && $minYear < $minConstraintYear) {
$minYear = $this->data['attrs']['min_year'] = $minConstraintYear;
$this->reportError(sprintf(Config::getMessage((43902)), $this->fieldName, $minYear), false);
}
$min = $this->data['js']['min'] = $this->getDateArray($minYear ?: Config::getMinYear(), $constraints['min'], 'min');
$max = $this->getDateArray($maxYear ?: Config::getMaxYear(), $constraints['max'], 'max');
if (!$this->data['readOnly']) {
$this->data['constraints']['minValue'] = strtotime($min['date']);
$this->data['constraints']['maxValue'] = strtotime($max['date']);
}
$this->data['dayLabel'] = Config::getMessage((50));
$this->data['monthLabel'] = Config::getMessage((54));
$this->data['yearLabel'] = Config::getMessage((58));
$this->data['hourLabel'] = Config::getMessage((48));
$this->data['minuteLabel'] = Config::getMessage((46));
list($this->data['monthOrder'], $this->data['dayOrder'], $this->data['yearOrder'], $this->data['js']['min_val'] ) = $this->getOrderParameters($min, Config::getConfig((109)), $this->dataType === 'DateTime');
if($this->data['value']) {
$this->data['value'] = explode(' ', date('m j Y G i', intval($this->data['value'])));
$this->data['defaultValue'] = true;
}
}
public function outputSelected($index, $itemIndex) {
if (is_array($this->data['value']) && intval($this->data['value'][$index]) === $itemIndex) {
return 'selected="selected"';
}
}
protected function getConstraints(array $constraints) {
$useDefines = $constraints['min'] === $this->minDateConstraint && $constraints['max'] === $this->maxDateConstraint;
$toDate = function($type, $constraint) use ($useDefines) {
return ($useDefines || $constraint === null) ? ($type === 'min' ? "1970-01-03 00:00:00" : "2100-12-31 23:59:59") : gmdate('Y-m-d H:i:s', $constraint);
};
return array( 'min' => $toDate('min', $constraints['min']), 'max' => $toDate('max', $constraints['max']), );
}
protected function getMetaConstraints() {
$constraints = array();
$meta = $this->fieldMetaData->constraints ?: array();
foreach ($meta as $constraint) {
if ($constraint->kind === Connect\Constraint::Min) {
$constraints['min'] = $constraint->value;
}
else if ($constraint->kind === Connect\Constraint::Max) {
$constraints['max'] = $constraint->value;
}
}
return $constraints;
}
protected function getDateArray($year, $date, $type = 'max') {
list($yearMonthDay, $time) = explode(' ', $date);
list($constraintYear, $month, $day) = explode('-', $yearMonthDay);
if ($type === 'min' && $constraintYear < $year) {
$month = $day = 1;
}
else {
$month = intval($month, 10);
$day = intval($day, 10);
}
return array( 'year' => $year, 'month' => $month, 'day' => $day, 'hour' => intval(\RightNow\Utils\Text::getSubstringBefore($time, ':')), 'time' => $time, 'date' => "{$year}-{$month}-{$day} {$time}",
);
}
private function getOrderParameters(array $min, $dateOrder, $addTime = true) {
if ($dateOrder == 0) {
$orderData = array(0, 1, 2, "{$min['month']}/{$min['day']}/{$min['year']}");
}
else if ($dateOrder == 1) {
$orderData = array(1, 2, 0, "{$min['year']}/{$min['month']}/{$min['day']}");
}
else {
$orderData = array(1, 0, 2, "{$min['day']}/{$min['month']}/{$min['year']}");
}
if ($addTime) {
$orderData[3] .= " {$min['time']}";
}
return $orderData;
}
}
function _standard_input_DateInput_header() {
$result = array( 'js_name' => 'RightNow.Widgets.DateInput', 'library_name' => 'DateInput', 'view_func_name' => '_standard_input_DateInput_view', 'meta' => array ( 'controller_path' => 'standard/input/DateInput', 'view_path' => 'standard/input/DateInput', 'js_path' => 'standard/input/DateInput', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/DateInput.css', 1 => 'assets/themes/mobile/widgetCss/DateInput.css', ), 'base_css' => array ( 0 => 'standard/input/DateInput/base.css', ), 'js_templates' => array ( 'legend' => '<% if (label) { %>  <%= label %> <% if (required) { %>  <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% } %>', ), 'template_path' => 'standard/input/DateInput', 'version' => '1.4.2', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4195)', ), 'contains' => array ( 0 => array ( 'widget' => 'standard/output/FieldDisplay', 'versions' => array ( 0 => '1.1', ), ), ), 'relativePath' => 'standard/input/DateInput', 'widget_name' => 'DateInput', ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => false, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => false, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'min_year' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 1970, 'type' => 'int', 'default' => 1970, 'min' => 1902, 'max' => 2100, 'inherited' => false, )), 'max_year' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'int', 'default' => null, 'min' => 1902, 'max' => 2100, 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace Custom\Widgets\input{
class CustomDateInput extends \RightNow\Widgets\DateInput {
function _custom_input_CustomDateInput_view ($data) {
extract($data);
?><?php ?>
<? if ($this->data['readOnly']): ?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/FieldDisplay', array('left_justify' => 'true',));
?>
<? else: ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<div id="rn_<?=$this->instanceID;?>_child" class="<?=
$this->classList ?><? if(!$this->data['attrs']['always_show']): echo(' rn_Hidden');
endif;?>" >
<fieldset>
<?
if ($this->data['attrs']['label_input']): ?>
    <legend id="rn_<?= $this->instanceID ?>_Legend" class="rn_Label"><?= $this->data['attrs']['label_input'] ?>
        <? if ($this->data['attrs']['required']): ?>
            <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015))?></span>
        <? endif;
?>
    </legend>
<? endif;
?>
<? if ($this->data['attrs']['hint']): ?>
    <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
<? endif;
?>
<? for ($i = 0;
$i < 3;
$i++): ?>
    <? ?>
    <? if ($this->data['yearOrder'] === $i): ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Year" class="rn_ScreenReaderOnly"><?= $this->data['yearLabel']?></label>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Year" name="<?= $this->data['inputName'] ?>.year">
        <option value=''>--</option>
        <? for ($j = $this->data['attrs']['max_year'];
$j >= $this->data['attrs']['min_year'];
$j--): ?>
        <option value="<?= $j ?>" <?= $this->outputselected(2, $j) ?>><?= $j ?></option>
        <? endfor;
?>
    </select>
    <? ?>
    <? elseif ($this->data['monthOrder'] === $i): ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Month" class="rn_ScreenReaderOnly"><?= $this->data['monthLabel'] ?></label>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Month" name="<?= $this->data['inputName']?>.month">
        <option value=''>--</option>
        <? for ($j = 1;
$j < 13;
$j++): ?>
        <option value="<?= $j ?>" <?= $this->outputselected(0, $j) ?>><?= $j ?></option>
        <? endfor;
?>
    </select>
    <? ?>
    <? else: ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Day" class="rn_ScreenReaderOnly"><?= $this->data['dayLabel'] ?></label>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Day" name="<?= $this->data['inputName']?>.day">
        <option value=''>--</option>
        <? for ($j = 1;
$j < 32;
$j++): ?>
        <option value="<?= $j ?>" <?= $this->outputselected(1, $j) ?>><?= $j ?></option>
        <? endfor;
?>
    </select>
    <? endif;
?>
<? endfor;
?>
<? if ($this->data['displayType'] === 'DateTime'): ?>
    <? ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Hour" class="rn_ScreenReaderOnly"><?= $this->data['hourLabel'] ?></label>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Hour" name="<?= $this->data['inputName']?>.hour">
        <option value=''>--</option>
        <? for ($j = 0;
$j < 24;
$j++): ?>
        <option value="<?= $j ?>" <?= $this->outputselected(3, $j) ?>><?= $j ?></option>
        <? endfor;
?>
    </select>
    <? ?>
    <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Minute" class="rn_ScreenReaderOnly"><?= $this->data['minuteLabel'] ?></label>
    <select id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Minute" name="<?= $this->data['inputName']?>.minute">
        <option value=''>--</option>
        <? for ($j = 0;
$j < 60;
$j++): ?>
        <option value="<?= $j ?>" <?= $this->outputselected(4, $j) ?>><?= $j ?></option>
        <? endfor;
?>
    </select>
<? endif;
?>
<? if ($this->data['attrs']['hint'] && $this->data['attrs']['always_show_hint']): ?>
    <span class="rn_HintText"><?= $this->data['attrs']['hint'] ?></span>
<? endif;
?>
</fieldset>
</div>
</div>
<? endif;
?>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
return parent::getData();
}
}
function _custom_input_CustomDateInput_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.CustomDateInput', 'library_name' => 'CustomDateInput', 'view_func_name' => '_custom_input_CustomDateInput_view', 'meta' => array ( 'controller_path' => 'custom/input/CustomDateInput', 'view_path' => 'custom/input/CustomDateInput', 'js_path' => 'custom/input/CustomDateInput', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/CustomDateInput.css', ), 'base_css' => array ( 0 => 'custom/input/CustomDateInput/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/input/DateInput', 'components' => array ( 'php' => true, 'view' => true, 'js' => true, ), ), 'relativePath' => 'custom/input/CustomDateInput', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/DateInput', ), 'view' => array ( 0 => 'standard/input/DateInput', ), 'logic' => array ( 0 => 'standard/input/DateInput', ), 'js_templates' => array ( 0 => array ( 'legend' => '<% if (label) { %> <rn:block id="legendTop"/> <%= label %> <% if (required) { %> <rn:block id="preRequired"/> <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <rn:block id="postRequired"/> <% } %> <rn:block id="legendBottom"/><% } %>', ), ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/input/DateInput', ), 'widget_name' => 'CustomDateInput', 'extends_php' => array ( 0 => 'standard/input/DateInput', ), 'extends_js' => array ( 0 => 'standard/input/DateInput', ), 'extends_view' => array ( 0 => 'standard/input/DateInput', ), 'parent' => 'standard/input/DateInput', 'js_templates' => array ( 'legend' => '<% if (label) { %>  <%= label %> <% if (required) { %>  <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% } %>', ), ), );
$result['meta']['attributes'] = array( 'display_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'always_show' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => true, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => true, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => true, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'min_year' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 1970, 'type' => 'int', 'default' => 1970, 'min' => 1902, 'max' => 2100, 'inherited' => true, )), 'max_year' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'int', 'default' => null, 'min' => 1902, 'max' => 2100, 'inherited' => true, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
class FileAttachmentUpload extends \RightNow\Libraries\Widget\Input {
function _standard_input_FileAttachmentUpload_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <div id="rn_<?= $this->instanceID ?>_LabelContainer">
        <label for="rn_<?=$this->instanceID;?>_FileInput" id="rn_<?=$this->instanceID;?>_Label"><?=$this->data['attrs']['label_input'];?>
        <?
if($this->data['attrs']['min_required_attachments'] > 0):?>
            <span class="rn_Required"> <?=\RightNow\Utils\Config::getMessage((1908));?> </span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage((7015))?></span>
        <?
endif;?>
        </label>
    </div>
    <input name="file" id="rn_<?=$this->instanceID;?>_FileInput" type="file"/>
    <?
if($this->data['attrs']['loading_icon_path']):?>
    <img id="rn_<?=$this->instanceID;?>_LoadingIcon" class="rn_Hidden" alt="" src="<?=$this->data['attrs']['loading_icon_path'];?>" />
    <?
endif;?>
    <span id="rn_<?=$this->instanceID;?>_StatusMessage"></span>
</div>
<?
}
function __construct($attrs){
parent::__construct($attrs);
}
function getData(){
$this->data['js']['name'] = $this->data['attrs']['name'] = "Incident.FileAttachments";
if (parent::getData() === false) return false;
if($incident = $this->CI->model('Incident')->get(\RightNow\Utils\Url::getParameter('i_id'))->result) {
$this->data['js']['attachmentCount'] = ($incident->FileAttachments) ? count($incident->FileAttachments) : 0;
}
if($this->data['attrs']['max_attachments'] !== 0 && $this->data['attrs']['min_required_attachments'] > $this->data['attrs']['max_attachments']) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((3050)), 'min_required_attachments', 'max_attachments'));
return false;
}
}
}
function _standard_input_FileAttachmentUpload_header() {
$result = array( 'js_name' => 'RightNow.Widgets.FileAttachmentUpload', 'library_name' => 'FileAttachmentUpload', 'view_func_name' => '_standard_input_FileAttachmentUpload_view', 'meta' => array ( 'controller_path' => 'standard/input/FileAttachmentUpload', 'view_path' => 'standard/input/FileAttachmentUpload', 'js_path' => 'standard/input/FileAttachmentUpload', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/FileAttachmentUpload.css', 1 => 'assets/themes/mobile/widgetCss/FileAttachmentUpload.css', ), 'base_css' => array ( 0 => 'standard/input/FileAttachmentUpload/base.css', ), 'js_templates' => array ( 'attachmentItem' => '<li id="<%= id %>">  <% if (displayThumbnail) { %>  <span class="rn_Thumbnail"></span>  <% } %>  <%= name %>   <a href=\'javascript:void(0)\' class=\'rn_fileRemove\'><%= attrs.label_remove %><span class=\'rn_ScreenReaderOnly\'><%= name %></span></a>  </li>', 'error' => '<div data-field="<%= fieldName %>">  <b><a href=\'javascript:void(0);\' onclick=\'document.getElementById("<%= id %>").focus(); return false;\'><%= errorLink %></a></b> </div>', 'label' => '<label for="rn_<%= instanceID %>_FileInput" id="rn_<%= instanceID %>_Label"><%= label %><% if(minAttachments) { %> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span><% } %></label>', 'maxMessage' => '<li>  <%= maxMessage %> </li>', ), 'template_path' => 'standard/input/FileAttachmentUpload', 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4226)', 'urlParameters' => array ( 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2167)', 'example' => 'i_id/7', ), ), ), 'relativePath' => 'standard/input/FileAttachmentUpload', 'widget_name' => 'FileAttachmentUpload', ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4480), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4480), 'inherited' => false, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_remove' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(6896), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(6896), 'inherited' => false, )), 'max_attachments' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => false, )), 'label_max_attachment_limit' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3336), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3336), 'inherited' => false, )), 'label_generic_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1941), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1941), 'inherited' => false, )), 'label_still_uploading_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43242), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(43242), 'inherited' => false, )), 'loading_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/indicator.gif', 'type' => 'FILEPATH', 'default' => 'images/indicator.gif', 'inherited' => false, )), 'min_required_attachments' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => false, )), 'label_min_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(18887), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(18887), 'inherited' => false, )), 'valid_file_extensions' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_invalid_extension' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2004), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2004), 'inherited' => false, )), 'display_thumbnail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'max_thumbnail_height' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 100, 'type' => 'INT', 'default' => 100, 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Framework, RightNow\Utils\Text, RightNow\Utils\Url;
class FormSubmit extends \RightNow\Libraries\Widget\Base {
function _standard_input_FormSubmit_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
    <input type="submit" id="rn_<?= $this->instanceID ?>_Button" value="<?= $this->data['attrs']['label_button'] ?>" disabled />
<? if ($this->data['attrs']['loading_icon_path']): ?>
    <img id="rn_<?= $this->instanceID ?>_LoadingIcon" class="rn_Hidden" alt="<?= \RightNow\Utils\Config::getMessage((24544)) ?>" src="<?= $this->data['attrs']['loading_icon_path'] ?>"/>
<? endif;
?>
<? if ($this->data['attrs']['label_submitting_message']): ?>
    <span id="rn_<?= $this->instanceID ?>_StatusMessage" class="rn_Hidden"><?= $this->data['attrs']['label_submitting_message'] ?></span>
<? endif;
?>
    <span class="rn_Hidden">
        <input id="rn_<?= $this->instanceID ?>_Submission" type="checkbox" class="rn_Hidden"/>
        <label for="rn_<?= $this->instanceID ?>_Submission" class="rn_Hidden">&nbsp;</label>
    </span>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if (Framework::isLoggedIn()) {
$idleLength = $this->CI->session->getProfileCookieLength();
if ($idleLength === 0) $idleLength = PHP_INT_MAX;
}
else {
$idleLength = $this->CI->session->getSessionIdleLength();
}
$this->data['js'] = array( 'f_tok' => Framework::createTokenWithExpiration(0, $this->data['attrs']['challenge_required']), 'formExpiration' => 1000 * (min(60 * \RightNow\Utils\Config::getConfig((204)), $idleLength) - 300) );
if ($this->data['attrs']['challenge_required'] && $this->data['attrs']['challenge_location']) {
$this->data['js']['challengeProvider'] = \RightNow\Libraries\AbuseDetection::getChallengeProvider();
}
$this->data['attrs']['add_params_to_url'] = Url::getParametersFromList($this->data['attrs']['add_params_to_url']);
if ($redirect = Url::getParameter('redirect')) {
$redirectLocation = urldecode(urldecode($redirect));
$parsedURL = parse_url($redirectLocation);
if (!$parsedURL['scheme'] && !Text::beginsWith($parsedURL['path'], '/ci/') && !Text::beginsWith($parsedURL['path'], '/cc/') && !Text::beginsWith($redirectLocation, '/app/')) {
$redirectLocation = "/app/$redirectLocation";
}
$this->data['attrs']['on_success_url'] = $redirectLocation;
}
}
}
function _standard_input_FormSubmit_header() {
$result = array( 'js_name' => 'RightNow.Widgets.FormSubmit', 'library_name' => 'FormSubmit', 'view_func_name' => '_standard_input_FormSubmit_view', 'meta' => array ( 'controller_path' => 'standard/input/FormSubmit', 'view_path' => 'standard/input/FormSubmit', 'js_path' => 'standard/input/FormSubmit', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/FormSubmit.css', 1 => 'assets/themes/mobile/widgetCss/FormSubmit.css', ), 'base_css' => array ( 0 => 'standard/input/FormSubmit/base.css', ), 'version' => '1.2.2', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4186)', ), 'relativePath' => 'standard/input/FormSubmit', 'widget_name' => 'FormSubmit', ), );
$result['meta']['attributes'] = array( 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4550), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4550), 'inherited' => false, )), 'label_confirm_dialog' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_submitting_message' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3842), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3842), 'inherited' => false, )), 'on_success_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'loading_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/indicator.gif', 'type' => 'filepath', 'default' => 'images/indicator.gif', 'inherited' => false, )), 'error_location' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'challenge_location' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'challenge_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'timeout' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'min' => 0, 'inherited' => false, )), );
return $result;
}
}
namespace Custom\Widgets\input{
class CustomFormSubmit extends \RightNow\Widgets\FormSubmit {
function _custom_input_CustomFormSubmit_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<div id="rn_<?= $this->instanceID ?>_view" class="<?= $this->classList ?> rn_FormSubmit <? if(!$this->data['attrs']['always_show']): echo('rn_Hidden');
endif;?>">
    <input type="submit" id="rn_<?=
$this->instanceID ?>_Button" value="<?= $this->data['attrs']['label_button'] ?>" disabled />
<? if ($this->data['attrs']['loading_icon_path']): ?>
    <img id="rn_<?= $this->instanceID ?>_LoadingIcon" class="rn_Hidden" alt="<?= \RightNow\Utils\Config::getMessage((24544)) ?>" src="<?= $this->data['attrs']['loading_icon_path'] ?>"/>
<? endif;
?>
<? if ($this->data['attrs']['label_submitting_message']): ?>
    <span id="rn_<?= $this->instanceID ?>_StatusMessage" class="rn_Hidden"><?= $this->data['attrs']['label_submitting_message'] ?></span>
<? endif;
?>
    <span class="rn_Hidden">
        <input id="rn_<?= $this->instanceID ?>_Submission" type="checkbox" class="rn_Hidden"/>
        <label for="rn_<?= $this->instanceID ?>_Submission" class="rn_Hidden">&nbsp;</label>
    </span>
</div>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
return parent::getData();
}
}
function _custom_input_CustomFormSubmit_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.CustomFormSubmit', 'library_name' => 'CustomFormSubmit', 'view_func_name' => '_custom_input_CustomFormSubmit_view', 'meta' => array ( 'controller_path' => 'custom/input/CustomFormSubmit', 'view_path' => 'custom/input/CustomFormSubmit', 'js_path' => 'custom/input/CustomFormSubmit', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/CustomFormSubmit.css', ), 'base_css' => array ( 0 => 'custom/input/CustomFormSubmit/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/input/FormSubmit', 'components' => array ( 'php' => true, 'view' => true, 'js' => true, 'css' => true, ), ), 'relativePath' => 'custom/input/CustomFormSubmit', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/FormSubmit', ), 'view' => array ( 0 => 'standard/input/FormSubmit', ), 'logic' => array ( 0 => 'standard/input/FormSubmit', ), 'js_templates' => array ( ), 'base_css' => array ( 0 => 'standard/input/FormSubmit/base.css', ), 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/FormSubmit.css', 1 => 'assets/themes/mobile/widgetCss/FormSubmit.css', ), 'parent' => 'standard/input/FormSubmit', ), 'widget_name' => 'CustomFormSubmit', 'extends_php' => array ( 0 => 'standard/input/FormSubmit', ), 'extends_js' => array ( 0 => 'standard/input/FormSubmit', ), 'extends_view' => array ( 0 => 'standard/input/FormSubmit', ), 'parent' => 'standard/input/FormSubmit', ), );
$result['meta']['attributes'] = array( 'display_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'always_show' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hideon_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4550), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4550), 'inherited' => true, )), 'label_confirm_dialog' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'label_submitting_message' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3842), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3842), 'inherited' => true, )), 'on_success_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'loading_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/indicator.gif', 'type' => 'filepath', 'default' => 'images/indicator.gif', 'inherited' => true, )), 'error_location' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'challenge_location' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'challenge_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => true, )), 'timeout' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'min' => 0, 'inherited' => true, )), );
return $result;
}
}
namespace Custom\Widgets\input{
class CustomFileAttachmentUpload extends \RightNow\Widgets\FileAttachmentUpload {
function _custom_input_CustomFileAttachmentUpload_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
<div id="rn_<?=$this->instanceID;?>_child" class="<?=
$this->classList ?> <? if(!$this->data['attrs']['always_show']): echo('rn_Hidden');
endif;?>">
    <div id="rn_<?=
$this->instanceID ?>_LabelContainer">
        <label for="rn_<?=$this->instanceID;?>_FileInput" id="rn_<?=$this->instanceID;?>_Label"><?=$this->data['attrs']['label_input'];?>
        <?
if($this->data['attrs']['min_required_attachments'] > 0):?>
            <span class="rn_Required"> <?=\RightNow\Utils\Config::getMessage((1908));?> </span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage((7015))?></span>
        <?
endif;?>
        </label>
    </div>
    <input name="file" id="rn_<?=$this->instanceID;?>_FileInput" type="file"/>
    <?
if($this->data['attrs']['loading_icon_path']):?>
    <img id="rn_<?=$this->instanceID;?>_LoadingIcon" class="rn_Hidden" alt="" src="<?=$this->data['attrs']['loading_icon_path'];?>" />
    <?
endif;?>
    <span id="rn_<?=$this->instanceID;?>_StatusMessage"></span>
</div>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
return parent::getData();
}
}
function _custom_input_CustomFileAttachmentUpload_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.CustomFileAttachmentUpload', 'library_name' => 'CustomFileAttachmentUpload', 'view_func_name' => '_custom_input_CustomFileAttachmentUpload_view', 'meta' => array ( 'controller_path' => 'custom/input/CustomFileAttachmentUpload', 'view_path' => 'custom/input/CustomFileAttachmentUpload', 'js_path' => 'custom/input/CustomFileAttachmentUpload', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/CustomFileAttachmentUpload.css', ), 'base_css' => array ( 0 => 'custom/input/CustomFileAttachmentUpload/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/input/FileAttachmentUpload', 'components' => array ( 'php' => true, 'view' => true, 'js' => true, 'css' => true, ), ), 'relativePath' => 'custom/input/CustomFileAttachmentUpload', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'view' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'logic' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'js_templates' => array ( 0 => array ( 'attachmentItem' => '<li id="<%= id %>"> <rn:block id="attachmentItemTop"/> <% if (displayThumbnail) { %> <rn:block id="preThumbnail"/> <span class="rn_Thumbnail"></span> <rn:block id="postThumbnail"/> <% } %> <rn:block id="preFileName"/> <%= name %> <rn:block id="postFileName"/> <rn:block id="preRemoveLink"/> <a href=\'javascript:void(0)\' class=\'rn_fileRemove\'><%= attrs.label_remove %><span class=\'rn_ScreenReaderOnly\'><%= name %></span></a> <rn:block id="postRemoveLink"/> <rn:block id="attachmentItemBottom"/></li>', 'error' => '<div data-field="<%= fieldName %>"> <rn:block id="preError"/> <b><a href=\'javascript:void(0);\' onclick=\'document.getElementById("<%= id %>").focus(); return false;\'><%= errorLink %></a></b> <rn:block id="postError"/></div>', 'label' => '<rn:block id="preFileInputLabel"/><label for="rn_<%= instanceID %>_FileInput" id="rn_<%= instanceID %>_Label"><%= label %><% if(minAttachments) { %> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span><% } %></label><rn:block id="postFileInputLabel"/>', 'maxMessage' => '<li> <rn:block id="preMaxLabel"/> <%= maxMessage %> <rn:block id="postMaxLabel"/></li>', ), ), 'base_css' => array ( 0 => 'standard/input/FileAttachmentUpload/base.css', ), 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/FileAttachmentUpload.css', 1 => 'assets/themes/mobile/widgetCss/FileAttachmentUpload.css', ), 'parent' => 'standard/input/FileAttachmentUpload', ), 'widget_name' => 'CustomFileAttachmentUpload', 'extends_php' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'extends_js' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'extends_view' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'parent' => 'standard/input/FileAttachmentUpload', 'js_templates' => array ( 'attachmentItem' => '<li id="<%= id %>">  <% if (displayThumbnail) { %>  <span class="rn_Thumbnail"></span>  <% } %>  <%= name %>   <a href=\'javascript:void(0)\' class=\'rn_fileRemove\'><%= attrs.label_remove %><span class=\'rn_ScreenReaderOnly\'><%= name %></span></a>  </li>', 'error' => '<div data-field="<%= fieldName %>">  <b><a href=\'javascript:void(0);\' onclick=\'document.getElementById("<%= id %>").focus(); return false;\'><%= errorLink %></a></b> </div>', 'label' => '<label for="rn_<%= instanceID %>_FileInput" id="rn_<%= instanceID %>_Label"><%= label %><% if(minAttachments) { %> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span><% } %></label>', 'maxMessage' => '<li>  <%= maxMessage %> </li>', ), ), );
$result['meta']['attributes'] = array( 'always_show' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'display_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4480), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4480), 'inherited' => true, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'label_remove' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(6896), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(6896), 'inherited' => true, )), 'max_attachments' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => true, )), 'label_max_attachment_limit' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3336), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3336), 'inherited' => true, )), 'label_generic_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1941), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1941), 'inherited' => true, )), 'label_still_uploading_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43242), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(43242), 'inherited' => true, )), 'loading_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/indicator.gif', 'type' => 'FILEPATH', 'default' => 'images/indicator.gif', 'inherited' => true, )), 'min_required_attachments' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => true, )), 'label_min_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(18887), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(18887), 'inherited' => true, )), 'valid_file_extensions' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'label_invalid_extension' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2004), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2004), 'inherited' => true, )), 'display_thumbnail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), 'max_thumbnail_height' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 100, 'type' => 'INT', 'default' => 100, 'inherited' => true, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), );
return $result;
}
}
namespace Custom\Widgets\input{
class CustomSmartAssist extends \RightNow\Widgets\SmartAssistantDialog {
function _custom_input_CustomSmartAssist_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=
$this->classList ?> rn_Hidden">
    <div class="rn_MessageBox rn_InfoMessage">
        <span id="rn_<?=$this->instanceID;?>_DialogHeading" class="rn_Heading"><??></span>
    </div>
    <div id="rn_<?=$this->instanceID;?>_DialogContent" role="document"><?
?></div>
</div>
<? }
function getData() {
$defaultButtons = array('label_solved_button', 'label_submit_button', 'label_cancel_button');
$cleanUpValue = function($value) {
return strtolower(trim($value));
};
$buttons = array_map($cleanUpValue, array_unique(explode(',', $this->data['attrs']['button_ordering'])));
$displayAsLinks = array_map($cleanUpValue, array_unique(explode(',', $this->data['attrs']['display_button_as_link'])));
$ordering = array();
for($i = 0;
$i < count($buttons);
$i++) {
if(($button = $buttons[$i]) && in_array($button, $defaultButtons) && $this->data['attrs'][$button]) {
unset($defaultButtons[array_search($button, $defaultButtons, true)]);
$this->pushItem($ordering, $button, in_array($button, $displayAsLinks));
}
}
$i = 0;
while(count($ordering) < count($defaultButtons) && $i < count($defaultButtons)) {
$default = $defaultButtons[$i];
if(!array_key_exists($default, $ordering) && $this->data['attrs'][$default]) {
$this->pushItem($ordering, $default, in_array($default, $displayAsLinks));
}
$i++;
}
$this->data['attrs']['button_ordering'] = $ordering;
}
protected function pushItem(array &$orderingArray, $attributeName, $displayAsLink) {
$orderingArray[] = array( 'name' => $attributeName, 'label' => $this->data['attrs'][$attributeName], 'displayAsLink' => $displayAsLink, );
}
}
function _custom_input_CustomSmartAssist_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.CustomSmartAssist', 'library_name' => 'CustomSmartAssist', 'view_func_name' => '_custom_input_CustomSmartAssist_view', 'meta' => array ( 'controller_path' => 'custom/input/CustomSmartAssist', 'view_path' => 'custom/input/CustomSmartAssist', 'js_path' => 'custom/input/CustomSmartAssist', 'base_css' => array ( 0 => 'custom/input/CustomSmartAssist/base.css', ), 'js_templates' => array ( 'answerContent' => '<span id="<%= spanID %>" class="rn_Answer rn_AnswerDetail rn_Hidden"> <% if(question) { %> <span class="rn_AnswerSummary"><%= question %></span> <% } %> <span class="rn_AnswerSolution"><%= contents %></span></span>', 'answerLink' => '<a target="_blank" href="<%= href %>" onclick=\'RightNow.ActionCapture.record("smartAssistantResult", "view", <%= answerID %>);\'> <%= text %></a>', 'customDisplayResults' => '<% for(var i = 0, suggestion; i < suggestions.length; i++) { suggestion = suggestions[i]; if(suggestion.type === \'AnswerSummary\') { %>  <div class="rn_Prompt"><%= attrs.label_prompt %> <% if(attrs.accesskeys_enabled && attrs.label_accesskey && attrs.display_answers_inline) { %> <div class="rn_AccesskeyPrompt"><%= accessKeyPrompt %></div> <% } %> </div>  <ul class="rn_List <%= (attrs.display_answers_inline) ? \'rn_InlineAnswers\' : \'\' %>"> <% for(var j = 0; j < suggestion.list.length; j++) { %> <% if(attrs.display_answers_inline) { %>  <li> <% if(attrs.accesskeys_enabled) { %>  <a aria-expanded="false" href="javascript:void(0)" accesskey="<%=j+1%>" data-id="<%=suggestion.list[j].ID%>" class="rn_InlineAnswerLink rn_ExpandAnswer" id="<%=baseDomID + \'_Answer\' + suggestion.list[j].ID %>"> <% } else { %>  <a aria-expanded="false" href="javascript:void(0)" data-id="<%=suggestion.list[j].ID%>" class="rn_InlineAnswerLink rn_ExpandAnswer" id="<%=baseDomID + \'_Answer\' + suggestion.list[j].ID %>"> <% } %> <%= suggestion.list[j].title %> <span class="rn_ScreenReaderOnly" role="alert" id="<%=baseDomID + \'_Answer\' + suggestion.list[j].ID + \'_Alternative\'%>"> <%= attrs.label_collapsed %> </span> </a>  </li>  <% } else { %>  <li>  <a target="_blank" href="<%= \'/app/\' + answerUrl + \'/a_id/\' + suggestion.list[j].ID + sessionParam %>" onclick=\'RightNow.ActionCapture.record("smartAssistantResult", "view", <%=suggestion.list[j].ID%>);\'> <%=suggestion.list[j].title%> </a>  </li>  <% } %> <% } %> </ul> <% } else if(suggestion.type === \'Answer\') { %>  <div class="rn_Answer"> <div class="rn_Summary"><%=suggestion.title%></div> <div class="rn_Solution"><%=suggestion.content%></div> </div>  <% } else { %>  <div class="rn_Response"><%=suggestion.content%></div>  <% } %><% } %>', ), 'template_path' => 'custom/input/CustomSmartAssist', 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/input/SmartAssistantDialog', 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'relativePath' => 'custom/input/CustomSmartAssist', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/SmartAssistantDialog', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/input/SmartAssistantDialog', ), 'widget_name' => 'CustomSmartAssist', 'extends_php' => array ( 0 => 'standard/input/SmartAssistantDialog', ), 'parent' => 'standard/input/SmartAssistantDialog', ), );
$result['meta']['attributes'] = array( 'get_answer_content' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/getAnswer', 'type' => 'AJAX', 'default' => '/ci/ajaxRequest/getAnswer', 'inherited' => true, )), 'label_banner' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3303), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3303), 'inherited' => true, )), 'label_prompt' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1984), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1984), 'inherited' => true, )), 'label_no_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(42065), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(42065), 'inherited' => true, )), 'label_submit_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4781), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4781), 'inherited' => true, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1699), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1699), 'inherited' => true, )), 'label_solved_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2783), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2783), 'inherited' => true, )), 'label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1967), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1967), 'inherited' => true, )), 'label_collapsed' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(14422), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(14422), 'inherited' => true, )), 'label_expanded' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(14416), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(14416), 'inherited' => true, )), 'label_accesskey' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(19076), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(19076), 'inherited' => true, )), 'label_download_attachment' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40397), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(40397), 'inherited' => true, )), 'label_view_guide' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(47429), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(47429), 'inherited' => true, )), 'solved_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'inherited' => true, )), 'accesskeys_enabled' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), 'display_answers_inline' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), 'button_ordering' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'label_solved_button, label_submit_button, label_cancel_button', 'type' => 'STRING', 'default' => 'label_solved_button, label_submit_button, label_cancel_button', 'inherited' => true, )), 'display_button_as_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'label_cancel_button', 'type' => 'STRING', 'default' => 'label_cancel_button', 'inherited' => true, )), 'dialog_width' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '800px', 'type' => 'STRING', 'default' => '800px', 'inherited' => true, )), 'dnc_label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'dnc_label_banner' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'dnc_label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'dnc_redirect_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Connect;
class PasswordInput extends \RightNow\Libraries\Widget\Input {
function _standard_input_PasswordInput_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<? if ($this->data['attrs']['require_current_password']): ?>
    <div class="rn_PasswordInputCurrent">
        <? if ($this->data['attrs']['label_current_password']): ?>
            <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_CurrentPassword" id="rn_<?= $this->instanceID ?>_Current_Label" class="rn_Label">
            <?= $this->data['attrs']['label_current_password'] ?>
            </label>
        <? endif;
?>
        <input type="password" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_CurrentPassword" name="<?= $this->data['inputName'] ?>_CurrentPassword" class="rn_Password rn_Current" <?= $this->outputconstraints();
?> />
    </div>
<? endif;
?>
<? if ($this->data['attrs']['label_input']): ?>
    <div id="rn_<?= $this->instanceID ?>_LabelContainer">
        <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" id="rn_<?= $this->instanceID ?>_Label" class="rn_Label">
        <?= $this->data['attrs']['label_input'] ?>
        <? if ($this->data['attrs']['required']): ?>
            <span class="rn_Required"> <?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015)) ?></span>
        <? endif;
?>
        </label>
    </div>
<? endif;
?>
    <input type="password" aria-describedby="<?if ($this->data['js']['requirements'] && $this->data['js']['requirements']['length']) echo "rn_{$this->instanceID}_PasswordLength ";?>rn_<?=$this->instanceID
?>_PasswordHelp" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>" name="<?= $this->data['inputName'] ?>" class="rn_Password" <?= $this->outputconstraints();
?> />
    <? if ($this->data['js']['requirements'] && $this->data['js']['requirements']['length']): ?>
        <span class="rn_PasswordLength" id="rn_<?= $this->instanceID ?>_PasswordLength"><? printf(\RightNow\Utils\Config::getMessage((40943)), $this->data['js']['requirements']['length']['count']) ?></span>
    <? endif;
?>
    <div id="rn_<?= $this->instanceID ?>_PasswordHelp"><? ?></div>
<? if ($this->data['attrs']['require_validation']): ?>
    <div class="rn_PasswordInputValidate">
        <div id="rn_<?= $this->instanceID ?>_LabelValidateContainer">
            <label for="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Validate" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_LabelValidate" class="rn_Label"><? printf($this->data['attrs']['label_validation'], $this->data['attrs']['label_input']) ?>
            <? if ($this->data['attrs']['required']): ?>
                <span class="rn_Required"><?= \RightNow\Utils\Config::getMessage((1908)) ?></span><span class="rn_ScreenReaderOnly"> <?= \RightNow\Utils\Config::getMessage((7015)) ?></span>
            <? endif;
?>
            </label>
        </div>
        <input type="password" aria-describedby="rn_<?= $this->instanceID ?>_PasswordValidationHelp" id="rn_<?= $this->instanceID ?>_<?= $this->data['js']['name'] ?>_Validate" name="<?= $this->data['inputName'] ?>_Validation" class="rn_Password rn_Validation" <?= $this->outputconstraints();
?> />
        <div id="rn_<?= $this->instanceID ?>_PasswordValidationHelp" class="rn_ScreenReaderOnly"><? printf(\RightNow\Utils\Config::getMessage((40498)), $this->data['attrs']['label_input']) ?></div>
    </div>
<? endif;
?>
</div><? }
const MAX_SIZE = 20;
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if (parent::getData() === false) return false;
if ($this->fieldName !== 'NewPassword') {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((40364)), $this->fieldName));
return false;
}
if (!\RightNow\Utils\Config::getConfig((193)) || $this->data['readOnly']) return false;
\RightNow\Utils\Url::redirectIfPageNeedsToBeSecure();
unset($this->constraints);
if ($validations = $this->getValidations()) {
$this->data['attrs']['required'] || ($this->data['attrs']['required'] = !is_null($validations['length']));
$this->data['js']['requirements'] = $validations;
}
if($this->data['attrs']['require_current_password']) {
$this->data['constraints']['requireCurrent'] = true;
}
if($this->data['attrs']['require_validation']) {
$this->data['constraints']['requireValidation'] = true;
}
}
function getValidations() {
$validations = \RightNow\Utils\Validation::getPasswordRequirements($this->fieldMetaData);
$validationsToPerform = array();
foreach ($validations as $name => $validation) {
if (!$validation['count'] || $name === 'old' || (($name === 'repetitions' || $name === 'occurrences') && $validations['length'] && $validations['length']['count'] && $validation['count'] > $validations['length']['count'])) continue;
$validationsToPerform[$name] = $validation;
$validationsToPerform[$name]['label'] = self::getValidationLabel($name, $validation['count']);
}
return $validationsToPerform;
}
function getValidationLabel($name, $number) {
switch ($name) {
case 'length': $attributeName = 'min_length';
break;
case 'occurrences': $attributeName = 'occurring';
break;
case 'repetitions': $attributeName = 'repetition';
break;
case 'specialAndDigits': $attributeName = 'special_digit';
break;
default: $attributeName = $name;
break;
}
if ($label = $this->data['attrs']["label_{$attributeName}_char"
. (($number > 1) ? 's' : '')]) {
return sprintf($label, $number);
}
}
function outputConstraints() {
$max = self::MAX_SIZE;
$attributes .= "maxlength='{$max}'";
if ($this->data['attrs']['required']) {
$attributes .= ' required';
}
if($this->data['attrs']['disable_password_autocomplete']){
$attributes .= ' autocomplete="off"';
}
return $attributes;
}
}
function _standard_input_PasswordInput_header() {
$result = array( 'js_name' => 'RightNow.Widgets.PasswordInput', 'library_name' => 'PasswordInput', 'view_func_name' => '_standard_input_PasswordInput_view', 'meta' => array ( 'controller_path' => 'standard/input/PasswordInput', 'view_path' => 'standard/input/PasswordInput', 'js_path' => 'standard/input/PasswordInput', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/PasswordInput.css', 1 => 'assets/themes/mobile/widgetCss/PasswordInput.css', ), 'js_templates' => array ( 'label' => '<% if (label) { %>  <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> </label> <% } %>', 'labelValidate' => '<label for="rn_<%= instanceID %>_<%= fieldName %>_Validate" id="rn_<%= instanceID %>_<%= fieldName %>_LabelValidate" class="rn_Label"><%= label %><% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <% } %></label>', 'overlay' => '<div class="rn_Heading">  <div class="rn_Intro" aria-describedby="rn_<%= instanceID %>_Requirements"> <div class="rn_Text"><%= title %></div> <span class="rn_ScreenReaderOnly"><%= passwordRequirementsLabel %></span> </div>   <div class="rn_Strength rn_Hidden"> <div class="rn_Meter" aria-describedby="rn_<%= instanceID %>_MeterLabel"></div> <label id="rn_<%= instanceID %>_MeterLabel"></label> </div> </div><ul class="rn_Requirements" aria-live="assertive" id="rn_<%= instanceID %>_Requirements"> <% for (var i in validations) { %> <% if (!validations.hasOwnProperty(i)) continue; %> <li data-validate="<%= i %>"> <span class="rn_ScreenReaderOnly"></span> <%= validations[i].label %> </li> <% } %></ul>', ), 'template_path' => 'standard/input/PasswordInput', 'version' => '1.3.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), 'yui' => array ( 'standard' => array ( 0 => 'overlay', ), ), ), 'info' => array ( 'description' => 'rn:msg:(42109)', ), 'relativePath' => 'standard/input/PasswordInput', 'widget_name' => 'PasswordInput', ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => false, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'require_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'boolean', 'default' => true, 'inherited' => false, )), 'require_current_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'label_current_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(31815), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(31815), 'inherited' => false, )), 'label_validation_incorrect' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1671), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(1671), 'inherited' => false, )), 'label_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3358), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3358), 'inherited' => false, )), 'disable_password_autocomplete' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'boolean', 'default' => true, 'inherited' => false, )), 'label_validation_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40561), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40561), 'inherited' => false, )), 'label_uppercase_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40343), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40343), 'inherited' => false, )), 'label_uppercase_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40342), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40342), 'inherited' => false, )), 'label_lowercase_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40335), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40335), 'inherited' => false, )), 'label_lowercase_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40334), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40334), 'inherited' => false, )), 'label_min_length_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(41963), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(41963), 'inherited' => false, )), 'label_min_length_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(41962), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(41962), 'inherited' => false, )), 'label_special_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40341), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40341), 'inherited' => false, )), 'label_special_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40340), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40340), 'inherited' => false, )), 'label_special_digit_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40346), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40346), 'inherited' => false, )), 'label_special_digit_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40336), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40336), 'inherited' => false, )), 'label_occurring_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40338), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40338), 'inherited' => false, )), 'label_occurring_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(41935), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(41935), 'inherited' => false, )), 'label_repetition_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40339), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40339), 'inherited' => false, )), 'label_repetition_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40312), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40312), 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Connect, RightNow\Libraries\Formatter;
class FieldDisplay extends \RightNow\Libraries\Widget\Output {
function _standard_output_FieldDisplay_view ($data) {
extract($data);
?><div  id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <? if ($this->data['attrs']['label']): ?>
        <span class="rn_DataLabel"><?=$this->data['attrs']['label'];?> </span>
    <?
endif;
?>
    <div class="rn_DataValue<?=$this->data['wrapClass']?>">
        <?=$this->data['value']?>
    </div>
</div>
<? }
protected $validObjectTypes = array('Menu', 'Country', 'NamedID', 'SlaInstance', 'Asset');
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(parent::getData() === false) {
return false;
}
$value = $this->data['value'];
$valueType = $this->getValueType($value, $this->fieldMetaData);
if (!$this->fieldShouldBeDisplayed($value, $valueType)) {
return false;
}
if (!$this->fieldIsValid($value, $valueType)) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((42158)), $this->data['attrs']['name']));
return false;
}
$this->data['value'] = Formatter::formatField($value, $this->fieldMetaData, $this->data['attrs']['highlight']);
if ($this->data['mask']) {
$this->data['value'] = Formatter::applyMask($this->data['value'], $this->data['mask']);
}
$this->data['wrapClass'] = ($this->data['attrs']['left_justify']) ? ' rn_LeftJustify' : '';
}
function getValueType($value, $fieldMetaData) {
if ($fieldMetaData->is_menu) {
return 'Menu';
}
if (Connect::isCountryType($value) && !Connect::isCustomAttribute($fieldMetaData) ) {
return 'Country';
}
if (Connect::isNamedIDType($value)) {
return 'NamedID';
}
if (Connect::isSlaInstanceType($value)) {
return 'SlaInstance';
}
if (Connect::isAssetType($value)) {
return 'Asset';
}
return $fieldMetaData->COM_type;
}
function fieldShouldBeDisplayed($value, $valueType) {
return (!is_null($value) && $value !== '' && !(!$value->ID && in_array($valueType, $this->validObjectTypes)));
}
function fieldIsValid($value, $valueType) {
if (is_object($value) && !in_array($valueType, $this->validObjectTypes)) {
return false;
}
return true;
}
}
function _standard_output_FieldDisplay_header() {
$result = array( 'js_name' => '', 'library_name' => 'FieldDisplay', 'view_func_name' => '_standard_output_FieldDisplay_view', 'meta' => array ( 'controller_path' => 'standard/output/FieldDisplay', 'view_path' => 'standard/output/FieldDisplay', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/FieldDisplay.css', 1 => 'assets/themes/basic/widgetCss/FieldDisplay.css', 2 => 'assets/themes/mobile/widgetCss/FieldDisplay.css', ), 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.2', 1 => '3.3', 2 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(41983)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(3918)', 'example' => 'kw/search', ), 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(993)', 'example' => 'a_id/3', ), 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), ), ), 'relativePath' => 'standard/output/FieldDisplay', 'widget_name' => 'FieldDisplay', ), );
$result['meta']['attributes'] = array( 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'STRING', 'default' => '{default_label}', 'inherited' => false, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'required' => true, 'inherited' => false, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'left_justify' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class BrowserSearchPlugin extends \RightNow\Libraries\Widget\Base {
function _standard_search_BrowserSearchPlugin_view ($data) {
extract($data);
?><link rel="search" type="application/opensearchdescription+xml" title="<?=$this->data['title']?>" href="/ci/browserSearch/desc/<?=$this->data['url'];?>/<?=$this->data['attrs']['title']?>/<?=$this->data['attrs']['description']?>/<?=$this->data['attrs']['icon_path']?>"/>
<?
}
function __construct($attrs){
parent::__construct($attrs);
}
function getData(){
if(!strlen($this->data['attrs']['pages'])) return false;
$this->data['attrs']['pages'] = explode(',', str_replace(' ', '', $this->data['attrs']['pages']));
$segmentUrl = '';
$pageSegments = $this->CI->config->item('parm_segment');
for($i = 3;
$i < $pageSegments;
$i++) $segmentUrl .= $this->CI->uri->segment($i) . '/';
$segmentUrl = substr($segmentUrl, 0, strlen($segmentUrl) - 1);
if(in_array($segmentUrl, $this->data['attrs']['pages'])) $this->constructOutput($segmentUrl);
else return false;
}
protected function constructOutput($page){
if(strlen($this->data['attrs']['search_page'])) $page = $this->data['attrs']['search_page'];
if(substr($page, -1) !== '/') $page .= '/';
if(substr($page, 0) !== '/') $page = '/' . $page;
$page .= 'kw/{searchTerms}';
$this->data['url'] = urlencode(\RightNow\Utils\Url::getShortEufAppUrl('sameAsCurrentPage', $page));
$this->data['title'] = $this->data['attrs']['title'];
$this->data['attrs']['title'] = urlencode($this->data['attrs']['title']);
$this->data['attrs']['description'] = urlencode($this->data['attrs']['description']);
$this->data['attrs']['icon_path'] = urlencode($this->data['attrs']['icon_path']);
}
}
function _standard_search_BrowserSearchPlugin_header() {
$result = array( 'js_name' => '', 'library_name' => 'BrowserSearchPlugin', 'view_func_name' => '_standard_search_BrowserSearchPlugin_view', 'meta' => array ( 'controller_path' => 'standard/search/BrowserSearchPlugin', 'view_path' => 'standard/search/BrowserSearchPlugin', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', 3 => '3.3', 4 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'category' => array ( 0 => 'Report Search', ), 'description' => 'rn:msg:(4363)', ), 'relativePath' => 'standard/search/BrowserSearchPlugin', 'widget_name' => 'BrowserSearchPlugin', ), );
$result['meta']['attributes'] = array( 'pages' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'home, answers/list, answers/detail', 'type' => 'STRING', 'default' => 'home, answers/list, answers/detail', 'inherited' => false, )), 'search_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'answers/list', 'type' => 'STRING', 'default' => 'answers/list', 'inherited' => false, )), 'title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'inherited' => false, )), 'description' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'inherited' => false, )), 'icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/euf/assets/images/icons/favicon_browserSearchPlugin.ico', 'type' => 'STRING', 'default' => '/euf/assets/images/icons/favicon_browserSearchPlugin.ico', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Framework, RightNow\Utils\Text, RightNow\Utils\Url;
class LogoutLink extends \RightNow\Libraries\Widget\Base {
function _standard_login_LogoutLink_view ($data) {
extract($data);
?><?php ?>
<span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <a id="rn_<?=$this->instanceID;?>_LogoutLink" href="javascript:void(0);"><?=$this->data['attrs']['label'];?></a>
</span>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
$this->setAjaxHandlers(array( 'logout_ajax' => array( 'method' => 'doLogout', 'clickstream' => 'account_logout', ), ));
}
function getData() {
if(!Framework::isLoggedIn() || (Framework::isPta() && !\RightNow\Utils\Config::getConfig((378)))) return false;
if(Framework::isPta()){
$this->data['js']['redirectLocation'] = Url::deleteParameter((\RightNow\Utils\Config::getConfig((25), 'COMMON') ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], 'sno');
}
else if($this->data['attrs']['redirect_url']){
$this->data['js']['redirectLocation'] = $this->data['attrs']['redirect_url'];
}
else{
$this->data['js']['redirectLocation'] = Url::deleteParameter($_SERVER['REQUEST_URI'], 'sno');
}
$this->data['js']['redirectLocation'] = Url::deleteParameter($this->data['js']['redirectLocation'], 'sno');
if(\RightNow\Utils\Url::sessionParameter() !== '') $this->data['js']['redirectLocation'] = Url::addParameter($this->data['js']['redirectLocation'], 'session', Text::getSubstringAfter(Url::sessionParameter(), "session/"));
if(\RightNow\Utils\Framework::isPta()){
$this->data['js']['redirectLocation'] = str_ireplace('%source_page%', urlencode($this->data['js']['redirectLocation']), \RightNow\Utils\Config::getConfig((378)));
}
if(\RightNow\Utils\Config::getConfig((701), 'RNW')){
if($socialLogoutUrl = \RightNow\Utils\Config::getConfig((703), 'RNW')){
$socialLogoutUrl .= '/scripts/signout';
$redirectComponents = parse_url($this->data['js']['redirectLocation']);
if($redirectComponents['host']){
$socialLogoutUrl .= '?redirectUrl=' . urlencode($this->data['js']['redirectLocation']);
}
else{
$socialLogoutUrl .= '?redirectUrl=' . urlencode(Url::getShortEufBaseUrl('sameAsCurrentPage', $this->data['js']['redirectLocation']));
}
$this->data['js']['redirectLocation'] = $socialLogoutUrl;
}
else{
echo $this->reportError(\RightNow\Utils\Config::getMessage((1294)));
return false;
}
}
}
function doLogout($parameters) {
Url::redirectToHttpsIfNecessary();
$result = $this->CI->model('Contact')->doLogout($parameters['url'], $parameters['redirectUrl'])->result;
echo json_encode($result);
}
}
function _standard_login_LogoutLink_header() {
$result = array( 'js_name' => 'RightNow.Widgets.LogoutLink', 'library_name' => 'LogoutLink', 'view_func_name' => '_standard_login_LogoutLink_view', 'meta' => array ( 'controller_path' => 'standard/login/LogoutLink', 'view_path' => 'standard/login/LogoutLink', 'js_path' => 'standard/login/LogoutLink', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4293)', ), 'relativePath' => 'standard/login/LogoutLink', 'widget_name' => 'LogoutLink', ), );
$result['meta']['attributes'] = array( 'logout_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajax/widget', 'type' => 'AJAX', 'default' => '/ci/ajax/widget', 'inherited' => false, )), 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(42023), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(42023), 'inherited' => false, )), 'redirect_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Text, RightNow\Utils\Url;
class LoginDialog extends \RightNow\Libraries\Widget\Base {
function _standard_login_LoginDialog_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <? if($this->data['attrs']['open_login_url']):?>
    <div class="rn_OpenLoginAlternative">
        <a id="rn_<?=$this->instanceID;?>_OpenLoginLink" href="<?=$this->data['attrs']['open_login_url'].
\RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['attrs']['label_open_login_link'];?></a>
    </div>
    <?
endif;?>
    <div id="rn_<?=$this->instanceID;?>_Content" class="rn_LoginDialogContent">
        <div id="rn_<?=$this->instanceID;?>_ErrorMessage"></div>
        <form id="rn_<?=$this->instanceID;?>_Form" onsubmit="return false;">
            <label for="rn_<?=$this->instanceID;?>_Username"><?=$this->data['attrs']['label_username'];?></label>
            <input id="rn_<?=$this->instanceID;?>_Username" type="text" maxlength="80" name="Contact.Login" autocorrect="off" autocapitalize="off" value="<?=$this->data['username'];?>"/>
        <?
if(!$this->data['attrs']['disable_password']):?>
            <label for="rn_<?=$this->instanceID;?>_Password"><?=$this->data['attrs']['label_password'];?></label>
            <input id="rn_<?=$this->instanceID;?>_Password" type="password" name="Contact.Password" maxlength="20" <?=($this->data['attrs']['disable_password_autocomplete'])
? 'autocomplete="off"' : '' ?>>
        <? endif;?>
        </form>
        <span><a href="<?=$this->data['attrs']['assistance_url'].
\RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['attrs']['label_assistance'];?></a></span>
    </div>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(\RightNow\Utils\Framework::isLoggedIn()) return false;
if($redirectLocation = \RightNow\Utils\Url::getParameter('redirect')) {
$redirectLocation = urldecode(urldecode($redirectLocation));
$parsedURL = parse_url($redirectLocation);
if($parsedURL['scheme'] || (Text::beginsWith($parsedURL['path'], '/ci/') || Text::beginsWith($parsedURL['path'], '/cc/'))) {
$this->data['js']['redirectOverride'] = $redirectLocation;
}
else {
$this->data['js']['redirectOverride'] = Text::beginsWith($redirectLocation, '/app/') ? $redirectLocation : "/app/$redirectLocation";
}
}
$redirectPage = $this->data['js']['redirectOverride'] ?: ($this->data['attrs']['redirect_url'] ?: $_SERVER['REQUEST_URI']);
if(\RightNow\Utils\Config::getConfig((239)) && !Url::isRequestHttps()) {
$this->data['js']['loginLinkOverride'] = Url::addParameter(Url::getShortEufBaseUrl('sameAsRequest', '/app/' . \RightNow\Utils\Config::getConfig((229)) . Url::sessionParameter()), 'redirect', urlencode(urlencode($redirectPage)));
}
if($this->data['attrs']['open_login_url']) {
$this->classList->add('rn_AdditionalOpenLogin');
if (!Text::stringContains($this->data['attrs']['open_login_url'], '/redirect/')) {
$this->data['attrs']['open_login_url'] = Url::addParameter($this->data['attrs']['open_login_url'], 'redirect', urlencode(urlencode($redirectPage)));
}
}
$this->data['attrs']['disable_password'] = $this->data['attrs']['disable_password'] ?: !\RightNow\Utils\Config::getConfig((193));
$this->data['username'] = \RightNow\Utils\Url::getParameter('username');
}
}
function _standard_login_LoginDialog_header() {
$result = array( 'js_name' => 'RightNow.Widgets.LoginDialog', 'library_name' => 'LoginDialog', 'view_func_name' => '_standard_login_LoginDialog_view', 'meta' => array ( 'controller_path' => 'standard/login/LoginDialog', 'view_path' => 'standard/login/LoginDialog', 'js_path' => 'standard/login/LoginDialog', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/LoginDialog.css', 1 => 'assets/themes/mobile/widgetCss/LoginDialog.css', ), 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(42108)', 'urlParameters' => array ( 'redirect' => array ( 'name' => 'rn:msg:(3354)', 'description' => 'rn:msg:(1761)', 'example' => 'redirect/home', ), 'username' => array ( 'name' => 'rn:msg:(4846)', 'description' => 'rn:msg:(3199)', 'example' => 'username/JohnDoe', ), ), ), 'relativePath' => 'standard/login/LoginDialog', 'widget_name' => 'LoginDialog', ), );
$result['meta']['attributes'] = array( 'trigger_element' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'required' => true, 'inherited' => false, )), 'label_username' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4846), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4846), 'inherited' => false, )), 'label_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40564), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(40564), 'inherited' => false, )), 'label_login_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2601), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2601), 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9555), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9555), 'inherited' => false, )), 'label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3151), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3151), 'inherited' => false, )), 'label_assistance' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2013), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2013), 'inherited' => false, )), 'disable_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'append_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'redirect_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'assistance_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((220)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((220)), 'inherited' => false, )), 'open_login_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((229)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((229)), 'inherited' => false, )), 'label_open_login_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((2591)) . "<span class='rn_ScreenReaderOnly'>" . \RightNow\Utils\Config::getMessage((40417)) . ' ' . \RightNow\Utils\Config::getMessage((1354)) . '</span>', 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((2591)) . "<span class='rn_ScreenReaderOnly'>" . \RightNow\Utils\Config::getMessage((40417)) . ' ' . \RightNow\Utils\Config::getMessage((1354)) . '</span>', 'inherited' => false, )), 'login_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/doLogin', 'type' => 'AJAX', 'default' => '/ci/ajaxRequest/doLogin', 'inherited' => false, )), 'disable_password_autocomplete' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), );
return $result;
}
}
namespace{
use \RightNow\Utils\FileSystem;
?><!DOCTYPE html>
<html lang="<?=\RightNow\Utils\Text::getLanguageCode();?>">
<head class="no-js">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
    <meta http-equiv="Content-Language" content="<?=\RightNow\Utils\Text::getLanguageCode();?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title><?=\RightNow\Utils\Tags::getPageTitleAtRuntime();?> | Virgin America</title>
    <!--[if lt IE 9]><script type="text/javascript" src="/euf/rightnow/html5.js"></script><![endif]-->
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/BrowserSearchPlugin',
array('pages' => 'home, answers/list, answers/detail',));
?>
    <?= \RightNow\Libraries\SEO::getCanonicalLinkTag() . "\n";
?>
<style type='text/css'>
 <!-- 
.rn_ScreenReaderOnly{position:absolute; height:1px; left:-10000px; overflow:hidden; top:auto; width:1px;}
.rn_Hidden{display:none;}
 --></style>
<base href='<?=\RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest', \RightNow\Utils\FileSystem::getOptimizedAssetsDir() . 'themes/standard/');?>'/>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>templates/standard.themes.standard.SITE.css' rel='stylesheet' type='text/css' media='all'/>
<style type="text/css">
<!--
.rn_LoginDialog{width: 210px;}
.rn_LoginDialog.rn_ContentLoading{background:url(<?=FileSystem::getOptimizedAssetsDir();?>themes/standard/images/loading.gif) no-repeat center center;}
.rn_LoginDialog input{margin-bottom:5px;}
.rn_LoginDialog input[type="text"], .rn_LoginDialog input[type="password"]{width:200px;}
.rn_LoginDialog label{margin-bottom:5px;display:block;}
.rn_LoginDialog div{margin-bottom: 5px;}
.rn_LoginDialog.rn_AdditionalOpenLogin{overflow: hidden;position: relative;width: 400px;}
.rn_LoginDialog.rn_AdditionalOpenLogin .rn_LoginDialogContent{border-left: 1px solid #DDD;float: right;margin-bottom: 5px;padding-left:32px;width:209px;}
.rn_LoginDialog div.rn_OpenLoginAlternative{background:url(<?=FileSystem::getOptimizedAssetsDir();?>themes/standard/images/icons/badges.png) no-repeat;border: 0;float: left;margin:4px;padding: 0;width: 150px;}
.rn_LoginDialog .rn_OpenLoginAlternative a{display: block;padding-top:80px;}
.rn_HighContrastMode .rn_LoginDialog .rn_OpenLoginAlternative a{padding-top: 0;}
.rn_HighContrastMode .rn_LoginDialog .rn_OpenLoginAlternative .rn_ScreenReaderOnly{position: static;}
-->
</style>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>pages/ask.themes.standard.css' rel='stylesheet' type='text/css' media='all'/>
9c1379bc-cca6-4750-aee7-188f8348a6c3
<style>
.rn_CustomFormSubmit{
    border: none !important;
}
</style>
    <link rel="shortcut icon" href="https://www.virginamerica.com/images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="//cloud.typography.com/6612472/735824/css/fonts.css" />
	
	<script type='text/javascript'>window.ATGSvcs = {'eeid': 200106296983};</script>
	<script type='text/javascript' src='//static.atgsvcs.com/js/atgsvcs.js'></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
       <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
       <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
</head>
<body class="yui-skin-sam yui3-skin-sam">
<!-- TagMan BootStrap -->
<!--commented to resolve the chrome issue-->
<!--<script type="text/javascript">
   var webData = {
      pageName: "Contact Us",
      siteSection: 'Contact Us',
      servEnv: 'Oracle'
   }
   window.tmParam = {};
   (function(d,s){
      var client = 'virginamerica';
      var siteId = 20;
      //  do not edit
      var a=d.createElement(s),b=d.getElementsByTagName(s)[0];
      a.async=true;a.type='text/javascript';
      a.src='//sec.levexis.com/clients/'+client+'/'+siteId+'.js';
      a.tagman='st='+(+new Date())+'&c='+client+'&sid='+siteId;
      b.parentNode.insertBefore(a,b);
   })(document,'script');
</script>
<script type="text/javascript">
  function toggleLinks(id) {
    var e = document.getElementById(id);
    var body = document.getElementById('rn_Body');
    var ele = document.querySelector("#vx-wrapper");
    if (e.style.display == 'block') {
      e.style.display = 'none';
      body.style.display = 'block';
      ele.style.backgroundColor = 'transparent';     
    }
    else {
      e.style.display = 'block';
      body.style.display = 'none';
      ele.style.backgroundColor = "#DF1A2D";
    }
  }
</script>-->
<div id="rn_Container" >
    <div id="rn_SkipNav"><a href="#rn_MainContent"><?=\RightNow\Utils\Config::msgGetFrom((3673));?></a></div>
    <div id="rn_Header" role="banner">
    <noscript><h1><?=\RightNow\Utils\Config::msgGetFrom((4861));?></h1></noscript>
    <!--    <div id="rn_Logo"><a href="/app/<?=\RightNow\Utils\Config::configGetFrom((226));?><?=\RightNow\Utils\Url::sessionParameter();?>"><span class="rn_LogoTitle"><?=\RightNow\Utils\Config::msgGetFrom((8290));?> <span class="rn_LogoTitleMinor"><?=\RightNow\Utils\Config::msgGetFrom((14049));?></span></span></a></div> -->
        <header role="banner" class="banner">
            <h1 class="navbar__logo">
                <a href="https://www.virginamerica.com/">Virgin America</a>
            </h1>
            <nav class="navbar__main cf">
                <ul class="navlist--main cf">
                    <li><a href="https://www.virginamerica.com/cms/book-travel">Book</a></li>
                    <li><a href="https://www.virginamerica.com/flight-check-in">Check In</a></li>
                    <li><a href="https://www.virginamerica.com/manage-itinerary">Manage</a></li>
                </ul>
                <ul class="navlist--sub cf">
                    <li><a href="https://www.virginamerica.com/cms/travel-deals">Deals</a></li>
                    <li><a href="https://www.virginamerica.com/cms/fly-with-us">Flying With Us</a></li>
                    <li><a href="https://www.virginamerica.com/cms/airport-destinations">Where We Fly</a></li>
                    <li><a href="https://www.virginamerica.com/cms/vx-fees" target="">Fees</a></li>
                    <li><a href="https://www.virginamerica.com/check-flight-status">Flight Status</a></li>
                    <li><a href="https://www.virginamerica.com/get-flight-alerts">Flight Alerts</a></li>
                </ul>
            </nav>
            <div class="navbar__right cf">
                <div class="navbar__expand-nav">
                    <a href="#" class="expand-nav icon-nav-toggle">Nav</a>
                </div>
                <div class="navbar__elevate-nav">
                    <span class="elevate-nav--logged-out cf">
                        <a href="https://www.virginamerica.com/cms/elevate-frequent-flyer" class="elevate-nav__link elevate-nav__link--about icon-elevate-small">About Elevate</a>
                       <!-- <a href="https://www.virginamerica.com/elevate-frequent-flyer" class="elevate-nav__link elevate-nav__link--sign-in icon-elevate-small">Sign In</a>
                        <a href="https://www.virginamerica.com/elevate-frequent-flyer/sign-up" class="elevate-nav__link" ng-show="header.breakpoint !== 'small'">Sign Up</a>-->
                    </span>
                </div>
                <div class="navbar__elevate-nav is-close">
                    <a href="#" class="elevate-nav--close icon-close-light-white"></a>
                </div>
            </div>
            <nav class="nav-dropdown is-hidden">
                <div class="nav-expanded">
                    <ul class="nav-expanded__list">
                        <li>
                            <a href="https://www.virginamerica.com/">Home</a>
                        </li>
                        <li>
                            <a href="https://www.virginamerica.com/cms/book-travel">Book</a>
                        </li>
                        <li>
                            <a href="https://www.virginamerica.com/flight-check-in">Check In</a>
                        </li>
                        <li>
                            <a href="https://www.virginamerica.com/manage-itinerary">Manage</a>
                        </li>
                    </ul>
                    <ul class="nav-expanded__list--sub">
                        <li><a href="https://www.virginamerica.com/cms/travel-deals">Deals</a></li>
                        <li><a href="https://www.virginamerica.com/cms/fly-with-us">Flying With Us</a></li>
                        <li><a href="https://www.virginamerica.com/cms/airport-destinations">Where We Fly</a></li>
                        <li><a href="https://www.virginamerica.com/cms/vx-fees">Fees</a></li>
                        <li><a href="https://www.virginamerica.com/check-flight-status">Flight Status</a></li>
                        <li><a href="https://www.virginamerica.com/get-flight-alerts">Flight Alerts</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <div id="rn_LoginStatus">
            <?if(
(\RightNow\Utils\Framework::isLoggedIn()) ):?>
                 <?=\RightNow\Utils\Config::msgGetFrom((4605));?>
                <strong>
                    <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Contact', 1 => 'LookupName', ), false);?>
                </strong>
                <div>
                    <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Contact', 1 => 'Organization', 2 => 'Name', ), false);?>
                </div>
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/LogoutLink',
array());
?>
            <?else:?>
                <?if( (\RightNow\Utils\Config::getConfig(372) == true) ):?>
                    <a href="javascript:void(0);" id="rn_LoginLink"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a>&nbsp;|&nbsp;<a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((3650));?></a>
                <?else:?>
                    <a href="javascript:void(0);" id="rn_LoginLink"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a>&nbsp;|&nbsp;<a href="/app/utils/create_account<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((3650));?></a>
                    <?if(
((get_instance()->page !== 'utils/create_account') && (get_instance()->page !== 'utils/login_form') && (get_instance()->page !== 'utils/account_assistance') ) ):?>
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/LoginDialog', array('trigger_element' => 'rn_LoginLink','open_login_url' => '/app/' . \RightNow\Utils\Config::configGetFrom((229)) . '','label_open_login_link' => '' . \RightNow\Utils\Config::msgGetFrom((2591)) . ' <span class=\'rn_ScreenReaderOnly\'>(Facebook, Twitter, Google, OpenID) ' . \RightNow\Utils\Config::msgGetFrom((1354)) . '</span>',));
?>
                    <?endif;?>
                    <?if(
((get_instance()->page === 'utils/create_account') || (get_instance()->page === 'utils/login_form') || (get_instance()->page === 'utils/account_assistance') ) ):?>
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/LoginDialog', array('trigger_element' => 'rn_LoginLink','redirect_url' => '/app/account/overview','open_login_url' => '/app/' . \RightNow\Utils\Config::configGetFrom((229)) . '','label_open_login_link' => '' . \RightNow\Utils\Config::msgGetFrom((2591)) . ' <span class=\'rn_ScreenReaderOnly\'>(Facebook, Twitter, Google, OpenID) ' . \RightNow\Utils\Config::msgGetFrom((1354)) . '</span>',));
?>
                    <?endif;?>
                <?endif;?>
            <?endif;?>
        </div>
    </div>
    <div id="rn_Body">
        <div id="rn_MainColumn" role="main">
            <a id="rn_MainContent"></a>
<!-- <div id="rn_PageTitle" class="rn_AskQuestion">
    <h1><?=\RightNow\Utils\Config::msgGetFrom((3838));?></h1>
</div> -->
<style>
#chat_button{
  float:left;
}
</style>
<div id="rn_PageContent" class="rn_AskQuestion askform">
<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/chat/ChatAgentCustomAvail',
array());
?>
  <h1 id="rn_title">Contact Us</h1>
  <hr width="40%" style="margin: 0 auto">
  <?if( (\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') == 1858) || (\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') == 1866) ):?>
  <?if( (\RightNow\Utils\Chat::isChatAvailable()) ):?>
    <div id="chat_button" style="float:right; margin-right:auto">
      <button class="ask_chaticon" onclick="window.location.href='http://virginamerica.custhelp.com/app/chat/chat_launch/incidents.c$typeofquestion/1858'"></button>
    </div>
  <?endif;?>
  <?endif;?>
  <div class="rn_Padding">
    <form id="rn_QuestionSubmit" onsubmit="return false;">
      <div id="rn_ErrorLocation"></div>
      <??>
      <!--
Elevate
-->
      <?if(
(\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') == 1857) ):?>
        <h2>Elevate</h2>
        <p class="fontGotham sub-heading size5">Need Elevate help?  Just fill out the form below and we'll respond within 24 hours.</p>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.first_name','required' => 'true','initial_focus' => 'false','label_input' => 'First Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.last_name','required' => 'true','label_input' => 'Last Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactprimaryelevate','required' => 'false','label_input' => 'Elevate Number (If you have it handy) (11 digit number)',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.confirmationcode','label_input' => 'Virgin America Booking Confirmation Code','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.email','required' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4547)) . '',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactphone','required' => 'false','label_input' => 'Phone Number',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/SelectionRadioInput', array('name' => 'Incident.CustomFields.c.elevatesubject','required' => 'true','label_input' => 'Elevate Help Request','always_show' => 'true','radio' => 'true',));
?>
        <br>
        <!-- show fields when elevate subject is
       Missing Points id=1867  
    -->
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'Incident.CustomFields.c.confirmationcode1','required' => 'false','always_show' => 'false','display_value' => 'Incident.CustomFields.c.elevatesubject=1867',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'Incident.CustomFields.c.confirmationcode2','required' => 'false','always_show' => 'false','display_value' => 'Incident.CustomFields.c.elevatesubject=1867',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'Incident.CustomFields.c.partnerairline','required' => 'false','label_input' => 'If missing points from one of our Elevate partners, which one?','always_show' => 'false','display_value' => 'Incident.CustomFields.c.elevatesubject=1867',));
?>
        <!-- show fields when elevate subject is
       Merge Accounts id=1852  
    -->
        <!-- show fields when elevate subject is
       Redeem points with our Airline Partners id=1869  
    -->
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/ToggleVisibleArea', array('name' => 'togg','label' => '<a target=\'_blank\' href=\'http://www.virginamerica.com/cms/elevate-frequent-flyer/partners/airline-partners\'>For more info click here</a>','display_value' => 'Incident.CustomFields.c.elevatesubject=1869',));
?>
        <br>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomSelectionInput', array('name' => 'Incident.CustomFields.c.ffpburn','trigger_change_event' => 'false','display_value' => 'Incident.CustomFields.c.elevatesubject=1869','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'Incident.CustomFields.c.ffpconfcode','required' => 'false','label_input' => 'Confirmation Code(If you have an existing booking)','always_show' => 'false','display_value' => 'Incident.CustomFields.c.elevatesubject=1869',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/ToggleVisibleArea', array('name' => 'togg2','label' => '<h4>Please give us a range of dates that you can depart (as availability is limited):</h4>','display_value' => 'Incident.CustomFields.c.elevatesubject=1869',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomDateInput', array('name' => 'incidents.c$ffpdesiredstart','required' => 'false','min_year' => '2015','max_year' => '2020','label_input' => 'Start','always_show' => 'false','display_value' => 'Incident.CustomFields.c.elevatesubject=1869',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomDateInput', array('name' => 'incidents.c$ffpdesiredstart2','required' => 'false','min_year' => '2015','max_year' => '2020','label_input' => 'End','always_show' => 'false','display_value' => 'Incident.CustomFields.c.elevatesubject=1869',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/ToggleVisibleArea', array('name' => 'togg3','label' => '<h4>Please give us a range of dates that you can return (as availability is limited):</h4>','display_value' => 'Incident.CustomFields.c.elevatesubject=1869',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomDateInput', array('name' => 'incidents.c$ffpdesiredend','required' => 'false','min_year' => '2015','max_year' => '2020','label_input' => 'Start','always_show' => 'false','display_value' => 'Incident.CustomFields.c.elevatesubject=1869',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomDateInput', array('name' => 'incidents.c$ffpdesiredend2','required' => 'false','min_year' => '2015','max_year' => '2020','label_input' => 'End','always_show' => 'false','display_value' => 'Incident.CustomFields.c.elevatesubject=1869',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'Incident.CustomFields.c.city_origin','required' => 'false','always_show' => 'false','label_input' => 'Where are you flying from?','display_value' => 'Incident.CustomFields.c.elevatesubject=1869',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'Incident.CustomFields.c.city_destination','required' => 'false','always_show' => 'false','label_input' => 'Where are you flying to?','display_value' => 'Incident.CustomFields.c.elevatesubject=1869',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'Incident.CustomFields.c.number_passengers','required' => 'false','always_show' => 'false','label_input' => 'How many guests?','display_value' => 'Incident.CustomFields.c.elevatesubject=1869',));
?>
        <!-- show fields when elevate subject is
       Other id=1872 
    -->
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'Incident.CustomFields.c.altelevatenum1','required' => 'false','always_show' => 'false','label_input' => 'Additional Elevate Number (11 digit number)','display_value' => 'Incident.CustomFields.c.elevatesubject=1872,Incident.CustomFields.c.elevatesubject=1868',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.subject','required' => 'true','label_input' => 'Subject',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.thread','required' => 'true','label_input' => 'Let us know how we can help you?',));
?>
      <?endif;?>
      <!--
Concern/Kudos
-->
      <?if(
(\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') == 1858) ):?>
        <h2>Share Your Experience</h2>
        <p class="fontGotham sub-heading size5">Something not quite right?  Have an idea for how we can do better? Contact us below regarding any post-flight questions and issues. While we always try to respond quickly, please note during busy travel periods email response time may range from 7 to 10 days.</p>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.first_name','required' => 'true','initial_focus' => 'false','label_input' => 'First Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.last_name','required' => 'true','label_input' => 'Last Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/SelectionRadioInput', array('name' => 'Incident.CustomFields.c.concern_or_kudos','always_show' => 'true','radio' => 'true','lbl' => 'Comment Type','label_input' => 'Comment Type',));
?>
        <br/>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactprimaryelevate','required' => 'false','label_input' => 'Elevate Number (If you have it handy - 11 digit number)',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.confirmationcode','label_input' => 'Virgin America Booking Confirmation Code','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.email','required' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4547)) . '',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactphone','required' => 'false','label_input' => 'Phone Number',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.subject','required' => 'true','label_input' => 'Subject',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.thread','required' => 'true','label_input' => 'What would you like to tell us?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FileAttachmentUpload', array('display_thumbnail' => 'true','label_input' => 'Have something to show us? Attach it here.',));
?>
      <?endif;?>
      <!--
Idea/Suggestion
-->
      <?if(
(\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') == 1859) ):?>
        <h2>General Feedback</h2>
        <p class="fontGotham sub-heading size5">Have an idea for how we can do better? Contact us below regarding any post-flight questions and issues. While we always try to respond quickly, please note during busy travel periods email response time may range from 7 to 10 days.</p>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.first_name','required' => 'true','initial_focus' => 'false','label_input' => 'First Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.last_name','required' => 'true','label_input' => 'Last Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactprimaryelevate','required' => 'false','label_input' => 'Elevate Number (If you have it handy - 11 digit number)',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.confirmationcode','label_input' => 'Virgin America Booking Confirmation Code','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.email','required' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4547)) . '',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactphone','required' => 'false','label_input' => 'Phone Number',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.subject','required' => 'true','label_input' => 'Subject',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.thread','required' => 'true','label_input' => 'What would you like to tell us?',));
?>
      <?endif;?>
      <!--
Reservations/General Info
-->
      <?if(
(\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') == 1860) ):?>
        <h2>Reservations/General Info</h2>
        <p class="fontGotham sub-heading size5">Need help with a current reservation? This form is where you can write to us if you have questions about your reservation or are unable to find the answers in our FAQ.  Just fill out the form below and we will respond within 24 hours.</p>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.first_name','required' => 'true','initial_focus' => 'false','label_input' => 'First Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.last_name','required' => 'true','label_input' => 'Last Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactprimaryelevate','label_input' => 'Elevate Number (If you have it handy - 11 digit number)','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.confirmationcode','label_input' => 'Virgin America Booking Confirmation Code','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.email','required' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4547)) . '',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactphone','required' => 'false','label_input' => 'Phone Number',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.subject','required' => 'true','label_input' => 'Subject',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.thread','required' => 'false','label_input' => 'What would you like to tell us?',));
?>
      <?endif;?>
      <!--
Receipt
-->
      <?if(
(\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') == 1866) ):?>
        <h2>Receipt</h2>
        <p class="fontGotham sub-heading size5">You expensing that? You can look up, print, or email your flight receipt <a href="https://www.virginamerica.com/manage-itinerary">here</a> to print a receipt. For a receipt on purchases made at 35,000 feet – fill out this form below. Be sure to include the date the charges posted to your bank account so we can look it up and get it to you faster. Please note: during busy travel periods or crazy weather events, email response time may take up to 7-10 business days. Cheers!</p>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/SelectionRadioInput', array('name' => 'Incident.CustomFields.c.receipt_type','always_show' => 'true','radio' => 'true','lbl' => 'Type of Receipt',));
?>
        <br/>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/ToggleVisibleArea', array('name' => 'toggX','label' => 'For any current reservation receipts please visit us <a target=\'_blank\' href=\'https://www.virginamerica.com/manage-itinerary\'>here.</a>','display_value' => 'Incident.CustomFields.c.receipt_type=1901',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'contacts.first_name','always_show' => 'true','required' => 'true','hideon_value' => 'Incident.CustomFields.c.receipt_type=1901','label_input' => 'First Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'contacts.last_name','always_show' => 'true','required' => 'true','hideon_value' => 'Incident.CustomFields.c.receipt_type=1901','label_input' => 'Last Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'Incident.CustomFields.c.contactprimaryelevate','always_show' => 'true','required' => 'false','hideon_value' => 'Incident.CustomFields.c.receipt_type=1901',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'Incident.CustomFields.c.confirmationcode','always_show' => 'true','label_input' => 'Virgin America Booking Confirmation Code','required' => 'false','hideon_value' => 'Incident.CustomFields.c.receipt_type=1901',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'contacts.email','always_show' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4547)) . '','required' => 'true','hideon_value' => 'Incident.CustomFields.c.receipt_type=1901',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'Incident.CustomFields.c.contactphone','always_show' => 'true','label_input' => 'Phone Number','required' => 'false','hideon_value' => 'Incident.CustomFields.c.receipt_type=1901',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'incidents.subject','always_show' => 'true','required' => 'true','label_input' => 'Subject','hideon_value' => 'Incident.CustomFields.c.receipt_type=1901',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'incidents.thread','always_show' => 'true','required' => 'true','label_input' => 'What would you like to tell us?','hideon_value' => 'Incident.CustomFields.c.receipt_type=1901',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FileAttachmentUpload', array('display_thumbnail' => 'true','label_input' => 'If possible please provide a picture',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomFormSubmit', array('label_button' => 'Fill the form to proceed','on_success_url' => '/app/ask_confirm','always_show' => 'true','hideon_value' => 'Incident.CustomFields.c.receipt_type=1901','error_location' => 'rn_ErrorLocation',));
?>
      <?endif;?>
      <!--
Best Fare Guarantee
-->
      <?if(
(\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') == 1861) ):?>
        <h2>Best Fare Guarantee</h2>
        <p class="fontGotham sub-heading size5">Think you found a better Virgin America fare on a website other than Virginamerica.com?   Our lowest fares are right here on <a href="http://www.virginamerica.com" target="_blank">virginamerica.com</a>, but if you've stumbled upon a lower fare on another site you can submit your claim no later than 11:59 pm CT on the same day you purchased Virgin America tickets. Please find the full Terms and Conditions <a href="http://www.virginamerica.com/cms/dam/vx-pdf/130905_best_fares_guarantee_tc.pdf" target="_blank">here</a>. We'll look into your claim and email you if we're able to honor the fare you found.</p>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.first_name','required' => 'true','initial_focus' => 'false','label_input' => 'First Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.last_name','required' => 'true','label_input' => 'Last Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactprimaryelevate','label_input' => 'Elevate Number (If you have it handy - 11 digit number)','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.confirmationcode','label_input' => 'Virgin America Booking Confirmation Code','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.email','required' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4547)) . '',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactphone','required' => 'true','label_input' => 'Phone Number',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.subject','required' => 'true','label_input' => 'Subject',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.thread','required' => 'true','label_input' => 'What would you like to tell us?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/DateInput', array('name' => 'Incident.CustomFields.c.bestfare_date','min_year' => '2015','max_year' => '2016','required' => 'false','label_input' => 'Date of Travel','initial_focus' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/SelectionInput', array('name' => 'Incident.CustomFields.c.cabinofservice','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.competingfare','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.competingsite','required' => 'false','label_input' => 'Site where fare was found?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FileAttachmentUpload', array('label_input' => 'Please upload screenshot of Fare',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/SelectionInput', array('name' => 'Incident.CustomFields.c.agreetofaxscreenshot','label_input' => 'Agree to fax screenshot if requested?','required' => 'false',));
?>
      <?endif;?>
      <!--
Best Fare Guarantee 2
-->   
      <?if(
(\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') == 1868) ):?>
        <h2>Lowest Dallas Love Field Fare Guarantee</h2>
        <p class="fontGotham sub-heading size5">Think you found a better Dallas Love Field Main Cabin fare on a website other than Virginamerica.com? Our lowest fares are right here on <a href="http://www.virginamerica.com" target="_blank">virginamerica.com</a>, but if you've stumbled upon a comparable Main Cabin fare that is lower than ours on a nonstop route that Virgin America serves from Dallas Love Field, show us and we'll match it. To get the match, tell us no later than 11:59 pm CT on the same day you purchased Virgin America tickets. For more details on how to request a match, check out the full Terms and Conditions <a href="https://www.virginamerica.com/cms/dam/vx-pdf/150116_Terms_and_Conditions_for_DAL_Fare_Guarantee.pdf" target="_blank">here</a>.</p>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.first_name','required' => 'true','initial_focus' => 'false','label_input' => 'First Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.last_name','required' => 'true','label_input' => 'Last Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactprimaryelevate','label_input' => 'Elevate Number (If you have it handy - 11 digit number)','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.confirmationcode','label_input' => 'Virgin America Booking Confirmation Code','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.email','required' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4547)) . '',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactphone','required' => 'true','label_input' => 'Phone Number',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.subject','required' => 'true','label_input' => 'Subject',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.thread','required' => 'true','label_input' => 'What would you like to tell us?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/DateInput', array('name' => 'Incident.CustomFields.c.bestfare_date','min_year' => '2015','max_year' => '2016','required' => 'false','label_input' => 'Date of Travel','initial_focus' => 'false',));
?>
        <div style="display:none">
          <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/SelectionInput', array('name' => 'incidents.c$cabinofservice','required' => 'false',));
?>
        </div>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.competingfare','required' => 'true',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.competingsite','required' => 'true','label_input' => 'Site where fare was found?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FileAttachmentUpload', array('label_input' => 'Please upload screenshot of Fare',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/SelectionInput', array('name' => 'Incident.CustomFields.c.agreetofaxscreenshot','label_input' => 'Agree to fax screenshot if requested?','required' => 'false',));
?>
      <?endif;?>
      <!--
Lost and Found
-->
      <?if(
(\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') == 1865) ):?>
        <h2>Lost and Found</h2>
        <p class="fontGotham sub-heading size5">While we're not responsible for items left on board, we will do our best to reunite you with your lost item.  Our stations hold all found property for 5 days.  After 5 days, our airport locations forward all items to Central Baggage at Corporate Headquarter (that's us).  We inventory lost and found once a week.</p>
        <p class="fontGotham sub-heading size5"> We'll keep your information on file for 30 days while we search.  If we find a match, we will notify you immediately</p>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.first_name','required' => 'true','initial_focus' => 'false','label_input' => 'First Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.last_name','required' => 'true','label_input' => 'Last Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactprimaryelevate','label_input' => 'Elevate Number (If you have it handy - 11 digit number)','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.confirmationcode','label_input' => 'Virgin America Booking Confirmation Code','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.email','required' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4547)) . '',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactphone','required' => 'true','label_input' => 'Phone Number',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/DateInput', array('name' => 'Incident.CustomFields.c.lost_object_date','min_year' => '2015','max_year' => '2020','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.lost_object_locationlastseen','required' => 'true',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.flight_number','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.seat_number','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.city_origin','required' => 'true','label_input' => 'Where did you fly from?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.city_destination','required' => 'true','label_input' => 'Where did you fly to?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/SelectionInput', array('name' => 'Incident.CustomFields.c.lost_object','required' => 'true',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.lost_object_brandnamemodel','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.lost_object_identifyingfeature','required' => 'true',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FileAttachmentUpload', array('display_thumbnail' => 'true','label_input' => 'If possible please provide a picture',));
?>
      <?endif;?>
      <!--
Special Request (Disability Form)
-->
      <?if(
(\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') == 2079) ):?>
        <style>
		.rn_SelectionInput legend, .rn_SelectionInput label
		{
			font-weight: normal !important;
			font-size: 1.167em !important;
		}
	</style>
        <h2>Accessibility Services</h2>
        <p class="fontGotham sub-heading size5">Do you have an accessibility request?  Just fill out the form below.  A member of Virgin America’s Care Team may contact you for additional information. If your flight departs in less than 48 hours, please also call 1-877-FLY-VIRGIN (1-877-359-8474) for immediate assistance with your request.</p>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.first_name','required' => 'true','initial_focus' => 'false','label_input' => 'First Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.last_name','required' => 'true','label_input' => 'Last Name',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactprimaryelevate','required' => 'false','label_input' => 'Elevate Number (If you have it handy)',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.confirmationcode','label_input' => 'Virgin America Booking Confirmation Code','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.email','required' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4547)) . '',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.contactphone','required' => 'false','label_input' => 'Phone Number',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomDateInput', array('name' => 'incidents.c$ffpdesiredstart','required' => 'false','min_year' => '2015','max_year' => '2020','label_input' => 'Departure Date','always_show' => 'true',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.departureflightnum','label_input' => 'Departure Flight Number','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.city_origin_menu','required' => 'false','label_input' => 'Where are you flying from?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomDateInput', array('name' => 'incidents.c$ffpdesiredend','required' => 'false','min_year' => '2015','max_year' => '2020','label_input' => 'Return Date','always_show' => 'true',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.returnflightnum','label_input' => 'Return Flight Number','required' => 'false',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.city_destination_menu','required' => 'false','label_input' => 'Where are you flying from (return trip)?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.serviceanimal','required' => 'false','label_input' => 'Are you traveling with a service animal?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/SelectionRadioInput', array('name' => 'Incident.CustomFields.c.emotional_support_animal','required' => 'false','label_input' => 'Are you traveling with an emotional support animal?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/ToggleVisibleArea', array('name' => 'togg','label' => '<p>Please visit <a href=\'http://virginamerica.custhelp.com/app/answers/detail/a_id/91\' target=\'_blank\'>here</a> for the documentation requirements.</p>','display_value' => 'Incident.CustomFields.c.emotional_support_animal=2069',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/SelectionRadioInput', array('name' => 'Incident.CustomFields.c.wheelchairassist','required' => 'false','label_input' => 'Do you require wheelchair assistance?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/ToggleVisibleArea', array('name' => 'togg','label' => '<p>If you would like us to provide you with a wheelchair curbside, we ask that you or a person accompanying you contact a Virgin America teammate at the ticket counter, notifying them that you have arrived and that you would like the assistance of a wheelchair. A wheelchair will then be brought to you curbside.</p>','display_value' => 'Incident.CustomFields.c.wheelchairassist=2066, Incident.CustomFields.c.wheelchairassist=2067, Incident.CustomFields.c.wheelchairassist=2068',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/SelectionRadioInput', array('name' => 'Incident.CustomFields.c.oxygen_use','required' => 'false','label_input' => 'Will you be using a Respiratory Assistive Device during the flight, such as for example, a portable oxygen concentrator, CPAP, respirator or ventilator?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/ToggleVisibleArea', array('name' => 'togg','label' => '<p>Please download the Respiratory Assistive Device Documentation Form <a href=\'https://virginamerica.custhelp.com/ci/fattach/get/91454/0/filename/Portable+Oxygen+Concentrator+Medical+Authorization.pdf\' target=\'_blank\'>here</a>. Then fill out and attach below. If you do not have the Respiratory Assistive Device Documentation Form already filled out you will receive an automated email from us after clicking “Submit”. You can respond directly to this email with your completed form.','display_value' => 'Incident.CustomFields.c.oxygen_use=2071',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomFileAttachmentUpload', array('required' => 'false','label_input' => 'Upload Form','display_value' => 'Incident.CustomFields.c.oxygen_use=2071',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Incident.CustomFields.c.oxygen_device_make_model','required' => 'false','label_input' => 'What is the make and model of the device?',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/SelectionRadioInput', array('name' => 'Incident.CustomFields.c.special_assist_other','required' => 'false','label_input' => 'Do you require assistance not listed above such as a seating accommodation, stowage of assistive devices, or escort assistance?',));
?>
        <div class="rn_Hidden">
          <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'incidents.subject','required' => 'true','label_input' => 'Subject','default_value' => 'Special Request',));
?>
        </div>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomTextInput', array('name' => 'incidents.thread','always_show' => 'true','required' => 'true','label_input' => 'Let us know how we can help you?','display_value' => 'Incident.CustomFields.c.special_assist_other=2073',));
?>
      <?endif;?>
      <div class="rn_Hidden">
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/SelectionInput',
array('name' => 'incidents.c$typeofquestion','default_value' => '1846','required' => 'false',));
?>
      </div>
      <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomSmartAssist', array('label_dialog_title' => 'Possible Answers - Smart Assistant','label_prompt' => 'The following answers might help you immediately. Click the arrow to expand the answer.',));
?>
      <?if( (\RightNow\Utils\Url::getParameter('incidents.c$typeofquestion') != 1866) ):?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/input/CustomFormSubmit', array('label_button' => 'Fill the form to proceed','on_success_url' => '/app/ask_confirm','always_show' => 'true','display_value' => 'submit','error_location' => 'rn_ErrorLocation',));
?>
      <?endif;?>
    </form>
  </div>
</div>
        </div>
<!--
        <rn:condition hide_on_pages="app/ask">
        <div id="rn_SideBar" role="navigation">
            <div class="rn_Padding">
                <div class="rn_Module">
                  <h2>Top 10 Questions</h2>
                    <rn:widget path="reports/Multiline2" report_id="194" per_page="10"/>
                </div>
            </div>
        </div>
        </rn:condition>
-->
    </div>
    <div id="rn_Footer" role="contentinfo">
<!--
        <div id="rn_RightNowCredit">
            <div class="rn_FloatRight">
                <rn:widget path="utils/RightNowLogo"/>
            </div>
        </div>
-->
    </div>
</div>
      <footer role="contentinfo">
            <div class="wrap">
                <div class="footer-wrap">
                    <nav class="footer-nav cf ng-scope" ng-switch-when="large">
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item">
                                <a href="/cms/sitemap" target="_self">Sitemap</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="http://virginamerica.custhelp.com/">Contact Us/FAQs</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="/cms/contract-of-carriage" target="_self">Contract of Carriage</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="/cms/intl-contract-of-carriage" target="_self">Int’l Contract of Carriage</a>
                            </li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item">
                                <a href="/blog" target="_self">Blog</a></li>
                            <li class="footer-nav__item">
                                <a href="/cms/about-our-airline" target="_self">About Us</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="/cms/about-our-airline/press" target="_self">Press &amp; Awards</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="/cms/news" target="_self">All News &amp; Updates</a>
                            </li>
                        </ul>
                        <ul class="footer-nav__list">
                             <li class="footer-nav__item">
                                <a href="/cms/legal/guest-service-commitment" target="_self">Guest Services Commitment</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="/cms/accessibility-services" target="_self">Accessibility Services</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="http://virginamerica.custhelp.com/app/ask/incidents.c$typeofquestion/2079" target="_self">Accessibility Services Form</a></li>
                            <li class="footer-nav__item">
                                <a href="https://access.virginamerica.com/h5/assistive/index" target="_self">Assistive View</a>
                            </li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item">
                                <a href="/cms/corporate-travel" target="_self">Corporate &amp; Group Travel</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="/cms/corporate-travel/travel-agents" target="_self">Travel Agency</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="/cms/travel-guard" target="_self">Travel Insurance</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="/cms/airline-jobs" target="_self">Careers</a>
                            </li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item">
                                <a href="/cms/elevate-frequent-flyer" target="_self">What Is Elevate?</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="https://creditcard.virginamerica.com" target="_self">Virgin America Credit Card</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="/cms/advertise-onboard" target="_self">Advertise Onboard</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="http://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGmAt9ur9biu27Jh9e9uzfeDcCi8SonfVXMtX%3DWQpglLjHJlYQGruK1w1EzbazdUdEGG6gmlazdJwoNGDzbf&amp;_ei_=EmSL9xUrhFrGHt6VuHz0Fpo">Email Unsubscribe</a>
                            </li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item">
                                <a href="https://www.virginamerica.com/cms/dam/vx-pdf/Tarmac_Delay_Contingency_Plan_Revised_May_2015.pdf" target="_self">Tarmac Delay Contingency Plan</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="http://ir.virginamerica.com/phoenix.zhtml?c=253736&amp;p=irol-irhome" target="_self">Investor Relations</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="/cms/corporate-responsibility" target="_self">Corporate Responsibility</a>
                            </li>
                            <li class="footer-nav__item">
                                <a href="/cms/legal/privacy-policy" target="_self">Privacy Policy</a>
                            </li>
                        </ul>
                        <ul class="footer-nav__list footer__social-icon" style="width: 100%">
                            <li class="social-icon icon-facebook">
                                <a href="https://www.facebook.com/VirginAmerica" target="_blank">
                                    <span class="accessible-hidden-label">Facebook</span>
                                </a>
                            </li>
                            <li class="social-icon icon-twitter">
                                <a href="https://twitter.com/VirginAmerica" target="_blank">
                                    <span class="accessible-hidden-label">Twitter</span>
                                </a>
                            </li>
                            <li class="social-icon icon-youtube">
                                <a href="https://www.youtube.com/user/VirginAmerica" target="_blank">
                                    <span class="accessible-hidden-label">Youtube</span>
                                </a>
                            </li>
                            <li class="social-icon icon-instagram">
                                <a href="https://www.instagram.com/virginamerica/" target="_blank">
                                    <span class="accessible-hidden-label">Instagram</span>
                                </a>
                            </li>
                            <li class="social-icon icon-google-plus">
                                <a href="https://plus.google.com/+VirginAmerica/" target="_blank">
                                    <span class="accessible-hidden-label">Google Plus</span>
                                </a>
                            </li>
                            <li class="social-icon icon-snapchat">
                                <a href="https://www.snapchat.com/add/virginamerica" target="_blank">
                                    <span class="accessible-hidden-label">Snapchat</span>
                                </a>
                            </li>
                            <li class="social-icon icon-linkedin">
                                <a href="https://www.linkedin.com/company/virgin-america" target="_blank">
                                    <span class="accessible-hidden-label">LinkedIn</span>
                                </a>
                            </li>
                            <li class="footer-copy">
                                © <span>2016</span> Virgin America
                            </li>
                    </ul></nav>
                </div>
            </div>
        </footer>
        <script>
            (function(){
                $dropdown = $('.nav-dropdown')
                $('.navbar__expand-nav').on('click', 'a', function (e) {
                    e.preventDefault();
                    $dropdown.toggleClass('is-hidden');
                    $('body').toggleClass('is-modal-open');
                    $('.banner').toggleClass('is-nav-expanded-active');
                });
                var getDeviceWindowHeight = function () {
                  var zoomLevel = document.documentElement.clientWidth / window.innerWidth;
                  return window.innerHeight * zoomLevel;
                }
                var applyWinHeight = function () {
                  $dropdown.css(
                    'height',
                    (getDeviceWindowHeight() - 54) + 'px'
                  );
                };
                applyWinHeight();
                $(window).resize(function () {
                    applyWinHeight();
                });
            })();
        </script>
<script>
    $(document).ready(function() { 
        $("iframe").each(function() { 
            $(this).attr('name','RightNow');  
            $(this).attr('id','RightNow');  
            $(this).attr('title','RightNow IFrame');  
            $(this).attr('tabindex','-1');  
            $('#RightNow').contents().find('html').attr('lang','en'); 
            $('<title>RightNow IFrame</title>').appendTo( $('#RightNow').contents().find('head') );
        });
    });
</script>  
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=\RightNow\Utils\Url::getCoreAssetPath('js/6.232/min/RightNow.js');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>templates<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/login/LogoutLink', 1 => 'standard/login/LoginDialog', ), '/standard.js', '1495130941');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => '/euf/core/3.2.6/js/6.232/min/widgetHelpers/EventProvider.js', 1 => '/euf/core/3.2.6/js/6.232/min/widgetHelpers/Field.js', 2 => '/euf/core/3.2.6/js/6.232/min/widgetHelpers/Form.js', 3 => 'standard/input/PasswordInput', 4 => 'custom/chat/ChatAgentCustomAvail', 5 => 'standard/input/SmartAssistantDialog', 6 => 'custom/input/CustomSmartAssist', 7 => 'standard/input/DateInput', 8 => 'standard/input/FileAttachmentUpload', 9 => 'standard/input/FormSubmit', 10 => 'standard/input/SelectionInput', 11 => 'standard/input/TextInput', 12 => 'custom/input/CustomDateInput', 13 => 'custom/input/CustomFileAttachmentUpload', 14 => 'custom/input/CustomFormSubmit', 15 => 'custom/input/CustomSelectionInput', 16 => 'custom/input/SelectionRadioInput', 17 => 'custom/input/CustomTextInput', 18 => 'custom/input/ToggleVisibleArea', ), '/ask.js', '1495130941');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'VALUE_MUST_BE_AN_INTEGER_MSG' => array ( 'value' => 4127, ), 'VALUE_IS_TOO_LARGE_MAX_VALUE_MSG' => array ( 'value' => 4125, ), 'VALUE_IS_TOO_SMALL_MIN_VALUE_MSG' => array ( 'value' => 4126, ), 'CONTAIN_1_CHARACTER_MSG' => array ( 'value' => 42414, ), 'PCT_D_CHARACTERS_MSG' => array ( 'value' => 2973, ), 'EXCEEDS_SZ_LIMIT_PCT_D_CHARS_1_LBL' => array ( 'value' => 42160, ), 'EXCEEDS_SZ_LIMIT_PCT_D_CHARS_PCT_D_LBL' => array ( 'value' => 1855, ), 'PCT_S_IS_AN_INVALID_POSTAL_CODE_MSG' => array ( 'value' => 3027, ), 'PCT_S_IS_AN_INVALID_PHONE_NUMBER_MSG' => array ( 'value' => 3026, ), 'PCT_S_CONT_SPACES_DOUBLE_QUOTES_LBL' => array ( 'value' => 41426, ), 'PCT_S_DIDNT_MATCH_EXPECTED_INPUT_LBL' => array ( 'value' => 3010, ), 'CONTAIN_SPACES_PLEASE_TRY_MSG' => array ( 'value' => 1344, ), 'PCT_S_IS_INVALID_MSG' => array ( 'value' => 3030, ), 'IS_NOT_A_VALID_URL_MSG' => array ( 'value' => 2246, ), 'FORMSUBMIT_PLACED_FORM_UNIQUE_ID_MSG' => array ( 'value' => 2021, ), 'PLS_VERIFY_REQ_ENTERING_TEXT_IMG_MSG' => array ( 'value' => 19038, ), 'ACCESSKEY_LBL' => array ( 'value' => 14176, ), 'ALT_LBL' => array ( 'value' => 14387, ), 'ALT_PLUS_SHIFT_LBL' => array ( 'value' => 14388, ), 'CTRL_LBL' => array ( 'value' => 15289, ), 'CTRL_PLUS_OPT_LBL' => array ( 'value' => 15290, ), 'LOADING_ELLIPSES_LBL' => array ( 'value' => 14002, ), 'FIELD_REQUIRED_MARK_LBL' => array ( 'value' => 1908, ), 'REQUIRED_LBL' => array ( 'value' => 7015, ), 'EXPECTED_INPUT_LBL' => array ( 'value' => 1870, ), 'WAITING_FOR_CHARACTER_LBL' => array ( 'value' => 4166, ), 'PLEASE_TYPE_A_NUMBER_MSG' => array ( 'value' => 3160, ), 'PLEASE_ENTER_UPPERCASE_LETTER_MSG' => array ( 'value' => 3148, ), 'PLEASE_ENTER_AN_UPPERCASE_LETTER_MSG' => array ( 'value' => 3137, ), 'PLS_ENTER_UPPERCASE_LETTER_SPECIAL_MSG' => array ( 'value' => 3165, ), 'PLEASE_ENTER_LOWERCASE_LETTER_MSG' => array ( 'value' => 3145, ), 'PLEASE_ENTER_A_LOWERCASE_LETTER_MSG' => array ( 'value' => 3136, ), 'PLS_ENTER_LOWERCASE_LETTER_SPECIAL_MSG' => array ( 'value' => 3164, ), 'PLEASE_ENTER_A_LETTER_OR_A_NUMBER_MSG' => array ( 'value' => 3135, ), 'PLEASE_ENTER_A_LETTER_MSG' => array ( 'value' => 3134, ), 'PLEASE_ENTER_LETTER_SPECIAL_CHAR_MSG' => array ( 'value' => 3144, ), 'THE_INPUT_IS_TOO_LONG_MSG' => array ( 'value' => 3920, ), 'THE_INPUT_IS_TOO_SHORT_MSG' => array ( 'value' => 3921, ), 'CHARACTER_LBL' => array ( 'value' => 1140, ), 'PCT_S_IS_NOT_COMPLETELY_FILLED_IN_MSG' => array ( 'value' => 3032, ), 'PCT_S_IS_NOT_A_VALID_DATE_MSG' => array ( 'value' => 3031, ), 'VALUE_MIN_VALUE_PCT_S_MSG' => array ( 'value' => 40743, ), 'FILE_PATH_FOUND_MSG' => array ( 'value' => 1932, ), 'FILE_ATT_UPLOAD_EMPTY_PLS_ENSURE_MSG' => array ( 'value' => 1917, ), 'FILE_UPLOAD_ALLOWED_FILE_MSG' => array ( 'value' => 1944, ), 'FILE_DELETED_LBL' => array ( 'value' => 1922, ), 'UPLOADING_ELLIPSIS_MSG' => array ( 'value' => 4057, ), 'FILE_UPLOAD_COMPLETE_LBL' => array ( 'value' => 1945, ), 'ERROR_PAGE_PLEASE_S_TRY_MSG' => array ( 'value' => 1805, ), 'FORM_EXP_PLS_CONFIRM_WISH_CONTINUE_MSG' => array ( 'value' => 2017, ), 'PCT_S_REQUIREMENTS_MET_LBL' => array ( 'value' => 41070, ), 'PASSWD_VALIDATION_REQS_READ_L_MSG' => array ( 'value' => 40556, ), 'PASSWORD_IS_TOO_SHORT_MSG' => array ( 'value' => 40563, ), 'PERFECT_LBL' => array ( 'value' => 40581, ), 'PASSWORD_IS_TOO_INSECURE_MSG' => array ( 'value' => 40562, ), 'COMPLETE_LBL' => array ( 'value' => 9461, ), 'INCOMPLETE_LBL' => array ( 'value' => 40451, ), 'PCT_S_MUST_NOT_CONTAIN_SPACES_MSG' => array ( 'value' => 3042, ), 'USERNAME_LBL' => array ( 'value' => 4846, ), 'PCT_S_CONTAIN_DOUBLE_QUOTES_MSG' => array ( 'value' => 3005, ), 'PCT_S_CNT_THAN_MSG' => array ( 'value' => 3002, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), 'CP_ANSWERS_DETAIL_URL' => array ( 'value' => 222, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
