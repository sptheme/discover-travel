<?php
/**
 * Sub navigation Widget
 *
 * List child page by parent page ID
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 *
 * @package Discover Travel
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPSP_Sub_Nav_Widget' ) ) :
class WPSP_Sub_Nav_Widget extends WP_Widget {

	/**
     * Register widget with WordPress.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $id = 'wpsp-sub-nav-widget';
        $name = WPSP_THEME_NAME . ' - '. __( 'List sub page', 'wpsp_admin' );
        $widget_ops = array(
                'classname'         => 'widget-sub-nav widget_nav_menu ',
                'description'   => __( 'A widget to list all children page name by parent page', 'wpsp_admin' )
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

        $title = apply_filters('widget_title', $instance['title'] );
        $parent_page = icl_object_id($instance['parent_page'], true);
        $depth = $instance['depth'];
        $order_by = $instance['order_by'];
        $sort_by = $instance['sort_by'];
        
        echo $before_widget;

        if ( $title )
            echo $before_title . $title . $after_title;

        if ( $depth ) {
            $args = array(
                    'sort_order' => $order_by,
                    'sort_column' =>  $sort_by,
                    'child_of' => $parent_page,
                    'parent' => $parent_page,
                    'hierarchical' => 0
                );    
        } else {
            $args = array( 'child_of' => $parent_page );
        }
        $child_pages = get_pages( $args );
        
        if ( $child_pages ) {
            $body_widget = '<ul>' . "\n";
            foreach ( $child_pages as $page ) {
                $body_widget .= '<li><a href="' . get_page_link( $page->ID ) . '">' . $page->post_title . '</a></li>';
            }

            $body_widget .= '</ul>' . "\n";
        }

        echo $body_widget;

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
 
        //Strip tags from title and name to remove HTML
        $instance['title'] = strip_tags( $new_instance['title'] );  
        $instance['parent_page'] = (int) $new_instance['parent_page'];
        $instance['depth'] = $new_instance['depth'];
        $instance['order_by'] = $new_instance['order_by'];
        $instance['sort_by'] = $new_instance['sort_by'];
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
            'title' => __('All Destinations', 'wpsp_admin'),
            'parent_page' => 0,
            'depth' => 0,
            'order_by' => 'asc',
            'sort_by' => 'post_title'
            );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpsp_admin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('parent_page'); ?>">
            <strong><?php _e('Select parent page:', 'wpsp_admin'); ?></strong><br>
            </label>
            <?php $args = array(
                        'id' => $this->get_field_id('parent_page'),
                        'name' => $this->get_field_name('parent_page'),
                        'selected' => (int)$instance['parent_page']
                    );
                wp_dropdown_pages( $args ); ?>
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('depth'); ?>" name="<?php echo $this->get_field_name('depth'); ?>" type="checkbox" value="1" <?php if ($instance['depth']) echo 'checked="checked"'; ?>/>
            <label for="<?php echo $this->get_field_id('depth'); ?>"><?php _e('Displays top-level Pages only?', 'wpsp_admin'); ?></label>
        </p> 
        <p>
            <label for="<?php echo $this->get_field_id('sort_by'); ?>"><?php _e('Sort by', 'wpsp_admin'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('sort_by'); ?>" name="<?php echo $this->get_field_name('sort_by'); ?>">
                <option value="post_title" <?php if ( $instance['sort_by'] == 'post_title' ) echo 'selected'; ?>>Post title</option>
                <option value="post_date" <?php if ( $instance['sort_by'] == 'post_date' ) echo 'selected'; ?>>Post date</option>
                <option value="menu_order" <?php if ( $instance['sort_by'] == 'menu_order' ) echo 'selected'; ?>>Menu order</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('order_by'); ?>"><?php _e('Order by', 'wpsp_admin'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
                <option value="asc" <?php if ( $instance['order_by'] == 'asc' ) echo 'selected'; ?>>A-Z</option>
                <option value="desc" <?php if ( $instance['order_by'] == 'desc' ) echo 'selected'; ?>>Z-A</option>
            </select>
        </p>   
<?php    
    }    
}
endif;

// Register widget with widgets init hook
if ( ! function_exists( 'register_wpsp_sub_nav_widget' ) ) :
function register_wpsp_sub_nav_widget() {
    register_widget( 'WPSP_Sub_Nav_Widget' );
}
endif;
add_action( 'widgets_init', 'register_wpsp_sub_nav_widget' );