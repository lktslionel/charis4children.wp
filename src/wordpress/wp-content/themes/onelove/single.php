<?php 
	global $catanis;
	
	$catanis_page = $catanis->pageconfig;	
	$_main_class = (!empty($catanis_page['layout']) && $catanis_page['layout'] != 'full') ? 'col-md-9' : 'col-md-12';
?>
<?php get_header(); ?>
<div class="page-template <?php catanis_extend_class_page(true); ?>">
	<?php if($catanis_page['layout'] == 'left'): get_sidebar(); endif;?>
	<div id="cata-main-content" class="<?php echo esc_attr($_main_class); ?>">
		<?php
			while ( have_posts () ) :
				the_post ();
				catanis_set_post_views ( get_the_ID () );
				
				get_template_part ( 'includes/post-templates/content-single'); 
		
				if ( comments_open() || get_comments_number() ) :
					comments_template ( '', true );
				endif;
				
				if (isset($catanis_page['show_related_post']) && $catanis_page['show_related_post'] ) :
					get_template_part ( 'includes/related_posts' );
				endif;
				
			endwhile;
		?>
	</div>
	<?php if($catanis_page['layout'] == 'right'): get_sidebar(); endif;?>
</div>
<?php get_footer(); ?>
