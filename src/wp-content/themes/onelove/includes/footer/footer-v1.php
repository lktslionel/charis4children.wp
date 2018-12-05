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

<div class="footer-bottom color-<?php echo esc_attr($footer_bottom_color_scheme . $ext_class); ?>">
	<div class="container">
		<div class="row">
			<div class="copyright col-md-8">
				<?php echo do_shortcode(catanis_option( 'footer_copyright' )); ?>
			</div>
			<div class="footer-socials col-md-4">
				<?php catanis_html_socials_theme_option();?>
			</div>
		</div>
	</div>
</div>