<?php

namespace CrawlHome\Classes;

class Sitemap {

	/**
	 * Name of the transient were results are located
	 *
	 * @var string
	 */
	private $transient = '';

	/**
	 * Constructor
	 *
	 * @param string $transient Name of the transient.
	 */
	public function __construct( $transient ) {
		$this->transient = $transient;
	}

	/**
	 * Generates the file sitemap.html
	 */
	public function create_sitemap() {
		$results = get_transient( $this->transient );
		if ( ! $results ) {
			$results = [ 'There are no results to display. Start a new crawling process.' ];
		}
		ob_start();
		if ( get_option( 'page_on_front' ) !== 0 ) {
			@get_header();
		}
		echo "<div class='container page' style='text-align: center; padding-top: 2rem;'><h1>Site Map</h1>";
		include_once CRAWL_HOME_PATH . 'views/settings/results-area.php';
		echo '</div>';
		if ( get_option( 'page_on_front' ) !== 0 ) {
			@get_footer();
		}
		$content = ob_get_contents();
		ob_end_clean();
		file_put_contents( CRAWL_HOME_HTML_PATH . 'sitemap.html', $content );
	}

	/**
	 * Deletes sitemap.html
	 */
	public function delete_sitemap() {
		wp_delete_file( CRAWL_HOME_HTML_PATH . 'sitemap.html' );
	}
}
