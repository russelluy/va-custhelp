<?php /* Originating Release: May 2016 */?>
<rn:block id="top"/>
<? switch ($this->dataType):
    case 'Menu':
    case 'Boolean':
    case 'Country':
    case 'NamedIDLabel':
    case 'NamedIDOptList':
    case 'Status':
    case 'Asset':
    case 'AssignedSLAInstance':?>
        <rn:widget path="input/SelectionInput" sub_id="selection"/>
        <? break;
    case 'Date':
    case 'DateTime':?>
        <rn:widget path="input/DateInput" sub_id="date"/>
        <? break;
    default: ?>
        <? if ($this->fieldName === 'NewPassword'): ?>
            <rn:widget path="input/PasswordInput" sub_id="password"/>
        <? else: ?>
            <rn:widget path="input/TextInput" sub_id="text"/>
        <? endif; ?>
        <? break;
endswitch;?>
<rn:block id="bottom"/>
