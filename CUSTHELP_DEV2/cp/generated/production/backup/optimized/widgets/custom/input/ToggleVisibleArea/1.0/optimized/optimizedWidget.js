RightNow.namespace('Custom.Widgets.input.ToggleVisibleArea');Custom.Widgets.input.ToggleVisibleArea=RightNow.Widgets.TextInput.extend({overrides:{constructor:function(){this.parent();this._parentContainer=this.Y.one("#rn_"+this.instanceID+"_child");this._toggleArea=this.Y.one(this.data.attrs.toggle_div_name);this._value1=false;this._value2=false;RightNow.Event.subscribe('evt_questiontype',this._doAction,this);RightNow.Event.subscribe('evt_selectiontype',this._doAction2,this);}},_doAction:function(evt,args){var myData=JSON.stringify(args[0].data,null,0);myData=myData.substring(myData.indexOf(':')+1,myData.length);myData=myData.replace(/"/g,'');myData=myData.replace(/_/g,'=');myData=myData.replace(/}/g,'');var dispValues=this.data.attrs.display_value.split(",");var hideonValuesNE=this.data.attrs.hideon_notequal_value.split(",");var testValue=myData;this._value2=false;if(!this.data.attrs.always_show)
this._parentContainer.addClass('rn_Hidden');else
this._parentContainer.removeClass('rn_Hidden');for(var i=0;i<dispValues.length;i++){if(dispValues[i].indexOf(myData)>-1){this._parentContainer.removeClass('rn_Hidden');if(this.data.attrs.toggle_div_name)
this._toggleArea.removeClass('rn_Hidden');}}},_doAction2:function(evt,args){var myData=JSON.stringify(args[0].data,null,0);myData=myData.substring(myData.indexOf(':')+1,myData.length);myData=myData.replace(/"/g,'');myData=myData.replace(/_/g,'=');myData=myData.replace(/}/g,'');var dispValues=this.data.attrs.display_value.split(",");var hideonValuesNE=this.data.attrs.hideon_notequal_value.split(",");var testValue=myData;this._value2=false;for(var i=0;i<dispValues.length;i++){if(dispValues[i].indexOf(myData)>-1){this._value2=true;if(this._value1&&this._value2){this._parentContainer.removeClass('rn_Hidden');if(this.data.attrs.toggle_div_name)
this._toggleArea.addClass('rn_Hidden');}}}}});