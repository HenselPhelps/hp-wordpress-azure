<?php

// remove responsiveness

add_action('wp_head', 'ope_pro_use_desktop_version_on_mobile');

add_filter('cloudpress\customizer\control\content_sections\multiple', 'ope_pro_content_add_insertion_type');

function ope_pro_content_add_insertion_type($data)
{
    return 'multiple';
}

function ope_pro_use_desktop_version_on_mobile()
{
    $useDesktop = get_theme_mod('ope_pro_use_desktop_version_on_mobile', false);

    if (intval($useDesktop)) {
        ?>
        <meta name="viewport" content="width=1280">
        <script type="text/javascript">
            window.navMenuForceDesktop = true;
        </script>
        <?php
    }
}

Kirki::add_field('one-page-express', array(
    'type'     => 'checkbox',
    'settings' => 'ope_pro_use_desktop_version_on_mobile',
    'label'    => __('Use Desktop version on mobile devices', 'one-page-express-pro'),
    'section'  => 'custom_css',
    'default'  => '0',
    'priority' => 10,
));

if (!function_exists("one_page_express_get_header")) {
    function one_page_express_get_header($template = "")
    {
        $template = apply_filters('one_page_express_get_header', $template);
        get_footer($template);
    }
}


add_filter('one_page_express_get_header', 'ope_get_header_woocomerce', 10, 2);

function ope_get_header_woocomerce($template)
{

    global $post;
    $header = false;

    if ($post) {
        $header = get_post_meta($post->ID, 'ope_post_header', true);
    }

    if ( ! $header) {
        $header = $template;
    }

    if (one_page_express_is_woocommerce()) {
        $setting = "ope_woo_header_type";
        if (one_page_express_is_woocommerce_product_page()) {
            $setting = "ope_woo_product_header_type";
        }

        $template = get_theme_mod($setting, "default");
        if ($template == "default") {
            $template = "";
        }
    }

    return $template;
}


add_filter('is_protected_meta', 'ope_post_header_protected_meta', 10, 2);

function ope_post_header_protected_meta($protected, $meta_key)
{

    if ($meta_key === "ope_post_header") {
        return true;
    }

    return $protected;
}


// ope_pro_users_custom_widgets_areas
Kirki::add_field('one_page_express', array(
    'type'      => 'repeater',
    'settings'  => 'ope_pro_users_custom_widgets_areas',
    'label'     => esc_html__('Custom Widget Areas', 'one-page-express'),
    'section'   => "user_custom_widgets_areas",
    "priority"  => 0,
    "default"   => array(),
    'row_label' => array(
        'type'  => 'field',
        'field' => 'name',
        'value' => 'Widgets Area',
    ),
    "fields"    => array(
        "name" => array(
            'type'    => 'text',
            'label'   => esc_attr__('Widgets Area name', 'one-page-express'),
            'default' => 'Widgets Area',
        ),

    ),
));


Kirki::add_field('one_page_express',
    array(
        'type'     => 'ope-info',
        'label'    => __('After adding a custom Widgets Area, please save and reload the Customizer. You will not be able to add widgets in the newly created widgets area before reloading.', 'one-page-express-pro'),
        'section'  => 'user_custom_widgets_areas',
        'settings' => "ope_pro_users_custom_widgets_areas_info",
    )
);


add_filter('cloudpress\customizer\global_data', function ($data) {


    $separators = one_page_express_separators_list();

    $data['section_separators'] = $separators;

    return $data;
});


register_sidebar(array(
    'name'          => 'Pages Sidebar',
    'id'            => "ope_pages_sidebar",
    'title'         => "Pages Sidebar",
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="widgettitle">',
    'after_title'   => '</h2>',
));