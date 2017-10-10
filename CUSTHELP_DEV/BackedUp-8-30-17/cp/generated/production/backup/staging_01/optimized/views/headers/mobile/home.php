<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/mobile', 1 => '/euf/assets/themes/mobile', 2 => array ( '/euf/assets/themes/mobile' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile', ), ));
get_instance()->_checkMeta(array('javascript_module'=>'mobile_may_10', 'title'=>'' . \RightNow\Utils\Config::msgGetFrom((4525)) . '', 'template'=>'mobile.php', 'clickstream'=>'home'));
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
class Accordion extends \RightNow\Libraries\Widget\Base {
function _standard_navigation_Accordion_view ($data) {
extract($data);
?><? }
}
function _standard_navigation_Accordion_header() {
$result = array( 'js_name' => 'RightNow.Widgets.Accordion', 'library_name' => 'Accordion', 'view_func_name' => '_standard_navigation_Accordion_view', 'meta' => array ( 'controller_path' => 'standard/navigation/Accordion', 'view_path' => '', 'js_path' => 'standard/navigation/Accordion', 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', 3 => '3.3', 4 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4338)', ), 'relativePath' => 'standard/navigation/Accordion', 'widget_name' => 'Accordion', ), );
$result['meta']['attributes'] = array( 'toggle' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'item_to_toggle' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'expanded_css_class' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'rn_Expanded', 'type' => 'STRING', 'default' => 'rn_Expanded', 'inherited' => false, )), 'collapsed_css_class' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'rn_Collapsed', 'type' => 'STRING', 'default' => 'rn_Collapsed', 'inherited' => false, )), 'label_collapsed' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3522), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3522), 'inherited' => false, )), 'label_expanded' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3523), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3523), 'inherited' => false, )), 'focus_item_on_open_selector' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class Multiline extends \RightNow\Libraries\Widget\Base {
function _standard_reports_Multiline_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
                <? for ($i = 0;
$i < $reportColumns;
$i++): ?>
                    <? $header = $this->data['reportData']['headers'][$i];
?>
                    <? if ($this->showColumn($value[$i], $header)): if ($i < 3): ?>
                            <span class="rn_Element<?=$i + 1?>"><?=$value[$i];?></span>
                        <?
else: ?>
                            <span class="rn_ElementsHeader"><?=$this->getHeader($header);?></span>
                            <span class="rn_ElementsData"><?=$value[$i];?></span>
                        <?
endif;
?>
                    <? endif;
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
        <? else: ?>
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
$this->data['js']['hide_columns'] = array_map('trim', explode(",", $this->data['attrs']['hide_columns']));
}
function showColumn($value, array $header) {
if((!array_key_exists('visible', $header) || $header['visible'] === true)) {
if($this->data['attrs']['hide_empty_columns'] && (is_null($value) || $value === '' || $value === false)) {
return false;
}
if(is_array($this->data['js']['hide_columns']) && in_array($header['col_definition'], $this->data['js']['hide_columns'])) {
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
$result = array( 'js_name' => 'RightNow.Widgets.Multiline', 'library_name' => 'Multiline', 'view_func_name' => '_standard_reports_Multiline_view', 'meta' => array ( 'controller_path' => 'standard/reports/Multiline', 'view_path' => 'standard/reports/Multiline', 'js_path' => 'standard/reports/Multiline', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/Multiline.css', 1 => 'assets/themes/standard/widgetCss/Multiline.css', ), 'js_templates' => array ( 'view' => '<% if (row_num) { %> <ol start=\'<%= start_num %>\'><% } else { %> <ul><% } %><% for (var i = 0; i < data.length; i++) { %>  <li> <% for (var j = 0; j < headers.length; j++) { var value = data[i][j]; if (typeof hide_columns !== \'undefined\' && hide_columns.indexOf(headers[j].col_definition) !== -1) { continue; } if ((typeof headers[j].visible === \'undefined\' || headers[j].visible) && (!hide_empty_columns || !(value === null || value === \'\' || value === false))) { if (j < 3) { %> <span class=\'rn_Element<%=j+1%>\'><%= value %></span> <% } else { %> <span class=\'rn_ElementsHeader\'><%= ((headers[j].heading) ? headers[j].heading + \':\' : \'\') %></span> <span class=\'rn_ElementsData\'><%= value %></span> <% } } } %> </li> <% } %><% if (row_num) { %> </ol><% } else { %> </ul><% } %>', ), 'template_path' => 'standard/reports/Multiline', 'version' => '1.1.3', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', ), 'jsModule' => array ( 0 => 'standard', ), ), 'info' => array ( 'description' => 'rn:msg:(4268)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(3918)', 'example' => 'kw/search', ), 'r_id' => array ( 'name' => 'rn:msg:(19461)', 'description' => 'rn:msg:(3928)', 'example' => 'r_id/176', ), 'st' => array ( 'name' => 'rn:msg:(9716)', 'description' => 'rn:msg:(4494)', 'example' => 'st/6', ), 'org' => array ( 'name' => 'rn:msg:(2905)', 'description' => 'rn:msg:(3584)', 'example' => 'org/2', ), 'page' => array ( 'name' => 'rn:msg:(4591)', 'description' => 'rn:msg:(4495)', 'example' => 'page/2', ), 'search' => array ( 'name' => 'rn:msg:(6920)', 'description' => 'rn:msg:(2262)', 'example' => 'search/0', ), 'sort' => array ( 'name' => 'rn:msg:(4602)', 'key' => 'sort', 'description' => 'rn:msg:(3586)', 'example' => 'sort/3,1', ), ), ), 'relativePath' => 'standard/reports/Multiline', 'widget_name' => 'Multiline', ), );
$result['meta']['attributes'] = array( 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'inherited' => false, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => false, )), 'truncate_size' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 200, 'type' => 'INT', 'default' => 200, 'min' => 1, 'inherited' => false, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'label_screen_reader_search_success_alert' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4463), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4463), 'inherited' => false, )), 'label_screen_reader_search_no_results_alert' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4464), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4464), 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'STRING', 'default' => 'kw', 'inherited' => false, )), 'hide_when_no_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'max_wordbreak_trunc' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'min' => 0, 'inherited' => false, )), 'date_format' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'short', 'type' => 'OPTION', 'default' => 'short', 'options' => array(0 => 'short', 1 => 'date_time', 2 => 'long', 3 => 'raw', ), 'inherited' => false, )), 'static_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'hide_empty_columns' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'hide_columns' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class MobileMultiline extends \RightNow\Widgets\Multiline {
function _standard_reports_MobileMultiline_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
                <? for ($i = 0;
$i < $reportColumns;
$i++): ?>
                    <? $header = $this->data['reportData']['headers'][$i];
?>
                    <? if ($this->showColumn($value[$i], $header)): if ($i < 3): ?>
                            <span class="rn_Element<?=$i + 1?>"><?=$value[$i];?></span>
                        <?
else: ?>
                            <span class="rn_ElementsHeader"><?=$this->getHeader($header);?></span>
                            <span class="rn_ElementsData"><?=$value[$i];?></span>
                        <?
endif;
?>
                    <? endif;
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
$result = array( 'js_name' => 'RightNow.Widgets.MobileMultiline', 'library_name' => 'MobileMultiline', 'view_func_name' => '_standard_reports_MobileMultiline_view', 'meta' => array ( 'controller_path' => 'standard/reports/MobileMultiline', 'view_path' => 'standard/reports/MobileMultiline', 'js_path' => 'standard/reports/MobileMultiline', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/MobileMultiline.css', ), 'js_templates' => array ( 'view' => '<% if (row_num) { %> <ol start=\'<%= start_num %>\'><% } else { %> <ul><% } %><% for (var i = 0; i < data.length; i++) { %>  <li> <% for (var j = 0; j < headers.length; j++) { var value = data[i][j]; if (typeof hide_columns !== \'undefined\' && hide_columns.indexOf(headers[j].col_definition) !== -1) { continue; } if ((typeof headers[j].visible === \'undefined\' || headers[j].visible) && (!hide_empty_columns || !(value === null || value === \'\' || value === false))) { if (j < 3) { %> <span class=\'rn_Element<%=j+1%>\'><%= value %></span> <% } else { %> <span class=\'rn_ElementsHeader\'><%= ((headers[j].heading) ? headers[j].heading + \':\' : \'\') %></span> <span class=\'rn_ElementsData\'><%= value %></span> <% } } } %> </li> <% } %><% if (row_num) { %> </ol><% } else { %> </ul><% } %>', ), 'template_path' => 'standard/reports/MobileMultiline', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', ), 'jsModule' => array ( 0 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/reports/Multiline', 'versions' => array ( 0 => '1.1', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'info' => array ( 'description' => 'rn:msg:(42112)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(3918)', 'example' => 'kw/search', ), 'r_id' => array ( 'name' => 'rn:msg:(19461)', 'description' => 'rn:msg:(3928)', 'example' => 'r_id/176', ), 'st' => array ( 'name' => 'rn:msg:(9716)', 'description' => 'rn:msg:(4494)', 'example' => 'st/6', ), 'org' => array ( 'name' => 'rn:msg:(2905)', 'description' => 'rn:msg:(3584)', 'example' => 'org/2', ), 'page' => array ( 'name' => 'rn:msg:(4591)', 'description' => 'rn:msg:(4495)', 'example' => 'page/2', ), 'search' => array ( 'name' => 'rn:msg:(6920)', 'description' => 'rn:msg:(2262)', 'example' => 'search/0', ), 'sort' => array ( 'name' => 'rn:msg:(4602)', 'key' => 'sort', 'description' => 'rn:msg:(3586)', 'example' => 'sort/3,1', ), ), ), 'relativePath' => 'standard/reports/MobileMultiline', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/reports/Multiline', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/reports/Multiline', ), 'widget_name' => 'MobileMultiline', 'extends_php' => array ( 0 => 'standard/reports/Multiline', ), 'parent' => 'standard/reports/Multiline', ), );
$result['meta']['attributes'] = array( 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'inherited' => true, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => true, )), 'truncate_size' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 200, 'type' => 'INT', 'default' => 200, 'min' => 1, 'inherited' => true, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), 'label_screen_reader_search_success_alert' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4463), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4463), 'inherited' => true, )), 'label_screen_reader_search_no_results_alert' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4464), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4464), 'inherited' => true, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'STRING', 'default' => 'kw', 'inherited' => true, )), 'hide_when_no_results' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => true, )), 'max_wordbreak_trunc' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'min' => 0, 'inherited' => true, )), 'date_format' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'short', 'type' => 'OPTION', 'default' => 'short', 'options' => array(0 => 'short', 1 => 'date_time', 2 => 'long', 3 => 'raw', ), 'inherited' => true, )), 'static_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'hide_empty_columns' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ProductCategoryList extends \RightNow\Libraries\Widget\Base {
function _standard_search_ProductCategoryList_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
$result = array( 'js_name' => '', 'library_name' => 'ProductCategoryList', 'view_func_name' => '_standard_search_ProductCategoryList_view', 'meta' => array ( 'controller_path' => 'standard/search/ProductCategoryList', 'view_path' => 'standard/search/ProductCategoryList', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/ProductCategoryList.css', 1 => 'assets/themes/standard/widgetCss/ProductCategoryList.css', ), 'base_css' => array ( 0 => 'standard/search/ProductCategoryList/base.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', ), ), 'info' => array ( 'description' => 'rn:msg:(4278)', ), 'relativePath' => 'standard/search/ProductCategoryList', 'widget_name' => 'ProductCategoryList', ), );
$result['meta']['attributes'] = array( 'data_type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'products', 'type' => 'OPTION', 'default' => 'products', 'options' => array(0 => 'products', 1 => 'categories', ), 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/answers/list', 'type' => 'STRING', 'default' => '/app/answers/list', 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1890), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1890), 'inherited' => false, )), 'only_display' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'maximum_top_levels' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 30, 'type' => 'INT', 'default' => 30, 'min' => 1, 'max' => 30, 'inherited' => false, )), 'levels' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 2, 'type' => 'INT', 'default' => 2, 'min' => 1, 'max' => 2, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class MobileProductCategoryList extends \RightNow\Widgets\ProductCategoryList {
function _standard_search_MobileProductCategoryList_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <? if($this->data['attrs']['label_title']):?>
    <span class="rn_Title"><?=$this->data['attrs']['label_title'];?></span>
    <?
endif;?>
    <?
$index = 1;
foreach($this->data['results'] as $key => $value):?>
    <div class="rn_HierList rn_HierList_<?=$key;?>">
    <a href="<?=$this->data['attrs']['report_page_url'].
$this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter() . "/{$this->data['type']}/".
$value['hierList'];?>"><?=htmlspecialchars($value['label'],
ENT_QUOTES, 'UTF-8');?></a>
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
}
function _standard_search_MobileProductCategoryList_header() {
$result = array( 'js_name' => '', 'library_name' => 'MobileProductCategoryList', 'view_func_name' => '_standard_search_MobileProductCategoryList_view', 'meta' => array ( 'controller_path' => 'standard/search/MobileProductCategoryList', 'view_path' => 'standard/search/MobileProductCategoryList', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/MobileProductCategoryList.css', 1 => 'assets/themes/basic/widgetCss/MobileProductCategoryList.css', ), 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'mobile', 1 => 'none', ), ), 'extends' => array ( 'widget' => 'standard/search/ProductCategoryList', 'versions' => array ( 0 => '1.1', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'info' => array ( 'description' => 'rn:msg:(43929)', ), 'relativePath' => 'standard/search/MobileProductCategoryList', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/search/ProductCategoryList', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/search/ProductCategoryList', ), 'widget_name' => 'MobileProductCategoryList', 'extends_php' => array ( 0 => 'standard/search/ProductCategoryList', ), 'parent' => 'standard/search/ProductCategoryList', ), );
$result['meta']['attributes'] = array( 'data_type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'products', 'type' => 'OPTION', 'default' => 'products', 'options' => array(0 => 'products', 1 => 'categories', ), 'inherited' => true, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/answers/list', 'type' => 'STRING', 'default' => '/app/answers/list', 'inherited' => true, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'label_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1890), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1890), 'inherited' => true, )), 'only_display' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'maximum_top_levels' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 30, 'type' => 'INT', 'default' => 30, 'min' => 1, 'max' => 30, 'inherited' => true, )), 'levels' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 2, 'type' => 'INT', 'default' => 2, 'min' => 1, 'max' => 2, 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
class MobileNavigationMenu extends \RightNow\Libraries\Widget\Base {
function _standard_navigation_MobileNavigationMenu_view ($data) {
extract($data);
?><?php ?>
<span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
class PageSetSelector extends \RightNow\Libraries\Widget\Base {
function _standard_utils_PageSetSelector_view ($data) {
extract($data);
?><?php ?>
<span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
$result = array( 'js_name' => '', 'library_name' => 'PageSetSelector', 'view_func_name' => '_standard_utils_PageSetSelector_view', 'meta' => array ( 'controller_path' => 'standard/utils/PageSetSelector', 'view_path' => 'standard/utils/PageSetSelector', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/PageSetSelector.css', 1 => 'assets/themes/basic/widgetCss/PageSetSelector.css', 2 => 'assets/themes/standard/widgetCss/PageSetSelector.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', ), 'jsModule' => array ( 0 => 'none', 1 => 'standard', 2 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4224)', ), 'relativePath' => 'standard/utils/PageSetSelector', 'widget_name' => 'PageSetSelector', ), );
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
.rn_MobileMultiline{overflow:hidden;}
.rn_MobileMultiline .rn_Loading{background: url(<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile/images/loading.gif) no-repeat center center;min-height:66px;}
.rn_MobileMultiline .rn_Element1, .rn_MobileMultiline .rn_Element1 a, .rn_MobileMultiline .rn_Element2, .rn_MobileMultiline .rn_Element3{display:block;}
.rn_MobileMultiline .rn_Element1{font-size:1.6em;line-height:1.4em;}
.rn_MobileMultiline .rn_Element1 img{float:right;position:relative;top:10px;}
.rn_MobileMultiline .rn_Element2, .rn_MobileMultiline .rn_Element3{font-size:1.1em;line-height:1.3em;}
.rn_MobileMultiline .rn_ElementsHeader, .rn_MobileMultiline .rn_ElementsData{color:#777;font-size:0.8em;}
.rn_MobileMultiline .rn_ElementsData{display:inline-block;}
.rn_MobileMultiline ol{padding-top:3px;}
.rn_MobileMultiline li{border-bottom:1px solid #DFDFDF;padding:15px;}
.rn_MobileProductCategoryList .rn_Title{display:block;background:#E1E1E1;background: -moz-linear-gradient(top, #FEFEFE, #E0E0E0);background:-webkit-gradient(linear, 0% 0%, 0% 100%, from(#FEFEFE), to(#E0E0E0));font-family:"Lucida Sans Unicode","Lucida Grande",Garuda,sans-serif;font-size:1.143em;line-height:1.4em;padding:10px 6px 13px;text-shadow:1px 2px 1px rgba(255, 255, 255, 1);-moz-box-shadow:0 1px 3px rgba(0, 0, 0, 0.7);-webkit-box-shadow:0 1px 3px rgba(0, 0, 0, 0.7);}
.rn_MobileProductCategoryList .rn_HierList a{background:transparent url(<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile/images/layout/listArrow.png) no-repeat scroll right;border-bottom:1px solid #DFDFDF;color:#111;display:block;font-size:1.3em;line-height:1.4em;margin:0;outline:none;padding:10px 30px 10px 8px;text-decoration:none;}
.rn_MobileProductCategoryList .rn_HierList li{margin:4px 0 0 10px;}
.rn_MobileProductCategoryList .rn_HierList li a{color:#07538D;text-decoration:none;}
-->
</style>
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
<section id="rn_PageContent" class="rn_Home">
    <div class="rn_Module">
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/navigation/Accordion',
array('toggle' => 'rn_AccordTrigger',));
?>
        <h2 id="rn_AccordTrigger" class="rn_Expanded"><?=\RightNow\Utils\Config::msgGetFrom((4586));?><span class="rn_Expand"></span></h2>
        <div>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/MobileMultiline',
array('report_id' => '162','per_page' => '6',));
?>
            <a class="rn_AnswersLink" href="/app/answers/list<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((3524));?></a>
        </div>
    </div>
    <div class="rn_Module">
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/navigation/Accordion',
array('toggle' => 'rn_ListTrigger',));
?>
        <h2 id="rn_ListTrigger" class="rn_Collapsed"><?=\RightNow\Utils\Config::msgGetFrom((1889));?><span class="rn_Expand"></span></h2>
        <div class="rn_Hidden">
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/MobileProductCategoryList',
array('data_type' => 'categories','levels' => '1','label_title' => '',));
?>
        </div>
    </div>
    <div class="rn_Module">
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/navigation/Accordion', array('toggle' => 'rn_ContactTrigger',));
?>
        <h2 id="rn_ContactTrigger" class="rn_Expanded"><?=\RightNow\Utils\Config::msgGetFrom((1340));?><span class="rn_Expand"></span></h2>
        <ul class="rn_ContactChannels">
            <li>
                <a class="rn_ChatChannel" href="/app/chat/chat_launch"><?=\RightNow\Utils\Config::msgGetFrom((7494));?></a>
            </li>
            <li>
                <a class="rn_AskChannel" href="/app/ask"><?=\RightNow\Utils\Config::msgGetFrom((1748));?></a>
            </li>
            <li>
                <a class="rn_VoiceChannel" href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((1109));?></a>
            </li>
            <li>
                <a class="rn_CommunityChannel" href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((1025));?></a>
            </li>
        </ul>
    </div>
</section>
        </section>
        <footer role="contentinfo">
            <?if(
(true) ):?>
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
( 0 => 'standard/login/LogoutLink', 1 => 'standard/navigation/MobileNavigationMenu', 2 => 'standard/search/MobileSimpleSearch', ), '/mobile.js', '1476968233');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => '/euf/core/3.2.6/js/4.122/min/widgetHelpers/EventProvider.js', 1 => '/euf/core/3.2.6/js/4.122/min/widgetHelpers/SearchFilter.js', 2 => 'standard/navigation/Accordion', 3 => 'standard/reports/MobileMultiline', ), '/mobile/home.js', '1476968233');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
