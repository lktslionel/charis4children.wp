<?php
if ( ! class_exists( 'Catanis_Widget_Aboutus_Contact' ) ){
	class Catanis_Widget_Aboutus_Contact extends WP_Widget {

		private $_ins_default = array();
		
		function __construct() {
			$id_base 	= 'catanis-widget-about-contact';
			$name		= esc_html__( 'CATANIS - AboutUs Info', 'onelove' );
			$widget_options = array(
				'classname' 	=> 'catanis-widget cata-widget-aboutus-info',
				'description' 	=> esc_html__( 'Display some information such as logo, phone, email, address..', 'onelove' )
			);
			$control_options = array( 'width' => '250px' );
			parent::__construct( $id_base, $name, $widget_options, $control_options );
			
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_style_scripts' ) );
			
			$this->_ins_default = array(
				'title' 		=> esc_html__( 'About Us', 'onelove' ),
				'image' 		=> '',
				'description'	=> '',
				'office'		=> '',
				'fax'			=> '',
				'phone'			=> '',
				'email'			=> '',
				'website'		=> ''
			);
		}

		public function enqueue_style_scripts() {
			global $current_screen;
			if($current_screen->id == 'widgets'){
				wp_enqueue_script( 'media-upload' );
				wp_enqueue_script( 'thickbox' );
				wp_enqueue_script( 'upload_media_widget', CATANIS_FRAMEWORK_URL . 'js/widget-upload-media.js', array( 'jquery' ) );
				wp_enqueue_style( 'thickbox' );
			}
			
		}
		
		function widget( $args, $instance ) {
			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
			$image 			= !empty($instance['image']) ? esc_url(trim($instance['image'])) : $this->_ins_default['image'];
			$description 	= !empty($instance['description']) ? trim( $instance['description'] ) : $this->_ins_default['description'];
			$office 		= !empty($instance['office']) ? trim( $instance['office'] ) : $this->_ins_default['office'];
			$phone 			= !empty($instance['phone']) ? trim( $instance['phone'] ) : $this->_ins_default['phone'];
			$fax 			= !empty($instance['fax']) ? trim( $instance['fax'] ) : $this->_ins_default['fax'];
			$email 			= !empty($instance['email']) ? trim( $instance['email'] ) : $this->_ins_default['email'];
			$website 		= !empty($instance['website']) ? trim( $instance['website'] ) : $this->_ins_default['website'];
		
			echo $before_widget;
			if ( empty( $image ) ) {
				echo $before_title . $title . $after_title;
			}			
			?>
			<div class="cata-aboutus-info">
				<?php if ( ! empty( $image ) ) : ?>
				<p class="cata-footer-logo"><img src="<?php echo esc_url( $image); ?>" alt="<?php echo esc_attr($title); ?>" /></p>	
				<?php endif; ?>
			
				<?php if ( ! empty( $description ) ) : ?>
				<div class="cata-desc"><?php echo wp_kses_post(wpautop($description) ); ?> </div>
				<?php endif; ?>
				
				<?php if ( ! empty( $office ) || ! empty( $phone ) || ! empty( $fax ) || ! empty( $fax ) || ! empty( $email ) ) : ?>
				<ul>
					<?php if ( ! empty( $office ) ) : ?>
						<li class="cata-office"><i class="fa fa-map-marker swing"></i> <?php echo esc_html( $office); ?></li>				
					<?php endif; ?>
					
					<?php if ( ! empty( $phone ) ): ?>
						<li class="cata-phone"><i class="fa fa-phone"></i> <?php echo esc_html( $phone); ?></li>
					<?php endif; ?>
					
					<?php if ( ! empty( $fax ) ): ?>
						<li class="cata-fax"><i class="fa fa-building-o"></i> <?php echo esc_html( $fax); ?></li>
					<?php endif; ?>
					
					<?php if ( ! empty($email ) ): ?>
						<li class="cata-email"><i class="fa fa-envelope-o"></i> <?php echo esc_html( $email); ?></li>
					<?php endif; ?>
					
					<?php if ( ! empty($website ) ): ?>
						<li class="cata-website"><i class="fa fa-globe"></i> <?php echo esc_html( $website); ?></li>
					<?php endif; ?>
				</ul>
				<?php endif; ?>
				
				<div class="clear"></div>
			</div>
			<?php
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			
			$instance = $old_instance;
			$instance['title'] 			= strip_tags($new_instance['title']);
			$instance['image'] 			= $new_instance['image'];
			$instance['description'] 	= $new_instance['description'];
			$instance['office'] 		= $new_instance['office'];
			$instance['phone'] 			= $new_instance['phone'];
			$instance['fax'] 			= $new_instance['fax'];
			$instance['email'] 			= $new_instance['email'];		
			$instance['website'] 		= $new_instance['website'];		
			
			return $instance;
		}

		function form( $instance ) { 
			
			$instance 	= wp_parse_args( (array) $instance, $this->_ins_default );
			$htmlObj 	=  new Catanis_Widget_Html();
			$xhtml 		= '';
			
			/* Element title*/
			$inputID 	= $this->get_field_id( 'title' );
			$inputName 	= $this->get_field_name( 'title' );
			$inputValue = esc_attr( $instance['title'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Title', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);

			/* Element description */
			$inputID 	= $this->get_field_id( 'description' );
			$inputName 	= $this->get_field_name( 'description' );
			$inputValue = esc_textarea( $instance['description'] );
			$arr 		= array( 'class' => 'widefat','id' => $inputID, 'style' => 'min-height:100px;' );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Enter your description', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textarea', $inputName, $inputValue, $arr )
			);
				
			/* Element office */
			$inputID 	= $this->get_field_id( 'office' );
			$inputName 	= $this->get_field_name( 'office' );
			$inputValue = esc_attr( $instance['office'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Enter your office.', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);

			/*  Element phone */
			$inputID 	= $this->get_field_id( 'phone' );
			$inputName 	= $this->get_field_name( 'phone' );
			$inputValue = esc_attr( $instance['phone'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Enter your phone', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);

			/* Element fax */
			$inputID 	= $this->get_field_id( 'fax' );
			$inputName 	= $this->get_field_name( 'fax' );
			$inputValue = esc_attr( $instance['fax'] );
			$arr 		= array( 'class' => 'widefat','id' => $inputID );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Enter your fax', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);

			/* Element email */
			$inputID 	= $this->get_field_id( 'email' );
			$inputName 	= $this->get_field_name( 'email' );
			$inputValue = esc_attr( $instance['email'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID);
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Enter your email', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);
			
			/* Element website */
			$inputID 	= $this->get_field_id( 'website' );
			$inputName 	= $this->get_field_name( 'website' );
			$inputValue = esc_attr( $instance['website'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Enter your website', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);

			/* Element image */
			$inputID 	= $this->get_field_id( 'image' );
			$inputName 	= $this->get_field_name( 'image' );
			$inputValue = $instance['image'];
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID, 'style' => 'margin-bottom:5px;' );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Enter your image', 'onelove' ), array( 'for' => $inputID ) )
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