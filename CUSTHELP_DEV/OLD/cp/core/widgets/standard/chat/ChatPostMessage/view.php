<?php /* Originating Release: November 2014 */?>
<div id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?> rn_Hidden">
    <rn:block id="top"/>
    <rn:block id="preInstructions"/>
    <div><?=$this->data['attrs']['label_send_instructions'];?></div>
    <rn:block id="postInstructions"/>
    <rn:block id="preTextArea"/>
    <span>
        <textarea id="rn_<?=$this->instanceID;?>_Input" rows="3" cols="50"></textarea>
    </span>
    <rn:block id="postTextArea"/>
    <rn:block id="bottom"/>
</div>
