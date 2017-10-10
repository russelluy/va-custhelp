RightNow.namespace('Custom.Widgets.input.CustomSelectionInput');
Custom.Widgets.input.CustomSelectionInput = RightNow.Widgets.SelectionInput.extend({ 
    /**
     * Place all properties that intend to
     * override those of the same name in
     * the parent inside `overrides`.
     */
    overrides: {
        /**
         * Overrides RightNow.Widgets.SelectionInput#constructor.
         */
        constructor: function() {
            // Call into parent's constructor
            this.parent();
            
            this._parentContainer = this.Y.one("#rn_" + this.instanceID + "_child");
            //alert(this._parentContainer);
            var _fldName = this.data.js.name;
            
            //alert(this.parentContainer);
            if(this.data.attrs.trigger_change_event)
		    {
		        this._inputField.on('change', this._selectionChanged, this);
		    }
            RightNow.Event.on('evt_questiontype', this._doAction, this);
        }

        /**
         * Overridable methods from SelectionInput:
         *
         * Call `this.parent()` inside of function bodies
         * (with expected parameters) to call the parent
         * method being overridden.
         */
        // swapLabel: function(container, requiredness, label, template)
        // constraintChange: function(evt, constraint)
        // onValidate: function(type, args)
        // displayError: function(errors, errorLocation)
        // toggleErrorIndicator: function(showOrHide)
        // blurValidate: function()
        // countryChanged: function()
        // successHandler: function(response)
        // onProvinceResponse: function(type, args)
        // onStatusChanged: function()
    },

    /**
     * Event handler executed when form is being submitted
     *
     * @param type String Event name
     * @param args Object Event arguments
     */
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
						
			if(!this.data.attrs.always_show)
				this._parentContainer.addClass('rn_Hidden');
			else
				this._parentContainer.removeClass('rn_Hidden');
			
			this.data.attrs.required = false;
			
			for(var i=0; i<dispValues.length; i++) {
				//alert(dispValues[i]);
				if(dispValues[i].indexOf(myData) > -1) {
					//alert('remove class disp value');
					this._parentContainer.removeClass('rn_Hidden');
					this.data.attrs.required = true;
				}
			}

    },

    _selectionChanged: function(e, args)
    {

      if(args.data.js.type === RightNow.Interface.Constants.EUF_DT_RADIO) {


        var eo = new RightNow.Event.EventObject();
        eo.data.name = "selection changed";
        eo.data.value = args._inputField[0].checked;
        eo.data.fieldname = args.data.attrs.name;
        RightNow.Event.fire("evt_selectiontype", eo);

      }
      else { 
        var eo = new RightNow.Event.EventObject();
        eo.data.name = "selection changed";
        eo.data.value = args._inputField.options[args._inputField.selectedIndex].value;
        eo.data.fieldname = args.data.attrs.name;
        RightNow.Event.fire("evt_selectiontype", eo);
      }
    }
});