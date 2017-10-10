<? namespace Custom\Widgets\templates;
class bottom extends \RightNow\Libraries\Widget\Base {
function _custom_templates_bottom_view ($data) {
extract($data);
?>
<!-- **********************************************************
Last Modified by: Abdul Mohammed on 1/28/2010 for incident 100120-000130
Purpose : To change footer of rightnow pages
Changed Made :a)Created a backup of old bottom.phph file named as bottom_old.phph.
              b)Removed all javascript code from bottom.phph .
              c)Copied vxFooter.js file from https://www.virginamerica.com/va/vxscripts/vxFooter.js and placed it on our server(/rnt/rnw/javascript/vxFooter.js)
			  d)Added code to point this new javascript file.
Modified: by Ryan Reichenbach - same incident
          Changed path to reference .js file on customer's server
          Added logic to determine if RNT_SSL is being used and change the protocol on the js reference
***************************************************************-->
<? $proto = (strtoupper($_SERVER['RNT_SSL']) == 'YES') ? "https" : "http";
?>
<script<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
return parent::getData();
}
}
function _custom_templates_bottom_header() {
$result = array( 'js_name' => '', 'library_name' => 'bottom', 'view_func_name' => '_custom_templates_bottom_view', 'meta' => array ( 'controller_path' => 'custom/templates/bottom', 'view_path' => 'custom/templates/bottom', 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'relativePath' => 'custom/templates/bottom', 'widget_name' => 'bottom', ), );
$result['meta']['attributes'] = array( );
return $result;
}
