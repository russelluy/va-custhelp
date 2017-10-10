<div id="<?= "rn_{$this->instanceID}"
?>" class="<?= $this->classList ?>">
<div id="<?= "rn_{$this->instanceID}_content"
?>" class="rn_label" >
    <? $instanceName = "rn_{$this->instanceID}";
?>
<br>    
I had a .. <br><br>
<div id="<?= "rn_{$this->instanceID}_Topics"?>" class="rn_IncidentTaskInput_Topics" ></div>
<br>
<rn:block id="preExperienceInput"/>
<div class="rn_IncidentTaskInput_col">
    <select id="<?=
"rn_{$this->instanceID}_select"?>" class="rn_IncidentTaskInput_Select">
 <option value="P">Positive Experience</option>
 <option value="N">Negative Experience</option>
 <option value="E">Idea/Suggestion</option>
 <option value="O">Other</option>
 </select>
</div>
<rn:block id="postExperienceInput"/>
 <div class="rn_IncidentTaskInput_Narrowcol" >
with </div>
<div class="rn_IncidentTaskInput_col2">
                <rn:widget path="input/ProductCategoryInputCustom"  label_input="" label_nothing_selected="Select a Topic"/>
</div>
<div class="rn_IncidentTaskInput_Narrowcol">
<rn:block id="preButtonInput"/>
<input type="button" class="rn_IncidentTaskInput_Button" id="rn_<?=$this->instanceID?>_TopicButton" value="Add" />
<input type="hidden" id="rn_<?=$this->instanceID?>_TopicIdSelected" value="" />
<input type="hidden" id="rn_<?=$this->instanceID?>_TopicLabelSelected" value="" />
</div>
<rn:block id="postButtonInput"/>
</div>
    <div class="rn_IncidentTaskInput_col">&nbsp; </div>
    <div class="rn_IncidentTaskInput_Narrowcol">&nbsp; </div>
    <div class="rn_IncidentTaskInput_col2">
        <span class="rn_IncidentTaskInput_Text">Please click "Add" after selecting topic </span>
    </div>
<br
</div>