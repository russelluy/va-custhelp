<? namespace Custom\Widgets\util;
class CustomInfoButton extends \RightNow\Libraries\Widget\Base {
function _custom_util_CustomInfoButton_view ($data) {
extract($data);
?><?php  ?>



<div id="rn_<?=$this->instanceID;?>" class="rn_InfoButton">
    <?
if ($this->data['attrs']['icon_path']):?>
        <input type="image" class="rn_SubmitImage" id="rn_<?=$this->instanceID;?>_SubmitButton" <?=tabindex($this->data['attrs']['tabindex'],
1);?> src="<?=$this->data['attrs']['icon_path'];?>" alt="<?=$this->data['attrs']['icon_alt_text'];?>" title="<?=$this->data['attrs']['label_button'];?>"/>
    <?
else:?>
        <input type="submit" class="rn_InfoButton" id="rn_<?=$this->instanceID;?>_SubmitButton" <?=tabindex($this->data['attrs']['tabindex'],
1);?> value="<?=$this->data['attrs']['label_button'];?>" />
    <?
endif;?>
    <?
if($this->data['isIE']): ?>
    <label for="rn_<?=$this->instanceID;?>_HiddenInput" class="rn_Hidden">&nbsp;</label>
    <input id="rn_<?=$this->instanceID;?>_HiddenInput" type="text" class="rn_Hidden" disabled="disabled" />
    <?
endif;?>
</div>

<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function generateWidgetInformation() {
$this->info['notes'] = getMessage((4253));
}
function getData() {
if($this->CI->agent->browser() === 'Internet Explorer') $this->data['isIE'] = true;
}
}
function _custom_util_CustomInfoButton_header() {
$result = array( 'js_name' => 'Custom.Widgets.util.CustomInfoButton', 'library_name' => 'CustomInfoButton', 'view_func_name' => '_custom_util_CustomInfoButton_view', 'meta' => array ( 'controller_path' => 'custom/util/CustomInfoButton', 'view_path' => 'custom/util/CustomInfoButton', 'js_path' => 'custom/util/CustomInfoButton', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/CustomInfoButton.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'relativePath' => 'custom/util/CustomInfoButton', 'widget_name' => 'CustomInfoButton', ), );
$result['meta']['attributes'] = array( 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4693), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4693), 'inherited' => false, )), 'target' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'is_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOL', 'default' => true, 'inherited' => false, )), 'new_window' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOL', 'default' => true, 'inherited' => false, )), 'icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'icon_alt_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4693), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4693), 'inherited' => false, )), 'popup_window' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOL', 'default' => false, 'inherited' => false, )), 'popup_window_width_percent' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 30, 'type' => 'INT', 'default' => 30, 'inherited' => false, )), 'popup_window_height_percent' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 42, 'type' => 'INT', 'default' => 42, 'inherited' => false, )), );
return $result;
}
