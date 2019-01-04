<?php 
	global $catanis;
	$catanis = new stdClass();
	
	require_once( trailingslashit( get_template_directory() ). 'framework/init.php' );
	require_once( trailingslashit( get_template_directory() ). 'framework/setup.php' );

	remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );
?>