<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/standard', 1 => '/euf/assets/themes/standard', 2 => array ( '/euf/assets/themes/standard' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/standard', ), ));
get_instance()->_checkMeta(array('title'=>'' . \RightNow\Utils\Config::msgGetFrom((31587)) . '', 'template'=>'standard.php', 'login_required'=>'false'));
get_instance()->clientLoader->setJavaScriptModule(get_instance()->meta['javascript_module']);
}
namespace Custom\Libraries\Widgets {
class CustomSharedViewPartials extends \RightNow\Libraries\Widgets\SharedViewPartials {
static function sample_view ($data) {
extract($data);
?>sample custom shared view partial<? }
}
}
namespace RightNow\Widgets{
class ResetPassword extends \RightNow\Libraries\Widget\Base {
function _standard_login_ResetPassword_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <div id="rn_<?=$this->instanceID;?>_ErrorLocation"></div>
    <form id="rn_<?=$this->instanceID;?>_ResetPassword" onsubmit="return false;" action="<?=$this->data['attrs']['reset_password_ajax'];?>">
    <?if(strlen($this->data['attrs']['label_heading'])):?>
        <span class="rn_ResetHeading"><?=$this->data['attrs']['label_heading'];?></span>
    <?endif;?>
    <?if($this->data['loginRequired']):?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput',
array('name' => 'Contact.Login','required' => 'true','validate_on_blur' => 'true','initial_focus' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4846)) . '','sub_id' => 'login',));
?>
        <?if(!$this->data['attrs']['disable_password']):?>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'Contact.NewPassword','require_validation' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((40564)) . '','label_validation' => '' . \RightNow\Utils\Config::msgGetFrom((4883)) . '','sub_id' => 'newAccountPassword',));
?>
        <?endif;?>
    <?else:?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput',
array('name' => 'Contact.NewPassword','initial_focus' => 'true','require_validation' => 'true','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((40564)) . '','label_validation' => '' . \RightNow\Utils\Config::msgGetFrom((4883)) . '','sub_id' => 'existingAccountPassword',));
?>
    <?endif;?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormSubmit',
array('on_success_url' => '' . $this->data['attrs']['on_success_url'] . '','error_location' => 'rn_' . $this->instanceID . '_ErrorLocation','sub_id' => 'submit',));
?>
    </form>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
$this->setAjaxHandlers(array( 'reset_password_ajax' => array( 'method' => 'performResetPassword', 'exempt_from_login_requirement' => true, ), ));
}
function getData() {
if($parmString = \RightNow\Utils\Url::getParameter('cred')) {
\RightNow\Utils\Url::redirectIfPageNeedsToBeSecure();
$this->data['js']['resetString'] = $parmString;
$parmString = \RightNow\Api::ver_ske_decrypt($parmString);
list($contactID, $expire, $loginRequired, $sharedEmail) = explode('/', $parmString);
if($expire && ($contactID || $sharedEmail)) {
$contactID = intval($contactID);
$expire = intval($expire);
$this->data['loginRequired'] = ($loginRequired) ? true : false;
if($expire > time()) {
if($contactID === 0 && $sharedEmail) {
return;
}
else {
$contact = $this->CI->model('Contact')->get($contactID)->result;
if($contact && isset($contact->Emails[0]->Address)) {
if(!$contact->Login && $this->data['loginRequired']) return;
if($contact->PasswordEmailExpirationTime === $expire) return;
}
}
}
}
}
echo '<br/>' . \RightNow\Utils\Config::getMessage((2564));
echo '<br/>' . sprintf(\RightNow\Utils\Config::getMessage((3394)), \RightNow\Utils\Config::getConfig((220), 'RNW_UI'), \RightNow\Utils\Config::getMessage((901)));
return false;
}
function performResetPassword($parameters) {
\RightNow\Libraries\AbuseDetection::check();
$data = json_decode($parameters['form']);
if(!$data) {
\RightNow\Utils\Framework::writeContentWithLengthAndExit(json_encode(\RightNow\Utils\Config::getMessage((2257))));
}
echo $this->CI->model('Field')->resetPassword($data, $parameters['pw_reset'])->toJson();
}
}
function _standard_login_ResetPassword_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ResetPassword', 'library_name' => 'ResetPassword', 'view_func_name' => '_standard_login_ResetPassword_view', 'meta' => array ( 'controller_path' => 'standard/login/ResetPassword', 'view_path' => 'standard/login/ResetPassword', 'js_path' => 'standard/login/ResetPassword', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ResetPassword.css', 1 => 'assets/themes/standard/widgetCss/ResetPassword.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4369)', 'urlParameters' => array ( 'cred' => array ( 'name' => 'rn:msg:(33683)', 'description' => 'rn:msg:(1763)', 'example' => 'cred/aUVCTCILuy0gb5GpOaelD~qh005DiVsKZJQKwJ638InUGE9IgcSJD4SA**', ), ), ), 'contains' => array ( 0 => array ( 'widget' => 'standard/input/FormInput', 'versions' => array ( 0 => '1.1', ), ), 1 => array ( 'widget' => 'standard/input/FormSubmit', 'versions' => array ( 0 => '1.2', ), ), ), 'relativePath' => 'standard/login/ResetPassword', 'widget_name' => 'ResetPassword', ), );
$result['meta']['attributes'] = array( 'reset_password_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajax/widget', 'type' => 'AJAX', 'default' => '/ci/ajax/widget', 'inherited' => false, )), 'label_heading' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'disable_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'on_success_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/utils/submit/password_changed', 'type' => 'STRING', 'default' => '/app/utils/submit/password_changed', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class FormInput extends \RightNow\Libraries\Widget\Input {
function _standard_input_FormInput_view ($data) {
extract($data);
?>
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
$result = array( 'js_name' => '', 'library_name' => 'FormInput', 'view_func_name' => '_standard_input_FormInput_view', 'meta' => array ( 'controller_path' => 'standard/input/FormInput', 'view_path' => 'standard/input/FormInput', 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:php:sprintf(\\RightNow\\Utils\\Config::getMessage((44076)), \'name\', \'default_value\')', 'urlParameters' => array ( 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), ), ), 'contains' => array ( 0 => array ( 'widget' => 'standard/input/SelectionInput', 'versions' => array ( 0 => '1.2', 1 => '1.3', ), ), 1 => array ( 'widget' => 'standard/input/DateInput', 'versions' => array ( 0 => '1.3', 1 => '1.4', ), ), 2 => array ( 'widget' => 'standard/input/TextInput', 'versions' => array ( 0 => '1.3', ), ), 3 => array ( 'widget' => 'standard/input/PasswordInput', 'versions' => array ( 0 => '1.3', ), ), ), 'relativePath' => 'standard/input/FormInput', 'widget_name' => 'FormInput', ), );
$result['meta']['attributes'] = array( );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Text;
class FormSubmit extends \RightNow\Libraries\Widget\Base {
function _standard_input_FormSubmit_view ($data) {
extract($data);
?><div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
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
$this->data['js'] = array( 'f_tok' => \RightNow\Utils\Framework::createTokenWithExpiration(0, $this->data['attrs']['challenge_required']), 'formExpiration' => (60000 * (\RightNow\Utils\Config::getConfig((204)) - 5)) );
if ($this->data['attrs']['challenge_required'] && $this->data['attrs']['challenge_location']) {
$this->data['js']['challengeProvider'] = \RightNow\Libraries\AbuseDetection::getChallengeProvider();
}
$this->data['attrs']['add_params_to_url'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']);
if ($redirect = \RightNow\Utils\Url::getParameter('redirect')) {
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
$result = array( 'js_name' => 'RightNow.Widgets.FormSubmit', 'library_name' => 'FormSubmit', 'view_func_name' => '_standard_input_FormSubmit_view', 'meta' => array ( 'controller_path' => 'standard/input/FormSubmit', 'view_path' => 'standard/input/FormSubmit', 'js_path' => 'standard/input/FormSubmit', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/FormSubmit.css', ), 'base_css' => array ( 0 => 'standard/input/FormSubmit/base.css', ), 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4186)', ), 'relativePath' => 'standard/input/FormSubmit', 'widget_name' => 'FormSubmit', ), );
$result['meta']['attributes'] = array( 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4550), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4550), 'inherited' => false, )), 'label_confirm_dialog' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_submitting_message' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3842), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3842), 'inherited' => false, )), 'on_success_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'loading_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/indicator.gif', 'type' => 'filepath', 'default' => 'images/indicator.gif', 'inherited' => false, )), 'error_location' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'challenge_location' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'challenge_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'timeout' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'min' => 0, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Connect, RightNow\Utils\Config;
class SelectionInput extends \RightNow\Libraries\Widget\Input {
function _standard_input_SelectionInput_view ($data) {
extract($data);
?><? if ($this->data['readOnly']): ?>
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
$result = array( 'js_name' => 'RightNow.Widgets.SelectionInput', 'library_name' => 'SelectionInput', 'view_func_name' => '_standard_input_SelectionInput_view', 'meta' => array ( 'controller_path' => 'standard/input/SelectionInput', 'view_path' => 'standard/input/SelectionInput', 'js_path' => 'standard/input/SelectionInput', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/SelectionInput.css', 1 => 'assets/themes/standard/widgetCss/SelectionInput.css', ), 'base_css' => array ( 0 => 'standard/input/SelectionInput/base.css', ), 'js_templates' => array ( 'label' => '<% if (label) { %>  <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <% } %>', 'legend' => '<% if (label) { %>  <%= label %> <% if (required) { %>  <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% } %>', ), 'template_path' => 'standard/input/SelectionInput', 'version' => '1.3.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4196)', ), 'contains' => array ( 0 => array ( 'widget' => 'standard/output/FieldDisplay', 'versions' => array ( 0 => '1.1', ), ), ), 'relativePath' => 'standard/input/SelectionInput', 'widget_name' => 'SelectionInput', ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => false, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => false, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'display_as_checkbox' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Config, RightNow\Connect\v1_2 as Connect;
class DateInput extends \RightNow\Libraries\Widget\Input {
function _standard_input_DateInput_view ($data) {
extract($data);
?><? if ($this->data['readOnly']): ?>
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
$result = array( 'js_name' => 'RightNow.Widgets.DateInput', 'library_name' => 'DateInput', 'view_func_name' => '_standard_input_DateInput_view', 'meta' => array ( 'controller_path' => 'standard/input/DateInput', 'view_path' => 'standard/input/DateInput', 'js_path' => 'standard/input/DateInput', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/DateInput.css', 1 => 'assets/themes/standard/widgetCss/DateInput.css', ), 'base_css' => array ( 0 => 'standard/input/DateInput/base.css', ), 'js_templates' => array ( 'legend' => '<% if (label) { %>  <%= label %> <% if (required) { %>  <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% } %>', ), 'template_path' => 'standard/input/DateInput', 'version' => '1.4.2', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4195)', ), 'contains' => array ( 0 => array ( 'widget' => 'standard/output/FieldDisplay', 'versions' => array ( 0 => '1.1', ), ), ), 'relativePath' => 'standard/input/DateInput', 'widget_name' => 'DateInput', ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => false, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => false, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'min_year' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 1970, 'type' => 'int', 'default' => 1970, 'min' => 1902, 'max' => 2100, 'inherited' => false, )), 'max_year' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'int', 'default' => null, 'min' => 1902, 'max' => 2100, 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Connect;
class PasswordInput extends \RightNow\Libraries\Widget\Input {
function _standard_input_PasswordInput_view ($data) {
extract($data);
?><div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
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
$result = array( 'js_name' => 'RightNow.Widgets.PasswordInput', 'library_name' => 'PasswordInput', 'view_func_name' => '_standard_input_PasswordInput_view', 'meta' => array ( 'controller_path' => 'standard/input/PasswordInput', 'view_path' => 'standard/input/PasswordInput', 'js_path' => 'standard/input/PasswordInput', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/PasswordInput.css', 1 => 'assets/themes/standard/widgetCss/PasswordInput.css', ), 'js_templates' => array ( 'label' => '<% if (label) { %>  <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> </label> <% } %>', 'labelValidate' => '<label for="rn_<%= instanceID %>_<%= fieldName %>_Validate" id="rn_<%= instanceID %>_<%= fieldName %>_LabelValidate" class="rn_Label"><%= label %><% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <% } %></label>', 'overlay' => '<div class="rn_Heading">  <div class="rn_Intro" aria-describedby="rn_<%= instanceID %>_Requirements"> <div class="rn_Text"><%= title %></div> <span class="rn_ScreenReaderOnly"><%= passwordRequirementsLabel %></span> </div>   <div class="rn_Strength rn_Hidden"> <div class="rn_Meter" aria-describedby="rn_<%= instanceID %>_MeterLabel"></div> <label id="rn_<%= instanceID %>_MeterLabel"></label> </div> </div><ul class="rn_Requirements" aria-live="assertive" id="rn_<%= instanceID %>_Requirements"> <% for (var i in validations) { %> <% if (!validations.hasOwnProperty(i)) continue; %> <li data-validate="<%= i %>"> <span class="rn_ScreenReaderOnly"></span> <%= validations[i].label %> </li> <% } %></ul>', ), 'template_path' => 'standard/input/PasswordInput', 'version' => '1.3.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), 'yui' => array ( 'standard' => array ( 0 => 'overlay', ), ), ), 'info' => array ( 'description' => 'rn:msg:(42109)', ), 'relativePath' => 'standard/input/PasswordInput', 'widget_name' => 'PasswordInput', ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => false, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'require_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'boolean', 'default' => true, 'inherited' => false, )), 'require_current_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'label_current_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(31815), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(31815), 'inherited' => false, )), 'label_validation_incorrect' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1671), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(1671), 'inherited' => false, )), 'label_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3358), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3358), 'inherited' => false, )), 'disable_password_autocomplete' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'boolean', 'default' => true, 'inherited' => false, )), 'label_validation_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40561), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40561), 'inherited' => false, )), 'label_uppercase_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40343), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40343), 'inherited' => false, )), 'label_uppercase_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40342), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40342), 'inherited' => false, )), 'label_lowercase_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40335), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40335), 'inherited' => false, )), 'label_lowercase_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40334), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40334), 'inherited' => false, )), 'label_min_length_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(41963), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(41963), 'inherited' => false, )), 'label_min_length_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(41962), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(41962), 'inherited' => false, )), 'label_special_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40341), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40341), 'inherited' => false, )), 'label_special_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40340), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40340), 'inherited' => false, )), 'label_special_digit_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40346), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40346), 'inherited' => false, )), 'label_special_digit_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40336), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40336), 'inherited' => false, )), 'label_occurring_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40338), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40338), 'inherited' => false, )), 'label_occurring_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(41935), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(41935), 'inherited' => false, )), 'label_repetition_chars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40339), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40339), 'inherited' => false, )), 'label_repetition_char' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40312), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(40312), 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Connect;
class TextInput extends \RightNow\Libraries\Widget\Input {
function _standard_input_TextInput_view ($data) {
extract($data);
?><? if ($this->data['readOnly']): ?>
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
$result = array( 'js_name' => 'RightNow.Widgets.TextInput', 'library_name' => 'TextInput', 'view_func_name' => '_standard_input_TextInput_view', 'meta' => array ( 'controller_path' => 'standard/input/TextInput', 'view_path' => 'standard/input/TextInput', 'js_path' => 'standard/input/TextInput', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/TextInput.css', 1 => 'assets/themes/standard/widgetCss/TextInput.css', ), 'base_css' => array ( 0 => 'standard/input/TextInput/base.css', ), 'js_templates' => array ( 'label' => '<% if (label) { %>  <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <% } %>', 'labelValidate' => '<label for="rn_<%= instanceID %>_<%= fieldName %>_Validate" id="rn_<%= instanceID %>_<%= fieldName %>_LabelValidate" class="rn_Label"><%= label %><% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <% } %></label>', ), 'template_path' => 'standard/input/TextInput', 'version' => '1.3.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4197)', ), 'contains' => array ( 0 => array ( 'widget' => 'standard/output/FieldDisplay', 'versions' => array ( 0 => '1.1', ), ), ), 'relativePath' => 'standard/input/TextInput', 'widget_name' => 'TextInput', ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => false, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => false, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'always_show_mask' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'boolean', 'default' => true, 'inherited' => false, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'existing_contact_check_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/checkForExistingContact', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/checkForExistingContact', 'inherited' => false, )), 'require_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'maximum_length' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'int', 'default' => 0, 'min' => 0, 'inherited' => false, )), 'minimum_length' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'int', 'default' => 0, 'min' => 0, 'inherited' => false, )), 'maximum_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'int', 'default' => null, 'inherited' => false, )), 'minimum_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'int', 'default' => null, 'inherited' => false, )), 'label_validation_incorrect' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1671), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(1671), 'inherited' => false, )), 'label_validation' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3358), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3358), 'inherited' => false, )), 'textarea' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
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
$result = array( 'js_name' => '', 'library_name' => 'FieldDisplay', 'view_func_name' => '_standard_output_FieldDisplay_view', 'meta' => array ( 'controller_path' => 'standard/output/FieldDisplay', 'view_path' => 'standard/output/FieldDisplay', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/FieldDisplay.css', 1 => 'assets/themes/mobile/widgetCss/FieldDisplay.css', 2 => 'assets/themes/standard/widgetCss/FieldDisplay.css', ), 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(41983)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(3918)', 'example' => 'kw/search', ), 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(993)', 'example' => 'a_id/3', ), 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), ), ), 'relativePath' => 'standard/output/FieldDisplay', 'widget_name' => 'FieldDisplay', ), );
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
$result = array( 'js_name' => '', 'library_name' => 'BrowserSearchPlugin', 'view_func_name' => '_standard_search_BrowserSearchPlugin_view', 'meta' => array ( 'controller_path' => 'standard/search/BrowserSearchPlugin', 'view_path' => 'standard/search/BrowserSearchPlugin', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4363)', ), 'relativePath' => 'standard/search/BrowserSearchPlugin', 'widget_name' => 'BrowserSearchPlugin', ), );
$result['meta']['attributes'] = array( 'pages' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'home, answers/list, answers/detail', 'type' => 'STRING', 'default' => 'home, answers/list, answers/detail', 'inherited' => false, )), 'search_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'answers/list', 'type' => 'STRING', 'default' => 'answers/list', 'inherited' => false, )), 'title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'inherited' => false, )), 'description' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'inherited' => false, )), 'icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/euf/assets/images/icons/favicon_browserSearchPlugin.ico', 'type' => 'STRING', 'default' => '/euf/assets/images/icons/favicon_browserSearchPlugin.ico', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Framework, RightNow\Utils\Text, RightNow\Utils\Url;
class LogoutLink extends \RightNow\Libraries\Widget\Base {
function _standard_login_LogoutLink_view ($data) {
extract($data);
?><span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
$result = array( 'js_name' => 'RightNow.Widgets.LoginDialog', 'library_name' => 'LoginDialog', 'view_func_name' => '_standard_login_LoginDialog_view', 'meta' => array ( 'controller_path' => 'standard/login/LoginDialog', 'view_path' => 'standard/login/LoginDialog', 'js_path' => 'standard/login/LoginDialog', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/LoginDialog.css', ), 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(42108)', 'urlParameters' => array ( 'redirect' => array ( 'name' => 'rn:msg:(3354)', 'description' => 'rn:msg:(1761)', 'example' => 'redirect/home', ), 'username' => array ( 'name' => 'rn:msg:(4846)', 'description' => 'rn:msg:(3199)', 'example' => 'username/JohnDoe', ), ), ), 'relativePath' => 'standard/login/LoginDialog', 'widget_name' => 'LoginDialog', ), );
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
    <meta name="viewport" content="width=device-width; initial-scale=1.0; user-scalable=no; minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Contact Us | FAQs</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
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
<link href='<?=FileSystem::getOptimizedAssetsDir();?>pages/account/reset_password.themes.standard.css' rel='stylesheet' type='text/css' media='all'/>
9c1379bc-cca6-4750-aee7-188f8348a6c3
    <link rel="shortcut icon" href="https://www.virginamerica.com/images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="//cloud.typography.com/6612472/735824/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="/euf/assets/themes/standard/header.css">
	
	<script type='text/javascript'>window.ATGSvcs = {'eeid': 200106296983};</script>
	<script type='text/javascript' src='//static.atgsvcs.com/js/atgsvcs.js'></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
       <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
       <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
</head>
<body class="yui-skin-sam yui3-skin-sam">
<!-- TagMan BootStrap -->
<script type="text/javascript">
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
</script>
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
                        <a href="https://www.virginamerica.com/elevate-frequent-flyer" class="elevate-nav__link elevate-nav__link--sign-in icon-elevate-small">Sign In</a>
                        <a href="https://www.virginamerica.com/elevate-frequent-flyer/sign-up" class="elevate-nav__link" ng-show="header.breakpoint !== 'small'">Sign Up</a>
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
<!-- This page is navigated to by following an email link when:
user or agent triggers 'reset password' routine-->
<div id="rn_PageTitle" class="rn_Account">
    <h1><?=\RightNow\Utils\Config::msgGetFrom((3411));?></h1>
</div>
<div id="rn_PageContent">
    <div class="rn_Padding">
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/ResetPassword',
array());
?>
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
        </div> -->
        <footer class="vx-footer">
            <div class="vx-wrap desktop">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                </ul>
                <ul>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>
            <div class="vx-wrap tablet">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                    <li><a href="/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>        
            <div class="vx-wrap mobile">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                    <li><a href="http://www.virginamerica.com/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>
            <p class="copyright">© 2014 Virgin America</p>
        </footer>
    </div>
</div>
      <footer role="contentinfo">
            <div class="wrap">
                <div class="footer-wrap">
                    <nav class="footer-nav cf">
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/sitemap">Sitemap</a></li>
                            <li class="footer-nav__item"><a href="http://virginamerica.custhelp.com/">Contact Us/FAQs</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/about-our-airline">About Us</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/about-our-airline/press">Press</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/blog">Blog</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/airline-jobs">Careers</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-travel">Corporate &amp; Group Travel</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-travel/travel-agents">Travel Agents</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/legal/guest-service-commitment">Guest Service Commitment</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/dam/vx-pdf/contract-of-carriage.pdf">Contract of Carriage</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/dam/vx-pdf/international-contract-of-carriage.pdf">Int’l Contract of Carriage</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-responsibility">Corporate Responsibility</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="http://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGmAt9ur9biu27Jh9e9uzfeDcCi8SonfVXMtX%3DWQpglLjHJlYQGruK1w1EzbazdUdEGG6gmlazdJwoNGDzbf&_ei_=EmSL9xUrhFrGHt6VuHz0Fpo">Email Unsubscribe</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/legal/privacy-policy">Privacy Policy</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/travel-guard">Travel Insurance</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/news">All News &amp; Updates</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/elevate-frequent-flyer">What Is Elevate?</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/elevate-frequent-flyer/credit-card">Virgin America Credit Card</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/advertise-onboard">Advertise Onboard</a></li>
                            <li class="footer-nav__item"><a href="https://plus.google.com/+VirginAmerica/" target="_blank" rel="publisher">Google+</a></li>
                        </ul>
                        <ul class="footer-nav__list is-omega">
                            <li class="footer-nav__item"><a href="http://instagram.com/virginamerica" target="_blank" rel="me">Instagram</a></li>
                            <li class="footer-nav__item"><a href="https://twitter.com/VirginAmerica" target="_blank" rel="me">Twitter</a></li>
                            <li class="footer-nav__item"><a href="https://www.facebook.com/VirginAmerica" target="_blank" rel="me">Facebook</a></li>
                            <li class="footer-nav__item"><a href="https://www.youtube.com/user/VirginAmerica" target="_blank" rel="me">YouTube</a></li>
                        </ul>
                    </nav>
                    <div class="footer-copy">
                        &copy; 2014 Virgin America
                    </div>
                </div>
            </div>
        </footer>
        <script>
	        //document.body.scrollTop = document.documentElement.scrollTop = 0;
        /*  var $jq = jQuery.noConflict(true);
		  jQuery( document ).ready(function() {
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
            })(); */
        </script>
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=\RightNow\Utils\Url::getCoreAssetPath('js/4.171/min/RightNow.js');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>templates<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/login/LogoutLink', 1 => 'standard/login/LoginDialog', ), '/standard.js', '1436303720');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/EventProvider.js', 1 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/Form.js', 2 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/Field.js', 3 => 'standard/login/ResetPassword', 4 => 'standard/input/FormSubmit', 5 => 'standard/input/SelectionInput', 6 => 'standard/input/DateInput', 7 => 'standard/input/PasswordInput', 8 => 'standard/input/TextInput', ), '/account/reset_password.js', '1436303720');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'FORMSUBMIT_PLACED_FORM_UNIQUE_ID_MSG' => array ( 'value' => 2021, ), 'PLS_VERIFY_REQ_ENTERING_TEXT_IMG_MSG' => array ( 'value' => 19038, ), 'VALUE_MUST_BE_AN_INTEGER_MSG' => array ( 'value' => 4127, ), 'VALUE_IS_TOO_LARGE_MAX_VALUE_MSG' => array ( 'value' => 4125, ), 'VALUE_IS_TOO_SMALL_MIN_VALUE_MSG' => array ( 'value' => 4126, ), 'CONTAIN_1_CHARACTER_MSG' => array ( 'value' => 42414, ), 'PCT_D_CHARACTERS_MSG' => array ( 'value' => 2973, ), 'EXCEEDS_SZ_LIMIT_PCT_D_CHARS_1_LBL' => array ( 'value' => 42160, ), 'EXCEEDS_SZ_LIMIT_PCT_D_CHARS_PCT_D_LBL' => array ( 'value' => 1855, ), 'PCT_S_IS_AN_INVALID_POSTAL_CODE_MSG' => array ( 'value' => 3027, ), 'PCT_S_IS_AN_INVALID_PHONE_NUMBER_MSG' => array ( 'value' => 3026, ), 'PCT_S_CONT_SPACES_DOUBLE_QUOTES_LBL' => array ( 'value' => 41426, ), 'PCT_S_DIDNT_MATCH_EXPECTED_INPUT_LBL' => array ( 'value' => 3010, ), 'CONTAIN_SPACES_PLEASE_TRY_MSG' => array ( 'value' => 1344, ), 'PCT_S_IS_INVALID_MSG' => array ( 'value' => 3030, ), 'IS_NOT_A_VALID_URL_MSG' => array ( 'value' => 2246, ), 'ERROR_PAGE_PLEASE_S_TRY_MSG' => array ( 'value' => 1805, ), 'FORM_EXP_PLS_CONFIRM_WISH_CONTINUE_MSG' => array ( 'value' => 2017, ), 'FIELD_REQUIRED_MARK_LBL' => array ( 'value' => 1908, ), 'REQUIRED_LBL' => array ( 'value' => 7015, ), 'PCT_S_IS_NOT_COMPLETELY_FILLED_IN_MSG' => array ( 'value' => 3032, ), 'PCT_S_IS_NOT_A_VALID_DATE_MSG' => array ( 'value' => 3031, ), 'VALUE_MIN_VALUE_PCT_S_MSG' => array ( 'value' => 40743, ), 'PCT_S_REQUIREMENTS_MET_LBL' => array ( 'value' => 41070, ), 'PASSWD_VALIDATION_REQS_READ_L_MSG' => array ( 'value' => 40556, ), 'PASSWORD_IS_TOO_SHORT_MSG' => array ( 'value' => 40563, ), 'PERFECT_LBL' => array ( 'value' => 40581, ), 'PASSWORD_IS_TOO_INSECURE_MSG' => array ( 'value' => 40562, ), 'COMPLETE_LBL' => array ( 'value' => 9461, ), 'INCOMPLETE_LBL' => array ( 'value' => 40451, ), 'EXPECTED_INPUT_LBL' => array ( 'value' => 1870, ), 'WAITING_FOR_CHARACTER_LBL' => array ( 'value' => 4166, ), 'PLEASE_TYPE_A_NUMBER_MSG' => array ( 'value' => 3160, ), 'PLEASE_ENTER_UPPERCASE_LETTER_MSG' => array ( 'value' => 3148, ), 'PLEASE_ENTER_AN_UPPERCASE_LETTER_MSG' => array ( 'value' => 3137, ), 'PLS_ENTER_UPPERCASE_LETTER_SPECIAL_MSG' => array ( 'value' => 3165, ), 'PLEASE_ENTER_LOWERCASE_LETTER_MSG' => array ( 'value' => 3145, ), 'PLEASE_ENTER_A_LOWERCASE_LETTER_MSG' => array ( 'value' => 3136, ), 'PLS_ENTER_LOWERCASE_LETTER_SPECIAL_MSG' => array ( 'value' => 3164, ), 'PLEASE_ENTER_A_LETTER_OR_A_NUMBER_MSG' => array ( 'value' => 3135, ), 'PLEASE_ENTER_A_LETTER_MSG' => array ( 'value' => 3134, ), 'PLEASE_ENTER_LETTER_SPECIAL_CHAR_MSG' => array ( 'value' => 3144, ), 'THE_INPUT_IS_TOO_LONG_MSG' => array ( 'value' => 3920, ), 'THE_INPUT_IS_TOO_SHORT_MSG' => array ( 'value' => 3921, ), 'CHARACTER_LBL' => array ( 'value' => 1140, ), 'PCT_S_MUST_NOT_CONTAIN_SPACES_MSG' => array ( 'value' => 3042, ), 'USERNAME_LBL' => array ( 'value' => 4846, ), 'PCT_S_CONTAIN_DOUBLE_QUOTES_MSG' => array ( 'value' => 3005, ), 'PCT_S_CNT_THAN_MSG' => array ( 'value' => 3002, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
