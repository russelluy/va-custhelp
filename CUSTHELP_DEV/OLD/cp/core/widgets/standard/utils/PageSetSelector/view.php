<?php /* Originating Release: November 2014 */?>
<span id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <?=$this->data['attrs']['label_message'];?>
    <rn:block id="preLoop"/>
    <? foreach($this->data['sets'] as $key => $set):?>
        <rn:block id="item">
        <? if($set['current']):?>
            <span class="rn_Bold"><?=$set['label'];?></span>
        <? else:?>
            <a href="/ci/redirect/pageSet/<?=urlencode($set['mapping'])?>/<?=htmlspecialchars($this->data['currentPage'], ENT_QUOTES, 'UTF-8')?>#rn:session#"><?=$set['label'];?></a>
        <? endif;?>
        <?=((++$count < count($this->data['sets'])) ? '|' : '');?>
        </rn:block>
    <? endforeach;?>
    <rn:block id="postLoop"/>
    <rn:block id="bottom"/>
</span>
