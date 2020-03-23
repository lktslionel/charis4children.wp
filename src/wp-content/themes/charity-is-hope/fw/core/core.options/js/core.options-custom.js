/* global jQuery:false */

jQuery(document).ready(function() {
	if (typeof CHARITY_IS_HOPE_STORAGE == 'undefined') CHARITY_IS_HOPE_STORAGE = {};
	CHARITY_IS_HOPE_STORAGE['media_frame'] = null;
	CHARITY_IS_HOPE_STORAGE['media_link'] = '';
	jQuery('.charity_is_hope_media_selector').on('click', function(e) {
		charity_is_hope_show_media_manager(this);
		e.preventDefault();
		return false;
	});
});

function charity_is_hope_show_media_manager(el) {
	"use strict";

	CHARITY_IS_HOPE_STORAGE['media_link'] = jQuery(el);
	// If the media frame already exists, reopen it.
	if ( CHARITY_IS_HOPE_STORAGE['media_frame'] ) {
		CHARITY_IS_HOPE_STORAGE['media_frame'].open();
		return false;
	}

	// Create the media frame.
	CHARITY_IS_HOPE_STORAGE['media_frame'] = wp.media({
		// Set the title of the modal.
		title: CHARITY_IS_HOPE_STORAGE['media_link'].data('choose'),
		// Tell the modal to show only images.
		library: {
			type: 'image'
		},
		// Multiple choise
		multiple: CHARITY_IS_HOPE_STORAGE['media_link'].data('multiple')===true ? 'add' : false,
		// Customize the submit button.
		button: {
			// Set the text of the button.
			text: CHARITY_IS_HOPE_STORAGE['media_link'].data('update'),
			// Tell the button not to close the modal, since we're
			// going to refresh the page when the image is selected.
			close: true
		}
	});

	// When an image is selected, run a callback.
	CHARITY_IS_HOPE_STORAGE['media_frame'].on( 'select', function(selection) {
		"use strict";
		// Grab the selected attachment.
		var field = jQuery("#"+CHARITY_IS_HOPE_STORAGE['media_link'].data('linked-field')).eq(0);
		var attachment = '';
		if (CHARITY_IS_HOPE_STORAGE['media_link'].data('multiple')===true) {
			CHARITY_IS_HOPE_STORAGE['media_frame'].state().get('selection').map( function( att ) {
				attachment += (attachment ? "\n" : "") + att.toJSON().url;
			});
			var val = field.val();
			attachment = val + (val ? "\n" : '') + attachment;
		} else {
			attachment = CHARITY_IS_HOPE_STORAGE['media_frame'].state().get('selection').first().toJSON().url;
		}
		field.val(attachment);
		if (field.siblings('img').length > 0) field.siblings('img').attr('src', attachment);
		field.trigger('change');
	});

	// Finally, open the modal.
	CHARITY_IS_HOPE_STORAGE['media_frame'].open();
	return false;
}
