/**#nocode+*/
if(RightNow.UI && !RightNow.UI.AbuseDetection) throw new Error("The RightNow.UI namespace variable has already been defined somewhere.");

YUI().use('node-style', 'dom-screen', 'event-base', 'event-custom', function(Y) {
Y.on('domready', function() {
    var UI = RightNow.UI;
    UI.Dialog.setRenderDiv(); UI.prepareVirtualBufferUpdateTrigger(); UI.ariaHideFrames();
});

'UI' in RightNow || (RightNow.UI = {});
RightNow.UI = Y.merge(RightNow.UI, (function() {
    var _emptyFunction = function(){},
        /**
         * Add or remove the rn_Hidden class on the specified element[s].
         *
         * @param {*} element Acceptable values are a selector or DOM id string, a Node instance, or an HTML DOM element.
         *        Elements can be passed in individually, or within an array.
         * @param {boolean} hidden If true, the rn_Hidden class will be added, else removed.
         * @private
         */
        _toggleHidden = function(element, hidden) {
            var elements = (element && typeof(element) === 'object' && element.length) ? element : [element],
                method = (hidden) ? 'addClass' : 'removeClass';
            for (var i = 0, instance; i < elements.length; i++) {
                if (instance = elements[i]) {
                    if (typeof(instance) === 'string') {
                        instance = Y.one(instance.substr(0, 1) === '#' ? instance : '#' + instance);
                    }
                    else if (!instance[method]) {
                        // Likely an HTML Dom Element
                        instance = Y.one(instance);
                    }
                    if (instance) {
                        instance[method]('rn_Hidden');
                    }
                }
            }
        },
        /**
         * Add non-visible text to button text to notify screen reader users of being in a dialog.
         * @param {Object} button Button to add the fallback screenreader text onto
         * @param {string=} title Title of dialog
         * @return {Object} The button with its screen reader text added
         * @private
         */
        _addFallbackScreenreaderText = function(button, title) {
            title = title || '';
            title += ' ' + RightNow.Interface.getMessage("DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG");

            return button.setHTML('<span class="rn_ScreenReaderOnly">' + title + '</span> ' + button.getHTML());
        };
    return {
        virtualBufferUpdateTrigger: null,
        prepareVirtualBufferUpdateTrigger: _emptyFunction,
        ariaHideFrames: _emptyFunction,
        updateVirtualBuffer: _emptyFunction,
        toggleVisibilityAndText: _emptyFunction,
        changeChildCssClass: _emptyFunction,
        getInputFieldByColumnName: function()
        {
            return null;
        },

        /**
         * Adds the error message to the header
         * @param {string} errorMessage
         */
        addDevelopmentHeaderError: function(errorMessage)
        {
            if(RightNow.UI.DevelopmentHeader)
                RightNow.UI.DevelopmentHeader.addJavascriptError(errorMessage);
        },

        /**
         * Adds the warning message to the header
         * @param {string} warningMessage
         */
        addDevelopmentHeaderWarning: function(warningMessage)
        {
            if(RightNow.UI.DevelopmentHeader)
                RightNow.UI.DevelopmentHeader.addJavascriptWarning(warningMessage);
        },
        /**
         * Find the parent form of an element if it exists
         * @param {string} id The DOM id of the element
         * @return {?string} The form element ID or null if not found or the form doesn't have an id
         */
        findParentForm: function(id)
        {
            var node = Y.one((id.indexOf("#") === 0) ? id : "#" + id),
                parentForm,
                formID;
            if(node)
            {
                //Check if the current node is a form itself
                if(node.get('tagName') === 'FORM'){
                    parentForm = node;
                }
                else{
                    parentForm = node.ancestor("form");
                }
                // YUI auto-assigns an id to an element if it doesn't have one
                if(parentForm && (formID = parentForm.get("id")) && formID.indexOf("yui_3_") !== 0) {
                    return formID;
                }
            }
            return null;
        },

        /**
         * Add the rn_Hidden class on the specified element[s].
         *
         * @param {*} element Acceptable values are a selector or DOM id string, a Node instance, or an HTML DOM element.
         *        Elements can be passed in individually, or within an array.
         */
        hide: function(element)
        {
            _toggleHidden(element, true);
        },

        /**
         * Remove the rn_Hidden class on the specified element[s].
         *
         * @param {*} element Acceptable values are a selector or DOM id string, a Node instance, or an HTML DOM element.
         *        Elements can be passed in individually, or within an array.
         */
        show: function(element)
        {
            _toggleHidden(element, false);
        },

        /**
         * RightNow.UI.Form
         *
         * Defines a number of utility variables that are stored when
         * submitting forms.
         */
        Form:
        {
            currentProduct: 0,
            logoutInProgress: false,
            smartAssistant: null
        },

        KeyMap: {
            BACKSPACE:  8,
            ENTER:     13,
            ESCAPE:    27,
            PAGEDOWN:  34,
            PAGEUP:    33,
            TAB:        9,
            SPACE:     32,
            LINEFEED:  10,
            RETURN:    13
        },

        /**
         * RightNow.UI.Dialog
         *
         * Defines a number of utility functions for creating dialogs
         * to the user. Functions for showing and enabling/disabling
         * dialog controls are contained here.
         * @namespace
         */
        Dialog: (function() {
            var _dialogCount = 0,
                /**@constructor*/
                _dialog = function(panel, title, content, cancelButton, dialogButtons){
                    this.id = panel.get('id');
                    //private dialog members
                    this._panel = panel;
                    this._title = title;
                    this._content = content;
                    this._cancelButton = cancelButton;
                    this._buttons = dialogButtons;
                    //public dialog events
                    this.showEvent = this.publish("showEvent");
                    this.hideEvent = this.publish("hideEvent");
                    this.backEvent = this.publish("backEvent");
                    //inject dialog into the DOM
                    this._panel.setStyle("display", "none");
                    new Y.Node(document.body).insert(this._panel, 0);
                },
                _mobileBrowser = window.navigator.userAgent.toLowerCase().match(/(iphone|ipod|android|webos)/),
                _emptyFunction = function(){};

            _mobileBrowser = (_mobileBrowser && _mobileBrowser[0]) ? _mobileBrowser[0] : "";
            _dialog.prototype = {
                /**@private*/
                _toggleBodyContent: function(displayMode) {
                    var sibling = this._panel.next(),
                        method = displayMode ? "removeClass" : "addClass";
                    while(sibling) {
                        if(sibling.get("tagName") !== "SCRIPT")
                            sibling[method]("rn_Hidden");
                        sibling = sibling.next();
                    }
                },
                /**@private*/
                _hideAllScreens: function(exceptScreenWithThisID) {
                    if(this._contentQueue && this._contentQueue.length) {
                        //hide any existing current screens, except one with the (optionally) passed-in id
                        for(var i = 0, currentScreen, len = this._contentQueue.length; i < len; i++) {
                            currentScreen = this._contentQueue[i].element;
                            currentScreen.setStyle("display", (currentScreen.get("id") === exceptScreenWithThisID) ? "block" : "none");
                        }
                    }
                },
                /**@private*/
                _findScreen: function(id) {
                    if(this._contentQueue && this._contentQueue.length) {
                        for(var i = 0, len = this._contentQueue.length; i < len; i++) {
                            if(this._contentQueue[i].element.get("id") === id) {
                                return {index: i, object: this._contentQueue[i]};
                            }
                        }
                    }
                },
                id: null,
                /**
                 * Returns true if panel is visible
                 * @return {boolean}
                 */
                visible: function() {
                    return this._panel.getComputedStyle("display") === "block";
                },
                /**
                 * Shows the panel
                 */
                show: function() {
                    this.fire("showEvent");
                    if(_mobileBrowser === "android") {
                        this._toggleBodyContent(false);
                    }
                    this._panel.setStyle("display", "block");
                    //prevent page + overlay background overlap problems: manually set height
                    //add 100px buffer to bottom of dialog content in case it dynamically grows
                    this._content.setStyle("height", (Y.DOM.docHeight() - (this._title.get("parentNode").get("clientHeight") - 100)) + "px");
                    this._cancelButton.focus();
                    window.scrollTo(0, 0);
                },
                /**
                 * Hides the panel
                 */
                hide: function() {
                    this.fire("hideEvent");
                    if(_mobileBrowser === "android") {
                        this._toggleBodyContent(true);
                    }
                    this._panel.setStyle("display", "none");
                },
                /**
                 * Destroys the panel
                 */
                destroy: function() {
                    this._panel.remove();
                },
                /**
                 * Resizes panel to fit the window
                 */
                resizeToWindow: function() {
                    if(this._content){
                        var content = this._content, bodyHeight;
                        //delaying this check by 1 ms gives a chance for any pending rendering ops to occur
                        //and makes sure the most up-to-date height is reported
                        setTimeout(function(){
                            bodyHeight = document.body.scrollHeight;
                            if(content.get("offsetHeight") < bodyHeight){
                                content.setStyle("height", bodyHeight + "px");
                            }
                        }, 1);
                    }
                },
                /**
                 * Enables the buttons
                 */
                enableButtons: function() {
                    for(var i = 0, len = this._buttons.length; i < len; i++) {
                        this._buttons[i].set("disabled", "");
                    }
                },
                /**
                 * Returns the buttons
                 * @return {Array}
                 */
                getButtons: function() {
                    return this._buttons;
                },
                /**
                 * Enables the second button
                 */
                enableSecondButton: function() {
                    if(this._buttons[1]) {
                        this._buttons[1].set("disabled", "");
                    }
                },
                /**
                 * Disables the buttons
                 */
                disableButtons: function() {
                    for(var i = 0, len = this._buttons.length; i < len; i++) {
                        this._buttons[i].set("disabled", "disabled");
                    }
                },
                /**
                 * Sets the header
                 * @param {string} newTitle
                 */
                setHeader: function(newTitle) {
                    if(this._title) {
                        this._title.set("innerHTML", newTitle);
                    }
                },
                /**
                 * Returns the header
                 * @return {string}
                 */
                getHeader: function() {
                    return (this._title) ? this._title.get("innerHTML") : "";
                },
                /**
                 * Returns true if previous content
                 * @return {boolean}
                 */
                hasPreviousContent: function() {
                    return typeof this._currentlyShowing !== "undefined" && this._currentlyShowing !== 0;
                },
                /**
                 * Navigates to the next screen
                 * @param {string} newContent
                 * @param {string} newTitle
                 * @param {string} backButtonText
                 */
                nextScreen: function(newContent, newTitle, backButtonText) {
                    if(this._content && this._content.one("*")) {
                        if(!this._contentQueue) {
                            //create & initialize the queue for the first time
                            this._contentQueue = [];
                            this._contentQueue.push({element: this._content.one("*"), title: this.getHeader(), cancelButton: this._cancelButton.get("innerHTML")});
                            this._currentlyShowing = 0;
                        }
                        this._hideAllScreens(null);
                        if(newTitle && newTitle !== this.getHeader())
                            this.setHeader(newTitle);
                        this._cancelButton.set("innerHTML", (backButtonText || RightNow.Interface.getMessage("BACK_LBL"))).get("parentNode").addClass("rn_Back");
                        this._content.append(newContent);
                        newContent = this._content.get("children").slice(-1).item(0);
                        this._contentQueue.push({element: newContent, title: this.getHeader(), cancelButton: this._cancelButton.get("innerHTML"), parent: this._currentlyShowing});
                        this._currentlyShowing = this._contentQueue.length - 1;
                        window.scrollTo(0, 0);
                        if(_mobileBrowser === "android") {
                            this.resizeToWindow();
                        }
                    }
                },
                /**
                 * Navigates to the previous screen
                 */
                previousScreen: function() {
                    if(this._contentQueue && this._contentQueue.length) {
                        this.showScreen(this._contentQueue[this._currentlyShowing].parent);
                        window.scrollTo(0, 0);
                        this.fire("backEvent");
                        if(!this.hasPreviousContent()) {
                            this._cancelButton.get("parentNode").removeClass("rn_Back");
                        }
                    }
                },
                /**
                 * Shows the screen
                 * @param {*} screen
                 */
                showScreen: function(screen) {
                    var index;
                    if(typeof screen === "string") {
                        if (screen.indexOf("#") === 0) {
                            screen = screen.substr(1);
                        }
                        screen = this._findScreen(screen);
                        index = screen.index;
                        screen = screen.object;
                    }
                    else if(typeof screen === "number") {
                        index = screen;
                        screen = this._contentQueue[index];
                    }
                    if(screen) {
                        this._hideAllScreens(screen.element.get("id"));
                        this.setHeader(screen.title);
                        this._cancelButton.set("innerHTML", screen.cancelButton);
                        this._currentlyShowing = index;
                        this._cancelButton.get("parentNode")[(this.hasPreviousContent() ? "addClass" : "removeClass")]("rn_Back");
                        window.scrollTo(0, 0);
                    }
                }
            };
            Y.augment(_dialog, Y.EventTarget);
            return {
                /**
                 * Creates a dialog overlay with the specified content and buttons.
                 *
                 * @param {string} title The title the dialog should have
                 * @param {Node} element HTMLElement to use as the content of the dialog
                 * @param {Object=} [dialogOptions] Optional configuration options for the dialog. Valid keys are:
                 *      {buttons: Array An array containing buttons specifications,
                         text: String button text,
                         cssClass: String CSS class added to the button,
                         isDefault: Boolean True if the button is the dialog default,
                         handler: Function called when the button is pressed,
                                             OR
                                 {fn: Function called when the button is pressed,
                                  scope: Default context applied to fn}
                                 },
                         navButtons: Boolean True if the buttons are to be displayed
                 *       cssClass: String A CSS class added to the top-most dialog element}
                 * @return {Object} dialog instance ready to be shown
                 */
                 actionDialog: function(title, element, dialogOptions) {
                    if(!element || (!element.nodeType && !element.get))
                        throw new TypeError("Second parameter must be an HTML Element");
                    if(element.nodeType && !element.get)
                        element = new Y.Node(element);

                    var zIndex = _dialogCount++ * 10 + 100,
                        titleID = 'rn_ActionDialog_Title' + _dialogCount,
                        panel = Y.Node.create("<div class='rn_Panel' role='dialog'></div>")
                                    .set('id', "rn_ActionDialog_Generated" + _dialogCount)
                                    .setAttribute('aria-labelledby', titleID)
                                    .setStyle("zIndex", zIndex),
                        titleElement = Y.Node.create("<span class='rn_Title'>" + (title || "") + "</span>").set('id', titleID),
                        cap = Y.Node.create("<div class='rn_PanelCap'></div>").setStyle("zIndex", ++zIndex).append(titleElement),
                        content = Y.Node.create("<div></div>")
                                    .set("className", "rn_PanelContent " + ((dialogOptions && dialogOptions.cssClass) ? dialogOptions.cssClass : ""))
                                    .setStyle("zIndex", ++zIndex).append(element),
                        // create dialog instance prior to assignment of cancelButton, buttonArray
                        // so that the proper scope can be passed to the button click handler if the caller didn't specify a callback scope
                        cancelButton,
                        buttonArray = [],
                        dialog = new _dialog(panel, titleElement, content, cancelButton, buttonArray);
                    //add buttons to nav bar
                    dialogOptions = dialogOptions || {};
                    dialogOptions.buttons = dialogOptions.buttons || [];
                    if(!dialogOptions.buttons.length) {
                        dialogOptions.buttons.push({text: RightNow.Interface.getMessage("CLOSE_CMD"), handler: {fn: function() {
                            if(dialog.hasPreviousContent()) {
                                dialog.previousScreen();
                            }
                            else {
                                dialog.hide();
                            }
                        }, scope: this}});
                    }
                    for(var i = 0, buttons = dialogOptions.buttons, len = buttons.length, button; i < len; i++) {
                        button = Y.Node.create("<div></div>");
                        if(dialogOptions.navButtons) {
                            cap.append(
                                button.set("innerHTML", "<a href='javascript:void(0);' class='rn_Button " + ((buttons[i].isDefault) ? "rn_DefaultButton" : "") + "'>" + buttons[i].text + "</a>")
                                      .set("className", ((buttons[i].isDefault) ? "rn_FloatRight " : "rn_FloatLeft ") + ((buttons[i].cssClass) ? buttons[i].cssClass : ""))
                            );
                        }
                        else {
                            content.append(
                                button.set("innerHTML", "<button class='" + ((buttons[i].isDefault) ? "rn_DefaultButton" : "rn_Button") + "'>" + buttons[i].text + "</button>")
                                      .set("className", buttons[i].cssClass || "")
                            );
                        }
                        button = button.one('*'); //<-actual button element
                        buttonArray.push(button);
                        button.on("click", buttons[i].handler.fn || buttons[i].handler, buttons[i].handler.scope || dialog);
                        if(i === len - 1) {
                            cancelButton = button;
                        }
                    }

                    //add nav bar & content to panel
                    panel.append(cap).append(content);
                    //sneak in the now assigned variables
                    dialog._buttons = buttonArray;
                    dialog._cancelButton = _addFallbackScreenreaderText(cancelButton, title || '');
                    return dialog;
                },

                /**
                 * Creates and shows an alert-style dialog with one OK button
                 *
                 * @param {string} message The message in the dialog body
                 * @param {Object=} [dialogOptions] (optional) Configuration options for the dialog. Valid keys are:
                 *     {title: Optional string to display for the dialog title. Defaults to "Information",
                 *      exitCallback: Function to be run when the dialog closes--
                 *                   called with focusElement as the first parameter
                 *                   OR
                 *                    {fn: Function to be run when the dialog closes--called with focusElement as the first parameter,
                 *                     scope: Scope that should be applied to fn},
                 *      focusElement: Element to be focused after the dialog closes}
                 */
                 messageDialog: function(message, dialogOptions) {
                    if(!message) {
                        throw new Error("First parameter must be specified");
                    }
                    _dialogCount++;

                    var titleID = "rn_DialogTitle" + _dialogCount,
                        dialog = Y.Node.create("<div class='rn_Dialog' role='alertdialog'></div>")
                                    .setStyle("zIndex", _dialogCount++ * 10 + 100)
                                    .set("id", "rn_Dialog_Generated" + _dialogCount)
                                    .setAttribute("aria-labelledby", titleID)
                                    .setAttribute('tabindex', 0),
                        hide,
                        buttonID, button,
                        handleOk,
                        title = (dialogOptions && dialogOptions.title) ? dialogOptions.title : RightNow.Interface.getMessage("INFORMATION_LBL");
                    //build up html
                    buttonID = "rn_Dialog" + _dialogCount;
                    dialog.set("innerHTML", "<div class='rn_DialogBg'></div><div class='rn_DialogContent'><div class='rn_DialogTitle' id='" + titleID + "'>" + title + "</div><div class='rn_DialogBody'>" + message + "</div>" +
                        "<div class='rn_DialogButton'><button id='" + buttonID + "'>" + RightNow.Interface.getMessage("OK_LBL") + "</button></div></div>");
                    Y.one(document.body).insert(dialog, 0);
                    //mobile browsers do a bad job of fixed positioning; scroll into view of the dialog manually
                    window.scrollTo(0, dialog.get("offsetTop") - 40); //40px buffer above dialog
                    button = _addFallbackScreenreaderText(Y.one("#" + buttonID), title);
                    button.focus();
                    //construct handler for OK button
                    /**@inner*/
                    hide = function() {
                        dialog.remove();
                    };
                    if(dialogOptions && (dialogOptions.exitCallback || dialogOptions.focusElement)) {
                        /**@inner*/
                        handleOk = function() {
                            hide();
                            //call caller-defined function
                            if(dialogOptions.exitCallback && typeof(dialogOptions.exitCallback) === "function") {
                                dialogOptions.exitCallback(dialogOptions.focusElement);
                            }
                            else if(dialogOptions.exitCallback && dialogOptions.exitCallback.fn && dialogOptions.exitCallback.scope) {
                                dialogOptions.exitCallback.fn.call(dialogOptions.exitCallback.scope, dialogOptions.focusElement);
                            }
                            //otherwise try to focus focusElement
                            else if(dialogOptions.focusElement) {
                                var focusElement;
                                if(typeof dialogOptions.focusElement === "string")
                                    focusElement = document.getElementById(dialogOptions.focusElement);
                                if(focusElement && focusElement.focus)
                                    focusElement.focus();
                            }
                        };
                    }
                    button.on("click", handleOk || hide);
                },
                /**
                 * Sets the given function as the onsubmit handler for the form in the dialog (if the dialog has a form).
                 * Prevents the form's default behavior specified by its action attribute.
                 * @param {Object} dialog RightNow.UI.Dialog.actionDialog dialog that contains the form
                 * @param {function()} submitHandler The function to handle the form's submit event
                 * @param {Object=} [scope] Optional scope for the submitHandler function
                 */
                addDialogEnterKeyListener: function(dialog, submitHandler, scope){
                    if (dialog._content) {
                        var form = dialog._content.one('form');
                        if (form)
                            form.on('submit', function(evt) {
                                try {
                                    submitHandler.call(scope);
                                }
                                catch(e){}
                                evt.halt();
                            });
                    }
                },
                setRenderDiv: _emptyFunction,
                disableDialogButtons: _emptyFunction,
                disableDialogControls: _emptyFunction,
                disableDialogKeyListener: _emptyFunction,
                enableDialogButtons: _emptyFunction,
                enableDialogControls: _emptyFunction,
                enableDialogKeyListener: _emptyFunction
            };
        })()
    };
})());
});
/**#nocode-*/
