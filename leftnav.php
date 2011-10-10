  <div id="leftNav">
    <div class="leftNavBackground">
        
        <?php
          global $post;
          
          $args = array(
            'depth'        => $post->post_parent ? 1 : 0,
            'show_date'    => '',
            'date_format'  => get_option('date_format'),
            'child_of'     => $post->ID,
            'exclude'      => '',
            'include'      => '',
            'title_li'     => get_the_title($post->post_parent),
            'echo'         => 0,
            'authors'      => '',
            'sort_column'  => 'menu_order, post_title',
            'link_before'  => '',
            'link_after'   => '',
            'walker'       => '' );
          $menu = wp_list_pages($args);
          if ( !strlen($menu)) {
            wp_nav_menu('depth=1');
          } else {
            echo $menu;
          }
        ?>

      <br class="clear" /><br class="clear" />
    </div>
  </div>
