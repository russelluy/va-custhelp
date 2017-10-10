 /* Originating Release: May 2016 */
RightNow.Widgets.ChatQueueSearch = RightNow.Widgets.extend({
    constructor: function(){
        this._widgetElement = this.Y.one(this.baseSelector);
        if(this._widgetElement){
            RightNow.Event.subscribe("evt_chatStateChangeResponse", this._onChatStateChangeResponse, this);
        }
    },

    /**
     * Listener for Chat State Change notifications.
     * @param type string Event name
     * @param args object Event arguments
     */
    _onChatStateChangeResponse: function(type, args){
        var eventObject = args[0];

        //show or hide the widget
        switch(eventObject.data.currentState)
        {
            case RightNow.Chat.Model.ChatState.RECONNECTING:
                return;
            case RightNow.Chat.Model.ChatState.SEARCHING:
            case RightNow.Chat.Model.ChatState.REQUEUED:
            case RightNow.Chat.Model.ChatState.DEQUEUED:
            {
                this._widgetElement.removeClass("rn_ScreenReaderOnly");
                break;
            }
            case RightNow.Chat.Model.ChatState.CANCELLED:
            {
                if(eventObject.data.reason == 'FAIL_NO_AGENTS_AVAIL' ||
                   eventObject.data.reason == 'QUEUE_TIMEOUT')
                    this._widgetElement.removeClass("rn_ScreenReaderOnly");
                else
                    this._widgetElement.addClass("rn_ScreenReaderOnly");
                break;
            }
            default:
            {
                this._widgetElement.addClass("rn_ScreenReaderOnly");
                break;
            }
        }
    }
});
