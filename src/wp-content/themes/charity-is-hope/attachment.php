<?php
/**
 * Attachment page
 */
get_header(); 

while ( have_posts() ) { the_post();

	// Move charity_is_hope_set_post_views to the javascript - counter will work under cache system
	if (charity_is_hope_get_custom_option('use_ajax_views_counter')=='no') {
		charity_is_hope_set_post_views(get_the_ID());
	}

	charity_is_hope_show_post_layout(
		array(
			'layout' => 'attachment',
			'sidebar' => !charity_is_hope_param_is_off(charity_is_hope_get_custom_option('show_sidebar_main'))
		)
	);

}

get_footer();
?>