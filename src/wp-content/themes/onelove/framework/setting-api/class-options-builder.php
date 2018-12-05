<?php
 /**
 * ============================================================
 * Description: Print Options Page: Main Nav, Sub Nav, UI Control,...
 *
 * @name		Catanis_Options_Builder
 * @copyright	Copyright (c) 2015, Catanithemes LLC
 * @author 		Catanis <info@catanisthemes.com> - <catanisthemes@gmail.com>
 * @link		http://www.catanisthemes.com
 * ============================================================
 */
if ( ! class_exists( 'Catanis_Options_Builder' ) ) {
	class Catanis_Options_Builder extends Catanis_Helper_Field {
	
		public $options_object 	= null;
		private $options		= array();
		
		function __construct( &$options_object ) {
			parent::__construct( $options_object );
			$this->options_object 	= $options_object;
			$this->options 			= $options_object->get_fields();
		}
	
		/**
		 * Checks the type of the option and printing
		 * 
		 * @return 	Html
		 */
		public function inOptionsControl() {
			$i = 0;
			foreach ( $this->options as $option ) {
				
				switch ( $option['type'] ) {
					case 'open':
						$this->inSubNavigation( $option, $i ); 
						break;
						
					case 'subtitle':
						$this->inSubtitle( $option, $i ); 
						break;
						
					case 'close':
						parent::inCloseDiv(); 
						break;
						
					case 'title':
						$i++; 
						break;
						
					case 'custom':
						parent::inCustom( $option ); 
						break;
						
					case 'documentation':
						parent::inTextHeading( $option ); 
						break;
						
					default:
						parent::inControlField( $option ); 
						break;
				}
			}
		}
	
		/**
		 * Prints the subnavigation tabs for each of the main navigation blocks
		 * 
		 * @param 	$option: 	the field infomation (array)
		 * @param 	$i: 		index for tab
		 * @return 	Html
		 */
		protected function inSubNavigation( $option, $i ) {
			$xhtml 	= '';
			$xhtml .= '<div id="tab-' . $i . '" class="op-tab">';
			if ( $option['subtitles'] ) {
				$xhtml .= '<div id="tab-navigation-' . $i . '" class="op-tab-navigation"><ul>';
				foreach ( $option['subtitles'] as $subtitle ) {
					$xhtml .= '<li><a href="#tab-' . $i . '-' . $subtitle['id'] . '" class="tab"><span>' . $subtitle['name'] . '</span></a></li>';
				}
				$xhtml .= '</ul></div>';
			}
			echo trim($xhtml);
		}
	
		/**
		 * Prints content a subtitle tab
		 * 
		 * @param 	$option: 	the field infomation (array)
		 * @param 	$i: 		index for tab
		 * @return 	Html
		 */
		protected function inSubtitle( $option, $i ) {
			echo '<div id="tab-' . $i . '-' . $option['id'] . '" class="op-sub-tab catanis-option-subtab">';
		}
	
		/**
		 * Prints the heading of the options panel include sidebar & intro when theme activated
		 * 
		 * @return 	Html
		 */
		public function inHeaderOption() {
			$xhtml = '';
			if ( isset( $_GET['activated'] ) && $_GET['activated'] == 'true' && 1==2 ) {
				$xhtml .= '<div class="note_box">Welcome to ' . CATANIS_THEMENAME . ' theme! <br/>
								<p>Please you click <b>"Save Changes"</b> button at <b>CATANIS Panel</b> below to initialization default values for site.</p>
							</div>';
			}
			
			if ( isset( $_GET['status'] ) && !empty($_GET['status']) ) {
				$status = $this->options_object->errors[$_GET['status']];
				
				$xhtml .= '<div id="import_message" class="note_box">';
				if( $_GET['status'] == 'import_successful'){
					$xhtml .= '<p class="ajax-import-export-msg"><span class="icon-checkmark"></span><b>' . $status . '</b></p>';
				}else{
					$xhtml .= '<p class="ajax-import-export-msg error"><span class="icon-delete"></span><b>' . $status . '</b></p>';
				}
				$xhtml .= '</div>';
			}
			
			
			$xhtml .= '<div id="catanis-content-container" class="wrap"><h1>Theme Options</h1><form method="post" enctype="multipart/form-data" id="catanis-options-form" data-action="catanis_save_options" data-import="catanis_import_options">';
			if ( function_exists( 'wp_nonce_field' ) ) {
				$xhtml 	.= wp_nonce_field('catanis-theme-update-options', 'catanis-theme-options', true, false );
			}
			$xhtml 	.= '<div id="catanis-sidebar">
							<div class="logo-container"> <div id="logo"></div> </div>
							<div id="op-navigation"><ul>';
	
			$i = 1;
			foreach ( $this->options as $option ) {
	
				if ( $option['type'] == 'title' ) {
					$xhtml 	.= '<li>
									<a href="#tab-' . $i . '">
										<span class="' . esc_attr($option['img']) . '"><i class="fa ' . esc_attr($option['class']) . '"></i></span>' . $option['name'] . '
									</a>
								</li>';
					$i++;
				}
			}
	
			$xhtml .= '</ul></div>
					<div id="follow-catanis">
						<p>Follow Catanis on:</p>
						<ul>
							<li><a href="' . esc_url( "https://twitter.com/catanisthemes" ) . '" title="Follow Our Work on Twitter" target="_blank"><img src="' . CATANIS_IMAGES_URL . 'catanis-twitter.png"></a></li>
							<li><a href="' . esc_url( "https://www.behance.net/catanisthemes" ) . '" title="Follow Our Work on Behance" target="_blank"><img src="' . CATANIS_IMAGES_URL . 'catanis-behance.png"></a></li>
							<li><a href="' . esc_url( "http://themeforest.net/user/catanis" ) . '" title="Follow Our Work on ThemeForest" target="_blank"><img src="' . CATANIS_IMAGES_URL . 'catanis-themeforest.png"></a></li>
							<li><a href="' . esc_url( "http://catanisthemes.com" ) . '" class="icon-catanis" title="Catanis Themes" target="_blank"><img src="' . CATANIS_IMAGES_URL . 'catanis-icon20x20.png" title="Visit Our Website"></a></li>
						</ul></div> 
						<input type="hidden" name="action" value="save">
					</div><div id="catanis-content"><div id="header"><h3 id="theme_name">' . CATANIS_THEMENAME . ' v.' . CATANIS_THEME_VERSION . '</h3><a class="more-button" target="_blank" href="http://themeforest.net/user/catanis/portfolio">More Catanis Themes &rarr;</a></div><div id="options_container">';
			
			
			echo trim($xhtml);
		}
	
		/**
		 * Prints the footer of the options panel
		 * 
		 * @return 	Html
		 */
		public function inFooterOption() {
			
			echo '</div>
					<div id="section-opsave-footer">
						<button type="button" class="catanis-btn btn-primary" id="op-save-button">Save Changes</button>
						
						<a href="javascript:;" class="catanis-btn" id="op-reset-button" data-confirm="' . esc_attr__( 'Are you sure? Resetting will loose all custom values!', 'onelove' ) . '" name="reset_options">Reset to Defaults</a>
					</div>
					<div class="ajax-processing">
						<img src="' . esc_url(CATANIS_IMAGES_URL) . 'ajax-processing.gif">
						<span>Processing..</span>
					</div>
					<p class="ajax-msg-success ajax-msg">Options saved!</p>
					<p class="ajax-msg-error ajax-msg">Options could not be saved.</p>
				</div><div class="clear"></div>
			</form></div>
			
			<div id="formDialog" class="customDialog dialog displayNone" title="">
				<div class="errorFormDialog"></div>
				<div id="contentFormDialog"></div>
				<div class="displayNone squareform_loading">
					<img class="img" src="' . esc_url(CATANIS_IMAGES_URL) . 'loading.gif" alt="">
					<div class="load_message">Loading</div>
				</div>
			</div>';
		}
		
	}
}
?>