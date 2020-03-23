<?php
/**
 * Theme Widget: Advanced Calendar
 */

// Theme init
if (!function_exists('charity_is_hope_widget_calendar_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_widget_calendar_theme_setup', 1 );
	function charity_is_hope_widget_calendar_theme_setup() {

		// Register shortcodes in the shortcodes list
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_widget_calendar_reg_shortcodes_vc');
	}
}

// Load widget
if (!function_exists('charity_is_hope_widget_calendar_load')) {
	add_action( 'widgets_init', 'charity_is_hope_widget_calendar_load' );
	function charity_is_hope_widget_calendar_load() {
		register_widget('charity_is_hope_widget_calendar');
	}
}

// Widget Class
class charity_is_hope_widget_calendar extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_calendar', 'description' => esc_html__('Calendar for posts and/or Events', 'trx_utils'));
		parent::__construct( 'charity_is_hope_widget_calendar', esc_html__('Charity Is Hope - Advanced Calendar', 'trx_utils'), $widget_ops );
	}

	// Show widget
	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');
		$post_type = isset($instance['post_type']) ? $instance['post_type'] : 'post';
		
		$output = charity_is_hope_get_calendar(false, 0, 0, array('post_type'=>$post_type));

		if (!empty($output)) {
	
			// Before widget (defined by themes)
			charity_is_hope_show_layout($before_widget);
			
			// Display the widget title if one was input (before and after defined by themes)
			if ($title) charity_is_hope_show_layout($title, $before_title, $after_title);
    
			charity_is_hope_show_layout($output);
			
			// After widget (defined by themes)
			charity_is_hope_show_layout($after_widget);
		}
	}

	// Update the widget settings.
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_type'] = isset($new_instance['post_type']) ? join(',', $new_instance['post_type']) : 'post';
		return $instance;
	}

	// Displays the widget settings controls on the widget panel.
	function form($instance) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'post_type'=>'post'
			)
		);
		$title = $instance['title'];
		$post_type = $instance['post_type'];
		$posts_types = charity_is_hope_get_list_posts_types(false);
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Widget title:', 'trx_utils'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>"  class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>_1"><?php esc_html_e('Post type:', 'trx_utils'); ?></label><br>
			<?php
				$i=0;
				if (is_array($posts_types) && count($posts_types) > 0) {
					foreach ($posts_types as $type=>$type_title) {
						$i++;
						echo '<span class="post_type widgets_param_post_type" ><input type="checkbox" id="'.esc_attr($this->get_field_id('post_type').'_'.intval($i)).'" name="'.esc_attr($this->get_field_name('post_type')).'[]" value="'.esc_attr($type).'"'.(charity_is_hope_strpos($post_type, $type)!==false ? ' checked="checked"' : '').'><label for="'.esc_attr($this->get_field_id('post_type').'_'.intval($i)).'">'.($type_title).'</label></span>';
					}
				}
			?>
			</select>
			<br><span class="description"><?php esc_html_e('Attention! If you check custom post types, please check also settings in the correspond plugins and enable display this posts in the blog!', 'trx_utils'); ?></span>
		</p>

	<?php
	}
}



// trx_widget_calendar
//-------------------------------------------------------------
/*
[trx_widget_calendar id="unique_id" title="Widget title" weekdays="short|initial"]
*/
if ( !function_exists( 'charity_is_hope_sc_widget_calendar' ) ) {
	function charity_is_hope_sc_widget_calendar($atts, $content=null){	
		$atts = charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			"weekdays" => "short",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts));
		if ($atts['weekdays']=='') $atts['weekdays'] = 'short';
		extract($atts);
		$type = 'charity_is_hope_widget_calendar';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_calendar' 
								. (charity_is_hope_exists_visual_composer() ? ' vc_widget_calendar wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
						. '">';
			ob_start();
			the_widget( $type, $atts, charity_is_hope_prepare_widgets_args(charity_is_hope_storage_get('widgets_args'), $id ? $id.'_widget' : 'widget_calendar', 'widget_calendar') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_widget_calendar', $atts, $content);
	}
	charity_is_hope_require_shortcode("trx_widget_calendar", "charity_is_hope_sc_widget_calendar");
}


// Add [trx_widget_calendar] in the VC shortcodes list
if (!function_exists('charity_is_hope_widget_calendar_reg_shortcodes_vc')) {
	//add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_widget_calendar_reg_shortcodes_vc');
	function charity_is_hope_widget_calendar_reg_shortcodes_vc() {
		
		vc_map( array(
				"base" => "trx_widget_calendar",
				"name" => esc_html__("Widget Calendar", 'trx_utils'),
				"description" => wp_kses_data( __("Insert standard WP Calendar, but allow user select week day's captions", 'trx_utils') ),
				"category" => esc_html__('Content', 'trx_utils'),
				"icon" => 'icon_trx_widget_calendar',
				"class" => "trx_widget_calendar",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Widget title", 'trx_utils'),
						"description" => wp_kses_data( __("Title of the widget", 'trx_utils') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "weekdays",
						"heading" => esc_html__("Week days", 'trx_utils'),
						"description" => wp_kses_data( __("Show captions for the week days as three letters (Sun, Mon, etc.) or as one initial letter (S, M, etc.)", 'trx_utils') ),
						"class" => "",
						"value" => array(esc_html__("Initial letter", 'trx_utils') => "initial" ),
						"type" => "checkbox"
					),
					charity_is_hope_get_vc_param('id'),
					charity_is_hope_get_vc_param('class'),
					charity_is_hope_get_vc_param('css')
				)
			) );
			
		class WPBakeryShortCode_Trx_Widget_Calendar extends WPBakeryShortCode {}

	}
}
?>