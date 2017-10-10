RightNow.namespace('Custom.Widgets.util.ExternalLinkModal');
Custom.Widgets.util.ExternalLinkModal = RightNow.Widgets.extend({
  /**
   * Widget constructor.
   */
  constructor: function () {
    this.Y.Event.attach("click", this._onClick, this.baseSelector + "_Link", this);
    this._linkUrl = this.data.attrs.target_url;
  },

  /**
   * Executed when the `continue` button is clicked on.
   */
  _onExternalButtonClick: function () {
    window.open(this._linkUrl);
  },

  /**
   * Executed when link is clicked on.
   * @param {Object} event Click Event  
   */
  _onClick: function (event) {
    event.halt();
    var modalContainer = "#rn_" + this.instanceID + "_leavingSiteModal";
    var panelElement = this.Y.one(modalContainer),
      externalBtn,
      closeBtns;

    if (!panelElement) return;

    if (!this._panel) {
      closeBtns = panelElement.all(".yui3-button-close");
      externalBtn = panelElement.one(".ExternalLink");
      this.Y.Event.attach("click", this._onExternalButtonClick, externalBtn, this);

      this._panel = new this.Y.Panel({
        srcNode: panelElement,
        width: '320px',
        centered: true,
        visible: false,
        draggable: false,
        constraintoviewport: true,
        zIndex: 5,
        modal: true,
        render: true,
        buttons: [],
        hideOn: [
          { eventName: "clickoutside" },
          {
            node: closeBtns,
            eventName: "keydown",
            keyCode: RightNow.UI.KeyMap.TAB
          },
          { node: closeBtns, eventName: "click" }
        ]
      });

      RightNow.UI.show(panelElement);

    } else if (this._panel && this._panel.get("visible") === true) {
      this._panel.hide();
      return;
    }

    this._panel.show();

    if (panelElement.one('h1')) {
      panelElement.one('h1').focus();
    }
  }
});