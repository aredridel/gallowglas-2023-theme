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

class GG2023ThemeUpdateChecker {

	public $theme_slug;
	public $version;
	public $cache_key;
	public $cache_allowed;

	public function __construct() {

		$this->theme_slug = 'gallowglas-2023';
		$this->version = wp_get_theme()->get("Version");
		$this->cache_key = 'gg2023_custom_update';
		$this->cache_allowed = false;

		add_filter( 'themes_api', array( $this, 'info' ), 20, 3 );
		add_filter( 'site_transient_update_themes', array( $this, 'update' ) );
		add_action( 'upgrader_process_complete', array( $this, 'purge' ), 10, 2 );

	}

	public function request(){

		$remote = get_transient( $this->cache_key );

		if( false === $remote || ! $this->cache_allowed ) {

			$remote = wp_remote_get(
				'https://aredridel.github.io/gallowglas-2023-theme/info.json',
				array(
					'timeout' => 10,
					'headers' => array(
						'Accept' => 'application/json'
					)
				)
			);

			if(
				is_wp_error( $remote )
				|| 200 !== wp_remote_retrieve_response_code( $remote )
				|| empty( wp_remote_retrieve_body( $remote ) )
			) {
				return false;
			}

			set_transient( $this->cache_key, $remote, DAY_IN_SECONDS );

		}

		$remote = json_decode( wp_remote_retrieve_body( $remote ) );

		return $remote;

	}


	function info( $res, $action, $args ) {

		// print_r( $action );
		// print_r( $args );

		// do nothing if you're not getting theme information right now
		if( 'theme_information' !== $action ) {
			return $res;
		}

		// do nothing if it is not our theme
		if( $this->theme_slug !== $args->slug ) {
			return $res;
		}

		// get updates
		$remote = $this->request();

		if( ! $remote ) {
			return $res;
		}

		$res = [
			"name" => $remote->name,
			"slug" => $remote->slug,
			"version" => $remote->version,
			"tested" => $remote->tested,
			"requires" => $remote->requires,
			"author" => $remote->author,
			"author_profile" => $remote->author_profile,
			"download_link" => $remote->download_url,
			"trunk" => $remote->download_url,
			"requires_php" => $remote->requires_php,
			"last_updated" => $remote->last_updated,
			'sections' => [
				'description' => $remote->sections->description,
				'installation' => $remote->sections->installation,
				'changelog' => $remote->sections->changelog
			]
		];

		return $res;

	}

	public function update( $transient ) {

		if ( empty($transient->checked ) ) {
			return $transient;
		}

		$remote = $this->request();

		if(
			$remote
			&& version_compare( $this->version, $remote->version, '<' )
			&& version_compare( $remote->requires, get_bloginfo( 'version' ), '<=' )
			&& version_compare( $remote->requires_php, PHP_VERSION, '<' )
		) {
			$res = [
				"slug" => $this->theme_slug,
				"theme" => 'Gallowglas 2023',
				"new_version" => $remote->version,
				"tested" => $remote->tested,
				"package" => $remote->download_url
			];

			$transient->response[ $res['theme'] ] = $res;

	}

		return $transient;

	}

	public function purge( $upgrader, $options ){

		if (
			$this->cache_allowed
			&& 'update' === $options['action']
			&& 'theme' === $options[ 'type' ]
		) {
			// just clean the cache when new theme version is installed
			delete_transient( $this->cache_key );
		}

	}


}

new GG2023ThemeUpdateChecker();

