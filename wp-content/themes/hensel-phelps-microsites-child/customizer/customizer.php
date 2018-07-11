<?php


if ( ! defined('OPE_PRO_CUSTOMIZER_DIR')) {
    define('OPE_PRO_CUSTOMIZER_DIR', get_stylesheet_directory() . "/customizer");
}


if ( ! defined('OPE_PRO_CUSTOMIZER_URI')) {
    define('OPE_PRO_CUSTOMIZER_URI', get_stylesheet_directory_uri() . "/customizer");
}

add_filter('ope_show_info_pro_messages', "__return_false");
add_filter('ope_enable_kirki_selective_refresh', "__return_false");

require_once OPE_PRO_CUSTOMIZER_DIR . "/webgradients-list.php";


add_filter('cloudpress\customizer\global_data', 'ope_pro_customizer_data');


$ope_custom_mods = array(
    ".header-homepage .heading8" => array(
        'type' => 'data-theme',
        'mod'  => "one_page_express_header_title",
    ),

    ".header-homepage p.header-subtitle" => array(
        'type' => 'data-theme',
        'mod'  => "one_page_express_header_subtitle",
    ),

    ".header-homepage p.header-subtitle2" => array(
        'type' => 'data-theme',
        'mod'  => "one_page_express_header_subtitle2",
    ),

    ".hp-header-primary-button" => array(
        "type" => 'data-theme',
        'mod'  => 'one_page_express_header_btn_1_label',
        "atts" => array(
            'href'   => "one_page_express_header_btn_1_url",
            'target' => 'one_page_express_header_btn_1_target',
            'class'  => 'one_page_express_header_btn_1_class',
        ),
    ),

    ".hp-header-secondary-button" => array(
        "type" => 'data-theme',
        'mod'  => 'one_page_express_header_btn_2_label',
        "atts" => array(
            'href'   => "one_page_express_header_btn_2_url",
            'target' => 'one_page_express_header_btn_2_target',
            'class'  => 'one_page_express_header_btn_2_class',

        ),
    ),
);

function ope_pro_customizer_data($data)
{
    global $ope_webgradients;

    $data['gradients']        = $ope_webgradients;
    $data['sectionsOverlays'] = get_theme_mod('ope_pro_background_overlay', array());

    global $ope_custom_mods;
    $data['mods'] = apply_filters('ope_dynamic_mods', $ope_custom_mods);


    return $data;
}

add_action('cloudpress\companion\ready', function ($companion) {
    $customizer = $companion->customizer();

    $customizer->registerScripts('ope_pro_customizer_scripts');
    $customizer->previewInit('ope_pro_customizer_preview_scripts');

    $customizer->register('ope_load_customizer_controls');
    $customizer->register('ope_pro_controls');

    $customizer->register('ope_pro_controls_custom_mods', PHP_INT_MAX);
    $customizer->register('ope_pro_order', PHP_INT_MAX);
    $customizer->register('ope_pro_navigation_order', PHP_INT_MAX);

});


function ope_pro_customizer_scripts()
{

    $ver = ope_get_pro_version();
    wp_enqueue_style('ope-pro-customizer', OPE_PRO_CUSTOMIZER_URI . "/assets/css/customizer.css", $ver);

    wp_enqueue_script('customizer-ope',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer.js", array(), $ver, true);

    wp_enqueue_script('customizer-custom-style-manager',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer-custom-style-manager.js", array(), $ver, true);


    wp_enqueue_script('customizer-scss-settings-vars',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer-scss-settings-vars.js", array(), $ver, true);

    wp_enqueue_script('customizer-sectionsetting-control',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/sectionsetting-control.js", array(), $ver, true);

    wp_enqueue_script('customizer-section-settings-controls',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer-section-settings-controls.js", array(), $ver, true);

    wp_enqueue_script('customizer-section-separator',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/sectionseparator-control.js", array(), $ver, true);

    wp_enqueue_script('customizer-section-settings-panel',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer-section-settings-panel.js", array(), $ver, true);

    wp_enqueue_script('customizer-site-colors',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer-site-colors.js", array(), $ver, true);

    wp_enqueue_script('customizer-button-style',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer-button-style.js", array(), $ver, true);

    wp_enqueue_script('customizer-icon-style',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer-icon-style.js", array(), $ver, true);

    wp_enqueue_script('customizer-galleries-settings',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer-galleries-settings.js", array(), $ver, true);

    wp_enqueue_script('customizer-shortcodes-pro', OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer-shortcodes.js",
        array(), $ver, true);

    wp_enqueue_script('customizer-web-fonts',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/web-fonts.js", array(), $ver, true);
    wp_enqueue_script('customizer-webfonts-control',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/webfonts-control.js", array(), $ver, true);
    wp_localize_script("customizer-web-fonts", "cpWebFonts", array(
        "url" => OPE_PRO_CUSTOMIZER_URI . "/assets/js/web-f/index.html",
    ));


    wp_enqueue_script('customizer-section-separator-settings',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer-section-separators.js", array(), $ver, true);


    wp_enqueue_script('customizer-custom-sections-settings',
        OPE_PRO_CUSTOMIZER_URI . "/assets/js/customizer-custom-sections-settings.js", array(), $ver, true);
}

function ope_pro_customizer_preview_scripts()
{
    wp_enqueue_script('customizer-section-settings-controls', OPE_PRO_CUSTOMIZER_URI . "/assets/js/preview.js",
        array('cp-customizer-preview'), false, true);
}


function ope_load_customizer_controls($wp_customize)
{
    require_once OPE_PRO_CUSTOMIZER_DIR . "/controls/WebGradientsControl.php";
    require_once OPE_PRO_CUSTOMIZER_DIR . "/controls/SectionSettingControl.php";
    require_once OPE_PRO_CUSTOMIZER_DIR . "/controls/SidebarGroupButtonControl.php";
    require_once OPE_PRO_CUSTOMIZER_DIR . "/controls/WebFontsControl.php";

    $wp_customize->register_control_type("\\OnePageExpress\\WebGradientsControl");
    $wp_customize->register_control_type("\\OnePageExpress\\SectionSettingControl");
    $wp_customize->register_control_type("\\OnePageExpress\\SidebarGroupButtonControl");
    $wp_customize->register_control_type("\\OnePageExpress\\WebFontsControl");


    add_filter('kirki/control_types', function ($controls) {
        $controls['web-gradients']        = "\\OnePageExpress\\WebGradientsControl";
        $controls['sectionsetting']       = "\\OnePageExpress\\SectionSettingControl";
        $controls['sidebar-button-group'] = "\\OnePageExpress\\SidebarGroupButtonControl";
        $controls['web-fonts']            = "\\OnePageExpress\\WebFontsControl";

        return $controls;
    });
}


$__header_hero_options = array(
    "video-on-left"  => __("Video on left, text on right", "one-page-express"),
    "video-on-right" => __("Text on left, video on right", "one-page-express"),
);

function ope_pro_controls($wp_customize)
{
    ope_pro_gradient_control(true);
    ope_pro_gradient_control(false);


    $wp_customize->add_section('general_site_style', array(
        'title'      => __('Typography', 'one-page-express-pro'),
        'panel'      => 'general_settings',
        'capability' => 'edit_theme_options',
    ));

    $wp_customize->add_section('user_custom_widgets_areas', array(
        'title'      => __('Manage Custom Widgets Areas', 'one-page-express-pro'),
        'priority'   => 100,
        'panel'      => 'general_settings',
        'capability' => 'edit_theme_options',
    ));


    $wp_customize->add_section('ope_pro_blog_settings', array(
        'title'      => __('Blog Options', 'one-page-express-pro'),
        'priority'   => 101,
        'panel'      => 'general_settings',
        'capability' => 'edit_theme_options',
    ));

    Kirki::add_field('one_page_express', array(
        'type'        => 'checkbox',
        'settings'    => 'ope_show_post_meta',
        'label'       => __('Show Post Meta ', 'one-page-express-pro'),
        'description' => __('Display post author, date and comments number', 'one-page-express-pro'),
        'section'     => 'ope_pro_blog_settings',
        'default'     => '1',
        'priority'    => 10,
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Header General Options', 'one-page-express'),
        'section'  => 'one_page_express_header_content',
        'settings' => "ope_pro_header_general_options_separator",
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'sidebar-button-group',
        'settings' => 'ope_header_title_style',
        'label'    => esc_html__('Title Style', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        "priority" => 2,
        "choices"  => array(
            "header_content_title_typography",
            "header_content_title_spacing",

            "one_page_express_header_text_morph_separator",
            "one_page_express_header_show_text_morph_animation",
            "one_page_express_header_show_text_morph_animation_info",
            "one_page_express_header_text_morph_speed",
            "one_page_express_header_text_morph_alternatives",
        ),
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'sidebar-button-group',
        'settings' => 'ope_header_subtitle_style',
        'label'    => esc_html__('Subtitle Style', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        "priority" => 2,
        "choices"  => array(
            "header_content_subtitle_typography",
            "header_content_subtitle_spacing",
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'sidebar-button-group',
        'settings' => 'ope_header_subtitle_style2',
        'label'    => esc_html__('Subtitle Style', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        "priority" => 2,
        "choices"  => array(
            "header_content_subtitle_typography2",
            "header_content_subtitle_spacing2",
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'sidebar-button-group',
        'settings' => 'ope_header_content_box_style',
        'label'    => esc_html__('Text box settings', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        "priority" => 2,
        "choices"  => array(
            "one_page_express_header_text_align",
            "one_page_express_header_content_width",
            "header_content_text_vertical_align",
            "one_page_express_header_customize_content_box",
            "one_page_express_header_content_border_color",
            "one_page_express_header_content_border_width",
            "one_page_express_header_content_border_style",
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'sidebar-button-group',
        'settings'        => 'ope_header_media_box_settings',
        'label'           => esc_html__('Media box settings', 'one-page-express'),
        'section'         => "one_page_express_header_content",
        "priority"        => 2,
        "choices"         => array(
            "header_content_media_vertical_align",
            "one_page_express_header_content_image",
            "one_page_express_header_content_image_rounded",


            "ope_pro_header_content_video",

            "one_page_express_header_color_video_popup_button",
            "one_page_express_header_color_video_popup_button_hover",

            "one_page_express_header_video_popup_image_disabled",
            "one_page_express_header_video_popup_image",


            "one_page_express_header_video_popup_overlay_color",
            "one_page_express_header_column_width",
            "header_content_media_spacing",

            "header_content_video_img_shadow",
        ),
        'active_callback' => array(
            array(
                'setting'  => 'ope_header_content_layout',
                'operator' => 'contains',
                'value'    => 'media-on-',
            ),
        ),
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Header Buttons', 'one-page-express'),
        'section'  => 'one_page_express_header_content',
        'settings' => "ope_pro_header_buttons_type_separator",
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'sidebar-button-group',
        'settings'        => 'ope_header_buttons_group',
        'label'           => esc_html__('Buttons Settings', 'one-page-express'),
        'section'         => "one_page_express_header_content",
        "priority"        => 2,
        "choices"         => array(

            "one_page_express_header_content_primary_button_separator",
            "one_page_express_header_show_btn_1",
            "one_page_express_header_btn_1_label",
            "one_page_express_header_btn_1_url",

            "one_page_express_header_content_secondary_button_separator",
            "one_page_express_header_show_btn_2",
            "one_page_express_header_btn_2_label",
            "one_page_express_header_btn_2_url",

            "ope_store_badges",
            "ope_pro_multiple_buttons",

        ),
        'active_callback' => array(
            array(
                'setting'  => 'ope_pro_header_buttons_type',
                'operator' => '!=',
                'value'    => 'none',
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'repeater',
        'settings' => 'ope_pro_multiple_buttons',
        'label'    => esc_html__('Buttons', 'one-page-express'),
        'section'  => "one_page_express_header_content",
        "priority" => 2,
        "default"  => get_normal_buttons_options(),

        'row_label' => array(
            'type'  => 'text',
            'value' => esc_attr__('Button', 'one-page-express'),
        ),
        "fields"    => array(
            "label"  => array(
                'type'    => 'hidden',
                'label'   => esc_attr__('Link', 'one-page-express'),
                'default' => 'Action Button',
            ),
            "target" => array(
                'type'    => 'hidden',
                'label'   => esc_attr__('Link', 'one-page-express'),
                'default' => '_self',
            ),
            "url"    => array(
                'type'    => 'hidden',
                'label'   => esc_attr__('Link', 'one-page-express'),
                'default' => '#',
            ),

            "class" => array(
                'type'    => 'hidden',
                'label'   => esc_attr__('Link', 'one-page-express'),
                'default' => 'button blue big',
            ),
        ),

        'active_callback' => array(
            array(
                'setting'  => 'ope_pro_header_buttons_type',
                'operator' => '==',
                'value'    => 'multiple_buttons',
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'            => 'repeater',
        'settings'        => 'ope_store_badges',
        'label'           => esc_html__('Store Badges', 'one-page-express'),
        'section'         => "one_page_express_header_content",
        "priority"        => 2,
        "default"         => array(
            array(
                'store' => 'google-store',
                'link'  => '#',
            ),
            array(
                'store' => 'apple-store',
                'link'  => '#',
            ),
        ),
        'row_label'       => array(
            'type'  => 'field',
            'field' => 'store',
            'value' => esc_attr__('Store Badge', 'one-page-express'),
        ),
        "fields"          => array(
            "store" => array(
                "type"    => "select",
                'label'   => esc_attr__('Badge Type', 'one-page-express'),
                "choices" => array(
                    "google-store" => "Google Play Badge",
                    "apple-store"  => "App Store Badge",
                ),
                "default" => "google-store",
            ),
            'link'  => array(
                'type'    => 'text',
                'label'   => esc_attr__('Link', 'one-page-express'),
                'default' => '#',
            ),
        ),
        'choices'         => array(
            'limit' => 2,
        ),
        'active_callback' => array(
            array(
                'setting'  => 'ope_pro_header_buttons_type',
                'operator' => '==',
                'value'    => 'store',
            ),
        ),
    ));


    // inner

    Kirki::add_field('one_page_express', array(
        'type'     => 'sidebar-button-group',
        'settings' => 'header_content_inner_title_typography_group',
        'label'    => esc_html__('Title Style', 'one-page-express'),
        'section'  => "one_page_express_inner_header_content",
        "priority" => 2,
        "choices"  => array(
            "header_content_inner_title_typography",
        ),
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'sidebar-button-group',
        'settings' => 'header_content_inner_subtitle_typography_group',
        'label'    => esc_html__('Subtitle Style', 'one-page-express'),
        'section'  => "one_page_express_inner_header_content",
        "priority" => 2,
        "choices"  => array(
            "header_content_inner_subtitle_typography",
        ),
    ));

}

function ope_pro_controls_custom_mods($wp_customize)
{
    global $ope_custom_mods;

    foreach ((array)$ope_custom_mods as $item) {
        if (isset($item['mod'])) {
            $wp_customize->remove_control($item['mod']);
            $wp_customize->remove_setting($item['mod']);
        }


        if (isset($item['atts'])) {
            foreach ($item['atts'] as $mod) {
                $wp_customize->remove_control($mod);
                $wp_customize->remove_setting($mod);
            }
        }
    }
}

function ope_pro_gradient_control($inner)
{
    $prefix  = $inner ? "one_page_express_inner_header" : "one_page_express_header";
    $section = $inner ? "header_image" : "one_page_express_header_background_chooser";

    Kirki::add_field('one_page_express', array(
        'type'      => 'web-gradients',
        'settings'  => $prefix . '_gradient',
        'label'     => esc_html__('Header Gradient', 'one-page-express'),
        'section'   => $section,
        'default'   => 'plum_plate',
        "priority"  => 2,
        'transport' => 'postMessage',
    ));
}


add_action("get_template_part_template-parts/header/hero", "ope_change_hero_path_to_pro", 10, 2);

function ope_change_hero_path_to_pro($slug, $name)
{
    global $__header_hero_options;
    if (isset($__header_hero_options[$name])) {
        $slug = get_stylesheet_directory() . $slug;
        get_template_part($slug, $name);
    }
}

function ope_pro_order($wp_customize)
{


    $c        = $wp_customize->get_control('one_page_express_header_nav_header_1');
    $c->label = __('Front Page Navigation Options', 'one-page-express');


    $s        = $wp_customize->get_section('background_image');
    $s->title = __('Page Background', 'one-page-express');

    $c                  = $wp_customize->get_control('background_color');
    $c->active_callback = "__return_false";


    $c        = $wp_customize->get_control('one_page_express_inner_header_nav_header_1');
    $c->label = __('Inner Page Navigation Options', 'one-page-express');


    $c        = $wp_customize->get_control('one_page_express_header_nav_transparent');
    $c->label = __('Transparent navigation bar', 'one-page-express');

    $c        = $wp_customize->get_control('one_page_express_inner_header_nav_transparent');
    $c->label = __('Transparent navigation bar', 'one-page-express');


    $wp_customize->remove_control('one_page_express_header_content_box_separator');


    // front page content
    $controls = array(
        "one_page_express_header_content_separator",
        "ope_header_content_layout",
        "ope_header_content_media",


        "one_page_express_header_spacing",


        // content box style
        "ope_header_content_box_style", // content box settings


        "one_page_express_header_text_align",


        // media box settings
        "ope_header_media_box_settings",

        "header_content_vertical_align",


        "one_page_express_header_content_image",
        "ope_pro_header_content_video",
        "one_page_express_header_column_width",
        "header_content_media_spacing",
        "header_content_video_img_shadow",

        // subtitle 2
        "one_page_express_header_content_subtitle_separator2",
        "one_page_express_header_show_subtitle2",
        "ope_header_subtitle_style2",

        // title
        "one_page_express_header_content_title_separator",
        "one_page_express_header_show_title",
        "one_page_express_header_title",
        "ope_header_title_style", // pro
        "header_content_title_typography", //pro
        "header_content_title_spacing",


        // subtitle
        "one_page_express_header_content_subtitle_separator",
        "one_page_express_header_show_subtitle",
        "one_page_express_header_subtitle",
        "header_content_subtitle_typography", // pro
        "ope_header_subtitle_style", // pro
        "header_content_subtitle_spacing",

        "ope_pro_header_buttons_type_separator",
        "ope_pro_header_buttons_type",

        "ope_header_buttons_group",


        "one_page_express_header_content_primary_button_separator",
        "one_page_express_header_show_btn_1",
        "one_page_express_header_btn_1_label",
        "one_page_express_header_btn_1_url",

        "one_page_express_header_content_secondary_button_separator",
        "one_page_express_header_show_btn_2",
        "one_page_express_header_btn_2_label",
        "one_page_express_header_btn_2_url",


    );

    foreach ($controls as $control) {
        $c = $wp_customize->get_control($control);
        if ($c) {
            $c->priority = ope_next_priority('one_page_express_header_content');
            $c->section  = 'one_page_express_header_content';
        }
    }


    // frontpage background panel
    $controls = array(
        "one_page_express_header_header_1",

        "one_page_express_header_background_type",
        "one_page_express_header_image",

        "one_page_express_header_parallax",

        "one_page_express_header_video",
        "one_page_express_header_video_external",
        "one_page_express_header_video_poster",

        "one_page_express_header_gradient",
        "one_page_express_header_gradient_pro_info",
        "one_page_express_header_slideshow",
        "one_page_express_header_slideshow_duration",
        "one_page_express_header_slideshow_speed",


        "ope_pro_header_general_options_separator",
        "one_page_express_full_height",
        "one_page_express_front_page_header_overlap",
        "one_page_express_front_page_header_overlap_info",
        "one_page_express_front_page_header_margin",


        "one_page_express_header_overlay_header",
        "one_page_express_header_show_overlay",
        "one_page_express_header_overlay_color",
        "one_page_express_header_overlay_opacity",

        "one_page_express_header_separator_header",
        "one_page_express_header_show_separator",
        "one_page_express_header_separator",
        "one_page_express_header_separator_height",
        "one_page_express_header_separator_color",

        "one_page_express_header_show_bottom_arrow_separator",
        "one_page_express_header_show_bottom_arrow",
        "one_page_express_header_bottom_arrow",

        "one_page_express_header_size_bottom_arrow",
        "one_page_express_header_offset_bottom_arrow",
        "one_page_express_header_color_bottom_arrow",
        "one_page_express_header_background_bottom_arrow",
        "one_page_express_header_bounce_bottom_arrow",


    );

    ope_sort_controls_in_section("one_page_express_header_background_chooser", $controls);

    $headerPanel        = $wp_customize->get_panel('one_page_express_header');
    $headerPanel->title = __('Header Settings', 'one-page-express-pro');


    $footerPanel        = $wp_customize->get_panel('one_page_express_footer');
    $footerPanel->title = __('Footer Settings', 'one-page-express-pro');


    $generalSectionsOrder = array(
        "title_tagline",
        "colors",
        "general_site_style",
        "background_image",
        "static_front_page",
        "custom_css",
    );

    ope_sort_section_in_panel('general_settings', $generalSectionsOrder);


    // inner header content

    $innerSettingsOrder = array(
        "header_content_inner_typography_title_sep",
        "one_page_express_inner_header_text_align",
        "one_page_express_inner_header_show_subtitle",

        "header_content_inner_title_typography_group",
        "header_content_inner_subtitle_typography_group",

        "header_content_inner_layout_sep",
        "one_page_express_inner_header_spacing",
        "one_page_express_blog_header_overlap",
        "one_page_express_blog_header_margin",

    );

    ope_sort_controls_in_section('one_page_express_inner_header_content', $innerSettingsOrder);
}


add_filter('kirki/fields', 'ope_pro_kirki_override');
function ope_pro_kirki_override($fields)
{
    $header_buttons_controls = array(
        "one_page_express_header_content_primary_button_separator",
        "one_page_express_header_show_btn_1",
        "one_page_express_header_btn_1_label",
        "one_page_express_header_btn_1_url",

        "one_page_express_header_content_secondary_button_separator",
        "one_page_express_header_show_btn_2",
        "one_page_express_header_btn_2_label",
        "one_page_express_header_btn_2_url",
    );

    foreach ($header_buttons_controls as $button_control) {
        if (isset(Kirki::$fields[$button_control])) {
            $c                              = Kirki::$fields[$button_control];
            $c['required']                  = array(
                array(
                    'setting'  => 'ope_pro_header_buttons_type',
                    'operator' => '===',
                    'value'    => 'normal',
                ),
            );
            $c['active_callback']           = array('Kirki_Active_Callback', 'evaluate');
            Kirki::$fields[$button_control] = $c;
        }
    }

    if (isset(Kirki::$fields['ope_header_content_layout'])) {

        Kirki::$fields['ope_header_content_layout']['default'] = "content-on-center";
    }

    if (isset(Kirki::$fields['one_page_express_header_spacing'])) {

        Kirki::$fields['one_page_express_header_spacing']['default']['bottom'] = "10%";
    }

//    $defaults = array();

//    foreach (Kirki::$fields as $key => $field) {
//        $defaults[$key] = @Kirki::$fields[$key]['default'];
//    }

//    $d        = require ABSPATH . "/wp-content/plugins/mods-exporter/defaults.php";
//    $defaults = array_merge($defaults, $d);
//    var_export($defaults);
//    die();

    return $fields;

}


function ope_pro_navigation_order($wp_customize)
{
    // header navigation section
    $navControls = array(
        "nav_header_1",
        "nav_transparent",
        "nav_sticked",
        "nav_boxed",
        "nav_border",

    );


    $proNavControls = array(
        "ope_header_nav_bar_color",

        "header_nav_title_typography_sep",
        "header_nav_menu_color",
        "header_nav_sticky_title_typography",

        "ope_header_nav_bar_typo_group",
        "header_nav_title_typography",

        "navigation_submenu_separator",
        "navigation_submenu_item_color",
        "navigation_submenu_item_hover_color",
        "navigation_submenu_item_text_color",
        "navigation_submenu_item_typography",
        "navigation_submenu_item_typography_group",

        "header_text_logo_title_typography_sep",
        "header_text_logo_color",
        "header_text_logo_sticky_typography",

        "ope_header_nav_logo_typo_group",
        "header_text_logo_title_typography",


    );

    foreach ($navControls as $control) {
        $c = $wp_customize->get_control("one_page_express_header_{$control}");

        if ($c) {
            $c->priority = ope_next_priority('ope_pro_navigation');
            $c->section  = 'ope_pro_navigation';
        }


        $c = $wp_customize->get_control("one_page_express_inner_header_{$control}");

        if ($c) {
            $c->priority = ope_next_priority('inner_ope_pro_navigation');
            $c->section  = 'inner_ope_pro_navigation';
        }

    }

    foreach ($proNavControls as $control) {
        $c = $wp_customize->get_control($control);

        if ($c) {
            $c->priority = ope_next_priority('ope_pro_navigation');
            $c->section  = 'ope_pro_navigation';
        }

        $c = $wp_customize->get_control("inner_" . $control);

        if ($c) {
            $c->priority = ope_next_priority('inner_ope_pro_navigation');
            $c->section  = 'inner_ope_pro_navigation';
        }

    }

}
