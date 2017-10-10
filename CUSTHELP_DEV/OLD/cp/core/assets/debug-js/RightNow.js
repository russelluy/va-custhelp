/*global YUI_config*/
if(RightNow) throw new Error("The RightNow namespace variable has already been defined somewhere.");
/**
 * The global RightNow namespace that contains all of the functionality provided through the Customer Portal
 * javascript API.
 * @namespace
 */
var RightNow = {
    /**
     * Creates and returns (if it doesn't already exist) the namespace specified
     * @return {Object} A reference to the last namespace object created
     */
    namespace: function(/* List of namespaces to create */){
        var a = arguments, o = null, i, j, d;
        for (i = 0; i < a.length; i++) {
            d = a[i].split(".");
            o = window;
            for (j = 0; j < d.length; j++) {
                o = o[d[j]] = o[d[j]] || {};
            }
        }
        return o;
    },

    /**
     * Contains common language utility functions.
     * @namespace
     */
    Lang: {
        /**
        * Iterates over each value in the sourceArray passing them to the
        * callback function. If the callback function returns true the value in
        * the array is returned into the result array. Array keys are preserved.
        * @param {Array} sourceArray The array to remove null values from
        * @param {function(*): boolean}callbackFunction Function If none is supplied, all values
        * equal to false will be removed
        * @return {Array} the resulting array with callbackFunction applied
        */
        arrayFilter: function(sourceArray, callbackFunction) {
            if(typeof callbackFunction === "undefined")
                /**@ignore*/
                callbackFunction = function(item){return (item != null && item != false);};
            else if(typeof callbackFunction !== "function")
                throw new TypeError();

            var returnArray = [], i;
            for(i in sourceArray) {
                if(typeof sourceArray[i] !== "function" && callbackFunction(sourceArray[i]))
                    returnArray[i] = sourceArray[i];
            }
            return returnArray;
        },

        /**
        * Performs a deep copy of the passed-in complex object.
        * Ignores any functions that may be part of the object.
        * @param {Object} objToCopy The object to create a new copy of
        * @return {Object} The new copy of objToCopy
        */
        cloneObject: function(objToCopy) {
            if(objToCopy === null) return null;
            var retObj = {};
            if(typeof objToCopy === "object") {
                if(Object.prototype.toString.call(objToCopy) === '[object Array]')
                    retObj = [];
                for(var i in objToCopy) {
                    if(typeof objToCopy[i] === "object") {
                        retObj[i] = RightNow.Lang.cloneObject(objToCopy[i]);
                    }
                    else if(typeof objToCopy[i] === "string" || typeof objToCopy[i] === "number") {
                        retObj[i] = objToCopy[i];
                    }
                    else if(typeof objToCopy[i] === "boolean") {
                        retObj[i] = (objToCopy[i]) ? true : false;
                    }
                }
            }
            return retObj;
        }
    },

    /**
     * Contains functions to interact with the JS Action Capture Service API
     * @name RightNow.ActionCapture
     * @namespace
     */
    ActionCapture: (function(){
        window._rnq = window._rnq || [];
        /** @lends RightNow.ActionCapture */
        return {
            /**
             * Records an action to the Action Capture Service
             * @param {string} subject The subject of the action
             * @param {string} verb The action being performed
             * @param {*} actionObject Optional content to additionally send with the action. Can be in any
             *                         format, but will be converted into a string using the toString method.
             */
            record: function(subject, verb, actionObject){
                var action = [subject, verb];
                if(actionObject !== null && actionObject !== undefined && actionObject !== ''){
                    action.push(actionObject.toString());
                }
                window._rnq.push(action);
            },

            /**
             * Forces the Action Capture Service to attempt to immediately send all queued actions. Should be used if there are
             * actions to record, but the page is about to be redirected.
             * @param {?function(...)} callbackFunction Function to execute once actions have been sent
             * @param {?Object} scope Scope with which to execute callbackFunction. If not set, defaults to window
             * @param {?number} timeout Number of milliseconds to wait for the ACS request to finish before we forcefully
                                        invoke the callback. Defaults to 250ms, and the max timeout length is 750ms.
             * @param {...} callbackArguments Variable number of arguments to pass to the callbackFunction when invoked.
             */
            flush: function(callbackFunction, scope, timeout, callbackArguments){
                if(!callbackFunction){
                    window._rnq.push(function(){});
                    return;
                }
                timeout = Math.min((timeout || 250), 750);
                scope = scope || window;
                callbackArguments = Array.prototype.slice.call(arguments, 3);
                var scopedCallback = function(){
                        callbackFunction.apply(scope, callbackArguments);
                    },
                    timeoutID = setTimeout(scopedCallback, timeout);
                window._rnq.push(function(){
                    clearTimeout(timeoutID);
                    scopedCallback();
                });
            }
        };
    }())
};

/**
 * Contains all widget instance objects and provides functions for creating new instances and
 * retrieving existing ones.
 * @namespace
 */
RightNow.Widgets = (function() {
    var _Y = YUI(),
        _widgetInstances = {},
        _widgetCount = 0,
        _getObject = function(objectString){
            var a = objectString.split("."), o = window, i;
            for (i = 0; i < a.length; i++) {
                o = o[a[i]];
                if(!o)
                    return null;
            }
            return o;
        },
        _widgetBoilerplate = function(data, instanceID, Y) {
            this.data = data;
            this.instanceID = instanceID;
            this.Y = Y;
            this.baseDomID = 'rn_' + this.instanceID;
            this.baseSelector = '#' + this.baseDomID;
            this.getStatic = function() { return _getObject(this.data.info.class_name); };

            //Fire events to let the framework know the status of widget instantiation.
            if(_widgetCount > 0 && this.data.info && this.data.info.class_name) {
                RightNow.Event.fire('evt_WidgetInstantiated', {
                    name: this.data.info.class_name,
                    instanceID: instanceID,
                    baseSelector: this.baseSelector
                });

                if(--_widgetCount === 0) {
                    RightNow.Event.fire('evt_WidgetInstantiationComplete');
                }
            }
        },
        _mixOverrides = function(child, parent, overrides, prototypeProperties) {
            var i;
            for (i in overrides) {
                // Only allow child to override parent properties that it has explicitly denoted
                if (!overrides.hasOwnProperty(i) || i === 'constructor') continue;

                if (typeof overrides[i] === 'function' && child[i]) {
                    child[i] = (function(name, func) {
                        // Allow methods to call their parent
                        return function() {
                            this.parent = parent[name];
                            var ret = func.apply(this, arguments);
                            delete this.parent;
                            return ret;
                        };
                    })(i, overrides[i]);
                }
                else {
                    child[i] = overrides[i];
                }
            }
            for (i in prototypeProperties) {
                if (i !== 'overrides' && !(i in child)) {
                    child[i] = prototypeProperties[i];
                }
            }
        },
        _defaultYUI = ['node-core', 'node-style', 'node-screen', 'node-event-delegate', 'event-base', 'array-extras', 'transition', 'history', 'escape'],
        _inherits = function(parent, prototypeProperties, staticProperties) {
            var child,
                overrides,
                /**
                 * @constructor
                 * @private
                 */
                constructor = function(){},
                hasParent = (parent + '' !== constructor + '');

            if (hasParent && prototypeProperties && prototypeProperties.hasOwnProperty('overrides') && prototypeProperties.overrides && typeof prototypeProperties.overrides === 'object') {
                // If the widget has a parent then its constructor must be denoted in `overrides`
                overrides = prototypeProperties.overrides;
                if (overrides.hasOwnProperty('constructor')) {
                    child = function() {
                        ('Y' in this) || _widgetBoilerplate.apply(this, arguments);
                        this.parent = parent.prototype.constructor;
                        overrides.constructor.apply(this, arguments);
                        delete this.parent;
                    };
                }
            }

            //If the widget doesn't have a parent, or isn't overriding the constructor
            if (!child) {
                child = (!hasParent && prototypeProperties && prototypeProperties.hasOwnProperty('constructor'))
                    // If there's a user-defined constructor, first call the super then call child constructor.
                    ? function() {
                        ('Y' in this) || _widgetBoilerplate.apply(this, arguments);
                        prototypeProperties.constructor.apply(this, arguments);
                    }
                    // Default to just calling super.
                    : function() {
                        ('Y' in this) || _widgetBoilerplate.apply(this, arguments);
                        return parent.apply(this, arguments);
                    };
            }

            // Inherit static properties from parent
            _Y.mix(child, parent);

            // Set proto chain to inherit from parent, w/o calling parent's constructor
            constructor.prototype = parent.prototype;
            child.prototype = new constructor();

            if(prototypeProperties) {
                if (overrides) {
                    _mixOverrides(child.prototype, parent.prototype, overrides, prototypeProperties);
                }
                else {
                    _Y.mix(child.prototype, prototypeProperties);
                }
            }
            if(staticProperties) {
                // Allow static properties to be overridden
                _Y.mix(child, staticProperties, true);
            }

            // Set child's prototype.constructor
            child.prototype.constructor = child;

            // In case the parent's prototype is needed later
            child.__super__ = parent.prototype;

            return child;
        };

    return {
        /**
         * Creates a new widget JS instance
         * @param {Object} data Widget instance information, including all attributes and any additional variables
         * @param {string} instanceID The name of this widget instance
         * @param {string} javaScriptPath The path to the widget
         * @param {string} className The name of the widget to instantiate
         * @param {string} suffix The unique ID of the widget instance
         * @param {boolean=} [showWarnings=false] Denotes whether are not to show an error
         */
        createWidgetInstance: function(data, instanceID, javaScriptPath, className, suffix, showWarnings)
        {
            var mappedData = {"info":{"controller_name":data.i.c,"name":data.i.n,"w_id":data.i.w,"class_name":className},"attrs":data.a,"js":data.j},
                widget = _getObject(className),
                /** Appease the closure compiler.
                 * @inner
                 * @param {Object=} Y YUI instance
                 * @param {Object=} details Info about the `use` request
                 */
                instantiate = function(Y, details) {
                    if ((!Y && !details) || details.success) {
                        _widgetInstances[instanceID].instance = new widget(mappedData, instanceID, Y);
                    }
                    else {
                        // Additional modules failed to load from combo server. Fall back to individual module requests.
                        YUI_config.comboBase = null;
                        YUI_config.base = RightNow.Env('yuiCore');
                        YUI().use(details.data, function(Y) {
                            _widgetInstances[instanceID].instance = new widget(mappedData, instanceID, Y);
                        });
                    }
                },
                module, requires;

            if(data.i.t)
                mappedData.info.type = data.i.t;
            _widgetInstances[instanceID] = {javaScriptPath: javaScriptPath, className: className, suffix: suffix};
            if(typeof widget === 'function')
            {
                if('requires' in widget && widget.requires)
                {
                    // The widget requires additional YUI components that aren't in the default roll-up
                    if (_Y.Lang.isArray(widget.requires))
                    {
                        // Requirement applies to all JS modules
                        requires = widget.requires;
                    }
                    else if (typeof widget.requires === 'object' && (module = RightNow.Env('module')) && _Y.Lang.isArray(widget.requires[module])) {
                        // Requirement applies to a named JS module
                        requires = widget.requires[module];
                    }
                    else {
                        requires = [];
                    }
                    _Y.use.apply(_Y, (requires).concat(_defaultYUI, [instantiate]));
                }
                else if('extend' in widget)
                {
                    // The widget doesn't require any additional components
                    _Y.use.apply(_Y, _defaultYUI.concat([instantiate]));
                }
                else
                {
                    instantiate();
                }
            }
            else if(showWarnings)
            {
                alert(RightNow.Interface.getMessage('FOLLOWING_WIDGET_JAVASCRIPT_SYNTAX_MSG') + javaScriptPath);
                return;
            }
        },

        /**
         * Returns instance information for the widget ID specified
         * @param {string} widgetInstanceID The widget instance ID
         * @return {?Object} Widget instance information
         */
        getWidgetInformation: function(widgetInstanceID)
        {
            return _widgetInstances[widgetInstanceID] || null;
        },

        /**
         * Returns the actual instance of the widget given its ID
         * @param {string} widgetInstanceID The widget instance ID
         * @return {?Object} The instance of the widget, or null if it doesn't exist
         */
        getWidgetInstance: function(widgetInstanceID)
        {
            return (_widgetInstances[widgetInstanceID]) ? _widgetInstances[widgetInstanceID].instance : null;
        },

        /**
         * Used by the framework to set the initial number of widgets so that we can correctly
         * notify implementors when the widgets have all been initialized.
         * @param {Number} widgetCount the number of widgets on the page
         * @private
         */
        setInitialWidgetCount: function(widgetCount) {
            _widgetCount = widgetCount;
        },

        /**
         * Whether or not all widgets have been instantiated
         * return {Boolean} true or false
         */
        isWidgetInstantiationComplete: function() {
            return (_widgetCount === 0);
        },

        /**
         * Provides a mechanism for children to inherit properties from a parent.
         * @param {Object} prototypeProperties prototype properties
         *       traditionally defined via widget.prototype = { ... };
         * @param {?Object} staticProperties properties to be shared across all instances (optional)
         */
        extend: function(prototypeProperties, staticProperties) {
            // Widgets inherit from std constructor function rather than `this` (RightNow.Widgets): they don't need
            // the three previous public methods as statics.
            // But if `this` actually has a prototype, then inherit from it.
            var child = _inherits(((this.prototype) ? this : function(){}), prototypeProperties, staticProperties);
            child.extend = this.extend; // Every widget has a static extend method
            return child;
        }
    };
}());

/**
 * Contains functions to retrieve messagebase and configbase values
 * @namespace
 */
RightNow.Interface = (function()
{
    var _configBaseInitializer = null,
        _configbaseEntries = null,
        _messagebaseEntries = null,
        _messageBaseInitializer = null;
    return {
        /**
         * Contains a number of dynamically passed in constants from PHP
         * @namespace
         */
        Constants: {},

        /**
         * Returns a configbase value
         * @param {string} index The configbase key
         * @return {string} The configbase value
         */
        getConfig: function(index)
        {
            if(_configbaseEntries === null && _configBaseInitializer)
                _configbaseEntries = _configBaseInitializer();
            if(_configbaseEntries && _configbaseEntries[index] !== undefined)
                return _configbaseEntries[index];
            return "";
        },

        /**
         * Returns a messagebase value
         * @param {string} index The messagebase key
         * @return {string} The messagebase value
         */
        getMessage: function(index)
        {
            if(_messagebaseEntries === null && _messageBaseInitializer)
                _messagebaseEntries = _messageBaseInitializer();
            if(_messagebaseEntries && _messagebaseEntries[index] !== undefined)
                return _messagebaseEntries[index];
            return "";
        },
        /**
         * Temporary wrapper for getMessage() to allow backporting of code from the new "gettext"
         * style calls in the Dynamic Upgrades project, currently slated for v12.2.
         *
         * @private
         * @param {string} message - The actual message string.
         * @param {string} context - The old msgbase define as a string. e.g. 'OPEN_LBL' or 'OPEN_LBL:RNW'
         * @return {string}
         */
        msg: function(message, context)
        {
            var messageBaseValue = this.getMessage(context);
            return (messageBaseValue === '') ? message : messageBaseValue;
        },
        /**@private*/
        ASTRgetMessage: function(value)
        {
            return value;
        },

        /**@private*/
        setConfigbase: function(initializer)
        {
            _configBaseInitializer = initializer;
        },
        /**@private*/
        setMessagebase: function(initializer)
        {
            _messageBaseInitializer = initializer;
        }
    };
}());

/**
 * Contains functions to retrieve contact profile values
 * @namespace
 */
RightNow.Profile = (function() {
    /** @private */
    function _getProfileData(key) {
        var profileData = RightNow.Env("profileData");

        if (!profileData || profileData.isLoggedIn !== true) {
            return '';
        }

        return (profileData.hasOwnProperty(key) && typeof(profileData[key]) !== 'undefined') ? profileData[key] : '';
    }

    return {
        /**
         * Returns whether or not the user is logged in
         * @return {boolean} Whether or not the user is logged in
         */
        isLoggedIn: function() {
            var profileData = RightNow.Env("profileData");
            return profileData.isLoggedIn;
        },

        /**
         * Returns the contactID of an authenticated contact
         * @return {?number} Contact's primary key, or null if user is not logged in
         */
        contactID: function() {
            var profileData = RightNow.Env("profileData");
            return (profileData.isLoggedIn === true) ? profileData.contactID : null;
        },

        /**
         * Returns the first name of an authenticated contact
         * @return {string} The first name or empty string if not authenticated
         */
        firstName: function() {
            return _getProfileData("firstName");
        },

        /**
         * Returns the last name of an authenticated contact
         * @return {string} The last name or empty string if not authenticated
         */
        lastName: function() {
            return _getProfileData("lastName");
        },

        /**
         * Returns the email address of an authenticated contact
         * @return {string} The email address or empty string if not authenticated
         */
        emailAddress: function() {
            return _getProfileData("email");
        },

        /**
         * Returns the full name of an authenticated contact
         * @return {string} The full name or empty string if not authenticated
         */
        fullName: function() {
            var profileData = RightNow.Env("profileData");
            if (profileData.isLoggedIn !== true) {
                return "";
            }

            return (RightNow.Interface.getConfig("intl_nameorder")) ?
                profileData.lastName + " " + profileData.firstName :
                profileData.firstName + " " + profileData.lastName;
        },

        /**
         * Returns the previously seen email address
         * @return {string} The previously seen email address
         */
        previouslySeenEmail: function() {
            var profileData = RightNow.Env("profileData");
            return profileData.previouslySeenEmail || '';
        }
    };
}());

YUI().use('json', function(Y) {
    /**
     * Contains functions to encode and decode data in JSON format. This wrapper will either use the
     * native browser functions, or use the YUI library if not available.
     * @namespace
     */
    RightNow.JSON = Y.JSON;
});
