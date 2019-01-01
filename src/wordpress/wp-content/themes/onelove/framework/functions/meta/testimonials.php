<?php
global $catanis;
$option = array(
	'boxtabs' 	=> false,
	'boxsimple' => true,
	'secondary_metaboxes' => array(
		array(
			'name' 		=> esc_html__( 'Author Name', 'onelove'),
			'id' 		=> 'author',
			'type' 		=> 'text'
		),
		array(
			'name' 		=> esc_html__( 'Testimonial', 'onelove'),
			'id' 		=> 'testimonial',
			'type' 		=> 'textarea',
			's_desc'	=> esc_html__( 'Enter the name of the author for this testimonial.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Rating Star', 'onelove'),
			'id' 		=> 'rating_star',
			'type' 		=> 'select',
			'std' 		=> '5',
			'options' 	=> array(
				array( 'id' => '1', 'name' => esc_html__( '1 Star', 'onelove' )),
				array( 'id' => '2', 'name' => esc_html__( '2 Stars', 'onelove' )),
				array( 'id' => '3', 'name' => esc_html__( '3 Stars', 'onelove' )),
				array( 'id' => '4', 'name' => esc_html__( '4 Stars', 'onelove' )),
				array( 'id' => '5', 'name' => esc_html__( '5 Stars', 'onelove' ))
			),
			's_desc' 	=> esc_html__( 'Choose a star number for this testimonial.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Author Avatar', 'onelove'),
			'id' 		=> 'thumbnail',
			'type' 		=> 'upload',
			'is-thumb' 	=> true,
		),
		array(
			'name' 		=> esc_html__( 'Occupation', 'onelove'),
			'id' 		=> 'occupation',
			'type' 		=> 'text',
			's_desc' 	=> esc_html__( 'Enter the author\'s occupation.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Organization', 'onelove'),
			'id' 		=> 'organization',
			'type' 		=> 'text',
			's_desc' 	=> esc_html__( 'Enter the author\'s organization.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Organization URL', 'onelove'),
			'id' 		=> 'organization_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Link to Organization page (remember to input "http://").', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Open link in a new window', 'onelove'),
			'id' 		=> 'target_link',
			'type' 		=> 'checkbox',
			'std' 		=> true
		)
	)
);

/*------------------------------------------------------- 
DON'T CHANGE---------------------------------------------*/
$catanis->meta[ basename(__FILE__, ".php") ] = $option;

