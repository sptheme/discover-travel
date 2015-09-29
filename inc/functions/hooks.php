<?php
/**
 * Setup theme hooks and action
 *
 * @package     Discover Travel
 * @since       Discover Travel 1.0.0
 */

/**
 * Main Content Hooks
 *
 * @since Discover Travel 1.0.0
 */
function wpsp_hook_content_top() {
    do_action( 'wpsp_hook_content_top' );
}
function wpsp_hook_content_bottom() {
    do_action( 'wpsp_hook_content_bottom' );
}

/**
 * Get tour header template part
 */
function wpsp_tour_header() {
	if ( is_singular( 'cp_tour' ) ) {
		get_template_part( 'partials/tour-header' );
	}
}
add_action( 'wpsp_hook_content_top', 'wpsp_tour_header' );

/**
 * Display full slideshow
 */
function wpsp_full_slideshow() {
	if ( is_page_template( 'templates/page-home.php' ) ) {
		get_template_part( 'partials/full-slideshow' );
	}
}
add_action( 'wpsp_hook_content_top', 'wpsp_full_slideshow' );