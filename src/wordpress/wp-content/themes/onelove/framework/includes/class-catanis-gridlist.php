<?php
 /**
 * ============================================================
 * Description: Adds icon grid and list to shop/category page
 *
 * @name		Catanis_Gridlist_Toogle
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 */
if( !class_exists('Catanis_Gridlist_Toogle') && catanis_is_woocommerce_active() ){
	class Catanis_Gridlist_Toogle {
		
		public function __construct() {
			add_action('wp', array($this, 'init_trigger'), 20);
		}
		
		public function init_trigger() {
			$enable_gridlist = catanis_option('procate_enable_gridlist');
			if( !$enable_gridlist){
				return;
			}
			if ( is_shop() || is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') || is_product_taxonomy() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'setup_scripts_styles' ), 100 );
				add_action( 'woocommerce_before_shop_loop', array( $this, 'gridlist_toggle_button' ), 10 );
			}
		}
		
		function gridlist_toggle_button() {
			$gridlist_opt = catanis_option('procate_gridlist');
			echo '<nav class="cata-gridlist-toggle" data-default="' . $gridlist_opt['default_view'] . '">
					<a href="#" id="cata_grid" title="' . esc_html__( 'Grid view', 'onelove' ) . '"><i class="ti-view-grid"></i></a>
					<a href="#" id="cata_list" title="' . esc_html__( 'List view', 'onelove' ) . '"><i class="ti-view-list"></i></a>
				</nav>';
		}
		public function setup_scripts_styles(){
			wp_register_script( 'catanis-js-gridlist', CATANIS_TEMPLATE_URL . '/js/woo_gridlist.js', false, CATANIS_THEME_VERSION, true );
			wp_enqueue_script( 'catanis-js-gridlist');
		}
	}
	
	new Catanis_Gridlist_Toogle();
}