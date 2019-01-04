<?php
add_action( 'widgets_init', 'catanis_load_sidebar_names', 10 );
add_action( 'widgets_init', 'catanis_register_all_sidebars', 11 );

if ( ! function_exists( 'catanis_load_sidebar_names' ) ) {
	/**
	 * Loads all the existing sidebars and sidebar to be registered in Theme Options
	 *
	 * @return array containing all the sidebars
	 */
	function catanis_load_sidebar_names() {
		global $catanis;

		if ( ! isset( $catanis->sidebars ) ) {
			/*default sidebar*/
			$catanis_sidebars = array(
				array( 'name' => 'Primary Sidebar', 'id' => 'sidebar-primary', 'location' => 'sidebar', 'class' => 'widget-container' )/*,
				array( 'name' => 'Secondary Sidebar', 'id' => 'sidebar-secondary', 'location' => 'sidebar', 'class' => 'widget-container' )*/
			);
			
			if(catanis_is_woocommerce_active()){
				$catanis_sidebars[] = array( 'name' => 'Shop Sidebar', 'id' => 'shop_sidebar', 'location' => 'sidebar', 'class' => 'widget-container' );
			}

			$sidebars = catanis_option( 'sidebars' ) ? catanis_option( 'sidebars' ) : array();

			/*add the generated sidebars in theme options*/
			foreach ( $sidebars as $sidebar ) {
				 $catanis_sidebars[] = array(
					'name'		=> $sidebar['sidebar_name'],
					'id'		=> catanis_convert_to_class( $sidebar['sidebar_name'] ),
					'location'	=> 'sidebar',
				 	'class' 	=> 'widget-container'
				); 
			}

			/*add the footer sidebars*/
			$sidebar_numbers = array( 'one', 'two', 'three', 'four', 'five', 'six');
			$footer_columns = 4;
			
			if ( $footer_columns != 0 ) {
				for ( $i=1; $i <= $footer_columns; $i++ ) {
					$number = $sidebar_numbers[$i-1];
					$catanis_sidebars[]=array(
						'name'		=> 'Footer Column '. ucfirst( $number ) ,
						'id'		=> 'footer-' . $number,
						'location'	=> 'footer',
						'class' => 'widget-container'
					);
				}
			}

			/*set the main sidebars to the global manager object*/
			$catanis->sidebars = $catanis_sidebars;
		}

		return $catanis->sidebars;
	}
}

if ( ! function_exists( 'catanis_convert_to_class' ) ) {
	/**
	 * Converts a name that consists of more words and different characters to a class (id).
	 * 
	 * @param  string $name the name to be converted
	 * @return string       the converted name
	 */
	function catanis_convert_to_class( $name ) {
		return strtolower( str_replace( array( ' ', ',', '.', '"', "'", '/', "\\",
				'+', '=', ')', '(', '*', '&', '^', '%', '$', '#', '@', '!', '~', '`',
				'<', '>', '?', '[', ']', '{', '}', '|', ':', ';' ), '', $name ) );
	}
}

if ( ! function_exists( 'catanis_get_content_sidebars' ) ) {

	/**
	 * Retrieves all the standard content sidebars.
	 * 
	 * @param string $type option type when load function
	 * @return array containing all the standard content sidebars.
	 */
	function catanis_get_content_sidebars( $type = null ) {
		global $catanis;

		if ( ! isset( $catanis->sidebars) || empty( $catanis->sidebars ) ) {
			catanis_load_sidebar_names();
		}

		$sidebars = array();
		if ( $type == 'default' ) {
			$sidebars[] = array(
				'name' 		=> esc_html__( 'Default', 'onelove' ),
				'id' 		=> 'default',
				'location' 	=> 'sidebar'
			);
		}

		foreach ( $catanis->sidebars as $sidebar ) {
			if ( $sidebar['location'] == 'sidebar' ) {
				$sidebars[] = $sidebar;
			}
		}

		return $sidebars;
	}
}

if ( ! function_exists( 'catanis_register_all_sidebars' ) ) {
	/**
	 * Registers all the sidebars that have been created.
	 * 
	 * @return void
	 */
	function catanis_register_all_sidebars() {
		global $catanis;

		$catanis_sidebars = $catanis->sidebars;
		foreach ( $catanis_sidebars as $sidebar ) {
			catanis_register_sidebar( $sidebar );
		}
	}
}

if ( ! function_exists( 'catanis_register_sidebar' ) ) {
	/**
	 * Registers a single sidebar.
	 *
	 * @param string  $name the name of the sidebar
	 * @param int     $id   the id of the sidebar
	 */
	function catanis_register_sidebar( $sidebar ) {
		$additional_class = isset( $sidebar['class'] ) ? ' ' . $sidebar['class'] : '';

		$sidebar_data = array( 'name'=> $sidebar['name'],
			'id' 			=> $sidebar['id'],
			'before_widget' => '<aside class="' . $sidebar['location'] . '-box %2$s' . $additional_class . '" id="%1$s">',
			'after_widget' 	=> '</aside>',
			'before_title' 	=> '<div class="widget-title-wrapper"><a class="cata-toggle-control" href="javascript:void(0)"></a><h5 class="widget-title heading-title">',
			'after_title' 	=> '</h5></div>',
		);

		register_sidebar( $sidebar_data );
	}
}
?>