(function (root, CP_Customizer, $) {

    var separatorPosition = ['top', 'bottom'];
    var controls = {
        top: {},
        bottom: {}
    };

    CP_Customizer.hooks.addAction('section_panel_before_text_options', function ($sectionSettingsContainer) {
        CP_Customizer.createControl.sectionSeparator(
            'section-setting-separators-sep',
            $sectionSettingsContainer,
            'Section Separators');

        _.each(separatorPosition, function (position) {
            controls[position]['displayControl'] = CP_Customizer.createControl.checkbox(
                'section-setting-display-separator-' + position,
                $sectionSettingsContainer,
                'Display ' + position + ' separator'
            );

            controls[position]['optionsGroup'] = CP_Customizer.createControl.controlsGroup(
                'section-setting-gallery-container',
                $sectionSettingsContainer,
                false
            );

            var $groupEl = controls[position]['optionsGroup'].el();

            controls[position]['type'] = CP_Customizer.createControl.select(
                'section-setting-separator-' + position + '-type',
                $groupEl,
                {
                    label: "Section " + position + " separator type",
                    choices: CP_Customizer.options('section_separators')
                }
            );


            controls[position]['color'] = CP_Customizer.createControl.color(
                'section-setting-separator-' + position + '-color',
                $groupEl,
                {
                    label: "Section " + position + " separator color"
                }
            );

            controls[position]['size'] = CP_Customizer.createControl.slider(
                'section-setting-separator-' + position + '-size',
                $groupEl,
                {
                    label: 'Separator Height',
                    choice: {
                        min: 1,
                        max: 100,
                        step: 0.1
                    }

                }
            );

        });

    });

    function toggleGroupVisibility(position, visible) {
        if (visible) {
            controls[position].optionsGroup.show();
        } else {
            controls[position].optionsGroup.hide();
        }
    }

    var defaultSeparatorTemplate = _.template('' +
        '<div class="section-separator-<%= position %>">\n' +
        '    <svg class="section-separator-<%= position %>" data-separator-name="triangle-asymmetrical-negative" preserveaspectratio="none" viewbox="0 0 1000 100" xmlns="http://www.w3.org/2000/svg">\n' +
        '        <path class="svg-white-bg" d="M737.9,94.7L0,0v100h1000V0L737.9,94.7z"></path>\n' +
        '    </svg>\n' +
        '</div>' +
        '');

    var cachedSeparators = {};

    CP_Customizer.hooks.addAction('section_sidebar_opened', function (data) {
        var $section = data.section;

        _.each(separatorPosition, function (position) {
            var hasSeparator = ( $section.children('div.section-separator-' + position).length > 0);
            var separatorControls = controls[position];

            toggleGroupVisibility(position, hasSeparator);


            function updateGroupControls() {
                var separator = $section.children('div.section-separator-' + position);

                var selector = '[data-id=' + $section.attr('data-id') + '] div.section-separator-' + position;
                var pathSelector = selector + ' svg path';

                separatorControls.type.attachWithSetter(
                    separator.find('svg').attr('data-separator-name'),
                    function (value) {
                        var url = CP_Customizer.options('themeURL') + "/assets/separators/" + value + ".svg";

                        if (!cachedSeparators[value]) {

                            CP_Customizer.IO.customGet(url).done(function (data, xhr) {
                                var svg = xhr.responseText;

                                var $svg = $(svg).attr('data-separator-name', value);
                                svg = $svg[0];

                                $svg.addClass('section-separator-' + position);

                                CP_Customizer.preview.replaceNode(separator.find('svg'), $svg);
                                cachedSeparators[value] = svg;
                            });

                        } else {
                            var $svg = $(cachedSeparators[value]).addClass('section-separator-' + position);
                            CP_Customizer.preview.replaceNode(separator.find('svg'), $svg);
                        }
                    }
                );


                separatorControls.color.attachWithSetter(
                    CP_Customizer.contentStyle.getNodeProp(separator.find('path'), pathSelector, null, 'fill'),
                    function (value) {
                        CP_Customizer.contentStyle.setProp(pathSelector, null, 'fill', value);

                    }
                );

                separatorControls.size.attachWithSetter(
                    CP_Customizer.utils.cssValueNumber(CP_Customizer.contentStyle.getProp(selector, null, 'height', '20')),
                    function (value) {
                        CP_Customizer.contentStyle.setProp(selector, null, 'height', value + '%');
                    }
                );
            }

            separatorControls.displayControl.attachWithSetter(hasSeparator, function (value) {
                toggleGroupVisibility(position, value);

                if (value) {
                    var separatorContent = defaultSeparatorTemplate({position: position});

                    if ($section.children('div.section-separator-' + position).length === 0) {
                        $section.addClass('content-relative');
                        CP_Customizer.preview.insertNode($(separatorContent), $section, 0);
                    }

                    updateGroupControls();
                } else {
                    $section.children('div.section-separator-' + position).remove();
                }

            });

            updateGroupControls();

        });


    });

})(window, CP_Customizer, jQuery);
