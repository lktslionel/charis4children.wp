<?php
/**
 * Charity Is Hope Framework: strings manipulations
 *
 * @package	charity_is_hope
 * @since	charity_is_hope 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check multibyte functions
if ( ! defined( 'CHARITY_IS_HOPE_MULTIBYTE' ) ) define( 'CHARITY_IS_HOPE_MULTIBYTE', function_exists('mb_strpos') ? 'UTF-8' : false );

if (!function_exists('charity_is_hope_strlen')) {
	function charity_is_hope_strlen($text) {
		return CHARITY_IS_HOPE_MULTIBYTE ? mb_strlen($text) : strlen($text);
	}
}

if (!function_exists('charity_is_hope_strpos')) {
	function charity_is_hope_strpos($text, $char, $from=0) {
		return CHARITY_IS_HOPE_MULTIBYTE ? mb_strpos($text, $char, $from) : strpos($text, $char, $from);
	}
}

if (!function_exists('charity_is_hope_strrpos')) {
	function charity_is_hope_strrpos($text, $char, $from=0) {
		return CHARITY_IS_HOPE_MULTIBYTE ? mb_strrpos($text, $char, $from) : strrpos($text, $char, $from);
	}
}

if (!function_exists('charity_is_hope_substr')) {
	function charity_is_hope_substr($text, $from, $len=-999999) {
		if ($len==-999999) { 
			if ($from < 0)
				$len = -$from; 
			else
				$len = charity_is_hope_strlen($text)-$from;
		}
		return CHARITY_IS_HOPE_MULTIBYTE ? mb_substr($text, $from, $len) : substr($text, $from, $len);
	}
}

if (!function_exists('charity_is_hope_strtolower')) {
	function charity_is_hope_strtolower($text) {
		return CHARITY_IS_HOPE_MULTIBYTE ? mb_strtolower($text) : strtolower($text);
	}
}

if (!function_exists('charity_is_hope_strtoupper')) {
	function charity_is_hope_strtoupper($text) {
		return CHARITY_IS_HOPE_MULTIBYTE ? mb_strtoupper($text) : strtoupper($text);
	}
}

if (!function_exists('charity_is_hope_strtoproper')) {
	function charity_is_hope_strtoproper($text) { 
		$rez = ''; $last = ' ';
		for ($i=0; $i<charity_is_hope_strlen($text); $i++) {
			$ch = charity_is_hope_substr($text, $i, 1);
			$rez .= charity_is_hope_strpos(' .,:;?!()[]{}+=', $last)!==false ? charity_is_hope_strtoupper($ch) : charity_is_hope_strtolower($ch);
			$last = $ch;
		}
		return $rez;
	}
}

if (!function_exists('charity_is_hope_strrepeat')) {
	function charity_is_hope_strrepeat($str, $n) {
		$rez = '';
		for ($i=0; $i<$n; $i++)
			$rez .= $str;
		return $rez;
	}
}

if (!function_exists('charity_is_hope_strshort')) {
	function charity_is_hope_strshort($str, $maxlength, $add='...') {
		if ($maxlength < 0) 
			return $str;
		if ($maxlength == 0) 
			return '';
		if ($maxlength >= charity_is_hope_strlen($str)) 
			return strip_tags($str);
		$str = charity_is_hope_substr(strip_tags($str), 0, $maxlength - charity_is_hope_strlen($add));
		$ch = charity_is_hope_substr($str, $maxlength - charity_is_hope_strlen($add), 1);
		if ($ch != ' ') {
			for ($i = charity_is_hope_strlen($str) - 1; $i > 0; $i--)
				if (charity_is_hope_substr($str, $i, 1) == ' ') break;
			$str = trim(charity_is_hope_substr($str, 0, $i));
		}
		if (!empty($str) && charity_is_hope_strpos(',.:;-', charity_is_hope_substr($str, -1))!==false) $str = charity_is_hope_substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Clear string from spaces, line breaks and tags (only around text)
if (!function_exists('charity_is_hope_strclear')) {
	function charity_is_hope_strclear($text, $tags=array()) {
		if (empty($text)) return $text;
		if (!is_array($tags)) {
			if ($tags != '')
				$tags = explode($tags, ',');
			else
				$tags = array();
		}
		$text = trim(chop($text));
		if (is_array($tags) && count($tags) > 0) {
			foreach ($tags as $tag) {
				$open  = '<'.esc_attr($tag);
				$close = '</'.esc_attr($tag).'>';
				if (charity_is_hope_substr($text, 0, charity_is_hope_strlen($open))==$open) {
					$pos = charity_is_hope_strpos($text, '>');
					if ($pos!==false) $text = charity_is_hope_substr($text, $pos+1);
				}
				if (charity_is_hope_substr($text, -charity_is_hope_strlen($close))==$close) $text = charity_is_hope_substr($text, 0, charity_is_hope_strlen($text) - charity_is_hope_strlen($close));
				$text = trim(chop($text));
			}
		}
		return $text;
	}
}

// Return slug for the any title string
if (!function_exists('charity_is_hope_get_slug')) {
	function charity_is_hope_get_slug($title) {
		return charity_is_hope_strtolower(str_replace(array('\\','/','-',' ','.'), '_', $title));
	}
}

// Replace macros in the string
if (!function_exists('charity_is_hope_strmacros')) {
	function charity_is_hope_strmacros($str) {
		return str_replace(array("{{", "}}", "((", "))", "||"), array("<i>", "</i>", "<b>", "</b>", "<br>"), $str);
	}
}

// Unserialize string (try replace \n with \r\n)
if (!function_exists('charity_is_hope_unserialize')) {
	function charity_is_hope_unserialize($str) {
		if ( is_serialized($str) ) {
			try {
				$data = unserialize($str);
			} catch (Exception $e) {
				dcl($e->getMessage());
				$data = false;
			}
			if ($data===false) {
				try {
					$data = unserialize(str_replace("\n", "\r\n", $str));
				} catch (Exception $e) {
					dcl($e->getMessage());
					$data = false;
				}
			}
			return $data;
		} else
			return $str;
	}
}
?>