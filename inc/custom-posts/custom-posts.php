<?php
/**
 * Custom post type.
 *
 *
 * @package Klahan9
 */

//Custom post WordPress admin menu position - 30, 33, 39, 42, 45, 48
if ( ! isset( $cp_menu_position ) )
	$cp_menu_position = array(
			'menu_tour'   => 30,
			'menu_slider'   => 33,
			'menu_gallery'   => 39,
			//'menu_team'      => 42
		);

//All custom posts
load_template( WPSP_INCS . 'custom-posts/cp-tour.php' );
load_template( WPSP_INCS . 'custom-posts/cp-slider.php' );
load_template( WPSP_INCS . 'custom-posts/cp-gallery.php' );
//load_template( WPSP_INCS . 'custom-posts/cp-team.php' );


//Taxonomies
load_template( WPSP_INCS . 'custom-posts/taxonomy-destination.php' );
load_template( WPSP_INCS . 'custom-posts/taxonomy-style.php' );
load_template( WPSP_INCS . 'custom-posts/taxonomy-day.php' );
load_template( WPSP_INCS . 'custom-posts/taxonomy-slider.php' );
load_template( WPSP_INCS . 'custom-posts/taxonomy-gallery.php' );
load_template( WPSP_INCS . 'custom-posts/taxonomy-multi-country.php' );
//load_template( WPSP_INCS . 'custom-posts/taxonomy-team.php' );

	
/*==========================================================================*/

//Change title text when creating new post
if ( is_admin() )
	add_filter( 'enter_title_here', 'sp_change_new_post_title' );	
	
/*
* Changes "Enter title here" text when creating new post
*/
if ( ! function_exists( 'sp_change_new_post_title' ) ) :
function sp_change_new_post_title( $title ){
	$screen = get_current_screen();

	if ( 'gallery' == $screen->post_type )
		$title = __( "Album name", 'wpsp _admin' );

	return $title;
}
endif; // /sp_change_new_post_title