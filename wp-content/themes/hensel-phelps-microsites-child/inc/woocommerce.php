<?php

require_once get_stylesheet_directory() . "/inc/woocommerce/index.php";


add_action('after_setup_theme', 'ope_pro_add_woocommerce_support');
function ope_pro_add_woocommerce_support()
{
    add_theme_support('woocommerce');


    /* WooCommerce support for latest gallery */
   if ( class_exists( 'WooCommerce' ) ) {
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
   }
}

function one_page_woo_register_sidebars()
{
    $widgets_area = get_theme_mod('ope_pro_users_custom_widgets_areas', array());

    register_sidebar(array(
        'name'          => 'WooCommerce Left Sidebar',
        'id'            => "ope_pro_woocommerce_sidebar_left",
        'title'         => "'WooCommerce Left Sidebar",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => 'WooCommerce Right Sidebar',
        'id'            => "ope_pro_woocommerce_sidebar_right",
        'title'         => "'WooCommerce Right Sidebar",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ));

}

add_action('widgets_init', 'one_page_woo_register_sidebars');


add_filter('woocommerce_enqueue_styles', 'ope_woocommerce_enqueue_styles');

function ope_woocommerce_enqueue_styles($woo)
{
    $assetsRoot = get_stylesheet_directory_uri() . "/assets";
    $version    = ope_get_pro_version();

    $styles = array(
        'ope-woo' => array(
            'src'     => $assetsRoot . "/css/ope-woo.css",
            'deps'    => array('woocommerce-general'),
            'version' => $version,
            'media'   => 'all',
            'has_rtl' => false,
        ),
    );

    wp_enqueue_style('fancybox', get_stylesheet_directory_uri() . "/assets/css/jquery.fancybox.min.css", array(), $version);
    wp_enqueue_script('fancybox', get_stylesheet_directory_uri() . "/assets/js/jquery.fancybox.min.js", array("jquery"), $version);

    return array_merge($woo, $styles);
}

add_filter('ope_pro_scss_files', 'ope_get_woo_scss');

function ope_get_woo_scss($files)
{

    $files[] = "Woo";

    return $files;
}



function ope_woo_get_sidebar($slug)
{
    $is_enabled = get_theme_mod("ope_woo_is_sidebar_{$slug}_enabled", true);

    if ($is_enabled) {
        get_sidebar("woocommerce-{$slug}");
    }
}

function ope_woo_container_class($echo = true)
{
    $class = array();

    $is_left_sb_enabled  = is_active_sidebar('ope_pro_woocommerce_sidebar_left');
    $is_right_sb_enabled = is_active_sidebar("ope_pro_woocommerce_sidebar_right");
    $sidebars            = intval($is_left_sb_enabled) + intval($is_right_sb_enabled);

    if (is_archive()) {
        $class = array("enabled-sidebars-{$sidebars}");
    }

    $class = apply_filters('ope_woo_container_class', $class);

    if ($echo) {
        echo implode(" ", $class);;
    }

    return implode(" ", $class);
}


function ope_woo_container_class_hide_title($classes) {
    if (one_page_express_is_woocommerce_product_page()) {
        $template = get_theme_mod("ope_woo_product_header_type", "default");
        if ($template == "default") {
            array_push($classes, "no-title");
        }
    }
    return $classes;
}

add_filter('ope_woo_container_class', 'ope_woo_container_class_hide_title');


add_action('wp_head', function () {
    $ver = ope_get_pro_version();
    wp_enqueue_script('one-page-express-woo', get_stylesheet_directory_uri() . "/assets/js/ope-woo.js", array('jquery'), $ver);
});


add_filter('one_page_express_header_title', function ($title) {

    if (ope_is_page_template()) {
        if (is_archive() && ope_get_current_template() === "woocommerce.php") {
            $title = woocommerce_page_title(false);
        }
    }

    return $title;
});


add_filter('woocommerce_show_page_title', '__return_false');

add_filter('ope_compiled_scss_deps', function ($deps) {
    $deps[] = 'ope-woo';

    return $deps;
});


add_filter( 'woocommerce_cross_sells_total', 'ope_cross_sells_product_no' );
  
function ope_cross_sells_product_no( $columns ) {
    return 2;
}


add_action('woocommerce_before_shop_loop', 'ope_woo_cart_button', 5);

function ope_woo_cart_button()
{
    $fragments = opr_woo_cart_button(array());
    ?>
    <div class="cart-contents-content">
        <h4><?php echo __('Cart Content: ', 'one-page-expres-pro'); ?></h4>
        <?php echo $fragments['a.cart-contents']; ?>
        <?php woocommerce_breadcrumb(); ?>
    </div>
    <?php
}

add_filter('woocommerce_add_to_cart_fragments', 'opr_woo_cart_button');

function opr_woo_cart_button($fragments)
{
    global $woocommerce;
    ob_start();
    ?>

    <a class="cart-contents button big" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'one-page-express-pro'); ?>">
        <i class="fa fa-shopping-cart"></i>
        <?php
        echo
            /* translators: %d is number of items */
        sprintf(_n('%d item', '%d items', absint($woocommerce->cart->cart_contents_count), 'one-page-express-pro'), absint($woocommerce->cart->cart_contents_count)); ?> - <?php echo wp_kses($woocommerce->cart->get_cart_total(), array(
            'span' => array(
                'class' => array(),
            ),
        )); ?></a>
    <?php
    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}

add_action('woocommerce_before_single_product_summary', 'woocommerce_breadcrumb', 5, 0);

add_filter('ope_pro_override_with_thumbnail_image', function ($value) {

    global $product;

    if (isset($product)) {
        $value = get_theme_mod('ope_woo_product_header_image', true);

        $value = (intval($value) === 1);

    }

    return $value;
});

add_action('woocommerce_before_shop_loop', function () {

    ?>
    <div class="products-list-wrapper">
    <?php
    ope_woo_get_sidebar('left');
}, 1000);


add_action('woocommerce_after_shop_loop', function () {

    ope_woo_get_sidebar('right');
    ?>
    </div>
    <?php

}, 0);

add_filter('woocommerce_rest_check_permissions', function ($permission, $context, $n, $object) {

    $nonce        = isset($_REQUEST['ope_woo_api_nonce']) ? $_REQUEST['ope_woo_api_nonce'] : '';
    $isNonceValid = is_ope_woo_api_key_valid($nonce);
    if ($isNonceValid && $context === "read") {
        {
            return true;
        }
    }

    return $permission;

}, 10, 4);


function ope_woo_query_maybe_add_category_args($args, $category, $operator = "IN")
{
    if ( ! empty($category)) {
        if (empty($args['tax_query'])) {
            $args['tax_query'] = array();
        }
        $args['tax_query'][] = array(
            array(
                'taxonomy' => 'product_cat',
                'terms'    => array_map('sanitize_title', explode(',', $category)),
                'field'    => 'id',
                'operator' => $operator,
            ),
        );
    }

    return $args;
}

function ope_woo_query_maybe_add_tags_args($args, $tag, $operator = "IN")
{
    if ( ! empty($tag)) {
        if (empty($args['tax_query'])) {
            $args['tax_query'] = array();
        }
        $args['tax_query'][] = array(
            array(
                'taxonomy' => 'product_tag',
                'terms'    => array_map('sanitize_title', explode(',', $tag)),
                'field'    => 'id',
                'operator' => $operator,
            ),
        );
    }

    return $args;
}



add_filter('body_class', 'ope_wc_body_class', 20);

function ope_wc_body_class($classes)
{
    global $post;

    if (in_array('woocommerce', $classes)) {
        $classes[] = 'page';
    }


    return $classes;
}