 /* Originating Release: November 2014 */
RightNow.Widgets.ConditionalChatLink = RightNow.Widgets.extend({
    constructor: function()
    {
        this._container = this.Y.one(this.baseSelector);

        this._pollingBegan = null;
        this._linkClicked = false;
        this._offerRecorded = this.data.js.offer_recorded;
        this._queueReceivedEventSubscribed = false;
        this._linkUrl = this.data.js.link_url;

        var initialResult = {};

        if(this.data.attrs.initiate_by_event)
        {
            // If initiate_by_event is enabled, we won't have availability data initially,
            // so we will display the default message.

            if(this.data.attrs.hide_on_unavailable)
            {
                // If hide_on_unavailable is also enabled, we will assume no available sessions
                // and hide the widget initially.
                initialResult.stats = { availableSessionCount: 0, expectedWaitSeconds: 0 };
            }
        }
        else if(this.data.js.unavailable_hours)
        {
            initialResult.out_of_hours = true;
        }
        else if(this.data.js.available_session_count !== undefined && this.data.js.expected_wait_seconds !== undefined)
        {
            initialResult.stats = {
                availableSessionCount: this.data.js.available_session_count,
                expectedWaitSeconds: this.data.js.expected_wait_seconds
            };
        }

        this._eo = new RightNow.Event.EventObject(this, {data: {
            wait_threshold: this.data.attrs.wait_threshold,
            min_agents_avail: this.data.attrs.min_sessions_avail,
            interface_id: this.data.js.interface_id,
            contact_email: this.data.js.contact_email,
            contact_fname: this.data.js.contact_fname,
            contact_lname: this.data.js.contact_lname,
            prod: this.data.js.prod,
            cat: this.data.js.cat,
            c_id: this.data.js.c_id,
            org_id: this.data.js.org_id,
            cacheable: true,
            avail_type: this.data.js.avail_type,
            ccl: true
        }});

        this._onQueueReceived(initialResult);

        // Subscribe to event fired on prod/cat change on pages such as the answer's "Advanced Search"
        RightNow.Event.subscribe("evt_productCategoryFilterSelected", this._onProdCatChanged, this);

        // Check to see whether polling is enabled. Start timer if so.
        if(!this.data.attrs.initiate_by_event && this.data.attrs.enable_availability_check && this.data.attrs.enable_polling)
            this._startPollingTimer(false);

        if(this.data.attrs.initiate_by_event)
        {
            RightNow.Event.subscribe("evt_customInitialization", this._startPollingTimer, this, true);
            // There could be race condition where the widget loads after the page referencing it loads
            RightNow.Event.fire("evt_CCLReady");
            RightNow.Event.subscribe("evt_isCCLReady", function(){
                RightNow.Event.fire("evt_CCLReady");
            }, this);
        }
    },

    /**
     * Starts polling for new availability information, if enabled.
     * @param {boolean} startImmediately If true, the polling will begin immediately. Otherwise it will start in 5 seconds.
     * @param {object} args Contains the data for the event, if it was called indirectly from an event fire
     */
    _startPollingTimer: function(startImmediately, args)
    {
        // Construct the URL that will be opened when link is clicked first.
        // Send the visitor ID and engagement engine ID obfuscated in the chat_data URL parameter (if available)
        var chatData = this.data.js.routeData || '';

        if(args !== undefined && args[0] !== undefined && args[0].data !== undefined)
        {
            var data = args[0].data;

            chatData = this._addChatDataParam(chatData, 'referrerUrl', encodeURIComponent(window.location.href));
            chatData = this._addChatDataParam(chatData, 'v_id', data.visitor_id);
            chatData = this._addChatDataParam(chatData, 'ee_id', data.ee_id);
            chatData = this._addChatDataParam(chatData, 'es_id', data.estara_id);
            chatData = this._addChatDataParam(chatData, 'ee_s_id', data.ee_session_id);
        }

        if(chatData.length !== 0)
            this._linkUrl = RightNow.Url.addParameter(this.data.js.link_url, 'chat_data', RightNow.Text.Encoding.base64Encode(chatData));

        // If polling has already started, immediately return.
        // Special case: When using the event triggered polling with
        // enable_polling set to false, we want to continue.
        if(this._pollingBegan !== null && this.data.attrs.enable_polling)
            return;

        if(!this._queueReceivedEventSubscribed)
            RightNow.Event.subscribe("evt_chatQueueResponseCCL", this._onQueueReceived, this);

        this._pollingBegan = new Date().getTime();

        if(startImmediately)
        {
            this._onPollingTimerElapsed();
        }
        else
        {
            // The memcache entries for this data timeout every 12 seconds. Setting lower than 5 seconds is ineffectual.
            this.Y.later(12000, this, this._onPollingTimerElapsed);
        }
    },

    /**
     * Fires the check chat queue request and renews the timer
     */
    _onPollingTimerElapsed: function()
    {
        if(RightNow.Event.fire("evt_chatQueueRequest", this._eo))
        {
            RightNow.Ajax.makeRequest(this.data.attrs.get_chat_info_ajax, this._eo.data, {
                successHandler: this._onQueueReceived,
                failureHandler: function() {}, // Just stifle any errors which could possibly occur, since this is non-critical
                scope: this,
                json: true,
                data: this._eo,
                type: "GETPOST",
                cors: true
            });
        }

        // If < 5 minutes, poll every 12 seconds. Otherwise, poll once per minute.
        var timeElapsed = new Date().getTime() - this._pollingBegan;
        var newTimeout = timeElapsed >= 30000 ? 60000 : 12000;

        // If this is triggered by event, it's possible to still have polling enabled.
        // Don't start polling now if that's the case.
        if(this.data.attrs.enable_polling)
            this.Y.later(newTimeout, this, this._onPollingTimerElapsed);
    },

    /*
     * Opens the chat link. If open in new window is enabled, opens window first and
     * then publishes DQA stats. Otherwise, publishes stats and then
     * redirects the window on callback.
     */
    _openChatLink: function()
    {
        var callback = null;

        if(this.data.attrs.open_in_new_window)
            window.open(this._linkUrl, 'chatLauncher', 'width=' + this.data.attrs.chat_login_page_width + ',height=' + this.data.attrs.chat_login_page_height + ',scrollbars=1');
        else
            callback = function() { window.location.href = this._linkUrl; };

        // Publish DQA stats
        if(!this._linkClicked)
        {
            this._linkClicked = true;
            this._publishStats({w:this.data.js.dqaWidgetType.toString(), accepts:1}, callback);
        }
    },

    /**
     * Event handler for when availability information has been received
     * @param {String} result Result containing queue information
     */
     _onQueueReceived: function(result)
    {
        var availableSessionCount = 0, expectedWaitSeconds = 0;
        var availableImmediately = false, availableWithWait = false, unavailableBusy = false, unavailableHours = false;

        // If there was an error, result may be null. Set to blank object and allow to fall through to default case.
        if(result === null || result === undefined){
            result = {};
        }

        // It's possible that prod/cat have changed; update the link URL to include it, in case. If it's 0 or undefined, just delete it in case it existed previously.
        var eoData = this._eo.data;

        this._linkUrl = eoData.prod ? RightNow.Url.addParameter(this._linkUrl, 'p', eoData.prod) : RightNow.Url.deleteParameter(this._linkUrl, 'p');
        this._linkUrl = eoData.cat ? RightNow.Url.addParameter(this._linkUrl, 'c', eoData.cat) : RightNow.Url.deleteParameter(this._linkUrl, 'c');

        if(result.stats)
        {
            availableSessionCount = parseInt(result.stats.availableSessionCount, 10);
            expectedWaitSeconds = parseInt(result.stats.expectedWaitSeconds, 10);

            if(expectedWaitSeconds <= this.data.attrs.wait_threshold && availableSessionCount >= this.data.attrs.min_sessions_avail && (expectedWaitSeconds > 0 || availableSessionCount > 0))
            {
                // Conditions met to offer the chat. Select the appropriate message.
                if(expectedWaitSeconds === 0)
                    availableImmediately = true;
                else
                    availableWithWait = true;
            }
            else
            {
                unavailableBusy = true;
            }
        }
        else if(result.out_of_hours)
        {
            unavailableHours = true;
        }

        this._container.removeClass('rn_Hidden');

        if(this.data.attrs.hide_on_unavailable && (unavailableHours || unavailableBusy))
        {
            this._container.addClass('rn_Hidden');
        }
        else if(availableImmediately || availableWithWait)
        {
            if(!this._offerRecorded)
            {
                this._offerRecorded = true;
                this._publishStats({w:this.data.js.dqaWidgetType.toString(), offers:1}, null);
            }

            if(availableImmediately)
            {
                this._container.setContent(this.Y.Node.create(new EJS({text: this.getStatic().templates.availableImmediatelyMessage}).render({
                    instanceID: this.instanceID,
                    linkTitle: RightNow.Interface.getMessage("LIVE_CHAT_LBL"),
                    message: this._parseMacro(this.data.attrs.label_available_immediately_template, expectedWaitSeconds)
                    })));

                this._addClickHandler(this.Y.one(this.baseSelector + '_AvailableImmediatelyLink'));
            }
            else
            {
                this._container.setContent(this.Y.Node.create(new EJS({text: this.getStatic().templates.availableWithWaitMessage}).render({
                    instanceID: this.instanceID,
                    linkTitle: RightNow.Interface.getMessage("LIVE_CHAT_LBL"),
                    message: this._parseMacro(this.data.attrs.label_available_with_wait_template, expectedWaitSeconds)
                })));

                this._addClickHandler(this.Y.one(this.baseSelector + '_AvailableWithWaitLink'));
            }
        }
        else if(unavailableBusy)
        {
            this._container.setContent(this.Y.Node.create(new EJS({text: this.getStatic().templates.unavailableBusyMessage}).render({
                instanceID: this.instanceID,
                linkTitle: RightNow.Interface.getMessage("LIVE_CHAT_LBL"),
                message: this._parseMacro(this.data.attrs.label_unavailable_busy_template, expectedWaitSeconds)
            })));

            this._addClickHandler(this.Y.one(this.baseSelector + '_UnavailableBusyLink'));
        }
        else if(unavailableHours)
        {
            this._container.setContent(this.Y.Node.create(new EJS({text: this.getStatic().templates.unavailableHoursMessage}).render({
                instanceID: this.instanceID,
                linkTitle: RightNow.Interface.getMessage("LIVE_CHAT_LBL"),
                message: this.data.attrs.label_unavailable_hours
            })));

            this._addClickHandler(this.Y.one(this.baseSelector + '_UnavailableHoursLink'));
        }
        else
        {
            // No availability information provided. Show "default" message.
            this._container.setContent(this.Y.Node.create(new EJS({text: this.getStatic().templates.defaultMessage}).render({
                instanceID: this.instanceID,
                linkTitle: RightNow.Interface.getMessage("LIVE_CHAT_LBL"),
                message: this.data.attrs.label_default
            })));

            this._addClickHandler(this.Y.one(this.baseSelector + '_DefaultLink'));
        }
    },

    _addClickHandler: function(elementNode)
    {
        if(elementNode)
            elementNode.on('click', this._openChatLink, this);
    },

    _parseMacro: function(message, expectedWaitSeconds)
    {
        var expectedWaitMinutes = Math.floor(expectedWaitSeconds / 60);

        if(message.indexOf('{NUM_MINUTES}' !== -1))
        {
            expectedWaitSeconds = expectedWaitSeconds % 60;

            message = message.replace('{NUM_MINUTES}', expectedWaitMinutes).replace('{MINUTES}', expectedWaitMinutes === 1 ? RightNow.Interface.getMessage("MINUTE_LC_LBL") : RightNow.Interface.getMessage('MINUTES_LWR_LBL'));
        }

        var expectedWaitSecondsPadded = expectedWaitSeconds < 10 ? '0' + expectedWaitSeconds.toString() : expectedWaitSeconds;
        message = message.replace('{TIME}', expectedWaitMinutes + ':' + expectedWaitSecondsPadded);

        return message.replace('{NUM_SECONDS}', expectedWaitSeconds).replace('{SECONDS}', expectedWaitSeconds === 1 ? RightNow.Interface.getMessage('SECOND_LBL') : RightNow.Interface.getMessage('SECONDS_LC_LBL'));
    },

    _publishStats: function(data, callback)
    {
        RightNow.Ajax.CT.submitAction(RightNow.Ajax.CT.WIDGET_STATS, data, callback, this);
    },

    /**
     * Adds key/value pair to the chatData parameter that's sent in the chat URL
     * @param {String} chatData The existing chatData string
     * @param {String} key The key to add
     * @param {String} value The value that corresponds to the key
     * @return {String}
     */
    _addChatDataParam: function(chatData, key, value)
    {
        // Make sure the chatData var at least exists. Set to empty string if not.
        if(chatData === undefined)
            chatData = '';

        // Check that value is set, and not empty
        if(value === undefined || value.length === 0)
            return chatData;

        if(chatData.length !== 0)
            chatData += '&';

        chatData += key + '=' + value;

        return chatData;
    },

    /**
     * Event handler for when the prod/cat search items on a page are changed
     * @param {String} type Event name
     * @param {Object} args Event arguments
     */
     _onProdCatChanged: function(type, args)
    {
        var prodCatType = args[0].data.data_type;
        var value = args[0].data.value;

        if (prodCatType.indexOf("Category") > -1)
            this._eo.data.cat = value;
        else // assume prod
            this._eo.data.prod = value;
    }
});
