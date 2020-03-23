<?php
// Get template args
extract(charity_is_hope_template_get_args('post-info'));

$info_parts = array_merge(array(
	'snippets' => false,	// For singular post/page/team/client/service etc.
	'date' => true,
	'author' => false,
	'terms' => true,
	'counters' => true,
	'tag' => 'div'			// 'p' for portfolio hovers 
	), isset($post_options['info_parts']) && is_array($post_options['info_parts']) ? $post_options['info_parts'] : array());

?>
<<?php echo esc_attr($info_parts['tag']); ?> class="post_info">
	<?php
	if ($info_parts['date'] && !in_array($post_data['post_type'], array('players', 'team'))) {
		$post_date = apply_filters('charity_is_hope_filter_post_date', $post_data['post_date_sql'], $post_data['post_id'], $post_data['post_type']);
		$post_date_diff = charity_is_hope_get_date_or_difference($post_date);
		if (!charity_is_hope_param_is_inherit($post_date)) {
			?>
			<span class="post_info_item post_info_posted"><?php 
				echo (in_array($post_data['post_type'], array('post', 'page', 'product')) 
						? ''
						: ($post_date <= date('Y-m-d H:i:s') 
							? esc_html__('Started', 'charity-is-hope') 
							: esc_html__('Will start', 'charity-is-hope'))); 
				?> <a href="<?php echo esc_url($post_data['post_link']); ?>" class="post_info_date<?php echo esc_attr($info_parts['snippets'] ? ' date updated' : ''); ?>"<?php echo !empty($info_parts['snippets']) ? ' itemprop="datePublished" content="'.esc_attr($post_date).'"' : ''; ?>><?php echo esc_html($post_date_diff); ?></a></span>
			<?php
		}
	}
	if ($info_parts['author'] && $post_data['post_type']=='post') {
		?>
		<span class="post_info_item post_info_posted_by<?php echo !empty($info_parts['snippets']) ? ' vcard' : ''; ?>"<?php echo !empty($info_parts['snippets']) ? ' itemprop="author"' : ''; ?>><?php esc_html_e('by', 'charity-is-hope'); ?> <a href="<?php echo esc_url($post_data['post_author_url']); ?>" class="post_info_author"><?php charity_is_hope_show_layout($post_data['post_author']); ?></a></span>
	<?php 
	}
	if ($info_parts['terms'] && !empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_links)) {
		?>
		<span class="post_info_item post_info_tags"><?php esc_html_e('in', 'charity-is-hope'); ?> <?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_links); ?></span>
		<?php
	}
	if ($info_parts['counters'] && !empty($post_options['counters'])) {
		?>
		<span class="post_info_item post_info_counters"><?php
			charity_is_hope_template_set_args('counters', array(
				'post_options' => $post_options,
				'post_data' => $post_data
			));
			get_template_part(charity_is_hope_get_file_slug('templates/_parts/counters.php')); 
		?></span>
		<?php
	}
	if (is_single() && !charity_is_hope_storage_get('blog_streampage') && ($post_data['post_edit_enable'] || $post_data['post_delete_enable'])) {
		?>
		<span class="frontend_editor_buttons">
			<?php if ($post_data['post_edit_enable']) { ?>
			<span class="post_info_item post_info_button post_info_button_edit"><a id="frontend_editor_icon_edit" class="icon-pencil" title="<?php esc_attr_e('Edit post', 'charity-is-hope'); ?>" href="#"><?php esc_html_e('Edit', 'charity-is-hope'); ?></a></span>
			<?php } ?>
			<?php if ($post_data['post_delete_enable']) { ?>
			<span class="post_info_item post_info_button post_info_button_delete"><a id="frontend_editor_icon_delete" class="icon-trash" title="<?php esc_attr_e('Delete post', 'charity-is-hope'); ?>" href="#"><?php esc_html_e('Delete', 'charity-is-hope'); ?></a></span>
			<?php } ?>
		</span>
		<?php
	}
	?>
</<?php echo esc_attr($info_parts['tag']); ?>>