<?php
if ( ! class_exists( 'Catanis_Widget_Html' ) ) {
	class Catanis_Widget_Html {
		
		public function __construct( $options = null ) {}
		
		public function control( $control, $name = '', $value = '', $attr = array(), $options = null ) {
			$output = '';
			
			switch ( $control ) {
				case 'textbox':
					$output = Catanis_HtmlTextbox::create( $name, $value, $attr, $options );
					break;
					
				case 'textarea':
					$output = Catanis_HtmlTextarea::create( $name, $value, $attr, $options );
					break;
					
				case 'selectbox':
					$output = Catanis_HtmlSelectbox::create( $name, $value, $attr, $options );
					break;
					
				case 'checkbox':
					$output = Catanis_HtmlCheckbox::create( $name, $value, $attr, $options );
					break;
					
				case 'radio':
					$output = Catanis_HtmlRadio::create( $name, $value, $attr, $options );
					break;
					
				case 'button': 
					$output = Catanis_HtmlButton::create( $name, $value, $attr, $options );
					break;
					
				case 'password':
					$output = Catanis_HtmlPassword::create( $name, $value, $attr, $options );
					break;
					
				case 'hidden':
					$output = Catanis_HtmlHidden::create( $name, $value, $attr, $options );
					
					break;
					
				case 'fileupload':
					$output = Catanis_HtmlFileupload::create( $name, $value, $attr, $options );
					break;
			}
			
			return $output;
		}
		
		public function labelTag( $text, $attr = array(), $checkbox = false ) {
			$strAttr = '';
			if ( is_array( $attr ) && count( $attr ) > 0 ) {
				foreach ( $attr as $key => $val ) {
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
			
			if ( $checkbox == true ) {
				return '<label'.$strAttr.'> ' . $text . '</label>';
			} else {
				return '<label' . $strAttr . '>' . $text . ':</label>';
			}
		}
		
		public function infoText( $text, $attr = array() ) {
			$strAttr = '';
			if ( is_array( $attr ) && count( $attr ) > 0 ) {
				foreach ( $attr as $key => $val ) {
					if ( $key != 'class' ) {
						$strAttr .= ' ' . $key . '="' . $val . '" ';
					}
				}
			}
		
			return '<p' . $strAttr . ' class="wg-cls-info">' . $text . '</p>';
		}
		
		public function generalItem( $content, $attr = array() ) {
			$strAttr = '';
			if ( is_array( $attr ) && count( $attr ) > 0 ) {
				foreach ( $attr as $key => $val ) {
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
			
			return '<p' . $strAttr . '>' . $content . '</p>';
		}
		
		public function taxonomy_upload_thumbnail($image = '', $thumbnail_id = 0){
			
			$real_image = !empty( $image ) ? $image : CATANIS_FRONT_IMAGES_URL . 'placeholder.png';
			return '<div id="cata_category_thumbnail" data-src="' . CATANIS_FRONT_IMAGES_URL . 'default/placeholder.png">
					<img src="' . esc_url($real_image) . '" />
				</div>
				<div>
					<input type="hidden" id="cata_category_thumbnail_id" name="category_thumbnail_id" value="' . $thumbnail_id . '" />
					<button type="button" class="upload_image_button_tax button">' . esc_html__( 'Upload/Add image', 'onelove' ) . '</button>
					<button type="button" class="cata-remove-image-button button">' . esc_html__( 'Remove image', 'onelove' ) . '</button>
				</div>
				<div class="clear"></div>';
		}
		
		public function pt_generalItem_tr( $label, $input ) {
			
			return '<tr class="form-field">
						<th scope="row" valign="top">' . $label . '</th>
						<td>' . $input . '</td>
					</tr>';
		}
		
		public function pt_generalItem_div( $label, $input ) {
		
			return '<div class="form-field">' . $label . $input . '</div>';
		}
	}
}
?>