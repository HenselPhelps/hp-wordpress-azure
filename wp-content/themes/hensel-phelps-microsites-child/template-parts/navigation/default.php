<div class="navigation-wrapper <?php one_page_express_navigation_wrapper_class() ?>">
    <div class="logo_col">
        <?php one_page_express_logo(); ?>
    </div>
    <div class="main_menu_col">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_id'        => 'drop_mainmenu',
            'menu_class'     => 'fm2_drop_mainmenu',
            'container_id'   => 'drop_mainmenu_container',
            'fallback_cb'    => 'one_page_express_nomenu_cb',
        ));
        ?>
    </div>
</div>