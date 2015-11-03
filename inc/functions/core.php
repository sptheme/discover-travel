<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Discover Travel
 */


if ( ! function_exists( 'wpsp_excerpt_length' ) ) :
/**
 * Excerpt length
 *
 */
add_filter( 'excerpt_length', 'wpsp_excerpt_length', 999 );

function wpsp_excerpt_length( $length ) {
	return 23;
}
endif;

if ( ! function_exists( 'wpsp_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function wpsp_posted_on() {

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s ', 'post date', 'discovertravel' ),
		$time_string
	);

	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'discovertravel' ) );
	

	$byline = sprintf(
		esc_html_x( '%s ', 'post author', 'discovertravel' ),
		'<span class="author vcard">' . esc_html( get_the_author() ) . '</span>'
	);

	if ( 'post' == get_post_type() ) {
		echo '<span class="byline"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span><span class="category-list">' . $categories_list . '</span>'; // WPCS: XSS OK.
		//echo '<span class="posted-on">' . $posted_on . '</span><span class="category-list">' . $categories_list . '</span>';
	} else {
		echo '<span class="byline"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span>';
	}

}
endif;

if ( ! function_exists( 'wpsp_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function wpsp_entry_footer() {
	edit_post_link( esc_html__( 'Edit', 'discovertravel' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'wpsp_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function wpsp_paging_nav( $pages = '', $range = 2 ) {
	$showitems = ( $range * 2 ) + 1;

	global $paged, $wp_query;

	if( empty( $paged ) )
		$paged = 1;

	if( $pages == '' ) {

		$pages = $wp_query->max_num_pages;

		if( !$pages )
			$pages = 1;

	}

	if( 1 != $pages ) {

		$output = '<nav class="pagination">';

		// if( $paged > 2 && $paged >= $range + 1 /*&& $showitems < $pages*/ )
			// $output .= '<a href="' . get_pagenum_link( 1 ) . '" class="next">&laquo; ' . __('First', 'sptheme_admin') . '</a>';

		if( $paged > 1 /*&& $showitems < $pages*/ )
			$output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="next">&larr; ' . __('Previous', 'discovertravel') . '</a>';

		for ( $i = 1; $i <= $pages; $i++ )  {

			if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
				$output .= ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '">' . $i . '</a>';

		}

		if ( $paged < $pages /*&& $showitems < $pages*/ )
			$output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="prev">' . __('Next', 'discovertravel') . ' &rarr;</a>';

		// if ( $paged < $pages - 1 && $paged + $range - 1 <= $pages /*&& $showitems < $pages*/ )
			// $output .= '<a href="' . get_pagenum_link( $pages ) . '" class="prev">' . __('Last', 'sptheme_admin') . ' &raquo;</a>';

		$output .= '</nav>';

		return $output;

	}
}
endif;


/**
 * Modify unused Media Gallery Columns
 * Delete column # 6-9
 * @link http://www.wizzud.com/2013/07/29/how-to-add-a-gallery-option-for-zero-columns-to-wordpress-media-manager/
 */
add_action( 'wp_enqueue_media', 'wpsp_media_gallery_edit_columns' );
function wpsp_media_gallery_edit_columns(){
	add_action( 'admin_print_footer_scripts', 'wpsp_media_gallery_edit_columns_script', 999);
}
function wpsp_media_gallery_edit_columns_script(){
?>
<script type="text/javascript">
jQuery(function(){
	if(wp.media.view.Settings.Gallery){
		wp.media.view.Settings.Gallery = wp.media.view.Settings.extend({
			className: "collection-settings gallery-settings",
			template: wp.media.template("gallery-settings"),
			render:	function() {
				wp.media.View.prototype.render.apply( this, arguments );
				// Remove column from 6-9
				var $s = this.$('select.columns');
				$s.find('option[value="6"]').remove();
				$s.find('option[value="7"]').remove();
				$s.find('option[value="8"]').remove();
				$s.find('option[value="9"]').remove();

				// Select the correct values.
				_( this.model.attributes ).chain().keys().each( this.update, this );
				return this;
			}
		});
	}
});
</script>
<?php
}

/**
 * Add custom image sizes selectable in WordPress admin
 */
add_filter( 'image_size_names_choose', 'wpsp_custom_sizes' );
 
function wpsp_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'slide' => __( 'Slide' ),
    ) );
}