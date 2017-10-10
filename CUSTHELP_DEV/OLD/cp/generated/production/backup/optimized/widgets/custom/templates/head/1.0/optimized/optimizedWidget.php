<? namespace Custom\Widgets\templates;
class head extends \RightNow\Libraries\Widget\Base {
function _custom_templates_head_view ($data) {
extract($data);
?>
<!-- **********************************************************
Last Modified by: Abdul Mohammed on 1/28/2010 for incident 100120-000130
Purpose : To change header of rightnow pages
Changed Made :a)Created a backup of old head.phph file named as head_old.phph.
              b)Removed all javascript code from head.phph .
***************************************************************-->
<meta name="ROBOTS" content="(0)">
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
<!-- <script type="text/javascript" src="http://www.virginamerica.com/va/images/sarissa.js" ></script> -->
<style>
.footerText {
	COLOR: #9A9A9A 
}
.copyRights {
	font-size: 10px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #666666;
}
A {
	COLOR: #7b7b7b; TEXT-DECORATION: underline
}
A:hover {
	COLOR: #D20002; TEXT-DECORATION: none
}
.overredA{
	color:D20002;
	font-family: Virgin America, Verdana, Arial, Helvetica, sans-serif; 
	font-size: 10px;
	text-decoration:none;
	cursor:default;
}
.overredA:hover{
	color:D20002;
	font-family: Virgin America, Verdana, Arial, Helvetica, sans-serif; 
	font-size: 10px;
	text-decoration:none;
	cursor:default;
}
</style>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
return parent::getData();
}
}
function _custom_templates_head_header() {
$result = array( 'js_name' => '', 'library_name' => 'head', 'view_func_name' => '_custom_templates_head_view', 'meta' => array ( 'controller_path' => 'custom/templates/head', 'view_path' => 'custom/templates/head', 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'relativePath' => 'custom/templates/head', 'widget_name' => 'head', ), );
$result['meta']['attributes'] = array( );
return $result;
}
