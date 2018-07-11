<?php

function get_normal_buttons_options()
{
    $buttons = array();

    $map = array(
        'label'  => '',
        'url'    => '#',
        'target' => '_self',
        'class'  => array(
            1 => 'button blue big',
            2 => 'button green big',
        ),
    );

    for ($i = 1; $i <= 2; $i++) {
        $button_data = array();

        $visible = get_theme_mod('one_page_express_header_show_btn_' . $i, true);
        if ($visible) {
            foreach ($map as $key => $initial_value) {
                if (is_array($initial_value)) {
                    $initial_value = $initial_value[$i];
                }

                $option = get_theme_mod("one_page_express_header_btn_{$i}_{$key}", $initial_value);

                if ($key === 'class') {
                    // remove class from normal buttons
                    $option = str_replace('hp-header-primary-button', '', $option);
                    $option = str_replace('hp-header-secondary-button', '', $option);
                }

                $button_data[$key] = $option;
            }

            $buttons[] = $button_data;
        }

    }

    return $buttons;
}

function one_page_express_pro_buttons_list_get()
{
    $fallback_buttons = get_normal_buttons_options();
    $buttons          = get_theme_mod('ope_pro_multiple_buttons', $fallback_buttons);


//    if ($buttons === null) {
//        $buttons = $fallback_buttons;
//    }

    return $buttons;
}


function one_page_express_pro_buttons_list_item_mods($index)
{
    $result = array(
        "type" => 'data-theme',
        "mod"  => "ope_pro_multiple_buttons|$index|label",
        "atts" => array(
            "href"   => "ope_pro_multiple_buttons|$index|url",
            "target" => "ope_pro_multiple_buttons|$index|target",
            "class"  => "ope_pro_multiple_buttons|$index|class",
        ),
    );

    return $result;
}

function one_page_express_pro_buttons_list_item_mods_attr($index)
{
    $item_mods = one_page_express_pro_buttons_list_item_mods($index);
    $result    = "data-theme='{$item_mods['mod']}'";

    foreach ($item_mods['atts'] as $key => $value) {
        $result .= " data-theme-{$key}='{$value}'";
    }

    $result .= " data-dynamic-mod='true'";

    return $result;
}

function one_page_express_pro_buttons_list_print()
{

    $buttons = one_page_express_pro_buttons_list_get();

    $in_preview = is_customize_preview();

    foreach ($buttons as $index => $button) {
        $title  = $button['label'];
        $url    = $button['url'];
        $target = $button['target'];
        $class  = $button['class'] . " homepage-header-button-{$index}";


        if (current_user_can('edit_theme_options')) {
            if (empty($title)) {
                $title = __('Action button 1', 'one-page-express');
            }
        }

        if ($in_preview) {
            $mod_attr = one_page_express_pro_buttons_list_item_mods_attr($index);

            $btn_string = '<a class="%4$s" target="%3$s" href="%1$s" ' . $mod_attr . ' >%2$s</a>';
            printf($btn_string, esc_url($url), wp_kses_post($title), $target, $class);
        } else {
            printf('<a class="%4$s" target="%3$s" href="%1$s">%2$s</a>', esc_url($url), wp_kses_post($title), $target, $class);
        }
    }

}

add_filter('cloudpress\customizer\mod_defaults', 'one_page_express_pro_buttons_list_defaults');

function one_page_express_pro_buttons_list_defaults($defaults)
{
    $defaults['ope_pro_multiple_buttons'] = get_normal_buttons_options();

    return $defaults;
}

