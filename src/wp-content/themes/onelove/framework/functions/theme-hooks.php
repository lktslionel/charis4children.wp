<?php 
/** LIST SECTIONS
 * 
 * 1. FILTER HOOK GENERAL 
 * 2. FILTER COMMENT
 * 3. FILTER VIDEO
 * 4. FILTER USERS
 */

/*==============================================================================
 * 1.  FILTER HOOK GENERAL
 *==============================================================================*/
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
add_filter( 'clean_url', 'catanis_so_handle_038', 99, 3 );
if ( ! function_exists( 'catanis_so_handle_038' ) ) {
	/**
	 * Desc: Filter URL in enqueue script
	 *
	 * @return: New URL filtered
	 */
	function catanis_so_handle_038( $url, $original_url, $_context ) {
		if ( strstr( $url, "googleapis.com" ) !== false ) {
			$url = str_replace( "&#038;", "&", $url );
		}
	
		return $url;
	}
}

add_filter( 'the_title', 'catanis_fiter_the_title', 10, 2 );
if ( ! function_exists( 'catanis_remove_number_paginate_links' ) ) {
	/**
	 * Filter the title for post
	 *
	 * @return post title
	 */
	function catanis_fiter_the_title( $title, $post_id = null ) {
		
		if(!is_admin() || wp_doing_ajax()){
			$title 	= str_replace('[', '<em>', $title);
			$title 	= str_replace(']', '</em>', $title);
		}
	
		return $title;
	}
}

add_filter('paginate_links', 'catanis_remove_number_paginate_links');
if ( ! function_exists( 'catanis_remove_number_paginate_links' ) ) {
	/**
	 * Fix to URL Problem : #038; replaces & and breaks the navigation
	 * 
	 * @return string
	 */ 
	function catanis_remove_number_paginate_links($link) {
		return str_replace('#038;', '&', $link);
	}
}

add_filter( 'wp_title', 'theme_filter_wp_title', 10, 2 );
if ( ! function_exists( 'theme_filter_wp_title' ) ) {
	/**
	 * Filters wp_title to print a neat <title> tag based
	 * 
	 * @return string The filtered title.
	 */
	function theme_filter_wp_title( $title, $sep ){
		if ( is_feed() ) {
			return $title;
		}
	
		global $page, $paged;
	
		/* Add the site name.*/
		$title .= get_bloginfo( 'name', 'display' );
	
		/* Add the blog description for the home/front page.*/
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}
	
		/*Add a page number if necessary*/
		if ( $paged >= 2 || $page >= 2 ){
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'onelove' ), max( $paged, $page ) );
		}
	
		return $title;
	}
}

add_filter( 'excerpt_length', 'catanis_custom_excerpt_length', 999 );
if ( ! function_exists( 'catanis_custom_excerpt_length' ) ) {
	
	function catanis_custom_excerpt_length( $length ) {
		return catanis_option('blog_excerpt_length');
	}
}

add_filter( 'the_content', 'auto_add_thickbox', 2 );
if ( ! function_exists( 'auto_add_thickbox' ) ) {
	/**
	 * Add thickbox for image of content
	 *
	 * @param string $content
	 * @return mixed
	 */
	function auto_add_thickbox($content){
		$content = preg_replace( '/<a(.*?)href="(.*?).(jpg|jpeg|png|gif|bmp|ico)"(.*?)><img/U', '<a$1href="$2.$3" $4 class="thickbox"><img', $content );
		return $content;
	}
}

add_filter( 'the_content', 'catanis_filter_relative_content_urls' );
if ( ! function_exists( 'catanis_filter_relative_content_urls' ) ) {
	function catanis_filter_relative_content_urls( $content ) {
		$content = str_replace( set_url_scheme( esc_url(home_url('/')), 'http' ), set_url_scheme( esc_url(home_url('/')), 'relative' ), $content);
		return $content;
	}
}

if ( ! function_exists( 'catanis_opengraph_for_posts' ) ) {
	/**
	 * Add meta opengraph for singular post
	 * <html <?php language_attributes();  prefix="og: http://ogp.me/ns#">
	 *
	 * @return mixed
	 */
	function catanis_opengraph_for_posts() {
				
		if ( is_singular() && !defined( 'WPSEO_PATH' )) {
			global $post;
			setup_postdata( $post );
			$output = '<meta property="og:type" content="article" />' . "\n";
			$output .= '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '" />' . "\n";
			$output .= '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
			$output .= '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '" />' . "\n";
			$output .= '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '" />' . "\n";
			if ( has_post_thumbnail() ) {
				$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
				$output .= '<meta property="og:image" content="' . esc_url($imgsrc[0]) . '" />' . "\n";
				$output .= '<meta itemprop="image" content="' . esc_url($imgsrc[0]) . '" />' . "\n";
			}
			echo trim($output);
		}
	}
}
add_action( 'wp_head', 'catanis_opengraph_for_posts');

if( !function_exists('catanis_remove_wp_version') ){
	/**
	 *  Remove WP Version Param From Any Enqueued Scripts & Stylesheet 
	 *  
	 */
	function catanis_remove_wp_version( $src ) {
		if( !is_admin() ){
			if ( strpos( $src, 'ver=' ) ){
				$src = esc_url( remove_query_arg( 'ver', $src ) );
			} 
			
			if ( strpos( $src, 'version=' ) ){
				$src = esc_url( remove_query_arg( 'version', $src ) );
			}
		}
		
		return $src;
	}
}
add_filter( 'style_loader_src', 'catanis_remove_wp_version', 9999 );
add_filter( 'script_loader_src', 'catanis_remove_wp_version', 9999 );

if ( ! function_exists( 'catanis_canonical_for_comments' ) ) {
	/**
	 * Resolve duplicate content in paged comments.
	 *
	 * @return: Link rel canonical
	 */
	function catanis_canonical_for_comments() {
		global $cpage, $post;
		if ( $cpage > 1 ) :
			echo "n<link rel='canonical' href='". get_permalink( $post->ID )."' />n";
		endif;
	}
}
add_action( 'wp_head', 'catanis_canonical_for_comments' );

if ( ! function_exists( 'add_oembed_soundcloud' ) ) {
	/**
	 * Add SoundCloud oEmbed
	 */
	function add_oembed_soundcloud() {
		wp_oembed_add_provider ( 'http://soundcloud.com/*', 'http://soundcloud.com/oembed' );
	}
}
add_action ( 'init', 'add_oembed_soundcloud' );

add_filter( 'body_class', 'catanis_browser_body_class' );
if ( ! function_exists( 'catanis_browser_body_class' ) ) {
	/**
	 * Detect the visitor browser using a hook
	 * 
	 * @param array $classes
	 * @return array
	 */
	function catanis_browser_body_class( $classes ) {
		global $catanis, $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	
		$catanis_page = $catanis->pageconfig;
		if ( $is_lynx ) $classes[] = 'lynx';
		elseif ( $is_gecko ) $classes[] = 'gecko';
		elseif ( $is_opera ) $classes[] = 'opera';
		elseif ( $is_NS4 ) $classes[] = 'ns4';
		elseif ( $is_safari ) $classes[] = 'safari';
		elseif ( $is_chrome ) $classes[] = 'chrome';
		elseif ( $is_IE ) $classes[] = 'ie';
		else $classes[] = 'unknown';
	
		if ( $is_iphone ) {
			$classes[] = 'iphone';
		}
	
		$menu_style = ( isset($_GET['menu']) && $_GET['menu'] == 'vertical' ) ? $_GET['menu'] : catanis_option( 'menu_style' );
		$classes[] = 'menu-' . $menu_style;
		
		if( isset($catanis_page['header_style']) && in_array($catanis_page['header_style'], array('v2', 'v4', 'v5'))){
			$classes[] = 'header-layout-center';
		}else{
			if(CATANIS_RTL){
				$classes[] = 'header-layout-left';
			}else{
				$classes[] = 'header-layout-right';
			}
		} 
		
		if ( ! catanis_option( 'header_fixed' ) ) {
			$classes[] = 'header-no-fixed';
		}
	
		if ( ! catanis_option( 'header_mobile_fixed' ) ) {
			$classes[] = 'header-mobile-no-fixed';
		}
	
		if ( ( is_home() || is_front_page() ) && isset( $catanis_page['slider'] ) && $catanis_page['slider'] == 'none' ) {
			$classes[] = 'home-default-background';
		}
	
		if ( (isset( $catanis_page['header_overlap'] ) && $catanis_page['header_overlap'] )) {
			$classes[] = 'header-overlap';
		}
		
		if (catanis_option( 'woo_catalog_mode' ) ) {
			$classes[] = 'woo-catalog-mode';
		}
		
		if (catanis_option( 'rtl_enable' ) ) {
			$classes[] = 'rtl';
		}
	
		if ( is_page_template( 'template-coming-soon.php' ) ) {
			$classes[] = 'coming-soon';
			if ( isset($_GET['style'])){
				$classes[] = $_GET['style'];
			}else{
				$classes[] = catanis_option('comingsoon_style');
			}
		}
	
		return $classes;
	}
}

add_filter( 'pre_get_posts', 'catanis_posttype_filter_search' );
if ( ! function_exists( 'catanis_posttype_filter_search' ) ) {
	/**
	 * This function modifies the main WordPress query to include an array of
	 * post types instead of the default 'post' post type.
	 *
	 * @param object $query  The original query.
	 * @return object $query The amended query.
	 */
	function catanis_posttype_filter_search( $query ) {

		if ( !is_admin() && $query->is_search ) {
			$search_type = catanis_option('search_type');
			
			if(is_array($search_type)){
				$query->set( 'post_type', array_combine($search_type, $search_type) );
			}else{
				if ( is_string($search_type) && !empty($search_type) ) {
					if (strpos($search_type, 'all') == false) {
						$search_type = explode(',', $search_type);
						$query->set( 'post_type', array_combine($search_type, $search_type) );
					}
				}
			} 
		}

		return $query;
	}
}

/** Disable WordPress update message **/
if ( ! current_user_can( 'edit_users' ) ) {
	add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
	add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}

/** Allow HTML in Category Descriptions **/
remove_filter('pre_term_description', 'wp_filter_kses');
remove_filter('pre_link_description', 'wp_filter_kses');
remove_filter('pre_link_notes', 'wp_filter_kses');
remove_filter('term_description', 'wp_kses_data');

/*==============================================================================
 * 2.  FILTER COMMENT
 *==============================================================================*/
if ( ! function_exists( 'catanis_filter_comments_open' ) ) {
	function catanis_filter_comments_open( $open, $post_id ) {
		
		if(!is_admin() ) {
			$post = get_post( $post_id );
			$data_config = get_post_meta( $post_id, Catanis_Meta::$meta_key, true );
			
			if( isset( $data_config['comment_enable'] ) ){
				if( catanis_check_option_bool( $data_config['comment_enable'] ) ){
					$open = true;
				}else{
					$open = false;
				}
			}else{
				if (get_post_meta($post->ID, 'Allow Comments', true)) {
					$open = true;
				}
			}
		}
		return $open;
		
	}
}
add_filter( 'comments_open', 'catanis_filter_comments_open', 10, 2 );


if ( ! function_exists( 'catanis_move_comment_field_to_bottom' ) ) {
	/**
	 * Move comment fields to bottom
	 * 
	 * @param array $fields
	 * @return array
	 * 
	 * Write code in theme-function.php -  if(is_singular( 'post' ))
	 * add_filter( 'comment_form_fields', 'catanis_move_comment_field_to_bottom' );
	 */
	function catanis_move_comment_field_to_bottom( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
		return $fields;
	}
}

add_action('comment_form_before_fields','catanis_before_comment_field_open');
if ( ! function_exists( 'catanis_before_comment_field_open' ) ) {
	/**
	 * Open a DIV to before comment fields 
	 * 
	 * @reurn html
	 */
	function catanis_before_comment_field_open(){
		echo '<div class="comment-author-wrapper">';
	}
}

add_action('comment_form_after_fields','catanis_before_comment_field_close');
if ( ! function_exists( 'catanis_before_comment_field_close' ) ) {
	/**
	 * Close a DIV to after comment fields
	 * 
	 * @return string
	 */
	function catanis_before_comment_field_close(){
		echo '</div>';
	}
}

add_action( 'comment_form_before', 'catanis_comment_form_before' );
if ( ! function_exists( 'catanis_comment_form_before' ) ) {
	/**
	 * Open a DIV to before comment form 
	 *
	 * @return string
	 */
	function catanis_comment_form_before(){
		echo '<div class="cata-comment-respond-wrapper cata-has-animation cata-fadeInUp">';
	}
}

add_action( 'comment_form_after', 'catanis_before_comment_field_close' );
if ( ! function_exists( 'catanis_before_comment_field_close' ) ) {
	/**
	 * Close a DIV to after comment form
	 *
	 * @return string
	 */
	function catanis_comment_form_after(){
		echo '</div>';
	}
}

/** Comment Item Template **/
function catanis_list_comment_item($comment, $args, $depth ){
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
<<?php echo ($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?>>
	<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<footer class="comment-meta">
			<div class="comment-author vcard">
				<h6><?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>AVATAR</h6>
			</div>

			<div class="wrap-comment-info">
				<div class="comment-metadata">
					<?php printf( esc_html__( '%s', 'onelove' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?> 
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>" class="meta-datetime">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'onelove' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a> 
					<?php edit_comment_link( esc_html__( 'Edit', 'onelove' ), '<span class="edit-link">', '</span>' ); ?>
				</div>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'onelove' ); ?></p>
				<?php endif; ?>
				
				<div class="comment-content">
					<?php comment_text(); ?>
				</div>
				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>'
					) ) );
				?>
			</div>
		</footer>
	</article>
<?php
}


/*==============================================================================
 * 3.  FILTER VIDEO
 *==============================================================================*/
add_filter( 'oembed_fetch_url', 'add_param_oembed_fetch_url', 10, 3 );
if ( ! function_exists( 'add_param_oembed_fetch_url' ) ) {
	/**
	 * Add extra parameters to video request API (oEmbed)
	 * 
	 * @param string $provider
	 * @param string $url
	 * @param array $args
	 */
	function add_param_oembed_fetch_url( $provider, $url, $args ) {

		$newargs = $args;
		$newargs['color'] = '407062';
		unset( $newargs['discover'] );
		unset( $newargs['width'] );
		unset( $newargs['height'] );

		$parameters = urlencode( http_build_query( $newargs ) );
		return $provider . '&'. $parameters;
	}
}

add_filter( 'oembed_result', 'add_player_id_to_ifame', 10, 3 );
if ( ! function_exists( 'add_player_id_to_ifame' ) ) {
	/**
	 * Add player ID to ifame IN on vimeo
	 * 
	 * @param string $html
	 * @param string $url
	 * @param array $args
	 * @return string
	 */
	function add_player_id_to_ifame( $html, $url, $args ) {
		if ( isset( $args['player_id'] ) ) {
			$newargs = $args;
			$concat = 'if'. 'rame';

			/* get rid of discover=true argument*/
			array_pop( $newargs );
			$parameters = http_build_query( $newargs );

			$html = str_replace( '<'.$concat, '<'.$concat.' id="' . $args['player_id'] . '"', $html );
			$html = str_replace( 'frameborder="0"', '', $html );
			$html = str_replace( '?feature=oembed', '?feature=oembed' . '&amp;' . $parameters, $html );
		}

		return $html;
	}
}


/*==============================================================================
 * 4.  FILTER USERS
 *==============================================================================*/
add_filter( 'avatar_defaults', 'customgravatar' );
if ( ! function_exists( 'customgravatar' ) ) {
	/**
	 * Add more custom avatar for theme
	 * 
	 * @param array $avatar_defaults
	 * @return array
	 */
	function customgravatar( $avatar_defaults ) {
	
		$myavatar = CATANIS_FRONT_IMAGES_URL . 'avatar_admin.png';
		$whitelist = array('127.0.0.1','::1');
	
		if ( in_array( $_SERVER['REMOTE_ADDR'], $whitelist ) ) {
			$myavatar = 'http://catanisthemes.com/guide/images/avatar_admin.png';
		}
	
		$avatar_defaults[$myavatar] = esc_html__( 'Catanis Themes', 'onelove' );
		return $avatar_defaults;
	}
}
?>