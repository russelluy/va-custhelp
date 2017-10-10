<?php /* Originating Release: May 2016 */?>
<div id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <form id="rn_<?=$this->instanceID;?>_SearchForm" onsubmit="return false;">
        <rn:block id="preInput"/>
        <input type="text" id="rn_<?=$this->instanceID;?>_SearchField" name="rn_<?=$this->instanceID;?>_SearchField" class="rn_SearchField" maxlength="255" value="<?=$this->data['attrs']['label_hint'];?>" title="<?=$this->data['attrs']['label_hint'];?>"/>
        <rn:block id="postInput"/>
        <? /*IE needs extra input element for form submit on enter*/ ?>
        <? if($this->data['isIE']): ?>
        <label for="rn_<?=$this->instanceID;?>_HiddenInput" class="rn_Hidden">&nbsp;</label>
        <input id="rn_<?=$this->instanceID;?>_HiddenInput" type="text" class="rn_Hidden"/>
        <? endif;?>
        <rn:block id="preImage"/>
        <input type="image" id="rn_<?=$this->instanceID;?>_Submit" class="rn_SearchImage" src="<?=$this->data['attrs']['icon_path'];?>" alt="<?=$this->data['attrs']['alt_text'];?>"/>
        <rn:block id="postImage"/>
    </form>
    <rn:block id="bottom"/>
</div>
