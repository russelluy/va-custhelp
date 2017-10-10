RightNow.namespace('Custom.Widgets.display.CustomInfoButton');
Custom.Widgets.display.CustomInfoButton = RightNow.Widgets.extend({ 
    /**
     * Widget constructor.
     */
    constructor: function() {
    
        this.Y.Event.attach("click", this._onClick, this.baseSelector + "_SubmitButton", this);
    },
    /**
     * Executed when link is clicked on.
     * @param {Object} event Click Event
     */
    _onClick: function(event) {
	    
	    event.halt();

		if(!this.data.attrs.is_link) {
			var theDiv = "#" + this.data.attrs.target;
	        var panelElement = this.Y.one(theDiv),
	            links, lastLink;
	        if (!panelElement) return;
	
	        if (!this._panel) {
	            links = panelElement.all("a");
	            lastLink = links.item(links.size() - 1);
	            this._panel = new this.Y.Panel({
	                srcNode: panelElement,
	                /* width:"320px", */ 
	                centered:true, 
	                visible:false, 
	                draggable:false, 
	                constraintoviewport:true, 
	                modal:true,
	                //align: {node: this.baseSelector, points: [this.Y.WidgetPositionAlign.TC, this.Y.WidgetPositionAlign.BC]},
	                render: true,
	                buttons: [],
	                //hideOn: [{eventName: "clickoutside"}, {node: lastLink, eventName: "keydown", keyCode: RightNow.UI.KeyMap.TAB}]
	                hideOn: [{eventName: "clickoutside"}, {node: lastLink, eventName: "keydown", keyCode: RightNow.UI.KeyMap.TAB}, {node: lastLink, eventName: "click"}]
	            });
	            RightNow.UI.show(panelElement);
	        }
	        else if (this._panel && this._panel.get("visible") === true) {
	            this._panel.hide();
	            return;
	        }
	        this._panel.show();
	        // focus first link
	        panelElement.one('a').focus();
        }
        
	    if(this.data.attrs.is_link) {
		    if(this.data.attrs.new_window) {
				window.open(this.data.attrs.target);
	     	}
		 	else
		 		RightNow.Url.navigate(this.data.attrs.target, true);
	    }
        
    }
});