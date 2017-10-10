UnitTest.addSuite({
    type: UnitTest.Type.Framework,
    jsFiles: ['/euf/core/debug-js/RightNow.UI.js'],
    namespaces: ['RightNow.UI']
}, function(Y){
    var rightnowUITests = new Y.Test.Suite("RightNow.UI");

    rightnowUITests.add(new Y.Test.Case(
    {
        name : "accessibilityFunctions",
        testPrepareVirtualBufferUpdateTrigger: function()
        {
            var trigger = document.getElementById("rn_VirtualBufferUpdateTrigger");
            Y.Assert.isObject(trigger);
            Y.Assert.areSame(trigger.name, "rn_VirtualBufferUpdateTrigger");
            Y.Assert.areSame(trigger.tagName.toLowerCase(), "input");
            Y.Assert.areSame(trigger.type, "hidden");

            Y.Assert.areSame(trigger.value, "1");
            var paragraph = trigger.parentNode;
            Y.Assert.areSame(paragraph, document.body.getElementsByTagName("P")[0]);
            Y.Assert.areSame(paragraph.tagName.toLowerCase(), "p");
            Y.Assert.areSame(paragraph.style.display, "inline");

            if(trigger.getAttribute('value') !== null)
            {
                RightNow.UI.updateVirtualBuffer();
                Y.Assert.areSame(trigger.getAttribute('value'), "0");
                RightNow.UI.updateVirtualBuffer();
                Y.Assert.areSame(trigger.getAttribute('value'), "1");
            }
            //Clean up DOM
            paragraph.parentNode.removeChild(paragraph);
        },

        testAriaHideFrames: function()
        {
            var historyIframe = document.createElement("iframe");
            historyIframe.id = "rn_History_Iframe";
            document.body.appendChild(historyIframe);

            var yuiMonitor = document.createElement("div");
            yuiMonitor.id = "_yuiResizeMonitor";
            document.body.appendChild(yuiMonitor);

            //must wait to test because ariaHideFrames does this exact same thing
            Y.on("available", function() {
                Y.Assert.areSame("presentation", historyIframe.getAttribute("role"));
                Y.Assert.areSame(-1, historyIframe.tabIndex);
                Y.Assert.areSame("presentation", yuiMonitor.getAttribute("role"));
                Y.Assert.areSame(-1, yuiMonitor.tabIndex);
            }, "#rn_History_Iframe");

            //Clean up DOM
            document.body.removeChild(historyIframe);
            document.body.removeChild(yuiMonitor);
            delete RightNow.Interface;
        }
    }));

    rightnowUITests.add(new Y.Test.Case(
    {
        name : "uiManipulationFunctions",

        testChangeChildCssClass: function()
        {
            var nodeTree = Y.Node.create('<div id="parent1">\
                                            <div id="child1" class="firstClass">\
                                                <div id="subchild1" ></div>\
                                                <div id="subchild2" class="firstClass"></div>\
                                            </div>\
                                            <div id="child2"></div>\
                                          </div>');

            Y.one(document.body).append(nodeTree);
            RightNow.UI.changeChildCssClass(nodeTree.getDOMNode(), "customClass");

            Y.Assert.areSame(Y.one('#parent1').get('className'), "");
            Y.Assert.areSame(Y.one('#child1').get('className'), "firstClass customClass");
            Y.Assert.areSame(Y.one('#subchild1').get('className'), "");
            Y.Assert.areSame(Y.one('#subchild2').get('className'), "firstClass customClass");
            Y.Assert.areSame(Y.one('#child2').get('className'), "");

            nodeTree.remove();
        },

        testFindParentForm: function()
        {
            var nodeTree = Y.Node.create('<form id="form">\
                                            <div id="parent">\
                                                <div id="child1">\
                                                    <div id="subchild"></div>\
                                                </div>\
                                                <div id="child2"></div>\
                                            </div>\
                                          </form>');

            Y.one(document.body).append(nodeTree);
            Y.Assert.areSame("form", RightNow.UI.findParentForm("subchild"));
            Y.Assert.areSame("form", RightNow.UI.findParentForm("form"));

            Y.one('#form').set('id', '');
            Y.Assert.areSame(null, RightNow.UI.findParentForm("subchild"));

            nodeTree.remove();
        },

        testGetInputFieldByColumnName: function()
        {
            var nodeTree = Y.Node.create('<form id="inputForm">\
                                            <input name="email"/>\
                                            <input name="name"/>\
                                            <input name="org"/>\
                                            <input name="custom"/>\
                                          </form>');

            Y.one(document.body).append(nodeTree);
            var form = Y.one('#inputForm').getDOMNode();

            Y.Assert.areSame(RightNow.UI.getInputFieldByColumnName("email", form), 0);
            Y.Assert.areSame(RightNow.UI.getInputFieldByColumnName("name", form), 1);
            Y.Assert.areSame(RightNow.UI.getInputFieldByColumnName("org", form), 2);
            Y.Assert.areSame(RightNow.UI.getInputFieldByColumnName("custom", form), 3);
            Y.Assert.areSame(RightNow.UI.getInputFieldByColumnName("email", "inputForm"), 0);
            Y.Assert.areSame(RightNow.UI.getInputFieldByColumnName("name", "inputForm"), 1);
            Y.Assert.areSame(RightNow.UI.getInputFieldByColumnName("org", "inputForm"), 2);
            Y.Assert.areSame(RightNow.UI.getInputFieldByColumnName("custom", "inputForm"), 3);
            Y.Assert.areSame(RightNow.UI.getInputFieldByColumnName("void", "inputForm"), null);

            nodeTree.remove();
        },

        testToggleVisibilityAndText: function()
        {
            var element = Y.Node.create('<div id="hideShowBlock" style="display:block"></div>'),
                link = Y.Node.create('<a id="hideShowText"></a>');

            Y.one(document.body).append(element);
            Y.one(document.body).append(link);

            RightNow.UI.toggleVisibilityAndText("hideShowBlock", "hideShowText", "basic", "advanced");
            Y.Assert.areSame(link.get('innerHTML'), "advanced");
            Y.Assert.areSame(element.getStyle('display'), "none");

            RightNow.UI.toggleVisibilityAndText("hideShowBlock", "hideShowText", "basic", "advanced");
            Y.Assert.areSame(link.get('innerHTML'), "basic");
            Y.Assert.areSame(element.getStyle('display'), "block");

            element.remove();
            link.remove();
        },

        assertHidden: function(instance) {
            Y.Assert.isTrue(instance.hasClass('rn_Hidden'), instance.toString());
        },
        assertVisible: function(instance) {
            Y.Assert.isFalse(instance.hasClass('rn_Hidden'), instance.toString());
        },
        testHideAndShow: function()
        {
            var list = Y.Node.create('<ul>'),
                body = Y.one(document.body),
                items = [];
            for (var i = 0, id; i < 3; i++) {
                id = 'li' + i;
                items.push(id);
                list.append('<li id="' + id + '">Item ' + i + '</li>');
            }
            body.append(list);

            var item0 = Y.one('#' + items[0]),
                item1 = Y.one('#' + items[1]),
                item2 = Y.one('#' + items[2]);

            // single element without leading '#'
            RightNow.UI.hide(items[0]);
            this.assertHidden(item0);
            this.assertVisible(item1);
            this.assertVisible(item2);

            // array of elements
            RightNow.UI.show(items);
            this.assertVisible(item0);
            this.assertVisible(item1);
            this.assertVisible(item2);

            // single element with leading '#'
            RightNow.UI.hide('#' + items[1]);
            this.assertVisible(item0);
            this.assertHidden(item1);
            this.assertVisible(item2);

            //// Node instance and DOM element
            RightNow.UI.show(items);
            RightNow.UI.hide([Y.one('#' + items[0]), document.getElementById(items[1])]);
            this.assertHidden(item0);
            this.assertHidden(item1);
            this.assertVisible(item2);

            // falsey values (should be a no-op)
            RightNow.UI.hide();
            RightNow.UI.hide(false);
            RightNow.UI.hide(null);
            RightNow.UI.hide([false, null, '']);

            // String value (should not throw an error, and be a no-op)
            RightNow.UI.hide('whatever');

            body.removeChild(list);
        }
    }));

    rightnowUITests.add(new Y.Test.Case(
    {
        name : "formNamespaceDefaults",

        testFormVariableDefaults: function()
        {
            Y.Assert.areSame(RightNow.UI.Form.currentProduct, 0);
            Y.Assert.areSame(RightNow.UI.Form.logoutInProgress, false);
            Y.Assert.areSame(RightNow.UI.Form.smartAssistant, null);
            Y.Assert.areSame(RightNow.UI.Form.smartAssistantToken, null);
        }
    }));

    rightnowUITests.add(new Y.Test.Case(
    {
        name : "privateMembersHiddenTest",

        testPrivateMembers: function()
        {
            UnitTest.recursiveMemberCheck(RightNow.UI);
        }
    }));

    return rightnowUITests;
});
UnitTest.run();
