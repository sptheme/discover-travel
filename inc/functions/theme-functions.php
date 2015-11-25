<?php
/**
 * Custom theme functions
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package 	Discover Travel
 * @since 		Discover Travel 1.0.0
 */

if( !function_exists('wpsp_languages_switcher')) :
/*
 * Language switcher with WPML plugin
 */	
function wpsp_languageswitcherer(){
	if(function_exists('icl_get_languages')) {
		$languages = icl_get_languages('skip_missing=1');
		if( 1 < count($languages) ){
			echo '<nav class="language col-sm-4"><ul>';
			//echo '<li>' . __('Language: ', 'sptheme') . '</li>';
			foreach($languages as $l){
				echo '<li class="'.$l['language_code'].'">';

				if(!$l['active']) echo '<a href="'.$l['url'].'" title="' . $l['native_name'] . '">';
				echo '<img src="' . $l['country_flag_url'] . '" alt="' . $l['native_name'] . '" />';
				if(!$l['active']) echo '</a>';

				echo '</li>';
			}
			echo '</ul></nav>';
		}
	} else {
		return null; // Activate WMPL plugin
	}
}
endif;

if( !function_exists('wpsp_lang_object_ids')) :
/*
 * Translating arrays of IDs with WPML plugin
 */	
function wpsp_lang_object_ids($ids_array, $type) {
	if(function_exists('icl_object_id')) {
		$res = array();
		foreach ($ids_array as $id) {
			$xlat = icl_object_id($id,$type,false);
			if(!is_null($xlat)) $res[] = $xlat;
		}
		return $res;
	} else {
		return $ids_array;
	}
}
endif;

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

if ( !function_exists( 'wpsp_get_tour_by_term' ) ) :
/**
 * List all tour by term
 * @since Discover Travel 1.0.0
 */
function wpsp_get_tour_by_term( $args, $cols ) {

	switch ( $cols ) {	
		case '2':
		$cols = 'col-sm-6';
		break;

		case '3':
		$cols = 'col-sm-4';
		break;

		case '4':
		$cols = 'col-sm-3';
		break;
	}

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	$defaults = array(
		'post_type'	=> 'cp_tour',
		'orderby' => 'rand',
		'posts_per_page' => -1,
		'paged' => $paged
		);
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	$custom_query = new WP_Query( $args );

	if ( $custom_query -> have_posts() ) :
		
		echo '<div class="row">';
		while ($custom_query -> have_posts() ) : $custom_query->the_post();
		echo '<div class="' . $cols . '">';
			get_template_part( 'partials/tour-grid' );
		echo '</div>';	
		endwhile; wp_reset_postdata();
		echo '</div>';
		// Pagination
        if(function_exists('wp_pagenavi'))
            wp_pagenavi();
        else 
            echo wpsp_paging_nav($custom_query->max_num_pages);
    else:
    	echo '<h5>' . esc_html__( 'Sorry, Our tours are not available now!', 'discovertravel' ) . '</h5>';
	endif;
}
endif;


if ( !function_exists( 'wpsp_send_tour_design' ) ) :
/**
 * Send all information of tour design form to tour oporators via ajax
 * @since Discover Travel 1.0.0
 */
function wpsp_send_tour_design() {
	
	parse_str ($_POST['tours'], $inquiry_info);
	
	wpsp_email_notify( $inquiry_info, true, true );//confirm to operator
	wpsp_email_notify( $inquiry_info, false, true ); //confirm to traveller
	
	die();
}
add_action('wp_ajax_nopriv_wpsp_send_tour_design', 'wpsp_send_tour_design'); //executes for users that are not logged in.
add_action('wp_ajax_wpsp_send_tour_design', 'wpsp_send_tour_design');
endif;


if ( !function_exists( 'wpsp_send_tour_inquiry' ) ) :
/**
 * Send all information of tour inquiry form to tour oporators via ajax
 * @since Discover Travel 1.0.0
 */
function wpsp_send_tour_inquiry() {
	
	parse_str ($_POST['tours'], $inquiry_info);
	
	wpsp_email_notify( $inquiry_info, true ); //confirm to operator
	wpsp_email_notify( $inquiry_info ); //confirm to traveller
	
	die();
}
add_action('wp_ajax_nopriv_wpsp_send_tour_inquiry', 'wpsp_send_tour_inquiry'); //executes for users that are not logged in.
add_action('wp_ajax_wpsp_send_tour_inquiry', 'wpsp_send_tour_inquiry');
endif;

if ( !function_exists( 'wpsp_email_notify' ) ) :
/**
 * Email notification to Traveller/guest and Operator 
 * @since Discover Travel 1.0.0
 */
function wpsp_email_notify( $inquiry_info, $is_operator = false, $is_tour_design = flase ) {
	
	if ( $is_operator ) {
		$subject = ( $is_tour_design ) ? esc_html__( 'Tour design:', 'discovertravel' ) . ' ' . $inquiry_info['fullname'] : esc_html__( 'Tour inquiry:', 'discovertravel' ) . ' ' . $inquiry_info['firstname'] . ' ' . $inquiry_info['lastname'];
	} else {
		$subject = get_bloginfo('name') . ' ' . esc_html__( 'Notification', 'discovertravel' );
	}
	
	$guest_email = strip_tags( $inquiry_info['email'] );
	$operator_email = ot_get_option('operator-email');
	$noreply_email = ot_get_option('noreply-email');
	$emailTo = ( $is_operator ) ? $operator_email : $guest_email;
	
	if ( $is_operator ) {
		$headers = "From: " . $guest_email . "\r\n";
		$headers .= "Reply-To: " . $guest_email . "\r\n";
	} else {
		$headers = "From: " . $noreply_email . "\r\n";
	}
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	if ( $is_tour_design ) {
		$custom_destination = '';
		foreach ( $inquiry_info['destinations'] as $destination ) :
			$custom_destination .=	$destination . ', ';
		endforeach;

		$custom_style = '';
		foreach ( $inquiry_info['tourstyles'] as $style ) :
			$custom_style .=	$style . ', ';
		endforeach;
	}
	
	$body = '<html><body style="background-color:#4caf50; padding-bottom:30px;">';
	
	$body .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#333333"><tbody>';
  	$body .= '<tr>';
    $body .= '<td align="center" valign="top">';
    
    $body .= '<table width="640" border="0" cellpadding="0" cellspacing="0" align="center"><tbody>';
    $body .= '<tr>';
    $body .= '<td width="170" valign="middle" style="padding-bottom:10px; padding-top:10px;">';
    $body .= '<img src="'. ot_get_option('custom-logo') . '">';
    $body .= '</td>';
    $body .= '<td width="470" valign="middle" style="padding-bottom:10px; padding-top:10px; text-align:right;">';
    $body .= '<font style="font-size:18px;line-height:18px" face="Arial, sans-serif" color="#ffffff">' . esc_html__( 'Hotline Support: ', 'discovertravel' ) . '<font color="#ffffff" style="text-decoration:none;color:#ffffff">' . ot_get_option('operator-hotline') . '</font></font>';
    $body .= '<br><font style="font-size:14px;line-height:14px" face="Arial, sans-serif" color="#cccccc"><a href="mailto:' . ot_get_option('operator-email') . '" style="text-decoration:none"><font color="#cccccc">' . ot_get_option('operator-email') . '</font></a></font>';
    $body .= '</td>';
    $body .= '</tr>';
    $body .= '</tbody></table>';
    
    $body .= '</td>';
    $body .= '</tr>';
    $body .= '</tbody></table>';

	$body .= '<div style="max-width:640px; margin: 30px auto 20px; background-color:#fff; padding:30px;">';
	$body .= '<table cellpadding="5" width="100%"><tbody>';
	$body .= '<tr>';
	$body .= '<td colspan="2">';
	if ( $is_operator ) {
		$body .= '<p>' . esc_html__( 'Dear Operators', 'discovertravel' ) . ',</p>';
		if ( $is_tour_design ) {
			$body .= '<p>' . esc_html__( 'Please review the tour customized from ', 'discovertravel' ) . ' <strong>' . $inquiry_info['fullname'] . esc_html__( ' listed bellow', 'discovertravel' ) . '</p>';	
		} else {
			$body .= '<p>' . esc_html__( 'Please review tour inquiry from ', 'discovertravel' ) . ' <strong>' . $inquiry_info['title'] . ' ' . $inquiry_info['firstname'] . '</strong>' . esc_html__( ' listed bellow', 'discovertravel' ) . '</p>';	
		}
			
	} else {
		if ( $is_tour_design ) {
			$body .= '<p>' . esc_html__( 'Dear', 'discovertravel' ) . ' ' . $inquiry_info['fullname'] . ',</p>';
		} else {
			$body .= '<p>' . esc_html__( 'Dear', 'discovertravel' ) . ' ' . $inquiry_info['title'] . ' ' . $inquiry_info['firstname'] . ',</p>';	
		}
		$body .= '<p>' . esc_html__( 'Thank you very much for your kind interest in booking Tours in Cambodia with', 'discovertravel' ) . ' ' . get_bloginfo('name') . '. ' . esc_html__( 'One of our travel consultants will proceed your request and get back to you with BEST OFFERS quickly.', 'discovertravel' ) . '</p>';
		$body .= '<p>' . esc_html__( 'Please kindly check all the information of your inquiry again as below:', 'discovertravel' ) . '</p>';
	}
	$body .= '</td>';
	$body .= '</tr>';
	$body .= '<tr>';
	$body .= '<td colspan="2"><div style="border-bottom:1px solid #ccc; padding-bottom:5px;"><strong>' . ( $is_tour_design ) ? esc_html__( 'Tour design summary:', 'discovertravel' ) : esc_html__( 'Tour inquiry summary:', 'discovertravel' ) . '</strong></div></td>';
	$body .= '</tr>';
	if ( !$is_tour_design ) {
		$body .= '<tr>';
		$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Tour name: ', 'discovertravel' ) . '</strong></td>';
		$body .= '<td width="70%">' . $inquiry_info['tourname'] . ' ' . $inquiry_info['tourday'] . ' ' . esc_html__( 'Days', 'discovertravel' ) . '/' . ($inquiry_info['tourday'] - 1) . ' ' . esc_html__( 'Nights', 'discovertravel' ) . '</td>';
		$body .= '</tr>';
	} else {
		$body .= '<tr>';
		$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Destinations: ', 'discovertravel' ) . '</strong></td>';
		$body .= '<td width="70%">' . $custom_destination . '' . $inquiry_info['otherdestination'] . '</td>';
		$body .= '</tr>';
		$body .= '<tr>';
		$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Tour styles: ', 'discovertravel' ) . '</strong></td>';
		$body .= '<td width="70%">' . $custom_style . '</td>';
		$body .= '</tr>';
	}
	$body .= '<tr>';
	$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Will travel as: ', 'discovertravel' ) . '</strong></td>';
	$body .= '<td width="70%" style="text-transform: capitalize;">' . $inquiry_info['tourtype'] . '</td>';
	$body .= '</tr>';
	$body .= '<tr>';
	$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Total guests: ', 'discovertravel' ) . '</strong></td>';
	$body .= '<td width="70%">';
	if ( $inquiry_info['tourtype'] == 'solo' ) {
		$body .= esc_html__( 'Adults:', 'discovertravel' ) . ' 1';
	}
	if ( $inquiry_info['tourtype'] == 'couple' ) {
		$body .= esc_html__( 'Adults:', 'discovertravel' ) . ' 2';
	}
	if ( $inquiry_info['tourtype'] == 'family' || $inquiry_info['tourtype'] == 'group' ) {
		$body .= esc_html__( 'Adults:', 'discovertravel' ) . ' ' . $inquiry_info['adult'] . ', ';
		$body .= esc_html__( 'Children:', 'discovertravel' ) . ' ' . $inquiry_info['children'] . ', '; 
		$body .= esc_html__( 'Babies:', 'discovertravel' ) . ' ' . $inquiry_info['kids'];
	} // end tour type as family or group
	$body .= '</td>';
	$body .= '</tr>';
	$body .= '<tr>';
	$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Hotel class: ', 'discovertravel' ) . '</strong></td>';
	$body .= '<td width="70%">' . $inquiry_info['tourclass'] . '</td>';
	$body .= '</tr>';
	$body .= '<tr>';
	if ( $inquiry_info['flexibledate'] ) {
		$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Flexible date: ', 'discovertravel' ) . '</strong></td>';
		$body .= '<td width="70%">' . $inquiry_info['manualdate'] . '</td>';
	} else {
		$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Arrive date: ', 'discovertravel' ) . '</strong></td>';
		$body .= '<td width="70%">' . date("d F Y", strtotime( $inquiry_info['departuredate'] )) . '</td>';
	}// end flexible date is checked
	$body .= '</tr>';
	if ( !empty( $inquiry_info['otherrequest'] ) )  {
	$body .= '<tr>';
	$body .= '<td valign="top" style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Special requests: ', 'discovertravel' ) . '</strong></td>';
	$body .= '<td width="70%">' . $inquiry_info['otherrequest'] . '</td>';
	$body .= '</tr>';
	} // end other request
	$body .= '<tr>';
	$body .= '<td colspan="2"><div style="padding-top: 10px; border-bottom:1px solid #ccc; padding-bottom:5px;"><strong>' . esc_html__( 'Contact info:', 'discovertravel' ) . '</strong></div></td>';
	$body .= '</tr>';
	$body .= '<tr>';
	$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Full Name: ', 'discovertravel' ) . '</strong></td>';
	if ( $is_tour_design ) {
		$body .= '<td width="70%"><strong>' . $inquiry_info['fullname'] . '</strong></td>';
	} else {
		$body .= '<td width="70%"><strong>' . $inquiry_info['title'] . ' ' . $inquiry_info['firstname'] . ' ' . $inquiry_info['lastname'] . '</strong></td>';
	}
	$body .= '</tr>';
	$body .= '<tr>';
	$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Email: ', 'discovertravel' ) . '</strong></td>';
	$body .= '<td width="70%">' . $inquiry_info['email'] . '</td>';
	$body .= '</tr>';
	$body .= '<tr>';
	$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Phone: ', 'discovertravel' ) . '</strong></td>';
	$body .= '<td width="70%">' . $inquiry_info['phone'] . '</td>';
	$body .= '</tr>';
	$body .= '<tr>';
	$body .= '<td style="padding-left:30px;width:30%;color:#666666;"><strong>' . esc_html__( 'Nationality: ', 'discovertravel' ) . '</strong></td>';
	$body .= '<td width="70%">' . $inquiry_info['country'] . '</td>';
	$body .= '</tr>';
	$body .= '</tbody></table>';

	if ( !$is_operator )
		$body .= '<br><p><strong>' . esc_html__( 'Tips: ', 'discovertravel' ) . '</strong>' . esc_html__( 'If you submit incorrect information, please contact our travel consultants to change your information by ', 'discovertravel' ) . '<a href="mailto:' . ot_get_option('operator-email') . '">' . ot_get_option('operator-email') . '</a></p>';
	
	$body .= '<p style="padding-top: 10px;">' . esc_html__( 'Thanks & Best regards,', 'discovertravel') . '</p>';	

	if ( !$is_operator ) {
		$body .= '<p style="border-top:1px solid #ccc; padding-top:30px; font-size:12px; color:#666666;"><strong style="font-size:13px; color:#4caf50;">' . get_bloginfo('name') . '</strong>';
		$body .= '<br>' . ot_get_option('operator-address');
		$body .= '<br><strong>' . esc_html__( 'T. ', 'discovertravel' ) . '</strong>' . ot_get_option('operator-phone');
		$body .= '<br><strong>' . esc_html__( 'E. ', 'discovertravel' ) . '</strong><a href="mailto:' . ot_get_option('operator-email') . '">' . ot_get_option('operator-email') . '</a>';
		$body .= '<br><strong>' . esc_html__( 'F. ', 'discovertravel' ) . '</strong>' . ot_get_option('operator-fax');
		$body .= '<br><strong>' . esc_html__( 'W: ', 'discovertravel' ) . '</strong>' . get_bloginfo('wpurl', 'display') . '</p>';
	}
	$body .= '</div>'; //wrapper
	$body .= '</body></html>';
	
	if ( mail( $emailTo, $subject, $body, $headers ) ){
		if ( !$is_operator ) {
			$out = '<h3>' . esc_html__( 'Thank you for sending us your inquiry!', 'discovertravel' ) . '</h3>';
			$out .= '<p>' . esc_html__( 'We will contact you within 01 working day. If you have any questions, please kindly contact us at: ', 'discovertravel' );
			$out .= '<br>Email: <a href="mailto:' . $operator_email . '">' . $operator_email . '</a>';
			$out .= '<br><span class="hotline">Hotline: ' . ot_get_option('operator-hotline') . '</span></p>';
			$out .= '<p class="note">Note: To ensure that you can receive a reply from us, Please kindly add the "' . str_replace( 'http://', '', get_home_url() ) . '" domain to your e-mail "safe list".<br>If you do not receive a response in your "inbox" within 12 hours, check your "bulk mail" or "junk mail" folders.</p>';
			echo $out;
		}
	} else {
		if ( !$is_operator )
			echo '<h5>' . esc_html__( 'Sorry, your inquiry cannot be send right now.', 'discovertravel' ) . '</h5><p>' . error_message . '</p>';
	}
}
endif;