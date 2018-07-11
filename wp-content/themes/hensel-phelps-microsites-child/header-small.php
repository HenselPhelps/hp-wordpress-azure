<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="header-top alternate <?php one_page_express_header_main_class(true) ?> small" <?php one_page_express_navigation_sticky_attrs(true) ?>>
    <?php ope_print_navigation(); ?>
</div>

<div id="page" class="site">
