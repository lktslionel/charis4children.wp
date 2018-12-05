<?php
 /**
 * ============================================================
 * Description: Print meta boxes with meta fields, nonce field, heading...
 *
 * @name		Catanis_Meta_Builder
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 */
if ( ! class_exists('Catanis_Meta_Builder') ){
	class Catanis_Meta_Builder extends Catanis_Helper_Field{
	
		protected $meta_boxes;
		protected $nonce_id;
		protected $nonce_display = false;
	
		function __construct( $meta_obj, $meta_boxes, $nonce_id = '' ) {
			parent::__construct( $meta_obj );
			$this->meta_boxes = $meta_boxes;
			$this->nonce_id = $nonce_id;
		}
	
		/**
		 * Prints the boxes with all field setting
		 * 
		 * @return 	Html
		 */
		public function inMetaBoxes($meta_boxes = array()) {
			
			global $post;
			if($this->nonce_display == false){
				$this->inNonceField();
			}
			
			$arrMeta = empty($meta_boxes) ? $this->meta_boxes : $meta_boxes; 
			echo '<div class="catanis-meta-boxes">';
			foreach ( $arrMeta as $meta_field ) {
			
				switch ( $meta_field['type'] ) {
					case 'heading':
						$this->inHeading( $meta_field );
						break;
							
					case 'documentation':
						parent::inTextDocument( $meta_field );
						break;
							
					default :
						parent::inControlField( $meta_field);
				}
			}
	
			echo '</div>
					<div id="formDialog" class="customDialog dialog displayNone" title="">
						<div class="errorFormDialog"></div>
						<div id="contentFormDialog"></div>
						<div class="displayNone squareform_loading">
							<img class="img" src="' . esc_url(CATANIS_IMAGES_URL) . 'loading.gif" alt="">
							<div class="load_message">Loading</div>
						</div>
					</div>';
		}
		
		/**
		 * Prints the boxes with tabs
		 *
		 * @return 	Html
		 */
		public function inMetaBoxesTabs(){
			global $post;
			if($post->post_type == CATANIS_POSTTYPE_PORTFOLIO || $post->post_type == 'product'){
				$page_tabs = array('Layout / Header', 'Page Title', 'Footer', ucfirst($post->post_type) );
				$page_tab_content = array('layout_header', 'page_title', 'footer', 'single_post_layout');
				
			}elseif($post->post_type == 'post'){
				$page_tabs = array('Layout / Header', 'Page Title', 'Footer', 'Single Post' ,'Post Format');
				$page_tab_content = array('layout_header', 'page_title', 'footer', 'single_post', 'post_format');
				
			}elseif($post->post_type == 'page'){
				$page_tabs = array('Layout / Header', 'Page Title', 'Footer', 'Extras');
				$page_tab_content = array('layout_header', 'page_title', 'footer', 'extras');
			}
			
			$icon_class = array('icon-tools', 'icon-done-all', 'icon-brush', 'icon-grain', 'icon-popup');
			echo '<ul class="catanis_metabox_tabs">';
				$icon = 0;
				$showicon = '';
				foreach( $page_tabs as $tab_key => $tab_name ) {
					if($icon_class){
						$showicon = '<i class="'.$icon_class[$icon].'"></i>';
					}
					echo '<li class="cata_tab_'.$page_tab_content[$tab_key].'"><a href="'.$tab_name.'">'.$showicon.'<span class="group_title">'.$tab_name.'</span></a></li>';
					$icon++;
				}
			echo '</ul>';
			
			echo '<div class="catanis_metabox_tab_content">';
			foreach( $page_tab_content as $tab_content_key => $tab_content_name ) {
				echo '<div class="catanis_metabox_tab" id="cata_tab_'.$tab_content_name.'">';
				if(isset($this->meta_boxes[$tab_content_name])){
					$this->inMetaBoxes($this->meta_boxes[$tab_content_name]);
				}else{
					echo esc_html__('Please add setting options for this section.','onelove');
				}
				echo '</div>';
			}
				
			$this->inNonceField();
			$this->nonce_display = true;
			echo '</div>';
			echo '<div class="clear"></div>';
		}
		
		/**
		 * Prints the boxes for only post and portfolio
		 *
		 * @return 	Html
		 */
		public function inMetaBoxesPortfolio(){
			$this->inMetaBoxes($this->meta_boxes['secondary_metaboxes']);
		}
	
		/**
		 * Prints a heading text with data attribute if it is set (optional)
		 * 
		 * @param 	$metaField: The field that contains all the heading information
		 * @return 	Html
		 */
		protected function inHeading( $metaField ) {
			
			$data = $elemClass = "";
			if ( isset( $metaField["data"] ) ) {
				foreach ( $metaField["data"] as $key => $value ) {
					$data.=' data-'.$key.'="' . $value . '"';
				}
			}
			
			$elemID = isset($metaField["id"]) ? $metaField["id"] : catanis_random_string(5, 'headeing') ;
			$elemClass .= 'option option-heading';
			$elemClass .= isset( $metaField["extClass"] ) ? ' ' . $metaField["extClass"] : '' ;
			echo'<div data-option-id="'. $elemID .'" class="'. $elemClass .'"' . $data . '><h4>' . $metaField["title"] . '</h4></div>';
		}
	
		/**
		 * Prints a nonce field to the meta
		 * 
		 * @return 	Html
		 */
		protected function inNonceField() {
			$nonce = wp_create_nonce( $this->nonce_id );
			echo '<input type="hidden" name="catanis-meta-nonce" value="' . $nonce . '" />';
		}
		
	}
}
?>