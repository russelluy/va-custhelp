<?php /* Originating Release: May 2016 */?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>

    <rn:block id="preUpvoteButton"/>
    <?= $this->render('buttonView', array(
            'disabled' => $disabled = (!$this->data['js']['canRate'] || $this->data['js']['alreadyRated']),
            'title' => $disabled ? ($this->data['js']['canRate'] ? $this->data['attrs']['label_upvote_thanks'] : $this->data['attrs']['label_upvote_disabled']) : $this->data['attrs']['label_upvote_hint'],
        ))
    ?>
    <rn:block id="postUpvoteButton"/>

    <rn:block id="preRatingValue"/>
    <span class="rn_RatingValue" itemprop="upvoteCount" title="<?= $this->helper->chooseCountLabel($this->data['js']['ratingValue'], $this->data['attrs']['label_vote_count_singular'], $this->data['attrs']['label_vote_count_plural']) ?>">
        <?= $this->data['js']['ratingValue'] ?: '' ?>
    </span>
    <rn:block id="postRatingValue"/>

    <rn:block id="bottom"/>
</div>
