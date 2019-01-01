 /**
 * ============================================================
 * Description: Control Plugin: catanisUpload, catanisColorPicker,catanisChooseBtn..
 *
 * @name		Catanis_Setup
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 */
(function($){
	"use strict";
	
	$.coreCatanis = function(options){
		var defaults 	= {"elemID" 	: "#elemID"};
		var options 	= $.extend(defaults,options);
		var txtKeyword 	= $(options.keyword);
		var loadMap 	= 0;
		init();
		
		function init(){
			initEvent();
			
			/*Slider Ui*/
			$('.slider-option').each(function(){
				
				var inputHid, newStr, selected = $(this).data('id'); 
				if($("#" +selected).length){
					inputHid = $(this).siblings('#' + selected);
				}else{
					newStr = selected.replace(/\[/g , "_");
					newStr = newStr.replace(/\]/g , "_");
					inputHid = $("input[alt*='"+newStr +"']");
				}
				
				$(this).slider({ 
					animate: true, 
					range: 	"min", 
					min: 	inputHid.data('min'), 
					max: 	inputHid.data('max'), 
					step: 	inputHid.data('step'), 
					value: 	inputHid.attr('value'),
					slide: 	function(event, ui){
						inputHid.attr('value',ui.value);
					}
				});
			});			
			
			/*Chosen*/
			$(".select-chosen").chosen();
			$('.select-chosen').on('change', function(evt, params) {
				var newStr, selected = $(this).data('id'); 
				if($("#" +selected).length){
					$("#" +selected).val(params.selected);
				}else{
					newStr = selected.replace(/\[/g , "_");
					newStr = newStr.replace(/\]/g , "_");
					
					selected = $("input[alt*='"+newStr +"']");
					selected.val(params.selected);
				}
			});
			
			/*Date Picker*/
			$('.input-datepicker').datepicker({
				inline: true,
				showOtherMonths: true,
				isRTL: jQuery('body').hasClass('rtl'),
				dateFormat : 'yy-mm-dd',
				changeMonth: true,
			    changeYear: true,
				dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
			});	
		}
		
		function initEvent(){
			
			/*Import*/
			 setTimeout(function(){ 
				 jQuery('#import_message').fadeOut('slow');
			 }, 3000);
			
			/*Reset*/
			jQuery('#op-reset-button').click(function(){
				var answer = confirm($(this).data('confirm')),
					action = $('form#catanis-options-form').data('import');
				if(answer){
					var postData = {
						action 		: action.replace('import', 'reset'),
						nonceValue 	: $('#catanis-theme-options').val(),
						ztype 		: 'reset'
					}
					
					 $.ajax({
			        	  type: "POST",
			        	  url: ajaxurl,
			        	  data: postData,
			        	  dataType: "json",
			        	  success: function(response){
			        		  if(response.success) {
				            	  $('.ajax-msg-success').html(response.message).fadeIn(1000);
				            	  setTimeout("jQuery('.ajax-msg-success').fadeOut('slow');", 3000);
				            	  window.setTimeout(function(){location.reload();}, 1500);
				              } else {
				            	 $('.ajax-msg-error').html(response.message).fadeIn(2000);
				            	 setTimeout("jQuery('.ajax-msg-error').fadeOut('slow');", 3000);
				              }
			        	  }
			        });
				}
				
				return false;
			});
			
			/*Save Option*/
			$("#op-save-button").on('click', function(e) {
				e.preventDefault();
				saveOptions();
			});
		}
		
		function init_map(){
			$('.google-map').each(function(index,value){
				var mapAddress = $(this).find('.map-address');
				var idMap = $(this).attr('id');
				
				var addresspickerMap = mapAddress.addresspicker({
					regionBias: "fr",
				  	elements: {
				  		map:     "." + idMap + "_show",
				  		lat:     "." + idMap + "_lat",
				  		lng:     "." + idMap + "_lng"
				  	}
				});
				var gmarker = addresspickerMap.addresspicker( "marker");
				gmarker.setVisible(true);
				addresspickerMap.addresspicker( "updatePosition");
			});
		}
		
		function saveOptions(){
			var form = 'form#catanis-options-form';
			var postData = getInfoForm(form); 
	          postData.action = $(form).data('action');
	          postData.nonceValue = $('#catanis-theme-options').val();
	          
	          $.ajax({
	        	  type: "POST",
	        	  url: ajaxurl,
	        	  data: postData,
	        	  dataType: "json",
	        	  beforeSend:function(){$(".ajax-processing").toggle();$('.ajax-msg-success, .ajax-msg-error').hide();},
	          	  complete:function(){$(".ajax-processing").toggle();},
	        	  success: function(response){
	        		  if(response.success) {
		            	  $('.ajax-msg-success').html(response.message).fadeIn(1000);
		            	  setTimeout("jQuery('.ajax-msg-success').fadeOut('slow');", 3000);
		              } else {
		            	 $('.ajax-msg-error').html(response.message).fadeIn(2000);
		            	 setTimeout("jQuery('.ajax-msg-error').fadeOut('slow');", 3000);
		              }
	        	  }
	        	});
	          
	          return false;
		}
		
		/*normal function*/
		function getMultiValue(selector){
			var $img = '';
			var values = $(selector).map(function () {
				$img = $(this).parent().find('img').attr('src');
				return {
					val: this.value,
					img: $img
				};
			}).get(); 
			return values;
		}
		function getCheckboxValue(selector){
			
			var chkId = '';
			 if ($(selector_parent).length) {
		          
		          $(selector_parent).each(function () {
		        		chkId += $(this).find('input[type="checkbox"]').val() + ",";
		          });
		          chkId = chkId.slice(0, -1);
		        }
			return {'multi_check':chkId};
		}
		function getHash(){var a=location.href.split("#",2)[1]||"";if(a==="!"){a=""}return a}
		function setHash(b){var a=getHash();if(a!==b){b=b||"!";location.hash=b;}return this}
		function isValidEmail(email) {
		    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		    return pattern.test(email);
		}
		function isUrl(s) {
		    var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
		    return regexp.test(s);
		}
		function getInfoForm(selector){var obj = {};$.each($(selector).serializeArray(), function(i,v) {obj[v.name] = v.value;});return obj;}
	}
	
	/**
	 * @name	Input NUmber Plugin.
	 * @desc	Add and sub number on input
	 */
	$.fn.catanisSpinner = function() {
		this.each(function() {
			var el = $(this);
			
			/* add elements*/
			el.wrap('<span class="spinner2c"></span>');     
			el.before('<span class="sub icon-minus"></span>');
			el.after('<span class="add icon-plus"></span>');

			/* substract*/
			el.parent().on('click', '.sub', function () {
				if (el.val() > parseInt(el.attr('min')))
					el.val( function(i, oldval) { return --oldval; });
			});

			/* increment*/
			el.parent().on('click', '.add', function () {
				if (el.val() < parseInt(el.attr('max')))
					el.val( function(i, oldval) { return ++oldval; });
			});
			
			el.keypress(function (e) {
		    	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		            return false;
		    	}
		   });
		
	    });
	};
	
	/**
	 * @name	Upload Image Plugin.
	 * @desc	Upload image from library
	 */
	$.fn.catanisUpload = function(options){
		
		var defaults = {
			"element"			: ".catanis-upload",
			"clsLoading"		: "ajax-loading",
			"clsError"			: "option-error",
			"buttonUpload"		: ".catanis-opts-upload",
			"buttonRemove"		: ".upload-remove-image",
			"uploadWrapper"		: ".upload-image-wrapper",
			"imagePreview"		: ".upload-preview"
		};
		
		var options 		= jQuery.extend(defaults,options);
		var element 		= $(options.element);
		var buttonUpload 	= $(options.buttonUpload);
		var buttonRemove 	= $(options.buttonRemove);
		init();
		
		function init(){
			
			$(document).on('click', options.buttonUpload, function(e) {
				
				var $el = $(e.currentTarget);
	        	e.preventDefault();

	        	var parent = ($(e.currentTarget)).closest(options.element);
	        	var custom_file_frame = null;

	            custom_file_frame = wp.media.frames.customHeader = wp.media({
	            	title: 'Choose a File',
	            	library: {
	            		type: 'image'
	            	},
	                button: {
	                    text: 'Select Image'
	                },
	                multiple: false
	            });

	            custom_file_frame.on( "select", function() {
	            	
	            	var attachment 	= custom_file_frame.state().get( "selection" ).first();
	            	/*var thumbnail 	= attachment.attributes.sizes.thumbnail ?  attachment.attributes.sizes.thumbnail.url : attachment.attributes.url;*/
	            	
	            	parent.find(options.uploadWrapper).show();
	            	parent.find(options.imagePreview).attr('src', attachment.attributes.url);
            		parent.find(options.buttonUpload).hide();
	                $('input.imgurl',parent).val(attachment.attributes.url)
	                $('input.imgid',parent).val(attachment.attributes.id)
	                
	            });

	            custom_file_frame.open();
	        });
			
			$(document).on('click', options.buttonRemove, function(e) {
		    	e.preventDefault();
		    	var parent = ($(e.currentTarget)).closest(options.element);
		    	
		    	parent.find(options.uploadWrapper).hide();
		    	parent.find(options.imagePreview).attr('src', '');
		    	parent.find(options.buttonUpload).show();
		        $('input', parent ).val('');
		    });
		}		
	}
	
	/**
	 * @name	Upload Link Plugin.
	 * @desc	Upload link from library
	 */
	$.fn.catanisLinkUpload = function(options){
		
		var defaults = {
			"element"			: ".catanis-link-upload",
			"clsLoading"		: "ajax-loading",
			"clsError"			: "option-error",
			"buttonUpload"		: ".catanis-upload-media-button",
			"buttonRemove"		: ".catanis-remove-media-button"
		};
		
		var options 		= jQuery.extend(defaults,options);
		var element 		= $(options.element);
		var buttonUpload 	= $(options.buttonUpload);
		var buttonRemove 	= $(options.buttonRemove);
		init();
		
		function init(){
			
			$(document).on('click', options.buttonUpload, function(e) {
				
				var $el = $(e.currentTarget);
	        	e.preventDefault();

	        	var parent = ($(e.currentTarget)).closest(options.element);
	        	var custom_file_frame = null;
	        	
	            custom_file_frame = wp.media.frames.customHeader = wp.media({
	            	title: $el.data('choose'),
	            	library: {
	            		type: $el.data('typeUpload')
	            	},
	                button: {
	                    text: $el.data('update')
	                },
	                multiple: false
	            });

	            custom_file_frame.on( "select", function() {
	            	
	            	var attachment 	= custom_file_frame.state().get( "selection" ).first();
	            	/*var thumbnail 	= attachment.attributes.sizes.thumbnail ?  attachment.attributes.sizes.thumbnail.url : attachment.attributes.url;*/
	            	
            		parent.find(options.buttonUpload).hide();
            		parent.find(options.buttonRemove).show();
	                $('input',parent).val(attachment.attributes.url)
	                
	            });

	            custom_file_frame.open();
	        });
			
			$(document).on('click', options.buttonRemove, function(e) {
		    	e.preventDefault();
		    	var parent = ($(e.currentTarget)).closest(options.element);
		    	
		    	parent.find(options.buttonUpload).show();
		    	parent.find(options.buttonRemove).hide();
		        $('input', parent ).val('');
		    });
		}		
	}
	
	$.fn.catanisMultiUpload = function(options){

		var defaults = {
			element		: ".catanis-multiupload",
			selectText : "Add Images"
		};
		
		var options 		= jQuery.extend(defaults,options);
		//var $element 		= $(options.element);
		var $element 		= $(this);
		var obj = {};
		init();
		
		function init(){
			var $el = $element;
			
			obj.fieldid = $element.data('fieldid');
			obj.fieldname = $element.data('fieldname') || obj.fieldid;
			obj.images = [];
			obj.lastUniqueId = 0;

			_buildMarkup();
		}
		
		function _buildMarkup(){
	
			var images = $element.data('images');

			$element.$input = $('<input />', 
					{type:'hidden', id:obj.fieldid, name:obj.fieldname, 'class':'option-input catanis-multiupload-field'})
					.appendTo($element);
			
			$element.$imgWrap = $('<div class="multiupload-img-wrapper"></div>').appendTo($element)
					.sortable( { update: _doOnOrderChanged});
			
			$element.$selectButton = $('<button />', 
					{type: "button", html: '<span class="icon-popup"></span>' + options.selectText, 'class':'btn-icon catanis-btn'}).appendTo($element)
					.on( "click", _doOnButtonClick);
			
			$element.$imgWrap.on('click', '.upload-remove-btn', _removeImage);
			
			if(images && images.length){
				_addImages(images);
			}
		}

		function _doOnButtonClick(){
			
			// this : is input button 
			var self = this,
				mediaControl = {
					
					frame: function() {
						if ( this._frame ){
							return this._frame;
						}
							
						this._frame = wp.media({
							title: options.selectText,
							library: {
								type: 'image'
							},
							button: {
								text: options.selectText
							},
							multiple: true
						});
						this._frame.on( 'open', this.updateFrame ).state('library').on( 'select', this.select );
						return this._frame;
					},
					
					select: function(a) {
						var selection = this.frame.state().get('selection');

						if( selection ){
							var images = [];
						
							selection.each(function(attachment){
								var thumb = attachment.attributes.sizes.thumbnail ?  attachment.attributes.sizes.thumbnail.url
									: attachment.attributes.url;
								images.push({
									id : attachment.id,
									thumbnail : thumb
								});
							});

							if(images.length){
								_addImages(images);
							}

						}					
					}
					
				};

				mediaControl.frame().open();
		}
		
		function _addImages (images){
			var i = 0, len = images.length;
			images = _applyUniqueIds(images);

			for(;i<len;i++){
				$('<div />', {'class':'multi-preview-wrap', 'id':images[i]['uniqueId']})
				.append('<img src="'+images[i]['thumbnail']+'" />')
				.append($('<div />', {'class':'upload-remove-btn', data:{'img_unique_id':images[i]['uniqueId']}}))
				.appendTo($element.$imgWrap);
			}

			_updateValues(images, true);
		}
		
		function _applyUniqueIds(images){
			var i = 0, len = images.length;

			for(;i<len;i++){
				images[i].uniqueId = ++ obj.lastUniqueId;
			}
			return images;
		}
		
		function _updateValues(images, append){
			var imageIds;

			if(append){
				obj.images = obj.images.concat(images);
			}else{
				obj.images = images;
			}

			imageIds = _.pluck(obj.images, 'id');
		
			$element.$input.val(imageIds.join(","));
		}
		
		function _removeImage (e){
			var $btn = $(e.currentTarget),
				imgId = parseInt($btn.data('img_unique_id'), 10),
				imageIds;

			obj.images = _.reject(obj.images, function(img){
				return img['uniqueId'] == imgId;
			});

			imageIds = _.pluck(obj.images, 'id');

			$element.$input.val(imageIds);

			$btn.parents('.multi-preview-wrap:first').remove();
		}
		
		function _doOnOrderChanged(){
			var newOrder = $element.$imgWrap.sortable('toArray'),
				newImages = [],
				i = 0, len = newOrder.length,
				uniqueId;

			for(;i<len;i++){
				uniqueId = parseInt(newOrder[i], 10);
				newImages.push(_.find(obj.images, function(img){
					return img.uniqueId===uniqueId;
				}));
			}

			_updateValues(newImages, false);
		}

	};
	
	/**
	 * @name	Color Picker Plugin.
	 * @desc	Chooce a color from wp-color-picker
	 *
	 * Dependencies:
	 * - jQuery
	 * - jQuery-ui-core
	 * - jQuery-ui-widget
	 * - wp-color-picker
	 * - Undersore.js
	 */
	$.fn.catanisColorPicker = function(options){
		var defaults = {
				"element"			: "input.color",
				"defaultValue"		: "ED6C71"
			};
		
		var options 		= jQuery.extend(defaults,options);
		var element 		= $(options.element);
		init();
		
		function init(){
			
			element.wpColorPicker({
		            change: function(event, ui) {
		                /*pickColor(element.wpColorPicker("color"));*/
		            },
		            clear: function() {
		                pickColor("");
		            }
		        });
		}
		
		function pickColor(color) {
			 element.val(color);
		}
	    function toggle_text() {
	        if ("" === element.val().replace("#", "")) {
	        	element.val(options.defaultValue);
	            pickColor(options.defaultValue);
	        } else { pickColor(element.val());}
	    }
	}
	
	/**
	 * @name	Button Option Plugin.
	 * @desc 	Can be used to select an image or color from list
	 *
	 * Dependencies:
	 * - jQuery
	 * - jQuery-ui-core
	 * - jQuery-ui-widget
	 * - Underscore.js
	 */
	$.fn.catanisChooseBtn = function(options){
		var defaults = {
				"classSelected"		: "selected",
				"parent"			: null,
				"element"			: null
			};
		
		var options 		= jQuery.extend(defaults,options);
		var parent 			= options.parent;
		var element			= null;
		var reponseVal		= null;
		init();
		
		function init(){
			var $id = parent.attr("id"), $val= null;
			element = parent.find('li a');
			
			/* load the default value*/
			var $selected = parent.find("li a." + options.classSelected);
			if(!$selected.length) {
				setTimeout(function() { parent.find("li:first a").trigger("click"); },10);
				$val = parent.find("a:first").attr("rel");
			} else {
				$val = $selected.attr("rel");
			}
			$('<input />', {
				type: "hidden",
				name: $id,
				value: $val
			}).appendTo(parent);
			
			reponseVal = {id:$id, val: $val};
			
			parent.find('li a').on('click', function(e) {
				e.preventDefault();
				var $el = $(e.currentTarget);

				/* get selected value and add class selected*/
				$val = $el.attr("rel");
				parent.find("input[name="+$id+"]").val($val);
				element.removeClass(options.classSelected);
				$el.addClass(options.classSelected);
				
			});
		}
		
		return reponseVal;
	}
	
	/**
	 * @name	Custom Option Plugin (for social, sidebar and more..)
	 * @desc 	Show and get value with multi elem
	 */
	$.fn.catanisCustomField = function(options){
		var defaults = {
				"fields"		: {},
				"values"		: [],
				"parent"		: null,
				"btnAddItem"  	: ".custom-btn-add",
				"btnDeleteItem"	: ".custom-btn-delete",
				"btnAddText"	: "Add",
				"editable"    	: false,
				"classes"       : {
						"option"      : "custom-option",
						"label"       : "custom-heading",
						"liValue"     : "custom-value",
						"ul"          : "custom-option-list",
						"editBtn"     : "edit-button",
						"doneBtn"     : "done-button",
						"fieldValue"  : "field-val",
						"uploadBtn"   : "catanis-opts-upload",
						"invalid"     : "invalid",
						"btnOption"   : "button-option button-option-img",
						"selected"    : "selected",
						"input"    	  : "option-input",
						"select"   	  : "option-select",
						"sortingCls"  : "custom-btn-sort icon-list",
						"deleteCls"   : "custom-btn-delete icon-delete2"
				}
			};
		
		var options 		= jQuery.extend(defaults,options);
		var element 		= $(options.element);
		var btnAddItem 		= $(options.btnAddItem);
		var btnDeleteItem	= $(options.btnDeleteItem);
		var valuesOpt		= [];
		var lastIndex 		= 0;
		var btnAdd 			= "";
		var listUl 		= "";
		init();
			
		function init(){
			buildHTML();
			if(options.values.length) {	setDefaultValue();}
			
			$(document).on('click', options.btnAddItem, function(e) {
				addDataEvent();
			});
			$(document).on('click', options.btnDeleteItem, function(e) {
				deleteDataEvent(e);
			});
		}
		
		/*Build HTML element*/
		function buildHTML(){
			
			$.each(options.fields, function(i, field) {
				var	$elemInput, j, len, selected;
				var $elmOption = $('<div />', {
					'class': options.classes.option
				}).append($('<span />', {
					'class': options.classes.label,
					'text': field.name
				}));

				/* generate html depending element type*/
				switch(field.type) {
				case 'text':
					$elemInput = $('<input />', {
						type: 'text',
						id: field.id,
						"class": options.classes.input
					});
					break;
				case 'textarea':
					$elemInput = $('<textarea />', {
						id: field.id
					});
					break;
				case 'select':
					$elemInput = $('<select />', {
						id: field.id,
						"class": options.classes.select
					});
					 $(field.options).each(function(i,e) {
						 $("<option />", {value: this.id, text: this.name}).appendTo($elemInput);
					});
					break;
				case 'upload':
					$elemInput = $('<button type="button" data-choose="Choose a File" data-update="Select File" class="catanis-btn btn-icon ' + options.classes.uploadBtn +'"><span class="icon-popup"></span>Browse</button>');
					$elemInput.find('a').catanisUpload();
					break;
				case 'imageselect':
					$elemInput = $('<div />', {
						'class': options.classes.btnOption,
						'id' :field.id
					}).append("<ul />");
					
					if(field.ztype == 'image'){
						for(j = 0, len = field.options.length; j < len; j++) {
							selected = j ? '' : ' class="' + options.classes.selected + '"';
							$elemInput.find("ul").append('<li' + selected + '><a title="' + field.options[j].title + '"><img src="' + field.options[j].image + '"/></a></li>');
						}
					}else{
						for(j = 0, len = field.options.length; j < len; j++) {
							selected = j ? '' : ' class="' + options.classes.selected + '"';
							$elemInput.find("ul").append('<li' + selected + '><a title="' + field.options[j].title + '"><span class="' + field.options[j].image + '"></span></li>');
						}
					}
					
					break;
				}

				$elmOption.append($elemInput).appendTo(element);
				field.$elmOption = $elemInput;
				
			});
			
			/*add button and list UI*/
			btnAdd = $('<button />', {
				'type': 'button',
				'class': 'catanis-btn custom-btn-add',
				'html':  options.btnAddText
			}).appendTo(element);

			listUl = $('<ul />', {
				'class': options.classes.ul
			}).appendTo(element).sortable();
		}
		
		/*Show list default with value saved*/
		function setDefaultValue(){
			valuesOpt = _.clone(options.values);
			$.each(valuesOpt, $.proxy(function(i, value) {
				showList(value);
			}, this));
		}
		
		/*Show list with data*/
		function showList(data) {
			var $li = $('<li />').data('index', lastIndex++),
				preview = '', field, inputVal, isValid = true, xhtml ='', k = 1;

			$.each(data, $.proxy(function(key, value) {
				
				if(data.hasOwnProperty(key)) {
					field = getFieldById(key);
					if(options.preview && options.preview === key) {
						preview = value;
					}
					
					inputVal = value || '<span class="empty">Empty</span>';
					if(typeof field != 'undefined'){
						if(field && field.type != 'imageselect') {
							$li.append('<div class="' + options.classes.liValue + '"><input type="hidden" name="'+field.id+'['+lastIndex+']" value="'+escapeHTML(inputVal)+'" ><strong>' + field.name + '</strong>: <span class="' + options.classes.fieldValue + '">' + inputVal + '</span></div>');
						}else{
							$li.append('<div class="' + options.classes.liValue + '"><input type="hidden" name="'+field.id+'['+lastIndex+']" value="'+escapeHTML(inputVal)+'" ></div>');
						}
					}
						
					if(preview && k == 1){
						if(field.ztype == 'image'){ $li.prepend('<img src="' + preview + '" />');
						}else{ $li.prepend('<span class="' + preview + ' font-icon"></span>'); }
						k+=1;
					}
				}
			}, this));

			/* add the delete, edit and sort button*/
			$('<span />', {
				'class': options.classes.deleteCls,
				title: 'Delete'
			}).appendTo($li);
			$('<span />', {
				'class': options.classes.sortingCls,
				title: 'Sorting'
			}).appendTo($li);
			
			if(options.editable) {
				$('<div />', {
					'class': options.classes.editBtn,
					title: 'Edit'
				}).appendTo($li);
			}
			$li.appendTo(listUl);
		}
		
		/*Get a field by ID */
		function getFieldById(fieldId) {
			var field = _.find(options.fields, function(field) {
				return field.id === fieldId;
			});
			return field;
		}
		
		/*Add button click handler */
		function addDataEvent() {
			var dataObj = {},
			isValid = true;
			
			/* get and validate the data*/
			$.each(options.fields, $.proxy(function(i, field) {
				
				dataObj[field.id] = getInputValue(field);
				if(field.required && dataObj[field.id] == ""){
					field.$elmOption.addClass(options.classes.invalid);
					isValid = false;
				}
				
			}, this));
			
			if(isValid) {
				valuesOpt.push(dataObj);
				showList(dataObj);
				resetForm();
			}
		}
		
		
		/*Delete button click handler */
		function deleteDataEvent(e) {
			var $li = $(e.target).parent('li'),
				index = $li.data('index'),
				dataObj = valuesOpt[index];

			valuesOpt.splice(index, 1);
			$li.fadeOut('slow', function(){$(this).remove();});
		}
		
		/*Resets the form, remove class and empty field*/
		 function resetForm() {
			$.each(options.fields, $.proxy(function(i, field) {
				if(field.type === 'text' || field.type === 'textarea') {
					field.$elmOption.val('');
				} else if(field.type === 'upload') {
					field.$elmOption.find('input.' + options.classes.uploadInput).val('');
				}
				
				field.$elmOption.removeClass(options.classes.invalid);
			}, this));
		}
		
		 /*Escape string html*/
		function escapeHTML(html) {
			return html.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
		}
		 
		/**
		 * Get value of a element depending type option
		 * 
		 * @param  {object} field 	the element object
		 * @return The value of the element
		 */
		function getInputValue(field) {
			if(field.type === 'text' || field.type === 'textarea' || field.type === 'select') {
				return field.$elmOption.val();
			} else if(field.type === 'upload') {
				return field.$elmOption.find('input.' + options.classes.uploadInput).val();
			} else if(field.type === 'imageselect' && field.ztype === 'image') {
				return field.$elmOption.find('a.selected img').attr('src');
			}else{
				return field.$elmOption.find('a.selected span').attr('class');
			}
		}
	
	}
	
	/**
	 * @name	catanisRadioImage Plugin.
	 * @desc	Make radio input with image
	 */
	$.fn.catanisRadioImage = function(options){
		
		var defaults = {
				"element"		: ''
			};
		
		var options 	= jQuery.extend(defaults,options);
		var element 	= options.element;
		init();

		function init(){
			
			$('.ca-radio-img-img').show();
			$('.ca-radio-img-radio').hide();
			
			/* On click event handler*/
			element.on('click', function(e) {
				e.preventDefault();
				var $el = $(e.currentTarget);
				
				$el.parent().parent().find('.ca-radio-img-radio').removeAttr('checked');				
				$el.parent().parent().find('.ca-radio-img-img').removeClass('radio-selected');
				$el.addClass('radio-selected');	
				$el.parent().find('.ca-radio-img-radio').prop('checked', 'checked');
			});
			
		}
	}
	
	/**
	 * @name	ON/OFF Plugin.
	 * @desc	Change On or OFF for input
	 */
	$.fn.catanisOnOff = function(options){
		
		var defaults = {
				"onMargin"		: 43,
				"offMargin"		: 2,
				"classAdd"		: "on",
				"classRemove"	: "off",
				"element"		: null
			};
		
		var options 		= jQuery.extend(defaults,options);
		var element 		= options.element;
		var handle 			= null;
		var reponseVal		= null;
		init();

		function init(){
			handle 		= element.find("span.handle");
			var $id 	= element.attr("id"),
				$onoff 	= element.hasClass("on");
			
			setPosition($onoff, 0);
			reponseVal = {id:$id, val:$onoff.toString()};
			
			$('<input />', {
				type: "hidden",
				name: $id,
				value: $onoff
			}).appendTo(element);
			
			/* On click event handler - value: true/false*/
			element.on('click', function(e) {
				e.preventDefault();
				var $el = $(e.currentTarget);
				var inputVal = ($el.hasClass("on")) ? false : true;
				
				setPosition($el.hasClass("on"), 1);
				element.find("input").val(inputVal.toString());
				
			});
		}
		
		/**
		 * Changes the handle position to the selected value - ON/OFF.
		 * @param {boolean} animate sets whether to animate the change or
		 * just apply it with CSS.
		 */
		function setPosition(onoff, onload) {
			var margin, addClass, removeClass, chk;
			chk = (onload==0) ? 0 : 1;
			if((!onoff && onload == 1) || (onoff && onload == 0)) {
				margin 		= options.onMargin;
				addClass 	= options.classAdd;
				removeClass = options.classRemove;
			} else {
				margin 		= options.offMargin;
				addClass 	= options.classRemove;
				removeClass = options.classAdd;
			}
			
			handle.animate({
				marginLeft: margin
			}, 200);
			
			element.removeClass(removeClass).addClass(addClass);

		}
		
		return reponseVal;
	}
	
	/**
	 * @name	Checkbox or Multi Checkbox.
	 * @desc	Checkbox input
	 */
	$.fn.catanisCheckbox = function(options){
		
		var defaults = {
				"selectedClass"		: 'selected',
				"holderItem"		: '.check-holder',
				"parent"			: null
			};
		
		var options 		= jQuery.extend(defaults,options);
		var holderItem 		= jQuery(options.holderItem);
		var parent 			= options.parent;
		var reponseVal		= null;
		init();

		function init(){
			
			loadValue();
			holderItem.off('click').on('click', function(e) {
				e.preventDefault();
				var $el = $(e.currentTarget),
					val = $el.data("val") + '',
					pa 	= $el.parent('.option-check').attr('id'),
					valueExclude = $("input[name="+pa+"]").val(),
					changed = false;
				
				valueExclude = valueExclude ? valueExclude.split(',') : [];
				if($el.hasClass(options.selectedClass) && _.include(valueExclude, val)) {
					valueExclude = _.without(valueExclude, val);
					changed = true;
					$el.removeClass(options.selectedClass);
				} else if(!$el.hasClass(options.selectedClass) && !_.include(valueExclude, val)) {
					valueExclude.push(val);
					changed = true;
					$el.addClass(options.selectedClass);
				}
				
				if(changed) {
					$("input[name="+pa+"]").val(valueExclude.join(","));
				}
				
			});
			
		}

		function loadValue() {
			var valHidden = []
			var $id = parent.attr("id");
			
			holderItem.each(function(i, el) {
				var $el = $(el);
				if($el.hasClass(options.selectedClass) && $el.parent().attr('id') == $id){
					valHidden.push($el.data("val"));
				}
			});
			
			$('<input />', {
				type: "hidden",
				name: $id,
				value: valHidden.join(",")
			}).appendTo(parent);
			
			reponseVal = {id:$id, val:valHidden.join(",")};
		}
 
		return reponseVal;
	}
	
	/**
	 * @name	Dialog Info
	 * @desc	open dialog content
	 */
	jQuery.catanisDialogInfo = function(options){
		
		var defaults = {
				"elemClick" 		: ".help-button",
				"formDialog"		: '#formDialog',
				"contentDialog"		: '.dialog-content',
				"wrapContentDialog"	: '#contentFormDialog',
				"classDialog"		: 'catanis-dialog'
			};
		
		var options 			= jQuery.extend(defaults,options);
		var elemClick 			= jQuery(options.elemClick);
		var formDialog 			= jQuery(options.formDialog);
		var wrapContentDialog	= jQuery(options.wrapContentDialog);
		var classDialog 		= jQuery(options.classDialog);
		init();
		
		function init(){
			$(document).on("click", options.elemClick, function(e) {
				event.preventDefault();
				setContentDialog($(this).find(options.contentDialog + ":first").html());
				paddingDialog(true);
				formDialog.dialog({
			        autoOpen: false,
			        width: 450,
			        modal: true,
			        title: $(this).attr("data-title"),
			        dialogClass : options.classDialog,
			        'buttons'       : {
			            "Close": function() {
			                $(this).dialog('close');
			            }
			        },
			        open: function(event) {
			            $('.ui-dialog-buttonpane').find('button:contains("Close")').addClass('catanis-btn');
			        }
			    });
				openDialog();
			});
		}
		
		function openDialog(){formDialog.dialog('open'); setErrorDialog('');}
		function closeDialog(){ formDialog.dialog('close'); wrapContentDialog.empty(); }
		function paddingDialog(flag){
			if(flag == true) formDialog.removeClass('customDialog');
			else formDialog.addClass('customDialog');
		}
		function loadingDialog(){ formDialog.find(".squareform_loading").toggle(0); }
		function savingDialog(){ $('.ui-dialog-buttonpane .status-saving-dialog').toggle(0); }
		function setContentDialog(html){
			wrapContentDialog.html( (html == '' || html == undefined) ? '' : html );
		}
		function setTitleDialog(html){
			formDialog.attr('title', (html == '' || html == undefined) ? null : html );
		}
		function setErrorDialog(html){
			if(html == '' || html == undefined){
				formDialog.find(".errorFormDialog").empty();
				formDialog.find(".errorFormDialog").hide();
			}else{
				formDialog.find(".errorFormDialog").html(html);
				formDialog.find(".errorFormDialog").show();
			}
		}
		
	}
	
	/**
	 * @name	Tab menu Option page setting
	 * @desc	Tabs menu for Theme Options
	 */
	jQuery.catanisMultiTab = function(options){
		var defaults = {
				"keyword" 		: "#keywords",
				"mainNav"		: "#op-navigation",
				"mainTabs"		: ".op-tab",
				"subNav"		: ".op-tab-navigation",
				"subTab"		: ".op-sub-tab",
				"subNavItems"	: ".op-tab-navigation li",
				"storageId"		: "catanis_options_tab",
				"selectedClass"	: "op-selected",
				"prefix"		: "tab"
			};
		
		var options 			= jQuery.extend(defaults,options);
		var mainNav 			= jQuery(options.mainNav);
		var mainTabs 			= jQuery(options.mainTabs);
		var subNavTab 			= jQuery(options.subNavTab);
		var subTab 				= jQuery(options.subTab);
		var subNavItems			= jQuery(options.subNavItems);
		var supportsStorage 	= typeof(Storage)!=="undefined";
		var firstTime 			= true;
		init();
		
		function init(){
			var selectedTabs = null;
			mainTabs.hide();
			subTab.hide();
	
			initEventHandlers();
			selectedTabs = getSelectedElements();
			showMainTab(selectedTabs.main);
			showSubTab(selectedTabs.sub);
		}
		
		function initEventHandlers() {
			/* Main navigation click event*/
			mainNav.find('a').on("click",function(e) {
				e.preventDefault();
				showMainTab(jQuery(e.currentTarget));
			});
			
			/* Subnavigation click event*/
			subNavItems.find('a').on("click",function(e) {
				e.preventDefault();
				showSubTab(jQuery(e.currentTarget));
			});
			
		}
		/**
		 * Retrieves the currently selected main navigation and subnavigation tabs
		 * @return {object} containing the selected elements with the following
		 * keys:
		 * - main : the tab element for the selected main navigation tab
		 * - sub : the tab element for the selected sub navigation tab
		 */
		function getSelectedElements() {
			var currentNav = getTabState(),
				parts = currentNav ? currentNav.split('-') : [],
				res = {},
				mainHref = '',
				selectedIndex = 0;
				
			if(parts.length === 3) {
				/* there is a tab and subtab selected*/
				res.sub = subNavItems.find('a[href="' + currentNav + '"]');
				parts.pop();
				mainHref = parts.join('-');
				res.main = mainNav.find('a[href="' + mainHref + '"]');
			} else if(parts.length === 2) {
				/* only the main tab is selected*/
				res.main = mainNav.find('a[href="' + currentNav + '"]');
				selectedIndex = parseInt(parts[1], 10) - 1;
				res.sub = mainTabs.eq(selectedIndex).find(options.subNav + ' li:first a');
			} else {
				res.main = mainNav.find('a:first');
				res.sub = subNavItems.find('a:first');
			}

			return res;
		}
		
		/**
		 * Save href the selected tab to local storage.
		 */
		function saveTabState(href) {
			if(supportsStorage) {
				localStorage.setItem(options.storageId, href);
			}
		}

		/**
		 * Get the selected tab from local storage.
		 * @return {unknown} 
		 * if the cookie is set, will return the href
		 * else it will return null
		 */
		function getTabState() {
			if(supportsStorage) {
				return localStorage.getItem(options.storageId);
			}
			return null;
		}
		
		/**
		 * Displays a main navigation element panel.
		 */
		function showMainTab($elem) {
			var href = $elem.attr('href'),
				tab = null,
				subTab = null;

			$elem.parents('li:first')
				.addClass(options.selectedClass)
				.siblings('.' + options.selectedClass)
				.removeClass(options.selectedClass);
			mainTabs.hide();
			tab = jQuery(href).show();
			subTab = tab.data('lasttab') ? 
				subNavItems.find('a[href="' + tab.data("lasttab") + '"]') : 
				tab.find(options.subNav + ' li:first a');
				
			showSubTab(subTab);
			saveTabState(subTab.attr('href'));
		}
		
		/**
		 * Displays a sub navigation element panel.
		 * @param  {object} $elem the corresponding tab that was clicked.
		 */
		function showSubTab($elem) {

			var href = $elem.attr('href');
			$elem.parents('li:first')
				.addClass(options.selectedClass)
				.siblings('.' + options.selectedClass)
				.removeClass(options.selectedClass);
			if(firstTime == true){
				subTab.hide();
				jQuery(href).show().parents(options.mainNav + ':first').data('lasttab', href);
			}else{
				subTab.fadeOut(1);
				jQuery(href).fadeIn(500).parents(options.mainNav + ':first').data('lasttab', href);
			}
			saveTabState(href);
			firstTime = false;
		}
		
	}
	
})(jQuery);

jQuery(document).ready(function(e) {
	jQuery.catanisMultiTab();
	jQuery.catanisDialogInfo();
	
	jQuery('input.input-number').catanisSpinner();
	jQuery(".on-off").each(function(i, el) {
		var res = null;
		res = jQuery(el).catanisOnOff({
			element: jQuery(this)
		});
	});
	
	jQuery('.catanis-multiupload').each(function(i, el) {
		jQuery(el).catanisMultiUpload();
	});
	
	jQuery(".ca-radio-img-img").each(function(i, el) {
		var res = null;
		res = jQuery(el).catanisRadioImage({
			element: jQuery(this)
		});
	});
	
	jQuery(".option-check").each(function(i, el) {
		var res = null;
		res = jQuery(el).catanisCheckbox({
			parent: jQuery(this)
		});
	});
	
	jQuery(".button-option").each(function(i, el) {
		var res = null;
		res = jQuery(el).catanisChooseBtn({
			parent: jQuery(this)
		});
	});
	
	if(jQuery(".color").length){
		jQuery(this).catanisColorPicker();
	}
	
	if(jQuery(".catanis-upload").length){
		jQuery(this).catanisUpload();
	}
	
	if(jQuery(".catanis-link-upload").length){
		jQuery(this).catanisLinkUpload();
	}

	jQuery.coreCatanis();
});
