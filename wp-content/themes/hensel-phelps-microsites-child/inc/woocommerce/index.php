<?php


function ope_woo_get_onsale_badge_default_color()
{
    $primary_color = get_theme_mod('ope_woo_primary_color', false);
    if ( ! $primary_color) {
        $primary_color = one_page_express_get_colors('color1');
    }

    return ope_lighten_color($primary_color);
}


add_filter('ope_pro_scss_vars', function ($vars) {

    $vars['woo_list_item_tablet_cols']  = get_theme_mod('ope_woo_list_item_tablet_cols', 2);
    $vars['woo_list_item_desktop_cols'] = get_theme_mod('ope_woo_list_item_desktop_cols', 4);


    $vars["woo_upsells_list_item_desktop_cols"]  = get_theme_mod('ope_woo_upsells_list_item_desktop_cols', 4);
    $vars["woo_upsells_list_item_tablet_cols"]  = get_theme_mod('ope_woo_upsells_list_item_tablet_cols', 2);
    
    $vars["woo_cross_sell_list_item_desktop_cols"]  = get_theme_mod('ope_woo_cross_sell_list_item_desktop_cols', 2);
    $vars["woo_cross_sell_list_item_tablet_cols"]  = get_theme_mod('ope_woo_cross_sell_list_item_tablet_cols', 2);

    $vars["woo_related_list_item_desktop_cols"]  = get_theme_mod('ope_woo_related_list_item_desktop_cols', 4);
    $vars["woo_related_list_item_tablet_cols"]  = get_theme_mod('ope_woo_related_list_item_tablet_cols', 2);

    $vars['woo_primary_color']          = get_theme_mod('ope_woo_primary_color', '$color1');
    $vars['woo_secondary_color']        = get_theme_mod('ope_woo_secondary_color', '$color2');
    $vars['woo_onsale_color']           = get_theme_mod('ope_woo_onsale_color', ope_woo_get_onsale_badge_default_color());
    $vars['woo_rating_stars_color']     = get_theme_mod('ope_woo_rating_stars_color', ope_woo_get_onsale_badge_default_color());


    return $vars;
});

require_once get_stylesheet_directory() . "/inc/woocommerce/list.php";
require_once get_stylesheet_directory() . "/inc/woocommerce/product-images.php";

add_action('customize_register', function ($wp_customize) {

    require_once get_stylesheet_directory() . "/inc/woocommerce/options.php";

}, 10, 1);


add_filter('loop_shop_per_page', 'new_loop_shop_per_page', 20);

function new_loop_shop_per_page($cols)
{
    // $cols contains the current number of products per page based on the value stored on Options -> Reading
    // Return the number of products you wanna show per page.
    $cols = get_theme_mod('ope_woo_products_per_page', 12);

    return $cols;
}


// woocommerce_widget_shopping_cart_button_view_cart

// view cart near menu

function ope_woo_cart_menu_item($items, $args = false)
{

    $isPrimaryMenu = ($args === false || (property_exists($args, 'theme_location') && $args->theme_location === "primary"));

    if ( ! $isPrimaryMenu) {
        return $items;
    }


    $cart_url = wc_get_cart_url();

    $cartContent = ope_instantiate_widget("WC_Widget_Cart",
        array(
            'wrap_tag'   => 'div',
            'wrap_class' => 'ope-woo-header-cart',
        )
    );

    $item = "<li class=\"ope-menu-cart\"><a href=\"{$cart_url}\"> <i class='fa fa-shopping-cart'></i></a>{$cartContent}</li>";

    return $items . $item;
}

add_action('wp_loaded', function () {

    $display_near_menu = get_theme_mod('ope_woo_cart_display_near_menu', true);

    if (intval($display_near_menu)) {
        add_filter('wp_nav_menu_items', 'ope_woo_cart_menu_item', 10, 2);
        add_filter('one_page_express_nomenu_after', 'ope_woo_cart_menu_item', 10, 2);
    }
});

function ope_get_woo_api_key()
{
    $dummyHash = uniqid('dummy_ope_hash');

    return get_theme_mod('ope_woo_api_nonce', md5($dummyHash));
}

function is_ope_woo_api_key_valid($key)
{
    return ($key === ope_get_woo_api_key());
}