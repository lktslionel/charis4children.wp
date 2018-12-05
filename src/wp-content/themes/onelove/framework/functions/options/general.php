<?php
global $catanis;

if ( catanis_check_cataniscore_exists() ) {
	$subtitles = array(
		array( 'id' => 'general', 'name' 	=> esc_html_x('General', 'Theme Options Subtab', 'onelove') ),
		array( 'id' => 'custom_code', 'name' 	=> esc_html_x('Custom Code', 'Theme Options Subtab', 'onelove') ),
		array( 'id' => 'comingsoon', 'name' 	=> esc_html_x('Coming Soon Page', 'Theme Options Subtab', 'onelove') ),
		array( 'id' => '404page', 'name' 	=> esc_html_x('404 Page', 'Theme Options Subtab', 'onelove') ),
		array( 'id' => 'api_keys', 'name' 	=> esc_html_x('API Keys', 'Theme Options Subtab', 'onelove') )
	);
}else{
	$subtitles = array(
		array( 'id' => 'general', 'name' 	=> esc_html_x('General', 'Theme Options Subtab', 'onelove') ),
		array( 'id' => 'custom_code', 'name' 	=> esc_html_x('Custom Code', 'Theme Options Subtab', 'onelove') ),
		array( 'id' => '404page', 'name' 	=> esc_html_x('404 Page', 'Theme Options Subtab', 'onelove') )
	);
}

$catanis_options = array( 
	array(
		'name' 		=> esc_html_x('General Settings', 'Theme Options Tab', 'onelove'),
		'type' 		=> 'title',
		'img' 		=> 'icon-cogs',
		'class' 	=> 'bg-danger'
	),
	array(
		'type' 		=> 'open',
		'subtitles'	=> $subtitles
	),

	/*GENERAL SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'general'
	),
	array(
		'name' 		=> esc_html__( 'Default logo (Dark Logo)', 'onelove'),
		'id' 		=> 'dark_logo',
		'type' 		=> 'upload',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/dark_logo.png',
		's_desc' 	=> wp_kses( __( 'Use for all pages OR use when header is transparent and menu color style is Light.<br>(Best 155px x 42px).', 'onelove' ), array('span', 'br', 'b') )
	),
	array(
		'name' 		=> esc_html__( 'Transparent logo (Light Logo)', 'onelove'),
		'id' 		=> 'light_logo',
		'type' 		=> 'upload',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/light_logo.png',
		's_desc' 	=> wp_kses( __( 'Use when the header is transparent and menu color style is Dark.<br/>(Best 155px x 42px).', 'onelove' ), array('span', 'br', 'b') )
	),
	array(
		'name' 		=> esc_html__( 'Sticky logo', 'onelove'),
		'id' 		=> 'sticky_logo',
		'type' 		=> 'upload',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/sticky_logo.png',
		's_desc' 	=> esc_html__( 'Upload your logo image for sticky header. (Best 155px x 42px).', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Favicon image URL', 'onelove'),
		'id' 		=> 'favicon',
		'type' 		=> 'upload',
		'is-thumb' 	=> true,
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/favicon.png',
		's_desc' 	=> esc_html__( 'Specify a favicon for your site (16px x 16px). Accepted formats: .ico, .png, .jpg, .gif extension. You can use favicon.cc to make sure it\'s fully compatible)', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable Right to Left mode', 'onelove'),
		'id' 		=> 'rtl_enable',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, your site will be displayed Right to Left mode.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Loader Style', 'onelove'),
		'id' 		=> 'page_loader_style',
		'type' 		=> 'styleimage',
		's_desc'	=> esc_html__( 'Set default loader for site.', 'onelove'),
		'std'		=> 'style1',
		'options' 	=> array(
			array(
				'id' 	=> 'style1',
				'img' 	=> CATANIS_IMAGES_URL . 'styles/loader/style1.png',
				'title'	=> ''
			),
			array(
				'id' 	=> 'style2',
				'img' 	=> CATANIS_IMAGES_URL . 'styles/loader/style2.png',
				'title'	=> ''
			),
			array(
				'id' 	=> 'style3',
				'img' 	=> CATANIS_IMAGES_URL . 'styles/loader/style3.png',
				'title'	=> ''
			),
			array(
				'id' 	=> 'style4',
				'img' 	=> CATANIS_IMAGES_URL . 'styles/loader/style4.png',
				'title'	=> ''
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Custom Image Loader', 'onelove'),
		'id' 		=> 'custom_img_loader',
		'type' 		=> 'upload',
		'std' 		=> '',
		's_desc' 	=> wp_kses( __( 'When you add custom your image here, it will replace Loader Style field above.<br/>(Small image is best).', 'onelove' ), array('span', 'br', 'b') )
	),
			
	array('type' 	=> 'close'),
		
	/*CUSTOM CSS SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'custom_code'
	),
	array(
		'name' 		=> esc_html__( 'Custom CSS', 'onelove'),
		'id' 		=> 'custom_css',
		'type' 		=> 'textarea',
		'style' 	=> 'width: 100%; height: 400px; font-size: 13px;',
		's_desc' 	=> esc_html__( 'If you want to customize css, paste your css code here.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Before Close &lt;/head&gt; Tag', 'onelove'),
		'id' 		=> 'before_head_end_code',
		'type' 		=> 'textarea',
		'style' 	=> 'width: 100%; height: 400px; font-size: 13px;',
		's_desc' 	=> esc_html__( 'Quickly add some custom code css/js before close head tag.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Before Close &lt;/body&gt; Tag', 'onelove'),
		'id' 		=> 'before_body_end_code',
		'type' 		=> 'textarea',
		'style' 	=> 'width: 100%; height: 400px; font-size: 13px;',
		's_desc' 	=> esc_html__( 'Quickly add some custom code html/css/js before close body tag.', 'onelove')
	),
		
	array('type' 	=> 'close'), 
		
	/*COMING SOON PAGE SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'comingsoon'
	),
	array(
		'name' 		=> esc_html__( 'Enable Under Construction', 'onelove'),
		'id' 		=> 'enable_under_construction',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, your site will under construction. Only administrator will be able to see frontend site.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Under Construction Page', 'onelove'),
		'id' 		=> 'under_construction_page',
		'type' 		=> 'select',
		'std' 		=> '',
		'options' 	=> Catanis_Default_Data::dataOptions( 'pages' ),
		's_desc' 	=> esc_html__( 'Select page to display when site is in under construction mode.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Coming soon style', 'onelove'),
		'id' 		=> 'comingsoon_style',
		'type' 		=> 'select',
		'extClass' 	=> 'catanis-select-parent',
		'options' 	=> array(
			array( 'id' => 'v1', 'name' => 'Style V1' ),
			array( 'id' => 'v2', 'name' => 'Style V2' )
		),
		'std' 		=> 'v2',
		's_desc'	=> esc_html__( 'Select a style for coming soon page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Coming logo', 'onelove'),
		'id' 		=> 'comingsoon_logo',
		'type' 		=> 'upload',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/logo-comingsoon-v1.png',
		's_desc' 	=> esc_html__( 'Upload your logo image.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Coming background', 'onelove'),
		'id' 		=> 'comingsoon_bg',
		'type' 		=> 'upload',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/bg-comingsoon.jpg',
		's_desc' 	=> esc_html__( 'Upload your bacground. (Best 1920px x 1030px).', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Timer countdown', 'onelove'),
		'id' 		=> 'comingsoon_countdown',
		'type' 		=> 'multioption',
		'extClass' 	=> 'countdown-group',
		's_desc' 	=> '',
		'fields' => array(
			array(
				'name' 	=> esc_html__( 'Year (Ex: 2018)', 'onelove'),
				'id' 	=> 'year',
				'std'	=> '2018',
				'type' 	=> 'text'
			),
			array(
				'name' 	=> esc_html__( 'Month (Ex: 07)', 'onelove'),
				'id' 	=> 'month',
				'std'	=> '07',
				'type' 	=> 'text'
			),
			array(
				'name' 	=> esc_html__( 'Days (Ex: 20)', 'onelove'),
				'id' 	=> 'days',
				'std'	=> '20',
				'type' 	=> 'text'
			),
			array(
				'name' 	=> esc_html__( 'Hours (Max is 24)', 'onelove'),
				'id' 	=> 'hours',
				'std'	=> '10',
				'type' 	=> 'text'
			),
			array(
				'name' 	=> esc_html__( 'Minutes (Max is 60)', 'onelove'),
				'id' 	=> 'minutes',
				'std'	=> '0',
				'type' 	=> 'text'
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Large title', 'onelove'),
		'id' 		=> 'comingsoon_large_title',
		'type' 		=> 'text',
		'std' 		=> esc_html__('Coming Soon', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Small title', 'onelove'),
		'id' 		=> 'comingsoon_small_title',
		'type' 		=> 'textarea',
		'std' 		=> esc_html__('STAY TUNED, WE ARE LAUNCHING VERY SOON...', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Disable subscribe form', 'onelove'),
		'id' 		=> 'comingsoon_disable_subscribe',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		'extClass' 	=> 'hide',
		's_desc' 	=> esc_html__( 'If disabled, the subscribe form will be not display.', 'onelove')
	),
	array(
		'type' 		=> 'documentation',
		'extClass' 	=> 'sub-heading',
		'text' 		=> esc_html__( 'Video Settings (for Style 2) ', 'onelove'),
		'data'		=> array('depend'=> 'comingsoon_style', 'value' => 'v2'),
	),
	array(
		'name' 		=> esc_html__( 'Video Url', 'onelove'),
		'id' 		=> 'comingsoon_video_url',
		'type' 		=> 'text',
		'std' 		=> 'https://www.youtube.com/watch?v=-2-PAEms-28',
		'data'		=> array('depend'=> 'comingsoon_style', 'value' => 'v2'),
		's_desc' 	=> esc_html__( 'Input video Url here.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Video startAt (number)', 'onelove'),
		'id' 		=> 'comingsoon_video_startat',
		'type' 		=> 'text',
		'std' 		=> 0,
		'data'		=> array('depend'=> 'comingsoon_style', 'value' => 'v2'),
		's_desc' 	=> esc_html__('Set the seconds the video should start at.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Video stopAt (number)', 'onelove'),
		'id' 		=> 'comingsoon_video_stopat',
		'type' 		=> 'text',
		'std' 		=> 90,
		'data'		=> array('depend'=> 'comingsoon_style', 'value' => 'v2'),
		's_desc' 	=> esc_html__( 'Set the seconds the video should stop at. If 0 is ignored.', 'onelove')
	),
		
	array('type' 	=> 'close'), 
		
	/*TWITTER SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> '404page'
	),
	array(
		'name' 		=> esc_html__( 'Background', 'onelove'),
		'id' 		=> '404page_bg',
		'type' 		=> 'upload',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/bg-404.jpg',
		's_desc' 	=> esc_html__( 'Upload your logo image style 1.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Large title', 'onelove'),
		'id' 		=> '404page_large_title',
		'type' 		=> 'text',
		'std' 		=> esc_html__( '404', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Small title', 'onelove'),
		'id' 		=> '404page_small_title',
		'type' 		=> 'text',
		'std' 		=> esc_html__('Oops! This Page Can Not Be Found!', 'onelove')
	),
		
	array('type' 	=> 'close'),
		
	/*API SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'api_keys'
	),
	array(
		'type' 		=> 'documentation',
		'extClass' 	=> 'sub-heading',
		'text' 		=> esc_html__( 'Google API Key', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Google API Key', 'onelove'),
		'id' 		=> 'google_api_key',
		'type' 		=> 'text',
		'std' 		=> '',
		's_desc' 	=> sprintf( wp_kses( __( 'Input your Google API key.<br/> <a href="%s" target="_blank">How To Get?</a>', 'onelove' ), array( 'span', 'br', 'b', 'a' => array( 'href' => array(), 'target' => array()) ) ), 'https://youtu.be/ISaNDHHPro0' )
	),
	array(
		'type' 		=> 'documentation',
		'extClass' 	=> 'sub-heading',
		'text' 		=> esc_html__( 'Twitter API Key', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Consumer key', 'onelove'),
		'id' 		=> 'consumer_key',
		'type' 		=> 'text',
		'std' 		=> '',
		's_desc' 	=> esc_html__( 'Input twitter_keys of your twitter.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Consumer secret', 'onelove'),
		'id' 		=> 'consumer_secret',
		'type' 		=> 'text',
		'std' 		=> '',
		's_desc' 	=> esc_html__( 'Input consumer_secret of your twitter.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Access token', 'onelove'),
		'id' 		=> 'access_token',
		'type' 		=> 'text',
		'std' 		=> '',
		's_desc' 	=> esc_html__( 'Input access_token of your twitter.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Access token secret', 'onelove'),
		'id' 		=> 'access_token_secret',
		'type' 		=> 'text',
		'std' 		=> '',
		's_desc' 	=> esc_html__( 'Input access_token_secret of your twitter.', 'onelove')
	),
		
	array('type' 	=> 'close'),
		
	array('type'	=> 'close')
);

$catanis->options->add_option_set( $catanis_options );
?>