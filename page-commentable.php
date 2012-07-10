<?php
/**
 * Template Name: Commentable
 *
 * A regular page without widgets on the right
 *
 */



get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php the_post(); ?>

				<?php get_template_part( 'content', '' ); ?>

				<?php comments_template( '', true ); ?>

			</div><!-- #content -->
      <?php get_widgets(); ?>
		</div><!-- #primary -->

<?php get_footer(); ?>
