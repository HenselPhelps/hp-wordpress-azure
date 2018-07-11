<?php

/*
Template Name: Page With Navigation Only
*/


one_page_express_get_header('small');

?>

    <div class="page-content">
            <?php
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/content', 'page' );
            endwhile;
            ?>
    </div>

<?php one_page_express_get_footer(); ?>