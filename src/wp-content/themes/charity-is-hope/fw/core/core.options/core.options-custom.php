<?php
/**
 * Charity Is Hope Framework: Theme options custom fields
 *
 * @package	charity_is_hope
 * @since	charity_is_hope 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'charity_is_hope_options_custom_theme_setup' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_options_custom_theme_setup' );
	function charity_is_hope_options_custom_theme_setup() {

		if ( is_admin() ) {
			add_action("admin_enqueue_scripts",	'charity_is_hope_options_custom_load_scripts');
		}
		
	}
}

// Load required styles and scripts for custom options fields
if ( !function_exists( 'charity_is_hope_options_custom_load_scripts' ) ) {
	//Handler of add_action("admin_enqueue_scripts", 'charity_is_hope_options_custom_load_scripts');
	function charity_is_hope_options_custom_load_scripts() {
		wp_enqueue_script( 'charity-is-hope-options-custom-script',	charity_is_hope_get_file_url('core/core.options/js/core.options-custom.js'), array(), null, true );
	}
}


// Show theme specific fields in Post (and Page) options
if ( !function_exists( 'charity_is_hope_show_custom_field' ) ) {
	function charity_is_hope_show_custom_field($id, $field, $value) {
		$output = '';
		switch ($field['type']) {
			case 'reviews':
				$output .= '<div class="reviews_block">' . trim(charity_is_hope_reviews_get_markup($field, $value, true)) . '</div>';
				break;
	
			case 'mediamanager':
				wp_enqueue_media( );
				$output .= '<a id="'.esc_attr($id).'" class="button mediamanager charity_is_hope_media_selector"
					data-param="' . esc_attr($id) . '"
					data-choose="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'charity-is-hope') : esc_html__( 'Choose Image', 'charity-is-hope')).'"
					data-update="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Add to Gallery', 'charity-is-hope') : esc_html__( 'Choose Image', 'charity-is-hope')).'"
					data-multiple="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? 'true' : 'false').'"
					data-linked-field="'.esc_attr($field['media_field_id']).'"
					>' . (isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'charity-is-hope') : esc_html__( 'Choose Image', 'charity-is-hope')) . '</a>';
				break;
		}
		return apply_filters('charity_is_hope_filter_show_custom_field', $output, $id, $field, $value);
	}
}
?>