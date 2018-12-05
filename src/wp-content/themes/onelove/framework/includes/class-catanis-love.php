<?php
/**
 * ============================================================
 * Description: Adds a "Love It" link to portfolio, post,...
 *
 * @name		Catanis_Love
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 */
if( !class_exists('Catanis_Love') ){
	class Catanis_Love {
		
		function __construct()   {	
			
	        add_action( 'wp_ajax_cata-love', array( &$this, 'cata_love' ) );
			add_action( 'wp_ajax_nopriv_cata-love', array( &$this, 'cata_love' ) );
		}
		
		/*=== Ajax love ===*/
		function cata_love( $post_id ) {
			
			if ( isset( $_POST['loves_id'] ) ) { /*update meta post*/ 
				$post_id = str_replace( 'cata-love-', '', $_POST['loves_id']);
				echo ($this->love_post( $post_id, 'update' ));
			} 
			else { /*get meta post*/
				$post_id = str_replace( 'cata-love-', '', $_POST['loves_id'] );
				echo ($this->love_post( $post_id, 'get' ));
			}
			
			exit;
		}
		
		/*=== Love output count ===*/
		function love_post( $post_id, $action = 'get' ) {
			
			if ( ! is_numeric( $post_id ) ) { 
				return;
			}
			
			switch ( $action ) {
			
				case 'get':
					$love_count = get_post_meta($post_id, '_catanis_love', true );
					if ( ! $love_count ){
						$love_count = 0;
						add_post_meta( $post_id, '_catanis_love', $love_count, true );
					}
					
					$love_count = ( $love_count <= 5000 ) ? $love_count : '5000+' ;
					return '<span class="cata-love-count">' . $love_count . '</span>';
					break;
					
				case 'update':
					$love_count = get_post_meta( $post_id, '_catanis_love', true );
					if ( isset( $_COOKIE['catanis_love_'. $post_id] ) ) { 
						return $love_count;
					}
					
					$love_count++;
					update_post_meta( $post_id, '_catanis_love', $love_count);
					setcookie( 'catanis_love_'. $post_id, $post_id, time()*20, '/' );
					
					return '<span class="cata-love-count">' . $love_count . '</span>';
					break;
			}
		}
	
		/*=== Love output html ===*/
		function add_love() {
			global $post;

			$output = $this->love_post( $post->ID );
	  
	  		$class = 'cata-love';
	  		$title = esc_html__( 'Love this', 'onelove' );
	  		$title_loved = esc_html__( 'You already love this!', 'onelove' );
			
			if( isset( $_COOKIE['catanis_love_' . $post->ID] ) ){
				$class .= ' loved';
				$title = esc_html__( 'You already love this!', 'onelove' );
			}
			
			return '<a href="#" class="' . $class . '" id="cata-love-' . $post->ID . '" title="' . $title . '" data-loved="' . $title_loved . '"> <i class="fa fa-heart-o"></i>' . $output .'</a>';
		}
		
		/*=== Get love output ===*/
		function get_love( $return = false ) {
		
			if ( $return ) {
				return $this->add_love();
			} else {
				echo ($this->add_love());
			}
		}
		
	}
	
	global $catanis;
	$catanis->love = new Catanis_Love();
}
?>