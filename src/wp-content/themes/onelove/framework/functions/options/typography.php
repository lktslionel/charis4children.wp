<?php
global $catanis;
$catanis_options = array( 
	array(
		'name' 		=> esc_html_x('Typography Settings', 'Theme Options Tab', 'onelove'),
		'type' 		=> 'title',
		'img' 		=> 'icon-danielbruce',
		'class' 	=> 'bg-success'
	),
	array(
		'type' 		=> 'open',
		'subtitles'	=> array(
			array( 'id' => 'general', 'name' 	=> esc_html_x('General', 'Theme Options Subtab', 'onelove') )
		)
	),

	/*GENERAL SETTINGS*/
	array(
		'type' 		=> 'subtitle',
		'id'		=> 'general'
	),
	array(
		'name' 		=> esc_html__( 'Body Font', 'onelove'),
		'id' 		=> 'body_font',
		'type' 		=> 'multioption',
		'extClass' 	=> 'fontgroup',
		's_desc'	=> esc_html__( 'Specify the Body font properties.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Font family', 'onelove'),
				'id' 		=> 'family',
				'type' 		=> 'select',
				'std' 		=> 'Raleway',
				'options' 	=> Catanis_Default_Data::themeFonts()
			),
			array(
				'name' 		=> esc_html__( 'Font Weight & Style', 'onelove'),
				'id' 		=> 'weight',
				'type' 		=> 'select',
				'std' 		=> '400',
				'options' 	=> Catanis_Default_Data::themeOptions( 'font-weight-style' )
			),
			array(
				'name' 		=> esc_html__( 'Text Transform', 'onelove'),
				'id' 		=> 'text_transform',
				'type' 		=> 'select',
				'std' 		=> 'none',
				'options' 	=> Catanis_Default_Data::themeOptions( 'text-transform' )
			),
			array(
				'name' 		=> esc_html__( 'Font size', 'onelove'),
				'id' 		=> 'size',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '14'
			),
			array(
				'name' 		=> esc_html__( 'Line height', 'onelove'),
				'id' 		=> 'line_height',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '24'
			),
			array(
				'name' 		=> esc_html__( 'Letter Spacing', 'onelove'),
				'id' 		=> 'letter_spacing',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '0'
			)			
		)
	),
	array(
		'name' 		=> esc_html__( 'Navigation Font', 'onelove'),
		'id' 		=> 'navigation_font',
		'type' 		=> 'multioption',
		'extClass' 	=> 'fontgroup',
		's_desc'	=> esc_html__( 'This font will be used for all navigation.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Font family', 'onelove'),
				'id' 		=> 'family',
				'type' 		=> 'select',
				'std' 		=> 'Raleway',
				'options' 	=> Catanis_Default_Data::themeFonts()
			),
			array(
				'name' 		=> esc_html__( 'Font Weight & Style', 'onelove'),
				'id' 		=> 'weight',
				'type' 		=> 'select',
				'std' 		=> '600',
				'options' 	=> Catanis_Default_Data::themeOptions( 'font-weight-style' )
			),
			array(
				'name' 		=> esc_html__( 'Text Transform', 'onelove'),
				'id' 		=> 'text_transform',
				'type' 		=> 'select',
				'std' 		=> 'uppercase',
				'options' 	=> Catanis_Default_Data::themeOptions( 'text-transform' )
			),
			array(
				'name' 		=> esc_html__( 'Font size', 'onelove'),
				'id' 		=> 'size',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '13'
			),
			/*array(
				'name' 		=> esc_html__( 'Line height', 'onelove'),
				'id' 		=> 'line_height',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '24'
			),*/
			array(
				'name' 		=> esc_html__( 'Letter Spacing', 'onelove'),
				'id' 		=> 'letter_spacing',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '0'
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Navigation Dropdown Font', 'onelove'),
		'id' 		=> 'navigation_dropdown_font',
		'type' 		=> 'multioption',
		'extClass' 	=> 'fontgroup',
		's_desc'	=> esc_html__( 'This font will be used for dropdown navigation.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Font family', 'onelove'),
				'id' 		=> 'family',
				'type' 		=> 'select',
				'std' 		=> 'Raleway',
				'options' 	=> Catanis_Default_Data::themeFonts()
			),
			array(
				'name' 		=> esc_html__( 'Font Weight & Style', 'onelove'),
				'id' 		=> 'weight',
				'type' 		=> 'select',
				'std' 		=> '400',
				'options' 	=> Catanis_Default_Data::themeOptions( 'font-weight-style' )
			),
			array(
				'name' 		=> esc_html__( 'Text Transform', 'onelove'),
				'id' 		=> 'text_transform',
				'type' 		=> 'select',
				'std' 		=> 'none',
				'options' 	=> Catanis_Default_Data::themeOptions( 'text-transform' )
			),
			array(
				'name' 		=> esc_html__( 'Font size', 'onelove'),
				'id' 		=> 'size',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '14'
			),
			array(
				'name' 		=> esc_html__( 'Line height', 'onelove'),
				'id' 		=> 'line_height',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '24'
			),
			array(
				'name' 		=> esc_html__( 'Letter Spacing', 'onelove'),
				'id' 		=> 'letter_spacing',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '0'
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Page Heading Font', 'onelove'),
		'id' 		=> 'page_header_font',
		'type' 		=> 'multioption',
		'extClass' 	=> 'fontgroup',
		's_desc'	=> esc_html__( 'This font will be used for Page Heading title.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Font family', 'onelove'),
				'id' 		=> 'family',
				'type' 		=> 'select',
				'std' 		=> 'Playfair Display',
				'options' 	=> Catanis_Default_Data::themeFonts()
			),
			array(
				'name' 		=> esc_html__( 'Font Weight & Style', 'onelove'),
				'id' 		=> 'weight',
				'type' 		=> 'select',
				'std' 		=> '700',
				'options' 	=> Catanis_Default_Data::themeOptions( 'font-weight-style' )
			),
			array(
				'name' 		=> esc_html__( 'Text Transform', 'onelove'),
				'id' 		=> 'text_transform',
				'type' 		=> 'select',
				'std' 		=> 'none',
				'options' 	=> Catanis_Default_Data::themeOptions( 'text-transform' )
			),
			array(
				'name' 		=> esc_html__( 'Font size', 'onelove'),
				'id' 		=> 'size',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '50'
			),
			array(
				'name' 		=> esc_html__( 'Line height', 'onelove'),
				'id' 		=> 'line_height',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '60'
			),
			array(
				'name' 		=> esc_html__( 'Letter Spacing', 'onelove'),
				'id' 		=> 'letter_spacing',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '0'
			)
		)
	),
	array(
		'name' 		=> esc_html__( 'Page Heading Subtitle Font', 'onelove'),
		'id' 		=> 'page_header_subtitle_font',
		'type' 		=> 'multioption',
		'extClass' 	=> 'fontgroup',
		's_desc'	=> esc_html__( 'This font will be used for Page Heading Subtitle, also use this font for H1 -> H6.', 'onelove'),
		'fields' 	=> array(
			array(
				'name' 		=> esc_html__( 'Font family', 'onelove'),
				'id' 		=> 'family',
				'type' 		=> 'select',
				'std' 		=> 'PT Serif',
				'options' 	=> Catanis_Default_Data::themeFonts()
			),
			array(
				'name' 		=> esc_html__( 'Font Weight & Style', 'onelove'),
				'id' 		=> 'weight',
				'type' 		=> 'select',
				'std' 		=> '400',
				'options' 	=> Catanis_Default_Data::themeOptions( 'font-weight-style' )
			),
			array(
				'name' 		=> esc_html__( 'Text Transform', 'onelove'),
				'id' 		=> 'text_transform',
				'type' 		=> 'select',
				'std' 		=> 'capitalize',
				'options' 	=> Catanis_Default_Data::themeOptions( 'text-transform' )
			),
			array(
				'name' 		=> esc_html__( 'Font size', 'onelove'),
				'id' 		=> 'size',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '16'
			),
			array(
				'name' 		=> esc_html__( 'Line height', 'onelove'),
				'id' 		=> 'line_height',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '26'
			),
			array(
				'name' 		=> esc_html__( 'Letter Spacing', 'onelove'),
				'id' 		=> 'letter_spacing',
				'type' 		=> 'text',
				'suffix' 	=> 'px',
				'std' 		=> '1'
			)
		)
	),
		
	array('type' 	=> 'close'),
		
	array('type' 	=> 'close' ) 
);

$catanis->options->add_option_set( $catanis_options );
?>