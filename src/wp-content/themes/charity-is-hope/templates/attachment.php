<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'charity_is_hope_template_attachment_theme_setup' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_template_attachment_theme_setup', 1 );
	function charity_is_hope_template_attachment_theme_setup() {
		charity_is_hope_add_template(array(
			'layout' => 'attachment',
			'mode'   => 'internal',
			'title'  => esc_html__('Attachment page layout', 'charity-is-hope'),
			'thumb_title'  => esc_html__('Fullwidth image', 'charity-is-hope'),
			'w'		 => 1170,
			'h'		 => null,
			'h_crop' => 659
		));
	}
}

// Template output
if ( !function_exists( 'charity_is_hope_template_attachment_output' ) ) {
	function charity_is_hope_template_attachment_output($post_options, $post_data) {
		$post_data['post_views']++;
		$title_tag = charity_is_hope_get_custom_option('show_page_title')=='yes' ? 'h3' : 'h1';
		?>
		<article <?php post_class('post_item post_item_attachment template_attachment'); ?>>
		
			<<?php echo esc_html($title_tag); ?> class="post_title"><?php echo !empty($post_data['post_excerpt']) ? strip_tags($post_data['post_excerpt']) : $post_data['post_title']; ?></<?php echo esc_html($title_tag); ?>>

			<div class="post_featured">
				<div class="post_thumb post_nav" data-image="<?php echo esc_url($post_data['post_attachment']); ?>" data-title="<?php echo esc_attr($post_data['post_title']); ?>">
					<?php
					charity_is_hope_show_layout($post_data['post_thumb']);
					$post = get_post();
					$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
					if (is_array($attachments) && count($attachments) > 0) {
						foreach ($attachments as $k => $attachment) {
							if ( $attachment->ID == $post->ID )
								break;
						}
					}
					if ( isset( $attachments[ $k-1 ] ) ) {
						$link = get_permalink( $attachments[ $k-1 ]->ID ).'#top_of_page';
						$desc = charity_is_hope_strshort(!empty($attachments[ $k-1 ]->post_excerpt) ? $attachments[ $k-1 ]->post_excerpt : $attachments[ $k-1 ]->post_title, 30);
						?>
						<a class="post_nav_item post_nav_prev" href="<?php echo esc_url($link); ?>">
							<span class="post_nav_info">
								<span class="post_nav_info_title"><?php esc_html_e('Previous item', 'charity-is-hope'); ?></span>
								<span class="post_nav_info_description"><?php charity_is_hope_show_layout($desc); ?></span>
							</span>
						</a>
						<?php
					}
					if ( isset( $attachments[ $k+1 ] ) ) {
						$link = get_permalink( $attachments[ $k+1 ]->ID ).'#top_of_page';
						$desc = charity_is_hope_strshort(!empty($attachments[ $k+1 ]->post_excerpt) ? $attachments[ $k+1 ]->post_excerpt : $attachments[ $k+1 ]->post_title, 30);
						?>
						<a class="post_nav_item post_nav_next" href="<?php echo esc_url($link); ?>">
							<span class="post_nav_info">
								<span class="post_nav_info_title"><?php esc_html_e('Next item', 'charity-is-hope'); ?></span>
								<span class="post_nav_info_description"><?php charity_is_hope_show_layout($desc); ?></span>
							</span>
						</a>
						<?php
					}
					?>
				</div>
			</div>
		
			<?php
			if (!$post_data['post_protected'] && charity_is_hope_get_custom_option('show_post_info')=='yes') {
				charity_is_hope_template_set_args('post-info', array(
					'post_options' => $post_options,
					'post_data' => $post_data
				));
				get_template_part(charity_is_hope_get_file_slug('templates/_parts/post-info.php')); 
			}
			?>
		
			<div class="post_content">
				<?php
				// Post content
				if ($post_data['post_protected']) { 
					charity_is_hope_show_layout($post_data['post_excerpt']);
				} else {
					echo !empty($post_data['post_content']) ? trim($post_data['post_content']) : esc_html__('No image description ...', 'charity-is-hope'); 
					wp_link_pages( array( 
						'before' => '<div class="nav_pages_parts"><span class="pages">' . esc_html__( 'Pages:', 'charity-is-hope' ) . '</span>', 
						'after' => '</div>',
						'link_before' => '<span class="page_num">',
						'link_after' => '</span>'
					) ); 
					
					if ( charity_is_hope_get_custom_option('show_post_tags') == 'yes' && !empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links)) {
						?>
						<div class="post_info post_info_bottom">
							<span class="post_info_item post_info_tags"><?php esc_html_e('Tags:', 'charity-is-hope'); ?> <?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links); ?></span>
						</div>
						<?php 
					}
				}
				?>
			
			</div>	<!-- /.post_content -->
		
		</article>

		<section class="related_wrap related_wrap_empty"></section>

		<?php	
		// Show comments
		if ( !$post_data['post_protected'] && (comments_open() || get_comments_number() != 0) ) {
			comments_template();
		}
	}
}
?>