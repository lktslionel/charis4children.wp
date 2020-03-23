<?php
/**
 * Charity Is Hope Framework: return lists
 *
 * @package charity_is_hope
 * @since charity_is_hope 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return styles list
if ( !function_exists( 'charity_is_hope_get_list_styles' ) ) {
	function charity_is_hope_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = sprintf(esc_html__('Style %d', 'charity-is-hope'), $i);
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the shortcodes margins
if ( !function_exists( 'charity_is_hope_get_list_margins' ) ) {
	function charity_is_hope_get_list_margins($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_margins'))=='') {
			$list = array(
				'null'		=> esc_html__('0 (No margin)',	'charity-is-hope'),
				'tiny'		=> esc_html__('Tiny',		'charity-is-hope'),
				'small'		=> esc_html__('Small',		'charity-is-hope'),
				'medium'	=> esc_html__('Medium',		'charity-is-hope'),
				'large'		=> esc_html__('Large',		'charity-is-hope'),
				'huge'		=> esc_html__('Huge',		'charity-is-hope'),
				'tiny-'		=> esc_html__('Tiny (negative)',	'charity-is-hope'),
				'small-'	=> esc_html__('Small (negative)',	'charity-is-hope'),
				'medium-'	=> esc_html__('Medium (negative)',	'charity-is-hope'),
				'large-'	=> esc_html__('Large (negative)',	'charity-is-hope'),
				'huge-'		=> esc_html__('Huge (negative)',	'charity-is-hope')
				);
			$list = apply_filters('charity_is_hope_filter_list_margins', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_margins', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the line styles
if ( !function_exists( 'charity_is_hope_get_list_line_styles' ) ) {
	function charity_is_hope_get_list_line_styles($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_line_styles'))=='') {
			$list = array(
				'solid'	=> esc_html__('Solid', 'charity-is-hope'),
				'dashed'=> esc_html__('Dashed', 'charity-is-hope'),
				'dotted'=> esc_html__('Dotted', 'charity-is-hope'),
				'double'=> esc_html__('Double', 'charity-is-hope'),
				'image'	=> esc_html__('Image', 'charity-is-hope')
				);
			$list = apply_filters('charity_is_hope_filter_list_line_styles', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_line_styles', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the animations
if ( !function_exists( 'charity_is_hope_get_list_animations' ) ) {
	function charity_is_hope_get_list_animations($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_animations'))=='') {
			$list = array(
				'none'			=> esc_html__('- None -',	'charity-is-hope'),
				'bounce'		=> esc_html__('Bounce',		'charity-is-hope'),
				'elastic'		=> esc_html__('Elastic',	'charity-is-hope'),
				'flash'			=> esc_html__('Flash',		'charity-is-hope'),
				'flip'			=> esc_html__('Flip',		'charity-is-hope'),
				'pulse'			=> esc_html__('Pulse',		'charity-is-hope'),
				'rubberBand'	=> esc_html__('Rubber Band','charity-is-hope'),
				'shake'			=> esc_html__('Shake',		'charity-is-hope'),
				'swing'			=> esc_html__('Swing',		'charity-is-hope'),
				'tada'			=> esc_html__('Tada',		'charity-is-hope'),
				'wobble'		=> esc_html__('Wobble',		'charity-is-hope')
				);
			$list = apply_filters('charity_is_hope_filter_list_animations', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_animations', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'charity_is_hope_get_list_animations_in' ) ) {
	function charity_is_hope_get_list_animations_in($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_animations_in'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'charity-is-hope'),
				'bounceIn'			=> esc_html__('Bounce In',			'charity-is-hope'),
				'bounceInUp'		=> esc_html__('Bounce In Up',		'charity-is-hope'),
				'bounceInDown'		=> esc_html__('Bounce In Down',		'charity-is-hope'),
				'bounceInLeft'		=> esc_html__('Bounce In Left',		'charity-is-hope'),
				'bounceInRight'		=> esc_html__('Bounce In Right',	'charity-is-hope'),
				'elastic'			=> esc_html__('Elastic In',			'charity-is-hope'),
				'fadeIn'			=> esc_html__('Fade In',			'charity-is-hope'),
				'fadeInUp'			=> esc_html__('Fade In Up',			'charity-is-hope'),
				'fadeInUpSmall'		=> esc_html__('Fade In Up Small',	'charity-is-hope'),
				'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'charity-is-hope'),
				'fadeInDown'		=> esc_html__('Fade In Down',		'charity-is-hope'),
				'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'charity-is-hope'),
				'fadeInLeft'		=> esc_html__('Fade In Left',		'charity-is-hope'),
				'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'charity-is-hope'),
				'fadeInRight'		=> esc_html__('Fade In Right',		'charity-is-hope'),
				'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'charity-is-hope'),
				'flipInX'			=> esc_html__('Flip In X',			'charity-is-hope'),
				'flipInY'			=> esc_html__('Flip In Y',			'charity-is-hope'),
				'lightSpeedIn'		=> esc_html__('Light Speed In',		'charity-is-hope'),
				'rotateIn'			=> esc_html__('Rotate In',			'charity-is-hope'),
				'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','charity-is-hope'),
				'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'charity-is-hope'),
				'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'charity-is-hope'),
				'rotateInDownRight'	=> esc_html__('Rotate In Down Right','charity-is-hope'),
				'rollIn'			=> esc_html__('Roll In',			'charity-is-hope'),
				'slideInUp'			=> esc_html__('Slide In Up',		'charity-is-hope'),
				'slideInDown'		=> esc_html__('Slide In Down',		'charity-is-hope'),
				'slideInLeft'		=> esc_html__('Slide In Left',		'charity-is-hope'),
				'slideInRight'		=> esc_html__('Slide In Right',		'charity-is-hope'),
				'wipeInLeftTop'		=> esc_html__('Wipe In Left Top',	'charity-is-hope'),
				'zoomIn'			=> esc_html__('Zoom In',			'charity-is-hope'),
				'zoomInUp'			=> esc_html__('Zoom In Up',			'charity-is-hope'),
				'zoomInDown'		=> esc_html__('Zoom In Down',		'charity-is-hope'),
				'zoomInLeft'		=> esc_html__('Zoom In Left',		'charity-is-hope'),
				'zoomInRight'		=> esc_html__('Zoom In Right',		'charity-is-hope')
				);
			$list = apply_filters('charity_is_hope_filter_list_animations_in', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_animations_in', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'charity_is_hope_get_list_animations_out' ) ) {
	function charity_is_hope_get_list_animations_out($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_animations_out'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'charity-is-hope'),
				'bounceOut'			=> esc_html__('Bounce Out',			'charity-is-hope'),
				'bounceOutUp'		=> esc_html__('Bounce Out Up',		'charity-is-hope'),
				'bounceOutDown'		=> esc_html__('Bounce Out Down',	'charity-is-hope'),
				'bounceOutLeft'		=> esc_html__('Bounce Out Left',	'charity-is-hope'),
				'bounceOutRight'	=> esc_html__('Bounce Out Right',	'charity-is-hope'),
				'fadeOut'			=> esc_html__('Fade Out',			'charity-is-hope'),
				'fadeOutUp'			=> esc_html__('Fade Out Up',		'charity-is-hope'),
				'fadeOutUpBig'		=> esc_html__('Fade Out Up Big',	'charity-is-hope'),
				'fadeOutDown'		=> esc_html__('Fade Out Down',		'charity-is-hope'),
				'fadeOutDownSmall'	=> esc_html__('Fade Out Down Small','charity-is-hope'),
				'fadeOutDownBig'	=> esc_html__('Fade Out Down Big',	'charity-is-hope'),
				'fadeOutLeft'		=> esc_html__('Fade Out Left',		'charity-is-hope'),
				'fadeOutLeftBig'	=> esc_html__('Fade Out Left Big',	'charity-is-hope'),
				'fadeOutRight'		=> esc_html__('Fade Out Right',		'charity-is-hope'),
				'fadeOutRightBig'	=> esc_html__('Fade Out Right Big',	'charity-is-hope'),
				'flipOutX'			=> esc_html__('Flip Out X',			'charity-is-hope'),
				'flipOutY'			=> esc_html__('Flip Out Y',			'charity-is-hope'),
				'hinge'				=> esc_html__('Hinge Out',			'charity-is-hope'),
				'lightSpeedOut'		=> esc_html__('Light Speed Out',	'charity-is-hope'),
				'rotateOut'			=> esc_html__('Rotate Out',			'charity-is-hope'),
				'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left','charity-is-hope'),
				'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right','charity-is-hope'),
				'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',	'charity-is-hope'),
				'rotateOutDownRight'=> esc_html__('Rotate Out Down Right','charity-is-hope'),
				'rollOut'			=> esc_html__('Roll Out',			'charity-is-hope'),
				'slideOutUp'		=> esc_html__('Slide Out Up',		'charity-is-hope'),
				'slideOutDown'		=> esc_html__('Slide Out Down',		'charity-is-hope'),
				'slideOutLeft'		=> esc_html__('Slide Out Left',		'charity-is-hope'),
				'slideOutRight'		=> esc_html__('Slide Out Right',	'charity-is-hope'),
				'zoomOut'			=> esc_html__('Zoom Out',			'charity-is-hope'),
				'zoomOutUp'			=> esc_html__('Zoom Out Up',		'charity-is-hope'),
				'zoomOutDown'		=> esc_html__('Zoom Out Down',		'charity-is-hope'),
				'zoomOutLeft'		=> esc_html__('Zoom Out Left',		'charity-is-hope'),
				'zoomOutRight'		=> esc_html__('Zoom Out Right',		'charity-is-hope')
				);
			$list = apply_filters('charity_is_hope_filter_list_animations_out', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_animations_out', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('charity_is_hope_get_animation_classes')) {
	function charity_is_hope_get_animation_classes($animation, $speed='normal', $loop='none') {
		return charity_is_hope_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!charity_is_hope_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}


// Return list of the main menu hover effects
if ( !function_exists( 'charity_is_hope_get_list_menu_hovers' ) ) {
	function charity_is_hope_get_list_menu_hovers($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_menu_hovers'))=='') {
			$list = array(
				'fade'			=> esc_html__('Fade',		'charity-is-hope'),
				'slide_line'	=> esc_html__('Slide Line',	'charity-is-hope'),
				'slide_box'		=> esc_html__('Slide Box',	'charity-is-hope'),
				'zoom_line'		=> esc_html__('Zoom Line',	'charity-is-hope'),
				'path_line'		=> esc_html__('Path Line',	'charity-is-hope'),
				'roll_down'		=> esc_html__('Roll Down',	'charity-is-hope'),
				'color_line'	=> esc_html__('Color Line',	'charity-is-hope'),
				);
			$list = apply_filters('charity_is_hope_filter_list_menu_hovers', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_menu_hovers', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the button's hover effects
if ( !function_exists( 'charity_is_hope_get_list_button_hovers' ) ) {
	function charity_is_hope_get_list_button_hovers($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_button_hovers'))=='') {
			$list = array(
				'default'		=> esc_html__('Default',			'charity-is-hope'),
				'fade'			=> esc_html__('Fade',				'charity-is-hope'),
				'slide_left'	=> esc_html__('Slide from Left',	'charity-is-hope'),
				'slide_top'		=> esc_html__('Slide from Top',		'charity-is-hope'),
				'arrow'			=> esc_html__('Arrow',				'charity-is-hope'),
				);
			$list = apply_filters('charity_is_hope_filter_list_button_hovers', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_button_hovers', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the input field's hover effects
if ( !function_exists( 'charity_is_hope_get_list_input_hovers' ) ) {
	function charity_is_hope_get_list_input_hovers($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_input_hovers'))=='') {
			$list = array(
				'default'	=> esc_html__('Default',	'charity-is-hope'),
				'accent'	=> esc_html__('Accented',	'charity-is-hope'),
				'path'		=> esc_html__('Path',		'charity-is-hope'),
				'jump'		=> esc_html__('Jump',		'charity-is-hope'),
				'underline'	=> esc_html__('Underline',	'charity-is-hope'),
				'iconed'	=> esc_html__('Iconed',		'charity-is-hope'),
				);
			$list = apply_filters('charity_is_hope_filter_list_input_hovers', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_input_hovers', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the search field's styles
if ( !function_exists( 'charity_is_hope_get_list_search_styles' ) ) {
	function charity_is_hope_get_list_search_styles($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_search_styles'))=='') {
			$list = array(
				'default'	=> esc_html__('Default',	'charity-is-hope'),
				'fullscreen'=> esc_html__('Fullscreen',	'charity-is-hope'),
				);
			$list = apply_filters('charity_is_hope_filter_list_search_styles', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_search_styles', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of categories
if ( !function_exists( 'charity_is_hope_get_list_categories' ) ) {
	function charity_is_hope_get_list_categories($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_categories'))=='') {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_categories', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'charity_is_hope_get_list_terms' ) ) {
	function charity_is_hope_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		if (($list = charity_is_hope_storage_get('list_taxonomies_'.($taxonomy)))=='') {
			$list = array();
			if ( is_array($taxonomy) || taxonomy_exists($taxonomy) ) {
				$terms = get_terms( $taxonomy, array(
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 0,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => $taxonomy,
					'pad_counts'               => false
					)
				);
			} else {
				$terms = charity_is_hope_get_terms_by_taxonomy_from_db($taxonomy);
			}
			if (!is_wp_error( $terms ) && is_array($terms) && count($terms) > 0) {
				foreach ($terms as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_taxonomies_'.($taxonomy), $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'charity_is_hope_get_list_posts_types' ) ) {
	function charity_is_hope_get_list_posts_types($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_posts_types'))=='') {
			// Return only theme inheritance supported post types
			$list = apply_filters('charity_is_hope_filter_list_post_types', array());
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_posts_types', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'charity_is_hope_get_list_posts' ) ) {
	function charity_is_hope_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (($list = charity_is_hope_storage_get($hash))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'charity-is-hope');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set($hash, $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list pages
if ( !function_exists( 'charity_is_hope_get_list_pages' ) ) {
	function charity_is_hope_get_list_pages($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'title',
			'order'				=> 'asc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));
		return charity_is_hope_get_list_posts($prepend_inherit, $opt);
	}
}


// Return list of registered users
if ( !function_exists( 'charity_is_hope_get_list_users' ) ) {
	function charity_is_hope_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		if (($list = charity_is_hope_storage_get('list_users'))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'charity-is-hope');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_users', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return slider engines list, prepended inherit (if need)
if ( !function_exists( 'charity_is_hope_get_list_sliders' ) ) {
	function charity_is_hope_get_list_sliders($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_sliders'))=='') {
			$list = array(
				'swiper' => esc_html__("Posts slider (Swiper)", 'charity-is-hope')
			);
			$list = apply_filters('charity_is_hope_filter_list_sliders', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_sliders', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return slider controls list, prepended inherit (if need)
if ( !function_exists( 'charity_is_hope_get_list_slider_controls' ) ) {
	function charity_is_hope_get_list_slider_controls($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_slider_controls'))=='') {
			$list = array(
				'no'		=> esc_html__('None', 'charity-is-hope'),
				'side'		=> esc_html__('Side', 'charity-is-hope'),
				'bottom'	=> esc_html__('Bottom', 'charity-is-hope'),
				'pagination'=> esc_html__('Pagination', 'charity-is-hope')
				);
			$list = apply_filters('charity_is_hope_filter_list_slider_controls', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_slider_controls', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return slider controls classes
if ( !function_exists( 'charity_is_hope_get_slider_controls_classes' ) ) {
	function charity_is_hope_get_slider_controls_classes($controls) {
		if (charity_is_hope_param_is_off($controls))	$classes = 'sc_slider_nopagination sc_slider_nocontrols';
		else if ($controls=='bottom')			$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom';
		else if ($controls=='pagination')		$classes = 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_nocontrols';
		else									$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_side';
		return $classes;
	}
}

// Return list with popup engines
if ( !function_exists( 'charity_is_hope_get_list_popup_engines' ) ) {
	function charity_is_hope_get_list_popup_engines($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_popup_engines'))=='') {
			$list = array(
				"pretty"	=> esc_html__("Pretty photo", 'charity-is-hope'),
				"magnific"	=> esc_html__("Magnific popup", 'charity-is-hope')
				);
			$list = apply_filters('charity_is_hope_filter_list_popup_engines', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_popup_engines', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_menus' ) ) {
	function charity_is_hope_get_list_menus($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_menus'))=='') {
			$list = array();
			$list['default'] = esc_html__("Default", 'charity-is-hope');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_menus', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'charity_is_hope_get_list_sidebars' ) ) {
	function charity_is_hope_get_list_sidebars($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_sidebars'))=='') {
			if (($list = charity_is_hope_storage_get('registered_sidebars'))=='') $list = array();
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_sidebars', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'charity_is_hope_get_list_sidebars_positions' ) ) {
	function charity_is_hope_get_list_sidebars_positions($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_sidebars_positions'))=='') {
			$list = array(
				'none'  => esc_html__('Hide',  'charity-is-hope'),
				'left'  => esc_html__('Left',  'charity-is-hope'),
				'right' => esc_html__('Right', 'charity-is-hope')
				);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_sidebars_positions', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'charity_is_hope_get_sidebar_class' ) ) {
	function charity_is_hope_get_sidebar_class() {
		$sb_main = charity_is_hope_get_custom_option('show_sidebar_main');
		$sb_outer = '';
		return (charity_is_hope_param_is_off($sb_main) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($sb_main))
				. ' ' . (charity_is_hope_param_is_off($sb_outer) ? 'sidebar_outer_hide' : '');
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_body_styles' ) ) {
	function charity_is_hope_get_list_body_styles($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_body_styles'))=='') {
			$list = array(
				'boxed'	=> esc_html__('Boxed',		'charity-is-hope'),
				'wide'	=> esc_html__('Wide',		'charity-is-hope')
				);
			if (charity_is_hope_get_theme_setting('allow_fullscreen')) {
				$list['fullwide']	= esc_html__('Fullwide',	'charity-is-hope');
				$list['fullscreen']	= esc_html__('Fullscreen',	'charity-is-hope');
			}
			$list = apply_filters('charity_is_hope_filter_list_body_styles', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_body_styles', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_templates' ) ) {
	function charity_is_hope_get_list_templates($mode='') {
		if (($list = charity_is_hope_storage_get('list_templates_'.($mode)))=='') {
			$list = array();
			$tpl = charity_is_hope_storage_get('registered_templates');
			if (is_array($tpl) && count($tpl) > 0) {
				foreach ($tpl as $k=>$v) {
					if ($mode=='' || in_array($mode, explode(',', $v['mode'])))
						$list[$k] = !empty($v['icon']) 
									? $v['icon'] 
									: (!empty($v['title']) 
										? $v['title'] 
										: charity_is_hope_strtoproper($v['layout'])
										);
				}
			}
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_templates_'.($mode), $list);
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_templates_blog' ) ) {
	function charity_is_hope_get_list_templates_blog($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_templates_blog'))=='') {
			$list = charity_is_hope_get_list_templates('blog');
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_templates_blog', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_templates_blogger' ) ) {
	function charity_is_hope_get_list_templates_blogger($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_templates_blogger'))=='') {
			$list = charity_is_hope_array_merge(charity_is_hope_get_list_templates('blogger'), charity_is_hope_get_list_templates('blog'));
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_templates_blogger', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_templates_single' ) ) {
	function charity_is_hope_get_list_templates_single($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_templates_single'))=='') {
			$list = charity_is_hope_get_list_templates('single');
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_templates_single', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return header styles list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_templates_header' ) ) {
	function charity_is_hope_get_list_templates_header($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_templates_header'))=='') {
			$list = charity_is_hope_get_list_templates('header');
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_templates_header', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return form styles list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_templates_forms' ) ) {
	function charity_is_hope_get_list_templates_forms($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_templates_forms'))=='') {
			$list = charity_is_hope_get_list_templates('forms');
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_templates_forms', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_article_styles' ) ) {
	function charity_is_hope_get_list_article_styles($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_article_styles'))=='') {
			$list = array(
				"boxed"   => esc_html__('Boxed', 'charity-is-hope'),
				"stretch" => esc_html__('Stretch', 'charity-is-hope')
				);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_article_styles', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_post_formats_filters' ) ) {
	function charity_is_hope_get_list_post_formats_filters($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_post_formats_filters'))=='') {
			$list = array(
				"no"      => esc_html__('All posts', 'charity-is-hope'),
				"thumbs"  => esc_html__('With thumbs', 'charity-is-hope'),
				"reviews" => esc_html__('With reviews', 'charity-is-hope'),
				"video"   => esc_html__('With videos', 'charity-is-hope'),
				"audio"   => esc_html__('With audios', 'charity-is-hope'),
				"gallery" => esc_html__('With galleries', 'charity-is-hope')
				);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_post_formats_filters', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_portfolio_filters' ) ) {
	function charity_is_hope_get_list_portfolio_filters($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_portfolio_filters'))=='') {
			$list = array(
				"hide"		=> esc_html__('Hide', 'charity-is-hope'),
				"tags"		=> esc_html__('Tags', 'charity-is-hope'),
				"categories"=> esc_html__('Categories', 'charity-is-hope')
				);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_portfolio_filters', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_hovers' ) ) {
	function charity_is_hope_get_list_hovers($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_hovers'))=='') {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'charity-is-hope');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'charity-is-hope');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'charity-is-hope');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'charity-is-hope');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'charity-is-hope');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'charity-is-hope');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'charity-is-hope');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'charity-is-hope');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'charity-is-hope');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'charity-is-hope');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'charity-is-hope');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'charity-is-hope');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'charity-is-hope');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'charity-is-hope');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'charity-is-hope');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'charity-is-hope');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'charity-is-hope');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'charity-is-hope');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'charity-is-hope');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'charity-is-hope');
			$list['square effect1']  = esc_html__('Square Effect 1',  'charity-is-hope');
			$list['square effect2']  = esc_html__('Square Effect 2',  'charity-is-hope');
			$list['square effect3']  = esc_html__('Square Effect 3',  'charity-is-hope');
			$list['square effect5']  = esc_html__('Square Effect 5',  'charity-is-hope');
			$list['square effect6']  = esc_html__('Square Effect 6',  'charity-is-hope');
			$list['square effect7']  = esc_html__('Square Effect 7',  'charity-is-hope');
			$list['square effect8']  = esc_html__('Square Effect 8',  'charity-is-hope');
			$list['square effect9']  = esc_html__('Square Effect 9',  'charity-is-hope');
			$list['square effect10'] = esc_html__('Square Effect 10',  'charity-is-hope');
			$list['square effect11'] = esc_html__('Square Effect 11',  'charity-is-hope');
			$list['square effect12'] = esc_html__('Square Effect 12',  'charity-is-hope');
			$list['square effect13'] = esc_html__('Square Effect 13',  'charity-is-hope');
			$list['square effect14'] = esc_html__('Square Effect 14',  'charity-is-hope');
			$list['square effect15'] = esc_html__('Square Effect 15',  'charity-is-hope');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'charity-is-hope');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'charity-is-hope');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'charity-is-hope');
			$list['square effect_more']  = esc_html__('Square Effect More',  'charity-is-hope');
			$list['square effect_fade']  = esc_html__('Square Effect Fade',  'charity-is-hope');
			$list['square effect_pull']  = esc_html__('Square Effect Pull',  'charity-is-hope');
			$list['square effect_slide'] = esc_html__('Square Effect Slide', 'charity-is-hope');
			$list['square effect_border'] = esc_html__('Square Effect Border', 'charity-is-hope');
			$list = apply_filters('charity_is_hope_filter_portfolio_hovers', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_hovers', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the blog counters
if ( !function_exists( 'charity_is_hope_get_list_blog_counters' ) ) {
	function charity_is_hope_get_list_blog_counters($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_blog_counters'))=='') {
			$list = array(
				'views'		=> esc_html__('Views', 'charity-is-hope'),
				'likes'		=> esc_html__('Likes', 'charity-is-hope'),
				'rating'	=> esc_html__('Rating', 'charity-is-hope'),
				'comments'	=> esc_html__('Comments', 'charity-is-hope')
				);
			$list = apply_filters('charity_is_hope_filter_list_blog_counters', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_blog_counters', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list of the item sizes for the portfolio alter style, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_alter_sizes' ) ) {
	function charity_is_hope_get_list_alter_sizes($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_alter_sizes'))=='') {
			$list = array(
					'1_1' => esc_html__('1x1', 'charity-is-hope'),
					'1_2' => esc_html__('1x2', 'charity-is-hope'),
					'2_1' => esc_html__('2x1', 'charity-is-hope'),
					'2_2' => esc_html__('2x2', 'charity-is-hope'),
					'1_3' => esc_html__('1x3', 'charity-is-hope'),
					'2_3' => esc_html__('2x3', 'charity-is-hope'),
					'3_1' => esc_html__('3x1', 'charity-is-hope'),
					'3_2' => esc_html__('3x2', 'charity-is-hope'),
					'3_3' => esc_html__('3x3', 'charity-is-hope')
					);
			$list = apply_filters('charity_is_hope_filter_portfolio_alter_sizes', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_alter_sizes', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_hovers_directions' ) ) {
	function charity_is_hope_get_list_hovers_directions($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_hovers_directions'))=='') {
			$list = array(
				'left_to_right' => esc_html__('Left to Right',  'charity-is-hope'),
				'right_to_left' => esc_html__('Right to Left',  'charity-is-hope'),
				'top_to_bottom' => esc_html__('Top to Bottom',  'charity-is-hope'),
				'bottom_to_top' => esc_html__('Bottom to Top',  'charity-is-hope'),
				'scale_up'      => esc_html__('Scale Up',  'charity-is-hope'),
				'scale_down'    => esc_html__('Scale Down',  'charity-is-hope'),
				'scale_down_up' => esc_html__('Scale Down-Up',  'charity-is-hope'),
				'from_left_and_right' => esc_html__('From Left and Right',  'charity-is-hope'),
				'from_top_and_bottom' => esc_html__('From Top and Bottom',  'charity-is-hope')
			);
			$list = apply_filters('charity_is_hope_filter_portfolio_hovers_directions', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_hovers_directions', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'charity_is_hope_get_list_label_positions' ) ) {
	function charity_is_hope_get_list_label_positions($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_label_positions'))=='') {
			$list = array(
				'top'		=> esc_html__('Top',		'charity-is-hope'),
				'bottom'	=> esc_html__('Bottom',		'charity-is-hope'),
				'left'		=> esc_html__('Left',		'charity-is-hope'),
				'over'		=> esc_html__('Over',		'charity-is-hope')
			);
			$list = apply_filters('charity_is_hope_filter_label_positions', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_label_positions', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the bg image positions
if ( !function_exists( 'charity_is_hope_get_list_bg_image_positions' ) ) {
	function charity_is_hope_get_list_bg_image_positions($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_bg_image_positions'))=='') {
			$list = array(
				'left top'	   => esc_html__('Left Top', 'charity-is-hope'),
				'center top'   => esc_html__("Center Top", 'charity-is-hope'),
				'right top'    => esc_html__("Right Top", 'charity-is-hope'),
				'left center'  => esc_html__("Left Center", 'charity-is-hope'),
				'center center'=> esc_html__("Center Center", 'charity-is-hope'),
				'right center' => esc_html__("Right Center", 'charity-is-hope'),
				'left bottom'  => esc_html__("Left Bottom", 'charity-is-hope'),
				'center bottom'=> esc_html__("Center Bottom", 'charity-is-hope'),
				'right bottom' => esc_html__("Right Bottom", 'charity-is-hope')
			);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_bg_image_positions', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the bg image repeat
if ( !function_exists( 'charity_is_hope_get_list_bg_image_repeats' ) ) {
	function charity_is_hope_get_list_bg_image_repeats($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_bg_image_repeats'))=='') {
			$list = array(
				'repeat'	=> esc_html__('Repeat', 'charity-is-hope'),
				'repeat-x'	=> esc_html__('Repeat X', 'charity-is-hope'),
				'repeat-y'	=> esc_html__('Repeat Y', 'charity-is-hope'),
				'no-repeat'	=> esc_html__('No Repeat', 'charity-is-hope')
			);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_bg_image_repeats', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the bg image attachment
if ( !function_exists( 'charity_is_hope_get_list_bg_image_attachments' ) ) {
	function charity_is_hope_get_list_bg_image_attachments($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_bg_image_attachments'))=='') {
			$list = array(
				'scroll'	=> esc_html__('Scroll', 'charity-is-hope'),
				'fixed'		=> esc_html__('Fixed', 'charity-is-hope'),
				'local'		=> esc_html__('Local', 'charity-is-hope')
			);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_bg_image_attachments', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}


// Return list of the bg tints
if ( !function_exists( 'charity_is_hope_get_list_bg_tints' ) ) {
	function charity_is_hope_get_list_bg_tints($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_bg_tints'))=='') {
			$list = array(
				'white'	=> esc_html__('White', 'charity-is-hope'),
				'light'	=> esc_html__('Light', 'charity-is-hope'),
				'dark'	=> esc_html__('Dark', 'charity-is-hope')
			);
			$list = apply_filters('charity_is_hope_filter_bg_tints', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_bg_tints', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_field_types' ) ) {
	function charity_is_hope_get_list_field_types($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_field_types'))=='') {
			$list = array(
				'text'     => esc_html__('Text',  'charity-is-hope'),
				'textarea' => esc_html__('Text Area','charity-is-hope'),
				'password' => esc_html__('Password',  'charity-is-hope'),
				'radio'    => esc_html__('Radio',  'charity-is-hope'),
				'checkbox' => esc_html__('Checkbox',  'charity-is-hope'),
				'select'   => esc_html__('Select',  'charity-is-hope'),
				'date'     => esc_html__('Date','charity-is-hope'),
				'time'     => esc_html__('Time','charity-is-hope'),
				'button'   => esc_html__('Button','charity-is-hope')
			);
			$list = apply_filters('charity_is_hope_filter_field_types', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_field_types', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'charity_is_hope_get_list_googlemap_styles' ) ) {
	function charity_is_hope_get_list_googlemap_styles($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_googlemap_styles'))=='') {
			$list = array(
				'default' => esc_html__('Default', 'charity-is-hope')
			);
			$list = apply_filters('charity_is_hope_filter_googlemap_styles', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_googlemap_styles', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return images list
if (!function_exists('charity_is_hope_get_list_images')) {
	function charity_is_hope_get_list_images($folder, $ext='', $only_names=false) {
		return function_exists('trx_utils_get_folder_list') ? trx_utils_get_folder_list($folder, $ext, $only_names) : array();
	}
}

// Return iconed classes list
if ( !function_exists( 'charity_is_hope_get_list_icons' ) ) {
	function charity_is_hope_get_list_icons($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_icons'))=='') {
			$list = charity_is_hope_parse_icons_classes(charity_is_hope_get_file_dir("css/fontello/css/fontello-codes.css"));
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_icons', $list);
		}
		return $prepend_inherit ? array_merge(array('inherit'), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'charity_is_hope_get_list_socials' ) ) {
	function charity_is_hope_get_list_socials($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_socials'))=='') {
			$list = charity_is_hope_get_list_images(CHARITY_IS_HOPE_FW_DIR."/images/socials", "png");
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_socials', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'charity_is_hope_get_list_yesno' ) ) {
	function charity_is_hope_get_list_yesno($prepend_inherit=false) {
		$list = array(
			'yes' => esc_html__("Yes", 'charity-is-hope'),
			'no'  => esc_html__("No", 'charity-is-hope')
		);
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'charity_is_hope_get_list_onoff' ) ) {
	function charity_is_hope_get_list_onoff($prepend_inherit=false) {
		$list = array(
			"on" => esc_html__("On", 'charity-is-hope'),
			"off" => esc_html__("Off", 'charity-is-hope')
		);
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'charity_is_hope_get_list_showhide' ) ) {
	function charity_is_hope_get_list_showhide($prepend_inherit=false) {
		$list = array(
			"show" => esc_html__("Show", 'charity-is-hope'),
			"hide" => esc_html__("Hide", 'charity-is-hope')
		);
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'charity_is_hope_get_list_orderings' ) ) {
	function charity_is_hope_get_list_orderings($prepend_inherit=false) {
		$list = array(
			"asc" => esc_html__("Ascending", 'charity-is-hope'),
			"desc" => esc_html__("Descending", 'charity-is-hope')
		);
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'charity_is_hope_get_list_directions' ) ) {
	function charity_is_hope_get_list_directions($prepend_inherit=false) {
		$list = array(
			"horizontal" => esc_html__("Horizontal", 'charity-is-hope'),
			"vertical" => esc_html__("Vertical", 'charity-is-hope')
		);
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with item's shapes
if ( !function_exists( 'charity_is_hope_get_list_shapes' ) ) {
	function charity_is_hope_get_list_shapes($prepend_inherit=false) {
		$list = array(
			"round"  => esc_html__("Round", 'charity-is-hope'),
			"square" => esc_html__("Square", 'charity-is-hope')
		);
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with item's sizes
if ( !function_exists( 'charity_is_hope_get_list_sizes' ) ) {
	function charity_is_hope_get_list_sizes($prepend_inherit=false) {
		$list = array(
			"tiny"   => esc_html__("Tiny", 'charity-is-hope'),
			"small"  => esc_html__("Small", 'charity-is-hope'),
			"medium" => esc_html__("Medium", 'charity-is-hope'),
			"large"  => esc_html__("Large", 'charity-is-hope')
		);
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with slider (scroll) controls positions
if ( !function_exists( 'charity_is_hope_get_list_controls' ) ) {
	function charity_is_hope_get_list_controls($prepend_inherit=false) {
		$list = array(
			"hide" => esc_html__("Hide", 'charity-is-hope'),
			"side" => esc_html__("Side", 'charity-is-hope'),
			"bottom" => esc_html__("Bottom", 'charity-is-hope')
		);
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'charity_is_hope_get_list_floats' ) ) {
	function charity_is_hope_get_list_floats($prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'charity-is-hope'),
			"left" => esc_html__("Float Left", 'charity-is-hope'),
			"right" => esc_html__("Float Right", 'charity-is-hope')
		);
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'charity_is_hope_get_list_alignments' ) ) {
	function charity_is_hope_get_list_alignments($justify=false, $prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'charity-is-hope'),
			"left" => esc_html__("Left", 'charity-is-hope'),
			"center" => esc_html__("Center", 'charity-is-hope'),
			"right" => esc_html__("Right", 'charity-is-hope')
		);
		if ($justify) $list["justify"] = esc_html__("Justify", 'charity-is-hope');
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with horizontal positions
if ( !function_exists( 'charity_is_hope_get_list_hpos' ) ) {
	function charity_is_hope_get_list_hpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['left'] = esc_html__("Left", 'charity-is-hope');
		if ($center) $list['center'] = esc_html__("Center", 'charity-is-hope');
		$list['right'] = esc_html__("Right", 'charity-is-hope');
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with vertical positions
if ( !function_exists( 'charity_is_hope_get_list_vpos' ) ) {
	function charity_is_hope_get_list_vpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['top'] = esc_html__("Top", 'charity-is-hope');
		if ($center) $list['center'] = esc_html__("Center", 'charity-is-hope');
		$list['bottom'] = esc_html__("Bottom", 'charity-is-hope');
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'charity_is_hope_get_list_sortings' ) ) {
	function charity_is_hope_get_list_sortings($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_sortings'))=='') {
			$list = array(
				"date" => esc_html__("Date", 'charity-is-hope'),
				"title" => esc_html__("Alphabetically", 'charity-is-hope'),
				"views" => esc_html__("Popular (views count)", 'charity-is-hope'),
				"comments" => esc_html__("Most commented (comments count)", 'charity-is-hope'),
				"author_rating" => esc_html__("Author rating", 'charity-is-hope'),
				"users_rating" => esc_html__("Visitors (users) rating", 'charity-is-hope'),
				"random" => esc_html__("Random", 'charity-is-hope')
			);
			$list = apply_filters('charity_is_hope_filter_list_sortings', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_sortings', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'charity_is_hope_get_list_columns' ) ) {
	function charity_is_hope_get_list_columns($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_columns'))=='') {
			$list = array(
				"none" => esc_html__("None", 'charity-is-hope'),
				"1_1" => esc_html__("100%", 'charity-is-hope'),
				"1_2" => esc_html__("1/2", 'charity-is-hope'),
				"1_3" => esc_html__("1/3", 'charity-is-hope'),
				"2_3" => esc_html__("2/3", 'charity-is-hope'),
				"1_4" => esc_html__("1/4", 'charity-is-hope'),
				"3_4" => esc_html__("3/4", 'charity-is-hope'),
				"1_5" => esc_html__("1/5", 'charity-is-hope'),
				"2_5" => esc_html__("2/5", 'charity-is-hope'),
				"3_5" => esc_html__("3/5", 'charity-is-hope'),
				"4_5" => esc_html__("4/5", 'charity-is-hope'),
				"1_6" => esc_html__("1/6", 'charity-is-hope'),
				"5_6" => esc_html__("5/6", 'charity-is-hope'),
				"1_7" => esc_html__("1/7", 'charity-is-hope'),
				"2_7" => esc_html__("2/7", 'charity-is-hope'),
				"3_7" => esc_html__("3/7", 'charity-is-hope'),
				"4_7" => esc_html__("4/7", 'charity-is-hope'),
				"5_7" => esc_html__("5/7", 'charity-is-hope'),
				"6_7" => esc_html__("6/7", 'charity-is-hope'),
				"1_8" => esc_html__("1/8", 'charity-is-hope'),
				"3_8" => esc_html__("3/8", 'charity-is-hope'),
				"5_8" => esc_html__("5/8", 'charity-is-hope'),
				"7_8" => esc_html__("7/8", 'charity-is-hope'),
				"1_9" => esc_html__("1/9", 'charity-is-hope'),
				"2_9" => esc_html__("2/9", 'charity-is-hope'),
				"4_9" => esc_html__("4/9", 'charity-is-hope'),
				"5_9" => esc_html__("5/9", 'charity-is-hope'),
				"7_9" => esc_html__("7/9", 'charity-is-hope'),
				"8_9" => esc_html__("8/9", 'charity-is-hope'),
				"1_10"=> esc_html__("1/10", 'charity-is-hope'),
				"3_10"=> esc_html__("3/10", 'charity-is-hope'),
				"7_10"=> esc_html__("7/10", 'charity-is-hope'),
				"9_10"=> esc_html__("9/10", 'charity-is-hope'),
				"1_11"=> esc_html__("1/11", 'charity-is-hope'),
				"2_11"=> esc_html__("2/11", 'charity-is-hope'),
				"3_11"=> esc_html__("3/11", 'charity-is-hope'),
				"4_11"=> esc_html__("4/11", 'charity-is-hope'),
				"5_11"=> esc_html__("5/11", 'charity-is-hope'),
				"6_11"=> esc_html__("6/11", 'charity-is-hope'),
				"7_11"=> esc_html__("7/11", 'charity-is-hope'),
				"8_11"=> esc_html__("8/11", 'charity-is-hope'),
				"9_11"=> esc_html__("9/11", 'charity-is-hope'),
				"10_11"=> esc_html__("10/11", 'charity-is-hope'),
				"1_12"=> esc_html__("1/12", 'charity-is-hope'),
				"5_12"=> esc_html__("5/12", 'charity-is-hope'),
				"7_12"=> esc_html__("7/12", 'charity-is-hope'),
				"10_12"=> esc_html__("10/12", 'charity-is-hope'),
				"11_12"=> esc_html__("11/12", 'charity-is-hope')
			);
			$list = apply_filters('charity_is_hope_filter_list_columns', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_columns', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'charity_is_hope_get_list_dedicated_locations' ) ) {
	function charity_is_hope_get_list_dedicated_locations($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_dedicated_locations'))=='') {
			$list = array(
				"default" => esc_html__('As in the post defined', 'charity-is-hope'),
				"center"  => esc_html__('Above the text of the post', 'charity-is-hope'),
				"left"    => esc_html__('To the left the text of the post', 'charity-is-hope'),
				"right"   => esc_html__('To the right the text of the post', 'charity-is-hope'),
				"alter"   => esc_html__('Alternates for each post', 'charity-is-hope')
			);
			$list = apply_filters('charity_is_hope_filter_list_dedicated_locations', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_dedicated_locations', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'charity_is_hope_get_post_format_name' ) ) {
	function charity_is_hope_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'charity-is-hope') : esc_html__('galleries', 'charity-is-hope');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'charity-is-hope') : esc_html__('videos', 'charity-is-hope');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'charity-is-hope') : esc_html__('audios', 'charity-is-hope');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'charity-is-hope') : esc_html__('images', 'charity-is-hope');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'charity-is-hope') : esc_html__('quotes', 'charity-is-hope');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'charity-is-hope') : esc_html__('links', 'charity-is-hope');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'charity-is-hope') : esc_html__('statuses', 'charity-is-hope');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'charity-is-hope') : esc_html__('asides', 'charity-is-hope');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'charity-is-hope') : esc_html__('chats', 'charity-is-hope');
		else						$name = $single ? esc_html__('standard', 'charity-is-hope') : esc_html__('standards', 'charity-is-hope');
		return apply_filters('charity_is_hope_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'charity_is_hope_get_post_format_icon' ) ) {
	function charity_is_hope_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'pictures';
		else if ($format=='video')	$icon .= 'video';
		else if ($format=='audio')	$icon .= 'note';
		else if ($format=='image')	$icon .= 'picture';
		else if ($format=='quote')	$icon .= 'quote';
		else if ($format=='link')	$icon .= 'link';
		else if ($format=='status')	$icon .= 'comment';
		else if ($format=='aside')	$icon .= 'doc-text';
		else if ($format=='chat')	$icon .= 'chat';
		else						$icon .= 'book-open';
		return apply_filters('charity_is_hope_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_fonts_styles' ) ) {
	function charity_is_hope_get_list_fonts_styles($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_fonts_styles'))=='') {
			$list = array(
				'i' => esc_html__('I','charity-is-hope'),
				'u' => esc_html__('U', 'charity-is-hope')
			);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_fonts_styles', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'charity_is_hope_get_list_fonts' ) ) {
	function charity_is_hope_get_list_fonts($prepend_inherit=false) {
		if (($list = charity_is_hope_storage_get('list_fonts'))=='') {
			$list = array();
			$list = charity_is_hope_array_merge($list, charity_is_hope_get_list_font_faces());
			$list = charity_is_hope_array_merge($list, array(
				'Advent Pro' => array('family'=>'sans-serif'),
				'Alegreya Sans' => array('family'=>'sans-serif'),
				'Arimo' => array('family'=>'sans-serif'),
				'Asap' => array('family'=>'sans-serif'),
				'Averia Sans Libre' => array('family'=>'cursive'),
				'Averia Serif Libre' => array('family'=>'cursive'),
				'Bree Serif' => array('family'=>'serif',),
				'Cabin' => array('family'=>'sans-serif'),
				'Cabin Condensed' => array('family'=>'sans-serif'),
				'Caudex' => array('family'=>'serif'),
				'Comfortaa' => array('family'=>'cursive'),
				'Cousine' => array('family'=>'sans-serif'),
				'Crimson Text' => array('family'=>'serif'),
				'Cuprum' => array('family'=>'sans-serif'),
				'Dosis' => array('family'=>'sans-serif'),
				'Economica' => array('family'=>'sans-serif'),
				'Exo' => array('family'=>'sans-serif'),
				'Expletus Sans' => array('family'=>'cursive'),
				'Karla' => array('family'=>'sans-serif'),
				'Lato' => array('family'=>'sans-serif'),
				'Lekton' => array('family'=>'sans-serif'),
				'Lobster Two' => array('family'=>'cursive'),
				'Maven Pro' => array('family'=>'sans-serif'),
				'Merriweather' => array('family'=>'serif'),
				'Montserrat' => array('family'=>'sans-serif'),
				'Neuton' => array('family'=>'serif'),
				'Noticia Text' => array('family'=>'serif'),
				'Old Standard TT' => array('family'=>'serif'),
				'Open Sans' => array('family'=>'sans-serif'),
				'Orbitron' => array('family'=>'sans-serif'),
				'Oswald' => array('family'=>'sans-serif'),
				'Overlock' => array('family'=>'cursive'),
				'Oxygen' => array('family'=>'sans-serif'),
				'Philosopher' => array('family'=>'serif'),
				'PT Serif' => array('family'=>'serif'),
				'Puritan' => array('family'=>'sans-serif'),
				'Raleway' => array('family'=>'sans-serif'),
				'Roboto' => array('family'=>'sans-serif'),
				'Roboto Slab' => array('family'=>'sans-serif'),
				'Roboto Condensed' => array('family'=>'sans-serif'),
				'Rosario' => array('family'=>'sans-serif'),
				'Share' => array('family'=>'cursive'),
				'Signika' => array('family'=>'sans-serif'),
				'Signika Negative' => array('family'=>'sans-serif'),
				'Source Sans Pro' => array('family'=>'sans-serif'),
				'Tinos' => array('family'=>'serif'),
				'Ubuntu' => array('family'=>'sans-serif'),
				'Vollkorn' => array('family'=>'serif')
				)
			);
			$list = apply_filters('charity_is_hope_filter_list_fonts', $list);
			if (charity_is_hope_get_theme_setting('use_list_cache')) charity_is_hope_storage_set('list_fonts', $list);
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'charity_is_hope_get_list_font_faces' ) ) {
	function charity_is_hope_get_list_font_faces($prepend_inherit=false) {
		static $list = false;
		if (is_array($list)) return $list;
		$fonts = charity_is_hope_storage_get('required_custom_fonts');
		$list = array();
		if (is_array($fonts)) {
			foreach ($fonts as $font) {
				if (($url = charity_is_hope_get_file_url('css/font-face/'.trim($font).'/stylesheet.css'))!='') {
					$list[sprintf(esc_html__('%s (uploaded font)', 'charity-is-hope'), $font)] = array('css' => $url);
				}
			}
		}
		return $list;
	}
}
?>