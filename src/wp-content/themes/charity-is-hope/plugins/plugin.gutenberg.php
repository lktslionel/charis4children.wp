<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('charity_is_hope_gutenberg_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_gutenberg_theme_setup', 1 );
	function charity_is_hope_gutenberg_theme_setup() {
		if (is_admin()) {
			add_filter( 'charity_is_hope_filter_required_plugins', 'charity_is_hope_gutenberg_required_plugins' );
		}
	}
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'charity_is_hope_exists_gutenberg' ) ) {
	function charity_is_hope_exists_gutenberg() {
		return function_exists( 'the_gutenberg_project' ) && function_exists( 'register_block_type' );
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'charity_is_hope_gutenberg_required_plugins' ) ) {
	//Handler of add_filter('charity_is_hope_filter_required_plugins',	'charity_is_hope_gutenberg_required_plugins');
	function charity_is_hope_gutenberg_required_plugins($list=array()) {
		if (in_array('gutenberg', (array)charity_is_hope_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> esc_html__('Gutenberg', 'charity-is-hope'),
					'slug' 		=> 'gutenberg',
					'required' 	=> false
				);
		return $list;
	}
}
