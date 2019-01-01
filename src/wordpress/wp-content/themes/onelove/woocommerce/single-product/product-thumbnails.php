<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $post, $product, $catanis;
$catanis_page = $catanis->pageconfig;

$attachment_ids 	= $product->get_gallery_image_ids();
$cloudzoom_enable 	= (isset($catanis_page['prodetail_enable_cloudzoom'])) ? $catanis_page['prodetail_enable_cloudzoom'] : catanis_option('prodetail_enable_cloudzoom') ;

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	
	if( is_array($attachment_ids) && has_post_thumbnail() && $cloudzoom_enable ){
		array_unshift($attachment_ids, get_post_thumbnail_id());
	}
	?>
	<div class="thumbnails cata-product-thumbnails-slider">
		<?php
		if ( $attachment_ids && $product->get_image_id() ) {
			foreach ( $attachment_ids as $attachment_id ) {
	
				$classes = array();
				
				if ( $loop === 0 || $loop % $columns === 0 ) {
					$classes[] = 'first';
				}
				
				if ( ( $loop + 1 ) % $columns === 0 ) {
					$classes[] = 'last';
				}
	
				$image_class = implode( ' ', $classes );
				$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
				$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
				$image_title     = get_post_field( 'post_title', $attachment_id );
				$image_caption   = get_post_field( 'post_excerpt', $attachment_id );
				
				if( $cloudzoom_enable ){
					$single_thumbnail = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
					$image_class 	.= ' cloud-zoom-gallery ';
					$attributes = array(
							'alt'         	=> $image_title,
							'title'       	=> $image_title,
							'data-caption'  => $image_caption
					);
					$html  = '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '" class="'.esc_attr($image_class).'" data-rel="useZoom: \'product_zoom\', smallImage: \''.esc_url( $single_thumbnail[0] ).'\'">';
					$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
					$html .= '</a></div>';
				}else{
					$image_class	.= ' fresco cata-item';
					$attributes = array(
						'title'                   	=> $image_title,
						'data-caption' 				=> $image_caption,
						'data-src'                	=> $full_size_image[0],
						'data-large_image'        	=> $full_size_image[0],
						'data-large_image_width'  	=> $full_size_image[1],
						'data-large_image_height' 	=> $full_size_image[2],
					);
					
					$html  = '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '" class="'.esc_attr($image_class).'" data-fresco-group="product-gallery">';
					$html .= wp_get_attachment_image( $attachment_id, 'woocommerce_single', false, $attributes );
					$html .= '</a></div>';
					
				}
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
				$loop++;
			}
		}
		?>
	</div>
	<?php
}
