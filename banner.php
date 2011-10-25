<header id="branding" class="title" role="banner">
    <hgroup>
      <h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
      <h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
    </hgroup>


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

			<nav id="access" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Main menu', 'twentyeleven' ); ?></h3>
				<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
				<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to primary content', 'twentyeleven' ); ?></a></div>
				<div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to secondary content', 'twentyeleven' ); ?></a></div>
			</nav><!-- #access -->
</header><!-- #branding -->
    
