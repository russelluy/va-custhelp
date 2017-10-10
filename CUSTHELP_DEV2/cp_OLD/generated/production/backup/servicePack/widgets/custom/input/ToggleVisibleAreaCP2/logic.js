 /* Originating Release: August 2012 */
RightNow.Widget.ToggleVisibleArea = function(data, instanceID) {
    this.data = data;
    this.instanceID = instanceID;

    this._parentContainer = document.getElementById("rn_" + this.instanceID); 
    this._toggleArea = document.getElementById(this.data.attrs.toggle_div_name); 

    //YAHOO.util.Dom.addClass(this._parentContainer, 'rn_Hidden');

    this._value1 = false;
    this._value2 = false;

    RightNow.Event.subscribe('evt_questiontype', this._doAction, this);
    RightNow.Event.subscribe('evt_selectiontype', this._doAction2, this);

};
RightNow.Widget.ToggleVisibleArea.prototype = {
/**
 * ----------------------------------------------
 * Form / UI Events and Functions:
 * ----------------------------------------------
 */

    _doAction : function (evt, args) {

       var dispValues = this.data.attrs.display_value.split(",");

       var testValue = args[0].data.fieldname+'='+args[0].data.value;

       this._value1 = false;

       YAHOO.util.Dom.addClass(this._parentContainer, 'rn_Hidden');
       YAHOO.util.Dom.removeClass(this._toggleArea, 'rn_Hidden');

       //all values have to be true
       for(var i=0; i<dispValues.length; i++) {
           if(dispValues[i] == testValue) {

             this._value1 = true;
             this._value2 = true;
    
             if(this._value1 && this._value2) {
               YAHOO.util.Dom.removeClass(this._parentContainer, 'rn_Hidden');
               YAHOO.util.Dom.removeClass(this._toggleArea, 'rn_Hidden');
             }
           }

       }
    
       if(!this._value1)
         YAHOO.util.Dom.addClass(this._toggleArea, 'rn_Hidden');


    },

    _doAction2 : function (evt, args) {

       var dispValues = this.data.attrs.display_value.split(",");

       var testValue = args[0].data.fieldname+'='+args[0].data.value;

       this._value2 = false;

       YAHOO.util.Dom.addClass(this._parentContainer, 'rn_Hidden');
       YAHOO.util.Dom.removeClass(this._toggleArea, 'rn_Hidden');

       //all values have to be true
       for(var i=0; i<dispValues.length; i++) {
           if(dispValues[i] == testValue) {

             this._value2 = true;

             if(this._value1 && this._value2) {
               YAHOO.util.Dom.removeClass(this._parentContainer, 'rn_Hidden');
               YAHOO.util.Dom.addClass(this._toggleArea, 'rn_Hidden');
             }
           }

       }

    },

};
