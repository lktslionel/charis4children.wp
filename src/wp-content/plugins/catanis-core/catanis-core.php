<?php
/*
Plugin Name: Catanis Core
Plugin URI: http://www.catanisthemes.com
Description: Plugin is a part of theme and Only use for OneLove wedding theme, to create shortcodes, custom post types and more...
Author: Catanis Team
Version: 2.3
Author URI: http://www.catanisthemes.com
*/ 
class Catanis_Core_Plugin{
	
	public function __construct(){
		$catanis_theme_data = wp_get_theme();
		
		if ( $catanis_theme_data->template == 'onelove') {
			add_action( 'admin_menu', array( $this, 'add_options_menu' ), 1 );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts_file' ), 101 );
			add_action( 'plugins_loaded', array($this, 'plugin_load_textdomain') );
			$this->init();
		}
	}
	
	public function init(){
		$this->constant();
		add_action( 'after_switch_theme', array( $this, 'my_rewrite_flush' ) );
		add_filter( 'template_include', array( $this, 'load_template_portfolio' ) );
		add_filter( 'pre_get_posts', array( $this, 'modify_query_option' ) );
		
		/* POST TYPE & PRODUCT CUSTOM TERM */
		require_once CATANIS_CORE_INC_PATH . '/catanis_functions_hooks.php';
		require_once CATANIS_CORE_INC_PATH . '/catanis_posttypes.php';
		require_once CATANIS_CORE_INC_PATH . '/widgets/main.php';
		require_once CATANIS_CORE_INC_PATH . '/catanis_vc_composer.php';
		require_once CATANIS_CORE_PATH . '/one-click-demo-import/one-click-demo-import.php';
		require_once CATANIS_CORE_INC_PATH . '/catanis_importer.php';
		
		/* WIDGETS */
		if( !is_admin() && !class_exists('TwitterOAuth')){
			require_once CATANIS_CORE_INC_PATH . '/widgets/extend/OAuth.php';
			require_once CATANIS_CORE_INC_PATH . '/widgets/extend/twitteroauth.php';
		}
	}
	
	public function add_options_menu(){
		global $catanis;

		if ( ! empty( $catanis ) ) {
			$page = add_menu_page(
				CATANIS_THEMENAME . ' Theme Options',
				'Theme Options',
				'edit_theme_options',
				CATANIS_OPTIONS,
				array( $catanis->options_manager, 'print_options_page' ),
				'none'
			);
			add_action("load-{$page}", array( new Catanis_Options(), 'import_data'));
		}
	}
	
	function modify_query_option( $wp_query ) {
		
		/* for paging (important) */
		if ( !is_admin() && (is_tax( 'portfolio_category') || is_tax( 'portfolio_tags') || is_post_type_archive( CATANIS_POSTTYPE_PORTFOLIO )) ) {
			if (function_exists('catanis_option') && catanis_option( 'portfolio_per_page' ) > 0 ) {
				$wp_query->query_vars['posts_per_page'] = catanis_option( 'portfolio_per_page' );
			} 
		}
		
		return $wp_query;
	}
	
	function constant(){
		if ( !defined( 'CATANIS_CORE_URL' ) ){
			define( 'CATANIS_CORE_URL', plugins_url( '', __FILE__ ) );
			define( 'CATANIS_CORE_PATH', plugin_dir_path( __FILE__ ) );
			define( 'CATANIS_CORE_INC_PATH', CATANIS_CORE_PATH . 'includes' );
			define( 'CATANIS_CORE_INC_URL', CATANIS_CORE_URL . '/includes' );
		}
				
		$opts = get_option('catanis_options');
		$rtl = ( (isset($opts['rtl_enable']) && $opts['rtl_enable'] ) || ( function_exists( 'is_rtl' ) && is_rtl() ) ) ? true : false ;
		if( !defined('CATANIS_RTL') ) {
			define('CATANIS_RTL', $rtl);
		}
	
		if( !defined('CATANIS_FRAMEWORK_URL') ) {
			define('CATANIS_FRAMEWORK_URL', get_template_directory_uri() . '/framework/');
		}
				 
		if( !defined('CATANIS_FRONT_IMAGES_URL') ) {
			define('CATANIS_FRONT_IMAGES_URL', get_template_directory_uri() . '/images/');
		}
		
		if( !defined('CATANIS_DEFAULT_IMAGE') ) {
			define('CATANIS_DEFAULT_IMAGE', CATANIS_FRONT_IMAGES_URL . 'default/no-image.jpg');
		}
		
		if ( !defined( 'CATANIS_POSTTYPE_PORTFOLIO' ) ){
			define( 'CATANIS_POSTTYPE_PORTFOLIO', 'portfolio' );
		}
		if ( !defined( 'CATANIS_TAXONOMY_PORTFOLIO' ) ){
			define( 'CATANIS_TAXONOMY_PORTFOLIO', 'portfolio_category' );
		}
	}
	
	function my_rewrite_flush() {
		flush_rewrite_rules();
	}
	
	function plugin_load_textdomain(){
		load_plugin_textdomain( 'catanis-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	
	public function load_template_portfolio( $template_file ) {
		global $wp_query;
		
		if ( is_singular( CATANIS_POSTTYPE_PORTFOLIO ) ) {
			$file = CATANIS_CORE_INC_PATH . '/portfolio/single-portfolio.php';
			if ( file_exists( $file ) ) {
				$template_file = $file;
			}
		}
		 
		if ( is_tax( 'portfolio_category' ) ) {
			$file = CATANIS_CORE_INC_PATH . '/portfolio/taxonomy-portfolio_category.php';
			if ( file_exists( $file ) ) {
				$template_file = $file;
			}
		}
		if ( is_post_type_archive( CATANIS_POSTTYPE_PORTFOLIO ) || is_tax( 'portfolio_tags' )) {
			$file = CATANIS_CORE_INC_PATH . '/portfolio/archive-portfolio.php';
			if ( file_exists( $file ) ) {
				$template_file = $file;
			}
		}
		
		return $template_file;
	}
	
	public function add_scripts_file() {

		wp_register_style( 'catanis-css-shortcode', CATANIS_CORE_URL . '/css/shortcode.css' );
		wp_enqueue_style( 'catanis-css-shortcode' );
		
		/*Script*/
		$google_api_key = 'AIzaSyCwemfIegq-vuXhqMdElQEJXoD2YHJd_xs';
		if( catanis_option( 'google_api_key' ) ) {
			$api_key = catanis_option( 'google_api_key' );
			if( !empty($api_key) ){
				$google_api_key = trim($api_key);
			}
		}
		wp_register_script( 'catanis-js-googleMaps', "http" . ( (is_ssl() ) ? 's' : '') . "://maps.googleapis.com/maps/api/js?v=3&amp;key=". $google_api_key ."&amp;language=" . trim( substr(get_locale(), 0, 2)), false, array(), true);
		wp_register_script( 'catanis-js-gmap3', CATANIS_TEMPLATE_URL . '/js/gmap3.min.js', array('catanis-js-googleMaps'), false, false );
	}
	
	/*Get fuetured image for list items*/
	public static function cata_get_featured_image( $post_ID ) {

		$post_thumbnail_id = get_post_thumbnail_id( $post_ID );
		if ( $post_thumbnail_id ) {
			$post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'featured_preview' );
			return $post_thumbnail_img[0];
		}
	}
}

new Catanis_Core_Plugin();
?>