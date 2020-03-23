<?php
/**
 * Charity Is Hope Framework: theme variables storage
 *
 * @package	charity_is_hope
 * @since	charity_is_hope 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('charity_is_hope_storage_get')) {
	function charity_is_hope_storage_get($var_name, $default='') {
		global $CHARITY_IS_HOPE_STORAGE;
		return isset($CHARITY_IS_HOPE_STORAGE[$var_name]) ? $CHARITY_IS_HOPE_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('charity_is_hope_storage_set')) {
	function charity_is_hope_storage_set($var_name, $value) {
		global $CHARITY_IS_HOPE_STORAGE;
		$CHARITY_IS_HOPE_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('charity_is_hope_storage_empty')) {
	function charity_is_hope_storage_empty($var_name, $key='', $key2='') {
		global $CHARITY_IS_HOPE_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($CHARITY_IS_HOPE_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($CHARITY_IS_HOPE_STORAGE[$var_name][$key]);
		else
			return empty($CHARITY_IS_HOPE_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('charity_is_hope_storage_isset')) {
	function charity_is_hope_storage_isset($var_name, $key='', $key2='') {
		global $CHARITY_IS_HOPE_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($CHARITY_IS_HOPE_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($CHARITY_IS_HOPE_STORAGE[$var_name][$key]);
		else
			return isset($CHARITY_IS_HOPE_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('charity_is_hope_storage_inc')) {
	function charity_is_hope_storage_inc($var_name, $value=1) {
		global $CHARITY_IS_HOPE_STORAGE;
		if (empty($CHARITY_IS_HOPE_STORAGE[$var_name])) $CHARITY_IS_HOPE_STORAGE[$var_name] = 0;
		$CHARITY_IS_HOPE_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('charity_is_hope_storage_concat')) {
	function charity_is_hope_storage_concat($var_name, $value) {
		global $CHARITY_IS_HOPE_STORAGE;
		if (empty($CHARITY_IS_HOPE_STORAGE[$var_name])) $CHARITY_IS_HOPE_STORAGE[$var_name] = '';
		$CHARITY_IS_HOPE_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('charity_is_hope_storage_get_array')) {
	function charity_is_hope_storage_get_array($var_name, $key, $key2='', $default='') {
		global $CHARITY_IS_HOPE_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($CHARITY_IS_HOPE_STORAGE[$var_name][$key]) ? $CHARITY_IS_HOPE_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($CHARITY_IS_HOPE_STORAGE[$var_name][$key][$key2]) ? $CHARITY_IS_HOPE_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('charity_is_hope_storage_set_array')) {
	function charity_is_hope_storage_set_array($var_name, $key, $value) {
		global $CHARITY_IS_HOPE_STORAGE;
		if (!isset($CHARITY_IS_HOPE_STORAGE[$var_name])) $CHARITY_IS_HOPE_STORAGE[$var_name] = array();
		if ($key==='')
			$CHARITY_IS_HOPE_STORAGE[$var_name][] = $value;
		else
			$CHARITY_IS_HOPE_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('charity_is_hope_storage_set_array2')) {
	function charity_is_hope_storage_set_array2($var_name, $key, $key2, $value) {
		global $CHARITY_IS_HOPE_STORAGE;
		if (!isset($CHARITY_IS_HOPE_STORAGE[$var_name])) $CHARITY_IS_HOPE_STORAGE[$var_name] = array();
		if (!isset($CHARITY_IS_HOPE_STORAGE[$var_name][$key])) $CHARITY_IS_HOPE_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$CHARITY_IS_HOPE_STORAGE[$var_name][$key][] = $value;
		else
			$CHARITY_IS_HOPE_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Add array element after the key
if (!function_exists('charity_is_hope_storage_set_array_after')) {
	function charity_is_hope_storage_set_array_after($var_name, $after, $key, $value='') {
		global $CHARITY_IS_HOPE_STORAGE;
		if (!isset($CHARITY_IS_HOPE_STORAGE[$var_name])) $CHARITY_IS_HOPE_STORAGE[$var_name] = array();
		if (is_array($key))
			charity_is_hope_array_insert_after($CHARITY_IS_HOPE_STORAGE[$var_name], $after, $key);
		else
			charity_is_hope_array_insert_after($CHARITY_IS_HOPE_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('charity_is_hope_storage_set_array_before')) {
	function charity_is_hope_storage_set_array_before($var_name, $before, $key, $value='') {
		global $CHARITY_IS_HOPE_STORAGE;
		if (!isset($CHARITY_IS_HOPE_STORAGE[$var_name])) $CHARITY_IS_HOPE_STORAGE[$var_name] = array();
		if (is_array($key))
			charity_is_hope_array_insert_before($CHARITY_IS_HOPE_STORAGE[$var_name], $before, $key);
		else
			charity_is_hope_array_insert_before($CHARITY_IS_HOPE_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('charity_is_hope_storage_push_array')) {
	function charity_is_hope_storage_push_array($var_name, $key, $value) {
		global $CHARITY_IS_HOPE_STORAGE;
		if (!isset($CHARITY_IS_HOPE_STORAGE[$var_name])) $CHARITY_IS_HOPE_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($CHARITY_IS_HOPE_STORAGE[$var_name], $value);
		else {
			if (!isset($CHARITY_IS_HOPE_STORAGE[$var_name][$key])) $CHARITY_IS_HOPE_STORAGE[$var_name][$key] = array();
			array_push($CHARITY_IS_HOPE_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('charity_is_hope_storage_pop_array')) {
	function charity_is_hope_storage_pop_array($var_name, $key='', $defa='') {
		global $CHARITY_IS_HOPE_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($CHARITY_IS_HOPE_STORAGE[$var_name]) && is_array($CHARITY_IS_HOPE_STORAGE[$var_name]) && count($CHARITY_IS_HOPE_STORAGE[$var_name]) > 0) 
				$rez = array_pop($CHARITY_IS_HOPE_STORAGE[$var_name]);
		} else {
			if (isset($CHARITY_IS_HOPE_STORAGE[$var_name][$key]) && is_array($CHARITY_IS_HOPE_STORAGE[$var_name][$key]) && count($CHARITY_IS_HOPE_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($CHARITY_IS_HOPE_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('charity_is_hope_storage_inc_array')) {
	function charity_is_hope_storage_inc_array($var_name, $key, $value=1) {
		global $CHARITY_IS_HOPE_STORAGE;
		if (!isset($CHARITY_IS_HOPE_STORAGE[$var_name])) $CHARITY_IS_HOPE_STORAGE[$var_name] = array();
		if (empty($CHARITY_IS_HOPE_STORAGE[$var_name][$key])) $CHARITY_IS_HOPE_STORAGE[$var_name][$key] = 0;
		$CHARITY_IS_HOPE_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('charity_is_hope_storage_concat_array')) {
	function charity_is_hope_storage_concat_array($var_name, $key, $value) {
		global $CHARITY_IS_HOPE_STORAGE;
		if (!isset($CHARITY_IS_HOPE_STORAGE[$var_name])) $CHARITY_IS_HOPE_STORAGE[$var_name] = array();
		if (empty($CHARITY_IS_HOPE_STORAGE[$var_name][$key])) $CHARITY_IS_HOPE_STORAGE[$var_name][$key] = '';
		$CHARITY_IS_HOPE_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('charity_is_hope_storage_call_obj_method')) {
	function charity_is_hope_storage_call_obj_method($var_name, $method, $param=null) {
		global $CHARITY_IS_HOPE_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($CHARITY_IS_HOPE_STORAGE[$var_name]) ? $CHARITY_IS_HOPE_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($CHARITY_IS_HOPE_STORAGE[$var_name]) ? $CHARITY_IS_HOPE_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('charity_is_hope_storage_get_obj_property')) {
	function charity_is_hope_storage_get_obj_property($var_name, $prop, $default='') {
		global $CHARITY_IS_HOPE_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($CHARITY_IS_HOPE_STORAGE[$var_name]->$prop) ? $CHARITY_IS_HOPE_STORAGE[$var_name]->$prop : $default;
	}
}
?>