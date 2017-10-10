<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/mobile', 1 => '/euf/assets/themes/mobile', 2 => array ( '/euf/assets/themes/mobile' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile', ), ));
get_instance()->_checkMeta(array('javascript_module'=>'mobile_may_10', 'title'=>'' . SEO::getDynamicTitle('answer', getUrlParm('a_id')) . '', 'template'=>'mobile.php', 'answer_details'=>'true', 'clickstream'=>'answer_view'));
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
class MobileAnswerFeedback extends \RightNow\Libraries\Widget\Base {
function _standard_feedback_MobileAnswerFeedback_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID?>" class="<?= $this->classList ?>">
<? if ($this->data['attrs']['label_title']): ?>
    <div class="rn_Title"><?=$this->data['attrs']['label_title']?></div>
<? endif;?>
    <div id="rn_<?=$this->instanceID?>_MobileAnswerFeedbackControl" class="rn_MobileAnswerFeedbackControl">
        <div id="rn_<?=$this->instanceID?>_RatingButtons">
            <button id="rn_<?=$this->instanceID?>_RatingYesButton"><?=$this->data['attrs']['label_yes_button']?></button>
            <button id="rn_<?=$this->instanceID?>_RatingNoButton"><?=$this->data['attrs']['label_no_button']?></button>
        </div>
        <span id="rn_<?=$this->instanceID?>_ThanksLabel" class="rn_ThanksLabel rn_Hidden">&nbsp;</span>
    </div>
    <form id="rn_<?=$this->instanceID?>_Form" class="rn_MobileAnswerFeedbackForm rn_Hidden" onsubmit="return false;">
        <div class="rn_DialogPrompt"><?=$this->data['attrs']['label_dialog_prompt'];?></div>
        <div id="rn_<?=$this->instanceID;?>_ErrorMessage"></div>
        <?
if (!$this->data['js']['profile']): ?>
            <label for="rn_<?=$this->instanceID?>_Email"><?=$this->data['attrs']['label_email_address'];?><span class="rn_Required"> <?=\RightNow\Utils\Config::getMessage((1908));?></span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage((7015))?></span></label>
            <input id="rn_<?=$this->instanceID?>_Email" class="rn_EmailField" type="email" value="<?=$this->data['js']['email']
?>"/>
        <? endif;?>
        <label for="rn_<?=$this->instanceID?>_FeedbackText"><?=$this->data['attrs']['label_comment_box'];?><span class="rn_Required"> <?=\RightNow\Utils\Config::getMessage((1908));?></span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage((7015))?></span></label>
        <textarea id="rn_<?=$this->instanceID?>_FeedbackText" rows="4" cols="60"></textarea>
    </form>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$answerID = \RightNow\Utils\Url::getParameter('a_id');
if($answerID) {
$answerData = $this->CI->model('Answer')->get($answerID);
if($answerData->error){
return false;
}
$this->data['js'] = array( 'summary' => $answerData->result->Summary, 'answerID' => $answerID );
}
else {
$this->data['js'] = array( 'summary' => \RightNow\Utils\Config::getMessage((4727)), 'answerID' => null );
}
if($emailAddress = $this->CI->session->getProfileData('email')) {
$this->data['js']['email'] = $emailAddress;
$this->data['profile'] = true;
}
else if($sessionEmail = $this->CI->session->getSessionData('previouslySeenEmail')) {
$this->data['js']['email'] = $sessionEmail;
}
$this->data['js']['f_tok'] = \RightNow\Utils\Framework::createTokenWithExpiration(0);
}
}
function _standard_feedback_MobileAnswerFeedback_header() {
$result = array( 'js_name' => 'RightNow.Widgets.MobileAnswerFeedback', 'library_name' => 'MobileAnswerFeedback', 'view_func_name' => '_standard_feedback_MobileAnswerFeedback_view', 'meta' => array ( 'controller_path' => 'standard/feedback/MobileAnswerFeedback', 'view_path' => 'standard/feedback/MobileAnswerFeedback', 'js_path' => 'standard/feedback/MobileAnswerFeedback', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/MobileAnswerFeedback.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4244)', 'urlParameters' => array ( 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(998)', 'example' => 'a_id/3', ), ), ), 'relativePath' => 'standard/feedback/MobileAnswerFeedback', 'widget_name' => 'MobileAnswerFeedback', ), );
$result['meta']['attributes'] = array( 'submit_rating_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/submitAnswerRating', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/submitAnswerRating', 'inherited' => false, )), 'submit_feedback_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/submitAnswerFeedback', 'type' => 'ajax', 'default' => '/ci/ajaxRequest/submitAnswerFeedback', 'inherited' => false, )), 'label_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4177), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4177), 'inherited' => false, )), 'label_yes_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(869), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(869), 'inherited' => false, )), 'label_no_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(863), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(863), 'inherited' => false, )), 'label_dissatisfied' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4214), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4214), 'inherited' => false, )), 'label_satisfied' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3911), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3911), 'inherited' => false, )), 'label_provide_feedback' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3294), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3294), 'inherited' => false, )), 'label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3329), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3329), 'inherited' => false, )), 'label_dialog_prompt' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3159), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3159), 'inherited' => false, )), 'label_feedback_submit_success' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3911), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3911), 'inherited' => false, )), 'label_email_address' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(8256), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(8256), 'inherited' => false, )), 'label_comment_box' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4546), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4546), 'inherited' => false, )), 'label_send_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4550), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4550), 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9555), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9555), 'inherited' => false, )), );
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
<link href='<?=FileSystem::getOptimizedAssetsDir();?>pages/mobile/answers/detail.themes.mobile.css' rel='stylesheet' type='text/css' media='all'/>
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
<section id="rn_PageTitle" class="rn_AnswerDetail">
    <h1 id="rn_Summary"><?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'Summary', ), true);?></h1>
    <div id="rn_AnswerInfo">
        <?=\RightNow\Utils\Config::msgGetFrom((5642));?> <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'CreatedTime', ), false);?>
        <br/>
        <?=\RightNow\Utils\Config::msgGetFrom((6861));?> <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'UpdatedTime', ), false);?>
    </div>
    <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'Question', ), true);?>
</section>
<section id="rn_PageContent" class="rn_AnswerDetail">
    <div id="rn_AnswerText">
        <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'Solution', ), true);?>
    </div>
    <div id="rn_FileAttach">
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/DataDisplay',
array('name' => 'answers.fattach',));
?>
    </div>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/knowledgebase/GuidedAssistant', array('popup_window_url' => '/app/utils/guided_assistant',));
?>
    <br/>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/feedback/MobileAnswerFeedback', array());
?>
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/knowledgebase/RelatedAnswers', array());
?>
    <!-- rn:widget path="utils/MobileEmailAnswerLink" label_link="<?=\RightNow\Utils\Config::msgGetFrom((1747));?>"/ -->
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
( 0 => 'standard/navigation/MobileNavigationMenu', 1 => 'standard/search/MobileSimpleSearch', 2 => 'standard/login/LogoutLink', ), '/mobile.js', '1441160703');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/knowledgebase/GuidedAssistant', 1 => 'standard/feedback/MobileAnswerFeedback', ), '/mobile/answers/detail.js', '1441160703');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'RESPONSE_PLACEHOLDER_LBL' => array ( 'value' => 3419, ), 'NO_ANSWERS_FOUND_MSG' => array ( 'value' => 34166, ), 'AGT_TEXT_LBL' => array ( 'value' => 948, ), 'FIELD_REQUIRED_MARK_LBL' => array ( 'value' => 1908, ), 'REQUIRED_LBL' => array ( 'value' => 7015, ), 'ADD_TO_CHAT_CMD' => array ( 'value' => 928, ), 'NEW_CONTENT_ADDED_BELOW_MSG' => array ( 'value' => 2802, ), 'TOP_CONTENT_CONTENT_ADDED_MSG' => array ( 'value' => 3960, ), 'PCT_S_IS_REQUIRED_MSG' => array ( 'value' => 3033, ), 'FIELD_IS_NOT_A_VALID_EMAIL_ADDRESS_MSG' => array ( 'value' => 1899, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
