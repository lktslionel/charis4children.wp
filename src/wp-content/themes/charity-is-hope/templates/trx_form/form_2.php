<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'charity_is_hope_template_form_2_theme_setup' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_template_form_2_theme_setup', 1 );
	function charity_is_hope_template_form_2_theme_setup() {
		charity_is_hope_add_template(array(
			'layout' => 'form_2',
			'mode'   => 'forms',
			'title'  => esc_html__('Contact Form 2', 'charity-is-hope')
			));
	}
}

// Template output
if ( !function_exists( 'charity_is_hope_template_form_2_output' ) ) {
	function charity_is_hope_template_form_2_output($post_options, $post_data) {

		$form_style = 'default';
		$address_1 = charity_is_hope_get_theme_option('contact_address_1');
		$address_2 = charity_is_hope_get_theme_option('contact_address_2');
		$phone = charity_is_hope_get_theme_option('contact_phone');
		$email = charity_is_hope_get_theme_option('contact_email');
		$open_hours = charity_is_hope_get_theme_option('contact_open_hours');

        static $cnt = 0;
        $cnt++;
        $privacy = charity_is_hope_get_privacy_text();
		
		?><div class="sc_columns columns_wrap"><?php

			// Form info
			?><div class="sc_form_address column-2_5">
				<h4 class="info_title"><?php esc_html_e('Contact Info', 'charity-is-hope'); ?></h4>
				<div class="sc_form_address_field">
					<span class="sc_form_address_label"><?php esc_html_e('Address:', 'charity-is-hope'); ?></span>
					<span class="sc_form_address_data">
						<?php
						charity_is_hope_show_layout($address_1);
						if (!empty($address_1) && !empty($address_2)) { esc_html_e(', ', 'charity-is-hope'); }
						charity_is_hope_show_layout($address_2);
						?>
					</span>
				</div>
				<div class="sc_form_address_field">
					<span class="sc_form_address_label"><?php esc_html_e('We Are Open:', 'charity-is-hope'); ?></span>
					<span class="sc_form_address_data"><?php charity_is_hope_show_layout($open_hours); ?></span>
				</div>
				<div class="sc_form_address_field">
					<span class="sc_form_address_label"><?php esc_html_e('Call:', 'charity-is-hope'); ?></span>
					<span class="sc_form_address_data"><a href="tel:<?php charity_is_hope_show_layout($phone) ?>"><?php charity_is_hope_show_layout($phone); ?></a></span>
				</div>
				<div class="sc_form_address_field">
					<span class="sc_form_address_label"><?php esc_html_e('Email:', 'charity-is-hope'); ?></span>
					<span class="sc_form_address_data"><a href="mailto:<?php charity_is_hope_show_layout($email) ?>"><?php charity_is_hope_show_layout($email); ?></a></span>
				</div>

				<?php
				if(!empty($post_options['description'])){
					echo '<h4 class="info_title_des">'.esc_html__('Information', 'charity-is-hope').'</h4>';
					echo '<div class="sc_form_descr">' . trim(charity_is_hope_strmacros($post_options['description'])). '</div>';
				}
				?>

				<?php
	            echo '<h4 class="info_title_soc">'.esc_html__('Stay Social', 'charity-is-hope').'</h4>';
				echo do_shortcode('[trx_socials size="tiny" shape="round"][/trx_socials]'); ?>
			</div><?php

			// Form fields
			?><div class="sc_form_fields column-3_5">
				<form <?php echo !empty($post_options['id']) ? ' id="'.esc_attr($post_options['id']).'_form"' : ''; ?> 
					class="sc_input_hover_<?php echo esc_attr($form_style); ?>"
					data-formtype="<?php echo esc_attr($post_options['layout']); ?>" 
					method="post" 
					action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : admin_url('admin-ajax.php')); ?>">
					<?php if (function_exists('charity_is_hope_sc_form_show_fields')) charity_is_hope_sc_form_show_fields($post_options['fields']); ?>
					<div class="sc_form_info">
						<div class="sc_form_item sc_form_field label_over"><input id="sc_form_username" type="text" name="username"<?php if ($form_style=='default') echo ' placeholder="'.esc_attr__('Name *', 'charity-is-hope').'"'; ?> aria-required="true"><?php
							if ($form_style!='default') { 
								?><label class="required" for="sc_form_username"><?php
									if ($form_style == 'path') {
										?><svg class="sc_form_graphic" preserveAspectRatio="none" viewBox="0 0 404 77" height="100%" width="100%"><path d="m0,0l404,0l0,77l-404,0l0,-77z"></svg><?php
									} else if ($form_style == 'iconed') {
										?><i class="sc_form_label_icon icon-user"></i><?php
									}
									?><span class="sc_form_label_content" data-content="<?php esc_html_e('Name', 'charity-is-hope'); ?>"><?php esc_html_e('Name', 'charity-is-hope'); ?></span><?php
								?></label><?php
							}
						?></div>
						<div class="sc_form_item sc_form_field label_over"><input id="sc_form_email" type="text" name="email"<?php if ($form_style=='default') echo ' placeholder="'.esc_attr__('E-mail *', 'charity-is-hope').'"'; ?> aria-required="true"><?php
							if ($form_style!='default') { 
								?><label class="required" for="sc_form_email"><?php
									if ($form_style == 'path') {
										?><svg class="sc_form_graphic" preserveAspectRatio="none" viewBox="0 0 404 77" height="100%" width="100%"><path d="m0,0l404,0l0,77l-404,0l0,-77z"></svg><?php
									} else if ($form_style == 'iconed') {
										?><i class="sc_form_label_icon icon-mail-empty"></i><?php
									}
									?><span class="sc_form_label_content" data-content="<?php esc_html_e('E-mail', 'charity-is-hope'); ?>"><?php esc_html_e('E-mail', 'charity-is-hope'); ?></span><?php
								?></label><?php
							}
						?></div>
						<div class="sc_form_item sc_form_field label_over"><input id="sc_form_subj" type="text" name="subject"<?php if ($form_style=='default') echo ' placeholder="'.esc_attr__('Subject', 'charity-is-hope').'"'; ?> aria-required="true"><?php
							if ($form_style!='default') { 
								?><label class="required" for="sc_form_subj"><?php
									if ($form_style == 'path') {
										?><svg class="sc_form_graphic" preserveAspectRatio="none" viewBox="0 0 404 77" height="100%" width="100%"><path d="m0,0l404,0l0,77l-404,0l0,-77z"></svg><?php
									} else if ($form_style == 'iconed') {
										?><i class="sc_form_label_icon icon-menu"></i><?php
									}
									?><span class="sc_form_label_content" data-content="<?php esc_html_e('Subject', 'charity-is-hope'); ?>"><?php esc_html_e('Subject', 'charity-is-hope'); ?></span><?php
								?></label><?php
							}
						?></div>
					</div>
					<div class="sc_form_item sc_form_message"><textarea id="sc_form_message" name="message"<?php if ($form_style=='default') echo ' placeholder="'.esc_attr__('Message', 'charity-is-hope').'"'; ?> aria-required="true"></textarea><?php
						if ($form_style!='default') { 
							?><label class="required" for="sc_form_message"><?php 
								if ($form_style == 'path') {
									?><svg class="sc_form_graphic" preserveAspectRatio="none" viewBox="0 0 404 77" height="100%" width="100%"><path d="m0,0l404,0l0,77l-404,0l0,-77z"></svg><?php
								} else if ($form_style == 'iconed') {
									?><i class="sc_form_label_icon icon-feather"></i><?php
								}
								?><span class="sc_form_label_content" data-content="<?php esc_html_e('Message', 'charity-is-hope'); ?>"><?php esc_html_e('Message', 'charity-is-hope'); ?></span><?php
							?></label><?php
						}
					?></div>
                    <?php
                    if (!empty($privacy)) {
                        ?><div class="sc_form_field sc_form_field_checkbox"><?php
                        ?><input type="checkbox" id="i_agree_privacy_policy_sc_form_<?php echo esc_attr($cnt); ?>" name="i_agree_privacy_policy" class="sc_form_privacy_checkbox" value="1">
                        <label for="i_agree_privacy_policy_sc_form_<?php echo esc_attr($cnt); ?>"><?php charity_is_hope_show_layout($privacy); ?></label>
                        </div><?php
                    }
                    ?>
					<div class="sc_form_item sc_form_button"><button <?php
                        if (!empty($privacy)) echo ' disabled="disabled"'
                        ?>><?php esc_html_e('Send Message', 'charity-is-hope'); ?></button></div>
					<div class="result sc_infobox"></div>
				</form>
			</div>
		</div>
		<?php
	}
}
?>