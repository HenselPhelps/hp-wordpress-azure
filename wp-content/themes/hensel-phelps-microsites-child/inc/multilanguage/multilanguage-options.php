<?php

add_action('customize_register', 'one_page_express_add_multilanguage_customizer_section');

function one_page_express_add_multilanguage_customizer_section($wp_customize)
{
    $wp_customize->add_section('one_page_express_multilanguage_settings', array(
        'title'      => __('Multilanguage Options', 'ope-pro'),
        'panel'      => 'general_settings',
        'capability' => 'edit_theme_options',
    ));

}

// Controls
function add_one_page_express_multilanguage_controls()
{
    $section       = 'one_page_express_multilanguage_settings';
    $settingPrefix = "one_page_express_multilanguage_";

    Kirki::add_field('one_page_express', array(
        'type'     => 'checkbox',
        'settings' => 'one_page_express_show_language_switcher',
        'label'    => __('Show side language switcher', 'one-page-express'),
        'section'  => $section,
        'default'  => true,
    ));

//    if (function_exists('pll_current_language')) {
//        Kirki::add_field('one_page_express', array(
//            'type'     => 'checkbox',
//            'settings' => 'one_page_express_polylang_display_as_dropdown',
//            'label'    => __('Display as dropdown', 'one-page-express'),
//            'section'  => $section,
//            'default'  => false
//        ));
//    }


    Kirki::add_field('one_page_express', array(
        'type'            => 'color',
        'settings'        => "{$settingPrefix}background_color",
        'label'           => __('Switcher background color', 'one-page-express'),
        'section'         => $section,
        'default'         => "#ffffff",
        'choices'         => array(
            'alpha' => true,
        ),
        "output"          => array(
            array(
                'element'  => '.ope-language-switcher',
                'property' => 'background-color',
                'suffix'   => ' !important',
            ),
        ),
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => '.ope-language-switcher',
                'function' => 'css',
                'property' => 'background-color',
                'suffix'   => ' !important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_show_language_switcher',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));


    Kirki::add_field('one_page_express', array(
        'type'            => 'dimension',
        'settings'        => "{$settingPrefix}position",
        'label'           => __('Switcher top offset', 'one-page-express'),
        'section'         => $section,
        'default'         => "80px",
        "output"          => array(
            array(
                'element'  => '.ope-language-switcher',
                'property' => 'top',
                'suffix'   => ' !important',
            ),
        ),
        'transport'       => 'postMessage',
        'js_vars'         => array(
            array(
                'element'  => '.ope-language-switcher',
                'function' => 'css',
                'property' => 'top',
                'suffix'   => ' !important',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'one_page_express_show_language_switcher',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));
}

add_action('init', 'ope_multilanguage_settings');
function ope_multilanguage_settings()
{

    if ( ! class_exists("\Kirki")) {
        return;
    }

    add_one_page_express_multilanguage_controls();
}

