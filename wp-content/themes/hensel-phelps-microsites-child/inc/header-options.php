<?php

Kirki::add_field('one_page_express', array(
    'type'      => 'typography',
    'settings'  => 'header_content_title_typography',
    'label'     => __('Title Typography', 'one-page-express'),
    'section'   => 'one_page_express_header_content',
    'default'   => array(
        'font-family'      => 'Source Sans Pro',
        'font-size'        => '3.3em',
        'mobile-font-size' => '3.3em',
        'variant'          => '600',
        'line-height'      => '115%',
        'letter-spacing'   => 'normal',
        'subsets'          => array(),
        'color'            => '#ffffff',
        'text-transform'   => 'uppercase',
        'addwebfont'       => true,
    ),
    'output'    => array(
        array(
            'element' => '.header-homepage h1.heading8',
        ),
    ),
    'transport' => 'postMessage',
    'js_vars'   => array(
        array(
            'element' => ".header-homepage h1.heading8",
        ),
    ),
));

Kirki::add_field('one_page_express', array(
    'type'      => 'spacing',
    'settings'  => 'header_content_title_spacing',
    'label'     => __('Title Spacing', 'one-page-express'),
    'section'   => 'one_page_express_header_content',
    'default'   => array(
        'top'    => '0',
        'bottom' => '25px',
    ),
    'transport' => 'postMessage',
    'output'    => array(
        array(
            'element'  => '.header-homepage h1.heading8',
            'property' => 'margin',
        ),
    ),
    'js_vars'   => array(
        array(
            'element'  => ".header-homepage h1.heading8",
            'function' => 'style',
            'property' => 'margin',
        ),
    ),
));

Kirki::add_field('one_page_express', array(
    'type'      => 'typography',
    'settings'  => 'header_content_subtitle_typography',
    'label'     => __('Subtitle Typography', 'one-page-express'),
    'section'   => 'one_page_express_header_content',
    'default'   => array(
        'font-family'     => 'Source Sans Pro',
        'font-size'       => '1.4em',
        'mobie-font-size' => '1.4em',
        'variant'         => '300',
        'line-height'     => '130%',
        'letter-spacing'  => 'normal',
        'subsets'         => array(),
        'color'           => '#ffffff',
        'text-transform'  => 'none',
        'addwebfont'      => true,
    ),
    'output'    => array(
        array(
            'element' => '.header-homepage p.header-subtitle',
        ),
    ),
    'transport' => 'postMessage',
    'js_vars'   => array(
        array(
            'element' => '.header-homepage p.header-subtitle',
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'      => 'spacing',
    'settings'  => 'header_content_subtitle_spacing',
    'label'     => __('Subtitle Spacing', 'one-page-express'),
    'section'   => 'one_page_express_header_content',
    'default'   => array(
        'top'    => '0',
        'bottom' => '20px',
    ),
    'transport' => 'postMessage',
    'output'    => array(
        array(
            'element'  => '.header-homepage p.header-subtitle',
            'property' => 'margin',
        ),
    ),
    'js_vars'   => array(
        array(
            'element'  => ".header-homepage p.header-subtitle",
            'function' => 'style',
            'property' => 'margin',
        ),
    ),
));

Kirki::add_field('one_page_express', array(
    'type'     => 'sectionseparator',
    'label'    => __('Title Settings', 'one-page-express-pro'),
    'section'  => 'one_page_express_inner_header_content',
    'settings' => "header_content_inner_typography_title_sep",
));

//Kirki::add_field('one_page_express', array(
//    'type'     => 'sectionseparator',
//    'label'    => __('Texts colors', 'one-page-express-pro'),
//    'section'  => 'one_page_express_inner_header_content',
//    'settings' => "header_content_inner_typography_sep",
//));
//));

Kirki::add_field('one_page_express', array(
    'type'     => 'sectionseparator',
    'label'    => __('Layout Settings', 'one-page-express-pro'),
    'section'  => 'one_page_express_inner_header_content',
    'settings' => "header_content_inner_layout_sep",
));

Kirki::add_field('one_page_express', array(
    'type'      => 'typography',
    'settings'  => 'header_content_inner_title_typography',
    'label'     => __('Title Typography', 'one-page-express'),
    'section'   => 'one_page_express_inner_header_content',
    'default'   => array(
        'font-family'      => 'Source Sans Pro',
        'font-size'        => '3.3em',
        'mobile-font-size' => '3.3em',
        'variant'          => '600',
        'line-height'      => '115%',
        'letter-spacing'   => 'normal',
        'subsets'          => array(),
        'color'            => '#ffffff',
        'text-transform'   => 'uppercase',
        'addwebfont'       => true,
    ),
    'output'    => array(
        array(
            'element' => '.header:not(.header-homepage) h1.heading8',
        ),
    ),
    'transport' => 'postMessage',
    'js_vars'   => array(
        array(
            'element' => '.header:not(.header-homepage) h1.heading8',
        ),
    ),
));

Kirki::add_field('one_page_express', array(
    'type'      => 'typography',
    'settings'  => 'header_content_inner_subtitle_typography',
    'label'     => __('Sub Title Typography', 'one-page-express'),
    'section'   => 'one_page_express_inner_header_content',
    'default'   => array(
        'font-family'      => 'Source Sans Pro',
        'font-size'        => '1.3em',
        'mobile-font-size' => '1.3em',
        'variant'          => '300',
        'line-height'      => '150%',
        'letter-spacing'   => 'normal',
        'subsets'          => array(),
        'color'            => '#ffffff',
        'text-transform'   => 'uppercase',
        'addwebfont'       => true,
    ),
    'output'    => array(
        array(
            'element' => '.header:not(.header-homepage) p.header-subtitle',
        ),
    ),
    'transport' => 'postMessage',
    'js_vars'   => array(
        array(
            'element' => '.header:not(.header-homepage) p.header-subtitle',
        ),
    ),
));


function ope_pro_media_type_choices($data)
{
    $companion = \OnePageExpress\Companion::instance();
    $sections  = $companion->getCustomizerData("data:sections");


    foreach ($sections as $section) {
        if ($section['category'] === "header-contents") {
            $choice        = "header_contents|" . $section['id'];
            $data[$choice] = $section['name'];
        }
    }

    return $data;
}


Kirki::add_field('one_page_express', array(
    'type'            => 'select',
    'settings'        => 'ope_header_content_media',
    'label'           => esc_html__('Media Type', 'one-page-express'),
    'section'         => 'one_page_express_header_content',
    'default'         => 'image',
    'choices'         => apply_filters('ope_pro_media_type_choices', array(
        "image"       => __("Image", "one-page-express"),
        "video"       => __("Video", "one-page-express"),
        "video_popup" => __("Video Popup Button", "one-page-express"),
    )),
    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_layout',
            'operator' => 'contains',
            'value'    => 'media-on-',
        ),
    ),
));

Kirki::add_field('one_page_express', array(
    'type'            => 'text',
    'settings'        => 'ope_pro_header_content_video',
    'label'           => __('Content Video', 'one-page-express'),
    'section'         => 'one_page_express_header_content',
    'default'         => 'https://www.youtube.com/watch?v=3iXYciBTQ0c',
    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_media',
            'operator' => 'contains',
            'value'    => 'video',
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'            => 'image',
    'settings'        => 'one_page_express_header_content_image',
    'label'           => __('Image', 'one-page-express'),
    'section'         => 'one_page_express_header_content',
    'default'         => get_template_directory_uri() . "/assets/images/project1.jpg",
    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_media',
            'operator' => '==',
            'value'    => 'image',
        ),
    ),


));


Kirki::add_field('one_page_express', array(
    'type'     => 'slider',
    'label'    => __('Media width', 'one-page-express'),
    'section'  => "one_page_express_header_content",
    'settings' => 'one_page_express_header_column_width',

    'choices' => array(
        'min'  => 0,
        'max'  => 100,
        'step' => 1,
    ),

    'default' => 50,

    'transport' => 'postMessage',

    "output" => array(
        array(
            "element"     => ".header-description-left",
            "property"    => "width",
            'suffix'      => '%!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),
        array(
            "element"     => ".header-description-right",
            "property"    => "width",
            "function"    => "style",
            'prefix'      => 'calc(100% - ',
            'suffix'      => '%)!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),
    ),


    "js_vars" => array(
        array(
            "element"     => ".header-description-left",
            "function"    => "style",
            "property"    => "width",
            'suffix'      => '%!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),
        array(
            "element"     => ".header-description-right",
            "property"    => "width",
            "function"    => "style",
            'prefix'      => 'calc(100% - ',
            'suffix'      => '% )!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),
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
    'type'     => 'slider',
    'label'    => __('Media column width', 'one-page-express'),
    'section'  => "one_page_express_header_content",
    'settings' => 'one_page_express_header_column_width',

    'choices' => array(
        'min'  => 0,
        'max'  => 100,
        'step' => 1,
    ),

    'default' => 50,

    'transport' => 'postMessage',

    "output" => array(
        array(
            "element"     => ".header-description-left",
            "property"    => "width",
            'suffix'      => '%!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),

        array(
            "element"     => ".header-description-right",
            "property"    => "width",
            "function"    => "style",
            'prefix'      => 'calc(100% - ',
            'suffix'      => '%)!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),
        // top - bottom media
        array(
            "element"     => ".header-media-container",
            "property"    => "width",
            'suffix'      => '%!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),
    ),


    "js_vars" => array(
        array(
            "element"     => ".header-description-left",
            "function"    => "style",
            "property"    => "width",
            'suffix'      => '%!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),

        array(
            "element"     => ".header-description-right",
            "property"    => "width",
            "function"    => "style",
            'prefix'      => 'calc(100% - ',
            'suffix'      => '% )!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),

        // top - bottom media
        array(
            "element"     => ".header-media-container",
            "function"    => "style",
            "property"    => "width",
            'suffix'      => '%!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),
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
    'type'      => 'spacing',
    'settings'  => 'header_content_media_spacing',
    'label'     => __('Media Box Spacing', 'one-page-express'),
    'section'   => 'one_page_express_header_content',
    'default'   => array(
        'top'    => '0px',
        'bottom' => '0px',
    ),
    'transport' => 'postMessage',
    'output'    => array(
        array(
            'element'  => '.header-description-bottom.media, .header-description-top.media',
            'property' => 'margin',
        ),
    ),
    'js_vars'   => array(
        array(
            'element'  => '.header-description-bottom.media, .header-description-top.media',
            'function' => 'style',
            'property' => 'margin',
        ),
    ),

    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_layout',
            'operator' => 'in',
            'value'    => array('media-on-top', 'media-on-bottom'),
        ),
    ),
));


// ANIMATION + ARROW

Kirki::add_field('one_page_express', array(
    'type'     => 'sectionseparator',
    'label'    => __('Bottom Arrow', 'one-page-express'),
    'section'  => "one_page_express_header_background_chooser",
    'settings' => "one_page_express_header_show_bottom_arrow_separator",
));

Kirki::add_field('one_page_express', array(
    'type'     => 'checkbox',
    'settings' => 'one_page_express_header_show_bottom_arrow',
    'label'    => __('Show bottom arrow', 'one-page-express'),
    'section'  => 'one_page_express_header_background_chooser',
    'default'  => false,
));
Kirki::add_field('one_page_express', array(
    'type'            => 'font-awesome-icon-control',
    'settings'        => 'one_page_express_header_bottom_arrow',
    'label'           => __('Icon', 'one-page-express'),
    'section'         => 'one_page_express_header_background_chooser',
    'default'         => "fa-angle-down",
    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_header_show_bottom_arrow',
            'operator' => '==',
            'value'    => true,
        ),
    ),
));

Kirki::add_field('one_page_express', array(
    'type'            => 'slider',
    'settings'        => 'one_page_express_header_size_bottom_arrow',
    'label'           => __('Icon Size', 'one-page-express'),
    'section'         => 'one_page_express_header_background_chooser',
    'default'         => "50",
    'choices'         => array(
        'min'  => '10',
        'max'  => '100',
        'step' => '1',
    ),
    "output"          => array(
        array(
            'element'  => '.header-homepage-arrow',
            'property' => 'font-size',
            'suffix'   => 'px !important',
        ),
    ),
    'transport'       => 'postMessage',
    'js_vars'         => array(
        array(
            'element'  => '.header-homepage-arrow',
            'function' => 'css',
            'property' => 'font-size',
            'suffix'   => 'px !important',
        ),
    ),
    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_header_show_bottom_arrow',
            'operator' => '==',
            'value'    => true,
        ),
    ),
    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_header_show_bottom_arrow',
            'operator' => '==',
            'value'    => true,
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'            => 'slider',
    'settings'        => 'one_page_express_header_offset_bottom_arrow',
    'label'           => __('Icon Bottom Offset', 'one-page-express'),
    'section'         => 'one_page_express_header_background_chooser',
    'default'         => "20",
    'choices'         => array(
        'min'  => '0',
        'max'  => '200',
        'step' => '1',
    ),
    "output"          => array(
        array(
            'element'  => '.header-homepage-arrow',
            'property' => 'bottom',
            'suffix'   => 'px !important',
        ),
    ),
    'transport'       => 'postMessage',
    'js_vars'         => array(
        array(
            'element'  => '.header-homepage-arrow',
            'function' => 'css',
            'property' => 'bottom',
            'suffix'   => 'px !important',
        ),
    ),
    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_header_show_bottom_arrow',
            'operator' => '==',
            'value'    => true,
        ),
    ),
    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_header_show_bottom_arrow',
            'operator' => '==',
            'value'    => true,
        ),
    ),
));

Kirki::add_field('one_page_express', array(
    'type'            => 'color',
    'settings'        => 'one_page_express_header_color_bottom_arrow',
    'label'           => __('Icon Color', 'one-page-express'),
    'section'         => 'one_page_express_header_background_chooser',
    'default'         => "#ffffff",
    'choices'         => array(
        'alpha' => true,
    ),
    "output"          => array(
        array(
            'element'  => '.header-homepage-arrow',
            'property' => 'color',
        ),
    ),
    'transport'       => 'postMessage',
    'js_vars'         => array(
        array(
            'element'  => '.header-homepage-arrow',
            'function' => 'css',
            'property' => 'color',
            'suffix'   => ' !important',
        ),
    ),
    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_header_show_bottom_arrow',
            'operator' => '==',
            'value'    => true,
        ),
    ),
));

Kirki::add_field('one_page_express', array(
    'type'            => 'color',
    'settings'        => 'one_page_express_header_background_bottom_arrow',
    'label'           => __('Icon Background Color', 'one-page-express'),
    'section'         => 'one_page_express_header_background_chooser',
    'default'         => "rgba(255,255,255,0)",
    'choices'         => array(
        'alpha' => true,
    ),
    "output"          => array(
        array(
            'element'  => '.header-homepage-arrow',
            'property' => 'background-color',
        ),
    ),
    'transport'       => 'postMessage',
    'js_vars'         => array(
        array(
            'element'  => '.header-homepage-arrow',
            'function' => 'css',
            'property' => 'background-color',
            'suffix'   => ' !important',
        ),
    ),
    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_header_show_bottom_arrow',
            'operator' => '==',
            'value'    => true,
        ),
    ),
));

/* Animation section */
Kirki::add_field('one_page_express', array(
    'type'     => 'sectionseparator',
    'label'    => __('Text Animation', 'one-page-express'),
    'section'  => "one_page_express_header_content",
    'settings' => "one_page_express_header_text_morph_separator",
));

Kirki::add_field('one_page_express', array(
    'type'     => 'checkbox',
    'settings' => 'one_page_express_header_show_text_morph_animation',
    'label'    => __('Enable text animation', 'one-page-express'),
    'section'  => 'one_page_express_header_content',
    'default'  => false,
));

Kirki::add_field('one_page_express', array(
    'type'            => 'ope-info',
    'label'           => __('The text between the curly braces will be replaced with the alternative texts in the following text area. Type one alternative text per line.', 'one-page-express'),
    'section'         => 'one_page_express_header_content',
    'settings'        => "one_page_express_header_show_text_morph_animation_info",
    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_header_show_text_morph_animation',
            'operator' => '==',
            'value'    => true,
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'            => 'textarea',
    'settings'        => 'one_page_express_header_text_morph_alternatives',
    'label'           => __('Alternative text (one per row)', 'one-page-express'),
    'section'         => 'one_page_express_header_content',
    'default'         => "some text\nsome other text",
    'transport'       => "postMessage",
    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_header_show_text_morph_animation',
            'operator' => '==',
            'value'    => true,
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'            => 'number',
    'settings'        => 'one_page_express_header_text_morph_speed',
    'label'           => __('Text Animation Speed', 'one-page-express'),
    'section'         => 'one_page_express_header_content',
    'default'         => 200,
    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_header_show_text_morph_animation',
            'operator' => '==',
            'value'    => true,
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'            => 'checkbox',
    'settings'        => 'one_page_express_header_bounce_bottom_arrow',
    'label'           => __('Bounce arrow', 'one-page-express'),
    'section'         => 'one_page_express_header_content',
    'default'         => true,
    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_header_show_bottom_arrow',
            'operator' => '==',
            'value'    => true,
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'     => 'select',
    'settings' => 'ope_pro_header_buttons_type',
    'label'    => __('Buttons Type', 'one-page-express'),
    'section'  => 'one_page_express_header_content',
    'default'  => 'normal',
    'choices'  => array(
        "none"             => __("No Button", "one-page-express-pro"),
        "normal"           => __("Main Buttons", "one-page-express-pro"),
        "multiple_buttons" => __("Custom Buttons", "one-page-express-pro"),
        "store"            => __("App Stores Buttons", "one-page-express-pro"),
    ),
));


/* Header Subtitle */

Kirki::add_field('one_page_express', array(
    'type'     => 'sectionseparator',
    'label'    => __('Subtitle 2 ( before title )', 'one-page-express'),
    'section'  => "one_page_express_header_content",
    'settings' => "one_page_express_header_content_subtitle_separator2",
));

Kirki::add_field('one_page_express', array(
    'type'     => 'checkbox',
    'settings' => 'one_page_express_header_show_subtitle2',
    'label'    => __('Show subtitle 2', 'one-page-express'),
    'section'  => 'one_page_express_header_content',
    'default'  => false,
));


// subtitle 2

Kirki::add_field('one_page_express', array(
    'type'      => 'typography',
    'settings'  => 'header_content_subtitle_typography2',
    'label'     => __('Subtitle Typography', 'one-page-express'),
    'section'   => 'one_page_express_header_content',
    'default'   => array(
        'font-family'      => 'Source Sans Pro',
        'font-size'        => '1.4em',
        'mobile-font-size' => '1.4em',
        'variant'          => '300',
        'line-height'      => '130%',
        'letter-spacing'   => 'normal',
        'subsets'          => array(),
        'color'            => '#ffffff',
        'text-transform'   => 'none',
        'addwebfont'       => true,
    ),
    'output'    => array(
        array(
            'element' => '.header-homepage p.header-subtitle2',
        ),
    ),
    'transport' => 'postMessage',
    'js_vars'   => array(
        array(
            'element' => '.header-homepage p.header-subtitle2',
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'      => 'spacing',
    'settings'  => 'header_content_subtitle_spacing2',
    'label'     => __('Subtitle Spacing', 'one-page-express'),
    'section'   => 'one_page_express_header_content',
    'default'   => array(
        'top'    => '0',
        'bottom' => '20px',
    ),
    'transport' => 'postMessage',
    'output'    => array(
        array(
            'element'  => '.header-homepage p.header-subtitle2',
            'property' => 'margin',
        ),
    ),
    'js_vars'   => array(
        array(
            'element'  => ".header-homepage p.header-subtitle2",
            'function' => 'style',
            'property' => 'margin',
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'      => 'select',
    'settings'  => 'header_content_media_vertical_align',
    'label'     => __('Media Vertical Align', 'one-page-express'),
    'section'   => 'one_page_express_header_content',
    'default'   => 'center',
    'transport' => 'postMessage',
    'choices'   => array(
        'flex-start' => __('Top', 'one-page-express-pro'),
        'center'     => __('Middle', 'one-page-express-pro'),
        'flex-end'   => __('Bottom', 'one-page-express-pro'),
    ),

    'output'  => array(
        array(
            'element'     => '.header-description-left',
            'property'    => 'align-items',
            'suffix'      => '!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),

        array(
            'element'       => '.header-description-left',
            'property'      => 'display',
            'suffix'        => '!important',
            'value_pattern' => 'flex',
            "media_query"   => "@media only screen and (min-width: 768px)",
        ),
    ),
    'js_vars' => array(
        array(
            'element'  => '.header-description-left',
            'function' => 'style',
            'suffix'   => '!important',
            'property' => 'align-items',
        ),

        array(
            'element'       => '.header-description-left',
            'function'      => 'style',
            'suffix'        => '!important',
            'value_pattern' => 'flex',
            'property'      => 'display',
        ),
    ),

    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_layout',
            'operator' => 'in',
            'value'    => array('media-on-left', 'media-on-right'),
        ),
    ),

));


$ope_homepage_text_content_selector
    = '
    .image-on-left .header-description-right,
    .image-on-right .header-description-left,
    .media-on-left .header-description-right,
    .media-on-right .header-description-left, 
    .header-content
    ';

Kirki::add_field('one_page_express', array(
    'type'      => 'select',
    'settings'  => 'header_content_text_vertical_align',
    'label'     => __('Text Vertical Align', 'one-page-express'),
    'section'   => 'one_page_express_header_content',
    'default'   => 'center',
    'transport' => 'postMessage',
    'choices'   => array(
        'flex-start' => __('Top', 'one-page-express-pro'),
        'center'     => __('Middle', 'one-page-express-pro'),
        'flex-end'   => __('Bottom', 'one-page-express-pro'),
    ),
    'output'    => array(
        array(
            'element'     => $ope_homepage_text_content_selector,
            'property'    => 'align-items',
            'suffix'      => '!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),

        array(
            'element'     => $ope_homepage_text_content_selector,
            'property'    => ' align-content',
            'suffix'      => '!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),
    ),
    'js_vars'   => array(
        array(
            'element'  => $ope_homepage_text_content_selector,
            'function' => 'style',
            'suffix'   => '!important',
            'property' => 'align-items',
        ),

        array(
            'element'     => $ope_homepage_text_content_selector,
            'property'    => ' align-content',
            'suffix'      => '!important',
            "media_query" => "@media only screen and (min-width: 768px)",
        ),
    ),

    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_layout',
            'operator' => 'in',
            'value'    => array('media-on-left', 'media-on-right'),
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'      => 'select',
    'settings'  => 'header_content_vertical_align',
    'label'     => __('Content Vertical Align', 'one-page-express'),
    'section'   => 'one_page_express_header_content',
    'default'   => 'v-align-top',
    'transport' => 'postMessage',
    'choices'   => array(
        'v-align-top'    => __('Top', 'one-page-express-pro'),
        'v-align-middle' => __('Middle', 'one-page-express-pro'),
        'v-align-bottom' => __('Bottom', 'one-page-express-pro'),
    ),

    'active_callback' => array(
        array(
            'setting'  => 'one_page_express_full_height',
            'operator' => 'in',
            'value'    => array(true, 1, "1"),
        ),
    ),

));


Kirki::add_field('one_page_express', array(
    'type'     => 'checkbox',
    'settings' => 'one_page_express_header_video_popup_image_disabled',
    'label'    => __('Hide Video Poster', 'one-page-express'),
    'section'  => 'one_page_express_header_background_chooser',
    'default'  => false,

    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_media',
            'operator' => 'in',
            'value'    => array('video_popup'),
        ),

    ),
));

Kirki::add_field('one_page_express', array(
    'type'            => 'color',
    'settings'        => 'one_page_express_header_video_popup_overlay_color',
    'label'           => __('Video Poster Overlay Color', 'one-page-express'),
    'section'         => 'one_page_express_header_background_chooser',
    'default'         => "rgba(0, 0, 0, 0.5)",
    'choices'         => array(
        'alpha' => true,
    ),
    'transport'       => 'postMessage',
    "output"          => array(
        array(
            'element'  => '.video-popup-button.with-image:before',
            'property' => 'background-color',
        ),
    ),
    'js_vars'         => array(
        array(
            'element'  => '.video-popup-button.with-image:before',
            'function' => 'css',
            'property' => 'background-color',
            'suffix'   => ' !important',
        ),
    ),
    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_media',
            'operator' => 'in',
            'value'    => array('video_popup'),
        ),
    ),
));
Kirki::add_field('one_page_express', array(
        'type'            => 'image',
        'settings'        => 'one_page_express_header_video_popup_image',
        'label'           => __('Poster', 'one-page-express'),
        'section'         => 'one_page_express_header_content',
        'default'         => get_template_directory_uri() . "/assets/images/Mock-up.jpg",
        'active_callback' => array(
            array(
                'setting'  => 'ope_header_content_media',
                'operator' => '==',
                'value'    => 'video_popup',
            ),

            array(
                'setting'  => 'one_page_express_header_video_popup_image_disabled',
                'operator' => '==',
                'value'    => false,
            ),

        ),
    )
);
// image / video shadow

Kirki::add_field('one_page_express', array(
    'type'            => 'checkbox',
    'settings'        => 'header_content_video_img_shadow',
    'label'           => __('Enable media shadow', 'one-page-express'),
    'section'         => 'one_page_express_header_content',
    'default'         => true,
    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_media',
            'operator' => 'in',
            'value'    => array('image', 'video', 'video_popup'),
        ),
    ),

));


Kirki::add_field('one_page_express', array(
    'type'            => 'checkbox',
    'settings'        => 'one_page_express_header_content_image_rounded',
    'label'           => __('Make Image round', 'one-page-express'),
    'section'         => 'one_page_express_header_content',
    'default'         => false,
    'transport'       => 'postMessage',
    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_media',
            'operator' => 'in',
            'value'    => array('image',),
        ),
    ),

));

add_action('wp_head', 'print_header_content_video_img_shadow');

function print_header_content_video_img_shadow()
{

    $hasShadow = get_theme_mod('header_content_video_img_shadow', true);

    if ( ! intval($hasShadow)) {
        ?>
        <style>
            .header-description-row img.homepage-header-image,
            .header-description-row .video-popup-button img,
            .header-description-row iframe.ope-header-video {
                box-shadow: none !important;
            }
        </style>
        <?php
    }
}


// a.video-popup-button-link
Kirki::add_field('one_page_express', array(
    'type'            => 'color',
    'settings'        => 'one_page_express_header_color_video_popup_button',
    'label'           => __('Icon Color', 'one-page-express'),
    'section'         => 'one_page_express_header_background_chooser',
    'default'         => "#ffffff",
    'choices'         => array(
        'alpha' => true,
    ),
    "output"          => array(
        array(
            'element'  => 'a.video-popup-button-link',
            'property' => 'color',
        ),
    ),
    'transport'       => 'postMessage',
    'js_vars'         => array(
        array(
            'element'  => 'a.video-popup-button-link',
            'function' => 'css',
            'property' => 'color',
            'suffix'   => ' !important',
        ),
    ),
    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_media',
            'operator' => 'in',
            'value'    => array('video_popup'),
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'            => 'color',
    'settings'        => 'one_page_express_header_color_video_popup_button_hover',
    'label'           => __('Icon Hover Color', 'one-page-express'),
    'section'         => 'one_page_express_header_background_chooser',
    'default'         => "#7AA7F5",
    'choices'         => array(
        'alpha' => true,
    ),
    "output"          => array(
        array(
            'element'  => 'a.video-popup-button-link:hover',
            'property' => 'color',
        ),
    ),
    'transport'       => 'postMessage',
    'js_vars'         => array(
        array(
            'element'  => 'a.video-popup-button-link:hover',
            'function' => 'css',
            'property' => 'color',
            'suffix'   => ' !important',
        ),
    ),
    'active_callback' => array(
        array(
            'setting'  => 'ope_header_content_media',
            'operator' => 'in',
            'value'    => array('video_popup'),
        ),
    ),
));


function one_page_express_header_settings_parallax($inner)
{
    $prefix  = $inner ? "one_page_express_inner_header" : "one_page_express_header";
    $section = $inner ? "header_image" : "one_page_express_header_background_chooser";


    Kirki::add_field('one_page_express', array(
        'type'            => 'checkbox',
        'settings'        => $prefix . '_parallax',
        'label'           => __('Enable parallax effect', 'one-page-express'),
        'section'         => $section,
        'priority'        => 3,
        'default'         => true,
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
    ));

}

one_page_express_header_settings_parallax(false);
one_page_express_header_settings_parallax(true);


Kirki::add_field('one_page_express', array(
    'type'      => 'color',
    'settings'  => 'inner_page_background_color',
    'label'     => __('Page Background Color', 'one-page-express'),
    'section'   => 'background_image',
    'priority'  => 0,
    'default'   => "#ffffff",
    'choices'   => array(
        'alpha' => false,
    ),
    "output"    => array(
        array(
            'element'  => 'body.pro-inner-page',
            'property' => 'background-color',
            'suffix'   => '!important',
        ),

        array(
            'element'  => 'body.pro-inner-page #page .svg-white-bg',
            'property' => 'fill',
            'suffix'   => '',
        ),
    ),
    'transport' => 'postMessage',
    'js_vars'   => array(
        array(
            'element'  => 'body.pro-inner-page',
            'property' => 'background-color',
            'function' => 'css',
            'suffix'   => '!important',
        ),

        array(
            'element'  => 'body.pro-inner-page #page .svg-white-bg',
            'property' => 'fill',
            'function' => 'css',
            'suffix'   => '',
        ),
    ),
));


Kirki::add_field('one_page_express', array(
    'type'     => 'image',
    'settings' => 'inner_page_background_image',
    'label'    => __('Inner Page Background Image', 'one-page-express'),
    'section'  => 'background_image',
    'default'  => 'none',
    "output"   => array(
        array(
            'element'  => 'body.pro-inner-page',
            'property' => 'background-image',
            'suffix'   => '!important',
        ),

    ),


));

add_action('wp_head', 'display_inner_page_background_image');

function display_inner_page_background_image()
{
    $image = get_theme_mod('inner_page_background_image', 'none');

    if ( ! $image || $image === 'none') {
        ?>
        <style type="text/css">
            body.pro-inner-page {
                background-image: none !important;
            }
        </style>
        <?php
    }
}

add_filter('body_class', 'ope_inner_pages_pro_class');

function ope_inner_pages_pro_class($classList)
{
    if (ope_is_inner_page() || one_page_express_is_woocommerce()) {
        if ( ! in_array('pro-inner-page', $classList)) {
            $classList[] = 'pro-inner-page';
        }

    }

    return $classList;
}


function one_page_express_header_settings_bg_position($inner)
{
    $prefix  = $inner ? "one_page_express_inner_header" : "one_page_express_header";
    $section = $inner ? "header_image" : "one_page_express_header_background_chooser";


    Kirki::add_field('one_page_express', array(
        'type'            => 'select',
        'settings'        => $prefix . '_bg_position',
        'label'           => __('Background Position', 'one-page-express'),
        'section'         => $section,
        'priority'        => $inner ? 2 : 51,
        'default'         => "center center",
        'choices'         => array(
            "left top"    => "left top",
            "left center" => "left center",
            "left bottom" => "left bottom",

            "center top"    => "center top",
            "center center" => "center center",
            "center bottom" => "center bottom",

            "right top"    => "right top",
            "right center" => "right center",
            "right bottom" => "right bottom",

        ),
        "output"          => array(
            array(
                'element'  => $inner ? '.header' : '.header-homepage',
                'property' => 'background-position',
                'suffix'   => '!important',
            ),

        ),
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => $inner ? '.header' : '.header-homepage',
                'property' => 'background-position',
                'suffix'   => '!important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => $prefix . '_background_type',
                'operator' => '==',
                'value'    => 'image',
            ),
        ),
    ));

}

one_page_express_header_settings_bg_position(false);
one_page_express_header_settings_bg_position(true);


function one_page_express_header_separator_color($inner)
{

    $prefix  = $inner ? "one_page_express_inner_header" : "one_page_express_header";
    $section = $inner ? "header_image" : "one_page_express_header_background_chooser";


    Kirki::add_field('one_page_express', array(
        'type'     => 'color',
        'settings' => "{$prefix}_separator_color",
        'label'    => esc_attr__('Separator Color', 'one-page-express-pro'),
        'section'  => $section,
        'choices'  => array(
            'alpha' => true,
        ),
        'default'  => "#ffffff",
        'output'   => array(
            array(
                'element'  => $inner ? "body.page .header path.svg-white-bg" : ".header-homepage + .header-separator path.svg-white-bg",
                'property' => 'fill',
                'suffix'   => '!important',
            ),


        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => $inner ? "body.page .header path.svg-white-bg" : ".header-homepage + .header-separator path.svg-white-bg",
                'property' => 'fill',
                'suffix'   => '!important',
            ),
        ),

        'active_callback' => array(
            array(
                'setting'  => $prefix . '_show_separator',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));
}


one_page_express_header_separator_color(false);
one_page_express_header_separator_color(true);


add_filter('ope_header_background_type', 'ope_header_background_image_position', 10, 3);

function ope_header_background_image_position($types, $inner, $prefix)
{
    if (isset($types['image']) && isset($type['image']['controls'])) {
        $type['image']['control'][] = $prefix . '_bg_position';
    }

    return $types;
}


function ope_get_split_header_gradient_value($color, $angle, $size, $fade = 0)
{
    $angle          = -90 + intval($angle);
    $fade           = intval($fade) / 2;
    $transparentMax = (100 - $size) - $fade;
    $colorMin       = (100 - $size) + $fade;

    $gradient = "{$angle}deg , transparent 0%, transparent {$transparentMax}%, {$color} {$colorMin}%, {$color} 100%";

    return $gradient;
}

// print split header option
add_action('wp_head', function () {

    $defaultColor = one_page_express_get_colors('color1');
    $enabled      = get_theme_mod('split_header', false);

    if ( ! intval($enabled)) {
        return;
    }

    $color = get_theme_mod('split_header_color', $defaultColor);
    $angle = get_theme_mod('split_header_angle', 0);
    $fade  = get_theme_mod('split_header_fade', 0);
    $size  = get_theme_mod('split_header_size', 50);


    $gradient = ope_get_split_header_gradient_value($color, $angle, $size, $fade);


    $angle = get_theme_mod('split_header_angle_mobile', 90);
    $size  = get_theme_mod('split_header_size', 50);


    $mobileGradient = ope_get_split_header_gradient_value($color, $angle, $size, $fade);


    ?>
    <style>
        .header-homepage:after {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: absolute;
            z-index: -1;
            display: inline-block;
            content: "";
        }
    </style>
    <style data-name="header-split-style">
        .header-homepage:after {
            background: linear-gradient(<?php echo $mobileGradient; ?>);
            background: -webkit-linear-gradient(<?php echo $mobileGradient; ?>);
            background: linear-gradient(<?php echo $mobileGradient; ?>);

        }

        @media screen and (min-width: 1024px) {
            .header-homepage:after {
                background: linear-gradient(<?php echo $gradient; ?>);
                background: -webkit-linear-gradient(<?php echo $gradient; ?>);
                background: linear-gradient(<?php echo $gradient; ?>);

            }
        }

    </style>


    <?php
});


function one_page_express_split_header($inner = false)
{
    $prefix  = $inner ? "inner_header" : "";
    $section = $inner ? "header_image" : "one_page_express_header_background_chooser";

    $defaultColor   = one_page_express_get_colors('color1');
    $priorityOffset = 1000;

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Split Header Background', 'one-page-express-pro'),
        'section'  => $section,
        'settings' => "{$prefix}split_header_separator",
        'priority' => ope_next_priority($section, $priorityOffset),
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'checkbox',
        'label'    => __('Enable Split Header Background', 'one-page-express'),
        'section'  => $section,
        'settings' => $prefix . 'split_header',
        'default'  => false,
        'priority' => ope_next_priority($section, $priorityOffset),
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'color',
        'settings' => "{$prefix}split_header_color",
        'label'    => esc_attr__('Color', 'one-page-express-pro'),
        'section'  => $section,
        'choices'  => array(
            'alpha' => true,
        ),
        'default'  => $defaultColor,

        'transport' => 'postMessage',
        'priority'  => ope_next_priority($section),

        'active_callback' => array(
            array(
                'setting'  => $prefix . 'split_header',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'priority'        => ope_next_priority($section, $priorityOffset),
    ));


    Kirki::add_field('one_page_express', array(
        'type'      => 'slider',
        'label'     => __('Angle', 'one-page-express'),
        'section'   => $section,
        'settings'  => $prefix . 'split_header_angle',
        'default'   => 0,
        'transport' => 'postMessage',
        'choices'   => array(
            'min'  => '-180',
            'max'  => '180',
            'step' => '5',
        ),

        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => $prefix . 'split_header',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'priority'        => ope_next_priority($section, $priorityOffset),
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'slider',
        'label'     => __('Size', 'one-page-express'),
        'section'   => $section,
        'settings'  => $prefix . 'split_header_size',
        'default'   => 50,
        'transport' => 'postMessage',
        'choices'   => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '1',
        ),

        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => $prefix . 'split_header',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'priority'        => ope_next_priority($section, $priorityOffset),
    ));


    Kirki::add_field('one_page_express', array(
        'type'      => 'slider',
        'label'     => __('Angle on mobile devices', 'one-page-express'),
        'section'   => $section,
        'settings'  => $prefix . 'split_header_angle_mobile',
        'default'   => 90,
        'transport' => 'postMessage',
        'choices'   => array(
            'min'  => '-180',
            'max'  => '180',
            'step' => '5',
        ),

        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => $prefix . 'split_header',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'priority'        => ope_next_priority($section, $priorityOffset),
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'slider',
        'label'     => __('Size on mobile devices', 'one-page-express'),
        'section'   => $section,
        'settings'  => $prefix . 'split_header_size_mobile',
        'default'   => 50,
        'transport' => 'postMessage',
        'choices'   => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '1',
        ),

        'transport'       => 'postMessage',
        'active_callback' => array(
            array(
                'setting'  => $prefix . 'split_header',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'priority'        => ope_next_priority($section, $priorityOffset),
    ));


//    Kirki::add_field('one_page_express', array(
//        'type'      => 'slider',
//        'label'     => __('Fade', 'one-page-express'),
//        'section'   => $section,
//        'settings'  => $prefix . 'split_header_fade',
//        'default'   => 0,
//        'transport' => 'postMessage',
//        'choices'   => array(
//            'min'  => '0',
//            'max'  => '100',
//            'step' => '1',
//        ),
//
//        'transport'       => 'postMessage',
//        'active_callback' => array(
//            array(
//                'setting'  => $prefix . 'split_header',
//                'operator' => '==',
//                'value'    => true,
//            ),
//        ),
//         'priority' => ope_next_priority($section, $priorityOffset),
//    ));
}

//one_page_express_split_header();