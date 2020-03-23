<article <?php post_class( 'post_item_single post_item_404 post_item_none_archive' ); ?>>
	<div class="post_content">
		<h1 class="page_title page-title"><?php esc_html_e( 'No results', 'charity-is-hope' ); ?></h1>
		<h2 class="page_subtitle"><?php esc_html_e("We're sorry, but your query did not match", 'charity-is-hope'); ?></h2>
		<p class="page_description"><?php echo sprintf( wp_kses_post( __('Can\'t find what you need? Take a moment and do a search or start from <a href="%s">our homepage</a>.', 'charity-is-hope')), home_url() ); ?></p>
	</div>
</article>
