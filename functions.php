<?php

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
});
register_nav_menus([
	'primary-menu' => __( 'Primary Menu' ),
]);


add_action( 'after_setup_theme', function () {
	add_theme_support( 'body-open' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'woocommerce' );
	remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
});

add_action( 'widgets_init', function () {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'gallowglas-2023' ),
		'id'            => 'primary',
		'before_widget' => '<div id="%1$s" class="cover %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Secondary Sidebar', 'gallowglas-2023' ),
		'id'            => 'secondary',
		'before_widget' => '<div id="%1$s" class="cover %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
});

add_action('get_header', function() {
    remove_action('wp_head', '_admin_bar_bump_cb');
	add_action("wp_head", function () {
		echo "<style>#wpadminbar { position: sticky !important; }</style>";
	});
});

function gg2023_posted_on() {
	if (get_post_type() === 'page') return;
	$time_string = sprintf( '<time class="entry-date published" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date. */
		esc_html_x( 'Posted on %s', 'post date', 'gg2023' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( 'by %s', 'post author', 'gg2023' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<div class="attribution"><span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span></div>'; 
}

function gg2023_post_footer() {
	if (get_the_modified_date( "c" ) !== get_the_date( "c" )) {
		$time_string = sprintf( 'Updated <time class="entry-date updated" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
		echo '<div class="post-footer">' . $time_string . '</div>';
	}
}
