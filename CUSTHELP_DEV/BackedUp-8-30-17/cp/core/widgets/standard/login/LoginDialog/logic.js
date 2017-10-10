 /* Originating Release: May 2016 */
RightNow.Widgets.LoginDialog = RightNow.Widgets.extend({
    constructor: function() {
        this._dialog = this._keyListener = null;
        this._errorDisplay = this.Y.one(this.baseSelector + "_ErrorMessage");
        this._container = this.Y.one(this.baseSelector);

        var loginLink = this.Y.one("#" + this.data.attrs.trigger_element);
        if(loginLink) {
            if(this.data.js.loginLinkOverride)
                loginLink.set('href', this.data.js.loginLinkOverride);
            else
                loginLink.on("click", this._onLoginTriggerClick, this);
        }
        else {
            RightNow.UI.addDevelopmentHeaderError("Error with LoginDialog widget, trigger_element attribute value was set to '" +
                this.data.attrs.trigger_element + "', but an element with that ID doesn't exist on the page.");
        }
    },
    /**
     * Event handler for when login control is clicked
     * @param type Object The event type
     * @param arg Object The event arguments
     */
    _onLoginTriggerClick: function(){
        if(!this._dialog) {
            this._dialog = RightNow.UI.Dialog.actionDialog(this.data.attrs.label_dialog_title,
                                document.getElementById("rn_" + this.instanceID),
                                {buttons: [{text: this.data.attrs.label_login_button, handler: {fn:this._onSubmit, scope:this}},
                                           {text: this.data.attrs.label_cancel_button, handler: {fn:this._onCancel, scope:this}}]}
            );
            // Set up keylistener for <enter> to run onSubmit()
            this._keyListener = RightNow.UI.Dialog.addDialogEnterKeyListener(this._dialog, this._onSubmit, this, 'input');
            //override default YUI validation to return false: don't want YUI to try to submit the form
            this._dialog.validate = function() { return false; };
            RightNow.UI.show(this._container);
            //Perform dialog close cleanup if the [x] cancel button or esc is used
            this._dialog.cancelEvent.subscribe(this._onCancel, null, this);
        }
        else if(this._errorDisplay)
        {
            this._errorDisplay.set("innerHTML", "");
        }

        this._dialog.show();

        this._usernameField = this._usernameField || this.Y.one(this.baseSelector + "_Username");
        this._passwordField = this._passwordField || this.Y.one(this.baseSelector + "_Password");

        var focusElement = ((this._usernameField && this._usernameField.get("value") === "") ? this._usernameField : this._passwordField);
        if(focusElement)
        {
            RightNow.UI.Dialog.enableDialogControls(this._dialog, this._keyListener);
            focusElement.focus();
        }
    },

    /**
     * User cancelled. Close up shop.
     */
    _onCancel: function(){
        // Get rid of any existing error message, so it's gone if the user opens the dialog again.
        if(this._errorDisplay)
        {
            this._errorDisplay.set("innerHTML", "").removeClass("rn_MessageBox rn_ErrorMessage");
        }
        // disable the key listener & buttons
        if(this._dialog)
        {
            RightNow.UI.Dialog.disableDialogControls(this._dialog, this._keyListener);
            this._dialog.hide();
        }
    },

    /**
     * Event handler for when login form is submitted
     */
    _onSubmit: function(){
        var username = (this._usernameField) ? this.Y.Lang.trim(this._usernameField.get("value")) : "",
            password = (!this.data.attrs.disable_password && this._passwordField) ? this._passwordField.get("value") : "",
            errorMessage = "", eventObject;

        if(username.indexOf(' ') > -1)
            errorMessage = RightNow.Text.sprintf(RightNow.Interface.getMessage("PCT_S_MUST_NOT_CONTAIN_SPACES_MSG"), RightNow.Interface.getMessage("USERNAME_LBL"));
        else if(username.indexOf('"') > -1)
            errorMessage = RightNow.Text.sprintf(RightNow.Interface.getMessage("PCT_S_CONTAIN_DOUBLE_QUOTES_MSG"), RightNow.Interface.getMessage("USERNAME_LBL"));
        else if(username.indexOf("<") > -1 || username.indexOf(">") > -1)
            errorMessage = RightNow.Text.sprintf(RightNow.Interface.getMessage("PCT_S_CNT_THAN_MSG"), RightNow.Interface.getMessage("USERNAME_LBL"));

        if(errorMessage !== "")
        {
            this._addErrorMessage(errorMessage, this._usernameField.get("id"));
            return;
        }

        eventObject = new RightNow.Event.EventObject(this, {data: {
           login: username,
           password: password,
           url: window.location.pathname,
           w_id: this.data.info.w_id
        }});
        if(RightNow.Event.fire("evt_loginFormSubmitRequest", eventObject))
        {
            this._toggleLoading(true);
            // disable login and cancel buttons
            RightNow.UI.Dialog.disableDialogControls(this._dialog, this._keyListener);

            if(RightNow.Event.noSessionCookies()) {
                //Attempt to set a test login cookie
                RightNow.Event.setTestLoginCookie();
            }
            RightNow.Ajax.makeRequest(this.data.attrs.login_ajax, eventObject.data, {successHandler: this._onResponseReceived, scope: this, data: eventObject, json: true});

            //since this form is submitted by script, force ie to do auto-complete
            if(this.Y.UA.ie > 0)
            {
                if(window.external && "AutoCompleteSaveForm" in window.external)
                {
                    window.external.AutoCompleteSaveForm(document.getElementById(this.baseDomID + "_Form"));
                }
            }
        }
    },

    /**
     * Event handler for when login has returned. Handles either successful login or failed login
     * @param response {Object} Result from server
     * @param originalEventObject {Object} Original request object sent in request
     */
    _onResponseReceived: function(response, originalEventObject){
        if(!RightNow.Event.fire("evt_loginFormSubmitResponse", {data: originalEventObject, response: response})){
            return;
        }

        this._toggleLoading(false);

        if(response.success == 1)
        {
            this._dialog.setFooter("");
            // TK Replace w/ this
            // this._dialog.set("footerContent", "");
            this._container && this._container.set("innerHTML", response.message);
            RightNow.Url.navigate(this._getRedirectUrl(response));
        }
        else
        {
            // enable buttons to allow the form to be re-submitted
            RightNow.UI.Dialog.enableDialogControls(this._dialog, this._keyListener);
            this._addErrorMessage(response.message, this._usernameField.get("id"), response.showLink);
        }
    },

    /**
     * Calculates the URL to redirect the user to after a login
     * @param result Object The result information returned from the server
     * @return String The URL to redirect to
     */
    _getRedirectUrl: function(result){
        var redirectUrl;
        result.sessionParm = RightNow.Text.getSubstringAfter(result.sessionParm, 'session/');
        if(this.data.js && this.data.js.redirectOverride){
            redirectUrl = RightNow.Url.addParameter(this.data.js.redirectOverride, 'session', result.sessionParm);
        }
        else{
            redirectUrl = this.data.attrs.redirect_url || result.url;
            if(result.addSession)
                redirectUrl = RightNow.Url.addParameter(redirectUrl, 'session', result.sessionParm);
        }
        redirectUrl += this.data.attrs.append_to_url;

        if (result.forceRedirect) {
            redirectUrl = RightNow.Url.addParameter(result.forceRedirect, 'redirect', encodeURIComponent(redirectUrl));
        }

        return redirectUrl;
    },

    /**
     * Adds an error message to the page and adds the correct CSS classes
     * @param message string The error message to display
     * @param focusElement HTMLElement The HTML element to focus on when the error message link is clicked
     * @param showLink Boolean Denotes if error message should be surrounded in a link tag
     */
    _addErrorMessage: function(message, focusElement, showLink){
        if(this._errorDisplay)
        {
            this._errorDisplay.addClass('rn_MessageBox rn_ErrorMessage');
            //add link to message so that it can receive focus for accessibility reasons
            if(showLink === false)
            {
                this._errorDisplay.set("innerHTML", message);
            }
            else
            {
                this._errorDisplay.set("innerHTML", '<a href="javascript:void(0);" onclick="document.getElementById(\'' + focusElement + '\').focus(); return false;">' + message + '</a>')
                    .get("firstChild").focus();
            }
        }
    },

    /**
     * Toggles the state of loading indicators:
     * Fades the form out/in (for decent browsers)
     * Disables/enables form inputs and dialog buttons
     * Adds/Removes loading indicator class
     * @param {Boolean} turnOn Whether to add or remove the loading indicators.
     */
    _toggleLoading: function(turnOn) {
        this._dialogContent || (this._dialogContent = this.Y.one(this.baseSelector + "_Content"));

        this._dialogContent.all('input')[(turnOn) ? 'setAttribute' : 'removeAttribute']('disabled', true);

        if (!this.Y.UA.ie || this.Y.UA.ie > 8) {
            // YUI's animation causes JS execution in IE7-8 to fail in weird ways, like failing to redirect the page
            // when a user's successfully logged in...
            this._dialogContent.transition({
                opacity: turnOn ? 0 : 1,
                duration: 0.4
            });
            this.Y.one(this.baseSelector)[(turnOn) ? 'addClass' : 'removeClass']('rn_ContentLoading');
        }
    }
});
