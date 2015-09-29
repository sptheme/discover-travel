<?php
/**
 * Post Category Widget
 *
 * List post thumbnail formath by category
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 * @package     Klahan9
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPSP_Post_Category_Widget' ) ) {
    class WPSP_Post_Category_Widget extends WP_Widget {
	
    /**
     * Register widget with WordPress.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $id = 'wpsp-post-category-widget';
        $name = WPSP_THEME_NAME . ' - '. __( 'Post by category', 'wpsp' );
        $widget_ops = array(
                'classname'         => 'widget-post-category-wpsp widget-post-category',
                'description'   => __( 'A widget to display the most recent posts thumbnail by post format from single category', 'wpsp' )
            );
        $control_ops = array();
        parent::__construct( $id, $name, $widget_ops, $control_ops );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     * @since 1.0.0
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    function widget( $args, $instance )
    {
        // Extract args
        extract( $args, EXTR_SKIP );

        $category_id        = empty($instance['category_id']) ? 1 : $instance['category_id'];
        $post_format        = empty($instance['post_format']) ? 'post-format-standard' : $instance['post_format'];
        $post_num           = empty($instance['post_num']) ? 5 : $instance['post_num'];
        $use_cat_title      = empty($instance['use_cat_title']) ? 0 : $instance['use_cat_title'];
        $title_link         = empty($instance['title_link']) ? 0 : $instance['title_link'];

        if ($use_cat_title) {
            $title = apply_filters('widget_title', get_cat_name($category_id), $instance, $this->id_base);
        } else {
            $title = apply_filters('widget_title', empty($instance['title'] ) ? __('Recent Posts in Category', 'wpsp') : $instance['title'], $instance, $this->id_base);
        }


        echo $before_widget;

            if ($title_link) {
                echo $before_title.'<a href="'. esc_url( get_category_link($category_id) ). '">'.$title.'</a>'.$after_title;
            } else {
                echo $before_title.$title.$after_title;
            }

            global $post;
            $args = array();
            if ( $post_format == 'post-format-standard' ) {
                $args = array(
                            'tax_query' => array(
                                array(
                                        'taxonomy' => 'category',
                                        'field'    => 'term_id',
                                        'terms'    => array( $category_id ),
                                )
                            ) 
                        );
            }
        
            $defaults = array(
                'post_type' => 'post',
                'posts_per_page' => (int) $post_num,
                'post__not_in' => array($post->ID),
                'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'post_format',
                            'field'    => 'slug',
                            'terms'    => array( $post_format ),
                        ),
                        array(
                                'taxonomy' => 'category',
                                'field'    => 'term_id',
                                'terms'    => array( $category_id ),
                        )
                    )    
            );
            $args = wp_parse_args( $args, $defaults );
            extract( $args );

            $custom_query = new WP_Query( $args );
            
            if( $custom_query->have_posts() ) {
                while ( $custom_query->have_posts() ) : $custom_query->the_post();
                    switch ( $post_format ) {
                        case 'post-format-standard':
                        get_template_part( 'partials/content', 'blog' );
                        break;

                        case 'post-format-video': // post format video
                        get_template_part( 'partials/content', 'tv' );
                        break;

                        case 'post-format-audio': // post format radio
                        get_template_part( 'partials/content', 'radio' );
                        break;
                    }
                endwhile; wp_reset_postdata();
            }

        echo $after_widget;
        
        return $instance;
    }  

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     * @since 1.0.0
     *
     * @param array $instance Previously saved values from database.
     */
    function form( $instance ) {

        // Some default values for the widget options
        $default = array(
            'title' => '', 
            'category_id' => 1, 
            'post_format' => 'post-format-standard',
            'post_num' => 5, 
            'use_cat_title' => 0, 
            'title_link' => 0
        );

        // any options not set get the default
        $instance = wp_parse_args( $instance, $defaults );

        // widget admin form begins
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpsp'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('category_id'); ?>"><?php _e('Parent category:', 'wpsp'); ?></label>
            <?php $args = array(
                'orderby'            => 'ID', 
                'order'              => 'ASC',
                'show_count'         => 1,
                'hide_empty'         => 0,
                'hide_if_empty'      => false,
                'echo'               => 1,
                'selected'           => $instance['category_id'],
                'hierarchical'       => 1, 
                'name'               => $this->get_field_name( 'category_id' ),
                'id'                 => $this->get_field_id( 'category_id' ),
                'class'              => 'widefat',
                'taxonomy'           => 'category',
              );

              wp_dropdown_categories( $args ); ?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('post_format'); ?>"><?php _e('Parent category:', 'wpsp'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('post_format'); ?>" name="<?php echo $this->get_field_name('post_format'); ?>">
                <option value="post-format-standard" <?php selected( $instance['post_format'], 'post-format-standard' ); ?>>Standard</option>
                <option value="post-format-video" <?php selected( $instance['post_format'], 'post-format-video' ); ?>>Video</option>
                <option value="post-format-audio" <?php selected( $instance['post_format'], 'post-format-audio' ); ?>>Audio</option>
            </select>
        </p>
        </p>
            <input id="<?php echo $this->get_field_id('use_cat_title'); ?>" name="<?php echo $this->get_field_name('use_cat_title'); ?>" type="checkbox" value="1" <?php if ($instance['use_cat_title']) echo 'checked="checked"'; ?>/>
            <label for="<?php echo $this->get_field_id('use_cat_title'); ?>"><?php _e('Title is parent category', 'wpsp'); ?></label>
            <br>
            <input id="<?php echo $this->get_field_id('title_link'); ?>" name="<?php echo $this->get_field_name('title_link'); ?>" type="checkbox" value="1" <?php if ($instance['title_link']) echo 'checked="checked"'; ?>/>
            <label for="<?php echo $this->get_field_id('title_link'); ?>"><?php _e('Add parent link to title', 'wpsp'); ?></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('post_num'); ?>"><?php _e('Post number:', 'wpsp'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('post_num'); ?>" name="<?php echo $this->get_field_name('post_num'); ?>" type="number" min="1" step="1" value="<?php echo esc_attr($instance['post_num']) ?>" />
        </p>
        
    <?php }
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @since 1.0.0
     *
     * @see WP_Widget::form()
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['category_id'] = (int) $new_instance['category_id'];
        $instance['post_format'] = (int) $new_instance['post_format'];
        $instance['post_num'] = (int) $new_instance['post_num'];
        $instance['use_cat_title'] = sanitize_text_field( $new_instance['use_cat_title'] );
        $instance['title_link'] = (int) $new_instance['title_link'];

        return $instance;
    }
             
}

// Register widget with widgets init hook
if ( ! function_exists( 'register_wpsp_post_category_widget' ) ) {
    function register_wpsp_post_category_widget() {
        register_widget( 'WPSP_Post_Category_Widget' );
    }
}
add_action( 'widgets_init', 'register_wpsp_post_category_widget' );