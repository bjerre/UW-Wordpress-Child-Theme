<?php
/**
 * UW FAQs
 *
 * @package WordPress
 * @subpackage UW Theme
 * @since 0.4.0
 */

/**
 * Add our theme options page to the admin menu, including some help documentation.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since 0.4.0
 */
function uwtheme_theme_faqs_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme FAQs', 'uwtheme' ),   // Name of page
		__( 'Theme FAQs', 'uwtheme' ),   // Label in menu
		'edit_theme_options',                    // Capability required
		'theme_faqs',                         // Menu slug, used to uniquely identify the page
		'uwtheme_theme_faqs_render_page' // Function that renders the options page
	);

  do_action('uwtheme_theme_faqs_add_page');

}
add_action( 'admin_menu', 'uwtheme_theme_faqs_add_page', 8 );

/**
 * Returns the rendered FAQ page
 *
 * @since 0.4.0
 */
function uwtheme_theme_faqs_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme FAQs', 'uwtheme' ), get_current_theme() ); ?></h2>
      <h3>How do I change the background? </h3>
      <h3>How do I turn my pages into a menu? </h3>
      <h3>How do I change the banner image? </h3>
      <h3>How do I add widgets? </h3>

	</div>
	<?php
}
