<?php
/*=== SHORTCODE - RECENT POST ===*/
if ( ! function_exists( 'catanis_recent_posts_shortcode_function' ) ) {
	function catanis_recent_posts_shortcode_function( $atts, $content = null ) {

		if( !function_exists('catanis_option') ){
			return '';
		}
		global $catanis, $post;
		$catanis_page = $catanis->pageconfig;
		
		$post_style = $post_categories = $post_columns = $post_count = '';
		$show_filter = $filter_align = $post_spacing = $spacing_size = $ext_class = $pagination_type = $orderby = $order = $excerpt_length = '';
		$items_desktop = $items_desktop_small = $items_tablet = $slide_loop = $image_source = $slide_arrows = '';
		$slide_dots = $slide_dots_style = $slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = '';
		extract(shortcode_atts(array(
			'post_style'			=> 'onecolumn',		/* slider, list, special-list, masonry, grid, onecolumn, grid_model */
			'post_categories'		=> '',
			'post_columns'			=> '2',				/* 2,3,4 */
			'post_count'			=> '6',
			'show_filter'			=> 'no',
			'filter_align'			=> 'text-center',	/*text-center, text-left, text-right*/
			'post_spacing'			=> 'no',
			'spacing_size'			=> '10',
			'pagination_type'		=> 'default', 		/* default, newer_older, loadmore, infinite-scroll */
			'excerpt_length'		=> '25',
			'orderby'				=> 'date',
			'order'					=> 'DESC',
			
			'items_desktop' 		=> '3',
			'items_desktop_small' 	=> '3',
			'items_tablet' 			=> '2',
			'image_source'			=> 'yes', 			/*NULL,yes*/
			'slide_loop'			=> 'featured', 		/*featured, custom*/
			'slide_arrows'			=> 'no', 	
			'slide_dots'			=> 'yes', 	
			'slide_dots_style'		=> 'dots-line', 	/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/	
			'slide_autoplay'		=> 'no', 	
			'slide_autoplay_speed'	=> 3000, 	
			'slides_to_scroll'		=> 3, 	
			'slides_speed'			=> 500, 
			'ext_class' 			=> ''
		), $atts) );
		
		if(is_front_page()) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		}else {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}

		$args = array(
			'post_type' 			=> 'post',
			'ignore_sticky_posts' 	=> 0,
			'post_status' 			=> 'publish',
			'posts_per_page' 		=> $post_count,
			'paged' 				=> intval($paged),
			'orderby ' 				=> $orderby,
			'order' 				=> $order
		);
			
		if ( $post_categories != "" ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' 	=> 'category',
					'terms' 	=> explode( ',', esc_attr( $post_categories ) ),
					'field' 	=> 'slug',
					'operator' 	=> 'IN'
				)
			);
		}

		$post_style = (isset($catanis_page['layout']) && $catanis_page['layout'] != 'full' && $post_style == 'list') ? 'onecolumn' : $post_style;
		
		$elemID = 'cata_post_' . mt_rand();
		$elemClass = array( 'cata-element', 'cata-post' );
		if(!empty($ext_class)){
			array_push( $elemClass, $ext_class );
		}
		
		$data_string = '';
		$arrParams = array();
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		$portfolio_container_class = 'cata-isotope-container';
		switch( $post_style ) {
			case 'list':
			case 'special-list':
			case 'onecolumn':
				array_push( $elemClass, 'cata-post-'. $post_style );
				break;
				
			case 'slider':
				$portfolio_container_class = 'slides';
				$arrParams = array(
					'autoplay' 			=> ($slide_autoplay == 'yes') ? true : false,
					'autoplaySpeed' 	=> intval($slide_autoplay_speed),
					'slidesToShow' 		=> intval($items_desktop),
					'slidesToScroll' 	=> intval($slides_to_scroll),
					'dots' 				=> ($slide_dots == 'yes')? true : false,
					'arrows' 			=> ($slide_arrows == 'yes')? true : false,
					'infinite' 			=> ($slide_loop == 'yes')? true : false,
					'draggable' 		=> true,
					'speed' 			=> intval($slides_speed),
					'rtl' 				=> CATANIS_RTL,
					'adaptiveHeight' 	=> true,
					'responsive'		=> array(
						array(
							'breakpoint'	=> 1024,
							'settings'		=> array(
								'slidesToShow'		=> intval($items_desktop_small),
								'slidesToScroll' 	=> intval($items_desktop_small)
							)
						),
						array(
							'breakpoint'	=> 992,
							'settings'		=> array(
								'slidesToShow'		=> intval($items_tablet),
								'slidesToScroll' 	=>  intval($items_tablet)
							)
						),
						array(
							'breakpoint'	=> 600,
							'settings'		=> array(
								'slidesToShow'		=> 1,
								'slidesToScroll' 	=> 1
							)
						),
					)
				);
				
				array_push( $elemClass, 'cata-slick-slider' );
				array_push( $elemClass, 'cata-post-'. $post_style );
				array_push( $elemClass, 'cata-cols'. intval($items_desktop) );
				array_push( $elemClass, $slide_dots_style );
				break;
				
			case 'masonry':
				$data_string = ' data-spacing-size="' . esc_attr( $spacing_size ) . '" data-layout="masonry"';
				array_push( $elemClass, 'cata-isotope' );
				array_push( $elemClass, 'cata-isotope-masonry' );
				array_push( $elemClass, 'cata-cols'. $post_columns );
				if( $post_spacing == 'yes' ){
					array_push( $elemClass, 'cata-with-spacing' );
				}
				break;
				
			case 'grid_model':
				$portfolio_container_class .= ' cata-post-wrapper';
				array_push( $elemClass, 'cata-grid-model' );
				array_push( $elemClass, 'cata-cols'. $post_columns );
				if( $post_spacing == 'yes' ){
					array_push( $elemClass, 'cata-with-spacing' );
				}
				break;
			
			case 'grid':
			default:
				$post_spacing = 'yes';
				$spacing_size = 30;
				
				$data_string = ' data-spacing-size="' . esc_attr( $spacing_size ) . '" data-layout="fitRows"';
				array_push( $elemClass, 'cata-isotope' );
				array_push( $elemClass, 'cata-isotope-grid' );
				array_push( $elemClass, 'cata-cols'. $post_columns );
				if( $post_spacing == 'yes' ){
					array_push( $elemClass, 'cata-with-spacing' );
				}
				break;
		}
		
		if( $pagination_type == 'infinite-scroll' ){
			$data_string .= ' data-finishedmsg="'. esc_attr__( 'No more post to load.', 'catanis-core') .'" data-msgtext="'. esc_attr__( 'Loading the next posts...', 'catanis-core' ) .'"';
			array_push( $elemClass, 'cata-paging-infinite-scroll' );
		}
		
		$_config_opts = catanis_option('blog_exclude_sections');
		if ( !is_array( $_config_opts )){
			$_config_opts = explode(',', $_config_opts);
		}
		
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script('wp-mediaelement');
		wp_enqueue_script( 'catanis-js-videojs' );
		wp_enqueue_script( 'catanis-js-videojs-youtube' );
		wp_enqueue_script( 'catanis-js-videojs-vimeo' );
		
		$postTerms = get_terms( 'category', array(
			'hide_empty' => true,
			'slug' 	=> explode( ',', $post_categories),
			'order' => 'DESC' )
		);
		
		// Portfolio Filter
		$category_filter_string = '';
		$_terms = get_terms( 'category', array( 'hide_empty' => true ) );
		if ( count( $_terms ) > 0 && $show_filter == 'yes' && in_array($post_style, array('masonry', 'grid')) ) :
			$category_filter_string .= '<div class="cata-isotope-filter '. $filter_align .'"><ul>';
			$category_filter_string .= '<li><a data-filter="*" class="selected">' . __( 'All', 'catanis-core' ) . '</a></li>';
			foreach ( $_terms as $term ) {
				if ( $post_categories != "" ){
					$_cates = explode( ',', esc_attr( $post_categories ) );
					if ( in_array( $term->slug, $_cates ) ){
						$category_filter_string .= '<li><a href="#" data-filter=".'. esc_html( $term->slug ) .'">'. esc_html( $term->name ) .'</a></li>';
					}
						
				}else{
					$category_filter_string .= '<li><a data-filter=".'. esc_html( $term->slug ) .'">'. esc_html( $term->name ) .'</a></li>';
				}
			}
			$category_filter_string .= '</ul></div>';
		endif;

		$_query = new WP_Query($args);
		ob_start();
		?>
			
		<?php if ( $_query->have_posts() ) : ?>
		
			<div<?php echo rtrim($dir); ?> id="<?php echo $elemID; ?>" class="<?php echo implode( ' ', $elemClass ); ?>" <?php echo trim( $data_string); ?>> 
				
				<?php echo $category_filter_string; ?>
				<div class="<?php echo esc_attr($portfolio_container_class); ?>" data-slick='<?php echo json_encode($arrParams); ?>'>
				
				<?php if ( in_array($post_style, array('masonry', 'grid')) && $post_columns != 1 ) : ?>
					<div class="cata-isotope-grid-sizer"></div>
				<?php endif; ?>
					
				<?php $iter = 0;
				while ( $_query->have_posts() ) : 
					$_query->the_post(); 
					
					$post_title		= get_the_title();
					$post_meta 		= get_post_meta( $post->ID, Catanis_Meta::$meta_key, true );
					$term_list 		= implode( ' ', wp_get_post_terms( $post->ID, 'category', array( "fields" => "slugs" ) ) );
					$term_list 		.= ' cata-blog-item cata-isotope-item ' . $post_meta['post_thumbnail_type'];
					$term_list 		.= ( !has_post_thumbnail() || post_password_required() ) ? ' cata-blog-nothumb' : '';
					if($post_meta['audio_type'] == 'soundcloud' && isset($post_meta['audio_soundcloud']) && !empty($post_meta['audio_soundcloud'])){
						if ( !preg_match("/visual=true/i", $post_meta['audio_soundcloud']) ) {
							$term_list 		.= ' format-audio-soundcloud';
						}
					}
					
					$format = get_post_format();
					if ( empty ( $format ) ) {
						$format = 'default';
					}
					
					if(($iter== 0 && $paged == 0) || ($iter== 0 && $pagination_type != 'infinite-scroll') ){
						$term_list 		.= ' cata-blog-first';
					}
					
					$new_excerpt_length = ( $iter == 0 && $post_style == 'special-list' ) ? 50 : $excerpt_length; 
				?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('post '. $term_list); ?>>
						<div class="item cata-has-animation cata-fadeInUp">
							<?php 
							if( in_array($post_style, array('list', 'special-list', 'onecolumn')) ) :
								echo '<div class="cata-heart-line cata-has-animation cata-fadeInUp"></div>';
							endif;
							
							if( in_array($post_style, array('list', 'onecolumn')) ) :
								catanis_html_post_style_list_onecolumn($post_style, $post_meta, $format, $post_title, $new_excerpt_length, $iter); 
							endif; 
							
							if( in_array($post_style, array('special-list')) ) :
								catanis_html_post_style_special_list($post_style, $post_meta, $format, $post_title, $new_excerpt_length, $iter);
							endif; 
							 
							if( in_array($post_style, array('masonry', 'grid')) ) :
								catanis_html_post_style_grid_masonry($post_style, $post_meta, $format, $post_title, $new_excerpt_length, $iter);
							endif;
							?>	
							
							<?php if( in_array($post_style, array('slider')) ) : ?>
								<div class="entry-content">
									<div class="post-<?php echo $format; ?> cata-post-format">
										<?php catanis_get_post_format_in_loop($format, $post_style, $post_meta); ?>
									</div>
									<?php if( !in_array($format, array('quote', 'link'))) : ?>
										<h3 class="cata-blog-item-title">
											<?php echo is_sticky() ? '<i class="sticky fa fa-thumb-tack"></i>' : ''; ?>
											<a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ($post_title); ?></a>
										</h3>
										<div class="meta-info">
											<?php catanis_post_meta(array('date', 'category')); ?>
										</div>
										<?php 
											if($excerpt_length > 0){
												catanis_get_post_item_excerpt($excerpt_length);
											}
										?>
									<?php endif; ?>
								</div>
							<?php endif; ?>	
							
							<?php if( in_array($post_style, array('grid_model')) ) : 
								$post_thumb_url		= catanis_get_post_preview_img( $post->ID, true, 'large' );
								$post_thumb_url 	= trim($post_thumb_url['img']);
							?>
							<div class="entry-content" style="background-image:url(<?php echo esc_url($post_thumb_url); ?>);">
								<div>
								<?php if(($iter== 0 && $paged == 0) || ($iter== 0 && $pagination_type != 'infinite-scroll') ):  ?>
									<div class="meta-info">
										<?php catanis_post_meta(array('date', 'category')); ?>
									</div>
								<?php endif; ?>
								<h3 class="cata-blog-item-title">
									<a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ($post_title); ?></a>
								</h3>
								
								<?php if(!($iter== 0 && $paged == 0) && !($iter== 0 && $pagination_type != 'infinite-scroll') ):  ?>
									<div class="meta-info">
										<?php catanis_post_meta(array('date', 'category')); ?>
									</div>
								<?php endif; ?>
								
								<?php 
									if(($iter== 0 && $paged == 0) || ($iter== 0 && $pagination_type != 'infinite-scroll') ) {
										if($excerpt_length > 0){
											catanis_get_post_item_excerpt($excerpt_length); 
										}
									}
								?>
								</div>
							</div>
							<?php endif; ?>	
							
						</div>
					</article>
				<?php $iter++; endwhile; ?>
				</div>
			
			
			<div class="clear"></div> 
			<?php if ( !empty($pagination_type) && $_query->have_posts() && $post_count != '-1' && $post_style !== "slider") :?>
				
				<?php if (in_array( $pagination_type, array( 'default', 'newer_older', 'infinite-scroll') ) ) : ?>
					<div class="end_content"<?php if ($pagination_type =='infinite-scroll'):?> style="display:none;"<?php endif;?>>
					   <?php if( $_query->max_num_pages > 1): ?>
							<div class="page_navi"><div class="nav-content">
							<?php
								if ( $pagination_type == 'newer_older' ){
									catanis_pagination_nextprev( $_query );
								}else{
									catanis_pagination( $_query );
								}
							?>
							</div></div>
					   <?php endif; ?>
					</div>
				<?php elseif ( $pagination_type == 'loadmore' ) : 
						$jsonData = array(
							'post_style' 		=> $post_style, 
							'post_count' 		=> $post_count, 
							'post_categories' 	=> $post_categories, 
							'pagination_type' 	=> $pagination_type, 
							'excerpt_length' 	=> $excerpt_length,
							'orderby ' 			=> $orderby,
							'order' 			=> $order
						); 
					?>
					<div class="cata-loadmore-wrapper ca-button" data-currentpage="1" data-params='<?php echo json_encode( $jsonData ); ?>'>
						<a class="cata-btn-post-loadmore cata-btn-loadmore" data-parentid="<?php echo esc_attr( $elemID ); ?>" href="javascript:;" title="<?php echo esc_attr__( 'Load More', 'catanis-core' ); ?>">
							<span class="cicon cone"></span>
							<span class="cicon ctwo"></span>
							<span class="cicon cthree"></span>
							<i><?php esc_html_e( 'Load More', 'onelove' ); ?></i>
						</a>
						<a href="#" class="cata-infload-to-top"><?php echo esc_html('All items loaded.', 'onelove'); ?></a>
					</div>
					
				<?php endif; ?>
			<?php endif; /*END paganation*/ ?>
			</div>
		<?php endif; /*END $_query->have_posts()*/ ?>
		<?php
		$xhtml = ob_get_contents();
		ob_end_clean();
		wp_reset_postdata();
		
		return $xhtml;
	}
}

add_shortcode( 'cata_recent_posts', 'catanis_recent_posts_shortcode_function' );


function catanis_html_post_style_list_onecolumn($post_style, $post_meta, $format, $post_title, $excerpt_length, $iter){
	ob_start(); 
	?>
	
	<?php if( !in_array($format, array('quote', 'link'))): ?>
		<header class="entry-header">
			<?php ///catanis_entry_taxonomies('tags'); ?>
			<h3 class="cata-blog-item-title">
				<?php echo is_sticky() ? '<i class="sticky fa fa-thumb-tack"></i>' : ''; ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ($post_title); ?></a>
			</h3>
			<div class="meta-info">
				<?php catanis_post_meta(array('date', 'category')); ?>
			</div>
		</header> 
		<?php endif;?>
		
		<div class="entry-content">
			<div class="post-<?php echo $format; ?> cata-post-format">
				<!-- <div class="cata-share-socials"><?php //echo catanis_get_share_btns_html($post->ID, 'post-list', false, true); ?></div> -->
				<?php catanis_get_post_format_in_loop($format, $post_style, $post_meta); ?>
			</div>
			
			<?php if( !in_array($format, array('quote', 'link'))) : ?>
				<?php if($excerpt_length > 0) : catanis_get_post_item_excerpt($excerpt_length); endif; ?>
			<?php endif; ?>
		</div>
	
	<?php 
	$xhtml = ob_get_contents();
	ob_end_clean();
	
	echo ($xhtml);
}

function catanis_html_post_style_grid_masonry($post_style, $post_meta, $format, $post_title, $excerpt_length, $iter){
	ob_start();
	?>
	
	<?php if( !in_array($format, array('quote', 'link')) ) : ?>
		<header class="entry-header">
			<div class="post-<?php echo $format; ?> cata-post-format">
				<?php catanis_get_post_format_in_loop($format, $post_style, $post_meta); ?>
			</div>
		</header> 
	<?php endif; ?>	
		
		<div class="entry-content">
			<?php if( in_array($format, array('quote', 'link')) ) : ?>
				<div class="post-<?php echo $format; ?> cata-post-format">
					<?php catanis_get_post_format_in_loop($format, $post_style, $post_meta); ?>
				</div>
			<?php else: ?>
			
				<h3 class="cata-blog-item-title">
					<?php echo is_sticky() ? '<i class="sticky fa fa-thumb-tack"></i>' : ''; ?>
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ($post_title); ?></a>
				</h3>
				<div class="meta-info">
					<?php catanis_post_meta(array('date', 'category')); ?>
				</div>
				
				<?php if($excerpt_length > 0) : catanis_get_post_item_excerpt($excerpt_length); endif; ?>
			<?php endif; ?>
		</div>
	
	<?php 
	$xhtml = ob_get_contents();
	ob_end_clean();
	
	echo ($xhtml);
}

function catanis_html_post_style_special_list($post_style, $post_meta, $format, $post_title, $excerpt_length, $iter){
	ob_start();
	?>
	
	<?php if( !in_array($format, array('quote', 'link')) ) : ?>
	<header class="entry-header">
	
		<?php if( $iter == 0) : ?>
			<h3 class="cata-blog-item-title">
				<?php echo is_sticky() ? '<i class="sticky fa fa-thumb-tack"></i>' : ''; ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ($post_title); ?></a>
			</h3>
			<div class="meta-info">
				<?php catanis_post_meta(array('date', 'category')); ?>
			</div>
		<?php endif; ?>
		
		<div class="post-<?php echo $format; ?> cata-post-format">
			<?php catanis_get_post_format_in_loop($format, $post_style, $post_meta); ?>
		</div>
		
	</header> 
	<?php endif; ?>	
	
	<div class="entry-content">
		<?php if( in_array($format, array('quote', 'link')) ) : ?>
			<div class="post-<?php echo $format; ?> cata-post-format">
				<?php catanis_get_post_format_in_loop($format, $post_style, $post_meta); ?>
			</div>
		<?php else: ?>
		
			<?php if($iter != 0) : ?>	
				<h3 class="cata-blog-item-title">
					<?php echo is_sticky() ? '<i class="sticky fa fa-thumb-tack"></i>' : ''; ?>
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ($post_title); ?></a>
				</h3>
				<div class="meta-info">
					<?php catanis_post_meta(array('date', 'category')); ?>
				</div>
			<?php endif; ?>
			
			<?php if($excerpt_length > 0) : catanis_get_post_item_excerpt($excerpt_length); endif; ?>
		<?php endif; ?>
	</div>
	
	<?php 
	$xhtml = ob_get_contents();
	ob_end_clean();
	
	echo ($xhtml);
}

add_action( 'wp_ajax_cata_posts_loadmore_items', 'catanis_posts_loadmore_items' );
add_action( 'wp_ajax_nopriv_cata_posts_loadmore_items', 'catanis_posts_loadmore_items' );
function catanis_posts_loadmore_items(){

	$params 		= $_POST['params'];
	$currentpage 	= $_POST['currentpage'];
	
	if ( !is_array( $params ) || empty( $params['post_count'] ) || empty( $params['post_style'] ) ) {
		return '';
	}
	
	$post_style 		= $params['post_style'];
	$post_count			= $params['post_count'];
	$post_categories	= $params['post_categories'];
	$pagination_type	= $params['pagination_type'];
	$post_animation		= $params['post_animation'];
	$excerpt_length		= $params['excerpt_length'];
	$orderby			= $params['orderby'];
	$order				= $params['order'];

	$_config_opts = catanis_option('blog_exclude_sections');
	if ( !is_array( $_config_opts )){
		$_config_opts = explode(',', $_config_opts);
	}
	
	$paged = $currentpage + 1;
	$args = array(
		'post_type' 			=> 'post',
		'post_status' 			=> 'publish',
		'ignore_sticky_posts' 	=> 0,
		'posts_per_page' 		=> $post_count,
		'paged' 				=> $paged,
		'orderby ' 				=> $orderby,
		'order' 				=> $order
	);
	if ($post_categories != "" ){
		$args['tax_query'] = array(
			array(
				'taxonomy' 	=> 'category',
				'terms' 	=> explode( ',', esc_html( $post_categories ) ),
				'field' 	=> 'slug',
				'operator' 	=> 'IN'
			)
		);
	}
	
	ob_start();
	$_query = new WP_Query($args);
	
	global $post, $catanis, $wp_query;
	$iter = 0;
	if ( $_query->have_posts() ) :
	while ( $_query->have_posts() ) : 
	
		$_query->the_post();
		
		$post_title		= get_the_title();
		$post_meta 		= get_post_meta( $post->ID, Catanis_Meta::$meta_key, true );
		$term_list 		= implode( ' ', wp_get_post_terms( $post->ID, 'category', array( "fields" => "slugs" ) ) );
		$term_list 		.= ' cata-blog-item cata-isotope-item ' . $post_meta['post_thumbnail_type'];
		$term_list 		.= ( !has_post_thumbnail() || post_password_required() ) ? ' cata-blog-nothumb' : '';
	
		if($post_meta['audio_type'] == 'soundcloud' && isset($post_meta['audio_soundcloud']) && !empty($post_meta['audio_soundcloud'])){
			if ( !preg_match("/visual=true/i", $post_meta['audio_soundcloud']) ) {
				$term_list 		.= ' format-audio-soundcloud';
			}
		}
			
		$format = get_post_format();
		if ( empty ( $format ) ) {
			$format = 'default';
		}
			
		if(($iter== 0 && $paged == 0) || ($iter== 0 && $pagination_type != 'infinite-scroll') ){
			$term_list 		.= ' cata-blog-first';
		}
			
		$new_excerpt_length = ( $iter== 0 && $post_style == 'special-list' )? 50 : $excerpt_length;
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('post '. $term_list); ?>>
			<div class="item cata-has-animation cata-fadeInUp">
				<?php 
					if( in_array($post_style, array('list', 'special-list', 'onecolumn')) ) :
						echo '<div class="cata-heart-line cata-has-animation cata-fadeInUp"></div>';
					endif;
					
					if( in_array($post_style, array('list', 'onecolumn')) ) :
						catanis_html_post_style_list_onecolumn($post_style, $post_meta, $format, $post_title, $new_excerpt_length, $iter); 
					endif; 
					
					if( in_array($post_style, array('special-list')) ) :
						catanis_html_post_style_special_list($post_style, $post_meta, $format, $post_title, $new_excerpt_length, $iter);
					endif; 
					 
					if( in_array($post_style, array('masonry', 'grid')) ) :
						catanis_html_post_style_grid_masonry($post_style, $post_meta, $format, $post_title, $new_excerpt_length, $iter);
					endif;
				?>	
				
				<?php if( in_array($post_style, array('grid_model')) ) : 
					$post_thumb_url		= catanis_get_post_preview_img( $post->ID, true, 'large' );
					$post_thumb_url 	= trim($post_thumb_url['img']);
				?>
				<div class="entry-content" style="background-image:url(<?php echo esc_url($post_thumb_url); ?>);">
					
					<?php if(($iter== 0 && $paged == 0) || ($iter== 0 && $pagination_type != 'infinite-scroll') ):  ?>
						<div class="meta-info">
							<?php catanis_post_meta(array('date', 'category')); ?>
						</div>
					<?php endif; ?>
					<h3 class="cata-blog-item-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ($post_title); ?></a>
					</h3>
					
					<?php if(!($iter== 0 && $paged == 0) && !($iter== 0 && $pagination_type != 'infinite-scroll') ):  ?>
						<div class="meta-info">
							<?php catanis_post_meta(array('date', 'category')); ?>
						</div>
					<?php endif; ?>
					
					<?php 
						if(($iter== 0 && $paged == 0) || ($iter== 0 && $pagination_type != 'infinite-scroll') ) {
							if($excerpt_length > 0){
								catanis_get_post_item_excerpt($excerpt_length); 
							}
						}
					?>
					
				</div>
				<?php endif; ?>	
				
			</div>
		</article>
		<?php 
	$iter++;
	endwhile;
	endif;
	
	$xhtml = ob_get_contents();
	ob_end_clean();
	wp_reset_postdata();

	echo $xhtml;
	die();
}
