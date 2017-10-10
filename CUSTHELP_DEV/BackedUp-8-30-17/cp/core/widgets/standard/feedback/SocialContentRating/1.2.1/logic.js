 /* Originating Release: May 2016 */
RightNow.Widgets.SocialContentRating = RightNow.Widgets.extend({
    constructor: function() {
        if(!this.data.js.canRate || this.data.js.alreadyRated){
            return;
        }

        this._baseNode = this.Y.one(this.baseSelector);
        this._upvoteButton = (this.data.attrs.rating_type === 'upvote') ? this._baseNode.one(".rn_UpvoteButton") : this._baseNode.all(".rn_StarVoteButton");

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
        this.userRating = parseInt(e.target.get('value'), 10) || 1;
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
                rating: this.userRating,
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
     * @param  {object} button Button on which action needs to be performed
     */
    _updateVoteButtonTitle: function(message, button) {
        button = button || this._upvoteButton;
        button.set('title', message)
                          .all('.rn_ScreenReaderOnly').setHTML(message);
    },

    /**
     * Updates the rating value UI.
     * @param  {string} totalRatingLabel Rating of the content to be displayed
     */
    _updateRating: function(totalRatingLabel) {
        this._baseNode.one(".rn_RatingValue").set('title', (this.data.js.ratingValue < 1 ? this.data.attrs.label_vote_count_singular : this.data.attrs.label_vote_count_plural)).setHTML(totalRatingLabel);
    },

    /**
     * Event handler for when a user clicks on an answer rating
     * @param {object} response Response object from ajax call
     */
    _onResponseReceived: function(response) {
        var bannerOptions = {},
            message;

        if(response && response.ratingID && !response.errors){
            message = this.data.attrs.label_upvote_thanks;
            if(this.data.attrs.rating_type === 'star') {
                this._upvoteButton.each(function(button) {
                    this._updateVoteButtonTitle(message, button);
                    if(parseInt(button.get('value'), 10) <= this.userRating) {
                        button.addClass('rn_StarVotedButton').removeClass('rn_StarVoteButton');
                    }
                }, this);
            }
            else {
               this._updateVoteButtonTitle(message);
            }
            this._updateRating(response.totalRatingLabel);
        }
        else{
            this._toggleDisabledVoteButton(false);
            if(RightNow.Ajax.indicatesSocialUserError(response)) {
                return;
            }
            if (response.errors && response.errors[0]) {
                message = response.errors[0].externalMessage;
            }
            else {
                message = RightNow.Interface.getMessage("ERROR_REQUEST_ACTION_COMPLETED_MSG");
            }

            bannerOptions.type = 'ERROR';
        }

        var activeButton = this.Y.one(this.baseSelector + ' .rn_RatingValue');
        bannerOptions.focusElement = activeButton;
        RightNow.UI.displayBanner(message, bannerOptions);
    }
});
