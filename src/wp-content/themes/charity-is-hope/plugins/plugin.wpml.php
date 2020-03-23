<?php
/* WPML support functions
------------------------------------------------------------------------------- */

// Check if WPML installed and activated
if ( !function_exists( 'charity_is_hope_exists_wpml' ) ) {
	function charity_is_hope_exists_wpml() {
		return defined('ICL_SITEPRESS_VERSION') && class_exists('sitepress');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'charity_is_hope_wpml_required_plugins' ) ) {
	//Handler of add_filter('charity_is_hope_filter_required_plugins',	'charity_is_hope_wpml_required_plugins');
	function charity_is_hope_wpml_required_plugins($list=array()) {
		if (in_array('wpml', charity_is_hope_storage_get('required_plugins'))) {
			$path = charity_is_hope_get_file_dir('plugins/install/wpml.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('WPML', 'charity-is-hope'),
					'slug' 		=> 'wpml',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}
?>