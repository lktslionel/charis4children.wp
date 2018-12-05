<?php
if(!class_exists('Catanis_Widget_Subscriptions')){
	class Catanis_Widget_Subscriptions extends WP_Widget {

		private $_ins_default = array();
		
		function __construct() {
			$id_base 	= 'catanis-widget-subscriptions';
			$name		= esc_html__('CATANIS - Feedburner Subscriptions', 'onelove');
			$widget_options = array(
				'classname' 	=> 'cata-widget cata-widget-subscriptions',
				'description' 	=> esc_html__('Display Feedburner Subscriptions Form Widget', 'onelove')
			);
			$control_options = array('width' => '400px');
			parent::__construct($id_base, $name, $widget_options, $control_options);
		
			$this->_ins_default = array(
				'title' 		=> esc_html__('Sign up for Our Newsletter', 'onelove'),
				'intro_text'	=> esc_html__('A newsletter is a regularly distributed publication generally', 'onelove'),
				'feedburner_id'	=> '',
				'style'			=> 'simple',
				'background'	=> '',
				'button_text'	=> ''
			);
		}
		
		function widget( $args, $instance ) {
			
			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
			$intro_text 	= (isset($instance['intro_text']) && !empty($instance['intro_text'])) ? trim($instance['intro_text']) : $this->_ins_default['intro_text'];
			$button_text 	= (isset($instance['button_text']) && !empty($instance['button_text'])) ? trim($instance['button_text']) : $this->_ins_default['button_text'];
			$feedburner_id 	= (isset($instance['feedburner_id']) && !empty($instance['feedburner_id'])) ? trim($instance['feedburner_id']) : $this->_ins_default['feedburner_id'];
			$style 			= (isset($instance['style']) && !empty($instance['style'])) ? trim($instance['style']) : $this->_ins_default['style'];
			$background 	= (isset($instance['background']) && !empty($instance['background'])) ? trim($instance['background']) : $this->_ins_default['background'];
			
			$elemID 	= catanis_random_string(3, 'fsubscribe');
			$subscribeStyle = '';
			if($style == 'background'){
				$subscribeStyle = !empty($background) ? 'background: url('. esc_url($background) .') no-repeat center center' : '';
			}else{
				$button_text = '';
			}
			
			echo $before_widget . $before_title . $title . $after_title;
			?>
			<div class="cata-subscribe cata-style-<?php echo esc_attr($style); ?>" style="<?php echo esc_attr($subscribeStyle); ?>">
				<div class="cata-subscribe-inner">
					<?php if ( ! empty( $intro_text ) ) :?>
					<div class="newsletter">
						<span><?php echo esc_html($intro_text); ?></span>
					</div>
					<?php endif;?>
				
					<form id="<?php echo esc_attr($elemID); ?>" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr($feedburner_id); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
						<p class="subscribe-email">
							<input type="text" name="email" autocomplete="off" class="subscribe_email" value="" placeholder="<?php esc_attr_e('Your email address','onelove'); ?>" />
							<?php if($style == 'simple'): ?>
							<button class="button" type="submit" title="<?php esc_attr_e( 'Subscribe', 'onelove' ); ?>"><span class="ti-email"><?php echo esc_html($button_text);?></span></button>
							<?php else: ?>
							<button class="button" type="submit" title="<?php esc_attr_e( 'Subscribe', 'onelove' ); ?>"><?php echo esc_html($button_text);?></button>
							<?php endif; ?>	
						</p>
						<input type="hidden" value="<?php echo esc_attr($feedburner_id); ?>" name="uri"/>
						<input type="hidden" value="<?php echo esc_attr(get_bloginfo( 'name' ));?>" name="title"/>
						<input type="hidden" name="loc" value="en_US"/>
						<p class="delivered-by"><?php esc_html_e( 'Delivered by', 'onelove' ); ?> <a href="<?php esc_url( 'http://feedburner.google.com'); ?>" target="_blank"><?php esc_html_e( 'FeedBurner', 'onelove'); ?></a></p>
						<p class="updates-from"><?php esc_html_e( 'Get updates from', 'onelove' ); ?> <a href='<?php esc_url( 'http://feeds.feedburner.com/'); ?><?php echo esc_attr($feedburner_id); ?>' target='_blank'><?php esc_html_e( 'Catanis', 'onelove' ); ?></a></p>
					</form>
				</div>
			</div>
			<?php
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;		
			$instance['title'] 			= $new_instance['title'];
			$instance['intro_text'] 	=  $new_instance['intro_text'];
			$instance['button_text'] 	=  $new_instance['button_text'];
			$instance['feedburner_id'] 	=  $new_instance['feedburner_id'];	
			$instance['style'] 			=  $new_instance['style'];	
			$instance['background'] 	=  $new_instance['background'];	

			return $instance;
		}

		function form( $instance ) { 
			$instance 		= wp_parse_args( (array) $instance, $this->_ins_default);
			$htmlObj 	=  new Catanis_Widget_Html();
			$xhtml 		= '';
			
			/* Element title*/
			$inputID 	= $this->get_field_id( 'title' );
			$inputName 	= $this->get_field_name( 'title' );
			$inputValue = esc_attr( $instance['title'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Title', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
			);

			/* Element feedburner_id*/
			$inputID 	= $this->get_field_id( 'feedburner_id' );
			$inputName 	= $this->get_field_name( 'feedburner_id' );
			$inputValue = esc_attr( $instance['feedburner_id'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Enter your Feedburner ID', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
			);

			/* Element thumb_size*/
			$inputID 	= $this->get_field_id( 'style' );
			$inputName 	= $this->get_field_name( 'style' );
			$inputValue = esc_attr( $instance['style'] );
			$arr 		= array('class' => 'widefat', 'id' => $inputID, 'style' => '' );
			$opts 		= array('data' => array(
					'simple' => esc_html__('Style Simple', 'onelove' ),
					'background' => esc_html__('Style Background', 'onelove' ),
			));
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Select a style', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);

			/* Element intro_text*/
			$inputID 	= $this->get_field_id( 'intro_text' );
			$inputName 	= $this->get_field_name( 'intro_text' );
			$inputValue = esc_attr( $instance['intro_text'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Enter your intro text', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
			);

			/* Element button_text*/
			$inputID 	= $this->get_field_id( 'button_text' );
			$inputName 	= $this->get_field_name( 'button_text' );
			$inputValue = esc_attr( $instance['button_text'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Enter your button text (Only use for Style Background)', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
			); 

			/* Element background */
			$inputID 	= $this->get_field_id( 'background' );
			$inputName 	= $this->get_field_name( 'background' );
			$inputValue = $instance['background'];
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID, 'style' => 'margin-bottom:5px;' );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Enter your background (Only use for Style Background)', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
					.$htmlObj->control( 'button', $this->get_field_name( 'btnupload' ), esc_html__('Choose Image', 'onelove' ),
							array( 'class' => 'cata_upload_image_button button button-primary'),
							array( 'type' => 'button' ) )
			);
			
			echo trim($xhtml);			
		}
	}
}
?>