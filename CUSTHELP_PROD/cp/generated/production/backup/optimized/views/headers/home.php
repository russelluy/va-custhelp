<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/standard', 1 => '/euf/assets/themes/standard', 2 => array ( '/euf/assets/themes/standard' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/standard', ), ));
get_instance()->_checkMeta(array('title'=>'' . \RightNow\Utils\Config::msgGetFrom((4525)) . '', 'template'=>'standard.php', 'clickstream'=>'home'));
get_instance()->clientLoader->setJavaScriptModule(get_instance()->meta['javascript_module']);
}
namespace Custom\Libraries\Widgets {
class CustomSharedViewPartials extends \RightNow\Libraries\Widgets\SharedViewPartials {
static function sample_view ($data) {
extract($data);
?>sample custom shared view partial<? }
}
}
namespace Custom\Widgets\display{
class CustomInfoButton extends \RightNow\Libraries\Widget\Base {
function _custom_display_CustomInfoButton_view ($data) {
extract($data);
?><div id="rn_<?= $this->instanceID ?>" class="rn_InfoButton <?= $this->classList ?>">
    <? if ($this->data['attrs']['icon_path']):?>
        <input type="image" class="rn_SubmitImage" id="rn_<?=$this->instanceID;?>_SubmitButton" 
        		<?=tabindex($this->data['attrs']['tabindex'],
1);?>	src="<?=$this->data['attrs']['icon_path'];?>" 
        		alt="<?=$this->data['attrs']['icon_alt_text'];?>" 
        		title="<?=$this->data['attrs']['label_button'];?>"/>
    <?
else:?>
        <input type="submit" class="rn_InfoButton" id="rn_<?=$this->instanceID;?>_SubmitButton" 
        		<?=tabindex($this->data['attrs']['tabindex'],
1);?>	value="<?=$this->data['attrs']['label_button'];?>" />
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
class ProductCategoryList extends \RightNow\Libraries\Widget\Base {
function _standard_search_ProductCategoryList_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <?= $this->data['attrs']['label_title'] ? "<h2>{$this->data['attrs']['label_title']}</h2>"
: "" ?>
    <? $index = 1;
foreach($this->data['results'] as $key => $value):?>
    <div class="rn_HierList rn_HierList_<?=$key;?> <?if($index
% 2) echo 'rn_FloatLeft';else
echo 'rn_FloatRight';?>">
    <h3><a href="<?=$this->data['attrs']['report_page_url'].
$this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter() . "/{$this->data['type']}/".
$value['hierList'];?>"><?=htmlspecialchars($value['label'],
ENT_QUOTES, 'UTF-8');?></a></h3>
        <?
if(count($value['subItems'])):?>
        <ul>
        <? for($i = 0;
$i < count($value['subItems']);
$i++):?>
        <li><a href="<?=$this->data['attrs']['report_page_url'] . $this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter() . "/{$this->data['type']}/".
$value['subItems'][$i]['hierList'];?>"><?=htmlspecialchars($value['subItems'][$i]['label'],
ENT_QUOTES, 'UTF-8');?></a></li>
        <?
endfor;?>
        </ul>
        <?
endif;?>    
    </div>
    <?
$index++;
endforeach;?>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['attrs']['data_type'] = strtolower($this->data['attrs']['data_type']);
$topLevelIDs = $this->data['attrs']['only_display'];
$this->data['results'] = $this->CI->model('Prodcat')->getHierarchy( $this->data['attrs']['data_type'], $this->data['attrs']['levels'], $this->data['attrs']['maximum_top_levels'], $topLevelIDs ? explode(',', $topLevelIDs) : array() )->result;
if($this->data['attrs']['add_params_to_url']) {
$this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']);
}
if(!count($this->data['results'])) {
return false;
}
$this->data['type'] = ($this->data['attrs']['data_type'] === 'products') ? 'p' : 'c';
}
}
function _standard_search_ProductCategoryList_header() {
$result = array( 'js_name' => '', 'library_name' => 'ProductCategoryList', 'view_func_name' => '_standard_search_ProductCategoryList_view', 'meta' => array ( 'controller_path' => 'standard/search/ProductCategoryList', 'view_path' => 'standard/search/ProductCategoryList', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ProductCategoryList.css', ), 'base_css' => array ( 0 => 'standard/search/ProductCategoryList/base.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', ), ), 'info' => array ( 'description' => 'rn:msg:(4278)', ), 'relativePath' => 'standard/search/ProductCategoryList', 'widget_name' => 'ProductCategoryList', ), );
$result['meta']['attributes'] = array( 'data_type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'products', 'type' => 'OPTION', 'default' => 'products', 'options' => array(0 => 'products', 1 => 'categories', ), 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/answers/list', 'type' => 'STRING', 'default' => '/app/answers/list', 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1890), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1890), 'inherited' => false, )), 'only_display' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'maximum_top_levels' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 30, 'type' => 'INT', 'default' => 30, 'min' => 1, 'max' => 30, 'inherited' => false, )), 'levels' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 2, 'type' => 'INT', 'default' => 2, 'min' => 1, 'max' => 2, 'inherited' => false, )), );
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
class AdvancedSearchDialog extends \RightNow\Libraries\Widget\Base {
function _standard_search_AdvancedSearchDialog_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
$result = array( 'js_name' => 'RightNow.Widgets.AdvancedSearchDialog', 'library_name' => 'AdvancedSearchDialog', 'view_func_name' => '_standard_search_AdvancedSearchDialog_view', 'meta' => array ( 'controller_path' => 'standard/search/AdvancedSearchDialog', 'view_path' => 'standard/search/AdvancedSearchDialog', 'js_path' => 'standard/search/AdvancedSearchDialog', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/AdvancedSearchDialog.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4201)', ), 'contains' => array ( 0 => array ( 'widget' => 'standard/search/KeywordText', 'versions' => array ( 0 => '1.0', ), ), 1 => array ( 'widget' => 'standard/search/SearchTypeList', 'versions' => array ( 0 => '1.0', ), ), 2 => array ( 'widget' => 'standard/search/WebSearchSort', 'versions' => array ( 0 => '1.0', ), ), 3 => array ( 'widget' => 'standard/search/WebSearchType', 'versions' => array ( 0 => '1.1', ), ), 4 => array ( 'widget' => 'standard/search/ProductCategorySearchFilter', 'versions' => array ( 0 => '1.0', ), ), 5 => array ( 'widget' => 'standard/search/FilterDropdown', 'description' => 'rn:msg:(46196)', 'versions' => array ( 0 => '1.0', ), ), 6 => array ( 'widget' => 'standard/search/SortList', 'versions' => array ( 0 => '1.1', ), ), ), 'relativePath' => 'standard/search/AdvancedSearchDialog', 'widget_name' => 'AdvancedSearchDialog', ), );
$result['meta']['attributes'] = array( 'label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4479), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4479), 'inherited' => false, )), 'label_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4479), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4479), 'inherited' => false, )), 'label_search_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(6920), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(6920), 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9555), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9555), 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'search_tips_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/utils/help_search', 'type' => 'STRING', 'default' => '/app/utils/help_search', 'inherited' => false, )), 'display_products_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'display_categories_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'display_sort_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'additional_filters' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace Custom\Widgets\util{
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
$result = array( 'js_name' => 'RightNow.Widgets.SearchTypeList', 'library_name' => 'SearchTypeList', 'view_func_name' => '_standard_search_SearchTypeList_view', 'meta' => array ( 'controller_path' => 'standard/search/SearchTypeList', 'view_path' => 'standard/search/SearchTypeList', 'js_path' => 'standard/search/SearchTypeList', 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(42110)', 'urlParameters' => array ( 'st' => array ( 'name' => 'rn:msg:(9716)', 'description' => 'rn:msg:(4494)', 'example' => 'st/6', ), ), ), 'relativePath' => 'standard/search/SearchTypeList', 'widget_name' => 'SearchTypeList', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'label_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9716), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9716), 'inherited' => false, )), 'search_on_select' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'search_type_only' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'filter_list' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
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
$result = array( 'js_name' => 'RightNow.Widgets.WebSearchSort', 'library_name' => 'WebSearchSort', 'view_func_name' => '_standard_search_WebSearchSort_view', 'meta' => array ( 'controller_path' => 'standard/search/WebSearchSort', 'view_path' => 'standard/search/WebSearchSort', 'js_path' => 'standard/search/WebSearchSort', 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(1648)', 'urlParameters' => array ( 'sort' => array ( 'name' => 'rn:msg:(4602)', 'description' => 'rn:msg:(3587)', 'example' => 'sort/3', ), ), ), 'relativePath' => 'standard/search/WebSearchSort', 'widget_name' => 'WebSearchSort', ), );
$result['meta']['attributes'] = array( 'label_sort' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4602), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4602), 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (10022), 'type' => 'OPTION', 'default' => (10022), 'options' => array(0 => '10022', 1 => '10016', ), 'inherited' => false, )), );
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
$result = array( 'js_name' => 'RightNow.Widgets.WebSearchType', 'library_name' => 'WebSearchType', 'view_func_name' => '_standard_search_WebSearchType_view', 'meta' => array ( 'controller_path' => 'standard/search/WebSearchType', 'view_path' => 'standard/search/WebSearchType', 'js_path' => 'standard/search/WebSearchType', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(1649)', 'urlParameters' => array ( 'st' => array ( 'name' => 'rn:msg:(3500)', 'description' => 'rn:msg:(4494)', 'example' => 'st/2', ), ), ), 'relativePath' => 'standard/search/WebSearchType', 'widget_name' => 'WebSearchType', ), );
$result['meta']['attributes'] = array( 'label_search' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4583), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4583), 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (10022), 'type' => 'OPTION', 'default' => (10022), 'options' => array(0 => '10022', 1 => '10016', ), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Text;
class ProductCategorySearchFilter extends \RightNow\Libraries\Widget\Base {
function _standard_search_ProductCategorySearchFilter_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
$result = array( 'js_name' => 'RightNow.Widgets.ProductCategorySearchFilter', 'library_name' => 'ProductCategorySearchFilter', 'view_func_name' => '_standard_search_ProductCategorySearchFilter_view', 'meta' => array ( 'controller_path' => 'standard/search/ProductCategorySearchFilter', 'view_path' => 'standard/search/ProductCategorySearchFilter', 'js_path' => 'standard/search/ProductCategorySearchFilter', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/ProductCategorySearchFilter.css', ), 'base_css' => array ( 0 => 'standard/search/ProductCategorySearchFilter/base.css', ), 'version' => '1.0.3', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', ), 'yui' => array ( 0 => 'panel', 1 => 'gallery-treeview', ), ), 'info' => array ( 'description' => 'rn:msg:(4271)', 'urlParameters' => array ( 'p' => array ( 'name' => 'rn:msg:(4594)', 'description' => 'rn:msg:(1223)', 'example' => 'p/1,2,3', ), 'c' => array ( 'name' => 'rn:msg:(4574)', 'description' => 'rn:msg:(1247)', 'example' => 'c/1', ), ), ), 'relativePath' => 'standard/search/ProductCategorySearchFilter', 'widget_name' => 'ProductCategorySearchFilter', ), );
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
$result = array( 'js_name' => 'RightNow.Widgets.FilterDropdown', 'library_name' => 'FilterDropdown', 'view_func_name' => '_standard_search_FilterDropdown_view', 'meta' => array ( 'controller_path' => 'standard/search/FilterDropdown', 'view_path' => 'standard/search/FilterDropdown', 'js_path' => 'standard/search/FilterDropdown', 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(1458)', 'urlParameters' => array ( 'filtername' => array ( 'name' => 'rn:msg:(5167)', 'description' => 'rn:msg:(3583)', 'example' => 'customMenu/22', ), ), ), 'relativePath' => 'standard/search/FilterDropdown', 'widget_name' => 'FilterDropdown', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'filter_name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'required' => true, 'inherited' => false, )), 'label_any' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4573), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4573), 'inherited' => false, )), 'search_on_select' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'options_to_ignore' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
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
$result = array( 'js_name' => 'RightNow.Widgets.SortList', 'library_name' => 'SortList', 'view_func_name' => '_standard_search_SortList_view', 'meta' => array ( 'controller_path' => 'standard/search/SortList', 'view_path' => 'standard/search/SortList', 'js_path' => 'standard/search/SortList', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(956)', 'urlParameters' => array ( 'sort' => array ( 'name' => 'rn:msg:(4602)', 'description' => 'rn:msg:(3586)', 'example' => 'sort/3,1', ), ), ), 'relativePath' => 'standard/search/SortList', 'widget_name' => 'SortList', ), );
$result['meta']['attributes'] = array( 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'STRING', 'default' => (176), 'inherited' => false, )), 'label_text' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3716), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3716), 'inherited' => false, )), 'label_default' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(8659), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(8659), 'inherited' => false, )), 'label_ascending' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(8680), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(8680), 'inherited' => false, )), 'label_descending' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(8682), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(8682), 'inherited' => false, )), 'search_on_select' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
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
$result = array( 'js_name' => '', 'library_name' => 'BrowserSearchPlugin', 'view_func_name' => '_standard_search_BrowserSearchPlugin_view', 'meta' => array ( 'controller_path' => 'standard/search/BrowserSearchPlugin', 'view_path' => 'standard/search/BrowserSearchPlugin', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4363)', ), 'relativePath' => 'standard/search/BrowserSearchPlugin', 'widget_name' => 'BrowserSearchPlugin', ), );
$result['meta']['attributes'] = array( 'pages' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'home, answers/list, answers/detail', 'type' => 'STRING', 'default' => 'home, answers/list, answers/detail', 'inherited' => false, )), 'search_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'answers/list', 'type' => 'STRING', 'default' => 'answers/list', 'inherited' => false, )), 'title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'inherited' => false, )), 'description' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'inherited' => false, )), 'icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/euf/assets/images/icons/favicon_browserSearchPlugin.ico', 'type' => 'STRING', 'default' => '/euf/assets/images/icons/favicon_browserSearchPlugin.ico', 'inherited' => false, )), );
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
use RightNow\Utils\Text, RightNow\Utils\Url;
class LoginDialog extends \RightNow\Libraries\Widget\Base {
function _standard_login_LoginDialog_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
$result = array( 'js_name' => 'RightNow.Widgets.LoginDialog', 'library_name' => 'LoginDialog', 'view_func_name' => '_standard_login_LoginDialog_view', 'meta' => array ( 'controller_path' => 'standard/login/LoginDialog', 'view_path' => 'standard/login/LoginDialog', 'js_path' => 'standard/login/LoginDialog', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/LoginDialog.css', ), 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(42108)', 'urlParameters' => array ( 'redirect' => array ( 'name' => 'rn:msg:(3354)', 'description' => 'rn:msg:(1761)', 'example' => 'redirect/home', ), 'username' => array ( 'name' => 'rn:msg:(4846)', 'description' => 'rn:msg:(3199)', 'example' => 'username/JohnDoe', ), ), ), 'relativePath' => 'standard/login/LoginDialog', 'widget_name' => 'LoginDialog', ), );
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
    <meta name="viewport" content="width=device-width; initial-scale=1.0; user-scalable=no; minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Contact Us | FAQs</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
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
.rn_CustomInfoButton{}
.rn_InfoButton{display:inline;bottom: 0px;}
.rn_InfoButton input{width: 100px;height: 100px;vertical-align:top;}
.rn_InfoButton{color:#FFF;cursor:pointer;font-weight:bold;}
.rn_CustomInfoButton{}
.rn_Multiline{overflow:hidden;}
.rn_Multiline .rn_Loading{background: url(<?=FileSystem::getOptimizedAssetsDir();?>themes/standard/images/loading.gif) no-repeat center center;height:auto !important;height:66px;min-height:66px;}
.rn_Multiline .rn_Element1, .rn_Multiline .rn_Element2{font-size:15px;line-height:24px;color:#7B4397;}
.rn_Multiline .rn_Element3{font-size:13px;line-height:22px;color:#000000;float:left;}
.rn_Multiline .rn_ElementsHeader, .rn_Multiline .rn_ElementsData{color:#999999;font-size:10px;line-height:19px;float:left;display:block;position:relative;padding-bottom: 12px;}
.rn_Multiline ol{padding-top:3px;}
.rn_Multiline li{display: table-row;margin-bottom: 12px;padding-bottom: 12px;}
.rn_ProductCategoryList{overflow:hidden;}
.rn_ProductCategoryList .rn_HierList{width:48%;}
.rn_ProductCategoryList .rn_HierList.rn_FloatRight{float:right;padding-right:10px;}
.rn_ProductCategoryList .rn_HierList.rn_FloatLeft{float:left;padding-left:9px;}
.rn_ProductCategoryList .rn_HierList li{margin:4px 0 0 10px;}
.rn_ProductCategoryList{margin:20px 0;text-align:center;}
.rn_ProductCategoryList h2{color:#000;font-size:20px;font-weight:bold;line-height:26px;text-align:left;text-transform:capitalize;}
.rn_ProductCategoryList .rn_HierList h3{color:#111;font-size:1.1em;margin:4px 0;}
.rn_ProductCategoryList .rn_HierList h3 a{color:#333;text-decoration:underline;}
.rn_ProductCategoryList .rn_HierList li{margin:4px 0 0 10px;}
.rn_ProductCategoryList .rn_HierList li a{color:#07538D;text-decoration:none;}
.rn_ProductCategoryList .rn_HierList li a:hover, .rn_ProductCategoryList .rn_HierList li a:focus{text-decoration:none;}
.rn_KeywordText input{font-size:1.333em;}
.rn_KeywordText{display:inline;}
.rn_KeywordText label{display: none;}
.rn_SearchButton{display:inline;bottom: 0px;float:left;margin-right:20px;margin-left:20px;}
.rn_SearchButton input{border:none;vertical-align:top;}
.rn_SearchButton .rn_SubmitButton{*height:30px;*line-height:21px;background-color:#d10103;color:#FFF;cursor:pointer;font-weight:bold;}
.rn_SearchButton .rn_SubmitButton:hover{background:#7B4397;cursor:pointer;}
.rn_AdvancedSearchDialog{overflow:visible;}
.rn_AdvancedSearchDialog .rn_DialogContent{overflow:visible;padding-top:16px;position:relative;}
.rn_AdvancedSearchDialog .rn_DialogContent .rn_SearchTips{color:#333;position:absolute;right:0px;_right:10px;top:0px;}
.rn_AdvancedSearchDialog .rn_DialogContent .rn_AdvancedSubWidget{clear:right;overflow:hidden;padding:16px 8px;}
.rn_AdvancedSearchDialog .rn_DialogContent .rn_AdvancedSubWidget:empty{display:none;}
.rn_AdvancedSearchDialog .rn_DialogContent .rn_AdvancedFilter, .rn_AdvancedSearchDialog .rn_DialogContent .rn_AdvancedSort{border-top:1px solid #FFF;}
.rn_AdvancedSearchDialog .rn_DialogContent .rn_AdvancedFilter button{width:auto !important;width:60%;max-width:60%;}
.rn_AdvancedSearchDialog .rn_DialogContent label{color:#333;float:left;font-weight:bold;width:38%;}
.rn_AdvancedSearchDialog .rn_DialogContent select{display:inline-block;*display:block;min-width:160px;}
.rn_CustomInfoButton{}
.rn_ProductCategorySearchFilter button.rn_DisplayButton{background:none;color:#000;cursor:pointer;font-weight:normal;overflow:hidden;text-overflow:ellipsis;-moz-border-radius:0;-webkit-border-radius:0;border-radius:0;-moz-box-shadow:none;-webkit-box-shadow:none;box-shadow:none;z-index:0 !important;}
.rn_ProductCategorySearchFilter .yui-overlay-hidden .rn_Panel table{*border-collapse:separate;}
.rn_ProductCategorySearchFilter .ygtvrow{cursor:pointer;}
.rn_ProductCategorySearchFilter .ygtvspacer{width:1em;display:block;}
.rn_ProductCategorySearchFilter .ygtvlabel, .rn_ProductCategorySearchFilter .ygtvlabel:link, .rn_ProductCategorySearchFilter .ygtvlabel:visited, .rn_ProductCategorySearchFilter .ygtvlabel:hover{font-size:inherit;}
.rn_ProductCategorySearchFilter .rn_PanelContainer .yui3-widget-hd{display: none;}
.rn_ProductCategorySearchFilter button.rn_DisplayButton{background:#FFF url(<?=FileSystem::getOptimizedAssetsDir();?>themes/standard/images/splitButtonArrow.png) no-repeat scroll right center;border:1px solid #B1B1B1;min-height:1.5em;min-width:250px;padding:4px 20px 4px 4px;text-align:left;text-shadow:none;}
.rn_ProductCategorySearchFilter .rn_Panel{background:#FFF;border:1px solid #B1B1B1;max-height:200px;overflow:auto;padding:6px;_height:200px;}
.rn_ProductCategorySearchFilter button.rn_DisplayButton:hover, .rn_ProductCategorySearchFilter button.rn_DisplayButton:focus{background-color:#F8F8F8;}
.rn_ProductCategorySearchFilter table{border-collapse:collapse;}
.rn_ProductCategorySearchFilter .rn_Label{color:#333333;float:left;font-weight:bold;width:38%;}
.ygtvlabel, .ygtvlabel:link, .ygtvlabel:visited, .ygtvlabel:hover{color:#111;}
-->
</style>
9c1379bc-cca6-4750-aee7-188f8348a6c3
    <link rel="shortcut icon" href="https://www.virginamerica.com/images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="//cloud.typography.com/6612472/735824/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="/euf/assets/themes/standard/header.css">
	
	<script type='text/javascript'>window.ATGSvcs = {'eeid': 200106296983};</script>
	<script type='text/javascript' src='//static.atgsvcs.com/js/atgsvcs.js'></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
       <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
       <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
</head>
<body class="yui-skin-sam yui3-skin-sam">
<!-- TagMan BootStrap -->
<script type="text/javascript">
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
</script>
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
                        <a href="https://www.virginamerica.com/elevate-frequent-flyer" class="elevate-nav__link elevate-nav__link--sign-in icon-elevate-small">Sign In</a>
                        <a href="https://www.virginamerica.com/elevate-frequent-flyer/sign-up" class="elevate-nav__link" ng-show="header.breakpoint !== 'small'">Sign Up</a>
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
            

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">   <!-- Required by iPhone 5 -->

<!-- TagMan BootStrap -->
<script type="text/javascript">
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

function go_ContactForm(id) {
  RightNow.Url.navigate("/app/ask/incidents.c$typeofquestion/"+id, false);
}

function go_Question(id) {
  RightNow.Url.navigate("/app/answers/detail/a_id/"+id, false);
}

function go_DirectUrl(url) {
  RightNow.Url.navigate(url, false);
}

function goto_EmailTopic() {

  var radios = document.getElementsByName('rn_Radio');
  var radio_value;
  for (var i = 0; i < radios.length; i++) {
     if (radios[i].checked) {
        radio_value = Number(radios[i].value);
        break;
     }
  }
  switch(radio_value) {
    case 1: go_ContactForm(1857);
            break;
    case 2: go_ContactForm(1858);
            break;
    case 3: go_ContactForm(1859); 
            break;
    case 4: go_ContactForm(1860); 
            break;
    case 5: go_DirectUrl('http://virginamerica.custhelp.com/app/answers/detail/a_id/686');
            break;
    case 6: go_ContactForm(1861); 
            break;
    case 7: go_Question(221); 
            break;
    case 8: go_DirectUrl('http://virginamerica.custhelp.com/app/answers/detail/a_id/665'); 
            break;
    case 9: go_DirectUrl('http://virginamerica.custhelp.com/app/answers/detail/a_id/140');
            break;
    case 10: go_DirectUrl('http://virginamerica.custhelp.com/app/answers/detail/a_id/153'); 
            break;
    case 11: go_ContactForm(1960); 
            break;
  }
}


function toggleLinks(id) {
  var e = document.getElementById(id);
  var body = document.getElementById('rn_Body');
  var ele = document.querySelector("#vx-wrapper");
  var border = document.querySelector("#rn_Header > header");
  var minus = document.querySelector("#rn_Header > header > div > div.vx-bars-container");
  if (e.style.display == 'block') {
    e.style.display = 'none';
    body.style.display = 'block';
    ele.style.backgroundColor = 'transparent';
    border.style.borderBottom = '0px';
    minus.style.borderBottom = '1px solid #FFF';
  }
  else {
    e.style.display = 'block';
    body.style.display = 'none';
    ele.style.backgroundColor = "#DF1A2D";
    border.style.borderBottom = '1px solid #5F2969';
    minus.style.borderBottom = '1px solid #DF1A2D';   /* Needs to be a few pixels longer */
  }
}

function closeModal(elem) {
	alert("in here");
	document.getElementById(elem).hide();
}
</script>

   <link rel="stylesheet" type="text/css" href="//cloud.typography.com/6612472/735824/css/fonts.css" />

    <div id="rn_PageTitle" class="rn_Home"></div>
  
    <div class="rn_Module">
	        
        <h1 style="text-align: center;">Contact Us </h1>
        <div>
          <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/display/CustomInfoButton',
array('label_button' => '','is_link' => 'false','target' => 'myCallDiv',));
?>
   <!-- Remove the comment surrounding the next line to display Chat -->
   <!--       <rn:widget path="custom/util/CustomInfoButton" label_button="Chat" target="/chat/chat_landing" is_link="true" /> -->
          <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/display/CustomInfoButton', array('label_button' => '','is_link' => 'false','target' => 'myEmailDiv',));
?>
          <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/display/CustomInfoButton', array('label_button' => '','is_link' => 'true','target' => 'https://www.twitter.com/VirginAmerica',));
?>
		  
          	<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/display/CustomInfoButton', array('label_button' => '','is_link' => 'false','target' => 'myAddressDiv',));
?>
			 
		 
        </div>
    </div>

    <div id="rn_PageContent" class="rn_Home">
     
        <div id="rn_SideBar" role="navigation">
            <div class="rn_Padding">
                <div class="rn_Module">
                  <h2>Top 10 Questions</h2>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/Multiline', array('report_id' => '194','per_page' => '10',));
?>
                </div>
            </div>
        </div>
          
      <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/ProductCategoryList', array('report_page_url' => '/app/home','label_title' => 'Frequently Asked Questions','data_type' => 'products','levels' => '1',));
?>

      <div id="rn_SearchControls">
        <h1 class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::msgGetFrom((4693));?></h1>
        <form onsubmit="return false;">
            <?
$currentAttributeArray = array("rn_container" => "true", 'report_id' => '176','rn_container_id' => 'rnc_1');
\RightNow\Utils\Widgets::pushAttributesOntoStack($currentAttributeArray);
\RightNow\Utils\Widgets::$rnContainers["rnc_1"] = json_decode('{"report_id":"176","rn_container_id":"rnc_1"}');
?>
              <div class="rn_SearchInput">                                   
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/KeywordText', array('label_text' => '' . \RightNow\Utils\Config::msgGetFrom((1962)) . '','initial_focus' => 'false',));
?>
              </div>
              <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/SearchButton', array());
?>
              <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/AdvancedSearchDialog', array('report_page_url' => '/app/answers/list','show_confirm_button_in_dialog' => 'true',));
?>
            <? $attributes = \RightNow\Utils\Widgets::popAttributesFromStack();
if($attributes !== null && !array_key_exists("rn_container", $attributes)) \RightNow\Utils\Widgets::pushAttributesOntoStack($attributes);
?>
        </form>
      </div>

      <div id="answerList" class="rn_AnswerList">
        <div class="rn_Padding">
           <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/Multiline', array('report_id' => '176',));
?>
        </div>
      </div>
   
      <div id="myDiv" class="rn_Hidden">
        <div class="hd">Panel #1 from Markup</div> 
        <div class="bd">This is a Panel that was marked up in the document. 
          <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('custom/util/CustomInfoButton', array('label_button' => 'Google','target' => 'http://www.google.com','is_link' => 'true',));
?>
        </div>
        <div class="ft">End of Panel #1</div>
      </div>

<div id="actionButtons">
<div id="myEmailDiv" class="rn_Hidden">
  <div class="hd"><a name="myEmailAnchor"></a></div> 
  <div class="bd">
    <h2>Email Us</h2>
    <h4>What type of questions do you have?</h4>
    <input type="radio" id="rn_1" name="rn_Radio" value="1" /><label for="rn_1">Elevate</label><br/>
    <input type="radio" id="rn_2" name="rn_Radio" value="2" /><label for="rn_2">Concern/Kudos</label><br/>
    <input type="radio" id="rn_3" name="rn_Radio" value="3" /><label for="rn_3">Idea/Suggestion</label><br/>
    <input type="radio" id="rn_4" name="rn_Radio" value="4" /><label for="rn_4">Reservations/General Info</label><br/>
    <input type="radio" id="rn_5" name="rn_Radio" value="5" /><label for="rn_5">Receipt</label><br/>
    <input type="radio" id="rn_6" name="rn_Radio" value="6" /><label for="rn_6">Best Fare Guarantee</label><br/>
    <input type="radio" id="rn_7" name="rn_Radio" value="7" /><label for="rn_7">Lost and Found</label><br/>
    <??>
    <input type="radio" id="rn_8" name="rn_Radio" value="8" /><label for="rn_8">Charity/Donation Request</label><br/>
    <input type="radio" id="rn_9" name="rn_Radio" value="9" /><label for="rn_9">Sponsorship/Advertising Request</label><br/>
    <input type="radio" id="rn_10" name="rn_Radio" value="10" /><label for="rn_10">Career</label><br/>
    <div class="fd">
      <button class="EmailUs" onclick="goto_EmailTopic()">Continue</button>
    </div>
  </div>
  <a class="yui3-button-close container-close" href="#" >Close</a>
</div>



<div id="myCallDiv" class="rn_Hidden" >
    <div class="hd"><a name="myCallAnchor"></a></div> 
    <div class="bd">
      <div class="content">
        <h2 class="title">Call Us</h2>
        <h5 class="subtext">If you’re looking for help with a new or existing reservation, general
          information, or details on our Elevate program, don’t hesitate to call us, 
          24 hours a day.</h5>

        <h6 class="dest">FROM U.S AND CANADA</h6>
        <h1>1.877.FLY.VIRGIN</h1>
        <h6>(877.359.8474)</h6>

        <h6 class="dest">FROM MEXICO</h6>
        <h3>001.877.359.8474</h3>

        <h6 class="subDest">FROM OTHER COUNTRIES</h6>
        <h3>+1.650.762.7005</h2>


        <h5 class="subDest">If you're an Elevate Silver or Elevate Gold member, you can contact us by calling your exclusive reservation line, or send an email to your dedicated email address—available once you log into your Elevate account.</h5>

        <h5 class="subDest">Any guest calling from the United States has access to a complimentary telecommunication relay service by dialing 711. For more information, head to the <a href="http://www.nidcd.nih.gov/health/hearing/pages/telecomm.aspx">Telecommunications Relay Services</a></h5>

       <h5 class="subDest">If you're looking to get in touch with one of our airport baggage offices please visit us <a href="http://virginamerica.custhelp.com/app/answers/detail/a_id/221">here.</a></h5>
       <h5 class="subDest">If you are Media or Press please visit us <a href="https://www.virginamerica.com/cms/about-our-airline/press-contacts.html">here.</a></h5><br>
       </div>
    </div>
    <a class="yui3-button-close container-close" href="#">Close</a>
</div>


<div id="myAddressDiv" class="rn_Hidden">
   <div class="hd"><a name="myAddressAnchor"></a></div>
   <div class="bd" id= "chat_reactive">
	   <p style="text-align: center;">Have a question? We’re here to help. Please connect with our fabulous teammates in real time, 6am to 11pm PST, 7 days a week (including holidays!). If this is after hours, you may send us an email <a href="http://virginamerica.custhelp.com/app/ask/incidents.c$typeofquestion/1860">here</a></p>

  </div>
  <a class="yui3-button-close container-close" href="#"></a>
</div>
</div>
<? $prod = intval(getUrlParm("p"));
if($prod > 0) {?>
    <script>
        location.hash = "#answerList";
    </script>
<?
}
?>
<script>
    //document.body.scrollTop = document.documentElement.scrollTop = 0;
</script>
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
        </div> -->
        <footer class="vx-footer">
            <div class="vx-wrap desktop">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                </ul>
                <ul>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>
            <div class="vx-wrap tablet">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                    <li><a href="/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>        
            <div class="vx-wrap mobile">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                    <li><a href="http://www.virginamerica.com/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>
            <p class="copyright">© 2014 Virgin America</p>
        </footer>
    </div>
</div>
      <footer role="contentinfo">
            <div class="wrap">
                <div class="footer-wrap">
                    <nav class="footer-nav cf">
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/sitemap">Sitemap</a></li>
                            <li class="footer-nav__item"><a href="http://virginamerica.custhelp.com/">Contact Us/FAQs</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/about-our-airline">About Us</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/about-our-airline/press">Press</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/blog">Blog</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/airline-jobs">Careers</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-travel">Corporate &amp; Group Travel</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-travel/travel-agents">Travel Agents</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/legal/guest-service-commitment">Guest Service Commitment</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/dam/vx-pdf/contract-of-carriage.pdf">Contract of Carriage</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/dam/vx-pdf/international-contract-of-carriage.pdf">Int’l Contract of Carriage</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-responsibility">Corporate Responsibility</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="http://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGmAt9ur9biu27Jh9e9uzfeDcCi8SonfVXMtX%3DWQpglLjHJlYQGruK1w1EzbazdUdEGG6gmlazdJwoNGDzbf&_ei_=EmSL9xUrhFrGHt6VuHz0Fpo">Email Unsubscribe</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/legal/privacy-policy">Privacy Policy</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/travel-guard">Travel Insurance</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/news">All News &amp; Updates</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/elevate-frequent-flyer">What Is Elevate?</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/elevate-frequent-flyer/credit-card">Virgin America Credit Card</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/advertise-onboard">Advertise Onboard</a></li>
                            <li class="footer-nav__item"><a href="https://plus.google.com/+VirginAmerica/" target="_blank" rel="publisher">Google+</a></li>
                        </ul>
                        <ul class="footer-nav__list is-omega">
                            <li class="footer-nav__item"><a href="http://instagram.com/virginamerica" target="_blank" rel="me">Instagram</a></li>
                            <li class="footer-nav__item"><a href="https://twitter.com/VirginAmerica" target="_blank" rel="me">Twitter</a></li>
                            <li class="footer-nav__item"><a href="https://www.facebook.com/VirginAmerica" target="_blank" rel="me">Facebook</a></li>
                            <li class="footer-nav__item"><a href="https://www.youtube.com/user/VirginAmerica" target="_blank" rel="me">YouTube</a></li>
                        </ul>
                    </nav>
                    <div class="footer-copy">
                        &copy; 2014 Virgin America
                    </div>
                </div>
            </div>
        </footer>
        <script>
	        //document.body.scrollTop = document.documentElement.scrollTop = 0;
        /*  var $jq = jQuery.noConflict(true);
		  jQuery( document ).ready(function() {
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
            })(); */
        </script>
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=\RightNow\Utils\Url::getCoreAssetPath('js/4.171/min/RightNow.js');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>templates<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/login/LogoutLink', 1 => 'standard/login/LoginDialog', ), '/standard.js', '1436802870');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/EventProvider.js', 1 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/SearchFilter.js', 2 => 'custom/display/CustomInfoButton', 3 => 'standard/reports/Multiline', 4 => 'standard/search/KeywordText', 5 => 'standard/search/SearchButton', 6 => 'standard/search/AdvancedSearchDialog', 7 => 'custom/util/CustomInfoButton', 8 => 'standard/search/SearchTypeList', 9 => 'standard/search/WebSearchSort', 10 => 'standard/search/WebSearchType', 11 => 'standard/search/ProductCategorySearchFilter', 12 => 'standard/search/FilterDropdown', 13 => 'standard/search/SortList', ), '/home.js', '1436802870');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'CANCEL_CMD' => array ( 'value' => 849, ), 'SELECTION_PCT_S_ACTIVATE_LINK_JUMP_MSG' => array ( 'value' => 3544, ), 'PCT_S_LNKS_DEPTH_ANNOUNCED_MSG' => array ( 'value' => 3036, ), 'PCT_S_MUST_NOT_CONTAIN_SPACES_MSG' => array ( 'value' => 3042, ), 'USERNAME_LBL' => array ( 'value' => 4846, ), 'PCT_S_CONTAIN_DOUBLE_QUOTES_MSG' => array ( 'value' => 3005, ), 'PCT_S_CNT_THAN_MSG' => array ( 'value' => 3002, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
