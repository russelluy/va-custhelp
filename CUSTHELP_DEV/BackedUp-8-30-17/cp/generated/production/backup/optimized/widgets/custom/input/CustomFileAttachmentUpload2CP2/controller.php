<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class CustomFileAttachmentUpload2 extends Widget {
function __construct() {
parent::__construct();
$this->attrs['label_input'] = new Attribute(getMessage((2221)), 'STRING', getMessage((2362)), getMessage((4480)));
$this->attrs['label_error'] = new Attribute(getMessage((1798)), 'STRING', sprintf(getMessage((3025)), 'label_input'), '');
$this->attrs['label_remove'] = new Attribute(getMessage((3371)), 'STRING', getMessage((2368)), getMessage((6896)));
$this->attrs['always_show'] = new Attribute("always show field", 'BOOL', "always show the field", false);
$this->attrs['max_attachments'] = new Attribute(getMessage((2662)), 'INT', getMessage((3741)), 0);
$this->attrs['label_max_attachment_limit'] = new Attribute(getMessage((2655)), 'STRING', getMessage((1788)), getMessage((3336)));
$this->attrs['label_generic_error'] = new Attribute(getMessage((2029)), 'STRING', getMessage((2028)), getMessage((1941)));
$this->attrs['loading_icon_path'] = new Attribute(getMessage((2578)), 'STRING', getMessage((1935)), 'images/indicator.gif');
$this->attrs['min_required_attachments'] = new Attribute(getMessage((2717)), 'INT', getMessage((2716)), 0);
$this->attrs['label_min_required'] = new Attribute(getMessage((2718)), 'STRING', getMessage((1787)), getMessage((18887)));
$this->attrs['valid_file_extensions'] = new Attribute(getMessage((4113)), 'STRING', getMessage((2529)), '');
$this->attrs['label_invalid_extension'] = new Attribute(getMessage((2467)), 'STRING', sprintf(getMessage((2468)), 'valid_file_extensions'), getMessage((2004)));
$this->attrs['display_value'] = new Attribute("display value", 'STRING', "value to compare", "display value");
}
function generateWidgetInformation() {
$this->info['notes'] = getMessage((4226));
$this->parms['i_id'] = new UrlParam(getMessage((10071)), 'i_id', false, getMessage((2167)), 'i_id/7');
}
function getData() {
$incidentID = getUrlParm('i_id');
if($incidentID) {
$this->CI->load->model('standard/Incident_model');
$this->data['js']['attachmentCount'] = $this->CI->Incident_model->getFileAttachmentCount($incidentID);
}
if($this->data['attrs']['max_attachments'] !== 0 && $this->data['attrs']['min_required_attachments'] > $this->data['attrs']['max_attachments']) {
echo $this->reportError(sprintf(getMessage((3050)), 'min_required_attachments', 'max_attachments'));
return false;
}
}
}
