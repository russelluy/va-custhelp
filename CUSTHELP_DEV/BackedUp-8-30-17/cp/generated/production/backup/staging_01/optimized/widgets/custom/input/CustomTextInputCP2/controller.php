<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
if(!class_exists('FormInput')) requireWidgetController('standard/input/FormInput');
class CustomTextInput extends FormInput {
function __construct() {
parent::__construct();
$this->attrs['always_show_mask'] = new Attribute(getMessage((975)), 'BOOL', getMessage((3601)), false);
$this->attrs['always_show'] = new Attribute("always show field", 'BOOL', "always show the field", false);
$this->attrs['require_validation'] = new Attribute(getMessage((3408)), 'BOOL', sprintf(getMessage((3818)), 'password_verify'), false);
$this->attrs['label_validation_incorrect'] = new Attribute(getMessage((2526)), 'STRING', getMessage((1783)), getMessage((1671)));
$this->attrs['label_validation'] = new Attribute(getMessage((2527)), 'STRING', getMessage((2406)), getMessage((3358)));
$this->attrs['hide_hint'] = new Attribute(getMessage((2074)), 'BOOL', getMessage((3749)), false);
$this->attrs['maximum_length'] = new Attribute(getMessage((2664)), 'INT', getMessage((3420)), 0);
$this->attrs['maximum_length']->min = 0;
$this->attrs['minimum_length'] = new Attribute(getMessage((2714)), 'INT', getMessage((3421)), 0);
$this->attrs['minimum_length']->min = 0;
$this->attrs['disable_password_autocomplete'] = new Attribute(getMessage((1613)), 'BOOL', getMessage((3245)), false);
$this->attrs['display_value'] = new Attribute("display value", 'STRING', "value to compare", "");
$this->attrs['hideon_notequal_value'] = new Attribute("hide when not equal value", 'STRING', "value to compare for hidding", "");
$this->attrs['hideon_value'] = new Attribute("hide when equal value", 'STRING', "value to compare for hidding", "");
}
function generateWidgetInformation() {
parent::generateWidgetInformation();
$this->info['notes'] = getMessage((4197));
}
function getData() {
if(parent::retrieveAndInitializeData() === false) return false;
if($this->field->data_type !== (7) && $this->field->data_type !== (10) && $this->field->data_type !== (6) && $this->field->data_type !== (8) && $this->field->data_type !== (5)) {
echo $this->reportError(sprintf(getMessage((3076)), $this->fieldName));
return false;
}
if($this->data['js']['mask'] && $this->data['value']) $this->data['value'] = $this->_addMask($this->data['value'], $this->data['js']['mask']);
if($this->data['attrs']['maximum_length'] > 0){
$this->data['maxLength'] = ($this->data['maxLength'] > 0) ? min($this->data['maxLength'], $this->data['attrs']['maximum_length']) : $this->data['attrs']['maximum_length'];
$this->data['js']['fieldSize'] = $this->data['maxLength'];
}
if($this->data['attrs']['minimum_length'] > 0){
if($this->data['maxLength'] > 0 && ($this->data['attrs']['minimum_length'] > $this->data['maxLength'])){
echo $this->reportError(sprintf(getMessage((1983)), $this->fieldName, $this->data['attrs']['minimum_length'], $this->data['maxLength']));
return false;
}
$this->data['attrs']['required'] = true;
}
if(!($this->field instanceof CustomField)) {
if($this->field->data_type === (7)) {
if(!getConfig((193))) return false;
redirectIfPageNeedsToBeSecure();
$this->data['value'] = '';
$field = $this->field;
$passwordValidations = $field::$validations;
$this->data['js']['passwordLength'] = $passwordValidations['length']['count'];
if($this->data['js']['passwordLength'] > 0 && !in_array($this->fieldName, array('password', 'organization_password'), true)) $this->data['attrs']['required'] = true;
if ($this->fieldName === 'password_new') {
$validationsToPerform = array();
foreach ($passwordValidations as $name => $validation) {
if (!$validation['count'] || $name === 'old' || (($name === 'repetitions' || $name === 'occurrences') && $validation['count'] > $this->data['js']['passwordLength'])) continue;
$validationsToPerform[$name] = $validation;
}
if ($validationsToPerform) {
$this->data['js']['passwordValidations'] = $validationsToPerform;
}
}
}
if(($this->fieldName === 'alt_first_name' || $this->fieldName === 'alt_last_name') && LANG_DIR !== 'ja_JP') {
echo $this->reportError(getMessage((968)));
return false;
}
if($this->fieldName === 'email' && !$this->field->value && $this->CI->session->getSessionData('previouslySeenEmail')) $this->data['value'] = $this->CI->session->getSessionData('previouslySeenEmail');
}
$this->data['js']['contactToken'] = createToken(1);
}
private static function _addMask($value, $mask) {
$j = 0;
$result = '';
for($i = 0;
$i < strlen($mask);
$i+=2) {
while($mask[$i] === 'F') {
$result .= $mask[$i + 1];
$i+=2;
}
$result .= $value[$j];
$j++;
}
return $result;
}
}
