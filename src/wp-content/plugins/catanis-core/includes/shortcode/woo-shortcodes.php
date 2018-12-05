<?php
/*=== SHORTCODE - PRODUCT CATEGORIES SLIDER ==*/
/*============================================*/
if( !function_exists('catanis_product_shippingbox_shortcode_function') ){
	function catanis_product_shippingbox_shortcode_function($atts, $content){
		
		$icon = $text = $ext_class = '';
		extract(shortcode_atts(array(
			'icon' 					=> 'ti-package',
			'text'					=> 'Free Shipping',
			'ext_class' 			=> ''
		),$atts));
		
		if ( !class_exists('WooCommerce') ){
			return;
		}
		
		$elemClass 	= 'cata-shippingbox';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		return '<div class="'. esc_attr($elemClass) .'"><i class="'. esc_attr($icon) .'"></i><span>'. esc_html($text) .'</span></div>';
		
	}
}
add_shortcode('cata_product_shippingbox', 'catanis_product_shippingbox_shortcode_function');

if( !function_exists('catanis_product_categories_slider_shortcode_function') ){
	function catanis_product_categories_slider_shortcode_function($atts, $content){
		
		$main_style = $number = $columns = $orderby = $order = $parent = $child_of = $ids = $hide_empty = $show_title = $show_product_count = $with_padding = $padding_value = '';
		$items_desktop = $items_desktop_small = $items_tablet = $slide_arrows = $slide_loop = $slide_dots = $slide_dots_style ='';
		$slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $ext_class = '';
		extract(shortcode_atts(array(
			'main_style' 			=> 'slider',
			'number' 				=> 7,
			'columns' 				=> 3,
			'orderby'				=> 'name',
			'order'					=> 'DESC',
			'parent' 				=> '',
			'child_of' 				=> '',
			'ids' 					=> '',
			'hide_empty' 			=> 'yes',
			'show_title' 			=> 'yes',
			'show_product_count' 	=> 'no',
			'with_padding' 			=> 'no',
			'padding_value' 		=> '30',
			
			'slide_dots_style'		=> 'dots-line',
			'ext_class' 			=> ''
		),$atts));

		if ( !class_exists('WooCommerce') ){
			return;
		}
		
		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_pro_cate');
		$elemClass 	= 'cata-product-categories cata-element cata-' . $main_style;
		$elemClass .= ($main_style == 'slider') ? ' cata-slick-slider ' . $slide_dots_style : '';
		$elemClass .= ($with_padding == 'yes') ? ' cata-slider-spacing' . absint($padding_value) : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
		
		$arrParams = array();
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		if($main_style == 'slider'){
			$arrParams = catanis_get_params_slick_slider($atts);
			$columns = $items_desktop;
		}
	
		$args = array(
			'orderby'	 	=> $orderby,
			'order'      	=> $order,
			'hide_empty' 	=> $hide_empty,
			'include'     	=> array_map('trim', explode(',', $ids)),
			'pad_counts'  	=> true,
			'parent'      	=> $parent,
			'child_of'  	=> $child_of,
			'number'     	=> $number
		);
		$product_categories = get_terms('product_cat', $args);
		
		global $woocommerce_loop;
		$old_woocommerce_loop_columns = $woocommerce_loop['columns'];
		$woocommerce_loop['columns'] = $columns;
		
		ob_start();
		$i = 1;
		if( count($product_categories) > 0 ):
		?>
			<div<?php echo rtrim($dir); ?> id="<?php echo esc_attr($elemID); ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo ($animation['animation-attrs']); ?>>
				<?php /*woocommerce_product_loop_start();*/ ?>
				<div class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
					<?php 
					foreach ( $product_categories as $category ) {
						$extend_class = ($i%3==1) ? ' cata-full-img' : '';
						wc_get_template( 'content-product_cat.php', array(
							'category' 				=> $category,
							'show_title' 			=> $show_title,
							'show_product_count' 	=> $show_product_count,
							'extend_class' 			=> 'cata-item' . $extend_class
						) );
						$i += 1;
					}
					woocommerce_reset_loop();
					?>
				</div>
				<?php /*woocommerce_product_loop_end();*/ ?>
			</div>
		<?php
		endif;
		
		$woocommerce_loop['columns'] = $old_woocommerce_loop_columns;
		
		return '<div class="woocommerce">' . ob_get_clean() . '</div>';			
	}
}
add_shortcode('cata_product_categories_slider', 'catanis_product_categories_slider_shortcode_function');


if( !function_exists('catanis_products_shortcode_function') ){
	function catanis_products_shortcode_function($atts, $content){

		$main_style = $product_type = $columns = $orderby = $order = $rows = $number = $product_cats = $with_padding = $padding_value = '';
		$show_title = $show_label = $show_price = $show_sku = $show_categories = $show_rating = $show_addtocart = $show_excerpt = '';
		$items_desktop = $items_desktop_small = $items_tablet = $slide_arrows = $slide_loop = $slide_dots = $slide_dots_style ='';
		$slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $ext_class = '';
		extract(shortcode_atts(array(
			'main_style' 		=> 'slider',				/*slider, list*/
			'product_type'		=> 'recent',
			'orderby'			=> 'date',
			'order'				=> 'desc',
			'columns' 			=> 3,
			'number' 			=> 9,
			'product_cats'		=> '',
			'with_padding' 		=> '',						/*NULL, yes*/
			'padding_value' 	=> '30',
			
			'show_title' 			=> 'yes',
			'show_label' 			=> 'yes',
			'show_price' 			=> 'yes',
			'show_sku' 				=> 'no',
			'show_categories'		=> 'yes',
			'show_rating' 			=> 'yes',
			'show_addtocart' 		=> 'yes',
			'show_excerpt'  		=> 'no',
			
			'items_desktop' 		=> '3',
			'items_desktop_small' 	=> '3',
			'items_tablet' 			=> '2',
			'slide_loop'			=> 'yes',
			'slide_arrows'			=> 'no',
			'slide_dots'			=> 'yes',
			'slide_dots_style'		=> 'dots-line', 		/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/
			'slide_autoplay'		=> 'no',
			'slide_autoplay_speed'	=> 3000,
			'slides_to_scroll'		=> 3,
			'slides_speed'			=> 500,
			'ext_class' 			=> ''
		), $atts));

		if ( !class_exists('WooCommerce') ){
			return;
		}

		$options = array(
			'show_label'		=> $show_label,
			'show_title'		=> $show_title,
			'show_sku'			=> $show_sku,
			'show_excerpt'		=> $show_excerpt,
			'show_categories'	=> $show_categories,
			'show_rating'		=> $show_rating/*,
			'show_price'		=> $show_price,
			'show_addtocart'	=> $show_addtocart*/
		);
		
		catanis_remove_product_hooks_shortcode( $options );
		
		$meta_query  = WC()->query->get_meta_query();
		$tax_query   = WC()->query->get_tax_query();
		$args = array(
			'post_type'           	=> 'product',
			'post_status'         	=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'posts_per_page' 		=> $number,
			'orderby' 				=> $orderby,
			'order' 				=> $order
		);
		
		switch( $product_type ){
			case 'sale':
				$meta_query[] = array(
					'key' 			=> '_sale_price',
					'value' 		=>  0,
					'compare'   	=> '>',
					'type'      	=> 'NUMERIC'
				);
				break;
				
			case 'featured':
				$tax_query[] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
					'operator' => 'IN',
				); 				
				break;
								
			case 'best_selling':
				$args['meta_key'] 	= 'total_sales';
				$args['orderby'] 	= 'meta_value_num';
				break;
				
			case 'top_rated':
				$args['meta_key'] 	= '_wc_average_rating';
				$args['orderby'] 	= 'meta_value_num';
				break;
				
			case 'mixed_order':
				$args['orderby'] 	= 'rand';
				break;
				
			default: /* Recent */
				break;
		}

		$product_cats = str_replace(' ', '', $product_cats);
		if( strlen($product_cats) > 0 ){
			$product_cats = explode(',', $product_cats);
		}

		if( is_array($product_cats) && count($product_cats) > 0 ){
			$field_name = is_numeric($product_cats[0]) ? 'term_id' : 'slug';
			$tax_query[] = array(
				array(
					'taxonomy' => 'product_cat',
					'terms' => $product_cats,
					'field' => $field_name,
					'operator' => 'IN',
					'include_children' => false
				)
			);
		}
		$args['meta_query']	= $meta_query;
		$args['tax_query']	= $tax_query;

		$animation 	= catanis_shortcodeAnimation($atts);
		$elemID 	= catanis_random_string(10, 'cata_products');
		$elemClass 	= 'cata-products cata-element cata-products-'. $product_type;
		$elemClass .= ($main_style == 'slider') ? ' cata-slick-slider '. $slide_dots_style : ' cata-list cata-products-list';
		$elemClass .= ($with_padding == 'yes') ? ' cata-slider-spacing' . absint($padding_value) : '';
		$elemClass .= (!empty($animation['has-animation'])) ? ' ' . $animation['has-animation'] : '';
		$elemClass .= (!empty($ext_class) ) ? ' '. $ext_class : '';
	
		$arrParams = array();
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		if ($main_style == 'slider') {
			$columns = intval($items_desktop);
			$arrParams = array(
				'autoplay' 			=> ($slide_autoplay == 'yes') ? true : false,
				'autoplaySpeed' 	=> intval($slide_autoplay_speed),
				'slidesToShow' 		=> intval($items_desktop),
				'slidesToScroll' 	=> intval($slides_to_scroll),
				'dots' 				=> ($slide_dots == 'yes')? true : false,
				'arrows' 			=> ($slide_arrows == 'yes')? true : false,
				'infinite' 			=> ($slide_loop == 'yes')? true : false,
				'draggable' 		=> true,
				'speed' 			=> intval($slides_speed),
				'rtl' 				=> CATANIS_RTL,
				'adaptiveHeight' 	=> true,
				'responsive'		=> array(
					array(
						'breakpoint'	=> 1024,
						'settings'		=> array(
							'slidesToShow'		=> intval($items_desktop_small),
							'slidesToScroll' 	=> intval($items_desktop_small)
						)
					),
					array(
						'breakpoint'	=> 768,
						'settings'		=> array(
							'slidesToShow'		=> intval($items_tablet),
							'slidesToScroll' 	=>  intval($items_tablet)
						)
					),
					array(
						'breakpoint'	=> 520,
						'settings'		=> array(
							'slidesToShow'		=> 1,
							'slidesToScroll' 	=> 1
						)
					),
				)
			);
		
			if($items_desktop == 1 && $items_desktop_small == 1 && $items_tablet == 1){
				$arrParams['fade'] = true;
				$arrParams['cssEase'] = 'linear';
			}
		}

		ob_start();
		global $woocommerce_loop;
		if( (int)$columns <= 0 ){
			$columns = 3;
		}
		$old_woocommerce_loop_columns = $woocommerce_loop['columns'];
		$woocommerce_loop['columns'] = $columns;

		$products = new WP_Query( $args );

		$is_slider = true;
		if( isset($products->post_count) && ( $products->post_count <= 1 || $products->post_count <= $rows ) ){
			$is_slider = false;
		}

		if( $products->have_posts() ):
		?>
			<div<?php echo rtrim($dir); ?> id="<?php echo $elemID; ?>" class="<?php echo esc_attr($elemClass); ?>" <?php echo ($animation['animation-attrs']); ?>>
				<?php woocommerce_product_loop_start(); ?>	
					<div class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
						<?php 
						while( $products->have_posts() ): $products->the_post();
							wc_get_template_part( 'content', 'product' );
						endwhile; 
						?>			
					</div>
				<?php woocommerce_product_loop_end(); ?>
			</div>
		<?php
			else:
				esc_html_e('No item to display!', 'catanis-core');
			endif;
			
			wp_reset_postdata();			

			/* restore hooks */
			catanis_restore_product_hooks_shortcode();

			$woocommerce_loop['columns'] = $old_woocommerce_loop_columns;
			
			return '<div class="woocommerce columns-'.$columns.'">' . ob_get_clean() . '</div>';
	}	
}
add_shortcode('cata_products', 'catanis_products_shortcode_function');


if( !function_exists('catanis_products_widget_shortcode_function') ){
	function catanis_products_widget_shortcode_function($atts, $content){
		
		if( !class_exists('Catanis_Widget_Products') ){
			return;
		}
		
		$main_style = $title = $limit = $product_type = $product_cats = $show_thumbnail = $show_categories = '';
		$show_product_title = $show_price = $show_rating = $show_nav = $auto_play = $per_slide = '';
		$instance = shortcode_atts(array(
			'is_shortcode' 		=> 'yes',
			'main_style' 		=> 'list',
			'title' 			=> '',
			'limit'				=> 9,
			'product_type' 		=> 'recent',
			'product_cats' 		=> '',
			'show_thumbnail'	=> 1,
			'show_categories'	=> 0,
			'show_product_title' => 1,
			'show_price'		=> 1,
			'show_rating'		=> 1,
			'show_nav' 			=> 1,
			'auto_play' 		=> 1,
			'per_slide'			=> 3
		), $atts);

		$instance['is_slider'] = ($instance['main_style'] == 'slider') ? 1 : 0;
		if( trim($instance['product_cats']) != '' ){
			$instance['product_cats'] = str_replace(', ', '|', $instance['product_cats']);
		}

		ob_start();
		the_widget('Catanis_Widget_Products', $instance);
		return ob_get_clean();
	}
}
add_shortcode('cata_products_widget', 'catanis_products_widget_shortcode_function');


function catanis_remove_product_hooks_shortcode( $options = array() ){
	
	if( isset($options['show_categories']) && !catanis_check_option_bool($options['show_categories']) ){
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_categories', 10);
	}
	if( isset($options['show_title']) && !catanis_check_option_bool($options['show_title']) ){
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_title', 20);
	}
	if( isset($options['show_sku']) && !catanis_check_option_bool($options['show_sku']) ){
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_sku', 30);
	}
	if( isset($options['show_price']) && !catanis_check_option_bool($options['show_price']) ){
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 50);
	}
	if( isset($options['show_addtocart']) && !catanis_check_option_bool($options['show_addtocart']) ){
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_add_to_cart', 60);
	}
	if( isset($options['show_excerpt']) && !catanis_check_option_bool($options['show_excerpt']) ){
		remove_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_excerpt_grid', 80);
	}
	if( isset($options['show_rating']) && !catanis_check_option_bool($options['show_rating']) ){
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 90);
	}
	if( isset($options['show_label']) && !catanis_check_option_bool($options['show_label']) ){
		remove_action('woocommerce_after_shop_loop_item_title', 'catanis_template_loop_product_label', 1);
	}
}

function catanis_restore_product_hooks_shortcode(){

	add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_categories', 10);
	add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_title', 20);
	add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_sku', 30);
	
	add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_before_cartprice', 40);
	add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 50);
	add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_add_to_cart', 60);
	add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_after_cartprice', 70);
	
	add_action('woocommerce_after_shop_loop_item', 'catanis_template_loop_product_excerpt_grid', 80);
	add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 90);
	
	add_action('woocommerce_after_shop_loop_item_title', 'catanis_template_loop_product_label', 1);
}

