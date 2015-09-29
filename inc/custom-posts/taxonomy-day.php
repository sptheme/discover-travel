<?php
add_action('init', 'wpsp_tax_tour_day_init', 0);

function wpsp_tax_tour_day_init() {
	register_taxonomy(
		'tour_day',
		array( 'cp_tour' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Days', 'wpsp_admin' ),
				'singular_name' => __( 'Day', 'wpsp_admin' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'tour-day' ),
			'show_in_nav_menus' => true
		)
	);
}