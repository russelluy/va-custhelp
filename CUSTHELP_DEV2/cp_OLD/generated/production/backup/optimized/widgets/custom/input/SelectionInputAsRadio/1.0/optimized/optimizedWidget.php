<? namespace Custom\Widgets\input;
\RightNow\Utils\Widgets::requireOptimizedWidgetController("standard/input/SelectionInput");
\RightNow\Utils\Widgets::requireOptimizedWidgetController("standard/output/FieldDisplay");
class SelectionInputAsRadio extends \RightNow\Widgets\SelectionInput {
function _custom_input_SelectionInputAsRadio_view ($data) {
extract($data);
?><? if ($this->data['readOnly']): ?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/FieldDisplay', array('left_justify' => 'true',));
?>
<? else: ?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<? if (1===2) {
?>
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
<? }
else {
<? if ($this->data['displayType'] === 'Select'): ?> <!-- Note: because menu custom fields always show in drop downs, this is the place we have replaced the <options> with radios -->
			
			<? if (!$this->data['attrs']['display_as_checkbox']): ?> <!-- Display as radio buttons -->
				<? $this->data['displayType'] = 'Radio';
?>
			    <? if (is_array($this->data['menuItems'])): $instanceName = "rn_{$this->instanceID}_Radio";
$inputNameRadio = "{$this->data['inputName']}_Radio";
$cVar = substr(strrchr($this->data['js']['name'], "."), 1);
$hiddenName = "rn_{$this->instanceID}_{$cVar}";
?>
			        	<input type="hidden" id="<?= $hiddenName ?>"/>
				        <div style="vertical-align:middle;padding-top:5px;float:left;">
							<? $i = 0;
foreach ($this->data['menuItems'] as $key => $item): $id = "rn_{$this->instanceID}_{$cVar}_{$key}";
$radioValue = "{$cVar}_{$key}";
?>
				        			<input type="radio" name="<?= $inputNameRadio ?>" id="<?= $id ?>" <?= $this->outputChecked($i) ?> value="<?= $key ?>"/>
				        			
						            <label for="<?= $id ?>" style="display:inline; margin-left:5px;">
							            <?= trim($item) ?>
							            <? if ($this->data['attrs']['hint'] && $i === 1): ?>
							                <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
							            <? endif;
?>
						            </label>
							        <br />
						            <? $i++;
?>
						        <? endforeach;
?>
						        <input type="hidden" name="<?= $this->data['inputName']?>" id="rn_<?= $hiddenName ?>" value="">
				        </div>
			    <? endif;
?>
		
		    <? else: ?> <! -- Display as a checkbox selection -->
		    	<? $this->data['displayType'] = 'Checkbox';
?>
		    		    <? if (is_array($this->data['menuItems'])): $instanceName = "rn_{$this->instanceID}_Checkbox";
$cVar = substr(strrchr($this->data['js']['name'], "."), 1);
$hiddenName = "rn_{$this->instanceID}_{$cVar}";
?>
			        	<input type="hidden" id="<?= $hiddenName ?>"/>
				        <div style="vertical-align:middle;padding-top:5px;float:left;">
							<? $i = 0;
foreach ($this->data['menuItems'] as $key => $item): $id = "rn_{$this->instanceID}_{$cVar}_{$key}";
?>
						            <input type="checkbox" id="<?= $id ?>" name="<?= $instanceName ?>" <?= $this->outputChecked(1) ?> value="1"/>
						            <label for="<?= $id ?>" style="display:inline; margin-left:5px;">
							            <?= trim($item) ?>
							            <? if ($this->data['attrs']['hint'] && $i === 1): ?>
							                <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
							            <? endif;
?>
						            </label>
							        <br />
						            <? $i++;
?>
						        <? endforeach;
?>
				        </div>
			    <? endif;
?>
				<br>
			<? endif;
?>
		<? endif;
?>	
		<br />	
	<? }
?>
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
function _custom_input_SelectionInputAsRadio_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.SelectionInputAsRadio', 'library_name' => 'SelectionInputAsRadio', 'view_func_name' => '_custom_input_SelectionInputAsRadio_view', 'meta' => array ( 'controller_path' => 'custom/input/SelectionInputAsRadio', 'view_path' => 'custom/input/SelectionInputAsRadio', 'js_path' => 'custom/input/SelectionInputAsRadio', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/SelectionInputAsRadio.css', ), 'base_css' => array ( 0 => 'custom/input/SelectionInputAsRadio/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/input/SelectionInput', 'components' => array ( 'php' => true, 'view' => true, 'js' => true, ), ), 'relativePath' => 'custom/input/SelectionInputAsRadio', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/SelectionInput', ), 'view' => array ( 0 => 'standard/input/SelectionInput', ), 'logic' => array ( 0 => 'standard/input/SelectionInput', ), 'js_templates' => array ( 0 => array ( 'label' => '<% if (label) { %> <rn:block id="preLabel"/> <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %> <rn:block id="preRequired"/> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <rn:block id="postRequired"/> <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <rn:block id="postLabel"/><% } %>', 'legend' => '<% if (label) { %> <rn:block id="preLabel"/> <%= label %> <% if (required) { %> <rn:block id="preRequired"/> <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span> <rn:block id="postRequired"/> <% } %> <rn:block id="postLabel"/><% } %>', ), ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/input/SelectionInput', ), 'widget_name' => 'SelectionInputAsRadio', 'extends_php' => array ( 0 => 'standard/input/SelectionInput', ), 'extends_js' => array ( 0 => 'standard/input/SelectionInput', ), 'extends_view' => array ( 0 => 'standard/input/SelectionInput', ), 'parent' => 'standard/input/SelectionInput', 'js_templates' => array ( 'label' => '<% if (label) { %>  <label for="rn_<%= instanceID %>_<%= fieldName %>" id="rn_<%= instanceID %>_Label" class="rn_Label"> <%= label %> <% if (required) { %>  <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% if (hint) { %> <span class="rn_ScreenReaderOnly"><%= hint %></span> <% } %> </label> <% } %>', 'legend' => '<% if (label) { %>  <%= label %> <% if (required) { %>  <span class="rn_Required"><%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span>  <% } %> <% } %>', ), ), );
$result['meta']['attributes'] = array( 'always_show' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'string', 'default' => '{default_label}', 'inherited' => true, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3033), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3033), 'inherited' => true, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => true, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'validate_on_blur' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => true, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hide_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'display_as_checkbox' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), );
return $result;
}
