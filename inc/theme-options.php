<?php
/**
 * UW Theme Options
 *
 * @package WordPress
 * @subpackage UW Theme
 * @since 0.3.0
 */

/**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 * @since 0.3.0
 *
 */
function uwtheme_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'uwtheme-theme-options', get_template_directory_uri() . '/inc/theme-options.css', false, '2011-04-28' );
	wp_enqueue_script( 'uwtheme-theme-options', get_template_directory_uri() . '/inc/theme-options.js', array( 'farbtastic' ), '2011-06-10' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'uwtheme_admin_enqueue_scripts' );

/**
 * Register the form setting for our uwtheme_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, uwtheme_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *
 * @since  0.3.0
 */
function uwtheme_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === uwtheme_get_theme_options() )
		add_option( 'uwtheme_theme_options', uwtheme_get_default_theme_options() );

	register_setting(
		'uwtheme_options',       // Options group, see settings_fields() call in theme_options_render_page()
		'uwtheme_theme_options', // Database option, see uwtheme_get_theme_options()
		'uwtheme_theme_options_validate' // The sanitization callback, see uwtheme_theme_options_validate()
	);
}
add_action( 'admin_init', 'uwtheme_theme_options_init' );

/**
 * Change the capability required to save the 'uwtheme_options' options group.
 *
 * @see uwtheme_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see uwtheme_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * By default, the options groups for all registered settings require the manage_options capability.
 * This filter is required to change our theme options page to edit_theme_options instead.
 * By default, only administrators have either of these capabilities, but the desire here is
 * to allow for finer-grained control for roles and users.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function uwtheme_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_uwtheme_options', 'uwtheme_option_page_capability' );

/**
 * Add our theme options page to the admin menu, including some help documentation.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since 0.3.0
 */
function uwtheme_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'uwtheme' ),   // Name of page
		__( 'Theme Options', 'uwtheme' ),   // Label in menu
		'edit_theme_options',                    // Capability required
		'theme_options',                         // Menu slug, used to uniquely identify the page
		'uwtheme_theme_options_render_page' // Function that renders the options page
	);

	if ( ! $theme_page )
		return;

	$help = '<p>' . __( 'Some themes provide customization options that are grouped together on a Theme Options screen. If you change themes, options may change or disappear, as they are theme-specific. Your current theme, Twenty Eleven, provides the following Theme Options:', 'uwtheme' ) . '</p>' .
			'<ol>' .
				'<li>' . __( '<strong>Link Color</strong>: You can choose the color used for text links on your site. You can enter the HTML color or hex code, or you can choose visually by clicking the "Select a Color" button to pick from a color wheel.', 'uwtheme' ) . '</li>' .
			'</ol>' .
			'<p>' . __( 'Remember to click "Save Changes" to save any changes you have made to the theme options.', 'uwtheme' ) . '</p>' .
			'<p><strong>' . __( 'For more information:', 'uwtheme' ) . '</strong></p>' .
			'<p>' . __( '<a href="http://codex.wordpress.org/Appearance_Theme_Options_Screen" target="_blank">Documentation on Theme Options</a>', 'uwtheme' ) . '</p>' .
			'<p>' . __( '<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'uwtheme' ) . '</p>';

	add_contextual_help( $theme_page, $help );
}
add_action( 'admin_menu', 'uwtheme_theme_options_add_page' );

/**
 * Returns an array of color schemes registered for Twenty Eleven.
 *
 * @since 0.3.0
 */
function uwtheme_color_schemes() {
	$color_scheme_options = array(
		'light' => array(
			'value' => 'light',
			'label' => __( 'Light', 'uwtheme' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/light.png',
			'default_link_color' => '#1b8be0',
		),
		'dark' => array(
			'value' => 'dark',
			'label' => __( 'Dark', 'uwtheme' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/dark.png',
			'default_link_color' => '#e4741f',
		),
	);
	return apply_filters( 'uwtheme_color_schemes', $color_scheme_options );
}


/**
 * Returns the default options for Twenty Eleven.
 *
 * @since 0.3.0
 */
function uwtheme_get_default_theme_options() {
	$default_theme_options = array(
		'color_scheme' => 'light',
		'link_color'   => uwtheme_get_default_link_color( 'light' ),
	);

	return apply_filters( 'uwtheme_default_theme_options', $default_theme_options );
}

/**
 * Returns the default link color for Twenty Eleven, based on color scheme.
 *
 * @since 0.3.0
 *
 * @param $string $color_scheme Color scheme. Defaults to the active color scheme.
 * @return $string Color.
 */
function uwtheme_get_default_link_color( $color_scheme = null ) {
	if ( null === $color_scheme ) {
		$options = uwtheme_get_theme_options();
		$color_scheme = $options['color_scheme'];
	}

	$color_schemes = uwtheme_color_schemes();
	if ( ! isset( $color_schemes[ $color_scheme ] ) )
		return false;

	return $color_schemes[ $color_scheme ]['default_link_color'];
}

/**
 * Returns the options array for Twenty Eleven.
 *
 * @since 0.3.0
 */
function uwtheme_get_theme_options() {
	return get_option( 'uwtheme_theme_options', uwtheme_get_default_theme_options() );
}

/**
 * Returns the options array for Twenty Eleven.
 *
 * @since 0.3.0
 */
function uwtheme_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'uwtheme' ), get_current_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'uwtheme_options' );
				$options = uwtheme_get_theme_options();
				$default_options = uwtheme_get_default_theme_options();
			?>

			<table class="form-table">

				<tr valign="top"><th scope="row"><?php _e( 'Link Color', 'uwtheme' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Link Color', 'uwtheme' ); ?></span></legend>
							<input type="text" name="uwtheme_theme_options[link_color]" id="link-color" value="<?php echo esc_attr( $options['link_color'] ); ?>" />
							<a href="#" class="pickcolor hide-if-no-js" id="link-color-example"></a>
							<input type="button" class="pickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'uwtheme' ); ?>" />
							<div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
							<br />
							<span><?php printf( __( 'Default color: %s', 'uwtheme' ), '<span id="default-color">' . uwtheme_get_default_link_color( $options['color_scheme'] ) . '</span>' ); ?></span>
						</fieldset>
					</td>
				</tr>

			</table>

			<?php submit_button(); ?>
		</form>
	</div>

	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see uwtheme_theme_options_init()
 * @todo set up Reset Options action
 *
 * @since 0.3.0
 */
function uwtheme_theme_options_validate( $input ) {
	$output = $defaults = uwtheme_get_default_theme_options();

	// Color scheme must be in our array of color scheme options
	if ( isset( $input['color_scheme'] ) && array_key_exists( $input['color_scheme'], uwtheme_color_schemes() ) )
		$output['color_scheme'] = $input['color_scheme'];

	// Our defaults for the link color may have changed, based on the color scheme.
	$output['link_color'] = $defaults['link_color'] = uwtheme_get_default_link_color( $output['color_scheme'] );

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
		$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	return apply_filters( 'uwtheme_theme_options_validate', $output, $input, $defaults );
}

/**
 * Enqueue the styles for the current color scheme.
 *
 * @since 0.3.0
 */
function uwtheme_enqueue_color_scheme() {
	$options = uwtheme_get_theme_options();
	$color_scheme = $options['color_scheme'];

	if ( 'dark' == $color_scheme )
		wp_enqueue_style( 'dark', get_template_directory_uri() . '/colors/dark.css', array(), null );

	do_action( 'uwtheme_enqueue_color_scheme', $color_scheme );
}
add_action( 'wp_enqueue_scripts', 'uwtheme_enqueue_color_scheme' );

/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since 0.3.0
 */
function uwtheme_print_link_color_style() {
	$options = uwtheme_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = uwtheme_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
	<style>
		/* Link color */
		a,
		#site-title a:focus,
		#site-title a:hover,
		#site-title a:active,
		.entry-title a:hover,
		.entry-title a:focus,
		.entry-title a:active,
		.widget_twentyeleven_ephemera .comments-link a:hover,
		section.recent-posts .other-recent-posts a[rel="bookmark"]:hover,
		section.recent-posts .other-recent-posts .comments-link a:hover,
		.format-image footer.entry-meta a:hover,
		#site-generator a:hover {
			color: <?php echo $link_color; ?>;
		}
		section.recent-posts .other-recent-posts .comments-link a:hover {
			border-color: <?php echo $link_color; ?>;
		}
		article.feature-image.small .entry-summary p a:hover,
		.entry-header .comments-link a:hover,
		.entry-header .comments-link a:focus,
		.entry-header .comments-link a:active,
	</style>
<?php
}
add_action( 'wp_head', 'uwtheme_print_link_color_style' );
