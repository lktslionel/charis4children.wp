<?php
if( !class_exists('Catanis_Default_Data') ){
	class Catanis_Default_Data{
		
		/**
		 * Retrive array value from min to max via +1
		 * 
		 * @param int $max Max value
		 * @param int $min min value
		 * @return array
		 */
		public static function intArray( $max, $min = 1 ) {
			$r = array();
			for ( $i = $min; $i <= $max; $i++ ) {
				$r[$i] = $i;
			}
			return $r;
		}
		
		/**
		 * Retrive array value from min to max via level
		 * 
		 * @param int $max Max value
		 * @param int $min Min value
		 * @param int $level Level to increase  
		 * @return array
		 */
		public static function intArrayLevel( $max, $min = 1, $level = 1 ) {
			$r = array();
			for ( $i = $min; $i <=$max; $i += $level ) {
				$r[$i] = $i;
			}
			return $r;
		}
		
		/**
		 * Calculate distance between 2 date
		 * 
		 * @param date $startDate start date
		 * @param date $endDate end date
		 * @param array $option options array
		 * @return string
		 */
		public static function dateDistance( $startDate = null, $endDate = null, $option = null ) {
		
			/* Convert To Second */
			$int_Date 	= strtotime( $startDate );
			$int_Now	= strtotime( $endDate );
		
			/* Calculate Distance */
			$distance 	= abs( $int_Now - $int_Date );
			$date_format = ( isset($option['date_format'] ) && !empty( $option['date_format'] ) ) ? $option['date_format'] : 'd F, Y';
			$time_format = ( isset($option['time_format'] ) && !empty( $option['time_format'] ) ) ? $option['time_format'] : 'g:i a';
			
			if ( $distance < 60 ) {
				$distance = ($distance < 1) ? 1 : $distance;
				$result = ($distance <= 1) ? $distance . ' second ago' : $distance . ' second ago';
				
			} elseif ( $distance >= 60 && $distance < 3600 ) {
				$distance = round($distance/60);
				$result =  ($distance == 1) ? $distance . ' minute ago' : $distance . ' minute ago';
				
			} elseif ( $distance >= 3600 && $distance < 86400 ) {
				$distance = round( $distance/3600 );
				$result = ( $distance == 1 ) ? $distance . ' hour ago' : $distance . ' hour ago';
				
			} elseif ( (int) ( $distance/86400 ) == 1 ) {
				$result = 'Yesterday at ' . date( $time_format, $int_Date );
			} elseif ( $distance/86400 > 1 ) {
				$result = date( $date_format, $int_Date ) . ' at ' . date( $time_format, $int_Date );
			}
			
			return $result;
		}
		
		/**
		 * Retrive number array
		 * 
		 * @param arrar $options
		 * @return array
		 */
		public static function numberArray( $options = null ) {
			$result = array();
			if ( $options == 'opacity' ) {
				for( $i=1; $i >= 0.1; $i-=0.1 ) {
					$result[] = array( 'name' => (string)$i, 'id' => (string) $i );
				}
				$result[] = array( 'name' => '0', 'id' => '0' );
			}
			return $result;
		}
		
		/**
		 * Retrive data for theme options, depend on param $options in function
		 * 
		 * @param string $type type to check and get value
		 * @param array $options options array
		 * @return array
		 */
		public static function dataOptions( $type = null, $options = null ) {
			$result = array();
			if ( $type == 'pages' ) {
				
				$pages = get_pages( 'sort_column=post_title&hierarchical=0' );
				$result[] = array( 'id' => '', 'name' => '--Choose a page--' );
				foreach ( $pages as $page ) {
					$result[] = array( 'id' => $page->ID, 'name' => $page->post_title );
				}
			} elseif ( $type == 'product-category' ) {
	
				if ( catanis_is_woocommerce_active() ) {
					$cates = get_terms( array( 'product_cat') );
					if ( count( $cates ) > 0 ) {
						$result[] = array( 'id' => 'all-product-category', 'name' => esc_html__('All Categories', 'onelove' ) );
						foreach ( $cates as $cate ) {
							$result[] = array('id' => $cate->slug, 'name' => $cate->name );
						}
					}
				}
				
			}
			
			return $result;
		}
		
		/**
		 * Retrive data for matabox
		 * 
		 * @param string $type type to check and get value
		 * @param array $options options array
		 * @return array
		 */
		public static function metaOptions( $type = null, $options = null ) {
			$result = array();
			if ( $type == 'portfolio-type' ) {
				$result = array( 
					array( 'id' => 'image', 'name' => 'Featured Image' ),
					array( 'id' => 'slider', 'name' => 'Slider' ),
					array( 'id' => 'gallery', 'name' => 'Classic Gallery' ),
					array( 'id' => 'gallery-vertical', 'name' => 'Vertical Gallery' ),
					array( 'id' => 'verticalsticky-sidebar', 'name' => 'Vertical Gallery & Sticky Sidebar' ),
					array( 'id' => 'video', 'name' => 'YouTube/Vimeo Video' ),
					array( 'id' => 'hosted', 'name' => 'HMTL5 Video' ),
					array( 'id' => 'none', 'name' => 'None' )
				);
				
			} elseif ( $type == 'portfolio-thumbnail-type' ) {
				$result = array(
					array( 'id' => 'cata-default-masonry-item', 'name' => 'Regular' ),
					array( 'id' => 'cata-small-height-masonry-item', 'name' => 'Small Height' ),
					array( 'id' => 'cata-large-height-masonry-item', 'name' => 'Large Height' ),
					array( 'id' => 'cata-large-width-masonry-item', 'name' => 'Large Width (only for Masonry Multi Size)' ),
					array( 'id' => 'cata-large-width-height-masonry-item', 'name' => 'Large Width & Height (only for Masonry Multi Size)' )
				);
				
			} elseif ( $type == 'video-type' ) {
				$result = array(
					array( 'id' => 'youtube', 'name' => 'Youtube' ),
					array( 'id' => 'vimeo', 'name' => 'Video' )
				);
	
			} elseif ( $type == 'position-slider' ) {
				$result = array(
					array( 'id' => 'before_header', 'name' => 'Before Header' ),
					array( 'id' => 'after_header', 'name' => 'After header' )
				);
			} elseif ( $type == 'page-slider' ) {
				$result = array(
					array( 'id' => 'none', 'name' => 'No Slider' )
				);
				
				if ( catanis_check_revolution_exists() ) {
					$result[] = array( 'id' => 'revolution', 'name' => 'Revolution Slider' );
				}
					
				if ( catanis_check_layerslider_exists() ) {
					$result[] = array( 'id' => 'layerslider', 'name' => 'Layer Slider' );
				}
				
			} elseif ( $type == 'productslider-option-page' ) {
				
				$result 	= null;
				if ( catanis_is_woocommerce_active() ) {
					$result = array(
						'name' 		=> 'Products slider',
						'id' 		=> 'product_cate',
						'type' 		=> 'select',
						'std' 		=> 'all-product-category',
						'options' 	=> Catanis_Default_Data::dataOptions( 'product-category' )
					);
				}
				
			} elseif ( $type == 'revolution-option-page' ) {
				
				$optionsArr = array();
				$result 	= null;
				if ( catanis_check_revolution_exists() ) {
					$slider = new RevSlider();
					$arrSliders = $slider->getArrSlidersShort();
					
					$optionsArr[] = array( 'id' => '', 'name' => 'Select a slider' );
					if ( count( $arrSliders ) > 0 ) {
						foreach ( $arrSliders as $id => $item ) {
							$optionsArr[] = array( 'id' => $id, 'name' => $item );
						}
					}
			
					$result = array(
						'name' 		=> esc_html__( 'Revolution slider', 'onelove' ),
						'id' 		=> 'page_feature_revslider',
						'type' 		=> 'select',
						's_desc' 	=> 'Select a revolution slider you want.',
						'options' 	=> $optionsArr
					);
					
					if($options['extra-data']){
						$result['data'] = $options['extra-data'];
					}
					
				}
									
			} elseif ( $type == 'layerslider-option-page' ) {
				$optionsArr 	= array();
				$result 	= null;
				if ( catanis_check_layerslider_exists() ) {
					$arrSliders = LS_Sliders::find();
					
					if ( count($arrSliders) > 0 ) {
						foreach ( $arrSliders as $key => $slider ) {
							$optionsArr[] = array( 'id' => $slider['id'], 'name' => $slider['name'] );
						}
					}
					
					$result = array(
						'name' 		=> esc_html__( 'Layer Slider', 'onelove' ),
						'id' 		=> 'layerslider_id',
						'type' 		=> 'select',
						'options' 	=> $optionsArr
					);
				}
			}
			
			return $result; 
			
		} 
		
		/**
		 * Retrive data for Theme Options
		 * 
		 * @param string $type type to check and get value
		 * @param array $options options array
		 * @return array
		 */
		public static function themeOptions( $type = null, $options = null ) {
			$result = array();
			if ( $type == 'color-scheme' ) {
				$result = array( 
					array( 'id' => '#0074A2', 'color' => '#0074A2' ),
					array( 'id' => '#ED6C71', 'color' => '#ED6C71' ),
					array( 'id' => '#3A3A3A', 'color' => '#3A3A3A' ),
					array( 'id' => '#222222', 'color' => '#222222' )
				);
				
			} elseif ( $type == 'menu-style' ) {
				$result = array(
					array( 'id' => 'horizontal', 'name' => 'Horizontal Menu' ),
					array( 'id' => 'vertical', 'name' => 'Vertical Menu' )
				);
				
			} elseif ( $type == 'header-style' ) {
				$result = array(
					array( 'id' => 'style1', 'name' => 'Style 1' ),
					array( 'id' => 'style2', 'name' => 'Style 2' ),
					array( 'id' => 'style3', 'name' => 'Style 3' ),
					array( 'id' => 'style4', 'name' => 'Style 4' ),
					array( 'id' => 'style5', 'name' => 'Style 5' )
				);
				
			} elseif ( $type == 'footer-style' ) {
				$result = array(
					array( 'id' => 'style1', 'name' => 'Style 1 (Home 1 & 2)' ),
					array( 'id' => 'style2', 'name' => 'Style 2 (Home 3)' )
				);
					
			} elseif ( $type == 'bg-pattern' ) {
				$partImg 	= CATANIS_FRONT_IMAGES_URL . 'default/patterns/';
				for ( $i = 1; $i <= 24; $i++ ) {
					$result[] = array(
						'id' 	=> 'pattern' . $i . '.png',
						'img' 	=> $partImg . 'pattern' . $i . '.png',
						'title'	=> 'Pattern ' . $i
					);
				}
				
			} elseif ( $type == 'layout-type' ) {
				
				$partImg 	= CATANIS_IMAGES_URL . 'styles/';
				$result = array(
					array(
						'id' 	=> 'full',
						'img' 	=> $partImg . 'full.png',
						'title'	=> 'Full width'
					),
					array(
						'id' 	=> 'boxed',
						'img' 	=> $partImg . 'boxed.png',
						'title'	=> 'Boxed'
					)
				);
				
			} elseif ( $type == 'sidebar-layout-position' ) {
				$partImg 	= CATANIS_IMAGES_URL . 'styles/';
				$result 	= array(
					array(
						'id' 	=> 'full',
						'img' 	=> $partImg . 'full.png',
						'title'	=> 'No sidebar (Full width)'
					),
					array(
						'id' 	=> 'left',
						'img' 	=> $partImg . '2cl.png',
						'title'	=> 'Left sidebar'
					),
					array(
						'id' 	=> 'right',
						'img' 	=> $partImg . '2cr.png',
						'title'	=> 'Right sidebar'
					)
				);
				
				if( $options['ztype'] == 'meta'){
					array_unshift( $result, array(
						'id' 	=> 'default',
						'img' 	=> $partImg . 'default.png',
						'title'	=> 'Default'
					) );
				}
				
			} elseif ( $type == 'layout-cols' ) {
				$partImg 	= CATANIS_IMAGES_URL . 'styles/';
				$result 	= array(
					array(
						'id' 	=> '1',
						'img' 	=> $partImg . 'one-one.png',
						'title'	=> 'List items'
					),
					array(
						'id' 	=> '2',
						'img' 	=> $partImg . 'one-second.png',
						'title'	=> 'Grid Two columns'
					),
					array(
						'id' 	=> '3',
						'img' 	=> $partImg . 'one-third.png',
						'title'	=> 'Grid Three columns'
					),
					array(
						'id' 	=> '4',
						'img' 	=> $partImg . 'one-fourth.png',
						'title'	=> 'Grid Four columns'
					)
				);
				
			} elseif ( $type == 'portfolio-hover' ) {
				$partImg 	= CATANIS_IMAGES_URL . 'styles/portfolio/';
				$result 	= array(
					array(
						'id' 	=> 'style1',
						'img' 	=> $partImg . 'style1.png',
						'title'	=> 'Style 1'
					),
					array(
						'id' 	=> 'style2',
						'img' 	=> $partImg . 'style2.png',
						'title'	=> 'Style 2'
					),
					array(
						'id' 	=> 'style3',
						'img' 	=> $partImg . 'style3.png',
						'title'	=> 'Style 3'
					)
				);
				
			} elseif ( $type == 'border-style' ) {
				$result = array(
					array( 'id' => 'solid', 'name' => 'Solid' ),
					array( 'id' => 'dashed', 'name' => 'Dashed' ),
					array( 'id' => 'dotted', 'name' => 'Dotted' ),
					array( 'id' => 'none', 'name' => 'None' )
				);
				
			} elseif ( $type == 'backtop-position' ) {
				$result = array(
					array( 'id' => 'right', 'name' => 'Right' ),
					array( 'id' => 'left', 'name' => 'Left' ),
					array( 'id' => 'center', 'name' => 'Center' ),
					array( 'id' => 'none', 'name' => 'None' )
				);
				
			} elseif ( $type == 'columns' ) {
				$prefix = 'col';
				$arrCols = array(
					1 => 'One column', 2 => 'Two column',
					3 => 'Three column', 4 => 'Four column',
					5 => 'Five column', 6 => 'Six column',
					7 => 'Seven column', 8 => 'Eight column',
					9 => 'Nine column', 10 => 'Ten column',
					11 => 'Eleven column', 12 => 'Twelve column'
				);
				
				if ( isset( $options['values'] ) && is_array( $options['values'] ) && count( $options['values'] ) > 0 ) {
					foreach ( $options['values'] as $val ) {
						$result[] = array( 'id' => $prefix . $val, 'name' => $arrCols[$val] );
					}
					
				} else {
					for ( $i = $options['min']; $i <= $options['max']; $i++ ) {
						$result[] = array( 'id' => $prefix . $i, 'name' => $arrCols[$i] );
					}
				}
				
				if ( isset( $options['ztype'] ) && $options['ztype'] == 'footer' ) {
					$result[] = array('id' => 'default', 'name' => 'Don\'t show footer' );
				} else {
					$result[] = array('id' => 'default', 'name' => 'Default');
				}
				
				if ( isset( $options['ztype'] ) && $options['ztype'] == 'cataoption' ) {
					array_pop( $result );
				}
				
			} elseif ( $type == 'text-transform' ) {
				$result = array(
					array( 'id' => 'none', 'name' => 'None' ),
					array( 'id' => 'capitalize', 'name' => 'Capitalize' ),
					array( 'id' => 'uppercase', 'name' => 'Uppercase' ),
					array( 'id' => 'lowercase', 'name' => 'Lowercase' ),
					array( 'id' => 'initial', 'name' => 'Initial' ),
					array( 'id' => 'inherit', 'name' => 'Inherit' )
				);
				
			} elseif ( $type == 'font-weight-style' ) {
				$result = array(
					array( 'id' => '400', 'name' => 'Normal 400' ),
					array( 'id' => '600', 'name' => 'Bold 600' ),
					array( 'id' => '400i', 'name' => 'Normal 400 Italic' ),
					array( 'id' => '600i', 'name' => 'Bold 600 Italic' )
				);
				
			} elseif ( $type == 'sharebox-link' ) {
				$result = array(
					array( 'id' => 'facebook', 'name' => 'Facebook link' ),
					array( 'id' => 'twitter', 'name' => 'Twitter link' ),
					array( 'id' => 'google', 'name' => 'Google Plus link' ),
					array( 'id' => 'pinterest', 'name' => 'Pinterest link' ),
					array( 'id' => 'linkedin', 'name' => 'Linkedin link' ),
					array( 'id' => 'vk', 'name' => 'VK link (vk.com)' ),
					array( 'id' => 'email', 'name' => 'Email link' )
				);
				
			} elseif ( $type == 'payment-icons' ) {
				$result = array(
					array( 'id' => 'payment_paypal', 'name' => 'Paypal' ),
					array( 'id' => 'payment_mastercard', 'name' => 'MasterCard' ),
					array( 'id' => 'payment_visa', 'name' => 'Visa' ),
					array( 'id' => 'payment_americanexpress', 'name' => 'American Express' ), 
					array( 'id' => 'payment_dhl', 'name' => 'DHL Express' ),
					array( 'id' => 'payment_discover', 'name' => 'Discover' ),
					array( 'id' => 'payment_fedex', 'name' => 'FedEx Express' ),
					array( 'id' => 'payment_echeck', 'name' => 'eCheck' ),
					array( 'id' => 'payment_maestro', 'name' => 'Maestro' ),
					array( 'id' => 'payment_jcb', 'name' => 'JCB' ),
					array( 'id' => 'payment_worldpay', 'name' => 'WorldPay' ),
					array( 'id' => 'payment_2co', 'name' => '2CheckOut' ),
				);
				
				if ( $options['task'] == 'show' ) {
					$arrNew = array();
					foreach ( $result as $key => $val ) {
						$arrNew[$val['id']] = $val;
					}
					
					$result = $arrNew;
				}
				
			} elseif ( $type == 'search-type' ) {
				$result = array(
					array( 'id' => 'all', 'name' => 'All' )
				);
				
				$arr_posttype = get_post_types( array('public' => true, 'exclude_from_search' => false ) );
				foreach ($arr_posttype as $val){
					if($val != 'attachment'){
						$result[] = array( 'id' => $val, 'name' => ucwords($val) );
					}
				}
				
			} elseif ( $type == 'gridlist-toggle' ) {
				$result = array(
					array( 'id' => 'grid', 'name' => 'Grid View' ),
					array( 'id' => 'list', 'name' => 'List View' )
				);
				
			} elseif ( $type == 'portfolio-columns' ) {
				$partImg 	= CATANIS_IMAGES_URL . 'styles/';
				$result = array(
					array(
						'id' 	=> '2',
						'img' 	=> $partImg . 'one-second.png',
						'title'	=> 'Grid Two columns'
					),
					array(
						'id' 	=> '3',
						'img' 	=> $partImg . 'one-third.png',
						'title'	=> 'Grid Three columns'
					),
					array(
						'id' 	=> '4',
						'img' 	=> $partImg . 'one-fourth.png',
						'title'	=> 'Grid Four columns'
					)
				);
				
			} elseif ( $type == 'navigations' ) {
				$menus = wp_get_nav_menus();
				if ( ! empty( $menus ) ) {
					$result[] = array('id' => '', 'name' => esc_html__( 'Default', 'onelove' ));
					foreach ( $menus as $item ) {
						$result[] = array('id' => $item->term_id, 'name' => $item->name);
					}
				}
				
			} elseif ( $type == 'portfolio-layout' ) {
				$result = array(
					array( 'id' => 'default', 'name' => 'Default (in container)' ),
					array( 'id' => 'fullwith-dark', 'name' => 'Full Width Layout - Dark Background' ),
					array( 'id' => 'fullwith-white', 'name' => 'Full Width Layout - White Background' )
				);
					
			}else{
				
			}
			
			return $result;
		}
		
		/**
		 * Retrive socials icons depend on $type
		 * 
		 * @param string $type type to check and get value
		 * @param array $options options array
		 * @return array
		 */
		public static function socialIcons( $type = null, $options = null ) {
			$result = array();
			if ( $type == 'image' ) {
				$icons = array(
					'facebook.png' 		=> 'Facebook',
					'twitter.png' 		=> 'Twitter',
					'googleplus.png' 	=> 'Google Plus',
					'rss.png' 			=> 'Rss',
					'pinterest.png' 	=> 'Pinterest',
					'flickr.png' 		=> 'Flickr',
					'delicious.png' 	=> 'Delicious',
					'skype.png' 		=> 'Skype',
					'youtube.png' 		=> 'Youtube',
					'vimeo.png' 		=> 'Vimeo',
					'blogger.png' 		=> 'Blogger',
					'linkedin.png' 		=> 'Linkedin',
					'reddit.png' 		=> 'Reddit',
					'dribbble.png' 		=> 'Dribbble',
					'forrst.png'		=> 'Forrst',
					'deviant-art.png'	=> 'Deviant Art',
					'github.png'		=> 'Github',
					'lastfm.png'		=> 'Lastfm',
					'sharethis.png' 	=> 'ShareThis',
					'stumbleupon.png'	=> 'StumbleUpon',
					'tumblr.png'		=> 'Tumblr',
					'wordpress.png'		=> 'WordPress',
					'yahoo.png'			=> 'Yahoo',
					'amazon.png'		=> 'Amazon',
					'apple.png'			=> 'Apple',
					'bing.png'			=> 'Bing',
					'instagram.png'		=> 'Instagram'
				);
				
				foreach ( $icons as $key => $value ) {
					$img = CATANIS_FRONT_IMAGES_URL . 'icons/' . $key;
					$result[] = array( 'image' => $img, 'title' => $value );
				}
				
			} elseif ( $type == 'font' ) { /* font icomoon */
				$icons = array(
					'icon-facebook' 	=> 'Facebook',
					'icon-twitter' 		=> 'Twitter',
					'icon-googleplus' 	=> 'Google Plus',
					'icon-rss' 			=> 'Rss',
					'icon-pinterest' 	=> 'Pinterest',
					'icon-flickr' 		=> 'Flickr',
					'icon-delicious' 	=> 'Delicious',
					'icon-skype' 		=> 'Skype',
					'icon-youtube' 		=> 'Youtube',
					'icon-vimeo' 		=> 'Vimeo',
					'icon-blogger' 		=> 'Blogger',
					'icon-linkedin' 	=> 'Linkedin',
					'icon-reddit' 		=> 'Reddit',
					'icon-dribbble'		=> 'Dribbble',
					'icon-forrst'		=> 'Forrst',
					'icon-deviantart'	=> 'Deviant Art',
					'icon-github'		=> 'Github',
					'icon-lastfm'		=> 'Lastfm',
					'icon-share' 		=> 'ShareThis',
					'icon-stumbleupon'	=> 'StumbleUpon',
					'icon-tumblr'		=> 'Tumblr',
					'icon-wordpress'	=> 'WordPress',
					'icon-yahoo'		=> 'Yahoo',
					'icon-amazon'		=> 'Amazon',
					'icon-apple'		=> 'Apple',
					'icon-instagram'	=> 'Instagram',
					'icon-google-drive'	=> 'Google Drive',
					'icon-smashing'		=> 'Smashing Magazine',
					'icon-behance'		=> 'Behance',
					'icon-picasa'		=> 'Picasa',
					'icon-yelp'			=> 'Yelp',
					'icon-mixi'			=> 'Mixi'
				);
				
				if ( $options == 'awesome' ) { /* font awesome */
					$icons = array(
						'fa-facebook' 		=> 'Facebook',
						'fa-twitter' 		=> 'Twitter',
						'fa-google-plus' 	=> 'Google Plus',
						'fa-pinterest' 		=> 'Pinterest',
						'fa-instagram'		=> 'Instagram',
						'fa-linkedin' 		=> 'Linkedin',
						'fa-youtube-play' 	=> 'Youtube',
						'fa-vimeo' 			=> 'Vimeo',
						'fa-flickr' 		=> 'Flickr',
						'fa-behance'		=> 'Behance',
						'fa-digg'			=> 'Digg',
						'fa-dribbble'		=> 'Dribbble',
						'fa-skype' 			=> 'Skype',
						'fa-yahoo'			=> 'Yahoo',
						'fa-soundcloud'		=> 'Soundcloud',
						'fa-wordpress'		=> 'WordPress',
						'fa-rss' 			=> 'Rss',
						'fa-envelope-o' 	=> 'Mail',
						'fa-tumblr'			=> 'Tumblr',
						'fa-deviantart'		=> 'Deviantart',
						'fa-delicious' 		=> 'Delicious',
						'fa-yelp'			=> 'Yelp',
						'fa-yoast'			=> 'Yoast',
						'fa-windows'		=> 'Windows',
						'fa-stumbleupon'	=> 'StumbleUpon',
						'fa-medium'			=> 'Medium',
						'fa-xing'			=> 'Xing',
						'fa-apple'			=> 'Apple',
						'fa-amazon'			=> 'Amazon',
						'fa-dropbox' 		=> 'Dropbox',
						'fa-foursquare'		=> 'Foursquare',
						'fa-lastfm'			=> 'LastFM',
						'fa-viadeo'			=> 'Viadeo',
						'fa-tripadvisor'	=> 'TripAdvisor',
						'fa-houzz'			=> 'Houzz',
						'fa-slideshare'		=> 'Slideshare',
						'fa-snapchat-ghost'	=> 'Snapchat',
						'fa-vine'			=> 'Vine',
						'fa-pagelines'		=> 'Pagelines',
						'fa-weibo'			=> 'Weibo',
						'fa-github-alt'		=> 'Github',
						'fa-bandcamp'		=> 'Bandcamp'
					);
				}
				
				foreach ( $icons as $key => $value ) {
					$result[] = array('image' => $key, 'title' => $value );
				}
				
			} elseif ( $type == 'social-style' ) {
				
				$partImg 	= CATANIS_IMAGES_URL . 'styles/socials/';
				$result 	= array(
					array(
						'id' 	=> 'style1',
						'img' 	=> $partImg . 'social_style1.jpg',
						'title'	=> 'Transparent'
					),
					array(
						'id' 	=> 'style2',
						'img' 	=> $partImg . 'social_style2.jpg',
						'title' => 'Color circle'
					),
					array(
						'id' 	=> 'style3',
						'img' 	=> $partImg . 'social_style3.jpg',
						'title' => 'Color square'
					),
					array(
						'id' 	=> 'style4',
						'img' 	=> $partImg . 'social_style4.jpg',
						'title' => 'Transparent circle'
					),
					array(
						'id' 	=> 'style5',
						'img' 	=> $partImg . 'social_style5.jpg',
						'title' => 'Transparent square'
					)
				);
			}
			
			return $result; 
		}
		
		/**
		 * Retrive icon font depend on $type
		 * 
		 * @param string $type type to get
		 * @return array
		 */
		public static function iconFonts( $type = null ) {
			$result = array();
			if ( $type == null ) {
				$icons = array(
					'icon-3d-rotation', 'icon-account-balance', 'icon-account-balance-wallet', 'icon-account-box', 'icon-account-child',
					'icon-account-circle', 'icon-alarm', 'icon-alarm-add', 'icon-alarm-on', 'icon-android', 'icon-announcement', 'icon-aspect-ratio', 'icon-assessment',
					'icon-assignment', 'icon-assignment-ind', 'icon-assignment-late', 'icon-assignment-return', 'icon-assignment-returned','icon-assignment-turned-in', 'icon-autorenew',
					'icon-backup', 'icon-book', 'icon-bookmark', 'icon-bookmark-outline', 'icon-bug-report', 'icon-cached', 'icon-class', 'icon-credit-card', 'icon-dashboard',
					'icon-delete', 'icon-description', 'icon-dns', 'icon-done', 'icon-done-all', 'icon-event', 'icon-exit-to-app', 'icon-explore', 'icon-extension',
					'icon-favorite', 'icon-favorite-outline', 'icon-find-in-page', 'icon-find-replace', 'icon-flip-to-back', 'icon-flip-to-front', 'icon-get-app', 'icon-grade',
					'icon-group-work', 'icon-help', 'icon-highlight-remove', 'icon-history', 'icon-home', 'icon-https', 'icon-info', 'icon-info-outline', 'icon-input',
					'icon-invert-colors', 'icon-label', 'icon-label-outline', 'icon-language', 'icon-launch', 'icon-list', 'icon-lock','icon-lock-outline', 'icon-loyalty',
					'icon-markunread-mailbox', 'icon-note-add', 'icon-open-in-browser', 'icon-open-in-new', 'icon-open-with', 'icon-pageview', 'icon-payment', 'icon-perm-camera-m',
					'icon-perm-contact-cal', 'icon-perm-data-setting', 'icon-perm-identity', 'icon-perm-media', 'icon-perm-phone-msg', 'icon-perm-scan-wifi', 'icon-picture-in-picture',
					'icon-polymer', 'icon-print', 'icon-query-builder', 'icon-question-answer', 'icon-receipt', 'icon-redeem', 'icon-reorder', 'icon-report-problem',
					'icon-restore', 'icon-room', 'icon-search', 'icon-settings', 'icon-settings-applications', 'icon-settings-display', 'icon-settings-ethernet',
					'icon-settings-input-antenna', 'icon-settings-input-component', 'icon-settings-input-hdmi', 'icon-settings-input-svideo', 'icon-settings-overscan', 'icon-shopping-basket',
					'icon-shopping-cart', 'icon-speaker-notes', 'icon-spellcheck', 'icon-star-rate', 'icon-stars', 'icon-store', 'icon-subject', 'icon-supervisor-account',
					'icon-swap-horiz', 'icon-swap-vert', 'icon-swap-vert-circle', 'icon-system-update-tv', 'icon-theaters', 'icon-thumb-up', 'icon-toc', 'icon-today', 'icon-track-changes',
					'icon-translate', 'icon-trending-up', 'icon-turned-in', 'icon-turned-in-not', 'icon-verified-user', 'icon-view-agenda', 'icon-view-array', 'icon-view-carousel',
					'icon-view-column', 'icon-view-day', 'icon-view-headline', 'icon-view-list', 'icon-view-module', 'icon-view-quilt', 'icon-view-stream', 'icon-view-week',
					'icon-visibility', 'icon-visibility-off', 'icon-wallet-giftcard', 'icon-wallet-membership', 'icon-wallet-travel', 'icon-work', 'icon-error', 'icon-warning',
					'icon-album', 'icon-av-timer', 'icon-closed-caption', 'icon-equalizer', 'icon-explicit', 'icon-fast-forward', 'icon-fast-rewind', 'icon-games',
					'icon-hearing', 'icon-high-quality', 'icon-loop', 'icon-mic', 'icon-mnone', 'icon-moff', 'icon-movie', 'icon-my-library-add', 'icon-my-library-books',
					'icon-my-library-mus', 'icon-new-releases', 'icon-not-interested', 'icon-pause', 'icon-pause-circle-fill', 'icon-pause-circle-outline', 'icon-play-arrow',
					'icon-play-circle-fill', 'icon-play-circle-outline', 'icon-play-shopping-bag', 'icon-playlist-add', 'icon-queue', 'icon-queue-mus', 'icon-radio', 'icon-recent-actors',
					'icon-repeat', 'icon-repeat-one', 'icon-replay', 'icon-shuffle', 'icon-skip-next', 'icon-skip-previous', 'icon-snooze', 'icon-stop', 'icon-subtitles',
					'icon-surround-sound', 'icon-video-collection', 'icon-videocam', 'icon-videocam-off', 'icon-volume-down', 'icon-volume-mute', 'icon-volume-off',
					'icon-volume-up', 'icon-web', 'icon-business', 'icon-call', 'icon-call-end', 'icon-call-made', 'icon-call-merge', 'icon-call-missed', 'icon-call-received',
					'icon-call-split', 'icon-chat', 'icon-clear-all', 'icon-comment', 'icon-contacts', 'icon-dialer-sip', 'icon-dialpad', 'icon-dnd-on', 'icon-email',
					'icon-forum', 'icon-import-export', 'icon-invert-colors-off', 'icon-invert-colors-on', 'icon-live-help', 'icon-location-off', 'icon-location-on',
					'icon-message', 'icon-messenger', 'icon-no-sim', 'icon-phone', 'icon-portable-wifi-off', 'icon-quick-contacts-dialer', 'icon-quick-contacts-mail',
					'icon-stay-current-landscape', 'icon-stay-current-portrait', 'icon-swap-calls', 'icon-textsms', 'icon-voicemail', 'icon-vpn-key', 'icon-add', 'icon-add-box',
					'icon-add-circle', 'icon-add-circle-outline', 'icon-archive', 'icon-backspace', 'icon-clear', 'icon-content-copy', 'icon-content-cut', 'icon-content-paste',
					'icon-create', 'icon-drafts', 'icon-filter-list', 'icon-flag', 'icon-forward', 'icon-gesture', 'icon-inbox', 'icon-link', 'icon-mail', 'icon-markunread',
					'icon-redo', 'icon-reply', 'icon-reply-all', 'icon-report', 'icon-save', 'icon-select-all', 'icon-send', 'icon-sort', 'icon-text-format', 'icon-undo',
					'icon-access-alarm', 'icon-access-alarms', 'icon-access-time', 'icon-add-alarm', 'icon-battery-charging-80', 'icon-battery-charging-full', 'icon-battery-full',
					'icon-bluetooth', 'icon-brightness-auto', 'icon-brightness-high', 'icon-brightness-low', 'icon-brightness-medium', 'icon-data-usage', 'icon-developer-mode', 'icon-devices',
					'icon-dvr', 'icon-gps-fixed', 'icon-location-searching', 'icon-multitrack-audio', 'icon-nfc', 'icon-now-wallpaper', 'icon-now-widgets', 'icon-screen-lock-landscape',
					'icon-screen-lock-portrait', 'icon-screen-lock-rotation', 'icon-screen-rotation', 'icon-sd-storage', 'icon-settings-system-daydream', 'icon-storage',
					'icon-usb', 'icon-wifi-tethering', 'icon-attach-file', 'icon-attach-money', 'icon-border-all', 'icon-border-color', 'icon-format-align-justify',
					'icon-format-bold', 'icon-format-color-fill', 'icon-format-color-reset', 'icon-format-color-text', 'icon-format-ital', 'icon-format-line-spacing', 'icon-format-list-bulleted',
					'icon-format-list-numbered', 'icon-format-paint', 'icon-format-quote', 'icon-format-textdirection-l-to-r', 'icon-format-underline', 'icon-insert-chart',
					'icon-insert-comment', 'icon-insert-drive-file', 'icon-insert-emoticon', 'icon-insert-invitation', 'icon-insert-link', 'icon-insert-photo', 'icon-merge-type',
					'icon-mode-comment', 'icon-mode-edit', 'icon-attachment', 'icon-cloud', 'icon-cloud-circle', 'icon-cloud-done', 'icon-cloud-download', 'icon-cloud-queue',
					'icon-cloud-upload', 'icon-file-download', 'icon-file-upload', 'icon-folder', 'icon-folder-open', 'icon-folder-shared', 'icon-cast', 'icon-cast-connected',
					'icon-computer', 'icon-desktop-mac', 'icon-desktop-windows', 'icon-dock', 'icon-gamepad', 'icon-headset', 'icon-headset-m', 'icon-keyboard', 'icon-keyboard-alt',
					'icon-keyboard-arrow-down', 'icon-keyboard-arrow-left', 'icon-keyboard-arrow-right', 'icon-keyboard-arrow-up', 'icon-keyboard-backspace', 'icon-keyboard-capslock',
					'icon-keyboard-control', 'icon-keyboard-hide', 'icon-keyboard-return', 'icon-keyboard-tab', 'icon-keyboard-voice', 'icon-laptop-mac', 'icon-memory', 'icon-mouse',
					'icon-phone-android', 'icon-phone-iphone', 'icon-phonelink', 'icon-security', 'icon-smartphone', 'icon-speaker', 'icon-tablet', 'icon-tablet-android',
					'icon-tablet-mac', 'icon-tv', 'icon-watch', 'icon-add-to-photos', 'icon-adjust', 'icon-assistant-photo', 'icon-audiotrack', 'icon-blur-circular',
					'icon-blur-on', 'icon-brightness-4', 'icon-brightness-5', 'icon-brightness-6', 'icon-brightness-7', 'icon-brush', 'icon-camera', 'icon-camera-alt', 'icon-camera-front',
					'icon-camera-rear', 'icon-camera-roll', 'icon-center-focus-strong', 'icon-center-focus-weak', 'icon-collections', 'icon-color-lens', 'icon-colorize',
					'icon-compare', 'icon-crop-3-2', 'icon-crop-5-4', 'icon-crop-16-9', 'icon-crop', 'icon-crop-din', 'icon-crop-free', 'icon-crop-landscape', 'icon-crop-original',
					'icon-crop-portrait', 'icon-crop-square', 'icon-dehaze', 'icon-details', 'icon-edit', 'icon-exposure', 'icon-exposure-plus-1', 'icon-exposure-plus-2',
					'icon-filter-1', 'icon-filter-2', 'icon-filter-3', 'icon-filter-4', 'icon-filter-5', 'icon-filter-6', 'icon-filter-7', 'icon-filter-8', 'icon-filter-9',
					'icon-filter-9-plus', 'icon-filter', 'icon-filter-b-and-w', 'icon-filter-center-focus', 'icon-filter-drama', 'icon-filter-frames', 'icon-filter-hdr',
					'icon-filter-none', 'icon-filter-tilt-shift', 'icon-filter-vintage', 'icon-flare', 'icon-flash-auto', 'icon-flash-off', 'icon-flash-on', 'icon-gradient',
					'icon-grain', 'icon-grid-on', 'icon-hdr-strong', 'icon-hdr-weak', 'icon-healing', 'icon-image', 'icon-image-aspect-ratio', 'icon-iso', 'icon-landscape',
					'icon-leak-add', 'icon-leak-remove', 'icon-lens', 'icon-looks-3', 'icon-looks-4', 'icon-looks-5', 'icon-looks-6', 'icon-looks', 'icon-looks-one', 'icon-looks-two',
					'icon-loupe', 'icon-movie-creation', 'icon-nature', 'icon-nature-people', 'icon-palette', 'icon-panorama', 'icon-panorama-fisheye', 'icon-panorama-horizontal',
					'icon-panorama-vertical', 'icon-panorama-wide-angle', 'icon-photo', 'icon-photo-album', 'icon-photo-camera', 'icon-photo-library', 'icon-portrait',
					'icon-remove-red-eye', 'icon-rotate-left', 'icon-rotate-right', 'icon-slideshow', 'icon-straighten', 'icon-style', 'icon-switch-camera', 'icon-switch-video',
					'icon-tag-faces', 'icon-texture', 'icon-timelapse', 'icon-timer-3', 'icon-timer-10', 'icon-timer-auto', 'icon-tonality', 'icon-transform', 'icon-tune',
					'icon-wb-auto', 'icon-wb-cloudy', 'icon-wb-incandescent', 'icon-wb-irradescent', 'icon-wb-sunny', 'icon-beenhere', 'icon-directions', 'icon-directions-bike',
					'icon-directions-bus', 'icon-directions-car', 'icon-directions-ferry', 'icon-directions-subway', 'icon-directions-train', 'icon-directions-transit',
					'icon-directions-walk', 'icon-flight', 'icon-hotel', 'icon-layers', 'icon-layers-clear', 'icon-local-airport', 'icon-local-atm', 'icon-local-attraction',
					'icon-local-bar', 'icon-local-cafe', 'icon-local-car-wash', 'icon-local-convenience-store', 'icon-local-drink', 'icon-local-florist', 'icon-local-gas-station',
					'icon-local-grocery-store', 'icon-local-hospital', 'icon-local-hotel', 'icon-local-laundry-service', 'icon-local-library', 'icon-local-mall', 'icon-local-movies',
					'icon-local-offer', 'icon-local-parking', 'icon-local-pharmacy', 'icon-local-phone', 'icon-local-pizza', 'icon-local-play', 'icon-local-post-office',
					'icon-local-print-shop', 'icon-local-restaurant', 'icon-local-see', 'icon-local-shipping', 'icon-local-taxi', 'icon-location-history', 'icon-map',
					'icon-my-location', 'icon-navigation', 'icon-pin-drop', 'icon-place', 'icon-rate-review', 'icon-restaurant-menu', 'icon-satellite', 'icon-store-mall-directory',
					'icon-terrain', 'icon-traff', 'icon-apps', 'icon-arrow-drop-down', 'icon-arrow-drop-down-circle', 'icon-arrow-drop-up', 'icon-cancel', 'icon-check', 'icon-chevron-left',
					'icon-chevron-right', 'icon-close', 'icon-expand-less', 'icon-expand-more', 'icon-fullscreen', 'icon-fullscreen-exit', 'icon-menu', 'icon-more-horiz',
					'icon-more-vert', 'icon-refresh', 'icon-unfold-less', 'icon-unfold-more', 'icon-adb', 'icon-bluetooth-audio', 'icon-drive-eta', 'icon-event-available', 
					'icon-event-busy', 'icon-event-note', 'icon-folder-special', 'icon-mms', 'icon-more', 'icon-play-download', 'icon-play-install', 'icon-sd-card',
					'icon-sim-card-alert', 'icon-sms', 'icon-sms-failed', 'icon-sync', 'icon-system-update', 'icon-tap-and-play', 'icon-time-to-leave', 'icon-vibration',
					'icon-voice-chat', 'icon-vpn-lock', 'icon-cake', 'icon-domain', 'icon-group', 'icon-group-add', 'icon-location-city', 'icon-mood', 'icon-notifications',
					'icon-notifications-none', 'icon-notifications-on', 'icon-notifications-paused', 'icon-pages', 'icon-party-mode', 'icon-people', 'icon-people-outline',
					'icon-person', 'icon-person-add', 'icon-person-outline', 'icon-poll', 'icon-publ', 'icon-school', 'icon-share', 'icon-whatshot', 'icon-check-box',
					'icon-check-box-outline-blank', 'icon-radio-button-off', 'icon-radio-button-on', 'icon-star', 'icon-star-half', 'icon-star-outline', 'icon-dots',
					'icon-facebook', 'icon-twitter', 'icon-googleplus', 'icon-rss', 'icon-pinterest', 'icon-flickr', 'icon-skype' ,
					'icon-youtube', 'icon-vimeo', 'icon-blogger', 'icon-linkedin', 'icon-reddit', 'icon-dribbble', 'icon-forrst', 'icon-deviantart',
					'icon-github', 'icon-lastfm', 'icon-share', 'icon-stumbleupon', 'icon-tumblr', 'icon-wordpress', 'icon-yahoo', 'icon-amazon', 'icon-apple', 
					'icon-instagram', 'icon-google-drive', 'icon-smashing', 'icon-behance', 'icon-picasa', 'icon-yelp', 'icon-delicious', 'icon-yahoo', 'icon-mixi'
				);
				
			} elseif( $type == 'awesome' ) {
				$icons = array(
					'fa-adjus', 'fa-adn', 'fa-align-center', 'fa-align-justify', 'fa-align-left', 'fa-align-right', 'fa-ambulance', 'fa-anchor', 
					'fa-android', 'fa-angellist', 'fa-angle-double-down', 'a-angle-double-left', 'fa-angle-double-right', 'fa-angle-double-up', 
					'fa-angle-down', 'fa-angle-left', 'fa-angle-right', 'fa-angle-up', 'fa-apple', 'fa-archive', 'fa-area-chart', 
					'fa-arrow-circle-down', 'fa-arrow-circle-left', 'fa-arrow-circle-o-down', 'fa-arrow-circle-o-left', 'fa-arrow-circle-o-right', 
					'fa-arrow-circle-o-up', 'fa-arrow-circle-right', 'fa-arrow-circle-up', 'fa-arrow-down', 'fa-arrow-left', 'fa-arrow-right', 
					'fa-arrow-up', 'fa-arrows', 'fa-arrows-alt', 'fa-arrows-h', 'fa-arrows-v', 'fa-asterisk', 'fa-at', 'fa-automobile', 
					'fa-backward', 'fa-ban', 'fa-bank', 'fa-bar-chart', 'fa-bar-chart-o', 'fa-barcode', 'fa-bars', 'fa-bed', 'fa-beer', 
					'fa-behance', 'fa-behance-square', 'fa-bell', 'fa-bell-o', 'fa-bell-slash', 'fa-bell-slash-o', 'fa-bicycle', 'fa-binoculars', 
					'fa-birthday-cake', 'fa-bitbucket', 'fa-bitbucket-square', 'fa-bitcoin', 'fa-bold', 'fa-bolt', 'fa-bomb', 'fa-book', 'fa-bookmark', 
					'fa-bookmark-o', 'fa-briefcase', 'fa-btc', 'fa-bug', 'fa-building', 'fa-building-o', 'fa-bullhorn', 'fa-bullseye', 'fa-bus', 
					'fa-buysellads', 'fa-cab', 'fa-calculator', 'fa-calendar', 'fa-calendar-o', 'fa-camera', 'fa-camera-retro', 'fa-car',  
					'fa-caret-down', 'fa-caret-left', 'fa-caret-right', 'fa-caret-square-o-down', 'fa-caret-square-o-left', 'fa-caret-square-o-right', 
					'fa-caret-square-o-up', 'fa-caret-up', 'fa-cart-arrow-down', 'fa-cart-plus', 'fa-cc', 'fa-cc-amex', 'fa-cc-discover', 
					'fa-cc-mastercard', 'fa-cc-paypal', 'fa-cc-stripe', 'fa-cc-visa', 'fa-certificate', 'fa-chain', 'fa-chain-broken', 'fa-check', 
					'fa-check-circle', 'fa-check-circle-o', 'fa-check-square', 'fa-check-square-o', 'fa-chevron-circle-down', 'fa-chevron-circle-left', 
					'fa-chevron-circle-right', 'fa-chevron-circle-up', 'fa-chevron-down', 'fa-chevron-left', 'fa-chevron-right', 'fa-chevron-up', 
					'fa-child', 'fa-circle', 'fa-circle-o', 'fa-circle-o-notch', 'fa-circle-thin', 'fa-clipboard', 'fa-clock-o', 'fa-close', 'fa-cloud', 
					'fa-cloud-download', 'fa-cloud-upload', 'fa-cny', 'fa-code', 'fa-code-fork', 'fa-codepen', 'fa-coffee', 'fa-cog', 'fa-cogs', 
					'fa-columns', 'fa-comment', 'fa-comment-o', 'fa-comments', 'fa-comments-o', 'fa-compass', 'fa-compress', 'fa-connectdevelop', 
					'fa-copy', 'fa-copyright', 'fa-credit-card', 'fa-crop', 'fa-crosshairs', 'fa-css3', 'fa-cube', 'fa-cubes', 'fa-cut', 'fa-cutlery', 
					'fa-dashboard', 'fa-dashcube', 'fa-database', 'fa-dedent', 'fa-delicious', 'fa-desktop', 'fa-deviantart', 'fa-diamond', 'fa-digg', 
					'fa-dollar', 'fa-dot-circle-o', 'fa-download', 'fa-dribbble', 'fa-dropbox', 'fa-drupal', 'fa-edit', 'fa-eject', 'fa-ellipsis-h', 
					'fa-ellipsis-v', 'fa-empire', 'fa-envelope', 'fa-envelope-o', 'fa-envelope-square', 'fa-eraser', 'fa-eur', 'fa-euro', 'fa-exchange', 
					'fa-exclamation', 'fa-exclamation-circle', 'fa-exclamation-triangle', 'fa-expand', 'fa-external-link', 'fa-external-link-square', 
					'fa-eye', 'fa-eye-slash', 'fa-eyedropper', 'fa-facebook', 'fa-facebook-f', 'fa-facebook-official', 'fa-facebook-square', 
					'fa-fast-backward', 'fa-fast-forward', 'fa-fax', 'fa-female', 'fa-fighter-jet', 'fa-file', 'fa-file-archive-o', 'fa-file-audio-o', 
					'fa-file-code-o', 'fa-file-excel-o', 'fa-file-image-o', 'fa-file-movie-o', 'fa-file-o', 'fa-file-pdf-o', 'fa-file-photo-o', 
					'fa-file-picture-o', 'fa-file-powerpoint-o', 'fa-file-sound-o', 'fa-file-text', 'fa-file-text-o', 'fa-file-video-o', 
					'fa-file-word-o', 'fa-file-zip-o', 'fa-files-o', 'fa-film', 'fa-filter', 'fa-fire', 'fa-fire-extinguisher', 'fa-flag', 
					'fa-flag-checkered', 'fa-flag-o', 'fa-flash', 'fa-flask', 'fa-flickr', 'fa-floppy-o', 'fa-folder', 'fa-folder-o', 'fa-folder-open', 
					'fa-folder-open-o', 'fa-font', 'fa-forumbee', 'fa-forward', 'fa-foursquare', 'fa-frown-o', 'fa-futbol-o', 'fa-gamepad', 'fa-gavel', 
					'fa-gbp', 'fa-ge', 'fa-gear', 'fa-gears', 'fa-genderless', 'fa-gift', 'fa-git', 'fa-git-square', 'fa-github', 'fa-github-alt', 
					'fa-github-square', 'fa-gittip', 'fa-glass', 'fa-globe', 'fa-google', 'fa-google-plus', 'fa-google-plus-square', 'fa-google-wallet', 
					'fa-graduation-cap', 'fa-gratipay', 'fa-groa-h-square', 'fa-hacker-news', 'fa-hand-o-down', 'fa-hand-o-left', 'fa-hand-o-right', 
					'fa-hand-o-up', 'fa-hdd-o', 'fa-header', 'fa-headphones', 'fa-heart', 'fa-heart-o', 'fa-heartbeat', 'fa-history', 'fa-home', 
					'fa-hospital-o', 'fa-hotel', 'fa-html5', 'fa-ils', 'fa-image', 'fa-inbox', 'fa-indent', 'fa-info', 'fa-info-circle', 'fa-inr', 
					'fa-instagram', 'fa-institution', 'fa-ioxhost', 'fa-italic', 'fa-joomla', 'fa-jpy', 'fa-jsfiddle', 'fa-key', 'fa-keyboard-o', 
					'fa-krw', 'fa-language', 'fa-laptop', 'fa-lastfm', 'fa-lastfm-square', 'fa-leaf', 'fa-leanpub', 'fa-legal', 'fa-lemon-o', 
					'fa-level-down', 'fa-level-up', 'fa-life-bouy', 'fa-life-buoy', 'fa-life-ring', 'fa-life-saver', 'fa-lightbulb-o', 'fa-line-chart', 
					'fa-link', 'fa-linkedin', 'fa-linkedin-square', 'fa-linux', 'fa-list', 'fa-list-alt', 'fa-list-ol', 'fa-list-ul', 'fa-location-arrow', 
					'fa-lock', 'fa-long-arrow-down', 'fa-long-arrow-left', 'fa-long-arrow-right', 'fa-long-arrow-up', 'fa-magic', 'fa-magnet', 
					'fa-mail-forward', 'fa-mail-reply', 'fa-mail-reply-all', 'fa-male', 'fa-map-marker', 'fa-mars', 'fa-mars-double', 'fa-mars-stroke', 
					'fa-mars-stroke-h', 'fa-mars-stroke-v', 'fa-maxcdn', 'fa-meanpath', 'fa-medium', 'fa-medkit', 'fa-meh-o', 'fa-mercury', 
					'fa-microphone', 'fa-microphone-slash', 'fa-minus', 'fa-minus-circle', 'fa-minus-square', 'fa-minus-square-o', 'fa-mobile', 
					'fa-mobile-phone', 'fa-money', 'fa-moon-o', 'fa-mortar-board', 'fa-motorcycle', 'fa-music', 'fa-navicon', 'fa-neuter', 
					'fa-newspaper-o', 'fa-openid', 'fa-outdent', 'fa-pagelines', 'fa-paint-brush', 'fa-paper-plane', 'fa-paper-plane-o', 'fa-paperclip',
					'fa-paragraph', 'fa-paste', 'fa-pause', 'fa-paw', 'fa-paypal', 'fa-pencil', 'fa-pencil-square', 'fa-pencil-square-o', 'fa-phone', 
					'fa-phone-square', 'fa-photo', 'fa-picture-o', 'fa-pie-chart', 'fa-pied-piper', 'fa-pied-piper-alt', 'fa-pinterest', 
					'fa-pinterest-p', 'fa-pinterest-square', 'fa-plane', 'fa-play', 'fa-play-circle', 'fa-play-circle-o', 'fa-plug', 'fa-plus', 
					'fa-plus-circle', 'fa-plus-square', 'fa-plus-square-o', 'fa-power-off', 'fa-print', 'fa-puzzle-piece', 'fa-qq', 'fa-qrcode', 
					'fa-question', 'fa-question-circle', 'fa-quote-left', 'fa-quote-right', 'fa-ra', 'fa-random', 'fa-rebel', 'fa-recycle', 'fa-reddit', 
					'fa-reddit-square', 'fa-refresh', 'fa-remove', 'fa-reorder', 'fa-repeat', 'fa-reply', 'fa-reply-all', 'fa-retweet', 'fa-rmb', 
					'fa-road', 'fa-rocket', 'fa-rotate-left', 'fa-rotate-right', 'fa-rouble', 'fa-rss', 'fa-rss-square', 'fa-rub', 'fa-ruble', 
					'fa-rupee', 'fa-save', 'fa-scissors', 'fa-search', 'fa-search-minus', 'fa-search-plus', 'fa-sellsy', 'fa-send', 'fa-send-o', 
					'fa-server', 'fa-share', 'fa-share-alt', 'fa-share-alt-square', 'fa-share-square', 'fa-share-square-o', 'fa-shekel', 'fa-sheqel', 
					'fa-shield', 'fa-ship', 'fa-shirtsinbulk', 'fa-shopping-cart', 'fa-sign-in', 'fa-sign-out', 'fa-signal', 'fa-simplybuilt', 
					'fa-sitemap', 'fa-skyatlas', 'fa-skype', 'fa-slack', 'fa-sliders', 'fa-slideshare', 'fa-smile-o', 'fa-skyatlas', 'fa-skype', 
					'fa-slack', 'fa-sliders', 'fa-slideshare', 'fa-smile-o', 'fa-sort-up', 'fa-soundcloud', 'fa-space-shuttle', 'fa-spinner', 
					'fa-spoon', 'fa-spotify', 'fa-square', 'fa-square-o', 'fa-stack-exchange', 'fa-stack-overflow', 'fa-star', 'fa-star-half', 
					'fa-star-half-empty', 'fa-star-half-full', 'fa-star-half-o', 'fa-star-o', 'fa-steam', 'fa-steam-square', 'fa-step-backward', 
					'fa-step-forward', 'fa-stethoscope', 'fa-stop', 'fa-street-view', 'fa-strikethrough', 'fa-stumbleupon', 'fa-stumbleupon-circle', 
					'fa-subscript', 'fa-subway', 'fa-suitcase', 'fa-sun-o', 'fa-superscript', 'fa-support', 'fa-table', 'fa-tablet', 'fa-tachometer', 
					'fa-tag', 'fa-tags', 'fa-tasks', 'fa-taxi', 'fa-tencent-weibo', 'fa-terminal', 'fa-text-height', 'fa-text-width', 'fa-th', 
					'fa-th-large', 'fa-th-list', 'fa-thumb-tack', 'fa-thumbs-down', 'fa-thumbs-o-down', 'fa-thumbs-o-up', 'fa-thumbs-up', 'fa-ticket', 
					'fa-times', 'fa-times-circle', 'fa-times-circle-o', 'fa-tint', 'fa-toggle-down', 'fa-toggle-left', 'fa-toggle-off', 'fa-toggle-on', 
					'fa-toggle-right', 'fa-toggle-up', 'fa-train', 'fa-transgender', 'fa-transgender-alt', 'fa-trash', 'fa-trash-o', 'fa-tree', 
					'fa-trello', 'fa-trophy', 'fa-truck', 'fa-try ', 'fa-tty', 'fa-tumblr', 'fa-tumblr-square', 'fa-turkish-lira', 'fa-twitch', 
					'fa-twitter ', 'fa-twitter-square', 'fa-umbrella', 'fa-underline', 'fa-undo', 'fa-university ', 'fa-unlink', 'fa-unlock', 
					'fa-unlock-alt', 'fa-unsorted', 'fa-upload', 'fa-usd ', 'fa-user', 'fa-user-md', 'fa-user-plus', 'fa-user-secret', 'fa-user-times', 
					'fa-users', 'fa-venus', 'fa-venus-double', 'fa-venus-mars', 'fa-viacoin', 'fa-video-camera', 'fa-vimeo-square', 'fa-vine', 'fa-vk', 
					'fa-volume-down', 'fa-volume-off', 'fa-volume-up', 'fa-warning', 'fa-wechat', 'fa-weibo', 'fa-weixin ', 'fa-whatsapp', 
					'fa-wheelchair', 'fa-wifi', 'fa-windows', 'fa-won', 'fa-wordpress ', 'fa-wrench', 'fa-xing', 'fa-xing-square', 'fa-yahoo', 
					'fa-yelp', 'fa-yen', 'fa-youtube', 'fa-youtube-play', 'fa-youtube-square'
				);
			}
			
			foreach ( $icons as $value ) {
				$result[] = array( 'image' => $value, 'title' => $value );
			}
			
			return $result;		
		}
		
		/**
		 * Theme Fonts List - System & Google Fonts
		 * 
		 * @param $ztypeType part font that you want get: array('default', 'system', 'popular', 'google') 
		 * @return array	
		 */
		public static function themeFonts( $ztype = array( 'default', 'system', 'popular', 'google' ), $optGroup = true ) {
			$fonts = array();
		
			/* system fonts won`t be downloaded from Google Fonts */
			if ( in_array( 'default', $ztype ) ) {
				$fonts[] = array( 'type'=>'group', 'label'=>'Default Font' );
				$fonts['default'] = array('Open Sans' );
				$fonts[] = array( 'type'=>'groupend' );			
			}
			
			if ( in_array( 'system', $ztype ) ) {
				$fonts[] = array( 'type'=>'group', 'label' => 'System Font' );
				$fonts['system'] = array(
					'Arial',  'Georgia', 'Tahoma', 'Times', 'Trebuchet',  'Verdana'
				);
				$fonts[] = array( 'type' => 'groupend' );
			}
			
			if ( in_array( 'popular', $ztype ) ) {
				$fonts[] = array( 'type' => 'group', 'label' => 'Popular Font' );
				$fonts['popular'] = array(
					'Abel', 'Abril Fatface', 'Acme', 'Adamina', 'Advent Pro', 'Alfa Slab One', 'Alice', 'Allan', 'Amaranth', 'Amatic SC', 'Andika', 'Anonymous Pro',
					'Anton', 'Arimo', 'Bangers', 'Basic', 'Baumans', 'Belgrano', 'Berkshire Swash', 'Bitter', 'Boogaloo', 'Brawler', 'Bree Serif', 'Bubblegum Sans',
					'Buda', 'Cabin Condensed', 'Cabin Sketch', 'Caudex', 'Contrail One', 'Courgette', 'Coustard', 'Crushed', 'Cuprum', 'Damion', 'Days One',
					'Dorsa', 'Droid Sans', 'Droid Serif', 'Duru Sans', 'Enriqueta', 'Federo', 'Francois One', 'Fredericka the Great', 'Fredoka One', 'Goudy Bookletter 1911',
					'Gruppo', 'Homenaje', 'Imprima', 'Inder', 'Istok Web', 'Jockey One', 'Josefin Slab', 'Just Another Hand', 'Kaushan Script', 'Kotta One',
					'Lemon', 'Lobster Two', 'Lobster', 'Maiden Orange', 'Marvel', 'Merienda One', 'Molengo', 'Montserrat', 'News Cycle', 'Niconne', 'Nixie One', 'Nobile', 'Oleo Script',
					'Open Sans', 'Overlock', 'Ovo', 'PT Sans', 'Philosopher', 'Playball', 'Poiret One', 'Quando', 'Quattrocento Sans', 'Quicksand', 'Raleway',
					'Righteous', 'Rokkitt', 'Ropa Sans', 'Sansita One', 'Sofia', 'Source Sans Pro', 'Stoke', 'Titillium Web', 'Ubuntu', 'Wire One', 'Yanone Kaffeesatz', 'Yellowtail'
				);
				$fonts[] = array( 'type'=>'groupend' );
			}
			
			if ( in_array( 'google', $ztype ) ) {
				$fonts[] = array( 'type' => 'group', 'label' => 'Google Font' );
				$fonts['google'] = array(
					'ABeeZee', 'Abel', 'Abril Fatface', 'Aclonica', 'Acme', 'Actor', 'Adamina', 'Advent Pro', 'Aguafina Script', 'Akronim', 'Aladin', 'Aldrich', 'Alef',
					'Alegreya', 'Alegreya SC', 'Alex Brush', 'Alfa Slab One', 'Alice', 'Alike', 'Alike Angular', 'Allan', 'Allerta', 'Allerta Stencil', 'Allura',
					'Almendra', 'Almendra Display', 'Almendra SC', 'Amarante', 'Amaranth', 'Amatic SC', 'Amethysta', 'Anaheim', 'Andada', 'Andika', 'Angkor', 'Annie Use Your Telescope',
					'Anonymous Pro', 'Antic', 'Antic Didone', 'Antic Slab', 'Anton', 'Arapey', 'Arbutus', 'Arbutus Slab', 'Architects Daughter', 'Archivo Black', 'Archivo Narrow', 'Arimo',
					'Arizonia', 'Armata', 'Artifika', 'Arvo', 'Asap', 'Asset', 'Astloch', 'Asul', 'Atomic Age', 'Aubrey', 'Audiowide', 'Autour One', 'Average', 'Average Sans',
					'Averia Gruesa Libre', 'Averia Libre', 'Averia Sans Libre', 'Averia Serif Libre', 'Bad Script', 'Balthazar', 'Bangers', 'Basic', 'Battambang', 'Baumans',
					'Bayon', 'Belgrano', 'Belleza', 'BenchNine', 'Bentham', 'Berkshire Swash', 'Bevan', 'Bigelow Rules', 'Bigshot One', 'Bilbo', 'Bilbo Swash Caps', 'Bitter',
					'Black Ops One', 'Bokor', 'Bonbon', 'Boogaloo', 'Bowlby One', 'Bowlby One SC', 'Brawler', 'Bree Serif', 'Bubblegum Sans', 'Bubbler One', 'Buda', 'Buenard', 'Butcherman',
					'Butterfly Kids', 'Cabin', 'Cabin Condensed', 'Cabin Sketch', 'Caesar Dressing', 'Cagliostro', 'Calligraffitti', 'Cambo', 'Candal', 'Cantarell', 'Cantata One',
					'Cantora One', 'Capriola', 'Cardo', 'Carme', 'Carrois Gothic', 'Carrois Gothic SC', 'Carter One', 'Caudex', 'Cedarville Cursive', 'Ceviche One', 'Changa One',
					'Chango', 'Chau Philomene One', 'Chela One', 'Chelsea Market', 'Chenla', 'Cherry Cream Soda', 'Cherry Swash', 'Chewy', 'Chicle', 'Chivo', 'Cinzel',
					'Cinzel Decorative', 'Clicker Script', 'Coda', 'Coda Caption', 'Codystar', 'Combo', 'Comfortaa', 'Coming Soon', 'Concert One', 'Condiment', 'Content',
					'Contrail One', 'Convergence', 'Cookie', 'Copse', 'Corben', 'Courgette', 'Cousine', 'Coustard', 'Covered By Your Grace', 'Crafty Girls', 'Creepster', 'Crete Round',
					'Crimson Text', 'Croissant One', 'Crushed', 'Cuprum', 'Cutive', 'Cutive Mono', 'Damion', 'Dancing Script', 'Dangrek', 'Dawning of a New Day', 'Days One', 'Delius', 'Delius Swash Caps',
					'Delius Unicase', 'Della Respira', 'Denk One', 'Devonshire', 'Didact Gothic', 'Diplomata', 'Diplomata SC', 'Domine', 'Donegal One', 'Doppio One', 'Dorsa', 'Dosis', 'Dr Sugiyama',
					'Droid Sans', 'Droid Sans Mono', 'Droid Serif', 'Duru Sans', 'Dynalight', 'EB Garamond', 'Eagle Lake', 'Eater', 'Economica', 'Electrolize',
					'Elsie', 'Elsie Swash Caps', 'Emblema One', 'Emilys Candy', 'Engagement', 'Englebert', 'Enriqueta', 'Erica One', 'Esteban', 'Euphoria Script',
					'Ewert', 'Exo', 'Expletus Sans', 'Fanwood Text', 'Fascinate', 'Fascinate Inline', 'Faster One', 'Fasthand', 'Fauna One', 'Federant', 'Federo', 'Felipa', 'Fenix', 'Finger Paint',
					'Fjalla One', 'Fjord One', 'Flamenco', 'Flavors', 'Fondamento', 'Fontdiner Swanky', 'Forum', 'Francois One', 'Freckle Face', 'Fredericka the Great', 'Fredoka One',
					'Freehand', 'Fresca', 'Frijole', 'Fruktur', 'Fugaz One', 'GFS Didot', 'GFS Neohellenic', 'Gabriela', 'Gafata', 'Galdeano', 'Galindo', 'Gentium Basic', 'Gentium Book Basic', 'Geo', 'Geostar',
					'Geostar Fill', 'Germania One', 'Gilda Display', 'Give You Glory', 'Glass Antiqua', 'Glegoo', 'Gloria Hallelujah', 'Goblin One', 'Gochi Hand', 'Gorditas',
					'Goudy Bookletter 1911', 'Graduate', 'Grand Hotel', 'Gravitas One', 'Great Vibes', 'Griffy', 'Gruppo', 'Gudea', 'Habibi', 'Hammersmith One', 'Hanalei', 'Hanalei Fill', 'Handlee', 'Hanuman',
					'Happy Monkey', 'Headland One', 'Henny Penny', 'Herr Von Muellerhoff', 'Holtwood One SC', 'Homemade Apple', 'Homenaje', 'IM Fell DW Pica', 'IM Fell DW Pica SC', 'IM Fell Double Pica',
					'IM Fell Double Pica SC', 'IM Fell English', 'IM Fell English SC', 'IM Fell French Canon', 'IM Fell French Canon SC', 'IM Fell Great Primer', 'IM Fell Great Primer SC',
					'Iceberg', 'Iceland', 'Imprima', 'Inconsolata', 'Inder', 'Indie Flower', 'Inika', 'Irish Grover', 'Istok Web', 'Italiana', 'Italianno', 'Jacques Francois', 'Jacques Francois Shadow',
					'Jim Nightshade', 'Jockey One', 'Jolly Lodger', 'Josefin Sans', 'Josefin Slab', 'Joti One', 'Judson', 'Julee', 'Julius Sans One', 'Junge', 'Jura', 'Just Another Hand',
					'Just Me Again Down Here', 'Kameron', 'Karla', 'Kaushan Script', 'Kavoon', 'Keania One', 'Kelly Slab', 'Kenia', 'Khmer', 'Kite One',
					'Knewave', 'Kotta One', 'Koulen', 'Kranky', 'Kreon', 'Kristi', 'Krona One', 'La Belle Aurore', 'Lancelot', 'Lato', 'League Script', 'Leckerli One', 'Ledger', 'Lekton',
					'Lemon', 'Libre Baskerville', 'Life Savers', 'Lilita One', 'Lily Script One', 'Limelight', 'Linden Hill', 'Lobster', 'Lobster Two', 'Londrina Outline', 'Londrina Shadow', 'Londrina Sketch',
					'Londrina Solid', 'Lora', 'Love Ya Like A Sister', 'Loved by the King', 'Lovers Quarrel', 'Luckiest Guy', 'Lusitana', 'Lustria', 'Macondo', 'Macondo Swash Caps',
					'Magra', 'Maiden Orange', 'Mako', 'Marcellus', 'Marcellus SC', 'Marck Script', 'Margarine', 'Marko One', 'Marmelad', 'Marvel', 'Mate', 'Mate SC', 'Maven Pro',
					'McLaren', 'Meddon', 'MedievalSharp', 'Medula One', 'Megrim', 'Meie Script', 'Merienda', 'Merienda One', 'Merriweather', 'Merriweather Sans', 'Metal', 'Metal Mania',
					'Metamorphous', 'Metrophobic', 'Michroma', 'Milonga', 'Miltonian', 'Miltonian Tattoo', 'Miniver', 'Miss Fajardose', 'Modern Antiqua', 'Molengo', 'Molle', 'Monda', 'Monofett', 'Monoton',
					'Monsieur La Doulaise', 'Montaga', 'Montez', 'Montserrat', 'Montserrat Alternates', 'Montserrat Subrayada', 'Moul', 'Moulpali', 'Mountains of Christmas', 'Mouse Memoirs', 'Mr Bedfort',
					'Mr Dafoe', 'Mr De Haviland', 'Mrs Saint Delafield', 'Mrs Sheppards', 'Muli', 'Mystery Quest', 'Neucha', 'Neuton', 'New Rocker', 'News Cycle',
					'Niconne', 'Nixie One', 'Nobile', 'Nokora', 'Norican', 'Nosifer', 'Nothing You Could Do', 'Noticia Text', 'Noto Sans', 'Noto Serif', 'Nova Cut', 'Nova Flat',
					'Nova Mono', 'Nova Oval', 'Nova Round', 'Nova Script', 'Nova Slim', 'Nova Square', 'Numans', 'Nunito', 'Odor Mean Chey', 'Offside', 'Old Standard TT', 'Oldenburg', 'Oleo Script',
					'Oleo Script Swash Caps', 'Open Sans', 'Open Sans Condensed', 'Oranienbaum', 'Orbitron', 'Oregano', 'Orienta', 'Original Surfer', 'Oswald',
					'Over the Rainbow', 'Overlock', 'Overlock SC', 'Ovo', 'Oxygen', 'Oxygen Mono', 'PT Mono', 'PT Sans', 'PT Sans Caption', 'PT Sans Narrow', 'PT Serif', 'PT Serif Caption',
					'Pacifico', 'Paprika', 'Parisienne', 'Passero One', 'Passion One', 'Pathway Gothic One', 'Patrick Hand', 'Patrick Hand SC', 'Patua One', 'Paytone One', 'Peralta',
					'Permanent Marker', 'Petit Formal Script', 'Petrona', 'Philosopher', 'Piedra', 'Pinyon Script', 'Pirata One', 'Plaster', 'Play', 'Playball',
					'Playfair Display', 'Playfair Display SC', 'Podkova', 'Poiret One', 'Poller One', 'Poly', 'Pompiere', 'Pontano Sans', 'Port Lligat Sans', 'Port Lligat Slab',
					'Prata', 'Preahvihear', 'Press Start 2P', 'Princess Sofia', 'Prociono', 'Prosto One', 'Puritan', 'Purple Purse', 'Quando', 'Quantico', 'Quattrocento', 'Quattrocento Sans', 'Questrial', 'Quicksand',
					'Quintessential', 'Qwigley', 'Racing Sans One', 'Radley', 'Raleway', 'Raleway Dots', 'Rambla', 'Rammetto One', 'Ranchers', 'Rancho', 'Rationale', 'Redressed', 'Reenie Beanie', 'Revalia', 'Ribeye',
					'Ribeye Marrow', 'Righteous', 'Risque', 'Roboto', 'Roboto Condensed', 'Roboto Slab', 'Rochester', 'Rock Salt', 'Rokkitt', 'Romanesco', 'Ropa Sans',
					'Rosario', 'Rosarivo', 'Rouge Script', 'Ruda', 'Rufina', 'Ruge Boogie', 'Ruluko', 'Rum Raisin', 'Ruslan Display', 'Russo One', 'Ruthie', 'Rye', 'Sacramento', 'Sail',
					'Salsa', 'Sanchez', 'Sancreek', 'Sansita One', 'Sarina', 'Satisfy', 'Scada', 'Schoolbell', 'Seaweed Script', 'Sevillana', 'Seymour One', 'Shadows Into Light', 'Shadows Into Light Two',
					'Shanti', 'Share', 'Share Tech', 'Share Tech Mono', 'Shojumaru', 'Short Stack', 'Siemreap', 'Sigmar One', 'Signika', 'Signika Negative', 'Simonetta', 'Sintony',
					'Sirin Stencil', 'Six Caps', 'Skranji', 'Slackey', 'Smokum', 'Smythe', 'Sniglet', 'Snippet', 'Snowburst One', 'Sofadi One', 'Sofia', 'Sonsie One', 'Sorts Mill Goudy',
					'Source Code Pro', 'Source Sans Pro', 'Special Elite', 'Spicy Rice', 'Spinnaker', 'Spirax', 'Squada One', 'Stalemate', 'Stalinist One', 'Stardos Stencil', 'Stint Ultra Condensed', 'Stint Ultra Expanded',
					'Stoke', 'Strait', 'Sue Ellen Francisco', 'Sunshiney', 'Supermercado One', 'Suwannaphum', 'Swanky and Moo Moo', 'Syncopate', 'Tangerine', 'Taprom', 'Tauri',
					'Telex', 'Tenor Sans', 'Text Me One', 'The Girl Next Door', 'Tienne', 'Tinos', 'Titan One', 'Titillium Web', 'Trade Winds', 'Trocchi', 'Trochut', 'Trykker', 'Tulpen One', 'Ubuntu', 'Ubuntu Condensed',
					'Ubuntu Mono', 'Ultra', 'Uncial Antiqua', 'Underdog', 'Unica One', 'UnifrakturCook', 'UnifrakturMaguntia', 'Unkempt', 'Unlock', 'Unna', 'VT323', 'Vampiro One',
					'Varela', 'Varela Round', 'Vast Shadow', 'Vibur', 'Vidaloka', 'Viga', 'Voces', 'Volkhov', 'Vollkorn', 'Voltaire', 'Waiting for the Sunrise',
					'Wallpoet', 'Walter Turncoat', 'Warnes', 'Wellfleet', 'Wendy One', 'Wire One', 'Yanone Kaffeesatz', 'Yellowtail', 'Yeseva One', 'Yesteryear', 'Zeyada', 'Poppins', 'NTR', 'Cormorant Upright'
				);
				
				$fonts[] = array( 'type' => 'groupend' );
			}
		
			/* Font loop */
			$result = array();
			foreach ( $fonts as $key => $value ) {
				if ( is_int( $key ) ) {
					if ( $optGroup ) $result[] = $value;
				} else {
					foreach ( $value as $font ) {
						$result[] = array( 'id' => $font, 'name' => $font );
					}
				}
			}
			return $result;
		}
		
	}
}
?>