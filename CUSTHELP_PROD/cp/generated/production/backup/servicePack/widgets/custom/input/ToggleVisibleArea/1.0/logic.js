RightNow.namespace('Custom.Widgets.input.ToggleVisibleArea');
Custom.Widgets.input.ToggleVisibleArea = RightNow.Widgets.TextInput.extend({ 
    /**
     * Place all properties that intend to
     * override those of the same name in
     * the parent inside `overrides`.
     */
    overrides: {
        /**
         * Overrides RightNow.Widgets.TextInput#constructor.
         */
        constructor: function() {
            //alert("in custom toggle area logic");
            // Call into parent's constructor
            this.parent();
            
            //alert(this.input);
            //if(this.data.attrs.toggle_div_name)
            //	alert(this.data.attrs.toggle_div_name);
            this._parentContainer = this.Y.one("#rn_" + this.instanceID + "_child");
            //alert(this._parentContainer);
 
		    this._toggleArea = this.Y.one(this.data.attrs.toggle_div_name); 
		
			//alert(this._toggleArea);
			
		    //YAHOO.util.Dom.addClass(this._parentContainer, 'rn_Hidden');
		
		    this._value1 = false;
		    this._value2 = false;
		
		    RightNow.Event.subscribe('evt_questiontype', this._doAction, this);
		    RightNow.Event.subscribe('evt_selectiontype', this._doAction2, this);
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
		//alert(this.data.attrs.hideon_notequal_value);
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
       var hideonValuesNE = this.data.attrs.hideon_notequal_value.split(",");
       
       var testValue = myData;
       this._value2 = false;

       if(!this.data.attrs.always_show)
         this._parentContainer.addClass('rn_Hidden');
       else
       	this._parentContainer.removeClass('rn_Hidden');
 
		for(var i=0; i<dispValues.length; i++) {
			//alert(dispValues[i]);
			if(dispValues[i].indexOf(myData) > -1) {
				this._parentContainer.removeClass('rn_Hidden');
				if(this.data.attrs.toggle_div_name)
					this._toggleArea.removeClass('rn_Hidden');
						
			}
		}
    },

    _doAction2 : function (evt, args) {

		//alert("in doAction2");
		//alert(this.data.attrs.display_value);
		//alert(this.data.attrs.hideon_notequal_value);
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
		var hideonValuesNE = this.data.attrs.hideon_notequal_value.split(",");
		
		var testValue = myData;
		this._value2 = false;
		
		for(var i=0; i<dispValues.length; i++) {
			//alert(dispValues[i]);
			if(dispValues[i].indexOf(myData) > -1) {
				this._value2 = true;
				if(this._value1 && this._value2) {
					this._parentContainer.removeClass('rn_Hidden');
					if(this.data.attrs.toggle_div_name)
						this._toggleArea.addClass('rn_Hidden');
				}
			}
		}
    }
});