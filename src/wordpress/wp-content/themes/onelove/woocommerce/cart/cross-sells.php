<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
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
$items_show = 4;
$isList = (count($cross_sells) <= $items_show) ? ' cata-islist' : '';
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

if ( $cross_sells ) : ?>

	<div class="cross-sells cata-has-animation cata-fadeInUp">

		<h2><?php _e( 'You may be interested in&hellip;', 'onelove' ) ?></h2>

		<?php woocommerce_product_loop_start(); ?>
			<div<?php echo rtrim($dir); ?> id="cata_cross_sells" class="cata-slick-slider cata-slider-spacing30<?php echo esc_attr($isList); ?>">
				<div class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
					<?php foreach ( $cross_sells as $cross_sell ) : ?>
		
						<?php
						 	$post_object = get_post( $cross_sell->get_id() );
		
							setup_postdata( $GLOBALS['post'] =& $post_object );
		
							wc_get_template_part( 'content', 'product' ); ?>
		
					<?php endforeach; ?>
				</div>
			</div>
		<?php woocommerce_product_loop_end(); ?>

	</div>
	
<?php endif;

wp_reset_postdata();
