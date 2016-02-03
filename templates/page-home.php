<?php
/**
 * Template Name: Homepage
 *
 * This is the template that displays landing homepage.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Discover Travel
 */

get_header(); ?>

	<?php $meta = get_post_meta( $post->ID ); 
	$term = get_term_by( 'id', $meta['wpsp_tour_style'][0], 'tour_style' ); ?>
	<?php $args = array(
		'post_type'	=> 'cp_tour',
		'tax_query' => array(
		  			array(
						'taxonomy' => 'tour_style',
						'field' => 'id',
		  				'terms' => array( $meta['wpsp_tour_style'][0] )
					),
				),
		'orderby' => 'rand',
		'posts_per_page' => $meta['wpsp_tour_amount'][0]
		);
	$custom_query = new WP_Query($args); ?>

	<?php if ( $custom_query -> have_posts() ) : ?>
	<section id="best-offer">
        <div class="container">
        <header class="section-title">
            <h2><?php echo $meta['wpsp_heading_title'][0]; ?></h2>
            <p class="description"><?php echo $meta['wpsp_heading_desc'][0]; ?></p>
        </header>
        <div class="row">
        <?php while ($custom_query -> have_posts() ) : $custom_query->the_post(); ?>
        	<div class="col-sm-4">
        <?php get_template_part( 'partials/tour-grid' ); ?>
        	</div>
    	<?php endwhile; wp_reset_postdata(); ?>
        </div> <!-- .row -->    
        <center><a class="button color-sky" href="<?php echo get_term_link( $term->term_taxonomy_id, 'tour_style' ); ?>"><?php echo esc_html__( 'View All Tours', 'discovertravel' ) . ' (' . $term->count . ')'; ?></a></center>
        </div> <!-- .container -->
    </section>   
	<?php endif; ?>

	<section id="country-highlight">
        <div class="container">
        <header class="section-title">
            <h2><?php echo $meta['wpsp_cambodia_title'][0]; ?></h2>
        </header>
        <div class="row">
            <div class="col-md-6">
            	<?php echo $meta['wpsp_cambodia_desc'][0]; ?>
            	<!--<?php 
                    $destination_1 = $meta['wpsp_destination_1'][0];
                    $destination_2 = $meta['wpsp_destination_2'][0];
                    $destination_3 = $meta['wpsp_destination_3'][0];
                    $args = array(
            				'include'	=> wpsp_lang_object_ids( array($destination_1, $destination_2, $destination_3) , 'page' )
            			);
            		$pages = get_pages( $args ); 
                    $pages = array($destination_1, $destination_2, $destination_3); ?>
            	<?php if (!empty( $pages ) ) : ?>
            	<div class="row">
                <?php foreach ( $pages as $page ) : ?>
                    <div class="col-xs-4">
                    	<div class="post-thumb-effect effect-sp-2 box-shadow">
                            <?php	
								if ( has_post_thumbnail( $page->ID ) ) :
								    echo get_the_post_thumbnail( $page->ID, 'thumbnail' );
								else :
									echo '<img src="' . esc_url( ot_get_option( 'post-placeholder' ) ) . '">';
								endif; 
							?>
                            <div class="caption-wrap">
                                <div class="caption-inner">
                                    <h5><?php echo $page->post_title; ?></h5>
                                    <a href="<?php echo get_permalink( $page->ID ); ?>"><?php echo esc_html__( 'View Detail', 'discovertravel' ); ?></a>
                                </div>
                            </div>
                        </div>	
                    </div>
                <?php endforeach; ?>    
                </div>   
            	<?php endif; ?> -->
            </div> <!-- .col-lg-6 -->

            <div class="col-md-6 map">
                <a href="<?php echo $meta['wpsp_cambodia_map_link'][0]; ?>"><img src="<?php echo $meta['wpsp_cambodia_map'][0]; ?>"></a>
            </div> <!-- .col-lg-6 -->
        </div> <!-- .row -->    
        <center><a class="button color-green" href="<?php echo $meta['wpsp_cambodia_btn_link'][0]; ?>"><?php echo esc_html__( 'View All Destination', 'discovertravel' ); ?></a></center>
    	</div> <!-- .container --> 
    </section> <!-- #country-highlight -->

    <section id="custom-tour-design">
        <div class="container">
        <header class="section-title">
            <h2><?php echo $meta['wpsp_tour_design_title'][0]; ?></h2>
            <p class="description"><?php echo $meta['wpsp_tour_design_desc'][0]; ?></p>
        </header>
        <?php get_template_part( 'partials/tour-design' ); ?>
        </div>
    </section> <!-- #tour-design-form -->

	<section id="all-tours-style">
        <div class="container">
            <div class="row">
                 <header class="section-title col-md-3">
                    <h2><?php echo $meta['wpsp_style_title'][0]; ?></h2>
                    <p class="description"><?php echo $meta['wpsp_style_desc'][0]; ?></p>
                </header>
                <div class="col-md-9">
        		<?php $is_empty_tour = ( $meta['wpsp_tour_hide_empty'][0] == 'off' )  ? 1 : 0;
                    $args = array(
		            	'hide_empty' => $is_empty_tour,
		            );
        			$terms = get_terms( 'tour_style', $args ); ?>
                    <ul class="tour-style-icon-60 row">
                    <?php foreach ( $terms as $term ) : 
                    		echo '<li class="col-xs-6 col-md-3"><a href="' . get_term_link( $term ) . '" title="' . $term->name . '"><i class="sprite ' . get_option( 'tour_style_'.$term->term_id.'_icon', '' ) . '"></i>' . $term->name . '</a></li>';
                    	endforeach; ?>	
                    </ul>
                </div>
            </div> <!-- .row -->
        </div> <!-- .container -->
    </section> <!-- #all-tours-style -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
