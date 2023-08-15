<?php

use CrawlHome\Plugin;

defined( 'ABSPATH' ) || exit;

// Composer autoload.
if ( file_exists( CRAWL_HOME_PATH . 'vendor/autoload.php' ) ) {
	require CRAWL_HOME_PATH . 'vendor/autoload.php';
}

// Auxiliary functions.
require_once CRAWL_HOME_FUNCTIONS_PATH . 'content.php';

/**
 * Serves sitemap.html file on front-end
 *
 * @param WP $wp Current WordPress environment instance (passed by reference).
 */
function crawl_home_create_sitemap_route( $wp ) {
	if ( preg_match( '#' . CRAWL_HOME_SITEMAP_ROUTE . '?#', $wp->request, $matches ) ) {
		if ( ! file_exists( CRAWL_HOME_HTML_PATH . 'sitemap.html' ) ) {
			status_header( 404 );
			$file = get_query_template( '404' );
		} else {
			$file = CRAWL_HOME_HTML_PATH . 'sitemap.html';
		}

		include_once $file;
		exit;
	}
}
add_action( 'parse_request', 'crawl_home_create_sitemap_route' );

/**
 * Tell WP what to do when plugin is loaded.
 */
function crawl_home_init() {
	if ( is_admin() ) {
		new Plugin();
		require CRAWL_HOME_ADMIN_PATH . 'admin.php';
	}
}
add_action( 'plugins_loaded', 'crawl_home_init' );

/**
 * Clears cron job and transient on plugin deactivation
 */
function crawl_home_deactivate() {
	wp_clear_scheduled_hook( 'crawl_home_cron' );
	delete_transient( CRAWL_HOME_TRANSIENT );
}
register_deactivation_hook( CRAWL_HOME_FILE, 'deactivate' );
