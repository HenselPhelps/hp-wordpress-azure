<?php

function one_page_express_get_translatable_mods()
{
    $one_page_express_translatable_mods = array(
        "one_page_express_header_image",
        "one_page_express_header_bg_position",

        "one_page_express_header_slideshow",
        "one_page_express_header_video_external",

        "one_page_express_header_content_image",
        "ope_pro_header_content_video",

        "one_page_express_header_video_popup_image",

        "one_page_express_header_title",
        "one_page_express_header_subtitle",
        "one_page_express_header_subtitle2",

        "one_page_express_header_text_morph_alternatives",

        "one_page_express_footer_copyright",

        "one_page_express_latest_news_read_more",

        "ope_pro_header_section_content_group-of-images-2",

        "ope_pro_multiple_buttons",
        "ope_store_badges",
    );

    return apply_filters("one_page_express_translatable_mods", $one_page_express_translatable_mods);
}

add_filter("one_page_express_translatable_mods", function ($mods) {

    // TODO: move each one in it's place//

    // header buttons//
    for ($i = 1; $i < 7; $i++) {
        array_push($mods, "one_page_express_header_btn_{$i}_label");
        array_push($mods, "one_page_express_header_btn_{$i}_url");
        array_push($mods, "one_page_express_header_btn_{$i}_target");
    }

    // footer content boxes//
    for ($i = 1; $i < 4; $i++) {
        array_push($mods, "one_page_express_footer_boxes_b{$i}_text");
    }


    // footer social boxes
    for ($i = 1; $i <= 5; $i++) {
        array_push($mods, "one_page_express_footer_social_icons_social_icon_{$i}_url");
    }

    return $mods;
});

function one_page_express_get_default_language()
{
    global $pagenow;
    $lang = apply_filters("one_page_express_get_default_language", "");
    one_page_express_log2("one_page_express_get_default_language => $lang => $pagenow");

    return $lang;
}

function one_page_express_get_post_language($post_id)
{
    global $pagenow;
    $lang = apply_filters("one_page_express_get_post_language", "", $post_id);
    one_page_express_log2("one_page_express_get_post_language => $lang => $pagenow");

    return $lang;
}

function one_page_express_get_current_language()
{
    global $pagenow;
    $lang = apply_filters("one_page_express_get_current_language", "");
    one_page_express_log2("one_page_express_get_current_language => $lang => $pagenow");

    return $lang;
}

function one_page_express_translate_set_mods($value, $old_value)
{

    $page_id = isset($_POST['customize_post_id']) ? intval($_POST['customize_post_id']) : -1;


    one_page_express_log2("one_page_express_translate_set_mods=>".$page_id);

    if ($page_id === -1) {
		one_page_express_log2("debug_backtrace => ".json_encode(debug_backtrace()));	
        return $value;
    }

    $changeset_status = null;
    if (isset($_POST['customize_changeset_status'])) {
        $changeset_status = wp_unslash($_POST['customize_changeset_status']);
    }

    $one_page_express_translatable_mods = one_page_express_get_translatable_mods();
    global $one_page_express_default_language_mods;

    remove_filter("option_theme_mods_" . get_option('stylesheet'), "one_page_express_translate_get_mods");

    $original_value = $one_page_express_default_language_mods;
    $value     = one_page_express_translate_mods($value);
    $old_value = one_page_express_translate_mods($old_value);


    one_page_express_log2(json_encode($original_value));

    if ($page_id !== -1 && $changeset_status == "publish") {

        $post_language        = one_page_express_get_post_language($page_id);
        $pll_default_language = one_page_express_get_default_language();

        $changed_mods = one_page_express_changed_mods();

        one_page_express_log2("default#".$pll_default_language."##".$post_language);

        if ($pll_default_language != $post_language) {
            foreach ($one_page_express_translatable_mods as $mod) {
                $cp_mod = "CP_AUTO_SETTING[" . $mod . "]";

                $are_eq1 = (isset($value[$mod]) && ($value[$mod] == $old_value[$mod])) || !isset($value[$mod]);
                $are_eq2 = (isset($value['CP_AUTO_SETTING'][$mod]) && $value['CP_AUTO_SETTING'][$mod] == $old_value['CP_AUTO_SETTING'][$mod]) || !isset($value['CP_AUTO_SETTING'][$mod]);
                $skip = $are_eq1 && $are_eq2;

                one_page_express_log2("are_eq1#".$are_eq1."##are_eq2=".$are_eq2);

                // update translated values //

                if (isset($changed_mods[$mod]) || isset($changed_mods[$cp_mod])) {
                    if (!$skip) {

                        if (isset($value[$mod])) {
                            one_page_express_set_translate_mod($post_language, $mod, $value[$mod]);
                        } else {
                            if (isset($value['CP_AUTO_SETTING'][$mod])) {
                                one_page_express_set_translate_mod($post_language, $mod, $value['CP_AUTO_SETTING'][$mod]);
                            }
                        }
                    }
                }

                // revert to old values for translatable mods //

                if (isset($original_value[$mod])) {
                    $value[$mod] = $original_value[$mod];
                    $value['CP_AUTO_SETTING'][$mod] = $original_value[$mod];

                    one_page_express_log2("restore value1#".$mod."#".$original_value[$mod]);

                } else {
                    //if its unset in original language, it will not show up, as it will go throw default values//
                    //unset($value[$mod]);
                }

                if (isset($original_value['CP_AUTO_SETTING'][$mod])) {
                    $value['CP_AUTO_SETTING'][$mod] = $original_value['CP_AUTO_SETTING'][$mod];
                    $value[$mod] = $original_value['CP_AUTO_SETTING'][$mod];

                    one_page_express_log2("restore value2#".$mod."#".$original_value['CP_AUTO_SETTING'][$mod]);

                } else {
                    //if its unset in original language, it will not show up, as it will go throw default values//
                    //unset($value['CP_AUTO_SETTING'][$mod]);
                }
            }
        }
    }

    return $value;
}

$one_page_express_default_language_mods = false;
$one_page_express_cached                = false;

function one_page_express_translate_get_initial_value($value)
{
    global $one_page_express_default_language_mods;
    $one_page_express_default_language_mods = $value;

    return $value;
}

function one_page_express_translate_get_mods($value)
{
    $page_id = isset($_POST['customize_post_id']) ? intval($_POST['customize_post_id']) : -1;

    $changeset_status = null;
    if (isset($_POST['customize_changeset_status'])) {
        $changeset_status = wp_unslash($_POST['customize_changeset_status']);
    }

    // on publish return original values //
    if (is_customize_preview() && $changeset_status === "publish") {
        return $value;
    }

    global $one_page_express_cached;
    if ($one_page_express_cached && $changeset_status !== "publish") {
        return $one_page_express_cached;
    }

    $value                   = one_page_express_translate_mods($value);
    $one_page_express_cached = $value;

    return $value;
}

function one_page_express_mods_are_changed($one_page_express_translatable_mods)
{
    $changed_mods = one_page_express_changed_mods();

    foreach ($one_page_express_translatable_mods as $key => $mod) {
        if (isset($changed_mods[$mod])) {
            return true;
        }
    }

    return false;
}

function one_page_express_changed_mods()
{
    global $wp_customize;

    if ($wp_customize) {
        $changeset_setting_values = $wp_customize->unsanitized_post_values(
            array(
                'exclude_post_data' => true,
                'exclude_changeset' => false,
            )
        );

        return $changeset_setting_values;
    }

    return array();
}

function one_page_express_translate_mods($value, $force = false)
{
    $one_page_express_translatable_mods = one_page_express_get_translatable_mods();

    foreach ($one_page_express_translatable_mods as $mod) {
        $cp_mod      = "CP_AUTO_SETTING[" . $mod . "]";
        $has_changed = one_page_express_mods_are_changed(array($mod, $cp_mod));

        if ($force || ! $has_changed) {
            if (isset($value['CP_AUTO_SETTING'][$mod])) {
                $mod_val                        = $value['CP_AUTO_SETTING'][$mod];
                $value['CP_AUTO_SETTING'][$mod] = one_page_express_translate_mod($mod, $mod_val);
            }

            if (isset($value[$mod])) {
                $mod_val     = $value[$mod];
                $value[$mod] = one_page_express_translate_mod($mod, $mod_val);
            }
        }
    }

    return $value;
}

function one_page_express_set_translate_mod($lang, $name, $value)
{
    one_page_express_log2("one_page_express_set_translate_mod => lang=". $lang . "; name=" . $name .";value=". json_encode($value));

    $langs = get_option("one_page_express_translated_mods", array());
    if ( ! isset($langs[$lang])) {
        $langs[$lang] = array();
    }

    $langs[$lang][$name] = $value;

    update_option("one_page_express_translated_mods", $langs);
}

function one_page_express_current_language()
{
    $page_id = isset($_POST['customize_post_id']) ? intval($_POST['customize_post_id']) : -1;

    global $wp_customize;
    global $pagenow;

    // detect language for settings values//
    if (is_admin() && 'customize.php' === $pagenow) {
        $preview_url = isset($_GET['url']) ? wp_unslash($_GET['url']) : site_url();
        $page_id     = url_to_postid($preview_url);

        if ( ! $page_id) {
            $page_id = -1;
        }
    }

    if ($page_id != -1) {
        $post_language = one_page_express_get_post_language($page_id);
    } else {
        $post_language = one_page_express_get_current_language();
    }

    return $post_language;
}

function one_page_express_translate_mod($name, $value)
{
    $langs = get_option("one_page_express_translated_mods", array());

    $post_language = one_page_express_current_language();

    if (isset($langs[$post_language]) && isset($langs[$post_language][$name])) {
        $new_value = $langs[$post_language][$name];
    } else {
        $new_value = $value;
    }

    //one_page_express_log2("get translation => post_language=". $post_language . "; name=" . $name .";value=". json_encode($value) . ";new_value=".json_encode($new_value));

    return $new_value;
}


function one_page_express_prepare_translation()
{
    add_filter("option_theme_mods_" . get_option('stylesheet'), "one_page_express_translate_get_mods", -1);
    add_filter("option_theme_mods_" . get_option('stylesheet'), "one_page_express_translate_get_initial_value");
    add_filter("pre_update_option_theme_mods_" . get_option('stylesheet'), "one_page_express_translate_set_mods", -1, 2);
}

one_page_express_prepare_translation();
