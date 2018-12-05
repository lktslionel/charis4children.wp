<!DOCTYPE html>
<!--[if !IE]><!--> <html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php 
	catanis_theme_favicon();
	wp_head();
	?>
</head>
<?php 
	global $catanis;
	$catanis_page = $catanis->pageconfig;
	
	$menu_style = ( isset($catanis_page['menu_style']) && $catanis_page['menu_style'] == 'vertical' ) ? 'vertical' : 'horizontal';
?>
<body <?php body_class(); ?>>
	<div id="catanis-loader"><?php echo catanis_get_pageloader(); ?></div>

	<?php 
		if ($menu_style == 'vertical') {
			catanis_get_header_style();
		}
	?>
			
	<div class="cata-body-wrapper">
		
		<div id="home"></div>
		<div id="cata-template-wrapper" class="template-wrapper">
			<?php if( isset($catanis_page['show_header_search']) && $catanis_page['show_header_search']): ?>
			<div id="search-outer">
				<div class="container">
				     <div id="search-box"><?php get_search_form();?></div>
				     <div id="close"> <a href="#"><i class="ti-close"></i></a></div>
				 </div>
			</div>
			<?php endif; ?>
			
			<?php 
				if($catanis_page['page_title_position'] == 'above'){
					catanis_html_page_title();
				}
				
				if ($menu_style != 'vertical') {
					catanis_get_header_style();
				} 
				
				if($catanis_page['page_title_position'] == 'below'){
					catanis_html_page_title();
				}
			?>
			<div id="main-container-wrapper">
			<?php do_action( 'catanis_hook_before_main_container' ); ?>
	