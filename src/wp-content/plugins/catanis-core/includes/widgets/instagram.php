<?php 
if ( ! class_exists('Catanis_Widget_Instagram') ) {
	class Catanis_Widget_Instagram extends WP_Widget {

		private $_ins_default = array();
		
		function __construct() {
			$id_base 	= 'catanis-widget-instagram';
			$name		= esc_html__('CATANIS - Instagram','onelove');
			$widget_options = array(
				'classname' 	=> 'cata-widget cata-widget-instagram',
				'description' 	=> esc_html__('The widget that displays recent Instagram photos.', 'onelove')
			);
			$control_options = array('width'=>'250px');
			parent::__construct( $id_base, $name, $widget_options, $control_options );
			
			$this->_ins_default = array(
				'title' 		=> '',
				'username'		=> '',
				'number'		=> 8,
				'columns'		=> 4,
				'size'			=> 'large',
				'target'		=> '_blank'
			);
		}
		
		function widget( $args, $instance ) {
			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
			$username 	= !empty($instance['username']) ? $instance['username'] : $this->_ins_default['username'];		
			$number 	= !empty($instance['number']) ? absint($instance['number']) : $this->_ins_default['number'];	
			$columns 	= ($instance['columns'] <= 0 || (empty($instance['type']) && $instance['columns'] > 5)) ? $this->_ins_default['columns'] : absint($instance['columns']);		
			$size 		= !empty( $instance['size'] ) ? $instance['size'] : $this->_ins_default['size'];
			$target 	= !empty( $instance['target'] ) ? $instance['target'] : $this->_ins_default['target'];

			echo $before_widget;
			if( $title ){
				echo $before_title . $title . $after_title;
			}
			
			if ( $username != '' ) {
			
				if ( !function_exists ( 'catanis_get_instagram' ) ) {
					echo  '<p>'. esc_html__('Please active our plugin "Catanis Core"','onelove') .'</p>';
					return false;
				}
				
				$media_array = catanis_get_instagram( $username );
				if ( is_wp_error( $media_array ) ) {
			
					echo wp_kses_post( $media_array->get_error_message() );
			
				} else {
			
					$media_array = array_slice( $media_array, 0, $number );
					if ( is_array( $media_array ) && count( $media_array ) > 0 ) {
						$output = '<ul class="cata-insta-items insta-columns-' . esc_attr( $columns ) . '">';
					
						foreach ( $media_array as $item ) {
							if($item['type'] == 'image'){
								$output	.= '<li><a href="' . esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'" title="'. esc_attr( $item['description'] ) .'"><img src="' . esc_url( $item[$size] ) . '" alt="'. esc_attr( $item['description'] ) .'" /></a></li>';
							}
						}
					
						$output .= '</ul>';
						$output .= '<a class="cata-see-more" href="' . trailingslashit( '//instagram.com/' . esc_attr( trim( $username ) ) ) . '" target="'. esc_attr( $target ) .'"><i class="fa fa-instagram" aria-hidden="true"></i>' . esc_html__( 'Follow us on Instagram', 'onelove') . '</a><div class="clear"></div>';
					}
					
					echo trim($output);
				}
			}else{
				return '<p>' . esc_html__( 'Please input username.', 'onelove' ) . '</p>';
			}
			
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] 		= strip_tags($new_instance['title']);
			$instance['username']	= $new_instance['username'];
			$instance['number']		= absint( $new_instance['number'] );
			$instance['columns']	= absint( $new_instance['columns'] );
			$instance['size']		= $new_instance['size'];
			$instance['target']		= $new_instance['target'];
					
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
					$htmlObj->labelTag( esc_html__('Title', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);
			
			/* Element userid*/
			$inputID 	= $this->get_field_id( 'username' );
			$inputName 	= $this->get_field_name( 'username' );
			$inputValue = esc_attr( $instance['username'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Username', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr ) 
			);
				
			/* Element number*/
			$inputID 	= $this->get_field_id( 'number' );
			$inputName 	= $this->get_field_name( 'number' );
			$inputValue = absint( $instance['number'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Limit number of photos: (1-30)', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number', 'min' => '1' ) )
			); 
				
			/* Element columns*/
			$inputID 	= $this->get_field_id( 'columns' );
			$inputName 	= $this->get_field_name( 'columns' );
			$inputValue = absint( $instance['columns']);
			$arr 		= array('class' =>'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Columns (1-5)', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number', 'min' => '1' ) )
			);
			
			/* Element size*/
			$inputID 	= $this->get_field_id( 'size' );
			$inputName 	= $this->get_field_name( 'size' );
			$inputValue = esc_attr( $instance['size'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts 		= array( 'data' => array('thumbnail' => 'Thumbnail', 'small' => 'Small', 'large' => 'Large', 'original' => 'Original') );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Photo size', 'onelove' ), array('for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);
			
			/* Element size*/
			$inputID 	= $this->get_field_id( 'target' );
			$inputName 	= $this->get_field_name( 'target' );
			$inputValue = esc_attr( $instance['target'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts 		= array( 'data' => array('_blank' => 'New window (_blank)', '_self' => 'Current window (_self)') );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Open links in', 'onelove' ), array('for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);
			
			echo trim($xhtml);
		}
	}
}
?>