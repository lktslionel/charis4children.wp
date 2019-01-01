<?php
global $catanis;
$shop_page_url = (!catanis_is_woocommerce_active()) ? '#' :  '#'; //get_permalink( wc_get_page_id( 'shop' ) );

$catanis_options = array( 
	array(
		'name' 		=> esc_html_x('Header &amp; Footer Settings', 'Theme Options Tab', 'onelove'),
		'type' 		=> 'title',
		'img' 		=> 'icon-popup',
		'class' 	=> 'bg-orange'
	),
	array(
		'type' 		=> 'open',
		'subtitles'	=> array(
			array( 'id' => 'header', 'name' 		=> esc_html_x('Header', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'page_title', 'name' 	=> esc_html_x('Page Title', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'social_media', 'name' 	=> esc_html_x('Socials Media', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'mega_menu', 'name' 		=> esc_html_x('Mega Menu', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'footer', 'name' 		=> esc_html_x('Footer', 'Theme Options Subtab', 'onelove') )
		 )
	),

	/*GENERAL PAGE SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'header'
	),
	array(
 		'name' 		=> esc_html__( 'Header style', 'onelove'),
 		'id' 		=> 'header_style',
 		'type' 		=> 'imageradio2',
 		's_desc'	=> esc_html__('Choose a header style', 'onelove'),
		'extClass' 	=> 'newrow',
		'std' 		=> 'v3',
		'options' 	=> array( 
			array( "title" => "Header One", "id" => 'v1', "img" => CATANIS_IMAGES_URL . 'styles/header/v1.jpg'), 
			array( "title" => "Header Two", "id" => 'v2', "img" => CATANIS_IMAGES_URL . 'styles/header/v2.jpg'), 
			array( "title" => "Header Three", "id" => 'v3', "img" => CATANIS_IMAGES_URL . 'styles/header/v3.jpg'),
			array( "title" => "Header Four", "id" => 'v4', "img" => CATANIS_IMAGES_URL . 'styles/header/v4.jpg'),
			array( "title" => "Header Five", "id" => 'v5', "img" => CATANIS_IMAGES_URL . 'styles/header/v5.jpg')
		)
	),
	array(
		'name' 		=> esc_html__( 'Header Fullwidth', 'onelove'),
		'id' 		=> 'header_fullwidth',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc'	=> esc_html__('Use header full with or in section box 1170px.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Header fixed', 'onelove'),
		'id' 		=> 'header_fixed',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc'	=> esc_html__( 'If ON, the header will be always displayed, will hide when scroll down and display when scroll up.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Header fixed on mobile', 'onelove'),
		'id' 		=> 'header_mobile_fixed',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc'	=> esc_html__('If ON, the header will be always displayed on mobile, will hide when scroll down and display when scroll up.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Header background', 'onelove'),
		'id' 		=> 'header_bg',
		'type' 		=> 'upload',
		'extClass' 	=> 'newrow',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/bg-header.jpg',
		's_desc' 	=> wp_kses( __( 'Choose image background for header. The image should be between 1920px x 300px for best results.<span>Only apply for header Style V4.</span>', 'onelove' ), array('span', 'br', 'b') )
	),
	array(
		'name' 		=> esc_html__( 'Show store notice', 'onelove'),
		'id'		=> 'show_store_notice',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		'extClass' 	=> 'catanis-select-parent',
		's_desc'	=> wp_kses( __( 'If ON, the store notice will be always displayed on top header.<span>Only apply for header Style V4, V5.</span>', 'onelove'), array('span', 'br', 'b') )
	),
	array(
		'name' 		=> esc_html__( 'Store notice', 'onelove'),
		'id' 		=> 'store_notice',
		'type' 		=> 'textarea',
		'data'		=> array('depend'=> 'show_store_notice', 'value' => 'true'),
		'std' 		=> sprintf( __( 'Wedding Week Sale Starts Now %s Off! <a href="%s">Shop Now</a>', 'onelove' ) , '50%' ,$shop_page_url ),
		's_desc' 	=> esc_html__( 'Change store notice here.', 'onelove')
	),
	array(
		'type' 		=> 'documentation',
		'text' 		=> esc_html__( 'Header Top Settings', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Show header cart', 'onelove'),
		'id'		=> 'show_header_cart',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc'	=> esc_html__( 'If ON, the cart icon will be always displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Show header search', 'onelove'),
		'id'		=> 'show_header_search',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc'	=> esc_html__( 'If ON, the search icon will be always displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Search post type', 'onelove'),
		'id' 		=> 'search_type',
		'type' 		=> 'multicheck',
		'class'		=> 'included',
		's_desc' 	=> esc_html__('Please check post type you want to search.', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions( 'search-type' ),
		'std' 		=> array( 'post')
	),
	array(
		'name' 		=> esc_html__( 'Header Phone', 'onelove'),
		'id' 		=> 'show_header_phone',
		'type' 		=> 'multioption',
		's_desc' 	=> esc_html__( 'Header phone config.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Status', 'onelove'),
				'id'		=> 'status',
				'type' 		=> 'checkbox',
				'std' 		=> true,
				's_desc' 	=> esc_html__('Show or hide the phone info.', 'onelove')
			),
			array(
				'name' 		=> esc_html__( 'Content Phone (Icon &amp; Text)', 'onelove'),
				'id' 		=> 'content',
				'type' 		=> 'textarea',
				'std' 		=> '<span class="iconn ti-mobile"></span><i>+102 198 9207</i>',
				's_desc' 	=> sprintf( __( 'See more icon <a href="%s" target="_blank">here</a> or <a href="%s" target="_blank">here</a>', 'onelove' ), esc_url('https://themify.me/themify-icons'), esc_url('http://fontawesome.io/icons/') )
			)
		)
	),
	array(
		'name' 		=> 'Header Email',
		'id' 		=> 'show_header_email',
		'type' 		=> 'multioption',
		's_desc' 	=> esc_html__('Header email config.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Status', 'onelove'),
				'id'		=> 'status',
				'type' 		=> 'checkbox',
				'std' 		=> true,
				's_desc' 	=> esc_html__('Show or hide the phone info.', 'onelove')
			),
			array(
				'name' 		=> esc_html__('Content Email (Icon &amp; Text)', 'onelove'),
				'id' 		=> 'content',
				'type' 		=> 'textarea',
				'std' 		=> '<span class="iconn ti-bookmark"></span><i>catanisthemes@gmail.com</i>',
				's_desc' 	=> sprintf( __( 'See more icon <a href="%s" target="_blank">here</a> or <a href="%s" target="_blank">here</a>', 'onelove' ), esc_url('https://themify.me/themify-icons'), esc_url('http://fontawesome.io/icons/') )
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Header Address', 'onelove'),
		'id' 		=> 'show_header_address',
		'type' 		=> 'multioption',
		's_desc' 	=> esc_html__( 'Header address config.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Status', 'onelove'),
				'id'		=> 'status',
				'type' 		=> 'checkbox',
				'std' 		=> true,
				's_desc' 	=> esc_html__( 'Show or hide the address info.', 'onelove')
			),
			array(
				'name' 		=> esc_html__( 'Content Address (Icon &amp; Text)', 'onelove'),
				'id' 		=> 'content',
				'type' 		=> 'textarea',
				'std' 		=> '<span class="iconn ti-location-pin"></span><i>123 Redwood Ct, Auburn, WA</i>',
				's_desc' 	=> sprintf( __( 'See more icon <a href="%s" target="_blank">here</a> or <a href="%s" target="_blank">here</a>', 'onelove' ), esc_url('https://themify.me/themify-icons'), esc_url('http://fontawesome.io/icons/') )
			)
		)
	),
		
	array('type' 	=> 'close'),
		
	/*PAGE TITLE SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'page_title'
	),
	array(
		'name' 		=> esc_html__( 'Enable Title', 'onelove'),
		'id' 		=> 'page_title_enable',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, page title will display in page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__('Title Style', 'onelove'),
		'id' 		=> 'page_title_style',
		'type' 		=> 'imageradio2',
		's_desc'	=> esc_html__('Choose style for the page title', 'onelove'),
		'extClass' 	=> 'newrow',
		'std' 		=> 'style2',
		'options' 	=> array(
			array( "title" => "Style V1", "id" => 'style1', "img" => CATANIS_IMAGES_URL . 'styles/page_title/v1.jpg'),
			array( "title" => "Style V2", "id" => 'style2', "img" => CATANIS_IMAGES_URL . 'styles/page_title/v2.jpg')
		)
	),
	array(
		'name' 		=> esc_html__( 'Header Integration', 'onelove'),
		'id' 		=> 'header_overlap',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, page header will be overlap into page title.', 'onelove')
	),
	array(
		'name' 		=> esc_html__('Enable Breadcrumb', 'onelove'),
		'id' 		=> 'show_breadcrumb',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__('If ON, breadcrumb will display in page title section.', 'onelove')
	),
	array(
		'name' 		=> esc_html__('Page Title Position', 'onelove'),
		'id' 		=> 'page_title_position',
		'type' 		=> 'select',
		'std'		=> 'below',
		'options' 	=> array(
			array( 'id' => 'below', 'name' => 'Page Title below Header' ),
			array( 'id' => 'above', 'name' => 'Page Title above Header' )
		),
		'extClass' 	=> 'hide',
		's_desc'	=> esc_html__('With this option page title will be shown above or below header section.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Feature Size', 'onelove'),
		'id' 		=> 'page_feature_size',
		'type' 		=> 'select',
		'extClass' 	=> 'catanis-select-parent',
		'std' 		=> 'custom-size',
		'options' 	=> array(
			array( 'id' => 'fullscreen', 'name' => 'Full Screen' ),
			array( 'id' => 'custom-size', 'name' => 'Custom Height' )
		),
		's_desc' 	=> esc_html__( 'Note: The height of revolution slider is configured from Revolution Slider Settings, do not use Feature Height below.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Feature Height', 'onelove'),
		'id' 		=> 'page_feature_height',
		'type' 		=> 'select',
		'std' 		=> '50',
		'options' 	=> array(
			array( 'id' => '20', 'name' => '20%' ),
			array( 'id' => '30', 'name' => '30%' ),
			array( 'id' => '40', 'name' => '40%' ),
			array( 'id' => '50', 'name' => '50%' ),
			array( 'id' => '60', 'name' => '60%' ),
			array( 'id' => '70', 'name' => '70%' ),
			array( 'id' => '80', 'name' => '80%' ),
			array( 'id' => '90', 'name' => '90%' )
		),
		'data'		=> array('depend'=> 'page_feature_size', 'value' => 'custom-size'),
		's_desc' 	=> esc_html__( 'Choose a value for height', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Feature Min Height', 'onelove'),
		'id' 		=> 'page_feature_minheight',
		'type' 		=> 'text',
		'std' 		=> '250',
		'data'		=> array('depend'=> 'page_feature_size', 'value' => 'custom-size'),
		's_desc' 	=> esc_html__( 'Input min height in px, ex: 200 or 300 or...', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Background Image', 'onelove'),
		'id' 		=> 'page_title_bg',
		'type' 		=> 'upload',
		'extClass' 	=> 'newrow',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/bg-page-title.jpg',
		's_desc' 	=> esc_html__( 'Choose an image background for page title.', 'onelove'),
	),
	array(
		'name' 		=> esc_html__( 'Background Alignment', 'onelove'),
		'id' 		=> 'page_title_bg_alignment',
		'type' 		=> 'select',
		's_desc' 	=> esc_html__( 'Please choose how you would like your slides background to be aligned.', 'onelove'),
		'std' 		=> 'center',
		'options' 	=> array(
			array( 'id' => 'top', 'name' => 'Top' ),
			array( 'id' => 'center', 'name' => 'Center' ),
			array( 'id' => 'bottom', 'name' => 'Bottom' )
		)
	),
		
	array('type' 	=> 'close'),
		
	/*SOCIAL MEDIA SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'social_media'
	),
	array(
		'name' 		=> esc_html__('Show socials', 'onelove'),
		'id' 		=> 'socials_show',
		'type' 		=> 'checkbox',
		's_desc' 	=> esc_html__('If ON, the socials media will be displayed.', 'onelove'),
		'std' 		=> true
	),
	array(
		'name'		=> esc_html__('Add social icons', 'onelove'),
		'id'		=> 'socials',
		'type'		=> 'custom',
		'ztype'		=> 'social',
		'btnText'	=> esc_html__('Add', 'onelove'),
		'preview'	=> 'icon_url',
		'fields'	=> array(
			array(
				'name'		=> esc_html__('Select Icon (*)', 'onelove'),
				'type'		=> 'imageselect',
				'id'		=> 'icon_url',
				'ztype'		=> 'font',
				'required'	=> true,
				'options'	=> Catanis_Default_Data::socialIcons( 'font', 'awesome' )
			),
			array(
				'name'		=> esc_html__('Social URL (*)', 'onelove'),
				'id'		=> 'icon_link',
				'type' 		=> 'text',
				'required'	=> true
			),
			array(
				'name'		=> esc_html__('Social Title', 'onelove'),
				'id'		=> 'icon_title',
				'type'		=> 'text',
			)
		)
	),
	
	array('type' 	=> 'close'),
	
	/*MEGA MENU SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'mega_menu'
	),
	catanis_option_mega_menu(),
	
	array('type' 	=> 'close'),
		
	/*FOOTER SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'footer'
	),
	array(
		'name' 		=> esc_html__('Disable Footer', 'onelove'),
		'id'		=> 'disable_footer',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc'	=> esc_html__('Disable page footer.', 'onelove'),
	),
	array(
		'name' 		=> esc_html__( 'Footer style', 'onelove'),
		'id' 		=> 'footer_style',
		'type' 		=> 'imageradio2',
		's_desc'	=> esc_html__( 'Choose a footer style', 'onelove'),
		'extClass' 	=> 'newrow',
		'std' 		=> 'v2',
		'options' 	=> array(
			array( "title" => "Footer One", "id" => 'v1', "img" => CATANIS_IMAGES_URL . 'styles/footer/v1.jpg'),
			array( "title" => "Footer Two", "id" => 'v2', "img" => CATANIS_IMAGES_URL . 'styles/footer/v2.jpg'),
			array( "title" => "Footer Three", "id" => 'v3', "img" => CATANIS_IMAGES_URL . 'styles/footer/v3.jpg'),
			array( "title" => "Footer Four", "id" => 'v4', "img" => CATANIS_IMAGES_URL . 'styles/footer/v4.jpg'),
		)
	), 
	array(
		'name' 		=> esc_html__( 'Footer Logo', 'onelove'),
		'id' 		=> 'footer_logo',
		'type' 		=> 'upload',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/footer_logo.png',
		's_desc' 	=> esc_html__( 'Upload your footer logo image. (Best 160px x 45px). Use for footer style #3', 'onelove'),
	),
	array(
		'name' 		=> esc_html__( 'Footer Background', 'onelove'),
		'id' 		=> 'footer_background',
		'type' 		=> 'upload',
		's_desc' 	=> esc_html__('Upload a image for background footer (Best 1920 x 1000px).', 'onelove'),
	),
	array(
		'name' 		=> esc_html__( 'Footer Top Color Scheme', 'onelove'),
		'id' 		=> 'footer_top_color_scheme',
		'type' 		=> 'select',
		'std' 		=> 'dark',
		'options'	=>  array(
			array( 'id' => 'light', 'name' => 'Light' ),
			array( 'id' => 'dark', 'name' => 'Dark' )
		),
		's_desc'	=> esc_html__( 'Select footer top color scheme here, depend on footer style above.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Footer Bottom Color Scheme', 'onelove'),
		'id' 		=> 'footer_bottom_color_scheme',
		'type' 		=> 'select',
		'std' 		=> 'dark',
		'options'	=>  array(
			array( 'id' => 'light', 'name' => 'Light' ),
			array( 'id' => 'dark', 'name' => 'Dark' ),
			array( 'id' => 'black', 'name' => 'Black' )
		),
		's_desc'	=> esc_html__('Select footer bottom color scheme here, depend on footer style above.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Back to top', 'onelove'),
		'id' 		=> 'footer_backtop',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc'	=> esc_html__( 'If ON, the button will be always displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Copyright text', 'onelove'),
		'id' 		=> 'footer_copyright',
		'type' 		=> 'textarea',
		'std' 		=> '&copy; [cata_year] <span>One Love Theme</span>. Design By <i class="fa fa-heart"></i><span>Catanis</span>. All Rights Reserved.',
		's_desc' 	=> esc_html__('Enter your Copyright Text (simple HTML allowed), can use shortcode [cata_year] to display current year.', 'onelove')
	),
	array(
		'type' 		=> 'documentation',
		'extClass' 	=> 'sub-heading',
		'text' 		=> esc_html__( 'Footer Shortcode Settings', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Footer Phone', 'onelove'),
		'id' 		=> 'show_footer_phone',
		'type' 		=> 'multioption',
		's_desc' 	=> esc_html__('Footer phone config, can use shortcode [cata_footer_phone] to display.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Status', 'onelove'),
				'id'		=> 'status',
				'type' 		=> 'checkbox',
				'std' 		=> true,
				's_desc' 	=> esc_html__( 'Show or hide the phone info.', 'onelove'),
			),
			array(
				'name' 		=> esc_html__( 'Content Phone (Icon &amp; Text)', 'onelove'),
				'id' 		=> 'content',
				'type' 		=> 'textarea',
				'std' 		=> '<span class="iconn ti-mobile"></span><i>(+1) 207 187 1989</i>',
				's_desc' 	=> sprintf( __( 'See more icon <a href="%s" target="_blank">here</a> or <a href="%s" target="_blank">here</a>', 'onelove' ), esc_url('https://themify.me/themify-icons'), esc_url('http://fontawesome.io/icons/') )
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Footer Email', 'onelove'),
		'id' 		=> 'show_footer_email',
		'type' 		=> 'multioption',
		's_desc' 	=> esc_html__( 'Footer email config, can use shortcode [cata_footer_email] to display.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Status', 'onelove'),
				'id'		=> 'status',
				'type' 		=> 'checkbox',
				'std' 		=> true,
				's_desc' 	=> esc_html__( 'Show or hide the phone info.', 'onelove')
			),
			array(
				'name' 		=> esc_html__( 'Content Email (Icon &amp; Text)', 'onelove'),
				'id' 		=> 'content',
				'type' 		=> 'textarea',
				'std' 		=> '<span class="iconn ti-bookmark"></span><i>catanisthemes@gmail.com</i>',
				's_desc' 	=> sprintf( __( 'See more icon <a href="%s" target="_blank">here</a> or <a href="%s" target="_blank">here</a>', 'onelove' ), esc_url('https://themify.me/themify-icons'), esc_url('http://fontawesome.io/icons/') )
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Footer Address', 'onelove'),
		'id' 		=> 'show_footer_address',
		'type' 		=> 'multioption',
		's_desc' 	=> esc_html__('Footer address config, can use shortcode [cata_footer_address] to display.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Status', 'onelove'),
				'id'		=> 'status',
				'type' 		=> 'checkbox',
				'std' 		=> true,
				's_desc' 	=> esc_html__( 'Show or hide the address info.', 'onelove')
			),
			array(
				'name' 	=> esc_html__( 'Content Address (Icon &amp; Text)', 'onelove'),
				'id' 	=> 'content',
				'type' 	=> 'textarea',
				'std' 	=> '<span class="iconn ti-location-pin"></span><i>2404 Redwood Ct, Auburn, WA 98092, USA</i>',
				's_desc' 	=> sprintf( __( 'See more icon <a href="%s" target="_blank">here</a> or <a href="%s" target="_blank">here</a>', 'onelove' ), esc_url('https://themify.me/themify-icons'), esc_url('http://fontawesome.io/icons/') )
			)
		)
	),
	
	array('type' 	=> 'close'),
		
	array('type' 	=> 'close') 
);

$catanis->options->add_option_set( $catanis_options );
?>