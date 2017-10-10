<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/standard', 1 => '/euf/assets/themes/standard', 2 => array ( '/euf/assets/themes/standard' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/standard', ), ));
get_instance()->_checkMeta(array('title'=>'' . \RightNow\Utils\Config::msgGetFrom((3854)) . '', 'template'=>'standard.php', 'clickstream'=>'incident_list', 'login_required'=>'true', 'force_https'=>'true'));
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
class AdvancedSearchDialog extends \RightNow\Libraries\Widget\Base {
function _standard_search_AdvancedSearchDialog_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <a href="javascript:void(0);" id="rn_<?=$this->instanceID;?>_TriggerLink" class="rn_AdvancedLink"><?=$this->data['attrs']['label_link'];?></a>
    <div id="rn_<?=$this->instanceID;?>_DialogContent" class="rn_DialogContent rn_Hidden">
        <div class="rn_AdvancedKeyword rn_AdvancedSubWidget">
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/KeywordText',
array('label_text' => '' . \RightNow\Utils\Config::msgGetFrom((3516)) . '','sub_id' => 'keywordText',));
?>
        </div>
    <? if(strlen($this->data['searchTypeFilters'])): ?>
        <div class="rn_AdvancedSearchType rn_AdvancedSubWidget">
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/SearchTypeList', array('filter_list' => '' . $this->data['searchTypeFilters'] . '','sub_id' => 'searchTypeList',));
?>
        </div>
    <? endif;
?>
    <? if($this->data['webSearch']): ?>
        <div class="rn_AdvancedSort rn_AdvancedSubWidget">
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/WebSearchSort', array('sub_id' => 'webSearchSort',));
?>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/WebSearchType', array('sub_id' => 'webSearchType',));
?>
        </div>
    <? else: ?>
        <? if ($this->data['attrs']['display_products_filter']): ?>
        <div class="rn_AdvancedFilter rn_AdvancedSubWidget"><?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/ProductCategorySearchFilter', array('filter_type' => 'products','sub_id' => 'prod',));
?></div>
        <? endif;
?>
        <? if ($this->data['attrs']['display_categories_filter']): ?>
        <div class="rn_AdvancedFilter rn_AdvancedSubWidget"><?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/ProductCategorySearchFilter', array('filter_type' => 'categories','sub_id' => 'cat',));
?></div>
        <? endif;
?>
        <? if (count($this->data['menuFilters'])): ?>
            <? foreach ($this->data['menuFilters'] as $filter): ?>
            <div class="rn_AdvancedFilter rn_AdvancedSubWidget">
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/FilterDropdown', array('filter_name' => '' . $filter . '','sub_id' => '' . "filter_$filter" . '',));
?>
            </div>
            <? endforeach;
?>
        <? endif;
?>
        <? if ($this->data['attrs']['display_sort_filter']):?>
        <div class="rn_AdvancedSort rn_AdvancedSubWidget"><?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/SortList', array('sub_id' => 'sortList',));
?></div>
        <? endif;
?>
    <? endif;?>
    <?
if ($this->data['attrs']['search_tips_url']): ?>
        <a class="rn_SearchTips" href="javascript:void(0);" onclick="window.open('<?=$this->data['attrs']['search_tips_url']?>', '', 'scrollbars,resizable,width=720,height=700'); return false;"><?=\RightNow\Utils\Config::msgGetFrom((4600));?></a>
    <?
endif;
?>
    </div>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$reportID = (int) $this->data['attrs']['report_id'];
if(strlen(trim($this->data['attrs']['additional_filters']))) {
$this->data['menuFilters'] = $this->data['searchTypeFilters'] = array();
$runtimeFilters = explode(',', trim($this->data['attrs']['additional_filters']));
foreach($runtimeFilters as $filter) {
$filter = trim($filter);
$filterData = $this->CI->model('Report')->getFilterByName($reportID, $filter)->result;
if($filterData === null) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((1988)), $filter, $reportID));
continue;
}
if(!in_array($filterData['data_type'], array((1), (3), (5)))) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((1990)), $filter));
continue;
}
if(($filterData['data_type'] === (3) || $filterData['data_type'] === (5))) {
$this->data['searchTypeFilters'][] = $filter;
}
else {
$this->data['menuFilters'][] = $filter;
}
}
$this->data['searchTypeFilters'] = count($this->data['searchTypeFilters']) ? implode(',', $this->data['searchTypeFilters']) : '';
}
$this->data['webSearch'] = ($reportID === (10022) || $reportID === (10016));
}
}
function _standard_search_AdvancedSearchDialog_header() {
$result = array( 'js_name' => 'RightNow.Widgets.AdvancedSearchDialog', 'library_name' => 'AdvancedSearchDialog', 'view_func_name' => '_standard_search_AdvancedSearchDialog_view', 'meta' => array ( 'controller_path' => 'standard/search/AdvancedSearchDialog', 'view_path' => 'standard/search/AdvancedSearchDialog', 'js_path' => 'standard/search/AdvancedSearchDialog', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/AdvancedSearchDialog.css', 1 => 'assets/themes/mobile/widgetCss/AdvancedSearchDialog.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4201)', ), 'contains' => array ( 0 => array ( 'widget' => 'standard/search/KeywordText', 'versions' => array ( 0 => '1.0', ), ), 1 => array ( 'widget' => 'standard/search/SearchTypeList', 'versions' => array ( 0 => '1.0', ), ), 2 => array ( 'widget' => 'standard/search/WebSearchSort', 'versions' => array ( 0 => '1.0', ), ), 3 => array ( 'widget' => 'standard/search/WebSearchType', 'versions' => array ( 0 => '1.1', ), ), 4 => array ( 'widget' => 'standard/search/ProductCategorySearchFilter', 'versions' => array ( 0 => '1.0', ), ), 5 => array ( 'widget' => 'standard/search/FilterDropdown', 'description' => 'rn:msg:(46196)', 'versions' => array ( 0 => '1.0', ), ), 6 => array ( 'widget' => 'standard/search/SortList', 'versions' => array ( 0 => '1.1', ), ), ), 'relativePath' => 'standard/search/AdvancedSearchDialog', 'widget_name' => 'AdvancedSearchDialog', ), );
$result['meta']['attributes'] = array( 'label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4479), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4479), 'inherited' => false, )), 'label_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4479), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4479), 'inherited' => false, )), 'label_search_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(6920), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(6920), 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9555), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9555), 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'search_tips_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/utils/help_search', 'type' => 'STRING', 'default' => '/app/utils/help_search', 'inherited' => false, )), 'display_products_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'display_categories_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'display_sort_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'additional_filters' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class KeywordText extends \RightNow\Libraries\Widget\Base {
function _standard_search_KeywordText_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
$result = array( 'js_name' => 'RightNow.Widgets.KeywordText', 'library_name' => 'KeywordText', 'view_func_name' => '_standard_search_KeywordText_view', 'meta' => array ( 'controller_path' => 'standard/search/KeywordText', 'view_path' => 'standard/search/KeywordText', 'js_path' => 'standard/search/KeywordText', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/KeywordText.css', 1 => 'assets/themes/mobile/widgetCss/KeywordText.css', ), 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(42114)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(4496)', 'example' => 'kw/roam', ), ), ), 'relativePath' => 'standard/search/KeywordText', 'widget_name' => 'KeywordText', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'source_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4690), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4690), 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class SearchButton extends \RightNow\Libraries\Widget\Base {
function _standard_search_SearchButton_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
$result = array( 'js_name' => 'RightNow.Widgets.SearchButton', 'library_name' => 'SearchButton', 'view_func_name' => '_standard_search_SearchButton_view', 'meta' => array ( 'controller_path' => 'standard/search/SearchButton', 'view_path' => 'standard/search/SearchButton', 'js_path' => 'standard/search/SearchButton', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/SearchButton.css', 1 => 'assets/themes/mobile/widgetCss/SearchButton.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4253)', ), 'relativePath' => 'standard/search/SearchButton', 'widget_name' => 'SearchButton', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'source_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4693), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4693), 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'FILEPATH', 'default' => '', 'inherited' => false, )), 'icon_alt_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4693), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4693), 'inherited' => false, )), 'target' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '_self', 'type' => 'STRING', 'default' => '_self', 'inherited' => false, )), 'popup_window' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'popup_window_width_percent' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 30, 'type' => 'INT', 'default' => 30, 'inherited' => false, )), 'popup_window_height_percent' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 42, 'type' => 'INT', 'default' => 42, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use \RightNow\Utils\Config;
class DisplaySearchFilters extends \RightNow\Libraries\Widget\Base {
function _standard_search_DisplaySearchFilters_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
<span class="rn_Heading"><?=$this->data['attrs']['label_title'];?></span>
<div id="rn_<?=$this->instanceID;?>_FilterContainer">
<?
for($i = 0;
$i < count($this->data['js']['filters']);
$i++):?>
    <div id="rn_<?=$this->instanceID . '_Filter_' . $i;?>" class="rn_Filter">
        <div class="rn_Label"><?=$this->data['js']['filters'][$i]['label'];?>
        <a id="rn_<?=$this->instanceID.'_Remove_'
. $i?>" title="<?=$this->data['attrs']['label_filter_remove'];?>" href="javascript:void(0);">
        <?
if($this->data['attrs']['remove_icon_path']):?>
            <img src="<?=$this->data['attrs']['remove_icon_path'];?>" alt="<?=$this->data['attrs']['label_filter_remove'];?>"/>
        <?
else:?>
            <?=$this->data['attrs']['label_filter_remove'];?>
        <?
endif;?>
        </a>
        </div>
        <?
foreach($this->data['js']['filters'][$i]['data'] as $index => $filter):?>
            <? $class = ($index === count($this->data['js']['filters'][$i]['data']) - 1) ? 'rn_Selected' : '';
?>
            <a href="<?=$filter['linkUrl'];?>" class="rn_FilterItem <?=$class;?>" id="rn_<?=$this->instanceID;?>_Filter<?=$filter['id']?>"><?=htmlspecialchars($filter['label'],
ENT_QUOTES, 'UTF-8');?></a>
            <span class="rn_Separator <?=$class;?>"></span>
        <?
endforeach;?>
    </div>
<?
endfor;?>
</div>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$displayedFilters = $defaultFilters = array();
$searchPage = "/app/{$this->CI->page}/";
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
if($chain = trim($filters['p']->filters->data[0])) {
$displayedFilters[] = $this->getFormattedFilter('p', $filters['p']->filters->fltr_id, Config::getMessage((4594)), $this->getHierarchyData('p', $chain, $searchPage));
}
if($chain = trim($filters['c']->filters->data[0])) {
$displayedFilters[] = $this->getFormattedFilter('c', $filters['c']->filters->fltr_id, Config::getMessage((4574)), $this->getHierarchyData('c', $chain, $searchPage));
}
$reportID = (int) $this->data['attrs']['report_id'];
$defaultSearchType = $this->CI->model('Report')->getSearchFilterTypeDefault($reportID)->result;
$displayedSearchType = $this->CI->model('Report')->getFilterById($reportID, $filters['searchType']->filters->fltr_id)->result;
$defaultFilters[] = array('name' => 'st', 'defaultValue' => $defaultSearchType['fltr_id']);
if ($reportID === (10016)) {
$standardDefaultType = $this->CI->model('Report')->getSearchFilterTypeDefault((166))->result;
$defaultFilters[] = array('name' => 'st', 'defaultValue' => $standardDefaultType['fltr_id']);
}
if($displayedSearchType['fltr_id'] && $defaultSearchType['fltr_id'] !== $displayedSearchType['fltr_id']) {
$displayedFilters[] = $this->getFormattedFilter('st', $displayedSearchType['fltr_id'], Config::getMessage((9716)), $this->getFlatData($displayedSearchType['fltr_id'], $displayedSearchType['prompt']));
}
if(($organizationID = $this->CI->session->getProfileData('orgID')) && $organizationID > 0) {
$defaultOrgFilter = 0;
$displayedOrgFilter = intval(\RightNow\Utils\Url::getParameter('org'));
$defaultFilters[] = array('name' => 'org', 'defaultValue' => $defaultOrgFilter);
if($displayedOrgFilter === 1) {
$displayedMessage = Config::getMessage((2025));
}
else if($displayedOrgFilter === 2) {
$displayedMessage = Config::getMessage((2782));
}
if($displayedMessage) {
$displayedFilters[] = $this->getFormattedFilter('org', $displayedOrgFilter, Config::getMessage((7002)), $this->getFlatData($displayedOrgFilter, $displayedMessage));
}
}
if(empty($displayedFilters)) {
$this->classList->add('rn_Hidden');
}
$this->data['js'] = array( 'defaultFilters' => $defaultFilters, 'filters' => $displayedFilters, 'searchPage' => $searchPage );
}
protected function getFormattedFilter($urlParameter, $filterID, $typeLabel, $filterData) {
return array( 'urlParameter' => $urlParameter, 'filterID' => $filterID, 'label' => $typeLabel, 'data' => $filterData, );
}
protected function getFlatData($filterID, $label) {
return array(array('id' => $filterID, 'label' => $label, 'linkUrl' => 'javascript:void(0)'));
}
protected function getHierarchyData($filterName, $chain, $searchPage) {
$chainData = $this->CI->model('Prodcat')->getFormattedChain(($filterName === 'p') ? 'Product' : 'Category', end(explode(',', $chain)))->result;
foreach($chainData as &$value) {
$value += array('linkUrl' => "{$searchPage}{$filterName}/{$value['id']}");
}
$chainData[count($chainData) - 1]['linkUrl'] = 'javascript:void(0)';
return $chainData;
}
}
function _standard_search_DisplaySearchFilters_header() {
$result = array( 'js_name' => 'RightNow.Widgets.DisplaySearchFilters', 'library_name' => 'DisplaySearchFilters', 'view_func_name' => '_standard_search_DisplaySearchFilters_view', 'meta' => array ( 'controller_path' => 'standard/search/DisplaySearchFilters', 'view_path' => 'standard/search/DisplaySearchFilters', 'js_path' => 'standard/search/DisplaySearchFilters', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/DisplaySearchFilters.css', 1 => 'assets/themes/mobile/widgetCss/DisplaySearchFilters.css', ), 'base_css' => array ( 0 => 'standard/search/DisplaySearchFilters/base.css', ), 'js_templates' => array ( 'view' => '<div id=\'<%= divID %>\' class=\'rn_Filter\'> <div class=\'rn_Label\'><%= label %>  <a id=\'<%= removeLinkID %>\' title=\'<%= labelFilterRemove %>\' href=\'javascript:void(0);\'> <% if (removeIconPath) { %> <img src=\'<%= removeIconPath %>\' alt=\'<%= labelFilterRemove %>\'/> <% } else { %> <%= labelFilterRemove %> <% } %> </a>  </div>  <% for(var i = 0; i < filterData.length; i++) { var selectionClass = (i === filterData.length -1) ? \'rn_Selected\' : \'\'; %>  <a id="<%= filterData[i].linkID %>" href="<%= filterData[i].linkUrl %>" class="rn_FilterItem <%= selectionClass %>"> <%= filterData[i].label %> </a>  <span class="rn_Separator <%= selectionClass %>"></span> <% } %> </div>', ), 'template_path' => 'standard/search/DisplaySearchFilters', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4191)', 'urlParameters' => array ( 'filter_name' => array ( 'name' => 'rn:msg:(1986)', 'description' => 'rn:msg:(4506)', 'example' => 'p/1,4,6', ), ), ), 'relativePath' => 'standard/search/DisplaySearchFilters', 'widget_name' => 'DisplaySearchFilters', ), );
$result['meta']['attributes'] = array( 'remove_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/remove.png', 'type' => 'filepath', 'default' => 'images/remove.png', 'inherited' => false, )), 'label_filter_remove' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(6896), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(6896), 'inherited' => false, )), 'label_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3504), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3504), 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ResultInfo extends \RightNow\Libraries\Widget\Base {
function _standard_reports_ResultInfo_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
$result = array( 'js_name' => 'RightNow.Widgets.ResultInfo', 'library_name' => 'ResultInfo', 'view_func_name' => '_standard_reports_ResultInfo_view', 'meta' => array ( 'controller_path' => 'standard/reports/ResultInfo', 'view_path' => 'standard/reports/ResultInfo', 'js_path' => 'standard/reports/ResultInfo', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ResultInfo.css', 1 => 'assets/themes/mobile/widgetCss/ResultInfo.css', ), 'base_css' => array ( 0 => 'standard/reports/ResultInfo/base.css', ), 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4283)', ), 'relativePath' => 'standard/reports/ResultInfo', 'widget_name' => 'ResultInfo', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (string)(176), 'type' => 'STRING', 'default' => (string)(176), 'inherited' => false, )), 'source_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'social', 'type' => 'string', 'default' => 'social', 'inherited' => false, )), 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => false, )), 'label_suggestion' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2908), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2908), 'inherited' => false, )), 'label_dictionary' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3940), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3940), 'inherited' => false, )), 'label_spell' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4748), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4748), 'inherited' => false, )), 'label_no_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2820), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2820), 'inherited' => false, )), 'label_no_results_suggestions' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3851), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3851), 'inherited' => false, )), 'label_common' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4395), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4395), 'inherited' => false, )), 'label_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3409), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3409), 'inherited' => false, )), 'label_results_search_query' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3468), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3468), 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'p,c', 'type' => 'STRING', 'default' => 'p,c', 'inherited' => false, )), 'display_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'combined_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'OPTION', 'default' => null, 'options' => array(0 => '', 1 => 'all', 2 => 'social', ), 'inherited' => false, )), 'display_knowledgebase_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class Grid extends \RightNow\Libraries\Widget\Base {
function _standard_reports_Grid_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <div id="rn_<?=$this->instanceID;?>_Alert" role="alert" class="rn_ScreenReaderOnly"></div>
    <div id="rn_<?=$this->instanceID;?>_Loading"></div>
    <div id="rn_<?=$this->instanceID;?>_Content" class="yui3-skin-sam">
        <table id="rn_<?=$this->instanceID;?>_Grid" class="yui3-datatable-table" role="grid">
        <caption><?=$this->data['attrs']['label_caption']?></caption>
        <?
if($this->data['attrs']['headers']):?>
            <thead class="yui3-datatable-columns">
                <tr>
                <? if($this->data['tableData']['row_num']):?>
                    <th class="yui3-datatable-header yui3-datatable-sortable-column"><?=$this->data['attrs']['label_row_number']?></th>
                <? endif;?>
                <?
foreach($this->data['tableData']['headers'] as $header):?>
                    <? if(!$header['visible']) continue;
?>
                    <? if($header['width'] !== null):?>
                        <th class="yui3-datatable-header yui3-datatable-sortable-column" style='width:"<?=$header['width'];?>%"'><?=$header['heading'];?></th>
                    <?
else:?>
                        <th class="yui3-datatable-header yui3-datatable-sortable-column"><?=$header['heading'];?></th>
                    <?
endif;?>
                <?
endforeach;?>
                </tr>
            </thead>
        <?
endif;?>
        <?
if(count($this->data['tableData']['data']) > 0): ?>
            <tbody class="yui3-datatable-data">
            <? for($i = 0;
$i < count($this->data['tableData']['data']);
$i++): ?>
                <tr role="row" class="<?=($i % 2 === 0) ? 'yui3-datatable-even' : 'yui3-datatable-odd'?>">
                <? if($this->data['tableData']['row_num']):?>
                    <td role="gridcell" class="yui3-datatable-cell"><?=$this->data['tableData']['start_num'] + $i;?></td>
                <?
endif;?>
                <?
for($j = 0;
$j < count($this->data['tableData']['headers']);
$j++):?>
                    <? if(!$this->data['tableData']['headers'][$j]['visible']) continue;
?>
                    <td role="gridcell" class="yui3-datatable-cell"><?=($this->data['tableData']['data'][$i][$j] !== '' && $this->data['tableData']['data'][$i][$j] !== null && $this->data['tableData']['data'][$i][$j] !== false) ? $this->data['tableData']['data'][$i][$j] : '&nbsp;' ?></td>
                <? endfor;?>
                </tr>
            <?
endfor;?>
            </tbody>
        <?
endif;?>
        </table>
    </div>
</div><?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$format = array( 'truncate_size' => $this->data['attrs']['truncate_size'], 'max_wordbreak_trunc' => $this->data['attrs']['max_wordbreak_trunc'], 'emphasisHighlight' => $this->data['attrs']['highlight'], 'recordKeywordSearch' => true, 'dateFormat' => $this->data['attrs']['date_format'], 'urlParms' => \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']), 'hiddenColumns' => true, );
$filters = array('recordKeywordSearch' => true);
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$reportToken = \RightNow\Utils\Framework::createToken($this->data['attrs']['report_id']);
$results = $this->CI->model('Report')->getDataHTML($this->data['attrs']['report_id'], $reportToken, $filters, $format)->result;
if ($results['error'] !== null) {
echo $this->reportError($results['error']);
return false;
}
$this->data['tableData'] = $results;
if(count($this->data['tableData']['data']) === 0 && $this->data['attrs']['hide_when_no_results']) {
$this->classList->add('rn_Hidden');
}
$filters['page'] = $results['page'];
$this->data['js'] = array( 'filters' => $filters, 'columnID' => (int) $filters['sort_args']['filters']['col_id'], 'sortDirection' => (int) $filters['sort_args']['filters']['sort_direction'], 'format' => $format, 'token' => $reportToken, 'headers' => $this->data['tableData']['headers'], 'rowNumber' => $this->data['tableData']['row_num'], 'searchName' => 'sort_args', 'dataTypes' => array('date' => (7), 'datetime' => (4), 'number' => (3)) );
}
}
function _standard_reports_Grid_header() {
$result = array( 'js_name' => 'RightNow.Widgets.Grid', 'library_name' => 'Grid', 'view_func_name' => '_standard_reports_Grid_view', 'meta' => array ( 'controller_path' => 'standard/reports/Grid', 'view_path' => 'standard/reports/Grid', 'js_path' => 'standard/reports/Grid', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/Grid.css', 1 => 'assets/themes/mobile/widgetCss/Grid.css', ), 'base_css' => array ( 0 => 'standard/reports/Grid/base.css', ), 'js_templates' => array ( 'dataTable' => '<table id="<%= tableID %>" class="yui3-datatable-table" role="grid"> <caption><%= caption %></caption> <thead class="yui3-datatable-columns">  <tr> <% for (var h=0; h < headers.length; h++) { %> <th class="yui3-datatable-header yui3-datatable-sortable-column" style="<%= headers[h].style %>"><%= headers[h].label %></th> <% } %> </tr>  </thead> <tbody class="yui3-datatable-data">  <% for (var r=0; r < rows.length; r++) { %>  <tr role="row" class="yui3-datatable-<%= (r % 2 === 0) ? \'even\' : \'odd\' %>"> <% for (var d=0; d < rows[r].length; d++) { %> <td role="gridcell" class="yui3-datatable-cell"><%= rows[r][d] %></td> <% } %> </tr>  <% } %>  </tbody></table>', ), 'template_path' => 'standard/reports/Grid', 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', ), 'yui' => array ( 0 => 'datatable-base', 1 => 'datatable-sort', 2 => 'datatable-message', ), ), 'info' => array ( 'description' => 'rn:msg:(4269)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(3918)', 'example' => 'kw/search', ), 'r_id' => array ( 'name' => 'rn:msg:(19461)', 'description' => 'rn:msg:(3928)', 'example' => 'r_id/176', ), 'st' => array ( 'name' => 'rn:msg:(9716)', 'description' => 'rn:msg:(4494)', 'example' => 'st/6', ), 'org' => array ( 'name' => 'rn:msg:(2905)', 'description' => 'rn:msg:(3584)', 'example' => 'org/2', ), 'page' => array ( 'name' => 'rn:msg:(4591)', 'description' => 'rn:msg:(4495)', 'example' => 'page/2', ), 'search' => array ( 'name' => 'rn:msg:(6920)', 'description' => 'rn:msg:(2262)', 'example' => 'search/0', ), 'sort' => array ( 'name' => 'rn:msg:(4602)', 'description' => 'rn:msg:(3586)', 'example' => 'sort/3,1', ), ), ), 'relativePath' => 'standard/reports/Grid', 'widget_name' => 'Grid', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => false, )), 'headers' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => false, )), 'truncate_size' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 75, 'type' => 'INT', 'default' => 75, 'min' => 1, 'inherited' => false, )), 'label_row_number' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3460), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3460), 'inherited' => false, )), 'label_caption' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'STRING', 'default' => 'kw', 'inherited' => false, )), 'label_screen_reader_search_success_alert' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4463), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4463), 'inherited' => false, )), 'label_screen_reader_search_no_results_alert' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4464), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4464), 'inherited' => false, )), 'hide_when_no_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'max_wordbreak_trunc' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'min' => 0, 'inherited' => false, )), 'date_format' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'short', 'type' => 'OPTION', 'default' => 'short', 'options' => array(0 => 'short', 1 => 'date_time', 2 => 'long', 3 => 'raw', ), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class Paginator extends \RightNow\Libraries\Widget\Base {
function _standard_reports_Paginator_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID?>" class="<?= $this->classList ?>">
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
$result = array( 'js_name' => 'RightNow.Widgets.Paginator', 'library_name' => 'Paginator', 'view_func_name' => '_standard_reports_Paginator_view', 'meta' => array ( 'controller_path' => 'standard/reports/Paginator', 'view_path' => 'standard/reports/Paginator', 'js_path' => 'standard/reports/Paginator', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/Paginator.css', 1 => 'assets/themes/mobile/widgetCss/Paginator.css', ), 'base_css' => array ( 0 => 'standard/reports/Paginator/base.css', ), 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4306)', 'urlParameters' => array ( 'page' => array ( 'name' => 'rn:msg:(4591)', 'description' => 'rn:msg:(3585)', 'example' => 'page/2', ), ), ), 'relativePath' => 'standard/reports/Paginator', 'widget_name' => 'Paginator', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => false, )), 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => false, )), 'maximum_page_links' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 6, 'type' => 'INT', 'default' => 6, 'inherited' => false, )), 'forward_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'back_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2921), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2921), 'inherited' => false, )), 'label_forward' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2807), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2807), 'inherited' => false, )), 'label_back' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2643), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2643), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class SearchTypeList extends \RightNow\Libraries\Widget\Base {
function _standard_search_SearchTypeList_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <label for="rn_<?=$this->instanceID;?>_Options" ><?=$this->data['attrs']['label_text'];?></label>
    <select id="rn_<?=$this->instanceID;?>_Options">
        <?foreach($this->data['js']['filters']
as $key => $value): echo "<";
?>option value='<?=$value['fltr_id'];?>' <?if($value['fltr_id']
=== $this->data['js']['defaultFilter']) echo "selected='selected'";?>><?=$value['prompt'];?></option>
        <?endforeach;?>
    </select>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['attrs']['filter_list'] = trim($this->data['attrs']['filter_list']);
$filters = array();
if(strlen($this->data['attrs']['filter_list'])) {
$addedFilters = explode(',', $this->data['attrs']['filter_list']);
foreach($addedFilters as $filter) {
$filter = trim($filter);
$filterData = $this->CI->model('Report')->getFilterByName($this->data['attrs']['report_id'], $filter)->result;
if($filterData === null || (is_array($filterData) && !in_array($filterData['data_type'], array((3), (5))))) {
$this->reportError(sprintf(\RightNow\Utils\Config::getMessage((1987)), $filter), false);
continue;
}
$filters[] = $filterData;
}
}
else {
$filters = ($this->data['attrs']['search_type_only']) ? $this->CI->model('Report')->getSearchFilterData($this->data['attrs']['report_id'])->result : $this->CI->model('Report')->getRuntimeIntTextData($this->data['attrs']['report_id'])->result;
}
if(empty($filters)) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((42140)), $this->data['attrs']['report_id'], 'filter_list'));
return false;
}
$resetFilter = $this->CI->model('Report')->getSearchFilterTypeDefault($this->data['attrs']['report_id'])->result;
foreach($filters as $filter) {
if($filter['fltr_id'] === $resetFilter['fltr_id']) {
$hasReset = true;
break;
}
}
if(!$hasReset) {
$this->reportError(sprintf(\RightNow\Utils\Config::getMessage((42058)), $this->data['attrs']['report_id'], $resetFilter['expression1']), false);
array_unshift($filters, $resetFilter);
}
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $urlFilters);
$this->data['js'] = array('filters' => $filters, 'defaultFilter' => $urlFilters['searchType']->filters->fltr_id, 'resetFilter' => $resetFilter['fltr_id'], 'rnSearchType' => 'searchType', 'searchName' => 'searchType');
}
}
function _standard_search_SearchTypeList_header() {
$result = array( 'js_name' => 'RightNow.Widgets.SearchTypeList', 'library_name' => 'SearchTypeList', 'view_func_name' => '_standard_search_SearchTypeList_view', 'meta' => array ( 'controller_path' => 'standard/search/SearchTypeList', 'view_path' => 'standard/search/SearchTypeList', 'js_path' => 'standard/search/SearchTypeList', 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', 3 => '3.3', 4 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'category' => array ( 0 => 'Report Search', ), 'description' => 'rn:msg:(42110)', 'urlParameters' => array ( 'st' => array ( 'name' => 'rn:msg:(9716)', 'description' => 'rn:msg:(4494)', 'example' => 'st/6', ), ), ), 'relativePath' => 'standard/search/SearchTypeList', 'widget_name' => 'SearchTypeList', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'label_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9716), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9716), 'inherited' => false, )), 'search_on_select' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'search_type_only' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'filter_list' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'static_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class WebSearchSort extends \RightNow\Libraries\Widget\Base {
function _standard_search_WebSearchSort_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <label for='rn_<?=$this->instanceID;?>_Options'><?=$this->data['attrs']['label_sort']?></label>
    <select id='rn_<?=$this->instanceID;?>_Options'>
        <?
foreach($this->data['sortOptions'] as $key => $value): echo "<";
?>option value="<?=$key;?>"<?=($js['sortDefault']
== $key) ? ' selected="selected"' : '';?>><?=$value?></option>
        <?
endforeach;?>
    </select>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$sortMode = $filters['sort_args']['filters']['col_id'];
$this->data['js'] = array('report_id' => $this->data['attrs']['report_id'], 'sortDefault' => $sortMode ?: \RightNow\Utils\Config::getConfig((258), 'RNW_UI'), 'configDefault' => \RightNow\Utils\Config::getConfig((258), 'RNW_UI') );
$this->data['sortOptions'] = $this->CI->model('Report')->getExternalDocumentSortOptions()->result;
}
}
function _standard_search_WebSearchSort_header() {
$result = array( 'js_name' => 'RightNow.Widgets.WebSearchSort', 'library_name' => 'WebSearchSort', 'view_func_name' => '_standard_search_WebSearchSort_view', 'meta' => array ( 'controller_path' => 'standard/search/WebSearchSort', 'view_path' => 'standard/search/WebSearchSort', 'js_path' => 'standard/search/WebSearchSort', 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', 3 => '3.3', 4 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'category' => array ( 0 => 'Report Search', ), 'description' => 'rn:msg:(1648)', 'urlParameters' => array ( 'sort' => array ( 'name' => 'rn:msg:(4602)', 'description' => 'rn:msg:(3587)', 'example' => 'sort/3', ), ), ), 'relativePath' => 'standard/search/WebSearchSort', 'widget_name' => 'WebSearchSort', ), );
$result['meta']['attributes'] = array( 'label_sort' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4602), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4602), 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (10022), 'type' => 'OPTION', 'default' => (10022), 'options' => array(0 => '10022', 1 => '10016', ), 'inherited' => false, )), 'static_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class WebSearchType extends \RightNow\Libraries\Widget\Base {
function _standard_search_WebSearchType_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <label for='rn_<?=$this->instanceID;?>_Options'><?=$this->data['attrs']['label_search']?></label>
    <select id='rn_<?=$this->instanceID;?>_Options'>
        <?
foreach($this->data['searchOptions'] as $key => $value): echo "<";
?>option value="<?=$key;?>"<?=($this->data['js']['searchDefault']
== $key) ? ' selected="selected"' : '';?>><?=$value?></option>
        <?
endforeach;?>
    </select>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$searchMode = $filters['searchType']->filters->fltr_id;
$this->data['js'] = array('report_id' => $this->data['attrs']['report_id'], 'searchDefault' => ($searchMode) ? $searchMode : \RightNow\Utils\Config::getConfig((257), 'RNW_UI') );
$this->data['searchOptions'] = $this->CI->model('Report')->getExternalDocumentSearchOptions()->result;
}
}
function _standard_search_WebSearchType_header() {
$result = array( 'js_name' => 'RightNow.Widgets.WebSearchType', 'library_name' => 'WebSearchType', 'view_func_name' => '_standard_search_WebSearchType_view', 'meta' => array ( 'controller_path' => 'standard/search/WebSearchType', 'view_path' => 'standard/search/WebSearchType', 'js_path' => 'standard/search/WebSearchType', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'category' => array ( 0 => 'Report Search', ), 'description' => 'rn:msg:(1649)', 'urlParameters' => array ( 'st' => array ( 'name' => 'rn:msg:(3500)', 'description' => 'rn:msg:(4494)', 'example' => 'st/2', ), ), ), 'relativePath' => 'standard/search/WebSearchType', 'widget_name' => 'WebSearchType', ), );
$result['meta']['attributes'] = array( 'label_search' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4583), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4583), 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (10022), 'type' => 'OPTION', 'default' => (10022), 'options' => array(0 => '10022', 1 => '10016', ), 'inherited' => false, )), 'static_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Text;
class ProductCategorySearchFilter extends \RightNow\Libraries\Widget\Base {
function _standard_search_ProductCategorySearchFilter_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <a href="javascript:void(0);" class="rn_ScreenReaderOnly" id="rn_<?= $this->instanceID ?>_LinksTrigger"><? printf($this->data['attrs']['label_screen_reader_accessible_option'], $this->data['attrs']['label_input']) ?>&nbsp;<span id="rn_<?= $this->instanceID ?>_TreeDescription"></span></a>
    <? if ($this->data['attrs']['label_input']): ?>
    <span class="rn_Label"><?= $this->data['attrs']['label_input'] ?></span>
    <? endif;
?>
    <button type="button" id="rn_<?= $this->instanceID ?>_<?= $this->data['attrs']['filter_type'] ?>_Button" class="rn_DisplayButton"><span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['label_accessible_interface'] ?></span> <span id="rn_<?= $this->instanceID ?>_ButtonVisibleText"><?= $this->data['attrs']['label_nothing_selected'] ?></span></button>
    <div class="rn_ProductCategoryLinks rn_Hidden" id="rn_<?= $this->instanceID ?>_Links"></div>
    <div id="rn_<?= $this->instanceID ?>_TreeContainer" class="rn_PanelContainer rn_Hidden">
        <div id="rn_<?= $this->instanceID ?>_Tree" class="rn_Panel"><? ?></div>
    <? if ($this->data['attrs']['show_confirm_button_in_dialog']): ?>
        <div id="rn_<?= $this->instanceID ?>_SelectionButtons" class="rn_SelectionButtons">
            <button type="button" id="rn_<?= $this->instanceID ?>_<?= $this->data['attrs']['filter_type'] ?>_ConfirmButton"><?= $this->data['attrs']['label_confirm_button'] ?></button>
            <button type="button" id="rn_<?= $this->instanceID ?>_<?= $this->data['attrs']['filter_type'] ?>_CancelButton"><?= $this->data['attrs']['label_cancel_button'] ?></button>
        </div>
    <? endif;
?>
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
$this->data['attrs']['label_input'] = ($this->data['attrs']['label_input'] === \RightNow\Utils\Config::getMessage((2562))) ? \RightNow\Utils\Config::getMessage((2561)) : $this->data['attrs']['label_input'];
$this->data['attrs']['label_nothing_selected'] = ($this->data['attrs']['label_nothing_selected'] === \RightNow\Utils\Config::getMessage((3532))) ? \RightNow\Utils\Config::getMessage((3529)) : $this->data['attrs']['label_nothing_selected'];
}
$filters = array();
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$filterType = strtolower($this->data['attrs']['filter_type'][0]);
if(!$filters[$filterType]->filters->optlist_id) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((1955)), $this->data['attrs']['filter_type'], $this->data['attrs']['report_id']));
return false;
}
$trimmedTreeViewCss = trim($this->data['attrs']['treeview_css']);
if ($trimmedTreeViewCss !== '') $this->addStylesheet($trimmedTreeViewCss);
$this->data['js'] = array( 'oper_id' => $filters[$filterType]->filters->oper_id, 'fltr_id' => $filters[$filterType]->filters->fltr_id, 'linkingOn' => $this->data['attrs']['linking_off'] ? 0 : $this->CI->model('Prodcat')->getLinkingMode(), 'report_def' => $filters[$filterType]->report_default, 'searchName' => $filterType, 'hm_type' => ($filterType === 'p') ? (13) : (14), );
$dataType = $this->data['attrs']['filter_type'];
$defaultChain = $filters[$filterType]->filters->data[0];
$defaultChain = $this->data['js']['initial'] = ($defaultChain) ? explode(',', $defaultChain) : array();
if($this->data['js']['linkingOn'] && $dataType === self::CATEGORY) {
$defaultProductID = end(explode(',', $filters['p']->filters->data[0])) ?: null;
$this->data['js']['link_map'] = $defaultHierMap = $this->CI->model('Prodcat')->getFormattedTree($dataType, $defaultChain, true, $defaultProductID)->result;
$this->data['js']['hierDataNone'] = $this->CI->model('Prodcat')->getFormattedTree($dataType, array(), true)->result;
array_unshift($this->data['js']['hierDataNone'][0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
array_unshift($this->data['js']['link_map'][0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
}
else {
$defaultHierMap = $this->CI->model('Prodcat')->getFormattedTree($dataType, $defaultChain)->result;
}
array_unshift($defaultHierMap[0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
$this->data['js']['hierData'] = $defaultHierMap;
}
}
function _standard_search_ProductCategorySearchFilter_header() {
$result = array( 'js_name' => 'RightNow.Widgets.ProductCategorySearchFilter', 'library_name' => 'ProductCategorySearchFilter', 'view_func_name' => '_standard_search_ProductCategorySearchFilter_view', 'meta' => array ( 'controller_path' => 'standard/search/ProductCategorySearchFilter', 'view_path' => 'standard/search/ProductCategorySearchFilter', 'js_path' => 'standard/search/ProductCategorySearchFilter', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ProductCategorySearchFilter.css', 1 => 'assets/themes/mobile/widgetCss/ProductCategorySearchFilter.css', ), 'base_css' => array ( 0 => 'standard/search/ProductCategorySearchFilter/base.css', ), 'version' => '1.0.3', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', ), 'yui' => array ( 0 => 'panel', 1 => 'gallery-treeview', ), ), 'info' => array ( 'description' => 'rn:msg:(4271)', 'urlParameters' => array ( 'p' => array ( 'name' => 'rn:msg:(4594)', 'description' => 'rn:msg:(1223)', 'example' => 'p/1,2,3', ), 'c' => array ( 'name' => 'rn:msg:(4574)', 'description' => 'rn:msg:(1247)', 'example' => 'c/1', ), ), ), 'relativePath' => 'standard/search/ProductCategorySearchFilter', 'widget_name' => 'ProductCategorySearchFilter', ), );
$result['meta']['attributes'] = array( 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2562), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2562), 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'min' => 1, 'inherited' => false, )), 'filter_type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'products', 'type' => 'OPTION', 'default' => 'products', 'options' => array(0 => 'products', 1 => 'categories', 2 => 'Product', 3 => 'Category', ), 'inherited' => false, )), 'linking_off' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'label_nothing_selected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3532), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3532), 'inherited' => false, )), 'label_confirm_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(864), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(864), 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(849), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(849), 'inherited' => false, )), 'label_accessible_interface' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1100), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1100), 'inherited' => false, )), 'label_screen_reader_selected' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4133), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4133), 'inherited' => false, )), 'label_screen_reader_accessible_option' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3490), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3490), 'inherited' => false, )), 'label_all_values' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(843), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(843), 'inherited' => false, )), 'label_level' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(8667), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(8667), 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'search_on_select' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'treeview_css' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Url::getYUICodePath('gallery-treeview/assets/treeview-menu.css'), 'type' => 'STRING', 'default' => \RightNow\Utils\Url::getYUICodePath('gallery-treeview/assets/treeview-menu.css'), 'inherited' => false, )), 'show_confirm_button_in_dialog' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class FilterDropdown extends \RightNow\Libraries\Widget\Base {
function _standard_search_FilterDropdown_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <label for="rn_<?=$this->instanceID;?>_Options"><?=$this->data['js']['name'];?></label>
    <select id="rn_<?=$this->instanceID;?>_Options">
        <option value='<?='~any~';?>'><?=$this->data['attrs']['label_any'];?></option>
        <?
foreach($this->data['js']['list'] as $key => $value): $selected = '';
if($value['id'] === intval($this->data['js']['defaultValue'])) $selected = 'selected';?>
            <option value="<?=$value['id']?>" <?=$selected?>><?=htmlspecialchars($value['label'],
ENT_QUOTES, 'UTF-8');?></option>
        <?
endforeach;?>
    </select>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$list = $allFilters = array();
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $allFilters);
$filters = $this->CI->model('Report')->getFilterByName($this->data['attrs']['report_id'], $this->data['attrs']['filter_name'])->result;
if(!$filters){
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((1956)), $this->data['attrs']['filter_name'], $this->data['attrs']['report_id']));
return false;
}
$list = \RightNow\Utils\Framework::getOptlist($filters['optlist_id']);
$optlist = array();
$optionsToIgnore = explode(',', $this->data['attrs']['options_to_ignore']);
foreach ($list as $key => $value) {
if (is_int($key) && !in_array($key, $optionsToIgnore)) $optlist[] = array('id' => $key, 'label' => $value);
}
$defaultValue = $allFilters[$this->data['attrs']['filter_name']]->filters->data[0];
$this->data['js'] = array('filters' => $filters, 'name' => $filters['prompt'], 'list' => $optlist, 'defaultValue' => $defaultValue ?: $filters['default_value'], 'rnSearchType' => 'filterDropdown', 'searchName' => $this->data['attrs']['filter_name'] );
}
}
function _standard_search_FilterDropdown_header() {
$result = array( 'js_name' => 'RightNow.Widgets.FilterDropdown', 'library_name' => 'FilterDropdown', 'view_func_name' => '_standard_search_FilterDropdown_view', 'meta' => array ( 'controller_path' => 'standard/search/FilterDropdown', 'view_path' => 'standard/search/FilterDropdown', 'js_path' => 'standard/search/FilterDropdown', 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', 3 => '3.3', 4 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'category' => array ( 0 => 'Report Search', ), 'description' => 'rn:msg:(1458)', 'urlParameters' => array ( 'filtername' => array ( 'name' => 'rn:msg:(5167)', 'description' => 'rn:msg:(3583)', 'example' => 'customMenu/22', ), ), ), 'relativePath' => 'standard/search/FilterDropdown', 'widget_name' => 'FilterDropdown', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'filter_name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'required' => true, 'inherited' => false, )), 'label_any' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4573), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4573), 'inherited' => false, )), 'search_on_select' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'options_to_ignore' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'static_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class SortList extends \RightNow\Libraries\Widget\Base {
function _standard_search_SortList_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <label for="rn_<?=$this->instanceID;?>_Headings"><?=$this->data['attrs']['label_text']?></label>
    <select id="rn_<?=$this->instanceID;?>_Headings" class="rn_Headings">
        <option value="-1"><?=$this->data['attrs']['label_default']?></option>
        <?
foreach ($this->data['js']['headers'] as $key => $value): ?>
            <option value="<?=$value['col_id']?>" <?=($value['col_id'] === $this->data['js']['col_id']) ? 'selected="selected"' : '';?>><?=$value['heading']?></option>
        <?
endforeach;
?>
    </select>
    <label for="rn_<?=$this->instanceID;?>_Direction"><?=\RightNow\Utils\Config::getMessage((13826))?></label>
    <select id='rn_<?=$this->instanceID;?>_Direction' class="rn_Direction">
        <option value="1" <?=($this->data['js']['sort_direction']
=== 1) ? 'selected="selected"' : '';?>><?=$this->data['attrs']['label_ascending']?></option>
        <option value="2" <?=($this->data['js']['sort_direction']
=== 2) ? 'selected="selected"' : '';?>><?=$this->data['attrs']['label_descending']?></option>
    </select>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$filters = array();
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$headers = $this->CI->model('Report')->getReportHeaders($this->data['attrs']['report_id'], \RightNow\Utils\Framework::createToken($this->data['attrs']['report_id']), $filters, null)->result;
$this->data['js'] = array( 'headers' => $headers, 'col_id' => $filters['sort_args']['filters']['col_id'] ?: -1, 'sort_direction' => $filters['sort_args']['filters']['sort_direction'] ?: 1, 'searchName' => 'sort_args' );
}
}
function _standard_search_SortList_header() {
$result = array( 'js_name' => 'RightNow.Widgets.SortList', 'library_name' => 'SortList', 'view_func_name' => '_standard_search_SortList_view', 'meta' => array ( 'controller_path' => 'standard/search/SortList', 'view_path' => 'standard/search/SortList', 'js_path' => 'standard/search/SortList', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'category' => array ( 0 => 'Report Search', ), 'description' => 'rn:msg:(956)', 'urlParameters' => array ( 'sort' => array ( 'name' => 'rn:msg:(4602)', 'description' => 'rn:msg:(3586)', 'example' => 'sort/3,1', ), ), ), 'relativePath' => 'standard/search/SortList', 'widget_name' => 'SortList', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'label_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3716), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3716), 'inherited' => false, )), 'label_default' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(8659), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(8659), 'inherited' => false, )), 'label_ascending' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(8680), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(8680), 'inherited' => false, )), 'label_descending' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(8682), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(8682), 'inherited' => false, )), 'search_on_select' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'static_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
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
$result = array( 'js_name' => 'RightNow.Widgets.LoginDialog', 'library_name' => 'LoginDialog', 'view_func_name' => '_standard_login_LoginDialog_view', 'meta' => array ( 'controller_path' => 'standard/login/LoginDialog', 'view_path' => 'standard/login/LoginDialog', 'js_path' => 'standard/login/LoginDialog', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/LoginDialog.css', 1 => 'assets/themes/mobile/widgetCss/LoginDialog.css', ), 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(42108)', 'urlParameters' => array ( 'redirect' => array ( 'name' => 'rn:msg:(3354)', 'description' => 'rn:msg:(1761)', 'example' => 'redirect/home', ), 'username' => array ( 'name' => 'rn:msg:(4846)', 'description' => 'rn:msg:(3199)', 'example' => 'username/JohnDoe', ), ), ), 'relativePath' => 'standard/login/LoginDialog', 'widget_name' => 'LoginDialog', ), );
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
-->
</style>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>pages/account/questions/list.themes.standard.css' rel='stylesheet' type='text/css' media='all'/>
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
<?
$currentAttributeArray = array("rn_container" => "true", 'report_id' => '196','rn_container_id' => 'rnc_1');
\RightNow\Utils\Widgets::pushAttributesOntoStack($currentAttributeArray);
\RightNow\Utils\Widgets::$rnContainers["rnc_1"] = json_decode('{"report_id":"196","rn_container_id":"rnc_1"}');
?>
<div id="rn_PageTitle" class="rn_QuestionList">
    <div id="rn_SearchControls">
        <h1 class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::msgGetFrom((4693));?></h1>
        <form onsubmit="return false;">
            <div class="rn_SearchInput">
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/AdvancedSearchDialog',
array());
?>
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/KeywordText', array('label_text' => '' . \RightNow\Utils\Config::msgGetFrom((3520)) . '','initial_focus' => 'true',));
?>
            </div>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/SearchButton', array());
?>
        </form>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/DisplaySearchFilters', array());
?>
    </div>
</div>
<div id="rn_PageContent" class="rn_QuestionList">
    <div class="rn_Padding">
        <h2 class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::msgGetFrom((4476));?></h2>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/ResultInfo',
array());
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/Grid', array('label_caption' => '<span class=\'rn_ScreenReaderOnly\'>' . \RightNow\Utils\Config::msgGetFrom((3520)) . '</span>',));
?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/Paginator', array());
?>
    </div>
</div>
<? $attributes = \RightNow\Utils\Widgets::popAttributesFromStack();
if($attributes !== null && !array_key_exists("rn_container", $attributes)) \RightNow\Utils\Widgets::pushAttributesOntoStack($attributes);
?>
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
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=\RightNow\Utils\Url::getCoreAssetPath('js/6.232/min/RightNow.js');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>templates<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/login/LogoutLink', 1 => 'standard/login/LoginDialog', ), '/standard.js', '1495130941');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => '/euf/core/3.2.6/js/6.232/min/widgetHelpers/EventProvider.js', 1 => '/euf/core/3.2.6/js/6.232/min/widgetHelpers/SearchFilter.js', 2 => 'standard/search/AdvancedSearchDialog', 3 => 'standard/search/KeywordText', 4 => 'standard/search/SearchButton', 5 => 'standard/search/DisplaySearchFilters', 6 => 'standard/reports/ResultInfo', 7 => 'standard/reports/Grid', 8 => 'standard/reports/Paginator', 9 => 'standard/search/SearchTypeList', 10 => 'standard/search/WebSearchSort', 11 => 'standard/search/WebSearchType', 12 => 'standard/search/ProductCategorySearchFilter', 13 => 'standard/search/FilterDropdown', 14 => 'standard/search/SortList', ), '/account/questions/list.js', '1495130941');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'PRODUCT_LBL' => array ( 'value' => 4594, ), 'CATEGORY_LBL' => array ( 'value' => 4574, ), 'SEARCH_TYPE_LBL' => array ( 'value' => 9716, ), 'ORGANIZATION_LBL' => array ( 'value' => 7002, ), 'ASCENDING_LBL' => array ( 'value' => 8680, ), 'DESCENDING_LBL' => array ( 'value' => 8682, ), 'SORT_BY_COLUMN_LBL' => array ( 'value' => 45674, ), 'REVERSE_SORT_BY_COLUMN_LBL' => array ( 'value' => 45611, ), 'NO_RECORDS_FOUND_MSG' => array ( 'value' => 2819, ), 'SORTED_ASCENDING_LBL' => array ( 'value' => 46325, ), 'SORTED_DESCENDING_LBL' => array ( 'value' => 46326, ), 'CANCEL_CMD' => array ( 'value' => 849, ), 'SELECTION_PCT_S_ACTIVATE_LINK_JUMP_MSG' => array ( 'value' => 3544, ), 'PCT_S_LNKS_DEPTH_ANNOUNCED_MSG' => array ( 'value' => 3036, ), 'PCT_S_MUST_NOT_CONTAIN_SPACES_MSG' => array ( 'value' => 3042, ), 'USERNAME_LBL' => array ( 'value' => 4846, ), 'PCT_S_CONTAIN_DOUBLE_QUOTES_MSG' => array ( 'value' => 3005, ), 'PCT_S_CNT_THAN_MSG' => array ( 'value' => 3002, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
