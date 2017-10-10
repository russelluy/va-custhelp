RightNow.namespace('Custom.Widgets.input.SelectionInputAsRadio');
Custom.Widgets.input.SelectionRadioInput = RightNow.Widgets.SelectionInput.extend({ 
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
			this._customFieldID =  this.baseDomID + "_" + this.data.js.name; //this.data.js.name.substring(this.data.js.name.indexOf(".c.") + 1).replace(".", "$");
			this._customDummyFieldName = this.baseDomID +  "_CloneRadioInput";
			this._customDummyFieldID = "rn_" + this.instanceID + "_CloneRadioInput";
			thePos = this._customDummyFieldID.search(/\d/);
			this._customRadioDivName = this._customDummyFieldID.substring(0, thePos-1) + "_RadioDiv";
			this._customRadioName = this._customDummyFieldID.substring(0, thePos-1) + "_Radio";
			//alert(this._customRadioName);
			
			//this.input.hide();

			this._cloneSelectAsRadio();
			
			//alert(this._customRadioDivName);
			//this._customRadioDivName.input.show();
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
     * Adds error messages to the common error element and adds
     * error indicators to the widget field and label.
     * @param {Array} errors Error messages
     * @param {String} errorLocation ID of the common error element
     */
    _cloneSelectAsRadio: function() {
        var selectDiv = this.Y.one("#" + this.baseDomID);
        if(selectDiv) {
			var html="<div data-field='" + this._customDummyFieldName + "_field\' id='" + this._customRadioDivName + "'>";
			var myObject = document.getElementById(this._customFieldID);
		 
 			for(var i=0;i<myObject.options.length;i++)
			{
				if(myObject.options[i].value != "")
				{
					//ryan fix for "selected" issue
					$selected = "";
					if (myObject.options[i].value === '1965' || myObject.options[i].value === '1967')
						$selected = "checked";
					//console.log("option #" + i + " has value " + myObject.options[i].value + " and its text is " + myObject.options[i].text);
					html += "<input type=\"radio\" id=\"" + this._customRadioName + "\"   name=\"" + this._customDummyFieldName + "\"  value=\"" + myObject.options[i].value + "\" " + $selected + " >";
					html += "<label>" +  myObject.options[i].text + "</label><br />";
				}
            }
			selectDiv.append(html);
		
			//alert('after append');
			
			//now add onclick to set the value of the "REAL" select object.  Once this works can add a HIDE call in constructor
			var radios = document.getElementsByName(this._customDummyFieldName);
			var fieldID = this._customFieldID;
 			var that = this;
			jQuery(("input[name=" + this._customDummyFieldName + "]")).change(function () {
				var selection=$(this).val();
				//alert("Radio button selection changed. Selected: "+selection + " and field id of "  + fieldID);
				var myObject = document.getElementById(fieldID);

				for(var j=0;j<myObject.options.length;j++)
				{
					console.log("checking options value " + myObject.options[j].value + " and comparing to " + selection);
					if(myObject.options[j].value == selection)
					{
						 
						myObject.options[j].selected = true;
					}
				}
				
				var eventObject = new RightNow.Event.EventObject(this, {data: {eventSubject: selection}});
		        if (RightNow.Event.fire("evt_questiontype", eventObject)) {
		        	//alert("Firing evt_questionType");
		            
		        }

			});
         }
        //this.toggleErrorIndicator(true);
    },
	_setValue: function(setVal)
	{   
		var setVal = this.value;
		alert("looking for sel object with value " + setVal);
		var customDummyFieldID = "rn_" + this.instanceID + "_CloneRadioInput";

		var myObject = document.getElementById( this.baseDomID + "_" + this.data.js.name);

 			for(var i=0;i<myObject.options.length;i++)
			{
				if(myObject.options[i].value == setVal)
				{
					 myObject.options[i].selected = true;
				 

				}
                 
            }

	}

 });