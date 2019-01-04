<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $catanis;

$catanis_page = $catanis->pageconfig;
$_main_class = (!empty($catanis_page['layout']) && $catanis_page['layout'] != 'full') ? 'col-md-9' : 'col-md-12';

get_header( 'shop' ); 
?>
<div class="page-template <?php catanis_extend_class_page(true); ?>">
	<?php if($catanis_page['layout'] == 'left'): get_sidebar('shop'); endif;?>

	<div id="cata-main-content" class="<?php echo esc_attr($_main_class); ?>">
		<?php
			/**
			 * Hook: woocommerce_before_main_content.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 * @hooked WC_Structured_Data::generate_website_data() - 30
			 */
			do_action( 'woocommerce_before_main_content' );
		?>

		<div id="page-<?php the_ID(); ?>">
			<div class="entry-content">		
				<div class="cata-container">	
					<?php
						/**
						 * Hook: woocommerce_archive_description.
						 *
						 * @hooked woocommerce_taxonomy_archive_description - 10
						 * @hooked woocommerce_product_archive_description - 10
						 */
						do_action( 'woocommerce_archive_description' );
					?>

					<div class="clearboth"></div>
					<?php if ( woocommerce_product_loop() ) : ?>
						<div class="cata-before-loop-wrapper">
							<?php
								/**
								 * Hook: woocommerce_before_shop_loop.
								 *
								 * @hooked wc_print_notices - 10
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								do_action( 'woocommerce_before_shop_loop' );
							?>
						</div>
						
						<?php 
							global $woocommerce_loop;
							
							/*=== Use $_GET for Demo Purpose Only ===*/
							$procate_columns = catanis_option( 'procate_columns' );
							if( isset($_GET['preset'])){
								$procate_columns = $_GET['preset'];
							}
							
							$procate_columns = str_replace( 'col', '', $procate_columns);
							if( absint($procate_columns) > 0 && in_array($procate_columns, array(2,3,4,5)) ){
								$woocommerce_loop['columns'] = absint($procate_columns);
							}else{
								$woocommerce_loop['columns'] = 4;
							}
						?>
						<div class="woocommerce columns-<?php echo esc_attr($woocommerce_loop['columns']); ?>">
						
						<?php woocommerce_product_loop_start(); ?>
			
							<?php woocommerce_product_subcategories(); ?>
										
							<?php 
							if ( wc_get_loop_prop( 'total' ) ) {
								while ( have_posts() ) {
									the_post(); 
								
									/**
									 * woocommerce_shop_loop hook.
									 *
									 * @hooked WC_Structured_Data::generate_product_data() - 10
									 */
									do_action( 'woocommerce_shop_loop' );
									wc_get_template_part( 'content', 'product' );
								}
							}
							?>
						<?php woocommerce_product_loop_end(); ?>
						</div>
						
						<div class="cata-after-loop-wrapper">
							<?php
								/**
								 * woocommerce_after_shop_loop hook.
								 *
								 * @hooked woocommerce_pagination - 10
								 */
								do_action( 'woocommerce_after_shop_loop' );
							?>
						</div>
						
					<?php //elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
					<?php else: 
							/**
							 * Hook: woocommerce_no_products_found.
							 *
							 * @hooked wc_no_products_found - 10
							 */
							do_action( 'woocommerce_no_products_found' );
					endif; ?>
				</div>
			</div>
		</div>
		
		<?php
			/**
			 * Hook: woocommerce_after_main_content.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
		?>

	</div>
	<?php if($catanis_page['layout'] == 'right'): get_sidebar('shop'); endif;?>
</div>
<?php get_footer( 'shop' ); ?>
