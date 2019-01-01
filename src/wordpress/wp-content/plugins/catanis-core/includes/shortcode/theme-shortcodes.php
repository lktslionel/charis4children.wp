<?php
/*---------------------------------------------------------------------------------------------------------*/
/*--- FUNCTIONS --------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'catanis_parse_multi_attribute' ) ) {
	/**
	 * Parse multi attributes 
	 * 
	 * @param array $value 
	 * @param array $default default value
	 * @return Ambigous <unknown, string>
	 */
	function catanis_parse_multi_attribute( $value, $default = array() ) {
		$result = $default;
		$params_pairs = explode( '|', $value );
		if ( ! empty( $params_pairs ) ) {
			foreach ( $params_pairs as $pair ) {
				$param = preg_split( '/\:/', $pair );
				if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
					$result[ $param[0] ] = rawurldecode( $param[1] );
				}
			}
		}
	
		return $result;
	}
}

if ( ! function_exists( 'catanis_widget_title' ) ) {
	/**
	 * Filter title in shortcode
	 * 
	 * @param array $params array for attribute title
	 * @return string
	 */
	function catanis_widget_title( $params = array( 'title' => '' ) ) {
		if ( $params['title'] == '' ) {
			return '';
		}
	
		$extraclass = ( isset( $params['extraclass'] ) ) ? " " . $params['extraclass'] : "";
		$output = '<h2 class="ca_heading' . $extraclass . '">' . $params['title'] . '</h2>';
	
		return apply_filters( 'the_title', $output, $params );
	}
}

if ( ! function_exists( 'catanis_date_format_sys' ) ) {
	/**
	 * Convert date time to system day format
	 * 
	 * @param date $time
	 * @return string
	 */
	function catanis_date_format_sys($time){
		$startDate = date( get_option( 'date_format' ) . ' ' . get_option('time_format'), strtotime($time));
		$endDate = date( get_option( 'date_format' ) . ' ' . get_option('time_format'), time());
		$option = array( 'date_format' => get_option('date_format'), 'time_format' => get_option('time_format'));
	
		if (class_exists('Catanis_Default_Data')){
			return Catanis_Default_Data::dateDistance( $startDate, $endDate, $option);
		}else{
			return mysql2date(get_option('date_format'), $time);
		}
	}
}

if ( ! function_exists( 'catannis_tweets_ago' ) ) {
	/**
	 * Calculation time in twitter tweet (shortcode twitter)
	 * 
	 * @param int $time
	 * @return string
	 */
	function catannis_tweets_ago( $time ) {
		$periods = array( "second", "minute", "hour", "day", "week", "month", "year", "decade" );
		$lengths = array( "60", "60", "24", "7", "4.35", "12", "10" );
	
		$now = time();
		$difference = $now - $time;
		 
		for ( $j = 0; $difference >= $lengths[$j] && $j < count( $lengths )-1; $j++ ) {
			$difference /= $lengths[$j];
		}
	
		$difference = round($difference);
	
		if ( $difference != 1 ) {
			$periods[$j].= "s";
		}
	
		return $difference .' '. $periods[$j] . ' ' . esc_html__( 'ago', 'catanis-core' );
	}
}

if ( ! function_exists( 'catanis_remove_empty_tags_around_shortcodes' ) ) {
	/**
	 * Remove empty paragraph tags <p> and line break <br /> from shortcode
	 * 
	 * @param html $content
	 * @return html
	 */
	function catanis_remove_empty_tags_around_shortcodes( $content ) {
		$tags = array(
			'<p>[' 	=> '[',
			'<p>[/' => '[/',
			']</p>' => ']',
			']<br>' => ']',
			']<br />' => ']'
		);
	
		$content = strtr( $content, $tags );
		return $content;
	}
}
add_filter( 'the_content', 'catanis_remove_empty_tags_around_shortcodes' );

if ( ! function_exists( 'catanis_strip_attr_prefix' ) ) {
	/**
	 * Replace key attribute array shortcode
	 * 
	 * @param array $atts
	 * @return array
	 */
	function catanis_strip_attr_prefix( $atts ) {
		$stripped_atts = array();

		if ( ! empty( $atts ) ) {
			foreach ( $atts as $key => $value ) {
				$stripped_key = str_replace( 'attr_', '', $key );
				$stripped_atts[$stripped_key] = $value;
			}
		}

		return $stripped_atts;
	}
}

if ( ! function_exists( 'catanis_random_string' ) ) {
	/**
	 * Generate a string random with length and suffix
	 * 
	 * @param int $length number length to need random
	 * @param string $suffix	suffix of string
	 * @return string unique string
	 */
	function catanis_random_string($length, $suffix = '') {

		$strRandom = null;
		$keys = array_merge(range(0,9), range('a', 'z'));

		for($i=0; $i < $length; $i++) {
			$strRandom .= $keys[array_rand($keys)];
		}

		if(!empty($suffix)){
			return $suffix .'_' .$strRandom;
		}else{
			return $strRandom;
		}
	}
}


if ( ! function_exists( 'catanis_colour_creator' ) ) {
	/** 
	 * Create new color RGB
	 * 
	 *  Example Result
	 	$originalColour = "#ff0000";
		$darkestPercent = -80;
		$darkPercent = -50;
		$lightPercent = 50;
		$lightestPercent = 80;
		
		$darkestColour = catanis_colour_creator($originalColour, $darkestPercent);
		$darkColour = catanis_colour_creator($originalColour, $darkPercent);
		$lightColour = catanis_colour_creator($originalColour, $lightPercent);
		$lightestColour = catanis_colour_creator($originalColour, $lightestPercent);
	*/
	function catanis_colour_creator($colour, $per)	{
		
		$colour = substr( $colour, 1 ); 	/* Removes first character of hex string (#) */
		$rgb = '';
		$per = $per/100*255; 				/* Creates a percentage to work with. Change the middle figure to control colour temperature */
	
		if  ($per < 0 ) {
			/* DARKER */
			$per =  abs($per);
			for ($x=0;$x<3;$x++)
			{
				$c = hexdec(substr($colour,(2*$x),2)) - $per;
				$c = ($c < 0) ? 0 : dechex($c);
				$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
			}
		}
		else {
			/* LIGHTER */
			for ($x=0;$x<3;$x++)
			{
				$c = hexdec(substr($colour,(2*$x),2)) + $per;
				$c = ($c > 255) ? 'ff' : dechex($c);
				$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
			}
		}
	
		return '#'.$rgb;
	}
}
if ( ! function_exists( 'catanis_is_json' ) ) {
	/**
	 * Check string is json or not
	 * 
	 * @param string $string
	 * @return boolean
	 */
	function catanis_is_json($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}
}

if ( ! function_exists( 'catanis_stringify_attributes' ) ) {
	/**
	 * Convert array of named params to string version
	 * All values will be escaped
	 *
	 * E.g. f(array('name' => 'foo', 'id' => 'bar')) -> 'name="foo" id="bar"'
	 *
	 * @param $attributes
	 *
	 * @return string
	 */
	function catanis_stringify_attributes( $attributes ) {
		$atts = array();
		foreach ( $attributes as $name => $value ) {
			$atts[] = $name . '="' . esc_attr( $value ) . '"';
		}
	
		return implode( ' ', $atts );
	}
}

if ( ! function_exists( 'catanis_param_group_parse_atts' ) ) {
	/**
	 * Parse attributes group
	 * 
	 * @param $atts_string string json encode
	 * @return array
	 */
	function catanis_param_group_parse_atts( $atts_string ) {
		$array = json_decode( urldecode( $atts_string ), true );
	
		return $array;
	}
}

if ( ! function_exists( 'catanis_param_group_parse_atts' ) ) {
	/**
	 * Get css color, example: color: #FFFFFF or background-color: #FFFF00 
	 * How to use: catanis_get_css_color( 'background-color', $color )
	 * 
	 * @param $prefix attribute color in css
	 * @param $color color code
	 * @return string
	 */
	function catanis_get_css_color( $prefix, $color ) {
		$rgb_color = preg_match( '/rgba/', $color ) ? preg_replace( array(
				'/\s+/',
				'/^rgba\((\d+)\,(\d+)\,(\d+)\,([\d\.]+)\)$/',
		), array(
				'',
				'rgb($1,$2,$3)',
		), $color ) : $color;
		$string = $prefix . ':' . $rgb_color . ';';
		if ( $rgb_color !== $color ) {
			$string .= $prefix . ':' . $color . ';';
		}
	
		return $string;
	}
}

if ( ! function_exists( 'catanis_shortcodeAnimation' ) ) {
	/**
	 * 
	 * @param array $atts array animation params
	 * @return array result animation
	 */
	function catanis_shortcodeAnimation($atts){
	
		$use_animation = $animation_type = $animation_duration = $animation_delay = '';
		extract( shortcode_atts( array(
			'use_animation'			=> 'no',
			'animation_type'		=> '',
			'animation_duration'	=> 700,
			'animation_delay'		=> '0',
		), $atts ) );
	
		$animationClass = $animationAttrs = '';
		if($use_animation == 'yes' && !empty($animation_type)){
			$animationClass = 'has-animation';
			$animationAttrs = ' data-animation-type="' . $animation_type . '" data-animation-duration="' . $animation_duration . '" data-animation-delay="' . $animation_delay .'"';
		}
	
		$output['has-animation'] = $animationClass;
		$output['animation-attrs'] = $animationAttrs;
		return $output;
	}
}

if(!function_exists('catanis_get_params_slick_slider')){
	
	function catanis_get_params_slick_slider($atts){
		
		$items_desktop = $items_desktop_small = $items_tablet = $slide_arrows = $slide_loop = $slide_dots = $slide_dots_style ='';
		$slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $ext_class = '';
		extract(shortcode_atts(array(
			'items_desktop' 		=> '4',
			'items_desktop_small' 	=> '3',
			'items_tablet' 			=> '2',
			'slide_loop'			=> 'yes',
			'slide_arrows'			=> 'no',
			'slide_dots'			=> 'yes',
			'slide_dots_style'		=> 'dots-line', 	/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/
			'slide_autoplay'		=> 'no',
			'slide_autoplay_speed'	=> 3000,
			'slides_to_scroll'		=> 3,
			'slides_speed'			=> 500,
		),$atts));
		
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		$arrParams = array(
			'autoplay' 			=> ($slide_autoplay == 'yes') ? true : false,
			'autoplaySpeed' 	=> intval($slide_autoplay_speed),
			'slidesToShow' 		=> intval($items_desktop),
			'slidesToScroll' 	=> intval($slides_to_scroll),
			'dots' 				=> ($slide_dots == 'yes')? true : false,
			'arrows' 			=> ($slide_arrows == 'yes')? true : false,
			'infinite' 			=> ($slide_loop == 'yes')? true : false,
			'draggable' 		=> true,
			'speed' 			=> intval($slides_speed),
			'rtl' 				=> CATANIS_RTL,
			'adaptiveHeight' 	=> true,
			'responsive'		=> array(
				array(
					'breakpoint'	=> 1024,
					'settings'		=> array(
						'slidesToShow'		=> intval($items_desktop_small),
						'slidesToScroll' 	=> intval($items_desktop_small)
					)
				),
				array(
					'breakpoint'	=> 768,
					'settings'		=> array(
							'slidesToShow'		=> intval($items_tablet),
							'slidesToScroll' 	=>  intval($items_tablet)
					)
				),
				array(
					'breakpoint'	=> 480,
					'settings'		=> array(
							'slidesToShow'		=> 1,
							'slidesToScroll' 	=> 1
					)
				),
			)
		);
		
		if($items_desktop == 1 && $items_desktop_small == 1 && $items_tablet == 1){
			$arrParams['fade'] = true;
			$arrParams['cssEase'] = 'linear';
		}
		
		return $arrParams;
	}
}

if(!function_exists('catanis_parse_text_style_for_googlefont')){
	/**
	 * Parse TEXT params in shortcodes.
	 *
	 * @param $string
	 * @param $tag_class
	 * @param $use_google_fonts
	 * @param $custom_fonts
	 *
	 * @return array
	 */
	function catanis_parse_text_style_for_googlefont( $string, $tag_class = '', $use_google_fonts = 'no', $custom_fonts = false ) {
		$parsed_param =  array();
		$parsed_array = array(
			'style' 	=> '',
			'tag' 		=> 'div',
			'class' 	=> '',
			'color' 	=> ''
		);
		$param_value  = explode( '|', $string );

		if ( is_array( $param_value ) ) {
			foreach ( $param_value as $single_param ) {
				$single_param  = explode( ':', $single_param );
				if ( isset($single_param[1]) && $single_param[1] != '' ) {
					$parsed_param[ $single_param[0] ] = $single_param[1];
				} else {
					$parsed_param[ $single_param[0] ] = '';
				}
			}
		}

		if ( ! empty( $parsed_param ) && is_array( $parsed_param ) ) {
			$parsed_array['style'] = 'style="';

			if ( 'yes' === $use_google_fonts && class_exists('Vc_Google_Fonts')) {

				$google_fonts_obj  = new Vc_Google_Fonts();
				$google_fonts_data = strlen( $custom_fonts ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( array(), $custom_fonts ) : '';

				$google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
				$parsed_array['style'] .= 'font-family:' . $google_fonts_family[0] . '; ';
				$google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
				$parsed_array['style'] .= 'font-weight:' . $google_fonts_styles[1] . '; ';
				$parsed_array['style'] .= 'font-style:' . $google_fonts_styles[2] . '; ';

				$settings = get_option( 'wpb_js_google_fonts_subsets' );
				if ( is_array( $settings ) && ! empty( $settings ) ) {
					$subsets = '&subset=' . implode( ',', $settings );
				} else {
					$subsets = '';
				}

				if ( isset( $google_fonts_data['values']['font_family'] ) && function_exists('vc_build_safe_css_class') ) {
					wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
				}
			}

			foreach ( $parsed_param as $key => $value ) {

				if ( strlen( $value ) > 0 ) {
					if ( 'font_style_italic' === $key ) {
						$parsed_array['style'] .= 'font-style:italic; ';
					} elseif ( 'font_style_bold' === $key ) {
						$parsed_array['style'] .= 'font-weight:bold; ';
					} elseif ( 'font_style_underline' === $key ) {
						$parsed_array['style'] .= 'text-decoration:underline; ';
					} elseif ( 'color' === $key ) {
						$parsed_array['style'] .= $key . ': ' . str_replace( '%23', '#', $value ) . '; ';
						$parsed_array['color'] = str_replace( '%23', '#', $value );
					} elseif('text_align' === $key){
						$parsed_array['style'] .= 'text-align:'. trim($value) .';';
					} elseif('tag' === $key){
						$parsed_array['tag'] = $value;
					}else {
						$parsed_array['style'] .= str_replace( '_', '-', $key ) . ': ' . $value . '; ';
					}
				}
			}
				
			$parsed_array['style'] .= '"';
			$parsed_array['class'] = $tag_class;
		}

		return $parsed_array;
	}
}


/*----------------------------------------------------------------------------------------------------------*/
/*--- CATANIS THEME SHORTCODES -----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'catanis_footer_email_shortcode_function' ) ) {
	function catanis_footer_email_shortcode_function( $atts, $content = null ) {
		$footer_email = catanis_option('show_footer_email');
		if($footer_email['status']){
			return wp_kses_post($footer_email['content']);
		}else{
			return esc_html__('Please enable footer email in Theme Options.', 'onelove');
		}
	}
}
add_shortcode('cata_footer_email', 'catanis_footer_email_shortcode_function');

if ( ! function_exists( 'catanis_footer_phone_shortcode_function' ) ) {
	function catanis_footer_phone_shortcode_function( $atts, $content = null ) {
		$footer_phone = catanis_option('show_footer_phone');
		if($footer_phone['status']){
			return wp_kses_post($footer_phone['content']);
		}else{
			return esc_html__('Please enable footer phone in Theme Options.', 'onelove');
		}
	}
}
add_shortcode('cata_footer_phone', 'catanis_footer_phone_shortcode_function');

if ( ! function_exists( 'catanis_footer_address_shortcode_function' ) ) {
	function catanis_footer_address_shortcode_function( $atts, $content = null ) {
		$footer_address = catanis_option('show_footer_address');
		if($footer_address['status']){
			return wp_kses_post($footer_address['content']);
		}else{
			return esc_html__('Please enable footer address in Theme Options.', 'onelove');
		}
	}
}
add_shortcode('cata_footer_address', 'catanis_footer_address_shortcode_function');

if ( ! function_exists( 'catanis_footer_logo_shortcode_function' ) ) {
	function catanis_footer_logo_shortcode_function( $atts, $content = null ) {
		
		global $catanis;
		$catanis_page = $catanis->pageconfig;
		
		if(isset($catanis_page['footer_logo']) && !empty($catanis_page['footer_logo'])){
			$footer_logo = trim($catanis_page['footer_logo']);
		}else{
			$footer_logo = catanis_option('footer_logo');
		}
		
		if(!empty($footer_logo)){
			return '<div class="cata-footer-logo"><img src="'. esc_url( $footer_logo) .'" alt="'. esc_html__('Footer logo', 'onelove') .'"/></div>';
		}
		
	}
}
add_shortcode('cata_footer_logo', 'catanis_footer_logo_shortcode_function');

if ( ! function_exists( 'catanis_year_shortcode_function' ) ) {
	function catanis_year_shortcode_function( $atts, $content = null ) {
		return date('Y');
	}
}
add_shortcode('cata_year', 'catanis_year_shortcode_function');


/*=== SHORTCODE - VISUAL ROW, SECTION ========*/
/*============================================*/
if ( ! function_exists( 'catanis_row_shortcode_function' ) ) {
	function catanis_row_shortcode_function( $atts, $content = null ) {
		
		$xhtml = '';
		$row_stretch = $full_height = $columns_placement = $overflow_visible = $overflow_hidden = $columns_gap = $equal_height = $content_placement = '';
		$bg_type = $bg_color = $bg_image = $bg_image_size = $bg_image_position = $bg_image_repeat = '';
		$show_overlay = $overlay_opacity = $overlay_color = $use_parallax = $parallax_speed = $add_texture = $texture_top = $texture_bottom = '';
		$video_url_youtube = $video_url_vimeo = $video_url_mp4 = $video_url_webm = $video_url_ogg = $video_poster = $show_video_control = $video_opts = '';
		$desktop_padding_top = $desktop_padding_right = $desktop_padding_bottom = $desktop_padding_left = '';
		$desktop_margin_top = $desktop_margin_right = $desktop_margin_bottom = $desktop_margin_left = '';
		$row_border = $border_color = $border_size = $border_type = '';
		$ipad_custom_padding_margin = $ipad_padding_top = $ipad_padding_right = $ipad_padding_bottom = $ipad_padding_left = '';
		$ipad_margin_top = $ipad_margin_right = $ipad_margin_bottom = $ipad_margin_left = '';
		$mobile_custom_padding_margin = $mobile_padding_top = $mobile_padding_right = $mobile_padding_bottom = $mobile_padding_left = '';
		$mobile_margin_top = $mobile_margin_right = $mobile_margin_bottom = $mobile_margin_left = '';
		$scroll_to_down = $scroll_to_down_id = $scroll_to_down_title = $disable_element = $ext_class = $ext_id = '';
		$extend_imgs = $img_topleft = $img_topright = $img_centerleft = $img_centerright = $img_bottomleft = $img_bottomright = $img_topcenter = $img_bottomcenter = '';
		
		extract( shortcode_atts( array(
			'row_stretch' 					=> 'container_stretch', 	/*container,container_stretch, container_fluid, full_width*/
			'full_height'  					=> '', 				/*NULL,yes*/
			'columns_placement'  			=> '', 				/*NULL,top,middle,bottom*/
			'overflow_hidden'  				=> '', 				/*NULL,yes*/
			'columns_gap'  					=> '30', 			/*10 -> 50*/
			'equal_height'  				=> '', 				/*NULL,yes*/
			'content_placement'  			=> '',				/*top, middle, bottom*/
			'bg_type'  						=> 'no_bg',			/*no_bg, color, image, youtube, vimeo, self*/
			'bg_color' 						=> '#FFFFFF',
			'bg_image' 						=> '',
			'bg_image_size' 				=> 'cover',			/*cover, contain, initial*/
			'bg_image_position' 			=> 'center-center',	/*center-center, center-top, center-bottom, left-top, left-center, left-bottom, right-top, right-center,right-bottom*/
			'bg_image_repeat' 				=> 'no-repeat',		/*no-repeat, repeat-x, repeat-y, repeat*/
			'show_overlay' 					=> '',				/*NULL,yes*/
			'overlay_opacity' 				=> '',				/*0.1->1.0*/
			'overlay_color' 				=> '',
			'use_parallax' 					=> '',				/*NULL,yes*/
			'parallax_speed' 				=> '0.1',
			'add_texture' 					=> '',				/*NULL,yes*/
			'texture_top' 					=> '',				
			'texture_bottom' 				=> '',			
			'video_url_youtube' 			=> '',
			'video_url_vimeo' 				=> '',
			'video_url_mp4' 				=> '',
			'video_url_webm' 				=> '',
			'video_url_ogg' 				=> '',
			'video_poster' 					=> '',
			'show_video_control' 			=> 'show-video-control',		/*no-video-control,show-video-control*/
			'video_opts' 					=> '',				/*multi checkbox: autoplay, loop, muted*/
			'desktop_padding_top' 			=> '',				
			'desktop_padding_right' 		=> '',				
			'desktop_padding_bottom' 		=> '',				
			'desktop_padding_left' 			=> '',				
			'desktop_margin_top' 			=> '',				
			'desktop_margin_right' 			=> '',				
			'desktop_margin_bottom' 		=> '30px',				
			'desktop_margin_left' 			=> '',				
			'row_border' 					=> '',				/*NULL,border-top, border-bottom*/			
			'border_color' 					=> '',			
			'border_size' 					=> 0,					
			'border_type' 					=> '',				/*NULL,dotted,dashed,solid,double*/		
			'ipad_custom_padding_margin' 	=> '',				/*NULL,yes*/				
			'ipad_padding_top' 				=> '',					
			'ipad_padding_right' 			=> '',					
			'ipad_padding_bottom' 			=> '',					
			'ipad_padding_left' 			=> '',					
			'ipad_margin_top' 				=> '',					
			'ipad_margin_right' 			=> '',					
			'ipad_margin_bottom' 			=> '',					
			'ipad_margin_left' 				=> '',					
			'mobile_custom_padding_margin' 	=> '',				/*NULL,yes*/						
			'mobile_padding_top' 			=> '',					
			'mobile_padding_right' 			=> '',					
			'mobile_padding_bottom' 		=> '',					
			'mobile_padding_left' 			=> '',					
			'mobile_margin_top' 			=> '',					
			'mobile_margin_right' 			=> '',					
			'mobile_margin_bottom' 			=> '',					
			'mobile_margin_left' 			=> '',					
			'scroll_to_down' 				=> '',				/*NULL,yes*/			
			'scroll_to_down_id' 			=> '',					
			'scroll_to_down_title' 			=> '',					
			'disable_element' 				=> '',				/*NULL,yes*/						
			'extend_imgs' 					=> '',				/*NULL,yes*/						
			'img_topleft' 					=> '',					
			'img_topright' 					=> '',					
			'img_centerleft' 				=> '',					
			'img_centerright' 				=> '',					
			'img_bottomleft' 				=> '',					
			'img_bottomright' 				=> '',					
			'img_topcenter' 				=> '',					
			'img_bottomcenter' 				=> '',					
			'ext_class' 					=> '',					
			'ext_id' 						=> ''
		), $atts ) );
		
		if ( ! empty( $disable_element ) ) {
			return '';
		}
		
		$elemAttribute = $elemClass = array();
		$elemStyle = '';
		
		$elemID = catanis_random_string(10, 'section');
		if ( ! empty( $ext_id ) ) {
			$elemAttribute[] = 'id="' . esc_attr( $ext_id ) . '"';
		}else{
			$elemAttribute[] = 'id="' . esc_attr( $elemID ) . '"';
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemClass[] = 'cata-section cata-section-'. str_replace('_', '-', $row_stretch);
		
		if($row_stretch == 'full_width' || $row_stretch == 'fullwidth'){
			$elemClass[] = 'cata-fullwidth';
		}
		if ( ! empty( $overflow_hidden ) ) {
			$elemClass[] = 'cata-overflow-hidden';
		}
		
		$flex_row = '';
		if ( ! empty( $full_height ) ) {
			$elemClass[] = 'row-full-height';
			if ( ! empty( $columns_placement ) ) {
				$flex_row = true;
				$elemClass[] = 'row-columns-'. $columns_placement;
			}
		}
		if ( ! empty( $equal_height ) ) {
			$elemClass[] = 'row-equal-height';
			$flex_row = true;
		}
		
		if ( ! empty( $content_placement ) ) {
			$elemClass[] = 'row-content-' . $content_placement;
			$flex_row = true;
		}
		
		if ( ! empty( $flex_row ) ) {
			$elemClass[] = 'cata-row-flex';
		}
		
		if ( ! empty( $animation['has-animation'] ) ) {
			$elemClass[] = $animation['has-animation'];
		}
		if ( ! empty( $ext_class ) ) {
			$elemClass[] = $ext_class;
		}
		
		/* For class padding/margin Ipab */
		if ( ! empty( $ipad_custom_padding_margin ) ) {
			
			if ( ! empty( $ipad_margin_top ) ) {
				$elemClass[] = $ipad_margin_top;
			}
			if ( ! empty( $ipad_margin_right ) ) {
				$elemClass[] = $ipad_margin_right;
			}
			if ( ! empty( $ipad_margin_bottom ) ) {
				$elemClass[] = $ipad_margin_bottom ;
			}
			if ( ! empty( $ipad_margin_left ) ) {
				$elemClass[] = $ipad_margin_left ;
			}
			
			if ( ! empty( $ipad_padding_top ) ) {
				$elemClass[] = $ipad_padding_top ;
			}
			if ( ! empty( $ipad_padding_right ) ) {
				$elemClass[] = $ipad_padding_right;
			}
			if ( ! empty( $ipad_padding_bottom ) ) {
				$elemClass[] = $ipad_padding_bottom;
			}
			if ( ! empty( $ipad_padding_left ) ) {
				$elemClass[] = $ipad_padding_left;
			}
		}
		
		/* For class padding/margin Mobile */
		if ( ! empty( $mobile_custom_padding_margin ) ) {
				
			if ( ! empty( $mobile_margin_top ) ) {
				$elemClass[] = $mobile_margin_top ;
			}
			if ( ! empty( $mobile_margin_right ) ) {
				$elemClass[] = $mobile_margin_right ;
			}
			if ( ! empty( $mobile_margin_bottom ) ) {
				$elemClass[] = $mobile_margin_bottom ;
			}
			if ( ! empty( $mobile_margin_left ) ) {
				$elemClass[] = $mobile_margin_left ;
			}
				
			if ( ! empty( $mobile_padding_top ) ) {
				$elemClass[] = $mobile_padding_top;
			}
			if ( ! empty( $mobile_padding_right ) ) {
				$elemClass[] = $mobile_padding_right ;
			}
			if ( ! empty( $mobile_padding_bottom ) ) {
				$elemClass[] = $mobile_padding_bottom;
			}
			if ( ! empty( $mobile_padding_left ) ) {
				$elemClass[] = $mobile_padding_left ;
			}
		}
		
		$elemStyle .= ( $desktop_padding_top != '' ) ? ' padding-top:'. $desktop_padding_top .';' : '';
		$elemStyle .= ( $desktop_padding_right != '' ) ? ' padding-right:'. $desktop_padding_right .';' : '';
		$elemStyle .= ( $desktop_padding_bottom != '' ) ? ' padding-bottom:'. $desktop_padding_bottom .';' : '';
		$elemStyle .= ( $desktop_padding_left != '' ) ? ' padding-left:'. $desktop_padding_left .';' : '';
		$elemStyle .= ( $desktop_margin_top != '' ) ? ' margin-top:'. $desktop_margin_top .';' : '';
		$elemStyle .= ( $desktop_margin_right != '' ) ? ' margin-right:'. $desktop_margin_right .';' : '';
		$elemStyle .= ( $desktop_margin_bottom != '' && $desktop_margin_bottom != '30px' ) ? ' margin-bottom:'. $desktop_margin_bottom .';' : '';
		$elemStyle .= ( $desktop_margin_left != '' ) ? ' margin-left:'. $desktop_margin_left .';' : '';
		
		/* For Border */
		$row_border = ($row_border) ? $row_border . ': ' : '';
		if($row_border){
			$row_border .= ($border_size) ? $border_size .'px' : '';
			$row_border .= ($border_type) ? ' '. $border_type : '';
			$row_border .= ($border_color) ? ' '. $border_color : '';
			$row_border .= ';';
			
			$elemStyle .= $row_border;
		}
		
		$extend_anima_imgs = '';
		if ( ! empty( $extend_imgs ) ) {
			$extend_anima_imgs .= '<div class="cata-extend-anima-imgs">';
			
			if ( (int) $img_topleft > 0 && ( $image_url = wp_get_attachment_url( $img_topleft ) ) !== false ) {
				$extend_anima_imgs .= '<div class="cata-item-img cata-img-topleft has-animation" data-animation-type="slideInLeft" data-animation-delay="300"><img src="' . $image_url . '" alt=""/></div>';
			}
			if ( (int) $img_topright > 0 && ( $image_url = wp_get_attachment_url( $img_topright ) ) !== false ) {
				$extend_anima_imgs .= '<div class="cata-item-img cata-img-topright has-animation" data-animation-type="slideInRight" data-animation-delay="300"><img src="' . $image_url . '" alt=""/></div>';
			}
			
			if ( (int) $img_centerleft > 0 && ( $image_url = wp_get_attachment_url( $img_centerleft ) ) !== false ) {
				$extend_anima_imgs .= '<div class="cata-item-img cata-img-centerleft has-animation" data-animation-type="slideInLeft" data-animation-delay="350"><img src="' . $image_url . '" alt=""/></div>';
			}
			if ( (int) $img_centerright > 0 && ( $image_url = wp_get_attachment_url( $img_centerright ) ) !== false ) {
				$extend_anima_imgs .= '<div class="cata-item-img cata-img-centerright has-animation" data-animation-type="slideInRight" data-animation-delay="350"><img src="' . $image_url . '" alt=""/></div>';
			}
			
			if ( (int) $img_bottomleft > 0 && ( $image_url = wp_get_attachment_url( $img_bottomleft ) ) !== false ) {
				$extend_anima_imgs .= '<div class="cata-item-img cata-img-bottomleft has-animation" data-animation-type="slideInLeft" data-animation-delay="400"><img src="' . $image_url . '" alt=""/></div>';
			}
			if ( (int) $img_bottomright > 0 && ( $image_url = wp_get_attachment_url( $img_bottomright ) ) !== false ) {
				$extend_anima_imgs .= '<div class="cata-item-img cata-img-bottomright has-animation" data-animation-type="slideInRight" data-animation-delay="400"><img src="' . $image_url . '" alt=""/></div>';
			}
			
			if ( (int) $img_topcenter > 0 && ( $image_url = wp_get_attachment_url( $img_topcenter ) ) !== false ) {
				$extend_anima_imgs .= '<div class="cata-item-img cata-img-topcenter has-animation" data-animation-type="slideInDown" data-animation-delay="300"><img src="' . $image_url . '" alt=""/></div>';
			}
			if ( (int) $img_bottomcenter > 0 && ( $image_url = wp_get_attachment_url( $img_bottomcenter ) ) !== false ) {
				$extend_anima_imgs .= '<div class="cata-item-img cata-img-bottomcenter has-animation" data-animation-type="slideInUp" data-animation-delay="400"><img src="' . $image_url . '" alt=""/></div>';
			}
			$extend_anima_imgs .= '</div>';
		}
		
		/* For scroll_to_down */
		if ( ! empty( $scroll_to_down ) ) {
			$elemClass[] = ' scrollToDownSection';
			$elemAttribute[] = 'data-section-id="'. esc_attr($scroll_to_down_id) .'"';
			$elemAttribute[] = 'data-section-title="'. esc_attr($scroll_to_down_title) .'"';
		}
		
		/* Background color */
		if( $bg_type == 'color' ){
			$elemStyle .= 'background-color:'. $bg_color .';';
		}
		
		/* Background image/parallax */
		$texture_html = '';
		if($bg_type == 'image' ){
			
			if( ! empty( $use_parallax ) ){
				$elemClass[] = 'cata-parallax-bg';
				$parallax_speed = floatval($parallax_speed);
				if( $parallax_speed == false ){
					$parallax_speed = 0.1;
				}
				$elemAttribute[] = 'data-prlx-speed="' . $parallax_speed . '"';
			}
		
			if ( (int) $bg_image > 0 && ( $image_url = wp_get_attachment_url( $bg_image ) ) !== false ) {
				$elemStyle .= 'background-image: url(' . $image_url . ');';
				$elemStyle .= 'background-repeat: ' . $bg_image_repeat . ';';
				$elemStyle .= 'background-size: ' . $bg_image_size . ';';
				$elemStyle .= 'background-position: ' . str_replace('-', ' ', $bg_image_position) . ';';
				
				if ( ! empty( $overflow_hidden ) ) {
					$elemStyle .= 'overflow: hidden;';
				}
			}
				
		}
		
		if( ! empty( $add_texture ) && in_array($bg_type, array('color', 'image') )) {
		
			if ( (int) $texture_top > 0 && ( $texture_top_image_url = wp_get_attachment_url( $texture_top ) ) !== false ) {
				$texture_html .= '<div class="selection-texture tt-top">';
				$texture_html .= '<img src="'. $texture_top_image_url .'" alt="'. esc_attr__('Texture top', 'catanis-core') .'"/>';
				$texture_html .= '</div>';
			}
			if ( (int) $texture_bottom > 0 && ( $texture_bottom_image_url = wp_get_attachment_url( $texture_bottom ) ) !== false ) {
				$texture_html .= '<div class="selection-texture tt-bottom">';
				$texture_html .= '<img src="'. $texture_bottom_image_url .'" alt="'. esc_attr__('Texture bottom', 'catanis-core') .'"/>';
				$texture_html .= '</div>';
			}
		}
		
		/* Background video */
		$outputVideo = '';
		$dataSetup = array();
		if( ($bg_type == 'youtube' && $video_url_youtube != '') || ($bg_type == 'vimeo' && $video_url_vimeo != '') || ( $bg_type == 'self' && ($video_url_mp4 != '' || $video_url_webm != '') ) ){
			$elemClass[] = 'cata-section-video';
			$elemClass[] = $show_video_control;
			
			$sources = '';
			$video_opts = explode(',', $video_opts);
			
			if(is_numeric($video_poster)){
				$video_poster =  wp_get_attachment_url( $video_poster ) ;
				$poster = (false == $video_poster)? CATANIS_DEFAULT_IMAGE : $video_poster;
				$dataSetup['poster'] = esc_url($video_poster);
			}
			
			wp_enqueue_script('catanis-js-videojs');
			if($bg_type == 'self') {
				if($video_url_mp4!='') {
					$sources .= '<source src="'.esc_url($video_url_mp4).'" type="video/mp4">';
				}
			
				if($video_url_webm!='') {
					$sources .= '<source src="'.esc_url($video_url_webm).'" type="video/webm">';
				}
					
				if($video_url_ogg!='') {
					$sources .= '<source src="'.esc_url($video_url_ogg).'" type="video/ogg">';
				}
			
			}elseif($bg_type == 'youtube'){
				wp_enqueue_script('catanis-js-videojs-youtube');
				$dataSetup['techOrder'] = array('youtube');
				$dataSetup['sources'] = array(array(
						'type' 	=> 'video/youtube',
						'src' 	=> esc_url($video_url_youtube)
				));
					
			}elseif($bg_type == 'vimeo'){
				wp_enqueue_script('catanis-js-videojs-vimeo');
					
				$dataSetup['techOrder'] = array('vimeo');
				$dataSetup['sources'] = array(array(
						'type' 	=> 'video/vimeo',
						'src' 	=> esc_url($video_url_vimeo)
				));
			}
			
			if(is_array($video_opts)){
				if(in_array('muted', $video_opts)){
					$bg_type .= ' muted';
				}
				
				if(in_array('loop', $video_opts)){
					$dataSetup['loop'] = true;
				}
			}
			
			if( (is_array($video_opts) && in_array('autoplay', $video_opts)) || $show_video_control == 'no-video-control'){
				$dataSetup['autoplay'] = true;
				$bg_type .= ' autoplay';
			}
			
			if(isset($dataSetup['autoplay']) && $dataSetup['autoplay'] == true){
				$bg_type .= ' playing';
			}else{
				$bg_type .= ' pausing';
			}
			
			$elemID = catanis_random_string(10, 'video');
			$outputVideo .= '<div id="'.$elemID.'" class="cata-section-video-bg video-host-'. $bg_type .'"><div class="video-control"></div><div class="wrap-cata-video">';
			$outputVideo .= '<video id="s'. $elemID .'" name="sc_video" data-setup='. json_encode($dataSetup) .' class="video-js vjs-default-skin">'. $sources .'<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p></video>';
			$outputVideo .= '</div></div>';
		}
		
		$elemAttribute[] = 'style="'. $elemStyle .'"';
		
		if( $row_stretch == 'container' ){ 
			$xhtml .= '<div class="cata-container">';
		} 
		$xhtml .= '<section class="'. implode( ' ', $elemClass ) .'" ' . implode( ' ', $elemAttribute ) . ' '. trim($animation['animation-attrs']) .'>';
			if( ! empty( $show_overlay )) {
				$opacity_attribute 	= !empty( $overlay_opacity ) ? 'opacity:'. $overlay_opacity .';' : '';
				$opacity_attribute .= !empty( $overlay_color ) ? ' background-color:'. $overlay_color .';' : '';
				$xhtml .= '<div class="selection-overlay" style="'. $opacity_attribute .'"></div>';
			}
			
			$xhtml .= $texture_html . $extend_anima_imgs;
			
			$xhtml .=  $outputVideo;
			if(!empty($outputVideo) && !empty($show_video_control)): $xhtml .= '<div class="cata-video-content-wrap">'; endif;
			
			if( in_array($row_stretch, array('container_stretch')) ){
				$xhtml .= '<div class="cata-container">';
			}
			if( in_array($row_stretch, array('container_fluid')) ){
				$xhtml .= '<div class="container-fluid">';
			}
			
			$xhtml .= '<div class="cata-row cata-columns-gap-'. $columns_gap .'">';			
				$xhtml .= do_shortcode($content);			
			$xhtml .= '</div>';
			if( in_array($row_stretch, array('container_stretch','container_fluid')) ){
				$xhtml .= '</div>';
			}
			
			if(!empty($outputVideo) && !empty($show_video_control)): $xhtml .= '</div>'; endif;
		$xhtml .= '</section>';
		if( $row_stretch == 'container' ){ 
			$xhtml .= '</div>';
		} 
		
		return $xhtml;
	}
}
add_shortcode( 'vc_row', 'catanis_row_shortcode_function' );
add_shortcode( 'vc_section', 'catanis_row_shortcode_function' );


/*=== SHORTCODE - VISUAL ROW INNER ===========*/
/*============================================*/
if ( ! function_exists( 'catanis_row_inner_shortcode_function' ) ) {
	function catanis_row_inner_shortcode_function( $atts, $content = null ) {

		$xhtml = '';
		$row_stretch = $bg_type = $bg_color = $bg_image = $bg_image_size = $bg_image_position = $bg_image_repeat = '';
		$show_overlay = $overlay_opacity = $overlay_color = $use_parallax = $parallax_speed = '';
		$video_url_youtube = $video_url_vimeo = $video_url_mp4 = $video_url_webm = $video_url_ogg = $video_poster = $show_video_control = $video_opts = '';
		$desktop_padding_top = $desktop_padding_right = $desktop_padding_bottom = $desktop_padding_left = '';
		$desktop_margin_top = $desktop_margin_right = $desktop_margin_bottom = $desktop_margin_left = '';
		$row_border = $border_color = $border_size = $border_type = '';
		$ipad_custom_padding_margin = $ipad_padding_top = $ipad_padding_right = $ipad_padding_bottom = $ipad_padding_left = '';
		$ipad_margin_top = $ipad_margin_right = $ipad_margin_bottom = $ipad_margin_left = '';
		$mobile_custom_padding_margin = $mobile_padding_top = $mobile_padding_right = $mobile_padding_bottom = $mobile_padding_left = '';
		$mobile_margin_top = $mobile_margin_right = $mobile_margin_bottom = $mobile_margin_left = $disable_element = $ext_class = $ext_id = '';

		extract( shortcode_atts( array(
			'row_stretch'  					=> 'container',		/*container, fullwidth*/
			
			'bg_type'  						=> 'no_bg',			/*no_bg, color, image, youtube, vimeo, self*/
			'bg_color' 						=> '#FFFFFF',
			'bg_image' 						=> '',
			'bg_image_size' 				=> 'cover',			/*cover, contain, initial*/
			'bg_image_position' 			=> 'center-center',	/*center-center, center-top, center-bottom, left-top, left-center, left-bottom, right-top, right-center,right-bottom*/
			'bg_image_repeat' 				=> 'no-repeat',		/*no-repeat, repeat-x, repeat-y, repeat*/
			'show_overlay' 					=> '',				/*NULL,yes*/
			'overlay_opacity' 				=> '',				/*0.1->1.0*/
			'overlay_color' 				=> '',
			'use_parallax' 					=> '',				/*NULL,yes*/
			'parallax_speed' 				=> '0.1',
			'video_url_youtube' 			=> '',
			'video_url_vimeo' 				=> '',
			'video_url_mp4' 				=> '',
			'video_url_webm' 				=> '',
			'video_url_ogg' 				=> '',
			'video_poster' 					=> '',
			'show_video_control' 			=> 'show-video-control',	/*no-video-control,show-video-control*/
			'video_opts' 					=> '',						/*multi checkbox: autoplay, loop, muted*/
			'desktop_padding_top' 			=> '',
			'desktop_padding_right' 		=> '',
			'desktop_padding_bottom' 		=> '',
			'desktop_padding_left' 			=> '',
			'desktop_margin_top' 			=> '',
			'desktop_margin_right' 			=> '',
			'desktop_margin_bottom' 		=> '30px',
			'desktop_margin_left' 			=> '',
			'row_border' 					=> '',				/*NULL,border-top, border-bottom*/
			'border_color' 					=> '',
			'border_size' 					=> 0,
			'border_type' 					=> '',				/*NULL,dotted,dashed,solid,double*/
			'ipad_custom_padding_margin' 	=> '',				/*NULL,yes*/
			'ipad_padding_top' 				=> '',
			'ipad_padding_right' 			=> '',
			'ipad_padding_bottom' 			=> '',
			'ipad_padding_left' 			=> '',
			'ipad_margin_top' 				=> '',
			'ipad_margin_right' 			=> '',
			'ipad_margin_bottom' 			=> '',
			'ipad_margin_left' 				=> '',
			'mobile_custom_padding_margin' 	=> '',				/*NULL,yes*/
			'mobile_padding_top' 			=> '',
			'mobile_padding_right' 			=> '',
			'mobile_padding_bottom' 		=> '',
			'mobile_padding_left' 			=> '',
			'mobile_margin_top' 			=> '',
			'mobile_margin_right' 			=> '',
			'mobile_margin_bottom' 			=> '',
			'mobile_margin_left' 			=> '',
			'disable_element' 				=> '',				/*NULL,yes*/
			'ext_class' 					=> '',
			'ext_id' 						=> ''
		), $atts ) );

		if ( ! empty( $disable_element ) ) {
			return '';
		}

		$elemAttribute = $elemClass = array();
		$elemStyle = '';

		$elemID = catanis_random_string(10, 'row');
		if ( ! empty( $ext_id ) ) {
			$elemAttribute[] = 'id="' . esc_attr( $ext_id ) . '"';
		}else{
			$elemAttribute[] = 'id="' . esc_attr( $elemID ) . '"';
		}

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemClass[] = 'cata-inner-row '. $elemID;

		$elemClass[] = 'cata-inner-row-' . $row_stretch;
		if ( ! empty( $animation['has-animation'] ) ) {
			$elemClass[] = $animation['has-animation'];
		}
		if ( ! empty( $ext_class ) ) {
			$elemClass[] = $ext_class;
		}

		/* For class padding/margin Ipab */
		if ( ! empty( $ipad_custom_padding_margin ) ) {
			
			if ( ! empty( $ipad_margin_top ) ) {
				$elemClass[] = $ipad_margin_top;
			}
			if ( ! empty( $ipad_margin_right ) ) {
				$elemClass[] = $ipad_margin_right;
			}
			if ( ! empty( $ipad_margin_bottom ) ) {
				$elemClass[] = $ipad_margin_bottom ;
			}
			if ( ! empty( $ipad_margin_left ) ) {
				$elemClass[] = $ipad_margin_left ;
			}
			
			if ( ! empty( $ipad_padding_top ) ) {
				$elemClass[] = $ipad_padding_top ;
			}
			if ( ! empty( $ipad_padding_right ) ) {
				$elemClass[] = $ipad_padding_right;
			}
			if ( ! empty( $ipad_padding_bottom ) ) {
				$elemClass[] = $ipad_padding_bottom;
			}
			if ( ! empty( $ipad_padding_left ) ) {
				$elemClass[] = $ipad_padding_left;
			}
		}
		
		/* For class padding/margin Mobile */
		if ( ! empty( $mobile_custom_padding_margin ) ) {
				
			if ( ! empty( $mobile_margin_top ) ) {
				$elemClass[] = $mobile_margin_top ;
			}
			if ( ! empty( $mobile_margin_right ) ) {
				$elemClass[] = $mobile_margin_right ;
			}
			if ( ! empty( $mobile_margin_bottom ) ) {
				$elemClass[] = $mobile_margin_bottom ;
			}
			if ( ! empty( $mobile_margin_left ) ) {
				$elemClass[] = $mobile_margin_left ;
			}
				
			if ( ! empty( $mobile_padding_top ) ) {
				$elemClass[] = $mobile_padding_top;
			}
			if ( ! empty( $mobile_padding_right ) ) {
				$elemClass[] = $mobile_padding_right ;
			}
			if ( ! empty( $mobile_padding_bottom ) ) {
				$elemClass[] = $mobile_padding_bottom;
			}
			if ( ! empty( $mobile_padding_left ) ) {
				$elemClass[] = $mobile_padding_left ;
			}
		}

		/* For class padding/margin Desktop */
		$elemStyle .= ( $desktop_padding_top != '' ) ? ' padding-top:'. $desktop_padding_top .';' : '';
		$elemStyle .= ( $desktop_padding_right != '' ) ? ' padding-right:'. $desktop_padding_right .';' : '';
		$elemStyle .= ( $desktop_padding_bottom != '' ) ? ' padding-bottom:'. $desktop_padding_bottom .';' : '';
		$elemStyle .= ( $desktop_padding_left != '' ) ? ' padding-left:'. $desktop_padding_left .';' : '';
		$elemStyle .= ( $desktop_margin_top != '' ) ? ' margin-top:'. $desktop_margin_top .';' : '';
		$elemStyle .= ( $desktop_margin_right != '' ) ? ' margin-right:'. $desktop_margin_right .';' : '';
		$elemStyle .= ( $desktop_margin_bottom != '' && $desktop_margin_bottom != '30px' ) ? ' margin-bottom:'. $desktop_margin_bottom .';' : '';
		$elemStyle .= ( $desktop_margin_left != '' ) ? ' margin-left:'. $desktop_margin_left .';' : '';

		/* For Border */
		$row_border = ($row_border) ? $row_border . ': ' : '';
		if($row_border){
			$row_border .= ($border_size) ? $border_size .'px' : '';
			$row_border .= ($border_type) ? ' '.$border_type : '';
			$row_border .= ($border_color) ? ' '.$border_color : '';
			$row_border .= ';';
			
			$elemStyle .= $row_border;
		}

		/* Background color */
		if( $bg_type == 'color' ){
			$elemStyle .= 'background-color:'. $bg_color .';';
		}

		/* Background image/parallax */
		if($bg_type == 'image' ){
				
			if( ! empty( $use_parallax ) ){
				$elemClass[] = 'cata-parallax-bg';
				$parallax_speed = floatval($parallax_speed);
				if( $parallax_speed == false ){
					$parallax_speed = 0.1;
				}
				$elemAttribute[] = 'data-prlx-speed="' . $parallax_speed . '"';
			}

			if ( (int) $bg_image > 0 && ( $image_url = wp_get_attachment_url( $bg_image ) ) !== false ) {
				$elemStyle .= 'background-image: url(' . $image_url . ');';
				$elemStyle .= 'background-repeat: ' . $bg_image_repeat . ';';
				$elemStyle .= 'background-size: ' . $bg_image_size . ';';
				$elemStyle .= 'background-position: ' . str_replace('-', ' ', $bg_image_position) . ';';
			}
		}

		/* Background video */
		$outputVideo = '';
		$dataSetup = array();
		if( ($bg_type == 'youtube' && $video_url_youtube != '') || ($bg_type == 'vimeo' && $video_url_vimeo != '') || ( $bg_type == 'self' && ($video_url_mp4 != '' || $video_url_webm != '') ) ){
			$elemClass[] = 'cata-section-video';
			$elemClass[] = $show_video_control;
				
			$sources = '';
			$video_opts = explode(',', $video_opts);
				
			if(is_numeric($video_poster)){
				$video_poster =  wp_get_attachment_url( $video_poster ) ;
				$poster = (false == $video_poster)? CATANIS_DEFAULT_IMAGE : $video_poster;
				$dataSetup['poster'] = esc_url($video_poster);
			}
			wp_enqueue_script('catanis-js-videojs');
			if($bg_type == 'self') {
				if($video_url_mp4!='') {
					$sources .= '<source src="'.esc_url($video_url_mp4).'" type="video/mp4">';
				}
					
				if($video_url_webm!='') {
					$sources .= '<source src="'.esc_url($video_url_webm).'" type="video/webm">';
				}
					
				if($video_url_ogg!='') {
					$sources .= '<source src="'.esc_url($video_url_ogg).'" type="video/ogg">';
				}
					
			}elseif($bg_type == 'youtube'){
				wp_enqueue_script('catanis-js-videojs-youtube');
					
				$dataSetup['techOrder'] = array('youtube');
				$dataSetup['sources'] = array(array(
						'type' 	=> 'video/youtube',
						'src' 	=> esc_url($video_url_youtube)
				));
					
			}elseif($bg_type == 'vimeo'){
				wp_enqueue_script('catanis-js-videojs-vimeo');
					
				$dataSetup['techOrder'] = array('vimeo');
				$dataSetup['sources'] = array(array(
					'type' 	=> 'video/vimeo',
					'src' 	=> esc_url($video_url_vimeo)
				));
			}
				
			if(is_array($video_opts)){
				if(in_array('muted', $video_opts)){
					$bg_type .= ' muted';
				}

				if(in_array('loop', $video_opts)){
					$dataSetup['loop'] = true;
				}
			}
				
			if( (is_array($video_opts) && in_array('autoplay', $video_opts)) || $show_video_control == 'show-video-control'){
				$dataSetup['autoplay'] = true;
				$bg_type .= ' autoplay';
			}
				
			if(isset($dataSetup['autoplay']) && $dataSetup['autoplay'] == true){
				$bg_type .= ' playing';
			}else{
				$bg_type .= ' pausing';
			}
				
			$elemID = catanis_random_string(10, 'video');
			$outputVideo = '<div id="'.$elemID.'" class="ca-row-video-bg video-host-'. $bg_type .'"><div class="video-control"></div><div class="wrap-cata-video">';
			$outputVideo .= '<video id="s'. $elemID .'" name="sc_video" data-setup='. json_encode($dataSetup) .' class="video-js vjs-default-skin">'. $sources .'<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p></video>';
			$outputVideo .= '</div></div>';
		}

		$elemAttribute[] = 'style="'. $elemStyle .'"';
		$xhtml .= '<div class="'. implode( ' ', $elemClass ) .'" ' . implode( ' ', $elemAttribute ) . ' '. trim($animation['animation-attrs']) .'>';
		if( ! empty( $show_overlay )) {
			$opacity_attribute 	= !empty( $overlay_opacity ) ? 'opacity:'. $overlay_opacity .';' : '';
			$opacity_attribute .= !empty( $overlay_color ) ? ' background-color:'. $overlay_color .';' : '';

			$xhtml .= '<div class="selection-overlay" style="'. $opacity_attribute .'"></div>';
		}
			
		$xhtml .=  $outputVideo;
		if(!empty($outputVideo) && !empty($show_video_control)): $xhtml .= '<div class="cata-video-content-wrap">'; endif;
		$xhtml .= do_shortcode($content);
		if(!empty($outputVideo) && !empty($show_video_control)): $xhtml .= '</div>'; endif;
			
		$xhtml .= '</div>';

		return $xhtml;
		
	}
}
add_shortcode( 'vc_row_inner', 'catanis_row_inner_shortcode_function' );


/*=== SHORTCODE - VISUAL COLUMN ==============*/
/*============================================*/
if ( ! function_exists( 'catanis_column_shortcode_function' ) ) {
	function catanis_column_shortcode_function( $atts, $content = null ) {
		$xhtml = '';
		$column_link = $alignment = $min_height = $content_vertical = $clear_both = $pull_right = '';
		$bg_type = $bg_color = $bg_image = $bg_image_size = $bg_image_position = $bg_image_repeat = '';
		$show_overlay = $overlay_opacity = $overlay_color = $use_parallax = $parallax_speed = '';
		$video_url_youtube = $video_url_vimeo = $video_url_mp4 = $video_url_webm = $video_url_ogg = $video_poster = $show_video_control = $video_opts = '';
		$desktop_padding_top = $desktop_padding_right = $desktop_padding_bottom = $desktop_padding_left = '';
		$desktop_margin_top = $desktop_margin_right = $desktop_margin_bottom = $desktop_margin_left = '';
		$column_border = $border_color = $border_size = $border_type = '';
		$ipad_custom_padding_margin = $ipad_padding_top = $ipad_padding_right = $ipad_padding_bottom = $ipad_padding_left = '';
		$ipad_margin_top = $ipad_margin_right = $ipad_margin_bottom = $ipad_margin_left = '';
		$mobile_custom_padding_margin = $mobile_padding_top = $mobile_padding_right = $mobile_padding_bottom = $mobile_padding_left = '';
		$mobile_margin_top = $mobile_margin_right = $mobile_margin_bottom = $mobile_margin_left = $disable_element = '';
		$offset = $width = $ext_class = $ext_id = '';
		
		extract( shortcode_atts( array(
			'column_link'  					=> '', 					/**/
			'alignment'  					=> '', 					/**/
			'min_height'  					=> '',					/**/
			'pull_right'  					=> '',					/*yes*/
			'clear_both'  					=> '',					/*yes*/
			'bg_type'  						=> 'no_bg',				/*no_bg, color, image*/
			'bg_color' 						=> '#FFFFFF',
			'bg_image' 						=> '',
			'bg_image_size' 				=> 'cover',				/*cover, contain, initial*/
			'bg_image_position' 			=> 'center-center',		/*center-center, center-top, center-bottom, left-top, left-center, left-bottom, right-top, right-center,right-bottom*/
			'bg_image_repeat' 				=> 'no-repeat',			/*no-repeat, repeat-x, repeat-y, repeat*/
			'show_overlay' 					=> '',					/*yes*/
			'overlay_opacity' 				=> '',					/*0.1->1.0*/
			'overlay_color' 				=> '',
			'use_parallax' 					=> '',					/*yes*/
			'parallax_speed' 				=> '0.1',
			'desktop_padding_top' 			=> '',
			'desktop_padding_right' 		=> '',
			'desktop_padding_bottom' 		=> '',
			'desktop_padding_left' 			=> '',
			'desktop_margin_top' 			=> '',
			'desktop_margin_right' 			=> '',
			'desktop_margin_bottom' 		=> '',
			'desktop_margin_left' 			=> '',
			'column_border' 					=> '',				/*border-top,border-bottom,border-left,border-right,border-all,topbottom,leftright,topleft,topright*/
			'border_color' 				=> '',
			'border_size' 				=> 0,
			'border_type' 				=> '',						/*dotted,dashed,solid,double*/
			'ipad_custom_padding_margin' 	=> '',					/*yes*/
			'ipad_padding_top' 				=> '',
			'ipad_padding_right' 			=> '',
			'ipad_padding_bottom' 			=> '',
			'ipad_padding_left' 			=> '',
			'ipad_margin_top' 				=> '',
			'ipad_margin_right' 			=> '',
			'ipad_margin_bottom' 			=> '',
			'ipad_margin_left' 				=> '',
			'mobile_custom_padding_margin' 	=> '',					/*yes*/
			'mobile_padding_top' 			=> '',
			'mobile_padding_right' 			=> '',
			'mobile_padding_bottom' 		=> '',
			'mobile_padding_left' 			=> '',
			'mobile_margin_top' 			=> '',
			'mobile_margin_right' 			=> '',
			'mobile_margin_bottom' 			=> '',
			'mobile_margin_left' 			=> '',
			'width' 						=> '1/1',
			'offset' 						=> '',
			'ext_class' 					=> '',
			'ext_id' 						=> ''
		), $atts ) );
	
		$elemAttribute = $elemClass = array();
		$elemStyle = '';
		
		$elemID = catanis_random_string(10, 'column');
		if ( ! empty( $ext_id ) ) {
			$elemAttribute[] = 'id="' . esc_attr( $ext_id ) . '"';
		}else{
			$elemAttribute[] = 'id="' . esc_attr( $elemID ) . '"';
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemClass[] = 'cata-column wpb_column vc_column_container';
		
		if ( ! empty( $clear_both ) ) {
			$elemClass[] = 'clearboth';
		}
		if ( ! empty( $alignment ) ) {
			$elemClass[] = $alignment;
		}
		if ( ! empty( $pull_right ) ) {
			$elemClass[] = 'pull-right';
		}
		
		if ( ! empty( $animation['has-animation'] ) ) {
			$elemClass[] = $animation['has-animation'];
		}
		if ( ! empty( $ext_class ) ) {
			$elemClass[] = $ext_class;
		}
		
		/* For class padding/margin Ipab */
		if ( ! empty( $ipad_custom_padding_margin ) ) {
			
			if ( ! empty( $ipad_margin_top ) ) {
				$elemClass[] = $ipad_margin_top;
			}
			if ( ! empty( $ipad_margin_right ) ) {
				$elemClass[] = $ipad_margin_right;
			}
			if ( ! empty( $ipad_margin_bottom ) ) {
				$elemClass[] = $ipad_margin_bottom ;
			}
			if ( ! empty( $ipad_margin_left ) ) {
				$elemClass[] = $ipad_margin_left ;
			}
			
			if ( ! empty( $ipad_padding_top ) ) {
				$elemClass[] = $ipad_padding_top ;
			}
			if ( ! empty( $ipad_padding_right ) ) {
				$elemClass[] = $ipad_padding_right;
			}
			if ( ! empty( $ipad_padding_bottom ) ) {
				$elemClass[] = $ipad_padding_bottom;
			}
			if ( ! empty( $ipad_padding_left ) ) {
				$elemClass[] = $ipad_padding_left;
			}
		}
		
		/* For class padding/margin Mobile */
		if ( ! empty( $mobile_custom_padding_margin ) ) {
				
			if ( ! empty( $mobile_margin_top ) ) {
				$elemClass[] = $mobile_margin_top ;
			}
			if ( ! empty( $mobile_margin_right ) ) {
				$elemClass[] = $mobile_margin_right ;
			}
			if ( ! empty( $mobile_margin_bottom ) ) {
				$elemClass[] = $mobile_margin_bottom ;
			}
			if ( ! empty( $mobile_margin_left ) ) {
				$elemClass[] = $mobile_margin_left ;
			}
				
			if ( ! empty( $mobile_padding_top ) ) {
				$elemClass[] = $mobile_padding_top;
			}
			if ( ! empty( $mobile_padding_right ) ) {
				$elemClass[] = $mobile_padding_right ;
			}
			if ( ! empty( $mobile_padding_bottom ) ) {
				$elemClass[] = $mobile_padding_bottom;
			}
			if ( ! empty( $mobile_padding_left ) ) {
				$elemClass[] = $mobile_padding_left ;
			}
		}
		
		/* For class padding/margin Desktop */
		$elemStyle .= ($desktop_padding_top) ? 'padding-top:'. $desktop_padding_top .';' : '';
		$elemStyle .= ($desktop_padding_right) ? 'padding-right:'. $desktop_padding_right .';' : '';
		$elemStyle .= ($desktop_padding_bottom) ? 'padding-bottom:'. $desktop_padding_bottom .';' : '';
		$elemStyle .= ($desktop_padding_left) ? 'padding-left:'. $desktop_padding_left .';' : '';
		$elemStyle .= ($desktop_margin_top) ? 'margin-top:'. $desktop_margin_top .';' : '';
		$elemStyle .= ($desktop_margin_right) ? 'margin-right:'. $desktop_margin_right .';' : '';
		$elemStyle .= ($desktop_margin_bottom) ? 'margin-bottom:'. $desktop_margin_bottom .';' : '';
		$elemStyle .= ($desktop_margin_left) ? 'margin-left:'. $desktop_margin_left .';' : '';
		
		/* For Border */
		$border_val = $elemStyleInner = '';
		if(!empty($column_border)){
			$border_style = '';
			
			$border_val .= ($border_size) ? $border_size .'px' : '';
			$border_val .= ($border_type) ? ' '. $border_type : '';
			$border_val .= ($border_color) ? ' '. $border_color : '';
			$border_val .= ';';
			
			if(in_array($column_border, array('border-all','topbottom','leftright','topleft','topright'))){
				switch ($column_border){
					case "border-all":
						$border_style .= 'border:'. $border_val;
						break;
					case "topbottom":
						$border_style .= 'border-top:'. $border_val;
						$border_style .= 'border-bottom:'. $border_val;
						break;
					case "leftright":
						$border_style .= 'border-left:'. $border_val;
						$border_style .= 'border-right:'. $border_val;
						break;
					case "topleft":
						$border_style .= 'border-top:'. $border_val;
						$border_style .= 'border-left:'. $border_val;
						break;
					case "topright":
						$border_style .= 'border-top:'. $border_val;
						$border_style .= 'border-right:'. $border_val;
						break;
				}
			}else{
				$border_style .= $column_border . ':' . $border_val;
			}
			
			$elemStyleInner .= $border_style;
		}
		
		/* For min-height */
		if(!empty($min_height)){
			$elemStyle .= 'min-height:'. $min_height.'px;';
		}
		
		/* For Offset and Width */
		$offset = ( $offset ) ? str_replace( 'vc_', '', $offset ) : '';
		if(strchr($offset, 'col-xs')):
			$elemClass[] = $offset;
		else:
			$elemClass[] = $offset . " col-xs-mobile-fullwidth";
		endif; 

		$width = explode('/', $width);
		
		if( $width[0] == '1' && $width[1] == '1' ){
			$elemClass[] = 'col-sm-12';
		}
		if( $width[0] != '1' ){
			$elemClass[] = ' col-sm-'.$width[0] * floor(12 / $width[1]);
		}else{
			if( $width[1] != '1' ){
				$elemClass[] = ' col-sm-'.floor(12 / $width[1]);
			}
		}
		
		/* Background color */#FFFFFF
		if( $bg_type == 'color' ){
			$elemStyle .= 'background-color:'. $bg_color .';';
		}
		
		/* Background image/parallax */
		if($bg_type == 'image' ){
		
			if( ! empty( $use_parallax ) ){
				$elemClass[] = 'cata-parallax-bg';
				$parallax_speed = floatval($parallax_speed);
				if( $parallax_speed == false ){
					$parallax_speed = 0.1;
				}
				$elemAttribute[] = 'data-prlx-speed="' . $parallax_speed . '"';
			}
		
			if ( (int) $bg_image > 0 && ( $image_url = wp_get_attachment_url( $bg_image ) ) !== false ) {
				$elemStyle .= 'background-image: url(' . $image_url . ');';
				$elemStyle .= 'background-repeat: ' . $bg_image_repeat . ';';
				$elemStyle .= 'background-size: ' . $bg_image_size . ';';
				$elemStyle .= 'background-position: ' . str_replace('-', ' ', $bg_image_position) . ';';
			}
		}
		
		$html_column_link = '';
		if(!empty($column_link)){
			$html_column_link = '<a href="'. esc_url($column_link) .'" class="column-link"></a>';
		}
		
		/* Output HTML */
		$elemAttribute[] = 'style="'. $elemStyle .'"';
		$xhtml .= '<div class="'. implode( ' ', $elemClass ) .'" '. trim($animation['animation-attrs']) .' ' . implode( ' ', $elemAttribute ) . '>';
		$xhtml .= '<div class="cata-column-wrapper vc-column-innner-wrapper" style="' . $elemStyleInner . '">';
		$xhtml .= do_shortcode( $content );
		$xhtml .= $html_column_link;
		$xhtml .= '</div>';
		$xhtml .= '</div>'; 
		
		return $xhtml;
		
	}
}
add_shortcode( 'vc_column', 'catanis_column_shortcode_function' );
add_shortcode( 'vc_column_inner', 'catanis_column_shortcode_function' );


/*=== CATANIS SHORTCODE - MENU ===============*/
/*============================================*/
if ( ! function_exists( 'catanis_menu_shortcode_function' ) ) {
	function catanis_menu_shortcode_function( $atts, $content = null ) {

		$name = '';
		extract( shortcode_atts( array( 'name' => null ), $atts ) );

		if ( is_nav_menu( $name ) ) {
			return wp_nav_menu( array( 'menu' => $name, 'echo' => false ) );
		} else {
			return '';
		}
	}
}
add_shortcode( 'cata_menu', 'catanis_menu_shortcode_function' );


/*=== CATANIS SHORTCODE - COLUMNS ============*/
/*============================================*/
if ( ! function_exists( 'catanis_columns_shortcode_function' ) ) {
	function catanis_columns_shortcode_function( $atts, $content = null, $code ) {

		$ext_class = '';
		extract( shortcode_atts( array(
		'ext_class'=>'',
		), $atts ) );

		$arrColumns = array(
				'cata_one_columns' 		=> 'cols-1',
				'cata_two_columns' 		=> 'cols-2',
				'cata_three_columns' 	=> 'cols-3',
				'cata_four_columns' 	=> 'cols-4',
				'cata_five_columns' 	=> 'cols-5',
				'cata_cols34_columns' 	=> 'cols-34',
				'cata_cols23_columns' 	=> 'cols-23'
		);

		$extClass = $arrColumns[$code];
		if ( isset( $class ) && ! empty( $ext_class ) ) { $extClass .= " " . $ext_class; }

		return '<div class="cata-cols-wrapper ' . $extClass . '">' . do_shortcode( trim( $content ) ) . '</div>';
	}
}
add_shortcode( 'cata_one_columns', 'catanis_columns_shortcode_function' );
add_shortcode( 'cata_two_columns', 'catanis_columns_shortcode_function' );
add_shortcode( 'cata_three_columns', 'catanis_columns_shortcode_function' );
add_shortcode( 'cata_four_columns', 'catanis_columns_shortcode_function' );
add_shortcode( 'cata_five_columns', 'catanis_columns_shortcode_function' );
add_shortcode( 'cata_cols34_columns', 'catanis_columns_shortcode_function' );
add_shortcode( 'cata_cols23_columns', 'catanis_columns_shortcode_function' );

if ( ! function_exists( 'catanis_column_shortcode_function' ) ) {
	function catanis_column_shortcode_function( $atts, $content = null, $code ) {
		if ( $code == 'cata_column_last' ) {
			return '<div class="col nomargin">' . do_shortcode( trim( $content ) ) . '</div>';
		} else {
			return '<div class="col">' . do_shortcode( trim( $content ) ) . '</div>';
		}
	}
}
add_shortcode('cata_column', 'catanis_column_shortcode_function');
add_shortcode('cata_column_last', 'catanis_column_shortcode_function');


/*=== SHORTCODE - COLUMN TEXT ================*/
/*============================================*/
if ( ! function_exists( 'catanis_column_text_shortcode_function' ) ) {
	function catanis_column_text_shortcode_function( $atts, $content = null) {

		$xhtml = $text_color = $css = $ext_class = '';
		extract( shortcode_atts( array(
			'text_color' 		=> 'dark',  	/* dark & white */
			'css' 				=> '',
			'ext_class' 		=> ''
		), $atts ) );

		$animation 	= catanis_shortcodeAnimation($atts);
		$class_to_filter = 'cata-text-column cata-element ' .vc_shortcode_custom_css_class( $css, ' ' ) . ' color-' .$text_color;
		$class_to_filter .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$class_to_filter .= (!empty($ext_class) ) ? ' '. $ext_class : '';

		$elemClass = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, 'cata_column_text', $atts );

		$xhtml = '<div class="' . esc_attr( $elemClass ) . '" '. trim($animation['animation-attrs']).'>
					<div class="text_wrapper">' . wpb_js_remove_wpautop( $content, true ) . '</div>
				</div>';

		return $xhtml;
	}
}
add_shortcode( 'cata_column_text', 'catanis_column_text_shortcode_function' );


/*=== CATANIS SHORTCODE - EMPTY SPACE ========*/
/*============================================*/
if ( ! function_exists( 'catanis_empty_space_shortcode_function' ) ) {
	function catanis_empty_space_shortcode_function( $atts, $content = null) {

		$xhtml = $height = $custom_mobile = $mobile_height = $css = $ext_class = '';
		extract( shortcode_atts( array(
			'height' 		=> '32px',  
			'custom_mobile' => '',  		/*NULL,yes*/
			'mobile_height' => '30px',  
			'css' 			=> '',
			'ext_class' 	=> ''
		), $atts ) );
		
		$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
		
		$regexr = preg_match( $pattern, $height, $matches );
		$value = isset( $matches[1] ) ? (float) $matches[1] : (float) WPBMap::getParam( 'cata_empty_space', 'height' );
		$unit = isset( $matches[2] ) ? $matches[2] : 'px';
		$height = $value . $unit;
		
		$inline_css = ( (float) $height >= 0.0 ) ? ' style="height: ' . esc_attr( $height ) . '"' : '';
		
		$elemID 		= catanis_random_string(5, 'cata_empty_space');
		$elemClass 	= 'cata-empty-space cata-element ' . vc_shortcode_custom_css_class( $css, ' ' );
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$elemClass = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $elemClass, 'cata_empty_space', $atts );
		
		/* Custom CSS */
		if($custom_mobile == 'yes'){
			global $catanis;
			$custom_css = '';
			$selectID = '#' . $elemID;
			$custom_css .= '@media only screen and (max-width: 768px) {' . $selectID . ' {
				height :'. esc_attr( $mobile_height ) .' !important;
			} }';
			$catanis->inlinestyle[] = $custom_css;
		}
		
		return '<div id="'. esc_attr( $elemID ) .'" class="'. esc_attr( trim( $elemClass ) ) .'"'. $inline_css .' ></div>';
	}
}
add_shortcode( 'cata_empty_space', 'catanis_empty_space_shortcode_function' );


/*=== CATANIS SHORTCODE - TOOLTIP ============*/
/*============================================*/
if ( ! function_exists( 'catanis_tooltip_shortcode_function' ) ) {
	function catanis_tooltip_shortcode_function( $atts, $content = null ) {

		$text = $tooltip = $position = $color = $bg_color = $ext_class = '';
		extract( shortcode_atts( array(
			'text'			=> '',
			'tooltip'		=> '',
			'position'		=> 'top',				/*top, right, bottom, left*/
			'color'			=> '#FFFFFF',					
			'bg_color'		=> '#E4B0B2',
			'ext_class'		=> '',
		), $atts ) );
		
		$elemID 		= catanis_random_string(10, 'cata_tooltip');
		$elemClass 		= 'cata-tooltip cata-element';
		$elemClass 		.= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$attrContainer 	= (!empty($tooltip)) ? ' data-toggle="tooltip" data-placement="'.$position.'" data-original-title="' . $tooltip .'"' : '';

		/* Custom CSS */
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;
		$custom_css .= $selectID . ' + .tooltip > .tooltip-inner {
			color:'. $color .';
			background-color:'. $bg_color .';
		}';
		$custom_css .= $selectID . ' + .tooltip > .tooltip-arrow {
			border-'.$position.'-color:'. $bg_color .';
		}';
		$catanis->inlinestyle[] = $custom_css;
		
		return '<span id="'. $elemID .'" class="'. $elemClass .'" '. $attrContainer .'>'. $content .'</span>';;
	}
}
add_shortcode('cata_tooltip', 'catanis_tooltip_shortcode_function');


/*=== CATANIS SHORTCODE - CUSTOM HEADING =====*/
/*============================================*/
if ( ! function_exists( 'catanis_custom_heading_shortcode_function' ) ) {
	function catanis_custom_heading_shortcode_function( $atts, $content = null ) {

		$xhtml 	= '';
		$text 	= $link = $font_container = $use_google_fonts = $google_fonts = $css = $ext_class = $customcss = '';
		$custom_fonts_size = $ipad_fontsize_title = $mobile_fontsize_title = '';
		extract( shortcode_atts( array(
			'text'					=> esc_html__( 'This is custom heading element', 'catanis-core' ),
			'link'					=> '',
			'font_container'		=> 'tag:h2',
			'use_google_fonts'		=> '',						/*NULL, yes*/
			'google_fonts'			=> 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
			'custom_fonts_size'		=> '',						/*NULL, yes*/
			'ipad_fontsize_title' 	=> 'ipad-fontsize-75px',
			'mobile_fontsize_title' => 'mobile-fontsize-50px',
			'css'					=> '',
			'ext_class'				=> '',
			'customcss'				=> '',
		), $atts ) );
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_custom_heading');
		$elemClass 	= 'cata-custom-heading cata-element ' . vc_shortcode_custom_css_class( $css, ' ' );
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		$elemClass = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $elemClass, 'cata_custom_heading', $atts );
		$font_data = catanis_parse_text_style_for_googlefont( $font_container, '', $use_google_fonts, $google_fonts );
		
		/* Custom CSS */
		global $catanis;
		$custom_css = '#' . $elemID . ' > '. $font_data['tag'] .', #' . $elemID . ' > '. $font_data['tag'] .' a{'. $customcss .'}';
		$catanis->inlinestyle[] = $custom_css;
		
		$itemCls = '';
		if($custom_fonts_size == 'yes'){
			$itemCls = $ipad_fontsize_title . ' ' . $mobile_fontsize_title;
		}
		
		/* Parse link */
		if ( ! empty( $link ) ) {
			$link 		= catanis_parse_multi_attribute( $link, array( 'url' => '', 'title' => '', 'target' => '', 'rel' => '' ) );
			$text = '<a href="' . esc_attr( $link['url'] ) . '"'
					. ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' )
					. ( $link['rel'] ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '' )
					. ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' )
					. '>' . $text . '</a>';
		}
		
		$xhtml .= '<div id="'. esc_attr($elemID) .'" class="'. esc_attr($elemClass) .'" '. trim($animation['animation-attrs']) .'>';
		$xhtml .= '<' . $font_data['tag'] . ' ' . $font_data['style'] . ' class="'. esc_attr($itemCls) .'">';
		$xhtml .= $text;
		$xhtml .= '</' . $font_data['tag'] . '>';
		$xhtml .= '</div>';
		
		return $xhtml;		
	}
}
add_shortcode( 'cata_custom_heading', 'catanis_custom_heading_shortcode_function' );


/*=== CATANIS SHORTCODE - GRADIENT TEXT ======*/
/*============================================*/
if ( ! function_exists( 'catanis_gradient_text_shortcode_function' ) ){
	function catanis_gradient_text_shortcode_function( $atts, $content = null ) {

		$xhtml = $text = $link = $font_container = $gradient_style = $color_1 = $color_2 = '';
		$use_google_fonts = $google_fonts = $css = $ext_class = '';
		extract( shortcode_atts( array(
			'text' 				=> '',
			'link' 				=> '',
			'font_container' 	=> 'tag:h2|text_align:left',
			'gradient_style'	=> 'gradient-leftright',  		/* gradient-leftright, gradient-topbottom, gradient-diagonal*/
			'color_1'			=> '#ff4242',
			'color_2'			=> '#f2e826',
			'use_google_fonts'	=> '',							/*yes*/
			'google_fonts'		=> '',
			'css'				=> '',
			'ext_class' 		=> ''
		), $atts ) );

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_gradient_text');
		$elemClass 	= 'cata-gradient-text cata-element '.$gradient_style . ' ' . vc_shortcode_custom_css_class( $css, ' ' );
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';

		$elemClass = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $elemClass, 'cata_gradient_text', $atts );

		/* Custom CSS */
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;
		if($gradient_style == 'gradient-topbottom'){

			$custom_css .= $selectID . ' {
				background: -webkit-linear-gradient(top, '. $color_1 .' 0%, '. $color_2 .' 100%);
				background: linear-gradient(to bottom, '. $color_1 .' 0%, '. $color_2 .' 100%);
			  	-webkit-background-clip: text;
				background-clip: text;
			}';

		}elseif($gradient_style == 'gradient-leftright'){
			$custom_css .= $selectID . ' {
				background: -webkit-linear-gradient(left, '. $color_1 .' 0%, '. $color_2 .' 100%);
				background: linear-gradient(to right, '. $color_1 .' 0%, '. $color_2 .' 100%);
				-webkit-background-clip: text;
				background-clip: text;
			}';

		}elseif($gradient_style == 'gradient-diagonal'){
			$custom_css .= $selectID . ' {
				background: -webkit-linear-gradient(top left, '. $color_1 .' 0%, '. $color_2 .' 100%);
				background: linear-gradient(to bottom right, '. $color_1 .' 0%, '. $color_2 .' 100%);
				-webkit-background-clip: text;
				background-clip: text;
			}';
				
		}else{ /* radial */
			$custom_css .= $selectID . ' {
				background: -moz-radial-gradient(center, ellipse cover, '. $color_1 .' 0%, '. $color_2 .' 100%);
				background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,'. $color_1 .'), color-stop(100%,'. $color_2 .'));
				background: -webkit-radial-gradient(center, ellipse cover, '. $color_1 .' 0%,'. $color_2 .' 100%);
				background: -o-radial-gradient(center, ellipse cover, '. $color_1 .' 0%,'. $color_2 .' 100%);
				background: -ms-radial-gradient(center, ellipse cover, '. $color_1 .' 0%,'. $color_2 .' 100%);
				background: radial-gradient(ellipse at center, '. $color_1 .' 0%,'. $color_2 .' 100%);
				-webkit-background-clip: text;
				background-clip: text;
			}';
		}
		$catanis->inlinestyle[] = $custom_css;

		/* Parse link */
		if ( ! empty( $link ) ) {
			$link 		= catanis_parse_multi_attribute( $link, array( 'url' => '', 'title' => '', 'target' => '', 'rel' => '' ) );
			$text = '<a href="' . esc_attr( $link['url'] ) . '"'
					. ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' )
					. ( $link['rel'] ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '' )
					. ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' )
					. '>' . $text . '</a>';
		}

		$font_data = catanis_parse_text_style_for_googlefont( $font_container, '', $use_google_fonts, $google_fonts );
		$xhtml .= '<div id="'. esc_attr($elemID) .'" class="'. esc_attr($elemClass) .'" '. trim($animation['animation-attrs']) .'>';
		$xhtml .= '<' . $font_data['tag'] . ' ' . $font_data['style'] . ' >';
		$xhtml .= $text;
		$xhtml .= '</' . $font_data['tag'] . '>';
		$xhtml .= '</div>';
			
		return $xhtml;

	}
}
add_shortcode('cata_gradient_text', 'catanis_gradient_text_shortcode_function');


/*=== CATANIS SHORTCODE - AUTO FADEIN TEXT ===*/
/*============================================*/
if ( ! function_exists( 'catanis_autofade_text_shortcode_function' ) ){
	function catanis_autofade_text_shortcode_function( $atts, $content = null ) {
		
		$xhtml = $fixed_text_first = $text1 = $text2 = $text3 = $text4 = $text5 = $fixed_text_last = $display_inline = '';
		$autoplay_speed = $color_fadein = $font_container = $use_google_fonts = $google_fonts = $css = $ext_class = '';

		extract( shortcode_atts( array(
			'fixed_text_first' 	=> '',
			'text1' 			=> '',
			'text2' 			=> '',
			'text3' 			=> '',
			'text4' 			=> '',
			'text5' 			=> '',
			'fixed_text_last' 	=> '',
			'autoplay_speed' 	=> 20000,
			'display_inline' 	=> 'yes',
			'font_container' 	=> 'text_align:left|font_size:20px|line_height:30|color:#1A1A1A',
			'color_fadein' 		=> '#ff4242',
			'use_google_fonts'	=> '',							/*yes*/
			'google_fonts'		=> '',
			'css'				=> '',
			'ext_class' 		=> ''
		), $atts ) );

		$dataText = array();
		if(!empty($text1)){
			$dataText[] = $text1;
		}
		if(!empty($text2)){
			$dataText[] = $text2;
		}
		if(!empty($text3)){
			$dataText[] = $text3;
		}
		if(!empty($text4)){
			$dataText[] = $text4;
		}
		if(!empty($text5)){
			$dataText[] = $text5;
		}

		if(empty($dataText)){
			return esc_html('Please input auto text for shortcode.', 'catanis-core');
		}

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_autofade_text');
		$elemClass 	= 'cata-autofade-text cata-element ' . vc_shortcode_custom_css_class( $css, ' ' );
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($display_inline) ) ? ' display-inline' : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';

		$elemClass = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $elemClass, 'cata_autofade_text', $atts );
		$font_data = catanis_parse_text_style_for_googlefont( $font_container, '', $use_google_fonts, $google_fonts );

		/* Custom CSS */
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;
		$custom_css .= $selectID .' .fading-texts-container,'. $selectID .' > p a{ color: '. $color_fadein .'; }';
		$catanis->inlinestyle[] = $custom_css;

		ob_start();
		?>
		
		<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']) . ' ' . $font_data['style']; ?> >
			<?php if(!empty($fixed_text_first)) echo '<p>'. esc_html($fixed_text_first) .'</p>' ?>
			 <p class="fading-texts">
		 		<?php 
		 		if ( is_array( $dataText ) && count( $dataText ) > 0 ) :
					foreach ( $dataText as $text ) {
						echo '<span>'.$text.'</span>';
					}
				endif;
				?>
	         </p>
	         <?php if(!empty($fixed_text_last)) echo '<p>'. esc_html($fixed_text_last) .'</p>'?>
		</div>		
	    <?php
	    $xhtml = ob_get_contents();
	    ob_end_clean();

		return $xhtml;
	}
}
add_shortcode('cata_autofade_text', 'catanis_autofade_text_shortcode_function');
 
	    	
/*=== CATANIS SHORTCODE - AUTO TEXT TYPING ===*/
/*============================================*/
if ( ! function_exists( 'catanis_autotyping_text_shortcode_function' ) ){
	function catanis_autotyping_text_shortcode_function( $atts, $content = null ) {

		$xhtml = $fixed_text_first = $text1 = $text2 = $text3 = $text4 = $text5 = $text6 = $text7 = $text8 = $text9 = $text10 = $fixed_text_last ='';
		$type_speed = $back_speed = $start_delay = $back_delay = $loop = $loop_count = $show_cursor = $cursor_char = '';
		$color_typing = $font_container = $use_google_fonts = $google_fonts = $css = $ext_class = '';
		extract( shortcode_atts( array(
			'fixed_text_first' 	=> '',
			'text1' 			=> '',
			'text2' 			=> '',
			'text3' 			=> '',
			'text4' 			=> '',
			'text5' 			=> '',
			'text6' 			=> '',
			'text7' 			=> '',
			'text8' 			=> '',
			'text9' 			=> '',
			'text10' 			=> '',
			'fixed_text_last' 	=> '',
			'type_speed' 		=> '100',
			'back_speed' 		=> '50',
			'start_delay' 		=> '300',
			'back_delay' 		=> '500',
			'loop' 				=> 1,
			'loop_count' 		=> 1,
			'show_cursor' 		=> 1,
			'cursor_char' 		=> '_',
			'font_container' 	=> 'text_align:left|font_size:20px|line_height:30px|color:#1A1A1A',
			'color_typing' 		=> '#ff4242',
			'use_google_fonts'	=> '',							/*yes*/
			'google_fonts'		=> '',
			'css'				=> '',
			'ext_class' 		=> ''
		), $atts ) );
		
		$dataText = array();
		if(!empty($text1)){
			$dataText[] = $text1;
		}
		if(!empty($text2)){
			$dataText[] = $text2;
		}
		if(!empty($text3)){
			$dataText[] = $text3;
		}
		if(!empty($text4)){
			$dataText[] = $text4;
		}
		if(!empty($text5)){
			$dataText[] = $text5;
		}
		if(!empty($text6)){
			$dataText[] = $text6;
		}
		if(!empty($text7)){
			$dataText[] = $text7;
		}
		if(!empty($text8)){
			$dataText[] = $text8;
		}
		if(!empty($text9)){
			$dataText[] = $text9;
		}
		if(!empty($text10)){
			$dataText[] = $text10;
		}
		
		if(empty($dataText)){
			return esc_html('Please input auto text for shortcode.', 'catanis-core');
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_autotyping_text');
		$elemClass 	= 'cata-autotyping-text cata-element ' . vc_shortcode_custom_css_class( $css, ' ' );
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		$elemClass = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $elemClass, 'cata_autotyping_text', $atts );
		$font_data = catanis_parse_text_style_for_googlefont( $font_container, '', $use_google_fonts, $google_fonts );
		
		/* Custom CSS */
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;
		$custom_css .= $selectID . ' .typed-cursor, '. $selectID .' .content-auto-typing{ color: '. $color_typing .'; }';
		$catanis->inlinestyle[] = $custom_css;
		
		$paramArr = array(
			'strings' 		=> $dataText,
			'contentType' 	=> 'html', 
			'typeSpeed' 	=> absint($type_speed), 
			'backSpeed'		=> absint($back_speed),
			'startDelay' 	=> absint($start_delay), 
			'backDelay' 	=> absint($back_delay), 
			'loop' 			=> ($loop)? true : false,
			'loopCount' 	=> absint($loop_count), 
			'showCursor' 	=> ($show_cursor)? true : false,
			'cursorChar' 	=> $cursor_char
		);

		$xhtml .= '<div id="'. esc_attr($elemID) .'" class="'. esc_attr($elemClass) .'" data-params=\''. json_encode($paramArr) .'\' '. trim($animation['animation-attrs']) . ' '. $font_data['style']. '>';
		$xhtml .= $fixed_text_first . ' <span class="content-auto-typing"></span> ' . $fixed_text_last;
		$xhtml .= '</div>';
		
		return $xhtml;
	}
}
add_shortcode('cata_autotyping_text', 'catanis_autotyping_text_shortcode_function');


/*=== SHORTCODE - COUNTDOWN ==================*/
/*============================================*/
if ( ! function_exists ( 'catanis_countdown_shortcode_function' ) ) {
	function catanis_countdown_shortcode_function( $atts, $content = null ) {

		$xhtml = $main_style = $minutes = $hours = $date = $month = $year = '';
		$hours = $minutes = $color_style = $css = $ext_class ='';
		extract(shortcode_atts( array(
			'main_style' 	=> 'style1',		/*style1->3*/
			'date' 			=> '',
			'month' 		=> '',
			'year' 			=> '',
			'hours' 		=> '0',
			'minutes' 		=> '0',
			'color_style' 	=> '',		/*NULL, text-light*/
			'css' 			=> '',
			'ext_class' 	=> ''
		), $atts ) );

		if( empty($date) || empty($month) || empty($year)){
			return '';
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_countdown');
		$elemClass 	= 'cata-countdown cata-element cata-'. $main_style;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($color_style) ) ? ' '. $color_style : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		$class_to_filter = $elemClass . ' ' .vc_shortcode_custom_css_class( $css, ' ' );
		$elemClass = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, 'cata_countdown', $atts );
		$_date = $year .'/'. ($month -1) . '/' . $date .'/'. $hours .'/'. $minutes;
		
		$xhtml 	.= '<div id="' . esc_attr($elemID) . '" class="' . esc_attr($elemClass) . '" '. trim($animation['animation-attrs']) .'>';
		$xhtml 	.= '	<div class="cata-countdown-content" data-date="' . $_date . '"> </div>';
		$xhtml 	.= '</div>';
		
		return $xhtml;
	}
}
add_shortcode( 'cata_countdown', 'catanis_countdown_shortcode_function' );


/*=== SHORTCODE - MILESTONE ==================*/
/*============================================*/
if ( ! function_exists( 'catanis_milestone_shortcode_function' ) ){
	function catanis_milestone_shortcode_function( $atts, $content = null ) {
		 
		$number = $suffix = $subject = $small_desc = $color_style = $bg_color = $bg_image = $use_icon = $icon_color = $icon = $ext_class = '';
		extract( shortcode_atts( array(
			'number' 			=> '1250',
			'suffix' 			=> '',
			'subject' 			=> '',
			'small_desc' 		=> '',
			'color_style' 		=> '', 							/* NULL, text-light */
			'bg_color' 			=> '', 				
			'bg_image' 			=> '', 				
			'use_icon' 			=> '',							/*NULL, yes*/
			'icon_color' 		=> '',					
			'icon' 				=> 'ti-agenda',
			'ext_class' 		=> ''
		), $atts ) );
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_milestone');
		$elemClass 	= 'cata-milestone cata-element';
		$elemClass .= (!empty($color_style)) ? ' cata-' . $color_style : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= ($use_icon == 'yes') ? ' has-icon' : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		/* Custom CSS */
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;
		if ( $use_icon == 'yes' && !empty($icon_color)){
			$custom_css .= $selectID . '.cata-milestone.has-icon .icon{ color: '. $icon_color .'; }';
		}
		if( !empty($bg_color) ) {
			$custom_css .= $selectID . ' { background-color: '. $bg_color .'; }';
		}
		if( !empty($bg_image) ) {
			$bg_image = wp_get_attachment_image_url( $bg_image, 'full') ;
			$custom_css .= $selectID . ' { background: url('. $bg_image .'); }';
		}
		$catanis->inlinestyle[] = $custom_css;
		
		ob_start();
		?>
		<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" data-number="<?php echo $number; ?>" <?php echo trim($animation['animation-attrs']); ?>>
			<?php if ( $use_icon == 'yes' ) : ?>
				<span class="icon"><i class="<?php echo esc_attr($icon); ?>"></i></span>
			<?php endif; ?>
			
			<div class="wrap-milestone">
				<h3 class="subject"><?php echo esc_html($subject); ?></h3>
				<p class="number"><span><?php echo esc_html($number); ?></span>
					<?php if ( $suffix ): ?><em><?php echo esc_html($suffix); ?></em><?php endif; ?>
				</p>
				
				<?php if ( $small_desc ): ?>
					<p class="short-desc"><?php echo esc_attr( $small_desc ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	    <?php
	    $xhtml = ob_get_contents();
	    ob_end_clean();
	    
	    return $xhtml;
	}
}
add_shortcode( 'cata_milestone', 'catanis_milestone_shortcode_function' );


/*=== SHORTCODE - BRANDS =====================*/
/*============================================*/
if ( ! function_exists( 'catanis_brands_shortcode_function' ) ) {
	function catanis_brands_shortcode_function( $atts ) {

		$main_style = $images = $columns = $with_padding = $padding_value = $onclick = $custom_links = $custom_links_target = '';
		$items_desktop = $items_desktop_small = $items_tablet = $slide_arrows = $slide_dots = $slide_dots_style = '';
		$slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $ext_class = '';
		extract( shortcode_atts( array(
			'main_style' 			=> 'style1', 		/*style1 -> #3 and list*/
			'images' 				=> '',
			'columns' 				=> '4',				/*Only for list style*/
			'with_padding' 			=> '',				/*NULL,yes*/
			'padding_value' 		=> '30',				
			'onclick' 				=> '',
			'custom_links' 			=> '',
			'custom_links_target' 	=> '_blank',
			
			'items_desktop' 		=> 4,
			'items_desktop_small' 	=> 3,
			'items_tablet' 			=> 2,
			'slide_arrows'			=> 'no', 	
			'slide_dots'			=> 'yes', 	
			'slide_dots_style'		=> 'dots-line', 	/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/	
			'slide_autoplay'		=> 'no', 	
			'slide_autoplay_speed'	=> 3000, 	
			'slides_to_scroll'		=> 3, 	
			'slides_speed'			=> 500, 
			'ext_class' 			=> ''
		), $atts ) );

		if ( '' === $images ){
			return '';
		}
			
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_brands');
		$elemClass 	= 'cata-brands cata-element cata-' . $main_style . ' ' . $slide_dots_style;
		$elemClass .= ($with_padding == 'yes') ? ' cata-slider-spacing' . absint($padding_value) : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		$i = - 1;
		$images = explode( ',', $images );
		if ( 'yes' === $onclick ) {
			$custom_links = explode( ',', $custom_links );
		}
		
		$arrParams = array();
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		if($main_style != 'list' ){
			$elemClass .= ' cata-slick-slider';
			
			$arrParams = array(
				'autoplay' 			=> ($slide_autoplay == 'yes') ? true : false,
				'autoplaySpeed' 	=> intval($slide_autoplay_speed),
				'slidesToShow' 		=> intval($items_desktop),
				'slidesToScroll' 	=> intval($slides_to_scroll),
				'dots' 				=> ($slide_dots == 'yes')? true : false,
				'arrows' 			=> ($slide_arrows == 'yes')? true : false,
				'infinite' 			=> true,
				'draggable' 		=> true,
				'rtl' 				=> CATANIS_RTL,
				'speed' 			=> intval($slides_speed),
				'responsive'		=> array(
					array(
						'breakpoint'	=> 1024,
						'settings'		=> array(
							'slidesToShow'		=> intval($items_desktop_small),
							'slidesToScroll' 	=> intval($items_desktop_small)
						)
					),
					array(
						'breakpoint'	=> 768,
						'settings'		=> array(
							'slidesToShow'		=> intval($items_tablet),
							'slidesToScroll' 	=>  intval($items_tablet)
						)
					),
					array(
						'breakpoint'	=> 480,
						'settings'		=> array(
							'slidesToShow'		=> 1,
							'slidesToScroll' 	=> 1
						)
					),
				) 
			);
		}
		
		ob_start();
		?>
		 <div<?php echo rtrim($dir); ?> id="<?php echo esc_attr( $elemID ); ?>" class="<?php echo esc_attr( $elemClass ); ?>" <?php echo trim($animation['animation-attrs']); ?>>
	        <ul class="slides cata-columns-<?php echo esc_attr($columns)?>" data-slick='<?php echo json_encode($arrParams); ?>'>
	            <?php 
	            foreach ( $images as $attach_id ): 
					$i ++;
					if ( $attach_id > 0 ) {
						$post_thumbnail = wpb_getImageBySize( array(
							'attach_id' 	=> $attach_id,
							'thumb_size' 	=> 'full'
						) );
					} else {
						$post_thumbnail = array();
						$post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
						$post_thumbnail['p_img_large'][0] = vc_asset_url( 'vc/no_image.png' );
					}
					$thumbnail = $post_thumbnail['thumbnail'];
				?>
		             <li class="cata-item">
		             	<?php if ( 'yes' === $onclick && isset( $custom_links[ $i ] ) && '' !== $custom_links[ $i ] ): ?>
							<a href="<?php echo esc_url( $custom_links[ $i ]); ?>" title="<?php echo get_the_title( $attach_id ); ?>" target="<?php echo esc_attr( $custom_links_target); ?>">
								<?php echo $thumbnail; ?>
							</a>
						<?php else: ?>
							<?php echo $thumbnail; ?>
						<?php endif; ?>
				    </li>
    			<?php endforeach; ?>
	        </ul>
	    </div>
		<?php
		$xhtml = ob_get_contents();
		ob_end_clean();
		
		return $xhtml;
	}
}
add_shortcode( 'cata_brands', 'catanis_brands_shortcode_function');


/*=== SHORTCODE - PRICE TABLE ================*/
/*============================================*/
if ( ! function_exists('catanis_pricetable_shortcode_function' ) ) {
	function catanis_pricetable_shortcode_function( $atts, $content = null ) {

		$title = $main_style = $bg_image = $bg_color = $icon = $active = $price = $currency = $price_period = '';
		$button = $button_use_icon = $button_icon = $description = $ext_class = '';
		extract( shortcode_atts( $args = array(
			'main_style'      	=> 'style2',
			'bg_image'      	=> '',
			'bg_color'      	=> '#FFFFFF',
			'icon'      		=> 'ti-agenda',
			'title'         	=> '',
			'active'         	=> 'no',
			'price'         	=> '0',
			'currency'      	=> '$',
			'price_period'  	=> '/mo',
			'description'   	=> '',
			'button'      	 	=> '',
			'button_use_icon'   => 'yes',
			'button_icon'   	=> 'fa fa-download',
			'ext_class' 		=> ''
		), $atts ) );
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_pricetable');
		$elemClass 	= 'cata-pricetable cata-element cata-' . $main_style;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= ($active == "yes" ) ? ' cata-active' : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
			 
		/* Parse link */
		$button 		= ( '||' === $button ) ? '' : $button;
		$button_temp 	= catanis_parse_multi_attribute( $button, array( 'url' => '#', 'title' => '', 'target' => '_blank', 'rel' => '' ) );
		$a_title 		= trim( $button_temp['title']);
		
		$btn_shortcode = '';
		if ( ! empty ( $a_title ) ){
			$add_icon = ( $button_use_icon == 'yes' ) ? 1 : 0 ;
			$text_color = ( $active == 'yes' || ( $active != 'yes' && $main_style == 'style-transparent') ) ? '#FFFFFF' : '#1A1A1A' ;
			$text_color = ( $active == 'yes' && $main_style == 'style-transparent' ) ? '#1A1A1A' : $text_color ;
			
			$button_color = ( $active == 'yes' && in_array($main_style, array('style1', 'style3')) ) ? "#e49497" : "transparent";
			
			$btn_shortcode = '[cata_button main_style="classic" button_text="'. $a_title .'"';
			$btn_shortcode .= ' link="'. $button .'" shape="square" size ="nm"';
			$btn_shortcode .= ' add_icon="'. $add_icon .'" icon="'. $button_icon .'" align="block"';
			$btn_shortcode .= ' button_color = "'. $button_color .'" text_color = "'. $text_color .'"';
			$btn_shortcode .= ' button_color_hover = "#e49497" text_color_hover = "#FFFFFF"]';
		}
		
		if(is_numeric($bg_image)){
			$bg_image = wp_get_attachment_image_url( $bg_image, 'full') ;
		}
		
		$innerStyle = '';
		if( $active == "yes" && !empty($bg_image) && $main_style == 'style2') {
			$innerStyle = 'style="background:url('. esc_url($bg_image) .') center center no-repeat;background-size: cover; "';
		}
		
		/* Custom CSS */
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;
		$custom_css .= $selectID . ' .ptable-content{ background-color: '. $bg_color .'; }';
		$catanis->inlinestyle[] = $custom_css;
		
		ob_start();
		?>
	    <div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
			<div class="cata-ptable-content" <?php echo trim($innerStyle); ?>>
				
				<?php if(!empty($icon) && $main_style != 'style3') : ?>
				<p class="cata-icon"><span class="<?php echo esc_attr($icon); ?>"></span></p>
				<?php endif; ?>
				
				<?php if(!empty($bg_image) && $main_style == 'style3') : ?>
				<figure><img src="<?php echo esc_url($bg_image); ?>" alt="<?php echo esc_attr($title); ?>"></figure>
				<?php endif; ?>
				
				<h4><?php echo esc_html($title); ?></h4>
				
				<div class="cata-price-unit">
					<span class="unit"><?php echo $currency; ?></span>
					<span class="price"><?php echo $price; ?></span>
					<span class="period"><?php echo $price_period; ?></span>
				</div>
				<p class="cata-short-desc"><?php echo wp_kses_post($description); ?></p>
				<?php echo wp_kses_post($content); ?>
				
				<?php if ( ! empty ( $btn_shortcode ) ): echo do_shortcode($btn_shortcode); endif; ?>
			</div>
		</div>
	    <?php 
	    $xhtml = ob_get_contents();
	    ob_end_clean();
	    
	    return $xhtml;
	}
}
add_shortcode( 'cata_pricetable', 'catanis_pricetable_shortcode_function' );


/*=== SHORTCODE - SIMPLE LIST ================*/
/*============================================*/
if ( ! function_exists( 'catanis_simple_list_shortcode_function' ) ){
	function catanis_simple_list_shortcode_function( $atts, $content = null ) {

		$xhtml = $list_type = $ordered_style = $unordered_style = $icon_color = $text_color = $ext_class = '';
		$atts = catanis_strip_attr_prefix( $atts );
		extract( shortcode_atts( array(
			'list_type' 		=> 'ordered',				/*ordered, unordered*/
			'ordered_style' 	=> 'bullet-numberic',			/*bullet-numberic, bullet-numberic-circle, bullet-numberic-rounded*/
			'unordered_style' 	=> 'bullet-check',			/*bullet-check, bullet-check-circle, bullet-check-rounded, bullet-caret, 'bullet-caret-circle, 'bullet-dot*/
			'icon_color' 		=> '#E5B1B3',
			'text_color' 		=> '#898989',
			'ext_class' 		=> ''
		), $atts ) );

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'list');
		$elemClass 	= '';
			
		$elemClass .= ($list_type == 'ordered' && !empty($ordered_style)) ? 'cata-list numlist ' . $ordered_style : '';
		$elemClass .= ($list_type == 'unordered' && !empty($unordered_style)) ? 'cata-list fontlist ' . $unordered_style : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class)) ? ' ' . $ext_class : '';
		$elemClass = str_replace('  ', ' ', trim($elemClass));

		global $catanis;
		$custom_css = '';

		$selectID = '#' . $elemID;
		$custom_css .= $selectID . ' li{ color: '. $text_color .';}';
		if($list_type == 'ordered' && in_array($ordered_style, array('bullet-numberic-circle', 'bullet-numberic-rounded'))){
			$custom_css .= $selectID . ' li:before{ background-color: '.$icon_color.';}';
			if($ordered_style == 'bullet-numberic-rounded'){
				$custom_css .= $selectID . ' ul > li:hover:after, '. $selectID .' ol > li:hover:after{ border-left-color: '.$icon_color.';}';
			}
		}else{
			$custom_css .= $selectID . ' li:before{ color: '.$icon_color.';}';
		}
		$catanis->inlinestyle[] = $custom_css;

		ob_start();
		?>
			<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
				<?php 
				$content = strtr( $content, array('<p>' => '', '</p>' => '') );
				echo trim($content);
				?>
			</div>
		<?php 
		$xhtml = ob_get_contents();
		ob_end_clean();
		
		return $xhtml;
	}
}
add_shortcode( 'cata_list', 'catanis_simple_list_shortcode_function' );


/*=== SHORTCODE - HEADING TITLE ==============*/
/*============================================*/
if ( ! function_exists( 'catanis_heading_title_shortcode_function' ) ) {
	function catanis_heading_title_shortcode_function( $atts, $content = null) {

		$xhtml = $small_title = $large_title = $main_style = '';
		$text_align = $text_color_style = $icon = $ext_class = '';
		extract( shortcode_atts( array(
			'small_title' 		=> '',
			'large_title' 		=> '',
			'main_style'  		=> 'style1', 			/* style1 -> style10 */
			'text_align'  		=> 'text-center', 		/* text-center, text-left */
			'text_color_style'  => '', 					/* text-light */
			'icon'				=> 'ti-desktop',		/* Only style 7*/
			'ext_class'  		=> ''
		), $atts ) );

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemClass 	= 'heading-title ' . $main_style;
		$elemClass .= (in_array($main_style, array('style1', 'style2', 'style5', 'style8', 'style9', 'style10'))) ? ' ' . $text_align : ' text-center' ;
		$elemClass .= (!empty($text_color_style)) ? ' ' . $text_color_style : '' ;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$elemClass = str_replace('  ', ' ', trim($elemClass));

		if ( !empty( $large_title ) ) {
			$xhtml .= '<h3 class="' . $elemClass . '" '. trim($animation['animation-attrs']) .'>';

			if ( in_array($main_style, array('style5', 'style8'))) {
				$xhtml .= $large_title;

			}elseif ( $main_style == 'style6') {
				$xhtml .= '<span>' . $large_title . '</span><hr class="line-l"/><i></i><hr class="line-r"/>';

			}elseif ( $main_style == 'style7') {
				$xhtml .= '<span>' . $large_title . '</span><hr class="line-l"/><i class="cicon '.$icon.'"></i><hr class="line-r"/>';
					
			}elseif ( $main_style == 'style9') {
				$xhtml .= '<hr class="line-l"/><hr class="line-r"/><span>' . $large_title . '</span>';

			}elseif ( $main_style == 'style3') {
				$xhtml .= '<i>' . $large_title . '</i><span>' . $small_title . '</span>';

			}elseif ( $main_style == 'style2') {
				$xhtml .= '<span>' . $large_title . '</span>';
				
			}else{ 
				/* 1,2,4,10 */
				$xhtml .= '<span><i>' . $small_title . '</i> ' . $large_title . '</span>';
			}

			$xhtml .= '</h3>';
		}

		return $xhtml;
			
	}
}
add_shortcode( 'cata_heading_title', 'catanis_heading_title_shortcode_function' );


/*=== SHORTCODE - SEPARATOR ==================*/
/*============================================*/
if ( ! function_exists( 'catanis_separator_shortcode_function' ) ) {
	function catanis_separator_shortcode_function( $atts, $content = null) {

		$xhtml = $main_style = $align = $border_color = $border_style = $border_width = $el_width = $css = $ext_class = '';
		extract( shortcode_atts( array(
			'main_style'  		=> 'wedding', 	/* default, wedding */
			'align'  			=> 'align-center', 		/* align-center, align-left, align-right */
			'border_color'  	=> '#EEEEEE', 			/* text-light */
			'border_style'  	=> 'solid', 			/* EMPTY, dashed,dotted,double,shadow*/
			'border_width'		=> '1px',				/* 1px -> 10px*/
			'el_width'			=> '100',				
			'css'				=> '1px',				
			'ext_class'  		=> ''
		), $atts ) );
		
		$border_width = absint($border_width);
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(3, 'separator');
		$elemClass 	= 'cata-separator cata-element cata-' . $align . ' cata-width-' . $el_width . ' cata-style-'. $main_style;
		$elemClass 	.= ' cata-sep-' . $border_style  .' cata-border-width-' . $border_width;
		$elemClass  .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass  .= (!empty($ext_class)) ? ' ' . $ext_class : '';
		
		$class_to_filter = $elemClass . ' ' .vc_shortcode_custom_css_class( $css, ' ' );
		$elemClass = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, 'cata_separator', $atts );
		
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;
		$custom_css .= $selectID . ' .cata-sep-holder .cata-sep-line{ border-color: '. $border_color .';}';
		
		if($border_style == 'shadow'){
			$custom_css .= $selectID . '.cata-border-width-'.$border_width.'.cata-sep-shadow .cata-sep-holder-l .cata-sep-line::after{ box-shadow:10px 10px 10px '.$border_width.'px '. $border_color .';}';
			$custom_css .= $selectID . '.cata-border-width-'.$border_width.'.cata-sep-shadow .cata-sep-holder-r .cata-sep-line::after{ box-shadow:-10px 10px 10px '.$border_width.'px '. $border_color .';}';
		}
		$catanis->inlinestyle[] = $custom_css;
	
		ob_start();
		?>
			<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']);?>>
				<span class="cata-sep-holder cata-sep-holder-l"><span class="cata-sep-line"></span></span>
				<span class="cata-sep-holder cata-sep-holder-r"><span class="cata-sep-line"></span></span>
			</div>
		<?php 
		$xhtml = ob_get_contents();
		ob_end_clean();
		
		return $xhtml;
	}
}
add_shortcode( 'cata_separator', 'catanis_separator_shortcode_function' );


/*=== SHORTCODE - IMAGE COMPARISON ===========*/
/*============================================*/
if ( ! function_exists( 'catanis_image_comparison_shortcode_function' ) ){
	function catanis_image_comparison_shortcode_function( $atts, $content = null ) {

		$xhtml = $main_style = $image_first = $image_second = $image_width = $image_height = '';
		$label_first = $label_second = $delim_color = $ext_class = '';
		$atts = catanis_strip_attr_prefix( $atts );
		extract( shortcode_atts( array(
			'main_style' 		=> 'horizontal',		/* horizontal -> vertical */
			'image_first' 		=> '',
			'image_second' 		=> '',
			'label_first'		=> '',
			'label_second'		=> '',
			'image_width'		=> '1170',
			'image_height'		=> '600',
			'delim_color'		=> '#FFFFFF',
			'ext_class' 		=> ''
		), $atts ) );

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'image_comparison');
		$elemClass 	= 'cata-image-comparison cata-element direction-' . $main_style;
		$elemClass  .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass  .= (!empty($ext_class)) ? ' ' . $ext_class : '';
		$elemClass  = str_replace('  ', ' ', trim($elemClass));

		/* Custom CSS */
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;

		$custom_css .= $selectID . ' div.jx-control,'. $selectID . ' div.jx-controller {background-color:'.esc_html($delim_color).';}';
		if($main_style == 'horizontal'){
			$custom_css .= $selectID . ' div.jx-arrow.jx-right {border-color: transparent transparent transparent '.esc_html($delim_color).';}';
			$custom_css .= $selectID . ' div.jx-arrow.jx-left {border-color: transparent '.esc_html($delim_color).' transparent transparent;}';
		}else{
			$custom_css .= $selectID . ' div.jx-arrow.jx-right {border-color: '.esc_html($delim_color).' transparent transparent transparent;}';
			$custom_css .= $selectID . ' div.jx-arrow.jx-left {border-color: transparent transparent '.esc_html($delim_color).' transparent;}';
		}
		$catanis->inlinestyle[] = $custom_css;
			
		$left_image_html = $right_image_html = '';
		if(isset($image_first) && !empty($image_first)) {
			$left_image_html .= catanis_generate_image_html($image_first, $image_width, $image_height, ' data-label="'. $label_first .'"');
		}
		if(isset($image_second) && !empty($image_second)) {
			$right_image_html .= catanis_generate_image_html($image_second, $image_width, $image_height, ' data-label="'. $label_second .'"');
		}

		if(!empty($left_image_html) && !empty($right_image_html)){
			$xhtml .= '<div id="'. esc_attr($elemID) .'" class="'. esc_attr($elemClass) .'" '. trim($animation['animation-attrs']) .'>';
			$xhtml .= '<div class="juxtapose" data-mode="'.$main_style.'" data-startingposition="50%" data-showlabels="true" data-showcredits="false" data-animate="true">' .$left_image_html . $right_image_html .'</div>';
			$xhtml .= '</div>';
		}

		return $xhtml;
	}
}
add_shortcode('cata_image_comparison', 'catanis_image_comparison_shortcode_function');

if ( ! function_exists( 'catanis_generate_image_html' ) ) {
	function catanis_generate_image_html($attachment_id = '', $width = '', $height = '', $data_options = '') {
		$html = $image_url = $alt = '';
	
		if($attachment_id != '') {
			$image_src = wp_get_attachment_image_src($attachment_id, 'full');
	
			if($width && $height){
				$image_url = catanis_get_resized_image( $image_src[0], $width, $height);
			}
	
			$image_meta = wp_get_attachment_metadata($attachment_id);
			if(isset($image_meta['image_meta']['caption']) && $image_meta['image_meta']['caption'] != '') {
				$alt = $image_meta['image_meta']['caption'];
					
			} elseif(isset($image_meta['image_meta']['title']) && $image_meta['image_meta']['title'] != '') {
				$alt = $image_meta['image_meta']['title'];
					
			} else {
				$alt = esc_attr__('Image comparison','onelove');
			}
	
			if(!$image_url || $image_url == ''){
				$image_url = $image_src[0];
			}
	
			$html .= '<img src="'.esc_url($image_url).'" alt="'.esc_attr($alt).'"';
			if($width){
				$html .= ' width="'.esc_attr($width).'"';
			}
			if($height){
				$html .= ' height="'.esc_attr($height).'"';
			}
			if($data_options){
				$html .= $data_options;
			}
	
			$html .= ' />';
		}
	
		return $html;
	}
}


/*=== SHORTCODE - IMAGE CIRCLE ===============*/
/*============================================*/
if ( ! function_exists( 'catanis_counter_circle_shortcode_function' ) ) {
	function catanis_counter_circle_shortcode_function( $atts, $content = null ) {

		$xhtml = $filledcolor = $unfilledcolor = $size = $speed = $linecap = $strokesize = '';
		$percent = $title = $desc = $ext_class = '';
		extract( shortcode_atts( array(
			'filledcolor' 		=> '#e49497',
			'unfilledcolor' 	=> '#f7f7f7',
			'size' 				=> '220',
			'speed' 			=> '1000',
			'linecap' 			=> 'round', 
			'strokesize' 		=> '5',
			'percent' 			=> '90',
			'title' 			=> '',
			'desc' 				=> '',
			'ext_class' 		=> ''
		), $atts ) );

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_counter_circle');
		$elemClass 	= 'cata-counter-circle cata-element';
		$elemClass  .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class)) ? ' ' . $ext_class : '';
		$elemClass = str_replace('  ', ' ', trim($elemClass));
		
		/* Custom CSS */
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;
		
		$custom_css .= $selectID . ' .cata-counter-circle-content {
	 		font-size:'. (50 * $size / 240) .'px;
			width: '.esc_html($size).'px; 
			height: '.esc_html($size).'px; 
			line-height: '.esc_html($size).'px; 
		}';
		$catanis->inlinestyle[] = $custom_css;
		
		$arrParams = array(
			'barColor'		=> $filledcolor,
			'trackColor'	=> $unfilledcolor,
			'scaleColor'	=> false,
			'scaleLength'	=> 5,
			'rotate'		=> 0,
			'lineCap' 		=> $linecap,
			'lineWidth' 	=> $strokesize,
			'size' 			=> $size,
			'animate' 		=> array(
				'duration'	=> $speed,
				'enabled'	=> true
			),
			'easing' 		=> 'defaultEasing'
		);

		ob_start();
		?>
		<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>"<?php echo trim($animation['animation-attrs']);?>>
			<div class="cata-counter-circle-content" data-percent="<?php echo esc_attr($percent); ?>" data-params='<?php echo json_encode($arrParams); ?>'> 
	        	<?php echo do_shortcode( $content ); ?>
            </div>
            
            <?php if ( $desc || $title ) : ?>
           	<p class="desc">
           	 	<?php if ( $title ) : ?><span><?php echo esc_attr( $title ); ?></span><?php endif; ?>
            	<?php if ( $desc ) : echo esc_attr( $desc ); 	endif; ?>
            </p>
            <?php endif; ?>
        </div>
	    <?php
		$xhtml = ob_get_contents();
		ob_end_clean();
	        
		return $xhtml;
	}
}
add_shortcode( 'cata_counter_circle', 'catanis_counter_circle_shortcode_function' );


/*=== SHORTCODE - CONTACT FORM ===============*/
/*============================================*/
if( ! function_exists( 'catanis_contactform_shortcode_function' ) ) {
	function catanis_contactform_shortcode_function( $atts, $content = null ) {

		$xhtml = $description = $form = $text_color_style = $ext_class = '';
		extract( shortcode_atts( array(
			'description' 		=> '',
			'form' 				=> '',
			'text_color_style' 	=> '',   /*NULL, light*/
			'ext_class' 		=> ''
		), $atts) );

		if ( empty( $form ) ) {
			return;
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_fcontact');
		$elemClass 	= 'cata-contact-form cata-element';
		$elemClass  .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($text_color_style)) ? ' cata-color-' . $text_color_style : '';
		$elemClass .= (!empty($ext_class)) ? ' ' . $ext_class : '';

		ob_start();
		?>
		<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']);?>>
	    	<?php if( !empty($description) ): ?>
	    		<div class="cata-desc"><?php echo $description; ?></div>
	    	<?php endif; ?>
	    	<div class="ctact-from-wrapper">
	    		<?php echo do_shortcode( '[contact-form-7 id="' . esc_attr($form) . '"]',true); ?>
	    	</div> 
	    </div>
	    <?php
	    $xhtml = ob_get_contents();
	    ob_end_clean();
	
	    return $xhtml;
	}
}
add_shortcode( 'cata_contactform', 'catanis_contactform_shortcode_function' );


/*=== SHORTCODE - CONTACT FORM ===============*/
/*============================================*/
if( ! function_exists( 'catanis_contactinfo_block_shortcode_function' ) ) {
	function catanis_contactinfo_block_shortcode_function( $atts, $content = null ) {

		$xhtml = $main_style = $short_desc = $address = $phone = $fax = $email = $website = '';
		$text_color_style = $background_image = $background_image_repeat = $background_color =  '';
		$general_border_style = $general_border_color = $general_border_width = $general_border_radius =  '';
		$thumb_size = $icon_size = $icon_background_color = $icon_color = $ext_class = '';
		extract( shortcode_atts( array(
			'main_style' 		=> 'style1',
			'short_desc' 		=> '',
			'address' 			=> '',
			'phone' 			=> '',  
			'fax' 				=> '',  
			'email' 			=> '',   
			'website' 			=> '',  
			'text_color_style' 			=> '',  
			'background_image' 			=> '',  
			'background_image_repeat' 	=> 'no-repeat',  
			'background_color' 			=> '',  
			
			'thumb_size' 				=> '40',  
			'icon_size' 				=> '',  
			'icon_background_color' 	=> '',  
			'icon_color' 				=> '',  
			'ext_class' 				=> ''
		), $atts) );
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(5, 'cata_contactinfo');
		$elemClass 	= 'cata-contactinfo-block cata-element cata-' . $main_style;
		$elemClass  .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($text_color_style)) ? ' cata-color-' . $text_color_style : '';
		$elemClass .= (!empty($ext_class)) ? ' ' . $ext_class : '';
		
		if (isset($phone) && !empty($phone)) {
			$phone = '<a href="tel:'.esc_attr($phone).'">'.esc_attr($phone).'</a>';
		}
		
		if (isset($email) && !empty($email)) {
			$email = '<a href="mailto:'.esc_attr($email).'">'.esc_attr($email).'</a>';
		}
		if (isset($website) && !empty($website)) {
			$website = '<a href="'.esc_attr($website).'" target="_blank">'.esc_attr($website).'</a>';
		}
		
		$address_var	= esc_html__('Address', 'catanis-core');
		$phones_var		= esc_html__('Phone', 'catanis-core');
		$fax_var		= esc_html__('Fax', 'catanis-core');
		$email_var		= esc_html__('Email', 'catanis-core');
		$website_var	= esc_html__('Website', 'catanis-core');
		
		$fields_arr = array (
			$phones_var		=> $phone,
			$fax_var		=> $fax,
			$email_var		=> $email,
			$address_var	=> $address,
			$website_var	=> $website
		);
		$icon = array (
			$phones_var		=> 'ti-mobile',
			$fax_var		=> 'ti-printer',
			$email_var		=> 'ti-email',
			$address_var	=> 'ti-location-pin',
			$website_var	=> 'ti-world'
		);

		$icon_style = 'style="';
		$general_css = 'style="';
		
		if ( !empty($icon_size)) {
			$icon_style .= 'font-size: '.esc_attr($icon_size).'px; ';
		}
		if( in_array($main_style, array('style2')) ) {
			$icon_style .= 'width: '.esc_attr($thumb_size).'px; ';
			$icon_style .= 'height: '.esc_attr($thumb_size).'px; ';
			
			if ( !empty($icon_background_color)) {
				$icon_style .= 'background: '.esc_attr($icon_background_color).'; ';
			}
		}
		if ( !empty($icon_color)) {
			$icon_style .= 'color: '.esc_attr($icon_color).'; ';
		}
		
		$bg_image_src = wp_get_attachment_image_src( $background_image, 'full' );
		if ( isset( $bg_image_src[0] ) && $bg_image_src[0] != '' ) {
			$general_css .= 'background-image: url('.esc_url($bg_image_src[0]).'); ';
		}
		if(strcmp($background_image_repeat, 'no-repeat') !== 0 ) {
			$general_css .= 'background-repeat: '.esc_attr($background_image_repeat).' ;';
		}
		if(!empty($background_color)) {
			$general_css .= 'background-color: '.  esc_attr($background_color).'; ';
		}
		
		$icon_style .= '"';
		$general_css .= '"';
		
		$xhtml .= '<div id="'. esc_attr($elemID) .'" class="'. esc_attr($elemClass) .'" '. trim($animation['animation-attrs']) .' '.$general_css.'>';
		if(!empty($short_desc)){
			$xhtml .= '<div class="cata-short-desc">'. wp_kses_post($short_desc) .'</div>';
		}
		
		$xhtml .= '<div class="cata-contactinfo-wrap">';
		foreach($fields_arr as $key => $value){
			if(isset($value) && !empty($value)){
				if(key_exists($key, $icon)){
					$class_item = $icon[$key];
				};
				$xhtml .= '<div class="cata-item">
								<i class="'. $class_item .'" '. $icon_style .'><span class="delimiter"></span></i>
								<div class="cata-fild-name">'. $key .'</div>
								<p class="cata-'.$key.'">'. $value .'</p>
							</div>';
			}
		}
		$xhtml .= '</div>';
		$xhtml .= '</div>';
			
		return $xhtml;
		
	}
}
add_shortcode( 'cata_contactinfo_block', 'catanis_contactinfo_block_shortcode_function' );


/*=== SHORTCODE - CALL TO ACTION =============*/
/*============================================*/
if ( ! function_exists( 'catanis_callaction_shortcode_function' ) ) {
	function catanis_callaction_shortcode_function( $atts, $content = null ) {
		$main_style = $heading = $description = $text_color_style = $text_align = $bg_color = $bg_image = $image_position = $use_both_bg = $ext_class = '';

		$btn_1 = $btn_text_1 = $btn_style_1 = $outline_custom_color_1 = $outline_custom_hover_bg_1 = $outline_custom_hover_text_1 = '';
		$btn_bg_color_1 = $btn_text_color_1 = $btn_bg_color_hover_1 = $btn_text_color_hover_1 = '';

		$btn_2 = $btn_text_2 = $btn_style_2 = $outline_custom_color_2 = $outline_custom_hover_bg_2 = $outline_custom_hover_text_2 = '';
		$btn_bg_color_2 = $btn_text_color_2 = $btn_bg_color_hover_2 = $btn_text_color_hover_2 = '';

		extract( shortcode_atts( array(
			'main_style' 					=> 'style3', 		/* style1 -> style6 */
			'heading' 						=> '',
			'description' 					=> '',
			'text_color_style' 				=> '',				/* text-light */
			'text_align' 					=> '',
			'bg_color' 						=> '#F1F1F1',
			'bg_image' 						=> '',
			'image_position' 				=> 'img-left',		/*img-left, img-right*/
			'use_both_bg' 					=> '',				/* 1 */
			'btn_1' 						=> '',
			
			'btn_text_1' 					=> 'PURCHASE NOW',
			'btn_style_1' 					=> 'flat',
			'outline_custom_color_1' 		=> '#e49497',
			'outline_custom_hover_bg_1' 	=> '#e49497',
			'outline_custom_hover_text_1' 	=> '#FFFFFF',
			'btn_bg_color_1' 				=> '#e49497',
			'btn_text_color_1' 				=> '#FFFFFF',
			'btn_bg_color_hover_1' 			=> '#dfa1a3',
			'btn_text_color_hover_1' 		=> '#FFFFFF',			
			
			'btn_2' 						=> '',
			'btn_text_2' 					=> 'PURCHASE NOW',
			'btn_style_2' 					=> 'classic',
			'outline_custom_color_2' 		=> '#e49497',
			'outline_custom_hover_bg_2' 	=> '#e49497',
			'outline_custom_hover_text_2' 	=> '#FFFFFF',
			'btn_bg_color_2' 				=> '#e49497',
			'btn_text_color_2' 				=> '#FFFFFF',
			'btn_bg_color_hover_2' 			=> '#dfa1a3',
			'btn_text_color_hover_2' 		=> '#FFFFFF',
			'ext_class'						=> ''
		), $atts ) );

		/* 'button_color' 			=> '#e49497',
		'text_color' 			=> '#FFFFFF',
		'button_color_hover' 	=> '#dfa1a3',
		'text_color_hover' 		=> '#FFFFFF',
		
		'outline_custom_color' 		=> '#e49497',
		'outline_custom_hover_bg' 	=> '#e49497',
		'outline_custom_hover_text' => '#FFFFFF', */
		
		
		
		if ( empty( $heading) && empty( $description) ) {
			return '';
		}

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_callaction');
		$elemClass 	= 'cata-callaction cata-' . $main_style . ' ' . $text_color_style;
		$elemClass .= ( in_array($main_style, array('style2', 'style4')) && !empty($text_align) ) ? ' ' . $text_align : '';
		$elemClass .= ( $main_style == 'style4' ) ? ' ' . $image_position : '';
		$elemClass .= ( $use_both_bg) ? ' both-bg': '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$elemClass  = str_replace('  ', ' ', trim($elemClass));

		if(is_numeric($bg_image)){
			$bg_image = wp_get_attachment_image_url( $bg_image, 'full') ;
		}
		
		if(empty($bg_color)){
			$bg_color = 'transparent';
		}

		global $catanis;
		$custom_css = '';

		$selectID = '#' . $elemID;
		$btn_size = 'nm';
		if($main_style == 'style1' || $main_style == 'style3'){
			$custom_css .= $selectID . ' {background-color: '. $bg_color .'; }';
			if(!empty($bg_image)){
				$custom_css .= $selectID . ' {background: url('. $bg_image .'); }';
			}
				
		}elseif($main_style == 'style2'){
			if($use_both_bg){
				$custom_css .= $selectID . ' .content-wrapper {background-color: '. $bg_color .'; }';
			}else{
				$custom_css .= $selectID . ' {background-color: '. $bg_color .'; }';
			}
				
			if(!empty($bg_image)){
				$custom_css .= $selectID . ' {background: url('. $bg_image .'); }';
			}
				
		}elseif($main_style == 'style4'){
			$custom_css .= $selectID . ' .callaction-heading{background-color: '. $bg_color .'; }';

		}elseif($main_style == 'style5'){
			$custom_css .= $selectID . ' .content-wrapper {background-color: '. $bg_color .'; }';
			if(!empty($bg_image)){
				$custom_css .= $selectID . ' {background: url('. $bg_image .'); }';
			}
				
		}elseif($main_style == 'style6'){
			$btn_size = 'md';	
			$custom_css .= $selectID . ' {background-color: '. $bg_color .'; }';
			if(!empty($bg_image)){
				$custom_css .= $selectID . ' {background: url('. $bg_image .'); }';
			}
		}
		$catanis->inlinestyle[] = $custom_css;
		$btn1_shortcode = '[cata_button main_style="'. $btn_style_1 .'" button_text="'. $btn_text_1 .'"';
		$btn1_shortcode .= ' link="'. $btn_1 .'" shape = "square" size ="'. $btn_size .'"';
		$btn1_shortcode .= ' outline_custom_color="'. $outline_custom_color_1 .'" outline_custom_hover_bg = "'. $outline_custom_hover_bg_1 .'" outline_custom_hover_text ="'. $outline_custom_hover_text_1 .'"';
		$btn1_shortcode .= ' button_color = "'. $btn_bg_color_1 .'" text_color = "'. $btn_text_color_1 .'"';
		$btn1_shortcode .= ' button_color_hover = "'. $btn_bg_color_hover_1 .'" text_color_hover = "'. $btn_text_color_hover_1 .'"]';

		if(!empty($btn_2) && $btn_2 != '|||') {
			$btn2_shortcode = '[cata_button main_style="'. $btn_style_2 .'" button_text="'. $btn_text_2 .'"';
			$btn2_shortcode .= ' link="'. $btn_2 .'" shape = "square" size ="'. $btn_size .'"';
			$btn2_shortcode .= ' outline_custom_color="'. $outline_custom_color_2 .'" outline_custom_hover_bg = "'. $outline_custom_hover_bg_2 .'" outline_custom_hover_text ="'. $outline_custom_hover_text_2 .'"';
			$btn2_shortcode .= ' button_color = "'. $btn_bg_color_2 .'" text_color = "'. $btn_text_color_2 .'"';
			$btn2_shortcode .= ' button_color_hover = "'. $btn_bg_color_hover_2 .'" text_color_hover = "'. $btn_text_color_hover_2 .'"]';
		}
		
		ob_start();
		?>
			<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>> 
				<?php if($main_style == 'style1'): ?>
					
					<div class="content-wrapper cata-cols-wrapper cols-34">
						<div class="callaction-heading col">
							<h4><?php echo esc_html($heading); ?></h4>
							
							<?php if(!empty($description)): ?>
							<div><?php echo trim($description); ?></div>
							<?php endif; ?>
						</div>
						<div class="callaction-btn col">
							<?php echo do_shortcode($btn1_shortcode); ?>
						</div>
					</div>
					
				<?php elseif($main_style == 'style2'): ?>
					<div class="content-wrapper">
						<div class="callaction-heading">
							<h4><?php echo esc_html($heading); ?></h4>
								
							<?php if(!empty($description)): ?>
							<div><?php echo trim($description); ?></div>
							<?php endif; ?>
						</div>
						
						<div class="callaction-btn">
						<?php 
							echo do_shortcode($btn1_shortcode); 
							if(!empty($btn_2) && $btn_2 != '|||'):
								echo do_shortcode($btn2_shortcode); 
							endif;
						?>
						</div>
					</div>
				
				<?php elseif($main_style == 'style3'): ?>
					<div class="content-wrapper container cata-cols-wrapper cols-34">
						<div class="callaction-heading col">
							<h4><?php echo esc_html($heading); ?></h4>
						</div>
						
						<div class="callaction-btn col">
							<?php echo do_shortcode($btn1_shortcode); ?>
						</div>
					</div>
				
				<?php elseif($main_style == 'style4'): ?>
					<div class="content-wrapper cata-cols-wrapper cols-2">
						
						<?php if($image_position == 'img-left' ): ?>
							
							<div class="callaction-img col">
								<?php if(!empty($bg_image)): ?>
									<img src="<?php echo esc_url($bg_image); ?>" alt="<?php echo esc_html($heading); ?>" />
								<?php endif; ?>
							</div>
							
							<div class="callaction-heading col">
							
								<h4><?php echo esc_html($heading); ?></h4>
								
								<?php if(!empty($description)): ?>
								<div><?php echo trim($description); ?></div>
								<?php endif; ?>
								
								<div class="callaction-btn">
									<?php 
										echo do_shortcode($btn1_shortcode); 
										if(!empty($btn_2)):
											echo do_shortcode($btn2_shortcode); 
										endif;
									?>
								</div>
							</div>
							
						<?php else: ?>
							<div class="callaction-heading col">
								
								<?php if(!empty($description)): ?>
								<div><?php echo trim($description); ?></div>
								<?php endif; ?>
								
								<h4><?php echo esc_html($heading); ?></h4>
								<div class="callaction-btn">
									<?php 
										echo do_shortcode($btn1_shortcode); 
										if(!empty($btn_2) && $btn_2 != '|||'):
											echo do_shortcode($btn2_shortcode); 
										endif;
									?>
								</div>
							</div>
							
							<div class="callaction-img col">
								<?php if(!empty($bg_image)): ?>
									<img src="<?php echo esc_url($bg_image); ?>" alt="<?php echo esc_html($heading); ?>" />
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php elseif($main_style == 'style5'): ?>
					<div class="content-wrapper container">
						<div class="callaction-heading">
							<h4><?php echo esc_html($heading); ?></h4>
								
							<?php if(!empty($description)): ?>
							<div><?php echo trim($description); ?></div>
							<?php endif; ?>
						</div>
						
						<div class="callaction-btn">
						<?php 
							echo do_shortcode($btn1_shortcode); 
							if(!empty($btn_2) && $btn_2 != '|||'):
								echo do_shortcode($btn2_shortcode); 
							endif;
						?>
						</div>
					</div>
					
				<?php elseif($main_style == 'style6'): ?>
					<div class="content-wrapper container<?php if(empty($description)) echo ' no-desc'; ?>">
						<div class="callaction-heading">
							<h4><?php echo esc_html($heading); ?></h4>
								
							<?php if(!empty($description)): ?>
							<div><?php echo trim($description); ?></div>
							<?php endif; ?>
						</div>
						
						<div class="callaction-btn">
						<?php 
							echo do_shortcode($btn1_shortcode); 
							if(!empty($btn_2) && $btn_2 != '|||'):
								echo do_shortcode($btn2_shortcode); 
							endif;
						?>
						</div>
					</div>
				<?php endif; ?>
				
			</div>
		<?php 
		$xhtml = ob_get_contents();
	    ob_end_clean();
	
	    return $xhtml;
	}
}
add_shortcode( 'cata_callaction', 'catanis_callaction_shortcode_function' );


/*=== SHORTCODE - VIDEO ======================*/
/*============================================*/
if ( ! function_exists( 'catanis_video_shortcode_function' ) ) {
	function catanis_video_shortcode_function ($atts, $content = null ) {

		$xhtml = '';
		$video_style = $video_host = $video_url_youtube = $video_url_vimeo = $video_url_mp4 = '';
		$video_url_webm = $video_url_ogg = $image_overlay = $use_stick_corners = $title_overlay = $video_opts = '';
		$video_width = $video_align = $poster = $control_color = $content_height = $ext_class = '';

		$atts = catanis_strip_attr_prefix( $atts );
		extract( shortcode_atts( array(
			'video_style' 		=> 'normal',		/* normal, popup */
			'video_host' 		=> 'youtube',		/* youtube, vimeo, hosted */
			'video_url_youtube' => 'https://www.youtube.com/watch?v=Sn_g80FXA-0',
			'video_url_vimeo' 	=> '',
			'video_url_mp4' 	=> '',
			'video_url_webm' 	=> '',
			'video_url_ogg' 	=> '',
			'image_overlay'	 	=> '',
			'use_stick_corners'	=> '',				/*NULL,yes*/
			'title_overlay' 	=> '',
			'control_color' 	=> '#e49497',
			'video_width' 		=> '100',
			'video_align' 		=> 'left',
			'video_opts' 		=> 'controls',
			'content_height' 	=> 'auto',			/*Only for Popup style*/
			'ext_class' 		=> ''
		), $atts ) );

		wp_enqueue_script('catanis-js-videojs');
		
		$dataSetup = array();
		$video_opts = explode(',', $video_opts);
		if(is_numeric($image_overlay)){
			$image_overlay =  wp_get_attachment_url( $image_overlay ) ;
			$poster = (false == $image_overlay)? CATANIS_DEFAULT_IMAGE : $image_overlay;
			$dataSetup['poster'] = esc_url($image_overlay);
		}

		if(in_array('controls', $video_opts)){
			$dataSetup['controls'] = true;
		}
		if(in_array('loop', $video_opts)){
			$dataSetup['loop'] = true;
		}
		if(in_array('autoplay', $video_opts)){
			$dataSetup['autoplay'] = true;
			$ext_class 	.= ' cata-video-autoplay';
		}
		if(in_array('muted', $video_opts)){
			$dataSetup['muted'] = true;
			$ext_class 	.= ' cata-video-muted';
		}

		$sources = '';
		if($video_host == 'hosted') {
			if($video_url_mp4!='') {
				$sources .= '<source src="'.esc_url($video_url_mp4).'" type="video/mp4">';
			}

			if($video_url_webm!='') {
				$sources .= '<source src="'.esc_url($video_url_webm).'" type="video/webm">';
			}
				
			if($video_url_ogg!='') {
				$sources .= '<source src="'.esc_url($video_url_ogg).'" type="video/ogg">';
			}

		}elseif($video_host == 'youtube'){
			wp_enqueue_script('catanis-js-videojs-youtube');
			$dataSetup['techOrder'] = array('youtube');
			$dataSetup['sources'] = array(array(
					'type' 	=> 'video/youtube',
					'src' 	=> trim($video_url_youtube)
			));
				
		}elseif($video_host == 'vimeo'){
			wp_enqueue_script('catanis-js-videojs-vimeo');
			
			$dataSetup['techOrder'] = array('vimeo');
			$dataSetup['vimeo'] = array('color' => '#E6b1b');
			$dataSetup['sources'] = array(array(
				'type' 	=> 'video/vimeo',
				'src' 	=> trim($video_url_vimeo)
			));
		}

		$elemID 	= catanis_random_string(10, 'video');
		$elemCls 	= 'video-align-' . $video_align . ' video-width-' . $video_width . ' video-host-'. $video_host;
		$elemCls 	.= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		if(empty($poster)){
			$elemCls .= ' noimg';
				
			global $catanis;
			$custom_css = '';
				
			$selectID = '#' . $elemID .'.cata-video-popup-style';
			if ( $video_style == 'popup' ) {
				$custom_css .= $selectID . ' .video-ctent .video-control{border-color: '. $control_color .';}';
				$custom_css .= $selectID . ' .video-ctent .video-control:before{ border-left-color:'. $control_color .'; }';
				$custom_css .= $selectID . ' .video-ctent h4{ color:'. $control_color .'; }';
			}
			$catanis->inlinestyle[] = $custom_css;
		}

		if ( $video_style == 'normal' ) {
				
			$xhtml .= '<div id="'.$elemID.'" class="cata-video '. $elemCls .'"><div class="wrap-cata-video">';
			$xhtml .= ($use_stick_corners == 'yes') ? '<div class="cata-corner-tl"></div><div class="cata-corner-br"></div>' : '';
			$xhtml .= '<video dir="rtl" id="s'. str_replace('_', '-', $elemID) .'" data-setup=\''. json_encode($dataSetup) .'\' class="video-js">'. $sources .'<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p></video>';
			$xhtml .= '</div></div>';
				
		} else {
			$dataSetup['controls'] = true;
			$elemCls .= ' cata-video-popup-style';
			$xhtml 	.= '<div id="'.$elemID.'" class="cata-video '. $elemCls .'" data-id="'. str_replace('_', '-', $elemID) .'">';
			$xhtml .= '		<div class="video-hid" id="'. str_replace('_', '-', $elemID)  .'" data-setup=\''. json_encode($dataSetup) .'\'>'. $sources .'<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p></div>';
			
			$bgpopup_style = 'background-image:url(' . $image_overlay . ');';
			if( $content_height != 'auto' ){
				$bgpopup_style .= 'height:'.$content_height;
			}
			
			if(!empty($image_overlay)){
				$xhtml 	.= '<div class="cata-bg-image" style="' . $bgpopup_style . '">';
				$xhtml 	.= '<div class="video-ctent"><div><span class="video-control"></span>';
				if(!empty($title_overlay)){
					$xhtml 	.= '<h4>' . $title_overlay . '</h4>';
				}
				$xhtml 	.= '</div></div></div>';
			}else{
				$xhtml 	.= '<div class="video-ctent"><div><span class="video-control"></span>';
				if(!empty($title_overlay)){
					$xhtml 	.= '<h4>' . $title_overlay . '</h4>';
				}
				$xhtml 	.= '</div></div>';
			}
			
			$xhtml 	.= '</div>';
		}

		return $xhtml;
			
	}
}
add_shortcode( 'cata_video', 'catanis_video_shortcode_function' );


/*=== SHORTCODE - AUDIO MP3 ==================*/
/*============================================*/
if ( ! function_exists( 'catanis_audio_shortcode_function' ) ) {
	function catanis_audio_shortcode_function( $atts, $content = null ) {
		$xhtml = '';
		$mp3_url = $image_overlay = $video_width = $video_align = $video_opts = $ext_class = '';
		
		extract( shortcode_atts( array(
			'mp3_url' 			=> '',
			'image_overlay'	 	=> '',
			'video_width' 		=> '100',
			'video_align' 		=> 'left',
			'video_opts' 		=> 'controls',
			'ext_class' 		=> ''
		), $atts ) );
		
		if(empty($mp3_url)){
			return; 
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_audio');
		$elemClass 	= 'cata-audiomp3 cata-element video-align-' . $video_align . ' video-width-' . $video_width;
		$elemClass .= (!empty($image_overlay)) ? ' has-thumb': '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$elemClass  = str_replace('  ', ' ', trim($elemClass));
		
		if ( !empty( $image_overlay ) ) {
			$image_overlay 	= wp_get_attachment_url( $image_overlay );
		}

		$video_opts = explode(',', $video_opts);
		$loop = (in_array('loop', $video_opts)) ? '1': '0';
		$autoplay = (in_array('autoplay', $video_opts)) ? '1' : '0';
		ob_start();
		?>
			
		<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
			
			<div class="cata-audio-mp3">
				<?php echo do_shortcode('[audio preload="auto" autoplay="'. $autoplay .'" loop="'. $loop .'" src="'. esc_url($mp3_url) .'"]'); ?>
			</div>
			
			<?php if(!empty($image_overlay)): ?>
				<figure class="entry-thumbnail">
					<img src="<?php echo esc_url($image_overlay); ?>" alt="">
				</figure>
			<?php endif; ?>
		</div>	
					
		<?php 
		$xhtml = ob_get_contents();
		ob_end_clean();
		 
		return $xhtml;
		
	}
}
add_shortcode( 'cata_audio', 'catanis_audio_shortcode_function' );


/*=== SHORTCODE - ICONBOX ====================*/
/*============================================*/
if ( ! function_exists( 'catanis_iconbox_shortcode_function' ) ) {
	function catanis_iconbox_shortcode_function( $atts, $content = null ) {

		$xhtml = $main_style = $number = $heading = $heading_size = $subject = $text_color_style = '';
		$icon = $bgimg = $icon_size = $show_readmore = $readmore_text = $readmore_link = $target_link = $ext_class = '';
		$atts = catanis_strip_attr_prefix( $atts );
		extract( shortcode_atts( array(
			'main_style' 		=> 'style1',		/* style1 -> style8 */
			'number' 			=> '01',
			'heading' 			=> '',
			'heading_size' 		=> '',
			'subject' 			=> '',
			'text_color_style' 	=> '', 				/* NULL , text-light */
			'icon' 				=> 'fa fa-info-circle',
			'bgimg' 			=> '',
			'icon_size' 		=> '',
			'show_readmore' 	=> 1,
			'readmore_text' 	=> esc_html__('Read more', 'catanis-core'),
			'readmore_link' 	=> '#',
			'target_link' 		=> '_blank',
			'ext_class' 		=> ''
		), $atts ) );
		 
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_iconbox');
		$elemClass 	= 'cata-iconbox cata-element cata-' . $main_style;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($text_color_style) ) ? ' cata-color-' . $text_color_style : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$elemClass  = str_replace('  ', ' ', trim($elemClass));
		
		$imageBG = '';
		if ( !empty( $bgimg ) ) {
			$bgimg 		= wp_get_attachment_image_src( $bgimg, 'full' );
			$imageBG 	= $bgimg[0];
		}

		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;
		if(!empty($heading_size)){
			$custom_css .= $selectID . ' h6{font-size: '. $heading_size .';}';
		}
		if(!empty($icon_size)){
			$custom_css .= $selectID . ' span.icon{font-size: '. $icon_size .';}';
		}
		$catanis->inlinestyle[] = $custom_css;
		
		ob_start();
		?>
	
		<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
			
			<?php if( in_array($main_style, array('style1', 'style2', 'style3')) ): ?>
				<span class="icon <?php echo esc_attr($icon); ?>"></span>
				<div class="iconbox-wrap">
					<h6>
						<?php if ( $show_readmore ) : ?><a href="<?php echo esc_url( $readmore_link ); ?>" title="<?php echo esc_attr($heading); ?>"><?php endif; ?>
						<?php echo esc_attr( $heading ); ?>
						<?php if ( $show_readmore ) : ?></a><?php endif; ?>
					</h6>
					<p><?php echo wp_kses_post($subject);?></p>
					
					<?php if ( $show_readmore ) : ?>
						<a href="<?php echo esc_url( $readmore_link ); ?>" class="readmore" target="<?php esc_attr_e( $target_link ); ?>" title="<?php esc_html_e($readmore_text);?>"><?php esc_html_e($readmore_text);?></a>
					<?php endif; ?>
				</div>
			<?php elseif( $main_style == 'style4'): ?>
				<span class="number"><?php echo esc_attr($number); ?></span>
				<div class="iconbox-wrap">
					<h6>
						<?php if ( $show_readmore ) : ?><a href="<?php echo esc_url( $readmore_link ); ?>" title="<?php echo esc_attr($heading); ?>"><?php endif; ?>
						<?php echo esc_attr( $heading ); ?>
						<?php if ( $show_readmore ) : ?></a><?php endif; ?>
					</h6>
					<p><?php echo wp_kses_post($subject);?></p>
					
					<?php if ( $show_readmore ) : ?>
						<a href="<?php echo esc_url( $readmore_link ); ?>" class="readmore" target="<?php esc_attr_e( $target_link ); ?>" title="<?php esc_html_e($readmore_text);?>"><?php esc_html_e($readmore_text);?></a>
					<?php endif; ?>
				</div>
				
			<?php elseif( $main_style == 'style5'): ?>
			
				<div class="cata-flipbox">
					<div class="cata-flipbox-front">
						<span class="icon <?php echo esc_attr($icon); ?>"></span>
						<div class="iconbox-wrap">
							<h6>
								<?php if ( $show_readmore ) : ?><a href="<?php echo esc_url( $readmore_link ); ?>" title="<?php echo esc_attr($heading); ?>"><?php endif; ?>
								<?php echo esc_attr( $heading ); ?>
								<?php if ( $show_readmore ) : ?></a><?php endif; ?>
							</h6>
							<p><?php echo wp_kses_post($subject);?></p>
							
							<?php if ( $show_readmore ) : ?>
								<a href="<?php echo esc_url( $readmore_link ); ?>" class="readmore" target="<?php esc_attr_e( $target_link ); ?>" title="<?php esc_html_e($readmore_text);?>"><?php esc_html_e($readmore_text);?></a>
							<?php endif; ?>
						</div>
					</div>
					
					<div class="cata-flipbox-back" style="background:url(<?php echo esc_url($imageBG); ?>) no-repeat center;">
						<?php if ( $show_readmore ) : ?>
							<a href="<?php echo esc_url( $readmore_link ); ?>" target="<?php esc_attr_e( $target_link ); ?>" title="<?php esc_html_e($readmore_text);?>"></a>
						<?php endif; ?>
					</div>
				</div>
				
			<?php else: 
				echo esc_html('The styles you choose do not exist, please choose again.', 'catanis-core'); ?>
				
			<?php endif; ?>
		</div>
	    <?php
	    $xhtml = ob_get_contents();
	    ob_end_clean();
	    
	    return $xhtml;
		
	}
}
add_shortcode( 'cata_iconbox', 'catanis_iconbox_shortcode_function' );


/*=== SHORTCODE - TEAM =======================*/
/*============================================*/
if ( ! function_exists( 'catanis_team_shortcode_function' ) ) {
	function catanis_team_shortcode_function( $atts = array(), $content ) {
		if( !class_exists('Catanis_Meta')){
			return;
		}
		$xhtml = $main_style = $style = $ids = $id = $list_columns = $show_desc = $text_color_style = '';
		$items_desktop = $items_desktop_small = $items_tablet = $slide_arrows = $slide_dots = $slide_dots_style ='';
		$slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $orderby = $order = $ext_class = ''; 
		$atts = catanis_strip_attr_prefix( $atts );
		extract( shortcode_atts( array(
			'main_style'  			=> 'style1', 		/* style1, style2 */
			'style'  				=> 'slider-slick', 	/* slider-slick, slider-center, list, item */
			'ids'					=> '',
			'id'					=> '',
			'list_columns'			=> 'cols-3',		/*cols-2 -> cols-5*/	
			'show_desc'				=> '',				/*NULL, yes*/
			'text_color_style' 		=> '',				/*NULL, dark*/
			'items_desktop' 		=> '4',
			'items_desktop_small' 	=> '3',
			'items_tablet' 			=> '2',
			
			'slide_arrows'			=> 'no', 	
			'slide_dots'			=> 'yes', 	
			'slide_dots_style'		=> 'dots-line', 	/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/	
			'slide_autoplay'		=> 'no', 	
			'slide_autoplay_speed'	=> 3000, 	
			'slides_to_scroll'		=> 3, 	
			'slides_speed'			=> 500, 
			'orderby'				=> 'date', 
			'order'					=> 'DESC', 
			'ext_class' 			=> ''
		), $atts ) );

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_team');
		$elemClass 	= 'cata-team cata-element cata-' . $main_style;
		$elemClass .= (!empty($text_color_style)) ? ' cata-color-' . $text_color_style : '';
		$elemClass .= ($style == 'slider-slick') ? ' cata-slick-slider cata-slider-spacing0 ' . $slide_dots_style : '';
		$elemClass .= ($style == 'slider-center') ? ' cata-slick-slider ' . $slide_dots_style : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		$arrParams = array();
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		if( in_array($style, array('slider-slick' ,'slider-center')) ){
			$arrParams = array(
				'autoplay' 			=> ($slide_autoplay == 'yes') ? true : false,
				'autoplaySpeed' 	=> intval($slide_autoplay_speed),
				'slidesToShow' 		=> intval($items_desktop),
				'slidesToScroll' 	=> intval($slides_to_scroll),
				'dots' 				=> ($slide_dots == 'yes')? true : false,
				'arrows' 			=> ($slide_arrows == 'yes')? true : false,
				'infinite' 			=> true,
				'draggable' 		=> true,
				'speed' 			=> intval($slides_speed),
				'rtl' 				=> CATANIS_RTL,
				'responsive'		=> array(
					array(
						'breakpoint'	=> 1024,
						'settings'		=> array(
							'slidesToShow'		=> intval($items_desktop_small),
							'slidesToScroll' 	=> intval($items_desktop_small)
						)
					),
					array(
						'breakpoint'	=> 768,
						'settings'		=> array(
							'slidesToShow'		=> intval($items_tablet),
							'slidesToScroll' 	=>  intval($items_tablet)
						)
					),
					array(
						'breakpoint'	=> 480,
						'settings'		=> array(
							'slidesToShow'		=> 1,
							'slidesToScroll' 	=> 1
						)
					),
				)
			);

			if( $style == 'slider-center' ){
				$arrParams['centerMode'] = true;
				$arrParams['centerPadding'] = '0px';
			}
		}
		
		$wraperClass = '';
		if ( $style == 'slider-slick' ) {
			$wraperClass = 'slides';
		} else if ( $style == 'slider-center' ) {
			$wraperClass = 'slides cata-team-center-slider';
		} else if ( $style == 'list' ) {
			$wraperClass = 'cata-cols-wrapper ' .$list_columns;
		}
		
		/* slider-slick, slider-center, list, item */
		if ( $ids && in_array($style, array('slider-slick', 'slider-center' ,'list'))  ) {
			$_query = new WP_Query( array( 
				'post_type' => 'team', 
				'post_status' => 'publish', 
				'post__in' => explode( ',', $ids ), 
				'posts_per_page' => 999,
				'orderby' => $orderby,
				'order' => $order
			));
		} elseif ( $id && $id > 0 && $style == 'item' ) {
			$_query = get_transient( 'cata_team_sc_query_transient_' . $main_style . '_' . $style . '_' . $id );
			if( $_query === false ) {
				$_query = new WP_Query( array( 'post_type' => 'team', 'post_status' => 'publish', 'p' => $id ) );
				set_transient( 'cata_team_sc_query_transient_' . $style . '_' . $id, $_query, 8 * HOUR_IN_SECONDS );
			}
		} else {
			return '';
		}
		
		ob_start();
		if ( $_query->have_posts() ) :
		?>
		
		<div<?php echo rtrim($dir); ?> id="<?php echo esc_attr( $elemID ); ?>" class="<?php echo esc_attr( $elemClass ); ?>" <?php echo trim($animation['animation-attrs']); ?>>
			
			<div class="<?php echo esc_attr($wraperClass); ?>" data-slick='<?php echo json_encode($arrParams); ?>'>
			<?php 
				while ( $_query->have_posts() ) : global $post; $_query->the_post();
					$name 			= esc_html( get_the_title( $post->ID ) );
					$content 		= wp_strip_all_tags( $post->post_content );
					$metaOpts 		= get_post_meta( $post->ID, Catanis_Meta::getKeySave(), true );
						
					$personal_url = $metaOpts['personal_url'];
					if ( $metaOpts['personal_url'] == '' ) { $personal_url = '#'; }
			
					$socials = '';
					if ( isset( $metaOpts['facebook_url'] ) && $metaOpts['facebook_url'] ) {
						$socials .= '<a class="facebook" href="' . esc_url( $metaOpts['facebook_url'] ) . '" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a>';
					}
					if ( isset( $metaOpts['twitter_url'] ) && $metaOpts['twitter_url'] ) {
						$socials .= '<a class="twitter" href="' . esc_url( $metaOpts['twitter_url'] ) . '" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a>';
					}
					if ( isset( $metaOpts['googleplus_url'] ) && $metaOpts['googleplus_url'] ) {
						$socials .= '<a class="google" href="' . esc_url( $metaOpts['googleplus_url'] ) . '" target="_blank" rel="nofollow"><i class="fa fa-google-plus"></i></a>';
					}
					if ( isset( $metaOpts['pinterest_url'] ) && $metaOpts['pinterest_url'] ) {
						$socials .= '<a class="pinterest" href="' . esc_url( $metaOpts['pinterest_url'] ) . '" target="_blank" rel="nofollow"><i class="fa fa-pinterest-p"></i></a>';
					}
					if ( isset( $metaOpts['instagram_url'] ) && $metaOpts['instagram_url'] ) {
						$socials .= '<a class="instagram" href="' . esc_url( $metaOpts['instagram_url'] ) . '" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i></a>';
					}
					if ( isset( $metaOpts['linkedin_url'] ) && $metaOpts['linkedin_url'] ) {
						$socials .= '<a class="linkedin" href="' . esc_url( $metaOpts['linkedin_url'] ) . '" target="_blank" rel="nofollow"><i class="fa fa-linkedin"></i></a>';
					}
					if ( isset( $metaOpts['dribble_url'] ) && $metaOpts['dribble_url'] ) {
						$socials .= '<a class="dribble" href="' . esc_url($metaOpts['dribble_url'] ) . '" target="_blank" rel="nofollow"><i class="fa fa-dribbble"></i></a>';
					}
					if ( isset( $metaOpts['behance_url'] ) && $metaOpts['behance_url'] ) {
						$socials .= '<a class="behance" href="' . esc_url($metaOpts['behance_url'] ) . '" target="_blank" rel="nofollow"><i class="fa fa-behance"></i></a>';
					}
					if ( isset($metaOpts['youtube_url'] ) && $metaOpts['youtube_url'] ) {
						$socials .= '<a class="youtube" href="' . esc_url( $metaOpts['youtube_url'] ) . '" target="_blank" rel="nofollow"><i class="fa fa-youtube-play"></i></a>';
					}
					if ( isset( $metaOpts['vimeo_url'] ) && $metaOpts['vimeo_url'] ) {
						$socials .= '<a class="vimeo" href="' . esc_url( $metaOpts['vimeo_url'] ) .'" target="_blank" rel="nofollow"><i class="fa fa-vimeo-square"></i></a>';
					}
					if ( isset( $metaOpts['email'] ) && $metaOpts['email'] ) {
						$socials .= '<a class="email" href="mailto:' . $metaOpts['email'] . '" target="_blank" rel="nofollow"><i class="fa fa-envelope"></i></a>';
					}
				?>
				<div class="cata-item col">
					<div class="team-member" <?php echo trim($animation['animation-attrs']); ?>>
						<figure class="animated-overlay">
							<?php the_post_thumbnail( 'cata_team_thumb' ); ?>
							
							<?php if($main_style == 'style1' && !empty( $socials ) ) : ?>
								<figcaption><div class="social"><?php echo $socials; ?></div></figcaption>
							<?php endif; ?>
						</figure>
						<div class="info">
							<div>
								<div class="name-role">
									<a class="name" href="<?php echo $personal_url; ?>" target="_blank"><?php echo $name; ?></a>
									<?php if ( $metaOpts['position'] ) : ?>
									<span class="role"><?php echo esc_html( $metaOpts['position'] ); ?></span>
									<?php endif; ?>
								</div>
								
								<?php if($main_style == 'style2' && !empty( $socials ) ) : ?>
									<div class="social"><?php echo $socials; ?></div>
								<?php endif; ?>
								
								<?php if ( $show_desc == 'yes' && !empty($metaOpts['short_description']) ) : ?>
									<p class="short-desc">
										<?php echo esc_html( $metaOpts['short_description'] ); ?>
									</p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
		<?php endwhile; ?>
			</div>
		</div>	
			<?php 
		endif;
		
		$xhtml = ob_get_contents();
		ob_end_clean();
		wp_reset_postdata();
		return $xhtml;
	}
}
add_shortcode( 'cata_team', 'catanis_team_shortcode_function' );


/*=== SHORTCODE - TESTTIMONIAL ===============*/
/*============================================*/
if ( ! function_exists( 'catanis_testimonial_shortcode_function' ) ) {
	function catanis_testimonial_shortcode_function( $atts, $content ) {

		if( !class_exists('Catanis_Meta')){
			return;
		}
		$xhtml = $main_style = $category = $number = $show_rating = $show_avatar = $show_organization = $show_nav = $text_color_style = '';
		$items_desktop = $items_desktop_small = $items_tablet = $slide_arrows = $slide_loop = $slide_dots = $slide_dots_style ='';
		$slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $orderby = $order = $ext_class = '';
		extract( shortcode_atts( array(
			'main_style'  			=> 'style1', 		/* style1 -> style7*/
			'category'				=> '',
			'number'				=> '6',
			'show_rating'			=> '',				/*NULL, yes*/
			'show_organization'		=> '',				/*NULL, yes*/
			'show_nav'				=> 'yes',			/*NULL, no, yes - for only style-carousel*/
			'text_color_style' 		=> '',				/*NULL, dark*/
			'items_desktop' 		=> '4',
			'items_desktop_small' 	=> '3',
			'items_tablet' 			=> '2',
				
			'slide_loop'			=> 'yes',
			'slide_arrows'			=> 'no',
			'slide_dots'			=> 'yes',
			'slide_dots_style'		=> 'dots-line', 	/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/
			'slide_autoplay'		=> 'no',
			'slide_autoplay_speed'	=> 3000,
			'slides_to_scroll'		=> 3,
			'slides_speed'			=> 500,
			'orderby'				=> 'date',
			'order'					=> 'DESC',
			'ext_class' 			=> ''
		), $atts ) );
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_testimonial');
		$elemClass 	= 'cata-testimonial cata-element cata-' . $main_style . ' cata-slick-slider cata-slider-spacing30 ' . $slide_dots_style;
		$elemClass .= (!empty($text_color_style)) ? ' cata-color-' . $text_color_style : '';
		$elemClass .= ( intval($items_desktop) == 1) ? ' cata-col-one' : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		if ( $main_style != "style-carousel" ) {
			$arrParams = array(
				'autoplay' 			=> ($slide_autoplay == 'yes') ? true : false,
				'autoplaySpeed' 	=> intval($slide_autoplay_speed),
				'slidesToShow' 		=> intval($items_desktop),
				'slidesToScroll' 	=> intval($slides_to_scroll),
				'dots' 				=> ($slide_dots == 'yes')? true : false,
				'arrows' 			=> ($slide_arrows == 'yes')? true : false,
				'infinite' 			=> ($slide_loop == 'yes')? true : false,
				'draggable' 		=> true,
				'speed' 			=> intval($slides_speed),
				'rtl' 				=> CATANIS_RTL,
				'adaptiveHeight' 	=> true,
				'responsive'		=> array(
					array(
						'breakpoint'	=> 1024,
						'settings'		=> array(
							'slidesToShow'		=> intval($items_desktop_small),
							'slidesToScroll' 	=> intval($items_desktop_small)
						)
					),
					array(
						'breakpoint'	=> 768,
						'settings'		=> array(
							'slidesToShow'		=> intval($items_tablet),
							'slidesToScroll' 	=>  intval($items_tablet)
						)
					),
					array(
						'breakpoint'	=> 480,
						'settings'		=> array(
							'slidesToShow'		=> 1,
							'slidesToScroll' 	=> 1
						)
					),
				)
			);

			if($items_desktop == 1 && $items_desktop_small == 1 && $items_tablet == 1){
				$arrParams['slidesToScroll'] = 1;
				$arrParams['fade'] = true;
				$arrParams['cssEase'] = 'linear';
			}
		}
	
		$args = array(
			'post_type'				=> 'testimonials',
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> true,
			'posts_per_page' 		=> $number,
			'orderby' 				=> $orderby,
			'order' 				=> $order
		);

		if ( $category != "" ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' 	=> 'testimonials_category',
					'terms' 	=> explode( ',', esc_attr( $category ) ),
					'field' 	=> 'slug',
					'operator' 	=> 'IN'
				)
			);
		}

		$testimonials = new WP_Query($args);
		if( !isset($testimonials->post_count) || $testimonials->post_count <= 0 ){
			return;
		}

		global $post;
		ob_start();
		?>
		<?php if( $testimonials->have_posts() ): ?>
			<div<?php echo rtrim($dir); ?> id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
			
				<ul class="slides testimonial-inner" data-slick='<?php echo json_encode($arrParams); ?>'>
					<?php 
					while( $testimonials->have_posts() ):
						$testimonials->the_post();
						$postMeta 	= get_post_meta( $post->ID, Catanis_Meta::getKeySave(), true );
						
						$organization_url = esc_url( $postMeta['organization_url'] ); 
						$author = esc_attr( $postMeta['author'] );
						$occupation = esc_attr( $postMeta['occupation'] );
						$thumbnail = !empty( $postMeta['thumbnail'] ) ? trim($postMeta['thumbnail']) : CATANIS_DEFAULT_IMAGE;
					?>
					<li class="cata-item">
						<div class="cata-wrap-content">
							
							<?php if( $main_style == 'style1' ): ?>
								<div class="cata-detail">
									<div class="testimonial-content"><?php echo $postMeta['testimonial']; ?></div>
								</div>
								<div class="cata-avatar">
									<a href="<?php echo esc_url($organization_url); ?>" title="<?php echo esc_attr($author); ?> - <?php echo esc_attr($occupation); ?>" target="<?php echo esc_attr($postMeta['target_link' ]); ?>">
										<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($author); ?>"/>
									</a>
								</div>
							
								<div class="cata-info">
									<a class="title" href="<?php echo esc_url($organization_url); ?>" title="<?php echo esc_attr($author); ?>" target="<?php echo esc_attr($postMeta['target_link' ]); ?>"><?php echo esc_attr($author); ?></a><em>,</em>
									<span class="occupation"><?php echo esc_attr($occupation); ?></span>
									
									<?php if ( $show_organization == 'yes' && !empty($postMeta['organization']) ): ?>
										<span class="organization"><?php echo esc_attr( $postMeta['organization'] ); ?></span>
									<?php endif; ?>
									
									<?php if( $show_rating ): ?>
										<p class="cata-rating-star">
											<?php echo str_repeat('<i class="fa fa-star"></i>', absint($postMeta['rating_star']));?>
										</p>
									<?php endif; ?>
								</div>
							<?php elseif( $main_style == 'style2' ): ?>
								<div class="cata-avatar">
									<a href="<?php echo esc_url($organization_url); ?>" title="<?php echo esc_attr($author); ?> - <?php echo esc_attr($occupation); ?>" target="<?php echo esc_attr($postMeta['target_link' ]); ?>">
										<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($author); ?>"/>
									</a>
								</div>
								
								<div class="cata-info">
									<a class="title" href="<?php echo esc_url($organization_url); ?>" title="<?php echo esc_attr($author); ?>" target="<?php echo esc_attr($postMeta['target_link' ]); ?>"><?php echo esc_attr($author); ?></a><em>,</em>
									<span class="occupation"><?php echo esc_attr($occupation); ?></span>
									
									<?php if ( $show_organization == 'yes' && !empty($postMeta['organization']) ): ?>
										<span class="organization"><?php echo esc_attr( $postMeta['organization'] ); ?></span>
									<?php endif; ?>
									
									<?php if( $show_rating ): ?>
										<p class="cata-rating-star">
											<?php echo str_repeat('<i class="fa fa-star"></i>', absint($postMeta['rating_star']));?>
										</p>
									<?php endif; ?>
								</div>
								
								<div class="cata-detail">
									<div class="testimonial-content"><?php echo $postMeta['testimonial']; ?></div>
								</div>
								
							<?php else: ?>
							
								<?php if ( $main_style != 'style7'): ?>
								<div class="cata-avatar">
									<a href="<?php echo esc_url($organization_url); ?>" title="<?php echo esc_attr($author); ?> - <?php echo esc_attr($occupation); ?>" target="<?php echo esc_attr($postMeta['target_link' ]); ?>">
										<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($author); ?>"/>
									</a>
								</div>
								<?php endif; ?>
								
								<div class="cata-detail">
									<div class="testimonial-content"><?php echo $postMeta['testimonial']; ?></div>
								</div>
								
								<div class="cata-info">
									<a class="title" href="<?php echo esc_url($organization_url); ?>" title="<?php echo esc_attr($author); ?>" target="<?php echo esc_attr($postMeta['target_link' ]); ?>"><?php echo esc_attr($author); ?></a><em>,</em>
									<span class="occupation"><?php echo esc_attr($occupation); ?></span>
									
									<?php if ( $show_organization == 'yes' && !empty($postMeta['organization']) ): ?>
										<span class="organization"><?php echo esc_attr( $postMeta['organization'] ); ?></span>
									<?php endif; ?>
									
									<?php if( $show_rating ): ?>
										<p class="cata-rating-star">
											<?php echo str_repeat('<i class="fa fa-star"></i>', absint($postMeta['rating_star']));?>
										</p>
									<?php endif; ?>
								</div>
								
								
							<?php endif; ?>
							
						</div>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
		<?php endif; ?>
			
		<?php
		$xhtml = ob_get_contents();
		ob_end_clean();
		wp_reset_postdata();
		return $xhtml;
	}
}
add_shortcode( 'cata_testimonial', 'catanis_testimonial_shortcode_function' );


/*=== SHORTCODE - GOOGLE MAPS ================*/
/*============================================*/
if( ! function_exists( 'catanis_google_maps_shortcode_function' ) ) {
	function catanis_google_maps_shortcode_function( $atts, $content = null ) {

		$main_style = $map_type = $width = $height = $zoom = $scrollwheel = $scale = $zoom_pancontrol = $ext_class = '';
		extract( shortcode_atts( array(
			'main_style' 		=> 'style1',
			'map_type' 			=> 'roadmap',
			'width' 			=> '100%',
			'height' 			=> '500px',
			'zoom' 				=> '8',
			'scrollwheel' 		=> '',
			'scale' 			=> 'yes',
			'zoom_pancontrol' 	=> 'yes',
			'ext_class' 		=> ''
		), $atts ) );

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_gmaps');
		$elemClass 	= 'cata-google-maps cata-element cata-' . $main_style;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		wp_enqueue_script( 'catanis-js-googleMaps' );

		ob_start();
		?>
	    <div class="<?php echo esc_attr( $elemClass ); ?>" id="<?php echo esc_attr( $elemID ); ?>" <?php echo trim($animation['animation-attrs']); ?>
	          data-mapstyle="<?php echo esc_attr($main_style); ?>" data-type="<?php echo esc_attr( $map_type ); ?>" data-zoom="<?php echo esc_attr( $zoom ); ?>" 
	          data-scroll-wheel="<?php echo esc_attr( ($scrollwheel == 'yes') ? 'true' : 'false' ); ?>"
	         data-scale="<?php echo esc_attr( ($scale == 'yes') ? 'true': 'false' ); ?>"  
	         data-zoom-pancontrol="<?php echo esc_attr( ($zoom_pancontrol == 'yes') ? 'true': 'false' ); ?>" style="width:<?php echo esc_attr( $width ); ?>;height:<?php echo esc_attr( $height ); ?>;">
	    	<?php echo wpb_js_remove_wpautop($content, false); ?>
	    </div>
	    <?php
	    $xhtml = ob_get_contents();
	    ob_end_clean();
	
	    return $xhtml;
	}
}
add_shortcode( 'cata_google_maps', 'catanis_google_maps_shortcode_function' );

if( ! function_exists( 'catanis_cata_map_item_shortcode_function' ) ) {
	function catanis_cata_map_item_shortcode_function( $atts, $content = null ) {
		$latitude = $longitude = $marker_image = $marker_title = $marker_description = '';
		extract( shortcode_atts( array(
			'latitude' 				=> '',
			'longitude' 			=> '',
			'marker_image' 			=> '',
			'marker_title' 			=> '',
			'marker_description' 	=> ''
		), $atts ) );
	
		if ($marker_image) {
			$marker = wp_get_attachment_image_src( $marker_image, 'full', true );
			$marker_image = $marker[0];
		} else {
			$marker_image = CATANIS_CORE_URL . "/images/pin.png";
		}
		
		$options = array(
			'marker_image' 			=> $marker_image,
			'marker_title' 			=> esc_attr($marker_title),
			'marker_description' 	=> esc_attr($marker_description),
			'latitude' 				=> esc_attr($latitude),
			'longitude' 			=> esc_attr($longitude)
		);
	
		ob_start(); 
		?>
		<input class="cata-map-location" type="hidden" data-options="<?php echo esc_attr(json_encode($options)); ?>" />
		<?php 
		$xhtml = ob_get_contents();
		ob_end_clean();
		
		return $xhtml;
	}
}
add_shortcode( 'cata_map_item', 'catanis_cata_map_item_shortcode_function' );


/*=== SHORTCODE - INSTAGRAM ==================*/
/*============================================*/
if ( ! function_exists( 'catanis_instagram_shortcode_function' ) ){
	function catanis_instagram_shortcode_function( $atts, $content = null ) {
			
		$xhtml = $main_style = $mode = $username = $number = $columns = $size = $target = $with_padding = $padding_value = $show_name = '';
		$items_desktop = $items_desktop_small = $items_tablet = $slide_arrows = $slide_loop = $slide_dots = $slide_dots_style ='';
		$slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $ext_class = '';
		extract( shortcode_atts( array(
			'main_style' 			=> 'style1',				/*style1, style2*/
			'mode' 					=> 'list',					/*list, slider*/
			'username' 				=> '',
			'size' 					=> 'large',
			'number' 				=> '9',
			'columns' 				=> '3',
			'show_name' 			=> 'yes',					/*NULL, yes*/
			'with_padding' 			=> '',						/*NULL, yes*/
			'padding_value' 		=> '30',					/*10,20,30,40,50*/
			'target' 				=> '_blank',
			
			'items_desktop' 		=> '3',
			'items_desktop_small' 	=> '2',
			'items_tablet' 			=> '1',
			'slide_loop'			=> 'yes',
			'slide_arrows'			=> 'no',
			'slide_dots'			=> 'yes',	
			'slide_dots_style'		=> 'dots-line', 			/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/
			'slide_autoplay'		=> 'no',
			'slide_autoplay_speed'	=> 3000,
			'slides_to_scroll'		=> 3,
			'slides_speed'			=> 500,
			'ext_class' 			=> ''
		), $atts ) );
			
		if ( empty ( $username ) ) {
			return '<p>' . esc_html__( 'Please input username.', 'catanis-core' ) . '</p>';
		}

		if ( !function_exists ( 'catanis_get_instagram' ) ) {
			echo  '<p>'. esc_html__('Please active our plugin "Catanis Core"','catanis-core') .'</p>';
			return false;
		}

		if ( !class_exists('Catanis_Widget_Instagram')  ) {
			echo  '<p>'. esc_html__('The class Catanis_Widget_Instagram don\'t exist.','catanis-core') .'</p>';
			
		}else{
			$animation 	= catanis_shortcodeAnimation($atts);
			$elemID 	= catanis_random_string(10, 'cata_instagram');
			$elemClass 	= 'cata-instagram cata-element cata-' . $main_style;
			$elemClass .= ($mode == 'slider') ? ' cata-slick-slider' : ' cata-list instagram-list';
			$elemClass .= ($with_padding == 'yes') ? ' cata-slider-spacing' . absint($padding_value) : '';
			$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
			$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
			
			$arrParams = array();
			$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
			if ($mode == 'slider') {
				$elemClass .= ($slide_dots == 'yes') ? ' ' . $slide_dots_style : ' dots-none';

				$arrParams = array(
					'autoplay' 			=> ($slide_autoplay == 'yes') ? true : false,
					'autoplaySpeed' 	=> intval($slide_autoplay_speed),
					'slidesToShow' 		=> intval($items_desktop),
					'slidesToScroll' 	=> intval($slides_to_scroll),
					'dots' 				=> ($slide_dots == 'yes')? true : false,
					'arrows' 			=> ($slide_arrows == 'yes')? true : false,
					'infinite' 			=> ($slide_loop == 'yes')? true : false,
					'draggable' 		=> true,
					'speed' 			=> intval($slides_speed),
					'rtl' 				=> CATANIS_RTL,
					'adaptiveHeight' 	=> true,
					'responsive'		=> array(
						array(
							'breakpoint'	=> 1024,
							'settings'		=> array(
								'slidesToShow'		=> intval($items_desktop_small),
								'slidesToScroll' 	=> intval($items_desktop_small)
							)
						),
						array(
							'breakpoint'	=> 768,
							'settings'		=> array(
								'slidesToShow'		=> intval($items_tablet),
								'slidesToScroll' 	=>  intval($items_tablet)
							)
						),
						array(
							'breakpoint'	=> 480,
							'settings'		=> array(
								'slidesToShow'		=> 1,
								'slidesToScroll' 	=> 1
							)
						),
					)
				);

			}
				
			$media_array = catanis_get_instagram( $username );
			if ( is_wp_error( $media_array ) ) {
				echo wp_kses_post( $media_array->get_error_message() );
				return false;
			}
				
			$media_array = array_slice( $media_array, 0, $number );
		
			ob_start();
			?>
			<div<?php echo rtrim($dir); ?> id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
				<?php if ( is_array( $media_array ) && count( $media_array ) > 0 ) : ?>
					<ul class="slides cata-columns-<?php echo esc_attr( $columns ); ?>" data-slick='<?php echo json_encode($arrParams); ?>'>
						<?php 
						
						foreach ( $media_array as $item ) {
							$dimension = $item[$size . '_di'];
							echo '<li class="cata-item '. $item['type'] .'"><a href="' . esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'" title="'. esc_attr( $item['description'] ) .'"><img src="' . esc_url( $item[$size] ) . '" width="'. esc_attr( $dimension['width'] ) .'" height="'. esc_attr( $dimension['height'] ) .'" alt="'. esc_attr( $item['description'] ) .'" /></a></li>';
						}
						?>
					</ul>
				<?php endif; ?>
				
				<?php if ($show_name == 'yes'): ?>
					<a class="insta-name" href="https://www.instagram.com/<?php echo esc_attr( $username ); ?>" target="_blank"><i class="fa fa-instagram"></i><?php echo esc_attr( ucfirst($username) ); ?></a>
				<?php endif; ?>		
			</div>		
		    <?php
		    $xhtml = ob_get_contents();
		    ob_end_clean();
		    return $xhtml;
		}
		
	}
}
add_shortcode( 'cata_instagram', 'catanis_instagram_shortcode_function' );


/*=== SHORTCODE - SOCIALS ====================*/
/*============================================*/
if ( ! function_exists( 'catanis_socials_shortcode_function' ) ){
	function catanis_socials_shortcode_function( $atts, $content = null ) {

		$xhtml = $main_style = $social_networks = $show_tooltip = $size = $align = $w_radius = '';
		$custom_color = $background_color = $icon_color = $ext_class = '';
		$atts = catanis_strip_attr_prefix( $atts );
		extract( shortcode_atts( array(
			'main_style' 		=> 'style1',			/* style1 -> style9 */
			'social_networks' 	=> '',
			'show_tooltip' 		=> 'no',				/* yes, no*/
			'size'				=> 'nm',				/* nm, lg, sm */
			'align'				=> 'left',				/* align-left, align-center, align-right */
			'w_radius'			=> '',					/*1*/
			'custom_color'		=> '',					/*1*/
			'background_color'	=> '#2e2e2e',
			'icon_color'		=> '#FFFFFF',
			'ext_class' 		=> ''
		), $atts ) );

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_socials');
		$elemClass 	= 'cata-socials cata-' . $main_style . ' cata-align-' . $align . ' cata-size-'. $size;

		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= ($w_radius) ? ' cata-w-radius' : '';
		$elemClass .= (!empty($ext_class)) ? ' ' . $ext_class : '';
		$elemClass = str_replace('  ', ' ', trim($elemClass));

		if($custom_color){
			global $catanis;
			$custom_css = '';
				
			$selectID = '#' . $elemID;
				
			if(in_array($main_style, array('style6', 'style10', 'style11', 'style12'))){
				$custom_css .= $selectID . ' li a{ color: '. $icon_color .'; background-color:'.$background_color.';}';
			}
			if(in_array($main_style, array('style8', 'style9'))){
				$custom_css .= $selectID . ' li a{ color: '. $icon_color .';}';
				$custom_css .= $selectID . ' li a:before{ background-color:'.$background_color.';}';
			}
			$catanis->inlinestyle[] = $custom_css;
		}

		$pattern = ( $show_tooltip == 'yes' ) ? ' data-toggle="tooltip" data-placement="top" data-original-title="{TITLE}"' : '';
		if(isset($social_networks) && !empty($social_networks) && function_exists('vc_param_group_parse_atts')) {

			$social_networks = (array) vc_param_group_parse_atts( $social_networks );
			$elemClass .= ' icons-' . count( $social_networks );
			$xhtml .= '<div id="'. esc_attr($elemID) .'" class="'. esc_attr($elemClass) .'" '. trim($animation['animation-attrs']) .'>';
			$xhtml .= '<ul>';
				
			foreach($social_networks as $network) {
				$link_atts = '';
				if(isset($network['item_name']) && isset($network['item_url'])) {

					if(isset($network['item_name'])) {
						$single_icon = $network['item_name'];
					}
					if(isset($network['item_url'])) {
						$link = catanis_parse_multi_attribute($network['item_url']);
					}
					if(isset($link['url']) && !empty($link['url'])) {
						$link_atts .= 'href="'.esc_url($link['url']).'"';
					}
					if(isset($link['target']) && !empty($link['target'])) {
						$link_atts .= ' target="'.esc_attr(trim($link['target'])).'"';
					}
						
					if(isset($link['title']) && !empty($link['title'])) {
						$_title = $link['title'];
						$link_atts .= ' title="'.esc_attr($_title).'"';
						$link_atts .= ' data-hover="'.esc_attr($_title).'"';
					}else{
						$_title = str_replace('fa-', '', $single_icon);
						$_title = str_replace('-', ' ', $_title);
						$_title = ucwords($_title);
					}
						
					$icon_style_html = '<i class="cicon '.esc_attr($single_icon).'"></i>';
					if(isset($main_style) && in_array($main_style, array('style13','style14','style15'))){
						$link_atts .= ' title="'. esc_attr(ucwords($_title)) .'"';
						$link_atts .= ' data-hover="'. esc_attr(ucwords($_title)) .'"';

						$icon_style_html .= '<em>' . esc_attr($_title) . '</em>';
					}
						
					if(isset($main_style) && strcmp($main_style, 'style1') === 0) {
						$icon_style_html .= '<span class="line-top-left"></span><span class="line-top-center"></span><span class="line-top-right"></span><span class="line-bottom-left"></span><span class="line-bottom-center"></span><span class="line-bottom-right"></span>';
					}
						
					if($show_tooltip == 'yes'){
						$xhtml .= '<li class="'. esc_attr(str_replace('fa-', 'icon-', $single_icon)) .'"'.str_replace( '{TITLE}', esc_attr( $_title ), $pattern ).'><a '.$link_atts .'>'.$icon_style_html.'</a></li>';
					}else{
						$xhtml .= '<li class="'. esc_attr(str_replace('fa-', 'icon-', $single_icon)) .'"><a '.$link_atts .'>'.$icon_style_html.'</a></li>';
					}
						
				}
			}

			$xhtml .= '</ul>';
			$xhtml .= '</div>';
		}

		return $xhtml;
	}
}
add_shortcode('cata_socials', 'catanis_socials_shortcode_function');


/*=== SHORTCODE - BUTTON =====================*/
/*============================================*/
if ( ! function_exists( 'catanis_button_shortcode_button' ) ) {
	function catanis_button_shortcode_button( $atts, $content = null ) {

		$main_style = $button_text = $tooltip_text = $link = $button_image = $image_width = $shape = $size = $align = '';
		$button_color = $text_color = $button_color_hover = $text_color_hover = $add_icon = $i_align = $icon = $custom_i_color = $i_color = $i_color_hover = '';
		$gradient_style = $gradient_custom_color_1 = $gradient_custom_color_2 = $gradient_text_color = '';
		$outline_custom_color = $outline_custom_hover_bg = $outline_custom_hover_text = $ext_class = '';
		$margin_top = $margin_right = $margin_bottom = $margin_left = '';
		extract( shortcode_atts( array(
			'main_style' 		=> 'flat',				/* modern, classic, flat, 3d, shadow, outline, gradient, gradient-border, image */
			'button_text' 		=> esc_html__( 'BUTTON', 'catanis-core' ),
			'tooltip_text' 		=> '',
			'link' 				=> '',
			'button_image' 		=> '',
			'image_width' 		=> '',
			'shape' 			=> 'rounded', 			/* rounded, square, round */
			'size' 				=> 'nm', 				/* lg, md, nm, sm, mini */
			'align' 			=> 'inline',			/* inline, block, left, right, center */
			'button_color' 			=> '#e49497',
			'text_color' 			=> '#FFFFFF',
			'button_color_hover' 	=> '#dfa1a3',
			'text_color_hover' 		=> '#FFFFFF',
			'add_icon' 				=> '',					/* 1 */
			'i_align' 				=> 'left',				/* left, right */
			'icon' 					=> 'ti-check-box',
			'custom_i_color' 		=> '',					/* 1 */
			'i_color' 				=> '',
			'i_color_hover' 		=> '',
			'gradient_style' 			=> 'gradient-leftright',
			'gradient_custom_color_1' 	=> '#dd3333',
			'gradient_custom_color_2' 	=> '#eeee22',
			'gradient_text_color' 		=> '#FFFFFF',
			'outline_custom_color' 		=> '#e49497',
			'outline_custom_hover_bg' 	=> '#e49497',
			'outline_custom_hover_text' => '#FFFFFF',
			'margin_top' 				=> '',
			'margin_right' 				=> '',
			'margin_bottom' 			=> '',
			'margin_left' 				=> '',
			'ext_class'					=> ''
		), $atts ) );

		$arrParams 	= array();
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_button');
		$elemClass 	= 'cata-button cata-btn-' . esc_attr( $align );
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$elemClass 	= str_replace('  ', ' ', trim($elemClass));
		
		$elemClassContain 	= 'cata-btn cata-btn-style-' . $main_style;
		$elemClassContain .= ( '' !== $shape )? ' cata-btn-shape-' . $shape : '';
		$elemClassContain .= ( '' !== $size ) ? ' cata-btn-size-' . $size : '';
		$elemClassContain .= ( empty($button_text) ) ? ' icon-only' : '';
		
		$elemClassContain 	= str_replace('  ', ' ', trim($elemClassContain));

		/* Custom Style */
		global $catanis;
		$custom_css = '';

		$elemStyle 	= '';
		$selectID = '#' . $elemID . '.cata-button';
		
		$elemStyle 	.= ( $margin_top != '' ) ? ' margin-top:'. $margin_top .';' : '';
		$elemStyle 	.= ( $margin_right != '' ) ? ' margin-right:'. $margin_right .';' : '';
		$elemStyle 	.= ( $margin_bottom != '' ) ? ' margin-bottom:'. $margin_bottom .';' : '';
		$elemStyle 	.= ( $margin_left != '' ) ? ' margin-left:'. $margin_left .';' : '';
		$custom_css .= $selectID . '{' . $elemStyle . '}';
		
		if($main_style == 'outline'){
			$custom_css .= $selectID . ' .cata-btn{color: '. $outline_custom_color .';border-color:'. $outline_custom_color .'}';
			$custom_css .= $selectID . ' .cata-btn:hover{color: '. $outline_custom_hover_text .';border-color:'. $outline_custom_hover_bg .'; background-color:'. $outline_custom_hover_bg .'}';
				
		}elseif($main_style == 'gradient'){
			$elemClassContain .= ' ' . $gradient_style;
			if($gradient_style == 'gradient-topbottom'){

				$custom_css .= $selectID . ' .cata-btn{
					background-image: -webkit-linear-gradient(top, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 50%,'. $gradient_custom_color_1 .' 100%);
					background-image: linear-gradient(to bottom, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 50%,'. $gradient_custom_color_1 .' 100%);
				}';
					
			}elseif($gradient_style == 'gradient-leftright'){
				$custom_css .= $selectID . ' .cata-btn{
					background-image: -webkit-linear-gradient(left, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 50%,'. $gradient_custom_color_1 .' 100%);
					background-image: linear-gradient(to right, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 50%,'. $gradient_custom_color_1 .' 100%);
				}';
					
			}else{
				$custom_css .= $selectID . ' .cata-btn{
					background-image: -webkit-linear-gradient(top left, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 60%,'. $gradient_custom_color_1 .' 100%);
					background-image: linear-gradient(to bottom right, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 60%,'. $gradient_custom_color_1 .' 100%);
				}';
					
			}
				
		}elseif($main_style == 'gradient-border'){
			$elemClassContain .= ' ' . $gradient_style;
				
			if($gradient_style == 'gradient-topbottom'){
				$custom_css .= $selectID . ' .cata-btn{
					border: 2px solid transparent;
					-moz-border-image: -moz-linear-gradient(top, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 100%);
					-webkit-border-image: -webkit-linear-gradient(top, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 100%);
					border-image: linear-gradient(to bottom, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 100%);
					border-image-slice: 1; color: '. $gradient_text_color .';
				}';

			}elseif($gradient_style == 'gradient-leftright'){
				$custom_css .= $selectID . ' .cata-btn{
					border: 2px solid transparent;
					-moz-border-image: -moz-linear-gradient(left, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 100%);
					-webkit-border-image: -webkit-linear-gradient(left, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 100%);
					border-image: linear-gradient(to right, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 100%);
					border-image-slice: 1; color: '. $gradient_text_color .';
				}';

			}else{
				$custom_css .= $selectID . ' .cata-btn{
					border: 2px solid transparent;
					-moz-border-image: -moz-linear-gradient(top left, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 100%);
					-webkit-border-image: -webkit-linear-gradient(top left, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 100%);
					border-image: linear-gradient(to bottom right, '. $gradient_custom_color_1 .' 0%, '. $gradient_custom_color_2 .' 100%);
					border-image-slice: 1; color: '. $gradient_text_color .';
				}';

			}

		}elseif($main_style == '3d'){

			$color_shadow = catanis_colour_creator($button_color, -12);
			$color_shadow_hover = catanis_colour_creator($button_color_hover, -12);
				
			$custom_css .= $selectID . ' .cata-btn{color: '. $text_color .';box-shadow:0 5px 0 '. $color_shadow .'; background-color:'. $button_color .'}';
			$custom_css .= $selectID . ' .cata-btn:hover{color: '. $text_color_hover .';box-shadow:0 2px 0 '. $color_shadow_hover .'; background-color:'. $button_color_hover .'}';
				
		}elseif($main_style == 'modern'){
			$custom_css .= $selectID . ' .cata-btn{color: '. $text_color .';border-color:'. $button_color .'; background-color:'. $button_color .'}';
			$custom_css .= $selectID . ' .cata-btn:hover{color: '. $text_color_hover .';border-color:'. $button_color_hover .'; background-color:'. $button_color_hover .'}';
				
		}elseif($main_style == 'classic'){
			$custom_css .= $selectID . ' .cata-btn{color: '. $text_color .'; background-color:'. $button_color .'}';
			$custom_css .= $selectID . ' .cata-btn:hover{color: '. $text_color_hover .'; background-color:'. $button_color_hover .'}';
				
		}elseif($main_style == 'flat' || $main_style == 'shadow'){
				
			$custom_css .= $selectID . ' .cata-btn{color: '. $text_color .'; background-color:'. $button_color .'}';
			$custom_css .= $selectID . ' .cata-btn:hover{color: '. $text_color_hover .'; background-color:'. $button_color_hover .'}';
		}

		if($add_icon && $custom_i_color){
			$custom_css .= $selectID . ' .cata-btn .cicon{color: '. $i_color .';}';
				
			if(!empty($i_color_hover)){
				$custom_css .= $selectID . ' .cata-btn:hover .cicon{color: '. $i_color_hover .';}';
			}
		}

		$catanis->inlinestyle[] = $custom_css;

		/* Parse link */
		$link 		= ( '||' === $link ) ? '' : $link;
		$link 		= catanis_parse_multi_attribute( $link, array( 'url' => '', 'title' => '', 'target' => '', 'rel' => '' ) );
		
		$a_href 	= trim( $link['url']);
		$a_title 	= trim( $link['title']);
		$a_target 	= trim( $link['target'] );
		$a_rel 		= trim( $link['rel']);

		if(!empty($button_text)){
			$a_title = $button_text;
		}

		/* Button Attribute */
		$elemClassContain .= ($add_icon) ? ' icon-' . $i_align : '';
		$attrContainer = 'class="' . $elemClassContain . '"';
		$attrContainer .= ( ! empty ( $a_href ) ) ? ' href="' . $a_href .'"' : ' href="javascript:;"';
		$attrContainer .= ( ! empty ( $a_rel ) ) ? ' rel="' . $a_rel .'"' : '';
		$attrContainer .= ( ! empty ( $a_target ) ) ? ' target="' . $a_target .'"' : '';

		if(!empty($tooltip_text)){
			$attrContainer .= ' title="' . $tooltip_text .'" data-toggle="tooltip" data-placement="top" data-original-title="' . $tooltip_text .'"';
		}else{
			$attrContainer .= ' title="' . $a_title .'"';
		}

		if($main_style == 'image' && !empty($image_width)){
			$attrContainer .= ' style="width:' . $image_width .'px;"';
		}

		/* Button Output HTML */
		$xhtml = '<div id="'. $elemID .'" class="'. $elemClass .'" '. trim($animation['animation-attrs']) .'><a '. $attrContainer .'>';
		if($main_style == 'image'){
			$button_image = wp_get_attachment_image_url( $button_image, 'full') ;
			$xhtml .= '<img src="' . $button_image .'" alt="' . $a_title .'"/>';
				
		}else{
			if($add_icon){
				$cicon = '<span class="cicon ' . $icon . '"></span>';
				$xhtml .= ($i_align == 'left') ? ($cicon . $a_title) : ($a_title . $cicon);
			}else{
				$xhtml .= $a_title;
			}
		}
		$xhtml .= '</a></div>';

		return $xhtml;
	}
}
add_shortcode( 'cata_button', 'catanis_button_shortcode_button' );


/*=== SHORTCODE - LINK BUTTON ================*/
/*============================================*/
if ( ! function_exists( 'catanis_button_link_shortcode_button' ) ) {
	function catanis_button_link_shortcode_button( $atts, $content = null ) {

		$main_style = $link_text = $tooltip_text = $link = $align = $border_style = $border_width = '';
		$border_color = $text_color = $boder_color_hover = $text_color_hover = $add_icon = $i_align = $icon = '';
		$custom_i_color = $i_color = $i_color_hover = $margin_top = $margin_right = $margin_bottom = $margin_left = $ext_class = '';
		extract( shortcode_atts( array(
			'main_style' 			=> 'border-bottom',		/*  */
			'link_text' 			=> esc_html__( 'Link Title', 'catanis-core' ),
			'tooltip_text' 			=> '',
			'link' 					=> '',
			'align' 				=> 'inline',			/* inline, block, left, right, center */
			'border_style' 			=> 'dashed',		/* dashed, dotted, double, solid*/
			'border_width' 			=> '1px',
			'border_color' 			=> '#e49497',
			'text_color' 			=> '#1A1A1A',
			'boder_color_hover' 	=> '#dfa1a3',
			'text_color_hover' 		=> '#1A1A1A',
			'add_icon' 				=> '',					/* 1 */
			'i_align' 				=> 'left',				/* left, right */
			'icon' 					=> 'ti-check-box',
			'custom_i_color' 		=> '',					/* 1 */
			'i_color' 				=> '',
			'i_color_hover' 		=> '',
			'margin_top' 			=> '',
			'margin_right' 			=> '',
			'margin_bottom' 		=> '',
			'margin_left' 			=> '',
			'ext_class'				=> ''
		), $atts ) );

		$arrParams 	= array();
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_button_link');
		$elemClass 	= 'cata-button cata-btn-link cata-btn-' . esc_attr( $align );
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$elemClass 	= str_replace('  ', ' ', trim($elemClass));

		$elemClassContain 	= 'cata-link cata-style-' . $main_style;
		$elemClassContain .= ( empty($link_text) ) ? ' icon-only' : '';
		$elemClassContain 	= str_replace('  ', ' ', trim($elemClassContain));

		/* Custom Style */
		global $catanis;
		$custom_css = '';

		$elemStyle 	= '';
		$selectID = '#' . $elemID;

		$elemStyle 	.= ( $margin_top != '' ) ? ' margin-top:'. $margin_top .';' : '';
		$elemStyle 	.= ( $margin_right != '' ) ? ' margin-right:'. $margin_right .';' : '';
		$elemStyle 	.= ( $margin_bottom != '' ) ? ' margin-bottom:'. $margin_bottom .';' : '';
		$elemStyle 	.= ( $margin_left != '' ) ? ' margin-left:'. $margin_left .';' : '';
		$custom_css .= $selectID . '{' . $elemStyle . '}';
		
		if($main_style == 'border-bottom'){
			$custom_css .= $selectID . ' .cata-link{border-bottom-style: '. $border_style .';border-bottom-width: '. $border_width .'; border-bottom-color:'. $border_color .'; color: '. $text_color .'}';
			$custom_css .= $selectID . ' .cata-link:hover{color: '. $text_color_hover .';border-color:'. $boder_color_hover .';}';
		}
		
		if($add_icon && $custom_i_color){
			$custom_css .= $selectID . ' .cata-link .cicon{color: '. $i_color .';}';

			if(!empty($i_color_hover)){
				$custom_css .= $selectID . ' .cata-btn:hover .cicon{color: '. $i_color_hover .';}';
			}
		}

		$catanis->inlinestyle[] = $custom_css;

		/* Parse link */
		$link 		= ( '||' === $link ) ? '' : $link;
		$link 		= catanis_parse_multi_attribute( $link, array( 'url' => '', 'title' => '', 'target' => '', 'rel' => '' ) );

		$a_href 	= trim( $link['url']);
		$a_title 	= trim( $link['title']);
		$a_target 	= trim( $link['target'] );
		$a_rel 		= trim( $link['rel']);

		if(!empty($link_text)){
			$a_title = $link_text;
		}

		/* Button Attribute */
		$elemClassContain .= ($add_icon) ? ' icon-' . $i_align : '';
		$attrContainer = 'class="' . $elemClassContain . '"';
		$attrContainer .= ( ! empty ( $a_href ) ) ? ' href="' . $a_href .'"' : ' href="javascript:;"';
		$attrContainer .= ( ! empty ( $a_rel ) ) ? ' rel="' . $a_rel .'"' : '';
		$attrContainer .= ( ! empty ( $a_target ) ) ? ' target="' . $a_target .'"' : '';

		if(!empty($tooltip_text)){
			$attrContainer .= ' title="' . $tooltip_text .'" data-toggle="tooltip" data-placement="top" data-original-title="' . $tooltip_text .'"';
		}else{
			$attrContainer .= ' title="' . $a_title .'"';
		}

		/* Button Output HTML */
		$xhtml = '<div id="'. $elemID .'" class="'. $elemClass .'" '. trim($animation['animation-attrs']) .'><a '. $attrContainer .'>';
		if($add_icon){
			$cicon = '<span class="cicon ' . $icon . '"></span>';
			$xhtml .= ($i_align == 'left') ? ($cicon . $a_title) : ($a_title . $cicon);
		}else{
			$xhtml .= $a_title;
		}
		$xhtml .= '</a></div>';

		return $xhtml;
	}
}
add_shortcode( 'cata_button_link', 'catanis_button_link_shortcode_button' );


/*=== SHORTCODE - TWITTER ====================*/
/*============================================*/
if ( ! function_exists( 'catanis_twitter_shortcode_function' ) ) {
	function catanis_twitter_shortcode_function( $atts, $content ) {

		$xhtml = $main_style = $mode = $username = $number = $columns = $with_padding = $padding_value = $icon_color = $text_color_style = $clear_cache = '';
		$items_desktop = $items_desktop_small = $items_tablet = $slide_arrows = $slide_loop = $slide_dots = $slide_dots_style ='';
		$slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $ext_class = '';
		
		extract( shortcode_atts( array(
			'main_style' 			=> 'style1',				/*style1, style2*/
			'mode' 					=> 'list',					/*list, slider*/
			'username' 				=> '',
			'number' 				=> '9',
			'columns' 				=> '3',
			'with_padding' 			=> '',						/*NULL, yes*/
			'padding_value' 		=> '30',					/*10,20,30,40,50*/
			'icon_color' 			=> '#e49497',
			'text_color_style' 		=> '',						/*NULL,text-light*/
			'clear_cache' 			=> '',						/*NULL, yes*/
			
			'items_desktop' 		=> '3',
			'items_desktop_small' 	=> '3',
			'items_tablet' 			=> '2',
			'slide_loop'			=> 'yes',
			'slide_arrows'			=> 'no',
			'slide_dots'			=> 'yes',
			'slide_dots_style'		=> 'dots-line', 		/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/
			'slide_autoplay'		=> 'no',
			'slide_autoplay_speed'	=> 3000,
			'slides_to_scroll'		=> 3,
			'slides_speed'			=> 500,
			'ext_class' 			=> ''
		), $atts ) );

		if ( empty ( $username ) ) {
			return '<p>' . esc_html__( 'Please input username twitter.', 'catanis-core' ) . '</p>';
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_twitter');
		$elemClass 	= 'cata-twitter cata-element cata-' . $main_style;
		$elemClass .= ($mode == 'slider') ? ' cata-slick-slider' : ' cata-list cata-twitter-list';
		$elemClass .= ($with_padding == 'yes') ? ' cata-slider-spacing' . absint($padding_value) : '';
		$elemClass .= (!empty($text_color_style)) ? ' cata-' . $text_color_style : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		$arrParams = array();
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		if ($mode == 'slider') {
			$elemClass .= ($slide_dots == 'yes') ? ' ' . $slide_dots_style : ' dots-none';
		
			$arrParams = array(
				'autoplay' 			=> ($slide_autoplay == 'yes') ? true : false,
				'autoplaySpeed' 	=> intval($slide_autoplay_speed),
				'slidesToShow' 		=> intval($items_desktop),
				'slidesToScroll' 	=> intval($slides_to_scroll),
				'dots' 				=> ($slide_dots == 'yes')? true : false,
				'arrows' 			=> ($slide_arrows == 'yes')? true : false,
				'infinite' 			=> ($slide_loop == 'yes')? true : false,
				'draggable' 		=> true,
				'speed' 			=> intval($slides_speed),
				'rtl' 				=> CATANIS_RTL,
				'adaptiveHeight' 	=> true,
				'responsive'		=> array(
					array(
						'breakpoint'	=> 1024,
						'settings'		=> array(
							'slidesToShow'		=> intval($items_desktop_small),
							'slidesToScroll' 	=> intval($items_desktop_small)
						)
					),
					array(
						'breakpoint'	=> 768,
						'settings'		=> array(
							'slidesToShow'		=> intval($items_tablet),
							'slidesToScroll' 	=>  intval($items_tablet)
						)
					),
					array(
						'breakpoint'	=> 480,
						'settings'		=> array(
							'slidesToShow'		=> 1,
							'slidesToScroll' 	=> 1
						)
					),
				)
			);

			if($items_desktop == 1 && $items_desktop_small == 1 && $items_tablet == 1){
				$arrParams['fade'] = true;
				$arrParams['cssEase'] = 'linear';
			}
		}
		
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID .'.cata-twitter ';
		$custom_css .= $selectID . ' .cata-item .cicon{color: '. $icon_color .';}';
		$catanis->inlinestyle[] = $custom_css;

		$transient_key = 'cata_twitter_' . $username . '_c' . $number;
		$cache = get_transient($transient_key);
		if($cache === false || $clear_cache == 'yes') {
			$tweets = catanis_get_tweets($username, $number);
			set_transient($transient_key, $tweets, 12 * HOUR_IN_SECONDS);
		}else{
			$tweets = $cache;
		}
		
		ob_start();
		if ($tweets != '' && is_array($tweets) ) {
		?>
			<div<?php echo rtrim($dir); ?> id="<?php echo $elemID; ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
				<?php if ($mode == 'slider'): ?>
					<div class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
				<?php else: ?>
					<div class="slides">
						<span class="cicon ti-twitter-alt"></span> 
				<?php endif; ?>
				
				<?php foreach ( $tweets as $tweet ) : ?>
					<div class="cata-item">
						<?php if ( $mode == 'slider'):?><span class="cicon ti-twitter-alt"></span> <?php endif; ?>
						<div class="tweet-content">
							<?php echo trim($tweet['text']); ?>
							<div class="author-datetime">
								<a href="<?php echo esc_url('http://twitter.com/' . $tweet['name']); ?>" target="_blank">
									by @<?php echo esc_html($tweet['name']); ?>
								</a>
								<span><?php echo human_time_diff($tweet['time'], current_time('timestamp')) . ' ' . esc_html__('ago', 'catanis-core'); ?></span>
							</div>
						</div>
					</div>
				<?php endforeach;?>
				</div>
			</div>
			<?php
			$xhtml = ob_get_contents();
			ob_end_clean();
			return $xhtml;
		}
		
	}
}
add_shortcode( 'cata_twitter', 'catanis_twitter_shortcode_function' );


/*=== SHORTCODE - FEEDBURNER =================*/
/*============================================*/
if ( ! function_exists( 'catanis_feedburner_shortcode_function' ) ) {
	function catanis_feedburner_shortcode_function( $atts, $content = null ) {
		
		$title = $intro_text = $feedburner_id = $main_style = $background = $button_text = $ext_class = '';
		extract( shortcode_atts( array(
			'intro_text'		=> '',
			'feedburner_id'		=> '',
			'main_style'		=> 'simple',
			'background'		=> '',
			'button_text'		=> '',
			'ext_class' 		=> ''
		), $atts ) );
		
		$bgimage = '';
		if($main_style == 'background' && !empty($background)){
			$bgimage = wp_get_attachment_image_src( $background, 'full' );
			$bgimage = $bgimage[0];
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemClass 	= 'cata-widget-subscriptions cata-feedburner cata-element';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		ob_start();
		the_widget( 'Catanis_Widget_Subscriptions',
			array('title' => '', 'intro_text' => $intro_text, 'feedburner_id'=> $feedburner_id, 'style' => $main_style, 'background' => $bgimage, 'button_text' => $button_text),
			array('before_widget' => '<div class="'. esc_attr($elemClass) .'" '. trim($animation['animation-attrs']) .' >', 'after_wiget' => '</div>')
		);
		$xhtml = ob_get_contents();
		ob_end_clean();
		
		return $xhtml;
	}
}
add_shortcode( 'cata_feedburner', 'catanis_feedburner_shortcode_function' );


/*=== SHORTCODE - VIDEO BACKGROUND ===========*/
/*============================================*/
if ( ! function_exists( 'catanis_videobg_shortcode_function' ) ) {
	function catanis_videobg_shortcode_function( $atts, $content = null ) {
		
		$xhtml = $video_title = $video_excerpt = $bg_type = $text_color = '';
		$video_url_youtube = $video_url_vimeo = $video_url_mp4 = $video_url_webm = $video_url_ogg = '';
		$video_poster = $show_video_control = $video_opts = $ext_class = '';
		
		extract( shortcode_atts( array(
			'video_title'      		 	=> '',
			'video_excerpt'    			=> '',
			'bg_type'  					=> 'no_bg',						/*no_bg, color, image, youtube, vimeo, self*/
			'text_color' 				=> 'light',						/*text-light,text-dark*/
			'video_url_youtube' 		=> '',
			'video_url_vimeo' 			=> '',
			'video_url_mp4' 			=> '',
			'video_url_webm' 			=> '',
			'video_url_ogg' 			=> '',
			'video_poster' 				=> '',
			'show_video_control' 		=> 'show-video-control',		/*no-video-control,show-video-control*/
			'video_opts' 				=> '',							/*multi checkbox: autoplay, loop, muted*/
			'ext_class' 				=> '',
		), $atts ) );
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_videobg');
		$elemClass 	= 'cata-videobg cata-element cata-section-video cata-' . $text_color . ' ' . $show_video_control;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		$outputVideo = '';
		$dataSetup = array();
		$elemAttribute = array();
		
		$sources = '';
		$video_opts = explode(',', $video_opts);
			
		if(is_numeric($video_poster)){
			$video_poster =  wp_get_attachment_url( $video_poster ) ;
			$poster = (false == $video_poster)? CATANIS_DEFAULT_IMAGE : $video_poster;
			$dataSetup['poster'] = esc_url($video_poster);
		}
			
		wp_enqueue_script('catanis-js-videojs');
		if($bg_type == 'self') {
			if($video_url_mp4!='') {
				$sources .= '<source src="'.esc_url($video_url_mp4).'" type="video/mp4">';
			}
				
			if($video_url_webm!='') {
				$sources .= '<source src="'.esc_url($video_url_webm).'" type="video/webm">';
			}
				
			if($video_url_ogg!='') {
				$sources .= '<source src="'.esc_url($video_url_ogg).'" type="video/ogg">';
			}
				
		}elseif($bg_type == 'youtube'){
			wp_enqueue_script('catanis-js-videojs-youtube');
			$dataSetup['techOrder'] = array('youtube');
			$dataSetup['sources'] = array(array(
				'type' 	=> 'video/youtube',
				'src' 	=> esc_url($video_url_youtube)
			));
				
		}elseif($bg_type == 'vimeo'){
			wp_enqueue_script('catanis-js-videojs-vimeo');
				
			$dataSetup['techOrder'] = array('vimeo');
			$dataSetup['sources'] = array(array(
				'type' 	=> 'video/vimeo',
				'src' 	=> esc_url($video_url_vimeo)
			));
		}
			
		if(is_array($video_opts)){
			if(in_array('muted', $video_opts)){
				$bg_type .= ' muted';
				$dataSetup['muted'] = true;
			}
	
			if(in_array('loop', $video_opts)){
				$dataSetup['loop'] = true;
			}
		}
			
		if( (is_array($video_opts) && in_array('autoplay', $video_opts)) || $show_video_control == 'no-video-control' ){
			$dataSetup['autoplay'] = true;
			$bg_type .= ' autoplay';
		}
			
		if(isset($dataSetup['autoplay']) && $dataSetup['autoplay'] == true){
			$bg_type .= ' playing';
		}else{
			$bg_type .= ' pausing';
		}
		
		$elemClass .= ( empty( $video_excerpt ) || empty( $video_title ) ) ? ' cata-no-title' : '';
			
		$elemID = catanis_random_string(10, 'video');
		$outputVideo .= '<div id="'.$elemID.'" class="cata-section-video-bg video-host-'. $bg_type .'"><div class="video-control"></div><div class="wrap-cata-video">';
		$outputVideo .= '<video id="s'. $elemID .'" name="sc_video" data-setup='. json_encode($dataSetup) .' class="video-js vjs-default-skin">'. $sources .'<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p></video>';
		$outputVideo .= '</div></div>';
		
		$xhtml .= '<div class="cata-section-video '. esc_attr($elemClass) .'" ' . implode( ' ', $elemAttribute ) . ' '. trim($animation['animation-attrs']) .'>';
			$xhtml .=  $outputVideo;
			$xhtml .= '<div class="cata-video-content-wrap">';
				$xhtml .= '<div class="video-title-wrap">';
				if ( ! empty( $video_excerpt ) || ! empty( $video_title ) ):
					$xhtml .= '<h3 class="cata-video-title">'. esc_html($video_title) .'</h3>';
					if ( ! empty( $video_excerpt ) ):
						$xhtml .= '<h6 class="cata-video-excerpt">'. esc_html($video_excerpt) .'</h6>';
					endif; 
				endif;
				$xhtml .= '</div>';
			$xhtml .= '</div>';
			
		$xhtml .= '</div>';
	    
	    return $xhtml;
	}
}
add_shortcode( 'cata_videobg', 'catanis_videobg_shortcode_function' );


/*=== SHORTCODE - MESSAGE BOX ================*/
/*============================================*/
if ( ! function_exists( 'catanis_messagebox_shortcode_function' ) ) {
	function catanis_messagebox_shortcode_function( $atts, $content = null ) {

		$main_style = $message_type = $title = $icon = $cicon = $main_color = $bg_color = $text_color = '';
		$click_to_close = $button_text = $button_link = $target_link = $custom_icon = $ext_class = '';
		extract( shortcode_atts( array(
			'main_style' 		=> 'style1',
			'message_type' 		=> 'info', 	/*informational, success, warning, error, custom*/
			'title' 			=> '',
			'click_to_close' 	=> '',
			'custom_icon' 		=> '',
			'icon' 				=> 'ti-info-alt',
			'main_color' 		=> '#2cce94',
			'bg_color' 			=> '#FFFFFF',
			'text_color' 		=> '#5a5a5a',
			'button_text' 		=> '',
			'button_link'  		=> '',
			'target_link'  		=> '_blank',
			'ext_class'			=> ''
		), $atts ) );

		if ( empty( $content ) ) {
			return '';
		}

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID = catanis_random_string(10, 'alert_message');
		$elemClass = 'cata-message cata-' . $main_style . ' msg-' . $message_type;
		$elemClass .= ($click_to_close) ? ' click-to-close' : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$elemClass = str_replace('  ', ' ', trim($elemClass));

		switch($message_type){
			case 'info': $cicon = 'ti-info-alt'; break;
			case 'success': $cicon = 'ti-check-box'; break;
			case 'warning': $cicon = 'ti-alert'; break;
			case 'error': $cicon = 'ti-close'; break;
		}

		if($main_style == 'style3' || ($main_style == 'style5' && $message_type == 'error') ){
			$cicon = 'ti-alert';
		}
		if($custom_icon){
			$cicon = $icon;
		}

		if($message_type == 'custom'){

			global $catanis;
			$custom_css = '';

			$selectID = '#' . $elemID .'.cata-message.cata-' . $main_style .'.msg-custom ';
			if($main_style == 'style2'){
				$custom_css .= $selectID . '{border-color: '. $main_color .';background-color: '. $bg_color .'; color: '. $text_color .';}';
				$custom_css .= $selectID . '.cclose{color: '. $main_color .';}';
				$custom_css .= $selectID . '.ccontent .tbolb{color: '. $main_color .';}';
			}
				
			if($main_style == 'style6'){
				$custom_css .= $selectID . '{border-color: '. $main_color .';background-color: '. $bg_color .';color: '. $text_color .';}';
				$custom_css .= $selectID . '.cclose{border-color: '. $main_color .';}';
				$custom_css .= $selectID . '.cicon{color: '. $main_color .';}';
			}
				
			if($main_style == 'style4'){
				$custom_css .= $selectID . '{border-color: '. $main_color .';background-color: '. $bg_color .';color: '. $text_color .';}';
				$custom_css .= $selectID . '.cicon{border-color: '. $main_color .';}';
				$custom_css .= $selectID . '.ccontent .tbolb{color: '. $main_color .';}';
			}
				
			if($main_style == 'style1'){
				$custom_css .= $selectID . '{border-color: '. $main_color .';background-color: '. $bg_color .';color: '. $text_color .';}';
				$custom_css .= $selectID . '.cicon{background-color: '. $main_color .';}';
				$custom_css .= $selectID . '.ccontent .cclose{color: '. $main_color .';}';
				$custom_css .= $selectID . '.ccontent .tbolb{color: '. $main_color .';}';
			}
			$catanis->inlinestyle[] = $custom_css;

		}

		$xhtml  = '';
		$button_link 	= ( ! empty ( $button_link ) ) ? esc_url( $button_link ) : 'javascript:;' ;
		ob_start();
		?>
			<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>> 
				<?php if($main_style == 'style1' || $main_style == 'style4'): ?>
					<div class="cicon"><span class=" <?php echo esc_attr( $cicon); ?>"></span></div>
					<p class="ccontent"><strong class="tbolb"><?php echo esc_html($title); ?></strong><?php echo esc_attr( $content ); ?></p>
					<div class="cclose"><span class="ti-close"></span></div>
					
				<?php elseif($main_style == 'style2'): ?>
					<p class="ccontent"><strong class="tbolb"><?php echo esc_html($title); ?></strong><?php echo esc_attr( $content ); ?></p>
					<div class="cclose"><span class="ti-close"></span></div>
				
				<?php elseif($main_style == 'style3' || $main_style == 'style5'): ?>
					<div class="cicon"><span class=" <?php echo esc_attr( $cicon); ?>"></span></div>
					<p class="ccontent"><strong class="tbolb"><?php echo esc_html($title); ?></strong><?php echo esc_attr( $content ); ?></p>
					<div class="cclose"><span class="ti-close"></span></div>
					<?php if ( ! empty ( $button_text ) ): ?>
					<a href="<?php echo esc_url( $button_link ); ?>" class="cata-button stype-simple" target="<?php echo esc_attr($target_link); ?>" title="<?php echo esc_attr($button_text); ?>">
						<?php echo $button_text; ?>
					</a>
					<?php endif; ?>
				
				<?php elseif($main_style == 'style6'): ?>
					<div class="cicon"><span class=" <?php echo esc_attr( $cicon); ?>"></span><strong class="tbolb"><?php echo esc_html($title); ?></strong></div>
					<p class="ccontent"><?php echo esc_attr( $content ); ?></p>
					<div class="cclose"><span class="ti-close"></span></div>
					
				<?php endif; ?>
				
			</div>
		<?php 
		$xhtml = ob_get_contents();
	    ob_end_clean();
	
	    return $xhtml;

	}
}
add_shortcode( 'cata_messagebox', 'catanis_messagebox_shortcode_function' );


/*=== SHORTCODE - SINGLE IMAGE ===============*/
/*============================================*/
if ( ! function_exists( 'catanis_single_image_shortcode_function' ) ) {
	function catanis_single_image_shortcode_function( $atts, $content = null ) {

		$xhtml = $image = $img_size = $img_align = $hover_effect = '';
		$add_caption = $img_caption = $onclick = $link = $target_link = $ext_class = '';
		extract( shortcode_atts( array(
			'image' 		=> '',
			'img_size' 		=> 'full',
			'img_align' 	=> 'img-left',		/* img-left, img-right, img-center*/
			'hover_effect' 	=> '',
			'onclick' 		=> '',				/*prettyphoto, custom_link*/
			'link' 			=> '',
			'target_link' 	=> '_blank',
			'ext_class' 	=> ''
		), $atts ) );

		if( empty( $image ) ){
			return esc_html('Please choose a image.', 'catanis-core');
		}

		if(is_numeric($image)){
			$img = wpb_getImageBySize( array(
				'attach_id' => $image,
				'thumb_size' => $img_size,
				'class' => 'cata-image-img',
			) );
			
			$img_thumbnail = $img['thumbnail'];
			$img_large = $img['p_img_large'][0];
		}else{
			$img_thumbnail = '<img src="'. esc_url($image) .'" alt="" />';
			$img_large = $image;
		}

		$html_append = '';
		if(in_array($hover_effect, array('effect-inner-shadow', 'effect-inner-shadow-2', 'effect-border'))){
			$html_append = '<div class="layer"></div>';

		}elseif(in_array($hover_effect, array('effect-mask'))){
			$html_append .= '<div class="mask1"></div><div class="mask2"></div>';
			
		}else{
			if(in_array($hover_effect, array('effect-sparkle', 'effect-rain', 'effect-glass', 'effect-snow'))){
				$html_append .= '<span class="cata-effect cata-'. $hover_effect .'"></span>';
			}
		}
		
		$a_attrs = array();
		$link_output = $img_thumbnail . $html_append;
		if ( $onclick ) {

			if($onclick == 'custom_link'){
				$a_attrs['href'] = $link;
				$a_attrs['target'] = $target_link;
				$a_attrs['class'] = 'custom-link';
			}else{
				$a_attrs['href'] = $img_large;
				$a_attrs['target'] = $target_link;

				$a_attrs['class'] = 'fresco';
				$a_attrs['data-fresco-group'] = catanis_random_string('5', 'img');
			}
				
			$link_output = '<a ' . catanis_stringify_attributes( $a_attrs ) . '>' . $link_output . '</a>';
		}

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID = catanis_random_string(10, 'cata_single_image');
		$elemClass = 'cata-single-image cata-element '. $img_align;
		$elemClass .= (!empty($hover_effect) ) ? ' '. $hover_effect : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';

		if(in_array($hover_effect, array('effect-3d'))){
			global $catanis;
			$custom_css = '';
				
			$selectID = '#' . $elemID .'.effect-3d';
			$custom_css .= $selectID . ' > div figure{
				background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('. $img_large .');
				background: -webkit-linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('. $img_large .');
			}';
			$catanis->inlinestyle[] = $custom_css;
		}

		ob_start();
		?>
		<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr( trim( $elemClass ) ); ?>" <?php echo trim($animation['animation-attrs']); ?>>
			<div><figure>
				<?php echo trim($link_output); ?>
			</figure></div>
		</div>
		<?php 
		$xhtml = ob_get_contents();
		ob_end_clean();
		
		return $xhtml;
	}
}
add_shortcode('cata_single_image', 'catanis_single_image_shortcode_function');


/*=== SHORTCODE - IMAGE TITLE ================*/
/*============================================*/
if ( ! function_exists( 'catanis_image_title_shortcode_function' ) ) {
	function catanis_image_title_shortcode_function( $atts, $content = null ) {

		$xhtml = $title = $image = $img_size = $img_align = $hover_effect = $custom_font = '';
		$font_size = $line_height = $font_weight = $onclick = $link = $target_link = $ext_class = '';
		extract( shortcode_atts( array(
			'title' 		=> '',
			'image' 		=> '',
			'img_size' 		=> 'full',
			'img_align' 	=> 'img-left',		/* img-left, img-right, img-center*/
			'hover_effect' 	=> 'effect-slide',
			'custom_font'	=> '',			/*NULL, yes*/
			'font_size'		=> '',
			'line_height'	=> '',
			'font_weight'	=> '600',
			'onclick' 		=> '',				/*prettyphoto, custom_link*/
			'link' 			=> '',
			'target_link' 	=> '_blank',
			'ext_class' 	=> ''
		), $atts ) );

		if( empty( $image ) || !is_numeric($image)){
			return esc_html('Please choose a image.', 'onelove');
		}

		$img = wpb_getImageBySize( array(
				'attach_id' => $image,
				'thumb_size' => $img_size,
				'class' => 'cata-image-title-img',
		) );

		$html_append = '<figcaption><h3>'. trim($title) .'</h3></figcaption>';
		if(in_array($hover_effect, array('effect-zoom-overlay'))){
			$html_append .= '<div class="layer"></div>';
		}
		
		if(in_array($hover_effect, array('effect-sparkle', 'effect-rain', 'effect-glass', 'effect-snow'))){
			$html_append .= '<span class="cata-effect cata-'. $hover_effect .'"></span>';
		}
		

		$a_attrs = array();
		$link_output = '<figure>' . $img['thumbnail'] . $html_append . '</figure>';
		if ( $onclick ) {

			if($onclick == 'custom_link'){
				$a_attrs['href'] = $link;
				$a_attrs['target'] = $target_link;
				$a_attrs['class'] = 'custom-link';
			}else{
				$a_attrs['href'] = $img['p_img_large'][0];
				$a_attrs['target'] = $target_link;

				$a_attrs['class'] = 'fresco';
				$a_attrs['data-fresco-group'] = catanis_random_string('5', 'img');
			}

			$link_output = '<a ' . catanis_stringify_attributes( $a_attrs ) . '><figure>' . $img['thumbnail'] . $html_append . '</figure></a>';
		}

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID = catanis_random_string(10, 'ca_image_title');
		$elemClass = 'cata-image-title cata-element '. $img_align . ' ' . $hover_effect;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';

		global $catanis;
		$custom_css = '';
		if( in_array($hover_effect, array('effect-3d' )) ){

			$selectID = '#' . $elemID . '.' . $hover_effect;
			if($hover_effect == 'effect-3d' ){
				$custom_css .= $selectID . ' > div figure{
					background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('. $img['p_img_large'][0] .');
					background: -webkit-linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('. $img['p_img_large'][0] .');
				}';
			}
			
		}
		
		if($custom_font == 'yes' ){
			$selectID = '#' . $elemID . '.' . $hover_effect;
			if( !empty($font_size) && !empty($line_height) && !empty($font_weight)) {
				$custom_css .= $selectID . ' > div figure figcaption h3{
					font-size: '. $font_size .';
					line-height: '. $line_height .';
					font-weight: '. $font_weight .';
				}';
			}
		}
		
		if(!empty($custom_css)){
			$catanis->inlinestyle[] = $custom_css;
		}
		
		ob_start();
		?>
		<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr( trim( $elemClass ) ); ?>" <?php echo trim($animation['animation-attrs']); ?>>
			<div><?php echo trim($link_output); ?></div>
		</div>
		<?php 
		$xhtml = ob_get_contents();
		ob_end_clean();
		
		return $xhtml;
	}
}
add_shortcode('cata_image_title', 'catanis_image_title_shortcode_function');


/*=== SHORTCODE - IMAGEBOX ===================*/
/*============================================*/
if ( ! function_exists( 'catanis_imagebox_shortcode_function' ) ) {
	/**
	 * Generates the image box element HTML from the shortcode
	 *
	 * @param array   $atts    the shortcode attributes
	 * @param string  $content
	 * @return string          the generated HTML code of the image box
	 */
	function catanis_imagebox_shortcode_function( $atts, $content = null ) {

		$image = $image_position = $main_style = $text_color = $bg_color = $heading = $heading_size = '';
		$subject = $show_readmore = $readmore_text = $readmore_link = $target_link = $ext_class = '';
		extract( shortcode_atts( $args = array(
			"image"      		=> "",
			"image_position"    => "left",				/* left, right */
			"main_style"    	=> "style1",			/* style1 -> style2 */
			"text_color"    	=> "text-dark",			/* text-dark, text-light */
			"bg_color"    		=> "#e49497",			/* dark, light */
			"heading"         	=> "",
			"heading_size"      => "16px",
			"subject"       	=> "",
			'show_readmore' 	=> 'yes',				/*NULL,yes*/
			'readmore_text' 	=> '',
			'readmore_link' 	=> '#',
			'target_link' 		=> '_blank',
			'ext_class' 		=> ''
		), $atts ) );
		
		$elemStyle = $imageBG = '';
		if ( !empty( $image ) ) {
			$image 		= wp_get_attachment_image_src( $image, 'large' );
			$imageBG 	= $image[0];
			$elemStyle .= "background: url($imageBG); ";
		}else{
			return '';
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID = catanis_random_string(10, 'cata_imagebox');
		$elemClass = 'cata-imagebox cata-element cata-'. $main_style . ' cata-'. $text_color . ' img-' . $image_position;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		ob_start();
		?>
		<div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?> style="<?php if($main_style == 'style2') echo esc_attr($elemStyle); ?>">
			
			<?php if( $main_style == 'style1'): ?>
				<div class="image-wrap">
					<?php if ( $show_readmore ) : ?><a href="<?php echo esc_url( $readmore_link ); ?>" target="<?php esc_attr_e( $target_link ); ?>"  title="<?php echo esc_attr($heading); ?>"><?php endif; ?>
					<img src="<?php echo esc_url($imageBG); ?>" alt="<?php echo esc_attr($heading); ?>"/>
					<span class="bgoverlay"></span>
					<?php if ( $show_readmore ) : ?></a><?php endif; ?>
				</div>
				<div class="imagebox-wrap">
					<h6 style="font-size: <?php echo esc_attr($heading_size); ?>">
						<?php if ( $show_readmore ) : ?><a href="<?php echo esc_url( $readmore_link ); ?>" target="<?php esc_attr_e( $target_link ); ?>"  title="<?php echo esc_attr($heading); ?>"><?php endif; ?>
						<?php echo esc_attr( $heading ); ?>
						<?php if ( $show_readmore ) : ?></a><?php endif; ?>
					</h6>
					<p><?php echo do_shortcode( $subject, true) ; ?></p>
					
					<?php if ( $show_readmore ) : ?>
						<a href="<?php echo esc_url( $readmore_link ); ?>" class="readmore" target="<?php esc_attr_e( $target_link ); ?>" title="<?php esc_html_e($readmore_text);?>"><?php esc_html_e($readmore_text);?></a>
					<?php endif; ?>
				</div>
			<?php elseif($main_style == 'style2'): ?>
					<span class="bgoverlay" style="background-color:<?php echo esc_attr($bg_color); ?>"></span>
					
				<div class="imagebox-wrap">
					<h6 style="font-size: <?php echo esc_attr($heading_size); ?>">
						<?php if ( $show_readmore ) : ?><a href="<?php echo esc_url( $readmore_link ); ?>" target="<?php esc_attr_e( $target_link ); ?>"  title="<?php echo esc_attr($heading); ?>"><?php endif; ?>
						<?php echo esc_attr( $heading ); ?>
						<?php if ( $show_readmore ) : ?></a><?php endif; ?>
					</h6>
					
					<p><?php echo do_shortcode( $subject, true) ; ?></p>
					
					<?php if ( $show_readmore == 'yes' ) : ?>
						<a href="<?php echo esc_url( $readmore_link ); ?>" class="readmore" target="<?php esc_attr_e( $target_link ); ?>" title="<?php esc_html_e($readmore_text);?>"><?php esc_html_e($readmore_text);?></a>
					<?php endif; ?>
				</div>	
			<?php endif; ?>
		</div>
	    
	    <?php 
	    $xhtml = ob_get_contents();
	    ob_end_clean();
	    
	    return $xhtml;
	}
}
add_shortcode('cata_imagebox', 'catanis_imagebox_shortcode_function');


/*=== SHORTCODE - PROGRESSBAR ================*/
/*============================================*/
if ( ! function_exists( 'catanis_progress_bar_shortcode_function' ) ){
	function catanis_progress_bar_shortcode_function( $atts, $content = null ) {
		 
		$main_style = $values = $units = $border_radius = $bgcolor = $custombgcolor = $customtxtcolor = $custombarcolor = $options = $ext_class = '';
		$values = urlencode( json_encode( array(
			array(
				'label' => __( 'Development', 'catanis-core' ),
				'value' => '90'
			),
			array(
				'label' => __( 'Design', 'catanis-core' ),
				'value' => '80'
			),
			array(
				'label' => __( 'Marketing', 'catanis-core' ),
				'value' => '70'
			),
		) ) );
		
		extract( shortcode_atts( array(
			'main_style' 		=> 'style1',		/*style1 -> 5*/
			'values' 			=> $values,				/*group: label, value, color, custombgcolor, customtxtcolor, custombarcolor*/
			'units' 			=> '',
			'bgcolor' 			=> 'main-color',
			'custombgcolor' 	=> '',
			'customtxtcolor' 	=> '',
			'custombarcolor' 	=> '',
			'options' 			=> '',			/*striped,animated*/
			'ext_class' 		=> ''
		), $atts ) );
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID = catanis_random_string(10, 'cata_progress_bar');
		$elemClass = 'cata-progress-bars cata-element cata-'. $main_style;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		$bar_options = array();
		$options = explode( ',', $options );
		if ( in_array( 'animated', $options ) ) {
			$bar_options[] = 'animated';
		}
		if ( in_array( 'striped', $options ) ) {
			$bar_options[] = 'striped';
		}
	
		if ( 'custom' === $bgcolor && '' !== $custombgcolor ) {
			$custombgcolor = ' style="' . catanis_get_css_color( 'background-color', $custombgcolor ) . '"';
			
			if ( '' !== $custombarcolor ) {
				$custombarcolor = ' style="' . catanis_get_css_color( 'background-color', $custombarcolor ) . '"';
			}
			if ( '' !== $customtxtcolor ) {
				$customtxtcolor = ' style="' . catanis_get_css_color( 'color', $customtxtcolor ) . '"';
			}
			$bgcolor = '';
		} else {
			$bgcolor = 'cata-bg-' . esc_attr( $bgcolor );
			$custombgcolor = $customtxtcolor = $custombarcolor = '';
		}
		
		$values = (array) catanis_param_group_parse_atts( $values );
		$max_value = 0.0;
		$graph_lines_data = array();
		foreach ( $values as $data ) {
			$new_line = $data;
			$new_line['value'] = isset( $data['value'] ) ? $data['value'] : 0;
			$new_line['label'] = isset( $data['label'] ) ? $data['label'] : '';
			$new_line['bgcolor'] = isset( $data['color'] ) && 'custom' !== $data['color'] ? '' : $custombgcolor;
			$new_line['txtcolor'] = isset( $data['color'] ) && 'custom' !== $data['color'] ? '' : $customtxtcolor;
			$new_line['barcolor'] = isset( $data['color'] ) && 'custom' !== $data['color'] ? '' : $custombarcolor;
			
			if(isset( $data['color'] ) && !in_array($data['color'], array('','custom'))){
				$new_line['classcolor'] = 'cata-bg-' . $data['color'];
			}else{
				$new_line['classcolor'] = $bgcolor;
			}
			
			if ( isset( $data['custombarcolor'] ) && ( ! isset( $data['color'] ) || 'custom' === $data['color'] ) ) {
				$new_line['barcolor'] = ' style="background-color: ' . esc_attr( $data['custombarcolor'] ) . ';"';
			}
			if ( isset( $data['custombgcolor'] ) && ( ! isset( $data['color'] ) || 'custom' === $data['color'] ) ) {
				$new_line['bgcolor'] = ' style="background-color: ' . esc_attr( $data['custombgcolor'] ) . ';"';
			}
			if ( isset( $data['customtxtcolor'] ) && ( ! isset( $data['color'] ) || 'custom' === $data['color'] ) ) {
				$new_line['txtcolor'] = ' style="color: ' . esc_attr( $data['customtxtcolor'] ) . ';"';
			}
			
			if ( $max_value < (float) $new_line['value'] ) {
				$max_value = $new_line['value'];
			}
			$graph_lines_data[] = $new_line;
		}

		$xhtml = '<div id="'. esc_attr($elemID) .'" class="' . esc_attr( $elemClass ) . '" '. trim($animation['animation-attrs']) .'>';
		foreach ( $graph_lines_data as $line ) {

			$unit = $unit5 = ( '' !== $units ) ? ' <span class="cata-percentage">' . $line['value'] . $units . '</span>' : '';
			$bar_line_cls = 'cata-bar-line ' . $line['classcolor'] . ' ' . implode( ' ', $bar_options );
			
			if($main_style != 'style5'){
				$unit5 = '';
			}else{
				$unit = '';
			}
				
			$xhtml .= '<div class="cata-progress-bar" data-value="' .  esc_attr( $line['value'] ) . '" data-units="' .  esc_attr( $units) . '">';
			$xhtml .= '  <div class="cata-bar-title"' . $line['txtcolor'] . '><em>' . $line['label'] . '</em>' . $unit . '</div>';
			$xhtml .= '  <div class="cata-bar"' . $line['barcolor'] . '>';
			$xhtml .= '    <div class="' . esc_attr( $bar_line_cls ) . '"' . $line['bgcolor'] . '></div>'. $unit5;
			$xhtml .= '  </div>';
			$xhtml .= '</div>';
		}
		$xhtml .= '</div>';
		
		return $xhtml;
		
	}
}
add_shortcode( 'cata_progress_bar', 'catanis_progress_bar_shortcode_function' );


/*=== SHORTCODE - INFOBOX CONTACT ============*/
/*============================================*/
if ( ! function_exists( 'catanis_infobox_contact_shortcode_function' ) ){
	function catanis_infobox_contact_shortcode_function( $atts, $content = null ) {
		
		$xhtml = $box_width = $image_top_left = $image_bottom_right = $ext_class = $ext_id = '';
		extract( shortcode_atts( array(
			'box_width' 			=> 'width-70percent',				/*width-80percent -> width-100percent*/
			'image_top_left'  		=> '',					
			'image_bottom_right'  	=> '',				
			'ext_class' 			=> '',
			'ext_id' 				=> ''
		), $atts ) );
		
		$elemID 	= (!empty($ext_id)) ? $ext_id : catanis_random_string(10, 'infobox_contact');
		$elemClass 	= 'cata-infobox-contact ' . $box_width;
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		if($image_top_left != '' && is_numeric($image_top_left)){
			$image_top_left = wp_get_attachment_image_url( $image_top_left, 'full') ;
		}

		if($image_bottom_right != '' && is_numeric($image_bottom_right)){
			$image_bottom_right = wp_get_attachment_image_url( $image_bottom_right, 'full') ;
		}
		
		$xhtml .= '<div id="'. esc_attr($elemID) .'" class="'. esc_attr($elemClass) .'">';
		if( !empty($image_top_left) ){
			$xhtml .= '<img src="'. $image_top_left .'" class="img-tl" alt="" />';
		}
		
		$xhtml .= '<div class="infobox-wrap">' . do_shortcode($content) . '</div>';
		
		if( !empty($image_bottom_right) ){
			$xhtml .= '<img src="'. $image_bottom_right .'" class="img-br" alt="" />';
		}
		$xhtml .= '</div>';
		return $xhtml;		

	}
}
add_shortcode('cata_infobox_contact', 'catanis_infobox_contact_shortcode_function');


/*=== SHORTCODE - CATANIS SLIDER =============*/
/*============================================*/
if ( ! function_exists( 'catanis_slider_shortcode_function' ) ) {
	function catanis_slider_shortcode_function( $atts ) {

		$xhtml = $images = $use_stick_corners = $bg_image_overlay = $with_padding = $padding_value = $onclick = $custom_links = $custom_links_target = '';
		$items_desktop = $items_desktop_small = $items_tablet = $slide_loop = $slide_arrows = $slide_dots = $slide_dots_style = '';
		$slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $ext_class = '';
		extract( shortcode_atts( array(
			'images' 				=> '',
			'use_stick_corners' 	=> '',				/*NULL,yes*/
			'bg_image_overlay' 	=> '',			
			'with_padding' 			=> '',				/*NULL,yes*/
			'padding_value' 		=> '30',
			'onclick' 				=> '',				/*NULL,popup_link,custom_link*/
			'custom_links' 			=> '',
			'custom_links_target' 	=> '_blank',
				
			'items_desktop' 		=> 4,
			'items_desktop_small' 	=> 3,
			'items_tablet' 			=> 2,
			'slide_loop' 			=> 'yes',
			'slide_arrows'			=> 'no',
			'slide_dots'			=> 'yes',
			'slide_dots_style'		=> 'dots-line', 	/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/
			'slide_autoplay'		=> 'no',
			'slide_autoplay_speed'	=> 3000,
			'slides_to_scroll'		=> 3,
			'slides_speed'			=> 500,
			'ext_class' 			=> ''
		), $atts ) );

		if ( '' === $images ){
			return '';
		}
			
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_slider');
		$elemClass 	= 'cata-slick-slider catanis-slider cata-element ' . $slide_dots_style;
		$elemClass .= ($with_padding == 'yes') ? ' cata-slider-spacing' . absint($padding_value) : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		
		$i = - 1;
		$images = explode( ',', $images );
		if ( 'custom_link' === $onclick ) {
			$custom_links = explode( ',', $custom_links );
		}

		$arrParams = array(
			'autoplay' 			=> ($slide_autoplay == 'yes') ? true : false,
			'autoplaySpeed' 	=> intval($slide_autoplay_speed),
			'slidesToShow' 		=> intval($items_desktop),
			'slidesToScroll' 	=> intval($slides_to_scroll),
			'dots' 				=> ($slide_dots == 'yes')? true : false,
			'arrows' 			=> ($slide_arrows == 'yes')? true : false,
			'infinite' 			=> ($slide_loop == 'yes')? true : false,
			'draggable' 		=> true,
			'rtl' 				=> CATANIS_RTL,
			'speed' 			=> intval($slides_speed),
			'responsive'		=> array(
				array(
					'breakpoint'	=> 1024,
					'settings'		=> array(
						'slidesToShow'		=> intval($items_desktop_small),
						'slidesToScroll' 	=> intval($items_desktop_small)
					)
				),
				array(
					'breakpoint'	=> 768,
					'settings'		=> array(
						'slidesToShow'		=> intval($items_tablet),
						'slidesToScroll' 	=>  intval($items_tablet)
					)
				),
				array(
					'breakpoint'	=> 480,
					'settings'		=> array(
						'slidesToShow'		=> 1,
						'slidesToScroll' 	=> 1
					)
				),
			)
		);

		if($items_desktop == 1 && $items_desktop_small == 1 && $items_tablet == 1){
			$arrParams['fade'] = true;
			$arrParams['cssEase'] = 'linear';
			$arrParams['slidesToScroll'] = 1;
			$elemClass 	.= ' cata-show-one';
			
			if($use_stick_corners == 'stick_corners'){
				$xhtml = '<div class="cata-corner-tl"></div><div class="cata-corner-br"></div>';
			}
			if($use_stick_corners == 'bg_overlay' && $bg_image_overlay != '' && is_numeric($bg_image_overlay) ) {
				$bg_image = wp_get_attachment_image_url( $bg_image_overlay, 'full') ;
				$xhtml = '<div class="cata-overlay-bg"><img src="'. esc_attr($bg_image) .'" alt=""/></div>';
			}
		}
	
		$groupID = 'gallery_' . catanis_random_string('5');
		ob_start();
		?>
		 <div<?php echo rtrim($dir); ?> id="<?php echo esc_attr( $elemID ); ?>" class="<?php echo esc_attr( $elemClass ); ?>" <?php echo trim($animation['animation-attrs']); ?>>
		 	<?php echo wp_kses_post($xhtml); ?>
	        <ul class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
	            <?php 
	            foreach ( $images as $attach_id ): 
					$i ++;
					if ( $attach_id > 0 ) {
						$post_thumbnail = wpb_getImageBySize( array(
							'attach_id' 	=> $attach_id,
							'thumb_size' 	=> 'full'
						) );
					} else {
						$post_thumbnail = array();
						$post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
						$post_thumbnail['p_img_large'][0] = vc_asset_url( 'vc/no_image.png' );
					}
					$thumbnail = $post_thumbnail['thumbnail'];
				
					if($onclick == 'custom_link' && isset( $custom_links[ $i ] ) && '' !== $custom_links[ $i ]){
						$link_html = '<a href="' . esc_url( $custom_links[ $i ] ) . '" target="'. esc_attr( $custom_links_target) .'" title="'. get_the_title( $attach_id ) .'">' . $thumbnail . '</a>';
					}elseif( in_array($onclick, array('popup_link')) ){
						$link = wp_get_attachment_image_src( $attach_id, 'large' );
						$link_html = '<a data-fresco-group="'. $groupID .'" class="fresco" href="' . esc_url( $link[0] ) . '" target="'. esc_attr( $custom_links_target) .'" title="'. get_the_title( $attach_id ) .'">' . $thumbnail . '</a>';
					}else{
						$link_html = $thumbnail;
					}
				?>
		             <li class="cata-item"><?php echo trim($link_html); ?></li>
    			<?php endforeach; ?>
	        </ul>
	    </div>
		<?php
		$xhtml = ob_get_contents();
		ob_end_clean();
		
		return $xhtml;
	}
}
add_shortcode( 'cata_slider', 'catanis_slider_shortcode_function');


/*=== SHORTCODE - FULLWIDTH SLIDER ===========*/
/*============================================*/
if ( ! function_exists( 'catanis_slider_fwidth_shortcode_function' ) ) {
	function catanis_slider_fwidth_shortcode_function( $atts, $content = null ) {

		$xhtml = $slider_style = $show_dots = $dots_style = $dots_color = $show_navigation = $navigation_style = '';
		$draggable = $cursor_color = $transition_style = $autoplay = $stop_on_hover = $autoplay_speed = $ext_class = $ext_id = '';
		extract( shortcode_atts( array(
			'slider_style' 			=> 'vertical',				/*vertical,horizontal*/
			'show_dots'  			=> '',						/*NULL,yes*/
			'dots_style'  			=> 'dots-line',				/*dots-rounded,dots-square,dots-line,dots-catanis-height,dots-catanis-width*/
			'dots_color' 			=> 'dark-dots',				/*dark-dots,light-dots*/
			'show_navigation' 		=> '',						/*NULL,yes*/
			'navigation_style' 		=> 'dark-navigation',		/*dark-navigation,light-navigation*/
			'draggable' 			=> '',						/*NULL,yes*/
			'cursor_color' 			=> '',						/*NULL,dark-cursor,light-cursor*/
			'transition_style' 		=> 'slide',					/*NULL,slide,fade*/
			'autoplay' 				=> '',						/*NULL,yes*/
			'stop_on_hover' 		=> '',						/*NULL,yes*/
			'autoplay_speed' 		=> '3000',					/*400->10000*/
			'ext_class' 			=> '',
			'ext_id' 				=> ''
		), $atts ) );
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= (!empty($ext_id)) ? $ext_id : catanis_random_string(10, 'slider-fwidth');
		$elemClass 	= 'cata-slider-fwidth cata-element slider-' . $slider_style;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		
		if($show_dots){
			$elemClass .= (!empty($dots_style) ) ? ' '. $dots_style : '';
			$elemClass .= (!empty($dots_color) ) ? ' '. $dots_color : '';
		}
		
		if($show_navigation){
			$elemClass .= (!empty($navigation_style) ) ? ' '. $navigation_style : '';
		}
		
		if($draggable){
			$elemClass .= (!empty($cursor_color) ) ? ' '. $cursor_color : '';
		}
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		
		$arrParams = array(
			'autoplay' 			=> ($autoplay) ? true : false,
			'autoplaySpeed' 	=> intval($autoplay_speed),
			'slidesToShow' 		=> 1,
			'slidesToScroll' 	=> 1,
			'dots' 				=> ($show_dots)? true : false,
			'arrows' 			=> ($show_navigation)? true : false,
			'draggable' 		=> ($draggable)? true : false,
			'infinite' 			=> true,
			'rtl' 				=> CATANIS_RTL,
			'speed' 			=> 500
		);

		if($slider_style == 'vertical'){
			$dir = '';
			$arrParams['vertical'] = true;
			$arrParams['infinite'] = false;
			$arrParams['rtl'] = false;
		}else{
			if($transition_style == 'fade'){
				$arrParams['fade'] = true;
				$arrParams['cssEase'] = 'linear';
			}
		}
	
		$xhtml .= '<div' . rtrim($dir) . ' id="'. esc_attr($elemID) .'" class="'. esc_attr($elemClass) .'" '. trim($animation['animation-attrs']) .'>';
		$xhtml .= '<div class="slides layout-onepage-scroll" data-slick=\''. json_encode($arrParams) .'\'>';
		$xhtml .= do_shortcode($content);
		$xhtml .= '</div>';
		$xhtml .= '</div>';
	    
	    return $xhtml;
		
	}
}
add_shortcode('cata_slider_fwidth', 'catanis_slider_fwidth_shortcode_function');


/*=== SHORTCODE - FULLWIDTH SLIDER ITEM ======*/
/*============================================*/
if ( ! function_exists( 'catanis_slider_item_shortcode_function' ) ){
	function catanis_slider_item_shortcode_function( $atts, $content = null ) {
		
		$xhtml = $image = $show_overlay = $overlay_opacity = $overlay_color = '';
		$title = $title_color = $fontsize_title = $ipad_fontsize_title = $mobile_fontsize_title = $use_google_fonts_title = $google_fonts_title = '';
		
		$desktop_margin_top_title = $desktop_margin_right_title = $desktop_margin_bottom_title = $desktop_margin_left_title = '';
		$ipad_custom_margin_title = $ipad_margin_top_title = $ipad_margin_right_title = $ipad_margin_bottom_title = $ipad_margin_left_title = '';
		$mobile_custom_margin_title = $mobile_margin_top_title = $mobile_margin_right_title = $mobile_margin_bottom_title = $mobile_margin_left_title = '';
		
		$subtitle = $subtitle_color = $fontsize_subtitle = $ipad_fontsize_subtitle = $mobile_fontsize_subtitle = $use_google_fonts_subtitle = $google_fonts_subtitle = '';
		$desktop_margin_top_subtitle = $desktop_margin_right_subtitle = $desktop_margin_bottom_subtitle = $desktop_margin_left_subtitle = '';
		$ipad_custom_margin_subtitle = $ipad_margin_top_subtitle = $ipad_margin_right_subtitle = $ipad_margin_bottom_subtitle = $ipad_margin_left_subtitle = '';
		$mobile_custom_margin_subtitle = $mobile_margin_top_subtitle = $mobile_margin_right_subtitle = $mobile_margin_bottom_subtitle = $mobile_margin_left_subtitle = '';
		
		$subtitle_above = $position_text = $animation_text = $num_button = $first_button = $second_button = $ext_class = $ext_id = '';
		extract( shortcode_atts( array(
			'image' 							=> '',										/*NULL,yes*/
			'show_overlay' 						=> '',
			'overlay_opacity' 					=> '',
			'overlay_color' 					=> '',
			
			'title' 							=> '',
			'title_color' 						=> '#FFFFFF',
			'fontsize_title' 					=> 'fontsize-100px',
			'ipad_fontsize_title' 				=> 'ipad-fontsize-75px',
			'mobile_fontsize_title' 			=> 'mobile-fontsize-50px',
			'desktop_margin_top_title' 			=> '',
			'desktop_margin_right_title' 		=> '',
			'desktop_margin_bottom_title' 		=> '',
			'desktop_margin_left_title' 		=> '',
			'ipad_custom_margin_title' 			=> '',										/*NULL,yes*/
			'ipad_margin_top_title' 			=> '',
			'ipad_margin_right_title' 			=> '',
			'ipad_margin_bottom_title' 			=> '',
			'ipad_margin_left_title' 			=> '',
			'mobile_custom_margin_title' 		=> '',										/*NULL,yes*/
			'mobile_margin_top_title' 			=> '',
			'mobile_margin_right_title' 		=> '',
			'mobile_margin_bottom_title' 		=> '',
			'mobile_margin_left_title' 			=> '',
			'use_google_fonts_title' 			=> '',										/*NULL,yes*/
			'google_fonts_title' 				=> 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
			
			'subtitle' 							=> '',
			'subtitle_color' 					=> '#FFFFFF',
			'fontsize_subtitle' 				=> 'fontsize-30px',
			'ipad_fontsize_subtitle' 			=> 'ipad-fontsize-20px',
			'mobile_fontsize_subtitle' 			=> 'mobile-fontsize-16px',
			'desktop_margin_top_subtitle' 		=> '',
			'desktop_margin_right_subtitle' 	=> '',
			'desktop_margin_bottom_subtitle' 	=> '',
			'desktop_margin_left_subtitle' 		=> '',
			'ipad_custom_margin_subtitle' 		=> '',										/*NULL,yes*/
			'ipad_margin_top_subtitle' 			=> '',
			'ipad_margin_right_subtitle' 		=> '',
			'ipad_margin_bottom_subtitle' 		=> '',
			'ipad_margin_left_subtitle' 		=> '',
			'mobile_custom_margin_subtitle' 	=> '',										/*NULL,yes*/
			'mobile_margin_top_subtitle' 		=> '',
			'mobile_margin_right_subtitle' 		=> '',
			'mobile_margin_bottom_subtitle' 	=> '',
			'mobile_margin_left_subtitle' 		=> '',
			'use_google_fonts_subtitle'			=> '',										/*NULL,yes*/
			'google_fonts_subtitle' 			=> 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',		
			'subtitle_above' 					=> '',										/*NULL,yes*/
			
			'position_text' 					=> 'center-center',							/*center-center,center-left,center-right*/
			'animation_text' 					=> 'cata-bounceInUp',							/*NULL,cata-bounceIn,cata-bounceInUp,cata-bounceInDown,cata-bounceInLeft,cata-bounceInRight,cata-fadeInLeft,cata-fadeInRight,cata-flipInY,cata-flipInX*/
			'num_button' 						=> '',										/*NULL,one,two*/
			'first_button' 						=> '',		
			'second_button' 					=> '',		
			'ext_class' 						=> '',
			'ext_id' 							=> ''
		), $atts ) );
		
		$elemID 	= (!empty($ext_id)) ? $ext_id : catanis_random_string(5, 'item');
		$elemClass 	= 'cata-item ' ;
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		$elemStyle = '';
		if(is_numeric($image)){
			$bg_image = wp_get_attachment_image_url( $image, 'full') ;
			$elemStyle .= 'background-image:url('. $bg_image .');';
		}
		
		/* TITLE */
		$title = ( $title ) ? str_replace('||', '<br />',$title) : '';
		$title_class = 'slider-title ' . $fontsize_title . ' ' . $ipad_fontsize_title . ' ' . $mobile_fontsize_title;
		if ( ! empty( $ipad_custom_margin_title ) ) {
			$title_class .=	( ! empty( $ipad_margin_top_title ) ) ? ' ' . $ipad_margin_top_title : '' ;
			$title_class .=	( ! empty( $ipad_margin_right_title ) ) ? ' ' . $ipad_margin_right_title : '' ;
			$title_class .=	( ! empty( $ipad_margin_bottom_title ) ) ? ' ' . $ipad_margin_bottom_title : '' ;
			$title_class .=	( ! empty( $ipad_margin_left_title ) ) ? ' ' . $ipad_margin_left_title : '' ;
		}
		
		if ( ! empty( $mobile_custom_margin_title ) ) {
			$title_class .=	( ! empty( $mobile_margin_top_title ) ) ? ' ' . $mobile_margin_top_title : '' ;
			$title_class .=	( ! empty( $mobile_margin_right_title ) ) ? ' ' . $mobile_margin_right_title : '' ;
			$title_class .=	( ! empty( $mobile_margin_bottom_title ) ) ? ' ' . $mobile_margin_bottom_title : '' ;
			$title_class .=	( ! empty( $mobile_margin_left_title ) ) ? ' ' . $mobile_margin_left_title : '' ;
		}
		
		$title_style = 'color:'. $title_color .';';
		$title_style .= ($desktop_margin_top_title) ? 'margin-top:'. $desktop_margin_top_title .';' : '';
		$title_style .= ($desktop_margin_right_title) ? 'margin-right:'. $desktop_margin_right_title .';' : '';
		$title_style .= ($desktop_margin_bottom_title) ? 'margin-bottom:'. $desktop_margin_bottom_title .';' : '';
		$title_style .= ($desktop_margin_left_title) ? 'margin-left:'. $desktop_margin_left_title .';' : '';
		
		$title_style = str_replace(';', '|', $title_style);
		$font_data_title = catanis_parse_text_style_for_googlefont($title_style, '', $use_google_fonts_title, $google_fonts_title );
		
		
		/* SUBTITLE */
		$subtitle = ( $subtitle ) ? str_replace('||', '<br />',$subtitle) : '';
		$subtitle_class = 'slider-subtitle ' . $fontsize_subtitle . ' ' . $ipad_fontsize_subtitle . ' ' . $mobile_fontsize_subtitle;
		if ( ! empty( $ipad_custom_margin_subtitle ) ) {
			$title_class .=	( ! empty( $ipad_margin_top_subtitle ) ) ? ' ' . $ipad_margin_top_subtitle : '' ;
			$title_class .=	( ! empty( $ipad_margin_right_subtitle ) ) ? ' ' . $ipad_margin_right_subtitle : '' ;
			$title_class .=	( ! empty( $ipad_margin_bottom_subtitle ) ) ? ' ' . $ipad_margin_bottom_subtitle : '' ;
			$title_class .=	( ! empty( $ipad_margin_left_subtitle ) ) ? ' ' . $ipad_margin_left_subtitle : '' ;
		}
		
		if ( ! empty( $mobile_custom_margin_subtitle ) ) {
			$title_class .=	( ! empty( $mobile_margin_top_subtitle ) ) ? ' ' . $mobile_margin_top_subtitle : '' ;
			$title_class .=	( ! empty( $mobile_margin_right_subtitle ) ) ? ' ' . $mobile_margin_right_subtitle : '' ;
			$title_class .=	( ! empty( $mobile_margin_bottom_subtitle ) ) ? ' ' . $mobile_margin_bottom_subtitle : '' ;
			$title_class .=	( ! empty( $mobile_margin_left_subtitle ) ) ? ' ' . $mobile_margin_left_subtitle : '' ;
		}
		
		$subtitle_style = 'color:'. $subtitle_color .';';
		$subtitle_style .= ($desktop_margin_top_subtitle) ? 'margin-top:'. $desktop_margin_top_subtitle .';' : '';
		$subtitle_style .= ($desktop_margin_right_subtitle) ? 'margin-right:'. $desktop_margin_right_subtitle .';' : '';
		$subtitle_style .= ($desktop_margin_bottom_subtitle) ? 'margin-bottom:'. $desktop_margin_bottom_subtitle .';' : '';
		$subtitle_style .= ($desktop_margin_left_subtitle) ? 'margin-left:'. $desktop_margin_left_subtitle .';' : '';
		
		$subtitle_style = str_replace(';', '|', $subtitle_style);
		$font_data_subtitle = catanis_parse_text_style_for_googlefont($subtitle_style, '', $use_google_fonts_subtitle, $google_fonts_subtitle );
		
		
		$xhtml .= '<div id="'. esc_attr($elemID) .'" class="'. esc_attr($elemClass) .'" style="'. esc_attr($elemStyle) .'">';
		if( ! empty( $show_overlay )) {
			$opacity_attribute 	= !empty( $overlay_opacity ) ? 'opacity:'. $overlay_opacity .';' : '';
			$opacity_attribute .= !empty( $overlay_color ) ? ' background-color:'. $overlay_color .';' : '';
			
			$xhtml .= '<div class="slider-overlay" style="'. $opacity_attribute .'"></div>';
		}
		
		$xhtml .= '<div class="container row-fullscreen"><div class="slider-typography">';
		$xhtml .= '<div class="slider-text-wrapper">';
		$xhtml .= '<div class="slider-text pos-'. $position_text . ' cata-has-animation ' . $animation_text .'">';
		if($subtitle_above){
			if($subtitle):
				$xhtml .= '<span class="'. $subtitle_class .'" '. $font_data_subtitle['style'] .'>'. $subtitle .'</span>';
			endif;
			if($title):
				$xhtml .= '<span class="'. $title_class .'" '. $font_data_title['style'] .'>'. $title .'</span>';
			endif;
		}else{
			if($title):
				$xhtml .= '<span class="'. $title_class .'" '. $font_data_title['style'] .'>'. $title .'</span>';
			endif;
			if($subtitle):
				$xhtml .= '<span class="'. $subtitle_class .'" '. $font_data_subtitle['style'] .'>'. $subtitle .'</span>';
			endif;
		}
		
		/* BUTTON */
		if($num_button){
			$xhtml .= '<div class="buttons-wrapper">';
			$first_button 	= ( '||' === $first_button ) ? '' : $first_button;
			$second_button 	= ( '||' === $second_button ) ? '' : $second_button;
			if ($first_button) {
				$first_button_attr = catanis_parse_multi_attribute($first_button);
				$first_button_title   = ( isset($first_button_attr['title']) ) ? $first_button_attr['title'] : 'Sample Button';
					
				$btn1_shortcode = '[cata_button main_style="flat" button_text="'. $first_button_title .'"';
				$btn1_shortcode .= ' link="'. $first_button .'" shape = "square" size ="md" ext_class="btn-one"';
				$btn1_shortcode .= ' button_color = "#1A1A1A" text_color = "#FFFFFF"';
				$btn1_shortcode .= ' button_color_hover = "#e49497" text_color_hover = "#FFFFFF"]';
				$xhtml .= do_shortcode($btn1_shortcode);
			}
			if ($second_button != '') {
				$second_button_attr 	= catanis_parse_multi_attribute($second_button);
				$second_button_title    = ( isset($second_button_attr['title']) ) ? $second_button_attr['title'] : 'Sample Button';
					
				$btn2_shortcode = '[cata_button main_style="flat" button_text="'. $second_button_title .'"';
				$btn2_shortcode .= ' link="'. $second_button .'" shape = "square" size ="md" ext_class="btn-two"';
				$btn2_shortcode .= ' button_color = "#1A1A1A" text_color = "#FFFFFF"';
				$btn2_shortcode .= ' button_color_hover = "#e49497" text_color_hover = "#FFFFFF"]';
				$xhtml .= do_shortcode($btn2_shortcode);
			}
			$xhtml .= '</div>';
		}
		
		$xhtml .= '</div>';
		$xhtml .= '</div>';
		$xhtml .= '</div></div>';
		
		$xhtml .= '</div>';
		
		return $xhtml;
		
	}
}
add_shortcode('cata_slider_item', 'catanis_slider_item_shortcode_function');


/*=== SHORTCODE - DOUBLE SLIDER ==============*/
/*============================================*/
if ( ! function_exists( 'catanis_double_slider_shortcode_function' ) ){
	function catanis_double_slider_shortcode_function($atts, $content = null){
		
		$slide_num = $slider_navi_pos = $slider_navi_color = $slider_autoplay = $slider_duration = $slider_height =  $slider_appearance = '';
		extract( shortcode_atts( array(
			'slide_num' 		=> '3',
			'slider_navi_pos' 	=> 'center-left-right',		/*center-left-right, center-bottom*/
			'slider_navi_color' => '',						/*NULL, color-light*/
			'slider_autoplay' 	=> 'yes',
			'slider_duration' 	=> '5',
			'slider_height' 	=> '500',
			'slider_appearance' => 'double-slider-left'		/*double-slider-left, double-slider-right*/
		), $atts ) );
	
		for($i=1; $i <= $slide_num; $i++){
			$slides[$i] = shortcode_atts( array(
				'slide_title_'.$i 			=> 'Title'.$i,
				'slide_subtitle_'.$i 		=> 'Subtitle'.$i,
				'slide_description_'.$i 	=> 'Slide Description'.$i,
				'slide_bg_'.$i 				=> '#f7f7f7',
				'slide_fg_'.$i 				=> '#1A1A1A',
				'slide_image_'.$i 			=> CATANIS_DEFAULT_IMAGE,
				'btn_'.$i					=> '',
				'btn_text_'.$i 				=> 'PURCHASE NOW'.$i,
				'btn_style_'.$i 			=> 'flat',
				'btn_bg_color_'.$i 			=> '#e49497',
				'btn_text_color_'.$i 		=> '#FFFFFF',
				'btn_bg_color_hover_'.$i 	=> '#dfa1a3',
				'btn_text_color_hover_'.$i 	=> '#FFFFFF'
			), $atts );
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID = catanis_random_string(10, 'cata_double_slider');
		$elemClass 	= 'cata-double-slider clearfix ' . $slider_appearance . ' '. $slider_navi_pos;
		$elemClass .= (!empty($slider_navi_color)) ? ' cata-' . $slider_navi_color : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass = str_replace('  ', ' ', trim($elemClass));
					
		if( $slider_autoplay == 'yes'){
			$autoPlay = 'true';
		} else{
			$autoPlay = 'false';
		}
		
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;
		$custom_css .= $selectID . ' .double-slider-image-container li div{ height:'. esc_attr($slider_height) .'px; }';
		$custom_css .= $selectID . ' .double-slider-text-container ul.slides{ height:'. esc_attr($slider_height) .'px; }';
		if(CATANIS_RTL){
			$custom_css .= $selectID . ' .double-slider-text-container .flex-viewport {direction:ltr;}';
			$custom_css .= $selectID . ' .double-slider-text-container .flex-viewport *{direction:ltr;}';
		}
		
		$catanis->inlinestyle[] = $custom_css;
		
		ob_start();
		?>
	    <div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
	        <div class="double-slider-image-container">
	            <ul class="slides clearfix">
	                <?php
	                foreach($slides as $key=>$slide){
	                    $image = $slide['slide_image_'.$key];
	                    if($image != '' && is_numeric($image)){
	                        $image = wp_get_attachment_image_src( $image,'full') ;
	                        $image = (false == $image)? CATANIS_DEFAULT_IMAGE : $image[0];
	                    }
	                ?>
	                <li><div style="background-image: url(<?php echo esc_attr($image);?>);"></div></li>
	                <?php
	                }
	                ?>
	            </ul>
	        </div>
	
	        <div class="double-slider-text-container">
	            <div class="double-slider-nav">
	                <a href="#" class="slider-prev"><i class="fa fa-angle-left"></i></a>
	                <a href="#" class="slider-next"><i class="fa fa-angle-right"></i></a>
	            </div>
	            <ul class="slides clearfix">
	                <?php
	                $bg = array();
	                $fgArr = array();
	                foreach($slides as $key => $slide){
	
		                $title 			= $slide['slide_title_'.$key];
		                $subTitle 		= $slide['slide_subtitle_'.$key];
		                $decription 	= $slide['slide_description_'.$key];
		                $bg[] 			= esc_attr($slide['slide_bg_'.$key]);
		                $fgArr[] 		= esc_attr($slide['slide_fg_'.$key]);
		                $fg 			= $slide['slide_fg_'.$key];
		                
		                $image 		= $slide['slide_image_'.$key];
		                if($image != '' && is_numeric($image)){
		                	$image = wp_get_attachment_image_src( $image) ;
		                	$image = (false == $image) ? CATANIS_DEFAULT_IMAGE : $image[0];
		                }
		                
		                $btn					= $slide['btn_'.$key];
		                $btn_text 				= $slide['btn_text_'.$key];
		                $btn_style 				= $slide['btn_style_'.$key];
		                $btn_bg_color 			= $slide['btn_bg_color_'.$key];
		                $btn_text_color 		= $slide['btn_text_color_'.$key];
		                $btn_bg_color_hover 	= $slide['btn_bg_color_hover_'.$key];
		                $btn_text_color_hover 	= $slide['btn_text_color_hover_'.$key];
		                
		                $btn_shortcode = '[cata_button main_style="'. $btn_style .'" button_text="'. $btn_text .'"';
		                $btn_shortcode .= ' link="'. $btn .'" shape = "square" size ="nm"';
		                $btn_shortcode .= ' button_color = "'. $btn_bg_color .'" text_color = "'. $btn_text_color .'"';
		                $btn_shortcode .= ' button_color_hover = "'. $btn_bg_color_hover .'" text_color_hover = "'. $btn_text_color_hover .'"]';
	                ?>
	                <li style="color:<?php echo esc_attr($fg); ?>;">
	                    <div class="slider-container">
	                    	<?php if(!empty($subTitle)): ?> 
	                        	<p class="slider-subtitle"><?php echo esc_attr($subTitle)?></p>
	                        <?php endif; ?>
	                        
	                        <?php if(!empty($title)): ?> 
	                            <h3 class="slider-title"><?php echo esc_attr($title)?></h3>
	                        <?php endif; ?>
	                        
	                        <?php if(!empty($decription)): ?> 
	                        	<p class="slider-description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($decription)); ?></p>
	                        <?php endif; ?>
	                        
	                         <?php if(!empty($btn_text)): echo do_shortcode($btn_shortcode); endif; ?>
	                    </div>
	                </li>
	                <?php
	                }
	                ?>
	            </ul>
	        </div>
	        
	    	<div id="s<?php echo esc_attr($elemID); ?>" data-bg='["<?php echo implode('","',$bg);?>"]' data-fg='["<?php echo implode('","',$fgArr);?>"]' data-autoplay="<?php echo esc_attr($autoPlay)?>" data-duration="<?php echo esc_attr($slider_duration*1000)?>">  </div>
	    </div>
	    <?php
	    return ob_get_clean();
	}
}
add_shortcode( 'cata_double_slider', 'catanis_double_slider_shortcode_function' );


/*=== SHORTCODE - CONTENT SLIDER =============*/
/*============================================*/
if ( ! function_exists( 'catanis_content_slider_shortcode_function' ) ){
	function catanis_content_slider_shortcode_function($atts, $content = null){
	
		$bg_image = $bg_overlay = $text_color = $text_align = '';
		$slide_num = $slider_nav_display = $slider_dots_display = $slider_autoplay = $slider_duration = $slider_height = '';
		extract( shortcode_atts( array(
			'bg_image' 				=> '',
			'bg_overlay' 			=> '',
			'text_color' 			=> '#FFFFFF',
			'slide_num' 			=> '3',
			'slider_nav_display' 	=> 'nav-lr',			/* nav-none, nav-lr, nav-bottom */
			'slider_dots_display' 	=> 'dots-none',			/* dots-none, dots-right, dots-bottom */
			'text_align' 			=> 'text-center',		/* text-center, text-left */
			'slider_autoplay' 		=> 'yes',
			'slider_duration' 		=> '5',
			'slider_height' 		=> '500'
		), $atts ) );
	
		for($i=1; $i <= $slide_num; $i++){
			$slides[$i] = shortcode_atts( array(
				'slide_title_'.$i 		=> 'Title'.$i,
				'slide_subtitle_'.$i 	=> 'Subtitle'.$i,
				'slide_description_'.$i => 'Slide Description'.$i,
				'btn_'.$i					=> '',
				'btn_text_'.$i 				=> 'PURCHASE NOW'.$i,
				'btn_style_'.$i 			=> 'flat',
				'btn_bg_color_'.$i 			=> '#e49497',
				'btn_text_color_'.$i 		=> '#FFFFFF',
				'btn_bg_color_hover_'.$i 	=> '#dfa1a3',
				'btn_text_color_hover_'.$i 	=> '#FFFFFF'
			), $atts );
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_content_slider');
		$elemClass 	= 'cata-content-slider cata-element clearfix ' . $slider_nav_display . ' ' . $slider_dots_display . ' ' . $text_align;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass 	= str_replace('  ', ' ', trim($elemClass));
		
		if($bg_image != '' && is_numeric($bg_image)){
			$bg_image = wp_get_attachment_image_src( $bg_image, 'full') ;
			$bg_image = (false == $bg_image)? CATANIS_DEFAULT_IMAGE : $bg_image[0];
		}
		
		global $catanis;
		$custom_css = '';
		$selectID = '#' . $elemID;
		$custom_css .= $selectID . ' .content-slider-container .slides:before{ background-color:'. esc_attr($bg_overlay) .'; }';
		$custom_css .= $selectID . ' .content-slider-container .slick-list  li{ color:'. esc_attr($text_color) .'; }';
		$custom_css .= $selectID . ' .content-slider-container{ 
						height: '. esc_attr($slider_height) .'px;
		            	line-height: '. esc_attr($slider_height) .'px;
		            	background: url('. esc_url($bg_image) .') no-repeat center center;   
		}';
		$catanis->inlinestyle[] = $custom_css;
		
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		$arrParams = array(
			'autoplay' 			=> ( $slider_autoplay == 'yes') ? true : false ,
			'autoplaySpeed' 	=> $slider_duration*1000,
			'speed' 			=> 600,
			'infinite' 			=> true,
			'dots'				=> ($slider_dots_display != 'dots-none') ? true : false,
			'arrows'			=> ($slider_nav_display != 'nav-none') ? true : false,
			'useCSS' 			=> false,
			'rtl' 				=> CATANIS_RTL,
			'draggable' 		=> true
		);
	
		ob_start();
		?>
	    <div<?php echo rtrim($dir); ?> id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
	        <div class="content-slider-container">
	            <ul class="slides clearfix" data-slick='<?php echo json_encode($arrParams); ?>'>
	                <?php
	                foreach($slides as $key => $slide){
	
		                $title 		= $slide['slide_title_'.$key];
		                $subtitle 	= $slide['slide_subtitle_'.$key];
		                $decription = $slide['slide_description_'.$key];
		                
		                $btn					= $slide['btn_'.$key];
		                $btn_text 				= $slide['btn_text_'.$key];
		                $btn_style 				= $slide['btn_style_'.$key];
		                $btn_bg_color 			= $slide['btn_bg_color_'.$key];
		                $btn_text_color 		= $slide['btn_text_color_'.$key];
		                $btn_bg_color_hover 	= $slide['btn_bg_color_hover_'.$key];
		                $btn_text_color_hover 	= $slide['btn_text_color_hover_'.$key];
		                
		                $btn_shortcode = '[cata_button main_style="'. $btn_style .'" button_text="'. $btn_text .'"';
		                $btn_shortcode .= ' link="'. $btn .'" shape = "square" size ="nm"';
		                $btn_shortcode .= ' button_color = "'. $btn_bg_color .'" text_color = "'. $btn_text_color .'"';
		                $btn_shortcode .= ' button_color_hover = "'. $btn_bg_color_hover .'" text_color_hover = "'. $btn_text_color_hover .'"]';
	                ?>
	                <li>
	                    <div class="container">
	                    	<div class="content-inner">
	                    	<?php if(!empty($subtitle)): ?> 
	                        	<p class="slider-subtitle"><?php echo esc_html($subtitle)?></p>
	                        <?php endif; ?>
	                        
	                        <?php if(!empty($title)): ?> 
	                            <h3 class="slider-title"><?php echo esc_html($title)?></h3>
	                        <?php endif; ?>
	                        
	                        <?php if(!empty($decription)): ?> 
	                        	<div class="slider-description"><?php echo ($decription); ?></div>
	                        <?php endif; ?>
	                        
	                         <?php if(!empty($btn_text)): echo do_shortcode($btn_shortcode); endif; ?>
	                         </div>
	                    </div>
	                </li>
	                <?php
	                }
	                ?>
	            </ul>
	        </div>
	    </div>
	    <?php
	    return ob_get_clean();
	}
}
add_shortcode( 'cata_content_slider', 'catanis_content_slider_shortcode_function' );


/*=== SHORTCODE - COLUMN SLIDER ==============*/
/*============================================*/
if ( ! function_exists( 'catanis_columns_slider_shortcode_function' ) ) {
	function catanis_columns_slider_shortcode_function($atts, $content = null){
	
		$slide_num = $with_padding = $padding_value = $items_desktop = $items_desktop_small = $items_tablet = $slide_arrows = '';
		$slide_loop = $slide_dots = $slide_dots_style = $slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $ext_class = '';
		extract( shortcode_atts( array(
			'with_padding' 			=> 'yes',						/*NULL, yes*/
			'padding_value' 		=> '30',						/*10,20,30,40,50*/
			
			'items_desktop' 		=> '3',
			'items_desktop_small' 	=> '2',
			'items_tablet' 			=> '1',
			'slide_loop'			=> 'yes',
			'slide_arrows'			=> 'no',
			'slide_dots'			=> 'yes',
			'slide_dots_style'		=> 'dots-line', 		/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/
			'slide_autoplay'		=> 'no',
			'slide_autoplay_speed'	=> 3000,
			'slides_to_scroll'		=> 3,
			'slides_speed'			=> 500,
			'ext_class' 			=> ''
		), $atts ) );
	
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID = catanis_random_string(10, 'cata_columns_slider');
		$elemClass 	= 'cata-slick-slider cata-columns-slider cata-element clearfix' .' '. $slide_dots_style;
		$elemClass .= ($with_padding == 'yes') ? ' cata-slider-spacing' . absint($padding_value) : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$elemClass = str_replace('  ', ' ', trim($elemClass));
	
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		$arrParams = array(
			'autoplay' 			=> ($slide_autoplay == 'yes') ? true : false,
			'autoplaySpeed' 	=> intval($slide_autoplay_speed),
			'slidesToShow' 		=> intval($items_desktop),
			'slidesToScroll' 	=> intval($slides_to_scroll),
			'dots' 				=> ($slide_dots == 'yes')? true : false,
			'arrows' 			=> ($slide_arrows == 'yes')? true : false,
			'infinite' 			=> ($slide_loop == 'yes')? true : false,
			'draggable' 		=> true,
			'speed' 			=> intval($slides_speed),
			'rtl' 				=> CATANIS_RTL,
			'adaptiveHeight' 	=> true,
			'responsive'		=> array(
				array(
					'breakpoint'	=> 1024,
					'settings'		=> array(
						'slidesToShow'		=> intval($items_desktop_small),
						'slidesToScroll' 	=> intval($items_desktop_small)
					)
				),
				array(
					'breakpoint'	=> 768,
					'settings'		=> array(
						'slidesToShow'		=> intval($items_tablet),
						'slidesToScroll' 	=>  intval($items_tablet)
					)
				),
				array(
					'breakpoint'	=> 480,
					'settings'		=> array(
						'slidesToShow'		=> 1,
						'slidesToScroll' 	=> 1
					)
				),
			)
		);
		
		if($items_desktop == 1 && $items_desktop_small == 1 && $items_tablet == 1){
			$arrParams['fade'] = true;
			$arrParams['cssEase'] = 'linear';
		}

		ob_start();
		?>
	    <div<?php echo rtrim($dir); ?> id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
	        <div class="content-slider-container">
	            <ul class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
	              	<?php echo do_shortcode($content); ?>
	            </ul>
	        </div>
	    </div>
	    <?php
	    return ob_get_clean();
	}
}
add_shortcode( 'cata_columns_slider', 'catanis_columns_slider_shortcode_function' );


if ( ! function_exists( 'catanis_columns_slider_item_shortcode_function' ) ) {
	function catanis_columns_slider_item_shortcode_function($atts, $content = null){

		$slide_image = $slide_title = $slide_description = $slide_btntext = $slide_btnlink = '';
		extract( shortcode_atts( array(
			'slide_image' 			=> '',
			'slide_title' 			=> '',
			'slide_description' 	=> '',
			'slide_btntext'			=> '',
			'slide_btnlink'			=> '',
		), $atts ) );
		
		if(empty($slide_title)){
			return '';
		}
		if($slide_image != '' && is_numeric($slide_image)){
			$slide_image = wp_get_attachment_image_src( $slide_image, 'large') ;
			$slide_image = (false == $slide_image) ? CATANIS_DEFAULT_IMAGE : $slide_image[0];
		}
		ob_start();
		?>
                 <li class="cata-item">
                    <div>
	                    <div class="image-wrap">
							<img src="<?php echo esc_attr($slide_image); ?>" alt="<?php echo esc_attr($slide_title); ?>" />
							<span class="bgoverlay"></span>
						</div>
                        
                        <div class="ctent-wrap">
	                        <?php if(!empty($slide_title)): ?> 
	                            <h6 class="slider-title"><?php echo esc_attr($slide_title); ?></h6>
	                        <?php endif; ?>
	                        
	                        <?php if(!empty($slide_description)): ?> 
	                        	<p class="slider-description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',$slide_description); ?></p>
	                        <?php endif; ?>
	                        
	                        <?php if(!empty($slide_btntext)): ?> 
	                        	<a href="<?php echo esc_url($slide_btnlink); ?>" class="readmore" target="_blank" title="<?php echo esc_attr($slide_btntext); ?>"><?php echo esc_html($slide_btntext); ?></a>
	                        <?php endif; ?>
                        </div>
                         
                    </div>
                </li>
	              
	    <?php
	    return ob_get_clean();
	}
}
add_shortcode( 'cata_columns_slider_item', 'catanis_columns_slider_item_shortcode_function' );


	
/*=== SHORTCODE - CENTER SLIDER ==============*/
/*============================================*/
if ( ! function_exists( 'catanis_center_slider_shortcode_function' ) ) {
	function catanis_center_slider_shortcode_function($atts, $content = null){
	
		$slide_style = $slide_effect = $slide_arrows = $slide_loop = $slide_dots = $slide_dots_style = $slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $ext_class = '';
		extract( shortcode_atts( array(
			'slide_style' 			=> 'w-focus',
			'slide_effect' 			=> 'overlay',		/*overlay,grayscale*/
			'slide_loop'			=> 'yes',
			'slide_arrows'			=> 'no',
			'slide_dots'			=> 'yes',
			'slide_dots_style'		=> 'dots-line', 		/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/
			'slide_autoplay'		=> 'no',
			'slide_autoplay_speed'	=> 3000,
			'slides_to_scroll'		=> 3,
			'slides_speed'			=> 500,
			'ext_class' 			=> ''
		), $atts ) );
	
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID = catanis_random_string(10, 'cata_center_slider');
		$elemClass 	= 'cata-center-slider cata-slick-slider clearfix ' . $slide_style .' effect-'. $slide_effect . ' '. $slide_dots_style;
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$elemClass = str_replace('  ', ' ', trim($elemClass));
		
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		$arrParams = array(
			'centerMode' 		=> true,
			'centerPadding' 	=> '20%',
			'autoplay' 			=> ($slide_autoplay == 'yes') ? true : false,
			'autoplaySpeed' 	=> intval($slide_autoplay_speed),
			'slidesToShow' 		=> 1,
			'slidesToScroll'	=> 1,
			'dots' 				=> ($slide_dots == 'yes')? true : false,
			'arrows' 			=> ($slide_arrows == 'yes')? true : false,
			'infinite' 			=> ($slide_loop == 'yes')? true : false,
			'draggable' 		=> true,
			'speed' 			=> intval($slides_speed),
			'rtl' 				=> CATANIS_RTL,
			'adaptiveHeight' 	=> true,
			'responsive'		=> array(
				array(
					'breakpoint'	=> 1024,
					'settings'		=> array(
						'centerPadding' 	=> '30px',
						'slidesToShow' 		=> 1,
					)
				),
				array(
					'breakpoint'	=> 768,
					'settings'		=> array(
						'centerPadding' 	=> '20px',
						'slidesToShow' 		=> 1,
					)
				),
				array(
					'breakpoint'	=> 480,
					'settings'		=> array(
						'centerPadding' 	=> '10px',
						'slidesToShow' 		=> 1,
					)
				),
			)
		);

		ob_start();
		?>
	    <div<?php echo rtrim($dir); ?> id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
	        <div class="content-slider-container">
	            <ul class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
	              	<?php echo do_shortcode($content); ?>
	            </ul>
	        </div>
	    </div>
	    <?php
	    return ob_get_clean();
	}
}
add_shortcode( 'cata_center_slider', 'catanis_center_slider_shortcode_function' );

if ( ! function_exists( 'catanis_center_slider_item_shortcode_function' ) ) {
	function catanis_center_slider_item_shortcode_function($atts, $content = null){

		$slide_image = $slide_title = $slide_subtitle = $slide_animation = '';
		$btn = $btn_text = $btn_style = $outline_custom_color = $outline_custom_hover_bg = $outline_custom_hover_text = '';
		$btn_bg_color = $btn_text_color = $btn_bg_color_hover = $btn_text_color_hover = '';
		extract( shortcode_atts( array(
			'slide_image' 			 	=> '',
			'slide_title' 			 	=> 'Title',
			'slide_subtitle'			=> 'Sub Title',
			'slide_animation'			=> 'cata-fadeInLeft',
								
			'btn' 						=> '',			
			'btn_text' 					=> 'PURCHASE NOW',
			'btn_style' 				=> 'flat',
			'outline_custom_color' 		=> '#e49497',
			'outline_custom_hover_bg' 	=> '#e49497',
			'outline_custom_hover_text' => '#FFFFFF',
			'btn_bg_color' 				=> '#e49497',
			'btn_text_color' 			=> '#FFFFFF',
			'btn_bg_color_hover' 		=> '#dfa1a3',
			'btn_text_color_hover' 		=> '#FFFFFF',
		
		), $atts ) );
		
		if(empty($slide_image)){
			return '';
		}
		
		if($slide_image != '' && is_numeric($slide_image)){
			$slide_image = wp_get_attachment_image_src( $slide_image, 'large') ;
			$slide_image = (false == $slide_image) ? CATANIS_DEFAULT_IMAGE : $slide_image[0];
		}
		
		$btn_shortcode = '[cata_button main_style="'. $btn_style .'" button_text="'. $btn_text .'"';
		$btn_shortcode .= ' link="'. $btn .'" shape = "square" size ="nm"';
		$btn_shortcode .= ' outline_custom_color="'. $outline_custom_color .'" outline_custom_hover_bg = "'. $outline_custom_hover_bg .'" outline_custom_hover_text ="'. $outline_custom_hover_text .'"';
		$btn_shortcode .= ' button_color = "'. $btn_bg_color .'" text_color = "'. $btn_text_color .'"';
		$btn_shortcode .= ' button_color_hover = "'. $btn_bg_color_hover .'" text_color_hover = "'. $btn_text_color_hover .'"]';

		ob_start();
	    ?>
		<li class="cata-item">
        	<div>
	        	<div class="image-wrap">
					<img src="<?php echo esc_attr($slide_image); ?>" alt="<?php echo esc_attr($slide_title); ?>" />
					<span class="bgoverlay"></span>
				</div>
                        
                <div class="ctent-wrap">
                	<div class="<?php echo esc_attr($slide_animation); ?>">
                        	
	                    <?php if(!empty($slide_subtitle)): ?> 
                        	<p class="slider-subtitle"><?php echo esc_attr($slide_subtitle)?></p>
                        <?php endif; ?>
                        
		                <?php if(!empty($slide_title)): ?> 
                            <h6 class="slider-title"><?php echo esc_attr($slide_title); ?></h6>
                        <?php endif; ?>
                        
                        <?php if(!empty($btn_text)): echo do_shortcode($btn_shortcode); endif; ?>
	            	</div>
            	</div>
        	</div>
		</li>
	    <?php
	    return ob_get_clean();
	}
}
add_shortcode( 'cata_center_slider_item', 'catanis_center_slider_item_shortcode_function' );


/*=== SHORTCODE - TIMELINE ===================*/
/*============================================*/
if ( ! function_exists( 'catanis_timeline_shortcode_function' ) ) {
	function catanis_timeline_shortcode_function($atts, $content = null){
		global $timeline_style;
		$main_style = $ext_class = '';
		extract( shortcode_atts( array(
			'main_style' 			=> 'style1',
			'ext_class' 			=> ''
		), $atts ) );

		$timeline_style = $main_style;
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID = catanis_random_string(10, 'cata_timeline');
		$elemClass 	= 'cata-timeline clearfix cata-' . $main_style;
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		$elemClass = str_replace('  ', ' ', trim($elemClass));
		
		ob_start();
		?>
	    <div id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
	    	<div class="cata-timeline-top"></div>
	        <div class="cata-content-wrapper">
	              <?php echo do_shortcode($content); ?>
	        </div>
	        <div class="cata-timeline-bottom"></div>
	    </div>
	    <?php
	    return ob_get_clean();
	}
}
add_shortcode( 'cata_timeline', 'catanis_timeline_shortcode_function' );

if ( ! function_exists( 'catanis_timeline_item_shortcode_function' ) ) {
	function catanis_timeline_item_shortcode_function($atts, $content = null){
		global $timeline_style;
		$xhtml = $item_style = $item_youtube_url = $item_mp3_url = $item_title = $item_date = $item_description = $icon = $item_bg = $img_hover_effect = $btn_link = '';
		$use_google_fonts = $google_fonts = $font_container = $margin_top = $margin_right = $margin_bottom = $margin_left = '';
		extract( shortcode_atts( array(
			'item_style' 			 => 'image',		/*image,video,audio*/
			'item_youtube_url' 		=> '',
			'item_mp3_url'			=> '',
			'item_title'			=> '',
			'item_date'				=> '',
			'item_description'		=> '',
			'icon'					=> 'flaticon-bells',
			'item_bg'				=> '',
			'img_hover_effect'		=> 'effect-inner-shadow-2',
			'btn_link'				=> '',
			'use_google_fonts'		=> '',
			'google_fonts'			=> '',
			'font_container'		=> '',
			'margin_top'			=> '',
			'margin_right'			=> '',
			'margin_bottom'			=> '',
			'margin_left'			=> '',
		), $atts ) );
		
		$elemClass 	= 'cata-item';
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		
		$img_shortcode = '';
		if($item_bg != '' && is_numeric($item_bg)){
			$image_overlay = wp_get_attachment_image_src( $item_bg, 'large') ;
			$image_overlay = (false == $image_overlay) ? CATANIS_DEFAULT_IMAGE : $image_overlay[0];
		}
		
		$tl_style = '';
		if($item_style == 'video'){
			$tl_style = $tl_style = do_shortcode('[cata_video video_style="popup" video_host="youtube" image_overlay="'. $image_overlay .'" video_url_youtube="'. $item_youtube_url .'"]');
		}elseif($item_style == 'audio'){
			$tl_style .= '<div class="cata-audio-mp3">' . do_shortcode('[audio preload="auto" src="'. $item_mp3_url.'"]') . '</div>';
			$tl_style .= catanis_post_thumbnail($image_overlay);
		}else{
			if($item_bg != '' && is_numeric($item_bg)){
				$tl_style = do_shortcode('[cata_single_image image="'. $item_bg .'" hover_effect="'. $img_hover_effect .'" img_align="img-center" img_size="full"]');
			}
		}
		
		/*Timeline Date*/
		$date = date_create($item_date);
		$item_date = date_format($date, get_option('date_format'));
		
		$btn_align = ( $timeline_style == 'style3' ) ? 'left' : 'center';
		$btn_shortcode = '[cata_button_link main_style="border-bottom" link_text=""';
		$btn_shortcode .= ' link="'. $btn_link .'" align="'. $btn_align .'" margin_top="20px"';
		$btn_shortcode .= ' border_color="#e49497" text_color="#1A1A1A"';
		$btn_shortcode .= ' boder_color_hover="#dfa1a3" text_color_hover="#1A1A1A"]';
		
		/* Custom CSS */
		$title_style = '';
		$title_style .= ($margin_top) ? 'margin-top:'. $margin_top .';' : '';
		$title_style .= ($margin_right) ? 'margin-right:'. $margin_right .';' : '';
		$title_style .= ($margin_bottom) ? 'margin-bottom:'. $margin_bottom .';' : '';
		$title_style .= ($margin_left) ? 'margin-left:'. $margin_left .';' : '';
		
		$title_style = str_replace(';', '|', $title_style);
		$font_data = catanis_parse_text_style_for_googlefont( $title_style.$font_container, '', $use_google_fonts, $google_fonts );
		
		ob_start();
		?>
		<div class="<?php echo esc_attr($elemClass); ?>" <?php echo trim($animation['animation-attrs']); ?>>
			<div class="cata-timeline-icon">
				<span class="<?php echo esc_html($icon); ?>"></span>
			</div> 
 
			<div class="cata-timeline-content">
				<?php 
				if( $timeline_style == 'style2' ) {	
	
					if(!empty($item_title)):
						$xhtml .= '<h4 '. $font_data['style'] .'>'. esc_attr($item_title) .'</h4>';
					endif;
						
					if(!empty($item_date)):
						$xhtml .= '<span class="cata-date">'. esc_attr($item_date) .'</span>';
					endif;
					
					if(!empty($tl_style)):
						$xhtml .= '<div class="image-wrap">'. trim($tl_style) .'</div>';
					endif;
					
					if(!empty($item_description)): 
                		$xhtml .= '<p class="cata-desc">'. trim($item_description) .'</p>';
                	endif;
                
                	if(strlen($btn_link)>3):
                		$xhtml .= do_shortcode($btn_shortcode);
                	endif;
					
				}elseif( in_array($timeline_style, array('style1', 'style3')) ) {
					
					if(!empty($tl_style)):
						$xhtml .= '<div class="image-wrap">'. trim($tl_style) .'</div>';
					endif;
					
					if( $timeline_style == 'style3' ):
						$xhtml .= '<div class="content-wrap">';
					endif;
					
					if(!empty($item_title)):
						$xhtml .= '<h4 '. $font_data['style'] .'>'. esc_attr($item_title) .'</h4>';
					endif;
						
					if(!empty($item_date)):
						$xhtml .= '<span class="cata-date">'. esc_attr($item_date) .'</span>';
					endif;
				
					if(!empty($item_description)):
						$xhtml .= '<p class="cata-desc">'. trim($item_description) .'</p>';
					endif;
					 
					if(strlen($btn_link)>3):
						$xhtml .= do_shortcode($btn_shortcode);
					endif;
					
					if( $timeline_style == 'style3' ):
						$xhtml .= '</div>';
					endif;
					
				}else{}
				
				echo trim($xhtml);
				?>
			</div> 
		</div> 
	    <?php
	    return ob_get_clean();
	}
}
add_shortcode( 'cata_timeline_item', 'catanis_timeline_item_shortcode_function' );


/*=== SHORTCODE - SOUNDCLOUD  ================*/
/*============================================*/
if ( ! function_exists( 'catanis_soundcloud_shortcode_function' ) ) {
	function catanis_soundcloud_shortcode_function( $atts, $url='' ) {

		$url = $params = $height = $width = $iframe = '';
		extract( shortcode_atts( array(
			'url' 		=> 'http://',
			'params' 	=> 'color=ff6600&auto_play=false&show_artwork=false',
			'height' 	=> '166',
			'width'  	=> '100%',
			'iframe' 	=> 'true'
		), $atts ) );

		$encoded_url = urlencode( $url );

		return '<p><iframe width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='. $encoded_url . '?' . $params . '"></iframe></p>';
	}
}
add_shortcode( "soundcloud", "catanis_soundcloud_shortcode_function" );
add_shortcode( "cata_soundcloud", "catanis_soundcloud_shortcode_function" );

?>