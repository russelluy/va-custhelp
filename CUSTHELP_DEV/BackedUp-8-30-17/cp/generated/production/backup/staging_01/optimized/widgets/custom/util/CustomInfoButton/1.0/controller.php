<?php
namespace Custom\Widgets\util;
class CustomInfoButton extends \RightNow\Libraries\Widget\Base {
function __construct($attrs) {
parent::__construct($attrs);
}
function generateWidgetInformation() {
$this->info['notes'] = getMessage((4253));
}
function getData() {
if($this->CI->agent->browser() === 'Internet Explorer') $this->data['isIE'] = true;
}
}
