<?php /* Originating Release: May 2016 */?>
<div id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?> rn_Hidden">
    <rn:block id="top"/>
    <div class="rn_MessageBox rn_InfoMessage">
        <rn:block id="preBanner"/>
        <span id="rn_<?=$this->instanceID;?>_DialogHeading" class="rn_Heading"><?/*Smart Assistant banner goes here*/?></span>
        <rn:block id="postBanner"/>
    </div>
    <rn:block id="preContent"/>
    <div id="rn_<?=$this->instanceID;?>_DialogContent"><? /**SmartAssistant content goes here*/?></div>
    <rn:block id="postContent"/>
    <rn:block id="bottom"/>
</div>
