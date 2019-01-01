<?php
/**
 * ============================================================
 * Description: Contains all the main functionality for initializing and managing the options functionality.
 *
 * @name		Catanis_Options_Manager
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 */
if ( ! class_exists( 'Catanis_Options_Manager' ) ) {
	class Catanis_Options_Manager{
	
		protected $options_obj = null;
	
		function __construct() {
			$this->init();
		}
	
		/**
		 * Inits the main functionality 
		 */
		public function init() {
			$this->options_object = new Catanis_Options();
			add_action( 'wp_ajax_catanis_save_options', array( $this, 'ajax_save_option' ) );
			add_action( 'template_redirect', array( $this, 'export_options_file' ) );
			add_action( 'wp_ajax_catanis_reset_options', array( $this, 'ajax_reset_option' ) );
			
			add_action( 'update_option_catanis_options', array( $this, 'update_styling' ), 10, 2 );
			/*add_action('updated_option', array($this,'update_styling'),10,3);*/
		}
		
		/**
		 * Custom style for theme
		 * 
		 * @return 	Update file style
		 */
		public function update_styling($oldvalue, $_newvalue ) {
			
			global $catanis;
			$catanis->optdata = $this->convert_array_opts( $_newvalue );
				
			/* Save File */
			$upload_dir = wp_upload_dir();
			$file_save = trailingslashit( $upload_dir['basedir'] ) . strtolower( str_replace(' ', '', wp_get_theme()->get('TextDomain') ) ) . '.css';
			$file_content = CATANIS_FRAMEWORK_PATH . 'functions/custom-styling.php';
			catanis_cache_content( $file_save, $file_content ); 
		}
		
		/**
		 * Convert array options to basic array
		 * 
		 * @return 	Basic array options
		 */
		public function convert_array_opts( $array_opts ) {
			$newArr = array();
	
			if( is_array($array_opts)){
				foreach ( $array_opts as $key => $val ) {
					if ( is_array( $val ) && count( $val ) > 0 && !in_array( $key, array( 'sidebars', 'socials' ) ) ) {
						foreach ( $val as $key2 => $val2 ) {
							$newArr[ $key . '_' . $key2 ] = $val2;
						}
					} else {
						$newArr[ $key ] = $val;
					}
				}
			}
			return $newArr;
		} 
		
		/**
		 * Reset setting option by ajax
		 * 
		 * @return 	Json object
		 */
		public function ajax_reset_option() {
			
			$result = $this->options_object->resetThemeOption();
			echo json_encode( $result );
			exit();
		}
		
		/**
		 * Reset setting option by ajax with hook template_redirect
		 *
		 * @return 	File download
		 */
		public function export_options_file(){
			if (isset($_GET['action']) && ($_GET['action'] == 'catanis_export_options')) {
				$this->options_object->export_data_file();
				exit();
			}
		}
		
		/**
		 * Get Catanis_Options object.
		 * 
		 * @return 	Catanis_Options object
		 */		
		public function get_options_obj() {
			
			return $this->options_object;
		}
	
		/**
		 * Save setting option by ajax
		 * 
		 * @return 	Json object
		 */
		public function ajax_save_option() {
			
			$res = $this->options_object->save_data();
			echo json_encode( $res );
			exit();
		}
		
		/**
		 * Print HTML options page
		 * 
		 * @return 	Html
		 */
		public function print_options_page() {
			
			$options_builder = new Catanis_Options_Builder( $this->options_object );
	
			$options_builder->inHeaderOption();
			$options_builder->inOptionsControl();
			$options_builder->inFooterOption();
		}
	
	}
}
?>