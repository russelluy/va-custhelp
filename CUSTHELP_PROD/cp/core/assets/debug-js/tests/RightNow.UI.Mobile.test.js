UnitTest.addSuite({
    type: UnitTest.Type.Framework,
    jsFiles: ['/euf/core/debug-js/RightNow.UI.Mobile.js'],
    namespaces: ['RightNow.UI']
}, function (Y) {

    var suite = new Y.Test.Suite({
        name: "RightNow.UI.Mobile",

        setUp: function () {
            this.origGetMessage = RightNow.Interface.getMessage;
            RightNow.Interface.getMessage = function (key) { return key; };
        },

        tearDown: function () {
            RightNow.Interface.getMessage = this.origGetMessage;
        }
    });

    suite.add(new Y.Test.Case({
        name: 'Mobile message dialog behavior',

        "Message dialogs' OK button has screen reader text containing the dialog title": function () {
            RightNow.UI.Dialog.messageDialog('Electric', { title: 'Telephone'} );
            var button = Y.one('.rn_Dialog button');
            var screenReaderContent = button.one('.rn_ScreenReaderOnly');
            Y.assert(screenReaderContent);
            Y.Assert.areSame("Telephone DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG", screenReaderContent.getHTML());
            Y.Assert.isTrue(button.getHTML().indexOf('OK_LBL') > -1);
        }
    }));

    suite.add(new Y.Test.Case({
        name: 'Mobile action dialog behavior',

        "Action dialogs' OK button has screen reader text containing the dialog title": function () {
            var title = 'goodbye';
            var dialog = RightNow.UI.Dialog.actionDialog(title, Y.Node.create('<div></div>'));

            dialog.show();

            var button = Y.one('.rn_Panel button');
            var screenReaderContent = button.one('.rn_ScreenReaderOnly');

            Y.assert(screenReaderContent);
            Y.Assert.areSame(title + " DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG", screenReaderContent.getHTML());
            Y.Assert.isTrue(button.getHTML().indexOf('CLOSE_CMD') > -1);

            dialog.destroy();
        }
    }));

    return suite;
}).run();
