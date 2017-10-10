<?php /* Originating Release: May 2016 */?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <div id="rn_<?= $this->instanceID ?>_Alert" role="alert" class="rn_ScreenReaderOnly"></div>
    <rn:block id="content">
    <div id="rn_<?= $this->instanceID ?>_Content" class="rn_Content">
        <? if (strtolower($this->data['js']['viewType']) === 'table'): ?>
            <?= $this->render('table', array('data' => $this->data['articles'], 'type' => $type, 'fields' => $this->data['fields'], 'attrs' => $this->data['attrs'], 'url' => $this->data['js']['answerUrl'])) ?>
        <? else: ?>
            <?= $this->render('list', array('data' => $this->data['articles'], 'type' => $type, 'attrs' => $this->data['attrs'], 'url' => $this->data['js']['answerUrl'])) ?>
        <? endif; ?>
    </div>
    </rn:block>
    <rn:block id="bottom"/>
</div>
