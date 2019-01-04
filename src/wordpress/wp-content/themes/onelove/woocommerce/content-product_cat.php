<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$classes = '';
if(isset($extend_class)){
	$classes = $extend_class;
}
?>
<section <?php wc_product_cat_class( $classes, $category ); ?>>
	<div class="cata-item-wrapper">
		<?php
		/**
		 * woocommerce_before_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_open - 10
		 */
		do_action( 'woocommerce_before_subcategory', $category );
	
		/**
		 * woocommerce_before_subcategory_title hook.
		 *
		 * @hooked woocommerce_subcategory_thumbnail - 10
		 */
		do_action( 'woocommerce_before_subcategory_title', $category );
	
		/**
		 * woocommerce_shop_loop_subcategory_title hook.
		 *
		 * @hooked woocommerce_template_loop_category_title - 10
		 */
		//do_action( 'woocommerce_shop_loop_subcategory_title', $category );
		?>
		
		<div class="cata-meta-wrapper"><div>
			<?php 
			if( !isset($show_title) || (isset($show_title) && $show_title == 'yes') ): 
				echo '<h6 class="category-name"><a href="' . get_term_link( $category, 'product_cat' ) . '">'.esc_html($category->name) .'</a></h6>';
			endif; 
			?>
			
			<?php 
				if( !isset($show_product_count) || (isset($show_product_count) && $show_product_count == 'yes') ): 
					if ( $category->count > 0 ){
						echo apply_filters( 'woocommerce_subcategory_count_html', '<mark class="count">' . sprintf( _n( '%s Product', '%s Products', $category->count, 'onelove' ), $category->count ) . '</mark>', $category );
					}
				endif; 
			?>
		</div></div>
		
		<?php 
		/**
		 * woocommerce_after_subcategory_title hook.
		 */
		do_action( 'woocommerce_after_subcategory_title', $category );
	
		/**
		 * woocommerce_after_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_close - 10
		 */
		do_action( 'woocommerce_after_subcategory', $category ); ?>
	</div>
</section>
