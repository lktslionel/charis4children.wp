<?php
/**
 * The template for displaying donation's content on the archive page
 *
 * @package Charity Is Hope Donations
 * @since Charity Is Hope Donations 1.0
 */

$plugin = TRX_DONATIONS::get_instance();
$column_class = isset($columns) && $columns > 1 
	? str_replace( array('$1', '$2'), array('1', $columns), $plugin->get_option('column_class')!='' ? esc_attr($plugin->get_option('column_class')) : 'sc_donations_column-$1_$2' )
	: '';



if (!empty($in_shortcode)) {
	?><div id="post-<?php the_ID(); ?>" class="post_item_<?php echo esc_attr($plugin->get_option('blog_style')); ?> post_type_<?php echo esc_attr(get_post_type()).' '.esc_attr($column_class); ?>"><?php
} else {
	?><article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_'.esc_attr($plugin->get_option('blog_style')).' post_type_'.esc_attr(get_post_type()).' '.esc_attr($column_class) ); ?>><?php
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

		<div class="post_header entry-header">
			<?php
			$tag = 'h' . (isset($columns) && $columns > 1 ? 4 : 2);
			the_title( sprintf( '<%s class="entry-title"><a href="%s" rel="bookmark">', esc_attr($tag), esc_url(get_permalink()) ), '</a></'.esc_attr($tag).'>' ); ?>
		</div><!-- .entry-header -->

		<div class="post_content entry-content">
			<?php
			global $post;
			$show_learn_more = true;
			if (!empty($post->post_excerpt)) {
				the_excerpt();
			} else if (strpos($post->post_content, '<!--more')!==false) {
				the_content( esc_html__( 'Learn more', 'charity-is-hope' ) );
				$show_learn_more = false;
			} else {
				the_excerpt();
			}
			?>

			<div class="post_info_donations">
				<?php
				// Goal and raised
				$goal = get_post_meta( get_the_ID(), 'trx_donations_goal', true );
				if (!empty($goal)) {
					$raised = get_post_meta( get_the_ID(), 'trx_donations_raised', true );
					if (empty($raised)) $raised = 0;
					$manual = get_post_meta( get_the_ID(), 'trx_donations_manual', true );
					?>
				<div class="top">
					<span class="post_info_item post_raised">
						<span class="post_counters_label"><?php esc_html_e('Raised', 'charity-is-hope'); ?></span>
					</span>
					<span class="post_info_item post_goal">
						<span class="post_counters_label"><?php esc_html_e('Goal', 'charity-is-hope'); ?></span>
					</span>
				</div>
				<div class="middle">
					<span <?php echo 'style="width:'.round(($raised+$manual)*100/$goal, 2).'%;"'; ?>></span>
				</div>
				<div class="bottom">
					<span class="post_counters_number_raised"><?php charity_is_hope_show_layout($plugin->get_money($raised+$manual)); ?></span>
					<span class="post_counters_number_goal"><?php charity_is_hope_show_layout($plugin->get_money($goal)); ?></span>
				</div>
				<?php
					}
				?>
			</div>

			<?php
			if ( $show_learn_more ) {
				?><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Donate', 'charity-is-hope'); ?></a><?php
			}
			?>
		</div><!-- .entry-content -->

	</div><!-- .post_body -->

<?php
if (empty($in_shortcode)) {
	?></article><?php
} else {
	?></div><?php
}
?>