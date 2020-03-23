<?php
/**
 * Single post
 */
get_header(); 

$single_style = charity_is_hope_storage_get('single_style');
if (empty($single_style)) $single_style = charity_is_hope_get_custom_option('single_style');

while ( have_posts() ) { the_post();
	charity_is_hope_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !charity_is_hope_param_is_off(charity_is_hope_get_custom_option('show_sidebar_main')),
			'content' => charity_is_hope_get_template_property($single_style, 'need_content'),
			'terms_list' => charity_is_hope_get_template_property($single_style, 'need_terms')
		)
	);
}

get_footer();
?>