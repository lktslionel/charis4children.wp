<?php
global $catanis;
$option = array(
	'boxtabs' 	=> false,
	'boxsimple' => true,
	'secondary_metaboxes' => array(
		array(
			'name' 		=> esc_html__( 'Position', 'onelove'),
			'id' 		=> 'position',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Ex: CEO Yahoo, Theme Development', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Personal URL', 'onelove'),
			'id' 		=> 'personal_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Start url with http:// or https://', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Short description', 'onelove'),
			'id' 		=> 'short_description',
			'type' 		=> 'text',
			'large' 	=> true,
			's_desc'	=> esc_html__( 'This is Optional', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Email', 'onelove'),
			'id' 		=> 'email',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Gmail, Yahoo mail,...', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Twittter URL', 'onelove'),
			'id' 		=> 'twitter_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Link to Twittter page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Facebook URL', 'onelove'),
			'id' 		=> 'facebook_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Link to Facebook page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Google Plus URL', 'onelove'),
			'id' 		=> 'googleplus_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Link to Google Plus page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Pinterest URL', 'onelove'),
			'id' 		=> 'pinterest_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Link to Pinterest page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Instagram URL', 'onelove'),
			'id' 		=> 'instagram_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Link to Instagram page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Linkedin URL', 'onelove'),
			'id' 		=> 'linkedin_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Link to Linkedin page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Dribble URL', 'onelove'),
			'id' 		=> 'dribble_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Link to Dribble page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Behance URL', 'onelove'),
			'id' 		=> 'behance_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Link to Dribble page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Youtube URL', 'onelove'),
			'id' 		=> 'youtube_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Link to Youtube page.', 'onelove')
		),
		array(
			'name' 		=> esc_html__( 'Vimeo URL', 'onelove'),
			'id' 		=> 'vimeo_url',
			'type' 		=> 'text',
			's_desc'	=> esc_html__( 'Link to Vimeo page.', 'onelove')
		)
	)
);

/*------------------------------------------------------- 
DON'T CHANGE---------------------------------------------*/
$catanis->meta[ basename(__FILE__, ".php") ] = $option;
?>