<?php
/**
 * Template Name: Tour style
 *
 * This is the template that displays thumbnail of each tour style.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

get_header(); ?>
 

	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">
				
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'partials/content', 'page' ); ?>
			
			<?php endwhile; // End of the loop. ?>
			
		</main><!-- #main -->
    
    <div class="tour-tax-term box-shadow">
      <h4><?php echo esc_html__( 'All Tours Style', 'discovertravel' ); ?></h4>
      <?php $terms = apply_filters( 'taxonomy-images-get-terms', '', array( 'taxonomy' => 'tour_style' ) );
        if ( ! empty( $terms ) ) {
            print '<div class="row">';
            foreach ( (array) $terms as $term ) {
                print '<div class="col-sm-4"><div class="post-thumb-effect effect-sp-2">';
                print wp_get_attachment_image( $term->image_id, 'thumbnail' );
                print '<div class="caption-wrap"><div class="caption-inner"><h5>' . $term->name . '</h5><a href="' . esc_url( get_term_link( $term, $term->taxonomy ) ) . '">' . esc_html__( 'Detail', 'discovertravel' ) . '</a></div></div>';
                print '</div></div>';
            }
            print '</div>';
        } ?>
    </div> <!-- .tour-tax-term -->   
         
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
