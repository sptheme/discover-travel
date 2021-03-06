<?php
/**
 * The template for displaying all single tour posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Discover Travel
 */

get_header(); ?>

	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'partials/content', 'single-tour' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->

		<?php wpsp_related_tour( 2, $post->ID, 'col-small-6 col-md-6 col-lg-6' ); ?>
		            
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
