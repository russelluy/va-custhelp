RightNow.namespace('Custom.Widgets.input.CustomDateInput');
Custom.Widgets.input.CustomDateInput = RightNow.Widgets.DateInput.extend({ 
    /**
     * Place all properties that intend to
     * override those of the same name in
     * the parent inside `overrides`.
     */
    overrides: {
        /**
         * Overrides RightNow.Widgets.DateInput#constructor.
         */
        constructor: function() {
            //alert("in custom date logic");
            // Call into parent's constructor
            this.parent();
            
            //alert(this.input);
            //alert(this._inputSelctor);
            this._parentContainer = this.Y.one("#rn_" + this.instanceID + "_child");
            //alert(this._parentContainer);
            
            //alert(this.parentContainer);
            RightNow.Event.on('evt_questiontype', this._doAction, this);
			RightNow.Event.on('evt_selectiontype', this._doAction, this);
			
			//alert(this.data.attrs.display_value);
        }

        /**
         * Overridable methods from DateInput:
         *
         * Call `this.parent()` inside of function bodies
         * (with expected parameters) to call the parent
         * method being overridden.
         */
        // swapLabel: function(container, requiredness, label, template)
        // constraintChange: function(evt, constraint)
        // onValidate: function(type, args)
        // displayError: function(errors, errorLocation)
        // toggleErrorIndicator: function(showOrHide, fieldsToHighlight)
        // blurValidate: function()
        // validateValue: function(errors)
        // _getDateFieldValue: function(fieldName)
    },

    _doAction : function (evt, args) {
		//alert("in doAction Date");
		//alert(this.data.attrs.display_value);
		//alert(evt);
		//alert(JSON.stringify(args[0].data, null, 0));
		var myData = JSON.stringify(args[0].data,null,0);
		myData = myData.substring(myData.indexOf(':')+1,myData.length);
		myData=myData.replace(/"/g, '');
		myData=myData.replace(/_/g, '=');
		myData=myData.replace(/}/g, '');
		//alert(myData); 
		//alert(this.data.attrs.display_value.indexOf(myData) > -1);
		
       var dispValues = this.data.attrs.display_value.split(",");
       
       var dispValues = this.data.attrs.display_value.split(",");


       if(!this.data.attrs.always_show)
         this._parentContainer.addClass('rn_Hidden');
       else {
       	 this._parentContainer.removeClass('rn_Hidden');
         this.data.attrs.required = false;
	   }
       for(var i=0; i<dispValues.length; i++) {
         if(dispValues[i].indexOf(myData) > -1) {
           this._parentContainer.removeClass('rn_Hidden');
           this.data.attrs.required = true;
         }
       }
        
	
    }
});