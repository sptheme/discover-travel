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

	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">
				
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'partials/content', 'page' ); ?>
			
			<?php endwhile; // End of the loop. ?>
			
		</main><!-- #main -->

		<div class="tour-tax-term box-shadow">
            <h5><?php echo esc_html__( 'All Destination in Cambodia', 'discovertravel' ); ?></h5>
           
           	<?php $args = array(
           			'parent'		=> $post->ID,
      					'child_of'		=> $post->ID,
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
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
