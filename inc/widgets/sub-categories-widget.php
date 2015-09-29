<?php
/**
 * Sub Categories Widget
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 * @package     Klahan9
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPSP_Sub_Categories_Widget' ) ) {
    class WPSP_Sub_Categories_Widget extends WP_Widget {
	
    /**
     * Register widget with WordPress.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $id = 'wpsp-sub-categories-widget';
        $name = WPSP_THEME_NAME . ' - '. __( 'Sub Categories', 'wpsp' );
        $widget_ops = array(
                'classname'         => 'widget-sub-categories',
                'description'   => __( 'Lists the sub-categories for a given category', 'wpsp' )
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
        $use_cat_title      = empty($instance['use_cat_title']) ? 0 : $instance['use_cat_title'];
        $hide_empty_cats    = empty($instance['hide_empty_cats']) ? 0 : $instance['hide_empty_cats'];
        $show_post_count    = empty($instance['show_post_count']) ? 0 : $instance['show_post_count'];
        $title_link         = empty($instance['title_link']) ? 0 : $instance['title_link'];

        if ($use_cat_title) {
            $title = apply_filters('widget_title', get_cat_name($category_id), $instance, $this->id_base);
        } else {
            $title = apply_filters('widget_title', empty($instance['title'] ) ? __('Sub Categories', 'wpsp') : $instance['title'], $instance, $this->id_base);
        }

        $no_sub_text = '<p>'.__('No sub-categories', 'wpsp').'</p>';

        $subs = wp_list_categories(array('child_of' => $category_id, 'hide_empty' => $hide_empty_cats, 'show_count' => $show_post_count, 'title_li' => null, 'show_option_none' => '', 'echo' => 0));

        echo $before_widget;

            if ($title_link) {
                echo $before_title.'<a href="'.get_category_link($category_id).'">'.$title.'</a>'.$after_title;
            } else {
                echo $before_title.$title.$after_title;
            }

            if (!empty($subs)) {
                echo '<ul>'.$subs.'</ul>';
            } else {
                echo $no_sub_text;
            }

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

        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['category_id'] = (int) $new_instance['category_id'];
        $instance['use_cat_title'] = (int) $new_instance['use_cat_title'];
        $instance['hide_empty_cats'] = (int) $new_instance['hide_empty_cats'];
        $instance['show_post_count'] = (int) $new_instance['show_post_count'];
        $instance['title_link'] = (int) $new_instance['title_link'];

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

        // Parse arguments
        $instance = wp_parse_args((array) $instance, array(
            'title' => __('Sub Categories', 'wpsp'), 
            'category_id' => 1, 
            'use_cat_title' => 0, 
            'hide_empty_cats' => 0, 
            'show_post_count' => 1, 
            'title_link' => 0
        ) ); ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpsp'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']) ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('category_id'); ?>"><?php _e('Parent category:', 'wpsp'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('category_id'); ?>" name="<?php echo $this->get_field_name('category_id'); ?>">
                <?php
                    $categories = get_categories(array('hide_empty' => 0));
                    foreach ($categories as $cat) {
                        $selected = $cat->cat_ID == $instance['category_id'] ? ' selected="selected"' : '';
                        echo '<option'.$selected.' value="'.$cat->cat_ID.'">'.$cat->cat_name.'</option>';
                    }
                ?>
            </select>
        </p>
        </p>
            <input id="<?php echo $this->get_field_id('use_cat_title'); ?>" name="<?php echo $this->get_field_name('use_cat_title'); ?>" type="checkbox" value="1" <?php if ($instance['use_cat_title']) echo 'checked="checked"'; ?>/>
            <label for="<?php echo $this->get_field_id('use_cat_title'); ?>"><?php _e('Title is parent category', 'wpsp'); ?></label>
            <br>
            <input id="<?php echo $this->get_field_id('show_post_count'); ?>" name="<?php echo $this->get_field_name('show_post_count'); ?>" type="checkbox" value="1" <?php if ($instance['show_post_count']) echo 'checked="checked"'; ?>/>
            <label for="<?php echo $this->get_field_id('show_post_count'); ?>"><?php _e('Show post counts', 'wpsp'); ?></label>
            <br>
            <input id="<?php echo $this->get_field_id('hide_empty_cats'); ?>" name="<?php echo $this->get_field_name('hide_empty_cats'); ?>" type="checkbox" value="1" <?php if ($instance['hide_empty_cats']) echo 'checked="checked"'; ?>/>
            <label for="<?php echo $this->get_field_id('hide_empty_cats'); ?>"><?php _e('Hide empty sub-categories', 'wpsp'); ?></label>
            <br>
            <input id="<?php echo $this->get_field_id('title_link'); ?>" name="<?php echo $this->get_field_name('title_link'); ?>" type="checkbox" value="1" <?php if ($instance['title_link']) echo 'checked="checked"'; ?>/>
            <label for="<?php echo $this->get_field_id('title_link'); ?>"><?php _e('Add parent link to title', 'wpsp'); ?></label>
        </p>
        
    <?php }
    }
}

// Register widget with widgets init hook
if ( ! function_exists( 'register_wpsp_sub_categories_widget' ) ) {
    function register_wpsp_sub_categories_widget() {
        register_widget( 'WPSP_Sub_Categories_Widget' );
    }
}
add_action( 'widgets_init', 'register_wpsp_sub_categories_widget' );