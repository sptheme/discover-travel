<?php
/**
 * Template Name: Destination
 *
 * This is the template that displays thumbnail of each destination.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

get_header(); ?>

   <?php $embed_map = get_post_meta( $post->ID, 'wpsp_embed_map', true ); ?>

	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">
				
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'partials/content', 'page' ); ?>
			
			<?php endwhile; // End of the loop. ?>
			
		</main><!-- #main -->

      <?php if ( $embed_map ) : ?>
      <div class="attractive-map box-shadow">
         <h3><?php printf( '%1$s ' . esc_html__( 'Map', 'discovertravel' ), get_the_title( $post->ID ) ); ?></h3>
         <?php echo $embed_map; ?>
      </div> <!-- .attractive-map -->
      <?php endif; ?>

		<div class="tour-tax-term box-shadow">
      <?php $country_name = esc_html__( 'Cambodia', 'discovertravel' );
         $parents = get_post_ancestors( $post->ID ); 
         $attraction_title = ( count($parents) < '1' ) ? $country_name : get_the_title(); ?>
         <h5><?php echo esc_html__( 'All Destination in ', 'discovertravel' ) . $attraction_title; ?></h5>
        
        	<?php $args = array(
        				'child_of'		=> $post->ID,
                  'parent'     => $post->ID,
                  'hierarchical'	=> 0
			);

        		$child_pages = get_pages( $args ) ?>
        	
        	<?php if ( !empty( $child_pages ) ) : ?>

        	<div class="row">	
        	<?php foreach ( $child_pages as $page ) : ?>
        		<div class="col-sm-4">
                 <div class="post-thumb-effect effect-sp-2">
                     <?php	
						if ( has_post_thumbnail( $page->ID ) ) {
						    echo get_the_post_thumbnail( $page->ID, 'thumbnail' );
						} else { 
							echo '<img src="' . esc_url( ot_get_option( 'post-placeholder' ) ) . '">';
						} 
					?>
                     <div class="caption-wrap">
                         <div class="caption-inner">
                             <h5><?php echo $page->post_title; ?></h5>
                             <a href="<?php echo esc_url( get_permalink( $page->ID ) ); ?>"><?php echo esc_html__( 'Detail', 'discovertravel' ); ?></a>
                         </div>
                     </div>
                 </div> <!-- .post-thumb-effect .effect-sp-2 -->
             </div> <!-- .col-sm-4 -->
        	<?php endforeach; ?>
        	</div> <!-- .row -->
        	<?php endif; ?>
      </div> <!-- .tour-tax-term -->

      <?php $term = get_post_meta( $post->ID, 'wpsp_related_tour', true );
         wpsp_tour_by_taxonomy( 'tour_destination', $term, 'col-sm-6', 2); ?>
         
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
