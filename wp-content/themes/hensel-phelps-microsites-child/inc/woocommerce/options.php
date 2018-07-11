<?php
// global $wp_customize;

$wp_customize->add_panel(
    'ope_woo_panel',
    array(
        'capability' => 'edit_theme_options',
        'title'      => __('WooCommerce Options', 'one-page-express-pro'),
    )
);

$wp_customize->add_section('ope_woo_colors', array(
    'title'    => __('Colors', 'one-page-express-pro'),
    'priority' => 30,
    'panel'    => 'ope_woo_panel',
));


Kirki::add_field('one_page_express', array(
    'type'      => 'color',
    'settings'  => "ope_woo_primary_color",
    'label'     => __('Primary Color', 'one-page-express-pro'),
    'section'   => 'ope_woo_colors',
    'default'   => one_page_express_get_colors('color1'),
    'choices'   => array(
        'alpha'    => false,
        'scss_var' => true,
    ),
    'transport' => 'postMessage',
));


Kirki::add_field('one_page_express', array(
    'type'      => 'color',
    'settings'  => "ope_woo_secondary_color",
    'label'     => __('Secondary Color', 'one-page-express-pro'),
    'section'   => 'ope_woo_colors',
    'default'   => one_page_express_get_colors('color2'),
    'choices'   => array(
        'alpha'    => false,
        'scss_var' => true,
    ),
    'transport' => 'postMessage',
));


Kirki::add_field('one_page_express', array(
    'type'      => 'color',
    'settings'  => "ope_woo_onsale_color",
    'label'     => __('"Sale" Badge Color', 'one-page-express-pro'),
    'section'   => 'ope_woo_colors',
    'default'   => ope_woo_get_onsale_badge_default_color(),
    'choices'   => array(
        'alpha'    => false,
        'scss_var' => true,
    ),
    'transport' => 'postMessage',
));

Kirki::add_field('one_page_express', array(
    'type'      => 'color',
    'settings'  => "ope_woo_rating_stars_color",
    'label'     => __('Rating Stars Color', 'one-page-express-pro'),
    'section'   => 'ope_woo_colors',
    'default'   => ope_woo_get_onsale_badge_default_color(),
    'choices'   => array(
        'alpha'    => false,
        'scss_var' => true,
    ),
    'transport' => 'postMessage',
));


add_filter('ope_scss_settings', function ($settings) {

    $settings = array_merge(
        $settings,
        array(
            'ope_woo_list_item_tablet_cols',
            'ope_woo_list_item_desktop_cols',
            'ope_woo_primary_color',
            'ope_woo_secondary_color',
        )
    );

    return $settings;
});


$wp_customize->add_section('ope_woo_product_list', array(
    'title'    => __('Product List Options', 'one-page-express-pro'),
    'priority' => 30,
    'panel'    => 'ope_woo_panel',
));

Kirki::add_field('one_page_express', array(
    'type'     => 'number',
    'settings' => "ope_woo_products_per_page",
    'label'    => __('Products per page', 'one-page-express-pro'),
    'section'  => 'ope_woo_product_list',
    'default'  => 12,
));

Kirki::add_field('one_page_express', array(
    'type'      => 'number',
    'settings'  => "ope_woo_list_item_desktop_cols",
    'label'     => __('Products per row on desktop', 'one-page-express-pro'),
    'section'   => 'ope_woo_product_list',
    'default'   => 3,
    'transport' => 'postMessage',
    'choices'   => array(
        'scss_var' => true,
    ),
));



Kirki::add_field('one_page_express', array(
    'type'      => 'number',
    'settings'  => "ope_woo_list_item_tablet_cols",
    'label'     => __('Products per row on tablet', 'one-page-express-pro'),
    'section'   => 'ope_woo_product_list',
    'default'   => 2,
    'transport' => 'postMessage',
    'choices'   => array(
        'scss_var' => true,
    ),
));


Kirki::add_field('one_page_express', array(
    'type'     => 'sortable',
    'settings' => 'ope_woo_card_item_get_print_order',
    'label'    => __('Product Fields Order', 'one-page-express-pro'),
    'section'  => 'ope_woo_product_list',
    'default'  => array('title', 'rating', 'price', 'categories', 'description'),
    'choices'  => apply_filters('ope_woo_list_product_options',
        array(
            'title'       => __('Product Name', 'one-page-express-pro'),
            'rating'      => __('Rating Stars', 'one-page-express-pro'),
            'price'       => __('Price', 'one-page-express-pro'),
            'categories'  => __('Product Categories', 'one-page-express-pro'),
            'description' => __('Product Description (excerpt) ', 'one-page-express-pro'),
        )
    ),
));


Kirki::add_field('one_page_express', array(
    'type'      => 'number',
    'settings'  => "ope_woo_related_list_item_desktop_cols",
    'label'     => __('Related products per row on desktop', 'one-page-express-pro'),
    'section'   => 'ope_woo_product_list',
    'default'   => 4,
    'transport' => 'postMessage',
    'choices'   => array(
        'scss_var' => true,
    ),
));



Kirki::add_field('one_page_express', array(
    'type'      => 'number',
    'settings'  => "ope_woo_related_list_item_tablet_cols",
    'label'     => __('Related products per row on tablet', 'one-page-express-pro'),
    'section'   => 'ope_woo_product_list',
    'default'   => 2,
    'transport' => 'postMessage',
    'choices'   => array(
        'scss_var' => true,
    ),
));


Kirki::add_field('one_page_express', array(
    'type'     => 'ope-info',
    'label'    => __('The cross-sell product list appears in the shopping cart page', 'one-page-express'),
    'section'  => 'ope_woo_product_list',
    'settings' => "ope_woo_cross_sell_list_item_desktop_cols_info",
));


Kirki::add_field('one_page_express', array(
    'type'      => 'number',
    'settings'  => "ope_woo_cross_sell_list_item_desktop_cols",
    'label'     => __('Cross-sell products per row on desktop', 'one-page-express-pro'),
    'section'   => 'ope_woo_product_list',
    'default'   => 4,
    'transport' => 'postMessage',
    'choices'   => array(
        'scss_var' => true,
    ),
));


Kirki::add_field('one_page_express', array(
    'type'      => 'number',
    'settings'  => "ope_woo_cross_sell_list_item_tablet_cols",
    'label'     => __('Cross-sell products per row on tablet', 'one-page-express-pro'),
    'section'   => 'ope_woo_product_list',
    'default'   => 2,
    'transport' => 'postMessage',
    'choices'   => array(
        'scss_var' => true,
    ),
));



Kirki::add_field('one_page_express', array(
    'type'     => 'ope-info',
    'label'    => __('The upsell product list appears in the product page, before the related products list', 'one-page-express-pro'),
    'section'  => 'ope_woo_product_list',
    'settings' => "ope_woo_upsells_list_item_desktop_cols_info",
));

Kirki::add_field('one_page_express', array(
    'type'      => 'number',
    'settings'  => "ope_woo_upsells_list_item_desktop_cols",
    'label'     => __('Upsell products per row on desktop', 'one-page-express-pro'),
    'section'   => 'ope_woo_product_list',
    'default'   => 2,
    'transport' => 'postMessage',
    'choices'   => array(
        'scss_var' => true,
    ),
));

Kirki::add_field('one_page_express', array(
    'type'      => 'number',
    'settings'  => "ope_woo_upsells_list_item_tablet_cols",
    'label'     => __('Upsell products per row on tablet', 'one-page-express-pro'),
    'section'   => 'ope_woo_product_list',
    'default'   => 2,
    'transport' => 'postMessage',
    'choices'   => array(
        'scss_var' => true,
    ),
));






add_filter('cloudpress\customizer\global_data', function ($data) {

    $key = wp_create_nonce('ope_woo_api_nonce');
    set_theme_mod('ope_woo_api_nonce', $key);

    if ( ! isset($_REQUEST['ope_woo_api_nonce'])) {
        $data['ope_woo_api_nonce'] = $key;
    }

    return $data;
});


$wp_customize->add_section('ope_woo_general_options', array(
    'title'    => __('General Options', 'one-page-express-pro'),
    'priority' => 30,
    'panel'    => 'ope_woo_panel',
));


Kirki::add_field('one_page_express', array(
    'type'            => 'select',
    'settings'        => 'ope_woo_header_type',
    'label'           => esc_html__('Shop header', 'one-page-express'),
    'section'         => 'ope_woo_general_options',
    'default'         => 'default',
    'choices'         => apply_filters('ope_woo_shop_header_type_choices', array(
        "default"       => __("Large header with title", "one-page-express"),
        "small"       => __("Navigation only", "one-page-express"),
    ))
));



Kirki::add_field('one_page_express', array(
    'type'            => 'select',
    'settings'        => 'ope_woo_product_header_type',
    'label'           => esc_html__('Product detail header', 'one-page-express'),
    'section'         => 'ope_woo_general_options',
    'default'         => 'default',
    'choices'         => apply_filters('ope_woo_shop_header_type_choices', array(
        "default"       => __("Large header with title", "one-page-express"),
        "small"       => __("Navigation only", "one-page-express"),
    ))
));



Kirki::add_field('one_page_express', array(
    'type'     => 'checkbox',
    'settings' => 'ope_woo_cart_display_near_menu',
    'label'    => __('Show cart button in menu', 'one-page-express'),
    'section'  => 'ope_woo_general_options',
    'default'  => true,
));



Kirki::add_field('one_page_express', array(
    'type'     => 'checkbox',
    'settings' => 'ope_woo_product_header_image',
    'label'    => __('On product page set product image as header background', 'one-page-express'),
    'section'  => 'ope_woo_general_options',
    'default'  => true,
));
