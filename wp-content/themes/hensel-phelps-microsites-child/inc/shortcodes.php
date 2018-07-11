<?php

function ope_placeholder_p($text)
{
    return '<p class="ope-placeholder-p"
		style="
	                padding: 80px 20px; 
	                background: #f3f0f8; 
	                text-align: center; 
	                text-transform: uppercase; 
	                font-weight: bold; 
	                font-size: 0.8em; 
	                color: hsla(263, 0%, 67%, 1);"
		>
			' . $text . '
		</p>';
}

add_shortcode('ope_shortcode_placeholder', 'ope_shortcode_placeholder');

function ope_shortcode_placeholder()
{
    return ope_placeholder_p('This is a placeholder<br/>Replace this with your custom shortcode');
}

add_shortcode('ope_display_widgets_area', 'ope_display_widgets_area');


function ope_display_widgets_area($atts)
{
    $atts = shortcode_atts(array(
        'id' => '',
    ), $atts);

    $content = '';

    if (empty($atts['id'])) {
        $content = ope_placeholder_p('This is a placeholder<br/>Configure this to display a "widgets area"');
    } else {
        $sidebars_widgets = wp_get_sidebars_widgets();
        if (empty($sidebars_widgets[$atts['id']])) {
            $widgets_areas_mod = get_theme_mod('ope_pro_users_custom_widgets_areas', array());
            $index             = str_replace('ope_pro_users_custom_widgets_area_', '', $atts['id']);
            $name              = 'Widgets Area';
            if (isset($widgets_areas_mod[$index])) {
                $name = $widgets_areas_mod[$index]['name'];
                $name = "\"{$name}\" Widgets Area";
            }

            $content = ope_placeholder_p($name . ' is empty<br/>Configure it from WP Admin');
        }

        ob_start();
        dynamic_sidebar($atts['id']);
        $content .= ob_get_clean();

    }


    $content = '<div data-name="ope-widgets-area">' . $content . '</div>';

    return $content;
}

add_shortcode('ope_display_woocommerce_items', 'ope_display_woocommerce_items');

function ope_display_woocommerce_items($atts)
{
    $atts = shortcode_atts(array(
        'id'              => '',
        'products_number' => '6',
        'filter' => 'all',
        'columns'         => '3',
        'columns_tablet'  => '2',
        'order'           => 'DESC',
        'order_by'        => 'date',
        'categories'      => '',
        'tags'            => '',
        'products'        => '',
        'custom'          => "false",
    ), $atts);

    $content = "";


    $query_args = array();

    if ( ! class_exists('WooCommerce')) {
        return ope_placeholder_p('This element needs the WooCommerce plugin to be installed');
    } else {
        if (json_decode($atts['custom'])) {
            $atts['custom'] = true;
            if (empty($atts['products']) || $atts['products'] === 'null') {
                return ope_placeholder_p('Select some products to be displayed here');
            } else {
                $query_args = array(
                    'post_type'           => 'product',
                    'post_status'         => 'publish',
                    'ignore_sticky_posts' => 1,
                    'posts_per_page'      => -1,
                    'meta_query'          => WC()->query->get_meta_query(),
                    'tax_query'           => WC()->query->get_tax_query(),
                );

                $query_args['post__in'] = array_map('trim', explode(',', $atts['products']));
            }
        } else {
            $atts['custom'] = false;
            $query_args     = array(
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page'      => intval($atts['products_number']),
                'order'               => $atts['order'],
                'meta_query'          => WC()->query->get_meta_query(),
                'tax_query'           => WC()->query->get_tax_query(),
            );


            switch ( $atts['order_by'] ) {
                case 'price' :
                    $query_args['meta_key'] = '_price';
                    $query_args['orderby']  = 'meta_value_num';
                    break;
                case 'random' :
                    $query_args['orderby']  = 'rand';
                    break;
                case 'sales' :
                    $query_args['meta_key'] = 'total_sales';
                    $query_args['orderby']  = 'meta_value_num';
                    break;
                case 'rating' :
                    $query_args['meta_key'] = '_wc_average_rating';
                    $query_args['orderby']  = 'meta_value_num';
                    break;
                default :
                    $query_args['orderby']  = 'date';
            }

            if ($atts['categories'] && ! empty($atts['categories']) && $atts['categories'] !== 'null') {
                $query_args = ope_woo_query_maybe_add_category_args($query_args, $atts['categories']);
            }

            if ($atts['tags'] && ! empty($atts['tags']) && $atts['tags'] !== 'null') {
                $query_args = ope_woo_query_maybe_add_tags_args($query_args, $atts['tags']);
            }


            if ($atts['filter'] == "onsale") {
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $query_args['post__in'] = $product_ids_on_sale;
            }

            if ($atts['filter'] == "featured") {
                $product_visibility_term_ids = wc_get_product_visibility_term_ids();
                $query_args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'term_taxonomy_id',
                    'terms'    => $product_visibility_term_ids['featured'],
                );
            }

           

        }
    }

    $content = ope_woocommerce_items_do_query($query_args, $atts, 'products');

    return $content;
}

function ope_woocommerce_items_do_query_post_classes_filter($classes)
{
    $atts = isset($GLOBALS['ope_woocommerce_items_do_query_atts']) ? $GLOBALS['ope_woocommerce_items_do_query_atts'] : false;

    if ( ! ($atts)) {
        return $classes;
    }

    $width        = 12 / $atts['columns'];
    $width_tablet = 12 / $atts['columns_tablet'];

    $classes[] = "cp{$width}cols";
    $classes[] = "cp{$width_tablet}cols-tablet";
    $classes[] = "in-page-section";


    return $classes;
}

function ope_woocommerce_items_do_query($query_args, $atts, $loop_name)
{

    $products = new WP_Query($query_args);

    // sort as added in the list
    if ($atts['custom'] === true) {
        $ids = $query_args['post__in'];
        usort($products->posts, function ($a, $b) use ($ids) {
            $apos = array_search($a->ID, $ids);
            $bpos = array_search($b->ID, $ids);

            return ($apos < $bpos) ? -1 : 1;
        });
    }

    ob_start();

    $GLOBALS['ope_woocommerce_items_do_query_atts'] = $atts;
    add_filter('post_class', 'ope_woocommerce_items_do_query_post_classes_filter');

    if ($products->have_posts()) {
        do_action("woocommerce_shortcode_before_{$loop_name}_loop", $atts); ?>

        <?php woocommerce_product_loop_start(); ?>

        <?php while ($products->have_posts()) : $products->the_post(); ?>

            <?php wc_get_template_part('content', 'product'); ?>

        <?php endwhile; // end of the loop. ?>

        <?php woocommerce_product_loop_end(); ?>

        <?php do_action("woocommerce_shortcode_after_{$loop_name}_loop", $atts); ?>

        <?php
    } else {
        echo ope_placeholder_p('No products to display');
    }


    woocommerce_reset_loop();
    wp_reset_postdata();

    remove_filter('post_class', 'ope_woocommerce_items_do_query_post_classes_filter');
    $GLOBALS['ope_woocommerce_items_do_query_atts'] = false;

    return '<div class="woocommerce in-section">' . ob_get_clean() . '</div>';
}


add_shortcode('ope_woo_shop_url', 'ope_woo_shop_url');

function ope_woo_shop_url()
{
    if ( ! function_exists('wc_get_page_permalink')) {
        return '#';
    }

    $shop_page_url = wc_get_page_permalink('shop');

    return $shop_page_url;
}


// gallery


add_shortcode('ope_gallery', 'ope_gallery_shortcode');


$ope_gallery_index = 0;


function ope_gallery_masonry_script($atts)
{
    $script             = "";
    $isShortcodeRefresh = apply_filters('is_shortcode_refresh', false);
    if ($atts['masonry'] == 1) {
        ob_start();
        ?>
        (function ($) {
        var masonryGallery = $(".<?php echo $atts['id'] ?>-dls-wrapper");

        masonryGallery.masonry({
        itemSelector: '.gallery-item',
        percentPosition: true,
        });

        var images = masonryGallery.find('img');
        var loadedImages = 0;

        function imageLoaded() {
        loadedImages++;
        if (images.length === loadedImages) {
        masonryGallery.data().masonry.layout();

        }
        }

        images.each(function () {
        $(this).on('load', imageLoaded);
        });

        $(window).on('load', function () {
        masonryGallery.data().masonry.layout();
        });

        })(<?php ope_print_contextual_jQuery(); ?>);

        <?php
        $script = ob_get_clean();

    } else {
        if ($isShortcodeRefresh) {
            ob_start();
            ?>
            jQuery(function ($) {
            var masonryGallery = $(".<?php echo $atts['id'] ?>-dls-wrapper");
            try {
            masonryGallery.masonry('destroy');
            } catch (e) {

            }
            });
            <?php
            $script = ob_get_clean();

        }
    }

    return $script;
}

function ope_gallery_shortcode($atts)
{
    global $ope_gallery_index;
    $atts = shortcode_atts(
        array(
            'id'      => 'ope-gallery-' . (++$ope_gallery_index),
            'columns' => '3',
            'ids'     => '',
            'link'    => 'file',
            'lb'      => '1',
            'orderby' => '',
            'skin'    => 'skin01',
            'masonry' => '1',
            'size'    => 'medium',
        ),
        $atts
    );


    if (empty($atts['ids'])) {

        $colors = array('03A9F4', '4CAF50', 'FBC02D', '9C27B0');

        ob_start();

        $imagesColors = array();

        ?>
        <div class="<?php echo $atts['id'] ?>-dls-wrapper gallery-items-wrapper">
            <?php for ($img = 0; $img < ($atts['columns'] * 2); $img++): ?>
                <dl class="gallery-item">
                    <dt class="gallery-icon landscape">
                        <?php
                        $colorIndex = $img % count($colors);
                        $color      = $colors[$colorIndex];
                        $data       = sscanf($color, "%02x%02x%02x");
                        $width      = min($data[1], 100) + 400;
                        $height     = min($data[2], 100) + 360;
                        $size       = "{$width}x{$height}";

                        if ($img % 2) {
                            $size = "{$height}x{$width}";
                        }

                        if ($atts['masonry'] == '0') {
                            $size = "400x400";
                        }
                        ?>
                        <a data-fancybox="<?php echo $atts['id'] ?>-group" href="http://placehold.it/<?php echo $size; ?>/<?php echo $color; ?>/ffffff?text=Placeholder">
                            <img src="https://placehold.it/<?php echo $size; ?>/<?php echo $color; ?>/ffffff?text=Placeholder" class="<?php echo $atts['id'] ?>-image" alt=""></a>
                    </dt>
                </dl>
            <?php endfor; ?>
        </div>
        <?php

        $gallery = ob_get_clean();
    } else {


        add_filter('use_default_gallery_style', '__return_false');

        // make sure the gallery_shortcode function will return the default gallery
        // fixes japck issue
        add_filter('post_gallery', '__return_empty_string', PHP_INT_MAX);


        $gallery = gallery_shortcode($atts);

        remove_filter('post_gallery', '__return_empty_string', PHP_INT_MAX); // remove the previous filter
        remove_filter('use_default_gallery_style', '__return_false');

        $gallery = preg_replace("/<br(.*?)>/is", "", $gallery);
        $gallery = preg_replace("/<div(.*?)id='gallery-(.*?)>/", "<div $1 class='" . $atts['id'] . "-dls-wrapper gallery-items-wrapper' >", $gallery);
        $gallery = preg_replace("/<img(.*)class=\"(.*?)\"/", "<img $1 class='" . $atts['id'] . "-image'", $gallery);
        $gallery = $gallery . '<style>#' . $atts['id'] . ' .wp-caption-text.gallery-caption{display:none;}</style>';
    }

    ob_start();

    ?>
    <style type="text/css">
        @media only screen and (min-width: 768px) {
        #<?php echo $atts['id'] ?> dl {
            float: left;
            width: <?php echo (100 / $atts['columns']) ?>% !important;
            max-width: <?php echo (100 / $atts['columns']) ?>% !important;
            min-width: <?php echo (100 / $atts['columns']) ?>% !important;
        }

        #<?php echo $atts['id'] ?> dl:nth-of-type(<?php echo $atts['columns']?>n +1 ) {
                                       clear: both;
                                   }
        }
    </style>
    <?php


    $style = ob_get_clean();

    $gallery = $style . $gallery;

    if ($atts['lb'] == 1) {
        $gallery = preg_replace('/<a/', '<a data-fancybox="' . $atts['id'] . '-group"', $gallery);
    }

    $masonry = ope_gallery_masonry_script($atts);

    $isShortcodeRefresh = apply_filters('is_shortcode_refresh', false);
    if ( ! $isShortcodeRefresh) {
        wp_add_inline_script('masonry', $masonry);
    } else {
        $gallery .= "<script>{$masonry}</script>";
    }


    return "<div id='{$atts['id']}' class='gallery-wrapper'>{$gallery}</div>";

}
