<?php
/* Tribe Events (TE) support functions
------------------------------------------------------------------------------- */


if (!defined('CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY')) 	{ define('CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY', 'give_forms_category'); }
if (!defined('CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG')) 	{ define('CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG', 'give_forms_tag'); }


if (!defined('CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS'))	{ define('CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS', 'give_forms'); }
if (!defined('CHARITY_IS_HOPE_GIVE_POST_TYPE_LIST')) 	{ define('CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS', 'give_payment'); }
if (!defined('CHARITY_IS_HOPE_GIVE_FORMS_SLUG')) 		{ define('CHARITY_IS_HOPE_GIVE_FORMS_SLUG', (defined( 'GIVE_FORMS_SLUG' ) ? GIVE_FORMS_SLUG : 'donations')); }

// Theme init
if (!function_exists('charity_is_hope_give_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_give_theme_setup', 1 );
	function charity_is_hope_give_theme_setup() {
		if (charity_is_hope_exists_give()) {

			// Hide goal process in the form content
			remove_action( 'give_pre_form',								'give_show_goal_progress', 10 );
			add_action( 'give_pre_form', 'charity_is_hope_give_pre_form', 55, 3 );

			add_action('charity_is_hope_action_add_styles',					'charity_is_hope_give_frontend_scripts' );
			add_action('give_donation_form_bottom',							'charity_is_hope_give_donation_form_bottom' );

			// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
			add_filter('charity_is_hope_filter_get_blog_type',			'charity_is_hope_give_get_blog_type', 9, 2);
			add_filter('charity_is_hope_filter_get_blog_title',			'charity_is_hope_give_get_blog_title', 9, 2);
			add_filter('charity_is_hope_filter_get_stream_page_title',	'charity_is_hope_give_get_stream_page_title', 9, 2);
			add_filter('charity_is_hope_filter_list_post_types',		'charity_is_hope_give_list_post_types');
			// Register shortcodes in the list
			add_action('charity_is_hope_action_shortcodes_list',		'charity_is_hope_give_reg_shortcodes');
			if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer()) {
				add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_give_reg_shortcodes_vc');
			}


		}
		if (is_admin()) {
			add_filter( 'charity_is_hope_filter_required_plugins',			'charity_is_hope_give_required_plugins' );
		}
	}
}

// Check if Tribe Events installed and activated
if (!function_exists('charity_is_hope_exists_give')) {
	function charity_is_hope_exists_give() {
		return class_exists( 'Give' );
	}
}

if ( !function_exists( 'charity_is_hope_give_settings_theme_setup2' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_give_settings_theme_setup2', 3 );
	function charity_is_hope_give_settings_theme_setup2() {
		// Add Donations post type and taxonomy into theme inheritance list
		if (charity_is_hope_exists_trx_donations()) {
			charity_is_hope_add_theme_inheritance( array(CHARITY_IS_HOPE_GIVE_FORMS_SLUG => array(
					'stream_template' => '',
					'single_template' => '',
					'taxonomy' => array(CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY),
					'taxonomy_tags' => array(CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG),
					'post_type' => array(CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS, CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS),
					'override' => 'custom'
				) )
			);
		}
	}
}


// Filter to detect current page slug
if ( !function_exists( 'charity_is_hope_give_get_blog_type' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_blog_type',	'charity_is_hope_give_get_blog_type', 9, 2);
	function charity_is_hope_give_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->is_tax(CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY) || is_tax(CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY))
			$page = CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY;
		else if ($query && $query->is_tax(CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG) || is_tax(CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG))
			$page = CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG;
		else if ($query && $query->get('post_type') == CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS
			|| get_query_var('post_type' == CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS))
			$page = $query && $query->is_single() || is_single() ? CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS . '_item' : CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS;
		else if ($query && $query->get('post_type') == CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS
			|| get_query_var('post_type' == CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS))
			$page = $query && $query->is_single() || is_single() ? CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS . '_item' : CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS;
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'charity_is_hope_give_get_blog_title' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_blog_title',	'charity_is_hope_give_get_blog_title', 9, 2);
	function charity_is_hope_give_get_blog_title($title, $page) {
		if (!empty($title)) return $title;

		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY) !== false ) {
			$term = get_term_by( 'slug', get_query_var( CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY ), CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY, OBJECT);
			$title = $term->name;
		}
		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG) !== false ) {
			$term = get_term_by( 'slug', get_query_var( CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG ), CHARITY_IS_HOPE_GIVE_TAXONOMY_TAG, OBJECT);
			$title = $term->name;
		}
		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS . '_item')  !== false
			|| charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS . '_item') !== false) {
			$title = charity_is_hope_get_post_title();
		}
		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS) !== false ) {
			$title = esc_html__('All donations', 'charity-is-hope');
		}
		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_PAYMENTS) !== false ) {
			$title = esc_html__('All paymants', 'charity-is-hope');
		}

		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'charity_is_hope_give_get_stream_page_title' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_stream_page_title',	'charity_is_hope_give_get_stream_page_title', 9, 2);
	function charity_is_hope_give_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;

		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS . '_item') !== false ) {
			$title = charity_is_hope_get_post_title();
		}
		if ( charity_is_hope_strpos($page, CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS) !== false ) {
			$title = esc_html__('All donations', 'charity-is-hope');
		}

		return $title;
	}
}

// Add title to a donation form
if (!function_exists('charity_is_hope_give_pre_form')) {
	function charity_is_hope_give_pre_form($form_id, $args, $form) {
		echo '<h4 class="give-form-title">';
		esc_html_e('Donation form', 'charity-is-hope');
		echo '</h4>';
	}
}

// Add title to a donation form
if (!function_exists('charity_is_hope_give_currency_symbol')) {
	function charity_is_hope_give_currency_symbol($symbol, $currency) {
		return ' ' . $currency;
	}
}



// Enqueue Tribe Events custom styles
if ( !function_exists( 'charity_is_hope_give_frontend_scripts' ) ) {
	//Handler of add_action( 'charity_is_hope_action_add_styles', 'charity_is_hope_give_frontend_scripts' );
	function charity_is_hope_give_frontend_scripts() {
		if (file_exists(charity_is_hope_get_file_dir('css/plugin.give.css')))
			wp_enqueue_style( 'charity-is-hope-plugin.give-style',  charity_is_hope_get_file_url('css/plugin.give.css'), array(), null );
	}
}


// Filter to add in the required plugins list
if ( !function_exists( 'charity_is_hope_give_required_plugins' ) ) {
	//Handler of add_filter('charity_is_hope_filter_required_plugins',	'charity_is_hope_give_required_plugins');
	function charity_is_hope_give_required_plugins($list=array()) {
		if (in_array('give', (array)charity_is_hope_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> esc_html__('Give WP', 'charity-is-hope'),
					'slug' 		=> 'give',
					'required' 	=> false
				);

		return $list;
	}
}

// Add share buttons
if ( !function_exists( 'charity_is_hope_give_donation_form_bottom' ) ) {
	function charity_is_hope_give_donation_form_bottom() {
		$show_share = charity_is_hope_get_custom_option("show_share");
		if (!charity_is_hope_param_is_off($show_share)) {
			$rez = charity_is_hope_show_share_links(array(
				'post_id'    => get_the_ID(),
				'post_link'  => get_post_permalink(),
				'post_title' => get_the_title(),
				'post_descr' => strip_tags(get_the_excerpt()),
				'post_thumb' => get_the_post_thumbnail_url(),
				'type'		 => 'block',
				'echo'		 => false
			));
			if ($rez) {
				?>
				<div class="post_info post_info_bottom post_info_share post_info_share_<?php echo esc_attr($show_share); ?>"><?php charity_is_hope_show_layout($rez); ?></div>
				<?php
			}
		}
	}
}
?>