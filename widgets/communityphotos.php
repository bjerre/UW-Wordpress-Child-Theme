<?php

include_once(ABSPATH . WPINC . '/feed.php');

class CommunityPhotos extends WP_Widget {
	function CommunityPhotos() {
		// widget actual processes
		parent::WP_Widget( $id = 'community_photos', $name = get_class($this), $options = array( 'description' => 'UW Community Photos' ) );
    if ( is_active_widget(false, false, $this->id_base) ) {
      add_action( 'wp_head', array(&$this, 'load_css') );
    }

	}
	function form($instance) {
		// outputs the options form on admin
	}
	function update($new_instance, $old_instance) {
		// processes widget options to be saved
	}
	function widget($args, $instance) {
    extract( $args );
		// outputs the content of the widget
    $URL = 'http://depts.washington.edu/newscomm/photos/feed';
    $rss = fetch_feed($URL);
    if (!is_wp_error( $rss ) ) { // Checks that the object is created correctly 
      // Figure out how many total items there are, but limit it to 5. 
      $url = $rss->get_permalink();
      $maxitems = $rss->get_item_quantity(20); 

      // Build an array of all the items, starting with element 0 (first element).
      $rss_items = $rss->get_items(0, $maxitems); 
      
      $content = "<div class='communityphotos'><h3 class='widget-title'>Community Photos</h3>";
      foreach ($rss_items as $item) {
        $title = $item->get_title();
        $link = $item->get_link();
        $src = $item->get_enclosure()->get_link();
        $content .= "
          <a href='$link' title='$title'>
            <span>
              <img src='$src' width='110' height='100' alt='$title'/>
            </span>
            <div style='width:110px'>
              <img src='$src' width='110' height='110' alt='$title'>
              <p>View Full Size</p>
            </div>
        ";
      }
      $content .= "</div>";
      echo $before_widget . $content . $after_widget;
    }
	}
  function load_css() {
      wp_register_style( 'communityphotos', get_bloginfo('template_url') . '/widgets/communityphotos.css' );
      wp_enqueue_style( 'communityphotos' );
  }
}
register_widget( 'CommunityPhotos' );

?>
