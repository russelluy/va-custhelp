<? namespace Custom\Widgets\input;
\RightNow\Utils\Widgets::requireOptimizedWidgetController("standard/input/TextInput");
\RightNow\Utils\Widgets::requireOptimizedWidgetController("standard/output/FieldDisplay");
class CustomTextInput extends \RightNow\Widgets\TextInput {
function _custom_input_CustomTextInput_view ($data) {
extract($data);
?><? if ($this->data['readOnly']): ?>
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
