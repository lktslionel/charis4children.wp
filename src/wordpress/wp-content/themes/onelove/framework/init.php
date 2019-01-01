<?php
/*=== DEFINED ALL ===*/
if ( !defined('CATANIS_TEMPLATE_URL' ) ) {
	define('CATANIS_TEMPLATE_URL', get_template_directory_uri());
}

if ( !defined('CATANIS_TEMPLATE_PATH') ) {
	define('CATANIS_TEMPLATE_PATH', trailingslashit( get_template_directory()));
}
if ( !defined('CATANIS_TEMPLATE_CHILD_PATH') ) {
	define('CATANIS_TEMPLATE_CHILD_PATH', trailingslashit( get_stylesheet_directory()));
}

$catanis_theme_data = wp_get_theme();
if(!$catanis_theme_data->Version)	{
	$catanis_theme_data = wp_get_theme();
}

if( !defined('CATANIS_THEME_VERSION') ) {
	define('CATANIS_THEME_VERSION', $catanis_theme_data->Version );
}

if( !defined('CATANIS_THEMENAME') ) {
	define('CATANIS_THEMENAME', $catanis_theme_data->Name );
}

if( !defined('CATANIS_OPTIONS') ) {
	define('CATANIS_OPTIONS', 'catanis_options' );
}

/*Defined for FRAMEWORK*/
if( !defined('CATANIS_FRAMEWORK_PATH') ) {
	define('CATANIS_FRAMEWORK_PATH', CATANIS_TEMPLATE_PATH . 'framework/');
}

if( !defined('CATANIS_FRAMEWORK_URL') ) {
	define('CATANIS_FRAMEWORK_URL', CATANIS_TEMPLATE_URL . '/framework/');
}

if(!defined('CATANIS_IMAGES_URL') ) {
	define('CATANIS_IMAGES_URL', CATANIS_FRAMEWORK_URL . 'images/');
}

if( !defined('CATANIS_SCRIPT_URL') ) {
	define('CATANIS_SCRIPT_URL', CATANIS_FRAMEWORK_URL.'js/');
}

if ( !defined( 'CATANIS_POSTTYPE_PORTFOLIO' ) ){
	define( 'CATANIS_POSTTYPE_PORTFOLIO', 'portfolio' );
}
if ( !defined( 'CATANIS_TAXONOMY_PORTFOLIO' ) ){
	define( 'CATANIS_TAXONOMY_PORTFOLIO', 'portfolio_category' );
}

/*Defined FRONT END*/
if( !defined('CATANIS_FRONT_IMAGES_URL') ) {
	define('CATANIS_FRONT_IMAGES_URL', CATANIS_TEMPLATE_URL.'/images/');
}
if( !defined('CATANIS_DEFAULT_IMAGE') ) {
	define('CATANIS_DEFAULT_IMAGE', CATANIS_FRONT_IMAGES_URL . 'default/no-image.jpg');
}

if( !function_exists('catanis_childtheme_file') ) {

	function catanis_childtheme_file($file) {
		if ( ( CATANIS_TEMPLATE_PATH != CATANIS_TEMPLATE_CHILD_PATH ) && file_exists(trailingslashit(CATANIS_TEMPLATE_CHILD_PATH).$file) )
			$url = trailingslashit(CATANIS_TEMPLATE_CHILD_PATH).$file;
		else
			$url = trailingslashit(CATANIS_TEMPLATE_PATH).$file;
		return $url;
	}
	add_filter('catanis_file_url', 'catanis_childtheme_file', 10, 1);
}

if( !function_exists('required_files_in_array') ) {
	function required_files_in_array( $file_names, $directory ){
		foreach( $file_names as $file ){
			$file_path = $directory . $file . '.php';
			if( file_exists(trailingslashit(CATANIS_TEMPLATE_PATH).$file_path) ){
				require_once( apply_filters('catanis_file_url', $file_path) );
			}
		}
	}
}

/*=== INCLUDE FILES ALL ===*/
/* Include files in functions & setting-api & metaboxes folder */
$functions_file = array('admin-init', 'theme-functions', 'class-default-data', 'class-helper-field', 'sidebars', 'theme-hooks', 'woo-hooks', 'mega-menu');
required_files_in_array($functions_file, 'framework/functions/');

$options_files = array('class-options', 'class-options-builder', 'class-options-manager');
required_files_in_array($options_files, 'framework/setting-api/');

$metaboxes_files = array('class-meta', 'class-meta-builder', 'class-meta-manager');
required_files_in_array($metaboxes_files, 'framework/metaboxes/');

/* Class & Widgets */
$includes_file = array('class-aq-resizer', 'class-mobile-detect', 'class-catanis-love', 'class-catanis-custom-fields-category', 'class-catanis-custom-woo-term', 'class-catanis-breadcrumbs', 'class-catanis-gridlist', 'class-html-compression');
required_files_in_array($includes_file, 'framework/includes/');

/* Visual Composer plugin */
if( catanis_is_visualcomposer_active() ){

	vc_set_shortcodes_templates_dir( CATANIS_FRAMEWORK_PATH . 'vc-extension/templates');
	vc_disable_frontend();
}

/* Admin include */
if ( is_admin() ) {
	require_once( apply_filters('catanis_file_url', 'framework/includes/class-tgm-plugin-activation.php') );
	require_once( apply_filters('catanis_file_url', 'framework/functions/editorbutton/editorbutton.php') );
	new CatanisEditorButton();
}
?>