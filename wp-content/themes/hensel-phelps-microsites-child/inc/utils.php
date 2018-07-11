<?php

$__ope_next_priority = array();

function ope_next_priority($parent, $offset = 0)
{
    global $__ope_next_priority;

    if ( ! isset($__ope_next_priority[$parent])) {
        $__ope_next_priority[$parent] = 0;
    }
    $__ope_next_priority[$parent] += 5;

    return $offset + $__ope_next_priority[$parent];
}

function ope_sort_controls_in_section($section, $controls_ids)
{
    global $wp_customize;

    foreach ($controls_ids as $control) {
        $c = $wp_customize->get_control($control);
        if ($c) {
            $c->priority = ope_next_priority($section);
            $c->section  = $section;
        }
    }
}

function ope_sort_section_in_panel($panel, $sections_ids)
{
    global $wp_customize;

    foreach ($sections_ids as $section) {
        $s = $wp_customize->get_section($section);
        if ($s) {
            $s->priority = ope_next_priority($panel);
            $s->panel    = $panel;
        }
    }
}

function ope_log($data)
{

    $string = "\n\n#################### " . date("F j, Y, g:i a") . " ####################\n" . json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents(ABSPATH . "/log.txt", $string, FILE_APPEND);
}


function ope_print_contextual_jQuery()
{
    $isShortcodeRefresh = apply_filters('is_shortcode_refresh', false);
    echo $isShortcodeRefresh ? "parent.CP_Customizer.preview.jQuery()" : "jQuery";
}

function ope_darker_color($color)
{
    return Kirki_Color::adjust_brightness($color, -10);
}

function ope_lighten_color($color, $value = 10)
{
    return Kirki_Color::adjust_brightness($color, $value);
}


if ( ! function_exists('ope_get_pro_version')) {
    function ope_get_pro_version()
    {
        $theme = wp_get_theme();
        $ver   = $theme->get('Version');
        $ver   = apply_filters('ope_get_pro_version', $ver);

        return $ver;
    }
}

function ope_pro_assets_uploads_dir($rel = "")
{
    $includesFolder = wp_get_upload_dir();
    $result         = false;

    if (wp_is_writable($includesFolder['basedir'])) {
        $path = $includesFolder['basedir'] . "/ope-assets{$rel}";
        if ( ! file_exists($path)) {
            wp_mkdir_p($path);
        }

        $result = array(
            'path' => $path,
            'url'  => $includesFolder['baseurl'] . "/ope-assets{$rel}",
        );
    }

    return $result;
}

function ope_instantiate_widget($widget, $args = array())
{

    ob_start();
    the_widget($widget, $args);
    $content = ob_get_contents();
    ob_end_clean();

    if (isset($args['wrap_tag'])) {
        $tag     = $args['wrap_tag'];
        $class   = isset($args['wrap_class']) ? $args['wrap_class'] : "";
        $content = "<{$tag} class='{$class}'>{$content}</{$tag}>";
    }

    return $content;

}


function ope_get_current_template()
{
    global $template;

    $current_template = str_replace("\\", "/", $template);
    $pathParts        = explode("/", $current_template);
    $current_template = array_pop($pathParts);

    return $current_template;
}


function ope_is_page_template()
{

    $templates   = wp_get_theme()->get_page_templates();
    $templates   = array_keys($templates);
    $templates[] = "woocommerce.php";

    $current_template = ope_get_current_template();


    foreach ($templates as $_template) {
        if ($_template === $current_template) {
            return true;
        }

    }

    return false;

}


if ( ! function_exists('ope_post_type_is')) {
    function ope_post_type_is($type)
    {
        global $wp_query;

        $post_type = $wp_query->query_vars['post_type'] ? $wp_query->query_vars['post_type'] : 'post';

        if ( ! is_array($type)) {
            $type = array($type);
        }

        return in_array($post_type, $type);
    }
}
