jQuery(document).ready(function($) {
	"use strict";
	
	/* Upload image */
    $(document).on("click", ".cata_upload_image_button", function(e) {
    	var mediaUploader;
    	var attachment;
    	
    	event.preventDefault();
    	
    	if ( mediaUploader ) {
			mediaUploader.open();
			return;
		}

		mediaUploader = wp.media.frames.logo_file = wp.media({
			title: 'Choose an image',
			button: {
				text: 'Use image',
			},
			multiple: false
		});

		/* Get previous element */
		jQuery.data(document.body, 'prevElement', $(this).prev());
		
		/* When an image is selected, run a callback. */
		mediaUploader.on( 'select', function() {
			attachment = mediaUploader.state().get('selection').first().toJSON();

	        var inputText = jQuery.data(document.body, 'prevElement');
	        if(inputText != undefined && inputText != '')     {
                inputText.val(attachment.url);
            }
		});

		mediaUploader.open();
    });
    
});