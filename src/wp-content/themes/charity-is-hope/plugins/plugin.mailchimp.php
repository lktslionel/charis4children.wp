<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('charity_is_hope_mailchimp_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_mailchimp_theme_setup', 1 );
	function charity_is_hope_mailchimp_theme_setup() {
		if (charity_is_hope_exists_mailchimp()) {
			if (is_admin()) {
				add_filter( 'charity_is_hope_filter_importer_options',				'charity_is_hope_mailchimp_importer_set_options' );
				add_action( 'charity_is_hope_action_importer_params',				'charity_is_hope_mailchimp_importer_show_params', 10, 1 );
				add_filter( 'charity_is_hope_filter_importer_import_row',			'charity_is_hope_mailchimp_importer_check_row', 9, 4);
			}
		}
		if (is_admin()) {
			add_filter( 'charity_is_hope_filter_importer_required_plugins',		'charity_is_hope_mailchimp_importer_required_plugins', 10, 2 );
			add_filter( 'charity_is_hope_filter_required_plugins',					'charity_is_hope_mailchimp_required_plugins' );
		}
	}
}

// Check if Instagram Feed installed and activated
if ( !function_exists( 'charity_is_hope_exists_mailchimp' ) ) {
	function charity_is_hope_exists_mailchimp() {
		return function_exists('mc4wp_load_plugin');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'charity_is_hope_mailchimp_required_plugins' ) ) {
	//Handler of add_filter('charity_is_hope_filter_required_plugins',	'charity_is_hope_mailchimp_required_plugins');
	function charity_is_hope_mailchimp_required_plugins($list=array()) {
		if (in_array('mailchimp', charity_is_hope_storage_get('required_plugins')))
			$list[] = array(
				'name' 		=> esc_html__('MailChimp for WP', 'charity-is-hope'),
				'slug' 		=> 'mailchimp-for-wp',
				'required' 	=> false
			);
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check Mail Chimp in the required plugins
if ( !function_exists( 'charity_is_hope_mailchimp_importer_required_plugins' ) ) {
	//Handler of add_filter( 'charity_is_hope_filter_importer_required_plugins',	'charity_is_hope_mailchimp_importer_required_plugins', 10, 2 );
	function charity_is_hope_mailchimp_importer_required_plugins($not_installed='', $list='') {
		if (charity_is_hope_strpos($list, 'mailchimp')!==false && !charity_is_hope_exists_mailchimp() )
			$not_installed .= '<br>' . esc_html__('Mail Chimp', 'charity-is-hope');
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'charity_is_hope_mailchimp_importer_set_options' ) ) {
	//Handler of add_filter( 'charity_is_hope_filter_importer_options',	'charity_is_hope_mailchimp_importer_set_options' );
	function charity_is_hope_mailchimp_importer_set_options($options=array()) {
		if ( in_array('mailchimp', charity_is_hope_storage_get('required_plugins')) && charity_is_hope_exists_mailchimp() ) {
			// Add slugs to export options for this plugin
			$options['additional_options'][] = 'mc4wp_lite_checkbox';
			$options['additional_options'][] = 'mc4wp_lite_form';
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'charity_is_hope_mailchimp_importer_show_params' ) ) {
	//Handler of add_action( 'charity_is_hope_action_importer_params',	'charity_is_hope_mailchimp_importer_show_params', 10, 1 );
	function charity_is_hope_mailchimp_importer_show_params($importer) {
		if ( charity_is_hope_exists_mailchimp() && in_array('mailchimp', charity_is_hope_storage_get('required_plugins')) ) {
			$importer->show_importer_params(array(
				'slug' => 'mailchimp',
				'title' => esc_html__('Import MailChimp for WP', 'charity-is-hope'),
				'part' => 1
			));
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'charity_is_hope_mailchimp_importer_check_row' ) ) {
	//Handler of add_filter('charity_is_hope_filter_importer_import_row', 'charity_is_hope_mailchimp_importer_check_row', 9, 4);
	function charity_is_hope_mailchimp_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'mailchimp')===false) return $flag;
		if ( charity_is_hope_exists_mailchimp() ) {
			if ($table == 'posts')
				$flag = $row['post_type']=='mc4wp-form';
		}
		return $flag;
	}
}
?>