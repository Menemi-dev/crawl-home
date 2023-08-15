<?php

namespace CrawlHome\Classes;

use DOMDocument;

class Crawler {

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
	 * Deletes old transient and starts crawling tasks
	 */
	public function init() {
		delete_transient( $this->transient );
		$links = $this->get_homepage_links();
		$this->save_results( $links );
	}

	/**
	 * Extracts all the internal hyperlinks from content if a static page is set as the front page
	 * or from the entire page otherwise
	 *
	 * @return HTMLCollection of all elements with an hyperlink tag
	 */
	public function get_homepage_links() {
		if ( get_option( 'page_on_front' ) !== 0 ) {
			$html = get_post_field( 'post_content', get_option( 'page_on_front' ) );
		} else {
			$html = crawl_home_get_url_content( CRAWL_HOME_URL );
		}

		$dom = new DOMDocument();
		@$dom->loadHTML( $html );
		return $dom->getElementsByTagName( 'a' );
	}

	/**
	 * Stores the found links temporarily in the database
	 *
	 * @param HTMLCollection $links Collection of found hiperlinks.
	 */
	public function save_results( $links ) {
		$results = [];
		foreach ( $links as $link ) {
			$url = $link->getAttribute( 'href' );
			if (
				! empty( $url ) && '#' !== $url
				&& strpos( $url, CRAWL_HOME_URL ) !== false
				&& ! in_array( $url, $results, true )
			) {
				$results[] = $link->ownerDocument->saveHTML( $link );
			}
		}
		set_transient( $this->transient, $results, HOUR_IN_SECONDS );
	}
}
