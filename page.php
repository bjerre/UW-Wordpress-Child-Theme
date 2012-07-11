<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage UW Theme
 * @since UW Theme 0.2.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php the_post(); ?>

				<?php get_template_part( 'content', '' ); ?>

				<?php /*comments_template( '', true );*/ ?>
			
			</div><!-- #content -->
     			<?php get_widgets(); ?>
			<?php get_synd_footer(); ?>
		</div><!-- #primary -->

<?php get_footer(); ?>
