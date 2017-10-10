<div id="<?= "rn_{$this->instanceID}" ?>" class="<?= $this->classList ?>">
<div id="<?= "rn_{$this->instanceID}_content" ?>" >
    <?  $instanceName = "rn_{$this->instanceID}";
    ?>

I had a .. <br><br>
<div id="<?= "rn_{$this->instanceID}_Topics"?>" ></div>
<rn:block id="preExperienceInput"/>
<div class="rn_IncidentTaskInput_col">
<select id="<?= "rn_{$this->instanceID}_select"?>">

 <option value="P">Positive Experience</option>
 <option value="N">Negative Experience</option>
 </select>
</div>
<rn:block id="postExperienceInput"/>
 <div class="rn_IncidentTaskInput_col">
with </div>
<div class="rn_IncidentTaskInput_col">
<?php 
         
echo "<select id=\"".$instanceName."_products\">";
    foreach($this->data['results'] as $key => $value) {
         
        echo " <option value=\"$value[ID]\">$value[Name]</option>\r\n";

    }
    echo "</select> ";        // echo response


?>
</div>
<div class="rn_IncidentTaskInput_col">
<rn:block id="preButtonInput"/>
<input type="button" id="rn_<?=$this->instanceID?>_TopicButton" value="Add" />
</div>
<rn:block id="postButtonInput"/>
</div>
<br>
</div>