<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/basic', 1 => '/euf/assets/themes/basic', 2 => array ( '/euf/assets/themes/basic' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/basic', ), ));
get_instance()->_checkMeta(array('javascript_module'=>'none', 'title'=>'' . \RightNow\Utils\Config::msgGetFrom((3854)) . '', 'template'=>'basic.php', 'clickstream'=>'incident_list', 'login_required'=>'true', 'force_https'=>'true'));
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
use RightNow\Utils\Url, RightNow\Utils\Text, RightNow\Utils\Config;
class BasicProductCategorySearchFilter extends \RightNow\Libraries\Widget\Base {
function _standard_search_BasicProductCategorySearchFilter_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID?>" class="<?= $this->classList ?>">
    <span class="rn_RefineLabel"><a href="<?=$this->data['resetUrl']?>"><?=$this->data['attrs']['label_title']?></a></span>
    <? if (!empty($this->data['selectedData'])): ?>
        <? for ($i = 0;
$i < count($this->data['selectedData']);
++$i): ?>
            <? if ($i < (count($this->data['selectedData']) - 1)): ?>
                <a href="<?=$this->data['selectedData'][$i]['url']?>"><?=$this->data['selectedData'][$i]['label']?></a> &gt;
            <? else: ?>
                <?=$this->data['selectedData'][$i]['label']?>
            <? endif;
?>
        <? endfor ?>
    <? endif;
?>
    <? if (!empty($this->data['levelData'])): ?>
        <ul>
            <?if($this->data['allowNextStep']):?>
            <li>
                <a href="<?=$this->data['applyUrl']?>"><?=$this->data['attrs']['label_all_values']?></a>
            </li>
            <?endif;?>
        <?
foreach ($this->data['levelData'] as $item): ?>
            <li>
                <a href="<?=$item['url']?>"><?=$item['label']?></a>
                <? if($item['hasChildren']): ?> &gt; <? endif;
?>
            </li>
        <? endforeach;
?>
        </ul>
    <? endif;
?>
    <div class="rn_AdvancedSearchButtons">
    <?if($this->data['allowNextStep']):?>
        <form class="rn_AdvancedSearchSubmit" method="get" action="<?=$this->data['applyUrl']?>">
            <div>
                <input type="submit" value="<?=$this->data['attrs']['label_search_button']?>" />
            </div>
        </form>
    <?endif;?>
        <form method="get" action="<?=$this->data['resetUrl']?>">
            <div>
                <input type="submit" value="<?=$this->data['attrs']['label_clear_filters_button']?>" />
            </div>
        </form>
    </div>
</div>
<?
}
const PRODUCT = 'Product';
const CATEGORY = 'Category';
private $pageUrl;
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->pageUrl = "/app/{$this->CI->page}"
. Url::getParametersFromList($this->data['attrs']['add_params_to_filter_url']);
$dataType = $this->data['attrs']['filter_type'] = (Text::stringContains(strtolower($this->data['attrs']['filter_type']), 'prod')) ? self::PRODUCT : self::CATEGORY;
if ($dataType === self::CATEGORY) {
$this->data['attrs']['label_all_values'] = ($this->data['attrs']['label_all_values'] === Config::getMessage((843))) ? Config::getMessage((842)) : $this->data['attrs']['label_all_values'];
$this->data['attrs']['label_title'] = ($this->data['attrs']['label_title'] === Config::getMessage((3532))) ? Config::getMessage((3529)) : $this->data['attrs']['label_title'];
}
$filters = array();
Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$filterType = strtolower($this->data['attrs']['filter_type'][0]);
if(!$filters[$filterType]->filters->optlist_id) {
echo $this->reportError(sprintf(Config::getMessage((1955)), $this->data['attrs']['filter_type'], $this->data['attrs']['report_id']));
return false;
}
$selectionData = $levelData = array();
$showSubItems = true;
$selectedItems = explode(',', $filters[$filterType]->filters->data[0] ?: Url::getParameter($filterType));
$selectedItem = end($selectedItems) ?: null;
if ($showSubItems) {
$linkingOn = $this->data['attrs']['linking_off'] ? false : $this->CI->model('Prodcat')->getLinkingMode();
if($linkingOn && $dataType === self::CATEGORY) {
$selectedProductID = explode(',', $filters['p']->filters->data[0] ?: Url::getParameter('p'));
$selectedProductID = end($selectedProductID) ?: null;
if($selectedProductID === null && $selectedItem){
$levelData = $this->CI->model('Prodcat')->getDirectDescendants($dataType, $selectedItem)->result;
}
else{
$linkedCategories = $this->CI->model('Prodcat')->getFormattedTree($dataType, $selectedItems, true, $selectedProductID)->result;
$levelData = $linkedCategories[$selectedItem] ?: $linkedCategories[0];
}
}
else{
$levelData = $this->CI->model('Prodcat')->getDirectDescendants($dataType, $selectedItem)->result;
}
}
$selectionData = ($selectedItem) ? $this->CI->model('Prodcat')->getFormattedChain($dataType, $selectedItem)->result : array();
$this->setUrlEndpoints($selectionData);
$this->data['levelData'] = $this->addUrlKeysAndEscapeLabels($levelData, $filterType);
$this->data['selectedData'] = $this->addUrlKeysAndEscapeLabels($selectionData, $filterType);
$this->data['resetUrl'] = Url::deleteParameter($this->pageUrl, $filterType) . Url::sessionParameter();
$this->data['allowNextStep'] = true;
if($this->data['attrs']['required'] && empty($this->data['selectedData']) && !empty($this->data['levelData'])){
$this->data['allowNextStep'] = false;
}
}
protected function setUrlEndpoints($selectionData){
$currentPage = Url::getShortEufAppUrl('sameAsCurrentPage', $this->CI->page);
$this->data['applyUrl'] = $this->data['attrs']['report_page_url'] ?: $currentPage;
$this->data['applyUrl'] .= Url::getParametersFromList($this->data['attrs']['add_params_to_search_url']) . Url::sessionParameter();
$productValueToAdd = $categoryValueToAdd = null;
if(($productValueToAdd = Url::getParameter('p')) === null && $this->data['attrs']['filter_type'] === self::PRODUCT && $selectionData){
$lastProduct = end($selectionData);
$productValueToAdd = $lastProduct['id'];
}
if(($categoryValueToAdd = Url::getParameter('c')) === null && $this->data['attrs']['filter_type'] === self::CATEGORY && $selectionData){
$lastCategory = end($selectionData);
$categoryValueToAdd = $lastCategory['id'];
}
if($productValueToAdd){
$this->data['applyUrl'] = Url::addParameter($this->data['applyUrl'], 'p', $productValueToAdd);
}
if($categoryValueToAdd){
$this->data['applyUrl'] = Url::addParameter($this->data['applyUrl'], 'c', $categoryValueToAdd);
}
}
protected function addUrlKeysAndEscapeLabels($items, $filterParameter) {
$augmentedItems = array();
if (is_array($items)) {
foreach ($items as $item) {
if ((isset($item['hasChildren']) && $item['hasChildren'] === true)) {
$item['url'] = Url::addParameter($this->pageUrl, $filterParameter, $item['id']) . Url::sessionParameter();
}
else {
$item['url'] = Url::addParameter($this->data['applyUrl'], $filterParameter, $item['id']);
}
$item['label'] = htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8');
$augmentedItems[] = $item;
}
}
return $augmentedItems;
}
}
function _standard_search_BasicProductCategorySearchFilter_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicProductCategorySearchFilter', 'view_func_name' => '_standard_search_BasicProductCategorySearchFilter_view', 'meta' => array ( 'controller_path' => 'standard/search/BasicProductCategorySearchFilter', 'view_path' => 'standard/search/BasicProductCategorySearchFilter', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/BasicProductCategorySearchFilter.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(43089)', 'urlParameters' => array ( 'p' => array ( 'name' => 'rn:msg:(4594)', 'description' => 'rn:msg:(1223)', 'example' => 'p/1,2,3', ), 'c' => array ( 'name' => 'rn:msg:(4574)', 'description' => 'rn:msg:(1247)', 'example' => 'c/1', ), ), ), 'relativePath' => 'standard/search/BasicProductCategorySearchFilter', 'widget_name' => 'BasicProductCategorySearchFilter', ), );
$result['meta']['attributes'] = array( 'label_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3532), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3532), 'inherited' => false, )), 'label_all_values' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(843), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(843), 'inherited' => false, )), 'label_search_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(6920), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(6920), 'inherited' => false, )), 'label_clear_filters_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43083), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(43083), 'inherited' => false, )), 'linking_off' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'filter_type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'products', 'type' => 'OPTION', 'default' => 'products', 'options' => array(0 => 'products', 1 => 'categories', 2 => 'Product', 3 => 'Category', ), 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'min' => 1, 'inherited' => false, )), 'add_params_to_search_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'STRING', 'default' => 'kw', 'inherited' => false, )), 'add_params_to_filter_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'p,c,kw,selectFilter,prodSelected,catSelected', 'type' => 'STRING', 'default' => 'p,c,kw,selectFilter,prodSelected,catSelected', 'inherited' => false, )), 'required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOL', 'default' => false, 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/answers/list', 'type' => 'STRING', 'default' => '/app/answers/list', 'inherited' => false, )), 'clear_filters_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/answers/list', 'type' => 'STRING', 'default' => '/app/answers/list', 'inherited' => false, )), );
return $result;
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
class BasicKeywordSearch extends \RightNow\Widgets\KeywordText {
function _standard_search_BasicKeywordSearch_view ($data) {
extract($data);
?><div class="<?=$this->classList?>">
    <form method="post" action="<?=$this->data['attrs']['report_page_url'] . $this->data['appendedParameters'] ?><?=\RightNow\Utils\Url::sessionParameter();?>">
        <div>
            <label for="rn_<?=$this->instanceID;?>_Text"><b><?=$this->data['attrs']['label_text'];?></b></label>
            <input id="rn_<?=$this->instanceID;?>_Text" name="kw" type="text" maxlength="255" value="<?=$this->data['js']['initialValue'];?>"/>
            <input type="submit" id="rn_<?=$this->instanceID;?>_Button" value="<?=$this->data['attrs']['label_button']?>"/><br/>
        </div>
    </form>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if (parent::getData() === false) return false;
$this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url'], array('kw'));
if ($this->data['js']['initialValue']) {
$this->data['js']['initialValue'] = str_replace(array("'", '"'), array('&#039;', '&quot;'), $this->data['js']['initialValue']);
}
if ($this->data['attrs']['report_page_url'] === '') $this->data['attrs']['report_page_url'] = "/app/{$this->CI->page}";
}
}
function _standard_search_BasicKeywordSearch_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicKeywordSearch', 'view_func_name' => '_standard_search_BasicKeywordSearch_view', 'meta' => array ( 'controller_path' => 'standard/search/BasicKeywordSearch', 'view_path' => 'standard/search/BasicKeywordSearch', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/BasicKeywordSearch.css', ), 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', ), ), 'extends' => array ( 'widget' => 'standard/search/KeywordText', 'versions' => array ( 0 => '1.0', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'info' => array ( 'description' => 'rn:msg:(4367)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(4496)', 'example' => 'kw/roam', ), ), ), 'relativePath' => 'standard/search/BasicKeywordSearch', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/search/KeywordText', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/search/KeywordText', ), 'widget_name' => 'BasicKeywordSearch', 'extends_php' => array ( 0 => 'standard/search/KeywordText', ), 'parent' => 'standard/search/KeywordText', ), );
$result['meta']['attributes'] = array( 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4693), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4693), 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'p,c', 'type' => 'STRING', 'default' => 'p,c', 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => true, )), 'label_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4690), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4690), 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
use \RightNow\Utils\Url, \RightNow\Utils\Config, \RightNow\Utils\Text;
class BasicDisplaySearchFilters extends \RightNow\Libraries\Widget\Base {
function _standard_search_BasicDisplaySearchFilters_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID?>" class="<?= $this->classList ?>">
<? for($i = 0;
$i < count($this->data['filters']);
++$i): ?>
        <? if (count($this->data['filters'][$i]['data']) > 0): ?>
            <a id="rn_<?=$this->instanceID .'_Remove_' . $i?>" href="<?=$this->getRemovalUrl($this->data['filters'][$i]['urlParameter'])?>">
                <?if($this->data['filters'][$i]['urlParameter'] === 'p'):?>
                <?=$this->data['attrs']['label_all_products']?>
                <?else:?>
                <?=$this->data['attrs']['label_all_categories']?>
                <?endif;?>
            </a> &gt;
        <?
endif;
?>
        <?if(count($this->data['filters'][$i]['data'])):?>
        <? foreach($this->data['filters'][$i]['data'] as $index => $filter): ?>
            <? if (isset($filter['linkUrl'])): ?>
                <a href="<?=$filter['linkUrl']?>" class="rn_FilterItem <?=$class?>" id="rn_<?=$this->instanceID?>_Filter<?=$filter['id']?>"><?=htmlspecialchars($filter['label'], ENT_QUOTES, 'UTF-8')?></a>
            <? else: ?>
                <?=htmlspecialchars($filter['label'], ENT_QUOTES, 'UTF-8')?>
            <? endif;
?>
            <?=($index === count($this->data['filters'][$i]['data']) - 1) ? '' : '&gt;'?>
        <? endforeach;
?>
        <br/>
        <?endif;?>
<?
endfor;
?>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$this->data['filters'] = array( $this->getFormattedFilter('p', $this->data['attrs']['label_product_title'], $this->getHierarchyData('p', trim($filters['p']->filters->data[0]))), $this->getFormattedFilter('c', $this->data['attrs']['label_category_title'], $this->getHierarchyData('c', trim($filters['c']->filters->data[0]))) );
}
protected function getHierarchyData($filterName, $chain) {
if (($chain = explode(',', $chain)) && ($ID = end($chain)) && ($chainData = $this->CI->model('Prodcat')->getFormattedChain(($filterName === 'p') ? 'Product' : 'Category', $ID)->result)) {
$currentUrl = Url::getShortEufAppUrl('sameAsCurrentPage', $this->CI->page) . Url::getParametersFromList($paramsToAddToUrl, array(($filterName !== 'p') ? 'p' : 'c'));
foreach($chainData as &$value) {
$value += array('linkUrl' => Url::addParameter($currentUrl, $filterName, $value['id']) . Url::sessionParameter());
}
unset($chainData[count($chainData) - 1]['linkUrl']);
return $chainData;
}
return array();
}
protected function getFormattedFilter($urlParameter, $typeLabel, $filterData) {
return array( 'urlParameter' => $urlParameter, 'label' => $typeLabel, 'data' => $filterData, );
}
public function getRemovalUrl($filterName) {
$url = Url::getShortEufAppUrl('sameAsCurrentPage', $this->CI->page) . Url::getParametersFromList($this->data['attrs']['add_params_to_url']);
return Url::deleteParameter($url, $filterName) . Url::sessionParameter();
}
}
function _standard_search_BasicDisplaySearchFilters_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicDisplaySearchFilters', 'view_func_name' => '_standard_search_BasicDisplaySearchFilters_view', 'meta' => array ( 'controller_path' => 'standard/search/BasicDisplaySearchFilters', 'view_path' => 'standard/search/BasicDisplaySearchFilters', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/BasicDisplaySearchFilters.css', ), 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(4191)', 'urlParameters' => array ( 'filter_name' => array ( 'name' => 'rn:msg:(1986)', 'description' => 'rn:msg:(4506)', 'example' => 'p/1,4,6', ), ), ), 'relativePath' => 'standard/search/BasicDisplaySearchFilters', 'widget_name' => 'BasicDisplaySearchFilters', ), );
$result['meta']['attributes'] = array( 'label_all_products' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(843), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(843), 'inherited' => false, )), 'label_all_categories' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(842), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(842), 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'p,c,kw', 'type' => 'STRING', 'default' => 'p,c,kw', 'inherited' => false, )), );
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
class BasicResultInfo extends \RightNow\Widgets\ResultInfo {
function _standard_reports_BasicResultInfo_view ($data) {
extract($data);
?><div class="<?= $this->classList ?>">
    <? ?>
    <?if(!$this->data['suggestionClass']):?>
    <div class="rn_Suggestion">
            <?=$this->data['attrs']['label_suggestion'];?>
            <?
for($i = 0;
$i < count($this->data['suggestionData']);
$i++): ?>
                <a href="<?=$this->data['js']['linkUrl'].$this->data['suggestionData'][$i].'/suggested/1'.$this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['suggestionData'][$i]?></a>&nbsp;
            <?
endfor;?>
    </div>
    <?endif;?>
    <?
?>
    <?if(!$this->data['spellClass']):?>
    <div class="rn_Spell">
        <?=$this->data['attrs']['label_spell'];?>
        <?if($this->data['spellData']):?>
        <a href="<?=$this->data['js']['linkUrl'].$this->data['spellData'].'/dym/1'.$this->data['appendedParameters'].
\RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['spellData'];?></a>
        <?endif;?>
    </div>
    <?endif;?>
    <?
?>
    <?if(!$this->data['noResultsClass']):?>
    <div class="rn_NoResults">
        <?=$this->data['attrs']['label_no_results'];?>
        <br/><br/>
        <?=$this->data['attrs']['label_no_results_suggestions'];?>
    </div>
    <?endif;?>
    <?
?>
    <? if($this->data['attrs']['display_results'] && !$this->data['resultClass']):?>
    <div class="rn_Results">
    <? if($this->data['searchQuery']):?>
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
</div><?
}
}
function _standard_reports_BasicResultInfo_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicResultInfo', 'view_func_name' => '_standard_reports_BasicResultInfo_view', 'meta' => array ( 'controller_path' => 'standard/reports/BasicResultInfo', 'view_path' => 'standard/reports/BasicResultInfo', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', ), ), 'extends' => array ( 'widget' => 'standard/reports/ResultInfo', 'versions' => array ( 0 => '1.1', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'info' => array ( 'description' => 'rn:msg:(43072)', ), 'relativePath' => 'standard/reports/BasicResultInfo', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/reports/ResultInfo', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/reports/ResultInfo', ), 'widget_name' => 'BasicResultInfo', 'extends_php' => array ( 0 => 'standard/reports/ResultInfo', ), 'parent' => 'standard/reports/ResultInfo', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (string)(176), 'type' => 'STRING', 'default' => (string)(176), 'inherited' => true, )), 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => true, )), 'label_suggestion' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2908), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2908), 'inherited' => true, )), 'label_dictionary' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3940), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3940), 'inherited' => true, )), 'label_spell' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4748), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4748), 'inherited' => true, )), 'label_no_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2820), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2820), 'inherited' => true, )), 'label_no_results_suggestions' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3851), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3851), 'inherited' => true, )), 'label_common' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4395), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4395), 'inherited' => true, )), 'label_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3409), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3409), 'inherited' => true, )), 'label_results_search_query' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3468), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3468), 'inherited' => true, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'p,c', 'type' => 'STRING', 'default' => 'p,c', 'inherited' => true, )), 'display_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), );
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
class BasicMultiline extends \RightNow\Widgets\Multiline {
function _standard_reports_BasicMultiline_view ($data) {
extract($data);
?><div class="<?=$this->classList?>">
    <? if(empty($this->data['reportData']['data'])): ?>
        <?=$this->data['attrs']['label_no_results'];?>
    <?
else: ?>
        <ul>
        <? $reportColumns = count($this->data['reportData']['headers']);
foreach($this->data['reportData']['data'] as $value): ?>
            <li>
                <span><?=$value[0];?></span><br/>
                <?
if($value[1]): ?>
                <span><?=$value[1];?></span><br/>
                <?
endif;
?>
                <? if($value[2]): ?>
                <span><?=$value[2];?></span><br/>
                <?
endif;
?>
                <? for ($i = 3;
$i < $reportColumns;
$i++): ?>
                    <? $header = $this->data['reportData']['headers'][$i];
?>
                    <? if ($this->showColumn($value[$i], $header)): ?>
                    <span><?=$this->getHeader($header);?></span>
                    <span><?=$value[$i];?></span><br/>
                    <?
endif;
?>
                <? endfor;
?>
            </li>
        <? endforeach;
?>
        </ul>
    <? endif;
?>
</div>
<? }
}
function _standard_reports_BasicMultiline_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicMultiline', 'view_func_name' => '_standard_reports_BasicMultiline_view', 'meta' => array ( 'controller_path' => 'standard/reports/BasicMultiline', 'view_path' => 'standard/reports/BasicMultiline', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/BasicMultiline.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', ), ), 'extends' => array ( 'widget' => 'standard/reports/Multiline', 'versions' => array ( 0 => '1.1', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'info' => array ( 'description' => 'rn:msg:(43070)', ), 'relativePath' => 'standard/reports/BasicMultiline', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/reports/Multiline', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/reports/Multiline', ), 'widget_name' => 'BasicMultiline', 'extends_php' => array ( 0 => 'standard/reports/Multiline', ), 'parent' => 'standard/reports/Multiline', ), );
$result['meta']['attributes'] = array( 'truncate_size' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 100, 'type' => 'INT', 'default' => 100, 'min' => 1, 'inherited' => false, )), 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'inherited' => true, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => true, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'STRING', 'default' => 'kw', 'inherited' => true, )), 'max_wordbreak_trunc' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'min' => 0, 'inherited' => true, )), 'date_format' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'short', 'type' => 'OPTION', 'default' => 'short', 'options' => array(0 => 'short', 1 => 'date_time', 2 => 'long', 3 => 'raw', ), 'inherited' => true, )), 'hide_empty_columns' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), );
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
class BasicPaginator extends \RightNow\Widgets\Paginator {
function _standard_reports_BasicPaginator_view ($data) {
extract($data);
?><div class="<?= $this->classList ?>">
    <? if($this->data['attrs']['back_icon_path']):?>
        <a href="<?=$this->data['js']['backPageUrl'] . $this->data['appendedParameters'];?>" class="<?=$this->data['backClass'];?>"><img src="<?=$this->data['attrs']['back_icon_path'];?>" alt="<?=$this->data['attrs']['label_back'];?>"/></a>
    <?
else:?>
        <a href="<?=$this->data['js']['backPageUrl'] . $this->data['appendedParameters'];?>" class="<?=$this->data['backClass'];?>"><?=$this->data['attrs']['label_back'];?></a>
    <?
endif;?>
    <span class="rn_PageLinks">
        <?
for($i = $this->data['js']['startPage'];
$i <= $this->data['js']['endPage'];
$i++):?>
            <? if($i == $this->data['js']['currentPage']):?>
                <span class="rn_CurrentPage"><?=$i;?></span>
            <?
else:?>
                <a href="<?=$this->data['js']['pageUrl'] . $i . $this->data['appendedParameters'];?>" title="<?printf($this->data['attrs']['label_page'],$i,
$this->data['totalPages']);?>" class="test"><?=$i;?></a>
            <?
endif;?>
        <?
endfor;?>
    </span>
    <?
if($this->data['attrs']['forward_icon_path']):?>
        <a href="<?=$this->data['js']['forwardPageUrl'] . $this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter();?>" class="<?=$this->data['forwardClass'];?>"><img src="<?=$this->data['attrs']['forward_icon_path']?>" alt="<?=$this->data['attrs']['label_forward']?>"/></a>
    <?
else:?>
        <a href="<?=$this->data['js']['forwardPageUrl'] . $this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter();?>" class="<?=$this->data['forwardClass'];?>"><?=$this->data['attrs']['label_forward']?></a>
    <?
endif;?>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if (parent::getData() === false) return false;
$this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']);
}
}
function _standard_reports_BasicPaginator_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicPaginator', 'view_func_name' => '_standard_reports_BasicPaginator_view', 'meta' => array ( 'controller_path' => 'standard/reports/BasicPaginator', 'view_path' => 'standard/reports/BasicPaginator', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', ), ), 'extends' => array ( 'widget' => 'standard/reports/Paginator', 'versions' => array ( 0 => '1.0', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'info' => array ( 'description' => 'rn:msg:(43071)', ), 'relativePath' => 'standard/reports/BasicPaginator', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/reports/Paginator', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/reports/Paginator', ), 'widget_name' => 'BasicPaginator', 'extends_php' => array ( 0 => 'standard/reports/Paginator', ), 'parent' => 'standard/reports/Paginator', ), );
$result['meta']['attributes'] = array( 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'p,c,kw', 'type' => 'STRING', 'default' => 'p,c,kw', 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => true, )), 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => true, )), 'maximum_page_links' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 6, 'type' => 'INT', 'default' => 6, 'inherited' => true, )), 'forward_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'back_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'label_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2921), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2921), 'inherited' => true, )), 'label_forward' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2807), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2807), 'inherited' => true, )), 'label_back' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2643), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2643), 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ClickjackPrevention extends \RightNow\Libraries\Widget\Base {
function _standard_utils_ClickjackPrevention_view ($data) {
extract($data);
?><? ?>
<script type="text/javascript">
<!--
if (parent !== self) {
    top.location.href = location.href;
}
else if (top !== self) {
    top.location.href = self.document.location;
}
//-->
</script>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
header("X-Frame-Options:DENY");
}
}
function _standard_utils_ClickjackPrevention_header() {
$result = array( 'js_name' => '', 'library_name' => 'ClickjackPrevention', 'view_func_name' => '_standard_utils_ClickjackPrevention_view', 'meta' => array ( 'controller_path' => 'standard/utils/ClickjackPrevention', 'view_path' => 'standard/utils/ClickjackPrevention', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(45063)', ), 'relativePath' => 'standard/utils/ClickjackPrevention', 'widget_name' => 'ClickjackPrevention', ), );
$result['meta']['attributes'] = array( );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Text, RightNow\Utils\Url;
class CapabilityDetector extends \RightNow\Libraries\Widget\Base {
function _standard_utils_CapabilityDetector_view ($data) {
extract($data);
?><div class="<?=$this->classList?>" id="rn_<?=$this->instanceID?>">
    <? if($this->data['label_tests_fail']): ?>
    <noscript>
        <div class="MessageContainer MessageContainerFailure">
            <?= $this->data['label_tests_fail'] ?>
        </div>
    </noscript>
    <? endif;
?>
    <div id="rn_<?=$this->instanceID?>_MessageContainer">
    </div>
    <? ?>
    <?='<' . 'script type="text/javascript"><!' . "-- \n /*<![" . 'CDATA[*/'?>
(function () {
    var runJSTests = function() {
        var messageContainerDiv = document.getElementById('rn_<?= $this->instanceID ?>_MessageContainer');
        function showFailure() {
            <? if($this->data['label_tests_fail']): ?>
            messageContainerDiv.className = 'MessageContainer MessageContainerFailure';
            messageContainerDiv.innerHTML = '<?= str_replace("'", "\'", $this->data['label_tests_fail']) ?>';
            <? endif;
?>
            <? if($this->data['automatically_redirect']): ?>
            window.location = '<?= $this->data['link_tests_fail'] ?>';
            <? endif;
?>
        }
        <? if($this->data['runJSTests']): ?>
        <? if($this->data['attrs']['display_if_no_xhr_object']): ?>
        function xhrTestFails() {
            return !window.XMLHttpRequest;
        }
        if(typeof RightNowTesting !== 'undefined' && RightNowTesting._isTesting) {
            RightNowTesting._xhrTestFails = xhrTestFails;
        }
        if (xhrTestFails()) {
            showFailure();
            return;
        }
        <? endif;
?>
        <? endif;
?>
        <? if($this->data['showSuccessMessage']): ?>
        messageContainerDiv.className = 'MessageContainer MessageContainerSuccess';
        messageContainerDiv.innerHTML = '<?= str_replace("'", "\'", $this->data['label_tests_pass']) ?>';
        <? endif;
?>
    }
    if(typeof RightNowTesting !== 'undefined' && RightNowTesting._isTesting) {
        RightNowTesting._runJSTests = runJSTests;
    }
    runJSTests();
})();
    <?='/*]' . ']>*/ // --></' . 'script>'?>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if($this->data['attrs']['fail_page_set'] === $this->data['attrs']['pass_page_set']) {
echo $this->reportError(\RightNow\Utils\Config::getMessage((43090)));
return false;
}
$currentPageSetPath = $this->CI->getPageSetPath() ?: 'default';
$automaticallyRedirect = $this->data['attrs']['automatically_redirect_on_failure'];
$pageSetInvalid = false;
$this->data['runJSTests'] = true;
$this->data['showSuccessMessage'] = $this->data['attrs']['display_tests_pass'];
$this->data['link_tests_fail'] = '/ci/redirect/pageSet/' . urlencode($this->data['attrs']['fail_page_set']) . '/' . Url::deleteParameter(Text::getSubstringAfter($_SERVER['REQUEST_URI'], "/app/"), 'session') . Url::sessionParameter();
$this->data['label_tests_fail'] = sprintf($this->data['attrs']['label_tests_fail'], $this->data['link_tests_fail']);
$this->data['label_tests_pass'] = sprintf($this->data['attrs']['label_tests_pass'], '/ci/redirect/pageSet/' . urlencode($this->data['attrs']['pass_page_set']) . '/' . Url::deleteParameter(Text::getSubstringAfter($_SERVER['REQUEST_URI'], "/app/"), 'session') . Url::sessionParameter());
$enabledPageSetMappings = $this->CI->model('Pageset')->getEnabledPageSetMappingArrays();
if($currentPageSetPath === $this->data['attrs']['fail_page_set']) {
$automaticallyRedirect = false;
$this->data['link_tests_fail'] = '';
$this->data['label_tests_fail'] = '';
}
else if($currentPageSetPath === $this->data['attrs']['pass_page_set']) {
$this->data['showSuccessMessage'] = false;
}
if($this->data['attrs']['fail_page_set'] !== 'default' && !isset($enabledPageSetMappings[$this->data['attrs']['fail_page_set']])) {
$automaticallyRedirect = false;
$this->data['link_tests_fail'] = '';
$this->data['label_tests_fail'] = $this->data['attrs']['label_no_link'];
$this->data['runJSTests'] = $this->data['attrs']['perform_javascript_checks_with_no_link'];
}
if($this->data['attrs']['pass_page_set'] !== 'default' && !isset($enabledPageSetMappings[$this->data['attrs']['pass_page_set']])) {
$this->data['showSuccessMessage'] = false;
$this->data['label_tests_pass'] = '';
}
if(!$this->data['link_tests_fail'] && !$this->data['label_tests_pass']) {
echo $this->reportError(\RightNow\Utils\Config::getMessage((43091)));
return false;
}
$this->data['automatically_redirect'] = $automaticallyRedirect;
if($automaticallyRedirect) {
$this->CI->clientLoader->addHeadContent('<noscript><META http-equiv="refresh" content="0;URL=' . $this->data['link_tests_fail'] . '"></noscript>');
}
}
}
function _standard_utils_CapabilityDetector_header() {
$result = array( 'js_name' => '', 'library_name' => 'CapabilityDetector', 'view_func_name' => '_standard_utils_CapabilityDetector_view', 'meta' => array ( 'controller_path' => 'standard/utils/CapabilityDetector', 'view_path' => 'standard/utils/CapabilityDetector', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/CapabilityDetector.css', 1 => 'assets/themes/mobile/widgetCss/CapabilityDetector.css', 2 => 'assets/themes/standard/widgetCss/CapabilityDetector.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(43106)', ), 'relativePath' => 'standard/utils/CapabilityDetector', 'widget_name' => 'CapabilityDetector', ), );
$result['meta']['attributes'] = array( 'automatically_redirect_on_failure' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'bool', 'default' => false, 'inherited' => false, )), 'display_if_no_xhr_object' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'bool', 'default' => true, 'inherited' => false, )), 'display_tests_pass' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'bool', 'default' => false, 'inherited' => false, )), 'label_tests_fail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43112), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(43112), 'inherited' => false, )), 'label_no_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43111), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(43111), 'inherited' => false, )), 'label_tests_pass' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43113), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(43113), 'inherited' => false, )), 'fail_page_set' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'basic', 'type' => 'string', 'default' => 'basic', 'inherited' => false, )), 'pass_page_set' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'default', 'type' => 'string', 'default' => 'default', 'inherited' => false, )), 'perform_javascript_checks_with_no_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'bool', 'default' => true, 'inherited' => false, )), );
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
class BasicLogoutLink extends \RightNow\Widgets\LogoutLink {
function _standard_login_BasicLogoutLink_view ($data) {
extract($data);
?><span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <a id="rn_<?=$this->instanceID;?>_LogoutLink" href="/ci/openlogin/logout/<?=$this->data['redirectUrl'];?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['attrs']['label'];?></a>
</span>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if (parent::getData() === false) {
return false;
}
$this->data['redirectUrl'] = $redirectUrl = $this->data['js']['redirectLocation'];
if ($redirectUrl && \RightNow\Utils\Text::beginsWith($redirectUrl, '/')) {
$this->data['redirectUrl'] = substr($redirectUrl, 1);
}
}
}
function _standard_login_BasicLogoutLink_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicLogoutLink', 'view_func_name' => '_standard_login_BasicLogoutLink_view', 'meta' => array ( 'controller_path' => 'standard/login/BasicLogoutLink', 'view_path' => 'standard/login/BasicLogoutLink', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/BasicLogoutLink.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(43068)', ), 'extends' => array ( 'widget' => 'standard/login/LogoutLink', 'versions' => array ( 0 => '1.0', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'relativePath' => 'standard/login/BasicLogoutLink', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/login/LogoutLink', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/login/LogoutLink', ), 'widget_name' => 'BasicLogoutLink', 'extends_php' => array ( 0 => 'standard/login/LogoutLink', ), 'parent' => 'standard/login/LogoutLink', ), );
$result['meta']['attributes'] = array( 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(42023), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(42023), 'inherited' => true, )), 'redirect_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'inherited' => true, )), );
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN" "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
<html lang="<?=\RightNow\Utils\Text::getLanguageCode();?>">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <title><?=\RightNow\Utils\Tags::getPageTitleAtRuntime();?></title>
        <style type="text/css">
            <!--
            #rn_SkipNav a{
                left:0px;
                height:1px;
                overflow:hidden;
                position:absolute;
                top:-500px;
                width:1px;
            }
            #rn_SkipNav a:active, #rn_SkipNav a:focus{
                background-color:#FFF;
                height:auto;
                left:auto;
                top:auto;
                width:auto;
            }
            .rn_Header{
                font-weight:bold;
                font-size:18pt;
            }
            .rn_LinksBlock a{
                display:block;
                margin-bottom:10px;
            }
            a img{
                border:0;
            }
            .rn_CenterText{
                text-align:center;
            }
            h1{
                font-weight:bold;
                font-size:16pt;
                line-height:1.4em;
                margin:0;
                padding:0;
            }
            h2{
                font-size:14pt;
                line-height:1.3em;
                margin:0;
                padding:0;
            }
            h3{
                font-size:12pt;
                line-height:1.2em;
                margin:0;
                padding:0;
            }
            -->
        </style>
        <?=
\RightNow\Libraries\SEO::getCanonicalLinkTag() . "\n";
?>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<style type='text/css'>
 <!-- 
.rn_ScreenReaderOnly{position:absolute; height:1px; left:-10000px; overflow:hidden; top:auto; width:1px;}
.rn_Hidden{display:none;}
 --></style>
<base href='<?=\RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest', \RightNow\Utils\FileSystem::getOptimizedAssetsDir() . 'themes/basic/');?>'></base>
<style type="text/css">
<!--
.rn_CapabilityDetector .MessageContainer{font-size: 1.5em;line-height: 1em;padding: 10px;text-align: center;border-style: solid;border-width: 2px;}
.rn_BasicLogoutLink{display:inline-block;}
.rn_PageSetSelector{margin: 10px 0;display: block;}
.rn_BasicProductCategorySearchFilter .rn_RefineLabel{font-weight: bold;font-size: 1em;}
.rn_BasicKeywordSearch input[type=text]{width: 63%;max-width: 350px;}
.rn_BasicDisplaySearchFilters .rn_SearchFilterTitle{font-weight: bold;font-size: 1em;}
.rn_BasicDisplaySearchFilters .rn_SearchFilterLabel{font-weight: bold;}
.rn_BasicMultiline ul{padding: 0;}
.rn_BasicMultiline ul li{list-style: none;margin-bottom: 10px;}
-->
</style>
9c1379bc-cca6-4750-aee7-188f8348a6c3
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/ClickjackPrevention',
array());
?>
    </head>
    <body>
        <div id="rn_SkipNav"><a href="<?=ORIGINAL_REQUEST_URI?>#rn_MainContent"><?=\RightNow\Utils\Config::msgGetFrom((3673));?></a></div>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/CapabilityDetector',
array());
?>
        <div class="rn_Header rn_CenterText"><?=\RightNow\Utils\Config::msgGetFrom((43198));?></div>
        <hr/>
        <div class="rn_CenterText">
            <a href="/app/<?=\RightNow\Utils\Config::configGetFrom((226));?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2097));?></a>&nbsp;|
            <a href="/app/ask<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((1748));?></a>&nbsp;|
            <a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((43191));?></a>
        </div>
        <hr/>
        <div><a id="rn_MainContent"></a></div>
<?
$currentAttributeArray = array("rn_container" => "true", 'report_id' => '196','rn_container_id' => 'rnc_1');
\RightNow\Utils\Widgets::pushAttributesOntoStack($currentAttributeArray);
\RightNow\Utils\Widgets::$rnContainers["rnc_1"] = json_decode('{"report_id":"196","rn_container_id":"rnc_1"}');
?>
    <?if( (\RightNow\Utils\Url::getParameter('selectFilter') == 'product') ):?>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/BasicProductCategorySearchFilter', array('report_page_url' => '/app/account/questions/list','clear_filters_page_url' => '/app/account/questions/list',));
?>
    <?else:?>
        <?if( (\RightNow\Utils\Url::getParameter('selectFilter') == 'category') ):?>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/BasicProductCategorySearchFilter', array('filter_type' => 'categories','report_page_url' => '/app/account/questions/list','clear_filters_page_url' => '/app/account/questions/list','label_clear_filters_button' => '' . \RightNow\Utils\Config::msgGetFrom((43193)) . '',));
?>
        <?else:?>
            <h1 class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::msgGetFrom((4693));?></h1>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/BasicKeywordSearch',
array('label_text' => '',));
?>
            <div>
                <a href="/app/account/questions/list/selectFilter/product/<?=\RightNow\Utils\Url::getParameterWithKey('c');?>/<?=\RightNow\Utils\Url::getParameterWithKey('kw');?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2562));?></a><br/>
                <a href="/app/account/questions/list/selectFilter/category/<?=\RightNow\Utils\Url::getParameterWithKey('p');?>/<?=\RightNow\Utils\Url::getParameterWithKey('kw');?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2561));?></a>
            </div>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/BasicDisplaySearchFilters',
array());
?>
            <hr/>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/BasicResultInfo', array());
?>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/BasicMultiline', array());
?>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/BasicPaginator', array());
?>
        <?endif;?>
    <?endif;?>
<?
$attributes = \RightNow\Utils\Widgets::popAttributesFromStack();
if($attributes !== null && !array_key_exists("rn_container", $attributes)) \RightNow\Utils\Widgets::pushAttributesOntoStack($attributes);
?>
        <hr/>
        <div class="rn_CenterText">
            <?if( (\RightNow\Utils\Framework::isLoggedIn()) ):?>
                <strong><?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array ( 0 => 'Contact', 1 => 'LookupName', ), false);?><?if(
(in_array(strtolower(\RightNow\Utils\Text::getLanguageCode()), array("ja-jp"))) ):?><?=\RightNow\Utils\Config::msgGetFrom((7023));?><?endif;?></strong>&nbsp;|
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/BasicLogoutLink',
array('label' => '' . \RightNow\Utils\Config::msgGetFrom((5280)) . '',));
?>&nbsp;|
                <a href="/app/account/overview<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((4436));?></a>
            <?else:?>
                <?if(
(\RightNow\Utils\Config::getConfig(372) == true) ):?>
                    <a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a>&nbsp;|
                    <a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((3650));?></a>
                <?else:?>
                    <a href="/app/<?=\RightNow\Utils\Config::configGetFrom((229));?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a>&nbsp;|
                    <a href="/app/utils/create_account<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((3650));?></a>
                <?endif;?>
            <?endif;?>
            <br/>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/PageSetSelector',
array('label_message' => '',));
?>
        </div>
<?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
