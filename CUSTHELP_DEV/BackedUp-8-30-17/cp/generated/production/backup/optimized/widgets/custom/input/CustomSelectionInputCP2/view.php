<?php  ?>
<rn:meta controller_path="custom/input/CustomSelectionInput" 
    js_path="custom/input/CustomSelectionInput" 
    base_css="standard/input/SelectionInput" 
    presentation_css="widgetCss/SelectionInput.css" 
    compatibility_set="November '09+"
    required_js_module="november_09,mobile_may_10"/>
<div id="rn_<?=$this->instanceID;?>_parent" class="<?
if(!$this->data['attrs']['always_show']): echo('rn_Hidden');
endif;?>" >
<?
if($this->data['readOnly']):?>
<rn:widget path="output/FieldDisplay" left_justify="true"/>
<? else:?>
<div id="rn_<?=$this->instanceID;?>" class="rn_SelectionInput">
<?
if($this->field->data_type === (4) || $this->field->data_type === (12)):?>
    <? if($this->data['attrs']['label_input']):?>
    <label for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" id="rn_<?=$this->instanceID;?>_Label" class="rn_Label"><?=$this->data['attrs']['label_input'];?>
    <?
if($this->data['attrs']['required']):?>
        <span class="rn_Required"> <?=getMessage((1908));?> </span><span class="rn_ScreenReaderOnly"><?=getMessage((7015))?></span>
    <?
endif;?>
    <?
if($this->data['js']['hint'] && !$this->data['attrs']['hide_hint']):?>
        <span class="rn_ScreenReaderOnly">
        <?=$this->data['js']['hint'];?>
        </span>
    <?
endif;?>
    </label>
    <?
endif;?>
    <select id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" <?=tabIndex($this->data['attrs']['tabindex'],
1);?>>
    <?
if(!$this->data['hideEmptyOption']):?>
        <option value="">--</option>
    <? endif;?>
    <?
if(is_array($this->data['menuItems'])):?>
        <? foreach($this->data['menuItems'] as $key => $item): $selected = ((string)$key == $this->data['value']) ? 'selected="selected"' : '';?>
            <option value="<?=$key;?>" <?=$selected;?>><?=$item;?></option>
        <?
endforeach;?>
    <?
endif;?>
    </select>
<?
elseif($this->field->data_type === (3)):?>
    <?if($this->data['attrs']['display_as_checkbox']): $checked = ($this->data['checkedIndex'] === 1) ? "checked='checked'" : '';?>
        <label for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" id="rn_<?=$this->instanceID;?>_Label" class="rn_Label"><?=$this->data['attrs']['label_input'];?>
        <?
if($this->data['attrs']['required']):?>
            <span class="rn_Required"> <?=getMessage((1908));?> </span><span class="rn_ScreenReaderOnly"><?=getMessage((7015))?></span>
        <?
endif;?>
        <?
if($this->data['js']['hint'] && !$this->data['attrs']['hide_hint']):?>
            <span class="rn_ScreenReaderOnly">
            <?=$this->data['js']['hint'];?>
            </span>
        <?
endif;?>
        </label>
        <input type="checkbox" id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" <?=$checked;?> value="1"/>
    <?else:?>
        <fieldset>
        <?
if($this->data['attrs']['label_input']):?>
            <legend id="rn_<?=$this->instanceID;?>_Label" class="rn_Label"><?=$this->data['attrs']['label_input'];?><?
if($this->data['attrs']['required']):?><span class="rn_Required"> <?=getMessage((1908));?> </span><span class="rn_ScreenReaderOnly"><?=getMessage((7015))?></span><?
endif;?></legend>
        <?
endif;?>
        <?
for($i = 1;
$i >= 0;
$i--): $checked = ($i === $this->data['checkedIndex']) ? 'checked="checked"' : '';
$id = "rn_{$this->instanceID}_{$this->data['js']['name']}_$i";
?>
            <input type="radio" name="rn_<?=$this->instanceID;?>_Radio" id="<?=$id;?>" <?=$checked;?> value="<?=$i;?>"/>
            <label for="<?=$id;?>"><?=$this->data['radioLabel'][$i];?><?
if($this->data['js']['hint'] && !$this->data['attrs']['hide_hint'] && $i===1):?> <span class="rn_ScreenReaderOnly"><?=$this->data['js']['hint']?></span><?endif;?></label>
        <?
endfor;?>
        </fieldset>
    <?endif;?>
<?
endif;?>
</div>
<?
endif;?>
</div>
