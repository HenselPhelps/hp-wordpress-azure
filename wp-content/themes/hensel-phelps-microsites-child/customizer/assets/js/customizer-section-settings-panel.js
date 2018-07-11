(function (root, CP_Customizer, $) {

    CP_Customizer.addModule(function (CP_Customizer) {
        var $sectionSettingsContainer = $("#cp-section-setting-popup .section-settings-container");

        CP_Customizer.hooks.doAction('section_panel_before_dimensions', $sectionSettingsContainer); // #####

        // dimensions
        CP_Customizer.createControl.sectionSeparator(
            'section-setting-dimension-sep',
            $sectionSettingsContainer,
            'Section Dimensions'
        );

        var sectionPadding = CP_Customizer.createControl.spacing(
            'section-setting-padding',
            $sectionSettingsContainer,
            {
                sides: ['top', 'bottom'],
                label: 'Section Spacing'
            }
        );


        CP_Customizer.hooks.doAction('section_panel_before_background', $sectionSettingsContainer); // #####


        CP_Customizer.createControl.sectionSeparator(
            'section-setting-background-type-sep',
            $sectionSettingsContainer,
            'Section Background'
        );

        var bgType = CP_Customizer.createControl.select(
            'section-setting-background-type',
            $sectionSettingsContainer,
            {
                value: '',
                label: 'Background Type',
                choices: {
                    transparent: "Transparent",
                    color: "Color",
                    image: "Image",
                    gradient: "Gradient"
                }
            });

        function removeGradientClass($item) {
            var _class = $item.attr('class') || "";
            _class = _class.replace(new RegExp(CP_Customizer.options().gradients.join("|")), " ");
            _class = _class.replace(/\s\s+/, " ").trim();

            $item.attr('class', _class);

            return $item;
        }


        // the onchange function does not change when the node changes
        var bgTypeControlsToggler = function (value) {
            bgColor.control.container.hide();
            bgImage.control.container.hide();
            bgGradient.control.container.hide();
            bgPageBackground.control.container.hide();
            parallaxBackground.control.container.hide();

            switch (value) {
                case "transparent":
                    bgPageBackground.control.container.show();
                    break;
                case "color":
                    bgColor.control.container.show();
                    break;
                case "image":
                    bgImage.control.container.show();
                    parallaxBackground.control.container.show();
                    break;
                case "gradient":
                    bgGradient.control.container.show();
                    parallaxBackground.control.container.show();
                    break;
            }
        };


        bgType.onChange = bgTypeControlsToggler;

        var bgColor = CP_Customizer.createControl.color(
            'section-setting-background-color',
            $sectionSettingsContainer,
            {
                value: '#ffffff',
                label: 'Background Color'
            });

        var bgPageBackground = CP_Customizer.createControl.button(
            'section-setting-background-color',
            $sectionSettingsContainer,
            'Change Page Background Image',
            function () {
                CP_Customizer.wpApi.control('background_image').focus();
            }
        );

        var bgImage = CP_Customizer.createControl.image(
            'section-setting-background-image',
            $sectionSettingsContainer,
            {
                value: '',
                label: 'Background Image'
            });

        var bgGradient = CP_Customizer.createControl.gradient(
            'section-setting-background-gradient',
            $sectionSettingsContainer,
            {
                value: '',
                label: 'Gradient'
            });

        var bgOverlay = CP_Customizer.createControl.color(
            'section-setting-background-overlay',
            $sectionSettingsContainer,
            {
                value: 'rgba(0,0,0,0)',
                label: 'Background Overlay'
            });


        var parallaxBackground = CP_Customizer.createControl.checkbox(
            'section-setting-background-parallax',
            $sectionSettingsContainer,
            'Use parallax effect'
        );


        CP_Customizer.hooks.doAction('section_panel_before_text_options', $sectionSettingsContainer); // #####
        // section separators

        // text colors
        CP_Customizer.createControl.sectionSeparator(
            'section-setting-text-color-sep',
            $sectionSettingsContainer,
            'Text Color');

        var rowTextColorClass = CP_Customizer.createControl.select(
            'section-setting-text-color',
            $sectionSettingsContainer,
            {
                value: '',
                label: 'Text Color',
                choices: {
                    " ": "Default",
                    "white-text-section": "White text",
                    "dark-text-section": "Dark text"
                }
            });

        CP_Customizer.hooks.doAction('section_panel_section_options', $sectionSettingsContainer); // #####

        // shortcodes for CF
        var settingsSeparator = CP_Customizer.createControl.sectionSeparator(
            'section-setting-shortcode-sep',
            $sectionSettingsContainer,
            'Section Settings');

        var shortcode = CP_Customizer.createControl.controlHolder('section-setting-shortcode', $sectionSettingsContainer); // #####

        // list reorder
        var listItemsSeparator = CP_Customizer.createControl.sectionSeparator(
            'section-setting-list-items-sep',
            $sectionSettingsContainer,
            'Items Options');

        var listItemsOrder = CP_Customizer.createControl.sortable(
            'section-setting-list-items-order',
            $sectionSettingsContainer,
            _.template('' +
                '<div class="section-list-item">' +
                '   <div class="handle reorder-handler"></div>' +
                '   <div class="text">' +
                '           <span title="color item" class="featured-item"><input class="item-colors" type="text"></input></span>' +
                '           <span><%= text %></span>' +
                '           <% if(options.showFeaturedCheckbox) { %>' +
                '               <span title="Highlight item" class="featured-item"><input class="featured" type="checkbox"></span>' +
                '           <% } %>' +
                '   </div>' +
                '</div>' +
                '')
        );

        var listItemsPricingInfo = CP_Customizer.createControl.info(
            'section-setting-list-items-order-info',
            $sectionSettingsContainer,
            "To highlight any item by checking the item's checkbox"
        );

        listItemsOrder.control.container.append('<a class="add-item button-primary">Add Item</a>');


        CP_Customizer.hooks.doAction('section_panel_before_end', $sectionSettingsContainer); // #####

        // dimensions
        CP_Customizer.hooks.addAction('right_sidebar_opened', function (sidebarId, data) {
            if (sidebarId !== 'cp-section-setting') {
                return;
            }


            var selector = '[data-id="' + data.section.attr('data-id') + '"]';

            var currentPadding = {
                top: CP_Customizer.contentStyle.getNodeProp(data.section, selector, null, 'padding-top'),
                bottom: CP_Customizer.contentStyle.getNodeProp(data.section, selector, null, 'padding-bottom')
            };


            sectionPadding.attachWithSetter(
                currentPadding,
                function (value) {
                    CP_Customizer.contentStyle.setProp(selector, null, 'padding-top', value.top);
                    CP_Customizer.contentStyle.setProp(selector, null, 'padding-bottom', value.bottom);
                }
            );

        });

        CP_Customizer.hooks.addAction('right_sidebar_opened', function (sidebarId, data) {
            if (sidebarId !== 'cp-section-setting') {
                return;
            }


            CP_Customizer.hooks.doAction('section_sidebar_opened',data);
        });

        // background options
        CP_Customizer.hooks.addAction('right_sidebar_opened', function (sidebarId, data) {
            if (sidebarId !== 'cp-section-setting') {
                return;
            }


            var color = getComputedStyle(data.section[0]).backgroundColor;

            var image = CP_Customizer.utils.normalizeBackgroundImageValue((getComputedStyle(data.section[0]).backgroundImage || "")) || false;
            image = (image && image !== "none" && !image.endsWith('/none')) ? image : false;

            var gradientClass = (data.section.attr('class') || "").match(new RegExp(CP_Customizer.options().gradients.join("|")));
            gradientClass = (gradientClass || [])[0];


            var currentBgType = "color";

            if (tinycolor(color).getAlpha() === 0) {
                currentBgType = "transparent";
            }

            if (gradientClass) {
                currentBgType = "gradient";
            } else if (image) {
                currentBgType = "image";
            }
            bgTypeControlsToggler(currentBgType);

            bgColor.attachWithSetter(color, function (value) {

                var availableFor = ["color", "transparent"];

                if (!value || availableFor.indexOf(currentBgType) === -1) {
                    return
                }
                removeGradientClass(data.section);
                data.section.css({
                    'background-image': 'none',
                    'background-color': value
                });

                CP_Customizer.updateState();
            });

            // bg image
            bgImage.attachWithSetter(image, function (value) {

                if (currentBgType !== "image") {
                    return
                }

                if (value) {
                    value = 'url("' + value + '")';
                } else {
                    value = "";
                }
                data.section.css({
                    'background-color': 'none',
                    'background-image': value,
                    'background-size': 'cover',
                    'background-position': 'center top'
                });

                if (value) {
                    removeGradientClass(data.section);
                }

                CP_Customizer.updateState();
            });

            // gradient;
            bgGradient.attachWithSetter(gradientClass, function (value) {

                if (!value) {
                    return;
                }

                if (currentBgType !== "gradient") {
                    return
                }

                removeGradientClass(data.section);
                data.section.addClass(value);
                data.section.css({
                    'background-image': '',
                    'background-color': '',
                });
                CP_Customizer.updateState();
            });

            var isParallaxEnabled = data.section.is('[data-parallax-depth]');
            parallaxBackground.attachWithSetter(
                isParallaxEnabled,
                function (value) {
                    if (value) {
                        data.section.attr('data-parallax-depth', '20');
                    } else {
                        data.section.removeAttr('data-parallax-depth');
                    }
                    CP_Customizer.updateState();
                }
            );


            bgType.attachWithSetter(currentBgType, function (value) {
                bgTypeControlsToggler(value);
                currentBgType = value;

                switch (value) {

                    case "transparent":
                        bgColor._value = undefined;
                        bgColor.set('rgba(255,255,255,0)');
                        break;
                    case "color":
                        bgColor._value = undefined;
                        bgColor.set('#ffffff');
                        break;
                    case "gradient":
                        bgGradient._value = undefined;
                        bgGradient.set('february_ink');
                        break;

                    case "image":
                        bgImage._value = undefined;
                        bgImage.set(CP_Customizer.options('stylesheetURL') + "/assets/images/default-row-bg.jpg");
                        break;
                }
            });


            var currentBgOverlay = CP_Customizer.contentStyle.getNodeProp(data.section, null, ':before', 'background-color');


            bgOverlay.attachWithSetter(currentBgOverlay, function (value) {
                var ov_id = data.section.attr('data-ovid');
                if (!ov_id) {
                    var ovid_prefix = 'ovid-' + (data.section.attr('id') || "") + '-';
                    ov_id = _.uniqueId(ovid_prefix);
                    data.section.attr('data-ovid', ov_id);
                    CP_Customizer.updateState();
                }
                CP_Customizer.contentStyle.setProp('[data-ovid="' + ov_id + '"]', ':before', 'background-color', value);
            });
        });


        // settings ( shortcode )
        CP_Customizer.hooks.addAction('right_sidebar_opened', function (sidebarId, data) {

            if (sidebarId !== 'cp-section-setting') {
                return;
            }

            var section = data.section;

            if (section.attr('data-setting')) {

                settingsSeparator.control.container.show();
                shortcode.control.container.show();
                shortcode.control.free();

                var settings = section.attr('data-setting').split(/\s+/);
                for (var i = 0; i < settings.length; i++) {
                    var setting = settings[i];
                    shortcode.control.attachControls(setting);
                }
            } else {
                settingsSeparator.control.container.hide();
                shortcode.control.container.hide();
            }
        });


        // list


        CP_Customizer.hooks.addAction('right_sidebar_opened', function (sidebarId, data) {

            if (sidebarId !== 'cp-section-setting') {
                return;
            }

            var section = data.section;

            listItemsSeparator.control.container.hide();
            listItemsOrder.control.container.hide();


            if (section.is('[data-category="pricing-tables"]')) {
                listItemsPricingInfo.show();
            } else {
                listItemsPricingInfo.hide();
            }

            var row = section.find('[data-type="row"]');

            if (!row.length || row.is('[data-content-shortcode]')) {
                return;
            }

            var featuredClass = section.attr('data-featured-class');
            if (featuredClass) {
                listItemsOrder.control.container.addClass('has-featured');
            } else {
                listItemsOrder.control.container.removeClass('has-featured');
            }

            listItemsSeparator.control.container.show();
            listItemsOrder.control.container.show();

            function setItems() {
                listItemsOrder.control.free();

                var items = row.children();

                items = items.map(function () {
                    var title = $(this).text().replace(/\s\s+/g, " ").trim();

                    var headingText = $(this).find('h1,h2,h3,h4,h4,h6').eq(0);

                    if (headingText.length) {
                        title = headingText.text().replace(/\s\s+/g, " ").trim();
                    }

                    title = title.replace(/(^.{1,25})(.*)$/, function (matches, firstMatch, secondMatch) {
                        var result = (firstMatch || "").trim() + (secondMatch && secondMatch.length ? "[...]" : "");
                        return result;
                    });

                    title = title.trim().length ? title : "[EMPTY ITEM]";

                    var classes = $(this).attr('class') || "";
                    return {
                        text: title,
                        featured: classes.indexOf(featuredClass) != -1,
                        original: $(this),
                        options: {
                            showFeaturedCheckbox: section.is('[data-category="pricing-tables"]')
                        }
                    }

                }).toArray();


                listItemsOrder.control.setItems(items, function (sortableItem, data) {
                    sortableItem.data('orignal', data.original);

                    function getActiveColor() {
                        var classes = data.original.attr('class') || "";
                        var match = classes.match(/color\d+/);
                        var color = "default";
                        if (match) {
                            color = match[0];
                        }
                        return color;
                    }

                    var colors = CP_Customizer.getColorsObj();

                    var colorpicker = sortableItem.find(".item-colors");
                    CP_Customizer.initSpectrumButton(colorpicker);

                    CP_Customizer.addSpectrumButton(colorpicker);

                    var color = getActiveColor();

                    sortableItem.find(".item-colors").spectrum("set", CP_Customizer.getColorValue(color));

                    sortableItem.find(".item-colors").change(function () {
                        var color = getActiveColor();

                        var node = sortableItem.data('orignal');
                        node.removeClass(color);

                        var newVal = $(this).val();
                        newVal = CP_Customizer.getThemeColor(newVal, function (newVal) {
                            if (newVal != "default") {
                                node.addClass(newVal);
                            }
                            CP_Customizer.updateState();
                        });

                        if (newVal != "default") {
                            node.addClass(newVal);
                        }

                        CP_Customizer.updateState();
                    });

                    sortableItem.find(".featured").prop('checked', data.featured);
                    sortableItem.find('.featured').unbind('change').change(function () {
                        var checked = $(this).prop('checked');
                        var node = sortableItem.data('orignal');
                        if (checked) {
                            node.addClass(featuredClass);
                        } else {
                            node.removeClass(featuredClass);
                        }
                        CP_Customizer.updateState();
                    });
                });
            }

            listItemsOrder.control.onStop = function (event, ui) {
                var index = ui.item.index();
                var node = jQuery(ui.item).data().orignal;
                root.CP_Customizer.preview.insertNode(node, node.parent(), index);
            }

            listItemsOrder.control.container.find('.add-item').unbind('click').click(function () {
                var $content = row.children('div').first().clone(false, false);

                $content = root.CP_Customizer.preview.cleanNode($content);
                root.CP_Customizer.preview.insertNode($content, row);

                setItems();
            });

            setItems();
            root.CP_Customizer.hooks.removeAction('section_list_item_refresh', setItems);
            root.CP_Customizer.hooks.addAction('section_list_item_refresh', setItems);

            var section = data.section;
        });


        CP_Customizer.hooks.addAction('right_sidebar_opened', function (sidebarId, data) {

            if (sidebarId !== 'cp-section-setting') {
                return;
            }

            var section = data.section;
            var textClasses = ['white-text-section', 'dark-text-section'];

            rowTextColorClass.onChange = function (value) {
                $.each(textClasses, function (index, item) {
                    section.removeClass(item);
                });

                section.addClass(value);
            };

            var toSet = " ";
            for (var i = 0; i < textClasses.length; i++) {
                if (section.is('.' + textClasses[i])) {
                    toSet = textClasses[i];
                    break;
                }
            }
            rowTextColorClass.set("");
            rowTextColorClass.set(toSet);
        });

        // video popup buttons

        var videoPopUpButtonSeparator = CP_Customizer.createControl.sectionSeparator(
            'section-setting-background-video-popup-button-sep',
            $sectionSettingsContainer,
            'Video Button');

        var videoPopUpButtonColor = CP_Customizer.createControl.color(
            'section-setting-background-video-popup-button-color',
            $sectionSettingsContainer,
            {
                value: '#ffffff',
                label: 'Normal Color'
            });


        var videoPopUpButtonColorHover = CP_Customizer.createControl.color(
            'section-setting-background-video-popup-button-color',
            $sectionSettingsContainer,
            {
                value: '#ffffff',
                label: 'Hover Color'
            });


        CP_Customizer.hooks.addAction('right_sidebar_opened', function (sidebarId, data) {

            if (sidebarId !== 'cp-section-setting') {
                return;
            }

            var section = data.section;

            var hasVideoPopup = section.find('[data-video-lightbox="true"]').length > 0;

            if (hasVideoPopup) {
                videoPopUpButtonSeparator.show();
                videoPopUpButtonColor.show();
                videoPopUpButtonColorHover.show();

                var popupButton = section.find('[data-video-lightbox="true"] > i');

                var selector = CP_Customizer.preview.getNodeClasses(section);

                if (selector.length) {
                    selector = "." + selector.join('.') + " ";
                }

                var buttonClass = CP_Customizer.preview.getNodeClasses(popupButton);

                if (!buttonClass.length) {
                    buttonClass = 'cp-video-' + Date.now();
                    popupButton.addClass(buttonClass);
                    buttonClass = [buttonClass];
                }

                selector = selector + "." + buttonClass.join('.');

                videoPopUpButtonColor.attachWithSetter(
                    CP_Customizer.contentStyle.getNodeProp(popupButton, selector, null, 'color'),
                    function (value) {
                        CP_Customizer.contentStyle.setProp(selector, null, 'color', value);
                    }
                );


                videoPopUpButtonColorHover.attachWithSetter(
                    CP_Customizer.contentStyle.getNodeProp(popupButton, selector, ":hover", 'color'),
                    function (value) {
                        CP_Customizer.contentStyle.setProp(selector, ":hover", 'color', value);
                    }
                );


            } else {
                videoPopUpButtonSeparator.hide();
                videoPopUpButtonColor.hide();
                videoPopUpButtonColorHover.hide();
            }

        });

    });

    // text color
    // rowTextColorClass

    // fixed overlay cog items filter;


    CP_Customizer.hooks.addFilter('section_fixed_overlay', function (options, key) {

        var tempOptions = _.clone(options);

        if (key === "items") {
            if (_.isArray(tempOptions)) {
                tempOptions.forEach(function (item, index, optionsList) {
                    if (item.name === "section_color_changer" || item.name === "cloumns_reorder") {
                        if (item.on_hover) {
                            delete item.on_hover;
                        }

                        item.classes = "";

                        item.on_click = function (node) {
                            var section = node;

                            if (!section.parent().is(CP_Customizer.preview.getRootNode())) {
                                section = node.parentsUntil(top.CP_Customizer.preview.getRootNode()).last();
                            }

                            section = CP_Customizer.hooks.applyFilters('filter_cog_item_section_element', section, node);

                            CP_Customizer.wpApi.panel('page_content_panel').focus()
                            CP_Customizer.openRightSidebar("cp-section-setting", {
                                section: section
                            });
                        }
                    }

                    if (item.name === "page_background_image") {
                        delete optionsList[index];
                    }
                });
            }

            // do return empty array slots
            var result = tempOptions.filter(function (item) {
                return item;
            });
        } else {
            result = options;
        }


        return result;
    });

    function itemExists(options, name) {

        if (options && options.items) {
            for (var i = 0; i < options.items.length; i++) {
                var item = options.items[i];

                if (item.name === name) {
                    return true;
                }
            }
        }

        return false;
    }


    CP_Customizer.hooks.addFilter('section_fixed_overlay_options', function (options, type) {

        var item = {

            name: "section_more_settings_button",
            title: "Section Settings",

            on_click: function (node) {
                var section = node;

                if (!section.parent().is(CP_Customizer.preview.getRootNode())) {
                    section = node.parentsUntil(top.CP_Customizer.preview.getRootNode()).last();
                }

                section = CP_Customizer.hooks.applyFilters('filter_cog_item_section_element', section, node);

                CP_Customizer.wpApi.panel('page_content_panel').focus()
                CP_Customizer.openRightSidebar("cp-section-setting", {
                    section: section
                });
            }

        };

        if (type === "section" && options && !itemExists(options, item.name)) {
            options.items.push(item);
        }

        return options;
    });

})(window, CP_Customizer, jQuery);
