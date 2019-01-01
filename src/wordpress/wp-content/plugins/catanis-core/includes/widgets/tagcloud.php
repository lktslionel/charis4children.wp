<?php 
if ( ! class_exists('Catanis_Widget_Tagcloud') ) {
	
	class Catanis_Widget_Tagcloud extends WP_Widget {
		
		private $_woo_actived = false;
		private $_ins_default = array();
		
		function __construct() {
			
			$id_base 	= 'catanis-widget-tagcloud';
			$name		= esc_html__('CATANIS - Tag Cloud', 'onelove');
			$widget_options = array(
				'classname' 	=> 'cata-widget cata-widget-tag-cloud',
				'description' 	=> esc_html__('This Tag Cloud widget present your tag', 'onelove')
			);
			$control_options = array( 'width' => '250px' );
			parent::__construct($id_base, $name, $widget_options, $control_options );
			
			$this->_woo_actived = catanis_is_woocommerce_active() ? true : false;
			$this->_ins_default = array( 
				'title'				=> esc_html__( 'Tag', 'onelove' ),
				'post_tag' 			=> 1, 
				'category' 			=> 0, 
				'product_tag' 		=> 1, 
				'product_cat' 		=> 0, 
				'smallest' 			=> 9,
				'largest' 			=> 14,
				'orderby' 			=> 'name',
				'order' 			=> 'ASC',
				'is_flashmode' 		=> 1, 
				'bg_color' 			=> '#FFFFFF',
				'bg_transparent' 	=> 1,
				'tag_color' 		=> '#333333', 
				'outline_color' 	=> '#000000', 
				'number' 			=> 12 
			);
		}

		function getCount( $tags_list, $averNumber, $args){
			$counts = array();
			$real_counts = array();
			
			foreach ( (array) $tags_list as $key => $tag ) {
				if($key < $averNumber){
					$real_counts[ $key ] = $tag->count;
					$counts[ $key ] = call_user_func( $args['topic_count_scale_callback'], $tag->count );
				}
			}
			
			return array('real_counts' => $real_counts, 'counts' => $counts);
		}
		
		function widget( $args, $instance ) {
			
			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
			
			if (!$this->_woo_actived) {
				$instance['product_tag'] = 0;
				$instance['product_cat'] = 0;
			}
			
			$arrTaxonomy	= array();
			if( $instance['product_tag'] ) $arrTaxonomy['product_tag'] = 'product_tag';
			if( $instance['product_cat'] ) $arrTaxonomy['product_cat'] = 'product_cat';
			if( $instance['post_tag'] ) $arrTaxonomy['post_tag'] = 'post_tag';
			if( $instance['category'] ) $arrTaxonomy['category'] = 'category';
			
			$smallest 		= !empty( $instance['smallest'] ) ? absint( $instance['smallest'] ) : $this->_ins_default['smallest'];
			$largest 		= !empty( $instance['largest'] ) ? absint( $instance['largest'] ) : $this->_ins_default['largest'];
			$orderby 		= !empty($instance['orderby']) ? trim( $instance['orderby'] ) : $this->_ins_default['orderby'];
			$order 			= !empty($instance['order']) ? trim( $instance['order'] ) : $this->_ins_default['order'];
			$is_flashmode 	= ( $instance['is_flashmode'] ) ? 1 : 0;
			
			$bg_color 		= empty( $instance['bg_color'] ) ? $this->_ins_default['bg_color'] : $instance['bg_color'];
			$bg_color 		= ( $instance['bg_transparent'] ) ? 'transparent' : $bg_color;
			$tag_color 		= empty( $instance['tag_color'] ) ? $this->_ins_default['tag_color'] : $instance['tag_color'];
			$outline_color = empty( $instance['outline_color'] ) ? $this->_ins_default['outline_color'] : $instance['outline_color'];
			$number 		= empty( $instance['number'] ) ? $this->_ins_default['number'] : absint( $instance['number']);
			
			if(empty($arrTaxonomy)) return;
			
			echo $before_widget . $before_title . $title . $after_title;
			$args = array(
				'smallest'                  => $smallest,
				'largest'                   => $largest,
				'unit'                      => 'px',
				'number'                    => $number,
				'format'                    => 'flat',
				'orderby'                   => $orderby,
				'order'                     => $order,
				'link'                      => 'view',
				'taxonomy'                  => array_keys( $arrTaxonomy ),
				'echo'                      => false,
				'topic_count_scale_callback' => 'default_topic_count_scale'
			);
			if(function_exists( 'wp_tag_cloud')){
				$tagCloud = wp_tag_cloud($args);
			}else{
				$tagCloud = '';
				$averNumber = round( $number/count( $arrTaxonomy ) );
				
				/*===  Post Tag ===*/
				$tags_list 	= get_tags();
				$result 	= $this->getCount( $tags_list, $averNumber, $args );
				$counts 	= $result['counts'];
				$real_counts = $result['real_counts'];
					
				if(!empty($counts) && !empty($real_counts) ){	
					
					$min_count 	= min( $counts );
					$spread 	= max( $counts ) - $min_count;
					if ( $spread <= 0 ) {
						$spread = 1; 
					}
					
					$font_spread = $largest - $smallest; 
					if ( $font_spread < 0 ) {
						$font_spread = 1;
					}
					$font_step = $font_spread / $spread; 
					
					$post_tags = '';
					if ( isset( $arrTaxonomy['post_tag'] ) ) {
						foreach( $tags_list as $key => $tag ) {
							if ( $key < $averNumber ) {
								$count 		= $counts[ $key ];
								$title 		= ( $real_counts[$key] == 1) ? '1 ' .esc_html__('post','onelove') : $real_counts[$key] . esc_html__('posts','onelove');
								$fontSize 	= str_replace( ',', '.', ( $smallest + ( ( $count - $min_count ) * $font_step ) ) );
								$post_tags 	.= '<a href="' . esc_url( get_term_link( $tag ) ).'" style="font-size: ' . esc_attr($fontSize) . 'px;" title="' . esc_attr($title) . ' topics">' . $tag->name . '</a>';
							}
						}
					}
					$tagCloud .= $post_tags;
				}
					
				/*===  Post Category ===*/
				$tags_list = get_categories();
				$result 	= $this->getCount( $tags_list, $averNumber, $args);
				$counts 	= $result['counts'];
				$real_counts = $result['real_counts'];
					
				if(!empty($counts) && !empty($real_counts) ){
					
					$min_count 	= min( $counts );
					$spread 	= max( $counts ) - $min_count;
					if($spread <= 0 ) {
						$spread = 1;
					}
					
					$font_spread = $largest - $smallest;
					if($font_spread < 0 ) {
						$font_spread = 1;
					}
					$font_step = $font_spread / $spread;
					
					$post_cats = '';
					if ( isset( $arrTaxonomy['category'] ) ) {
						foreach ( $tags_list as $key => $tag ){
							if ( $key < $averNumber ) {
								$count 		= $counts[ $key ];
								$title 		= ( $real_counts[$key] == 1 ) ? '1 ' . esc_html__('post', 'onelove') : $real_counts[$key] . ' ' . esc_html__('posts', 'onelove');
								$fontSize 	= str_replace( ',', '.', ( $smallest + ( ( $count - $min_count ) * $font_step ) ) );
								$post_cats 	.= '<a href="' . esc_url( get_term_link( $tag ) ).'" style="font-size: ' . esc_attr($fontSize) . 'px;" title="' . esc_attr($title) . ' topics">' . $tag->name . '</a>';
							}
						}
					}
					$tagCloud .= $post_cats;
				}
				
				/*===  Product Tag ===*/
				if ( catanis_is_woocommerce_active() ){
					$tags_list  = get_categories( array( 'taxonomy' => 'product_tag' ) );
					$result 	= $this->getCount( $tags_list, $averNumber, $args );
					$counts 	= $result['counts'];
					$real_counts = $result['real_counts'];
					
					if(!empty($counts) && !empty($real_counts) ){	
						$min_count 	= min( $counts );
						$spread 	= max( $counts ) - $min_count;
						if ( $spread <= 0 ) $spread = 1;
						$font_spread = $largest - $smallest;
						if ( $font_spread < 0 ) $font_spread = 1;
						$font_step = $font_spread / $spread;
						
						$product_tags = '';
						if ( isset( $arrTaxonomy['product_tag'] ) ) {
							foreach ( $tags_list as $key => $tag ) {
								if ( $key < $averNumber ) {
									$count 		= $counts[ $key ];
									$title 		= ($real_counts[$key] == 1) ? '1 ' .esc_html__('post','onelove') : $real_counts[$key] .' ' . esc_html__('posts','onelove');
									$fontSize 	= str_replace( ',', '.', ( $smallest + ( ( $count - $min_count ) * $font_step )));
									$product_tags 	.= '<a href="'.esc_url(get_term_link($tag)).'" style="font-size: '. esc_attr($fontSize) .'px;" title="'. esc_attr($title) .' topics">' . $tag->name . '</a>';
								}
							}
						}
						$tagCloud .= $product_tags;
					}
				}
		
				/*===  Product Category ===*/
				if ( catanis_is_woocommerce_active() ){
					$tags_list  = get_categories( array( 'taxonomy' => 'product_cat' ) );
					$result 	= $this->getCount( $tags_list, $averNumber, $args );

					$counts 	= $result['counts'];
					$real_counts = $result['real_counts'];
						
					if(!empty($counts) && !empty($real_counts) ){
						
						$min_count 	= min( $counts );
						$spread 	= max( $counts ) - $min_count;
						if ( $spread <= 0 ) $spread = 1;
						$font_spread = $largest - $smallest;
						if ( $font_spread < 0 ) $font_spread = 1;
						$font_step = $font_spread / $spread;
						
						$product_cats = '';
						if ( isset( $arrTaxonomy['product_cat'] ) ) {
							foreach ( $tags_list as $key => $tag ) {
								if ( $key < $averNumber ) {
									$count 		= $counts[ $key ];
									$title 		= ( $real_counts[$key] == 1 ) ? '1 ' .esc_html__('post','onelove') : $real_counts[$key] .' ' . esc_html__('posts', 'onelove' );
									$fontSize 	= str_replace( ',', '.', ( $smallest + ( ( $count - $min_count ) * $font_step ) ) );
									$product_cats 	.= '<a href="' . esc_url( get_term_link( $tag ) ).'" style="font-size: ' . esc_attr($fontSize) . 'px;" title="' . esc_attr($title) . ' topics">' . $tag->name . '</a>';
								}
							}
						}
						$tagCloud .= $product_cats;
					}
				}
			}
			
			if(!empty($tagCloud)){
				$random_id =  'cata_tagcloud_' . mt_rand( 0, 1000 );
				$arrParams = array(
				 	'shape' 			=> 'vcylinder',
			 		'textColour'		=> $tag_color,
			 		'outlineColour' 	=> $outline_color, //#e6b1b
			 		'outlineThickness' 	=> 1,
			 		'reverse' 			=> true,
			 		'wheelZoom' 		=> false,
			 		'depth' 			=> 0.8,
			 		'maxSpeed' 			=> 0.03
				);
				
				if ($is_flashmode) : ?>
					<div id="<?php echo esc_attr($random_id); ?>" class="cata-widget-tag-cloud-wraper" style="background-color: <?php echo esc_attr($bg_color); ?>" data-params='<?php echo json_encode($arrParams); ?>'>
						<canvas width="350" height="350" id="abc<?php echo esc_attr($random_id); ?>">
					  		<p><?php esc_html_e('In Internet Explorer versions up to 8, things inside the canvas are inaccessible!','onelove'); ?></p>
					 	</canvas>
					</div><div id="cata_tags"><?php echo trim($tagCloud); ?></div>
				<?php else: ?>
					<div id="<?php echo esc_attr($random_id); ?>" class="cata-widget-tag-cloud-wraper widget_tag_cloud no_flash">
						<div class="tagcloud"> <?php echo trim($tagCloud); ?></div>
					</div>
				<?php endif; 
			}else{
				esc_html_e('Tags empty', 'onelove');
			}
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] 			= strip_tags( $new_instance['title'] );
			$instance['post_tag'] 		= $new_instance['post_tag'];
			$instance['category'] 		= $new_instance['category'];
			$instance['product_tag'] 	= $new_instance['product_tag'];
			$instance['product_cat'] 	= $new_instance['product_cat'];
			$instance['smallest'] 		= absint($new_instance['smallest'] );
			$instance['largest'] 		= absint($new_instance['largest'] );
			$instance['orderby'] 		= $new_instance['orderby'];
			$instance['order'] 			= $new_instance['order'];
			$instance['is_flashmode'] 	= $new_instance['is_flashmode'];
			$instance['bg_color'] 		= strip_tags( $new_instance['bg_color'] );
			$instance['bg_transparent'] = strip_tags( $new_instance['bg_transparent'] );
			$instance['tag_color'] 		= strip_tags( $new_instance['tag_color'] );
			$instance['outline_color'] = strip_tags( $new_instance['outline_color'] );
			$instance['number'] 		= absint( $new_instance['number'] );
			
			if( $instance['largest'] < $instance['smallest'] ) {
				$instance['largest'] = $instance['smallest'];
			}
			
			return $instance;
		}

		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->_ins_default );
			$htmlObj 	= new Catanis_Widget_Html();
			$xhtml 		= '';
			
			/* Element title*/
			$inputID 	= $this->get_field_id( 'title' );
			$inputName 	= $this->get_field_name( 'title' );
			$inputValue = esc_attr( $instance['title'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
				$htmlObj->labelTag( esc_html__('Title', 'onelove' ), array( 'for' => $inputID ) )
				.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
			);

			/* Element post_tag*/
			$inputID 	= $this->get_field_id('post_tag');
			$inputName 	= $this->get_field_name('post_tag');
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts 		= array( 'current_value' => $instance['post_tag'] );
			$xhtml 		.= $htmlObj->generalItem(
				$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
				.$htmlObj->labelTag( esc_html__('Post Tag', 'onelove'), array('for' => $inputID ), true)
			);

			/* Element post_cat*/
			$inputID 	= $this->get_field_id( 'category' );
			$inputName 	= $this->get_field_name( 'category' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts 		= array( 'current_value' => $instance['category']);
			$xhtml 		.= $htmlObj->generalItem(
				$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
				.$htmlObj->labelTag( esc_html__('Post Category', 'onelove' ), array( 'for' => $inputID ), true)
			);

			if ( $this->_woo_actived ) {
				
				/* Element prod_cat*/
				$inputID 	= $this->get_field_id( 'product_tag' );
				$inputName 	= $this->get_field_name( 'product_tag' );
				$inputValue = 1;
				$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
				$opts 		= array( 'current_value' => $instance['product_tag'] );
				$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Product Tag', 'onelove'), array('for' => $inputID ), true )
				);

				/* Element post_cat*/
				$inputID 	= $this->get_field_id( 'product_cat' );
				$inputName 	= $this->get_field_name( 'product_cat' );
				$inputValue = 1;
				$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
				$opts 		= array( 'current_value' => $instance['product_cat'] );
				$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Product Category', 'onelove'), array( 'for' => $inputID ), true )
				);
			}
			
			/* Element smallest*/
			$inputID 	= $this->get_field_id( 'smallest' );
			$inputName 	= $this->get_field_name( 'smallest' );
			$inputValue = absint( $instance['smallest'] );
			$arr 		= array('class' => 'small-text', 'id' => $inputID );
			$smallest   = $htmlObj->labelTag( esc_html__('Min', 'onelove'), array( 'for' => $inputID ) )
						  .$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number' ) );

			/* Element largest*/
			$inputID 	= $this->get_field_id( 'largest' );
			$inputName 	= $this->get_field_name( 'largest' );
			$inputValue = absint( $instance['largest'] );
			$arr 		= array( 'class' => 'small-text', 'id' => $inputID );
			$largest    = $htmlObj->labelTag( esc_html__('Max', 'onelove' ), array( 'for' => $inputID ) )
						  .$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number' ) );

			$xhtml .= $htmlObj->labelTag(esc_html__('Font size', 'onelove'), array( 'for' => $inputID ) )
						.$htmlObj->generalItem( $smallest .'&nbsp;&nbsp;' . $largest );

			/* Element orderby*/
			$inputID 	= $this->get_field_id( 'orderby' );
			$inputName 	= $this->get_field_name( 'orderby' );
			$inputValue = esc_attr( $instance['orderby'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts 		= array( 'data' => array( 'name' => 'Name', 'count' => 'Count' ) );
			$xhtml 		.= $htmlObj->generalItem(
				$htmlObj->labelTag( esc_html__('Order of the tags', 'onelove' ), array( 'for' => $inputID ) )
				.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);

			/* Element order*/
			$inputID 	= $this->get_field_id( 'order' );
			$inputName 	= $this->get_field_name( 'order' );
			$inputValue = esc_attr( $instance['order'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts 		= array( 'data' => array( 'ASC' => 'ASC', 'DESC' => 'DESC', 'RAND' => 'RAND' ) );
			$xhtml 		.= $htmlObj->generalItem(
				$htmlObj->labelTag( esc_html__('Sort order', 'onelove' ), array( 'for' => $inputID ) )
				.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts)
			);

			/* Element number*/
			$inputID 	= $this->get_field_id( 'number' );
			$inputName 	= $this->get_field_name( 'number' );
			$inputValue = @absint( $instance['number'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
				$htmlObj->labelTag( esc_html__('Number of Tag (average post type above)', 'onelove' ), array( 'for' => $inputID ) )
				.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number' ) )
			);

			$xhtml .= $htmlObj->infoText( esc_html__('Flash mode Options', 'onelove' ) );

			/* Element is_flashmode*/
			$inputID 	= $this->get_field_id( 'is_flashmode' );
			$inputName 	= $this->get_field_name( 'is_flashmode' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts 		= array( 'current_value' => $instance['is_flashmode'] );
			$xhtml 		.= $htmlObj->generalItem(
				$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
				.$htmlObj->labelTag( esc_html__('Flash mode', 'onelove'), array( 'for' => $inputID ), true)
			);

			/* Element bg_color*/
			$inputID 	= $this->get_field_id( 'bg_color' );
			$inputName 	= $this->get_field_name( 'bg_color' );
			$inputValue = esc_attr( $instance['bg_color'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Background color (Ex: #FFFFFF )','onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
			);

			/* Element bg_transparent*/
			$inputID 	= $this->get_field_id( 'bg_transparent' );
			$inputName 	= $this->get_field_name( 'bg_transparent' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts 		= array( 'current_value' => $instance['bg_transparent'] );
			$xhtml 		.= $htmlObj->generalItem(
				$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
				.$htmlObj->labelTag( esc_html__('Background transparent', 'onelove'), array( 'for' => $inputID ), true )
			);

			/* Element tag_color*/
			$inputID 	= $this->get_field_id( 'tag_color' );
			$inputName 	= $this->get_field_name( 'tag_color' );
			$inputValue = esc_attr( $instance['tag_color'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
				$htmlObj->labelTag( esc_html__('Tag color (Ex: #FFFFFF )', 'onelove' ), array( 'for' => $inputID ) )
				.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr )
			);

			/* Element outline_color*/
			$inputID 	= $this->get_field_id( 'outline_color' );
			$inputName 	= $this->get_field_name( 'outline_color' );
			$inputValue = esc_attr( $instance['outline_color'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
				$htmlObj->labelTag( esc_html__('Outline color (Ex: #FFFFFF )', 'onelove'), array('for' => $inputID ) )
				.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr)
			);

			echo trim($xhtml); 
		}
	}
}
?>