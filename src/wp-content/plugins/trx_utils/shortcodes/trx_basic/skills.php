<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('charity_is_hope_sc_skills_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_sc_skills_theme_setup' );
	function charity_is_hope_sc_skills_theme_setup() {
		add_action('charity_is_hope_action_shortcodes_list', 		'charity_is_hope_sc_skills_reg_shortcodes');
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_sc_skills_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_skills id="unique_id" type="bar|pie|arc|counter" dir="horizontal|vertical" layout="rows|columns" count="" max_value="100" align="left|right"]
	[trx_skills_item title="Scelerisque pid" value="50%"]
	[trx_skills_item title="Scelerisque pid" value="50%"]
	[trx_skills_item title="Scelerisque pid" value="50%"]
[/trx_skills]
*/

if (!function_exists('charity_is_hope_sc_skills')) {	
	function charity_is_hope_sc_skills($atts, $content=null){	
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"max_value" => "100",
			"type" => "bar",
			"layout" => "",
			"dir" => "",
			"style" => "1",
			"columns" => "",
			"align" => "",
			"color" => "",
			"bg_color" => "",
			"border_color" => "",
			"arc_caption" => esc_html__("Skills", 'trx_utils'),
			"pie_compact" => "on",
			"pie_cutout" => 0,
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link_caption" => esc_html__('Learn more', 'trx_utils'),
			"link" => '',
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
		charity_is_hope_storage_set('sc_skills_data', array(
			'counter' => 0,
            'columns' => 0,
            'height'  => 0,
            'type'    => $type,
            'pie_compact' => charity_is_hope_param_is_on($pie_compact) ? 'on' : 'off',
            'pie_cutout'  => max(0, min(99, $pie_cutout)),
            'color'   => $color,
            'bg_color'=> $bg_color,
            'border_color'=> $border_color,
            'legend'  => '',
            'data'    => ''
			)
		);
		charity_is_hope_enqueue_diagram($type);
		if ($type!='arc') {
			if ($layout=='' || ($layout=='columns' && $columns<1)) $layout = 'rows';
			if ($layout=='columns') charity_is_hope_storage_set_array('sc_skills_data', 'columns', $columns);
			if ($type=='bar') {
				if ($dir == '') $dir = 'horizontal';
				if ($dir == 'vertical' && $height < 1) $height = 300;
			}
		}
		if (empty($id)) $id = 'sc_skills_diagram_'.str_replace('.','',mt_rand());
		if ($max_value < 1) $max_value = 100;
		if ($style) {
			$style = max(1, min(4, $style));
			charity_is_hope_storage_set_array('sc_skills_data', 'style', $style);
		}
		charity_is_hope_storage_set_array('sc_skills_data', 'max', $max_value);
		charity_is_hope_storage_set_array('sc_skills_data', 'dir', $dir);
		charity_is_hope_storage_set_array('sc_skills_data', 'height', charity_is_hope_prepare_css_value($height));
		$class .= ($class ? ' ' : '') . charity_is_hope_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= charity_is_hope_get_css_dimensions_from_values($width);
		if (!charity_is_hope_storage_empty('sc_skills_data', 'height') && (charity_is_hope_storage_get_array('sc_skills_data', 'type') == 'arc' || (charity_is_hope_storage_get_array('sc_skills_data', 'type') == 'pie' && charity_is_hope_param_is_on(charity_is_hope_storage_get_array('sc_skills_data', 'pie_compact')))))
			$css .= 'height: '.charity_is_hope_storage_get_array('sc_skills_data', 'height');
		$content = do_shortcode($content);
		$output = '<div id="'.esc_attr($id).'"' 
					. ' class="sc_skills sc_skills_' . esc_attr($type) 
						. ($type=='bar' ? ' sc_skills_'.esc_attr($dir) : '') 
						. ($type=='pie' ? ' sc_skills_compact_'.esc_attr(charity_is_hope_storage_get_array('sc_skills_data', 'pie_compact')) : '') 
						. (!empty($class) ? ' '.esc_attr($class) : '') 
						. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
						. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
					. (!charity_is_hope_param_is_off($animation) ? ' data-animation="'.esc_attr(charity_is_hope_get_animation_classes($animation)).'"' : '')
					. ' data-type="'.esc_attr($type).'"'
					. ' data-caption="'.esc_attr($arc_caption).'"'
					. ($type=='bar' ? ' data-dir="'.esc_attr($dir).'"' : '')
				. '>'
					. (!empty($subtitle) ? '<h6 class="sc_skills_subtitle sc_item_subtitle">' . esc_html($subtitle) . '</h6>' : '')
					. (!empty($title) ? '<h2 class="sc_skills_title sc_item_title' . (empty($description) ? ' sc_item_title_without_descr' : ' sc_item_title_without_descr') . '">' . esc_html($title) . '</h2>' : '')
					. (!empty($description) ? '<div class="sc_skills_descr sc_item_descr">' . trim($description) . '</div>' : '')
					. ($layout == 'columns' ? '<div class="columns_wrap sc_skills_'.esc_attr($layout).' sc_skills_columns_'.esc_attr($columns).'">' : '')
					. ($type=='arc' 
						? ('<div class="sc_skills_legend">'.(charity_is_hope_storage_get_array('sc_skills_data', 'legend')).'</div>'
							. '<div id="'.esc_attr($id).'_diagram" class="sc_skills_arc_canvas"></div>'
							. '<div class="sc_skills_data" style="display:none;">' . (charity_is_hope_storage_get_array('sc_skills_data', 'data')) . '</div>'
						  )
						: '')
					. ($type=='pie' && charity_is_hope_param_is_on(charity_is_hope_storage_get_array('sc_skills_data', 'pie_compact'))
						? ('<div class="sc_skills_legend">'.(charity_is_hope_storage_get_array('sc_skills_data', 'legend')).'</div>'
							. '<div id="'.esc_attr($id).'_pie" class="sc_skills_item">'
								. '<canvas id="'.esc_attr($id).'_pie_canvas" class="sc_skills_pie_canvas"></canvas>'
								. '<div class="sc_skills_data" style="display:none;">' . (charity_is_hope_storage_get_array('sc_skills_data', 'data')) . '</div>'
							. '</div>'
						  )
						: '')
					. ($content)
					. ($layout == 'columns' ? '</div>' : '')
					. (!empty($link) ? '<div class="sc_skills_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
				. '</div>';
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_skills', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_skills', 'charity_is_hope_sc_skills');
}


if (!function_exists('charity_is_hope_sc_skills_item')) {	
	function charity_is_hope_sc_skills_item($atts, $content=null) {
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts( array(
			// Individual params
			"title" => "",
			"value" => "",
			"color" => "",
			"bg_color" => "",
			"border_color" => "",
			"style" => "",
			"icon" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		charity_is_hope_storage_inc_array('sc_skills_data', 'counter');
		$ed = charity_is_hope_substr($value, -1)=='%' ? '%' : '';
		$value = str_replace('%', '', $value);
		if (charity_is_hope_storage_get_array('sc_skills_data', 'max') < $value) charity_is_hope_storage_set_array('sc_skills_data', 'max', $value);
		$percent = round($value / charity_is_hope_storage_get_array('sc_skills_data', 'max') * 100);
		$start = 0;
		$stop = $value;
		$steps = 100;
		$step = max(1, round(charity_is_hope_storage_get_array('sc_skills_data', 'max')/$steps));
		$speed = mt_rand(10,40);
		$animation = round(($stop - $start) / $step * $speed);
		$title_block = '<div class="sc_skills_info"><div class="sc_skills_label">' . ($title) . '</div></div>';
		$old_color = $color;
		if (empty($color)) $color = charity_is_hope_storage_get_array('sc_skills_data', 'color');
		if (empty($color)) $color = charity_is_hope_get_scheme_color('text_link', $color);
		if (empty($bg_color)) $bg_color = charity_is_hope_storage_get_array('sc_skills_data', 'bg_color');
		if (empty($bg_color)) $bg_color = charity_is_hope_get_scheme_color('bg_color', $bg_color);
		if (empty($border_color)) $border_color = charity_is_hope_storage_get_array('sc_skills_data', 'border_color');
		if (empty($border_color)) $border_color = charity_is_hope_get_scheme_color('bd_color', $border_color);;
		if (empty($style)) $style = charity_is_hope_storage_get_array('sc_skills_data', 'style');
		$style = max(1, min(4, $style));
		$output = '';
		if (charity_is_hope_storage_get_array('sc_skills_data', 'type') == 'arc' || (charity_is_hope_storage_get_array('sc_skills_data', 'type') == 'pie' && charity_is_hope_param_is_on(charity_is_hope_storage_get_array('sc_skills_data', 'pie_compact')))) {
			if (charity_is_hope_storage_get_array('sc_skills_data', 'type') == 'arc' && empty($old_color)) {
				$rgb = charity_is_hope_hex2rgb($color);
				$color = 'rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.(1 - 0.1*(charity_is_hope_storage_get_array('sc_skills_data', 'counter')-1)).')';
			}
			charity_is_hope_storage_concat_array('sc_skills_data', 'legend', 
				'<div class="sc_skills_legend_item"><span class="sc_skills_legend_marker" style="background-color:'.esc_attr($color).'"></span><span class="sc_skills_legend_title">' . ($title) . '</span><span class="sc_skills_legend_value">' . ($value) . '</span></div>'
			);
			charity_is_hope_storage_concat_array('sc_skills_data', 'data', 
				'<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
					. ' class="'.esc_attr(charity_is_hope_storage_get_array('sc_skills_data', 'type')).'"'
					. (charity_is_hope_storage_get_array('sc_skills_data', 'type')=='pie'
						? ( ' data-start="'.esc_attr($start).'"'
							. ' data-stop="'.esc_attr($stop).'"'
							. ' data-step="'.esc_attr($step).'"'
							. ' data-steps="'.esc_attr($steps).'"'
							. ' data-max="'.esc_attr(charity_is_hope_storage_get_array('sc_skills_data', 'max')).'"'
							. ' data-speed="'.esc_attr($speed).'"'
							. ' data-duration="'.esc_attr($animation).'"'
							. ' data-color="'.esc_attr($color).'"'
							. ' data-bg_color="'.esc_attr($bg_color).'"'
							. ' data-border_color="'.esc_attr($border_color).'"'
							. ' data-cutout="'.esc_attr(charity_is_hope_storage_get_array('sc_skills_data', 'pie_cutout')).'"'
							. ' data-easing="easeOutCirc"'
							. ' data-ed="'.esc_attr($ed).'"'
							)
						: '')
					. '><input type="hidden" class="text" value="'.esc_attr($title).'" /><input type="hidden" class="percent" value="'.esc_attr($percent).'" /><input type="hidden" class="color" value="'.esc_attr($color).'" /></div>'
			);
		} else {
			$output .= (charity_is_hope_storage_get_array('sc_skills_data', 'columns') > 0 
							? '<div class="sc_skills_column column-1_'.esc_attr(charity_is_hope_storage_get_array('sc_skills_data', 'columns')).'">' 
							: '')
					. (charity_is_hope_storage_get_array('sc_skills_data', 'type')=='bar' && charity_is_hope_storage_get_array('sc_skills_data', 'dir')=='horizontal' ? $title_block : '')
					. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_skills_item' . ($style ? ' sc_skills_style_'.esc_attr($style) : '') 
							. (!empty($class) ? ' '.esc_attr($class) : '')
							. (charity_is_hope_storage_get_array('sc_skills_data', 'counter') % 2 == 1 ? ' odd' : ' even') 
							. (charity_is_hope_storage_get_array('sc_skills_data', 'counter') == 1 ? ' first' : '') 
							. '"'
						. (charity_is_hope_storage_get_array('sc_skills_data', 'height') !='' || $css 
							? ' style="' 
								. (charity_is_hope_storage_get_array('sc_skills_data', 'height') !='' 
										? 'height: '.esc_attr(charity_is_hope_storage_get_array('sc_skills_data', 'height')).';' 
										: '') 
								. ($css) 
								. '"' 
							: '')
					. '>'
					. (!empty($icon) ? '<div class="sc_skills_icon '.esc_attr($icon).'"></div>' : '');
			if (in_array(charity_is_hope_storage_get_array('sc_skills_data', 'type'), array('bar'))) {
				$output .= '<div class="sc_skills_total"'
					. ' data-start="' . esc_attr($start) . '"'
					. ' data-stop="' . esc_attr($stop) . '"'
					. ' data-step="' . esc_attr($step) . '"'
					. ' data-max="' . esc_attr(charity_is_hope_storage_get_array('sc_skills_data', 'max')) . '"'
					. ' data-speed="' . esc_attr($speed) . '"'
					. ' data-duration="' . esc_attr($animation) . '"'
					. ' data-ed="' . esc_attr($ed) . '"
					'.  (charity_is_hope_storage_get_array('sc_skills_data', 'dir')=='vertical' ? 'style="bottom:'.($stop) . ($ed).'"' : '')  .'
					>'
					. ($start) . ($ed)
					. '</div>'
					. '<div class="sc_skills_count"' . (charity_is_hope_storage_get_array('sc_skills_data', 'type') == 'bar' && $color ? ' style="background-color:' . esc_attr($color) . '; border-color:' . esc_attr($color) . '"' : '') . '>'
					. '</div>'
				    . (charity_is_hope_storage_get_array('sc_skills_data', 'dir')=='vertical' ? $title_block : '')
					;
			} else if (in_array(charity_is_hope_storage_get_array('sc_skills_data', 'type'), array('counter'))) {
				$output .= '<div class="sc_skills_count"' . (charity_is_hope_storage_get_array('sc_skills_data', 'type')=='bar' && $color ? ' style="background-color:' . esc_attr($color) . '; border-color:' . esc_attr($color) . '"' : '') . '>'
							. '<div class="sc_skills_total"'
								. ' data-start="'.esc_attr($start).'"'
								. ' data-stop="'.esc_attr($stop).'"'
								. ' data-step="'.esc_attr($step).'"'
								. ' data-max="'.esc_attr(charity_is_hope_storage_get_array('sc_skills_data', 'max')).'"'
								. ' data-speed="'.esc_attr($speed).'"'
								. ' data-duration="'.esc_attr($animation).'"'
								. ' data-ed="'.esc_attr($ed).'">'
								. ($start) . ($ed)
							.'</div>'
						. '</div>';
			} else if (charity_is_hope_storage_get_array('sc_skills_data', 'type')=='pie') {
				if (empty($id)) $id = 'sc_skills_canvas_'.str_replace('.','',mt_rand());
				$output .= '<canvas id="'.esc_attr($id).'_canvas"></canvas>'
					. '<div class="sc_skills_total"'
						. ' data-start="'.esc_attr($start).'"'
						. ' data-stop="'.esc_attr($stop).'"'
						. ' data-step="'.esc_attr($step).'"'
						. ' data-steps="'.esc_attr($steps).'"'
						. ' data-max="'.esc_attr(charity_is_hope_storage_get_array('sc_skills_data', 'max')).'"'
						. ' data-speed="'.esc_attr($speed).'"'
						. ' data-duration="'.esc_attr($animation).'"'
						. ' data-color="'.esc_attr($color).'"'
						. ' data-bg_color="'.esc_attr($bg_color).'"'
						. ' data-border_color="'.esc_attr($border_color).'"'
						. ' data-cutout="'.esc_attr(charity_is_hope_storage_get_array('sc_skills_data', 'pie_cutout')).'"'
						. ' data-easing="easeOutCirc"'
						. ' data-ed="'.esc_attr($ed).'">'
						. ($start) . ($ed)
					.'</div>';
			}
			$output .= 
					  (charity_is_hope_storage_get_array('sc_skills_data', 'type')=='counter' ? $title_block : '')
					. '</div>'
					. (charity_is_hope_storage_get_array('sc_skills_data', 'type') == 'pie' ? $title_block : '')
					. (charity_is_hope_storage_get_array('sc_skills_data', 'columns') > 0 ? '</div>' : '');
		}
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_skills_item', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_skills_item', 'charity_is_hope_sc_skills_item');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_skills_reg_shortcodes' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list', 'charity_is_hope_sc_skills_reg_shortcodes');
	function charity_is_hope_sc_skills_reg_shortcodes() {
	
		charity_is_hope_sc_map("trx_skills", array(
			"title" => esc_html__("Skills", 'trx_utils'),
			"desc" => wp_kses_data( __("Insert skills diagramm in your page (post)", 'trx_utils') ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"max_value" => array(
					"title" => esc_html__("Max value", 'trx_utils'),
					"desc" => wp_kses_data( __("Max value for skills items", 'trx_utils') ),
					"value" => 100,
					"min" => 1,
					"type" => "spinner"
				),
				"type" => array(
					"title" => esc_html__("Skills type", 'trx_utils'),
					"desc" => wp_kses_data( __("Select type of skills block", 'trx_utils') ),
					"value" => "bar",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => array(
						'bar' => esc_html__('Bar', 'trx_utils'),
						'pie' => esc_html__('Pie chart', 'trx_utils'),
						'counter' => esc_html__('Counter', 'trx_utils'),
						'arc' => esc_html__('Arc', 'trx_utils')
					)
				), 
				"layout" => array(
					"title" => esc_html__("Skills layout", 'trx_utils'),
					"desc" => wp_kses_data( __("Select layout of skills block", 'trx_utils') ),
					"dependency" => array(
						'type' => array('counter','pie','bar')
					),
					"value" => "rows",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => array(
						'rows' => esc_html__('Rows', 'trx_utils'),
						'columns' => esc_html__('Columns', 'trx_utils')
					)
				),
				"dir" => array(
					"title" => esc_html__("Direction", 'trx_utils'),
					"desc" => wp_kses_data( __("Select direction of skills block", 'trx_utils') ),
					"dependency" => array(
						'type' => array('counter','pie','bar')
					),
					"value" => "horizontal",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => charity_is_hope_get_sc_param('dir')
				), 
				"style" => array(
					"title" => esc_html__("Counters style", 'trx_utils'),
					"desc" => wp_kses_data( __("Select style of skills items (only for type=counter)", 'trx_utils') ),
					"dependency" => array(
						'type' => array('counter')
					),
					"value" => 1,
					"options" => charity_is_hope_get_list_styles(1, 4),
					"type" => "checklist"
				), 
				// "columns" - autodetect, not set manual
				"color" => array(
					"title" => esc_html__("Skills items color", 'trx_utils'),
					"desc" => wp_kses_data( __("Color for all skills items", 'trx_utils') ),
					"divider" => true,
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", 'trx_utils'),
					"desc" => wp_kses_data( __("Background color for all skills items (only for type=pie)", 'trx_utils') ),
					"dependency" => array(
						'type' => array('pie')
					),
					"value" => "",
					"type" => "color"
				),
				"border_color" => array(
					"title" => esc_html__("Border color", 'trx_utils'),
					"desc" => wp_kses_data( __("Border color for all skills items (only for type=pie)", 'trx_utils') ),
					"dependency" => array(
						'type' => array('pie')
					),
					"value" => "",
					"type" => "color"
				),
				"align" => array(
					"title" => esc_html__("Align skills block", 'trx_utils'),
					"desc" => wp_kses_data( __("Align skills block to left or right side", 'trx_utils') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => charity_is_hope_get_sc_param('float')
				), 
				"arc_caption" => array(
					"title" => esc_html__("Arc Caption", 'trx_utils'),
					"desc" => wp_kses_data( __("Arc caption - text in the center of the diagram", 'trx_utils') ),
					"dependency" => array(
						'type' => array('arc')
					),
					"value" => "",
					"type" => "text"
				),
				"pie_compact" => array(
					"title" => esc_html__("Pie compact", 'trx_utils'),
					"desc" => wp_kses_data( __("Show all skills in one diagram or as separate diagrams", 'trx_utils') ),
					"dependency" => array(
						'type' => array('pie')
					),
					"value" => "yes",
					"type" => "switch",
					"options" => charity_is_hope_get_sc_param('yes_no')
				),
				"pie_cutout" => array(
					"title" => esc_html__("Pie cutout", 'trx_utils'),
					"desc" => wp_kses_data( __("Pie cutout (0-99). 0 - without cutout, 99 - max cutout", 'trx_utils') ),
					"dependency" => array(
						'type' => array('pie')
					),
					"value" => 0,
					"min" => 0,
					"max" => 99,
					"type" => "spinner"
				),
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
				"link" => array(
					"title" => esc_html__("Button URL", 'trx_utils'),
					"desc" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'trx_utils') ),
					"value" => "",
					"type" => "text"
				),
				"link_caption" => array(
					"title" => esc_html__("Button caption", 'trx_utils'),
					"desc" => wp_kses_data( __("Caption for the button at the bottom of the block", 'trx_utils') ),
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
			),
			"children" => array(
				"name" => "trx_skills_item",
				"title" => esc_html__("Skill", 'trx_utils'),
				"desc" => wp_kses_data( __("Skills item", 'trx_utils') ),
				"container" => false,
				"params" => array(
					"title" => array(
						"title" => esc_html__("Title", 'trx_utils'),
						"desc" => wp_kses_data( __("Current skills item title", 'trx_utils') ),
						"value" => "",
						"type" => "text"
					),
					"value" => array(
						"title" => esc_html__("Value", 'trx_utils'),
						"desc" => wp_kses_data( __("Current skills level", 'trx_utils') ),
						"value" => 50,
						"min" => 0,
						"step" => 1,
						"type" => "spinner"
					),
					"color" => array(
						"title" => esc_html__("Color", 'trx_utils'),
						"desc" => wp_kses_data( __("Current skills item color", 'trx_utils') ),
						"value" => "",
						"type" => "color"
					),
					"bg_color" => array(
						"title" => esc_html__("Background color", 'trx_utils'),
						"desc" => wp_kses_data( __("Current skills item background color (only for type=pie)", 'trx_utils') ),
						"value" => "",
						"type" => "color"
					),
					"border_color" => array(
						"title" => esc_html__("Border color", 'trx_utils'),
						"desc" => wp_kses_data( __("Current skills item border color (only for type=pie)", 'trx_utils') ),
						"value" => "",
						"type" => "color"
					),
					"style" => array(
						"title" => esc_html__("Counter style", 'trx_utils'),
						"desc" => wp_kses_data( __("Select style for the current skills item (only for type=counter)", 'trx_utils') ),
						"value" => 1,
						"options" => charity_is_hope_get_list_styles(1, 4),
						"type" => "checklist"
					), 
					"icon" => array(
						"title" => esc_html__("Counter icon",  'trx_utils'),
						"desc" => wp_kses_data( __('Select icon from Fontello icons set, placed above counter (only for type=counter)',  'trx_utils') ),
						"value" => "",
						"type" => "icons",
						"options" => charity_is_hope_get_sc_param('icons')
					),
					"id" => charity_is_hope_get_sc_param('id'),
					"class" => charity_is_hope_get_sc_param('class'),
					"css" => charity_is_hope_get_sc_param('css')
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'charity_is_hope_sc_skills_reg_shortcodes_vc' ) ) {
	//add_action('charity_is_hope_action_shortcodes_list_vc', 'charity_is_hope_sc_skills_reg_shortcodes_vc');
	function charity_is_hope_sc_skills_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_skills",
			"name" => esc_html__("Skills", 'trx_utils'),
			"description" => wp_kses_data( __("Insert skills diagramm", 'trx_utils') ),
			"category" => esc_html__('Content', 'trx_utils'),
			'icon' => 'icon_trx_skills',
			"class" => "trx_sc_collection trx_sc_skills",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"as_parent" => array('only' => 'trx_skills_item'),
			"params" => array(
				array(
					"param_name" => "max_value",
					"heading" => esc_html__("Max value", 'trx_utils'),
					"description" => wp_kses_data( __("Max value for skills items", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => "100",
					"type" => "textfield"
				),
				array(
					"param_name" => "type",
					"heading" => esc_html__("Skills type", 'trx_utils'),
					"description" => wp_kses_data( __("Select type of skills block", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Bar', 'trx_utils') => 'bar',
						esc_html__('Pie chart', 'trx_utils') => 'pie',
						esc_html__('Counter', 'trx_utils') => 'counter',
						esc_html__('Arc', 'trx_utils') => 'arc'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "layout",
					"heading" => esc_html__("Skills layout", 'trx_utils'),
					"description" => wp_kses_data( __("Select layout of skills block", 'trx_utils') ),
					"admin_label" => true,
					'dependency' => array(
						'element' => 'type',
						'value' => array('counter','bar','pie')
					),
					"class" => "",
					"value" => array(
						esc_html__('Rows', 'trx_utils') => 'rows',
						esc_html__('Columns', 'trx_utils') => 'columns'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "dir",
					"heading" => esc_html__("Direction", 'trx_utils'),
					"description" => wp_kses_data( __("Select direction of skills block", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(charity_is_hope_get_sc_param('dir')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Counters style", 'trx_utils'),
					"description" => wp_kses_data( __("Select style of skills items (only for type=counter)", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(charity_is_hope_get_list_styles(1, 4)),
					'dependency' => array(
						'element' => 'type',
						'value' => array('counter')
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "columns",
					"heading" => esc_html__("Columns count", 'trx_utils'),
					"description" => wp_kses_data( __("Skills columns count (required)", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Color", 'trx_utils'),
					"description" => wp_kses_data( __("Color for all skills items", 'trx_utils') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'trx_utils'),
					"description" => wp_kses_data( __("Background color for all skills items (only for type=pie)", 'trx_utils') ),
					'dependency' => array(
						'element' => 'type',
						'value' => array('pie')
					),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "border_color",
					"heading" => esc_html__("Border color", 'trx_utils'),
					"description" => wp_kses_data( __("Border color for all skills items (only for type=pie)", 'trx_utils') ),
					'dependency' => array(
						'element' => 'type',
						'value' => array('pie')
					),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'trx_utils'),
					"description" => wp_kses_data( __("Align skills block to left or right side", 'trx_utils') ),
					"class" => "",
					"value" => array_flip(charity_is_hope_get_sc_param('float')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "arc_caption",
					"heading" => esc_html__("Arc caption", 'trx_utils'),
					"description" => wp_kses_data( __("Arc caption - text in the center of the diagram", 'trx_utils') ),
					'dependency' => array(
						'element' => 'type',
						'value' => array('arc')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "pie_compact",
					"heading" => esc_html__("Pie compact", 'trx_utils'),
					"description" => wp_kses_data( __("Show all skills in one diagram or as separate diagrams", 'trx_utils') ),
					'dependency' => array(
						'element' => 'type',
						'value' => array('pie')
					),
					"class" => "",
					"value" => array(esc_html__('Show separate skills', 'trx_utils') => 'no'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "pie_cutout",
					"heading" => esc_html__("Pie cutout", 'trx_utils'),
					"description" => wp_kses_data( __("Pie cutout (0-99). 0 - without cutout, 99 - max cutout", 'trx_utils') ),
					'dependency' => array(
						'element' => 'type',
						'value' => array('pie')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
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
		
		
		vc_map( array(
			"base" => "trx_skills_item",
			"name" => esc_html__("Skill", 'trx_utils'),
			"description" => wp_kses_data( __("Skills item", 'trx_utils') ),
			"show_settings_on_create" => true,
			'icon' => 'icon_trx_skills_item',
			"class" => "trx_sc_single trx_sc_skills_item",
			"content_element" => true,
			"is_container" => false,
			"as_child" => array('only' => 'trx_skills'),
			"as_parent" => array('except' => 'trx_skills'),
			"params" => array(
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'trx_utils'),
					"description" => wp_kses_data( __("Title for the current skills item", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "value",
					"heading" => esc_html__("Value", 'trx_utils'),
					"description" => wp_kses_data( __("Value for the current skills item", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Color", 'trx_utils'),
					"description" => wp_kses_data( __("Color for current skills item", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'trx_utils'),
					"description" => wp_kses_data( __("Background color for current skills item (only for type=pie)", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "border_color",
					"heading" => esc_html__("Border color", 'trx_utils'),
					"description" => wp_kses_data( __("Border color for current skills item (only for type=pie)", 'trx_utils') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Counter style", 'trx_utils'),
					"description" => wp_kses_data( __("Select style for the current skills item (only for type=counter)", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(charity_is_hope_get_list_styles(1, 4)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Counter icon", 'trx_utils'),
					"description" => wp_kses_data( __("Select icon from Fontello icons set, placed before counter (only for type=counter)", 'trx_utils') ),
					"class" => "",
					"value" => charity_is_hope_get_sc_param('icons'),
					"type" => "dropdown"
				),
				charity_is_hope_get_vc_param('id'),
				charity_is_hope_get_vc_param('class'),
				charity_is_hope_get_vc_param('css'),
			)
		) );
		
		class WPBakeryShortCode_Trx_Skills extends CHARITY_IS_HOPE_VC_ShortCodeCollection {}
		class WPBakeryShortCode_Trx_Skills_Item extends CHARITY_IS_HOPE_VC_ShortCodeSingle {}
	}
}
?>