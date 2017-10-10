<?php /* Originating Release: May 2016 */?>
<div id="rn_<?= $this->instanceID ?>" class="<?= $this->classList ?>">
<rn:block id="top">
<?if($this->data['attrs']['label_heading']):?>
    <rn:block id="title">
        <h2><?= $this->data['attrs']['label_heading'] ?></h2>
    </rn:block>
<?endif;?>
    <rn:block id="preList"/>
    <ul>
    <? foreach($this->data['previousContent'] as $content): ?>
        <rn:block id="recentlyViewedItem">
        <?= $this->render($this->helper->getContentType($content), array('content' => $content)) ?>
        </rn:block>
    <? endforeach; ?>
    </ul>
    <rn:block id="postList"/>
<rn:block id="bottom"/>
</div>
