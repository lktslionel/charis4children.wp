<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*Custom*/
global $catanis;
$catanis_page = $catanis->pageconfig;

$items_show = (isset($catanis_page['layout']) && $catanis_page['layout'] != 'full') ? 3 : 4;
$isList = (count($upsells) <= $items_show) ? ' cata-islist' : '';
$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
$arrParams = array(
	'autoplay' 			=> true,
	'autoplaySpeed' 	=> 3000,
	'slidesToShow' 		=> intval($items_show),
	'slidesToScroll' 	=> intval($items_show) - 1 ,
	'dots' 				=> false,
	'arrows' 			=> false,
	'infinite' 			=> true,
	'draggable' 		=> true,
	'speed' 			=> 600,
	'rtl' 				=> CATANIS_RTL,
	'adaptiveHeight' 	=> true,
	'responsive'		=> array(
		array(
			'breakpoint'	=> 1024,
			'settings'		=> array(
				'slidesToShow'		=> 3,
				'slidesToScroll' 	=> 2
			)
		),
		array(
			'breakpoint'	=> 768,
			'settings'		=> array(
				'slidesToShow'		=> 2,
				'slidesToScroll' 	=> 1
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

if ( $upsells ) : ?>

	<section class="up-sells upsells products cata-has-animation cata-fadeInUp">

		<h2><?php esc_html_e( 'You may also like&hellip;', 'onelove' ) ?></h2>

		<?php woocommerce_product_loop_start(); ?>
			<div<?php echo rtrim($dir); ?> id="cata_upsells" class="cata-slick-slider cata-slider-spacing30<?php echo esc_attr($isList); ?>">
				<div class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
					<?php 
						foreach ( $upsells as $upsell ) : 
			
						 	$post_object = get_post( $upsell->get_id() );

							setup_postdata( $GLOBALS['post'] =& $post_object );

							wc_get_template_part( 'content', 'product' );
			
						endforeach; 
					?>
				</div>
			</div>
		<?php woocommerce_product_loop_end(); ?>

	</section>
	
<?php endif;

wp_reset_postdata();
