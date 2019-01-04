<?php
 /**
 * ============================================================
 * Description: This class contains all the meta data management functionality.
 *
 * @name		Catanis_Meta
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 */
if ( ! class_exists( 'Catanis_Meta' ) ) {
	class Catanis_Meta { 
		
		protected $fields 		= array();
		public $meta_key_save 	= 'meta_catanis_opts';
		public static $meta_key = 'meta_catanis_opts';
		public $post_id;
		public $post_type;
	
		/**
		 * Returns meta key save
		 * 
		 * @return 	An string value
		 */
		public static function getKeySave() {
			return self::$meta_key;
		}
		
		/**
		 * Returns the array containing all the meta fields
		 * 
		 * @return 	Array
		 */
		public function get_fields() {
			return $this->fields;
		}
		
		/**
		 * Sets the array containing all the meta fields
		 * 
		 * @param 	$fields: an array containing all the fields.
		 * @return 	Value 'fields' property
		 */
		public function set_fields( $fields ) {
			$this->fields = $fields;
		}
		
		/**
		 * Saves the meta data
		 * 
		 * @param 	$post_id: 	The ID of the post
		 * @param 	$post_type: The post type of the post
		 * @param 	$nonce_id: 	The nonce ID string which is used to verify the post
		 * @return 	- true if the data was saved
		 * 			- the post ID if the data was not saved
		 */
		public function metaSaveData( $post_id, $post_type, $nonce_id ) {
			
			global $post;
			if ( ! isset( $post ) || ! isset( $_POST['catanis-meta-nonce'] ) ) {
				return $post_id;
			}
			
			if ( ! wp_verify_nonce( $_POST['catanis-meta-nonce'], $nonce_id ) ) {
				return $post_id;
			}
			
			/*Don't save anything if this is an autosave*/
			if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				return;
			}
			
			if ( ! current_user_can( 'edit_posts' ) ) {
				return $post_id;
			}
			
			if ( defined( 'WPSEO_VERSION' ) ) {
				$post_id = $_POST['post_ID'];
			}

			$meta_boxes = $this->fields[$post_type];
			
			if ( ! empty( $meta_boxes ) ) {
				$metaUpdate = array();
				

				if (is_array($meta_boxes) || is_object($meta_boxes)) {
											
					foreach ( $meta_boxes as $sections ) {
						if (is_array($sections) || is_object($sections)) {
							foreach ( $sections as $meta ) {
								
								if ( $meta['type'] != 'multioption' ) {
									if ( isset( $meta["id"] ) && isset( $_POST[ $meta["id"] ] ) ) {
										$metaUpdate[ $meta["id"] ] = $_POST[ $meta["id"] ];
									}
								} elseif ( isset( $meta['fields'] ) ) { 
									$metaArr = array();
									foreach ($meta['fields'] as $field ) {
										
										if ( isset( $_POST[ $meta['id'] ][ $field['id'] ] ) ) {
											
											$val = $_POST[ $meta['id'] ][ $field['id'] ];
											if ( $field['type'] == 'checkbox' ) {
												$val = ( $val == 'false' ) ? false : true;
											}
											
											$metaArr[ $field['id'] ] = $val;
										}
									}
									$metaUpdate[ $meta['id'] ] = $metaArr;
								}
							}
						}
						
					}
				}
				
				update_post_meta( $post_id, $this->meta_key_save, $metaUpdate );
				return true;
			}
	
			return $post_id;
		}
	
		/**
		 * Get value of a meta field
		 * 
		 * @param 	$id:		The ID of the field
		 * @param 	$args:	The array contain the post id and the post type (optional)
		 * @return 	- saved value: 		If the meta field has a saved value
		 * 			- default value:	If the meta field has not a saved value
		 * 			- empty string:		If the post ID and post type are not set
		 * 			- null: 			If the specified ID cannot be found OR the post ID and post type are not set
		 */
		public function get_value( $id, $args = array() ) {
			
			if ( isset( $args['post_id'] ) && isset( $args['post_type'] ) ) {
				$post_id 	= $args['post_id'];
				$post_type 	= $args['post_type'];
				
			} elseif ( isset( $this->post_id ) && isset( $this->post_type ) ) {
				$post_id 	= $this->post_id;
				$post_type 	= $this->post_type;
				
			} else {
				return;
			}
	
			$saved_val = get_post_meta( $post_id, $this->meta_key_save, true );
			$saved_val = (isset($saved_val[ $id ]) && !empty( $saved_val )) ? $saved_val[ $id ] : 'null';
			
			if ( $saved_val != 'null' ) { 
				return $saved_val; 
				
			} elseif ( isset( $this->fields[$post_type] ) ) {
				/*has not a saved value, return the default value*/
				foreach ( $this->fields[ $post_type ] as $sections ) {
					if(is_array($sections)){
						foreach ( $sections as $field ) {
							
							if ( isset( $field['id'] ) && $field['id'] == $id ) {
								if ( $field['type'] == 'multioption' ) {
									$res = $this->getDefaultValue( $field );
									foreach ( $field['fields'] as $subfield ) {
										$val = get_post_meta( $post_id, $field['id'] . '_' . $subfield['id'], true );
										if ( ! empty( $val ) ) {
											$res[ $subfield['id'] ] = $val;
										}
									}
									return $res;
								} else {
									return $this->getDefaultValue( $field );
								}
							}
						}
					}
				}
			} else {
				return;
			}
			return '';
		}
		
		/**
		 * Returns the default value of a field
		 * 
		 * @param 	$field: the field data (array)
		 * @return 	Default value option
		 */
		public function getDefaultValue( $field ) {
		
			if ( $field['type'] != 'multioption' ) {
				
				if ( isset( $field['std'] ) ) {  /*single field*/
					return $field['std'];
					
				} else { /*multi options*/
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
					$res[ $sub_field['id'] ] = $this->getDefaultValue( $sub_field );
				}
				
				return $res;
			}
		}
		
	}
}
?>