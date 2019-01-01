<?php
/*=== VISUAL ROW =============================*/
/*============================================*/
vc_map( array(
	'name'		 	=> esc_attr__('Row', 'catanis-core'),
	'base' 			=> 'vc_row',
	'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/row.png',
	'category' 		=> esc_html__( 'Catanis Elements', 'catanis-core'),
	'wrapper_class' => 'clearfix',
	'js_view' 		=> 'VcRowView',
	'is_container' 	=> true,   
	'show_settings_on_create' => false,
	'description' 	=> esc_html__( 'Place content elements inside the row.', 'catanis-core'),
	'params' 		=> array(
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__( 'Row stretch', 'catanis-core' ),
			'param_name' 		=> 'row_stretch',
			'value' 			=> array(
				__( 'Container (Default)', 'catanis-core' ) 	=> 'container',
				__( 'Container Stretch', 'catanis-core' ) 		=> 'container_stretch',
				__( 'Container Fluid', 'catanis-core' ) 		=> 'container_fluid',
				__( 'Full Width', 'catanis-core' ) 				=> 'fullwidth',
			),
			'std' 				=> 'container_stretch',
			'description' 		=> esc_attr__( 'Select stretching options for row and content (Note: stretched may not work properly if parent container has "overflow: hidden" CSS property).', 'catanis-core' ),
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__('Overflow hidden', 'catanis-core'),
			'param_name' 		=> 'overflow_hidden',
			'value' 			=> array( esc_attr__( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> esc_attr__( 'Checked it to set content overflow hidden.', 'catanis-core' ),
		),
		array(
         	'type' 				=> 'checkbox',
        	'heading' 			=> esc_attr__('Full height row?', 'catanis-core'),
         	'param_name' 		=> 'full_height',
         	'value' 			=> array( esc_attr__( 'Yes', 'catanis-core' ) => 'yes' ),
        	'description' 		=> esc_attr__( 'If checked row will be set to full height, usually use for first row.', 'catanis-core' ),
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> __( 'Columns position', 'catanis-core' ),
			'param_name' 		=> 'columns_placement',
			'value' 			=> array(
				__( 'Default', 'catanis-core' ) => '',
				__( 'Top', 'catanis-core' ) 	=> 'top',
				__( 'MIddle', 'catanis-core' ) 	=> 'middle',
				__( 'Bottom', 'catanis-core' ) 	=> 'bottom',
			),
			'std' 				=> '',
			'dependency' 		=> array( 'element' => 'full_height', 'value' => array('yes') ),
			'description' 		=> esc_attr__( 'Select columns position within row.', 'catanis-core' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear'
		),
		
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('For Columns in Row Setting', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__( 'Equal height', 'catanis-core' ),
			'param_name' 		=> 'equal_height',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> esc_attr__( 'If checked columns will be set to equal height.', 'catanis-core' )
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__( 'Content Position', 'catanis-core' ),
			'param_name' 		=> 'content_placement',
			'value' 			=> array(
				__( 'Default', 'catanis-core' ) => '',
				__( 'Top', 'catanis-core' ) 	=> 'top',
				__( 'Middle', 'catanis-core' ) 	=> 'middle',
				__( 'Bottom', 'catanis-core' ) 	=> 'bottom',
			),
			'description' 		=> esc_attr__( 'Select content position within columns.', 'catanis-core' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> __( 'Columns gap', 'catanis-core' ),
			'param_name' 		=> 'columns_gap',
			'value' 			=> array(
				'0px' 	=> '0',
				'10px' 	=> '10',
				'20px' 	=> '20',
				'30px' 	=> '30',
				'40px' 	=> '40',
				'50px' 	=> '50',
			),
			'std' 				=> '30',
			'description' 		=> __( 'Select gap between columns in row.', 'catanis-core' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
		),
			
		/* Group: Background */	
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Type', 'catanis-core'),
			'param_name' 		=> 'bg_type',
			'std' 				=> 'no_bg',
			'value' 			=> array(
				esc_attr__('Default')			=> 'no_bg',
				esc_attr__('Color')				=> 'color',
				esc_attr__('Image / Parallax')	=> 'image',
				esc_attr__('Youtube Video')		=> 'youtube',
				esc_attr__('Vimeo Video')		=> 'vimeo',
				esc_attr__('Hosted Video')		=> 'self'
			),
			'description' 		=> esc_html__('Note: Youtube Video does not work on mobile', 'catanis-core'),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Background Color', 'catanis-core' ),
			'param_name' 		=> 'bg_color',
			'value' 			=> '#FFFFFF',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('color')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Background Image', 'catanis-core'),
			'param_name' 		=> 'bg_image',  
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Size', 'catanis-core'),
			'param_name' 		=> 'bg_image_size',
			'std' 				=> 'cover',
			'value' 			=> array(
				__('Cover - Image to be as large as possible', 'catanis-core')						=> 'cover',
				__('Contain - Image will try to fit inside the container area', 'catanis-core')		=> 'contain',
				__('Initial - If the height content >= 650, recommend using this option.', 'catanis-core')	=> 'initial'
			),
			'description' 		=> esc_html__('Options to control size of the background image.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Position', 'catanis-core'),
			'param_name' 		=> 'bg_image_position',
			'std' 				=> 'center center',
			'value' 			=> array(
				esc_html__('center top', 'catanis-core')		=> 'center top',
				esc_html__('center center', 'catanis-core')		=> 'center center',
				esc_html__('center bottom', 'catanis-core')		=> 'center bottom',
				esc_html__('left top', 'catanis-core')			=> 'left top',
				esc_html__('left center', 'catanis-core')		=> 'left center',
				esc_html__('left bottom', 'catanis-core')		=> 'left bottom',
				esc_html__('right top', 'catanis-core')			=> 'right top',
				esc_html__('right center', 'catanis-core')		=> 'right center',
				esc_html__('right bottom', 'catanis-core')		=> 'right bottom',
			),
			'description' 		=> esc_html__('Options to control position of the background image.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Repeat', 'catanis-core'),
			'param_name' 		=> 'bg_image_repeat',
			'value' 			=> array(
				esc_html__('No Repeat', 'catanis-core')								=> 'no-repeat',
				esc_html__('Repeat Horizontally', 'catanis-core')					=> 'repeat-x',
				esc_html__('Repeat Vertically', 'catanis-core')						=> 'repeat-y',
				esc_html__('Repeat Vertically and Horizontally', 'catanis-core')	=> 'repeat'
			),
			'description' 		=> esc_html__('Defines the directions in which a background image will be repeated.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__('Show Overlay Div', 'catanis-core'),
			'param_name' 		=> 'show_overlay',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'description' 		=> esc_attr__( 'Checked it to show overlay in row.', 'catanis-core' ),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Overlay Opacity', 'catanis-core'),
			'param_name' 		=> 'overlay_opacity',
			'value' 			=> $catanis_vc_opacity,
			'dependency' 		=> array( 'element' => 'show_overlay', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Overlay Color', 'catanis-core' ),
			'param_name' 		=> 'overlay_color',
			'dependency' 		=> array( 'element' => 'show_overlay', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__( 'Use Parallax', 'catanis-core' ),
			'param_name' 		=> 'use_parallax',
			'value' 			=> array( esc_attr__( 'Yes', 'catanis-core' ) => 'yes' ),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'description' 		=> __( 'Checked it to use background image with parallax.', 'catanis-core' ),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_html__('Parallax Speed', 'catanis-core'),
			'param_name' 		=> 'parallax_speed',
			'value' 			=> '0.1',
			'dependency' 		=> array('element' => 'use_parallax', 'value' => array('yes')),
			/*'edit_field_class' 	=> 'hide',*/
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__( 'Add Texture Image', 'catanis-core' ),
			'param_name' 		=> 'add_texture',
			'value' 			=> array( esc_attr__( 'Yes', 'catanis-core' ) => 'yes' ),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image', 'color')),
			'description' 		=> __( 'Checked it to add background texture for top and bottom in row.', 'catanis-core' ),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Texture Image on Top', 'catanis-core'),
			'param_name' 		=> 'texture_top',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'add_texture', 'value' => array('yes')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Texture Image on Bottom', 'catanis-core'),
			'param_name' 		=> 'texture_bottom',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'add_texture', 'value' => array('yes')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_html__('Youtube Video URL', 'catanis-core'),
			'param_name' 		=> 'video_url_youtube',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('youtube')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_html__('Vimeo Video URL', 'catanis-core'),
			'param_name' 		=> 'video_url_vimeo',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('vimeo')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'href',
			'heading' 			=> esc_html__('MP4 Video URL', 'catanis-core'),
			'param_name' 		=> 'video_url_mp4',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('self')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'href',
			'heading' 			=> esc_html__('WebM Video URL', 'catanis-core'),
			'param_name' 		=> 'video_url_webm',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('self')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'href',
			'heading' 			=> esc_html__('Ogg Video URL', 'catanis-core'),
			'param_name' 		=> 'video_url_ogg',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('self')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Placeholder Image', 'catanis-core'),
			'param_name' 		=> 'video_poster',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('youtube', 'vimeo', 'self')),
			'description' 		=> esc_html__('Note: Don\'t display when use Autoplay', 'catanis-core'),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__( 'Show Video Control', 'catanis-core' ),
			'param_name' 		=> 'show_video_control',
			'value' 			=> array(
				'No' 	=> 'no-video-control',
				'Yes' 	=> 'show-video-control'
			),
			'std' 				=> 'show-video-control',
			'description' 		=> esc_html__( 'Video will autoplay if don\'t show video control', 'catanis-core' ),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('youtube', 'vimeo', 'self')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_html__('Extra Options', 'catanis-core'),
			'param_name' 		=> 'video_opts',
			'value' 			=> array(
				'Auto Play' 	=> 'autoplay', 
				'Loop' 			=> 'loop',
				'Muted' 		=> 'muted'
			),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('youtube', 'vimeo', 'self')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
			
		/* Group: Design Options */
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Margin Setting (Can use \'%\' or \'px\' Eg. 5%, 10px,..)', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper mt0 vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_top',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_right',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> __('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_bottom',
			'value' 			=> '30px',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_left',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Padding Setting (Can use \'%\' or \'px\' Eg. 5%, 10px,..)', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_top',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_right',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_bottom',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_left',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Border Setting', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Row Border', 'catanis-core' ),
			'param_name' 		=> 'row_border',
			'value' 			=> array(
				esc_attr__('No Border', 'catanis-core') 	=> '',
				esc_attr__('Border Top', 'catanis-core') 	=> 'border-top',
				esc_attr__('Border Bottom', 'catanis-core') => 'border-bottom'
			),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Border Color', 'catanis-core' ),
			'param_name' 		=> 'border_color',
			'dependency' 		=> array( 'element' => 'row_border', 'value' => array('border-top','border-bottom') ),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'ca_vc_number',
			'heading' 			=> esc_html__( 'Border Size', 'catanis-core' ),
			'param_name' 		=> 'border_size',
			'value' 			=> 0,
			'min' 				=> 0,
			'max' 				=> 20,
			'suffix' 			=> 'px',
			'description' 		=> esc_html__('Input a border size (Max: 20).', 'catanis-core'),
			'dependency' 		=> array( 'element' => 'row_border', 'value' => array('border-top','border-bottom') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__( 'Border Type', 'catanis-core' ),
			'param_name' 		=> 'border_type',
			'value' 			=> array(
				esc_attr__('no border', 'catanis-core') => '',
				esc_attr__('Dotted', 'catanis-core') 	=> 'dotted',
				esc_attr__('Dashed', 'catanis-core') 	=> 'dashed',
				esc_attr__('Solid', 'catanis-core') 	=> 'solid',
				esc_attr__('Double', 'catanis-core') 	=> 'double'
			),
			'description' 		=> esc_html__('Choose a border type.', 'catanis-core'),
			'dependency' 		=> array( 'element' => 'row_border', 'value' => array('border-top','border-bottom') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Setting Padding/Margin for IPAD and MOBILE', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Padding/Margin for IPAD', 'catanis-core'),
			'param_name' 		=> 'ipad_custom_padding_margin',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom padding and margin on Ipad.', 'catanis-core' ),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_top',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-top'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_right',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-right'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_bottom',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-bottom'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_left',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-left'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_top',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-top'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_right',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-right'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_bottom',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-bottom'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_left',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-left'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Padding/Margin for MOBILE', 'catanis-core'),
			'param_name' 		=> 'mobile_custom_padding_margin',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom padding and margin on Mobile.', 'catanis-core' ),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_top',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-top'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_right',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-right'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_bottom',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-bottom'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_left',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-left'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_top',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-top'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_right',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-right'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_bottom',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-bottom'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_left',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-left'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
			
		/* Group: Scroll To Down */
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Scroll To Down', 'catanis-core'),
			'param_name' 		=> 'scroll_to_down',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set scroll to down in section or for One page scroll template.', 'catanis-core' ),
			'edit_field_class' 	=> 'hide',
			/*'group'				=> esc_attr__('Scroll To Down', 'catanis-core')*/
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> __('Scroll Id', 'catanis-core' ),
			'param_name' 		=> 'scroll_to_down_id',
			'dependency' 		=> array( 'element' => 'scroll_to_down', 'value' => array('yes') ),
			'description' 		=> __( 'Ex: #about, #services, #contact,...', 'catanis-core' ),
			'edit_field_class' 	=> 'hide',
			/*'group'				=> esc_attr__('Scroll To Down', 'catanis-core')*/
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> __('Scroll Ttile', 'catanis-core' ),
			'param_name' 		=> 'scroll_to_down_title',
			'dependency' 		=> array( 'element' => 'scroll_to_down', 'value' => array('yes') ),
			'description' 		=> __( 'Input a title for section. Ex: About, Services, Contact,...', 'catanis-core' ),
			'edit_field_class' 	=> 'hide',
			/*'group'				=> esc_attr__('Scroll To Down', 'catanis-core')*/
		),
			
		/* Group: Extras */
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Disable row', 'catanis-core' ),
			'param_name' 		=> 'disable_element',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'If checked the row won\'t be visible on the public side of your website. You can switch it back any time.', 'catanis-core' ),
			'group'				=> esc_attr__('Extras', 'catanis-core')
		),
		catanis_vc_extra_id(true),
		catanis_vc_extra_class(true),
			
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Animation More Images for Row', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Extend Images', 'catanis-core' ),
			'param_name' 		=> 'extend_imgs',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'If checked the row will extend more images use animation.', 'catanis-core' ),
			'group'				=> esc_attr__('Extras', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Image Top Left', 'catanis-core'),
			'param_name' 		=> 'img_topleft',
			'value' 			=> '',
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'dependency' 		=> array('element' => 'extend_imgs', 'value' => array('yes')),
			'group'				=> esc_attr__('Extras', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Image Top Right', 'catanis-core'),
			'param_name' 		=> 'img_topright',
			'value' 			=> '',
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'dependency' 		=> array('element' => 'extend_imgs', 'value' => array('yes')),
			'group'				=> esc_attr__('Extras', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Image Center Left', 'catanis-core'),
			'param_name' 		=> 'img_centerleft',
			'value' 			=> '',
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'dependency' 		=> array('element' => 'extend_imgs', 'value' => array('yes')),
			'group'				=> esc_attr__('Extras', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Image Center Right', 'catanis-core'),
			'param_name' 		=> 'img_centerright',
			'value' 			=> '',
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'dependency' 		=> array('element' => 'extend_imgs', 'value' => array('yes')),
			'group'				=> esc_attr__('Extras', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Image Bottom Left', 'catanis-core'),
			'param_name' 		=> 'img_bottomleft',
			'value' 			=> '',
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'dependency' 		=> array('element' => 'extend_imgs', 'value' => array('yes')),
			'group'				=> esc_attr__('Extras', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Image Bottom Right', 'catanis-core'),
			'param_name' 		=> 'img_bottomright',
			'value' 			=> '',
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'dependency' 		=> array('element' => 'extend_imgs', 'value' => array('yes')),
			'group'				=> esc_attr__('Extras', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Image Top Center', 'catanis-core'),
			'param_name' 		=> 'img_topcenter',
			'value' 			=> '',
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'dependency' 		=> array('element' => 'extend_imgs', 'value' => array('yes')),
			'group'				=> esc_attr__('Extras', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Image Bottom Center', 'catanis-core'),
			'param_name' 		=> 'img_bottomcenter',
			'value' 			=> '',
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'dependency' 		=> array('element' => 'extend_imgs', 'value' => array('yes')),
			'group'				=> esc_attr__('Extras', 'catanis-core')
		),
			
		/* Group: Animation */
		catanis_vc_use_animation(),
		catanis_vc_animation_type(),
		catanis_vc_animation_duration(),
		catanis_vc_animation_delay()
	)
) );

/*=== VISUAL ROW INNER =======================*/
/*============================================*/
vc_map( array(
	'name'		 	=> esc_attr__('Inner Row', 'catanis-core'),
	'base' 			=> 'vc_row_inner',
	'category' 		=> esc_html__( 'Catanis Elements', 'catanis-core'),
	'js_view' 		=> 'VcRowView',
	'is_container' 	=> true,
	'content_element' => false,
	'description' 	=> esc_html__( 'Place content elements inside the inner row.', 'catanis-core'),
	'params' 		=> array(
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__( 'Row stretch', 'catanis-core' ),
			'param_name' 		=> 'row_stretch',
			'value' 			=> array(
				__( 'Container (Default)', 'catanis-core' ) 	=> 'container',
				__( 'Full Width', 'catanis-core' ) 				=> 'fullwidth',
			),
			'description' 		=> esc_attr__( 'Use in container or full width with parent row.', 'catanis-core' ),
		),
		
		/* Group: Background */
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Type', 'catanis-core'),
			'param_name' 		=> 'bg_type',
			'std' 				=> 'no_bg',
			'value' 			=> array(
				esc_html__( 'Default' )				=> 'no_bg',
				esc_html__( 'Color' )				=> 'color',
				esc_html__( 'Image / Parallax' )	=> 'image',
				esc_html__( 'Youtube Video' )		=> 'youtube',
				esc_html__( 'Vimeo Video' )			=> 'vimeo',
				esc_html__( 'Hosted Video' )		=> 'self'
			),
			'description' 		=> esc_html__('Note: Youtube Video does not work on mobile', 'catanis-core'),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Background Color', 'catanis-core' ),
			'param_name' 		=> 'bg_color',
			'value' 			=> '#FFFFFF',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('color')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Background Image', 'catanis-core'),
			'param_name' 		=> 'bg_image', 
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Size', 'catanis-core'),
			'param_name' 		=> 'bg_image_size',
			'std' 				=> 'cover',
			'value' 			=> array(
				__('Cover - Image to be as large as possible', 'catanis-core')						=> 'cover',
				__('Contain - Image will try to fit inside the container area', 'catanis-core')		=> 'contain',
				__('Initial - If the height content >= 650, recommend using this option.', 'catanis-core')	=> 'initial'
			),
			'description' 		=> esc_html__('Options to control size of the background image.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Position', 'catanis-core'),
			'param_name' 		=> 'bg_image_position',
			'std' 				=> 'center center',
			'value' 			=> array(
				esc_html__('center top', 'catanis-core')		=> 'center top',
				esc_html__('center center', 'catanis-core')		=> 'center center',
				esc_html__('center bottom', 'catanis-core')		=> 'center bottom',
				esc_html__('left top', 'catanis-core')			=> 'left top',
				esc_html__('left center', 'catanis-core')		=> 'left center',
				esc_html__('left bottom', 'catanis-core')		=> 'left bottom',
				esc_html__('right top', 'catanis-core')			=> 'right top',
				esc_html__('right center', 'catanis-core')		=> 'right center',
				esc_html__('right bottom', 'catanis-core')		=> 'right bottom',
			),
			'description' 		=> esc_html__('Options to control position of the background image.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Repeat', 'catanis-core'),
			'param_name' 		=> 'bg_image_repeat',
			'value' 			=> array(
				esc_html__('No Repeat', 'catanis-core')								=> 'no-repeat',
				esc_html__('Repeat Horizontally', 'catanis-core')					=> 'repeat-x',
				esc_html__('Repeat Vertically', 'catanis-core')						=> 'repeat-y',
				esc_html__('Repeat Vertically and Horizontally', 'catanis-core')	=> 'repeat'
			),
			'description' 		=> esc_html__('Defines the directions in which a background image will be repeated.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__('Show Overlay Div', 'catanis-core'),
			'param_name' 		=> 'show_overlay',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'description' 		=> esc_attr__( 'Checked it to show overlay in row.', 'catanis-core' ),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Overlay Opacity', 'catanis-core'),
			'param_name' 		=> 'overlay_opacity',
			'value' 			=> $catanis_vc_opacity,
			'dependency' 		=> array( 'element' => 'show_overlay', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Overlay Color', 'catanis-core' ),
			'param_name' 		=> 'overlay_color',
			'dependency' 		=> array( 'element' => 'show_overlay', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__( 'Use Parallax', 'catanis-core' ),
			'param_name' 		=> 'use_parallax',
			'value' 			=> array( esc_attr__( 'Yes', 'catanis-core' ) => 'yes' ),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'description' 		=> __( 'Checked it to use background image with parallax.', 'catanis-core' ),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_html__('Parallax Speed', 'catanis-core'),
			'param_name' 		=> 'parallax_speed',
			'value' 			=> '0.1',
			'dependency' 		=> array('element' => 'use_parallax', 'value' => array('yes')),
			/*'edit_field_class' 	=> 'hide',*/
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_html__('Youtube Video URL', 'catanis-core'),
			'param_name' 		=> 'video_url_youtube',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('youtube')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_html__('Vimeo Video URL', 'catanis-core'),
			'param_name' 		=> 'video_url_vimeo',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('vimeo')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'href',
			'heading' 			=> esc_html__('MP4 Video URL', 'catanis-core'),
			'param_name' 		=> 'video_url_mp4',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('self')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'href',
			'heading' 			=> esc_html__('WebM Video URL', 'catanis-core'),
			'param_name' 		=> 'video_url_webm',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('self')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'href',
			'heading' 			=> esc_html__('Ogg Video URL', 'catanis-core'),
			'param_name' 		=> 'video_url_ogg',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('self')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Placeholder Image', 'catanis-core'),
			'param_name' 		=> 'video_poster',
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('youtube', 'vimeo', 'self')),
			'description' 		=> esc_html__('Note: Don\'t display when use Autoplay', 'catanis-core'),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__( 'Show Video Control', 'catanis-core' ),
			'param_name' 		=> 'show_video_control',
			'value' 			=> array(
				'No' 	=> 'no-video-control',
				'Yes' 	=> 'show-video-control'
			),
			'std' 				=> 'show-video-control',
			'description' 		=> esc_html__( 'Video will autoplay if don\'t show video control', 'catanis-core' ),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('youtube', 'vimeo', 'self')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_html__('Extra Options', 'catanis-core'),
			'param_name' 		=> 'video_opts',
			'value' 			=> array(
				esc_attr__('Auto Play') 	=> 'autoplay', 
				esc_attr__('Loop') 			=> 'loop',
				esc_attr__('Muted') 		=> 'muted'
			),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('youtube', 'vimeo', 'self')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
			
		/* Group: Design Options */
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Margin Setting (Can use \'%\' or \'px\' Eg. 5%, 10px,..)', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper mt0 vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_top',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_right',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> __('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_bottom',
			'value' 			=> '30px',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_left',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Padding Setting (Can use \'%\' or \'px\' Eg. 5%, 10px,..)', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_top',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_right',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_bottom',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_left',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),

		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Border Setting', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Row Border', 'catanis-core' ),
			'param_name' 		=> 'row_border',
			'value' 			=> array(
				esc_attr__('No Border', 'catanis-core') 	=> '',
				esc_attr__('Border Top', 'catanis-core') 	=> 'border-top',
				esc_attr__('Border Bottom', 'catanis-core') => 'border-bottom'
			),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Border Color', 'catanis-core' ),
			'param_name' 		=> 'border_color',
			'dependency' 	=> array('element' => 'row_border', 'not_empty' => true),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'ca_vc_number',
			'heading' 			=> esc_html__( 'Border Size', 'catanis-core' ),
			'param_name' 		=> 'border_size',
			'value' 			=> 0,
			'min' 				=> 0,
			'max' 				=> 20,
			'suffix' 			=> 'px',
			'description' 		=> esc_html__('Input a border size (Max: 20).', 'catanis-core'),
			'dependency' 	=> array('element' => 'row_border', 'not_empty' => true),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__( 'Border Type', 'catanis-core' ),
			'param_name' 		=> 'border_type',
			'value' 			=> array(
				esc_attr__('no border', 'catanis-core') => '',
				esc_attr__('Dotted', 'catanis-core') 	=> 'dotted',
				esc_attr__('Dashed', 'catanis-core') 	=> 'dashed',
				esc_attr__('Solid', 'catanis-core') 	=> 'solid',
				esc_attr__('Double', 'catanis-core') 	=> 'double'
			),
			'description' 		=> esc_html__('Choose a border type.', 'catanis-core'),
			'dependency' 	=> array('element' => 'row_border', 'not_empty' => true),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type'					=> 'ca_vc_heading',
			'text'					=> esc_attr__('Setting Padding/Margin for IPAD and MOBILE', 'catanis-core'),
			'param_name'			=> 'main_heading_typograpy',
			'edit_field_class'		=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'					=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Padding/Margin for IPAD', 'catanis-core'),
			'param_name' 		=> 'ipad_custom_padding_margin',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom padding and margin on Ipad.', 'catanis-core' ),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_top',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-top'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_right',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-right'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_bottom',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-bottom'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_left',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-left'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_top',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-top'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_right',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-right'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_bottom',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-bottom'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_left',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-left'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Padding/Margin for MOBILE', 'catanis-core'),
			'param_name' 		=> 'mobile_custom_padding_margin',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom padding and margin on Mobile.', 'catanis-core' ),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_top',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-top'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_right',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-right'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_bottom',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-bottom'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_left',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-left'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_top',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-top'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_right',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-right'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_bottom',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-bottom'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_left',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-left'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
			
		/* Group: Extras */
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Disable row', 'catanis-core' ),
			'param_name' 		=> 'disable_element',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'If checked the row won\'t be visible on the public side of your website. You can switch it back any time.', 'catanis-core' ),
			'group'				=> esc_attr__('Extras', 'catanis-core')
		),
		catanis_vc_extra_id(true),
		catanis_vc_extra_class(true),
		
		/* Group: Animation */
		catanis_vc_use_animation(),
		catanis_vc_animation_type(),
		catanis_vc_animation_duration(),
		catanis_vc_animation_delay(),
	)
) );

/*=== VISUAL COLUMN ==========================*/
/*============================================*/
vc_map( array(
	'name'		 		=> esc_attr__('Column', 'catanis-core'),
	'base' 				=> 'vc_column',
	'icon' 				=> CATANIS_CORE_URL.'/images/vcicons/column.png',
	'category' 			=> esc_html__( 'Catanis Elements', 'catanis-core'),
	'js_view' 			=> 'VcColumnView',
	'content_element' 	=> false,	/*hide*/
	'is_container' 		=> true,
	'show_settings_on_create' => false,
	'description' 		=> esc_html__( 'Place content elements inside the inner row.', 'catanis-core'),
	'params' 			=> array(
		
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__( 'Alignment', 'catanis-core' ),
			'param_name' 		=> 'alignment',
			'value' 			=> array(
				esc_html__( 'Left', 'catanis-core' ) 		=> 'text-left',
				esc_html__( 'Right', 'catanis-core' ) 		=> 'text-right',
				esc_html__( 'Center', 'catanis-core' ) 		=> 'text-center',
				esc_html__( 'Justify', 'catanis-core' ) 	=> 'text-justify'
			),
			'std' 				=> 'Left',
			'description' 		=> esc_html__( 'Select tabs section title alignment.', 'catanis-core' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column'
		),
		array(
			'type' 				=> 'ca_vc_number',
			'heading' 			=> esc_html__( 'Min height', 'catanis-core' ),
			'param_name' 		=> 'min_height',
			'min' 				=> 0,
			'max' 				=> 10000,
			'step' 				=> 50,
			'suffix' 			=> 'px',
			'description' 		=> esc_html__('Define min height (Optional).', 'catanis-core'),
			'edit_field_class' 	=> 'vc_col-sm-6 pt0 vc_column'
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_html__( 'Column Link' ),
			'param_name' 		=> 'column_link',
			'description' 		=> esc_html__( 'If you wish for this column to link somewhere, enter the URL in here' )
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Column Pull Right', 'catanis-core' ),
			'param_name' 		=> 'pull_right',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'If checked to set float right for column.', 'catanis-core' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Clear Both', 'catanis-core' ),
			'param_name' 		=> 'clear_both',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'If checked to mark as clear both.', 'catanis-core' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column'
		),
		
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Extras Setting', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear'
		),
		catanis_vc_extra_id(),
		catanis_vc_extra_class(),
		
		/* Group: Background */
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Type', 'catanis-core'),
			'param_name' 		=> 'bg_type',
			'std' 				=> 'no_bg',
			'value' 			=> array(
				'Default'			=> 'no_bg',
				'Color'				=> 'color',
				'Image / Parallax'	=> 'image'
			),
			'description' 		=> esc_html__('Note: Youtube Video does not work on mobile', 'catanis-core'),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Background Color', 'catanis-core' ),
			'param_name' 		=> 'bg_color',
			'value' 			=> '#FFFFFF',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('color')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Background Image', 'catanis-core'),
			'param_name' 		=> 'bg_image', 
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Size', 'catanis-core'),
			'param_name' 		=> 'bg_image_size',
			'std' 				=> 'cover',
			'value' 			=> array(
				__('Cover - Image to be as large as possible', 'catanis-core')						=> 'cover',
				__('Contain - Image will try to fit inside the container area', 'catanis-core')		=> 'contain',
				__('Initial - If the height content >= 650, recommend using this option.', 'catanis-core')	=> 'initial'
			),
			'description' 		=> esc_html__('Options to control size of the background image.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Position', 'catanis-core'),
			'param_name' 		=> 'bg_image_position',
			'std' 				=> 'center center',
			'value' 			=> array(
				esc_html__('center top', 'catanis-core')		=> 'center top',
				esc_html__('center center', 'catanis-core')		=> 'center center',
				esc_html__('center bottom', 'catanis-core')		=> 'center bottom',
				esc_html__('left top', 'catanis-core')			=> 'left top',
				esc_html__('left center', 'catanis-core')		=> 'left center',
				esc_html__('left bottom', 'catanis-core')		=> 'left bottom',
				esc_html__('right top', 'catanis-core')			=> 'right top',
				esc_html__('right center', 'catanis-core')		=> 'right center',
				esc_html__('right bottom', 'catanis-core')		=> 'right bottom',
			),
			'description' 		=> esc_html__('Options to control position of the background image.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Repeat', 'catanis-core'),
			'param_name' 		=> 'bg_image_repeat',
			'value' 			=> array(
				esc_html__('No Repeat', 'catanis-core')									=> 'no-repeat',
				esc_html__('Repeat only Horizontally', 'catanis-core')					=> 'repeat-x',
				esc_html__('Repeat only Vertically', 'catanis-core')					=> 'repeat-y',
				esc_html__('Repeat both Vertically and Horizontally', 'catanis-core')	=> 'repeat'
			),
			'description' 		=> esc_html__('Defines the directions in which a background image will be repeated.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__('Show Overlay Div', 'catanis-core'),
			'param_name' 		=> 'show_overlay',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'description' 		=> esc_attr__( 'Checked it to show overlay in row.', 'catanis-core' ),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Overlay Opacity', 'catanis-core'),
			'param_name' 		=> 'overlay_opacity',
			'value' 			=> $catanis_vc_opacity,
			'dependency' 		=> array( 'element' => 'show_overlay', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Overlay Color', 'catanis-core' ),
			'param_name' 		=> 'overlay_color',
			'dependency' 		=> array( 'element' => 'show_overlay', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__( 'Use Parallax', 'catanis-core' ),
			'param_name' 		=> 'use_parallax',
			'value' 			=> array( esc_attr__( 'Yes', 'catanis-core' ) => 'yes' ),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'description' 		=> __( 'Checked it to use background image with parallax.', 'catanis-core' ),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_html__('Parallax Speed', 'catanis-core'),
			'param_name' 		=> 'parallax_speed',
			'value' 			=> '0.1',
			'dependency' 		=> array('element' => 'use_parallax', 'value' => array('yes')),
			/*'edit_field_class' 	=> 'hide',*/
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Padding Setting (Can use \'%\' or \'px\' Eg. 5%, 10px,..)', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper mt0 vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_top',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_right',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_bottom',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_left',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
			
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Margin Setting (Can use \'%\' or \'px\' Eg. 5%, 10px,..)', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_top',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_right',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> __('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_bottom',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_left',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Border Setting', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Column Border', 'catanis-core' ),
			'param_name' 		=> 'column_border',
			'value' 			=> array(
				esc_attr__('No Border', 'catanis-core') 			=> '',
				esc_attr__('Border Top', 'catanis-core') 			=> 'border-top',
				esc_attr__('Border Bottom', 'catanis-core') 		=> 'border-bottom',
				esc_attr__('Border Left', 'catanis-core') 			=> 'border-left',
				esc_attr__('Border Right', 'catanis-core') 			=> 'border-right',
				esc_attr__('Border All', 'catanis-core') 			=> 'border-all',
				esc_attr__('Border Top and Bottom', 'catanis-core') => 'topbottom',
				esc_attr__('Border Left and Right', 'catanis-core') => 'leftright',
				esc_attr__('Border Top and Left', 'catanis-core') 	=> 'topleft',
				esc_attr__('Border Top and Right', 'catanis-core') 	=> 'topright'				
			),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Border Color', 'catanis-core' ),
			'param_name' 		=> 'border_color',
			'dependency' 	=> array('element' => 'column_border', 'not_empty' => true),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'ca_vc_number',
			'heading' 			=> esc_html__( 'Border Size', 'catanis-core' ),
			'param_name' 		=> 'border_size',
			'value' 			=> 0,
			'min' 				=> 0,
			'max' 				=> 20,
			'suffix' 			=> 'px',
			'description' 		=> esc_html__('Input a border size (Max: 20).', 'catanis-core'),
			'dependency' 	=> array('element' => 'column_border', 'not_empty' => true),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__( 'Border Type', 'catanis-core' ),
			'param_name' 		=> 'border_type',
			'value' 			=> array(
				esc_attr__('no border', 'catanis-core') => '',
				esc_attr__('Dotted', 'catanis-core') 	=> 'dotted',
				esc_attr__('Dashed', 'catanis-core') 	=> 'dashed',
				esc_attr__('Solid', 'catanis-core') 	=> 'solid',
				esc_attr__('Double', 'catanis-core') 	=> 'double'
			),
			'description' 		=> esc_html__('Choose a border type.', 'catanis-core'),
			'dependency' 	=> array('element' => 'column_border', 'not_empty' => true),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Setting Padding/Margin for IPAD and MOBILE', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Padding/Margin for IPAD', 'catanis-core'),
			'param_name' 		=> 'ipad_custom_padding_margin',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom padding and margin on Ipad.', 'catanis-core' ),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_top',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-top'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_right',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-right'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_bottom',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-bottom'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_left',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-left'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_top',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-top'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_right',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-right'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_bottom',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-bottom'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_left',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-left'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
			
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Padding/Margin for MOBILE', 'catanis-core'),
			'param_name' 		=> 'mobile_custom_padding_margin',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom padding and margin on Mobile.', 'catanis-core' ),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_top',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-top'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_right',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-right'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_bottom',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-bottom'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_left',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-left'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_top',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-top'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_right',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-right'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_bottom',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-bottom'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_left',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-left'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
			
		/* Group: Responsive Options */
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> __( 'Width', 'catanis-core' ),
			'param_name' 		=> 'width',
			'value' 			=> array(
				__( '1 column - 1/12', 'catanis-core' ) 	=> '1/12',
				__( '2 columns - 1/6', 'catanis-core' ) 	=> '1/6',
				__( '3 columns - 1/4', 'catanis-core' ) 	=> '1/4',
				__( '4 columns - 1/3', 'catanis-core' ) 	=> '1/3',
				__( '5 columns - 5/12', 'catanis-core' ) 	=> '5/12',
				__( '6 columns - 1/2', 'catanis-core' ) 	=> '1/2',
				__( '7 columns - 7/12', 'catanis-core' ) 	=> '7/12',
				__( '8 columns - 2/3', 'catanis-core' ) 	=> '2/3',
				__( '9 columns - 3/4', 'catanis-core' ) 	=> '3/4',
				__( '10 columns - 5/6', 'catanis-core' ) 	=> '5/6',
				__( '11 columns - 11/12', 'catanis-core' ) 	=> '11/12',
				__( '12 columns - 1/1', 'catanis-core' ) 	=> '1/1',
			),
			'std' 				=> '1/1',
			'description' 		=> __( 'Select column width.', 'catanis-core' ),
			'group' 			=> __( 'Responsive Options', 'catanis-core' )
		),
		array(
			'type' 				=> 'column_offset',
			'heading' 			=> __( 'Responsiveness', 'catanis-core' ),
			'param_name' 		=> 'offset',
			'group' 			=> __( 'Responsive Options', 'catanis-core' ),
			'description' 		=> __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'catanis-core' ),
		),
		
		/* Group: Animation */
		catanis_vc_use_animation(),
		catanis_vc_animation_type(),
		catanis_vc_animation_duration(),
		catanis_vc_animation_delay(),
	)
) );

/*=== VISUAL COLUMN INNER ====================*/
/*============================================*/
 vc_map( array(
	'name'		 	=> esc_attr__('Column', 'catanis-core'),
	'base' 			=> 'vc_column_inner',
	'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/column.png',
	'category' 		=> esc_html__( 'Catanis Elements', 'catanis-core'),
	'js_view' 		=> 'VcColumnView',
	'is_container' 	=> true,
 	'content_element' => false,
 	'allowed_container_element' => false,
	'description' 	=> esc_html__( 'Place content elements inside the inner row.', 'catanis-core'),
	'params' 		=> array(
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_html__( 'Column Link' ),
			'param_name' 		=> 'column_link',
			'description' 		=> esc_html__( 'If you wish for this column to link somewhere, enter the URL in here' )
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__( 'Alignment', 'catanis-core' ),
			'param_name' 		=> 'alignment',
			'value' 			=> array(
				esc_html__( 'Left', 'catanis-core' ) 		=> 'text-left',
				esc_html__( 'Right', 'catanis-core' ) 		=> 'text-right',
				esc_html__( 'Center', 'catanis-core' ) 		=> 'text-center',
				esc_html__( 'Justify', 'catanis-core' ) 	=> 'text-justify'
			),
			'std' 				=> 'Left',
			'description' 		=> esc_html__( 'Select tabs section title alignment.', 'catanis-core' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column'
		),
		array(
			'type' 				=> 'ca_vc_number',
			'heading' 			=> esc_html__( 'Min height', 'catanis-core' ),
			'param_name' 		=> 'min_height',
			'min' 				=> 0,
			'max' 				=> 10000,
			'step' 				=> 50,
			'suffix' 			=> 'px',
			'description' 		=> esc_html__('Define min height (Optional).', 'catanis-core'),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Column Pull Right', 'catanis-core' ),
			'param_name' 		=> 'pull_right',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'If checked to set float right.', 'catanis-core' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Clear Both', 'catanis-core' ),
			'param_name' 		=> 'clear_both',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'If checked to mark as clear both.', 'catanis-core' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column'
		),
		
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Extras Setting', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear'
		),
		catanis_vc_extra_id(),
		catanis_vc_extra_class(),
		
		/* Group Design Options */
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Type', 'catanis-core'),
			'param_name' 		=> 'bg_type',
			'std' 				=> 'no_bg',
			'value' 			=> array(
				'Default'			=> 'no_bg',
				'Color'				=> 'color',
				'Image / Parallax'	=> 'image'
			),
			'description' 		=> esc_html__('Note: Youtube Video does not work on mobile', 'catanis-core'),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Background Color', 'catanis-core' ),
			'param_name' 		=> 'bg_color',
			'value' 			=> '#FFFFFF',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('color')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> esc_html__('Background Image', 'catanis-core'),
			'param_name' 		=> 'bg_image', 
			'value' 			=> '',
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Size', 'catanis-core'),
			'param_name' 		=> 'bg_image_size',
			'std' 				=> 'cover',
			'value' 			=> array(
				__('Cover - Image to be as large as possible', 'catanis-core')						=> 'cover',
				__('Contain - Image will try to fit inside the container area', 'catanis-core')		=> 'contain',
				__('Initial - If the height content >= 650, recommend using this option.', 'catanis-core')	=> 'initial'
			),
			'description' 		=> esc_html__('Options to control size of the background image.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Position', 'catanis-core'),
			'param_name' 		=> 'bg_image_position',
			'std' 				=> 'center center',
			'value' 			=> array(
				esc_html__('center top', 'catanis-core')		=> 'center top',
				esc_html__('center center', 'catanis-core')		=> 'center center',
				esc_html__('center bottom', 'catanis-core')		=> 'center bottom',
				esc_html__('left top', 'catanis-core')			=> 'left top',
				esc_html__('left center', 'catanis-core')		=> 'left center',
				esc_html__('left bottom', 'catanis-core')		=> 'left bottom',
				esc_html__('right top', 'catanis-core')			=> 'right top',
				esc_html__('right center', 'catanis-core')		=> 'right center',
				esc_html__('right bottom', 'catanis-core')		=> 'right bottom',
			),
			'description' 		=> esc_html__('Options to control position of the background image.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__('Background Image Repeat', 'catanis-core'),
			'param_name' 		=> 'bg_image_repeat',
			'value' 			=> array(
				esc_html__('No Repeat', 'catanis-core')								=> 'no-repeat',
				esc_html__('Repeat Horizontally', 'catanis-core')					=> 'repeat-x',
				esc_html__('Repeat Vertically', 'catanis-core')						=> 'repeat-y',
				esc_html__('Repeat Vertically and Horizontally', 'catanis-core')	=> 'repeat'
			),
			'description' 		=> esc_html__('Defines the directions in which a background image will be repeated.', 'catanis-core'),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__('Show Overlay Div', 'catanis-core'),
			'param_name' 		=> 'show_overlay',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'description' 		=> esc_attr__( 'Checked it to show overlay in row.', 'catanis-core' ),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Overlay Opacity', 'catanis-core'),
			'param_name' 		=> 'overlay_opacity',
			'value' 			=> $catanis_vc_opacity,
			'dependency' 		=> array( 'element' => 'show_overlay', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Overlay Color', 'catanis-core' ),
			'param_name' 		=> 'overlay_color',
			'dependency' 		=> array( 'element' => 'show_overlay', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear',
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__( 'Use Parallax', 'catanis-core' ),
			'param_name' 		=> 'use_parallax',
			'value' 			=> array( esc_attr__( 'Yes', 'catanis-core' ) => 'yes' ),
			'dependency' 		=> array('element' => 'bg_type', 'value' => array('image')),
			'description' 		=> __( 'Checked it to use background image with parallax.', 'catanis-core' ),
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_html__('Parallax Speed', 'catanis-core'),
			'param_name' 		=> 'parallax_speed',
			'value' 			=> '0.1',
			'dependency' 		=> array('element' => 'use_parallax', 'value' => array('yes')),
			/*'edit_field_class' 	=> 'hide',*/
			'group'				=> esc_attr__('Background', 'catanis-core')
		),
		
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Padding Setting (Can use \'%\' or \'px\' Eg. 5%, 10px,..)', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper mt0 vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_top',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_right',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_bottom',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'desktop_padding_left',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Margin Setting (Can use \'%\' or \'px\' Eg. 5%, 10px,..)', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_top',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_right',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> __('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_bottom',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_left',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),

 		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Border Setting', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Column Border', 'catanis-core' ),
			'param_name' 		=> 'column_border',
			'value' 			=> array(
				esc_attr__('No Border', 'catanis-core') 			=> '',
				esc_attr__('Border Top', 'catanis-core') 			=> 'border-top',
				esc_attr__('Border Bottom', 'catanis-core') 		=> 'border-bottom',
				esc_attr__('Border Left', 'catanis-core') 			=> 'border-left',
				esc_attr__('Border Right', 'catanis-core') 			=> 'border-right',
				esc_attr__('Border All', 'catanis-core') 			=> 'border-all',
				esc_attr__('Border Top and Bottom', 'catanis-core') 	=> 'topbottom',
				esc_attr__('Border Left and Right', 'catanis-core') 	=> 'leftright',
				esc_attr__('Border Top and Left', 'catanis-core') 	=> 'topleft',
				esc_attr__('Border Top and Right', 'catanis-core') 	=> 'topright'				
			),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Border Color', 'catanis-core' ),
			'param_name' 		=> 'border_color',
			'dependency' 	=> array('element' => 'column_border', 'not_empty' => true),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'ca_vc_number',
			'heading' 			=> esc_html__( 'Border Size', 'catanis-core' ),
			'param_name' 		=> 'border_size',
			'value' 			=> 0,
			'min' 				=> 0,
			'max' 				=> 20,
			'suffix' 			=> 'px',
			'description' 		=> esc_html__('Input a border size (Max: 20).', 'catanis-core'),
			'dependency' 	=> array('element' => 'column_border', 'not_empty' => true),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__( 'Border Type', 'catanis-core' ),
			'param_name' 		=> 'border_type',
			'value' 			=> array(
				esc_attr__('no border', 'catanis-core') => '',
				esc_attr__('Dotted', 'catanis-core') 	=> 'dotted',
				esc_attr__('Dashed', 'catanis-core') 	=> 'dashed',
				esc_attr__('Solid', 'catanis-core') 	=> 'solid',
				esc_attr__('Double', 'catanis-core') 	=> 'double'
			),
			'description' 		=> esc_html__('Choose a border type.', 'catanis-core'),
			'dependency' 	=> array('element' => 'column_border', 'not_empty' => true),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
			
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Setting Padding/Margin for IPAD and MOBILE', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Padding/Margin for IPAD', 'catanis-core'),
			'param_name' 		=> 'ipad_custom_padding_margin',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom padding and margin on Ipad.', 'catanis-core' ),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_top',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-top'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_right',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-right'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_bottom',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-bottom'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'ipad_padding_left',
			'value' 			=> catanis_vc_padding_margin('ipad-padding-left'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_top',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-top'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_right',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-right'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_bottom',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-bottom'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_left',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-left'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
			
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Padding/Margin for MOBILE', 'catanis-core'),
			'param_name' 		=> 'mobile_custom_padding_margin',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom padding and margin on Mobile.', 'catanis-core' ),
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Top', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_top',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-top'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Right', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_right',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-right'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Bottom', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_bottom',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-bottom'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Padding Left', 'catanis-core' ),
			'param_name' 		=> 'mobile_padding_left',
			'value' 			=> catanis_vc_padding_margin('mobile-padding-left'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_top',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-top'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_right',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-right'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_bottom',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-bottom'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_left',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-left'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group'				=> esc_attr__('Design Options', 'catanis-core')
		),
			
		/* Group Responsive Options */
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> __( 'Width', 'catanis-core' ),
			'param_name' 		=> 'width',
			'value' 			=> array(
				__( '1 column - 1/12', 'catanis-core' ) 	=> '1/12',
				__( '2 columns - 1/6', 'catanis-core' ) 	=> '1/6',
				__( '3 columns - 1/4', 'catanis-core' ) 	=> '1/4',
				__( '4 columns - 1/3', 'catanis-core' ) 	=> '1/3',
				__( '5 columns - 5/12', 'catanis-core' ) 	=> '5/12',
				__( '6 columns - 1/2', 'catanis-core' ) 	=> '1/2',
				__( '7 columns - 7/12', 'catanis-core' ) 	=> '7/12',
				__( '8 columns - 2/3', 'catanis-core' )		=> '2/3',
				__( '9 columns - 3/4', 'catanis-core' ) 	=> '3/4',
				__( '10 columns - 5/6', 'catanis-core' ) 	=> '5/6',
				__( '11 columns - 11/12', 'catanis-core' ) 	=> '11/12',
				__( '12 columns - 1/1', 'catanis-core' ) 	=> '1/1',
			),
			'std' 				=> '1/1',
			'description' 		=> __( 'Select column width.', 'catanis-core' ),
			'group' 			=> __( 'Responsive Options', 'catanis-core' )
		),
		array(
			'type' 				=> 'column_offset',
			'heading' 			=> __( 'Responsiveness', 'catanis-core' ),
			'param_name' 		=> 'offset',
			'group' 			=> __( 'Responsive Options', 'catanis-core' ),
			'description' 		=> __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'catanis-core' ),
		),
		
		/* Group Animation */
		catanis_vc_use_animation(),
		catanis_vc_animation_type(),
		catanis_vc_animation_duration(),
		catanis_vc_animation_delay(),
		
	)
) );


/*=== IMAGE FULLWIDTH SLIDER =================*/
/*============================================*/
vc_map( array(
	'name' 			=> __( 'Image Slider FullWidth' , 'catanis-core' ), 
	'base' 			=> 'cata_slider_fwidth',
	'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/image-slider-fullwidth.png',
	'category' 		=> esc_html__( 'Catanis Elements', 'catanis-core'),
	'as_parent' 	=> array('only' => 'cata_slider_item'), 	/* Use only|except attributes to limit child shortcodes (separate multiple values with comma) */
	'js_view' 		=> 'VcColumnView',
	'description' 	=> __( 'Image slider fullwidth Horizontal/Vertical', 'catanis-core' ), 
	'params' 		=> array( 
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> __('Slider Style', 'catanis-core'),
			'param_name' 		=> 'slider_style',
			'admin_label' 		=> true,
			'value' 			=> array(
				esc_html__( 'Slider Horizontal', 'catanis-core') 	=> 'horizontal',
				esc_html__( 'Slider Vertical', 'catanis-core') 		=> 'vertical'
			),
			'std' 				=> 'vertical'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Show Pagination Dots', 'catanis-core' ),
			'param_name' 		=> 'show_dots',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'If checked, the pagination will be displayed in slider.', 'catanis-core' )
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> __('Pagination Style', 'catanis-core'),
			'param_name' 		=> 'dots_style',
			'admin_label' 		=> true,
			'value' 			=> array(
				esc_html__( 'Style Rounded', 'catanis-core') 		=> 'dots-rounded',
				esc_html__( 'Style Square', 'catanis-core') 		=> 'dots-square',
				esc_html__( 'Style Line', 'catanis-core') 			=> 'dots-line',
				esc_html__( 'Catanis Style Height', 'catanis-core') => 'dots-catanis-height',
				esc_html__( 'Catanis Style Width', 'catanis-core') 	=> 'dots-catanis-width'
			),
			'std' 				=> 'dots-line',
            'dependency' 		=> array( 'element' => 'show_dots', 'value' => array('yes') )
        ),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> __('Pagination Color', 'catanis-core'),
			'param_name' 		=> 'dots_color',
			'value' 			=> array(
				__('Dark Style', 'catanis-core') 	=> 'dark-dots',
				__('Light Style', 'catanis-core') 	=> 'light-dots'
			),
			'std' 				=> 'dark-dots',
			'dependency' => array( 'element' => 'show_dots', 'value' => array('yes') ),
        ),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Show Navigation', 'catanis-core' ),
			'param_name' 		=> 'show_navigation',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'If checked, the navigation will be displayed in slider.', 'catanis-core' )
		),
		array(
              'type' 			=> 'dropdown',
              'heading' 		=> __('Navigation Style', 'catanis-core'),
              'param_name' 		=> 'navigation_style',
              'admin_label' 	=> true,
              'value' 			=> array(
				__('Next/Prev Black Arrow', 'catanis-core') => 'dark-navigation',
				__('Next/Prev White Arrow', 'catanis-core') => 'light-navigation'
			),
			'std' 				=> 'dark-navigation',
			'dependency' => array( 'element' => 'show_navigation', 'value' => array('yes') ),
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Draggable', 'catanis-core' ),
			'param_name' 		=> 'draggable',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'admin_label' 		=> true,
			'description' 		=> __( 'Enable mouse dragging.', 'catanis-core' ),
			'dependency' 		=> array( 'element' => 'slider_style', 'value' => 'horizontal' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> __('Cursor Color', 'catanis-core'),
			'param_name' 		=> 'cursor_color',
			'value' 			=> array(
				__('None', 'catanis-core') 				=> '',
				__('Dark Cursor', 'catanis-core') 		=> 'dark-cursor',
				__('Light Cursor', 'catanis-core') 		=> 'light-cursor'
			),
			'std' 				=> 'default-cursor',
			'description' 		=> __( 'Choose cursor color.', 'catanis-core' ),
			'dependency' 		=> array( 'element' => 'draggable', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> __('Transition Style', 'catanis-core'),
			'param_name' 		=> 'transition_style',
			'admin_label' 		=> true,
			'value' 			=> array(
				__('Slide Style', 'catanis-core') 		=> 'slide', 
				__('Fade Style', 'catanis-core') 		=> 'fade'
			),
			'dependency' 		=> array( 'element' => 'slider_style', 'value' => 'horizontal' ),
			'edit_field_class' 	=> 'vc_col-sm-8 vc_column'
		), 
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Autoplay', 'catanis-core' ),
			'param_name' 		=> 'autoplay',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'admin_label' 		=> true,
			'description' 		=> __( 'Checked it to autoplay slider.', 'catanis-core' ),
			'edit_field_class' 	=> 'vc_col-sm-5 vc_column'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Stop On Hover', 'catanis-core' ),
			'param_name' 		=> 'stop_on_hover',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Checked it to stop autoplay when hover on slider.', 'catanis-core' ),
			'dependency' 		=> array( 'element' => 'autoplay', 'value' => 'yes' ),
			'edit_field_class' 	=> 'vc_col-sm-7 vc_column'
		),
		array(
			'type'             	=> 'ca_vc_slider',
			'heading' 			=> __('Autoplay Speed', 'catanis-core'),
			'param_name' 		=> 'autoplay_speed',
			'value'            	=> '3000',
			'defaultSetting'   	=> array(
				'min'    => '400',
				'max'    => '10000',
				'prefix' => 'ms',
				'step'   => '200'
			),
			'description' 		=> __('Select value for autoplay speed (1ms = 100)', 'catanis-core'),
			'dependency'  		=> array( 'element' => 'autoplay', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column'
		),
		catanis_vc_extra_id(true),
		catanis_vc_extra_class(true)
	)
));


vc_map( array(
	'name' 			=> __('Slide Item', 'catanis-core'),
	'base' 			=> 'cata_slider_item',
	'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/image-slider-item.png',
	'as_child' 		=> array('only' => 'cata_slider_fwidth'), 	/* Use only|except attributes to limit children shortcodes (separate multiple values with comma) */
	'description' 	=> __( 'A slide for the image slider', 'catanis-core' ),
	'params' 		=> array(
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> __('Slide Image', 'catanis-core'),
			'param_name' 		=> 'image',
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> esc_attr__('Show Overlay Div', 'catanis-core'),
			'param_name' 		=> 'show_overlay',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> esc_attr__( 'Checked it to show overlay in image.', 'catanis-core' ),
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Background Overlay Opacity', 'catanis-core'),
			'param_name' 		=> 'overlay_opacity',
			'value' 			=> $catanis_vc_opacity,
			'dependency' 		=> array( 'element' => 'show_overlay', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear'
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__( 'Overlay Color', 'catanis-core' ),
			'param_name' 		=> 'overlay_color',
			'dependency' 		=> array( 'element' => 'show_overlay', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column clear'
		),
		
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__( 'Position Text', 'startup' ),
			'param_name' 		=> 'position_text',
			'admin_label' 		=> true,
			'std' 				=> 'center-center',
			'value' 			=> array(
				__('Center Center', 'catanis-core') 	=> 'center-center',
				__('Center Left', 'catanis-core') 		=> 'center-left',
				__('Center Right', 'catanis-core') 		=> 'center-right',
			),
			'description' 		=> esc_html__( 'Select position to display title and subtitle.', 'startup' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Animation Text', 'startup'),
			'param_name' 		=> 'animation_text',
			'admin_label' 		=> true,
			'value' 			=> array(
				__('Select Animation', 'catanis-core') 	=> '',
				'bounceIn' 			=> 'cata-bounceIn', 
				'bounceInUp' 		=> 'cata-bounceInUp',
				'bounceInDown' 		=> 'cata-bounceInDown',
				'bounceInLeft' 		=> 'cata-bounceInLeft',
				'bounceInRight' 	=> 'cata-bounceInRight', 
				'fadeInLeft' 		=> 'cata-fadeInLeft',
				'fadeInRight' 		=> 'cata-fadeInRight',
				'flipInY' 			=> 'cata-flipInY',
				'flipInX' 			=> 'cata-flipInX'
			),
			'std' 				=> 'cata-bounceInUp',
			'description' 		=> esc_html__( 'Select animation for title and subtitle.', 'startup' ),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> __('Number buttons display', 'catanis-core'),
			'param_name' 		=> 'num_button',
			'admin_label' 		=> true,
			'value' 			=> array(
				__('No Button', 'catanis-core') 	=> '',
				__('One Button', 'catanis-core') 	=> 'one',
				__('Two Buttons', 'catanis-core') 	=> 'two',
			),
			'description'	 	=> __('Hide/show buttons in slide (Notes: It will only apply if your selected image slider style contains the button)', 'catanis-core'),
			'edit_field_class' 	=> 'vc_col-sm-6 vc_column',
		),
		array(
			'type'       	 	=> 'vc_link',
			'heading'     		=> __('Button 1', 'catanis-core' ),
			'param_name'  		=> 'first_button',
			'dependency'  		=> array( 'element' => 'num_button', 'value' => array('one','two') ),
		),
		array(
			'type'        		=> 'vc_link',
			'heading'     		=> __('Button 2', 'catanis-core' ),
			'param_name'  		=> 'second_button',
			'dependency'  		=> array( 'element' => 'num_button', 'value' => array('two') ),
		),
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Slider ID and Class', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear'
		),
		catanis_vc_extra_id(false),
		catanis_vc_extra_class(false),
		
		/* Group: Title Settings */
		array(
			'type' 				=> 'textfield',
			'heading' 			=> __('Title (large title)', 'catanis-core'),
			'param_name' 		=> 'title',
			'description' 		=> esc_html__( 'Note: Add character "||" to go to new line.', 'startup' ),
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__('Color', 'catanis-core'),
			'param_name' 		=> 'title_color',
			'value' 			=> '#FFFFFF',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Font Size for Desktop', 'startup'),
			'param_name' 		=> 'fontsize_title',
			'value' 			=> catanis_vc_fontsize_large(),
			'std' 				=> 'fontsize-100px',
			'edit_field_class' 	=> 'vc_col-sm-4 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Font Size for Ipad', 'startup'),
			'param_name' 		=> 'ipad_fontsize_title',
			'value' 			=> catanis_vc_fontsize_large('ipad'),
			'std' 				=> 'ipad-fontsize-75px',
			'edit_field_class' 	=> 'vc_col-sm-4 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Font Size for Mobile', 'startup'),
			'param_name' 		=> 'mobile_fontsize_title',
			'value' 			=> catanis_vc_fontsize_large('mobile'),
			'std' 				=> 'mobile-fontsize-50px',
			'edit_field_class' 	=> 'vc_col-sm-4 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Margin Setting (Can use \'%\' or \'px\' Eg. 5%, 10px,..)', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_top_title',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_right_title',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> __('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_bottom_title',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_left_title',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Setting Margin for IPAD and MOBILE', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Margin for IPAD', 'catanis-core'),
			'param_name' 		=> 'ipad_custom_margin_title',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom padding and margin on Ipad.', 'catanis-core' ),
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_top_title',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-top'),
			'dependency' 		=> array( 'element' => 'ipad_custom_margin_title', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_right_title',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-right'),
			'dependency' 		=> array( 'element' => 'ipad_custom_margin_title', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_bottom_title',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-bottom'),
			'dependency' 		=> array( 'element' => 'ipad_custom_margin_title', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_left_title',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-left'),
			'dependency' 		=> array( 'element' => 'ipad_custom_margin_title', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
			
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Margin for MOBILE', 'catanis-core'),
			'param_name' 		=> 'mobile_custom_margin_title',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom margin on Mobile.', 'catanis-core' ),
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_top_title',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-top'),
			'dependency' 		=> array( 'element' => 'mobile_custom_margin_title', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_right_title',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-right'),
			'dependency' 		=> array( 'element' => 'mobile_custom_margin_title', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_bottom_title',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-bottom'),
			'dependency' 		=> array( 'element' => 'mobile_custom_margin_title', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_left_title',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-left'),
			'dependency' 		=> array( 'element' => 'mobile_custom_margin_title', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'Title Settings'
		),
 		
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Setting Custom Google Font', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Use google font family?', 'startup' ),
			'param_name' 		=> 'use_google_fonts_title',
			'value' 			=> array( __( 'Yes', 'startup' ) => 'yes' ),
			'description' 		=> __( 'Use custom Google font family.', 'startup' ),
			'group' 			=> 'Title Settings'
		),
		array(
			'type' 				=> 'google_fonts',
			'param_name' 		=> 'google_fonts_title',
			'value' 			=> 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
			'settings' 			=> array(
				'fields' 		=> array(
					'font_family_description' => __( 'Select font family.', 'startup' ),
					'font_style_description' => __( 'Select font styling.', 'startup' ),
				),
			),
			'dependency' 		=> array('element' => 'use_google_fonts_title','value' => 'yes'),
			'group' 			=> 'Title Settings'
		),
		
		/* Group: SubTitle Settings */
		array(
			'type' 				=> 'textfield',
			'heading' 			=> __('SubTitle (small title)', 'catanis-core'),
			'param_name' 		=> 'subtitle',
			'description' 		=> esc_html__( 'Note: Add character "||" to go to new line.', 'startup' ),
			'edit_field_class' 	=> 'vc_col-sm-8 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Subtitle above Title?', 'catanis-core' ),
			'param_name' 		=> 'subtitle_above',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'edit_field_class' 	=> 'vc_col-sm-4 mt0 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'colorpicker',
			'heading' 			=> esc_attr__('Color', 'catanis-core'),
			'param_name' 		=> 'subtitle_color',
			'value' 			=> '#FFFFFF',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Font Size for Desktop', 'startup'),
			'param_name' 		=> 'fontsize_subtitle',
			'value' 			=> catanis_vc_fontsize_small(),
			'std' 				=> 'fontsize-30px',
			'edit_field_class' 	=> 'vc_col-sm-4 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Font Size for Ipad', 'startup'),
			'param_name' 		=> 'ipad_fontsize_subtitle',
			'value' 			=> catanis_vc_fontsize_small('ipad'),
			'std' 				=> 'ipad-fontsize-20px',
			'edit_field_class' 	=> 'vc_col-sm-4 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Font Size for Mobile', 'startup'),
			'param_name' 		=> 'mobile_fontsize_subtitle',
			'value' 			=> catanis_vc_fontsize_small('mobile'),
			'std' 				=> 'mobile-fontsize-16px',
			'edit_field_class' 	=> 'vc_col-sm-4 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Margin Setting (Can use \'%\' or \'px\' Eg. 5%, 10px,..)', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_top_subtitle',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_right_subtitle',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> __('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_bottom_subtitle',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'textfield',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'desktop_margin_left_subtitle',
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Setting Margin for IPAD and MOBILE', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Margin for IPAD', 'catanis-core'),
			'param_name' 		=> 'ipad_custom_margin_subtitle',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom padding and margin on Ipad.', 'catanis-core' ),
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_top_subtitle',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-top'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin_subtitle', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_right_subtitle',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-right'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin_subtitle', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_bottom_subtitle',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-bottom'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin_subtitle', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'ipad_margin_left_subtitle',
			'value' 			=> catanis_vc_padding_margin('ipad-margin-left'),
			'dependency' 		=> array( 'element' => 'ipad_custom_padding_margin_subtitle', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
			
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __('Margin for MOBILE', 'catanis-core'),
			'param_name' 		=> 'mobile_custom_margin_subtitle',
			'value' 			=> array( __( 'Yes', 'catanis-core' ) => 'yes' ),
			'description' 		=> __( 'Set custom margin on Mobile.', 'catanis-core' ),
			'group' 			=> 'SubTitle Settings' 
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Top', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_top_subtitle',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-top'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin_subtitle', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Right', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_right_subtitle',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-right'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin_subtitle', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Bottom', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_bottom_subtitle',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-bottom'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin_subtitle', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_attr__('Margin Left', 'catanis-core' ),
			'param_name' 		=> 'mobile_margin_left_subtitle',
			'value' 			=> catanis_vc_padding_margin('mobile-margin-left'),
			'dependency' 		=> array( 'element' => 'mobile_custom_padding_margin_subtitle', 'value' => array('yes') ),
			'edit_field_class' 	=> 'vc_col-sm-3 vc_column',
			'group' 			=> 'SubTitle Settings'
		),

		array(
			'type'				=> 'ca_vc_heading',
			'text'				=> esc_attr__('Setting Custom Google Font', 'catanis-core'),
			'param_name'		=> 'main_heading_typograpy',
			'edit_field_class'	=> 'ca-param-heading-wrapper vc_col-sm-12 vc_column clear',
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'checkbox',
			'heading' 			=> __( 'Use google font family?', 'startup' ),
			'param_name' 		=> 'use_google_fonts_subtitle',
			'value' 			=> array( __( 'Yes', 'startup' ) => 'yes' ),
			'description' 		=> __( 'Use custom Google font family.', 'startup' ),
			'group' 			=> 'SubTitle Settings'
		),
		array(
			'type' 				=> 'google_fonts',
			'param_name' 		=> 'google_fonts_subtitle',
			'value' 			=> 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
			'settings' 			=> array(
				'fields' 		=> array(
					'font_family_description' 	=> __( 'Select font family.', 'startup' ),
					'font_style_description' 	=> __( 'Select font styling.', 'startup' )
				)
			),
			'dependency' 		=> array('element' => 'use_google_fonts_subtitle','value' => 'yes'),
			'group' 			=> 'SubTitle Settings'
		)
	)
));

if(class_exists('WPBakeryShortCodesContainer')){ 
  class WPBakeryShortCode_Cata_Slider_Fwidth extends WPBakeryShortCodesContainer { }
}
if(class_exists('WPBakeryShortCode')){
  class WPBakeryShortCode_Cata_Slider_Item extends WPBakeryShortCode { }
}

/*=== INFOBOX CONTACT ========================*/
/*============================================*/
vc_map( array(
	'name'		 		=> esc_attr__('InfoBox Contact', 'catanis-core'),
	'base' 				=> 'cata_infobox_contact',
	'icon' 				=> CATANIS_CORE_URL.'/images/vcicons/infobox-contact.png',
	'category' 			=> esc_html__( 'Catanis Elements', 'catanis-core'),
	'is_container' 		=> true,
	'as_parent' 		=> array('only' => 'cata_heading_title,cata_custom_heading,cata_column_text,cata_contactform,cata_empty_space,vc_column_text,cata_single_image'),
	'js_view' 			=> 'VcColumnView',
	'show_settings_on_create' => false,
	'description' 		=> esc_html__( 'Block to make information box contact.', 'catanis-core'),
	'params' 			=> array(
		array(
			'type' 				=> 'dropdown',
			'heading' 			=> esc_html__( 'Box Width', 'catanis-core' ),
			'param_name' 		=> 'box_width',
			'admin_label' 		=> true,
			'save_always' 		=> true,
			'value' 			=> array(
				'50%' 		=> 'width-50percent',
				'55%' 		=> 'width-55percent',
				'60%' 		=> 'width-60percent',
				'65%' 		=> 'width-65percent',
				'70%' 		=> 'width-70percent',
				'75%' 		=> 'width-75percent',
				'80%' 		=> 'width-80percent',
				'85%' 		=> 'width-85percent',
				'90%' 		=> 'width-90percent',
				'95%' 		=> 'width-95percent',
				'100%' 		=> 'width-100percent'
			),
			'std' 		=> 'width-70percent',
			'description' 		=>  esc_html__( 'Choose a type to show.', 'catanis-core' )
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> __('Image on Top Left.', 'catanis-core'),
			'param_name' 		=> 'image_top_left',
			'admin_label' 		=> true,
			'save_always' 		=> true,
			'description' 		=>  esc_html__( 'Choose a image on the Top Left coner.', 'catanis-core' )
		),
		array(
			'type' 				=> 'attach_image',
			'heading' 			=> __('Image on Bottom Right.', 'catanis-core'),
			'param_name' 		=> 'image_bottom_right',
			'admin_label' 		=> true,
			'save_always' 		=> true,
			'description' 		=>  esc_html__( 'Choose a image on the Bottom Right coner.', 'catanis-core' )
		),
		catanis_vc_extra_id(true),
		catanis_vc_extra_class(true),
			
	)
));

if(class_exists('WPBakeryShortCodesContainer')){
	class WPBakeryShortCode_Cata_Infobox_Contact extends WPBakeryShortCodesContainer { }
}

