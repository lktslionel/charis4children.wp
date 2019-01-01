<?php
if(!class_exists('Catanis_Widget_Tab_Post')){
	class Catanis_Widget_Tab_Post extends WP_Widget {

		private $_ins_default = array();
		
		function __construct() {
			$id_base 	= 'catanis-widget-tab-post';
			$name		= esc_html__('CATANIS - Tabs Post','onelove');
			$widget_options = array(
				'classname' 	=> 'cata-widget cata-widget-tabs-post',
				'description' 	=> esc_html__('The widget display popular posts, recent posts, comments, and tags in tabbed format.', 'onelove')
			);
			$control_options = array('width' => '250px');
			parent::__construct( $id_base, $name, $widget_options, $control_options );
				
			$this->_ins_default = array(
				'title' 		=> '',
				'tabs' 			=> array( 'recent' => 1, 'popular' => 1, 'comments' => '0', 'tags' => '0'),
				'tab_order' 	=> array( 'recent' => 1, 'popular' => 2, 'comments' => 3, 'tags' => 4),
				'post_num' 		=> '5',
				'show_thumb' 	=> 1,
				'thumb_size' 	=> 'small',
				'show_date' 	=> 1,
				'show_comment' 	=> 1,
				'show_excerpt' 	=> 0,
				'excerpt_length' => '15',
				'show_avatar' 	=> 1
			);
			
			add_action('wp_ajax_cata_tab_post_widget_content', array(&$this, 'catanis_ajax_tab_post_widget_content'));
			add_action('wp_ajax_nopriv_cata_tab_post_widget_content', array(&$this, 'catanis_ajax_tab_post_widget_content'));
		}
		
		public function catanis_ajax_tab_post_widget_content() {
			$tab 	= $_POST['tab'];
			$args 	= $_POST['args'];
			if ( !is_array( $args ) ) {
				return '';
			}
			
			$post_num = ( empty( $args['post_num'] ) ? 5 : intval( $args['post_num'] ) );
			if ($post_num > 20 || $post_num < 1) { 
				$post_num = 3;
			}
		
			$show_thumb = !empty( $args['show_thumb'] );
			$thumb_size = $args['thumb_size'];
			
			if ( $thumb_size != 'small' && $thumb_size != 'large') {
				$thumb_size = 'small';
			}
			$show_date 		= !empty( $args['show_date'] );
			$show_comment 	= !empty( $args['show_comment'] );
			$show_excerpt 	= !empty( $args['show_excerpt'] );
			$show_avatar 	= !empty( $args['show_avatar'] );
			$excerpt_length = ( empty( $args['excerpt_length'] ) ? 5 : intval( $args['excerpt_length'] ) );
			if ( $excerpt_length > 100 || $post_num < 1) { 
				$excerpt_length = 15;
			}
			
			global $post;
			switch ($tab) {
				case "popular": ?>
					<ul class="cata-thumb-<?php echo esc_attr($thumb_size); ?>">						
						<?php 
						$popular = new WP_Query( array( 'ignore_sticky_posts' => 1, 'posts_per_page' => $post_num, 'post_status' => 'publish', 'orderby' => 'meta_value_num', 'meta_key' => '_cata_post_views_count', 'order' => 'desc'));
						$last_page = $popular->max_num_pages;      
						while ( $popular->have_posts() ) : $popular->the_post(); 
						?>	
							<li class="cata-item">
								
								<?php if ( $show_thumb) : ?>					
									<div class="cata-post-thumbnail">
										<a class="cata-effect-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
											<?php if( has_post_thumbnail() ) : 
												the_post_thumbnail( 'medium', array( 'alt' => esc_html(get_the_title()) ) ) ; ?>		
											<?php else: ?>							
												<img src="<?php echo esc_url(CATANIS_FRONT_IMAGES_URL .'default/'. $thumb_size.'thumb.png'); ?>" alt="<?php the_title(); ?>" class="wp-post-image" />					
											<?php endif; ?>
										</a>
									</div>
								<?php endif; ?>			
										
								<div class="cata-post-meta">
									<div class="cata-entry-title"><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>	
									
									<?php if ( $show_date || $show_comment ) : ?>	
									<div class="cata-info-detail">
										<?php if( isset( $show_comment) && $show_comment ): ?>
										<span class="comments-count"> 
											<?php 
												$comments_count = wp_count_comments( $post->ID ); 
												if( $comments_count->approved < 10 && $comments_count->approved > 0) echo '0'; 
												echo absint($comments_count->approved); ?>
										</span>
										<?php endif; ?>
							
										<?php if( isset( $show_date ) && $show_date ): ?>
											<span class="date-time"><?php echo get_the_date('M d, Y') ?></span>
										<?php endif; ?>
									</div>
									<?php endif;?>
									
									<?php if( $show_excerpt ): ?>
									<div class="cata-entry-desc"> 
										<?php echo catanis_string_limit_words( apply_filters( 'get_the_excerpt', $post->post_excerpt ), $excerpt_length, '...');?>
									</div>
									<?php endif; ?>
								</div>
	                            	
							<div class="clear"></div>		
						</li>				
						<?php endwhile; wp_reset_postdata(); ?>		
					</ul>
	                <div class="clear"></div>
				<?php           
				break;              
				case "recent": ?>         
					<ul class="cata-thumb-<?php echo esc_attr($thumb_size); ?>">			
						<?php   
						$recent = new WP_Query('posts_per_page=' . $post_num . '&orderby=post_date&order=desc&post_status=publish' );       
						$last_page = $recent->max_num_pages;      
						while ( $recent->have_posts() ) : $recent->the_post();   
						?>						         
							<li class="cata-item">
								
								<?php if ( $show_thumb) : ?>					
									<div class="cata-post-thumbnail">
										<a class="cata-effect-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
											<?php if( has_post_thumbnail() ) : 
												the_post_thumbnail( 'medium', array( 'alt' => esc_html(get_the_title()) ) ) ; ?>		
											<?php else: ?>							
												<img src="<?php echo esc_url(CATANIS_FRONT_IMAGES_URL .'default/'. $thumb_size.'thumb.png'); ?>" alt="<?php the_title(); ?>" class="wp-post-image" />					
											<?php endif; ?>
										</a>
									</div>
								<?php endif; ?>			
										
								<div class="cata-post-meta">
									<div class="cata-entry-title"><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>	
									
									<?php if ( $show_date || $show_comment ) : ?>	
									<div class="cata-info-detail">
										<?php if( isset( $show_comment) && $show_comment ): ?>
										<span class="comments-count"> 
											<?php 
												$comments_count = wp_count_comments( $post->ID ); 
												if( $comments_count->approved < 10 && $comments_count->approved > 0) echo '0'; 
												echo absint($comments_count->approved); ?>
										</span>
										<?php endif; ?>
							
										<?php if( isset( $show_date ) && $show_date ): ?>
											<span class="date-time"><?php echo get_the_date('M d, Y') ?></span>
										<?php endif; ?>
									</div>
									<?php endif;?>
									
									<?php if( $show_excerpt ): ?>
									<div class="cata-entry-desc"> 
										<?php echo catanis_string_limit_words( apply_filters( 'get_the_excerpt', $post->post_excerpt ), $excerpt_length, '...');?>
									</div>
									<?php endif; ?>
								</div>
	                            	
							<div class="clear"></div>		
						</li>				
						<?php endwhile; wp_reset_postdata(); ?>		
					</ul>
	                <div class="clear"></div>
				<?php       
				break;     
				case "comments": ?>          
					<ul>            
						<?php         
						$avatar_size = 70;            
						$comments_query = new WP_Comment_Query();   
						$comments = $comments_query->query( array( 'number' => $post_num, 'offset' => 0, 'status' => 'approve' ) );    
						if ( $comments ) : foreach ( $comments as $comment ) : ?>       
						<li class="cata-item">
							<blockquote class="comment-body"><?php echo catanis_string_limit_words( strip_tags( apply_filters( 'get_comment_text', $comment->comment_content ) ), 15 ); ?></blockquote>
							
							<?php if ( $show_avatar ): ?>
							<div class="cata-avatar"><a href="<?php echo get_comment_link( $comment->comment_ID ); ?>"><?php echo get_avatar( $comment->comment_author_email, 70 ); ?></a></div>
							<?php endif; ?>
							
							<div class="cata-info">
								<a href="<?php echo get_comment_link( $comment->comment_ID ); ?>" rel="external nofollow">   
									<span class="cata-author"><?php echo get_comment_author( $comment->comment_ID ); ?> </span>
								 </a>
								
								<?php if( $show_date ): ?>
								<span class="cata-date"><?php echo date(get_option('date_format'), strtotime($comment->comment_date ) ); ?></span>
								<?php endif; ?>
							</div>
							<div class="clear"></div>      
						</li>
								           
						<?php endforeach; else : ?>           
						<li>                   
							<div class="no-comments"><?php esc_html_e('No comments yet.', 'onelove'); ?></div>        
						</li>                             
						<?php endif; ?>       
					</ul>   
					<div class="clear"></div>    
				<?php           
				break;             
			    case "tags":  ?>           
					<?php        
						$tags = get_tags( array( 'get'=>'all', 'number' => 20 ) );             
						if($tags) {               
							foreach ($tags as $tag): ?>    
								<a href="<?php echo get_term_link($tag); ?>"><?php echo esc_html($tag->name); ?></a>          
								<?php            
							endforeach;       
						} else {          
							esc_html_e('No tags created.', 'onelove');           
						}            
					?>           
				<?php            
				break;            
			}              
			die(); 
		}
				
		function widget( $args, $instance ) {
			
			extract( $args );
			$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : $this->_ins_default['title'], $instance, $this->id_base );
			$tabs 			= !empty( $instance['tabs'] ) ? $instance['tabs'] : $this->_ins_default['tabs'];
			$tab_order 		= !empty( $instance['tab_order'] ) ? $instance['tab_order'] : $this->_ins_default['tab_order'];
			$post_num 		= !empty( $instance['post_num'] ) ? $instance['post_num'] : $this->_ins_default['post_num'];
			$show_thumb 	= ( $instance['show_thumb'] ) ? $this->_ins_default['show_thumb'] : 0;
			$thumb_size 	= !empty( $instance['thumb_size'] ) ? $instance['thumb_size'] : $this->_ins_default['thumb_size'];
			$show_date 		= ( $instance['show_date'] ) ? $this->_ins_default['show_date'] : 0;
			$show_comment 	= ( $instance['show_comment'] ) ? $this->_ins_default['show_comment'] : 0;
			$show_avatar 	= ( $instance['show_avatar'] ) ? $this->_ins_default['show_avatar'] : 0;
			$show_excerpt 	= ( $instance['show_excerpt'] ) ? $this->_ins_default['show_excerpt'] : 0;
			$excerpt_length	= !empty( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : $this->_ins_default['excerpt_length'];
			
			$tabs_count = (int)count($tabs);
			$available_tabs = array(
				'popular' 	=> esc_html__('Popular', 'onelove'),
				'recent' 	=> esc_html__('Recent', 'onelove'),
				'comments' 	=> esc_html__('Comments', 'onelove'),
				'tags' 		=> esc_html__('Tags', 'onelove')
			);
			
			array_multisort( $tab_order, $available_tabs);
			
			unset( $instance['tabs'], $instance['tab_order'] );
			echo $before_widget;
			if( !empty( $title ) ){ 
				echo $before_title . $title . $after_title; 
			}
			
			global $post;
			?>
			<div class="cata-tab-post-widget-content" id="cata_tabs_post<?php echo mt_rand(); ?>_content" data-args='<?php echo json_encode( $instance ); ?>'>	
				<ul class="cata-tabs <?php echo "has-$tabs_count-"; ?>tabs">
					<?php foreach ( $available_tabs as $tab => $label ) : ?>
			        	<?php if ( ! empty( $tabs[ $tab ] ) ): ?>
			            		<li class="tab_title"><a href="#" id="<?php echo esc_attr($tab); ?>-tab"><?php echo esc_html( $label ); ?></a></li>	
			        	<?php endif; ?>
					<?php endforeach; ?> 
				</ul> 
				<div class="clear"></div>  
				
				<div class="cata-tabs-content">        
					<?php if ( ! empty( $tabs['popular'] ) ): ?>	
					<div id="popular-tab-content" class="tab-content cata-widget-recent-posts">	
						<div class="tab-content-wrapper"> </div>	
					</div>      
					<?php endif; ?>  
					     
					<?php if ( ! empty( $tabs['recent'] ) ) : ?>	
					<div id="recent-tab-content" class="tab-content cata-widget-recent-posts"> 	
						<div class="tab-content-wrapper"></div>		 
					</div> 
					<?php endif; ?>     
					                
					<?php if ( ! empty( $tabs['comments'] ) ) : ?>      
					<div id="comments-tab-content" class="tab-content cata-widget-recent-comments"> 	
						<div class="tab-content-wrapper"> </div>		
					</div>    
					<?php endif; ?>   
					         
					<?php if ( ! empty( $tabs['tags'] ) ): ?>       
					<div id="tags-tab-content" class="tab-content cata-widget-tag-cloud"> 	
						<div class="tab-content-wrapper tagcloud"> </div>		
					</div> 
					<?php endif; ?>	
					
					<div class="clear"></div>	
				</div> <!--end .inside -->	
				
				<div class="clear"></div>
			</div> 
			<?php 
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {

			$instance = $old_instance;
			$instance['title'] 			= strip_tags($new_instance['title']);
			$instance['tabs'] 			= $new_instance['tabs'];
			$instance['tab_order'] 		= $new_instance['tab_order'];
			$instance['post_num'] 		= $new_instance['post_num'];
			$instance['show_thumb'] 	= $new_instance['show_thumb'];
			$instance['thumb_size'] 	= $new_instance['thumb_size'];
			$instance['show_date'] 		= $new_instance['show_date'];
			$instance['show_comment'] 	= $new_instance['show_comment'];
			$instance['show_excerpt'] 	= $new_instance['show_excerpt'];
			$instance['excerpt_length'] = $new_instance['excerpt_length'];
			$instance['show_avatar'] 	= $new_instance['show_avatar'];
			
			return $instance;
		}

		function form( $instance ) {
			
			$instance 	= wp_parse_args( (array) $instance, $this->_ins_default );
			$htmlObj 	= new Catanis_Widget_Html();
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

			/* Element tab popular*/
			$inputID 	= $this->get_field_id( 'tabs' ) . '_popular';
			$inputName 	= $this->get_field_name( 'tabs' ) . '[popular]';
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => absint( @$instance['tabs']['popular'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Popular Tab', 'onelove'), array( 'for' => $inputID ), true),
					array('style' => 'display: inline-block; width: 50%; margin-bottom: 0;' )
			);
			
			/* Element tab recent*/
			$inputID 	= $this->get_field_id('tabs').'_recent';
			$inputName 	= $this->get_field_name('tabs').'[recent]';
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array('current_value'=> absint(@$instance['tabs']['recent']));
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control('checkbox',$inputName,$inputValue,$arr, $opts)
					.$htmlObj->labelTag(esc_html__('Recent Tab','onelove'), array('for'=>$inputID), true),
					array('style' => 'display: inline-block;width: 50%;margin-bottom: 0;')
			);
			
			/* Element tab comments*/
			$inputID 	= $this->get_field_id( 'tabs' ) . '_comments';
			$inputName 	= $this->get_field_name( 'tabs' ) . '[comments]';
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => absint( @$instance['tabs']['comments'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__( 'Comments Tab', 'onelove' ), array('for' => $inputID ), true),
					array( 'style' => 'display: inline-block; width: 50%; margin-bottom: 0;')
			);
			
			/* Element tab comments*/
			$inputID 	= $this->get_field_id( 'tabs' ) . '_tags';
			$inputName 	= $this->get_field_name( 'tabs' ) . '[tags]';
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array('current_value'=> absint( @$instance['tabs']['tags'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Tags Tab', 'onelove' ), array('for' => $inputID ), true),
					array( 'style' => 'display: inline-block; width: 50%; margin-bottom: 0;')
			);
			
			$xhtml .= $htmlObj->infoText( esc_html__('Tabs Order Options', 'onelove' ) );
			
			/* Element tab_order popular*/
			$inputID 	= $this->get_field_id( 'tab_order' ) . '_popular';
			$inputName 	= $this->get_field_name( 'tab_order' ) . '[popular]';
			$inputValue = esc_attr($instance['tab_order']['popular']);
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID, 'style' => 'width: 50px;' );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'textbox',$inputName,$inputValue,$arr, array( 'type' => 'number', 'min' => '1' ) )
					.$htmlObj->labelTag( esc_html__('Popular', 'onelove' ), array( 'for' => $inputID ), true ),
					array( 'style' => 'display: inline-block; width: 50%; margin-top: 0;' )
			);
			
			/* Element tab_order recent*/
			$inputID 	= $this->get_field_id( 'tab_order' ) . '_recent';
			$inputName 	= $this->get_field_name( 'tab_order' ) . '[recent]';
			$inputValue = esc_attr($instance['tab_order']['recent']);
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID, 'style' => 'width: 50px;' );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array('type' => 'number', 'min' => '1' ) )
					.$htmlObj->labelTag( esc_html__('Recent', 'onelove'), array( 'for' => $inputID ), true ),
					array( 'style' => 'display: inline-block; width: 50%; margin-top: 0;')
			);
			
			/* Element tab_order comments*/
			$inputID 	= $this->get_field_id( 'tab_order' ) . '_comments';
			$inputName 	= $this->get_field_name( 'tab_order' ) . '[comments]';
			$inputValue = esc_attr($instance['tab_order']['comments']);
			$arr 		= array('class' => 'widefat', 'id' => $inputID, 'style' => 'width: 50px;' );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number', 'min' => '1' ) )
					.$htmlObj->labelTag( esc_html__('Comments', 'onelove'), array( 'for' => $inputID ), true ),
					array( 'style' => 'display: inline-block; width: 50%; margin-top: 0;')
			);
				
			/* Element tab_order comments*/
			$inputID 	= $this->get_field_id( 'tab_order' ) . '_tags';
			$inputName 	= $this->get_field_name( 'tab_order' ) . '[tags]';
			$inputValue = esc_attr( $instance['tab_order']['tags'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID, 'style' => 'width: 50px;' );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number', 'min' => '1' ) )
					.$htmlObj->labelTag( esc_html__('Tags', 'onelove' ), array( 'for' => $inputID ), true ),
					array( 'style' => 'display: inline-block;width: 50%;margin-top: 0;')
			);
			
			$xhtml .= $htmlObj->infoText( esc_html__('Advanced Options', 'onelove' ) );
			
			/* Element post_num*/
			$inputID 	= $this->get_field_id( 'post_num' );
			$inputName 	= $this->get_field_name( 'post_num' );
			$inputValue = esc_attr( $instance['post_num'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Number of posts to show', 'onelove' ), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number', 'min' => '1' ) )
			);

			/* Element show_thumb*/
			$inputID 	= $this->get_field_id( 'show_thumb' );
			$inputName 	= $this->get_field_name( 'show_thumb' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => absint( @$instance['show_thumb'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Show thumbnail', 'onelove'), array( 'for' => $inputID ), true )
			);
			
			/* Element thumb_size*/
			$inputID 	= $this->get_field_id( 'thumb_size' );
			$inputName 	= $this->get_field_name( 'thumb_size' );
			$inputValue = esc_attr( $instance[ 'thumb_size']);
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID, 'style'=>' width: 140px; margin-left: 10px;' );
			$opts 		= array( 'data' => array( 'small' => esc_html__('Small', 'onelove'), 'large' => esc_html__('Large','onelove' ) ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Thumbnail size', 'onelove'), array('for' => $inputID ) )
					.$htmlObj->control( 'selectbox', $inputName, $inputValue, $arr, $opts )
			);
			
			/* Element show_date*/
			$inputID 	= $this->get_field_id( 'show_date' );
			$inputName 	= $this->get_field_name( 'show_date' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => absint( @$instance['show_date'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show date', 'onelove'), array( 'for' => $inputID ), true )
			);
			
			/* Element show comment*/
			$inputID 	= $this->get_field_id( 'show_comment' );
			$inputName 	= $this->get_field_name( 'show_comment' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => absint( @$instance['show_comment'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts)
					.$htmlObj->labelTag( esc_html__('Show comment count', 'onelove'), array( 'for' => $inputID ), true)
			);

			/* Element show_excerpt*/
			$inputID 	= $this->get_field_id( 'show_excerpt' );
			$inputName 	= $this->get_field_name( 'show_excerpt' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => absint( @$instance['show_excerpt'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show excerpt', 'onelove'), array('for' => $inputID ), true )
			);

			/* Element excerpt_length*/
			$inputID 	= $this->get_field_id( 'excerpt_length' );
			$inputName 	= $this->get_field_name( 'excerpt_length' );
			$inputValue = esc_attr($instance['excerpt_length'] );
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID, 'style' => ' width: 90px;  margin-left: 10px;');
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->labelTag( esc_html__('Excerpt length (words)', 'onelove'), array( 'for' => $inputID ) )
					.$htmlObj->control( 'textbox', $inputName, $inputValue, $arr, array( 'type' => 'number', 'min' => '10' ) )
			);
			
			/* Element show_excerpt*/
			$inputID 	= $this->get_field_id( 'show_avatar' );
			$inputName 	= $this->get_field_name( 'show_avatar' );
			$inputValue = 1;
			$arr 		= array( 'class' => 'widefat', 'id' => $inputID );
			$opts		= array( 'current_value' => absint( @$instance['show_avatar'] ) );
			$xhtml 		.= $htmlObj->generalItem(
					$htmlObj->control( 'checkbox', $inputName, $inputValue, $arr, $opts )
					.$htmlObj->labelTag( esc_html__('Show avatar on Comment tab', 'onelove'), array( 'for' => $inputID ), true)
			);
			
			echo trim($xhtml);
		}
	}
}
?>