RightNow.namespace('Custom.Widgets.input.IncidentTaskInput');
Custom.Widgets.input.IncidentTaskInput = RightNow.Widgets.extend({ 
    /**
     * Widget constructor.
     */
    constructor: function() {
        //RightNow.Event.subscribe('evt_formFieldValidateRequest', this._saveTaskData, this);
        RightNow.Event.subscribe("evt_formButtonSubmitRequest", this._formSubmitButtonPushed, this);
        var Event = this.Y.Event;
        var TopicButton = this.Y.one(this.baseSelector + "_TopicButton");
        Event.attach("click", this._onClick, TopicButton, this);
    },
        _onClick: function(event)
        {
           var div = document.createElement("div");
           var text = this.getSelectedText(this.baseDomID + '_products');     
           var myexperience = this.getSelectedText(this.baseDomID + '_select');
           if (text ==="Select a Topic")
        	   {
        	 //  alert("Please select a topic");
                 RightNow.UI.Dialog.messageDialog("Please select a topic" , {icon: "BLOCK"}
);
        	   return false;
        	   }
        	   
        	if ( myexperience==="") {
        		RightNow.UI.Dialog.messageDialog("Please rate your experience", {icon: "BLOCK"});
        		return false;
        	}
        	
           var rowcount = document.getElementById(this.baseDomID + "_Topics").childElementCount
           var removeId = this.baseDomID + "_remove" + rowcount
           var topicId = document.getElementById(this.baseDomID + '_products').value;
           var rateCode = document.getElementById(this.baseDomID + '_select').value;
           div.className = "row";
          div.id= this.baseDomID + "_row"  + rowcount
          text=text.trim();
          div.innerHTML ='<input type="hidden" id="' + this.baseDomID +'_data'+ rowcount +'" value="' +topicId +', '+ myexperience + 
                  ' with ' + text  + '" /> <div class="rn_IncidentTaskInput_col">' + myexperience  + 
          	'</div><div class= "rn_IncidentTaskInput_Narrowcol">&nbsp; &nbsp;with&nbsp; &nbsp;</div> <div class= "rn_IncidentTaskInput_col2">' +
          	text +	'</div><div class= "rn_IncidentTaskInput_Narrowcol"><a href="javascript:void(0);" id=' + this.baseDomID +  
          	'_remove'+ rowcount +'>remove</a></div>';

          document.getElementById(this.baseDomID + "_Topics").appendChild(div);
          var RemoveLink = document.getElementById(this.baseDomID + "_remove" + rowcount);
          //RemoveLink.addEventListener('click', function() { removeRow(p1, p2);       }, false);
          this.Y.Event.attach("click", this.removeRow, RemoveLink, this, rowcount);
          document.getElementById(this.baseDomID + '_products').value= "";
          this._saveTaskData(this);
       },
        getSelectedText:  function(elementId) {
          var elt = document.getElementById(elementId);

           if (elt.selectedIndex == -1)
               return "";

           return elt.options[elt.selectedIndex].text;
       },

        removeRow: function( input,rowcount) {
            input.stopPropagation;
            var myrow = document.getElementById(this.baseDomID + "_Topics") ;
             myrow.removeChild(myrow.childNodes[rowcount]);
             this._saveTaskData(this);
           return false;            
    },

    /**
     * Sample widget method.
     */
    methodName: function() {

    },
    
    _saveTaskData: function(obj) {
    	this.saveTaskData_ajax_endpoint(this);
    }, 

    /**
     * Handles when FormSubmitButton is clicked to indicate that this is for a password reset
     * and to add additional request data.
     */
    _formSubmitButtonPushed: function() {
            	var myrow = document.getElementById(this.baseDomID + "_Topics").childElementCount ;
                var mychildren = document.getElementById(this.baseDomID + "_Topics").children ;
    	var node;
    	var theTopics= '';
    	var therows = [];
    	if (myrow > 0 ) {
    		for (var i = 0, ii = myrow ; i < ii; i++) {                    
                    node = mychildren[i].id.slice(-1);
                    strTopics= document.getElementById(this.baseDomID + "_data"+ node).value;
                    theTopics = strTopics.split(",");
                    therows.push( {
                    "experience" : theTopics[1], "id" : theTopics[0]
                    });
    		}
    	}  else {
//            alert('Please add a tpoic by selecting a topic and clicking ADD buttonm');
 //           RightNow.Event.fire("evt_formValidateFailure", new RightNow.Event.EventObject(this));
  //          return false;
        }
        
    var myjson =JSON.stringify(therows);

        RightNow.Ajax.addRequestData('topics', myjson, true);
        RightNow.Ajax.addRequestData('w_id', this.data.info.w_id, true);
    },
    /**
     * Makes an AJAX request for `default_ajax_endpoint`.
     */
      saveTaskData_ajax_endpoint: function(evt) {
  /*  	var myrow = document.getElementById(this.baseDomID + "_Topics").childElementCount ;
    	var node;
    	var theTopics= '';
    	var therows = [];
    	if (myrow > 0 ) {
    		for (var i = 0, ii = myrow ; i < ii; i++) {
    			strTopics= document.getElementById(this.baseDomID + "_data"+ i).value;
                        theTopics = strTopics.split(",");
    			therows.push( {
    			"experience" : theTopics[1], "id" : theTopics[0]
    			});
    		}
    	}
    var myjson =JSON.stringify(therows);
        // Make AJAX request:
        var eventObj = new RightNow.Event.EventObject(this, {data:{
            w_id: this.data.info.w_id,
            // Parameters to send	
            topics:                    myjson
        }});
        RightNow.Ajax.makeRequest(this.data.attrs.saveTaskData_ajax_endpoint, eventObj.data, {
            successHandler: this.saveTaskData_ajax_endpointCallback,
            scope:          this,
            data:           eventObj,
            json:           true
        });
*/    },

    /**
     * Handles the AJAX response for `default_ajax_endpoint`.
     * @param {object} response JSON-parsed response from the server
     * @param {object} originalEventObj `eventObj` from #getDefault_ajax_endpoint
     */
    saveTaskData_ajax_endpointCallback: function(response, originalEventObj) {
        // Handle response
    //	alert(response);
    }
});