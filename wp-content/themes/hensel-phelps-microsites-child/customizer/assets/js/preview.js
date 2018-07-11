(function ($) {
    liveUpdateAutoSetting('ope_pro_background_overlay', function (value) {

        var style = jQuery.map(value, function (color, id) {
            return '[data-ovid="' + id + '"]:before { background-color: ' + color + ' !important; }'
        }).join("\n");

        jQuery('style[data-for=ope_pro_background_overlay]').html(style);
    });

    liveUpdate('header_nav_title_typography', function (value) {
        jQuery('#drop_mainmenu>li:hover>a, #drop_mainmenu>li.hover>a, #drop_mainmenu>li.current_page_item>a').css({
            'text-shadow': "0px 0px 0px " + value.color
        });

        jQuery('#drop_mainmenu>li:hover>a, #drop_mainmenu>li.hover>a, #drop_mainmenu>li.current_page_item>a').css({
            'border-bottom-color': value.color
        });

        jQuery('.header-top.homepage.bordered').css({
            'border-bottom-color': value.color
        });
    });

    liveUpdate('header_content_vertical_align', function (value) {
        var header = jQuery('.header-homepage');
        header.removeClass('v-align-top');
        header.removeClass('v-align-middle');
        header.removeClass('v-align-bottom');
        header.addClass(value);
    });

    liveUpdate('one_page_express_header_text_align', function (value) {
        var header = jQuery('.header-content:not(.header-content-centered, .header-content-left, .header-content-right)');
        if (header.length) {
            header.removeClass('container-align-center');
            header.removeClass('container-align-left');
            header.removeClass('container-align-right');
            header.addClass('container-align-' + value);
        }
    });
    liveUpdate('one_page_express_full_height', function (value) {
        var contentVerticalControl = parent.wp.customize.control('header_content_vertical_align');
        contentVerticalControl.active(value);
    });

    liveUpdate('one_page_express_header_content_image_rounded', function (value) {
        if (value) {
            $('.homepage-header-image').addClass('round');
        } else {
            $('.homepage-header-image').removeClass('round');
        }
    });


    function getHeaderSplitGradientValue(color, angle, size, fade) {
        angle = -90 + parseInt(angle);
        fade = parseInt(fade) / 2;
        transparentMax = (100 - size) - fade;
        colorMin = (100 - size) + fade;


        var gradient = angle + "deg, " + "transparent 0%, transparent " + transparentMax + "%, " + color + " " + colorMin + "%, " + color + " 100%";

        // return gradient;

        var result = 'background: linear-gradient(' + gradient + ');' +
            'background: -webkit-linear-gradient(' + gradient + ');' +
            'background: linear-gradient(' + gradient + ');';

        return result;
    }

    function recalculateHeaderSplitGradient() {
        var color = wp.customize('split_header_color').get();
        var angle = wp.customize('split_header_angle').get();
        var fade = wp.customize('split_header_fade') ? wp.customize('split_header_fade').get() : 0;
        var size = wp.customize('split_header_size').get();

        var gradient = getHeaderSplitGradientValue(color, angle, size, fade);

        var angle = wp.customize('split_header_angle_mobile').get();
        var size = wp.customize('split_header_size_mobile').get();

        var mobileGradient = getHeaderSplitGradientValue(color, angle, size, fade);

        var style = '' +
            '.header-homepage:after{' + mobileGradient + '}' + "\n\n" +
            '@media screen and (min-width: 1024px) { .header-homepage:after{' + gradient + '} }';

        jQuery('style[data-name="header-split-style"]').html(style);
    }

    
    liveUpdate('split_header_fade', recalculateHeaderSplitGradient);
    liveUpdate('split_header_color', recalculateHeaderSplitGradient);
    liveUpdate('split_header_angle', recalculateHeaderSplitGradient);
    liveUpdate('split_header_size', recalculateHeaderSplitGradient);
    liveUpdate('split_header_angle_mobile', recalculateHeaderSplitGradient);
    liveUpdate('split_header_size_mobile', recalculateHeaderSplitGradient);
})(jQuery);
