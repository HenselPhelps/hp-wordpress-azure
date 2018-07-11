(function (root, CP_Customizer, $) {

    var mapsAnsSubscribeControls = {
        "one_page_express_maps": {
            "api_key": {
                control: {
                    label: "Api key (<a target='_blank' href='https://developers.google.com/maps/documentation/javascript/get-api-key'>Get your api key here</a>)",
                    type: "text",
                    setValue: function (name, value, tag) {
                        CP_Customizer.setMod(tag + '_' + name, value);
                    },
                    getValue: function (name, tag) {
                        return CP_Customizer.getMod(tag + '_' + name);
                    }
                }
            },

            "address": {
                control: {
                    label: "Address",
                    type: "text"
                }
            },

            "lng": {
                control: {
                    label: "Lng (optional)",
                    type: "text"
                }
            },

            "lat": {
                control: {
                    label: "Lat (optional)",
                    type: "text"
                }
            },


            "zoom": {
                control: {
                    label: "Zoom",
                    type: "text",
                    default: 65
                }
            },

            "shortcode": {
                control: {
                    canHide: true,
                    description: "Use this field for 3rd party maps plugins. The fields above will be ignored in this case.",
                    enableLabel: "Use 3rd party shortcode",
                    label: "3rd party shortcode (optional)",
                    type: "text-with-checkbox",
                    setParse: function (value) {
                        if (value.visible) {
                            return value.shortcode.replace(/^\[+/, '').replace(/\]+$/, '')
                        }
                        return "";
                    },

                    getParse: function (value) {
                        value = value.replace(/^\[+/, '').replace(/\]+$/, '')
                        if (value) {
                            return {value: "[" + ( CP_Customizer.utils.htmlDecode(value)) + "]", visible: true};
                        }
                        return {value: "", visible: false}
                    }
                }

            }
        },

        "one_page_express_subscribe_form": {
            "shortcode": {
                control: {
                    label: "3rd party form shortcode",
                    type: "text",
                    setParse: function (value) {
                        return value.replace(/^\[+/, '').replace(/\]+$/, '')
                    },
                    getParse: function (value) {
                        return "[" + CP_Customizer.utils.htmlDecode(value.replace(/^\[+/, '').replace(/\]+$/, '')) + "]";
                    }
                }
            }
        }
    };

    CP_Customizer.hooks.addFilter('filter_shortcode_popup_controls', function (controls) {
        var extendedControls = _.extend(
            _.clone(controls),
            mapsAnsSubscribeControls
        );

        return extendedControls;
    });

    CP_Customizer.hooks.addAction('shortcode_edit_one_page_express_maps', CP_Customizer.editEscapedShortcodeAtts);
    CP_Customizer.hooks.addAction('shortcode_edit_one_page_express_subscribe_form', CP_Customizer.editEscapedShortcodeAtts);


})(window, CP_Customizer, jQuery);


(function (root, CP_Customizer, $) {


    var contentElementSelector = '[data-name="ope-custom-content-shortcode"]';

    CP_Customizer.content.registerItem({
        "shortcode-content": {
            label: "[ ]",
            data: '<div data-editable="true" data-name="ope-custom-content-shortcode" data-content-shortcode="ope_shortcode_placeholder">[ope_shortcode_placeholder]</div>',
            contentElementSelector: contentElementSelector,
            tooltip: 'Custom shortcode',
            after: shortcodeEdit
        }
    });

    function shortcodeEdit($node) {

        if ($node.is(contentElementSelector)) {

            // var shortcode = prompt('Set the shortcode ( leave empty to remove )', '[' + $node.attr('data-content-shortcode') + ']');
            CP_Customizer.popupPrompt(
                'Shortcode',
                'Set the shortcode',
                '[' + $node.attr('data-content-shortcode') + ']',
                function (shortcode, oldShortcode) {
                    if (shortcode === null) {
                        return;
                    }

                    if (!shortcode) {
                        $node.remove();
                        return;
                    }

                    shortcode = '[' + CP_Customizer.utils.phpTrim(shortcode, '[]') + ']';
                    CP_Customizer.updateNodeShortcode($node, shortcode);
                }
            );


        }
    }

    CP_Customizer.hooks.addAction('shortcode_edit', shortcodeEdit);

})(window, CP_Customizer, jQuery);


(function (root, CP_Customizer, $) {

    var contentElementSelector = '[data-name="ope-widgets-area"]';

    CP_Customizer.content.registerItem({
        "wisgets-area": {
            icon: 'fa-th-large',
            data: '<div data-editable="true" data-name="ope-widgets-area" data-content-shortcode="ope_display_widgets_area id=\'\'">[ope_display_widgets_area id=""]</div>',
            contentElementSelector: contentElementSelector,
            tooltip: 'Widgets Area',
            after: shortcodeEdit
        }
    });


    function shortcodeEdit($node, sortcodeObject) {

        var areaId = sortcodeObject ? sortcodeObject.attrs.id : "";

        function popupClose(value, oldValue) {
            var shortcode = {
                "tag": "ope_display_widgets_area",
                "attrs": {
                    "id": value
                }
            };

            CP_Customizer.updateNodeFromShortcodeObject($node, shortcode);
        }

        var $popup = CP_Customizer.popupSelectPrompt(
            'Widgets Area',
            'Select a Widgets Area',
            areaId,
            CP_Customizer.preview.data('widgets_areas'),
            popupClose,
            'No Widgets Area Selected',
            '<a href="#" class="manage-widgets-areas">Manage Widgets Areas</a>'
        );

        $popup.find('a.manage-widgets-areas').click(function () {
            CP_Customizer.closePopUps();
            CP_Customizer.wpApi.control('ope_pro_users_custom_widgets_areas').focus();
        })
    }

    CP_Customizer.hooks.addAction('shortcode_edit_ope_display_widgets_area', shortcodeEdit);

})(window, CP_Customizer, jQuery);


(function (root, CP_Customizer, $) {

    var tag = 'ope_display_woocommerce_items';

    var cachedCategories = {};
    var cachedTags = {};

    var popupControls = {

        "custom": {
            control: {
                label: "Use custom selection",
                type: "checkbox",
                default: false,
                text: 'Search for specific products to display',
                getValue: function () {
                    try {
                        value = JSON.parse(this.value);
                    } catch (e) {

                    }

                    return value;

                },
                toggleVisibleControls: function () {
                    var val = this.val();
                    if (val) {
                        this.$panel.find('' +
                            '[data-field="categories"],' +
                            '[data-field="order_by"],' +
                            '[data-field="order"],' +
                            '[data-field="tags"],' +
                            '[data-field="filter"],' +
                            '[data-field="products_number"]'
                        ).hide();
                        this.$panel.find('[data-field="products"]').show();

                    } else {
                        this.$panel.find('' +
                            '[data-field="categories"],' +
                            '[data-field="order_by"],' +
                            '[data-field="order"],' +
                            '[data-field="tags"],' +
                            '[data-field="filter"],' +
                            '[data-field="products_number"]'
                        ).show();
                        this.$panel.find('[data-field="products"]').hide();
                    }
                },
                ready: function ($controlWrapper, $panel) {
                    var field = this;
                    field.toggleVisibleControls();
                    $controlWrapper.find('input[type=checkbox]').change(function () {
                        field.toggleVisibleControls();
                    });
                }

            }
        },


        "columns": {
            control: {
                label: "Number of products per row",
                type: "text",
                default: 3
            }
        },


        "products_number": {
            control: {
                label: "Total number of products to display",
                type: "text",
                default: 6
            }
        },

        "filter": {
            control: {
                label: "Show",
                type: "select",
                default: 'all',
                choices: {
                    "All products": "all",
                    "Featured products": "featured",
                    "On-sale products": "onsale"
                }
            }
        },

        "categories": {
            control: {
                label: "Categories",
                type: "selectize",
                default: '',
                data: {
                    choices: function () {
                        return cachedCategories;
                    },
                    multiple: true
                }
            }
        },

        "tags": {
            control: {
                label: "Tags",
                type: "selectize",
                default: '',
                data: {
                    choices: function () {
                        return cachedTags;
                    },
                    multiple: true
                }
            }
        },

        "order_by": {
            control: {
                label: "Order By",
                type: "select",
                default: 'date',
                choices: {
                    "Date" : "date",
                    "Price" : "price",
                    "Sales" : "sales",
                    "Rating" : "rating",
                    "Random" : "random" 
                }
            }
        },

        "order": {
            control: {
                label: "Order",
                type: "select",
                default: 'DESC',
                choices: {
                    "ASC": "ASC",
                    "DESC": "DESC"
                }
            }
        },

        "products": {
            control: {
                label: "Select Products to display",
                type: "selectize-remote",
                default: null,
                getValue: function () {
                    if (this.value == 'null' || !this.value) {
                        return [];
                    }
                    var ids = this.value.split(',');
                    return ids;

                },
                ready: function ($controlWrapper) {
                    var field = this;

                    if (this.value) {
                        CP_Customizer.IO.rest.get(
                            '/wc/v2/products',
                            {
                                'ope_woo_api_nonce': CP_Customizer.options('ope_woo_api_nonce'),
                                include: field.value.join(',')
                            }
                        ).done(function (data) {
                            field.initSelectize(data);
                        }).fail(function () {
                            field.initSelectize([]);
                        })
                    } else {
                        field.initSelectize([]);
                    }
                },

                initSelectize: function (options) {

                    var $select = this.$wrapper.find('select');
                    $select.attr('multiple', true);
                    if (_.isArray(options)) {
                        for (var i = 0; i < options.length; i++) {
                            $select.append('<option selected="true" value="' + options[i].id + '">' + options[i].name + '</option>')
                        }

                    }
                    var field = this;
                    $select.selectize({
                        valueField: 'id',
                        labelField: 'name',
                        searchField: 'name',
                        maxItems: null,
                        plugins: ['remove_button', 'drag_drop'],
                        options: options || [],
                        create: false,
                        load: function (query, callback) {
                            if (!query.length) return callback();
                            CP_Customizer.IO.rest.get(
                                '/wc/v2/products',
                                {
                                    'ope_woo_api_nonce': CP_Customizer.options('ope_woo_api_nonce'),
                                    search: query
                                }
                            ).done(function (data) {
                                callback(data);
                            }).fail(function () {
                                callback();
                            })

                        }
                    })
                }
            }
        }
    };

    CP_Customizer.addModule(function (CP_Customizer) {

        CP_Customizer.IO.rest.get(
            '/wc/v2/products/categories',
            {
                'ope_woo_api_nonce': CP_Customizer.options('ope_woo_api_nonce')
            }
        ).done(function (data) {
            if (_.isArray(data)) {
                for (var i = 0; i < data.length; i++) {
                    var item = data[i];
                    cachedCategories[item.id] = item.name
                }
            }
        });


        CP_Customizer.IO.rest.get(
            '/wc/v2/products/tags',
            {
                'ope_woo_api_nonce': CP_Customizer.options('ope_woo_api_nonce')
            }
        ).done(function (data) {
            if (_.isArray(data)) {
                for (var i = 0; i < data.length; i++) {
                    var item = data[i];
                    cachedTags[item.id] = item.name
                }
            }
        });

    });


    CP_Customizer.hooks.addFilter('filter_shortcode_popup_controls', function (controls) {
        var popUp = {};
        popUp[tag] = popupControls;
        var extendedControls = _.extend(
            _.clone(controls),
            popUp
        );
        return extendedControls;
    });


    CP_Customizer.hooks.addAction('shortcode_edit_' + tag, function ($node, shortcodeData) {
        CP_Customizer.openShortcodePopupEditor(function (atts) {
            var newShortcode = _.clone(shortcodeData);
            atts.tags = ( atts.tags == null )? '' : atts.tags;
            atts.categories = (atts.categories == null) ? '' : atts.categories;
            newShortcode.attrs = _.extend(newShortcode.attrs, atts);

            CP_Customizer.updateNodeFromShortcodeObject($node, newShortcode);

        }, $node, shortcodeData)
    });


    CP_Customizer.hooks.addAction('dynamic_columns_handle', function (cols, node) {
        if (CP_Customizer.isShortcodeContent(node)) {
            var shortcode = CP_Customizer.getNodeShortcode(node);
            var device = root.CP_Customizer.preview.currentDevice();
            var prop = ( device === "tablet") ? "columns_tablet" : "columns";
            shortcode.attrs = shortcode.attrs || {};
            shortcode.attrs[prop] = cols;

            CP_Customizer.updateNodeFromShortcodeObject(node, shortcode);
        }
    });

})(window, CP_Customizer, jQuery);
