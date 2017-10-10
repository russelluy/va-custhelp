<?php
namespace Custom\Controllers;

use RightNow\Api,
	RightNow\Connect\v1_2 as Connect;

class jsptest extends \RightNow\Controllers\Base
{
    //This is the constructor for the custom controller. Do not modify anything within
    //this function.
    function __construct()
    {
        parent::__construct();
    }

    function test1()
    {
        echo <<<EOF
<script>        
function addRow() {
    var div = document.createElement("div");
     var isPositive= document.getElementById("radio1").checked
    var text = getSelectedText('products');     
    if (isPositive) {
        myexperience= 'Positive Experience';
      } else {
        myexperience= 'Negative Experience';
    }
    div.className = "row";
        
    div.innerHTML =myexperience  + '   with    ' + text +'     <a href="#" onclick="removeRow(this)">remove</a>';
        
     document.getElementById("content").appendChild(div);
}
function getSelectedText(elementId) {
    var elt = document.getElementById(elementId);

    if (elt.selectedIndex == -1)
        return "";

    return elt.options[elt.selectedIndex].text;
}

function removeRow(input) {
    document.getElementById("content").removeChild( input.parentNode );
}
 </script>
EOF;
 echo '\n<div id="content"> I had a ... </div>';
            $result = Connect\ROQL::query("select Id, Name from ServiceProduct s where parent=28 " )->next();
           echo <<<EOF
           <br>
<br>
<input type="radio" name="radio1" id="radio1" value="P">Positive Experience
<br>
<input type="radio" name="radio1" id="radio2" value="N">Negative Experience
with
EOF;
         echo "<select id=\"products\">"; 
        while($record = $result->next()) {

           
 echo " <option value=\"$record[ID]\">$record[Name]</option>";
	
          }
echo "</select> <br>  <input type=\"button\" value=\"Add a Topic\" onclick=\"addRow()\" /> ";
    }
}
