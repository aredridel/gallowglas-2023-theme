<?php get_header(); ?>

<main class="with-sidebars">
    <?php get_template_part( 'parts/404' ); ?>
    <?php get_sidebar( 'primary' ); ?>
    <?php get_sidebar( 'secondary' ); ?>
</main>

<?php get_footer() ?>
