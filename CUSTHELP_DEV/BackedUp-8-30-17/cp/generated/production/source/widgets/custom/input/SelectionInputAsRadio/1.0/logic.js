RightNow.namespace('Custom.Widgets.input.SelectionInputAsRadio');
Custom.Widgets.input.SelectionInputAsRadio = RightNow.Widgets.SelectionInput.extend({ 
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
            
                    
            
            //alert("radio input before");
            radioID = '#' + this.baseDomID;
            selectID = this.baseDomID + '_' + this.data.js.name;
            var _fldname = this.data.js.name;
			
			         
            //alert(document.getElementById(selectID)); 
            //alert(selectID);
            //this._select = Y.one(this.baseDomID + '_' + this.data.js.nameD);
         
            //alert(this.Y.one(radioID));
            this.input = this.Y.one(radioID).delegate('click', function (e) {
				var eventObject = new RightNow.Event.EventObject(this, {data: {eventSubject: e.target.get('value')}});
		        if (RightNow.Event.fire("evt_questiontype", eventObject)) {
		        	//alert("in here");
		        	//alert(e.target.get('value'));
		        	//alert(radioID);
		            //return fireResponse(value, eventObject);
					//alert(this);
					//alert(this.get('id'));
					//var selectedValue =  e.target.get('value');					
					//var myData = this.get('id');
					//myData = myData.substring(0,myData.length-5);
					//myData = "#" . myData;
					//myData=myData.replace(/"/g, '');
					//myData=myData.replace(/_/g, '=');
					//myData=myData.replace(/}/g, '');
					//alert(myData);
					
					//alert(_fldname);
					
					//this.select.set('value', selectedValue);
					//document.getElementById(selectID).value = selectedValue;
					//alert(this.data.attrs.display_value.indexOf(myData) > -1);
		            
		        }
		        alert("in here2");
		        //alert(myData);
		        //alert(document.getElementById(selectID).value);
				
  			}, 'input[type=radio]');
  			
  			
            //var fieldName = this.data.js.name;
            //alert(fieldName);
            
            //if(fieldName === "Incident.CustomFields.c.elevatesubject") {
            //    this.on("click", this.elevateSubjectChanged, this);
          
            //}
            
            
                      
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

    _setHidden : function (evt, args) {
		alert("in setHidden");
		//alert(this.data.attrs.display_value);
		//alert(this.data.attrs.hideon_value);
		//alert(args[0].data.fieldname+'='+args[0].data.value);
		//alert(evt);
		alert(args);
		//alert(JSON.stringify(args[0].data, null, 0));
		var myData = JSON.stringify(args[0].data,null,0);
		myData = myData.substring(myData.indexOf(':')+1,myData.length);
		myData=myData.replace(/"/g, '');
		myData=myData.replace(/_/g, '=');
		myData=myData.replace(/}/g, '');
		alert(myData);
		//alert(this.data.attrs.display_value.indexOf(myData) > -1);
		
       /* var dispValues = this.data.attrs.display_value.split(",");
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
        }*/

       
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