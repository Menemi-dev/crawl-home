<?php

defined( 'ABSPATH' ) || exit;

/**
 * Area to display the extracted internal hyperlinks
 *
 * @param Array $results Array of hyperlinks
 */
?>

<div class="wrap container crawl-home__results-area">
  <?php
	foreach ( $results as $result ) {
		?>
	  <p>
		<?php echo $result; ?>
	  </p>
		<?php
	}
	?>
</div>
