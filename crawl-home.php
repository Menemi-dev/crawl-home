<?php
/**
 * Plugin Name: Crawl Home
 * Plugin URI: https://github.com/Menemi-dev
 * Description: Manually trigger a crawl to view web pages linked to the home page
 * Version: 1.0.0
 */

define( 'CRAWL_HOME_FILE', __FILE__ );
define( 'CRAWL_HOME_PATH', realpath( plugin_dir_path( CRAWL_HOME_FILE ) ) . '/' );
define( 'CRAWL_HOME_INC_PATH', realpath( CRAWL_HOME_PATH . 'inc/' ) . '/' );
define( 'CRAWL_HOME_HTML_PATH', realpath( CRAWL_HOME_PATH . 'html/' ) . '/' );
define( 'CRAWL_HOME_ADMIN_PATH', realpath( CRAWL_HOME_INC_PATH . 'admin' ) . '/' );
define( 'CRAWL_HOME_FUNCTIONS_PATH', realpath( CRAWL_HOME_INC_PATH . 'functions/' ) . '/' );
define( 'CRAWL_HOME_URL', get_home_url() );
define( 'CRAWL_HOME_TRANSIENT', 'homepage_crawling_results' );
define( 'CRAWL_HOME_SITEMAP_ROUTE', 'sitemap/home' );


require CRAWL_HOME_INC_PATH . 'main.php';
