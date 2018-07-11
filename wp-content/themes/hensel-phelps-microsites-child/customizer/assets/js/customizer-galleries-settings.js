(function (root, CP_Customizer, $) {


    CP_Customizer.addModule(function (CP_Customizer) {


        var shortcodeEdit = function ($node, shortcode) {

            CP_Customizer.openMediaBrowser('gallery', function (selection, ids) {

                shortcode.attrs.ids = ids.join(',');
                shortcode.attrs.columns = selection.gallery.get('columns');
                shortcode.attrs.size = selection.gallery.get('size');
                shortcode.attrs.link = selection.gallery.get('link');

                CP_Customizer.updateNodeFromShortcodeObject($node, shortcode);

            }, shortcode.attrs);
        };

        // CP_Customizer.hooks.addAction('shortcode_edit_gallery', shortcodeEdit);
        CP_Customizer.hooks.addAction('shortcode_edit_ope_gallery', shortcodeEdit);

        var $sectionSettingsContainer = $("#cp-section-setting-popup .section-settings-container");


        var container = CP_Customizer.createControl.controlsGroup(
            'section-setting-gallery-container',
            $sectionSettingsContainer,
            'Gallery Settings'
        );

        var useMasonryControl = CP_Customizer.createControl.checkbox(
            'section-setting-gallery-masonry',
            container.el(),
            'Use Masonry to display the gallery'
        );


        var useLightBoxControl = CP_Customizer.createControl.checkbox(
            'section-setting-gallery-lightbox',
            container.el(),
            'Open images in Lightbox'
        );


        var columnsPerRow = CP_Customizer.createControl.select(
            'section-setting-gallery-columns',
            container.el(),
            {
                label: 'Columns per row',

                choices: {
                    "1": "1 Column",
                    "2": "2 Columns",
                    "3": "3 Columns",
                    "4": "4 Columns",
                    "5": "5 Columns",
                    "6": "6 Columns",
                    "7": "7 Columns",
                    "8": "8 Columns",
                    "9": "9 Columns",
                    "10": "10 Columns",
                    "11": "11 Columns",
                    "12": "12 Columns"
                }

            }
        );

        CP_Customizer.hooks.addAction('right_sidebar_opened', function (sidebarId, data) {
            if (sidebarId !== 'cp-section-setting') {
                return;
            }

            var section = data.section;
            var galleryHolder = section.find('[data-content-shortcode]');

            var isGallerySection = galleryHolder.length && CP_Customizer.nodeWrapsShortcode(galleryHolder, 'ope_gallery');

            if (!isGallerySection) {
                container.free();
                return;
            }

            container.attach();

            var shortcodeData = CP_Customizer.getNodeShortcode(galleryHolder);

            useMasonryControl.attachWithSetter(
                shortcodeData.attrs.masonry == '1',
                function (value) {
                    var shortcodeData = CP_Customizer.getNodeShortcode(galleryHolder);
                    if (value) {
                        shortcodeData.attrs.masonry = '1';
                    } else {
                        shortcodeData.attrs.masonry = '0';
                    }

                    root.CP_Customizer.updateNodeFromShortcodeObject(galleryHolder, shortcodeData);
                }
            );


            useLightBoxControl.attachWithSetter(
                shortcodeData.attrs.lb == '1',
                function (value) {
                    var shortcodeData = CP_Customizer.getNodeShortcode(galleryHolder);
                    if (value) {
                        shortcodeData.attrs.lb = '1';
                    } else {
                        shortcodeData.attrs.lb = '0';
                    }

                    root.CP_Customizer.updateNodeFromShortcodeObject(galleryHolder, shortcodeData, true);
                }
            );

            columnsPerRow.attachWithSetter(
                shortcodeData.attrs.columns || "3",
                function (value) {
                    var shortcodeData = CP_Customizer.getNodeShortcode(galleryHolder);
                    shortcodeData.attrs.columns = value;
                    root.CP_Customizer.updateNodeFromShortcodeObject(galleryHolder, shortcodeData);
                }
            );

        });
    });
})(window, CP_Customizer, jQuery);
