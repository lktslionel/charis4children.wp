<?php
function catanis_import_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'CatanisThemes - One Click Demo Import' , 'catanis-core' );
	$default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'catanis-core' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'catanis-one-click-demo-import';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'catanis_import_page_setup' );
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

function ocdi_plugin_intro_text( $default_text ) {
	$img = CATANIS_CORE_URL . '/images/import-home-main.png';
	$default_text .= '<div class="ocdi__intro-text cata-import-intro">
			<h3>Welcome to Catanis Demo Importer!</h3>
			<p>Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. It will allow you to quickly edit everything instead of creating content from scratch. When you import the data, the following things might happen: </p>
			<ul>
				<li>No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.</li>
				<li>Posts, pages, images, widgets, menus and other theme settings will get imported.</li>
				<li>Please click on the Import button only once and wait, it can take a couple of minutes.</li>
			</ul>

			<p>Server Requirements are very critical in order to seamlessly upload the theme and import the demo data. Incase you face some issues while importing the demo, please check the list of PHP configurations required in the <strong>php.ini</strong> file on your server. If you are not familiar with modifying this, you can contact to your server hosting provider who should be able to configure it.</p>
			<ul>
				<li>MAX_EXECUTION_TIME = 300</li>
				<li>MAX_INPUT_TIME = 120</li>
				<li>MEMORY_LIMIT = 128M</li>
			</ul>

			<p><strong>NOTE:</strong></p>
			<ul>
				<li> The installation process is fast or slow, it is depend on your hosting (strong or not). Do not close or refresh the page until the import is complete.</li>
				<li>The images in the actual demo will be replaced with blurred images in the sample data. This is to speed up the import process as well as licensing reasons.</li>
			</ul>
			</div>';
	
	return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'ocdi_plugin_intro_text' );

function catanis_import_demo_files() {

	$importArr = array(
		array(
			'import_file_name'           => 'Home Main',
			'import_file_url'            => trailingslashit( CATANIS_CORE_INC_URL ) . 'data/sample_data.xml',
			'import_widget_file_url'     => trailingslashit( CATANIS_CORE_INC_URL ) . 'data/home_main/import_widgets.wie',
			'import_preview_image_url'   => CATANIS_CORE_URL . '/images/import-home-main.png'
		)
	);
	
	if ( in_array( $_SERVER['REMOTE_ADDR'], array('127.0.0.1','::1') ) ) {
		$importArr = array(
			array(
				'import_file_name'           => 'Home Main',
				'local_import_file'            => trailingslashit( CATANIS_CORE_INC_PATH ) . 'data/sample_data.xml',
				'local_import_widget_file'     => trailingslashit( CATANIS_CORE_INC_PATH ) . 'data/home_main/import_widgets.wie',
				'import_preview_image_url'     => CATANIS_CORE_URL . '/images/import-home-main.png'
			)
		);
	}
	
	
	return $importArr;
}
add_filter( 'pt-ocdi/import_files', 'catanis_import_demo_files' );

function catanis_after_import_demo( $selected_import ) {
	
	/* Import Theme Options */
	if ( $selected_import['import_file_name'] == 'Home Main' ){
		$theme_options_name = 'data/home_main/theme_options.json';
		$homepage_title = 'Home Main';
	}
	
	$theme_options_path = trailingslashit( CATANIS_CORE_INC_PATH ) . $theme_options_name;
	$theme_options_url = trailingslashit( CATANIS_CORE_INC_URL) . $theme_options_name;
	
	if( !file_exists($theme_options_path) ){
		esc_html_e('Theme Options File Not Found', 'catanis-core');
		return false;
	}
	
	$option_data = unserialize( file_get_contents($theme_options_url) );
	update_option( CATANIS_OPTIONS, $option_data );
	esc_html_e('Theme Options Import Successful', 'catanis-core');
	
	/* Menu Locations */
	catanis_set_menu_locations();
	
	/* Update Front Page Display */
	catanis_front_page_display_update($homepage_title);
	
	/*WooCommerce Page*/
	update_option( 'woocommerce_myaccount_page_id', 2748 );
	update_option( 'woocommerce_cart_page_id', 2746 );
	update_option( 'woocommerce_checkout_page_id', 2747 );
	update_option( 'woocommerce_shop_page_id', 2745 );
	
	/* Import Revolution Slider */
	$rev_directory = trailingslashit( CATANIS_CORE_INC_PATH ) . 'data/revslider/';
	catanis_import_revslider_demo($rev_directory);
	esc_html_e('Theme Options Import Successful', 'catanis-core');
}
add_action( 'pt-ocdi/after_import', 'catanis_after_import_demo' );

function catanis_before_widgets_import( $selected_import ) {
	$sidebars_widgets =  get_option( 'sidebars_widgets' );
	$sidebars_widgets['wp_inactive_widgets'] = $sidebars_widgets['sidebar-primary'];
	$sidebars_widgets['sidebar-primary'] = array();
	
	update_option( 'sidebars_widgets', $sidebars_widgets );
}
add_action( 'pt-ocdi/before_widgets_import', 'catanis_before_widgets_import' );

function catanis_set_menu_locations(){
	$locations = get_theme_mod( 'nav_menu_locations' );
	$menus = wp_get_nav_menus();

	if( $menus ) {
		foreach($menus as $menu) {
			if( $menu->name == 'Catanis Primary Navigation' ) {
				$locations['catanis_main_menu'] = $menu->term_id;
			}
		}
	}
	set_theme_mod( 'nav_menu_locations', $locations );
}

function catanis_front_page_display_update($homepage_title){
	$homepage = get_page_by_title( $homepage_title );
	if( isset( $homepage ) && $homepage->ID ){
		update_option('show_on_front', 'page');
		update_option('page_on_front', $homepage->ID);
	}
	
	update_option('posts_per_page', 9);	
}
	
function catanis_import_revslider_demo($rev_directory){
	if( class_exists('UniteFunctionsRev') && class_exists('ZipArchive') ) {
		global $wpdb;
		$updateAnim = true;
		$updateStatic= true;
		$rev_files = array();
		$rev_db = new RevSliderDB();

		foreach( glob( $rev_directory . '*.zip' ) as $filename ) {
			$filename = basename($filename);
			$allow_import = false;
				
			$arr_filename = explode('_', $filename);
			$slider_new_id = absint( $arr_filename[0] );
			if( $slider_new_id > 0 ){
				$response = $rev_db->fetch( RevSliderGlobals::$table_sliders, 'id=' + $slider_new_id );
				if( empty($response) ){
					$rev_files_ids[] = $slider_new_id;
					$allow_import = true;
				}
			}
			else{
				$rev_files_ids[] = 0;
				$allow_import = true;
			}
				
			if( $allow_import ){
				$rev_files[] = $rev_directory . $filename;
			}
		}

		foreach( $rev_files as $index => $rev_file ) {

			$filepath = $rev_file;

			$zip = new ZipArchive;
			$importZip = $zip->open($filepath, ZIPARCHIVE::CREATE);

			if( $importZip === true ){

				$slider_export = $zip->getStream('slider_export.txt');
				$custom_animations = $zip->getStream('custom_animations.txt');
				$dynamic_captions = $zip->getStream('dynamic-captions.css');
				$static_captions = $zip->getStream('static-captions.css');

				$content = '';
				$animations = '';
				$dynamic = '';
				$static = '';

				while ( !feof($slider_export) ) $content .= fread($slider_export, 1024);
				if($custom_animations){ while (!feof($custom_animations)) $animations .= fread($custom_animations, 1024); }
				if($dynamic_captions){ while (!feof($dynamic_captions)) $dynamic .= fread($dynamic_captions, 1024); }
				if($static_captions){ while (!feof($static_captions)) $static .= fread($static_captions, 1024); }

				fclose($slider_export);
				if($custom_animations){ fclose($custom_animations); }
				if($dynamic_captions){ fclose($dynamic_captions); }
				if($static_captions){ fclose($static_captions); }

			}else{
				$content = @file_get_contents($filepath);
			}

			if($importZip === true){
				$db = new UniteDBRev();

				$animations = @unserialize($animations);
				if( !empty($animations) ){
					foreach($animations as $key => $animation){
						$exist = $db->fetch(GlobalsRevSlider::$table_layer_anims, "handle = '".$animation['handle']."'");
						if( !empty($exist) ){
							if( $updateAnim == 'true' ){
								$arrUpdate = array();
								$arrUpdate['params'] = stripslashes(json_encode(str_replace("'", '"', $animation['params'])));
								$db->update(GlobalsRevSlider::$table_layer_anims, $arrUpdate, array('handle' => $animation['handle']));

								$id = $exist['0']['id'];
							}else{
								$arrInsert = array();
								$arrInsert["handle"] = 'copy_'.$animation['handle'];
								$arrInsert["params"] = stripslashes(json_encode(str_replace("'", '"', $animation['params'])));

								$id = $db->insert(GlobalsRevSlider::$table_layer_anims, $arrInsert);
							}
						}else{
							$arrInsert = array();
							$arrInsert["handle"] = $animation['handle'];
							$arrInsert["params"] = stripslashes(json_encode(str_replace("'", '"', $animation['params'])));

							$id = $db->insert(GlobalsRevSlider::$table_layer_anims, $arrInsert);
						}

						$content = str_replace(array('customin-'.$animation['id'], 'customout-'.$animation['id']), array('customin-'.$id, 'customout-'.$id), $content);
					}
				}else{

				}

				if( !empty($static) ){
					if( isset( $updateStatic ) && $updateStatic == 'true' ){
						RevOperations::updateStaticCss($static);
					}else{
						$static_cur = RevOperations::getStaticCss();
						$static = $static_cur."\n".$static;
						RevOperations::updateStaticCss($static);
					}
				}
					
				$dynamicCss = UniteCssParserRev::parseCssToArray($dynamic);

				if(is_array($dynamicCss) && $dynamicCss !== false && count($dynamicCss) > 0){
					foreach($dynamicCss as $class => $styles){
						$class = trim($class);

						if((strpos($class, ':hover') === false && strpos($class, ':') !== false) ||
								strpos($class," ") !== false ||
								strpos($class,".tp-caption") === false ||
								(strpos($class,".") === false || strpos($class,"#") !== false) ||
								strpos($class,">") !== false){
							continue;
						}
							
						if(strpos($class, ':hover') !== false){
							$class = trim(str_replace(':hover', '', $class));
							$arrInsert = array();
							$arrInsert["hover"] = json_encode($styles);
							$arrInsert["settings"] = json_encode(array('hover' => 'true'));
						}else{
							$arrInsert = array();
							$arrInsert["params"] = json_encode($styles);
						}
							
						$result = $db->fetch(GlobalsRevSlider::$table_css, "handle = '".$class."'");

						if(!empty($result)){
							$db->update(GlobalsRevSlider::$table_css, $arrInsert, array('handle' => $class));
						}else{
							$arrInsert["handle"] = $class;
							$db->insert(GlobalsRevSlider::$table_css, $arrInsert);
						}
					}

				}else{

				}
			}

			$content = preg_replace_callback('!s:(\d+):"(.*?)";!', array('RevSliderSlider', 'clear_error_in_string') , $content); //clear errors in string

			$arrSlider = @unserialize($content);
			$sliderParams = $arrSlider["params"];

			if(isset($sliderParams["background_image"]))
				$sliderParams["background_image"] = UniteFunctionsWPRev::getImageUrlFromPath($sliderParams["background_image"]);

			$json_params = json_encode($sliderParams);


			$arrInsert = array();
			$arrInsert["params"] = $json_params;
			$arrInsert["title"] = UniteFunctionsRev::getVal($sliderParams, "title","Slider1");
			$arrInsert["alias"] = UniteFunctionsRev::getVal($sliderParams, "alias","slider1");
			if( $rev_files_ids[$index] != 0 ){
				$arrInsert["id"] = $rev_files_ids[$index];
				$arrFormat = array('%s', '%s', '%s', '%d');
			}
			else{
				$arrFormat = array('%s', '%s', '%s');
			}
			$sliderID = $wpdb->insert(GlobalsRevSlider::$table_sliders, $arrInsert, $arrFormat);
			$sliderID = $wpdb->insert_id;

			/* create all slides */
			$arrSlides = $arrSlider["slides"];

			$alreadyImported = array();

			foreach($arrSlides as $slide){

				$params = $slide["params"];
				$layers = $slide["layers"];

				if(isset($params["image"])){
					if(trim($params["image"]) !== ''){
						if($importZip === true){
							$image = $zip->getStream('images/'.$params["image"]);
							if(!$image){
								echo trim($params["image"]) .' not found!<br>';
							}else{
								if(!isset($alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]])){
									$importImage = UniteFunctionsWPRev::import_media('zip://'.$filepath."#".'images/'.$params["image"], $sliderParams["alias"].'/');

									if($importImage !== false){
										$alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]] = $importImage['path'];

										$params["image"] = $importImage['path'];
									}
								}else{
									$params["image"] = $alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]];
								}
							}
						}
					}
					$params["image"] = UniteFunctionsWPRev::getImageUrlFromPath($params["image"]);
				}

				foreach($layers as $key=>$layer){
					if(isset($layer["image_url"])){
						if(trim($layer["image_url"]) !== ''){
							if($importZip === true){
								$image_url = $zip->getStream('images/'.$layer["image_url"]);
								if(!$image_url){
									echo trim($layer["image_url"]) . ' not found!<br>';
								}else{ 
									if(!isset($alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]])){
										$importImage = UniteFunctionsWPRev::import_media('zip://'.$filepath."#".'images/'.$layer["image_url"], $sliderParams["alias"].'/');

										if($importImage !== false){
											$alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]] = $importImage['path'];

											$layer["image_url"] = $importImage['path'];
										}
									}else{
										$layer["image_url"] = $alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]];
									}
								}
							}
						}
						$layer["image_url"] = UniteFunctionsWPRev::getImageUrlFromPath($layer["image_url"]);
						$layers[$key] = $layer;
					}
				}

				/* create new slide */
				$arrCreate = array();
				$arrCreate["slider_id"] = $sliderID;
				$arrCreate["slide_order"] = $slide["slide_order"];
				$arrCreate["layers"] = json_encode($layers);
				$arrCreate["params"] = json_encode($params);

				$wpdb->insert(GlobalsRevSlider::$table_slides,$arrCreate);
			}
		}
	}
}


?>