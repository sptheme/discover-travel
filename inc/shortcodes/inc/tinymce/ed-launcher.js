/**
 * Launcher Short code button
 */

(function($) {
     tinymce.create( 'tinymce.plugins.launcher', {
        init : function( ed, url ) {
             ed.addButton( 'launcher', {
                title : 'Insert Launcher Posts',
                image : url + '/ed-icons/launcher.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Launcher options', 'admin-ajax.php?action=wpsp_launcher_shortcode_ajax&width=' + W + '&height=' + H );					                 }
             });
         },
         getInfo : function() {
				return {
						longname : 'SP Theme',
						author : 'Sopheak Peas',
						authorurl : 'http://www.linkedin.com/in/sopheakpeas',
						infourl : 'http://www.linkedin.com/in/sopheakpeas',
						version : '1.0.1'
				};
		}
     });
	tinymce.PluginManager.add( 'launcher', tinymce.plugins.launcher );

	// handles the click event of the submit button
	$('body').on('click', '#sc-launcher-form #option-submit', function() {
		form = $('#sc-launcher-form');
		// defines the options and their default values
		// again, this is not the most elegant way to do this
		// but well, this gets the job done nonetheless
		var options = { 
			'term_id' : null,
			'post_num' : null,
			'cols' : null
			};
		var shortcode = '[sc_launcher';
		
		for( var index in options) {
			var value = form.find('#'+index).val();
			
			// attaches the attribute to the shortcode only if it's different from the default value
			if ( value !== options[index] )
				shortcode += ' ' + index + '="' + value + '"';
		}
		
		shortcode += ']';
			
		// inserts the shortcode into the active editor
		tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
		// closes Thickbox
		tb_remove();
		
		
	});
	
})(jQuery);