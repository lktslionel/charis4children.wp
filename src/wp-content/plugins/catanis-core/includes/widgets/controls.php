<?php
/************************************************
 *  1. Textbox - Catanis_HtmlTextbox
 *	2. Textarea - Catanis_HtmlTextarea
 *	3. Selectbox - Catanis_HtmlSelectbox
 *	4. Checkbox - Catanis_HtmlCheckbox
 *	5. Radio - Catanis_HtmlRadio
 *	6. Button - Catanis_HtmlButton
 *	7. Hidden - Catanis_HtmlHidden
 *	8. Password - Catanis_HtmlPassword
 *	9. Fileupload - Catanis_HtmlFileupload
 ************************************************/

/*============================================================================================*/
/*=== 1. Textbox - Catanis_HtmlTextbox =======================================================*/
if ( !class_exists( 'Catanis_HtmlTextbox' ) ) {
	class Catanis_HtmlTextbox{
		/*
		 * $name 	: Name of textbox
		 * $attr 	: Attributes of textbox ( Id - style - width - class - value ... )
		 * $options	: array options (optional)
		 */
		public static function create( $name = '', $value = '', $attr = array(), $options = null ) {

			$html = '';
				
			/* String sttributes from $attr*/
			$strAttr = '';
			if(count($attr)> 0){
				foreach ($attr as $key => $val){
					if($key != "type" && $key != 'value'){
						$strAttr .= ' ' . $key . '="' . $val . '" ';
					}
				}
			}
				
			$html = '<input type="text" name="' . $name . '" ' . $strAttr . ' value="' . $value . '" />';
				
			if ( isset($options['type']) && !empty($options['type'] ) ) {
				$html = '<input type="' . $options['type'] . '" name="' . $name . '" ' . $strAttr . ' value="' . $value . '" />';
			}

			return $html;
		}
	}
}

/*============================================================================================*/
/*=== 2. Textarea - Catanis_HtmlTextarea =====================================================*/
if ( !class_exists( 'Catanis_HtmlTextarea' ) ) {
	class Catanis_HtmlTextarea{
		/*
		 * $name 	: Name of textarea
		 * $attr 	: Attributes of textarea ( Id - style - width - class - value ... )
		 * $options	: array options (optional)
		 */
		public static function create( $name = '', $value = '', $attr = array(), $options = null ) {

			$html = '';
				
			/* String sttributes from $attr*/
			$strAttr = '';
			if(count($attr)> 0){
				foreach ($attr as $key => $val){
					if($key != "type" && $key != 'value'){
						$strAttr .= ' ' . $key . '="' . $val . '" ';
					}
				}
			}
				
			$html = '<textarea name="'. $name . '" ' . $strAttr . '>' . $value . '</textarea>';

			return $html;
		}
	}
}

/*============================================================================================*/
/*=== 3. Selectbox - Catanis_HtmlSelectbox ===================================================*/
if ( !class_exists( 'Catanis_HtmlSelectbox' ) ) {
	class Catanis_HtmlSelectbox{
		/*
		 * $name 	: Name of Selectbox
		 * $attr 	: Attributes of Selectbox ( Id - style - width - class - value ... )
		 * $options	: array options (optional)
		 * 			  [data]: container array value and label of <option>
		 */
		public static function create( $name = '', $value = '', $attr = array(), $options = null ) {

			$html = '';

			/* String sttributes from $attr*/
			$strAttr = '';
			if(count($attr)> 0){
				foreach ($attr as $key => $val){
					if($key != "type" && $key != 'value'){
						$strAttr .= ' ' . $key . '="' . $val . '" ';
					}					
				}
			}
				
			/* Check value of $value */
			$strValue = '';
			if ( is_array( $value ) ) {
				$strValue = implode( "|", $value );
			} else {
				$strValue = $value;
			}
				
			/* Create value and label of <option>*/
			$strOption = '';
			$data = $options['data'];
			if ( count( $data ) ) {
				foreach ( $data as $key => $val ) {
					$selected = '';
					if ( preg_match( '/^(' . $strValue . ')$/i', $key ) ) {
						$selected = ' selected="selected" ';
					}
					$strOption .= '<option value="' . $key . '" ' . $selected . ' >' . $val . '</option>';
				}
			}
				
			$html = '<select name="' . $name . '" ' . $strAttr . ' >' . $strOption . '</select>';
				
			return $html;
		}
	}
}

/*============================================================================================*/
/*=== 4. Checkbox - Catanis_HtmlCheckbox =====================================================*/
if ( !class_exists( 'Catanis_HtmlCheckbox' ) ) {
	class Catanis_HtmlCheckbox{
		/*
		 * $name 	: Name of checkbox
		 * $attr 	: Attributes of checkbox ( Id - style - width - class - value ... )
		 * $options	: array options (optional)
		 * 			  [current_value]
		 */
		public static function create( $name = '', $value = '', $attr = array(), $options = null ) {

			$html = '';

			/* String sttributes from $attr*/
			$strAttr = '';
			if ( count( $attr ) > 0 ) {
				foreach ( $attr as $key => $val ) {
					if ( $key != "type" && $key != 'value' ) {
						$strAttr .= ' ' . $key . '="' . $val . '" ';
					}
				}
			}
				
			/* Check checkbox checked or not checked*/
			$checked = '';
			if ( isset( $options['current_value'] ) ) {
				if ( $options['current_value'] == $value ) {
					$checked = ' checked="checked" ';
				}
			}
				
			$html = '<input type="checkbox" name="'. $name . '" '. $strAttr . ' value="' . $value . '" ' . $checked  . ' />';

			return $html;
		}
	}
}

/*============================================================================================*/
/*=== 5. Radio - Catanis_HtmlRadio ===========================================================*/
if ( !class_exists( 'Catanis_HtmlRadio' ) ) {
	class Catanis_HtmlRadio{
		/*
		 * $name 	: Name of Radio
		 * $attr 	: Attributes of Radio ( Id - style - width - class - value ... )
		 * $options	: array options (optional)
		 * 				[data]: container a array value and label of radio
		 *  			[separator]: separator each radio button
		 */
		public static function create( $name = '', $value = '', $attr = array(), $options = null ) {

			$html = '';

			/* String sttributes from $attr*/
			$strAttr = '';
			if(count($attr)> 0){
				foreach ($attr as $key => $val){
					if($key != "type" && $key != 'value'){
						$strAttr .= ' ' . $key . '="' . $val . '" ';
					}
				}
			}
				
			$strValue = $value;
			if ( ! isset( $options['separator'] ) ) {
				$options['separator'] = ' ';
			}
				
			$html = '';
			$data = $options['data'];
			if ( count( $data ) ) {
				foreach ( $data as $key => $val ) {
					$checked = '';
					if ( preg_match( '/^(' . $strValue . ')$/i', $key ) ) {
						$checked = ' checked="checked" ';
					}
					$html  .= '<input type="radio" name="' . $name . '" ' . $checked . ' value="' . $key . '"/>'
							. $val  . $options['separator'];
				}
			}

			return $html;
		}
	}
}

/*============================================================================================*/
/*=== 6. Button - Catanis_HtmlButton =========================================================*/
if ( !class_exists( 'Catanis_HtmlButton' ) ) {
	class Catanis_HtmlButton{
		/*
		 * $name 	: Name of button
		 * $attr 	: Attributes of button ( Id - style - width - class - value ... )
		 * $options	: array options (optional)
		 * 			  [type]: button - submit - reset
		 */
		public static function create( $name = '', $value = '', $attr = array(), $options = null ) {

			$html = '';
				
			/* String sttributes from $attr*/
			$strAttr = '';
			if(count($attr)> 0){
				foreach ($attr as $key => $val){
					if($key != "type" && $key != 'value'){
						$strAttr .= ' ' . $key . '="' . $val . '" ';
					}
				}
			}
				
			/* Button type*/
			if ( ! isset($options['type'] ) ) {
				$type = 'submit';
			} else {
				$type = $options['type'];
			}
				
			$html = '<input type="' . $type .'" name="' . $name . '" ' . $strAttr . ' value="' . $value . '" />';

			return $html;
		}
	}
}

/*============================================================================================*/
/*=== 7. Hidden - Catanis_HtmlHidden =========================================================*/
if ( !class_exists( 'Catanis_HtmlHidden' ) ) {
	class Catanis_HtmlHidden{
		/*
		 * $name 	: Name of hidden input
		 * $attr 	: Attributes of hidden input ( Id - style - width - class - value ... )
		 * $options	: array options (optional)
		 */
		public static function create( $name = '', $value = '', $attr = array(), $options = null ) {

			$html = '';
				
			/* String sttributes from $attr*/
			$strAttr = '';
			if ( count( $attr ) > 0 ) {
				foreach ( $attr as $key => $val ) {
					if ( $key != "type" && $key != 'value' ) {
						$strAttr .= ' ' . $key . '="' . $val . '" ';
					}
				}
			}
				
			$html = '<input type="hidden" name="' . $name . '" ' . $strAttr . ' value="' . $value . '" />';

			return $html;
		}

	}
}

/*============================================================================================*/
/*=== 8. Password - Catanis_HtmlPassword =====================================================*/
if ( !class_exists( 'Catanis_HtmlPassword' ) ) {
	class Catanis_HtmlPassword{
		/*
		 * $name 	: Name of password
		 * $attr 	: Attributes of password ( Id - style - width - class - value ... )
		 * $options	: array options (optional)
		 */
		public static function create( $name = '', $value = '', $attr = array(), $options = null ) {

			$html = '';

			/* String sttributes from $attr*/
			$strAttr = '';
			if ( count( $attr ) > 0 ) {
				foreach ( $attr as $key => $val ) {
					if ( $key != "type" && $key != 'value' ) {
						$strAttr .= ' ' . $key . '="' . $val . '" ';
					}
				}
			}

			$html = '<input type="password" name="' . $name . '" ' . $strAttr . ' value="' . $value . '" />';

			return $html;
		}
	}
}

/*============================================================================================*/
/*=== 9. Fileupload - Catanis_HtmlFileupload =================================================*/
if ( !class_exists( 'Catanis_HtmlFileupload' ) ) {
	class Catanis_HtmlFileupload{
		/*
		 * $name 	: Name of Fileupload
		* $attr 	: Attributes of Fileupload ( Id - style - width - class - value ... )
		* $options	: array options (optional)
		*/
		public static function create( $name = '', $value = '', $attr = array(), $options = null ) {

			$html = '';
				
			/* String sttributes from $attr*/
			$strAttr = '';
			if ( count( $attr ) > 0 ) {
				foreach ( $attr as $key => $val ) {
					if ( $key != "type" && $key != 'value' ) {
						$strAttr .= ' ' . $key . '="' . $val . '" ';
					}
				}
			}
				
			$html = '<input type="file" name="' . $name . '" ' . $strAttr . ' value="' . $value . '" />';

			return $html;
		}
	}
}
?>