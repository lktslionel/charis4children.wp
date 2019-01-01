jQuery(function($) {
	 "use strict";

	 if (typeof CATANIS === 'undefined') {
		 return false;
	 }
	 
	/* Check actived tab when page on load */
	if($(".catanis_metabox_tabs").length > 0){
		if($.cookie('catanis_metabox_active_id_' + $('#post_ID').val())) {
			var active_class = $.cookie('catanis_metabox_active_id_' + $('#post_ID').val());
	
			$('#catatnis_metaboxes_options').find('.catanis_metabox_tabs li').removeClass('active');
			$('#catatnis_metaboxes_options').find('.catanis_metabox_tab').removeClass('active').hide();
	
			$('.'+active_class).addClass('active').fadeIn();
			$('#catatnis_metaboxes_options').find('#'+active_class).addClass('active').fadeIn();
	
		} else {
			$('.catanis_metabox_tabs li:first-child').addClass('active');
			$('.catanis_metabox_tab_content .catanis_metabox_tab:first-child').addClass('active').fadeIn();
		}
		$('.catanis_metabox_tabs li a').click(function(e) {
			e.preventDefault();
	
			var tab_click_id = $(this).parent().attr('class').split(' ')[0];
			var tab_main_div = $(this).parents('#catatnis_metaboxes_options');
	
			$.cookie('catanis_metabox_active_id_' + $('#post_ID').val(), tab_click_id, { expires: 7 });
			
			tab_main_div.find('.catanis_metabox_tabs li').removeClass('active');
			tab_main_div.find('.catanis_metabox_tab').removeClass('active').hide();
	
			$(this).parent().addClass('active').fadeIn();
			tab_main_div.find('#'+tab_click_id).addClass('active').fadeIn();
	
		});
	 }
	
	 /**=== Metabox for post category and portfolio category ===**/
	if(jQuery.inArray( CATANIS.taxonomy, [ "portfolio_category", "category", "product_cat", 'pa_color' ] ) > -1){
		 
		if ( ! jQuery('#cata_category_thumbnail_id').val() || jQuery('#cata_category_thumbnail_id').val() == 0 ){
			 jQuery('.cata-remove-image-button').hide();
		}
		var mediaUploader;
		var attachment;
		
		jQuery(document).on( 'click', '.upload_image_button_tax', function( event ){
			event.preventDefault();
			if ( mediaUploader ) {
				mediaUploader.open();
				return;
			}

			mediaUploader = wp.media.frames.breadcrumb_file = wp.media({
				title: 'Choose an image',
				button: {
					text: 'Use image'
				},
				multiple: false
			});

			mediaUploader.on( 'select', function() {
				attachment = mediaUploader.state().get('selection').first().toJSON();

				jQuery('#cata_category_thumbnail_id').val( attachment.id );
				jQuery('#cata_category_thumbnail img').attr('src', attachment.url );
				jQuery('.cata-remove-image-button').show();
			});

			mediaUploader.open();
		});
		
		jQuery(document).on( 'click', '.cata-remove-image-button', function( event ){
			jQuery('#cata_category_thumbnail_id').val('');
			jQuery('#cata_category_thumbnail img').attr('src', jQuery('#cata_category_thumbnail').attr('data-src') );
			jQuery('.cata-remove-image-button').hide();
			
			return false;
		});
	}
	  
 	/**=== Init Metaboxes ===**/
 	if(CATANIS.posttype == 'services') {
		init_metabox_services();
		
	} else if(CATANIS.posttype == 'post'){
		$('#post-formats-select input').change(check_format_post);
		$(window).on("load", function() {
			check_format_post('init');
		});
		
		$('#post-formats-select input[type=radio]').change(function() {
			
			var tab_click_id = 'cata_tab_post_format';
	
			if(!$('.'+tab_click_id).hasClass('active')){
				var tab_main_div = $('#catatnis_metaboxes_options');
				
				$.cookie('catanis_metabox_active_id_' + $('#post_ID').val(), tab_click_id, { expires: 7 });
				
				tab_main_div.find('.catanis_metabox_tabs li').removeClass('active');
				tab_main_div.find('.catanis_metabox_tab').removeClass('active').hide();
		
				$('.'+tab_click_id).addClass('active').fadeIn();
				tab_main_div.find('#'+tab_click_id).addClass('active').fadeIn();
			}
		});
		
	} else if(CATANIS.posttype == 'portfolio' || CATANIS.posttype == 'gallery'){
		
		init_metabox_portfolio();
		if(jQuery().chosen) {
			$(".portfolio_type").chosen().change(init_metabox_portfolio);
		}
	}
 	
 	if( (jQuery.inArray( CATANIS.posttype, [ "page", "gallery", "portfolio", "post", "product" ] ) > -1 ) || CATANIS.page == 'catanis_options'){
 		
 		metabox_page_init_options();
 		
 		if(jQuery().wpColorPicker) {
 			$('.cata_colorpicker').wpColorPicker(); 
 		}
		$("#catatnis_metaboxes_options .catanis-meta-boxes .catanis-select-parent").change({section: "catatnis_metaboxes_options"}, metabox_page_event_change);
		$("#catatnis_metaboxes_options .catanis-meta-boxes .catanis-select-parent .on-off").on('click', {section: "catatnis_metaboxes_options"}, metabox_page_event_change);
		
		$('#page_feature_type').change(check_format_post);
		$(window).on("load", function() {
			check_format_post('init');
		});
	}
 	
 	if( CATANIS.page == 'catanis_options' ){
		metabox_page_init_options();
		$("#catanis-options-form .catanis-select-parent").change({section: "catanis-options-form"}, metabox_page_event_change);
		$("#catanis-options-form .catanis-select-parent .on-off").on('click', {section: "catanis-options-form"}, metabox_page_event_change);
		
		$('#page_feature_type').change(check_format_post);
		$(window).on("load", function() {
			check_format_post('init');
		});
	}
	 	 
 	/**=== Metabox Page===**/
 	function metabox_page_event_change(e){
 		e.preventDefault();
 		var $select = $(e.currentTarget);
		var selectName = $select.closest('.option').data('optionId');
		
		if($select.hasClass("on-off")) {
			var selectValue = ($select.hasClass("on")) ? false : true;
		}else{
			var selectValue = $select.find('option:selected').val();
		}
 		
		var section = '#' + e.data.section + ' .catanis-meta-boxes > .option';
		if(e.data.section == 'catanis-options-form'){
			section = '#' + e.data.section + ' .catanis-option-subtab > .option';
		}
		
		$.each($(section), function(index, value){
			var opt_depend_value = $(value).data('value');
			if(opt_depend_value != undefined ){
				if( $(value).data('depend') == selectName && opt_depend_value == selectValue){
					$(value).slideDown(500);
				}else{
					if($(value).data('depend') == selectName && opt_depend_value != selectValue ){
						$(value).hide(10);
					}
				}
			}
		});
 	}
 	function metabox_page_init_options(){
 		$.each($('.catanis-meta-boxes > .option, .catanis-option-subtab > .option'), function(index, value){
 			var opt_depend_value = $(value).data('value');
 			
 			if(opt_depend_value != undefined){
 				var selectName = $(value).data('depend');
 				
 				if($("#" + selectName).hasClass("on-off")){
 					var selectValue = ($("#" + selectName).hasClass("on")) ? true : false;
 				}else{
 					var selectValue = $('select[name='+selectName+']').val();
 				}
 				
 				if(opt_depend_value == selectValue){
					$(value).slideDown(500);
				}else{
					$(value).hide(10);
				}
 			}
 		});
 	}
 	
	/**=== Check post format in metaboxes Post===**/
	function check_format_post($flag = ''){
		
		var format = $('#post-formats-select input:checked').attr('value');
		if(CATANIS.posttype != 'post' || CATANIS.page == 'catanis_options' ){
			format = $('#page_feature_type').val();
		}
			
		if(typeof format != 'undefined'){
			
			if(format == 'audio'){
				$('.option.audio_format').stop(true,true).fadeIn(500);
				
				$('.option.docs_format').stop(true,true).fadeOut(100);				
				$('.option.video_format, .option.gallery_format, .option.quote_format, .option.link_format').stop(true,true).fadeOut(100);
			} else if(format == 'quote'){
				$('.option.quote_format').stop(true,true).fadeIn(500);
				
				$('.option.docs_format').stop(true,true).fadeOut(100);
				$('.option.video_format, .option.audio_format, .option.gallery_format, .option.link_format').stop(true,true).fadeOut(100);
				
			} else if(format == 'link'){
				$('.option.link_format').stop(true,true).fadeIn(500);
				
				$('.option.docs_format').stop(true,true).fadeOut(100);
				$('.option.video_format, .option.audio_format, .option.gallery_format, .option.quote_format').stop(true,true).fadeOut(100);
				
			} else if(format == 'video'){
				$('.option.video_format').stop(true,true).fadeIn(500);
				
				$('.option.docs_format').stop(true,true).fadeOut(100);
				$('.option.audio_format, .option.gallery_format, .option.quote_format, .option.link_format').stop(true,true).fadeOut(100);
				
			} else if(format == 'gallery'){	
				$('.option.gallery_format').stop(true,true).fadeIn(500);
				
				$('.option.docs_format').stop(true,true).fadeOut(100);
				$('.option.video_format, .option.audio_format, .option.quote_format, .option.link_format').stop(true,true).fadeOut(100);
			
			}else{ 
				/* (format == 'default' || format == 'image' || format == 'aside') */
				$('.option.docs_format').stop(true,true).fadeIn(500);

				$('.option.video_format').stop(true,true).fadeOut(100);
				$('.option.quote_format').stop(true,true).fadeOut(100);
				$('.option.link_format').stop(true,true).fadeOut(100);
				$('.option.audio_format').stop(true,true).fadeOut(100);
				$('.option.gallery_format').stop(true,true).fadeOut(100);
			}
		}
		
		/* catatnis_metaboxes_options_secondary */
		var _section = 'catatnis_metaboxes_options';
		post_format_init_again(format, _section);
		$("#"+ _section +" .catanis-meta-boxes .catanis-select-parent").change({section: _section}, metabox_page_event_change);
	}
		
	function post_format_init_again(format, section){
		
		var section = '#' + section + ' .catanis-meta-boxes > .option';
		$.each($(section), function(index, value){
 			
 			var $curElem = $(value);
 			var opt_depend_value = $curElem.data('value');
 			
 			if($curElem.hasClass(format + '_format') && opt_depend_value != undefined){
 					
				var selectName = $curElem.data('depend');
 				var selectValue = $('select[name='+selectName+']').val();
 				
 				if( opt_depend_value == selectValue){
 					$curElem.slideDown(500);
				}else{
					$curElem.hide(0);
				}
 			}
 		});
	}
		
	/**=== Metabox Portfolio or Gallery ===**/
	function init_metabox_portfolio(){
		
		var changeID1 = 'portfolio_type';
		var elemValue = ( $(this).val() == undefined) ? $('input[name='+changeID1+']').val() : $(this).val();
		
		$.each($('.catanis-meta-boxes .option'), function(index, value){
			
			if( $(value).data('depend') == changeID1 && $(value).data('value') == elemValue){
				$(value).slideDown(500);
			}else{
				if($(value).data('optionID') != changeID1 && $(value).data('depend') == changeID1){
					$(value).hide(10);
				}
			}				
		});
	}
		
	/**=== Metabox Services===**/
	function init_metabox_services(){
		var value = $('input[name=service_show_by]:checked', '#post').val(),
			parent = $('.catanis-meta-boxes');
		
		choose_service(value, parent);
		$('.radio_service_show_by').change(function(){
			var parent = $(this).closest('.catanis-meta-boxes');
			choose_service($(this).val(), parent);
		});
	}
	
	function choose_service(value, parent){
		
		if(value == 'image'){
			parent.find('.option-upload:first').show();
			parent.find('.option-stylefont:first').hide();
		}else{
			parent.find('.option-upload:first').hide();
			parent.find('.option-stylefont:first').show();
		}
	}
	 
 });