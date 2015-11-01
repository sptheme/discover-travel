<?php

/**
 * Initialize the custom Meta Boxes. 
 */
add_action( 'admin_init', 'custom_meta_boxes' );

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types in demo-theme-options.php.
 *
 * @return    void
 * @since     2.0
 */
function custom_meta_boxes() {

	$prefix = 'wpsp_';
  
	/*  Custom meta boxes
	/* ------------------------------------ */
	$page_layout_options = array(
		'id'          => 'page-options',
		'title'       => 'Page Options',
		'desc'        => '',
		'pages'       => array( 'page', 'post', 'cp_tour' ),
		'context'     => 'normal',
		'priority'    => 'default',
		'fields'      => array(
			array(
				'label'		=> 'Primary Sidebar',
				'id'		=> $prefix . 'sidebar_primary',
				'type'		=> 'sidebar-select',
				'desc'		=> 'Overrides default'
			),
			array(
				'label'		=> 'Layout',
				'id'		=> $prefix . 'layout',
				'type'		=> 'radio-image',
				'desc'		=> 'Overrides the default layout option',
				'std'		=> 'inherit',
				'choices'	=> array(
					array(
						'value'		=> 'inherit',
						'label'		=> 'Inherit Layout',
						'src'		=> get_template_directory_uri() . '/assets/images/admin/layout-off.png'
					),
					array(
						'value'		=> 'col-1c',
						'label'		=> '1 Column',
						'src'		=> get_template_directory_uri() . '/assets/images/admin/col-1c.png'
					),
					array(
						'value'		=> 'col-2cl',
						'label'		=> '2 Column Left',
						'src'		=> get_template_directory_uri() . '/assets/images/admin/col-2cl.png'
					),
					array(
						'value'		=> 'col-2cr',
						'label'		=> '2 Column Right',
						'src'		=> get_template_directory_uri() . '/assets/images/admin/col-2cr.png'
					)
				)
			)
		)
	);

	/* ---------------------------------------------------------------------- */
	/*	Home template
	/* ---------------------------------------------------------------------- */
	$home_template_settings = array(
		'id'          => 'attraction-settings',
		'title'       => 'Attraction Settings',
		'desc'        => '',
		'pages'       => array( 'page' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'label'       => 'Slider',
				'id'          => 'tab_slider',
				'type'        => 'tab'
			),
			array(
				'label'		=> 'Slider',
				'id'		=> $prefix . 'category_slider',
				'type'		=> 'taxonomy-select',
				'std'		=> '',
				'desc'		=> 'Select slide category to be show under header menu of this page. <br/><a href="'. get_admin_url() .'edit.php?post_type=cp_slider" target="_blank">Manage Slider</a>',
				'taxonomy'	=> 'slider'
			),
			array(
				'label'       => 'Best Offer',
				'id'          => 'tab_tour_offer',
				'type'        => 'tab'
			),
			array(
				'label'		=> 'Heading title',
				'id'		=> $prefix . 'heading_title',
				'type'		=> 'text',
				'std'		=> 'Special Offers Tours in Cambodia',
				'desc'		=> '',
			),
			array(
				'label'		=> 'Description',
				'id'		=> $prefix . 'heading_desc',
				'type'		=> 'textarea_simple',
				'std'		=> 'Explore best tours to visit some of our most popular destinations',
				'desc'		=> '',
				'rows'      => '3',
			),
			array(
				'label'		=> 'Tour style',
				'id'		=> $prefix . 'tour_style',
				'type'		=> 'taxonomy-select',
				'std'		=> '',
				'desc'		=> 'Select group of tour style, will be show on homepage',
				'taxonomy'	=> 'tour_style'
			),
			array(
				'label'		=> 'Amount of tours',
				'id'		=> $prefix . 'tour_amount',
				'type'		=> 'numeric-slider',
				'min_max_step'=> '1,6,1',
				'std'		=> '',
				'desc'		=> 'Set number of tour for this tour style. Between 1 and 6 tours',
			),
			array(
				'label'       => 'About Cambodia',
				'id'          => 'tab_about_cambodia',
				'type'        => 'tab'
			),
			array(
				'label'		=> 'Heading title',
				'id'		=> $prefix . 'cambodia_title',
				'type'		=> 'text',
				'std'		=> 'Welcome to Cambodia',
				'desc'		=> '',
			),
			array(
				'label'		=> 'Description',
				'id'		=> $prefix . 'cambodia_desc',
				'type'		=> 'textarea_simple',
				'std'		=> 'Cambodia is a country of charm and unique cultural heritage known across the globe for its incredible natural beauty, breathtaking temples, fertile rice paddy fields and a history past unlike any other. Should you decide to come and view the awe-inspiring temples of Angkor, you may find yourself transported into a world frozen in centuries past, which only comes to life in this special place. <strong>So where wil you go in Cambodia?</strong>',
				'desc'		=> '',
				'rows'      => '5',
			),
			array(
				'label'		=> 'Destinations 1',
				'id'		=> $prefix . 'destination_1',
				'type'		=> 'page_select',
				'std'		=> '',
				'desc'		=> 'Select destination you like to show under description.',
			),
			array(
				'label'		=> 'Destinations 2',
				'id'		=> $prefix . 'destination_2',
				'type'		=> 'page_select',
				'std'		=> '',
				'desc'		=> 'Select destination you like to show under description.',
			),
			array(
				'label'		=> 'Destinations 3',
				'id'		=> $prefix . 'destination_3',
				'type'		=> 'page_select',
				'std'		=> '',
				'desc'		=> 'Select destination you like to show under description.',
			),
			array(
				'label'		=> 'Map',
				'id'		=> $prefix . 'cambodia_map',
				'type'		=> 'upload',
				'std'		=> '',
				'desc'		=> 'Optional: Upload map for this country. .jpg, .gif, .png'
			),
			array(
				'label'		=> 'Map link',
				'id'		=> $prefix . 'cambodia_map_link',
				'type'		=> 'text',
				'std'		=> '',
				'desc'		=> 'Copy and past URL/link for the map',
			),
			array(
				'label'		=> 'Button link',
				'id'		=> $prefix . 'cambodia_btn_link',
				'type'		=> 'text',
				'std'		=> '',
				'desc'		=> 'Copy and past URL/link for button',
			),
			array(
				'label'       => 'Tour style',
				'id'          => 'tab_tour_style_icon',
				'type'        => 'tab'
			),
			array(
				'label'		=> 'Heading title',
				'id'		=> $prefix . 'style_title',
				'type'		=> 'text',
				'std'		=> 'Your Feeling and Tour Mood:',
				'desc'		=> '',
			),
			array(
				'label'		=> 'Description',
				'id'		=> $prefix . 'style_desc',
				'type'		=> 'textarea_simple',
				'std'		=> 'Join with us to explore and experience the most notable destinations and valuable treasure of Cambodia',
				'desc'		=> '',
				'rows'      => '3',
			),
			array(
				'label'		=> 'Show/Hide empty tour style name',
				'id'		=> $prefix . 'tour_hide_empty',
				'type'		=> 'on-off',
				'std'		=> 'on',
				'desc'		=> 'Default: on - show tour sytle name if it does not have any tours'
			),
		)
	);

	/* ---------------------------------------------------------------------- */
	/*	Attraction template
	/* ---------------------------------------------------------------------- */
	$attraction_template_settings = array(
		'id'          => 'attraction-settings',
		'title'       => 'Attraction Settings',
		'desc'        => '',
		'pages'       => array( 'page' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'label'     => 'Gallery',
				'id'        => $prefix . 'attraction_gallery',
				'type'		=> 'custom-post-type-select',
				'std'		=> '',
				'desc'		=> 'Select album for this attraction. <br/><a href="'. get_admin_url() .'edit.php?post_type=cp_gallery" target="_blank">Manage Gallery</a>',
				'post_type'	=> 'cp_gallery'
			),
			array(
				'label'		=> 'Map',
				'id'		=> $prefix . 'embed_map',
				'type'		=> 'text',
				'std'		=> '',
				'desc'		=> 'Copy embed map code from google map account'
			),
			array(
				'label'		=> 'Tour by Destination',
				'id'		=> $prefix . 'related_tour',
				'type'		=> 'taxonomy-select',
				'std'		=> '',
				'desc'		=> 'Select destination name to show related tour',
				'taxonomy'	=> 'tour_destination'
			),
		)
	);		

	/* ---------------------------------------------------------------------- */
	/*	Post Type - Tour
	/* ---------------------------------------------------------------------- */
	$post_type_tour = array(
		'id'          => 'tour-settings',
		'title'       => 'Tour SUMMARY',
		'desc'        => '',
		'pages'       => array( 'cp_tour' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'label'       => 'Day',
				'id'          => 'tab_day',
				'type'        => 'tab'
			),
			array(
				'label'		=> 'Amount of days',
				'id'		=> $prefix . 'day_amount',
				'type'		=> 'numeric-slider',
				'min_max_step'=> '1,30,1',
				'std'		=> '',
				'desc'		=> 'Set number of day for this tour',
			),
			array(
				'label'       => 'Price',
				'id'          => 'tab_price',
				'type'        => 'tab'
			),
			array(
				'label'		=> 'Price',
				'id'		=> $prefix . 'tour_price',
				'type'		=> 'text',
				'std'		=> '',
				'desc'		=> 'Enter number only. e.g: 1840',
			),
			array(
				'label'		=> 'Is promotion',
				'id'		=> $prefix . 'is_promote',
				'type'		=> 'on-off',
				'std'		=> 'off',
				'desc'		=> 'Switch discount options - on/off'
			),
			array(
				'label'		=> 'Percentage of discount',
				'id'		=> $prefix . 'discount_amount',
				'type'		=> 'text',
				'std'		=> '',
				'desc'		=> 'Enter number only. e.g: 5, 10 or 30',
				'condition'	=> 'wpsp_is_promote:is(on)'
			),
			array(
				'label'       => 'Available Date',
				'id'          => 'tab_date',
				'type'        => 'tab'
			),
			array(
				'label'		=> 'Valid from',
				'id'		=> $prefix . 'valid_from',
				'type'		=> 'date-picker',
				'std'		=> '',
				'desc'		=> 'Tour Available star date',
			),
			array(
				'label'		=> 'Valid end',
				'id'		=> $prefix . 'valid_end',
				'type'		=> 'date-picker',
				'std'		=> '',
				'desc'		=> 'Tour Available end date',
			),
			array(
				'label'       => 'Brochure',
				'id'          => 'tab_brochure',
				'type'        => 'tab'
			),
			array(
				'label'		=> 'Brochure',
				'id'		=> $prefix . 'brochure',
				'type'		=> 'upload',
				'std'		=> '',
				'desc'		=> 'Optional: Upload brochure file for guest/customer download. .doc, .docx, .pdf'
			),
			array(
				'label'       => 'Highlight',
				'id'          => 'tab_highlight',
				'type'        => 'tab'
			),
			array(
				'label'		=> 'Tour highlight',
				'id'		=> $prefix . 'highlight',
				'type'		=> 'textarea-simple',
				'desc'		=> 'You can separate each days by comma(,) <br> e.g: Day 1: Arrive in Phnom Penh, <br>Day 2: Explore Phnom Penh',
				'rows'      => '4'
			),
			array(
				'label'       => 'Map',
				'id'          => 'tab_map',
				'type'        => 'tab'
			),
			array(
				'label'		=> 'Map',
				'id'		=> $prefix . 'embed_map',
				'type'		=> 'text',
				'std'		=> '',
				'desc'		=> 'Copy embed map code from google map account'
			),
		)
	);

	/* ---------------------------------------------------------------------- */
	/*	Post Type - Tour - Slideshow
	/* ---------------------------------------------------------------------- */
	$post_type_tour_slideshow = array(
		'id'          => 'tour-slideshow',
		'title'       => 'Tour Slideshow',
		'desc'        => '',
		'pages'       => array( 'cp_tour' ),
		'context'     => 'normal',
		'priority'    => 'default',
		'fields'      => array(
			array(
				'label'		=> 'Upload photos',
				'id'		=> $prefix . 'tour_slideshow',
				'type'		=> 'gallery',
				'std'		=> '',
				'desc'		=> 'Upload photos slideshow for this tour with supported file: .jpg, .gif and .png',
			)
		)
	);

	/* ---------------------------------------------------------------------- */
	/*	Post Type - Slider
	/* ---------------------------------------------------------------------- */
	$post_type_slider = array(
		'id'          => 'slider-settings',
		'title'       => 'Slider Settings',
		'desc'        => '',
		'pages'       => array( 'cp_slider' ),
		'context'     => 'normal',
		'priority'    => 'default',
		'fields'      => array(
			array(
				'label'		=> 'Button text',
				'id'		=> $prefix . 'slider_btn',
				'type'		=> 'text',
				'std'		=> 'Discover Now',
				'desc'		=> '',
			),
			array(
				'label'		=> 'Link',
				'id'		=> $prefix . 'slider_link',
				'type'		=> 'text',
				'std'		=> '',
				'desc'		=> '',
			),
			array(
				'label'		=> 'Upload photos',
				'id'		=> $prefix . 'slider_image',
				'type'		=> 'upload',
				'std'		=> '',
				'desc'		=> 'Upload photos slideshow with support file: .jpg, .gif, .png',
			),
		)
	);


	// Gallery post type
	$post_type_gallery = array(
		'id'          => 'gallery-settings',
		'title'       => 'Upload photos',
		'desc'        => 'These settings enable you to upload photos.',
		'pages'       => array( 'cp_gallery' ),
		'context'     => 'normal',
		'priority'    => 'default',
		'fields'      => array(
			array(
				'label'		=> 'Upload photo',
				'id'		=> $prefix . 'gallery',
				'type'		=> 'gallery',
				'desc'		=> 'Upload photos'
			),
		)
	);

	/* ---------------------------------------------------------------------- */
	/*	Return meta box option base on page template selected
	/* ---------------------------------------------------------------------- */
	function rw_maybe_include() {
		// Include in back-end only
		if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN ) {
			return false;
		}

		// Always include for ajax
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return true;
		}

		if ( isset( $_GET['post'] ) ) {
			$post_id = $_GET['post'];
		}
		elseif ( isset( $_POST['post_ID'] ) ) {
			$post_id = $_POST['post_ID'];
		}
		else {
			$post_id = false;
		}

		$post_id = (int) $post_id;
		$post    = get_post( $post_id );

		$template = get_post_meta( $post_id, '_wp_page_template', true );

		return $template;
	}

	/**
    * Register our meta boxes using the 
    * ot_register_meta_box() function.
    */
	if ( function_exists( 'ot_register_meta_box' ) ) :

		ot_register_meta_box( $post_type_tour );
		ot_register_meta_box( $post_type_tour_slideshow );
		ot_register_meta_box( $post_type_slider );
		ot_register_meta_box( $post_type_gallery );

		$template_file = rw_maybe_include();
		if ( $template_file == 'templates/page-attraction.php' ) {
			ot_register_meta_box( $attraction_template_settings ); 
		}
		if ( $template_file == 'templates/page-home.php' ) {
			ot_register_meta_box( $home_template_settings ); 
		}
		ot_register_meta_box( $page_layout_options );
		
	endif;
	
}