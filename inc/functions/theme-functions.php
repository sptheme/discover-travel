<?php
/**
 * Custom theme functions
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package 	Discover Travel
 * @since 		Discover Travel 1.0.0
 */


if ( ! function_exists( 'wpsp_tour_price' ) ) :
/**
 * Display sale price and regular price
 * @since 	Discover Travel 1.0.0
 */
function wpsp_tour_price( $price, $is_promote = false, $percentage ) {
        
        if ( empty( $price ) )  
                return;

        $regular_price = $price;
        printf( '<span class="label">%s</span>', esc_html__( 'Per person', 'discovertravel' ) );
        
        if ( $is_promote == 'on' ) {
        	$discount_price = ($regular_price / 100) * $percentage;
        	$sale_price = $regular_price - $discount_price;
        	printf('<del><span class="amount"><sup>$</sup>%1$s</span></del><ins><span class="on-sale">%2$s</span></ins><ins><span class="amount"><sup>$</sup>%3$s</span></ins>', 
        			$regular_price,
        			$percentage . esc_html__( '% Off', 'discovertravel' ),
        			$sale_price
        		);
        } else {
        	printf('<ins><span class="amount"><sup>$</sup>%1$s</span></ins>', 
        			$regular_price
        		);
        }
}
endif;

if ( ! function_exists( 'wpsp_tour_valid_date' ) ) :
/**
 * Display valid date tour
 * @since 	Discover Travel 1.0.0
 */
function wpsp_tour_valid_date( $valid_from, $valid_end ) {
        
        printf( '%1$s %2$s <strong>%3$s</strong> %4$s <strong>%5$s</strong>',
                sprintf( '<span class="label">%s</span>', esc_html__( 'Valid date:', 'discovertravel' ) ),
                sprintf( '%s', esc_html__( 'From', 'discovertravel' ) ),
                date("d F Y", strtotime($valid_from)),
                sprintf( '%s ', esc_html__( 'to', 'discovertravel' ) ),
                date("d F Y", strtotime($valid_end))
        );
}
endif;

if ( !function_exists( 'wpsp_list_tour_destination' ) ) :
/**
 * List all destination base on tour id
 * @since Discover Travel 1.0.0
 */
function wpsp_list_tour_destination(){
	global $post;

	$destinations = wp_get_post_terms( $post->ID, 'tour_destination' );
	$out = '<span class="label">' .  esc_html__( 'Destination: ', 'discovertravel' ) . '</span>';
	foreach ($destinations as $term) {
		$dests[] = '<strong>' . $term->name . '</strong>';
	}
	$out .= implode(' / ', $dests);
	echo $out;
}
endif;

if ( !function_exists( 'wpsp_list_tour_style' ) ) :
/**
 * List all style base on tour id
 * @since Discover Travel 1.0.0
 */
function wpsp_list_tour_style( $icon_size = '' ) {
	global $post;

	$class = 'tour-style-icon';
	if ( $icon_size ) 
		$class = 'tour-style-icon-' . $icon_size;

	//$args = array('orderby' => 'ID', 'order' => 'DESC', 'fields' => 'all');
	$tour_styles = wp_get_post_terms( $post->ID, 'tour_style' );
	$out = '<ul class="' . $class . '">';
	$out .= '<li><span class="label">' . esc_html__( 'Experiences: ', 'discovertravel' ) . '</span></li>';
	foreach ($tour_styles as $term) {
		//$out .= '<li><a href="' . get_term_link( $term ) . '" title="' . $term->name . '"><span class="sprite ' . get_option( 'tour_style_'.$term->term_id.'_icon', '' ) . '"></span>' . $term->name . '</a></li>';
		$out .= '<li><span class="sprite ' . get_option( 'tour_style_'.$term->term_id.'_icon', '' ) . '"></span></li>';
	}
	$out .= '</ul>';
	echo $out;
}
endif;

if ( !function_exists( 'wpsp_related_tour' ) ) :
/**
 * Display related tour by destination, style and day terms
 * @since Discover Travel 1.0.0
 */
function wpsp_related_tour( $post_num, $post_id, $cols ) {
	$destinations = wp_get_post_terms($post_id, 'tour_destination');
	$tour_styles = wp_get_post_terms($post_id, 'tour_style');
	$days = wp_get_post_terms($post_id, 'tour_day');
	$des_array = array();
	$style_array = array();
	$day_array = array();
	foreach ($destinations as $value) {
		$des_array[] = $value->term_id;
	}
	foreach ($tour_styles as $value) {
		$style_array[] = $value->term_id;
	}
	foreach ($days as $value) {
		$day_array[] = $value->term_id;
	}
	
	$args = array(
		'post_type'	=> 'cp_tour',
		'post__not_in' => array($post_id),
		'tax_query' => array(
				'relation' => 'OR',
		  			array(
						'taxonomy' => 'tour_destination',
						'field' => 'id',
		  				'terms' => array(join(', ', $des_array))
					),
					array(
						'taxonomy' => 'tour_style',
						'field' => 'id',
		  				'terms' => array(join(', ', $style_array))
					),
					array(
						'taxonomy' => 'tour_day',
						'field' => 'id',
		  				'terms' => array(join(', ', $day_array))
					),
				),
		'orderby' => 'rand',
		'posts_per_page' => $post_num
		);
	$custom_query = new WP_Query($args);

	if ( $custom_query -> have_posts() ) {
		echo '<div class="related-tours">';
		echo '<h3>' . esc_html__( 'Other tours you may be like...', 'discovertravel' ) . '</h3>';
		echo '<div class="row">';
		while ($custom_query -> have_posts() ) : $custom_query->the_post();
			echo '<div class="' . $cols . '">';
			get_template_part( 'partials/tour-grid' );
			echo '</div>';
		endwhile; wp_reset_postdata();
		echo '</div>';
		echo '</div> <!-- .related-tours -->';
	}
}
endif; 

if ( !function_exists( 'wpsp_tour_by_taxonomy' ) ) :
/**
 * Display related tour by taxonomy
 * @since Discover Travel 1.0.0
 */
function wpsp_tour_by_taxonomy( $taxonomy, $term, $cols, $post_num = 2 ) {

	$term_data = get_term( $term, $taxonomy ); 

	$args = array(
		'post_type'	=> 'cp_tour',
		'tax_query' => array(
		  			array(
						'taxonomy' => $taxonomy,
						'field' => 'id',
		  				'terms' => array( $term )
					),
				),
		'orderby' => 'rand',
		'posts_per_page' => $post_num
		);
	$custom_query = new WP_Query($args);

	if ( $custom_query -> have_posts() ) {
		echo '<div class="related-tours">';
		echo '<h3>' . esc_html__( 'Tour in ', 'discovertravel' ) . $term_data->name . esc_html__( ' you may be like...', 'discovertravel' ) . '</h3>';
		echo '<div class="row">';
		while ($custom_query -> have_posts() ) : $custom_query->the_post();
			echo '<div class="' . $cols . '">';
			get_template_part( 'partials/tour-grid' );
			echo '</div>';
		endwhile; wp_reset_postdata();
		echo '</div>';
		echo '</div> <!-- .related-tours -->';
	}
}
endif; 

if ( !function_exists( 'wpsp_tour_by_style' ) ) :
/**
 * Display related tour by style
 * @since Discover Travel 1.0.0
 */
function wpsp_tour_by_style( $term, $cols, $post_num = 2 ) {

	$term_data = get_term( $term, 'tour_style' ); 

	$args = array(
		'post_type'	=> 'cp_tour',
		'tax_query' => array(
		  			array(
						'taxonomy' => 'tour_style',
						'field' => 'id',
		  				'terms' => array( $term )
					),
				),
		'orderby' => 'rand',
		'posts_per_page' => $post_num
		);
	$custom_query = new WP_Query($args);

	if ( $custom_query -> have_posts() ) {
		echo '<div class="related-tours">';
		echo '<h3>' . esc_html__( 'Tour in ', 'discovertravel' ) . $term_data->name . esc_html__( ' you may be like...', 'discovertravel' ) . '</h3>';
		echo '<div class="row">';
		while ($custom_query -> have_posts() ) : $custom_query->the_post();
			echo '<div class="' . $cols . '">';
			get_template_part( 'partials/tour-grid' );
			echo '</div>';
		endwhile; wp_reset_postdata();
		echo '</div>';
		echo '</div> <!-- .related-tours -->';
	}
}
endif; 

if ( !function_exists( 'wpsp_tour_slideshow' ) ) :
/**
 * Get all the urls of images attached and present as slideshow
 * @since Discover Travel 1.0.0
 */
function wpsp_tour_slideshow() {
	global $post;

	$photos = explode( ',', get_post_meta( $post->ID, 'wpsp_tour_slideshow', true ) );

	if ( $photos[0] != '' ) {  ?>
		<script type="text/javascript">
            jQuery(document).ready(function($){
                $('#slides').superslides({
                	play: 5000,
				    animation_speed: 600,
				    animation_easing: 'swing',
				    animation: 'slide',
			        inherit_width_from: '.site-slider',
			        inherit_height_from: '.site-slider'
			      });
            });     
        </script>
	<?php
		echo '<div class="site-slider">';
		echo '<div id="slides">';
        echo '<ul class="slides-container">';
        foreach ( $photos as $photo ) : 
        echo '<li>' . wp_get_attachment_image( $photo, 'post-slide' ) . '</li>';
    	endforeach;
        echo '</ul>';
        echo '<nav class="slides-navigation">';
	    echo '<a href="#" class="next"><i class="fa fa-chevron-right"></i></a>';
	    echo '<a href="#" class="prev"><i class="fa fa-chevron-left"></i></a>';
	    echo '</nav>';
		echo ' </div> <!-- #slides -->';
        echo '</div> <!-- .site-slider -->';
	}
}
endif;
