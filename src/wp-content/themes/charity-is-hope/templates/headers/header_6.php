<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'charity_is_hope_template_header_6_theme_setup' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_template_header_6_theme_setup', 1 );
	function charity_is_hope_template_header_6_theme_setup() {
		charity_is_hope_add_template(array(
			'layout' => 'header_6',
			'mode'   => 'header',
			'title'  => esc_html__('Header 6', 'charity-is-hope'),
			'icon'   => charity_is_hope_get_file_url('templates/headers/images/6.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'charity_is_hope_template_header_6_output' ) ) {
	function charity_is_hope_template_header_6_output($post_options, $post_data) {

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!='' 
				? ' style="background-image: url('.esc_url($header_image).')"' 
				: '';
		}
		?>

		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_6 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_6 top_panel_position_<?php echo esc_attr(charity_is_hope_get_custom_option('top_panel_position')); ?>">

			<?php if (charity_is_hope_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<?php
						charity_is_hope_template_set_args('top-panel-top', array(
							'top_panel_top_components' => array('login', 'currency', 'bookmarks', 'language', 'cart')
						));
						get_template_part(charity_is_hope_get_file_slug('templates/headers/_parts/top-panel-top.php'));
						?>
					</div>
				</div>
			<?php } ?>
			<div class="top_panel_middle" <?php charity_is_hope_show_layout($header_css); ?>>
				<div class="content_wrap">
					<div class="contact_logo">
						<?php charity_is_hope_show_logo(true, true); ?>
					</div>
					<?php
					// info link
					$first_button = charity_is_hope_get_custom_option('first_button');
					$first_button_link = charity_is_hope_get_custom_option('first_button_link');
					if (!empty($first_button) && !empty($first_button_link))  { ?>
						<div class="contact_button">
							<?php
							if (!empty($first_button) && !empty($first_button_link)){
								echo '<a class="first_button" href="'.esc_url($first_button_link).'">'.esc_html($first_button).'</a>';
							}
							?>
						</div>
					<?php
					}
					?>
					<div class="menu_main_wrap">
						<nav class="menu_main_nav_area menu_hover_<?php echo esc_attr(charity_is_hope_get_theme_option('menu_hover')); ?>">
							<?php
							$menu_main = charity_is_hope_get_nav_menu('menu_main');
							if (empty($menu_main)) $menu_main = charity_is_hope_get_nav_menu();
							charity_is_hope_show_layout($menu_main);
							?>
						</nav>
					</div>
				</div>
			</div>

			</div>
		</header>

		<?php
		charity_is_hope_storage_set('header_mobile', array(
				'open_hours' => false,
				'login' => true,
				'socials' => true,
				'bookmarks' => false,
				'contact_address' => false,
				'contact_phone_email' => false,
				'woo_cart' => false,
				'search' => true
			)
		);
	}
}
?>