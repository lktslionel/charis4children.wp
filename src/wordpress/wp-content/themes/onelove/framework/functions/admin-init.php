<?php
add_action( 'admin_enqueue_scripts', 'catanis_register_admin_scripts_and_styles', 100 );
if ( ! function_exists( 'catanis_register_admin_scripts_and_styles' ) ) {
	function catanis_register_admin_scripts_and_styles() {
		global $current_screen;
		
		/* Register the scripts */
		wp_register_script( 'catanis-plugin', CATANIS_SCRIPT_URL . 'plugins.init.js', array( 'jquery', 'jquery-ui-datepicker', 'wp-color-picker' ), CATANIS_THEME_VERSION, true );
		wp_register_script( 'catanis-googlemaps', '//maps.googleapis.com/maps/api/js?key=AIzaSyCwemfIegq-vuXhqMdElQEJXoD2YHJd_xs', false, '3', true);
		wp_register_script( 'catanis-addresspicker', CATANIS_SCRIPT_URL . 'plugins/jquery.ui.addresspicker.js', false, CATANIS_THEME_VERSION, true );
		wp_register_script( 'catanis-chosen', CATANIS_SCRIPT_URL . 'plugins/chosen_v1.2.0/chosen.jquery.min.js', false, CATANIS_THEME_VERSION, true );
		wp_register_script( 'catanis-image-picker', CATANIS_SCRIPT_URL . 'plugins/image-picker.jquery.min.js', array('jquery'), false, true);
		wp_register_script( 'catanis-color-picker-alpha', CATANIS_SCRIPT_URL . 'plugins/wp-color-picker-alpha.min.js', array( 'wp-color-picker'), false, true);
		
		/* Register the styles */
		wp_register_style( 'catanis-css-chosen', CATANIS_SCRIPT_URL . 'plugins/chosen_v1.2.0/chosen.custom.css' );
		wp_register_style( 'catanis-css-style', CATANIS_FRAMEWORK_URL . 'css/admin.css' , array('wp-color-picker' ));
		
		/* Enqueue script & styles */
		wp_enqueue_style( 'catanis-css-style' );
		if ( $current_screen->base == 'post' || (isset( $_GET['page'] ) && $_GET['page'] == 'catanis_options') ) {
			wp_enqueue_media();
			wp_enqueue_script( 'catanis-chosen');
			wp_enqueue_script( 'catanis-googlemaps');
			wp_enqueue_script( 'catanis-addresspicker');
			wp_enqueue_script( 'catanis-plugin');
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'catanis-color-picker-alpha');
			wp_enqueue_script( 'catanis-image-picker');
			
			wp_enqueue_style( 'catanis-css-chosen' );
		}
	}
}

add_action( 'admin_print_scripts', 'catanis_print_admin_scripts' );
if ( ! function_exists('catanis_print_admin_scripts' ) ) {
	function catanis_print_admin_scripts(){
		
		global $current_screen;

		$script = '<script type="text/javascript">';
		$script	.='var CATANIS = CATANIS || {};';
		$script	.='CATANIS.theme_uri="' . esc_url(CATANIS_TEMPLATE_URL) . '";';
		$script	.='CATANIS.taxonomy="' . esc_js($current_screen->taxonomy) . '";';
		$script	.='CATANIS.posttype="' . esc_js($current_screen->post_type) . '";';
		
		if ( current_user_can( 'edit_posts' ) ) {
			$nonce 	= wp_create_nonce( 'catanis_upload' );
			$script	.='CATANIS.uploadNonce = "' . esc_js($nonce) . '";';
		}
		if(isset($_GET['page']) && !empty($_GET['page']) ){
			$script	.='CATANIS.page = "' . esc_js($_GET['page']) . '";';
		}
		
		$meta_hide_editor = array( 'template-fullscreen-slider.php' );
		$script	.= 'CATANIS.images_url = "' . esc_url(CATANIS_IMAGES_URL) . '";';
		$script	.= 'CATANIS.templatesToHideEditor=' . json_encode( $meta_hide_editor ) . ';';
		$script	.= '</script>';
		
		echo ($script);
	}
}

/*Notice Default Scripts*/
//add_action( 'wp_default_scripts', 'catanis_wp_default_scripts' );
if ( ! function_exists('catanis_wp_default_scripts' ) ) {
	function catanis_wp_default_scripts($scripts){
		if ( ! empty( $scripts->registered['jquery'] ) ) {
			$jquery_dependencies = $scripts->registered['jquery']->deps;
			$scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
		}
	}
}
?>