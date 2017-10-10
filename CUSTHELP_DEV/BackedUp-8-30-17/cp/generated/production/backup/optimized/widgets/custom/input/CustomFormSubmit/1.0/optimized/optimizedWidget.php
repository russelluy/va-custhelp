<? namespace Custom\Widgets\input;
\RightNow\Utils\Widgets::requireOptimizedWidgetController("standard/input/FormSubmit");
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
