RightNow.namespace('Custom.Widgets.util.CustomInfoButton');Custom.Widgets.util.CustomInfoButton=RightNow.Widgets.extend({constructor:function(data,instanceID){var attrs=this.data.attrs;this.instanceID=instanceID;this._requestInProgress=false;this._searchButton=document.getElementById("rn_"+this.instanceID+"_SubmitButton");this._enableClickListener();RightNow.Event.subscribe("evt_reportResponse",this._onSearchResponse,this);this._myDivPanel=null;},_startSearch:function(evt)
{if(this._requestInProgress)
return false;if(!this.data.attrs.popup_window&&((this.data.attrs.target==='_self')))
this._disableClickListener();if(this.Y.UA.ie!==0)
{if(!this._parentForm)
this._parentForm=myNode.ancestor("rn_"+this.instanceID,"FORM");if(this._parentForm&&window.external&&"AutoCompleteSaveForm"in window.external)
{window.external.AutoCompleteSaveForm(this._parentForm);}}
var eo=new RightNow.Event.EventObject();eo.w_id=this.instanceID;eo.filters={reportPage:this.data.attrs.report_page_url,target:this.data.attrs.target,popupWindow:this.data.attrs.popup_window,width:this.data.attrs.popup_window_width_percent,height:this.data.attrs.popup_window_height_percent};if(!this.data.attrs.is_link){var theDiv=document.getElementById(this.data.attrs.target);myNode.removeClass(theDiv,'rn_Hidden');this._myDivPanel=new this.Y.Panel({srcNode:'#myEmailDiv',width:250,zIndex:5,centered:true,modal:true,visible:false,render:true,plugins:[Y.Plugin.Drag]});this._myDivPanel.show();}
if(this.data.attrs.is_link){if(this.data.attrs.new_window){window.open(this.data.attrs.target);}
else
RightNow.Url.navigate(this.data.attrs.target,true);}},_onSearchResponse:function(type,args)
{if(args[0].filters.report_id==this.data.attrs.report_id)
this._enableClickListener();},_enableClickListener:function()
{this._requestInProgress=false;var button=this.Y.one(this._searchButton);button.on("click",this._startSearch);},_disableClickListener:function()
{this._requestInProgress=true;this.Y.Event["detach"]("click",this._startSearch,this._searchButton,this);}});