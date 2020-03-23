<?php

// Check if shortcodes settings are now used
if ( !function_exists( 'charity_is_hope_shortcodes_is_used' ) ) {
	function charity_is_hope_shortcodes_is_used() {
		return charity_is_hope_options_is_used() 															// All modes when Theme Options are used
			|| (is_admin() && isset($_POST['action']) 
					&& in_array($_POST['action'], array('vc_edit_form', 'wpb_show_edit_form')))		// AJAX query when save post/page
			|| (is_admin() && !empty($_REQUEST['page']) && $_REQUEST['page']=='vc-roles')			// VC Role Manager
			|| (function_exists('charity_is_hope_vc_is_frontend') && charity_is_hope_vc_is_frontend());			// VC Frontend editor mode
	}
}

// Width and height params
if ( !function_exists( 'charity_is_hope_shortcodes_width' ) ) {
	function charity_is_hope_shortcodes_width($w="") {
		return array(
			"title" => esc_html__("Width", 'trx_utils'),
			"divider" => true,
			"value" => $w,
			"type" => "text"
		);
	}
}
if ( !function_exists( 'charity_is_hope_shortcodes_height' ) ) {
	function charity_is_hope_shortcodes_height($h='') {
		return array(
			"title" => esc_html__("Height", 'trx_utils'),
			"desc" => wp_kses_data( __("Width and height of the element", 'trx_utils') ),
			"value" => $h,
			"type" => "text"
		);
	}
}

// Return sc_param value
if ( !function_exists( 'charity_is_hope_get_sc_param' ) ) {
	function charity_is_hope_get_sc_param($prm) {
		return charity_is_hope_storage_get_array('sc_params', $prm);
	}
}

// Set sc_param value
if ( !function_exists( 'charity_is_hope_set_sc_param' ) ) {
	function charity_is_hope_set_sc_param($prm, $val) {
		charity_is_hope_storage_set_array('sc_params', $prm, $val);
	}
}

// Add sc settings in the sc list
if ( !function_exists( 'charity_is_hope_sc_map' ) ) {
	function charity_is_hope_sc_map($sc_name, $sc_settings) {
		charity_is_hope_storage_set_array('shortcodes', $sc_name, $sc_settings);
	}
}

// Add sc settings in the sc list after the key
if ( !function_exists( 'charity_is_hope_sc_map_after' ) ) {
	function charity_is_hope_sc_map_after($after, $sc_name, $sc_settings='') {
		charity_is_hope_storage_set_array_after('shortcodes', $after, $sc_name, $sc_settings);
	}
}

// Add sc settings in the sc list before the key
if ( !function_exists( 'charity_is_hope_sc_map_before' ) ) {
	function charity_is_hope_sc_map_before($before, $sc_name, $sc_settings='') {
		charity_is_hope_storage_set_array_before('shortcodes', $before, $sc_name, $sc_settings);
	}
}

// Compare two shortcodes by title
if ( !function_exists( 'charity_is_hope_compare_sc_title' ) ) {
	function charity_is_hope_compare_sc_title($a, $b) {
		return strcmp($a['title'], $b['title']);
	}
}



/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'charity_is_hope_shortcodes_settings_theme_setup' ) ) {
//	if ( charity_is_hope_vc_is_frontend() )
	if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') || (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline') )
		add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_shortcodes_settings_theme_setup', 20 );
	else
		add_action( 'charity_is_hope_action_after_init_theme', 'charity_is_hope_shortcodes_settings_theme_setup' );
	function charity_is_hope_shortcodes_settings_theme_setup() {
		if (charity_is_hope_shortcodes_is_used()) {

			// Sort templates alphabetically
			$tmp = charity_is_hope_storage_get('registered_templates');
			ksort($tmp);
			charity_is_hope_storage_set('registered_templates', $tmp);

			// Prepare arrays 
			charity_is_hope_storage_set('sc_params', array(
			
				// Current element id
				'id' => array(
					"title" => esc_html__("Element ID", 'trx_utils'),
					"desc" => wp_kses_data( __("ID for current element", 'trx_utils') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
			
				// Current element class
				'class' => array(
					"title" => esc_html__("Element CSS class", 'trx_utils'),
					"desc" => wp_kses_data( __("CSS class for current element (optional)", 'trx_utils') ),
					"value" => "",
					"type" => "text"
				),
			
				// Current element style
				'css' => array(
					"title" => esc_html__("CSS styles", 'trx_utils'),
					"desc" => wp_kses_data( __("Any additional CSS rules (if need)", 'trx_utils') ),
					"value" => "",
					"type" => "text"
				),
			
			
				// Switcher choises
				'list_styles' => array(
					'ul'	=> esc_html__('Unordered', 'trx_utils'),
					'ol'	=> esc_html__('Ordered', 'trx_utils'),
					'iconed'=> esc_html__('Iconed', 'trx_utils')
				),

				'yes_no'	=> charity_is_hope_get_list_yesno(),
				'on_off'	=> charity_is_hope_get_list_onoff(),
				'dir' 		=> charity_is_hope_get_list_directions(),
				'align'		=> charity_is_hope_get_list_alignments(),
				'float'		=> charity_is_hope_get_list_floats(),
				'hpos'		=> charity_is_hope_get_list_hpos(),
				'show_hide'	=> charity_is_hope_get_list_showhide(),
				'sorting' 	=> charity_is_hope_get_list_sortings(),
				'ordering' 	=> charity_is_hope_get_list_orderings(),
				'shapes'	=> charity_is_hope_get_list_shapes(),
				'sizes'		=> charity_is_hope_get_list_sizes(),
				'sliders'	=> charity_is_hope_get_list_sliders(),
				'controls'	=> charity_is_hope_get_list_controls(),

				// alternative case to refresh categories list:
				// hook add_action( 'wp_ajax_vc_edit_form', 'your func name' )
				// and return js-code with jQuery.post action 'charity_is_hope_admin_change_post_type'
				'categories'=> is_admin() && charity_is_hope_get_value_gp('action')=='vc_edit_form' && substr(charity_is_hope_get_value_gp('tag'), 0, 4)=='trx_' && isset($_POST['params']['post_type']) && $_POST['params']['post_type']!='post'
								? charity_is_hope_get_list_terms(false, charity_is_hope_get_taxonomy_categories_by_post_type($_POST['params']['post_type']))
								: charity_is_hope_get_list_categories(),

				'columns'	=> charity_is_hope_get_list_columns(),
				'images'	=> array_merge(array('none'=>"none"), charity_is_hope_get_list_images(CHARITY_IS_HOPE_FW_DIR."/images/icons", "png")),
				'icons'		=> array_merge(array("inherit", "none"), charity_is_hope_get_list_icons()),
				'locations'	=> charity_is_hope_get_list_dedicated_locations(),
				'filters'	=> charity_is_hope_get_list_portfolio_filters(),
				'formats'	=> charity_is_hope_get_list_post_formats_filters(),
				'hovers'	=> charity_is_hope_get_list_hovers(true),
				'hovers_dir'=> charity_is_hope_get_list_hovers_directions(true),
				'schemes'	=> charity_is_hope_get_list_color_schemes(true),
				'animations'		=> charity_is_hope_get_list_animations_in(),
				'margins' 			=> charity_is_hope_get_list_margins(true),
				'blogger_styles'	=> charity_is_hope_get_list_templates_blogger(),
				'forms'				=> charity_is_hope_get_list_templates_forms(),
				'posts_types'		=> charity_is_hope_get_list_posts_types(),
				'googlemap_styles'	=> charity_is_hope_get_list_googlemap_styles(),
				'field_types'		=> charity_is_hope_get_list_field_types(),
				'label_positions'	=> charity_is_hope_get_list_label_positions()
				)
			);

			// Common params
			charity_is_hope_set_sc_param('animation', array(
				"title" => esc_html__("Animation",  'trx_utils'),
				"desc" => wp_kses_data( __('Select animation while object enter in the visible area of page',  'trx_utils') ),
				"value" => "none",
				"type" => "select",
				"options" => charity_is_hope_get_sc_param('animations')
				)
			);
			charity_is_hope_set_sc_param('top', array(
				"title" => esc_html__("Top margin",  'trx_utils'),
				"divider" => true,
				"value" => "inherit",
				"type" => "select",
				"options" => charity_is_hope_get_sc_param('margins')
				)
			);
			charity_is_hope_set_sc_param('bottom', array(
				"title" => esc_html__("Bottom margin",  'trx_utils'),
				"value" => "inherit",
				"type" => "select",
				"options" => charity_is_hope_get_sc_param('margins')
				)
			);
			charity_is_hope_set_sc_param('left', array(
				"title" => esc_html__("Left margin",  'trx_utils'),
				"value" => "inherit",
				"type" => "select",
				"options" => charity_is_hope_get_sc_param('margins')
				)
			);
			charity_is_hope_set_sc_param('right', array(
				"title" => esc_html__("Right margin",  'trx_utils'),
				"desc" => wp_kses_data( __("Margins around this shortcode", 'trx_utils') ),
				"value" => "inherit",
				"type" => "select",
				"options" => charity_is_hope_get_sc_param('margins')
				)
			);

			charity_is_hope_storage_set('sc_params', apply_filters('charity_is_hope_filter_shortcodes_params', charity_is_hope_storage_get('sc_params')));

			// Shortcodes list
			//------------------------------------------------------------------
			charity_is_hope_storage_set('shortcodes', array());
			
			// Register shortcodes
			do_action('charity_is_hope_action_shortcodes_list');

			// Sort shortcodes list
			$tmp = charity_is_hope_storage_get('shortcodes');
			uasort($tmp, 'charity_is_hope_compare_sc_title');
			charity_is_hope_storage_set('shortcodes', $tmp);
		}
	}
}
?>