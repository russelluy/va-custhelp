<?php /* Originating Release: November 2014 */?>
<div id="rn_<?=$this->instanceID;?>" class="<?= $this->classList ?>">
    <rn:block id="top"/>
    <div id="rn_<?= $this->instanceID ?>_LabelContainer">
        <rn:block id="preFileInputLabel"/>
        <label for="rn_<?=$this->instanceID;?>_FileInput" id="rn_<?=$this->instanceID;?>_Label"><?=$this->data['attrs']['label_input'];?>
        <? if($this->data['attrs']['min_required_attachments'] > 0):?>
            <span class="rn_Required"> <?=\RightNow\Utils\Config::getMessage(FIELD_REQUIRED_MARK_LBL);?> </span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage(REQUIRED_LBL)?></span>
        <? endif;?>
        </label>
        <rn:block id="postFileInputLabel"/>
    </div>
    <rn:block id="preFileInput"/>
    <input name="file" id="rn_<?=$this->instanceID;?>_FileInput" type="file" aria-labelledby="rn_<?=$this->instanceID;?>_Label"/>
    <rn:block id="postFileInput"/>
    <? if($this->data['attrs']['loading_icon_path']):?>
    <img id="rn_<?=$this->instanceID;?>_LoadingIcon" class="rn_Hidden" alt="" src="<?=$this->data['attrs']['loading_icon_path'];?>" />
    <? endif;?>
    <rn:block id="preStatus"/>
    <span id="rn_<?=$this->instanceID;?>_StatusMessage"></span>
    <rn:block id="postStatus"/>
    <rn:block id="bottom"/>
</div>
