<?php
/**
 * Setup tour style taxonomy
 *
 * @package     Discover Travel
 * @since       Discover Travel 1.0.0
 */

/**
 * Register Tour Style taxonomy
 */
function wpsp_tax_tour_style_init() {
	register_taxonomy(
		'tour_style',
		array( 'cp_tour' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Styles', 'wpsp_admin' ),
				'singular_name' => __( 'Style', 'wpsp_admin' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'tour-style' ),
			'show_in_nav_menus' => true
		)
	);
}
add_action('init', 'wpsp_tax_tour_style_init', 0);

/**
 * Create edit custom field 
 * 
 * Use HTML tag and Class to present icon before Tour style name
 * @since 	Discover Travel 1.0.0
 */
function edit_tour_style($tag, $taxonomy) {
	$icon_field = get_option( 'tour_style_'.$tag->term_id.'_icon', '' );
	?>
	<tr class="form-field">
        <th scope="row" valign="top"><label for="tour_style_icon">Icon</label></th>
        <td>
            <input type="text" name="tour_style_icon" id="tour_style_icon" value="<?php echo $icon_field; ?>"/>
            <p class="description">Place HTML tag with class name to present icon before Tour style name.</p>
        </td>
    </tr>
    <?php
}
add_action( 'tour_style_edit_form_fields', 'edit_tour_style', 10, 2);

/**
 * Save meta values
 */
if ( ! function_exists( 'save_tour_style' ) ) {
	
	function save_tour_style($term_id, $tt_id) {
	    if (!$term_id) return;
	
		if (isset($_POST['tour_style_icon'])){
			$name = 'tour_style_' .$term_id. '_icon';
			update_option( $name, $_POST['tour_style_icon'] );
		}
	}

}
add_action( 'edited_tour_style', 'save_tour_style', 10, 2);

/**
 * Delete Meta values fields after delete taxonomy
 */
if ( ! function_exists( 'delete_tour_style' ) ) {

	function delete_tour_style($id) {
		delete_option( 'tour_style_'.$id.'_icon' );
	}
	
}
add_action( 'deleted_term_taxonomy', 'delete_tour_style' );