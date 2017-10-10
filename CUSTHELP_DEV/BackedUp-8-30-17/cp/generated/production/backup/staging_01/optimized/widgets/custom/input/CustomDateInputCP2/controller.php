<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
if(!class_exists('FormInput')) requireWidgetController('standard/input/FormInput');
class CustomDateInput extends FormInput {
function __construct() {
parent::__construct();
unset($this->attrs['always_show_mask']);
try{
$maxYear = getMaxYear();
}
catch (Exception $e){
echo $this->reportError($e->getMessage());
$maxYear = date('Y');
}
$this->attrs['max_year'] = new Attribute(getMessage((2672)), 'INT', getMessage((2659)), $maxYear);
$this->attrs['max_year']->min = getMinYear();
$this->attrs['max_year']->max = 2100;
$this->attrs['min_year'] = new Attribute(getMessage((2720)), 'INT', getMessage((2719)), getMinYear());
$this->attrs['min_year']->min = getMinYear();
$this->attrs['min_year']->max = 2100;
$this->attrs['hide_hint'] = new Attribute(getMessage((2074)), 'BOOL', getMessage((3749)), false);
$this->attrs['display_value'] = new Attribute("display value", 'STRING', "value to compare", "display value");
$this->attrs['always_show'] = new Attribute("always show field", 'BOOL', "always show the field", false);
}
function generateWidgetInformation() {
parent::generateWidgetInformation();
$this->info['notes'] = getMessage((4195));
}
function getData() {
if(parent::retrieveAndInitializeData() === false) return false;
if($this->field->data_type !== (1) && $this->field->data_type !== (2)) {
echo $this->reportError(sprintf(getMessage((3008)), $this->fieldName));
return false;
}
$minYear = $this->data['minYear'] = $this->data['js']['minYear'] = $this->data['attrs']['min_year'];
$this->data['maxYear'] = $this->data['attrs']['max_year'];
$dateOrder = getConfig((109), 'COMMON');
$this->data['dayLabel'] = getMessage((50), 'COMMON');
$this->data['monthLabel'] = getMessage((54), 'COMMON');
$this->data['yearLabel'] = getMessage((58), 'COMMON');
$this->data['hourLabel'] = getMessage((48), 'COMMON');
$this->data['minuteLabel'] = getMessage((46), 'COMMON');
if ($dateOrder == 0) {
$this->data['monthOrder'] = 0;
$this->data['dayOrder'] = 1;
$this->data['yearOrder'] = 2;
if ($this->field->data_type === (2)) $this->data['js']['min_val'] = "1/2/$minYear 09:00";
else $this->data['js']['min_val'] = "1/2/$minYear";
}
else if ($dateOrder == 1) {
$this->data['monthOrder'] = 1;
$this->data['dayOrder'] = 2;
$this->data['yearOrder'] = 0;
if ($this->field->data_type === (2)) $this->data['js']['min_val'] = sprintf("{$minYear}%s/1%s/2%s 09:00",
$this->data['yearLabel'], $this->data['monthLabel'], $this->data['dayLabel']);
else $this->data['js']['min_val'] = sprintf("{$minYear}%s/1%s/2%s",
$this->data['yearLabel'], $this->data['monthLabel'], $this->data['dayLabel']);
}
else {
$this->data['monthOrder'] = 1;
$this->data['dayOrder'] = 0;
$this->data['yearOrder'] = 2;
if ($this->field->data_type === (2)) $this->data['js']['min_val'] = "2/1/$minYear 09:00";
else $this->data['js']['min_val'] = "2/1/$minYear";
}
if($this->data['value']) {
$this->data['value'] = explode(' ', date('m j Y G i', intval($this->data['value'])));
$this->data['defaultValue'] = true;
}
}
}
