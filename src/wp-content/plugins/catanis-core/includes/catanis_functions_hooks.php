<?php
/*==============================================================================
 * 1.  FUNCTIONS
 *==============================================================================*/
function catanis_get_instagram( $username ) {

	$username = trim( strtolower( $username ) );
	$username_fist_character = substr( $username, 0, 1 );
	
	switch ( $username_fist_character ) {
		case '#':
			$url = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
			$transient_prefix = 'tag';
			break;
		default:
			$url = 'https://instagram.com/' . str_replace( '@', '', $username );
			$transient_prefix = 'user';
			break;
	}
	
	if ( false === ( $instagram = get_transient( 'catanis-instagram-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ) ) ) ) {
		
		$remote = wp_remote_get( $url );

		if ( is_wp_error( $remote ) ) {
			return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'catanis-core' ) );
		}

		if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
			return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'catanis-core' ) );
		}
		
		$shards = explode( 'window._sharedData = ', $remote['body'] );
		$insta_json = explode( ';</script>', $shards[1] );
		$insta_array = json_decode( $insta_json[0], true );
		
		if ( ! $insta_array ) {
			return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'catanis-core' ) );
		}

		if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
			$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
		} elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
			$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
		} else {
			return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'catanis-core' ) );
		}
		
		if ( ! is_array( $images ) ) {
			return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'catanis-core' ) );
		}
		
		$instagram = array();

		foreach ( $images as $image ) {

			if ( true === $image['node']['is_video'] ) {
				$type = 'video';
			} else {
				$type = 'image';
			}
			
			$caption = __( 'Instagram Image', 'catanis-core' );
			if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
				$caption = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
			}

			$instagram[] = array(
				'description' => $caption,
				'link'        => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
				'time'        => $image['node']['taken_at_timestamp'],
				'comments'    => $image['node']['edge_media_to_comment']['count'],
				'likes'       => $image['node']['edge_liked_by']['count'],
				'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
				'thumbnail_di'	=> array('width'=> 160, 'height' => 160),
				'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
				'small_di'		=> array('width'=> 320, 'height' => 320),
				'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
				'large_di'		=> array('width'=> 640, 'height' => 640),
				'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
				'original_di'	=> array('width'=> $image['node']['dimensions']['width'], 'height' => $image['node']['dimensions']['height']), 
				'type'        => $type,
			);
			
		} 

		/* do not set an empty transient - should help catch private or empty accounts */
		if ( ! empty( $instagram ) ) {
			$instagram = base64_encode( serialize( $instagram ) );
			set_transient( 'catanis-instagram-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'cata_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
		}
	}

	if ( ! empty( $instagram ) ) {
		return unserialize( base64_decode( $instagram ) );

	} else {
		return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'catanis-core' ) );
	}
	
}


/*==============================================================================
 * 2.  HOOKS
 *==============================================================================*/
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'user_contactmethods', 'catanis_custom_contact_method' );
if ( ! function_exists( 'catanis_custom_contact_method' ) ) {
	/**
	 * Add more field for user
	 *
	 * @param string  $option the option ID
	 * @return the option value. If there isn't a value set, returns the default value for the option.
	 */
	function catanis_custom_contact_method( $user_contact ) {
		$user_contact['position'] 	= esc_html__( 'Position Name', 'onelove' );
		$user_contact['twitter'] 	= esc_html__( 'Twitter ID', 'onelove' );
		$user_contact['facebook'] 	= esc_html__( 'Facebook ID', 'onelove' );
		$user_contact['googleplus'] = esc_html__( 'Google Plus ID', 'onelove' );
		$user_contact['behance'] 	= esc_html__( 'Behance ID', 'onelove' );
		$user_contact['instagram'] 	= esc_html__( 'Instagram ID', 'onelove' );
		$user_contact['linkedin'] 	= esc_html__( 'Linkedin ID', 'onelove' );
		return $user_contact;
	}
}

add_action('upload_mimes', 'catanis_custom_upload_mimes');
if ( ! function_exists( 'catanis_custom_upload_mimes' ) ) {
	/**
	 * Add more custom mimies for wordpress upload
	 * @param array $mimes
	 * @return array
	 */
	function catanis_custom_upload_mimes($mimes = array()) {
	
		$mimes['csv'] = "text/csv";
		$mimes['json'] = 'application/json';
		$mimes['svg'] = 'image/svg+xml';
	
		return $mimes;
	}
}

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

add_action( 'wp_head', 'catanis_customcode_before_head_tag', 20 );
if ( ! function_exists ( 'catanis_customcode_before_head_tag' ) ) {
	/**
	 * Quickly add some custom code css/js before close head tag.
	 *
	 * @return css/js
	 */
	function catanis_customcode_before_head_tag() {
		if( function_exists('catanis_option') ){
			$custom_code = catanis_option('before_head_end_code');
			if(!empty($custom_code)){
				echo stripslashes(trim($custom_code));
			}
		}
		
	}
}

add_action( 'catanis_hook_footer', 'catanis_customcode_before_body_tag', 20 );
if ( ! function_exists ( 'catanis_customcode_before_body_tag' ) ) {
	/**
	 * Quickly add some custom code html/css/js before close head tag.
	 *
	 * @return html/css/js
	 */
	function catanis_customcode_before_body_tag() {
		if( function_exists('catanis_option') ){
			$custom_code = catanis_option('before_body_end_code');
			if(!empty($custom_code)){
				echo stripslashes(trim($custom_code));
			}
		}
	}
}

if ( ! function_exists( 'catanis_deactive_somescript' ) ) {
	/**
	 * Remove some thing in head
	 *
	 * @return: void
	 */
	function catanis_deactive_somescript() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

		/* Post View Count - For Popular Post */
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	}
}
add_action('init', 'catanis_deactive_somescript');
