<div class="rn_StarVoting">
    <? for($i = $this->data['js']['ratingScale']; $i >= 1; $i--): ?>
        <button class="<?= ($this->data['js']['alreadyRated'] && $this->data['js']['userRating'] >= $i) ? 'rn_StarVotedButton' : 'rn_StarVoteButton'?>" title="<?= $title ?>" <?= $disabled ? 'disabled' : '' ?> value="<?= $i ?>">
            <span class="rn_ScreenReaderOnly" aria-live="polite"><?= !$disabled ? "$title $i" : $title ?></span>
        </button>
    <? endfor; ?>
</div>

