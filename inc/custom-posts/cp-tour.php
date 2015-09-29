<?php
/*
*****************************************************
* Tour custom post
*
* CONTENT:
* - 1) Actions and filters
* - 2) Creating a custom post
* - 3) Custom post list in admin
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering CP
		add_action( 'init', 'wpsp_tour_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'wpsp_tour_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-cp_tour_columns', 'wpsp_tour_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'wpsp_tour_cp_init' ) ) {
		function wpsp_tour_cp_init() {
			global $cp_menu_position;

			$labels = array(
				'name'               => __( 'Tours', 'wpsp_admin' ),
				'singular_name'      => __( 'Tour', 'wpsp_admin' ),
				'add_new'            => __( 'Add New', 'wpsp_admin' ),
				'all_items'          => __( 'All Tour', 'wpsp_admin' ),
				'add_new_item'       => __( 'Add New Tour', 'wpsp_admin' ),
				'new_item'           => __( 'Add New Tour', 'wpsp_admin' ),
				'edit_item'          => __( 'Edit Tour', 'wpsp_admin' ),
				'view_item'          => __( 'View Tour', 'wpsp_admin' ),
				'search_items'       => __( 'Search Tour', 'wpsp_admin' ),
				'not_found'          => __( 'No Tour found', 'wpsp_admin' ),
				'not_found_in_trash' => __( 'No Tour found in trash', 'wpsp_admin' ),
				'parent_item_colon'  => __( 'Parent Tour', 'wpsp_admin' ),
			);	

			$role     = 'post'; // page
			$slug     = 'tour';
			$supports = array('title', 'editor', 'thumbnail'); // 'title', 'editor', 'thumbnail', 'post-formats'

			$args = array(
				'labels' 				=> $labels,
				'rewrite'               => array( 'slug' => $slug ),
				'menu_position'         => $cp_menu_position['menu_tour'],
				'menu_icon'           	=> 'dashicons-megaphone',
				'supports'              => $supports,
				'capability_type'     	=> $role,
				'query_var'           	=> true,
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_nav_menus'	    => false,
				'publicly_queryable'	=> true,
				'exclude_from_search'   => false,
				'has_archive'			=> true,
				'can_export'			=> true
			);
			register_post_type( 'cp_tour' , $args );
		}
	} 


/*
*****************************************************
*      3) CUSTOM POST LIST IN ADMIN
*****************************************************
*/
	/*
	* Registration of the table columns
	*
	* $Cols = ARRAY [array of columns]
	*/
	if ( ! function_exists( 'wpsp_tour_cp_columns' ) ) {
		function wpsp_tour_cp_columns( $columns ) {
			
			$columns['cb']                  = '<input type="checkbox" />';
			$columns['title']               = __( 'Title', 'wpsp_admin' );
			$columns['tour_thumbnail']		= __( 'Thumbnail', 'wpsp_admin' );
			$columns['duration']   			= __( 'Duration', 'wpsp_admin' );
			$columns['valid_date']		 	= __( 'Valid Date', 'wpsp_admin' );
			$columns['date']		 		= __( 'Date create', 'wpsp_admin' );

			return $columns;
		}
	}

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'wpsp_tour_cp_custom_column' ) ) {
		function wpsp_tour_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
				case "tour_thumbnail":
					echo get_the_post_thumbnail( $post->ID, array(50, 50) );
				break;

				case "duration":
					echo get_post_meta( $post->ID, 'wpsp_day_amount', true ) . esc_html__( ' Days', 'wpsp_admin' );
				break;

				case "valid_date":
					$valid_from = date("d F Y", strtotime(get_post_meta( $post->ID, 'wpsp_valid_from', true )));
					$valid_end = date("d F Y", strtotime(get_post_meta( $post->ID, 'wpsp_valid_end', true )));
					echo esc_html__( 'From ', 'wpsp_admin' ) . $valid_from . esc_html__( ' to ', 'wpsp_admin' ) . $valid_end;
				break;
				
				default:
				break;
			}
		}
	} // /wpsp_tour_cp_custom_column

	
	