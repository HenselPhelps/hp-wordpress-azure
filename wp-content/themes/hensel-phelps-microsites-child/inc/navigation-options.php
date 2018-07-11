<?php


function ope_get_nav_menu_color_selector($inner = false, $current = false, $hover = false)
{
    $selectorsStart = array('.header-top.homepage');

    if ($inner) {
        $selectorsStart = array(".header-top:not(.homepage)", ".header-top:not(.homepage)");
    }

    $navItemSelector = array();
    foreach ($selectorsStart as $selector) {

        $item = $current ? "#drop_mainmenu>li.current_page_item" : "#drop_mainmenu>li";

        $navItemSelector[] = $selector . " {$item}>a";

        if ($hover) {
            $navItemSelector[] = $selector . " #drop_mainmenu>li:hover>a";
            $navItemSelector[] = $selector . " #drop_mainmenu>li.hover>a";
        }
        $navItemSelector[] = $selector . " a#fm2_drop_mainmenu_mobile_button .caption";
    }



    return implode(',', $navItemSelector);

}


function ope_get_sticky_nav_menu_color_selector($inner = false, $current = false, $hover = false)
{
    $selectorsStart = array('.header-top.homepage.coloured-nav', '.header-top.homepage.fixto-fixed');

    if ($inner) {
        $selectorsStart = array(".header-top.fixto-fixed:not(.homepage)", ".header-top.alternate:not(.homepage)");
    }

    $navItemSelector = array();
    foreach ($selectorsStart as $selector) {

        $item = $current ? "#drop_mainmenu>li.current_page_item" : "#drop_mainmenu>li";

        $navItemSelector[] = $selector . " {$item}>a";
        if ($hover) {
            $navItemSelector[] = $selector . " #drop_mainmenu>li:hover>a";
            $navItemSelector[] = $selector . " #drop_mainmenu>li.hover>a";
        }

        $navItemSelector[] = $selector . " a#fm2_drop_mainmenu_mobile_button .caption";
    }


    return implode(',', $navItemSelector);

}


function ope_get_nav_submenu_item_selector($inner = false, $state = false)
{
    $selectorsStart = array('.header-top.homepage');

    if ($inner) {
        $selectorsStart = array(".header-top:not(.homepage)", ".header-top:not(.homepage)");
    }

    $navItemSelector = array();
    $item            = "#drop_mainmenu ul li a";
    foreach ($selectorsStart as $selector) {


        if ( ! $state) {
            $navItemSelector[] = $selector . " {$item}";
        } else {
            if ($state === "hover") {
                $navItemSelector[] = $selector . " {$item}:hover";
                $navItemSelector[] = $selector . " {$item}.hover";
            }
        }

    }

    return implode(',', $navItemSelector);

}


function ope_get_nav_submenu_ul_selector($inner = false)
{
    $selectorsStart = array('.header-top.homepage');
    $selectorsStart = array('.header-top.homepage');

    if ($inner) {
        $selectorsStart = array(".header-top:not(.homepage)", ".header-top:not(.homepage)");
    }

    $navItemSelector = array();
    $ulSelector      = "#drop_mainmenu > li ul";
    foreach ($selectorsStart as $selector) {

        $navItemSelector[] = $selector . " {$ulSelector}";

    }

    return implode(',', $navItemSelector);

}


function ope_pro_navigation_shadow_pattern()
{
    return "0px 0px 0px $, 0px 0px 0px $";
}


function ope_get_nav_text_logo_selector($inner = false)
{
    $selectorsStart = array('.header-top.homepage.coloured-nav', '.header-top.homepage');

    if ($inner) {
        $selectorsStart = array(".header-top:not(.homepage)", ".header-top:not(.homepage)");
    }

    $logoSelector = array();
    foreach ($selectorsStart as $selector) {
        $logoSelector[] = $selector . " a.text-logo";
    }

    return implode(',', $logoSelector);
}

function ope_get_sticky_nav_text_logo_selector($inner = false)
{
    $selectorsStart = array('.header-top.homepage.fixto-fixed');

    if ($inner) {
        $selectorsStart = array(".header-top.fixto-fixed:not(.homepage)", " .header-top.alternate:not(.homepage)");
    }

    $logoSelector = array();
    foreach ($selectorsStart as $selector) {
        $logoSelector[] = $selector . " a.text-logo";
    }

    return implode(',', $logoSelector);
}

function ope_get_sticky_nav_selector($inner = false)
{
    $selectorsStart = array('.header-top.homepage.coloured-nav', '.header-top.homepage.fixto-fixed');

    if ($inner) {
        $selectorsStart = array(".header-top.coloured-nav:not(.homepage)", ".header-top.fixto-fixed:not(.homepage)", ".header-top.alternate:not(.homepage)");
    }

    return implode(',', $selectorsStart);
}

function ope_add_navigation_controls($inner = false)
{

    $settingPrefix = $inner ? "inner_" : "";
    $section       = $settingPrefix . "ope_pro_navigation";

    add_action('customize_register', function ($wp_customize) use ($inner, $section) {
        $wp_customize->add_section($section, array(
            'title'      => $inner ? __('Inner Pages Navigation', 'one-page-express-pro') : __('Front Page Navigation', 'one-page-express-pro'),
            'panel'      => 'one_page_express_header',
            'capability' => 'edit_theme_options',
        ));
    });


    // navigation

    ope_pro_add_text_logo_controls($settingPrefix, $section, $inner);
    ope_pro_add_nav_controls($settingPrefix, $section, $inner);
    ope_pro_add_nav_submenu_controls($settingPrefix, $section, $inner);


    Kirki::add_field('one_page_express', array(
        'type'     => 'color',
        'settings' => "{$settingPrefix}ope_header_nav_bar_color",
        'label'    => __('Nav Bar Color', 'one-page-express-pro'),
        'section'  => $section,
        'default'  => '#ffffff',
        'choices'  => array(
            'alpha' => true,
        ),

        'default' => "#FFFFFF",
        'output'  => array(
            array(
                'element'  => ope_get_sticky_nav_selector($inner),
                'property' => 'background-color',
                'suffix'   => '!important',
            ),
        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => ope_get_sticky_nav_selector($inner),
                'property' => 'background-color',
                'suffix'   => '!important',
            ),
        ),

    ));


}


function ope_pro_add_text_logo_controls($settingPrefix, $section, $inner)
{


    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Text Logo Typography', 'one-page-express-pro'),
        'section'  => $section,
        'settings' => "{$settingPrefix}header_text_logo_title_typography_sep",
        'priority' => ope_next_priority($section),
    ));

    Kirki::add_field('one-page-express', array(
        'type'     => 'sidebar-button-group',
        'settings' => "{$settingPrefix}ope_header_nav_logo_typo_group",
        'label'    => __('Text Logo Typography', 'one-page-express'),
        'section'  => $section,
        "priority" => 2,
        "choices"  => array(
            "{$settingPrefix}header_text_logo_title_typography",
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'typography',
        'settings'  => "{$settingPrefix}header_text_logo_title_typography",
        'label'     => __('Text Logo Typography', 'one-page-express-pro'),
        'section'   => $section,
        'default'   => array(
            'font-family'    => 'inherit',
            'font-size'      => '2.6em',
            'font-weight'    => '600',
            'line-height'    => '100%',
            'letter-spacing' => '0px',
            'subsets'        => array(),
            'text-transform' => 'none',
            'addwebfont'     => true,
        ),
        'output'    => array(
            array(
                'element' => ope_get_nav_text_logo_selector($inner),
            ),
        ),
        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element' => ope_get_nav_text_logo_selector($inner),
            ),
        ),
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'color',
        'settings' => "{$settingPrefix}header_text_logo_color",
        'label'    => esc_attr__('Text logo color', 'one-page-express-pro'),
        'section'  => $section,
        'default'  => "#ffffff",
        'choices'  => array(
            'alpha' => false,
        ),
        'output'   => array(
            array(
                'element'  => ope_get_nav_text_logo_selector($inner),
                'property' => 'color',
                'suffix'   => '!important',
            ),

        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => ope_get_nav_text_logo_selector($inner),
                'property' => 'color',
                'suffix'   => '!important',
            ),
        ),
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'color',
        'settings' => "{$settingPrefix}header_text_logo_sticky_typography",
        'label'    => esc_attr__('Sticky nav text logo color', 'one-page-express-pro'),
        'section'  => $section,
        'default'  => "#000000",
        'choices'  => array(
            'alpha' => false,
        ),
        'output'   => array(
            array(
                'element'  => ope_get_sticky_nav_text_logo_selector($inner),
                'property' => 'color',
                'suffix'   => '!important',
            ),

        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => ope_get_sticky_nav_text_logo_selector($inner),
                'property' => 'color',
                'suffix'   => '!important',
            ),
        ),
    ));
}


function ope_pro_add_nav_controls($settingPrefix, $section, $inner)
{
    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Navigation Typography', 'one-page-express-pro'),
        'section'  => $section,
        'settings' => "{$settingPrefix}header_nav_title_typography_sep",
    ));

    Kirki::add_field('one-page-express', array(
        'type'     => 'sidebar-button-group',
        'settings' => "{$settingPrefix}ope_header_nav_bar_typo_group",
        'label'    => __('Navigation Typography', 'one-page-express'),
        'section'  => $section,
        "priority" => 2,
        "choices"  => array(
            "{$settingPrefix}header_nav_title_typography",

        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'typography',
        'settings' => "{$settingPrefix}header_nav_title_typography",
        'label'    => __('Navigation Typography', 'one-page-express-pro'),
        'section'  => $section,
        'default'  => array(
            'font-family'    => 'inherit',
            'font-size'      => '0.9em',
            'font-weight'    => '400',
            'line-height'    => '115%',
            'letter-spacing' => '3px',
            'subsets'        => array(),
            'text-transform' => 'uppercase',
            'addwebfont'     => true,
        ),
        'output'   => array(
            array(
                'element' => ope_get_nav_menu_color_selector($inner),
            ),

        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element' => ope_get_nav_menu_color_selector($inner),
            ),
        ),
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'color',
        'settings' => "{$settingPrefix}header_nav_menu_color",
        'label'    => esc_attr__('Nav menu color', 'one-page-express-pro'),
        'section'  => $section,
        'choices'  => array(
            'alpha' => false,
        ),
        'default'  => "#FFFFFF",
        'output'   => array(
            array(
                'element'  => ope_get_nav_menu_color_selector($inner),
                'property' => 'color',
//                'suffix'   => '!important',
            ),

            array(
                'element'       => ope_get_nav_menu_color_selector($inner, true, true),
                'property'      => 'text-shadow',
                'value_pattern' => ope_pro_navigation_shadow_pattern(),
//                'suffix'        => '!important',
            ),


            array(
                'element'  => ope_get_nav_menu_color_selector($inner, true),
                'property' => 'border-bottom-color',
//                'suffix'   => '!important',
            ),


            array(
                'element'  => $inner ? '.header-top.bordered:not(.homepage)' : '.header-top.homepage.bordered',
                'property' => 'border-bottom-color',
//                'suffix'   => '!important',
            ),

        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => ope_get_nav_menu_color_selector($inner),
                'property' => 'color',
                'suffix'   => '!important',
            ),

            array(
                'element'  => ope_get_nav_menu_color_selector($inner, true),
                'property' => 'border-bottom-color',
                'suffix'   => '!important',
            ),

            array(
                'element'  => $inner ? '.header-top.bordered:not(.homepage)' : '.header-top.homepage.bordered',
                'property' => 'border-bottom-color',
                'suffix'   => '!important',
            ),

            array(
                'element'       => ope_get_nav_menu_color_selector($inner, true, true),
                'property'      => 'text-shadow',
                'value_pattern' => ope_pro_navigation_shadow_pattern(),
                'suffix'        => '!important',
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'color',
        'settings' => "{$settingPrefix}header_nav_sticky_title_typography",
        'label'    => esc_attr__('Sticky nav menu color', 'one-page-express-pro'),
        'section'  => $section,
        'choices'  => array(
            'alpha' => false,
        ),
        'default'  => "#000000",
        'output'   => array(
            array(
                'element'  => ope_get_sticky_nav_menu_color_selector($inner),
                'property' => 'color',
//                'suffix'   => '!important',
            ),

            array(
                'element'       => ope_get_sticky_nav_menu_color_selector($inner, true, true),
                'property'      => 'text-shadow',
                'value_pattern' => ope_pro_navigation_shadow_pattern(),
//                'suffix'        => '!important',
            ),

        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => ope_get_sticky_nav_menu_color_selector($inner),
                'property' => 'color',
                'suffix'   => '!important',
            ),

            array(
                'element'       => ope_get_sticky_nav_menu_color_selector($inner, true, true),
                'property'      => 'text-shadow',
                'value_pattern' => ope_pro_navigation_shadow_pattern(),
//                'suffix'        => '!important',
            ),
        ),
    ));
}


function ope_pro_add_nav_submenu_controls($settingPrefix, $section, $inner)
{
    $settingPrefix = $settingPrefix . "navigation_submenu";

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Navigation Submenu Settings', 'one-page-express-pro'),
        'section'  => $section,
        'settings' => "{$settingPrefix}_separator",
    ));


    // colors

    Kirki::add_field('one_page_express', array(
        'type'     => 'color',
        'settings' => "{$settingPrefix}_item_color",
        'label'    => esc_attr__('Background Color', 'one-page-express-pro'),
        'section'  => $section,
        'choices'  => array(
            'alpha' => true,
        ),
        'default'  => "#3F464C",
        'output'   => array(
            array(
                'element'  => ope_get_nav_submenu_item_selector($inner),
                'property' => 'background-color',
                'suffix'   => '!important',
            ),
        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => ope_get_nav_submenu_item_selector($inner),
                'property' => 'background-color',
                'suffix'   => '!important',
            ),

        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'color',
        'settings' => "{$settingPrefix}_item_hover_color",
        'label'    => esc_attr__('Hover Color', 'one-page-express-pro'),
        'section'  => $section,
        'choices'  => array(
            'alpha' => true,
        ),
        'default'  => "#2176ff",
        'output'   => array(
            array(
                'element'  => ope_get_nav_submenu_item_selector($inner, 'hover'),
                'property' => 'background-color',
                'suffix'   => '!important',
            ),

            array(
                'element'  => ope_get_nav_submenu_ul_selector($inner),
                'property' => 'border-bottom-color',
                'suffix'   => '!important',
            ),
        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => ope_get_nav_submenu_item_selector($inner, 'hover'),
                'property' => 'background-color',
                'suffix'   => '!important',
            ),

            array(
                'element'  => ope_get_nav_submenu_ul_selector($inner),
                'property' => 'border-bottom-color',
                'suffix'   => '!important',
            ),

        ),
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'color',
        'settings' => "{$settingPrefix}_item_text_color",
        'label'    => esc_attr__('Item Text Color', 'one-page-express-pro'),
        'section'  => $section,
        'choices'  => array(
            'alpha' => false,
        ),
        'default'  => "#FFFFFF",
        'output'   => array(
            array(
                'element'  => ope_get_nav_submenu_item_selector($inner),
                'property' => 'color',
                'suffix'   => '!important',
            ),
        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => ope_get_nav_submenu_item_selector($inner),
                'property' => 'color',
                'suffix'   => '!important',
            ),

        ),
    ));

    // typography

    Kirki::add_field('one-page-express', array(
        'type'     => 'sidebar-button-group',
        'settings' => "{$settingPrefix}_item_typography_group",
        'label'    => __('Item Typography', 'one-page-express'),
        'section'  => $section,
        "priority" => 2,
        "choices"  => array(
            "{$settingPrefix}_item_typography",
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'typography',
        'settings' => "{$settingPrefix}_item_typography",
        'label'    => __('Item Typography', 'one-page-express-pro'),
        'section'  => $section,
        'default'  => array(
            'font-family'    => 'inherit',
            'font-size'      => '0.6em',
            'font-weight'    => '400',
            'line-height'    => '120%',
            'letter-spacing' => '0px',
            'subsets'        => array(),
            'text-transform' => 'uppercase',
            'addwebfont'     => true,
        ),
        'output'   => array(
            array(
                'element' => ope_get_nav_submenu_item_selector($inner),
            ),

        ),

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element' => ope_get_nav_submenu_item_selector($inner),
            ),
        ),
    ));
}


ope_add_navigation_controls();
ope_add_navigation_controls(true);
