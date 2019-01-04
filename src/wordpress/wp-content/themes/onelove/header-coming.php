<!DOCTYPE html>
<!--[if IE 9]><html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage" class="ie ie9"> <![endif]-->
<!--[if !IE]><!--> <html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php 
	if ( ! (function_exists( 'wp_site_icon' ) && wp_site_icon()) ) :
		if( catanis_option('favicon') ) : $favicon = trim(catanis_option('favicon')); ?>
			<link rel="shortcut icon" type="image/x-icon" href="<?php echo esc_url($favicon); ?>" />
			<?php 
		endif;
	endif;
	wp_head();
	?>
</head>

<body <?php body_class(); ?>>
	<div class="ca-preloader"></div>
	<div id="particles-js"></div>
	<div class="cata-body-wrapper">
		<?php wp_reset_postdata(); ?>
		
		<div id="cata-template-wrapper" class="template-wrapper">
			<div id="main-container-wrapper">
				
			<?php do_action( 'catanis_hook_before_main_container' ); ?>
	