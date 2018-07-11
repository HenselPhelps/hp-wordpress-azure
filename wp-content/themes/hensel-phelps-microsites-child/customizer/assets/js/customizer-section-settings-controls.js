(function (root, CP_Customizer, $) {

    var sectionSettingsContainer = $('' +
        '<li id="cp-section-setting-popup" class="reiki-right-section">' +
        '    <span data-reiki-close-right="true" title="Close Panel" class="close-panel"></span>' +
        '    <ul class="section-settings-container accordion-section-content no-border"></ul>' +
        ' </li>');

    CP_Customizer.addModule(function (CP_Customizer) {

        var control = wp.customize.panel('page_content_panel');
        control.container.find('.sections-list-reorder').append(sectionSettingsContainer);

        CP_Customizer.hooks.addFilter('content_section_setting_float', function () {
            return false;
        });

        CP_Customizer.hooks.addFilter('content_section_setting', function () {
            return "cp-section-setting";
        });


        CP_Customizer.createControl = function (options) {

            options = _.extend({
                id: '',
                type: '',
                container: $('<div />'),
                params: {},
                value: '',
                updater: function (value) {
                    if (control.container.find('[data-cp-link]').is('[type=checkbox]')) {
                        control.container.find('[data-cp-link]').prop('checked', value);
                        return;
                    }
                    control.container.find('[data-cp-link]').val(value).trigger('change');
                }
            }, options);


            options.params.type = options.params.type || options.type;

            var settingID = options.id || _.uniqueId('control-setting-');
            var setting = new CP_Customizer.wpApi.Setting(settingID, options.value, {});

            setting.previewer = CP_Customizer.wpApi.previewer;

            setting.transport = 'postMessage';

            options.params.settings = [setting];
            options.params.value = options.value;
            options.params.link = ' data-cp-link';

            var controllerClass = CP_Customizer.wpApi.controlConstructor[options.type] || CP_Customizer.wpApi.Control;
            var control = new controllerClass(
                settingID + '-control',
                {
                    containerType: options.type,
                    params: options.params
                }
            );

            var container = $(options.container);

            control.container = container;
            control.setting = control.setting || setting;

            control.section = function () {
                return (CP_Customizer.slugPrefix() || "").replace(/-/g, '_') + '_page_content';
            };

            var updaterCallback = options.updater;

            var oldSet = setting.set;

            setting.bind(function (value) {
                control.params.value = value;
                updaterCallback.call(this, value);
            });

            setting.bind(function (value) {
                if (_.isFunction(setting.onChange)) {
                    setting.onChange(value);
                    CP_Customizer.markSave();
                }
            });

            setting.controlContainer = container;
            setting.renderControl = function () {
                control.renderContent();
                control.ready();

                return this;
            };

            setting.attachWithSetter = function (currentValue, onChange) {
                this.onChange = false;
                this._value = undefined;
                this.set(currentValue);

                if (options.onAttach) {
                    options.onAttach.call(setting, currentValue);
                }

                var self = this;
                _.delay(function () {
                    self.onChange = onChange;
                }, 1);
            };

            setting.renderControl();
            setting.control = control;


            setting.hide = function () {
                this.control.container.hide();
            };

            setting.show = function () {
                this.control.container.show();
            };

            return setting;
        };

        CP_Customizer.createControl.color = function (id, container, params) {

            var $container = $('<li class="customize-control customize-control-kirki customize-control-kirki-color" />');

            if (container) {
                $(container).append($container);
            }

            var options = {
                id: id || '',
                updater: function (value) {
                    this.control.container.find('input[data-cp-link]').iris('color', value);
                },
                type: 'kirki-color',
                container: $container,
                params: _.extend(
                    params,
                    {
                        choices: {
                            alpha: params.alpha || true
                        },
                        value: params.value || "#FFFFFF"
                    }
                ),
                value: params.value || "#FFFFFF"
            };

            return CP_Customizer.createControl(options);
        };


        CP_Customizer.createControl.select = function (id, container, params) {
            var type = 'kirki-select',
                $container = $('<li class="customize-control customize-control-kirki customize-control-' + type + '" />');

            if (container) {
                $(container).append($container);
            }

            var options = {
                id: id || '',
                updater: function (value) {
                    if (this.controlContainer.find('[data-cp-link]').data().selectize) {
                        this.controlContainer.find('[data-cp-link]').data().selectize.setValue(value);
                    }
                },
                type: type,
                container: $container,
                params: _.extend(
                    params,
                    {
                        choices: params.choices || [],
                        value: params.value || "",
                        multiple: params.multiple || []
                    }
                ),
                value: params.value || ""
            };

            return CP_Customizer.createControl(options);
        };

        CP_Customizer.createControl.image = function (id, container, params) {
            var type = 'image',
                $container = $('<li class="customize-control customize-control-kirki customize-control-' + type + '" />');

            if (container) {
                $(container).append($container);
            }

            var options = {
                id: id || '',
                type: type,
                container: $container,
                updater: function (value) {
                    if (value && "none" !== value && "/none" !== value.split('/none').pop()) {
                        this.control.params.attachment = {
                            id: Date.now(),
                            type: type,
                            sizes: {
                                full: {
                                    url: value
                                }
                            }
                        }
                    } else {
                        this.control.params.attachment = undefined;
                    }
                    this.control.renderContent();
                },
                params: _.extend(
                    params,
                    {

                        canUpload: true,
                        button_labels: {
                            remove: "Remove",
                            change: "Change",
                            select: "Select"
                        },
                        attachment: {
                            type: type,
                            sizes: {
                                full: {
                                    url: params.url
                                }
                            }
                        }
                    }
                ),
                value: params.value || ""
            };

            return CP_Customizer.createControl(options);
        };

        CP_Customizer.createControl.gradient = function (id, container, params) {
            var type = 'web-gradients',
                $container = $('<li class="customize-control customize-control-kirki customize-control-' + type + '" />');

            if (container) {
                $(container).append($container);
            }

            var options = {
                id: id || '',
                type: type,
                updater: function (value) {
                    this.control.params.value = value;
                    this.control.renderContent();
                },
                container: $container,
                params: _.extend(
                    params,
                    {
                        value: params.value || "",
                        button_label: "Choose Gradient"
                    }
                ),
                value: params.value || ""
            };

            return CP_Customizer.createControl(options);
        };


        CP_Customizer.createControl.sectionSeparator = function (id, container, label) {
            var type = 'sectionseparator',
                $container = $('<li class="customize-control customize-control-kirki customize-control-' + type + '" />');

            if (container) {
                $(container).append($container);
            }

            var options = {
                id: id || '',
                type: type,
                container: $container,
                params: {
                    label: label
                }
            };

            return CP_Customizer.createControl(options);
        };


        CP_Customizer.createControl.controlsGroup = function (id, container, label) {
            var type = 'sectionseparator',
                $container = $('<li class="customize-control customize-control-kirki customize-controls-container customize-control-' + type + '" ></li>');

            if (container) {
                $(container).append($container);
            }

            var options = {
                id: id || '',
                type: type,
                container: $container,
                params: {
                    label: label || ""
                }
            };

            var result = CP_Customizer.createControl(options);


            return (function (result, $el, parent) {

                if (!label) {
                    result.control.container.find('.one-page-express-separator').remove()
                }


                result.parent = container;

                result.free = function () {
                    $el.remove();
                };

                result.attach = function () {
                    parent.append($el);
                };

                result.el = function () {
                    if (this.control.container.find('ul.holder').length === 0) {
                        this.control.container.append('<ul class="holder"></ul>');
                    }
                    return this.control.container.find('ul.holder');
                };

                return result;
            })(result, $container, container);
        };


        CP_Customizer.createControl.controlHolder = function (id, container) {
            var type = 'sectionsetting',
                $container = $('<li class="customize-control customize-control-kirki customize-control-' + type + '" />');

            if (container) {
                $(container).append($container);
            }

            var options = {
                id: id || '',
                type: type,
                container: $container
            };

            return CP_Customizer.createControl(options);
        };


        CP_Customizer.createControl.checkbox = function (id, container, label) {
            var type = 'kirki-checkbox',
                $container = $('<li class="customize-control customize-control-kirki customize-control-' + type + '" />');

            if (container) {
                $(container).append($container);
            }

            var options = {
                id: id || '',
                type: type,
                container: $container,
                params: {
                    label: label
                }
            };

            return CP_Customizer.createControl(options);
        };


        CP_Customizer.createControl.button = function (id, container, label, callback, buttonOptions) {
            var type = 'kirki-checkbox',
                $container = $('<li class="customize-control customize-control-kirki customize-control-ope-button" />');

            if (container) {
                $(container).append($container);
            }

            buttonOptions = _.extend(
                {
                    class: "button full-width"
                },
                buttonOptions
            );

            var options = {
                id: id || '',
                type: type,
                container: $container,
                params: {
                    label: label
                }
            };

            var result = CP_Customizer.createControl(options);

            result.control.container.empty();

            var $button = $('<button class="' + buttonOptions.class + '" />');
            $button.text(label);
            $button.off('click').on('click', function (event) {
                event.stopPropagation();
                event.preventDefault();
                callback.call(this, event);
            });

            result.control.container.append($button);

            return result;
        };


        CP_Customizer.createControl.info = function (id, container, content) {
            var type = 'kirki-checkbox',
                $container = $('<li class="customize-control customize-control-kirki customize-control-ope-info" />');

            if (container) {
                $(container).append($container);
            }


            var options = {
                id: id || '',
                type: type,
                container: $container,
                params: {
                    label: ""
                }
            };

            var result = CP_Customizer.createControl(options);

            result.control.container.empty();

            result.control.container.append(content);


            return result;
        };


        CP_Customizer.createControl.sortable = function (id, container, itemTemplate) {
            var type = 'sectionsetting',
                $container = $('<li class="customize-control customize-control-kirki customize-control-' + type + '" />');

            if (container) {
                $(container).append($container);
            }

            var options = {
                id: id || '',
                type: type,
                container: $container,
                params: {
                    itemTemplate: itemTemplate
                }
            };

            var result = CP_Customizer.createControl(options);

            result.control.attachControls = function () {
            };
            result.control.free = function () {
                this.container.find('.setting-control-container').empty();
                try {
                    this.container.sortable('destroy');
                } catch (e) {

                }
            };

            result.control.onStop = function () {
            };

            result.control.setItems = function (items, afterCreation) {
                var control = this;
                var itemContainer = this.container.find('.setting-control-container');
                for (var i = 0; i < items.length; i++) {
                    var item = items[i];
                    var html = control.params.itemTemplate(item);

                    if (afterCreation) {
                        html = $(html);
                        afterCreation(html, item);
                    }

                    itemContainer.append(html);
                }

                itemContainer.sortable({
                    axis: "y",
                    handle: ".handle",
                    stop: function (event, ui) {
                        result.control.onStop(event, ui);
                    }
                });

            };


            return result;
        }


        CP_Customizer.createControl.spacing = function (id, container, options) {
            if (!options.sides) {
                options.sides = ['top', 'bottom'];
            }

            var type = 'kirki-spacing',
                $container = $('<li class="customize-control customize-control-kirki customize-control-' + type + ' cp-control" />');

            if (container) {
                $(container).append($container);
            }

            var sides = {};
            var controls = {};

            for (var i = 0; i < options.sides.length; i++) {
                sides[options.sides[i]] = "0px";
                controls[options.sides[i]] = true;
            }

            var controlOptions = {
                id: id || '',
                updater: function (value) {

                    for (var key in value) {
                        var $input = this.controlContainer.find('.' + key + '.input-wrapper > input');
                        $input.val(value[key]);
                    }

                },
                type: type,
                container: $container,
                params: {
                    kirkiConfig: "global",
                    l10n: kirki.l10n.global,
                    label: options.label,
                    default: sides,
                    choices: {
                        controls: controls
                    }
                },
                value: sides
            };

            kirkiNotifications(id, type, 'global');

            return CP_Customizer.createControl(controlOptions);
        }

        CP_Customizer.createControl.dimension = function (id, container, options) {

            options = options || {};

            var type = 'kirki-dimension',
                $container = $('<li class="customize-control customize-control-kirki customize-control-' + type + ' cp-control" />');

            if (container) {
                $(container).append($container);
            }


            var controlOptions = {
                id: id || '',
                updater: function (value) {
                    var $input = this.controlContainer.find('.input-wrapper > input');
                    $input.val(value);

                },
                type: type,
                container: $container,
                params: {
                    kirkiConfig: "global",
                    l10n: kirki.l10n.global,
                    label: options.label,
                    default: options.default || "0px"
                },
                value: options.default || "0px"
            };

            kirkiNotifications(id, type, 'global');

            return CP_Customizer.createControl(controlOptions);
        }

        CP_Customizer.createControl.slider = function (id, container, options) {

            options = options || {};

            options.choices = _.extend(options.choices || {}, {
                min: 0,
                max: 100,
                step: 1
            });

            var type = 'kirki-slider',
                $container = $('<li class="customize-control customize-control-kirki customize-control-' + type + ' cp-control" />');

            if (container) {
                $(container).append($container);
            }


            var controlOptions = {
                id: id || '',
                updater: function (value) {
                    var thisInput = this.controlContainer.find('input');
                    thisInput.val(value);
                    thisInput.change();
                    thisInput.siblings('.kirki_range_value .value').text(value);

                },
                onAttach: function (value) {
                    var thisInput = this.controlContainer.find('input');
                    thisInput.attr('data-reset_value', value);
                    thisInput.data('reset_value', value);
                },
                type: type,
                container: $container,
                params: {
                    kirkiConfig: "global",
                    l10n: kirki.l10n.global,
                    label: options.label,
                    default: options.default || "0",
                    choices: options.choices
                },
                value: options.default || "0"
            };

            kirkiNotifications(id, type, 'global');

            return CP_Customizer.createControl(controlOptions);
        }
    });

})(window, CP_Customizer, jQuery);
