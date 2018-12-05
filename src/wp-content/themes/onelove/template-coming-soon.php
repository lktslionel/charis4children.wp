<?php 
/**
 * Template Name: Coming Soon Template
 */
?>
<?php get_header('coming'); ?>
<div class="page-template">
	<div id="cata-main-content">
		<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
			<?php 
				$logo = catanis_option('comingsoon_logo');
				$bg = catanis_option('comingsoon_bg');
				$large_title = catanis_option('comingsoon_large_title');
				$small_title = catanis_option('comingsoon_small_title');
				$disable_subscribe = catanis_option('comingsoon_disable_subscribe');
				$countdown = catanis_option('comingsoon_countdown');
				
				$style = isset($_GET['style']) ? $_GET['style'] : catanis_option('comingsoon_style');
				if ($style == 'v2') {
					$countdown_sc = '[cata_countdown main_style="style1" date="'.$countdown['days'].'" month="'.$countdown['month'].'" year="'.$countdown['year'].'" hours="'.$countdown['hours'].'" minutes="'.$countdown['minutes'].'"]';
					
					$videoUrl = catanis_option('comingsoon_video_url');
					$startAt = catanis_option('comingsoon_video_startat');
					$stopAt = catanis_option('comingsoon_video_stopat');
					
				}else{
					$countdown_sc = '[cata_countdown main_style="style3" date="'.$countdown['days'].'" month="'.$countdown['month'].'" year="'.$countdown['year'].'" hours="'.$countdown['hours'].'" minutes="'.$countdown['minutes'].'"]';
					
					/*Only Demo Purpose*/
					if(isset($_GET['style'])){
						$large_title = esc_html('Coming Soon','onelove');
						$small_title = esc_html('STAY TUNED, WE ARE LAUNCHING VERY SOON...','onelove');
					}
				}
				
				global $catanis;
				$custom_css = '';
				if(!empty($bg)){ 
					$custom_css .= 'body.coming-soon.v1 .cata-body-wrapper #main-container-wrapper{background-image: url('. esc_url($bg) .');}';
					$custom_css .= 'body.coming-soon.v2 {background-image: url('. esc_url($bg) .');}';
				}
				$catanis->inlinestyle[] = $custom_css;
				
			?>
			<div class="cata-coming-soon cata-<?php echo esc_attr($style); ?>">
				<?php if($style == 'v2') : ?> 
					<div id="comingsoon_fvideo" class="player" data-property="{videoURL:'<?php echo esc_url($videoUrl); ?>',containment:'body', autoPlay:true, showControls:false, showYTLogo:false, mute:true, loop:true, opacity:1, startAt:<?php echo absint($startAt); ?>, stopAt:<?php echo absint($stopAt); ?>}"><?php esc_html_e('Video', 'onelove'); ?></div>
				<?php endif; ?>
				
				<h1 class="cata-logo"><a href="<?php echo esc_url( home_url('/') ); ?>"><img src="<?php echo esc_url($logo)?>" alt=""/></a></h1>
				
				<div class="cata-content-middle">
					<h1 class="cata-large-title"><?php echo esc_html($large_title); ?></h1>
					<p class="cata-small-title"><?php echo wp_kses_post($small_title); ?></p>
					<?php echo do_shortcode($countdown_sc); ?>
				</div>
				
				<footer class="cata-footer v2">
					<div class="footer-top dark">
						<div class="container">
							<div class="footer-socials">
								<?php catanis_html_socials_theme_option();?>
							</div>
							<div class="copyright">
								<?php echo do_shortcode(catanis_option( 'footer_copyright' )); ?>
							</div>
						</div>
					</div>
				</footer>
			</div>
				
			</div> 
		</div>
	</div> <!-- end main-content -->
</div>
<?php get_footer(); ?>