<?php
/*
*****************************************************
* Slider custom post
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
		add_action( 'init', 'wpsp_slider_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'wpsp_slider_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-cp_slider_columns', 'wpsp_slider_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'wpsp_slider_cp_init' ) ) {
		function wpsp_slider_cp_init() {
			global $cp_menu_position;

			$labels = array(
				'name'               => __( 'Sliders', 'wpsp_admin' ),
				'singular_name'      => __( 'Slider', 'wpsp_admin' ),
				'add_new'            => __( 'Add New', 'wpsp_admin' ),
				'all_items'          => __( 'All Slider', 'wpsp_admin' ),
				'add_new_item'       => __( 'Add New Slider', 'wpsp_admin' ),
				'new_item'           => __( 'Add New Slider', 'wpsp_admin' ),
				'edit_item'          => __( 'Edit Slider', 'wpsp_admin' ),
				'view_item'          => __( 'View Slider', 'wpsp_admin' ),
				'search_items'       => __( 'Search Slider', 'wpsp_admin' ),
				'not_found'          => __( 'No Slider found', 'wpsp_admin' ),
				'not_found_in_trash' => __( 'No Slider found in trash', 'wpsp_admin' ),
				'parent_item_colon'  => __( 'Parent Slider', 'wpsp_admin' ),
			);	

			$role     = 'post'; // page
			$slug     = 'slider';
			$supports = array('title'); // 'title', 'editor', 'thumbnail', 'post-formats'

			$args = array(
				'labels' 				=> $labels,
				'rewrite'               => array( 'slug' => $slug ),
				'menu_position'         => $cp_menu_position['menu_slider'],
				'menu_icon'           	=> 'dashicons-archive',
				'supports'              => $supports,
				'capability_type'     	=> $role,
				'query_var'           	=> true,
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_nav_menus'	    => false,
				'publicly_queryable'	=> true,
				'exclude_from_search'   => false,
				'has_archive'			=> false,
				'can_export'			=> true
			);
			register_post_type( 'cp_slider' , $args );
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
	if ( ! function_exists( 'wpsp_slider_cp_columns' ) ) {
		function wpsp_slider_cp_columns( $columns ) {
			
			$columns['cb']                  = '<input type="checkbox" />';
			$columns['title']               = __( 'Title', 'wpsp_admin' );
			$columns['slider_thumbnail']	= __( 'Thumbnail', 'wpsp_admin' );
			$columns['slider_category']    	= __( 'Category', 'wpsp_admin' );

			return $columns;
		}
	}

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'wpsp_slider_cp_custom_column' ) ) {
		function wpsp_slider_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
				case "slider_thumbnail":
					echo '<img src="' . get_post_meta( $post->ID, 'wpsp_slider_image', true ) . '" width="120">';
				break;

				case "slider_category":
					$terms = get_the_terms( $post->ID, 'slider' );

					if ( empty( $terms ) )
					break;
	
					$output = array();
	
					foreach ( $terms as $term ) {
						
						$output[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'slider' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'slider', 'display' ) )
						);
	
					}
	
					echo join( ', ', $output );
				break;
				
				default:
				break;
			}
		}
	} // /wpsp_slider_cp_custom_column

	
	