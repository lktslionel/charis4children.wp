<?php 
	global $catanis, $post;
	$catanis_page 	= $catanis->pageconfig;
	$format 		= get_post_format();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('cata-blog-item'); ?>>
	<div class="item">
		<header class="entry-header">
			<div class="single-top-meta">
				<?php if (get_the_title()) : ?>
					<h2 class="title"><?php the_title(); ?></h2>
				<?php endif; ?>
				<div class="meta-info">
					<?php catanis_post_meta(); ?>
				</div>
			</div>
		</header> <!-- end entry-header -->
	
		<div class="entry-content">
			<div class="wrap-entry-content">
				<?php 
					if(empty($format)){ /*standard post*/
						$post_thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
						echo catanis_post_thumbnail(trim($post_thumb_url[0])); 
					}
					
					the_content( '' );
					
					wp_link_pages(array('before' => '<div>' . esc_html__( 'Pages:', 'onelove' ), 'after' => '</div>')); 
				?>	
			</div>
			<div class="clear"></div>
			<?php catanis_post_tags_and_share($post, array('tags')); ?>
		</div> <!-- end entry-content -->
	
		<footer class="entry-footer">
			<?php
			if ( isset($catanis_page['show_author_bio']) && $catanis_page['show_author_bio'] ){
				if ( get_the_author_meta( 'description' ) ) {
					get_template_part( 'author-bio' );
				}
			}
			echo catanis_get_post_navigation_next_and_previous();
			?>
		</footer>  <!-- end entry-footer -->
	</div>
</article>