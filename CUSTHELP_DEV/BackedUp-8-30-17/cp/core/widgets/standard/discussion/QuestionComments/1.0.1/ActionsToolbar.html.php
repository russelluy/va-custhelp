<div class="rn_CommentToolbarLeft">
    <ul role="menubar">
        <? if ($this->helper->shouldDisplayCommentReply($comment)): ?>
        <li role="menuitem" class="rn_CommentAction">
            <a href="javascript:void(0);" class="rn_CommentAction rn_ReplyAction <?= (!$this->data['socialUser']) ? 'rn_SocialLogin' : '' ?>" role="button">
                <span class="rn_ActionLabel"><?= \RightNow\Utils\Config::getMessage(REPLY_LBL) ?></span>
            </a>
        </li>
        <? endif; ?>

        <? if($comment->SocialPermissions->isActive() && $this->data['attrs']['show_share_link']): ?>
        <li role="menuitem" class="rn_CommentAction">
            <a href="javascript:void(0);" class="rn_CommentAction rn_ShareAction" role="button" aria-haspopup="true">
                <span class="rn_ActionLabel"><?= \RightNow\Utils\Config::getMessage(SHARE_CMD) ?></span>
            </a>
        </li>
        <? endif; ?>

        <li role="menuitem" class="rn_CommentRating">
            <rn:widget path="feedback/SocialContentRating" comment_id="#rn:php:$comment->ID#" question_id="#rn:php:$this->helper->question->ID#" sub_id="commentRating" />
        </li>
    </ul>
</div>

<div class="rn_CommentToolbarRight">
    <ul role="menubar">
        <? if(!\RightNow\Utils\Framework::isSocialUser() || $comment->SocialPermissions->canFlag()): ?>
        <li role="menuitem" class="rn_CommentAction">
            <rn:widget path="feedback/SocialContentFlagging" comment_id="#rn:php:$comment->ID#" question_id="#rn:php:$questionID#" sub_id="commentFlag" />
        </li>
        <? endif; ?>

        <? if ($comment->SocialPermissions->canUpdate()): ?>
        <li role="menuitem" class="rn_CommentAction">
            <rn:block id="preCommentEdit"/>
            <a href="javascript:void(0);" class="rn_EditCommentAction" data-commentID="<?= $comment->ID ?>">
                <span class="rn_ActionLabel"><?= $this->data['attrs']['label_edit'] ?></span>
            </a>
            <rn:block id="postCommentEdit"/>
        </li>
        <? endif; ?>
    </ul>
</div>
