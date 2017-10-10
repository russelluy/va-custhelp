 /* Originating Release: May 2016 */
RightNow.Widgets.FormSubmit = RightNow.Form.extend({
    overrides: {
        constructor: function() {
            this.parent();

            this._formButton = this.Y.one(this.baseSelector + "_Button");
            this._formSubmitFlag = this.Y.one(this.baseSelector + "_Submission");

            if(!this._formButton || !this._formSubmitFlag) return;

            //if value's been set, then the form's already been submitted
            if(this._formSubmitFlag.get("checked")) {
                this._formButton.set("disabled", "true");
                return;
            }

            // 'submitResponse' - Fired if a Field widget wishes to initiate a form submission programmatically
            this.on("validation:fail", this._onFormValidationFail, this)
                .on("validation:pass", this._onFormValidated, this)
                .on("response", this._formSubmitResponse, this)
                .on("responseError", this._onErrorResponse, this)
                .on("submitRequest", this._onButtonClick, this)
                .on("formUpdated", this._onFormUpdated, this);

            this._toggleClickListener(true);

            RightNow.Event.subscribe("evt_formTokenUpdate", this._onFormTokenUpdate, this);
            this._enableFormExpirationWatch();
        }
    },

    /**
     * Handles when user clicks the submit button.
     * @param {Object=} evt Click event or null if called programmatically
     */
    _onButtonClick: function(evt) {
        if (evt && evt.halt) {
            evt.halt();
        }
        if (this._requestInProgress) return false;

        this._toggleClickListener(false);

        //Reset form errors
        this._errorMessageDiv.addClass("rn_Hidden").set("innerHTML", "");

        //since the form is submitted by script, deliberately tell IE to do auto completion of the form data
        if (this.Y.UA.ie && window.external && "AutoCompleteSaveForm" in window.external) {
            window.external.AutoCompleteSaveForm(document.getElementById(this._parentForm));
        }
        this._fireSubmitRequest();
    },

    _fireSubmitRequest: function() {
        var eo = new RightNow.Event.EventObject(this, {data: {
            form: this._parentForm,
            f_tok: this.data.js.f_tok,
            error_location: this._errorMessageDiv.get("id"),
            timeout: this.data.attrs.timeout * 1000
        }});
        RightNow.Event.fire("evt_formButtonSubmitRequest", eo);
        this.fire("collect", eo);
    },

    /**
     * Event handler for when form has been validated.
     */
    _onFormValidated: function() {
        this._toggleLoadingIndicators();
        this.fire("send", this.getValidatedFields());
    },

    /**
     * Event handler for when form fails validation check.
     */
    _onFormValidationFail: function() {
        // give error div a common error message CSS class
        this._errorMessageDiv.addClass("rn_MessageBox").addClass("rn_ErrorMessage").removeClass("rn_Hidden").scrollIntoView();
        window.scrollTo(0, this.Y.DOM.docScrollY());
        var firstField = this._errorMessageDiv.one("a");

        if (firstField) {
            // Focus first link in the error box.
            firstField.focus();
            // If tabIndex had previously been set via the
            // else case (during a different failure) then remove it now.
            this._errorMessageDiv.removeAttribute('tabIndex');
        }
        else {
            // The error box doesn't have any links, so focus on the box itself.
            // Setting tabIndex to 0 on an element that's not normally tab-focusable gives
            // it normal tab flow in the document.
            this._errorMessageDiv.set('tabIndex', 0);
            this.Y.Lang.later(500, this, function() {
                // Focusing 1/2 second later helps screen readers announce the message correctly.
                this._errorMessageDiv.focus();
            });
        }

        this._toggleClickListener(true);
        this._toggleLoadingIndicators(false);

        RightNow.Event.fire("evt_formValidateFailure", new RightNow.Event.EventObject(this));
    },

    /**
     * Event handler for when form submission returns from the server
     * @param {String} type Event name
     * @param {Array} args Event arguments
     */
    _formSubmitResponse: function(type, args) {
        var responseObject = args[0].data,
            result;

        if (!responseObject) {
            // Didn't get any kind of a response object back; that's... unexpected.
            this._displayErrorDialog(RightNow.Interface.getMessage('ERROR_REQUEST_ACTION_COMPLETED_MSG'));
        }
        else if (responseObject.errors) {
            // Error message(s) on the response object.
            var errorMessage = "";
            this.Y.Array.each(responseObject.errors, function(error) {
                errorMessage += "<div><b>" + error + "</b></div>";
            });
            this._errorMessageDiv.append(errorMessage);
            this._onFormValidationFail();
        }
        else if (responseObject.result) {
            result = responseObject.result;

            if (result.sa) {
                // trap SmartAssistant™ case here
                if(result.newFormToken) {
                    // Check if a new form token was passed back and use it the next time the the form is submitted
                    this.data.js.f_tok = result.newFormToken;
                    RightNow.Event.fire("evt_formTokenUpdate", new RightNow.Event.EventObject(this, {data: {newToken: result.newFormToken}}));
                }
            }
            else if (result.transaction || result.redirectOverride) {
                // success
                this._formSubmitFlag.set("checked", true);

                var navigateToUrl = function() {
                    var url;

                    if (result.redirectOverride) {
                        url = result.redirectOverride + result.sessionParam;
                    }
                    else if (this.data.attrs.on_success_url) {
                        var paramsToAdd = '';
                        this.Y.Object.each(result.transaction, function(details) {
                            if (details.key) {
                                paramsToAdd += '/' + details.key + '/' + details.value;
                            }
                        });

                        if (paramsToAdd) {
                            url = this.data.attrs.on_success_url + paramsToAdd + result.sessionParam;
                        }
                        else {
                            var sessionValue = result.sessionParam.substr(result.sessionParam.lastIndexOf("/") + 1);
                            if(!sessionValue && this.data.js.redirectSession)
                                sessionValue = this.data.js.redirectSession;
                            url = RightNow.Url.addParameter(this.data.attrs.on_success_url, 'session', sessionValue);
                        }
                    }
                    else {
                        url = window.location + result.sessionParam;
                    }
                    RightNow.Url.navigate(url + this.data.attrs.add_params_to_url);
                };

                if(this.data.attrs.label_confirm_dialog !== '') {
                    // either create confirmation dialog
                    RightNow.UI.Dialog.messageDialog(this.data.attrs.label_confirm_dialog, {exitCallback: {fn: navigateToUrl, scope: this}, width: '250px'});
                }
                else {
                    // or go directly to the next page
                    navigateToUrl.call(this);
                }
                return;
            }
            else {
                // Response object with a result, but not the result we expect.
                this._displayErrorDialog();
            }
        }
        else {
            // Response object didn't have a result or errors on it.
            this._displayErrorDialog();
        }

        this._toggleLoadingIndicators(false);
        this._toggleClickListener(true);

        args[0].data || (args[0].data = {});
        args[0].data.form = this._parentForm;
        RightNow.Event.fire('evt_formButtonSubmitResponse', args[0]);
    },

    /**
     * Triggered when the form is updated by the dynamic forms API. If the error
     * div is now empty, hide it from the page.
     */
    _onFormUpdated: function() {
        if(this._errorMessageDiv.all('[data-field]').size() === 0) {
            this._errorMessageDiv.addClass("rn_Hidden").set("innerHTML", "");
        }
    },

    /**
     * Handler for the `responseError` form event.
     * If any non-HTTP 200 OK response is received, display a generic error
     * message and reset the form for resubmission.
     * The event object's `data` property contains the full AJAX response object
     * for the request.
     */
    _onErrorResponse: function() {
        this._displayErrorDialog(RightNow.Interface.getMessage('ERROR_REQUEST_ACTION_COMPLETED_MSG'));
        this._toggleLoadingIndicators(false);
        this._toggleClickListener(true);
    },

    /**
     * Displays a generic error dialog.
     * @param {string=} message Error message to use; if not supplied
     * a generic 'Error - please try again' message is displayed
     */
    _displayErrorDialog: function(message) {
        RightNow.UI.Dialog.messageDialog(message || RightNow.Interface.getMessage('ERROR_PAGE_PLEASE_S_TRY_MSG'), {icon: "WARN"});
    },

    /**
     * Handles response from successful getFormToken request
     * @param type {string} Type/name of event
     * @param args {array} Contains an EventObject
     */
    _onFormTokenUpdate: function(type, args) {
        var eventObject = args[0];
        if (eventObject.data.newToken && this.instanceID === eventObject.w_id) {
            this.data.js.f_tok = eventObject.data.newToken;
        }
        this._enableFormExpirationWatch();
    },

    /**
    * Handles form expiration. Five minutes before the form token expires displays a dialog.
    * Upon confirmation, retrieves a fresh token. Repeat.
    */
    _enableFormExpirationWatch: function() {
        if(this.data.js.formExpiration >= 300000) {
            //form expiration must be at least 5 minutes in the future;
            //if it's less than that? then there's no good way to handle form expiration (Type faster! Oops, too late!)
            var fiveMinutesBeforeExpiring = function() {
                this.Y.Lang.later(this.data.js.formExpiration, this, function() {
                    RightNow.UI.Dialog.messageDialog(RightNow.Interface.getMessage("FORM_EXP_PLS_CONFIRM_WISH_CONTINUE_MSG"), {icon: "WARN", exitCallback: {fn: function(){
                        // get a new f_tok
                        RightNow.Event.fire("evt_formTokenRequest",
                            new RightNow.Event.EventObject(this, {data:{formToken:this.data.js.f_tok}}));
                    }, scope: this}});
                });
            };
            fiveMinutesBeforeExpiring.call(this);
        }
    },

    /**
     * Hides / shows the loading icon and status message.
     * @param {Boolean=} turnOn Whether to turn on the loading indicators (T),
     * remove the loading indicators (F), or toggle their current state (default) (optional)
     */
    _toggleLoadingIndicators: function(turnOn) {
        var classFunc = ((typeof turnOn === "undefined") ? "toggleClass" : ((turnOn === true) ? "removeClass" : "addClass")),
            loading = this.Y.one(this.baseSelector + "_LoadingIcon"),
            message = this.Y.one(this.baseSelector + "_StatusMessage");
        if (loading) {
            loading[classFunc]("rn_Hidden");
        }
        if (message) {
            message[classFunc]("rn_Hidden").setAttribute("aria-live", (message.hasClass("rn_Hidden")) ? "off" : "assertive");
        }
    },

    /**
    * Enables / disables the form submit button and adds / removes its onclick listener.
    * @param {Boolean} To enable or disable the button
    */
    _toggleClickListener: function(enable) {
        this._formButton.set("disabled", !enable);
        this._requestInProgress = !enable;
        this.Y.Event[((enable) ? "attach" : "detach")]("click", this._onButtonClick, this._formButton, this);
    }
});
