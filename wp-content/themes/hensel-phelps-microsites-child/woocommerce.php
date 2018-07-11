<?php

one_page_express_get_header();

?>
    <div class="content-wrapper">
        <div class="page-column gridContainer">
            <div class="page-row">

                <div class="woocommerce-page-content <?php ope_woo_container_class(); ?>">
                    <?php woocommerce_content(); ?>
                </div>

            </div>
        </div>
    </div>
<?php one_page_express_get_footer(); ?>