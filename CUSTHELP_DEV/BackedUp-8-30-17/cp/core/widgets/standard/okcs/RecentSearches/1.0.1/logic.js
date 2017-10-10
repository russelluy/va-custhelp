 /* Originating Release: May 2016 */
RightNow.Widgets.RecentSearches = RightNow.SearchConsumer.extend({
    overrides: {
        constructor: function() {
            this.parent();
            this._inputNodes = this.Y.all("." + this.data.attrs.parent_selector + " input");
            if (this._inputNodes) {
                this._inputNodes.each(function(currentNode) {
                    this._searchField = currentNode;
                    currentNode.addClass('yui3-skin-sam');
                    currentNode.plug(this.Y.Plugin.AutoCompleteList);
                    currentNode.on('click', this._showRecentSearches, this);
                    this.Y.all('.yui3-aclist-list').setAttribute('title', this.data.attrs.label_recent_search);
                    this._getLatestRecentSearches(this);
                    currentNode.ac.after('select', function(e) {
                        this._inputNodes.set('value', e.itemNode.getDOMNode().childNodes[0].textContent);
                        this.searchSource().fire('collect').fire('search');
                    }, this);
                    this.searchSource().on('response', this._getLatestRecentSearches, this);
                }, this);
                this._inputNodes.on('windowresize', this._resizeRecentSearchDiv, this);
            }
        }
    },

    /*
     * Function to render the recent searches display.
     */
    _showRecentSearches: function() {
        this._searchField.ac.set('maxResults', this.data.attrs.no_of_suggestions);
        this._searchField.ac.set('minLength', 0);
        if (this.data.js.recentSearches.length > 0) {
            this.Y.all('.yui3-aclist-list').setHTML(this.data.attrs.label_recent_search);
            this._setResultFormatter(this.data.js.recentSearches);
            this._searchField.ac.set('source', this.data.js.recentSearches);
        }
        this._searchField.ac.fire('query');
    },

    /*
     * This function to resize the recent search div based upon the window display.
     */
    _resizeRecentSearchDiv: function() {
        this.Y.all('.yui3-aclist').set('offsetWidth', this._inputNodes.get('offsetWidth'));
    },

    /**
     * Function to get the latest recent searches after the search response is triggered.
     * @param {object} filter object
     */
    _getLatestRecentSearches: function() {
        this._searchField.ac.hide();
        var eventObject = new RightNow.Event.EventObject(this, {
            data: {
                noOfSuggestions: this.data.attrs.no_of_suggestions
            }
        });
        RightNow.Ajax.makeRequest(this.data.attrs.get_okcs_data_ajax, eventObject.data, {
            successHandler: function(response) {
                this._searchField.ac.hide();
                this.data.js.recentSearches = response;
                if (this.data.js.recentSearches.length > 0) {
                    this.Y.all('.yui3-aclist-list').setHTML(this.data.attrs.label_recent_search);
                    this._setResultFormatter(this.data.js.recentSearches);
                    this._searchField.ac.set('source', response);
                }
            },
            json: true,
            scope: this,
            ignoreFailure: true
        });
    },
    
    /*
   * This function to set the result formatter.
   */	
   _setResultFormatter: function(results){
       var that = this;
       var htmlTemplate = '<li class="rn_ResultFormat" >{_array}</li>';
       if(this.data.attrs.display_tooltip) {
           htmlTemplate = htmlTemplate + '<div class="list-item-tooltip">{_array}</div>';
       }
          function resultFormatter(query, results) {
          return that.Y.Array.map(results, function (result) {
            return that.Y.Lang.sub(htmlTemplate, {
              _array : result.raw
            });
          });
        } 
       this._searchField.ac.set('resultFormatter',resultFormatter);
   }
});