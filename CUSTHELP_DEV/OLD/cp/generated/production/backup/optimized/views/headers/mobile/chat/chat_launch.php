<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/mobile', 1 => '/euf/assets/themes/mobile', 2 => array ( '/euf/assets/themes/mobile' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile', ), ));
get_instance()->_checkMeta(array('javascript_module'=>'mobile_may_10', 'title'=>'' . \RightNow\Utils\Config::msgGetFrom((5984)) . '', 'template'=>'mobile.php', 'clickstream'=>'chat_request'));
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
class ChatLaunchFormOpen extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatLaunchFormOpen_view ($data) {
extract($data);
?><span class="rn_ChatLaunchFormHeader"><?=$this->data['attrs']['label_form_header']?></span>
<form id="rn_<?=$this->instanceID?>_Form" method="post" action="/app/chat/chat_landing">
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->reportError(sprintf(\RightNow\Utils\Config::getMessage((41763)), "November '12"), false);
}
}
function _standard_chat_ChatLaunchFormOpen_header() {
$result = array( 'js_name' => '', 'library_name' => 'ChatLaunchFormOpen', 'view_func_name' => '_standard_chat_ChatLaunchFormOpen_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatLaunchFormOpen', 'view_path' => 'standard/chat/ChatLaunchFormOpen', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ChatLaunchFormOpen.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(41940)', ), 'relativePath' => 'standard/chat/ChatLaunchFormOpen', 'widget_name' => 'ChatLaunchFormOpen', ), );
$result['meta']['attributes'] = array( 'label_form_header' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1161), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(1161), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ContactNameInput extends \RightNow\Libraries\Widget\Base {
function _standard_input_ContactNameInput_view ($data) {
extract($data);
?>
<? $initialFocus = $this->data['attrs']['initial_focus_on_first_field'] ? 'true' : 'false';
?>
<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => '' . $this->data['names'][0] . '','initial_focus' => '' . $initialFocus . '','label_input' => '' . $this->data['labels'][0] . '','sub_id' => 'first',));
?>
<? if (!$this->data['attrs']['short_name']): ?>
<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => '' . $this->data['names'][1] . '','label_input' => '' . $this->data['labels'][1] . '','sub_id' => 'last',));
?>
<? endif;
?>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['names'] = array('Contact.Name.First', 'Contact.Name.Last');
$this->data['labels'] = array(\RightNow\Utils\Config::getMessage((4790)), \RightNow\Utils\Config::getMessage((4793)));
if (\RightNow\Utils\Config::getConfig((134))) {
$this->data['names'] = array_reverse($this->data['names']);
$this->data['labels'] = array_reverse($this->data['labels']);
}
}
}
function _standard_input_ContactNameInput_header() {
$result = array( 'js_name' => '', 'library_name' => 'ContactNameInput', 'view_func_name' => '_standard_input_ContactNameInput_view', 'meta' => array ( 'controller_path' => 'standard/input/ContactNameInput', 'view_path' => 'standard/input/ContactNameInput', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4204)', ), 'contains' => array ( 0 => array ( 'widget' => 'standard/input/FormInput', 'versions' => array ( 0 => '1.1', ), ), ), 'relativePath' => 'standard/input/ContactNameInput', 'widget_name' => 'ContactNameInput', ), );
$result['meta']['attributes'] = array( 'initial_focus_on_first_field' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOL', 'default' => false, 'inherited' => false, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOL', 'default' => false, 'inherited' => false, )), 'short_name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOL', 'default' => false, 'inherited' => false, )), );
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
class ChatLaunchButton extends FormSubmit {
function _standard_chat_ChatLaunchButton_view ($data) {
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
parent::getData();
$this->data['js']['chatWindowName'] = \RightNow\Utils\Config::getConfig((120)) . \RightNow\Api::intf_id();
if($this->attrs['protocol_selection']->value === 'auto') $this->data['js']['baseUrl'] = \RightNow\Utils\Url::getShortEufBaseUrl('sameAsCurrentPage');
else $this->data['js']['baseUrl'] = 'http' . ($this->attrs['protocol_selection']->value === 'ssl' ? 's' : '') . '://' . \RightNow\Utils\Config::getConfig((9));
$chatHours = $this->CI->model('Chat')->getChatHours()->result;
$this->data['js']['isBrowserSupported'] = $this->CI->model('Chat')->isBrowserSupported();
$this->data['js']['showForm'] = $chatHours['inWorkHours'] && !$chatHours['holiday'] && $this->data['js']['isBrowserSupported'];
}
}
function _standard_chat_ChatLaunchButton_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatLaunchButton', 'library_name' => 'ChatLaunchButton', 'view_func_name' => '_standard_chat_ChatLaunchButton_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatLaunchButton', 'view_path' => '', 'js_path' => 'standard/chat/ChatLaunchButton', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatLaunchButton.css', 1 => 'assets/themes/standard/widgetCss/ChatLaunchButton.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatLaunchButton/base.css', ), 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4280)', ), 'extends' => array ( 'widget' => 'standard/input/FormSubmit', 'versions' => array ( 0 => '1.2', ), 'components' => array ( 'php' => true, 'js' => true, ), ), 'relativePath' => 'standard/chat/ChatLaunchButton', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/FormSubmit', ), 'view' => array ( 0 => 'standard/input/FormSubmit', ), 'logic' => array ( 0 => 'standard/input/FormSubmit', ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/input/FormSubmit', ), 'widget_name' => 'ChatLaunchButton', 'extends_php' => array ( 0 => 'standard/input/FormSubmit', ), 'extends_js' => array ( 0 => 'standard/input/FormSubmit', ), 'extends_view' => array ( 0 => 'standard/input/FormSubmit', ), 'parent' => 'standard/input/FormSubmit', ), );
$result['meta']['attributes'] = array( 'label_form_header' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1161), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1161), 'inherited' => false, )), 'launch_width' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 380, 'type' => 'INT', 'default' => 380, 'inherited' => false, )), 'launch_height' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 495, 'type' => 'INT', 'default' => 495, 'inherited' => false, )), 'open_in_new_window' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'enable_scrollbars' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4550), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4550), 'inherited' => true, )), 'label_submitting_message' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3842), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3842), 'inherited' => true, )), 'loading_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/indicator.gif', 'type' => 'filepath', 'default' => 'images/indicator.gif', 'inherited' => true, )), 'error_location' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'timeout' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'min' => 0, 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatHours extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatHours_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <div id="rn_<?=$this->instanceID;?>_HoursLabel" class="rn_HoursLabel">
        <?=$this->data['attrs']['label_chat_hours'];?>
    </div>
    <div id="rn_<?=$this->instanceID;?>_HoursBlock" class="rn_HoursBlock">
        <?for
($i = 0;
$i < count($this->data['chatHours']['hours']);
$i++): ?>
            <div>
                <span id="rn_<?=$this->instanceID;?>_HoursPrefix_<?=$i?>" class="rn_HoursPrefix">
                    <?=$this->data['chatHours']['hours'][$i][0]
?><?= ((LANG_DIR == fr_FR) || (LANG_DIR == fr_CA) ? '&nbsp' : '');
?>:&nbsp;
                </span>
                <span id="rn_<?=$this->instanceID;?>_Hours_<?=$i?>" class="rn_Hours">
                    <?=$this->data['chatHours']['hours'][$i][1]
?>
                </span>
            </div>
        <? endfor;?>
    </div>
    <?if($this->data['chatHours']['holiday']):?>
        <div id="rn_<?=$this->instanceID;?>_Holiday" class="rn_Holiday">
            <?=$this->data['attrs']['label_holiday'];?>
        </div>
    <?
endif;?>
    <div id="rn_<?=$this->instanceID;?>_CurrentTime" class="rn_CurrentTime">
        <?=$this->data['chatHours']['current_time'];?>
    </div>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['chatHours'] = $this->CI->model('Chat')->getChatHours()->result;
$this->data['show_hours'] = !$this->data['chatHours']['inWorkHours'];
}
}
function _standard_chat_ChatHours_header() {
$result = array( 'js_name' => '', 'library_name' => 'ChatHours', 'view_func_name' => '_standard_chat_ChatHours_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatHours', 'view_path' => 'standard/chat/ChatHours', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatHours.css', 1 => 'assets/themes/standard/widgetCss/ChatHours.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(22712)', ), 'relativePath' => 'standard/chat/ChatHours', 'widget_name' => 'ChatHours', ), );
$result['meta']['attributes'] = array( 'label_holiday' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2254), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2254), 'inherited' => false, )), 'label_chat_hours' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1152), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1152), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatStatus extends \RightNow\Widgets\ChatHours {
function _standard_chat_ChatStatus_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
<? if($this->data['chatHours']['inWorkHours'] && !$this->data['chatHours']['holiday']):?>
    <?=$this->data['attrs']['label_chat_available'];?>
<?
else:?>
    <?=$this->data['attrs']['label_chat_unavailable'];?>
<?
endif;?>
</div>
<?
}
}
function _standard_chat_ChatStatus_header() {
$result = array( 'js_name' => '', 'library_name' => 'ChatStatus', 'view_func_name' => '_standard_chat_ChatStatus_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatStatus', 'view_path' => 'standard/chat/ChatStatus', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatStatus.css', 1 => 'assets/themes/standard/widgetCss/ChatStatus.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/chat/ChatHours', 'versions' => array ( 0 => '1.0', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'info' => array ( 'description' => 'rn:msg:(22003)', ), 'relativePath' => 'standard/chat/ChatStatus', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/chat/ChatHours', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/chat/ChatHours', ), 'widget_name' => 'ChatStatus', 'extends_php' => array ( 0 => 'standard/chat/ChatHours', ), 'parent' => 'standard/chat/ChatHours', ), );
$result['meta']['attributes'] = array( 'label_chat_available' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4802), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4802), 'inherited' => false, )), 'label_chat_unavailable' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3698), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3698), 'inherited' => false, )), );
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
class MobileNavigationMenu extends \RightNow\Libraries\Widget\Base {
function _standard_navigation_MobileNavigationMenu_view ($data) {
extract($data);
?><span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
<button type="button" id="rn_<?=$this->instanceID;?>_Link"><?=$this->data['attrs']['label_button'];?></button>
</span>
<?
}
}
function _standard_navigation_MobileNavigationMenu_header() {
$result = array( 'js_name' => 'RightNow.Widgets.MobileNavigationMenu', 'library_name' => 'MobileNavigationMenu', 'view_func_name' => '_standard_navigation_MobileNavigationMenu_view', 'meta' => array ( 'controller_path' => 'standard/navigation/MobileNavigationMenu', 'view_path' => 'standard/navigation/MobileNavigationMenu', 'js_path' => 'standard/navigation/MobileNavigationMenu', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/MobileNavigationMenu.css', ), 'base_css' => array ( 0 => 'standard/navigation/MobileNavigationMenu/base.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4255)', ), 'relativePath' => 'standard/navigation/MobileNavigationMenu', 'widget_name' => 'MobileNavigationMenu', ), );
$result['meta']['attributes'] = array( 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(7520), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(7520), 'inherited' => false, )), 'label_parent_menu_alt' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(29091), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(29091), 'inherited' => false, )), 'submenu' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'css_class' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'rn_Selected', 'type' => 'STRING', 'default' => 'rn_Selected', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class MobileSimpleSearch extends \RightNow\Libraries\Widget\Base {
function _standard_search_MobileSimpleSearch_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <form id="rn_<?=$this->instanceID;?>_SearchForm" onsubmit="return false;">
        <label for="rn_<?=$this->instanceID;?>_SearchField" class="rn_ScreenReaderOnly"><?=$this->data['attrs']['label_hint'];?></label>
        <input type="text" id="rn_<?=$this->instanceID;?>_SearchField" name="rn_<?=$this->instanceID;?>_SearchField" class="<?=$this->data['cssClass'];?>" maxlength="255" value="<?=$this->data['attrs']['label_hint'];?>"/>
        <?
if ($this->data['attrs']['clear_text_icon_path']): ?>
        <div id="rn_<?=$this->instanceID;?>_Clear" role="button" aria-label="<?=$this->data['attrs']['label_clear_text_icon'];?>" class="rn_ClearText rn_Hidden"><img src="<?=$this->data['attrs']['clear_text_icon_path'];?>" alt=""/></div>
        <?
endif;
?>
        <? if ($this->data['attrs']['search_icon_path']): ?>
        <input type="image" id="rn_<?=$this->instanceID;?>_Submit" class="rn_SearchImage" src="<?=$this->data['attrs']['search_icon_path'];?>" alt="<?=$this->data['attrs']['label_search'];?>"/>
        <?
else: ?>
        <input type="submit" id="rn_<?=$this->instanceID;?>_Submit" class="rn_SearchButton" value="<?=$this->data['attrs']['label_search'];?>"/>
        <?
endif;?>
    </form>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if($this->data['attrs']['report_page_url'] === '') $this->data['attrs']['report_page_url'] = '/app/' . $this->CI->page;
$this->data['cssClass'] = (($this->data['attrs']['clear_text_icon_path']) ? 'rn_RightPadding' : '') . (($this->data['attrs']['search_icon_path']) ? ' rn_LeftPadding' : '');
}
}
function _standard_search_MobileSimpleSearch_header() {
$result = array( 'js_name' => 'RightNow.Widgets.MobileSimpleSearch', 'library_name' => 'MobileSimpleSearch', 'view_func_name' => '_standard_search_MobileSimpleSearch_view', 'meta' => array ( 'controller_path' => 'standard/search/MobileSimpleSearch', 'view_path' => 'standard/search/MobileSimpleSearch', 'js_path' => 'standard/search/MobileSimpleSearch', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/MobileSimpleSearch.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4367)', ), 'relativePath' => 'standard/search/MobileSimpleSearch', 'widget_name' => 'MobileSimpleSearch', ), );
$result['meta']['attributes'] = array( 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/answers/list', 'type' => 'STRING', 'default' => '/app/answers/list', 'inherited' => false, )), 'search_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'filepath', 'default' => '', 'inherited' => false, )), 'clear_text_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/x.png', 'type' => 'filepath', 'default' => 'images/x.png', 'inherited' => false, )), 'label_clear_text_icon' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1188), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1188), 'inherited' => false, )), 'label_search' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4693), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4693), 'inherited' => false, )), 'label_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
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
class PageSetSelector extends \RightNow\Libraries\Widget\Base {
function _standard_utils_PageSetSelector_view ($data) {
extract($data);
?><span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <?=$this->data['attrs']['label_message'];?>
    <?
foreach($this->data['sets'] as $key => $set):?>
        <? if($set['current']):?>
            <span class="rn_Bold"><?=$set['label'];?></span>
        <?
else:?>
            <a href="/ci/redirect/pageSet/<?=urlencode($set['mapping'])?>/<?=htmlspecialchars($this->data['currentPage'], ENT_QUOTES, 'UTF-8')?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=$set['label'];?></a>
        <?
endif;?>
        <?=((++$count
< count($this->data['sets'])) ? '|' : '');?>
    <?
endforeach;?>
</span>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(!\RightNow\Utils\Config::getConfig((238))) {
echo $this->reportError(\RightNow\Utils\Config::getMessage((1406)));
return false;
}
$this->data['sets'] = array('/' => array());
$sets = explode(',', trim($this->data['attrs']['page_sets']));
if(!count(array_filter($sets))) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((2997)), 'page_sets'));
return false;
}
$enabledPageSetMappings = $this->CI->model('Pageset')->getEnabledPageSetMappingArrays();
foreach($sets as $set) {
list($pageSet, $label) = array_map('trim', explode('>', $set));
if ($pageSet === "default" || isset($enabledPageSetMappings[$pageSet])) {
$this->data['sets'][$pageSet]['label'] = $label;
$this->data['sets'][$pageSet]['mapping'] = $pageSet;
}
}
$cookie = $_COOKIE['agent'];
if(!$cookie) {
$currentPageSet = $this->CI->getPageSetPath();
$cookie = $currentPageSet ? $currentPageSet : '/';
}
if($cookie) {
if($this->data['sets']['default']) {
$this->data['sets']['/'] = $this->data['sets']['default'];
unset($this->data['sets']['default']);
if($cookie === '/') $this->data['sets']['/']['current'] = true;
}
if($this->data['sets'][$cookie]) {
$this->data['sets'][$cookie]['current'] = true;
}
if($this->data['attrs']['cookie_expiration']) {
$this->data['expires'] = date(DATE_COOKIE, time() + ($this->data['attrs']['cookie_expiration'] * 86400));
}
$this->data['secure'] = \RightNow\Utils\Config::getConfig((25), 'COMMON') ? 'secure' : '';
}
if (count($this->data['sets']) <= 1) {
$this->classList->add('rn_Hidden');
$this->classList->remove('rn_PageSetSelector');
}
$this->data['currentPage'] = \RightNow\Utils\Text::getSubstringAfter(ORIGINAL_REQUEST_URI, "/app/");
}
}
function _standard_utils_PageSetSelector_header() {
$result = array( 'js_name' => '', 'library_name' => 'PageSetSelector', 'view_func_name' => '_standard_utils_PageSetSelector_view', 'meta' => array ( 'controller_path' => 'standard/utils/PageSetSelector', 'view_path' => 'standard/utils/PageSetSelector', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/PageSetSelector.css', 1 => 'assets/themes/mobile/widgetCss/PageSetSelector.css', 2 => 'assets/themes/standard/widgetCss/PageSetSelector.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', 1 => 'standard', 2 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4224)', ), 'relativePath' => 'standard/utils/PageSetSelector', 'widget_name' => 'PageSetSelector', ), );
$result['meta']['attributes'] = array( 'cookie_expiration' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 10, 'type' => 'INT', 'default' => 10, 'inherited' => false, )), 'label_message' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4157), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4157), 'inherited' => false, )), 'page_sets' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => sprintf('default > %s, mobile > %s, basic > %s', \RightNow\Utils\Config::getMessage((1572)), \RightNow\Utils\Config::getMessage((4880)), \RightNow\Utils\Config::getMessage((43115))), 'type' => 'STRING', 'default' => sprintf('default > %s, mobile > %s, basic > %s', \RightNow\Utils\Config::getMessage((1572)), \RightNow\Utils\Config::getMessage((4880)), \RightNow\Utils\Config::getMessage((43115))), 'inherited' => false, )), );
return $result;
}
}
namespace{
use \RightNow\Utils\FileSystem;
?>
<!DOCTYPE html>
<html lang="<?=\RightNow\Utils\Text::getLanguageCode();?>">
    <head>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
        <meta charset="utf-8"/>
        <title><?=\RightNow\Utils\Tags::getPageTitleAtRuntime();?></title>
        <?=
\RightNow\Libraries\SEO::getCanonicalLinkTag() . "\n";
?>
<style type='text/css'>
 <!-- 
.rn_ScreenReaderOnly{position:absolute; height:1px; left:-10000px; overflow:hidden; top:auto; width:1px;}
.rn_Hidden{display:none;}
 --></style>
<base href='<?=\RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest', \RightNow\Utils\FileSystem::getOptimizedAssetsDir() . 'themes/mobile/');?>'/>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>templates/mobile.themes.mobile.SITE.css' rel='stylesheet' type='text/css' media='all'/>
<style type="text/css">
<!--
.rn_MobileNavigationMenu button{padding:6px 10px;width:auto;}
.rn_MobileNavigationMenu.rn_Menu li a .rn_ParentMenuAlt{opacity:0;position:absolute;left:0;}
.rn_MobileNavigationMenu button{background:#597EAA;background: -moz-linear-gradient(top, rgba(154, 175, 202, 1.0), rgba(89, 126, 170, 1.0), rgba(90, 127, 171, 1.0));background: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(0.0, rgba(154, 175, 202, 1.0)), color-stop(0.5, rgba(89, 126, 170, 1.0)), color-stop(1.0, rgba(90, 127, 171, 1.0)));border:1px solid #AAA;border-color:#444 #999 #DDD;color:#FFF;display:block;font-size:inherit;font-weight:bold;margin-top:5px;text-shadow:1px 1px 3px rgba(0, 0, 0, .5);-moz-border-radius:6px;-moz-box-shadow:0 0 0 rgba(0, 0, 0, .5);-webkit-box-shadow:0 0 0 rgba(0, 0, 0, .5);-webkit-border-radius:6px;}
.rn_MobileNavigationMenu button.rn_Selected{background:#38547B;background: -moz-linear-gradient(top, #7084A0 0%, #39567F 50%, #364F70 100%);background: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(0.0, #7084A0), color-stop(0.5, #39567F), color-stop(1.0, #364F70));}
.rn_MobileNavigationMenu.rn_Menu{padding:20px 0 0;}
.rn_MobileNavigationMenu.rn_Menu li a{border-bottom:1px solid #DDD;color:#FFF;display:block;font-size:1.5em;font-weight:bold;padding:26px 16px;line-height:1.15em;}
.rn_MobileNavigationMenu.rn_Menu li a.rn_ParentMenu{background:transparent url(<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile/images/layout/whiteListArrow.png) no-repeat right;}
.rn_MobileSimpleSearch{margin:auto;width:80%;}
.rn_MobileSimpleSearch form{position:relative;}
.rn_MobileSimpleSearch .rn_ClearText{height:30px;padding:8px 0 0 8px;position:absolute;right:0;top:0;width:30px;z-index:100;}
.rn_MobileSimpleSearch input[type="submit"]{font-size:1.7em;}
.rn_MobileSimpleSearch input[type="text"]{margin-bottom:12px;}
.rn_MobileSimpleSearch input[type="text"].rn_LeftPadding{padding-left:10%;width:89%;}
.rn_MobileSimpleSearch input[type="text"].rn_RightPadding{padding-right:10%;width:89%;}
.rn_MobileSimpleSearch input[type="text"].rn_LeftPadding.rn_RightPadding{width:79%;}
.rn_MobileSimpleSearch input[type="image"]{border:none;padding:10px 0 10px 2.5%;position:absolute;left:0;top:0;z-index:100;}
.rn_PageSetSelector{display:block;margin-bottom:16px;}
-->
</style>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>pages/mobile/chat/chat_launch.themes.mobile.css' rel='stylesheet' type='text/css' media='all'/>
9c1379bc-cca6-4750-aee7-188f8348a6c3
        <link rel="icon" href="images/favicon.png" type="image/png">
    </head>
    <body>
        <noscript><h1><?=\RightNow\Utils\Config::msgGetFrom((4861));?></h1></noscript>
        <header role="banner">
            <?if(
(true) ):?>
            <nav id="rn_Navigation" role="navigation">
                <span class="rn_FloatLeft">
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/navigation/MobileNavigationMenu', array('submenu' => 'rn_MenuList',));
?>
                </span>
                <ul id="rn_MenuList" class="rn_Hidden">
                    <li>
                        <a href="/app/home<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2097));?></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="rn_ParentMenu"><?=\RightNow\Utils\Config::msgGetFrom((1340));?></a>
                        <ul class="rn_Submenu rn_Hidden">
                            <li><a href="/app/chat/chat_launch<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((7494));?></a></li>
                            <li><a href="/app/ask<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((1748));?></a></li>
                            <li><a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((1109));?></a></li>
                            <li><a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((1025));?></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="rn_ParentMenu"><?=\RightNow\Utils\Config::msgGetFrom((4436));?></a>
                        <ul class="rn_Submenu rn_Hidden">
                            <?if(
(!\RightNow\Utils\Framework::isLoggedIn()) ):?>
                            <li><a href="/app/utils/create_account<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((3650));?></a></li>
                            <li><a href="/app/utils/login_form<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a></li>
                            <li><a href="/app/utils/account_assistance<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((901));?></a></li>
                            <?endif;?>
                            <li><a href="/app/account/questions/list<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((4163));?></a></li>
                            <li><a href="/app/account/profile<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((1135));?></a></li>
                        </ul>
                    </li>
                </ul>
                <span class="rn_FloatRight rn_Search" role="search">
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/navigation/MobileNavigationMenu',
array('label_button' => '' . \RightNow\Utils\Config::msgGetFrom((6920)) . '<img src=\'images/search.png\' alt=\'' . \RightNow\Utils\Config::msgGetFrom((6920)) . '\'/>','submenu' => 'rn_SearchForm',));
?>
                </span>
                <div id="rn_SearchForm" class="rn_Hidden">
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/MobileSimpleSearch', array('report_page_url' => '/app/answers/list',));
?>
                </div>
            </nav>
            <?endif;?>
        </header>
        <section role="main">
<section id="rn_PageTitle" class="rn_LiveHelp">
    <h1><?=\RightNow\Utils\Config::msgGetFrom((1176));?></h1>
</section>
<section id="rn_PageContent" class="rn_LiveHelp">
    <div class="rn_Padding" >
        <div class="rn_ChatForm">
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatLaunchFormOpen',
array());
?>
            <div id="rn_ErrorLocation"></div>
            <fieldset>
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/ContactNameInput', array('required' => 'true',));
?>
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/FormInput', array('name' => 'contacts.email','required' => 'true',));
?>
            </fieldset>
            <br />
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatLaunchButton', array('error_location' => 'rn_ErrorLocation','open_in_new_window' => 'false',));
?>
            <br /><br />
            </form>
       </div>
       <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatStatus', array());
?>
       <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatHours', array());
?>
    </div>
</section>
        </section>
        <footer role="contentinfo">
            <?if( (true) ):?>
                <div>
                    <?if( (\RightNow\Utils\Framework::isLoggedIn()) ):?>
                    <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array ( 0 => 'Contact', 1 => 'Emails', 2 => 'PRIMARY', 3 => 'Address', ), false);?><?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/LogoutLink',
array());
?>
                    <?else:?>
                    <a href="/app/utils/login_form<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a>
                    <?endif;?>
                    <br/><br/>
                </div>
                <?if(
((get_instance()->page !== 'utils/guided_assistant') ) ):?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/PageSetSelector', array());
?>
                <?endif;?>
                <div class="rn_FloatLeft"><a href="javascript:window.scrollTo(0, 0);"><?=\RightNow\Utils\Config::msgGetFrom((1018));?></a></div>
            <?endif;?>
            <div class="rn_FloatRight">Powered by <a href="http://www.rightnow.com">RightNow</a></div>
            <br/><br/>
        </footer>
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>templates<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/navigation/MobileNavigationMenu', 1 => 'standard/search/MobileSimpleSearch', 2 => 'standard/login/LogoutLink', ), '/mobile.js', '1436303720');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/EventProvider.js', 1 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/Form.js', 2 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/Field.js', 3 => 'standard/input/FormSubmit', 4 => 'standard/chat/ChatLaunchButton', 5 => 'standard/input/SelectionInput', 6 => 'standard/input/DateInput', 7 => 'standard/input/PasswordInput', 8 => 'standard/input/TextInput', ), '/mobile/chat/chat_launch.js', '1436303720');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'FORMSUBMIT_PLACED_FORM_UNIQUE_ID_MSG' => array ( 'value' => 2021, ), 'PLS_VERIFY_REQ_ENTERING_TEXT_IMG_MSG' => array ( 'value' => 19038, ), 'VALUE_MUST_BE_AN_INTEGER_MSG' => array ( 'value' => 4127, ), 'VALUE_IS_TOO_LARGE_MAX_VALUE_MSG' => array ( 'value' => 4125, ), 'VALUE_IS_TOO_SMALL_MIN_VALUE_MSG' => array ( 'value' => 4126, ), 'CONTAIN_1_CHARACTER_MSG' => array ( 'value' => 42414, ), 'PCT_D_CHARACTERS_MSG' => array ( 'value' => 2973, ), 'EXCEEDS_SZ_LIMIT_PCT_D_CHARS_1_LBL' => array ( 'value' => 42160, ), 'EXCEEDS_SZ_LIMIT_PCT_D_CHARS_PCT_D_LBL' => array ( 'value' => 1855, ), 'PCT_S_IS_AN_INVALID_POSTAL_CODE_MSG' => array ( 'value' => 3027, ), 'PCT_S_IS_AN_INVALID_PHONE_NUMBER_MSG' => array ( 'value' => 3026, ), 'PCT_S_CONT_SPACES_DOUBLE_QUOTES_LBL' => array ( 'value' => 41426, ), 'PCT_S_DIDNT_MATCH_EXPECTED_INPUT_LBL' => array ( 'value' => 3010, ), 'CONTAIN_SPACES_PLEASE_TRY_MSG' => array ( 'value' => 1344, ), 'PCT_S_IS_INVALID_MSG' => array ( 'value' => 3030, ), 'IS_NOT_A_VALID_URL_MSG' => array ( 'value' => 2246, ), 'ERROR_PAGE_PLEASE_S_TRY_MSG' => array ( 'value' => 1805, ), 'FORM_EXP_PLS_CONFIRM_WISH_CONTINUE_MSG' => array ( 'value' => 2017, ), 'CHAT_SUPP_BROWSER_CHAT_AVAIL_MSG' => array ( 'value' => 40313, ), 'FIELD_REQUIRED_MARK_LBL' => array ( 'value' => 1908, ), 'REQUIRED_LBL' => array ( 'value' => 7015, ), 'PCT_S_IS_NOT_COMPLETELY_FILLED_IN_MSG' => array ( 'value' => 3032, ), 'PCT_S_IS_NOT_A_VALID_DATE_MSG' => array ( 'value' => 3031, ), 'VALUE_MIN_VALUE_PCT_S_MSG' => array ( 'value' => 40743, ), 'PCT_S_REQUIREMENTS_MET_LBL' => array ( 'value' => 41070, ), 'PASSWD_VALIDATION_REQS_READ_L_MSG' => array ( 'value' => 40556, ), 'PASSWORD_IS_TOO_SHORT_MSG' => array ( 'value' => 40563, ), 'PERFECT_LBL' => array ( 'value' => 40581, ), 'PASSWORD_IS_TOO_INSECURE_MSG' => array ( 'value' => 40562, ), 'COMPLETE_LBL' => array ( 'value' => 9461, ), 'INCOMPLETE_LBL' => array ( 'value' => 40451, ), 'EXPECTED_INPUT_LBL' => array ( 'value' => 1870, ), 'WAITING_FOR_CHARACTER_LBL' => array ( 'value' => 4166, ), 'PLEASE_TYPE_A_NUMBER_MSG' => array ( 'value' => 3160, ), 'PLEASE_ENTER_UPPERCASE_LETTER_MSG' => array ( 'value' => 3148, ), 'PLEASE_ENTER_AN_UPPERCASE_LETTER_MSG' => array ( 'value' => 3137, ), 'PLS_ENTER_UPPERCASE_LETTER_SPECIAL_MSG' => array ( 'value' => 3165, ), 'PLEASE_ENTER_LOWERCASE_LETTER_MSG' => array ( 'value' => 3145, ), 'PLEASE_ENTER_A_LOWERCASE_LETTER_MSG' => array ( 'value' => 3136, ), 'PLS_ENTER_LOWERCASE_LETTER_SPECIAL_MSG' => array ( 'value' => 3164, ), 'PLEASE_ENTER_A_LETTER_OR_A_NUMBER_MSG' => array ( 'value' => 3135, ), 'PLEASE_ENTER_A_LETTER_MSG' => array ( 'value' => 3134, ), 'PLEASE_ENTER_LETTER_SPECIAL_CHAR_MSG' => array ( 'value' => 3144, ), 'THE_INPUT_IS_TOO_LONG_MSG' => array ( 'value' => 3920, ), 'THE_INPUT_IS_TOO_SHORT_MSG' => array ( 'value' => 3921, ), 'CHARACTER_LBL' => array ( 'value' => 1140, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
