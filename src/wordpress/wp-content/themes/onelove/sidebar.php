<?php 
	global $catanis;
	$catanis_page = $catanis->pageconfig;	
?>
<?php if ( is_active_sidebar( $catanis_page['sidebar']) &&  $catanis_page['layout'] != 'full') : ?>
	<aside class="cata-sidebar col-md-3 <?php echo esc_attr($catanis_page['layout']); ?>-sidebar">
		<div class="cata-wrapper clearfix">
			<?php dynamic_sidebar( $catanis_page['sidebar'] ); ?>
		</div>
	</aside>
<?php else: ?>
	<aside class="cata-sidebar col-md-3 <?php echo esc_attr($catanis_page['layout']); ?>-sidebar">
		<div class="cata-wrapper clearfix">
			<div class="widget-title-wrapper"><h5 class="widget-title heading-title">SideBar</h5></div>
			<p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">
			<?php printf( esc_html__('Click here to assign a widget to "%s" area', 'onelove'), $catanis_page['sidebar']); ?>
			</a></p>
		</div>
	</aside>
<?php endif; ?>