RightNow.namespace('Custom.Widgets.input.CustomDateInput');Custom.Widgets.input.CustomDateInput=RightNow.Widgets.DateInput.extend({overrides:{constructor:function(){this.parent();this._parentContainer=this.Y.one("#rn_"+this.instanceID+"_child");RightNow.Event.on('evt_questiontype',this._doAction,this);RightNow.Event.on('evt_selectiontype',this._doAction,this);}},_doAction:function(evt,args){var myData=JSON.stringify(args[0].data,null,0);myData=myData.substring(myData.indexOf(':')+1,myData.length);myData=myData.replace(/"/g,'');myData=myData.replace(/_/g,'=');myData=myData.replace(/}/g,'');var dispValues=this.data.attrs.display_value.split(",");var dispValues=this.data.attrs.display_value.split(",");if(!this.data.attrs.always_show)
this._parentContainer.addClass('rn_Hidden');else{this._parentContainer.removeClass('rn_Hidden');this.data.attrs.required=false;}
for(var i=0;i<dispValues.length;i++){if(dispValues[i].indexOf(myData)>-1){this._parentContainer.removeClass('rn_Hidden');this.data.attrs.required=true;}}}});