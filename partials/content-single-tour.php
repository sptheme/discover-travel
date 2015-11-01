<?php
/**
 * Template part for displaying single tour posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

?>

<?php $embed_map = get_post_meta( $post->ID, 'wpsp_embed_map', true ); ?>

<div class="itenerary-content">
	<?php if ( $embed_map ) : ?>
    <div class="tour-map"><?php echo $embed_map; ?></div>            
	<?php endif; ?>
	<?php the_content(); ?>
</div><!-- .entry-content -->

<?php get_template_part('partials/tour-inquiry'); ?>

