<?php
/**
 * Template part for displaying tour list.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

?>

<?php $tour_price = get_post_meta( $post->ID, 'wpsp_tour_price', true );
	$is_promote = get_post_meta( $post->ID, 'wpsp_is_promote', true );
	$percentage = get_post_meta( $post->ID, 'wpsp_discount_amount', true );
	$day_amount = get_post_meta( $post->ID, 'wpsp_day_amount', true ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'box-shadow', 'tour-thumb-wrap', 'list', 'clearfix' ) ); ?>>
	<div class="tour-post-thumb effect-honey">
        <?php	
			if (has_post_thumbnail()) {
			    the_post_thumbnail( 'thumbnail' );
			} else { 
				echo '<img src="' . esc_url( ot_get_option( 'post-placeholder' ) ) . '">';
			} 
		?>
        <div class="thumb-caption">
            <span class="day-amount"><?php echo $day_amount; ?> <?php echo esc_html__( 'Days', 'discovertravel' ); ?></span>
            <a href="<?php echo esc_url( get_permalink() ); ?>"><span class="button color-green"><?php echo esc_html__( 'Detail', 'discovertravel' ); ?></span></a>
        </div>
    </div>
    <div class="tour-meta">
        <?php the_title( sprintf( '<h3 class="entry-title" itemprop="name"><a itemprop="url" href="%1$s" rel="bookmark" title="%2$s">', esc_url( get_permalink() ), esc_attr( get_the_title() ) ), '</a></h3>' ); ?>
        <div class="destination">
            <?php wpsp_list_tour_destination(); ?>
        </div>
        <?php wpsp_list_tour_style(); ?>
        <div class="price">
            <?php wpsp_tour_price( $tour_price, $is_promote, $percentage ); ?>
        </div>
        <a href="<?php echo esc_url( get_permalink() ); ?>" class="more-info"><?php echo esc_html__( 'More info', 'discovertravel' ); ?></a>
    </div> <!-- .tour-meta -->
</article><!-- #post-## -->