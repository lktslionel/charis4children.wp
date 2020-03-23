jQuery(document).ready(function () {
	"use strict";

	// Open frontend editor
	jQuery('#frontend_editor_icon_edit').on('click', function (e) {
		"use strict";
		if (jQuery('#frontend_editor_overflow').length == 0) {
			jQuery('body').append('<div id="frontend_editor_overflow" class="frontend_editor_overflow"></div>')
		}
		jQuery('#frontend_editor_overflow').fadeIn(400);
		jQuery('#frontend_editor_button_cancel').val(CHARITY_IS_HOPE_STORAGE['strings']['editor_caption_cancel']);
		jQuery('#frontend_editor').slideDown();
		e.preventDefault();
		return false;
	});

	//Close frontend editor
	jQuery('#frontend_editor_button_cancel').on('click', function (e) {
		"use strict";
		if (jQuery(this).val() == CHARITY_IS_HOPE_STORAGE['strings']['editor_caption_close'])
			window.location.reload();
		else {
			jQuery('#frontend_editor').slideUp();
			jQuery('#frontend_editor_overflow').fadeOut(400);
		}
		e.preventDefault();
		return false;
	});

	// Save post
	jQuery('#frontend_editor_button_save').on('click', function (e) {
		"use strict";
		// Save editors content
		var editor = typeof(tinymce) != 'undefined' ? tinymce.activeEditor : false;
		if ( 'mce_fullscreen' == editor.id )
			tinymce.get('content').setContent(editor.getContent({format : 'raw'}), {format : 'raw'});
		tinymce.triggerSave();
		// Prepare data
		var data = {
			action: 'frontend_editor_save',
			nonce: CHARITY_IS_HOPE_STORAGE['ajax_nonce'],
			data: jQuery("#frontend_editor form").serialize()
		};
		jQuery.post(CHARITY_IS_HOPE_STORAGE['ajax_url'], data, function(response) {
			"use strict";
			var rez = {};
			try {
				rez = JSON.parse(response);
			} catch (e) {
				rez = { error: CHARITY_IS_HOPE_STORAGE['ajax_error'] };
				console.log(response);
			}
			if (rez.error == '') {
				charity_is_hope_message_success('', CHARITY_IS_HOPE_STORAGE['strings']['editor_save_success']);
				jQuery('#frontend_editor_button_cancel').val(CHARITY_IS_HOPE_STORAGE['strings']['editor_caption_close']);
			} else {
				charity_is_hope_message_warning(rez.error, CHARITY_IS_HOPE_STORAGE['strings']['editor_save_error']);
			}
		});
		e.preventDefault();
		return false;
	});

	// Delete post
	//----------------------------------------------------------------
	jQuery('#frontend_editor_icon_delete').on('click', function (e) {
		"use strict";
		charity_is_hope_message_confirm(CHARITY_IS_HOPE_STORAGE['strings']['editor_delete_post'], CHARITY_IS_HOPE_STORAGE['strings']['editor_delete_post_header'], function(btn) {
			"use strict";
			if (btn != 1) return;
			var data = {
				action: 'frontend_editor_delete',
				post_id: jQuery("#frontend_editor form #frontend_editor_post_id").val(),
				nonce: CHARITY_IS_HOPE_STORAGE['ajax_nonce']
			};
			jQuery.post(CHARITY_IS_HOPE_STORAGE['ajax_url'], data, function(response) {
				"use strict";
				var rez = {};
				try {
					rez = JSON.parse(response);
				} catch (e) {
					rez = { error: CHARITY_IS_HOPE_STORAGE['ajax_error'] };
					console.log(response);
				}
				if (rez.error == '') {
					charity_is_hope_message_success('', CHARITY_IS_HOPE_STORAGE['strings']['editor_delete_success']);
					setTimeout(function() { 
						window.location.href = CHARITY_IS_HOPE_STORAGE['site_url'];
						}, 1000);
				} else {
					charity_is_hope_message_warning(rez.error, CHARITY_IS_HOPE_STORAGE['strings']['editor_delete_error']);
				}
			});
			
		});
		e.preventDefault();
		return false;
	});

});