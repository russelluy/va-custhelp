RightNow.namespace('Custom.Widgets.input.SelectionInputAsRadio');Custom.Widgets.input.SelectionRadioInput=RightNow.Widgets.SelectionInput.extend({overrides:{constructor:function(){this.parent();this._customFieldID=this.baseDomID+"_"+this.data.js.name;this._customDummyFieldName=this.baseDomID+"_CloneRadioInput";this._customDummyFieldID="rn_"+this.instanceID+"_CloneRadioInput";thePos=this._customDummyFieldID.search(/\d/);this._customRadioDivName=this._customDummyFieldID.substring(0,thePos-1)+"_RadioDiv";this._customRadioName=this._customDummyFieldID.substring(0,thePos-1)+"_Radio";this._cloneSelectAsRadio();}},_cloneSelectAsRadio:function(){var selectDiv=this.Y.one("#"+this.baseDomID);if(selectDiv){var html="<div data-field='"+this._customDummyFieldName+"_field\' id='"+this._customRadioDivName+"'>";var myObject=document.getElementById(this._customFieldID);for(var i=0;i<myObject.options.length;i++)
{if(myObject.options[i].value!="")
{$selected="";if(myObject.options[i].value==='1965'||myObject.options[i].value==='1967')
$selected="checked";html+="<input type=\"radio\" id=\""+this._customRadioName+"\"   name=\""+this._customDummyFieldName+"\"  value=\""+myObject.options[i].value+"\" "+$selected+" >";html+="<label>"+myObject.options[i].text+"</label><br />";}}
selectDiv.append(html);var radios=document.getElementsByName(this._customDummyFieldName);var fieldID=this._customFieldID;var that=this;jQuery(("input[name="+this._customDummyFieldName+"]")).change(function(){var selection=$(this).val();var myObject=document.getElementById(fieldID);for(var j=0;j<myObject.options.length;j++)
{console.log("checking options value "+myObject.options[j].value+" and comparing to "+selection);if(myObject.options[j].value==selection)
{myObject.options[j].selected=true;}}
var eventObject=new RightNow.Event.EventObject(this,{data:{eventSubject:selection}});if(RightNow.Event.fire("evt_questiontype",eventObject)){}});}},_setValue:function(setVal)
{var setVal=this.value;alert("looking for sel object with value "+setVal);var customDummyFieldID="rn_"+this.instanceID+"_CloneRadioInput";var myObject=document.getElementById(this.baseDomID+"_"+this.data.js.name);for(var i=0;i<myObject.options.length;i++)
{if(myObject.options[i].value==setVal)
{myObject.options[i].selected=true;}}}});