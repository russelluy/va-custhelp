<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '', 1 => '/euf/assets/themes/standard', 2 => array ( ), ));
get_instance()->_checkMeta(array('title'=>'' . \RightNow\Utils\Config::msgGetFrom((2047)) . '', 'template'=>'agent.php', 'account_session_required'=>'true'));
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
namespace{
use \RightNow\Utils\FileSystem;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="Pragma" content="no-cache"/>
    <title><?=\RightNow\Utils\Tags::getPageTitleAtRuntime();?></title>
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
<base href='<?=\RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest', \RightNow\Utils\FileSystem::getOptimizedAssetsDir() . 'themes/standard/');?>'></base>
<style type="text/css">
<!--
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
.rn_GuidedAssistant img{display:inline-block;max-width:500px;max-height:500px;padding:6px;}
.rn_GuidedAssistant .rn_Node{border-bottom:1px solid #DDD;margin-bottom:26px;padding-bottom:14px;}
.rn_GuidedAssistant .rn_QuestionText{margin:24px 0 10px;}
.rn_GuidedAssistant .rn_Result{margin:6px 0 10px;}
.rn_GuidedAssistant .rn_ResultHeading{line-height:1.6em;margin-bottom:10px;}
.rn_GuidedAssistant .rn_RadioQuestion div{margin-top:6px;}
.rn_GuidedAssistant .rn_RadioQuestion label{margin-left:6px;}
.rn_GuidedAssistant .rn_ImageQuestion input, .rn_GuidedAssistant .rn_RadioQuestion input{border:none;}
.rn_GuidedAssistant .rn_LinkQuestion div{margin-bottom:8px;}
.rn_GuidedAssistant .rn_LinkQuestion label{color:#0000CC;margin:4px 0;text-decoration:underline;}
.rn_GuidedAssistant .rn_LinkQuestion label.rn_HighlightResponse{color:#FFF;background-color:#0E53A7;}
.rn_GuidedAssistant .rn_ButtonQuestion .rn_HighlightResponse{font-weight:bold;}
.rn_GuidedAssistant .rn_ButtonQuestion .rn_HighlightResponse.rn_SelectedButton{background-position: 0px -40px;border:1px solid #333;color:#FCFCFC;}
.rn_GuidedAssistant .rn_TextQuestion .rn_Label, .rn_GuidedAssistant .rn_TextQuestion button{display:block;margin-top:6px;}
.rn_GuidedAssistant .rn_TextQuestion input{width:200px;}
.rn_GuidedAssistant .rn_ResultLink a{display:block;}
-->
</style>
9c1379bc-cca6-4750-aee7-188f8348a6c3
</head>
<body class="yui-skin-sam">
    <noscript><h1><?=\RightNow\Utils\Config::msgGetFrom((4861));?></h1></noscript>
<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/knowledgebase/GuidedAssistant',
array('label_text_result' => '',));
?>
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=\RightNow\Utils\Url::getCoreAssetPath('js/5.171/min/RightNow.js');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/knowledgebase/GuidedAssistant', ), '/agent/guided_assistant.js', '1441160703');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'RESPONSE_PLACEHOLDER_LBL' => array ( 'value' => 3419, ), 'NO_ANSWERS_FOUND_MSG' => array ( 'value' => 34166, ), 'AGT_TEXT_LBL' => array ( 'value' => 948, ), 'FIELD_REQUIRED_MARK_LBL' => array ( 'value' => 1908, ), 'REQUIRED_LBL' => array ( 'value' => 7015, ), 'ADD_TO_CHAT_CMD' => array ( 'value' => 928, ), 'NEW_CONTENT_ADDED_BELOW_MSG' => array ( 'value' => 2802, ), 'TOP_CONTENT_CONTENT_ADDED_MSG' => array ( 'value' => 3960, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
