<?php  ?>
<rn:meta controller_path="custom/input/CustomTextInput" 
    js_path="custom/input/CustomTextInput" 
    base_css="standard/input/CustomTextInput" 
    presentation_css="widgetCss/TextInput.css" 
    compatibility_set="November '09+"
    required_js_module="november_09,mobile_may_10"/>

<? if($this->data['readOnly']):?>
<rn:widget path="output/FieldDisplay" left_justify="true"/>
<? else:?>
<? $passwordClass = '';
if($this->data['js']['type'] === (7) && ($this->data['js']['passwordValidations'] || $this->data['js']['name'] === 'password_verify')): $passwordClass = ' rn_PasswordInput';
endif;
?>

<div id="rn_<?=$this->instanceID;?>" class="rn_TextInput<?=$passwordClass?> <?
if(!$this->data['attrs']['always_show']): echo('rn_Hidden');
endif;?>" >
<?
switch($this->data['js']['type']): case (8): case (5): ?>
    <? if($this->data['attrs']['label_input']):?>
    <label for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" id="rn_<?=$this->instanceID;?>_Label" class="rn_Label"><?=$this->data['attrs']['label_input'];?>
    <?
if($this->data['attrs']['required']):?>
        <span class="rn_Required"> <?=getMessage((1908));?> </span><span class="rn_ScreenReaderOnly"><?=getMessage((7015))?></span>
    <?
endif;?>
    <?
if($this->data['js']['hint'] && !$this->data['attrs']['hide_hint']):?>
        <span class="rn_ScreenReaderOnly"> <?=$this->data['js']['hint']?></span>
    <? endif;?>
    </label>
    <?
endif;?>
    <input type="text" id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" name="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" class="rn_Text" <?=tabIndex($this->data['attrs']['tabindex'],
1);?> <?
if($this->data['maxLength']): echo('maxlength="' . $this->data['maxLength'] . '"');
endif;?> value="<?=$this->data['value'];?>"/>
    <?
if($this->data['attrs']['require_validation']):?>
        <div class="rn_TextInputValidate">
        <label for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>_Validate" id="rn_<?=$this->instanceID;?>_LabelValidate" class="rn_Label"><?printf($this->data['attrs']['label_validation'],
$this->data['attrs']['label_input']);?>
        <?
if($this->data['attrs']['required']):?>
            <span class="rn_Required"> <?=getMessage((1908));?> </span><span class="rn_ScreenReaderOnly"><?=getMessage((7015))?></span>
        <?
endif;?>
        </label>
        <input type="text" id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>_Validate" name="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>_Validate" class="rn_Text" <?=tabIndex($this->data['attrs']['tabindex'],
2);?> <?
if($this->data['maxLength']): echo('maxlength="' . $this->data['maxLength'] . '"');
endif;?> value="<?=$this->data['value'];?>"/>
        </div>
   <?
endif;?>
<?
break;
case (7): ?>
    <? if($this->data['attrs']['label_input']):?>
    <label for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" id="rn_<?=$this->instanceID;?>_Label" class="rn_Label"><?=$this->data['attrs']['label_input'];?>
    <?
if($this->data['attrs']['required']):?>
        <span class="rn_Required"> <?=getMessage((1908));?> </span><span class="rn_ScreenReaderOnly"><?=getMessage((7015))?></span>
    <?
endif;?>
    <?
if($this->data['js']['hint'] && !$this->data['attrs']['hide_hint']):?>
    <span class="rn_ScreenReaderOnly"> <?=$this->data['js']['hint']?></span>
    <? endif;?>
    </label>
    <?
endif;?>
    <input type="password" aria-describedby="rn_<?=
$this->instanceID ?>_PasswordOverlay" id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" class="rn_Password" <?=tabIndex($this->data['attrs']['tabindex'],
1);?> <?=($this->data['attrs']['disable_password_autocomplete'])
? 'autocomplete="off"' : '' ?> <? if($this->data['maxLength']): echo('maxlength="' . $this->data['maxLength'] . '"');
endif;?>/>
    <?
if ($this->data['js']['name'] === 'password_verify'): ?>
        <div class="rn_PasswordOverlay rn_ScreenReaderOnly" id="rn_<?= $this->instanceID ?>_PasswordOverlay"><? printf(getMessage((40498)), getMessage((4842))) ?></div>    
    <? else: ?>
    <div class="rn_PasswordOverlay rn_Hidden" id="rn_<?= $this->instanceID ?>_PasswordOverlay" aria-live="polite">
    <? if ($this->data['js']['passwordValidations']): ?>
        <div class="rn_Heading">
            <div class="rn_Intro" aria-describedby="rn_<?= $this->instanceID ?>_Requirements">
                <div class="rn_Title"><?= getMessage((40561)) ?></div>
                <span class="rn_ScreenReaderOnly">
                    <?= getMessage((40556)) ?>
                </span>
            </div>
            <div class="rn_Strength rn_Hidden">
                <div class="rn_Meter" aria-describedby="rn_<?= $this->instanceID ?>_MeterLabel"></div>
                <label id="rn_<?= $this->instanceID ?>_MeterLabel"></label>
            </div>
        </div>
        <ul class="rn_Requirements" aria-live="assertive" aria-atomic="true" id="rn_<?= $this->instanceID ?>_Requirements">
            <? foreach ($this->data['js']['passwordValidations'] as $type => $validation): ?>
                <? switch ($type) {
case 'uppercase': $message = array( getMessage((40342)), getMessage((40343)), );
break;
case 'lowercase': $message = array( getMessage((40334)), getMessage((40335)), );
break;
case 'length': $message = array( getMessage((40496)), getMessage((40497)), );
break;
case 'special': $message = array( getMessage((40340)), getMessage((40341)), );
break;
case 'specialAndDigits': $message = array( getMessage((40336)), getMessage((40346)), );
break;
case 'occurrences': $message = array( getMessage((40337)), getMessage((40338)), );
break;
case 'repetitions': $message = array( getMessage((40312)), getMessage((40339)), );
break;
default: $message = null;
break;
}
?>
            <li data-validate="<?= $type ?>">
                <span class="rn_ScreenReaderOnly"></span>
                <? printf(($validation['count'] === 1) ? $message[0] : $message[1], $validation['count']) ?>
            </li>
        <? endforeach;
?>
        </ul>
    <? endif;
?>
    </div>
    <? endif;
?>
<? break;
default: ?>
    <? if($this->data['attrs']['label_input']):?>
    <label for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" id="rn_<?=$this->instanceID;?>_Label" class="rn_Label"><?=$this->data['attrs']['label_input'];?>
    <?
if($this->data['attrs']['required']):?>
        <span class="rn_Required"> <?=getMessage((1908));?> </span><span class="rn_ScreenReaderOnly"><?=getMessage((7015))?></span>
    <?
endif;?>
    <?
if($this->data['js']['hint'] && !$this->data['attrs']['hide_hint']):?>
    <span class="rn_ScreenReaderOnly"> <?=$this->data['js']['hint']?></span>
    <? endif;?>
    </label>
    <?
endif;?>
    <textarea id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" class="rn_TextArea" rows="7" cols="60" <?=tabIndex($this->data['attrs']['tabindex'],
1);?> <?
if($this->data['maxLength']): echo('maxlength="' . $this->data['maxLength'] . '"');
endif;?>><?=$this->data['value'];?></textarea>
<?
break;
endswitch;
?>
</div>

<? endif;?>

