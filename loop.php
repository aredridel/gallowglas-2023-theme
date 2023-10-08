<section class="posts">

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

			<?php if (is_singular()) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
				</div>
			<?php elseif ( $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'gg2023' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'gg2023' ) ); ?></div>
				</div>
			<?php endif ?>

		<?php endwhile ?>

	<?php else: ?>

		<?php get_template_part( 'parts/content', 'none' ); ?>

	<?php endif ?>
</section>
