RightNow.namespace('Custom.Widgets.input.IncidentTaskInput');
Custom.Widgets.input.IncidentTaskInput = RightNow.Widgets.extend({ 
    /**
     * Widget constructor.
     */
    constructor: function() {
        var Event = this.Y.Event;
        var TopicButton = this.Y.one(this.baseSelector + "_TopicButton");
        Event.attach("click", this._onClick, TopicButton, this);
        RightNow.Event.subscribe("evt_formFieldValidateRequest”", this._saveTaskData, this, true);
    },
        _onClick: function(event)
        {
            var div = document.createElement("div");
           var text = this.getSelectedText(this.baseDomID + '_products');     
           var myexperience = this.getSelectedText(this.baseDomID + '_select');
           var rowcount = document.getElementById(this.baseDomID + "_Topics").childElementCount
           var removeId = this.baseDomID + "_remove" + rowcount
           div.className = "row";
          div.id= this.baseDomID + "_row"  + rowcount
          div.innerHTML ='<div class="rn_IncidentTaskInput_col">' + myexperience  +
    		'</div><div class= "rn_IncidentTaskInput_col">with</div> <div class= "rn_IncidentTaskInput_col">' + text + 
    	'</div><div class= "rn_IncidentTaskInput_col"><a href="javascript:void(0);" id=' + this.baseDomID +  
    	'_remove'+ rowcount +'>remove</a></div>';

               
          document.getElementById(this.baseDomID + "_Topics").appendChild(div);
          var RemoveLink = document.getElementById(this.baseDomID + "_remove" + rowcount);
          //RemoveLink.addEventListener('click', function() { removeRow(p1, p2);       }, false);
          this.Y.Event.attach("click", this.removeRow, RemoveLink, this, rowcount);
       },
        getSelectedText:  function(elementId) {
           var elt = document.getElementById(elementId);

           if (elt.selectedIndex == -1)
               return "";

           return elt.options[elt.selectedIndex].text;
       },

        removeRow: function( input,rowcount) {
        	input.stopPropagation;
        	var myrow = document.getElementById(this.baseDomID + "_Topics") 
           myrow.removeChild(myrow.childNodes[rowcount]);
           return false;            
    },

    /**
     * Sample widget method.
     */
    methodName: function() {

    },
    
    _saveTaskData: function() {
    	this.saveTaskData_ajax_endpoint()
    }, 

    /**
     * Makes an AJAX request for `default_ajax_endpoint`.
     */
    saveTaskData_ajax_endpoint: function() {
        // Make AJAX request:
        var eventObj = new RightNow.Event.EventObject(this, {data:{
            w_id: this.data.info.w_id,
            // Parameters to send	
        }});
        RightNow.Ajax.makeRequest(this.data.attrs.saveTaskData_ajax_endpoint, eventObj.data, {
            successHandler: this.saveTaskData_ajax_endpointCallback,
            scope:          this,
            data:           eventObj,
            json:           true
        });
    },

    /**
     * Handles the AJAX response for `default_ajax_endpoint`.
     * @param {object} response JSON-parsed response from the server
     * @param {object} originalEventObj `eventObj` from #getDefault_ajax_endpoint
     */
    getProducts_ajax_endpointCallback: function(response, originalEventObj) {
        // Handle response
    }
});