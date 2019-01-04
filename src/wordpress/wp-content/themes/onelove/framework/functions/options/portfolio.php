<?php
global $catanis;
$catanis_options = array( 
	array(
		'name' 		=> esc_html_x('Portfolio Settings', 'Theme Options Tab', 'onelove'),
		'type' 		=> 'title',
		'img' 		=> 'icon-layout',
		'class' 	=> 'bg-primary2'
	),
	array(
		'type' 		=> 'open',
		'subtitles'	=> array(
			array( 'id' => 'general', 'name' 	=> esc_html_x('Portfolio Settings', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'single', 'name' 	=> esc_html_x('Portfolio Single', 'Theme Options Subtab', 'onelove') )
		 )
	),

	/*GENERAL SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'general'
	),
	array(
		'name' 		=> esc_html__( 'Portfolio layout', 'onelove'),
		'id' 		=> 'portfolio_layout',
		'type' 		=> 'styleimage',
		's_desc'	=> esc_html__( 'Set the default sidebar position for Portfolio page. This setting will be overwritten default sidebar.', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions( 'sidebar-layout-position' ),
		'std'		=> 'full'
	),
	array(
		'name' 		=> esc_html__( 'Page sidebar', 'onelove'),
		'id' 		=> 'portfolio_sidebar',
		'type' 		=> 'select',
		'std' 		=> 'sidebar-primary',
		's_desc' 	=> esc_html__( 'Select a sidebar to show', 'onelove'),
		'options' 	=> catanis_get_content_sidebars(),
	),
	array(
		'name' 		=> esc_html__( 'Portfolio style', 'onelove'),
		'id' 		=> 'portfolio_style',
		'type' 		=> 'select',
		's_desc'	=> esc_html__( 'Select your portfolio style.', 'onelove'),
		'std'		=> 'grid',
		'options' 	=> array(
			array('id' => 'grid', 'name' => 'Grid Style'),
			array('id' => 'masonry', 'name' => 'Masonry Style')
		)
	),
	array(
		'name' 		=> esc_html__( 'Portfolio columns', 'onelove'),
		'id' 		=> 'portfolio_columns',
		'type' 		=> 'styleimage',
		's_desc'	=> esc_html__( 'Select your preferred layout columns.', 'onelove'),
		'std'		=> '3',
		'options' 	=> Catanis_Default_Data::themeOptions( 'portfolio-columns' )
	),
	array(
		'name' 		=> esc_html__( 'Portfolio hover style', 'onelove'),
		'id' 		=> 'portfolio_hover_style',
		'type' 		=> 'styleimage',
		's_desc'	=> esc_html__( 'Select your portfolio hover.', 'onelove'),
		'std'		=> 'style1',
		'options' 	=> Catanis_Default_Data::themeOptions( 'portfolio-hover' )
	),
	array(
		'name' 		=> esc_html__( 'Image source', 'onelove'),
		'id' 		=> 'image_source',
		'type' 		=> 'select',
		's_desc' 	=> esc_html__( 'Image source to display.', 'onelove'),
		'std'		=> 'featured',
		'options' 	=> array(
				array( 'id' => 'featured', 'name' => 'Featured Image' ),
				array( 'id' => 'custom', 'name' => 'Custom Image' )
		)
	),
	array(
		'name' 		=> esc_html__( 'Portfolio spacing', 'onelove'),
		'id' 		=> 'portfolio_spacing',
		'type' 		=> 'select',
		's_desc' 	=> esc_html__( 'Select the spacing between each items.', 'onelove'),
		'std'		=> 'yes',
		'options' 	=> array(
			array( 'id' => 'no', 'name' => 'No Spacing' ),
			array( 'id' => 'yes', 'name' => 'With Spacing' )
		)
	),
	array(
		'name' 		=> esc_html__( 'Spacing size', 'onelove'),
		'id' 		=> 'spacing_size',
		'type' 		=> 'select',
		's_desc' 	=> esc_html__( 'Choose a valuefor spacing size.', 'onelove'),
		'std'		=> '10',
		'options' 	=> array(
			array( 'id' => '10', 'name' => '10px' ),
			array( 'id' => '20', 'name' => '20px' ),
			array( 'id' => '30', 'name' => '30px' ),
			array( 'id' => '40', 'name' => '40px' )
		) 
	),
	array(
		'name' 		=> esc_html__( 'Posts per page', 'onelove'),
		'id' 		=> 'portfolio_per_page',
		'type' 		=> 'text',
		'std'		=> '9',
		's_desc'	=> 	wp_kses( __( 'Number of portfolio posts per page. <br />(Input -1 to show all)', 'onelove' ), array('span', 'br', 'b') )
	),
	
	array('type' 	=> 'close'),
		
	/*PORTFOLIO DETAIL SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'single'
	),
	array(
		'name' 		=> esc_html__( 'Portfolio single layout', 'onelove'),
		'id' 		=> 'portfolio_single_layout',
		'type' 		=> 'styleimage',
		's_desc'	=> esc_html__( 'Sidebar will be applied to single Portfolio posts. This setting will be overwritten default sidebar.', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions( 'sidebar-layout-position' )
	),
	array(
		'name' 		=> esc_html__( 'Page sidebar', 'onelove'),
		'id' 		=> 'portfolio_single_sidebar',
		'type' 		=> 'select',
		'std' 		=> 'sidebar-primary',
		's_desc' 	=> esc_html__( 'Select a sidebar to show', 'onelove'),
		'options' 	=> catanis_get_content_sidebars(),
	),
	array(
		'name' 		=> esc_html__( 'Enable share-box', 'onelove'),
		'id' 		=> 'portfolio_single_enable_sharebox',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the share-box will be displayed on post detail page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Show sections from post info', 'onelove'),
		'id' 		=> 'portfolio_single_sharebox_link',
		'type' 		=> 'multicheck',
		'class'		=> 'included',
		's_desc' 	=> esc_html__( 'The theme allows you to display share links to various social media at the bottom of your blog posts. Check which links you want to display:', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions( 'sharebox-link' ),
		'std' 		=> array( 'facebook', 'twitter', 'google' )
	),
	array(
		'name' 			=> esc_html__( 'Page Back Portfolio', 'onelove'),
		'id' 			=> 'portfolio_single_pageback',
		'type' 			=> 'select',
		'std' 			=> '',
		'options' 		=> Catanis_Default_Data::dataOptions( 'pages' ),
		's_desc' 		=> esc_html__( 'Choose a page to back to portfolio page in navigation.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Display related portfolio', 'onelove'),
		'id' 		=> 'portfolio_single_show_related_portfolio',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, the related portfolio will be displayed on post detail page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable comment', 'onelove'),
		'id' 		=> 'portfolio_single_comment_enable',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, the comment will be displayed on portfolio detail page.', 'onelove')
	),
	
	array('type' 	=> 'close'),
		
	array('type' 	=> 'close' ) 
);

$catanis->options->add_option_set( $catanis_options );
?>