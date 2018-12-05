<?php
if ( ! class_exists( 'Catanis_Widget_Facebook' ) ) {
	class Catanis_Widget_Facebook extends WP_Widget {
		private $_ins_default = array();
		
		function __construct() {
		
			$id_base 	= 'catanis-widget-facebook';
			$name		= esc_html__( 'CATANIS - Facebook', 'onelove' );
			$widget_options = array(
					'classname' 	=> 'cata-widget cata-widget-facebook',
					'description' 	=> esc_html__( 'Facebook Social Network widget.', 'onelove' )
			);
			$control_options = array( 'width' => '250px' );
			parent::__construct( $id_base, $name, $widget_options, $control_options );
				
			$this->_ins_default = array(
				'title' 		=> __('Facebook widget', 'onelove'),
				'url'			=> 'platform',
				'width' 		=> 370,
				'height' 		=> 450,
				'hide_cover' 	=> 'false',
				'show_faces' 	=> 'true',
				'small_header' 	=> 'false',
				'image_upload' 	=> ''					
			);	
		}
		
		public function widget($args, $instance) {

			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
		
			$url = isset($instance['url']) && !empty($instance['url']) ? $instance['url'] : $this->_ins_default['url'];
			$width = isset($instance['width']) && !empty($instance['width']) ? $instance['width'] : $this->_ins_default['width'];
			$height = isset($instance['height']) && !empty($instance['height']) ? $instance['height'] : $this->_ins_default['height'];
			$hide_cover = isset($instance['hide_cover']) && !empty($instance['hide_cover']) ? $instance['hide_cover'] : $this->_ins_default['hide_cover'];
			$show_faces = isset($instance['faces']) && !empty($instance['show_faces']) ? $instance['show_faces'] : $this->_ins_default['show_faces'];
			$small_header = isset($instance['small_header']) && !empty($instance['small_header']) ? $instance['small_header'] : $this->_ins_default['small_header'];
			$image_upload = isset($instance['image_upload']) && !empty($instance['image_upload']) ? $instance['image_upload'] : $this->_ins_default['image_upload'];
			echo $before_widget;
			if ($title) {
				echo $before_title . $title . $after_title;
			}
			?>
				
				<div class="cata-facebook-outer">
					<?php if(!empty($image_upload)) : ?>
						<div class="cata-widget-mask" style="background-image: url(<?php echo esc_url($image_upload) ?>);"></div>
					<?php endif; ?>
					
					<div class="cata-facebook-inner">
						<div class="fb-page" 
							data-href="https://www.facebook.com/<?php echo esc_attr($url); ?>" 
							data-tabs="timeline" adapt_container_width="true" 
							data-width="<?php echo esc_attr($width); ?>" data-height="<?php echo esc_attr($height); ?>"
							data-small-header="<?php echo esc_attr($small_header); ?>" 
							data-adapt-container-width="true" 
							data-hide-cover="<?php echo esc_attr($hide_cover); ?>" 
							data-show-facepile="<?php echo esc_attr($show_faces); ?>">
						</div>
					</div>
				</div>
				<div id="fb-root"></div>
				<script type="text/javascript">
				(function(d, s, id) {
					"use strict";
					
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id))
						return;
					js = d.createElement(s);
					js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
				</script>
		
			<?php
			echo $after_widget;
		}
			
		public function update($new_instance, $old_instance) {
		
			$instance = array();
			$instance['title'] 			= strip_tags($new_instance['title']);
			$instance['url'] 			= strip_tags($new_instance['url']);
			$instance['width'] 			= strip_tags($new_instance['width']);
			$instance['height'] 		= strip_tags($new_instance['height']);
			$instance['hide_cover'] 	= strip_tags($new_instance['hide_cover']);
			$instance['show_faces'] 	= strip_tags($new_instance['show_faces']);
			$instance['small_header'] 	= strip_tags($new_instance['small_header']);
			$instance['image_upload'] 	= esc_url($new_instance['image_upload']);
			
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
				
			/* Element url*/
			$inputID 	= $this->get_field_id( 'url' );
			$inputName 	= $this->get_field_name( 'url' );
			$inputValue = esc_attr( $instance['url'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Facebook Name ( facebook.com/ * Type into field * )', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);
			
			/* Element width*/
			$inputID 	= $this->get_field_id( 'width' );
			$inputName 	= $this->get_field_name( 'width' );
			$inputValue = esc_attr( $instance['width'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Width (Ex: 300 )', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);

			/* Element height*/
			$inputID 	= $this->get_field_id( 'height' );
			$inputName 	= $this->get_field_name( 'height' );
			$inputValue = esc_attr( $instance['height'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Height (Ex: 450 )', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);

			/* Element faces*/
			$inputID 	= $this->get_field_id( 'show_faces' );
			$inputName 	= $this->get_field_name( 'show_faces' );
			$inputValue = esc_attr( $instance['show_faces'] );
			$arr = array( 'class' => 'widefat', 'id' => $inputID );
			$opts = array( 'data' => array( 'true' => 'Yes','false' => 'No') );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Show faces', 'onelove'), array( 'for'=>$inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts )
			);

			/* Element hide_cover*/
			$inputID 	= $this->get_field_id( 'hide_cover' );
			$inputName 	= $this->get_field_name( 'hide_cover' );
			$inputValue = esc_attr( $instance['hide_cover'] );
			$arr = array( 'class' => 'widefat', 'id' => $inputID );
			$opts = array( 'data' => array( 'true' => 'Yes','false' => 'No') );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Hide cover photo in the header', 'onelove'), array( 'for'=>$inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts )
			);

			/* Element small_header*/
			$inputID 	= $this->get_field_id( 'small_header' );
			$inputName 	= $this->get_field_name( 'small_header' );
			$inputValue = esc_attr($instance['small_header']);
			$arr = array( 'class' => 'widefat', 'id' => $inputID );
			$opts = array( 'data' => array( 'true' => 'Yes', 'false' => 'No') );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Use the small header instead', 'onelove'), array( 'for'=>$inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts )
			);

			/* Element imageUpload */
			$inputID 	= $this->get_field_id( 'image_upload' );
			$inputName 	= $this->get_field_name( 'image_upload' );
			$inputValue = $instance['image_upload'];
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID, 'style' => 'margin-bottom:5px;' );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Mask image', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
					.$htmlObj->control( 'button', $this->get_field_name( 'btnupload' ), esc_html__('Upload Image', 'onelove' ),
							array( 'class' => 'cata_upload_image_button button button-primary'),
							array( 'type' => 'button' ) )
			);
			
			echo trim($xhtml);
		}
		
	}
}
?>