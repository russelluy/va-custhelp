RightNow.namespace('Custom.Widgets.input.CustomFormSubmit');
Custom.Widgets.input.CustomFormSubmit = RightNow.Widgets.FormSubmit.extend({ 
    /**
     * Place all properties that intend to
     * override those of the same name in
     * the parent inside `overrides`.
     */
    overrides: {
        /**
         * Overrides RightNow.Widgets.FormSubmit#constructor.
         */
        constructor: function() {
            //alert("in custom text logic");
            // Call into parent's constructor
            
            
            this.parent();
            
            //alert(this.input);
            //alert(this._inputSelctor);
            this._parentContainer = this.Y.one("#rn_" + this.instanceID);
            //alert(this._parentContainer);
            
            //alert(this.parentContainer);
            RightNow.Event.on('evt_questiontype', this._doAction, this);
            RightNow.Event.on('evt_selectiontype', this._doAction, this);
            
            RightNow.Event.subscribe('on_before_ajax_reqeust', this._onajaxrequest, this);
           
			
			//alert(this.data.attrs.display_value);

            this._addEventHandler("mysend", {
                post: function(eo) {
                    if (!this._eventCanceled) {
                       FormSubmission.submitForm(this._parentForm, this.data.attrs.add_params_to_url, this);
                    }
                    this._eventCanceled = false;
                },
                during: function(eo) {
                    if (eo === false) {
                        this._eventCanceled = true;
                    }
                }
            })._addEventHandler("mycollect", {
                pre: function() {
                    this._collectedFields = [];
                },
                during: function(fieldName) {
                    if(fieldName) {
                        this._collectedFields.push(fieldName);
                    }
                },
                post: function(eo) {
                    this.fire("submit", eo);
                }

        });},
        _fireSubmitRequest: function() {
        var eo = new RightNow.Event.EventObject(this, {data: {
            form: this._parentForm,
            f_tok: this.data.js.f_tok,
            error_location: this._errorMessageDiv.get("id"),
            timeout: this.data.attrs.timeout * 1000
        }});
        RightNow.Event.fire("evt_formButtonSubmitRequest", eo);
        this.fire("mycollect", eo);
    },

    /**
     * Event handler for when form has been validated.
     */
    _onFormValidated: function() {
        this._toggleLoadingIndicators();
        this.fire("mysend", this.getValidatedFields());
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

    

        _onajaxrequest : function (evt, args) {
		alert("in on ajax request");
	    } 


        /**
         * Overridable methods from TextInput:
         *
         * Call `this.parent()` inside of function bodies
         * (with expected parameters) to call the parent
         * method being overridden.
         */
        // swapLabel: function(container, requiredness, label, template)
        // constraintChange: function(evt, constraint)
        // getVerificationValue: function()
        // onValidate: function(type, args)
        // _displayError: function(errors, errorLocation)
        // toggleErrorIndicator: function(showOrHide, fieldToHighlight, labelToHighlight)
        // _toggleFormSubmittingFlag: function(event)
        // _blurValidate: function(event, validateVerifyField)
        // _validateVerifyField: function(errors)
        // _checkExistingAccount: function()
        // _massageValueForModificationCheck: function(value)
        // _onAccountExistsResponse: function(response, originalEventObject)
        // onProvinceChange: function(type, args)
        // _initializeMask: function()
        // _createMaskArray: function(mask)
        // _getSimpleMaskString: function()
        // _compareInputToMask: function(submitting)
        // _showMaskMessage: function(error)
        // _setMaskMessage: function(message)
        // _showMask: function()
        // _hideMaskMessage: function()
        // _onValidateFailure: function()
    },

    _doAction : function (evt, args) {
		//alert("in doAction");
		//alert(this.data.attrs.display_value);
		//alert(this.data.attrs.hideon_value);
		//alert(args[0].data.fieldname+'='+args[0].data.value);
		//alert(evt);
		//alert(args);
		//alert(JSON.stringify(args[0].data, null, 0));
		var myData = JSON.stringify(args[0].data,null,0);
		myData = myData.substring(myData.indexOf(':')+1,myData.length);
		myData=myData.replace(/"/g, '');
		myData=myData.replace(/_/g, '=');
		myData=myData.replace(/}/g, '');
		//alert(myData);
		//alert(this.data.attrs.display_value.indexOf(myData) > -1);
		
       var dispValues = this.data.attrs.display_value.split(",");
       var hideonValues = this.data.attrs.hideon_value.split(",");
       var testValue = myData;
       var matchHide = 0;

       if(!this.data.attrs.always_show)
         this._parentContainer.addClass('rn_Hidden');
       this.data.attrs.required = false;
 
       for(var i=0; i<dispValues.length; i++) {
	     //alert(dispValues[i]);
         if(dispValues[i].indexOf(myData) > -1) {
	       //alert('remove class disp value');
           this._parentContainer.removeClass('rn_Hidden');
           this.data.attrs.required = true;
         }
       }
       
       //gsh experimental
       if(hideonValues.length>0 && hideonValues[0] != "") {
         for(var i=0; i<hideonValues.length; i++) {
           if(hideonValues[i].indexOf(myData) > -1) {
             this._parentContainer.addClass('rn_Hidden');
             matchHide = 1;
           }
         }
       }
      
       if(matchHide == 0)
       	 this._parentContainer.removeClass('rn_Hidden');


    },
        /**
     * Event handler for when form has been validated.
     */

});
var FormSubmission = (function() {
    var allFields = {},
        validatedFields = {};

    /**
    * Submits a GET form to a CP controller by converting
    * the form's fields to segments and navigating to the controller
    * via a hyperlink (in order to properly replicate the form's target).
    * @param {Object} form YUI form node
    * @param {String} action The form's action / URL to navigate to
    * @param {String} parametersToAdd any additonal url parameters to add
    * @param {Object} scope context to use for YUI instance
    * @private
    * assert - The form's method is GET and the form's default submittal
    * event has already been canceled.
    */
    function _submitCPGetForm(form, action, parametersToAdd, scope) {
        var fields = {},
            target = form.getAttribute("target");

        form.all('input, select, textarea').each(function(element) {
            var type = element.get("type"),
                name = element.get("name");
            if (name !== "" && type !== "submit" && type !== "image") {
                fields[element.get("name")] = element.get("value");
            }
        });

        var url = action + RightNow.Url.convertToSegment(fields) + parametersToAdd;
        if (RightNow.Url.getSession()) {
            url = RightNow.Url.addParameter(url, "session", RightNow.Url.getSession());
        }

        var link = scope.Y.Node.create("<a class='rn_Hidden'>form</a>").setAttribute("href", url);
        if (target) {
            link.setAttribute("target", target);
        }
        scope.Y.one(document.body).append(link);
        link = scope.Y.Node.getDOMNode(link);

        if (document.createEvent) {
            var click = document.createEvent("MouseEvents");
            click.initEvent("click", false, false);
            link.dispatchEvent(click);
        }
        else { /* IE */
            link.fireEvent("onclick");
        }
    }

    /**
     * Callback for the ajax request. Expects its scope to be a Form instance.
     * @private
     * @param {Object} responseObject Response from the server
     */
    function _serverResponse(responseObject) {
        this.fire("response", new RightNow.Event.EventObject(this, {data: responseObject}));
    }

    /**
     * Callback when the ajax request fails (non-200 response code).
     * @param  {Object} responseObject Ajax response data
     */
    function _serverErrorResponse(responseObject) {
        this.fire("responseError", new RightNow.Event.EventObject(this, {data: responseObject}));
    }

    function _sendFormRequest(url, scope, fields) {
        if(RightNow.Event.noSessionCookies()) {
            // Attempt to set a test login cookie if the form contains the contact login field.
            for(var i = 0, length = fields.length; i < length; i++) {
                if(fields[i].name === 'Contact.Login') {
                    document.cookie = "cp_login_start=1;path=/";
                    break;
                }
            }
        }

        var postData = {
                f_tok: scope._originalEventObject.data.f_tok,
                form: RightNow.JSON.stringify(fields),
                updateIDs: RightNow.JSON.stringify({
                    "asset_id": RightNow.Url.getParameter("asset_id"),
                    "product_id": RightNow.Url.getParameter("product_id"),
                    "serial_no": RightNow.Url.getParameter("serial_no"),
                    "i_id": RightNow.Url.getParameter("i_id")
                })
            },
            requestOptions = {
                scope: scope,
                json: true,
                successHandler: _serverResponse,
                failureHandler: _serverErrorResponse
            },
            Form = RightNow.UI.Form;

        if (Form.smartAssistant != null) {
            postData.smrt_asst = Form.smartAssistant;
        }
        if (Form.smartAssistantToken !== null) {
            postData.saToken = Form.smartAssistantToken;
        }

        if (scope._originalEventObject) {
            if (scope._originalEventObject.data.timeout) {
                requestOptions.timeout = scope._originalEventObject.data.timeout;
            }

            requestOptions =
            (function(target, source) {
                var members = ["challengeHandler", "challengeHandlerContext"],
                    i, m;
                    for (i = 0; i < members.length; ++i) {
                        m = members[i];
                        target[m] = source[m] || undefined;
                    }
                return target;
            })(requestOptions, scope._originalEventObject);
        }

        RightNow.Ajax.makeRequest(url, postData, requestOptions);
    }
return {
     submitForm: function(formID, parametersToAdd, scope) {
        var form = scope.Y.one("#" + formID),
            method = form.getAttribute("method"),
            action = form.getAttribute("action"),
            fields = validatedFields[formID];

        parametersToAdd = parametersToAdd || "";

        if (action && !scope.data.attrs.on_success_url) {
            // Traditional form with "get" method, page flip with data in the URL
            if (method.toLowerCase() !== "post" && (RightNow.Text.beginsWith(action, "/") || !RightNow.Url.isExternalUrl(action))) {
                _submitCPGetForm(form, action, parametersToAdd, scope);
                return;
            }

            // Traditional form with "post", page flip with post data
            if (parametersToAdd) {
                form.set("action", action + parametersToAdd);
            }

            for(var i = 0, field, existingElement; i < fields.length; i++) {
                field = fields[i];
                if(!field || !field.value) continue;

                existingElement = form.one('input[name="' + field.name + '"]');

                // If the value is already on the form that we're going to submit, just ensure the field's value is the same as what we've validated (shouldn't ever differ)
                if(existingElement) {
                    existingElement.set('value', field.value);
                }
                else {
                    form.append(scope.Y.Node.create('<input type="hidden" name="' + field.name + '" value="' + field.value + '"/>'));
                }
            }

            form.submit();
            return;
        }

        // Ajax post to the action specified on the form or the default endpoint
        _sendFormRequest((action || "/cc/ajaxRequest/sendForm") + parametersToAdd, scope, fields);
    },

    resetValidatedFields: function(formID) {
        validatedFields[formID] = [];
    },

    addValidatedField: function(formID, eventObject) {
        if (!validatedFields[formID]) {
            this.resetFormFields(formID);
        }
        delete eventObject.data.form;
        validatedFields[formID].push(eventObject.data);
    },

    getValidatedFields: function(formID) {
        return RightNow.Lang.cloneObject(validatedFields[formID]);
    },

    addField: function(formID, name, instance) {
        if(!allFields[formID]) {
            allFields[formID] = {};
        }

        allFields[formID][name] = instance;
    },

    findField: function(formID, name) {
        return allFields[formID][name];
    },

    getAllFields: function(formID) {
        return allFields[formID] || {};
    }
};
})();
