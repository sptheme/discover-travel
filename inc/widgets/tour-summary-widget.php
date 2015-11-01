<?php
/**
 * Tour Summary Widget
 *
 * Highlight of tour itinerary
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 *
 * @package Discover Travel
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPSP_Tour_Summary_Widget' ) ) :
class WPSP_Tour_Summary_Widget extends WP_Widget {

	/**
     * Register widget with WordPress.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $id = 'wpsp-tour-summary-widget';
        $name = WPSP_THEME_NAME . ' - '. __( 'Tour SUMMARY', 'wpsp_admin' );
        $widget_ops = array(
                'classname'         => 'widget-tour-summary',
                'description'   => __( 'A widget to Highlight of tour itinerary, work only in tour detail page', 'wpsp_admin' )
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
    function widget( $args, $instance ) {
        global $post;

        // Extract args
        extract( $args, EXTR_SKIP );

        $title = apply_filters('widget_title', $instance['title'] );
        $highlight = get_post_meta( $post->ID, 'wpsp_highlight', true );

        if ( is_singular( 'cp_tour' ) && !empty( $highlight ) ) {

            echo $before_widget;

            if ( $title )
                echo $before_title . $title . $after_title;

            $body_widget = '<ul>' . "\n";
            $day_itinerary = explode( ',', $highlight );
            foreach ( $day_itinerary as $day ) :
                $body_widget .= '<li>' . $day .  '</li>' . "\n";
            endforeach;
            $body_widget .= '</ul>' . "\n";

            echo $body_widget;

            echo $after_widget;
        } // is single tour post
        
        return $instance;
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
 
        //Strip tags from title and name to remove HTML
        $instance['title'] = strip_tags( $new_instance['title'] );  
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
        //Set up some default widget settings.
        $defaults = array( 'title' => __('Tour SUMMARY', 'wpsp_admin') );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpsp_admin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']) ?>" />
        </p>
<?php    
    }    
}
endif;

// Register widget with widgets init hook
if ( ! function_exists( 'register_wpsp_tour_summary_widget' ) ) :
function register_wpsp_tour_summary_widget() {
    register_widget( 'WPSP_Tour_Summary_Widget' );
}
endif;
add_action( 'widgets_init', 'register_wpsp_tour_summary_widget' );