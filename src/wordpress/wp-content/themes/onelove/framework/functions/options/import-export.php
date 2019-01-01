<?php
global $catanis;
$catanis_options= array( 
	array(
		'name' 		=> esc_html_x('Import &amp; Export Settings', 'Theme Options Tab', 'onelove'),
		'type' 		=> 'title',
		'img' 		=> 'icon-tools',
		'class' 	=> 'bg-dark'
	),
	array(
		'type' 		=> 'open',
		'subtitles'	=> array(
			array( 'id' => 'import', 'name' 	=> esc_html_x('Import', 'Theme Options Subtab', 'onelove') ),
			array( 'id' => 'export', 'name' 	=> esc_html_x('Export', 'Theme Options Subtab', 'onelove') )
		 )
	),

	/*IMPORT SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'import'
	),
	array(
		'name' 		=> esc_html__( 'Import', 'onelove'),
		'id' 		=> 'import_options',
		'type' 		=> 'import'
	),
		
	array('type' 	=> 'close'),

	/*EXPORT SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'export'
	),
	array(
		'name' 		=> esc_html__( 'Export', 'onelove'),
		'id' 		=> 'export_options',
		'type' 		=> 'export'
	),
		
	array('type' 	=> 'close'),
		
	array('type' 	=> 'close') 
);

$catanis->options->add_option_set( $catanis_options );
?>