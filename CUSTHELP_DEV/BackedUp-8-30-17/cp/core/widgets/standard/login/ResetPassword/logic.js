 /* Originating Release: May 2016 */
RightNow.Widgets.ResetPassword = RightNow.Widgets.extend({
    constructor: function() {
        RightNow.Event.subscribe("evt_formButtonSubmitRequest", this._formSubmitButtonPushed, this);
    },

    /**
     * Handles when FormSubmitButton is clicked to indicate that this is for a password reset
     * and to add additional request data.
     */
    _formSubmitButtonPushed: function() {
        RightNow.Ajax.addRequestData('pw_reset', this.data.js.resetString, true);
        RightNow.Ajax.addRequestData('w_id', this.data.info.w_id, true);
    }
});
