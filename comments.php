<?php if ( post_password_required() ) : ?>
	<div id="comments">
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'gallowglas2023' ); ?></p>
	</div><!-- #comments -->
	<?php
	/*
	 * Stop the rest of comments.php from being processed,
	 * but don't kill the script entirely -- we still have
	 * to fully load the template.
	 */
	return; ?>
<?php elseif ( have_comments() ) : ?>
	<div id="comments">
		<h3 id="comments-title">
			<?php
			if ( '1' === get_comments_number() ) {
				printf(
					/* translators: %s: The post title. */
					__( 'One Response to %s', 'gallowglas2023' ),
					'<em>' . get_the_title() . '</em>'
				);
			} else {
				printf(
					/* translators: 1: The number of comments, 2: The post title. */
					_n( '%1$s Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'gallowglas2023' ),
					number_format_i18n( get_comments_number() ),
					'<em>' . get_the_title() . '</em>'
				);
			}
			?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
				<div class="navigation">
					<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'gallowglas2023' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'gallowglas2023' ) ); ?></div>
				</div> <!-- .navigation -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="commentlist">
			<?php
				/*
				 * Loop through and list the comments. Tell wp_list_comments()
				 * to use gallowglas2023_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define gallowglas2023_comment() and that will be used instead.
				 * See gallowglas2023_comment() in gallowglas2023/functions.php for more.
				 */
				wp_list_comments( array( 'callback' => 'gallowglas2023_comment' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'gallowglas2023' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'gallowglas2023' ) ); ?></div>
			</div><!-- .navigation -->
		<?php endif; // Check for comment navigation. ?>

		<?php
		/*
		 * If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		?>
		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="nocomments"><?php _e( 'Comments are closed.', 'gallowglas2023' ); ?></p>
		<?php endif; ?>
	</div>

<?php endif; // End have_comments(). ?>

<?php comment_form(); ?>
