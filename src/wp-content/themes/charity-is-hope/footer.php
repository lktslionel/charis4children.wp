<?php
/**
 * The template for displaying the footer.
 */

				charity_is_hope_close_wrapper();	// <!-- </.content> -->

				// Show main sidebar
				get_sidebar();

				if (charity_is_hope_get_custom_option('body_style')!='fullscreen') charity_is_hope_close_wrapper();	// <!-- </.content_wrap> -->
				?>
			
			</div>		<!-- </.page_content_wrap> -->
			
			<?php
			// Footer Testimonials stream
			if (charity_is_hope_get_custom_option('show_testimonials_in_footer')=='yes') { 
				$count = max(1, charity_is_hope_get_custom_option('testimonials_count'));
				$data = charity_is_hope_sc_testimonials(array('count'=>$count));
				if ($data) {
					?>
					<footer class="testimonials_wrap sc_section scheme_<?php echo esc_attr(charity_is_hope_get_custom_option('testimonials_scheme')); ?>">
						<div class="testimonials_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php charity_is_hope_show_layout($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}

			if (charity_is_hope_get_custom_option('show_area_in_footer')=='yes') {
				$area_text = charity_is_hope_get_custom_option('area_in_footer');
				if (!empty($area_text)) {
					?>
					<footer class="area_wrap">
						<div class="area_wrap_inner">
							<div class="content_wrap">
								<div class="area_text">
									<?php echo charity_is_hope_do_shortcode(apply_filters('charity_is_hope_filter_sc_clear_around', $area_text)); ?>
								</div>
							</div>	<!-- /.content_wrap -->
						</div>	<!-- /.area_wrap_inner -->
					</footer>	<!-- /.area_wrap -->
				<?php
				}
			}




			// Footer sidebar
			$footer_show  = charity_is_hope_get_custom_option('show_sidebar_footer');
			$sidebar_name = charity_is_hope_get_custom_option('sidebar_footer');
			if(charity_is_hope_get_custom_option('show_contacts_in_footer')=='yes' || (!charity_is_hope_param_is_off($footer_show) && is_active_sidebar($sidebar_name)))
			?>
			<footer class="footer_wrap widget_area scheme_<?php echo esc_attr(charity_is_hope_get_custom_option('sidebar_footer_scheme')); ?>">
				<div class="footer_wrap_inner widget_area_inner">
					<div class="content_wrap">
						<div class="columns_wrap">

							<?php
								// Footer contacts
								if (charity_is_hope_get_custom_option('show_contacts_in_footer')=='yes') { ?>
								<div class="column-1_2">
								<?php
								$contacts_in_footer = charity_is_hope_get_theme_option('contacts_in_footer');
									?>
									<div class="contacts_wrap">
										<div class="contacts_wrap_inner">
												<?php charity_is_hope_show_logo(false, false, true); ?>
												<div class="contacts_address">
													<?php if (!empty($contacts_in_footer)) echo charity_is_hope_do_shortcode(apply_filters('charity_is_hope_filter_sc_clear_around', $contacts_in_footer)); ?>
												</div>
										</div>	<!-- /.contacts_wrap_inner -->
									</div>	<!-- /.contacts_wrap -->
								</div><div class="column-1_2 width_right">
								<?php
								}
								else { ?>
								<div class="column-1_1">
								<?php
								}

								?>

							<div class="columns_wrap">
								<?php
								if (!charity_is_hope_param_is_off($footer_show) && is_active_sidebar($sidebar_name)) {
									charity_is_hope_storage_set('current_sidebar', 'footer');
										ob_start();
										do_action( 'before_sidebar' );
										if ( !dynamic_sidebar($sidebar_name) ) {
											// Put here html if user no set widgets in sidebar
										}
										do_action( 'after_sidebar' );
										$out = ob_get_contents();
										ob_end_clean();
										charity_is_hope_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out));
								}
								?>
							</div></div>
						</div>	<!-- /.columns_wrap -->
					</div>	<!-- /.content_wrap -->
				</div>	<!-- /.footer_wrap_inner -->
			</footer>	<!-- /.footer_wrap -->
<?php


			// Footer Twitter stream
			if (charity_is_hope_get_custom_option('show_twitter_in_footer')=='yes' && function_exists('charity_is_hope_sc_twitter')) {
				$count = max(1, charity_is_hope_get_custom_option('twitter_count'));
				$data = charity_is_hope_sc_twitter(array('count'=>$count));
				if ($data) {
					?>
					<footer class="twitter_wrap sc_section scheme_<?php echo esc_attr(charity_is_hope_get_custom_option('twitter_scheme')); ?>">
						<div class="twitter_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php charity_is_hope_show_layout($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}


			// Google map
			if ( charity_is_hope_get_custom_option('show_googlemap')=='yes' ) { 
				$map_address = charity_is_hope_get_custom_option('googlemap_address');
				$map_latlng  = charity_is_hope_get_custom_option('googlemap_latlng');
				$map_zoom    = charity_is_hope_get_custom_option('googlemap_zoom');
				$map_style   = charity_is_hope_get_custom_option('googlemap_style');
				$map_height  = charity_is_hope_get_custom_option('googlemap_height');
				if (!empty($map_address) || !empty($map_latlng)) {
					$args = array();
					if (!empty($map_style))		$args['style'] = esc_attr($map_style);
					if (!empty($map_zoom))		$args['zoom'] = esc_attr($map_zoom);
					if (!empty($map_height))	$args['height'] = esc_attr($map_height);
                    if (function_exists('charity_is_hope_sc_googlemap')) charity_is_hope_show_layout(charity_is_hope_sc_googlemap($args));
				}
			}


			// Copyright area
			$copyright_style = charity_is_hope_get_custom_option('show_copyright_in_footer');
			if (!charity_is_hope_param_is_off($copyright_style)) {
				?> 
				<div class="copyright_wrap copyright_style_<?php echo esc_attr($copyright_style); ?>  scheme_<?php echo esc_attr(charity_is_hope_get_custom_option('copyright_scheme')); ?>">
					<div class="copyright_wrap_inner">
						<div class="content_wrap">
							<?php
							if ($copyright_style == 'menu') {
								if (($menu = charity_is_hope_get_nav_menu('menu_footer'))!='') {
									charity_is_hope_show_layout($menu);
								}
							} else if ($copyright_style == 'socials') {
								charity_is_hope_show_layout(charity_is_hope_sc_socials(array('size'=>"tiny")));
							}
							?>
							<div class="copyright_text"><?php charity_is_hope_show_layout(str_replace(array('{{Y}}', '{Y}'), date('Y'), charity_is_hope_get_custom_option('footer_copyright'))); ?></div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
			
		</div>	<!-- /.page_wrap -->

	</div>		<!-- /.body_wrap -->
	
	<?php wp_footer(); ?>

</body>
</html>