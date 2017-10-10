<div id="rn_<?= $this->instanceID ?>" class="rn_InfoButton <?= $this->classList ?>">
    <? if ($this->data['attrs']['icon_path']):?>
        <input type="image" class="rn_SubmitImage" 
                id="rn_<?=$this->instanceID;?>_SubmitButton" 
                name="rn_<?=$this->instanceID;?>_SubmitButton" 
        		<?=tabIndex($this->data['attrs']['tabindex'],
1);?> 
        		src="<?=$this->data['attrs']['icon_path'];?>" 
        		alt="<?=$this->data['attrs']['icon_alt_text'];?>" 
        		title="<?=$this->data['attrs']['label_button'];?>"
                value=""/>
    <?
else:?>
        <input type="submit" class="rn_InfoButton"
                id="rn_<?=$this->instanceID;?>_SubmitButton" 
                name="rn_<?=$this->instanceID;?>_SubmitButton" 
        		<?=tabIndex($this->data['attrs']['tabindex'],
1);?> 
                alt="<?=$this->data['attrs']['icon_alt_text'];?>" 
                title="<?=$this->data['attrs']['label_button'];?>"
                value=""/>
    <?
endif;?>
    <?
if($this->data['isIE']): ?>
    	<label for="rn_<?=$this->instanceID;?>_HiddenInput" class="rn_Hidden">&nbsp;</label>
		<input id="rn_<?=$this->instanceID;?>_HiddenInput" name="rn_<?=$this->instanceID;?>_HiddenInput" type="text" class="rn_Hidden" disabled="disabled" value=""/>
    <?
endif;?>
</div>
