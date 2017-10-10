 /* Originating Release: May 2016 */
RightNow.Widgets.SocialUserAvatar = RightNow.Field.extend({
    overrides: {
        constructor: function() {
            this.parent();

            this.element = this.Y.one(this.baseSelector);
            if(this.avatarForm = this.element.ancestor('form')) {
                this.submitButton = this.avatarForm.one('.rn_FormSubmit button');
            }

            if (this.data.js.socialUser) {
                this._addClickHandlers();
                this.img = this.element.one('.rn_PreviewImage img');
                this.defaultImg = this.element.one('.rn_PreviewImage .rn_Default');
                this._monitorPreviewImage(this.img);

                this.parentForm().on('submit', this.onValidate, this);

                this.data.js.name = 'SocialUser.AvatarURL';
            }
            else {
                if (this.data.attrs.create_user_on_load) {
                    RightNow.Event.subscribe("evt_WidgetInstantiationComplete", function() {
                        RightNow.Event.fire("evt_userInfoRequired");
                    });
                }
                this.element.one('.rn_AddSocialUser').on('click', this._addSocialUser, this);
            }
        },

        getValue: function() {
            return this.img.hasClass('rn_Hidden') ? '' : this._getPreviewImage();
        }
    },

    /**
     * Event handler executed when form is being submitted.
     */
    onValidate: function() {
        var eo = this.createEventObject();
        RightNow.Event.fire("evt_formFieldValidationPass", eo);

        return eo;
    },

    /**
     * Labels and class names for each status.
     * @param  {String=} status Status to retrieve; defaults
     *                          to returning all statuses
     * @return {Object}        class name and message of status
     */
    getStatus: function(status) {
        this._statuses || (this._statuses = {
            loading: {
                icon:      'fa fa-spin fa fa-spinner',
                className: 'rn_LoadingStatus',
                message:   this.data.attrs.label_loading_icon_message
            },
            success: {
                icon:      'fa fa-check-square-o',
                className: 'rn_Success',
                message:   this.data.attrs.label_success_icon_message
            },
            error: {
                icon:      'fa fa-exclamation-circle',
                className: 'rn_Error',
                message:   this.data.attrs.label_error_icon_message
            }
        });

        return status ? this._statuses[status] : this._statuses;
    },

    /**
     * Toggles the disabled attribute on the submit form button, if available
     * @param  {boolean} state State to toggle the button's disabled attribute to
     */
    toggleSubmitButton: function(state) {
        if(!this.submitButton) return;

        this.submitButton.set('disabled', state);
    },

    /**
     * Add click handlers for avatar services
     */
    _addClickHandlers: function() {
        var services = {
            '.rn_DefaultOption': this._updateImageForDefault,
            '.rn_Gravatar':      this._updateImageForGravatar
        }, div;

        this.Y.Object.each(services, function(fn, id) {
            if (div = this.element.one(id)) {
                div.delegate('click', fn, 'button', this);
            }
        }, this);
    },

    /**
     * Handler for adding a social user
     */
    _addSocialUser: function(e) {
        RightNow.Event.fire("evt_userInfoRequired");
        e.halt();
    },

    /**
     * Change handler for default
     * @param  {Object} e Change event
     */
    _updateImageForDefault: function(e) {
        this._showPreviewImage(false);
        this._displayStatusForInput('loading', e.target);
        this._removeAllStatusIcons('rn_Success', 'rn_Error');
        this._replaceLoadingWithStatus('success');
        this._removeCurrent();
    },

    /**
     * Change handler for gravatar
     * @param  {Object} e Change event
     */
    _updateImageForGravatar: function(e) {
        this.toggleSubmitButton(true);
        this._displayStatusForInput('loading', e.target);
        this._refreshPreviewImage(this._getImageUrlForService('gravatar', this.data.js.email.hash));
    },

    /**
     * Click handler for preview buttons.
     * @param  {Object} e Click event
     */
    _previewImageForSocialService: function(e) {
        this._updateImageForInput(e.target.ancestor().one('input'), true);
    },

    /**
     * Updates the preview image for the given input's value and data-service values.
     * @param  {Object} input               Y.Node input element
     * @param  {Boolean=} displayStatusIcon Whether to display a loading icon
     *                                      for the transaction
     */
    _updateImageForInput: function(input, displayStatusIcon) {
        var username = this.Y.Lang.trim(input.get('value')),
            service = input.getAttribute('data-service');

        if (!username) {
            return this._displayStatusForInput('error', input);
        }

        this.toggleSubmitButton(true);
        if (displayStatusIcon) {
            this._displayStatusForInput('loading', input);
        }

        this._refreshPreviewImage(this._getImageUrlForService(service, username));
    },

    /**
     * Inserts a loading status icon after the
     * specified element. If the element already
     * has a status element, then the status element
     * is removed.
     * @param {String} status Status to display
     * @param  {Object} forElement Y.Node
     */
    _displayStatusForInput: function(status, forElement) {
        var currentIcon = forElement.next('.rn_StatusIcon');
        if (currentIcon) {
            currentIcon.remove();
        }
        forElement.insert(this._renderStatusView(status), 'after');
    },

    /**
     * Replaces all currently-loading status icons with
     * the designated status.
     * @param  {string} status Either error or success
     */
    _replaceLoadingWithStatus: function(status) {
        this.element.all('.rn_LoadingStatus').each(function(node){
            if (node.hasClass('rn_Permanent')) {
                node.replaceClass('rn_LoadingStatus', this.getStatus(status).className);
            }
            else {
                node.replace(this.Y.Node.create(this._renderStatusView(status)));
            }
        }, this);
    },

    /**
     * Replaces all icons with the specified status.
     * @param  {string} status error or success or loading
     */
    _replaceAllWithStatus: function(status) {
        this._removeAllStatusIcons('rn_Success', 'rn_Error');
        this._replaceLoadingWithStatus(status);
    },

    /**
     * Removes all status icons or all status icons designated
     * by the specified class names
     * @param {...String} classes Status icons with the classnames to remove.
     *                            If not specified, all status icons are removed.
     *                            If a status icon has a rn_Permanent class, then the
     *                            specified classes are removed.
     */
    _removeAllStatusIcons: function() {
        var classes = arguments.length ? Array.prototype.slice.call(arguments) : ['rn_StatusIcon'],
            YArray = this.Y.Array;

        this.element.all('.' + classes.join(',.')).each(function(node) {
            if (!node.hasClass('rn_Permanent')) {
                node.remove();
            }
            else {
                YArray.each(classes, node.removeClass, node);
            }
        });
    },

    /**
     * Removes the current avatar highlighting and show both social service inputs
     */
    _removeCurrent: function() {
        this.element.all('.rn_ChosenAvatar').each(function(node) {
            RightNow.UI.hide(node.one('.rn_CurrentSocialAvatar'));
            RightNow.UI.show(node.one('.rn_NewSocialInput'));
            node.removeClass('rn_ChosenAvatar');
        });
    },

    /**
     * Renders a status icon element for the given status.
     * @param  {String} forStatus loading, success, error
     * @return {String}           Rendered view
     */
    _renderStatusView: function(forStatus) {
        this._statusView || (this._statusView = new EJS({ text: this.getStatic().templates.statusIcon }));

        return this._statusView.render(this.getStatus(forStatus));
    },

    /**
     * Sets the preview image's `src` attribute to the given url.
     * @param  {String} url image src
     */
    _refreshPreviewImage: function(url) {
        if (url === this.img.getAttribute('src')) {
            // load/error callback is expected to be async. So wait a tick.
            return this.Y.Lang.later(100, this, this._onPreviewImageLoaded, [{ target: this.img }, true]);
        }

        this.img.setAttribute('src', url);
    },

    /**
     * Callback for the image's load event.
     * @param  {Object} e load event
     * @param {Boolean} displaySuccess Whether to forcefully display the success status even if
     *                                 a new image isn't copied to the `data-fallback` attribute
     */
    _onPreviewImageLoaded: function(e, displaySuccess) {
        this.toggleSubmitButton(false);

        if (this._copyElementAttribute(e.target, 'src', 'data-fallback') || displaySuccess) {
            this._replaceAllWithStatus('success');
            this._showPreviewImage(true);
            this._removeCurrent();
        }
    },

    /**
     * Callback for the image's error event.
     * Sets the `src` attribute back to the last successfully-loaded
     * url set in the `data-fallback` attribute.
     * @param  {Object} e error event
     */
    _onPreviewImageError: function(e) {
        this.toggleSubmitButton(false);
        this._copyElementAttribute(e.target, 'data-fallback', 'src');
        this._replaceLoadingWithStatus('error');

        if (!this.img.getAttribute('data-fallback')) {
            this._showPreviewImage(false);
        }
    },

    /**
     * Sets up event listeners on the image.
     * @param  {Object} img Y.Node image
     */
    _monitorPreviewImage: function(img) {
        this._copyElementAttribute(img, 'src', 'data-fallback');

        img.on('load', this._onPreviewImageLoaded, this);
        img.on('error',this._onPreviewImageError, this);
    },

    /**
     * Toggle the default and preview images
     * @param {Boolean} turnOn Whether to turn on or off the preview image
     */
    _showPreviewImage: function(turnOn) {
        if (turnOn) {
            RightNow.UI.show(this.img);
            RightNow.UI.hide(this.defaultImg);
        }
        else {
            RightNow.UI.hide(this.img);
            RightNow.UI.show(this.defaultImg);
        }
    },

    /**
     * Copies an attribute value from one attribute to another.
     * @param  {Object} el  Y.Node
     * @param  {String} from From attribute
     * @param  {String} to   To attribute
     * @return {Boolean} False if the values are already the same
     *                         and a copy didn't happen
     */
    _copyElementAttribute: function(el, from, to) {
        var fromValue = el.getAttribute(from),
            toValue = el.getAttribute(to);

        if (fromValue === toValue) return false;

        return !!el.setAttribute(to, fromValue);
    },

    /**
     * Returns the preview image's `src` attribute.
     * @return {String} src
     */
    _getPreviewImage: function() {
        // Does a fresh node query to avoid caching on `this.img`.
        return this.element.one('.rn_PreviewImage img').get('src');
    },

    /**
     * Retrieves the image url for the specified service.
     * @param  {String} service  One of the supported services
     * @param  {String} username The user-entered username
     * @return {String}          Url
     */
    _getImageUrlForService: function(service, username) {
        if (username.charAt(0) === '@') {
            // We don't want to get into the business of regex-validating other services' username
            // requirements. However, the @username convention is so common that we might as well handle it.
            username = username.slice(1);
        }

        return RightNow.Text.sprintf(this.getStatic().SOCIAL_PROFILE_URLS[service.toUpperCase()], username);
    }
}, {
    SOCIAL_PROFILE_URLS: {
        // 256x256
        GRAVATAR: 'https://www.gravatar.com/avatar/%s?d=404&s=256'
    }
});
