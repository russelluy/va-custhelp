<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class head extends Widget {
function __construct() {
parent::__construct();
$this->attrs['attribute'] = new Attribute(getMessage((1044)), 'String', getMessage((1043)), getMessage((1042)));
}
function generateWidgetInformation() {
$this->info['notes'] = getMessage((4375));
$this->parms['url_parameter'] = new UrlParam(getMessage((4071)), 'parm', true, getMessage((1508)), 'parm/3');
}
function getData() {
}
}
