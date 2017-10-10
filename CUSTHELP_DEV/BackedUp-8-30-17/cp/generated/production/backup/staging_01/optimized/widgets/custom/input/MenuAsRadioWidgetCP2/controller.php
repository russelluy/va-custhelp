<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
if(!class_exists('FormInput')) requireWidgetController('standard/input/FormInput');
class MenuAsRadioWidget extends FormInput {
function __construct() {
parent::__construct();
unset($this->attrs['always_show_mask']);
$this->attrs['always_show'] = new Attribute("always show field", 'BOOL', "always show the field", false);
$this->attrs['hide_hint'] = new Attribute(getMessage((2074)), 'BOOL', getMessage((3749)), false);
$this->attrs['display_as_checkbox'] = new Attribute(getMessage((1624)), 'BOOL', getMessage((1180)), false);
}
function generateWidgetInformation() {
$this->info['notes'] = getMessage((4375));
$this->parms['url_parameter'] = new UrlParam(getMessage((4071)), 'parm', true, getMessage((1508)), 'parm/3');
}
function getData() {
if(parent::retrieveAndInitializeData() === false) return false;
if($this->fieldName === 'status' && !getUrlParm('i_id')) {
echo $this->reportError(sprintf(getMessage((3021)), 'incidents.status'));
return false;
}
if($this->field->data_type !== (4) && $this->field->data_type !== (12) && $this->field->data_type !== (3)) {
echo $this->reportError(sprintf(getMessage((3039)), $this->fieldName));
return false;
}
if(!($this->field instanceof CustomField)) {
if(($this->CI->meta['sla_failed_page'] || $this->CI->meta['sla_required_type']) && $this->fieldName === 'sla' && count($this->field->menu_items)) $this->data['hideEmptyOption'] = true;
if($this->field->data_type === (12)) {
$this->data['menuItems'] = array(getMessage((4406)), getMessage((2143)));
$this->data['hideEmptyOption'] = true;
}
}
if($this->field->data_type === (3)) {
$this->data['radioLabel'] = array(getMessage((863)), getMessage((869)));
if(is_null($this->data['value'])) $this->data['checkedIndex'] = -1;
elseif(intval($this->data['value']) === 1) $this->data['checkedIndex'] = 1;
else $this->data['checkedIndex'] = 0;
}
$this->data['showAriaHint'] = $this->CI->clientLoader->getCanUseAria() && $this->data['js']['hint'];
}
}
