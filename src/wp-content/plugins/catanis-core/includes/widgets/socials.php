<?php
if ( ! class_exists('Catanis_Widget_Socials')){
	class Catanis_Widget_Socials extends WP_Widget {

		private $_ins_default = array();
		
		function __construct() {
			$id_base 	= 'catanis-widget-socials';
			$name		= esc_html__('CATANIS - Social Profiles','onelove');
			$widget_options = array(
				'classname' 	=> 'cata-widget cata-widget-socials',
				'description' 	=> esc_html__('Display Social Profiles', 'onelove')
			);
			$control_options = array('width' => '250px');
			parent::__construct($id_base, $name, $widget_options, $control_options);
			
			$this->_ins_default = array(
				'title' 		=> '',
				'main_style' 	=> 'style1',
				'size' 			=> 'sm',
				'show_tooltip'	=> 'yes'
			);
		}

		function widget( $args, $instance ) {
			
			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
			
			echo $before_widget;
			if( $title ){
				echo $before_title . $title . $after_title;
			}
			
			catanis_html_socials_theme_option( array(
				'main_style' 	=> $instance['main_style'],
				'size'			=> $instance['size'],
				'show_tooltip' 	=> $instance['show_tooltip']
			) );
			
			echo $after_widget;			
		}

		function update( $new_instance, $old_instance ) {
			
			$instance = $old_instance;
			$instance['title'] 			= strip_tags($new_instance['title']);
			$instance['main_style'] 	= $new_instance['main_style'];
			$instance['size'] 			= $new_instance['size'];
			$instance['show_tooltip'] 	= $new_instance['show_tooltip'];
			
			return $instance;
		}

		function form( $instance ) { 
			$instance 	= wp_parse_args( (array) $instance, $this->_ins_default );
			$htmlObj =  new Catanis_Widget_Html();
			$xhtml = '';
			
			$xhtml .= $htmlObj->infoText( esc_html__( 'You setting socials icon in Theme Options', 'onelove' ) );
			
			/* Element title*/
			$inputID 	= $this->get_field_id( 'title' );
			$inputName 	= $this->get_field_name( 'title' );
			$inputValue = esc_attr( $instance['title'] );
			$arr 		= array('class' => 'widefat', 'id' => $inputID);
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Enter your title', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
			);

			/* Element style*/
			$inputID 	= $this->get_field_id( 'main_style' );
			$inputName 	= $this->get_field_name( 'main_style' );
			$inputValue = esc_attr( $instance['main_style'] );
			$arr 		= array('class' => 'widefat', 'id' => $inputID);
			$opts 		= array('data' => array(
				'style1' 	=> esc_html__('Style #1', 'onelove' ),
				'style2' 	=> esc_html__('Style #2', 'onelove'),					
				'style12' 	=> esc_html__('Style #3', 'onelove')					
			) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Style socials', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);
			
			/* Element style*/
			$inputID 	= $this->get_field_id( 'size' );
			$inputName 	= $this->get_field_name( 'size' );
			$inputValue = esc_attr( $instance['size'] );
			$arr 		= array('class' => 'widefat', 'id' => $inputID);
			$opts 		= array('data' => array(
				'lg' 	=> esc_html__('Large', 'onelove' ),
				'nm' 	=> esc_html__('Normal', 'onelove'),
				'sm' 	=> esc_html__('Small', 'onelove')
			) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Size', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);
			
			/* Element show_tooltip*/
			$inputID 	= $this->get_field_id( 'show_tooltip' );
			$inputName 	= $this->get_field_name( 'show_tooltip' );
			$inputValue = esc_attr( $instance['show_tooltip'] );
			$arr 		= array('class' => 'widefat', 'id' => $inputID);
			$opts 		= array('data' => array('yes' => esc_html__('Yes', 'onelove' ), 'no' => esc_html__('No', 'onelove') ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Show tooltip', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);
			
			echo trim($xhtml);
		}
	}
}
?>