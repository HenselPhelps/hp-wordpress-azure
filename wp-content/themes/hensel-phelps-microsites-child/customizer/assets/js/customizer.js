(function (root, CP_Customizer, $) {

    CP_Customizer.addModule(function (CP_Customizer) {

        CP_Customizer.IS_PRO = true;

        CP_Customizer.hooks.addFilter('tinymce_google_fonts', function (fonts) {
            var generalFont = CP_Customizer.wpApi('general_site_typography').get()['font-family'];

            fonts[generalFont] = generalFont + ",arial,helvetica,sans-serif";

            return fonts;

        });

        CP_Customizer.hooks.addAction('text_element_clicked', function ($node) {
            root.CP_Customizer.preview.showTextElementCUI($node);
        });


        // video link popup
        CP_Customizer.hooks.addFilter('container_data_element', function (result, $elem) {

            if (!$elem.is('i.fa')) {
                return result;
            }

            if (!$elem.parent().is('a')) {
                return result;
            }

            if ($elem.parent().is('[data-video-lightbox]')) {
                result[0].label = "Video Popup Button";
                result[0].canHide = false;
                result[0].value.target = false;
            }

            return result;
        });

        CP_Customizer.hooks.addFilter('decorable_elements_containers', function (selectors) {

            selectors.push('.header-homepage  .header-content');

            return selectors;
        });


        CP_Customizer.hooks.addFilter('filter_cog_item_section_element', function (section, node) {
            if (node.parent().is('[data-theme]')) {
                section = node;
            }

            return section;
        });


        jQuery('body').on('change', '[data-customize-setting-link="one_page_express_header_show_text_morph_animation"]', function () {
            var value = this.checked;

            var addCurlyBraces = function () {
                if (value) {
                    var $title = CP_Customizer.preview.jQuery('.header-content h1.heading8');
                    var curlyRegexp = /[\{|\}]/;

                    if (!curlyRegexp.test($title.html())) {
                        var $title = CP_Customizer.preview.jQuery('.header-content h1.heading8');
                        var lastChild = $title[0].childNodes.item($title[0].childNodes.length - 1);
                        var text = lastChild.textContent;
                        text = text.replace(/(\w+?)$/, '{$1}');
                        lastChild.textContent = text;

                        CP_Customizer.updateState();
                    }
                }

                CP_Customizer.off(CP_Customizer.events.PREVIEW_LOADED + '.add_curly_braces'/*, addCurlyBraces*/);
            };

            CP_Customizer.on(CP_Customizer.events.PREVIEW_LOADED + '.add_curly_braces', addCurlyBraces);

        });

        // clean content style when section is removed
        CP_Customizer.hooks.addAction('before_section_remove', function ($section) {
            var selector = "^\\[data\\-id=('|\")?" + $section.attr('data-id') + '(\'|")?\\]';

            if ($section.attr('data-ovid')) {
                selector = "(" + selector + ")|(" + "^\\[data\\-ovid=('|\")?" + $section.attr('data-ovid') + '(\'|")?\\]' + ")";
            }

            var selectorRegExp = new RegExp(selector);

            CP_Customizer.contentStyle.removeSelector(selectorRegExp, "all");
        });

    });
})(window, CP_Customizer, jQuery);

