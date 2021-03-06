RightNow.namespace('Custom.Widgets.input.CustomDateInput');
Custom.Widgets.input.CustomDateInput = RightNow.Widgets.extend({ 
    /**
     * Widget constructor.
     */
    constructor: function() {

    this.data = data;
    this.instanceID = instanceID;
    this._formErrorLocation = null;
    this._errorNodes = null;

    var widgetContainer = document.getElementById("rn_" + this.instanceID);
    if(!widgetContainer) return;
    this._selectNodes = myNode.all(function(node){return node.tagName === "SELECT";}, "SELECT", "rn_" + this.instanceID);
    if(!this._selectNodes) return;

    this._parentContainer =  document.getElementById("rn_" + this.instanceID + "_parent");

    if(this.data.js.hint && !this.data.attrs.hide_hint)
        this._initializeHint();

    if(this.data.attrs.initial_focus)
    {
        if(this._selectNodes[0] && this._selectNodes[0].focus)
            this._selectNodes[0].focus();
    }
    if(this.data.attrs.validate_on_blur)
        Y.Event.addListener(this._selectNodes[this._selectNodes.length - 1], "blur", this._blurValidate, null, this);

    RightNow.Event.subscribe("evt_formFieldValidateRequest", this._onValidate, this);

    RightNow.Event.subscribe('evt_questiontype', this._doAction, this);
    RightNow.Event.subscribe('evt_selectiontype', this._doAction, this);

    },

    /**
     * Retrives the entered value of the field
     * @return String Value in various formats depending on its type
     */
    _doAction : function (evt, args) {

       var dispValues = this.data.attrs.display_value.split(",");

       var testValue = args[0].data.fieldname+'='+args[0].data.value;

       if(!this.data.attrs.always_show)
         myNode.addClass(this._parentContainer, 'rn_Hidden');
       this.data.attrs.required = false;

       for(var i=0; i<dispValues.length; i++) {
         if(dispValues[i] == testValue) {
           myNode.removeClass(this._parentContainer, 'rn_Hidden');
           this.data.attrs.required = true;
         }
       }


    },

    _getValue: function()
    {
        var fieldValue = "",
              monthField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_Month"),
              dayField = document.getElementById("rn_" + this.instanceID  + "_" + this.data.js.name + "_Day"),
              yearField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_Year");

        if(monthField && dayField && yearField)
        {
            fieldValue = yearField.options[yearField.selectedIndex].value + "-" +
                      monthField.options[monthField.selectedIndex].value + "-" +
                      dayField.options[dayField.selectedIndex].value;

            if(fieldValue === "--")
            {
                //value isn't set: just return empty string instead of random punctuation string
                return "";
            }

            if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_DATETIME)
            {
                    var hourField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_Hour"),
                    minuteField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_Minute");
                    if (hourField && minuteField)
                    {
                        fieldValue += " " + hourField.options[hourField.selectedIndex].value + ":" +
                                  minuteField.options[minuteField.selectedIndex].value;
                    }
            }
        }
        return fieldValue;
    },

    /**
     * Event handler for when form is being submitted
     *
     * @param type String Event name
     * @param args Object Event arguments
     */
    _onValidate: function(type, args)
    {
        this._parentForm = this._parentForm || RightNow.UI.findParentForm("rn_" + this.instanceID);
        var eo = new RightNow.Event.EventObject();
        eo.data = {"name" : this.data.js.name,
                   "value" : this._getValue(),
                   "table" : this.data.js.table,
                   "required" : (this.data.attrs.required ? true : false),
                   "prev" : this.data.js.prev,
                   "form" : this._parentForm};
        if (RightNow.UI.Form.form === this._parentForm)
        {
            this._formErrorLocation = args[0].data.error_location;
            myNode.removeClass(this._errorNodes, "rn_ErrorField");
            myNode.removeClass("rn_" + this.instanceID + "_Legend", "rn_ErrorLabel");

            if(this._checkRequired() && this._checkValue())
            {
                if(this.data.js.profile)
                    eo.data.profile = true;
                if(this.data.js.customID)
                {
                    eo.data.custom = true;
                    eo.data.customID = this.data.js.customID;
                    eo.data.customType = this.data.js.type;
                }
                else
                {
                    eo.data.custom = false;
                }
                eo.w_id = this.instanceID;
                RightNow.Event.fire("evt_formFieldValidateResponse", eo);
            }
            else
            {
                RightNow.UI.Form.formError = true;
            }
        }
        else
        {
            RightNow.Event.fire("evt_formFieldValidateResponse", eo);
        }
        RightNow.Event.fire("evt_formFieldCountRequest");
    },

    /**
    * Validates that a proper date has been entered.
    */
    _blurValidate: function()
    {
        myNode.removeClass(this._errorNodes, "rn_ErrorField");
        myNode.removeClass("rn_" + this.instanceID + "_Legend", "rn_ErrorLabel");
        this._formErrorLocation = null;
        this._checkRequired();
        this._checkValue();
    },

    /**
     * Validation routine to check if field is required, and if so, ensure it has a value
     * @return Boolean denoting if required check passed
     */
    _checkRequired: function()
    {
        if(this.data.attrs.required)
        {
            this._errorNodes = [];
            for(var i = 0; i < this._selectNodes.length; i++)
            {
                if(this._selectNodes[i].value === "")
                {
                    this._errorNodes.push(this._selectNodes[i].id);
                }
            }
            if(this._errorNodes.length > 0)
            {
                this._displayError(this.data.attrs.label_required);
                return false;
            }
        }
        return true;
    },

    /**
     * Validation routine to check if field passes type and size requirements
     * @return Boolean denoting if value is acceptable
     */
    _checkValue: function()
    {
        this._errorNodes = [];
        var numberFilledIn = 0,
              numberChecked = 0;

        //check if all of the date fields have been set (only all or none is allowed)
        for(var i = 0; i < this._selectNodes.length; i++)
        {
            if(this._selectNodes[i].value === "")
                this._errorNodes.push(this._selectNodes[i].id);
            else
                numberFilledIn++;
            numberChecked++;
        }
        if(numberFilledIn > 0 && numberFilledIn !== numberChecked)
        {
            this._displayError(RightNow.Interface.getMessage("PCT_S_IS_NOT_COMPLETELY_FILLED_IN_MSG"));
            return false;
        }
        var yearField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_Year"),
            monthField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_Month"),
            dayField = document.getElementById("rn_" + this.instanceID  + "_" + this.data.js.name + "_Day"),
            year = (yearField && yearField.value) ? parseInt(yearField.value, 10) : null,
            month = (monthField && monthField.value) ? parseInt(monthField.value, 10) : null,
            day = (dayField && dayField.value) ? parseInt(dayField.value, 10) : null;

        if(year && month && day)
        {
            var error = this._returnErrorIfDateInvalid(year, month, day);
            if(error)
            {
                this._errorNodes = [monthField.id, dayField.id, yearField.id];
                this._displayError(error[0], error[1]);
                return false;
            }
            if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_DATETIME)
            {
                var hourField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_Hour");
                if((month === 1 && day === 2 && year === this.data.js.minYear) && (parseInt(hourField.value, 10) < 9))
                {
                    this._errorNodes = [monthField.id, dayField.id, yearField.id, hourField.id];
                    this._displayError(RightNow.Interface.getMessage("PCT_S_VALUE_MIN_VALUE_PCT_S_MSG"), this.data.js.min_val);
                    return false;
                }
            }
        }
        return true;
    },

    /**
     * Returns null if date is considered valid, else returns a 2 element array where element 0 is
     * the error message and element 1 is an optional second argument to send to _displayError().
     * @param year [integer]  4 digit year
     * @param month [integer] 1-12
     * @param day [integer] 1-31
     * @return mixed
     */
    _returnErrorIfDateInvalid: function(year, month, day)
    {
        if (day === 1 && month === 1 && year === this.data.js.minYear)
            return [RightNow.Interface.getMessage('PCT_S_VALUE_MIN_VALUE_PCT_S_MSG'), this.data.js.min_val];


        if (new Date(year, month - 1, day).getDate() !== day)
            return [RightNow.Interface.getMessage("PCT_S_IS_NOT_A_VALID_DATE_MSG"), null];

        return null;
    },

    /**
     * Creates the hint overlay that shows / hides when
     * the input field is focused / blurred.
     */
    _initializeHint: function()
    {
        if(Y.Overlay)
        {
            if (this.data.attrs.always_show_hint)
            {
                var overlay = this._createHintElement(true);
            }
            else
            {
                var overlay = this._createHintElement(false);
                Y.Event.addListener(this._selectNodes, "focus", function(){overlay.show();});
                Y.Event.addListener(this._selectNodes, "blur", function(){overlay.hide();});
            }
        }
        else
        {
            //display hint inline if YUI container code isn't being included
            var hint = document.createElement("span");
            hint.className = "rn_HintText";
            hint.innerHTML = this.data.js.hint;
            afterNode.insert(hint, this._selectNodes[this._selectNodes.length - 1]);
        }
    },

    /**
     * Creates the hint element.
     * @param visibility Boolean whether the hint element is initially visible
     * @return Object representing the hint element
     */
    _createHintElement: function(visibility)
    {
        var overlay = document.createElement("span");
        overlay.id = "rn_" + this.instanceID + "_Hint";
        myNode.addClass(overlay, "rn_HintBox");
        if (visibility)
            myNode.addClass(overlay, "rn_AlwaysVisibleHint");
        afterNode.insert(overlay, this._selectNodes[this._selectNodes.length - 1]);

        overlay = new Y.Overlay(overlay, {visible: visibility});
        overlay.setBody(this.data.js.hint);
        overlay.render();
        
        return overlay;
    },

    /**
     * Displays error by appending message above submit button
     * @param error String Message to display
     */
    _displayError: function(errorMessage)
    {
        var Form = RightNow.UI.Form;
        Form.errorCount++;
        if(this._formErrorLocation)
        {
            var commonErrorDiv = document.getElementById(this._formErrorLocation);
            if(commonErrorDiv)
            {
                if(Form.chatSubmit && Form.errorCount === 1)
                    commonErrorDiv.innerHTML = "";

                var inputLabel = this.data.attrs.label_error || this.data.attrs.label_input,
                    label = (errorMessage.indexOf("%s") > -1 || arguments.length > 1) ?
                        RightNow.Text.sprintf(errorMessage, inputLabel, Array.prototype.slice.call(arguments).slice(1)) :
                        inputLabel + ' ' + errorMessage;

                commonErrorDiv.innerHTML += "<div><b><a href='javascript:void(0);' onclick='document.getElementById(\"" +
                    this._errorNodes[0] + "\").focus(); return false;'>" + label + "</a></b></div> ";
            }
        }
        myNode.addClass(this._errorNodes, "rn_ErrorField");
        myNode.addClass("rn_" + this.instanceID + "_Legend", "rn_ErrorLabel");
    }
});