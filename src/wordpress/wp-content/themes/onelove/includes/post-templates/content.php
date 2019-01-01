<?php 
	global $catanis, $post;
	$catanis_page = $catanis->pageconfig;
	
	$format 		= get_post_format();
	if(empty($format)){
		$format = 'default';
	}
	$post_title		= get_the_title();
	$post_meta 		= get_post_meta( $post->ID, Catanis_Meta::$meta_key, true );
	$term_list 		= implode( ' ', wp_get_post_terms( $post->ID, 'category', array( "fields" => "slugs" ) ) );
	$term_list 		.= ' cata-isotope-item cata-blog-item';
	$term_list 		.= isset($post_meta['post_thumbnail_type']) ? ' '. $post_meta['post_thumbnail_type'] : '';
	$term_list 		.= ( !has_post_thumbnail() || post_password_required() ) ? ' cata-blog-nothumb' : '';
	
	if(isset($post_meta['audio_type']) && $post_meta['audio_type'] == 'soundcloud' && isset($post_meta['audio_soundcloud']) && !empty($post_meta['audio_soundcloud'])){
		if ( !preg_match("/visual=true/i", $post_meta['audio_soundcloud']) ) {
			$term_list 		.= ' format-audio-soundcloud';
		}
	}
	
	$post_style 	= catanis_option('blog_style');
	if(!in_array($post_style, array('list', 'onecolumn', 'masonry', 'grid'))){
		$post_style 	= 'onecolumn';
	}
	$post_style 	= (isset($catanis_page['layout']) && $catanis_page['layout'] != 'full' && $post_style == 'list') ? 'onecolumn' : $post_style;
		
	$_config_opts = catanis_option('blog_exclude_sections');
	if ( !is_array( $_config_opts )){
		$_config_opts = explode(',', $_config_opts);
	}
	
	$blog_post_summary 	= catanis_option('blog_post_summary');
	$excerpt_length 	= catanis_option('blog_excerpt_length');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post '. $term_list); ?>>
	<div class="item cata-has-animation cata-fadeInUp">
		<?php if( in_array($post_style, array('list', 'onecolumn')) ) : ?>
			<div class="cata-heart-line cata-has-animation cata-fadeInUp"></div>
		<?php endif; ?>	

		<?php if( in_array($post_style, array('list', 'onecolumn')) ) : ?>
			<?php if( !in_array($format, array('quote', 'link'))): ?>
			<header class="entry-header">
				<?php if ($post_title) : ?>
					<h3 class="cata-blog-item-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ($post_title); ?></a>
					</h3>
				<?php endif; ?>
				
				<div class="meta-info">
					<?php catanis_post_meta(); ?>
				</div>
			</header> 
			<?php endif;?>
			
			<div class="entry-content">
				<div class="post-<?php echo esc_attr($format); ?> cata-post-format">
					<?php catanis_get_post_format_in_loop($format, $post_style, $post_meta); ?>
				</div>
				
				<?php if( !in_array($format, array('quote', 'link'))) : ?>
					<?php catanis_get_post_item_excerpt($excerpt_length, $blog_post_summary); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>	
				
		<?php if( in_array($post_style, array('masonry', 'grid')) ) : ?>
				
			<?php if( !in_array($format, array('quote', 'link'))) : ?>
			<header class="entry-header">
				<div class="post-<?php echo esc_attr($format); ?> cata-post-format">
					<?php catanis_get_post_format_in_loop($format, $post_style, $post_meta); ?>
				</div>
			</header> 
			<?php endif; ?>	
			
			<div class="entry-content">
				<?php if( in_array($format, array('quote', 'link'))) : ?>
					<div class="post-<?php echo esc_attr($format); ?> cata-post-format">
						<?php catanis_get_post_format_in_loop($format, $post_style, $post_meta); ?>
					</div>
				<?php else: ?>	
				
					<?php if ($post_title) : ?>
					<h3 class="cata-blog-item-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ($post_title); ?></a>
					</h3>
					<?php endif; ?>
				
					<div class="meta-info">
						<?php catanis_post_meta(); ?>
					</div>
					<?php catanis_get_post_item_excerpt($excerpt_length, $blog_post_summary); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>	
		
	</div>
</article>