RightNow.namespace('Custom.Widgets.input.MenuAsRadioWidget');
Custom.Widgets.input.MenuAsRadioWidget = RightNow.Widgets.extend({ 
    /**
     * Widget constructor.
     */
    constructor: function() {
       this.data = data;
       this.instanceID = instanceID;
       this._formErrorLocation = null;
       this._mycontainer = null;
       //Treat radio buttons that we're displaying as checkboxes as a check type
       if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_RADIO && this.data.attrs.display_as_checkbox)
           this.data.js.type = RightNow.Interface.Constants.EUF_DT_CHECK;
   
       if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_RADIO)
           this._inputField = [document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_1"),
               document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_0")];
       else
           this._inputField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name);
       if(!this._inputField || (Y.lang.isArray(this._inputField) && (!this._inputField[0] || !this._inputField[1])))
           return;
   
       if(this.data.js.hint && !this.data.attrs.hide_hint)
           this._initializeHint();
   
       if(this.data.attrs.initial_focus && this._inputField)
       {
           if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_RADIO && this._inputField[0] && this._inputField[0].focus)
               this._inputField[0].focus();
           else if(this._inputField.focus)
               this._inputField.focus();
       }
   
       if(this.data.attrs.validate_on_blur && this.data.attrs.required)
           Y.Event.addListener(this._inputField, "blur",
               function() { this._formErrorLocation = null; this._validateRequirement(); }, null, this);
   
       RightNow.Event.subscribe("evt_formFieldValidateRequest", this._onValidate, this);
       //specific events for specific fields:
       var fieldName = this.data.js.name;
       //province changing
       if(fieldName === "country_id")
       {
           Y.Event.addListener(this._inputField,"change", this._countryChanged, null, this);
           if(this.data.attrs.default_value)
               this._countryChanged();
       }
       else if(fieldName === "prov_id")
       {
           RightNow.Event.subscribe("evt_formFieldProvinceResponse", this._onProvinceResponse, this);
       }
   
       this._fldName = this.data.attrs.name;
   
       this._init(this.data.js.prev);

    },

    /**
    * ----------------------------------------------
    * Form / UI Events and Functions:
    * ----------------------------------------------
    */
       
       _init: function(id)
       {
         var eo = new RightNow.Event.EventObject();
         eo.data.name = "selection changed";
         eo.data.value = id;
         eo.data.fieldname = this._fldName; 
         RightNow.Event.fire("evt_questiontype", eo);
   
   
         var container = Y.Node.create('rn_'+this.instanceID); 
         container.on('click', this._selectionChanged, this);
       },
   
   
       /**
        * Event handler executed when form is being submitted
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
   
               if(this._validateRequirement())
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
           RightNow.Event.fire("evt_formFieldCountRequest");
       },
   
       /**
       * Returns the String (Radio/Select) or Boolean value (Check) of the element.
       * @return String/Boolean that is the field value
       */
       _getValue: function()
       {
         var el = Y.Node.create("rn_" + this.instanceID);
         var arrRadio = el.getElementsByTagName("input"); 
         var rdoValue = 0;
         for(var i = 0; i < arrRadio.length; i++) {
        
           if(arrRadio[i].checked)
             rdoValue = arrRadio[i].value; 
     
         }
   
           if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_RADIO)
           {
             return rdoValue;
           }
           else if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_CHECK)
           {
               if(this._inputField.type === "checkbox")
                   return this._inputField.checked;
               return this._inputField.value === "1";
           }
           else
           {
               //select value
               return rdoValue;
           }
       },
   
       /**
        * Validation routine to check if field is required, and if so, ensure it has a value
        * @return Boolean denoting if required check passed
        */
       _validateRequirement: function()
       {
           if(this.data.attrs.required)
           {
               // this widget is all funky.  Should be redone, but no time.
               // thinks it's a select.  It's actual a group of radios
               // but _inputField is a hidden
               var el = Y.Node.create("rn_" + this.instanceID);
               var radios = el.getElementsByTagName("input");
               var retVal = false;
               for(var i = 0; i < radios.length; i++)
               {
                   if(radios[i].checked)
                      retVal = true;
               }
   
               if(!retVal)
               {
                   this._displayError(this.data.attrs.label_required);
               }
               else
               {
                   myNode.removeClass(this._inputField, "rn_ErrorField");
                   myNode.removeClass("rn_" + this.instanceID + "_Label", "rn_ErrorLabel");
               }
               return retVal;
           }
           return true;
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
               afterNode.insert(hint, (Y.lang.isArray(this._inputField) && this._inputField.length) ? this._inputField[this._inputField.length - 1] : this._inputField);
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
           if(Y.lang.isArray(this._inputField))
           {
               //radio buttons
               myNode.setStyle(overlay, "margin-left", "2em");
               afterNode.insert(overlay, this._inputField[this._inputField.length - 1]);
           }
           else
           {
               afterNode.insert(overlay, this._inputField);
           }
   
           overlay = new Y.Overlay(overlay, {visible: visibility});
           overlay.setBody(this.data.js.hint);
           overlay.render();
           
           return overlay;
       },
  
       /**
        * Displays error by appending message above submit button
        * @param errorMessage String Message to display
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
   
                   var elementId = (Y.Lang.isArray(this._inputField)) ? this._inputField[0].id : this._inputField.id,
                       inputLabel = this.data.attrs.label_error || this.data.attrs.label_input,
                       label = (errorMessage.indexOf("%s") > -1) ?  RightNow.Text.sprintf(errorMessage, inputLabel) : inputLabel + ' ' +  errorMessage;
   
                   commonErrorDiv.innerHTML += "<div><b><a href='javascript:void(0);' onclick='document.getElementById(\"" +
                       elementId + "\").focus(); return false;'>" + label + "</a></b></div> ";
               }
           }
          myNode.addClass(this._inputField, "rn_ErrorField");
          myNode.addClass("rn_" + this.instanceID + "_Label", "rn_ErrorLabel");
       },
   /**
    * --------------------------------------------------------
    * Business Rules Events and Functions:
    * --------------------------------------------------------
    */
       /**
        * Event handler executed when country dropdown is changed
        */
       _countryChanged: function()
       {
           if(this._inputField.options)
           {
               var evtObj = new RightNow.Event.EventObject();
               evtObj.data = {"country_id" : this._inputField.options[this._inputField.selectedIndex].value,
                                    "w_id" : this.instanceID};
               RightNow.Event.fire("evt_formFieldProvinceRequest", evtObj);
           }
       },
   
       _selectionChanged: function(e, args)
       {
         var el = Y.Node.create("rn_" + args.instanceID);
         var arrRadio = el.getElementsByTagName("input"); 
       var rdoValue = 0;
       for(var i = 0; i < arrRadio.length; i++) {
      
         if(arrRadio[i].checked)
           rdoValue = arrRadio[i].value; 
   
       }
 
 
       //if(e.srcElement.tagName != "INPUT")
       return false;
 
       var eo = new RightNow.Event.EventObject();
       eo.data.name = "selection changed";
       eo.data.value = rdoValue; // e.srcElement.value;
       eo.data.fieldname = args._fldName;
       RightNow.Event.fire("evt_questiontype", eo);      
 
     },
 
     /**
      * Event handler executed when province/state data is returned from the server
      *
      * @param type String Event name
      * @param args Object Event arguments
      */
     _onProvinceResponse: function(type, args)
     {
 
         var evtObj = args[0],
             options = this._inputField.options,
             aNewOption, i;
         if(evtObj.states)
         {
             options.length = 0;
             if(!evtObj.states[0] || (evtObj.states[0].val !== "--" && !this.data.attrs.hideEmptyOption))
                 evtObj.states.unshift({val: "--", id: ""});
             for(i = 0; i < evtObj.states.length; i++)
             {
                 aNewOption = document.createElement("option");
                 aNewOption.text = evtObj.states[i].val;
                 aNewOption.value = evtObj.states[i].id;
                 options.add(aNewOption);
             }
         }
     }

});


 /* Originating Release: August 2012 */
 RightNow.Widget.MenuAsRadioWidget = function(data, instanceID){
 
     this.data = data;
     this.instanceID = instanceID;
     this._formErrorLocation = null;
     this._mycontainer = null;
     //Treat radio buttons that we're displaying as checkboxes as a check type
     if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_RADIO && this.data.attrs.display_as_checkbox)
         this.data.js.type = RightNow.Interface.Constants.EUF_DT_CHECK;
 
     if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_RADIO)
         this._inputField = [document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_1"),
             document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name + "_0")];
     else
         this._inputField = document.getElementById("rn_" + this.instanceID + "_" + this.data.js.name);
     if(!this._inputField || (Y.lang.isArray(this._inputField) && (!this._inputField[0] || !this._inputField[1])))
         return;
 
     if(this.data.js.hint && !this.data.attrs.hide_hint)
         this._initializeHint();
 
 
     if(this.data.attrs.initial_focus && this._inputField)
     {
         if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_RADIO && this._inputField[0] && this._inputField[0].focus)
             this._inputField[0].focus();
         else if(this._inputField.focus)
             this._inputField.focus();
     }
 
     if(this.data.attrs.validate_on_blur && this.data.attrs.required)
         Y.Event.addListener(this._inputField, "blur",
             function() { this._formErrorLocation = null; this._validateRequirement(); }, null, this);
 
     RightNow.Event.subscribe("evt_formFieldValidateRequest", this._onValidate, this);
     //specific events for specific fields:
     var fieldName = this.data.js.name;
     //province changing
     if(fieldName === "country_id")
     {
         Y.Event.addListener(this._inputField,"change", this._countryChanged, null, this);
         if(this.data.attrs.default_value)
             this._countryChanged();
     }
     else if(fieldName === "prov_id")
     {
         RightNow.Event.subscribe("evt_formFieldProvinceResponse", this._onProvinceResponse, this);
     }
 
     this._fldName = this.data.attrs.name;
 
     this._init(this.data.js.prev);
 
    
 };
 
 RightNow.Widget.MenuAsRadioWidget.prototype = {
 /**
  * ----------------------------------------------
  * Form / UI Events and Functions:
  * ----------------------------------------------
  */
     
     _init: function(id)
     {
       var eo = new RightNow.Event.EventObject();
       eo.data.name = "selection changed";
       eo.data.value = id;
       eo.data.fieldname = this._fldName; 
       RightNow.Event.fire("evt_questiontype", eo);
 
 
       var container = Y.Node.create('rn_'+this.instanceID); 
       container.on('click', this._selectionChanged, this);
     },
 
 
     /**
      * Event handler executed when form is being submitted
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
 
             if(this._validateRequirement())
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
         RightNow.Event.fire("evt_formFieldCountRequest");
     },
 
     /**
     * Returns the String (Radio/Select) or Boolean value (Check) of the element.
     * @return String/Boolean that is the field value
     */
     _getValue: function()
     {
       var el = Y.Node.create("rn_" + this.instanceID);
       var arrRadio = el.getElementsByTagName("input"); 
       var rdoValue = 0;
       for(var i = 0; i < arrRadio.length; i++) {
      
         if(arrRadio[i].checked)
           rdoValue = arrRadio[i].value; 
   
       }
 
         if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_RADIO)
         {
           return rdoValue;
         }
         else if(this.data.js.type === RightNow.Interface.Constants.EUF_DT_CHECK)
         {
             if(this._inputField.type === "checkbox")
                 return this._inputField.checked;
             return this._inputField.value === "1";
         }
         else
         {
             //select value
             return rdoValue;
         }
     },
 
     /**
      * Validation routine to check if field is required, and if so, ensure it has a value
      * @return Boolean denoting if required check passed
      */
     _validateRequirement: function()
     {
         if(this.data.attrs.required)
         {
             // this widget is all funky.  Should be redone, but no time.
             // thinks it's a select.  It's actual a group of radios
             // but _inputField is a hidden
             var el = Y.Node.create("rn_" + this.instanceID);
             var radios = el.getElementsByTagName("input");
             var retVal = false;
             for(var i = 0; i < radios.length; i++)
             {
                 if(radios[i].checked)
                     retVal = true;
             }
 
             if(!retVal)
             {
                 this._displayError(this.data.attrs.label_required);
             }
             else
             {
                 myNode.removeClass(this._inputField, "rn_ErrorField");
                 myNode.removeClass("rn_" + this.instanceID + "_Label", "rn_ErrorLabel");
             }
             return retVal;
         }
         return true;
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
             afterNode.insert(hint, (Y.lang.isArray(this._inputField) && this._inputField.length) ? this._inputField[this._inputField.length - 1] : this._inputField);
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
         if(Y.lang.isArray(this._inputField))
         {
             //radio buttons
             myNode.setStyle(overlay, "margin-left", "2em");
             afterNode.insert(overlay, this._inputField[this._inputField.length - 1]);
         }
         else
         {
             afterNode.insert(overlay, this._inputField);
         }
 
         overlay = new Y.Overlay(overlay, {visible: visibility});
         overlay.setBody(this.data.js.hint);
         overlay.render();
         
         return overlay;
     },
 
     /**
      * Displays error by appending message above submit button
      * @param errorMessage String Message to display
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
 
                 var elementId = (Y.Lang.isArray(this._inputField)) ? this._inputField[0].id : this._inputField.id,
                     inputLabel = this.data.attrs.label_error || this.data.attrs.label_input,
                     label = (errorMessage.indexOf("%s") > -1) ?  RightNow.Text.sprintf(errorMessage, inputLabel) : inputLabel + ' ' +  errorMessage;
 
                 commonErrorDiv.innerHTML += "<div><b><a href='javascript:void(0);' onclick='document.getElementById(\"" +
                     elementId + "\").focus(); return false;'>" + label + "</a></b></div> ";
             }
         }
        myNode.addClass(this._inputField, "rn_ErrorField");
        myNode.addClass("rn_" + this.instanceID + "_Label", "rn_ErrorLabel");
     },
 /**
  * --------------------------------------------------------
  * Business Rules Events and Functions:
  * --------------------------------------------------------
  */
     /**
      * Event handler executed when country dropdown is changed
      */
     _countryChanged: function()
     {
         if(this._inputField.options)
         {
             var evtObj = new RightNow.Event.EventObject();
             evtObj.data = {"country_id" : this._inputField.options[this._inputField.selectedIndex].value,
                                  "w_id" : this.instanceID};
             RightNow.Event.fire("evt_formFieldProvinceRequest", evtObj);
         }
     },
 
     _selectionChanged: function(e, args)
     {
       var el = Y.Node.create("rn_" + args.instanceID);
       var arrRadio = el.getElementsByTagName("input"); 
       var rdoValue = 0;
       for(var i = 0; i < arrRadio.length; i++) {
      
         if(arrRadio[i].checked)
           rdoValue = arrRadio[i].value; 
   
       }
 
 
       //if(e.srcElement.tagName != "INPUT")
       return false;
 
       var eo = new RightNow.Event.EventObject();
       eo.data.name = "selection changed";
       eo.data.value = rdoValue; // e.srcElement.value;
       eo.data.fieldname = args._fldName;
       RightNow.Event.fire("evt_questiontype", eo);      
 
     },
 
     /**
      * Event handler executed when province/state data is returned from the server
      *
      * @param type String Event name
      * @param args Object Event arguments
      */
     _onProvinceResponse: function(type, args)
     {
 
         var evtObj = args[0],
             options = this._inputField.options,
             aNewOption, i;
         if(evtObj.states)
         {
             options.length = 0;
             if(!evtObj.states[0] || (evtObj.states[0].val !== "--" && !this.data.attrs.hideEmptyOption))
                 evtObj.states.unshift({val: "--", id: ""});
             for(i = 0; i < evtObj.states.length; i++)
             {
                 aNewOption = document.createElement("option");
                 aNewOption.text = evtObj.states[i].val;
                 aNewOption.value = evtObj.states[i].id;
                 options.add(aNewOption);
             }
         }
     }
 };
 
 