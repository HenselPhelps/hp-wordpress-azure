(function (root, CP_Customizer, $) {

    CP_Customizer.themeColors = function() {
        var buttonColors = {
            "default": "",
        }
        var colors = CP_Customizer.getColorsObj();
        _.each(colors, function(color, name) {
            buttonColors[name] = name;
        })

        return buttonColors;
    }

    var currentColorRegexp;

  
    CP_Customizer.hooks.addFilter('container_data_element', function (result, $elem) {
        var _class = CP_Customizer.preview.cleanNode($elem.clone()).attr('class') || "";
        
        var colors = CP_Customizer.themeColors();

        currentColorRegexp = /(color\d+)/ig;

        if ($elem.is('i.fa')) {
            var color = _class.match(currentColorRegexp) ? _class.match(currentColorRegexp)[0] : "";

            color = CP_Customizer.getColorValue(color);

            result.push({
                label: "Icon Color",
                type: "colorselect",
                choices : colors,
                "name": "icon_color_option",
                "value": color
            });
        }

        return result;
    });

    CP_Customizer.hooks.addAction('container_data_element_setter', function (node, value, field) {
        if (field.name) {
            var _class = node.attr('class');
            var match = false;
            switch (field.name) {
                case "icon_color_option":
                    match = true;
                    _class = _class.replace(currentColorRegexp, " ");
                    
                    value = CP_Customizer.getThemeColor(value, function(value) {
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
	           CP_Customizer.updateState();
            }
        
        }
    });
    
})(window, CP_Customizer, jQuery);
