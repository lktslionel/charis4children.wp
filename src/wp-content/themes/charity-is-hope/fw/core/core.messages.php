<?php
/**
 * Charity Is Hope Framework: messages subsystem
 *
 * @package	charity_is_hope
 * @since	charity_is_hope 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('charity_is_hope_messages_theme_setup')) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_messages_theme_setup' );
	function charity_is_hope_messages_theme_setup() {
		// Core messages strings
		add_filter('charity_is_hope_filter_localize_script', 'charity_is_hope_messages_localize_script');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('charity_is_hope_get_error_msg')) {
	function charity_is_hope_get_error_msg() {
		return charity_is_hope_storage_get('error_msg');
	}
}

if (!function_exists('charity_is_hope_set_error_msg')) {
	function charity_is_hope_set_error_msg($msg) {
		$msg2 = charity_is_hope_get_error_msg();
		charity_is_hope_storage_set('error_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('charity_is_hope_get_success_msg')) {
	function charity_is_hope_get_success_msg() {
		return charity_is_hope_storage_get('success_msg');
	}
}

if (!function_exists('charity_is_hope_set_success_msg')) {
	function charity_is_hope_set_success_msg($msg) {
		$msg2 = charity_is_hope_get_success_msg();
		charity_is_hope_storage_set('success_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('charity_is_hope_get_notice_msg')) {
	function charity_is_hope_get_notice_msg() {
		return charity_is_hope_storage_get('notice_msg');
	}
}

if (!function_exists('charity_is_hope_set_notice_msg')) {
	function charity_is_hope_set_notice_msg($msg) {
		$msg2 = charity_is_hope_get_notice_msg();
		charity_is_hope_storage_set('notice_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('charity_is_hope_set_system_message')) {
	function charity_is_hope_set_system_message($msg, $status='info', $hdr='') {
		update_option(charity_is_hope_storage_get('options_prefix') . '_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('charity_is_hope_get_system_message')) {
	function charity_is_hope_get_system_message($del=false) {
		$msg = get_option(charity_is_hope_storage_get('options_prefix') . '_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			charity_is_hope_del_system_message();
		return $msg;
	}
}

if (!function_exists('charity_is_hope_del_system_message')) {
	function charity_is_hope_del_system_message() {
		delete_option(charity_is_hope_storage_get('options_prefix') . '_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('charity_is_hope_messages_localize_script')) {
	//Handler of add_filter('charity_is_hope_filter_localize_script', 'charity_is_hope_messages_localize_script');
	function charity_is_hope_messages_localize_script($vars) {
		$vars['strings'] = array(
			'ajax_error'		=> esc_html__('Invalid server answer', 'charity-is-hope'),
			'bookmark_add'		=> esc_html__('Add the bookmark', 'charity-is-hope'),
            'bookmark_added'	=> esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'charity-is-hope'),
            'bookmark_del'		=> esc_html__('Delete this bookmark', 'charity-is-hope'),
            'bookmark_title'	=> esc_html__('Enter bookmark title', 'charity-is-hope'),
            'bookmark_exists'	=> esc_html__('Current page already exists in the bookmarks list', 'charity-is-hope'),
			'search_error'		=> esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'charity-is-hope'),
			'email_confirm'		=> esc_html__('On the e-mail address "%s" we sent a confirmation email. Please, open it and click on the link.', 'charity-is-hope'),
			'reviews_vote'		=> esc_html__('Thanks for your vote! New average rating is:', 'charity-is-hope'),
			'reviews_error'		=> esc_html__('Error saving your vote! Please, try again later.', 'charity-is-hope'),
			'error_like'		=> esc_html__('Error saving your like! Please, try again later.', 'charity-is-hope'),
			'error_global'		=> esc_html__('Global error text', 'charity-is-hope'),
			'name_empty'		=> esc_html__('The name can\'t be empty', 'charity-is-hope'),
			'name_long'			=> esc_html__('Too long name', 'charity-is-hope'),
			'email_empty'		=> esc_html__('Too short (or empty) email address', 'charity-is-hope'),
			'email_long'		=> esc_html__('Too long email address', 'charity-is-hope'),
			'email_not_valid'	=> esc_html__('Invalid email address', 'charity-is-hope'),
			'subject_empty'		=> esc_html__('The subject can\'t be empty', 'charity-is-hope'),
			'subject_long'		=> esc_html__('Too long subject', 'charity-is-hope'),
			'text_empty'		=> esc_html__('The message text can\'t be empty', 'charity-is-hope'),
			'text_long'			=> esc_html__('Too long message text', 'charity-is-hope'),
			'send_complete'		=> esc_html__("Send message complete!", 'charity-is-hope'),
			'send_error'		=> esc_html__('Transmit failed!', 'charity-is-hope'),
			'geocode_error'			=> esc_html__('Geocode was not successful for the following reason:', 'charity-is-hope'),
			'googlemap_not_avail'	=> esc_html__('Google map API not available!', 'charity-is-hope'),
			'editor_save_success'	=> esc_html__("Post content saved!", 'charity-is-hope'),
			'editor_save_error'		=> esc_html__("Error saving post data!", 'charity-is-hope'),
			'editor_delete_post'	=> esc_html__("You really want to delete the current post?", 'charity-is-hope'),
			'editor_delete_post_header'	=> esc_html__("Delete post", 'charity-is-hope'),
			'editor_delete_success'	=> esc_html__("Post deleted!", 'charity-is-hope'),
			'editor_delete_error'	=> esc_html__("Error deleting post!", 'charity-is-hope'),
			'editor_caption_cancel'	=> esc_html__('Cancel', 'charity-is-hope'),
			'editor_caption_close'	=> esc_html__('Close', 'charity-is-hope')
			);
		return $vars;
	}
}
?>