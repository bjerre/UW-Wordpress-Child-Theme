<?php
/**
 * Template Name: Left Widgets
 *
 * A regular page with widgets on the left under navigation
 * Requires: header-leftwidgets.php
 */
 
get_header(); ?>

<?php get_template_part('leftnav', 'withwidgets'); ?>

		<div id="primary" class="no-widgets">
			<div id="content" role="main">

				<?php the_post(); ?>

				<?php get_template_part( 'content', '' ); ?>

				<?php comments_template( '', true ); ?>

			</div><!-- #content -->
		</div><!-- #primary -->

    <br class="clear" /></div>   
    <div id="bottomRoundedLeft"></div> 
    </div>
   
  </div>
</div>

<?php get_footer(); ?>
