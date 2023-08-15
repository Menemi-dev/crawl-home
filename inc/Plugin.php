<?php

namespace CrawlHome;

use CrawlHome\Classes\Crawler;
use CrawlHome\Classes\Sitemap;

defined( 'ABSPATH' ) || exit;

class Plugin {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_post_start_crawling', [ $this, 'start_crawling_homepage' ] );
	}

	/**
	 * Initiates the crawling tasks
	 */
	public function start_crawling_homepage() {
		$crawler = new Crawler( CRAWL_HOME_TRANSIENT );
		$crawler->init();

		crawl_home_save_html_file( CRAWL_HOME_HTML_PATH . 'homepage.html', CRAWL_HOME_URL );

		$sitemap = new Sitemap( CRAWL_HOME_TRANSIENT );
		$sitemap->delete_sitemap();
		$sitemap->create_sitemap();

		$this->cron_job();

		$goback = add_query_arg(
			[
				'display-results' => 'true',
				'_wpnonce'        => wp_create_nonce( 'ch_view_results' ),
			],
			admin_url( 'admin.php?page=crawl-home' )
		);
		wp_safe_redirect( $goback );

		exit();
	}

	/**
	 * Creates a cron job to run the crawling event every hour
	 */
	public function cron_job() {
		add_action( 'crawl_home_cron', [ $this, 'start_crawling_homepage' ], 10, 2 );

		if ( wp_next_scheduled( 'crawl_home_cron' ) ) {
			wp_clear_scheduled_hook( 'crawl_home_cron' );
		}

		wp_schedule_event( time(), 'hourly', 'crawl_home_cron' );
	}
}
