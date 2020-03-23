<?php
/* The GDPR Framework support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('charity_is_hope_gdpr_framework_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_gdpr_framework_theme_setup', 1 );
	function charity_is_hope_gdpr_framework_theme_setup() {
		if (is_admin()) {
			add_filter( 'charity_is_hope_filter_required_plugins', 'charity_is_hope_gdpr_framework_required_plugins' );
		}
	}
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'charity_is_hope_exists_gdpr_framework' ) ) {
	function charity_is_hope_exists_gdpr_framework() {
		return defined( 'GDPR_FRAMEWORK_VERSION' );
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'charity_is_hope_gdpr_framework_required_plugins' ) ) {
	//Handler of add_filter('charity_is_hope_filter_required_plugins',	'charity_is_hope_gdpr_framework_required_plugins');
	function charity_is_hope_gdpr_framework_required_plugins($list=array()) {
		if (in_array('gdpr-framework', (array)charity_is_hope_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> esc_html__('The GDPR Framework', 'charity-is-hope'),
					'slug' 		=> 'gdpr-framework',
					'required' 	=> false
				);
		return $list;
	}
}
