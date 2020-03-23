<?php
/**
 * The template for displaying single donation's content
 *
 * @package Charity Is Hope Donations
 * @since Charity Is Hope Donations 1.0
 */

$plugin = TRX_DONATIONS::get_instance();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) ); ?>>

	<div class="post_sidebar">
		<?php
		// Post thumbnail
		if ( has_post_thumbnail() ) {
			?>
			<div class="post_featured">
				<?php the_post_thumbnail( 'thumb_med', array( 'alt' => get_the_title() ) ); ?>
			</div><!-- .post_featured -->
			<?php
		}

		// Post meta
		$goal = get_post_meta( get_the_ID(), 'trx_donations_goal', true );
		$raised = get_post_meta( get_the_ID(), 'trx_donations_raised', true );
		if (empty($raised)) $raised = 0;
		$manual = get_post_meta( get_the_ID(), 'trx_donations_manual', true );
		$supporters = get_post_meta( get_the_ID(), 'trx_donations_supporters', true );
		?>

		<div class="post_info_donations">
			<div class="post_raised">
				<span class="post_raised_title"><?php esc_html_e('Raised', 'charity-is-hope'); ?></span><span class="post_raised_amount"><?php charity_is_hope_show_layout($plugin->get_money($raised+$manual)); ?></span>
			</div>
			<div class="middle">
				<span <?php echo 'style="width:'.round(($raised+$manual)*100/$goal, 2).'%;"'; ?>></span>
			</div>
			<div class="post_goal">
				<span class="post_goal_title"><?php esc_html_e('Goal', 'charity-is-hope'); ?></span><span class="post_goal_amount"><?php charity_is_hope_show_layout($plugin->get_money($goal)); ?></span>
			</div>
		</div>


		<?php
		if (isset($_REQUEST['trx_donations_pp_answer']) && substr($_REQUEST['trx_donations_pp_answer'], 0, 7)=='success'
				&& !empty($_POST['payment_status']) && $_POST['payment_status']=='Completed' && !empty($_POST['item_number']) && (int) $_POST['item_number'] == get_the_ID()) {
			?><div class="post_thanks"><?php esc_html_e('Thank you', 'charity-is-hope'); ?></div><?php
		} else {
			?><div class="post_help"><?php esc_html_e('Help us attain our goal', 'charity-is-hope'); ?></div><?php
		}
		?>

		<div class="post_supporters">
	
			<h5 class="post_supporters_title"><?php esc_html_e('Group\'s supporters to date', 'charity-is-hope'); ?></h5>
			<?php
			if (is_array($supporters) && count($supporters) > 0) {
				$i = 0;
				$max = max(0, (int) $plugin->get_option('max_supporters_to_show'));
				?><ol><?php
				foreach ($supporters as $v) {
					if ( (int) $v['show_in_rating'] == 0) continue;
					$i++;
					if ($i > $max) break;
					?><li class="post_supporters_item"><span class="post_supporters_name"><?php echo esc_html($v['name']); ?></span><span class="post_supporters_amount"><?php echo esc_html($plugin->get_money($v['amount']));  ?></span><?php 
						if ($v['site']) { 
							?><a href="<?php echo esc_url($v['site']); ?>" class="post_supporters_site" title="<?php esc_attr_e("Go to the supporter's site", 'charity-is-hope'); ?>"><?php charity_is_hope_show_layout($v['site']); ?></a><?php
						}
						if (!empty($v['message'])) {
							?><div class="post_supporters_message"><?php charity_is_hope_show_layout($v['message']); ?></div><?php
						}
					?></li><?php
				}
				?>
				</ol>
				<div class="post_supporters_count"><?php printf(esc_html__('Supporters number: %s', 'charity-is-hope'), !empty($supporters) ? count($supporters) : 0); ?></div>
			<?php } else { ?>
				<div class="post_supporters_count"><?php esc_html_e('No supporters yet', 'charity-is-hope'); ?></div>
			<?php } ?>
		</div>
	</div>

	<div class="post_body">
		<div class="post_header entry-header">
			<?php the_title( '<h1 class="post_title entry-title">', '</h1>' ); ?>
			<div class="post_info">
				<span class="post_info_item post_date"><?php echo get_the_date(); ?></span>
			</div>
		</div><!-- .entry-header -->
	
	
		<div class="post_content entry-content">
			<?php
				the_content( );
	
				wp_link_pages( array(
					'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'charity-is-hope' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'charity-is-hope' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				) );
			?>
		</div><!-- .entry-content -->
	
		<div class="post_footer entry-footer">
			<?php $plugin->show_share_links(); ?>
		</div><!-- .entry-footer -->

	</div><!-- .post_body -->


</article>
