<?php
/**
 * Discover Travel functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package Discover Travel
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Get theme info
$shortname 		= get_template(); 
$themeData     	= wp_get_theme( $shortname ); //WP 3.4+ only

// Define branding and version constant
define( 'WPSP_THEME_NAME', 'DT' );
define ('WPSP_THEME_VERSION', $themeData->Version );

// Paths to the parent theme directory
define( 'WPSP_BASE_DIR', get_template_directory() );
define( 'WPSP_BASE_URL', get_template_directory_uri() );

// Images, Javascript and CSS Paths
define( 'WPSP_JS_DIR_URI', WPSP_BASE_URL .'/assets/js/' );
define( 'WPSP_CSS_DIR_URI', WPSP_BASE_URL .'/assets/css/' );

// Includes files path
define( 'WPSP_INCS', WPSP_BASE_DIR . '/inc/' );


if ( ! function_exists( 'discover_travel_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dt_setup() {

	// This theme styles the visual editor to resemble the theme style.
	$font_url = 'https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700';
	add_editor_style( array( WPSP_CSS_DIR_URI . 'base.css', str_replace( ',', '%2C', $font_url ) ) );

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Discover Travel, use a find and replace
	 * to change 'discover-travel' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'discover-travel', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	update_option( 'thumbnail_size_w', 420 );
	update_option( 'thumbnail_size_h', 282 );
	update_option( 'thumbnail_crop', 1 );

	add_image_size( 'mid-thumbnail', 720, 484, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'top' => esc_html__( 'Top Menu', 'discovertravel' ),
		'primary' => esc_html__( 'Primary Menu', 'discovertravel' ),
		'mobile' => esc_html__( 'Mobile Menu', 'discovertravel' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

}
endif; // dt_setup
add_action( 'after_setup_theme', 'dt_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function discover_travel_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'discover_travel_content_width', 720 );
}
add_action( 'after_setup_theme', 'discover_travel_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function dt_scripts() {
	wp_enqueue_style( 'discover-travel-style', get_stylesheet_uri() );
	wp_enqueue_style( 'g-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700|Courgette|Qwigley' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'dt-base', WPSP_CSS_DIR_URI . 'main.css' );
	wp_enqueue_style( 'dt-mobile-menu', WPSP_CSS_DIR_URI . 'mobile-menu.css' );
	wp_enqueue_style( 'superslides', WPSP_CSS_DIR_URI . 'superslides.css' );
	wp_enqueue_style( 'magnific-popup', WPSP_CSS_DIR_URI . 'magnific-popup.css' );

	wp_enqueue_script( 'modernizr', WPSP_JS_DIR_URI . 'vendor/modernizr-2.8.3-respond-1.4.2.min.js', array('jquery'), '20120206', false );
	wp_enqueue_script( 'jquery-easing', WPSP_JS_DIR_URI . 'vendor/jquery.easing.1.3.js', array(), '20120206', true );
	wp_enqueue_script( 'jquery-validate', WPSP_JS_DIR_URI . 'vendor/jquery.validate.min.js', array(), '20120206', true );
	wp_enqueue_script( 'dt-jquery-form', WPSP_JS_DIR_URI . 'vendor/jquery.form.js', array(), '20120206', true );
	wp_enqueue_script( 'jquery-animate-enhanced', WPSP_JS_DIR_URI . 'vendor/jquery.animate-enhanced.min.js', array(), '20120206', true );
	wp_enqueue_script( 'dt-main', WPSP_JS_DIR_URI . 'main.js', array(), '20120206', true );
	
	wp_enqueue_script( 'dt-mobile-menu', WPSP_JS_DIR_URI . 'mobile-menu.js', array(), '20120206', true );
	wp_enqueue_script( 'jquery-superslides', WPSP_JS_DIR_URI . 'vendor/jquery.superslides.min.js', array(), '20120206', true );
	wp_enqueue_script( 'magnific-popup', WPSP_JS_DIR_URI . 'vendor/jquery.magnific-popup.min.js', array(), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular( 'cp_tour' ) || is_front_page() || is_home() || is_page_template( 'templates/page-home.php' ) ) {
		wp_enqueue_style( 'jquery-ui-datepicker-style' , '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script( 'dt-tour-inquiry', WPSP_JS_DIR_URI . 'tour-inquiry.js', array(), '20120206', true );
		$config_array = array(
	        'ajaxURL' => admin_url( 'admin-ajax.php' )
	    );
		wp_localize_script( 'dt-tour-inquiry', 'dt_tour_inquiry_obj', $config_array );
	}

}
add_action( 'wp_enqueue_scripts', 'dt_scripts' );

/**
 * Add Option Tree for theme option
 */
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
load_template( get_template_directory() . '/inc/option-tree/ot-loader.php' );

if ( ! function_exists( 'option_tree_admin_bar_render' ) ) :
/**
 * Add theme option on admin menu bar
 */
function wpsp_option_tree_admin_bar_render() {

	if ( current_user_can('edit_theme_options') ) {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array(
		'parent' => false, // use 'false' for a root menu, or pass the ID of the parent menu
		'id' => 'option_tree_admin_bar', // link ID, defaults to a sanitized title value
		'title' => 'Theme Options', // link title
		'href' => admin_url( 'themes.php?page=ot-theme-options'), // name of file
		'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
	));
	}
}
add_action( 'wp_before_admin_bar_render', 'wpsp_option_tree_admin_bar_render' );
endif;

// Load core functions
load_template( WPSP_INCS . 'functions/core.php' );

// Load custom theme function
load_template( WPSP_INCS . 'functions/theme-functions.php' );

// Load hooks functions
load_template( WPSP_INCS . 'functions/hooks.php' );

// Load custom shortcode functions
load_template( WPSP_INCS . 'shortcodes/shortcodes.php' );

// Load custom widgets
load_template( WPSP_INCS . 'widgets/widgets.php' );

// Custom login logo
load_template( WPSP_INCS . 'addons/custom-login.php' );

// Custom Post Type
load_template( WPSP_INCS . 'custom-posts/custom-posts.php' );

// Load theme options
load_template( WPSP_INCS . 'functions/theme-options.php' );

// Load meta options
load_template( WPSP_INCS . 'functions/meta-boxes.php' );
