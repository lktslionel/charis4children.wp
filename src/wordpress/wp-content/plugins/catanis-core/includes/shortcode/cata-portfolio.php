<?php
/*=== SHORTCODE - PORTFOLIO ===*/
if ( ! function_exists( 'catanis_portfolio_shortcode_function' ) ){
	function catanis_portfolio_shortcode_function( $atts, $content = null ) {
			
		if( !function_exists('catanis_option') ){
			return '';
		}
		$xhtml = $portfolio_style = $portfolio_columns = $portfolio_count = $portfolio_animation = '';
		$portfolio_link_mode = $portfolio_link_mode_title = $portfolio_categories = $portfolio_cate_defdault = $portfolio_show_filter = $portfolio_filter_align = '';
		$portfolio_hover_style = $portfolio_spacing = $spacing_size = $pagination_type = $orderby = $order = $image_source = '';
		$items_desktop = $items_desktop_small = $items_tablet = $slide_arrows = $slide_loop = $slide_dots = $slide_dots_style ='';
		$slide_autoplay = $slide_autoplay_speed = $slides_to_scroll = $slides_speed = $ext_class = '';
		$portfolio_tags = '';
		
		$portfolio_count = ( isset( $atts['portfolio_count'] ) && $atts['portfolio_count'] > 0 ) ? $atts['portfolio_count'] : catanis_option( 'portfolio_per_page' );
		if ( $portfolio_count < -1 || $portfolio_count == 0 ) $portfolio_count = get_option( 'posts_per_page' );
		
		extract(shortcode_atts(array(
			'portfolio_style' 			=>  'masonry',
			'portfolio_columns' 		=>  3,
			'portfolio_count' 			=>  $portfolio_count,
			'portfolio_animation' 		=>  'cata-fadeInUp',
			'portfolio_link_mode' 		=> 'item',
			'portfolio_categories' 		=>  '',
			'portfolio_cate_defdault' 	=>  '',
			'portfolio_tags' 			=>  '',		/*Only for Archive page*/
			'portfolio_show_filter' 	=>  'yes',
			'portfolio_filter_align' 	=>  'text-center',
			'portfolio_hover_style' 	=>  'style1',
			'portfolio_spacing' 		=>  'yes',
			'spacing_size' 				=>  '10',
			'pagination_type' 			=>  'default',
			'orderby' 					=>  'date', 
			'order' 					=>  'DESC',
			'image_source'				=> 'featured', 		/*featured, custom*/
			
			'items_desktop' 			=> '3',
			'items_desktop_small' 		=> '3',
			'items_tablet' 				=> '2',
			'slide_loop'				=> 'yes',
			'slide_arrows'				=> 'no',
			'slide_dots'				=> 'yes',
			'slide_dots_style'			=> 'dots-line', 		/*dots-rounded, dots-square, dots-line, dots-catanis-height, dots-catanis-width*/
			'slide_autoplay'			=> 'no',
			'slide_autoplay_speed'		=> 3000,
			'slides_to_scroll'			=> 3,
			'slides_speed'				=> 500,
			'ext_class' 				=> ''
		), $atts ) );
		
		$data_string = '';
		$arrParams = array();
		$elemID = 'cata_isotope_' . mt_rand();
		$elemClass = array( 'cata-element', 'cata-portfolio'  );
		if(!empty($ext_class)){
			array_push( $elemClass, $ext_class );
		}
		
		$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
		array_push( $elemClass, 'cata-hover-'. $portfolio_hover_style );
		switch( $portfolio_style ) {
			case 'masonry':
				$portfolio_container_class = 'cata-isotope-container';
				if ( $portfolio_link_mode == 'popup' ) {
					$portfolio_container_class .= ' cata-gallery-popup';
				}
				$data_string = ' data-spacing-size="' . esc_attr( $spacing_size ) . '" data-layout="masonry"';
				array_push( $elemClass, 'cata-isotope' );
				array_push( $elemClass, 'cata-isotope-masonry' );
				array_push( $elemClass, 'cata-cols'. $portfolio_columns );
				if( $portfolio_spacing == 'yes' ){
					array_push( $elemClass, 'cata-with-spacing' );
				}
				break;
				
			case 'masonry-multisize':
				$portfolio_container_class = 'cata-isotope-container';
				if ( $portfolio_link_mode == 'popup' ) {
					$portfolio_container_class .= ' cata-gallery-popup';
				}
				$data_string = ' data-spacing-size="' . esc_attr( $spacing_size ) . '" data-layout="packery"';
				array_push( $elemClass, 'cata-isotope' );
				array_push( $elemClass, 'cata-isotope-packery' );
				array_push( $elemClass, 'cata-cols'. $portfolio_columns );
				if( $portfolio_spacing == 'yes' ){
					array_push( $elemClass, 'cata-with-spacing' );
				}
				break;
				
			case 'masonry-horizontal':
				
				$portfolio_container_class = 'cata-isotope-container';
				if ( $portfolio_link_mode == 'popup' ) {
					$portfolio_container_class .= ' cata-gallery-popup';
				}
				
				$data_string = ' data-is-horizontal="true" data-spacing-size="' . esc_attr( $spacing_size ) . '" data-layout="masonry"';
				array_push( $elemClass, 'cata-isotope' );
				array_push( $elemClass, 'cata-portfolio-horizontal' );
				
				if( $portfolio_spacing == 'yes' ){
					array_push( $elemClass, 'cata-with-spacing' );
				}
				break;
				
			case 'slider':
				$portfolio_container_class = 'cata-isotope-container slides';
				if ( $portfolio_link_mode == 'popup' ) {
					$portfolio_container_class .= ' cata-gallery-popup';
				}
				$data_string = ' data-spacing-size="' . esc_attr( $spacing_size ) . '"';
				
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
							'breakpoint'	=> 768,
							'settings'		=> array(
									'slidesToShow'		=> intval($items_tablet),
									'slidesToScroll' 	=>  intval($items_tablet)
							)
						),
						array(
							'breakpoint'	=> 480,
							'settings'		=> array(
									'slidesToShow'		=> 1,
									'slidesToScroll' 	=> 1
							)
						),
					)
				);
				
				if($items_desktop == 1 && $items_desktop_small == 1 && $items_tablet == 1){
					$arrParams['fade'] = true;
					$arrParams['cssEase'] = 'linear';
				}
				
				array_push( $elemClass, 'cata-slick-slider' );
				array_push( $elemClass, 'cata-portfolio-slider' );
				array_push( $elemClass, 'cata-cols'. $portfolio_columns );
				array_push( $elemClass, $slide_dots_style );
				
				if( $portfolio_spacing == 'yes' ){
					array_push( $elemClass, 'cata-with-spacing' );
					array_push( $elemClass, 'cata-slider-spacing' . esc_attr( $spacing_size ) );
				}
				break;
				
			case 'ziczac':
				array_push( $elemClass, 'cata-portfolio-ziczac' );
				array_push( $elemClass, 'cata-cols'. $portfolio_columns );
				if ( $portfolio_link_mode == 'popup' ) {
					$portfolio_container_class .= ' cata-gallery-popup';
				}
				break;
				
			case 'grid':
			default:
				$portfolio_container_class = 'cata-isotope-container';
				if ( $portfolio_link_mode == 'popup' ) {
					$portfolio_container_class .= ' cata-gallery-popup';
				}
				
				$data_string = ' data-spacing-size="' . esc_attr( $spacing_size ) . '" data-layout="fitRows"';
				array_push( $elemClass, 'cata-isotope' );
				array_push( $elemClass, 'cata-isotope-grid' );
				array_push( $elemClass, 'cata-cols'. $portfolio_columns );
				if( $portfolio_spacing == 'yes' ){
					array_push( $elemClass, 'cata-with-spacing' );
				}
				break;
		}
		$data_string .= ' data-filterdef="' . esc_attr( $portfolio_cate_defdault ) . '"';
		
		$ext_attr_link = $ext_attr_link2 = '';
		if ( $portfolio_link_mode == 'popup' ) {
			$ext_attr_link = ' data-fresco-caption="{TITLE}" data-fresco-group="cata-gallery"';
			$ext_attr_link2 = ' data-fresco-caption="{TITLE}" data-fresco-group="cata-gallery2"';
		}
		switch ( $portfolio_hover_style ) {
			case 'style1':
				$patternLi = '<article class="cata-isotope-item {ITEM_CLASS}">
						<div class="cata-isotope-item-inner"><div class="cata-has-animation '. $portfolio_animation .'">
							<a href="{LINK}" class="cata-item-url {LINK_CLASS_POPUP}"'. $ext_attr_link .'></a>
							<div class="cata-bg-overlay" style="background: {BG_COLOR}"></div>
							<div class="cata-love-counter">{CATANIS_LOVE}</div>
						
							<div class="cata-item-image">
								<img src="{IMAGE}" alt="{TITLE}">
							</div>
							<div class="cata-item-info">
								<h4 class="cata-title"><a href="{LINK}" class="{LINK_CLASS_POPUP}"'. $ext_attr_link2 .' title="{TITLE}">{TITLE}</a></h4>
								<p class="cata-cates">{CATEGORIES_COMMA}</p>
							</div>
						</div></div>
					</article>'; break;
		
			case 'style2':
				$patternLi = '<article class="cata-isotope-item {ITEM_CLASS}">
						<div class="cata-isotope-item-inner"><div class="cata-has-animation '. $portfolio_animation .'">
							<a href="{LINK}" class="cata-item-url {LINK_CLASS_POPUP}"'. $ext_attr_link .'></a>
							<div class="cata-bg-overlay" style="background: {BG_COLOR}"></div>
							<div class="cata-love-counter">{CATANIS_LOVE}</div>
								
							<div class="cata-item-image">
								<img src="{IMAGE}" alt="{TITLE}">
							</div>
							<div class="cata-item-info">
								<h4 class="cata-title"><a href="{LINK}" class="{LINK_CLASS_POPUP}"'. $ext_attr_link2 .' title="{TITLE}">{TITLE}</a></h4>
								<p class="cata-cates">{CATEGORIES_COMMA}</p>
							</div>
						</div></div>
					</article>'; break;
		
			case 'style3':
				$patternLi = '<article class="cata-isotope-item {ITEM_CLASS}">
						<div class="cata-isotope-item-inner"><div class="cata-has-animation '. $portfolio_animation .'">
							<a href="{LINK}" class="cata-item-url {LINK_CLASS_POPUP}"'. $ext_attr_link .'></a>
							<div class="cata-love-counter">{CATANIS_LOVE}</div>
								
							<div class="cata-item-image">
								<img src="{IMAGE}" alt="{TITLE}">
							</div>
							<div class="cata-item-info">
								<h4 class="cata-title"><a href="{LINK}" class="{LINK_CLASS_POPUP}"'. $ext_attr_link2 .' title="{TITLE}">{TITLE}</a></h4>
								<p class="cata-cates">{CATEGORIES_COMMA}</p>
							</div>
						</div></div>
					</article>'; break;
		}
		
		/* Portfolio Filter */
		$category_filter_string = '';
		if( $portfolio_show_filter == 'yes' && !in_array($portfolio_style, array('ziczac', 'slider', 'masonry-horizontal')) ){
			$_terms = get_terms( 'portfolio_category', array( 'hide_empty' => true ) );
			if ( count( $_terms ) > 0 ) {
				$category_filter_string .= '<div class="cata-isotope-filter '. $portfolio_filter_align .'"><ul>';
				
				$category_filter_string .= ( !empty($portfolio_cate_defdault) ) ? '<li>' : '<li class="selected">';
				$category_filter_string .= '<a  href="#" data-filter="*">' . __( 'All', 'catanis-core' ) . '</a></li>';
				
				foreach ( $_terms as $term ) {
					if ( $portfolio_categories != "" ){
						$_cates = explode( ',', esc_attr( $portfolio_categories ) );
						if ( in_array( $term->slug, $_cates ) ){
							
							$category_filter_string .= ( $term->slug == $portfolio_cate_defdault ) ? '<li class="selected">' : '<li>';
							$category_filter_string .= '<a href="#" data-filter=".'. esc_html( $term->slug ) .'">'. esc_html( $term->name ) .'</a></li>';
						}
			
					}else{
						$category_filter_string .= '<li><a data-filter=".'. esc_html( $term->slug ) .'">'. esc_html( $term->name ) .'</a></li>';
					}
				}
				$category_filter_string .= '</ul></div>';
			}
		}
	
		/* Portfolio Items */
		$args = array(
			'post_type' 	=> CATANIS_POSTTYPE_PORTFOLIO,
			'posts_per_page' => $portfolio_count,
			'paged' 		=> get_query_var( 'paged' ),
			'orderby' 		=> $orderby,
			'order' 		=> $order
		);
		if ( $portfolio_categories != "" ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' 	=> 'portfolio_category',
					'terms' 	=> explode( ',', esc_html( $portfolio_categories ) ),
					'field' 	=> 'slug',
					'operator' 	=> 'IN'
				)
			);
		} 
		if ( $portfolio_tags != "" ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' 	=> 'portfolio_tags',
					'terms' 	=> explode( ',', esc_html( $portfolio_tags ) ),
					'field' 	=> 'slug',
					'operator' 	=> 'IN'
				)
			);
		}
	
		global $catanis;
		$_query = new WP_Query( $args );
		ob_start();
		?>
			<div<?php echo rtrim($dir); ?> id="<?php echo esc_attr( $elemID ); ?>" class="<?php echo implode( ' ', $elemClass ); ?>" <?php echo trim( $data_string); ?>>
				<?php echo $category_filter_string; ?>
				
				<div class="<?php echo esc_attr($portfolio_container_class); ?>" data-slick='<?php echo json_encode($arrParams); ?>'>
					<?php 
					if ( $_query->have_posts() ) : 
						if( !in_array($portfolio_style, array('ziczac', 'slider')) ){
							echo '<div class="cata-isotope-grid-sizer"></div>';
						}
						
						while ( $_query->have_posts() ) : $_query->the_post(); 
							$post_id = get_the_ID();
							$post_meta 	= get_post_meta( $post_id, Catanis_Meta::$meta_key, true );
							$post_title = esc_html( get_the_title( $post_id ) );
							$post_url 	= esc_url( get_permalink( $post_id ) );
							
							$term_list 			= implode( ' ', wp_get_post_terms( $post_id, 'portfolio_category', array( "fields" => "slugs" ) ) );
							$term_list_comma 	= get_the_term_list( $post_id, 'portfolio_category', '', ', ', '' );

							if( !in_array($portfolio_style, array('masonry-horizontal', 'slider')) ){
								$term_list 				.= ' cata-portfolio-item';
							}
								
							$portfolio_data 	= catanis_get_image_size_portfolio($post_meta['port_thumbnail_type'], $portfolio_style);
							$term_list 			.= ' ' . $portfolio_data['image_size_class'];
							
							$image_size 		= ($portfolio_columns == 1) ? 'catanis-image-medium-rect-horizontal' : $portfolio_data['image_size'];
							if( $image_source == 'custom' && !empty($post_meta['port_custom_thumbnail']) ){
							
								/*$preview_img		= catanis_get_portfolio_preview_img( $post_id, false, 'full' );*/
								$preview_img		= catanis_get_portfolio_preview_img( $post_id, false, $image_size );
								$post_thumb_url 	= trim($preview_img['img']);
								$popup_large_img 	= trim($preview_img['img_full']);
								
							}else{
																	
								$preview_img		= catanis_get_portfolio_preview_img( $post_id, true, $image_size );
								$post_thumb_url 	= trim($preview_img['img']);
								$popup_large_img 	= trim($preview_img['img_full']);
								
								/* if ( $portfolio_link_mode == 'popup' ) {
									$popup_large_img 	= trim($preview_img['img_full']);
									$popup_large_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
									$popup_large_img = $popup_large_img[0];
								} */
							}
							
							$link_class_popup = '';
							if ( $portfolio_link_mode == 'popup' ) {
								$post_url 			= $popup_large_img;
								$link_class_popup 	= 'fresco';
							}
							
							if ( $portfolio_link_mode == 'custom-link' ) {
								$post_url = '#';
								if(isset($post_meta['port_exteral_url']) && !empty($post_meta['port_exteral_url'])){
									$post_url = trim($post_meta['port_exteral_url']);
								}
							}
							
							$bg_color	 		= 'rgba(255, 255, 255, .9);';
							if ( isset( $post_meta['portfolio_hover_color'] ) && ! empty( $post_meta['port_hover_color'] ) ) {
								$bg_color 		= implode( ',', catanis_hex2rgba( $post_meta['port_hover_color'], '.8' ) );
								$bg_color 		= "rgba({$bg_color})";
							}
							
							/*item*/
							$liItem = str_replace( '{ITEM_CLASS}', esc_html( $term_list ), $patternLi );
							$liItem = str_replace( '{CATEGORIES_COMMA}', $term_list_comma, $liItem );
							$liItem = str_replace( '{LINK}', $post_url, $liItem );
							$liItem = str_replace( '{TITLE}', $post_title, $liItem );
							$liItem = str_replace( '{LINK_CLASS_POPUP}', $link_class_popup, $liItem );
							$liItem = str_replace( '{IMAGE}', esc_url( $post_thumb_url ), $liItem );
							$liItem = str_replace( '{BG_COLOR}', esc_html( $bg_color ), $liItem );
							$liItem = str_replace( '{CATANIS_LOVE}', $catanis->love->get_love(true ), $liItem );
							
							echo $liItem; 
						
						endwhile;
					endif;
					?>
				</div>
				<?php if ( $_query->have_posts() && $pagination_type == 'loadmore' && $portfolio_count != '-1' && !in_array($portfolio_style, array('masonry-horizontal', 'slider')) ) : ?>
					<?php 
						$jsonData = array( 
							'portfolio_style' 			=> $portfolio_style,
							'portfolio_count' 			=> $portfolio_count,
							'portfolio_columns' 		=> $portfolio_columns,
							'portfolio_animation' 		=> $portfolio_animation,
							'portfolio_link_mode' 		=> $portfolio_link_mode,
							'portfolio_categories' 		=> $portfolio_categories,
							'portfolio_hover_style' 	=> $portfolio_hover_style,
							'orderby' 					=> $orderby,
							'order' 					=> $order
						); 
					?>
					<div class="cata-loadmore-wrapper" data-currentpage="1" data-params='<?php echo json_encode( $jsonData ); ?>'>
						<a class="cata-btn-portfolio-loadmore cata-btn-loadmore" data-parentid="<?php echo esc_attr( $elemID ); ?>" href="javascript:;" title="<?php echo esc_attr__( 'Load More', 'catanis-core' ); ?>">
							<span class="cicon cone"></span>
							<span class="cicon ctwo"></span>
							<span class="cicon cthree"></span>
							<i><?php esc_html_e( 'Load More', 'onelove' ); ?></i>
						</a>
						<a href="#" class="cata-infload-to-top"><?php echo esc_html('All items loaded.', 'onelove'); ?></a>
						
					</div>
					
				<?php elseif ( $_query->have_posts() && $pagination_type == 'default' && !in_array($portfolio_style, array('masonry-horizontal', 'slider'))) : ?>
					<div class="end_content">
					   <?php if ( $_query->max_num_pages > 1 ): ?>
						<div class="page_navi"><div class="nav-content"><?php catanis_pagination( $_query );?></div></div>
					   <?php endif; ?>
					</div>
				<?php endif; ?>
				
			</div><div class="clear"></div>
						
		<?php 
		wp_reset_postdata(); 
	    $xhtml = ob_get_contents();
	    ob_end_clean();
	   
	    return $xhtml;
	}
}
add_shortcode( 'cata_portfolio', 'catanis_portfolio_shortcode_function' );

/*PORTFOLIO LOAD MORE*/
add_action( 'wp_ajax_cata_portfolio_loadmore_items', 'catanis_portfolio_loadmore_items' );
add_action( 'wp_ajax_nopriv_cata_portfolio_loadmore_items', 'catanis_portfolio_loadmore_items' );

function catanis_portfolio_loadmore_items(){
	$currentpage = $_POST['currentpage'];
	$params = $_POST['params'];
	
	if ( !is_array( $params ) || empty( $params['portfolio_count'] ) || empty( $params['portfolio_style'] ) ) {
		return '';
	}
	$portfolio_style 		= $params['portfolio_style'];
	$portfolio_count		= $params['portfolio_count'];
	$portfolio_columns		= $params['portfolio_columns'];
	$portfolio_animation	= $params['portfolio_animation'];
	$portfolio_link_mode	= $params['portfolio_link_mode'];
	$portfolio_categories	= $params['portfolio_categories'];
	$portfolio_hover_style	= $params['portfolio_hover_style'];
	$orderby				= $params['orderby'];
	$order					= $params['order'];
	
	$ext_attr_link = $ext_attr_link2 = '';
	if ( $portfolio_link_mode == 'popup' ) {
		$ext_attr_link = ' data-fresco-caption="{TITLE}" data-fresco-group="cata-gallery"';
		$ext_attr_link2 = ' data-fresco-caption="{TITLE}" data-fresco-group="cata-gallery2"';
	}
	switch ( $portfolio_hover_style ) {
		case 'style1':
			$patternLi = '<article class="cata-isotope-item {ITEM_CLASS}">
						<div class="cata-isotope-item-inner"><div class="cata-has-animation '. $portfolio_animation .'">
							<a href="{LINK}" class="cata-item-url {LINK_CLASS_POPUP}"'. $ext_attr_link .'></a>
							<div class="cata-bg-overlay" style="background: {BG_COLOR}"></div>
							<div class="cata-love-counter">{CATANIS_LOVE}</div>
	
							<div class="cata-item-image">
								<img src="{IMAGE}" alt="{TITLE}">
							</div>
							<div class="cata-item-info">
								<h4 class="cata-title"><a href="{LINK}" class="{LINK_CLASS_POPUP}"'. $ext_attr_link2 .' title="{TITLE}">{TITLE}</a></h4>
								<p class="cata-cates">{CATEGORIES_COMMA}</p>
							</div>
						</div></div>
					</article>'; break;
	
		case 'style2':
			$patternLi = '<article class="cata-isotope-item {ITEM_CLASS}">
						<div class="cata-isotope-item-inner"><div class="cata-has-animation '. $portfolio_animation .'">
							<a href="{LINK}" class="cata-item-url {LINK_CLASS_POPUP}"'. $ext_attr_link .'></a>
							<div class="cata-bg-overlay" style="background: {BG_COLOR}"></div>
							<div class="cata-love-counter">{CATANIS_LOVE}</div>
	
							<div class="cata-item-image">
								<img src="{IMAGE}" alt="{TITLE}">
							</div>
							<div class="cata-item-info">
								<h4 class="cata-title"><a href="{LINK}" class="{LINK_CLASS_POPUP}"'. $ext_attr_link2 .' title="{TITLE}">{TITLE}</a></h4>
								<p class="cata-cates">{CATEGORIES_COMMA}</p>
							</div>
						</div></div>
					</article>'; break;
	
		case 'style3':
			$patternLi = '<article class="cata-isotope-item {ITEM_CLASS}">
						<div class="cata-isotope-item-inner"><div class="cata-has-animation '. $portfolio_animation .'">
							<a href="{LINK}" class="cata-item-url {LINK_CLASS_POPUP}"'. $ext_attr_link .'></a>
							<div class="cata-love-counter">{CATANIS_LOVE}</div>
	
							<div class="cata-item-image">
								<img src="{IMAGE}" alt="{TITLE}">
							</div>
							<div class="cata-item-info">
								<h4 class="cata-title"><a href="{LINK}" class="{LINK_CLASS_POPUP}"'. $ext_attr_link2 .' title="{TITLE}">{TITLE}</a></h4>
								<p class="cata-cates">{CATEGORIES_COMMA}</p>
							</div>
						</div></div>
					</article>'; break;
	}
	
	$args = array(
		'post_type' 		=> 'portfolio',
		'posts_per_page' 	=> $portfolio_count,
		'paged'				=> $currentpage + 1,
		'orderby' 			=> $orderby,
		'order' 			=> $order
	);
	if ($portfolio_categories != "" ){
		$args['tax_query'] = array(
			array(
				'taxonomy' 	=> 'portfolio_category',
				'terms' 	=> explode( ',', esc_html( $portfolio_categories ) ),
				'field' 	=> 'slug',
				'operator' 	=> 'IN'
			)
		);
	}
	
	$_query = new WP_Query($args);
	global $post, $catanis, $wp_query;
	
	if ( $_query->have_posts() ) :
		while ( $_query->have_posts() ) : $_query->the_post();
			$post_id = get_the_ID();
			$post_meta 	= get_post_meta( $post_id, Catanis_Meta::$meta_key, true );
			$post_title = esc_html( get_the_title( $post_id ) );
			$post_url 	= esc_url( get_permalink( $post_id ) );
			
			$term_list 			= implode( ' ', wp_get_post_terms( $post_id, 'portfolio_category', array( "fields" => "slugs" ) ) );
			$term_list_comma 	= get_the_term_list( $post_id, 'portfolio_category', '', ', ', '' );
			
			$portfolio_data 	= catanis_get_image_size_portfolio($post_meta['port_thumbnail_type'], $portfolio_style);
			$term_list 			.= ' ' . $portfolio_data['image_size_class'];
			
			$image_size 		= ($portfolio_columns == 1) ? 'catanis-image-medium-rect-horizontal' : $portfolio_data['image_size'];
			if( !empty($post_meta['port_custom_thumbnail']) ){
					
				/*$preview_img		= catanis_get_portfolio_preview_img( $post_id, false, 'full' );*/
				$preview_img		= catanis_get_portfolio_preview_img( $post_id, false, $image_size );
				$post_thumb_url 	= trim($preview_img['img']);
				$popup_large_img 	= trim($preview_img['img_full']);
			
			}else{
					
				$preview_img		= catanis_get_portfolio_preview_img( $post_id, true, $image_size );
				$post_thumb_url 	= trim($preview_img['img']);
				$popup_large_img 	= trim($preview_img['img_full']);
			
				/* if ( $portfolio_link_mode == 'popup' ) {
				 $popup_large_img 	= trim($preview_img['img_full']);
				$popup_large_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
				$popup_large_img = $popup_large_img[0];
				} */
			}
			
			
			$link_class_popup = '';
			if ( $portfolio_link_mode == 'popup' ) {
				$post_url 			= $popup_large_img;
				$link_class_popup 	= 'fresco';
			}
			
			if ( $portfolio_link_mode == 'custom-link' ) {
				$post_url = '#';
				if(isset($post_meta['port_exteral_url']) && !empty($post_meta['port_exteral_url'])){
					$post_url = trim($post_meta['port_exteral_url']);
				}
			}
			
			$bg_color	 		= 'rgba(255, 255, 255, .9);';
			if ( isset( $post_meta['portfolio_hover_color'] ) && ! empty( $post_meta['port_hover_color'] ) ) {
				$bg_color 		= implode( ',', catanis_hex2rgba( $post_meta['port_hover_color'], '.8' ) );
				$bg_color 		= "rgba({$bg_color})";
			}
			
			/*item*/
			$liItem = str_replace( '{ITEM_CLASS}', esc_html( $term_list ), $patternLi );
			$liItem = str_replace( '{CATEGORIES_COMMA}', $term_list_comma, $liItem );
			$liItem = str_replace( '{LINK}', $post_url, $liItem );
			$liItem = str_replace( '{TITLE}', $post_title, $liItem );
			$liItem = str_replace( '{LINK_CLASS_POPUP}', $link_class_popup, $liItem );
			$liItem = str_replace( '{IMAGE}', esc_url( $post_thumb_url ), $liItem );
			$liItem = str_replace( '{BG_COLOR}', esc_html( $bg_color ), $liItem );
			$liItem = str_replace( '{CATANIS_LOVE}', $catanis->love->get_love(true ), $liItem );
			
			if($portfolio_style == 'ziczac' && !empty($post_meta['port_excerpt']) ){
				$btn_viewmore = '<a href="'.$post_url .'" title="'. $post_title .'" class="catanis-shortcode button viewmore icon-right main_color">'. esc_html__( "View More", 'catanis-core' ) .'<span class="icon vc_icon_element-icon fa fa-angle-double-right"></span></a>';
				$liItem = str_replace( '{EXCERPT}', catanis_string_limit_words(strip_tags($post_meta['port_excerpt']), 60, $btn_viewmore), $liItem );
			}
			
			echo $liItem; 
	
		endwhile;
	endif;
	wp_reset_postdata();
	
	die();
}
