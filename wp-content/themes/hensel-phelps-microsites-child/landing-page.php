<?php
/*
Template Name: Landing Page
*/

one_page_express_get_header('empty');
?>
    <div class="page-content flexbox-list flexbox-list-align-center landing page-content">
        <?php
        while (have_posts()) : the_post();
            get_template_part('template-parts/content', 'page');
        endwhile;
        ?>
    </div>
<?php get_footer('empty'); ?>