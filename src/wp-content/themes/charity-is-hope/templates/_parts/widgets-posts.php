<?php
// Get template args
extract(charity_is_hope_template_get_args('widgets-posts'));

$post_id = get_the_ID();
$post_date = charity_is_hope_get_date_or_difference(apply_filters('charity_is_hope_filter_post_date', get_the_date('Y-m-d H:i:s'), $post_id, get_post_type()));
$post_title = get_the_title();
$post_link = !isset($show_links) || $show_links ? get_permalink($post_id) : '';

$widget_posts_output = '<article class="post_item' . ($show_image == 0 ? ' no_thumb' : ' with_thumb') . ($post_number==1 ? ' first' : '') . '">';

if ($show_image) {
	$post_thumb = charity_is_hope_get_resized_image_tag($post_id, 108, 82);
	if ($post_thumb) {
		$widget_posts_output .= '<div class="post_thumb">' . ($post_thumb) . '</div>';
	}
}

$widget_posts_output .= '<div class="post_content">'
			.'<h6 class="post_title">'
			.($post_link ? '<a href="' . esc_url($post_link) . '">' : '') . ($post_title) . ($post_link ? '</a>' : '')
			.'</h6>';

$post_counters = $post_counters_icon = '';

if ($show_counters && !charity_is_hope_param_is_off($show_counters)) {

	if (charity_is_hope_strpos($show_counters, 'views')!==false) {
		$post_counters = charity_is_hope_storage_isset('post_data_'.$post_id) && charity_is_hope_storage_get_array('post_data_'.$post_id, 'post_options_counters') 
							? charity_is_hope_storage_get_array('post_data_'.$post_id, 'post_views') 
							: charity_is_hope_get_post_views($post_id);
		$post_counters_icon = 'post_counters_views icon-eye-inv';

	} else if (charity_is_hope_strpos($show_counters, 'likes')!==false) {
		$likes = isset($_COOKIE['charity_is_hope_likes']) ? $_COOKIE['charity_is_hope_likes'] : '';
		$allow = charity_is_hope_strpos($likes, ','.($post_id).',')===false;
		$post_counters = charity_is_hope_storage_isset('post_data_'.$post_id) && charity_is_hope_storage_get_array('post_data_'.$post_id, 'post_options_counters') 
							? charity_is_hope_storage_get_array('post_data_'.$post_id, 'post_likes') 
							: charity_is_hope_get_post_likes($post_id);
		$post_counters_icon = 'post_counters_likes icon-heart '.($allow ? 'enabled' : 'disabled');
		charity_is_hope_enqueue_messages();

	} else if (charity_is_hope_strpos($show_counters, 'stars')!==false || charity_is_hope_strpos($show_counters, 'rating')!==false) {
		$post_counters = charity_is_hope_reviews_marks_to_display(charity_is_hope_storage_isset('post_data_'.$post_id) && charity_is_hope_storage_get_array('post_data_'.$post_id, 'post_options_reviews')
							? charity_is_hope_storage_get_array('post_data_'.$post_id, $post_rating) 
							: get_post_meta($post_id, $post_rating, true));
		$post_counters_icon = 'post_counters_rating icon-star';

	} else {
		$post_counters = charity_is_hope_storage_isset('post_data_'.$post_id) && charity_is_hope_storage_get_array('post_data_'.$post_id, 'post_options_counters') 
							? charity_is_hope_storage_get_array('post_data_'.$post_id, 'post_comments') 
							: get_comments_number($post_id);
		$post_counters_icon = 'post_counters_comments icon-comment-inv';
	}

	if (charity_is_hope_strpos($show_counters, 'stars')!==false && $post_counters > 0) {
		if (charity_is_hope_strpos($post_counters, '.')===false) 
			$post_counters .= '.0';
		if (charity_is_hope_get_custom_option('show_reviews')=='yes') {
			$widget_posts_output .= '<div class="post_rating reviews_summary blog_reviews">'
				. '<div class="criteria_summary criteria_row">' . trim(charity_is_hope_reviews_get_summary_stars($post_counters, false, false, 5)) . '</div>'
				. '</div>';
		}
	}
}

if ($show_date || $show_counters || $show_author) {
	$widget_posts_output .= '<div class="post_info">';
	if ($show_date) {
		$widget_posts_output .= '<span class="post_info_item post_info_posted">'.($post_link ? '<a href="' . esc_url($post_link) . '" class="post_info_date">' : '') . ($post_date) . ($post_link ? '</a>' : '').'</span>';
	}
	if ($show_author) {
		if (charity_is_hope_storage_isset('post_data_'.$post_id)) {
			$post_author_id		= charity_is_hope_storage_get_array('post_data_'.$post_id, 'post_author_id');
			$post_author_name	= charity_is_hope_storage_get_array('post_data_'.$post_id, 'post_author');
			$post_author_url	= charity_is_hope_storage_get_array('post_data_'.$post_id, 'post_author_url');
		} else {
			$post_author_id   = get_the_author_meta('ID');
			$post_author_name = get_the_author_meta('display_name', $post_author_id);
			$post_author_url  = get_author_posts_url($post_author_id, '');
		}
		$widget_posts_output .= '<span class="post_info_item post_info_posted_by">' . esc_html__('by', 'charity-is-hope') . ' ' . ($post_link ? '<a href="' . esc_url($post_author_url) . '" class="post_info_author">' : '') . ($post_author_name) . ($post_link ? '</a>' : '') . '</span>';
	}
	if ($show_counters && charity_is_hope_strpos($show_counters, 'stars')===false) {
		$post_counters_link = charity_is_hope_strpos($show_counters, 'comments')!==false 
									? get_comments_link( $post_id ) 
									: (charity_is_hope_strpos($show_counters, 'likes')!==false
									    ? '#'
									    : $post_link
									    );
		$widget_posts_output .= '<span class="post_info_item post_info_counters">'
			. ($post_counters_link ? '<a href="' . esc_url($post_counters_link) . '"' : '<span') 
				. ' class="post_counters_item ' . esc_attr($post_counters_icon) . '"'
				. (charity_is_hope_strpos($show_counters, 'likes')!==false
					? ' title="' . ($allow ? esc_attr__('Like', 'charity-is-hope') : esc_attr__('Dislike', 'charity-is-hope')) . '"'
						. ' data-postid="' . esc_attr($post_id) . '"'
                        . ' data-likes="' . esc_attr($post_counters) . '"'
                        . ' data-title-like="' . esc_attr__('Like', 'charity-is-hope') . '"'
                        . ' data-title-dislike="' . esc_attr__('Dislike', 'charity-is-hope') . '"'
					: ''
				)
				. '>'
			. '<span class="post_counters_number">' . ($post_counters) . '</span>'
			. ($post_counters_link ? '</a>' : '</span>')
			. '</span>';
	}
	$widget_posts_output .= '</div>';
}
$widget_posts_output .= '</div>'
		.'</article>';

// Return result
charity_is_hope_storage_set('widgets_posts_output', $widget_posts_output);
?>