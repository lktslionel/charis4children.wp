/**
 * This file contains all the main JavaScript functionality needed for the editor formatting buttons.
 * 
 * @author Catanis
 */

if(!CATANIS){
	var CATANIS = {};
}

(function($){

CATANIS.tinymce = {};
CATANIS.tinymce.btnImageUri = CATANIS.theme_uri+'/framework/functions/editorbutton/icons/';

/*======================================================
 * Define all the formatting buttons with the HTML code they set.
 *======================================================*/
CATANIS.tinymce.buttons=[
     	{
			id:'catanistitle',
			image: 'heading.png',
			title:'Page Underlined Heading',
			allowSelection: true,
			fields:[{id:'text', name:'Heading Text'}],
			generateHtml:function(text){
				return '<h2 class="page-heading">'+text+'</h2>&nbsp;';
			}
		},
		{
			id:'catanisdropcaps',
			image:'drop.png',
			title:'Drop Caps',
			allowSelection:false,
			fields:[{id:'letter', name:'Letter', desc:'Input a letter for Dropcap'},
					{id:'main_style', name:'Style', values:['simple', 'circle', 'square', 'rounded']},
					{id:'color', name:'Color', type:'colorpicker'},
					{id:'bg_color', name:'Background color', type:'colorpicker', desc:'Do not use this options for Simple style' }],
			generateHtml:function(obj){
				var $_style = '';
				
				$_style = 'color:' + obj.color + '; background-color:' + obj.bg_color + ';';
				if(obj.main_style == 'simple' || obj.main_style == undefined){
					$_style = 'color:' + obj.color + ';';
				}
				return '<span class="cata-dropcaps style-'+ obj.main_style +'" style="'+ $_style +'">'+ obj.letter +'</span>';
			}
		},
		{
			id:'catanistooltip',
			image:'lb.png',
			title: 'ToolTip',
			allowSelection:false,
			fields:[{id:'text', name:'Text', desc:'Input a text'},
			        {id:'tooltip', name:'Tooltip', desc:'Input a tooltip for text above'},
					{id:'position', name:'Tooltip Position', values:['top', 'left', 'bottom', 'right']},
					{id:'color', name:'Color', type:'colorpicker'},
					{id:'bg_color', name:'Background Color', type:'colorpicker'},
					{id:'ext_class', name:'Extend Custom Class'}],
			generateHtml:function(obj){
				var $xhtml = '';
				
				$xhtml += '[cata_tooltip tooltip="'+ obj.tooltip +'" position="'+ obj.position +'"';
				if(obj.color != '' || obj.color == undefined){
					$xhtml += ' color="'+ obj.color +'"';
				}
				if(obj.bg_color != '' || obj.bg_color == undefined){
					$xhtml += ' bg_color="'+ obj.bg_color +'"';
				}
				$xhtml += ']'+ obj.text +'[/cata_tooltip]';
				
				return $xhtml;
			}
		},
		{
			id:'catanisemptyspace',
			image:'hl.png',
			title:'Empty Space',
			allowSelection:false,
			fields:[{id:'height', name:'Height'},
					{id:'ext_class', name:'Extra Class', desc: 'Optional - Style particular content element differently - add a class name and refer to it in custom CSS. You can define multiple CSS class with use of space like "Class1 Class2"'}],
			generateHtml:function(obj){
				return '[cata_empty_space height="'+ obj.height +'" ext_class="'+ obj.ext_class +'"]';
			}
		},
		{
			id:'catanistwocolumns',
			image:'col_2.png',
			title:'Two Columns',
			allowSelection:false,
			generateHtml:function(obj){
				return '<br class="clear" /><div class="cols-wrapper cols-2"><div class="col"><p>'+
						'&nbsp;Content Column 1</p></div><div class="col nomargin"><p>'+
						'&nbsp;Content Column 2</p></div></div>&nbsp;<br class="clear" />';
			}
		},
		{
			id:'catanisthreecolumns',
			image:'col_3.png',
			title:'Three Columns',
			allowSelection:false,
			generateHtml:function(obj){
				return '<br class="clear" /><div class="cols-wrapper cols-3"><div class="col"><p>'+
				'&nbsp;Content Column 1</p></div><div class="col"><p>'+
				'&nbsp;Content Column 2</p></div><div class="col nomargin"><p>'+
				'&nbsp;Content Column 3</p></div></div>&nbsp;<br class="clear" />';
			}
		},
		{
			id:'catanisfourcolumns',
			image:'col_4.png',
			title:'Four Columns',
			allowSelection:false,
			generateHtml:function(obj){
				return '<br class="clear" /><div class="cols-wrapper cols-4"><div class="col"><p>'+
				'&nbsp;Content Column 1</p></div><div class="col"><p>'+
				'&nbsp;Content Column 2</p></div><div class="col"><p>'+
				'&nbsp;Content Column 3</p></div><div class="col nomargin"><p>'+
				'&nbsp;Content Column 4</p></div></div>&nbsp;<br class="clear" />';
			}
		},
		{
			id:'catanisfivecolumns',
			image:'col_4.png',
			title:'Five Columns',
			allowSelection:false,
			generateHtml:function(obj){
				return '<br class="clear" /><div class="cols-wrapper cols-5"><div class="col"><p>'+
				'&nbsp;Content Column 1</p></div><div class="col"><p>'+
				'&nbsp;Content Column 2</p></div><div class="col"><p>'+
				'&nbsp;Content Column 3</p></div><div class="col"><p>'+
				'&nbsp;Content Column 4</p></div><div class="col nomargin"><p>'+
				'&nbsp;Content Column 5</p></div></div>&nbsp;<br class="clear" />';
			}
		},
		{
			id:'catanis23columns',
			image:'col_2.png',
			title:'2/3 and 1/3 Columns',
			allowSelection:false,
			generateHtml:function(obj){
				return '<br class="clear" /><div class="cols-wrapper cols-23"><div class="col"><p>'+
						'&nbsp;Content Column 1</p></div><div class="col nomargin"><p>'+
						'&nbsp;Content Column 2</p></div></div>&nbsp;<br class="clear" />';
			}
		},
		{
			id:'catanis34columns',
			image:'col_2.png',
			title:'3/4 and 1/4 Columns',
			allowSelection:false,
			generateHtml:function(obj){
				return '<br class="clear" /><div class="cols-wrapper cols-34"><div class="col"><p>'+
						'&nbsp;Content Column 1</p></div><div class="col nomargin"><p>'+
						'&nbsp;Content Column 2</p></div></div>&nbsp;<br class="clear" />';
			}
		}
			
],

//CATANIS.tinymce.excludeDialogButtons = /(wp_more|fullscreen|undo|redo|wp_help|catanisbgsection|catanisnivoslider|charmap|pastetext|pasteword),?/g;
CATANIS.tinymce.excludeDialogButtons = /(wp_more|fullscreen|undo|redo|wp_help|catanisnivoslider|charmap|pastetext|pasteword),?/g;

CATANIS.tinymce.opera = false;
CATANIS.tinymce.ie = false;
CATANIS.tinymce.attrPrefix = 'attr_';

/**
 * Builds a shortcode from the given data and fields.
 * @param  {object} dataObj          the shortcode data
 * @param  {object} fields        object containing all of the fields that the
 * shortcode supports
 * @param  {string} shortcodeName the name of the shortcode
 * @return {string}               the shortcode string
 */
CATANIS.tinymce.buildShortcode = function(dataObj, fields, shortcodeName){
	var shortcode = '['+shortcodeName,
		prefix = CATANIS.tinymce.attrPrefix;

	//add the shortcode attributes
	_.each(fields, function(field){
		if(dataObj[field.id] && field.id !== 'content'){
			shortcode += ' '+prefix+field.id + '="' + dataObj[field.id]+'"';
		}
	});

	//add an inner attribute which means that this is a shortcode within
	//another shortcode
	if(dataObj.inner){
		shortcode+=' '+prefix+'inner="true"';
	}

	shortcode+=']';

	//add the shortcode content
	if(dataObj.content){
		shortcode+=dataObj.content;
	}

	shortcode+='[/'+shortcodeName+']';

	return shortcode;
};


/**
 * Button manager - main constructior. Contains the main functionality for 
 * adding new TinyMCE buttons and initializing the functionality for adding and 
 * editing content 
 * with these buttons
 * @param  {array} buttons array containing all of the buttons data, such as
 * fields, htmlGeneration function, etc.
 */
CATANIS.tinymce.btnManager=function(buttons){
	
	this.dialogs	= [];
	this.idPrefix 	= 'catanis-shortcode-';
	this.visualBtns = [];
	this.buttons 	= buttons;
	this.attrPrefix = CATANIS.tinymce.attrPrefix;
	
};

		
/** ok
 * Init the formatting button functionality.
 * 
 * visualBtns, visualShortcodes in Object CATANIS.tinymce.btnManager
 */
CATANIS.tinymce.btnManager.prototype.init=function(){
	
	var last 	= false,
		self 	= this,
		length 	= self.buttons.length,
		visualShortcodesArr = [];
	
	if (navigator.userAgent.toLowerCase().indexOf('msie') > -1){
		CATANIS.tinymce.ie=true;
	}

	if (navigator.userAgent.toLowerCase().indexOf('opera') > -1){
		CATANIS.tinymce.opera=true;
	}
	
	for(var i=0; i<length; i++){
		btnObj = self.buttons[i];
	
		if(btnObj.visual){
			//this is a shortcode button that is added as an image in the visual
			//content, add the buttons to the visual shortcode buttons array
			self.visualBtns.push(btnObj);
			visualShortcodesArr.push(btnObj.visual.shortcode);
			
			///if(last){self.setEventHandlers();}
		}

		if(i===length-1){
			last = true;
		}
		
		this.loadButton(btnObj, last);
	}

	/*Add Menu Button Item*/
	/**this.loadMenuButton();*/
	
	if(visualShortcodesArr.length){
		self.visualShortcodes = visualShortcodesArr.join('|');
	}

};

/**
 * Loads a button and sets the functionality that is executed when the button 
 * is clicked.
 * @param  {object} btnObj  the button object containing the button details, such
 * as fields, html generator function, etc.
 * @param  {boolean} last sets whether this is the last button from the button
 * set
 */
CATANIS.tinymce.btnManager.prototype.loadButton = function(btnObj, last){
	var self = this; 
	
	tinymce.create('tinymce.plugins.'+btnObj.id, {

        init : function(editorObj, url) {

			self.editorObj = editorObj;
			if(last){
				self.setEventHandlers();
			}

			editorObj.addButton(btnObj.id, {
                title : btnObj.title,
                
				onclick : function() {
					
					var selection = editorObj.selection.getContent();
					if(btnObj.allowSelection && selection){
						//modification via selection is allowed for this button and some text has been selected
						selection = btnObj.generateHtml(selection);
						editorObj.selection.setContent(selection);
					}else if(btnObj.fields){ 
						
						//there are inputs to fill in, show a dialog to fill the required data
						self.showDialog(btnObj, editorObj);
					}else if(btnObj.list){
						console.log('button with list');
						//this is a list
						var list, dom = editorObj.dom, sel = editorObj.selection;

						// Check for existing list element
						list = dom.getParent(sel.getNode(), 'ul');
						
						// Switch/add list type if needed
						editorObj.execCommand('InsertUnorderedList');
						
						// Append styles to new list element
						list = dom.getParent(sel.getNode(), 'ul');
						
						if (list) {
							dom.addClass(list, btnObj.list);
							dom.addClass(list, 'imglist');
						}
					}else{
						console.log('button normal');
						//no data is required for this button, insert the generated HTML
						editorObj.execCommand('mceInsertContent', true, btnObj.generateHtml());
					}
				}
			});
		}
    });
	
    tinymce.PluginManager.add(btnObj.id, tinymce.plugins[btnObj.id]);
};


/**
 * Registers event handlers mainly for the visual shortcode functionality.
 */
CATANIS.tinymce.btnManager.prototype.setEventHandlers = function(){
	var self = this, 
		editorObj = self.editorObj;
	
	if(self.visualBtns.length){

		//replace the shortcode with image (when init and add new)
		editorObj.onBeforeSetContent.add(function(ed, o) {
			o.content = self.replaceShortcodeWithImg(o.content, editorObj);
		});

		//replace the shortcode with image (only add new)
		editorObj.onExecCommand.add(function(editorObj, cmd) {
			// mceInsertContent: add - mceRepaint: edit
		    if (cmd ==='mceInsertContent'){	
				tinyMCE.activeEditor.setContent( self.replaceShortcodeWithImg(tinyMCE.activeEditor.getContent(), editorObj) );
			}
		});

		//replace the image back to shortcode on save
		editorObj.onPostProcess.add(function(editorObj, o) {
			
			//remove the tooltips if any has been added to the content and not removed
			o.content = o.content.replace(/<div class="cata-tooltip".+?<\/div>/g, '');
			if (o.get){
				o.content = self.replaceImgWithShortcode(o.content);
			}
		});

		self.initEditFunctionality(editorObj);
		editorObj.onInit.add(self.setButtonVisibility);
	}
};

/**
 * Replaces a shortcode with an image. The shortcode needs to be registered
 * as a visual shortcode (a "visual" property containing the shortcode has to be 
 * set to the button object)
 * @param  {string} contentEditor the editor content
 * @param  {object} editorObj the current editor object
 * @return {string}    the editor content with the shortcode replaced with an
 * image. Shortcodes within shortcodes (with the inner attribute set) are not
 * replaced in the main content editor.
 */
CATANIS.tinymce.btnManager.prototype.replaceShortcodeWithImg=function(contentEditor, editorObj){
	var self = this,
		matches, rg;

	//build the regular expression, if it is a content editor and the shortcode
	//has the inner attribute set, do not replace this shortcode as its parent
	//shortcode will be replaced
	rg = editorObj.id==='content'?
		new RegExp('\\[('+self.visualShortcodes+')(?![^\\]]*'+self.attrPrefix+'inner)([^\\]]*)\\]((.|[\\r\\n])*?)\\[\/\\1]', 'g') :
		new RegExp('\\[('+self.visualShortcodes+')([^\\]]*)\\]((.|[\\r\\n])*?)\\[\/\\1]', 'g');
		
	return contentEditor.replace(rg, function(match, shortcode, attr, content){
		content = $.trim(content);
		attr 	= $.trim(attr);
		var len = content.length,
			btnObj = _.find(self.visualBtns, function(currentBtn){ 
				// loop in visualBtns find shortcode name and compare with current shortcode
				return currentBtn.visual.shortcode===shortcode;
			});
		
		var dataContent 	= content ? ' data-catacontent="'+tinymce.DOM.encode(content)+'"' : '',
			dataShortcode 	= ' data-shortcode="'+btnObj.visual.shortcode+'"';
		
		return '<p><img src="'+btnObj.visual.img+'"'+dataContent+dataShortcode+' class="catanis-edit-image mceItem image-'+btnObj.visual.shortcode+'" data-atts="'+tinymce.DOM.encode(attr)+'" /></p>';
	});
	
};

/**
 * Escapes the inner quotes within inner shortcode attributes. For example, the
 * following content:
 * test [bgsection pex_attr_text="this is "some" text here"][/bgsection] text
 * will be converted to:
 * test [bgsection pex_attr_text="this is &quot;some&quot; text here"][/bgsection] text
 * @param  {string} co the content that will be searched for inner shortcodes
 * @return {string}    the content with escaped quotes within its attributes
 */
CATANIS.tinymce.btnManager.prototype.escapeInnerShortcodeQuotes = function(co){
	var self = this,
		match,
		rg = new RegExp('\\[('+self.visualShortcodes+')([^\\]]*)\\][^]*?\\[\/\\1]', 'g');

		return co.replace(rg, function(match, shortcode, attr){
			var escapedAttr = ' '+self.escapeAttrStrInnerQuotes(attr);
			return match.replace(attr, escapedAttr);
		});
	
};

/**
 * Replaces an image with a shortcode. The images that represent the shortcodes
 * in the visual editor are replaced back to shortcodes when the Text tab is 
 * opened or on content save.
 * @param  {string} content the content that will be searched for image shortcodes
 * and that will be replaced
 * @return {string}    the replaced content
 */
CATANIS.tinymce.btnManager.prototype.replaceImgWithShortcode=function(content){
	var self = this,
		getAttr = function(s, n) {
		var attsString, res;
		n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
		return n ? tinymce.DOM.decode(n[1]) : '';
	};
	
	return content.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function(a,img) {
		var cls = getAttr(img, 'class'),
			content = tinymce.trim(getAttr(img, 'data-catacontent')),
			len = content.length;

		if(content.indexOf('<p>')===0 && content.indexOf('</p>')===len-4){
			//remove surrounding p tags
		   content = content.slice(3,len-4);
		}

		content = self.escapeInnerShortcodeQuotes(content);
		if(cls.indexOf('catanis-edit-image') != -1 ){
			return '<p>['+tinymce.trim(getAttr(img, 'data-shortcode'))+' '+self.escapeAttrStrInnerQuotes(tinymce.trim(getAttr(img, 'data-atts')))+']'+content+'[/'+getAttr(img, 'data-shortcode')+']</p>';
		}

		return a;
	});
};

/**
 * Inits a dialog that contains fields for inserting the data needed for the 
 * button. (Only button width fields)
 * @param  {object} btnObj the button object
 * @param  {object} editorObj  the editor object
 */
CATANIS.tinymce.btnManager.prototype.showDialog=function(btnObj, editorObj){
	
	var self = this, 
		formBuilder, contentDialog, dialog, caret, selection;
	
	if(CATANIS.tinymce.ie){
		editorObj.dom.remove('cataniscaret');
	    caret = '<div id="cataniscaret">&nbsp;</div>';
	    editorObj.execCommand('mceInsertContent', false, caret);	
		selection = editorObj.selection;
	}

	//build the dialog form containing the fields
	formBuilder = new CATANIS.tinymce.formBuilder(btnObj, self.idPrefix, btnObj.defData);
	contentDialog = formBuilder.getFormElement();
		
	//dialog(btn, ed, insertCallback, $el, loadCallback, edit, closeCallback)
	dialog = new CATANIS.tinymce.dialog(btnObj, editorObj, 
				function(){self.executeCommand(editorObj, btnObj);}, //insertCallback
				contentDialog, 
				function(){return formBuilder.initElements();},  //loadCallback
				false, function(){self.removeDialog();} //closeCallback
			);
	
	dialog.init();
	self.dialogs.push(dialog);

};

CATANIS.tinymce.btnManager.prototype.removeDialog = function(){
	var self = this;
	self.dialogs.pop().remove();
};

/**
 * Retrieves the dialog input values.
 * @param  {object} btn   the button object
 * @param  {boolean} inner sets if it is an inner dialog
 * @return {object}       object containing all of the input values of the
 * registered button fields.
 */
CATANIS.tinymce.btnManager.prototype.getInputsValue = function(btn, inner){
	var values={}, value, html='',
	self = this;

	if(!btn.allowSelection){
		//the button doesn't allow selection, generate the values as an object literal
		for(var i=0, length=btn.fields.length; i<length; i++){
			var id=btn.fields[i].id;
			
			if(btn.fields[i].imgradio){
				value = $("input:radio[name='"+self.idPrefix+btn.fields[i].id+"']:checked").val();
			}else{
				value=$('.catanis-dialog-'+btn.id + ' #'+self.idPrefix+id).val();
			}
			
			if(btn.fields[i].type=='wysiwyg'){
				var cont,
					$visualBtn = $('#catanis-shortcode-content-tmce');

				if($visualBtn.length && $visualBtn.parents('.html-active').length){
					//trigger the visual button click, so that the content gets 
					//refreshed in the visual editor
					$visualBtn.trigger('click');
				}

				cont = tinyMCE.activeEditor.getContent();
				cont = self.removeTrailingPTags(cont);
				values[id] = cont;
				
			}else{
				values[id]=value;
			}

		}

		if(inner){
			//this is an inner editor
			values['inner']=true;
		}
	}else{
		//the button allows selection - only one value is needed for the formatting, so
		//return this value only (not an object literal)
		value = $('#'+self.idPrefix+btn.fields[0].id).attr("value");
	}

	return values;

};


CATANIS.tinymce.btnManager.prototype.removeTrailingPTags = function(str){
	var searchStr = '<p>'+String.fromCharCode(160)+'</p>', //they use the ASCII 160 for an epmty space
	index = str.lastIndexOf(searchStr),
	newStr = '';

	if(index!==-1){
		newStr = str.substr(0, index) + str.substr(index+searchStr.length, str.length);
		return newStr;
	}else{
		return str;
	}

};


/**
 * Inserts a content to the editor when the Insert button of the dialog
 * is clicked. (Only button width fields)
 * @param  {object} editorObj  the editor object
 * @param  {object} btnObj the button object
 */
CATANIS.tinymce.btnManager.prototype.executeCommand=function(editorObj, btnObj){

	var html='',
		values,
		value,
		self = this,
		inner = editorObj.id === 'content' ? false : true;

	if(!btnObj.allowSelection){
		
		//the button doesn't allow selection and has multiple fields
		values = self.getInputsValue(btnObj, inner);
		values = self.escapeObjectQuotes(values);
		html = btnObj.generateHtml(values);
	}else{
		//the button allows selection - only one value is needed for the formatting, so
		//return this value only (not an object literal)
		value = jQuery('#'+self.idPrefix + btnObj.fields[0].id).attr("value");
		html = btnObj.generateHtml(value);
	}

	// close popup
	self.dialogs.pop().remove();

	if(CATANIS.tinymce.ie){
		editorObj.selection.select(editorObj.dom.select('div#cataniscaret')[0], false);
		editorObj.dom.remove('cataniscaret');
	}

	editorObj.execCommand('mceInsertContent', false, html);

};

/**
 * Preloads the visual shortcode edit images, so that when an image is clicked
 * once and the edit image should be displayed, it can be displayed without a
 * delay.
 */
CATANIS.tinymce.btnManager.prototype.preloadEditImages = function(){
	var self = this;

	_.each(self.visualBtns, function(btn){
		var editSrc = self.getEditImgSrc(btn.visual.img),
			img = new Image();
		img.src = editSrc;
	});
};

/**
 * Generates the edit image URL that corresponds to a visual shortcode image.
 * For example, the edit URL of http://site.com/image.jpg would be
 * http://site.com/image-edit.jpg
 * Works with JPG and PNG images only
 * @param  {string} src the original image source
 * @return {string}     the edit image source
 */
CATANIS.tinymce.btnManager.prototype.getEditImgSrc = function(src){
	return src.replace(/\.(png|jpg)/, '-edit$&');
};

/**
 * Generates the default image URL that corresponds to a visual shortcode edit 
 * image. For example, the default URL of http://site.com/image-edit.jpg would be
 * http://site.com/image.jpg
 * Works with JPG and PNG images only
 * @param  {string} src the edit image source
 * @return {string}     the original image source
 */
CATANIS.tinymce.btnManager.prototype.getDefImgSrcFromEditImg = function(editSrc){
	return editSrc.replace(/-edit\.(png|jpg)/, '.$1');
};

CATANIS.tinymce.btnManager.prototype.setImageHover = function(editorObj){
	var self = this,
		$body = $(editorObj.dom.doc.body),
		$tooltip = $('<div />', {'class':'cata-tooltip'});

	$body.on('mouseenter', 'img.catanis-edit-image, .cata-tooltip', function(){
		var $img = $(this),
			atts = self.convertAttrStringToObj($img.attr('data-atts'));
		
		if(atts.title){
			$tooltip.html(atts.title)
				.css({top: ($img.offset().top + 7)})
				.appendTo($body);
		}
	}).on('mouseleave focusout', 'img.catanis-edit-image', function(){
		$tooltip.detach();
	});

	editorObj.onChange.add(function(){
		$tooltip.detach();
	});
};

/**
 * Inits the visual shortcode edit functionality. When the image that represents
 * the shortcode is clicked, an edit dialog will be opened to edit the shortcode
 * data.
 * @param  {object} editorObj the editor object
 */
CATANIS.tinymce.btnManager.prototype.initEditFunctionality = function(editorObj){
	var self = this;

	editorObj.onInit.add(function(editorObj){

		var $lastTarget = null,
			removeEdit;

		removeEdit = function($img){
			//remove the edit class of the image
			var src = $img.attr('src');
				newSrc = self.getDefImgSrcFromEditImg(src);
				
			$img.removeClass('catanis-focus-img').data('editnow', false);
		};
		
		// set image hover title
		self.setImageHover(editorObj);

		editorObj.onMouseUp.add(function(editor, e){
		
			var src, newSrc, $target, atts, content,
				target = e.target || e.srcElement || e.originalTarget;

			if(target){
				$target = $(target);
				
				if($target.hasClass('catanis-edit-image')){
					
					//it's a visual shortcode image
					if($lastTarget && $lastTarget[0]!==$target[0]){
						//if another image has been selected before, remove its
						//edit state
						removeEdit($lastTarget);
						$lastTarget = null;
					}
					
					// shortcode image hasn't been clicked (one click)
					if(!$target.data('editnow')){
						
						//the image hasn't been clicked before, change the stadndard
						//image with an edit image (add an edit class)
						src = $target.attr('src');
						newSrc = self.getEditImgSrc(src);
						$target.addClass('catanis-focus-img').data('editnow', true);

						$lastTarget = $target;
					
					}else{ // shortcode image hasn been clicked (two click - show dialog)
						
						//the image has been already clicked once, second click
						//now triggers the edit dialog
						attsString = tinymce.DOM.decode($target.attr('data-atts'));
						content = $target.attr('data-catacontent') ? tinymce.DOM.decode($target.attr('data-catacontent')) : null;
						
						var data = self.convertAttrStringToObj(attsString);
						data = self.escapeObjectQuotes(data);
						
						if(content){
							data.content=content;
						}
						
						var shortcode = $target.data('shortcode'),
							btns = _.filter(self.visualBtns, function(curBtn){
								return curBtn.visual.shortcode === shortcode;
							}),
							btnObj = btns[0];
						
						//create the edit form and dialog
						var formBuilder = new CATANIS.tinymce.formBuilder(btnObj, self.idPrefix, data),
						contentDialog = formBuilder.getFormElement(),
						
							//dialog(btnObj, editorObj, insertCallback, contentDialog, loadCallback, edit, closeCallback){
							dialog = new CATANIS.tinymce.dialog(btnObj, editorObj, 
									function(){self.doOnEdit(editorObj, $target, btnObj);}, //insertCallback
									contentDialog, 
									function(){return formBuilder.initElements();},  //loadCallback
									true, 	// Edit
									function(){self.removeDialog();}	//closeCallback
								);
						
						dialog.init();
						self.dialogs.push(dialog);
					}
				}else{
					if($lastTarget){
						removeEdit($lastTarget);
						$lastTarget = null;
					}
				}
			}
		});

	});

	self.preloadEditImages();

};


/** ok
 * Converts a shortcode attribute string to a JavaScript object with key/value
 * pairs.
 * @param  {string} attsString the string to convert
 * @return {object}            object containing the attributes as key/value
 * pairs
 */
CATANIS.tinymce.btnManager.prototype.convertAttrStringToObj = function(attsString){
	var self = this,
		atts = attsString.split(self.attrPrefix),
		data = {};
	
	_.each(atts, function(att){
		var att_arr = att.split(/=(.+)?/),
			val = '';
		if(att_arr.length>=2){
			val = $.trim(att_arr[1]);
			if(val[0]==='"' && val[val.length-1]==='"'){
				//remove the surrounding quotes
				val = val.slice(1, val.length-1);
			}
			data[att_arr[0]]=val;
		}
	});

	return data;
};


/**
 * Escapes the inner quotes of an attribute string. For example, this string:
 * pex_attr_title="title "here" with a quote" pex_attr_text="content here" 
 * will be converted to:
 * pex_attr_title="title &quot;here&quot; with a quote" pex_attr_text="content here"
 * @param  {string} attsString the attribute string to escape
 * @return {string}            the attribute string with escaped quotes
 */
CATANIS.tinymce.btnManager.prototype.escapeAttrStrInnerQuotes = function(attsString){
	var res='',
		self = this,
		atts = self.convertAttrStringToObj(attsString);

	_.each(atts, function(value, key){
		res+=' '+self.attrPrefix+key+'="'+value.replace(/"/g, '&quot;')+'"';
	});

	res = $.trim(res);

	return res;
};


/** ok
 * Escapes the quotes within an object's values.
 * @param  {object} obj the object whose values will be escaped
 * @return {object}     the object with escaped quotes in the values
 */
CATANIS.tinymce.btnManager.prototype.escapeObjectQuotes = function(obj){

	_.each(obj, function(value, key){
		if(key!=='content' && typeof value === 'string'){
			obj[key] = value.replace(/"/g, '&quot;');
		}
	});

	return obj;
};


/**
 * Updates the visual editor element when the "Update" button is clicked in an
 * edit dialog.
 * @param  {object} ed      the current editor object
 * @param  {object} $target jQuery image object which is the image that represents
 * the edited shortcode
 * @param  {object} btn     the button object associated with the shortcode
 */
CATANIS.tinymce.btnManager.prototype.doOnEdit = function(ed, $target, btn){
	var values,
		html='',
		attrStr='',
		self = this,
		inner = ed.id === 'content' ? false : true;

	values = self.getInputsValue(btn, inner);

	//create an attribute string from the values
	_.each(values, function(val, key){
		if(key!=='content'){
			attrStr+=self.attrPrefix+key+'="'+tinymce.DOM.encode(val)+'" ';
		}
	});
	if(attrStr){
		$target.attr('data-atts', attrStr);
	}

	if(values.content){
		$target.attr('data-catacontent', values.content);
	}

	tinyMCE.execCommand("mceRepaint");

	self.dialogs.pop().remove();

};

CATANIS.tinymce.btnManager.prototype.setButtonVisibility = function(){
	/*var $select = $('select[name="page_template"]'),
		$btn = $('.mce-i-catanisbgsection').parents('.mce-widget:first'),
		setVisibility = function(){
			if($select.val()=='template-full-custom.php'){
				$btn.css({'display':'inline-block'});
			}else{
				$btn.hide();
			}
		};

	if($select.length && $btn.length){
		setVisibility();
		$select.on('change', setVisibility);
	}

	//hide the add image button in the main editor
	$('.mce-i-catanisframe').not('.catanis4h-dialog .mce-i-catanisframe').parents('.mce-widget:first').hide();
	*/
};



/*******************************************************************************
 * BUTTONS DIALOG
 ******************************************************************************/

/**
 * Dialog - inits a dialog to insert or edit data associated with a TinyMCE
 * button.
 * @param  {object} btn            the button object
 * @param  {object} ed             the current editor object
 * @param  {function} insertCallback a callback function that will be executed
 * when the dialog's Insert/Update button is clicked
 * @param  {object} contentDialog          jQuery element object that contains the content
 * of the dialog, such as forms and fields
 * @param  {function} loadCallback   a callback function that will be executed
 * when the dialog is loaded
 * @param  {boolean} edit           sets whether it is edit dialog (when set to
 * true) or an insert dialog (when set to false)
 */
CATANIS.tinymce.dialog = function(btnObj, editorObj, insertCallback, contentDialog, loadCallback, edit, closeCallback){
	this.btnObj = btnObj;
	this.contentDialog = contentDialog;
	this.editorObj = editorObj;
	this.insertCallback = insertCallback;
	this.loadCallback = loadCallback;
	this.edit = edit;
	this.closeCallback = closeCallback;
};


/**
 * Inits the dialog functionality.
 */
CATANIS.tinymce.dialog.prototype.init = function(){
	var self = this,
		dialogWidth = Math.min($(window).width()-100, 800),
		btnText = self.edit ? 'Update' : 'Insert',
		dialog;
	
		self.bodyClassName = 'catanis-dialog-shortcode';
		self.customBodyClassName = 'catanis-dialog-shortcode-'+self.btnObj.id;

		dialog = self.contentDialog.dialog({
		title:self.btnObj.title, 
		modal: true,
		width:dialogWidth,
		dialogClass:'catanis-dialog catanis-dialog-'+self.btnObj.id,
		close:function(event, ui){
			
			$(this).html('').remove();
			self.closeCallback.call();
			self.doOnClose();
		},
		create:function(){
			// add class loading for modal dialog
			self.contentDialog.parent().addClass('catanis-loading');
			
			self.loadCallback.call(null).done(function(){
				self.contentDialog.parent().removeClass('catanis-loading');
			});

		},
		open:function(){
			$('body').addClass(self.bodyClassName+' '+self.customBodyClassName);
			//remove the preventing of the focus in event in jQuery UI
			//fixes the issue with the WordPress Link dialog fields not being editable
			setTimeout(function(){
				$(document).off('focusin.dialog');
			}, 500);
			
		},
		buttons:[
			{
				"html": '<i aria-hidden="true" class="icon-plus"></i>' + btnText,
				"class":"catanis-btn btn-primary",
				"click": function(){
					self.insertCallback.call();
				}
			},
			{
				"html": 'Close',
				"class":"catanis-btn",
				"click": function(){
					$(this).html('').remove();
					self.closeCallback.call();
					self.doOnClose();
				}
			}
		]
	});

	this.dialogEl = dialog;

};

/**
 * Removes the dialog.
 */
CATANIS.tinymce.dialog.prototype.remove = function(){
	this.dialogEl.remove();
	this.doOnClose();
};

CATANIS.tinymce.dialog.prototype.doOnClose = function(){
	$('body').removeClass(this.customBodyClassName);

	var bClasses = document.body.className.match(/catanis\-dialog\-opened\-/gi);
	if(!bClasses){
		//there are no other dialogs opened, remove the body dialog class
		$('body').removeClass(this.bodyClassName);
	}
};



/*******************************************************************************
 * FORM BUILDER
 ******************************************************************************/

/**
 * Builds a form that contains all of the inputs associated with a TinyMCE
 * button to add/edit data.
 * @param  {object} btnObj      the button object
 * @param  {string} idPrefix the prefix of the elements/inputs IDs
 * @param  {object} defData  default data can be set to the inputs, set as 
 * null when there is no default data
 */
CATANIS.tinymce.formBuilder = function(btnObj, idPrefix, defData){
	this.btnObj = btnObj;
	this.idPrefix = idPrefix;
	this.$el = null;
	this.defData = defData;
};


CATANIS.tinymce.count = 0;

/**
 * Builds the form element and returns it.
 * @return {object} a jQuery object element containing all of the form fields
 * and data.
 */
CATANIS.tinymce.formBuilder.prototype.getFormElement = function(){
	var self 	= this,
		btnObj 	= self.btnObj,
		defData = self.defData,
		html	=	'<div>';

	for(var i=0, length = btnObj.fields.length; i<length; i++){
		var field = btnObj.fields[i], inputHtml='',
			defValue = (defData && defData[field.id]) ? defData[field.id] : null;

		if(field.type=='subtitle'){
			//subtitle (start of new section) field
			if(field.small){
				html+='<span class="dialog-subtitle-small">'+field.name+'</span>';
			}else{
				html+='<h3 class="dialog-subtitle">'+field.name+'</h3>';
			}
			continue;
		}

		if(field.values){
			if(field.imgradio){
				//this is an image radio element
				$.each(field.values, function(index, value){
					var selected;

					selected = (defValue && defValue===value.id) || (index===0 && defValue===null) ? ' checked' : '';
					inputHtml+='<div class="dialog-img-radio"><input type="radio" name="'+self.idPrefix+field.id+'" value="'+
						value.id+'"'+selected+'><img src="'+value.img+'">';
					if(!field.hideTitle){
						inputHtml+='<span class="img-radio-title">'+value.name+'</span>';
					}
					inputHtml+='</div>';
				});
			} else{
				//this is a select list
				inputHtml = '<select class="option-select select-chosen" id="'+self.idPrefix+field.id+'">';
				$.each(field.values, function(index, value){
					var name, id, selected;
					if(typeof value === 'string'){
						name = self.ucfirst(value);
						id = value;
					}else{
						name = value.name;
						id = value.id;
					}
					
					selected = (defValue && defValue===id) ? ' selected="selected"' : '';
					inputHtml+='<option value="'+id+'"'+selected+'>'+name+'</option>';
				});
				inputHtml+='</select>';
			}

		}else{

			if(field.textarea && !CATANIS.tinymce.opera){
				//this is a textarea
				var val = defValue || '';
				var clsText = (field.size) ? 'class="'+field.size+'"' : null;
				inputHtml='<textarea id="'+self.idPrefix+field.id+'" '+clsText+'>'+val+'</textarea>';
			}else if(field.type==='wysiwyg'){
				//this is a wysiwyg/tinymce editor
				inputHtml='<textarea id="'+self.idPrefix+field.id+(++CATANIS.tinymce.count)+'" class="catanis_tinymce"></textarea>';
			}else if(field.type==='upload'){
				var styleWrap = '', styleBtn = '',
					data = 'data-fieldid="'+self.idPrefix+field.id+'" data-type="text"';
				
				if(defValue){
					data	+=' data-url="'+defValue+'"';
					data	+=' data-thumbnail="'+defValue+'"';
					
					styleWrap 	= ' style="display:block;"';
					styleBtn 	= ' style="display: none;"';
				}

				inputHtml	= ' <div class="catanis-upload" '+data+'>';
				inputHtml 	+= '	<div class="upload-image-wrapper"'+styleWrap+'>';
				inputHtml 	+= '		<img src="" class="upload-preview">';
				inputHtml 	+= '		<div class="upload-remove-image"><span class="icon-delete2"></span>Remove Upload</div>';
				inputHtml 	+= '	</div>';
				inputHtml 	+= '	<button type="button" data-choose="Choose a File" data-update="Select File" class="catanis-btn btn-icon catanis-opts-upload"'+styleBtn+'>';
				inputHtml 	+= '		<span class="icon-popup"></span>Browse</button>';
				inputHtml 	+= '	<input type="hidden" id="'+self.idPrefix+field.id+'" name="'+self.idPrefix+field.id+'" value="">';
				inputHtml 	+= '</div>';
			
			}else if(field.selectgroup){
				inputHtml = '<select class="option-select select-chosen" id="'+self.idPrefix+field.id+'">';
				inputHtml+= field.options;
				inputHtml+= '</select>';
			}else{
				//input field
				var inputClass 	= "option-input",
					attrInput	= "",
					val = defValue ? ' value="'+defValue+'"' : '';

				if(field.type==='colorpicker'){
					//colorpicker field
					inputClass += " color";
					attrInput = ' data-default-color="'+defValue+'"';
				}

				inputHtml+='<input type="text" id="'+self.idPrefix+field.id+'" class="'+inputClass+'" '+val+attrInput+'/>';
				if(field.suffix){
					inputHtml += '<span class="option-suffix">'+field.suffix+'</span>';
				}
			}
		}
		var addClass = '';
		if(field.twocolumn){
			addClass = ' small-field';
			if(field.twocolumn=='first'){
				html+='<div class="catanis-shortcode-two-column">';
			}
		}
		if(field.imgradio){
			addClass+=' img-radio-field';
		}

		var desc = field.desc ? '<span class="dialog-desc">'+field.desc+'</span>' : '';
		
		html+='<div class="catanis-shortcode-field'+addClass+'"><label><span class="dialog-title">'+field.name+'</span>'+desc+'</label>'+inputHtml+'</div>';

		if(field.twocolumn=='last'){
			html+='</div>';
		}
	}
	html+='</div>';

	self.$el = $(html);

	return self.$el;
};


CATANIS.tinymce.formBuilder.prototype.ucfirst = function(string){
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}


/**
 * Inits the elements within the form, such as Upload functionality, Color
 * Picker, additional TinyMCE editors, etc.
 * @return {Deferred} returns a jQuery Deferred object which gets resolved when 
 * all of the functionality and elements are loaded.
 */
CATANIS.tinymce.formBuilder.prototype.initElements = function(){
	var self = this,
		$el = self.$el,
		pending = false,
		deferred = new $.Deferred();

	self.initDependentFields();

	//load the upload functionality
	$el.find('.catanis-upload').each(function(){
		///$(this).catanisUpload();
	});

	//load the color picker functionality
	$el.find('.color').each(function(){
		$(this).catanisColorPicker();
	});

	//load the radio images
	$el.find('.dialog-img-radio img').on('click', function(){
		$(this).siblings('input:radio').trigger('click');
	});
	
	var $tinymce_editor = $el.find('.catanis_tinymce');
	if($tinymce_editor.length){
		//load the TinyMCE editor
		pending = true;

		var editorId = $tinymce_editor.attr('id') || 'catanis_editor',
			data = {'action':'catanis_print_wp_editor', 'id':editorId};

		$.ajax({
			url: ajaxurl,
			data_type:'POST',
			data: data
		}).done(function(res){
			
			$tinymce_editor.replaceWith(res);

			//create a new editor settings object and copy all of the editor 
			//settings from the main WordPress content editor to the new one
			tinyMCEPreInit.mceInit[editorId] = $.extend(
				{id:editorId, theme:'advanced'}, 
				tinyMCEPreInit.mceInit['content']);
			tinyMCEPreInit.mceInit[editorId].elements = editorId;
			tinyMCEPreInit.mceInit[editorId].body_class = editorId;
			tinyMCEPreInit.mceInit[editorId].selector = '#'+editorId;

			//make it compatible with both TinyMCE 3.0 & 4.0
			var buttonsKey = tinyMCEPreInit.mceInit[editorId]['theme_advanced_buttons1'] ?
				'theme_advanced_buttons' : 'toolbar';

			if(CATANIS.tinymce.excludeDialogButtons){
				//exclude some of the default TinyMCE buttons
				for(var i=1; i<=4; i++){
					var buttons = tinyMCEPreInit.mceInit[editorId][buttonsKey+i],len;
					buttons = buttons.replace(CATANIS.tinymce.excludeDialogButtons, '');
					len = buttons.length;

					if(buttons[len-1]===','){
						buttons = buttons.substring(0, len - 1);
					}
					
					tinyMCEPreInit.mceInit[editorId][buttonsKey+i]=buttons;
				}
			}
			
			tinyMCE.init(tinyMCEPreInit.mceInit[editorId]);
			var qtInit = $.extend({}, tinyMCEPreInit.qtInit['content']);
			qtInit.id=editorId;
			tinyMCEPreInit.qtInit[editorId] = qtInit;

			quicktags( tinyMCEPreInit.qtInit[editorId] );

			tinyMCE.activeEditor = tinyMCE.get(editorId);

			if(self.defData && self.defData.content){
				//insert the default content to the editor
				tinyMCE.get(editorId).execCommand('mceInsertContent', false, self.defData.content);
			}

			deferred.resolve();
		});

	}

	if(!pending){
		deferred.resolve();
	}

	return deferred;
};

CATANIS.tinymce.formBuilder.prototype.getSingleElement = function(id){
	var self = this;
	return self.$el.find('#'+self.idPrefix+id+',input:radio[name="'+self.idPrefix+id+'"]');
};


CATANIS.tinymce.formBuilder.prototype.initDependentFields = function(){
	var self = this,
		getFieldVal = function($el, type){
			if(type=='select'){
				return $el.val();
			}else{
				return $el.filter(':checked').val();
			}
		},
		updateDependentFields = function(field, $el, init){
			var fieldType = field.imgradio ? 'imgradio' : 'select',
				selectedVal = getFieldVal($el, fieldType),
				defaults = _.filter(field.values, function(val){
					return val.id === selectedVal;
				});

			if(defaults[0]){
				_.each(defaults[0].defaults, function(defVal, key){
					var $input = self.getSingleElement(key),
						changed = $input.val() ? true : false;

					if($input.prop("tagName").toLowerCase()==='select' && 
						$input.find('option:selected').index()===0){
						changed = false;
					}

					if(!changed || !init){
						$input.val(defVal);
						if($input.hasClass('color') && !init){
							$input.trigger('colorChange');
						}
					}
				});
			}
		},
		hiddenInputs = [],
		setFieldsVisibility = function(field, $select){
			var i,
				selectedVal = $select.val(),
				selectedValField = _.filter(field.values, function(val){
					return val.id===selectedVal;
			});

			//show all fields
			i=hiddenInputs.length;
			while(i--){
				hiddenInputs[i].show();
			}
			hiddenInputs = [];

			if(selectedValField.length){
				if(selectedValField[0].hide){
					for(i = 0; i<selectedValField[0].hide.length; i++){
						var $fieldToHide = self.getSingleElement(selectedValField[0].hide[i]).parent();
						$fieldToHide.hide();
						hiddenInputs.push($fieldToHide);
					}
				}
			}

		};

	_.each(self.btnObj.fields, function(field){
		if(field.values){
			var $el = self.getSingleElement(field.id);
			if(field.values[0].defaults){
				//this field has some default values that should be applied
				//to the dependent fields
				
				updateDependentFields(field, $el, true);

				$el.on('change', function(){
					updateDependentFields(field, $el, false);
				});
			}

			var fieldsToHide = _.filter(field.values, function(val){
				return val.hide;
			});

			if(fieldsToHide.length){
				setFieldsVisibility(field, $el);
				$el.on('change', function(){
					setFieldsVisibility(field, $el);				
				});
			}
		}
	});
};

$(document).ready(function() {
	//init the custom formatting buttons functionality
	var btnManager = new CATANIS.tinymce.btnManager(CATANIS.tinymce.buttons);
	btnManager.init();
});


})(jQuery);
