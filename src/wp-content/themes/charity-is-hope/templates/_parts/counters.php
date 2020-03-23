<?php
// Get template args
extract(charity_is_hope_template_get_args('counters'));

$show_all_counters = !empty($post_options['counters']);
$counters_tag = is_single() ? 'span' : 'a';

// Views
if ($show_all_counters && charity_is_hope_strpos($post_options['counters'], 'views')!==false) {
	?>
	<<?php charity_is_hope_show_layout($counters_tag); ?> class="post_counters_item post_counters_views icon-eye-inv" title="<?php echo esc_attr( sprintf(esc_html__('Views - %s', 'charity-is-hope'), $post_data['post_views']) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php charity_is_hope_show_layout($post_data['post_views']); ?></span><?php if (charity_is_hope_strpos($post_options['counters'], 'captions')!==false) echo ' '.esc_html__('Views', 'charity-is-hope'); ?></<?php charity_is_hope_show_layout($counters_tag); ?>>
	<?php
}

// Comments
if ($show_all_counters && charity_is_hope_strpos($post_options['counters'], 'comments')!==false) {
	?>
	<a class="post_counters_item post_counters_comments icon-comment-inv" title="<?php echo esc_attr( sprintf(esc_html__('Comments - %s', 'charity-is-hope'), $post_data['post_comments']) ); ?>" href="<?php echo esc_url($post_data['post_comments_link']); ?>"><span class="post_counters_number"><?php charity_is_hope_show_layout($post_data['post_comments']); ?></span><?php if (charity_is_hope_strpos($post_options['counters'], 'captions')!==false) echo ' '.esc_html__('Comments', 'charity-is-hope'); ?></a>
	<?php 
}
 
// Rating
$rating = $post_data['post_reviews_'.(charity_is_hope_get_theme_option('reviews_first')=='author' ? 'author' : 'users')];
if ($rating > 0 && ($show_all_counters && charity_is_hope_strpos($post_options['counters'], 'rating')!==false)) { 
	?>
	<<?php charity_is_hope_show_layout($counters_tag); ?> class="post_counters_item post_counters_rating icon-star" title="<?php echo esc_attr( sprintf(esc_html__('Rating - %s', 'charity-is-hope'), $rating) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php charity_is_hope_show_layout($rating); ?></span></<?php charity_is_hope_show_layout($counters_tag); ?>>
	<?php
}

// Likes
if ($show_all_counters && charity_is_hope_strpos($post_options['counters'], 'likes')!==false) {
	// Load core messages
	charity_is_hope_enqueue_messages();
	$likes = isset($_COOKIE['charity_is_hope_likes']) ? $_COOKIE['charity_is_hope_likes'] : '';
	$allow = charity_is_hope_strpos($likes, ','.($post_data['post_id']).',')===false;
	?>
	<a class="post_counters_item post_counters_likes icon-heart <?php echo !empty($allow) ? 'enabled' : 'disabled'; ?>" title="<?php echo !empty($allow) ? esc_attr__('Like', 'charity-is-hope') : esc_attr__('Dislike', 'charity-is-hope'); ?>" href="#"
		data-postid="<?php echo esc_attr($post_data['post_id']); ?>"
		data-likes="<?php echo esc_attr($post_data['post_likes']); ?>"
		data-title-like="<?php esc_attr_e('Like', 'charity-is-hope'); ?>"
		data-title-dislike="<?php esc_attr_e('Dislike', 'charity-is-hope'); ?>"><span class="post_counters_number"><?php charity_is_hope_show_layout($post_data['post_likes']); ?></span><?php if (charity_is_hope_strpos($post_options['counters'], 'captions')!==false) echo ' '.esc_html__('Likes', 'charity-is-hope'); ?></a>
	<?php
}

// Edit page link
if (charity_is_hope_strpos($post_options['counters'], 'edit')!==false) {
	edit_post_link( esc_html__( 'Edit', 'charity-is-hope' ), '<span class="post_edit edit-link">', '</span>' );
}

// Markup for search engines
if (is_single() && charity_is_hope_strpos($post_options['counters'], 'markup')!==false) {
	?>
	<meta itemprop="interactionCount" content="User<?php echo esc_attr(charity_is_hope_strpos($post_options['counters'],'comments')!==false ? 'Comments' : 'PageVisits'); ?>:<?php echo esc_attr(charity_is_hope_strpos($post_options['counters'], 'comments')!==false ? $post_data['post_comments'] : $post_data['post_views']); ?>" />
	<?php
}
?>