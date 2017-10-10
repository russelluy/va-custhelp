<rn:meta controller_path="custom/input/MenuAsRadioWidget" 
    js_path="custom/input/MenuAsRadioWidget" 
    base_css="standard/input/SelectionInput" 
    presentation_css="widgetCss/SelectionInput.css" 
    compatibility_set="November '09+"
    required_js_module="november_09,mobile_may_10"/>


<?
if(isLoggedIn())
    $this->data['readOnly'] = false;

?>

<? if($this->data['readOnly']):?>
    <rn:widget path="output/FieldDisplay" left_justify="true"/>
<? else:?>

<?
if($this->data['attrs']['checkbox'])
    $class = "rn_SelectionInput_chk";
else if($this->data['attrs']['checkbox2'])
    $class = "rn_SelectionInput_2";
else if($this->data['attrs']['radio'])
    $class = "rn_SelectionInput_radio";
else
    $class = "rn_SelectionInput";
?>

    <?if($this->data['attrs']['checkbox'] || $this->data['attrs']['checkbox2']):?>
        <div id="rn_<?=$this->instanceID;?>" class="<?=$class?>">
    <?else: ?>
        <div id="rn_<?=$this->instanceID;?>" class="<?=$class?> <? if(!$this->data['attrs']['always_show']): echo('rn_Hidden'); endif;?>" style="width:355px;">
    <?endif;?>
<? if($this->field->data_type === EUF_DT_SELECT || $this->field->data_type === EUF_DT_CHECK):?>
    <? if($this->data['attrs']['label_input']):?>
    <label style="width:150px;" for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" id="rn_<?=$this->instanceID;?>_Label" class="fldLabel">
        <? $this->data['attrs']['lbl'] ? print($this->data['attrs']['lbl']) : print($this->data['attrs']['label_input'])?>:
    <? if($this->data['attrs']['required']):?>
        <span class="rn_Required"> <?=getMessage(FIELD_REQUIRED_MARK_LBL);?> </span><span class="rn_ScreenReaderOnly"><?=getMessage(REQUIRED_LBL)?></span>
    <? endif;?>
    <? if($this->data['js']['hint']):?>
        <span class="rn_ScreenReaderOnly">
        <?=$this->data['js']['hint'];?>
        </span>
    <? endif;?>
    </label>
    <? endif;?>
    <? //handle radio display ?>
    <? if($this->data['attrs']['radio']): ?>
        <? if(is_array($this->data['menuItems'])):?>
           <div style="vertical-align:middle;padding-top:5px;">
                <input type="hidden" id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" />
            <? foreach($this->data['menuItems'] as $key => $item): ?>
            
                <? if($key == $this->data['value']):?>
                <input type="radio" id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>_<?=$key?>" name="rn_<?=$this->instanceID;?>_Radio" value="<?=$key;?>" checked="checked" />
                <? else: ?>
                <input type="radio" id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>_<?=$key?>" name="rn_<?=$this->instanceID;?>_Radio" value="<?=$key;?>" />
                <? endif; ?> 

                <label for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>_<?=$key?>"><?=$item?></label><br/>
            <? endforeach;?>
            </div>
        <? endif;?>
    <? else: ?>
    <select id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" <?=tabIndex($this->data['attrs']['tabindex'], 1);?>>
    <? if(!$this->data['hideEmptyOption']):?>
        <option value="">--</option>
    <? endif;?>
    <? if(is_array($this->data['menuItems'])):?>
        <? foreach($this->data['menuItems'] as $key => $item):
             $selected = '';
             if($key==$this->data['value']) $selected = 'selected="selected"';?>
            <option value="<?=$key;?>" <?=$selected;?>><?=$item;?></option>
        <? endforeach;?>
    <? endif;?>
    <?endif; ?>
    </select>

<? elseif($this->field->data_type === EUF_DT_RADIO):?>
    <fieldset>
    <? if($this->data['attrs']['label_input'] && !$this->data['attrs']['checkbox'] && !$this->data['attrs']['checkbox2']):?>
        <legend id="rn_<?=$this->instanceID;?>_Label" class="rn_Label"><?=$this->data['attrs']['label_input'];?><? if($this->data['attrs']['required']):?><span class="rn_Required"> <?=getMessage(FIELD_REQUIRED_MARK_LBL);?> </span><span class="rn_ScreenReaderOnly"><?=getMessage(REQUIRED_LBL)?></span><? endif;?></legend>
    <? endif;?>
    <? for($i = 1; $i >= 0; $i--):
        
        $checked = ($i === $this->data['checkedIndex']) ? 'checked="checked"' : '';
        $id = "rn_{$this->instanceID}_{$this->data['js']['name']}_$i"; 

    ?>

    <?if($i === 1): ?>
        <? //handle checkbox display ?>
        <? if($this->data['attrs']['checkbox'] || $this->data['attrs']['checkbox2']): ?>
            <input type="checkbox" name="rn_<?=$this->instanceID;?>_Radio" id="<?=$id;?>" <?=$checked;?> value="<?=$i;?>"/>
            <label for="<?=$id;?>"><? $this->data['attrs']['lbl'] ? print($this->data['attrs']['lbl']) : print($this->data['radioLabel'][$i])?>
        <? if($this->data['js']['hint'] && $i===1):?> 
            <span class="rn_ScreenReaderOnly"><?=$this->data['js']['hint']?></span><?endif;?></label>
        <? else: ?>
            <input type="radio" name="rn_<?=$this->instanceID;?>_Radio" id="<?=$id;?>" <?=$checked;?> value="<?=$i;?>"/>
            <label for="<?=$id;?>"><?=$this->data['radioLabel'][$i];?><? if($this->data['js']['hint'] && $i===1):?> <span class="rn_ScreenReaderOnly"><?=$this->data['js']['hint']?></span><?endif;?></label><br/>
        <? endif; ?>
    <? endif; ?>
    <? endfor;?>
    </fieldset>
<? endif;?>
</div>

<? endif;?>

