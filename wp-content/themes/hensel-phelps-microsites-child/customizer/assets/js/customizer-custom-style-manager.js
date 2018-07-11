(function (root, CP_Customizer, $) {

    var currentPageStyles = {};
    var styleEL = $("");
    var mod = null;

    var mediaMap = {
        "mobile": "@media screen and (max-width:767)",
        "tablet": "@media screen and (min-width:768)",
        "desktop": "@media screen and (min-width:1024)",
        "nomedia": false
    };

    var outputOrder = ['nomedia', 'mobile', 'tablet', 'desktop'];

    function ope_sprintf_style_array(data, media) {
        var style = "";


        for (var selector in data) {
            var props = data[selector];
            var propsText = "";

            for (var prop in props) {
                var value = props[prop];
                propsText += "\t" + prop + ":" + value + ";\n";
            }

            style += selector + "{\n" + propsText + "\n}";
        }
        if (media) {
            style = media + "{\n" + style + "\n}";
        }

        return style + "\n\n";
    }

    function setModAndUpdate() {
        CP_Customizer.setMod(mod, _.clone(currentPageStyles), 'postMessage');

        var style = "";

        for (var i = 0; i < outputOrder.length; i++) {
            var media = outputOrder[i];
            var mediaQuery = mediaMap[media];
            style += ope_sprintf_style_array(currentPageStyles[media], mediaQuery);
        }
        styleEL.text(style);
    }


    CP_Customizer.on(CP_Customizer.events.PREVIEW_LOADED, function () {
        currentPageStyles = CP_Customizer.preview.data('content_style');
        mod = 'ope_pro_custom_style_' + CP_Customizer.preview.data('pageID');
        styleEL = CP_Customizer.preview.find('#ope-pro-page-custom-styles');
    });


    CP_Customizer.contentStyle = {
        getStyle: function (selector, media) {

            if (!selector) {
                return {};
            }

            media = media || 'nomedia';
            return currentPageStyles[media][selector] || {};
        },

        removeSelector: function (selector, media, noUpdate) {
            media = media || 'nomedia';

            if (media === "all") {
                for (var m in currentPageStyles) {
                    this.removeSelector(selector, m, true);
                }
                setModAndUpdate();
                return;
            }

            if (currentPageStyles[media]) {
                if (currentPageStyles[media][selector]) {
                    delete currentPageStyles[media][selector];
                } else {
                    for (var s in currentPageStyles[media]) {
                        if (s.match(selector)) {
                            delete currentPageStyles[media][s];
                        }
                    }
                }
            }

            if (!noUpdate) {

                setModAndUpdate();
            }

        },

        getProp: function (selector, pseudo, prop, defaultValue, media) {
            pseudo = (pseudo || "").trim();
            selector = selector + pseudo;

            var style = this.getStyle(selector, media);
            return (style[prop] || "").toLowerCase().replace('!important', '').trim() || defaultValue;

        },

        getNodeProp: function (node, selector, pseudo, prop, media) {

            if (!node || node.length === 0) {
                return '';
            }

            node = CP_Customizer.preview.jQuery(node)[0];
            var defaultValue = CP_Customizer.preview.frame().getComputedStyle(node, pseudo).getPropertyValue(prop);
            return this.getProp(selector, pseudo, prop, defaultValue, media)
        },


        getNodeProps: function (node, selector, pseudo, props, media) {
            var result = {},
                manager = this;

            _.each(props, function (prop) {
                result[prop] = manager.getNodeProp(node, selector, pseudo, prop, media);
            });

            return result;
        },

        isImportant: function (selector, pseudo, prop, media) {
            pseudo = (pseudo || "").trim();
            selector = selector + pseudo;

            var style = this.getStyle(selector, media);
            var value = style[prop] || "";
            return value.toLowerCase().indexOf('!important') !== -1;

        },

        setProp: function (selector, pseudo, prop, value, media, handeledModUpdate) {
            media = media || 'nomedia';
            pseudo = (pseudo || "").trim();

            pseudo = (pseudo || "").trim();
            selector = selector + pseudo;

            if (!currentPageStyles[media]) {
                currentPageStyles[media] = {};
            }

            if (_.isArray(currentPageStyles[media])) {
                currentPageStyles[media] = _.extend({}, currentPageStyles[media]);
            }

            if (!currentPageStyles[media][selector]) {
                currentPageStyles[media][selector] = {};
            }

            currentPageStyles[media][selector][prop] = value;

            if (!handeledModUpdate) {
                setModAndUpdate();
            }
        },

        removeProp: function (selector, pseudo, prop, media) {
            media = media || 'nomedia';

            pseudo = (pseudo || "").trim();
            selector = selector + pseudo;

            if (currentPageStyles[media]) {
                if (currentPageStyles[media][selector]) {
                    if (currentPageStyles[media][selector][prop]) {
                        delete currentPageStyles[media][selector][prop];
                    }
                }
            }


            setModAndUpdate();
        },

        setProps: function (selector, pseudo, props, media) {
            for (var prop in props) {
                this.setProp(selector, prop, props[prop], pseudo, media, true);
            }

            setModAndUpdate();
        },


        recompileScssStyle: function () {
            var settings = CP_Customizer.options('scss_settings', {});
            var vars = {};

            for (var i = 0; i < settings.length; i++) {
                var setting = settings[i];
                var setting_vars = CP_Customizer.hooks.applyFilters('scss_setting_vars_' + setting, {});

                if (_.isEmpty(setting_vars)) {
                    setting_vars = CP_Customizer.hooks.applyFilters('scss_setting_vars', {}, setting);
                }

                vars = _.extend(_.clone(vars), _.clone(setting_vars));
            }

            var data = CP_Customizer.preview.data('scss', {});

            vars = _.extend(_.clone(data.vars), _.clone(vars));
            data.vars = vars;

            var request = CP_Customizer.IO.post('compiled_style_preview', {
                data: data
            });

            request.done(function (content) {
                CP_Customizer.preview.find('#ope-compiled-css').text(content);
            });

        }
    };


})(window, CP_Customizer, jQuery);
