<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('charity_is_hope_essgrids_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_essgrids_theme_setup', 1 );
	function charity_is_hope_essgrids_theme_setup() {
		// Register shortcode in the shortcodes list
		if (is_admin()) {
			add_filter( 'charity_is_hope_filter_importer_required_plugins',	'charity_is_hope_essgrids_importer_required_plugins', 10, 2 );
			add_filter( 'charity_is_hope_filter_required_plugins',				'charity_is_hope_essgrids_required_plugins' );
		}
	}
}


// Check if Ess. Grid installed and activated
if ( !function_exists( 'charity_is_hope_exists_essgrids' ) ) {
	function charity_is_hope_exists_essgrids() {
		return defined('EG_PLUGIN_PATH');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'charity_is_hope_essgrids_required_plugins' ) ) {
	//Handler of add_filter('charity_is_hope_filter_required_plugins',	'charity_is_hope_essgrids_required_plugins');
	function charity_is_hope_essgrids_required_plugins($list=array()) {
		if (in_array('essgrids', (array)charity_is_hope_storage_get('required_plugins'))) {
			$path = charity_is_hope_get_file_dir('plugins/install/essential-grid.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('Essential Grid', 'charity-is-hope'),
					'slug' 		=> 'essential-grid',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}

?>