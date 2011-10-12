<div class="title">
    <h2><?php bloginfo('name'); ?></h2>
</div>

  <?php
    // Check to see if the header image has been removed
    $header_image = get_header_image();
    if ( ! empty( $header_image ) ) :
  ?>

  <a class="banner" style="display:block;" href="<?php bloginfo('url'); ?>">

      <?php
        // The header image
        // Check if this is a post or page, if it has a thumbnail, and if it's a big one
        if ( is_singular() &&
            has_post_thumbnail( $post->ID ) &&
            ( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array( HEADER_IMAGE_WIDTH, HEADER_IMAGE_WIDTH ) ) ) &&
            $image[1] >= HEADER_IMAGE_WIDTH ) :
          // Houston, we have a new header image!
          echo get_the_post_thumbnail( $post->ID, 'post-thumbnail', array('class' => '') );
        else : ?>
        <img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="Banner graphic" />
      <?php endif; ?>

  </a>
<?php endif; ?>
