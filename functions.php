<?php

/**
 * Set the content width for the theme
 */

if( ! isset( $content_width ) )
  $content_width = 584;

/**
 * Setup the theme settings when activated
 *
 */
add_action( 'after_setup_theme', 'uwtheme_setup' );

if( ! function_exists( 'uwtheme_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override uwtheme_setup() in a child theme, add your own uwtheme_setup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, and Post Formats.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since 0.3.0
 */
  
function uwtheme_setup() {

	/* Make UW Theme available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on UW Theme, use a find and replace
	 * to change 'uwtheme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'uwtheme', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up our theme options page and related code.
	require( dirname( __FILE__ ) . '/inc/theme-faqs.php' );
	require( dirname( __FILE__ ) . '/inc/theme-options.php' );

	// Grab the Twenty Eleven's Ephemera widget.
	//require( dirname( __FILE__ ) . '/inc/widgets.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'uwtheme' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	// Add support for custom backgrounds
	add_custom_background();

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	// The next four constants set how UW Theme supports custom headers.

	// The default header text color
	define( 'HEADER_TEXTCOLOR', 'FFF' );

	// By leaving empty, we allow for random image rotation.
	define( 'HEADER_IMAGE', '' );

	// The height and width of your custom header.
	// Add a filter to uwtheme_header_image_width and uwtheme_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'uwtheme_header_image_width', 874 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'uwtheme_header_image_height', 85 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Add UW Theme's custom image sizes
	add_image_size( 'large-feature', HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true ); // Used for large feature (header) images
	add_image_size( 'small-feature', 500, 300 ); // Used for featured posts if a large-feature doesn't exist

	// Turn on random header image rotation by default.
	add_theme_support( 'custom-header', array( 'random-default' => true ) );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See uwtheme_admin_header_style(), below.
	add_custom_image_header( 'uwtheme_header_style', 'uwtheme_admin_header_style', 'uwtheme_admin_header_image' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
  $template_uri = get_bloginfo('template_url');
	register_default_headers( array(
    'huskypromise' => array(
      'url' => "$template_uri/images/banners/banner.jpg",
      'thumbnail_url' => "$template_uri/images/banners/banner-thumb.jpg",
      /* translators: header image description */
      'description' => __( 'Husky Promise', 'uw_theme' )
    )
	) );
}
endif; // uwtheme_setup 

if ( ! function_exists( 'uwtheme_no_banner_class' ) ) :
/**
 * Adds a class noBanner to #header if no banner image is selected
 *
 * @since UW Theme 0.4.2
 */
  function uwtheme_no_banner_class() {

    $header_image = get_header_image();
    
    echo empty( $header_image ) ? ' noBanner ' : '';

  }
endif;


if ( ! function_exists( 'uwtheme_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @since UW Theme 0.3.0
 */
function uwtheme_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
  
};

endif; // uwtheme_header_style

if ( ! function_exists( 'uwtheme_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in uwtheme_setup().
 *
 * @since UW Theme 0.3.0
 */
function uwtheme_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
    position: relative;
	}
	#headimg h1,
	#desc {
		font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
	}
	#headimg h1 {
		margin: 0;
    left: 21px;
    position: absolute;
    top: 10px;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#desc {
		line-height: 23px;
    font-size: 13px;
    left: 20px;
    padding: 0;
    position: absolute;
    top: 39px;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 1000px;
		height: auto;
		width: 100%;
	}
  #headimg img {
    left: 0;
    top: 0;
    width: 100%;
  }

	</style>
<?php
}
endif; // uwtheme_admin_header_style

if ( ! function_exists( 'uwtheme_admin_header_image' ) ) :

/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in uwtheme_setup().
 *
 * @since UW Theme 0.3.0
 */
function uwtheme_admin_header_image() { ?>
	<div id="headimg">
		<?php
		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // uwtheme_admin_header_image

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function uwtheme_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'uwtheme_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function uwtheme_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'uwtheme' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and uwtheme_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function uwtheme_auto_excerpt_more( $more ) {
	return ' &hellip;' . uwtheme_continue_reading_link();
}
add_filter( 'excerpt_more', 'uwtheme_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function uwtheme_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= uwtheme_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'uwtheme_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function uwtheme_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'uwtheme_page_menu_args' );

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since UW Theme 0.3.0
 */
function uwtheme_widgets_init() {

  //[todo]
	//register_widget( 'Twenty_Eleven_Ephemera_Widget' );

	register_sidebar( array(
		'name' => __( 'Widgets Sidebar', 'uwtheme' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Left Widgets', 'uwtheme' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'uwtheme_widgets_init' );

/**
 * Display navigation to next/previous pages when applicable
 *
 * @deprecated UW Theme 0.6.0
 */
function uwtheme_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>" class="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'uwtheme' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'uwtheme' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'uwtheme' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}

/**
 * Display a paginated navigation (replaces uwtheme_content_nav above)
 *
 * @since UW Theme 0.6.0
 */
function uwtheme_pagination($pages = '', $range = 2) {  
     global $paged;

     if($pages == '') {
       global $wp_query;
       $pages = $wp_query->max_num_pages;
       if(!$pages) {
           $pages = 1;
       }
     }   

     $showitems = ($range * 2)+1;  
     $prevclass = ($paged == 1) ? 'disabled' : '';
     $nextclass = ($paged == $pages) ? 'disabled' : '';

     if(empty($paged)) $paged = 1;

     if(1 != $pages) {
         echo "<div class='pagination'>";
         echo "<ul>";
         echo "<li class='prev $prevclass'><a href='".get_pagenum_link($paged-1)."'>&larr; Previous</a></li>";
         for ($i=1; $i <= $pages; $i++) {
           $class = ($i == $paged) ? 'class="active"' : '';
           if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
             echo "<li $class><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
           }
         }
         echo "<li class='next $nextclass'><a href='".get_pagenum_link($paged+1)."'>Next &rarr;</a></li>";
         echo "</ul>";
         echo "</div>";
     }
}


/**
 * Return the URL for the first link found in the post content.
 *
 * @since UW Theme 0.3.0
 * @return string|bool URL or false when no link is present.
 */
function uwtheme_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
function uwtheme_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}
*/

if ( ! function_exists( 'uwtheme_comment' ) ) :

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own uwtheme_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since UW Theme 0.3.0
 */

function uwtheme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'uwtheme' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'uwtheme' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'uwtheme' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'uwtheme' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'uwtheme' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'uwtheme' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'uwtheme' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for uwtheme_comment()

if ( ! function_exists( 'uwtheme_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own uwtheme_posted_on to override in a child theme
 *
 * @since UW Theme 0.3.0
 */
function uwtheme_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'uwtheme' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'uwtheme' ), get_the_author() ),
		esc_html( get_the_author() )
	);
}
endif;

add_filter( 'body_class', 'uwtheme_body_classes' );
if (!function_exists('uwtheme_body_classes')) :
/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since UW Theme 0.3.0
 */

function uwtheme_body_classes( $classes ) {
  if ( false == is_active_sidebar( 'sidebar-1' ) ) $classes[] = 'no-widgets';

	if ( ! is_multi_author() ) $classes[] = 'singular-author';
	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular-page';

	return $classes;
}
endif;


/****** OLD STUFF *******/

add_action('wp_enqueue_scripts', 'add_additional_css');

if (!function_exists('add_additional_css')) :
/**
 * Adds the css files for that are needed on each page 
 * Need to use wp_enqueue_scripts action for the following reason:
 *   http://wpdevel.wordpress.com/2011/12/12/use-wp_enqueue_scripts-not-wp_print_styles-to-enqueue-scripts-and-styles-for-the-frontend/
 */

function add_additional_css() {
    $theme_data = get_theme_data( get_bloginfo('stylesheet_url') );
    $cssfiles = array(
      //'NAME OF FILE' => 'FILENAME ISTELF',
      'bootstrap' => 'bootstrap.min.css',
      'twentyeleven' => 'twentyeleven.css',
      'header' => 'header.css',
      'footer' => 'footer.css',
      'secondary' => 'secondary.css',
      'reveal'    => 'reveal.css'
    );
    foreach ($cssfiles as $name => $file) {
      $url = get_bloginfo('template_url') . "/css/$file";
      wp_register_style($name, $url, array(), $theme_data['Version']);
      wp_enqueue_style($name);
    }
}
endif;

add_action('wp_enqueue_scripts', 'add_additional_js');

if (!function_exists('add_additional_js')) :
/**
 * Adds the javascript files for that are needed on each page 
 *
 * @since UW Theme 0.1.0
 */

function add_additional_js() {
    $theme_data = get_theme_data( get_bloginfo('stylesheet_url') );
    $jsfiles = array(
      //'NAME OF FILE' => 'FILENAME ISTELF',
      'jquery' => '',
      'weather' => 'https://raw.github.com/uweb/jquery.uw/master/src/min/jquery.uw.weather.min.js',
      'site' => 'site.js',
      //'nextprev' => 'nextprev.js',
      'modernizr' => 'modernizr.js'
    );
    foreach ($jsfiles as $name => $file) {
      if( strlen($file) > 0 ) {
        $url = (strpos($file, 'http') === false) ? get_bloginfo('template_url') . "/js/$file" : $file;
        wp_register_script($name, $url, array(), $theme_data['Version']);
      }
      wp_enqueue_script($name);
    }
}
endif;

if (!function_exists('get_widgets')) :
/**
 * UW widgets on sidebar 
 *   only echos out widgets if there are active widgets
 */

function get_widgets($side='right') {
  if ( is_active_sidebar( 'sidebar-1' ) && $side == 'right' ){
    get_sidebar();
  }
  if ( is_active_sidebar( 'sidebar-2' ) && $side == 'left' ){
    get_sidebar('left');
  }
}
endif;


/**
 * UW Custom form template
 * Functions for the the field, textarea and submit button
 */

add_filter('comment_form_default_fields', 'uw_form_fields');
add_filter('comment_form_field_comment',  'uw_form_field_comment');
add_filter('comment_form', 'uwtheme_comment_submit_button');

if (!function_exists('uw_form_fields')) :
/**
 * Outputs the comment form to be compatible with Bootstrap
 *
 * @since UW Theme 0.1.0
 */

function uw_form_fields($fields) {
  $commenter = wp_get_current_commenter();
  $fields =  array(
    'author'  => '<div class="clearfix required">' . '<label for="author">' . __( 'Name' ) . '</label> ' . '<div class="input">' . 
                   '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' .
                   '<span class="help-inline">Required</span>' . '</div>' . '</div>',
    'email'   => '<div class="clearfix required">' . '<label for="author">' . __( 'Email' ) . '</label> ' . '<div class="input">' .
                   '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />' .
                   '<span class="help-inline">Required</span>' . '</div>' . '</div>',
    'url'     => '<div class="clearfix">' . '<label for="url">' . __( 'Website' ) . '</label>' . '<div class="input">' .
                   '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>' . 
                   '</div>' . '</div>'
  );
  
  return $fields;
}
endif;

if (!function_exists('uw_form_field_comment')) :
/**
 * Wraps the comment button to work with Bootstrap CSS
 *
 * @since UW Theme 0.1.0
 */
function uw_form_field_comment($comment_field) {
  $comment_field = "
          <div class='clearfix'>
            <label for='comment'>Comment</label>
            <div class='input'>
              <textarea class='xxlarge' id='comment' name='comment' rows='3'></textarea>
            </div>
          </div>
  ";
    
  return $comment_field;
}
endif;

if (!function_exists('uwtheme_comment_submit_button')) :
/**
 * Wraps the comment button to work with Bootstrap CSS
 *
 * @since UW Theme 0.3.0
 */

function uwtheme_comment_submit_button($html){

	echo "
          <div class='actions'>
            <input class='btn' type='submit' value='Post Comment' id='submit' name='submit'>
          </div>
  ";
}
endif;

if (!function_exists('uwtheme_custom_the_password_form')) :
/**
 * Adds class form-stacked to the password form
 *
 * @since UW Theme 0.6.1
 */
add_filter('the_password_form', 'uwtheme_custom_the_password_form');
function uwtheme_custom_the_password_form($html) {
  return str_replace('<form', '<form class="form-stacked"', $html);
}
endif;

/**
 * Register Widgets
 */

include_once('widgets/communityphotos.php');
//include_once('widgets/uwmap.php');

if (!function_exists('get_uw_dropdowns')) {
/**
 * Grabs the dropdown navigation off of http://uw.edu (UW Homepage)
 * after a certain amount of time has passed and stores it in the database. 
 *
 * @return The navigation HTML
 */ 
    function get_uw_dropdowns() {

        // check if we need to update the dropdowns from the UW homepage
        if(uw_dropdowns_need_updating()) {
            update_uw_dropdowns();
        } 

        // return the navigation HTML
        $options = get_option('uw_theme_settings');
        return $options['navigation'];
    }
}

if (!function_exists('uw_dropdowns')) {
/**
 * Echos out the navigation HTML
 */ 
    function uw_dropdowns() {
        echo get_uw_dropdowns();
    }
}

if (!function_exists('update_uw_dropdowns')) {
    function update_uw_dropdowns() {
        // include the necessary functions to scrap the homepage
        include_once('inc/simple_html_dom.php');
        $navigation;
        // gather the options for the theme
        $options = get_option('uw_theme_settings');
        $html = file_get_dom('http://www.washington.edu/');
        $node = $html->find('#navg');
        // create the html from the dom element;
        foreach($node as $element) { 
            $navigation .= $element->innertext;
        }
        // also save the current time the new html was saved into the database
        $options['_updated'] = time();
        // get the new html and save it to the database
        $options['navigation'] = $navigation;
        update_option('uw_theme_settings', $options);
    }
}

if (!function_exists('uw_dropdowns_need_updating')) {
    function uw_dropdowns_need_updating() {
        $options = get_option('uw_theme_settings');
        return (time() - $options['_nav_updated'] > $options['_nav_update_frequency']);
    }
}

?>
