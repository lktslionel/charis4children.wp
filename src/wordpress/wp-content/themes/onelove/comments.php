<?php 
	if ( post_password_required() ) {
		return;
	}
	
	global $catanis;
	$catanis_page = $catanis->pageconfig;	
	
	$extClss = '';
	if(is_singular('post') && isset($catanis_page['show_related_post']) && !$catanis_page['show_related_post']){
		$extClss = ' cata-related-post-none';
	}
?>

<div id="cata_comments" class="cata-comments-area cata-has-animation cata-fadeInUp<?php echo esc_attr($extClss); ?>">
	<?php if ( have_comments() ) : ?>
		<h6 class="comments-title">
			<?php printf( _nx( '1 comment', '%1$s comments', get_comments_number(), 'Comment title', 'onelove' ), number_format_i18n( get_comments_number() ) ); ?>
		</h6>

		<ol class="commentlist">
			<?php wp_list_comments(array( 'callback' => 'catanis_list_comment_item', 'avatar_size' => 70 ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="comment-nav">
			<div class="comment-nav-prev"> <?php previous_comments_link( esc_html__( '&larr; Older Comments', 'onelove' ) ); ?> </div>
			<div class="comment-nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'onelove' ) ); ?></div>
		</nav> 
		<?php endif; ?>
		
		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"> <?php esc_html_e( 'Comments are closed.', 'onelove' ); ?></p>
		<?php endif; ?>
		
	<?php endif; ?>

	<?php 
	$commenter = wp_get_current_commenter();
	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	
	$comment_args = array( 
		'fields' => apply_filters(
			'comment_form_default_fields', array(
				'author' =>'<p class="comment-form-author">' . '<input id="author" placeholder="'.esc_html__( 'Your Name *', 'onelove' ).'" name="author" type="text" value="' .
						esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
				'email'  => '<p class="comment-form-email">' . '<input id="email" placeholder="'.esc_html__( 'Email Address *', 'onelove' ).'" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
						'" size="30"' . $aria_req . ' /></p>',
				'url'    => '<p class="comment-form-url">' .
						'<input id="url" name="url" placeholder="'.esc_html__( 'Website', 'onelove' ).'" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'
			)
		),
   		'comment_field' 		=> '<div class="comment-message-wrapper"><p><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="'.esc_html__( 'Comment goes here...*', 'onelove' ).'"></textarea></p></div>',
		'comment_notes_after' 	=>'',
		'title_reply_before'   => '<h6 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h6>',
		'class_submit'         => 'submit',
		'label_submit'         => esc_html__( 'Submit Now', 'onelove' ),
		'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
		'submit_field'         => '<p class="form-submit catanis-shortcode button icon-left style-dark">%1$s %2$s</p>'
	);
	comment_form($comment_args); ?>
</div>
