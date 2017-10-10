 /* Originating Release: May 2016 */
RightNow.Widgets.SocialBookmarkLink = RightNow.Widgets.extend({
    constructor: function() {
        this.Y.Event.attach("click", this._onClick, this.baseSelector + "_Link", this);
    },
    /**
     * Executed when link is clicked on.
     * @param {Object} event Click Event
     */
    _onClick: function(event) {
        event.halt();

        var panelElement = this.Y.one(this.baseSelector + "_Panel"),
            links, lastLink;
        if (!panelElement) return;

        if (!this._panel) {
            links = panelElement.all("a");
            lastLink = links.item(links.size() - 1);
            this._panel = new this.Y.Panel({
                srcNode: panelElement,
                align: {node: this.baseSelector, points: [this.Y.WidgetPositionAlign.TC, this.Y.WidgetPositionAlign.BC]},
                render: true,
                buttons: [],
                hideOn: [{eventName: "clickoutside"}, {node: lastLink, eventName: "keydown", keyCode: RightNow.UI.KeyMap.TAB}]
            });
            RightNow.UI.show(panelElement);
        }
        else if (this._panel && this._panel.get("visible") === true) {
            this._panel.hide();
            return;
        }
        this._panel.show();
        // focus first link
        panelElement.one('a').focus();
    }
});
