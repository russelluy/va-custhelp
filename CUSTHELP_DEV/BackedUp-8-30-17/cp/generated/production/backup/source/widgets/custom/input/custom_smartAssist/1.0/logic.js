RightNow.namespace('Custom.Widgets.input.custom_smartAssist');
Custom.Widgets.input.custom_smartAssist = RightNow.Field.extend({
    overrides: {
        constructor: function() {
            this.parent();
		//	document.getElementsByName("yui_3_13_0_3_1457024751570_68").style.display = "none";

            try {
                this.parentForm().on("response", this._displayResults, this);
                //We need to store this ID off since when the dialog is popped, this widget is no longer within the form element and therefore
                //can't call the form (re)submit event. We'll use this later to tell the parentForm() function which ID to use
                this._parentFormID = this.getParentFormID();
            }
            catch (e) {
                // Widget appears outside of a form tag
                RightNow.Event.on('evt_formButtonSubmitResponse', this._displayResults, this);
            }
            RightNow.UI.Form.smartAssistant = true;
        }
    },
    /**
     * Event handler for when form submission returns from the server.
     * This function only handles a server response that contains
     * SmartAssistant result data.
     * @param evt string Event name
     * @param args object Event arguments
     */
    _displayResults: function(evt, args)
    {
        var result = args[0];
        if(result && result.data && result.data.result && result.data.result.sa)
        {
            if (!this._parentFormID && result.data.form)
            {
                this._parentFormID = result.data.form;
            }
            var sessionParameter = result.data.result.sessionParm;
            result = result.data.result.sa;
            if(result.token){
                RightNow.UI.Form.smartAssistantToken = result.token;
            }
            RightNow.UI.Form.smartAssistant = false;
            this._doNotCreateIncident = !result.canEscalate;
            var dialogHeading = this.Y.one("#rn_" + this.instanceID + "_DialogHeading");
            if(dialogHeading)
                dialogHeading.set("innerHTML", this.data.attrs.label_banner);

            var saDisplay = "",
                accessKeyPrompt = "",
                displayButton = true,
                inlineContent = false,
                inlineAnswers = false,
                suggestions = result.suggestions,
                i;

            if(suggestions && suggestions.length > 0)
            {
                var suggestion;
                for(i = 0; i < suggestions.length; i++)
                {
                    suggestion = suggestions[i];
                    if(suggestion.type === 'AnswerSummary')
                    {
                        if(this.data.attrs.accesskeys_enabled && this.data.attrs.label_accesskey && this.data.attrs.display_answers_inline)
                        {
                            var keyComboString = RightNow.Interface.getMessage("ACCESSKEY_LBL"),
                                UA = this.Y.UA,
                                OS = UA.os;

                            if(UA.ie)
                                keyComboString = RightNow.Interface.getMessage("ALT_LBL");
                            else if (UA.gecko)
                                keyComboString = (OS === "windows" || !OS) ? RightNow.Interface.getMessage("ALT_PLUS_SHIFT_LBL") : RightNow.Interface.getMessage("CTRL_LBL");
                            else if (UA.webkit)
                                keyComboString = (OS === "windows" || !OS) ? RightNow.Interface.getMessage("ALT_LBL") : RightNow.Interface.getMessage("CTRL_PLUS_OPT_LBL");

                            accessKeyPrompt = RightNow.Text.sprintf("<span class='rn_ScreenReaderOnly'>" + this.data.attrs.label_accesskey + "</span>", keyComboString, suggestion.list.length);
                        }
                        if(this.data.attrs.display_answers_inline)
                            inlineAnswers = true;
                    }
                    else
                    {
                        inlineContent = true;
                    }
                }
                //Build up data array for the EJS view.
                var data = {
                    'suggestions' : suggestions,
                    'accessKeyPrompt' : accessKeyPrompt,
                    'sessionParm' : sessionParameter || '',
                    'baseDomID' : this.baseDomID,
                    'attrs' : {
                        'label_prompt' : this.data.attrs.label_prompt,
                        'accesskeys_enabled' : this.data.attrs.accesskeys_enabled,
                        'label_accesskey' : this.data.attrs.label_accesskey,
                        'display_answers_inline' : this.data.attrs.display_answers_inline,
                        'label_collapsed' : this.data.attrs.label_collapsed
                    },
                    'answerUrl' : RightNow.Interface.getConfig('CP_ANSWERS_DETAIL_URL')
                };

                saDisplay = new EJS({text: this.getStatic().templates.displayResults}).render(data);
            }
            else
            {
                saDisplay = this.data.attrs.label_no_results;
            }
            if(this._doNotCreateIncident)
            {
                RightNow.ActionCapture.record('incident', 'doNotCreateState');
                //Reset the SA to always display if they are in the DNC case
                RightNow.UI.Form.smartAssistant = true;
                if(this.data.attrs.dnc_label_banner && dialogHeading)
                    dialogHeading.set("innerHTML", this.data.attrs.dnc_label_banner);
                displayButton = false;
            }

            //Create the dialog box, set up the event handlers, and populate it with the generated HTML.
            this._dialogBody = this.Y.one(this.baseSelector);
            if(this._dialogBody)
            {
                var handlers = {
                        label_submit_button: {
                            fn: function(){
                                    //notify FormSubmit widget to re-submit
                                    this._dialog.hide();
									/*console.log(this.parentForm);*/
                                    /*this.parentForm(this._parentFormID).fire("submitRequest");*/
									//fname= document.getElementById("user_first_name").value;
									
									/*first_name= document.getElementById("rn_TextInput_3_Contact.Name.First").value;
									last_name= document.getElementById("rn_TextInput_5_Contact.Name.Last").value;
									emaildt =  document.getElementById("rn_TextInput_7_Contact.Emails.PRIMARY.Address").value;
									subject =  document.getElementById("rn_TextInput_9_Incident.Subject").value;*/
									
									first_name = document.getElementsByName("Contact.Name.First")[0].value;
									last_name = document.getElementsByName("Contact.Name.Last")[0].value;
									emaildt = document.getElementsByName("Contact.Emails.PRIMARY.Address")[0].value;
									subject = document.getElementsByName("Incident.Subject")[0].value;
									
									
									
//----------------Chat popup with width and height------------------//	

//window.location.href="http://virginamerica--tst.custhelp.com/app/chat/chat_landing/Contact.Name.First/"+first_name+"/Contact.Name.Last/"+last_name+"/Contact.Email.0.Address/"+emaildt+"/Incident.Subject/"+subject+"/";
									window.open("http://virginamerica.custhelp.com/app/chat/chat_landing/Contact.Name.First/"+first_name+"/Contact.Name.Last/"+last_name+"/Contact.Email.0.Address/"+emaildt+"/Incident.Subject/"+subject+"/", "Ratting","width=500,height=650,0,status=0");
									
									
//------------------------chat popup end----------------------------//



                                },
                            scope: this
                        },
                        label_cancel_button:{
                            fn: function(){
                                    if(!this._doNotCreateIncident || !this.data.attrs.dnc_redirect_url)
                                        this._dialog.hide();
                                    else
                                        RightNow.Url.navigate(this.data.attrs.dnc_redirect_url);
                                },
                            scope: this
                        },
                        label_solved_button: {
                            fn: function(){
                                    RightNow.ActionCapture.record('incident', 'deflect');
                                    RightNow.ActionCapture.flush(function(){
                                        var redirectUrl = this.data.attrs.solved_url;
                                        if(RightNow.UI.Form.smartAssistantToken && RightNow.Text.beginsWith(redirectUrl, '/app')){
                                            redirectUrl = RightNow.Url.addParameter(redirectUrl, 'saResultToken', RightNow.UI.Form.smartAssistantToken);
                                        }
                                        RightNow.Url.navigate(redirectUrl);
                                    }, this);
                                },
                            scope: this
                        }
                    },
                    dialogContent = this.Y.one("#rn_" + this.instanceID + "_DialogContent"),
					
                    buttons = [],
                    links = [],
                    buttonOrder = this.data.attrs.button_ordering,
                    index = 0,
                    button;
					console.log(this.Y.one("#rn_" + this.instanceID + "_DialogContent"));

                if(displayButton)
                {
                    for(i = 0; i < buttonOrder.length; i++)
                    {
                        button = buttonOrder[i];
                        buttons.push({text: button.label, handler: handlers[button.name], isDefault: (buttons.length === 0)});
                        if(button.displayAsLink)
                        {
                            // keep track of the button's index and click handler for the button's replacement later
                            links.push({index: index, handler: handlers[button.name], label: button.label});
                        }
                        index++;
                    }
                }
                else if(this.data.attrs.label_cancel_button)
                {
                    buttons.push({text: (this._doNotCreateIncident && this.data.attrs.dnc_label_cancel_button) ? this.data.attrs.dnc_label_cancel_button : this.data.attrs.label_cancel_button, handler: handlers.label_cancel_button, isDefault: true});
                }

                if(dialogContent)
                {
                    dialogContent.set("innerHTML", saDisplay);
                    if(inlineAnswers)
                        this._enableInlineAnswers();
                    if(inlineContent || !inlineAnswers)
                        this._modifyLinkTargets(dialogContent);
                }

                this._dialog = RightNow.UI.Dialog.actionDialog((this._doNotCreateIncident && this.data.attrs.dnc_label_dialog_title) ? this.data.attrs.dnc_label_dialog_title : this.data.attrs.label_dialog_title, this._dialogBody, {"buttons": buttons, "width": this.data.attrs.dialog_width || ''});
                this.Y.one('#' + this._dialog.id).addClass("rn_SmartAssistantDialogContainer");
                RightNow.UI.show(this._dialogBody);
                if(links.length)
                {
                    // replace buttons with equivalent links
                    var dialogButtons = this._dialog.getButtons(),
                        link, handler, buttonContainer;
                    for(i = 0; i < links.length; i++)
                    {
                        button = dialogButtons.item ? dialogButtons.item(links[i].index) : dialogButtons[links[i].index];
                        handler = links[i].handler;
                        /*link = this.Y.Node.create("<a href='javascript:void(0);'>" + links[i].label + "</a>");
                        link.on('click', (typeof handler === "function") ? handler : handler.fn, links[i].handler.scope || this._dialog);*/
                        buttonContainer = button.get('parentNode') || null;
                        if(buttonContainer)
                        {
                            button.insert(link, 'after');
                            button.remove();
                        }
                    }
                }
                this._dialog.show();
            }
        }
		
		var elm= document.getElementsByClassName("yui3-button-close");// hides close button
		elm[0].hidden = true;
    },

    /**
     * Sets target attribute of all links to "_blank" to force links to a new window.
     * @param rootElement - YUI3 Node for which you want the links modified
     */
    _modifyLinkTargets: function(rootElement)
    {
        rootElement.all('a').setAttribute("target", "_blank");
    },

    /**
     * Declares the event listener for when the links specified are clicked.
     */
    _enableInlineAnswers: function()
    {
        this._answersLoaded = {};
        this.Y.one(this.baseSelector + ' .rn_List').delegate('click', function(evt)
        {
            var clicked = evt.target,
                answerID = clicked.getAttribute('data-id');

            //Non-answer expander was clicked, let it work like normal
            if(answerID === ""){
                return;
            }
            evt.halt();
            if(this._showingAnswer === clicked)
                return;

            //If the answer isn't already loaded, make an AJAX request to get it.
            if(typeof this._answersLoaded[answerID] === "undefined")
            {
                clicked.append("<span class='rn_Loading' aria-live='assertive'><span class='rn_ScreenReaderOnly'>" + RightNow.Interface.getMessage("LOADING_ELLIPSES_LBL") + "</span></span>");
                this._showingAnswer = clicked;
                if(this._dialogBody)
                    this._dialogBody.setAttribute("aria-busy", "true");
                var eventObject = new RightNow.Event.EventObject(this, {data: {answerID: answerID}});
                if(RightNow.Event.fire('evt_getAnswerRequest', eventObject)){
                    RightNow.Ajax.makeRequest(this.data.attrs.get_answer_content, eventObject.data, {successHandler: this._displayAnswerContent, scope: this, data: eventObject, json: true, isResponseObject: true});
                }
            }
            //If it's loaded, toggle the display
            else
            {
                this._toggleAnswerContent(answerID, !this._answersLoaded[answerID]);
            }
        }, 'li', this);
    },

    /**
    * Event subscriber for when an answer is returned from the server.
    * @param {Object} response Response object from the server containing answer data for the clicked ID.
    */
    _displayAnswerContent: function(response, originalEventObject)
    {
        if(RightNow.Event.fire("evt_getAnswerResponse", {data: originalEventObject, response: response})){
            //Make sure the response is hitting the correct widget, is expected, matches the showing answer and has legitimate answer data.
            if(this._showingAnswer && this._showingAnswer.get("id").indexOf(response.ID) > -1 && response.ID)
            {
                var answerWrapper,
                    url = response.URL,
                    contents = response.Solution,
                    // @codingStandardsIgnoreStart
                    fileAttachmentID = response.FileAttachments ? response.FileAttachments['0'].ID : null;
                    // @codingStandardsIgnoreEnd

                this._answersLoaded[response.ID] = true;
                if(fileAttachmentID)
                    contents = "<a href='/ci/fattach/get/" + fileAttachmentID + "\'>" + RightNow.Interface.getMessage("DOWNLOAD_ATTACHMENT_CMD") + "</a>";
                else if(url)
                    contents = "<a href='" + url + "'>" + url + "</a>";
                answerWrapper = this.Y.Node.create("<span id='" + this.baseDomID + "_AnswerContent" + response.ID + "' class='rn_Answer rn_AnswerDetail rn_Hidden'>" + ((response.Question) ? "<span class='rn_AnswerSummary'>" + response.Question + "</span>" : "") + "<span class='rn_AnswerSolution'>" + contents + "</span></span>");
                this._modifyLinkTargets(answerWrapper);
                this._showingAnswer.insert(answerWrapper, "after");
                this._showingAnswer.removeChild(this._showingAnswer.get("lastChild"));
                this._showingAnswer = null;
                this._toggleAnswerContent(response.ID, true);
                if(this._dialog.resizeToWindow)
                    this._dialog.resizeToWindow();
                if(this._dialogBody)
                    this._dialogBody.setAttribute("aria-busy", "false");
                RightNow.ActionCapture.record('answer', 'view', response.ID);
                RightNow.ActionCapture.record('smartAssistantResult', 'view', response.ID);
            }
        }
    },

    /**
    * Handles the accordion-link toggling display of expanded answer details.
    * @param answerID int The answer id of the answer to toggle
    * @param expand boolean T to expand the answer F to hide the answer
    */
    _toggleAnswerContent: function(answerID, expand)
    {
        var id = this.baseSelector + "_Answer",
            toggle = this.Y.one(id + answerID),
            answer = this.Y.one(id + "Content" + answerID),
            alt = this.Y.one(id + answerID + "_Alternative");
        if(expand)
        {
            for(var i in this._answersLoaded)
            {
                if(this._answersLoaded.hasOwnProperty(i) && i != answerID && this._answersLoaded[i] === true)
                {
                    //hide any currently-expanded answers
                    this.Y.one(id + i).replaceClass("rn_ExpandedAnswer", "rn_ExpandAnswer");
                    this.Y.one(id + "Content" + i).replaceClass("rn_ExpandedAnswerContent", "rn_Hidden");
                    this.Y.one(id + i + "_Alternative").set("innerHTML", this.data.attrs.label_collapsed);
                    this._answersLoaded[i] = false;
                }
            }

            answer.replaceClass("rn_Hidden", "rn_ExpandedAnswerContent");
            toggle.replaceClass("rn_ExpandAnswer", "rn_ExpandedAnswer");
            alt.set("innerHTML", this.data.attrs.label_expanded);

            if(!this.Y.DOM.contains(window, this.Y.Node.getDOMNode(toggle)))
            {
                //mobile: scroll to the top of the expanded item
                //iOS: doesn't properly implement view properties but does properly implement auto-scrolling
                if(toggle.getY() <= 0 && toggle.scrollIntoView)
                    toggle.scrollIntoView();
                //Android: doesn't properly implement auto-scrolling but does properly implement view properties
                else
                    window.scrollTo(0, toggle.getY() - 20); //20px buffer above
                //WebOS: doesn't properly implement anything...
            }
        }
        else //collapse
        {
            answer.replaceClass("rn_ExpandedAnswerContent", "rn_Hidden");
            toggle.replaceClass("rn_ExpandedAnswer", "rn_ExpandAnswer");
            alt.set("innerHTML", this.data.attrs.label_collapsed);
        }
        this._answersLoaded[answerID] = expand;
    }
	
	
});