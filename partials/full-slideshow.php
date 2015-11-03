<?php
/**
 * Template part for displaying slider by taxonomy.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

?>

<?php $gallery_term = get_post_meta( $post->ID, 'wpsp_category_slider', true );
	$args = array(
			'post_type'	=> 'cp_slider',
			'tax_query'	=> array(
					array(
						'taxonomy'	=> 'slider',
						'field'		=> 'term_id',
						'terms'		=> $gallery_term
						)
				)
		); 
	$custom_query = new WP_Query( $args ); ?>

<?php if ( $custom_query -> have_posts() ) : ?>	

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
<div class="full-slide-container">
	<div id="slides">
	    <ul class="slides-container">
	<?php while ($custom_query -> have_posts() ) : $custom_query->the_post(); 
		$btn_text = get_post_meta( $post->ID, 'wpsp_slider_btn', true ); 
		$slider_link = get_post_meta( $post->ID, 'wpsp_slider_link', true ); 
		$slider_img_url = get_post_meta( $post->ID, 'wpsp_slider_image', true ); ?>    
	        <li<?php echo ( empty($slider_link) ) ? ' class="title-only"' : '' ; ?>>
	            <img src="<?php echo $slider_img_url; ?>">
	            
	            <div class="slide-caption clearfix">
	                <h2><?php the_title(); ?></h2>
	                <?php if ( !empty($slider_link) ) : ?>
	                <a class="button" href="<?php echo esc_url( $slider_link ); ?>"><?php echo esc_html( $btn_text ); ?></a>
	            	<?php endif; ?>
	            </div>    
	        </li>
	<?php endwhile; wp_reset_postdata(); ?>        
		</ul>
		<nav class="slides-navigation">
	        <a href="#" class="next"><i class="fa fa-chevron-right"></i></a>
	        <a href="#" class="prev"><i class="fa fa-chevron-left"></i></a>
	      </nav>
	</div> <!-- #slides -->	
</div> <!-- .full-slide-container -->
<?php endif; ?>