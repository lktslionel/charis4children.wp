<?php 
	global $catanis;
	
	$catanis_page = $catanis->pageconfig;	
	$_main_class = (!empty($catanis_page['layout']) && $catanis_page['layout'] != 'full') ? 'col-md-9' : 'col-md-12';
?>
<?php get_header(); ?>

<div class="page-template <?php catanis_extend_class_page(true); ?>">
	<?php if($catanis_page['layout'] == 'left'): get_sidebar(); endif;?>

	<div id="cata-main-content" class="<?php echo esc_attr($_main_class); ?>">
		<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
		
			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
				
				<div class="entry-content">
					<?php if( isset($catanis_page['vc_enabled']) && !$catanis_page['vc_enabled']): echo '<div class="cata-container">'; endif; ?>
						<?php the_content(); ?>
						<?php wp_link_pages(); ?>
					<?php if( isset($catanis_page['vc_enabled']) && !$catanis_page['vc_enabled']): echo '</div>'; endif;?>
				</div> 
				
			</div>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<div class="container"><?php comments_template('',true); ?></div>
			<?php endif;?>
			
		<?php endwhile; endif; ?>
	</div>
	
	<?php if($catanis_page['layout'] == 'right'): get_sidebar(); endif;?>
</div>

<?php get_footer(); ?>