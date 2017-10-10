<?php /* Originating Release: November 2014 */?>
<span id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <a onclick="window.print(); return false;" href="javascript:void(0);" title="<?=$this->data['attrs']['label_tooltip'];?>">
        <? if($this->data['attrs']['icon_path']):?>
            <img src="<?=$this->data['attrs']['icon_path'];?>" alt="<?=$this->data['attrs']['label_icon_alt']?>"/>
        <? endif;?>
        <span><?=$this->data['attrs']['label_link'];?></span>
    </a>
    <rn:block id="bottom"/>
</span>
