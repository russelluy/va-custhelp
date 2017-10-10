UnitTest.addSuite({
    type: UnitTest.Type.Framework,
    jsFiles: [
        '/euf/core/debug-js/RightNow.Event.js',
        '/euf/core/debug-js/modules/chat/RightNow.Chat.Communicator.js',
        '/euf/core/debug-js/modules/chat/RightNow.Chat.Controller.js',
        '/euf/core/debug-js/modules/chat/RightNow.Chat.Model.js',
        '/euf/core/debug-js/modules/chat/RightNow.Chat.UI.js'
    ],
    namespaces: [
        'RightNow.Event',
        'RightNow.Chat.Communicator',
        'RightNow.Chat.Controller.ChatCommunicationsController',
        'RightNow.Chat.UI',
        'RightNow.Chat.Model',
        'RightNow.Chat.Controller'
    ]
}, function(Y) {
    var rightnowChatUITests = new Y.Test.Suite("RightNow.Chat.UI");

    rightnowChatUITests.add(new Y.Test.Case(
    {
        name: 'utilFunctions',
        testHasLeaveScreenIssues: function()
        {
            // Default case; should respond with no issues
            Y.Assert.areSame(false, RightNow.Chat.UI.Util.hasLeaveScreenIssues());

            //Only works in IE 10
            if(Y.UA.ie >= 10) {
                RightNow.Chat.UI.Util._leaveScreenIssues = undefined;
                window.ActiveXObject = undefined;
                window.innerWidth = screen.width;
                window.innerHeight = screen.height;
                Y.Assert.areSame(true, RightNow.Chat.UI.Util.hasLeaveScreenIssues());
            }
        }
    }));
    return rightnowChatUITests;
}).run();
