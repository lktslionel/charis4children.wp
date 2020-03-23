<?php
/**
 * Theme custom styles
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if (!function_exists('charity_is_hope_action_theme_styles_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_action_theme_styles_theme_setup', 1 );
	function charity_is_hope_action_theme_styles_theme_setup() {
	
		// Add theme fonts in the used fonts list
		add_filter('charity_is_hope_filter_used_fonts',			'charity_is_hope_filter_theme_styles_used_fonts');
		// Add theme fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('charity_is_hope_filter_list_fonts',			'charity_is_hope_filter_theme_styles_list_fonts');

		// Add theme stylesheets
		add_action('charity_is_hope_action_add_styles',			'charity_is_hope_action_theme_styles_add_styles');
		// Add theme inline styles
		add_filter('charity_is_hope_filter_add_styles_inline',		'charity_is_hope_filter_theme_styles_add_styles_inline');

		// Add theme scripts
		add_action('charity_is_hope_action_add_scripts',			'charity_is_hope_action_theme_styles_add_scripts');
		// Add theme scripts inline
		add_filter('charity_is_hope_filter_localize_script',		'charity_is_hope_filter_theme_styles_localize_script');

		// Add theme less files into list for compilation
		add_filter('charity_is_hope_filter_compile_less',			'charity_is_hope_filter_theme_styles_compile_less');


		/* Color schemes
		
		// Block's border and background
		bd_color		- border for the entire block
		bg_color		- background color for the entire block
		// Next settings are deprecated
		//bg_image, bg_image_position, bg_image_repeat, bg_image_attachment  - first background image for the entire block
		//bg_image2,bg_image2_position,bg_image2_repeat,bg_image2_attachment - second background image for the entire block
		
		// Additional accented colors (if need)
		accent2			- theme accented color 2
		accent2_hover	- theme accented color 2 (hover state)		
		accent3			- theme accented color 3
		accent3_hover	- theme accented color 3 (hover state)		
		
		// Headers, text and links
		text			- main content
		text_light		- post info
		text_dark		- headers
		text_link		- links
		text_hover		- hover links
		
		// Inverse blocks
		inverse_text	- text on accented background
		inverse_light	- post info on accented background
		inverse_dark	- headers on accented background
		inverse_link	- links on accented background
		inverse_hover	- hovered links on accented background
		
		// Input colors - form fields
		input_text		- inactive text
		input_light		- placeholder text
		input_dark		- focused text
		input_bd_color	- inactive border
		input_bd_hover	- focused borde
		input_bg_color	- inactive background
		input_bg_hover	- focused background
		
		// Alternative colors - highlight blocks, form fields, etc.
		alter_text		- text on alternative background
		alter_light		- post info on alternative background
		alter_dark		- headers on alternative background
		alter_link		- links on alternative background
		alter_hover		- hovered links on alternative background
		alter_bd_color	- alternative border
		alter_bd_hover	- alternative border for hovered state or active field
		alter_bg_color	- alternative background
		alter_bg_hover	- alternative background for hovered state or active field 
		// Next settings are deprecated
		//alter_bg_image, alter_bg_image_position, alter_bg_image_repeat, alter_bg_image_attachment - background image for the alternative block
		
		*/

		// Add color schemes
		charity_is_hope_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'charity-is-hope'),
			
			// Whole block border and background
			'bd_color'				=> '#d8d8d8', //ok
			'bg_color'				=> '#ffffff',
			
			// Headers, text and links colors
			'text'					=> '#8a8a8a', //ok
			'text_light'			=> '#acb4b6',
			'text_dark'				=> '#333333', //ok
			'text_link'				=> '#84c54e', //ok - green
			'text_hover'			=> '#ff7e27', //ok - orange

			// Inverse colors
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
		
			// Input fields
			'input_text'			=> '#8a8a8a', //ok
			'input_light'			=> '#acb4b6',
			'input_dark'			=> '#333333', //ok
			'input_bd_color'		=> '#f2f2f2', //ok
			'input_bd_hover'		=> '#d7d8d8', //ok
			'input_bg_color'		=> '#f2f2f2', //ok
			'input_bg_hover'		=> '#f2f2f2', //ok
		
			// Alternative blocks (submenu items, etc.)
			'alter_text'			=> '#757575', //ok
			'alter_light'			=> '#acb4b6',
			'alter_dark'			=> '#0f0f0f', //ok
			'alter_link'			=> '#ffe400', //ok - yellow
			'alter_hover'			=> '#ff7e27',
			'alter_bd_color'		=> '#dddddd',
			'alter_bd_hover'		=> '#bbbbbb',
			'alter_bg_color'		=> '#f6f5f2', //ok
			'alter_bg_hover'		=> '#424242', //ok
			)
		);

		// Add color schemes
		charity_is_hope_add_color_scheme('light', array(

			'title'					=> esc_html__('Light', 'charity-is-hope'),

			// Whole block border and background
			'bd_color'				=> '#dddddd',
			'bg_color'				=> '#f7f7f7',
		
			// Headers, text and links colors
			'text'					=> '#8a8a8a',
			'text_light'			=> '#acb4b6',
			'text_dark'				=> '#232a34',
			'text_link'				=> '#20c7ca',
			'text_hover'			=> '#189799',

			// Inverse colors
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
		
			// Input fields
			'input_text'			=> '#8a8a8a',
			'input_light'			=> '#acb4b6',
			'input_dark'			=> '#232a34',
			'input_bd_color'		=> '#e7e7e7',
			'input_bd_hover'		=> '#dddddd',
			'input_bg_color'		=> '#ffffff',
			'input_bg_hover'		=> '#f0f0f0',
		
			// Alternative blocks (submenu items, etc.)
			'alter_text'			=> '#8a8a8a',
			'alter_light'			=> '#acb4b6',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#20c7ca',
			'alter_hover'			=> '#189799',
			'alter_bd_color'		=> '#e7e7e7',
			'alter_bd_hover'		=> '#dddddd',
			'alter_bg_color'		=> '#ffffff',
			'alter_bg_hover'		=> '#f0f0f0',
			)
		);

		// Add color schemes
		charity_is_hope_add_color_scheme('dark', array(

			'title'					=> esc_html__('Dark', 'charity-is-hope'),
			
			// Whole block border and background
			'bd_color'				=> '#7d7d7d',
			'bg_color'				=> '#333333', //ok

			// Headers, text and links colors
			'text'					=> '#8a8a8a', //ok
			'text_light'			=> '#a0a0a0',
			'text_dark'				=> '#e0e0e0',
			'text_link'				=> '#84c54e', //ok
			'text_hover'			=> '#ff7e27', //ok

			// Inverse colors
			'inverse_text'			=> '#f0f0f0',
			'inverse_light'			=> '#e0e0e0',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#e5e5e5',
		
			// Input fields
			'input_text'			=> '#999999',
			'input_light'			=> '#aaaaaa',
			'input_dark'			=> '#d0d0d0',
			'input_bd_color'		=> '#464646', //ok
			'input_bd_hover'		=> '#585757', //ok
			'input_bg_color'		=> '#464646', //ok
			'input_bg_hover'		=> '#464646', //ok
		
			// Alternative blocks (submenu items, etc.)
			'alter_text'			=> '#999999',
			'alter_light'			=> '#aaaaaa',
			'alter_dark'			=> '#d0d0d0',
			'alter_link'			=> '#ffe400', //ok
			'alter_hover'			=> '#29fbff',
			'alter_bd_color'		=> '#909090',
			'alter_bd_hover'		=> '#888888',
			'alter_bg_color'		=> '#666666',
			'alter_bg_hover'		=> '#505050',
			)
		);


		/* Font slugs:
		h1 ... h6	- headers
		p			- plain text
		link		- links
		info		- info blocks (Posted 15 May, 2015 by John Doe)
		menu		- main menu
		submenu		- dropdown menus
		logo		- logo text
		button		- button's caption
		input		- input fields
		*/

		// Add Custom fonts
		charity_is_hope_add_custom_font('h1', array(
			'title'			=> esc_html__('Heading 1', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '4.500em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.23em',
			'margin-top'	=> '0.72em',
			'margin-bottom'	=> '0.52em'
			)
		);
		charity_is_hope_add_custom_font('h2', array(
			'title'			=> esc_html__('Heading 2', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '3.000em',
			'font-weight'	=> '800',
			'font-style'	=> '',
			'line-height'	=> '1.2em',
			'margin-top'	=> '1.1em',
			'margin-bottom'	=> '0.52em'
			)
		);
		charity_is_hope_add_custom_font('h3', array(
			'title'			=> esc_html__('Heading 3', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '2.500em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.2em',
			'margin-top'	=> '1.3em',
			'margin-bottom'	=> '0.4em'
			)
		);
		charity_is_hope_add_custom_font('h4', array(
			'title'			=> esc_html__('Heading 4', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.500em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.25em',
			'margin-top'	=> '1.6em',
			'margin-bottom'	=> '0.6em'
			)
		);
		charity_is_hope_add_custom_font('h5', array(
			'title'			=> esc_html__('Heading 5', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.125em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '2.2em',
			'margin-bottom'	=> '0.85em'
			)
		);
		charity_is_hope_add_custom_font('h6', array(
			'title'			=> esc_html__('Heading 6', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.35em',
			'margin-top'	=> '1.25em',
			'margin-bottom'	=> '0.65em'
			)
		);
		charity_is_hope_add_custom_font('p', array(
			'title'			=> esc_html__('Text', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> 'Open Sans',
			'font-size' 	=> '16px',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.65em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1em'
			)
		);
		charity_is_hope_add_custom_font('link', array(
			'title'			=> esc_html__('Links', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> ''
			)
		);
		charity_is_hope_add_custom_font('info', array(
			'title'			=> esc_html__('Post info', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '0.813em',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2857em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1.5em'
			)
		);
		charity_is_hope_add_custom_font('menu', array(
			'title'			=> esc_html__('Main menu items', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '0.875em',
			'font-weight'	=> '800',
			'font-style'	=> '',
			'line-height'	=> '1.2857em'
			)
		);
		charity_is_hope_add_custom_font('submenu', array(
			'title'			=> esc_html__('Dropdown menu items', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.21em'
			)
		);
		charity_is_hope_add_custom_font('logo', array(
			'title'			=> esc_html__('Logo', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '2em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.4em'
			)
		);
		charity_is_hope_add_custom_font('button', array(
			'title'			=> esc_html__('Buttons', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.4em'
			)
		);
		charity_is_hope_add_custom_font('input', array(
			'title'			=> esc_html__('Input fields', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2857em'
			)
		);
		charity_is_hope_add_custom_font('other', array(
			'title'			=> esc_html__('Other elements', 'charity-is-hope'),
			'description'	=> '',
			'font-family'	=> 'WCManoNegraBta'
			)
		);
	}
}





//------------------------------------------------------------------------------
// Theme fonts
//------------------------------------------------------------------------------

// Add theme fonts in the used fonts list
if (!function_exists('charity_is_hope_filter_theme_styles_used_fonts')) {
	function charity_is_hope_filter_theme_styles_used_fonts($theme_fonts) {
		$theme_fonts['Open Sans'] = 1;
		$theme_fonts['WCManoNegraBta'] = 1;
		return $theme_fonts;
	}
}

// Add theme fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('charity_is_hope_filter_theme_styles_list_fonts')) {
	function charity_is_hope_filter_theme_styles_list_fonts($list) {

		if (!isset($list['Open Sans']))	$list['Open Sans'] = array('family'=>'sans-serif');
	    if (!isset($list['WCManoNegraBta'])) {
			$list['WCManoNegraBta'] = array(
				'family' => 'sans-serif',
				'css'    => charity_is_hope_get_file_url('/css/font-face/WCManoNegraBta/stylesheet.css')
			);
		}
		return $list;
	}
}



//------------------------------------------------------------------------------
// Theme stylesheets
//------------------------------------------------------------------------------

// Add theme.less into list files for compilation
if (!function_exists('charity_is_hope_filter_theme_styles_compile_less')) {
	function charity_is_hope_filter_theme_styles_compile_less($files) {
		if (file_exists(charity_is_hope_get_file_dir('css/theme.less'))) {
		 	$files[] = charity_is_hope_get_file_dir('css/theme.less');
		}
		return $files;	
	}
}

// Add theme stylesheets
if (!function_exists('charity_is_hope_action_theme_styles_add_styles')) {
	function charity_is_hope_action_theme_styles_add_styles() {
		// Add stylesheet files only if LESS supported
		if ( charity_is_hope_get_theme_setting('less_compiler') != 'no' ) {
			wp_enqueue_style( 'charity-is-hope-theme-style', charity_is_hope_get_file_url('css/theme.css'), array(), null );
			wp_add_inline_style( 'charity-is-hope-theme-style', charity_is_hope_get_inline_css() );
		}
	}
}

// Add theme inline styles
if (!function_exists('charity_is_hope_filter_theme_styles_add_styles_inline')) {
	function charity_is_hope_filter_theme_styles_add_styles_inline($custom_style) {

		// Submenu width
		$menu_width = charity_is_hope_get_theme_option('menu_width');
		if (!empty($menu_width)) {
			$custom_style .= "
				/* Submenu width */
				.menu_side_nav > li ul,
				.menu_main_nav > li ul {
					width: ".intval($menu_width)."px;
				}
				.menu_side_nav > li > ul ul,
				.menu_main_nav > li > ul ul {
					left:".intval($menu_width+4)."px;
				}
				.menu_side_nav > li > ul ul.submenu_left,
				.menu_main_nav > li > ul ul.submenu_left {
					left:-".intval($menu_width+1)."px;
				}
			";
		}
	
		// Logo height
		$logo_height = charity_is_hope_get_custom_option('logo_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo header height */
				.top_panel_wrap .logo_main,
				.top_panel_wrap .logo_fixed {
					height:".intval($logo_height)."px;
				}
			";
		}
	
		// Logo top offset
		$logo_offset = charity_is_hope_get_custom_option('logo_offset');
		if (!empty($logo_offset)) {
			$custom_style .= "
				/* Logo header top offset */
				.page_wrap .top_panel_wrap .logo {
					margin-top:".intval($logo_offset)."px;
				}
			";
		}

		// Logo footer height
		$logo_height = charity_is_hope_get_theme_option('logo_footer_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo footer height */
				.contacts_wrap .logo img {
					height:".intval($logo_height)."px;
				}
			";
		}

		// Custom css from theme options
		$custom_style .= charity_is_hope_get_custom_option('custom_css');

		return $custom_style;	
	}
}


//------------------------------------------------------------------------------
// Theme scripts
//------------------------------------------------------------------------------

// Add theme scripts
if (!function_exists('charity_is_hope_action_theme_styles_add_scripts')) {
	function charity_is_hope_action_theme_styles_add_scripts() {
		if (charity_is_hope_get_theme_option('show_theme_customizer') == 'yes' && file_exists(charity_is_hope_get_file_dir('js/theme.customizer.js')))
			wp_enqueue_script( 'charity-is-hope-theme_styles-customizer-script', charity_is_hope_get_file_url('js/theme.customizer.js'), array(), null );
	}
}

// Add theme scripts inline
if (!function_exists('charity_is_hope_filter_theme_styles_localize_script')) {
	function charity_is_hope_filter_theme_styles_localize_script($vars) {
		if (empty($vars['theme_font']))
			$vars['theme_font'] = charity_is_hope_get_custom_font_settings('p', 'font-family');
		$vars['theme_color'] = charity_is_hope_get_scheme_color('text_dark');
		$vars['theme_bg_color'] = charity_is_hope_get_scheme_color('bg_color');
		return $vars;
	}
}
?>