<?php 
	global $catanis;
	
	$catanis_page = $catanis->pageconfig;
	$_main_class = (!empty($catanis_page['layout']) && $catanis_page['layout'] != 'full') ? 'col-md-9' : 'col-md-12';
?>
<?php get_header(); ?>
<div id="container" class="page-template container <?php catanis_extend_class_page(true); ?>">
	<div id="cata-main-content" class="<?php echo esc_attr($_main_class); ?>">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="item">
				<header class="entry-header">
					<p class="attachment">
						<?php if ( wp_attachment_is_image( $post->id ) ) : $att_image = wp_get_attachment_image_src( $post->id, "full"); ?>
						<a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>" rel="attachment">
							<img src="<?php echo esc_url($att_image[0]); ?>" width="<?php echo esc_html($att_image[1]); ?>" height="<?php echo esc_html($att_image[2]); ?>"  class="attachment-medium" alt="<?php $post->post_excerpt; ?>" />
						</a>
						<?php else : ?>
							<a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo esc_html( get_the_title( $post->ID ), 1 ) ?>" rel="attachment"><?php echo basename( $post->guid ); ?></a>
						<?php endif; ?>
					</p>
				</header> 
			</div>
		</article>
	</div> 
</div>
<?php get_footer(); ?>