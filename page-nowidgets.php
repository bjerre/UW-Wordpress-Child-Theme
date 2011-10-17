<?php
/**
 * Template Name: No Widgets
 *
 * A regular page without widgets on the right
 *
 */
 
get_header(); ?>

		<div id="primary" class="no-widgets">
			<div id="content" role="main">

				<?php the_post(); ?>

				<?php get_template_part( 'content', '' ); ?>

				<?php comments_template( '', true ); ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>
