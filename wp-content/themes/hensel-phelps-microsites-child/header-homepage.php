<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="header-top homepage <?php one_page_express_header_main_class() ?>" <?php one_page_express_navigation_sticky_attrs() ?>>
    <?php ope_print_navigation(); ?>
</div>

<div id="page" class="site">
    <div class="header-wrapper">
        <div <?php echo one_page_express_background() ?>>
            <?php one_page_express_print_video_container(); ?>
            <?php $desctipion_classes = get_theme_mod('one_page_express_header_content_partial', "content-on-center"); ?>
            <?php $desctipion_classes = apply_filters('one_page_express_header_description_classes', $desctipion_classes); ?>
            <div class="header-description gridContainer <?php echo esc_attr($desctipion_classes); ?>">
                <?php
                $one_page_express_header_content_partial = get_theme_mod('one_page_express_header_content_partial', "content-on-center");
                get_template_part('template-parts/header/hero', $one_page_express_header_content_partial);
                ?>
            </div>
        </div>
        <?php
        one_page_express_header_separator();
        do_action('one_page_express_after_header_content');
        ?>
    </div>

