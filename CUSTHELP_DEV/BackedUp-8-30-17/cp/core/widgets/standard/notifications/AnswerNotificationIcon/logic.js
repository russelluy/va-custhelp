 /* Originating Release: May 2016 */
RightNow.Widgets.AnswerNotificationIcon = RightNow.Widgets.extend({
    constructor: function()
    {
        if(this.data.js.pta)
            return false;
        this._submitting = false;
        if(RightNow.Profile.isLoggedIn())
            this.Y.one(this.baseSelector + '_Trigger').on('click', this._onTriggerClick, this, null);

        //If logged in by previous invocation, go ahead and do the notification.
        if(this.data.js.autoOpen == 1)
            this._onTriggerClick();
    },

    /**
     * Event handler when user clicks our trigger element.
     * @param type {String} Event name
     * @param args {Object} Event arguments
     */
    _onTriggerClick: function(type, args)
    {
        if(!this._submitting)
        {
            this._submitting = true;
            this._createNotification();
        }
        return false;
    },

    /**
     * Packages and fires event to create notification
     */
    _createNotification: function()
    {
        var eventObject = new RightNow.Event.EventObject(this, {data: {filter_type: 'answer', id: this.data.js.answerID, cid: this.data.js.contactID}});
        if (RightNow.Event.fire('evt_answerNotificationUpdateRequest', eventObject)) {
            RightNow.Ajax.makeRequest(this.data.attrs.add_or_renew_notification_ajax, eventObject.data, {
                successHandler: this._onNotificationResponse, scope: this, data: eventObject, json: true
            });
        }
    },

    /**
     * Event handler for when notification update event is received from server.
     * @param response {mixed}
     * @param originalEventObj {Object}
     */
    _onNotificationResponse: function(response, originalEventObj)
    {
        if (RightNow.Event.fire('evt_answerNotificationResponse', {data: originalEventObj, response: response})) {
            var body = this.Y.Node.create('<div></div>').addClass("rn_AnswerNotificationStatusDialog"),
                title,
                message;
            if(response.error) {
                title = RightNow.Interface.getMessage('NOTIFY_REQUEST_FAILED_HDG');
                body.set('innerHTML', RightNow.Interface.getMessage('NOTIFY_SUBMIT_FAILED_MSG'));
            }
            else {
                if (response.action === 'renew') {
                    title = RightNow.Interface.getMessage('YOUR_ANSWER_NOTIFICATION_LBL');
                    message = RightNow.Interface.getMessage('YOU_ARE_ALREADY_NOTIFIED_ANSWER_MSG');
                }
                else {
                    title = RightNow.Interface.getMessage('NOTIFY_REQUEST_SUCCESS_HDG');
                    message = RightNow.Interface.getMessage('NOTIFY_SUBMIT_SUCCESS_MSG');
                }
                body.set('innerHTML', message + '<br/><br/><a href="' +
                         this.data.attrs.notifications_url + '">' +
                         this.data.attrs.label_notification_link + "</a>");
            }

            var confirmDialog = RightNow.UI.Dialog.actionDialog(title, body);
            confirmDialog.show();
            this._submitting = false;
            return false;
        }
    }
});
