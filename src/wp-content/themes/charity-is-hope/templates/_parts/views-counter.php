<?php 
if (is_singular()) {
	if (charity_is_hope_get_theme_option('use_ajax_views_counter')=='yes') {
		charity_is_hope_storage_set_array('js_vars', 'ajax_views_counter', array(
			'post_id' => get_the_ID(),
			'post_views' => charity_is_hope_get_post_views(get_the_ID())
		));
	} else
		charity_is_hope_set_post_views(get_the_ID());
}
?>