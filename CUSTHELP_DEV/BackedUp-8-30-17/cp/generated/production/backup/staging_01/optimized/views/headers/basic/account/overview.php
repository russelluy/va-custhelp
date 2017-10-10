<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/basic', 1 => '/euf/assets/themes/basic', 2 => array ( '/euf/assets/themes/basic' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/basic', ), ));
get_instance()->_checkMeta(array('javascript_module'=>'none', 'title'=>'' . \RightNow\Utils\Config::msgGetFrom((906)) . '', 'template'=>'basic.php', 'login_required'=>'true', 'force_https'=>'true'));
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
$result = array( 'js_name' => '', 'library_name' => 'BasicMultiline', 'view_func_name' => '_standard_reports_BasicMultiline_view', 'meta' => array ( 'controller_path' => 'standard/reports/BasicMultiline', 'view_path' => 'standard/reports/BasicMultiline', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/BasicMultiline.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'none', ), ), 'extends' => array ( 'widget' => 'standard/reports/Multiline', 'versions' => array ( 0 => '1.1', 1 => '1.2', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'info' => array ( 'description' => 'rn:msg:(43070)', ), 'relativePath' => 'standard/reports/BasicMultiline', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/reports/Multiline', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/reports/Multiline', ), 'widget_name' => 'BasicMultiline', 'extends_php' => array ( 0 => 'standard/reports/Multiline', ), 'parent' => 'standard/reports/Multiline', ), );
$result['meta']['attributes'] = array( 'truncate_size' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 100, 'type' => 'INT', 'default' => 100, 'min' => 1, 'inherited' => false, )), 'per_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'inherited' => true, )), 'report_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => (176), 'type' => 'INT', 'default' => (176), 'min' => 1, 'inherited' => true, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'STRING', 'default' => 'kw', 'inherited' => true, )), 'max_wordbreak_trunc' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'min' => 0, 'inherited' => true, )), 'date_format' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'short', 'type' => 'OPTION', 'default' => 'short', 'options' => array(0 => 'short', 1 => 'date_time', 2 => 'long', 3 => 'raw', ), 'inherited' => true, )), 'static_filter' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'hide_empty_columns' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ClickjackPrevention extends \RightNow\Libraries\Widget\Base {
function _standard_utils_ClickjackPrevention_view ($data) {
extract($data);
?><? if ($this->data['attrs']['frame_options'] === "DENY"): ?>
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
<? endif;
?>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
header("X-Frame-Options: " . $this->data['attrs']['frame_options']);
}
}
function _standard_utils_ClickjackPrevention_header() {
$result = array( 'js_name' => '', 'library_name' => 'ClickjackPrevention', 'view_func_name' => '_standard_utils_ClickjackPrevention_view', 'meta' => array ( 'controller_path' => 'standard/utils/ClickjackPrevention', 'view_path' => 'standard/utils/ClickjackPrevention', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(45063)', ), 'relativePath' => 'standard/utils/ClickjackPrevention', 'widget_name' => 'ClickjackPrevention', ), );
$result['meta']['attributes'] = array( 'frame_options' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'DENY', 'type' => 'OPTION', 'default' => 'DENY', 'options' => array(0 => 'DENY', 1 => 'SAMEORIGIN', ), 'inherited' => false, )), );
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
$result = array( 'js_name' => '', 'library_name' => 'CapabilityDetector', 'view_func_name' => '_standard_utils_CapabilityDetector_view', 'meta' => array ( 'controller_path' => 'standard/utils/CapabilityDetector', 'view_path' => 'standard/utils/CapabilityDetector', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/CapabilityDetector.css', 1 => 'assets/themes/basic/widgetCss/CapabilityDetector.css', 2 => 'assets/themes/standard/widgetCss/CapabilityDetector.css', ), 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(51877)', ), 'relativePath' => 'standard/utils/CapabilityDetector', 'widget_name' => 'CapabilityDetector', ), );
$result['meta']['attributes'] = array( 'automatically_redirect_on_failure' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'bool', 'default' => false, 'inherited' => false, )), 'display_if_no_xhr_object' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'bool', 'default' => true, 'inherited' => false, )), 'display_tests_pass' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'bool', 'default' => false, 'inherited' => false, )), 'label_tests_fail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43112), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(43112), 'inherited' => false, )), 'label_no_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43111), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(43111), 'inherited' => false, )), 'label_tests_pass' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43113), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(43113), 'inherited' => false, )), 'fail_page_set' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'basic', 'type' => 'string', 'default' => 'basic', 'inherited' => false, )), 'pass_page_set' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'default', 'type' => 'string', 'default' => 'default', 'inherited' => false, )), 'perform_javascript_checks_with_no_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'bool', 'default' => true, 'inherited' => false, )), );
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
class BasicLogoutLink extends \RightNow\Widgets\LogoutLink {
function _standard_login_BasicLogoutLink_view ($data) {
extract($data);
?><?php ?>
<span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
<div>
    <h1><?=\RightNow\Utils\Config::msgGetFrom((906));?></h1>
</div>
<div>
    <h2><?=\RightNow\Utils\Config::msgGetFrom((4830));?></h2>
    <div>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/reports/BasicMultiline',
array('report_id' => '196','per_page' => '4',));
?>
        <a href="/app/account/questions/list<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((3526));?></a>
    </div>
    <h2><?=\RightNow\Utils\Config::msgGetFrom((8453));?></h2>
    <div class="rn_LinksBlock">
        <a href="/app/account/profile<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((4044));?></a>
        <?if(
(!\RightNow\Utils\Framework::isPta() && !\RightNow\Utils\Framework::isOpenLogin()) ):?>
            <?if( (\RightNow\Utils\Config::getConfig(193) == true) ):?>
                <a href="/app/<?=\RightNow\Utils\Config::configGetFrom((719));?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((1136));?></a>
            <?endif;?>
        <?endif;?>
    </div>
</div>
        <hr/>
        <div class="rn_CenterText">
            <?if(
(\RightNow\Utils\Framework::isLoggedIn()) ):?>
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
