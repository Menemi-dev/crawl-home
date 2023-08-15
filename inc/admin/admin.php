<?php

defined( 'ABSPATH' ) || exit;

/**
 * Adds the plugin menu page to the Settings main menu
 */
function crawl_home_add_settings_page() {
	add_options_page( 'Crawl Home', 'Crawl Home', 'manage_options', 'crawl-home', 'crawl_home_render_settings_page' );
}
add_action( 'admin_menu', 'crawl_home_add_settings_page' );

/**
 * Renders the plugin menu page
 */
function crawl_home_render_settings_page() {
	include_once CRAWL_HOME_PATH . 'views/settings/admin-page.php';

	if ( isset( $_GET['display-results'] ) && isset( $_GET['_wpnonce'] )
		&& wp_verify_nonce( $_GET['_wpnonce'], 'ch_view_results' ) ) {
			$results = get_transient( CRAWL_HOME_TRANSIENT );

		if ( ! $results ) {
			$results = [ 'There are no results to display. Start a new crawling process.' ];
		}

		include_once CRAWL_HOME_PATH . 'views/settings/results-area.php';
	}
}
