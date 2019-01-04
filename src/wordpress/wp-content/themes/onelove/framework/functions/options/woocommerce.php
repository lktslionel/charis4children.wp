<?php
global $catanis;
$catanis_options = array( 
	array(
		'name' 		=> esc_html_x('Woocommerce Settings', 'Theme Options Tab', 'onelove'),
		'type' 		=> 'title',
		'img' 		=> 'icon-shopping-cart',
		'class' 	=> 'bg-violet'
	),
	array(
		'type' 		=> 'open',
		'subtitles'	=> array( 
			array( 'id' => 'general', 'name' 	=> esc_html_x('General', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'page_title', 'name' => esc_html_x('Page Title', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'procate', 'name' 	=> esc_html_x('Shop & Product Category', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'prodetail', 'name' 	=> esc_html_x('Product Single', 'Theme Options Subtab', 'onelove') )
		)
	),

	/*GENERAL SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'general'
	),
	array(
		'name' 		=> esc_html__( 'Enable catalog mode', 'onelove'),
		'id' 		=> 'woo_catalog_mode',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, hide all "Add To Cart" button on your site.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable image hover effect', 'onelove'),
		'id' 		=> 'woo_effect_product',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, show Back Product Image on hover', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable lazy load', 'onelove'),
		'id' 		=> 'woo_enable_lazy_load',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, enable lazy load for products', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Placeholder lazy load', 'onelove'),
		'id' 		=> 'woo_placeholder_lazyload',
		'type' 		=> 'upload',
		'extClass' 	=> 'newrow',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/woo-default-placeholder.gif',
		's_desc' 	=> esc_html__( 'Choose an image for placeholder for lazy load.', 'onelove'),
	),
		
	array(
		'type' 		=> 'documentation',
		'extClass' 	=> 'sub-heading',
		'text' 		=> esc_html__( 'Product Label', 'onelove'),
	),
	array(
		'name' 		=> esc_html__( 'Product Feature Label Text', 'onelove'),
		'id' 		=> 'woo_feature_label_text',
		'type' 		=> 'text',
		'std'		=> 'Hot'
	),
	array(
		'name' 		=> esc_html__( 'Product Out Of Stock Label Text', 'onelove'),
		'id' 		=> 'woo_out_of_stock_label_text',
		'type' 		=> 'text',
		'std'		=> 'Sold out'
	),
	array(
		'name' 		=> esc_html__( 'Product Sale Label Text', 'onelove'),
		'id' 		=> 'woo_sale_label_text',
		'type' 		=> 'text',
		'std'		=> 'Sale'
	),
	array(
		'name' 		=> esc_html__( 'Show Sale Label As', 'onelove'),
		'id' 		=> 'woo_show_sale_label_as',
		'type' 		=> 'select',
		'std' 		=> 'col3',
		's_desc' 	=> esc_html__( 'Select how many columns you want.', 'onelove'),
		'options' 	=> array(
			array( 'id' => 'text', 'name' => 'Text' ),
			array( 'id' => 'number', 'name' => 'Number' ),
			array( 'id' => 'percent', 'name' => 'Percent' )
		),
	),
		
	array('type' 	=> 'close'),
		
	/*PAGE TITLE SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'page_title'
	),
	array(
		'name' 		=> esc_html__( 'Enable Title', 'onelove'),
		'id' 		=> 'woo_page_title_enable',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__('If ON, page title will display in page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Title Style', 'onelove'),
		'id' 		=> 'woo_page_title_style',
		'type' 		=> 'imageradio2',
		's_desc'	=> esc_html__( 'Choose style for the page title', 'onelove'),
		'extClass' 	=> 'newrow',
		'std' 		=> 'style1',
		'options' 	=> array(
				array( "title" => "Style V1", "id" => 'style1', "img" => CATANIS_IMAGES_URL . 'styles/page_title/v1.jpg'),
				array( "title" => "Style V2", "id" => 'style2', "img" => CATANIS_IMAGES_URL . 'styles/page_title/v2.jpg')
		)
	),
	array(
		'name' 		=> esc_html__( 'Enable Breadcrumb', 'onelove'),
		'id' 		=> 'woo_show_breadcrumb',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__('If ON, breadcrumb will display in page title section.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Page Title Position', 'onelove'),
		'id' 		=> 'woo_page_title_position',
		'type' 		=> 'select',
		'std'		=> 'below',
		'options' 	=> array(
			array( 'id' => 'below', 'name' => 'Page Title below Header' ),
			array( 'id' => 'above', 'name' => 'Page Title above Header' )
		),
		'extClass' 	=> 'hide',
		's_desc'	=> esc_html__( 'With this option page title will be shown above or below header section.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Feature Size', 'onelove'),
		'id' 		=> 'woo_page_feature_size',
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
		'id' 		=> 'woo_page_feature_height',
		'type' 		=> 'select',
		'std' 		=> '20',
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
		'data'		=> array('depend'=> 'woo_page_feature_size', 'value' => 'custom-size'),
		's_desc' 	=> esc_html__( 'Choose a value for height', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Feature Min Height', 'onelove'),
		'id' 		=> 'woo_page_feature_minheight',
		'type' 		=> 'text',
		'std' 		=> '150',
		'data'		=> array('depend'=> 'woo_page_feature_size', 'value' => 'custom-size'),
		's_desc' 	=> esc_html__( 'Input min height in px, ex: 200 or 300 or...', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Background Image', 'onelove'),
		'id' 		=> 'woo_page_title_bg',
		'type' 		=> 'upload',
		'extClass' 	=> 'newrow',
		'std' 		=> CATANIS_FRONT_IMAGES_URL . 'default/bg-page-title-woo.jpg',
		's_desc' 	=> esc_html__('Choose an image background for page title.', 'onelove'),
	),
	array(
		'name' 		=> esc_html__('Background Alignment', 'onelove'),
		'id' 		=> 'woo_page_title_bg_alignment',
		'type' 		=> 'select',
		's_desc' 	=> esc_html__('Please choose how you would like your slides background to be aligned.', 'onelove'),
		'std' 		=> 'center',
		'options' 	=> array(
			array( 'id' => 'top', 'name' => 'Top' ),
			array( 'id' => 'center', 'name' => 'Center' ),
			array( 'id' => 'bottom', 'name' => 'Bottom' )
		)
	),
	
	array('type' 	=> 'close'),
		
	/*PRODUCT CATEGORY SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'procate'
	),
	array(
		'name' 		=> esc_html__( 'Number Columns', 'onelove'),
		'id' 		=> 'procate_columns',
		'type' 		=> 'select',
		'std' 		=> 'col3',
		's_desc' 	=> esc_html__( 'Select how many columns you want.', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions( 'columns', array('values' => array( 2, 3, 4), 'ztype' => 'cataoption' ) )
	),
	array(
		'name' 		=> esc_html__( 'Number of products per page', 'onelove'),
		'id' 		=> 'procate_products_per_page',
		'type' 		=> 'text',
		'std'		=> 9,
		's_desc'	=> esc_html__( 'Set the number of products per page', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Sidebar layout', 'onelove'),
		'id' 		=> 'procate_layout',
		'type' 		=> 'styleimage',
		's_desc'	=> esc_html__( 'Set the default sidebar position ( only for Product category page). This setting will be overwritten default layout.', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions( 'sidebar-layout-position' ),
		'std' 		=> 'left'
	),
	array(
		'name' 		=> esc_html__( 'Page sidebar', 'onelove'),
		'id' 		=> 'procate_sidebar',
		'type' 		=> 'select',
		'std' 		=> 'shop_sidebar',
		's_desc' 	=> esc_html__( 'Select a sidebar to show (only for Product category page).', 'onelove'),
		'options' 	=> catanis_get_content_sidebars()
	),
	array(
		'name' 		=> esc_html__( 'Enable product title', 'onelove'),
		'id' 		=> 'procate_enable_title',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product title will be displayed.', 'onelove'),
	),
	array(
		'name' 		=> esc_html__( 'Enable product label', 'onelove'),
		'id' 		=> 'procate_enable_label',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product label will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable product price', 'onelove'),
		'id' 		=> 'procate_enable_price',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product price will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable product sku', 'onelove'),
		'id' 		=> 'procate_enable_sku',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, the product sku will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable product catagories', 'onelove'),
		'id' 		=> 'procate_enable_categories',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product categories will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable product rating', 'onelove'),
		'id' 		=> 'procate_enable_rating',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product rating will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable add to cart button', 'onelove'),
		'id' 		=> 'procate_enable_addtocart',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the button add to cart will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable Grid List', 'onelove'),
		'id' 		=> 'procate_enable_gridlist',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the icon Grid & List will be displayed.', 'onelove'),
	),
	array(
		'name' 		=> esc_html__( 'Grid list button', 'onelove'),
		'id' 		=> 'procate_gridlist',
		'type' 		=> 'multioption',
		's_desc'	=> esc_html__( 'Choose status (show or hide) and number of words in description on Grid mode.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Enable grid list button', 'onelove'),
				'id' 		=> 'enable',
				'type' 		=> 'checkbox',
				'std' 		=> true
			),
			array(
				'name' 		=> esc_html__( 'Default view grid list', 'onelove'),
				'id' 		=> 'default_view',
				'type' 		=> 'select',
				'std' 		=> 'grid',
				'options' 	=> Catanis_Default_Data::themeOptions( 'gridlist-toggle' ),
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Product Description on Grid Mode', 'onelove'),
		'id' 		=> 'procate_desc_grid_mode',
		'type' 		=> 'multioption',
		's_desc'	=> esc_html__( 'Choose status (show or hide) and number of words in description on Grid mode.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Status', 'onelove'),
				'id' 		=> 'status',
				'type' 		=> 'checkbox',
				'std' 		=> false
			),
			array(
				'name' 		=> esc_html__( 'Number of Words', 'onelove'),
				'id' 		=> 'number_words',
				'type' 		=> 'text',
				'std' 		=> '8'
			)
		)
	),
	
	array(
		'name' 		=> esc_html__( 'Product Description on List Mode', 'onelove'),
		'id' 		=> 'procate_desc_list_mode',
		'type' 		=> 'multioption',
		's_desc'	=> esc_html__( 'Choose status (show or hide) and number of words in description on List mode.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Status', 'onelove'),
				'id' 		=> 'status',
				'type' 		=> 'checkbox',
				'std' 		=> true
			),
			array(
				'name' 		=> esc_html__( 'Number of Words', 'onelove'),
				'id' 		=> 'number_words',
				'type' 		=> 'text',
				'std' 		=> '50'
			)
		)
	),
	
	array('type' 	=> 'close'),
	
	/*PRODUCT DETAIL SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'prodetail'
	),
	array(
		'name' 		=> esc_html__( 'Sidebar layout', 'onelove'),
		'id' 		=> 'prodetail_layout',
		'type' 		=> 'styleimage',
		's_desc'	=> esc_html__( 'Set the default sidebar position for Product detail page. This setting will be overwritten default sidebar.', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions('sidebar-layout-position')
	),
	array(
		'name' 		=> esc_html__( 'Page sidebar', 'onelove'),
		'id' 		=> 'prodetail_sidebar',
		'type' 		=> 'select',
		'std' 		=> 'sidebar-primary',
		's_desc' 	=> esc_html__( 'Select a sidebar to show', 'onelove'),
		'options' 	=> catanis_get_content_sidebars(),
	),
	array(
		'name' 		=> esc_html__( 'Enable cloud zoom', 'onelove'),
		'id' 		=> 'prodetail_enable_cloudzoom',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If OFF, product gallery images will open in a lightbox. This option overrides the option of WooCommerce.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Product thumbnails style', 'onelove'),
		'id' 		=> 'prodetail_thumbnails_style',
		'type' 		=> 'select',
		'std' 		=> 'vertical',
		's_desc' 	=> esc_html__( 'Select thumbnails style you want.', 'onelove'),
		'options' 	=> array(
			array( 'id' => 'vertical', 'name' => 'Vertical' ),
			array( 'id' => 'horizontal', 'name' => 'Horizontal' )
		),
	),
	array(
		'name' 		=> esc_html__( 'Enable product title', 'onelove'),
		'id' 		=> 'prodetail_enable_title',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product title will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable product label', 'onelove'),
		'id' 		=> 'prodetail_enable_label',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product label will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable product availability', 'onelove'),
		'id' 		=> 'prodetail_enable_availability',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, the product availability will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable product price', 'onelove'),
		'id' 		=> 'prodetail_enable_price',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product price will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable product rating', 'onelove'),
		'id' 		=> 'prodetail_enable_rating',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product rating will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable product excerpt', 'onelove'),
		'id' 		=> 'prodetail_enable_excerpt',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product excerpt will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable add to cart button', 'onelove'),
		'id' 		=> 'prodetail_enable_addtocart',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product add to cart will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable meta', 'onelove'),
		'id' 		=> 'prodetail_enable_meta',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the meta (SKU, Tags and categories) will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable pagination', 'onelove'),
		'id' 		=> 'prodetail_enable_pagination',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product pagination Next & Previous will be displayed on detail page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable share-box', 'onelove'),
		'id' 		=> 'prodetail_enable_sharebox',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, the share-box will be displayed on post detail page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Show sections sharebox link', 'onelove'),
		'id' 		=> 'prodetail_sharebox_link',
		'type' 		=> 'multicheck',
		'class'		=> 'included',
		's_desc' 	=> esc_html__( 'The theme allows you to display share links to various social media at the bottom of your product detail. Check which links you want to display:', 'onelove'),
		'options' 	=> Catanis_Default_Data::themeOptions( 'sharebox-link' ),
		'std' 		=> array( 'facebook','twitter', 'google' )
	),
	array(
	 	'name' 		=> esc_html__( 'Show shipping & return box', 'onelove'),
		'id' 		=> 'prodetail_enable_shippingbox',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc'	=> esc_html__( 'If ON, the shipping return content will be displayed.', 'onelove')
	),
	array(
		'type' 		=> 'documentation',
		'extClass' 	=> 'sub-heading',
		'text' 		=> esc_html__( 'Product Custom Tabs', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable Product Tabs', 'onelove'),
		'id' 		=> 'prodetail_enable_tabs',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product tabs will be displayed on detail page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable Product Custom Tabs', 'onelove'),
		'id' 		=> 'prodetail_enable_custom_tabs',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the product custom tabs will be displayed on detail page.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Product Custom Tabs Text', 'onelove'),
		'id' 		=> 'prodetail_custom_tabs_title',
		'type' 		=> 'text',
		'std'		=> 'Custom tab'
	),
	array(
		'name' 		=> esc_html__( 'Product Custom Tabs content', 'onelove'),
		'id' 		=> 'prodetail_custom_tabs_content',
		'type' 		=> 'textarea',
		'style' 	=> 'width: 100%; height: 200px; ',
		'std' 		=> 'Add your custom content goes  here. You can use default or change it for individual product.',
		's_desc'	=> esc_html__( 'Enter custom content here.', 'onelove')
	),
	array(
		'type' 		=> 'documentation',
		'extClass' 	=> 'sub-heading',
		'text' 		=> esc_html__( 'Related & Up-Sell Products', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable Related products', 'onelove'),
		'id' 		=> 'prodetail_enable_related',
		'type' 		=> 'checkbox',
		'std' 		=> true,
		's_desc' 	=> esc_html__( 'If ON, the section related product will be displayed.', 'onelove')
	),
	array(
		'name' 		=> esc_html__( 'Enable Up-Sell products', 'onelove'),
		'id' 		=> 'prodetail_enable_upsells',
		'type' 		=> 'checkbox',
		'std' 		=> false,
		's_desc' 	=> esc_html__( 'If ON, the section up-sells product will be displayed.', 'onelove')
	),
	
	array('type' 	=> 'close'),
		
	array('type' 	=> 'close' ) 
);

$catanis->options->add_option_set( $catanis_options );
