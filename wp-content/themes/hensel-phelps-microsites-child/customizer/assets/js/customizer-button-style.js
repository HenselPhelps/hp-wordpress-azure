(function (root, CP_Customizer, $) {

    // this should be moved in globalConfigs in the future
    var buttonSizes = {
        "normal": "",
        "small": "small",
        "big": "big"
    };

    var buttonColors = {};

    var oldColors = {
        "transparent": "transparent",
        "blue": "color1",
        "green": "color2",
        "yellow": "color3",
        "orange": "color5",
        "purple": "color4"
    };

    var buttonTextColors = {
        "default": "",
        "white text": "white-text",
        "dark text": "dark-text"
    };

    var buttonShadow = {
        "Default": "",
        "no shadow": "no-shadow",
        "show shadow": "force-shadow",
    };

    function buttonColorsList() {
        var buttonColors = {
            "default": "",
            "transparent ( link button )": "transparent"
        };

        var colors = CP_Customizer.getColorsObj(true);
        _.each(colors, function (color, name) {
            buttonColors[name] = name;
        })

        return buttonColors;
    }





    var currentColorRegexp;

    var oldCurrentColorRegexp = new RegExp(jQuery.map(oldColors, function (value, index) {
        return index
    }).filter(function (item) {
        return item.length
    }).join("|"), 'ig');

    var currentTextColorRegexp = new RegExp(jQuery.map(buttonTextColors, function (value, index) {
        return value
    }).filter(function (item) {
        return item.length
    }).join("|"), 'ig');

    var currentShadowRegexp = new RegExp(jQuery.map(buttonShadow, function (value, index) {
        return value
    }).filter(function (item) {
        return item.length
    }).join("|"), 'ig');


    var buttonSizesRegexp = new RegExp(jQuery.map(buttonSizes, function (value, index) {
        return value
    }).filter(function (item) {
        return item.length
    }).join("|"), 'ig');

    // link with images
    CP_Customizer.hooks.addFilter('container_data_element', function (result, $elem) {
        var _class = CP_Customizer.preview.cleanNode($elem.clone()).attr('class') || "";

        buttonColors = buttonColorsList();
        currentColorRegexp = /(transparent|(color\d+))/ig;

        if ($elem.is('a') && _class && ($elem.is('.button') || $elem.is('[class*=button]'))) {
            var color = _class.match(currentColorRegexp) ? _class.match(currentColorRegexp)[0] : "";
            if (!color) {
                color = _class.match(oldCurrentColorRegexp) ? _class.match(oldCurrentColorRegexp)[0] : "";
            }
            var size = _class.match(buttonSizesRegexp) ? _class.match(buttonSizesRegexp)[0] : "";
            var textColor = _class.match(currentTextColorRegexp) ? _class.match(currentTextColorRegexp)[0] : "";
            var shadow = _class.match(currentShadowRegexp) ? _class.match(currentShadowRegexp)[0] : "";

            if (oldColors[color]) {
                color = oldColors[color]
            }

            color = CP_Customizer.getColorValue(color);

            if (!$elem.is('.button')) {
                $elem.addClass('button');
            }

            if ($elem.is('.button')) {
                result.push({
                    'label': "Button Size",
                    "type": "select",
                    "choices": buttonSizes,
                    "name": "button_size_option",
                    "classes": "button-pro-option",
                    "value": size
                });

                result.push({
                    'label': "Button Shadow",
                    "type": "select",
                    "choices": buttonShadow,
                    "name": "button_shadow_option",
                    "classes": "button-pro-option",
                    "value": shadow
                });

                result.push({
                    'label': "Button Color",
                    "type": "colorselect-transparent",
                    "choices": buttonColors,
                    "name": "button_color_option",
                    "classes": "button-pro-option",
                    "value": color,
                    "getValue": CP_Customizer.utils.getSpectrumColorFormated
                });

                result.push({
                    'label': "Button Text Color",
                    "type": "select",
                    "choices": buttonTextColors,
                    "name": "button_text_color_option",
                    "classes": "button-pro-option",
                    "value": textColor
                });
            }

            var icon = $elem.attr('data-icon') || "";

            if (!icon) {
                if ($elem.find('span.button-icon').length) {
                    var match = $elem.find('span.button-icon').attr('class').match(/fa\-[a-z\-]+/ig);
                    icon = ( (match || []).pop() ) || "";
                }
            }

            result.push({
                'label': "Button Icon",
                "type": "icon",
                "choices": buttonColors,
                "name": "button_icon_option",
                "canHide": true,
                value: {
                    icon: icon,
                    visible: ($elem.find('span.button-icon').length > 0)
                },
                "mediaType": "icon",
                mediaData: false
            });
        }

        return result;
    });

    CP_Customizer.hooks.addAction('container_data_element_setter', function (node, value, field) {

        if (field.name) {
            var _class = node.attr('class');
            var match = false;
            switch (field.name) {
                case "button_size_option":
                    _class = _class.replace(buttonSizesRegexp, " ");
                    match = true;
                    break;

                case "button_text_color_option":
                    _class = _class.replace(currentTextColorRegexp, " ");
                    match = true;
                    break;

                case "button_shadow_option":
                    match = true;
                    _class = _class.replace(currentShadowRegexp, " ");
                    break;

                case "button_color_option":
                    match = true;
                    _class = _class.replace(currentColorRegexp, " ").replace(oldCurrentColorRegexp, " ");

                    value = CP_Customizer.getThemeColor(value, function (value) {
                        match = false;

                        _class = _class.replace(/\s\s+/, " ").trim();
                        _class += " " + value;

                        node.attr('class', _class.trim());

                        CP_Customizer.updateState(true);
                    });


                    break;
            }

            if (match) {
                _class = _class.replace(/\s\s+/, " ").trim();
                _class += " " + value;

                node.attr('class', _class.trim());
            }

        }

        if (field.name === "button_icon_option") {
            node.attr('data-icon', value.icon);
            node.find('span.fa').remove();

            if (value.visible) {
                node.prepend('<span class="button-icon fa ' + value.icon + '"></span>');
                root.CP_Customizer.preview.markNode(node);
            }
        }
    });


    CP_Customizer.hooks.addFilter('temp_attr_mod_value', function (value, attr, $el) {

        var _class = ($el.attr('class') || "");

        if (attr === "temp-size") {
            value = _class.match(buttonSizesRegexp) ? _class.match(buttonSizesRegexp)[0] : "";
        }

        if (attr === "temp-color") {
            value = _class.match(currentColorRegexp) ? _class.match(currentColorRegexp)[0] : "";
        }

        return value;
    });


})(window, CP_Customizer, jQuery);
