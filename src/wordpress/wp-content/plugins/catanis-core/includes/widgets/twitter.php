<?php 
if ( ! class_exists('Catanis_Widget_Twitter' ) ) {
	class Catanis_Widget_Twitter extends WP_Widget {

		private $_ins_default = array();
		private $_flag_check_option = false;
		
		function __construct() {
			$id_base 	= 'catanis-widget-twitter';
			$name		= esc_html__('CATANIS - Twitter','onelove');
			$widget_options = array(
				'classname' 	=> 'cata-widget cata-widget-twitter',
				'description' 	=> esc_html__('Catanis Twitter', 'onelove')
			);
			$control_options = array('width' => '250px');
			parent::__construct($id_base, $name, $widget_options, $control_options);
			
			if( !function_exists('catanis_option')) {
				return;
			}
			
			$consumer_key = catanis_option('consumer_key');
			$consumer_secret = catanis_option('consumer_secret');
			$access_token = catanis_option('access_token');
			$access_token_secret = catanis_option('access_token_secret');
			if(function_exists('catanis_option') && !empty($consumer_key) && !empty($consumer_secret) && !empty($access_token) && !empty($access_token_secret) ){
				$this->_flag_check_option = true;
			}
			
			$this->_ins_default = array(
				'title' 		=> esc_html__( 'Follow Us', 'onelove' ),
				'limit'			=> 4,
				'username'		=> '',
				'is_slider' 	=> 1,
				'show_nav' 		=> 1,
				'auto_play' 	=> 1,
				'per_slide'		=> 2
			);
		}
		
		function widget( $args, $instance ) {
			
			extract( $args );
			$title 			= apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
			$limit 			= !empty( $instance['limit'] ) ? absint( $instance['limit'] ) : $this->_ins_default['limit'];
			$username 		= !empty( $instance['username'] ) ? esc_attr( $instance['username'] ) : $this->_ins_default['username'];
			$is_slider 		= ($instance['is_slider']) ? $instance['is_slider'] : 0;
			$show_nav 		= ($instance['show_nav']) ? $instance['show_nav'] : 0;
			$auto_play 		= ($instance['auto_play']) ? $instance['auto_play'] : 0;
			$perSlide 		= !empty($instance['per_slide']) ? absint($instance['per_slide']) : $this->_ins_default['per_slide'];
			
			echo $before_widget;
			if( $title ){
				echo $before_title . $title . $after_title;
			}
			
			if( empty($username) ){
				return esc_html__( 'Please input username twitter.', 'onelove');
			}
			
			$transient_key = 'catanis_twitter_' . trim( $username ) . '_limit' .trim( $limit ) . '_nav'. $show_nav. '-slider' .$is_slider;
			$cache = get_transient($transient_key);
			
			if( $cache !== false) {
				echo ($cache) ;
					
			} else {
	
				if( $limit < 2 || $limit <= $perSlide ){
					$is_slider = 0;
				}
				
				$elemClass = 'cata-widget-twitter-wrapper';
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
				
				$i = 0;
				$tweets = catanis_get_tweets($username, $limit);
			
				if ($tweets != '' && is_array($tweets) ) {
					ob_start();
					?>
					<div<?php echo rtrim($dir); ?> id="cata_twitter<?php echo mt_rand(); ?>" class="<?php echo esc_attr($elemClass); ?>">
						<div class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
						
						<?php foreach ( $tweets as $tweet ) : ?>
							<?php if ( ($i == 0 || $i % $perSlide == 0) && $is_slider == 1 ) { ?>
							<div class="cata-slick-per-slide">
							<?php } ?>
							
								<div class="cata-item">
									<div class="tweet-content"><?php echo trim($tweet['text']); ?></div>
									<div class="author-datetime">
										<a href="<?php echo esc_url('http://twitter.com/' . $tweet['name']); ?>" target="_blank">
											by @<?php echo esc_html($tweet['name']); ?>
										</a>
										<span><?php echo human_time_diff($tweet['time'], current_time('timestamp')) . ' ' . esc_html__('ago', 'onelove'); ?></span>
									</div>
								</div>
							
							<?php $i++; if ( ($i % $perSlide == 0 || $i == $limit ) && $is_slider == 1 ) { ?>
							</div>
							<?php } ?>
						<?php endforeach;?>
						</div>
					</div>
					<?php
					$output = ob_get_clean();
					echo ($output);
					set_transient($transient_key, $output, 12 * HOUR_IN_SECONDS);
				}
			}
			
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] 			= strip_tags( $new_instance['title'] );
			$instance['username'] 		= $new_instance['username'];
			$instance['limit'] 			= absint( $new_instance['limit'] );
			$instance['is_slider'] 		= $new_instance['is_slider'];
			$instance['show_nav'] 		= $new_instance['show_nav'];
			$instance['auto_play'] 		= $new_instance['auto_play'];
			$instance['per_slide'] 		= $new_instance['per_slide'];
			$instance['limit'] 			= ($instance['per_slide'] > $instance['limit']) ? ($instance['per_slide'] + 1) : $instance['limit'];
							
			return $instance;
		}

		function form( $instance ) {

			$instance 	= wp_parse_args( (array) $instance, $this->_ins_default );
			$htmlObj 	= new Catanis_Widget_Html();
			$xhtml 		= '';
			
			if ( !$this->_flag_check_option) {
				$xhtml .= $htmlObj->infoText( esc_html__( 'You need setting twitter keys in Theme Options', 'onelove' ) );
			}
			
			/* Element title*/
			$inputID 	= $this->get_field_id( 'title' );
			$inputName 	= $this->get_field_name( 'title' );
			$inputValue = esc_attr( $instance['title'] ); 
			$arr = array('class' => 'widefat', 'id' => $inputID );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Title', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);
			
			/* Element username*/
			$inputID 	= $this->get_field_id( 'username' );
			$inputName 	= $this->get_field_name( 'username' );
			$inputValue = esc_attr( $instance['username']);
			$arr = array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Username', 'onelove'), array('for' => $inputID ) )
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
	
		/** Convert date time format **/
		function date_format($time){
			$startDate = date( get_option( 'date_format' ) . ' ' . get_option('time_format'), strtotime($time));
			$endDate = date( get_option( 'date_format' ) . ' ' . get_option('time_format'), time());
			$option = array( 'date_format' => get_option('date_format'), 'time_format' => get_option('time_format'));
				
			return Catanis_Default_Data::dateDistance( $startDate, $endDate, $option);
			/*return mysql2date(get_option('date_format'), $time);*/
		}
	}
}
?>