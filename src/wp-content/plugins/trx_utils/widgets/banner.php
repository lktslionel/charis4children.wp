<?php
/**
 * Theme Widget: Banner
 */

// Theme init
if (!function_exists('charity_is_hope_widget_banner_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_widget_banner_theme_setup', 1 );
	function charity_is_hope_widget_banner_theme_setup() {

		// Register shortcodes in the shortcodes list
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_widget_banner_reg_shortcodes_vc');
	}
}

// Load widget
if (!function_exists('charity_is_hope_widget_banner_load')) {
	add_action( 'widgets_init', 'charity_is_hope_widget_banner_load' );
	function charity_is_hope_widget_banner_load() {
		register_widget( 'charity_is_hope_widget_banner' );
	}
}

// Widget Class
class charity_is_hope_widget_banner extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_banner', 'description' => esc_html__('Banner', 'trx_utils') );
		parent::__construct( 'charity_is_hope_widget_banner', esc_html__('Charity Is Hope - Banner', 'trx_utils'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {
		
		extract( $args );

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$banner_image = isset($instance['banner_image']) ? $instance['banner_image'] : '';
		$banner_link = isset($instance['banner_link']) ? $instance['banner_link'] : '';
		$banner_code = isset($instance['banner_code']) ? $instance['banner_code'] : '';

		// Before widget (defined by themes)
		charity_is_hope_show_layout($before_widget);

		// Display the widget title if one was input (before and after defined by themes)
		if ($title) charity_is_hope_show_layout($title, $before_title, $after_title);
		?>			
		<div class="widget_banner_inner">
			<?php
			if ($banner_image!='') {
				if ((int) $banner_image > 0) {
					$attach = wp_get_attachment_image_src( $banner_image, 'full' );
					if (isset($attach[0]) && $attach[0]!='')
						$banner_image = $attach[0];
				}
				$attr = charity_is_hope_getimagesize($banner_image);
				echo (!empty($banner_link) ? '<a href="' . esc_url($banner_link) . '"' : '<span') . ' class="image_wrap"><img src="' . esc_url($banner_image) . '" alt="' . esc_attr($title) . '"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>' . (!empty($banner_link) ? '</a>': '</span>');
			}
			if ($banner_code!='') {
				echo force_balance_tags(charity_is_hope_substitute_all($banner_code));
			}
			?>
		</div>
		<?php
		
		// After widget (defined by themes)
		charity_is_hope_show_layout($after_widget);
	}

	// Update the widget settings.
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['banner_image'] = strip_tags( $new_instance['banner_image'] );
		$instance['banner_link'] = strip_tags( $new_instance['banner_link'] );
		$instance['banner_code'] = $new_instance['banner_code'];
		return $instance;
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'banner_image' => '',
			'banner_link' => '',
			'banner_code' => ''
			)
		);
		$title = $instance['title'];
		$banner_image = $instance['banner_image'];
		$banner_link = $instance['banner_link'];
		$banner_code = $instance['banner_code'];
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'trx_utils'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($title); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'banner_image' )); ?>"><?php echo wp_kses_data( __('Image source URL:<br />(leave empty if you paste banner code)', 'trx_utils') ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'banner_image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_image' )); ?>" value="<?php echo esc_attr($banner_image); ?>"  class="widgets_param_fullwidth widgets_param_img_selector" />
            <?php
            charity_is_hope_show_layout(charity_is_hope_show_custom_field($this->get_field_id( 'banner_media' ), array('type'=>'mediamanager', 'media_field_id'=>$this->get_field_id( 'banner_image' )), null));
			if ($banner_image) {
			?>
	            <br /><br /><img src="<?php echo esc_url($banner_image); ?>"  class="widgets_param_maxwidth" alt="" />
			<?php
			}
			?>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'banner_link' )); ?>"><?php echo wp_kses_data( __('Image link URL:<br />(leave empty if you paste banner code)', 'trx_utils') ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'banner_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_link' )); ?>" value="<?php echo esc_attr($banner_link); ?>"  class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'banner_code' )); ?>"><?php esc_html_e('or paste Banner Widget HTML Code:', 'trx_utils'); ?></label>
			<textarea id="<?php echo esc_attr($this->get_field_id( 'banner_code' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_code' )); ?>" rows="5"  class="widgets_param_fullwidth"><?php echo htmlspecialchars($banner_code); ?></textarea>
		</p>
	<?php
	}
}



// trx_widget_banner
//-------------------------------------------------------------
/*
[trx_widget_banner id="unique_id" title="Widget title" fullwidth="0|1" image="image_url" link="Image_link_url" code="html & js code"]
*/
if ( !function_exists( 'charity_is_hope_sc_widget_banner' ) ) {
	function charity_is_hope_sc_widget_banner($atts, $content=null){	
		$atts = charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			"image" => "",
			"link" => "",
			"code" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts));
		extract($atts);
		$type = 'charity_is_hope_widget_banner';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$atts['banner_image'] = $image;
			$atts['banner_link'] = $link;
			$atts['banner_code'] = $code;
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_banner' 
								. (charity_is_hope_exists_visual_composer() ? ' vc_widget_banner wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
						. '">';
			ob_start();
			the_widget( $type, $atts, charity_is_hope_prepare_widgets_args(charity_is_hope_storage_get('widgets_args'), $id ? $id.'_widget' : 'widget_banner', 'widget_banner') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_widget_banner', $atts, $content);
	}
	charity_is_hope_require_shortcode("trx_widget_banner", "charity_is_hope_sc_widget_banner");
}


// Add [trx_widget_banner] in the VC shortcodes list
if (!function_exists('charity_is_hope_widget_banner_reg_shortcodes_vc')) {
	//add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_widget_banner_reg_shortcodes_vc');
	function charity_is_hope_widget_banner_reg_shortcodes_vc() {
		
		vc_map( array(
				"base" => "trx_widget_banner",
				"name" => esc_html__("Widget Banner", 'trx_utils'),
				"description" => wp_kses_data( __("Insert widget with banner or any HTML and/or Javascript code", 'trx_utils') ),
				"category" => esc_html__('Content', 'trx_utils'),
				"icon" => 'icon_trx_widget_banner',
				"class" => "trx_widget_banner",
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
						"param_name" => "image",
						"heading" => esc_html__("Image", 'trx_utils'),
						"description" => wp_kses_data( __("Select or upload image or write URL from other site for the banner (leave empty if you paste banner code)", 'trx_utils') ),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Banner's link", 'trx_utils'),
						"description" => wp_kses_data( __("Link URL for the banner (leave empty if you paste banner code)", 'trx_utils') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "code",
						"heading" => esc_html__("or paste Banner Widget HTML Code", 'trx_utils'),
						"description" => wp_kses_data( __("Widget's HTML and/or JS code", 'trx_utils') ),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					charity_is_hope_get_vc_param('id'),
					charity_is_hope_get_vc_param('class'),
					charity_is_hope_get_vc_param('css')
				)
			) );
			
		class WPBakeryShortCode_Trx_Widget_Banner extends WPBakeryShortCode {}

	}
}
?>