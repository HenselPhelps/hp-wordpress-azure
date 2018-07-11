<?php
/*
 * Template Name: Full Width Page Template
 */
get_header();
?>

<div class="page-content">

    <?php
    while (have_posts()) : the_post();
        get_template_part('template-parts/content', 'full-width-page');
    endwhile;
    ?>
</div>
<?php one_page_express_get_footer(); ?>
