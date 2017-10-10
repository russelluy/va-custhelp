<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/standard', 1 => '/euf/assets/themes/standard', 2 => array ( '/euf/assets/themes/standard' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/standard', ), ));
get_instance()->_checkMeta(array('title'=>'' . \RightNow\Utils\Config::msgGetFrom((4827)) . '', 'template'=>'standard.php', 'login_required'=>'true', 'force_https'=>'true'));
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
class AnswerNotificationManager extends \RightNow\Libraries\Widget\Base {
function _standard_notifications_AnswerNotificationManager_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <div id="rn_<?=$this->instanceID;?>_Message"></div>
<?
if(count($this->data['notifications'])):?>
    <div id="rn_<?=$this->instanceID;?>_List">
    <?
foreach($this->data['notifications'] as $index => $notification):?>
        <div class="rn_Notification" data-id="<?=$notification['id']?>">
            <div class="rn_Notification_Info">
                <a href="<?=$notification['url']?>" target="_blank"><?=$notification['summary']?></a>
                <span><?=sprintf(\RightNow\Utils\Config::getMessage((3846)), $notification['startDate']);?></span>
                <span><?=
($notification['expiresTime']) ? $notification['expiresTime'] : \RightNow\Utils\Config::getMessage((4977));
?></span>
            </div>
            <div class="rn_Notification_Actions">
                <?if($this->data['js']['duration']):?>
                <button class="rn_Notification_Renew"><?=$this->data['attrs']['label_renew_button'];?></button>
                <?endif;?>
                <button class="rn_Notification_Delete"><?=$this->data['attrs']['label_delete_button'];?></button>
            </div>
        </div>
    <?
endforeach;?>
    </div>
<?
else:?>
<?=$this->data['attrs']['label_no_notifs'];?>
<?
endif;?>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['js']['duration'] = \RightNow\Utils\Config::getConfig((298));
$this->data['notifications'] = array();
$answerNotifications = $this->CI->model('Notification')->get('answer')->result['answer'] ?: array();
$answerNotifications = \RightNow\Utils\Framework::sortBy($answerNotifications, true, function($notification) {
return $notification->StartTime;
});
foreach($answerNotifications as $notification) {
$notificationDetails = array( 'startDate' => \RightNow\Utils\Framework::formatDate($notification->StartTime, 'default', null), 'summary' => $notification->Answer->Summary, 'id' => $notification->Answer->ID, 'url' => \RightNow\Utils\Url::addParameter($this->data['attrs']['url'], 'a_id', $notification->Answer->ID) . \RightNow\Utils\Url::sessionParameter() );
if($this->data['js']['duration'] > 0) $notificationDetails['expiresTime'] = $notification->ExpireTime;
$this->data['notifications'][] = $notificationDetails;
}
}
}
function _standard_notifications_AnswerNotificationManager_header() {
$result = array( 'js_name' => 'RightNow.Widgets.AnswerNotificationManager', 'library_name' => 'AnswerNotificationManager', 'view_func_name' => '_standard_notifications_AnswerNotificationManager_view', 'meta' => array ( 'controller_path' => 'standard/notifications/AnswerNotificationManager', 'view_path' => 'standard/notifications/AnswerNotificationManager', 'js_path' => 'standard/notifications/AnswerNotificationManager', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/AnswerNotificationManager.css', 1 => 'assets/themes/standard/widgetCss/AnswerNotificationManager.css', ), 'base_css' => array ( 0 => 'standard/notifications/AnswerNotificationManager/base.css', ), 'js_templates' => array ( 'view' => ' <div class="rn_Notification" data-id="<%=id%>">  <div class="rn_Notification_Info">  <a href="<%=url%>" target="_blank"><%=summary%></a>   <span><%=subscribedLabel%></span>   <span><%=expiresLabel%></span>  </div>   <div class="rn_Notification_Actions"> <% if(includeRenew) { %>  <button class="rn_Notification_Renew"><%=renewLabel%></button>  <% } %>  <button class="rn_Notification_Delete"><%=deleteLabel%></button>  </div>  </div>', ), 'template_path' => 'standard/notifications/AnswerNotificationManager', 'version' => '2.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(42111)', ), 'relativePath' => 'standard/notifications/AnswerNotificationManager', 'widget_name' => 'AnswerNotificationManager', ), );
$result['meta']['attributes'] = array( 'label_renew_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4959), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4959), 'inherited' => false, )), 'label_delete_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(853), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(853), 'inherited' => false, )), 'label_notif_renewed' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2833), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2833), 'inherited' => false, )), 'label_notif_deleted' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2831), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2831), 'inherited' => false, )), 'label_no_notifs' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1674), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1674), 'inherited' => false, )), 'message_element' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((222)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((222)), 'inherited' => false, )), 'renew_notification_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/addOrRenewNotification', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/addOrRenewNotification', 'inherited' => false, )), 'delete_notification_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/deleteNotification', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/deleteNotification', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Config;
class ProdCatNotificationManager extends \RightNow\Libraries\Widget\Base {
function _standard_notifications_ProdCatNotificationManager_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <div id="rn_<?=$this->instanceID;?>_Message"></div>
    <div id="rn_<?=$this->instanceID;?>_List">
    <?
if(count($this->data['notifications'])):?>
        <? foreach($this->data['notifications'] as $index => $notification):?>
        <div id="rn_<?=$this->instanceID;?>_Notification_<?=$index;?>" class="rn_Notification">
            <div class="rn_Notification_Info">
                <a href="<?=$notification['url'];?>" target="_blank"><?=htmlspecialchars($notification['label'],
ENT_QUOTES, 'UTF-8');?></a>
                <span><?
printf(\RightNow\Utils\Config::getMessage((3846)), $notification['startDate']);?></span>
                <span id="rn_<?=$this->instanceID;?>_Expiration_<?=$index;?>">
                    <?=
$notification['expiresTime'] ? $notification['expiresTime'] : \RightNow\Utils\Config::getMessage((4977)) ?>
                </span>
            </div>
            <div class="rn_Notification_Actions">
                <? if($this->data['js']['duration']):?>
                    <button id="rn_<?=$this->instanceID;?>_Renew_<?=$index;?>"><?=$this->data['attrs']['label_renew_button'];?></button>
                <?
endif;?>
                <button id="rn_<?=$this->instanceID;?>_Delete_<?=$index;?>"><?=$this->data['attrs']['label_delete_button'];?></button>
            </div>
        </div>
        <?
endforeach;?>
    <?
else:?>
    <?=$this->data['attrs']['label_no_notifs'];?>
    <?
endif;?>
    </div>
    <div class="rn_ButtonGroup">
        <button id="rn_<?=$this->instanceID;?>_AddButton" class="rn_AddButton"><?=$this->data['attrs']['label_add_button'];?></button>
    </div>
    <form id="rn_<?=$this->instanceID
?>_Form">
        <div id="rn_<?=$this->instanceID;?>_Dialog" class="rn_ProdCatNotificationManager_Dialog rn_Hidden">
            <div class="rn_SelectionWidget">
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/ProductCategoryInput',
array('label_set_button' => '' . \RightNow\Utils\Config::msgGetFrom((7508)) . '','set_button' => 'true','linking_off' => 'true','sub_id' => 'prod',));
?>
            </div>
            <div class="rn_SelectionWidget">
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/ProductCategoryInput', array('data_type' => 'Category','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4574)) . '','label_nothing_selected' => '' . \RightNow\Utils\Config::msgGetFrom((3529)) . '','label_set_button' => '' . \RightNow\Utils\Config::msgGetFrom((7507)) . '','set_button' => 'true','linking_off' => 'true','sub_id' => 'cat',));
?>
            </div>
        </div>
    </form>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['js']['duration'] = \RightNow\Utils\Config::getConfig((298));
$this->data['js']['productsTable'] = (13);
$this->data['js']['categoriesTable'] = (14);
$notificationLists = $this->CI->model('Notification')->get(array('product', 'category'))->result;
$allNotifications = array_merge($notificationLists['product'] ?: array(), $notificationLists['category'] ?: array());
$allNotifications = \RightNow\Utils\Framework::sortBy($allNotifications, true, function($n) {
return $n->StartTime;
});
$notifications = $this->data['js']['notifications'] = array();
foreach($allNotifications as $notification) {
if(\RightNow\Utils\Connect::isProductNotificationType($notification)) {
$label = Config::getMessage((4594));
$hierarchyType = 'ProductHierarchy';
$notificationObject = 'Product';
$urlKey = 'p';
$filterType = (13);
}
else {
$label = Config::getMessage((4574));
$hierarchyType = 'CategoryHierarchy';
$notificationObject = 'Category';
$urlKey = 'c';
$filterType = (14);
}
$labelChain = "$label - ";
foreach($notification->$notificationObject->$hierarchyType as $parent) {
$labelChain .= $parent->LookupName . ' / ';
}
$labelChain .= $notification->$notificationObject->LookupName;
$this->data['notifications'][] = array( 'startDate' => \RightNow\Utils\Framework::formatDate($notification->StartTime, 'default', null), 'label' => $labelChain, 'url' => $this->data['attrs']['report_page_url'] . "/$urlKey/" . $notification->$notificationObject->ID . \RightNow\Utils\Url::sessionParameter(), 'expiresTime' => ($this->data['js']['duration'] > 0) ? $notification->ExpireTime : null );
$this->data['js']['notifications'][] = array( 'id' => $notification->$notificationObject->ID, 'filter_type' => $filterType );
}
}
}
function _standard_notifications_ProdCatNotificationManager_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ProdCatNotificationManager', 'library_name' => 'ProdCatNotificationManager', 'view_func_name' => '_standard_notifications_ProdCatNotificationManager_view', 'meta' => array ( 'controller_path' => 'standard/notifications/ProdCatNotificationManager', 'view_path' => 'standard/notifications/ProdCatNotificationManager', 'js_path' => 'standard/notifications/ProdCatNotificationManager', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ProdCatNotificationManager.css', 1 => 'assets/themes/standard/widgetCss/ProdCatNotificationManager.css', ), 'base_css' => array ( 0 => 'standard/notifications/ProdCatNotificationManager/base.css', ), 'js_templates' => array ( 'view' => '<div id="<%= divID %>" class="rn_Notification"> <div class="rn_Notification_Info">  <a href="<%= href %>" target="_blank"><%= label %></a> <span><%= startDate %></span> <span><%= expirationDate %></span>  </div> <div class="rn_Notification_Actions"> <% if (renewButtonID) { %>  <button id="<%= renewButtonID %>"><%= labelRenewButton %></button>  <% } %>  <button id="<%= deleteButtonID %>"><%= labelDeleteButton %></button>  </div></div>', ), 'template_path' => 'standard/notifications/ProdCatNotificationManager', 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4309)', ), 'contains' => array ( 0 => array ( 'widget' => 'standard/input/ProductCategoryInput', 'versions' => array ( 0 => '1.2', ), ), ), 'relativePath' => 'standard/notifications/ProdCatNotificationManager', 'widget_name' => 'ProdCatNotificationManager', ), );
$result['meta']['attributes'] = array( 'renew_notification_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/addOrRenewNotification', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/addOrRenewNotification', 'inherited' => false, )), 'delete_notification_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/deleteNotification', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/deleteNotification', 'inherited' => false, )), 'label_renew_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4959), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4959), 'inherited' => false, )), 'label_delete_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(853), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(853), 'inherited' => false, )), 'label_notif_renewed' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2833), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2833), 'inherited' => false, )), 'label_notif_deleted' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2831), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2831), 'inherited' => false, )), 'label_no_notifs' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1675), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1675), 'inherited' => false, )), 'label_add_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(923), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(923), 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/answers/list', 'type' => 'STRING', 'default' => '/app/answers/list', 'inherited' => false, )), 'message_element' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_dialog_cancel' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9555), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9555), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Url, RightNow\Utils\Text;
class ProductCategoryInput extends \RightNow\Libraries\Widget\Input {
function _standard_input_ProductCategoryInput_view ($data) {
extract($data);
?><?php ?>
<? if($this->data['js']['readOnly']):?>
<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/ProductCategoryDisplay', array('name' => '' . 'Incident.' . $this->data['attrs']['data_type'] . '','label' => '' . $this->data['attrs']['label_input'] . '','left_justify' => 'true',));
?>
<? else:?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <a href="javascript:void(0);" class="rn_ScreenReaderOnly" id="rn_<?=$this->instanceID?>_LinksTrigger"><?printf($this->data['attrs']['label_screen_reader_accessible_option'], $this->data['attrs']['label_input'])?>&nbsp;<span id="rn_<?=$this->instanceID;?>_TreeDescription"></span></a>
    <?
if($this->data['attrs']['label_input']):?>
    <span class="rn_Label" id="rn_<?= $this->instanceID ?>_Label">
        <?=$this->data['attrs']['label_input']?>
        <? if($this->data['attrs']['required_lvl']):?>
        <span class="rn_Required"> <?=\RightNow\Utils\Config::getMessage((1908));?></span><span id="rn_<?=$this->instanceID;?>_RequiredLabel" class="rn_RequiredLabel">
            <span class="rn_ScreenReaderOnly">
                <?=\RightNow\Utils\Config::getMessage((7015));?>
            </span>
        </span>
        <?
endif;?>
    </span>
    <?
endif;?>
    <button type="button" id="rn_<?=$this->instanceID;?>_<?=$this->data['attrs']['data_type'];?>_Button" class="rn_DisplayButton"><span class="rn_ScreenReaderOnly"><?=$this->data['attrs']['label_accessible_interface']?></span> <span id="rn_<?=$this->instanceID?>_Button_Visible_Text"><?=$this->data['attrs']['label_nothing_selected'];?></span></button>
    <div class="rn_ProductCategoryLinks rn_Hidden" id="rn_<?=$this->instanceID;?>_Links"></div>
    <div id="rn_<?=$this->instanceID;?>_TreeContainer" class="rn_PanelContainer rn_Hidden">
        <div id="rn_<?=$this->instanceID;?>_Tree" class="rn_Panel">
            <?
?>
        </div>
    <? if ($this->data['attrs']['show_confirm_button_in_dialog']): ?>
        <div id="rn_<?=$this->instanceID;?>_SelectionButtons" class="rn_SelectionButtons">
            <button type="button" id="rn_<?=$this->instanceID;?>_<?=$this->data['attrs']['data_type'];?>_ConfirmButton"><?=$this->data['attrs']['label_confirm_button'];?></button>
            <button type="button" id="rn_<?=$this->instanceID;?>_<?=$this->data['attrs']['data_type'];?>_CancelButton"><?=$this->data['attrs']['label_cancel_button'];?></button>
        </div>
    <?
endif;
?>
    </div>
    <? if($this->data['attrs']['set_button']):?>
    <button type="button" id="rn_<?=$this->instanceID;?>_<?=$this->data['attrs']['data_type'];?>_SetButton"><?=$this->data['attrs']['label_set_button']?></button>
    <?
endif;?>
</div>
<?
endif;?>
<?
}
const PRODUCT = 'Product';
const CATEGORY = 'Category';
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$dataType = $this->data['attrs']['data_type'] = (Text::stringContains(strtolower($this->data['attrs']['data_type']), 'prod')) ? self::PRODUCT : self::CATEGORY;
if ($this->data['attrs']['data_type'] === self::CATEGORY) {
$this->data['attrs']['label_all_values'] = ($this->data['attrs']['label_all_values'] === \RightNow\Utils\Config::getMessage((843))) ? \RightNow\Utils\Config::getMessage((842)) : $this->data['attrs']['label_all_values'];
$this->data['attrs']['label_input'] = ($this->data['attrs']['label_input'] === \RightNow\Utils\Config::getMessage((4594))) ? \RightNow\Utils\Config::getMessage((4574)) : $this->data['attrs']['label_input'];
$this->data['attrs']['label_nothing_selected'] = ($this->data['attrs']['label_nothing_selected'] === \RightNow\Utils\Config::getMessage((3532))) ? \RightNow\Utils\Config::getMessage((3529)) : $this->data['attrs']['label_nothing_selected'];
}
if ($this->data['attrs']['table'] === 'contacts') {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((40942)), 'contacts', 'table'));
return false;
}
$this->data['js']['name'] = $this->data['attrs']['name'] = "Incident.{$this->data['attrs']['data_type']}";
if (parent::getData() === false) return false;
if (!in_array($this->dataType, array('ServiceProduct', 'ServiceCategory'))) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((40365)), $this->fieldName));
return false;
}
if($this->data['attrs']['required_lvl'] > $this->data['attrs']['max_lvl']) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((4119)), "required_lvl", "max_lvl", "max_lvl", "required_lvl", $this->data['attrs']['required_lvl']));
$this->data['attrs']['max_lvl'] = $this->data['attrs']['required_lvl'];
}
if($this->data['attrs']['hint'] && strlen(trim($this->data['attrs']['hint']))){
$this->data['js']['hint'] = $this->data['attrs']['hint'];
}
$trimmedTreeViewCss = trim($this->data['attrs']['treeview_css']);
if ($trimmedTreeViewCss !== '') $this->addStylesheet($trimmedTreeViewCss);
$this->data['js']['linkingOn'] = $this->data['attrs']['linking_off'] ? 0 : $this->CI->model('Prodcat')->getLinkingMode();
$this->data['js']['hm_type'] = ($dataType === self::PRODUCT) ? (13) : (14);
$maxLevel = $this->data['attrs']['max_lvl'];
$defaultChain = $this->getDefaultChain();
if($this->data['js']['linkingOn'] && $dataType === self::CATEGORY) {
$defaultProductID = $this->CI->model('Prodcat')->getDefaultProductID() ?: null;
$this->data['js']['link_map'] = $defaultHierMap = $this->CI->model('Prodcat')->getFormattedTree($dataType, $defaultChain, true, $defaultProductID, $maxLevel)->result;
$this->data['js']['hierDataNone'] = $this->CI->model('Prodcat')->getFormattedTree($dataType, array(), true, null, $maxLevel)->result;
array_unshift($this->data['js']['hierDataNone'][0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
array_unshift($this->data['js']['link_map'][0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
}
else {
if($dataType === self::PRODUCT) {
$this->CI->model('Prodcat')->setDefaultProductID(end($defaultChain));
}
$defaultHierMap = $this->CI->model('Prodcat')->getFormattedTree($dataType, $defaultChain, false, null, $maxLevel)->result;
}
array_unshift($defaultHierMap[0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
$this->data['js']['hierData'] = $defaultHierMap;
}
protected function getDefaultChain() {
$dataType = $this->data['attrs']['data_type'];
$shortDataType = ($dataType === self::PRODUCT) ? 'prod' : 'cat';
$defaultValue = null;
$postKeys = array( "Incident_$dataType", "incidents_$shortDataType", $shortDataType[0], );
$urlKeys = array( "Incident.$dataType", "incidents.$shortDataType", $shortDataType[0], );
foreach ($postKeys as $key) {
$postParam = $this->CI->input->post($key);
if ($postParam !== false) {
$defaultValue = $postParam;
}
}
$incidentID = Url::getParameter('i_id');
if (($defaultValue === false || $defaultValue === null) && $incidentID && $incident = $this->CI->model('Incident')->get($incidentID)->result) {
$incidentValue = $incident->{$dataType}->ID;
if ($incidentValue) {
$defaultValue = $incidentValue;
}
}
if ($defaultValue === false || $defaultValue === null) {
foreach ($urlKeys as $key) {
$urlParam = Url::getParameter($key);
if ($urlParam !== null) {
$defaultValue = $urlParam;
}
}
}
if ($defaultValue === false || $defaultValue === null) {
$defaultFromAttribute = $this->data['attrs']['default_value'];
if ($defaultFromAttribute !== false) {
$defaultValue = $defaultFromAttribute;
}
}
if($defaultValue) {
$defaultChain = explode(',', $defaultValue);
$defaultChain = (count($defaultChain) === 1) ? $this->CI->model('Prodcat')->getFormattedChain($dataType, $defaultChain[0], true)->result : $this->CI->model('Prodcat')->getEnduserVisibleHierarchy($defaultChain)->result;
if(count($defaultChain) > $this->data['attrs']['max_lvl']) {
$defaultChain = array_splice($defaultChain, 0, $this->data['attrs']['max_lvl']);
}
}
return $defaultChain ?: array();
}
}
function _standard_input_ProductCategoryInput_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ProductCategoryInput', 'library_name' => 'ProductCategoryInput', 'view_func_name' => '_standard_input_ProductCategoryInput_view', 'meta' => array ( 'controller_path' => 'standard/input/ProductCategoryInput', 'view_path' => 'standard/input/ProductCategoryInput', 'js_path' => 'standard/input/ProductCategoryInput', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ProductCategoryInput.css', 1 => 'assets/themes/standard/widgetCss/ProductCategoryInput.css', ), 'base_css' => array ( 0 => 'standard/input/ProductCategoryInput/base.css', ), 'js_templates' => array ( 'label' => '<%= label %><% if(requiredLevel) { %><span class="rn_Required"> <%= requiredMarkLabel %></span><span id="rn_<%= instanceID %>_RequiredLabel" class="rn_RequiredLabel"> <span class="rn_ScreenReaderOnly"> <%= requiredLabel %> </span></span><% } %>', ), 'template_path' => 'standard/input/ProductCategoryInput', 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', ), 'yui' => array ( 0 => 'panel', 1 => 'gallery-treeview', ), ), 'info' => array ( 'description' => 'rn:msg:(42107)', 'urlParameters' => array ( 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), 'Incident.Product' => array ( 'name' => 'rn:msg:(4594)', 'description' => 'rn:msg:(41957)', 'example' => 'Incident.Product/1,2,3', ), 'Incident.Category' => array ( 'name' => 'rn:msg:(4574)', 'description' => 'rn:msg:(41956)', 'example' => 'Incident.Category/1', ), ), ), 'contains' => array ( 0 => array ( 'widget' => 'standard/output/ProductCategoryDisplay', 'versions' => array ( 0 => '1.0', 1 => '1.1', ), ), ), 'relativePath' => 'standard/input/ProductCategoryInput', 'widget_name' => 'ProductCategoryInput', ), );
$result['meta']['attributes'] = array( 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_all_values' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(843), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(843), 'inherited' => false, )), 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4594), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4594), 'inherited' => false, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_set_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4623), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4623), 'inherited' => false, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3154), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3154), 'inherited' => false, )), 'label_confirm_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(864), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(864), 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(849), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(849), 'inherited' => false, )), 'label_nothing_selected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3532), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3532), 'inherited' => false, )), 'label_accessible_interface' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1100), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1100), 'inherited' => false, )), 'label_screen_reader_selected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4133), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4133), 'inherited' => false, )), 'label_screen_reader_accessible_option' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3491), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3491), 'inherited' => false, )), 'label_level' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(8667), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(8667), 'inherited' => false, )), 'data_type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'Product', 'type' => 'OPTION', 'default' => 'Product', 'options' => array(0 => 'Product', 1 => 'Category', 2 => 'Products', 3 => 'Categories', ), 'inherited' => false, )), 'required_lvl' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'max' => 6, 'inherited' => false, )), 'max_lvl' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 6, 'type' => 'INT', 'default' => 6, 'min' => 1, 'max' => 6, 'inherited' => false, )), 'linking_off' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'set_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'treeview_css' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Url::getYUICodePath('gallery-treeview/assets/treeview-menu.css'), 'type' => 'STRING', 'default' => \RightNow\Utils\Url::getYUICodePath('gallery-treeview/assets/treeview-menu.css'), 'inherited' => false, )), 'show_confirm_button_in_dialog' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ProductCategoryDisplay extends \RightNow\Libraries\Widget\Output {
function _standard_output_ProductCategoryDisplay_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
<? if ($this->data['attrs']['label']): ?>
    <span class="rn_DataLabel"><?=$this->data['attrs']['label'];?></span>
<?
endif;
?>
    <div class="rn_DataValue<?=$this->data['wrapClass']?>">
        <ul>
        <? foreach($this->data['value'] as $item):?>
            <li>
            <?= str_repeat('&nbsp;&nbsp;', $item['Depth']) ?>
            <? $value = htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8');
?>
            <? if ($this->data['attrs']['report_page_url']): ?>
                <a href="<?=$this->data['attrs']['report_page_url'] . '/' . $this->data['filterKey'] . '/' . $item['ID'] . $this->data['appendedParameters'];?>"><?=$value;?></a>
            <?
else: ?>
                <?=$value;?>
            <?
endif;
?>
            </li>
        <? endforeach;
?>
        </ul>
    </div>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(parent::getData() === false) return false;
if(!$type = \RightNow\Utils\Connect::getProductCategoryType($this->data['value'])){
echo $this->reportError(\RightNow\Utils\Config::getMessage((3268)));
return false;
}
if(is_object($this->data['value']) && !\RightNow\Utils\Connect::isArray($this->data['value'])) {
if(!$this->data['value']->ID || (!$chain = $this->CI->model('Prodcat')->getFormattedChain($type, $this->data['value']->ID)->result)) return false;
$depth = 0;
$this->data['value'] = array();
foreach($chain as $item) {
$this->data['value'][] = $this->createResultItem($item['id'], $item['label'], $depth++);
}
}
else {
if(count($this->data['value']) === 0 || !$result = $this->generateTree($type)) return false;
$this->data['value'] = $result;
}
if($this->data['attrs']['report_page_url'] !== '') {
$this->data['filterKey'] = ($type === 'product') ? 'p' : 'c';
$this->data['attrs']['url'] = rtrim($this->data['attrs']['url'], '/');
$this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']) . \RightNow\Utils\Url::sessionParameter();
}
$this->data['wrapClass'] = ($this->data['attrs']['left_justify']) ? ' rn_LeftJustify' : '';
}
protected function generateTree($type) {
$dataTree = array();
$prodcat = $this->CI->model('Prodcat');
foreach($this->data['value'] as $leaf) {
if(!$chain = $prodcat->getFormattedChain($type, $leaf->ID)->result) {
continue;
}
$depth = 0;
foreach($chain as $item) {
$parentID = (!$depth) ? 0 : $chain[$depth - 1]['id'];
$dataTree[$parentID][$prodcat->get($item['id'])->result->DisplayOrder] = $this->createResultItem($item['id'], $item['label'], $depth++);
}
}
foreach($dataTree as &$nodeList) {
ksort($nodeList);
$nodeList = array_values($nodeList);
}
$iter = 0;
$listCounts = $iterStacks = $resultList = array();
while(true) {
if($iter === null) break;
if(!isset($listCounts[$iter])) $listCounts[$iter] = 0;
if($listCounts[$iter] === count($dataTree[$iter])) {
$iter = array_pop($iterStacks);
continue;
}
$item = $dataTree[$iter][$listCounts[$iter]];
array_push($resultList, $item);
$listCounts[$iter]++;
if(isset($dataTree[$item['ID']])) {
array_push($iterStacks, $iter);
$iter = $item['ID'];
}
}
return $resultList;
}
protected function createResultItem($id, $label, $depth) {
return array('ID' => $id, 'Name' => $label, 'Depth' => $depth);
}
}
function _standard_output_ProductCategoryDisplay_header() {
$result = array( 'js_name' => '', 'library_name' => 'ProductCategoryDisplay', 'view_func_name' => '_standard_output_ProductCategoryDisplay_view', 'meta' => array ( 'controller_path' => 'standard/output/ProductCategoryDisplay', 'view_path' => 'standard/output/ProductCategoryDisplay', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ProductCategoryDisplay.css', 1 => 'assets/themes/basic/widgetCss/ProductCategoryDisplay.css', 2 => 'assets/themes/standard/widgetCss/ProductCategoryDisplay.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(51783)', 'urlParameters' => array ( 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(993)', 'example' => 'a_id/3', ), 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), ), ), 'relativePath' => 'standard/output/ProductCategoryDisplay', 'widget_name' => 'ProductCategoryDisplay', ), );
$result['meta']['attributes'] = array( 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'STRING', 'default' => '{default_label}', 'inherited' => false, )), 'left_justify' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'string', 'default' => 'kw', 'inherited' => false, )), );
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
$result = array( 'js_name' => 'RightNow.Widgets.LoginDialog', 'library_name' => 'LoginDialog', 'view_func_name' => '_standard_login_LoginDialog_view', 'meta' => array ( 'controller_path' => 'standard/login/LoginDialog', 'view_path' => 'standard/login/LoginDialog', 'js_path' => 'standard/login/LoginDialog', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/LoginDialog.css', 1 => 'assets/themes/standard/widgetCss/LoginDialog.css', ), 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(42108)', 'urlParameters' => array ( 'redirect' => array ( 'name' => 'rn:msg:(3354)', 'description' => 'rn:msg:(1761)', 'example' => 'redirect/home', ), 'username' => array ( 'name' => 'rn:msg:(4846)', 'description' => 'rn:msg:(3199)', 'example' => 'username/JohnDoe', ), ), ), 'relativePath' => 'standard/login/LoginDialog', 'widget_name' => 'LoginDialog', ), );
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
.rn_AnswerNotificationManager{overflow:hidden;}
.rn_AnswerNotificationManager .rn_Notification{overflow:auto;*overflow:none;padding:8px 0;width:80%;}
.rn_AnswerNotificationManager .rn_Notification_Actions{float:right;width:34%;}
.rn_AnswerNotificationManager .rn_Notification_Info{float:left;overflow:hidden;width:62%;}
.rn_AnswerNotificationManager .rn_Notification_Info span{display:block;}
.rn_AnswerNotificationManager{background:#F2FAFD;border:1px solid #DDD;margin:10px 0px 20px;padding:10px 4px 8px;}
.rn_AnswerNotificationManager .rn_Notification{margin:0px auto;}
.rn_AnswerNotificationManager .rn_Notification_Info{background:url(<?=FileSystem::getOptimizedAssetsDir();?>themes/standard/images/layout/whitePixel.png) 0 bottom scroll repeat-x;border-bottom:1px solid #DDD;color:#888;padding:0 4px 10px 0;}
.rn_AnswerNotificationManager .rn_Notification_Actions button{float:left;margin-top:4px;}
.rn_ProdCatNotificationManager{overflow:hidden;}
.rn_ProdCatNotificationManager .rn_Notification{overflow:auto;*overflow:none;padding:8px 0;width:80%;}
.rn_ProdCatNotificationManager .rn_Notification_Actions{float:right;width:34%;}
.rn_ProdCatNotificationManager .rn_Notification_Info{float:left;overflow:hidden;width:62%;}
.rn_ProdCatNotificationManager .rn_Notification_Info span{display:block;}
.rn_ProdCatNotificationManager{background:#F2FAFD;border:1px solid #DDD;margin:10px 0px 20px;padding:10px 4px 8px;}
.rn_ProdCatNotificationManager .rn_Loading{background:url(<?=FileSystem::getOptimizedAssetsDir();?>themes/standard/images/loading.gif) no-repeat center center;min-height:66px;height:auto !important;height:66px;}
.rn_ProdCatNotificationManager .rn_Notification{margin:0px auto;}
.rn_ProdCatNotificationManager .rn_Notification_Info{background:url(<?=FileSystem::getOptimizedAssetsDir();?>themes/standard/images/layout/whitePixel.png) 0 bottom scroll repeat-x;border-bottom:1px solid #DDD;color:#888;padding:0 4px 10px 0;}
.rn_ProdCatNotificationManager .rn_Notification_Actions button{float:left;margin-top:4px;}
.rn_ProdCatNotificationManager .rn_AddButton{display:block;margin:10px auto;}
.rn_ProdCatNotificationManager_Dialog{overflow:auto;}
.rn_ProdCatNotificationManager_Dialog .rn_SelectionWidget{float:left;margin:0 4px;width:48%;}
.rn_ProdCatNotificationManager_Dialog .rn_SelectionWidget button{margin-top:10px;}
.rn_ProductCategoryInput button.rn_DisplayButton{display:inline;background:none;color:#000;cursor:pointer;overflow:hidden;text-overflow:ellipsis;}
.rn_ProductCategoryInput .yui-overlay-hidden .rn_Panel table{*border-collapse:separate;}
.rn_ProductCategoryInput .ygtvrow{cursor:pointer;}
.rn_ProductCategoryInput .ygtvspacer{width:1em;display:block;}
.rn_ProductCategoryInput .ygtvlabel, .rn_ProductCategoryInput .ygtvlabel:link, .rn_ProductCategoryInput .ygtvlabel:visited, .rn_ProductCategoryInput .ygtvlabel:hover{font-size:inherit;}
.rn_ProductCategoryInput .rn_HintBox{z-index:1;}
.rn_ProductCategoryInput .rn_HintBox.rn_AlwaysVisibleHint{z-index:0;}
.rn_ProductCategoryInput .rn_PanelContainer .yui3-widget-hd{display: none;}
.rn_ProductCategoryInput{clear:both;margin-bottom:8px;}
.rn_ProductCategoryInput .rn_Label{display:block;font-weight:bold;margin-bottom:2px;width:36%;}
.rn_ProductCategoryInput .rn_RequiredLabel{display:block;font-style:italic;font-weight:normal;}
.rn_ProductCategoryInput button.rn_DisplayButton{background:#FFF url(<?=FileSystem::getOptimizedAssetsDir();?>themes/standard/images/splitButtonArrow.png) no-repeat scroll right center;border:1px solid #B1B1B1;font-weight:normal;margin-top:auto;min-height:1.5em;min-width:250px;padding:4px 20px 4px 4px;text-align:left;text-shadow:none;-moz-border-radius:0;-webkit-border-radius:0;border-radius:0;-moz-box-shadow:none;-webkit-box-shadow:none;box-shadow:none;}
.rn_ProductCategoryInput .rn_Panel{background:#FFF;border:1px solid #B1B1B1;max-height:200px;overflow:auto;padding:6px;_height:200px;}
.rn_ProductCategoryInput button.rn_DisplayButton:hover, .rn_ProductCategoryInput button.rn_DisplayButton:focus{background-color:#F8F8F8;}
.rn_ProductCategoryInput table{border-collapse:collapse;}
.ygtvlabel, .ygtvlabel:link, .ygtvlabel:visited, .ygtvlabel:hover{color:#111;}
.rn_ProductCategoryDisplay .rn_DataLabel{float:left;font-weight:bold;}
.rn_ProductCategoryDisplay .rn_DataValue{margin-left:180px;}
.rn_ProductCategoryDisplay .rn_DataValue ul{clear:none;}
.rn_ProductCategoryDisplay .rn_DataValue.rn_LeftJustify{clear:left;margin-left:0;padding-bottom:.5em;}
-->
</style>
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
<div id="rn_PageTitle" class="rn_Account">
    <h1><?=\RightNow\Utils\Config::msgGetFrom((4827));?></h1>
</div>
<div id="rn_PageContent">
    <div class="rn_Padding">
        <h2><?=\RightNow\Utils\Config::msgGetFrom((10700));?></h2>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/notifications/AnswerNotificationManager',
array());
?>
        <h2><?=\RightNow\Utils\Config::msgGetFrom((10750));?></h2>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/notifications/ProdCatNotificationManager',
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
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=\RightNow\Utils\Url::getCoreAssetPath('js/4.122/min/RightNow.js');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>templates<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/login/LogoutLink', 1 => 'standard/login/LoginDialog', ), '/standard.js', '1476968233');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => '/euf/core/3.2.6/js/4.122/min/widgetHelpers/EventProvider.js', 1 => '/euf/core/3.2.6/js/4.122/min/widgetHelpers/Field.js', 2 => '/euf/core/3.2.6/js/4.122/min/widgetHelpers/Form.js', 3 => 'standard/notifications/AnswerNotificationManager', 4 => 'standard/notifications/ProdCatNotificationManager', 5 => 'standard/input/ProductCategoryInput', ), '/account/notif/list.js', '1476968233');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'VALUE_MUST_BE_AN_INTEGER_MSG' => array ( 'value' => 4127, ), 'VALUE_IS_TOO_LARGE_MAX_VALUE_MSG' => array ( 'value' => 4125, ), 'VALUE_IS_TOO_SMALL_MIN_VALUE_MSG' => array ( 'value' => 4126, ), 'CONTAIN_1_CHARACTER_MSG' => array ( 'value' => 42414, ), 'PCT_D_CHARACTERS_MSG' => array ( 'value' => 2973, ), 'EXCEEDS_SZ_LIMIT_PCT_D_CHARS_1_LBL' => array ( 'value' => 42160, ), 'EXCEEDS_SZ_LIMIT_PCT_D_CHARS_PCT_D_LBL' => array ( 'value' => 1855, ), 'PCT_S_IS_AN_INVALID_POSTAL_CODE_MSG' => array ( 'value' => 3027, ), 'PCT_S_IS_AN_INVALID_PHONE_NUMBER_MSG' => array ( 'value' => 3026, ), 'PCT_S_CONT_SPACES_DOUBLE_QUOTES_LBL' => array ( 'value' => 41426, ), 'PCT_S_DIDNT_MATCH_EXPECTED_INPUT_LBL' => array ( 'value' => 3010, ), 'CONTAIN_SPACES_PLEASE_TRY_MSG' => array ( 'value' => 1344, ), 'PCT_S_IS_INVALID_MSG' => array ( 'value' => 3030, ), 'IS_NOT_A_VALID_URL_MSG' => array ( 'value' => 2246, ), 'FORMSUBMIT_PLACED_FORM_UNIQUE_ID_MSG' => array ( 'value' => 2021, ), 'PLS_VERIFY_REQ_ENTERING_TEXT_IMG_MSG' => array ( 'value' => 19038, ), 'SUBSCRIBED_ON_PCT_S_LBL' => array ( 'value' => 3846, ), 'NO_EXPIRATION_DATE_LBL' => array ( 'value' => 4977, ), 'CANCEL_CMD' => array ( 'value' => 849, ), 'SELECTION_PCT_S_ACTIVATE_LINK_JUMP_MSG' => array ( 'value' => 3544, ), 'PCT_S_LNKS_DEPTH_ANNOUNCED_MSG' => array ( 'value' => 3036, ), 'FIELD_REQUIRED_MARK_LBL' => array ( 'value' => 1908, ), 'REQUIRED_LBL' => array ( 'value' => 7015, ), 'PCT_S_MUST_NOT_CONTAIN_SPACES_MSG' => array ( 'value' => 3042, ), 'USERNAME_LBL' => array ( 'value' => 4846, ), 'PCT_S_CONTAIN_DOUBLE_QUOTES_MSG' => array ( 'value' => 3005, ), 'PCT_S_CNT_THAN_MSG' => array ( 'value' => 3002, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
