<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/standard', 1 => '/euf/assets/themes/standard', 2 => array ( '/euf/assets/themes/standard' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/standard', ), ));
get_instance()->_checkMeta(array('title'=>'' . SEO::getDynamicTitle('answer', getUrlParm('a_id')) . '', 'template'=>'standard.php', 'answer_details'=>'true', 'clickstream'=>'answer_view'));
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
use RightNow\Utils\Url;
class GuidedAssistant extends \RightNow\Libraries\Widget\Base {
function _standard_knowledgebase_GuidedAssistant_view ($data) {
extract($data);
?><? $question = $this->data['firstQuestion'];
$questionID = "{$this->data['guideID']}_{$question->questionID}";
?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<? if ($this->data['attrs']['popup_window_url']): ?>
    <button class="rn_PopupLaunchButton" onclick="window.open('<?= $this->data['attrs']['popup_window_url'] . \RightNow\Utils\Url::sessionParameter() ?>');"><?= $this->data['attrs']['label_popup_launch_button'] ?></button>
<? else: ?>
    <a id="rn_<?= $this->instanceID ?>_SamePageAnchor"></a>
    <div id="rn_<?= $this->instanceID ?>_Guide<?= $this->data['guideID'] ?>" class="rn_Guide">
        <div id="rn_<?= $this->instanceID ?>_Question<?= $questionID ?>" class="rn_Node rn_Question">
            <div class="rn_QuestionText">
                <?= $question->text ?>
            </div>
        <? switch ($question->type): case (1): ?>
            <div id="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>" class="rn_Response rn_ButtonQuestion">
            <? foreach ($question->responses as $response): ?>
                <button data-level="1" data-guide="<?= $this->data['guideID'] ?>" data-question="<?= $question->questionID ?>" data-response="<?= $response->responseID ?>"><?= $response->text ?></button>
            <? endforeach ?>
            </div>
        <? break;
case (2): case (3): ?>
            <? $className = $question->type === (3) ? "List" : "Menu";
$sizeAttribute = $question->type === (3) ? (count($question->responses) + 1) : 0;
?>
            <div id="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>" class="rn_Response rn_<?= $className ?>Question">
                <select data-level="1" data-guide="<?= $this->data['guideID'] ?>" data-question="<?= $question->questionID ?>" title="<?= $question->taglessText ?>" size="<?= $sizeAttribute ?>">
                    <option value="">--</option>
                <? foreach ($question->responses as $response): ?>
                    <option value="<?= $response->responseID ?>"><?= $response->text ?></option>
                <? endforeach;
?>
                </select>
            </div>
        <? break;
case (5): ?>
            <div id="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>" class="rn_Response rn_LinkQuestion">
                <fieldset>
                    <legend>
                        <span class="rn_ScreenReaderOnly"><?= $question->taglessText ?></span>
                    </legend>
                <? $inputClass = $this->data['js']['mobile'] ? "rn_TransparentScreenReaderOnly" : "rn_ScreenReaderOnly";
foreach ($question->responses as $response): $id = "rn_{$this->instanceID}_Response{$questionID}_{$response->responseID}";
?>
                    <div>
                        <input tabindex="-1" data-level="1" data-guide="<?= $this->data['guideID'] ?>" data-question="<?= $question->questionID ?>" data-response="<?= $response->responseID ?>" class="<?= $inputClass?>" type="radio" id="<?= $id ?>" name="rn_<?= $this->instanceID ?>_LinkResponse<?= $questionID ?>" value="<?= $response->responseID ?>"/>
                        <label for="<?= $id ?>"><a href="javascript:void(0);" onclick="document.getElementById('<?= $id ?>').click(); return false;"><?= $response->text ?></a></label>
                    </div>
                <? endforeach;
?>
                </fieldset>
            </div>
        <? break;
case (4): ?>
            <div id="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>" class="rn_Response rn_RadioQuestion">
                <fieldset>
                    <legend>
                        <span class="rn_ScreenReaderOnly"><?= $question->taglessText ?></span>
                    </legend>
                <? foreach ($question->responses as $response): ?>
                    <div>
                        <input type="radio" data-level="1" data-guide="<?= $this->data['guideID'] ?>" data-question="<?= $question->questionID ?>" data-response="<?= $response->responseID ?>" id="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>_<?= $response->responseID ?>" name="rn_<?= $this->instanceID ?>_RadioResponse<?= $questionID ?>" value="<?= $response->responseID ?>"/>
                        <label for="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>_<?= $response->responseID ?>"><?= $response->text ?></label>
                    </div>
                <? endforeach;
?>
                </fieldset>
            </div>
        <? break;
case (7): ?>
            <div id="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>" class="rn_Response rn_ImageQuestion">
                <fieldset>
                    <legend>
                        <span class="rn_ScreenReaderOnly"><?= $question->taglessText ?></span>
                    </legend>
                <? foreach ($question->responses as $response): ?>
                    <div>
                        <label for="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>_<?= $response->responseID ?>">
                        <? $altText = (!$response->showCaption) ? $response->text : "";
?>
                        <img src="/ci/fattach/get/<?= $response->imageID ?>" alt="<?= $altText ?>"/>
                            <span class="rn_ImageCaption">
                                <input type="radio" data-level="1" data-guide="<?= $this->data['guideID'] ?>" data-question="<?= $question->questionID ?>" data-response="<?= $response->responseID ?>" id="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>_<?= $response->responseID ?>" name="rn_<?= $this->instanceID ?>_ImageResponse<?= $questionID ?>" value="<?= $response->responseID ?>"/>
                                <? if ($response->showCaption): ?>
                                <?= $response->text ?>
                                <? endif;
?>
                            </span>
                        </label>
                    </div>
                <? endforeach;
?>
                </fieldset>
            </div>
        <? break;
case (6): ?>
            <div id="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>" class="rn_Response rn_TextQuestion">
                <? $response = $question->responses[0];
?>
                <label class="rn_Label" for="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>_<?= $response->responseID ?>"><?= $response->text ?> <span class="rn_Required" aria-hidden="true"> <?= \RightNow\Utils\Config::getMessage((1908)) ?> </span><span class="rn_ScreenReaderOnly" aria-hidden="true"><?= \RightNow\Utils\Config::getMessage((7015))?></span></label>
                <input type="text" id="rn_<?= $this->instanceID ?>_Response<?= $questionID ?>_<?= $response->responseID ?>" maxlength="255" aria-required="true"/>
                <button data-level="1" data-guide="<?= $this->data['guideID'] ?>" data-question="<?= $question->questionID ?>" data-response="<?= $response->responseID ?>"><?= $this->data['attrs']['label_text_response_button'] ?></button>
            </div>
        <? break;
endswitch;
?>
        <? if ($this->data['js']['agentMode'] && $this->data['js']['agentMode'] !== 'enduserPreview'): ?>
            <? if ($question->agentText): ?>
                <pre class="rn_AgentText"><em><?= \RightNow\Utils\Config::getMessage((948)) ?></em><?= $question->agentText ?></pre>
            <? endif;
?>
            <? if($this->data['js']['isChatAgent']): ?>
                <a class="rn_ChatLink" href='javascript:void(0);' data-guide="<?= $this->data['guideID'] ?>" data-question="<?= $question->questionID ?>"><?= \RightNow\Utils\Config::getMessage((928)) ?></a>
            <? endif;
?>
        <? endif;
?>
        </div>
    </div>
    <? if ($this->data['attrs']['single_question_display']): ?>
    <button id="rn_<?= $this->instanceID ?>_BackButton" class="rn_Hidden rn_BackButton"><?= $this->data['attrs']['label_question_back'] ?></button>
    <? endif;
?>
<? endif;
?>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
$this->setAjaxHandlers(array( 'guide_request_ajax' => 'getGuideAsArray', ));
}
function getData() {
if ($this->data['attrs']['static_guide_id']) {
$guideID = $this->data['attrs']['static_guide_id'];
}
else if ($guideID = Url::getParameter('g_id')) {
$guideID = intval($guideID);
}
else if (($answerID = Url::getParameter('a_id')) && ($answer = $this->CI->model('Answer')->get($answerID)->result)) {
$guideID = $answer->GuidedAssistance ? $answer->GuidedAssistance->ID : null;
}
if($guideID) {
if($this->data['attrs']['popup_window_url']) {
$this->data['attrs']['popup_window_url'] = \RightNow\Utils\Url::addParameter($this->data['attrs']['popup_window_url'], 'g_id', $guideID);
return;
}
$langID = Url::getParameter('lang');
$guidedAssistant = $this->CI->model('Guidedassistance')->get($guideID, $langID)->result;
if($guidedAssistant) {
$this->data['firstQuestion'] = $guidedAssistant->questions[0];
$this->data['guideID'] = $guidedAssistant->guideID;
$this->data['js'] = array( 'guidedAssistant' => $guidedAssistant->toArray(), 'types' => array('QUESTION_RESPONSE' => (1), 'GUIDE_RESPONSE' => (2), 'ANSWER_RESPONSE' => (4), 'TEXT_RESPONSE' => (8), 'URL_POST' => (2), 'URL_GET' => (1), 'BUTTON_QUESTION' => (1), 'MENU_QUESTION' => (2), 'LIST_QUESTION' => (3), 'LINK_QUESTION' => (5), 'IMAGE_QUESTION' => (7), 'TEXT_QUESTION' => (6), 'RADIO_QUESTION' => (4)), 'session' => $this->CI->session->getSessionData('sessionID'), 'channel' => (1));
if($langID) {
$this->data['js']['langID'] = $langID;
}
if($mobileBrowser = $this->CI->agent->supportedMobileBrowser()){
$this->data['js']['mobile'] = $mobileBrowser;
}
$this->data['js']['isSpider'] = $this->CI->rnow->isSpider();
$metaInfo = $this->CI->_getMetaInformation();
if(strtolower($metaInfo['account_session_required']) === 'true') {
$this->processAgentMode();
}
return;
}
}
return false;
}
function getGuideAsArray($params) {
$guideID = intval($params['guideID']);
$langID = intval($params['langID']);
echo json_encode(($guide = $this->CI->model('Guidedassistance')->get($guideID, $langID)->result) ? $guide->toArray() : array());
}
protected function processAgentMode() {
if($consoleMode = Url::getParameter('preview')) {
$this->data['js']['agentMode'] = ($consoleMode === 'agent') ? 'agentPreview' : 'enduserPreview';
}
else {
$this->data['js']['agentMode'] = 'agent';
}
$this->data['js']['accountID'] = intval(Url::getParameter('account_id'));
$this->addJavaScriptInclude(\RightNow\Utils\Url::getCoreAssetPath('debug-js/RightNow.Agent.js'));
if(Url::getParameter('chat')) {
$this->data['js']['isChatAgent'] = true;
$this->data['js']['channel'] = (3);
}
else {
$this->data['js']['channel'] = (2);
}
}
}
function _standard_knowledgebase_GuidedAssistant_header() {
$result = array( 'js_name' => 'RightNow.Widgets.GuidedAssistant', 'library_name' => 'GuidedAssistant', 'view_func_name' => '_standard_knowledgebase_GuidedAssistant_view', 'meta' => array ( 'controller_path' => 'standard/knowledgebase/GuidedAssistant', 'view_path' => 'standard/knowledgebase/GuidedAssistant', 'js_path' => 'standard/knowledgebase/GuidedAssistant', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/GuidedAssistant.css', 1 => 'assets/themes/standard/widgetCss/GuidedAssistant.css', ), 'base_css' => array ( 0 => 'standard/knowledgebase/GuidedAssistant/base.css', ), 'js_templates' => array ( 'answerResult' => '<div class="rn_Result rn_ResultLink"><% if (heading) { %> <div class="rn_ResultHeading"><%= heading %></div><% } %><% for (var i = 0; i < answers.length; i++) { %> <a href="<%= answers[i].link %>" data-answer="<%= answers[i].id %>" data-guide="<%= guideID %>" data-question="<%= questionID %>" data-response="<%= responseID %>" target="<%= target %>"><%= answers[i].summary %></a><% } %></div>', 'buttonResponse' => '<div class="name"><% for (var i = 0; i < responses.length; i++) { %> <button data-level="<%= level %>" data-guide="<%= guideID %>" data-question="<%= questionID %>" data-response="<%= responses[i].responseID %>"><%= responses[i].text %></button><% } %></div>', 'imageResponse' => '<fieldset> <legend> <span class="rn_ScreenReaderOnly"><%= accessibleText %></span> </legend><% for (var i = 0, altText; i < responses.length; i++) { %> <div> <label for="<%= id + responses[i].responseID %>"> <% altText = (!responses[i].showCaption) ? responses[i].text : ""; %> <img src="/ci/fattach/get/<%= responses[i].imageID %>" alt="<%= altText %>"/> <span class="rn_ImageCaption"> <input type="radio" data-level="<%= level %>" data-guide="<%= guideID %>" data-question="<%= questionID %>" data-response="<%= responses[i].responseID %>" id="<%= id + responses[i].responseID %>" name="<%= id + \'_\' + questionID %>" value="<%= responses[i].responseID %>"/> <% if (responses[i].showCaption) { %> <%= responses[i].text %> <% } %> </span> </label> </div><% } %></fieldset>', 'linkResponse' => '<fieldset> <legend> <span class="rn_ScreenReaderOnly"><%= accessibleText %></span> </legend><% for (var i = 0, inputID; i < responses.length; i++) { %> <div> <% inputID = id + responses[i].responseID; %> <input class="<%= className %>" tabindex="-1" type="radio" data-level="<%= level %>" data-guide="<%= guideID %>" data-question="<%= questionID %>" data-response="<%= responses[i].responseID %>" id="<%= inputID %>" name="<%= id + \'_\' + questionID %>" value="<%= responses[i].responseID %>"/> <label for="<%= inputID %>"><a href="javascript:void(0)" onclick="document.getElementById(\'<%= inputID %>\').click(); return false;"><%= responses[i].text %></a></label> </div><% } %></fieldset>', 'menuResponse' => '<select data-level="<%= level %>" data-guide="<%= guideID %>" data-question="<%= questionID %>" title="<%= accessibleText %>" size="<%= size %>"> <option value="">--</option><% for (var i = 0; i < responses.length; i++) { %> <option value="<%= responses[i].responseID %>"><%= responses[i].text %></option><% } %></select>', 'question' => '<div class="rn_QuestionText"> <%= questionText %></div><div id="<%= responseID %>" class="rn_Response <%= responseClass %>"> <%= responseContent %></div>', 'radioResponse' => '<fieldset> <legend> <span class="rn_ScreenReaderOnly"><%= accessibleText %></span> </legend><% for (var i = 0; i < responses.length; i++) { %> <div> <input type="radio" data-level="<%= level %>" data-guide="<%= guideID %>" data-question="<%= questionID %>" data-response="<%= responses[i].responseID %>" id="<%= id + responses[i].responseID %>" name="<%= id + \'_\' + questionID %>" value="<%= responses[i].responseID %>"/> <label for="<%= id + responses[i].responseID %>"><%= responses[i].text %></label> </div><% } %></fieldset>', 'textResponse' => '<label class="rn_Label" for="<%= id %>"> <%= responseText %> <span class="rn_Required" aria-hidden="true"><%= requiredLabel %></span> <span class="rn_ScreenReaderOnly" aria-hidden="true"><%= screenReaderLabel %></span></label><input type="text" id="<%= id %>" maxlength="255" aria-required="true"/><button data-level="<%= level %>" data-guide="<%= guideID %>" data-question="<%= questionID %>" data-response="<%= responseID %>"><%= label %></button>', 'textResult' => '<div class="rn_Result rn_ResultText"><% if (heading) { %> <div class="rn_ResultHeading"><%= heading %></div><% } %><%= resultText %></div>', ), 'template_path' => 'standard/knowledgebase/GuidedAssistant', 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4276)', 'urlParameters' => array ( 'a_id' => array ( 'name' => 'rn:msg:(9359)', 'description' => 'rn:msg:(985)', 'example' => 'a_id/7', ), 'g_id' => array ( 'name' => 'rn:msg:(2050)', 'description' => 'rn:msg:(2049)', 'example' => 'g_id/27', ), ), ), 'relativePath' => 'standard/knowledgebase/GuidedAssistant', 'widget_name' => 'GuidedAssistant', ), );
$result['meta']['attributes'] = array( 'guide_request_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajax/widget', 'type' => 'ajax', 'default' => '/ci/ajax/widget', 'inherited' => false, )), 'static_guide_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => null, 'type' => 'INT', 'default' => null, 'inherited' => false, )), 'label_question_back' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2040), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2040), 'inherited' => false, )), 'label_start_over' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3797), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3797), 'inherited' => false, )), 'label_answer_result' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3132), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3132), 'inherited' => false, )), 'label_text_result' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'popup_window_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_popup_launch_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2544), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2544), 'inherited' => false, )), 'label_text_response_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(864), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(864), 'inherited' => false, )), 'single_question_display' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'target' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'call_url_new_window' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Connect;
class DataDisplay extends \RightNow\Libraries\Widget\Output {
function _standard_output_DataDisplay_view ($data) {
extract($data);
?>
<?if(\RightNow\Utils\Connect::isFileAttachmentType($this->data['value'])):?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/FileListDisplay', array('sub_id' => 'file',));
?>
<?elseif(\RightNow\Utils\Connect::getProductCategoryType($this->data['value'])):?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/ProductCategoryDisplay', array('sub_id' => 'prodCat',));
?>
<?elseif(\RightNow\Utils\Connect::isIncidentThreadType($this->data['value'])):?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/IncidentThreadDisplay', array('sub_id' => 'incident',));
?>
<?else:?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/FieldDisplay', array('sub_id' => 'genericField',));
?>
<?endif;?>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(parent::getData() === false) return false;
}
}
function _standard_output_DataDisplay_header() {
$result = array( 'js_name' => '', 'library_name' => 'DataDisplay', 'view_func_name' => '_standard_output_DataDisplay_view', 'meta' => array ( 'controller_path' => 'standard/output/DataDisplay', 'view_path' => 'standard/output/DataDisplay', 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(41981)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(3918)', 'example' => 'kw/search', ), 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(993)', 'example' => 'a_id/3', ), 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), ), ), 'contains' => array ( 0 => array ( 'widget' => 'standard/output/FileListDisplay', 'versions' => array ( 0 => '1.1', ), ), 1 => array ( 'widget' => 'standard/output/ProductCategoryDisplay', 'versions' => array ( 0 => '1.1', ), ), 2 => array ( 'widget' => 'standard/output/IncidentThreadDisplay', 'versions' => array ( 0 => '1.0', ), ), 3 => array ( 'widget' => 'standard/output/FieldDisplay', 'versions' => array ( 0 => '1.1', ), ), ), 'relativePath' => 'standard/output/DataDisplay', 'widget_name' => 'DataDisplay', ), );
$result['meta']['attributes'] = array( );
return $result;
}
}
namespace RightNow\Widgets{
class AnswerFeedback extends \RightNow\Libraries\Widget\Base {
function _standard_feedback_AnswerFeedback_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID?>" class="<?= $this->classList ?>">
    <? ?>
    <div id="rn_<?=$this->instanceID?>_AnswerFeedbackControl" class="rn_AnswerFeedbackControl">
        <? if ($this->data['attrs']['label_title']): ?>
            <div class="rn_Title"><?=$this->data['attrs']['label_title']?></div>
        <? endif;?>
        <?
if ($this->data['js']['buttonView']): ?>
            <?= $this->render('buttonView') ?>
        <? elseif ($this->data['attrs']['use_rank_labels']):?>
            <?= $this->render('rankLabels') ?>
        <? else:?>
            <?= $this->render('ratingMeter') ?>
        <? endif;?>
    </div>
    <?
?>
    <div id="rn_<?=$this->instanceID?>_AnswerFeedbackForm" class="rn_AnswerFeedbackForm rn_Hidden">
        <div id="rn_<?=$this->instanceID?>_DialogDescription" class="rn_DialogSubtitle"><?=$this->data['attrs']['label_dialog_description'];?></div>
        <div id="rn_<?=$this->instanceID;?>_ErrorMessage"></div>
        <form>
        <?
if (!$this->data['js']['isProfile']): ?>
            <label for="rn_<?=$this->instanceID?>_EmailInput"><?=$this->data['attrs']['label_email_address'];?><span class="rn_Required" > <?=\RightNow\Utils\Config::getMessage((1908));?></span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage((7015))?></span></label>
            <input id="rn_<?=$this->instanceID?>_EmailInput"  class="rn_EmailField" type="text" value="<?=$this->data['js']['email'];?>"/>
        <?
endif;?>
        <label for="rn_<?=$this->instanceID?>_FeedbackTextarea"><?=$this->data['attrs']['label_comment_box'];?><span class="rn_Required" > <?=\RightNow\Utils\Config::getMessage((1908));?></span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage((7015))?></span></label>
        <textarea id="rn_<?=$this->instanceID?>_FeedbackTextarea" class="rn_Textarea" rows="4" cols="60"></textarea>
        </form>
    </div>
    <?
?>
</div>
<? }
function _standard_feedback_AnswerFeedback_buttonView ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID?>_RatingButtons">
    <button id="rn_<?=$this->instanceID?>_RatingYesButton" type="button"><?=$this->data['attrs']['label_yes_button']?></button>
    <button id="rn_<?=$this->instanceID?>_RatingNoButton" type="button"><?=$this->data['attrs']['label_no_button']?></button>
</div>
<? }
function _standard_feedback_AnswerFeedback_ratingMeter ($data) {
extract($data);
?><div id="rn_<?= $this->instanceID;?>_RatingMeter" class="rn_RatingMeter <?=
$this->data['RatingMeterHidden'];?>" role="application">
    <?
if ($this->data['attrs']['options_descending']): ?>
        <? for($i = $this->data['attrs']['options_count'];
$i > 0;
$i--): ?>
             <? echo "<a id='rn_".$this->instanceID.'_RatingCell_'.$i."' href='javascript:void(0)' class='rn_RatingCell' title='".\RightNow\Utils\Config::getMessage($this->data['rateLabels'][$i])."' ".sprintf('><span class="rn_ScreenReaderOnly">'.$this->data['attrs']['label_accessible_option_description'], $i, $this->data['attrs']['options_count']).'</span>&nbsp;</a>';
?>
        <? endfor;
?>
    <? else: ?>
        <? for($i = 1;
$i <= $this->data['attrs']['options_count'];
$i++): ?>
            <? echo "<a id='rn_".$this->instanceID.'_RatingCell_'.$i."' href='javascript:void(0)' class='rn_RatingCell' title='".\RightNow\Utils\Config::getMessage($this->data['rateLabels'][$i])."' ".sprintf('><span class="rn_ScreenReaderOnly">'.$this->data['attrs']['label_accessible_option_description'], $i, $this->data['attrs']['options_count']).'</span>&nbsp;</a>';
?>
        <? endfor;
?>
    <? endif;
?>
</div>
<? }
function _standard_feedback_AnswerFeedback_rankLabels ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID?>_RatingButtons">
    <? if ($this->data['attrs']['options_descending']): ?>
        <? for($i = $this->data['attrs']['options_count'];
$i > 0;
$i--): ?>
            <button id="rn_<?=$this->instanceID?>_RatingButton_<?=$i?>" type="button"><?=\RightNow\Utils\Config::getMessage($this->data['rateLabels'][$i])?></button>
        <? endfor;
?>
    <? else: ?>
        <? for($i = 1;
$i <= $this->data['attrs']['options_count'];
$i++): ?>
            <button id="rn_<?=$this->instanceID?>_RatingButton_<?=$i?>" type="button"><?=\RightNow\Utils\Config::getMessage($this->data['rateLabels'][$i])?></button>
        <? endfor;
?>
    <? endif;
?>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['js'] = array( 'f_tok' => \RightNow\Utils\Framework::createTokenWithExpiration(0), 'isProfile' => false, 'email' => '', 'buttonView' => ($this->data['attrs']['options_count'] === 2), );
$this->data['rateLabels'] = $this->getRateLabels();
$answerID = \RightNow\Utils\Url::getParameter('a_id');
if($answerID) {
$answerData = $this->CI->model('Answer')->get($answerID);
if($answerData->error){
return false;
}
$this->data['js']['summary'] = $answerData->result->Summary;
$this->data['js']['answerID'] = $answerID;
}
else {
$this->data['js']['summary'] = \RightNow\Utils\Config::getMessage((4727));
$this->data['js']['answerID'] = null;
}
if(\RightNow\Utils\Framework::isLoggedIn()){
$this->data['js']['email'] = $this->CI->session->getProfileData('email');
$this->data['js']['isProfile'] = true;
}
else if($previousEmail = $this->CI->session->getSessionData('previouslySeenEmail')) {
$this->data['js']['email'] = $previousEmail;
}
}
protected function getRateLabels() {
switch($this->data['attrs']['options_count']) {
case 3: return array(null, (19296), (19300), (19297));
case 4: return array(null, (19296), (19299), (19302), (19297));
case 5: return array(null, (19296), (19299), (19300), (19302), (19297));
default: return array();
}
}
}
function _standard_feedback_AnswerFeedback_header() {
$result = array( 'js_name' => 'RightNow.Widgets.AnswerFeedback', 'library_name' => 'AnswerFeedback', 'view_func_name' => '_standard_feedback_AnswerFeedback_view', 'meta' => array ( 'controller_path' => 'standard/feedback/AnswerFeedback', 'view_path' => 'standard/feedback/AnswerFeedback', 'view_partials' => array ( 0 => 'buttonView.html.php', 1 => 'ratingMeter.html.php', 2 => 'rankLabels.html.php', ), 'js_path' => 'standard/feedback/AnswerFeedback', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/AnswerFeedback.css', ), 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', ), ), 'info' => array ( 'description' => 'rn:msg:(42103)', 'urlParameters' => array ( 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(998)', 'example' => 'a_id/3', ), ), ), 'relativePath' => 'standard/feedback/AnswerFeedback', 'widget_name' => 'AnswerFeedback', ), );
$result['meta']['attributes'] = array( 'submit_rating_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/submitAnswerRating', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/submitAnswerRating', 'inherited' => false, )), 'submit_feedback_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/submitAnswerFeedback', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/submitAnswerFeedback', 'inherited' => false, )), 'label_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4177), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(4177), 'inherited' => false, )), 'label_accessible_option_description' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3317), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3317), 'inherited' => false, )), 'label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3293), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3293), 'inherited' => false, )), 'label_dialog_description' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3330), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3330), 'inherited' => false, )), 'dialog_width' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '375px', 'type' => 'string', 'default' => '375px', 'inherited' => false, )), 'options_count' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 2, 'type' => 'int', 'default' => 2, 'min' => 2, 'max' => 5, 'inherited' => false, )), 'options_descending' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'label_yes_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(869), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(869), 'inherited' => false, )), 'label_no_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(863), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(863), 'inherited' => false, )), 'feedback_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'dialog_threshold' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 1, 'type' => 'int', 'default' => 1, 'min' => 0, 'inherited' => false, )), 'label_feedback_submit' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3911), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3911), 'inherited' => false, )), 'label_email_address' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(8256), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(8256), 'inherited' => false, )), 'label_comment_box' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4546), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(4546), 'inherited' => false, )), 'label_send_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4550), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(4550), 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(849), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(849), 'inherited' => false, )), 'use_rank_labels' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class RelatedAnswers extends \RightNow\Libraries\Widget\Base {
function _standard_knowledgebase_RelatedAnswers_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
<?if($this->data['attrs']['label_title']):?>
    <h2><?=$this->data['attrs']['label_title'];?></h2>
<?endif;?>
    <ul>
    <?
foreach($this->data['relatedAnswers'] as $answer):?>
        <li><a href="<?=$this->data['attrs']['url'].'/a_id/'.$answer->ID . $this->data['appendedParameters'];?>" target="<?=$this->data['attrs']['target'];?>"> <?=$answer->FormattedTitle;?></a></li>
    <?
endforeach;?>
    </ul>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']) . '/related/1' . \RightNow\Utils\Url::sessionParameter();
if($answerID = \RightNow\Utils\Url::getParameter('a_id')) {
$relatedAnswers = $this->CI->model('Answer')->getRelatedAnswers($answerID, $this->data['attrs']['limit']);
if($relatedAnswers->error || (is_array($relatedAnswers->result) && count($relatedAnswers->result) === 0)) return false;
$this->data['relatedAnswers'] = $relatedAnswers->result;
foreach($this->data['relatedAnswers'] as $answer){
$answer->FormattedTitle = $answer->Title;
}
if(($this->data['attrs']['highlight'] && ($searchTerm = \RightNow\Utils\Url::getParameter('kw'))) || $this->data['attrs']['truncate_size']) {
foreach($this->data['relatedAnswers'] as $answer){
if($this->data['attrs']['truncate_size']){
$answer->FormattedTitle = \RightNow\Utils\Text::truncateText($answer->FormattedTitle, $this->data['attrs']['truncate_size']);
}
if($this->data['attrs']['highlight'] && $searchTerm){
$answer->FormattedTitle = \RightNow\Utils\Text::emphasizeText($answer->FormattedTitle);
}
}
}
}
else {
return false;
}
}
}
function _standard_knowledgebase_RelatedAnswers_header() {
$result = array( 'js_name' => '', 'library_name' => 'RelatedAnswers', 'view_func_name' => '_standard_knowledgebase_RelatedAnswers_view', 'meta' => array ( 'controller_path' => 'standard/knowledgebase/RelatedAnswers', 'view_path' => 'standard/knowledgebase/RelatedAnswers', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/RelatedAnswers.css', 1 => 'assets/themes/standard/widgetCss/RelatedAnswers.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(4301)', 'urlParameters' => array ( 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(5136)', 'example' => 'a_id/3', ), 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(2087)', 'example' => 'kw/searchTerm', ), ), ), 'relativePath' => 'standard/knowledgebase/RelatedAnswers', 'widget_name' => 'RelatedAnswers', ), );
$result['meta']['attributes'] = array( 'limit' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 5, 'type' => 'int', 'default' => 5, 'inherited' => false, )), 'target' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '_self', 'type' => 'string', 'default' => '_self', 'inherited' => false, )), 'label_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4572), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(4572), 'inherited' => false, )), 'url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((222)), 'type' => 'string', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((222)), 'inherited' => false, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'boolean', 'default' => true, 'inherited' => false, )), 'truncate_size' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'int', 'default' => 0, 'min' => 0, 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'string', 'default' => 'kw', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class PreviousAnswers extends \RightNow\Libraries\Widget\Base {
function _standard_knowledgebase_PreviousAnswers_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
<? if($this->data['attrs']['label_title']):?>
    <h2><?=$this->data['attrs']['label_title'];?></h2>
<?
endif;?>
    <ul>
    <?
for($i = 0;
$i < count($this->data['previousAnswers']);
$i++):?>
        <li><a href="<?=$this->data['attrs']['url'].'/a_id/'.$this->data['previousAnswers'][$i][0] . $this->data['appendedParameters'] . \RightNow\Utils\Url::sessionParameter();?>" target="<?=$this->data['attrs']['target'];?>"><?=$this->data['previousAnswers'][$i][1];?></a></li>
    <?
endfor;?>
    </ul>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$previousAnswers = $this->CI->model('Answer')->getPreviousAnswers(\RightNow\Utils\Url::getParameter('a_id'), $this->data['attrs']['limit'], $this->data['attrs']['truncate_size']);
if($previousAnswers->error || $previousAnswers->result === null || (is_array($previousAnswers->result) && count($previousAnswers->result) === 0)) return false;
$this->data['previousAnswers'] = $previousAnswers->result;
$this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']);
if($this->data['attrs']['highlight'] && \RightNow\Utils\Url::getParameter('kw')) {
for($i = 0;
$i < count($this->data['previousAnswers']);
$i++) $this->data['previousAnswers'][$i][1] = \RightNow\Utils\Text::emphasizeText($this->data['previousAnswers'][$i][1]);
}
}
}
function _standard_knowledgebase_PreviousAnswers_header() {
$result = array( 'js_name' => '', 'library_name' => 'PreviousAnswers', 'view_func_name' => '_standard_knowledgebase_PreviousAnswers_view', 'meta' => array ( 'controller_path' => 'standard/knowledgebase/PreviousAnswers', 'view_path' => 'standard/knowledgebase/PreviousAnswers', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/PreviousAnswers.css', 1 => 'assets/themes/standard/widgetCss/PreviousAnswers.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(4299)', 'urlParameters' => array ( 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(995)', 'example' => 'a_id/3', ), 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(2087)', 'example' => 'kw/searchTerm', ), ), ), 'relativePath' => 'standard/knowledgebase/PreviousAnswers', 'widget_name' => 'PreviousAnswers', ), );
$result['meta']['attributes'] = array( 'limit' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 5, 'type' => 'int', 'default' => 5, 'min' => 0, 'inherited' => false, )), 'target' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '_self', 'type' => 'string', 'default' => '_self', 'inherited' => false, )), 'label_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4593), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(4593), 'inherited' => false, )), 'url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((222)), 'type' => 'string', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((222)), 'inherited' => false, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'boolean', 'default' => true, 'inherited' => false, )), 'truncate_size' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'int', 'default' => 0, 'min' => 0, 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'string', 'default' => 'kw', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class SocialBookmarkLink extends \RightNow\Libraries\Widget\Base {
function _standard_utils_SocialBookmarkLink_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <a id="rn_<?=$this->instanceID;?>_Link" href="javascript:void(0);" title="<?=$this->data['attrs']['label_tooltip']?>">
        <?
if($this->data['attrs']['icon_path']): ?>
        <img src="<?=$this->data['attrs']['icon_path'];?>" alt="<?=$this->data['attrs']['label_icon_alt']?>"/>
        <?
endif;
?>
        <span><?=$this->data['attrs']['label_link'];?></span>
    </a>
    <div id="rn_<?=$this->instanceID;?>_Panel" class="rn_Panel rn_Hidden">
        <ul>
        <?
for ($i = 0;
$i < count($this->data['sites']);
$i++): ?>
            <li class="rn_Link<?=$i + 1;?>">
                <a href="<?=$this->data['sites'][$i]['link'];?>" target="_blank" title="<?=$this->data['sites'][$i]['title'];?>"><?=$this->data['sites'][$i]['name'];?></a>
            </li>
        <?
endfor;
?>
        </ul>
    </div>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$pageTitle = \RightNow\Libraries\SEO::getDynamicTitle('answer', \RightNow\Utils\Url::getParameter('a_id'));
$pageTitle = urlencode(htmlspecialchars_decode($pageTitle));
$pageUrl = \RightNow\Utils\Url::getShortEufBaseUrl('sameAsCurrentPage', '/app/' . $this->CI->page . '/a_id/' . \RightNow\Utils\Url::getParameter('a_id'));
$this->data['sites'] = array();
$pages = explode(',', $this->data['attrs']['sites']);
foreach($pages as $page) {
list($name, $title, $link) = explode('>', trim($page, ' "\''));
$link = str_replace('|URL|', $pageUrl, $link);
$link = str_replace('|TITLE|', $pageTitle, $link);
$this->data['sites'] []= array('name' => trim($name, '"\''), 'title' => trim($title, '"\''), 'link' => trim($link, '"\''));
}
if(!count($this->data['sites'])) return false;
}
}
function _standard_utils_SocialBookmarkLink_header() {
$result = array( 'js_name' => 'RightNow.Widgets.SocialBookmarkLink', 'library_name' => 'SocialBookmarkLink', 'view_func_name' => '_standard_utils_SocialBookmarkLink_view', 'meta' => array ( 'controller_path' => 'standard/utils/SocialBookmarkLink', 'view_path' => 'standard/utils/SocialBookmarkLink', 'js_path' => 'standard/utils/SocialBookmarkLink', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/SocialBookmarkLink.css', ), 'base_css' => array ( 0 => 'standard/utils/SocialBookmarkLink/base.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', ), 'yui' => array ( 0 => 'panel', ), ), 'info' => array ( 'description' => 'rn:msg:(4221)', 'urlParameters' => array ( 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'key' => 'a_id', 'required' => true, 'description' => 'rn:msg:(1009)', 'example' => 'a_id/3', ), ), ), 'relativePath' => 'standard/utils/SocialBookmarkLink', 'widget_name' => 'SocialBookmarkLink', ), );
$result['meta']['attributes'] = array( 'icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/Share.png', 'type' => 'STRING', 'default' => 'images/Share.png', 'inherited' => false, )), 'label_icon_alt' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(28786), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(28786), 'inherited' => false, )), 'label_tooltip' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3626), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3626), 'inherited' => false, )), 'sites' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => sprintf('Facebook > %s > http://facebook.com/sharer.php?u=|URL|, Twitter > %s > http://twitter.com/home?status=|TITLE|+|URL|, LinkedIn > %s > http://www.linkedin.com/shareArticle?mini=true&amp;url=|URL|&amp;title=|TITLE|&amp;summary=|TITLE|&amp;source=|URL|, Reddit > %s > http://reddit.com/submit?url=|URL|&amp;title=|TITLE|', \RightNow\Utils\Config::getMessage((3226)), \RightNow\Utils\Config::getMessage((3997)), \RightNow\Utils\Config::getMessage((42533)), \RightNow\Utils\Config::getMessage((3227))), 'type' => 'STRING', 'default' => sprintf('Facebook > %s > http://facebook.com/sharer.php?u=|URL|, Twitter > %s > http://twitter.com/home?status=|TITLE|+|URL|, LinkedIn > %s > http://www.linkedin.com/shareArticle?mini=true&amp;url=|URL|&amp;title=|TITLE|&amp;summary=|TITLE|&amp;source=|URL|, Reddit > %s > http://reddit.com/submit?url=|URL|&amp;title=|TITLE|', \RightNow\Utils\Config::getMessage((3226)), \RightNow\Utils\Config::getMessage((3997)), \RightNow\Utils\Config::getMessage((42533)), \RightNow\Utils\Config::getMessage((3227))), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class PrintPageLink extends \RightNow\Libraries\Widget\Base {
function _standard_utils_PrintPageLink_view ($data) {
extract($data);
?><span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <a onclick="window.print(); return false;" href="javascript:void(0);" title="<?=$this->data['attrs']['label_tooltip'];?>">
        <?
if($this->data['attrs']['icon_path']):?>
            <img src="<?=$this->data['attrs']['icon_path'];?>" alt="<?=$this->data['attrs']['label_icon_alt']?>"/>
        <?
endif;?>
        <span><?=$this->data['attrs']['label_link'];?></span>
    </a>
</span>
<?
}
}
function _standard_utils_PrintPageLink_header() {
$result = array( 'js_name' => '', 'library_name' => 'PrintPageLink', 'view_func_name' => '_standard_utils_PrintPageLink_view', 'meta' => array ( 'controller_path' => 'standard/utils/PrintPageLink', 'view_path' => 'standard/utils/PrintPageLink', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/PrintPageLink.css', ), 'base_css' => array ( 0 => 'standard/utils/PrintPageLink/base.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(1194)', ), 'relativePath' => 'standard/utils/PrintPageLink', 'widget_name' => 'PrintPageLink', ), );
$result['meta']['attributes'] = array( 'label_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(859), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(859), 'inherited' => false, )), 'label_tooltip' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3255), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3255), 'inherited' => false, )), 'icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/Print.png', 'type' => 'filepath', 'default' => 'images/Print.png', 'inherited' => false, )), 'label_icon_alt' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class EmailAnswerLink extends \RightNow\Libraries\Widget\Base {
function _standard_utils_EmailAnswerLink_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID?>" class="<?= $this->classList ?>">
    <a id="rn_<?=$this->instanceID?>_Link" href="javascript:void(0);" title="<?=$this->data['attrs']['label_tooltip'];?>">
        <?
if($this->data['attrs']['icon_path']):?>
            <img src="<?=$this->data['attrs']['icon_path'];?>" alt="<?=$this->data['attrs']['label_icon_alt']?>"/>
        <?
endif;?>
        <span><?=$this->data['attrs']['label_link'];?></span>
    </a>
    <?
?>
    <div id="rn_<?=$this->instanceID?>_EmailAnswerLinkForm" class="rn_EmailAnswerLinkForm rn_Hidden">
        <div id="rn_<?=$this->instanceID;?>_ErrorMessage"></div>
        <form onsubmit="return false;">
        <label id="rn_<?=$this->instanceID?>_LabelRecipientEmail" for="rn_<?=$this->instanceID?>_InputRecipientEmail">
            <?=$this->data['attrs']['label_to'];?><span class="rn_Required"> <?=\RightNow\Utils\Config::getMessage((1908));?></span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage((7015))?></span>
        </label>
        <input id="rn_<?=$this->instanceID?>_InputRecipientEmail" type="email"/>
    <?
if(!$this->data['js']['isProfile']):?>
        <label id="rn_<?=$this->instanceID?>_LabelSenderEmail" for="rn_<?=$this->instanceID?>_InputSenderEmail">
            <?=$this->data['attrs']['label_sender_email'];?><span class="rn_Required"> <?=\RightNow\Utils\Config::getMessage((1908));?></span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage((7015))?></span>
        </label>
        <input id="rn_<?=$this->instanceID?>_InputSenderEmail" type="email" value="<?=$this->data['js']['senderEmail'];?>"/>
    <?
endif;?>
    <?
if(!$this->data['js']['senderName']):?>    
        <label id="rn_<?=$this->instanceID?>_LabelSenderName" for="rn_<?=$this->instanceID?>_InputSenderName">
            <?=$this->data['attrs']['label_sender_name'];?><span class="rn_Required"> <?=\RightNow\Utils\Config::getMessage((1908));?></span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage((7015))?></span>
        </label>
        <input id="rn_<?=$this->instanceID?>_InputSenderName" maxlength="70" type="text" value="<?=$this->data['js']['senderName'];?>"/>
    <?
endif;?>
        </form>
    </div>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
$this->setAjaxHandlers(array( 'send_email_ajax' => array( 'method' => 'emailAnswer', 'clickstream' => 'email_answer', ), ));
}
function getData() {
if (($answerID = \RightNow\Utils\Url::getParameter('a_id')) === null) return false;
$this->data['js'] = array( 'answerID' => $answerID, 'emailAnswerToken' => \RightNow\Utils\Framework::createTokenWithExpiration(146), 'isProfile' => false, );
if($profile = $this->CI->session->getProfile(true)) {
$this->data['js']['senderName'] = trim((\RightNow\Utils\Config::getConfig((134))) ? $profile->lastName . ' ' . $profile->firstName : $profile->firstName . ' ' . $profile->lastName);
$this->data['js']['senderEmail'] = $profile->email;
$this->data['js']['isProfile'] = true;
}
else {
$this->data['js']['senderEmail'] = $this->CI->session->getSessionData('previouslySeenEmail') ?: '';
}
}
static function emailAnswer($parameters) {
\RightNow\Libraries\AbuseDetection::check();
echo get_instance()->model('Answer')->emailToFriend($parameters['to'], $parameters['name'], $parameters['from'], $parameters['a_id'])->toJson();
}
}
function _standard_utils_EmailAnswerLink_header() {
$result = array( 'js_name' => 'RightNow.Widgets.EmailAnswerLink', 'library_name' => 'EmailAnswerLink', 'view_func_name' => '_standard_utils_EmailAnswerLink_view', 'meta' => array ( 'controller_path' => 'standard/utils/EmailAnswerLink', 'view_path' => 'standard/utils/EmailAnswerLink', 'js_path' => 'standard/utils/EmailAnswerLink', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/EmailAnswerLink.css', 1 => 'assets/themes/standard/widgetCss/EmailAnswerLink.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4346)', 'urlParameters' => array ( 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(997)', 'required' => true, 'example' => 'a_id/3', ), ), ), 'relativePath' => 'standard/utils/EmailAnswerLink', 'widget_name' => 'EmailAnswerLink', ), );
$result['meta']['attributes'] = array( 'label_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(5161), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(5161), 'inherited' => false, )), 'label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4694), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4694), 'inherited' => false, )), 'label_tooltip' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1726), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1726), 'inherited' => false, )), 'icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/Email.png', 'type' => 'filepath', 'default' => 'images/Email.png', 'inherited' => false, )), 'label_icon_alt' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_to' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3345), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3345), 'inherited' => false, )), 'label_sender_name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4452), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4452), 'inherited' => false, )), 'label_sender_email' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4701), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4701), 'inherited' => false, )), 'label_send_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(35430), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(35430), 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9555), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9555), 'inherited' => false, )), 'label_email_sent' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1730), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1730), 'inherited' => false, )), 'send_email_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajax/widget', 'type' => 'ajax', 'default' => '/ci/ajax/widget', 'inherited' => false, )), );
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
class FileListDisplay extends \RightNow\Libraries\Widget\Output {
function _standard_output_FileListDisplay_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <? if ($this->data['attrs']['label']): ?>
        <span class="rn_DataLabel"><?=$this->data['attrs']['label'];?></span>
    <?
endif;
?>
    <div class="rn_DataValue<?=$this->data['wrapClass']?>">
        <ul>
            <? foreach ($this->data['value'] as $attachment): ?>
               <? if (!($attachment->Private === true)): ?>
                <li>
                    <a href="<?=$attachment->AttachmentUrl;?>" target="<?=$attachment->Target
?>">
                        <?if($attachment->ThumbnailUrl && $attachment->ThumbnailScreenReaderText):?>
                            <img src='<?=$attachment->ThumbnailUrl;?>' class='rn_FileTypeImageThumbnail' alt='<?=\RightNow\Utils\Config::getMessage((45012));?>' />
                            <span class='rn_ScreenReaderOnly'><?=$attachment->ThumbnailScreenReaderText;?></span>
                        <?else:?>
                            <?=$attachment->Icon;?>
                        <?endif;?>
                        <?=
$attachment->Name ?: $attachment->FileName ?>
                    </a>
                   <? if ($this->data['attrs']['display_file_size']): ?>
                    <span class="rn_FileSize">(<?=$attachment->ReadableSize;?>)</span>
                   <?
endif;
?>
                </li>
               <? endif;
?>
            <? endforeach;
?>
        </ul>
   </div>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(parent::getData() === false) return false;
if($this->data['attrs']['name'] === 'Answer.FileAttachments'){
if(($answerID = \RightNow\Utils\Url::getParameter('a_id')) && ($answer = $this->CI->model('Answer')->get($answerID)->result)){
$commonAttachments = (array)$answer->CommonAttachments;
}
}
if(!$this->data['value'] || !count($this->data['value']) && !$commonAttachments && !count($commonAttachments)) return false;
if(!\RightNow\Utils\Connect::isFileAttachmentType($this->data['value'])){
echo $this->reportError(\RightNow\Utils\Config::getMessage((1927)));
return false;
}
$attachmentArray = (array)$this->data['value'];
$displayingIncidents = $this->table === "Incident";
if($commonAttachments) $attachmentArray = array_merge(array_values($attachmentArray), array_values($commonAttachments));
$openInNewWindow = trim(\RightNow\Utils\Config::getConfig((247)));
$attachmentUrl = "/ci/fattach/get/%s/%s" . \RightNow\Utils\Url::sessionParameter() . "/filename/%s";
$showCreatedTime = \RightNow\Utils\Text::beginsWith($this->data['attrs']['name'], 'Incident.');
foreach ($attachmentArray as $item) {
$item->Target = ($openInNewWindow && preg_match("/{$openInNewWindow}/i",
$item->ContentType)) ? '_blank' : '_self';
$item->Icon = \RightNow\Utils\Framework::getIcon($item->FileName);
$item->ReadableSize = \RightNow\Utils\Text::getReadableFileSize($item->Size);
$item->AttachmentUrl = sprintf($attachmentUrl, $item->ID, $showCreatedTime ? $item->CreatedTime : 0, urlencode($item->FileName));
$item->ThumbnailUrl = null;
$item->ThumbnailScreenReaderText = null;
if($this->data['attrs']['display_thumbnail'] && \RightNow\Utils\Text::beginsWith($item->ContentType, 'image')) {
$fileExtension = pathinfo($item->AttachmentUrl, PATHINFO_EXTENSION);
$fileExtension = \RightNow\Utils\Text::escapeHtml($fileExtension);
$item->ThumbnailScreenReaderText = sprintf(\RightNow\Utils\Config::getMessage((40926)), $fileExtension);
$item->ThumbnailUrl = $item->AttachmentUrl;
}
}
$this->data['value'] = array_values($attachmentArray);
if ($this->data['attrs']['sort_by_filename']) {
usort($this->data['value'], function($a, $b) {
return strcasecmp($a->FileName, $b->FileName);
});
}
$this->data['wrapClass'] = ($this->data['attrs']['left_justify']) ? ' rn_LeftJustify' : '';
}
}
function _standard_output_FileListDisplay_header() {
$result = array( 'js_name' => '', 'library_name' => 'FileListDisplay', 'view_func_name' => '_standard_output_FileListDisplay_view', 'meta' => array ( 'controller_path' => 'standard/output/FileListDisplay', 'view_path' => 'standard/output/FileListDisplay', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/FileListDisplay.css', 1 => 'assets/themes/mobile/widgetCss/FileListDisplay.css', 2 => 'assets/themes/standard/widgetCss/FileListDisplay.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(41979)', 'urlParameters' => array ( 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(993)', 'example' => 'a_id/3', ), 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), ), ), 'relativePath' => 'standard/output/FileListDisplay', 'widget_name' => 'FileListDisplay', ), );
$result['meta']['attributes'] = array( 'display_thumbnail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'STRING', 'default' => '{default_label}', 'inherited' => false, )), 'left_justify' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'display_file_size' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'sort_by_filename' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ProductCategoryDisplay extends \RightNow\Libraries\Widget\Output {
function _standard_output_ProductCategoryDisplay_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
<? if ($this->data['attrs']['label']): ?>
    <span class="rn_DataLabel"><?=$this->data['attrs']['label'];?></span>
<?
endif;
?>
    <div class="rn_DataValue<?=$this->data['wrapClass']?>">
        <ul>
        <? foreach($this->data['value'] as $item):?>
            <li>
            <?= str_repeat('&nbsp;&nbsp;', $item['Depth']) ?>
            <? $value = htmlspecialchars($item['Name'], ENT_QUOTES, 'UTF-8');
?>
            <? if ($this->data['attrs']['report_page_url']): ?>
                <a href="<?=$this->data['attrs']['report_page_url'] . '/' . $this->data['filterKey'] . '/' . $item['ID'] . $this->data['appendedParameters'];?>"><?=$value;?></a>
            <?
else: ?>
                <?=$value;?>
            <?
endif;
?>
            </li>
        <? endforeach;
?>
        </ul>
    </div>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(parent::getData() === false) return false;
if(!$type = \RightNow\Utils\Connect::getProductCategoryType($this->data['value'])){
echo $this->reportError(\RightNow\Utils\Config::getMessage((3268)));
return false;
}
if(is_object($this->data['value']) && !\RightNow\Utils\Connect::isArray($this->data['value'])) {
if(!$this->data['value']->ID || (!$chain = $this->CI->model('Prodcat')->getFormattedChain($type, $this->data['value']->ID)->result)) return false;
$depth = 0;
$this->data['value'] = array();
foreach($chain as $item) {
$this->data['value'][] = $this->createResultItem($item['id'], $item['label'], $depth++);
}
}
else {
if(count($this->data['value']) === 0 || !$result = $this->generateTree($type)) return false;
$this->data['value'] = $result;
}
if($this->data['attrs']['report_page_url'] !== '') {
$this->data['filterKey'] = ($type === 'product') ? 'p' : 'c';
$this->data['attrs']['url'] = rtrim($this->data['attrs']['url'], '/');
$this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']) . \RightNow\Utils\Url::sessionParameter();
}
$this->data['wrapClass'] = ($this->data['attrs']['left_justify']) ? ' rn_LeftJustify' : '';
}
protected function generateTree($type) {
$dataTree = array();
$prodcat = $this->CI->model('Prodcat');
foreach($this->data['value'] as $leaf) {
if(!$chain = $prodcat->getFormattedChain($type, $leaf->ID)->result) {
continue;
}
$depth = 0;
foreach($chain as $item) {
$parentID = (!$depth) ? 0 : $chain[$depth - 1]['id'];
$dataTree[$parentID][$prodcat->get($item['id'])->result->DisplayOrder] = $this->createResultItem($item['id'], $item['label'], $depth++);
}
}
foreach($dataTree as &$nodeList) {
ksort($nodeList);
$nodeList = array_values($nodeList);
}
$iter = 0;
$listCounts = $iterStacks = $resultList = array();
while(true) {
if($iter === null) break;
if(!isset($listCounts[$iter])) $listCounts[$iter] = 0;
if($listCounts[$iter] === count($dataTree[$iter])) {
$iter = array_pop($iterStacks);
continue;
}
$item = $dataTree[$iter][$listCounts[$iter]];
array_push($resultList, $item);
$listCounts[$iter]++;
if(isset($dataTree[$item['ID']])) {
array_push($iterStacks, $iter);
$iter = $item['ID'];
}
}
return $resultList;
}
protected function createResultItem($id, $label, $depth) {
return array('ID' => $id, 'Name' => $label, 'Depth' => $depth);
}
}
function _standard_output_ProductCategoryDisplay_header() {
$result = array( 'js_name' => '', 'library_name' => 'ProductCategoryDisplay', 'view_func_name' => '_standard_output_ProductCategoryDisplay_view', 'meta' => array ( 'controller_path' => 'standard/output/ProductCategoryDisplay', 'view_path' => 'standard/output/ProductCategoryDisplay', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/ProductCategoryDisplay.css', 1 => 'assets/themes/mobile/widgetCss/ProductCategoryDisplay.css', 2 => 'assets/themes/standard/widgetCss/ProductCategoryDisplay.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(41982)', 'urlParameters' => array ( 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(993)', 'example' => 'a_id/3', ), 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), ), ), 'relativePath' => 'standard/output/ProductCategoryDisplay', 'widget_name' => 'ProductCategoryDisplay', ), );
$result['meta']['attributes'] = array( 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'STRING', 'default' => '{default_label}', 'inherited' => false, )), 'left_justify' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'kw', 'type' => 'string', 'default' => 'kw', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class IncidentThreadDisplay extends \RightNow\Libraries\Widget\Output {
function _standard_output_IncidentThreadDisplay_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
<? if ($this->data['attrs']['label']): ?>
    <span class="rn_DataLabel"><?=$this->data['attrs']['label'];?> </span>
<?
endif;
?>
<? if($this->data['value']): ?>
<? foreach($this->data['value'] as $thread): ?>
    <? if ($this->threadIsPrivate($thread)) continue;
$threadMetadata = $thread::getMetadata();
$subclass = $this->threadIsCustomerEntry($thread) ? 'rn_Customer' : '';
?>
    <div class="rn_ThreadHeader <?=$subclass?>">
        <span class="rn_ThreadAuthor">
            <?=$thread->EntryType->LookupName;?>
            <?=
$this->getAuthorName($thread) ?>
            <? if($thread->Channel) printf(\RightNow\Utils\Config::getMessage((4139)), $thread->Channel->LookupName);
?>
        </span>
        <span class="rn_ThreadTime">
            <?=\RightNow\Libraries\Formatter::formatField($thread->CreatedTime, $threadMetadata->CreatedTime, $this->data['attrs']['highlight']);?>
        </span>
    </div>
    <div class="rn_ThreadContent">
        <?=\RightNow\Libraries\Formatter::formatThreadEntry($thread,
$this->data['attrs']['highlight']);?>
    </div>
<?
endforeach;
?>
<? endif;
?>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(parent::getData() === false) return false;
if (!\RightNow\Utils\Connect::isIncidentThreadType($this->data['value'])) {
echo $this->reportError(\RightNow\Utils\Config::getMessage((2173)));
return false;
}
$this->data['value'] = (array)$this->data['value'];
usort($this->data['value'], function($a, $b){
if($a->CreatedTime === $b->CreatedTime){
if($a->DisplayOrder === $b->DisplayOrder){
return 0;
}
return ($a->DisplayOrder > $b->DisplayOrder) ? -1 : 1;
}
return ($a->CreatedTime > $b->CreatedTime) ? -1 : 1;
});
if($this->data['value'] && $this->data['attrs']['thread_order'] === 'ascending') {
$this->data['value'] = array_reverse($this->data['value']);
}
}
function getAuthorName($thread) {
switch ($thread->EntryType->ID) {
case (3): $name = $thread->Contact->LookupName;
$suffix = \RightNow\Utils\Config::getMessage((7023));
$name .= ($suffix) ? " $suffix" : '';
break;
case (6): $name = '';
break;
default: $name = $thread->Account->DisplayName;
break;
}
return $name;
}
function threadIsPrivate($thread) {
return !in_array($thread->EntryType->ID, array( (2), (3), (4), (5), (6), ), true);
}
function threadIsCustomerEntry($thread) {
return $thread->EntryType->ID === (3) || $thread->EntryType->ID === (4);
}
}
function _standard_output_IncidentThreadDisplay_header() {
$result = array( 'js_name' => '', 'library_name' => 'IncidentThreadDisplay', 'view_func_name' => '_standard_output_IncidentThreadDisplay_view', 'meta' => array ( 'controller_path' => 'standard/output/IncidentThreadDisplay', 'view_path' => 'standard/output/IncidentThreadDisplay', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/IncidentThreadDisplay.css', 1 => 'assets/themes/mobile/widgetCss/IncidentThreadDisplay.css', 2 => 'assets/themes/standard/widgetCss/IncidentThreadDisplay.css', ), 'base_css' => array ( 0 => 'standard/output/IncidentThreadDisplay/base.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(1693)', 'urlParameters' => array ( 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), ), ), 'relativePath' => 'standard/output/IncidentThreadDisplay', 'widget_name' => 'IncidentThreadDisplay', ), );
$result['meta']['attributes'] = array( 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'required' => true, 'inherited' => false, )), 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'STRING', 'default' => '{default_label}', 'inherited' => false, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'thread_order' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'descending', 'type' => 'option', 'default' => 'descending', 'options' => array(0 => 'ascending', 1 => 'descending', ), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Connect, RightNow\Libraries\Formatter;
class FieldDisplay extends \RightNow\Libraries\Widget\Output {
function _standard_output_FieldDisplay_view ($data) {
extract($data);
?><div  id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <? if ($this->data['attrs']['label']): ?>
        <span class="rn_DataLabel"><?=$this->data['attrs']['label'];?> </span>
    <?
endif;
?>
    <div class="rn_DataValue<?=$this->data['wrapClass']?>">
        <?=$this->data['value']?>
    </div>
</div>
<? }
protected $validObjectTypes = array('Menu', 'Country', 'NamedID', 'SlaInstance', 'Asset');
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(parent::getData() === false) {
return false;
}
$value = $this->data['value'];
$valueType = $this->getValueType($value, $this->fieldMetaData);
if (!$this->fieldShouldBeDisplayed($value, $valueType)) {
return false;
}
if (!$this->fieldIsValid($value, $valueType)) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((42158)), $this->data['attrs']['name']));
return false;
}
$this->data['value'] = Formatter::formatField($value, $this->fieldMetaData, $this->data['attrs']['highlight']);
if ($this->data['mask']) {
$this->data['value'] = Formatter::applyMask($this->data['value'], $this->data['mask']);
}
$this->data['wrapClass'] = ($this->data['attrs']['left_justify']) ? ' rn_LeftJustify' : '';
}
function getValueType($value, $fieldMetaData) {
if ($fieldMetaData->is_menu) {
return 'Menu';
}
if (Connect::isCountryType($value) && !Connect::isCustomAttribute($fieldMetaData) ) {
return 'Country';
}
if (Connect::isNamedIDType($value)) {
return 'NamedID';
}
if (Connect::isSlaInstanceType($value)) {
return 'SlaInstance';
}
if (Connect::isAssetType($value)) {
return 'Asset';
}
return $fieldMetaData->COM_type;
}
function fieldShouldBeDisplayed($value, $valueType) {
return (!is_null($value) && $value !== '' && !(!$value->ID && in_array($valueType, $this->validObjectTypes)));
}
function fieldIsValid($value, $valueType) {
if (is_object($value) && !in_array($valueType, $this->validObjectTypes)) {
return false;
}
return true;
}
}
function _standard_output_FieldDisplay_header() {
$result = array( 'js_name' => '', 'library_name' => 'FieldDisplay', 'view_func_name' => '_standard_output_FieldDisplay_view', 'meta' => array ( 'controller_path' => 'standard/output/FieldDisplay', 'view_path' => 'standard/output/FieldDisplay', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/FieldDisplay.css', 1 => 'assets/themes/mobile/widgetCss/FieldDisplay.css', 2 => 'assets/themes/standard/widgetCss/FieldDisplay.css', ), 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(41983)', 'urlParameters' => array ( 'kw' => array ( 'name' => 'rn:msg:(13864)', 'description' => 'rn:msg:(3918)', 'example' => 'kw/search', ), 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(993)', 'example' => 'a_id/3', ), 'i_id' => array ( 'name' => 'rn:msg:(10071)', 'description' => 'rn:msg:(2166)', 'example' => 'i_id/7', ), ), ), 'relativePath' => 'standard/output/FieldDisplay', 'widget_name' => 'FieldDisplay', ), );
$result['meta']['attributes'] = array( 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '{default_label}', 'type' => 'STRING', 'default' => '{default_label}', 'inherited' => false, )), 'name' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'required' => true, 'inherited' => false, )), 'highlight' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'left_justify' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), );
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
-->
</style>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>pages/answers/detail.themes.standard.css' rel='stylesheet' type='text/css' media='all'/>
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
<div id="rn_PageTitle" class="rn_AnswerDetail">
   <?if(
(true) ):?>
        <div id="rn_SearchControls" class="rn_AnswerSearchControls">
            <h1 class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::msgGetFrom((4693));?></h1>
            <form method="post" action="" onsubmit="return false" >
                <div class="rn_SearchInput">
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/AdvancedSearchDialog',
array('report_page_url' => '/app/answers/list','report_id' => '176',));
?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/KeywordText', array('label_text' => '' . \RightNow\Utils\Config::msgGetFrom((1962)) . '','initial_focus' => 'true','report_id' => '176',));
?>
                </div>
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/SearchButton', array('report_page_url' => '/app/answers/list','report_id' => '176',));
?>
            </form>
        </div>
    <?endif;?>
    <h1 id="rn_Summary"><?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'Summary', ), true);?></h1>
    <div id="rn_AnswerInfo">
        <?=\RightNow\Utils\Config::msgGetFrom((5642));?> <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'CreatedTime', ), false);?>
        &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <?=\RightNow\Utils\Config::msgGetFrom((6861));?> <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'UpdatedTime', ), false);?>
    </div>
    <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'Question', ), true);?>
</div>
<div id="rn_PageContent" class="rn_AnswerDetail">
    <div id="rn_AnswerText">
        <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'Solution', ), true);?>
    </div>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/knowledgebase/GuidedAssistant',
array('label_text_result' => '',));
?>
    <div id="rn_FileAttach">
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/DataDisplay', array('name' => 'answers.fattach',));
?>
    </div>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/feedback/AnswerFeedback', array('dialog_threshold' => '2','options_descending' => 'true','options_count' => '4','use_rank_labels' => 'true','label_dialog_title' => 'Rating Submitted','label_dialog_description' => 'Please tell us how we can make this answer more useful. ',));
?>
    <br/>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/knowledgebase/RelatedAnswers', array());
?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/knowledgebase/PreviousAnswers', array());
?>
    <?if( (true) ):?>
        <div id="rn_DetailTools">
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/SocialBookmarkLink', array());
?>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/PrintPageLink', array());
?>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/EmailAnswerLink', array());
?>
        </div>
    <?endif;?>
</div>
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
( 0 => 'standard/login/LogoutLink', 1 => 'standard/login/LoginDialog', ), '/standard.js', '1436303720');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/EventProvider.js', 1 => '/euf/core/3.2.4/js/4.171/min/widgetHelpers/SearchFilter.js', 2 => 'standard/search/AdvancedSearchDialog', 3 => 'standard/search/KeywordText', 4 => 'standard/search/SearchButton', 5 => 'standard/knowledgebase/GuidedAssistant', 6 => 'standard/feedback/AnswerFeedback', 7 => 'standard/utils/SocialBookmarkLink', 8 => 'standard/utils/EmailAnswerLink', 9 => 'standard/search/SearchTypeList', 10 => 'standard/search/WebSearchSort', 11 => 'standard/search/WebSearchType', 12 => 'standard/search/ProductCategorySearchFilter', 13 => 'standard/search/FilterDropdown', 14 => 'standard/search/SortList', ), '/answers/detail.js', '1436303720');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'RESPONSE_PLACEHOLDER_LBL' => array ( 'value' => 3419, ), 'NO_ANSWERS_FOUND_MSG' => array ( 'value' => 34166, ), 'AGT_TEXT_LBL' => array ( 'value' => 948, ), 'FIELD_REQUIRED_MARK_LBL' => array ( 'value' => 1908, ), 'REQUIRED_LBL' => array ( 'value' => 7015, ), 'ADD_TO_CHAT_CMD' => array ( 'value' => 928, ), 'NEW_CONTENT_ADDED_BELOW_MSG' => array ( 'value' => 2802, ), 'TOP_CONTENT_CONTENT_ADDED_MSG' => array ( 'value' => 3960, ), 'ANSWERFEEDBACK_DIALOG_MISSING_REQD_MSG' => array ( 'value' => 40280, ), 'PCT_S_IS_REQUIRED_MSG' => array ( 'value' => 3033, ), 'FIELD_IS_NOT_A_VALID_EMAIL_ADDRESS_MSG' => array ( 'value' => 1899, ), 'PCT_S_CONTAIN_THAN_MSG' => array ( 'value' => 3006, ), 'PCT_S_MUST_NOT_CONTAIN_QUOTES_MSG' => array ( 'value' => 3041, ), 'PCT_S_MUST_NOT_CONTAIN_MSG' => array ( 'value' => 3040, ), 'PLEASE_ENTER_SINGLE_EMAIL_ADDRESS_MSG' => array ( 'value' => 3147, ), 'PCT_S_IS_INVALID_MSG' => array ( 'value' => 3030, ), 'PCT_S_IS_TOO_LONG_MSG' => array ( 'value' => 3034, ), 'CANCEL_CMD' => array ( 'value' => 849, ), 'SELECTION_PCT_S_ACTIVATE_LINK_JUMP_MSG' => array ( 'value' => 3544, ), 'PCT_S_LNKS_DEPTH_ANNOUNCED_MSG' => array ( 'value' => 3036, ), 'PCT_S_MUST_NOT_CONTAIN_SPACES_MSG' => array ( 'value' => 3042, ), 'USERNAME_LBL' => array ( 'value' => 4846, ), 'PCT_S_CONTAIN_DOUBLE_QUOTES_MSG' => array ( 'value' => 3005, ), 'PCT_S_CNT_THAN_MSG' => array ( 'value' => 3002, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
