<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'charity_is_hope_template_date_theme_setup' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_template_date_theme_setup', 1 );
	function charity_is_hope_template_date_theme_setup() {
		charity_is_hope_add_template(array(
			'layout' => 'date',
			'mode'   => 'blogger',
			'title'  => esc_html__('Blogger layout: Timeline', 'charity-is-hope')
			));
	}
}

// Template output
if ( !function_exists( 'charity_is_hope_template_date_output' ) ) {
	function charity_is_hope_template_date_output($post_options, $post_data) {
		if (charity_is_hope_param_is_on($post_options['scroll'])) charity_is_hope_enqueue_slider();
		charity_is_hope_template_set_args('reviews-summary', array(
			'post_options' => $post_options,
			'post_data' => $post_data
		));
		get_template_part(charity_is_hope_get_file_slug('templates/_parts/reviews-summary.php'));
		$reviews_summary = charity_is_hope_storage_get('reviews_summary');
		?>
		
		<div class="post_item sc_blogger_item
			<?php if ($post_options['number'] == $post_options['posts_on_page'] && !charity_is_hope_param_is_on($post_options['loadmore'])) echo ' sc_blogger_item_last'; ?>"
			<?php echo 'horizontal'==$post_options['dir'] ? ' style="width:'.(100/$post_options['posts_on_page']).'%"' : ''; ?>>
			<div class="sc_blogger_date">
				<span class="day_month"><?php charity_is_hope_show_layout($post_data['post_date_part1']); ?></span>
				<span class="year"><?php charity_is_hope_show_layout($post_data['post_date_part2']); ?></span>
			</div>

			<div class="post_content">
				<h6 class="post_title sc_title sc_blogger_title">
					<?php echo (!isset($post_options['links']) || $post_options['links'] ? '<a href="' . esc_url($post_data['post_link']) . '">' : ''); ?>
					<?php charity_is_hope_show_layout($post_data['post_title']); ?>
					<?php echo (!isset($post_options['links']) || $post_options['links'] ? '</a>' : ''); ?>
				</h6>
				
				<?php charity_is_hope_show_layout($reviews_summary); ?>
	
				<?php if (charity_is_hope_param_is_on($post_options['info'])) { ?>
				<div class="post_info">
					<span class="post_info_item post_info_posted_by"><?php esc_html_e('by', 'charity-is-hope'); ?> <a href="<?php echo esc_url($post_data['post_author_url']); ?>" class="post_info_author"><?php echo esc_html($post_data['post_author']); ?></a></span>
					<span class="post_info_item post_info_counters">
						<?php echo 'comments'==$post_options['orderby'] || 'comments'==$post_options['counters'] ? esc_html__('Comments', 'charity-is-hope') : esc_html__('Views', 'charity-is-hope'); ?>
						<span class="post_info_counters_number"><?php echo 'comments'==$post_options['orderby'] || 'comments'==$post_options['counters'] ? esc_html($post_data['post_comments']) : esc_html($post_data['post_views']); ?></span>
					</span>
				</div>
				<?php } ?>

			</div>	<!-- /.post_content -->
		
		</div>		<!-- /.post_item -->

		<?php
		if ($post_options['number'] == $post_options['posts_on_page'] && charity_is_hope_param_is_on($post_options['loadmore'])) {
		?>
			<div class="load_more"<?php echo 'horizontal'==$post_options['dir'] ? ' style="width:'.(100/$post_options['posts_on_page']).'%"' : ''; ?>></div>
		<?php
		}
	}
}
?>