<?php 
if ( ! class_exists( 'Catanis_Widget_Ads' ) ) {
	class Catanis_Widget_Ads extends WP_Widget {

		private $_ins_default = array();
		
		function __construct() {
			$id_base 	= 'catanis-widget-ads';
			$name		= esc_html__( 'CATANIS - Advertisement', 'onelove' );
			$widget_options = array(
				'classname' 	=> 'catanis-widget-css wg-ads',
				'description' 	=> esc_html__( 'Catanis Advertisment Widget', 'onelove' )
			);
			$control_options = array( 'width' => '350px' );
			parent::__construct( $id_base, $name, $widget_options, $control_options );
			
			$this->_ins_default = array(
				'title' 		=> '',
				'image' 		=> '',
				'link_url'		=> '',
				'image_title'	=> '',
				'hover_style'	=> '',
				'image_height'	=> '',
				'image_width'	=> ''
			);
		}
		
		function widget( $args, $instance ) {
			
			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
				
			$image 			= !empty($instance['image']) ? trim( $instance['image'] ) : $this->_ins_default['image'];
			$linkUrl 		= !empty($instance['link_url']) ? esc_url( $instance['link_url'] ) : $this->_ins_default['link_url'];
			$imgTitle 		= !empty($instance['image_title']) ? trim( $instance['image_title'] ) : $this->_ins_default['image_title'];
			$hover_style 	= !empty($instance['hover_style']) ? trim( $instance['hover_style'] ) : $this->_ins_default['hover_style'];
			$imgHeight 		= !empty($instance['image_height']) ? absint( $instance['image_height'] ) : $this->_ins_default['image_height'];
			$imgWidth 		= !empty($instance['image_width']) ? absint( $instance['image_width'] ) : $this->_ins_default['image_width'];
			
			if ( ! empty( $image ) && @getimagesize( $image ) !== false ) {
				
				$attr = '';
				$attr .= ' alt="' . esc_attr($imgTitle) . '"';
				$attr .= ' title="' . esc_attr($imgTitle) . '"';
				if ( !empty($imgHeight) && $imgHeight > 0 ) {
					$attr .= ' height="' . esc_attr($imgHeight) . '"';
				}
				if ( !empty($imgWidth) && $imgWidth > 0 ) {
					$attr .= ' width="' . esc_attr($imgWidth) . '"';
				} 
				
				$hover_style = (!empty($hover_style)) ? '<span class="cata-effect cata-'. $hover_style .'"></span>' : '';
				
				echo $before_widget;
				if( $title ) {
					echo $before_title . $title . $after_title;
				}
				echo '<div class="cata-ads">
						<a href="' . esc_url($linkUrl) . '" target="_blank"><img src="' . esc_url($image) . '" ' . $attr . '/>
						'. $hover_style .'</a>
					</div>';
				echo $after_widget;
			}
		}
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] 			= strip_tags( $new_instance['title'] );
			$instance['image'] 			= $new_instance['image'];
			$instance['link_url'] 		= esc_url( $new_instance['link_url'] );
			$instance['image_title'] 	= esc_attr( $new_instance['image_title'] );
			$instance['hover_style'] 	= esc_attr( $new_instance['hover_style'] );
			$instance['image_height'] 	= absint( $new_instance['image_height'] );
			$instance['image_width'] 	= absint( $new_instance['image_width'] );

			return $instance;
		}

		function form( $instance ) {
			
			$instance 	= wp_parse_args( (array) $instance, $this->_ins_default );
			$htmlObj 	=  new Catanis_Widget_Html();
			$xhtml 		= '';
			
			/* Element title*/
			$inputID 	= $this->get_field_id( 'title' );
			$inputName 	= $this->get_field_name( 'title' );
			$inputValue = esc_attr($instance[ 'title'] );
			$arr 		= array( 'class' => 'widefat','id' => $inputID );
			$xhtml 	.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Title', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);
			
			/* Element image*/
			$inputID 	= $this->get_field_id( 'image' );
			$inputName 	= $this->get_field_name( 'image' );
			$inputValue = $instance['image'];
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID, 'style' => 'margin-bottom:5px;' );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Image Url', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
					.$htmlObj->control( 'button', $this->get_field_name( 'btnupload' ), esc_html__('Choose Image', 'onelove' ),
							array( 'class' => 'cata_upload_image_button button button-primary'),
							array( 'type' => 'button' ) )
			);
			
			/* Element link_url*/
			$inputID 	= $this->get_field_id( 'link_url' );
			$inputName 	= $this->get_field_name('link_url' );
			$inputValue = esc_url( $instance['link_url'] );
			$arr = array('class' => 'widefat', 'id' => $inputID );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Link Url', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
			);
			
			/* Element image_title*/
			$inputID 	= $this->get_field_id( 'image_title' );
			$inputName 	= $this->get_field_name( 'image_title' );
			$inputValue = esc_attr( $instance['image_title'] );
			$arr = array('class' => 'widefat', 'id' => $inputID );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Image Title', 'onelove' ), array('for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);
			
			/* Element hover_style*/
			$inputID 	= $this->get_field_id( 'hover_style' );
			$inputName 	= $this->get_field_name( 'hover_style' );
			$inputValue = esc_attr( $instance['hover_style'] );
			$arr 		= array('class' => 'widefat', 'id' => $inputID );
			$opts 		= array('data' => array(
				'' 			=> esc_html__('None', 'onelove' ),
				'effect-sparkle' 	=> esc_html__('Sparkle', 'onelove' ),
				'effect-rain' 		=> esc_html__('Rain', 'onelove' ),
				'effect-glass' 	=> esc_html__('Glass', 'onelove'),
				'effect-snow' 		=> esc_html__('Snow', 'onelove')
			));
			$xhtml 		.= $htmlObj->generalItem(
				$htmlObj->labelTag( esc_html__('Hover Style', 'onelove'), array( 'for' => $inputID ) )
				.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);
			
			/* Element image_width*/
			$inputID 	= $this->get_field_id( 'image_width' );
			$inputName 	= $this->get_field_name( 'image_width' );
			$inputValue = absint( $instance['image_width'] );
			$arr = array( 'class' => 'widefat', 'id' => $inputID, 'style' => 'width:80%' );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Image Width (Optional)', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr ) . ' px'
			);
			
			/* Element image_height*/
			$inputID 	= $this->get_field_id( 'image_height' );
			$inputName 	= $this->get_field_name( 'image_height' );
			$inputValue = absint( $instance['image_height'] );
			$arr = array( 'class' => 'widefat', 'id' => $inputID, 'style' => 'width:80%' );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Image Height (Optional)', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr ) .' px'
			);
			
			$xhtml .= $htmlObj->labelTag( esc_html__( 'NOTE: If you dont input image url OR image url does not exist, advertisement dont display.', 'onelove' ), $arr = array( 'style' => '    display: block; margin-bottom:10px;' ) );

			echo trim($xhtml);
		}
	}
}
?>