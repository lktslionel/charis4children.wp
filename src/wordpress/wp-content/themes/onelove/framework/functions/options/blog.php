<?php
global $catanis;
$catanis_options = array( 
	array(
		'name' 		=> esc_html_x('Blog Settings', 'Theme Options Tab', 'onelove'),
		'type' 		=> 'title',
		'img' 		=> 'icon-light-bulb',
		'class' 	=> 'bg-primary'
	),
	array(
		'type' 		=> 'open',
		'subtitles'	=> array(
			array( 'id' => 'general', 'name' 	=> esc_html_x('General', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'detail', 'name' 	=> esc_html_x('Blog Single', 'Theme Options Subtab', 'onelove') )
		 )
	),

	/*GENERAL SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'general'
	),
	array(
		'name' 		=> esc_html__( 'Blog layout', 'onelove'),
		'id' 		=> 'blog_layout',
		'type' 		=> 'styleimage',
		's_desc'	=> esc_html__( 'Set the default sidebar position for Blog page and Category page. This setting will be overwritten default sidebar.', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions( 'sidebar-layout-position' ),
		'std'		=> 'full'
	),
	array(
		'name' 		=> esc_html__( 'Page sidebar', 'onelove'),
		'id' 		=> 'blog_sidebar',
		'type' 		=> 'select',
		'std' 		=> 'sidebar-primary',
		's_desc' 	=> esc_html__( 'Select a sidebar to show', 'onelove'),
		'options' 	=> catanis_get_content_sidebars(),
	),
	array(
		'name' 		=> esc_html__( 'Blog style', 'onelove'),
		'id' 		=> 'blog_style',
		'type' 		=> 'select',
		'std' 		=> 'onecolumn',
		's_desc' 	=> esc_html__( 'Choose a style for Blog page', 'onelove'),
		'options' 	=> array(
			array('id' => 'grid', 'name' => 'Grid'),
			array('id' => 'list', 'name' => 'List'),
			array('id' => 'masonry', 'name' => 'Masonry'),
			array('id' => 'onecolumn', 'name' => 'One Column')
		)
	),
	array(
		'name' 		=> esc_html__( 'Blog layout columns', 'onelove'),
		'id' 		=> 'blog_layout_columns',
		'type' 		=> 'styleimage',
		's_desc' 	=> wp_kses( __( 'Select number columns for Blog page. <br /><span style="color:#3FD5B0"> (Only for Grid & Masonry style)</span>', 'onelove' ), array('span', 'br', 'b') ),
		'options' 	=> Catanis_Default_Data::themeOptions( 'layout-cols' ), /*1->4*/
		'std'		=> '1'
	),
	array(
		'name' 		=> esc_html__( 'Show sections from post info', 'onelove'),
		'id' 		=> 'blog_exclude_sections',
		'type' 		=> 'multicheck',
		'class'		=> 'included',
		's_desc' 	=> esc_html__( 'You can choose to display each post.', 'onelove'),
		'std'		=> array('date', 'category'),
		'options' 	=> array(
			array('id' => 'date', 'name' => 'Post Date'),
			array('id' => 'author', 'name' => 'Post Author'),
			array('id' => 'category', 'name' => 'Post Category'),
			array('id' => 'love', 'name' => 'Post Love'),
			array('id' => 'comments', 'name' => 'Comment Number') 
		)
	),
	array(
		'name' 		=> esc_html__( 'Show post summary as', 'onelove'),
		'id' 		=> 'blog_post_summary',
		'type' 		=> 'select',
		'std' 		=> 'readmore',
		's_desc'	=> esc_html__( 'Using the "Read More" tag or the excerpt.', 'onelove'),
		'std'		=> 'excerpt',
		'options' 	=> array(
			array('id' => 'readmore', 'name' => 'Separated with \'Read More\' tag'),
			array('id' => 'excerpt', 'name' => 'Excerpt') 
		)
	),
	array(
		'name' 		=> esc_html__( 'Excerpt length', 'onelove'),
		'id' 		=> 'blog_excerpt_length',
		'type' 		=> 'text',
		'std'		=> 35,
		's_desc'	=> esc_html__( 'If you choose post summary is excerpt, you input length here.', 'onelove')
	),
	array(
	 	'type' 		=> 'documentation',
		 'text' 	=> esc_html__( 'Blog Template Settings', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable advertisement', 'onelove'),
		'id' 		=> 'blog_template_enable_ads',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		'extClass' 	=> 'catanis-select-parent',
		's_desc' 	=> esc_html__( 'If ON, the ads feed will be displayed on the bottom.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Advertisement', 'onelove'),
		'id' 		=> 'blog_template_ads_img',
		'type' 		=> 'upload',
		'extClass' 	=> 'newrow',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/blog-template-ads.jpg',
		'data'		=> array('depend'=> 'blog_template_enable_ads', 'value' => 'true'),
		's_desc' 	=> esc_html__( 'Upload a image for advertisement.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Advertisement URL', 'onelove'),
		'id' 		=> 'blog_template_ads_url',
		'type' 		=> 'text',
		'std' 		=> '#',
		'data'		=> array('depend'=> 'blog_template_enable_ads', 'value' => 'true'),
		's_desc' 	=> esc_html__( 'Input a URL for advertisement, start url with http:// or https://', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Advertisement target', 'onelove'),
		'id' 		=> 'blog_template_ads_target',
		'type' 		=> 'select',
		'std' 		=> '_blank',
		'options' 	=> array(
			array( 'id' => '_blank', 'name' => esc_html__( 'New window', 'onelove' ) ),
			array( 'id' => '_self', 'name' => esc_html__( 'Same window', 'onelove' ) )
		),
		'data'		=> array('depend'=> 'blog_template_enable_ads', 'value' => 'true'),
		's_desc' 	=> esc_html__( 'Choose a value for link target.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable instagram', 'onelove'),
		'id' 		=> 'blog_template_enable_instagram',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		'extClass' 	=> 'catanis-select-parent',
		's_desc' 	=> esc_html__( 'If ON, the instagram feed will be displayed on the bottom.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Instagram username', 'onelove'),
		'id' 		=> 'blog_template_instagram_username',
		'type' 		=> 'text',
		'std' 		=> 'catanisthemes',
		'data'		=> array('depend'=> 'blog_template_enable_instagram', 'value' => 'true')
	),
	
	array('type' 	=> 'close'),
		
	/*BLOG DETAIL SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'detail'
	),
	array(
		'name' 		=> esc_html__( 'Blog single layout', 'onelove'),
		'id' 		=> 'blog_single_sidebar_position',
		'type' 		=> 'styleimage',
		's_desc'	=> esc_html__( 'Sidebar will be applied to single Blog posts. This setting will be overwritten default sidebar.', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions( 'sidebar-layout-position' ),
		'std'		=> 'full'
	),
	array(
		'name' 		=> esc_html__( 'Page sidebar', 'onelove'),
		'id' 		=> 'blog_single_sidebar',
		'type' 		=> 'select',
		'std' 		=> 'sidebar-primary',
		's_desc' 	=> esc_html__( 'Select a sidebar to show', 'onelove'),
		'options' 	=> catanis_get_content_sidebars()
	),
	array(
		'name' 		=> esc_html__( 'Enable share-box', 'onelove'),
		'id' 		=> 'blog_single_enable_sharebox',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the share-box will be displayed on post detail page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Social share links', 'onelove'),
		'id' 		=> 'blog_single_sharebox_link',
		'type' 		=> 'multicheck',
		'class'		=> 'included',
		's_desc' 	=> esc_html__( 'The theme allows you to display share links to various social media at the bottom of your blog posts. Check which links you want to display:', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions( 'sharebox-link' ),
		'std' 		=> array( 'facebook','twitter', 'google' )
	),
	array(
		'name' 		=> esc_html__( 'Display comment', 'onelove'),
		'id' 		=> 'blog_single_display_comment',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, the comment will be displayed on post detail page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Display related posts', 'onelove'),
		'id' 		=> 'blog_single_display_related',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, the related posts will be displayed on post detail page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Blog related articles excerpt', 'onelove'),
		'id' 		=> 'blog_single_related_excerpt',
		'type' 		=> 'multioption',
		's_desc'	=> esc_html__( 'Input excerpt length for related post (depend on theme).', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Status', 'onelove'),
				'id' 		=> 'status',
				'type' 		=> 'checkbox',
				'std' 		=> false
			),
			array(
				'name' 		=> esc_html__( 'Length', 'onelove'),
				'id' 		=> 'length',
				'type' 		=> 'text',
				'std' 		=> '16'
			)
		)
	),
	
	array('type' 	=> 'close'),
		
	array('type' 	=> 'close') 
);

$catanis->options->add_option_set( $catanis_options );
?>