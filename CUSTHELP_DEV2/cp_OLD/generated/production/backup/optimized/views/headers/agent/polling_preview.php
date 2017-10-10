<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '', 1 => '/euf/assets/themes/standard', 2 => array ( ), ));
get_instance()->_checkMeta(array());
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
class Polling extends \RightNow\Libraries\Widget\Base {
function _standard_surveys_Polling_view ($data) {
extract($data);
?><?$this->addJavaScriptInclude($this->data['ma_js_location']);?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <?if (!$this->data['attrs']['modal']):?>
    <div id="rn_<?=$this->instanceID;?>_PollTitle" class="rn_PollTitle">
        <h2 id="rn_<?=$this->instanceID;?>_PollTitleHeading">
            <?=$this->data['title'];?>
        </h2>
    </div>
    <?endif;?>
    <form id="rn_<?=$this->instanceID;?>_QuestionForm" name="rn_<?=$this->instanceID;?>_QuestionForm">
        <fieldset class="rn_PollFieldset">
            <?
if ($this->data['js']['element_type'] === "list" || $this->data['js']['element_type'] === "menu"): ?>
            <label id="rn_<?=$this->instanceID;?>_PollQuestion" for="q_<?=$this->data['js']['question_id'];?>">
                <span class="rn_ScreenReaderOnly"><?=$this->data['js']['dialog_description'];?></span>
                <?=$this->data['question']?>
            </label>
            <?
else: ?>
            <legend id="rn_<?=$this->instanceID;?>_PollQuestion" class="rn_PollQuestion">
                <span class="rn_ScreenReaderOnly"><?=$this->data['js']['dialog_description'];?></span>
                <?=$this->data['question']?>
            </legend>
            <?
endif;
?>
        <div id="rn_<?=$this->instanceID;?>_FlipArea" class="rn_FlipArea" >
            <div id="rn_<?=$this->instanceID;?>_ErrorMessage"></div>
            <div id="rn_<?=$this->instanceID;?>_PollAnswerArea" class="rn_PollAnswerArea">
                <?=$this->data['answer_area']?>
            </div>
            <?if
($this->data['show_results_link'] && $this->data['js']['question_type'] === "choice" && $this->data['js']['show_chart']):?>
            <div id="rn_<?=$this->instanceID;?>_ViewResults" class="rn_ViewResults rn_Hidden">
                <a href="javascript:void();" class="rn_ViewResultsLink" id="rn_<?=$this->instanceID;?>_ViewResultsLink" onclick="return false"><?=$this->data['view_results_label']?></a>
            </div>
            <?endif;?>
            <?if
(!$this->data['attrs']['modal']):?>
            <div id="rn_<?=$this->instanceID;?>_PollSubmit" class="rn_PollSubmit">
                <input id="rn_<?=$this->instanceID;?>_Submit" type="submit" disabled="disabled" onclick="return false" value="<?=$this->data['submit_button_label']?>"/>
            </div>
            <?endif;?>
        </div>
        </fieldset>
    </form>
    <div id="rn_<?=$this->instanceID;?>_TotalVotes" class="rn_TotalVotes rn_Hidden">
        <p id="rn_<?=$this->instanceID;?>_TotalVotesParagraph">
            <?=$this->data['total_votes_label'];?>
        </p>
    </div>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
$this->setAjaxHandlers(array( 'submit_poll_ajax' => 'submitPoll', ));
}
function getData() {
$this->data['js']['cookied_questionID'] = intval($_COOKIE[$this->instanceID]);
if ($this->data['attrs']['modal'] === true && $this->data['js']['cookied_questionID'] > 0) {
return false;
}
else {
$this->data['ma_js_location'] = \RightNow\Utils\Url::getCoreAssetPath('js/' . MOD_BUILD_SP . '.' . MOD_BUILD_NUM . '/min/RightNow.MarketingFeedback.js');
if ($this->data['attrs']['admin_console']) return $this->getDataAdminPreview();
else if ($this->data['js']['cookied_questionID'] > 0) return $this->getDataPollResults($this->data['js']['cookied_questionID']);
else return $this->getDataServePoll();
}
}
protected function getDataAdminPreview() {
$questionID = $_REQUEST['question_id'];
$surveyID = $_REQUEST['survey_id'];
if ($questionID < 1 || $surveyID < 1) return false;
$surveyData = $this->CI->model('Polling')->getPollQuestion($surveyID, $questionID, false)->result;
$this->data['question'] = $surveyData['question'];
$this->data['answer_area'] = $surveyData['answer_area'];
$this->data['total_votes_label'] = $surveyData['total_votes_label'];
$this->data['view_results_label'] = $surveyData['view_results_label'];
$this->data['show_results_link'] = $surveyData['show_results_link'];
if ($_REQUEST['modal'] === "true") $this->data['attrs']['modal'] = true;
else $this->data['attrs']['modal'] = false;
$this->data['js']['flow_id'] = $surveyData['flow_id'];
$this->data['js']['doc_id'] = $surveyData['doc_id'];
$this->data['js']['show_chart'] = $surveyData['show_chart'];
$this->data['js']['question_type'] = $surveyData['question_type'];
$this->data['js']['question_id'] = $questionID;
if ($this->data['attrs']['modal']) {
$this->data['js']['title'] = $surveyData['title'];
$this->data['js']['submit_button_label'] = $surveyData['submit_button_label'];
}
else {
$this->data['title'] = $surveyData['title'];
$this->data['submit_button_label'] = $surveyData['submit_button_label'];
}
}
protected function getDataServePoll() {
$questionID = -1;
$surveyID = $this->data['attrs']['survey_id'];
if ($this->data['attrs']['test']) $data = $this->CI->model('Polling')->getPreviewQuestion($surveyID, $questionID, false)->result;
else $data = $this->CI->model('Polling')->getPollQuestion($surveyID, $questionID, false)->result;
if (!$data['flow_id']) {
if (!$this->data['attrs']['modal']) echo $this->reportError(\RightNow\Utils\Config::getMessage((1985)));
$this->data['js']['disabled_expired'] = true;
return false;
}
if ($data['survey_disabled'] === 1) {
if (!$this->data['attrs']['modal']) echo \RightNow\Utils\Config::getMessage((3185));
$this->data['js']['disabled_expired'] = true;
return false;
}
if ($data['max_responses_met'] || (intval($data['expiration_date']) > 0 && intval($data['expiration_date']) < time())) {
if (!$this->data['attrs']['modal']) {
if (strlen($data['expire_msg']) > 0) echo $data['expire_msg'];
else echo \RightNow\Utils\Config::getMessage((3186));
}
$this->data['js']['disabled_expired'] = true;
return false;
}
$this->data['question'] = $data['question'];
$this->data['answer_area'] = $data['answer_area'];
$this->data['total_votes_label'] = $data['total_votes_label'];
$this->data['view_results_label'] = $data['view_results_label'];
$this->data['show_results_link'] = $data['show_results_link'];
$this->data['js']['flow_id'] = $data['flow_id'];
$this->data['js']['doc_id'] = $data['doc_id'];
$this->data['js']['question_id'] = $data['question_id'];
$this->data['js']['validation_script'] = $data['validation_script'];
$this->data['js']['turn_text'] = $data['turn_text'];
$this->data['js']['show_total_votes'] = $data['show_total_votes'];
$this->data['js']['show_chart'] = $data['show_chart'];
$this->data['js']['question_type'] = $data['question_type'];
$this->data['js']['element_type'] = $data['element_type'];
$this->data['js']['dialog_description'] = $data['title'] . ' ' . \RightNow\Utils\Config::getMessage((1603));
if ($this->data['attrs']['modal'] === true) {
$this->data['js']['title'] = $data['title'];
$this->data['js']['submit_button_label'] = $data['submit_button_label'];
$this->data['js']['ok_button_label'] = $data['ok_button_label'];
}
else {
$this->data['title'] = $data['title'];
$this->data['submit_button_label'] = $data['submit_button_label'];
}
}
protected function getDataPollResults($questionID) {
$surveyID = $this->data['attrs']['survey_id'];
$data = $this->CI->model('Polling')->getPollQuestion($surveyID, $questionID, false)->result;
$this->data['question'] = $data['question'];
$this->data['total_votes_label'] = $data['total_votes_label'];
$this->data['title'] = $data['title'];
$this->data['js']['show_total_votes'] = $data['show_total_votes'];
$this->data['js']['question_type'] = $data['question_type'];
$this->data['js']['show_chart'] = $data['show_chart'];
$this->data['js']['turn_text'] = $data['turn_text'];
$resultsData = $this->CI->model('Polling')->getPollResults($data['flow_id'], $questionID, $this->data['attrs']['test'])->result;
$this->data['js']['total'] = $resultsData['total'];
$this->data['js']['question_results'] = $resultsData['question_results'];
}
function submitPoll($parameters) {
$flowID = $parameters['flow_id'];
$questionID = $parameters['question_id'];
$testMode = $parameters['test'] === true || $parameters['test'] === 'true';
if ($parameters['results_only']) {
echo json_encode($this->CI->model('Polling')->getPollResults($flowID, $questionID, $testMode)->result);
}
else {
\RightNow\Libraries\AbuseDetection::check();
$docID = $parameters['doc_id'];
$responses = $parameters['responses'];
$chartType = $parameters['chart_type'];
$includeResults = ($parameters['include_results'] === 'true');
$questionType = $parameters['question_type'];
if (!$testMode) $this->CI->model('Polling')->submitPoll($flowID, $docID, $questionID, $responses, $questionType, false);
if ($includeResults) echo json_encode($this->CI->model('Polling')->getPollResults($flowID, $questionID, $testMode)->result);
}
}
}
function _standard_surveys_Polling_header() {
$result = array( 'js_name' => 'RightNow.Widgets.Polling', 'library_name' => 'Polling', 'view_func_name' => '_standard_surveys_Polling_view', 'meta' => array ( 'controller_path' => 'standard/surveys/Polling', 'view_path' => 'standard/surveys/Polling', 'js_path' => 'standard/surveys/Polling', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/Polling.css', ), 'base_css' => array ( 0 => 'standard/surveys/Polling/base.css', ), 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), 'yui' => array ( 0 => 'charts', ), ), 'info' => array ( 'description' => 'rn:msg:(4312)', ), 'relativePath' => 'standard/surveys/Polling', 'widget_name' => 'Polling', ), );
$result['meta']['attributes'] = array( 'survey_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'min' => 1, 'required' => true, 'inherited' => false, )), 'modal' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'dialog_width' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 360, 'type' => 'INT', 'default' => 360, 'min' => 100, 'inherited' => false, )), 'seconds' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => false, )), 'frequency' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 100, 'type' => 'INT', 'default' => 100, 'min' => 1, 'max' => 100, 'inherited' => false, )), 'cookie_duration' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 10, 'type' => 'INT', 'default' => 10, 'inherited' => false, )), 'test' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'poll_logic' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'instance_id' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'chart_type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'horizontal_bar', 'type' => 'OPTION', 'default' => 'horizontal_bar', 'options' => array(0 => 'none', 1 => 'horizontal_bar', 2 => 'vertical_bar', 3 => 'pie', 4 => 'simple', ), 'inherited' => false, )), 'chart_tooltip_background_color' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '#000000', 'type' => 'STRING', 'default' => '#000000', 'inherited' => false, )), 'chart_tooltip_font_color' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '#FFFFFF', 'type' => 'STRING', 'default' => '#FFFFFF', 'inherited' => false, )), 'chart_bar_color' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '#0000FF', 'type' => 'STRING', 'default' => '#0000FF', 'inherited' => false, )), 'submit_poll_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajax/widget', 'type' => 'ajax', 'default' => '/ci/ajax/widget', 'inherited' => false, )), );
return $result;
}
}
namespace{
use \RightNow\Utils\FileSystem;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
<title><?=getMessage((33570));?></title>
<link rel="stylesheet" type="text/css" href="<?=getYUICodePath('container/assets/skins/sam/container.css')?>" />
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
.rn_Polling .rn_ChartArea{height:200px;width:200px;}
.rn_Polling .yui3-widget-content-expanded{height:100%;}
.rn_Polling{min-width:250px;max-width:900px;}
.rn_PollTitle{text-decoration:underline;}
.rn_ChartArea{width:inherit;height:200px;}
.rn_PollQuestion{margin: 0px;padding: 0px;visibility: inherit;font-size: 1em;display: inline;zoom:1;}
.rn_PollQuestion span{white-space:normal;display:block;zoom:1;}
.rn_PollFieldset{margin: 0px;padding: 0px;border: 0px;}
.rn_ViewResultsLink{margin: 0px 50px 0px 0px;float:left;}
.rn_PollSubmit{float:left;}
.rn_SimpleChartBar{background-color:#1B35E0;}
-->
</style>
9c1379bc-cca6-4750-aee7-188f8348a6c3
</head>
<body class="yui-skin-sam">
<br />
<!-- survey_id is a fake number, the controller will grab the real survey_id from $_REQUEST -->
<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/surveys/Polling',
array('admin_console' => 'true','survey_id' => '1234567',));
?>
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=\RightNow\Utils\Url::getCoreAssetPath('js/4.171/min/RightNow.js');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/surveys/Polling', ), '/agent/polling_preview.js', '1439568043');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'VALUE_REQD_MSG' => array ( 'value' => 4707, ), 'FLD_CONT_TOO_MANY_CHARS_MSG' => array ( 'value' => 4554, ), 'NEED_TO_SELECT_MORE_OPTIONS_MSG' => array ( 'value' => 6802, ), 'NEED_TO_SELECT_FEWER_OPTIONS_MSG' => array ( 'value' => 6801, ), 'POLL_RESULTS_PIE_CHART_UC_LBL' => array ( 'value' => 3196, ), 'POLL_RESULTS_HORIZ_BAR_CHART_LBL' => array ( 'value' => 3192, ), 'POLL_RESS_VERTICAL_BAR_CHART_LBL' => array ( 'value' => 3191, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html><?
}
?>
