<?php 
if ( ! class_exists( 'Catanis_Widget_Flickr' ) ) {
	class Catanis_Widget_Flickr extends WP_Widget {

		private $_ins_default = array();
		
		function __construct() {

			$id_base 	= 'catanis-widget-flickr';
			$name		= esc_html__( 'CATANIS - Flickr', 'onelove' );
			$widget_options = array(
				'classname' 	=> 'cata-widget cata-widget-flickr',
				'description' 	=> esc_html__( 'This Flickr widget populates photos from a Flickr ID', 'onelove' )
			);
			$control_options = array( 'width' => '250px' );
			parent::__construct( $id_base, $name, $widget_options, $control_options );
			
			$this->_ins_default = array(
				'title' 		=> esc_html__( 'Fickr', 'onelove' ),
				'id'			=> '133442753@N02', 
				'number' 		=> 8,
				'sorting' 		=> 'latest',
				'columns' 		=> 4
			);
		}

		function widget( $args, $instance ) {
			
			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
			$id 			= !empty($instance['id']) ? trim( $instance['id'] ) : $this->_ins_default['id'];
			$number 		= !empty($instance['number']) ? absint( $instance['number'] ) : $this->_ins_default['number'];
			$sorting 		= !empty($instance['sorting']) ? esc_attr( $instance['sorting'] ) : $this->_ins_default['sorting'];
			$columns 		= ( $instance['columns'] <= 0 || $instance['columns'] > 5) ? absint($this->_ins_default['columns']) : absint($instance['columns'] );
			
			echo $before_widget;
			if( $title ){
				echo $before_title . $title . $after_title;
			}
			
			if ( $id ) {
				unset($instance['title']);
				$transient_key = 'flickr_' . implode('_', $instance);
				$cache = get_transient($transient_key);
					
				if( $cache !== false){
					echo trim($cache);
				} else {
					
					$url = 'http://www.flickr.com/badge_code_v2.gne?source=user&user=' . $id . '&count=' . $number . '&display=' . $sorting . '&layout=x&size=m';
					$args = array(
						'method'      => 'GET',
						'timeout'     => 5,
						'redirection' => 5,
						'httpversion' => '1.0',
						'blocking'    => true,
						'headers'     => array(),
						'body'        => null,
						'cookies'     => array()
					);
					$statuses = wp_remote_get( $url, $args );
					if ( ! is_wp_error( $statuses ) ) {
						$statuses 	=  $statuses['body'];
						$math 		= preg_match_all( '/<a.*?href="(.*?)".*?src="(.*?)".*?<\/a>/ism', $statuses, $match );
						
						ob_start();
						?>
						<div class="cata-flickr-wrapper">
							<ul class="cata-flickr-items flickr-columns-<?php echo esc_attr( $columns ); ?>">
							<?php foreach( $match[0] as $index => $image ) : ?>
								<li><?php echo ($image);?></li>
							<?php endforeach; ?>	
							</ul>
							
							<div class="clear"></div>
							<a class="cata-see-more" href="http://www.flickr.com/photos/<?php echo esc_html($id); ?>" target="_blank"><?php esc_html_e( 'Follow us on Flikr', 'onelove' ); ?></a>
							<div class="clear"></div>
						</div>
						<?php 
						$output = ob_get_clean();
						echo ($output);
						set_transient($transient_key, $output, 12 * HOUR_IN_SECONDS);
					}
					
				}
			}
			echo $after_widget;
	   }

		function update( $new_instance, $old_instance ) {
			
			$instance = $old_instance;
   			$instance['title'] 		=  strip_tags($new_instance['title']);
   			$instance['id'] 		=  $new_instance['id'];
		   	$instance['number'] 	=  $new_instance['number'];
		   	$instance['columns'] 	=  $new_instance['columns'];
		   	$instance['sorting'] 	=  $new_instance['sorting'];
		
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
			
			/* Element id*/
			$inputID 	= $this->get_field_id( 'id' );
			$inputName 	= $this->get_field_name( 'id' );
			$inputValue = esc_attr( $instance['id'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Flickr ID', 'onelove') . '( <a href="' . esc_url("http://www.idgettr.com") . '">idGettr</a>):', array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);
			
			/* Element number*/
			$inputID 	= $this->get_field_id( 'number' );
			$inputName 	= $this->get_field_name( 'number' );
			$inputValue = absint( $instance['number'] );
			$arr = array( 'class' => 'widefat', 'id' => $inputID );
			$opts = array( 'data' => array( '1' => 1,'2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9,'10' => 10 ) );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Number', 'onelove'), array( 'for'=>$inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts )
			);
			
			/* Element columns*/
			$inputID 	= $this->get_field_id( 'columns' );
			$inputName 	= $this->get_field_name( 'columns' );
			$inputValue = absint( $instance['columns'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Columns (1-5)', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number', 'min' => '1' ) )
			);

			/* Element sorting*/
			$inputID 	= $this->get_field_id( 'sorting' );
			$inputName 	= $this->get_field_name( 'sorting' );
			$inputValue = esc_attr( $instance['sorting'] );
			$arr = array( 'class' => 'widefat','id' => $inputID);
			$opts = array( 'data' => array( 'latest' => esc_html__( 'Latest', 'onelove'), 'random' => esc_html__( 'Random', 'onelove' ) ) );
			$xhtml .= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__( 'Sorting', 'onelove' ), array('for'=>$inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts )
			);

			echo trim($xhtml);
		}
	}
}
?>