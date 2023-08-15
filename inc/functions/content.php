<?php

defined( 'ABSPATH' ) || exit;

/**
 * Retrieves a web page content
 *
 * @param string $url URL to retrieve content from.
 * @return string Content of the page
 */
function crawl_home_get_url_content( $url ) {
	$page = wp_remote_get( $url );
	return wp_remote_retrieve_body( $page );
}

/**
 * Creates a file with content from a web page
 *
 * @param string $name Name of the file.
 * @param string $url URL of the content to save on file.
 */
function crawl_home_save_html_file( $name, $url ) {
	$html = crawl_home_get_url_content( $url );
	file_put_contents( $name, $html );
}
