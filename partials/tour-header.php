<?php
/**
 * Template part for displaying tour header info.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

?>

<?php $tour_price = get_post_meta( $post->ID, 'wpsp_tour_price', true );
	$is_promote = get_post_meta( $post->ID, 'wpsp_is_promote', true );
	$percentage = get_post_meta( $post->ID, 'wpsp_discount_amount', true );
	$day_amount = get_post_meta( $post->ID, 'wpsp_day_amount', true ); 
	$valid_from = get_post_meta( $post->ID, 'wpsp_valid_from', true );
	$valid_end = get_post_meta( $post->ID, 'wpsp_valid_end', true );
	$brochure = get_post_meta( $post->ID, 'wpsp_brochure', true );
	$embed_map = get_post_meta( $post->ID, 'wpsp_embed_map', true );  ?>

<div class="container">
    <div class="itenerary-head">
        <?php wpsp_tour_slideshow(); 
            //get_template_part( 'partials/tour-slideshow' ); ?>

    	<div class="itenerary-summary">
            <div class="tour-title">
                <div class="row">
                    <div class="col-sm-1">
                    	<span class="day-amount"><strong><?php echo $day_amount; ?></strong> <?php echo esc_html__( 'Days', 'discovertravel' ); ?></span>
                    </div>
                    <div class="col-lg-7">
                    	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    </div>
                    <div class="price col-lg-4">
                	<?php wpsp_tour_price( $tour_price, $is_promote, $percentage ); ?>
                    </div>
                </div>
            </div> <!-- .tour-title -->
            <div class="tour-meta">
                <div class="row">
                    <div class="col-md-8">
                        <div class="destination">
                        	<?php wpsp_list_tour_destination(); ?>
                        </div>
                        <?php wpsp_list_tour_style(); ?>
                    	<div class="tour-expire">
                    		<?php wpsp_tour_valid_date( $valid_from, $valid_end ); ?>
                    	</div>
                    </div>
                    <div class="inquiry col-md-4">
	                    <a class="button color-green tour-inquiry" href="#tour-inquiry-form"><?php echo esc_html__( 'Inquiry Now', 'discovertravel' ); ?></a>
                        <?php if ( !empty( $brochure ) ) : ?>
                        <a class="button color-gray" href="<?php echo $brochure; ?>"><?php echo esc_html__( 'Download Brochure', 'discovertravel' ); ?></a>
                        <?php endif; ?>
                    </div>   
                </div> <!-- .row -->     
            </div> <!-- .tour-meta -->                    
        </div> <!-- .itenerary-summary -->
        
        <?php if ( $embed_map ) : ?>
        <div class="tour-map"><?php echo $embed_map; ?></div>            
    	<?php endif; ?>
	</div> <!-- .itenerary-head -->
</div>	<!-- .container -->

