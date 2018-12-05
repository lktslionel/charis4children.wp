jQuery(document).ready(function(){
	"use strict";
	
	var cookie_name 	= 'cata_gridlist_cookie';
	var elem_ptoducts 	= jQuery('.cata-container div.products');
	
	/*Default*/
	if (jQuery.cookie(cookie_name) == null) {
		var _def =  jQuery('.cata-gridlist-toggle').data('default');
		elem_ptoducts.addClass(_def);
    	jQuery('.cata-gridlist-toggle #'+ _def).addClass('active');
    	gl_active_item(_def);
    }
	
    if (jQuery.cookie(cookie_name) == 'grid') {
    	elem_ptoducts.addClass(jQuery.cookie(cookie_name));
    	gl_active_item(jQuery.cookie(cookie_name));
        jQuery('.cata-gridlist-toggle #cata_grid').addClass('active');
        jQuery('.cata-gridlist-toggle #cata_list').removeClass('active');
    }
    if (jQuery.cookie(cookie_name) == 'list') {
    	elem_ptoducts.addClass(jQuery.cookie(cookie_name));
    	gl_active_item(jQuery.cookie(cookie_name));
        jQuery('.cata-gridlist-toggle #cata_list').addClass('active');
        jQuery('.cata-gridlist-toggle #cata_grid').removeClass('active');
    }
	
    jQuery('#cata_grid').click(function(e) {
    	e.preventDefault();
		jQuery(this).addClass('active');
		jQuery('#cata_list').removeClass('active');
		jQuery.cookie(cookie_name,'grid', { path: '/' });
		elem_ptoducts.fadeOut(300, function() {
			jQuery(this).addClass('grid').removeClass('list').fadeIn(300);
			gl_active_item('grid');
		});
		return false;
	});

	jQuery('#cata_list').click(function(e) {
		e.preventDefault();
		jQuery(this).addClass('active');
		jQuery('#cata_grid').removeClass('active');
		jQuery.cookie(cookie_name,'list', { path: '/' });
		elem_ptoducts.fadeOut(300, function() {
			jQuery(this).removeClass('grid').addClass('list').fadeIn(300);
	    	gl_active_item('list');
		});
		return false;
	});

	function gl_active_item($item){
		elem_ptoducts.find('.product-excerpt').hide();
		elem_ptoducts.find('.product-excerpt.'+$item).show();
	}
});