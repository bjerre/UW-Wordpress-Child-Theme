<?php
/**
 * The Sidebar containing the left widgets under the navigation
 *
 * @package WordPress
 * @subpackage UW Theme
 * @since UW Theme 0.6.0
 */
?>
		<div id="left-widgets" class="widget-area" role="complementary">

			<?php if ( ! dynamic_sidebar( 'sidebar-2' ) ) : ?>
          <?php // put the default widgets here if desired ?>
			<?php endif; // end sidebar widget area ?>

		</div><!-- #secondary .widget-area -->
