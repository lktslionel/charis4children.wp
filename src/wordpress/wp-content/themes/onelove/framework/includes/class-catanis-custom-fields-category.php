<?php
 /**
 * ============================================================
 * Description: Adds some custom field for Post category
 *
 * @name		Catanis_Custom_Fields_Category
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 */
if( !class_exists('Catanis_Custom_Fields_Category') ){
	class Catanis_Custom_Fields_Category {
		
		public static $_key_save_custom = 'cata_custom_post_taxonomy';
		var $_default_data = array();
		
		/*=== Constructor class ===*/
		function __construct()   {	
			
			/*Custom fields for category*/
			add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_wp_admin_style' ), 30 );
			add_action( 'category_add_form_fields', array( $this, 'add_form_fields' ), 20 );
			add_action( 'category_edit_form_fields', array( $this, 'edit_form_fields' ), 10, 2 );
			add_action( 'created_category', array( $this, 'save_data' ), 10, 2 );
			add_action( 'edited_category', array( $this, 'save_data' ), 10, 2 );
			add_action( 'delete_category', array( $this, 'delete_data' ), 10, 1 );
				
			$this->_default_data = array(
				'layout' 			=> 'default',
				'sidebar' 			=> 'sidebar-primary',
				'header_overlap' 	=> 'true',
				'breadcrumb_bg' 	=> '',
			);
		}
		
		/*=== Func: Get key save ===*/
		static public function get_key_save() {
			return self::$_key_save_custom;
		}
		
		/*=== Enqueue script style ===*/
		public function load_custom_wp_admin_style() {
			
			if( !wp_script_is('catanis-metabox-script-main')) {
				wp_register_script( 'catanis-metabox-script-main', CATANIS_FRAMEWORK_URL . 'js/cata-metabox.js', array(), '1.0', true );
				wp_enqueue_script( 'catanis-metabox-script-main');
			}
		}
		
		/*=== Add fields for Portfolio Category in add layout ===*/
		public function add_form_fields(){
			
			$xhtml = '';
			$htmlObj =  new Catanis_Widget_Html();
			
			$inputID 	= 'layout';
			$inputValue = $this->_default_data[$inputID];
			$arr 		= array( 'class' =>'postform','id' => $inputID, 'style' =>'width:200px' );
			$opts 		= array( 'data' => $this->get_layout() );
			$xhtml 		.= $htmlObj->pt_generalItem_div(
					$htmlObj->labelTag( esc_html__('Category Layout', 'onelove' ), array( 'for' => $inputID ) ),
					$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
			);
				
			$inputID 	= 'sidebar';
			$inputValue = $this->_default_data[$inputID];
			$arr 		= array( 'class' => 'postform', 'id' => $inputID, 'style' => 'width:200px' );
			$opts 		= array( 'data' => $this->get_sidebar() );
			$xhtml 		.= $htmlObj->pt_generalItem_div(
					$htmlObj->labelTag( esc_html__( 'Category Sidebar', 'onelove' ), array( 'for' => $inputID ) ),
					$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
			);
				
			$inputID 	= 'header_overlap';
			$inputValue = $this->_default_data[$inputID];
			$arr 		= array( 'class' => 'postform', 'id' => $inputID, 'style' => 'width:200px' );
			$opts 		= array( 'data' => array('default' => esc_html__('Default', 'onelove'), 'true' => esc_html__('Yes', 'onelove'), 'false' => esc_html__('No', 'onelove') ));
			$xhtml 		.= $htmlObj->pt_generalItem_div(
					$htmlObj->labelTag( esc_html__( 'Header Integration (will be overlap into page title)', 'onelove' ), array( 'for' => $inputID ) ),
					$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
			);
				
			$inputID 	= 'breadcrumb_bg';
			$xhtml 		.= $htmlObj->pt_generalItem_div(
					$htmlObj->labelTag( esc_html__('Page Title Background', 'onelove' ), array( 'for' => $inputID , 'style' => 'margin-bottom: 10px;' ) ),
					$htmlObj->taxonomy_upload_thumbnail()
			);
				
			echo trim($xhtml);
		}
		
		/*=== Add fields for Portfolio Category in edit layout ===*/
		public function edit_form_fields( $term, $taxonomy ) {
		
			$xhtml = '';
			$htmlObj =  new Catanis_Widget_Html();
			
			/*Get data for display*/
			$option = get_option( self::$_key_save_custom );
			$image 	= CATANIS_FRONT_IMAGES_URL . 'placeholder.png';
			$thumbnail_id = 0;
			if( isset ($option[ $term->term_id ]['breadcrumb_id']) ){
					
				$thumbnail_id = $option[ $term->term_id ]['breadcrumb_id'];
				if ( absint($thumbnail_id) > 0 ) {
					$image = wp_get_attachment_thumb_url( $thumbnail_id );
				}
			}
				
			$inputID 	= 'layout';
			$inputValue = $option[ $term->term_id ][$inputID];
			$arr 		= array( 'class' => 'postform', 'id' => $inputID, 'style' => 'width:200px' );
			$opts 		= array( 'data' => $this->get_layout());
			$xhtml 		.= $htmlObj->pt_generalItem_tr(
					$htmlObj->labelTag( esc_html__( 'Category Layout', 'onelove' ), array( 'for' => $inputID ) ),
					$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
			);
				
			$inputID 	= 'sidebar';
			$inputValue = $option[ $term->term_id ][$inputID];
			$arr 		= array( 'class' => 'postform', 'id' => $inputID, 'style' => 'width:200px' );
			$opts 		= array( 'data' => $this->get_sidebar() );
			$xhtml 		.= $htmlObj->pt_generalItem_tr(
					$htmlObj->labelTag( esc_html__('Category Sidebar', 'onelove' ), array( 'for' => $inputID ) ),
					$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
			);
				
			$inputID 	= 'header_overlap';
			$inputValue = $option[ $term->term_id ][$inputID];
			$arr 		= array( 'class' => 'postform', 'id' => $inputID, 'style' => 'width:200px' );
			$opts 		= array( 'data' => array('default' => esc_html__('Default', 'onelove'), 'true' => esc_html__('Yes', 'onelove'), 'false' => esc_html__('No', 'onelove') ));
			$xhtml 		.= $htmlObj->pt_generalItem_tr(
					$htmlObj->labelTag( esc_html__( 'Header Integration (will be overlap into page title)', 'onelove' ), array( 'for' => $inputID ) ),
					$htmlObj->control( 'selectbox', $inputID, $inputValue, $arr, $opts )
			);
			
			$inputID 	= 'breadcrumb_bg';
			$xhtml 		.= $htmlObj->pt_generalItem_tr(
					$htmlObj->labelTag( esc_html__('Page Title Background', 'onelove' ), array( 'for' => $inputID , 'style' => 'margin-bottom: 10px;' ) ),
					$htmlObj->taxonomy_upload_thumbnail( trim($image), $thumbnail_id )
			);
				
			echo trim($xhtml);
		}
		
		/*=== Save data for custom term ===*/
		public function save_data( $term_id, $tt_id  ) {
		
			if ( isset( $_POST['_inline_edit'] ) ) {
				return $term_id;
			}
				
			$option = get_option( self::$_key_save_custom );
			$option[ $term_id ]['layout'] = isset( $_POST['layout'] ) ? wp_kses_data( $_POST['layout'] ) : $this->_default_data['layout'];
			$option[ $term_id ]['sidebar'] = isset( $_POST['sidebar'] ) ? wp_kses_data( $_POST['sidebar'] ) : $this->_default_data['sidebar'];
			$option[ $term_id ]['header_overlap'] = isset ( $_POST['header_overlap']) ? esc_html($_POST['header_overlap']) : $this->_default_data['header_overlap'];
			$option[ $term_id ]['breadcrumb_id'] = isset ( $_POST['category_thumbnail_id']) ? absint( $_POST['category_thumbnail_id'] ) : 0;
			update_option( self::$_key_save_custom, $option );
		}
		
		/*=== Delete data for custom term ===*/
		public function delete_data( $term_id ) {
			$option = get_option( self::$_key_save_custom );
			unset( $option[ $term_id ] );
			update_option( self::$_key_save_custom, $option );
		}
		
		private function get_layout() {
		
			return array(
				'default'	=> esc_html__( 'Default', 'onelove' ),
				'full' 		=> esc_html__( 'No sidebar (Full width)', 'onelove' ),
				'left' 		=> esc_html__( 'Left sidebar', 'onelove' ),
				'right'		=> esc_html__( 'Right sidebar', 'onelove' )
			);
		}
		
		private function get_sidebar(){
			$sidebars 	= catanis_get_content_sidebars( 'default' );
			$result 	= array();
			if ( sizeof( $sidebars ) ) {
				foreach ( $sidebars as $sb ) {
					$result[$sb['id']] = $sb['name'];
				}
			}
		
			return $result;
		}
		
	}
	
	new Catanis_Custom_Fields_Category();
}
?>