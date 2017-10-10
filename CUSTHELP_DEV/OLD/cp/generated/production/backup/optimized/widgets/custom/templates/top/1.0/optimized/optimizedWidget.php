<? namespace Custom\Widgets\templates;
class top extends \RightNow\Libraries\Widget\Base {
function _custom_templates_top_view ($data) {
extract($data);
?>
<!-- **********************************************************
Last Modified by: Abdul Mohammed on 1/28/2010 for incident 100120-000130
Purpose : To change header of rightnow pages
Changed Made :a)Created a backup of old top.phph file named as top_old.phph.
              b)Removed all javascript code from top.phph .
              c)Copied vxHeader.js file from https://www.virginamerica.com/va/vxscripts/vxHeader.js and placed it on our server(/rnt/rnw/javascript/vxHeader.js)
			  d)Added code to point this new javascript file.
Modification: by Ryan Reichenbach - same incident
              Changed path to reference .js file on customer's server
              Added logic to determine if RNT_SSL is being used and change the protocol on the js reference
***************************************************************-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="ROBOTS" content="(0)">
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
<link rel="stylesheet" href="https://www.virginamerica.com/va/styles/vamain.css" type="text/css" media="screen">
<style>
#privacy-policy{ COLOR: #7b7b7b; TEXT-DECORATION: underline }
#privacy-policy:hover { color: #D20002; text-decoration: none; }
#term-condition{ COLOR: #7b7b7b; TEXT-DECORATION: underline }
#term-condition:hover { color: #D20002; text-decoration: none; }
#cargo-service{ COLOR: #7b7b7b; TEXT-DECORATION: underline }
#cargo-service:hover { color: #D20002; text-decoration: none; }
#site-map{ COLOR: #7b7b7b; TEXT-DECORATION: underline }
#site-map:hover { color: #D20002; text-decoration: none; }
#contact-us{ COLOR: #7b7b7b; TEXT-DECORATION: underline }
#contact-us:hover { color: #D20002; text-decoration: none; }
#about-us{ COLOR: #7b7b7b; TEXT-DECORATION: underline }
#about-us:hover { color: #D20002; text-decoration: none; }
</style>
<link rel="stylesheet" href="https://www.virginamerica.apply2jobs.com/a2j.css" type="text/css" media="screen">
<!-- <script type="text/javascript" src="http://www.virginamerica.com/va/scripts/sarissa.js" ></script> -->
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
function _custom_templates_top_header() {
$result = array( 'js_name' => '', 'library_name' => 'top', 'view_func_name' => '_custom_templates_top_view', 'meta' => array ( 'controller_path' => 'custom/templates/top', 'view_path' => 'custom/templates/top', 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'relativePath' => 'custom/templates/top', 'widget_name' => 'top', ), );
$result['meta']['attributes'] = array( );
return $result;
}
