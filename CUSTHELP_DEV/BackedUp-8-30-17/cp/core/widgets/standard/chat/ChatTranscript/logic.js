 /* Originating Release: May 2016 */
RightNow.Widgets.ChatTranscript = RightNow.Widgets.extend({
    constructor: function(){
        // Local member variables section
        this._transcriptContainer = this.Y.one(this.baseSelector);
        this._transcript = this.Y.one(this.baseSelector + '_Transcript');
        this._anchorRE = new RegExp(/(<a .*?>(.*?)<\/a>)/i);
        this._hrefRE = new RegExp(/href\s*=\s*['"](.+?)['"]/i);
        this._titleRE = new RegExp(/title\s*=\s*['"](.+?)['"]/i);
        this._urlRE = new RegExp(/((http[s]?:\/\/|ftp:\/\/)|(www\.)|(ftp\.))([^\s<>\.\/^{^}]+)\.([^\s<>^{^}]+)/i);
        this._quotedUrlRE = new RegExp(/['"]+((http[s]?:\/\/|ftp:\/\/)|(www\.)|(ftp\.))([^\s<>\.\/]+)\.([^\s<>]+)['"]+/i);
        this._tagRE = new RegExp(/(<\/?[\w]+[^>]*>)/i);
        this._endUserName = '';

        // Event subscription section. If no UI object exists (transcript), don't subscribe to any of the events since there's no UI object to update.
        if(this._transcript)
        {
            if(!this.data.attrs.mobile_mode)
            {
                RightNow.Event.subscribe("evt_chatCobrowseAcceptResponse", this._coBrowseAcceptResponse, this);
                RightNow.Event.subscribe("evt_chatCobrowseStatusResponse", this._coBrowseStatusResponse, this);
                RightNow.Event.subscribe("evt_fileUploadUpdateResponse", this._fileUploadResponse, this);
                RightNow.Event.subscribe("evt_chatNotifyFattachUpdateResponse", this._fileNotifyResponse, this);
            }

            RightNow.Event.subscribe("evt_chatStateChangeResponse", this._onChatStateChangeResponse, this);
            RightNow.Event.subscribe("evt_chatPostResponse", this._onChatPostResponse, this);
            RightNow.Event.subscribe("evt_chatEngagementParticipantAddedResponse", this._onChatEngagementParticipantAddedResponse, this);
            RightNow.Event.subscribe("evt_chatEngagementParticipantRemovedResponse", this._onChatEngagementParticipantRemovedResponse, this);
            RightNow.Event.subscribe("evt_chatEngagementConcludedResponse", this._onChatEngagementConcludedResponse, this);
            RightNow.Event.subscribe("evt_chatCobrowseInvitationResponse", this._coBrowseInvitationResponse, this);
            RightNow.Event.subscribe("evt_chatCoBrowsePremiumInvitationResponse", this._coBrowsePremiumInvitationResponse, this);
            RightNow.Event.subscribe("evt_chatReconnectUpdateResponse", this._reconnectUpdateResponse, this);
            RightNow.Event.subscribe("evt_chatAgentAbsentUpdateResponse", this._agentAbsentUpdateResponse, this);
            RightNow.Event.subscribe("evt_chatAgentStatusChangeResponse", this._onAgentStatusChangeResponse, this);
            RightNow.Event.subscribe("evt_chatPostCompletion", this._onChatPostCompletion, this);
            RightNow.Event.subscribe("evt_chatCoBrowsePremiumAcceptResponse", this._coBrowseAcceptResponse, this);

            this._preloadImages();
            this._transcript.setAttribute("aria-live", "polite").setAttribute("role", "log");
        }

        if(this.data.attrs.unread_messages_titlebar_enabled)
        {
            this._unreadCount = 0;
            this._windowFocused = document.hasFocus ? document.hasFocus() : false;
            this._baseTitle = document.title;
            var Event = this.Y.Event;
            if(this.Y.UA.ie > 0)
            {
                Event.attach("focusin", this._onApplicationFocus, document, this);
                Event.attach("focusout", this._onApplicationBlur, document, this);
            }
            else
            {
                Event.attach("focus", this._onApplicationFocus, window, this);
                Event.attach("blur", this._onApplicationBlur, window, this);
            }
        }
    },

    /**
    * Handles the state of the chat has changed.
     * @param type string Event name
     * @param args object Event arguments
     */
    _onChatStateChangeResponse: function(type, args)
    {
        var currentState = args[0].data.currentState;
        var previousState = args[0].data.previousState;
        var ChatState = RightNow.Chat.Model.ChatState;
        var newMessage = null;

        if(currentState === ChatState.CONNECTED)
            RightNow.UI.show(this._transcriptContainer);
        else if(currentState === ChatState.RECONNECTING)
        {
            this._stateBeforeReconnect = previousState;
            if(previousState === ChatState.CONNECTED)
                newMessage = RightNow.Interface.getMessage("COMM_RN_LIVE_SERV_LOST_PLS_WAIT_MSG");
        }
        else if(currentState === ChatState.DISCONNECTED && (args[0].data.reason === 'RECONNECT_FAILED' || args[0].data.reason === 'ERROR'))
            newMessage = RightNow.Interface.getMessage("COMM_RN_LIVE_SERV_LOST_CHAT_SESS_MSG");

        if(currentState === ChatState.CONNECTED && previousState === ChatState.RECONNECTING)
            newMessage = RightNow.Interface.getMessage("CONNECTION_RESUMED_MSG");

        if(newMessage !== null)
        {
            this._appendEJSToChat(this.getStatic().templates.systemMessage, {
                attrs: this.data.attrs,
                messages: [newMessage],
                context: null
            });
        }
    },
    /**
    * Event received when a participant joins the chat. Adds note to transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _onChatEngagementParticipantAddedResponse: function(type, args)
    {
        var agent = args[0].data.agent;
        var role = args[0].data.role;
        var message = "";

        if(role === "LEAD")
        {
            if(RightNow.Chat.UI.Util.hasLeaveScreenIssues())
            {
                this._appendEJSToChat(this.getStatic().templates.systemMessage, {
                    attrs: this.data.attrs,
                    messages: [this.data.attrs.label_leave_screen_warning],
                    context: null
                });
            }

            message = ': ' + agent.greeting;
        }
        else
        {
            message = ' ' + this.data.attrs.label_has_joined_chat;
        }

        this._appendEJSToChat(this.getStatic().templates.participantAddedResponse, {
            attrs: this.data.attrs,
            agentName: this._getAgentIdString(args[0].data.agent.name),
            role: role,
            message: message
        });
    },
    /**
    * Event received when participant leaves the chat. Adds note to transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _onChatEngagementParticipantRemovedResponse: function(type, args)
    {
        var reason = args[0].data.reason;
        var agent = args[0].data.agent;

        if(!agent)
            return;

        this._appendEJSToChat(this.getStatic().templates.systemMessage, {
            attrs: this.data.attrs,
            messages: [this._getAgentIdString(agent.name), (args[0].data.reason === RightNow.Chat.Model.ChatDisconnectReason.TRANSFERRED_TO_QUEUE ? this.data.attrs.label_has_disconnected : this.data.attrs.label_has_left_chat)],
            context: null
        });
    },
    /**
     * Handles adding a new chat post to the transcript.
     * @param type string Event name
     * @param args object Event arguments
     */
    _onChatPostResponse: function(type, args)
    {
        var message = args[0].data.messageBody;
        var messageId = args[0].data.messageId;
        var isEndUserPost = args[0].data.isEndUserPost;
        var postID;
        var name;

        if(args[0].data.richText === undefined || args[0].data.richText === false)
            message = this.Y.Escape.html(message).replace(/\n/g, "<br/>");
        else if(!this.data.attrs.mobile_mode)
            message = this._formatLinks(message);

        if(args[0].data.isOffTheRecord)
            message = this.data.attrs.label_off_the_record + ' ' + message;

        if(args[0].data.isEndUserPost)
        {
            postID = 'eup_' + messageId;
            this._setEndUserName(args);
            name = this._endUserName;
        }
        else
        {
            postID = args[0].data.serviceFinishTime;
            name = this._getAgentIdString(args[0].data.agent.name);
        }

        this._appendEJSToChat(this.getStatic().templates.chatPostResponse, {
                attrs: this.data.attrs,
                endUserName: name,
                agentName: name,
                message: message,
                context: args[0].data
        }, postID);
    },

    _setEndUserName: function(args)
    {
        // Only parse enduser name once; it won't change, and this function is hit often, so this tweak is worthwhile.
        if(!this._endUserName || this._endUserName === '')
        {
            var endUser = args[0].data.endUser;

            if(endUser.firstName === null && endUser.lastName === null)
            {
                if(endUser.email === null)
                    this._endUserName = this.data.attrs.label_enduser_name_default_prefix;
                else
                    this._endUserName = endUser.email;
            }
            else
            {
                if(endUser.firstName !== null && endUser.lastName !== null)
                {
                    var internationalNameOrder = RightNow.Interface.getConfig("intl_nameorder", "COMMON");
                    this._endUserName = internationalNameOrder ? endUser.lastName + " " + endUser.firstName : endUser.firstName + " " + endUser.lastName;
                }
                else if(endUser.firstName !== null)
                {
                    this._endUserName = endUser.firstName;
                }
                else
                {
                    this._endUserName = endUser.lastName;
                }

                this._endUserName += RightNow.Interface.getMessage("NAME_SUFFIX_LBL");

                // Ensure that any < or > characters are escaped to avoid vulnerabilities
                this._endUserName = this._endUserName.replace(/</g, "&lt;");
                this._endUserName = this._endUserName.replace(/>/g, "&gt;");
            }
        }
    },
    /**
    * Event received when a post has been successfuly sent
    * @param response object Event response object
    */
    _onChatPostCompletion: function(type, args)
    {
        var messageId = args[0];
        var timestamp = args[1];
        var post = this.Y.one('#eup_' + messageId);
        var insertNode;

        if (post)
        {
            post.set('id', timestamp);

            if (post.previous() && post.previous().get('id') > timestamp)
            {
                insertNode = post.previous();
                post.remove();
                insertNode.insert(post, "before");
            }
            else if (post.next() && post.next().id < timestamp)
            {
                insertNode = post.next();
                post.remove();
                insertNode.insert(post, "after");
            }
        }
    },
    /**
    * Event received when the engagement has been concluded. Adds note to transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _onChatEngagementConcludedResponse: function(type, args)
    {
        var agent = args[0].data.agent;
        var messages = [];
        var context = null;

        // agent should never be null if isUserDisconnect is null or false.
        if(args[0].data.isUserDisconnect)
        {
            if(args[0].data.reason === 'IDLE_TIMEOUT')
                messages.push(RightNow.Interface.getMessage("DISCONNECTED_CHAT_DUE_INACTIVITY_MSG"));
            else
            {
                messages.push(this.data.attrs.label_you);
                messages.push(this.data.attrs.label_have_disconnected);
                context = args[0].data;
            }
        }
        else
        {
            messages.push(agent.name);
            messages.push(this.data.attrs.label_has_disconnected);
        }

        this._appendEJSToChat(this.getStatic().templates.systemMessage, {
            attrs: this.data.attrs,
            messages: messages,
            context: context
        });
    },
    /**
    * Event received when a file attachment status update is received. Adds note to transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _fileNotifyResponse: function(type, args)
    {
        this._appendEJSToChat(this.getStatic().templates.systemMessage, {
            attrs: this.data.attrs,
            messages: [this.data.attrs.label_file_attachment_started],
            context: null
        });
    },
    /**
    * Event received when a file attachment upload is completed or errored. Adds note to transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _fileUploadResponse: function(type, args)
    {
        var attachmentInfo = args[0];
        var message = "";

        if(attachmentInfo.error !== 0 || attachmentInfo.errorMessage)
        {
            message = this.data.attrs.label_file_attachment_error;
        }
        else
        {
            var fileName = attachmentInfo.name;
            var fileSize = Math.round((attachmentInfo.size / 1024) * 100) / 100;
            message = this.data.attrs.label_file_attachment_received
                                .replace("{0}", fileName)
                                .replace("{1}", fileSize + 'KB');
        }

        this._appendEJSToChat(this.getStatic().templates.systemMessage, {
            attrs: this.data.attrs,
            messages: [message],
            context: null
        });
    },
    /**
    * Event received when an agent has gone absent. Adds note to transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _agentAbsentUpdateResponse: function(type, args)
    {
        if(args[0].data.requeueSeconds)
            this._appendEJSToChat(this.getStatic().templates.systemMessage, {
                attrs: this.data.attrs,
                messages: [RightNow.Interface.getMessage("REQUEUED_APPROXIMATELY_0_MSG").
                                    replace("{0}", args[0].data.requeueSeconds)],
                context: null
            });
    },
    /**
    * Event received when a cobrowse session is being offered. Adds note with clickable links to transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _coBrowseInvitationResponse: function(type, args)
    {
        var CoBrowseTypes = RightNow.Chat.Model.ChatCoBrowseType;
        var type = args[0].data.modeType;
        var coBrowseUrl = args[0].data.coBrowseUrl;
        var agent = args[0].data.agent;

        if(this.data.attrs.mobile_mode)
        {
            RightNow.Widgets.ChatTranscript.sendCoBrowseResponse(false);
        }
        else
        {
            var message = "";
            if(type === CoBrowseTypes.SCREEN || type === CoBrowseTypes.SCREEN_POINTER)
                message = this.data.attrs.label_agent_requesting_view_desktop;
            else
                message = this.data.attrs.label_agent_requesting_control_desktop;

            this._appendEJSToChat(this.getStatic().templates.cobrowseInvitationResponse, {
                attrs: this.data.attrs,
                message: message,
                agentName: agent.name,
                url: coBrowseUrl
            });
        }
    },
    /**
    * Event received when a cobrowse premium session is being offered. Adds note with clickable links to transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _coBrowsePremiumInvitationResponse: function(type, args)
    {
        if(this.data.attrs.mobile_mode)
        {
            RightNow.Widgets.ChatTranscript.sendCoBrowseResponse(false);
            return;
        }

        var agentEnvironment = args[0].data.agentEnvironment;
        var coBrowseSessionId = args[0].data.coBrowseSessionId;
        var agent = args[0].data.agent;

        this._appendEJSToChat(this.getStatic().templates.CoBrowsePremiumInvitationResponse, {
            attrs: this.data.attrs,
            message: this.data.attrs.label_agent_requesting_view_desktop,
            agentName: agent.name,
            agentEnvironment: agentEnvironment,
            coBrowseSessionId: coBrowseSessionId
        });
        this.Y.one(this.baseSelector).delegate('click', this.onAllowCoBrowsePremiumClick, 'a.rn_CoBrowsePremiumAllow', this);
        this.Y.one(this.baseSelector).delegate('click', this.onDeclineCoBrowsePremiumClick, 'a.rn_CoBrowsePremiumDecline', this);
    },
    /**
    * Event received when a cobrowse offer has been accepted. Adds note to transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _coBrowseAcceptResponse: function(type, args)
    {
        var accepted = args[0].data.accepted;
        var message = "";

        this._transcript.all('.rn_CoBrowseAction').remove();

        if(accepted)
            message = this.data.attrs.label_initializing_screen_sharing_session;
        else
            message = this.data.attrs.label_screen_sharing_session_declined;

        this._appendEJSToChat(this.getStatic().templates.systemMessage, {
            attrs: this.data.attrs,
            messages: [message],
            context: null
        });
    },
    /**
    * Event received when the status of a cobrowse session has changed. Adds note regarding new status to transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _coBrowseStatusResponse: function(type, args)
    {
        var ChatCoBrowseStatusCode = RightNow.Chat.Model.ChatCoBrowseStatusCode;
        var coBrowseStatus = args[0].data.coBrowseStatus;
        var message = "";

        switch(coBrowseStatus)
        {
            case ChatCoBrowseStatusCode.STARTED:
                message = this.data.attrs.label_screen_sharing_session_started;
                break;
            case ChatCoBrowseStatusCode.STOPPED:
                message = this.data.attrs.label_screen_sharing_session_ended;
                break;
            case ChatCoBrowseStatusCode.ERROR:
                // LiveLOOK recently changed the error data to: <code> - <string>. We want to use our own string.
                // Parse out the preceding <code> integer; since only values are 0 and 1, safely assume first char.
                var errorCode = parseInt(args[0].data.coBrowseData[0], 10);

                if(errorCode === 0)
                    message = this.data.attrs.label_java_not_detected;
                else if(errorCode === 1)
                    message = this.data.attrs.label_java_cert_rejected;
                break;
        }

        this._appendEJSToChat(this.getStatic().templates.systemMessage, {
            attrs: this.data.attrs,
            messages: [message],
            context: null
        });
    },
    /**
    * Event received when a reconnect status update is triggered. Adds a note about the reconnection attempt status to the transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _reconnectUpdateResponse: function(type, args)
    {
        if(this._stateBeforeReconnect === RightNow.Chat.Model.ChatState.CONNECTED)
            this._appendEJSToChat(this.getStatic().templates.systemMessage, {
                attrs: this.data.attrs,
                messages: [RightNow.Interface.getMessage("DISCONNECTION_IN_0_SECONDS_MSG")
                                           .replace("{0}", args[0].data.secondsLeft)],
                context: null
            });
    },
    /**
    * Event received when an agent's status is changed. Notes about the status change are added to the transcript.
    * @param type string Event name
    * @param args object Event arguments
    */
    _onAgentStatusChangeResponse: function(type, args)
    {
        var agent = args[0].data.agent;
        if(!agent)
            return;

        var message = null;
        if(agent.activityStatus === RightNow.Chat.Model.ChatActivityState.ABSENT)
            message = RightNow.Interface.getMessage("COMM_DISP_NAME_LOST_PLS_WAIT_MSG");
        else if(args[0].data.previousState === RightNow.Chat.Model.ChatActivityState.ABSENT)
            message = RightNow.Interface.getMessage("COMM_DISPLAY_NAME_RESTORED_MSG");

        if(message !== null)
            this._appendEJSToChat(this.getStatic().templates.agentStatusChangeResponse, {
                attrs: this.data.attrs,
                message: message,
                agentName: agent.name
            });
    },
    /**
    * Function is used to pre-load all images that could be used in the chat transcript. Avoids issues delays showing new images in transcript.
    * Also avoids a bug where connection is lost and an icon is used in the transcript.
    */
    _preloadImages: function()
    {
        var imageArray = [];

        imageArray.push(this.data.attrs.alert_icon_path);
        imageArray.push(this.data.attrs.agent_message_icon_path);
        imageArray.push(this.data.attrs.off_the_record_icon_path);

        if(!this.data.attrs.mobile_mode)
            imageArray.push(this.data.attrs.cobrowse_icon_path);

        if(this.data.attrs.enduser_message_icon_path)
            imageArray.push(this.data.attrs.enduser_message_icon_path);

        for(var x = 0; x < imageArray.length; x++)
            eval("var imageObject" + x + " = new Image(); imageObject" + x + ".src = imageArray[x];");
    },

    /**
     * Handles adding a new chat post to the transcript.
     * @param postText object EJS object
     * @param postData object JSON object containing data to be passed to EJS
     * @param postID string (optional) If desired, an ID can be assigned to the created EJS by specifying this attribute
     */
    _appendEJSToChat: function(postText, postData, postID)
    {
        var newEntry = this.Y.Node.create(new EJS({text: postText}).render(postData));

        if(postID !== undefined)
            newEntry.set("id", postID);

        this._transcript.appendChild(newEntry);

        // Using scrollIntoView doesn't have consistent behavior across browsers (particularly IE). Use YUI Anim instead.
        var scrollAnim = new this.Y.Anim({
            node: this._transcriptContainer,
            to: {
                scroll: function(node) { return [0, node.get('scrollHeight')] }
            }
        }).run();

        if(this.data.attrs.unread_messages_titlebar_enabled && !this._windowFocused)
            document.title = '(' + (++this._unreadCount) + ') ' + this._baseTitle;
    },

    /**
    * Format anchor tags and optionally text URLs into a clickable link in transcript.
    * @param text string Input text to process
    */
    _formatLinks: function(text)
    {
        var newText = '';
        var stringArray;
        var tempString = text;
        var titles = {};
        var hrefs = {};
        var descs = {};
        var tags = {};
        var quotedUrls = {};
        var aMatches = 0;
        var qMatches = 0;
        var tMatches = 0;
        var anchorMatch = "";

        while(anchorMatch = tempString.match(this._anchorRE))
        {
            descs[aMatches] = anchorMatch[2];
            stringArray = tempString.split(anchorMatch[0]);

            var title = anchorMatch[0].match(this._titleRE);
            if(title != null)
                titles[aMatches] = title[1];

            href = hrefs[aMatches] = anchorMatch[0].match(this._hrefRE);
            if(href != null)
            {
                hrefs[aMatches] = href[1];

                if(!hrefs[aMatches].match(/^(http(s)?)/i))
                    hrefs[aMatches] = "http://" + hrefs[aMatches];

                newText += stringArray[0] + "{RNTAMATCH" + aMatches + "}";

                aMatches++;
            }

            if (stringArray.length > 0)
            {
                stringArray.shift();
                tempString = stringArray.join(anchorMatch[0]);
            }
        }

        if(aMatches !== 0)
        {
            newText += tempString;
            tempString = newText;
            newText = "";
        }

        //Replace tags with tokens so we don't end up with tags inside tags
        while(urlMatch = tempString.match(this._tagRE))
        {
             tags[tMatches] = urlMatch[0];
             tempString = tempString.replace(urlMatch[0], "{RNTTMATCH" + tMatches + "}");
             tMatches++;
        }

        //Replace quoted URL's so we don't modify those
        var urlMatch = "";
        while(urlMatch = tempString.match(this._quotedUrlRE))
        {
            quotedUrls[qMatches] = urlMatch[0];
            tempString = tempString.replace(urlMatch[0], "{RNTQMATCH" + qMatches + "}");
            qMatches++;
        }

        while(urlMatch = tempString.match(this._urlRE))
        {
            var href = urlMatch[0];
            stringArray = tempString.split(urlMatch[0]);

            if(urlMatch[0].match(/^ftp\./i))
                href = "ftp://" + urlMatch[0];
            else if(!urlMatch[0].match(/^(http(s)?|ftp)/i))
                href = "http://" + urlMatch[0];

            var replace = "<a href='" + href + "' target='_blank'>" + urlMatch[0] + "</a>";
            newText += stringArray[0] + replace;

            if (stringArray.length > 0)
            {
                stringArray.shift();
                tempString = stringArray.join(urlMatch[0]);
            }
        }

        newText += tempString;

        //Return the quoted URLs
        if(qMatches > 0)
        {
            for(var x = 0; x < qMatches; x++)
                newText = newText.replace("{RNTQMATCH" + x + "}", quotedUrls[x]);
        }

        if(tMatches > 0)
        {
            for(var x = 0; x < tMatches; x++)
                newText = newText.replace("{RNTTMATCH" + x + "}", tags[x]);
        }

        if(aMatches > 0)
        {
            for(var x = 0; x < aMatches; x++)
            {
                if(this.data.attrs.mobile_mode)
                    newText = newText.replace("{RNTAMATCH" + x + "}", descs[x] == null ? hrefs[x] : descs[x] + ' (' + hrefs[x] + ')');
                else
                    newText = newText.replace("{RNTAMATCH" + x + "}", "<a href='" + hrefs[x] + "' " + (titles[x] == null ? "" : "title=\"" + titles[x] + "\" ") + " target=\"_blank\">" + (descs[x] == null ? hrefs[x] : descs[x]) + "</a>");
            }
        }

        return newText;
    },
    _getAgentIdString: function(agentName)
    {
        return this.data.attrs.agent_id.replace(/{display_name}/g, agentName);
    },

    /**
    * Handles when the window gains focus.
    */
    _onApplicationFocus: function()
    {
        this._windowFocused = true;
        this._unreadCount = 0;

        document.title = this._baseTitle;
    },

    /**
    * Handles when the window loses focus.
    */
    _onApplicationBlur: function()
    {
        this._windowFocused = false;
    },
    /**
    * Event handler when CobrowsePremium Allow is clicked in the transcript.
    * @param e boolean event
    */
    onAllowCoBrowsePremiumClick: function (e)
    {
        e.halt();
        var target = e.currentTarget,
            agentEnvironment = target.getAttribute('data-agentEnvironment'),
            coBrowseSessionId = target.getAttribute('data-coBrowseSessionId');
        RightNow.Widgets.ChatTranscript.sendCoBrowsePremiumResponse(true, agentEnvironment, coBrowseSessionId);
    },
    /**
    * Event handler when CobrowsePremium Decline is clicked in the transcript.
    */
    onDeclineCoBrowsePremiumClick: function ()
    {
        RightNow.Widgets.ChatTranscript.sendCoBrowsePremiumResponse(false);
    }
},
{
    /**
    * Static function called when user clicks a cobrowse action in the transcript.
    * @param accepted boolean Flag for whether cobrowse was accepted
    * @param coBrowseUrl string The URL for the cobrowse session
    */
    sendCoBrowseResponse: function(accepted, coBrowseUrl)
    {
        var eo = new RightNow.Event.EventObject(this, {data: {}});

        if(accepted)
        {
            eo.data = {coBrowseUrl: coBrowseUrl};
            RightNow.Event.fire('evt_chatCoBrowseAcceptRequest', eo);
        }
        else
        {
            RightNow.Event.fire('evt_chatCoBrowseDenyRequest', eo);
        }
    },
    /**
    * Static function called when user clicks a cobrowse action in the transcript.
    * @param accepted boolean Flag for whether cobrowse was accepted
    * @param agentEnvironment string The agentEnvironment for the cobrowse session
    * @param coBrowseSessionId string The coBrowseSessionId for the cobrowse session
    */
    sendCoBrowsePremiumResponse: function(accepted, agentEnvironment, coBrowseSessionId)
    {
        var eo = new RightNow.Event.EventObject(this, {data: {}});

        if(accepted)
        {
            eo.data = {agentEnvironment: agentEnvironment, coBrowseSessionId: coBrowseSessionId};
            RightNow.Event.fire('evt_chatCoBrowsePremiumAcceptRequest', eo);
        }
        else
        {
            RightNow.Event.fire('evt_chatCoBrowsePremiumDenyRequest', eo);
        }
    }
});
