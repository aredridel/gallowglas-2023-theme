<?php get_header(); ?>

<main class="with-sidebars">

    <?php if ( have_posts() ): ?>

        <?php while ( have_posts() ): ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php the_post(); ?>
                <h2><?php the_title(); ?></h2>
                <?php the_post_thumbnail(); ?>
                <?php gg2023_posted_on() ?>
                <?php the_content(); ?>
                <?php gg2023_post_footer() ?>
            </article>

        <?php endwhile ?>

    <?php else: ?>

        <?php get_template_part( 'parts/content', 'none' ); ?>

    <?php endif ?>

    <?php get_sidebar( 'primary' ); ?>
    <?php get_sidebar( 'secondary' ); ?>
</main>

<?php get_footer() ?>
