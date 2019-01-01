<?php
add_filter( 'wp_nav_menu_args', 'catanis_primary_menu_args' );
function catanis_primary_menu_args( $args ) {

	if( isset( $args['theme_location'] ) && 'catanis_main_menu' == $args['theme_location'] ) {
		$walker = new Catanis_Menu_Walker;
		$args['walker'] = $walker;
	}

	return $args;
}
class Catanis_Menu_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    	
    	if ( $item->menu_item_parent == 0 ) {
	    	if ( in_array( $item->ID, $this->get_mega_menu_items() ) ) {
	    	
	    		$menu_name = 'catanis_main_menu';
	    		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
	    			$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	    			$menu = wp_get_nav_menu_items($menu->term_id);
	    			
	    			$item->classes[] = 'cata-megamenu-columns-' . $this->getMenuChilds($menu, $item->ID);
	    		}  
	    		
	    		$item->classes[] = 'mega-menu-item';
	    	}
	    }
	    
	    /* Remove 'menu-item-has-children' class from elements beyond the second depth level*/
	  	if( $depth > 1 && isset( $item->classes ) && is_array( $item->classes ) && ( $key = array_search( 'menu-item-has-children', $item->classes ) ) !== false ) {
	    	unset( $item->classes[ $key ] );
	    }

        parent::start_el( $output, $item, $depth, $args, $id );
    }
	
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		if( $depth < 2 ) {
			$output .= "\n$indent<ul class='sub-menu'>\n";
		} elseif( $depth >= 2 ) {
			$output .= "\n$indent\n"; 
		}
	}
	
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		if( $depth < 2 ) {
			$output .= "$indent</ul>\n";
		} elseif( $depth >= 2 ) {
			$output .= "\n$indent\n";
		}
	}
    
    private function get_mega_menu_items(){
    	if ( ! isset( $this->mega_menu_items ) ) {
    		
    		$mega_menu_items = array();
    		$mega_menu = catanis_option( 'items_mega_menu' );
    		if(is_string($mega_menu)){
    			$mega_menu_items = explode( ',', catanis_option( 'items_mega_menu' ) );
    		}
    		$this->mega_menu_items = $mega_menu_items;
    	}

    	return $this->mega_menu_items;
    }

    private function getMenuChilds( $menu, $parentID ) {
    	
    	$submenu = 0; 
    	foreach( $menu as $item ) {
    		if ( $item->menu_item_parent == $parentID ) {
    			$submenu ++;
    		}
    	}
    	
    	return $submenu;
    }
}


if ( ! function_exists( 'catanis_get_main_menu_parent_items' ) ) {
	function catanis_get_main_menu_parent_items() {
		$items 		= array();
		$menu_name 	= 'catanis_main_menu';
		$locations 	= get_nav_menu_locations();
		
	    if ( isset( $locations[ $menu_name ] ) && $locations[ $menu_name ] != 0 ) {
	    	$menu_id = $locations[ $menu_name ];

			$items = catanis_get_menu_parent_items( $menu_id );

			//get the WPML translated items
			$trans_items = catanis_get_translation_items( $menu_id );
			if ( ! empty( $trans_items ) ) {
				$items = array_merge( $items, $trans_items );
			}

		}

		return $items;
	}
}

if ( ! function_exists( 'catanis_get_menu_parent_items' ) ) {
	function catanis_get_menu_parent_items( $menu_id ) {
		$menu = wp_get_nav_menu_object( $menu_id );

		$menu_items = wp_get_nav_menu_items( $menu->term_id );
		$items = array();

		if ( sizeof( $menu_items ) ) {
			foreach ( $menu_items as $item ) {
				if ( $item->menu_item_parent == 0 ) {
					$items[] = array( 'id' => $item->ID, 'name' => $item->title );
				}
			}
		}

		return $items;
	}
}

if ( ! function_exists('catanis_get_translation_items' ) ) {
	function catanis_get_translation_items( $main_id ) {
		$items = array();
		if ( function_exists( 'icl_object_id' ) && function_exists( 'icl_get_languages' ) ) {
			//get the WPML languages
			$languages = icl_get_languages( 'skip_missing=0' );
			if ( sizeof( $languages ) ) {
				foreach ( $languages as $lang ) {
					$code = $lang['language_code'];
					if ( ! empty( $code ) ) {
						$menu_id_str = icl_object_id( $main_id, 'nav_menu', false, $code );
						if ( ! empty( $menu_id_str ) ) {
							$menu_id = intval( $menu_id_str );
	
							if ( $menu_id != $main_id ) {
								$menu_items = catanis_get_menu_parent_items($menu_id);
								
								if ( ! empty( $menu_items ) ) {
									$items = array_merge( $items, $menu_items );
								}
							}
							
						}
					}
				}
			}
		}

		return $items;
	}
}


if ( ! function_exists( 'catanis_option_mega_menu' ) ) {
	function catanis_option_mega_menu() {
		$items = catanis_get_main_menu_parent_items();

		if ( ! empty( $items ) ) {
			return array(
				'name'		=> esc_html__( 'Enable top mega menu', 'onelove' ),
				'id'		=> 'items_mega_menu',
				'type' 		=> 'multicheck',
				'class'		=> 'included',
				'options' 	=> $items,
				's_desc'	=> esc_html__( 'Check top menu item that you want to use mega menu', 'onelove' ),
			);
		}else{
			return array(
				'type' 		=> 'documentation',
				'text' 		=> '<div class="option-input-wrap">
								<p style="margin-bottom:0">' . esc_html__( 'No menu items added into "Catanis Main Menu".', 'onelove' ) . ' </p>
								<p style="margin-top:0"><strong> ' . esc_html__( 'Guide', 'onelove' ) . ':</strong> ' . esc_html__( 'You go to Appearance -> Menus section, create a custom menu and 
								assign the menu as the Catanis Main Menu.', 'onelove' ) . '</p></div>');
		}

	}
}
