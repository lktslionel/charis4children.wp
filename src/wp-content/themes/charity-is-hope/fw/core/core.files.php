<?php
/**
 * Charity Is Hope Framework: file system manipulations, styles and scripts usage, etc.
 *
 * @package	charity_is_hope
 * @since	charity_is_hope 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Return image url by attachment ID
if (!function_exists('charity_is_hope_get_attachment_url')) {
	function charity_is_hope_get_attachment_url($image_id, $size='full') {
		if ($image_id > 0) {
			$attach = wp_get_attachment_image_src($image_id, $size);
			$image_id = isset($attach[0]) && $attach[0]!='' ? $attach[0] : '';
		} else
			$image_id = charity_is_hope_add_thumb_size($image_id, $size);
		return $image_id;
	}
}


// Add thumb sizes to image name
if (!function_exists('charity_is_hope_add_thumb_size')) {
	function charity_is_hope_add_thumb_size($url, $thumb_size, $check_exists=true) {

		if (empty($url)) return '';

		$pi = pathinfo($url);
		$pi['dirname'] = charity_is_hope_remove_protocol($pi['dirname']);

		// Remove image sizes from filename
		$parts = explode('-', $pi['filename']);
		$suff = explode('x', $parts[count($parts)-1]);
		if (count($suff)==2 && (int) $suff[0] > 0 && (int) $suff[1] > 0) {
			array_pop($parts);
		}
		$url = $pi['dirname'] . '/' . join('-', $parts) . '.' . $pi['extension'];

		// Add new image sizes
		global $_wp_additional_image_sizes;
		if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) && in_array( $thumb_size, array_keys( $_wp_additional_image_sizes ) ) )
			$parts[] = intval( $_wp_additional_image_sizes[$thumb_size]['width'] ) . 'x' . intval( $_wp_additional_image_sizes[$thumb_size]['height'] );
		$pi['filename'] = join('-', $parts);
		$new_url = $pi['dirname'] . '/' . $pi['filename'] . '.' . $pi['extension'];

		// Check exists
		if ($check_exists) {
			$uploads_info = wp_upload_dir();
			$uploads_url = charity_is_hope_remove_protocol($uploads_info['baseurl']);
			$uploads_dir = $uploads_info['basedir'];
			if (strpos($new_url, $uploads_url)!==false) {
				if (!file_exists(str_replace($uploads_url, $uploads_dir, $new_url)))
					$new_url = $url;
			} else {
				$new_url = $url;
			}
		}
		return $new_url;
	}
}

// Return image size name with @retina modifier (if need)
if (!function_exists('charity_is_hope_get_thumb_size')) {
	function charity_is_hope_get_thumb_size($ts) {
		return apply_filters('charity_is_hope_filter_get_thumb_size', ($ts=='post-thumbnail' || strpos($ts, 'charity_is_hope-thumb-')===0 ? '' : 'charity_is_hope-thumb-') . $ts);
	}
}

// Return url without protocol
if (!function_exists('charity_is_hope_remove_protocol')) {
	function charity_is_hope_remove_protocol($url) {
		$url = preg_replace('/http[s]?:/', '', $url);
		return $url;
	}
}


// Return file name from full name/path
if (!function_exists('charity_is_hope_get_file_name')) {
	function charity_is_hope_get_file_name($file, $without_ext=true) {
		$parts = pathinfo($file);
		return !empty($parts['filename']) && $without_ext ? $parts['filename'] : $parts['basename'];
	}
}


/* File names manipulations
------------------------------------------------------------------------------------- */

// Return path to directory with uploaded images
if (!function_exists('charity_is_hope_get_uploads_dir_from_url')) {	
	function charity_is_hope_get_uploads_dir_from_url($url) {
		$upload_info = wp_upload_dir();
		$upload_dir = $upload_info['basedir'];
		$upload_url = $upload_info['baseurl'];
		
		$http_prefix = "http://";
		$https_prefix = "https://";
		
		if (!strncmp($url, $https_prefix, charity_is_hope_strlen($https_prefix)))			//if url begins with https:// make $upload_url begin with https:// as well
			$upload_url = str_replace($http_prefix, $https_prefix, $upload_url);
		else if (!strncmp($url, $http_prefix, charity_is_hope_strlen($http_prefix)))		//if url begins with http:// make $upload_url begin with http:// as well
			$upload_url = str_replace($https_prefix, $http_prefix, $upload_url);		
	
		// Check if $img_url is local.
		if ( false === charity_is_hope_strpos( $url, $upload_url ) ) return false;
	
		// Define path of image.
		$rel_path = str_replace( $upload_url, '', $url );
		$img_path = ($upload_dir) . ($rel_path);
		
		return $img_path;
	}
}

// Replace uploads url to current site uploads url
if (!function_exists('charity_is_hope_replace_uploads_url')) {	
	function charity_is_hope_replace_uploads_url($str, $uploads_folder='uploads') {
		static $uploads_url = '', $uploads_len = 0;
		if (is_array($str) && count($str) > 0) {
			foreach ($str as $k=>$v) {
				$str[$k] = charity_is_hope_replace_uploads_url($v, $uploads_folder);
			}
		} else if (is_string($str)) {
			if (empty($uploads_url)) {
				$uploads_info = wp_upload_dir();
				$uploads_url = $uploads_info['baseurl'];
				$uploads_len = charity_is_hope_strlen($uploads_url);
			}
			$break = '\'" ';
			$pos = 0;
			while (($pos = charity_is_hope_strpos($str, "/{$uploads_folder}/", $pos))!==false) {
				$pos0 = $pos;
				$chg = true;
				while ($pos0) {
					if (charity_is_hope_strpos($break, charity_is_hope_substr($str, $pos0, 1))!==false) {
						$chg = false;
						break;
					}
					if (charity_is_hope_substr($str, $pos0, 5)=='http:' || charity_is_hope_substr($str, $pos0, 6)=='https:')
						break;
					$pos0--;
				}
				if ($chg) {
					$str = ($pos0 > 0 ? charity_is_hope_substr($str, 0, $pos0) : '') . ($uploads_url) . charity_is_hope_substr($str, $pos+charity_is_hope_strlen($uploads_folder)+1);
					$pos = $pos0 + $uploads_len;
				} else 
					$pos++;
			}
		}
		return $str;
	}
}

// Replace site url to current site url
if (!function_exists('charity_is_hope_replace_site_url')) {	
	function charity_is_hope_replace_site_url($str, $old_url) {
		static $site_url = '', $site_len = 0;
		if (is_array($str) && count($str) > 0) {
			foreach ($str as $k=>$v) {
				$str[$k] = charity_is_hope_replace_site_url($v, $old_url);
			}
		} else if (is_string($str)) {
			if (empty($site_url)) {
				$site_url = get_site_url();
				$site_len = charity_is_hope_strlen($site_url);
				if (charity_is_hope_substr($site_url, -1)=='/') {
					$site_len--;
					$site_url = charity_is_hope_substr($site_url, 0, $site_len);
				}
			}
			if (charity_is_hope_substr($old_url, -1)=='/') $old_url = charity_is_hope_substr($old_url, 0, charity_is_hope_strlen($old_url)-1);
			$break = '\'" ';
			$pos = 0;
			while (($pos = charity_is_hope_strpos($str, $old_url, $pos))!==false) {
				$str = charity_is_hope_unserialize($str);
				if (is_array($str) && count($str) > 0) {
					foreach ($str as $k=>$v) {
						$str[$k] = charity_is_hope_replace_site_url($v, $old_url);
					}
					$str = serialize($str);
					break;
				} else {
					$pos0 = $pos;
					$chg = true;
					while ($pos0 >= 0) {
						if (charity_is_hope_strpos($break, charity_is_hope_substr($str, $pos0, 1))!==false) {
							$chg = false;
							break;
						}
						if (charity_is_hope_substr($str, $pos0, 5)=='http:' || charity_is_hope_substr($str, $pos0, 6)=='https:')
							break;
						$pos0--;
					}
					if ($chg && $pos0>=0) {
						$str = ($pos0 > 0 ? charity_is_hope_substr($str, 0, $pos0) : '') . ($site_url) . charity_is_hope_substr($str, $pos+charity_is_hope_strlen($old_url));
						$pos = $pos0 + $site_len;
					} else 
						$pos++;
				}
			}
		}
		return $str;
	}
}

// Get domain part from URL
if (!function_exists('charity_is_hope_get_domain_from_url')) {
	function charity_is_hope_get_domain_from_url($url) {
		if (($pos=strpos($url, '://'))!==false) $url = substr($url, $pos+3);
		if (($pos=strpos($url, '/'))!==false) $url = substr($url, 0, $pos);
		return $url;
	}
}

// Return file extension from full name/path
if (!function_exists('charity_is_hope_get_file_ext')) {
	function charity_is_hope_get_file_ext($file) {
		$parts = pathinfo($file);
		return $parts['extension'];
	}
}



/* File system utils
------------------------------------------------------------------------------------- */

// Init WP Filesystem
if (!function_exists('charity_is_hope_init_filesystem')) {
	add_action( 'after_setup_theme', 'charity_is_hope_init_filesystem', 0);
	function charity_is_hope_init_filesystem() {
		if( !function_exists('WP_Filesystem') ) {
			require_once( ABSPATH .'/wp-admin/includes/file.php' );
		}
		if (is_admin()) {
			$url = admin_url();
			$creds = false;
			// First attempt to get credentials.
			if ( function_exists('request_filesystem_credentials') && false === ( $creds = request_filesystem_credentials( $url, '', false, false, array() ) ) ) {
				// If we comes here - we don't have credentials
				// so the request for them is displaying no need for further processing
				return false;
			}

			// Now we got some credentials - try to use them.
			if ( !WP_Filesystem( $creds ) ) {
				// Incorrect connection data - ask for credentials again, now with error message.
				if ( function_exists('request_filesystem_credentials') ) request_filesystem_credentials( $url, '', true, false );
				return false;
			}

			return true; // Filesystem object successfully initiated.
		} else {
			WP_Filesystem();
		}
		return true;
	}
}


// Put data into specified file
if (!function_exists('charity_is_hope_fpc')) {
    function charity_is_hope_fpc($file, $data, $flag=0) {
        global $wp_filesystem;
        if (!empty($file)) {
            if (isset($wp_filesystem) && is_object($wp_filesystem)) {
                $file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
// Attention! WP_Filesystem can't append the content to the file!
// That's why we have to read the contents of the file into a string,
// add new content to this string and re-write it to the file if parameter $flag == FILE_APPEND!
                return $wp_filesystem->put_contents($file, ($flag==FILE_APPEND ? $wp_filesystem->get_contents($file) : '') . $data, false);
            } else {
                if (charity_is_hope_param_is_on(charity_is_hope_get_theme_option('debug_mode')))
                    throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Put contents to the file "%s" failed', 'charity-is-hope'), $file));
            }
        }
        return false;
    }
}


// Get text from specified file
if (!function_exists('charity_is_hope_fgc')) {
    function charity_is_hope_fgc($file) {
        static $allow_url_fopen = -1;
        if ($allow_url_fopen==-1) $allow_url_fopen = (int) ini_get('allow_url_fopen');
        global $wp_filesystem;
        if (!empty($file)) {
            if (isset($wp_filesystem) && is_object($wp_filesystem)) {
                $file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
                return !$allow_url_fopen && strpos($file, '//')!==false
                    ? charity_is_hope_remote_get($file)
                    : $wp_filesystem->get_contents($file);
            } else {
                if (charity_is_hope_param_is_on(charity_is_hope_get_theme_option('debug_mode')))
                    throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get contents from the file "%s" failed', 'charity-is-hope'), $file));
            }
        }
        return '';
    }
}


// Get text from specified file via HTTP (cURL)
if (!function_exists('charity_is_hope_remote_get')) {
    function charity_is_hope_remote_get($file, $timeout=-1) {
        // Set timeout as half of the PHP execution time
        if ($timeout < 1) $timeout = round( 0.5 * max(30, ini_get('max_execution_time')));
        $response = wp_remote_get($file, array(
                'timeout'     => $timeout
            )
        );
        //return wp_remote_retrieve_response_code( $response ) == 200 ? wp_remote_retrieve_body( $response ) : '';
        return isset($response['response']['code']) && $response['response']['code']==200 ? $response['body'] : '';
    }
}

// Get array with rows from specified file
if (!function_exists('charity_is_hope_fga')) {
	function charity_is_hope_fga($file) {
		global $wp_filesystem;
		if (!empty($file)) {
			if (isset($wp_filesystem) && is_object($wp_filesystem)) {
				$file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
				return $wp_filesystem->get_contents_array($file);
			} else {
				if (charity_is_hope_param_is_on(charity_is_hope_get_theme_option('debug_mode')))
					throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get rows from the file "%s" failed', 'charity-is-hope'), $file));
			}
		}
		return array();
	}
}


/* Check if file/folder present in the child theme and return path (url) to it.
   Else - path (url) to file in the main theme dir
------------------------------------------------------------------------------------- */

// Detect file location with next algorithm:
// 1) check in the child theme folder
// 2) check in the framework folder in the child theme folder
// 3) check in the main theme folder
// 4) check in the framework folder in the main theme folder
if (!function_exists('charity_is_hope_get_file_dir')) {
    function charity_is_hope_get_file_dir($file, $return_url=false) {

        if ($file[0] == '/') $file = charity_is_hope_substr($file, 1);

        // Use new WordPress functions (if present)
        if ( function_exists('get_theme_file_path') ) {
            $dir = get_theme_file_path($file);

            if (file_exists($dir) ) {
                $dir = ($return_url ? get_theme_file_uri($file) : $dir);
            } else {
                $file = CHARITY_IS_HOPE_FW_DIR . '/' . $file;
                $dir = get_theme_file_path($file);
                $dir = ($return_url ? get_theme_file_uri($file) : $dir);
            }

            // Otherwise (on WordPress older then 4.7.0)
        } else {
            $theme_dir = get_template_directory();
            $theme_url = get_template_directory_uri();
            $child_dir = get_stylesheet_directory();
            $child_url = get_stylesheet_directory_uri();
            $dir = '';
            if (file_exists(($child_dir) . '/' . ($file)))
                $dir = ($return_url ? $child_url : $child_dir) . '/' . ($file);
            else if (file_exists(($child_dir) . '/' . (CHARITY_IS_HOPE_FW_DIR) . '/' . ($file)))
                $dir = ($return_url ? $child_url : $child_dir) . '/' . (CHARITY_IS_HOPE_FW_DIR) . '/' . ($file);
            else if (file_exists(($theme_dir) . '/' . ($file)))
                $dir = ($return_url ? $theme_url : $theme_dir) . '/' . ($file);
            else if (file_exists(($theme_dir) . '/' . (CHARITY_IS_HOPE_FW_DIR) . '/' . ($file)))
                $dir = ($return_url ? $theme_url : $theme_dir) . '/' . (CHARITY_IS_HOPE_FW_DIR) . '/' . ($file);
        }

        return $dir;
    }
}

// Detect file location with next algorithm:
// 1) check in the main theme folder
// 2) check in the framework folder in the main theme folder
// and return file slug (relative path to the file without extension)
// to use it in the get_template_part()
if (!function_exists('charity_is_hope_get_file_slug')) {
	function charity_is_hope_get_file_slug($file) {
		if ($file[0]=='/') $file = charity_is_hope_substr($file, 1);
		$theme_dir = get_template_directory();
		$dir = '';
		if (file_exists(($theme_dir).'/'.($file)))
			$dir = $file;
		else if (file_exists(($theme_dir).'/'.CHARITY_IS_HOPE_FW_DIR.'/'.($file)))
			$dir = CHARITY_IS_HOPE_FW_DIR.'/'.($file);
		if (charity_is_hope_substr($dir, -4)=='.php') $dir = charity_is_hope_substr($dir, 0, charity_is_hope_strlen($dir)-4);
		return $dir;
	}
}

if (!function_exists('charity_is_hope_get_file_url')) {	
	function charity_is_hope_get_file_url($file) {
		return charity_is_hope_get_file_dir($file, true);
	}
}

// Detect folder location with same algorithm as file (see above)
if (!function_exists('charity_is_hope_get_folder_dir')) {	
	function charity_is_hope_get_folder_dir($folder, $return_url=false) {
		if ($folder[0]=='/') $folder = charity_is_hope_substr($folder, 1);
		$theme_dir = get_template_directory();
		$theme_url = get_template_directory_uri();
		$child_dir = get_stylesheet_directory();
		$child_url = get_stylesheet_directory_uri();
		$dir = '';
		if (is_dir(($child_dir).'/'.($folder)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.($folder);
		else if (is_dir(($child_dir).'/'.(CHARITY_IS_HOPE_FW_DIR).'/'.($folder)))
			$dir = ($return_url ? $child_url : $child_dir).'/'.(CHARITY_IS_HOPE_FW_DIR).'/'.($folder);
		else if (file_exists(($theme_dir).'/'.($folder)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.($folder);
		else if (file_exists(($theme_dir).'/'.(CHARITY_IS_HOPE_FW_DIR).'/'.($folder)))
			$dir = ($return_url ? $theme_url : $theme_dir).'/'.(CHARITY_IS_HOPE_FW_DIR).'/'.($folder);
		return $dir;
	}
}

if (!function_exists('charity_is_hope_get_folder_url')) {	
	function charity_is_hope_get_folder_url($folder) {
		return charity_is_hope_get_folder_dir($folder, true);
	}
}

// Return path to social icon (if exists)
if (!function_exists('charity_is_hope_get_socials_dir')) {	
	function charity_is_hope_get_socials_dir($soc, $return_url=false) {
		return charity_is_hope_get_file_dir('images/socials/' . sanitize_file_name($soc) . (charity_is_hope_strpos($soc, '.')===false ? '.png' : ''), $return_url, true);
	}
}

if (!function_exists('charity_is_hope_get_socials_url')) {	
	function charity_is_hope_get_socials_url($soc) {
		return charity_is_hope_get_socials_dir($soc, true);
	}
}

// Detect theme version of the template (if exists), else return it from fw templates directory
if (!function_exists('charity_is_hope_get_template_dir')) {	
	function charity_is_hope_get_template_dir($tpl) {
		return charity_is_hope_get_file_dir('templates/' . sanitize_file_name($tpl) . (charity_is_hope_strpos($tpl, '.php')===false ? '.php' : ''));
	}
}
?>