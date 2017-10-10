<?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=
$this->classList ?>">
    <rn:block id="top"/>
    <label for="rn_<?=$this->instanceID;?>_Text"><?=$this->data['attrs']['label_text'];?></label>
    <rn:block id="preInput"/>
    <input
      id="rn_<?=$this->instanceID;?>_Text"
      name="rn_<?=$this->instanceID;?>_Text"
    <?php
if (isset($this->data['attrs']['placeholder'])){
echo 'placeholder="' . $this->data['attrs']['placeholder'] . '"';
};
?>
    type="text"
    maxlength="255"
    value="<?=$this->data['js']['initialValue'];?>"
    />
    <rn:block id="postInput"/>
    <rn:block id="bottom"/>
</div>
