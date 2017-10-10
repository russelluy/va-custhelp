YUI().use('node-base', 'node-core', 'node-style', 'dom-base', 'event-base', 'panel', function(Y) {
/**
 * This namespace contains functions which relate to DOM manipulation or retrieval.
 * @namespace
 */
RightNow.UI = RightNow.UI || {};
RightNow.UI = Y.merge(RightNow.UI, (function() {
    var _virtualBufferUpdateTrigger = (function() {
            // Creates a hidden input tag used to encourage screen readers to update virtual buffer
            var input = Y.Node.create("<input type='hidden' id='rn_VirtualBufferUpdateTrigger' name='rn_VirtualBufferUpdateTrigger' value='1'/>");
            new Y.Node(document.body).insert(Y.Node.create('<p style="display:inline"></p>').append(input), 0);
            // Adds aria-hidden attribute to various frames for better usability for screen reader users
            Y.on("available", function() {
                this.set("role", "presentation").set("tabIndex", -1);
                if(this.get("id") === "_yuiResizeMonitor") {
                    //IE doesn't allow setting innerHTML on an iframe
                    //but we're doing this to try and appease AccVerify
                    try {
                        this.set("innerHTML", "&nbsp;");
                    }
                    catch(e) {}
                }
            }, "#rn_History_Iframe, #_yuiResizeMonitor");
            return input;
        })(),

        /**
         * Add or remove the rn_Hidden class on the specified element[s].
         *
         * @param {*} element Acceptable values are a selector or DOM id string, a Node instance, or an HTML DOM element.
         *        Elements can be passed in individually, or within an array.
         * @param {boolean} hidden If true, the rn_Hidden class will be added, else removed.
         * @private
         * @return
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
        };

        // Detect Windows High Contrast Mode and throw a class on the body tag if it's in use.
        if (Y.UA.os === 'windows' && !Y.UA.webkit) { // WebKit doesn't support HCM.
            // Apply a 1px bg image; if it doesn't take, then HCM prevented it.
            var test = Y.Node.create('<div style="display:none;background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAAAAAA6fptVAAAACklEQVQIHWP4DwABAQEANl9ngAAAAABJRU5ErkJggg==);"/>'),
                body = Y.one(document.body);
            body.append(test);
            if (test.getComputedStyle('backgroundImage') === 'none') {
                body.addClass('rn_HighContrastMode');
            }
            test.remove();
        }

return { /** @lends RightNow.UI */
    /**
     * Changes the value of the hidden input to trigger a virtual buffer update
     */
    updateVirtualBuffer: function()
    {
        var trigger = _virtualBufferUpdateTrigger || Y.one('#rn_VirtualBufferUpdateTrigger'),
            value = ((trigger) ? (trigger.get('value') === '1') ? '0' : '1' : null);
        (value && trigger.set('value', value));
    },

    /**
     * Adds an error to the development header, ensuring that it exists first.
     *
     * @param {string} errorMessage The error message to add
     */
    addDevelopmentHeaderError: function(errorMessage)
    {
        if(RightNow.UI.DevelopmentHeader)
            RightNow.UI.DevelopmentHeader.addJavascriptError(errorMessage);
    },

    /**
     * Adds an warning to the development header, ensuring that it exists first.
     *
     * @param {string} warningMessage The warning message to add
     */
    addDevelopmentHeaderWarning: function(warningMessage)
    {
        if(RightNow.UI.DevelopmentHeader)
            RightNow.UI.DevelopmentHeader.addJavascriptWarning(warningMessage);
    },

    /**
     * Iterates over an element's children and adds the specified
     * CSS class to them
     *
     * @param {Object} element The DOM object to modify
     * @param {string} cssClass The CSS class to add
     */
    changeChildCssClass: function(element, cssClass)
    {
        Y.one(element).all('*').each(function(child) {
            if (child.get("className")) {
                child.addClass(cssClass);
            }
        });
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
     * Get a form field element by name
     * @param {string} name The name of the field
     * @param {string|Object} parentForm The form ID or object to look within
     */
    getInputFieldByColumnName: function(name, parentForm)
    {
        var regex = new RegExp("^" + name);
        if(typeof parentForm !== 'object' && parentForm !== null)
            parentForm = document.getElementById(parentForm);
        for(var i = 0; i < parentForm.elements.length; i++)
        {
            if(parentForm.elements[i] && parentForm.elements[i].name && regex.test(parentForm.elements[i].name))
                return i;
        }
        return null;
    },

    /**
     * Utility function to hide/show an element and update the text of
     * the its controller link
     *
     * @param {string} dispElement The id of the element to hide/show
     * @param {string} linkElement The id of the link to change text on
     * @param {string} basicText The text to use when showing the dispElement
     * @param {string} advancedText The text to use when hiding the dispElement
     */
    toggleVisibilityAndText: function(dispElement, linkElement, basicText, advancedText)
    {
        var domElement = document.getElementById(dispElement);
        if(domElement)
        {
            if(domElement.style.display === "none")
            {
                domElement.style.display = "block";
                document.getElementById(linkElement).innerHTML = basicText;
            }
            else if(domElement.style.display === "block")
            {
                domElement.style.display = "none";
                document.getElementById(linkElement).innerHTML = advancedText;
            }
        }
    },

    /**
     * Add the rn_Hidden class on the specified element[s].
     *
     * @param {*} element Acceptable values are a selector or DOM id string, a Node instance, or an HTML DOM element.
     *        Elements can be passed in individually, or within an array.
     * @return
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
     * @return
     */
    show: function(element)
    {
        _toggleHidden(element, false);
    },

    /**
     * Defines a number of utility variables that are stored when submitting forms.
     * @namespace
     */
    Form:
    {
        /**@property {number} currentProduct*/
        currentProduct: 0,
        /**@property {boolean} logoutInProgress*/
        logoutInProgress: false,
        /**@property {boolean|null} smartAssistant
          *@type {boolean|null} smartAssistant*/
        smartAssistant: null,
        /**@property {string|null} smartAssistantToken
          *@type {string|null} smartAssistantToken*/
        smartAssistantToken: null
    },

    KeyMap:
    {
        BACKSPACE:  8,
        ENTER:     13,
        ESCAPE:    27,
        PAGEDOWN:  34,
        PAGEUP:    33,
        TAB:        9,
        SPACE:     32,
        LINEFEED:  10,
        RETURN:    13
    }
};
})());

/**
 * Defines functions for creating standard dialogs and enabling/disabling dialog controls.
 * @namespace
 */
RightNow.UI.Dialog = (function()
{
    var _dialogCount = 0,
        _keyListeners = {},
        _topRenderDiv = (function() {
            var div = document.createElement('div');
            Y.DOM.addHTML(document.body, div, document.body.firstChild);
            return div;
        })(),

        /**
         * Defines the message dialog icons
         * @inner
         */
        _messageDialogIcons = function() {
            // Function rather than literal hash because RightNow.Interface may not be immediately available.
            return {
                HELP: {
                    title: RightNow.Interface.getMessage("HELP_LBL"),
                    className: 'rn_HelpContent'
                },
                WARN: {
                    title: RightNow.Interface.getMessage("WARNING_LBL"),
                    className: 'rn_WarningContent'
                },
                TIP: {
                    className: 'rn_TipContent'
                },
                ALARM: {
                    className: 'rn_AlarmContent'
                },
                BLOCK: {
                    className: 'rn_BlockContent'
                },
                defaults: {
                    title: RightNow.Interface.getMessage("INFORMATION_LBL"),
                    className: 'rn_AlertContent'
                }
            };
        },

        /**
         * Converts YUI2 SimpleDialog button configuration into YUI3 Panel button configuration.
         * @inner
         * @param {Array} buttons Configuration properties
         * @return {Array} Converted properties
         */
        _convertButtons = function(buttons) {
            var converted = [];

            Y.Array.each(buttons, function(button) {
                converted.push({
                    label: button.text,
                    action: (button.handler && button.handler.scope && button.handler.fn)
                        ? RightNow.Event.createDelegate(button.handler.scope, button.handler.fn)
                        : button.handler,
                    classNames: button.cssClass,
                    href: button.href,
                    isDefault: button.isDefault
                });
            });

            return converted;
        },

        /**
         * Provide backwards compatible API for YUI2 SimpleDialog.
         * @inner
         * @param {Object} dialog Panel instance
         * @return {Object} same instance with properties added
         */
        _shimDialog = function(dialog) {
            // Properties
            // Ea. panel consists of an outermost 'boundingBox' (container div)
            // and a 'contextBox'. The dialog div is the later.
            dialog.id = dialog.get('contentBox').get('id');
            dialog.cfg = {
                getProperty: function(name) {
                    return dialog.get(name);
                },
                setProperty: function(name, value) {
                    return dialog.set(name, value);
                }
            };

            // Events
            var events = {},
                /**@inner*/
                add = function(type, handler, args, context) {
                    events[type] || (events[type] = []);
                    events[type].push({handler: handler, args: args, context: context});
                },
                /**@inner*/
                call = function(type) {
                    for (var i = 0, callbacks = events[type] || []; i < callbacks.length; i++) {
                        callbacks[i].handler.call(callbacks[i].context || dialog, callbacks[i].args);
                    }
                };

            dialog.hideEvent = {
                subscribe: function(handler, args, context) {
                    add('hide', handler, args, context);
                }
            };
            dialog.showEvent = {
                subscribe: function(handler, args, context) {
                    add('show', handler, args, context);
                }
            };
            dialog.cancelEvent = {
                subscribe: function(handler, args, context) {
                    add('cancel', handler, args, context);
                }
            };
            dialog.after('visibleChange', function(e) {
                call(e.newVal ? 'show' : 'hide');
                RightNow.UI.updateVirtualBuffer();
            });

            dialog.onCancel = function(e) {
                e.preventDefault();
                this.hide();
                call('cancel');
            };

            // Methods
            dialog.disableButtons = function() {
                RightNow.UI.Dialog.disableDialogButtons(this);
            };
            dialog.enableButtons = function() {
                RightNow.UI.Dialog.enableDialogButtons(this);
            };
            dialog.enableSecondButton = function() {
                var button = this.getStdModNode(Y.WidgetStdMod.FOOTER).all('button').item(1);
                if (button) {
                    button.removeAttribute('disabled');
                }
            };
            dialog.getButtons = function() {
                return this.getStdModNode(Y.WidgetStdMod.FOOTER).all('button');
            };

            dialog.setFooter = function(content) {
                this.set('footerContent', content);
            };
            dialog.setHeader = function(content) {
                this.set('headerContent', content);
            };
            dialog.setBody = function(content) {
                this.set('bodyContent', content);
            };

            return dialog;
        },

        /**
         * Add a fallback for screenreader text to default dialog button add off screen
         * text to button text to notify screen reader users of being in a dialog
         * @param {Object} dialog Dialog to which to add the fallback screenreader text
         * @param {String|null} title Title of dialog
         * @param {Object} description Element that contains the text of a description
         * @private
         */
        _addFallbackScreenreaderText = function(dialog, title, description) {
            var defaultButton = dialog.getStdModNode(Y.WidgetStdMod.FOOTER).one('.yui3-button-primary') || dialog.getButtons().item(0);
            if(defaultButton)
            {
                // It's possible for a dialog description to be specified, so check for it. Fall back on generic text if not found.
                var screenReaderText = description
                    ? RightNow.Interface.getMessage("DIALOG_LBL") + '. ' + description.get('text')
                    : RightNow.Interface.getMessage("DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG");
                defaultButton.set('innerHTML', '<span class="rn_ScreenReaderOnly">' + title + ' ' + screenReaderText + ' </span>' + defaultButton.getHTML());

                //make sure we focus on the default button (which has the corresponding screenreader description) when the dialog is shown
                dialog.after('visibleChange', function(e) {
                    if (e.newVal) {
                        try {
                            defaultButton.focus();
                        }
                        catch(ex){}
                    }
                });
            }
        },

        /**
         * Private utility function for building dialogs
         * @param {String} title The string to use as the dialog title
         * @param {Object} message The HTML element to put as the content of the dialog
         * @param {Object=} [dialogOptions] Object Configuration options for the dialog. Valid keys are:
         *      exitCallback: Function to be run when the dialog closes,
         *      width: String Dialog width,
         *      close: Boolean Set to `false` if the dialog should _not_ have a close button,
         *      buttons: Array Array of buttons to use for the dialog,
         *      cssClass: String A CSS class name to add to the dialog
         * @return {Object} Panel instance
         * @private
         */
        _createDialog = function(title, message, dialogOptions)
        {
            ++_dialogCount;

            dialogOptions || (dialogOptions = {});
            dialogOptions.buttons || (dialogOptions.buttons = [{
                text: RightNow.Interface.getMessage("OK_LBL"),
                handler: (dialogOptions.exitCallback || function(){this.hide();}),
                isDefault: true
            }]);

            if (!message.get) {
                // Convert HTMLElement into a Node.
                message = Y.one(message);
            }

            var dialogID = 'rnDialog' + _dialogCount,
                dialogDefines = Y.WidgetStdMod,
                dialog = new Y.Panel({
                    // In order to be backward compatible w/ YUI2 SimpleDialog,
                    // the div that Panel creates is the equivalent of YUI 2's
                    // container div and the dialog's 'contentBox' is the actual
                    // dialog div (whose id is set later on).
                    id: dialogID + '_c',
                    bodyContent: message,
                    visible: false,
                    zIndex: 9999,
                    centered: true,
                    modal: true,
                    constrain: true,
                    width: dialogOptions.width || '',
                    buttons: _convertButtons(dialogOptions.buttons),
                    alignOn: dialogOptions.alignOn || ''
                });

            if (!('close' in dialogOptions) || dialogOptions.close) {
                dialog.addButton({
                    name: 'close',
                    label: RightNow.Interface.getMessage("CLOSE_CMD"),
                    action: dialogOptions.exitCallback || 'onCancel' // #onCancel is provided by #_shimDialog.
                }, dialogDefines.HEADER);
            }

            //mark boundaries of dialog for accessibility
            var titleID = 'rn_Dialog_' + _dialogCount + '_Title',
                screenReader = '<span class="rn_ScreenReaderOnly">{text}</span>';
            dialog.setStdModContent(dialogDefines.HEADER, Y.Lang.sub(screenReader, {text: RightNow.Interface.getMessage("BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG")}) + " <span id='" + titleID + "'>" + title + '</span>', dialogDefines.BEFORE);
            dialog.setStdModContent(dialogDefines.FOOTER, Y.Lang.sub(screenReader, {text: RightNow.Interface.getMessage("END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG")}), dialogDefines.AFTER);
            dialog.get('contentBox').set('id', dialogID).setAttribute('aria-labelledby', titleID).addClass(Y.Lang.trim('rn_Dialog ' + (dialogOptions.cssClass || "")));

            dialog.on("widget:render", RightNow.UI.updateVirtualBuffer);
            dialog.render(_topRenderDiv);

            if (document.activeElement) {
                // Re-focus on the element that triggered the dialog when the dialog is closed.
                dialog.after("visibleChange", function(e) {
                    if (!e.newVal) {
                        try {
                            //IE throws errors if it cannot focus (element is disabled, hidden, etc.)
                            this.focus && this.focus();
                        }
                        catch(ex){}
                    }
                }, document.activeElement, true);
            }

            return _shimDialog(dialog);
        };

    return {
        /**
         * Creates and returns a YUI Panel with the specified content and buttons.
         * @param {String} title The title of the dialog
         * @param {Object} element Element to use as the content of the dialog; may either be an HTMLElement or YUI Node
         * @param {Object=} [dialogOptions] Object Configuration options for the dialog. Valid keys are:
         *      buttons: Array An array containing buttons specifications; each button can have the following properties,
         *          text: String button label
         *          classNames: String CSS class(es)
         *          handler: Callback function to invoke when the button is clicked; Either a function or object
         *              with `fn` and `scope` keys
         *          href: String URL If the button is intended to be a link
         *          isDefault: Boolean If the button is the default button for the dialog
         *      close: Boolean Set to `false` if the dialog should _not_ have a close button
         *      cssClass: String A CSS class name to add to the dialog
         *      width: String Width parameter for dialog. e.g. '250px'
         *      hideOnEnterKeyPress: Boolean True if the dialog should be hidden when the enter key is pressed
         *      dialogDescription: String An id of an element to use to describe the dialog if it's comprised of a complex element
         *          like a form. This makes it more convenient for screen reader users to understand the purpose of the dialog
         * @return {Object} dialog The dialog instance. The show() method must be called before the dialog will be displayed
         */
        actionDialog: function(title, element, dialogOptions)
        {
            if(!element || (!element.nodeType && !element.get))
                return null;

            var dialog = _createDialog(title, element, dialogOptions);
            if(dialogOptions && dialogOptions.hideOnEnterKeyPress && dialogOptions.hideOnEnterKeyPress === true)
                this.addDialogEnterKeyListener(dialog, dialog.hide);
            //focus first form element
            var firstInputOrTextarea = dialog.getStdModNode(Y.WidgetStdMod.BODY).one('input, textarea, select'),
                description = dialogOptions && dialogOptions.dialogDescription ? Y.one('#' + dialogOptions.dialogDescription) : null;
            if(firstInputOrTextarea && firstInputOrTextarea.get("id"))
            {
                //focus first form element
                //for accessibility, add some text (hidden offscreen) to the label
                //of the first element we focus to provide context
                //find this input element's label element
                //maybe it's the previous sibling
                var firstLabel = dialog.getStdModNode(Y.WidgetStdMod.BODY).one('label[for="' + firstInputOrTextarea.get("id") + '"]');

                if(dialogOptions && dialogOptions.dialogDescription)
                {
                    if(description)
                        description.setAttribute("tabindex", -1);
                    dialog.get('contentBox').setAttribute('aria-describedby', dialogOptions.dialogDescription);
                }
                //the above is the correct way to do aria dialogs. this is the fall back for ie
                if(firstLabel && Y.UA.ie)
                {
                    firstLabel.prepend('<span class="rn_ScreenReaderOnly">' + title + " " + RightNow.Interface.getMessage("DIALOG_LBL") + ' </span>');
                    //help ie 9+ to explain the dialog
                    if(dialogOptions && dialogOptions.dialogDescription)
                        firstInputOrTextarea.setAttribute("aria-describedby", dialogOptions.dialogDescription);
                }
                dialog.after('visibleChange', function(e) {
                    if (e.newVal) {
                        try {
                            firstInputOrTextarea.focus();
                        }
                        catch(ex){}
                    }
                });
            }
            else
            {
                _addFallbackScreenreaderText(dialog, title, description);
            }

            dialog.get('contentBox').setAttribute("role", "dialog");

            return dialog;
        },

        /**
         * Creates a keylistener to respond to the 'enter' key press on an active dialog.
         * @param {Object} dialog Dialog to which to add the keylistener
         * @param {function(string, Array)} callback Function to be run when 'enter' is pressed
         * @param {Object=} scope The context for callback execution; defaults to the dialog
         * @param {String=} selector CSS selector to limit the enter key press on; if not specified,
         *                           callback is called whenever the enter key is pressed while
         *                           focus is on the dialog or any element within it. If enter
         *                           is pressed while on a button, callback is never called. Callback
         *                           handlers for buttons should be configured via the configuration
         *                           object for actionDialog.
         * @return {Object} keyListener The instance of the keylistener
         * @example
         * RightNow.UI.Dialog.addDialogEnterKeyListener(theDialog, myCallback, this, 'input, select')
         */
        addDialogEnterKeyListener: function(dialog, callback, scope, selector) {
            if (!dialog || !callback) return null;

            // Set up key listener for <enter> key to run callback, sending parameters
            // in the format that's expected.
            var keyListener = Y.delegate('key', function(e) {
                if (!e.target || e.target.get('tagName') !== 'BUTTON') {
                    // Buttons have their own handlers.
                    callback.call(scope || dialog, 'keyPressed', [RightNow.UI.KeyMap.ENTER, e]);
                }
            }, '#' + dialog.get("id"), 'down:' + RightNow.UI.KeyMap.ENTER, selector);

            //Stash off the keylistener in case we need to re-attach it later since calling #detach irrevocably
            //prevents the event handler from being "re-attached".
            _keyListeners[dialog.id] || (_keyListeners[dialog.id] = {});
            _keyListeners[dialog.id][keyListener.sub.id] = {
                context: scope,
                fn: callback,
                attached: true,
                selector: selector
            };
            return keyListener;
        },

        /**
         * Disables buttons for dialog_id.
         * @param {Object} dialog Instance of dialog to disable buttons on
         */
        disableDialogButtons: function(dialog)
        {
            dialog.getStdModNode(Y.WidgetStdMod.FOOTER).all('button').set('disabled', true);
        },

        /**
         * Disable buttons and keylistener on a dialog
         * @param {Object} dialog Dialog to be disabled
         * @param {Object} keyListener Keylistener to be disabled
         */
        disableDialogControls: function(dialog, keyListener)
        {
            this.disableDialogKeyListener(dialog, keyListener);
            this.disableDialogButtons(dialog);
        },

        /**
         * Disable an existing key listener.
         * @param {Object} dialog Dialog that uses the keylistener
         * @param {Object} keyListener Keylistener to be disabled
         */
        disableDialogKeyListener: function(dialog, keyListener)
        {
            if(!dialog || !keyListener) return null;
            var dialogID = dialog.id;
            _keyListeners[dialogID] || (_keyListeners[dialogID] = {});
            if(_keyListeners[dialogID][keyListener.sub.id]){
                _keyListeners[dialogID][keyListener.sub.id].attached = false;
            }
            keyListener.detach();
        },

        /**
        * Enables buttons for dialog_id.
        * @param {Object} dialog Dialog the enable buttons on.
        */
        enableDialogButtons: function(dialog)
        {
            dialog.getStdModNode(Y.WidgetStdMod.FOOTER).all('button').removeAttribute('disabled');
        },

        /**
         * Enable buttons and keylistener on a dialog
         * @param {Object} dialog Dialog to be enabled
         * @param {Object} keyListener Keylistener to be enabled
         * @param {boolean} focusElement Should object gain focus
        */
        enableDialogControls: function(dialog, keyListener, focusElement)
        {
            this.enableDialogKeyListener(dialog, keyListener);
            this.enableDialogButtons(dialog);
            if (focusElement)
                focusElement.focus();
        },

        /**
         * Enable an existing key listener.
         * @param {Object} dialog Dialog that uses the keylistener
         * @param {Object} keyListener Keylistener to be enabled
        */
        enableDialogKeyListener: function(dialog, keyListener)
        {
            if(!dialog || !keyListener) return null;

            var id = keyListener.sub.id,
                stashed = (_keyListeners[dialog.id]) ? _keyListeners[dialog.id][id] : null;

            if (stashed && !stashed.attached) {
                keyListener = this.addDialogEnterKeyListener(dialog, stashed.fn, stashed.context, stashed.selector);
            }
        },

        /**
         * Creates and shows an actionDialog with a single OK button.
         * @param {string} message The message in the dialog body
         * @param {Object=} [dialogOptions] Object Configuration options for the dialog. Valid keys are:
         *      icon: String Enumerated string denoting which YUI icon to display with the message,
         *      exitCallback: Function to be run when the dialog closes--
         *                   called with focusElement as the first parameter,
         *      focusElement: Element to be focused after the dialog closes,
         *      width: String Width parameter for dialog.  Ex: '250px',
         *      title: String Title to display for the dialog,
         *      dialogDescription: String An id of an element to use to describe the dialog if it's comprised of a complex element
         *          like a form. This makes it more convenient for screen reader users to understand the purpose of the dialog}
         * @return {Object} The dialog instance
         */
        messageDialog: function(message, dialogOptions)
        {
            if (!message) return null;

            dialogOptions || (dialogOptions = {});
            dialogOptions.width || (dialogOptions.width = '20em');

            //Create the dialog title based on the enumerated icon
            var settings = _messageDialogIcons(),
                defaults = settings[dialogOptions.icon] || settings.defaults,
                title = dialogOptions.title || defaults.title || '',
                className = defaults.className,
                handleOk;

            //construct handler for OK button
            if(dialogOptions.exitCallback || dialogOptions.focusElement) {
                /**@inner*/
                handleOk = function(arg) {
                    this.hide();
                    //call caller-defined function
                    if(dialogOptions.exitCallback && typeof(dialogOptions.exitCallback) === "function")
                        dialogOptions.exitCallback(dialogOptions.focusElement);
                    else if(dialogOptions.exitCallback && dialogOptions.exitCallback.fn && dialogOptions.exitCallback.scope)
                        dialogOptions.exitCallback.fn.call(dialogOptions.exitCallback.scope, dialogOptions.focusElement);
                    //otherwise try to focus focusElement
                    else if(dialogOptions.focusElement) {
                        var focusElement = (typeof dialogOptions.focusElement === "string") ? document.getElementById(dialogOptions.focusElement) : dialogOptions.focusElement;
                        focusElement && focusElement.focus && focusElement.focus();
                    }
                };
            }
            else {
                /**@inner*/
                handleOk = function() {
                    this.hide();
                };
            }
            var messageWrapper = Y.Node.create("<span>" + message + "</span>"),
                dialog = _createDialog(title, messageWrapper, {width: dialogOptions.width, exitCallback: handleOk});
            // Set the id after #_createDialog is called, so that _dialogCount has been properly incremented.
            dialog.get('contentBox').setAttribute("aria-describedby", messageWrapper.set('id', 'rn_Dialog_' + _dialogCount + '_Message').get('id'))
                                    .setAttribute("role", "alertdialog");
            messageWrapper.insert("<span class='rn_MessageDialogIcon " + className + "'></span>", 'before');
            // Handle the close icon ('x') click
            dialog.cancelEvent.subscribe(handleOk);

            var description = dialogOptions && dialogOptions.dialogDescription ? Y.one('#' + dialogOptions.dialogDescription) : Y.one('#rn_Dialog_' + _dialogCount + '_Message');
            _addFallbackScreenreaderText(dialog, title, description);

            if(Y.UA.ie)
                Y.Lang.later(400, dialog, 'show');
            else
                dialog.show();

            return dialog;
        }
    };
}());
});
