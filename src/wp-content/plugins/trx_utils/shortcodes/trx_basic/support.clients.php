<?php
/**
 * Charity Is Hope Framework: Clients support
 *
 * @package	charity_is_hope
 * @since	charity_is_hope 1.0
 */

// Theme init
if (!function_exists('charity_is_hope_clients_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_clients_theme_setup', 1 );
	function charity_is_hope_clients_theme_setup() {

		// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
		add_filter('charity_is_hope_filter_get_blog_type',			'charity_is_hope_clients_get_blog_type', 9, 2);
		add_filter('charity_is_hope_filter_get_blog_title',		'charity_is_hope_clients_get_blog_title', 9, 2);
		add_filter('charity_is_hope_filter_get_current_taxonomy',	'charity_is_hope_clients_get_current_taxonomy', 9, 2);
		add_filter('charity_is_hope_filter_is_taxonomy',			'charity_is_hope_clients_is_taxonomy', 9, 2);
		add_filter('charity_is_hope_filter_get_stream_page_title',	'charity_is_hope_clients_get_stream_page_title', 9, 2);
		add_filter('charity_is_hope_filter_get_stream_page_link',	'charity_is_hope_clients_get_stream_page_link', 9, 2);
		add_filter('charity_is_hope_filter_get_stream_page_id',	'charity_is_hope_clients_get_stream_page_id', 9, 2);
		add_filter('charity_is_hope_filter_query_add_filters',		'charity_is_hope_clients_query_add_filters', 9, 2);
		add_filter('charity_is_hope_filter_detect_inheritance_key','charity_is_hope_clients_detect_inheritance_key', 9, 1);

		// Extra column for clients lists
		if (charity_is_hope_get_theme_option('show_overriden_posts')=='yes') {
			add_filter('manage_edit-clients_columns',			'charity_is_hope_post_add_options_column', 9);
			add_filter('manage_clients_posts_custom_column',	'charity_is_hope_post_fill_options_column', 9, 2);
		}

		// Registar shortcodes [trx_clients] and [trx_clients_item] in the shortcodes list
		add_action('charity_is_hope_action_shortcodes_list',		'charity_is_hope_clients_reg_shortcodes');
		if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer())
			add_action('charity_is_hope_action_shortcodes_list_vc','charity_is_hope_clients_reg_shortcodes_vc');
		
		// Add supported data types
		charity_is_hope_theme_support_pt('clients');
		charity_is_hope_theme_support_tx('clients_group');
	}
}

if ( !function_exists( 'charity_is_hope_clients_settings_theme_setup2' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_clients_settings_theme_setup2', 3 );
	function charity_is_hope_clients_settings_theme_setup2() {
		// Add post type 'clients' and taxonomy 'clients_group' into theme inheritance list
		charity_is_hope_add_theme_inheritance( array('clients' => array(
			'stream_template' => 'blog-clients',
			'single_template' => 'single-client',
			'taxonomy' => array('clients_group'),
			'taxonomy_tags' => array(),
			'post_type' => array('clients'),
			'override' => 'custom'
			) )
		);
	}
}


if (!function_exists('charity_is_hope_clients_after_theme_setup')) {
	add_action( 'charity_is_hope_action_after_init_theme', 'charity_is_hope_clients_after_theme_setup' );
	function charity_is_hope_clients_after_theme_setup() {
		// Update fields in the override options
		if (charity_is_hope_storage_get_array('post_override_options', 'page')=='clients') {
			// Meta box fields
			charity_is_hope_storage_set_array('post_override_options', 'title', esc_html__('Client Options', 'trx_utils'));
			charity_is_hope_storage_set_array('post_override_options', 'fields', array(
				"mb_partition_clients" => array(
					"title" => esc_html__('Clients', 'trx_utils'),
					"override" => "page,post,custom",
					"divider" => false,
					"icon" => "iconadmin-users",
					"type" => "partition"),
				"mb_info_clients_1" => array(
					"title" => esc_html__('Client details', 'trx_utils'),
					"override" => "page,post,custom",
					"divider" => false,
					"desc" => wp_kses_data( __('In this section you can put details for this client', 'trx_utils') ),
					"class" => "client_meta",
					"type" => "info"),
				"client_name" => array(
					"title" => esc_html__('Contact name',  'trx_utils'),
					"desc" => wp_kses_data( __("Name of the contacts manager", 'trx_utils') ),
					"override" => "page,post,custom",
					"class" => "client_name",
					"std" => '',
					"type" => "text"),
				"client_position" => array(
					"title" => esc_html__('Position',  'trx_utils'),
					"desc" => wp_kses_data( __("Position of the contacts manager", 'trx_utils') ),
					"override" => "page,post,custom",
					"class" => "client_position",
					"std" => '',
					"type" => "text"),
				"client_show_link" => array(
					"title" => esc_html__('Show link',  'trx_utils'),
					"desc" => wp_kses_data( __("Show link to client page", 'trx_utils') ),
					"override" => "page,post,custom",
					"class" => "client_show_link",
					"std" => "no",
					"options" => charity_is_hope_get_list_yesno(),
					"type" => "switch"),
				"client_link" => array(
					"title" => esc_html__('Link',  'trx_utils'),
					"desc" => wp_kses_data( __("URL of the client's site. If empty - use link to this page", 'trx_utils') ),
					"override" => "page,post,custom",
					"class" => "client_link",
					"std" => '',
					"type" => "text")
				)
			);
		}
	}
}


// Return true, if current page is clients page
if ( !function_exists( 'charity_is_hope_is_clients_page' ) ) {
	function charity_is_hope_is_clients_page() {
		$is = in_array(charity_is_hope_storage_get('page_template'), array('blog-clients', 'single-client'));
		if (!$is) {
			if (!charity_is_hope_storage_empty('pre_query'))
				$is = charity_is_hope_storage_call_obj_method('pre_query', 'get', 'post_type')=='clients'
						|| charity_is_hope_storage_call_obj_method('pre_query', 'is_tax', 'clients_group') 
						|| (charity_is_hope_storage_call_obj_method('pre_query', 'is_page') 
							&& ($id=charity_is_hope_get_template_page_id('blog-clients')) > 0 
							&& $id==charity_is_hope_storage_get_obj_property('pre_query', 'queried_object_id', 0)
							);
			else
				$is = get_query_var('post_type')=='clients' 
						|| is_tax('clients_group') 
						|| (is_page() && ($id=charity_is_hope_get_template_page_id('blog-clients')) > 0 && $id==get_the_ID());
		}
		return $is;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'charity_is_hope_clients_detect_inheritance_key' ) ) {
	//Handler of add_filter('charity_is_hope_filter_detect_inheritance_key',	'charity_is_hope_clients_detect_inheritance_key', 9, 1);
	function charity_is_hope_clients_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return charity_is_hope_is_clients_page() ? 'clients' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'charity_is_hope_clients_get_blog_type' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_blog_type',	'charity_is_hope_clients_get_blog_type', 9, 2);
	function charity_is_hope_clients_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->is_tax('clients_group') || is_tax('clients_group'))
			$page = 'clients_category';
		else if ($query && $query->get('post_type')=='clients' || get_query_var('post_type')=='clients')
			$page = $query && $query->is_single() || is_single() ? 'clients_item' : 'clients';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'charity_is_hope_clients_get_blog_title' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_blog_title',	'charity_is_hope_clients_get_blog_title', 9, 2);
	function charity_is_hope_clients_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( charity_is_hope_strpos($page, 'clients')!==false ) {
			if ( $page == 'clients_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'clients_group' ), 'clients_group', OBJECT);
				$title = $term->name;
			} else if ( $page == 'clients_item' ) {
				$title = charity_is_hope_get_post_title();
			} else {
				$title = esc_html__('All clients', 'trx_utils');
			}
		}
		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'charity_is_hope_clients_get_stream_page_title' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_stream_page_title',	'charity_is_hope_clients_get_stream_page_title', 9, 2);
	function charity_is_hope_clients_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (charity_is_hope_strpos($page, 'clients')!==false) {
			if (($page_id = charity_is_hope_clients_get_stream_page_id(0, $page=='clients' ? 'blog-clients' : $page)) > 0)
				$title = charity_is_hope_get_post_title($page_id);
			else
				$title = esc_html__('All clients', 'trx_utils');				
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'charity_is_hope_clients_get_stream_page_id' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_stream_page_id',	'charity_is_hope_clients_get_stream_page_id', 9, 2);
	function charity_is_hope_clients_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (charity_is_hope_strpos($page, 'clients')!==false) $id = charity_is_hope_get_template_page_id('blog-clients');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'charity_is_hope_clients_get_stream_page_link' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_stream_page_link',	'charity_is_hope_clients_get_stream_page_link', 9, 2);
	function charity_is_hope_clients_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (charity_is_hope_strpos($page, 'clients')!==false) {
			$id = charity_is_hope_get_template_page_id('blog-clients');
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'charity_is_hope_clients_get_current_taxonomy' ) ) {
	//Handler of add_filter('charity_is_hope_filter_get_current_taxonomy',	'charity_is_hope_clients_get_current_taxonomy', 9, 2);
	function charity_is_hope_clients_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( charity_is_hope_strpos($page, 'clients')!==false ) {
			$tax = 'clients_group';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'charity_is_hope_clients_is_taxonomy' ) ) {
	//Handler of add_filter('charity_is_hope_filter_is_taxonomy',	'charity_is_hope_clients_is_taxonomy', 9, 2);
	function charity_is_hope_clients_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query && $query->get('clients_group')!='' || is_tax('clients_group') ? 'clients_group' : '';
	}
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'charity_is_hope_clients_query_add_filters' ) ) {
	//Handler of add_filter('charity_is_hope_filter_query_add_filters',	'charity_is_hope_clients_query_add_filters', 9, 2);
	function charity_is_hope_clients_query_add_filters($args, $filter) {
		if ($filter == 'clients') {
			$args['post_type'] = 'clients';
		}
		return $args;
	}
}





// ---------------------------------- [trx_clients] ---------------------------------------

/*
[trx_clients id="unique_id" columns="3" style="clients-1|clients-2|..."]
	[trx_clients_item name="client name" position="director" image="url"]Description text[/trx_clients_item]
	...
[/trx_clients]
*/
if ( !function_exists( 'charity_is_hope_sc_clients' ) ) {
	function charity_is_hope_sc_clients($atts, $content=null){	
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "clients-1",
			"columns" => 4,
			"slider" => "no",
			"slides_space" => 0,
			"controls" => "no",
			"interval" => "",
			"autoheight" => "no",
			"custom" => "no",
			"ids" => "",
			"cat" => "",
			"count" => 4,
			"offset" => "",
			"orderby" => "title",
			"order" => "asc",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link_caption" => esc_html__('Learn more', 'trx_utils'),
			"link" => '',
			"scheme" => '',
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));

		if (empty($id)) $id = "sc_clients_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";
		if (!empty($height) && charity_is_hope_param_is_on($autoheight)) $autoheight = "no";
		if (empty($interval)) $interval = mt_rand(5000, 10000);

		$class .= ($class ? ' ' : '') . charity_is_hope_get_css_position_as_classes($top, $right, $bottom, $left);

		$ws = charity_is_hope_get_css_dimensions_from_values($width);
		$hs = charity_is_hope_get_css_dimensions_from_values('', $height);
		$css .= ($hs) . ($ws);

		if (charity_is_hope_param_is_on($slider)) charity_is_hope_enqueue_slider('swiper');
	
		$columns = max(1, min(12, $columns));
		$count = max(1, (int) $count);
		if (charity_is_hope_param_is_off($custom) && $count < $columns) $columns = $count;
		charity_is_hope_storage_set('sc_clients_data', array(
			'id'=>$id,
            'style'=>$style,
            'counter'=>0,
            'columns'=>$columns,
            'slider'=>$slider,
            'css_wh'=>$ws . $hs
            )
        );

		$output = '<div' . ($id ? ' id="'.esc_attr($id).'_wrap"' : '') 
						. ' class="sc_clients_wrap'
						. ($scheme && !charity_is_hope_param_is_off($scheme) && !charity_is_hope_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
						.'">'
					. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_clients sc_clients_style_'.esc_attr($style)
							. ' ' . esc_attr(charity_is_hope_get_template_property($style, 'container_classes'))
							. (!empty($class) ? ' '.esc_attr($class) : '')
						.'"'
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
						. (!charity_is_hope_param_is_off($animation) ? ' data-animation="'.esc_attr(charity_is_hope_get_animation_classes($animation)).'"' : '')
					. '>'
					. (!empty($subtitle) ? '<h6 class="sc_clients_subtitle sc_item_subtitle">' . trim(charity_is_hope_strmacros($subtitle)) . '</h6>' : '')
					. (!empty($title) ? '<h2 class="sc_clients_title sc_item_title' . (empty($description) ? ' sc_item_title_without_descr' : ' sc_item_title_without_descr') . '">' . trim(charity_is_hope_strmacros($title)) . '</h2>' : '')
					. (!empty($description) ? '<div class="sc_clients_descr sc_item_descr">' . trim(charity_is_hope_strmacros($description)) . '</div>' : '')
					. (charity_is_hope_param_is_on($slider) 
						? ('<div class="sc_slider_swiper swiper-slider-container'
										. ' ' . esc_attr(charity_is_hope_get_slider_controls_classes($controls))
										. (charity_is_hope_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
										. ($hs ? ' sc_slider_height_fixed' : '')
										. '"'
									. (!empty($width) && charity_is_hope_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
									. (!empty($height) && charity_is_hope_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
									. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
									. ($columns > 1 ? ' data-slides-per-view="' . esc_attr($columns) . '"' : '')
									. ($slides_space > 0 ? ' data-slides-space="' . esc_attr($slides_space) . '"' : '')
									. ' data-slides-min-width="' . ($style=='clients-1' ? 100 : 220) . '"'
								. '>'
							. '<div class="slides swiper-wrapper">')
						: ($columns > 1 
							? '<div class="sc_columns columns_wrap">' 
							: '')
						);
	
		if (charity_is_hope_param_is_on($custom) && $content) {
			$output .= do_shortcode($content);
		} else {
			global $post;
	
			if (!empty($ids)) {
				$posts = explode(',', $ids);
				$count = count($posts);
			}
			
			$args = array(
				'post_type' => 'clients',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='asc' ? 'asc' : 'desc',
			);
		
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
		
			$args = charity_is_hope_query_add_sort_order($args, $orderby, $order);
			$args = charity_is_hope_query_add_posts_and_cats($args, $ids, 'clients', $cat, 'clients_group');

			$query = new WP_Query( $args );
	
			$post_number = 0;

			while ( $query->have_posts() ) { 
				$query->the_post();
				$post_number++;
				$args = array(
					'layout' => $style,
					'show' => false,
					'number' => $post_number,
					'posts_on_page' => ($count > 0 ? $count : $query->found_posts),
					"descr" => charity_is_hope_get_custom_option('post_excerpt_maxlength'.($columns > 1 ? '_masonry' : '')),
					"orderby" => $orderby,
					'content' => false,
					'terms_list' => false,
					'columns_count' => $columns,
					'slider' => $slider,
					'tag_id' => $id ? $id . '_' . $post_number : '',
					'tag_class' => '',
					'tag_animation' => '',
					'tag_css' => '',
					'tag_css_wh' => $ws . $hs
				);
				$post_data = charity_is_hope_get_post_data($args);
				$post_meta = get_post_meta($post_data['post_id'], charity_is_hope_storage_get('options_prefix') . '_post_options', true);
				$thumb_sizes = charity_is_hope_get_thumb_sizes(array('layout' => $style));
				$args['client_name'] = $post_meta['client_name'];
				$args['client_position'] = $post_meta['client_position'];
				$args['client_image'] = $post_data['post_thumb'];
				$args['client_link'] = charity_is_hope_param_is_on('client_show_link')
					? (!empty($post_meta['client_link']) ? $post_meta['client_link'] : $post_data['post_link'])
					: '';
				$output .= charity_is_hope_show_post_layout($args, $post_data);
			}
			wp_reset_postdata();
		}
	
		if (charity_is_hope_param_is_on($slider)) {
			$output .= '</div>'
				. '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>'
				. '<div class="sc_slider_pagination_wrap"></div>'
				. '</div>';
		} else if ($columns > 1) {
			$output .= '</div>';
		}

		$output .= (!empty($link) ? '<div class="sc_clients_button sc_item_button">'.charity_is_hope_do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
				. '</div><!-- /.sc_clients -->'
			. '</div><!-- /.sc_clients_wrap -->';
	
		// Add template specific scripts and styles
		do_action('charity_is_hope_action_blog_scripts', $style);
	
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_clients', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_clients', 'charity_is_hope_sc_clients');
}


if ( !function_exists( 'charity_is_hope_sc_clients_item' ) ) {
	function charity_is_hope_sc_clients_item($atts, $content=null) {
		if (charity_is_hope_in_shortcode_blogger()) return '';
		extract(charity_is_hope_html_decode(shortcode_atts( array(
			// Individual params
			"name" => "",
			"position" => "",
			"image" => "",
			"link" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => ""
		), $atts)));
	
		charity_is_hope_storage_inc_array('sc_clients_data', 'counter');
	
		$id = $id ? $id : (charity_is_hope_storage_get_array('sc_clients_data', 'id') ? charity_is_hope_storage_get_array('sc_clients_data', 'id') . '_' . charity_is_hope_storage_get_array('sc_clients_data', 'counter') : '');
	
		$descr = trim(chop(do_shortcode($content)));
	
		$thumb_sizes = charity_is_hope_get_thumb_sizes(array('layout' => charity_is_hope_storage_get_array('sc_clients_data', 'style')));

		if ($image > 0) {
			$attach = wp_get_attachment_image_src( $image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$image = $attach[0];
		}
		$image = charity_is_hope_get_resized_image_tag($image, $thumb_sizes['w'], $thumb_sizes['h']);

		$post_data = array(
			'post_title' => $name,
			'post_excerpt' => $descr
		);
		$args = array(
			'layout' => charity_is_hope_storage_get_array('sc_clients_data', 'style'),
			'number' => charity_is_hope_storage_get_array('sc_clients_data', 'counter'),
			'columns_count' => charity_is_hope_storage_get_array('sc_clients_data', 'columns'),
			'slider' => charity_is_hope_storage_get_array('sc_clients_data', 'slider'),
			'show' => false,
			'descr'  => 0,
			'tag_id' => $id,
			'tag_class' => $class,
			'tag_animation' => $animation,
			'tag_css' => $css,
			'tag_css_wh' => charity_is_hope_storage_get_array('sc_clients_data', 'css_wh'),
			'client_position' => $position,
			'client_link' => $link,
			'client_image' => $image
		);
		$output = charity_is_hope_show_post_layout($args, $post_data);
		return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_clients_item', $atts, $content);
	}
	charity_is_hope_require_shortcode('trx_clients_item', 'charity_is_hope_sc_clients_item');
}
// ---------------------------------- [/trx_clients] ---------------------------------------



// Add [trx_clients] and [trx_clients_item] in the shortcodes list
if (!function_exists('charity_is_hope_clients_reg_shortcodes')) {
	//Handler of add_filter('charity_is_hope_action_shortcodes_list',	'charity_is_hope_clients_reg_shortcodes');
	function charity_is_hope_clients_reg_shortcodes() {
		if (charity_is_hope_storage_isset('shortcodes')) {

			$users = charity_is_hope_get_list_users();
			$members = charity_is_hope_get_list_posts(false, array(
				'post_type'=>'clients',
				'orderby'=>'title',
				'order'=>'asc',
				'return'=>'title'
				)
			);
			$clients_groups = charity_is_hope_get_list_terms(false, 'clients_group');
			$clients_styles = charity_is_hope_get_list_templates('clients');
			$controls 		= charity_is_hope_get_list_slider_controls();

			charity_is_hope_sc_map_after('trx_chat', array(

				// Clients
				"trx_clients" => array(
					"title" => esc_html__("Clients", 'trx_utils'),
					"desc" => wp_kses_data( __("Insert clients list in your page (post)", 'trx_utils') ),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", 'trx_utils'),
							"desc" => wp_kses_data( __("Title for the block", 'trx_utils') ),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", 'trx_utils'),
							"desc" => wp_kses_data( __("Subtitle for the block", 'trx_utils') ),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", 'trx_utils'),
							"desc" => wp_kses_data( __("Short description for the block", 'trx_utils') ),
							"value" => "",
							"type" => "textarea"
						),
						"style" => array(
							"title" => esc_html__("Clients style", 'trx_utils'),
							"desc" => wp_kses_data( __("Select style to display clients list", 'trx_utils') ),
							"value" => "clients-1",
							"type" => "select",
							"options" => $clients_styles
						),
						"columns" => array(
							"title" => esc_html__("Columns", 'trx_utils'),
							"desc" => wp_kses_data( __("How many columns use to show clients", 'trx_utils') ),
							"value" => 4,
							"min" => 2,
							"max" => 6,
							"step" => 1,
							"type" => "spinner"
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", 'trx_utils'),
							"desc" => wp_kses_data( __("Select color scheme for this block", 'trx_utils') ),
							"value" => "",
							"type" => "checklist",
							"options" => charity_is_hope_get_sc_param('schemes')
						),
						"slider" => array(
							"title" => esc_html__("Slider", 'trx_utils'),
							"desc" => wp_kses_data( __("Use slider to show clients", 'trx_utils') ),
							"value" => "no",
							"type" => "switch",
							"options" => charity_is_hope_get_sc_param('yes_no')
						),
						"controls" => array(
							"title" => esc_html__("Controls", 'trx_utils'),
							"desc" => wp_kses_data( __("Slider controls style and position", 'trx_utils') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"divider" => true,
							"value" => "no",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $controls
						),
						"slides_space" => array(
							"title" => esc_html__("Space between slides", 'trx_utils'),
							"desc" => wp_kses_data( __("Size of space (in px) between slides", 'trx_utils') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 0,
							"min" => 0,
							"max" => 100,
							"step" => 10,
							"type" => "spinner"
						),
						"interval" => array(
							"title" => esc_html__("Slides change interval", 'trx_utils'),
							"desc" => wp_kses_data( __("Slides change interval (in milliseconds: 1000ms = 1s)", 'trx_utils') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 7000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"autoheight" => array(
							"title" => esc_html__("Autoheight", 'trx_utils'),
							"desc" => wp_kses_data( __("Change whole slider's height (make it equal current slide's height)", 'trx_utils') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => "no",
							"type" => "switch",
							"options" => charity_is_hope_get_sc_param('yes_no')
						),
						"custom" => array(
							"title" => esc_html__("Custom", 'trx_utils'),
							"desc" => wp_kses_data( __("Allow get team members from inner shortcodes (custom) or get it from specified group (cat)", 'trx_utils') ),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => charity_is_hope_get_sc_param('yes_no')
						),
						"cat" => array(
							"title" => esc_html__("Categories", 'trx_utils'),
							"desc" => wp_kses_data( __("Select categories (groups) to show team members. If empty - select team members from any category (group) or from IDs list", 'trx_utils') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => charity_is_hope_array_merge(array(0 => esc_html__('- Select category -', 'trx_utils')), $clients_groups)
						),
						"count" => array(
							"title" => esc_html__("Number of posts", 'trx_utils'),
							"desc" => wp_kses_data( __("How many posts will be displayed? If used IDs - this parameter ignored.", 'trx_utils') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 4,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => esc_html__("Offset before select posts", 'trx_utils'),
							"desc" => wp_kses_data( __("Skip posts before select next part.", 'trx_utils') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Post order by", 'trx_utils'),
							"desc" => wp_kses_data( __("Select desired posts sorting method", 'trx_utils') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "title",
							"type" => "select",
							"options" => charity_is_hope_get_sc_param('sorting')
						),
						"order" => array(
							"title" => esc_html__("Post order", 'trx_utils'),
							"desc" => wp_kses_data( __("Select desired posts order", 'trx_utils') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "asc",
							"type" => "switch",
							"size" => "big",
							"options" => charity_is_hope_get_sc_param('ordering')
						),
						"ids" => array(
							"title" => esc_html__("Post IDs list", 'trx_utils'),
							"desc" => wp_kses_data( __("Comma separated list of posts ID. If set - parameters above are ignored!", 'trx_utils') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "",
							"type" => "text"
						),
						"link" => array(
							"title" => esc_html__("Button URL", 'trx_utils'),
							"desc" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'trx_utils') ),
							"value" => "",
							"type" => "text"
						),
						"link_caption" => array(
							"title" => esc_html__("Button caption", 'trx_utils'),
							"desc" => wp_kses_data( __("Caption for the button at the bottom of the block", 'trx_utils') ),
							"value" => "",
							"type" => "text"
						),
						"width" => charity_is_hope_shortcodes_width(),
						"height" => charity_is_hope_shortcodes_height(),
						"top" => charity_is_hope_get_sc_param('top'),
						"bottom" => charity_is_hope_get_sc_param('bottom'),
						"left" => charity_is_hope_get_sc_param('left'),
						"right" => charity_is_hope_get_sc_param('right'),
						"id" => charity_is_hope_get_sc_param('id'),
						"class" => charity_is_hope_get_sc_param('class'),
						"animation" => charity_is_hope_get_sc_param('animation'),
						"css" => charity_is_hope_get_sc_param('css')
					),
					"children" => array(
						"name" => "trx_clients_item",
						"title" => esc_html__("Client", 'trx_utils'),
						"desc" => wp_kses_data( __("Single client (custom parameters)", 'trx_utils') ),
						"container" => true,
						"params" => array(
							"name" => array(
								"title" => esc_html__("Name", 'trx_utils'),
								"desc" => wp_kses_data( __("Client's name", 'trx_utils') ),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"position" => array(
								"title" => esc_html__("Position", 'trx_utils'),
								"desc" => wp_kses_data( __("Client's position", 'trx_utils') ),
								"value" => "",
								"type" => "text"
							),
							"link" => array(
								"title" => esc_html__("Link", 'trx_utils'),
								"desc" => wp_kses_data( __("Link on client's personal page", 'trx_utils') ),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"image" => array(
								"title" => esc_html__("Image", 'trx_utils'),
								"desc" => wp_kses_data( __("Client's image", 'trx_utils') ),
								"value" => "",
								"readonly" => false,
								"type" => "media"
							),
							"_content_" => array(
								"title" => esc_html__("Description", 'trx_utils'),
								"desc" => wp_kses_data( __("Client's short description", 'trx_utils') ),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => charity_is_hope_get_sc_param('id'),
							"class" => charity_is_hope_get_sc_param('class'),
							"animation" => charity_is_hope_get_sc_param('animation'),
							"css" => charity_is_hope_get_sc_param('css')
						)
					)
				)

			));
		}
	}
}


// Add [trx_clients] and [trx_clients_item] in the VC shortcodes list
if (!function_exists('charity_is_hope_clients_reg_shortcodes_vc')) {
	//Handler of add_filter('charity_is_hope_action_shortcodes_list_vc',	'charity_is_hope_clients_reg_shortcodes_vc');
	function charity_is_hope_clients_reg_shortcodes_vc() {

		$clients_groups = charity_is_hope_get_list_terms(false, 'clients_group');
		$clients_styles = charity_is_hope_get_list_templates('clients');
		$controls		= charity_is_hope_get_list_slider_controls();

		// Clients
		vc_map( array(
				"base" => "trx_clients",
				"name" => esc_html__("Clients", 'trx_utils'),
				"description" => wp_kses_data( __("Insert clients list", 'trx_utils') ),
				"category" => esc_html__('Content', 'trx_utils'),
				'icon' => 'icon_trx_clients',
				"class" => "trx_sc_columns trx_sc_clients",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_clients_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Clients style", 'trx_utils'),
						"description" => wp_kses_data( __("Select style to display clients list", 'trx_utils') ),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($clients_styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", 'trx_utils'),
						"description" => wp_kses_data( __("Select color scheme for this block", 'trx_utils') ),
						"class" => "",
						"value" => array_flip(charity_is_hope_get_sc_param('schemes')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slider",
						"heading" => esc_html__("Slider", 'trx_utils'),
						"description" => wp_kses_data( __("Use slider to show testimonials", 'trx_utils') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'trx_utils'),
						"class" => "",
						"std" => "no",
						"value" => array_flip(charity_is_hope_get_sc_param('yes_no')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Controls", 'trx_utils'),
						"description" => wp_kses_data( __("Slider controls style and position", 'trx_utils') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'trx_utils'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"std" => "no",
						"value" => array_flip($controls),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slides_space",
						"heading" => esc_html__("Space between slides", 'trx_utils'),
						"description" => wp_kses_data( __("Size of space (in px) between slides", 'trx_utils') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'trx_utils'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "interval",
						"heading" => esc_html__("Slides change interval", 'trx_utils'),
						"description" => wp_kses_data( __("Slides change interval (in milliseconds: 1000ms = 1s)", 'trx_utils') ),
						"group" => esc_html__('Slider', 'trx_utils'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "autoheight",
						"heading" => esc_html__("Autoheight", 'trx_utils'),
						"description" => wp_kses_data( __("Change whole slider's height (make it equal current slide's height)", 'trx_utils') ),
						"group" => esc_html__('Slider', 'trx_utils'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => array("Autoheight" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom", 'trx_utils'),
						"description" => wp_kses_data( __("Allow get clients from inner shortcodes (custom) or get it from specified group (cat)", 'trx_utils') ),
						"class" => "",
						"value" => array("Custom clients" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", 'trx_utils'),
						"description" => wp_kses_data( __("Title for the block", 'trx_utils') ),
						"admin_label" => true,
						"group" => esc_html__('Captions', 'trx_utils'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", 'trx_utils'),
						"description" => wp_kses_data( __("Subtitle for the block", 'trx_utils') ),
						"group" => esc_html__('Captions', 'trx_utils'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", 'trx_utils'),
						"description" => wp_kses_data( __("Description for the block", 'trx_utils') ),
						"group" => esc_html__('Captions', 'trx_utils'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					array(
						"param_name" => "cat",
						"heading" => esc_html__("Categories", 'trx_utils'),
						"description" => wp_kses_data( __("Select category to show clients. If empty - select clients from any category (group) or from IDs list", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip(charity_is_hope_array_merge(array(0 => esc_html__('- Select category -', 'trx_utils')), $clients_groups)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'trx_utils'),
						"description" => wp_kses_data( __("How many columns use to show clients", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Number of posts", 'trx_utils'),
						"description" => wp_kses_data( __("How many posts will be displayed? If used IDs - this parameter ignored.", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => esc_html__("Offset before select posts", 'trx_utils'),
						"description" => wp_kses_data( __("Skip posts before select next part.", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Post sorting", 'trx_utils'),
						"description" => wp_kses_data( __("Select desired posts sorting method", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"std" => "title",
						"class" => "",
						"value" => array_flip(charity_is_hope_get_sc_param('sorting')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Post order", 'trx_utils'),
						"description" => wp_kses_data( __("Select desired posts order", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"std" => "asc",
						"class" => "",
						"value" => array_flip(charity_is_hope_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("client's IDs list", 'trx_utils'),
						"description" => wp_kses_data( __("Comma separated list of client's ID. If set - parameters above (category, count, order, etc.)  are ignored!", 'trx_utils') ),
						"group" => esc_html__('Query', 'trx_utils'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Button URL", 'trx_utils'),
						"description" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'trx_utils') ),
						"group" => esc_html__('Captions', 'trx_utils'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link_caption",
						"heading" => esc_html__("Button caption", 'trx_utils'),
						"description" => wp_kses_data( __("Caption for the button at the bottom of the block", 'trx_utils') ),
						"group" => esc_html__('Captions', 'trx_utils'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					charity_is_hope_vc_width(),
					charity_is_hope_vc_height(),
					charity_is_hope_get_vc_param('margin_top'),
					charity_is_hope_get_vc_param('margin_bottom'),
					charity_is_hope_get_vc_param('margin_left'),
					charity_is_hope_get_vc_param('margin_right'),
					charity_is_hope_get_vc_param('id'),
					charity_is_hope_get_vc_param('class'),
					charity_is_hope_get_vc_param('animation'),
					charity_is_hope_get_vc_param('css')
				),
				'js_view' => 'VcTrxColumnsView'
			) );
			
			
		vc_map( array(
				"base" => "trx_clients_item",
				"name" => esc_html__("Client", 'trx_utils'),
				"description" => wp_kses_data( __("Client - all data pull out from it account on your site", 'trx_utils') ),
				"show_settings_on_create" => true,
				"class" => "trx_sc_collection trx_sc_column_item trx_sc_clients_item",
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_clients_item',
				"as_child" => array('only' => 'trx_clients'),
				"as_parent" => array('except' => 'trx_clients'),
				"params" => array(
					array(
						"param_name" => "name",
						"heading" => esc_html__("Name", 'trx_utils'),
						"description" => wp_kses_data( __("Client's name", 'trx_utils') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "position",
						"heading" => esc_html__("Position", 'trx_utils'),
						"description" => wp_kses_data( __("Client's position", 'trx_utils') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link", 'trx_utils'),
						"description" => wp_kses_data( __("Link on client's personal page", 'trx_utils') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Client's image", 'trx_utils'),
						"description" => wp_kses_data( __("Clients's image", 'trx_utils') ),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					charity_is_hope_get_vc_param('id'),
					charity_is_hope_get_vc_param('class'),
					charity_is_hope_get_vc_param('animation'),
					charity_is_hope_get_vc_param('css')
				),
				'js_view' => 'VcTrxColumnItemView'
			) );
			
		class WPBakeryShortCode_Trx_Clients extends CHARITY_IS_HOPE_VC_ShortCodeColumns {}
		class WPBakeryShortCode_Trx_Clients_Item extends CHARITY_IS_HOPE_VC_ShortCodeCollection {}

	}
}
?>