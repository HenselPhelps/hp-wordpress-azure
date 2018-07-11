(function ($) {


    if (!$.event.special.tap) {

        $.event.special.tap = {
            setup: function (data, namespaces) {
                var $elem = $(this);
                $elem.bind('touchstart', $.event.special.tap.handler)
                    .bind('touchmove', $.event.special.tap.handler)
                    .bind('touchend', $.event.special.tap.handler);
            },

            teardown: function (namespaces) {
                var $elem = $(this);
                $elem.unbind('touchstart', $.event.special.tap.handler)
                    .unbind('touchmove', $.event.special.tap.handler)
                    .unbind('touchend', $.event.special.tap.handler);
            },

            handler: function (event) {

                var $elem = $(this);
                $elem.data(event.type, 1);
                if (event.type === 'touchend' && !$elem.data('touchmove')) {
                    event.type = 'tap';
                    $.event.handle.apply(this, arguments);
                }
                else if ($elem.data('touchend')) {
                    $elem.removeData('touchstart touchmove touchend');
                }
            }
        };

    }
})(jQuery);

function opeRenderMap(settings) {
    var windowWidth = typeof(window.outerWidth) !== "undefined" ? window.outerWidth : document.documentElement.clientWidth;
    var mapOptions = {
        center: {
            lat: settings.lat,
            lng: settings.lng
        },
        scrollwheel: false,
        draggable: (windowWidth > 800),
        zoom: settings.zoom,
        mapTypeId: google.maps.MapTypeId[settings.type]
    };


    var mapHolder = jQuery('[data-id=' + settings['id'] + ']');
    mapHolder.each(function () {
        var map = new google.maps.Map(this, mapOptions);
        var latLang = new google.maps.LatLng(settings.lat, settings.lng);
        var marker = new google.maps.Marker({
            position: latLang,
            map: map
        });

        if (windowWidth < 800) {
            jQuery(this).click(function () {
                map.set("draggable", true);
            });
        }
    })
}

jQuery(function ($) {
    $('[data-fancybox]').fancybox({
        youtube: {
            controls: 1,
            showinfo: 0,
            autoplay: 1
        },
        vimeo: {
            color: 'f00',
            autoplay: 1
        }

    });

    $('[target=lightbox]').fancybox({

        iframe: {
            attr: {
                scrolling: true
            }
        }

    })

    $(document).on('onInit.fb', function (e, instance) {
        $.each(instance.group, function (i, item) {

            var type = item.type;
            if (type === 'iframe') {
                try {
                    item.opts.iframe.scrolling = "auto";
                } catch (e) {

                }
            }
        });
    });

});

(function ($) {

    $(document).on('ope-mobile-menu-show.multilanguage', function () {

        polylangLinksAddedInMenu = true;
        var $mobileUL = $('#fm2_drop_mainmenu_jq_menu_back div.menu ul');
        var $polyLangLinks = $('.ope-language-switcher a');
        if ($polyLangLinks.length) {
            $polyLangLinks.each(function () {
                var $polylangLink = $(this);
                var $menuLink = $('<li class="ellipsis pll-mobile-menu-item"><a href=#"><p class="xtd_menu_ellipsis"><font class="leaf"></font></p></a></li>');
                $menuLink.find('a').attr('href', $polylangLink.attr('href'));
                $menuLink.find('.leaf').html($polylangLink.html());
                $mobileUL.append($menuLink);
            });
        }

        $(document).off('ope-mobile-menu-show.multilanguage');
    });

    $(document).on('tap', '.ope-language-switcher', function (event) {
        var $languagesList = $(this);

        if (!$languagesList.hasClass('hover')) {
            event.preventDefault();
            event.stopPropagation();
            $languagesList.addClass('hover');
        } else {
            var isCurrentLang = $(event.target).closest('.current-lang').length !== 0;
            isCurrentLang = isCurrentLang || $(event.target).hasClass('current-lang');
            if (isCurrentLang) {
                event.preventDefault();
                event.stopPropagation();
            }
        }
    });

})(jQuery);






