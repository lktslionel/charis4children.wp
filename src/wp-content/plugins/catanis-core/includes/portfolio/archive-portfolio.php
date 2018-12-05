<?php 
	if( !function_exists('catanis_option') ){
		return '';
	}
	
	global $catanis;
	
	$catanis_page = $catanis->pageconfig;	
	$_main_class = ( ! empty( $catanis_page['layout'] ) && $catanis_page['layout'] != 'full' ) ? 'col-md-9' : 'col-md-12';
?>
<?php get_header(); ?>

<div class="page-template container <?php catanis_extend_class_page( true ); ?>">
	<?php if ( $catanis_page['layout'] == 'left' ) : get_sidebar(); endif; ?>

	<div id="cata-main-content" class="<?php echo esc_attr($_main_class); ?>">
		<?php if ( have_posts() ) : ?>
			
			<?php if( !empty(term_description()) ): ?>
			<header class="page-header">
				<?php the_archive_description( '<div class="tax-desc">', '</div>' ); ?>
			</header>
			<?php endif; ?>
			
			<?php 
				$sc = '[cata_portfolio';
				if(isset($wp_query->query_vars['portfolio_tags']) && !empty($wp_query->query_vars['portfolio_tags'])){
					$sc .= ' portfolio_tags="' . $wp_query->query_vars['portfolio_tags'] . '"';
				}
				$sc .= ' portfolio_style="' . catanis_option( 'portfolio_style' ) . '"';
				$sc .= ' portfolio_count="' . catanis_option( 'portfolio_per_page' ) . '"';
				$sc .= ' portfolio_columns="' . catanis_option( 'portfolio_columns' ) . '"';
				$sc .= ' portfolio_hover_style="' . catanis_option( 'portfolio_hover_style' ) . '"';
				$sc .= ' portfolio_spacing="' . catanis_option( 'portfolio_spacing' ) . '"';
				$sc .= ' spacing_size="' . catanis_option( 'spacing_size' ) . '"';
				$sc .= ' image_source="' . catanis_option( 'image_source' ) . '"';
				$sc .= ' portfolio_show_filter="no"]';
				echo do_shortcode($sc);
			?>
			
		<?php  else: ?>
		
			<?php get_template_part( 'includes/post-templates/content', 'none' ); ?>
			
		<?php endif; ?>
	</div>
	
	<?php if ( $catanis_page['layout'] == 'right' ): get_sidebar(); endif; ?>
</div>

<?php get_footer(); ?>
