<?php
/**
 * Theme Widget: Give
 */

// Theme init
if (!function_exists('charity_is_hope_give_theme_setup')) {
    add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_give_theme_setup', 1 );
    function charity_is_hope_give_theme_setup() {

        // Register shortcodes in the shortcodes list
        if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer()) {
            add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_give_reg_shortcodes_vc');
        }

    }
}

// Widgets
//------------------------------------------------------------------------

// Load widget
if (!function_exists('charity_is_hope_widget_give_goal_load')) {
    add_action( 'widgets_init', 'charity_is_hope_widget_give_goal_load' );
    function charity_is_hope_widget_give_goal_load() {
        if (!charity_is_hope_exists_give()) { return; }

        register_widget( 'charity_is_hope_widget_give_goal' );
        register_widget( 'charity_is_hope_widget_give_donation_history' );
    }
}

// Widget Class

/**
 * Widget Give goal
 * Class charity_is_hope_widget_give_goal
 */
class charity_is_hope_widget_give_goal extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_give_goal', 'description' => esc_html__('Give goal', 'trx_utils'));
        parent::__construct('charity_is_hope_widget_give_goal', esc_html__('Charity Is Hope - Give goal', 'trx_utils'), $widget_ops);
    }

    // Show widget
    function widget($args, $instance) {

        extract($args);

        $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
        $goal_description = isset($instance['goal_description']) ? $instance['goal_description'] : '';

        // Before widget (defined by themes)
        charity_is_hope_show_layout($before_widget);

        // Display the widget title if one was input (before and after defined by themes)
        if ($title) charity_is_hope_show_layout($title, $before_title, $after_title);

        if ($goal_description) echo '<p>' . esc_attr($goal_description) . '</p>';

        if (function_exists('give_show_goal_progress')) give_show_goal_progress(get_the_ID(), array());

        // After widget (defined by themes)
        charity_is_hope_show_layout($after_widget);
    }

    // Update the widget settings.
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['goal_description'] = strip_tags($new_instance['goal_description']);
        return $instance;
    }

    // Displays the widget settings controls on the widget panel.
    function form($instance) {

        // Set up some default widget settings
        $instance = wp_parse_args((array)$instance, array(
                'title' => '',
                'goal_description' => ''
            )
        );
        $title = $instance['title'];
        $goal_description = $instance['goal_description'];
        ?>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'trx_utils'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   value="<?php echo esc_attr($title); ?>" class="widgets_param_fullwidth"/>
        </p>

        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('goal_description')); ?>"><?php esc_html_e('Goal description:', 'trx_utils'); ?></label>
            <textarea id="<?php echo esc_attr($this->get_field_id('goal_description')); ?>"
                      name="<?php echo esc_attr($this->get_field_name('goal_description')); ?>" rows="5"
                      class="widgets_param_fullwidth"><?php echo esc_attr($goal_description); ?></textarea>
        </p>
        <?php
    }
}


/**
 * Widget Give donation history
 * Class charity_is_hope_widget_give_donation_history
 */
class charity_is_hope_widget_give_donation_history extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_give_donation_history', 'description' => esc_html__('Give donation history', 'trx_utils'));
        parent::__construct('charity_is_hope_widget_give_donation_history', esc_html__('Charity Is Hope - Give donation history', 'trx_utils'), $widget_ops);
    }

    // Show widget
    function widget($args, $instance) {

        extract($args);

        $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
        $goal_description = isset($instance['goal_description']) ? $instance['goal_description'] : '';

        // Before widget (defined by themes)
        charity_is_hope_show_layout($before_widget);

        // Display the widget title if one was input (before and after defined by themes)
        if ($title) charity_is_hope_show_layout($title, $before_title, $after_title);

        if ($goal_description) echo '<p>' . esc_attr($goal_description) . '</p>';

        if (shortcode_exists('donation_history')) echo do_shortcode('[donation_history]');

        // After widget (defined by themes)
        charity_is_hope_show_layout($after_widget);
    }

    // Update the widget settings.
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['goal_description'] = strip_tags($new_instance['goal_description']);
        return $instance;
    }

    // Displays the widget settings controls on the widget panel.
    function form($instance) {

        // Set up some default widget settings
        $instance = wp_parse_args((array)$instance, array(
                'title' => '',
                'goal_description' => ''
            )
        );
        $title = $instance['title'];
        $goal_description = $instance['goal_description'];
        ?>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'trx_utils'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   value="<?php echo esc_attr($title); ?>" class="widgets_param_fullwidth"/>
        </p>

        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('goal_description')); ?>"><?php esc_html_e('Goal description:', 'trx_utils'); ?></label>
            <textarea id="<?php echo esc_attr($this->get_field_id('goal_description')); ?>"
                      name="<?php echo esc_attr($this->get_field_name('goal_description')); ?>" rows="5"
                      class="widgets_param_fullwidth"><?php echo esc_attr($goal_description); ?></textarea>
        </p>
        <?php
    }
}


