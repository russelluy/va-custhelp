RightNow.namespace('Custom.Widgets.input.CustomTextInput');Custom.Widgets.input.CustomTextInput=RightNow.Widgets.TextInput.extend({overrides:{constructor:function(){this.parent();this._parentContainer=this.Y.one("#rn_"+this.instanceID+"_child");RightNow.Event.on('evt_questiontype',this._doAction,this);RightNow.Event.on('evt_selectiontype',this._doAction,this);}},_doAction:function(evt,args){var myData=JSON.stringify(args[0].data,null,0);myData=myData.substring(myData.indexOf(':')+1,myData.length);myData=myData.replace(/"/g,'');myData=myData.replace(/_/g,'=');myData=myData.replace(/}/g,'');var dispValues=this.data.attrs.display_value.split(",");var hideonValuesNE=this.data.attrs.hideon_notequal_value.split(",");var hideonValues=this.data.attrs.hideon_value.split(",");var testValue=myData;var matchHide=0;var matchDisplay=0;if(!this.data.attrs.always_show)
this._parentContainer.addClass('rn_Hidden');else
this._parentContainer.removeClass('rn_Hidden');for(var i=0;i<dispValues.length;i++){if(dispValues[i].indexOf(myData)>-1){this._parentContainer.removeClass('rn_Hidden');matchDisplay=1;}}
if(hideonValuesNE.length>0&&hideonValuesNE[0]!=""){for(var i=0;i<hideonValuesNE.length;i++){if(hideonValuesNE[i]!=testValue){this._parentContainer.addClass('rn_Hidden');}
else
this._parentContainer.removeClass('rn_Hidden');}}
if(hideonValues.length>0&&hideonValues[0]!=""){for(var i=0;i<hideonValues.length;i++){if(hideonValues[i]==testValue){this._parentContainer.addClass('rn_Hidden');matchHide=1;}}}
if((hideonValues.length>0&&hideonValues[0]!="")&&matchHide==0)
this._parentContainer.removeClass('rn_Hidden');if((dispValues.length>0&&dispValues[0]!="")&&matchDisplay==0)
this._parentContainer.addClass('rn_Hidden');}});