<?php 
/**
 * Template Name: Blogs Template
 */
?>

<?php 
	global $catanis;
	
	$catanis_page = $catanis->pageconfig;	
	$_main_class = (!empty($catanis_page['layout']) && $catanis_page['layout'] != 'full') ? 'col-md-9' : 'col-md-12';
?>
<?php get_header(); ?>

<div class="page-template blog-template <?php catanis_extend_class_page(true); ?>">
	<?php if($catanis_page['layout'] == 'left'): get_sidebar(); endif;?>

	<div id="cata-main-content" class="<?php echo esc_attr($_main_class); ?>">
		<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
		
			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div> 
			</div>

		<?php endwhile; endif; ?>
	</div>
	
	<?php if($catanis_page['layout'] == 'right'): get_sidebar(); endif;?>
	
	<?php 
		if( catanis_option( 'blog_template_enable_ads' ) ) {
			if( function_exists( 'catanis_single_image_shortcode_function' ) && $catanis_page['layout'] != 'full' ):
			echo '<div class="blog-template-abs-footer cata-has-animation cata-fadeInUp">';
			echo catanis_single_image_shortcode_function(array(
				'image' 		=> catanis_option('blog_template_ads_img'),
				'img_size' 		=> 'full',
				'img_align' 	=> 'img-left',	
				'hover_effect' 	=> 'effect-snow',
				'onclick' 		=> 'custom_link',
				'link' 			=> catanis_option('blog_template_ads_url'),
				'target_link' 	=> catanis_option('blog_template_ads_target'),
				'ext_class' 	=> ''
			));
			echo '</div>';
		endif;
	}
	?>
</div>

<?php get_footer(); ?>
