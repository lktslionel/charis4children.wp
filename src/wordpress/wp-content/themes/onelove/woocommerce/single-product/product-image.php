<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $post, $product, $catanis;
$catanis_page = $catanis->pageconfig;

$postID = $post->ID;
$vertical_thumbnails = (isset($catanis_page['prodetail_thumbnails_style']) && $catanis_page['prodetail_thumbnails_style'] == 'vertical');
$cloudzoom_enable 	= (isset($catanis_page['prodetail_enable_cloudzoom'])) ? $catanis_page['prodetail_enable_cloudzoom'] : catanis_option('prodetail_enable_cloudzoom') ;
$plus_button 		= ($cloudzoom_enable) ? '' : '<span class="cata-image-zoom-btn"><i class="ti-arrows-corner"></i></span>';
?>
<div class="cata-product-images">
	<?php 
		if($vertical_thumbnails){
			do_action( 'woocommerce_product_thumbnails' );
		}
		
		echo '<div class="images">';
		do_action('catanis_hook_before_product_image');
		
		if ( has_post_thumbnail() ) {
			
			$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
			/*$post_thumbnail_id = get_post_thumbnail_id( $post->ID );*/
			$post_thumbnail_id = $product->get_image_id();
			$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
			$attributes = array(
					'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
					'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
					'data-src'                => $full_size_image[0],
					'data-large_image'        => $full_size_image[0],
					'data-large_image_width'  => $full_size_image[1],
					'data-large_image_height' => $full_size_image[2],
			);
				
			if( $cloudzoom_enable){
				$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $postID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '" class="cloud-zoom zoom " id=\'product_zoom\' data-rel="position:\'inside\',showTitle:0,titleOpacity:0.5,lensOpacity:0.5,fixWidth:362,fixThumbWidth:72,fixThumbHeight:72,adjustX: 0, adjustY:'.(wp_is_mobile()?'0':'-4').'">';
				$html .= get_the_post_thumbnail( $postID, 'woocommerce_single', $attributes ) . $plus_button;
				$html .= '</a></div>';
			}
			else{
				$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $postID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '" class="fresco cata-item" data-fresco-group="product-gallery">';
				$html .= get_the_post_thumbnail( $postID, 'woocommerce_single', $attributes ) . $plus_button;
				$html .= '</a></div>';
			}
		
		}else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src('woocommerce_single') ), esc_html__( 'Awaiting product image', 'onelove' ) );
			$html .= '<p class="cata-product-info">'. esc_html('Please upload a thumbnail for product to use for thumbnail gallery.!', 'onelove') .'</p>';
			$html .= '</div>';
		}
		
		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
		do_action('catanis_hook_after_product_image');
		echo '</div>';
			
		if( !$vertical_thumbnails){
			do_action( 'woocommerce_product_thumbnails' );
		}
	?>
</div>

