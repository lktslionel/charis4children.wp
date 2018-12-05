<?php
if( !class_exists('Catanis_Helper_Field') ){
	class Catanis_Helper_Field{
	
		public $objData 	= null;
		
		function __construct( &$objData ) {
			$this->objData 	= $objData;
		}
		
		/**
		 * Prints a closing div tag
		 * 
		 * @return 	Html
		 */
		protected function inCloseDiv() {
			echo '</div>';
		}
		
		/**
		 * Prints custom control with Add button such as social media with different options - name, link, etc.
		 * 
		 * @param 	$option: 	the field infomation (array)
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name"=>"Add Share Social",
		 * 		"id"=>'share_social',
		 * 		"type"=>"custom",
		 * 		"btnText"=>'Add',
		 * 		"preview"=>"social_image_name",
		 *  	"fields"=>array(
		 *   		array('id'=>'social_image_name', 'type'=>'upload', 'name'=>'Social URL'),
		 *   		array('id'=>'social_image_title', 'type'=>'text', 'name'=>'Social Title'),
		 *   		array('id'=>'social_image_desc', 'type'=>'textarea', 'name'=>'Social Description')
		 * 		)
		 *)
		 * ------------------------------------------------------------------------------------------
		 */
		protected function inCustom( $option ) {
			$xhtml = '';
			$xhtml .= '<div id="' . $option['id'] . '" >';
	
			$val = $this->objData->get_value( $option['id'] );
			$preview 	= isset( $option['preview'] ) ? 'preview:"' . $option['preview'] . '",' : '';
			$editable 	= isset( $option['editable'] ) && !$option['editable'] ? 'editable:false,' : '';
			$btnText 	= isset( $option['btnText'] ) ? 'btnAddText:"' . $option['btnText'] . '",' : '';
			$bind_to 	= isset( $option['bind_to'] ) ? $option['bind_to'] : null;
	
			/* call the script that enables the functionality for adding custom fields */
			$xhtml .= '<script type="text/javascript">
				jQuery(document).ready(function($){
					$("#' . $option["id"] . '").catanisCustomField({fields:' . json_encode( $option['fields'] ) . ',
						values:' . json_encode( $val ) . ',
						' . $preview . '
						' . $btnText . '
						' . $editable . '
						element:$("#' . $option["id"] . '"),
						parent:$("#catanis-content-container"),
						bindTo:' . json_encode( $bind_to ) . '
					});
				});
			</script>';
	
			$xhtml .= '</div>';
	
			$this->inBeforeField( $option );
			echo trim($xhtml);
			$this->inAfterField( $option );
			
		}
	
		/**
		 * Prints text heading intro (type: documentation)
		 * 
		 * @return 	Html
		 */
		protected function inTextHeading( $option ) {
			$this->inBeforeField( $option );
			if ( isset( $option['text'] ) ) {
				echo "<h4>" . $option['text'] . '</h4>';
			}
			$this->inAfterField( $option );
		}
	
		/**
		 * Prints text heading intro (type: documentation)
		 *
		 * @return 	Html
		 */
		protected function inTextDocument( $option ) {
			$this->inBeforeField( $option );
			if ( isset( $option['text'] ) ) {
				echo '<div class="docs">' . $option['text'] . '</div>';
			}
			$this->inAfterField( $option );
		}
		
		/**
		 * Print html before field option
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$multi: 	yes or no multi-option in field
		 * @return 	Html
		 */
		protected function inBeforeField( $field, $multi = false ) {
			$clsSelect 	= !empty( $field['extClass'] ) ? ' ' . $field['extClass'] : '';
			$multiclass = $multi ? ' multi-option option-fields-' . sizeof( $field["fields"] ) . $clsSelect : ' '. $clsSelect;
			
			$data = "";
			
			/* add data attribute if it is set */
			if ( isset( $field["data"] ) ) {
				foreach ( $field["data"] as $key => $value ) {
					$data	.= ' data-' . $key . '="' . $value . '"';
				}
			}
			if ( isset( $field["optstyle"] ) ) {
				$data	.= ' style="' . $field["optstyle"] .'"';
			}
			
			$additional_class = isset( $field['suffix'] ) ? ' with-suffix' : '';
			$html 	= '<div class="option' . $multiclass . ' option-'.$field['type'] . $additional_class . '"' . $data . '>';
			if ( $field['type'] != 'documentation' ) {
				$html 	= '<div data-option-id="' . $field["id"] . '" class="option' . $multiclass . ' option-'.$field['type'] . $additional_class . '"' . $data . '>';
			}
			
			if ( isset( $field['name'] ) ) {
				$s_desc = ( isset( $field['s_desc'] ) ) ? $field['s_desc'] : '';
				$html	.= '<h6>' . $field['name'] . '<i>' . $s_desc . '</i></h6>';
			}
				
			if ( $field['type'] != 'documentation' ) {
				$html 	.= '<div class="option-input-wrap">';
			}
			
			echo trim($html);
		}
		
		/**
		 * Check type of field and Print control
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @return 	Html
		 */
		public function inControlField( $field, $saved = null ) {

			$saved_val = ( $saved != null ) ? $saved : $this->objData->get_value( $field['id'] );
			switch ( $field['type'] ) {
				case 'text': 
					$this->inTextInput( $field, $saved_val ); 
					break;
					
				case 'textarea': 
					$this->inTextarea( $field, $saved_val ); 
					break;
					
				case 'select': 
					$this->inSelect( $field, $saved_val ); 
					break;
					
				case 'multicheck':
					$this->inMultiCheckbox( $field, $saved_val ); 
					break;
					
				case 'color':
					$this->inColor( $field, $saved_val ); 
					break; 
					
				case 'slider':
					$this->inSlider( $field, $saved_val ); 
					break;
					
				case 'linkupload':
					$this->inLinkUpload( $field, $saved_val );
					break;
					
				case 'upload':
					$this->inUpload( $field, $saved_val ); 
					break;
					
				case 'multiupload':
					$this->inMultiUpload( $field, $saved_val );
				break;
					
				case 'checkbox':
					$this->inCheckbox( $field, $saved_val ); 
					break;
					
				case 'radio':
					$this->inRadio( $field, $saved_val ); 
					break;
					
				case 'imageradio':
					$this->inImageRadio( $field, $saved_val ); 
					break;
				case 'imageradio2':
					$this->inImageRadio_v2( $field, $saved_val );
					break;
				case 'styleimage':
					$this->inStylebox( $field, $saved_val, 'image' ); 
					break;
					
				case 'stylepattern':
					$this->inStylebox( $field, $saved_val, 'pattern'); 
					break;
					
				case 'stylecolor':
					$this->inStylebox( $field, $saved_val, 'color' ); 
					break;
					
				case 'stylefont':
					$this->inStylebox( $field, $saved_val, 'font' ); 
					break;
					
				case 'editor':
					$this->inEditor( $field, $saved_val ); 
					break;
					
				case 'google_map':
					$this->inGoogleMap( $field, $saved_val ); 
					break;
					
				case 'border':
					$this->inBorder( $field, $saved_val ); 
					break;
					
				case 'datepicker':
					$this->inDatepicker( $field, $saved_val ); 
					break;
					
				case 'import':
					$this->inImport( $field, $saved_val ); 
					break;
					
				case 'export':
					$this->inExport( $field, $saved_val ); 
					break;
					
				case 'multioption':
					$this->inBeforeField( $field, true );
					foreach ( $field["fields"] as $sub_field ) {
						$new_field = $sub_field;
						$new_field['id'] = $field['id'].'['.$sub_field['id'].']';
						if(isset($saved_val[ $sub_field['id']])){
							$this->inControlField( $new_field , $saved_val[ $sub_field['id']] );
						}else{
							$this->inControlField( $new_field , $sub_field['std'] );
						}
					}
					$this->inAfterField( $field );
					break;
			}
		}
		
		/**
		 * Print html after field option
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @return 	Html
		 */
		protected function inAfterField( $field ) {
			if ( $field['type'] != 'documentation' ) {
				echo '</div>';
			}
			/* print description popup */
			if ( isset( $field['desc'] ) ) {
				echo '<div class="help-button icon-info2" data-title="' . esc_attr($field['name']) . '"><div class="dialog-content"><p>' . $field['desc'] . '</p></div></div>';
			}
			echo '</div>'; /* close div of main option */
		}
		
		/**
		 * Print input control
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Seo title",
		 * 		"id" 		=> "seo_title",
		 * 		"type" 		=> "text",
		 * 		"s_desc"	=> "This is description",
		 * 		"large" 	=> true
		 *)
		 * ------------------------------------------------------------------------------------------
		 */
		public function inTextInput( $field, $saved_val ) {
	
			$this->inBeforeField( $field );
			$large = ( isset( $field['large']) ) ? ' style="width: 100%;"' : '' ;
			echo '<input class="option-input" name="' . $field['id'] . '" id="' . $field['id'] . '" type="' . $field['type'] . '" value="' . htmlspecialchars( $saved_val ) . '"' . $large . ' />';
			if ( isset( $field['suffix'] ) ) {
				echo '<span class="option-suffix">' . $field['suffix'] . '</span>';
			}
			$this->inAfterField( $field );
		}
		
		/**
		 * Print textarea control
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Seo description",
		 * 		"id" 		=> "seo_description",
		 * 		"type" 		=> "textarea",
		 * 		"s_desc"	=> "This is description",
		 * 		"large" 	=> true
		 *)
		 * ------------------------------------------------------------------------------------------
		 */
		public function inTextarea( $field, $saved_val ) {
			$this->inBeforeField( $field );
			if( !in_array($field['id'], array('before_head_end_code', 'before_body_end_code' ))  ){
				$saved_val = wp_kses_post($saved_val);
			}
			$additional_style = isset( $field['style'] ) && !empty( $field['style'] ) ? ' style="' . $field['style'] . '" ' : '';
			echo ' <textarea name="' . $field['id'] . '" id="'. $field['id'] . '" class="option-textarea" cols="" rows="" ' . $additional_style . '>' . $saved_val . '</textarea>';
			$this->inAfterField( $field );
		}
		
		/**
		 * Print select control with select group (option)
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Post layout",
		 * 		"id" 		=> "post_layout",
		 * 		"type" 		=> "select",
		 * 		"s_desc"	=> "This is description",
		 * 		"std" 		=> "right"
		 * 		"options" 	=> array(
		 * 				array( "type"=>"group", "label"=>"Group One"), // (option)
		 * 				array( "type"=>"groupend"),// (option)
		 * 				array( "id"=>"right", "name"=>"Right Sidebar" ),
		 * 				array( "id"=>"left", "name"=>"Left Sidebar" ),
		 * 				array( "id"=>"full", "name"=>"Full width" ) ,
		 * 				array( "type"=>"group", "label"=>"Group Two"),// (option)
		 *				array( "type"=>"groupend"),// (option)
		 *				array( "id"=>"footer", "name"=>"Footer" ),
		 *				array( "id"=>"header", "name"=>"Header" )
		 * 		)
		 *)
		 * ------------------------------------------------------------------------------------------
		 */
		public function inSelect( $field, $saved_val ) {
			
			$xhtml 	= '';
			$dataName = str_replace( array( '[',']'), '_', $field['id'] );
			// input extend class "select-chosen" if want seach in selectbox
			$xhtml .= '<select name="' . $field['id'] . '" class="option-select ' . $field['id'] . '" id="' . $field['id'] . '">';
		
			if ( is_array( $field['options'] ) ) {
				foreach ( $field['options'] as $option ) {
					if ( isset( $option['type'] ) ) {
						if ( $option['type'] == 'group' ) {
							$xhtml .= '<optgroup label="' . $option['label'] . '">';
						} elseif ( $option['type'] == 'groupend' ) {
							$xhtml .= '</optgroup>';
						}
					} else {
						$attr = '';
						if ( $saved_val == $option['id'] ) {
							$attr = ' selected="selected"';
						}
						if ( $option['id'] == 'disabled' ) {
							$attr 	.= ' disabled="disabled"';
						}
						if ( isset( $option['class'] ) ) {
							$attr	.=' class="' . $option['class'] . '"';
						}
						$xhtml .= '<option ' . $attr . ' value="' . $option['id'] . '">' . stripcslashes( $option['name'] ) . '</option>';
					}
				}
			}
			$xhtml .= '</select>';
			//*for choosen class */$xhtml .= '<input type="hidden" id="' . $field['id'] . '" name="' . $field['id'] . '" alt="' . $dataName . '" value="' . $saved_val . '">';
			
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		/**
		 * Print multi checkbox control
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Show post info",
		 * 		"id" 		=> "show_post_info",
		 * 		"type" 		=> "multicheck",
		 * 		"class" 	=> "exclude", //exclude|include
		 * 		"std"		=> "This is description",
		 * 		"s_desc"	=> array(1,2),  // default value
		 * 		"options" 	=> array(array("id"=>1, "name"=>"Post Date"), array("id"=>2, "name"=>"Post Author"))
		 *)
		 * ------------------------------------------------------------------------------------------
		 */
		public function inMultiCheckbox( $field, $saved_val ) {
			
			$xhtml = '';
			if ( is_string( $saved_val ) ) {
				$saved_val = explode( ',', $saved_val );
			}
			
			$checked_class = $field['class'] == '' ? 'included' : $field['class'];
			$xhtml .= '<div class="option-check ' . $checked_class . '"  id="' . $field['id'] . '">';
		
			foreach ( $field['options'] as $sub_option ) {
				$class='';
				
				if ( !empty( $saved_val ) && in_array( $sub_option['id'], $saved_val ) ) {
					$class = ' selected';
				}
				$xhtml .= '<div class="check-holder ' . $class . '" data-val="' . $sub_option['id'] . '"><span class="check icon-checkmark" aria-hidden="true" ></span><span class="check-value">' . $sub_option['name'] . '</span></div>';
			}
			$xhtml .= '</div>';
		
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		/**
		 * Print color picker control
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Header Color",
		 * 		"id" 		=> "header_color",
		 * 		"type" 		=> "color",
		 * 		"std" 		=> "#ffee44",
		 * 		"s_desc"	=> "This is description"
		 *)
		 * ------------------------------------------------------------------------------------------
		 */
		public function inColor( $field, $saved_val ) {
			$this->inBeforeField( $field );
			$field['std'] = ( isset( $field['std'] ) ) ? $field['std'] : '';
			echo '<input class="option-input color" data-alpha="true" name="' . $field['id'] . '" id="' . $field['id'] . '" type="text" value="' . $saved_val . '" data-default-color="' . $field['std'] . '" />';
			$this->inAfterField( $field );
		}
		
		/**
		 * Print slider control
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Font size",
		 * 		"id" 		=> "font_size",
		 * 		"type" 		=> "slider",
		 * 		"suffix"	=> "px",
		 * 		"min"		=> "8",
		 * 		"max"		=> "70",
		 * 		"step"		=> "px",
		 * 		"std" 		=> "15",
		 * 		"s_desc"	=> "This is description"
		 *)
		 * ------------------------------------------------------------------------------------------
		 */
		public function inSlider( $field, $saved_val ) {
			$dataName = str_replace( array( '[', ']' ), '_', $field['id'] );
			$this->inBeforeField( $field );
			echo '<div class="slider-option" data-id="' . $field['id'] . '"></div>
				  <input class="option-input" name="' . $field['id'] . '" id="' . $field['id'] . '" type="text" value="' . $saved_val . '" data-min="' . $field['min'] . '" data-max="' . $field['max'] . '" data-step="' . $field['step'] . '" readonly="readonly" alt="' . $dataName . '" />
				  <span class="option-suffix">' . $field['suffix'] . '</span>';
			$this->inAfterField( $field );
		}
		
		/**
		 * Display a input hidden field, support for other fields
		 * 
		 * @param string $inputName
		 * @param string $inputID
		 * @param string $fieldClass
		 * @param array $options
		 * @return Html
		 */
		protected function inHiddenInput( $inputName, $inputID = '', $inputClass = '', $options = array() ) {
			
			global $post;
			
			$extInput = '';
			if(isset($post) && !empty($post)){
				
				$extInputVal = '';
				$inputID = empty( $inputID ) ? $inputName : $inputID;
				$post_meta 	= get_post_meta( $post->ID, Catanis_Meta::$meta_key, true );
				if ( isset( $post_meta[$inputName] ) ) {
					$extInputVal = trim( $post_meta[$inputName] );
				}
				$extInput = '<input type="hidden" name="' . $inputName . '" id="' . $inputID . '" class="' . $inputClass . '" value="' . $extInputVal . '">';
			}
			
			return $extInput;
		}
		
		
		/**
		 * Print upload image control
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Logo Image",
		 * 		"id" 		=> "logo_image",
		 * 		"type" 		=> "upload",
		 * 		"s_desc"	=> "This is description"
		 *)
		 * ------------------------------------------------------------------------------------------
		 */
		public function inUpload( $field, $saved_val ) {
			
			$xhtml 		= $data = $styleWrap = $styleBtn = '';
			$classThumb = isset($field['is-thumb']) ? ' is-thumb' : '';
			$extInput 	= $this->inHiddenInput($field['id']. '_id', '', 'imgid');
			if(!empty($saved_val)){
				$data.=' data-url="' . htmlspecialchars( $saved_val ) . '"';
				$data.=' data-thumbnail="' . $saved_val . '"';
				/* $data.=' data-thumbnail="'.catanis_get_resized_image($saved_val, 150, 150).'"'; */
				$styleWrap 	= ' style="display:block;"';
				$styleBtn 	= ' style="display: none;"';
			}
			$xhtml 	.= '<div class="catanis-upload"' . $data . '>
							<div class="upload-image-wrapper' . $classThumb . '"' . $styleWrap . '>
								<img src="' . $saved_val . '" class="upload-preview">
								<div class="upload-remove-image"><span class="icon-delete2"></span>Remove Upload</div>
							</div>
							<button type="button" data-choose="Choose a File" data-update="Select File" class="catanis-btn btn-icon catanis-opts-upload"' . $styleBtn . '><span class="icon-popup"></span>Browse</button>
							<input type="hidden" id="' . $field['id'] . '" name="' . $field['id'] . '" class="imgurl" value="' . $saved_val . '">
							'. $extInput .'
						</div>';
			
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		/**
		 * Print upload link control
		 *
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 			=> "MP4 Link",
		 * 		"id" 			=> "mp4_link",
		 * 		"type" 			=> "linkupload",
		 * 		"upload_type" 	=> 'image', 		//image,audio,video
		 * 		"s_desc"		=> "This is description"
		 *)
		 * ------------------------------------------------------------------------------------------
		 */
		public function inLinkUpload( $field, $saved_val ) {
			
			$large = ( isset( $field['large']) ) ? ' style="width: 100%;"' : '' ;
			$xhtml 	= '<div class="catanis-link-upload">
							<input type="text" id="' . $field['id'] . '" name="' . $field['id'] . '" value="' . $saved_val . '"' . $large . '>
							<button type="button" data-type-upload="' . $field['upload_type'] . '" data-choose="Choose a File" data-update="Select File" class="catanis-btn btn-icon catanis-upload-media-button"><span class="icon-popup"></span>Browse</button>
							<button type="button" class="catanis-btn catanis-remove-media-button" style="display:none;">Remove</button>
						</div>';
				
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}

		/**
		 * Print multi upload control
		 *
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "My Gallery",
		 * 		"id" 		=> "my_gallery",
		 * 		"type" 		=> "multiupload",
		 * 		"s_desc"	=> "This is description"
		 *)
		 * ------------------------------------------------------------------------------------------
		 */
		public function inMultiUpload( $field, $saved_val ) {
			$xhtml 	= $data = $styleWrap = $styleBtn = '';
				
			$data = 'data-fieldid="'. $field['id'] .'"';
			if(!empty($saved_val)){
				$images 	= explode(',', $saved_val);
				$img_data 	= array();
				
				if(sizeof($images)){
					foreach ($images as $imgid) {
						$thumbnail 	= wp_get_attachment_image_src( intval($imgid), 'thumbnail');
						$img_data[]	= array('id' => $imgid, 'thumbnail' => $thumbnail[0]);
					}
					$data	.=' data-images="'.esc_attr(json_encode($img_data)).'"';
				}
			}
		
			$xhtml 	.= '<div class="catanis-multiupload"' . $data . '></div>';
				
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		
		/**
		 * Print checkbox control
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 * 
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Checkbox Name",
		 * 		"id" 		=> "check_id",
		 * 		"type" 		=> "checkbox",
		 * 		"std" 		=> "on",
		 * 		"s_desc"	=> "This is description"
		 *)
		 * ------------------------------------------------------------------------------------------
		 */
		public function inCheckbox( $field, $saved_val ) {
			$xhtml = '';
			
			if ( $saved_val === true || $saved_val=="true" ) {
				$def_class = 'on';
			} else {
				$def_class = 'off';
			}
			$xhtml 	.= '<div class="on-off ' . $def_class . '" id="' . $field['id'] . '">
							<em class="on-text">on</em>
							<span class="handle"><i class="icon-flickr"></i></span>
							<em class="off-text">off</em>
						</div>';
			
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		/**
		 * Print list color or list image
		 *  
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @param 	$type: 		"color" or "image" or "pattern"
		 * @return 	Html
		 * 
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Theme Image",
		 * 		"id" 		=> "theme_image",
		 * 		"type" 		=> "styleimage",
		 * 		"s_desc"	=> "This is description",
		 * 		'options'=> array( "1col.png"=>'Full width', "2cl.png"=>'Sidebar Left', "2cr.png"=>'Sidebar Right')
		 * )
		 * array(
		 * 		"name" 		=> "Theme Color",
		 * 		"id" 		=> "theme_color",
		 * 		"type" 		=> "stylecolor",
		 * 		"s_desc"	=> This is description,
		 * 		"options" 	=> array( "0074A2"=>"none", "ED6C71"=>"none", "222222"=>"none")
		 * )
		 * array(
		 * 		"name" 		=> "Body Background Pattern",
		 * 		"id" 		=> "background_pattern",
		 * 		"type" 		=> "stylepattern",
		 * 		"s_desc" 	=> "Body Background Pattern",
		 * 		"options"	=> array( "pattern01.png", "pattern02.png", "pattern03.png")
		 * )
		 * ------------------------------------------------------------------------------------------
		 */
		public function inStylebox( $field, $saved_val, $type ) {
			$xhtml 		= '';
			$extClass 	= !empty( $field['extClass'] ) ? ' ' . $field['extClass'] : '';
			$xhtml 		.= '<div class="button-option' . $extClass . '" id="' . $field['id'] . '"><ul>';
		
			foreach ( $field['options'] as $option ) {
				$class 	= ( isset( $option['id'] ) && $option['id'] == $saved_val ) ? ' selected' : '';
				$desc	= ( ! empty( $option['title'] ) && $option['title'] != 'none' ) ? '<span>' . $option['title'] . '</span>' : '';
				if ( $type == 'image' ) {	
					$xhtml 	.= '<li class="box-img">
									<a class="style-box' . $class . '" rel="' . $option['id'] . '" title="' . $option['title'] . '" href="javascript:;">
										<img src="' . $option['img'] . '" alt="' . $option['title'] . '">
									</a>' . $desc . '
								</li>';
					
				} elseif ( $type=='pattern' ) {
					$xhtml 	.= '<li>
									<a class="style-box' . $class . '" rel="'.$option['id'] . '" title="' . $option['title'].'" href="javascript:;">
										<img src="' . $option['img'] . '" alt="' . $option['title'] . '">
									</a>		
								</li>';
					
				} elseif ( $type=='color' ) {
					$style = 'background-color:' . $option['color'] . ';';
					$xhtml .= '<li style="' . $style . '" class="colour"><a class="style-box' . $class . '" title="' . $option['color'] . '" rel="' . $option['color'] . '" href="javascript:;"></a></li>';
				
				} elseif ( $type == 'font' ) {
					$class 	= ( $option['image'] == $saved_val ) ? ' selected' : '';
					$xhtml 	.= '<li>
									<a class="'.$class.'" rel="' . $option['image'] . '" title="' . $option['title'] . '" href="javascript:;">
										<span class="' . $option['image'] . '" alt="' . $option['title'] . '"></span>
									</a>
								</li>';
				}
			}
			
			$xhtml .= '</ul></div>';
			
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		/**
		 * Print editor control
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Main Content",
		 * 		"id" 		=> "main_content",
		 * 		"type" 		=> "editor",
		 * 		"s_desc"	=> "This is description"
		 * )
		 * ------------------------------------------------------------------------------------------
		 */
		public function inEditor( $field, $saved_val ) {
			
			$dfw = !empty( $field['dfw'] ) ? $field['dfw'] : false;
			$settings = array( 'textarea_name' => $field['id'], 'dfw' => $dfw, 'textarea_rows' => get_option( 'default_post_edit_rows', 15 ) );
			
			$this->inBeforeField( $field );		
			echo wp_editor( $saved_val, $field['id'], $settings );
			$this->inAfterField( $field );
		}
		
		/**
		 * Print gogole map
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Contact map",
		 * 		"id" 		=> "contact_map",
		 * 		"type" 		=> "google_map",
		 * 		"s_desc"	=> "This is description"
		 * )
		 * ------------------------------------------------------------------------------------------
		 */
		public function inGoogleMap( $field, $saved_val ) {
			
			$this->inBeforeField( $field );
			echo '<div id="' . $field['id'] . '" class="google-map">
					<input type="text" name="' . $field['id'] . '[address]" id="' . $field['id'] . '_address" value="' . $saved_val['address'] . '" class="map-address">
					<div class="wrap_map">
						<h5> 
							<span class="icon-location"></span><strong> Map</strong>
							<i>'.esc_html__('You can drag and drop the marker to the correct location', 'onelove').'</i>
					 	</h5>    	
						<div class="' . $field['id'] . '_show map_show"></div>
					</div>
					<input type="hidden" name="' . $field['id'] . '[lat]" value="' . $saved_val['lat'] . '" class="' . $field['id'] . '_lat">
					<input type="hidden" name="' . $field['id'] . '[lng]" value="' . $saved_val['lng'] . '" class="' . $field['id'] . '_lng">
				  </div>';
			$this->inAfterField( $field );
		}
		
		/**
		 * Prints custom control - border
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Border left",
		 * 		"id" 		=> "border_left",
		 * 		"type" 		=> "border",
		 * 		"s_desc"	=> "This is description",
		 * )
		 * ------------------------------------------------------------------------------------------
		 */
		public function inBorder( $field, $saved_val ) {
			$xhtml = '';
			$xhtml 	.= '<div class="input-prepend">
							<input type="text" id="' . $field['id'] . '" name="' . $field['id'] . '" class="input-number" min="' . $field['min'] . '" max="' . $field['max'] . '" value="' . (int)$saved_val . '">
						</div>';
			
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
	
		/**
		 * Prints date picker
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Border left",
		 * 		"id" 		=> "border_left",
		 * 		"type" 		=> "datepicker",
		 * 		"s_desc"	=> "This is description",
		 * )
		 * ------------------------------------------------------------------------------------------
		 */
		public function inDatepicker( $field, $saved_val ) {
			$xhtml 	= '';
			$xhtml 	.= '<div>
							<input type="text" id="' . $field['id'] . '" name="' . $field['id'] . '" class="input-datepicker" value="' . $saved_val . '">
						</div>';
			
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		
		/**
		 * Prints import
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Import",
		 * 		"id" 		=> "import_options",
		 * 		"type" 		=> "import",
		 * 		"s_desc"	=> "This is description"
		 * )
		 * ------------------------------------------------------------------------------------------
		 */
		public function inImport( $field, $saved_val ) {
			$xhtml = '';
	
			$xhtml 	.= '<div class="import-export">';
			$xhtml 	.= ' 	<p> ' . esc_html__( 'Input your theme configuration here. The configuration settings will restore your sites options from a backup, overwrite your current configuration and you can not restore the current configuration afterwards.', 'onelove' ) .'</p>';
			$xhtml 	.= '	<div>';
			$xhtml 	.= '		<input type="file" name="fileimport" />';
			$xhtml 	.= '	</div>';
			$xhtml 	.= '	<div class="import-export">
								<input type="submit" name="uploadimport" id="uploadimport" class="catanis-btn btn-primary" value="' . esc_html__('Import Options', 'onelove') . '" />
							</div>'; 
			$xhtml 	.= '</div>';
			
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		
		/**
		 * Prints export
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Export",
		 * 		"id" 		=> "export_options",
		 * 		"type" 		=> "export",
		 * 		"s_desc"	=> "This is description"
		 * )
		 * ------------------------------------------------------------------------------------------
		 */
		public function inExport( $field, $saved_val ) {
			$xhtml = '';
			$savedOptions = $this->objData->get_saved_options();
	
			$xhtml .= '<div class="import-export">';
			$xhtml 	.= '	<p>' . esc_html__( 'Click the button to generate and download a config file which contains the theme current option settings. Keep this safe as you can use it as a backup should anything go wrong. You can use the config file to import the theme settings on another sever. Or you can use it to restore your settings on this site (or any other site).', 'onelove' ) . ' </p>';
			$xhtml 	.= '	<div>';
			$xhtml 	.= '		<textarea id="export_data" readonly>' . serialize($savedOptions) . '</textarea>';
			$xhtml 	.= '	</div>';
			$xhtml 	.= '	<div class="import-export">
								<a href="' . add_query_arg( array( 'action' => 'catanis_export_options', 'secret' => md5( AUTH_KEY.SECURE_AUTH_KEY ) ), site_url() ).'" id="' . $field['id'] . '" class="catanis-btn btn-primary">' . esc_html__( 'Export to file', 'onelove' ) . '</a>
							</div>';
			$xhtml .= '</div>';
			
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		/**
		 * Prints an radio field
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Show service",
		 * 		"id" 		=> "service_show",
		 * 		"type" 		=> "radio",
		 * 		"s_desc"	=> "This is description",
		 * 		"separator"	=> "",
		 * 		"options" 	=> array("icon"=>"Icon", "image"=>"Image")
		 * )
		 * ------------------------------------------------------------------------------------------
		 */
		public function inRadio( $field, $saved_val ) {
		
			$xhtml 	= '';
			
			if ( ! isset($field['separator'] ) ) {
				$field['separator'] = ' ';
			}
			if ( sizeof( $field['options'] ) > 0 ) {
				foreach( $field['options'] as $key => $name ) {
					$checked = ( $saved_val == $key || $field['checked'] == $key) ? 'checked="checked"' : '';
					$xhtml 	.= '<span class="option-radio">
									<input type="radio" name="' . $field['id'] . '" value="' . $key . '" ' . $checked . ' class="radio_' . $field['id'] . '"/>' . $name . '
								</span>' . $field['separator'];
				}
			}
		
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		/**
		 * Prints an image radio field - Choose only one
		 * 
		 * @param 	$field: 	the field infomation (array)
		 * @param 	$saved_val: default value
		 * @return 	Html
		 *
		 * EXAMPLE USAGE CONTROL:
		 * ------------------------------------------------------------------------------------------
		 * array(
		 * 		"name" 		=> "Layout Type",
		 * 		"id" 		=> "layout_type",
		 * 		"type" 		=> "imageradio",
		 * 		"s_desc"	=> "This is description",
		 * 		"options" 	=> array(array("name"=>"Option one", "id"=>1, "img"=>"1col.png"), array("name"=>"Option two", "id"=>2, "img"=>"2cl.png"))
		 * )
		 * ------------------------------------------------------------------------------------------
		 */
		public function inImageRadio( $field, $saved_val ) {
			
			$xhtml 	= '';
			
			if ( ! isset( $field['separator'] ) ) {
				$field['separator'] = ' ';
			}
			if ( sizeof( $field['options'] ) > 0 ) {
				foreach ( $field['options'] as $sub_option ) {
					$checked = ( $saved_val == $sub_option['id'] ) ? 'checked="checked"' : '';
					$xhtml 	.= '<div class="option-image-radio">
									<img src="' . $sub_option['img'] . '" title="' . $sub_option['title'] . '"/>
									<input type="radio" name="' . $field['id'] . '" value="' . $sub_option['id'] . '" ' . $checked . '/>
								</div>';
				}
			}
		
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		public function inImageRadio_v2( $field, $saved_val ) {
				
			$xhtml 	= '';
				
			if ( ! isset( $field['separator'] ) ) {
				$field['separator'] = ' ';
			}
			if ( sizeof( $field['options'] ) > 0 ) {
				foreach ( $field['options'] as $sub_option ) {
					$checked = ( $saved_val == $sub_option['id'] ) ? 'checked="checked"' : '';
					$clsChecked = ( $saved_val == $sub_option['id'] ) ? 'ca-radio-img-img radio-selected' : 'ca-radio-img-img';
					
					$idHeader = $field['id'] .'-' . $sub_option['id'];
					$xhtml 	.= '<div class="option-image-radio">
									<input type="radio" id="' . $idHeader . '" class="checkbox ca-radio-img-radio" value="'.$sub_option['id'].'" name="' . $field['id'] . '" ' . $checked . '>
									<img src="' . $sub_option['img'] . '" alt="' . $sub_option['title'] . '" class="' . $clsChecked . '" onclick="document.getElementById(\'' . $idHeader . '\').checked = true;">
								</div>';
				}
				
			}
		
			$this->inBeforeField( $field );
			echo trim($xhtml);
			$this->inAfterField( $field );
		}
		
		
	}
}
?>