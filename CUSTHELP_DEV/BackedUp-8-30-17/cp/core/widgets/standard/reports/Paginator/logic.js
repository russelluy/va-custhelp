 /* Originating Release: May 2016 */
RightNow.Widgets.Paginator = RightNow.SearchFilter.extend({
    overrides: {
        constructor: function() {
            this.parent();

            this._currentPage = this.data.js.currentPage;

            for(var i = this.data.js.startPage; i <= this.data.js.endPage; i++)
            {
                var pageLinkID = this.baseSelector + "_PageLink_" + i;
                if(this.Y.one(pageLinkID))
                    this.Y.one(pageLinkID).on("click", this._onPageChange, this, i);
            }
            this._instanceElement = this.Y.one(this.baseSelector);
            this._forwardButton = this.Y.one(this.baseSelector + "_Forward");
            this._forwardButton.on("click", this._onDirection, this, true);
            this._backButton = this.Y.one(this.baseSelector + "_Back");
            this._backButton.on("click", this._onDirection, this, false);

            this._eo = new RightNow.Event.EventObject(this, {
                filters: {
                    report_id: this.data.attrs.report_id,
                    per_page: this.data.attrs.per_page,
                    page: this._currentPage
                }
            });

            this.searchSource(this.data.attrs.report_id).on("response", this._onReportChanged, this);
        }
    },

    /**
    * Event Handler fired when a page link is selected
    *
    * @param {Object} evt Event object
    * @param {Int} pageNumber Number of the page link clicked on
    */
    _onPageChange: function(evt, pageNumber)
    {
        evt.preventDefault();

        if(this._currentlyChangingPage || !pageNumber || pageNumber === this._currentPage)
            return;

        this._currentlyChangingPage = true;
        pageNumber = (pageNumber < 1) ? 1 : pageNumber;
        this._eo.filters.page = this._currentPage = pageNumber;
        if (RightNow.Event.fire("evt_switchPagesRequest", this._eo)) {
            this.searchSource().fire("appendFilter", this._eo)
                .fire("search", this._eo);
        }
    },

    /**
    * Event Handler fired when a direction button is clicked
    *
    * @param {Object} evt Event object
    * @param {Bool} isForward Indicator of button's direction
    */
    _onDirection: function(evt, isForward)
    {
        evt.preventDefault();
        if(this._currentlyChangingPage)
            return;

        this._currentlyChangingPage = true;
        if(isForward)
            this._currentPage++;
        else
            this._currentPage--;
        this._eo.filters.page = this._currentPage;

        if (RightNow.Event.fire("evt_switchPagesRequest", this._eo)) {
            this.searchSource().fire("appendFilter", this._eo)
                .fire("search", this._eo);
        }
    },

    /**
    * Event handler received when report data has changed
    *
    * @param {String} type Event type
    * @param {Object} args Arguments passed with event
    */
    _onReportChanged: function(type, args)
    {
        var newData = args[0];
        newData = newData.data;
        if(args[0].filters.report_id == this.data.attrs.report_id)
        {
            this._currentPage = newData.page;
            var totalPages = newData.total_pages;

            if(totalPages < 2 || newData.truncated)
            {
                RightNow.UI.hide(this._instanceElement);
            }
            else
            {
                //update all of the page links
                var pagesContainer = this.Y.one(this.baseSelector + "_Pages");
                if(pagesContainer)
                {
                    pagesContainer.set('innerHTML', "");

                    var startPage, endPage;
                    if(this.data.attrs.maximum_page_links === 0)
                        startPage = endPage = this._currentPage;
                    else if(totalPages > this.data.attrs.maximum_page_links)
                    {
                        var split = Math.round(this.data.attrs.maximum_page_links / 2);
                        if(this._currentPage <= split)
                        {
                            startPage = 1;
                            endPage = this.data.attrs.maximum_page_links;
                        }
                        else
                        {
                            var offsetFromMiddle = this._currentPage - split;
                            var maxOffset = offsetFromMiddle + this.data.attrs.maximum_page_links;
                            if(maxOffset <= newData.total_pages)
                            {
                                startPage = 1 + offsetFromMiddle;
                                endPage = maxOffset;
                            }
                            else
                            {
                                startPage = newData.total_pages - (this.data.attrs.maximum_page_links - 1);
                                endPage = newData.total_pages;
                            }
                        }
                    }
                    else
                    {
                        startPage = 1;
                        endPage = totalPages;
                    }

                    for(var i = startPage, link, titleString; i <= endPage; i++)
                    {
                        if(i === this._currentPage)
                        {
                            link = this.Y.Node.create("<span/>").addClass("rn_CurrentPage")
                                .set('innerHTML', i);
                        }
                        else
                        {
                            link = this.Y.Node.create("<a/>").set('id', this.baseSelector + "_PageLink_" + i)
                                .set('href', this.data.js.pageUrl + i)
                                .set('innerHTML', i + '<span class="rn_ScreenReaderOnly">' + RightNow.Text.sprintf(this.data.attrs.label_page, i, totalPages) + '</span>');
                            titleString = this.data.attrs.label_page;
                            if(titleString)
                            {
                                titleString = titleString.replace(/%s/, i).replace(/%s/, newData.total_pages);
                                link.set('title', titleString);
                            }
                        }
                        pagesContainer.appendChild(link);
                        link.on("click", this._onPageChange, this, i);
                    }

                    RightNow.UI.show(this._instanceElement);
                }
            }
            //update the forward button
            if(this._forwardButton)
            {
                if(newData.total_pages > newData.page)
                    this._forwardButton.removeClass("rn_Hidden").set('href', this.data.js.pageUrl + (this._currentPage + 1));
                else
                    RightNow.UI.hide(this._forwardButton);
            }
            //update the back button
            if(this._backButton)
            {
                if(newData.page > 1)
                    this._backButton.removeClass("rn_Hidden").set('href', this.data.js.pageUrl + (this._currentPage - 1));
                else
                    RightNow.UI.hide(this._backButton);
            }
        }
        this._currentlyChangingPage = false;
    }
});
