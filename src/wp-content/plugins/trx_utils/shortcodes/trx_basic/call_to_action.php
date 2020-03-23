<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('charity_is_hope_sc_call_to_action_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_sc_call_to_action_theme_setup' );
	function charity_is_hope_sc_call_to_action_theme_setup() {
		add_action('charity_is_hope_action_shortcodes_list', 		'charity_is_hope_sc_call_to_action_reg_shortcodes');
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_sc_call_to_action_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_call_to_action id="unique_id" style="1|2" align="left|center|right"]
	[inner shortcodes]
[/trx_call_to_action]
*/

if (!function_exists('charity_is_hope_sc_call_to_action')) {	
	function charity_is_hope_sc_call_to_action($atts, $content=null){
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "1",
			"align" => "center",
			"custom" => "no",
			"accent" => "no",
			"image" => "",
			"video" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_caption" => esc_html__('Learn more', 'trx_utils'),
			"link2" => '',
			"link2_caption" => '',
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));

		if (empty($id)) $id = "sc_call_to_action_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";

		if ($image > 0) {
			$attach = wp_get_attachment_image_src( $image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$image = $attach[0];
		}
		if (!empty($image) && $style==1) {
			$thumb_sizes = charity_is_hope_get_thumb_sizes(array('layout' => 'excerpt'));
			$image = !empty($video)
				? charity_is_hope_get_resized_image_url($image, $thumb_sizes['w'], $thumb_sizes['h'])
				: charity_is_hope_get_resized_image_tag($image, $thumb_sizes['w'], $thumb_sizes['h']);
		}

		if (!empty($video)) {
			$video = '<video' . ($id ? ' id="' . esc_attr($id.'_video') . '"' : '')
				. ' class="sc_video"'
				. ' src="' . esc_url(charity_is_hope_get_video_player_url($video)) . '"'
				. ' width="' . esc_attr($width) . '" height="' . esc_attr($height) . '"'
				. ' data-width="' . esc_attr($width) . '" data-height="' . esc_attr($height) . '"'
				. ' data-ratio="16:9"'
				. ($image ? ' poster="'.esc_attr($image).'" data-image="'.esc_attr($image).'"' : '')
				. ' controls="controls" loop="loop"'
				. '>'
				. '</video>';
			if (charity_is_hope_get_custom_option('substitute_video')=='no') {
				$video = charity_is_hope_get_video_frame($video, $image, '', '');
			} else {
				if ((isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') && (isset($_POST['action']) && $_POST['action']=='vc_load_shortcode')) {
					$video = charity_is_hope_substitute_video($video, $width, $height, false);
				}
			}
			if (charity_is_hope_get_theme_option('use_mediaelement')=='yes')
				wp_enqueue_script('wp-mediaelement');
		}

		$class .= ($class ? ' ' : '') . charity_is_hope_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= charity_is_hope_get_css_dimensions_from_values($width, $height);

		$content = do_shortcode($content);

		$featured = ($style==1 && (!empty($content) || !empty($image) || !empty($video))
					? '<div class="sc_call_to_action_featured column-1_2">'
						. (!empty($content)
							? $content
							: (!empty($video)
								? $video
								: $image)
							)
						. '</div>'
					: '');


		$featured2 = ($style==2 && !empty($image)
			? '<div class="sc_call_to_action_featured">'
			.('<div class="featured_bg"'.($image ? ' style="background-image:url('.$image.');"' : '').'></div>')
			. '</div>'
			: '');

		$need_columns = ($featured || $style==2) && !in_array($align, array('center', 'none'))
							? ($style==2 ? 4 : 2)
							: 0;

		$buttons = (!empty($link) || !empty($link2)
						? '<div class="sc_call_to_action_buttons sc_item_buttons">'
							. (!empty($link)
								? '<div class="sc_call_to_action_button sc_item_button">'.do_shortcode('[trx_button '.($style==1 ? 'icon="icon-arrow"' : '').' link="'.esc_url($link).'" size="large" '.(charity_is_hope_param_is_on($accent) ? 'style="filled3"' : 'style="filled2"').']'.esc_html($link_caption).'[/trx_button]').'</div>'
								: '')
							. (!empty($link2)
								? '<div class="sc_call_to_action_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link2).'" size="large"]'.esc_html($link2_caption).'[/trx_button]').'</div>'
								: '')
							. '</div>'
						: '');

		if($style==2){
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_call_to_action'
				. (charity_is_hope_param_is_on($accent) ? ' sc_call_to_action_accented' : '')
				. ' sc_call_to_action_style_' . esc_attr($style)
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. '"'
				. (!charity_is_hope_param_is_off($animation) ? ' data-animation="'.esc_attr(charity_is_hope_get_animation_classes($animation)).'"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>'

				. '<div class="sc_call_to_action_info">'
				. (!empty($subtitle) ? '<h6 class="sc_call_to_action_subtitle sc_item_subtitle">' . trim(charity_is_hope_strmacros($subtitle)) . '</h6>' : '')
				. (!empty($title) ? '<h2 class="sc_call_to_action_title sc_item_title' . (empty($description) ? ' sc_item_title_without_descr' : ' sc_item_title_without_descr') . '">' . trim(charity_is_hope_strmacros($title)) . '</h2>' : '')
				. (!empty($description) ? '<div class="sc_call_to_action_descr sc_item_descr">' . trim(charity_is_hope_strmacros($description)) . '</div>' : '')
				. '</div>'
				. ($featured2)
				. ($buttons)
				. '</div>';
		}
		else {
			$output = '<div' . ($id ? ' id="' . esc_attr($id) . '"' : '')
				. ' class="sc_call_to_action'
				. (charity_is_hope_param_is_on($accent) ? ' sc_call_to_action_accented' : '')
				. ' sc_call_to_action_style_' . esc_attr($style)
				. ' sc_call_to_action_align_' . esc_attr($align)
				. (!empty($class) ? ' ' . esc_attr($class) : '')
				. '"'
				. (!charity_is_hope_param_is_off($animation) ? ' data-animation="' . esc_attr(charity_is_hope_get_animation_classes($animation)) . '"' : '')
				. ($css != '' ? ' style="' . esc_attr($css) . '"' : '')
				. '>'
				. ($need_columns ? '<div class="columns_wrap">' : '')
				. ($align!='right' ? $featured : '')
				. ($style==2 && $align=='right' ? $buttons : '')
				. '<div class="sc_call_to_action_info'.($need_columns ? ' column-'.esc_attr($need_columns-1).'_'.esc_attr($need_columns) : '').'">'
				. (!empty($subtitle) ? '<h6 class="sc_call_to_action_subtitle sc_item_subtitle">' . trim(charity_is_hope_strmacros($subtitle)) . '</h6>' : '')
				. (!empty($title) ? '<h2 class="sc_call_to_action_title sc_item_title' . (empty($description) ? ' sc_item_title_without_descr' : ' sc_item_title_without_descr') . '">' . trim(charity_is_hope_strmacros($title)) . '</h2>' : '')
				. (!empty($description) ? '<div class="sc_call_to_action_descr sc_item_descr">' . trim(charity_is_hope_strmacros($description)) . '</div>' : '')
				. ($style==1 ? $buttons : '')
				. '</div>'
				. ($style==2 && $align!='right' ? $buttons : '')
				. ($align=='right' ? $featured : '')
				. ($need_columns ? '</div>' : '')
				. '</div>';
			}
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_call_to_action', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_call_to_action', 'charity_is_hope_sc_call_to_action');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_call_to_action_reg_shortcodes' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list', 'charity_is_hope_sc_call_to_action_reg_shortcodes');
	function charity_is_hope_sc_call_to_action_reg_shortcodes() {
	
		charity_is_hope_sc_map("trx_call_to_action", array(
			"title" => esc_html__("Call to action", 'trx_utils'),
			"desc" => wp_kses_data( __("Insert call to action block in your page (post)", 'trx_utils') ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"title" => array(
					"title" => esc_html__("Title", 'trx_utils'),
					"desc" => wp_kses_data( __("Title for the block", 'trx_utils') ),
					"value" => "",
					"type" => "text"
				),
				"subtitle" => array(
					"title" => esc_html__("Subtitle", 'trx_utils'),
					"desc" => wp_kses_data( __("Subtitle for the block", 'trx_utils') ),
					"value" => "",
					"type" => "text"
				),
				"description" => array(
					"title" => esc_html__("Description", 'trx_utils'),
					"desc" => wp_kses_data( __("Short description for the block", 'trx_utils') ),
					"value" => "",
					"type" => "textarea"
				),
				"style" => array(
					"title" => esc_html__("Style", 'trx_utils'),
					"desc" => wp_kses_data( __("Select style to display block", 'trx_utils') ),
					"value" => "1",
					"type" => "checklist",
					"options" => charity_is_hope_get_list_styles(1, 2)
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'trx_utils'),
					"desc" => wp_kses_data( __("Alignment elements in the block(style1)", 'trx_utils') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => charity_is_hope_get_sc_param('align')
				),
				"accent" => array(
					"title" => esc_html__("Accented", 'trx_utils'),
					"desc" => wp_kses_data( __("Fill entire block with links color from current color scheme", 'trx_utils') ),
					"divider" => true,
					"value" => "no",
					"type" => "switch",
					"options" => charity_is_hope_get_sc_param('yes_no')
				),
				"custom" => array(
					"title" => esc_html__("Custom", 'trx_utils'),
					"desc" => wp_kses_data( __("Allow get featured image or video from inner shortcodes (custom) or get it from shortcode parameters below", 'trx_utils') ),
					"divider" => true,
					"value" => "no",
					"type" => "switch",
					"options" => charity_is_hope_get_sc_param('yes_no')
				),
				"image" => array(
					"title" => esc_html__("Image", 'trx_utils'),
					"desc" => wp_kses_data( __("Select or upload image or write URL from other site to include image into this block", 'trx_utils') ),
					"divider" => true,
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"link" => array(
					"title" => esc_html__("Button URL", 'trx_utils'),
					"desc" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'trx_utils') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"link_caption" => array(
					"title" => esc_html__("Button caption", 'trx_utils'),
					"desc" => wp_kses_data( __("Caption for the button at the bottom of the block", 'trx_utils') ),
					"value" => "",
					"type" => "text"
				),
				"link2" => array(
					"title" => esc_html__("Button 2 URL", 'trx_utils'),
					"desc" => wp_kses_data( __("Link URL for the second button at the bottom of the block", 'trx_utils') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"link2_caption" => array(
					"title" => esc_html__("Button 2 caption", 'trx_utils'),
					"desc" => wp_kses_data( __("Caption for the second button at the bottom of the block", 'trx_utils') ),
					"value" => "",
					"type" => "text"
				),
				"width" => charity_is_hope_shortcodes_width(),
				"height" => charity_is_hope_shortcodes_height(),
				"top" => charity_is_hope_get_sc_param('top'),
				"bottom" => charity_is_hope_get_sc_param('bottom'),
				"left" => charity_is_hope_get_sc_param('left'),
				"right" => charity_is_hope_get_sc_param('right'),
				"id" => charity_is_hope_get_sc_param('id'),
				"class" => charity_is_hope_get_sc_param('class'),
				"animation" => charity_is_hope_get_sc_param('animation'),
				"css" => charity_is_hope_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_call_to_action_reg_shortcodes_vc' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list_vc', 'charity_is_hope_sc_call_to_action_reg_shortcodes_vc');
	function charity_is_hope_sc_call_to_action_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_call_to_action",
			"name" => esc_html__("Call to Action", 'trx_utils'),
			"description" => wp_kses_data( __("Insert call to action block in your page (post)", 'trx_utils') ),
			"category" => esc_html__('Content', 'trx_utils'),
			'icon' => 'icon_trx_call_to_action',
			"class" => "trx_sc_collection trx_sc_call_to_action",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Block's style", 'trx_utils'),
					"description" => wp_kses_data( __("Select style to display this block", 'trx_utils') ),
					"class" => "",
					"admin_label" => true,
					"value" => array_flip(charity_is_hope_get_list_styles(1, 2)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'trx_utils'),
					"description" => wp_kses_data( __("Select block alignment (style 1)", 'trx_utils') ),
					"class" => "",
					"value" => array_flip(charity_is_hope_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "accent",
					"heading" => esc_html__("Accent", 'trx_utils'),
					"description" => wp_kses_data( __("Fill entire block with links color from current color scheme", 'trx_utils') ),
					"class" => "",
					"value" => array("Fill with links color" => "yes" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "custom",
					"heading" => esc_html__("Custom", 'trx_utils'),
					"description" => wp_kses_data( __("Allow get featured image or video from inner shortcodes (custom) or get it from shortcode parameters below", 'trx_utils') ),
					"class" => "",
					"value" => array("Custom content" => "yes" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("Image", 'trx_utils'),
					"description" => wp_kses_data( __("Image to display inside block", 'trx_utils') ),
					'dependency' => array(
						'element' => 'custom',
						'is_empty' => true
					),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'trx_utils'),
					"description" => wp_kses_data( __("Title for the block", 'trx_utils') ),
					"admin_label" => true,
					"group" => esc_html__('Captions', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "subtitle",
					"heading" => esc_html__("Subtitle", 'trx_utils'),
					"description" => wp_kses_data( __("Subtitle for the block", 'trx_utils') ),
					"group" => esc_html__('Captions', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "description",
					"heading" => esc_html__("Description", 'trx_utils'),
					"description" => wp_kses_data( __("Description for the block", 'trx_utils') ),
					"group" => esc_html__('Captions', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textarea"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Button URL", 'trx_utils'),
					"description" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'trx_utils') ),
					"group" => esc_html__('Captions', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link_caption",
					"heading" => esc_html__("Button caption", 'trx_utils'),
					"description" => wp_kses_data( __("Caption for the button at the bottom of the block", 'trx_utils') ),
					"group" => esc_html__('Captions', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link2",
					"heading" => esc_html__("Button 2 URL", 'trx_utils'),
					"description" => wp_kses_data( __("Link URL for the second button at the bottom of the block", 'trx_utils') ),
					"group" => esc_html__('Captions', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link2_caption",
					"heading" => esc_html__("Button 2 caption", 'trx_utils'),
					"description" => wp_kses_data( __("Caption for the second button at the bottom of the block", 'trx_utils') ),
					"group" => esc_html__('Captions', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				charity_is_hope_get_vc_param('id'),
				charity_is_hope_get_vc_param('class'),
				charity_is_hope_get_vc_param('animation'),
				charity_is_hope_get_vc_param('css'),
				charity_is_hope_vc_width(),
				charity_is_hope_vc_height(),
				charity_is_hope_get_vc_param('margin_top'),
				charity_is_hope_get_vc_param('margin_bottom'),
				charity_is_hope_get_vc_param('margin_left'),
				charity_is_hope_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Call_To_Action extends CHARITY_IS_HOPE_VC_ShortCodeCollection {}
	}
}
?>