<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/mobile', 1 => '/euf/assets/themes/mobile', 2 => array ( '/euf/assets/themes/mobile' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile', ), ));
get_instance()->_checkMeta(array('javascript_module'=>'mobile_may_10', 'clickstream'=>'chat_landing', 'include_chat'=>'true'));
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
namespace{
use \RightNow\Utils\FileSystem;
?>
<!DOCTYPE html>
<html lang="<?=\RightNow\Utils\Text::getLanguageCode();?>">
    <head>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <title><?=\RightNow\Utils\Config::msgGetFrom((2572));?></title>
        <?=
\RightNow\Libraries\SEO::getCanonicalLinkTag() . "\n";
?>
<style type='text/css'>
 <!-- 
.rn_ScreenReaderOnly{position:absolute; height:1px; left:-10000px; overflow:hidden; top:auto; width:1px;}
.rn_Hidden{display:none;}
 --></style>
<base href='<?=\RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest', \RightNow\Utils\FileSystem::getOptimizedAssetsDir() . 'themes/mobile/');?>'/>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>pages/mobile/chat/chat_landing.themes.mobile.SITE.css' rel='stylesheet' type='text/css' media='all'/>
<style type="text/css">
<!--
-->
</style>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>pages/mobile/chat/chat_landing.themes.mobile.css' rel='stylesheet' type='text/css' media='all'/>
9c1379bc-cca6-4750-aee7-188f8348a6c3
        <link rel="icon" href="images/favicon.png" type="image/png">
    </head>
    <body>
        <noscript><h1><?=\RightNow\Utils\Config::msgGetFrom((4861));?></h1></noscript>
        <header>
            <?if(
(true) ):?>
            <nav id="rn_Navigation">
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
                <span class="rn_FloatRight">
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatDisconnectButton',
array('close_icon_path' => '','disconnect_icon_path' => '','mobile_mode' => 'true',));
?>
                </span>
                <span class="rn_FloatRight rn_Search">
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatCancelButton', array());
?>
                </span>
            </nav>
            <?endif;?>
        </header>
        <div id="rn_ChatContainer">
            <a name="rn_MainContent" id="rn_MainContent"></a>
            <div id="rn_PageContent" class="rn_Live">
                <div id="rn_ChatDialogContainer">
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatServerConnect',
array());
?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatEngagementStatus', array());
?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatQueueWaitTime', array('type' => 'all','label_estimated_wait_time_not_available' => '','label_average_wait_time_not_available' => '',));
?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatAgentStatus', array());
?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatTranscript', array('mobile_mode' => 'true',));
?>
                    <div id="rn_PreChatButtonContainer">
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatRequestEmailResponseButton', array());
?>
                    </div>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatPostMessage', array('label_send_instructions' => '' . \RightNow\Utils\Config::msgGetFrom((4018)) . '','mobile_mode' => 'true',));
?>
                    <div id="rn_InChatButtonContainer">
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/chat/ChatSendButton', array());
?>
                    </div>
                </div>
            </div>
        </div>
        <footer>
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
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=\RightNow\Utils\Url::getCoreAssetPath('js/4.171/min/RightNow.Chat.js');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/navigation/MobileNavigationMenu', 1 => 'standard/chat/ChatDisconnectButton', 2 => 'standard/chat/ChatCancelButton', 3 => 'standard/chat/ChatServerConnect', 4 => 'standard/chat/ChatEngagementStatus', 5 => 'standard/chat/ChatQueueWaitTime', 6 => 'standard/chat/ChatAgentStatus', 7 => 'standard/chat/ChatTranscript', 8 => 'standard/chat/ChatRequestEmailResponseButton', 9 => 'standard/chat/ChatPostMessage', 10 => 'standard/chat/ChatSendButton', 11 => 'standard/login/LogoutLink', ), '/mobile/chat/chat_landing.js', '1439568043');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'CANCEL_LBL' => array ( 'value' => 9555, ), 'EXISTING_CHAT_SESS_FND_RESUME_SESS_MSG' => array ( 'value' => 5336, ), 'EXISTING_CHAT_SESSION_LBL' => array ( 'value' => 1861, ), 'COMM_RN_LIVE_SERV_LOST_CHAT_SESS_MSG' => array ( 'value' => 5334, ), 'COMM_RN_LIVE_SERV_LOST_PLS_WAIT_MSG' => array ( 'value' => 37354, ), 'CONNECTION_RESUMED_MSG' => array ( 'value' => 4804, ), 'NAME_SUFFIX_LBL' => array ( 'value' => 7023, ), 'DISCONNECTED_CHAT_DUE_INACTIVITY_MSG' => array ( 'value' => 4806, ), 'REQUEUED_APPROXIMATELY_0_MSG' => array ( 'value' => 9942, ), 'DISCONNECTION_IN_0_SECONDS_MSG' => array ( 'value' => 9921, ), 'COMM_DISP_NAME_LOST_PLS_WAIT_MSG' => array ( 'value' => 5333, ), 'COMM_DISPLAY_NAME_RESTORED_MSG' => array ( 'value' => 5332, ), 'THE_INPUT_IS_TOO_LONG_MSG' => array ( 'value' => 3920, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), 'CHAT_CLUSTER_POOL_ID' => array ( 'value' => 382, ), 'ABSENT_INTERVAL' => array ( 'value' => 404, ), 'USER_ABSENT_RETRY_COUNT' => array ( 'value' => 409, ), 'SRV_CHAT_HOST' => array ( 'value' => 389, ), 'SERVLET_HTTP_PORT' => array ( 'value' => 393, ), 'DB_NAME' => array ( 'value' => 120, ), 'AGENT_ABSENT_RETRY_COUNT' => array ( 'value' => 405, ), 'ESTIMATED_WAIT_TIME_SAMPLES' => array ( 'value' => 438, ), 'intl_nameorder' => array ( 'value' => 134, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
