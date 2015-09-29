<?php
/**
 * The template for displaying post by term.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

get_header(); ?>

<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>

	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">
		<?php if ( have_posts() ) : ?>	

		<header class="page-header">
			<h1 class="page-title">
			<?php if ( $term->taxonomy == 'tour_style' ) : ?>
				<?php printf( '%1$s ' . esc_html__( 'Tours in Cambodia', 'discovertravel' ), $term->name ); ?>
			<?php else : ?>	
				<?php printf( esc_html__( 'Tours in ', 'discovertravel' ) . '%1$s', $term->name ); ?>
			<?php endif; ?>
			</h1>

			<?php if ( $term->description ) : ?>
			<div class="taxonomy-description"><p><?php echo $term->description; ?></p></div>
			<?php endif; ?>
		</header><!-- .page-header -->	
		
		<?php if ( ot_get_option('tax-archive-view') == 'grid' ) echo '<div class="row">'; ?>
		<?php while ( have_posts() ) : the_post(); 

			if ( ot_get_option('tax-archive-view') == 'list' ) :
					get_template_part( 'partials/tour-list' ); 
			else : ?>
				<div class="col-md-6">
				<?php get_template_part( 'partials/tour-grid' ); ?>
				</div> <!-- .col-md-6 -->
			<?php endif; ?>
		
		<?php endwhile; ?>
		<?php if ( ot_get_option('tax-archive-view') == 'grid' ) echo '</div> <!-- .row -->'; ?>
		
		<?php else : ?>

			<?php get_template_part( 'partials/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>