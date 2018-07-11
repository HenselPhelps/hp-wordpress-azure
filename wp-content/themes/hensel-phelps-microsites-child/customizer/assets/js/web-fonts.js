(function(root, CP_Customizer, $) {
    CP_Customizer.addModule(function(CP_Customizer) {

        function openWebFontsDialog(webFonts, activeFont, callback) {
            var popupContainer = $('#webfonts-popup-template');
            var fontsIframe = $('#cp-webfonts-iframe');

            jQuery('#cp-webfonts-iframe').off().on("load", function() {
                if (activeFont) {
                    this.contentWindow.postMessage({
                        fonts: [activeFont],
                        edit: true
                    }, "*");
                } else {
                    this.contentWindow.postMessage({
                        fonts: webFonts
                    }, "*");
                }
            })

            popupContainer.find('[id="cp-item-ok"]').off().click(function() {
                var fontsWindow = fontsIframe[0].contentWindow;
                var newFont = fontsWindow.getFont();
                if (activeFont) {
                    activeFont.weights = newFont.weights;
                    callback(activeFont);
                } else {
                    callback(newFont);
                }
                CP_Customizer.closePopUps();
             });

            popupContainer.find('[id="cp-item-cancel"]').off().click(function () {
                CP_Customizer.closePopUps();
            });

            jQuery('#cp-webfonts-iframe').attr("src", cpWebFonts.url);
            CP_Customizer.popUp('Manage web fonts', "webfonts-popup-template",{});
        }

        CP_Customizer.openWebFontsDialog = openWebFontsDialog;
        

        CP_Customizer.hooks.addFilter('tinymce_google_fonts', function (fonts) {
            var definedFonts = CP_Customizer.wpApi('one_page_express_web_fonts').get();
            if (_.isString(definedFonts)) {
                definedFonts = JSON.parse(definedFonts);
            }

            for (var i = 0; i < definedFonts.length; i++) {
                fonts[definedFonts[i].family] = definedFonts[i].family + ",arial,helvetica,sans-serif";
            }
            return fonts;

        });
    });
})(window, CP_Customizer, jQuery);
