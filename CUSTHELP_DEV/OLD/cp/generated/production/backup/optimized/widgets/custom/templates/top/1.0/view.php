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
<META NAME="ROBOTS" CONTENT="(0)">
<META NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW">
<link rel="stylesheet" href="https://www.virginamerica.com/va/styles/vamain.css" TYPE="text/css" MEDIA="screen">
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
<link rel="stylesheet" href="https://www.virginamerica.apply2jobs.com/a2j.css" TYPE="text/css" MEDIA="screen">
<!-- <script type="text/javascript" src="http://www.virginamerica.com/va/scripts/sarissa.js" ></script> -->
<? $proto = (strtoupper($_SERVER['RNT_SSL']) == 'YES') ? "https" : "http";
?>
<script type="text/javascript" src="<?=$proto;?>://www.virginamerica.com/va/vxscripts/vxHeader.js" language="javascript"></script>
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
</head>
<body>
