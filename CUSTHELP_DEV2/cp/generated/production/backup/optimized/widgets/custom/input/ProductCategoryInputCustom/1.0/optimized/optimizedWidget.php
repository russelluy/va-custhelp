<? namespace Custom\Widgets\input;
\RightNow\Utils\Widgets::requireOptimizedWidgetController("standard/output/ProductCategoryDisplay");
use RightNow\Utils\Url, RightNow\Utils\Text;
class ProductCategoryInputCustom extends \RightNow\Libraries\Widget\Input {
function _custom_input_ProductCategoryInputCustom_view ($data) {
extract($data);
?><?php ?>
<? if($this->data['js']['readOnly']):?>
<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/ProductCategoryDisplay', array('name' => '' . 'Incident.' . $this->data['attrs']['data_type'] . '','label' => '' . $this->data['attrs']['label_input'] . '','left_justify' => 'true',));
?>
<? else:?>
<div id="rn_<?=$this->instanceID;?>" class="<?=
$this->classList ?>">
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
function _custom_input_ProductCategoryInputCustom_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.ProductCategoryInputCustom', 'library_name' => 'ProductCategoryInputCustom', 'view_func_name' => '_custom_input_ProductCategoryInputCustom_view', 'meta' => array ( 'controller_path' => 'custom/input/ProductCategoryInputCustom', 'view_path' => 'custom/input/ProductCategoryInputCustom', 'js_path' => 'custom/input/ProductCategoryInputCustom', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ProductCategoryInputCustom.css', ), 'base_css' => array ( 0 => 'custom/input/ProductCategoryInputCustom/base.css', ), 'js_templates' => array ( 'label' => '<%= label %><% if(requiredLevel) { %><span class="rn_Required"> <%= requiredMarkLabel %></span><span id="rn_<%= instanceID %>_RequiredLabel" class="rn_RequiredLabel"> <span class="rn_ScreenReaderOnly"> <%= requiredLabel %> </span></span><% } %>', ), 'template_path' => 'custom/input/ProductCategoryInputCustom', 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', ), 'yui' => array ( 0 => 'panel', 1 => 'gallery-treeview', ), ), 'info' => array ( 'description' => 'rn:msg:(42107)', 'urlParameters' => array ( 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), 'Incident.Product' => array ( 'name' => 'rn:msg:(4594)', 'description' => 'rn:msg:(41957)', 'example' => 'Incident.Product/1,2,3', ), 'Incident.Category' => array ( 'name' => 'rn:msg:(4574)', 'description' => 'rn:msg:(41956)', 'example' => 'Incident.Category/1', ), ), ), 'contains' => array ( 0 => array ( 'widget' => 'standard/output/ProductCategoryDisplay', 'versions' => array ( 0 => '1.0', 1 => '1.1', ), ), ), 'relativePath' => 'custom/input/ProductCategoryInputCustom', 'widget_name' => 'ProductCategoryInputCustom', ), );
$result['meta']['attributes'] = array( 'default_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_all_values' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(843), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(843), 'inherited' => false, )), 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4594), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4594), 'inherited' => false, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_set_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4623), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4623), 'inherited' => false, )), 'label_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3154), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3154), 'inherited' => false, )), 'label_confirm_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(864), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(864), 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(849), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(849), 'inherited' => false, )), 'label_nothing_selected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3532), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3532), 'inherited' => false, )), 'label_accessible_interface' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1100), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1100), 'inherited' => false, )), 'label_screen_reader_selected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4133), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4133), 'inherited' => false, )), 'label_screen_reader_accessible_option' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3491), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3491), 'inherited' => false, )), 'label_level' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(8667), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(8667), 'inherited' => false, )), 'data_type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'Product', 'type' => 'OPTION', 'default' => 'Product', 'options' => array(0 => 'Product', 1 => 'Category', 2 => 'Products', 3 => 'Categories', ), 'inherited' => false, )), 'required_lvl' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'max' => 6, 'inherited' => false, )), 'max_lvl' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 6, 'type' => 'INT', 'default' => 6, 'min' => 1, 'max' => 6, 'inherited' => false, )), 'linking_off' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'set_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'allow_external_login_updates' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'treeview_css' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Url::getYUICodePath('gallery-treeview/assets/treeview-menu.css'), 'type' => 'STRING', 'default' => \RightNow\Utils\Url::getYUICodePath('gallery-treeview/assets/treeview-menu.css'), 'inherited' => false, )), 'show_confirm_button_in_dialog' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'always_show_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
