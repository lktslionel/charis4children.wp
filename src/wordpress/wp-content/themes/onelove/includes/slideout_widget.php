<?php
	global $catanis;
	$catanis_page = $catanis->pageconfig;
?>

<?php if( isset($catanis_page['show_slideout_widget']) && $catanis_page['show_slideout_widget']) : ?>
<div id="slide-out-widget-area-bg" class="slide-out-from-right dark"></div>
<div id="slide-out-widget-area" class="slide-out-from-right open">		
	<div class="inner">
		<a class="slide_out_area_close" href="#"><span class="iconn ti-close"></span></a>
	   	<div id="text-5" class="widget widget_text">
	   		<h4>About CatanisThemes</h4>
			<div class="textwidget">
				<p>The Aldyn<br> 60 Riverside Boulevard<br> Lincoln Square, NY</p>
				<p>T: <a href="#">+698 (0)58 6985 1248</a><br>
					W: <a href="<?php echo esc_url('http://catanisthemes.com'); ?>" target="_blank" title="CatanisThemes">catanisthemes.com</a><br>
					E: <a href="<?php echo esc_url('info@catanisthemes.com'); ?>">info@catanisthemes.com</a></p>
			</div>
		</div>				
	</div>		
</div>
<?php endif; ?>