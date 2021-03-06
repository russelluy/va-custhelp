RightNow.namespace('Custom.Widgets.input.CustomTextInput');
Custom.Widgets.input.CustomTextInput = RightNow.Widgets.extend({ 
    /**
     * Widget constructor.
     */
    constructor: function() {
	    this.data = data;
	    this.instanceID = instanceID;
	    this._formErrorLocation = null;
	    this._validated = false;
	    this._errorLabel = this.data.attrs.label_error || this.data.attrs.label_input;
	
	    this._inputField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name);
	    this._parentContainer =  document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name).parentNode;
	    //myNode.addClass(this._parentContainer, 'rn_Hidden');
	/*    
	    if(this.data.attrs.require_validation)
	    {
	        var validationField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_Validate");
	        if(validationField)
	            this._validationField = validationField;
	        else
	            this.data.attrs.require_validation = false;
	    }
	*/
	    if(!this._inputField) return;
	
	     if(this.data.js.hint && !this.data.attrs.hide_hint)
	        this._initializeHint();
	
	    if(this.data.attrs.initial_focus && this._inputField.focus)
	        this._inputField.focus();
	
	    //setup mask
	    if(this.data.js.mask)
	        this._initializeMask();
	
	    RightNow.Event.subscribe("evt_formFieldValidateRequest", this._onValidate, this);
	    //specific events for specific fields:
	    this._fieldName = this.data.js.name;
	    //province changing : update phone/postal masks
	    if(this._fieldName === "postal_code" || this._fieldName === "ph_office" || this._fieldName === "ph_mobile" || this._fieldName === "ph_fax" ||
	        this._fieldName === "ph_asst" || this._fieldName === "ph_home")
	                RightNow.Event.subscribe("evt_formFieldProvinceResponse", this._onProvinceChange, this);
	    //check for existing username/email
	    if(this.data.attrs.validate_on_blur)
	    {
	        Y.Event.addListener(this._inputField, "blur", this._blurValidate, null, this);
	        
	        //Add blur validation to Validate Field
	        if(this.data.attrs.require_validation)
	            Y.Event.addListener(this._validationField, "blur", this._blurValidateValidationField, null, this);
	    }
	
	    if (this.data.js.type === RightNow.Interface.Constants.EUF_DT_PASSWORD && (this._fieldName === 'password_new' || this._fieldName === 'password_verify'))
	    {
	        // Don't do anything with the 'current password' field.
	        this._initializePasswordOverlay();
	    }
	
	//test
	
	
	    RightNow.Event.subscribe('evt_questiontype', this._doAction, this);
	    RightNow.Event.subscribe('evt_selectiontype', this._doAction, this);
	
	//end test
    },

   /**
 * ----------------------------------------------
 * Form / UI Events and Functions:
 * ----------------------------------------------
 */

    _doAction : function (evt, args) {


/*
      if(this.data.attrs.require_validation)
      {
        var validationField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_Validate");
        if(validationField)
            this._validationField = validationField;
        else
            this.data.attrs.require_validation = false;
      }
*/
       var dispValues = this.data.attrs.display_value.split(",");
       var hideonValuesNE = this.data.attrs.hideon_notequal_value.split(",");
       var hideonValues = this.data.attrs.hideon_value.split(",");
       var testValue = args[0].data.fieldname+'='+args[0].data.value;
       var matchHide = 0;
       var matchDisplay = 0;

       if(!this.data.attrs.always_show)
         myNode.addClass(this._parentContainer, 'rn_Hidden');
 
       for(var i=0; i<dispValues.length; i++) {
         if(dispValues[i] == testValue) {
           myNode.removeClass(this._parentContainer, 'rn_Hidden');
           matchDisplay = 1;
         }
       }

       //gsh experimental
       if(hideonValuesNE.length>0 && hideonValuesNE[0] != "") {
         for(var i=0; i<hideonValuesNE.length; i++) {
           if(hideonValuesNE[i] != testValue) {
             myNode.addClass(this._parentContainer, 'rn_Hidden');
           }
           else
             myNode.removeClass(this._parentContainer, 'rn_Hidden');
         }
       }

       //gsh experimental
       if(hideonValues.length>0 && hideonValues[0] != "") {
         for(var i=0; i<hideonValues.length; i++) {
           if(hideonValues[i] == testValue) {
             myNode.addClass(this._parentContainer, 'rn_Hidden');
             matchHide = 1;
           }
         }
       }

       //when no matches to list, show button
       if((hideonValues.length>0 && hideonValues[0] != "") && matchHide == 0)
         myNode.removeClass(this._parentContainer, 'rn_Hidden');

       if((dispValues.length>0 && dispValues[0] != "") && matchDisplay == 0)
         myNode.addClass(this._parentContainer, 'rn_Hidden');
    },


    /**
     * Event handler executed when form is being submitted
     *
     * @param type String Event name
     * @param args Object Event arguments
     */
    _onValidate: function(type, args)
    {
        this._validated = true;
        this._parentForm = this._parentForm || RightNow.UI.findParentForm("rn_" + this.instanceID);
        this._trimField();
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
            if(this._compareInputToMask(true) && this._checkRequired() && this._checkData() && this._checkValue() && this._checkEmail() && this._checkUrl() && this._checkRequiredValidationField() && this._checkValidationField())
            {
                myNode.removeClass(this._inputField, "rn_ErrorField");
                myNode.removeClass("rn_" + this.instanceID + "_Label", "rn_ErrorLabel");
                if(this.data.attrs.require_validation)
                {
                    myNode.removeClass(this._validationField, "rn_ErrorField");
                    myNode.removeClass("rn_" + this.instanceID + "_LabelValidate", "rn_ErrorLabel");
                }
                
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
                if(this.data.js.channelID)
                {
                    eo.data.channelID = this.data.js.channelID;
                }
                eo.w_id = this.data.info.w_id;
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
        this._validated = false;
        RightNow.Event.fire("evt_formFieldCountRequest");
    },

    /**
    * Validates that the input field has a value (if required) and that the value is
    * of the correct format.
    */
    _blurValidate: function()
    {
        this._formErrorLocation = null;
        if(this._dialogShowing)
            return;
        
        this._trimField();
       
        if(this._checkRequired() && this._checkData() && this._checkValue() && this._checkEmail())
        {
            if(this._fieldName === "login" || this._fieldName === "email" || this._fieldName === "email_alt1" || this._fieldName === "email_alt2")
            {
                this._checkExistingAccount();
            }
            myNode.removeClass(this._inputField, "rn_ErrorField");
            myNode.removeClass("rn_" + this.instanceID + "_Label", "rn_ErrorLabel");
            return true;
        }
    },
    
    /**
    * Validates that the Validation field has a value (if required) and that the value matches
    * that of _inputField.
    */
    _blurValidateValidationField: function()
    {
        this._formErrorLocation = null;
        if(this._checkRequiredValidationField() && this._checkValidationField())
        {
            myNode.removeClass(this._validationField, "rn_ErrorField");
            myNode.removeClass("rn_" + this.instanceID + "_LabelValidate", "rn_ErrorLabel");
        }    
    },

    /**
    * Checks that the value entered doesn't exceed its expected bounds
    */
    _checkValue: function()
    {
        if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_INT)
        {
            //make sure it's a valid int
            if(this._inputField.value !== "" && (isNaN(Number(this._inputField.value)) || parseInt(this._inputField.value, 10) !== parseFloat(this._inputField.value)))
            {
                this._displayError(RightNow.Interface.getMessage('VALUE_MUST_BE_AN_INTEGER_MSG'));
                return false;
            }
            //make sure it's value is in bounds
            if(this.data.js.maxVal || this.data.js.minVal)
            {
                var value = parseInt(this._inputField.value, 10);
                if(this.data.js.maxVal && value > parseInt(this.data.js.maxVal, 10))
                {
                    this._displayError(RightNow.Interface.getMessage('VALUE_IS_TOO_LARGE_MAX_VALUE_MSG') + this.data.js.maxVal + ")");
                    return false;
                }
                if(this.data.js.minVal && value < parseInt(this.data.js.minVal, 10))
                {
                    this._displayError(RightNow.Interface.getMessage('VALUE_IS_TOO_SMALL_MIN_VALUE_MSG') + this.data.js.minVal + ")");
                    return false;
                }
            }
        }
        else if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_PASSWORD && this.data.js.name !== "organization_password")
        {
            if (this.data.js.name === 'password_new' && this.data.js.passwordValidations && !this._validatePasswordInput(true))
            {
                this._displayError(RightNow.Interface.getMessage("PCT_S_REQUIREMENTS_MET_LBL"));
                return false;
            }
            if (this.data.js.name === 'password_verify' && !this._validatePasswordValidation(true))
            {
                this._displayError(RightNow.Interface.getMessage("PCT_S_DOES_NOT_MATCH_LBL"));
                return false;
            }
        }
        if(this.data.js.fieldSize || this.data.attrs.minimum_length)
        {
            //make sure it's within the max field size
            var length = RightNow.Text.Encoding.utf8Length(this._inputField.value),
                maxLength = this.data.js.fieldSize,
                minLength = this.data.attrs.minimum_length,
                multibyteCharacterCount = parseInt(length/this._inputField.value.length, 10);
            
            if(length % (this._inputField.value.length) !== 0)
                multibyteCharacterCount++;
            
            if(isNaN(multibyteCharacterCount)){
                multibyteCharacterCount = 1;
            }

            if(maxLength && maxLength < length)
            {
                var extra = parseInt((length - maxLength) / multibyteCharacterCount, 10);
                if((length - maxLength) % (multibyteCharacterCount) !== 0)
                    extra++;
                this._displayError(RightNow.Text.sprintf(RightNow.Interface.getMessage("EXCEEDS_SZ_LIMIT_PCT_D_CHARS_PCT_D_LBL"), parseInt(maxLength/multibyteCharacterCount, 10), extra));
                return false;
            }
            else if(minLength && minLength > length){
                var short = parseInt((minLength - length) / multibyteCharacterCount, 10);
                if((minLength - length) % (multibyteCharacterCount) !== 0)
                    short++;
                this._displayError(RightNow.Text.sprintf(RightNow.Interface.getMessage("MEET_MINIMUM_CHAR_LNG_PCT_D_CHARS_LBL"), parseInt(minLength/multibyteCharacterCount, 10), short));
                return false;
            }
        }
        return true;
    },

    /**
    * Validation routine to check for valid strings in certain fields i.e. first_name, last_name and login
    *
    * @param silent Boolean Optional parameter: set to true if the caller wishes to perform
    * the validation check without displaying error messages.
    */
    _checkData: function(silent)
    {
        var spacesRe = /\s/;

        if(this._inputField.value !== "")
        {
            if(this._fieldName === "login")
            {
                //check if username contains spaces
                if(spacesRe.test(this._inputField.value))
                {
                    if(!silent)
                        this._displayError(RightNow.Interface.getMessage('CONTAIN_SPACES_PLEASE_TRY_MSG'));
                    return false;
                }
                //check if username contains double quotes
                if(this._inputField.value.indexOf('"') > -1)
                {
                    if(!silent)
                        this._displayError(RightNow.Interface.getMessage("CONT_DOUBLE_QUOTE_CHARS_PLS_TRY_MSG"));
                    return false;
                }

                if(/<|>/.test(this._inputField.value))
                {
                    if(!silent)
                        this._displayError(RightNow.Interface.getMessage('NOT_CONT_EITHER_GT_LT_MSG'));
                    return false;
                }
            }
            else if(this._fieldName === "ph_office" || this._fieldName === "ph_fax" || this._fieldName === "ph_home" || this._fieldName === "ph_asst" ||
                this._fieldName === "ph_mobile" || this._fieldName === "postal_code")
            {
                var validInput = new RegExp("^[-A-Za-z0-9,# +.()]+$");
                if(!validInput.test(this._inputField.value))
                {
                    if(!silent)
                    {
                        if(this._fieldName === "postal_code")
                            this._displayError(RightNow.Interface.getMessage("PCT_S_IS_AN_INVALID_POSTAL_CODE_MSG"));
                        else
                            this._displayError(RightNow.Interface.getMessage("PCT_S_IS_AN_INVALID_PHONE_NUMBER_MSG"));
                    }
                    return false;
                }
            }
            //Check for space characters on channel fields
            else if(this.data.js.channelID && spacesRe.test(this._inputField.value))
            {
                if(!silent)
                    this._displayError(RightNow.Interface.getMessage('CONTAIN_SPACES_PLEASE_TRY_MSG'));
                return false;
            }
        }
        return true;
    },

    /**
    * Validation routine to check for valid email addresses
    *
    * @param silent Boolean Optional parameter: set to true if the caller wishes to perform
    * the validation check without displaying error messages.
    */
    _checkEmail: function(silent)
    {
        if(!(this._fieldName === 'email' || this._fieldName === 'email_alt1' || this._fieldName === 'email_alt2'|| this._fieldName === 'alternateemail' || this.data.js.email) || this._inputField.value === "")
            return true;
        if (this._fieldName === 'alternateemail')
        {
            var status = true;
            var emailArray = this._inputField.value.split(";");
            for (var i = 0; i < emailArray.length; i++)
            {
                emailArray[i] = Y.lang.trim(emailArray[i]);
                status = (this._validateEmail(emailArray[i], silent) && status) ? true : false;
            }
            return status;
        }
        else
        {
            return this._validateEmail(this._inputField.value, silent);
        }
    },
    
    /**
    * subroutine to validate against the regex
    * @param value String the email address
    * @param silent Boolean Optional parameter: set to true if the caller wishes to perform
    */
    _validateEmail: function(value, silent)
    {
        if(!RightNow.Text.isValidEmailAddress(value))
        {
            if(!silent)
                this._displayError(RightNow.Interface.getMessage("PCT_S_IS_INVALID_MSG"));
           return false;
        }
        return true;
    },

    /**
    * Validation routine to check for valid url custom fields
    *
    * @param silent Boolean Optional parameter: set to true if the caller wishes to perform
    * the validation check without displaying error messages.
    */
    _checkUrl: function(silent)
    {
        if((this.data.js.customID) && (this.data.js.url) && !(this._inputField.value === ""))
        {
            if(!RightNow.Text.isValidUrl(this._inputField.value))
            {
                if(!silent)
                    this._displayError(RightNow.Interface.getMessage("IS_NOT_A_VALID_URL_MSG"));
               return false;
            }
        }
        return true;
    },

    /**
     * Validation routine to check if field is required, and if so, ensure it has a value
     * @return Boolean denoting if required check passed
     */
    _checkRequired: function()
    {
        if(this.data.attrs.required)
        {
            if(this._inputField.value === "")
            {
                this._displayError(this.data.attrs.label_required);
                this._checkRequiredValidationField();
                return false;
            }
        }
        return true;
    },
    
    /**
     * Validation routine to check if the _inputField is required, and if so, ensure that the
     * validation field is also required.
     * @return Boolean denoting if required check passed
     */
    _checkRequiredValidationField: function()
    {
        if(this.data.attrs.require_validation && this.data.attrs.required && this._validationField.value === "")
        {
            var validationLabel = RightNow.Text.sprintf(this.data.attrs.label_validation, this._errorLabel);
            this._displayValidationError(RightNow.Text.sprintf(this.data.attrs.label_required, validationLabel));
            return false;
        }
        return true;
    },  
    
    /**
    *   If there is a validation field check if it's equal to the original field
    *   this should be performed after validation of the first field to ensure that they
    *   are both legitimate fields. 
    */
    _checkValidationField: function()
    {
        if(this.data.attrs.require_validation && Y.lang.trim(this._validationField.value) !== this._inputField.value)
        {
            var validationLabel = RightNow.Text.sprintf(this.data.attrs.label_validation, this._errorLabel);
            this._displayValidationError(RightNow.Text.sprintf(this.data.attrs.label_validation_incorrect, validationLabel, this._errorLabel));
            return false;
        }
        return true;
    },
    
    /**
    * Returns the field's value
    * @return Mixed String or Int (for Int data type)
    */
    _getValue: function()
    {
        if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_INT)
        {
            if(this._inputField.value !== "")
                return parseInt(this._inputField.value);
        }
        if(this.data.js.mask)
            return this._stripMaskFromFieldValue();
        return this._inputField.value;

    },

    /**
    * Trims the value of the input field (removes leading / trailing whitespace).
    */
    _trimField: function()
    {
        if(this._inputField.value !== "" && this.data.js.type !== RightNow.Interface.Constants.EUF_DT_PASSWORD)
            this._inputField.value = Y.lang.trim(this._inputField.value);
        return true;
    },
    
    /**
     * Shows hint on the input field's focus
     * and hides the hint on the field's blur.
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
                Y.Event.addListener(this._inputField, "focus", function(){overlay.show();});
                Y.Event.addListener(this._inputField, "blur", function(){overlay.hide();});
            }
        }
        else
        {
            //display hint inline if YUI container code isn't being included
            var hint = document.createElement("span");
            hint.className = "rn_HintText";
            hint.innerHTML = this.data.js.hint;
            afterNode.insert(hint, this._inputField);
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
        afterNode.insert(overlay, this._inputField);

        overlay = new Y.Overlay(overlay, {visible: visibility});
        overlay.setBody(this.data.js.hint);
        overlay.render();
        
        return overlay;
    },

    /**
     * Displays error specific to the input field
     */
    _displayError: function(errorMessage)
    {
        this._errorHandler(errorMessage, 
                      this._errorLabel, 
                      "rn_" + this.instanceID + "_Label",
                      this._inputField.id);
    },
    
    /**
     * Displays error specific to the validation field
     */
    _displayValidationError: function(errorMessage)
    {
        if(this.data.attrs.require_validation)
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
        
                    commonErrorDiv.innerHTML += "<div><b><a href='javascript:void(0);' onclick='document.getElementById(\"" + this._validationField.id + "\").focus(); return false;'>" +
                        errorMessage + "</a></b></div> ";                    
                }
            }
            myNode.addClass(this._validationField.id, "rn_ErrorField");
            myNode.addClass("rn_" + this.instanceID + "_LabelValidate", "rn_ErrorLabel");
        }
    },

    /**
     * Common errorHandler, displays error by appending message above submit button
     * @param errorMessage String message to display
     * @param inputLabel String label to display before the message
     * @param fieldID Id of the field to focus, and to highlight
     * @param labelID Id of the label to highlight
     */
    _errorHandler: function(errorMessage, inputLabel, labelID, fieldID)
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
    
                commonErrorDiv.innerHTML += "<div><b><a href='javascript:void(0);' onclick='document.getElementById(\"" + fieldID + "\").focus(); return false;'>" +
                    ((errorMessage.indexOf("%s") > -1) ? RightNow.Text.sprintf(errorMessage, inputLabel + ' ') : (inputLabel + ' ' + errorMessage)) +
                    "</a></b></div> ";                    
            }
        }
        myNode.addClass(fieldID, "rn_ErrorField");
        myNode.addClass(labelID, "rn_ErrorLabel");
    },

/**
 * --------------------------------------------------------
 * Business Rules Events and Functions:
 * --------------------------------------------------------
 */
    /**
     * Event handler for when email or login field blurs
     * Check to see if the username/email is unique
     */
    _checkExistingAccount: function()
    {
        if(this._inputField.value === "" || this._inputField.value === (this.data.js.prev ? this.data.js.prev.replace('&#039;',"'") : this.data.js.prev) ||
           (this._fieldName.indexOf("email") > -1 && this._inputField.value.toLowerCase() === (this.data.js.prev ? this.data.js.prev.replace('&#039;',"'") : this.data.js.prev)))
            return;
        //static copy so we don't do a bunch of requests onblur if the value hasn't changed
        if(!this._seenValue)
            this._seenValue = this._inputField.value;
        else if(this._seenValue === this._inputField.value)
            return;
        else
            this._seenValue = this._inputField.value;

        var evtObj = new RightNow.Event.EventObject();
        if(this._fieldName.indexOf("email") > -1)
            evtObj.data.email = this._inputField.value;
        else if(this._fieldName === "login")
            evtObj.data.login = this._inputField.value;
        evtObj.data.contactToken = this.data.js.contactToken;
        RightNow.Event.subscribe("evt_formFieldAccountExistsResponse", this._onAccountExistsResponse, this);
        RightNow.Event.fire("evt_formFieldAccountExistsRequest", evtObj);
    },

    /**
    * If args has a message and we aren't in the process of submitting
    * then alert the message; otherwise no duplicate account exists
    * @param type String Event name
    * @param args Object Event arguments
    */
    _onAccountExistsResponse: function(type, args)
    {
        RightNow.Event.unsubscribe("evt_formFieldAccountExistsResponse", this._onAccountExistsResponse);
        var results = args[0];
        if(results !== false && this._validated === false)
        {
            //add error indicators
            myNode.addClass("rn_" + this.instanceID + "_Label", "rn_ErrorLabel");
            myNode.addClass(this._inputField, "rn_ErrorField");
            //create action dialog with link to acct assistance page
            var handleOK = function(){
                warnDialog.hide();
                this._dialogShowing = false;
                this._inputField.focus();
            };
            var buttons = [ { text: RightNow.Interface.getMessage("OK_LBL"), handler: {fn: handleOK, scope: this}, isDefault: true } ];
            var dialogBody = document.createElement("div");
            dialogBody.innerHTML = results.message;
            var warnDialog = RightNow.UI.Dialog.actionDialog(RightNow.Interface.getMessage("WARNING_LBL"), dialogBody, {"buttons" : buttons, "width" : "250px"});
            this._dialogShowing = true;
            warnDialog.show();
        }
        else
        {
            //remove error indicators
            myNode.removeClass("rn_" + this.instanceID + "_Label", "rn_ErrorLabel");
            myNode.removeClass(this._inputField, "rn_ErrorField");
            this._validated = false;
        }
        return false;
    },

    /**
     * Event handler for when province/state data is returned from the server
     *
     * @param type String Event name
     * @param args Object Event arguments
     */
    _onProvinceChange: function(type, args)
    {
        var eventObj = args[0],
              resetMask = false;

        if(!eventObj.states.length)
            this.data.js.mask = "";

        if((this._fieldName === "postal_code") && ("postal_mask" in eventObj))
        {
            resetMask = true;
            this.data.js.mask = eventObj.postal_mask;
        }
        else if("phone_mask" in eventObj)
        {
            resetMask = true;
            this.data.js.mask = eventObj.phone_mask;
        }

        if(resetMask && this.data.js.mask)
            this._initializeMask();
        else if(this._maskNodeOnPage)
            this._maskNodeOnPage.parentNode.removeChild(this._maskNodeOnPage);
    },
/**
 * --------------------------------------------------------
 * Mask Functions
 * --------------------------------------------------------
 */
    /**
    * Creates a mask overlay
    */
     _initializeMask: function()
     {
            Y.Event.addListener(this._inputField,"keyup", this._compareInputToMask, null, this);
            Y.Event.addListener(this._inputField, "blur", this._hideMaskMessage, null, this);
            Y.Event.addListener(this._inputField, "focus", this._compareInputToMask, null, this);
            this.data.js.mask = this._createMaskArray(this.data.js.mask);
            //Set up mask overlay
            var overlay = document.createElement("div");
            myNode.addClass(overlay, "rn_MaskOverlay");
            if(Y.Overlay)
            {
                this._maskNode = afterNode.insert(overlay, this._inputField);
                this._maskNode = new Y.Overlay(this._maskNode, { visible:false });
                this._maskNode.cfg.setProperty("context", [this._inputField, "tl", "bl", ["windowScroll"]]);
                this._maskNode.setBody("");
                this._maskNode.render();
            }
            else
            {
                myNode.addClass(overlay, "rn_Hidden");
                this._maskNode = overlay;
                afterNode.insert(this._maskNode, this._inputField);
            }

            if(this.data.attrs.always_show_mask)
            {
                //Write mask onto the page
                var maskMessageOnPage = this._getSimpleMaskString(),
                widgetContainer = document.getElementById("rn_" + this.instanceID);
                if(maskMessageOnPage && widgetContainer)
                {
                    var messageNode = document.createElement("div");
                    messageNode.innerHTML = RightNow.Interface.getMessage("EXPECTED_INPUT_LBL") + ": " + maskMessageOnPage;
                    myNode.addClass(messageNode, 'rn_Mask' + (myNode.hasClass(widgetContainer.lastChild, 'rn_HintText') ? ' rn_MaskBuffer' : ''));
                    this._maskNodeOnPage = widgetContainer.appendChild(messageNode);
                }
            }
     },
    /**
     * Creates a mask array based on the passed-in
     * string mask value.
     * @param mask String The new mask to apply to the field
     * @return Array the newly created mask array
     */
    _createMaskArray: function(mask)
    {
        if(!mask) return;
        var maskArray = [];
        for(var i = 0, j = 0, size = mask.length / 2; i < size; i++)
        {
            maskArray[i] = mask.substring(j, j + 2);
            j += 2;
        }
        return maskArray;
    },

    /**
    * Removes the mask from the field value.
    * @return String The value without the mask
    */
    _stripMaskFromFieldValue: function()
    {
        if(!this.data.js.mask || this._inputField.value === "")
            return this._inputField.value;

        var result = "";
        for(var i = 0; i < this._inputField.value.length; i++)
        {
            if(i < this.data.js.mask.length && this.data.js.mask[i].charAt(0) !== 'F')
                result += this._inputField.value.charAt(i);
        }
        return result;
    },

     /**
     * Builds up simple mask string example based off of mask characters
     */
    _getSimpleMaskString: function()
    {
        if(!this.data.js.mask) return "";
        var maskString = "";
        for(var i = 0; i < this.data.js.mask.length; i++)
        {
            switch(this.data.js.mask[i].charAt(0)) {
                case "F":
                    maskString += this.data.js.mask[i].charAt(1);
                    break;
                case "U":
                    switch(this.data.js.mask[i].charAt(1)) {
                        case "#":
                            maskString += "#";
                            break;
                        case "A":
                        case "C":
                            maskString += "@";
                            break;
                        case "L":
                            maskString += "A";
                            break;
                    }
                    break;
                case "L":
                    switch(this.data.js.mask[i].charAt(1)) {
                        case "#":
                            maskString += "#";
                            break;
                        case "A":
                        case "C":
                            maskString += "@";
                            break;
                        case "L":
                            maskString += "a";
                            break;
                    }
                    break;
                case "M":
                    switch(this.data.js.mask[i].charAt(1)) {
                        case "#":
                            maskString += "#";
                            break;
                        case "A":
                        case "C":
                        case "L":
                            maskString += "@";
                            break;
                    }
                    break;
            }
        }
        return maskString;
    },

    /**
     * Compares entered value to required mask format
     * @param submitting Boolean Whether the form is submitting or not;
     * don't display the mask message if the form is submitting.
     * @return Boolean denoting of value coforms to mask
     */
    _compareInputToMask: function(submitting)
    {
        if(!this.data.js.mask) return true;
        var error = [];
        if(this._inputField.value.length > 0)
        {
            for(var i = 0, tempRegExVal; i < this._inputField.value.length; i++) {
                if(i < this.data.js.mask.length) {
                    tempRegExVal = "";
                    switch(this.data.js.mask[i].charAt(0)) {
                        case 'F':
                            if(this._inputField.value.charAt(i) !== this.data.js.mask[i].charAt(1))
                                error.push([i,this.data.js.mask[i]]);
                            break;
                        case 'U':
                            switch(this.data.js.mask[i].charAt(1)) {
                                case '#':
                                    tempRegExVal = /^[0-9]+$/;
                                    break;
                                case 'A':
                                    tempRegExVal = /^[0-9A-Z]+$/;
                                    break;
                                case 'L':
                                    tempRegExVal = /^[A-Z]+$/;
                                    break;
                                case 'C':
                                    tempRegExVal = /^[^a-z]+$/;
                                    break;
                            }
                            break;
                        case 'L':
                            switch(this.data.js.mask[i].charAt(1)) {
                                case '#':
                                    tempRegExVal = /^[0-9]+$/;
                                    break;
                                case 'A':
                                    tempRegExVal = /^[0-9a-z]+$/;
                                    break;
                                case 'L':
                                    tempRegExVal = /^[a-z]+$/;
                                    break;
                                case 'C':
                                    tempRegExVal = /^[^A-Z]+$/;
                                    break;
                            }
                            break;
                        case 'M':
                            switch(this.data.js.mask[i].charAt(1)) {
                                case '#':
                                    tempRegExVal = /^[0-9]+$/;
                                    break;
                                case 'A':
                                    tempRegExVal = /^[0-9a-zA-Z]+$/;
                                    break;
                                case 'L':
                                    tempRegExVal = /^[a-zA-Z]+$/;
                                    break;
                                default:
                                    break;
                            }
                            break;
                        default:
                            break;
                    }
                    if((tempRegExVal !== "") && !(tempRegExVal.test(this._inputField.value.charAt(i))))
                        error.push([i,this.data.js.mask[i]]);
                }
                else
                {
                    error.push([i,"LEN"]);
                }
            }
            //input matched mask but length didn't match up
            if((!error.length) && (this._inputField.value.length < this.data.js.mask.length) && (!this.data.attrs.always_show_mask || submitting === true))
            {
                for(var i = this._inputField.value.length; i < this.data.js.mask.length; i++)
                    error.push([i,"MISS"]);
            }
            if(error.length > 0)
            {
                //input didn't match mask
                this._showMaskMessage(error);
                if(submitting === true)
                    this._displayError(RightNow.Interface.getMessage("PCT_S_DIDNT_MATCH_EXPECTED_INPUT_LBL"));
                return false;
            }
            //no mask errors
            this._showMaskMessage(null);
            return true;
        }
        //haven't entered anything yet...
        if(!this.data.attrs.always_show_mask && submitting !== true)
            this._showMaskMessage(error);
        return true;
    },

    /**
     * Actually shows the error message to the user
     * @param error Array Collection of details about error to display
     */
    _showMaskMessage: function(error)
    {
        if(error === null)
        {
            this._hideMaskMessage();
        }
        else
        {
            if(!this._showMaskMessage._maskMessages)
            {
                //set a static variable containing error messages so it's lazily defined once across widget instances
                this._showMaskMessage._maskMessages = {"F" : RightNow.Interface.getMessage('WAITING_FOR_CHARACTER_LBL'),
                    "U#" : RightNow.Interface.getMessage('PLEASE_TYPE_A_NUMBER_MSG'),
                    "L#" : RightNow.Interface.getMessage('PLEASE_TYPE_A_NUMBER_MSG'),
                    "M#" : RightNow.Interface.getMessage('PLEASE_TYPE_A_NUMBER_MSG'),
                    "UA" : RightNow.Interface.getMessage('PLEASE_ENTER_UPPERCASE_LETTER_MSG'),
                    "UL" : RightNow.Interface.getMessage('PLEASE_ENTER_AN_UPPERCASE_LETTER_MSG'),
                    "UC" : RightNow.Interface.getMessage('PLS_ENTER_UPPERCASE_LETTER_SPECIAL_MSG'),
                    "LA" : RightNow.Interface.getMessage('PLEASE_ENTER_LOWERCASE_LETTER_MSG'),
                    "LL" : RightNow.Interface.getMessage('PLEASE_ENTER_A_LOWERCASE_LETTER_MSG'),
                    "LC" : RightNow.Interface.getMessage('PLS_ENTER_LOWERCASE_LETTER_SPECIAL_MSG'),
                    "MA" : RightNow.Interface.getMessage('PLEASE_ENTER_A_LETTER_OR_A_NUMBER_MSG'),
                    "ML" : RightNow.Interface.getMessage('PLEASE_ENTER_A_LETTER_MSG'),
                    "MC" : RightNow.Interface.getMessage('PLEASE_ENTER_LETTER_SPECIAL_CHAR_MSG'),
                    "LEN" : RightNow.Interface.getMessage('THE_INPUT_IS_TOO_LONG_MSG'),
                    "MISS" : RightNow.Interface.getMessage('THE_INPUT_IS_TOO_SHORT_MSG') };
            }
            var message = "",
                  sampleMaskString = this._getSimpleMaskString().split("");
            for(var i = 0, type; i < error.length; i++)
            {
                type = error[i][1];
                //F means format char should have followed
                if(type.charAt(0) === "F")
                {
                    message += "<b>" + RightNow.Interface.getMessage('CHARACTER_LBL') + " " + (error[i][0] + 1) + "</b> " + RightNow.Interface.getMessage('WAITING_FOR_CHARACTER_LBL') + type.charAt(1) + " ' <br/>";
                    sampleMaskString[(error[i][0])] = "<span style='color:#F00;'>" + sampleMaskString[(error[i][0])] + "</span>";
                }
                else
                {
                    if(type !== "MISS")
                    {
                        message += "<b>" + RightNow.Interface.getMessage('CHARACTER_LBL') + " " + (error[i][0] + 1) + "</b> " + this._showMaskMessage._maskMessages[type] + "<br/>";
                        if(type !== "LEN")
                        {
                            sampleMaskString[(error[i][0])] = "<span style='color:#F00;'>" + sampleMaskString[(error[i][0])] + "</span>";
                        }
                        else
                        {
                            break;
                        }
                    }
                }
            }
            sampleMaskString = sampleMaskString.join("");
            this._setMaskMessage(RightNow.Interface.getMessage('EXPECTED_INPUT_LBL') + ": "  + sampleMaskString + "<br/>" + message);
            this._showMask();
        }
    },

    /**
    * Sets mask message.
    * @param message String message to set
    */
    _setMaskMessage: function(message)
    {
        ((this._maskNode.body) ? this._maskNode.body : this._maskNode).innerHTML = message;
    },

    /**
    * Shows mask message.
    */
    _showMask: function()
    {
        if(this._maskNode.show)
            this._maskNode.show();
        else
            myNode.removeClass(this._maskNode, "rn_Hidden");
    },

    /**
     * Hides mask message.
     */
    _hideMaskMessage: function()
    {
        if(this._maskNode.cfg && this._maskNode.cfg.getProperty("visible") !== false)
              this._maskNode.hide();
        else if(!this._maskNode.cfg)
            myNode.addClass(this._maskNode, "rn_Hidden");
    },
/**
 * ----------------------------------------------
 * Password Validation
 * ----------------------------------------------
 */
    /**
     * Builds the password validation overlay and subscribes to
     * relevant DOM events.
     */
    _initializePasswordOverlay: function() {
        var Event = Y.Event,
            type = (this._fieldName === 'password_verify') ? 'validation' : 'input',
            element = this._inputField;

        if (type === 'validation') {
            Event.addListener(element, "keyup", this._validatePasswordValidation, type, this);
            var passwordValidationHandler = function(evt, args) {
                this._validatedPassword = args[0].data.password;
                this._approvedPassword = evt.indexOf('fail') === -1;
            };
            RightNow.Event.subscribe('evt_passwordValidation:pass', passwordValidationHandler, this);
            RightNow.Event.subscribe('evt_passwordValidation:fail', passwordValidationHandler, this);
            Event.addListener(element, "focus", function(e, type) {
                if (this._approvedPassword) {
                    this._showPasswordOverlay(e, type);
                }
            }, type, this);
        }
        else {
            if (!this.data.js.passwordValidations) {
                // No requirements. But fire a validation event on blur for password validation instance.
                Event.addListener(element, 'blur', function() {
                    var eo = new RightNow.Event.EventObject();
                    eo.data.password = element.value;
                    eo.w_id = this.instanceID;
                    RightNow.Event.fire('evt_passwordValidation:pass', eo);
                }, null, this);
                return;
            }
            Event.addListener(element, "focus", this._showPasswordOverlay, type, this);
            Event.addListener(element, "keyup", this._validatePasswordInput, type, this);
        }
        Event.addListener(element, "blur", this._passwordBlurValidation, type, this);
        Event.addListener(element, "keydown", function(e, type) {
            // Blur listener needs to know that the blur happened
            // via keyboard so that it doesn't prevent shift+tab blur
            if (e.keyCode === TABKEY) {
                this._passwordBlurValidation((e.shiftKey) ? false : e, type);
            }
        }, type, this);
    },
    
    /**
     * Shows the overlay. Creates the overlay if it doesn't already exist.
     * @param {Object} e Focus event
     * @param {String} type The element to attach the overlay onto (input|validation)
     */    
    _showPasswordOverlay: function(e, type) {
        var name = type + "Overlay";
        if (!this[name]) {
            var content = document.getElementById('rn_' + this.instanceID + '_PasswordOverlay'),
                overlay = document.createElement("span"),
                removeClass = (type === 'input') ? 'rn_Hidden' : 'rn_ScreenReaderOnly';
            
            myNode.removeClass(content, removeClass);
            myNode.insertAfter(overlay, this._inputField);
            
            if (Y.Overlay) {
                overlay = new Y.Overlay(overlay);
                overlay.setBody(content);
                overlay.render();
            }
            else {
                if (typeof content === 'string') {
                    overlay.innerHTML = content;
                }
                else {
                    overlay.appendChild(content);
                }
                overlay = {
                    body: overlay,
                    hide: function() { myNode.addClass(this.body, 'rn_Hidden'); },
                    show: function() { myNode.removeClass(this.body, 'rn_Hidden'); },
                    cfg: {
                        setProperty: function(prop, val) {
                            if (prop === 'zIndex') {
                                myNode.setStyle(this.body, prop, val);
                            }
                        },
                        getProperty: function(prop) {
                            if (prop === 'visible') {
                                return !myNode.hasClass(this.body, 'rn_Hidden');
                            }
                        }
                    }
                };
            }
            this[name] = overlay;
        }
        // Static z-index property to make sure that the currently-showing overlay
        // isn't underneath a different overlay
        this._showPasswordOverlay.zIndex || (this._showPasswordOverlay.zIndex = 1);
        this[name].cfg.setProperty('zIndex', this._showPasswordOverlay.zIndex++);
        this[name].show();
    },
    
    /**
     * Performs validation on blur.
     * If validation succeeds then the overlay is hidden;
     * If validation fails, the appropriate class names
     * are added and the overlay remains open.
     * @param {Object} e Blur event
     * @param {String} type The element perform validation on (input|validation)
     */
    _passwordBlurValidation: function(e, type) {
        var overlay = this[type + 'Overlay'];

        if (!overlay || this._alreadyBlurring) return;

        if (e === false) {
            overlay.hide();
            return;
        }
        
        var classMethod;
        if (this["_validatePassword" + type.charAt(0).toUpperCase() + type.slice(1)](true)) {
            overlay.hide();
            classMethod = 'removeClass';
        } 
        else {
            if (e.keyCode) {
                // Focus on the overlay only if keypress
                // triggered the blur (screen readers)
                var child = overlay.body.childNodes[0];
                child.setAttribute("tabIndex", "-1");
                this._alreadyBlurring = true;
                child.focus();
                this._alreadyBlurring = false;
            }
            else if (type === 'validation') {
                overlay.hide();
            }
            classMethod = 'addClass';
            if (e.keyCode === TABKEY && !e.shiftKey && overlay.cfg.getProperty('visible')) {
                // Stop the tab event from skipping
                // the validation overlay's focus
                Y.Event.preventDefault(e);
            }
        }
        myNode[classMethod]('rn_' + this.instanceID + '_Label', 'rn_ErrorLabel');
        myNode[classMethod](this._inputField, "rn_ErrorField");
    },
    
    /**
    * Password validation class names.
    * @type Object
    */
    _validationClasses: {
        fail: "rn_Fail",
        pass: "rn_Pass"
    },
    
    /**
     * Validates the password field.
     * @param {Object} e DOM event
     * @return {Boolean} Whether validation succeeded or failed
     */
    _validatePasswordInput: function(e) {
        if (e.keyCode === TABKEY) return;
 
        var className, passed = 0, total = 0,
            password = this._inputField.value,
            validations = this.data.js.passwordValidations,
            checks = this._getPasswordStats(password);

        // Check failures and update checklist
        for (var i in checks) {
            if (checks.hasOwnProperty(i)) {
                if (!validations[i]) continue;

                if ((validations[i].bounds === 'max' && checks[i] > validations[i].count) || 
                    (validations[i].bounds === 'min' && checks[i] < validations[i].count)) {
                    className = 'fail';
                }
                else {
                    passed++;
                    className = 'pass';
                }
                this._updatePasswordChecklist(i, className);
                total++;
            }
        }

        // Update progress meter
        var quotient = passed / total,
            label;
        
        if (quotient === 1) {
            className = "rn_AllValidations";
            label = RightNow.Interface.getMessage("PERFECT_LBL");
        }
        else if (quotient > 0.3) {
            className = "rn_SomeValidations";
            label = RightNow.Interface.getMessage("PASSWORD_IS_TOO_INSECURE_MSG");
        }
        else {
            className = "rn_NoValidations";
            label = RightNow.Interface.getMessage("PASSWORD_IS_TOO_SHORT_MSG");
        }
        myNode.addClass(myNode.all('rn_Title', 'div', 'rn_' + this.instanceID + '_PasswordOverlay'), 'rn_Hidden');
        var container = myNode.all(function(node) {
                return myNode.hasClass(node, 'rn_Strength');
            }, 'div', 'rn_' + this.instanceID + '_PasswordOverlay'),
            meter = myNode.all('rn_Meter', 'div', container);
        myNode.removeClass(container, 'rn_Hidden');
        if (meter[0]) {
            meter[0].innerHTML = '<div class="' + className + '"></div>';
            meter = document.getElementById('rn_' + this.instanceID + '_MeterLabel');
            if (meter) {
                meter.innerHTML = label;
            }
        }

        // Notify listeners
        var eo = new RightNow.Event.EventObject();
        eo.data.password = password;
        eo.w_id = this.instanceID;
        RightNow.Event.fire('evt_passwordValidation:' + ((quotient === 1)
            ? 'pass'
            : 'fail'), eo);

        return quotient === 1;
    },

    /**
     * Finds the corresponding list-item for the specified name
     * and updates its class name and screen reader text.
     * @param {string} name of the item to lookup via its
     *      data-validate attribute
     * @param {string} name Either 'pass' or 'fail'
     */
    _updatePasswordChecklist: function(name, action) {
        this._passwordChecklist || (this._passwordChecklist = document.getElementById("rn_" + this.instanceID + "_Requirements"));

        var className = this._validationClasses[action],
            label = ((action === 'pass')
            ? RightNow.Interface.getMessage("COMPLETE_LBL") 
            : RightNow.Interface.getMessage("INCOMPLETE_LBL"));
    
        myNode.all(function(node) {
            if (node.parentNode.getAttribute('data-validate') === name) {
                // Overwrite any existing className
                node.parentNode.className = className;
                return true;
            }
        }, 'span', this._passwordChecklist).innerHTML = label;
    },

    /**
     * Computes various items for the given password text.
     * @param {string} password Password text
     * @return {object} The stats recorded for the text:
     *  - repetitions: max number of character repetitions
     *  - occurrences: max number of character occurrences
     *  - uppercase: number of uppercase characters
     *  - lowercase: number of lowercase characters
     *  - special: number of special characters
     *  - specialAndDigits: number of special characters
     *      and digits
     *  - length: length of the string
     */
    _getPasswordStats: function(password) {
        var checks = {
                repetitions: 0,
                occurrences: 0,
                uppercase: 0,
                lowercase: 0,
                special: 0,
                specialAndDigits: 0,
                length: 0
            },
            len = password.length,
            lastChar = '',
            i, j, char, occur, reps,
            lc, uc;

        for (i = 0; i < len; i++) {
            occur = 0;
            char = password[i] || password.substr(i, 1);

            if (char === lastChar) {
                reps++;
                if (reps > checks.repetitions) {
                    checks.repetitions = reps;
                }
            }
            else {
                lastChar = char;
                reps = 1;
            }

            for (j = 0; j < len; j++) {
                if ((password[j] || password.substr(j, 1)) === char) {
                    occur++;
                }
            }
            if (occur > checks.occurrences) {
                checks.occurrences = occur;
            }

            uc = char.toLocaleUpperCase();
            lc = char.toLocaleLowerCase();

            if (uc === lc && lc === char) {
                // Special char or digit
                if (!isNaN(parseInt(char, 10))) {
                    checks.specialAndDigits++;
                }
                else {
                    checks.specialAndDigits++;
                    checks.special++;
                }            
            }
            else if (lc === char) {
                checks.lowercase++;
            }
            else if (uc === char) {
                checks.uppercase++;
            }
        }
        checks.length = len;

        return checks;
    },
    
    /**
     * Validates the password validation field.
     * @return {Boolean} Whether validation succeeded or failed
     */
    _validatePasswordValidation: function() {
        if (typeof this._validatedPassword === 'undefined') {
            this._validatedPassword = '';
        }

        var className;
        if (this._validatedPassword === this._inputField.value) {
            className = this._validationClasses.pass;
        }
        else {
            className = this._validationClasses.fail;
        }
        if (this.validationOverlay) {
            // Overwrite any existing class name
            this.validationOverlay.body.className = className;
        }
        
        return className === this._validationClasses.pass;
    }

});


