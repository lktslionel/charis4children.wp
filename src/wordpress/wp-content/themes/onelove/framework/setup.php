<?php 
/**
 * ============================================================
 * Description: Setup for theme
 *
 * @name		Catanis_Setup
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 */
if ( ! class_exists('Catanis_Setup') ){
	class Catanis_Setup{
		
		protected $options 		= array();
	
		/*=== Construct function ===*/
		public function __construct(){
			$this->init_theme();
			$this->init_options_manager();
			add_action( 'init', array( $this, 'init_options' ) );
			add_action( 'admin_menu', array( $this, 'add_options_menu' ) );
			add_action( 'tgmpa_register', array( $this, 'register_plugins' ) );
			add_action( 'after_switch_theme', array( $this, 'catanis_theme_activation' ) );
			$this->init_metabox_manager();			
		}
		
		/*=== Init theme ===*/
		protected function init_theme(){
		
			add_action( 'after_setup_theme', array( $this, 'catanis_setup_theme' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts_file_first' ), 100 );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts_file' ), 102 );
			add_action( 'get_footer', array( $this, 'register_google_font' ), 100 );
			
			if ( function_exists( 'add_image_size' ) ) {
			
				/*Portfolio*/
				add_image_size( 'catanis-image-small-mini', 480, 400, true );
				add_image_size( 'catanis-image-small-square', 600, 600, true );
				add_image_size( 'catanis-image-medium-rect-vertical', 600, 1200, true );
				add_image_size( 'catanis-image-medium-rect-horizontal', 1200, 600, true );
				add_image_size( 'catanis-image-medium-square', 1200, 1200, true );
			}
		}
		
		/*=== Init after switch theme ===*/
		public function catanis_theme_activation() {
			global $pagenow;
		
			$this->options_def();
			if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == "themes.php" ) {
				
				/* Define image sizes for woocommerce */
				update_option( 'thumbnail_size_w', 150 );
				update_option( 'thumbnail_size_h', 150 );
					
				update_option( 'medium_size_w', 970 );
				update_option( 'medium_size_h', 545 );
					
				update_option( 'large_size_w', 1170 );
				update_option( 'large_size_h', 658 );
					
				/* Define image sizes for woocommerce */
				update_option( 'shop_catalog_image_size', 	array( 'width' => '370', 'height' => '430', 'crop' => 1 ) );
				update_option( 'shop_single_image_size', 	array( 'width' => '500', 'height' => '581', 'crop' => 1 ) );
				update_option( 'shop_thumbnail_image_size', array( 'width' => '120', 'height' => '140', 'crop' => 0 ) );
				
				wp_redirect(admin_url("admin.php?page=catanis_options&activated=true"));
			}
		}
		
		/*=== Init options manager ===*/
		protected function init_options_manager(){
			global $catanis;
	
			$catanis->options_manager = new Catanis_Options_Manager();
			$catanis->options = $catanis->options_manager->get_options_obj();
		}
		
		/*=== Init options ===*/
		public function init_options(){
			global $catanis;
	
			$options_files	= array( 'general', 'header-footer', 'sidebar', 'typography', 'styling', 'blog', 'portfolio' );
			if ( catanis_is_woocommerce_active() ) {
				$options_files[] = 'woocommerce';
			}
			
			$options_files[] = 'import-export';
			foreach ( $options_files as $file ) {
				require_once( apply_filters('catanis_file_url', 'framework/functions/options/' . $file . '.php') );
			}
			$catanis->options->init(); 
	
		}
		
		protected function options_def(){
			global $catanis;
		
			$theme_exist = wp_get_themes();
			if( !get_option(CATANIS_OPTIONS) || !isset($theme_exist['onelove'])){
				$catanis_optdata = array();
				$fields = $catanis->options->get_fields();
				foreach ( $fields as $option ) {
					if ( isset( $option['id'] ) && !in_array( $option['type'], array( 'subtitle', 'title', 'documentation', 'open', 'close', 'import', 'export' ) ) ) {
						$defaultOptions[ $option['id'] ] = $catanis->options->get_default_value( $option );
					}
				}
				update_option( CATANIS_OPTIONS, $defaultOptions );
			
				/* Save File */
				if( is_array($defaultOptions)){
					foreach ( $defaultOptions as $key => $val ) {
						if ( is_array( $val ) && count( $val ) > 0 && !in_array( $key, array( 'sidebars', 'socials' ) ) ) {
							foreach ( $val as $key2 => $val2 ) {
								$catanis_optdata[ $key . '_' . $key2 ] = $val2;
							}
						} else {
							$catanis_optdata[ $key ] = $val;
						}
					}
					$catanis->optdata = $catanis_optdata;
				}
				$upload_dir = wp_upload_dir();
				$file_save = trailingslashit( $upload_dir['basedir'] ) . strtolower( str_replace(' ', '', wp_get_theme()->get('TextDomain') ) ) . '.css';
				$file_content = CATANIS_FRAMEWORK_PATH . 'functions/custom-styling.php';
				catanis_cache_content( $file_save, $file_content );
			}
		}
		
		
		/*=== Menu setting options ===*/
		public function add_options_menu(){
			
			if ( empty ( $GLOBALS['admin_page_hooks'][ 'catanis_options' ] ) ) {
				
				global $catanis;
				add_theme_page(
					CATANIS_THEMENAME . ' Theme Options',
					'Theme Options',
					'edit_theme_options',
					'catanis_options',
					array( $catanis->options_manager, 'print_options_page' ),
					'none'
				);
				
			}
		}
		
		/*=== Init metabox manager ===*/
		protected function init_metabox_manager(){
			
			global $catanis, $pagenow;
			if ( in_array( $pagenow, array( 'post-new.php', 'post.php', 'admin-ajax.php' ) ) || ( isset( $_GET['post_type'] ) && in_array( $_GET['post_type'], array( 'page', CATANIS_POSTTYPE_PORTFOLIO, 'clients', 'teams', 'slider' ) ) ) ) {
			
				$catanis->meta = array();
				add_action( 'init', array( $this, 'init_metabox' ), 10 );
			
				/* init the meta manager object */
				$catanis->meta_manager = new Catanis_Meta_Manager( $catanis->meta );
			}
		}
		
		/*=== Init metabox ===*/
		public function init_metabox(){
			global $catanis;
			
			$meta_files	= array('page', 'post', CATANIS_POSTTYPE_PORTFOLIO, 'testimonials', 'team', 'product');
			foreach ( $meta_files as $file ) {
				if ( file_exists( CATANIS_FRAMEWORK_PATH . 'functions/meta/' . $file . '.php' ) ) {
					require_once( apply_filters('catanis_file_url', 'framework/functions/meta/' . $file . '.php') );
				}
			}
			
			$catanis->meta_manager->set_meta( $catanis->meta );
			$catanis->meta_manager->init();
		}
		
		/*=== Register plugin for theme ===*/
		public function register_plugins() {
			
			$plugins = array(
				array(
					'name'     	 	=> 'Catanis Core',
					'slug'      	=> 'catanis-core',
					'source'    	=> 'http://onelove.catanisthemes.com/plugins_theme/catanis-core.zip',
					'required'  	=> true,
					'version'       => '2.2'
				),
				array(
					'name'               => 'WooCommerce',
					'slug'               => 'woocommerce',
					'required'           => true,
					'version'            => '3.4',
					'force_activation'   => false,
					'force_deactivation' => false
				),
				array(
					'name'          => 'WPBakery Visual Composer',
					'slug'          => 'js_composer',
					'source'        => 'http://catanisthemes.com/plugins_theme/js_composer.zip',
					'required'      => true,
					'version'       => '5.5.4'
				),
				array(
					'name'      	=> 'Revolution Slider',
					'slug'     	 	=> 'revslider',
					'source'        => 'http://catanisthemes.com/plugins_theme/revslider.zip',
					'required'  	=> true,
					'version'       => '5.4.8'
				),
				array(
					'name'      	=> 'Slider Revolution Particles Effect',
					'slug'     	 	=> 'revslider-particles-addon',
					'source'        => 'http://catanisthemes.com/plugins_theme/revslider-particles-addon.zip',
					'required'  	=> true,
					'version'       => '1.0.4'
				),
				array(
					'name'      	=> 'Envato Market',
					'slug'     	 	=> 'envato-market',
					'source'        => 'http://catanisthemes.com/plugins_theme/envato-market.zip',
					'required'  	=> false
				),
				array(
					'name'      	=> 'Contact Form 7',
					'slug'      	=> 'contact-form-7',
					'required'  	=> true,
				)
			);
			
			$config = array(
				'id'           		=> 'tgmpa',                 	/* Unique ID for hashing notices for multiple instances of TGMPA. */
				'domain'       		=> 'onelove',         			/* Text domain - likely want to be the same as your theme. */
				'default_path' 		=> '',                         	/* Default absolute path to pre-packaged plugins */
				'menu'         		=> 'install-required-plugins', 	/* Menu slug */
				'has_notices'      	=> true,                       	/* Show admin notices or not */
				'is_automatic'    	=> true,					   	/* Automatically activate plugins after installation or not */
				'dismissable'  		=> true,                   		/* If false, a user cannot dismiss the nag message. */
				'message' 			=> '',
				'strings'      		=> array(
					'page_title'	=> esc_html__( 'Install Required Plugins', 'onelove' ),
					'menu_title'	=> esc_html__( 'Required Plugins', 'onelove' ),
					'nag_type'		=> 'updated'
				)
			);
			
			tgmpa( $plugins, $config );
		}
		
		/*=== Catanis setup theme ===*/
		public function catanis_setup_theme() {
			
			/* Enable theme support */
			add_editor_style();
			add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', 'gallery' ) );
			add_theme_support( 'post-formats', array('aside', 'gallery', 'quote', 'image', 'video', 'audio', 'link' ) );		
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'woocommerce' );
			add_theme_support( 'title-tag' );
			
			add_theme_support( 'custom-background', $defaults = array(
				'default-color'     => 'ffffff',
				'default-image'     => '',
			) );
			
			/* Make theme available for translation */
			load_theme_textdomain( 'onelove', CATANIS_TEMPLATE_URL . '/languages' );
			load_child_theme_textdomain( 'onelove', get_stylesheet_directory() . '/languages');
			
			$locale = get_locale();
			$locale_file = get_template_directory() . "/languages/$locale.php";
			if ( is_readable( $locale_file ) ){
				require_once( $locale_file );
			}
			
			/* This theme uses wp_nav_menu() in one location. */
			register_nav_menus( array(
				'catanis_main_menu' => esc_html__( 'Catanis Primary Navigation', 'onelove' )				
			) );
			
			$detect = new Mobile_Detect;
			$_is_tablet = $detect->isTablet();
			$_is_mobile = $detect->isMobile() && !$_is_tablet;
			define( 'CATANIS_IS_MOBILE', $_is_mobile );
			define( 'CATANIS_IS_TABLET', $_is_tablet );
		}
		
		/*=== Register google font from Theme Option ===*/
		function register_google_font(){
			
			$font_families		= array();
			$body_font 			= catanis_option( 'body_font' );
			$navi_font 			= catanis_option( 'navigation_font' );
			$navi_dropdown_font	= catanis_option( 'navigation_dropdown_font' );
			$header_font 		= catanis_option( 'page_header_font' );
			$header_sub_font 	= catanis_option( 'page_header_subtitle_font' );
			$googleFonts 		= array( $body_font['family'], $navi_font['family'], $header_font['family'], $header_sub_font['family'], $navi_dropdown_font['family'] );
			$googleFonts 		= array_unique( $googleFonts );
		
			foreach ( $googleFonts as $fontgoogle ) {
				if ( catanis_check_using_google_font( $fontgoogle ) && strlen( trim( $fontgoogle ) ) > 0 ) {
					$font_families[] 	= $fontgoogle . ':400,600,700';
				}
			}
			
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			
			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			
			wp_enqueue_style( 'catanis-css-google-fonts', esc_url_raw( $fonts_url ), array(), null ); 
		}
		
		/*=== Add stylesheet file base on the first ===*/
		function add_scripts_file_first(){
			wp_register_style( 'catanis-css-bootstrap', CATANIS_TEMPLATE_URL . '/css/bootstrap.min.css' );
			wp_enqueue_style( 'catanis-css-bootstrap' );	
		}
		
		/*=== Add script and more stylesheet files for site ===*/
		public function add_scripts_file(){
	
			wp_register_script( 'catanis-js-plugins', CATANIS_TEMPLATE_URL . '/js/jquery.catanis.plugins.js', array('jquery', 'wp-mediaelement' ), CATANIS_THEME_VERSION, true );
			wp_register_script( 'catanis-js-core', CATANIS_TEMPLATE_URL . '/js/core.js', false, false, true );
			wp_register_script( 'catanis-js-videojs', CATANIS_TEMPLATE_URL . '/js/video-js/video.js', false, false, true );
			wp_register_script( 'catanis-js-videojs-youtube', CATANIS_TEMPLATE_URL . '/js/video-js/youtube.js', false, false, true );
			wp_register_script( 'catanis-js-videojs-vimeo', CATANIS_TEMPLATE_URL . '/js/video-js/vjs.vimeo.js', false, false, true );
			wp_register_script( 'catanis-js-YTPlayer', CATANIS_TEMPLATE_URL . '/js/jquery.mb.YTPlayer.js', false, false, true );
			
			wp_register_script( 'catanis-js-html5shiv', CATANIS_TEMPLATE_URL.'/js/html5shiv.js', false, false, false );
			wp_script_add_data( 'catanis-js-html5shiv', 'conditional', 'lt IE 9' );
			
			wp_register_style( 'catanis-css-woocommerce', CATANIS_TEMPLATE_URL . '/css/woocommerce.css' );
			wp_register_style( 'catanis-css-responsive', CATANIS_TEMPLATE_URL . '/css/responsive.css' );
			wp_register_style( 'catanis-css-rtl', CATANIS_TEMPLATE_URL . '/css/rtl.css' );
			
			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_style( 'catanis-css-woocommerce' );
			wp_enqueue_style( 'catanis-style', get_stylesheet_uri() );
			wp_enqueue_style( 'catanis-css-responsive' );
			
			$this->register_custom_style();
			if( !defined('CATANIS_RTL') ) {
				$rtl = false;
				if( catanis_option( 'rtl_enable' ) || ( function_exists( 'is_rtl' ) && is_rtl() ) ){
					$rtl = true;
					wp_enqueue_style( 'catanis-css-rtl' );
				}
				define('CATANIS_RTL', $rtl);
			}
			
			wp_enqueue_script( 'catanis-js-html5shiv' );
			wp_enqueue_script( 'catanis-js-plugins' );
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			
			if( is_singular('product') && catanis_option('prodetail_enable_cloudzoom')){
				wp_register_script( 'catanis-cloud-zoom', CATANIS_TEMPLATE_URL.'/js/cloud-zoom/cloud-zoom.min.js', array('jquery'), null, true);
				wp_enqueue_script( 'catanis-cloud-zoom' );
			}
			
			/* Load script/styles for page templates */
			if (is_page()) {
				$curr_page_template = basename(get_page_template());
				switch($curr_page_template) {
			
					case 'template-coming-soon.php':
						wp_enqueue_script('catanis-js-YTPlayer');
						break;
				}
			}
			
			wp_enqueue_script( 'catanis-js-core' );
			
			$options = array();
			$options['home_url'] = get_home_url();
			$options['theme_uri'] = esc_url(CATANIS_TEMPLATE_URL);
			$options['js_url'] = esc_url(CATANIS_TEMPLATE_URL . '/js/');
			$options['images_url'] = esc_url(CATANIS_FRONT_IMAGES_URL);
			
			$ajax_url = admin_url('admin-ajax.php', 'relative');
			if( defined('ICL_LANGUAGE_CODE') ) {
				$ajax_url = admin_url('admin-ajax.php?lang='.ICL_LANGUAGE_CODE, 'relative');
			} 
			$options['ajax_url'] 			= $ajax_url;
			$options['header_fixed'] 		= catanis_option('header_fixed');
			$options['header_mobile_fixed'] = catanis_option('header_mobile_fixed');
			$options['countdown_label'] 	= array( esc_html__('Years', 'onelove'), esc_html__('Months', 'onelove'), esc_html__('Weeks', 'onelove'), esc_html__('Days', 'onelove'), esc_html__('Hours', 'onelove'), esc_html__('Mins', 'onelove'), esc_html__('Secs', 'onelove') );
			$options['countdown_label1'] 	= array( esc_html__('Year', 'onelove'), esc_html__('Month', 'onelove'), esc_html__('Week', 'onelove'), esc_html__('Day', 'onelove'), esc_html__('Hour', 'onelove'), esc_html__('Min', 'onelove'), esc_html__('Sec', 'onelove') );
			$options['translate_text'] 	= array( 'guests' => esc_html__('Number Of Guests', 'onelove'), 'attending' => esc_html__('What Will You Be Attending', 'onelove') );
			
			wp_localize_script( 'catanis-js-plugins', 'CATANIS', $options );
		}
		
		/*=== Add custom stylesheet file from Theme Options ===*/
		function register_custom_style(){
			
			$upload_dir = wp_upload_dir();
			$filename = trailingslashit( $upload_dir['baseurl'] ) . strtolower(str_replace(' ', '', wp_get_theme()->get('TextDomain'))) . '.css';
			$filename_dir = trailingslashit( $upload_dir['basedir'] ) . strtolower(str_replace(' ', '', wp_get_theme()->get('TextDomain'))) . '.css';
			$optionCss = trim( catanis_option('custom_css') );
			
			if( is_ssl() ){
				$filename = str_replace('http://', 'https://', $filename);
			}
			
			if( file_exists( $filename_dir ) ){
				wp_enqueue_style('catanis-dynamic-css', $filename);
				
				if(!empty($optionCss)){
					wp_add_inline_style( 'catanis-dynamic-css', stripslashes($optionCss) );
				}
			
			} else{
				ob_start();
				require_once( apply_filters('catanis_file_url', 'framework/functions/custom-styling.php') );
				$dynamic_css = ob_get_contents();
				if(!empty($optionCss)){
					$dynamic_css	.= stripslashes($optionCss);
				}
				ob_end_clean(); 
				wp_add_inline_style( 'catanis-css-responsive', $dynamic_css );
			}
		}
		
	}
	
	new Catanis_Setup();	
}
?>