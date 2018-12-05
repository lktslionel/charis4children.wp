			<?php do_action( 'catanis_hook_after_main_container' ); ?>
			</div> <!-- end #main-container-wrapper -->
			
			<?php catanis_get_footer_style();?>
		
		</div> <!-- end #cata-template-wrapper -->
	</div> <!-- END .cata-body-wrapper -->

	<?php 
		get_template_part ( 'includes/slideout_widget' ); 
		do_action( 'catanis_hook_footer' ); 
		wp_footer(); 
	?>
</body>
</html>