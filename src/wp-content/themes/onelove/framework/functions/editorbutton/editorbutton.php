<?php 
/**
 * ============================================================
 * Description: This class management for the custom TinyMCE Editor buttons.
 *
 * @name		Catanis_Setup
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 * https://code.tutsplus.com/tutorials/guide-to-creating-your-own-wordpress-editor-buttons--wp-30182
 */
class CatanisEditorButton{
	
	public function __construct(){
		
		$this->catanis_init();
		
		add_action( 'admin_init', array( $this, 'catanis_init_buttons' ) );
		
		add_action( 'admin_footer', array($this, 'catanis_load_tinymce_script_styles'), 20 );
		add_action( 'wp_ajax_catanis_print_wp_editor', array( $this, 'catanis_print_wp_editor' ) );
	}
	
	public function catanis_init(){
		global $catanis;
		
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}
		
		if ( ! isset($catanis->styling_buttons ) ) {
			$catanis->styling_buttons = array('catanisdropcaps', 'catanistooltip', 'catanisemptyspace');
		}
	}
	
	public function catanis_init_buttons(){
		add_editor_style( 'framework/functions/editorbutton/custom-editor-style.css' );
	
		if ( get_user_option( 'rich_editing') == 'true' ) {
			add_filter( 'mce_external_plugins', array( $this,'catanis_add_btn_tinymce_plugin' ) );
			add_filter( 'mce_buttons_2', array( $this, 'catanis_register_more_buttons' ) );
			add_filter( 'mce_buttons_3', array( $this, 'catanis_register_styling_buttons' ) );
			add_filter("mce_buttons", array( $this, 'extended_editor_mce_buttons'), 0);
		}
	}
	
	function catanis_register_more_buttons( $buttons ) {

		/* Add the button/option after 3th item */
		array_splice( $buttons, 3, 0, 'backcolor' );
	
		return $buttons;
	}
	
	function extended_editor_mce_buttons( $buttons ) {
		
		array_unshift( $buttons, 'styleselect' );
		return $buttons; 
	}
	
	public function catanis_load_tinymce_script_styles(){
		global $current_screen;
		
		if ( $current_screen->base=='post' ) {
			wp_enqueue_style( 'catanis-editor-buttons', CATANIS_FRAMEWORK_URL . 'functions/editorbutton/editor-buttons.css' );
			
			/*load the portfolio categories*/
			$portfolio_cats = taxonomy_exists('portfolio_category') ? catanis_get_portfolio_categories() : array();
			array_unshift( $portfolio_cats, array( 'id' => '-1', 'name' => 'All categories' ) );
			
			/*load the post categories */
			$cats = catanis_get_categories();
			array_unshift( $cats, array( 'id' => '-1', 'name' => 'All categories' ) );
			
			echo '<script type="text/javascript">'
					.'var CATANIS = CATANIS || {};'
					.'CATANIS.themeName = "' . CATANIS_THEMENAME . '";'
					.'CATANIS.portfolioCategories = ' . json_encode( $portfolio_cats ) . ';'
					.'CATANIS.categories = ' . json_encode( $cats ) . ';'
					.'CATANIS.posttype = "' . $current_screen->post_type . '";'
				.'</script>';
				
		}
	}
	
	/**
	 * Registers a JavaScript file that will handle the functionality from the
	 * custom buttons.
	 *
	 * @param $plugin_array
	 */
	public function catanis_add_btn_tinymce_plugin( $plugin_array ){
		
		global $catanis;
		
		$merged_buttons = $catanis->styling_buttons;
		
		foreach ( $merged_buttons as $btn ) {
			$plugin_array[$btn] = CATANIS_FRAMEWORK_URL . 'functions/editorbutton/editor.plugin.js';
		}
		return $plugin_array; 
		
	}
	
	public function catanis_register_styling_buttons( $buttons ) {
		global $catanis;

		array_push( $buttons, implode( ',', $catanis->styling_buttons ) );
		return $buttons;
	}
	
	public function catanis_print_wp_editor(){
		
		$editor_id = isset( $_GET['id'] ) ? $_GET['id'] : 'catanis_editor';
		$content = isset( $_GET['content'] ) ? $_GET['content'] : '';
		wp_editor( $content, $editor_id, array( 'media_buttons' => false ) );
		exit();
	}
	
}

