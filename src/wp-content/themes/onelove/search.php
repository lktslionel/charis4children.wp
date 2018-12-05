<?php 
	global $catanis;
	
	$catanis_page = $catanis->pageconfig;	
	$_main_class = (!empty($catanis_page['layout']) && $catanis_page['layout'] != 'full') ? 'col-md-9' : 'col-md-12';
	
	$elemClass 	= 'cata-element cata-post cata-isotope cata-isotope-masonry cata-cols3 cata-with-spacing search-area';
	$data_string = ' data-spacing-size="30" data-layout="masonry"';
?>
<?php get_header(); ?>
<div id="container" class="page-template container <?php catanis_extend_class_page(true); ?>">
	<?php if($catanis_page['layout'] == 'left'): get_sidebar(); endif;?>
	
	<div id="cata-main-content" class="<?php echo esc_attr($_main_class); ?>">
		<section class="cata-section cata-section-container-stretch">
			<div class="cata-container">
		<?php if ( have_posts() ) : ?>
			
			<div id="cata_post_<?php echo mt_rand(); ?>" class="<?php echo esc_attr($elemClass ); ?>" <?php echo trim( $data_string ); ?>> 
				<div class="cata-isotope-container">
					<div class="cata-isotope-grid-sizer"></div>
					<?php  while( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'includes/post-templates/content-search' ); ?>
					<?php endwhile; ?>
				</div>
			</div>
			<?php catanis_pagination();?>
			
		<?php else : ?>
			<?php get_template_part( 'includes/post-templates/content', 'none' ); ?>
		<?php endif; ?>
			</div>
		</section>
	</div>
	
	<?php if($catanis_page['layout'] == 'right'): get_sidebar(); endif;?>
</div>
<?php get_footer(); ?>