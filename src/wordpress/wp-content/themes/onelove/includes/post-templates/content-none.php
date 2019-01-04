<?php 
$msg = esc_html__( 'Nothing found!', 'onelove' );
if( is_tax('testimonials_category')){
	$msg = esc_html__( 'Do not support this archive.', 'onelove' );
}
?>

<div class="not-found">
	<h1><?php echo esc_html($msg); ?></h1>
</div>