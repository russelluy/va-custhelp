 /* Originating Release: May 2016 */
RightNow.Widgets.AnswerContent = RightNow.Widgets.extend({
    constructor: function() {
        if(RightNow.Url.getParameter('s') !== null) {
            var url = location.pathname.split('/s/')[0] + '#__highlight';
            if ('replaceState' in window.history) {
                history.replaceState(null, null, url);
            }
        }
    }
});