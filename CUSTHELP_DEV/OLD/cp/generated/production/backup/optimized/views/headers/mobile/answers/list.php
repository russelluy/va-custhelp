<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/mobile', 1 => '/euf/assets/themes/mobile', 2 => array ( '/euf/assets/themes/mobile' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile', ), ));
get_instance()->_checkMeta(array('javascript_module'=>'mobile_may_10', 'title'=>'' . \RightNow\Utils\Config::msgGetFrom((4527)) . '', 'template'=>'mobile.php', 'clickstream'=>'answer_list'));
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
namespace RightNow\Widgets{
class Accordion extends \RightNow\Libraries\Widget\Base {
function _standard_navigation_Accordion_view ($data) {
extract($data);
?><? }
}
function _standard_navigation_Accordion_header() {
$result = array( 'js_name' => 'RightNow.Widgets.Accordion', 'library_name' => 'Accordion', 'view_func_name' => '_standard_navigation_Accordion_view', 'meta' => array ( 'controller_path' => 'standard/navigation/Accordion', 'view_path' => '', 'js_path' => 'standard/navigation/Accordion', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4338)', ), 'relativePath' => 'standard/navigation/Accordion', 'widget_name' => 'Accordion', ), );
$result['meta']['attributes'] = array( 'toggle' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'item_to_toggle' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'expanded_css_class' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'rn_Expanded', 'type' => 'STRING', 'default' => 'rn_Expanded', 'inherited' => false, )), 'collapsed_css_class' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'rn_Collapsed', 'type' => 'STRING', 'default' => 'rn_Collapsed', 'inherited' => false, )), 'label_collapsed' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3522), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3522), 'inherited' => false, )), 'label_expanded' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3523), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3523), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Text;
class MobileProductCategorySearchFilter extends \RightNow\Libraries\Widget\Base {
function _standard_search_MobileProductCategorySearchFilter_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <? $i = 1;
$id = "rn_{$this->instanceID}_{$this->data['attrs']['filter_type']}";
?>
     <form id="<?=$id;?>_Level1Input" class="rn_Hidden rn_Input rn_MobileProductCategorySearchFilter rn_Level1" onsubmit="return false;">
    <?
foreach ($this->data['firstLevel'] as $item): ?>
        <div class="rn_Parent <?=$item['selected'] ? 'rn_Selected' : '';?>">
            <input type="radio" name="<?=$id;?>_Level1" id="<?=$id;?>_Input1_<?=$i?>" value="<?=$item['id'];?>"/>
            <?
$class = ($item['hasChildren']) ? 'rn_HasChildren' : '';?>
            <label class="<?=$class;?>" id="<?=$id;?>_Label1_<?=$i?>" for="<?=$id;?>_Input1_<?=$i;?>"><?=htmlspecialchars($item['label'],
ENT_QUOTES, 'UTF-8');?>
            <?
if ($item['hasChildren']): ?><span class="rn_ParentMenuAlt"> <?=$this->data['attrs']['label_parent_menu_alt']?></span><? endif;
?>
            </label>
        </div>
    <? $i++;
endforeach;
?>
    </form>
    <? $filtersToDisplay = count($this->data['js']['initial']);
?>
    <div id="<?=$id;?>_FilterDisplay" class="rn_FilterDisplay">
        <div class="rn_Heading">
            <a id="<?=$id;?>_Launch" href="javascript:void(0);" class="rn_Opener rn_LinkOpener"><?=$this->data['attrs']['label_input'];?></a>
            <a href="javascript:void(0);" id="<?=$id;?>_FilterRemove" class="rn_Remove <?=($filtersToDisplay)?
'' : 'rn_Hidden';?>">
                <?
if ($this->data['attrs']['remove_icon_path']): ?>
                <img src="<?=$this->data['attrs']['remove_icon_path'];?>" alt="<?=$this->data['attrs']['label_filter_remove'];?>"/>
                <?
else: ?>
                <?=$this->data['attrs']['label_filter_remove'];?>
                <?
endif;
?>
            </a>
        </div>
        <div id="<?=$id;?>_Filters" class="rn_Filters">
        <?
if ($filtersToDisplay): ?>
        <? foreach ($this->data['js']['initial'] as $index => $value): ?>
            <? $class = ($index === count($this->data['js']['initial']) - 1) ? 'rn_Selected' : '';?>
            <a href="<?=(!$class)?
$this->data['js']['searchPage'] . $this->data['js']['searchName'] . '/' . $value['id'] : 'javascript:void(0);'?>" class="rn_FilterItem <?=$class;?>" id="<?=$id;?>_Filter<?=$value['id']?>"><?=htmlspecialchars($value['label'],
ENT_QUOTES, 'UTF-8');?></a>
        <?
endforeach;
?>
        <? endif;
?>
        </div>
    </div>
</div>
<? }
const PRODUCT = 'Product';
const CATEGORY = 'Category';
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['attrs']['filter_type'] = (Text::stringContains(strtolower($this->data['attrs']['filter_type']), 'prod')) ? self::PRODUCT : self::CATEGORY;
if ($this->data['attrs']['filter_type'] === self::CATEGORY) {
$this->data['attrs']['label_all_values'] = ($this->data['attrs']['label_all_values'] === \RightNow\Utils\Config::getMessage((843))) ? \RightNow\Utils\Config::getMessage((842)) : $this->data['attrs']['label_all_values'];
$this->data['attrs']['label_input'] = ($this->data['attrs']['label_input'] === \RightNow\Utils\Config::getMessage((2562)) . ' &raquo;') ? \RightNow\Utils\Config::getMessage((2561)) . ' &raquo;' : $this->data['attrs']['label_input'];
$this->data['attrs']['label_prompt'] = ($this->data['attrs']['label_prompt'] === \RightNow\Utils\Config::getMessage((3532))) ? \RightNow\Utils\Config::getMessage((3529)) : $this->data['attrs']['label_prompt'];
$this->data['attrs']['label_filter_type'] = ($this->data['attrs']['label_filter_type'] === \RightNow\Utils\Config::getMessage((4623))) ? \RightNow\Utils\Config::getMessage((4617)) : $this->data['attrs']['label_filter_type'];
}
$filters = array();
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$filterType = strtolower($this->data['attrs']['filter_type'][0]);
$defaultValue = $filters[$filterType]->filters->data[0];
$defaultValue = ($defaultValue) ? explode(',', $defaultValue) : array();
$optlistID = $filters[$filterType]->filters->optlist_id;
if(!$optlistID) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((1955)), $this->data['attrs']['filter_type'], $this->data['attrs']['report_id']));
return false;
}
$this->data['js'] = array( 'name' => $filters[$filterType]->filters->name, 'oper_id' => $filters[$filterType]->filters->oper_id, 'fltr_id' => $filters[$filterType]->filters->fltr_id, 'linkingOn' => $this->data['attrs']['linking_off'] ? 0 : $this->CI->model('Prodcat')->getLinkingMode(), 'report_def' => $filters[$filterType]->report_default, 'searchName' => $filterType, 'hm_type' => $filterType === 'p' ? (13) : (14), 'searchPage' => $this->data['attrs']['report_page_url'] ? $this->data['attrs']['report_page_url'] . '/' : "/app/{$this->CI->page}/"
);
if($filterType === 'c' && $this->data['js']['linkingOn']) $selectedProds = ($filters['p']) ? explode(',', $filters['p']->filters->data[0]) : null;
$this->data['firstLevel'] = array();
$defaultSelection = ($selectedProds[0]) ? $this->_setProdLinkingDefaults($this->data['firstLevel'], $selectedProds, $defaultValue) : $this->_setDefaults($this->data['firstLevel'], $defaultValue);
if($defaultSelection) {
$this->data['js']['initial'] = $defaultSelection;
}
if(empty($this->data['firstLevel'])) {
if($this->data['js']['linkingOn'] && $filterType === 'c') {
$this->classList->add('rn_HideEmpty');
}
else {
return false;
}
}
}
protected function _setDefaults(&$firstLevelItems, $hierItems) {
$selection = array();
$model = $this->CI->model('Prodcat');
if ($hierItems) {
$lastItem = end($hierItems);
if (!$selection = $model->getFormattedChain($this->data['attrs']['filter_type'], $lastItem)->result) {
return false;
}
}
if (!$firstLevelItems = $model->getDirectDescendants($this->data['attrs']['filter_type'])->result) {
return false;
}
if ($selection) {
$firstLevelSelectedItem = $selection[0]['id'];
foreach ($firstLevelItems as &$item) {
if ($item['id'] == $firstLevelSelectedItem) {
$item['selected'] = true;
break;
}
}
}
array_unshift($firstLevelItems, array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
return $selection;
}
protected function _setProdLinkingDefaults(&$firstLevelItems, $productArray, $catArray) {
$productArray = array_filter($productArray);
$lastProdID = end($productArray);
$selection = array();
$hierList = '';
if (!($lastProdId = end($productArray)) || !($hierArray = $this->CI->model('Prodcat')->getLinkedCategories($lastProdId)->result)) return false;
ksort($hierArray);
$matchIndex = 0;
foreach($hierArray as $parentID => $child) {
if(!count($child)) {
unset($hierArray[$parentID]);
continue;
}
foreach($child as $dataArray) {
$id = $dataArray['id'];
if($id === intval($catArray[$matchIndex])) {
$selected = true;
$matchIndex++;
$hierList .= $id;
$selection []= $dataArray + array('hierList' => $hierList);
$hierList .= ',';
}
else {
$selected = false;
}
if($parentID === 0) {
$firstLevelItems []= $dataArray + array('selected' => $selected);
}
}
}
array_unshift($firstLevelItems, array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
$this->data['js']['linkMap'] = $hierArray;
return $selection;
}
}
function _standard_search_MobileProductCategorySearchFilter_header() {
$result = array( 'js_name' => 'RightNow.Widgets.MobileProductCategorySearchFilter', 'library_name' => 'MobileProductCategorySearchFilter', 'view_func_name' => '_standard_search_MobileProductCategorySearchFilter_view', 'meta' => array ( 'controller_path' => 'standard/search/MobileProductCategorySearchFilter', 'view_path' => 'standard/search/MobileProductCategorySearchFilter', 'js_path' => 'standard/search/MobileProductCategorySearchFilter', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/MobileProductCategorySearchFilter.css', ), 'base_css' => array ( 0 => 'standard/search/MobileProductCategorySearchFilter/base.css', ), 'js_templates' => array ( 'view' => '<form id="<%= inputID %>" class="rn_Input rn_MobileProductCategorySearchFilter rn_Level<%= level %>" onsubmit="return false;"> <% for (var i = 0, divClass, labelClass; i < data.length; i++) { %> <% divClass = ((i === 0) ? "rn_Parent" : "rn_SubItem") + ((data[i].id === alreadySelected) ? " rn_Selected" : ""); %> <div class="<%= divClass %>"> <input type="radio" id="<%= inputID %>_<%= (i + 1) %>" value="<%= data[i].id %>"/> <% labelClass = (data[i].hasChildren) ? "rn_HasChildren" : ""; %> <label class="<%= labelClass %>" id="<%= labelID %>_<%= (i + 1) %>" for="<%= inputID %>_<%= (i + 1) %>"><%= escapeHtml(data[i].label) %> <% if (labelClass === "rn_HasChildren") { %><span class="rn_ParentMenuAlt"> <%= parentAlt %></span><% } %> </label> </div><% } %> </form>', ), 'template_path' => 'standard/search/MobileProductCategorySearchFilter', 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4310)', 'urlParameters' => array ( 'p' => array ( 'name' => 'rn:msg:(4594)', 'description' => 'rn:msg:(1223)', 'example' => 'p/1,2,3', ), 'c' => array ( 'name' => 'rn:msg:(4574)', 'description' => 'rn:msg:(1247)', 'example' => 'c/1', ), ), ), 'relativePath' => 'standard/search/MobileProductCategorySearchFilter', 'widget_name' => 'MobileProductCategorySearchFilter', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'min' => 0, 'inherited' => false, )), 'filter_type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'Product', 'type' => 'OPTION', 'default' => 'Product', 'options' => array(0 => 'products', 1 => 'categories', 2 => 'Product', 3 => 'Category', ), 'inherited' => false, )), 'linking_off' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((2562)) . ' &raquo;', 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((2562)) . ' &raquo;', 'inherited' => false, )), 'label_filter_type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4623), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4623), 'inherited' => false, )), 'label_prompt' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3532), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3532), 'inherited' => false, )), 'label_parent_menu_alt' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(29091), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(29091), 'inherited' => false, )), 'label_all_values' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(843), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(843), 'inherited' => false, )), 'remove_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/x.png', 'type' => 'filepath', 'default' => 'images/x.png', 'inherited' => false, )), 'label_filter_remove' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(6896), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(6896), 'inherited' => false, )), 'search_on_select' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ResultInfo extends \RightNow\Libraries\Widget\Base {
function _standard_reports_ResultInfo_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <? ?>
    <div id="rn_<?=$this->instanceID;?>_Suggestion" class="rn_Suggestion <?=$this->data['suggestionClass'];?>">
        <?=$this->data['attrs']['label_suggestion'];?>
        <?
for($i = 0;
$i < count($this->data['suggestionData']);
$i++): ?>
            <a href="<?=$this->data['js']['linkUrl'].$this->data['suggestionData'][$i].'/suggested/1'.$this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['suggestionData'][$i]?></a>&nbsp;
        <?
endfor;?>
    </div>
    <?
?>
    <div id="rn_<?=$this->instanceID;?>_Spell" class="rn_Spell <?=$this->data['spellClass'];?>">
        <?=$this->data['attrs']['label_spell'];?>
        <?if($this->data['spellData']):?>
        <a href="<?=$this->data['js']['linkUrl'].$this->data['spellData'].'/dym/1'.$this->data['appendedParameters'].
\RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['spellData'];?></a>
        <?endif;?>
    </div>
    <?
?>
    <div id="rn_<?=$this->instanceID;?>_NoResults" class="rn_NoResults <?=$this->data['noResultsClass'];?>">
        <?=$this->data['attrs']['label_no_results'];?>
        <br/><br/>
        <?=$this->data['attrs']['label_no_results_suggestions'];?>
    </div>
    <?
?>
    <? if($this->data['attrs']['display_results']):?>
    <div id="rn_<?=$this->instanceID;?>_Results" class="rn_Results <?=$this->data['resultClass'];?>">
    <?
if($this->data['searchQuery']):?>
        <? $query = '';
foreach($this->data['searchQuery'] as $searchTerm):?>
            <? if($searchTerm['stop']):?>
                <? $query .= "<span class='rn_Strike' title='{$this->data['attrs']['label_common']}'>{$searchTerm['word']}</span> ";?>
            <?
elseif($searchTerm['notFound']):?>
                <? $query .= "<span class='rn_Strike' title='{$this->data['attrs']['label_dictionary']}'>{$searchTerm['word']}</span> ";?>
            <?
else:?>
            <? $query .= '<a href="'.$this->data['js']['linkUrl'].$searchTerm['url'].$this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter()."\">{$searchTerm['word']}</a> ";?>
            <?
endif;?>
        <?
endforeach;?>
        <?
printf($this->data['attrs']['label_results_search_query'], $this->data['firstResult'], $this->data['lastResult'], $this->data['totalResults'], $query);?>
    <?
else:?>
        <? printf($this->data['attrs']['label_results'], $this->data['firstResult'], $this->data['lastResult'], $this->data['totalResults']);?>
    <?
endif;?>
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
if($this->data['attrs']['add_params_to_url']) {
$appendedParameters = explode(',', trim($this->data['attrs']['add_params_to_url']));
foreach($appendedParameters as $key => $parameter) {
if(trim($parameter) === 'kw') {
unset($appendedParameters[$key]);
break;
}
}
$this->data['attrs']['add_params_to_url'] = (count($appendedParameters)) ? implode(',', $appendedParameters) : '';
$this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']);
}
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$reportToken = \RightNow\Utils\Framework::createToken($this->data['attrs']['report_id']);
if($this->data['attrs']['combined_results']) {
$format['hiddenColumns'] = true;
}
$results = $this->CI->model('Report')->getDataHTML($this->data['attrs']['report_id'], $reportToken, $filters, $format)->result;
$this->data['suggestionClass'] = $this->data['spellClass'] = $this->data['noResultsClass'] = $this->data['resultClass'] = 'rn_Hidden';
if(count($results['ss_data'])) {
$this->data['suggestionClass'] = '';
$this->data['suggestionData'] = $results['ss_data'];
}
if($results['spelling']) {
$this->data['spellClass'] = '';
$this->data['spellData'] = $results['spelling'];
}
if($results['total_num'] === 0 && $results['search_term'] !== '' && !$results['topics']) {
$this->data['noResultsClass'] = '';
}
else if(!$results['truncated']) {
$this->data['resultClass'] = '';
$this->data['firstResult'] = $results['start_num'];
$this->data['lastResult'] = $results['end_num'];
$this->data['totalResults'] = $results['total_num'];
}
if(!$this->data['attrs']['combined_results'] && $results['search_term'] !== null && $results['search_term'] !== '' && $results['search_term'] !== false) {
$stopWords = $results['stopword'];
$noDictWords = $results['not_dict'];
$searchTerms = explode(' ', $results['search_term']);
$this->data['searchQuery'] = array();
foreach($searchTerms as $word) {
$strippedWord = preg_replace('/\W/', '', $word);
if($stopWords && $strippedWord && strstr($stopWords, $strippedWord) !== false) $type = 'stop';
else if($noDictWords && $strippedWord && strstr($noDictWords, $strippedWord) !== false) $type = 'notFound';
else $type = 'normal';
$word = htmlspecialchars($word, ENT_QUOTES, 'UTF-8', false);
array_push($this->data['searchQuery'], array('word' => $word, 'url' => urlencode(str_replace('&amp;', '&', $word)) . '/search/1', $type => true));
}
}
if(substr_count($this->data['attrs']['label_results'], '%d') > 3) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((2995)), 'label_results'));
return false;
}
else if(substr_count($this->data['attrs']['label_results_search_query'], '%d') > 3) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((2995)), 'label_results_search_query'));
return false;
}
if($this->data['attrs']['combined_results']) {
if(!$this->data['attrs']['display_knowledgebase_results']) {
$this->data['resultClass'] = 'rn_Hidden';
$this->data['noResultsClass'] = '';
$results['total_num'] = $this->data['firstResult'] = $this->data['lastResult'] = $this->data['totalResults'] = 0;
}
$searchSocial = (\RightNow\Utils\Framework::inArrayCaseInsensitive(array('all', 'social'), $this->data['attrs']['combined_results']) && \RightNow\Utils\Config::getConfig((701), 'RNW'));
$combinedResults = ($searchSocial ? $this->addCommunityResults($filters['keyword']->filters->data) : 0);
}
$this->data['js'] = array( 'linkUrl' => "/app/{$this->CI->page}/search/1/kw/",
'totalResults' => $this->data['totalResults'] ?: 0, 'lastResult' => $this->data['lastResult'] ?: 0, 'firstResult' => $this->data['firstResult'] ?: 0, 'searchTerm' => $filters['keyword']->filters->data, 'combinedResults' => $combinedResults ?: 0, 'prunedAnswers' => $prunedAnswers, 'social' => $searchSocial, 'error' => $results['error'], );
}
protected function addCommunityResults($keyword) {
$socialResults = $this->CI->model('Social')->request('performSearch', $keyword, 20, null, $this->data['attrs']['social_resource_id'], null, null)->getResponse()->result;
return $this->addCombinedResults($this->data, $filters['page'], $socialResults->totalCount);
}
protected function addCombinedResults(array &$data, $page, $numberOfAdditionalResults) {
if($numberOfAdditionalResults) {
$numberOfAdditionalResults = ($numberOfAdditionalResults > 20 ? 20 : $numberOfAdditionalResults);
$data['totalResults'] += $numberOfAdditionalResults;
if(!$data['noResultsClass'] && $numberOfAdditionalResults) {
$data['noResultsClass'] = 'rn_Hidden';
$data['resultClass'] = '';
$data['firstResult'] = 1;
}
$indexToIncrement = (!$page || $page < 2) ? 'lastResult' : 'firstResult';
$data[$indexToIncrement] += $numberOfAdditionalResults;
}
return $numberOfAdditionalResults ?: 0;
}
}
function _standard_reports_ResultInfo_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ResultInfo', 'library_name' => 'ResultInfo', 'view_func_name' => '_standard_reports_ResultInfo_view', 'meta' => array ( 'controller_path' => 'standard/reports/ResultInfo', 'view_path' => 'standard/reports/ResultInfo', 'js_path' => 'standard/reports/ResultInfo', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ResultInfo.css', 1 => 'assets/themes/standard/widgetCss/ResultInfo.css', ), 'base_css' => array ( 0 => 'standard/reports/ResultInfo/base.css', ), 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4283)', ), 'relativePath' => 'standard/reports/ResultInfo', 'widget_name' => 'ResultInfo', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (string)(176), 'type' => 'STRING', 'default' => (string)(176), 'inherited' => false, )), 'source_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'social', 'type' => 'string', 'default' => 'social', 'inherited' => false, )), 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => false, )), 'label_suggestion' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2908), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2908), 'inherited' => false, )), 'label_dictionary' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3940), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3940), 'inherited' => false, )), 'label_spell' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4748), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4748), 'inherited' => false, )), 'label_no_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2820), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2820), 'inherited' => false, )), 'label_no_results_suggestions' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3851), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3851), 'inherited' => false, )), 'label_common' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4395), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4395), 'inherited' => false, )), 'label_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3409), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3409), 'inherited' => false, )), 'label_results_search_query' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3468), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3468), 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'p,c', 'type' => 'STRING', 'default' => 'p,c', 'inherited' => false, )), 'display_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'combined_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'OPTION', 'default' => null, 'options' => array(0 => '', 1 => 'all', 2 => 'social', ), 'inherited' => false, )), 'display_knowledgebase_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class Multiline extends \RightNow\Libraries\Widget\Base {
function _standard_reports_Multiline_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <div id="rn_<?=$this->instanceID;?>_Alert" role="alert" class="rn_ScreenReaderOnly"></div>
    <div id="rn_<?=$this->instanceID;?>_Loading"></div>
    <div id="rn_<?=$this->instanceID;?>_Content" class="rn_Content">
        <?
if (is_array($this->data['reportData']['data']) && count($this->data['reportData']['data']) > 0): ?>
        <? if ($this->data['reportData']['row_num']): ?>
            <ol start="<?=$this->data['reportData']['start_num'];?>">
        <?
else: ?>
            <ul>
        <? endif;
?>
        <? $reportColumns = count($this->data['reportData']['headers']);
foreach ($this->data['reportData']['data'] as $value): ?>
            <li>
                <span class="rn_Element1"><?=$value[0];?></span>
                <?
if($value[1]): ?>
                <span class="rn_Element2"><?=$value[1];?></span>
                <?
endif;
?>
                <span class="rn_Element3"><?=$value[2];?></span>
                <?
for ($i = 3;
$i < $reportColumns;
$i++): ?>
                    <? $header = $this->data['reportData']['headers'][$i];
?>
                    <? if ($this->showColumn($value[$i], $header)): ?>
                    <span class="rn_ElementsHeader"><?=$this->getHeader($header);?></span>
                    <span class="rn_ElementsData"><?=$value[$i];?></span>
                    <?
endif;
?>
                <? endfor;
?>
            </li>
        <? endforeach;
?>
        <? if ($this->data['reportData']['row_num']): ?>
            </ol>
        <? else: ?>
            </ul>
        <? endif;
?>
        <? endif;
?>
    </div>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$format = array( 'truncate_size' => $this->data['attrs']['truncate_size'], 'max_wordbreak_trunc' => $this->data['attrs']['max_wordbreak_trunc'], 'emphasisHighlight' => $this->data['attrs']['highlight'], 'dateFormat' => $this->data['attrs']['date_format'], 'urlParms' => \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']), );
$filters = array('recordKeywordSearch' => true);
$reportToken = \RightNow\Utils\Framework::createToken($this->data['attrs']['report_id']);
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$results = $this->CI->model('Report')->getDataHTML($this->data['attrs']['report_id'], $reportToken, $filters, $format)->result;
if ($results['error'] !== null) {
echo $this->reportError($results['error']);
}
$this->data['reportData'] = $results;
if($this->data['attrs']['hide_when_no_results'] && count($this->data['reportData']['data']) === 0) {
$this->classList->add('rn_Hidden');
}
$this->data['js'] = array( 'filters' => $filters, 'format' => $format, 'r_tok' => $reportToken, 'error' => $results['error'] );
$this->data['js']['filters']['page'] = $results['page'];
}
function showColumn($value, array $header) {
if((!array_key_exists('visible', $header) || $header['visible'] === true)) {
if($this->data['attrs']['hide_empty_columns'] && (is_null($value) || $value === '' || $value === false)) {
return false;
}
return true;
}
return false;
}
function getHeader(array $header) {
return $header['heading'] ? $header['heading'] . ': ' : '';
}
}
function _standard_reports_Multiline_header() {
$result = array( 'js_name' => 'RightNow.Widgets.Multiline', 'library_name' => 'Multiline', 'view_func_name' => '_standard_reports_Multiline_view', 'meta' => array ( 'controller_path' => 'standard/reports/Multiline', 'view_path' => 'standard/reports/Multiline', 'js_path' => 'standard/reports/Multiline', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/Multiline.css', ), 'js_templates' => array ( 'view' => '<% if (row_num) { %> <ol start=\'<%= start_num %>\'><% } else { %> <ul><% } %><% for (var i = 0; i < data.length; i++) { %>  <li> <span class=\'rn_Element1\'><%= data[i][0] %></span> <% if (data[i][1]) { %> <span class=\'rn_Element2\'><%= data[i][1] %></span> <% } %> <span class=\'rn_Element3\'><%= data[i][2] %></span> <% for (var j = 3; j < headers.length; j++) { var value = data[i][j]; if ((typeof headers[j].visible === \'undefined\' || headers[j].visible) && (!hide_empty_columns || !(value === null || value === \'\' || value === false))) { %> <span class=\'rn_ElementsHeader\'><%= ((headers[j].heading) ? headers[j].heading + \': \' : \'\') %></span> <span class=\'rn_ElementsData\'><%= value %></span> <% } %> <% } %> </li> <% } %><% if (row_num) { %> </ol><% } else { %> </ul><% } %>', ), 'template_path' => 'standard/reports/Multiline', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', ), ), 'info' => array ( 'description' => 'rn:msg:(4268)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(3918)', 'example' => 'kw/search', ), 'r_id' => array ( 'name' => 'rn:msg:(19461)', 'description' => 'rn:msg:(3928)', 'example' => 'r_id/176', ), 'st' => array ( 'name' => 'rn:msg:(9716)', 'description' => 'rn:msg:(4494)', 'example' => 'st/6', ), 'org' => array ( 'name' => 'rn:msg:(2905)', 'description' => 'rn:msg:(3584)', 'example' => 'org/2', ), 'page' => array ( 'name' => 'rn:msg:(4591)', 'description' => 'rn:msg:(4495)', 'example' => 'page/2', ), 'search' => array ( 'name' => 'rn:msg:(6920)', 'description' => 'rn:msg:(2262)', 'example' => 'search/0', ), 'sort' => array ( 'name' => 'rn:msg:(4602)', 'key' => 'sort', 'description' => 'rn:msg:(3586)', 'example' => 'sort/3,1', ), ), ), 'relativePath' => 'standard/reports/Multiline', 'widget_name' => 'Multiline', ), );
$result['meta']['attributes'] = array( 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => false, )), 'truncate_size' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 200, 'type' => 'INT', 'default' => 200, 'min' => 1, 'inherited' => false, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'label_screen_reader_search_success_alert' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4463), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4463), 'inherited' => false, )), 'label_screen_reader_search_no_results_alert' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4464), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4464), 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'STRING', 'default' => 'kw', 'inherited' => false, )), 'hide_when_no_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'max_wordbreak_trunc' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'min' => 0, 'inherited' => false, )), 'date_format' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'short', 'type' => 'OPTION', 'default' => 'short', 'options' => array(0 => 'short', 1 => 'date_time', 2 => 'long', 3 => 'raw', ), 'inherited' => false, )), 'hide_empty_columns' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class MobileMultiline extends \RightNow\Widgets\Multiline {
function _standard_reports_MobileMultiline_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <div id="rn_<?=$this->instanceID;?>_Alert" role="alert" class="rn_ScreenReaderOnly"></div>
    <div id="rn_<?=$this->instanceID;?>_Loading"></div>
    <div id="rn_<?=$this->instanceID;?>_Content" class="rn_Content">
        <?
if (is_array($this->data['reportData']['data']) && count($this->data['reportData']['data']) > 0): ?>
        <? if ($this->data['reportData']['row_num']): ?>
            <ol start="<?=$this->data['reportData']['start_num'];?>">
        <?
else: ?>
            <ul>
        <? endif;
?>
        <? $reportColumns = count($this->data['reportData']['headers']);
foreach ($this->data['reportData']['data'] as $value): ?>
            <li>
                <span class="rn_Element1"><?=$value[0];?></span>
                <?
if($value[1]): ?>
                <span class="rn_Element2"><?=$value[1];?></span>
                <?
endif;
?>
                <span class="rn_Element3"><?=$value[2];?></span>
                <?
for ($i = 3;
$i < $reportColumns;
$i++): ?>
                    <? $header = $this->data['reportData']['headers'][$i];
?>
                    <? if ($this->showColumn($value[$i], $header)): ?>
                    <span class="rn_ElementsHeader"><?=$this->getHeader($header);?></span>
                    <span class="rn_ElementsData"><?=$value[$i];?></span>
                    <?
endif;
?>
                <? endfor;
?>
            </li>
        <? endforeach;
?>
        <? if ($this->data['reportData']['row_num']): ?>
            </ol>
        <? else: ?>
            </ul>
        <? endif;
?>
        <? endif;
?>
    </div>
</div>
<? }
}
function _standard_reports_MobileMultiline_header() {
$result = array( 'js_name' => 'RightNow.Widgets.MobileMultiline', 'library_name' => 'MobileMultiline', 'view_func_name' => '_standard_reports_MobileMultiline_view', 'meta' => array ( 'controller_path' => 'standard/reports/MobileMultiline', 'view_path' => 'standard/reports/MobileMultiline', 'js_path' => 'standard/reports/MobileMultiline', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/MobileMultiline.css', ), 'js_templates' => array ( 'view' => '<% if (row_num) { %> <ol start=\'<%= start_num %>\'><% } else { %> <ul><% } %><% for (var i = 0; i < data.length; i++) { %>  <li> <span class=\'rn_Element1\'><%= data[i][0] %></span> <% if (data[i][1]) { %> <span class=\'rn_Element2\'><%= data[i][1] %></span> <% } %> <span class=\'rn_Element3\'><%= data[i][2] %></span> <% for (var j = 3; j < headers.length; j++) { var value = data[i][j]; if ((typeof headers[j].visible === \'undefined\' || headers[j].visible) && (!hide_empty_columns || !(value === null || value === \'\' || value === false))) { %> <span class=\'rn_ElementsHeader\'><%= ((headers[j].heading) ? headers[j].heading + \': \' : \'\') %></span> <span class=\'rn_ElementsData\'><%= value %></span> <% } %> <% } %> </li> <% } %><% if (row_num) { %> </ol><% } else { %> </ul><% } %>', ), 'template_path' => 'standard/reports/MobileMultiline', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/reports/Multiline', 'versions' => array ( 0 => '1.1', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'info' => array ( 'description' => 'rn:msg:(42112)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(3918)', 'example' => 'kw/search', ), 'r_id' => array ( 'name' => 'rn:msg:(19461)', 'description' => 'rn:msg:(3928)', 'example' => 'r_id/176', ), 'st' => array ( 'name' => 'rn:msg:(9716)', 'description' => 'rn:msg:(4494)', 'example' => 'st/6', ), 'org' => array ( 'name' => 'rn:msg:(2905)', 'description' => 'rn:msg:(3584)', 'example' => 'org/2', ), 'page' => array ( 'name' => 'rn:msg:(4591)', 'description' => 'rn:msg:(4495)', 'example' => 'page/2', ), 'search' => array ( 'name' => 'rn:msg:(6920)', 'description' => 'rn:msg:(2262)', 'example' => 'search/0', ), 'sort' => array ( 'name' => 'rn:msg:(4602)', 'key' => 'sort', 'description' => 'rn:msg:(3586)', 'example' => 'sort/3,1', ), ), ), 'relativePath' => 'standard/reports/MobileMultiline', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/reports/Multiline', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/reports/Multiline', ), 'widget_name' => 'MobileMultiline', 'extends_php' => array ( 0 => 'standard/reports/Multiline', ), 'parent' => 'standard/reports/Multiline', ), );
$result['meta']['attributes'] = array( 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'inherited' => true, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => true, )), 'truncate_size' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 200, 'type' => 'INT', 'default' => 200, 'min' => 1, 'inherited' => true, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), 'label_screen_reader_search_success_alert' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4463), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4463), 'inherited' => true, )), 'label_screen_reader_search_no_results_alert' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4464), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4464), 'inherited' => true, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'STRING', 'default' => 'kw', 'inherited' => true, )), 'hide_when_no_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => true, )), 'max_wordbreak_trunc' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'min' => 0, 'inherited' => true, )), 'date_format' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'short', 'type' => 'OPTION', 'default' => 'short', 'options' => array(0 => 'short', 1 => 'date_time', 2 => 'long', 3 => 'raw', ), 'inherited' => true, )), 'hide_empty_columns' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
class Paginator extends \RightNow\Libraries\Widget\Base {
function _standard_reports_Paginator_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID?>" class="<?= $this->classList ?>">
    <a href="<?=$this->data['js']['backPageUrl'];?>" id="rn_<?=$this->instanceID;?>_Back" class="<?=$this->data['backClass'];?>">
    <?
if($this->data['attrs']['back_icon_path']):?>
        <img src="<?=$this->data['attrs']['back_icon_path'];?>" alt="<?=$this->data['attrs']['label_back'];?>"/>
    <?
else:?>
        <?=$this->data['attrs']['label_back'];?>
    <?
endif;?>
    </a>
    <span id="rn_<?=$this->instanceID;?>_Pages" class="rn_PageLinks">
        <?
for($i = $this->data['js']['startPage'];
$i <= $this->data['js']['endPage'];
$i++):?>
            <? if($i == $this->data['js']['currentPage']):?>
                <span class="rn_CurrentPage"><?=$i;?></span>
            <?
else:?>
                <a id="rn_<?=$this->instanceID . '_PageLink_' . $i;?>" href="<?=$this->data['js']['pageUrl'].
$i;?>" title="<?printf($this->data['attrs']['label_page'],$i,
$this->data['totalPages']);?>">
                    <?=$i;?><span class="rn_ScreenReaderOnly"><?printf($this->data['attrs']['label_page'],
$i, $this->data['totalPages']);?></span>
                </a>
            <?
endif;?>
        <?
endfor;?>
    </span>
    <a href="<?=$this->data['js']['forwardPageUrl'];?>" id="rn_<?=$this->instanceID;?>_Forward" class="<?=$this->data['forwardClass'];?>">
    <?
if($this->data['attrs']['forward_icon_path']):?>
        <img src="<?=$this->data['attrs']['forward_icon_path']?>" alt="<?=$this->data['attrs']['label_forward']?>"/>
    <? else:?>
        <?=$this->data['attrs']['label_forward']?>
    <? endif;?>
    </a>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$reportToken = \RightNow\Utils\Framework::createToken($this->data['attrs']['report_id']);
$results = $this->CI->model('Report')->getDataHTML($this->data['attrs']['report_id'], $reportToken, $filters, null)->result;
if(!$this->data['attrs']['maximum_page_links']) {
$this->data['js']['startPage'] = $this->data['js']['endPage'] = $results['page'];
}
else if($results['total_pages'] > $this->data['attrs']['maximum_page_links']) {
$split = round($this->data['attrs']['maximum_page_links'] / 2);
if($results['page'] <= $split) {
$this->data['js']['startPage'] = 1;
$this->data['js']['endPage'] = $this->data['attrs']['maximum_page_links'];
}
else {
$offsetFromMiddle = $results['page'] - $split;
$maxOffset = $offsetFromMiddle + $this->data['attrs']['maximum_page_links'];
if($maxOffset <= $results['total_pages']) {
$this->data['js']['startPage'] = 1 + $offsetFromMiddle;
$this->data['js']['endPage'] = $maxOffset;
}
else {
$this->data['js']['startPage'] = $results['total_pages'] - ($this->data['attrs']['maximum_page_links'] - 1);
$this->data['js']['endPage'] = $results['total_pages'];
}
}
}
else {
$this->data['js']['startPage'] = 1;
$this->data['js']['endPage'] = $results['total_pages'];
}
$this->data['totalPages'] = $results['total_pages'];
$url = $this->CI->page;
$this->data['js']['pageUrl'] = "/app/$url/page/";
$this->data['js']['currentPage'] = $results['page'];
$this->data['js']['backPageUrl'] = $this->data['js']['pageUrl'] . (intval($this->data['js']['currentPage']) - 1);
$this->data['js']['forwardPageUrl'] = $this->data['js']['pageUrl'] . (intval($this->data['js']['currentPage']) + 1);
if ($results['truncated'] || ($results['total_pages'] < 2)) {
$this->classList->add('rn_Hidden');
}
$forwardClass = ($this->data['attrs']['forward_img_path']) ? 'rn_ForwardImageLink' : '';
$this->data['forwardClass'] = ($results['total_pages'] <= $this->data['js']['currentPage']) ? 'rn_Hidden' : $forwardClass;
$backClass = ($this->data['attrs']['back_img_path']) ? 'rn_BackImageLink' : '';
$this->data['backClass'] = ($this->data['js']['currentPage'] <= 1) ? 'rn_Hidden' : $backClass;
}
}
function _standard_reports_Paginator_header() {
$result = array( 'js_name' => 'RightNow.Widgets.Paginator', 'library_name' => 'Paginator', 'view_func_name' => '_standard_reports_Paginator_view', 'meta' => array ( 'controller_path' => 'standard/reports/Paginator', 'view_path' => 'standard/reports/Paginator', 'js_path' => 'standard/reports/Paginator', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/Paginator.css', 1 => 'assets/themes/standard/widgetCss/Paginator.css', ), 'base_css' => array ( 0 => 'standard/reports/Paginator/base.css', ), 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4306)', 'urlParameters' => array ( 'page' => array ( 'name' => 'rn:msg:(4591)', 'description' => 'rn:msg:(3585)', 'example' => 'page/2', ), ), ), 'relativePath' => 'standard/reports/Paginator', 'widget_name' => 'Paginator', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => false, )), 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => false, )), 'maximum_page_links' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 6, 'type' => 'INT', 'default' => 6, 'inherited' => false, )), 'forward_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'back_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2921), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2921), 'inherited' => false, )), 'label_forward' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2807), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2807), 'inherited' => false, )), 'label_back' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2643), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2643), 'inherited' => false, )), );
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
<link href='<?=FileSystem::getOptimizedAssetsDir();?>pages/mobile/answers/list.themes.mobile.css' rel='stylesheet' type='text/css' media='all'/>
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
<section id="rn_PageTitle" class="rn_AnswerList">
    <?if(
(true) ):?>
        <div id="rn_SearchControls">
            <h1><?=\RightNow\Utils\Config::msgGetFrom((4476));?></h1>
            <form method="post" action="" onsubmit="return false;">
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/KeywordText',
array('label_text' => '','report_id' => '176',));
?>
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/SearchButton', array('report_id' => '176','icon_path' => 'images/icons/search.png',));
?>
            </form>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/navigation/Accordion', array('toggle' => 'rn_Advanced',));
?>
            <div class="rn_Padding">
                <a class="rn_AlignRight" href="javascript:void(0);" id="rn_Advanced"><?=\RightNow\Utils\Config::msgGetFrom((3184));?></a>
                <div>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/MobileProductCategorySearchFilter',
array('filter_type' => 'products','report_id' => '176',));
?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/MobileProductCategorySearchFilter', array('filter_type' => 'categories','label_filter_type' => '' . \RightNow\Utils\Config::msgGetFrom((4617)) . '','label_prompt' => '' . \RightNow\Utils\Config::msgGetFrom((3529)) . '','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((2561)) . ' »','report_id' => '176',));
?>
                </div>
            </div>
        </div>
    <?endif;?>
</section>
<section id="rn_PageContent" class="rn_AnswerList">
    <div class="rn_Padding">
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/ResultInfo',
array('report_id' => '176','add_params_to_url' => 'p,c',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/MobileMultiline', array('report_id' => '176',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/Paginator', array('report_id' => '176',));
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
( 0 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/EventProvider.js', 1 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/SearchFilter.js', 2 => 'standard/search/KeywordText', 3 => 'standard/search/SearchButton', 4 => 'standard/navigation/Accordion', 5 => 'standard/search/MobileProductCategorySearchFilter', 6 => 'standard/reports/ResultInfo', 7 => 'standard/reports/MobileMultiline', 8 => 'standard/reports/Paginator', ), '/mobile/answers/list.js', '1436303720');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'ALL_PCT_S_LBL' => array ( 'value' => 958, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
