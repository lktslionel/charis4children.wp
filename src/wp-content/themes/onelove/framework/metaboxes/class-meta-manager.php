<?php
/**
 * ============================================================
 * Description: This class initializing Meta Manager Object and contains all the main functionality.
 *
 * @name		Catanis_Meta_Manager
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 */
if ( ! class_exists( 'Catanis_Meta_Manager' ) ) {
	class Catanis_Meta_Manager {
	
		protected $meta;
		protected $meta_boxes 	= array();
		public $metaObj 		= null;
		public $nonce_id		= 'catanis-meta';
		
		function __construct( $meta ) {
			$this->meta = $meta;
			$this->metaObj = new Catanis_Meta();
		}
	
		/**
		 * Inits the main functionality
		 */
		public function init() {
			add_action( 'add_meta_boxes', array( &$this, 'init_meta_boxes' ) );
			add_action( 'save_post', array( &$this, 'save_data'));
			add_action( 'admin_footer', array( $this, 'add_style_script' ) );
		}
	
		/**
		 * Initializes the meta boxes
		 * 
		 * @return 	Void
		 */
		public function init_meta_boxes() {
			
			global $post;
			if ( empty( $post ) ) {
				return;
			}
			
			$this->set_meta_data();
			$widgets_builder = new Catanis_Meta_Builder( $this->metaObj, $this->meta_boxes, $this->nonce_id );
		
			if ( ! empty( $this->meta_boxes ) ) {
				
				if ($this->meta_boxes['boxtabs'] == true ) {
					add_meta_box( 'catatnis_metaboxes_options',
						'<div class="icon-small"></div> CATANIS ' . strtoupper(str_replace( array('catanis-', 'catanis_'), ' ', $this->post_type )) . ' SETTINGS',
						array( $widgets_builder, 'inMetaBoxesTabs' ), $this->post_type); 
				}
				
				if ($this->meta_boxes['boxsimple'] == true ) {
					$nameFunc = 'CATANIS ' . strtoupper(str_replace( array('catanis-', 'catanis_'), ' ', $this->post_type )) . ' FORMAT SETTINGS';
					$nameFunc = ($this->meta_boxes['boxtabs'] == false) ? str_replace('FORMAT ', '', $nameFunc) : $nameFunc;
					
					/* Add more single metaboxes for post and portfolio */
					add_meta_box( 'catatnis_metaboxes_options_secondary',
						'<div class="icon-small"></div>' . $nameFunc,
						array( $widgets_builder, 'inMetaBoxesPortfolio' ), $this->post_type);
				}
			}
		}
		
		/**
		 * Set the needed meta data: post ID, post type and meta_boxes array
		 * 
		 * @return 	Void
		 */
		protected function set_meta_data() {
			global $current_screen, $post;
			
			/*set the meta boxes for the current page*/
			if ( empty( $this->meta_boxes ) ) {
				$post_type = empty( $current_screen ) ? $post->post_type : $current_screen->post_type;
				if ( isset( $this->meta[$post_type] ) ) {
					$this->meta_boxes = $this->meta[$post_type];
				}
			}
	
			/*set the post ID*/
			if ( empty($this->post_id ) ) {
				$this->post_id = $post->ID;
				$this->metaObj->post_id = $post->ID;
			}
	
			/*set the post type*/
			if ( empty( $this->post_type ) ) {
				if ( ! empty( $current_screen ) ) {
					$this->post_type = $current_screen->post_type;
					$this->metaObj->post_type = $current_screen->post_type;
				} else {
					$this->post_type = $post->post_type;
					$this->metaObj->post_type = $post->post_type;
				}
			}
		}
		
		/**
		 * Get the current meta object
		 * 
		 * @return 	Catanis_Meta object
		 */
		public function get_meta_obj() {
			return $this->metaObj;
		}
		
		/**
		 * Saves the meta data
		 * 
		 * @return 	Void
		 */
		public function save_data() {
			global $post;
			if ( isset( $post ) ) {
				
				$this->set_meta_data();
				$this->metaObj->metaSaveData( $this->post_id, $this->post_type, $this->nonce_id );
			}
		}
	
		/**
		 * Sets the meta fields array
		 * 
		 * @param 	$meta	The meta fields array
		 * @return 	Void
		 */
		public function set_meta( $meta ) {
			$this->meta = $meta;
			$this->metaObj->set_fields( $meta );
		}
		
		/**
		 * Add script into metabox
		 * 
		 * @return 	Void
		 */
		public function add_style_script(){
			if( !wp_script_is('catanis-metabox-script-main')) {
				wp_register_script( 'catanis-metabox-script-main', CATANIS_FRAMEWORK_URL . 'js/cata-metabox.js', array(), '1.0', true );
				wp_enqueue_script( 'catanis-metabox-script-main');
			}
			global $pagenow;
			if (is_admin() && ($pagenow=='post-new.php' || $pagenow=='post.php')) {
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');
				wp_register_script('catanis-admin-metabox-cookie-js', CATANIS_FRAMEWORK_URL . 'js/metabox-cookie.js', array('jquery'), CATANIS_THEME_VERSION);
				wp_enqueue_script('catanis-admin-metabox-cookie-js');
			}
			
			
		}
		
	}
}
?>