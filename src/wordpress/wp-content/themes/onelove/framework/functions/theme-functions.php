<?php 
/*==============================================================================
 * GENERAL FUNCTIONS
 *==============================================================================*/
if ( ! function_exists( 'catanis_is_woocommerce_active' ) ) {
	/**
	 * Check WooCommerce plugin active
	 *
	 * @return boolean true or false
	 */
	function catanis_is_woocommerce_active() {
		$activated = false;
		if ( is_multisite() ) {
			$active_plugins = get_site_option( 'active_sitewide_plugins' ) ;
			if ( class_exists( 'Multilingual_Press' ) || ( ! empty( $active_plugins ) && isset( $active_plugins['woocommerce/woocommerce.php'] ) ) ) {
				$activated = true;
			}
			
		}else{
			$activated = in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		}

		return $activated;
	}
}

if ( ! function_exists( 'catanis_is_wooCompare_active' ) ) {
	/**
	 * Check Woo Compare plugin active
	 *
	 * @return boolean true or false
	 */
	function catanis_is_wooCompare_active(){
		$actived = false;
		if ( class_exists( 'YITH_Woocompare_Frontend') && defined( 'YITH_WOOCOMPARE' ) ) {
			$actived = true;
		}
		return $actived;
	}
}

if ( ! function_exists( 'catanis_is_contactForm7_active' ) ) {
	/**
	 * Check Contact Form 7 plugin active
	 *
	 * @return boolean true or false
	 */
	function catanis_is_contactForm7_active() {
		
		$actived = false;
		if ( class_exists( 'WPCF7_ContactForm' ) || defined( 'WPCF7_PLUGIN' ) ) {
			$actived = true;
		}
		
		return $actived;
	}
}

if ( ! function_exists( 'catanis_is_wooWishlist_active' ) ) {
	/**
	 * Check Woo Wishlist plugin active
	 *
	 * @return boolean true or false
	 */
	function catanis_is_wooWishlist_active(){
		$actived = false;
		if ( class_exists( 'YITH_WCWL_UI' ) && class_exists( 'YITH_WCWL' ) ) {
			$actived = true;
		}
		return $actived;
	}
}

if ( ! function_exists( 'catanis_is_gridlistToggle_active' ) ) {
	/**
	 * Check Grid List Toggle plugin active
	 *
	 * @return boolean true or false
	 */
	function catanis_is_gridlistToggle_active(){
		$actived = false;
		if ( in_array( "woocommerce-grid-list-toggle/grid-list-toggle.php", apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$actived = true;
		}

		return $actived;
	}
}

if ( ! function_exists( 'catanis_is_visualcomposer_active' ) ) {
	/**
	 * Check Visual Composer plugin active
	 * 
	 * @return boolean true or false
	 */
	function catanis_is_visualcomposer_active(){
		$actived = false;
		if ( class_exists( 'Vc_Manager' ) && class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
			$actived = true;
		}
		return $actived;
	}
}

if ( ! function_exists( 'catanis_check_revolution_exists' ) ) {
	/**
	 * Check Revolution slider plugin exists
	 *
	 * @return boolean true or false
	 */
	function catanis_check_revolution_exists() {
		return ( class_exists( 'RevSlider' ) && class_exists( 'UniteFunctionsRev' ) );
	}
}

if ( ! function_exists( 'catanis_check_layerslider_exists' ) ) {
	/**
	 * Check Layer slider plugin exists
	 *
	 * @return boolean true or false
	 */
	function catanis_check_layerslider_exists() {
		return class_exists( 'LS_Sliders' );
	}
}
if ( ! function_exists( 'catanis_check_cataniscore_exists' ) ) {
	/**
	 * Check Catanis Core plugin exists
	 *
	 * @return boolean true or false
	 */
	function catanis_check_cataniscore_exists() {
		return class_exists( 'Catanis_Core_Plugin' );
	}
}

if ( ! function_exists( 'catanis_option' ) ) {
	/**
	 * Gets an option from the options panel by its key.
	 *
	 * @param string  $option the option ID
	 * @return the option value. If there isn't a value set, returns the default value for the option.
	 */
	function catanis_option( $option = null ) {
		global $catanis;
		if ( $option != null ){
			$val = $catanis->options->get_value( $option );
			if ( is_string( $val ) && $option != 'custom_css' ) {
				$val = stripslashes( trim($val) );
			}
		}else{
			$val = $catanis->options->get_alloption_saved();
		}
		
		return $val;
	}
}

if ( ! function_exists( 'catanis_check_option_bool' ) ) {
	/**
	 * Ways to evaluate a string 'False' as boolean False in PHP
	 *
	 * @param string  $option the option
	 * @return the bool value (true or false)
	 * 
	 * Important thing to remember with using this method is that it returns TRUE 
	 * only for "1", "true", "on" and "yes", everything else returns FALSE.
	 */
	function catanis_check_option_bool( $option ) {
		return filter_var( $option , FILTER_VALIDATE_BOOLEAN);
	}
}

if ( ! function_exists( 'catanis_check_using_google_font' ) ) {
	/**
	 * Check using google font in option panel
	 *
	 * @param string  $fontName the font name to check
	 * @return boolean $flagCheck, true: using, false: not using
	 */
	function catanis_check_using_google_font( $fontName = null ) {
		$flagCheck = false;
		$googleFonts = Catanis_Default_Data::themeFonts( array( 'google' ), false );
		if ( $fontName != null && count( $googleFonts ) > 0 ) {
			foreach ( $googleFonts as $font ) {
				if ( $font['name'] == $fontName ) {
					$flagCheck = true;
					break;
				}
			}
		}
		
		return $flagCheck;
	}
}

if ( ! function_exists( 'catanis_set_post_views' ) ) {
	/**
	 * Set a meta to count post view
	 *
	 * @param int $postID post ID
	 * @return void
	 */
	function catanis_set_post_views($postID) {
		$count_key = '_cata_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
}

if ( ! function_exists( 'catanis_get_post_views' ) ) {
	/**
	 * Get count view of a post
	 *
	 * @param int $postID
	 * @return string
	 */
	function catanis_get_post_views($postID){
		$count_key = '_cata_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if( $count == '' ) {
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return esc_html__('0 View', 'onelove');
		}
		return $count . ' ' . esc_html__('Views', 'onelove');
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


if ( ! function_exists( 'catanis_get_categories' ) ) {
	/**
	 * Gets the post categories.
	 *
	 * @return array containing the categories with keys id containing the category ID
	 * and name containing the category name.
	 */
	function catanis_get_categories() {
		global $catanis;

		if ( !isset( $catanis->categories ) ) {
			$categories = get_categories( 'hide_empty=0' );
			$catanis_categories = array();
			
			for ( $i=0; $i < sizeof( $categories ); $i++ ) {
				$catanis_categories[] = array( 
					'id' 	=> $categories[$i]->cat_ID, 
					'name' 	=> $categories[$i]->cat_name 
				);
			}
			$catanis->categories = $catanis_categories;
		}

		return $catanis->categories;
	}
}

if ( ! function_exists('catanis_get_resized_image')) {

	/**
	 * Gets the URL for a Timthumb resized image.
	 *
	 * @param string  $imgurl the original image URL
	 * @param string  $width  the width to which the image will be cropped
	 * @param string  $height the height to which the image will be cropped
	 * @param string  $crop whether to crop the image to exact proportions
	 * @return string the URL of the image resized with Timthumb
	 */
	function catanis_get_resized_image( $imgurl, $width, $height='', $crop = false, $increase_size = false ) {
		if ( $height && !$crop ){
			$crop = true;
		}
		$width = (int)$width;
		$height = (int)$height;

		if ( $increase_size ){
			$new_width = $width+150;
			$new_height = $new_width*$height/$width;
		}else{
			$new_width = $width;
			$new_height = $height;
		}

		$resized_img = aq_resize( $imgurl, $new_width, $new_height, $crop, true, true );

		/* If the Aqua Resizer script could not crop the image, return the original image */
		if ( !$resized_img ){
			$resized_img = $imgurl;
		}

		return $resized_img;
	}
}

if ( ! function_exists('catanis_get_image_sizes' ) ) {
	/**
	 * Retrive a image size
	 * 
	 * @param string $size image size
	 * @return array
	 */
	function catanis_get_image_sizes( $size = '' ) {
	
		global $_wp_additional_image_sizes;
	
		$sizes = array();
		$get_intermediate_image_sizes = get_intermediate_image_sizes();
	
		/* Create the full array with sizes and crop info */
		foreach ( $get_intermediate_image_sizes as $_size ) {
	
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
	
				$sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
				$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
				$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
	
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
	
				$sizes[ $_size ] = array(
					'width' 	=> $_wp_additional_image_sizes[ $_size ]['width'],
					'height' 	=> $_wp_additional_image_sizes[ $_size ]['height'],
					'crop' 		=>  $_wp_additional_image_sizes[ $_size ]['crop']
				);
			}
		}
	
		/* Get only 1 size if found */
		if ( $size ) {
			if ( isset( $sizes[ $size ] ) ) {
				return $sizes[ $size ];
			} else {
				return false;
			}
		}
	
		return $sizes;
	}
}

if ( ! function_exists( 'catanis_cache_content' ) ) {
	/**
	 * Put content css to a file
	 * 
	 * @param string $file_save file path
	 * @param string $file_content content of file
	 * @return void
	 */
	function catanis_cache_content($file_save, $file_content) {
		
		ob_start();
		include $file_content;
		$dynamic_css = ob_get_contents();
		ob_get_clean();
			
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}
		
		$credentials = request_filesystem_credentials($file_save, '', false, false, array());
		if( ! WP_Filesystem( $credentials ) ){
			return false;
		}
			
		if ( $wp_filesystem ) {
			$wp_filesystem->put_contents(
				$file_save,
				$dynamic_css,
				FS_CHMOD_FILE 
			);
		}
		
	}
}

if ( ! function_exists( 'catanis_get_video_html' ) ) {

	/**
	 * Generates a video HTML. For Flash videos uses the standard flash embed code
	 * and for other videos uses the WordPress embed tag.
	 *
	 * @param string  $video_url the URL of the video
	 * @param string  $width     the width to set to the video
	 * @return html
	 */
	function catanis_get_video_html( $video_url, $width, $embed_args = array() ) {
		$video_html = '';

		if ( strstr( $video_url, '.swf' ) ) {
			$video_html .= '<div class="cata-video-html"><OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
			WIDTH="'.$width.'" id="catanis-flash" ALIGN=""><PARAM NAME=movie VALUE="' . $video_url . '">
			<PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#333399> <EMBED src="' . $video_url . '"
			quality=high bgcolor=#333399 WIDTH="' . $width . '" NAME="catanis-flash" ALIGN=""
			TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
			</EMBED> </OBJECT></div>';
		} else {
			
			if ( empty( $width ) ) {
				$width = isset( $content_width ) ? $content_width : 580;
			}
			
			$default_args = array(
				'title' 		=> 0,
				'byline' 		=> 0,
				'portrait' 		=> 0,
				'color' 		=> 'eb145b',
				'width' 		=> $width,
				'autoplay' 		=> 0,
				'showinfo' 		=> 0,
				'rel' 			=> 0,
				'player_id' 	=> 'player_' . mt_rand()
			);
			$options = (!empty($embed_args) && count($embed_args)> 0) ? array_merge($default_args, $embed_args) : $default_args;
			$video_html .= '<div class="cata-video-html">' . wp_oembed_get( $video_url , $options ) . '</div>';
		}

		return $video_html;
	}
}

if ( ! function_exists( 'catanis_list_hooked' ) ) {
	/**
	 * Dssplay all action in a hook
	 * 
	 * @param string $tag hood to get an display
	 * @return array
	 */
	function catanis_list_hooked( $tag = false ) {
		global $wp_filter;
		if ( $tag ) {
			$hook[$tag] = $wp_filter[$tag];
			if ( !is_array($hook[$tag] ) ) {
				trigger_error( "Nothing found for '$tag' hook", E_USER_WARNING );
				return;
			}
		}
		else {
			$hook = $wp_filter;
			ksort( $hook );
		}
	
		echo '<div id="list-hook">';
		foreach ( $hook as $tag => $priority ){
			echo "<br />Hook Name: <strong>$tag</strong><br />";
			ksort( $priority );
			foreach ( $priority as $priority => $function ) {
				$comma_flag = 0;
				echo ($priority.": ");
				foreach ( $function as $name => $properties ) {
					if ( $comma_flag > 0 ) {
						echo ", ";
					}
					echo "$name";
					$comma_flag++;
				}
				echo "<br />";
			}
		}
		echo '</div>';
		return;
	}
}

if ( ! function_exists( 'catanis_get_address' ) ) {
	function catanis_get_address() {
		/* return the full address */
		return catanis_get_protocal().'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	} 
}

if ( ! function_exists( 'catanis_get_protocal' ) ) {
	/**
	 * Get protocal of link
	 * 
	 * @return string
	 */
	function catanis_get_protocal() {
		return is_ssl() ? 'https' : 'http';
	}
}

if ( ! function_exists( 'catanis_check_video_type' ) ) {
	/**
	 * Check link video yourtube or vimeo or other
	 * 
	 * @param string $url : link youtube, video or...
	 * @return string 
	 */
	function catanis_check_video_type( $url ) {
		
		if ( preg_match( '/youtu\.be/i', $url ) || preg_match( '/youtube\.com\/watch/i', $url ) ) {
			return 'youtube';
		}elseif ( preg_match( '/vimeo\.com/i', $url ) ) {
			return 'vimeo';
		}else{
			return '';
		}
		
	}
}

if ( ! function_exists( 'catanis_check_http_and_https_from_link' ) ) {
	/**
	 * Check protocal for a link
	 * 
	 * @param string $link
	 * @return boolean
	 */
	function catanis_check_http_and_https_from_link( $link ) {
		return ( preg_match( '#^https?://#i', $link ) === 1 );
	}
}

if ( ! function_exists( 'relativeTime' ) ) {
	/**
	 * Convert date to real time
	 * 
	 * @param date $time
	 * @return string
	 */
	function relativeTime( $time ) {
		$second = 1;
		$minute = 60 * $second;
		$hour = 60 * $minute;
		$day = 24 * $hour;
		$month = 30 * $day;
	
		$delta = strtotime('+0 hours') - strtotime( $time );
		if ($delta < 2 * $minute) {
			return "1 min ago";
		}
		if ($delta < 45 * $minute) {
			return floor($delta / $minute) . " min ago";
		}
		if ($delta < 90 * $minute) {
			return "1 hour ago";
		}
		if ($delta < 24 * $hour) {
			return floor($delta / $hour) . " hours ago";
		}
		if ($delta < 48 * $hour) {
			return "yesterday";
		}
		if ($delta < 30 * $day) {
			return floor($delta / $day) . " days ago";
		}
		if ($delta < 12 * $month) {
			$months = floor($delta / $day / 30);
			return $months <= 1 ? "1 month ago" : $months . " months ago";
		} else {
			$years = floor($delta / $day / 365);
			return $years <= 1 ? "1 year ago" : $years . " years ago";
		}
	}
}

if ( ! function_exists( 'catanis_string_limit_words' ) ) {
	/**
	 * Limit word for a string
	 * 
	 * @param string $string string that limit word
	 * @param int $word_limit number to set limt
	 * @return string
	 */
	function catanis_string_limit_words( $string, $word_limit, $btn_viewmore = '' ) {
		$xhtml = '';
		$words = explode( ' ', $string );
		$xhtml = implode( " ",array_splice( $words, 0, $word_limit ) ) ;
		
		if ( !empty($btn_viewmore) ) {
			$xhtml .= $btn_viewmore;
		}
		
		return $xhtml;
	}
}

if ( ! function_exists ( 'catanis_get_the_excerpt_max_words' ) ) {
	/**
	 * Get excerpt max word for post
	 * 
	 * @param int $word_limit  number to set limt 
	 * @param object $post Post object
	 * @param boolean $echo true or false
	 * @param boolean $strip_tags true or false
	 * @return string
	 */
	function catanis_get_the_excerpt_max_words( $word_limit = -1, $post = null, $echo = true, $strip_tags = true, $extra_str = '') {
		
		if ( $post != null ){
			$excerpt = catanis_get_the_excerpt_sql( $post->ID );
		}else{
			$excerpt = get_the_excerpt();
		}
			
		if ( $strip_tags ){
			$excerpt = wp_strip_all_tags( $excerpt );
			$excerpt = strip_shortcodes( $excerpt );
		}
		
		if ( $word_limit != -1 ){
			$result = catanis_string_limit_words( $excerpt, $word_limit );
		}else{
			$result = $excerpt;
		}
			
		$result .= $extra_str;
		
		if ( $echo ) {
			echo wp_kses_post(do_shortcode($result));
		}else{
			return wp_kses_post(do_shortcode($result));
		}
		
	}
}

if ( ! function_exists ( 'catanis_custom_excerpt' ) ) {
	/**
	 * Get custom excerpt with length and new more
	 * 
	 * @param int $new_length
	 * @param string $new_more
	 * @return string
	 */
	function catanis_custom_excerpt($new_length = 20, $new_more = '...') {

		$limit = $new_length+1;
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
			array_pop($excerpt);
			$excerpt = implode(" ",$excerpt) . $new_more;
		} else {
			$excerpt = implode(" ",$excerpt);
		}
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		
		echo wp_kses_post($excerpt);
	
	}
}

if ( ! function_exists ( 'catanis_trim_excerpt' ) ) {
	/**
	 * Limit for text with number limit
	 * 
	 * @param string $text string text
	 * @param int $limit number limit string
	 * @return string
	 */
	function catanis_trim_excerpt( $text = '', $limit = 55) {
		$text = strip_shortcodes( $text );
		$text = apply_filters( 'the_content', $text );
		$text = str_replace( ']]>', ']]&gt;', $text );
		$excerpt_length = apply_filters( 'excerpt_length', $limit );
		$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );
		
		return wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
}


if ( !function_exists( 'catanis_get_the_excerpt_sql' ) ) {
	/**
	 * Retive excerpt from databse with post ID
	 * 
	 * @param int $post_id post ID
	 * @return string
	 */
	function catanis_get_the_excerpt_sql( $post_id ) {
		global $wpdb;
		$query = "SELECT post_excerpt, post_content FROM $wpdb->posts WHERE ID = %d LIMIT 1";
		$result = $wpdb->get_results( $wpdb->prepare($query, $post_id), ARRAY_A );
		
		if ( $result[0]['post_excerpt'] ){
			return $result[0]['post_excerpt'];
		}else{
			return $result[0]['post_content'];
		}
	}
}

if ( ! function_exists( 'catanis_pagination' ) ) {
	/**
	 * Generates the user pagination for custom and default loops
	 * 
 	 * @param object $query used within a custom loop
 	 * @return html
	 */
	function catanis_pagination( $query = null) {
		global $wp_rewrite;
		if ( !$query ) {
			global $wp_query;
			$query = $wp_query;
		}
		
		if(is_front_page()) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		}else {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}
		
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );
		
		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}
		
		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
		
		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
		
		$page_format = paginate_links( array(
			'base' 			=> $pagenum_link,
			'format' 		=> $format,
			'add_args' 		=> array_map( 'urlencode', $query_args ),
			'current' 		=> max( 1, $paged ),
			'total' 		=> $query->max_num_pages,
			'type'  		=> 'array',
			'end_size'     	=> 3,
			'mid_size'     	=> 3,
			'prev_text'    	=> '&larr;',
			'next_text'    	=> '&rarr;'
		) );
	
		if ( is_array( $page_format ) ) {
			echo '<div class="cata-pagination cata-has-animation cata-fadeInUp"><div class="cata-heart-line"></div><ul>';
			foreach ( $page_format as $page ) {
				echo "<li>$page</li>";
			}
			echo '</ul></div>';
		}
	}
}


if ( !function_exists( 'catanis_pagination_nextprev' ) ) {
	function catanis_pagination_nextprev( $query = '') {

		$xhtml = '';
		if ( !$query ) {
			global $wp_query;
			$query = $wp_query;
		}

 		if ( $query->max_num_pages > 1 ) {
			$xhtml .= '<div class="cata-pagination cata-pagination-nextprev cata-has-animation cata-fadeInUp"><div class="cata-heart-line"></div>';
			$xhtml .= '<div class="alignleft newer-posts">';
			$xhtml .= get_previous_posts_link('<i class="fa fa-angle-left"></i> '. esc_html__( 'Newer Posts', 'onelove' ) );
			$xhtml .= '</div>';
			$xhtml .= '<div class="alignright older-posts">';
			$xhtml .= get_next_posts_link( esc_html__( 'Older Posts', 'onelove' ) .' <i class="fa fa-angle-right"></i>', $query->max_num_pages);
			$xhtml .= '</div>';
			$xhtml .= '</div>';
		}

		echo ($xhtml);
	}
}

if ( ! function_exists( 'catanis_post_thumbnail' ) ) {
	/**
	 * Displays an optional post thumbnail.
	 * (Wraps the post thumbnail in an anchor element on index views, or a div element when on single views.)
	 */
	function catanis_post_thumbnail($post_thumb_url = '') {
		global $post;
		
		$xhtml = '';
		if(empty($post_thumb_url)){
			if ( has_post_thumbnail() && ! post_password_required() ){
				$thumbnail_url = catanis_get_featured_image_url($post);
			}
		}else{
			$thumbnail_url = $post_thumb_url;
		}
		$title = strip_tags(get_the_title());

		if(!empty($thumbnail_url)) {
			if ( !is_single() ) {
				$xhtml .= '<a href="'. get_the_permalink() .'" title="'. esc_attr($title) .'">';
			}
			
			$xhtml 	.= '<figure class="entry-thumbnail">
							<img src="'. esc_url($thumbnail_url) .'" class="attachment-post-thumbnail wp-post-image" alt="'. esc_attr($title) .'">
						</figure>';
			
			if ( !is_single() ) {
				$xhtml .= '</a>';
			}
		}
		
		return $xhtml;
	}
}

if ( ! function_exists( 'catanis_post_thumbnail_video_grid' ) ) {
	/**
	 * Displays an optional post thumbnail for video grid.
	 * (Wraps the post thumbnail in an anchor element on index views, or a div element when on single views.)
	 */
	function catanis_post_thumbnail_video_grid($video_url, $post_thumb_url) {
		
		$title = get_the_title();
		if(empty($post_thumb_url)) {
			$post_thumb_url = CATANIS_DEFAULT_IMAGE;
		}
		
		if ( !is_single() ) {
			$xhtml .= '<a href="'. esc_attr($video_url) .'" class="fresco" data-fresco-options="width: 860, height:480" title="'. esc_attr($title) .'">';
		}
			
		$xhtml 	.= '<figure class="entry-thumbnail">
						<img src="'. esc_url($post_thumb_url) .'" class="attachment-post-thumbnail wp-post-image" alt="'. esc_attr($title) .'">
						<span class="video-control"></span>
					</figure>';
		
		if ( !is_single() ) {
			$xhtml .= '</a>';
		}
		
		return $xhtml;

	}
}


if ( ! function_exists( 'catanis_post_meta' ) ) {
	/**
	 * Display meta information for a specific post.
	 *
	 * @return html
	 */
	function catanis_post_meta($options = array()) {
		global $catanis, $post;
		
		/*Use settings in theme options*/
		if( empty($options)){
			$_config_opts = catanis_option('blog_exclude_sections');
			if ( !is_array( $_config_opts )){
				$options = explode(',', $_config_opts);
			}else{
				$options = $_config_opts;
			}
		}

		echo '<ul class="list-inline entry-meta">';
		if ( get_post_type() === 'post' ) {
			$seperate_li = '<li class="meta-seperate"></li>';
			
			if ( is_sticky() ) {
				echo '<li class="meta-featured-post"><i class="fa fa-thumb-tack"></i> ' . esc_html__( 'Sticky', 'onelove' ) . ' </li> ' . $seperate_li;
			}

			if(in_array('date', $options)):
				echo '<li class="meta-date"> ' . get_the_date() . ' </li>' . $seperate_li;
			endif;

			if(in_array('author', $options)):
				printf(
					'<li class="meta-author">'. esc_html__('By','onelove') .' <a href="%1$s" rel="author">%2$s</a></li>'. $seperate_li,
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					get_the_author()
				);
			endif;
			
			if(in_array('category', $options)):
				$category_list = get_the_category_list( ', ' );
				if ( $category_list ) {
					echo '<li class="meta-categories"><span>'. esc_html__( 'In', 'onelove' ) .'</span>' .$category_list .'</li>' .$seperate_li;
				}
			endif;
			
			if ( in_array('comments', $options)) :
				echo '<li class="meta-comments">';
					echo '<span class="fa fa-comment">';
						comments_popup_link( '0', '1', esc_html__( '% Comments', 'onelove' ) );
					echo '</span>';
				echo '</li>' .$seperate_li;
			endif;
				
			/* Love */
			if(in_array('love', $options)):
				echo '<li class="meta-love">'. $catanis->love->get_love(true) .'</li>';
			endif;

		}
		echo '</ul>';
	}
}

if ( ! function_exists( 'catanis_entry_taxonomies' ) ) :
	/**
	 * Prints HTML with category and tags for current post.
	 * Create your own catanis_entry_taxonomies() function to override in a child theme.
	 * 
	 * @return html
	 */
	function catanis_entry_taxonomies($taxonomy) {
	
		if( $taxonomy == 'category' ):
			$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'onelove' ) );
			if ( $categories_list ) {
				printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Categories', 'Used before category names.', 'onelove' ), $categories_list );
			}
		endif;
		
		if( $taxonomy == 'tags' ):
			$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'onelove') );
			if ( $tags_list ) {
				printf( '<span class="tags-links"><i class="fa fa-bookmark"></i>%2$s</span>',
				_x( 'Tags', 'Used before tag names.', 'onelove' ), $tags_list );
			}
		endif;
	}
endif;

if ( ! function_exists( 'catanis_get_post_format_in_loop' ) ) {
	/**
	 * Display post content with post format
	 *
	 * @return html
	 */
	function catanis_get_post_format_in_loop($format, $post_style, $post_meta, $echo = true){
		
		global $post;
		$xhtml = '';
		
		if( !empty($post_meta['post_custom_thumbnail']) ){
			if( isset($post_meta['post_custom_thumbnail_id']) ){
				$post_thumb_url 	= wp_get_attachment_image_src( $post_meta['post_custom_thumbnail_id'], 'large' );
				$post_thumb_url 	= $post_thumb_url[0];
			}else{
				$post_thumb_url		= catanis_get_post_preview_img( $post->ID, false, 'large' );
				$post_thumb_url 	= trim($post_thumb_url['img']);
			}
		}else{
			$post_thumb_url		= catanis_get_post_preview_img( $post->ID, true, 'large' );
			$post_thumb_url 	= trim($post_thumb_url['img']);
		} 
		
		switch ( $format ) {
			case 'gallery':
				
				if( in_array($post_style, array('one-column', 'list')) ){
					$img_size['width'] 	=  get_option( 'large_size_w' );
					$img_size['height']	= get_option( 'large_size_h' );
				}else{
					$img_size['width'] 	=  get_option( 'medium_size_w' );
					$img_size['height']	= get_option( 'medium_size_h' );
				}
				
				$img_size['crop'] = true;
				if(isset($post_meta['gallery_items'])){
					$images = catanis_get_slick_slider_images( $post_meta['gallery_items'], $img_size );
					if ( !empty($images) && count($images) > 1) {
						$xhtml .= catanis_get_slick_slider_html($images, 'post-'.rand(), $img_size['height'], 'slick-calc-height');
					}
				}
					
				break;
		
			case 'video':
				if( !empty($post_meta) ) {
					if(catanis_check_cataniscore_exists()){
						$image_overlay = get_post_thumbnail_id( $post->ID );
						$video_style = ($post_style == 'grid' || $post_style == 'masonry') ? 'popup' : 'normal';
						
						$video_sc = '[cata_video video_style="'. $video_style .'" video_host="'. $post_meta['video_type'] .'" image_overlay="'. $image_overlay .'"';
						$video_sc .= ' video_url_youtube="'. $post_meta['video_url_youtube'] .'" video_url_vimeo="'. $post_meta['video_url_vimeo'] .'"';
						$video_sc .= ' video_url_mp4="'. $post_meta['video_url_mp4'] .'" video_url_ogg="'. $post_meta['video_url_ogg'] .'" video_url_webm="'. $post_meta['video_url_webm'] .'"]';
						$xhtml .= do_shortcode($video_sc);
					}else{
						
						$video_type = $post_meta['video_type'];
						$tmp = catanis_post_thumbnail($post_thumb_url);
						if ( isset($video_type)){
							if(in_array($video_type, array('youtube', 'vimeo'))){
								$video_url = ($video_type == 'youtube') ? $post_meta['video_url_youtube'] : $post_meta['video_url_vimeo'];
								if($post_style == 'grid' || $post_style == 'masonry'){
									$tmp = catanis_post_thumbnail_video_grid($video_url, $post_thumb_url);
								}else{
									$tmp = catanis_get_video_html( $video_url, '100%');
								}
							}
						}
						
						$xhtml .= $tmp;
					}
				}
				
				break;
		
			case 'audio':
				
				if ( isset($post_meta['audio_type']) && !empty($post_meta['audio_type']) ) {
					if($post_meta['audio_type'] == 'mp3' && isset($post_meta['audio_mp3']) && !empty($post_meta['audio_mp3'])){
						$xhtml .= '<div class="cata-audio-mp3">' . do_shortcode('[audio preload="auto" src="'. esc_url($post_meta['audio_mp3']) .'"]') .'</div>';
						$xhtml .= catanis_post_thumbnail($post_thumb_url);
					}else{
						
						if(isset($post_meta['audio_soundcloud']) && !empty($post_meta['audio_soundcloud'])){
							
							if ( preg_match("/visual=true/i", $post_meta['audio_soundcloud']) ) {
								$newHeight = (is_single() || in_array($post_style, array('list', 'onecolumn'))) ? 400 : 210;
								$content = preg_replace( array('/height="\d+"/i'), array(sprintf('height="%d"', $newHeight)),$post_meta['audio_soundcloud']);
							} else {
								$content = $post_meta['audio_soundcloud'];
							}
							$xhtml .= do_shortcode($content);
						}
					}
				}else{
					$xhtml .= catanis_post_thumbnail($post_thumb_url);
				}
			
				break;
		
			case 'quote':
				
				$xhtml .= '<figure class="cata-entry-thumbnail">';
				$xhtml .= '	<div class="wrap-cont"><span class="ti-quote-right top-icon"></span>';
					if (!empty($post_meta['quote_content']) ) :
						$title = strip_tags(get_the_title());
						$xhtml .= '<blockquote>'. strip_tags( $post_meta['quote_content'] ) .
									'<a href="'. esc_url( get_permalink($post) ) .'" title="' . esc_attr($title) . '" target="_blank">'. strip_tags( $post_meta['quote_author'] ) .'</a></blockquote>';
					else:
						$xhtml .= get_the_content();
					endif;
				$xhtml .= '</div></figure>';
				
				break;
					
			case 'link':
			
				if( !empty($post_meta) ) :
					$title = strip_tags(get_the_title());
					$xhtml .= '<div><span class="ti-link top-icon"></span>
							<h5><a href="'. get_the_permalink() .'" title="' . esc_attr($title) . '" target="_blank">'. strip_tags( $post_meta['link_text'] ) .'</a></h5>
							<a href="'. esc_url( $post_meta['link_url'] ) .'" title="' . esc_attr($title) . '" target="_blank"><span>'. esc_url( $post_meta['link_url'] ) .'</span></a>
		 				</div>';
				else:
					$xhtml .= '<div><span class="fa fa-link top-icon"></span><h5>'. get_the_content() .'</h5></div>';
				endif;
				
				break;
		
			default:
				
				$xhtml .= catanis_post_thumbnail($post_thumb_url);
				break; 
		}
		
		if($echo == true){
			echo trim($xhtml);
		}else{
			return $xhtml;
		}
		
	}
}

if ( ! function_exists( 'catanis_get_post_item_excerpt' ) ) {
	/**
	 * Display excerpt for each blog item
	 *
	 * @return html post excerpt
	 */
	function catanis_get_post_item_excerpt($excerpt_length, $blog_post_summary = 'excerpt'){
		?>
		<div class="cata-blog-item-excerpt">
			<?php
				if ( $blog_post_summary != 'excerpt' ):
					$ismore = @strpos( $post->post_content, '<!--more-->' );
					the_content();
			?>
					<div class="clear"></div>
					<?php if ( $ismore ) { ?> 
					<a href="<?php the_permalink(); ?>" class="read-more">
						<span class="more-arrow"><i class="fa fa-caret-right"></i></span>
						<?php esc_html_e( 'Read More', 'onelove' ); ?>
					</a>
				<?php } ?>
			<?php 
				else: 
					catanis_custom_excerpt( $excerpt_length );
			?>
					<div class="clear"></div>
					<a href="<?php the_permalink(); ?>" class="read-more">
						<span class="more-arrow"><i class="fa fa-caret-right"></i></span>
						<?php esc_html_e( 'Read More', 'onelove' ); ?>
					</a>
			<?php endif; ?>
		</div>
		<?php 
	}
}

if ( ! function_exists( 'catanis_post_tags_and_share' ) ) {
	/**
	 * Display tags and share for a post detail
	 *
	 * @return html post tags and share
	 */
	function catanis_post_tags_and_share($post, $opts = array()) {

		/* Tags */
		if(!empty($opts) && in_array('tags', $opts)):
			$tag_list = get_the_tag_list( '', ' ' );
			if ( $tag_list ):
				echo '<p class="meta-tags"><span>'. esc_html__('TAGS', 'onelove').':</span> '. $tag_list.'</p>';
			endif;
		endif;
		
		/* Categories */
		if(!empty($opts) && in_array('category', $opts)):
			$category_list = get_the_category_list( ' ' );
			if ( $category_list ):
				echo '<p class="meta-tags cates"><span>'. esc_html__('CATEGORIES', 'onelove').':</span> '. $category_list.'</p>';
			endif;
		endif;

		/* Share */
		if(!empty($opts) && in_array('share', $opts)):
			echo '<div class="post-share">
					<div class="wrap-social">
						'. catanis_get_share_btns_html($post->ID, 'post', false) .'
					</div>
				</div>';
		endif;
	}
}

if ( ! function_exists( 'catanis_get_share_btns_html' ) ) {
	/**
	 * Generates the sharing buttons HTML code.
	 *
	 * @param int $post_id  the ID of the post that the buttons will be added to
	 * @param string $content_type the type of the containing element - can be a post, page, product or portfolio
	 * @return string the HTML code of the buttons
	 */
	function catanis_get_share_btns_html( $post_id, $content_type, $tooltip = true) {

		$xhtml = $addCls = '';
		$display_buttons = catanis_option( 'blog_single_sharebox_link' );
		if ( $content_type =='product' ) {
			$display_buttons = catanis_option( 'prodetail_sharebox_link' );
			
		}elseif ( $content_type == CATANIS_POSTTYPE_PORTFOLIO ) {
			$display_buttons = catanis_option( 'portfolio_single_sharebox_link' );
		}elseif ( $content_type =='post' ) {
			$display_buttons = catanis_option( 'blog_single_sharebox_link' );
		}elseif ( $content_type =='post-list' ) {
			$display_buttons = catanis_option( 'blog_post_sharebox_link' );
		}

		if ( !is_array( $display_buttons )) {
			$display_buttons = explode( ',', $display_buttons);
		}
		
		$permalink = get_permalink( $post_id );
		$title_post = get_the_title( $post_id );

		if ( is_array( $display_buttons ) && count( $display_buttons ) >0 && !empty( $display_buttons[0] ) ) {
				
			$addCls = 'items' . count( $display_buttons );
			if ( $content_type == CATANIS_POSTTYPE_PORTFOLIO ) {
				$width = ( count( $display_buttons )*30 ) + 20 .'px';
				$topArr = array( 1 => '0px', 2 => '-23px', 3 => '-38px', 4 => '-50px', 5 => '-65px', 6 => '-78px');
				$style = 'style="width: ' . $width . '; left:' . $topArr[count( $display_buttons )] . '"';
			}
			$xhtml = '<div class="cata-social-share type-'.$content_type.' animated '.$addCls.'"><ul>';
			foreach ( $display_buttons as $btn ) {
				switch ( $btn ) {
					case 'facebook':
						$title = esc_html__('Facebook', 'onelove');
						$_tooltip = ( !$tooltip ) ? '' : ' data-toggle="tooltip" data-placement="top" data-original-title="'. $title .'"';
						$xhtml.='<li class="share-facebook"' . $_tooltip . '>
								<a class="cata-social-share-facebook" href="' . $permalink . '" title="'. $title_post .'">
								<i class="fa fa-facebook"></i><span>'. $title .'</span></a></li>';
						break; 

					case 'twitter':
						$title = esc_html__('Twitter', 'onelove');
						$_tooltip = ( !$tooltip ) ? '' : ' data-toggle="tooltip" data-placement="top" data-original-title="'. $title .'"';
						$xhtml.='<li class="share-twitter"' . $_tooltip . '>
							<a class="cata-social-share-twitter" href="' . $permalink . '" title="'. $title_post .'">
							<i class="fa fa-twitter"></i><span>'. $title .'</span></a></li>';
						break;

					case 'google':
						$title = esc_html__('Google+', 'onelove');
						$_tooltip = ( !$tooltip ) ? '' : ' data-toggle="tooltip" data-placement="top" data-original-title="'. $title .'"';
						$xhtml.='<li class="share-googleplus"' . $_tooltip . '>
							<a class="cata-social-share-googleplus" href="' . $permalink . '" title="'. $title_post .'">
							<i class="fa fa-google-plus"></i><span>'. $title .'</span></a></li>';
						break;

					case 'pinterest':
						global $post, $product;
						$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
						$title 	= esc_html__('Pinterest', 'onelove');
						$_tooltip = ( !$tooltip ) ? '' : ' data-toggle="tooltip" data-placement="top" data-original-title="'. $title .'"';
						$xhtml .='<li class="share-pinterest"' . $_tooltip . '>
								<a class="cata-social-share-pinterest" href="' . $permalink . '" data-pin-img="' . $image_link . '" title="'. $title_post .'">
								<i class="fa fa-pinterest"></i><span>'. $title .'</span></a></li>';
						break;

					case 'linkedin':
						$title 	= esc_html__('Linkedin', 'onelove');
						$_tooltip = ( !$tooltip ) ? '' : ' data-toggle="tooltip" data-placement="top" data-original-title="'. $title .'"';
						$xhtml.='<li class="share-linkedin"' . $_tooltip . '>
								<a class="cata-social-share-linkedin" href="' . $permalink . '" title="'. $title_post .'">
								<i class="fa fa-linkedin"></i><span>'. $title .'</span></a></li>';
						break;
							
					case 'email':
						$title 	= esc_html__('Email', 'onelove');
						$_tooltip = ( !$tooltip ) ? '' : ' data-toggle="tooltip" data-placement="top" data-original-title="'. $title .'"';
						$xhtml.='<li class="share-email"' . $_tooltip . '>
								<a class="" href="mailto:?subject=' . str_replace(' ', '-', $title_post)  . '&amp;body=' . $permalink . '" title="'. $title_post .'">
								<i class="fa fa-envelope"></i><span>'. $title .'</span></a></li>';
						break;

					case 'digg':
						$title 	= esc_html__('Digg', 'onelove');
						$_tooltip = ( !$tooltip ) ? '' : ' data-toggle="tooltip" data-placement="top" data-original-title="'. $title .'"';
						$xhtml .='<li class="share-digg"' . $_tooltip . '>
							<a class="cata-social-share-digg" href="' . $permalink . '" title="'. $title_post .'">
							<i class="fa fa-digg"></i><span>'. $title .'</span></a></li>';
						break;
					case 'vk':
							$title 	= esc_html__('VK', 'onelove');
							$_tooltip = ( !$tooltip ) ? '' : ' data-toggle="tooltip" data-placement="top" data-original-title="'. $title .'"';
							$xhtml .='<li class="share-vk"' . $_tooltip . '>
							<a class="cata-social-share-vk" href="' . $permalink . '" title="'. $title_post .'">
							<i class="fa fa-vk"></i><span>'. $title .'</span></a></li>';
						break;
						
					case 'stumbleUpon':
						$title 	= esc_html__('StumbleUpon', 'onelove');
						$_tooltip = ( !$tooltip ) ? '' : ' data-toggle="tooltip" data-placement="top" data-original-title="'. $title .'"';
						$xhtml.='<li class="share-stumbleUpon"' . $_tooltip . '>
								<a class="cata-social-share-stumbleUpon" href="' . $permalink.'" title="'. $title_post .'">
								<i class="fa fa-stumbleupon"></i><span>'. $title .'</span></a></li>';
						break;
						
					case 'delicious':
						$title 	= esc_html__('Delicious', 'onelove');
						$_tooltip = ( !$tooltip ) ? '' : ' data-toggle="tooltip" data-placement="top" data-original-title="'. $title .'"';
						$xhtml.='<li class="share-delicious"' . $_tooltip . '>
								<a class="cata-social-share-delicious" href="' . $permalink . '" title="'. $title_post .'">
								<i class="fa fa-delicious"></i><span>'. $title .'</span></a></li>';
						break;
				}
			}
			
			$xhtml	.= '</ul></div><div class="clear"></div>';
		}

		return $xhtml;
	}
}
if ( ! function_exists( 'catanis_get_featured_image_url' ) ) {
	/**
	 * Gets the URL of the featured image of a post.
	 * 
	 * @param int  $pid the ID of the post
	 * @return string the URL of the image
	 */
	function catanis_get_featured_image_url( $pid, $image_size = 'medium' ) {
		$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $pid ), $image_size );
		
		return trim($attachment[0]);
	}
}

if ( ! function_exists( 'catanis_get_single_meta' ) ) {
	/**
	 * Retrive single meta
	 * 
	 * @param int $post_id post ID
	 * @param string $key key a single meta
	 * @return string or array
	 */
	function catanis_get_single_meta( $post_id, $key ) {
		
		$data_config = get_post_meta( $post_id, Catanis_Meta::$meta_key, true );
		return $data_config[$key];
	}
}

if ( ! function_exists( 'catanis_get_portfolio_categories' ) ) {

	function catanis_get_portfolio_categories() {
		global $catanis;

		if ( !isset( $catanis->portfolio_categories ) ) {
			$categories = array();
			$terms    	= get_terms( 'portfolio_category', 'orderby=id&hide_empty=0' );

			for($i=0; $i < sizeof( $terms ); $i++ ) {
				$categories[] = array( 'id' => $terms[$i]->term_id, 'name' => $terms[$i]->name );
			}
			$catanis->portfolio_categories = $categories;
		}

		return $catanis->portfolio_categories;
	}
}

if ( ! function_exists( 'catanis_get_portfolio_preview_img' ) ) {
	/**
	 * Retrieves the main preview image URL of a portfolio item.
	 *
	 * @param int $id the item(post) ID
	 * @param skip_custom_thumbnail when set to true, it won't check for a custom thumbnail
	 * @param image_size name image size to get
	 * @return array containing the image URL as an 'img' key and
	 * a boolean with key 'custom' setting whether the thumbnail was customly set.
	 */
	function catanis_get_portfolio_preview_img( $id, $skip_custom_thumbnail = false, $image_size = 'full' ) {
		
		$preview = '';
		$custom = false;
		$custom_thumbnail = ($skip_custom_thumbnail == false) ? catanis_get_single_meta( $id, 'port_custom_thumbnail' ) : null;

		if ( ! empty( $custom_thumbnail ) ) {
			$preview = $custom_thumbnail;
			$preview_full = catanis_get_featured_image_url( $id, 'full' );
			$custom = true;
			
		}elseif ( has_post_thumbnail( $id ) ) {
			$preview = catanis_get_featured_image_url( $id, $image_size );
			$preview_full = catanis_get_featured_image_url( $id, 'full' );
		}else {
			/*retrieve the first image from the attachment list*/
			$post = get_post( $id );
			$attachments = catanis_get_post_gallery_images( $post );
			if ( sizeof( $attachments ) > 0 ) {
				$vals = array_values( $attachments );
				$attachment = array_shift( $vals );
				$src = wp_get_attachment_image_src( $attachment->ID, $image_size);
				$preview = $preview_full = $src[0];
				$alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true);
			}
		}

		$img = array( 'img' => $preview, 'img_full' => $preview_full ,'custom' => $custom);
		if ( isset( $alt ) ) {
			$img['alt'] = esc_attr( $alt );
		}

		return $img;
	}
}

if ( ! function_exists( 'catanis_get_image_size_portfolio' ) ) {
	function catanis_get_image_size_portfolio( $custom_thumbnail_type, $portfolio_style) {
		$image_size = 'catanis-image-small-square';
		$image_size_class = 'cata-default-masonry-item';
		
		if($portfolio_style == 'masonry'){
			if($custom_thumbnail_type == 'cata-small-height-masonry-item'){
				$image_size = 'catanis-image-small-mini';
				
			}elseif($custom_thumbnail_type == 'cata-large-height-masonry-item'){
				$image_size = 'catanis-image-medium-rect-vertical';
			}
		}elseif($portfolio_style == 'masonry-multisize'){
			$image_size_class = $custom_thumbnail_type;
			if($custom_thumbnail_type == 'cata-small-height-masonry-item'){
				$image_size = 'catanis-image-small-mini';
					
			}elseif($custom_thumbnail_type == 'cata-large-width-masonry-item'){
				$image_size = 'catanis-image-medium-rect-horizontal';
					
			}elseif($custom_thumbnail_type == 'cata-large-height-masonry-item'){
				$image_size = 'catanis-image-medium-rect-vertical';
					
			}elseif($custom_thumbnail_type == 'cata-large-width-height-masonry-item'){
				$image_size = 'catanis-image-medium-square';
			}
		}
		
		return array(
				'image_size' => $image_size,
				'image_size_class' => $image_size_class
			);
	}
}

if ( ! function_exists( 'catanis_get_post_preview_img' ) ) {
	/**
	 * Retrieves the main preview image URL of a post item.
	 *
	 * @param int $id the item(post) ID
	 * @param skip_custom_thumbnail when set to true, it won't check for a custom thumbnail
	 * @return array containing the image URL as an 'img' key and
	 * a boolean with key 'custom' setting whether the thumbnail was customly set.
	 */
	function catanis_get_post_preview_img( $id, $skip_custom_thumbnail = false, $image_size ) {

		$preview = '';
		$custom = false;
		$custom_thumbnail = $skip_custom_thumbnail == false ? catanis_get_single_meta( $id, 'post_custom_thumbnail' ) : null;

		if ( ! empty( $custom_thumbnail ) ) {
			$preview = $custom_thumbnail;
			$custom = true;
				
		}elseif ( has_post_thumbnail( $id ) ) {
			$preview = catanis_get_featured_image_url( $id, $image_size );
				
		}else {
			/*retrieve the first image from the attachment list*/
			$post = get_post( $id );
			$attachments = catanis_get_post_gallery_images( $post );
			if ( sizeof( $attachments ) > 0 ) {
				$vals = array_values( $attachments );
				$attachment = array_shift( $vals );
				$src = wp_get_attachment_image_src( $attachment->ID, 'full');
				$preview = $src[0];
				$alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true);
			}
		}

		$img = array( 'img' => $preview, 'custom' => $custom);
		if ( isset( $alt ) ) {
			$img['alt'] = esc_attr( $alt );
		}

		return $img;
	}
}

if ( ! function_exists( 'catanis_hex2rgba' ) ) {
	/**
	 * Convert color HEX to RGB
	 * 
	 * @param string $colour, Ex: #FF000000
	 * @param int $opacity opacity 
	 * @return array
	 * 
	 * Input: 	hex2rgb("#f00", '.2')
	 * Output: 	Array(255, 0, 0, 0.2)
	 */
	function catanis_hex2rgba( $colour, $opacity = 1 ) {
	
		$colour = ( $colour[0] == '#' ) ? substr( $colour, 1 ) : $colour ;
		if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
			return false;
		}
	
		$r = hexdec( $r );  $g = hexdec( $g );  $b = hexdec( $b );
		
		$RGB = 'rgba('.$r.', '.$g.', '.$b.', '.$opacity.')';
		return $RGB;
	}
}

if ( ! function_exists( 'catanis_rgb2hex' ) ) {
	/**
	 * Convert color RGB to HEX
	 *
	 * @param array $rgb, Ex: array( 255, 0, 0 )
	 * @return string
	 *
	 * Input: 	rgb2hex(array( 255, 0, 0 ))
	 * Output: 	#FF000000
	 */
	function catanis_rgb2hex( $rgb ) {
		$hex = "#";
		$hex .= str_pad( dechex( $rgb[0] ), 2, "0", STR_PAD_LEFT );
		$hex .= str_pad( dechex( $rgb[1] ), 2, "0", STR_PAD_LEFT );
		$hex .= str_pad( dechex( $rgb[2] ), 2, "0", STR_PAD_LEFT );
	
		return $hex;
	}
}

if ( ! function_exists( 'catanis_instagram_response' ) ) {
	/**
	 * Retrieves instagram result (Use for widget and shortcode)
	 *
	 * @param string $userid the user ID
	 * @param int $count number item to get
	 * @param int $columns number columns to display
	 * @return html containing html result
	 */
	function catanis_instagram_response( $userid = null, $count = 8, $columns = 4) {
	
		$output = '';
		if ( intval( $userid ) === 0 ) {
			return '<p>' . esc_html__( 'No user ID specified.', 'onelove' ) . '</p>';
		}
	
		$transient_var = 'instagram_' . $userid . '_' . $count . '_'. $columns;
		if ( false === ( $items = get_transient( $transient_var ) ) ) {
	
			$response = wp_remote_get( 'https://api.instagram.com/v1/users/' . esc_attr($userid) . '/media/recent/?client_id=9783646bdb41462abedf723be97a047b&count=' . esc_attr( $count ));
			
			if ( ! is_wp_error( $response ) ) {
			
				$response_body = json_decode( $response['body'] );
				if ( !isset($response_body->meta) || $response_body->meta->code !== 200 ) {
					return '<p>' . esc_html__( 'Incorrect user ID specified.', 'onelove' ) . '</p>';
				}
		
				$items_as_objects = $response_body->data;
				$items = array();
				foreach ( $items_as_objects as $item_object ) {
					$item['link'] = $item_object->link;
					$item['src'] = $item_object->images->low_resolution->url;
					$items[] = $item;
				}
				
				if(count($items) >0){
					set_transient( $transient_var, $items, 12 * HOUR_IN_SECONDS );
				}
			}
		}
	
		if ( is_array( $items ) && count( $items ) > 0 ) {
			$output = '<ul class="insta-items insta-columns-' . esc_attr( $columns ) . '">';
		
			foreach ( $items as $item ) {
				$link	= $item['link'];
				$image	= $item['src'];
				$output	.= '<li><a href="' . esc_url( $link ) .'" target="_blank"><img src="' . esc_url( $image ) . '" alt="" /></a></li>';
			}
		
			$output .= '</ul>';
			$output .= '<a class="see-more" href="http://ink361.com/app/users/ig-' . esc_attr($userid) . '/photos" target="_blank">' . esc_html__( 'Follow us on Instagram', 'onelove') . '</a>';
		}
	
		return $output; 
	}
}

if ( ! function_exists ( 'catanis_extend_class_page' ) ) {
	/**
	 * Display Or Retrieves extend class for page
	 *
	 * @param string $echo display or retrieves
	 * @return string extend class
	 */
	function catanis_extend_class_page( $echo = false ) {
		
		global $catanis;
	
		$catanis_page = $catanis->pageconfig;
		$_extend_class 	= ( ! empty( $catanis_page['layout'] ) && $catanis_page['layout'] != 'full' ) ? 'cata-template-sidebar sb-' . $catanis_page['layout'] : 'cata-template-fullwidth';
		if ( isset( $catanis_page['columns'] ) && !empty( $catanis_page['columns'] ) ) {
			$_extend_class 	.= ' columns-' . $catanis_page['columns'];
		}
		
		if ( $echo == false ) {
			return $_extend_class;
		}else{
			echo esc_html($_extend_class);
		}
	}
}


/*==============================================================================
 * ACTION HOOK FUNCTIONS
 *==============================================================================*/
add_action( 'catanis_hook_footer', 'catanis_backtotop_button', 3 );
if ( ! function_exists ( 'catanis_backtotop_button' ) ) {
	/**
	 * Display back to top button for site
	 *
	 * @return html
	 */
	function catanis_backtotop_button() {
		if(catanis_option('footer_backtop')) :
			echo '<div class="cata-backtotop"><a href="#" class="cata-backtotop-inner"><i class="fa fa-angle-up"></i></a></div>';
		endif; 
	}
}

add_action( 'template_redirect', 'catanis_setup_template_redirect' );
if ( ! function_exists ( 'catanis_setup_template_redirect' ) ) {
	/**
	 * Setting all page when template redirect
	 * 
	 * @return array value for $catanis_page
	 */
	function catanis_setup_template_redirect() {
		global $catanis, $wp_query, $post;
		
		$catanis_page = array();
		
		$show_header_phone 	= catanis_option('show_header_phone');
		$show_header_email 	= catanis_option('show_header_email');
		$show_header_address = catanis_option('show_header_address');
		$default_opts = array(
			'layout'					=> catanis_option('default_layout'),
			'sidebar'					=> catanis_option('default_sidebar'),
			'header_overlap' 			=> catanis_option('header_overlap'),
			'header_bg_color'			=> '',
			'header_style'				=> catanis_option('header_style'),
			'header_bg'					=> catanis_option('header_bg'),
			'header_fullwidth'			=> false,
			'show_store_notice'			=> catanis_option('show_store_notice'),
			'store_notice'				=> catanis_option('store_notice'),
			'menu_color_style'			=> catanis_option('menu_color_style'),
			'main_navigation_menu'		=> '',
			'custom_logo'				=> '',
			'sticky_logo'				=> catanis_option('sticky_logo'),
			'show_header_cart' 			=> catanis_option('show_header_cart'),
			'show_slideout_widget' 		=> catanis_option('show_slideout_widget'),
			'show_header_search' 		=> catanis_option('show_header_search'),
			'show_header_socials' 		=> catanis_option('socials_show'),
			'show_header_phone' 		=> $show_header_phone['status'],
			'show_header_email' 		=> $show_header_email['status'],
			'show_header_address' 		=> $show_header_address['status'],
	
			'page_title_enable' 		=> catanis_option('page_title_enable'),
			'page_title_style'			=> catanis_option('page_title_style'),
			'show_breadcrumb' 			=> catanis_option('show_breadcrumb'),
			'page_title_position'		=> catanis_option('page_title_position'),
			'page_title_bg'				=> catanis_option('page_title_bg'),
			'page_title_bg_alignment'	=> catanis_option('page_title_bg_alignment'),
			'page_title_overlay'		=> false,
			'page_title_overlay_color'	=> 'rgba(0, 0, 0, 0.3)',
			'page_title_parallax'		=> false,
			'page_title_title'			=> '',
			'page_title_subtitle'		=> '',
			'page_title_bg_color'		=> '#e49497',
			'page_title_font_color'		=> '#FFFFFF',
				
			'page_feature_type'			=> 'image',
			'page_feature_size'			=> catanis_option('page_feature_size'),
			'page_feature_height'		=> catanis_option('page_feature_height'),
			'page_feature_minheight'	=> catanis_option('page_feature_minheight'),
			'page_feature_revslider' 	=> '',
			'page_feature_slider_items' => '',
			'page_feature_map_pin' 		=> '',
			'page_feature_map_style' 	=> 'style1',
			'page_feature_map_zoom' 	=> '8',
			'page_feature_map_address1' => '',
			'page_feature_map_address2' => '',
			'page_feature_map_address3' => '',
			'page_feature_map_address4' => '',
			'page_feature_map_address5' => '',
			'page_feature_video_type' 	=> 'youtube',
			'page_feature_video_url_youtube' 	=> '',
			'page_feature_video_url_vimeo' 		=> '',
			'page_feature_video_url_mp4' 		=> '',
			'page_feature_video_url_ogg' 		=> '',
			'page_feature_video_url_webm' 		=> '',
				
			'disable_footer'			=> catanis_option( 'disable_footer' ),
			'footer_style'				=> catanis_option( 'footer_style' ),
			'footer_logo'				=> catanis_option( 'footer_logo' ),
			'footer_background'			=> catanis_option( 'footer_background' ),
			'footer_top_color_scheme'	=> catanis_option( 'footer_top_color_scheme' ),
			'footer_bottom_color_scheme' => catanis_option( 'footer_bottom_color_scheme' ),
				
			'comment_enable'			=> false,
				
			/*For WooCommerce*/
			'woo_page_title_enable' 		=> catanis_option( 'woo_page_title_enable' ),
			'woo_page_title_style' 			=> catanis_option( 'woo_page_title_style' ),
			'woo_show_breadcrumb' 			=> catanis_option( 'woo_show_breadcrumb' ),
			'woo_page_title_position' 		=> catanis_option( 'woo_page_title_position' ),
			'woo_page_title_bg' 			=> catanis_option( 'woo_page_title_bg' ),
			'woo_page_title_bg_alignment' 	=> catanis_option( 'woo_page_title_bg_alignment' ),
			'woo_page_feature_size' 		=> catanis_option( 'woo_page_feature_size' ),
			'woo_page_feature_height' 		=> catanis_option( 'woo_page_feature_height' ),
			'woo_page_feature_minheight' 	=> catanis_option( 'woo_page_feature_minheight' )
				
		);
		
		if ( is_home() || is_front_page()) {
			
			/*Default - No choose Front page displays in Settings -> Reading*/
			if ( is_home() && is_front_page()) {
				/*Post page*/
				$default_opts['layout'] = catanis_option( 'blog_layout' );
				$default_opts['sidebar'] = catanis_option( 'blog_sidebar' );
			}
			$default_opts['comment_enable'] = ($post->comment_status === 'open' || $post->ping_status === 'open') ? true : false;
			
			$vc_enabled = false;
			$page_id = ( is_front_page()) ? get_option( 'page_on_front' ) : get_option( 'page_for_posts' );
			if ( ($wp_query->is_posts_page || get_option( 'page_for_posts' ) == $wp_query->query_vars['page_id']) && $wp_query->query_vars['page_id'] > 0 ) {
				$page_id = get_option( 'page_for_posts' );
			}
			
			if ( $page_id > 0 ){
				$data_config = get_post_meta( $page_id, Catanis_Meta::$meta_key, true );
				if ( is_array( $data_config ) && ! empty( $data_config ) ) {
					$catanis_page = array(
							
						'layout'					=> (isset( $data_config['layout']) && $data_config['layout'] != 'default') ? $data_config['layout'] : $default_opts['layout'],
						'sidebar'					=> (isset( $data_config['sidebar']) && $data_config['sidebar'] != 'default') ? $data_config['sidebar'] : $default_opts['sidebar'],
						'header_overlap' 			=> (isset( $data_config['header_overlap']) && !catanis_check_option_bool( $data_config['header_overlap'] ) ) ? false : true,
						'header_bg_color'			=> (isset( $data_config['header_bg_color']) && !empty( $data_config['header_bg_color'])) ? $data_config['header_bg_color'] : '',
						'header_style'				=> (isset( $data_config['header_style']) && !empty( $data_config['header_style'])) ? $data_config['header_style'] : $default_opts['header_style'],
						'header_bg'					=> (isset( $data_config['header_bg']) && !empty( $data_config['header_bg'])) ? $data_config['header_bg'] : $default_opts['header_bg'],
						'header_fullwidth' 			=> (isset( $data_config['header_fullwidth']) && catanis_check_option_bool( $data_config['header_fullwidth'] ) ) ? true : false,
						'show_store_notice' 		=> (isset( $data_config['show_store_notice']) && !catanis_check_option_bool( $data_config['show_store_notice'] ) ) ? false : true,
						'menu_color_style'			=> (isset( $data_config['menu_color_style']) && !empty( $data_config['menu_color_style'])) ? $data_config['menu_color_style'] : $default_opts['menu_color_style'],
						'main_navigation_menu'		=> (isset( $data_config['main_navigation_menu']) && !empty( $data_config['main_navigation_menu'])) ? $data_config['main_navigation_menu'] : $default_opts['main_navigation_menu'],
						'custom_logo'				=> (isset( $data_config['custom_logo']) && !empty($data_config['custom_logo']) ) ? $data_config['custom_logo'] : '',
						'sticky_logo'				=> (isset( $data_config['sticky_logo']) && !empty($data_config['sticky_logo']) ) ? $data_config['sticky_logo'] : $default_opts['sticky_logo'],
						'show_header_cart' 			=> (isset( $data_config['show_header_cart']) && !catanis_check_option_bool( $data_config['show_header_cart'] ) ) ? false : true,
						'show_slideout_widget' 		=> (isset( $data_config['show_slideout_widget']) && !catanis_check_option_bool( $data_config['show_slideout_widget'] ) ) ? false : true,
						'show_header_search' 		=> (isset( $data_config['show_header_search']) && !catanis_check_option_bool( $data_config['show_header_search'] ) ) ? false : true,
						'show_header_socials' 		=> (isset( $data_config['show_header_socials']) && !catanis_check_option_bool( $data_config['show_header_socials'] ) ) ? false : true,
						'show_header_phone' 		=> (isset( $data_config['show_header_phone']) && !catanis_check_option_bool( $data_config['show_header_phone'] ) ) ? false : true,
						'show_header_email' 		=> (isset( $data_config['show_header_email']) && !catanis_check_option_bool( $data_config['show_header_email'] ) ) ? false : true,
						'show_header_address' 		=> (isset( $data_config['show_header_address']) && !catanis_check_option_bool( $data_config['show_header_address'] ) ) ? false : true,
						
						'page_title_enable' 		=> (isset( $data_config['page_title_enable']) && !catanis_check_option_bool( $data_config['page_title_enable'] ) ) ? false : true,
						'page_title_style'			=> (isset( $data_config['page_title_style']) && !empty($data_config['page_title_style'])) ? $data_config['page_title_style'] : $default_opts['page_title_style'],
						'show_breadcrumb' 			=> (isset( $data_config['show_breadcrumb']) && catanis_check_option_bool( $data_config['show_breadcrumb'] ) ) ? true : false,
						'page_title_position'		=> (isset( $data_config['page_title_position']) && !empty( $data_config['page_title_position'])) ? $data_config['page_title_position'] : $default_opts['page_title_position'],
						'page_title_bg'				=> (isset( $data_config['page_title_bg']) && !empty( $data_config['page_title_bg'])) ? $data_config['page_title_bg'] : '',
						'page_title_bg_alignment'	=> (isset( $data_config['page_title_bg_alignment']) && !empty( $data_config['page_title_bg_alignment'])) ? $data_config['page_title_bg_alignment'] : $default_opts['page_title_bg_alignment'],
						'page_title_overlay'		=> (isset( $data_config['page_title_overlay']) && catanis_check_option_bool( $data_config['page_title_overlay'] ) ) ? true : false,
						'page_title_overlay_color'	=> (isset( $data_config['page_title_overlay_color']) && !empty( $data_config['page_title_overlay_color'])) ? $data_config['page_title_overlay_color'] : $default_opts['page_title_overlay_color'],
						'page_title_parallax'		=> (isset( $data_config['page_title_parallax']) && catanis_check_option_bool( $data_config['page_title_parallax'] ) ) ? true : false,
						'page_title_title'			=> (isset( $data_config['page_title_title']) && !empty( $data_config['page_title_title'])) ? $data_config['page_title_title'] : '',
						'page_title_subtitle'		=> (isset( $data_config['page_title_subtitle']) && !empty( $data_config['page_title_subtitle'])) ? $data_config['page_title_subtitle'] : '',
						'page_title_bg_color'		=> (isset( $data_config['page_title_bg_color']) && !empty( $data_config['page_title_bg_color'])) ? $data_config['page_title_bg_color'] : $default_opts['page_title_bg_color'],
						'page_title_font_color'		=> (isset( $data_config['page_title_font_color']) && !empty( $data_config['page_title_font_color'])) ? $data_config['page_title_font_color'] : $default_opts['page_title_font_color'],
							
						'page_feature_type'			=> (isset( $data_config['page_feature_type']) && !empty( $data_config['page_feature_type']) ) ? $data_config['page_feature_type'] : $default_opts['page_feature_type'],
						'page_feature_size'			=> (isset( $data_config['page_feature_size']) && !empty( $data_config['page_feature_size']) ) ? $data_config['page_feature_size'] : $default_opts['page_feature_size'],
						'page_feature_height'		=> (isset( $data_config['page_feature_height']) && !empty( $data_config['page_feature_height']) ) ? $data_config['page_feature_height'] : $default_opts['page_feature_height'],
						'page_feature_minheight'	=> (isset( $data_config['page_feature_minheight']) && !empty( $data_config['page_feature_minheight']) ) ? $data_config['page_feature_minheight'] : $default_opts['page_feature_minheight'],
						'page_feature_revslider' 	=> (isset( $data_config['page_feature_revslider']) && !empty( $data_config['page_feature_revslider']) ) ? $data_config['page_feature_revslider'] : $default_opts['page_feature_revslider'],
						'page_feature_slider_items' => (isset( $data_config['page_feature_slider_items']) && !empty( $data_config['page_feature_slider_items']) ) ? $data_config['page_feature_slider_items'] : $default_opts['page_feature_slider_items'],
						'page_feature_map_pin' 		=> (isset( $data_config['page_feature_map_pin']) && !empty( $data_config['page_feature_map_pin']) ) ? $data_config['page_feature_map_pin'] : $default_opts['page_feature_map_pin'],
						'page_feature_map_style' 	=> (isset( $data_config['page_feature_map_style']) && !empty( $data_config['page_feature_map_style']) ) ? $data_config['page_feature_map_style'] : $default_opts['page_feature_map_style'],
						'page_feature_map_zoom' 	=> (isset( $data_config['page_feature_map_zoom']) && !empty( $data_config['page_feature_map_zoom']) ) ? $data_config['page_feature_map_zoom'] : $default_opts['page_feature_map_zoom'],
						'page_feature_map_address1' => (isset( $data_config['page_feature_map_address1']) && !empty( $data_config['page_feature_map_address1']) ) ? $data_config['page_feature_map_address1'] : $default_opts['page_feature_map_address1'],
						'page_feature_map_address2' => (isset( $data_config['page_feature_map_address2']) && !empty( $data_config['page_feature_map_address2']) ) ? $data_config['page_feature_map_address2'] : $default_opts['page_feature_map_address2'],
						'page_feature_map_address3' => (isset( $data_config['page_feature_map_address3']) && !empty( $data_config['page_feature_map_address3']) ) ? $data_config['page_feature_map_address3'] : $default_opts['page_feature_map_address3'],
						'page_feature_map_address4' => (isset( $data_config['page_feature_map_address4']) && !empty( $data_config['page_feature_map_address4']) ) ? $data_config['page_feature_map_address4'] : $default_opts['page_feature_map_address4'],
						'page_feature_map_address5' => (isset( $data_config['page_feature_map_address5']) && !empty( $data_config['page_feature_map_address5']) ) ? $data_config['page_feature_map_address5'] : $default_opts['page_feature_map_address5'],
						'page_feature_video_type' 	=> (isset( $data_config['page_feature_video_type']) && !empty( $data_config['page_feature_video_type']) ) ? $data_config['page_feature_video_type'] : $default_opts['page_feature_video_type'],
						'page_feature_video_url_youtube' 	=> (isset( $data_config['page_feature_video_url_youtube']) && !empty( $data_config['page_feature_video_url_youtube']) ) ? $data_config['page_feature_video_url_youtube'] : $default_opts['page_feature_video_url_youtube'],
						'page_feature_video_url_vimeo' 		=> (isset( $data_config['page_feature_video_url_vimeo']) && !empty( $data_config['page_feature_video_url_vimeo']) ) ? $data_config['page_feature_video_url_vimeo'] : $default_opts['page_feature_video_url_vimeo'],
						'page_feature_video_url_mp4' 		=> (isset( $data_config['page_feature_video_url_mp4']) && !empty( $data_config['page_feature_video_url_mp4']) ) ? $data_config['page_feature_video_url_mp4'] : $default_opts['page_feature_video_url_mp4'],
						'page_feature_video_url_ogg' 		=> (isset( $data_config['page_feature_video_url_ogg']) && !empty( $data_config['page_feature_video_url_ogg']) ) ? $data_config['page_feature_video_url_ogg'] : $default_opts['page_feature_video_url_ogg'],
						'page_feature_video_url_webm' 		=> (isset( $data_config['page_feature_video_url_webm']) && !empty( $data_config['page_feature_video_url_webm']) ) ? $data_config['page_feature_video_url_webm'] : $default_opts['page_feature_video_url_webm'],
							
						'disable_footer'				=> (isset( $data_config['disable_footer']) && catanis_check_option_bool( $data_config['disable_footer'] ) ) ? true : false,
						'footer_style'					=> (isset( $data_config['footer_style']) && !empty( $data_config['footer_style'])) ? $data_config['footer_style'] : $default_opts['footer_style'],
						'footer_logo'					=> (isset( $data_config['footer_logo']) && !empty( $data_config['footer_logo'])) ? $data_config['footer_logo'] : $default_opts['footer_logo'],
						'footer_background'				=> (isset( $data_config['footer_background']) && !empty( $data_config['footer_background'])) ? $data_config['footer_background'] : '',
						'footer_top_color_scheme'		=> (isset( $data_config['footer_top_color_scheme']) && !empty( $data_config['footer_top_color_scheme'])) ? $data_config['footer_top_color_scheme'] : $default_opts['footer_top_color_scheme'],
						'footer_bottom_color_scheme' 	=> (isset( $data_config['footer_bottom_color_scheme']) && !empty( $data_config['footer_bottom_color_scheme'])) ? $data_config['footer_bottom_color_scheme'] : $default_opts['footer_bottom_color_scheme'],
							
						'comment_enable'				=> (isset( $data_config['comment_enable']) && catanis_check_option_bool( $data_config['comment_enable'] ) ) ? true : false,
						'audio_use' 					=> (isset( $data_config['audio_use']) && !empty( $data_config['audio_use'])) ? $data_config['audio_use'] : '',
						'audio_mp3' 					=> (isset( $data_config['audio_mp3']) && !empty( $data_config['audio_mp3'])) ? $data_config['audio_mp3'] : '',
						'audio_autoplay'				=> (isset( $data_config['audio_autoplay']) && catanis_check_option_bool( $data_config['audio_autoplay'] ) ) ? true : false,
						'audio_soundcloud' 				=> (isset( $data_config['audio_soundcloud']) && !empty( $data_config['audio_soundcloud'])) ? $data_config['audio_soundcloud'] : '',
								
					);
				}
				
				/*Check VC Enable*/
				$vc_enabled = get_post_meta($page_id, '_wpb_vc_js_status', true);
				$vc_enabled = catanis_check_option_bool( $vc_enabled );
					
				$post = get_post();
				if ( $post && preg_match( '/vc_row/', $post->post_content ) ) {
					$vc_enabled = true;
				}
				
			}
			
			/*Check VC Enable*/
			$catanis_page['vc_enabled'] = $vc_enabled;
			
			$catanis_page = array_merge($default_opts, $catanis_page); 
			
		} elseif ( $wp_query->is_page() || (function_exists('is_shop') && is_shop() ) || is_post_type_archive('product') ) {
			if ( is_page_template( 'template-portfolio.php' ) ) {
				$default_opts['layout'] = catanis_option( 'portfolio_layout' );
				$default_opts['sidebar'] = catanis_option( 'portfolio_sidebar' );
			}
			
			if(function_exists('is_shop') && is_shop()  || is_post_type_archive('product')){
				$default_opts['layout'] = catanis_option( 'procate_layout' );
				$default_opts['sidebar'] = catanis_option( 'procate_sidebar' );
			}

			$default_opts['comment_enable'] = ($post->comment_status === 'open' || $post->ping_status === 'open') ? true : false;
			
			$page_id = (function_exists('is_shop') && is_shop() ) ? get_option( 'woocommerce_shop_page_id' ) : $post->ID;
			$data_config = get_post_meta( $page_id, Catanis_Meta::$meta_key, true );
			if ( is_array( $data_config ) && ! empty( $data_config ) ) { 
				$catanis_page = array(
							
					'layout'					=> (isset( $data_config['layout']) && $data_config['layout'] != 'default') ? $data_config['layout'] : $default_opts['layout'],
					'sidebar'					=> (isset( $data_config['sidebar']) && $data_config['sidebar'] != 'default') ? $data_config['sidebar'] : $default_opts['sidebar'],
					'header_overlap' 			=> (isset( $data_config['header_overlap']) && !catanis_check_option_bool( $data_config['header_overlap'] ) ) ? false : true,
					'header_bg_color'			=> (isset( $data_config['header_bg_color']) && !empty( $data_config['header_bg_color'])) ? $data_config['header_bg_color'] : '',
					'header_style'				=> (isset( $data_config['header_style']) && !empty( $data_config['header_style'])) ? $data_config['header_style'] : $default_opts['header_style'],
					'header_bg'					=> (isset( $data_config['header_bg']) && !empty( $data_config['header_bg'])) ? $data_config['header_bg'] : $default_opts['header_bg'],
					'header_fullwidth' 			=> (isset( $data_config['header_fullwidth']) && catanis_check_option_bool( $data_config['header_fullwidth'] ) ) ? true : false,
					'show_store_notice' 		=> (isset( $data_config['show_store_notice']) && !catanis_check_option_bool( $data_config['show_store_notice'] ) ) ? false : true,
					'menu_color_style'			=> (isset( $data_config['menu_color_style']) && !empty( $data_config['menu_color_style'])) ? $data_config['menu_color_style'] : $default_opts['menu_color_style'],
					'main_navigation_menu'		=> (isset( $data_config['main_navigation_menu']) && !empty( $data_config['main_navigation_menu'])) ? $data_config['main_navigation_menu'] : $default_opts['main_navigation_menu'],
					'custom_logo'				=> (isset( $data_config['custom_logo']) && !empty($data_config['custom_logo']) ) ? $data_config['custom_logo'] : '',
					'sticky_logo'				=> (isset( $data_config['sticky_logo']) && !empty($data_config['sticky_logo']) ) ? $data_config['sticky_logo'] : $default_opts['sticky_logo'],
					'show_header_cart' 			=> (isset( $data_config['show_header_cart']) && !catanis_check_option_bool( $data_config['show_header_cart'] ) ) ? false : true,
					'show_slideout_widget' 		=> (isset( $data_config['show_slideout_widget']) && !catanis_check_option_bool( $data_config['show_slideout_widget'] ) ) ? false : true,
					'show_header_search' 		=> (isset( $data_config['show_header_search']) && !catanis_check_option_bool( $data_config['show_header_search'] ) ) ? false : true,
					'show_header_socials' 		=> (isset( $data_config['show_header_socials']) && !catanis_check_option_bool( $data_config['show_header_socials'] ) ) ? false : true,
					'show_header_phone' 		=> (isset( $data_config['show_header_phone']) && !catanis_check_option_bool( $data_config['show_header_phone'] ) ) ? false : true,
					'show_header_email' 		=> (isset( $data_config['show_header_email']) && !catanis_check_option_bool( $data_config['show_header_email'] ) ) ? false : true,
					'show_header_address' 		=> (isset( $data_config['show_header_address']) && !catanis_check_option_bool( $data_config['show_header_address'] ) ) ? false : true,
					
					'page_title_enable' 		=> (isset( $data_config['page_title_enable']) && !catanis_check_option_bool( $data_config['page_title_enable'] ) ) ? false : true,
					'page_title_style'			=> (isset( $data_config['page_title_style']) && !empty($data_config['page_title_style'])) ? $data_config['page_title_style'] : $default_opts['page_title_style'],
					'show_breadcrumb' 			=> (isset( $data_config['show_breadcrumb']) && catanis_check_option_bool( $data_config['show_breadcrumb'] ) ) ? true : false,
					'page_title_position'		=> (isset( $data_config['page_title_position']) && !empty( $data_config['page_title_position'])) ? $data_config['page_title_position'] : $default_opts['page_title_position'],
					'page_title_bg'				=> (isset( $data_config['page_title_bg']) && !empty( $data_config['page_title_bg'])) ? $data_config['page_title_bg'] : '',
					'page_title_bg_alignment'	=> (isset( $data_config['page_title_bg_alignment']) && !empty( $data_config['page_title_bg_alignment'])) ? $data_config['page_title_bg_alignment'] : $default_opts['page_title_bg_alignment'],
					'page_title_overlay'		=> (isset( $data_config['page_title_overlay']) && catanis_check_option_bool( $data_config['page_title_overlay'] ) ) ? true : false,
					'page_title_overlay_color'	=> (isset( $data_config['page_title_overlay_color']) && !empty( $data_config['page_title_overlay_color'])) ? $data_config['page_title_overlay_color'] : $default_opts['page_title_overlay_color'],
					'page_title_parallax'		=> (isset( $data_config['page_title_parallax']) && catanis_check_option_bool( $data_config['page_title_parallax'] ) ) ? true : false,
					'page_title_title'			=> (isset( $data_config['page_title_title']) && !empty( $data_config['page_title_title'])) ? $data_config['page_title_title'] : '',
					'page_title_subtitle'		=> (isset( $data_config['page_title_subtitle']) && !empty( $data_config['page_title_subtitle'])) ? $data_config['page_title_subtitle'] : '',
					'page_title_bg_color'		=> (isset( $data_config['page_title_bg_color']) && !empty( $data_config['page_title_bg_color'])) ? $data_config['page_title_bg_color'] : $default_opts['page_title_bg_color'],
					'page_title_font_color'		=> (isset( $data_config['page_title_font_color']) && !empty( $data_config['page_title_font_color'])) ? $data_config['page_title_font_color'] : $default_opts['page_title_font_color'],
							
					'page_feature_type'			=> (isset( $data_config['page_feature_type']) && !empty( $data_config['page_feature_type']) ) ? $data_config['page_feature_type'] : $default_opts['page_feature_type'],
					'page_feature_size'			=> (isset( $data_config['page_feature_size']) && !empty( $data_config['page_feature_size']) ) ? $data_config['page_feature_size'] : $default_opts['page_feature_size'],
					'page_feature_height'		=> (isset( $data_config['page_feature_height']) && !empty( $data_config['page_feature_height']) ) ? $data_config['page_feature_height'] : $default_opts['page_feature_height'],
					'page_feature_minheight'	=> (isset( $data_config['page_feature_minheight']) && !empty( $data_config['page_feature_minheight']) ) ? $data_config['page_feature_minheight'] : $default_opts['page_feature_minheight'],
					'page_feature_revslider' 	=> (isset( $data_config['page_feature_revslider']) && !empty( $data_config['page_feature_revslider']) ) ? $data_config['page_feature_revslider'] : $default_opts['page_feature_revslider'],
					'page_feature_slider_items' => (isset( $data_config['page_feature_slider_items']) && !empty( $data_config['page_feature_slider_items']) ) ? $data_config['page_feature_slider_items'] : $default_opts['page_feature_slider_items'],
					'page_feature_map_pin' 		=> (isset( $data_config['page_feature_map_pin']) && !empty( $data_config['page_feature_map_pin']) ) ? $data_config['page_feature_map_pin'] : $default_opts['page_feature_map_pin'],
					'page_feature_map_style' 	=> (isset( $data_config['page_feature_map_style']) && !empty( $data_config['page_feature_map_style']) ) ? $data_config['page_feature_map_style'] : $default_opts['page_feature_map_style'],
					'page_feature_map_zoom' 	=> (isset( $data_config['page_feature_map_zoom']) && !empty( $data_config['page_feature_map_zoom']) ) ? $data_config['page_feature_map_zoom'] : $default_opts['page_feature_map_zoom'],
					'page_feature_map_address1' => (isset( $data_config['page_feature_map_address1']) && !empty( $data_config['page_feature_map_address1']) ) ? $data_config['page_feature_map_address1'] : $default_opts['page_feature_map_address1'],
					'page_feature_map_address2' => (isset( $data_config['page_feature_map_address2']) && !empty( $data_config['page_feature_map_address2']) ) ? $data_config['page_feature_map_address2'] : $default_opts['page_feature_map_address2'],
					'page_feature_map_address3' => (isset( $data_config['page_feature_map_address3']) && !empty( $data_config['page_feature_map_address3']) ) ? $data_config['page_feature_map_address3'] : $default_opts['page_feature_map_address3'],
					'page_feature_map_address4' => (isset( $data_config['page_feature_map_address4']) && !empty( $data_config['page_feature_map_address4']) ) ? $data_config['page_feature_map_address4'] : $default_opts['page_feature_map_address4'],
					'page_feature_map_address5' => (isset( $data_config['page_feature_map_address5']) && !empty( $data_config['page_feature_map_address5']) ) ? $data_config['page_feature_map_address5'] : $default_opts['page_feature_map_address5'],
					'page_feature_video_type' 	=> (isset( $data_config['page_feature_video_type']) && !empty( $data_config['page_feature_video_type']) ) ? $data_config['page_feature_video_type'] : $default_opts['page_feature_video_type'],
					'page_feature_video_url_youtube' 	=> (isset( $data_config['page_feature_video_url_youtube']) && !empty( $data_config['page_feature_video_url_youtube']) ) ? $data_config['page_feature_video_url_youtube'] : $default_opts['page_feature_video_url_youtube'],
					'page_feature_video_url_vimeo' 		=> (isset( $data_config['page_feature_video_url_vimeo']) && !empty( $data_config['page_feature_video_url_vimeo']) ) ? $data_config['page_feature_video_url_vimeo'] : $default_opts['page_feature_video_url_vimeo'],
					'page_feature_video_url_mp4' 		=> (isset( $data_config['page_feature_video_url_mp4']) && !empty( $data_config['page_feature_video_url_mp4']) ) ? $data_config['page_feature_video_url_mp4'] : $default_opts['page_feature_video_url_mp4'],
					'page_feature_video_url_ogg' 		=> (isset( $data_config['page_feature_video_url_ogg']) && !empty( $data_config['page_feature_video_url_ogg']) ) ? $data_config['page_feature_video_url_ogg'] : $default_opts['page_feature_video_url_ogg'],
					'page_feature_video_url_webm' 		=> (isset( $data_config['page_feature_video_url_webm']) && !empty( $data_config['page_feature_video_url_webm']) ) ? $data_config['page_feature_video_url_webm'] : $default_opts['page_feature_video_url_webm'],
						
					'disable_footer'				=> (isset( $data_config['disable_footer']) && catanis_check_option_bool( $data_config['disable_footer'] ) ) ? true : false,
					'footer_style'					=> (isset( $data_config['footer_style']) && !empty( $data_config['footer_style'])) ? $data_config['footer_style'] : $default_opts['footer_style'],
					'footer_logo'					=> (isset( $data_config['footer_logo']) && !empty( $data_config['footer_logo'])) ? $data_config['footer_logo'] : $default_opts['footer_logo'],
					'footer_background'				=> (isset( $data_config['footer_background']) && !empty( $data_config['footer_background'])) ? $data_config['footer_background'] : '',
					'footer_top_color_scheme'		=> (isset( $data_config['footer_top_color_scheme']) && !empty( $data_config['footer_top_color_scheme'])) ? $data_config['footer_top_color_scheme'] : $default_opts['footer_top_color_scheme'],
					'footer_bottom_color_scheme' 	=> (isset( $data_config['footer_bottom_color_scheme']) && !empty( $data_config['footer_bottom_color_scheme'])) ? $data_config['footer_bottom_color_scheme'] : $default_opts['footer_bottom_color_scheme'],
						
					'comment_enable'				=> (isset( $data_config['comment_enable']) && catanis_check_option_bool( $data_config['comment_enable'] ) ) ? true : false,
					'audio_use' 					=> (isset( $data_config['audio_use']) && !empty( $data_config['audio_use'])) ? $data_config['audio_use'] : '',
					'audio_mp3' 					=> (isset( $data_config['audio_mp3']) && !empty( $data_config['audio_mp3'])) ? $data_config['audio_mp3'] : '',
					'audio_autoplay'				=> (isset( $data_config['audio_autoplay']) && catanis_check_option_bool( $data_config['audio_autoplay'] ) ) ? true : false,
					'audio_soundcloud' 				=> (isset( $data_config['audio_soundcloud']) && !empty( $data_config['audio_soundcloud'])) ? $data_config['audio_soundcloud'] : '',
				);
			}
			
			/*Check VC Enable*/
			$vc_enabled = get_post_meta($page_id, '_wpb_vc_js_status', true);
			$vc_enabled = catanis_check_option_bool( $vc_enabled );
			
			$post = get_post();
			if ( $post && preg_match( '/vc_row/', $post->post_content ) ) {
				$vc_enabled = true;
			}
			$catanis_page['vc_enabled'] = $vc_enabled;
			
			if(function_exists('is_shop') && is_shop() ){
				catanis_remove_hooks_from_shop_loop();
			}
			
			$catanis_page = array_merge($default_opts, $catanis_page);
			
		} elseif ( is_tax('portfolio_category') || is_category()) {
			
			/* Default Options*/
			$default_opts['page_title_style'] 		= 'style1';
			$default_opts['show_breadcrumb'] 		= true;
			$default_opts['page_feature_size'] 		= catanis_option('woo_page_feature_size');
			$default_opts['page_feature_height'] 	= catanis_option('woo_page_feature_height');
			$default_opts['page_feature_minheight'] = catanis_option('woo_page_feature_minheight');
			
			if(is_tax('portfolio_category')){
				$key_save = Catanis_Posttype_Portfolio::$_key_save_custom;
				$default_opts['layout'] 	= catanis_option( 'portfolio_layout' );
				$default_opts['sidebar'] 	= catanis_option( 'portfolio_sidebar' );
		
			}else{
				$key_save = Catanis_Custom_Fields_Category::$_key_save_custom;
				$default_opts['layout'] 	= catanis_option( 'blog_layout' );
				$default_opts['sidebar'] 	= catanis_option( 'blog_sidebar' );
			}
		
			$option_arr = get_option( $key_save, array() );
			if( is_array( $option_arr ) && count( $option_arr ) > 0 ){
		
				$term_id = get_queried_object()->term_id;
				if( $term_id > 0 && isset( $option_arr[$term_id] ) ) {
					$custom_data = $option_arr[$term_id];
					
					if ($custom_data['layout'] != 'default'){
						$catanis_page['layout'] 		= $custom_data['layout'];
					}
					if ($custom_data['sidebar'] != 'default'){
						$catanis_page['sidebar'] 		= $custom_data['sidebar'];
					}
					if ($custom_data['header_overlap'] != 'default'){
						$catanis_page['header_overlap'] 	= catanis_check_option_bool( $custom_data['header_overlap'] ) ? true : false ;
		
						if( catanis_check_option_bool( $custom_data['header_overlap'] )){
							$catanis_page['menu_color_style'] 			= 'light';
							$default_opts['page_feature_minheight'] 	+= 80;
						}
					}
					if( absint($custom_data['breadcrumb_id']) > 0) {
						$header_bg = wp_get_attachment_url($custom_data['breadcrumb_id']);
						$catanis_page['page_title_bg'] 	= trim( $header_bg );
					}
						
				}
			}
			$catanis_page = array_merge($default_opts, $catanis_page);
			
		}elseif( is_tax('product_cat') ){	
			
			/* Default Options*/
			$default_opts['page_title_style'] 		= catanis_option('woo_page_title_style');
			$default_opts['show_breadcrumb'] 		= catanis_option('woo_show_breadcrumb');
			$default_opts['page_feature_size'] 		= catanis_option('woo_page_feature_size');
			$default_opts['page_feature_height'] 	= catanis_option('woo_page_feature_height');
			$default_opts['page_feature_minheight'] = catanis_option('woo_page_feature_minheight');
			$default_opts['layout'] 				= catanis_option( 'procate_layout' );
			$default_opts['sidebar'] 				= catanis_option( 'procate_sidebar' );
			
			/* For WC Market Place */
			if(is_tax( 'dc_vendor_shop' )){
				$default_opts['page_title_enable'] = false;
			}
			
			$key_save = Catanis_Custom_Woo_Term::$_key_save_custom;
			
			$option_arr = get_option( $key_save, array() );
			if( is_array( $option_arr ) && count( $option_arr ) > 0 ){
					
				$term_id = get_queried_object()->term_id;
				if( $term_id > 0 && isset( $option_arr[$term_id] ) ) {
					$custom_data = $option_arr[$term_id];
			
					if ($custom_data['layout'] != 'default'){
						$catanis_page['layout'] 		= $custom_data['layout'];
					}
					if ($custom_data['sidebar'] != 'default'){
						$catanis_page['sidebar'] 		= $custom_data['sidebar'];
					}
					if ($custom_data['header_overlap'] != 'default'){
						$catanis_page['header_overlap'] 	= catanis_check_option_bool( $custom_data['header_overlap'] ) ? true : false ;
			
						if( catanis_check_option_bool( $custom_data['header_overlap'] )){
							$catanis_page['menu_color_style'] 			= 'light';
							$default_opts['page_feature_minheight'] 	+= 80;
						}
					}
					if( absint($custom_data['breadcrumb_id']) > 0) {
						$header_bg = wp_get_attachment_url($custom_data['breadcrumb_id']);
						$catanis_page['page_title_bg'] 	= trim( $header_bg );
					}
						
				}
			}
			
			catanis_remove_hooks_from_shop_loop();
			$catanis_page = array_merge($default_opts, $catanis_page);
			
		} elseif ( is_singular( 'product' ) ) {
			
			/* Default Options*/
			$default_opts['layout'] 				= catanis_option( 'prodetail_layout' );
			$default_opts['sidebar'] 				= catanis_option( 'prodetail_sidebar' );
			
			$default_opts['page_title_enable'] 		= $default_opts['woo_page_title_enable'];
			$default_opts['page_title_style'] 		= $default_opts['woo_page_title_style'];
			$default_opts['show_breadcrumb'] 		= $default_opts['woo_show_breadcrumb'];
			$default_opts['page_title_position'] 	= $default_opts['woo_page_title_position'];
			$default_opts['page_title_bg'] 			= $default_opts['woo_page_title_bg'];
			$default_opts['page_title_bg_alignment'] = $default_opts['woo_page_title_bg_alignment'];
			
			$default_opts['page_feature_size'] 		= $default_opts['woo_page_feature_size'];
			$default_opts['page_feature_height'] 	= $default_opts['woo_page_feature_height'];
			$default_opts['page_feature_minheight'] = $default_opts['woo_page_feature_minheight'];
			$default_opts['comment_enable'] 		= false;
			
			$data_config = get_post_meta( $post->ID, Catanis_Meta::$meta_key, true );
			if ( is_array( $data_config ) && ! empty( $data_config ) ) {
				
				$catanis_page = array(
							
					'layout'					=> (isset( $data_config['layout']) && $data_config['layout'] != 'default') ? $data_config['layout'] : $default_opts['layout'],
					'sidebar'					=> (isset( $data_config['sidebar']) && $data_config['sidebar'] != 'default') ? $data_config['sidebar'] : $default_opts['sidebar'],
					'header_overlap' 			=> (isset( $data_config['header_overlap']) && !catanis_check_option_bool( $data_config['header_overlap'] ) ) ? false : true,
					'header_bg_color'			=> (isset( $data_config['header_bg_color']) && !empty( $data_config['header_bg_color'])) ? $data_config['header_bg_color'] : '',
					'header_style'				=> (isset( $data_config['header_style']) && !empty( $data_config['header_style'])) ? $data_config['header_style'] : $default_opts['header_style'],
					'header_bg'					=> (isset( $data_config['header_bg']) && !empty( $data_config['header_bg'])) ? $data_config['header_bg'] : $default_opts['header_bg'],
					'show_store_notice' 		=> (isset( $data_config['show_store_notice']) && !catanis_check_option_bool( $data_config['show_store_notice'] ) ) ? false : true,
					'menu_color_style'			=> (isset( $data_config['menu_color_style']) && !empty( $data_config['menu_color_style'])) ? $data_config['menu_color_style'] : $default_opts['menu_color_style'],
					'main_navigation_menu'		=> (isset( $data_config['main_navigation_menu']) && !empty( $data_config['main_navigation_menu'])) ? $data_config['main_navigation_menu'] : $default_opts['main_navigation_menu'],
					'custom_logo'				=> (isset( $data_config['custom_logo']) && !empty($data_config['custom_logo']) ) ? $data_config['custom_logo'] : '',
					'sticky_logo'				=> (isset( $data_config['sticky_logo']) && !empty($data_config['sticky_logo']) ) ? $data_config['sticky_logo'] : $default_opts['sticky_logo'],
					'show_header_cart' 			=> (isset( $data_config['show_header_cart']) && !catanis_check_option_bool( $data_config['show_header_cart'] ) ) ? false : true,
					'show_slideout_widget' 		=> (isset( $data_config['show_slideout_widget']) && !catanis_check_option_bool( $data_config['show_slideout_widget'] ) ) ? false : true,
					'show_header_search' 		=> (isset( $data_config['show_header_search']) && !catanis_check_option_bool( $data_config['show_header_search'] ) ) ? false : true,
					'show_header_socials' 		=> (isset( $data_config['show_header_socials']) && !catanis_check_option_bool( $data_config['show_header_socials'] ) ) ? false : true,
					'show_header_phone' 		=> (isset( $data_config['show_header_phone']) && !catanis_check_option_bool( $data_config['show_header_phone'] ) ) ? false : true,
					'show_header_email' 		=> (isset( $data_config['show_header_email']) && !catanis_check_option_bool( $data_config['show_header_email'] ) ) ? false : true,
					'show_header_address' 		=> (isset( $data_config['show_header_address']) && !catanis_check_option_bool( $data_config['show_header_address'] ) ) ? false : true,
						
					'page_title_enable' 		=> (isset( $data_config['page_title_enable']) && !catanis_check_option_bool( $data_config['page_title_enable'] ) ) ? false : true,
					'page_title_style'			=> (isset( $data_config['page_title_style']) && !empty($data_config['page_title_style'])) ? $data_config['page_title_style'] : $default_opts['woo_page_title_style'],
					'show_breadcrumb' 			=> (isset( $data_config['show_breadcrumb']) && catanis_check_option_bool( $data_config['show_breadcrumb'] ) ) ? true : false,
					'page_title_position'		=> (isset( $data_config['page_title_position']) && !empty( $data_config['page_title_position'])) ? $data_config['page_title_position'] : $default_opts['woo_page_title_position'],
					'page_title_bg'				=> (isset( $data_config['page_title_bg']) && !empty( $data_config['page_title_bg'])) ? $data_config['page_title_bg'] : '',
					'page_title_bg_alignment'	=> (isset( $data_config['page_title_bg_alignment']) && !empty( $data_config['page_title_bg_alignment'])) ? $data_config['page_title_bg_alignment'] : $default_opts['woo_page_title_bg_alignment'],
					'page_title_overlay'		=> (isset( $data_config['page_title_overlay']) && catanis_check_option_bool( $data_config['page_title_overlay'] ) ) ? true : false,
					'page_title_overlay_color'	=> (isset( $data_config['page_title_overlay_color']) && !empty( $data_config['page_title_overlay_color'])) ? $data_config['page_title_overlay_color'] : $default_opts['page_title_overlay_color'],
					'page_title_parallax'		=> (isset( $data_config['page_title_parallax']) && catanis_check_option_bool( $data_config['page_title_parallax'] ) ) ? true : false,
					'page_title_title'			=> (isset( $data_config['page_title_title']) && !empty( $data_config['page_title_title'])) ? $data_config['page_title_title'] : '',
					'page_title_subtitle'		=> (isset( $data_config['page_title_subtitle']) && !empty( $data_config['page_title_subtitle'])) ? $data_config['page_title_subtitle'] : '',
					'page_title_bg_color'		=> (isset( $data_config['page_title_bg_color']) && !empty( $data_config['page_title_bg_color'])) ? $data_config['page_title_bg_color'] : $default_opts['page_title_bg_color'],
					'page_title_font_color'		=> (isset( $data_config['page_title_font_color']) && !empty( $data_config['page_title_font_color'])) ? $data_config['page_title_font_color'] : $default_opts['page_title_font_color'],
					
					'page_feature_type'				=> (isset( $data_config['page_feature_type']) && !empty( $data_config['page_feature_type']) ) ? $data_config['page_feature_type'] : $default_opts['page_feature_type'],
					'page_feature_size'				=> (isset( $data_config['page_feature_size']) && !empty( $data_config['page_feature_size']) ) ? $data_config['page_feature_size'] : $default_opts['woo_page_feature_size'],
					'page_feature_height'			=> (isset( $data_config['page_feature_height']) && !empty( $data_config['page_feature_height']) ) ? $data_config['page_feature_height'] : $default_opts['woo_page_feature_height'],
					'page_feature_minheight'		=> (isset( $data_config['page_feature_minheight']) && !empty( $data_config['page_feature_minheight']) ) ? $data_config['page_feature_minheight'] : $default_opts['woo_page_feature_minheight'],
					'page_feature_revslider' 		=> (isset( $data_config['page_feature_revslider']) && !empty( $data_config['page_feature_revslider']) ) ? $data_config['page_feature_revslider'] : $default_opts['page_feature_revslider'],
					'page_feature_slider_items' 	=> (isset( $data_config['page_feature_slider_items']) && !empty( $data_config['page_feature_slider_items']) ) ? $data_config['page_feature_slider_items'] : $default_opts['page_feature_slider_items'],
					'page_feature_map_pin' 			=> (isset( $data_config['page_feature_map_pin']) && !empty( $data_config['page_feature_map_pin']) ) ? $data_config['page_feature_map_pin'] : $default_opts['page_feature_map_pin'],
					'page_feature_map_style' 		=> (isset( $data_config['page_feature_map_style']) && !empty( $data_config['page_feature_map_style']) ) ? $data_config['page_feature_map_style'] : $default_opts['page_feature_map_style'],
					'page_feature_map_zoom' 		=> (isset( $data_config['page_feature_map_zoom']) && !empty( $data_config['page_feature_map_zoom']) ) ? $data_config['page_feature_map_zoom'] : $default_opts['page_feature_map_zoom'],
					'page_feature_map_address1' 	=> (isset( $data_config['page_feature_map_address1']) && !empty( $data_config['page_feature_map_address1']) ) ? $data_config['page_feature_map_address1'] : $default_opts['page_feature_map_address1'],
					'page_feature_map_address2' 	=> (isset( $data_config['page_feature_map_address2']) && !empty( $data_config['page_feature_map_address2']) ) ? $data_config['page_feature_map_address2'] : $default_opts['page_feature_map_address2'],
					'page_feature_map_address3' 	=> (isset( $data_config['page_feature_map_address3']) && !empty( $data_config['page_feature_map_address3']) ) ? $data_config['page_feature_map_address3'] : $default_opts['page_feature_map_address3'],
					'page_feature_map_address4' 	=> (isset( $data_config['page_feature_map_address4']) && !empty( $data_config['page_feature_map_address4']) ) ? $data_config['page_feature_map_address4'] : $default_opts['page_feature_map_address4'],
					'page_feature_map_address5' 	=> (isset( $data_config['page_feature_map_address5']) && !empty( $data_config['page_feature_map_address5']) ) ? $data_config['page_feature_map_address5'] : $default_opts['page_feature_map_address5'],
					'page_feature_video_type' 			=> (isset( $data_config['page_feature_video_type']) && !empty( $data_config['page_feature_video_type']) ) ? $data_config['page_feature_video_type'] : $default_opts['page_feature_video_type'],
					'page_feature_video_url_youtube' 	=> (isset( $data_config['page_feature_video_url_youtube']) && !empty( $data_config['page_feature_video_url_youtube']) ) ? $data_config['page_feature_video_url_youtube'] : $default_opts['page_feature_video_url_youtube'],
					'page_feature_video_url_vimeo' 		=> (isset( $data_config['page_feature_video_url_vimeo']) && !empty( $data_config['page_feature_video_url_vimeo']) ) ? $data_config['page_feature_video_url_vimeo'] : $default_opts['page_feature_video_url_vimeo'],
					'page_feature_video_url_mp4' 		=> (isset( $data_config['page_feature_video_url_mp4']) && !empty( $data_config['page_feature_video_url_mp4']) ) ? $data_config['page_feature_video_url_mp4'] : $default_opts['page_feature_video_url_mp4'],
					'page_feature_video_url_ogg' 		=> (isset( $data_config['page_feature_video_url_ogg']) && !empty( $data_config['page_feature_video_url_ogg']) ) ? $data_config['page_feature_video_url_ogg'] : $default_opts['page_feature_video_url_ogg'],
					'page_feature_video_url_webm' 		=> (isset( $data_config['page_feature_video_url_webm']) && !empty( $data_config['page_feature_video_url_webm']) ) ? $data_config['page_feature_video_url_webm'] : $default_opts['page_feature_video_url_webm'],
						
					'disable_footer'				=> (isset( $data_config['disable_footer']) && catanis_check_option_bool( $data_config['disable_footer'] ) ) ? true : false,
					'footer_style'					=> (isset( $data_config['footer_style']) && !empty( $data_config['footer_style'])) ? $data_config['footer_style'] : $default_opts['footer_style'],
					'footer_logo'					=> (isset( $data_config['footer_logo']) && !empty( $data_config['footer_logo'])) ? $data_config['footer_logo'] : $default_opts['footer_logo'],
					'footer_background'				=> (isset( $data_config['footer_background']) && !empty( $data_config['footer_background'])) ? $data_config['footer_background'] : '',
					'footer_top_color_scheme'		=> (isset( $data_config['footer_top_color_scheme']) && !empty( $data_config['footer_top_color_scheme'])) ? $data_config['footer_top_color_scheme'] : $default_opts['footer_top_color_scheme'],
					'footer_bottom_color_scheme' 	=> (isset( $data_config['footer_bottom_color_scheme']) && !empty( $data_config['footer_bottom_color_scheme'])) ? $data_config['footer_bottom_color_scheme'] : $default_opts['footer_bottom_color_scheme'],
			
					'prodetail_thumbnails_style' 	=> (isset( $data_config['prodetail_thumbnails_style']) && !empty( $data_config['prodetail_thumbnails_style'])) ? $data_config['prodetail_thumbnails_style'] : catanis_option( 'prodetail_thumbnails_style' ),
					'prodetail_enable_cloudzoom' 	=> (isset( $data_config['prodetail_enable_cloudzoom']) && !catanis_check_option_bool( $data_config['prodetail_enable_cloudzoom'] ) ) ? false : true,
					'prodetail_enable_title' 		=> (isset( $data_config['prodetail_enable_title']) && !catanis_check_option_bool( $data_config['prodetail_enable_title'] ) ) ? false : true,
					'prodetail_enable_label' 		=> (isset( $data_config['prodetail_enable_label']) && !catanis_check_option_bool( $data_config['prodetail_enable_label'] ) ) ? false : true,
					'prodetail_enable_availability'	=> (isset( $data_config['prodetail_enable_availability']) && catanis_check_option_bool( $data_config['prodetail_enable_availability'] ) ) ? true : false,
					'prodetail_enable_price' 		=> (isset( $data_config['prodetail_enable_price']) && !catanis_check_option_bool( $data_config['prodetail_enable_price'] )) ? false : true,
					'prodetail_enable_rating' 		=> (isset( $data_config['prodetail_enable_rating']) && !catanis_check_option_bool( $data_config['prodetail_enable_rating'] ) ) ? false : true,
					'prodetail_enable_excerpt' 		=> (isset( $data_config['prodetail_enable_excerpt']) && !catanis_check_option_bool( $data_config['prodetail_enable_excerpt'] ) ) ? false : true,
					'prodetail_enable_addtocart' 	=> (isset( $data_config['prodetail_enable_addtocart']) && !catanis_check_option_bool( $data_config['prodetail_enable_addtocart'] ) ) ? false : true,
					'prodetail_enable_meta' 		=> (isset( $data_config['prodetail_enable_meta']) && !catanis_check_option_bool( $data_config['prodetail_enable_meta'] ) ) ? false : true,
					'prodetail_enable_pagination' 	=> (isset( $data_config['prodetail_enable_pagination']) && !catanis_check_option_bool( $data_config['prodetail_enable_pagination'] ) ) ? false : true,
					'prodetail_enable_sharebox' 	=> (isset( $data_config['prodetail_enable_sharebox']) && !catanis_check_option_bool( $data_config['prodetail_enable_sharebox'] ) ) ? false : true,
					'prodetail_enable_shippingbox' 	=> (isset( $data_config['prodetail_enable_shippingbox']) && !catanis_check_option_bool( $data_config['prodetail_enable_shippingbox'] ) ) ? false : true,
					'prodetail_enable_related' 		=> (isset( $data_config['prodetail_enable_related']) && !catanis_check_option_bool( $data_config['prodetail_enable_related'] ) ) ? false : true,
					'prodetail_enable_upsells' 		=> (isset( $data_config['prodetail_enable_upsells']) && catanis_check_option_bool( $data_config['prodetail_enable_upsells'] ) ) ? true : false,
						
					'prodetail_custom_tabs'			=> (isset( $data_config['prodetail_custom_tabs']) && !empty( $data_config['prodetail_custom_tabs'])) ? true : false,
					'prodetail_custom_tabs_title'	=> (isset( $data_config['prodetail_custom_tabs_title']) && !empty( $data_config['prodetail_custom_tabs_title'])) ? $data_config['prodetail_custom_tabs_title'] : '',
					'prodetail_custom_tabs_content'	=> (isset( $data_config['prodetail_custom_tabs_content']) && !empty( $data_config['prodetail_custom_tabs_content'])) ? $data_config['prodetail_custom_tabs_content'] : '',
						
				);
			}
			
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && $post->comment_status === 'open' ){
				$catanis_page['comment_enable'] = true;
			}
			
			$catanis_page = array_merge($default_opts, $catanis_page);
			
			/* Remove hooks on Related and Up-Sell products */
			catanis_remove_hooks_from_shop_loop();
			
			/* Remove hooks on single product */
			if( isset($catanis_page['prodetail_enable_title']) && !$catanis_page['prodetail_enable_title'] ){
				remove_action('catanis_hook_top_single_product', 'woocommerce_template_single_title', 30);
			}
			
			if( isset($catanis_page['prodetail_enable_label']) && !$catanis_page['prodetail_enable_label'] ){
				remove_action('catanis_hook_before_product_image', 'catanis_template_loop_product_label', 10);
			}
			
			if( isset($catanis_page['prodetail_enable_rating']) && !$catanis_page['prodetail_enable_rating'] ){
				remove_action('catanis_hook_top_single_product', 'woocommerce_template_single_rating', 40);
			}
			
			if( isset($catanis_page['prodetail_enable_availability']) && !$catanis_page['prodetail_enable_availability'] ){
				remove_action('woocommerce_single_product_summary', 'catanis_template_single_availability', 11);
			}
			
			if( isset($catanis_page['prodetail_enable_price']) && !$catanis_page['prodetail_enable_price'] ){
				remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
				remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
			}
			
			if( isset($catanis_page['prodetail_enable_excerpt']) && !$catanis_page['prodetail_enable_excerpt'] ){
				remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
			}
			
			if( (isset($catanis_page['prodetail_enable_addtocart']) && !$catanis_page['prodetail_enable_addtocart']) || catanis_option('woo_catalog_mode') ){
				$terms        = get_the_terms( $post->ID, 'product_type' );
				$product_type = ! empty( $terms ) ? sanitize_title( current( $terms )->name ) : 'simple';
				if( $product_type != 'variable' ){
					remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
				}else{
					remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
				}
			}
			
			if( isset($catanis_page['prodetail_enable_meta']) && !$catanis_page['prodetail_enable_meta'] ){
				remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
			}
			
			if( isset($catanis_page['prodetail_enable_pagination']) && !$catanis_page['prodetail_enable_pagination'] ){
				remove_action('catanis_hook_top_single_product', 'catanis_template_single_navigation', 5);
			}
			
			if( isset($catanis_page['prodetail_enable_sharebox']) && !$catanis_page['prodetail_enable_sharebox'] ){
				remove_action('woocommerce_share', 'catanis_template_single_social_sharing', 10);
			}
			
			if( isset($catanis_page['prodetail_enable_shippingbox']) && !$catanis_page['prodetail_enable_shippingbox'] ){
				remove_action('woocommerce_single_product_summary', 'catanis_template_single_shippingbox', 70);
			}
			
			if( isset($catanis_page['prodetail_enable_upsells']) && !$catanis_page['prodetail_enable_upsells'] ){
				remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
			}
			
			if( isset($catanis_page['prodetail_enable_related']) && !$catanis_page['prodetail_enable_related'] ){
				remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
			}

		} elseif ( is_singular( 'post' ) ) {
			
			/* Default Options*/	
			$default_opts['show_related_post'] = catanis_option ( 'blog_single_display_related' );
			$default_opts['show_author_bio'] = false;
			$default_opts['comment_enable'] = ($post->comment_status === 'open' || $post->ping_status === 'open') ? true : false;
			
			$data_config = get_post_meta( $post->ID, Catanis_Meta::$meta_key, true );
			if ( is_array( $data_config ) && ! empty( $data_config ) ) {

				$catanis_page = array(
							
					'layout'					=> (isset( $data_config['layout']) && $data_config['layout'] != 'default') ? $data_config['layout'] : $default_opts['layout'],
					'sidebar'					=> (isset( $data_config['sidebar']) && $data_config['sidebar'] != 'default') ? $data_config['sidebar'] : $default_opts['sidebar'],
					'header_overlap' 			=> (isset( $data_config['header_overlap']) && !catanis_check_option_bool( $data_config['header_overlap'] ) ) ? false : true,
					'header_bg_color'			=> (isset( $data_config['header_bg_color']) && !empty( $data_config['header_bg_color'])) ? $data_config['header_bg_color'] : '',
					'header_style'				=> (isset( $data_config['header_style']) && !empty( $data_config['header_style'])) ? $data_config['header_style'] : $default_opts['header_style'],
					'header_bg'					=> (isset( $data_config['header_bg']) && !empty( $data_config['header_bg'])) ? $data_config['header_bg'] : $default_opts['header_bg'],
					'show_store_notice' 		=> (isset( $data_config['show_store_notice']) && !catanis_check_option_bool( $data_config['show_store_notice'] ) ) ? false : true,
					'menu_color_style'			=> (isset( $data_config['menu_color_style']) && !empty( $data_config['menu_color_style'])) ? $data_config['menu_color_style'] : $default_opts['menu_color_style'],
					'main_navigation_menu'		=> (isset( $data_config['main_navigation_menu']) && !empty( $data_config['main_navigation_menu'])) ? $data_config['main_navigation_menu'] : $default_opts['main_navigation_menu'],
					'custom_logo'				=> (isset( $data_config['custom_logo']) && !empty($data_config['custom_logo']) ) ? $data_config['custom_logo'] : '',
					'sticky_logo'				=> (isset( $data_config['sticky_logo']) && !empty($data_config['sticky_logo']) ) ? $data_config['sticky_logo'] : $default_opts['sticky_logo'],
					'show_header_cart' 			=> (isset( $data_config['show_header_cart']) && !catanis_check_option_bool( $data_config['show_header_cart'] ) ) ? false : true,
					'show_slideout_widget' 		=> (isset( $data_config['show_slideout_widget']) && !catanis_check_option_bool( $data_config['show_slideout_widget'] ) ) ? false : true,
					'show_header_search' 		=> (isset( $data_config['show_header_search']) && !catanis_check_option_bool( $data_config['show_header_search'] ) ) ? false : true,
					'show_header_socials' 		=> (isset( $data_config['show_header_socials']) && !catanis_check_option_bool( $data_config['show_header_socials'] ) ) ? false : true,
					'show_header_phone' 		=> (isset( $data_config['show_header_phone']) && !catanis_check_option_bool( $data_config['show_header_phone'] ) ) ? false : true,
					'show_header_email' 		=> (isset( $data_config['show_header_email']) && !catanis_check_option_bool( $data_config['show_header_email'] ) ) ? false : true,
					'show_header_address' 		=> (isset( $data_config['show_header_address']) && !catanis_check_option_bool( $data_config['show_header_address'] ) ) ? false : true,
					
					'page_title_enable' 		=> (isset( $data_config['page_title_enable']) && !catanis_check_option_bool( $data_config['page_title_enable'] ) ) ? false : true,
					'page_title_style'			=> (isset( $data_config['page_title_style']) && !empty($data_config['page_title_style'])) ? $data_config['page_title_style'] : $default_opts['page_title_style'],
					'show_breadcrumb' 			=> (isset( $data_config['show_breadcrumb']) && catanis_check_option_bool( $data_config['show_breadcrumb'] ) ) ? true : false,
					'page_title_position'		=> (isset( $data_config['page_title_position']) && !empty( $data_config['page_title_position'])) ? $data_config['page_title_position'] : $default_opts['page_title_position'],
					'page_title_bg'				=> (isset( $data_config['page_title_bg']) && !empty( $data_config['page_title_bg'])) ? $data_config['page_title_bg'] : '',
					'page_title_bg_alignment'	=> (isset( $data_config['page_title_bg_alignment']) && !empty( $data_config['page_title_bg_alignment'])) ? $data_config['page_title_bg_alignment'] : $default_opts['page_title_bg_alignment'],
					'page_title_overlay'		=> (isset( $data_config['page_title_overlay']) && catanis_check_option_bool( $data_config['page_title_overlay'] ) ) ? true : false,
					'page_title_overlay_color'	=> (isset( $data_config['page_title_overlay_color']) && !empty( $data_config['page_title_overlay_color'])) ? $data_config['page_title_overlay_color'] : $default_opts['page_title_overlay_color'],
					'page_title_parallax'		=> (isset( $data_config['page_title_parallax']) && catanis_check_option_bool( $data_config['page_title_parallax'] ) ) ? true : false,
					'page_title_title'			=> (isset( $data_config['page_title_title']) && !empty( $data_config['page_title_title'])) ? $data_config['page_title_title'] : '',
					'page_title_subtitle'		=> (isset( $data_config['page_title_subtitle']) && !empty( $data_config['page_title_subtitle'])) ? $data_config['page_title_subtitle'] : '',
					'page_title_bg_color'		=> (isset( $data_config['page_title_bg_color']) && !empty( $data_config['page_title_bg_color'])) ? $data_config['page_title_bg_color'] : $default_opts['page_title_bg_color'],
					'page_title_font_color'		=> (isset( $data_config['page_title_font_color']) && !empty( $data_config['page_title_font_color'])) ? $data_config['page_title_font_color'] : $default_opts['page_title_font_color'],

					'page_feature_type'			=> (isset( $data_config['page_feature_type']) && !empty( $data_config['page_feature_type']) ) ? $data_config['page_feature_type'] : $default_opts['page_feature_type'],
					'page_feature_size'			=> (isset( $data_config['page_feature_size']) && !empty( $data_config['page_feature_size']) ) ? $data_config['page_feature_size'] : $default_opts['page_feature_size'],
					'page_feature_height'		=> (isset( $data_config['page_feature_height']) && !empty( $data_config['page_feature_height']) ) ? $data_config['page_feature_height'] : $default_opts['page_feature_height'],
					'page_feature_minheight'	=> (isset( $data_config['page_feature_minheight']) && !empty( $data_config['page_feature_minheight']) ) ? $data_config['page_feature_minheight'] : $default_opts['page_feature_minheight'],
					'page_feature_revslider' 	=> (isset( $data_config['page_feature_revslider']) && !empty( $data_config['page_feature_revslider']) ) ? $data_config['page_feature_revslider'] : $default_opts['page_feature_revslider'],
					'page_feature_slider_items' => (isset( $data_config['page_feature_slider_items']) && !empty( $data_config['page_feature_slider_items']) ) ? $data_config['page_feature_slider_items'] : $default_opts['page_feature_slider_items'],
					'page_feature_map_pin' 		=> (isset( $data_config['page_feature_map_pin']) && !empty( $data_config['page_feature_map_pin']) ) ? $data_config['page_feature_map_pin'] : $default_opts['page_feature_map_pin'],
					'page_feature_map_style' 	=> (isset( $data_config['page_feature_map_style']) && !empty( $data_config['page_feature_map_style']) ) ? $data_config['page_feature_map_style'] : $default_opts['page_feature_map_style'],
					'page_feature_map_zoom' 	=> (isset( $data_config['page_feature_map_zoom']) && !empty( $data_config['page_feature_map_zoom']) ) ? $data_config['page_feature_map_zoom'] : $default_opts['page_feature_map_zoom'],
					'page_feature_map_address1' => (isset( $data_config['page_feature_map_address1']) && !empty( $data_config['page_feature_map_address1']) ) ? $data_config['page_feature_map_address1'] : $default_opts['page_feature_map_address1'],
					'page_feature_map_address2' => (isset( $data_config['page_feature_map_address2']) && !empty( $data_config['page_feature_map_address2']) ) ? $data_config['page_feature_map_address2'] : $default_opts['page_feature_map_address2'],
					'page_feature_map_address3' => (isset( $data_config['page_feature_map_address3']) && !empty( $data_config['page_feature_map_address3']) ) ? $data_config['page_feature_map_address3'] : $default_opts['page_feature_map_address3'],
					'page_feature_map_address4' => (isset( $data_config['page_feature_map_address4']) && !empty( $data_config['page_feature_map_address4']) ) ? $data_config['page_feature_map_address4'] : $default_opts['page_feature_map_address4'],
					'page_feature_map_address5' => (isset( $data_config['page_feature_map_address5']) && !empty( $data_config['page_feature_map_address5']) ) ? $data_config['page_feature_map_address5'] : $default_opts['page_feature_map_address5'],
					'page_feature_video_type' 	=> (isset( $data_config['page_feature_video_type']) && !empty( $data_config['page_feature_video_type']) ) ? $data_config['page_feature_video_type'] : $default_opts['page_feature_video_type'],
					'page_feature_video_url_youtube' 	=> (isset( $data_config['page_feature_video_url_youtube']) && !empty( $data_config['page_feature_video_url_youtube']) ) ? $data_config['page_feature_video_url_youtube'] : $default_opts['page_feature_video_url_youtube'],
					'page_feature_video_url_vimeo' 		=> (isset( $data_config['page_feature_video_url_vimeo']) && !empty( $data_config['page_feature_video_url_vimeo']) ) ? $data_config['page_feature_video_url_vimeo'] : $default_opts['page_feature_video_url_vimeo'],
					'page_feature_video_url_mp4' 		=> (isset( $data_config['page_feature_video_url_mp4']) && !empty( $data_config['page_feature_video_url_mp4']) ) ? $data_config['page_feature_video_url_mp4'] : $default_opts['page_feature_video_url_mp4'],
					'page_feature_video_url_ogg' 		=> (isset( $data_config['page_feature_video_url_ogg']) && !empty( $data_config['page_feature_video_url_ogg']) ) ? $data_config['page_feature_video_url_ogg'] : $default_opts['page_feature_video_url_ogg'],
					'page_feature_video_url_webm' 		=> (isset( $data_config['page_feature_video_url_webm']) && !empty( $data_config['page_feature_video_url_webm']) ) ? $data_config['page_feature_video_url_webm'] : $default_opts['page_feature_video_url_webm'],
						
					'disable_footer'			=> (isset( $data_config['disable_footer']) && catanis_check_option_bool( $data_config['disable_footer'] ) ) ? true : false,
					'footer_style'				=> (isset( $data_config['footer_style']) && !empty( $data_config['footer_style'])) ? $data_config['footer_style'] : $default_opts['footer_style'],
					'footer_logo'				=> (isset( $data_config['footer_logo']) && !empty( $data_config['footer_logo'])) ? $data_config['footer_logo'] : $default_opts['footer_logo'],
					'footer_background'			=> (isset( $data_config['footer_background']) && !empty( $data_config['footer_background'])) ? $data_config['footer_background'] : '',
					'footer_top_color_scheme'	=> (isset( $data_config['footer_top_color_scheme']) && !empty( $data_config['footer_top_color_scheme'])) ? $data_config['footer_top_color_scheme'] : $default_opts['footer_top_color_scheme'],
					'footer_bottom_color_scheme' => (isset( $data_config['footer_bottom_color_scheme']) && !empty( $data_config['footer_bottom_color_scheme'])) ? $data_config['footer_bottom_color_scheme'] : $default_opts['footer_bottom_color_scheme'],
			
					'comment_enable'			=> (isset( $data_config['comment_enable']) && catanis_check_option_bool( $data_config['comment_enable'] ) ) ? true : false,
					'show_related_post'			=> (isset( $data_config['show_related_post']) && catanis_check_option_bool( $data_config['show_related_post'] ) ) ? true : false,
					'show_author_bio'			=> (isset( $data_config['show_author_bio']) && catanis_check_option_bool( $data_config['show_author_bio'] ) ) ? true : false
				);

			}
			
			if(isset($catanis_page['page_title_enable']) && $catanis_page['page_title_enable'] == false){
				$catanis_page['header_overlap'] = false;
			}
			
			/*Check VC Enable*/
			$vc_enabled = get_post_meta($post->ID, '_wpb_vc_js_status', true);
			$vc_enabled = catanis_check_option_bool( $vc_enabled );
			
			$post = get_post();
			if ( $post && preg_match( '/vc_row/', $post->post_content ) ) {
				$vc_enabled = true;
			}
			$catanis_page['vc_enabled'] = $vc_enabled;
			
			$catanis_page = array_merge($default_opts, $catanis_page);
			
			/*Filter to move comment field to top*/
			add_filter( 'comment_form_fields', 'catanis_move_comment_field_to_bottom' );
		
		} elseif ( is_singular(CATANIS_POSTTYPE_PORTFOLIO) ) {

			/* Default Options*/
			$default_opts['pageback_portfolio'] 		= catanis_option ( 'portfolio_single_pageback' );
			$default_opts['show_related_portfolio'] 	= catanis_option ( 'portfolio_single_show_related_portfolio' );
			$default_opts['port_type'] 					= 'image';
			$default_opts['port_hover_color'] 			= '#000000';
			$default_opts['port_custom_thumbnail'] 		= '';
			$default_opts['port_thumbnail_type'] 		= 'regular';
			$default_opts['port_exteral_url'] 			= '';
			$default_opts['port_excerpt'] 				= '';
			$default_opts['project_client'] 			= '';
			$default_opts['project_url'] 				= '';
			$default_opts['project_release_date'] 		= '';
			
			$data_config = get_post_meta( $post->ID, Catanis_Meta::$meta_key, true );
			if ( is_array( $data_config ) && ! empty( $data_config ) ) {

				$catanis_page = array(
							
					'layout'					=> (isset( $data_config['layout']) && $data_config['layout'] != 'default') ? $data_config['layout'] : $default_opts['layout'],
					'sidebar'					=> (isset( $data_config['sidebar']) && $data_config['sidebar'] != 'default') ? $data_config['sidebar'] : $default_opts['sidebar'],
					'header_overlap' 			=> (isset( $data_config['header_overlap']) && !catanis_check_option_bool( $data_config['header_overlap'] ) ) ? false : true,
					'header_bg_color'			=> (isset( $data_config['header_bg_color']) && !empty( $data_config['header_bg_color'])) ? $data_config['header_bg_color'] : '',
					'header_style'				=> (isset( $data_config['header_style']) && !empty( $data_config['header_style'])) ? $data_config['header_style'] : $default_opts['header_style'],
					'header_bg'					=> (isset( $data_config['header_bg']) && !empty( $data_config['header_bg'])) ? $data_config['header_bg'] : $default_opts['header_bg'],
					'show_store_notice' 		=> (isset( $data_config['show_store_notice']) && !catanis_check_option_bool( $data_config['show_store_notice'] ) ) ? false : true,
					'menu_color_style'			=> (isset( $data_config['menu_color_style']) && !empty( $data_config['menu_color_style'])) ? $data_config['menu_color_style'] : $default_opts['menu_color_style'],
					'main_navigation_menu'		=> (isset( $data_config['main_navigation_menu']) && !empty( $data_config['main_navigation_menu'])) ? $data_config['main_navigation_menu'] : $default_opts['main_navigation_menu'],
					'custom_logo'				=> (isset( $data_config['custom_logo']) && !empty($data_config['custom_logo']) ) ? $data_config['custom_logo'] : '',
					'sticky_logo'				=> (isset( $data_config['sticky_logo']) && !empty($data_config['sticky_logo']) ) ? $data_config['sticky_logo'] : $default_opts['sticky_logo'],
					'show_header_cart' 			=> (isset( $data_config['show_header_cart']) && !catanis_check_option_bool( $data_config['show_header_cart'] ) ) ? false : true,
					'show_slideout_widget' 		=> (isset( $data_config['show_slideout_widget']) && !catanis_check_option_bool( $data_config['show_slideout_widget'] ) ) ? false : true,
					'show_header_search' 		=> (isset( $data_config['show_header_search']) && !catanis_check_option_bool( $data_config['show_header_search'] ) ) ? false : true,
					'show_header_socials' 		=> (isset( $data_config['show_header_socials']) && !catanis_check_option_bool( $data_config['show_header_socials'] ) ) ? false : true,
					'show_header_phone' 		=> (isset( $data_config['show_header_phone']) && !catanis_check_option_bool( $data_config['show_header_phone'] ) ) ? false : true,
					'show_header_email' 		=> (isset( $data_config['show_header_email']) && !catanis_check_option_bool( $data_config['show_header_email'] ) ) ? false : true,
					'show_header_address' 		=> (isset( $data_config['show_header_address']) && !catanis_check_option_bool( $data_config['show_header_address'] ) ) ? false : true,
					
					'page_title_enable' 		=> (isset( $data_config['page_title_enable']) && !catanis_check_option_bool( $data_config['page_title_enable'] ) ) ? false : true,
					'page_title_style'			=> (isset( $data_config['page_title_style']) && !empty($data_config['page_title_style'])) ? $data_config['page_title_style'] : $default_opts['page_title_style'],
					'show_breadcrumb' 			=> (isset( $data_config['show_breadcrumb']) && catanis_check_option_bool( $data_config['show_breadcrumb'] ) ) ? true : false,
					'page_title_position'		=> (isset( $data_config['page_title_position']) && !empty( $data_config['page_title_position'])) ? $data_config['page_title_position'] : $default_opts['page_title_position'],
					'page_title_bg'				=> (isset( $data_config['page_title_bg']) && !empty( $data_config['page_title_bg'])) ? $data_config['page_title_bg'] : '',
					'page_title_bg_alignment'	=> (isset( $data_config['page_title_bg_alignment']) && !empty( $data_config['page_title_bg_alignment'])) ? $data_config['page_title_bg_alignment'] : $default_opts['page_title_bg_alignment'],
					'page_title_overlay'		=> (isset( $data_config['page_title_overlay']) && catanis_check_option_bool( $data_config['page_title_overlay'] ) ) ? true : false,
					'page_title_overlay_color'	=> (isset( $data_config['page_title_overlay_color']) && !empty( $data_config['page_title_overlay_color'])) ? $data_config['page_title_overlay_color'] : $default_opts['page_title_overlay_color'],
					'page_title_parallax'		=> (isset( $data_config['page_title_parallax']) && catanis_check_option_bool( $data_config['page_title_parallax'] ) ) ? true : false,
					'page_title_title'			=> (isset( $data_config['page_title_title']) && !empty( $data_config['page_title_title'])) ? $data_config['page_title_title'] : '',
					'page_title_subtitle'		=> (isset( $data_config['page_title_subtitle']) && !empty( $data_config['page_title_subtitle'])) ? $data_config['page_title_subtitle'] : '',
					'page_title_bg_color'		=> (isset( $data_config['page_title_bg_color']) && !empty( $data_config['page_title_bg_color'])) ? $data_config['page_title_bg_color'] : $default_opts['page_title_bg_color'],
					'page_title_font_color'		=> (isset( $data_config['page_title_font_color']) && !empty( $data_config['page_title_font_color'])) ? $data_config['page_title_font_color'] : $default_opts['page_title_font_color'],

					'page_feature_type'			=> (isset( $data_config['page_feature_type']) && !empty( $data_config['page_feature_type']) ) ? $data_config['page_feature_type'] : $default_opts['page_feature_type'],
					'page_feature_size'			=> (isset( $data_config['page_feature_size']) && !empty( $data_config['page_feature_size']) ) ? $data_config['page_feature_size'] : $default_opts['page_feature_size'],
					'page_feature_height'		=> (isset( $data_config['page_feature_height']) && !empty( $data_config['page_feature_height']) ) ? $data_config['page_feature_height'] : $default_opts['page_feature_height'],
					'page_feature_minheight'	=> (isset( $data_config['page_feature_minheight']) && !empty( $data_config['page_feature_minheight']) ) ? $data_config['page_feature_minheight'] : $default_opts['page_feature_minheight'],
					'page_feature_revslider' 	=> (isset( $data_config['page_feature_revslider']) && !empty( $data_config['page_feature_revslider']) ) ? $data_config['page_feature_revslider'] : $default_opts['page_feature_revslider'],
					'page_feature_slider_items' => (isset( $data_config['page_feature_slider_items']) && !empty( $data_config['page_feature_slider_items']) ) ? $data_config['page_feature_slider_items'] : $default_opts['page_feature_slider_items'],
					'page_feature_map_pin' 		=> (isset( $data_config['page_feature_map_pin']) && !empty( $data_config['page_feature_map_pin']) ) ? $data_config['page_feature_map_pin'] : $default_opts['page_feature_map_pin'],
					'page_feature_map_style' 	=> (isset( $data_config['page_feature_map_style']) && !empty( $data_config['page_feature_map_style']) ) ? $data_config['page_feature_map_style'] : $default_opts['page_feature_map_style'],
					'page_feature_map_zoom' 	=> (isset( $data_config['page_feature_map_zoom']) && !empty( $data_config['page_feature_map_zoom']) ) ? $data_config['page_feature_map_zoom'] : $default_opts['page_feature_map_zoom'],
					'page_feature_map_address1' => (isset( $data_config['page_feature_map_address1']) && !empty( $data_config['page_feature_map_address1']) ) ? $data_config['page_feature_map_address1'] : $default_opts['page_feature_map_address1'],
					'page_feature_map_address2' => (isset( $data_config['page_feature_map_address2']) && !empty( $data_config['page_feature_map_address2']) ) ? $data_config['page_feature_map_address2'] : $default_opts['page_feature_map_address2'],
					'page_feature_map_address3' => (isset( $data_config['page_feature_map_address3']) && !empty( $data_config['page_feature_map_address3']) ) ? $data_config['page_feature_map_address3'] : $default_opts['page_feature_map_address3'],
					'page_feature_map_address4' => (isset( $data_config['page_feature_map_address4']) && !empty( $data_config['page_feature_map_address4']) ) ? $data_config['page_feature_map_address4'] : $default_opts['page_feature_map_address4'],
					'page_feature_map_address5' => (isset( $data_config['page_feature_map_address5']) && !empty( $data_config['page_feature_map_address5']) ) ? $data_config['page_feature_map_address5'] : $default_opts['page_feature_map_address5'],
					'page_feature_video_type' 	=> (isset( $data_config['page_feature_video_type']) && !empty( $data_config['page_feature_video_type']) ) ? $data_config['page_feature_video_type'] : $default_opts['page_feature_video_type'],
					'page_feature_video_url_youtube' 	=> (isset( $data_config['page_feature_video_url_youtube']) && !empty( $data_config['page_feature_video_url_youtube']) ) ? $data_config['page_feature_video_url_youtube'] : $default_opts['page_feature_video_url_youtube'],
					'page_feature_video_url_vimeo' 		=> (isset( $data_config['page_feature_video_url_vimeo']) && !empty( $data_config['page_feature_video_url_vimeo']) ) ? $data_config['page_feature_video_url_vimeo'] : $default_opts['page_feature_video_url_vimeo'],
					'page_feature_video_url_mp4' 		=> (isset( $data_config['page_feature_video_url_mp4']) && !empty( $data_config['page_feature_video_url_mp4']) ) ? $data_config['page_feature_video_url_mp4'] : $default_opts['page_feature_video_url_mp4'],
					'page_feature_video_url_ogg' 		=> (isset( $data_config['page_feature_video_url_ogg']) && !empty( $data_config['page_feature_video_url_ogg']) ) ? $data_config['page_feature_video_url_ogg'] : $default_opts['page_feature_video_url_ogg'],
					'page_feature_video_url_webm' 		=> (isset( $data_config['page_feature_video_url_webm']) && !empty( $data_config['page_feature_video_url_webm']) ) ? $data_config['page_feature_video_url_webm'] : $default_opts['page_feature_video_url_webm'],
						
					'disable_footer'				=> (isset( $data_config['disable_footer']) && catanis_check_option_bool( $data_config['disable_footer'] ) ) ? true : false,
					'footer_style'					=> (isset( $data_config['footer_style']) && !empty( $data_config['footer_style'])) ? $data_config['footer_style'] : $default_opts['footer_style'],
					'footer_logo'					=> (isset( $data_config['footer_logo']) && !empty( $data_config['footer_logo'])) ? $data_config['footer_logo'] : $default_opts['footer_logo'],
					'footer_background'				=> (isset( $data_config['footer_background']) && !empty( $data_config['footer_background'])) ? $data_config['footer_background'] : '',
					'footer_top_color_scheme'		=> (isset( $data_config['footer_top_color_scheme']) && !empty( $data_config['footer_top_color_scheme'])) ? $data_config['footer_top_color_scheme'] : $default_opts['footer_top_color_scheme'],
					'footer_bottom_color_scheme' 	=> (isset( $data_config['footer_bottom_color_scheme']) && !empty( $data_config['footer_bottom_color_scheme'])) ? $data_config['footer_bottom_color_scheme'] : $default_opts['footer_bottom_color_scheme'],
			
					'comment_enable'			=> (isset( $data_config['comment_enable']) && catanis_check_option_bool( $data_config['comment_enable'] ) ) ? true : false,
					'pageback_portfolio' 		=> (isset( $data_config['pageback_portfolio']) && !empty( $data_config['pageback_portfolio'])) ? $data_config['pageback_portfolio'] : catanis_option( 'portfolio_single_pageback' ),
					'show_related_portfolio'	=> (isset( $data_config['show_related_portfolio']) && catanis_check_option_bool( $data_config['show_related_portfolio'] ) ) ? true : false,
					'port_type'					=> isset( $data_config['port_type'] ) ? $data_config['port_type'] : 'image' ,
					'port_hover_color'			=> isset( $data_config['port_hover_color'] ) ? $data_config['port_hover_color'] : '#000000',
					'port_custom_thumbnail'		=> isset( $data_config['port_custom_thumbnail'] ) ? $data_config['port_custom_thumbnail'] : '',
					'port_thumbnail_type'		=> isset( $data_config['port_thumbnail_type'] ) ? $data_config['port_thumbnail_type'] : 'regular',
					'port_exteral_url'			=> isset( $data_config['port_exteral_url'] ) ? $data_config['port_exteral_url'] : '',
					'port_excerpt'				=> isset( $data_config['port_excerpt'] ) ? $data_config['port_excerpt'] : '',
					'project_client'			=> isset( $data_config['project_client'] ) ? $data_config['project_client'] : '',
					'project_url'				=> isset( $data_config['project_url'] ) ? $data_config['project_url'] : '',
					'project_release_date'		=> isset( $data_config['project_release_date'] ) ? $data_config['project_release_date'] : ''
				);
			}
			
			$catanis_page = array_merge($default_opts, $catanis_page);
			
		} else{
			$default_opts['page_title_style'] 		= 'style1';
			$default_opts['show_breadcrumb'] 		= true;
			$default_opts['page_feature_size'] 		= 'custom-size';
			$default_opts['page_feature_height'] 	= '20';
			$default_opts['page_feature_minheight'] = '230';
			$default_opts['header_overlap'] 	= true;
			$default_opts['menu_color_style'] 	= 'light';
			
			if ( is_search() || is_archive() || is_404()) {
				$default_opts['layout'] = catanis_option('other_pages_layout');
				$default_opts['sidebar'] = catanis_option('other_pages_sidebar');
			}
			
			if( is_archive() && in_array($default_opts['header_style'], array('v4', 'v5'))  ){
				$default_opts['header_overlap'] 	= false;
				$default_opts['menu_color_style'] 	= 'dark';
			}
			
			if ( is_404() ) {
				$default_opts['page_title_enable'] = false;
				$default_opts['menu_color_style'] 	= 'dark';
			}
			
			$catanis_page = $default_opts;
		}
		
		/*Disable This Option*/
		$catanis_page['show_slideout_widget'] = false;
		
		$catanis->pageconfig = $catanis_page;
		
	}
}

function catanis_remove_hooks_from_shop_loop(){
	$num = 0;
	if( !catanis_option('procate_enable_label') ){
		remove_action('woocommerce_after_shop_loop_item_title', 'catanis_template_loop_product_label', 1);
	}
	
	if( !catanis_option('procate_enable_categories') ){
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_categories', 10);
	}
	
	if( !catanis_option('procate_enable_title') ){
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_title', 20);
	}
	
	if( !catanis_option('procate_enable_sku') ){
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_sku', 30);
	}	
	
	if( !catanis_option('procate_enable_rating') ){
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 90);
	}
	
	if( !catanis_option('procate_enable_price') ){
		$num += 1;
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 50);
	}
	
	if( !catanis_option('procate_enable_addtocart') ){
		$num += 1;
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_add_to_cart', 60);
	}
	
	$grid_mode = catanis_option( 'procate_desc_grid_mode' );
	$list_mode = catanis_option( 'procate_desc_list_mode' );
	if ( !$grid_mode['status']){
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_excerpt_grid', 80);
	}
	if ( !$list_mode['status']){
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_excerpt_list', 85);
	}
	if ( !$grid_mode['status'] && !$list_mode['status']){
	}
	
	if($num == 2){
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_before_cartprice', 40);
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_after_cartprice', 70);
	}
}

/*==============================================================================
 * HEADER FUNCTIONS
 *==============================================================================*/
if ( ! function_exists( 'catanis_get_header_style' ) ) {

	/**
	 * Display the header style by setting option
	 *
	 * @param array $option the options for header style
	 */
	function catanis_get_header_style( $option = null ) {
		
		global $catanis;
		$catanis_page = $catanis->pageconfig;

		$header_style = catanis_option( 'header_style' );
		$_style = !empty($header_style) ? $header_style : 'v1';
		$custom_style = (isset($catanis_page['header_style']) && !empty($catanis_page['header_style'])) ? $catanis_page['header_style'] : $_style;
		
		echo get_template_part( 'includes/header/header', $custom_style );
		
	}
}

if ( ! function_exists( 'catanis_theme_favicon' ) ) {
	/**
	 * Display favicon for site
	 */
	function catanis_theme_favicon() {
		if ( ! (function_exists( 'wp_site_icon' ) && wp_site_icon()) ) :
			if( catanis_option('favicon') ) : $favicon = trim(catanis_option('favicon')); ?>
				<link rel="shortcut icon" type="image/x-icon" href="<?php echo esc_url($favicon); ?>" />
				<?php 
			endif;
		endif;
	}
}

if ( ! function_exists( 'catanis_html_socials_theme_option' ) ) {
	/**
	 * Display html header socials
	 * 
	 * @param array $option the options for socials style, ex: header, footer...
	 */
	function catanis_html_socials_theme_option( $options = array() ) {
		
		$socials = catanis_option( 'socials' );
		if ( count( $socials ) > 0 ) {
			$social_networks = array();
			foreach ( $socials as $item ) {
				$social_networks[] = array(
						'item_name' => $item['icon_url'],
						'item_url' 	=> 'url:'. rawurlencode($item['icon_link']) . '||target:_blank|title:'. $item['icon_title']
				);
			}
		}
		
		if(!empty($social_networks) && function_exists('catanis_socials_shortcode_function')){

			/*Some options are depend on main_style, see more in this shortcode*/
			$atts = array(
				'main_style' 		=> 'style1',			/* style1 -> style9 */
				'social_networks' 	=> rawurlencode(json_encode($social_networks)),
				'show_tooltip' 		=> 'no',				/* yes, no*/
				'size'				=> 'sm',				/* sm, nm, lg */
				'align'				=> 'left',				/* align-left, align-center, align-right */
				'w_radius'			=> '',					/*1*/
				'custom_color'		=> '',					/*1*/
				'background_color'	=> '#2e2e2e',
				'icon_color'		=> '#FFFFFF',
				'ext_class' 		=> ''
			);
			
			$options = array_merge($atts, $options);
			echo catanis_socials_shortcode_function( $options);		
		}
		
	}
}

if ( ! function_exists( 'catanis_html_header_logo' ) ) {
	/**
	 * Display html header logo
	 * 
	 * @param string $extCls extend class for logo (optional)
	 * @param array $options option array (optional)
	 * @return html the html of logo
	 */	
	function catanis_html_header_logo( $extCls = '', $options = null ) {
	
		global $catanis;
		$catanis_page = $catanis->pageconfig;
		
		$xhtml = '';
		$sitename = get_bloginfo( 'name', 'display' );
		$logo_class = !empty( $extCls ) ? 'header-logo '. $extCls : 'header-logo';
		$logo_image	= catanis_option( 'dark_logo' );
		if (isset( $catanis_page['menu_color_style']) && $catanis_page['menu_color_style'] == 'light') {
			$logo_image	= catanis_option( 'light_logo' );
		}
		if (isset( $catanis_page['custom_logo']) && !empty($catanis_page['custom_logo'])) {
			$logo_image	= trim($catanis_page['custom_logo']);
		}
		$sticky_logo = trim($catanis_page['sticky_logo']);

		$xhtml .= '<h2 class="' . esc_attr($logo_class) . '">';
		$xhtml .= '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr__( 'Home', 'onelove' ) . '" class="main-logo">';
		$xhtml .= ( !empty($logo_image) ) ? '<img src="' . esc_url($logo_image) . '" alt="' . esc_attr($sitename) . '"/>' : esc_attr($sitename);
		$xhtml .= '</a>';
		
		$xhtml .= '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr__( 'Home', 'onelove' ) . '" class="sticky-logo">';
		$xhtml .= ( !empty($sticky_logo) ) ? '<img src="' . esc_url($sticky_logo) . '" alt="' . esc_attr($sitename) . '"/>' : esc_attr($sitename);
		$xhtml .= '</a>';
		$xhtml .= '</h2>';
				
		echo wp_kses_post($xhtml);
	}
}


if ( ! function_exists( 'catanis_html_page_title' ) ) {
	/**
	 * Display html page title
	 *
	 * @param array $options option array (optional)
	 *
	 * @return html the html of page title
	 */
	function catanis_html_page_title( $options = null ) {
		global $catanis, $post;
		$catanis_page = $catanis->pageconfig;
		
		$xhtml = $custom_css = '';
		$elemClass = '';
		if($catanis_page['page_title_enable'] == false){
			return '';
		}

		$page_feature_type = 'image';
		if( isset( $catanis_page['page_feature_type'] ) && !empty($catanis_page['page_feature_type'])){
			$page_feature_type = $catanis_page['page_feature_type'];
		}
		
		$page_title_bg = ''; 
		if ( isset( $catanis_page['page_title_bg'] ) && ! empty( $catanis_page['page_title_bg'] ) ) {
			$page_title_bg = trim($catanis_page['page_title_bg']);
			$page_title_bg = esc_url($page_title_bg);
		}
		
		if( isset( $catanis_page['page_title_bg_color'] ) && !empty($catanis_page['page_title_bg_color'])) {
			$custom_css .= ".cata-page-title, .page-header-wrap {background-color: {$catanis_page['page_title_bg_color']};}";
		}
		
		if( isset( $catanis_page['page_feature_size'] ) && $catanis_page['page_feature_size'] == 'custom-size' ) {
			$custom_css .= ".cata-page-title, .cata-page-title .page-header-wrap {min-height: {$catanis_page['page_feature_minheight']}px; }";
		}
		
		if( isset( $catanis_page['page_title_font_color'] ) && !empty($catanis_page['page_title_font_color'])) {
			$custom_css .= ".cata-page-title .page-header-wrap .pagetitle-contents .title-subtitle *,
				.cata-page-title .page-header-wrap .pagetitle-contents .cata-breadcrumbs,
				.cata-page-title .page-header-wrap .pagetitle-contents .cata-breadcrumbs *, 
				.cata-page-title .cata-autofade-text .fading-texts-container {
					color:{$catanis_page['page_title_font_color']} !important;  }";
		}
		
		if( $page_feature_type == 'image' && !empty($page_title_bg)){
			$custom_css .= ".cata-page-title .page-header-wrap {
				background-image: url({$page_title_bg}); }";
		}
		
		if( isset( $catanis_page['page_title_overlay']) && $catanis_page['page_title_overlay']) {

			if($page_feature_type == 'image'){
				$elemClass .= ' cata-use-overlay';
				$custom_css .= ".cata-page-title.cata-page-title-image.cata-use-overlay .page-header-wrap:before {
					background: {$catanis_page['page_title_overlay_color']}; }";
				
			}elseif($page_feature_type == 'video'){
				$elemClass .= ' cata-use-overlay';
				$custom_css .= ".cata-page-title .pagetitle-contents-inner .cata-video-pattern:before {
					background: {$catanis_page['page_title_overlay_color']}; }";
			}
		}

		$catanis->inlinestyle[] = $custom_css;
		
		$extend_attr = ( isset( $catanis_page['page_feature_type'] ) && !empty( $catanis_page['page_feature_type']) ) ? ' data-bg-type="' . $catanis_page['page_feature_type'] . '"' : ''; 
		$extend_attr .= ( isset( $catanis_page['page_title_parallax'] ) && catanis_check_option_bool( $catanis_page['page_title_parallax'] ) && $page_feature_type == 'image') ? ' data-parallax="1"' : ''; 
		$extend_attr .= ' data-height="' . absint($catanis_page['page_feature_height']) . '"'; 
		$extend_attr .= isset( $catanis_page['page_title_bg_alignment'] ) ? ' data-bg-position="' . $catanis_page['page_title_bg_alignment'] . '"' : ''; 

		$elemClass .= ' cata-page-title cata-'. $catanis_page['page_title_style']. ' header-'. $catanis_page['header_style'] . ' cata-page-title-' . $page_feature_type;
		$elemClass .= ( isset( $catanis_page['page_feature_size'])) ? ' cata-' .$catanis_page['page_feature_size'] : '';
		$elemClass .= ( isset( $catanis_page['page_title_enable']) && !catanis_check_option_bool( $catanis_page['page_title_enable'] ) ) ? ' hide' : '';
		$elemID = isset($post->post_type) ? $post->post_type : 'vendor' ;
		?>
		<div id="cata-<?php echo esc_attr($elemID); ?>-title" class="<?php echo esc_attr($elemClass); ?>">
			<div class="page-header-wrap"<?php echo ($extend_attr); ?>>
				<div class="container pagetitle-contents">
					<div class="pagetitle-contents-inner">
						<?php 
							if( $page_feature_type == 'revslider' && class_exists('RevSliderFront') ){

								global $wpdb;
								$table_name = $wpdb->prefix . RevSliderGlobals::TABLE_SLIDERS_NAME;
								$slider_id = absint($catanis_page['page_feature_revslider']);
									
								$prepared_statement = $wpdb->prepare( "SELECT id FROM {$table_name} WHERE id = %d", $slider_id );
								$values = $wpdb->get_col( $prepared_statement );

								if( count($values) > 0 ){
									echo '<div style="text-align:initial;">';
									RevSliderOutput::putSlider( $catanis_page['page_feature_revslider']);
									echo '</div>';
								}else{
									catanis_get_pagetitle_and_breadcrumbs( array('norevslider' => true) );
								}
								
							}elseif( $page_feature_type == 'map'){

								echo catanis_google_maps_shortcode_function( array(
									'address1' 			=> $catanis_page['page_feature_map_address1'],
									'address2' 			=> $catanis_page['page_feature_map_address2'],
									'address3' 			=> $catanis_page['page_feature_map_address3'],
									'address4' 			=> $catanis_page['page_feature_map_address4'],
									'address5' 			=> $catanis_page['page_feature_map_address5'],
									'pin' 				=> $catanis_page['page_feature_map_pin'],
									'main_style' 		=> $catanis_page['page_feature_map_style'],
									'width' 			=> '100%',
									'height' 			=> '100%',
									'zoom' 				=> $catanis_page['page_feature_map_zoom'],
									'scrollwheel' 		=> 'no',
									'scale' 			=> 'yes',
									'zoom_pancontrol' 	=> 'yes',
									'ext_class' 		=> ''
								));

							}elseif( $page_feature_type == 'video'){
								
								$xhtml = '<div class="cata-pattern"></div>';
								$video_type = $catanis_page['page_feature_video_type'];
								if(catanis_check_cataniscore_exists()){
								
									$video_sc = '[cata_video video_style="normal" video_host="'. $video_type .'" image_overlay="" video_opts="autoplay,loop,muted"';
									$video_sc .= ' video_url_youtube="'. $catanis_page['page_feature_video_url_youtube'] .'" video_url_vimeo="'. $catanis_page['page_feature_video_url_vimeo'] .'"';
									$video_sc .= ' video_url_mp4="'. $catanis_page['page_feature_video_url_mp4'] .'" video_url_ogg="'. $catanis_page['page_feature_video_url_ogg'] .'" video_url_webm="'. $catanis_page['page_feature_video_url_webm'] .'"]';
									$xhtml .= do_shortcode($video_sc);
									
								}else{
									if(in_array($video_type, array('youtube', 'vimeo'))){
										$video_url = ($video_type == 'youtube') ? $catanis_page['page_feature_video_url_youtube'] : $catanis_page['page_feature_video_url_vimeo'];
										$xhtml .= catanis_get_video_html( $video_url, '100%', array('autoplay' => 1));
									}
								}
								
								echo ($xhtml);

							}elseif( $page_feature_type == 'slider'){

								$img_size['width'] 	= 1920;
								$img_size['height']	= 1080;
								$img_size['crop'] = true;
								$images = catanis_get_slick_slider_images( $catanis_page['page_feature_slider_items'], $img_size, false );
								if ( !empty($images) && count($images) > 1) {
									echo catanis_get_slick_slider_html($images, 'post-'.rand(), $img_size['height'], 'slick-calc-height');
								} 

							}else{
								catanis_get_pagetitle_and_breadcrumbs();
							}
						?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}


function catanis_get_pagetitle_and_breadcrumbs( $options = null ) {
	global $catanis, $post;
	$catanis_page = $catanis->pageconfig;
	$default_title = (is_single() && $post->post_type == 'post') ? '' : catanis_get_page_title();
	$default_title = is_singular( 'product' ) ? esc_html__('Shop', 'onelove') : $default_title;
	$header_title = (isset($catanis_page['page_title_title']) && !empty($catanis_page['page_title_title'])) ? $catanis_page['page_title_title'] : $default_title ;
	
	$header_subtitle = '';
	$arrText = array();
	if(isset($catanis_page['page_title_subtitle']) && !empty($catanis_page['page_title_subtitle'])){

		$arrText = explode('|', $catanis_page['page_title_subtitle']);
		$text1 = isset($arrText[0]) ? $arrText[0] : '' ;
		$text2 = isset($arrText[1]) ? $arrText[1] : '' ;
		$text3 = isset($arrText[2]) ? $arrText[2] : '' ;
		$text4 = isset($arrText[3]) ? $arrText[3] : '' ;
		$text5 = isset($arrText[4]) ? $arrText[4] : '' ;
		
		if (count($arrText) > 1){
			$shortcode = '[cata_autofade_text text1="'. $text1 .'" text2="'. $text2 .'"';
			$shortcode .= ' text3="'. $text3 .'" text4 ="'. $text4 .'" text5 ="'. $text5 .'"';
			$shortcode .= ' display_inline="no" font_container="" color_fadein="#FFFFFF"]';
			$header_subtitle = $shortcode;
			
		}else{
			$header_subtitle = $arrText[0];
		}
	}
	
	if($options != null && $options['norevslider']){
		$header_title = sprintf( __( 'Slider with ID(%d) not found', 'onelove' ) , $catanis_page['page_feature_revslider'] );
		$header_subtitle = esc_html__('Please go to CATANIS PAGE SETTING and change setting Page Title again!', 'onelove');
	}

	if(in_array($catanis_page['page_title_style'], array('style1','style2'))){
	?>
		<div class="title-subtitle">
			<h1 class="heading-title page-title"><?php echo esc_html($header_title); ?></h1>
			<?php 
			if (!empty($header_subtitle)){
				if (count($arrText) > 1){
					echo do_shortcode($header_subtitle);
				}else{
					echo '<span>'. $header_subtitle .'</span>';
				}
			}
			?>
		</div>
	<?php 
	}
	
	if($catanis_page['show_breadcrumb'] == 'true'){
		if( catanis_is_woocommerce_active() ){
			if( function_exists('woocommerce_breadcrumb') && function_exists('is_woocommerce') && is_woocommerce() ){
				woocommerce_breadcrumb(
					array(
						'wrap_before'=>'<div id="cata-breadcrumbs" class="cata-breadcrumbs woocommerce-breadcrumb">',
						'delimiter'=>'<span>&#47;</span>',
						'wrap_after'=>'</div>'
					)
				);
				return; 
			}
		}
		
		catanis_print_breadcrumbs();
	}
}

if ( ! function_exists( 'catanis_get_page_title' ) ) {
	/**
	 * Retrieves page title
	 *
	 * @param array $options option array (optional)
	 * @return string page title
	 */
	function catanis_get_page_title( $options = null ) {
		$title = get_the_title();

		if ( is_front_page() ) {
			$title = '';
		}
		elseif ( is_home() ) {
			$title = esc_html__( 'Blog', 'onelove' ) ;
			
		} elseif ( is_category() ) {
			$title = single_cat_title( '', false );

		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
				
		}elseif ( is_search() ) {
			$title = esc_html__( 'Search', 'onelove' ) ;
				
		}elseif ( is_day() ) {
			$title = get_the_date();
				
		} elseif ( is_month() ) {
			$title = get_the_date( 'F Y' );
				
		} elseif ( is_year() ) {
			$title = get_the_date( 'Y' );
				
		} elseif ( is_page() || is_attachment()) {
		} elseif ( is_author() ) {
			$title = get_the_author();
				
		} elseif ( is_404() ) {
			$title = esc_html__( 'Nothing Found', 'onelove' ) ;
				
		} elseif ( is_tax( 'portfolio_category' ) ) {
			$title = single_cat_title( '', false );

		} elseif ( is_archive() ){
			$title = esc_html__( 'Archive a', 'onelove' );

			if ( catanis_is_woocommerce_active() && ( is_product_category() || is_product_tag() ) ){
				$title = woocommerce_page_title(false);
			}
			if (function_exists('is_shop') && is_shop() ) {
				$title = esc_html__( 'Shop', 'onelove' );
			}
		}

		return $title;
	}
}

if ( ! function_exists( 'catanis_html_header_minicart' ) ) {
	/**
	 * Display html header mini cart
	 *
	 * @param array $options option array (optional)
	 * @return html
	 */
	function catanis_html_header_minicart( $options = null ) {
		
		$xhtml = '';
		
		if(!catanis_is_woocommerce_active()){
			return;
		}
		
		if ( $options == null ) {
			$xhtml 	.= '<div id="cata_mini_cart" class="cata-mini-cart dropdown cata-dropdown">';
			$xhtml 	.= '	<div class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">';
			$xhtml 	.= '		<div class="cat-woo-cart-btn"><span class="iconn ti-bag"></span>';
			$xhtml 	.= '			<p><span class="cart-items">0</span></p>';
			$xhtml 	.= '		</div>';
			$xhtml 	.= '	</div>';
			$xhtml 	.= '	<div class="dropdown-menu woocommerce">';
			$xhtml 	.= '		<div class="widget_shopping_cart_content"></div>';
			$xhtml 	.= '	</div>';
			$xhtml 	.= '</div>';
		}
		
		echo wp_kses_post($xhtml);
	}
}

if ( ! function_exists( 'catanis_html_header_main_menu' ) ) {
	/**
	 * Display html header main menu
	 *
	 * @return html main menu
	 */
	function catanis_html_header_main_menu() {

		global $catanis;
		$catanis_page = $catanis->pageconfig;
		
		if ( has_nav_menu( 'catanis_main_menu' ) ) {
			if ( !isset($catanis_page['main_navigation_menu']) || empty( $catanis_page['main_navigation_menu'] ) ) {
				return wp_nav_menu(
					array(
						'menu_class' => 'main-menu cata-main-menu', 	/* menu class */
						'theme_location' => 'catanis_main_menu', 		/* where in the theme it's assigned */
						'container' => false,
						'link_before' => '<span class="cata-item">',
						'link_after' => '</span>',
						'walker' => new Catanis_Menu_Walker(),
					)
				);
			} else {
				/*Custom Alternative Menu*/
				return wp_nav_menu(
					array(
						'menu_class' => 'main-menu cata-main-menu', 		/* menu class */
						'menu' => $catanis_page['main_navigation_menu'], 	/* menu name */
						'container' => false,
						'link_before' => '<span class="cata-item">',
						'link_after' => '</span>',
						'walker' => new Catanis_Menu_Walker(),
					)
				);
			}
		}else{
			echo '<ul class="main-menu"><li><a href="#">' . esc_html__('No menu assigned!', 'onelove') . '</a></li></ul>';
		}
	}
}

if ( ! function_exists( 'catanis_html_header_login_link' ) ) {
	
	/**
	 * Display html header login/registry link  
	 * 
	 * @return html the html of header login 
	 */
	function catanis_html_header_login_link(){
		
		$xhtml = '';
		if ( catanis_option( 'show_login_register' ) ) : 
			if ( catanis_is_woocommerce_active() ) {
				$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
				if ( $myaccount_page_id ) {
					$login_url 		= esc_url( get_permalink( $myaccount_page_id ) );
					$register_url 	= $login_url;
					$profile_url 	= $login_url;
				}
			}
			else{
				$login_url 		= esc_url( wp_login_url() );
				$register_url 	= esc_url( wp_registration_url() );
				$profile_url 	= esc_url( admin_url( 'profile.php' ) );
			}
			
			$login_text = ( is_user_logged_in() ) ? esc_html__( 'My Account', 'onelove' ) : esc_html__( 'Login / Register', 'onelove' );
			$login_url 	= ( is_user_logged_in() ) ? $profile_url : $login_url;
			
			$xhtml .= '<p class="header-login"><a href="' . esc_url($login_url) . '">' . $login_text . '</a></p>';
		endif;

		echo wp_kses_post($xhtml);
	}
}


if ( ! function_exists( 'catanis_get_pageloader' ) ) {
	/**
	 * Retrieves page loader style and display
	 */
	function catanis_get_pageloader(){
		
		$xhtml = '';
		$custom_img_loader = catanis_option('custom_img_loader');
		if( !empty( $custom_img_loader ) ){
			$xhtml .= '<div class="catanis-loader-wraper cata-custom-loader">';
				$xhtml .= '<img src="'. esc_url($custom_img_loader) .'" alt="" />';
		}else{
			$page_loader = catanis_option('page_loader_style');
	
			$xhtml .= '<div class="catanis-loader-wraper cata-'. $page_loader .'">';
			switch ($page_loader){
				case 'style1': 
					$xhtml .= '
						<div class="loader-heart heart1"><span class="fa fa-heart"></span></div>
					  	<div class="loader-heart heart2"><span class="fa fa-heart"></span></div>
					  	<div class="loader-heart heart3"><span class="fa fa-heart"></span></div>';
					break;
					
				case 'style2': 
					$xhtml .= '
		                    <div class="heart"></div>
		                    <div class="heart heart2"></div>
		                    <div class="heart heart3 pinkHeart"></div>
		                    <div class="heart heart4 fushiaHeart"></div>
		                    <div class="heart hear5 pinkHeart"></div>';
					break;
					
				case 'style3':
					$xhtml .= '
	                    <div class="heart"><i class="fa fa-heart"></i></div>
						<div class="heart-reverse"><i class="fa fa-heart"></i></div>';
					break;
					
				case 'style4':
					$xhtml .= '<div class="heart" style="background:url('. CATANIS_FRONT_IMAGES_URL .'preloader-heart-style4.gif);"></div>';
					break;
					
				case 'style5':
					$xhtml .= '<div class="bounce"></div>';
					break;
			}	
		}
		$xhtml .= '</div>';

		return $xhtml;
		
	}
}


/*==============================================================================
 * FOOTER FUNCTIONS
 *==============================================================================*/
if ( ! function_exists( 'catanis_get_footer_style' ) ) {
	/**
	 * Display the footer style by setting option
	 *
	 * @param array $option the options for footer style
	 * @return html the html of footer
	 */
	function catanis_get_footer_style( $option = null ) {
		global $catanis;
		$catanis_page = $catanis->pageconfig;

		$_style = (isset($catanis_page['footer_style']) && !empty($catanis_page['footer_style']) ) ? $catanis_page['footer_style'] : catanis_option( 'footer_style' );
		if ( !$catanis_page['disable_footer'] && !is_page_template('template-coming-soon.php') ){
			echo '<footer class="cata-footer '.$_style.'">';
			echo get_template_part( 'includes/footer/footer', $_style );
			echo '</footer>';
		}
	}
}

add_action('catanis_hook_footer', 'catanis_show_page_music', 1);
if ( ! function_exists( 'catanis_show_page_music' ) ) {
	function catanis_show_page_music(){

		global $catanis;
		$catanis_page = $catanis->pageconfig;
		
		$xhtml = ''; 
		if(isset($catanis_page['audio_use']) && !empty($catanis_page['audio_use'])){
			$xhtml 	.= '<div id="cata-page-music">';
			$xhtml 	.= '	<div class="cata-music-toggle-btn cata-toogle"><span class="fa fa-music"></span></div>';
			$xhtml 	.= '	<div class="cata-music-embed cata-music-'.$catanis_page['audio_use'].'">';
			if( $catanis_page['audio_use'] == 'mp3' && isset($catanis_page['audio_mp3']) && !empty($catanis_page['audio_mp3']) ){
				$autoplay = ($catanis_page['audio_autoplay']) ? 1 : 0;
				$xhtml 	.= '<div class="cata-audiomp3 has-thumb"><div class="cata-audio-mp3">' . do_shortcode('[audio preload="auto" autoplay="'.$autoplay.'" src="'. esc_url($catanis_page['audio_mp3']) .'"]') .'</div>';
				$xhtml 	.= '	<figure class="entry-thumbnail"><img src="'. CATANIS_FRONT_IMAGES_URL .'default/page-music-bg.png" alt=""></figure>';
				$xhtml 	.= '</div>';
			}else{
				if(isset($catanis_page['audio_soundcloud']) && !empty($catanis_page['audio_soundcloud'])){

					$content = preg_replace( array('/height="\d+"/i'), array(sprintf('height="%d"', 170)), $catanis_page['audio_soundcloud']);
					$content = ($catanis_page['audio_autoplay']) ? str_replace( 'auto_play=false', 'auto_play=true', $content) : $content;
					$xhtml .= do_shortcode($content);
				}
			}
			
			$xhtml 	.= '	</div>';
			$xhtml 	.= '</div>';
			
			echo trim($xhtml);
		}
			
	}
}
if ( ! function_exists( 'catanis_add_inline_style' ) ) {
	function catanis_add_inline_style() {
		global $catanis;
	
		if( isset($catanis->inlinestyle) && count($catanis->inlinestyle) >0){
			$inlineStyle = implode(' ', $catanis->inlinestyle);
			if(!empty($inlineStyle)){
				echo trim('<div id="cata_inline_style">'. stripslashes($inlineStyle) .'</div>');
			}
		}
	}
}
add_action( 'catanis_hook_footer', 'catanis_add_inline_style', 100 );


/*==============================================================================
 * SIDEBAR FUNCTIONS
 *==============================================================================*/
if ( ! function_exists( 'catanis_shop_sidebar' ) ) {
	/**
	 * Display sidebar for page
	 *
	 * @param string $position position of sidebar
	 * @param array $option array options (optional)
	 * @return html the html of the sidebar
	 */
	function catanis_shop_sidebar( $position = 'left', $option = null ) {
		if ( $position == 'left' ) {
			get_sidebar( 'shop' );
		} else {
			/**
			 * woocommerce_sidebar hook
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
		}
	}
}


/*==============================================================================
 * GALLERY FUNCTIONS
 *==============================================================================*/
if ( ! function_exists( 'catanis_getwidth_for_item' ) ) {
	/**
	 * Display sidebar for page
	 *
	 * @param int $cols number columns
	 * @return int content widh
	 */
	function catanis_getwidth_for_item( $cols ) {
		
		$cols = empty( $cols ) ? 2 : $cols ;
		$content_with = 1170;

		return ( $content_with/$cols );
	}
}

if ( ! function_exists( 'catanis_remove_gallery_from_content' ) ) {

	/**
	 * Strips the first gallery shortcode from the content of the item.
	 * 
	 * @param  string $content the content to strip the shortcode from
	 * @return string the content without the gallery shortcode.
	 */
	function catanis_remove_gallery_from_content( $content ) {
		$pattern = '/\[.?gallery[^\]]*\]/';

		$content = preg_replace( $pattern, '', $content, 1 );
		return $content;
	}
}

if ( ! function_exists( 'catanis_get_carousel_slider_html' ) ) {
	/**
	 * Generates the Carousel slider HTML.
	 * 
	 * @param  array  $images    array containing the slider images
	 * @param  object  $options    slider options
	 * @param  string  $slider_div_id the ID of the slider div
	 * @param  int  $height  the height of the slider
	 * @param  boolean $static_height sets whether to set a static height or the
	 * height will be dynamic depending on the original image ratio
	 * @return string  the HTML code of the slider
	 */
	function catanis_get_carousel_slider_html( $images, $slider_div_id, $height, $static_height = true, $extClass = '' ) {

		$style 	= $static_height ? 'style="max-height:' . absint($height) . 'px;"' : 'style="min-height:' . absint($height) . 'px;"';
		$html 	= '<div class="cata-slider ' . esc_attr($extClass) . '" ' . $style . ' id="' . esc_attr($slider_div_id) . '" data-animation="true" data-autoplay="true" data-nav="true">';
		$html 	.= '<div class="ca_items_list_inner">';
		
		foreach ( $images as $image ) {
			
			$html	.= '<div class="items_per_slide">';
			if ( ! empty( $image['link'] ) ) {
				$html	.= '<a href="'. esc_url( $image['link'] ) .'">';
			}
			
			$html	.= '<img src="' . esc_url($image['url']) .'" title="' . esc_attr($image['description']) . '" alt=""/>';
			if ( ! empty( $image['link'] ) ) {
				$html	.= '</a>';
			}
			$html	.= '</div>';
		}

		$html	.= '</div></div>';

		return $html;
	}
}

if ( ! function_exists( 'catanis_get_owl_carousel_post_images' ) ) {
	/**
	 * Display sidebar for page
	 *
	 * @param object $post POST object
	 * @param array $img_size image size to get
	 * @return array post images
	 */
	function catanis_get_owl_carousel_post_images ( $post, $img_size) {
		$attachments = catanis_get_post_gallery_images( $post );
		$images = array();

		foreach ( $attachments as $attachment ) {
			$img =  wp_get_attachment_image_src( $attachment->ID, 'full' );
			$imgurl = catanis_get_resized_image( $img[0], $img_size['width'], $img_size['height'], $img_size['crop'], true );
			$images[]= array(
				'url' 	=> $imgurl,
				'link' 	=> '',
				'description' => $attachment->catanis_desc
			);
		}

		return $images;
	}
}


if ( ! function_exists( 'catanis_get_slick_slider_images' ) ) {
	function catanis_get_slick_slider_images( $post_meta_gallery_items, $img_size, $resize = true ){
		$attachments 	= explode(',', $post_meta_gallery_items);
		$images = array();

		foreach ( $attachments as $attachment ) {
			$img =  wp_get_attachment_image_src( $attachment, 'full' );
			$imgurl = (!$resize) ? $img[0] : catanis_get_resized_image( $img[0], $img_size['width'], $img_size['height'], $img_size['crop'], true );
			$images[]= array(
				'url' 	=> $imgurl,
				'link' 	=> '',
				'description' => ''
			); 
		}
		
		return $images;		
	}
}
if ( ! function_exists( 'catanis_get_slick_slider_html' ) ) {
	/**
	 * Generates the Slick slider HTML.
	 *
	 * @param  array  $images    array containing the slider images
	 * @param  object  $options    slider options
	 * @param  string  $slider_div_id the ID of the slider div
	 * @param  int  $height  the height of the slider
	 * @param  boolean $static_height sets whether to set a static height or the
	 * height will be dynamic depending on the original image ratio
	 * @return string  the HTML code of the slider
	 */
	function catanis_get_slick_slider_html( $images, $slider_div_id, $height, $extClass = '' ) {

		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		$arrParams = array(
			'autoplay' 			=> true,
			'autoplaySpeed' 	=> 2000,
			'slidesToShow' 		=> 1,
			'slidesToScroll' 	=> 1,
			'dots' 				=> true,
			'arrows' 			=> true,
			'infinite' 			=> true,
			'fade'				=> true,
			'draggable' 		=> false,
			'rtl' 				=> CATANIS_RTL,
			'speed' 			=> 1000
		);

		$xhtml 	= '<div' . rtrim($dir) . ' class="cata-slick-slider dots-line ' . esc_attr($extClass) . '" id="' . esc_attr($slider_div_id) . '">';
		$xhtml 	.= "	<ul class='slides' data-slick='". json_encode($arrParams) ."'>";

		foreach ( $images as $image ) {
				
			$xhtml	.= '<li class="cata-slick-item">';
			if ( ! empty( $image['link'] ) ) {
				$xhtml	.= '<a href="'. esc_url( $image['link'] ) .'">';
			}
				
			$xhtml	.= '<img src="' . esc_url($image['url']) .'" title="' . esc_attr($image['description']) . '" alt=""/>';
			if ( ! empty( $image['link'] ) ) {
				$xhtml	.= '</a>';
			}
			$xhtml	.= '</li>';
		}

		$xhtml	.= '</ul></div>';

		return $xhtml;
	}
}


if ( ! function_exists( 'catanis_get_classic_gallery_portfolio' ) ) {
	
	function catanis_get_classic_gallery_portfolio( $post_meta_gallery_items, $img_size ){

		$xhtml = '';
		$attachments 	= explode(',', $post_meta_gallery_items);

		$xhtml 	.= '<div class="cata-gallery-imgs">';
		foreach ( $attachments as $attachment ) {
			$img =  wp_get_attachment_image_src( $attachment, $img_size );
				
			$xhtml 	.= '	<div class="cata-img"><a data-fresco-group="product-gallery" class="fresco" href="'. esc_url($img[0]) .'">';
			$xhtml 	.= '		<img src="'. esc_url($img[0]) .'" alt=""/>';
			$xhtml 	.= '		<div class="cata-overlay"><span class="icon-circle"><i class="fa fa-search"></i></span></div>';
			$xhtml 	.= '	</a></div>';
		}
		$xhtml .= '</div>';

		return $xhtml;
	}
}
if ( ! function_exists( 'catanis_get_vertical_gallery_portfolio' ) ) {

	function catanis_get_vertical_gallery_portfolio( $post_meta_gallery_items, $img_size ){

		$xhtml = '';
		$attachments 	= explode(',', $post_meta_gallery_items);

		$xhtml 	.= '<div class="cata-vertical-gallery-imgs">';
		foreach ( $attachments as $attachment ) {
			$img =  wp_get_attachment_image_src( $attachment, $img_size );

			$xhtml 	.= '	<div class="cata-img">';
			$xhtml 	.= '		<img src="'. esc_url($img[0]) .'" alt=""/>';
			$xhtml 	.= '		<div class="cata-overlay"></div>';
			$xhtml 	.= '	</div>';
		}
		$xhtml .= '</div>';

		return $xhtml;
	}
}

if ( ! function_exists( 'catanis_get_image_size_options' ) ) {
	/**
	 * Retrieves the image size options depending on the section/content type and the number of columns.
	 * 
	 * @param  integer $columns   the number of columns
	 * @param  string  $content_type the content type - can be blog, gallery, carousel, quick_gallery, services, content_slider
	 * @param  string  $layout   the current page/section layout
	 * @return array  array containing the image size settings, with properties width, height and crop
	 */
	function catanis_get_image_size_options( $content_type ){
		global $catnis;

		$result = array( 'width' => '', 'height' => '', 'crop' => false );
		return array_merge( $result, catanis_option( $content_type ) );
	}
}

if ( ! function_exists( 'catanis_get_post_gallery_images' ) ) {
	/**
	 * Loads the post images into an array. First checks for a gallery inserted
	 * in the content of the post. If there is a gallery, loads the gallery images.
	 * If there isn't a gallery, loads the post attachment images. If there aren't
	 * attachment images, loads the featured image of the post (if it set).
	 *
	 * @param unknown $post the post object	 * 
	 * @return array containing the attachment(image) objects
	 */
	function catanis_get_post_gallery_images( $post ) {
		$pattern = get_shortcode_regex();
		$ids = array();
		$images = array();

		/*check if there is a gallery shortcode included*/
		if ( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
				&& array_key_exists( 2, $matches )
				&& in_array( 'gallery', $matches[2] ) ) {

			$key = array_search( 'gallery', $matches[2] );
			$att_text = $matches[3][ $key ];
			$atts = shortcode_parse_atts( $att_text );
			if ( ! empty( $atts['ids'] ) ) {
				$ids = explode( ',' , $atts['ids'] );
			}
		}

		$args = array(
			'post_type' 		=> 'attachment',
			'post_mime_type' 	=> 'image',
			'numberposts' 		=> -1
		);

		/*Check gallery shortcode included, 
		 if NO gallery include, load the item attachments*/
		if ( !empty( $ids ) ) {
			$args['post__in'] = $ids;
		} else {
			$args['order'] 			= 'ASC';
			$args['orderby'] 		= 'menu_order';
			$args['post_parent'] 	= $post->ID;
		}

		$images = get_posts( $args );

		if ( empty( $images ) && has_post_thumbnail( $post->ID ) ) {
			$att_id = get_post_thumbnail_id( $post->ID );
			$att = get_post( $att_id );
			if ( !empty( $att->post_content ) ) {
				$att->catanis_desc = $att->post_content;
			}
			$images[] = $att;
			return $images;
		}

		if ( ! empty( $ids ) ) {
			/*order images as set in their IDs attribute*/
			if ( sizeof( $images ) == sizeof( $ids ) ) {
				$ordered_images = array_fill( 0, sizeof( $images ), null );

				foreach ( $images as $img ) {
					$index = array_search( $img->ID, $ids );
					$ordered_images[ $index ] = $img;
				}

				$images = $ordered_images;
			} else {
				/*fix WP about not removing the deleted images IDs from the gallery shortcode*/
				$ordered_images = array();

				foreach ( $ids as $id ) {
					foreach ( $images as $img ) {
						if ( $img->ID == $id ) {
							$ordered_images[] = $img;
							break;
						}
					}
				}
			}
		}

		/*set the description of the image*/
		foreach ( $images as &$img ) {
			if ( !empty( $img->post_content ) ) {
				$img->catanis_desc = $img->post_content;
			} elseif ( !empty( $img->post_excerpt ) ) {
				$img->catanis_desc = $img->post_excerpt;
			} else {
				$img->catanis_desc = '';
			}
		}

		return $images;
	}
}

if ( ! function_exists( 'catanis_get_project_images_portfolio' ) ) {
	/**
	 * Retrieves portfolio image in portfolio detail page
	 * 
	 * @return html
	 */
	function catanis_get_project_images_portfolio( $imgs, $type = 'default' ) {
		
		global $post;
		$xhtml = '';
		
		if ( count( $imgs ) > 0 ):
			if ( $type == 'default' ){
				
				$xhtml 	.= '<div class="floating-imgs">';
				foreach ( $imgs as $key => $val ):
				$xhtml 	.= '	<img src="'. esc_url($val->guid) .'" alt="'. esc_attr($val->catanis_desc) .'" />';
				endforeach;
				$xhtml 	.= '</div>';
				
			} elseif ( $type == 'gallery' ){
				
				$orgImg = catanis_get_post_gallery_images( $post );
				$xhtml 	.= '<div class="cata-gallery-imgs">';
				foreach ( $imgs as $key => $val ):
				$xhtml 	.= '	<a data-fresco-group="product-gallery" class="fresco" href="'. $orgImg[$key]->guid .'">';
				$xhtml 	.= '		<img src="'. esc_url($val['url']) .'" alt="'. esc_attr($val['description']) .'"/>';
				$xhtml 	.= '		<div class="cata-overlay"><span class="icon-circle"><i class="fa fa-search"></i></span></div>';
				$xhtml 	.= '	</a>';
				endforeach;
				$xhtml .= '</div>';
			}
		endif;

		return $xhtml;
	}
}
if ( ! function_exists( 'catanis_get_project_detail_portfolio' ) ) {
	/**
	 * Display portfolio (project) information in detail page
	 * 
	 * @return html portfolio infor 
	 */
	function catanis_get_project_detail_portfolio( $post, $post_meta ){
	
		$xhtml 	= '';
		
		$project_client = $post_meta['project_client'];
		if(!empty($project_client)){
			$xhtml 	.= '<div class="project-client project-info">
							<h5>'. esc_html__('Client','onelove') .'</h5>
							<p><a href="'. esc_url( $post_meta['project_url'] ) .'" title="'.get_the_title( $post ).'">'. esc_html($project_client) .'</a></p>
						</div>';
		}
		
		$project_release_date = $post_meta['project_release_date'];
		if(!empty($project_release_date)){
			$xhtml 	.= '<div class="project-date project-info">
							<h5>'. esc_html__('Date','onelove') .'</h5>
							<p> '. date( get_option('date_format'), strtotime( $project_release_date ) ) .'</p>
						</div>';
		}
		
		$tags_list = get_the_term_list( $post->ID, 'portfolio_tags', '', ', ', '' );
		if ( $tags_list ) {
			$xhtml 	.= '<div class="project-categories project-info">
						<h5>'. esc_html__('Tags','onelove') .'</h5>
						<p>'. $tags_list .'</p>
					</div>';
		}
		
		$xhtml 	.= '<div class="project-share project-info">
						<h5>'. esc_html__('Share','onelove') .'</h5>
						'. catanis_get_share_btns_html($post->ID, CATANIS_POSTTYPE_PORTFOLIO, false) .'
					</div>';
		
		echo wp_kses_post($xhtml);
	
	}
}

if ( ! function_exists( 'catanis_get_portfolio_type_in_single' ) ) {
	function catanis_get_portfolio_type_in_single($portfolio_type, $post_meta, $echo = true){
	
		global $post;
		$xhtml = '';
		
		$post_thumb_url		= catanis_get_post_preview_img( $post->ID, true, 'large' );
		$post_thumb_url 	= trim($post_thumb_url['img']);
		if( empty($post_thumb_url) && !empty($post_meta['port_custom_thumbnail']) ){
			if( isset($post_meta['port_custom_thumbnail_id']) ){
				$post_thumb_url 	= wp_get_attachment_image_src( $post_meta['port_custom_thumbnail_id'], 'large' );
				$post_thumb_url 	= $post_thumb_url[0];
			}else{
				$post_thumb_url		= catanis_get_post_preview_img( $post->ID, false, 'large' );
				$post_thumb_url 	= trim($post_thumb_url['img']);
			}
		}

		switch ( $portfolio_type ) {
			case 'slider':
					
				$img_size['width'] 	=  get_option( 'large_size_w' );
				$img_size['height']	= get_option( 'large_size_h' );
				$img_size['crop'] 	= true;
				
				$images = catanis_get_slick_slider_images( $post_meta['slider_items'], $img_size );
				if ( !empty($images) && count($images) > 1) {
					$xhtml .= catanis_get_slick_slider_html($images, 'post-'.rand(), $img_size['height'], '');
				}
		
				break;
				
			case 'gallery':
				$xhtml .= catanis_get_classic_gallery_portfolio($post_meta['gallery_items'], 'large');
				break;
			
			case 'gallery-vertical':
				$xhtml .= catanis_get_vertical_gallery_portfolio($post_meta['gallery_vertical_items'], 'large');
				break;
				
			case 'verticalsticky-sidebar':
				$xhtml .= catanis_get_vertical_gallery_portfolio($post_meta['gallery_verticalsticky_items'], 'large');
				break;
				
			case 'video':
			case 'hosted':
				
				$video_url = $post_meta['video_url'];
				if($portfolio_type == 'hosted'){
					$video_type = 'hosted';
				}else{
					$video_type = catanis_check_video_type($video_url);
				}
				
				if(!catanis_check_cataniscore_exists()){
					$image_overlay = get_post_thumbnail_id( $post->ID );
					$video_style = 'normal';
					if(!empty($video_type)){
						$video_sc = '[cata_video video_style="'. $video_style .'" video_host="'. $video_type .'" image_overlay="'. $image_overlay .'"';
						$video_sc .= ' video_url_youtube="'. $video_url .'" video_url_vimeo="'. $video_url .'"';
						$video_sc .= ' video_url_mp4="'. $post_meta['video_url_mp4'] .'" video_url_ogg="'. $post_meta['video_url_ogg'] .'" video_url_webm="'. $post_meta['video_url_webm'] .'"]';
						$xhtml .= do_shortcode($video_sc);
					} 
					
				}else{
		
					$tmp = catanis_post_thumbnail($post_thumb_url);
					if(!empty($video_type)){
						if($video_type == 'hosted'){
							$video_sc = '[video poster="'. $post_thumb_url .'" mp4="'. $post_meta['video_url_mp4'] .'" ogv="'. $post_meta['video_url_ogg'] .'" webm="'. $post_meta['video_url_webm'] .'"]';
							$tmp = '<div class="cata-video-html5">' . do_shortcode($video_sc) .'</div>';
						}else{
							$tmp = catanis_get_video_html( $video_url, '100%');
						}
					}
					$xhtml .= $tmp;
				}
					
				break;
		
			case 'image':
			default:
		
				$xhtml .= catanis_post_thumbnail($post_thumb_url);
				break;
		}
		
		if($echo == true){
			echo trim($xhtml);
		}else{
			return $xhtml;
		}
	}
}

if ( ! function_exists( 'catanis_get_post_navigation_next_and_previous' ) ) {
	/**
	 * Display post navigation in post detail
	 * 
	 *  @return html post navigation
	 */
	function catanis_get_post_navigation_next_and_previous(){
		global $post;
		$next_post = get_next_post();
		$prev_post = get_previous_post();
		
		if ( is_a( $prev_post, 'WP_Post' ) || is_a( $next_post, 'WP_Post' ) ){ ?>
			<div id="post_single_navigation" class="cata-has-animation cata-fadeInUp">
				<div class="container">
					<div class="cata-post-navigation navi-project"> 
					
						<div class="cata-navi-prev"> 
							<?php  
							if ( is_a( $prev_post, 'WP_Post' ) ) {
								previous_post_link( '%link', '<i class="fa fa-angle-left"></i> <span>'. esc_html__('Prev Post', 'onelove') .'</span>' ); 
							}
							?>
						</div>
						
						<div class="cata-navi-center cata-post-share"> 
							<div class="wrap-social">
								<?php echo catanis_get_share_btns_html($post->ID, 'post', false); ?>
							</div>
						</div>
						
						<div class="cata-navi-next"> 
							<?php  
							if ( is_a( $next_post, 'WP_Post' ) ) {
								next_post_link( '%link', '<span>'. esc_html__('Next Post', 'onelove') .'</span> <i class="fa fa-angle-right"></i>' );
							}
							?>
						</div>
						
					</div>
				</div>
			</div>
		<?php 	
		}
	}
}


/*==============================================================================
 * EXTRA FUNCTIONS
 *==============================================================================*/
add_action('init', 'catanis_force_under_construction_page', 1);
if ( ! function_exists( 'catanis_force_under_construction_page' ) ) {
	function catanis_force_under_construction_page() {

		/*The link what user request*/
		$userrequest = str_ireplace(home_url(),'', catanis_get_address());
		$userrequest = rtrim($userrequest,'/');

		if (catanis_option('enable_under_construction') && !current_user_can('level_10') && catanis_option('under_construction_page') != '' ) {

			$do_redirect = '';
			if( get_option('permalink_structure') ){
				$getpost = get_post(catanis_option('under_construction_page'));
				if ($getpost) {
					$do_redirect = '/'. $getpost->post_name;
				}
			}else{
				$do_redirect = '/?page_id=' . catanis_option('under_construction_page');
			}
			
			/* Check user link if it's admin link */
			if ( strpos($userrequest, '/wp-login.php') !== 0 && strpos($userrequest, '/wp-admin') !== 0 ) {
				$userrequest = str_replace('*', '(.*)', $userrequest);
				$pattern = '/^' . str_replace( '/', '\/', rtrim( $userrequest, '/' ) ) . '/';
				$do_redirect = str_replace('*', '$1', $do_redirect);
				$output = preg_replace($pattern, $do_redirect, $userrequest);
				if ($output !== $userrequest) {
					/*pattern matched, perform redirect*/
					$do_redirect = $output;
				}
			}else{
				$do_redirect = $userrequest;
			}
			
			if ($do_redirect !== '' && trim($do_redirect, '/') !== trim($userrequest, '/') ) {
				if (strpos($do_redirect, '/') === 0){
					$do_redirect = home_url('/') . $do_redirect;
					/*$do_redirect = get_permalink( get_post( catanis_option('under_construction_page') ) );*/
				}

				header ('HTTP/1.1 301 Moved Permanently');
				header ('Location: ' . $do_redirect);
				exit();
			}
		}
		
	} 
}


if ( ! function_exists( 'catanis_admin_bar_under_construction_notice' ) ) {
	/**
	 * Add under construction notice to adminbar for all logged user
	 * 
	 * @return void
	 */
	function catanis_admin_bar_under_construction_notice() {
		global $wp_admin_bar;
			
		if (catanis_option('enable_under_construction')) {
			$wp_admin_bar->add_menu( array(
				'id' => 'admin-bar-under-construction-notice',
				'parent' => 'top-secondary',
				'href' => admin_url("admin.php?page=catanis_options"),
				'title' => '<span style="color: #FF0000;">Under Construction</span>'
			) );
		}
	}
}
add_action( 'admin_bar_menu', 'catanis_admin_bar_under_construction_notice' );

/*==============================================================================
 * ACTION HOOK MOBILE NAVIGATION
 *==============================================================================*/
add_action( 'catanis_hook_nav_mobile', 'catanis_mobile_navigation', 10 );

if ( ! function_exists( 'catanis_mobile_navigation' ) ) {
	/**
	 * Disaply main navigation and logo on mobile
	 * 
	 * @return html
	 */
	function catanis_mobile_navigation() {
		global $catanis;
		$catanis_page = $catanis->pageconfig;
		$logo_image = catanis_option('dark_logo');
		?>
		
		<section id="mobile-nav">
			<div class="section-one mobile-section">
				<h2 class="logo<?php if ( empty($logo_image) ): echo ' text-logo';  endif; ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e('Home', 'onelove'); ?>" class="main-logo">
						<?php if ( !empty($logo_image) ) : ?>
						<img src="<?php echo esc_url($logo_image); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"> 
						<?php else: echo esc_attr( get_bloginfo( 'name', 'display' ) ); endif; ?>
					</a>
				</h2>				
				
				<div class="mobile-nav-icon-toggle">
					<span class="mobi-nav-btn ti-menu"></span>
				</div>
				
				<?php if(catanis_is_woocommerce_active() && isset($catanis_page['show_header_cart']) && $catanis_page['show_header_cart']== 'true' ) : ?>
				<div class="mobile-nav-icon-cart">
					<a href="<?php echo wc_get_cart_url(); ?>" title="Cart page">
						<span class="mobi-cart-btn ti-bag"><span class="cart-items"><?php echo (WC()->cart->get_cart_contents_count()); ?></span></span>
					</a>
				</div>
				<?php endif; ?>
				
			</div> 
		</section>
		
		<?php 
		$xhtml 	= '<div id="cata_mini_cart" class="cata-mini-cart dropdown cata-dropdown">';
		$xhtml 	.= '	<div class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">';
		$xhtml 	.= '		<div class="cat-woo-cart-btn"><span class="iconn ti-bag"></span>';
		$xhtml 	.= '			<p><span class="cart-items">0</span></p>';
		$xhtml 	.= '		</div>';
		$xhtml 	.= '	</div>';
		$xhtml 	.= '	<div class="dropdown-menu woocommerce">';
		$xhtml 	.= '		<div class="widget_shopping_cart_content"></div>';
		$xhtml 	.= '	</div>';
		$xhtml 	.= '</div>';
		
	}
}

/*==============================================================================
 * ACTION HOOK WOOCOMMERCE
 *==============================================================================*/
/*--- Get Ajax Cart Fragment ---*/
add_filter( 'woocommerce_add_to_cart_fragments', 'catanis_woocommerce_header_add_to_cart_fragment' );
if ( ! function_exists( 'catanis_woocommerce_header_add_to_cart_fragment' ) ) {
	function catanis_woocommerce_header_add_to_cart_fragment($fragments) {

		$_cartQty = WC()->cart->get_cart_contents_count();
		$fragments['#cata_mini_cart .dropdown-toggle .cart-items'] = '<span class="cart-items">' . ($_cartQty > 0 ? $_cartQty : '0') . '</span>';
		$fragments['.mobile-nav-icon-cart .cart-items'] = '<span class="cart-items">' . ($_cartQty > 0 ? $_cartQty : '0') . '</span>';
	
		return $fragments;
				
	}
}

add_filter('woocommerce_default_catalog_orderby', 'catanis_custom_default_catalog_orderby');
if ( ! function_exists( 'catanis_custom_default_catalog_orderby' ) ) {
	function catanis_custom_default_catalog_orderby() {
		return 'date'; /* Can also use title and price */
	}
}

/* Twitter Shortcode Function */
function catanis_get_tweets($username, $count) {

	if( !class_exists('TwitterOAuth') ){
		esc_html_e( 'The class TwitterOAuth does not exist.', 'onelove');
		return ;
	}

	$consumer_key = catanis_option('consumer_key');
	$consumer_secret = catanis_option('consumer_secret');
	$access_token = catanis_option('access_token');
	$access_token_secret = catanis_option('access_token_secret');
	if( !empty($consumer_key) && !empty($consumer_secret) && !empty($access_token) && !empty($access_token_secret) ){

		$connection = new TwitterOAuth(
			$consumer_key, $consumer_secret, $access_token, $access_token_secret
		);
		$fetchedTweets 	= $connection->get( 'statuses/user_timeline', array(
			'screen_name' 		=> $username,
			'include_rts'		=> 1,
			'exclude_replies' 	=> true,
			'count'				=> $count
		) );

		$backupName = 'catanis_twitter_list_backup_' . trim( $username );
		
		if ($connection->http_code != 200) {
			$tweets = get_option($backupName);
		} else {
			$limitToDisplay = min($count, count($fetchedTweets));
			for ($i = 0; $i < $limitToDisplay; $i++) {
				$tweet = $fetchedTweets[$i];
					
				$name = $tweet->user->name;
					
				$permalink = 'http://twitter.com/' . $name . '/status/' . $tweet->id_str;
					
				$image = $tweet->user->profile_image_url;
					
				$pattern = '/(http|https):(\S)+/';
					
				$replace = '<a href="${0}" target="_blank" rel="nofollow">${0}</a>';
					
				$text = preg_replace($pattern, $replace, $tweet->text);
					
				$time = $tweet->created_at;
				$time = date_parse($time);
					
				$uTime = mktime($time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year']);
					
				$tweets[] = array(
					'text' => $text,
					'name' => $name,
					'permalink' => $permalink,
					'image' => $image,
					'time' => $uTime
				);
			}
	
			update_option($backupName, $tweets);
		}
		
		return $tweets;
	}else{
		esc_html_e( 'You need setting twitter keys in Theme Options', 'onelove');
	}
}

?>