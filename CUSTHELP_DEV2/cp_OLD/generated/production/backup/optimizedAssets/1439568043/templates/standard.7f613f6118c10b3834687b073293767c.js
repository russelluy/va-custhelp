
RightNow.Widgets.LogoutLink=RightNow.Widgets.extend({constructor:function(){var logoutLink=this.Y.one(this.baseSelector+"_LogoutLink");if(!logoutLink)
return;logoutLink.on("click",this._onLogoutClick,this);},_onLogoutCompleted:function(response,originalEventObj){if(!RightNow.Event.fire("evt_logoutResponse",{data:originalEventObj,response:response}))
return;var Url=RightNow.Url;if(response.success===1&&!RightNow.UI.Form.logoutInProgress&&originalEventObj.w_id===this.instanceID)
{RightNow.UI.Form.logoutInProgress=true;if(this.data.js&&this.data.js.redirectLocation)
{if(response.session)
this.data.js.redirectLocation=Url.addParameter(this.data.js.redirectLocation,'session',RightNow.Text.getSubstringAfter(response.session,'session/'));Url.navigate(this.data.js.redirectLocation,true);}
else
{if(response.socialLogout)
Url.navigate(response.socialLogout,true);else if(this.data.attrs.redirect_url==='')
Url.navigate(response.url,true);else
Url.navigate(this.data.attrs.redirect_url+response.session,true);}}},_onLogoutClick:function(){var eventObject=new RightNow.Event.EventObject(this,{data:{w_id:this.instanceID,currentUrl:window.location.pathname,redirectUrl:this.data.attrs.redirect_url}});if(RightNow.Event.fire("evt_logoutRequest",eventObject)){RightNow.Ajax.makeRequest(this.data.attrs.logout_ajax,eventObject.data,{successHandler:this._onLogoutCompleted,scope:this,data:eventObject,json:true});}}});
RightNow.Widgets.LoginDialog=RightNow.Widgets.extend({constructor:function(){this._dialog=this._keyListener=null;this._errorDisplay=this.Y.one(this.baseSelector+"_ErrorMessage");this._container=this.Y.one(this.baseSelector);var loginLink=this.Y.one("#"+this.data.attrs.trigger_element);if(loginLink){if(this.data.js.loginLinkOverride)
loginLink.set('href',this.data.js.loginLinkOverride);else
loginLink.on("click",this._onLoginTriggerClick,this);}
else{RightNow.UI.addDevelopmentHeaderError("Error with LoginDialog widget, trigger_element attribute value was set to '"+
this.data.attrs.trigger_element+"', but an element with that ID doesn't exist on the page.");}},_onLoginTriggerClick:function(){if(!this._dialog){this._dialog=RightNow.UI.Dialog.actionDialog(this.data.attrs.label_dialog_title,document.getElementById("rn_"+this.instanceID),{buttons:[{text:this.data.attrs.label_login_button,handler:{fn:this._onSubmit,scope:this}},{text:this.data.attrs.label_cancel_button,handler:{fn:this._onCancel,scope:this}}]});this._keyListener=RightNow.UI.Dialog.addDialogEnterKeyListener(this._dialog,this._onSubmit,this,'input');this._dialog.validate=function(){return false;};RightNow.UI.show(this._container);this._dialog.cancelEvent.subscribe(this._onCancel,null,this);}
else if(this._errorDisplay)
{this._errorDisplay.set("innerHTML","");}
this._dialog.show();this._usernameField=this._usernameField||this.Y.one(this.baseSelector+"_Username");this._passwordField=this._passwordField||this.Y.one(this.baseSelector+"_Password");var focusElement=((this._usernameField&&this._usernameField.get("value")==="")?this._usernameField:this._passwordField);if(focusElement)
{RightNow.UI.Dialog.enableDialogControls(this._dialog,this._keyListener);focusElement.focus();}},_onCancel:function(){if(this._errorDisplay)
{this._errorDisplay.set("innerHTML","").removeClass("rn_MessageBox rn_ErrorMessage");}
if(this._dialog)
{RightNow.UI.Dialog.disableDialogControls(this._dialog,this._keyListener);this._dialog.hide();}},_onSubmit:function(){var username=(this._usernameField)?this.Y.Lang.trim(this._usernameField.get("value")):"",password=(!this.data.attrs.disable_password&&this._passwordField)?this._passwordField.get("value"):"",errorMessage="",eventObject;if(username.indexOf(' ')>-1)
errorMessage=RightNow.Text.sprintf(RightNow.Interface.getMessage("PCT_S_MUST_NOT_CONTAIN_SPACES_MSG"),RightNow.Interface.getMessage("USERNAME_LBL"));else if(username.indexOf('"')>-1)
errorMessage=RightNow.Text.sprintf(RightNow.Interface.getMessage("PCT_S_CONTAIN_DOUBLE_QUOTES_MSG"),RightNow.Interface.getMessage("USERNAME_LBL"));else if(username.indexOf("<")>-1||username.indexOf(">")>-1)
errorMessage=RightNow.Text.sprintf(RightNow.Interface.getMessage("PCT_S_CNT_THAN_MSG"),RightNow.Interface.getMessage("USERNAME_LBL"));if(errorMessage!=="")
{this._addErrorMessage(errorMessage,this._usernameField.get("id"));return;}
eventObject=new RightNow.Event.EventObject(this,{data:{login:username,password:password,url:window.location.pathname,w_id:this.data.info.w_id}});if(RightNow.Event.fire("evt_loginFormSubmitRequest",eventObject))
{this._toggleLoading(true);RightNow.UI.Dialog.disableDialogControls(this._dialog,this._keyListener);if(RightNow.Event.noSessionCookies()){RightNow.Event.setTestLoginCookie();}
RightNow.Ajax.makeRequest(this.data.attrs.login_ajax,eventObject.data,{successHandler:this._onResponseReceived,scope:this,data:eventObject,json:true});if(this.Y.UA.ie>0)
{if(window.external&&"AutoCompleteSaveForm"in window.external)
{window.external.AutoCompleteSaveForm(document.getElementById(this.baseDomID+"_Form"));}}}},_onResponseReceived:function(response,originalEventObject){if(!RightNow.Event.fire("evt_loginFormSubmitResponse",{data:originalEventObject,response:response})){return;}
this._toggleLoading(false);if(response.success==1)
{this._dialog.setFooter("");this._container&&this._container.set("innerHTML",response.message);RightNow.Url.navigate(this._getRedirectUrl(response));}
else
{RightNow.UI.Dialog.enableDialogControls(this._dialog,this._keyListener);this._addErrorMessage(response.message,this._usernameField.get("id"),response.showLink);}},_getRedirectUrl:function(result){var redirectUrl;result.sessionParm=RightNow.Text.getSubstringAfter(result.sessionParm,'session/');if(this.data.js&&this.data.js.redirectOverride){redirectUrl=RightNow.Url.addParameter(this.data.js.redirectOverride,'session',result.sessionParm);}
else{redirectUrl=this.data.attrs.redirect_url||result.url;if(result.addSession)
redirectUrl=RightNow.Url.addParameter(redirectUrl,'session',result.sessionParm);}
redirectUrl+=this.data.attrs.append_to_url;if(result.forceRedirect){redirectUrl=RightNow.Url.addParameter(result.forceRedirect,'redirect',encodeURIComponent(redirectUrl));}
return redirectUrl;},_addErrorMessage:function(message,focusElement,showLink){if(this._errorDisplay)
{this._errorDisplay.addClass('rn_MessageBox rn_ErrorMessage');if(showLink===false)
{this._errorDisplay.set("innerHTML",message);}
else
{this._errorDisplay.set("innerHTML",'<a href="javascript:void(0);" onclick="document.getElementById(\''+focusElement+'\').focus(); return false;">'+message+'</a>').get("firstChild").focus();}}},_toggleLoading:function(turnOn){this._dialogContent||(this._dialogContent=this.Y.one(this.baseSelector+"_Content"));this._dialogContent.all('input')[(turnOn)?'setAttribute':'removeAttribute']('disabled',true);if(!this.Y.UA.ie||this.Y.UA.ie>8){this._dialogContent.transition({opacity:turnOn?0:1,duration:0.4});this.Y.one(this.baseSelector)[(turnOn)?'addClass':'removeClass']('rn_ContentLoading');}}});