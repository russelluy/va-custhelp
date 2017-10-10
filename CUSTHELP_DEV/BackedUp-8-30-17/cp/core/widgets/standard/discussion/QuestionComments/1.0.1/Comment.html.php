<? if ($this->helper->commentIsBestAnswer($comment) && $comment->SocialPermissions->isActive() && $this->question->SocialPermissions->isActive()): ?>
<div id="rn_<?= $this->instanceID ?>_<?= $comment->ID ?>" data-commentID="<?= $comment->ID ?>" data-contentType="<?= $comment->BodyContentType->LookupName ?>" class="rn_CommentContainer rn_BestAnswer" aria-describedby="rn_<?= $this->instanceID ?>_<?= $comment->ID ?>_BestAnswerInfo" itemprop="suggestedAnswer acceptedAnswer" itemscope itemtype="http://schema.org/Answer">
<? else: ?>
<div id="rn_<?= $this->instanceID ?>_<?= $comment->ID ?>" data-commentID="<?= $comment->ID ?>" data-contentType="<?= $comment->BodyContentType->LookupName ?>" class="rn_CommentContainer" itemprop="suggestedAnswer" itemscope itemtype="http://schema.org/Answer">
<? endif; ?>

    <? if(!$this->data['attrs']['use_rich_text_input']): ?>
        <span id="rn_<?= $this->instanceID ?>_<?= $comment->ID ?>_rawComment" data-rawCommentText="<?= \RightNow\Utils\Text::escapeHtml($comment->Body) ?>" class="rn_Hidden rn_rawCommentText"></span>
    <? endif; ?>

    <rn:block id="preCommentContainer"/>
    <div class="rn_CommentInfo">
        <rn:block id="preCommentAvatar"/>
        <span class="rn_CommentAvatarImage" itemprop="author" itemscope itemtype="http://schema.org/Person">
            <?= $this->render('Partials.Social.Avatar', $this->helper('Social')->defaultAvatarArgs($comment->CreatedBySocialUser, array(
                'size' => $this->data['attrs']['avatar_size'],
            ))) ?>
        </span>
        <rn:block id="postCommentAvatar"/>
    </div>

    <? /* ID serves as the comment's permalink. */ ?>
    <div class="rn_CommentContent <?= $comment->SocialPermissions->canDelete() ? 'rn_CommentDeletable' : '' ?>" id="comment_<?=$comment->ID ?>">

        <? if($comment->SocialPermissions->isSuspended() && $comment->SocialPermissions->canUpdateStatus()): ?>
        <div class="rn_Banner rn_SuspendedComment">
            <?= $this->data['attrs']['label_comment_suspended_banner']; ?>
        </div>
        <? endif; ?>

        <div class="rn_HeaderToolbar">
            <div class="rn_CommentAction">
                <div class="rn_BestAnswerInfo" aria-live="assertive" aria-relevant="all">
                    <?= $this->render('BestAnswerLabel', array('comment' => $comment)) ?>
                </div>

                <rn:condition is_social_moderator="true">
                    <rn:widget path="moderation/ModerationInlineAction" label_action_suspend_user="#rn:msg:SUSPEND_AUTHOR_LBL#" label_action_approve_restore_user="#rn:msg:APPROVERESTORE_AUTHOR_LBL#" label_user_not_found_error="#rn:msg:AUTHOR_DOES_NOT_EXIST_MSG#" label_action_menu="#rn:msg:MODERATE_LBL#" object_type="SocialComment" object_id="#rn:php:$comment->ID#" sub_id="moderate"/>
                </rn:condition>
            </div>
        </div>

        <rn:block id="preCommentContent"/>
        <? if ($this->helper->shouldDisplayCommentContent($comment)): ?>
            <div class="rn_CommentText" itemprop="text">
                <?= $this->helper('Social')->formatBody($comment, $this->data['attrs']['highlight']) ?>
            </div>
        <? else: ?>
            <div class="rn_CommentText rn_RemovedComment"><?= $this->data['attrs']['label_comment_unavailable'] ?></div>
        <? endif; ?>
        <rn:block id="postCommentContent"/>

        <div class="rn_CommentFooter">
            <div class="rn_Timestamps">
                <span class="rn_CommentCreatedTime">
                    <rn:block id="preCommentCreatedTime"/>
                    <? printf($this->data['attrs']['label_comment_created_on'], '<time itemprop="dateCreated">' . $this->helper->formattedTimestamp($comment->CreatedTime) . '</time>') ?>
                    <rn:block id="postCommentCreatedTime"/>
                </span>
            </div>

            <?= $this->render('BestAnswerActions', array('comment' => $comment)) ?>

            <div class="rn_CommentToolbar">
                <?= $this->render('ActionsToolbar', array('comment' => $comment, 'questionID' => $questionID)) ?>
            </div>
        </div>
    </div>

    <rn:block id="postCommentContainer"/>
</div>
