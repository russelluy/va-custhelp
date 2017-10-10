<aside class="rn_QuestionInfo">
    <rn:block id="questionTimestamps">
    <div class="rn_QuestionTimestamps">
        <span class="rn_CreationTimestamp">
            <? printf($this->data['attrs']['label_created_time'], "<time itemprop='dateCreated' pubdate datetime='" . $this->formatDate($question->CreatedTime) . "'>" . $this->formatDate($question, 'CreatedTime') . "</time>") ?>
        </span>
    </div>
    </rn:block>

    <div class="rn_QuestionInfoOptions">
        <rn:block id="preQuestionRating"/>
            <rn:widget path="feedback/SocialContentRating" question_id="#rn:php:$question->ID#" content_type="question" sub_id="rating"/>
        <rn:block id="postQuestionRating"/>

        <rn:widget path="feedback/SocialContentFlagging" question_id="#rn:php:$question->ID#" content_type="question" sub_id="flags"/>

        <? if ($question->SocialPermissions->canUpdate()): ?>
        <rn:block id="questionEditActions">
            <div class="rn_QuestionActions">
                <a class="rn_EditQuestionLink" href="javascript:void(0);"><?= $this->data['attrs']['label_edit'] ?></a>
            </div>
        </rn:block>
        <? endif; ?>
    </div>
</aside>
