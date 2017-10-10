<?php /* Originating Release: May 2016 */?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <h3><?= $this->data['attrs']['label_title'] ?></h3>

    <? if ($this->data['bestAnswers']): ?>
    <?= $this->render('BestAnswers', array(
        'bestAnswers' => $this->data['bestAnswers'],
        'question'    => $this->data['question'],
        'socialUser'  => $this->data['socialUser'],
    )) ?>
    <? else: ?>
    <p><?= $this->data['attrs']['label_no_best_answers'] ?></p>
    <? endif; ?>
    <rn:block id="bottom"/>
</div>
