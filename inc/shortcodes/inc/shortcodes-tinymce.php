<?php
/**
 * Short codes in visual editor
 * Register short code buttons and add them to the visual mode of editor
 */

if ( ! function_exists( 'wpsp_shortcodes_register_mce_button_3' ) ) :
/**
 * Register Buttons row 3
 */
function wpsp_shortcodes_register_mce_button_3( $buttons ) {

	array_unshift( $buttons, 'fontsizeselect' );
	array_unshift( $buttons, 'fontselect' );

	array_push( $buttons, 'col' );
	array_push( $buttons, 'btn' );
	array_push( $buttons, 'accordion' );
	/*array_push( $buttons, 'horz_rule' );
	array_push( $buttons, 'email_encoder' );
	array_push( $buttons, 'toggle' );
	array_push( $buttons, 'tab' );
	array_push( $buttons, 'team' );
	array_push( $buttons, 'photogallery' );
	array_push( $buttons, 'post' );*/
	array_push( $buttons, 'tour_inclusion' );

    return $buttons;
}
endif;

if ( !function_exists( 'wpsp_customize_text_sizes' ) ) :
/**
 * Customize mce editor font sizes and google font
 */
function wpsp_customize_text_sizes( $initArray ){

	$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
	$initArray['font_formats'] = 'Courgette=courgette;Qwigley=qwigley;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
	
	return $initArray;
}
add_filter( 'tiny_mce_before_init', 'wpsp_customize_text_sizes' );
endif;

if ( !function_exists( 'wpsp_mce_google_fonts_styles' ) ) :
/**
 * add google scripts for use with the editor
 */
function wpsp_mce_google_fonts_styles() {

	$scripts[] = 'http://fonts.googleapis.com/css?family=Courgette';
	$scripts[] = 'http://fonts.googleapis.com/css?family=Qwigley';
	foreach ( $scripts as $script ) {
		add_editor_style( str_replace( ',', '%2C', $script ) );
	}

}
add_action( 'init', 'wpsp_mce_google_fonts_styles' );	
endif;

if ( !function_exists( 'wpsp_shortcodes_add_tinymce_plugin' ) ) :
/**
 * Register TinyMCE Plugin
 */
function wpsp_shortcodes_add_tinymce_plugin($plugin_array) {
	if (isset($_GET['post'])) {
		$post = get_post($_GET['post']);
		if ($post)
            $post_type = $post->post_type;
	} elseif ( !isset($_GET['post_type']) )
        $post_type = 'post';
    elseif ( in_array( $_GET['post_type'], get_post_types( array('show_ui' => true ) ) ) )
        $post_type = $_GET['post_type'];
    else
        return;

	$plugin_array['col'] 			= ED_JS_URL . 'ed-columns.js';
	$plugin_array['btn']			= ED_JS_URL . 'ed-button.js';
	$plugin_array['horz_rule']		= ED_JS_URL . 'ed-hr.js';
	$plugin_array['email_encoder']	= ED_JS_URL . 'ed-email-encoder.js';
	$plugin_array['tour_inclusion']	= ED_JS_URL . 'ed-tour-inclusion.js';
	$plugin_array['accordion']		= ED_JS_URL . 'ed-accordion.js';
	/*$plugin_array['toggle']			= ED_JS_URL . 'ed-toggle.js';
	$plugin_array['tab']			= ED_JS_URL . 'ed-tab.js';*/
	/*if ( $post_type == 'page' ) {
		$plugin_array['team']				= ED_JS_URL . 'ed-team.js';
		$plugin_array['photogallery']		= ED_JS_URL . 'ed-photogallery.js';
		$plugin_array['post']				= ED_JS_URL . 'ed-post.js';
	}*/
	
    return $plugin_array;
}
endif;

/**
 * Initialization Function
 */
function wpsp_shortcodes_add_mce_button() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
	  add_filter( 'mce_external_plugins', 'wpsp_shortcodes_add_tinymce_plugin' );
	  add_filter( 'mce_buttons_3', 'wpsp_shortcodes_register_mce_button_3' );
	}
}
add_action( 'admin_head', 'wpsp_shortcodes_add_mce_button' );

// load_template( SC_INC_DIR . 'popup/ajax-team-shortcode.php' );
// load_template( SC_INC_DIR . 'popup/ajax-photogallery-shortcode.php' );
// load_template( SC_INC_DIR . 'popup/ajax-post-shortcode.php' );