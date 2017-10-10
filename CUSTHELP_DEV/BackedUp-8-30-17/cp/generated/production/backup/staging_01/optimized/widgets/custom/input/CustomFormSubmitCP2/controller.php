<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class CustomFormSubmit extends Widget {
function __construct() {
parent::__construct();
$this->attrs['label_button'] = new Attribute(getMessage((1104)), 'STRING', getMessage((2512)), getMessage((4550)));
$this->attrs['label_confirm_dialog'] = new Attribute(getMessage((1326)), 'STRING', getMessage((2761)), '');
$this->attrs['on_success_url'] = new Attribute(getMessage((2871)), 'STRING', getMessage((4080)), '');
$this->attrs['loading_icon_path'] = new Attribute(getMessage((2578)), 'STRING', getMessage((1935)), 'images/indicator.gif');
$this->attrs['error_location'] = new Attribute(getMessage((1800)), 'STRING', getMessage((4022)), '');
$this->attrs['add_params_to_url'] = new Attribute(getMessage((926)), 'STRING', sprintf(getMessage((1221)), 'on_success_url'), '');
$this->attrs['challenge_location'] = new Attribute(getMessage((1131)), 'STRING', getMessage((4034)), '');
$this->attrs['challenge_required'] = new Attribute(getMessage((1132)), 'BOOL', getMessage((2193)), false);
$this->attrs['display_value'] = new Attribute("display value", 'STRING', "value to compare", "display value");
$this->attrs['always_show'] = new Attribute("always show field", 'BOOL', "always show the field", false);
$this->attrs['hideon_value'] = new Attribute("hide when value equals", 'STRING', "value to compare for hidding", "");
}
function generateWidgetInformation() {
$this->info['notes'] = getMessage((4186));
}
function getData() {
$this->data['js'] = array( 'f_tok' => cpCreateTokenExp(0, $this->data['attrs']['challenge_required']), 'formExpiration' => (60000 * (getConfig((204)) - 5)) );
if ($this->data['attrs']['challenge_required'] && $this->data['attrs']['challenge_location']) {
$this->data['js']['challengeProvider'] = AbuseDetection::getChallengeProvider();
}
$this->data['attrs']['on_success_url'] .= getUrlParametersFromList($this->data['attrs']['add_params_to_url']);
if(getUrlParmString('redirect')) {
$redirectLocation = urldecode(urldecode(getUrlParm('redirect')));
$parsedURL = parse_url($redirectLocation);
if($parsedURL['scheme'] || (beginsWith($parsedURL['path'], '/ci/') || beginsWith($parsedURL['path'], '/cc/'))) {
$this->data['attrs']['on_success_url'] = $redirectLocation;
}
else {
$this->data['attrs']['on_success_url'] = beginsWith($redirectLocation, '/app/') ? $redirectLocation : "/app/$redirectLocation";
}
}
}
}
