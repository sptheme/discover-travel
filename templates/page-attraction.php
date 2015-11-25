<?php
/**
 * Template Name: Attraction
 *
 * This is the template that displays single attraction place.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

get_header(); ?>

	<?php $album_id = get_post_meta( $post->ID, 'wpsp_attraction_gallery', true );
		$photos = explode( ',', get_post_meta( $album_id, 'wpsp_gallery', true ) );
		$embed_map = get_post_meta( $post->ID, 'wpsp_embed_map', true ); ?>

	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'partials/content', 'page' ); ?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->

		<?php if ( !empty( $album_id ) ) : ?>
		<div class="attractive-photo box-shadow gallery">
			<h3><?php printf( '%1$s ' . esc_html__( 'Photos', 'discovertravel' ), get_the_title( $post->ID ) ); ?></h3>
			<?php  
				echo '<ul class="row">';
		        foreach ( $photos as $photo ) : 
			        $full_image = wp_get_attachment_image_src( $photo, 'large' );	
			    	$thumbnail = wp_get_attachment_image( $photo, 'thumbnail' );
			        echo '<li class="col-xs-6 col-md-4"><a href="' . $full_image[0] . '">' . $thumbnail . '</a></li>';
		    	endforeach;
		        echo '</ul>'; ?>
		</div> <!-- .attractive-photo -->
		<?php endif; ?>

		<?php if ( $embed_map ) : ?>
		<div class="attractive-map box-shadow">
			<h3><?php printf( '%1$s ' . esc_html__( 'Map', 'discovertravel' ), get_the_title( $post->ID ) ); ?></h3>
			<?php echo $embed_map; ?>
		</div> <!-- .attractive-map -->
		<?php endif; ?>

		<?php $parents = get_post_ancestors( $post->ID ); 
			$post_parent_title = ( count($parents) <= '1' ) ? get_the_title() : get_the_title( wp_get_post_parent_id( $post->ID ) );
			$args = array();
			// get page level 1 
			if ( count($parents) <= '1' ) {
				$args = array(
					'parent'		=> icl_object_id($post->ID,'page',true),
					'child_of'		=> icl_object_id($post->ID,'page',true),
					'hierarchical'	=> 0
		    	); 
	    	}
	    	// default is sibling pages
	    	$defaults = array(
				'child_of'	=> $parents[0],
				'exclude' => icl_object_id($post->ID,'page',true)
				);
			$args = wp_parse_args( $args, $defaults );
			extract( $args );

	    	$pages = get_pages( $args ); ?>

	    <?php if ( !empty( $pages ) ) : ?>
		<div class="attractive-place box-shadow">
            <h3><?php echo esc_html__( 'Other Attractions in ', 'discovertravel' ) . $post_parent_title; ?></h3>

            <!-- Show all subling pages -->
            <div class="row">
            <?php foreach ( $pages as $page ) : ?>
            	<div class="col-sm-4">
	            	<div class="post-thumb-effect effect-sp-1">
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
                    </div> <!-- .post-thumb-effect .effect-sp-1 -->
                </div> <!-- .col-lg-4 -->
            <?php endforeach; ?>    
            </div> <!-- .row -->

        </div> <!-- .attractive-place -->  
        <?php endif; ?>     

        <?php $term = get_post_meta( $post->ID, 'wpsp_related_tour', true );
        	wpsp_tour_by_taxonomy( 'tour_destination', $term, 'col-sm-6', 2); ?>

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
