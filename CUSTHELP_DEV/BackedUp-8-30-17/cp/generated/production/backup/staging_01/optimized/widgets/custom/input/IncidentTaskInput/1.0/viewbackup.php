<div id="<?= "rn_{$this->instanceID}"
?>" class="<?= $this->classList ?>">
<div id="<?= "rn_{$this->instanceID}_content"
?>" class="rn_label" >
    <? $instanceName = "rn_{$this->instanceID}";
?>
    <br>
I had a .. <br><br>
<div id="<?= "rn_{$this->instanceID}_Topics"?>" class="rn_IncidentTaskInput_Topics" ></div>
<rn:block id="preExperienceInput"/>
<div class="rn_IncidentTaskInput_col">
    <select id="<?=
"rn_{$this->instanceID}_select"?>" class="rn_IncidentTaskInput_Select">
 <option value="P">Positive Experience</option>
 <option value="N">Negative Experience</option>
 <option value="I">Idea/Suggestion</option>
 <option value="O">Other</option>
 </select>
</div>
<rn:block id="postExperienceInput"/>
 <div class="rn_IncidentTaskInput_Narrowcol" >
&nbsp; &nbsp;with &nbsp; &nbsp;</div>
<div class="rn_IncidentTaskInput_col2">
<?php 
echo "<select id=\"".$instanceName."_products\" class=\"rn_IncidentTaskInput_Select\">";
echo " <option value=\"\">Select a Topic</option>\r\n";
foreach($this->data['results'] as $key => $value) {
echo " <option value=\"".$value['id']."\">".$value['label']."</option>\r\n";
if(count($value['subItems'])) {
foreach($value['subItems'] as $si_value) {
echo " <option value=\"".$si_value['id']."\">&nbsp;&nbsp;".$si_value['label']."</option>\r\n";
if(count($si_value['subItems'])) {
foreach($si_value['subItems'] as $si2_value) {
echo " <option value=\"".$si2_value['id']."\">&nbsp;&nbsp;&nbsp;&nbsp;".$si2_value['label']."</option>\r\n";
}
}
}
}
}
echo "</select> ";
?>
</div>
<div class="rn_IncidentTaskInput_Narrowcol">
<rn:block id="preButtonInput"/>
<input type="button" id="rn_<?=$this->instanceID?>_TopicButton" value="Add" />
</div>
<rn:block id="postButtonInput"/>
</div>
    <div class="rn_IncidentTaskInput_col">&nbsp; </div>
    <div class="rn_IncidentTaskInput_Narrowcol">&nbsp; </div>
    <div class="rn_IncidentTaskInput_col2">
        <span class="rn_IncidentTaskInput_Text">Please click "Add" after selecting topic </span>
    </div>
<br>
</div>