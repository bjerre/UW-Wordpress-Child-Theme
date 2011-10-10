  <div id="leftNav">
    <div class="leftNavBackground">
        
        <?php
          global $post;
          
          $id = (!$post->post_parent) ? $post->ID : $post->post_parent;
          
          $args = array(
            'depth'        => 0,
            'date_format'  => get_option('date_format'),
            'child_of'     => $id,
            'title_li'     => get_the_title($post->post_parent),
            'echo'         => 0,
            'sort_column'  => 'menu_order, post_title');

          $menu = wp_list_pages($args);

          echo ( !strlen($menu)) ? wp_nav_menu('depth=1') : $menu ;
        ?>

      <br class="clear" /><br class="clear" />
    </div>
  </div>
