<?php

add_action('wp_ajax_wpsp_photogallery_shortcode_ajax', 'wpsp_photogallery_shortcode_ajax' );

function wpsp_photogallery_shortcode_ajax() {
	$defaults = array(
		'photogallery' => null
	);
	$args = array_merge( $defaults, $_GET );
	?>

	<div id="sc-photogallery-form">
			<table id="sc-photogallery-table" class="form-table">
				<!-- <tr>
					<?php $field = 'album_id'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Album options: ', 'wpsp_shortcode' ); ?></label></th>
					<td>
						<select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
							<option class="level-0" value="-1"><?php _e( 'All albums', 'wpsp_shortcode' ); ?></option>
							<optgroup label="<?php _e( 'By Group', 'wpsp_shortcode' ); ?>">
								<?php $args = array(
										'hide_empty'	=> 0
									);
								$taxonomies = get_terms( 'gallery_category', $args );
								foreach ( $taxonomies as $tax ) {
									echo '<option class="level-0" value="' . $tax->term_id . '">' . $tax->name . '</option>';
								} ?>
							</optgroup>
							<optgroup label="<?php _e( 'By album', 'wpsp_shortcode' ); ?>">
								<?php $args = (array(
									'post_type' => 'cp_gallery',
									'post_per_pages' => -1
								));
								$posts = get_posts( $args );
								foreach ( $posts as $post ) {
									echo '<option class="level-0" value="' . $post->ID . '">' . $post->post_title . '</option>';
								} ?>
							</optgroup>
						</select>
					</td>
				</tr> -->
				<tr>
					<?php $field = 'term_id'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Album options: ', 'wpsp_shortcode' ); ?></label></th>
					<td>
						<select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
							<option class="level-0" value="0"><?php _e( 'Select category', 'wpsp_shortcode' ); ?></option>
							<?php $args = array(
									'hide_empty'	=> 0
								);
							$taxonomies = get_terms( 'gallery_category', $args );
							foreach ( $taxonomies as $tax ) {
								echo '<option class="level-0" value="' . $tax->term_id . '">' . $tax->name . '</option>';
							} ?>
						</select>
					</td>
				</tr>
				<tr>
					<?php $field = 'post_num'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Number of photo/album: ', 'wpsp_shortcode' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="-1" /> <smal>(-1 for show all)</small>
					</td>
				</tr>
				<tr>
					<?php $field = 'cols'; ?>
					<th><label for="<?php echo $field; ?>"><?php _e( 'Columns: ', 'wpsp_shortcode' ); ?></label></th>
					<td>
						<select name="<?php echo $field; ?>" id="<?php echo $field; ?>">
							<option class="level-0" value="2">2</option>
							<option class="level-0" selected="selected" value="3">3</option>
							<option class="level-0" value="4">4</option>
						</select>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php _e( 'Add photogallery', 'wpsp_shortcode' ); ?>" name="submit" />
			</p>
	</div>			

	<?php
	exit();	
}
?>