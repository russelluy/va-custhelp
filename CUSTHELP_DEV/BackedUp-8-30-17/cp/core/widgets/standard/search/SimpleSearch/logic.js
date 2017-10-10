 /* Originating Release: May 2016 */
RightNow.Widgets.SimpleSearch = RightNow.Widgets.extend({
    constructor: function() {
        this._searchField = this.Y.one(this.baseSelector + "_SearchField");
        if (!this._searchField) return;

        if (this.data.attrs.label_hint) {
            this._searchField.on("focus", this._onFocus, this);
            this._searchField.on("blur", this._onBlur, this);
        }

        if (this.data.attrs.initial_focus && this._searchField.focus) {
            this._searchField.focus();
        }

        this.Y.Event.attach("click", this._onSearch, this.baseSelector + "_Submit", this);
    },
    /**
    * Called when the user searches
    */
    _onSearch: function() {
        if(this.Y.UA.ie) {
            //since the form is submitted by script, deliberately tell IE to do auto completion of the form data
            var parentForm = this.Y.one(this.baseSelector + "_SearchForm");
            if(parentForm && window.external && "AutoCompleteSaveForm" in window.external) {
                window.external.AutoCompleteSaveForm(parentForm);
            }
        }
        var searchString = (this._searchField.get("value") === this.data.attrs.label_hint) ? "" : this._searchField.get("value");
        searchString = RightNow.Url.addParameter(this.data.attrs.report_page_url, "kw", searchString);
        searchString = RightNow.Url.addParameter(searchString, "search", 1);
        searchString = RightNow.Url.addParameter(searchString, "session", RightNow.Url.getSession());
        RightNow.Url.navigate(searchString);
    },
    /**
    * Called when the search field is focused. Removes initial_value text
    */
    _onFocus: function() {
        if (this._searchField.get("value") === this.data.attrs.label_hint)
            this._searchField.set("value", "");
    },
    /**
    * Called when the search field is blurred. Removes initial_value text
    */
    _onBlur: function() {
        if (this._searchField.get("value") === "")
            this._searchField.set("value", this.data.attrs.label_hint);
    }
});
