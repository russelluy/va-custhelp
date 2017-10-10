
<rn:block id='SelectionInput-top'>
<? if (1===2) { ?>
</rn:block>

<!--
<rn:block id='SelectionInput-preLabel'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-preRequired'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-postRequired'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-postLabel'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-preInput'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-inputTop'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-inputBottom'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-postInput'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-preHint'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-postHint'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-preRadioInput'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-postRadioInput'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-preRadioLabel'>

</rn:block>
-->

<!--
<rn:block id='SelectionInput-postRadioLabel'>

</rn:block>
-->


<rn:block id='SelectionInput-bottom'>
<?	} else { 
		<? if ($this->data['displayType'] === 'Select'): ?> <!-- Note: because menu custom fields always show in drop downs, this is the place we have replaced the <options> with radios -->
			
			<? if (!$this->data['attrs']['display_as_checkbox']): ?> <!-- Display as radio buttons -->
				<? $this->data['displayType'] = 'Radio'; ?>
			    <? if (is_array($this->data['menuItems'])): 
				        $instanceName = "rn_{$this->instanceID}_Radio";
				        $inputNameRadio = "{$this->data['inputName']}_Radio"; 
				        $cVar = substr(strrchr($this->data['js']['name'], "."), 1); 
			        	$hiddenName = "rn_{$this->instanceID}_{$cVar}";
			        	
			        ?>
			        	<input type="hidden" id="<?= $hiddenName ?>"/>
				        <div style="vertical-align:middle;padding-top:5px;float:left;">
							<?
						        $i = 0;
						        foreach ($this->data['menuItems'] as $key => $item): 
					        		$id = "rn_{$this->instanceID}_{$cVar}_{$key}"; 
					        		$radioValue = "{$cVar}_{$key}";
				        	?>
				        			<input type="radio" name="<?= $inputNameRadio ?>" id="<?= $id ?>" <?= $this->outputChecked($i) ?> value="<?= $key ?>"/>
				        			
						            <label for="<?= $id ?>" style="display:inline; margin-left:5px;">
							            <?= trim($item) ?>
							            <? if ($this->data['attrs']['hint'] && $i === 1): ?>
							                <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
							            <? endif; ?>
						            </label>
							        <br />
						            <?  $i++; ?>
						        <? endforeach; ?>
						        <input type="hidden" name="<?= $this->data['inputName']?>" id="rn_<?= $hiddenName ?>" value="">
				        </div>
			    <? endif; ?>
		
		    <? else: ?> <! -- Display as a checkbox selection -->
		    	<? $this->data['displayType'] = 'Checkbox'; ?>
		    		    <? if (is_array($this->data['menuItems'])): 
				        $instanceName = "rn_{$this->instanceID}_Checkbox"; 
				        $cVar = substr(strrchr($this->data['js']['name'], "."), 1); 
			        	$hiddenName = "rn_{$this->instanceID}_{$cVar}";
			        ?>
			        	<input type="hidden" id="<?= $hiddenName ?>"/>
				        <div style="vertical-align:middle;padding-top:5px;float:left;">
							<?
						        $i = 0;
						        foreach ($this->data['menuItems'] as $key => $item): 
					        		$id = "rn_{$this->instanceID}_{$cVar}_{$key}"; 
				        	?>
						            <input type="checkbox" id="<?= $id ?>" name="<?= $instanceName ?>" <?= $this->outputChecked(1) ?> value="1"/>
						            <label for="<?= $id ?>" style="display:inline; margin-left:5px;">
							            <?= trim($item) ?>
							            <? if ($this->data['attrs']['hint'] && $i === 1): ?>
							                <span class="rn_ScreenReaderOnly"><?= $this->data['attrs']['hint'] ?></span>
							            <? endif; ?>
						            </label>
							        <br />
						            <?  $i++; ?>
						        <? endforeach; ?>
				        </div>
			    <? endif; ?>
				<br>
			<? endif; ?>
		<? endif; ?>	
		<br />	
	<? } ?>
</rn:block>

<!--
<rn:block id='FieldDisplay-top'>

</rn:block>
-->

<!--
<rn:block id='FieldDisplay-label'>

</rn:block>
-->

<!--
<rn:block id='FieldDisplay-value'>

</rn:block>
-->

<!--
<rn:block id='FieldDisplay-bottom'>

</rn:block>
-->

