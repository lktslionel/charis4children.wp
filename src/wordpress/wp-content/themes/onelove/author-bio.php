<div class="author-info cata-has-animation cata-fadeInUp">
	<div class="author-avatar">
		<?php
		$author_bio_avatar_size = apply_filters( CATANIS_THEMENAME. '_author_bio_avatar_size', 120 );
		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
		?>
	</div>

	<div class="author-description">
		<h3 class="author-title"><?php echo get_the_author(); ?></h3>
		<p><?php the_author_meta( 'position' ); ?></p>
		<div class="author-bio">
			<?php the_author_meta( 'description' ); ?>
		</div>
		
		<ul class="author-socials">
			<?php 
			$arr_socials = array(
				'facebook' => trim(get_the_author_meta('facebook')),
				'twitter' => trim(get_the_author_meta('twitter')),
				'google-plus' => trim(get_the_author_meta('googleplus')),
				'behance' => trim(get_the_author_meta('behance')),
				'linkedin' => trim(get_the_author_meta('linkedin')),
				'instagram' => trim(get_the_author_meta('instagram')),
				'website' => trim(get_the_author_meta('url'))
			);
			if(count($arr_socials) > 0){
				foreach ($arr_socials as $key => $link){
					if(!empty($link)){
						$title = ucwords(str_replace('-', ' ', $key) );
						$key = ($key== 'website') ? 'desktop' : $key ;
						echo '<li class="'.$key.'" data-toggle="tooltip" data-placement="top" data-original-title="'. $title .'">
								<a href="'. esc_url($link) .'" title="'. $title .'" target="_blank">
								<i class="fa fa-'.$key.'"></i></a>
							</li>';
					}
				}
			}
			?>
		</ul>
	</div>
</div>
