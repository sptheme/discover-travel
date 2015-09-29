<?php
add_action('init', 'wpsp_tax_slider_init', 0);

function wpsp_tax_slider_init() {
	register_taxonomy(
		'slider',
		array( 'cp_slider' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Categories', 'wpsp_admin' ),
				'singular_name' => __( 'Category', 'wpsp_admin' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'slider' ),
			'show_in_nav_menus' => true
		)
	);
}