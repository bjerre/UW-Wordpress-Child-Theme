<?php

define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyeleven_header_image_width', 874 ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyeleven_header_image_height', 85 ) );

function uw_theme_setup() {

$template_uri = get_stylesheet_directory_uri();
register_default_headers( array(
  'huskypromise' => array(
    'url' => "$template_uri/images/banners/banner.jpg",
    'thumbnail_url' => "$template_uri/images/banners/banner-thumb.jpg",
    /* translators: header image description */
    'description' => __( 'Husky Promise', 'uw_theme' )
  )
));

unregister_default_headers( array('wheel','shore','trolley','pine-cone','chessboard','lanterns','willow','hanoi'));

}
add_action( 'after_setup_theme', 'uw_theme_setup', 11 );



/**
 * Adds the css files for that are needed on each page 
 *
 */
add_action('wp_print_styles', 'add_additional_css');
function add_additional_css() {
    $cssfiles = array(
      //'NAME OF FILE' => 'FILENAME ISTELF',
      'bootstrap' => 'bootstrap.min.css',
      'twentyeleven' => 'twentyeleven.css',
      'header' => 'header.css',
      'footer' => 'footer.css',
      'secondary' => 'secondary.css'
    );
    foreach ($cssfiles as $name => $file) {
      $url = get_stylesheet_directory_uri() . "/css/$file";
      wp_register_style($name, $url);
      wp_enqueue_style($name);
    }
}

/**
 * Adds the javascript files for that are needed on each page 
 *
 */
add_action('wp_enqueue_scripts', 'add_additional_js');
function add_additional_js() {
    $jsfiles = array(
      //'NAME OF FILE' => 'FILENAME ISTELF',
      'jquery' => '',
      'weather' => 'https://raw.github.com/uweb/jquery.uw/master/src/min/jquery.uw.weather.min.js',
      'site' => 'site.js'
    );
    foreach ($jsfiles as $name => $file) {
      if( strlen($file) > 0 ) {
        $url = (strpos($file, 'http') === false) ? get_stylesheet_directory_uri() . "/js/$file" : $file;
        wp_register_script($name, $url);
      }
      wp_enqueue_script($name);
    }
}

/**
 * UW Custom form template
 */

add_filter('comment_form_default_fields', 'uw_form_fields');
add_filter('comment_form_field_comment',  'uw_form_field_comment');
//add_action('comment_form_after_fields', 'uw_remove_comment_help');
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

function uw_form_field_comment($comment_field) {
  $comment_field = "
          <div class='clearfix'>
            <label for='comment'>Comment</label>
            <div class='input'>
              <textarea class='xxlarge' id='comment' name='comment' rows='3'></textarea>
              <span class='help-block'>
              You may use these HTML tags and attributes: <code>a abbr acrynym b blockquote cite code del em i  q strike strong</code>
              </span>
            </div>
          </div>
  ";
    
  return $comment_field;
}

/**
 * Grabs the dropdown navigation off of http://uw.edu (UW Homepage)
 * after a certain amount of time has passed and stores it in the database. 
 *
 * @return The navigation HTML
 */ 
if (!function_exists('get_uw_dropdowns')) {
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

/**
 * Echos out the navigation HTML
 */ 
if (!function_exists('uw_dropdowns')) {
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
