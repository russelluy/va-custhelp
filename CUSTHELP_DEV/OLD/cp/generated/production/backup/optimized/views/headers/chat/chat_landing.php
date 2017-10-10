<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/standard', 1 => '/euf/assets/themes/standard', 2 => array ( '/euf/assets/themes/standard' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/standard', ), ));
get_instance()->_checkMeta(array('clickstream'=>'chat_landing', 'include_chat'=>'true'));
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
class ChatPostMessage extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatPostMessage_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <div><?=$this->data['attrs']['label_send_instructions'];?></div>
    <span>
        <textarea id="rn_<?=$this->instanceID;?>_Input" rows="3" cols="50"></textarea>
    </span>
</div>
<?
}
}
function _standard_chat_ChatPostMessage_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatPostMessage', 'library_name' => 'ChatPostMessage', 'view_func_name' => '_standard_chat_ChatPostMessage_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatPostMessage', 'view_path' => 'standard/chat/ChatPostMessage', 'js_path' => 'standard/chat/ChatPostMessage', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatPostMessage.css', 1 => 'assets/themes/standard/widgetCss/ChatPostMessage.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatPostMessage/base.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), 'yui' => array ( 0 => 'event-valuechange', 1 => 'event-key', ), ), 'info' => array ( 'description' => 'rn:msg:(4334)', ), 'relativePath' => 'standard/chat/ChatPostMessage', 'widget_name' => 'ChatPostMessage', ), );
$result['meta']['attributes'] = array( 'label_send_instructions' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4820), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4820), 'inherited' => false, )), 'all_posts_off_the_record' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'mobile_mode' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'focus_on_incoming_messages' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatOffTheRecordDialog extends \RightNow\Widgets\ChatPostMessage {
function _standard_chat_ChatOffTheRecordDialog_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <div><?=$this->data['attrs']['label_send_instructions'];?></div>
    <span>
        <textarea id="rn_<?=$this->instanceID;?>_Input" rows="3" cols="50"></textarea>
    </span>
</div>
<?
}
}
function _standard_chat_ChatOffTheRecordDialog_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatOffTheRecordDialog', 'library_name' => 'ChatOffTheRecordDialog', 'view_func_name' => '_standard_chat_ChatOffTheRecordDialog_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatOffTheRecordDialog', 'view_path' => '', 'js_path' => 'standard/chat/ChatOffTheRecordDialog', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatOffTheRecordDialog.css', 1 => 'assets/themes/standard/widgetCss/ChatOffTheRecordDialog.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatOffTheRecordDialog/base.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), 'yui' => array ( 0 => 'event-valuechange', 1 => 'event-key', ), ), 'extends' => array ( 'widget' => 'standard/chat/ChatPostMessage', 'versions' => array ( 0 => '1.1', 1 => '1.0', ), 'components' => array ( 'js' => true, ), ), 'info' => array ( 'description' => 'rn:msg:(4289)', ), 'relativePath' => 'standard/chat/ChatOffTheRecordDialog', 'extends_info' => array ( 'controller' => array ( ), 'view' => array ( 0 => 'standard/chat/ChatPostMessage', ), 'logic' => array ( 0 => 'standard/chat/ChatPostMessage', ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/chat/ChatPostMessage', ), 'widget_name' => 'ChatOffTheRecordDialog', 'extends_js' => array ( 0 => 'standard/chat/ChatPostMessage', ), 'extends_view' => array ( 0 => 'standard/chat/ChatPostMessage', ), 'parent' => 'standard/chat/ChatPostMessage', ), );
$result['meta']['attributes'] = array( 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9555), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9555), 'inherited' => false, )), 'label_send_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(33103), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(33103), 'inherited' => false, )), 'label_window_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2865), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2865), 'inherited' => false, )), 'label_send_instructions' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4820), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4820), 'inherited' => true, )), 'all_posts_off_the_record' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => true, )), 'mobile_mode' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => true, )), 'focus_on_incoming_messages' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => true, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatDisconnectButton extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatDisconnectButton_view ($data) {
extract($data);
?><span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <button id="rn_<?=$this->instanceID;?>_Button" title="<?=$this->data['attrs']['label_tooltip_disconnect'];?>">
        <?
if($this->data['attrs']['disconnect_icon_path'] !== ''):?>
            <img src="<?=$this->data['attrs']['disconnect_icon_path']?>" alt="<?=$this->data['attrs']['label_tooltip_disconnect'];?>" />
        <?
endif;?> 
        <?=$this->data['attrs']['label_disconnect']?>
    </button>
</span>
<?
}
}
function _standard_chat_ChatDisconnectButton_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatDisconnectButton', 'library_name' => 'ChatDisconnectButton', 'view_func_name' => '_standard_chat_ChatDisconnectButton_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatDisconnectButton', 'view_path' => 'standard/chat/ChatDisconnectButton', 'js_path' => 'standard/chat/ChatDisconnectButton', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatDisconnectButton.css', 1 => 'assets/themes/standard/widgetCss/ChatDisconnectButton.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatDisconnectButton/base.css', ), 'js_templates' => array ( 'closeButton' => '<% if(attrs.close_icon_path){ %>  <img alt="" src="<%= attrs.close_icon_path %>"/> <% } %><%= attrs.label_close %>', ), 'template_path' => 'standard/chat/ChatDisconnectButton', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4241)', ), 'relativePath' => 'standard/chat/ChatDisconnectButton', 'widget_name' => 'ChatDisconnectButton', ), );
$result['meta']['attributes'] = array( 'close_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/chatClose.png', 'type' => 'FILEPATH', 'default' => 'images/chatClose.png', 'inherited' => false, )), 'disconnect_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/chatDisconnect.png', 'type' => 'FILEPATH', 'default' => 'images/chatDisconnect.png', 'inherited' => false, )), 'label_close' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(850), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(850), 'inherited' => false, )), 'label_disconnect' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(37345), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(37345), 'inherited' => false, )), 'label_tooltip_close' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1212), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1212), 'inherited' => false, )), 'label_tooltip_disconnect' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3895), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3895), 'inherited' => false, )), 'mobile_mode' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'close_redirect_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'open_in_window' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'new_window', 'type' => 'OPTION', 'default' => 'new_window', 'options' => array(0 => 'new_window', 1 => 'parent_window', ), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatOffTheRecordButton extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatOffTheRecordButton_view ($data) {
extract($data);
?><span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <button id="rn_<?=$this->instanceID;?>_Button" title="<?=$this->data['attrs']['label_tooltip'];?>">
        <?
if($this->data['attrs']['off_the_record_icon_path'] != ''): ?>
            <img src="<?=$this->data['attrs']['off_the_record_icon_path']?>" alt="<?=$this->data['attrs']['label_tooltip'];?>" />
        <?
endif;
?> 
        <?=$this->data['attrs']['label_off_the_record']?>
    </button>
</span>
<? }
}
function _standard_chat_ChatOffTheRecordButton_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatOffTheRecordButton', 'library_name' => 'ChatOffTheRecordButton', 'view_func_name' => '_standard_chat_ChatOffTheRecordButton_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatOffTheRecordButton', 'view_path' => 'standard/chat/ChatOffTheRecordButton', 'js_path' => 'standard/chat/ChatOffTheRecordButton', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ChatOffTheRecordButton.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatOffTheRecordButton/base.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4344)', ), 'relativePath' => 'standard/chat/ChatOffTheRecordButton', 'widget_name' => 'ChatOffTheRecordButton', ), );
$result['meta']['attributes'] = array( 'off_the_record_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/chatOffTheRecordSend.png', 'type' => 'FILEPATH', 'default' => 'images/chatOffTheRecordSend.png', 'inherited' => false, )), 'label_off_the_record' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_tooltip' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3554), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3554), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatPrintButton extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatPrintButton_view ($data) {
extract($data);
?><span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <button id="rn_<?=$this->instanceID;?>_Button" title="<?=$this->data['attrs']['label_tooltip'];?>"><?
if($this->data['attrs']['print_icon_path'] !== ''):?><img src="<?=$this->data['attrs']['print_icon_path']?>" alt="<?=$this->data['attrs']['label_tooltip'];?>" /><?
endif;
?> <?=$this->data['attrs']['label_print']?></button>
</span>
<? }
}
function _standard_chat_ChatPrintButton_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatPrintButton', 'library_name' => 'ChatPrintButton', 'view_func_name' => '_standard_chat_ChatPrintButton_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatPrintButton', 'view_path' => 'standard/chat/ChatPrintButton', 'js_path' => 'standard/chat/ChatPrintButton', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ChatPrintButton.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatPrintButton/base.css', ), 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4343)', ), 'relativePath' => 'standard/chat/ChatPrintButton', 'widget_name' => 'ChatPrintButton', ), );
$result['meta']['attributes'] = array( 'print_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/chatPrint.png', 'type' => 'FILEPATH', 'default' => 'images/chatPrint.png', 'inherited' => false, )), 'label_print' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_tooltip' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3254), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3254), 'inherited' => false, )), 'label_print_after_chat' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43133), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(43133), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatServerConnect extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatServerConnect_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <? if($this->data['outOfChatHours']):?>
           <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatStatus', array());
?>
           <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatHours', array());
?>
    <? else:?>
        <div id="rn_<?=$this->instanceID;?>_Connector">
            <div id="rn_<?=$this->instanceID;?>_ErrorLocation"></div>
            <div id="rn_<?=$this->instanceID;?>_ConnectionStatus">
                <?if($this->data['attrs']['loading_icon_path']
!= ''):?>
                    <img alt="" id="rn_<?=$this->instanceID;?>_ConnectingIcon" src="<?=$this->data['attrs']['loading_icon_path'];?>"/>&nbsp;
                <?endif;?>
                <span id="rn_<?=$this->instanceID;?>_Message"><?=$this->data['attrs']['label_connecting'];?></span>
            </div>
        </div>
    <?
endif;?>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['js']['interfaceID'] = \RightNow\Api::intf_id();
$contactID = $this->CI->session->getProfileData('contactID');
$this->data['js']['maUrl'] = \RightNow\Utils\Url::getShortEufBaseUrl(false, '/ci/documents/detail/1/' . \RightNow\Api::generic_track_encode($contactID) . '/6/' . (223));
$this->data['chatHours'] = $this->CI->model('Chat')->getChatHours()->result;
if(!$this->data['chatHours']['inWorkHours'] || $this->data['chatHours']['holiday']) $this->data['outOfChatHours'] = true;
$profile = $this->CI->session->getProfile(true);
if($profile !== null) {
$contactID = $profile->contactID;
$organizationID = $profile->orgID;
if($contactID > 0) {
$this->data['js']['contactID'] = $contactID;
if(is_int($organizationID) && $organizationID > 0) $this->data['js']['organizationID'] = $organizationID;
if(isset($profile->email) && $profile->email !== null && $profile->email !== '') $this->data['js']['contactEmail'] = $profile->email;
if(isset($profile->firstName) && $profile->firstName !== null && $profile->firstName !== '') $this->data['js']['contactFirstName'] = $profile->firstName;
if(isset($profile->lastName) && $profile->lastName !== null && $profile->lastName !== '') $this->data['js']['contactLastName'] = $profile->lastName;
}
}
$this->data['js']['sessionID'] = $this->CI->session->getSessionData('sessionID');
$requestSource = \RightNow\Utils\Url::getParameter('request_source');
if($requestSource) {
$this->data['js']['requestSource'] = $requestSource;
}
else {
$pac = \RightNow\Utils\Url::getParameter('pac');
$this->data['js']['requestSource'] = $pac ? $pac : (2);
}
$this->data['js']['customFields'] = $this->CI->model('Chat')->getBlankCustomFields()->result;
$this->data['js']['dateField'] = (1);
$this->data['js']['dateTimeField'] = (2);
$this->data['js']['radioField'] = (3);
foreach($_POST as $key => $value) {
if(\RightNow\Utils\Text::beginsWith($key, 'Incident_CustomFields')) {
$this->data['js']['postedCustomFields'][$key] = $value;
}
else if($key === 'Incident_Subject') {
$this->data['js']['postedSubject'] = $value;
}
else if($key === 'Incident_Product') {
$this->data['js']['postedProduct'] = $value;
}
else if($key === 'Incident_Category') {
$this->data['js']['postedCategory'] = $value;
}
else if($key === 'chat_data') {
$this->data['js']['chat_data'] = $value;
}
else if($key === 'referrerUrl') {
$this->data['js']['referrerUrl'] = $value;
}
else if($profile === null) {
if($key === 'Contact_Emails_PRIMARY_Address') $this->data['js']['contactEmail'] = $value;
else if($key === 'Contact_Name_First') $this->data['js']['contactFirstName'] = $value;
else if($key === 'Contact_Name_Last') $this->data['js']['contactLastName'] = $value;
}
}
}
}
function _standard_chat_ChatServerConnect_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatServerConnect', 'library_name' => 'ChatServerConnect', 'view_func_name' => '_standard_chat_ChatServerConnect_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatServerConnect', 'view_path' => 'standard/chat/ChatServerConnect', 'js_path' => 'standard/chat/ChatServerConnect', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatServerConnect.css', 1 => 'assets/themes/standard/widgetCss/ChatServerConnect.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatServerConnect/base.css', ), 'js_templates' => array ( 'errorMessageList' => '<ul> <% for(var i=0; i<errors.length; i++) {%>  <li> <%= errors[i] %> </li>  <% } %> </ul>', ), 'template_path' => 'standard/chat/ChatServerConnect', 'version' => '1.0.3', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4371)', 'urlParameters' => array ( 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2168)', 'example' => 'i_id/7', ), 'p' => array ( 'name' => 'rn:msg:(4623)', 'description' => 'rn:msg:(3276)', 'example' => 'p/7,2', ), 'c' => array ( 'name' => 'rn:msg:(4617)', 'description' => 'rn:msg:(1122)', 'example' => 'c/8,3', ), 'q_id' => array ( 'name' => 'rn:msg:(8193)', 'description' => 'rn:msg:(41664)', 'example' => 'q_id/1', ), 'survey_comp_id' => array ( 'name' => 'rn:msg:(41564)', 'description' => 'rn:msg:(41658)', ), 'survey_term_id' => array ( 'name' => 'rn:msg:(41635)', 'description' => 'rn:msg:(41657)', ), 'survey_send_id' => array ( 'name' => 'rn:msg:(41634)', 'description' => 'rn:msg:(41656)', ), 'survey_send_delay' => array ( 'name' => 'rn:msg:(41633)', 'description' => 'rn:msg:(41639)', ), ), ), 'contains' => array ( 0 => array ( 'widget' => 'standard/chat/ChatStatus', 'versions' => array ( 0 => '1.0', ), ), 1 => array ( 'widget' => 'standard/chat/ChatHours', 'version' => array ( 0 => '1.0', ), ), ), 'relativePath' => 'standard/chat/ChatServerConnect', 'widget_name' => 'ChatServerConnect', ), );
$result['meta']['attributes'] = array( 'loading_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/indicator.gif', 'type' => 'FILEPATH', 'default' => 'images/indicator.gif', 'inherited' => false, )), 'label_connecting' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3182), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3182), 'inherited' => false, )), 'label_connection_success' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1334), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1334), 'inherited' => false, )), 'label_connection_fail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1332), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1332), 'inherited' => false, )), 'label_terminate_session' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(5325), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(5325), 'inherited' => false, )), 'label_validation_fail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4122), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4122), 'inherited' => false, )), 'first_name_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'last_name_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'email_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'label_prevent_anonymous_chat' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3392), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3392), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatEngagementStatus extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatEngagementStatus_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <span id="rn_<?=$this->instanceID;?>_Prefix" class="rn_StatusPrefix">
        <?=$this->data['attrs']['label_status_prefix'];?>
    </span>
    <span id="rn_<?=$this->instanceID;?>_Status" class="rn_Status">
        <?=$this->data['attrs']['label_status_searching'];?>
    </span>
    <div id="rn_<?=$this->instanceID;?>_Searching" class="rn_SearchingDetailMessage rn_Hidden">
        <img alt="" src="<?=$this->data['attrs']['loading_icon_path'];?>"/>&nbsp;<span><?=$this->data['attrs']['label_detail_searching'];?></span>
    </div>
    <div id="rn_<?=$this->instanceID;?>_Requeued" class="rn_RequeuedDetailMessage rn_Hidden">
        <?=$this->data['attrs']['label_detail_requeued'];?>
    </div>
    <div id="rn_<?=$this->instanceID;?>_Canceled_User" role="alert" class="rn_CanceledUserDetailMessage rn_Hidden">
        <?=$this->data['attrs']['label_detail_canceled_user'];?>&nbsp;<span><?=$this->data['attrs']['label_close_window_message'];?></span>
    </div>
    <div id="rn_<?=$this->instanceID;?>_Canceled_Self_Service" class="rn_CanceledSelfServiceDetailMessage rn_Hidden">
        <?=$this->data['attrs']['label_detail_canceled_self_service'];?>
    </div>
    <div id="rn_<?=$this->instanceID;?>_Canceled_NoAgentsAvail" class="rn_CanceledNoAgentsAvailDetailMessage rn_Hidden">
        <?=$this->data['attrs']['label_detail_canceled_no_agents_avail'];?>
    </div>
    <div id="rn_<?=$this->instanceID;?>_Canceled_Queue_Timeout" class="rn_CanceledQueueTimeoutDetailMessage rn_Hidden">
        <?=$this->data['attrs']['label_detail_canceled_queue_timeout'];?>
    </div>
    <div id="rn_<?=$this->instanceID;?>_Canceled_Dequeued" class="rn_CanceledDequeuedDetailMessage rn_Hidden">
        <?=$this->data['attrs']['label_detail_canceled_dequeued'];?>
    </div>
    <div id="rn_<?=$this->instanceID;?>_Canceled_Browser" class="rn_CanceledBrowserDetailMessage rn_Hidden">
        <?=$this->data['attrs']['label_detail_canceled_browser'];?>
    </div>
</div>
<?
}
}
function _standard_chat_ChatEngagementStatus_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatEngagementStatus', 'library_name' => 'ChatEngagementStatus', 'view_func_name' => '_standard_chat_ChatEngagementStatus_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatEngagementStatus', 'view_path' => 'standard/chat/ChatEngagementStatus', 'js_path' => 'standard/chat/ChatEngagementStatus', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatEngagementStatus.css', 1 => 'assets/themes/standard/widgetCss/ChatEngagementStatus.css', ), 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4320)', ), 'relativePath' => 'standard/chat/ChatEngagementStatus', 'widget_name' => 'ChatEngagementStatus', ), );
$result['meta']['attributes'] = array( 'loading_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/indicator.gif', 'type' => 'FILEPATH', 'default' => 'images/indicator.gif', 'inherited' => false, )), 'label_status_prefix' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((30697)) . ' ', 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((30697)) . ' ', 'inherited' => false, )), 'label_status_searching' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4826), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4826), 'inherited' => false, )), 'label_status_canceled' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(32965), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(32965), 'inherited' => false, )), 'label_status_connected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4825), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4825), 'inherited' => false, )), 'label_status_reconnecting' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3348), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3348), 'inherited' => false, )), 'label_status_disconnected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4788), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4788), 'inherited' => false, )), 'label_detail_searching' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4798), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4798), 'inherited' => false, )), 'label_detail_requeued' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4821), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4821), 'inherited' => false, )), 'label_detail_canceled_user' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2557), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2557), 'inherited' => false, )), 'label_detail_canceled_self_service' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2558), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2558), 'inherited' => false, )), 'label_detail_canceled_no_agents_avail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(937), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(937), 'inherited' => false, )), 'label_detail_canceled_queue_timeout' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(937), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(937), 'inherited' => false, )), 'label_detail_canceled_dequeued' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3372), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3372), 'inherited' => false, )), 'label_close_window_message' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43368), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(43368), 'inherited' => false, )), 'label_detail_canceled_browser' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(46024), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(46024), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatQueueWaitTime extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatQueueWaitTime_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <div id="rn_<?=$this->instanceID;?>_BrowserWarning" class="rn_BrowserWarning rn_Hidden">
        <?=$this->data['attrs']['label_leave_screen_warning'];?>
        <br/><br/>
    </div>
    <span id="rn_<?=$this->instanceID;?>_QueuePosition" class="rn_ChatQueuePosition rn_Hidden" title="<?=$this->data['attrs']['label_tooltip_queue_position'];?>">
        <?=$this->data['attrs']['label_queue_position_not_available'];?>
    </span>
    <span id="rn_<?=$this->instanceID;?>_EstimatedWaitTime" class="rn_ChatEstimatedWaitTime rn_Hidden" title="<?=$this->data['attrs']['label_tooltip_estimated_wait_time'];?>">
        <?=$this->data['attrs']['label_estimated_wait_time_not_available'];?>
    </span>
    <span id="rn_<?=$this->instanceID;?>_AverageWaitTime" class="rn_ChatAverageWaitTime rn_Hidden" title="<?=$this->data['attrs']['label_tooltip_average_wait_time'];?>">
        <?=$this->data['attrs']['label_average_wait_time_not_available'];?>
    </span>
</div>
<?
}
}
function _standard_chat_ChatQueueWaitTime_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatQueueWaitTime', 'library_name' => 'ChatQueueWaitTime', 'view_func_name' => '_standard_chat_ChatQueueWaitTime_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatQueueWaitTime', 'view_path' => 'standard/chat/ChatQueueWaitTime', 'js_path' => 'standard/chat/ChatQueueWaitTime', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatQueueWaitTime.css', 1 => 'assets/themes/standard/widgetCss/ChatQueueWaitTime.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4311)', ), 'relativePath' => 'standard/chat/ChatQueueWaitTime', 'widget_name' => 'ChatQueueWaitTime', ), );
$result['meta']['attributes'] = array( 'type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'all', 'type' => 'OPTION', 'default' => 'all', 'options' => array(0 => 'position', 1 => 'estimated', 2 => 'average', 3 => 'all', ), 'inherited' => false, )), 'label_tooltip_queue_position' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4439), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4439), 'inherited' => false, )), 'label_queue_position' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3312), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3312), 'inherited' => false, )), 'label_queue_position_not_available' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3183), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3183), 'inherited' => false, )), 'label_tooltip_estimated_wait_time' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1846), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1846), 'inherited' => false, )), 'label_estimated_wait_time' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1331), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1331), 'inherited' => false, )), 'label_estimated_wait_time_not_available' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_estimated_wait_time_exceeded' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1012), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1012), 'inherited' => false, )), 'label_tooltip_average_wait_time' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1056), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1056), 'inherited' => false, )), 'label_average_wait_time' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1060), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1060), 'inherited' => false, )), 'label_average_wait_time_not_available' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_leave_screen_warning' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(44438), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(44438), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatAgentStatus extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatAgentStatus_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <div id="rn_<?=$this->instanceID;?>_Roster" class="rn_ChatAgentStatusBlock">
    </div>
</div>
    <?
}
}
function _standard_chat_ChatAgentStatus_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatAgentStatus', 'library_name' => 'ChatAgentStatus', 'view_func_name' => '_standard_chat_ChatAgentStatus_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatAgentStatus', 'view_path' => 'standard/chat/ChatAgentStatus', 'js_path' => 'standard/chat/ChatAgentStatus', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatAgentStatus.css', 1 => 'assets/themes/standard/widgetCss/ChatAgentStatus.css', ), 'js_templates' => array ( 'participantAddedResponse' => '<div id = "rn_<%= instanceID %>_Agent_<%= clientID %>"><% if(attrs.agent_icon_path){ %>  <img alt="" src="<%= attrs.agent_icon_path %>"/> <% } %> <span id="rn_<%= instanceID %>_AgentStatus_<%= clientID %>"><%= agentName %>&nbsp;(<%= attrs.label_status_listening %>)</span></div>', ), 'template_path' => 'standard/chat/ChatAgentStatus', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4242)', ), 'relativePath' => 'standard/chat/ChatAgentStatus', 'widget_name' => 'ChatAgentStatus', ), );
$result['meta']['attributes'] = array( 'agent_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{display_name}', 'type' => 'STRING', 'default' => '{display_name}', 'inherited' => false, )), 'agent_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/chatAgent.png', 'type' => 'FILEPATH', 'default' => 'images/chatAgent.png', 'inherited' => false, )), 'label_status_listening' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(31647), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(31647), 'inherited' => false, )), 'label_status_responding' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(31664), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(31664), 'inherited' => false, )), 'label_status_absent' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(5346), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(5346), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatTranscript extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatTranscript_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <div id="rn_<?=$this->instanceID;?>_Transcript" class="rn_ChatTranscriptBlock">
    </div>
</div>
<?
}
}
function _standard_chat_ChatTranscript_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatTranscript', 'library_name' => 'ChatTranscript', 'view_func_name' => '_standard_chat_ChatTranscript_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatTranscript', 'view_path' => 'standard/chat/ChatTranscript', 'js_path' => 'standard/chat/ChatTranscript', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatTranscript.css', 1 => 'assets/themes/standard/widgetCss/ChatTranscript.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatTranscript/base.css', ), 'js_templates' => array ( 'agentStatusChangeResponse' => '<span class="rn_MessagePost"><% if(attrs.alert_icon_path){ %>  <img alt="" src="<%= attrs.alert_icon_path %>"/> <% } %> <%= message.replace("{display_name}", \'<span class="rn_AgentTextPrefix">\' + agentName + \'</span>\') %><br/></span>', 'chatPostResponse' => '<span class="rn_MessagePost"><% if(context.isEndUserPost && context.isOffTheRecord && attrs.off_the_record_icon_path){ %>  <img alt="" src="<%= attrs.off_the_record_icon_path %>"/> <% } else if(context.isEndUserPost && !context.isOffTheRecord && attrs.enduser_message_icon_path){ %>  <img alt="" src="<%= attrs.enduser_message_icon_path %>"/> <% } else if(!context.isEndUserPost && attrs.agent_message_icon_path){ %>  <img alt="" src="<%= attrs.agent_message_icon_path %>"/> <% } %> <% if(context.isEndUserPost){ %> <span class="rn_UserTextPrefix"><%= endUserName %></span>:<% if(context.isOffTheRecord){ %> <span class="rn_OffTheRecordMessage"><%= message %></span><% } else{ %> <%= message %><% } } else { %> <span class="rn_AgentTextPrefix"><%= agentName %></span>: <%= message %><% } %><br/></span>', 'cobrowseInvitationResponse' => '<span class="rn_MessagePost"><% if(attrs.cobrowse_icon_path){ %>  <img alt="" src="<%= attrs.cobrowse_icon_path %>"/> <% } %> <span class="rn_Action"> <%= message.replace(\'{0}\', agentName) %> <span class="rn_CoBrowseAction"> <%= attrs.label_click %> <a href="javascript: void(0);" onclick="javascript: RightNow.Widgets.ChatTranscript.sendCoBrowseResponse(true, \'<%= url %>\'); return false;"> <%= attrs.label_allow %> </a> <%= attrs.label_or %> <a href="javascript: void(0);" onclick="javascript: RightNow.Widgets.ChatTranscript.sendCoBrowseResponse(false); return false;"> <%= attrs.label_deny %> </a> </span></span><br/></span>', 'CoBrowsePremiumInvitationResponse' => '<span class="rn_MessagePost"><% if(attrs.cobrowse_icon_path){ %>  <img alt="" src="<%= attrs.cobrowse_icon_path %>"/> <% } %> <span class="rn_Action"> <%= message.replace(/\\{0\\}/g, agentName) %> <span class="rn_CoBrowseAction"> <%= attrs.label_click %> <a href="javascript: void(0);" class=\'rn_CoBrowsePremiumAllow\' role=\'button\' data-agentenvironment=\'<%= agentEnvironment %>\' data-cobrowsesessionid=\'<%= coBrowseSessionId %>\'> <%= attrs.label_allow %> </a> <%= attrs.label_or %> <a href="javascript: void(0);" class=\'rn_CoBrowsePremiumDecline\' role=\'button\' > <%= attrs.label_deny %> </a> </span></span><br/></span>', 'participantAddedResponse' => '<span class="rn_MessagePost"><% if(role === "LEAD" && attrs.agent_message_icon_path){ %>  <img alt="" src="<%= attrs.agent_message_icon_path %>"/> <% } else if(role !== "LEAD" && attrs.alert_icon_path){ %>  <img alt="" src="<%= attrs.alert_icon_path %>"/> <% } %> <span class="rn_AgentTextPrefix"><%= agentName %></span><%= message %> <br/></span>', 'systemMessage' => '<span class="rn_MessagePost"><% if(attrs.alert_icon_path){ %>  <img alt="" src="<%= attrs.alert_icon_path %>"/> <% } for(var i=0; i<messages.length; i++) { if(i == 0 && context && context.isUserDisconnect && context.reason !== \'IDLE_TIMEOUT\'){ %> <span class="rn_UserTextPrefix"><% } else if(i == 0) { %> <span class="rn_Action"><% } %> <%= messages[i] %><% if(i == 0) {%> </span><% }} %><br/></span>', ), 'template_path' => 'standard/chat/ChatTranscript', 'version' => '1.2.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), 'yui' => array ( 0 => 'anim-scroll', ), ), 'info' => array ( 'description' => 'rn:msg:(4290)', ), 'relativePath' => 'standard/chat/ChatTranscript', 'widget_name' => 'ChatTranscript', ), );
$result['meta']['attributes'] = array( 'agent_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{display_name}', 'type' => 'STRING', 'default' => '{display_name}', 'inherited' => false, )), 'agent_message_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/chatAgent.png', 'type' => 'FILEPATH', 'default' => 'images/chatAgent.png', 'inherited' => false, )), 'alert_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/chatAlert.png', 'type' => 'FILEPATH', 'default' => 'images/chatAlert.png', 'inherited' => false, )), 'cobrowse_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/chatCobrowse.png', 'type' => 'FILEPATH', 'default' => 'images/chatCobrowse.png', 'inherited' => false, )), 'enduser_message_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/chatEndUserMessage.png', 'type' => 'FILEPATH', 'default' => 'images/chatEndUserMessage.png', 'inherited' => false, )), 'label_allow' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9912), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9912), 'inherited' => false, )), 'label_agent_requesting_view_desktop' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9941), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9941), 'inherited' => false, )), 'label_agent_requesting_control_desktop' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9940), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9940), 'inherited' => false, )), 'label_click' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(22026), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(22026), 'inherited' => false, )), 'label_deny' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9920), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9920), 'inherited' => false, )), 'label_enduser_name_default_prefix' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4801), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4801), 'inherited' => false, )), 'label_initializing_screen_sharing_session' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(22970), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(22970), 'inherited' => false, )), 'label_java_cert_rejected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(23005), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(23005), 'inherited' => false, )), 'label_java_not_detected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9932), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9932), 'inherited' => false, )), 'label_file_attachment_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(22794), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(22794), 'inherited' => false, )), 'label_file_attachment_received' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(22796), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(22796), 'inherited' => false, )), 'label_file_attachment_started' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(22798), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(22798), 'inherited' => false, )), 'label_has_disconnected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4810), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4810), 'inherited' => false, )), 'label_has_joined_chat' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4812), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4812), 'inherited' => false, )), 'label_has_left_chat' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4813), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4813), 'inherited' => false, )), 'label_have_disconnected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4815), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4815), 'inherited' => false, )), 'label_off_the_record' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_or' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9938), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9938), 'inherited' => false, )), 'label_screen_sharing_session_declined' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(23582), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(23582), 'inherited' => false, )), 'label_screen_sharing_session_ended' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(23583), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(23583), 'inherited' => false, )), 'label_screen_sharing_session_error_starting' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(22764), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(22764), 'inherited' => false, )), 'label_screen_sharing_session_started' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(23584), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(23584), 'inherited' => false, )), 'label_you' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4801), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4801), 'inherited' => false, )), 'off_the_record_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/chatOffTheRecord.png', 'type' => 'FILEPATH', 'default' => 'images/chatOffTheRecord.png', 'inherited' => false, )), 'mobile_mode' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'unread_messages_titlebar_enabled' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'label_leave_screen_warning' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(44438), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(44438), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatCancelButton extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatCancelButton_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <button id="rn_<?=$this->instanceID;?>_Button"  title="<?=$this->data['attrs']['label_tooltip'];?>"><?
if($this->data['attrs']['cancel_icon_path'] !== ''):?><img src="<?=$this->data['attrs']['cancel_icon_path']?>" alt="<?=$this->data['attrs']['label_tooltip'];?>" /><?
endif;?> <?=$this->data['attrs']['label_cancel']?></button>
</div>
<?
}
}
function _standard_chat_ChatCancelButton_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatCancelButton', 'library_name' => 'ChatCancelButton', 'view_func_name' => '_standard_chat_ChatCancelButton_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatCancelButton', 'view_path' => 'standard/chat/ChatCancelButton', 'js_path' => 'standard/chat/ChatCancelButton', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatCancelButton.css', 1 => 'assets/themes/standard/widgetCss/ChatCancelButton.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatCancelButton/base.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4386)', ), 'relativePath' => 'standard/chat/ChatCancelButton', 'widget_name' => 'ChatCancelButton', ), );
$result['meta']['attributes'] = array( 'cancel_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'FILEPATH', 'default' => '', 'inherited' => false, )), 'label_cancel' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2554), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2554), 'inherited' => false, )), 'label_tooltip' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3896), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3896), 'inherited' => false, )), 'canceling_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatRequestEmailResponseButton extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatRequestEmailResponseButton_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <button id="rn_<?=$this->instanceID;?>_Button" title="<?=$this->data['attrs']['label_tooltip'];?>"><?=$this->data['attrs']['label_button']?></button>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['js']['baseUrl'] = \RightNow\Utils\Url::getShortEufBaseUrl('sameAsCurrentPage');
}
}
function _standard_chat_ChatRequestEmailResponseButton_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatRequestEmailResponseButton', 'library_name' => 'ChatRequestEmailResponseButton', 'view_func_name' => '_standard_chat_ChatRequestEmailResponseButton_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatRequestEmailResponseButton', 'view_path' => 'standard/chat/ChatRequestEmailResponseButton', 'js_path' => 'standard/chat/ChatRequestEmailResponseButton', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ChatRequestEmailResponseButton.css', 1 => 'assets/themes/standard/widgetCss/ChatRequestEmailResponseButton.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4252)', ), 'relativePath' => 'standard/chat/ChatRequestEmailResponseButton', 'widget_name' => 'ChatRequestEmailResponseButton', ), );
$result['meta']['attributes'] = array( 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3396), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3396), 'inherited' => false, )), 'page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/ask', 'type' => 'STRING', 'default' => '/app/ask', 'inherited' => false, )), 'label_tooltip' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => sprintf(\RightNow\Utils\Config::getMessage((1098)), \RightNow\Utils\Config::getMessage((8245))), 'type' => 'STRING', 'default' => sprintf(\RightNow\Utils\Config::getMessage((1098)), \RightNow\Utils\Config::getMessage((8245))), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatSendButton extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatSendButton_view ($data) {
extract($data);
?><span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden" title="<?=$this->data['attrs']['label_tooltip'];?>">
    <button id="rn_<?=$this->instanceID;?>_Button"><?
if($this->data['attrs']['send_icon_path'] !== ''):?><img src="<?=$this->data['attrs']['send_icon_path']?>" alt="<?=$this->data['attrs']['label_tooltip'];?>" /><?
endif;?> <?=$this->data['attrs']['label_send']?></button>
</span>
<?
}
}
function _standard_chat_ChatSendButton_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatSendButton', 'library_name' => 'ChatSendButton', 'view_func_name' => '_standard_chat_ChatSendButton_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatSendButton', 'view_path' => 'standard/chat/ChatSendButton', 'js_path' => 'standard/chat/ChatSendButton', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ChatSendButton.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatSendButton/base.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4374)', ), 'relativePath' => 'standard/chat/ChatSendButton', 'widget_name' => 'ChatSendButton', ), );
$result['meta']['attributes'] = array( 'send_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'FILEPATH', 'default' => '', 'inherited' => false, )), 'label_send' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(33103), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(33103), 'inherited' => false, )), 'label_tooltip' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3562), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3562), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class FileAttachmentUpload extends \RightNow\Libraries\Widget\Input {
function _standard_input_FileAttachmentUpload_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
$result = array( 'js_name' => 'RightNow.Widgets.FileAttachmentUpload', 'library_name' => 'FileAttachmentUpload', 'view_func_name' => '_standard_input_FileAttachmentUpload_view', 'meta' => array ( 'controller_path' => 'standard/input/FileAttachmentUpload', 'view_path' => 'standard/input/FileAttachmentUpload', 'js_path' => 'standard/input/FileAttachmentUpload', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/FileAttachmentUpload.css', 1 => 'assets/themes/standard/widgetCss/FileAttachmentUpload.css', ), 'base_css' => array ( 0 => 'standard/input/FileAttachmentUpload/base.css', ), 'js_templates' => array ( 'attachmentItem' => '<li id="<%= id %>">  <% if (displayThumbnail) { %>  <span class="rn_Thumbnail"></span>  <% } %>  <%= name %>   <a href=\'javascript:void(0)\' class=\'rn_fileRemove\'><%= attrs.label_remove %><span class=\'rn_ScreenReaderOnly\'><%= name %></span></a>  </li>', 'error' => '<div data-field="<%= fieldName %>">  <b><a href=\'javascript:void(0);\' onclick=\'document.getElementById("<%= id %>").focus(); return false;\'><%= errorLink %></a></b> </div>', 'label' => '<label for="rn_<%= instanceID %>_FileInput" id="rn_<%= instanceID %>_Label"><%= label %><% if(minAttachments) { %> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span><% } %></label>', 'maxMessage' => '<li>  <%= maxMessage %> </li>', ), 'template_path' => 'standard/input/FileAttachmentUpload', 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4226)', 'urlParameters' => array ( 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2167)', 'example' => 'i_id/7', ), ), ), 'relativePath' => 'standard/input/FileAttachmentUpload', 'widget_name' => 'FileAttachmentUpload', ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4480), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4480), 'inherited' => false, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_remove' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(6896), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(6896), 'inherited' => false, )), 'max_attachments' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => false, )), 'label_max_attachment_limit' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3336), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3336), 'inherited' => false, )), 'label_generic_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1941), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1941), 'inherited' => false, )), 'label_still_uploading_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43242), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(43242), 'inherited' => false, )), 'loading_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/indicator.gif', 'type' => 'FILEPATH', 'default' => 'images/indicator.gif', 'inherited' => false, )), 'min_required_attachments' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => false, )), 'label_min_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(18887), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(18887), 'inherited' => false, )), 'valid_file_extensions' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_invalid_extension' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2004), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2004), 'inherited' => false, )), 'display_thumbnail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'max_thumbnail_height' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 100, 'type' => 'INT', 'default' => 100, 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatAttachFileButton extends FileAttachmentUpload {
function _standard_chat_ChatAttachFileButton_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <div id="rn_<?=$this->instanceID;?>_ButtonContent" class="rn_ChatAttachFileButtonContent">
        <button id="rn_<?=$this->instanceID;?>_Button" title="<?=$this->data['attrs']['label_tooltip'];?>">
            <?
if($this->data['attrs']['file_attach_icon_path']): ?>
                <img src="<?=$this->data['attrs']['file_attach_icon_path']?>" alt="<?=$this->data['attrs']['label_tooltip'];?>" />
            <?
endif ?> 
            <?=$this->data['attrs']['label_file_attach']?>
        </button>
    </div>
    <form method="post" id="rn_<?=$this->instanceID;?>_Form" class="rn_ChatAttachFileButtonForm">
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
    </form>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
parent::getData();
$this->data['js']['name'] = null;
$this->classList->add('rn_Hidden');
}
}
function _standard_chat_ChatAttachFileButton_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatAttachFileButton', 'library_name' => 'ChatAttachFileButton', 'view_func_name' => '_standard_chat_ChatAttachFileButton_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatAttachFileButton', 'view_path' => 'standard/chat/ChatAttachFileButton', 'js_path' => 'standard/chat/ChatAttachFileButton', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ChatAttachFileButton.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatAttachFileButton/base.css', ), 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/input/FileAttachmentUpload', 'versions' => array ( 0 => '1.2', ), 'components' => array ( 'php' => true, 'view' => true, 'js' => true, ), ), 'info' => array ( 'description' => 'rn:msg:(4342)', ), 'relativePath' => 'standard/chat/ChatAttachFileButton', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'view' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'logic' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'js_templates' => array ( 0 => array ( 'attachmentItem' => '<li id="<%= id %>"> <rn:block id="attachmentItemTop"/> <% if (displayThumbnail) { %> <rn:block id="preThumbnail"/> <span class="rn_Thumbnail"></span> <rn:block id="postThumbnail"/> <% } %> <rn:block id="preFileName"/> <%= name %> <rn:block id="postFileName"/> <rn:block id="preRemoveLink"/> <a href=\'javascript:void(0)\' class=\'rn_fileRemove\'><%= attrs.label_remove %><span class=\'rn_ScreenReaderOnly\'><%= name %></span></a> <rn:block id="postRemoveLink"/> <rn:block id="attachmentItemBottom"/></li>', 'error' => '<div data-field="<%= fieldName %>"> <rn:block id="preError"/> <b><a href=\'javascript:void(0);\' onclick=\'document.getElementById("<%= id %>").focus(); return false;\'><%= errorLink %></a></b> <rn:block id="postError"/></div>', 'label' => '<rn:block id="preFileInputLabel"/><label for="rn_<%= instanceID %>_FileInput" id="rn_<%= instanceID %>_Label"><%= label %><% if(minAttachments) { %> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span><% } %></label><rn:block id="postFileInputLabel"/>', 'maxMessage' => '<li> <rn:block id="preMaxLabel"/> <%= maxMessage %> <rn:block id="postMaxLabel"/></li>', ), ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/input/FileAttachmentUpload', ), 'widget_name' => 'ChatAttachFileButton', 'extends_php' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'extends_js' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'extends_view' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'parent' => 'standard/input/FileAttachmentUpload', 'js_templates' => array ( 'attachmentItem' => '<li id="<%= id %>">  <% if (displayThumbnail) { %>  <span class="rn_Thumbnail"></span>  <% } %>  <%= name %>   <a href=\'javascript:void(0)\' class=\'rn_fileRemove\'><%= attrs.label_remove %><span class=\'rn_ScreenReaderOnly\'><%= name %></span></a>  </li>', 'error' => '<div data-field="<%= fieldName %>">  <b><a href=\'javascript:void(0);\' onclick=\'document.getElementById("<%= id %>").focus(); return false;\'><%= errorLink %></a></b> </div>', 'label' => '<label for="rn_<%= instanceID %>_FileInput" id="rn_<%= instanceID %>_Label"><%= label %><% if(minAttachments) { %> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span><% } %></label>', 'maxMessage' => '<li>  <%= maxMessage %> </li>', ), ), );
$result['meta']['attributes'] = array( 'file_attach_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'FILEPATH', 'default' => '', 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9555), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9555), 'inherited' => false, )), 'label_file_attach' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(21902), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(21902), 'inherited' => false, )), 'label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4480), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4480), 'inherited' => false, )), 'position_during_upload' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'bottom-right', 'type' => 'OPTION', 'default' => 'bottom-right', 'options' => array(0 => 'top-left', 1 => 'top-right', 2 => 'bottom-left', 3 => 'bottom-right', 4 => 'center', ), 'inherited' => false, )), 'label_tooltip' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1030), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1030), 'inherited' => false, )), 'label_generic_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1941), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1941), 'inherited' => true, )), 'label_still_uploading_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43242), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(43242), 'inherited' => true, )), 'loading_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/indicator.gif', 'type' => 'FILEPATH', 'default' => 'images/indicator.gif', 'inherited' => true, )), 'valid_file_extensions' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'label_invalid_extension' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2004), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2004), 'inherited' => true, )), 'display_thumbnail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), 'max_thumbnail_height' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 100, 'type' => 'INT', 'default' => 100, 'inherited' => true, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatCoBrowseButton extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatCoBrowseButton_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <button id="rn_<?=$this->instanceID;?>_Button" class="rn_Hidden" title="<?=$this->data['attrs']['label_tooltip'];?>">
        <?
if($this->data['attrs']['end_cobrowse_icon_path']) :?>
            <img src="<?=$this->data['attrs']['end_cobrowse_icon_path']?>" alt="<?=$this->data['attrs']['label_tooltip'];?>" />
        <?
endif;
?> <?=$this->data['attrs']['label_end_cobrowse']?>
    </button>
    <iframe id="rn_<?=$this->instanceID;?>_IFrame" class="rn_Hidden" title="<?=$this->data['attrs']['label_cobrowse_session'];?>"></iframe>
</div>
<?
}
}
function _standard_chat_ChatCoBrowseButton_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatCoBrowseButton', 'library_name' => 'ChatCoBrowseButton', 'view_func_name' => '_standard_chat_ChatCoBrowseButton_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatCoBrowseButton', 'view_path' => 'standard/chat/ChatCoBrowseButton', 'js_path' => 'standard/chat/ChatCoBrowseButton', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ChatCoBrowseButton.css', ), 'base_css' => array ( 0 => 'standard/chat/ChatCoBrowseButton/base.css', ), 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4347)', ), 'relativePath' => 'standard/chat/ChatCoBrowseButton', 'widget_name' => 'ChatCoBrowseButton', ), );
$result['meta']['attributes'] = array( 'end_cobrowse_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'FILEPATH', 'default' => '', 'inherited' => false, )), 'label_end_cobrowse' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9922), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9922), 'inherited' => false, )), 'label_tooltip' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1768), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1768), 'inherited' => false, )), 'label_cobrowse_session' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43365), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(43365), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ChatQueueSearch extends \RightNow\Libraries\Widget\Base {
function _standard_chat_ChatQueueSearch_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_ScreenReaderOnly">
    <form method="post" onsubmit="return false">
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/KeywordText', array('label_text' => '' . $this->data['attrs']['label_text'] . '',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/SearchButton', array('report_page_url' => '' . $this->data['attrs']['report_page_url'] . '','target' => '_blank',));
?>
    </form>
</div>
<? }
}
function _standard_chat_ChatQueueSearch_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ChatQueueSearch', 'library_name' => 'ChatQueueSearch', 'view_func_name' => '_standard_chat_ChatQueueSearch_view', 'meta' => array ( 'controller_path' => 'standard/chat/ChatQueueSearch', 'view_path' => 'standard/chat/ChatQueueSearch', 'js_path' => 'standard/chat/ChatQueueSearch', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ChatQueueSearch.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4366)', ), 'contains' => array ( 0 => array ( 'widget' => 'standard/search/KeywordText', 'versions' => array ( 0 => '1.0', ), ), 1 => array ( 'widget' => 'standard/search/SearchButton', 'versions' => array ( 0 => '1.0', ), ), ), 'relativePath' => 'standard/chat/ChatQueueSearch', 'widget_name' => 'ChatQueueSearch', ), );
$result['meta']['attributes'] = array( 'label_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4412), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4412), 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/answers/list', 'type' => 'STRING', 'default' => '/app/answers/list', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class RightNowLogo extends \RightNow\Libraries\Widget\Base {
function _standard_utils_RightNowLogo_view ($data) {
extract($data);
?><span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <a href="<?=$this->data['link']?>" target="_blank" title="<?=$this->data['title'];?>"><span class="rn_ScreenReaderOnly"><?=$this->data['title'];?></span></a>
</span>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['link'] = \RightNow\Utils\Config::getConfig((133));
$this->data['title'] = 'Powered By Oracle';
}
}
function _standard_utils_RightNowLogo_header() {
$result = array( 'js_name' => '', 'library_name' => 'RightNowLogo', 'view_func_name' => '_standard_utils_RightNowLogo_view', 'meta' => array ( 'controller_path' => 'standard/utils/RightNowLogo', 'view_path' => 'standard/utils/RightNowLogo', 'base_css' => array ( 0 => 'standard/utils/RightNowLogo/base.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(43116)', ), 'relativePath' => 'standard/utils/RightNowLogo', 'widget_name' => 'RightNowLogo', ), );
$result['meta']['attributes'] = array( );
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
class KeywordText extends \RightNow\Libraries\Widget\Base {
function _standard_search_KeywordText_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <label for="rn_<?=$this->instanceID;?>_Text"><?=$this->data['attrs']['label_text'];?></label>
    <input id="rn_<?=$this->instanceID;?>_Text" name="rn_<?=$this->instanceID;?>_Text" type="text" maxlength="255" value="<?=$this->data['js']['initialValue'];?>"/>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$reportToken = \RightNow\Utils\Framework::createToken($this->data['attrs']['report_id']);
$searchTerm = $this->CI->model('Report')->getSearchTerm($this->data['attrs']['report_id'], $reportToken, $filters)->result;
$this->data['js'] = array( 'initialValue' => $searchTerm ?: '', 'rnSearchType' => 'keyword', 'searchName' => 'keyword', );
}
}
function _standard_search_KeywordText_header() {
$result = array( 'js_name' => 'RightNow.Widgets.KeywordText', 'library_name' => 'KeywordText', 'view_func_name' => '_standard_search_KeywordText_view', 'meta' => array ( 'controller_path' => 'standard/search/KeywordText', 'view_path' => 'standard/search/KeywordText', 'js_path' => 'standard/search/KeywordText', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/KeywordText.css', 1 => 'assets/themes/standard/widgetCss/KeywordText.css', ), 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(42114)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(4496)', 'example' => 'kw/roam', ), ), ), 'relativePath' => 'standard/search/KeywordText', 'widget_name' => 'KeywordText', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'source_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4690), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4690), 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class SearchButton extends \RightNow\Libraries\Widget\Base {
function _standard_search_SearchButton_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <? if ($this->data['attrs']['icon_path']): ?>
        <input type="image" class="rn_SubmitImage" id="rn_<?=$this->instanceID;?>_SubmitButton" src="<?=$this->data['attrs']['icon_path'];?>" alt="<?=$this->data['attrs']['icon_alt_text'];?>" title="<?=$this->data['attrs']['label_button'];?>"/>
    <?
else: ?>
        <input type="submit" class="rn_SubmitButton" id="rn_<?=$this->instanceID;?>_SubmitButton" value="<?=$this->data['attrs']['label_button'];?>"/>
    <?
endif;?>
    <?
if ($this->data['isIE']): ?>
        <label for="rn_<?=$this->instanceID;?>_HiddenInput" class="rn_Hidden">&nbsp;</label>
        <input id="rn_<?=$this->instanceID;?>_HiddenInput" type="text" class="rn_Hidden" disabled="disabled"/>
    <?
endif;
?>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if($this->CI->agent->browser() === 'Internet Explorer') $this->data['isIE'] = true;
}
}
function _standard_search_SearchButton_header() {
$result = array( 'js_name' => 'RightNow.Widgets.SearchButton', 'library_name' => 'SearchButton', 'view_func_name' => '_standard_search_SearchButton_view', 'meta' => array ( 'controller_path' => 'standard/search/SearchButton', 'view_path' => 'standard/search/SearchButton', 'js_path' => 'standard/search/SearchButton', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/SearchButton.css', 1 => 'assets/themes/standard/widgetCss/SearchButton.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4253)', ), 'relativePath' => 'standard/search/SearchButton', 'widget_name' => 'SearchButton', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'source_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4693), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4693), 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'FILEPATH', 'default' => '', 'inherited' => false, )), 'icon_alt_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4693), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4693), 'inherited' => false, )), 'target' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '_self', 'type' => 'STRING', 'default' => '_self', 'inherited' => false, )), 'popup_window' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'popup_window_width_percent' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 30, 'type' => 'INT', 'default' => 30, 'inherited' => false, )), 'popup_window_height_percent' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 42, 'type' => 'INT', 'default' => 42, 'inherited' => false, )), );
return $result;
}
}
namespace{
use \RightNow\Utils\FileSystem;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?=\RightNow\Utils\Text::getLanguageCode();?>" xml:lang="<?=\RightNow\Utils\Text::getLanguageCode();?>">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="X-UA-Compatible" content="chrome=1" />
    <title><?=\RightNow\Utils\Config::msgGetFrom((2572));?></title>
    <?=
\RightNow\Libraries\SEO::getCanonicalLinkTag() . "\n";
?>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<style type='text/css'>
 <!-- 
.rn_ScreenReaderOnly{position:absolute; height:1px; left:-10000px; overflow:hidden; top:auto; width:1px;}
.rn_Hidden{display:none;}
 --></style>
<base href='<?=\RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest', \RightNow\Utils\FileSystem::getOptimizedAssetsDir() . 'themes/standard/');?>'></base>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>pages/chat/chat_landing.themes.standard.SITE.css' rel='stylesheet' type='text/css' media='all'/>
<style type="text/css">
<!--
-->
</style>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>pages/chat/chat_landing.themes.standard.css' rel='stylesheet' type='text/css' media='all'/>
9c1379bc-cca6-4750-aee7-188f8348a6c3
</head>
<body class="yui-skin-sam">
    <div id="rn_ChatContainer">
        <a name="rn_MainContent" id="rn_MainContent"></a>
        <div id="rn_PageContent" class="rn_Live">
            <div class="rn_Padding" >
                <div id="rn_ChatDialogContainer">
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatOffTheRecordDialog',
array());
?>
                    <div id="rn_ChatDialogHeaderContainer">
                        <div id="rn_ChatDialogTitle" class="rn_FloatLeft"><h3><?=\RightNow\Utils\Config::msgGetFrom((7494));?></h3></div>
                        <div id="rn_ChatDialogHeaderButtonContainer">
                            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatDisconnectButton',
array());
?>
                            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatOffTheRecordButton', array());
?>
                            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatPrintButton', array());
?>
                        </div>
                    </div>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatServerConnect', array());
?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatEngagementStatus', array());
?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatQueueWaitTime', array('type' => 'all','label_estimated_wait_time_not_available' => '','label_average_wait_time_not_available' => '',));
?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatAgentStatus', array());
?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatTranscript', array());
?>
                    <div id="rn_PreChatButtonContainer">
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatCancelButton', array());
?>
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatRequestEmailResponseButton', array());
?>
                    </div>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatPostMessage', array());
?>
                    <div id="rn_InChatButtonContainer">
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatSendButton', array());
?>
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatAttachFileButton', array());
?>
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatCoBrowseButton', array());
?>
                    </div>
                    <div id="rn_ChatQueueSearchContainer">
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatQueueSearch', array('popup_window' => 'true',));
?>
                    </div>
                </div>
            </div>
        </div>
        <div id="rn_ChatFooter">
            <div class="rn_FloatRight">
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/RightNowLogo', array());
?>
            </div>
        </div>
    </div>
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=\RightNow\Utils\Url::getCoreAssetPath('js/4.171/min/RightNow.js');?>"></script>
<script type="text/javascript" src="<?=\RightNow\Utils\Url::getCoreAssetPath('js/4.171/min/RightNow.Chat.js');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/EventProvider.js', 1 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/Field.js', 2 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/Form.js', 3 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/SearchFilter.js', 4 => 'standard/chat/ChatPostMessage', 5 => 'standard/chat/ChatOffTheRecordDialog', 6 => 'standard/chat/ChatDisconnectButton', 7 => 'standard/chat/ChatOffTheRecordButton', 8 => 'standard/chat/ChatPrintButton', 9 => 'standard/chat/ChatServerConnect', 10 => 'standard/chat/ChatEngagementStatus', 11 => 'standard/chat/ChatQueueWaitTime', 12 => 'standard/chat/ChatAgentStatus', 13 => 'standard/chat/ChatTranscript', 14 => 'standard/chat/ChatCancelButton', 15 => 'standard/chat/ChatRequestEmailResponseButton', 16 => 'standard/chat/ChatSendButton', 17 => 'standard/input/FileAttachmentUpload', 18 => 'standard/chat/ChatAttachFileButton', 19 => 'standard/chat/ChatCoBrowseButton', 20 => 'standard/chat/ChatQueueSearch', 21 => 'standard/search/KeywordText', 22 => 'standard/search/SearchButton', ), '/chat/chat_landing.js', '1436303720');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'VALUE_MUST_BE_AN_INTEGER_MSG' => array ( 'value' => 4127, ), 'VALUE_IS_TOO_LARGE_MAX_VALUE_MSG' => array ( 'value' => 4125, ), 'VALUE_IS_TOO_SMALL_MIN_VALUE_MSG' => array ( 'value' => 4126, ), 'CONTAIN_1_CHARACTER_MSG' => array ( 'value' => 42414, ), 'PCT_D_CHARACTERS_MSG' => array ( 'value' => 2973, ), 'EXCEEDS_SZ_LIMIT_PCT_D_CHARS_1_LBL' => array ( 'value' => 42160, ), 'EXCEEDS_SZ_LIMIT_PCT_D_CHARS_PCT_D_LBL' => array ( 'value' => 1855, ), 'PCT_S_IS_AN_INVALID_POSTAL_CODE_MSG' => array ( 'value' => 3027, ), 'PCT_S_IS_AN_INVALID_PHONE_NUMBER_MSG' => array ( 'value' => 3026, ), 'PCT_S_CONT_SPACES_DOUBLE_QUOTES_LBL' => array ( 'value' => 41426, ), 'PCT_S_DIDNT_MATCH_EXPECTED_INPUT_LBL' => array ( 'value' => 3010, ), 'CONTAIN_SPACES_PLEASE_TRY_MSG' => array ( 'value' => 1344, ), 'PCT_S_IS_INVALID_MSG' => array ( 'value' => 3030, ), 'IS_NOT_A_VALID_URL_MSG' => array ( 'value' => 2246, ), 'FORMSUBMIT_PLACED_FORM_UNIQUE_ID_MSG' => array ( 'value' => 2021, ), 'PLS_VERIFY_REQ_ENTERING_TEXT_IMG_MSG' => array ( 'value' => 19038, ), 'THE_INPUT_IS_TOO_LONG_MSG' => array ( 'value' => 3920, ), 'CANCEL_LBL' => array ( 'value' => 9555, ), 'EXISTING_CHAT_SESS_FND_RESUME_SESS_MSG' => array ( 'value' => 5336, ), 'EXISTING_CHAT_SESSION_LBL' => array ( 'value' => 1861, ), 'COMM_RN_LIVE_SERV_LOST_CHAT_SESS_MSG' => array ( 'value' => 5334, ), 'COMM_RN_LIVE_SERV_LOST_PLS_WAIT_MSG' => array ( 'value' => 37354, ), 'CONNECTION_RESUMED_MSG' => array ( 'value' => 4804, ), 'NAME_SUFFIX_LBL' => array ( 'value' => 7023, ), 'DISCONNECTED_CHAT_DUE_INACTIVITY_MSG' => array ( 'value' => 4806, ), 'REQUEUED_APPROXIMATELY_0_MSG' => array ( 'value' => 9942, ), 'DISCONNECTION_IN_0_SECONDS_MSG' => array ( 'value' => 9921, ), 'COMM_DISP_NAME_LOST_PLS_WAIT_MSG' => array ( 'value' => 5333, ), 'COMM_DISPLAY_NAME_RESTORED_MSG' => array ( 'value' => 5332, ), 'FIELD_REQUIRED_MARK_LBL' => array ( 'value' => 1908, ), 'REQUIRED_LBL' => array ( 'value' => 7015, ), 'FILE_PATH_FOUND_MSG' => array ( 'value' => 1932, ), 'FILE_ATT_UPLOAD_EMPTY_PLS_ENSURE_MSG' => array ( 'value' => 1917, ), 'FILE_UPLOAD_ALLOWED_FILE_MSG' => array ( 'value' => 1944, ), 'FILE_DELETED_LBL' => array ( 'value' => 1922, ), 'UPLOADING_ELLIPSIS_MSG' => array ( 'value' => 4057, ), 'FILE_UPLOAD_COMPLETE_LBL' => array ( 'value' => 1945, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), 'CHAT_CLUSTER_POOL_ID' => array ( 'value' => 382, ), 'ABSENT_INTERVAL' => array ( 'value' => 404, ), 'USER_ABSENT_RETRY_COUNT' => array ( 'value' => 409, ), 'SRV_CHAT_HOST' => array ( 'value' => 389, ), 'SERVLET_HTTP_PORT' => array ( 'value' => 393, ), 'DB_NAME' => array ( 'value' => 120, ), 'AGENT_ABSENT_RETRY_COUNT' => array ( 'value' => 405, ), 'ESTIMATED_WAIT_TIME_SAMPLES' => array ( 'value' => 438, ), 'intl_nameorder' => array ( 'value' => 134, ), 'MOD_COBROWSE_ENABLED' => array ( 'value' => 78, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
