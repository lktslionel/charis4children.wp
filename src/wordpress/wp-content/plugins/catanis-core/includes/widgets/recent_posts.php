<?php
if (  !class_exists('Catanis_Widget_Recent_Posts') ) {
	class Catanis_Widget_Recent_Posts extends WP_Widget {

		private $_ins_default = array();
		
		function __construct() {
			$id_base 	= 'catanis-widget-recent-posts';
			$name		= esc_html__('CATANIS - Recent Posts','onelove');
			$widget_options = array(
				'classname' 	=> 'cata-widget cata-widget-recent-posts',
				'description' 	=> esc_html__('The widget display recent posts', 'onelove')
			);
			$control_options = array('width' => '250px');
			parent::__construct( $id_base, $name, $widget_options, $control_options );
			
			$this->_ins_default = array(
				'title' 				=> esc_html__( 'Recent Posts', 'onelove'),
				'limit'					=> 4,
				'categories'			=> '',
				'limit_excerpt_word'	=> 10,
				'thumb_size' 			=> '',
				'show_title' 			=> 1,
				'show_excerpt' 			=> 0,
				'show_date' 			=> 1,
				'show_author' 			=> 0,
				'show_comment'			=> 0,
				'is_slider' 			=> 1,
				'show_nav' 				=> 1,
				'auto_play' 			=> 1,
				'per_slide'				=> 2
			);
		}

		function widget( $args, $instance ) {
		
			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
			$limit 				= !empty($instance['limit']) ? absint($instance['limit']) : $this->_ins_default['limit'];
			$categories 		= !empty($instance['categories']) ? $instance['categories'] : $this->_ins_default['categories'];
			$perSlide 			= !empty($instance['per_slide']) ? absint($instance['per_slide']) : $this->_ins_default['per_slide'];
			$limit_excerpt_word = !empty($instance['limit_excerpt_word']) ? absint($instance['limit_excerpt_word']) : $this->_ins_default['limit_excerpt_word'];		
			$thumb_size 		= !empty($instance['thumb_size']) ? esc_attr($instance['thumb_size']) : $this->_ins_default['thumb_size'];		
			$show_excerpt 		= ($instance['show_excerpt']) ? $instance['show_excerpt'] : 0;
			$show_date 			= ($instance['show_date']) ? $instance['show_date'] : 0;
			$show_author 		= ($instance['show_author']) ? $instance['show_author'] : 0;
			$show_comment 		= ($instance['show_comment']) ? $instance['show_comment'] : 0;
			
			$is_slider 			= ($instance['is_slider']) ? $instance['is_slider'] : 0;			
			$show_nav 			= ($instance['show_nav']) ? $instance['show_nav'] : 0;	
			$auto_play 			= ($instance['auto_play']) ? $instance['auto_play'] : 0;

			echo $before_widget;
			if ( $title !== "" ) {
				echo $before_title . $title . $after_title;
			}
			
			$args = array(
				'post_type'				=> 'post',
				'ignore_sticky_posts'	=> 1,
				'post_status'			=> 'publish',
				'posts_per_page'		=> $limit,
				'order_by' 				=> 'date',
				'order'  				=> 'desc'
			);
			
			if (strpos($categories, 'all') === false) {
				if ( isset( $categories ) && $categories != "" ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' 	=> 'category',
							'terms' 	=> explode( '|', esc_attr( $categories ) ),
							'field' 	=> 'slug',
							'operator' 	=> 'IN'
						)
					);
				}
			}
				
			global $post;
			$posts = new WP_Query($args);
			
			if( $posts->have_posts() ){
				$post_count = $posts->post_count;
				if( $post_count < 2 || $post_count <= $perSlide ){
					$is_slider = 0;
				}
				
				$i = 0; 
				$elemClass = 'cata-widget-recent-posts-wrapper';
				$elemClass .= ' cata-wrapper cata-thumb-'. $thumb_size;
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
						'rtl' 				=> CATANIS_RTL,
						'speed' 			=> 500
					);
				}
				?>
				<div<?php echo rtrim($dir); ?> id="cata_recent_posts_<?php echo mt_rand(); ?>" class="<?php echo esc_attr($elemClass); ?>">
					<div class="slides cata-thumb-<?php echo esc_attr($thumb_size); ?>" data-slick='<?php echo json_encode($arrParams); ?>'>
						<?php while ( $posts->have_posts() ) : 
								$posts->the_post();  
							
								$liClass = 'cata-item';
								$liClass .= ($i == 0 || ($i % $perSlide == 0 && $is_slider == 1)) ? ' first' : '';
							
								$thumb_default = CATANIS_FRONT_IMAGES_URL .'default/smallthumb.png';
								if( !in_array($thumb_size, array('none', 'small') )){
									$thumb_default = CATANIS_FRONT_IMAGES_URL .'default/largethumb.png';
								}
							
								$liBg = '';
								if($thumb_size == 'large-special' && $i != 0 && strpos($liClass, 'first') === false ){
									$featureImg 	= catanis_get_featured_image_url($post);
									$liBg 	= ' style="background-image: url('. $featureImg .'); "';
								}
						?>
							<?php if ( ($i == 0 || $i % $perSlide == 0) && $is_slider == 1 ) { ?>
							<div class="cata-slick-per-slide">
							<?php } ?>
									<div class="<?php echo esc_attr($liClass) ; ?>"<?php echo ($liBg); ?>>
									
										<?php if ( ($thumb_size != 'none' && $thumb_size != 'large-special') || ($thumb_size == 'large-special' && strpos($liClass, 'first') !== false )) : ?>
										<div class="cata-post-thumbnail">
											<a class="cata-effect-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
												<?php if( has_post_thumbnail() ) : 
													the_post_thumbnail( 'medium', array( 'alt' => esc_html(get_the_title()) ) ) ; ?>		
												<?php else: ?>							
													<img src="<?php echo esc_url($thumb_default); ?>" alt="<?php the_title(); ?>" class="wp-post-image" />					
												<?php endif; ?>
											</a>
										</div>
										<?php endif; ?>
									
										<div class="cata-post-meta">
											<?php if ( isset( $thumb_size ) && $thumb_size == 'none' ) : ?>
											<span class="cata-num"><?php echo ($i >= 10)? ($i+1) : '0' . ($i+1); ?></span>
											<?php endif; ?>
											
											<div class="cata-post-meta-inner">
												<div class="cata-entry-title">
													<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'onelove' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
														<?php echo get_the_title(); ?>
													</a>
												</div>
												
												<div class="cata-info-detail">
													<?php if ( isset( $show_comment) && $show_comment ): ?>
													<span class="comments-count"> 
														<?php 
															$comments_count = wp_count_comments( $post->ID ); 
															if ( $comments_count->approved < 10 && $comments_count->approved > 0 ) {
																echo '0'; 
															}
															echo absint($comments_count->approved); 
														?>
													</span>
													<?php endif; ?>
										
													<?php if ( isset( $show_author ) && $show_author ) : ?>
													<span class="author"> <?php the_author_posts_link(); ?> </span>
													<?php endif;  ?>
													
													<?php if ( isset($show_date) && $show_date ) : ?>
													<span class="date-time"><?php echo get_the_date( get_option( 'date_format' )); ?></span>
													<?php endif; ?>
												</div>
												
												<?php if ( isset( $show_excerpt ) && $show_excerpt ) : ?>
												<div class="cata-entry-desc"> 
													<?php echo catanis_string_limit_words( apply_filters( 'get_the_excerpt', $post->post_excerpt ), $limit_excerpt_word );?>
												</div>
												<?php endif; ?>
											</div>
										</div>
										<div class="clear"></div>
									</div>
								<?php $i++; if ( ($i % $perSlide == 0 || $i == $limit ) && $is_slider == 1 ) { ?>
							</div>
							<?php } ?>
						<?php endwhile;?>
					</div>	
				</div>
				<div class="clear"></div>
			<?php
			}else{
				esc_html_e( 'No items to display!', 'onelove' );
			}
			echo $after_widget;
			wp_reset_postdata();			
		}

		function update( $new_instance, $old_instance ) {
			
			$instance = $old_instance;
			$categories = esc_sql($new_instance['categories']); 	
			$categories = implode('|', $categories); 	
					
			$instance['title'] 					= strip_tags($new_instance['title']);
			$instance['limit'] 					= $new_instance['limit'];
			$instance['per_slide'] 				= $new_instance['per_slide'];		
			$instance['categories'] 			= $categories;
			$instance['limit_excerpt_word'] 	= $new_instance['limit_excerpt_word'];
			$instance['thumb_size'] 			= $new_instance['thumb_size'];
			$instance['show_excerpt'] 			= $new_instance['show_excerpt'];
			$instance['show_date'] 				= $new_instance['show_date'];
			$instance['show_author'] 			= $new_instance['show_author'];
			$instance['show_comment'] 			= $new_instance['show_comment'];
			$instance['is_slider'] 				= $new_instance['is_slider'];
			$instance['show_nav'] 				= $new_instance['show_nav'];
			$instance['auto_play'] 				= $new_instance['auto_play'];
			
			$instance['limit'] 					= ($instance['per_slide'] > $instance['limit']) ? ($instance['per_slide'] + 1) : $instance['limit'];
			
			return $instance;
		}

		function form( $instance ) { 
			
			$instance 	= wp_parse_args( (array) $instance, $this->_ins_default );
			$htmlObj 	=  new Catanis_Widget_Html();
			$xhtml 		= '';
			
			/* Terms Category */
			$terms 		= get_terms( array('taxonomy' => 'category', 'hide_empty' => true, 'hierarchical' => false)  );
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
			$arr 		= array('class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Title', 'onelove'), array('for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);

			/* Element limit*/
			$inputID 	= $this->get_field_id( 'limit' );
			$inputName 	= $this->get_field_name( 'limit' );
			$inputValue = absint( $instance['limit'] );
			$arr 		= array('class' =>'widefat','id' => $inputID);
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag(esc_html__('Limit posts','onelove'), array('for'=>$inputID ))
					.$htmlObj->control('textbox',$inputName,$inputValue,$arr, array('type'=>'number', 'min'=>'1'))
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
			
			/*Element limit_excerpt_word*/
			$inputID 	= $this->get_field_id('limit_excerpt_word');
			$inputName 	= $this->get_field_name('limit_excerpt_word');
			$inputValue = esc_attr($instance['limit_excerpt_word']);
			$arr 		= array('class' =>'widefat hide','id' => $inputID);
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag('Limit excerpt word', array('for'=>$inputID, 'class' => 'hide'))
					.$htmlObj->control('textbox',$inputName,$inputValue,$arr, array('type'=>'number', 'min'=>'10'))
			); 
			
			/* Element show_date*/
			$inputID 	= $this->get_field_id( 'show_date' );
			$inputName 	= $this->get_field_name( 'show_date' );
			$inputValue = 1;
			$arr 		= array( 'class' =>'widefat', 'id' => $inputID);
			$opts		= array( 'current_value' => absint(@$instance['show_date']));
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( esc_html__('checkbox', 'onelove'), $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( 'Show date', array( 'for' => $inputID ), true)
			);
			
			/* Element thumb_size*/
			$inputID 	= $this->get_field_id( 'thumb_size' );
			$inputName 	= $this->get_field_name( 'thumb_size' );
			$inputValue = esc_attr( $instance['thumb_size'] );
			$arr 		= array('class' => 'widefat', 'id' => $inputID, 'style' => ' width:140px; margin-left:10px;' );
			$opts 		= array('data' => array(
				'none' => esc_html__('No thumbnail', 'onelove' ), 
				'small' => esc_html__('Small', 'onelove' ), 
				'large' => esc_html__('Large', 'onelove'), 
				/* 'large-style2' => esc_html__('Large Style 2', 'onelove'),
				'large-style3' => esc_html__('Large Style 3', 'onelove'),
				'large-special' => esc_html__('Large Special', 'onelove') */
			));
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Thumbnail size', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);			
		
			/* Element show_excerpt*/
			$inputID 	= $this->get_field_id( 'show_excerpt' );
			$inputName 	= $this->get_field_name( 'show_excerpt' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat hide', 'id' => $inputID );
			$opts		= array( 'current_value' => absint( @$instance['show_excerpt'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue,$arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show excerpt', 'onelove'), array('for' => $inputID, 'class' => 'hide' ), true)
			);
			
			/* Element show_author*/
			$inputID 	= $this->get_field_id( 'show_author' );
			$inputName 	= $this->get_field_name( 'show_author' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat hide', 'id' => $inputID );
			$opts		= array( 'current_value' => absint( @$instance['show_author'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Show author', 'onelove'), array( 'for' => $inputID, 'class' => 'hide' ), true)
			);
			
			/* Element show_comment*/
			$inputID 	= $this->get_field_id( 'show_comment' );
			$inputName 	= $this->get_field_name( 'show_comment' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID);
			$opts		= array( 'current_value' => absint( @$instance['show_comment'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Show comment', 'onelove' ), array( 'for' => $inputID, 'class' => '' ), true)
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
					.$htmlObj->labelTag( esc_html__('Auto play', 'onelove'), array( 'for' => $inputID ), true)
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