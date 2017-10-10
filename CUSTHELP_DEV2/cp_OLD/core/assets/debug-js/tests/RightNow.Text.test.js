UnitTest.addSuite({
    type: UnitTest.Type.Framework,
    jsFiles: ['/euf/core/debug-js/RightNow.Text.js'],
    namespaces: ['RightNow.Text']
}, function(Y){
    var rightnowTextTests = new Y.Test.Suite({
        name: "RightNow.Text",
        setUp: function(){
            var testExtender = {
                Text: RightNow.Text
            };
            for(var item in this.items){
                Y.mix(this.items[item], testExtender);
            }
        }
    });

    //getSubstringAfter
    rightnowTextTests.add(new Y.Test.Case(
    {
        name: "getSubstringAfterTests",

        _should: {
            error: {
                testNumberHaystack: true,
                testObjectHaystack: true
            }
        },

        //Test Methods
        testFound: function() {
            Y.Assert.areSame(this.Text.getSubstringAfter('test string', 'test'), ' string');
            Y.Assert.areSame(this.Text.getSubstringAfter('a/b/c/d', 'b/c'), '/d');
            Y.Assert.areSame(this.Text.getSubstringAfter('foo', 'f'), 'oo');
            Y.Assert.areSame(this.Text.getSubstringAfter('a/b/c/d', 'd'), '');
        },

        testMissing: function() {
            Y.Assert.areSame(this.Text.getSubstringAfter('foo', 'bar'), false);
            Y.Assert.areSame(this.Text.getSubstringAfter('a/b/c/d', 'c/b'), false);
        },

        testNonStringNeedles: function() {
            Y.Assert.areSame(this.Text.getSubstringAfter('foo', 1), false);
            Y.Assert.areSame(this.Text.getSubstringAfter('a/b/c/d', {foo:'bar'}), false);
        },
        testNumberHaystack: function() {
            this.Text.getSubstringAfter(1, 1);
        },
        testObjectHaystack: function() {
            this.Text.getSubstringAfter({}, 1);
        }
    }));

    //getSubstringBetween
    rightnowTextTests.add(new Y.Test.Case(
    {
        name: "getSubstringBetweenTests",

        _should: {
            error: {
                testNumberSubject: true,
                testObjectSubject: true,
                testNothing: true,
                testNoMarkers: true
            }
        },

        //Test Methods
        testFound: function() {
            Y.Assert.areSame(this.Text.getSubstringBetween('banana assiduous rifle found', 'banana', 'found'), ' assiduous rifle ');
            Y.Assert.areSame(this.Text.getSubstringBetween('banana assiduous rifle', 'banana', 'found'), ' assiduous rifle');
            Y.Assert.areSame(this.Text.getSubstringBetween('http://mysite.custhelp.com/a_id/2345/banana/23', '/a_id/', '/'), '2345');
            Y.Assert.areSame(this.Text.getSubstringBetween('http://mysite.custhelp.com/posts/a24R34T5/banana/23', '/posts/', '/'), 'a24R34T5');
            Y.Assert.areSame(this.Text.getSubstringBetween('banana ', 'banana', 'found'), ' ');
            Y.Assert.areSame(this.Text.getSubstringBetween('said banana ', ' ', ' '), 'banana');
            Y.Assert.areSame(this.Text.getSubstringBetween('banana', '', 'banana'), 'banana');
            Y.Assert.areSame(this.Text.getSubstringBetween('banana', '', ''), 'banana');
            Y.Assert.areSame(this.Text.getSubstringBetween('banana first banana second', 'banana ', ' '), 'first');
        },

        testMissing: function() {
            Y.Assert.areSame(this.Text.getSubstringBetween('banana', 'what', 'dinosaur'), false);
            Y.Assert.areSame(this.Text.getSubstringBetween('help_me_find_my_name', ' ', 'help_me_find_my_name'), false);
        },

        testNonStringMarkers: function() {
            Y.Assert.areSame(this.Text.getSubstringBetween('banana', 1), 'banana');
            Y.Assert.areSame(this.Text.getSubstringBetween('banana', 1, -1), 'banana');
            Y.Assert.areSame(this.Text.getSubstringBetween('banana', -1), 'banana');
            Y.Assert.areSame(this.Text.getSubstringBetween('banana', {banana:'famous'}), 'banana');
        },
        testNumberSubject: function() {
            this.Text.getSubstringBetween(1, "banana", "win");
        },
        testObjectSubject: function() {
            this.Text.getSubstringBetween({}, "banana", "fail");
        },
        testNothing: function() {
            this.Text.getSubstringBetween();
        },
        testNoMarkers: function() {
            this.Text.getSubstringBetween("banana");
        }
    }));

    //sprintf
    rightnowTextTests.add(new Y.Test.Case(
    {
        name: "sprintfTests",

        _should: {
            error: {
                testNotEnoughArguments: true
            }
        },

        //Test Methods
        testPropertyFormatted: function() {
            Y.Assert.areSame(this.Text.sprintf('a %s string', 'simple'), 'a simple string');
            Y.Assert.areSame(this.Text.sprintf('%d plus %d', 1, 2), '1 plus 2');
            Y.Assert.areSame(this.Text.sprintf('%s and %d and a couple more %s %s %s', 'strings', 3, 'one', 'two', 'three'), 'strings and 3 and a couple more one two three');
        },

        testLiteralPercent: function() {
            Y.Assert.areSame(this.Text.sprintf('a literal %% sign'), 'a literal % sign');
            Y.Assert.areSame(this.Text.sprintf('%d %% %s', 4, 'string'), '4 % string');
        },

        testNotEnoughArguments: function() {
            this.Text.sprintf('no arguments but placeholder %s');
        },

        testNotEnoughPlaceholders: function() {
            Y.Assert.areSame(this.Text.sprintf('no placeholders', 'string'), 'no placeholders');
            Y.Assert.areSame(this.Text.sprintf('only 2 placeholders %s %s', 4, 'one', 'two'), 'only 2 placeholders 4 one');
        },

        testArgumentsWithSpaces: function() {
            Y.Assert.areSame(this.Text.sprintf('min value: %s', '1/2/1970 12:00:00'), 'min value: 1/2/1970 12:00:00');
        }
    }));

    //trimComma
    rightnowTextTests.add(new Y.Test.Case(
    {
        name: "trimCommaTests",

        _should: {
            error: {
                testArray: true,
                testObject: true,
                testNumber: true
            }
        },

        //Test Methods
        testSingleComma: function() {
            Y.Assert.areSame(this.Text.trimComma('trailing comma,'), 'trailing comma');
            Y.Assert.areSame(this.Text.trimComma(','), '');
            Y.Assert.areSame(this.Text.trimComma('one,two,'), 'one,two');
        },

        testMultipleComma: function() {
            Y.Assert.areSame(this.Text.trimComma('multiple commas,,,,,'), 'multiple commas');
            Y.Assert.areSame(this.Text.trimComma('multiple,,, commas,,,,,'), 'multiple,,, commas');
        },

        testNoComma: function() {
            Y.Assert.areSame(this.Text.trimComma('no comma'), 'no comma');
            Y.Assert.areSame(this.Text.trimComma('no trailing, comma'), 'no trailing, comma');
        },

        testArray: function() {
            this.Text.trimComma([]);
        },
        testObject: function() {
            this.Text.trimComma({});
        },
        testNumber: function() {
            this.Text.trimComma(1);
        }
    }));

    //isValidEmailAddress
    rightnowTextTests.add(new Y.Test.Case(
    {
        name: "isValidEmailAddressTests",
        setUp: function () {
            RightNow.Interface.setConfigbase(function(){return {"DE_VALID_EMAIL_PATTERN":"^(([-!#$%&'*+\/=?^~`{|}\\w]+(\\.[-!#$%&'*+\/=?^~`{|}\\w]+)*)|(\"[^\"]+\"))@[0-9A-Za-z]+(-[0-9A-Za-z]+)*(\\.[0-9A-Za-z]+(-[0-9A-Za-z]+)*)+$"};});
            RightNow.Interface.Constants.API_VALIDATION_REGEX_EMAIL = "((([-_!#$%&'*+/=?^~`{|}\\w]+(\\.[-_!#$%&'*+/=?^~`{|}\\w]+)*)|(\"[^\"]+\"))@[0-9A-Za-z]+([\\-]+[0-9A-Za-z]+)*(\\.[0-9A-Za-z]+([\\-]+[0-9A-Za-z]+)*)+[;, ]*)+";
        },

        //Test Methods
        testValidEmail: function() {
            Y.Assert.areSame(this.Text.isValidEmailAddress('eturner@rightnow.com'), true);
            Y.Assert.areSame(this.Text.isValidEmailAddress('a@b.c.d'), true);
        },

        testInvalidEmail: function() {
            Y.Assert.areSame(this.Text.isValidEmailAddress('a@b'), false);
            Y.Assert.areSame(this.Text.isValidEmailAddress('@c.com'), false);
            Y.Assert.areSame(this.Text.isValidEmailAddress(''), false);
        },

        testInvalidLength: function() {
            var looong = '';
            while(looong.length < 100)
                looong += 'a';
            Y.Assert.areSame(this.Text.isValidEmailAddress(looong), false);
            looong = '';
            while(looong.length < 72)
                looong += 'a';
            looong += '@foo.com';
            Y.Assert.areSame(this.Text.isValidEmailAddress(looong), true);
            looong = 'a' + looong;
            Y.Assert.areSame(this.Text.isValidEmailAddress(looong), false);
        }
    }));

    rightnowTextTests.add(new Y.Test.Case(
    {
        name : "isValidUrlTests",

        testValidUrls: function()
        {
            Y.Assert.isTrue(this.Text.isValidUrl("foo.com"));
            Y.Assert.isTrue(this.Text.isValidUrl("foo.com/"));
            Y.Assert.isTrue(this.Text.isValidUrl("foo.com/one/two"));
            Y.Assert.isTrue(this.Text.isValidUrl("www.foo.com"));
            Y.Assert.isTrue(this.Text.isValidUrl("ß∂ƒ´®´∑œ∑∂ß.au"));
            Y.Assert.isTrue(this.Text.isValidUrl("a.b"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://www.foo.com"));
            Y.Assert.isTrue(this.Text.isValidUrl("HTTP://WWw.fOo.COM"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://foo.bar.baz.com"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://foo.com/blah_blah_(wikipedia)"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://www.example.com/wpstyle/?p=364"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://✪df.ws/123"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://userid:password@example.com:8080"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://userid@example.com"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://foo.com/blah_(wikipedia)#cite-1"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://مثال.إالعربية"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://例子.测试"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://उदाहरण.परीक्षा/उदाहरण/परीक्षा"));
            Y.Assert.isTrue(this.Text.isValidUrl("ab://____.___"));
            Y.Assert.isTrue(this.Text.isValidUrl("google.com/~`!@#$%^&*()_-+={[}]|\;:'\"<,>.?/"));
            Y.Assert.isTrue(this.Text.isValidUrl("a9://foo.com"));
            Y.Assert.isTrue(this.Text.isValidUrl("a9://foo.com"));
            Y.Assert.isTrue(this.Text.isValidUrl("a9.+-://foo.com"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://.www.foo.bar/"));

            //IPv6 addresses
            Y.Assert.isTrue(this.Text.isValidUrl("[FEDC:BA98:7654:3210:FEDC:BA98:7654:3210]:80/index.html"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://[1080:0:0:0:8:800:200C:417a]/index.html"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://[::192.9.5.5]/ipng"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://[2010:836B:4179::836B:4179]"));
            Y.Assert.isTrue(this.Text.isValidUrl("http://[::ffff:129.144.52.38]:80/index.html"));
            Y.Assert.isTrue(this.Text.isValidUrl("[:]/index.html"));
            Y.Assert.isTrue(this.Text.isValidUrl("[::::::::::]/index.html"));
        },

        testInvalidUrls: function()
        {
            debugger;
            //Invalid parameter types
            Y.Assert.isFalse(this.Text.isValidUrl(20));
            Y.Assert.isFalse(this.Text.isValidUrl(null));
            Y.Assert.isFalse(this.Text.isValidUrl(false));
            Y.Assert.isFalse(this.Text.isValidUrl([]));

            //Protocol checks
            Y.Assert.isFalse(this.Text.isValidUrl("a://b.com"));
            Y.Assert.isFalse(this.Text.isValidUrl("9://b.com"));
            Y.Assert.isFalse(this.Text.isValidUrl("9a://b.com"));
            Y.Assert.isFalse(this.Text.isValidUrl("123://google.com/"));
            Y.Assert.isFalse(this.Text.isValidUrl("ab!@#$%^<>://b.com"));
            Y.Assert.isFalse(this.Text.isValidUrl("http://"));
            Y.Assert.isFalse(this.Text.isValidUrl("http://."));
            Y.Assert.isFalse(this.Text.isValidUrl("http://.."));

            Y.Assert.isFalse(this.Text.isValidUrl("http://#"));

            //Hostname checks
            Y.Assert.isFalse(this.Text.isValidUrl("asdf"));
            Y.Assert.isFalse(this.Text.isValidUrl("/foo.com/"));

            Y.Assert.isFalse(this.Text.isValidUrl("http:// shouldfail.com"));
            Y.Assert.isFalse(this.Text.isValidUrl("http://<helloworld>.com"));
            Y.Assert.isFalse(this.Text.isValidUrl("http://foo/bar.com"));
            Y.Assert.isFalse(this.Text.isValidUrl("asdf//google.com/"));
            Y.Assert.isFalse(this.Text.isValidUrl("http/google.com/foo?bar=af"));
            Y.Assert.isFalse(this.Text.isValidUrl("http://foo"));
            Y.Assert.isFalse(this.Text.isValidUrl("http://foo."));
            Y.Assert.isFalse(this.Text.isValidUrl("http://foo.b ar"));
            Y.Assert.isFalse(this.Text.isValidUrl("http://foo.<bar>"));
            Y.Assert.isFalse(this.Text.isValidUrl("http://foo./bar"));

            //Invalid IPv6
            Y.Assert.isFalse(this.Text.isValidUrl("FEDC:BA98:7654:3210:FEDC:BA98:7654:3210/index.html"));
            Y.Assert.isFalse(this.Text.isValidUrl("[]/index.html"));
            Y.Assert.isFalse(this.Text.isValidUrl("[zy]/index.html"));
            Y.Assert.isFalse(this.Text.isValidUrl("[ef:gh:ij:kl:mn:op:qr:st:uv:wx:yz]/index.html"));

            //Path Checks
            Y.Assert.isFalse(this.Text.isValidUrl("http://foo.bar?q=Spaces should be encoded"));
            Y.Assert.isFalse(this.Text.isValidUrl("http://foo.bar?q=\n\t\r"));
        }
    }));

    rightnowTextTests.add(new Y.Test.Case(
    {
        name : "privateMembersHiddenTest",

        testPrivateMembers: function()
        {
            UnitTest.recursiveMemberCheck(Y, RightNow.Text);
        }
    }));

    return rightnowTextTests;
});
UnitTest.run();
