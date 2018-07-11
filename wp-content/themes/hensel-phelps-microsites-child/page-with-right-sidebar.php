<?php
/*
Template Name: Page With Right Sidebar
*/

one_page_express_get_header();
?>
    <div class="content-wrapper">
        <div class="page-column gridContainer">
            <div class="page-row">
                <div class="page-content">
					<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content', 'full-width-page' );
					endwhile;
					?>
                </div>
                <?php get_sidebar('pages'); ?>
            </div>
        </div>
    </div>
<?php one_page_express_get_footer(); ?>