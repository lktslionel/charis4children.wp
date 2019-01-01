<?php
	global $catanis, $post;
	$catanis_page = $catanis->pageconfig;
	
	$post_meta = get_post_meta( $post->ID, Catanis_Meta::$meta_key, true );
	$portfolio_type = $catanis_page['port_type'];
	$portfolio_layout = $post_meta['port_layout_style'];
	$_main_class = ( ! empty( $catanis_page['layout'] ) && $catanis_page['layout'] != 'full') ? 'col-md-9' : 'col-md-12';
?>
<?php get_header(); ?>
<div class="page-template container <?php catanis_extend_class_page(true); ?>">
	<?php if ( $catanis_page['layout'] == 'left' ): get_sidebar(); endif;?>	
	
	<div id="cata-main-content" class="<?php echo esc_attr($_main_class); ?>">
		<?php while ( have_posts() ) : the_post(); ?>
		<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<div class="cata-project-detail cata-project-<?php echo $portfolio_type; ?> cata-port-layout-<?php echo esc_attr($portfolio_layout); ?>"> 
					
					<?php if($portfolio_type == 'verticalsticky-sidebar' || $portfolio_layout =='style2' ) : ?>
						<div class="cata-project-content-wrap"> 
							<div class="cata-project-content"> 
								<div class="cata-project-type"> 
									<?php catanis_get_portfolio_type_in_single($portfolio_type, $post_meta); ?>
								</div>
							</div>
							<div class="cata-project-info<?php echo ($portfolio_type == 'verticalsticky-sidebar') ? ' cata-sidebar-fixed' : ''; ?>"> 
								<div class="cata-wrapper">
									<h3 class="cata-project-title"><?php the_title(); ?></h3>
									<div class="cata-project-content-verticalsticky"> 
										<?php echo do_shortcode( apply_filters( 'the_content', $post->post_content ) ); ?>
									</div>
									
									<?php catanis_get_project_detail_portfolio( $post, $post_meta ); ?>	
								</div>
							</div>
						</div>	
						
					<?php else: ?>
					
						<?php if($portfolio_type != 'none') : ?>
						<div class="cata-project-type"> 
							<?php catanis_get_portfolio_type_in_single($portfolio_type, $post_meta); ?>
						</div>
						<?php endif; ?>
						
						<div class="cata-project-content-wrap"> 
							<div class="cata-project-content"> 
								<h3 class="cata-project-title"><?php echo the_title(); ?></h3>
								<?php //echo wpautop($post_meta['port_excerpt']); ?>
								<?php echo do_shortcode( apply_filters( 'the_content', $post->post_content ) ); ?>
							</div>
							<div class="cata-project-info"> 
								<?php catanis_get_project_detail_portfolio( $post, $post_meta ); ?>	
							</div>
						</div>	
					<?php endif;?>
					
					<?php if(isset($post_meta['custom_content']) && !empty($post_meta['custom_content'])) : ?>
						<div class="cata-project-custom-content"> 
							<?php echo do_shortcode( apply_filters( 'the_content', $post_meta['custom_content'] ) ); ?>
						</div>
					<?php endif; ?>
				</div>
				
				<?php 
				/*---RELATED PORTFOLIO---*/
				if(isset($catanis_page['show_related_portfolio']) && $catanis_page['show_related_portfolio']) :
					$portTerms = array();
					$portTaxonomyRelate = wp_get_post_terms( $post->ID, CATANIS_TAXONOMY_PORTFOLIO );
						
					if ( !is_array( $portTaxonomyRelate ) ){
						$portTaxonomyRelate = array();
					}
					
					if ( count( $portTaxonomyRelate) > 0 ) {
						foreach ( $portTaxonomyRelate as $term ) {
							if ( $term->count > 0 ) {
								array_push( $portTerms, $term->term_id );
							}
						}
					}
					
					$related_columns = 3;
					if(! empty ( $catanis_page ['layout'] ) && $catanis_page ['layout'] != 'full'){
						$related_columns = 2;
					}
					
					if(!empty( $portTaxonomyRelate ) && count( $portTerms ) > 0 ){
						$args = array(
							'post_type' 		=> CATANIS_POSTTYPE_PORTFOLIO,
							'tax_query'			=> array(
								array(
									'taxonomy' 	=> CATANIS_TAXONOMY_PORTFOLIO,
									'field' 	=> 'id',
									'terms' 	=> $portTerms
								)
							),
							'post__not_in' 		=> array( $post->ID ),
							'posts_per_page'	=> $related_columns*3
						);
					}else{
						$args = array(
							'post_type'		=> $post->post_type,
							'post__not_in'	=> array( $post->ID ),
							'posts_per_page' => $related_columns*3
						);
					}
					$related = new WP_Query( $args );
				
					$arrParams = array();
					$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
					$relatedClass = ' cata-portfolio cata-hover-style3 cata-has-animation cata-fadeInUp dots-line cata-cols'.$related_columns;
					if ( $related->post_count >= $related_columns ) {
						$relatedClass .= ' cata-slick-slider';

						$arrParams = array(
							'autoplay' 			=> true,
							'autoplaySpeed' 	=> 2000,
							'slidesToShow' 		=> intval($related_columns),
							'slidesToScroll' 	=> intval($related_columns),
							'dots' 				=> true,
							'arrows' 			=> false,
							'infinite' 			=> true,
							'draggable' 		=> false,
							'speed' 			=> 1000,
							'rtl' 				=> CATANIS_RTL,
							'adaptiveHeight' 	=> true,
							'responsive'		=> array(
								array(
									'breakpoint'	=> 1024,
									'settings'		=> array(
										'slidesToShow'		=> 2,
										'slidesToScroll' 	=> 2
									)
								),
								array(
									'breakpoint'	=> 768,
									'settings'		=> array(
										'slidesToShow'		=> 2,
										'slidesToScroll' 	=> 2
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
					}
				?>
					<div class="cata-heart-line cata-has-animation cata-fadeInUp"></div>
					<div class="cata-related cata-related-portfolio">
						<div class="related_title">
							<?php 
								$sc_title 	= '[cata_heading_title main_style="style1" small_title="'. esc_html__('RELATED PORTFOLIO', 'catanis-core') .'" large_title="'. esc_html__('You May Also Like', 'catanis-core') .'"';
								$sc_title 	.= ' text_align="text-center" use_animation="yes" animation_type="slideInUp" ext_class="cata-related-port-heading"]';
								echo do_shortcode($sc_title);
							?>
						</div>
						
						<?php if ( $related->have_posts()): ?>
						<div<?php echo rtrim($dir); ?> class="<?php echo $relatedClass; ?>" id="relate_port<?php echo mt_rand(); ?>">
							<ul class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
							<?php
								while ( $related->have_posts() ) : 
									$related->the_post();
								
									$post_title 		= get_the_title( $post->ID );
									$post_url 			= get_permalink( $post->ID );
									
									$term_list 			= implode( ' ', wp_get_post_terms( $post->ID, CATANIS_TAXONOMY_PORTFOLIO, array( "fields" => "slugs" ) ) );
									$term_list_comma 	= get_the_term_list( $post->ID, CATANIS_TAXONOMY_PORTFOLIO, '', ', ', '');
									
									$post_meta 			= get_post_meta( $post->ID, Catanis_Meta::$meta_key, true );
									$preview_img		= catanis_get_portfolio_preview_img( $post->ID, true, 'medium' );
									$post_thumb_url 	= trim($preview_img['img']);
									
									if( empty($post_thumb_url) && !empty($post_meta['port_custom_thumbnail']) ){
										$preview_img		= catanis_get_portfolio_preview_img( $post->ID, false, 'full' );
										$post_thumb_url 	= trim($preview_img['img']);
									}
									
									$bg_color	 		= 'rgba(255, 255, 255, .9);';
									if ( isset( $post_meta['portfolio_hover_color'] ) && ! empty( $post_meta['port_hover_color'] ) ) {
										$bg_color 		= implode( ',', catanis_hex2rgba( $post_meta['port_hover_color'], '.8' ) );
										$bg_color 		= "rgba({$bg_color})";
									}
									?>
									<li class="cata-isotope-item">
										<div class="cata-isotope-item-inner"><div class="cata-has-animation cata-fadeInUp">
											<a href="<?php the_permalink(); ?>" class="cata-item-url"></a>
											<div class="cata-bg-overlay" style="background: <?php echo esc_html( $bg_color ); ?>"></div>
											<div class="cata-love-counter"><?php $catanis->love->get_love(true ); ?></div>
										
											<div class="cata-item-image">
												<img src="<?php echo esc_url( $post_thumb_url ); ?>" alt="<?php echo esc_attr( $post_title ); ?>">
											</div>
											<div class="cata-item-info">
												<h4 class="cata-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $post_title ); ?>"><?php echo esc_attr( $post_title ); ?></a></h4>
												<p class="cata-cates"><?php echo $term_list_comma; ?></p>
											</div>
										</div></div>
									</li>
									
									<?php
								endwhile;
								wp_reset_postdata();
							?>
							</ul>
						</div>
						<?php else: ?>
							<div class="no-items woocommerce-info"><?php esc_html_e( 'Sorry, no post found!', 'catanis-core'); ?></div>
						<?php endif;?>
					</div>
					<?php endif; /*-- END RELATED PORTFOLIO */?>
					
				<?php 
				if ((comments_open () || get_comments_number ()) && (isset($catanis_page['comment_enable']) && $catanis_page['comment_enable']) ) :
					comments_template ( '', true );
				endif;
				?>			
			</div>	
		</div>	
		<?php endwhile; ?>
	</div>
	<?php if ( $catanis_page['layout'] == 'right' ) : get_sidebar(); endif; ?>
</div> <!-- end container -->

<?php 
	/*---NAVIGATION PORTFOLIO---*/
	$next_post = get_next_post();
	$prev_post = get_previous_post();
	
	$pageback_url = '#';
	if(isset($catanis_page['pageback_portfolio']) && !empty($catanis_page['pageback_portfolio'])){
		$pageback_url = get_page_link($catanis_page['pageback_portfolio']);
	}
?>
<?php if ( is_a( $prev_post , 'WP_Post' ) || is_a( $next_post , 'WP_Post' ) ): ?>
<div id="port_single_navigation" class="cata-has-animation cata-fadeInUp">
	<div class="container">
		<div class="cata-port-navigation navi-project"> 
			<div class="cata-navi-prev"> 
				<?php  if ( is_a( $prev_post, 'WP_Post' ) ): 
					previous_post_link( '%link', '<i class="fa fa-angle-left"></i> <span>'. esc_html__( 'PREV', 'catanis-core'). '</span>' ); 
				endif; 
				?>
			</div>
			
			<div class="cata-navi-center"> 
				<a href="<?php echo esc_url($pageback_url); ?>" title=""><i class="ti-layout-grid3"></i></a>
			</div>
			
			<div class="cata-navi-next"> 
				<?php  if ( is_a( $next_post, 'WP_Post' ) ):
					next_post_link( '%link', '<span>'. esc_html__( 'NEXT', 'catanis-core'). '</span> <i class="fa fa-angle-right"></i>' );
				endif; ?>
			</div>
		</div>
			
	</div>
</div>
<?php endif; ?>
	
<?php get_footer(); ?>