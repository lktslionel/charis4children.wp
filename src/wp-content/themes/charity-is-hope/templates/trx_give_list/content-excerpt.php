<?php
/**
 * The template for displaying donation's content on the archive page
 *
 * @package ThemeREX Donations
 * @since ThemeREX Donations 1.0
 */


$blog_style =  isset($style) ? 'sc_donations_style_' . $style : '';
$column_class = isset($columns) && $columns > 1 
	? str_replace( array('$1', '$2'), array('1', $columns),  'column-$1_$2' )
	: '';

if (!empty($in_shortcode)) {
	?><div id="post-<?php the_ID(); ?>" class="post_item_<?php echo esc_attr($blog_style); ?> post_type_<?php echo esc_attr(get_post_type()).' '.esc_attr($column_class); ?>"><?php
} else {
	?><article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_'.esc_attr($blog_style).' post_type_'.esc_attr(get_post_type()).' '.esc_attr($column_class) ); ?>><?php
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
			the_title( sprintf( '<%s class="entry-title"><a href="%s" rel="bookmark">', esc_attr($tag), esc_url(get_permalink()) ), '</a></'.esc_attr($tag).'>' );
			?>
		</div><!-- .entry-header -->
		<div class="post_content entry-content">
		<?php
		global $post;
		if (!empty($post->post_excerpt)) {
			the_excerpt();
		} else {
			$content = wpautop( give_get_meta( get_the_ID(), '_give_form_content', true ) );
			if ( give_is_setting_enabled( give_get_option( 'the_content_filter' ) ) ) {
				$content = apply_filters( 'the_content', $content );
			}
			?><div class="give-form-content-wrap"><?php charity_is_hope_show_layout($content);?></div><!-- .entry-content --><?php
		}
		?><p>
		<div class="post_info">
			<?php if (function_exists('give_show_goal_progress')) give_show_goal_progress(get_the_ID(), array()); ?>
		</div>
		<a class="more-link theme_button" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Donate', 'charity-is-hope'); ?></a></p>
		</div><!-- .entry-content -->

	</div><!-- .post_body -->

<?php
if (empty($in_shortcode)) {
	?></article><?php
} else {
	?></div><?php
}
?>