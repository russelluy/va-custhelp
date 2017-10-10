RightNow.namespace('Custom.Widgets.input.CustomFileAttachmentUpload');
Custom.Widgets.input.CustomFileAttachmentUpload = RightNow.Widgets.FileAttachmentUpload.extend({ 
    /**
     * Place all properties that intend to
     * override those of the same name in
     * the parent inside `overrides`.
     */
    overrides: {
        /**
         * Overrides RightNow.Widgets.FileAttachmentUpload#constructor.
         */
        constructor: function() {
            //alert("in custom text logic");
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
         * Overridable methods from FileAttachmentUpload:
         *
         * Call `this.parent()` inside of function bodies
         * (with expected parameters) to call the parent
         * method being overridden.
         */
        // getValue: function()
        // swapLabel: function(container, minAttachments, label, template)
        // updateMinAttachments: function(evt, constraint)
        // _onKeyPress: function(event)
        // _onFileAdded: function(e)
        // _validateFileExtension: function(fileName)
        // _displayStatus: function(message)
        // _sendUploadRequest: function()
        // _processServerError: function(response)
        // _processAttachmentThreshold: function(count)
        // _fileUploadReturn: function(response, originalEventObject)
        // _getFileFromInput: function()
        // _renderNewAttachmentItem: function(filename, count)
        // _normalizeFilename: function (filename, originalFileName)
        // _renameDuplicateFilename: function (filename)
        // _loadThumbnail: function(file, reader, callback)
        // _fileUploadFailure: function()
        // getAttachmentErrorInfo: function(attachmentInfo)
        // resetInput: function()
        // recreateInput: function()
        // removeClick: function(event, index)
        // _onValidateUpdate: function(type, args)
        // toggleErrorIndicator: function(showOrHide)
        // _setLoading: function(turnOn, statusMessage)
        // _displayError: function(errorMessage, errorLocation)
    },

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

    }
});