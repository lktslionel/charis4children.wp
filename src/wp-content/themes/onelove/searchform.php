<?php $rand_id = catanis_random_string(10); ?>	
<form method="get" id="searchform_<?php echo esc_attr($rand_id); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
	<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s-<?php echo esc_attr($rand_id); ?>" class="search-input" required="required" placeholder="<?php esc_attr_e( 'Start Typing...', 'onelove' ); ?>" data-placeholder="<?php esc_attr_e( 'Start Typing...', 'onelove' ); ?>" autocomplete="off"/>
	<input type="submit" id="search-<?php echo esc_attr($rand_id); ?>" value="<?php esc_html_e('Search', 'onelove'); ?>" />
	<button type="submit" id="search-<?php echo esc_attr($rand_id); ?>" class="fa fa-search search-submit"></button>
</form>

