<?php
/* Donations support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('charity_is_hope_trx_donations_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_trx_donations_theme_setup', 1 );
	function charity_is_hope_trx_donations_theme_setup() {

		// Register shortcode in the shortcodes list
		if (charity_is_hope_exists_trx_donations()) {

			add_action('charity_is_hope_action_add_styles', 				'charity_is_hope_donations_frontend_scripts' );

			// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
			add_filter('charity_is_hope_filter_get_blog_type',			'charity_is_hope_trx_donations_get_blog_type', 9, 2);
			add_filter('charity_is_hope_filter_get_blog_title',		'charity_is_hope_trx_donations_get_blog_title', 9, 2);
			add_filter('charity_is_hope_filter_get_current_taxonomy',	'charity_is_hope_trx_donations_get_current_taxonomy', 9, 2);
			add_filter('charity_is_hope_filter_is_taxonomy',			'charity_is_hope_trx_donations_is_taxonomy', 9, 2);
			add_filter('charity_is_hope_filter_get_stream_page_title',	'charity_is_hope_trx_donations_get_stream_page_title', 9, 2);
			add_filter('charity_is_hope_filter_get_stream_page_link',	'charity_is_hope_trx_donations_get_stream_page_link', 9, 2);
			add_filter('charity_is_hope_filter_get_stream_page_id',	'charity_is_hope_trx_donations_get_stream_page_id', 9, 2);
			add_filter('charity_is_hope_filter_query_add_filters',		'charity_is_hope_trx_donations_query_add_filters', 9, 2);
			add_filter('charity_is_hope_filter_detect_inheritance_key','charity_is_hope_trx_donations_detect_inheritance_key', 9, 1);
			add_filter('charity_is_hope_filter_list_post_types',		'charity_is_hope_trx_donations_list_post_types');
			// Register shortcodes in the list
			add_action('charity_is_hope_action_shortcodes_list',		'charity_is_hope_trx_donations_reg_shortcodes');
			if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
				add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_trx_donations_reg_shortcodes_vc');
			if (is_admin()) {
				add_filter( 'charity_is_hope_filter_importer_options',				'charity_is_hope_trx_donations_importer_set_options' );
			}
		}
		if (is_admin()) {
			add_filter( 'charity_is_hope_filter_importer_required_plugins',	'charity_is_hope_trx_donations_importer_required_plugins', 10, 2 );
			add_filter( 'charity_is_hope_filter_required_plugins',				'charity_is_hope_trx_donations_required_plugins' );
		}
	}
}

if ( !function_exists( 'charity_is_hope_trx_donations_settings_theme_setup2' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_trx_donations_settings_theme_setup2', 3 );
	function charity_is_hope_trx_donations_settings_theme_setup2() {
		// Add Donations post type and taxonomy into theme inheritance list
		if (charity_is_hope_exists_trx_donations()) {
			charity_is_hope_add_theme_inheritance( array('donations' => array(
				'stream_template' => 'blog-donations',
				'single_template' => 'single-donation',
				'taxonomy' => array(TRX_DONATIONS::TAXONOMY),
				'taxonomy_tags' => array(),
				'post_type' => array(TRX_DONATIONS::POST_TYPE),
				'override' => 'page'
				) )
			);
		}
	}
}


// Enqueue donations custom styles
if ( !function_exists( 'charity_is_hope_donations_frontend_scripts' ) ) {
	function charity_is_hope_donations_frontend_scripts() {
		if (charity_is_hope_exists_trx_donations())
			if (file_exists(charity_is_hope_get_file_dir('css/plugin.donations.css')))
				wp_enqueue_style( 'charity-is-hope-plugin.donations-style',  charity_is_hope_get_file_url('css/plugin.donations.css'), array(), null );
	}
}


// Check if Donations installed and activated
if ( !function_exists( 'charity_is_hope_exists_trx_donations' ) ) {
	function charity_is_hope_exists_trx_donations() {
		return class_exists('TRX_DONATIONS');
	}
}


// Return true, if current page is donations page
if ( !function_exists( 'charity_is_hope_is_trx_donations_page' ) ) {
	function charity_is_hope_is_trx_donations_page() {
		$is = false;
		if (charity_is_hope_exists_trx_donations()) {
			$is = in_array(charity_is_hope_storage_get('page_template'), array('blog-donations', 'single-donation'));
			if (!$is) {
				if (!charity_is_hope_storage_empty('pre_query'))
					$is = (charity_is_hope_storage_call_obj_method('pre_query', 'is_single') && charity_is_hope_storage_call_obj_method('pre_query', 'get', 'post_type') == TRX_DONATIONS::POST_TYPE) 
							|| charity_is_hope_storage_call_obj_method('pre_query', 'is_post_type_archive', TRX_DONATIONS::POST_TYPE) 
							|| charity_is_hope_storage_call_obj_method('pre_query', 'is_tax', TRX_DONATIONS::TAXONOMY);
				else
					$is = (is_single() && get_query_var('post_type') == TRX_DONATIONS::POST_TYPE) 
							|| is_post_type_archive(TRX_DONATIONS::POST_TYPE) 
							|| is_tax(TRX_DONATIONS::TAXONOMY);
			}
		}
		return $is;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'charity_is_hope_trx_donations_detect_inheritance_key' ) ) {
	//Handler of add_filter('charity_is_hope_filter_detect_inheritance_key',	'charity_is_hope_trx_donations_detect_inheritance_key', 9, 1);
	function charity_is_hope_trx_donations_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return charity_is_hope_is_trx_donations_page() ? 'donations' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'charity_is_hope_trx_donations_get_blog_type' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_blog_type',	'charity_is_hope_trx_donations_get_blog_type', 9, 2);
	function charity_is_hope_trx_donations_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->is_tax(TRX_DONATIONS::TAXONOMY) || is_tax(TRX_DONATIONS::TAXONOMY))
			$page = 'donations_category';
		else if ($query && $query->get('post_type')==TRX_DONATIONS::POST_TYPE || get_query_var('post_type')==TRX_DONATIONS::POST_TYPE)
			$page = $query && $query->is_single() || is_single() ? 'donations_item' : 'donations';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'charity_is_hope_trx_donations_get_blog_title' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_blog_title',	'charity_is_hope_trx_donations_get_blog_title', 9, 2);
	function charity_is_hope_trx_donations_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( charity_is_hope_strpos($page, 'donations')!==false ) {
			if ( $page == 'donations_category' ) {
				$term = get_term_by( 'slug', get_query_var( TRX_DONATIONS::TAXONOMY ), TRX_DONATIONS::TAXONOMY, OBJECT);
				$title = $term->name;
			} else if ( $page == 'donations_item' ) {
				$title = charity_is_hope_get_post_title();
			} else {
				$title = esc_html__('All donations', 'charity-is-hope');
			}
		}

		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'charity_is_hope_trx_donations_get_stream_page_title' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_stream_page_title',	'charity_is_hope_trx_donations_get_stream_page_title', 9, 2);
	function charity_is_hope_trx_donations_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (charity_is_hope_strpos($page, 'donations')!==false) {
			if (($page_id = charity_is_hope_trx_donations_get_stream_page_id(0, $page=='donations' ? 'blog-donations' : $page)) > 0)
				$title = charity_is_hope_get_post_title($page_id);
			else
				$title = esc_html__('All donations', 'charity-is-hope');				
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'charity_is_hope_trx_donations_get_stream_page_id' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_stream_page_id',	'charity_is_hope_trx_donations_get_stream_page_id', 9, 2);
	function charity_is_hope_trx_donations_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (charity_is_hope_strpos($page, 'donations')!==false) $id = charity_is_hope_get_template_page_id('blog-donations');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'charity_is_hope_trx_donations_get_stream_page_link' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_stream_page_link',	'charity_is_hope_trx_donations_get_stream_page_link', 9, 2);
	function charity_is_hope_trx_donations_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (charity_is_hope_strpos($page, 'donations')!==false) {
			$id = charity_is_hope_get_template_page_id('blog-donations');
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'charity_is_hope_trx_donations_get_current_taxonomy' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_current_taxonomy',	'charity_is_hope_trx_donations_get_current_taxonomy', 9, 2);
	function charity_is_hope_trx_donations_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( charity_is_hope_strpos($page, 'donations')!==false ) {
			$tax = TRX_DONATIONS::TAXONOMY;
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'charity_is_hope_trx_donations_is_taxonomy' ) ) {
	//Handler of add_filter('charity_is_hope_filter_is_taxonomy',	'charity_is_hope_trx_donations_is_taxonomy', 9, 2);
	function charity_is_hope_trx_donations_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query && $query->get(TRX_DONATIONS::TAXONOMY)!='' || is_tax(TRX_DONATIONS::TAXONOMY) ? TRX_DONATIONS::TAXONOMY : '';
	}
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'charity_is_hope_trx_donations_query_add_filters' ) ) {
	//Handler of add_filter('charity_is_hope_filter_query_add_filters',	'charity_is_hope_trx_donations_query_add_filters', 9, 2);
	function charity_is_hope_trx_donations_query_add_filters($args, $filter) {
		if ($filter == 'donations') {
			$args['post_type'] = TRX_DONATIONS::POST_TYPE;
		}
		return $args;
	}
}

// Add custom post type to the list
if ( !function_exists( 'charity_is_hope_trx_donations_list_post_types' ) ) {
	//Handler of add_filter('charity_is_hope_filter_list_post_types',		'charity_is_hope_trx_donations_list_post_types');
	function charity_is_hope_trx_donations_list_post_types($list) {
		$list[TRX_DONATIONS::POST_TYPE] = esc_html__('Donations', 'charity-is-hope');
		return $list;
	}
}


// Register shortcode in the shortcodes list
if (!function_exists('charity_is_hope_trx_donations_reg_shortcodes')) {
	//Handler of add_filter('charity_is_hope_action_shortcodes_list',	'charity_is_hope_trx_donations_reg_shortcodes');
	function charity_is_hope_trx_donations_reg_shortcodes() {
		if (charity_is_hope_storage_isset('shortcodes')) {

			$plugin = TRX_DONATIONS::get_instance();
			$donations_groups = charity_is_hope_get_list_terms(false, TRX_DONATIONS::TAXONOMY);

			charity_is_hope_sc_map_before('trx_dropcaps', array(

				// Donations form
				"trx_donations_form" => array(
					"title" => esc_html__("Donations form", 'charity-is-hope'),
					"desc" => esc_html__("Insert Donations form", 'charity-is-hope'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", 'charity-is-hope'),
							"desc" => esc_html__("Title for the donations form", 'charity-is-hope'),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", 'charity-is-hope'),
							"desc" => esc_html__("Subtitle for the donations form", 'charity-is-hope'),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", 'charity-is-hope'),
							"desc" => esc_html__("Short description for the donations form", 'charity-is-hope'),
							"value" => "",
							"type" => "textarea"
						),
						"align" => array(
							"title" => esc_html__("Alignment", 'charity-is-hope'),
							"desc" => esc_html__("Alignment of the donations form", 'charity-is-hope'),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => charity_is_hope_get_sc_param('align')
						),
						"account" => array(
							"title" => esc_html__("PayPal account", 'charity-is-hope'),
							"desc" => esc_html__("PayPal account's e-mail. If empty - used from Donations settings", 'charity-is-hope'),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"sandbox" => array(
							"title" => esc_html__("Sandbox mode", 'charity-is-hope'),
							"desc" => esc_html__("Use PayPal sandbox to test payments", 'charity-is-hope'),
							"dependency" => array(
								'account' => array('not_empty')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => charity_is_hope_get_sc_param('yes_no')
						),
						"amount" => array(
							"title" => esc_html__("Default amount", 'charity-is-hope'),
							"desc" => esc_html__("Specify amount, initially selected in the form", 'charity-is-hope'),
							"dependency" => array(
								'account' => array('not_empty')
							),
							"value" => 5,
							"min" => 1,
							"step" => 5,
							"type" => "spinner"
						),
						"currency" => array(
							"title" => esc_html__("Currency", 'charity-is-hope'),
							"desc" => esc_html__("Select payment's currency", 'charity-is-hope'),
							"dependency" => array(
								'account' => array('not_empty')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => charity_is_hope_array_merge(array(0 => esc_html__('- Select currency -', 'charity-is-hope')), $plugin->currency_codes)
						),
						"id" => charity_is_hope_get_sc_param('id'),
						"class" => charity_is_hope_get_sc_param('class'),
						"css" => charity_is_hope_get_sc_param('css')
					)
				),
				
				
				// Donations form
				"trx_donations_list" => array(
					"title" => esc_html__("Donations list", 'charity-is-hope'),
					"desc" => esc_html__("Insert Doantions list", 'charity-is-hope'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", 'charity-is-hope'),
							"desc" => esc_html__("Title for the donations list", 'charity-is-hope'),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", 'charity-is-hope'),
							"desc" => esc_html__("Subtitle for the donations list", 'charity-is-hope'),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", 'charity-is-hope'),
							"desc" => esc_html__("Short description for the donations list", 'charity-is-hope'),
							"value" => "",
							"type" => "textarea"
						),
						"link" => array(
							"title" => esc_html__("Button URL", 'charity-is-hope'),
							"desc" => esc_html__("Link URL for the button at the bottom of the block", 'charity-is-hope'),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"link_caption" => array(
							"title" => esc_html__("Button caption", 'charity-is-hope'),
							"desc" => esc_html__("Caption for the button at the bottom of the block", 'charity-is-hope'),
							"value" => "",
							"type" => "text"
						),
						"style" => array(
							"title" => esc_html__("List style", 'charity-is-hope'),
							"desc" => esc_html__("Select style to display donations", 'charity-is-hope'),
							"value" => "excerpt",
							"type" => "select",
							"options" => array(
								'excerpt' => esc_html__('Excerpt', 'charity-is-hope'),
								'extra' => esc_html__('Extra', 'charity-is-hope')
							)
						),
						"readmore" => array(
							"title" => esc_html__("Read more text", 'charity-is-hope'),
							"desc" => esc_html__("Text of the 'Read more' link", 'charity-is-hope'),
							"value" => esc_html__('Read more', 'charity-is-hope'),
							"type" => "hidden"
						),
						"cat" => array(
							"title" => esc_html__("Categories", 'charity-is-hope'),
							"desc" => esc_html__("Select categories (groups) to show donations. If empty - select donations from any category (group) or from IDs list", 'charity-is-hope'),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => charity_is_hope_array_merge(array(0 => esc_html__('- Select category -', 'charity-is-hope')), $donations_groups)
						),
						"count" => array(
							"title" => esc_html__("Number of donations", 'charity-is-hope'),
							"desc" => esc_html__("How many donations will be displayed? If used IDs - this parameter ignored.", 'charity-is-hope'),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns", 'charity-is-hope'),
							"desc" => esc_html__("How many columns use to show donations list", 'charity-is-hope'),
							"value" => 3,
							"min" => 2,
							"max" => 6,
							"step" => 1,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => esc_html__("Offset before select posts", 'charity-is-hope'),
							"desc" => esc_html__("Skip posts before select next part.", 'charity-is-hope'),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Donadions order by", 'charity-is-hope'),
							"desc" => esc_html__("Select desired sorting method", 'charity-is-hope'),
							"value" => "date",
							"type" => "select",
							"options" => charity_is_hope_get_sc_param('sorting')
						),
						"order" => array(
							"title" => esc_html__("Donations order", 'charity-is-hope'),
							"desc" => esc_html__("Select donations order", 'charity-is-hope'),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => charity_is_hope_get_sc_param('ordering')
						),
						"ids" => array(
							"title" => esc_html__("Donations IDs list", 'charity-is-hope'),
							"desc" => esc_html__("Comma separated list of donations ID. If set - parameters above are ignored!", 'charity-is-hope'),
							"value" => "",
							"type" => "text"
						),
						"id" => charity_is_hope_get_sc_param('id'),
						"class" => charity_is_hope_get_sc_param('class'),
						"css" => charity_is_hope_get_sc_param('css')
					)
				)

			));
		}
	}
}


// Register shortcode in the VC shortcodes list
if (!function_exists('charity_is_hope_trx_donations_reg_shortcodes_vc')) {
	//Handler of add_filter('charity_is_hope_action_shortcodes_list_vc',	'charity_is_hope_trx_donations_reg_shortcodes_vc');
	function charity_is_hope_trx_donations_reg_shortcodes_vc() {

		$plugin = TRX_DONATIONS::get_instance();
		$donations_groups = charity_is_hope_get_list_terms(false, TRX_DONATIONS::TAXONOMY);

		// Donations form
		vc_map( array(
				"base" => "trx_donations_form",
				"name" => esc_html__("Donations form", 'charity-is-hope'),
				"description" => esc_html__("Insert Donations form", 'charity-is-hope'),
				"category" => esc_html__('Content', 'charity-is-hope'),
				'icon' => 'icon_trx_donations_form',
				"class" => "trx_sc_single trx_sc_donations_form",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", 'charity-is-hope'),
						"description" => esc_html__("Title for the donations form", 'charity-is-hope'),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", 'charity-is-hope'),
						"description" => esc_html__("Subtitle for the donations form", 'charity-is-hope'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", 'charity-is-hope'),
						"description" => esc_html__("Description for the donations form", 'charity-is-hope'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", 'charity-is-hope'),
						"description" => esc_html__("Alignment of the donations form", 'charity-is-hope'),
						"class" => "",
						"value" => array_flip((array)charity_is_hope_get_sc_param('align')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "account",
						"heading" => esc_html__("PayPal account", 'charity-is-hope'),
						"description" => esc_html__("PayPal account's e-mail. If empty - used from Donations settings", 'charity-is-hope'),
						"admin_label" => true,
						"group" => esc_html__('PayPal', 'charity-is-hope'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "sandbox",
						"heading" => esc_html__("Sandbox mode", 'charity-is-hope'),
						"description" => esc_html__("Use PayPal sandbox to test payments", 'charity-is-hope'),
						"admin_label" => true,
						"group" => esc_html__('PayPal', 'charity-is-hope'),
						'dependency' => array(
							'element' => 'account',
							'not_empty' => true
						),
						"class" => "",
						"value" => array("Sandbox mode" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "amount",
						"heading" => esc_html__("Default amount", 'charity-is-hope'),
						"description" => esc_html__("Specify amount, initially selected in the form", 'charity-is-hope'),
						"admin_label" => true,
						"group" => esc_html__('PayPal', 'charity-is-hope'),
						"class" => "",
						"value" => "5",
						"type" => "textfield"
					),
					array(
						"param_name" => "currency",
						"heading" => esc_html__("Currency", 'charity-is-hope'),
						"description" => esc_html__("Select payment's currency", 'charity-is-hope'),
						"class" => "",
						"value" => array_flip(charity_is_hope_array_merge(array(0 => esc_html__('- Select currency -', 'charity-is-hope')), $plugin->currency_codes)),
						"type" => "dropdown"
					),
					charity_is_hope_get_vc_param('id'),
					charity_is_hope_get_vc_param('class'),
					charity_is_hope_get_vc_param('css'),
					charity_is_hope_vc_width(),
				)
			) );
			
		class WPBakeryShortCode_Trx_Donations_Form extends CHARITY_IS_HOPE_VC_ShortCodeSingle {}



		// Donations list
		vc_map( array(
				"base" => "trx_donations_list",
				"name" => esc_html__("Donations list", 'charity-is-hope'),
				"description" => esc_html__("Insert Donations list", 'charity-is-hope'),
				"category" => esc_html__('Content', 'charity-is-hope'),
				'icon' => 'icon_trx_donations_list',
				"class" => "trx_sc_single trx_sc_donations_list",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("List style", 'charity-is-hope'),
						"description" => esc_html__("Select style to display donations", 'charity-is-hope'),
						"class" => "",
						"value" => array(
							esc_html__('Excerpt', 'charity-is-hope') => 'excerpt',
							esc_html__('Extra', 'charity-is-hope') => 'extra'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", 'charity-is-hope'),
						"description" => esc_html__("Title for the donations form", 'charity-is-hope'),
						"group" => esc_html__('Captions', 'charity-is-hope'),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", 'charity-is-hope'),
						"description" => esc_html__("Subtitle for the donations form", 'charity-is-hope'),
						"group" => esc_html__('Captions', 'charity-is-hope'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", 'charity-is-hope'),
						"description" => esc_html__("Description for the donations form", 'charity-is-hope'),
						"group" => esc_html__('Captions', 'charity-is-hope'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Button URL", 'charity-is-hope'),
						"description" => esc_html__("Link URL for the button at the bottom of the block", 'charity-is-hope'),
						"group" => esc_html__('Captions', 'charity-is-hope'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link_caption",
						"heading" => esc_html__("Button caption", 'charity-is-hope'),
						"description" => esc_html__("Caption for the button at the bottom of the block", 'charity-is-hope'),
						"group" => esc_html__('Captions', 'charity-is-hope'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "readmore",
						"heading" => esc_html__("Read more text", 'charity-is-hope'),
						"description" => esc_html__("Text of the 'Read more' link", 'charity-is-hope'),
						"group" => esc_html__('Captions', 'charity-is-hope'),
						"class" => "",
						"value" => esc_html__('Read more', 'charity-is-hope'),
						"type" => "hidden"
					),
					array(
						"param_name" => "cat",
						"heading" => esc_html__("Categories", 'charity-is-hope'),
						"description" => esc_html__("Select category to show donations. If empty - select donations from any category (group) or from IDs list", 'charity-is-hope'),
						"group" => esc_html__('Query', 'charity-is-hope'),
						"class" => "",
						"value" => array_flip(charity_is_hope_array_merge(array(0 => esc_html__('- Select category -', 'charity-is-hope')), $donations_groups)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'charity-is-hope'),
						"description" => esc_html__("How many columns use to show donations", 'charity-is-hope'),
						"group" => esc_html__('Query', 'charity-is-hope'),
						"admin_label" => true,
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Number of posts", 'charity-is-hope'),
						"description" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", 'charity-is-hope'),
						"group" => esc_html__('Query', 'charity-is-hope'),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => esc_html__("Offset before select posts", 'charity-is-hope'),
						"description" => esc_html__("Skip posts before select next part.", 'charity-is-hope'),
						"group" => esc_html__('Query', 'charity-is-hope'),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Post sorting", 'charity-is-hope'),
						"description" => esc_html__("Select desired posts sorting method", 'charity-is-hope'),
						"group" => esc_html__('Query', 'charity-is-hope'),
						"class" => "",
						"value" => array_flip((array)charity_is_hope_get_sc_param('sorting')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Post order", 'charity-is-hope'),
						"description" => esc_html__("Select desired posts order", 'charity-is-hope'),
						"group" => esc_html__('Query', 'charity-is-hope'),
						"class" => "",
						"value" => array_flip((array)charity_is_hope_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("client's IDs list", 'charity-is-hope'),
						"description" => esc_html__("Comma separated list of donation's ID. If set - parameters above (category, count, order, etc.)  are ignored!", 'charity-is-hope'),
						"group" => esc_html__('Query', 'charity-is-hope'),
						'dependency' => array(
							'element' => 'cats',
							'is_empty' => true
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),

					charity_is_hope_get_vc_param('id'),
					charity_is_hope_get_vc_param('class'),
					charity_is_hope_get_vc_param('css'),
				)
			) );
			
		class WPBakeryShortCode_Trx_Donations_List extends CHARITY_IS_HOPE_VC_ShortCodeSingle {}

	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'charity_is_hope_trx_donations_required_plugins' ) ) {
	//Handler of add_filter('charity_is_hope_filter_required_plugins',	'charity_is_hope_trx_donations_required_plugins');
	function charity_is_hope_trx_donations_required_plugins($list=array()) {
		if (in_array('trx_donations', (array)charity_is_hope_storage_get('required_plugins'))) {
			$path = charity_is_hope_get_file_dir('plugins/install/trx_donations.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('Donations', 'charity-is-hope'),
					'slug' 		=> 'trx_donations',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check in the required plugins
if ( !function_exists( 'charity_is_hope_trx_donations_importer_required_plugins' ) ) {
	//Handler of add_filter( 'charity_is_hope_filter_importer_required_plugins',	'charity_is_hope_trx_donations_importer_required_plugins', 10, 2 );
	function charity_is_hope_trx_donations_importer_required_plugins($not_installed='', $list='') {
		if (charity_is_hope_strpos($list, 'trx_donations')!==false && !charity_is_hope_exists_trx_donations() )
			$not_installed .= '<br>' . esc_html__('Donations', 'charity-is-hope');
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'charity_is_hope_trx_donations_importer_set_options' ) ) {
	//Handler of add_filter( 'charity_is_hope_filter_importer_options',	'charity_is_hope_trx_donations_importer_set_options' );
	function charity_is_hope_trx_donations_importer_set_options($options=array()) {
		if ( in_array('trx_donations', (array)charity_is_hope_storage_get('required_plugins')) && charity_is_hope_exists_trx_donations() ) {
			// Add slugs to export options for this plugin
			$options['additional_options'][] = 'trx_donations_options';
		}
		return $options;
	}
}
?>