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
			
			//alert(this.data.attrs.display_value);
			
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


    }
});