<?php
add_action('init', 'wpsp_tax_tour_destination_init', 0);

function wpsp_tax_tour_destination_init() {
	register_taxonomy(
		'tour_destination',
		array( 'cp_tour' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Destinations', 'wpsp_admin' ),
				'singular_name' => __( 'Destination', 'wpsp_admin' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'tour-destination' ),
			'show_in_nav_menus' => true
		)
	);
}