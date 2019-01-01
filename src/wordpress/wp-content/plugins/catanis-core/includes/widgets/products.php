<?php
if ( ! class_exists( 'Catanis_Widget_Products' ) ) {
	class Catanis_Widget_Products extends WP_Widget {
		private $_ins_default = array();
		
		function __construct() {
		
			$id_base 	= 'catanis-widget-products';
			$name		= esc_html__( 'CATANIS - Products', 'onelove' );
			$widget_options = array(
				'classname' 	=> 'cata-widget woocommerce cata-products-widget',
				'description' 	=> esc_html__( 'Display the products widget.', 'onelove' )
			);
			$control_options = array( 'width' => '250px' );
			parent::__construct( $id_base, $name, $widget_options, $control_options );
				
			$this->_ins_default = array(
				'title' 			=> '',
				'limit'				=> 9,
				'product_type' 		=> 'recent',
				'product_cats' 		=> '',
				'show_thumbnail'	=> 1,
				'show_categories'	=> 0,
				'show_product_title' => 1,
				'show_price'		=> 1,
				'show_rating'		=> 1,
				'is_slider' 		=> 1,
				'show_nav' 			=> 1,
				'auto_play' 		=> 1,
				'per_slide'			=> 3					
			);	
			
		}
		
		public function widget($args, $instance) {

			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
		
			$is_shortcode 		= (isset($instance['is_shortcode'])) ? true : false;
			$limit 				= !empty($instance['limit']) ? absint($instance['limit']) : $this->_ins_default['limit'];
			$product_type 		= !empty($instance['product_type']) ? $instance['product_type'] : $this->_ins_default['product_type'];
			$product_cats 		= !empty($instance['product_cats']) ? $instance['product_cats'] : $this->_ins_default['product_cats'];
			$perSlide 			= !empty($instance['per_slide']) ? absint($instance['per_slide']) : $this->_ins_default['per_slide'];
			
			$show_thumbnail 	= ($instance['show_thumbnail']) ? $instance['show_thumbnail'] : 0;
			$show_categories 	= ($instance['show_categories']) ? $instance['show_categories'] : 0;
			$show_product_title = ($instance['show_product_title']) ? $instance['show_product_title'] : 0;
			$show_price 		= ($instance['show_price']) ? $instance['show_price'] : 0;
			$show_rating 		= ($instance['show_rating']) ? $instance['show_rating'] : 0;
			
			$is_slider 			= ($instance['is_slider']) ? $instance['is_slider'] : 0;
			$show_nav 			= ($instance['show_nav']) ? $instance['show_nav'] : 0;
			$auto_play 			= ($instance['auto_play']) ? $instance['auto_play'] : 0;
			
			echo $before_widget;
			if ($title) {
				echo $before_title . $title . $after_title;
			}
			
			$meta_query  = WC()->query->get_meta_query();
			$tax_query   = WC()->query->get_tax_query();
			$args = array(
				'post_type'           	=> 'product',
				'post_status'         	=> 'publish',
				'ignore_sticky_posts' 	=> 1,
				'posts_per_page' 		=> $limit,
				'orderby' 				=> 'date',
				'order' 				=> 'desc'
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
				$args['tax_query'] = array(
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
			
			global $post;
			$products = new WP_Query($args);
			if( $products->have_posts() ){
				$post_count = $products->post_count;
				if( $post_count < 2 || $post_count <= $perSlide ){
					$is_slider = 0;
				}
			
				$i = 0;
				$elemClass = 'cata-widget-recent-posts-wrapper';
				$elemClass = 'cata-wrapper cata-products-'. $product_type;
				$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
				$arrParams = array();
				if ( $is_slider ) {
					$elemClass .= ' cata-slick-slider dots-line';
					$arrParams = array(
						'autoplay' 			=> ($auto_play) ? true : false,
						'autoplaySpeed' 	=> 3000,
						'slidesToShow' 		=> 1,
						'slidesToScroll' 	=> 1,
						'dots' 				=> ($show_nav)? true : false,
						'arrows' 			=> false,
						'infinite' 			=> true,
						'draggable' 		=> true,
						'rtl' 				=> CATANIS_RTL,
						'adaptiveHeight' 	=> true,
						'speed' 			=> 700
					);
				}
			?>
			
				<div<?php echo rtrim($dir); ?> id="cata_products_<?php echo mt_rand(); ?>" class="<?php echo esc_attr($elemClass); ?>">
					<div class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
						<?php if ( $is_slider == 0 ): ?><ul class="product_list_widget"><?php endif; ?>
							
						<?php while( $products->have_posts() ): $products->the_post(); $product = wc_get_product( $post->ID ); ?>
					
							<?php if ( ($i == 0 || $i % $perSlide == 0) && $is_slider == 1 ) { ?>
								<ul class="cata-slick-per-slide product_list_widget">
							<?php } ?>
							
								<li class="cata-item<?php if( !$show_thumbnail ){ echo ' no-thumb'; } ?>">
									<?php if ( $show_thumbnail ): ?>
										<a class="cata-thumbnail" href="<?php echo esc_url( get_permalink($product->get_id()) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
											<?php echo ($product->get_image()); ?>
										</a>
									<?php endif; ?>
								
								<div class="cata-meta">
								
									<?php if( $show_categories ){ 
										catanis_template_loop_product_categories();
									} ?>
									
									<a href="<?php echo esc_url( get_permalink($product->get_id()) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
										<?php  
											if( $show_product_title ){
												echo esc_html( $product->get_title() );
											}
										?>
									</a>
									<?php if( $show_price ){ echo woocommerce_template_loop_price(); } ?>
									<?php if( $show_rating ){ echo woocommerce_template_loop_rating(); } ?>
								</div>
								
								</li>
							
							<?php $i++; if ( ($i % $perSlide == 0 || $i == $limit ) && $is_slider == 1 ) { ?>
								</ul>
							<?php } ?>
						
						<?php endwhile; ?>
						<?php if ( $is_slider == 0 ): ?></ul><?php endif; ?>
					</div>
				</div>
				
			<?php
			}else{
				esc_html_e( 'No items to display!', 'onelove' );
			}
			echo $after_widget;
			
			if( $product_type == 'top_rated' ){
				remove_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses') );
			}
			
			wp_reset_postdata();
		}
			
		public function update($new_instance, $old_instance) {
		
			$instance = $old_instance;
			$categories = esc_sql($new_instance['product_cats']);
			$categories = implode('|', $categories);
			
			$instance['title'] 					= strip_tags($new_instance['title']);
			$instance['limit'] 					= $new_instance['limit'];
			$instance['product_type'] 			= $new_instance['product_type'];
			$instance['product_cats'] 			= $categories;
			$instance['show_thumbnail'] 		= $new_instance['show_thumbnail'];
			$instance['show_categories'] 		= $new_instance['show_categories'];
			$instance['show_product_title'] 	= $new_instance['show_product_title'];
			$instance['show_price'] 			= $new_instance['show_price'];
			$instance['show_rating'] 			= $new_instance['show_rating'];
			$instance['is_slider'] 				= $new_instance['is_slider'];
			$instance['show_nav'] 				= $new_instance['show_nav'];
			$instance['auto_play'] 				= $new_instance['auto_play'];
			$instance['per_slide'] 				= $new_instance['per_slide'];
			
			$instance['limit'] 					= ($instance['per_slide'] > $instance['limit']) ? ($instance['per_slide'] + 1) : $instance['limit'];
			
			return $instance;
		}
		
		function form( $instance ) {
				
			$instance 	= wp_parse_args( (array) $instance, $this->_ins_default );
			$htmlObj 	=  new Catanis_Widget_Html();
			$xhtml 		= '';
			
			/* Terms Category */
			$terms 		= get_terms( array('taxonomy' => 'product_cat', 'hide_empty' => true, 'hierarchical' => false)  );
			$terms_arr 	= array();
			if ( $terms && !is_wp_error($terms) ) {
				$terms_arr['all'] =  esc_html__('All Category', 'onelove');
				foreach( $terms as $term ) {
					$terms_arr[$term->slug] = $term->name;
				}
			}
			
			/* Element title*/
			$inputID 	= $this->get_field_id( 'title' );
			$inputName 	= $this->get_field_name( 'title' );
			$inputValue = esc_attr( $instance['title'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Title', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);

			/* Element limit*/
			$inputID 	= $this->get_field_id( 'limit' );
			$inputName 	= $this->get_field_name( 'limit' );
			$inputValue = absint( $instance['limit'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Enter the number limit of latest tweets','onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
			);
			
			/* Element product_type*/
			$inputID 	= $this->get_field_id( 'product_type' );
			$inputName 	= $this->get_field_name( 'product_type' );
			$inputValue = esc_attr( $instance['product_type'] );
			$arr = array( 'class' => 'widefat', 'id' => $inputID );
			$opts = array( 'data' => array( 
					'recent' 		=> 'Recent', 
					'sale' 			=> 'Sale', 
					'featured' 		=> 'Featured', 
					'best_selling' 	=> 'Best Selling', 
					'top_rated' 	=> 'Top Rated', 
					'mixed_order' 	=> 'Mixed Order') );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Product type', 'onelove'), array( 'for'=>$inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts )
			);
			
			/* Element product_cats*/
			$inputID 	= $this->get_field_id( 'product_cats' );
			$inputName 	= $this->get_field_name( 'product_cats' ) .'[]';
			$inputValue = str_replace(',', '|', $instance['product_cats']);
			$arr 		= array('class' => 'widefat', 'id' => $inputID, 'multiple' => 'multiple');
			$opts 		= array('data' => $terms_arr);
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Categories', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);
				
			/* Element show_thumbnail*/
			$inputID 	= $this->get_field_id( 'show_thumbnail' );
			$inputName 	= $this->get_field_name( 'show_thumbnail' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID);
			$opts		= array( 'current_value' => absint( @$instance['show_thumbnail'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Show thumbnail', 'onelove'), array( 'for' => $inputID ), true )
			);
			
			/* Element show_categories*/
			$inputID 	= $this->get_field_id( 'show_categories' );
			$inputName 	= $this->get_field_name( 'show_categories' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID);
			$opts		= array( 'current_value' => absint( @$instance['show_categories'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Show categories', 'onelove'), array( 'for' => $inputID ), true )
			);
			
			/* Element show_product_title*/
			$inputID 	= $this->get_field_id( 'show_product_title' );
			$inputName 	= $this->get_field_name( 'show_product_title' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID);
			$opts		= array( 'current_value' => absint( @$instance['show_product_title'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Show product title', 'onelove'), array( 'for' => $inputID ), true )
			);
			
			/* Element show_price*/
			$inputID 	= $this->get_field_id( 'show_price' );
			$inputName 	= $this->get_field_name( 'show_price' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID);
			$opts		= array( 'current_value' => absint( @$instance['show_price'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Show price', 'onelove'), array( 'for' => $inputID ), true )
			);
			
			/* Element show_price*/
			$inputID 	= $this->get_field_id( 'show_rating' );
			$inputName 	= $this->get_field_name( 'show_rating' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID);
			$opts		= array( 'current_value' => absint( @$instance['show_rating'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Show rating', 'onelove'), array( 'for' => $inputID ), true )
			);

			$xhtml .= $htmlObj->infoText( esc_html__('Slider mode Options', 'onelove' ) );
				
			/* Element is_slider*/
			$inputID 	= $this->get_field_id( 'is_slider' );
			$inputName 	= $this->get_field_name( 'is_slider' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID);
			$opts		= array( 'current_value' => absint( @$instance['is_slider'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Slider mode', 'onelove'), array( 'for' => $inputID ), true )
			);
			
			/* Element show_nav*/
			$inputID 	= $this->get_field_id( 'show_nav' );
			$inputName 	= $this->get_field_name( 'show_nav' );
			$inputValue = 1;
			$arr 		= array('class' => 'widefat', 'id' => $inputID);
			$opts		= array('current_value' => absint( @$instance['show_nav'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show navigation button', 'onelove'), array( 'for' => $inputID ), true)
			);
				
			/* Element auto_play*/
			$inputID 	= $this->get_field_id( 'auto_play' );
			$inputName 	= $this->get_field_name( 'auto_play' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID);
			$opts		= array( 'current_value' => absint( @$instance['auto_play'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Autoplay for slider', 'onelove'), array( 'for' => $inputID ), true)
			);
			
			/* Element per_slide*/
			$inputID 	= $this->get_field_id( 'per_slide' );
			$inputName 	= $this->get_field_name( 'per_slide' );
			$inputValue = absint( $instance['per_slide'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('A number of items per slide', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number', 'min' => '1' ) )
			);

			echo trim($xhtml);
		}
		
	}
}
?>