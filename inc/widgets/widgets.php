<?php
/**
 * Include all custom widgets
 *
 * @package Discover Travel
 */


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function wpsp_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Default Sidebar', 'discovertravel' ),
		'id'            => 'default-sidebar',
		'description'   => __( 'Sidebar area appears in the right of the site.', 'discovertravel' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Tour Sidebar', 'discovertravel' ),
		'id'            => 'tour-sidebar',
		'description'   => __( 'Tour sidebar area appears in the right of the site.', 'discovertravel' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Header Sidebar', 'discovertravel' ),
		'id'            => 'header-sidebar-1',
		'description'   => __( 'Header Sidebar 1 area appears inside header page.', 'discovertravel' ),
		'before_widget' => '<aside id="%1$s" class="header-widget %2$s">',
		'after_widget'  => '</aside>',
	) );

	/*register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar', 'discovertravel' ),
		'id'            => 'footer-sidebar',
		'description'   => __( 'Footer widgets area appears in the footer of the site.', 'discovertravel' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );*/

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar 1', 'discovertravel' ),
		'id'            => 'footer-sidebar-1',
		'description'   => __( 'Footer widgets area appears in the footer of the site.', 'discovertravel' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget col-sm-6 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar 2', 'discovertravel' ),
		'id'            => 'footer-sidebar-2',
		'description'   => __( 'Footer widgets area appears in the footer of the site.', 'discovertravel' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Mobile Sidebar', 'discovertravel' ),
		'id'            => 'mobile-sidebar',
		'description'   => __( 'Mobile Sidebar area appears inside mobile navigation.', 'discovertravel' ),
		'before_widget' => '<aside id="%1$s" class="mobile-widget %2$s">',
		'after_widget'  => '</aside>',
	) );
}
add_action( 'widgets_init', 'wpsp_widgets_init' );

/**
 * Add shortcode support to text widget
 */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Register custom sidebars - work with options tree
 * 
 */
if ( ! function_exists( 'wpsp_custom_sidebars' ) ) :
function wpsp_custom_sidebars() {
	if ( !ot_get_option('sidebar-areas') =='' ) {
		
		$sidebars = ot_get_option('sidebar-areas', array());
		
		if ( !empty( $sidebars ) ) {
			foreach( $sidebars as $sidebar ) {
				if ( isset($sidebar['title']) && !empty($sidebar['title']) && isset($sidebar['id']) && !empty($sidebar['id']) && ($sidebar['id'] !='sidebar-') ) {
					register_sidebar(array('name' => ''.$sidebar['title'].'','id' => ''.strtolower($sidebar['id']).'','before_widget' => '<aside id="%1$s" class="widget %2$s">','after_widget' => '</aside>','before_title' => '<h2 class="widget-title">','after_title' => '</h2>'));
				}
			}
		}
	}
}
add_action( 'widgets_init', 'wpsp_custom_sidebars' );	
endif;

/**
 * Sidebar choice - work with option tree
 * 
 */
if ( ! function_exists( 'wpsp_sidebar_primary' ) ) :	
function wpsp_sidebar_primary() {
	// Default sidebar
	$sidebar = 'default-sidebar';

	// Set sidebar based on page
	if ( is_home() && ot_get_option('s1-home') ) $sidebar = ot_get_option('s1-home');
	if ( is_single() && ot_get_option('s1-single') ) $sidebar = ot_get_option('s1-single');
	if ( is_singular('cp_tour') && ot_get_option('s1-tour') ) $sidebar = ot_get_option('s1-tour');
	//if ( is_singular('team') && ot_get_option('s1-team') ) $sidebar = ot_get_option('s1-team');
	//if ( is_singular('gallery') && ot_get_option('s1-gallery') ) $sidebar = ot_get_option('s1-gallery');
	if ( is_archive() && ot_get_option('s1-archive') ) $sidebar = ot_get_option('s1-archive');
	if ( is_category() && ot_get_option('s1-archive-category') ) $sidebar = ot_get_option('s1-archive-category');
	if ( is_search() && ot_get_option('s1-search') ) $sidebar = ot_get_option('s1-search');
	if ( is_404() && ot_get_option('s1-404') ) $sidebar = ot_get_option('s1-404');
	if ( is_page() && ot_get_option('s1-page') ) $sidebar = ot_get_option('s1-page');
	if ( is_page_template( 'templates/page-destination.php' ) ) $sidebar = ot_get_option('s1-page-destination');
	if ( is_page_template( 'templates/page-attraction.php' ) ) $sidebar = ot_get_option('s1-page-attraction');

	// Check for page/post specific sidebar
	if ( is_page() || is_single() ) {
		// Reset post data
		wp_reset_postdata();
		global $post;
		// Get meta
		$meta = get_post_meta($post->ID,'wpsp_sidebar_primary',true);
		if ( $meta ) { $sidebar = $meta; }
	}

	// Return sidebar
	return $sidebar;
}
endif;

/**
 * Layout choice - work with option tree
 * 
 */
if ( ! function_exists( 'wpsp_layout_class' ) ) :
function wpsp_layout_class() {
	// Default layout
	$layout = 'col-2cr';
	$default = 'col-2cr';

	// Check for page/post specific layout
	if ( is_page() || is_single() ) {
		// Reset post data
		wp_reset_postdata();
		global $post;
		// Get meta
		$meta = get_post_meta($post->ID,'wpsp_layout',true);
		// Get if set and not set to inherit
		if ( isset($meta) && !empty($meta) && $meta != 'inherit' ) { $layout = $meta; }
		// Else check for page-global / single-global
		elseif ( is_single() && ( ot_get_option('layout-single') !='inherit' ) ) $layout = ot_get_option('layout-single',''.$default.'');
		elseif ( is_page() && ( ot_get_option('layout-page') !='inherit' ) ) $layout = ot_get_option('layout-page',''.$default.'');
		// Else check for custom post
		elseif ( is_singular('cp_tour') && ( ot_get_option('layout-tour') !='inherit' ) ) $layout = ot_get_option('layout-tour',''.$default.'');
		// Else check for custom template
		elseif ( is_page_template( 'templates/page-destination.php' ) && ( ot_get_option('layout-destination') !='inherit' ) ) $layout = ot_get_option('layout-destination',''.$default.'');
			elseif ( is_page_template( 'templates/page-attraction.php' ) && ( ot_get_option('layout-attraction') !='inherit' ) ) $layout = ot_get_option('layout-attraction',''.$default.'');
		/*elseif ( is_singular('gallery') && ( ot_get_option('layout-gallery') !='inherit' ) ) $layout = ot_get_option('layout-gallery',''.$default.'');*/
		// Else get global option
		else $layout = ot_get_option('layout-global',''.$default.'');
	}
	
	// Set layout based on page
	elseif ( is_home() && ( ot_get_option('layout-home') !='inherit' ) ) $layout = ot_get_option('layout-home',''.$default.'');
	elseif ( is_category() && ( ot_get_option('layout-archive-category') !='inherit' ) ) $layout = ot_get_option('layout-archive-category',''.$default.'');
	elseif ( is_archive() && ( ot_get_option('layout-archive') !='inherit' ) ) $layout = ot_get_option('layout-archive',''.$default.'');
	elseif ( is_search() && ( ot_get_option('layout-search') !='inherit' ) ) $layout = ot_get_option('layout-search',''.$default.'');
	elseif ( is_404() && ( ot_get_option('layout-404') !='inherit' ) ) $layout = ot_get_option('layout-404',''.$default.'');
	
	// Global option
	else $layout = ot_get_option('layout-global',''.$default.'');
	
	// Return layout class
	return $layout;
}
endif;

/**
 * Add layout option in body class
 * 
 */
if ( ! function_exists( 'wpsp_layout_option_body_class' ) ) :
function wpsp_layout_option_body_class( $classes ) {
	$classes[] = wpsp_layout_class();
	return $classes;
}
add_filter( 'body_class', 'wpsp_layout_option_body_class' );	
endif;

/**
 * Include all custom widgets
 *
 * @since   1.0.0
 */
function wpsp_custom_widgets() {

    // Define array of custom widgets for the theme
    $widgets = array(
        'custom-taxonomy-menu',
        'quick-contact',
        'tour-summary'
    );

    // Loop through widgets and load their files
    foreach ( $widgets as $widget ) {
        $widget_file = WPSP_INCS .'widgets/'. $widget .'-widget.php';
        if ( file_exists( $widget_file ) ) {
            load_template( $widget_file );
        }
    }
}
add_action( 'after_setup_theme', 'wpsp_custom_widgets', 5 );