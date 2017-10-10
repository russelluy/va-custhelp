<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/basic', 1 => '/euf/assets/themes/basic', 2 => array ( '/euf/assets/themes/basic' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/basic', ), ));
get_instance()->_checkMeta(array('javascript_module'=>'none', 'title'=>'' . \RightNow\Libraries\SEO::getDynamicTitle('answer', \RightNow\Utils\Url::getParameter('a_id')) . '', 'template'=>'basic.php', 'answer_details'=>'true', 'clickstream'=>'answer_view'));
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
require_once CPCORE . 'Libraries/PostRequest.php';
class BasicFormStatusDisplay extends \RightNow\Libraries\Widget\Base {
function _standard_input_BasicFormStatusDisplay_view ($data) {
extract($data);
?><div class="rn_BasicFormStatusDisplay">
<? if($this->data['messages']): ?>
    <hr/><hr/>
    <? if($this->data['attrs']['label']): ?>
        <div><?=$this->data['attrs']['label']?></div>
    <? endif;
?>
    <? foreach($this->data['messages'] as $type => $types): ?>
        <? foreach($types as $field => $items): ?>
            <div class="rn_BasicFormStatusDisplay_<?=$type?>">
            <span class="rn_BasicFormStatusDisplay_Field"><?=$field;?></span>
            <?
foreach($items as $item): ?>
                <div><?=($field === '') ? $item : " - $item";?></div>
            <?
endforeach;
?>
            <br/></div>
        <? endforeach;
?>
    <? endforeach;
?>
    <hr/><hr/>
<? endif;
?>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['messages'] = \RightNow\Libraries\PostRequest::getMessages();
}
}
function _standard_input_BasicFormStatusDisplay_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicFormStatusDisplay', 'view_func_name' => '_standard_input_BasicFormStatusDisplay_view', 'meta' => array ( 'controller_path' => 'standard/input/BasicFormStatusDisplay', 'view_path' => 'standard/input/BasicFormStatusDisplay', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/BasicFormStatusDisplay.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(43035)', ), 'relativePath' => 'standard/input/BasicFormStatusDisplay', 'widget_name' => 'BasicFormStatusDisplay', ), );
$result['meta']['attributes'] = array( 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
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
class BasicAnswerFeedback extends \RightNow\Widgets\AnswerFeedback {
function _standard_feedback_BasicAnswerFeedback_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID?>" class="<?= $this->classList ?>">
    <div id="rn_<?=$this->instanceID?>_AnswerFeedbackControl" class="rn_AnswerFeedbackControl">
        <form method='post' action='/app/<?=\RightNow\Utils\Config::configGetFrom((222));?>/a_id/<?=
$this->data['js']['answerID'] ?>'><div>
            <input type="hidden" name="answerFeedback[OptionsCount]" value="<?=$this->data['attrs']['options_count']?>" />
            <input type="hidden" name="answerFeedback[Threshold]" value="<?=$this->data['attrs']['threshold']?>" />
            <? if ($this->data['attrs']['label_title']): ?>
                <h2><?=$this->data['attrs']['label_title']?></h2>
            <? endif;
?>
            <? if ($this->data['js']['buttonView']): ?>
                <input type="radio" id="rn_<?=$this->instanceID?>_RatingYesButton" name="answerRating" value="2" /><label for="rn_<?=$this->instanceID?>_RatingYesButton"><?=$this->data['attrs']['label_yes_button']?></label><br />
                <input type="radio" id="rn_<?=$this->instanceID?>_RatingNoButton" name="answerRating" value="1" /><label for="rn_<?=$this->instanceID?>_RatingNoButton"><?=$this->data['attrs']['label_no_button']?></label><br />
            <? else: ?>
                <? if ($this->data['attrs']['options_descending']): ?>
                    <? for($i = $this->data['attrs']['options_count'];
$i > 0;
$i--): ?>
                        <input type="radio" id="rn_<?=$this->instanceID?>_RatingButton_<?=$i?>" name="answerRating" value="<?=$i?>" /><label for="rn_<?=$this->instanceID?>_RatingButton_<?=$i?>"><?=\RightNow\Utils\Config::getMessage($this->data['rateLabels'][$i])?></label><br />
                    <? endfor;
?>
                <? else: ?>
                    <? for($i = 1;
$i <= $this->data['attrs']['options_count'];
$i++): ?>
                        <input type="radio" id="rn_<?=$this->instanceID?>_RatingButton_<?=$i?>" name="answerRating" value="<?=$i?>" /><label for="rn_<?=$this->instanceID?>_RatingButton_<?=$i?>"><?=\RightNow\Utils\Config::getMessage($this->data['rateLabels'][$i])?></label><br />
                    <? endfor;
?>
                <? endif;
?>
            <? endif;
?>
            <br />
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/BasicFormSubmit', array('label_button' => '' . $this->data['attrs']['label_submit_button'] . '',));
?>
        <?= \RightNow\Utils\Widgets::addServerConstraints('/app/' . \RightNow\Utils\Config::configGetFrom((222)) . '/a_id/' . $this->data['js']['answerID'] . '', '' . $this->data['attrs']['post_request_handler'] . '');
?></div></form>
    </div>
</div>
<? }
}
function _standard_feedback_BasicAnswerFeedback_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicAnswerFeedback', 'view_func_name' => '_standard_feedback_BasicAnswerFeedback_view', 'meta' => array ( 'controller_path' => 'standard/feedback/BasicAnswerFeedback', 'view_path' => 'standard/feedback/BasicAnswerFeedback', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(43027)', 'urlParameters' => array ( 'a_id' => array ( 'name' => 'rn:msg:(4653)', 'description' => 'rn:msg:(998)', 'example' => 'a_id/3', ), ), ), 'extends' => array ( 'widget' => 'standard/feedback/AnswerFeedback', 'versions' => array ( 0 => '1.0', 1 => '1.1', 2 => '1.2', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'contains' => array ( 0 => array ( 'widget' => 'standard/input/BasicFormSubmit', 'versions' => array ( 0 => '1.0', ), ), ), 'relativePath' => 'standard/feedback/BasicAnswerFeedback', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/feedback/AnswerFeedback', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/feedback/AnswerFeedback', ), 'widget_name' => 'BasicAnswerFeedback', 'extends_php' => array ( 0 => 'standard/feedback/AnswerFeedback', ), 'parent' => 'standard/feedback/AnswerFeedback', ), );
$result['meta']['attributes'] = array( 'threshold' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 1, 'type' => 'int', 'default' => 1, 'min' => 0, 'inherited' => false, )), 'post_request_handler' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'postRequest/submitAnswerRating', 'type' => 'string', 'default' => 'postRequest/submitAnswerRating', 'inherited' => false, )), 'label_submit_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4551), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(4551), 'inherited' => false, )), 'label_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4177), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(4177), 'inherited' => true, )), 'label_accessible_option_description' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3317), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3317), 'inherited' => true, )), 'options_count' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 2, 'type' => 'int', 'default' => 2, 'min' => 2, 'max' => 5, 'inherited' => true, )), 'options_descending' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), 'label_yes_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(869), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(869), 'inherited' => true, )), 'label_no_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(863), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(863), 'inherited' => true, )), );
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
class BasicFormSubmit extends \RightNow\Libraries\Widget\Base {
function _standard_input_BasicFormSubmit_view ($data) {
extract($data);
?><div class="<?= $this->classList ?>">
        <input type="submit" id="rn_<?= $this->instanceID ?>_Button" value="<?= $this->data['attrs']['label_button'] ?>"/>
    <input type="hidden" name="f_tok" value="<?=$this->data['f_tok']?>"/>
    <? foreach($this->data['format'] as $key => $value): ?>
        <? if($value): ?>
            <input type="hidden" name="format[<?=$key?>]" value="<?=$value?>"/>
        <? endif;
?>
    <? endforeach;
?>
</div><? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['f_tok'] = \RightNow\Utils\Framework::createTokenWithExpiration(0);
$this->data['format'] = array( 'on_success_url' => $this->data['attrs']['on_success_url'], 'add_params_to_url' => $this->data['attrs']['add_params_to_url'], );
}
}
function _standard_input_BasicFormSubmit_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicFormSubmit', 'view_func_name' => '_standard_input_BasicFormSubmit_view', 'meta' => array ( 'controller_path' => 'standard/input/BasicFormSubmit', 'view_path' => 'standard/input/BasicFormSubmit', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(43036)', ), 'relativePath' => 'standard/input/BasicFormSubmit', 'widget_name' => 'BasicFormSubmit', ), );
$result['meta']['attributes'] = array( 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4550), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4550), 'inherited' => false, )), 'on_success_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
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
$this->data['link_tests_fail'] = '/ci/redirect/pageSet/' . urlencode($this->data['attrs']['fail_page_set']) . '/' . Url::deleteParameter(Text::getSubstringAfter(ORIGINAL_REQUEST_URI, "/app/"), 'session') . Url::sessionParameter();
$this->data['label_tests_fail'] = sprintf($this->data['attrs']['label_tests_fail'], $this->data['link_tests_fail']);
$this->data['label_tests_pass'] = sprintf($this->data['attrs']['label_tests_pass'], '/ci/redirect/pageSet/' . urlencode($this->data['attrs']['pass_page_set']) . '/' . Url::deleteParameter(Text::getSubstringAfter(ORIGINAL_REQUEST_URI, "/app/"), 'session') . Url::sessionParameter());
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
.rn_BasicFormStatusDisplay{font-weight:bold;}
.rn_BasicFormStatusDisplay_error{color:#E80000;}
.rn_BasicFormStatusDisplay_info{color:#008000;}
.rn_BasicFormStatusDisplay_Field{font-size:1.2em;}
.rn_FileListDisplay .rn_DataLabel{display:block;font-weight:bold;}
.rn_FileListDisplay .rn_DataValue ul{margin:0;}
.rn_FileListDisplay .rn_DataValue li{padding:10px 0;}
.rn_FileListDisplay .rn_FileSize{color:#555;font-style:italic;padding-left:4px;}
.rn_FileTypeImageThumbnail{border: 2px solid #fff;height: 64px;width: 64px;vertical-align: middle;margin-right: 6px;}
.rn_ProductCategoryDisplay .rn_DataLabel{float:left;font-weight:bold;}
.rn_ProductCategoryDisplay .rn_DataValue{margin-left:50px;}
.rn_ProductCategoryDisplay .rn_DataValue ul{clear:none;margin:0;}
.rn_ProductCategoryDisplay .rn_DataValue.rn_LeftJustify{clear:left;margin-left:0;padding-bottom:1%;}
.rn_IncidentThreadDisplay .rn_ThreadContent{word-wrap:break-word;}
.rn_IncidentThreadDisplay p.MsoNormal, .rn_IncidentThreadDisplay li.MsoNormal, .rn_IncidentThreadDisplay div.MsoNormal{margin:0;}
.rn_IncidentThreadDisplay p.MsoListParagraph, .rn_IncidentThreadDisplay li.MsoListParagraph, .rn_IncidentThreadDisplay div.MsoListParagraph{margin: 0 0 0 48px;}
.rn_IncidentThreadDisplay .rn_ThreadHeader{background-color:#EEE;border: 1px solid #CCC;font-weight:bold;padding:1px;position:relative;}
.rn_IncidentThreadDisplay .rn_ThreadHeader .rn_ThreadTime{display:block;}
.rn_IncidentThreadDisplay .rn_ThreadContent{background-color:#FFF;padding:10px;}
.rn_FieldDisplay .rn_DataLabel{float:left;font-weight:bold;padding-right: 5px;}
.rn_FieldDisplay .rn_DataValue.rn_LeftJustify{clear:left;margin-left:0;padding-bottom:5px;}
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
<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/BasicFormStatusDisplay',
array());
?>
<div>
    <h1><?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array ( 0 => 'Answer', 1 => 'Summary', ), true);?></h1>
    <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'Question', ), true);?>
</div>
<div>
    <div>
        <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'Solution', ), true);?>
    </div><br />
    <div>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/output/DataDisplay',
array('name' => 'Answer.FileAttachments','left_justify' => 'true','label' => '' . \RightNow\Utils\Config::msgGetFrom((33337)) . '',));
?>
    </div><br />
    <div>
        <b><?=\RightNow\Utils\Config::msgGetFrom((5642));?></b> <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'CreatedTime', ), false);?><br />
        <b><?=\RightNow\Utils\Config::msgGetFrom((6861));?></b> <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Answer', 1 => 'UpdatedTime', ), false);?><br />
    </div>
</div>
<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/feedback/BasicAnswerFeedback',
array('on_success_url' => '/app/answers/submit_feedback',));
?>
<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/knowledgebase/RelatedAnswers', array());
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
