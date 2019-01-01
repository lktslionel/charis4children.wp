<?php 
/**
 * Template Name: Intro Template
 */
?>
<?php get_header(); ?>
<div class="page-template <?php catanis_extend_class_page(true); ?>">
	<div id="cata-main-content">
		<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
			</div> 
		</div>
	</div>
</div>
<?php get_footer(); ?>