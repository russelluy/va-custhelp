<? namespace Custom\Widgets\display;
class CustomInfoButton extends \RightNow\Libraries\Widget\Base {
function _custom_display_CustomInfoButton_view ($data) {
extract($data);
?><div id="rn_<?= $this->instanceID ?>" class="rn_InfoButton <?= $this->classList ?>">
    <? if ($this->data['attrs']['icon_path']):?>
        <input type="image" class="rn_SubmitImage" 
                id="rn_<?=$this->instanceID;?>_SubmitButton" 
                name="rn_<?=$this->instanceID;?>_SubmitButton" 
        		<?=tabindex($this->data['attrs']['tabindex'],
1);?>	src="<?=$this->data['attrs']['icon_path'];?>" 
        		alt="<?=$this->data['attrs']['icon_alt_text'];?>" 
        		title="<?=$this->data['attrs']['label_button'];?>"
                value=""/>
    <?
else:?>
        <input type="submit" class="rn_InfoButton"
                id="rn_<?=$this->instanceID;?>_SubmitButton" 
                name="rn_<?=$this->instanceID;?>_SubmitButton" 
        		<?=tabindex($this->data['attrs']['tabindex'],
1);?> alt="<?=$this->data['attrs']['icon_alt_text'];?>" 
                title="<?=$this->data['attrs']['label_button'];?>"
                value=""/>
    <?
endif;?>
    <?
if($this->data['isIE']): ?>
    	<label for="rn_<?=$this->instanceID;?>_HiddenInput" class="rn_Hidden">&nbsp;</label>
		<input id="rn_<?=$this->instanceID;?>_HiddenInput" name="rn_<?=$this->instanceID;?>_HiddenInput" type="text" class="rn_Hidden" disabled="disabled" value=""/>
    <?
endif;?>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if($this->CI->agent->browser() === 'Internet Explorer') $this->data['isIE'] = true;
return parent::getData();
}
}
function _custom_display_CustomInfoButton_header() {
$result = array( 'js_name' => 'Custom.Widgets.display.CustomInfoButton', 'library_name' => 'CustomInfoButton', 'view_func_name' => '_custom_display_CustomInfoButton_view', 'meta' => array ( 'controller_path' => 'custom/display/CustomInfoButton', 'view_path' => 'custom/display/CustomInfoButton', 'js_path' => 'custom/display/CustomInfoButton', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/CustomInfoButton.css', ), 'base_css' => array ( 0 => 'custom/display/CustomInfoButton/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'relativePath' => 'custom/display/CustomInfoButton', 'widget_name' => 'CustomInfoButton', ), );
$result['meta']['attributes'] = array( 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'is_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'target' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'new_window' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'icon_alt_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'popup_window' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'boolean', 'default' => true, 'inherited' => false, )), 'popup_window_width_percent' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 30, 'type' => 'int', 'default' => 30, 'inherited' => false, )), 'popup_window_height_percent' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 42, 'type' => 'string', 'default' => 42, 'inherited' => false, )), );
return $result;
}
