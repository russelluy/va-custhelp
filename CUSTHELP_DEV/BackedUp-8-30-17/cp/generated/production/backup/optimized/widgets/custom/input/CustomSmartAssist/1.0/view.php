<?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=
$this->classList ?> rn_Hidden">
    <rn:block id="top"/>
    <div class="rn_MessageBox rn_InfoMessage">
        <rn:block id="preBanner"/>
        <span id="rn_<?=$this->instanceID;?>_DialogHeading" class="rn_Heading"><??></span>
        <rn:block id="postBanner"/>
    </div>
    <rn:block id="preContent"/>
    <div id="rn_<?=$this->instanceID;?>_DialogContent" role="document"><?
?></div>
    <rn:block id="postContent"/>
    <rn:block id="bottom"/>
</div>
