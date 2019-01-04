<?php
global $catanis;
$catanis_options = array( 
	array(
		'name' 		=> esc_html_x('Layout Settings', 'Theme Options Tab', 'onelove'),
		'type' 		=> 'title',
		'img' 		=> 'icon-newspaper',
		'class' 	=> 'bg-warning'
	),
	array(
		'type' 		=> 'open',
		'subtitles'	=> array(
			array( 'id' => 'general', 'name' 	=> esc_html_x('General', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'contents', 'name' 	=> esc_html_x('Custom Sidebars', 'Theme Options Subtab', 'onelove') )
		)
	),

	/*GENERAL SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'general'
	),
	array(
		'name' 		=> esc_html__( 'Default layout', 'onelove'),
		'id' 		=> 'default_layout',
		'type' 		=> 'styleimage',
		's_desc'	=> esc_html__( 'Set default layout for all pages.', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions('sidebar-layout-position'),
		'std'		=> 'full'
	),
	array(
		'name' 		=> esc_html__( 'Default sidebar', 'onelove'),
		'id' 		=> 'default_sidebar',
		'type' 		=> 'select',
		'std' 		=> 'sidebar-primary',
		's_desc' 	=> esc_html__( 'Select a sidebar to show', 'onelove'),
		'options' 	=> catanis_get_content_sidebars(),
	),
	array(
		'type' 		=> 'documentation',
		'text' 		=> esc_html__( 'Layout for Other Pages Settings', 'onelove')
	),
		
	array(
		'name' 		=> esc_html__( 'Other pages layout', 'onelove'),
		'id' 		=> 'other_pages_layout',
		'type' 		=> 'styleimage',
		's_desc'	=> esc_html__( 'Set default layout for Archive, Search and 404 page.', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions('sidebar-layout-position'),
		'std'		=> 'full'
	),
	array(
		'name' 		=> esc_html__( 'Default sidebar', 'onelove'),
		'id' 		=> 'other_pages_sidebar',
		'type' 		=> 'select',
		'std' 		=> 'sidebar-primary',
		's_desc' 	=> esc_html__( 'Select a sidebar for Archive, Search and 404 page.', 'onelove'),
		'options' 	=> catanis_get_content_sidebars(),
	),

	array('type' 	=> 'close'),
		
	/*CONTENT SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'contents'
	),
	array(
		'name'		=> esc_html__( 'Custom sidebars', 'onelove'),
		'id'		=> 'sidebars',
		'type'		=> 'custom',
		'ztype'		=> 'sidebar',
		's_desc'	=> esc_html__( 'Sidebars can be used on pages, blog and portfolio', 'onelove'),
		'btnText'	=> esc_html__( 'Add sidebar', 'onelove'),
		'fields'	=> array(
			array( 
				'name'		=> esc_html__( 'Sidebar name (*)', 'onelove'),
				'id'		=> 'sidebar_name', 
				'type'		=> 'text', 
				'required'	=> true
			)
		)
	),
		
	array('type' => 'close'),

	array('type' => 'close' )
);

$catanis->options->add_option_set( $catanis_options );
?>