 /* Originating Release: May 2016 */
RightNow.Widgets.SourceSearchField = RightNow.SearchProducer.extend({
    overrides: {
        constructor: function() {
            this.parent();
            this.input = this.Y.one(this.baseSelector + '_SearchInput');

            if (this.data.attrs.initial_focus) {
                this.input.focus();
            }

            this.searchSource()
                .on('collect', this.onCollect, this)
                .on('updateFilters', this.onFilterUpdate, this)
                .on('reset', this.onReset, this);
        }
    },

    /**
     * Returns a RightNow.Event.EventObject with the filter value filled in
     * @return {object} RightNow.Event.EventObject with the filter value filled in
     */
    onCollect: function () {
        var searchTerm = "";
        var keywordEntered = this.Y.Lang.trim(this.input.get('value'));
        if (this.data.attrs.allow_empty_search && !keywordEntered) {
            searchTerm = "*";
        }
        else if (keywordEntered) {
            searchTerm = keywordEntered;
        }
        //reset the page number to 1, when search button is clicked
        this.searchSource().setOptions({page: {key: "page", type: "page", value: 1}});
        return new RightNow.Event.EventObject(this, {
            data: this.Y.merge(this.data.js.filter, { value: searchTerm })
        });
    },

    /**
     * Updates the filter value.
     * @param  {string} e  Event name
     * @param  {object} eo RightNow.Event.EventObject
     */
    onFilterUpdate: function(e, eo) {
        this.Y.Object.some(eo[0].data, function(filter) {
            if(filter.key === this.data.js.filter.key) {
                this.input.set('value', (filter.value !== '*') ? filter.value : '');
                return true;
            }
        }, this);
    },

    /**
     * Resets the input field to its original value.
     */
    onReset: function () {
        this.input.set('value', this.data.js.prefill);
        }
});
