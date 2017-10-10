/**#nocode+*/
(function() {
    // The sub-modules defined in this unit
    var History, Search, Helpers, SourceConductor, isRestoring = false;

    /**
     * Handles calling response and updateFilters on the appropriate source
     * @param {Object} state State to use for restoration
     */
    function restoreState(state) {
        //If the source doesn't exist, we're coming onto the page from a new load and the widgets haven't created it yet,
        //just skip the events, since the widgets will already have the correct data.
        var source = SourceConductor.get(state.sourceID);
        if(source) {
            source
                .fire('response', new RightNow.Event.EventObject(null, {data: state.response}))
                .fire('updateFilters', new RightNow.Event.EventObject(null, {data: state.filters}));
        }
    }

    /**
     * Handles calling reset and search on all sources
     */
    function reInitialize() {
        var sources = SourceConductor.get(), source;
        for(source in sources) {
            if(sources.hasOwnProperty(source) && sources[source].impactsHistory) {
                sources[source].fire('reset').fire('search');
            }
        }
    }

    /**
     * Handles saving / restoring the search state in the browser's
     * history as well as caching all search responses in a local object.
     * @param {Object} Y YUI instances with the HistoryHTML5 module attached.
     * @return {Object} History module to use throughout this file
     */
    function initializeHistory(Y) {
        var cachedResponses = {},
            history = new Y.HistoryHTML5();

        /**
        * Called when the history manager's state changes. Only responds when the state change
        * is a popState change.
        * This occurs when the browser's back / forward button is clicked in
        * a [modern browser](http://caniuse.com/#feat=history).
        * @private
        */
        history.on('change', function(e) {
            if(e.src !== Y.HistoryHTML5.SRC_POPSTATE) return;

            isRestoring = true;
            var state = e.changed.state;
            if (state) {
                restoreState(state.newVal);
            }
            else {
                reInitialize();
            }
            isRestoring = false;
        });

        return {
            enabled: true,

            /**
             * Adds the given state to the YUI history manager.
             * @param {string} key   Key to use for the browser URL
             * @param {Object} state State to save
             * @param {Boolean} isRestoring Whether the state is currently
             *                           being restored
             * @private
             */
            addState: function (key, state, isRestoring) {
                history[(isRestoring) ? 'replace' : 'add']({ state : state }, { url : Helpers.getCurrentPage() + key });
            },

            /**
             * Checks the local object cache for the given key and state key. Returns the state if it exists.
             * @param {string} key The key of the search source (e.g. "report176")
             * @param {string} stateKey The JSON stringified, base64-encoded state of the request filters
             * @return {?Object} The found state or null if not found
             * @private
             */
            checkCache: function(key, stateKey) {
                return ((cachedResponses[key]) ? cachedResponses[key][stateKey] : null);
            },

            /**
             * Sets the given state object as a keyed member of a local object cache.
             * @param {string} key The key of the search source (e.g. "report176")
             * @param {string} stateKey The JSON stringified, base64-encoded state of the request filters
             * @param {Object} state The state to cache
             * @private
             */
            setCache: function(key, stateKey, state) {
                cachedResponses[key] || (cachedResponses[key] = {});
                cachedResponses[key][stateKey] = state;
            }
        };
    }

    if ('pushState' in window.history) {
        YUI().use('history-html5', function(Y) {
            History = initializeHistory(Y);
        });
    }
    else {
        History = { enabled: false };
    }

    /**
     * Search
     * @namespace Provides functions for searching reports & generic sources via ajax or page flip.
     * @requires RightNow.Ajax, RightNow.Text, RightNow.Url
     */
    Search = (function() {
        var Y = YUI();

        /**
         * Callback function for ajax requests. Fires the 'response' event on the correct searchSource object.
         * @private
         * @param {Object} response The response object from the server (assert: already JSON-decoded)
         * @param {Object} args The filters from the search:
         *              'searchSource' {string} The id of the searchSource that triggered the request
         *              'cacheKey' {string} The cache key to locally cache the response object under
         *              'allFilters' {Object} The state of all filters that triggered the search
         */
        function _ajaxCallback(response, args) {
            if(args.impactsHistory) {
                History.setCache(args.sourceID, args.historyKey, response);
                History.addState(args.historyKey, {response: response, filters: args.filters, sourceID: args.sourceID}, args.isRestoring);
            }

            SourceConductor.get(args.sourceID)
                .fire('response', new RightNow.Event.EventObject(null, {data: response}))
                .fire('updateFilters', new RightNow.Event.EventObject(null, {data: args.filters}));
        }

        /**
         * Fires off the ajax request to do a search.
         * @private
         * @param {string} url The endpoint url
         * @param {Object} params The post params
         * @param {Object} callbackData Callback data to receive in the ajax callback function
         */
        function _ajaxSearch(url, params, callbackData) {
            RightNow.Ajax.makeRequest(url, params, {
                successHandler: _ajaxCallback,
                failureHandler: function(response){
                    var message = RightNow.Interface.getMessage("ERROR_REQUEST_ACTION_COMPLETED_MSG");
                    if(response.status === 403 && response.responseText !== undefined){
                        message = response.responseText;
                    }
                    RightNow.UI.Dialog.messageDialog(message, {"icon": "WARN", exitCallback: function(){window.location.reload(true);}});
                },
                json: true,
                data: callbackData,
                timeout: 10000 // 10 secs
            });
        }

        /**
         * Fires off the ajax request to do a search without modifying history state.
         * @private
         * @param {Object} filters The filters
         * @param {Object} options AJAX options
         * @param {string} sourceID Source to use
         */
        function _searchSourceViaAjaxNoHistory(filters, options, sourceID) {
            if(!options.endpoint) {
                throw Error("An endpoint hasn't been specified");
            }

            _ajaxSearch(options.endpoint, Y.mix({
                sourceID: sourceID,
                filters: RightNow.JSON.stringify(filters),
                limit: options.limit
            }, options.params), {
                sourceID: sourceID,
                filters: filters
            });
        }

        /**
         * Fires off the ajax request to do a search.
         * @private
         * @param {Object} filters The filters
         * @param {Object} options AJAX options
         * @param {string} sourceID Source to use for history state
         * @param {Object} searchSource SearchSource object
         */
        function _searchSourceViaAjax(filters, options, sourceID, searchSource) {
            var filterUrl = Helpers.getFilterUrl(filters),
                cachedSearch = History.checkCache(sourceID, filterUrl);

            //Lucky! this exact state has already been seen. Just return the cached state
            if(cachedSearch) {
                History.addState(filterUrl, {response: cachedSearch, filters: filters, sourceID: sourceID}, isRestoring);
                searchSource.fire('response', new RightNow.Event.EventObject(null, {data: cachedSearch}))
                            .fire('updateFilters', new RightNow.Event.EventObject(null, {data: filters}));
                return;
            }

            //We're searching without filters, return no results and skip the request
            if(filterUrl === '/') {
                searchSource.fire('response', new RightNow.Event.EventObject(null, {data: {}}));
                return;
            }

            if(!options.endpoint) {
                throw Error("An endpoint hasn't been specified");
            }

            //TSL - Clickstreams - We likely want to send something in with the search to signify that we're recording a new search

            _ajaxSearch(options.endpoint, Y.mix({
                sourceID: sourceID,
                filters: RightNow.JSON.stringify(filters),
                limit: options.limit
            }, options.params), {
                sourceID: sourceID,
                historyKey: filterUrl,
                filters: filters,
                isRestoring: isRestoring,
                impactsHistory: true
            });
        }

        function _searchSourceOnNewPage(filters, options) {
            var newUrl = RightNow.Url.addParameter((options.new_page || Helpers.getCurrentPage()) + Helpers.getFilterUrl(filters), 'session', RightNow.Url.getSession());

            window.open(newUrl, options.target || '_self');
        }

        return {
            go: function(filters, options, sourceID, impactsHistory, searchSource) {
                if(!History.enabled || (options && (options.new_page || !options.endpoint))) {
                    _searchSourceOnNewPage(filters, options);
                }
                else {
                    //TSL - This filters object will have a different structure. Do we even need to fire this event since this is a new search system?
                    //RightNow.Event.fire("evt_searchRequest", new RightNow.Event.EventObject(this, {filters: searchFilters}));
                    if(!impactsHistory) {
                        _searchSourceViaAjaxNoHistory(filters, options, sourceID);
                    }
                    else {
                        _searchSourceViaAjax(filters, options, sourceID, searchSource);
                    }
                }
            }
        };
    })();

    Helpers = {
        alphanumericSort: function(a, b) {
            return (a < b ? -1 : (a > b ? 1 : 0));
        },

        getFilterUrl: function(filters) {
            var filterKeys = [],
                keysToValues = {},
                type, filter;

            for(type in filters) {
                if (filters.hasOwnProperty(type)) {
                    filter = filters[type];

                    if(filter.key && !keysToValues[filter.key] && (filter.value || filter.value === 0 || filter.value === false)) {
                        filterKeys.push(filter.key);
                        keysToValues[filter.key] = filter.value;
                    }
                }
            }

            filterKeys.sort(Helpers.alphanumericSort);
            var url = '', filterKey;
            while(filterKey = filterKeys.shift()) {
                url += '/' + filterKey + '/' + encodeURIComponent(keysToValues[filterKey]);
            }

            return url;
        },

        getFlattenedFilters: function(filters) {
            var result = {}, filter;

            for (var key in filters) {
                if (filters.hasOwnProperty(key) && typeof filters[key] === 'object') {
                    filter = Helpers.getFlattenedFilter(filters[key]);
                    if (filter) {
                        result[key] = filter;
                    }
                }
            }

            return result;
        },

        /**
         * Returns widget-specific data to pass into the AJAX request
         * @param {Object} eo Event Object passed in by the calling widget
         * @return {Object} Object containing the widget-specific data
         */
        getWidgetData: function(eo) {
            var result = {};

            if (eo && eo.data) {
                result.w_id = eo.w_id;
                result.rn_contextData = eo.data.rn_contextData;
                result.rn_contextToken = eo.data.rn_contextToken;
                result.rn_timestamp = eo.data.rn_timestamp;
            }

            return result;
        },

        getFlattenedFilter: function(filter) {
            if('value' in filter && 'type' in filter && 'key' in filter) {
                return {
                    value: filter.value,
                    key: filter.key,
                    type: filter.type
                };
            }
        },

        /**
         * Returns the current page path.
         * * Accounts for the implicit home mapping if the current page doesn't have a path or the path is '/app'.
         * * Removes all URL parameters.
         * @return {String} Current page
         */
        getCurrentPage: function() {
            var location = window.location,
                pathname = location.pathname,
                // window.location.origin is currently only supported in webkit browsers
                origin = location.origin || location.protocol + '//' + location.host;

            // If there's no path, (i.e. site.com homepage) the history url must be a FQDM otherwise the browser throws a cross-origin exception.
            // If the search is on the implicit hompage, make it the explicit homepage so that if the page is refreshed, an illegal param error isn't encounted.
            // If there's already a path, remove any parameters from it.
            return (pathname === "/" || pathname === "/app" || pathname === "/app/")
                ? origin + "/app/" + RightNow.Interface.getConfig("CP_HOME_URL")
                : pathname.split("/").slice(0, RightNow.Url.getParameterSegment() - 1).join("/");
        }
    };

    SourceConductor = (function(){
        var sources = {},
            hasHistorySource = false;

        var _searchSource = RightNow.EventProvider.extend({
            overrides: {
                constructor: function(Y, sourceID, options) {
                    this.parent();

                    this.sourceID = sourceID;
                    this.Y = Y;
                    this.initialFilters = {};
                    this.filters = {};
                    this.widgetData = {};
                    this.options = {};
                    this.cancelSearch = false;
                    this.impactsHistory = false;

                    delete this.data;
                    delete this.baseDomID;
                    delete this.baseSelector;

                    //Alias RightNow.Event.EventObject to appease closure compiler
                    var eventObject = RightNow.Event.EventObject;

                    //Collect is only triggered by the search button
                    this._addEventHandler('collect', {
                        pre: function() {
                            this.filters = this.initialFilters;
                        },
                        during: function(eo) {
                            var filter;
                            if(eo && eo instanceof eventObject) {
                                filter = Helpers.getFlattenedFilter(eo.data);
                                if(filter && filter.value) {
                                    this.filters[filter.type] = filter;
                                }
                                else {
                                    delete this.filters[filter.type];
                                }
                            }
                        }
                    });

                    //Search can be triggered either by the pagination widget or the search button
                    this._addEventHandler('search', {
                        pre: function(eo) {
                            if(eo && eo instanceof eventObject) {
                                this.options = Y.merge(this.options, eo.data);
                            }

                            this.options.params = Y.merge(this.options.params, this.widgetData);

                            // Super fun special casey case.
                            if ('page' in this.options) {
                                if (this.Y.Object.isEmpty(this.filters)) {
                                    this.filters = this.initialFilters;
                                }
                                this.filters.page = this.options.page;
                            }

                            this.cancelSearch = false;
                        },
                        during: function(eo) {
                            if(eo === false) {
                                this.cancelSearch = true;
                            }
                        },
                        post: function() {
                            //Only allow a single source to impact the history.
                            if(!hasHistorySource && this.options.history_source_id === this.instanceID) {
                                this.impactsHistory = hasHistorySource = true;
                            }

                            if(!this.cancelSearch) {
                                Search.go(this.filters, this.options, sourceID, this.impactsHistory, this);
                            }
                            else {
                                this.fire('searchCancelled', this.filters, this.options);
                            }
                        }
                    });

                    //Fired on page load to setup the history state
                    this._addEventHandler('initializeFilters', {
                        pre: function(eo) {
                            if(eo && eo instanceof eventObject) {
                                this.initialFilters = Helpers.getFlattenedFilters(eo.data);
                                this.widgetData = Helpers.getWidgetData(eo);
                            }
                        }
                    });

                    //Fired by the history to set a group of filters to a specific state
                    this._addEventHandler('updateFilters');

                    //Fired by the history to set a group of filters to their initial value
                    this._addEventHandler('reset');

                    this.on('reset', function() {
                        this.filters = this.initialFilters;
                        this.page = 0;
                    }, this);

                    //TSL - Revert all filters to their last state, use by the advanced search dialog on cancel
                    this._addEventHandler('revertFilter', {

                    });

                    //TSL - Fired by display search filters, needs to remove the filter from local data structures
                    //and notify the widget that the filter should be set to no-value
                    this._addEventHandler('removeFilter', {

                    });
                    this._addEventHandler('removeFilter', {

                    });
                },

                /**
                 * Sets search options.
                 * @param {Object} options Hash of options:
                 *                         - page: {int} Page number to fetch for the current
                 *                                 set of search filters
                 *                         - new_page: {string} A page path to execute the search via page navigation
                 *                         - target: {string} If `new_page` is specified, this target value is used on `window.open`
                 *                         - history_source_id: {string} Source id for the filters that should be maintained in the URL
                 *                         - endpoint: {string} AJAX endpoint to search
                 *                         - params: {object} Hash of post parameters to add to the search request
                 */
                setOptions: function (options) {
                    if (options && this.sourceID in options && options[this.sourceID]) {
                        options = options[this.sourceID];
                    }

                    this.options = this.Y.mix(this.options, options, true);

                    return this;
                }
            }
        });

        /**
         * @private
         * @constructor
         * @see SourceConductor.multipleSourcesWrapper
         */
        function _multipleSourcesWrapper(sources) {
            if (!sources || !sources.length || sources.length < 2)
                throw new Error("You're doing it wrong");
            this.sources = sources;
            this.multiple = true;
        }
        function delegate (method) {
            return function () {
                for (var i = 0, args = arguments, src; i < this.sources.length; i++) {
                    src = this.sources[i];
                    src[method].apply(src, args);
                }
                return this;
            };
        }
        _multipleSourcesWrapper.prototype = {
            on: delegate('on'),
            fire: delegate('fire'),
            setOptions: delegate('setOptions')
        };

        return {
            SearchSource: _searchSource,
            MultipleSourcesWrapper: _multipleSourcesWrapper,
            getSearchSources: function(sourceID) {
                return (sourceID) ? (sourceID + "").split(",") : [];
            },
            add: function(sourceID, source) {
                if(sourceID && source instanceof _searchSource && !sources[sourceID]) {
                    return (sources[sourceID] = source);
                }
            },
            get: function(sourceID) {
                return (sourceID) ? sources[sourceID] : sources;
            }
        };
    })();
    /**#nocode-*/

    /**
     * The RightNow.SearchFilter module provides common functionality for all SearchFilter widgets via a
     * searchSource() EventProvider instance. The search source allows widgets to hook into the search specific
     * event bus for a given report ID or source ID (or combination). The following events are provided by this
     * interface:
     * @example
     * Use searchSource().on('eventName', handlerFunction) in the extending widget to subscribe to these events:
     *     'search' - Triggered when a search is performed by the SearchButton widget. Gathers all of the
     *                search filters on the page and fires a send event.
     *     'send' - Validates that all of the widgets are ready for the search to be performed and submits
     *              the filters to the server
     *     'reset' - Reset all of the filters to their initial state (when the page was loaded)
     *     'setInitialFilters' - Set the initial page load filters.
     * @requires RightNow.Widgets
     * @constructor
     */
    //Used by any widget which can only work with a single source
    RightNow.SearchConsumer = RightNow.Widgets.extend(/**@lends RightNow.SearchConsumer*/{
        /**
         * Creates a searchSource method that can be used to subscribe to search filter events.
         */
        constructor: function() {
            var sources = SourceConductor.getSearchSources(this.data.attrs.source_id),
                existingSource = SourceConductor.get(sources[0]);

            if(sources.length > 1) {
                RightNow.UI.DevelopmentHeader.addJavascriptError("A search consumer cannot have more than one search source");
            }

            if(!existingSource) {
                existingSource = new SourceConductor.SearchSource(this.Y, sources[0]);
                SourceConductor.add(sources[0], existingSource);
            }

            this.searchSource = function() {
                return existingSource;
            };
        }
    });

    /**
     * The RightNow.SearchProducer module provides common functionality for all SearchProducer widgets via a
     * searchSource() EventProvider instance. Search 'producers' are widgets that initiate a search (e.g.
     * Search button, search filter dropdown, pagination links, etc.). The search source allows widgets to
     * hook into the search-specific event bus for a given source ID.
     * The following events are provided by this interface:
     * @example
     * Use searchSource().on('eventName', handlerFunction) in the extending widget to subscribe to these events:
     *     'collect' - Gathers all of the search filters on the page as a prelude to the 'search' event.
     *     'search' - Triggered when a search is to be performed.
     *     'send' - Validates that all of the widgets are ready for the search to be performed and submits
     *              the filters to the server.
     *     'reset' - Reset all of the filters to their initial state (when the page was loaded)
     *     'setInitialFilters' - Set the initial page load filters.
     * @requires RightNow.Widgets
     * @constructor
     */
    RightNow.SearchProducer = RightNow.Widgets.extend(/**@lends RightNow.SearchProducer*/{
        //Used by any widget which can interact with or initialize sources (button, filter, pagination)
        constructor: function() {
            var sources = SourceConductor.getSearchSources(this.data.attrs.source_id),
                searchSources = [];

            for(var i = 0, existingSource; i < sources.length; i++) {
                existingSource = existingSource = SourceConductor.get(sources[i]);
                if(!existingSource) {
                    existingSource = new SourceConductor.SearchSource(this.Y, sources[i]);
                    SourceConductor.add(sources[i], existingSource);
                }
                searchSources.push(existingSource);
            }

            if (!searchSources.length) {
                throw new Error("No search sources were given");
            }
            existingSource = (searchSources.length === 1) ? existingSource : new SourceConductor.MultipleSourcesWrapper(searchSources);
            this.searchSource = function() {
                return existingSource;
            };
        }
    });
})();
