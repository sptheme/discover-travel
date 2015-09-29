<?php
/**
 * Quick Contact Widget
 *
 * Short contact information
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 *
 * @package Discover Travel
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPSP_Quick_Contact_Widget' ) ) :
class WPSP_Quick_Contact_Widget extends WP_Widget {

	/**
     * Register widget with WordPress.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $id = 'wpsp-quick-contact-widget';
        $name = WPSP_THEME_NAME . ' - '. __( 'Quick contact', 'wpsp_admin' );
        $widget_ops = array(
                'classname'         => 'widget-quick-contact',
                'description'   => __( 'A widget to display short contact information.', 'wpsp_admin' )
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
        // Extract args
        extract( $args, EXTR_SKIP );

        $label            = $instance['label'];
        $hotline          = $instance['hotline'];
        $open_hour        = $instance['open_hour'];
        $email            = $instance['email'];

        echo $before_widget;

        // We're good to go, let's build the menu
        $out = '<ul class="quick-contact">';
        $out .= '<li class="hotline">' . $label . '<span>' . $hotline . '</span></li>';
        $out .= '<li class="open-hour">' . $open_hour . '</li>';
        $out .= '<li class="email"><a href="mailto:' . antispambot( $email ) . '">' . antispambot( $email ) . '</a></li>';
        $out .= '</ul>';

        echo $out;

        echo $after_widget;
        
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
 
        $instance['label'] = strip_tags( $new_instance['label'] );  
        $instance['hotline'] = strip_tags( $new_instance['hotline'] );
        $instance['open_hour'] = strip_tags( $new_instance['open_hour'] );
        $instance['email'] = strip_tags( $new_instance['email'] );

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
        $defaults = array( 
            'label' => __('Questions? ', 'wpsp_admin'), 
            'hotline' => '+855 12 608 108', 
            'open_hour' => 'Mon - Sat 9:00 AM to 7:00 PM (Asia Pacific)',
            'email' => 'info@mydomain.com' );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <p>
            <label for="<?php echo $this->get_field_id('label'); ?>"><?php _e('Title:', 'wpsp_admin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('label'); ?>" name="<?php echo $this->get_field_name('label'); ?>" type="text" value="<?php echo esc_attr($instance['label']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('hotline'); ?>"><?php _e('Hotline number:', 'wpsp_admin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('hotline'); ?>" name="<?php echo $this->get_field_name('hotline'); ?>" type="text" value="<?php echo esc_attr($instance['hotline']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('open_hour'); ?>"><?php _e('Open hour:', 'wpsp_admin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('open_hour'); ?>" name="<?php echo $this->get_field_name('open_hour'); ?>" type="text" value="<?php echo esc_attr($instance['open_hour']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('E-mail:', 'wpsp_admin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo esc_attr($instance['email']) ?>" />
        </p>
<?php    
    }    
}
endif;

// Register widget with widgets init hook
if ( ! function_exists( 'register_wpsp_quick_contact_widget' ) ) :
function register_wpsp_quick_contact_widget() {
    register_widget( 'WPSP_Quick_Contact_Widget' );
}
endif;
add_action( 'widgets_init', 'register_wpsp_quick_contact_widget' );