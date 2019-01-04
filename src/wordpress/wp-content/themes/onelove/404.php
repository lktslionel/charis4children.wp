<?php 
	$link = 'url:'. rawurlencode( esc_url(home_url('/')) ) .'||target:'.'_self';
	$large_title = catanis_option('404page_large_title');
	$small_title = catanis_option('404page_small_title');
	$bg = catanis_option('404page_bg');
	if(!empty($bg)){
		$_style = ' style="background-image:url('. esc_url($bg) .');"';
	}
?>
<?php get_header(); ?>
<div class="container-404"<?php echo trim($_style);?>>
	<article>
		<h1><?php echo esc_html($large_title); ?></h1>
		<h3><?php echo esc_html($small_title); ?></h3>
		<?php
			$btn = '[cata_button main_style="flat" button_text="'. esc_html('GO TO HOMEPAGE', 'onelove') .'"';
			$btn .= ' link="'. $link .'" shape = "square" size ="nm"';
			$btn .= ' button_color = "#282828" text_color = "#FFFFFF"';
			$btn .= ' button_color_hover = "#e49497" text_color_hover = "#FFFFFF"]';
			echo do_shortcode($btn);
		?>
	</article>
</div>
<?php get_footer(); ?>