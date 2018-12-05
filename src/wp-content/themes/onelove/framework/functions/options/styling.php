<?php
global $catanis;
$catanis_options= array( 
	array(
		'name' 		=> esc_html_x('Styling Settings', 'Theme Options Tab', 'onelove'),
		'type' 		=> 'title',
		'img' 		=> 'icon-sun',
		'class' 	=> 'bg-primary-light'
	),
	array(
		'type' 		=> 'open',
		'subtitles'	=> array(
			array( 'id' => 'content', 'name' 	=> esc_html_x('Content', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'header', 'name' 	=> esc_html_x('Header', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'footer', 'name' 	=> esc_html_x('Footer', 'Theme Options Subtab', 'onelove') )
		)
	),

	/*CONTENT SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'content'
	),
	array(
		'name' 		=> esc_html__( 'Background color', 'onelove'),
		'id' 		=> 'content_background_color',
		'type' 		=> 'color',
		'std' 		=> '#FFFFFF',
		's_desc' 	=> esc_html__( 'Content background color.', 'onelove'),
	),
	array(
		'name' 		=> esc_html__( 'Text color', 'onelove'),
		'id' 		=> 'content_text_color',
		'type' 		=> 'color',
		'std' 		=> '#808080',
		's_desc' 	=> esc_html__( 'Content text color.', 'onelove'),
	),
	array(
		'name' 		=> esc_html__( 'Link style', 'onelove'),
		'id' 		=> 'content_link',
		'type' 		=> 'multioption',
		's_desc' 	=> esc_html__( 'Select your custom content link style.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 	=> esc_html__( 'Regular', 'onelove'),
				'id' 	=> 'regular',
				'type' 	=> 'color',
				'std' 	=> '#1A1A1A'
			),
			array(
				'name' 	=> esc_html__( 'Hover', 'onelove'),
				'id' 	=> 'hover',
				'type' 	=> 'color',
				'std' 	=> '#e49497'
			)
		)
	),
	array(
		'type' 		=> 'documentation',
		'text' 		=> esc_html__( 'Main Color Settings', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Main color', 'onelove'),
		'id' 		=> 'main_color',
		'type' 		=> 'color',
		'std' 		=> '#e49497',
		's_desc' 	=> esc_html__( 'Change this color to alter the accent color globally for your site.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Main Color Lighter', 'onelove'),
		'id' 		=> 'main_color_lighter',
		'type' 		=> 'color',
		'std' 		=> '#fff1f1',
		's_desc' 	=> esc_html__( 'This color will use in some sections/elements, will be used along with Main Color.', 'onelove'),
	),
	array(
		'name' 		=> esc_html__( 'Extra Color #1', 'onelove'),
		'id' 		=> 'extra_color_1',
		'type' 		=> 'color',
		'std' 		=> '#f6653c',
		's_desc' 	=> esc_html__( 'Applicable theme elements will have the option to choose this as a color.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Extra Color #2', 'onelove'),
		'id' 		=> 'extra_color_2',
		'type' 		=> 'color',
		'std' 		=> '#2AC4EA',
		's_desc' 	=> esc_html__( 'Applicable theme elements will have the option to choose this as a color.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Extra Color #3', 'onelove'),
		'id' 		=> 'extra_color_3',
		'type' 		=> 'color',
		'std' 		=> '#333333',
		's_desc' 	=> esc_html__( 'Applicable theme elements will have the option to choose this as a color.', 'onelove')
	),
	array('type' 	=> 'close'),

	/*HEADER SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'header'
	),
	array(
		'name' 		=> esc_html__( 'Header top background color', 'onelove'),
		'id' 		=> 'header_top_bg_color',
		'type' 		=> 'color',
		'std' 		=> '#F8DEDF',
		's_desc' 	=> esc_html__( 'Select a bacground color for header top, depend on header style.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Header Top Color', 'onelove'),
		'id' 		=> 'header_top_color',
		'type' 		=> 'multioption',
		's_desc' 	=> esc_html__( 'Select a color for header top, depend on header style.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 	=> esc_html__( 'For Icon', 'onelove'),
				'id' 	=> 'icon',
				'type' 	=> 'color',
				'std' 	=> '#E49497'
			),
			array(
				'name' 	=> esc_html__( 'For Text', 'onelove'),
				'id' 	=> 'text',
				'type' 	=> 'color',
				'std' 	=> '#9c8888'
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Menu color style', 'onelove'),
		'id' 		=> 'menu_color_style',
		'type' 		=> 'select',
		's_desc'	=> esc_html__( 'Select a color style for main menu.', 'onelove'),
		'options' 	=> array(
			array( 'id' => 'dark', 'name' => 'Dark style' ),
			array( 'id' => 'light', 'name' => 'Light style' )
		),
		'std' 		=> 'dark'
	),
	array(
		'type' 		=> 'documentation',
		'text' 		=> esc_html__( 'Menu "LIGHT" Style Settings', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Background color', 'onelove'),
		'id' 		=> 'mainmenu_light_bg_color',
		'type' 		=> 'color',
		'std' 		=> '#282828',
		's_desc' 	=> esc_html__( 'Select the background color (include header bottom).', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Menu link color', 'onelove'),
		'id' 		=> 'mainmenu_light_link',
		'type' 		=> 'multioption',
		'extClass' 	=> 'color-color',
		's_desc' 	=> esc_html__( 'Select your custom link color.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 	=> esc_html__( 'Regular', 'onelove'),
				'id' 	=> 'regular',
				'type' 	=> 'color',
				'std' 	=> '#FFFFFF'
			),
			array(
				'name' 	=> esc_html__( 'Hover', 'onelove'),
				'id' 	=> 'hover',
				'type' 	=> 'color',
				'std' 	=> '#e49497'
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Border color', 'onelove'),
		'id' 		=> 'mainmenu_light_border_color',
		'type' 		=> 'color',
		'std' 		=> 'rgba(222, 222, 222,0.15)',
		's_desc' 	=> esc_html__( 'Select a color, depend on header style.', 'onelove')
	),
	array(
		'type' 		=> 'documentation',
		'extClass' 	=> 'sub-heading',
		'text' 		=> esc_html__( 'Sub Menu Settings', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Background color', 'onelove'),
		'id' 		=> 'submenu_light_bg_color',
		'type' 		=> 'color',
		'std' 		=> '#FFFFFF',
		's_desc' 	=> esc_html__( 'Select the background color.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Submenus link color', 'onelove'),
		'id' 		=> 'submenu_light_link',
		'type' 		=> 'multioption',
		'extClass' 	=> 'color-color',
		's_desc' 	=> esc_html__( 'Select your custom submenu link color.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 	=> esc_html__( 'Regular', 'onelove'),
				'id' 	=> 'regular',
				'type' 	=> 'color',
				'std' 	=> '#282828'
			),
			array(
				'name' 	=> esc_html__( 'Hover', 'onelove'),
				'id' 	=> 'hover',
				'type' 	=> 'color',
				'std' 	=> '#e49497'
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Submenus border color', 'onelove'),
		'id' 		=> 'submenu_light_border_color',
		'type' 		=> 'color',
		'std' 		=> 'rgba(0,0,0,0.10)',
		's_desc' 	=> esc_html__( 'Select your custom submenu border color.', 'onelove')
	),
	array(
		'type' 		=> 'documentation',
		'extClass' 	=> 'sub-heading',
		'text' 		=> esc_html__( 'Sticky Header Settings', 'onelove'),
	),
	array(
		'name' 		=> esc_html__( 'Sticky background color', 'onelove'),
		'id' 		=> 'mainmenu_light_sticky_color',
		'type' 		=> 'color',
		'std' 		=> '#FFFFFF',
		's_desc' 	=> esc_html__( 'Select the background color for sticky menu.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Menu link color', 'onelove'),
		'id' 		=> 'mainmenu_light_sticky_link_color',
		'type' 		=> 'multioption',
		'extClass' 	=> 'color-color',
		's_desc' 	=> esc_html__( 'Select your custom link color.', 'onelove'),
		'fields' 	=> array(
		array(
				'name' 	=> esc_html__( 'Regular', 'onelove'),
				'id' 	=> 'regular',
				'type' 	=> 'color',
				'std' 	=> '#282828'
			),
			array(
				'name' 	=> esc_html__( 'Hover', 'onelove'),
				'id' 	=> 'hover',
				'type' 	=> 'color',
				'std' 	=> '#e49497'
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Border color', 'onelove'),
		'id' 		=> 'mainmenu_light_sticky_border_color',
		'type' 		=> 'color',
		'std' 		=> 'rgba(255,255,255,0.30)',
		's_desc' 	=> esc_html__( 'Select a color, depend on header style.', 'onelove')
	),
	
	array(
		'type' 		=> 'documentation',
		'text' 		=> esc_html__( 'Menu "DARK" Style Settings', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Background color', 'onelove'),
		'id' 		=> 'mainmenu_dark_bg_color',
		'type' 		=> 'color',
		'std' 		=> '#FFFFFF',
		's_desc' 	=> esc_html__( 'Select the background color (include header bottom).', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Menu link color', 'onelove'),
		'id' 		=> 'mainmenu_dark_link',
		'type' 		=> 'multioption',
		'extClass' 	=> 'color-color',
		's_desc' 	=> esc_html__( 'Select your custom link color.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 	=> esc_html__( 'Regular', 'onelove'),
				'id' 	=> 'regular',
				'type' 	=> 'color',
				'std' 	=> '#282828'
			),
			array(
				'name' 	=> esc_html__( 'Hover', 'onelove'),
				'id' 	=> 'hover',
				'type' 	=> 'color',
				'std' 	=> '#e49497'
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Border color', 'onelove'),
		'id' 		=> 'mainmenu_dark_border_color',
		'type' 		=> 'color',
		'std' 		=> 'rgba(0,0,0,0.10)',
		's_desc' 	=> esc_html__( 'Select a color, depend on header style.', 'onelove')
	),
	array(
		'type' 		=> 'documentation',
		'extClass' 	=> 'sub-heading',
		'text' 		=> esc_html__( 'Sub Menu Settings', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Background color', 'onelove'),
		'id' 		=> 'submenu_dark_bg_color',
		'type' 		=> 'color',
		'std' 		=> '#FFFFFF',
		's_desc' 	=> esc_html__( 'Select the background color.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Submenus link color', 'onelove'),
		'id' 		=> 'submenu_dark_link',
		'type' 		=> 'multioption',
		'extClass' 	=> 'color-color',
		's_desc' 	=> esc_html__( 'Select your custom submenu link color.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 	=> esc_html__( 'Regular', 'onelove'),
				'id' 	=> 'regular',
				'type' 	=> 'color',
				'std' 	=> '#282828'
			),
			array(
				'name' 	=> esc_html__( 'Hover', 'onelove'),
				'id' 	=> 'hover',
				'type' 	=> 'color',
				'std' 	=> '#e49497'
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Submenus border color', 'onelove'),
		'id' 		=> 'submenu_dark_border_color',
		'type' 		=> 'color',
		'std' 		=> 'rgba(0,0,0,0.10)',
		's_desc' 	=> esc_html__( 'Select your custom submenu border color.', 'onelove')
	),
	array(
		'type' 		=> 'documentation',
		'extClass' 	=> 'sub-heading',
		'text' 		=> esc_html__( 'Sticky Header Settings', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Sticky background color', 'onelove'),
		'id' 		=> 'mainmenu_dark_sticky_color',
		'type' 		=> 'color',
		'std' 		=> '#FFFFFF',
		's_desc' 	=> esc_html__( 'Select the background color for sticky menu.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Menu link color', 'onelove'),
		'id' 		=> 'mainmenu_dark_sticky_link_color',
		'type' 		=> 'multioption',
		'extClass' 	=> 'color-color',
		's_desc' 	=> esc_html__( 'Select your custom link color.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 	=> esc_html__( 'Regular', 'onelove'),
				'id' 	=> 'regular',
				'type' 	=> 'color',
				'std' 	=> '#282828'
			),
			array(
				'name' 	=> esc_html__( 'Hover', 'onelove'),
				'id' 	=> 'hover',
				'type' 	=> 'color',
				'std' 	=> '#e49497'
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Border color', 'onelove'),
		'id' 		=> 'mainmenu_dark_sticky_border_color',
		'type' 		=> 'color',
		'std' 		=> 'rgba(255,255,255,0.30)',
		's_desc' 	=> esc_html__( 'Select a color, depend on header style.', 'onelove')
	),
		
	array('type' 	=> 'close'),
		
	/*FOOTER SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'footer'
	),
	array(
		'name' 		=> esc_html__( 'Footer heading color', 'onelove'),
		'id' 		=> 'footer_heading_color',
		'type' 		=> 'color',
		'std' 		=> '#FFFFFF',
		's_desc' 	=> esc_html__( 'Select your custom footer heading color.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Footer text color', 'onelove'),
		'id' 		=> 'footer_text_color',
		'type' 		=> 'color',
		'std' 		=> '#898989',
		's_desc' 	=> esc_html__( 'Select your custom text color for footer.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Footer border color', 'onelove'),
		'id' 		=> 'footer_border_color',
		'type' 		=> 'color',
		'std' 		=> '#1E1E1E',
		's_desc' 	=> esc_html__( 'Select your custom border color for footer.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Footer link color', 'onelove'),
		'id' 		=> 'footer_link',
		'type' 		=> 'multioption',
		'extClass' 	=> 'color-color',
		's_desc' 	=> esc_html__( 'Select your custom link color.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 	=> esc_html__( 'Regular', 'onelove'),
				'id' 	=> 'regular',
				'type' 	=> 'color',
				'std' 	=> '#A3A3A3'
			),
			array(
				'name' 	=> esc_html__( 'Hover', 'onelove'),
				'id' 	=> 'hover',
				'type' 	=> 'color',
				'std' 	=> '#FFFFFF'
			)
		)
	),

	array('type' 	=> 'close'),
		
	array( 'type' 	=> 'close' )
);

$catanis->options->add_option_set( $catanis_options );
?>