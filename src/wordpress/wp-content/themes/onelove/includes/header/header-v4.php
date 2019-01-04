<?php 
	global $catanis;
	$catanis_page = $catanis->pageconfig;
	
	$contentLeft = 0;
	$clssExtendBox 	= ' container';
	$headerClass 	= 'cata-header ' . $catanis_page['header_style'] . ' cata-' .$catanis_page['menu_color_style'];
	if( isset($catanis_page['header_fullwidth']) && $catanis_page['header_fullwidth'] == true) {
		$clssExtendBox 	= '';
		$headerClass	.= ' section-fwidth';
	}
	
	if( isset($catanis_page['show_header_cart']) && $catanis_page['show_header_cart']== 'true') {
		$contentLeft +=1;
	}
	if( isset($catanis_page['show_slideout_widget']) && $catanis_page['show_slideout_widget']== 'true') {
		$contentLeft +=1;
	}
	if( isset($catanis_page['show_header_search']) && $catanis_page['show_header_search']== 'true') {
		$contentLeft +=1;
	}
	$clssExtendBox 	.= ($contentLeft != 0) ? '' : ' no-ctent';

	$bg_header = $catanis_page['header_bg'];
?>
<header id="cata-main-header" class="<?php echo esc_attr($headerClass); ?>"<?php echo ( catanis_option( 'header_fixed' ) ) ? esc_attr(' data-header-fixed=true') : '' ; ?>>
	
	<div class="header-top" style="background-image:url(<?php echo esc_url($bg_header); ?>)">
		<?php if( isset($catanis_page['show_store_notice']) && $catanis_page['show_store_notice'] == true): ?>
			<div class="cata-store-notice">
				<div class="container">
					<?php echo wp_kses_post($catanis_page['store_notice']); ?>
				</div>
			</div>
		<?php endif; ?>
		
		<?php catanis_html_header_logo(); ?>
	</div>
	<div class="header-bottom">
		<div class="header-bottom-container<?php echo esc_attr($clssExtendBox); ?>">
			
			<div class="header-content-left">
				<?php if( isset($catanis_page['show_header_socials']) && $catanis_page['show_header_socials'] == 'true'): ?>
				<div class="header-socials">
					<?php catanis_html_socials_theme_option(array('echo' => true, 'show_title' => false, 'class' => ''));?>
				</div>
				<?php endif; ?>
			</div>
			
			<div class="header-content-right">
			
		        <?php if( isset($catanis_page['show_slideout_widget']) && $catanis_page['show_slideout_widget']== 'true'): ?>
				<div class="header-sidewidget">
					<a href="#sidewidgetarea"> 
						<span class="iconn ti-align-right"></span>
					</a> 
				</div>
				<?php endif; ?>
				 
				<?php if( isset($catanis_page['show_header_cart']) && $catanis_page['show_header_cart']== 'true'): ?>
				<div class="header-cart">
					<?php catanis_html_header_minicart(); ?>
		        </div>
		        <?php endif; ?>
		        
		        <?php if( isset($catanis_page['show_header_search']) && $catanis_page['show_header_search']== 'true'): ?>
				<div class="header-search">
					<span class="iconn ti-search"></span>
				</div>
				<?php endif; ?>
		        
			</div>
			<nav id="catanis_menu" class="catanis-main-menu">
				<?php catanis_html_header_main_menu(); ?>
			</nav>
			
		</div>
	</div> 
	
	<?php 
		/*Hook Mobile Navigation*/
		do_action( 'catanis_hook_nav_mobile' ); 
	?>
</header>