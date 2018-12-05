<?php
if(!class_exists('Catanis_Visual_Composer')){
	class Catanis_Visual_Composer {
		
		public function __construct(){
			add_action('init', array($this, 'init'), 50);
		}
		
		public function init(){
			if(class_exists('Vc_Manager')){
				add_action('init', array($this, 'visual_builder_init'), 100);
			}
		}
		
		public function visual_builder_init() {
			
			require_once CATANIS_CORE_INC_PATH . '/catanis_visualsc_map.php';
			require_once CATANIS_CORE_INC_PATH . '/catanis_visual_map.php';
			$this->visual_update_params();
			
			/* Build new Shortcodes */
			$shortcodes = array( 'theme-shortcodes', 'woo-shortcodes', 'cata-portfolio', 'cata-blog');
			if ( count( $shortcodes ) > 0 ) {
				foreach ( $shortcodes as $item ) {
					require_once CATANIS_CORE_INC_PATH . '/shortcode/' . $item . '.php';
				}
			}
			
			/* Remove VC elements */
			$vc_elements = array( 'tta_tabs', 'toggle', 'tta_tour', 'tta_accordion', 'tta_pageable',
					'raw_html', 'round_chart', 'line_chart', 'icon', 'masonry_media_grid', 'masonry_grid',
					'basic_grid', 'media_grid', 'custom_heading', 'empty_space', 'clients', 'widget_sidebar',
					'images_carousel', 'carousel', 'tour', 'gallery', 'posts_slider', 'posts_grid', 'teaser_grid',
					'separator', 'text_separator', 'message', 'facebook', 'tweetmeme', 'googleplus', 'pinterest',
					'single_image', 'btn', 'toogle', 'button2', 'cta_button', 'cta_button2', 'video', 'gmaps', 'flickr', 'progress_bar', 'raw_js', 'pie', 'wp_meta', 'wp_recentcomments', 'wp_text', 'wp_calendar', 'wp_pages', 'wp_custommenu', 'wp_posts', 'wp_links', 'wp_categories',
					'wp_archives', 'wp_rss', 'cta', 'wp_search', 'wp_tagcloud', 'button', 'accordion' );
			
			$vc_elements = array( 
				'tabs', 'tour', 'accordion', 'tta_pageable', 'button', 'button2', 'cta_button', 'cta_button2', 
				'empty_space', 'video', 'progress_bar', 'single_image', 
				'separator', 'section', 'message', 'posts_slider', 'btn', 'zigzag', 'hoverbox',
				'gmaps', 'cta', 'basic_grid', 'flickr', 'facebook', 'tweetmeme', 'googleplus', 'pinterest',
				'media_grid', 'masonry_grid', 'masonry_media_grid', 'widget_sidebar', 'line_chart', 'round_chart',
				'pie', 'wp_recentcomments', 'wp_archives', 'wp_rss', 'wp_categories', 'wp_posts', 'wp_text',
				'wp_custommenu', 'wp_tagcloud', 'wp_pages', 'wp_calendar', 'wp_meta', 'wp_search'
			);
			
			//vc_remove_element( 'contact-form-7' );
			foreach ( $vc_elements as $elem ) {
				vc_remove_element( 'vc_'. $elem );
			}
		}
		
		public function visual_update_params() {
			
			/*=== vc_tta_tabs ===*/
			vc_remove_param('vc_tta_tabs', 'title');
			vc_remove_param('vc_tta_tabs', 'shape');
			vc_remove_param('vc_tta_tabs', 'color');
			vc_remove_param('vc_tta_tabs', 'no_fill_content_area');
			vc_remove_param('vc_tta_tabs', 'spacing');
			vc_remove_param('vc_tta_tabs', 'gap');
			vc_remove_param('vc_tta_tabs', 'el_class');
			vc_remove_param('vc_tta_tabs', 'pagination_style');
			vc_remove_param('vc_tta_tabs', 'pagination_color');
			vc_remove_param('vc_tta_tabs', 'style');
			vc_remove_param('vc_tta_tabs', 'alignment');
			vc_remove_param('vc_tta_tabs', 'active_section');
			vc_remove_param('vc_tta_tabs', 'css_animation');
			
			$attributes = array(
				array(
					'heading'			=> esc_html__( 'Main Style', 'catanis-core' ),
					'type'				=> 'ca_vc_preview_image',
					'param_name'		=> 'main_style',
					'simple_mode'		=> false,
					'value'				=> 'style1',
					'options'			=> array(
						'style1'	=> array(
							'name'		=> esc_attr__('Style Default', 'catanis-core'),
							'src'		=> CATANIS_CORE_URL . '/images/preview-images/tabs/style1.jpg'
						),
						'style-icon'	=> array(
							'name'		=> esc_attr__('Style Icon', 'catanis-core'),
							'src'		=> CATANIS_CORE_URL . '/images/preview-images/tabs/style-icon.jpg'
						)
					)
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Alignment', 'catanis-core' ),
					'param_name' 	=> 'alignment',
					'value' 		=> array(
						esc_html__( 'Left', 'catanis-core' ) 		=> 'left',
						esc_html__( 'Right', 'catanis-core' ) 		=> 'right',
						esc_html__( 'Center', 'catanis-core' ) 		=> 'center',
						esc_html__( 'Justify', 'catanis-core' ) 	=> 'justify'
					),
					'std' 			=> 'justify',
					/*'dependency' => array(
						'element' => 'main_style',
						'value' => array('style1', 'style2', 'style3'),
					),*/
					'description' 	=> esc_html__( 'Select tabs section title alignment.', 'catanis-core' )
				),
				array(
					'type' 			=> 'textfield',
					'param_name' 	=> 'active_section',
					'heading' 		=> esc_html__( 'Active section', 'catanis-core' ),
					'value' 		=> 1,
					'description' 	=> esc_html__( 'Enter active section number (Note: to have all sections closed on initial load enter non-existing number).', 'catanis-core' ),
				),
				catanis_vc_extra_class()
			);
			vc_add_params( 'vc_tta_tabs', $attributes );
			
			$arrHide = array('autoplay', 'tab_position');
			foreach ($arrHide as $para){
				$param = WPBMap::getParam( 'vc_tta_tabs', $para );
				$param['edit_field_class'] = 'hide';
				vc_update_shortcode_param( 'vc_tta_tabs', $param );
			}
			
			$settings = array (
				'name' 			=> __( 'Tabs', 'catanis-core' ),
				'category' 		=> esc_html__( 'Catanis Elements', 'catanis-core'),
				'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/tabs.png?x=0|y=0',
			);
			vc_map_update( 'vc_tta_tabs', $settings ); 
			
			
			/*=== vc_tta_tour ===*/
			vc_remove_param('vc_tta_tour', 'title');
			vc_remove_param('vc_tta_tour', 'style');
			vc_remove_param('vc_tta_tour', 'shape');
			vc_remove_param('vc_tta_tour', 'color');
			vc_remove_param('vc_tta_tour', 'no_fill_content_area');
			vc_remove_param('vc_tta_tour', 'spacing');
			vc_remove_param('vc_tta_tour', 'gap');
			vc_remove_param('vc_tta_tour', 'alignment');
			vc_remove_param('vc_tta_tour', 'controls_size');
			vc_remove_param('vc_tta_tour', 'el_class');
			vc_remove_param('vc_tta_tour', 'pagination_style');
			vc_remove_param('vc_tta_tour', 'pagination_color');
			vc_remove_param('vc_tta_tour', 'css_animation');
			vc_remove_param('vc_tta_tour', 'active_section');
			
			$attributes = array(
				array(
					'heading'			=> esc_html__( 'Main Style', 'catanis-core' ),
					'type'				=> 'ca_vc_preview_image',
					'param_name'		=> 'main_style',
					'simple_mode'		=> false,
					'value'				=> 'style1',
					'options'			=> array(
						'style1'	=> array(
							'name'		=> esc_attr__('Style 1', 'catanis-core'),
							'src'		=> CATANIS_CORE_URL . '/images/preview-images/tour/style1.jpg'
						),
						'style2'	=> array(
							'name'		=> esc_attr__('Style 2', 'catanis-core'),
							'src'		=> CATANIS_CORE_URL . '/images/preview-images/tour/style2.jpg'
						)
					)
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Alignment', 'catanis-core' ),
					'param_name' 	=> 'alignment',
					'value' 		=> array(
						esc_html__( 'Left', 'catanis-core' ) 		=> 'left',
						esc_html__( 'Right', 'catanis-core' ) 		=> 'right',
						esc_html__( 'Center', 'catanis-core' ) 		=> 'center'
					),
					'std' 			=> 'left',
					'dependency' => array(
						'element' => 'main_style',
						'value' => array('style1', 'style2'),
					),
					'description' 	=> esc_html__( 'Select tabs section title alignment.', 'catanis-core' )
				),
				array(
					'type' 			=> 'textfield',
					'param_name' 	=> 'active_section',
					'heading' 		=> esc_html__( 'Active section', 'catanis-core' ),
					'value' 		=> 1,
					'description' 	=> esc_html__( 'Enter active section number (Note: to have all sections closed on initial load enter non-existing number).', 'catanis-core' ),
				),
				catanis_vc_extra_class()
			);
			vc_add_params( 'vc_tta_tour', $attributes );
			
			/*update params*/
			$arrHide = array('autoplay', 'tab_position');
			foreach ($arrHide as $para){
				$param = WPBMap::getParam( 'vc_tta_tour', $para );
				$param['edit_field_class'] = 'hide';
				vc_update_shortcode_param( 'vc_tta_tour', $param );
			}
			
			$settings = array (
				'name' => __( 'Tour', 'catanis-core' ),
				'category' => esc_html__( 'Catanis Elements', 'catanis-core'),
				'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/tour.png?x=0|y=0',
			);
			vc_map_update( 'vc_tta_tour', $settings );
			
			
			/*=== vc_tta_accordion ===*/
			vc_remove_param('vc_tta_accordion', 'title');
			vc_remove_param('vc_tta_accordion', 'style');
			vc_remove_param('vc_tta_accordion', 'shape');
			vc_remove_param('vc_tta_accordion', 'color');
			vc_remove_param('vc_tta_accordion', 'no_fill');
			vc_remove_param('vc_tta_accordion', 'spacing');
			vc_remove_param('vc_tta_accordion', 'gap');
			vc_remove_param('vc_tta_accordion', 'el_class');
			
			vc_remove_param('vc_tta_accordion', 'active_section'); 
			vc_remove_param('vc_tta_accordion', 'c_icon'); 
			vc_remove_param('vc_tta_accordion', 'c_align');
			vc_remove_param('vc_tta_accordion', 'c_position');
			vc_remove_param('vc_tta_accordion', 'autoplay');
			vc_remove_param('vc_tta_accordion', 'css_animation');
			
			$attributes = array(
				array(
					'heading'			=> esc_html__( 'Main Style', 'catanis-core' ),
					'type'				=> 'ca_vc_preview_image',
					'param_name'		=> 'main_style',
					'simple_mode'		=> false,
					'admin_label' 		=> true,
					'save_always' 		=> true,
					'value'				=> 'style1',
					'options'			=> array(
						'style1'	=> array(
							'name'		=> esc_attr__('Style 1', 'catanis-core'),
							'src'		=> CATANIS_CORE_URL . '/images/preview-images/accordion/style1.jpg'
						),
						'style2'	=> array(
							'name'		=> esc_attr__('Style 2', 'catanis-core'),
							'src'		=> CATANIS_CORE_URL . '/images/preview-images/accordion/style2.jpg'
						)
					)
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Navigation Icon', 'catanis-core' ),
					'param_name' 	=> 'c_icon',
					'value' 		=> array(
						__( 'None', 'catanis-core' ) 			=> 'none',
						__( 'Angle', 'catanis-core' ) 			=> 'angle ti-angle',
						__( 'Angle Double', 'catanis-core' ) 	=> 'angle-double ti-angle-double',
						__( 'Arrow Circle', 'catanis-core' ) 	=> 'arrow-circle ti-arrow-circle',
						__( 'Plus Circle', 'catanis-core' ) 	=> 'plus-circle fa-plus-circle fa',
						__( 'Caret Down', 'catanis-core' ) 		=> 'caret-down fa-caret-down',
						__( 'Angle Down', 'catanis-core' ) 		=> 'angle-down fa-angle-down'
					),
					'std' 			=> 'caret-down fa-caret-down',
					'dependency' 	=> array(
						'element' 	=> 'main_style',
						'value' 	=> array('style1','style2'),
					), 
					'description' 	=> __( 'Note: Will apply this icon for all Sections, so please do not need to select icon in each Section.', 'catanis-core' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Icon Position', 'catanis-core' ),
					'param_name' 	=> 'icon_position',
					'value' 		=> array(
						esc_html__( 'Left', 'catanis-core' ) 	=> 'left',
						esc_html__( 'Right', 'catanis-core' ) 	=> 'right'
					),
					'std' 			=> 'left',
					'dependency' 	=> array(
						'element' 	=> 'main_style',
						'value' 	=> array('style1', 'style2'),
					),
					'description' 	=> esc_html__( 'Select icon alignment (choose icon in each section).', 'catanis-core' )
				),
				array(
					'type' 			=> 'textfield',
					'param_name' 	=> 'active_section',
					'heading' 		=> esc_html__( 'Active section', 'catanis-core' ),
					'value' 		=> 1,
					'description' 	=> esc_html__( 'Enter active section number (Note: to have all sections closed on initial load enter non-existing number).', 'catanis-core' ),
				),
				catanis_vc_extra_class()
			);
			vc_add_params( 'vc_tta_accordion', $attributes );
			
			/*update params*/
			$arrHide = array('collapsible_all');
			foreach ($arrHide as $para){
				$param = WPBMap::getParam( 'vc_tta_accordion', $para );
				$param['edit_field_class'] = 'hide';
				vc_update_shortcode_param( 'vc_tta_accordion', $param );
			}
			
			$settings = array (
				'name' 		=> __( 'Accordion', 'catanis-core' ),
				'category' 	=> esc_html__( 'Catanis Elements', 'catanis-core'),
				'icon' 		=> CATANIS_CORE_URL.'/images/vcicons/accordion.png?x=0|y=0',
			);
			vc_map_update( 'vc_tta_accordion', $settings );
			
			
			/*=== vc_tta_section ===*/
			vc_remove_param('vc_tta_section', 'add_icon');
			vc_remove_param('vc_tta_section', 'i_icon_fontawesome');
			vc_remove_param('vc_tta_section', 'i_icon_openiconic');
			vc_remove_param('vc_tta_section', 'i_icon_typicons');
			vc_remove_param('vc_tta_section', 'i_icon_entypo');
			vc_remove_param('vc_tta_section', 'i_icon_linecons');
			vc_remove_param('vc_tta_section', 'i_icon_monosocial');
			vc_remove_param('vc_tta_section', 'el_class');
			vc_remove_param('vc_tta_section', 'i_type');
			
			$attributes = array(
				array(
					'type' 				=> 'textfield',
					'param_name' 		=> 'i_type',
					'heading' 			=> esc_html__( 'Icon Type', 'catanis-core' ),
					'admin_label' 		=> false,
					'save_always' 		=> false,
					'value' 			=> 'ti',
					'edit_field_class' 	=> 'hide'
				),
				array(
					'type' => 'checkbox',
					'param_name' => 'add_icon',
					'heading' => __( 'Add icon?', 'catanis-core' ),
					'description' => __( 'Add icon next to section title.', 'catanis-core' ),
				),
				array(
					'type' 				=> 'iconpicker',
					'heading' 			=> esc_html__( 'Select Icon', 'catanis-core' ),
					'param_name' 		=> 'i_icon_ti',
					'value'				=> 'ti-agenda',
					'settings' 			=> array(
						'emptyIcon' 	=> false,
						'type' 			=> 'extensions',
						'iconsPerPage' 	=> 4000,
						'source' 		=> catanis_vc_themify_icons()
					),
					'dependency' => array(
						'element' => 'add_icon',
						'value' => 'true',
					),
					'description' 		=> esc_html__( 'Select icon from library.', 'catanis-core' ),
				),
				catanis_vc_extra_class()
			);
			vc_add_params( 'vc_tta_section', $attributes );
			
			/*update params*/
			$arrHide = array('tab_id', 'i_position');
			foreach ($arrHide as $para){
				$param = WPBMap::getParam( 'vc_tta_section', $para );
				$param['edit_field_class'] = 'hide';
				vc_update_shortcode_param( 'vc_tta_section', $param );
			}
			
			
			/*=== vc_gallery ===*/
			vc_remove_param('vc_gallery', 'title');
			vc_remove_param('vc_gallery', 'css_animation');

			$attributes = array(
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Columns','onelove'),
					'param_name' 	=> 'columns',
					'value' 		=> array(
						esc_html__( '2 Columns', 'onelove' ) 	=> 'cols2',
						esc_html__( '3 Columns', 'onelove' ) 	=> 'cols3',
						esc_html__( '4 Columns', 'onelove') 	=> 'cols4',
						esc_html__( '5 Columns', 'onelove' ) 	=> 'cols5'
					),
					'dependency' 	=> array(
						'element' 	=> 'type',
						'value' 	=> 'image_grid'
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column clear',
					'description' 	=> esc_html__( 'Select columns to show items for Image Grid.', 'onelove' )
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'With Spacing','onelove'),
					'param_name' 	=> 'with_spacing',
					'value' 		=> array(
						esc_html__( 'Yes', 'onelove' ) 	=> '',
						esc_html__( 'No', 'onelove' ) 		=> 'no-spacing'
					),
					'std' => '',
					'dependency' 	=> array(
						'element' 	=> 'type',
						'value' 	=> 'image_grid'
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'description' 	=> esc_html__( 'Show items with spacing.', 'onelove' )
				)
			);
			vc_add_params( 'vc_gallery', $attributes );
			
			/*update params*/
			$arrHide = array('type', 'interval', 'source', 'images', 'custom_srcs', 'img_size', 'external_img_size', 'onclick', 'custom_links', 'custom_links_target' ,'columns', 'with_spacing', 'el_class');
			foreach ($arrHide as $para){
				$param = WPBMap::getParam( 'vc_gallery', $para );
				$param['weight'] = 1;
			
				vc_update_shortcode_param( 'vc_gallery', $param );
			}
			
			$settings = array (
				'name' 		=> __( 'Image Gallery', 'catanis-core' ),
				'category' 	=> esc_html__( 'Catanis Elements', 'catanis-core'),
				'icon' 		=> CATANIS_CORE_URL.'/images/vcicons/image-gallery.png?x=0|y=0',
			);
			vc_map_update( 'vc_gallery', $settings );
			
			
			/*=== vc_images_carousel ===*/
			vc_remove_param('vc_images_carousel', 'title');
			vc_remove_param('vc_images_carousel', 'partial_view');
			vc_remove_param('vc_images_carousel', 'css_animation');
			
			$settings = array (
				'name' 		=> __( 'Image Carousel', 'catanis-core' ),
				'category' 	=> esc_html__( 'Catanis Elements', 'catanis-core'),
				'icon' 		=> CATANIS_CORE_URL.'/images/vcicons/image-carousel.png?x=0|y=0',
			);
			vc_map_update( 'vc_images_carousel', $settings );
			
			
			/*Element VC*/
			$cate_title = esc_html__( 'Visual Elements', 'catanis-core');
			vc_map_update( 'vc_raw_html', array (
				'category' 		=> $cate_title,
				'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/raw-html.png?x=0|y=0',
			) );
			vc_map_update( 'vc_raw_js', array (
				'category' 		=> $cate_title,
				'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/raw-js.png?x=0|y=0',
			) );
			vc_map_update( 'vc_column_text', array (
				'category' 		=> $cate_title,
				'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/text-block.png?x=0|y=0',
			) );
			vc_map_update( 'vc_text_separator', array (
				'category' 		=> $cate_title,
				'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/separator-with-text.png?x=0|y=0',
			) );
			vc_map_update( 'vc_toggle', array (
				'category' 		=> $cate_title,
				'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/faqs.png?x=0|y=0',
			) );
			vc_map_update( 'vc_icon', array (
				'category' 		=> $cate_title,
				'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/icon.png?x=0|y=0',
			) );
			vc_map_update( 'rev_slider', array (
				'category' 		=> $cate_title,
				'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/revolution-slider.png?x=0|y=0',
			) );
			vc_map_update( 'rev_slider_vc', array (
				'category' 		=> $cate_title,
				'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/revolution-slider.png?x=0|y=0',
			) );
			
			
			/*WooCommerce*/
			if ( class_exists( 'WooCommerce' ) ) {
				
				vc_remove_element( 'product_page' );
				vc_remove_element( 'add_to_cart' );
				vc_remove_element( 'add_to_cart_url' );
				/*vc_remove_element( 'product' );
				vc_remove_element( 'product_categories' );
				vc_remove_element( 'woocommerce_cart' );
				vc_remove_element( 'woocommerce_checkout' );
				vc_remove_element( 'woocommerce_my_account' );*/
			
				$settings = array (
					'category' 		=> esc_html__( 'Catanis WooCommerce', 'catanis-core'),
					'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/woo.png?x=0|y=0',
				);
				vc_map_update( 'recent_products', $settings );
				vc_map_update( 'sale_products', $settings );
				vc_map_update( 'best_selling_products', $settings );
				vc_map_update( 'top_rated_products', $settings );
				vc_map_update( 'featured_products', $settings );
				vc_map_update( 'products', $settings );
				vc_map_update( 'product_attribute', $settings );
				vc_map_update( 'product_category', $settings );
				vc_map_update( 'woocommerce_order_tracking', $settings );
				vc_map_update( 'product_categories', $settings );
				
				$settings = array (
					'category' 		=> esc_html__( 'Content', 'catanis-core'),
					'icon' 			=> CATANIS_CORE_URL.'/images/vcicons/woo.png?x=0|y=0',
				);
				vc_map_update( 'product', $settings );
				vc_map_update( 'woocommerce_cart', $settings );
				vc_map_update( 'woocommerce_checkout', $settings );
				vc_map_update( 'woocommerce_my_account', $settings );
			}
			
		}
		
	}
	new Catanis_Visual_Composer();
}