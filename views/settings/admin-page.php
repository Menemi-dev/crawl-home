<?php

defined( 'ABSPATH' ) || exit;

/**
 * Admin side menu template
 */
?>

<div class="wrap">
  <h1>Crawl Home</h1>
  <p>To start crawling the homepage click on the "Start Crawling" button.
	It will generate new results and set a new crawling every hour.</p>
  <p>Use the "View Results" button to display the results.
	If there are no results to display, start a new crawling process.</p>
  <form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
	<input type="hidden" name="action" value="start_crawling">
	<input type="submit" class="button button-primary" value="Start Crawling">
  </form>
  <br>
  <a href="
    <?php
    echo add_query_arg(
      [
        'display-results' => 'true',
        '_wpnonce'        => wp_create_nonce( 'ch_view_results' ),
      ],
      admin_url( 'admin.php?page=crawl-home' )
    );
    ?>
	"
	class="button">
	View Results
  </a>
</div>
