
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
RightNow.Widgets.ChatDisconnectButton=RightNow.Widgets.extend({constructor:function(){this._container=this.Y.one(this.baseSelector);this._disconnectButton=this.Y.one(this.baseSelector+"_Button");this._currentState=RightNow.Chat.Model.SEARCHING;if(this._container&&this._disconnectButton)
{this._disconnectButton.on("click",this._onButtonClick,this);RightNow.Event.subscribe("evt_chatStateChangeResponse",this._onChatStateChangeResponse,this);}},_onButtonClick:function(type,args)
{if(this._currentState!==RightNow.Chat.Model.ChatState.DISCONNECTED&&this._currentState!==RightNow.Chat.Model.ChatState.CANCELLED){RightNow.Event.fire("evt_chatHangupRequest",new RightNow.Event.EventObject(this,{data:{}}));}
else{RightNow.Event.fire("evt_chatCloseButtonClickRequest",new RightNow.Event.EventObject(this,{data:{closingUrl:this.data.attrs.close_redirect_url,openInWindow:this.data.attrs.open_in_window}}));}},_onChatStateChangeResponse:function(type,args)
{var currentState=args[0].data.currentState;var previousState=args[0].data.previousState;var ChatState=RightNow.Chat.Model.ChatState;if(currentState===ChatState.CONNECTED&&previousState!==ChatState.CONNECTED)
{RightNow.UI.show(this._container);}
else if(currentState===ChatState.CANCELLED||currentState===ChatState.DISCONNECTED)
{if(this.data.attrs.mobile_mode||!window.opener)
{RightNow.UI.hide(this._container);}
else
{this._disconnectButton.set('innerHTML',new EJS({text:this.getStatic().templates.closeButton}).render({attrs:this.data.attrs})).set('title',this.data.attrs.label_tooltip_close);}}
this._currentState=currentState;}});
RightNow.Widgets.ChatServerConnect=RightNow.Widgets.extend({constructor:function(){this._resumeSessionDialog=null;this._miscellaneousData=null;this._validChatRequest=true;this._connectionStatus=this.Y.one(this.baseSelector+"_ConnectionStatus");this._connectingIconElem=this.Y.one(this.baseSelector+"_ConnectingIcon");this._errorMessageDiv=this.Y.one(this.baseSelector+"_ErrorLocation");if(this.Y.one(this.baseSelector+"_Connector")){RightNow.Event.subscribe("evt_chatEventBusInitializedResponse",this._validateChatParameters,this);RightNow.Event.subscribe("evt_chatConnectResponse",this._onChatConnectResponse,this);RightNow.Event.subscribe("evt_chatFetchUpdateResponse",this._onFetchUpdateResponse,this);RightNow.Event.subscribe("evt_chatStateChangeResponse",this._onChatStateChangeResponse,this);RightNow.Event.subscribe("evt_chatSetParametersResponse",this._onChatSetParametersResponse,this);RightNow.Event.subscribe("evt_chatValidateParametersResponse",this._onChatValidateParametersResponse,this);RightNow.Event.subscribe("evt_chatCheckAnonymousResponse",this._onChatCheckAnonymousResponse,this);}
if(RightNow.Chat.UI&&RightNow.Chat.UI.EventBus!==null&&RightNow.Chat.UI.EventBus.isEventBusInitialized!==undefined&&RightNow.Chat.UI.EventBus.isEventBusInitialized())
this._validateChatParameters();},_validateChatParameters:function()
{var eventObject;this._setMiscellaneousData();eventObject=new RightNow.Event.EventObject(this,{data:{email:this.data.js.contactEmail||RightNow.Url.getParameter("Contact.Email.0.Address"),prod:RightNow.Url.getParameter("p"),cat:RightNow.Url.getParameter("c"),miscellaneousData:this._miscellaneousData,customFields:this.data.js.customFields}});RightNow.Event.fire("evt_chatValidateParametersRequest",eventObject);this._checkAnonymousRequest();this._displayErrors();this._setChatParameters();},_onChatValidateParametersResponse:function(type,args)
{var eventObject=args[0];this._validChatRequest=eventObject.data.valid;if(this._validChatRequest)
{return;}
if(!this._errorMessages)
this._errorMessages=[];this._errorMessages.push(this.data.attrs.label_validation_fail);},_checkAnonymousRequest:function()
{if(!this.data.attrs.first_name_required&&!this.data.attrs.last_name_required&&!this.data.attrs.email_required)
return;var eventObject=new RightNow.Event.EventObject(this,{data:{firstName:this.data.js.contactFirstName||RightNow.Url.getParameter("Contact.Name.First")||RightNow.Url.getParameter("contacts.first_name"),firstNameRequired:this.data.attrs.first_name_required,lastName:this.data.js.contactLastName||RightNow.Url.getParameter("Contact.Name.Last")||RightNow.Url.getParameter("contacts.last_name"),lastNameRequired:this.data.attrs.last_name_required,email:this.data.js.contactEmail||RightNow.Url.getParameter("Contact.Email.0.Address")||RightNow.Url.getParameter("contacts.email"),emailRequired:this.data.attrs.email_required}});RightNow.Event.fire("evt_chatCheckAnonymousRequest",eventObject);},_onChatCheckAnonymousResponse:function(type,args)
{var eventObject=args[0];if(!eventObject.data.anonymousRequest)
return;if(!this._errorMessages)
this._errorMessages=[];this._errorMessages.push(this.data.attrs.label_prevent_anonymous_chat);this._validChatRequest=false;},_displayErrors:function()
{if(this._validChatRequest||!this._errorMessages||this._errorMessages.length<=0)
return;var errorMessageList=this.Y.Node.create(new EJS({text:this.getStatic().templates.errorMessageList}).render({errors:this._errorMessages,attrs:this.data.attrs}));this._errorMessageDiv.appendChild(errorMessageList);this._errorMessageDiv.addClass("rn_MessageBox").addClass("rn_ErrorMessage").removeClass("rn_Hidden").scrollIntoView();RightNow.UI.hide(this._connectionStatus);},_setChatParameters:function()
{if(!this._validChatRequest)
return;var surveyCompID=RightNow.Url.getParameter("survey_comp_id");var surveyTermID=RightNow.Url.getParameter("survey_term_id");var surveyCompAuth=RightNow.Url.getParameter("survey_comp_auth");var surveyTermAuth=RightNow.Url.getParameter("survey_term_auth");var eventObject=new RightNow.Event.EventObject(this,{data:{connectionData:{absentInterval:RightNow.Interface.getConfig("ABSENT_INTERVAL","RNL"),absentRetryCount:RightNow.Interface.getConfig("USER_ABSENT_RETRY_COUNT","RNL"),chatServerHost:RightNow.Interface.getConfig("SRV_CHAT_HOST","RNL"),chatServerPort:RightNow.Interface.getConfig("SERVLET_HTTP_PORT","RNL"),dbName:RightNow.Interface.getConfig("DB_NAME","COMMON"),useHttps:window.location.protocol.indexOf('https:')===0},surveyBaseUrl:this.data.js.maUrl,agentAbsentRetryCount:RightNow.Interface.getConfig("AGENT_ABSENT_RETRY_COUNT","RNL"),terminateChatSessionString:this.data.attrs.label_terminate_session}});if(surveyCompID)
eventObject.data.surveyCompID=surveyCompID;if(surveyTermID)
eventObject.data.surveyTermID=surveyTermID;if(surveyCompAuth)
eventObject.data.surveyCompAuth=surveyCompAuth;if(surveyTermAuth)
eventObject.data.surveyTermAuth=surveyTermAuth;RightNow.Event.fire("evt_chatSetParametersRequest",eventObject);},_onChatSetParametersResponse:function(type,args)
{this._connect();},_connect:function(resume)
{var subject=RightNow.Url.getParameter('Incident.Subject')||RightNow.Url.getParameter("incidents.subject");if(subject===null||subject==='')
subject=this.data.js.postedSubject;var eventObject=new RightNow.Event.EventObject(this,{data:{interfaceID:this.data.js.interfaceID,firstName:this.data.js.contactFirstName||RightNow.Url.getParameter("Contact.Name.First")||RightNow.Url.getParameter("contacts.first_name"),lastName:this.data.js.contactLastName||RightNow.Url.getParameter("Contact.Name.Last")||RightNow.Url.getParameter("contacts.last_name"),email:this.data.js.contactEmail||RightNow.Url.getParameter("Contact.Email.0.Address")||RightNow.Url.getParameter("contacts.email"),contactID:this.data.js.contactID,organizationID:this.data.js.organizationID,subject:subject,prod:this.data.js.postedProduct||RightNow.Url.getParameter("p")||RightNow.Url.getParameter("incidents.prod"),cat:this.data.js.postedCategory||RightNow.Url.getParameter("c")||RightNow.Url.getParameter("incidents.cat"),resume:resume,queueID:RightNow.Url.getParameter("q_id"),requestSource:this.data.js.requestSource,surveySendID:RightNow.Url.getParameter("survey_send_id"),surveySendDelay:RightNow.Url.getParameter("survey_send_delay"),surveySendAuth:RightNow.Url.getParameter("survey_send_auth"),sessionID:this.data.js.sessionID,miscellaneousData:this._miscellaneousData,incidentID:RightNow.Url.getParameter("i_id"),routingData:this.data.js.chat_data||RightNow.Url.getParameter("chat_data"),referrerUrl:this._getReferrerUrl(),coBrowsePremiumSupported:typeof CoBrowseLauncher!=="undefined"&&CoBrowseLauncher.isEnvironmentSupported(CoBrowseLauncher.getEnvironment())?0:1,isSpider:this.data.js.isSpider}});RightNow.Event.fire("evt_chatConnectRequest",eventObject);},_setMiscellaneousData:function()
{if(this._miscellaneousData)
return;this._miscellaneousData=[];for(var customFieldID in this.data.js.customFields)
{var customField=this.data.js.customFields[customFieldID],columnName=customField.col_name.split("c$")[1],postedCustomFieldName="Incident_CustomFields_c_"+columnName,urlCustomFieldName="Incident.CustomFields.c."+columnName,url2CustomFieldName="incidents.c$"+columnName,postedCustomFields=this.data.js.postedCustomFields||{},Url=RightNow.Url,customFieldValue=postedCustomFields[postedCustomFieldName]||Url.getParameter(urlCustomFieldName)||Url.getParameter(url2CustomFieldName);if(customFieldValue===null&&(customField.data_type===this.data.js.dateField||customField.data_type===this.data.js.dateTimeField))
{var year=postedCustomFields[postedCustomFieldName+"_year"]||Url.getParameter(urlCustomFieldName+"_year"),month=postedCustomFields[postedCustomFieldName+"_month"]||Url.getParameter(urlCustomFieldName+"_month"),day=postedCustomFields[postedCustomFieldName+"_day"]||Url.getParameter(urlCustomFieldName+"_day"),hour=postedCustomFields[postedCustomFieldName+"_hour"]||Url.getParameter(urlCustomFieldName+"_hour"),minute=postedCustomFields[postedCustomFieldName+"_minute"]||Url.getParameter(urlCustomFieldName+"_minute");if(year!==null)
this._miscellaneousData[urlCustomFieldName]=year||month||day?[[year,month,day].join("-"),hour||minute?[hour,minute].join(":"):""].join(" "):null;continue;}
else if(customField.data_type===this.data.js.radioField)
{customFieldValue=customFieldValue==="true"?"1":customFieldValue==="false"?"0":customFieldValue;}
if(customFieldValue!==null)
this._miscellaneousData[urlCustomFieldName]=customFieldValue;}},_getReferrerUrl:function()
{var referrerUrl;if(this.data.js.referrerUrl!=null)
{referrerUrl=this.data.js.referrerUrl;}
else
{var chatData=RightNow.Text.Encoding.base64Decode(RightNow.Url.getParameter("chat_data"));var dataValues=chatData.split('&');for(var index=0;index<dataValues.length;index++)
{var value=dataValues[index].split('=');if(value[0]==="referrerUrl")
{referrerUrl=decodeURIComponent(value[1]);break;}}
if(!referrerUrl)
{referrerUrl=document.referrer;if(!referrerUrl&&window.opener&&window.opener.location)
{try
{referrerUrl=window.opener.location.href;}
catch(e)
{}}}}
return referrerUrl;},_onChatConnectResponse:function(type,args)
{var eventObject=args[0];var messageElement=this.Y.one(this.baseSelector+"_Message");RightNow.UI.hide(this._connectingIconElem);if(eventObject.data.connected)
{if(messageElement)
messageElement.set("innerHTML",this.data.attrs.label_connection_success);}
else if(messageElement)
{messageElement.set("innerHTML",this.data.attrs.label_connection_fail);}
if(eventObject.data.connected&&eventObject.data.existingSession)
{this._displayResumeSessionDialog();return;}
if(eventObject.data.connected)
{this._fetchUpdate();}},_displayResumeSessionDialog:function()
{var buttons=[{text:RightNow.Interface.getMessage("OK_LBL"),handler:{fn:this._resumeSession,scope:this},isDefault:true},{text:RightNow.Interface.getMessage("CANCEL_LBL"),handler:{fn:this._startNewSession,scope:this},isDefault:false}];var dialogBody=this.Y.Node.create("<div>").addClass("rn_dialogLeftAlign").addClass("rn_ChatResumeSessionDialog").set("innerHTML",RightNow.Interface.getMessage("EXISTING_CHAT_SESS_FND_RESUME_SESS_MSG"));this._resumeSessionDialog=RightNow.UI.Dialog.actionDialog(RightNow.Interface.getMessage("EXISTING_CHAT_SESSION_LBL"),dialogBody,{"buttons":buttons});RightNow.UI.Dialog.addDialogEnterKeyListener(this._resumeSessionDialog,this._resumeSession,this);this._resumeSessionDialog.show();},_resumeSession:function()
{this._resumeSessionDialog.hide();this._connect(true);},_startNewSession:function()
{this._resumeSessionDialog.hide();this._connect(false);},_fetchUpdate:function()
{RightNow.Event.fire("evt_chatFetchUpdateRequest",new RightNow.Event.EventObject(this,{data:{}}));},_onFetchUpdateResponse:function()
{this._fetchUpdate();},_onChatStateChangeResponse:function(type,args)
{RightNow.UI.hide(this.baseSelector);}});
RightNow.Widgets.ChatEngagementStatus=RightNow.Widgets.extend({constructor:function(){this._currentState=null;this._previousState=null;this._reason=null;this._widgetElement=this.Y.one(this.baseSelector);if(this.Y.UA.ie>0&&this.Y.UA.ie<=8)
{this._onChatStateChangeResponse(null,[{'data':{'currentState':RightNow.Chat.Model.ChatState.DISCONNECTED,'reason':RightNow.Chat.Model.ChatDisconnectReason.BROWSER_UNSUPPORTED}}]);return;}
if(this._widgetElement)
{RightNow.Event.subscribe("evt_chatStateChangeResponse",this._onChatStateChangeResponse,this);this._widgetElement.setAttribute("aria-live","assertive").setAttribute("role","alert");}},_onChatStateChangeResponse:function(type,args)
{this._currentState=args[0].data.currentState;this._previousState=args[0].data.previousState;this._reason=args[0].data.reason;this._updateStatus();RightNow.UI.show(this._widgetElement);this._updateSearchingDetail();this._updateRequeuedDetail();this._updateCanceledDetail();},_updateStatus:function()
{var statusElement=this.Y.one(this.baseSelector+"_Status");if(!statusElement)
return;var ChatState=RightNow.Chat.Model.ChatState;switch(this._currentState)
{case ChatState.SEARCHING:case ChatState.REQUEUED:{statusElement.set("innerHTML",this.data.attrs.label_status_searching);break;}
case ChatState.CONNECTED:{statusElement.set("innerHTML",this.data.attrs.label_status_connected);break;}
case ChatState.RECONNECTING:{if(this._previousState===RightNow.Chat.Model.CONNECTED)
statusElement.set("innerHTML",this.data.attrs.label_status_reconnecting);break;}
case ChatState.CANCELLED:case ChatState.DEQUEUED:{statusElement.set("innerHTML",this.data.attrs.label_status_canceled);break;}
case ChatState.DISCONNECTED:{if(this._reason&&this._reason==='RECONNECT_FAILED')
statusElement.set("innerHTML",RightNow.Interface.getMessage("COMM_RN_LIVE_SERV_LOST_CHAT_SESS_MSG"));else
statusElement.set("innerHTML",this.data.attrs.label_status_disconnected);break;}}},_updateSearchingDetail:function()
{var searchingDetailElement=this.Y.one(this.baseSelector+"_Searching");if(!searchingDetailElement)
return;var ChatState=RightNow.Chat.Model.ChatState;if(this._currentState===ChatState.RECONNECTING)
return;if(this._currentState==ChatState.SEARCHING||this._currentState==ChatState.REQUEUED)
{RightNow.UI.show(searchingDetailElement);}
else
{RightNow.UI.hide(searchingDetailElement);}},_updateRequeuedDetail:function()
{var requeuedDetailElement=this.Y.one(this.baseSelector+"_Requeued");if(!requeuedDetailElement)
return;var ChatState=RightNow.Chat.Model.ChatState;if(this._currentState===ChatState.RECONNECTING)
return;if(this._currentState==ChatState.REQUEUED)
RightNow.UI.show(requeuedDetailElement);else
RightNow.UI.hide(requeuedDetailElement);},_updateCanceledDetail:function()
{var canceledUserDetailElement=this.Y.one(this.baseSelector+"_Canceled_User");var canceledSelfServiceDetailElement=this.Y.one(this.baseSelector+"_Canceled_Self_Service");var canceledNoAgentsAvailDetailElement=this.Y.one(this.baseSelector+"_Canceled_NoAgentsAvail");var canceledQueueTimeoutDetailElement=this.Y.one(this.baseSelector+"_Canceled_Queue_Timeout");var canceledDequeuedDetailElement=this.Y.one(this.baseSelector+"_Canceled_Dequeued");var canceledBrowserDetailElement=this.Y.one(this.baseSelector+"_Canceled_Browser");var ChatState=RightNow.Chat.Model.ChatState;var ChatDisconnectReason=RightNow.Chat.Model.ChatDisconnectReason;if(this._currentState===ChatState.RECONNECTING)
return;if(this._currentState==ChatState.CANCELLED)
{if(canceledUserDetailElement&&this._reason===ChatDisconnectReason.ENDED_USER_CANCEL)
RightNow.UI.show(canceledUserDetailElement);else if(canceledSelfServiceDetailElement&&this._reason===ChatDisconnectReason.ENDED_USER_DEFLECTED)
RightNow.UI.show(canceledSelfServiceDetailElement);else if(canceledNoAgentsAvailDetailElement&&this._reason===ChatDisconnectReason.FAIL_NO_AGENTS_AVAIL)
RightNow.UI.show(canceledNoAgentsAvailDetailElement);else if(canceledQueueTimeoutDetailElement&&this._reason===ChatDisconnectReason.QUEUE_TIMEOUT)
RightNow.UI.show(canceledQueueTimeoutDetailElement);}
else if(this._currentState==ChatState.DEQUEUED&&canceledDequeuedDetailElement)
{RightNow.UI.show(canceledDequeuedDetailElement);}
else if(this._currentState===ChatState.DISCONNECTED&&this._reason===ChatDisconnectReason.NO_AGENTS_AVAILABLE&&canceledUserDetailElement)
{RightNow.UI.show(canceledNoAgentsAvailDetailElement);}
else if(this._currentState===ChatState.DISCONNECTED&&typeof ChatDisconnectReason.BROWSER_UNSUPPORTED!=='undefined'&&this._reason===ChatDisconnectReason.BROWSER_UNSUPPORTED&&canceledBrowserDetailElement)
{RightNow.UI.show(canceledBrowserDetailElement);}
else
{if(canceledUserDetailElement)
RightNow.UI.hide(canceledUserDetailElement);if(canceledSelfServiceDetailElement)
RightNow.UI.hide(canceledSelfServiceDetailElement);if(canceledNoAgentsAvailDetailElement)
RightNow.UI.hide(canceledNoAgentsAvailDetailElement);if(canceledQueueTimeoutDetailElement)
RightNow.UI.hide(canceledQueueTimeoutDetailElement);if(canceledDequeuedDetailElement)
RightNow.UI.hide(canceledDequeuedDetailElement);}}});
RightNow.Widgets.ChatQueueWaitTime=RightNow.Widgets.extend({constructor:function(){RightNow.Event.subscribe("evt_chatEventBusInitializedResponse",this._initialize,this);this._estimatedWaitTimeDisplayed=false;this._queueWaitTimeContainer=this.Y.one(this.baseSelector);this._queuePositionElement=this.Y.one(this.baseSelector+"_QueuePosition");this._estimatedWaitTimeElement=this.Y.one(this.baseSelector+"_EstimatedWaitTime");this._averageWaitTimeElement=this.Y.one(this.baseSelector+"_AverageWaitTime");this._leaveScreenWarningElement=this.Y.one(this.baseSelector+"_BrowserWarning");if(this._queuePositionElement||this._estimatedWaitTimeElement||this._averageWaitTimeElement){RightNow.Event.subscribe("evt_chatStateChangeResponse",this._onChatStateChangeResponse,this);RightNow.Event.subscribe("evt_chatQueuePositionNotificationResponse",this._onChatQueuePositionNotificationResponse,this);}
this._displayQueuePosition=this._queuePositionElement&&(this.data.attrs.type==='position'||this.data.attrs.type==='all');this._displayEstimatedWaitTime=this._estimatedWaitTimeElement&&(this.data.attrs.type==='estimated'||this.data.attrs.type==='all');this._displayAverageWaitTime=this._averageWaitTimeElement&&(this.data.attrs.type==='average'||this.data.attrs.type==='all');if(RightNow.Chat.UI&&RightNow.Chat.UI.EventBus!==null&&RightNow.Chat.UI.EventBus.isEventBusInitialized!==undefined&&RightNow.Chat.UI.EventBus.isEventBusInitialized())
this._initialize();},_initialize:function()
{var uiUtils=RightNow.Chat.UI.Util;this._queuePositionMsg=uiUtils.doPositionAndWaitTimeVariableSubstitution(this.data.attrs.label_queue_position,this.instanceID+"_QueuePosition",RightNow.Interface.getConfig("ESTIMATED_WAIT_TIME_SAMPLES","RNL"));this._estimatedWaitTimeMsg=uiUtils.doPositionAndWaitTimeVariableSubstitution(this.data.attrs.label_estimated_wait_time,this.instanceID+"_EstimatedWaitTime",RightNow.Interface.getConfig("ESTIMATED_WAIT_TIME_SAMPLES","RNL"));this._averageWaitTimeMsg=uiUtils.doPositionAndWaitTimeVariableSubstitution(this.data.attrs.label_average_wait_time,this.instanceID+"_AverageWaitTime",RightNow.Interface.getConfig("ESTIMATED_WAIT_TIME_SAMPLES","RNL"));this._queuePositionElement.setAttribute("aria-live","polite").setAttribute("aria-atomic","true");this._estimatedWaitTimeElement.setAttribute("aria-live","polite").setAttribute("aria-atomic","true");this._averageWaitTimeElement.setAttribute("aria-live","polite").setAttribute("aria-atomic","true");if(uiUtils.hasLeaveScreenIssues())
RightNow.UI.show(this._leaveScreenWarningElement);},_onChatStateChangeResponse:function(type,args)
{if(args[0].data.currentState===RightNow.Chat.Model.ChatState.SEARCHING||args[0].data.currentState===RightNow.Chat.Model.ChatState.REQUEUED)
{this._estimatedWaitTimeDisplayed=false;if(this._displayQueuePosition)
{this._queuePositionElement.set('innerHTML',this.data.attrs.label_queue_position_not_available);RightNow.UI.show(this._queuePositionElement);}
if(this._displayEstimatedWaitTime)
{this._estimatedWaitTimeElement.set('innerHTML',this.data.attrs.label_estimated_wait_time_not_available);RightNow.UI.show(this._estimatedWaitTimeElement);}
if(this._displayAverageWaitTime)
{this._averageWaitTimeElement.set('innerHTML',this.data.attrs.label_average_wait_time_not_available);RightNow.UI.show(this._averageWaitTimeElement);}
RightNow.UI.show(this._queueWaitTimeContainer);}
else if(args[0].data.currentState===RightNow.Chat.Model.ChatState.RECONNECTING)
{return;}
else
{RightNow.UI.hide(this._queueWaitTimeContainer);}},_onChatQueuePositionNotificationResponse:function(type,args){this._updateQueuePosition(args[0].data.position);this._updateEstimatedWaitTime(args[0].data.expectedWaitSeconds);this._updateAverageWaitTime(args[0].data.averageWaitSeconds);},_updateQueuePosition:function(position)
{if(this._displayQueuePosition)
{this._updateQueuePositionMessage(position);this._updateQueuePositionValue(position);}},_updateQueuePositionMessage:function(position)
{this._queuePositionElement.set('innerHTML',position>0?this._queuePositionMsg:this.data.attrs.label_queue_position_not_available);},_updateQueuePositionValue:function(position)
{var queuePositionValueElem=this.Y.one(this.baseSelector+"_QueuePosition_QueuePosition");if(!queuePositionValueElem)
return;queuePositionValueElem.set('innerHTML',position>0?position:"");},_updateEstimatedWaitTime:function(estimatedWaitSeconds)
{if(this._displayEstimatedWaitTime)
{this._updateEstimatedWaitTimeMessage(estimatedWaitSeconds);this._updateEstimatedWaitTimeValue(estimatedWaitSeconds);}},_updateEstimatedWaitTimeMessage:function(estimatedWaitSeconds)
{if(estimatedWaitSeconds>0)
{this._estimatedWaitTimeDisplayed=true;this._estimatedWaitTimeElement.set('innerHTML',this._estimatedWaitTimeMsg);}
else
{this._estimatedWaitTimeElement.set('innerHTML',(estimatedWaitSeconds==0&&!this._estimatedWaitTimeDisplayed?this.data.attrs.label_estimated_wait_time_not_available:this.data.attrs.label_estimated_wait_time_exceeded));}},_updateEstimatedWaitTimeValue:function(estimatedWaitSeconds)
{var estimatedWaitTimeValueElem=this.Y.one(this.baseSelector+"_EstimatedWaitTime_EstimatedWaitTime");if(!estimatedWaitTimeValueElem)
return;estimatedWaitTimeValueElem.set('innerHTML',estimatedWaitSeconds>0?RightNow.Chat.UI.Util.toIso8601Time(estimatedWaitSeconds):"");},_updateAverageWaitTime:function(averageWaitSeconds)
{if(this._displayAverageWaitTime)
{this._updateAverageWaitTimeMessage(averageWaitSeconds);this._updateAverageWaitTimeValue(averageWaitSeconds);}},_updateAverageWaitTimeMessage:function(averageWaitSeconds)
{this._averageWaitTimeElement.set('innerHTML',averageWaitSeconds>0?this._averageWaitTimeMsg:this.data.attrs.label_average_wait_time_not_available);},_updateAverageWaitTimeValue:function(averageWaitSeconds)
{var averageWaitTimeValueElem=this.Y.one(this.baseSelector+"_AverageWaitTime_AverageWaitTime");if(!averageWaitTimeValueElem)
return;averageWaitTimeValueElem.set('innerHTML',averageWaitSeconds>0?RightNow.Chat.UI.Util.toIso8601Time(averageWaitSeconds):"");}});
RightNow.Widgets.ChatAgentStatus=RightNow.Widgets.extend({constructor:function(){this._container=this.Y.one(this.baseSelector);this._roster=this.Y.one(this.baseSelector+"_Roster");if(this._container&&this._roster)
{RightNow.Event.subscribe("evt_chatAgentStatusChangeResponse",this._onChatAgentStatusChangeResponse,this);RightNow.Event.subscribe("evt_chatEngagementParticipantAddedResponse",this._onChatEngagementParticipantAddedResponse,this);RightNow.Event.subscribe("evt_chatEngagementParticipantRemovedResponse",this._onChatEngagementParticipantRemovedResponse,this);RightNow.Event.subscribe("evt_chatStateChangeResponse",this._onChatStateChangeResponse,this);}},_onChatEngagementParticipantAddedResponse:function(type,args)
{if(!args[0].data.agent)
return;var agent=args[0].data.agent;this._roster.appendChild(this.Y.Node.create(new EJS({text:this.getStatic().templates.participantAddedResponse}).render({attrs:this.data.attrs,instanceID:this.instanceID,agentName:this.data.attrs.agent_id.replace(/{display_name}/g,agent.name),clientID:agent.clientID})));this._roster.setAttribute('aria-live','polite');RightNow.UI.show(this._container);},_onChatEngagementParticipantRemovedResponse:function(type,args)
{if(!args[0].data.agent)
return;var agent=args[0].data.agent;var element=this.Y.one(this.baseSelector+'_Agent_'+agent.clientID);if(element)
element.remove();},_onChatAgentStatusChangeResponse:function(type,args)
{if(!args[0].data.agent)
return;var agent=args[0].data.agent;var newStatusString="";switch(agent.activityStatus)
{case RightNow.Chat.Model.ChatActivityState.RESPONDING:newStatusString=this.data.attrs.label_status_responding;break;case RightNow.Chat.Model.ChatActivityState.LISTENING:newStatusString=this.data.attrs.label_status_listening;break;case RightNow.Chat.Model.ChatActivityState.ABSENT:newStatusString=this.data.attrs.label_status_absent;break;}
var statusElement=this.Y.one(this.baseSelector+'_AgentStatus_'+agent.clientID);if(statusElement)
{statusElement.setHTML(this.data.attrs.agent_id.replace(/{display_name}/g,agent.name)+"&nbsp;("+newStatusString+")");}},_onChatStateChangeResponse:function(type,args)
{if(!args[0].data.currentState)
return;var currentState=args[0].data.currentState;var ChatState=RightNow.Chat.Model.ChatState;if(currentState===ChatState.CANCELLED||currentState===ChatState.DISCONNECTED||currentState===ChatState.REQUEUED)
RightNow.UI.hide(this._container);}});
RightNow.Widgets.ChatTranscript=RightNow.Widgets.extend({constructor:function(){this._transcriptContainer=this.Y.one(this.baseSelector);this._transcript=this.Y.one(this.baseSelector+'_Transcript');this._anchorRE=new RegExp(/(<a .*?>(.*?)<\/a>)/i);this._hrefRE=new RegExp(/href\s*=\s*['"](.+?)['"]/i);this._titleRE=new RegExp(/title\s*=\s*['"](.+?)['"]/i);this._urlRE=new RegExp(/((http[s]?:\/\/|ftp:\/\/)|(www\.)|(ftp\.))([^\s<>\.\/^{^}]+)\.([^\s<>^{^}]+)/i);this._quotedUrlRE=new RegExp(/['"]+((http[s]?:\/\/|ftp:\/\/)|(www\.)|(ftp\.))([^\s<>\.\/]+)\.([^\s<>]+)['"]+/i);this._tagRE=new RegExp(/(<\/?[\w]+[^>]*>)/i);this._endUserName='';if(this._transcript)
{if(!this.data.attrs.mobile_mode)
{RightNow.Event.subscribe("evt_chatCobrowseAcceptResponse",this._coBrowseAcceptResponse,this);RightNow.Event.subscribe("evt_chatCobrowseStatusResponse",this._coBrowseStatusResponse,this);RightNow.Event.subscribe("evt_fileUploadUpdateResponse",this._fileUploadResponse,this);RightNow.Event.subscribe("evt_chatNotifyFattachUpdateResponse",this._fileNotifyResponse,this);}
RightNow.Event.subscribe("evt_chatStateChangeResponse",this._onChatStateChangeResponse,this);RightNow.Event.subscribe("evt_chatPostResponse",this._onChatPostResponse,this);RightNow.Event.subscribe("evt_chatEngagementParticipantAddedResponse",this._onChatEngagementParticipantAddedResponse,this);RightNow.Event.subscribe("evt_chatEngagementParticipantRemovedResponse",this._onChatEngagementParticipantRemovedResponse,this);RightNow.Event.subscribe("evt_chatEngagementConcludedResponse",this._onChatEngagementConcludedResponse,this);RightNow.Event.subscribe("evt_chatCobrowseInvitationResponse",this._coBrowseInvitationResponse,this);RightNow.Event.subscribe("evt_chatCoBrowsePremiumInvitationResponse",this._coBrowsePremiumInvitationResponse,this);RightNow.Event.subscribe("evt_chatReconnectUpdateResponse",this._reconnectUpdateResponse,this);RightNow.Event.subscribe("evt_chatAgentAbsentUpdateResponse",this._agentAbsentUpdateResponse,this);RightNow.Event.subscribe("evt_chatAgentStatusChangeResponse",this._onAgentStatusChangeResponse,this);RightNow.Event.subscribe("evt_chatPostCompletion",this._onChatPostCompletion,this);RightNow.Event.subscribe("evt_chatCoBrowsePremiumAcceptResponse",this._coBrowseAcceptResponse,this);this._preloadImages();this._transcript.setAttribute("aria-live","polite").setAttribute("role","log");}
if(this.data.attrs.unread_messages_titlebar_enabled)
{this._unreadCount=0;this._windowFocused=document.hasFocus?document.hasFocus():false;this._baseTitle=document.title;var Event=this.Y.Event;if(this.Y.UA.ie>0)
{Event.attach("focusin",this._onApplicationFocus,document,this);Event.attach("focusout",this._onApplicationBlur,document,this);}
else
{Event.attach("focus",this._onApplicationFocus,window,this);Event.attach("blur",this._onApplicationBlur,window,this);}}},_onChatStateChangeResponse:function(type,args)
{var currentState=args[0].data.currentState;var previousState=args[0].data.previousState;var ChatState=RightNow.Chat.Model.ChatState;var newMessage=null;if(currentState===ChatState.CONNECTED)
RightNow.UI.show(this._transcriptContainer);else if(currentState===ChatState.RECONNECTING)
{this._stateBeforeReconnect=previousState;if(previousState===ChatState.CONNECTED)
newMessage=RightNow.Interface.getMessage("COMM_RN_LIVE_SERV_LOST_PLS_WAIT_MSG");}
else if(currentState===ChatState.DISCONNECTED&&(args[0].data.reason==='RECONNECT_FAILED'||args[0].data.reason==='ERROR'))
newMessage=RightNow.Interface.getMessage("COMM_RN_LIVE_SERV_LOST_CHAT_SESS_MSG");if(currentState===ChatState.CONNECTED&&previousState===ChatState.RECONNECTING)
newMessage=RightNow.Interface.getMessage("CONNECTION_RESUMED_MSG");if(newMessage!==null)
{this._appendEJSToChat(this.getStatic().templates.systemMessage,{attrs:this.data.attrs,messages:[newMessage],context:null});}},_onChatEngagementParticipantAddedResponse:function(type,args)
{var agent=args[0].data.agent;var role=args[0].data.role;var message="";if(role==="LEAD")
{if(RightNow.Chat.UI.Util.hasLeaveScreenIssues())
{this._appendEJSToChat(this.getStatic().templates.systemMessage,{attrs:this.data.attrs,messages:[this.data.attrs.label_leave_screen_warning],context:null});}
message=': '+agent.greeting;}
else
{message=' '+this.data.attrs.label_has_joined_chat;}
this._appendEJSToChat(this.getStatic().templates.participantAddedResponse,{attrs:this.data.attrs,agentName:this._getAgentIdString(args[0].data.agent.name),role:role,message:message});},_onChatEngagementParticipantRemovedResponse:function(type,args)
{var reason=args[0].data.reason;var agent=args[0].data.agent;if(!agent)
return;this._appendEJSToChat(this.getStatic().templates.systemMessage,{attrs:this.data.attrs,messages:[this._getAgentIdString(agent.name),(args[0].data.reason===RightNow.Chat.Model.ChatDisconnectReason.TRANSFERRED_TO_QUEUE?this.data.attrs.label_has_disconnected:this.data.attrs.label_has_left_chat)],context:null});},_onChatPostResponse:function(type,args)
{var message=args[0].data.messageBody;var messageId=args[0].data.messageId;var isEndUserPost=args[0].data.isEndUserPost;var postID;var name;if(args[0].data.richText===undefined||args[0].data.richText===false)
message=this.Y.Escape.html(message).replace(/\n/g,"<br/>");else if(!this.data.attrs.mobile_mode)
message=this._formatLinks(message);if(args[0].data.isOffTheRecord)
message=this.data.attrs.label_off_the_record+' '+message;if(args[0].data.isEndUserPost)
{postID='eup_'+messageId;this._setEndUserName(args);name=this._endUserName;}
else
{postID=args[0].data.serviceFinishTime;name=this._getAgentIdString(args[0].data.agent.name);}
this._appendEJSToChat(this.getStatic().templates.chatPostResponse,{attrs:this.data.attrs,endUserName:name,agentName:name,message:message,context:args[0].data},postID);},_setEndUserName:function(args)
{if(!this._endUserName||this._endUserName==='')
{var endUser=args[0].data.endUser;if(endUser.firstName===null&&endUser.lastName===null)
{if(endUser.email===null)
this._endUserName=this.data.attrs.label_enduser_name_default_prefix;else
this._endUserName=endUser.email;}
else
{if(endUser.firstName!==null&&endUser.lastName!==null)
{var internationalNameOrder=RightNow.Interface.getConfig("intl_nameorder","COMMON");this._endUserName=internationalNameOrder?endUser.lastName+" "+endUser.firstName:endUser.firstName+" "+endUser.lastName;}
else if(endUser.firstName!==null)
{this._endUserName=endUser.firstName;}
else
{this._endUserName=endUser.lastName;}
this._endUserName+=RightNow.Interface.getMessage("NAME_SUFFIX_LBL");this._endUserName=this._endUserName.replace(/</g,"&lt;");this._endUserName=this._endUserName.replace(/>/g,"&gt;");}}},_onChatPostCompletion:function(type,args)
{var messageId=args[0];var timestamp=args[1];var post=this.Y.one('#eup_'+messageId);var insertNode;if(post)
{post.set('id',timestamp);if(post.previous()&&post.previous().get('id')>timestamp)
{insertNode=post.previous();post.remove();insertNode.insert(post,"before");}
else if(post.next()&&post.next().id<timestamp)
{insertNode=post.next();post.remove();insertNode.insert(post,"after");}}},_onChatEngagementConcludedResponse:function(type,args)
{var agent=args[0].data.agent;var messages=[];var context=null;if(args[0].data.isUserDisconnect)
{if(args[0].data.reason==='IDLE_TIMEOUT')
messages.push(RightNow.Interface.getMessage("DISCONNECTED_CHAT_DUE_INACTIVITY_MSG"));else
{messages.push(this.data.attrs.label_you);messages.push(this.data.attrs.label_have_disconnected);context=args[0].data;}}
else
{messages.push(agent.name);messages.push(this.data.attrs.label_has_disconnected);}
this._appendEJSToChat(this.getStatic().templates.systemMessage,{attrs:this.data.attrs,messages:messages,context:context});},_fileNotifyResponse:function(type,args)
{this._appendEJSToChat(this.getStatic().templates.systemMessage,{attrs:this.data.attrs,messages:[this.data.attrs.label_file_attachment_started],context:null});},_fileUploadResponse:function(type,args)
{var attachmentInfo=args[0];var message="";if(attachmentInfo.error!==0||attachmentInfo.errorMessage)
{message=this.data.attrs.label_file_attachment_error;}
else
{var fileName=attachmentInfo.name;var fileSize=Math.round((attachmentInfo.size/1024)*100)/100;message=this.data.attrs.label_file_attachment_received.replace("{0}",fileName).replace("{1}",fileSize+'KB');}
this._appendEJSToChat(this.getStatic().templates.systemMessage,{attrs:this.data.attrs,messages:[message],context:null});},_agentAbsentUpdateResponse:function(type,args)
{if(args[0].data.requeueSeconds)
this._appendEJSToChat(this.getStatic().templates.systemMessage,{attrs:this.data.attrs,messages:[RightNow.Interface.getMessage("REQUEUED_APPROXIMATELY_0_MSG").replace("{0}",args[0].data.requeueSeconds)],context:null});},_coBrowseInvitationResponse:function(type,args)
{var CoBrowseTypes=RightNow.Chat.Model.ChatCoBrowseType;var type=args[0].data.modeType;var coBrowseUrl=args[0].data.coBrowseUrl;var agent=args[0].data.agent;if(this.data.attrs.mobile_mode)
{RightNow.Widgets.ChatTranscript.sendCoBrowseResponse(false);}
else
{var message="";if(type===CoBrowseTypes.SCREEN||type===CoBrowseTypes.SCREEN_POINTER)
message=this.data.attrs.label_agent_requesting_view_desktop;else
message=this.data.attrs.label_agent_requesting_control_desktop;this._appendEJSToChat(this.getStatic().templates.cobrowseInvitationResponse,{attrs:this.data.attrs,message:message,agentName:agent.name,url:coBrowseUrl});}},_coBrowsePremiumInvitationResponse:function(type,args)
{if(this.data.attrs.mobile_mode)
{RightNow.Widgets.ChatTranscript.sendCoBrowseResponse(false);return;}
var agentEnvironment=args[0].data.agentEnvironment;var coBrowseSessionId=args[0].data.coBrowseSessionId;var agent=args[0].data.agent;this._appendEJSToChat(this.getStatic().templates.CoBrowsePremiumInvitationResponse,{attrs:this.data.attrs,message:this.data.attrs.label_agent_requesting_view_desktop,agentName:agent.name,agentEnvironment:agentEnvironment,coBrowseSessionId:coBrowseSessionId});this.Y.one(this.baseSelector).delegate('click',this.onAllowCoBrowsePremiumClick,'a.rn_CoBrowsePremiumAllow',this);this.Y.one(this.baseSelector).delegate('click',this.onDeclineCoBrowsePremiumClick,'a.rn_CoBrowsePremiumDecline',this);},_coBrowseAcceptResponse:function(type,args)
{var accepted=args[0].data.accepted;var message="";this._transcript.all('.rn_CoBrowseAction').remove();if(accepted)
message=this.data.attrs.label_initializing_screen_sharing_session;else
message=this.data.attrs.label_screen_sharing_session_declined;this._appendEJSToChat(this.getStatic().templates.systemMessage,{attrs:this.data.attrs,messages:[message],context:null});},_coBrowseStatusResponse:function(type,args)
{var ChatCoBrowseStatusCode=RightNow.Chat.Model.ChatCoBrowseStatusCode;var coBrowseStatus=args[0].data.coBrowseStatus;var message="";switch(coBrowseStatus)
{case ChatCoBrowseStatusCode.STARTED:message=this.data.attrs.label_screen_sharing_session_started;break;case ChatCoBrowseStatusCode.STOPPED:message=this.data.attrs.label_screen_sharing_session_ended;break;case ChatCoBrowseStatusCode.ERROR:var errorCode=parseInt(args[0].data.coBrowseData[0],10);if(errorCode===0)
message=this.data.attrs.label_java_not_detected;else if(errorCode===1)
message=this.data.attrs.label_java_cert_rejected;break;}
this._appendEJSToChat(this.getStatic().templates.systemMessage,{attrs:this.data.attrs,messages:[message],context:null});},_reconnectUpdateResponse:function(type,args)
{if(this._stateBeforeReconnect===RightNow.Chat.Model.ChatState.CONNECTED)
this._appendEJSToChat(this.getStatic().templates.systemMessage,{attrs:this.data.attrs,messages:[RightNow.Interface.getMessage("DISCONNECTION_IN_0_SECONDS_MSG").replace("{0}",args[0].data.secondsLeft)],context:null});},_onAgentStatusChangeResponse:function(type,args)
{var agent=args[0].data.agent;if(!agent)
return;var message=null;if(agent.activityStatus===RightNow.Chat.Model.ChatActivityState.ABSENT)
message=RightNow.Interface.getMessage("COMM_DISP_NAME_LOST_PLS_WAIT_MSG");else if(args[0].data.previousState===RightNow.Chat.Model.ChatActivityState.ABSENT)
message=RightNow.Interface.getMessage("COMM_DISPLAY_NAME_RESTORED_MSG");if(message!==null)
this._appendEJSToChat(this.getStatic().templates.agentStatusChangeResponse,{attrs:this.data.attrs,message:message,agentName:agent.name});},_preloadImages:function()
{var imageArray=[];imageArray.push(this.data.attrs.alert_icon_path);imageArray.push(this.data.attrs.agent_message_icon_path);imageArray.push(this.data.attrs.off_the_record_icon_path);if(!this.data.attrs.mobile_mode)
imageArray.push(this.data.attrs.cobrowse_icon_path);if(this.data.attrs.enduser_message_icon_path)
imageArray.push(this.data.attrs.enduser_message_icon_path);for(var x=0;x<imageArray.length;x++)
eval("var imageObject"+x+" = new Image(); imageObject"+x+".src = imageArray[x];");},_appendEJSToChat:function(postText,postData,postID)
{var newEntry=this.Y.Node.create(new EJS({text:postText}).render(postData));if(postID!==undefined)
newEntry.set("id",postID);this._transcript.appendChild(newEntry);var scrollAnim=new this.Y.Anim({node:this._transcriptContainer,to:{scroll:function(node){return[0,node.get('scrollHeight')]}}}).run();if(this.data.attrs.unread_messages_titlebar_enabled&&!this._windowFocused)
document.title='('+(++this._unreadCount)+') '+this._baseTitle;},_formatLinks:function(text)
{var newText='';var stringArray;var tempString=text;var titles={};var hrefs={};var descs={};var tags={};var quotedUrls={};var aMatches=0;var qMatches=0;var tMatches=0;var anchorMatch="";while(anchorMatch=tempString.match(this._anchorRE))
{descs[aMatches]=anchorMatch[2];stringArray=tempString.split(anchorMatch[0]);var title=anchorMatch[0].match(this._titleRE);if(title!=null)
titles[aMatches]=title[1];href=hrefs[aMatches]=anchorMatch[0].match(this._hrefRE);if(href!=null)
{hrefs[aMatches]=href[1];if(!hrefs[aMatches].match(/^(http(s)?)/i))
hrefs[aMatches]="http://"+hrefs[aMatches];newText+=stringArray[0]+"{RNTAMATCH"+aMatches+"}";aMatches++;}
if(stringArray.length>0)
{stringArray.shift();tempString=stringArray.join(anchorMatch[0]);}}
if(aMatches!==0)
{newText+=tempString;tempString=newText;newText="";}
while(urlMatch=tempString.match(this._tagRE))
{tags[tMatches]=urlMatch[0];tempString=tempString.replace(urlMatch[0],"{RNTTMATCH"+tMatches+"}");tMatches++;}
var urlMatch="";while(urlMatch=tempString.match(this._quotedUrlRE))
{quotedUrls[qMatches]=urlMatch[0];tempString=tempString.replace(urlMatch[0],"{RNTQMATCH"+qMatches+"}");qMatches++;}
while(urlMatch=tempString.match(this._urlRE))
{var href=urlMatch[0];stringArray=tempString.split(urlMatch[0]);if(urlMatch[0].match(/^ftp\./i))
href="ftp://"+urlMatch[0];else if(!urlMatch[0].match(/^(http(s)?|ftp)/i))
href="http://"+urlMatch[0];var replace="<a href='"+href+"' target='_blank'>"+urlMatch[0]+"</a>";newText+=stringArray[0]+replace;if(stringArray.length>0)
{stringArray.shift();tempString=stringArray.join(urlMatch[0]);}}
newText+=tempString;if(qMatches>0)
{for(var x=0;x<qMatches;x++)
newText=newText.replace("{RNTQMATCH"+x+"}",quotedUrls[x]);}
if(tMatches>0)
{for(var x=0;x<tMatches;x++)
newText=newText.replace("{RNTTMATCH"+x+"}",tags[x]);}
if(aMatches>0)
{for(var x=0;x<aMatches;x++)
{if(this.data.attrs.mobile_mode)
newText=newText.replace("{RNTAMATCH"+x+"}",descs[x]==null?hrefs[x]:descs[x]+' ('+hrefs[x]+')');else
newText=newText.replace("{RNTAMATCH"+x+"}","<a href='"+hrefs[x]+"' "+(titles[x]==null?"":"title=\""+titles[x]+"\" ")+" target=\"_blank\">"+(descs[x]==null?hrefs[x]:descs[x])+"</a>");}}
return newText;},_getAgentIdString:function(agentName)
{return this.data.attrs.agent_id.replace(/{display_name}/g,agentName);},_onApplicationFocus:function()
{this._windowFocused=true;this._unreadCount=0;document.title=this._baseTitle;},_onApplicationBlur:function()
{this._windowFocused=false;},onAllowCoBrowsePremiumClick:function(e)
{e.halt();var target=e.currentTarget,agentEnvironment=target.getAttribute('data-agentEnvironment'),coBrowseSessionId=target.getAttribute('data-coBrowseSessionId');RightNow.Widgets.ChatTranscript.sendCoBrowsePremiumResponse(true,agentEnvironment,coBrowseSessionId);},onDeclineCoBrowsePremiumClick:function()
{RightNow.Widgets.ChatTranscript.sendCoBrowsePremiumResponse(false);}},{sendCoBrowseResponse:function(accepted,coBrowseUrl)
{var eo=new RightNow.Event.EventObject(this,{data:{}});if(accepted)
{eo.data={coBrowseUrl:coBrowseUrl};RightNow.Event.fire('evt_chatCoBrowseAcceptRequest',eo);}
else
{RightNow.Event.fire('evt_chatCoBrowseDenyRequest',eo);}},sendCoBrowsePremiumResponse:function(accepted,agentEnvironment,coBrowseSessionId)
{var eo=new RightNow.Event.EventObject(this,{data:{}});if(accepted)
{eo.data={agentEnvironment:agentEnvironment,coBrowseSessionId:coBrowseSessionId};RightNow.Event.fire('evt_chatCoBrowsePremiumAcceptRequest',eo);}
else
{RightNow.Event.fire('evt_chatCoBrowsePremiumDenyRequest',eo);}}});
RightNow.Widgets.ChatCancelButton=RightNow.Widgets.extend({constructor:function(){this._container=this.Y.one(this.baseSelector);var cancelButton=this.Y.one(this.baseSelector+"_Button");if(cancelButton)
{cancelButton.on("click",this._onButtonClick,this);RightNow.Event.subscribe("evt_chatStateChangeResponse",this._onChatStateChangeResponse,this);}},_onButtonClick:function(type,args)
{RightNow.Event.fire("evt_chatHangupRequest",new RightNow.Event.EventObject(this,{data:{isCancelled:true,cancelingUrl:this.data.attrs.canceling_url}}));},_onChatStateChangeResponse:function(type,args)
{var currentState=args[0].data.currentState;var previousState=args[0].data.previousState;var ChatState=RightNow.Chat.Model.ChatState;if(currentState===ChatState.RECONNECTING)
return;if(currentState===ChatState.SEARCHING)
RightNow.UI.show(this._container);else
RightNow.UI.hide(this._container);}});
RightNow.Widgets.ChatRequestEmailResponseButton=RightNow.Widgets.extend({constructor:function(){this._container=this.Y.one(this.baseSelector);this._requestEmailResponseButton=this.Y.one(this.baseSelector+"_Button");this._currentState=RightNow.Chat.Model.SEARCHING;if(this._container&&this._requestEmailResponseButton)
{this._requestEmailResponseButton.on("click",this._onButtonClick,this);RightNow.Event.subscribe("evt_chatStateChangeResponse",this._onChatStateChangeResponse,this);}},_onChatStateChangeResponse:function(type,args){var reason=args[0].data.reason;var currentState=args[0].data.currentState;if((currentState===RightNow.Chat.Model.ChatState.CANCELLED&&(reason==="FAIL_NO_AGENTS_AVAIL"||reason==="QUEUE_TIMEOUT"))||currentState===RightNow.Chat.Model.ChatState.DEQUEUED||currentState===RightNow.Chat.Model.ChatState.DISCONNECTED&&reason==="NO_AGENTS_AVAILABLE")
RightNow.UI.show(this._container);else
RightNow.UI.hide(this._container);},_onButtonClick:function(type,args)
{var pageToDisplay=this.Y.Lang.trim(this.data.attrs.page_url);if(pageToDisplay===''){pageToDisplay=this.data.js.baseUrl+"/app/ask";}
window.open(pageToDisplay);}});
RightNow.Widgets.ChatSendButton=RightNow.Widgets.extend({constructor:function(){this._container=this.Y.one(this.baseSelector);var sendButton=this.Y.one(this.baseSelector+"_Button");if(sendButton)
{sendButton.on("click",this._onButtonClick,this);RightNow.Event.subscribe("evt_chatStateChangeResponse",this._onChatStateChangeResponse,this);}},_onButtonClick:function(type,args)
{RightNow.Event.fire("evt_chatSendButtonClickRequest",new RightNow.Event.EventObject(this));},_onChatStateChangeResponse:function(type,args)
{var currentState=args[0].data.currentState;var ChatState=RightNow.Chat.Model.ChatState;if(currentState===ChatState.CONNECTED)
{this._container.addClass("rn_ChatSendButtonShown");RightNow.UI.show(this._container);}
else if(currentState===ChatState.REQUEUED||currentState===ChatState.DISCONNECTED||currentState===ChatState.RECONNECTING)
{this._container.removeClass("rn_ChatSendButtonShown");RightNow.UI.hide(this._container);}}});
RightNow.Widgets.MobileNavigationMenu=RightNow.Widgets.extend({constructor:function(){this._currentlyShowing=false;this._submenu=this.Y.one("#"+this.data.attrs.submenu);if(this._submenu){this._button=this.Y.one(this.baseSelector+"_Link");this._button.on("click",this._onClick,this);RightNow.Event.subscribe("evt_navigationMenuShow",function(evt,args){if(args[0].w_id!==this.instanceID&&this._currentlyShowing){this._onClick(null,true);}},this);this._eo=new RightNow.Event.EventObject(this);}
else{RightNow.UI.addDevelopmentHeaderError('Element specified by submenu attribute does not exist.');}},_onClick:function(clickEvent,closeAll){this._initMenu();if(this._subMenuShowing){for(var i=0;i<this._contentStack.length;i++){this._contentStack[i].setStyle("display","none");}
this._submenu.setStyle("display","block");this._button.set("innerHTML",this.data.attrs.label_button);this._subMenuShowing=false;if(!closeAll)return;}
var cssFunction,displayProperty;if(this._currentlyShowing){cssFunction="removeClass";displayProperty="none";}
else{displayProperty="block";cssFunction="addClass";RightNow.Event.fire("evt_navigationMenuShow",this._eo);var panelTop=parseInt(this._submenu.getStyle("top"),10),buttonBottom=parseInt(this._button.get("offsetHeight"),10)+parseInt(this._button.get("offsetTop"),10);if(Math.abs(panelTop-buttonBottom)>5){this._submenu.setStyle("top",(buttonBottom+5)+"px");}
if(this._firstInput){this._firstInput.focus();}}
this._currentlyShowing=!this._currentlyShowing;this._panel.setStyle("display",displayProperty);this._button[cssFunction](this.data.attrs.css_class);},_toggleMenu:function(evt,itemToToggle){if(!itemToToggle.get("id")){this._idGenerator=this._idGenerator||1;itemToToggle.set("id",this.baseDomID+"_SubMenu"+this._idGenerator);this._idGenerator++;}
this._submenu.setStyle("display","none");this._panel.appendChild(itemToToggle);itemToToggle.setStyle("top",this._submenu.getStyle("top")).setStyle("display","block").removeClass("rn_Hidden").addClass("rn_PanelContent").addClass("rn_Menu").addClass("rn_MobileNavigationMenu");this._button.set("innerHTML",RightNow.Interface.getMessage("BACK_LBL"));this._subMenuShowing=true;for(var i=0,alreadyInStack;i<this._contentStack.length;i++){if(this._contentStack[i].get("id")===itemToToggle.get("id")){alreadyInStack=true;break;}}
if(!alreadyInStack){this._contentStack.push(itemToToggle);}},_initMenu:function(){if(!this._initialized){this._panel=this.Y.Node.create("<div class='rn_Panel rn_Hidden'></div>");this._panel.appendChild(this._submenu);this._submenu.setStyle("display","block").removeClass("rn_Hidden").addClass("rn_PanelContent").addClass("rn_Menu").addClass("rn_MobileNavigationMenu");this.Y.one(document.body).get("firstChild").insert(this._panel,"before");var parentMenuAltHtml="<span class='rn_ParentMenuAlt'> "+this.data.attrs.label_parent_menu_alt+"</span>";this._submenu.all("ul.rn_Submenu").each(function(subMenu){subMenu.previous().append(parentMenuAltHtml).on("click",this._toggleMenu,this,subMenu);},this);this._contentStack=[];var firstInput=this._submenu.one("input");if(firstInput&&firstInput.focus){this._firstInput=firstInput;}
this._initialized=true;}}});
RightNow.Widgets.ChatPostMessage=RightNow.Widgets.extend({constructor:function(){this.container=this.Y.one(this.baseSelector);this.input=this.Y.one(this.baseSelector+"_Input");this.isOffTheRecord=this.data.attrs.all_posts_off_the_record;this._errorDialog=null;this._vaMode=false;if(this.input)
{RightNow.Event.subscribe("evt_chatStateChangeResponse",this._onChatStateChangeResponse,this);RightNow.Event.subscribe("evt_chatSendButtonClickResponse",this.sendText,this);RightNow.Event.subscribe("evt_chatPostLengthExceededResponse",this._onChatPostLengthExceededResponse,this);RightNow.Event.subscribe("evt_chatEngagementParticipantAddedResponse",this._onChatEngagementParticipantAddedResponse,this);RightNow.Event.subscribe("evt_chatPostResponse",this._onChatPostResponse,this);this.input.on("valueChange",this._onValueChange,this);this.input.on("key",this._onEnterKey,"enter",this);}},_onChatStateChangeResponse:function(type,args)
{if(!RightNow.Event.fire("evt_handleChatStateChange",new RightNow.Event.EventObject(this,{data:args[0].data})))
return;var currentState=args[0].data.currentState;var ChatState=RightNow.Chat.Model.ChatState;if(currentState===ChatState.CONNECTED)
{this.input.set('disabled',false);RightNow.UI.show(this.container);if(this.data.attrs.initial_focus&&this.input.focus)
{top.window.focus();this.input.focus();}}
else if(currentState===ChatState.REQUEUED)
{RightNow.UI.hide(this.container);}
else if(currentState===ChatState.CANCELLED||currentState===ChatState.DISCONNECTED||currentState===ChatState.REQUEUED)
{RightNow.UI.hide(this.container);}
else if(currentState===ChatState.RECONNECTING)
{this.input.set('disabled',true);}},_onValueChange:function(e)
{var eo=new RightNow.Event.EventObject(this,{data:{keyEvent:e,inputValue:e.newVal,inputValueBeforeChange:e.prevVal,isOffTheRecord:this.isOffTheRecord}});RightNow.Event.fire("evt_chatPostMessageKeyUpRequest",eo);},_onEnterKey:function(e)
{if(e.shiftKey)
return;if(this.input.get('value')!=='\r\n')
this.sendText();else
this.input.set('value',"");e.preventDefault();if(this.data.attrs.mobile_mode)
this.input.blur();},_onChatPostLengthExceededResponse:function(type,eventObject)
{if(eventObject[0].w_id!==this.instanceID)
return;this.input.set('value',eventObject[0].data.inputValueBeforeChange).set('disabled',true);if(this._errorDialog){this._errorDialog.show();}
else{this._errorDialog=RightNow.UI.Dialog.messageDialog(RightNow.Interface.getMessage("THE_INPUT_IS_TOO_LONG_MSG"),{icon:"WARN",exitCallback:{fn:this._enableControls,scope:this}});}},_enableControls:function()
{this.input.set('disabled',false).focus();},sendText:function()
{var text=this.input.get('value');if(text.replace(/^\s*/,"").length==0||text.length>349525)
return;var c,newText="";for(i=0;i<text.length;i++)
{c=text.charCodeAt(i);if(c==RightNow.UI.KeyMap.VTAB)
newText+="\n";else if(c<32&&c!==RightNow.UI.KeyMap.LINEFEED&&c!==RightNow.UI.KeyMap.RETURN&&c!==RightNow.UI.KeyMap.TAB)
{newText+="&#00";newText+=(c<10)?"0"+c.toString():c.toString();}
else if(c=='<')
newText+="&lt;";else if(c=='>')
newText+="&gt;";else
newText+=text.substr(i,1);}
text=newText;this.input.set('value',"");if(this._vaMode)
this.input.set('disabled',true);var eo=new RightNow.Event.EventObject(this,{data:{messageBody:text,isEndUserPost:true,isOffTheRecord:this.isOffTheRecord}});RightNow.Event.fire("evt_chatPostMessageRequest",eo);if(!this.data.attrs.mobile_mode)
this.input.focus();},_onChatPostResponse:function(type,args)
{if(!args[0].data.isEndUserPost)
{this.input.set('disabled',false);if(this.data.attrs.focus_on_incoming_messages)
{top.window.focus();this.input.focus();}
else if(this._vaMode)
{this.input.focus();}}},_onChatEngagementParticipantAddedResponse:function(type,args)
{this._vaMode=args[0].data.virtualAgent===undefined?false:args[0].data.virtualAgent;}});