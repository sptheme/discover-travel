<?php
add_action('init', 'wpsp_tax_multi_country_init', 0);

function wpsp_tax_multi_country_init() {
	register_taxonomy(
		'multi_country',
		array( 'cp_tour' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Multi-Country', 'wpsp_admin' ),
				'singular_name' => __( 'Multi-Country', 'wpsp_admin' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'multi-country' ),
			'show_in_nav_menus' => true
		)
	);
}