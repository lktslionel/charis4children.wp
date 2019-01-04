<?php
if(!catanis_is_woocommerce_active() || !class_exists('WooCommerce')){
	return;
}

/*OR add_filter( 'woocommerce_enqueue_styles', '__return_false' );*/
add_filter( 'woocommerce_enqueue_styles', 'catanis_dequeue_woo_styles' );
function catanis_dequeue_woo_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-layout'] );
	unset( $enqueue_styles['woocommerce-smallscreen'] );	
	unset( $enqueue_styles['woocommerce-general'] );
	return $enqueue_styles;
}

add_filter('loop_shop_per_page', 'catanis_change_products_per_page_shop' );
add_filter('woocommerce_product_get_rating_html', 'catanis_get_empty_rating_html', 10, 2);
/****************************************************************
 * Shop - Category [archive-product.php]
 ****************************************************************/
remove_action('woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10);

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

remove_action('woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10);

add_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 5);

/****************************************************************
 * Product Item [content-product.php]
 ****************************************************************/
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

/*Add new action hook*/
add_action('woocommerce_before_shop_loop_item_title', 'catanis_template_loop_product_thumbnail', 10);

add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_categories', 10);
add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_title', 20);
add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_sku', 30);

add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_before_cartprice', 40);
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 50);
add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_add_to_cart', 60);
add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_after_cartprice', 70);

add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_excerpt_grid', 80);
add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_excerpt_list', 85);
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 90);

add_action('woocommerce_after_shop_loop_item_title', 'catanis_template_loop_product_label', 1);

function catanis_template_loop_before_cartprice(){
	$cls = (!catanis_option('procate_enable_addtocart') ) ? ' cata-disable-addtocart' : '';
	$cls .= (!catanis_option('procate_enable_price') ) ? ' cata-disable-price' : '';
	
	echo '<div class="cata-loop-cartprice-wrapper'. $cls .'">';
}

function catanis_template_loop_after_cartprice(){
	echo '</div>';
}

function catanis_template_loop_add_to_cart(){
	
	if( catanis_option('woo_catalog_mode') ){
		return;
	}
	
	echo '<div class="cata-loop-add-to-cart">';
		woocommerce_template_loop_add_to_cart();
	echo '</div>';
}

function catanis_template_loop_product_excerpt_grid(){
	global $post, $product;
	
	$enable_gridlist = catanis_option( 'procate_enable_gridlist' );
	$grid_mode = catanis_option( 'procate_desc_grid_mode' );
	$number_words_grid = absint( $grid_mode['number_words'] );

	if ( empty( $post->post_excerpt ) ) return;
	
	$xhtml 	= '';
	if ( ! ( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive( 'product' ) ) ) {
		if ( catanis_check_option_bool( $grid_mode['status'] ) ) :
			$xhtml 	.= '<div class="product-excerpt">';
			$xhtml 	.=	catanis_get_the_excerpt_max_words( $number_words_grid, null, false, true, " ..." );
			$xhtml 	.= '</div>';
		endif;
	} else {
		if ( catanis_check_option_bool( $grid_mode['status'] ) ) :
			$xhtml 	.= '<div class="product-excerpt grid" style="'. (($enable_gridlist) ? 'display: none' : '') .'">';
			$xhtml 	.=	catanis_get_the_excerpt_max_words( $number_words_grid, null, false );
			$xhtml 	.= '</div>';
		endif;
	}
	
	echo trim($xhtml);
}

function catanis_template_loop_product_excerpt_list(){
	global $post, $product;

	$list_mode = catanis_option( 'procate_desc_list_mode' );
	$number_words_list = absint( $list_mode['number_words'] );
	$is_archive = is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product');
	
	$xhtml 	= '';
	if ( $list_mode['status'] && $is_archive):
		$xhtml 	.= '<div class="product-excerpt list" style="display: none">';
		$xhtml 	.= catanis_get_the_excerpt_max_words( $number_words_list, null, false );
		$xhtml 	.= '</div>';
	endif;

	echo trim($xhtml);
}

function catanis_template_loop_product_sku(){
	global $product, $post;
	if($product->get_sku()){
		echo '<span class="cata-product-sku">' . esc_attr($product->get_sku()) . '</span>';
	}
}

function catanis_template_loop_product_title(){
	global $post, $product;
	$uri = get_permalink($post->ID);
	echo '<h3 class="product_title"><a href='. esc_url($uri) .'>'. get_the_title() .'</a></h3>';
}

function catanis_template_loop_product_categories(){
	global $product;
	$categories_label = esc_html__('Categories: ', 'onelove');
	echo wc_get_product_category_list($product->get_id(), ', ', '<div class="product-categories"><span>'.$categories_label.'</span>', '</div>');
}

function catanis_template_loop_product_label(){
	global $post, $product;
	$xhtml 	= '';
	
	$out_of_stock = false;
	$product_stock = $product->get_availability();
	if( isset($product_stock['class']) && $product_stock['class'] == 'out-of-stock' ){
		$out_of_stock = true;
	}
	
	$showme = false;
	$show_sale_label_as = catanis_option('woo_show_sale_label_as');
		
	/* Sale label */
	if( $product->is_on_sale() && !$out_of_stock ){ 
		$showme = true;
		if( $product->get_regular_price() > 0 && $show_sale_label_as != 'text' ){
			$_off_percent = (1 - round($product->get_price() / $product->get_regular_price(), 2))*100;
			$_off_price = round($product->get_regular_price() - $product->get_price(), 0);
			$_price_symbol = get_woocommerce_currency_symbol();
			if( $show_sale_label_as == 'number' ){
			
				$symbol_pos = get_option('woocommerce_currency_pos', 'left');
				$price_display = '';
				switch( $symbol_pos ){
					case 'left':
						$price_display = '-'.$_price_symbol.$_off_price;
					break;
					case 'right':
						$price_display = '-'.$_off_price.$_price_symbol;
					break;
					case 'left_space':
						$price_display = '-'.$_price_symbol.' '.$_off_price;
					break;
					default: /* right_space */
						$price_display = '-'.$_off_price.' '.$_price_symbol;
					break;
				}
				 
				$xhtml 	.= '<span class="onsale amount" data-original="'.$price_display.'">'.$price_display.'</span>';
			}
			if( $show_sale_label_as == 'percent' ){
				$xhtml 	.= '<span class="onsale percent">-'.$_off_percent.'%</span>';
			}
		}
		else{
			$xhtml 	.= '<span class="onsale">'.esc_html(stripslashes(catanis_option('woo_sale_label_text'))).'</span>';
		}
		
	}
	
	/* Featured label */
	if( $product->is_featured() && !$out_of_stock ){
		$showme = true;
		$xhtml 	.= '<span class="featured">'.esc_html(stripslashes(catanis_option('woo_feature_label_text'))).'</span>';
	}
	
	/* Out of stock */
	if( $out_of_stock ){
		$showme = true;
		$xhtml 	.= '<span class="out-of-stock">'.esc_html(stripslashes(catanis_option('woo_out_of_stock_label_text'))).'</span>';
	}
	
	if($showme){
		echo '<div class="product-label">' . $xhtml . '</div>';
	}
	
}

function catanis_template_loop_product_thumbnail(){
	global $product;

	$lazy_load = catanis_option('woo_enable_lazy_load') && !( defined( 'DOING_AJAX' ) && DOING_AJAX );
	$placeholder_img_src = (catanis_option('woo_placeholder_lazyload')) ? catanis_option('woo_placeholder_lazyload') : wc_placeholder_img_src();
	
	if( defined( 'YITH_INFS' ) && (is_shop() || is_product_taxonomy()) ){ /* Compatible with YITH Infinite Scrolling */
		$lazy_load = false;
	}

	$prod_galleries = $product->get_gallery_image_ids();
								
	$has_back_image = catanis_option('woo_effect_product');

	if( !is_array($prod_galleries) || ( is_array($prod_galleries) && count($prod_galleries) == 0 ) ){
		$has_back_image = false;
	}

	if( wp_is_mobile() ){
		$has_back_image = false;
	}

	$image_size = 'shop_catalog';
	$dimensions = wc_get_image_size( $image_size );

	echo '<figure class="'.(($has_back_image) ? 'has-back-image' : 'no-back-image').'">';
	if( !$lazy_load ){
		echo woocommerce_get_product_thumbnail( $image_size );
		if( $has_back_image ){
			echo wp_get_attachment_image( $prod_galleries[0], $image_size, 0, array('class' => 'product-image-back') );
		}
		
	}
	else{	
		$front_img_src = '';
		$alt = '';
		if( has_post_thumbnail( $product->get_id() ) ){
			$post_thumbnail_id = get_post_thumbnail_id($product->get_id());
			$image_obj = wp_get_attachment_image_src($post_thumbnail_id, $image_size, 0);
			if( isset($image_obj[0]) ){
				$front_img_src = $image_obj[0];
			}
			$alt = trim(strip_tags( get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true) ));
		}
		else if( wc_placeholder_img_src() ){
			$front_img_src = wc_placeholder_img_src();
		}
			
		echo '<img src="'.esc_url($placeholder_img_src).'" data-src="'.esc_url($front_img_src).'" class="attachment-shop_catalog wp-post-image cata-lazy-load" alt="'.esc_attr($alt).'" width="'.$dimensions['width'].'" height="'.$dimensions['height'].'" />';
			
		if( $has_back_image ){
			$back_img_src = '';
			$alt = '';
			$image_obj = wp_get_attachment_image_src($prod_galleries[0], $image_size, 0);
			if( isset($image_obj[0]) ){
				$back_img_src = $image_obj[0];
				$alt = trim(strip_tags( get_post_meta($prod_galleries[0], '_wp_attachment_image_alt', true) ));
			}
			else if( wc_placeholder_img_src() ){
				$back_img_src = wc_placeholder_img_src();
			}

			echo '<img src="'.esc_url($placeholder_img_src).'" data-src="'.esc_url($back_img_src).'" class="product-image-back cata-lazy-load" alt="'.esc_attr($alt).'" width="'.$dimensions['width'].'" height="'.$dimensions['height'].'" />';
		}
	}
	echo '</figure>';
}

function catanis_change_products_per_page_shop(){
	if( is_tax('product_cat') || is_tax('product_tag') || is_post_type_archive('product') ){
		if( absint(catanis_option('procate_products_per_page')) > 0){
			return absint(catanis_option('procate_products_per_page'));
		}
	}
}

function catanis_get_empty_rating_html( $rating_html, $rating ){
	if( $rating == 0 ){
		$rating_html  = '<div class="star-rating no-rating" title="">';
		$rating_html .= '<span style="width:0%"></span>';
		$rating_html .= '</div>';
	}
	return $rating_html;
}

/****************************************************************
 * Single Product [content-single-product.php]
 ****************************************************************/
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

add_action('catanis_hook_top_single_product', 'catanis_template_single_navigation', 5);

add_action('catanis_hook_top_single_product', 'catanis_template_single_before_top', 10);
add_action('catanis_hook_top_single_product', 'catanis_template_loop_product_categories', 20);
add_action('catanis_hook_top_single_product', 'woocommerce_template_single_title', 30);
add_action('catanis_hook_top_single_product', 'woocommerce_template_single_rating', 40);
add_action('catanis_hook_top_single_product', 'catanis_template_single_after_top', 50);

add_action('catanis_hook_before_product_image', 'catanis_template_loop_product_label', 10);
add_action('catanis_hook_after_product_image', 'catanis_template_single_video', 11);
add_action('woocommerce_single_product_summary', 'catanis_template_single_availability', 11);
add_action('woocommerce_single_product_summary', 'catanis_template_single_shippingbox', 70);

add_action('woocommerce_share', 'catanis_template_single_social_sharing', 10);

function catanis_template_single_social_sharing(){
	global $post, $product;
	echo catanis_get_share_btns_html($post->ID, 'product', true );
}

function catanis_template_single_before_top( $classes ){
	echo '<div class="cata-product-single-top">';
}
function catanis_template_single_after_top(){
	echo '</div>';
}
function catanis_template_single_navigation(){
	
	$xhtml = '';
	$prev_post = get_adjacent_post(false, '', true, 'product_cat');
	$next_post = get_adjacent_post(false, '', false, 'product_cat');

	$xhtml .= '<div class="cata-single-navigation">';
	
	if( $prev_post ){
		$post_id = $prev_post->ID;
		$product = wc_get_product($post_id);
		
		$xhtml 	.= '<div class="cata-prev"><a href="'. get_permalink($post_id) .'">';
		$xhtml 	.= '	<div class="product-info prev-product-info">'. $product->get_image();
		$xhtml 	.= '		<div><span>'. esc_html(catanis_string_limit_words($product->get_title(), 5, '...' )) .'</span><span class="price">'. $product->get_price_html() .'</span></div>';
		$xhtml 	.= '	</div>';
		$xhtml 	.= '</a></div>';
	}
			
	if( $next_post ){
		$post_id = $next_post->ID;
		$product = wc_get_product($post_id);
		
		$xhtml 	.= '<div class="cata-next"><a href="'. get_permalink($post_id) .'">';
		$xhtml 	.= '	<div class="product-info next-product-info">'. $product->get_image();
		$xhtml 	.= '		<div><span>'. esc_html(catanis_string_limit_words($product->get_title(), 5, '...' )) .'</span><span class="price">'. $product->get_price_html() .'</span></div>';
		$xhtml 	.= '	</div>';
		$xhtml 	.= '</a></div>';
	}
	$xhtml .= '</div >';
	
	echo wp_kses_post($xhtml);
}

function catanis_template_single_shippingbox(){
	echo '<div class="cata-product-shippingbox">';
		wc_get_template( 'single-product/shippingbox.php' );
	echo '</div>';
}

function catanis_template_single_video(){

	global $post, $product;
	
	$data_config = get_post_meta( $post->ID, Catanis_Meta::$meta_key, true );
	
	if( isset($data_config['prodetail_video']) ){
		
		$video_link = $data_config['prodetail_video'];
		if( function_exists('catanis_video_shortcode_function') && !empty($video_link) ){
			$video_type = catanis_check_video_type($video_link);
		
			if( !in_array( $video_type, array( 'youtube', 'vimeo' ) ) ){
				return;
			}
		
			$opts = array(
				'video_style' 		=> 'popup',
				'video_host' 		=> $video_type,
				'video_url_youtube' => $video_link,
				'video_url_vimeo' 	=> $video_link,
				'control_color' 	=> '#e49497',
				'video_opts' 		=> 'controls',
				'ext_class' 		=> 'single-product-video'
			);
			echo catanis_video_shortcode_function($opts);
		}
	}
}
function catanis_template_single_availability(){
	global $product;
	
	$product_stock = $product->get_availability();
	$availability_text = empty($product_stock['availability']) ? esc_html__('In Stock', 'onelove') : esc_attr($product_stock['availability']);
	
	echo '<p class="availability stock '.esc_attr($product_stock['class']) .'" data-original="'. esc_attr($availability_text) .'" data-class="'. esc_attr($product_stock['class']) .'">
			<span>'. esc_html($availability_text) .'</span></p>';
}

/*=== PRODUCT TABS ===*/
/* Fix for WooCommerce Tab Manager plugin */
if( !is_admin() ){ 
	add_filter( 'woocommerce_product_tabs', 'catanis_remove_product_custom_tabs', 999 );
	add_filter( 'woocommerce_product_tabs', 'catanis_add_product_custom_tab', 90 );
}
function catanis_remove_product_custom_tabs( $tabs = array() ){
	if( !catanis_option('prodetail_enable_tabs') ){
		return array();
	}
	return $tabs;
}
function catanis_add_product_custom_tab( $tabs = array() ){
	global $catanis, $post;
	$catanis_page = $catanis->pageconfig;
	
	if(isset($catanis_page['custom_tabs_use_default']) && !$catanis_page['custom_tabs_use_default']){
		$custom_tab_title = $catanis_page['custom_tabs_title'];
	}else{
		$custom_tab_title = catanis_option('prodetail_custom_tabs_title');
	}
	
	if( catanis_option('prodetail_enable_custom_tabs') ){
		$tabs['cata_custom'] = array(
			'title'    	=> esc_html( $custom_tab_title ),
			'priority' 	=> 90,
			'callback' 	=> "catanis_product_custom_tab_content"
		);
	}
	return $tabs;
}

function catanis_product_custom_tab_content(){
	global $catanis, $post;
	$catanis_page = $catanis->pageconfig;
	
	if(isset($catanis_page['custom_tabs_use_default']) && !$catanis_page['custom_tabs_use_default']){
		$custom_tab_content = $catanis_page['custom_tabs_content'];
	}else{
		$custom_tab_content = catanis_option('prodetail_custom_tabs_content');
	}

	echo do_shortcode( stripslashes( htmlspecialchars_decode( $custom_tab_content ) ) );
}

/* Remove heading tile in Description tab of product*/
add_filter('woocommerce_product_description_heading', create_function('', 'return "";'));

/* Remove heading tile in Additional Information tab of product*/
add_filter('woocommerce_product_additional_information_heading', create_function('', 'return "";'));

/* Always show the price in variable product */
add_filter('woocommerce_available_variation', 'catanis_variable_product_price_filter', 10, 3);
function catanis_variable_product_price_filter( $value, $object = null, $variation = null ){
	if( $value['price_html'] == '' ){
		$value['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
	}
	return $value;
}

/* Related products */
add_filter('woocommerce_output_related_products_args', 'catanis_output_related_products_args_filter');
function catanis_output_related_products_args_filter( $args ){
	$args['posts_per_page'] = 8;
	$args['columns'] = 4;
	return $args;
}

/****************************************************************
 * Cart page [.php]
****************************************************************/
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 10 );

add_action('woocommerce_proceed_to_checkout', 'catanis_cart_continue_shopping_button', 20);
function catanis_cart_continue_shopping_button(){
	echo '<a href="'.esc_url(wc_get_page_permalink('shop')).'" class="button cata-button2">'. esc_html__('Continue Shopping', 'onelove') .'</a>';
}


