<?php 
	global $catanis;
	$catanis_page = $catanis->pageconfig;

	$footer_bg = $catanis_page['footer_background'];
	$footer_top_color_scheme = $catanis_page['footer_top_color_scheme'];
	$footer_bottom_color_scheme = $catanis_page['footer_bottom_color_scheme'];
	$ext_class = !empty( $footer_bg ) ? ' cata-with-bg' : '';
	
	if($footer_top_color_scheme == 'light' && !empty( $footer_bg )){
		$footer_top_color_scheme = 'dark';
		$footer_bottom_color_scheme = 'dark';
	}
?>

<?php if ( ! empty( $footer_bg ) ) :?>
	<div class="cata-footer-bg cata-color-<?php echo esc_attr($footer_top_color_scheme); ?>" style="background-image: url(<?php echo esc_url( $footer_bg); ?>)"></div>
<?php endif; ?>

<div class="footer-top color-<?php echo esc_attr($footer_top_color_scheme . $ext_class); ?>">
	<div class="container">
		
		<?php echo do_shortcode('[cata_footer_logo]'); ?>
		
		<div class="cata-footer-contact-info">
			<p><?php echo do_shortcode('[cata_footer_address]'); ?></p>
			<p><?php echo do_shortcode('[cata_footer_phone]'); ?></p>
			<p><?php echo do_shortcode('[cata_footer_email]'); ?></p>
		</div>
		
		<div class="footer-socials">
			<?php catanis_html_socials_theme_option();?>
		</div>
	</div>
</div>

<hr class="<?php echo esc_attr($footer_top_color_scheme); ?>">
<div class="footer-bottom color-<?php echo esc_attr($footer_bottom_color_scheme . $ext_class); ?>">
	<div class="container">
		<div class="copyright">
			<?php echo do_shortcode(catanis_option( 'footer_copyright' )); ?>
		</div>
	</div>
</div>