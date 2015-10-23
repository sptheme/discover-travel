<?php
/**
 * Klahan9 shortcodes functions
 *
 * @package Klahan9
 */

/**
 * Print script and style of shortcodes
 */
add_action( 'wp_enqueue_scripts', 'add_script_style_sc' );

function add_script_style_sc() {
	global $post;
	if( !is_admin() ){
		wp_enqueue_script( 'shortcode-js', SC_JS_URL . 'shortcodes.js', array(), SC_VER, true );
		wp_enqueue_style( 'shortcode', SC_CSS_URL . 'shortcodes.css', false, SC_VER );
	}
	
}

/**
 * Register and initialize short codes
 */
function wpsp_add_shortcodes() {
	add_shortcode( 'col', 'col' );
	add_shortcode( 'button', 'wpsp_button_shortcode' );
	add_shortcode( 'tour_inclusion', 'wpsp_tour_inclusion_shortcode' );
	add_shortcode( 'inclusion_section', 'wpsp_inclusion_section_shortcode' );
	add_shortcode( 'tour_itinerary', 'wpsp_tour_itinerary_shortcode' );
	add_shortcode( 'itinerary_section', 'wpsp_itinerary_section_shortcode' );
	//add_shortcode( 'hr', 'wpsp_hr_shortcode_shortcode' );
	//add_shortcode( 'email_encoder', 'wpsp_email_encoder_shortcode' );
	// add_shortcode( 'accordion', 'wpsp_accordion_shortcode' );
	// add_shortcode( 'accordion_section', 'wpsp_accordion_section_shortcode' );	
	// add_shortcode( 'toggle', 'wpsp_toggle_shortcode' );
	// add_shortcode( 'toggle_section', 'wpsp_toggle_section_shortcode' );	
	// add_shortcode( 'tabgroup', 'wpsp_tabgroup_shortcode' );
	// add_shortcode( 'tab', 'wpsp_tab_shortcode' );
	
	// add_shortcode( 'sc_team', 'wpsp_team_shortcode' );
	// add_shortcode( 'sc_photogallery', 'wpsp_photogallery_shortcode' );
	// add_shortcode( 'sc_post', 'wpsp_post_shortcode' );
	
	
}
add_action( 'init', 'wpsp_add_shortcodes' );

/**
 * Fix Shortcodes 
 */
if( !function_exists('wpsp_fix_shortcodes') ) {
	function wpsp_fix_shortcodes($content){
		$array = array (
			'<p>['		=> '[', 
			']</p>'		=> ']', 
			']<br />'	=> ']'
		);
		$content = strtr($content, $array);
		return $content;
	}
}
add_filter('the_content', 'wpsp_fix_shortcodes');

/**
 * Helper function for removing automatic p and br tags from nested short codes
 */
function return_clean( $content, $p_tag = false, $br_tag = false )
{
	$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );

	if ( $br_tag )
		$content = preg_replace( '#<br \/>#', '', $content );

	if ( $p_tag )
		$content = preg_replace( '#<p>|</p>#', '', $content );

	return do_shortcode( shortcode_unautop( trim( $content ) ) );
}

if ( ! function_exists( 'col' ) ) :
/**
 * Column
 */
function col( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => 'full'
	), $atts ) );
	$out = '<div class="' . $type . '">' . return_clean($content) . '</div>';
	if ( strpos( $type, 'last' ) )
		$out .= '<div class="clear"></div>';
	return $out;
}
endif;

if ( ! function_exists( 'wpsp_button_shortcode' ) ) :
/**
 * Button
 */
function wpsp_button_shortcode($atts, $content = null) {
	
	extract(shortcode_atts(array(
		'url' => 'null',
	), $atts));
	
	return '<a class="button" href="' . $url .'">' . $content . '</a>';
	
}
endif;

if ( ! function_exists( 'wpsp_hr_shortcode_shortcode' ) ) :
/**
 * Devide
 */
function wpsp_hr_shortcode_shortcode($atts, $content = null) {
	
	extract(shortcode_atts(array(
		'style' => 'dashed',
		'margin_top' => '40',
		'margin_bottom' => '40',
	), $atts));
	
	return '<hr class="' .$style . '" style="margin-top:' . $margin_top . 'px;margin-bottom:' . $margin_bottom . 'px;" />';
	
}
endif;

if ( ! function_exists( 'wpsp_email_encoder_shortcode' ) ) :
/**
 * Email encoder
 */
function wpsp_email_encoder_shortcode($atts, $content = null){
	extract(shortcode_atts(array(
		'email' 	=> 'name@domainname.com',
		'subject'	=> 'General Inquirie'
	), $atts));

	return '<a href="mailto:' . antispambot($email) . '?subject=' . $subject . '">' . antispambot($email) . '</a>';
}
endif;

if ( ! function_exists( 'wpsp_accordion_shortcode' ) ) :
/**
 * Accordion
 * Main accordion container
 */
function wpsp_accordion_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'style' => 'one',
		'size' => 'small',		
		'open_index' => 0
	), $atts));

	return '<div class="accordion ' . $size . ' ' . $style . ' clearfix" data-opened="' . $open_index . '">' . return_clean($content) . '</div>';
}
endif;

if ( ! function_exists( 'wpsp_accordion_section_shortcode' ) ) :
/**
 * Accordion section
 */
function wpsp_accordion_section_shortcode($atts, $content = null) {

	extract(shortcode_atts(array(
		'title' => 'Title Goes Here',		
	), $atts));

	return '<section><h4>' . $title . '</h4><div><p>' . return_clean($content) . '</p></div></section>';
	
}
endif;

if ( ! function_exists( 'wpsp_toggle_shortcode' ) ) :
/**
 * Toggle
 * Main toggle container
 */
function wpsp_toggle_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'style' => 'one',		
		'open_index' => 0
	), $atts));

	return '<div class="accordion small ' . $style . ' clearfix toggle" data-opened="' . $open_index . '">' . return_clean($content) . '</div>';
}
endif;

if ( ! function_exists( 'wpsp_toggle_section_shortcode' ) ) :
/**
 * toggle section
 */
function wpsp_toggle_section_shortcode($atts, $content = null) {

	extract(shortcode_atts(array(
		'title' => 'Title Goes Here',		
	), $atts));

	return '<section><h4>' . $title . '</h4><div><p>' . return_clean($content) . '</p></div></section>';	
}
endif;

if ( ! function_exists( 'wpsp_tabgroup_shortcode' ) ) :
/**
 * Tabs
 * Main Tabgroup
 */
function wpsp_tabgroup_shortcode($atts, $content = null) {

	$defaults = array();
	//extract( shortcode_atts( $defaults, $atts ) );
	extract(shortcode_atts(array(
		'style' => 'light'
	), $atts));
	
	STATIC $i = 0;
	$i++;

	// Extract the tab titles for use in the tab widget.
	preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
	
	$tab_titles = array();
	if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
	
	$output = '';
	
	if( count($tab_titles) ){
	    $output .= '<div id="sp-tabs-'. $i .'" class="tabs-container ' . $style . ' clearfix">';
		$output .= '<ul class="titles clearfix">';
		
		foreach( $tab_titles as $tab ){
			$output .= '<li><a href="#sp-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
		}
	    
	    $output .= '</ul><div class="tab-contents clearfix">';
	    $output .= do_shortcode( $content );
	    $output .= '</div></div>';
	} else {
		$output .= do_shortcode( $content );
	}

	return $output;

}
endif;



if ( ! function_exists( 'wpsp_tab_shortcode' ) ) :
/**
 * Individual Tabs
 */
function wpsp_tab_shortcode($atts, $content = null) {

	$defaults = array( 'title' => 'Tab' );
	extract( shortcode_atts( $defaults, $atts ) );
	
	return '<div id="sp-tab-'. sanitize_title( $title ) .'">'. do_shortcode( $content ) .'</div>';
	
}
endif;

if ( ! function_exists( 'wpsp_team_shortcode' ) ) :
/**
 * Team shortcode
 *
 * Options: Show all team / by Category
 *
 */
function wpsp_team_shortcode( $atts, $content = null ){

	ob_start();
	extract( shortcode_atts( array(
		'term_id' => null,
		'post_num' => null,
		'cols' => null
	), $atts ) );

	$args = array();
	if ( $term_id == '-1' ) {
		wpsp_get_posts_type( 'cp_team', $args, $cols );
	} else {
		$args = array (
				'tax_query' => array(
					array(
						'taxonomy' => 'team_category',
						'field'    => 'id',
						'terms'    => array($term_id)
					)
				),
				'posts_per_page' => $post_num
			);
		wpsp_get_posts_type( 'cp_team', $args, $cols );
	}

	return ob_get_clean();
}
endif;

if ( ! function_exists( 'wpsp_photogallery_shortcode' ) ) :
/**
 * Photogallery
 *
 * Display photo by individule or all albums
 *
 */
function wpsp_photogallery_shortcode( $atts, $content = null ){

	global $post;

	ob_start();

	extract( shortcode_atts( array(
		'term_id'  => null,
		'post_num'  => null,
		'cols' 		=> null,
	), $atts ) );

	wpsp_get_albums_by_term( $term_id, $post_num, $cols );

	return ob_get_clean();
}
endif;

if ( ! function_exists( 'wpsp_post_shortcode' ) ) :
/**
 * Post shortcode
 *
 * Options: Show post format by category
 *
 */
function wpsp_post_shortcode( $atts, $content = null ) {

	ob_start();
	extract( shortcode_atts( array(
		'term_id'  => null,
		'post_format' => null,
		'post_num'  => null,
		'cols' 		=> null,
	), $atts ) );

	$args = array (
			'tax_query' => array(
				'relation' => 'AND',
                array(
                    'taxonomy' => 'post_format',
                    'field'    => 'slug',
                    'terms'    => array( $post_format ),
                ),
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => array($term_id)
				)
			),
			'posts_per_page' => $post_num
		);
	wpsp_get_posts_type( 'post', $args, $cols );

	return ob_get_clean();
}
endif; 

if ( ! function_exists( 'wpsp_tour_inclusion_shortcode' ) ) :
/**
 * Tour inclusino shortcode
 *
 * Options: Display tour included and not included in  two columns with Bootstrap
 *
 */
function wpsp_tour_inclusion_shortcode( $atts, $content = null ) {

	return '<div class="tour-inclusion"><div class="row">' . return_clean($content). '</div></div>';
}
endif;

if ( ! function_exists( 'wpsp_inclusion_section_shortcode' ) ) :
/**
 * Inclusion section
 */
function wpsp_inclusion_section_shortcode($atts, $content = null) {

	extract(shortcode_atts(array(
		'type' => null,		
	), $atts));

	return '<div class="' . $type . ' col-md-6">' . return_clean($content) . '</div>';
	
}
endif;

if ( ! function_exists( 'wpsp_tour_itinerary_shortcode' ) ) :
/**
 * Tour itinerary shortcode
 *
 * Options: Display tour itinerary
 *
 */
function wpsp_tour_itinerary_shortcode( $atts, $content = null ) {

	return '<article class="itenerary-item">' . return_clean($content). '</article>';
}
endif;

if ( ! function_exists( 'wpsp_itinerary_section_shortcode' ) ) :
/**
 * Itinerary section
 */
function wpsp_itinerary_section_shortcode($atts, $content = null) {

	extract(shortcode_atts(array(
		'title' => 'Day of itinerary goes here',		
	), $atts));

	return '<h4 class="itenerary-title">' . $title . '</h4><div class="itenerary-desc">' . return_clean($content) . '</div>';
	
}
endif;