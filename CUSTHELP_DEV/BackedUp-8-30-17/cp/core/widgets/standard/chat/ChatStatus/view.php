<?php /* Originating Release: May 2016 */?>
<div id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
<? if($this->data['chatHours']['inWorkHours'] && !$this->data['chatHours']['holiday']):?>
    <?=$this->data['attrs']['label_chat_available'];?>
<? else:?>
    <?=$this->data['attrs']['label_chat_unavailable'];?>
<? endif;?>
    <rn:block id="bottom"/>
</div>
