 /* Originating Release: May 2016 */
RightNow.Widgets.SocialContentRating = RightNow.Widgets.extend({
    constructor: function() {
        if(!this.data.js.canRate || this.data.js.alreadyRated){
            return;
        }

        this._baseNode = this.Y.one(this.baseSelector);
        this._upvoteButton = this._baseNode.one(".rn_UpvoteButton");

        if(this._upvoteButton){
            this._upvoteButton.on('click', this._submit, this);
        }
    },

    /**
     * Event handler for when a user is submitting a vote of a piece of content
     * @param event String event object
     */
    _submit: function(e) {
        this._toggleDisabledVoteButton(true);
        this._sendVote();
    },

    /**
     * Builds event object and fires off the ajax call for submitting a vote
     */
    _sendVote: function() {
        var eventObject = new RightNow.Event.EventObject(this, {
            data: {
                questionID: this.data.attrs.question_id,
                commentID: this.data.attrs.comment_id,
                w_id: this.data.info.w_id
            }
        });

        if(RightNow.Event.fire("evt_submitVoteRequest", eventObject)) {
            RightNow.Ajax.makeRequest(this.data.attrs.submit_vote_ajax,
                eventObject.data,
                {successHandler: this._onResponseReceived, scope: this, data: eventObject, json: true});
        }
    },

    /**
     * Toggles disabled attribute on the upvote button.
     * @param {bool} force Force button to a specific state
     */
    _toggleDisabledVoteButton: function(force) {
        this._upvoteButton.set('disabled', force);
    },

    /**
     * Updates the button's title and screen reader text.
     * @param  {string} message Message to set
     */
    _updateVoteButtonTitle: function(message) {
        this._upvoteButton.set('title', message)
                          .all('.rn_ScreenReaderOnly').setHTML(message);
    },

    /**
     * Increments the rating value UI.
     */
    _incrementRating: function() {
        // add one vote to the rating value (even though weighting and so forth may make it slightly more or less valuable in the actual tally)
        this._baseNode.all(".rn_RatingValue").setHTML(++this.data.js.ratingValue);
    },

    /**
     * Event handler for when a user clicks on an answer rating
     * @param {object} response Response object from ajax call
     */
    _onResponseReceived: function(response) {
        var bannerOptions = { focus: true }, message;

        if(response && !response.errors){
            message = this.data.attrs.label_upvote_thanks;
            this._updateVoteButtonTitle(message);
            this._incrementRating();
        }
        else{
            this._toggleDisabledVoteButton(false);
            if(RightNow.Ajax.indicatesSocialUserError(response)) {
                return;
            }
            message = RightNow.Interface.getMessage("ERROR_REQUEST_ACTION_COMPLETED_MSG");
            bannerOptions.type = 'ERROR';
        }

        var activeButton = this.Y.one(this.baseSelector + ' button');
        RightNow.UI.displayBanner(message, bannerOptions).on('blur', function () { activeButton.focus(); });
    }
});
