<?php 
	global $catanis, $post;
	$catanis_page = $catanis->pageconfig;
	
	$related_excerpt = catanis_option('blog_single_related_excerpt');
	$_cat_list = get_the_category( $post->ID );
	$_cat_list_arr = array();
	foreach ( $_cat_list as $_cat_item ) {
		array_push( $_cat_list_arr, $_cat_item->term_id );
	}

	$_list_cat_id = implode( $_cat_list_arr, "," );
	if ( ! empty( $_cat_list ) ) {
		$args = array(
			'post_type' 		=> $post->post_type,
			'cat' 				=> $_list_cat_id,
			'post__not_in' 		=> array( $post->ID ),
			'posts_per_page' 	=> 6
		);
	} else {
		$args = array(
			'post_type' 		=> $post->post_type,
			'post__not_in' 		=> array($post->ID),
			'posts_per_page' 	=> 6
		);
	}
	
	$related = new WP_Query( $args );

	$related_columns = 3;
	if(! empty ( $catanis_page ['layout'] ) && $catanis_page ['layout'] != 'full'){
		$related_columns = 2;
	}

	$arrParams = array();
	$relatedClass = 'cata-has-animation cata-fadeInUp dots-line cata-cols'.$related_columns;
	$dir = (CATANIS_RTL) ? ' dir="rtl"' : '';
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
<div class="container cata-related cata-related-post">
	<div class="cata-heart-line cata-has-animation cata-fadeInUp"></div>
	<div class="related_title">
		<?php 
			$sc_title 	= '[cata_heading_title main_style="style1" small_title="'. esc_html__('RELATED POSTS', 'onelove') .'" large_title="'. esc_html__('You May Also Like', 'onelove') .'"';
			$sc_title 	.= ' text_align="text-center" use_animation="yes" animation_type="slideInUp" ext_class="cata-related-post-heading"]';
			$sc_title 	.= '[/cata_heading_title]';
			echo do_shortcode($sc_title);
		?>
	</div>
	
	<?php if ( $related->have_posts()): ?>
	<div<?php echo rtrim($dir); ?> id="relate_post<?php echo mt_rand(); ?>" class="<?php echo esc_attr($relatedClass); ?>">
		<ul class="slides" data-slick='<?php echo json_encode($arrParams); ?>'>
			<?php
			while ( $related->have_posts() ) : 
				$related->the_post(); 
				$post_meta 		= get_post_meta( $post->ID, Catanis_Meta::$meta_key, true );
			?>
				<li class="cata-item">
					<header class="entry-header">
						<div class="post-default">
							<?php catanis_get_post_format_in_loop('default', 'grid', $post_meta); ?>
						</div>
					</header>
					
					<div class="entry-content">
						<h3 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						<?php catanis_post_meta(array('date')); ?>
						
						<?php if($related_excerpt['status']): ?>
							<div class="short-desc">
								<?php echo catanis_string_limit_words( apply_filters( 'get_the_excerpt', $post->post_excerpt ), $related_excerpt['length'], '...'); ?>
							</div>
						<?php endif; ?>
					</div>
				</li>
			<?php
			endwhile;
			wp_reset_postdata();
		?>
		</ul>
	</div>
	<?php else: ?>
		<div class="no-items woocommerce-info"><?php esc_html_e( 'Sorry, no post found!', 'onelove'); ?></div>
	<?php endif;?>
</div>
