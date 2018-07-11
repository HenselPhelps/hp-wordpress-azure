<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="header-top <?php one_page_express_header_main_class(true) ?>" <?php one_page_express_navigation_sticky_attrs(true) ?>>
    <?php ope_print_navigation(); ?>
</div>

<div id="page" class="site">
    <div class="header-wrapper">
        <div <?php echo one_page_express_background(true) ?>>
            <?php one_page_express_print_video_container(true); ?>

            <div class="inner-header-description gridContainer">
                <div class="row header-description-row">
                    <?php
                    $one_page_express_inner_header_show_title = get_theme_mod('one_page_express_inner_header_show_title', true);
                    if ($one_page_express_inner_header_show_title):
                        ?>
                        <h1 class="heading8">
                            <?php echo one_page_express_title(); ?>
                        </h1>
                    <?php endif;

                    $is_woocommerce = one_page_express_is_woocommerce();

                    $one_page_express_inner_header_show_subtitle = get_theme_mod('one_page_express_inner_header_show_subtitle', true);
                    if ($one_page_express_inner_header_show_subtitle && ope_post_type_is(array('post','attachment')) && !$is_woocommerce) :
                        ?>
                        <p class="header-subtitle"><?php echo esc_html(get_bloginfo('description')); ?></p>
                    <?php endif ?>
                </div>
            </div>
            <?php
            one_page_express_header_separator(true);
            ?>
        </div>
    </div>