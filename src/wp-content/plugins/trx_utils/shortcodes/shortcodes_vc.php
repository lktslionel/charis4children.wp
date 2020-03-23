<?php
if (is_admin() 
		|| (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true' )
		|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline')
	) {
    require_once trx_utils_get_file_dir('shortcodes/shortcodes_vc_classes.php');
}

// Width and height params
if ( !function_exists( 'charity_is_hope_vc_width' ) ) {
	function charity_is_hope_vc_width($w='') {
		return array(
			"param_name" => "width",
			"heading" => esc_html__("Width", 'trx_utils'),
			"description" => wp_kses_data( __("Width of the element", 'trx_utils') ),
			"group" => esc_html__('Size &amp; Margins', 'trx_utils'),
			"value" => $w,
			"type" => "textfield"
		);
	}
}
if ( !function_exists( 'charity_is_hope_vc_height' ) ) {
	function charity_is_hope_vc_height($h='') {
		return array(
			"param_name" => "height",
			"heading" => esc_html__("Height", 'trx_utils'),
			"description" => wp_kses_data( __("Height of the element", 'trx_utils') ),
			"group" => esc_html__('Size &amp; Margins', 'trx_utils'),
			"value" => $h,
			"type" => "textfield"
		);
	}
}

// Load scripts and styles for VC support
if ( !function_exists( 'charity_is_hope_shortcodes_vc_scripts_admin' ) ) {
	//add_action( 'admin_enqueue_scripts', 'charity_is_hope_shortcodes_vc_scripts_admin' );
	function charity_is_hope_shortcodes_vc_scripts_admin() {
		// Include CSS 
		wp_enqueue_style ( 'shortcodes_vc_admin-style', trx_utils_get_file_url('shortcodes/theme.shortcodes_vc_admin.css'), array(), null );
		// Include JS
		wp_enqueue_script( 'shortcodes_vc_admin-script', trx_utils_get_file_url('shortcodes/shortcodes_vc_admin.js'), array('jquery'), null, true );
	}
}

// Load scripts and styles for VC support
if ( !function_exists( 'charity_is_hope_shortcodes_vc_scripts_front' ) ) {
	//add_action( 'wp_enqueue_scripts', 'charity_is_hope_shortcodes_vc_scripts_front' );
	function charity_is_hope_shortcodes_vc_scripts_front() {
		if (charity_is_hope_vc_is_frontend()) {
			// Include CSS 
			wp_enqueue_style ( 'shortcodes_vc_front-style', trx_utils_get_file_url('shortcodes/theme.shortcodes_vc_front.css'), array(), null );
			// Include JS
//			wp_enqueue_script( 'shortcodes_vc_front-script', trx_utils_get_file_url('shortcodes/shortcodes_vc_front.js'), array('jquery'), null, true );
			wp_enqueue_script( 'shortcodes_vc_theme-script', trx_utils_get_file_url('shortcodes/theme.shortcodes_vc_front.js'), array('jquery'), null, true );
		}
	}
}

// Add init script into shortcodes output in VC frontend editor
if ( !function_exists( 'charity_is_hope_shortcodes_vc_add_init_script' ) ) {
	//add_filter('charity_is_hope_shortcode_output', 'charity_is_hope_shortcodes_vc_add_init_script', 10, 4);
	function charity_is_hope_shortcodes_vc_add_init_script($output, $tag='', $atts=array(), $content='') {
		if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') && (isset($_POST['action']) && $_POST['action']=='vc_load_shortcode')
				&& ( isset($_POST['shortcodes'][0]['tag']) && $_POST['shortcodes'][0]['tag']==$tag )
		) {
			if (charity_is_hope_strpos($output, 'charity_is_hope_vc_init_shortcodes')===false) {
				$id = "charity_is_hope_vc_init_shortcodes_".str_replace('.', '', mt_rand());
				// Attention! This code will be appended in the shortcode's output
				// to init shortcode after it inserted in the page in the VC Frontend editor
				$holder = 'script';
				$output .= '<'.trim($holder).' id="'.esc_attr($id).'">
						try {
							charity_is_hope_init_post_formats();
							charity_is_hope_init_shortcodes(jQuery("body").eq(0));
							charity_is_hope_scroll_actions();
						} catch (e) { };
					</'.trim($holder).'>';
			}
		}
		return $output;
	}
}

// Return vc_param value
if ( !function_exists( 'charity_is_hope_get_vc_param' ) ) {
	function charity_is_hope_get_vc_param($prm) {
		return charity_is_hope_storage_get_array('vc_params', $prm);
	}
}

// Set vc_param value
if ( !function_exists( 'charity_is_hope_set_vc_param' ) ) {
	function charity_is_hope_set_vc_param($prm, $val) {
		charity_is_hope_storage_set_array('vc_params', $prm, $val);
	}
}


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'charity_is_hope_shortcodes_vc_theme_setup' ) ) {
	//if ( charity_is_hope_vc_is_frontend() )
	if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') || (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline') )
		add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_shortcodes_vc_theme_setup', 20 );
	else
		add_action( 'charity_is_hope_action_after_init_theme', 'charity_is_hope_shortcodes_vc_theme_setup' );
	function charity_is_hope_shortcodes_vc_theme_setup() {


		// Set dir with theme specific VC shortcodes
		if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
			vc_set_shortcodes_templates_dir( charity_is_hope_get_folder_dir('shortcodes/vc' ) );
		}
		
		// Add/Remove params in the standard VC shortcodes
		vc_add_param("vc_row", array(
					"param_name" => "scheme",
					"heading" => esc_html__("Color scheme", 'trx_utils'),
					"description" => wp_kses_data( __("Select color scheme for this block", 'trx_utils') ),
					"group" => esc_html__('Color scheme', 'trx_utils'),
					"class" => "",
					"value" => array_flip(charity_is_hope_get_list_color_schemes(true)),
					"type" => "dropdown"
		));

		// Add param 'inverse'
		vc_add_param("vc_row", array(
					"param_name" => "inverse",
					"heading" => esc_html__("Inverse colors", 'trx_utils'),
					"description" => wp_kses_data( __("Inverse all colors of this block", 'trx_utils') ),
					"group" => esc_html__('Color scheme', 'trx_utils'),
					"class" => "",
					"std" => "no",
					"value" => array(esc_html__('Inverse colors', 'trx_utils') => 'yes'),
					"type" => "checkbox"
		));

		// Add custom params to the VC shortcodes
		add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'charity_is_hope_shortcodes_vc_add_params_classes', 10, 3 );

		if (charity_is_hope_shortcodes_is_used() && class_exists('CHARITY_IS_HOPE_VC_ShortCodeSingle')) {

			// Set VC as main editor for the theme
			vc_set_as_theme( true );
			
			// Enable VC on follow post types
			vc_set_default_editor_post_types( array('page', 'team') );
			
			// Load scripts and styles for VC support
			add_action( 'wp_enqueue_scripts',		'charity_is_hope_shortcodes_vc_scripts_front');
			add_action( 'admin_enqueue_scripts',	'charity_is_hope_shortcodes_vc_scripts_admin' );

			// Add init script into shortcodes output in VC frontend editor
			add_filter('charity_is_hope_shortcode_output', 'charity_is_hope_shortcodes_vc_add_init_script', 10, 4);

			charity_is_hope_storage_set('vc_params', array(
				
				// Common arrays and strings
				'category' => esc_html__("Charity Is Hope shortcodes", 'trx_utils'),
			
				// Current element id
				'id' => array(
					"param_name" => "id",
					"heading" => esc_html__("Element ID", 'trx_utils'),
					"description" => wp_kses_data( __("ID for the element", 'trx_utils') ),
					"group" => esc_html__('ID &amp; Class', 'trx_utils'),
					"value" => "",
					"type" => "textfield"
				),
			
				// Current element class
				'class' => array(
					"param_name" => "class",
					"heading" => esc_html__("Element CSS class", 'trx_utils'),
					"description" => wp_kses_data( __("CSS class for the element", 'trx_utils') ),
					"group" => esc_html__('ID &amp; Class', 'trx_utils'),
					"value" => "",
					"type" => "textfield"
				),

				// Current element animation
				'animation' => array(
					"param_name" => "animation",
					"heading" => esc_html__("Animation", 'trx_utils'),
					"description" => wp_kses_data( __("Select animation while object enter in the visible area of page", 'trx_utils') ),
					"group" => esc_html__('ID &amp; Class', 'trx_utils'),
					"class" => "",
					"value" => array_flip(charity_is_hope_get_sc_param('animations')),
					"type" => "dropdown"
				),
			
				// Current element style
				'css' => array(
					"param_name" => "css",
					"heading" => esc_html__("CSS styles", 'trx_utils'),
					"description" => wp_kses_data( __("Any additional CSS rules (if need)", 'trx_utils') ),
					"group" => esc_html__('ID &amp; Class', 'trx_utils'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
			
				// Margins params
				'margin_top' => array(
					"param_name" => "top",
					"heading" => esc_html__("Top margin", 'trx_utils'),
					"description" => wp_kses_data( __("Margin above this shortcode", 'trx_utils') ),
					"group" => esc_html__('Size &amp; Margins', 'trx_utils'),
					"std" => "inherit",
					"value" => array_flip(charity_is_hope_get_sc_param('margins')),
					"type" => "dropdown"
				),
			
				'margin_bottom' => array(
					"param_name" => "bottom",
					"heading" => esc_html__("Bottom margin", 'trx_utils'),
					"description" => wp_kses_data( __("Margin below this shortcode", 'trx_utils') ),
					"group" => esc_html__('Size &amp; Margins', 'trx_utils'),
					"std" => "inherit",
					"value" => array_flip(charity_is_hope_get_sc_param('margins')),
					"type" => "dropdown"
				),
			
				'margin_left' => array(
					"param_name" => "left",
					"heading" => esc_html__("Left margin", 'trx_utils'),
					"description" => wp_kses_data( __("Margin on the left side of this shortcode", 'trx_utils') ),
					"group" => esc_html__('Size &amp; Margins', 'trx_utils'),
					"std" => "inherit",
					"value" => array_flip(charity_is_hope_get_sc_param('margins')),
					"type" => "dropdown"
				),
				
				'margin_right' => array(
					"param_name" => "right",
					"heading" => esc_html__("Right margin", 'trx_utils'),
					"description" => wp_kses_data( __("Margin on the right side of this shortcode", 'trx_utils') ),
					"group" => esc_html__('Size &amp; Margins', 'trx_utils'),
					"std" => "inherit",
					"value" => array_flip(charity_is_hope_get_sc_param('margins')),
					"type" => "dropdown"
				)
			) );
			
			// Add theme-specific shortcodes
			do_action('charity_is_hope_action_shortcodes_list_vc');

		}
	}
}

// Add params in the standard VC shortcodes
if ( !function_exists( 'charity_is_hope_shortcodes_vc_add_params_classes' ) ) {
	//Handler of the add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,				'charity_is_hope_shortcodes_vc_add_params_classes', 10, 3 );
	function charity_is_hope_shortcodes_vc_add_params_classes($classes, $sc, $atts) {
		if (in_array($sc, array('vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_column_text'))) {
			if (!empty($atts['scheme']) && !charity_is_hope_param_is_off($atts['scheme']) && !charity_is_hope_param_is_inherit($atts['scheme']))
				$classes .= ($classes ? ' ' : '') . 'scheme_' . $atts['scheme'];
		}
		if (in_array($sc, array('vc_row'))) {
			if (!empty($atts['inverse']) && !charity_is_hope_param_is_off($atts['inverse']))
				$classes .= ($classes ? ' ' : '') . 'inverse_colors';
		}
		return $classes;
	}
}

// Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)
if ( ! function_exists( 'trx_utils_gutenberg_disable_cpt' ) ) {
    add_action( 'current_screen', 'trx_utils_gutenberg_disable_cpt' );
    function trx_utils_gutenberg_disable_cpt() {
        $safe_pb = array('vc');
        if ( !empty($safe_pb) && function_exists( 'the_gutenberg_project' ) && function_exists( 'register_block_type' ) ) {
            $current_post_type = get_current_screen()->post_type;
            $disable = false;
            if ( !$disable && in_array('vc', $safe_pb) && function_exists('vc_editor_post_types') ) {
                $post_types = vc_editor_post_types();
                $disable = is_array($post_types) && in_array($current_post_type, $post_types);
            }
            if ( $disable ) {
                remove_filter( 'replace_editor', 'gutenberg_init' );
                remove_action( 'load-post.php', 'gutenberg_intercept_edit_post' );
                remove_action( 'load-post-new.php', 'gutenberg_intercept_post_new' );
                remove_action( 'admin_init', 'gutenberg_add_edit_link_filters' );
                remove_filter( 'admin_url', 'gutenberg_modify_add_new_button_url' );
                remove_action( 'admin_print_scripts-edit.php', 'gutenberg_replace_default_add_new_button' );
                remove_action( 'admin_enqueue_scripts', 'gutenberg_editor_scripts_and_styles' );
                remove_filter( 'screen_options_show_screen', '__return_false' );
            }
        }
    }
}
?>