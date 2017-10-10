<?php /* Originating Release: May 2016 */?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>

    <rn:block id="preUpvoteButton"/>
    <? $ratingView = ($this->data['attrs']['rating_type'] === 'star') ? 'starView' : 'buttonView'; ?>
    <?= $this->render($ratingView, array(
            'disabled' => $disabled = (!$this->data['js']['canRate'] || $this->data['js']['alreadyRated']),
            'title' => $disabled ? ($this->data['js']['canRate'] ? $this->data['attrs']['label_upvote_thanks'] : $this->data['attrs']['label_upvote_disabled_tooltip']) : $this->data['attrs']['label_upvote_hint'],
        ))
    ?>
    <rn:block id="postUpvoteButton"/>

    <rn:block id="preRatingValue"/>
    <span class="rn_Separator"></span>
    <span class="rn_RatingValue" itemprop="<?= $this->data['attrs']['rating_type'] ?>Count" title="<?= $this->helper->chooseCountLabel($this->data['js']['ratingValue'], $this->data['attrs']['label_vote_count_singular'], $this->data['attrs']['label_vote_count_plural']) ?>">
        <? if($this->data['js']['ratingValue'] !== 0): ?>
            <?= $this->data['js']['totalRatingLabel'] ?>
        <? elseif(\RightNow\Utils\Framework::isLoggedIn() && !$this->data['js']['canRate']): ?>
            <?= $this->data['attrs']['label_upvote_disabled_tooltip'] ?>
        <? else: ?>
            <?= $this->data['attrs']['label_be_first_to_vote'] ?>
        <? endif; ?>
    </span>
    <rn:block id="postRatingValue"/>

    <rn:block id="bottom"/>
</div>
