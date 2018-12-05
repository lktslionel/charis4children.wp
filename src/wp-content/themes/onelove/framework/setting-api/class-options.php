<?php
 /**
 * ============================================================
 * Description: This class contains all the options management functionality. Initializes page builder object, retrieving options, saving options...
 *
 * @name		Catanis_Options
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 */
if ( ! class_exists( 'Catanis_Options' ) ) {
	class Catanis_Options {
	
		protected $options_to_update 	= array();
		protected $saved_options 		= array();
		protected $fields 				= array();
		public $errors					= array(
			"empty_post" 		=> "Error: Data is empty",
			"file_error" 		=> "Error: File import error",
			"invalid_nonce" 	=> "Error: Nonce field did not verify",
			"invalid_action" 	=> "Error: The action you have requested is invalid",
			"user_cap" 			=> "Error: You are not allowed to edit the Theme Options",
			"no_feed_defined"	=> "Error: No feed defined",
			"invalid_secret"	=> "Error: Invalid Secret for options use",
			"import_successful"	=> "Import successful!",
			"import_error"		=> "Import error! Reload page and try again.",
		);
		
		function __construct() {
			$this->init();
		}
	
		/**
		 * Inits the main functionality
		 */
		public function init() {
			$this->load_options();
		}
	
		/**
		 * Loads the saved options into a property
		 * 
		 * @return 	Value 'saved_options' property
		 */
		public function load_options() {
			$this->saved_options = get_option( CATANIS_OPTIONS );
			
		}
	
		/**
		 * Get value the saved options property
		 * 
		 * @return 	Value 'saved_options' property
		 */
		public function get_saved_options() {
			
			if ( empty( $this->saved_options ) ) {
				$this->load_options();
			}
			return $this->saved_options;
		}
	
		/**
		 * Get the array containing all the fields
		 * 
		 * @return 	Array
		 */
		public function get_fields() {
			return $this->fields;
		}
		
		/**
		 * Sets the array containing all the fields
		 * 
		 * @param 	$fields: an array containing all the fields.
		 * @return 	Value 'fields' property
		 */
		public function set_fields( $fields ) {
			$this->fields = $fields;
		}
		
		/**
		 * Returns the default value of a field
		 * 
		 * @param 	$field: the field data
		 * @return 	Default value option
		 */
		public function get_default_value( $field ) {
			
			if ( $field['type'] != 'multioption' ) { /*single field*/
				if ( isset( $field['std'] ) ) {
					return $field['std'];
					
				} else { /*multi option*/
					if ( in_array( $field['type'], array( 'select', 'imageradio', 'styleimage', 'stylecolor', 'stylepattern' ) ) && !empty( $field['options'] ) ) {
						return $field['options'][0]['id'];
					
					} elseif ( $field['type'] == 'multicheck' || $field['type'] == 'custom' || $field['type'] == 'google_map' ) {
						return array();
					
					} elseif ( $field['type'] == 'checkbox' ) {
						return false;
					
					} else {
						return '';
					}
				}
			} else {
				$res = array();
				foreach ( $field['fields'] as $sub_field ) {
					$res[ $sub_field['id'] ] = $this->get_default_value( $sub_field );
				}
				return $res;
			}
		}
		
		/**
		 * Verifies the nonce value, validate user update theme and reset theme options 
		 * 
		 * @return 	Array
		 */
		public function resetThemeOption() {
			$result = array();
			
			if ( $_POST['ztype'] != 'reset' ) {
				$result["success"] = false;
				$result["message"] = $this->errors['invalid_action'];
				
			} elseif ( !wp_verify_nonce( $_POST['nonceValue'], 'catanis-theme-update-options' ) ) { /*nonce name: catanis-theme-options*/
				$result["success"] = false;
				$result["message"] = $this->errors['invalid_nonce'];
				
			} elseif( !current_user_can( 'edit_theme_options')) {
				$result["success"] = false;
				$result["message"] = $this->errors['user_cap'];
				
			} else {
				$result["success"] = true;
				$result["message"] = 'Reset successful!';
				
				foreach ( $this->fields as $option ) {
					if ( isset( $option['id'] ) && !in_array( $option['type'], array( 'subtitle', 'title', 'documentation', 'open', 'close', 'import', 'export' ) ) ) {
						$defaultOptions[ $option['id'] ] = $this->get_default_value( $option );
					}
				}
				update_option( CATANIS_OPTIONS, $defaultOptions );
			}
		
			return $result;
		}
		
		/**
		 * Adds an option into 'fields' property
		 * 
		 * @param 	$optionsArr: an array containing arrays of options
		 * @return 	'fields' property - An array containing all the options of the theme
		 */
		public function add_option_set( $optionsArr ) {
			foreach ( $optionsArr as $option ){
				$this->fields[] = $option;
			}
		}
	
		/**
		 * Verifies the nonce value, validate user update theme and update the theme options
		 */
		public function import_data(){
			
			if (isset($_POST['uploadimport']) ) {
				if ( $_FILES["fileimport"]["error"] > 0 ) {
					$status = 'file_error';
						
				} elseif ( !wp_verify_nonce( $_POST['catanis-theme-options'], 'catanis-theme-update-options' ) ) { /*nonce name: catanis-theme-options*/
					$status = 'invalid_nonce';
						
				} elseif ( !current_user_can( 'edit_theme_options' ) ) {
					$status = 'user_cap';
						
				} else {
					
					$form_fields = array ('uploadimport'); 
					$url = wp_nonce_url('admin.php?page=catanis_options');
					
					if (false === ($creds = request_filesystem_credentials($url, '', false, false, $form_fields) ) ) {
						return true; 
					}
					
					if ( ! WP_Filesystem($creds) ) {
						request_filesystem_credentials($url, '', true, false, $form_fields);
						return true;
					}
					
					global $wp_filesystem;
					$uploadInfo = wp_handle_upload($_FILES['fileimport'], array(
						'unique_filename_callback' => array( $this, 'catanis_cust_filename' ),
						'test_form' => false
					));
				
					if($wp_filesystem->exists($uploadInfo['file']) ){
						
						$data = unserialize($wp_filesystem->get_contents( $uploadInfo['file'] ) );
						$chk = update_option( CATANIS_OPTIONS, $data );
						
						if ( $chk ) {
							$status = 'import_successful';
						} else {
							$status = 'import_error';
						}
					}
					
				}
				
				wp_redirect(admin_url("admin.php?page=catanis_options&status=". $status));
			}
		}
		
		function catanis_cust_filename($dir, $name, $ext){
			return 'catanis_themeopts.json';
		}
		
		/**
		 * Validate and export file theme options
		 * 
		 * @return 	Array
		 */
		public function export_data_file() {
			
			if ( !current_user_can( 'edit_theme_options' ) ) {
				wp_die( $this->errors['invalid_nonce'] );
				exit;
				
			} elseif ( !isset( $_GET['secret'] ) || $_GET['secret'] != md5( AUTH_KEY.SECURE_AUTH_KEY ) ) {
				wp_die($this->errors['invalid_secret']);
				exit;
				
			} elseif ( !isset( $_GET['action'] ) ) {
				wp_die( $this->errors['no_feed_defined'] );
				exit;
				
			} else {
				$savedOptions = $this->saved_options;
				$filename = str_replace(" ", "", wp_get_theme()->get('TextDomain') ) . '_' . CATANIS_OPTIONS . '_' . date('d-m-Y') . '.json';
				
				nocache_headers();
				ob_clean();
				header("Content-Type: application/json; charset=" . get_option( 'blog_charset'));
				header("Content-Disposition: attachment; filename=$filename");
				header( "Expires: 0" );
				echo serialize($savedOptions);
				exit();
			}
		}
		
		
		/**
		 * Verifies the nonce value, validate user update theme, call function to update the options
		 * 
		 * @return 	Array
		 */
		public function save_data() {
			$result = array();

			if ( empty( $_POST ) ) {
				$result["success"] = false;
				$result["message"] = $this->errors['empty_post'];
				
			} elseif ( !wp_verify_nonce( $_POST['nonceValue'], 'catanis-theme-update-options' ) ) {
				$result["success"] = false;
				$result["message"] = $this->errors['invalid_nonce'];
				
			} elseif ( !current_user_can( 'edit_theme_options' ) ) {
				$result["success"] = false;
				$result["message"] = $this->errors['user_cap'];
				
			} else {
				$this->save_options();
				$result["success"] = true;
			}
			
			return $result;
		}
	
		/**
		 * Check type to get value option, then saves all the opstions from $_POST request
		 * 
		 * @return 	Void
		 */
		protected function save_options() {
			
			foreach ( $this->fields as $option ) {
				if ( isset( $option['id'] ) ) {
	
					if ( isset($_POST[ $option['id'] ] ) && !is_array( $_POST[ $option['id'] ] ) ) {
						$val = $_POST[ $option['id'] ];
						if ( $option['type'] == 'checkbox' ) {
							$val = ( $val == 'false' ) ? false : true;
						}
						
						$this->options_to_update[ $option['id'] ] = $val;
						
					} elseif ( $option["type"] == "multioption" ) {
						$opt_arr = array();
						foreach ( $option["fields"] as $field ) {
							
							if ( isset($_POST[ $option['id'] ][ $field['id'] ] ) ) {
								$val = $_POST[ $option['id'] ][ $field['id'] ];
								
								if ( $field['type'] == 'checkbox' ) {
									$val = ( $val == 'false' ) ? false : true;
								}
								$opt_arr[ $field['id'] ] = $val;
							}  
						}
						$this->options_to_update[ $option['id'] ] = $opt_arr;
						
					} elseif ( $option['type'] == 'custom' ) {
						if ( $option['ztype'] == 'social' ) {
							$arr = array();
							if ( isset( $_POST['icon_link'] ) && count( $_POST['icon_link'] ) > 0 ) {
								foreach ( $_POST['icon_link'] as $key => $link ) {
									$arr[] = array(
										'icon_url' => stripslashes( $_POST['icon_url'][$key] ),
										'icon_link' => stripslashes( $link ),
										'icon_title' => stripslashes( $_POST['icon_title'][$key] )
									);
								}
							}
							
							$this->options_to_update[ $option['id'] ] = $arr;
						}
						
						if ( $option['ztype'] == 'sidebar' ) {
							$arr = array();
							if ( isset( $_POST['sidebar_name'] ) && count( $_POST['sidebar_name'] ) > 0 ) {
								foreach ( $_POST['sidebar_name'] as $sidebar ) {
									$arr[] = array( 'sidebar_name' => $sidebar );
								}
							}
							$this->options_to_update[ $option['id'] ] = $arr;
						} 
						
					} elseif ( $option['type'] == 'google_map' ) {
						$this->options_to_update[ $option['id'] ] = $_POST[ $option['id'] ];
					}
				}
			}

			update_option( CATANIS_OPTIONS, $this->options_to_update );
		}
	
		/**
		 * Get value an option with id
		 * 
		 * @param 	@id: ID of the option
		 * @return 	Value an option
		 */
		public function get_value( $id ) {
			if ( isset( $this->saved_options[ $id ] ) ) {
				$val = $this->saved_options[ $id ];
				if ( is_string( $val ) ) {
					$val = stripslashes( $val );
				}
				return $val;
				
			} else {
				foreach ( $this->fields as $option ) {
					if ( isset( $option['id'] ) && $option['id'] == $id ) {
						return $this->get_default_value( $option );
					}
				}
			}
			return '';
		}
	
		/**
		 * Get saved value an option with id
		 * 
		 * @param 	@id: ID of the option
		 * @return 	Saved value option
		 */
		public function get_saved_value( $id ) {
			if ( isset( $this->saved_options[ $id ] ) ) {
				
				$val = $this->saved_options[ $id ];
				if ( is_string( $val ) ) {
					$val = stripslashes( $val );
				}
	
				foreach ( $this->fields as $option ) {
					if ( isset( $option['id'] ) && $option['id'] == $id ) {
						$default_val = $this->get_default_value( $option );
						break;
					}
				}
	
				if ( $default_val != $val ) {
					return $val;
				}
			}
			return null;
		}
		
		/**
		 * Get all option saved
		 * 
		 * @return 	Array saved value option
		 */
		public function get_alloption_saved() {
			return $this->saved_options;
		}
	
	}
}
?>