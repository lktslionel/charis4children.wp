<?php
/**
 * Charity Is Hope Framework: date and time manipulations
 *
 * @package	charity_is_hope
 * @since	charity_is_hope 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Convert date from MySQL format (YYYY-mm-dd) to Date (dd.mm.YYYY)
if (!function_exists('charity_is_hope_sql_to_date')) {
	function charity_is_hope_sql_to_date($str) {
		return (trim($str)=='' || trim($str)=='0000-00-00' ? '' : trim(charity_is_hope_substr($str,8,2).'.'.charity_is_hope_substr($str,5,2).'.'.charity_is_hope_substr($str,0,4).' '.charity_is_hope_substr($str,11)));
	}
}

// Convert date from Date format (dd.mm.YYYY) to MySQL format (YYYY-mm-dd)
if (!function_exists('charity_is_hope_date_to_sql')) {
	function charity_is_hope_date_to_sql($str) {
		if (trim($str)=='') return '';
		$str = strtr(trim($str),'/\-,','....');
		if (trim($str)=='00.00.0000' || trim($str)=='00.00.00') return '';
		$pos = charity_is_hope_strpos($str,'.');
		$d=trim(charity_is_hope_substr($str,0,$pos));
		$str=charity_is_hope_substr($str,$pos+1);
		$pos = charity_is_hope_strpos($str,'.');
		$m=trim(charity_is_hope_substr($str,0,$pos));
		$y=trim(charity_is_hope_substr($str,$pos+1));
		$y=($y<50?$y+2000:($y<1900?$y+1900:$y));
		return ''.($y).'-'.(charity_is_hope_strlen($m)<2?'0':'').($m).'-'.(charity_is_hope_strlen($d)<2?'0':'').($d);
	}
}

// Return difference or date
if (!function_exists('charity_is_hope_get_date_or_difference')) {
	function charity_is_hope_get_date_or_difference($dt1, $dt2=null, $max_days=-1, $date_format='') {
		static $gmt_offset = 999;
		if ($gmt_offset==999) $gmt_offset = (int) get_option('gmt_offset');
		if ($max_days < 0) $max_days = charity_is_hope_get_theme_option('show_date_after', 30);
		if ($dt2 == null) $dt2 = date('Y-m-d H:i:s');
		$dt2n = strtotime($dt2)+$gmt_offset*3600;
		$dt1n = strtotime($dt1);
		if (is_numeric($dt1n) && is_numeric($dt2n)) {
			$diff = $dt2n - $dt1n;
			$days = floor($diff / (24*3600));
			if (abs($days) < $max_days)
				return sprintf($days >= 0 ? esc_html__('%s ago', 'charity-is-hope') : esc_html__('in %s', 'charity-is-hope'), charity_is_hope_get_date_difference($days >= 0 ? $dt1 : $dt2, $days >= 0 ? $dt2 : $dt1));
			else {
				return charity_is_hope_get_date_translations(date_i18n(empty($date_format) ? get_option('date_format') : $date_format, $dt1n));
			}
		} else
			return charity_is_hope_get_date_translations($dt1);
	}
}

// Difference between two dates
if (!function_exists('charity_is_hope_get_date_difference')) {
	function charity_is_hope_get_date_difference($dt1, $dt2=null, $short=1, $sec = false) {
		static $gmt_offset = 999;
		if ($gmt_offset==999) $gmt_offset = (int) get_option('gmt_offset');
		if ($dt2 == null) $dt2n = time()+$gmt_offset*3600;
		else $dt2n = strtotime($dt2)+$gmt_offset*3600;
		$dt1n = strtotime($dt1);
		if (is_numeric($dt1n) && is_numeric($dt2n)) {
			$diff = $dt2n - $dt1n;
			$days = floor($diff / (24*3600));
			$months = floor($days / 30);
			$diff -= $days * 24 * 3600;
			$hours = floor($diff / 3600);
			$diff -= $hours * 3600;
			$min = floor($diff / 60);
			$diff -= $min * 60;
			$rez = '';
			if ($months > 0 && $short == 2)
				$rez .= ($rez!='' ? ' ' : '') . sprintf($months > 1 ? esc_html__('%s months', 'charity-is-hope') : esc_html__('%s month', 'charity-is-hope'), $months);
			if ($days > 0 && ($short < 2 || $rez==''))
				$rez .= ($rez!='' ? ' ' : '') . sprintf($days > 1 ? esc_html__('%s days', 'charity-is-hope') : esc_html__('%s day', 'charity-is-hope'), $days);
			if ((!$short || $rez=='') && $hours > 0)
				$rez .= ($rez!='' ? ' ' : '') . sprintf($hours > 1 ? esc_html__('%s hours', 'charity-is-hope') : esc_html__('%s hour', 'charity-is-hope'), $hours);
			if ((!$short || $rez=='') && $min > 0)
				$rez .= ($rez!='' ? ' ' : '') . sprintf($min > 1 ? esc_html__('%s minutes', 'charity-is-hope') : esc_html__('%s minute', 'charity-is-hope'), $min);
			if ($sec || $rez=='')
				$rez .=  $rez!='' || $sec ? (' ' . sprintf($diff > 1 ? esc_html__('%s seconds', 'charity-is-hope') : esc_html__('%s second', 'charity-is-hope'), $diff)) : esc_html__('less then minute', 'charity-is-hope');
			return $rez;
		} else
			return $dt1;
	}
}

// Prepare month names in date for translation
if (!function_exists('charity_is_hope_get_date_translations')) {
	function charity_is_hope_get_date_translations($dt) {
		return str_replace(
			array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',
				  'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
			array(
				esc_html__('January', 'charity-is-hope'),
				esc_html__('February', 'charity-is-hope'),
				esc_html__('March', 'charity-is-hope'),
				esc_html__('April', 'charity-is-hope'),
				esc_html__('May', 'charity-is-hope'),
				esc_html__('June', 'charity-is-hope'),
				esc_html__('July', 'charity-is-hope'),
				esc_html__('August', 'charity-is-hope'),
				esc_html__('September', 'charity-is-hope'),
				esc_html__('October', 'charity-is-hope'),
				esc_html__('November', 'charity-is-hope'),
				esc_html__('December', 'charity-is-hope'),
				esc_html__('Jan', 'charity-is-hope'),
				esc_html__('Feb', 'charity-is-hope'),
				esc_html__('Mar', 'charity-is-hope'),
				esc_html__('Apr', 'charity-is-hope'),
				esc_html__('May', 'charity-is-hope'),
				esc_html__('Jun', 'charity-is-hope'),
				esc_html__('Jul', 'charity-is-hope'),
				esc_html__('Aug', 'charity-is-hope'),
				esc_html__('Sep', 'charity-is-hope'),
				esc_html__('Oct', 'charity-is-hope'),
				esc_html__('Nov', 'charity-is-hope'),
				esc_html__('Dec', 'charity-is-hope'),
			),
			$dt);
	}
}
?>