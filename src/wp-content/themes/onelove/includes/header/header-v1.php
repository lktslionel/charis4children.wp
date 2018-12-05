<?php 
	global $catanis;
	$catanis_page = $catanis->pageconfig;
	
	$show_header_phone 	= catanis_option('show_header_phone');
	$show_header_email 	= catanis_option('show_header_email');
	$show_header_address = catanis_option('show_header_address');
	
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
			        
?>
<header id="cata-main-header" class="<?php echo esc_attr($headerClass); ?>"<?php echo ( catanis_option( 'header_fixed' ) ) ? esc_attr(' data-header-fixed=true') : '' ; ?>>
	
	<div class="header-top">
		<div class="header-top-container<?php echo esc_attr($clssExtendBox); ?>">
			
			<div class="header-content-left">
				
				<?php if( isset($catanis_page['show_header_phone']) && $catanis_page['show_header_phone'] == 'true'): ?>
				<div class="header-phone">
					<?php echo wp_kses_post($show_header_phone['content']); ?>
				</div>
				<?php endif; ?>
				
				<?php if( isset($catanis_page['show_header_email']) && $catanis_page['show_header_email'] == 'true'): ?>
				<div class="header-email">
					<?php echo wp_kses_post($show_header_email['content']); ?>
				</div>
		        <?php endif; ?>
		        
		        <?php if( isset($catanis_page['show_header_address']) && $catanis_page['show_header_address']== 'true'): ?>
				<div class="header-address">
					<?php echo wp_kses_post($show_header_address['content']); ?>
				</div>
		        <?php endif; ?>
		        
			</div>
			
			<div class="header-content-right">
			 	<?php if( isset($catanis_page['show_header_socials']) && $catanis_page['show_header_socials']== 'true'): ?>
				<div class="header-socials">
					<span><?php esc_html_e('Follow:', 'onelove'); ?></span>
					<?php catanis_html_socials_theme_option(array('echo' => true, 'show_title' => false, 'class' => ''));?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	
	<div class="header-bottom">
		<div class="header-bottom-container<?php echo esc_attr($clssExtendBox); ?>">
			
			<div class="header-content-left">
				<?php catanis_html_header_logo(); ?>
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
