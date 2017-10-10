RightNow.namespace('Custom.Widgets.util.CustomInfoButton');
Custom.Widgets.util.CustomInfoButton = RightNow.Widgets.extend({ 
    /**
     * Widget constructor.
     */
    constructor: function(data, instanceID) {
		this.data = data;
		this.instanceID = instanceID;
		this._requestInProgress = false;
		this._searchButton = document.getElementById("rn_" + this.instanceID + "_SubmitButton");
       
		this._enableClickListener();
		RightNow.Event.subscribe("evt_reportResponse",  this._onSearchResponse, this);
   
		this._myDivPanel = null;
    },
	
	
	_startSearch: function(evt)
	{
	   if(this._requestInProgress)
	       return false;
	   if(!this.data.attrs.popup_window && (!this.data.attrs.report_page_url && (this.data.attrs.target === '_self')))
	       this._disableClickListener();
	
	   if(this.Y.UA.ie !== 0)
	   {
	       //since the form is submitted by script, deliberately tell IE to do auto completion of the form data
	       if(!this._parentForm)
	           this._parentForm = myNode.ancestor("rn_" + this.instanceID, "FORM");
	       if(this._parentForm && window.external && "AutoCompleteSaveForm" in window.external)
	       {
	           window.external.AutoCompleteSaveForm(this._parentForm);
	       }
	   }
	   var eo = new RightNow.Event.EventObject();
	   eo.w_id = this.instanceID;
	   eo.filters = {report_id: this.data.attrs.report_id, 
	       reportPage: this.data.attrs.report_page_url,
	       target: this.data.attrs.target,
	       popupWindow: this.data.attrs.popup_window,
	       width: this.data.attrs.popup_window_width_percent,
	       height: this.data.attrs.popup_window_height_percent
	   };
	
	   if(!this.data.attrs.is_link) {
	
	     var theDiv = document.getElementById(this.data.attrs.target);
	     myNode.removeClass(theDiv, 'rn_Hidden');
	     //this._myDivPanel = new this.Y.Panel(this.data.attrs.target, { width:"320px", fixedcenter:true, visible:false, draggable:true, constraintoviewport:true, modal:true } ); 
	     this._myDivPanel = new this.Y.Panel({srcNode      : '#myEmailDiv',
										        width        : 250,
										        zIndex       : 5,
										        centered     : true,
										        modal        : true,
										        visible      : false,
										        render       : true,
										        plugins      : [Y.Plugin.Drag]});
	     //this._myDivPanel.render(document.body);
	     this._myDivPanel.show();
	   }
	
	   if(this.data.attrs.is_link) {
	
	     if(this.data.attrs.new_window) {
	       window.open(this.data.attrs.target);
	     }
	     else
	       RightNow.Url.navigate(this.data.attrs.target, true);
	   }
	},
	
	/**
	* Event handler executed when search submission returns from server
	* @param type string Event name
	* @param args object Event arguments
	*/
	_onSearchResponse: function(type, args)
	{
	   if(args[0].filters.report_id == this.data.attrs.report_id)
	      this._enableClickListener();
	},
	
	/**
	* Enable the form submit control by enabling button and adding an onClick listener.
	*/
	_enableClickListener: function()
	{
	   this._requestInProgress = false;
	   //this.Y.Event.addListener(this._searchButton, "click", this._startSearch, null, this);
	   //this.Y.Event["attach"]("click", this._startSearch, this._searchButton, this);
	   
	   var button = this.Y.one(this._searchButton);
	   button.on("click", this._startSearch);
	},
	
	/**
	* Disable the form submit control by disabling button and removing the onClick listener.
	*/
	_disableClickListener: function()
	{
	   this._requestInProgress = true;
	   //this.Y.Event.removeListener(this._searchButton, "click", this._startSearch);
	   this.Y.Event["detach"]("click", this._startSearch, this._searchButton, this);
	}

});

