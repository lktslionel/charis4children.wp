<?php
if ( ! class_exists('Catanis_Widgets_Main') ) {
	class Catanis_Widgets_Main{
	
		private $_widgets = array();

		public function __construct(){
			
			$this->_widgets = array(
				'tagcloud', 'ads', 'aboutus_contact', 'subscriptions', 'instagram', 'socials',
				'twitter', 'flickr', 'recent_posts','testimonial','recent_comments', 'tab_post',
				'facebook'
			);
			
			if( catanis_is_woocommerce_active() ){
				$this->_widgets[] = 'products';
			}
		
			$this->init();
			add_action('widgets_init', array($this, 'catanis_register_widget'));
			add_action('widgets_init', array($this, 'catanis_remove_widget'));
		}
		
		public function init(){
			if(count($this->_widgets) >0){
				foreach ($this->_widgets as $widget){
					require_once CATANIS_CORE_INC_PATH . '/widgets/' . $widget . '.php';
				}
			}
			
			if(is_admin()){
				require_once CATANIS_CORE_INC_PATH . '/widgets/html.php';
				require_once CATANIS_CORE_INC_PATH . '/widgets/controls.php';
			}
		}
		
		function catanis_register_widget(){
			if(count($this->_widgets) >0){
				foreach ($this->_widgets as $widget){
					$name = 'Catanis_Widget_'. ucfirst($widget);
					register_widget($name);
				}
			}
		}
		
		function catanis_remove_widget(){
			/*unregister_widget('WP_Widget_Recent_Comments');
			unregister_widget('WP_Widget_Search');   */  
		}
		
	}
	
	new Catanis_Widgets_Main();
}
?>