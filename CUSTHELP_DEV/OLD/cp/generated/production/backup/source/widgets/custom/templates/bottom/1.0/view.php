

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
<?
$proto = (strtoupper($_SERVER['RNT_SSL']) == 'YES') ? "https" : "http";
?>
<script type="text/javascript" src="<?=$proto;?>://www.virginamerica.com/va/vxscripts/vxFooter.js" language="javascript"></script> 
<!---<script type="text/javascript" src="/rnt/rnw/javascript/vxFooter.js" language="javascript"></script>--->
<style>
#ContainerFooter {
    border-top: none;
}
#footerCopyright { 
    white-space:nowrap; 
}
table {
    border-collapse: inherit;
    border-spacing: 0px;
}

</style>
</body>
</html>


