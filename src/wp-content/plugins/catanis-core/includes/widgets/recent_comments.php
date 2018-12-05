<?php
if ( ! class_exists('Catanis_Widget_Recent_Comments') ){
	class Catanis_Widget_Recent_Comments extends WP_Widget {

		private $_ins_default = array();
		
		function __construct() {
			$id_base 	= 'catanis-widget-recent-comments';
			$name		= esc_html__('CATANIS - Recent Comments','onelove');
			$widget_options = array(
				'classname' 	=> 'cata-widget cata-widget-recent-comments',
				'description' 	=> esc_html__('The widget display recent comments', 'onelove')
			);
			$control_options = array( 'width' => '250px' );
			parent::__construct( $id_base, $name, $widget_options, $control_options);
		
			$this->_ins_default = array(
				'title' 		=> esc_html__('Recent Comments','onelove'),
				'limit' 		=> 4,
				'post_type' 	=> 'all',
				'show_avatar' 	=> 1,
				'show_author' 	=> 1,
				'show_date' 	=> 1,
				'is_slider' 	=> 1,
				'show_nav' 		=> 1,
				'auto_play' 	=> 1,
				'per_slide' 	=> 2
			);				
		}
		
		function widget( $args, $instance ) {
			
			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
			$limit 			= !empty($instance['limit']) ? absint($instance['limit']) : $this->_ins_default['limit'];
			$post_type 		= !empty($instance['post_type']) ? trim($instance['post_type']) : $this->_ins_default['post_type'];
			$show_avatar 	= ($instance['show_avatar']) ? $instance['show_avatar'] : 0;
			$show_author 	= ($instance['show_author']) ? $instance['show_author'] : 0;
			$show_date 		= ($instance['show_date']) ? $instance['show_date'] : 0;
			$is_slider 		= ($instance['is_slider']) ? $instance['is_slider'] : 0;
			$show_nav 		= ($instance['show_nav']) ? $instance['show_nav'] : 0;
			$auto_play 		= ($instance['auto_play']) ? $instance['auto_play'] : 0;
			$perSlide 		= !empty($instance['per_slide']) ? absint($instance['per_slide']) : $this->_ins_default['per_slide'];
			
			$args = array( 'number' => $limit, 'status' => 'approve', 'post_status' => 'publish', 'comment_type' => '');
			if( $post_type != 'all') {
				$args['post_type'] = $post_type;
			}
			
			echo $before_widget;
			if( !empty($title) ) {
				echo $before_title . $title . $after_title;
			}
			
			$comments = (array)get_comments( $args );
			if ( $comments ) {
				$post_count = count($comments);
				if( $post_count < 2 || $post_count <= $perSlide ){
					$is_slider = 0;
				}
				
				$i = 0;
				$elemClass = 'cata_widget_recent_comments_wrapper';
				
				$arrParams = array();
				$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
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
				<div<?php echo rtrim($dir); ?> id="cata_recent_comments_<?php echo mt_rand(); ?>" class="<?php echo esc_attr($elemClass); ?>">
					<div class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
					<?php foreach ( $comments as $comment): $GLOBALS['comment'] = $comment; ?> 
						<?php if ( ($i == 0 || $i % $perSlide == 0) && $is_slider) { ?>
						<div class="cata-slick-per-slide">
						<?php } ?>
						
								<div class="<?php echo ( !$show_avatar && !$show_author || !$show_date) ? 'cata-item cata-only-show-quote' : 'cata-item'; ?>">
									<blockquote class="comment-body"><?php echo catanis_string_limit_words( strip_tags( apply_filters( 'get_comment_text', $comment->comment_content ) ), 15 ); ?></blockquote>
									
									<?php if ( $show_avatar ): ?>
									<div class="cata-avatar"><a href="<?php echo get_comment_link( $comment->comment_ID ); ?>"><?php echo get_avatar( $comment->comment_author_email, 70 ); ?></a></div>
									<?php endif; ?>
									
									<?php if( $show_author || $show_date ) : ?>
									<div class="cata-info">
										<?php if( $show_author ) : ?>
										<a href="<?php echo get_comment_link( $comment->comment_ID ); ?>" rel="external nofollow">   
											<span class="cata-author"><?php echo get_comment_author( $comment->comment_ID ); ?> </span>
										 </a>
										<?php endif; ?>
										
										<?php if( $show_date ): ?>
										<span class="cata-date"><?php echo date(get_option('date_format'), strtotime($comment->comment_date ) ); ?></span>
										<?php endif; ?>
									</div>
									<?php endif; ?>
								</div>
						<?php $i++; if ( ($i % $perSlide == 0 || $i == $limit) && $is_slider ) { ?>
						</div>
						<?php } ?>
					<?php endforeach;?>
					</div>
				</div>
			<?php
			}else{
				esc_html_e( 'No items to display!', 'onelove' );
			}
			echo $after_widget;
			
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] 			= strip_tags($new_instance['title']);
			$instance['limit'] 		= $new_instance['limit'];
			$instance['post_type'] 		= $new_instance['post_type'];
			$instance['show_avatar'] 	= $new_instance['show_avatar'];
			$instance['show_author'] 	= $new_instance['show_author'];
			$instance['show_date']	 	= $new_instance['show_date'];
			$instance['is_slider'] 		= $new_instance['is_slider'];
			$instance['show_nav'] 		= $new_instance['show_nav'];
			$instance['auto_play'] 		= $new_instance['auto_play'];
			$instance['per_slide'] 		= $new_instance['per_slide'];

			$instance['limit'] 		= ($instance['per_slide'] > $instance['limit']) ? ($instance['per_slide'] + 1) : $instance['limit'];
			return $instance;
		}

		function form( $instance ) {

			$instance 	= wp_parse_args( (array) $instance, $this->_ins_default );
			$htmlObj 	=  new Catanis_Widget_Html();
			$xhtml 		= ''; 

			$arrPosttype = array();
			$arrPosttype['all'] = esc_html__('All Posts', 'onelove');
			
			$post_types = get_post_types( array( 'public' => true, 'show_ui' => true ), 'names');
			foreach($post_types as $key => $post_type){
				if(post_type_supports( $key,'comments') ){
					$arrPosttype[$key] = ucfirst( $post_type );
				}
			}
			
			/* Element title*/
			$inputID 	= $this->get_field_id( 'title' );
			$inputName 	= $this->get_field_name( 'title' );
			$inputValue = esc_attr( $instance['title'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Title', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);
			
			/* Element limit*/
			$inputID 	= $this->get_field_id( 'limit' );
			$inputName 	= $this->get_field_name( 'limit' );
			$inputValue = absint( $instance['limit'] );
			$arr 		= array('class' => 'widefat','id' => $inputID);
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Number limit of comments', 'onelove' ), array('for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array('type' => 'limit', 'min' => '1' ) )
			
			);

			/* Element post_type*/
			$inputID 	= $this->get_field_id( 'post_type' );
			$inputName 	= $this->get_field_name( 'post_type' );
			$inputValue = esc_attr( $instance['post_type'] );
			$arr 		= array( 'class' => 'widefat','id' => $inputID);
			$opts 		= array( 'data' => $arrPosttype );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Post type', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts )
			);

			/* Element show_avatar*/
			$inputID 	= $this->get_field_id( 'show_avatar' );
			$inputName 	= $this->get_field_name( 'show_avatar' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => $instance['show_avatar'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show Avatar', 'onelove'), array('for' => $inputID ), true)
			);
			
			/* Element show_author*/
			$inputID 	= $this->get_field_id( 'show_author' );
			$inputName 	= $this->get_field_name( 'show_author' );
			$inputValue = 1;
			$arr 		= array('class' => 'widefat', 'id' => $inputID );
			$opts		= array('current_value' => $instance['show_author'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control('checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show author', 'onelove' ), array( 'for' => $inputID ), true)
			);
			
			/* Element show_date*/
			$inputID 	= $this->get_field_id( 'show_date' );
			$inputName 	= $this->get_field_name( 'show_date' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat','id' => $inputID );
			$opts		= array( 'current_value' => $instance['show_date'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show date', 'onelove'), array( 'for' => $inputID ), true)
			);

			$xhtml .= $htmlObj->infoText( esc_html__( 'Slider mode Options', 'onelove' ) );
			
			/* Element is_slider*/
			$inputID 	= $this->get_field_id( 'is_slider' );
			$inputName 	= $this->get_field_name( 'is_slider' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat','id' => $inputID);
			$opts		= array( 'current_value' => $instance['is_slider'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control('checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Slider mode', 'onelove'), array( 'for' => $inputID), true)
			);
			
			/* Element show_nav*/
			$inputID 	= $this->get_field_id( 'show_nav' );
			$inputName 	= $this->get_field_name( 'show_nav' );
			$inputValue = 1;
			$arr 		= array('class' => 'widefat', 'id' => $inputID );
			$opts		= array('current_value'=>$instance['show_nav'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control('checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show navigation button', 'onelove' ), array( 'for' => $inputID ), true)
			);
			
			/* Element auto_play*/
			$inputID 	= $this->get_field_id( 'auto_play' );
			$inputName 	= $this->get_field_name( 'auto_play' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => $instance['auto_play'] );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
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