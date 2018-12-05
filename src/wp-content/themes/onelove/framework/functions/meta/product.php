<?php
global $catanis;

/*
 * 'boxtabs' 	=> true		: Show tab 1
 *	boxsimple' 	=> false 	: Dont show tab 2 (secondary_metaboxes)
 */
$page_feature_type = array(
	array( 'id' => 'image', 'name' => 'Image (settings section below)' ),
	array( 'id' => 'map', 'name' => 'Map' ),
	array( 'id' => 'video', 'name' => 'Video' ),
	array( 'id' => 'slider', 'name' => 'Slider' )
);
		
if(catanis_check_revolution_exists()){
	$page_feature_type[] = array( 'id' => 'revslider', 'name' => 'Revolution Slider' );
}

$show_header_phone 	= catanis_option('show_header_phone');
$show_header_email 	= catanis_option('show_header_email');
$show_header_address = catanis_option('show_header_address');

$options = array(
	'boxtabs' 	=> true,
	'boxsimple' => false,
	'layout_header' => array(
		array(
			'name' 		=> esc_html__( 'Page Layout', 'onelove'),
			'id' 		=> 'layout',
			'type' 		=> 'imageradio',
			'options' 	=> Catanis_Default_Data::themeOptions('sidebar-layout-position', array( 'ztype' => 'meta' ) ),
			'std' 		=> 'default',
			's_desc' 	=> esc_html__( 'Choose a layout for this page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Page Sidebar', 'onelove'),
			'id' 		=> 'sidebar',
			'type' 		=> 'select',
			'options' 	=> catanis_get_content_sidebars( 'default' ),
			's_desc' 	=> esc_html__( 'Choose a sidebar you want, depend on Page Layout above.', 'onelove')
		),
		array(
			'title' 	=> esc_html__( 'Custom Options For Page', 'onelove'),
			'type' 	 	=> 'heading',
			'extClass' 	=> 'sub-heading'
		),
		array(
			'name' 		=> esc_html__( 'Header Style', 'onelove'),
			'id' 		=> 'header_style',
			'type' 		=> 'select',
			'extClass' 	=> 'catanis-select-parent',
			'std' 		=> catanis_option('header_style'),
			'options' 	=> array(
				array( 'id' => '', 'name' => esc_html__( 'Default', 'onelove' )),
				array( 'id' => 'v1', 'name' => esc_html__( 'Style V1', 'onelove' )),
				array( 'id' => 'v2', 'name' => esc_html__( 'Style V2', 'onelove' )),
				array( 'id' => 'v3', 'name' => esc_html__( 'Style V3', 'onelove' )),
				array( 'id' => 'v4', 'name' => esc_html__( 'Style V4', 'onelove' )),
				array( 'id' => 'v5', 'name' => esc_html__( 'Style V5', 'onelove' ))
			),
			's_desc' 	=> wp_kses( __( 'Choose a header style for this page.<span>Inherit: Theme Options > Header & Footer Settings > Header.</span>', 'onelove' ), array('span', 'br', 'b') )
		),
		array(
			'name' 		=> esc_html__( 'Header Background', 'onelove'),
			'id' 		=> 'header_bg',
			'type' 		=> 'upload',
			'data'		=> array('depend'=> 'header_style', 'value' => 'v4'),
			's_desc' 	=> wp_kses( __( 'Choose image background for header. The image should be between 1920px x 300px for best results.<span>Only apply for header Style V4.</span>', 'onelove' ), array('span', 'br', 'b') )
		),
		array(
			'name' 		=> esc_html__( 'Show store notice', 'onelove'),
			'id'		=> 'show_store_notice',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('show_store_notice'),
			's_desc' 	=> wp_kses( __( 'If ON, the store notice will be always displayed on top header (Only apply for header Style V4, V5).<span>Inherit: Theme Options > Header & Footer Settings > Header.</span>', 'onelove' ), array('span', 'br', 'b') )			
		),
		array(
			'name' 		=> esc_html__( 'Menu Color Style', 'onelove'),
			'id' 		=> 'menu_color_style',
			'type' 		=> 'select',
			'std' 		=> catanis_option('menu_color_style'),
			'options' 	=> array(
				array( 'id' => '', 'name' => esc_html__( 'Default', 'onelove' )),
				array( 'id' => 'dark', 'name' => 'Dark style' ),
				array( 'id' => 'light', 'name' => 'Light style' )
			),
			's_desc' 	=> wp_kses( __( 'Select a color style for menu.<span>Inherit: Theme Options > Styling Settings > Header.</span>', 'onelove' ), array('span', 'br', 'b') )
		),
		array(
			'name' 		=> esc_html__( 'Main Navigation Menu', 'onelove'),
			'id' 		=> 'main_navigation_menu',
			'type' 		=> 'select',
			'options' 	=> Catanis_Default_Data::themeOptions('navigations'),
			's_desc'	=> esc_html__( 'Select alternative main navigation menu.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Custom Logo', 'onelove'),
			'id' 		=> 'custom_logo',
			'type' 		=> 'upload',
			's_desc' 	=> wp_kses( __( 'Select a logo to custom for page.<span>Inherit: Theme Options > General Settings => Logo Site (Dark Logo).</span>', 'onelove' ), array('span', 'br', 'b') )
		),
		array(
			'name' 		=> esc_html__( 'Sticky logo', 'onelove'),
			'id' 		=> 'sticky_logo',
			'type' 		=> 'upload',
			's_desc' 	=> wp_kses( __( 'Upload your logo image for sticky header.<span>Inherit: Theme Options > General Settings => Sticky logo.</span>', 'onelove' ), array('span', 'br', 'b') )
		),
		array(
			'name' 		=> esc_html__( 'Show header cart', 'onelove'),
			'id'		=> 'show_header_cart',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('show_header_cart'),
			's_desc'	=> esc_html__( 'Show or hide the cart icon.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Show header search', 'onelove'),
			'id'		=> 'show_header_search',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('show_header_search'),
			's_desc'	=> esc_html__( 'Show or hide header search icon.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Show socials', 'onelove'),
			'id' 		=> 'show_header_socials',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('socials_show'),
			's_desc' 	=> esc_html__( 'If ON, the socials media will be displayed.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Show header phone', 'onelove'),
			'id'		=> 'show_header_phone',
			'type' 		=> 'checkbox',
			'std' 		=> $show_header_phone['status'],
			's_desc'	=> esc_html__( 'Show or hide header phone. It\'s depend on header style.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Show header email', 'onelove'),
			'id' 		=> 'show_header_email',
			'type' 		=> 'checkbox',
			'std' 		=> $show_header_email['status'],
			's_desc' 	=> esc_html__( 'Show or hide header email. It\'s depend on header style.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Show header address', 'onelove'),
			'id'		=> 'show_header_address',
			'type' 		=> 'checkbox',
			'std' 		=> $show_header_address['status'],
			's_desc'	=> esc_html__( 'Show or hide the address. It\'s depend on header style.', 'onelove')
		),
	),
	'page_title' => array(
		array(
			'name' 		=> esc_html__( 'Enable Title', 'onelove'),
			'id' 		=> 'page_title_enable',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('woo_page_title_enable'),
			's_desc' 	=> wp_kses( __( 'If ON, page title will display in page.<br /><b>If OFF all options below will not apply.</b>', 'onelove' ), array('span', 'br', 'b') )
		),
		array(
			'name' 		=> esc_html__( 'Header Integration', 'onelove'),
			'id' 		=> 'header_overlap',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('header_overlap'),
			's_desc' 	=> esc_html__( 'If ON, page header will be overlap into page title.', 'onelove')
		),
		array(
			'title' 	=> esc_html__( 'Page Feature Settings', 'onelove'),
			'type' 	 	=> 'heading',
			'extClass' 	=> 'sub-heading'
		),
		array(
			'name' 		=> esc_html__( 'Page Feature Type', 'onelove'),
			'id' 		=> 'page_feature_type',
			'type' 		=> 'select',
			'extClass' 	=> 'catanis-select-parent',
			'style' 	=> 'background: #eaeaea;margin-left: -25px;padding-left: 25px;padding-right: 25px; margin-bottom: -3px; width: 100% !important;',
			'std' 		=> 'image',
			'options' 	=> $page_feature_type,
			's_desc'	=> esc_html__( 'Please select the background type you would like to use for page title.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Feature Size', 'onelove'),
			'id' 		=> 'page_feature_size',
			'type' 		=> 'select',
			'extClass' 	=> 'catanis-select-parent',
			'std' 		=> catanis_option('woo_page_feature_size'),
			'options' 	=> array(
					array( 'id' => 'fullscreen', 'name' => 'Full Screen' ),
					array( 'id' => 'custom-size', 'name' => 'Custom Height' )
			),
			's_desc' 	=> esc_html__( 'Note: If you choose Feature Type is Revolution Slider, so the height is configured from Revolution Slider Settings, do not use Feature Height.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Feature Height', 'onelove'),
			'id' 		=> 'page_feature_height',
			'type' 		=> 'select',
			'std' 		=> catanis_option('woo_page_feature_height'),
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
			'large'		=> true,
			'std' 		=> catanis_option('woo_page_feature_minheight'),
			'data'		=> array('depend'=> 'page_feature_size', 'value' => 'custom-size'),
			's_desc' 	=> esc_html__( 'Input min height in px, ex: 200 or 300 or...', 'onelove')
		),
			
		Catanis_Default_Data::metaOptions( 'revolution-option-page', array('extra-data' => array('depend'=> 'page_feature_type', 'value' => 'revslider')) ),
		array(
			'name' 		=> esc_html__( 'Images Slider', 'onelove'),
			'id' 		=> 'page_feature_slider_items',
			'type' 		=> 'multiupload',
			'data'		=> array('depend'=> 'page_feature_type', 'value' => 'slider'),
			's_desc'	=> esc_html__( 'Choose some images for gallery.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Pin Image (Marker)', 'onelove'),
			'id' 		=> 'page_feature_map_pin',
			'type' 		=> 'upload',
			'std' 		=> '',
			'data'		=> array('depend'=> 'page_feature_type', 'value' => 'map'),
			's_desc' 	=> esc_html__( 'Select a pin image to be used on Google Map', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Map style', 'onelove'),
			'id' 		=> 'page_feature_map_style',
			'type' 		=> 'select',
			'std' 		=> 'style1',
			'options' 	=> array(
				array( 'id' => 'style1', 'name' => 'Style 1' ),
				array( 'id' => 'style2', 'name' => 'Style 2' ),
				array( 'id' => 'style3', 'name' => 'Style 3' ),
				array( 'id' => 'style4', 'name' => 'Style 4' ),
				array( 'id' => 'style5', 'name' => 'Style 5' ),
				array( 'id' => 'style6', 'name' => 'Style 6' ),
				array( 'id' => 'style7', 'name' => 'Style 7' ),
				array( 'id' => 'style8', 'name' => 'Style 8' ),
				array( 'id' => 'style9', 'name' => 'Style 9' ),
				array( 'id' => 'style10', 'name' => 'Style 10' )
			),
			'data'		=> array('depend'=> 'page_feature_type', 'value' => 'map'),
		),
		array(
			'name' 		=> esc_html__( 'Map zoom', 'onelove'),
			'id' 		=> 'page_feature_map_zoom',
			'type' 		=> 'text',
			'std' 		=> '8',
			'large'		=> true,
			'data'		=> array('depend'=> 'page_feature_type', 'value' => 'map'),
			's_desc' 	=> esc_html__( 'Input a value (from 1 to 18)', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Address 1', 'onelove'),
			'id' 		=> 'page_feature_map_address1',
			'type' 		=> 'text',
			'data'		=> array('depend'=> 'page_feature_type', 'value' => 'map')
		),
		array(
			'name' 		=> esc_html__( 'Address 2', 'onelove'),
			'id' 		=> 'page_feature_map_address2',
			'type' 		=> 'text',
			'data'		=> array('depend'=> 'page_feature_type', 'value' => 'map')
		),
		array(
			'name' 		=> esc_html__( 'Address 3', 'onelove'),
			'id' 		=> 'page_feature_map_address3',
			'type' 		=> 'text',
			'data'		=> array('depend'=> 'page_feature_type', 'value' => 'map')
		),
		array(
			'name' 		=> esc_html__( 'Address 4', 'onelove'),
			'id' 		=> 'page_feature_map_address4',
			'type' 		=> 'text',
			'data'		=> array('depend'=> 'page_feature_type', 'value' => 'map')
		),
		array(
			'name' 		=> esc_html__( 'Address 5', 'onelove'),
			'id' 		=> 'page_feature_map_address5',
			'type' 		=> 'text',
			'data'		=> array('depend'=> 'page_feature_type', 'value' => 'map')
		),
		
		array(
			'name' 		=> esc_html__( 'Video type', 'onelove'),
			'id' 		=> 'page_feature_video_type',
			'type' 		=> 'select',
			'extClass' 	=> 'video_format catanis-select-parent',
			'std' 		=> 'youtube',
			'options' 	=> array(
				array( 'id' => 'hosted', 'name' => 'Self Hosted' ),
				array( 'id' => 'youtube', 'name' => 'Youtube Video' ),
				array( 'id' => 'vimeo', 'name' => 'Vimeo Video' )
			),
			'data'		=> array('depend'=> 'page_feature_type', 'value' => 'video'),
			's_desc' 	=> esc_html__( 'Select video type.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Video Youtube URL', 'onelove'),
			'id' 		=> 'page_feature_video_url_youtube',
			'type' 		=> 'text',
			'large'		=> true,
			'extClass'	=> 'video_format',
			'data'		=> array('depend'=> 'page_feature_video_type', 'value' => 'youtube'),
			's_desc' 	=> esc_html__( 'Input Youtube Video URL here.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Video Vimeo URL', 'onelove'),
			'id' 		=> 'page_feature_video_url_vimeo',
			'type' 		=> 'text',
			'large'		=> true,
			'extClass'	=> 'video_format',
			'data'		=> array('depend'=> 'page_feature_video_type', 'value' => 'vimeo'),
			's_desc' 	=> esc_html__( 'Input Vimeo Video URL here.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'MP4 Video URL', 'onelove'),
			'id' 		=> 'page_feature_video_url_mp4',
			'type' 		=> 'linkupload',
			'upload_type' 	=> 'video',
			'large'		=> true,
			'extClass'	=> 'video_format',
			'data'		=> array('depend'=> 'page_feature_video_type', 'value' => 'hosted'),
			's_desc' 	=> esc_html__( 'Video url is required here if self hosted option is selected.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'OGG Video URL', 'onelove'),
			'id' 		=> 'page_feature_video_url_ogg',
			'type' 		=> 'linkupload',
			'upload_type' 	=> 'video',
			'large'		=> true,
			'extClass'	=> 'video_format',
			'data'		=> array('depend'=> 'page_feature_video_type', 'value' => 'hosted'),
			's_desc' 	=> esc_html__( 'Video url is required here if self hosted option is selected.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'WEBM Video URL', 'onelove'),
			'id' 		=> 'page_feature_video_url_webm',
			'type' 		=> 'linkupload',
			'upload_type' 	=> 'video',
			'large'		=> true,
			'extClass'	=> 'video_format',
			'data'		=> array('depend'=> 'page_feature_video_type', 'value' => 'hosted'),
			's_desc' 	=> esc_html__( 'Video url is required here if self hosted option is selected.', 'onelove')
		),
		array(
			'title' 	=> esc_html__( 'Page Title Image Default', 'onelove'),
			'type' 	 	=> 'heading',
			'extClass' 	=> 'sub-heading'
		),
			
		array(
			'name' 		=> esc_html__( 'Title Style', 'onelove'),
			'id' 		=> 'page_title_style',
			'type' 		=> 'select',
			'extClass' 	=> 'catanis-select-parent',
			's_desc' 	=> esc_html__( 'Please choose style for the page title', 'onelove'),
			'std' 		=> catanis_option('woo_page_title_style'),
			'options' 	=> array(
				array( 'id' => 'style1', 'name' => 'Style V1' ),
				array( 'id' => 'style2', 'name' => 'Style V2' )
			)
		),
		array(
			'name' 		=> esc_html__( 'Enable Breadcrumb', 'onelove'),
			'id' 		=> 'show_breadcrumb',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('woo_show_breadcrumb'),
			's_desc' 	=> esc_html__( 'If ON, breadcrumb will be display in title section.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Page Title Position', 'onelove'),
			'id' 		=> 'page_title_position',
			'type' 		=> 'select',
			'extClass' 	=> 'hide',
			's_desc'	=> esc_html__( 'With this option page title will be shown above or header feature section.', 'onelove'),
			'std'		=> catanis_option('woo_page_title_position'),
			'options' 	=> array(
				array( 'id' => '', 'name' => 'Default' ),
				array( 'id' => 'below', 'name' => 'Page Title below Header' ),
				array( 'id' => 'above', 'name' => 'Page Title above Header' )
			)
		),
		array(
			'name' 		=> esc_html__( 'Background Image', 'onelove'),
			'id' 		=> 'page_title_bg',
			'type' 		=> 'upload',
			'std' 		=> catanis_option('woo_page_title_bg'),
			's_desc' 	=> esc_html__( 'Choose image background for header and page title. The image should be between 1920px - 1080px wide.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Background Alignment', 'onelove'),
			'id' 		=> 'page_title_bg_alignment',
			'type' 		=> 'select',
			's_desc' 	=> esc_html__( 'Please choose how you would like your slides background to be aligned.', 'onelove'),
			'std' 		=> catanis_option('woo_page_title_bg_alignment'),
			'options' 	=> array(
				array( 'id' => 'top', 'name' => 'Top' ),
				array( 'id' => 'center', 'name' => 'Center' ),
				array( 'id' => 'bottom', 'name' => 'Bottom' )
			)
		),
		array(
			'name' 		=> esc_html__( 'Show Overlay Div', 'onelove'),
			'id' 		=> 'page_title_overlay',
			'type' 		=> 'checkbox',
			'extClass' 	=> 'catanis-select-parent',
			'std' 		=> false,
			's_desc' 	=> esc_html__( 'If ON, a div with color will be overlap background image.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Overlay Color', 'onelove'),
			'id' 		=> 'page_title_overlay_color',
			'type' 		=> 'color',
			'std' 		=> 'rgba(0, 0, 0, 0.3)',
			'data'		=> array('depend'=> 'page_title_overlay', 'value' => 'true'),
			's_desc' 	=> esc_html__( 'Set color for overlay div.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Use Parallax', 'onelove'),
			'id' 		=> 'page_title_parallax',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('page_title_parallax'),
			's_desc' 	=> esc_html__( 'This will cause your header to have a parallax scroll effect.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Page Header Title', 'onelove'),
			'id' 		=> 'page_title_title',
			'type' 		=> 'text',
			's_desc' 	=> esc_html__( 'Enter in the page header title.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Page Header Subtitle', 'onelove'),
			'id' 		=> 'page_title_subtitle',
			'type' 		=> 'text',
			's_desc' 	=> esc_html__( 'Enter in the page header subtitle. If you want use FadeIn effect please using characters | to separate between each subtitles.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Page Header Background Color', 'onelove'),
			'id' 		=> 'page_title_bg_color',
			'type' 		=> 'color',
			'std' 		=> '#e49497',
			's_desc' 	=> esc_html__( 'Set your desired page header background color if not using an image.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Page Header Font Color', 'onelove'),
			'id' 		=> 'page_title_font_color',
			'type' 		=> 'color',
			'std' 		=> '#FFFFFF',
			's_desc' 	=> esc_html__( 'Set your desired page header font color', 'onelove')
		)
	),
	'footer' => array(
		array(
			'name' 		=> esc_html__( 'Disable Footer', 'onelove'),
			'id' 		=> 'disable_footer',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('disable_footer'),
			's_desc' 	=> esc_html__( 'Disable page footer.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Footer Style', 'onelove'),
			'id' 		=> 'footer_style',
			'type' 		=> 'select',
			'std' 		=> catanis_option('footer_style'),
			'options' 	=> array(
				array( 'id' => '', 'name' => 'Default'),
				array( 'id' => 'v1', 'name' => 'Style V1'),
				array( 'id' => 'v2', 'name' => 'Style V2'),
				array( 'id' => 'v3', 'name' => 'Style V3'),
				array( 'id' => 'v4', 'name' => 'Style V4')
			),
			's_desc' 	=> wp_kses( __( 'Choose a footer style for this page. <span>Inherit: Theme Options > Header & Footer Settings > Footer.</span>', 'onelove' ), array('span', 'br', 'b') )
		),
		array(
			'name' 		=> esc_html__( 'Footer Logo', 'onelove'),
			'id' 		=> 'footer_logo',
			'type' 		=> 'upload',
			'std' 		=> catanis_option('footer_logo'),
			's_desc' 	=> esc_html__( 'Upload your footer logo image. (Best 160px x 45px). Use for footer style #3', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Footer Background', 'onelove'),
			'id' 		=> 'footer_background',
			'type' 		=> 'upload',
			'std' 		=> catanis_option('footer_background'),
			's_desc' 	=> esc_html__('Upload a image for background footer (Best 1920 x 1000px).', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Footer Top Color Scheme', 'onelove'),
			'id' 		=> 'footer_top_color_scheme',
			'type' 		=> 'select',
			'std' 		=> catanis_option('footer_top_color_scheme'),
			'options'	=>  array(
					array( 'id' => '', 'name' => 'Default'),
					array( 'id' => 'light', 'name' => 'Light' ),
					array( 'id' => 'dark', 'name' => 'Dark' )
			),
			's_desc'	=> esc_html__( 'Select footer top color scheme here, depend on footer style above.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Footer Bottom Color Scheme', 'onelove'),
			'id' 		=> 'footer_bottom_color_scheme',
			'type' 		=> 'select',
			'std' 		=> catanis_option('footer_bottom_color_scheme'),
			'options'	=>  array(
				array( 'id' => '', 'name' => 'Default'),
				array( 'id' => 'light', 'name' => 'Light' ),
				array( 'id' => 'dark', 'name' => 'Dark' ),
				array( 'id' => 'black', 'name' => 'Black' )
			),
			's_desc'	=> esc_html__('Select footer bottom color scheme here, depend on footer style above.', 'onelove')
		)		
	),

	'single_post_layout' => array(
		
		array(
			'name' 		=> esc_html__( 'Product video', 'onelove'),
			'id' 		=> 'prodetail_video',
			'type' 		=> 'text',
			'large'		=> true,
			'std' 		=> '',
			's_desc' 	=> esc_html__( 'Input youtube video here to display video link popup on product single page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Product thumbnails style', 'onelove'),
			'id' 		=> 'prodetail_thumbnails_style',
			'type' 		=> 'select',
			'std' 		=> catanis_option('prodetail_thumbnails_style'),
			's_desc' 	=> esc_html__( 'Select thumbnails style you want.', 'onelove'),
			'options' 	=> array(
					array( 'id' => 'vertical', 'name' => 'Vertical' ),
					array( 'id' => 'horizontal', 'name' => 'Horizontal' )
			),
		),
		array(
			'name' 		=> esc_html__( 'Enable cloud zoom', 'onelove'),
			'id' 		=> 'prodetail_enable_cloudzoom',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_cloudzoom'),
			's_desc' 	=> esc_html__( 'If OFF, product gallery images will open in a lightbox. This option overrides the option of WooCommerce.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Enable product title', 'onelove'),
			'id' 		=> 'prodetail_enable_title',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_title'),
			's_desc' 	=> esc_html__( 'If ON, the product title will be displayed.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Enable product label', 'onelove'),
			'id' 		=> 'prodetail_enable_label',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_label'),
			's_desc' 	=> esc_html__( 'If ON, the product label will be displayed.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Enable product availability', 'onelove'),
			'id' 		=> 'prodetail_enable_availability',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_availability'),
			's_desc' 	=> esc_html__( 'If ON, the product availability will be displayed.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Enable product price', 'onelove'),
			'id' 		=> 'prodetail_enable_price',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_price'),
			's_desc' 	=> esc_html__( 'If ON, the product price will be displayed.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Enable product rating', 'onelove'),
			'id' 		=> 'prodetail_enable_rating',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_rating'),
			's_desc' 	=> esc_html__( 'If ON, the product rating will be displayed.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Enable product excerpt', 'onelove'),
			'id' 		=> 'prodetail_enable_excerpt',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_excerpt'),
			's_desc' 	=> esc_html__( 'If ON, the product excerpt will be displayed.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Enable add to cart button', 'onelove'),
			'id' 		=> 'prodetail_enable_addtocart',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_addtocart'),
			's_desc' 	=> esc_html__( 'If ON, the product add to cart will be displayed.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Enable meta', 'onelove'),
			'id' 		=> 'prodetail_enable_meta',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_meta'),
			's_desc' 	=> esc_html__( 'If ON, the meta (SKU, Tags and categories) will be displayed.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Enable pagination', 'onelove'),
			'id' 		=> 'prodetail_enable_pagination',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_pagination'),
			's_desc' 	=> esc_html__( 'If ON, the product pagination Next & Previous will be displayed on detail page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Enable share-box', 'onelove'),
			'id' 		=> 'prodetail_enable_sharebox',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_sharebox'),
			's_desc' 	=> esc_html__( 'If ON, the share-box will be displayed on post detail page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Show shipping & return box', 'onelove'),
			'id' 		=> 'prodetail_enable_shippingbox',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_shippingbox'),
			's_desc'	=> esc_html__( 'If ON, the shipping return content will be displayed.', 'onelove')
		),
		array(
			'title' 	=> '<div class="ui-icon ui-icon-image"></div>' . esc_html__('Product Custom Tabs', 'onelove'),
			'type' 		=> 'heading',
			'extClass' 	=> 'sub-heading'
		),
		array(
			'name' 		=> esc_html__( 'Product Custom Tabs', 'onelove'),
			'id' 		=> 'prodetail_custom_tabs',
			'type' 		=> 'select',
			'extClass' 	=> 'catanis-select-parent',
			's_desc' 	=> esc_html__( 'You can use default setting in Theme Option OR override it.', 'onelove'),
			'options' 	=> array(
				array( 'id' => '', 'name' => 'Default' ),
				array( 'id' => 'override', 'name' => 'Override' )
			)
		),
		array(
			'name' 		=> esc_html__( 'Product Custom Tabs Text', 'onelove'),
			'id' 		=> 'prodetail_custom_tabs_title',
			'type' 		=> 'text',
			'data'		=> array('depend'=> 'prodetail_custom_tabs', 'value' => 'override'),
			'std'		=> catanis_option('prodetail_custom_tabs_title'),
		),
		array(
			'name' 		=> esc_html__( 'Product Custom Tabs content', 'onelove'),
			'id' 		=> 'prodetail_custom_tabs_content',
			'type' 		=> 'textarea',
			'data'		=> array('depend'=> 'prodetail_custom_tabs', 'value' => 'override'),
			'style' 	=> 'width: 100%; height: 200px; ',
			'std' 		=> catanis_option('prodetail_custom_tabs_content'),
			's_desc'	=> esc_html__( 'Enter custom content here.', 'onelove')
		),
		array(
			'title' 	=> '<div class="ui-icon ui-icon-image"></div>'. esc_html__( 'Related & Up-Sell Products', 'onelove') ,
			'type' 		=> 'heading',
			'extClass' 	=> 'sub-heading'
		),
		array(
			'name' 		=> esc_html__( 'Enable Related products', 'onelove'),
			'id' 		=> 'prodetail_enable_related',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_related'),
			's_desc' 	=> esc_html__( 'If ON, the section related product will be displayed.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Enable Up-Sell products', 'onelove'),
			'id' 		=> 'prodetail_enable_upsells',
			'type' 		=> 'checkbox',
			'std' 		=> catanis_option('prodetail_enable_upsells'),
			's_desc' 	=> esc_html__( 'If ON, the section up-sells product will be displayed.', 'onelove')
		)
	)
);

/*------------------------------------------------------- 
DON'T CHANGE---------------------------------------------*/
$catanis->meta[ basename( __FILE__, ".php") ] = $options;
?>