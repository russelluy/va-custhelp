(function() {
    // This was inspired by code at http://www.nczonline.net/blog/2009/06/23/loading-javascript-without-blocking/
    var _loadScript = function(url, context, callback) {
        var script = document.createElement("script");
        script.type = "text/javascript";

        if (script.readyState) {
            // This case is for IE
            /**@ignore*/
            script.onreadystatechange = function() {
                if (script.readyState === "complete" || script.readyState === "loaded") {
                    script.onreadystatechange = null;
                    callback.call(context);
                }
            };
        }
        else {
            // This is for non-donkey browsers.
            /**@ignore*/
            script.onload = function() {
                callback.call(context);
            };
        }
        script.src = url;
        document.body.appendChild(script);
    },
    /**@inner*/
    _augmentObject = function(target, source) {
        for (var i in source) {
            if (source.hasOwnProperty(i)) {
                target[i] = source[i];
            }
        }
    };

    return {
        create: function(targetDivID, customOptions, callback) {
            _loadScript(defaultChallengeOptions.scriptUrl, this, function() {
                var customTranslations = false;
                if (defaultChallengeOptions && customOptions) {
                    customTranslations = customOptions.custom_translations;
                    if (defaultChallengeOptions.custom_translations && customTranslations) {
                        _augmentObject(defaultChallengeOptions.custom_translations, customTranslations);
                        customOptions.custom_translations = null;
                    }
                    _augmentObject(defaultChallengeOptions, customOptions);
                }
                defaultChallengeOptions.callback = function(){
                    //Add some offscreen text to improve the screen reader user experience
                    var instructionsSpan = document.getElementById("recaptcha_instructions_image");
                    if(instructionsSpan)
                        instructionsSpan.innerHTML += '<span style="position:absolute; height:1px; left:-10000px; overflow:hidden; top:auto; width:1px;">' + defaultChallengeOptions.cant_see_image + '</span>';
                    //add alt = "" to recaptcha image
                    var recaptchaImage = document.getElementById('recaptcha_image');
                    if(recaptchaImage && (recaptchaImage = recaptchaImage.getElementsByTagName("IMG"))[0]) {
                        recaptchaImage[0].setAttribute('alt', '');
                    }

                    if(callback)
                        callback.apply(this, arguments);
                };
                Recaptcha.create(defaultChallengeOptions.publicKey, targetDivID, defaultChallengeOptions);
                if (customOptions && customTranslations) {
                    customOptions.custom_translations = customTranslations;
                }
            });
        },

        getInputs: function(targetDivID) {
            var parentDiv = document.getElementById(targetDivID),
                inputs = {};
            if (parentDiv) {
                var response = document.getElementById("recaptcha_response_field"),
                    opaque = document.getElementById("recaptcha_challenge_field");
                if (response) {
                    inputs.abuse_challenge_response = response.value.replace(/^\s+|\s+$/g, "");
                }
                if (opaque) {
                    inputs.abuse_challenge_opaque = opaque.value;
                }
            }
            return inputs;
        },

        focus: function() {
            try {
                Recaptcha.focus_response_field();
            }
            catch (ex) {
                // Focus isn't that important; suppress any errors that result from Recaptcha not being ready.
            }
        },

        destroy: function() {
            try {
                Recaptcha.destroy();
            }
            catch (ex) {
                // Destroying isn't that important; suppress any errors that result from Recaptcha not being ready.
            }
        }
    };
})();
