<?php
/**
 * The template for displaying donation's content on the archive page
 *
 * @package ThemeREX Donations
 * @since ThemeREX Donations 1.0
 */
$form_id = get_the_ID();
$form    = new Give_Donate_Form( $form_id );

/**
 * Filter the give currency.
 *
 * @since 1.8.17
 */
$form_currency = apply_filters( 'give_goal_form_currency', give_get_currency( $form_id ), $form_id );
/**
 * Filter the form income
 *
 * @since 1.8.8
 */
$income = apply_filters( 'give_goal_amount_raised_output', $form->get_earnings(), $form_id, $form );

/**
 * Filter the form
 *
 * @since 1.8.8
 */
$goal = apply_filters( 'give_goal_amount_target_output', $form->goal, $form_id, $form );
/**
 * Filter the income formatting arguments.
 *
 * @since 1.8.17
 */
$income_format_args = apply_filters( 'give_goal_income_format_args', array( 'sanitize' => false, 'currency' => $form_currency, 'decimal' => false ), $form_id );
/**
 * Filter the goal formatting arguments.
 *
 * @since 1.8.17
 */
$goal_format_args   = apply_filters( 'give_goal_amount_format_args', array( 'sanitize' => false, 'currency' => $form_currency, 'decimal' => false ), $form_id );


$income = give_human_format_large_amount( give_format_amount( $income, $income_format_args ), array( 'currency' => $form_currency ) );
$goal   = give_human_format_large_amount( give_format_amount( $goal, $goal_format_args ), array( 'currency' => $form_currency ) );

$blog_style =  isset($style) ? 'sc_donations_style_' . $style : '';
$column_class = isset($columns) && $columns > 1
	? str_replace( array('$1', '$2'), array('1', $columns),  'column-$1_$2' )
	: '';

if (!empty($in_shortcode)) {
	?><div id="post-<?php echo esc_attr($form_id); ?>" class="post_item_<?php echo esc_attr($blog_style); ?> post_type_<?php echo esc_attr(get_post_type()).' '.esc_attr($column_class); ?>"><?php
} else {
	?><article id="post-<?php echo esc_attr($form_id); ?>" <?php post_class( 'post_item_'.esc_attr($blog_style).' post_type_'.esc_attr(get_post_type()).' '.esc_attr($column_class) ); ?>><?php
}
	// Post thumbnail
	if ( has_post_thumbnail() ) {
		?>
		<div class="post_featured">
			<?php the_post_thumbnail( 'thumb_med', array( 'alt' => get_the_title() ) ); ?>
		</div><!-- .post_featured -->
		<?php
	}
	?>
	<div class="post_body">
		<div class="post_info">
			<span class="post_info_item post_goal">
				<span class="post_counters_label"><?php esc_html_e('Group goal:', 'charity-is-hope'); ?></span>&nbsp;
				<span class="post_counters_number"><?php charity_is_hope_show_layout($goal)?></span>
			</span>
			<span class="post_info_item post_raised">
				<span class="post_counters_label"><?php esc_html_e('Raised:', 'charity-is-hope'); ?></span>&nbsp;
				<span class="post_counters_number"><?php charity_is_hope_show_layout($income)?></span>
			</span>
		</div>
		<div class="post_header entry-header">
			<?php
			$tag = 'h' . (isset($columns) && $columns > 1 ? 4 : 2);
			the_title( sprintf( '<%s class="entry-title"><a href="%s" rel="bookmark">', esc_attr($tag), esc_url(get_permalink()) ), '</a></'.esc_attr($tag).'>' );
			?>
		</div><!-- .entry-header -->
		<div class="post_content entry-content">
			<?php
			global $post;
			if (!empty($post->post_excerpt)) {
				the_excerpt();
			} else {
				$content = wpautop( give_get_meta( $form_id, '_give_form_content', true ) );
				if ( give_is_setting_enabled( give_get_option( 'the_content_filter' ) ) ) {
					$content = apply_filters( 'the_content', $content );
				}
				?><div class="give-form-content-wrap"><?php charity_is_hope_show_layout($content);?></div><!-- .entry-content --><?php
			}
			?>
			<a class="more-link theme_button" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Donate', 'charity-is-hope'); ?></a>
		</div><!-- .entry-content -->

	</div><!-- .post_body -->

<?php
if (empty($in_shortcode)) {
	?></article><?php
} else {
	?></div><?php
}
?>