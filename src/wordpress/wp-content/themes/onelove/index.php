<?php 
	global $catanis;
	
	$catanis_page = $catanis->pageconfig;
	$_main_class = (!empty($catanis_page['layout']) && $catanis_page['layout'] != 'full') ? 'col-md-9' : 'col-md-12';
	
	$clsPost = $post_style = $data_string = '';
	if(is_home() || (is_home() && is_front_page())){
		
		$post_columns	= catanis_option('blog_layout_columns');
		$post_style 	= catanis_option('blog_style');
		
		if(!in_array($post_style, array('list', 'onecolumn', 'masonry', 'grid'))){
			$post_style 	= 'onecolumn';
		}
		
		$post_style 	= (isset($catanis_page['layout']) && $catanis_page['layout'] != 'full' && $post_style == 'list') ? 'onecolumn' : $post_style;
	
		$elemClass 		= array( 'cata-element', 'cata-post' );
		switch( $post_style ) {
			case 'list':
			case 'onecolumn':
				array_push( $elemClass, 'cata-post-'. $post_style );
				break;
		
			case 'masonry':
				$post_spacing = 'yes';
				$spacing_size = 30;
				
				$data_string = ' data-spacing-size="' . esc_attr( $spacing_size ) . '" data-layout="masonry"';
				array_push( $elemClass, 'cata-isotope' );
				array_push( $elemClass, 'cata-isotope-masonry' );
				array_push( $elemClass, 'cata-cols'. $post_columns );
				if( $post_spacing == 'yes' ){
					array_push( $elemClass, 'cata-with-spacing' );
				}
				break;
		
			case 'grid':
			default:
				$post_spacing = 'yes';
				$spacing_size = 30;
		
				$data_string = ' data-spacing-size="' . esc_attr( $spacing_size ) . '" data-layout="fitRows"';
				array_push( $elemClass, 'cata-isotope' );
				array_push( $elemClass, 'cata-isotope-grid' );
				array_push( $elemClass, 'cata-cols'. $post_columns );
				if( $post_spacing == 'yes' ){
					array_push( $elemClass, 'cata-with-spacing' );
				}
				break;
		}
		
	}
?>
<?php get_header(); ?>
	<div class="page-template <?php catanis_extend_class_page(true); ?>">
		<?php if($catanis_page['layout'] == 'left'): get_sidebar(); endif;?>

		<div id="cata-main-content" class="<?php echo esc_attr($_main_class); ?>">
			<?php if ( have_posts() ) : ?>
				<div id="cata_post_<?php echo mt_rand(); ?>" class="<?php echo implode( ' ', $elemClass ); ?>" <?php echo trim( $data_string); ?>> 
					<div class="cata-isotope-container">
					
					<?php if ( in_array($post_style, array('masonry', 'grid')) ) : ?>
						<div class="cata-isotope-grid-sizer"></div>
					<?php endif; ?>
					
					<?php  while( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'includes/post-templates/content' ); ?>
					<?php endwhile; ?>
					</div>
				</div>
				<?php catanis_pagination_nextprev();?>
				
			<?php else : ?>
				<?php get_template_part( 'includes/post-templates/content', 'none' ); ?>
			<?php endif; ?>
		</div>
		
		<?php if($catanis_page['layout'] == 'right'): get_sidebar(); endif;?>
	</div>
<?php get_footer(); ?>