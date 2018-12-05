<?php 
	$cls_popup = '';
	$post_url 	= get_permalink( $post->ID );
	
	$format 		= get_post_format();
	if(empty($format)){
		$format = 'default';
	}
?>
	
<article id="post-<?php the_ID(); ?>" <?php post_class('post search-item cata-isotope-item cata-blog-item cata-default-masonry-item'); ?>>
	<div class="item cata-has-animation cata-fadeInUp<?php if( !has_post_thumbnail() || post_password_required() ) { echo ' no-thumb cata-blog-nothumb'; } ?>">
		
		<header class="entry-header"> 
			<?php echo catanis_post_thumbnail(); ?>
		</header>

		<div class="entry-content">
			<h3 class="title"><a href="<?php echo esc_url( $post_url ); ?>" class="<?php echo esc_attr($cls_popup); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			<div class="wrap-entry-content cata-blog-item-excerpt">
				<?php the_excerpt(); ?>
				<a href="<?php the_permalink(); ?>" class="read-more">
					<span class="more-arrow"><i class="fa fa-caret-right"></i></span>
					<?php esc_html_e( 'Read More', 'onelove' ); ?>
				</a>
			</div>
		</div> <!-- end entry-content -->
		
	</div>
</article>