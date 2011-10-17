<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage UW Theme
 * @since UW Theme 0.2.0
 */

$options = uwtheme_get_default_theme_options();
$current_layout = $options['theme_layout'];

if ( 'content' != $current_layout ) :
?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
          <?php // put the default widgets here if desired ?>
			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary .widget-area -->
<?php endif; ?>

