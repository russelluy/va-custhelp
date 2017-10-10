<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/mobile', 1 => '/euf/assets/themes/mobile', 2 => array ( '/euf/assets/themes/mobile' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile', ), ));
get_instance()->_checkMeta(array('javascript_module'=>'mobile_may_10', 'title'=>'' . \RightNow\Utils\Config::msgGetFrom((2048)) . '', 'template'=>'mobile.php'));
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
.rn_GuidedAssistant .rn_Node{position:relative;word-wrap:break-word;}
.rn_GuidedAssistant .rn_QuestionText, .rn_GuidedAssistant .rn_ResultHeading{clear:both;overflow:hidden;}
.rn_GuidedAssistant .rn_ChatLink{display:block;margin:2px 20px 0 80%;}
.rn_GuidedAssistant .rn_AgentText{background-color:#F4F4F4;border:1px solid #DDD;font-family:sans-serif;margin-top:10px;padding:4px 6px;}
.rn_GuidedAssistant .rn_AgentText em{font-style:normal;font-weight:bold;display:block;}
.rn_GuidedAssistant .rn_LinkQuestion label{cursor:pointer;}
.rn_GuidedAssistant .rn_TransparentScreenReaderOnly{opacity:0;position:absolute;left:0;}
.rn_GuidedAssistant .rn_ImageQuestion img{overflow:hidden;}
.rn_GuidedAssistant .rn_ImageQuestion div{display:inline-block;*display:inline;margin-bottom:16px;}
.rn_GuidedAssistant .rn_ImageQuestion label{cursor:pointer;display:inline-block;position:relative;zoom:1;}
.rn_GuidedAssistant .rn_ImageQuestion .rn_ImageCaption{bottom:0;font-weight:bold;left:10px;position:absolute;top:10px;text-shadow:0 1px 1px #FFF;width:100%;background: url(adff);}
.rn_GuidedAssistant .rn_ButtonQuestion button{margin: 0 6px 6px 0;padding: 2px 4px;}
@media print{.rn_GuidedAssistant .rn_Question{display:block;}
}
.rn_GuidedAssistant{position:relative;}
.rn_GuidedAssistant img{display:inline-block;max-width:500px;max-height:500px;padding:6px;}
.rn_GuidedAssistant .rn_PopupLaunchButton, .rn_GuidedAssistant .rn_LinkQuestion, .rn_GuidedAssistant .rn_Node, .rn_GuidedAssistant .rn_Result.rn_Text, .rn_GuidedAssistant .rn_Result.rn_Answers{margin:auto;width:90%;}
.rn_GuidedAssistant .rn_QuestionText, .rn_GuidedAssistant .rn_Result:first-child{margin:20px 0;}
.rn_GuidedAssistant .rn_ResultLink a{display:block;margin:10px 0;}
.rn_GuidedAssistant .rn_Guide{border-radius:16px;-moz-border-radius:16px;-webkit-border-radius:16px;background:#FFF;border:1px solid #AAA;margin:20px auto 0;min-height:100px;padding:26px 0;width:90%;}
.rn_GuidedAssistant .rn_BackButton, .rn_GuidedAssistant .rn_RestartButton{margin:8px auto;overflow:hidden;text-overflow:ellipsis;font-weight:normal;white-space:nowrap;background:none;border-width:0 4px 0 12px;width:90%;-moz-border-image:url("<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile/images/BreadCrumbSprite.png") 0 4 75% 60% stretch stretch;-webkit-border-image:url("<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile/images/BreadCrumbSprite.png") 0 4 75% 60% stretch stretch;-moz-box-shadow:none;-webkit-box-shadow:none;}
.rn_GuidedAssistant button:focus, .rn_GuidedAssistant button:hover{-webkit-animation:none;}
.rn_GuidedAssistant .rn_RestartButton{-moz-border-image:url(<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile/images/BreadCrumbSprite.png) 50% 4 25% 60% stretch stretch;-webkit-border-image:url(<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile/images/BreadCrumbSprite.png) 50% 4 25% 60% stretch stretch;}
.rn_GuidedAssistant .rn_ButtonQuestion .rn_HighlightResponse.rn_SelectedButton{background:#555A67;background:-moz-linear-gradient(center top , rgba(172, 177, 190, 0.8), rgba(40, 52, 82, 0.8), rgba(6, 11, 26, 0.8));background:-webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(0, rgba(172, 177, 190, 0.8)), color-stop(.5, rgba(40, 52, 82, 0.8)), color-stop(1, rgba(6, 11, 26, 0.8)));}
.rn_GuidedAssistant .rn_RadioQuestion div{margin:auto;width:90%;}
.rn_GuidedAssistant input[type="radio"], .rn_GuidedAssistant .rn_RadioQuestion label{display:inline;height:auto;margin:10px 0;width:auto;}
.rn_GuidedAssistant .rn_ImageQuestion input{margin:0;}
.rn_GuidedAssistant .rn_RadioQuestion label{padding-left:10px;}
.rn_GuidedAssistant .rn_LinkQuestion label{display:inline;padding:2px;text-decoration:underline;}
.rn_GuidedAssistant .rn_LinkQuestion label.rn_HighlightResponse{color:#FFF;background-color:#0E53A7;text-decoration:none;}
.rn_GuidedAssistant .rn_LinkQuestion div{margin:8px 0;}
.rn_GuidedAssistant .rn_TextQuestion input{margin-bottom:14px;width:96%;}
.rn_GuidedAssistant .rn_Guide.rn_Result{border:none;margin-top:0;padding:0;width:100%;}
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
<section id="rn_PageContent" class="rn_StandAloneGuide">
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/knowledgebase/GuidedAssistant',
array('single_question_display' => 'true','label_question_back' => '' . \RightNow\Utils\Config::msgGetFrom((2039)) . '','label_text_result' => '',));
?>
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
( 0 => 'standard/knowledgebase/GuidedAssistant', ), '/mobile/utils/guided_assistant.js', '1436303720');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'RESPONSE_PLACEHOLDER_LBL' => array ( 'value' => 3419, ), 'NO_ANSWERS_FOUND_MSG' => array ( 'value' => 34166, ), 'AGT_TEXT_LBL' => array ( 'value' => 948, ), 'FIELD_REQUIRED_MARK_LBL' => array ( 'value' => 1908, ), 'REQUIRED_LBL' => array ( 'value' => 7015, ), 'ADD_TO_CHAT_CMD' => array ( 'value' => 928, ), 'NEW_CONTENT_ADDED_BELOW_MSG' => array ( 'value' => 2802, ), 'TOP_CONTENT_CONTENT_ADDED_MSG' => array ( 'value' => 3960, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
