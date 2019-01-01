<?php
if ( ! class_exists( 'Catanis_Widget_Testimonial') ) {
	class Catanis_Widget_Testimonial extends WP_Widget {

		private $_ins_default = array();
		
		function __construct() {
			$id_base 	= 'catanis-widget-testimonial';
			$name		= esc_html__('CATANIS - Testimonials','onelove');
			$widget_options = array(
				'classname' 	=> 'cata-widget cata-widget-testimonials',
				'description' 	=> esc_html__('The widget display Testimonials', 'onelove')
			);
			$control_options = array( 'width' => '250px');
			parent::__construct( $id_base, $name, $widget_options, $control_options );
				
			$this->_ins_default = array(
				'title' 			=> esc_html__('Testimonial', 'onelove'),
				'limit' 			=> 4,
				'order_by' 			=> 'date',
				'order'  			=> 'desc',
				'show_author' 		=> 1,
				'show_avatar' 		=> 1,
				'show_occupation' 	=> 1,
				'show_rating_star' 	=> 1,
				'categories' 		=> '',
				'specific_ids' 		=> '',
				'is_slider' 		=> 1,
				'show_nav' 			=> 1,
				'auto_play' 		=> 1,
				'per_slide' 		=> 2
			);
		}

		function widget( $args, $instance ) {
			
			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
			$limit 				= !empty( $instance['limit'] ) ? absint( $instance['limit'] ) : $this->_ins_default['limit'];
			$order_by 			= !empty( $instance['order_by'] ) ? $instance['order_by'] : $this->_ins_default['order_by'];
			$order 				= !empty( $instance['order'] ) ? $instance['order'] : $this->_ins_default['order'];
			$show_author 		= ( $instance['show_author'] ) ? $instance['show_author'] : 0;
			$show_avatar 		= ( $instance['show_avatar'] ) ? $instance['show_avatar'] : 0;
			$show_occupation 	= ( $instance['show_occupation'] ) ? $instance['show_occupation'] : 0;
			$show_rating_star 	= ( $instance['show_rating_star'] ) ? $instance['show_rating_star'] : 0;
			$categories 		= !empty( $instance['categories'] ) ? trim($instance['categories']) : $this->_ins_default['categories'];
			$specific_ids 		= !empty( $instance['specific_ids'] ) ? trim( $instance['specific_ids'] ) : $this->_ins_default['specific_ids'];
			
			$is_slider 			= ($instance['is_slider']) ? $instance['is_slider'] : 0;
			$show_nav 			= ($instance['show_nav']) ? $instance['show_nav'] : 0;
			$auto_play 			= ($instance['auto_play']) ? $instance['auto_play'] : 0;
			$perSlide 			= !empty($instance['per_slide']) ? absint($instance['per_slide']) : $this->_ins_default['per_slide'];
			
			echo $before_widget;
			if ( $title !== "" ) {
				echo $before_title . $title . $after_title;
			}
			$args = array(
				'post_type'				=> 'testimonials',
				'post_status' 			=> 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' 		=> $limit,
				'orderby' 				=> $order_by,
				'order' 				=> $order			
			);
			
			if (strpos($categories, 'all') === false) {
				if ( isset( $categories ) && $categories != "" ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' 	=> 'testimonials_category',
							'terms' 	=> explode( '|', esc_attr( $categories ) ),
							'field' 	=> 'slug',
							'operator' 	=> 'IN'
						)
					);
				}
			}
			
			if ( strlen( trim( $specific_ids ) ) > 0 ) {
				$args['post__in'] = explode(',', str_replace(' ', '', $specific_ids ) );
			}
			
			$testimonials = new WP_Query( $args );
			if ( $testimonials->post_count <= 1 ) {
				$is_slider = 0;
			}
			
			if ( $testimonials->post_count > 0 ) {
				
				$i = 0;
				$elemClass = 'cata_widget_testimonial_wrapper';
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
						'adaptiveHeight' 	=> true,
						'fade'				=> true,
						'rtl' 				=> CATANIS_RTL,
						'speed' 			=> 500
					);
				}
			?>
				<div<?php echo rtrim($dir); ?> id="cata_testimonial_<?php echo mt_rand(); ?>" class="<?php echo esc_attr($elemClass); ?>">
					<?php if ( $testimonials->have_posts() ) :?>
					<div class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
						<?php while ( $testimonials->have_posts() ) : 
							$testimonials->the_post();
						
							$post_id = get_the_ID();
							$postMeta = get_post_meta( $post_id, Catanis_Meta::$meta_key, true );
							$organization_url = esc_url( $postMeta['organization_url'] );
							$target_link = ( $postMeta['target_link'] == 'true' ) ? '_blank' : '_self';
							$title = ( ! empty( $postMeta['author'] ) ) ? $postMeta['author'] : get_the_title( $post_id ) ;
						?>
						<?php if ( ($i == 0 || $i % $perSlide == 0) && $is_slider) { ?>
						<div class="cata-slick-per-slide">
						<?php } ?>
						
							<div class="cata-item">
								<div class="cata-testimonial-content"><?php echo esc_html($postMeta['testimonial']); ?></div>
								<div class="cata-info">
									<?php if( $show_avatar ): ?>
									<div class="cata-avatar">
										<a href="<?php echo esc_url($organization_url); ?>" target="<?php echo esc_attr($target_link); ?>">
											<img src="<?php echo esc_url( trim($postMeta['thumbnail']) ); ?>" alt="">
										</a>
									</div>
									<?php endif; ?>
									
									<?php if( $show_author || $show_occupation ) : ?>
									<p class="cata-title-occupation">
										<a href="<?php echo esc_url($organization_url); ?>" title="<?php echo esc_attr($title); ?>" target="<?php echo esc_attr($target_link); ?>"><?php echo esc_html($title); ?></a>
										
										<?php if ( $show_occupation ) : ?>
										<span> - <?php echo esc_html( $postMeta['occupation']); ?></span>					
										<?php endif; ?>
									</p>
									<?php endif; ?>
									
									<?php if( $show_rating_star ): ?>
									<div class="cata-rating-star">
										<?php echo str_repeat('<i class="fa fa-star"></i>', absint($postMeta['rating_star']));?>
									</div>
									<?php endif; ?>
									
								</div>
							</div>
						<?php $i++; if ( ($i % $perSlide == 0 || $i == $limit) && $is_slider ) { ?>
						</div>
						<?php } ?>
						<?php endwhile;?>
					</div>
					<?php endif; ?>
				</div>
				<div class="clear"></div>
				
				<?php 				
			}else{
				esc_html_e('No items to display!', 'onelove');
			}
			echo $after_widget;
			wp_reset_postdata();
		}

		function update( $new_instance, $old_instance ) {

			$instance = $old_instance;	
			$categories = esc_sql($new_instance['categories']);
			$categories = implode('|', $categories);
			
			$instance['title'] 			= strip_tags($new_instance['title']);					
			$instance['limit'] 			= $new_instance['limit'];
			$instance['order_by'] 		= $new_instance['order_by'];									
			$instance['order'] 			= $new_instance['order'];									
			$instance['show_author'] 	= $new_instance['show_author'];									
			$instance['show_avatar'] 	= $new_instance['show_avatar'];																	
			$instance['show_occupation'] 	= $new_instance['show_occupation'];																	
			$instance['show_rating_star'] 	= $new_instance['show_rating_star'];																	
			$instance['categories'] 	= $categories;						
			$instance['specific_ids'] 	= $new_instance['specific_ids'];									
			$instance['is_slider'] 		= $new_instance['is_slider'];									
			$instance['show_nav'] 		= $new_instance['show_nav'];									
			$instance['auto_play'] 		= $new_instance['auto_play'];		
			$instance['per_slide'] 		= $new_instance['per_slide'];
			
			return $instance;
		}

		function form( $instance ) {
			$instance 	= wp_parse_args( (array) $instance, $this->_ins_default );
			$htmlObj 	= new Catanis_Widget_Html();
			$xhtml 		= '';

			/* Terms Category */
			$terms 		= get_terms( array('taxonomy' => 'testimonials_category', 'hide_empty' => true, 'hierarchical' => false)  );
			$terms_arr 	= array();
			if ( $terms && !is_wp_error($terms) ) {
				$terms_arr['all'] =  esc_html__('All Category', 'onelove');
				foreach( $terms as $term ) {
					$terms_arr[$term->slug] = $term->name;
				}
			}
			
			/* Element Title*/
			$inputID 	= $this->get_field_id( 'title' );
			$inputName 	= $this->get_field_name( 'title' );
			$inputValue = esc_attr( $instance['title'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Title', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
			);
			
			/* Element Limit*/
			$inputID 	= $this->get_field_id( 'limit' );
			$inputName 	= $this->get_field_name( 'limit' );
			$inputValue = absint( $instance['limit'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Limit', 'onelove'), array('for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array(' type' => 'number', 'min' => '1' ) )
			);

			/* Element Order by*/
			$inputID 	= $this->get_field_id( 'order_by' );
			$inputName 	= $this->get_field_name( 'order_by' );
			$inputValue = esc_attr( $instance['order_by'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts 		= array( 'data' => array(
				'none' 	=> esc_html__('No order', 'onelove'),
				'date' 	=> esc_html__('Date', 'onelove'),
				'title' => esc_html__('Title', 'onelove'),
				'rand' 	=> esc_html__('Random', 'onelove')
			) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Order by', 'onelove' ), array('for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);

			/* Element Order*/
			$inputID 	= $this->get_field_id( 'order' );
			$inputName 	= $this->get_field_name( 'order' );
			$inputValue = esc_attr( $instance['order'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts 		= array( 'data' => array(
				'desc' 	=> esc_html__('Descending', 'onelove'),
				'asc' 	=> esc_html__('Ascending', 'onelove')
			) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Order', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);

			/* Element show avatar*/
			$inputID 	= $this->get_field_id( 'show_avatar' );
			$inputName 	= $this->get_field_name( 'show_avatar' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => $instance['show_avatar'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show avatar', 'onelove'), array( 'for' => $inputID ), true )
			);

			/* Element show_author*/
			$inputID 	= $this->get_field_id( 'show_author' );
			$inputName 	= $this->get_field_name( 'show_author' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => $instance['show_author'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Show author','onelove'), array('for' => $inputID ), true )
			);
				
			/* Element show_occupation*/
			$inputID 	= $this->get_field_id( 'show_occupation' );
			$inputName 	= $this->get_field_name( 'show_occupation' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => $instance['show_occupation'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show occupation','onelove' ), array('for' => $inputID ), true )
			);

			/* Element rating_star*/
			$inputID 	= $this->get_field_id( 'show_rating_star' );
			$inputName 	= $this->get_field_name( 'show_rating_star' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => $instance['show_rating_star'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show rating star','onelove' ), array('for' => $inputID ), true )
			);


			/* Element categories*/
			$inputID 	= $this->get_field_id( 'categories' );
			$inputName 	= $this->get_field_name( 'categories' ) .'[]';
			$inputValue = str_replace(',', '|', $instance['categories']);
			$arr 		= array('class' => 'widefat', 'id' => $inputID, 'multiple' => 'multiple');
			$opts 		= array('data' => $terms_arr);
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Categories', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);

			/* Element specific_ids*/
			$inputID 	= $this->get_field_id( 'specific_ids' );
			$inputName 	= $this->get_field_name( 'specific_ids' );
			$inputValue = esc_attr( $instance['specific_ids'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Specific IDs','onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
					. '<span>' . esc_html__('Display a list specific testimonial. Add commas between IDs', 'onelove') . '</span>'
			);

			$xhtml .= $htmlObj->infoText( esc_html__('Slider mode Options', 'onelove' ) );
			
			/* Element is_slider*/
			$inputID 	= $this->get_field_id( 'is_slider' );
			$inputName 	= $this->get_field_name( 'is_slider' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => $instance['is_slider'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Slider mode', 'onelove'), array( 'for' => $inputID ), true)
			);
				
			/* Element show_nav*/
			$inputID 	= $this->get_field_id( 'show_nav' );
			$inputName 	= $this->get_field_name( 'show_nav' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => $instance['show_nav'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr,$opts)
					.$htmlObj->labelTag( esc_html__('Show navigation', 'onelove'), array( 'for' => $inputID ), true )
			);
			
			/* Element auto_play*/
			$inputID 	= $this->get_field_id( 'auto_play' );
			$inputName 	= $this->get_field_name( 'auto_play' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => $instance['auto_play'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Auto play', 'onelove'), array( 'for' => $inputID ), true)
			);

			/* Element per_slide*/
			$inputID 	= $this->get_field_id( 'per_slide' );
			$inputName 	= $this->get_field_name( 'per_slide' );
			$inputValue = absint( $instance['per_slide'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID);
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('A number of items per slide', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number', 'min' => '1' ) )
			);
			
			echo trim($xhtml);
		}
	}
}
?>