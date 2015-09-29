<?php
/**
 * Template part for displaying single tour photo slideshow.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

?>

<?php global $post;
	$photos = explode( ',', get_post_meta( $post->ID, 'wpsp_tour_slideshow', true ) ); ?>

<?php if ( $photos[0] != '' ) : ?>	

<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#slides').superslides({
        	play: 5000,
		    animation_speed: 600,
		    animation_easing: 'swing',
		    animation: 'slide',
	        inherit_width_from: '.full-slide-container',
	        inherit_height_from: '.full-slide-container'
	      });
    });     
</script>
<div class="site-slider">
	<div id="slides">
	    <ul class="slides-container">
	<?php foreach ( $photos as $photo ) : ?>    
	        <li><?php echo wp_get_attachment_image( $photo, 'post-slide' ); ?></li>
	<?php endforeach; ?>        
		</ul>
		<nav class="slides-navigation">
			<a href="#" class="next"><i class="fa fa-chevron-right"></i></a>
			<a href="#" class="prev"><i class="fa fa-chevron-left"></i></a>
		</nav>
	</div> <!-- #slides -->	
</div> <!-- .site-slider -->
<?php endif; ?>