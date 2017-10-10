<?php /* Originating Release: May 2016 */?>
<div id="rn_<?=$this->instanceID?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <? /* Define the rating feedback control. */ ?>
    <div id="rn_<?=$this->instanceID?>_AnswerFeedbackControl" class="rn_AnswerFeedbackControl">
        <? if ($this->data['attrs']['label_title']): ?>
            <div class="rn_Title"><?=$this->data['attrs']['label_title']?></div>
        <? endif;?>
        <? if ($this->data['js']['buttonView']): ?>
            <?= $this->render('buttonView') ?>
        <? elseif ($this->data['attrs']['use_rank_labels']):?>
            <?= $this->render('rankLabels') ?>
        <? else:?>
            <?= $this->render('ratingMeter') ?>
        <? endif;?>
    </div>
    <? /* Container for feedback form.  It's hidden on the page. */ ?>
    <div id="rn_<?=$this->instanceID?>_AnswerFeedbackForm" class="rn_AnswerFeedbackForm rn_Hidden">
        <div id="rn_<?=$this->instanceID?>_DialogDescription" class="rn_DialogSubtitle"><?=$this->data['attrs']['label_dialog_description'];?></div>
        <div id="rn_<?=$this->instanceID;?>_ErrorMessage"></div>
        <rn:block id="preForm"/>
        <form>
        <rn:block id="topForm"/>
        <? if (!$this->data['js']['isProfile']): ?>
            <rn:block id="preEmailInput"/>
            <label for="rn_<?=$this->instanceID?>_EmailInput"><?=$this->data['attrs']['label_email_address'];?><span class="rn_Required" > <?=\RightNow\Utils\Config::getMessage(FIELD_REQUIRED_MARK_LBL);?></span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage(REQUIRED_LBL)?></span></label>
            <input id="rn_<?=$this->instanceID?>_EmailInput"  class="rn_EmailField" type="text" value="<?=$this->data['js']['email'];?>"/>
            <rn:block id="postEmailInput"/>
        <? endif;?>
        <rn:block id="preFeedbackInput"/>
        <label for="rn_<?=$this->instanceID?>_FeedbackTextarea"><?=$this->data['attrs']['label_comment_box'];?><span class="rn_Required" > <?=\RightNow\Utils\Config::getMessage(FIELD_REQUIRED_MARK_LBL);?></span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage(REQUIRED_LBL)?></span></label>
        <textarea id="rn_<?=$this->instanceID?>_FeedbackTextarea" class="rn_Textarea" rows="4" cols="60"></textarea>
        <rn:block id="postFeedbackInput"/>
        <rn:block id="bottomForm"/>
        </form>
        <rn:block id="postForm"/>
    </div>
    <? /* End form */ ?>
    <rn:block id="bottom"/>
</div>
