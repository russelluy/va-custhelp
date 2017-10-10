<?php /* Originating Release: August 2012 */ ?>


<? if($this->data['readOnly']):?>
<rn:widget path="output/FieldDisplay" left_justify="true"/>
<? else:?>
<?
    $passwordClass = '';
    if($this->data['js']['type'] === EUF_DT_PASSWORD && ($this->data['js']['passwordValidations'] || $this->data['js']['name'] === 'password_verify')):
        $passwordClass = ' rn_PasswordInput';
    endif;
?>

<div id="rn_<?=$this->instanceID;?>" class="rn_TextInput<?=$passwordClass?> <? if(!$this->data['attrs']['always_show']): echo('rn_Hidden'); endif;?>" >
<?
switch($this->data['js']['type']):
case EUF_DT_VARCHAR:
case EUF_DT_INT:
?>
    <? if($this->data['attrs']['label_input']):?>
    <label for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" id="rn_<?=$this->instanceID;?>_Label" class="rn_Label"><?=$this->data['attrs']['label_input'];?>
    <? if($this->data['attrs']['required']):?>
        <span class="rn_Required"> <?=getMessage(FIELD_REQUIRED_MARK_LBL);?> </span><span class="rn_ScreenReaderOnly"><?=getMessage(REQUIRED_LBL)?></span>
    <? endif;?>
    <? if($this->data['js']['hint'] && !$this->data['attrs']['hide_hint']):?>
        <span class="rn_ScreenReaderOnly"> <?=$this->data['js']['hint']?></span>
    <? endif;?>
    </label>
    <? endif;?>
    <input type="text" id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" name="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" class="rn_Text" <?=tabIndex($this->data['attrs']['tabindex'], 1);?> <? if($this->data['maxLength']): echo('maxlength="' . $this->data['maxLength'] . '"'); endif;?> value="<?=$this->data['value'];?>"/>
    <? if($this->data['attrs']['require_validation']):?>
        <div class="rn_TextInputValidate">
        <label for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>_Validate" id="rn_<?=$this->instanceID;?>_LabelValidate" class="rn_Label"><?printf($this->data['attrs']['label_validation'], $this->data['attrs']['label_input']);?>
        <? if($this->data['attrs']['required']):?>
            <span class="rn_Required"> <?=getMessage(FIELD_REQUIRED_MARK_LBL);?> </span><span class="rn_ScreenReaderOnly"><?=getMessage(REQUIRED_LBL)?></span>
        <? endif;?>
        </label>
        <input type="text" id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>_Validate" name="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>_Validate" class="rn_Text" <?=tabIndex($this->data['attrs']['tabindex'], 2);?> <? if($this->data['maxLength']): echo('maxlength="' . $this->data['maxLength'] . '"'); endif;?> value="<?=$this->data['value'];?>"/>
        </div>
   <? endif;?>
<?
break;
case EUF_DT_PASSWORD:
?>
    <? if($this->data['attrs']['label_input']):?>
    <label for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" id="rn_<?=$this->instanceID;?>_Label" class="rn_Label"><?=$this->data['attrs']['label_input'];?>
    <? if($this->data['attrs']['required']):?>
        <span class="rn_Required"> <?=getMessage(FIELD_REQUIRED_MARK_LBL);?> </span><span class="rn_ScreenReaderOnly"><?=getMessage(REQUIRED_LBL)?></span>
    <? endif;?>
    <? if($this->data['js']['hint'] && !$this->data['attrs']['hide_hint']):?>
    <span class="rn_ScreenReaderOnly"> <?=$this->data['js']['hint']?></span>
    <? endif;?>
    </label>
    <? endif;?>
    <input type="password" aria-describedby="rn_<?= $this->instanceID ?>_PasswordOverlay" id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" class="rn_Password" <?=tabIndex($this->data['attrs']['tabindex'], 1);?> <?=($this->data['attrs']['disable_password_autocomplete']) ? 'autocomplete="off"' : '' ?> <? if($this->data['maxLength']): echo('maxlength="' . $this->data['maxLength'] . '"'); endif;?>/>
    <? if ($this->data['js']['name'] === 'password_verify'): ?>
        <div class="rn_PasswordOverlay rn_ScreenReaderOnly" id="rn_<?= $this->instanceID ?>_PasswordOverlay"><? printf(getMessage(MUST_MATCH_PCT_S_MSG), getMessage(PASSWD_LBL)) ?></div>    
    <? else: ?>
    <div class="rn_PasswordOverlay rn_Hidden" id="rn_<?= $this->instanceID ?>_PasswordOverlay" aria-live="polite">
    <? if ($this->data['js']['passwordValidations']): ?>
        <div class="rn_Heading">
            <div class="rn_Intro" aria-describedby="rn_<?= $this->instanceID ?>_Requirements">
                <div class="rn_Title"><?= getMessage(PASSWORD_HELP_LBL) ?></div>
                <span class="rn_ScreenReaderOnly">
                    <?= getMessage(PASSWD_VALIDATION_REQS_READ_L_MSG) ?>
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
                    case 'uppercase':
                        $message = array(
                            getMessage(CONTAIN_PCT_D_UPPER_CHARACTER_MSG),
                            getMessage(CONTAIN_PCT_D_UPPER_CHARACTERS_MSG),
                        );
                        break;
                    case 'lowercase':
                        $message = array(
                            getMessage(CONTAIN_PCT_D_LOWER_CHARACTER_MSG),
                            getMessage(CONTAIN_PCT_D_LOWER_CHARACTERS_MSG),
                        );
                        break;
                    case 'length':
                        $message = array(
                            getMessage(MUST_BE_LEAST_PCT_D_CHARACTER_MSG),
                            getMessage(MUST_BE_LEAST_PCT_D_CHARACTERS_MSG),
                        );
                        break;
                    case 'special':
                        $message = array(
                            getMessage(CONTAIN_PCT_D_SPECIAL_CHARACTER_MSG),
                            getMessage(CONTAIN_PCT_D_SPECIAL_CHARACTERS_MSG),
                        );
                        break;
                    case 'specialAndDigits':
                        $message = array(
                            getMessage(CONTAIN_PCT_D_MSG),
                            getMessage(CONT_PCT_D_MSG),
                        );
                        break;
                    case 'occurrences':
                        $message = array(
                            getMessage(CONTAIN_PCT_D_REPEATED_CHARACTER_LBL),
                            getMessage(CONTAIN_PCT_D_REPEATED_CHARACTERS_LBL),
                        );
                        break;
                    case 'repetitions':
                        $message = array(
                            getMessage(CHARACTER_CANNOT_BE_REPEATED_ROW_MSG),
                            getMessage(CONTAIN_PCT_D_REPEATED_CHARS_ROW_LBL),
                        );
                        break;
                    default:
                        $message = null;
                        break;
                } ?>
            <li data-validate="<?= $type ?>">
                <span class="rn_ScreenReaderOnly"></span>
                <? printf(($validation['count'] === 1) ? $message[0] : $message[1], $validation['count']) ?>
            </li>
        <? endforeach; ?>
        </ul>
    <? endif; ?>
    </div>
    <? endif; ?>
<?
break;
default:
?>
    <? if($this->data['attrs']['label_input']):?>
    <label for="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" id="rn_<?=$this->instanceID;?>_Label" class="rn_Label"><?=$this->data['attrs']['label_input'];?>
    <? if($this->data['attrs']['required']):?>
        <span class="rn_Required"> <?=getMessage(FIELD_REQUIRED_MARK_LBL);?> </span><span class="rn_ScreenReaderOnly"><?=getMessage(REQUIRED_LBL)?></span>
    <? endif;?>
    <? if($this->data['js']['hint'] && !$this->data['attrs']['hide_hint']):?>
    <span class="rn_ScreenReaderOnly"> <?=$this->data['js']['hint']?></span>
    <? endif;?>
    </label>
    <? endif;?>
    <textarea id="rn_<?=$this->instanceID;?>_<?=$this->data['js']['name'];?>" class="rn_TextArea" rows="7" cols="60" <?=tabIndex($this->data['attrs']['tabindex'], 1);?> <? if($this->data['maxLength']): echo('maxlength="' . $this->data['maxLength'] . '"'); endif;?>><?=$this->data['value'];?></textarea>
<?
break;
endswitch;
?>
</div>

<? endif;?>

