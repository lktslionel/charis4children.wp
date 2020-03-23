<?php
/**
 * Theme sprecific functions and definitions
 */

/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'charity_is_hope_theme_setup' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_theme_setup', 1 );
	function charity_is_hope_theme_setup() {

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails
        add_theme_support( 'post-thumbnails' );

        // Custom header setup
        add_theme_support( 'custom-header', array('header-text'=>false));

        // Custom backgrounds setup
        add_theme_support( 'custom-background');

        // Supported posts formats
        add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') );

        // Autogenerate title tag
        add_theme_support('title-tag');

        // Add user menu
        add_theme_support('nav-menus');

        // WooCommerce Support
        add_theme_support( 'woocommerce' );

        // Add wide and full blocks support
        add_theme_support( 'align-wide' );

		// Register theme menus
		add_filter( 'charity_is_hope_filter_add_theme_menus',		'charity_is_hope_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'charity_is_hope_filter_add_theme_sidebars',	'charity_is_hope_add_theme_sidebars' );

		// Add theme required plugins
		add_filter( 'charity_is_hope_filter_required_plugins',		'charity_is_hope_add_required_plugins' );
		
		// Add preloader styles
		add_filter('charity_is_hope_filter_add_styles_inline',		'charity_is_hope_head_add_page_preloader_styles');

		// Init theme after WP is created
		add_action( 'wp',									'charity_is_hope_core_init_theme' );

		// Add theme specified classes into the body
		add_filter( 'body_class', 							'charity_is_hope_body_classes' );

		// Add data to the head and to the beginning of the body
		add_action('wp_head',								'charity_is_hope_head_add_page_meta', 1);
		add_action('before',								'charity_is_hope_body_add_gtm');
		add_action('before',								'charity_is_hope_body_add_toc');
		add_action('before',								'charity_is_hope_body_add_page_preloader');

		// Add data to the footer (priority 1, because priority 2 used for localize scripts)
		add_action('wp_footer',								'charity_is_hope_footer_add_views_counter', 1);
		add_action('wp_footer',								'charity_is_hope_footer_add_theme_customizer', 1);
		add_action('wp_footer',								'charity_is_hope_footer_add_scroll_to_top', 1);
		add_action('wp_footer',								'charity_is_hope_footer_add_custom_html', 1);
		add_action('wp_footer',								'charity_is_hope_footer_add_gtm2', 1);

        // Gutenberg support
        add_theme_support( 'align-wide' );

		// Set list of the theme required plugins
		charity_is_hope_storage_set('required_plugins', array(
			'calcfields',
			'essgrids',
			'learndash',
			'responsive_poll',
			'revslider',
			'tribe_events',
			'give',
			'trx_utils',
			'visual_composer',
			'woocommerce',
			'mailchimp',
            'gdpr-framework',
            'contact_form_7'
			)
		);

		// Set list of the theme required custom fonts from folder /css/font-faces
		// Attention! Font's folder must have name equal to the font's name
		charity_is_hope_storage_set('required_custom_fonts', array(
			'Amadeus', 'WCManoNegraBta'
			)
		);


		if ( is_dir(CHARITY_IS_HOPE_THEME_PATH . 'demo/') ) {
		charity_is_hope_storage_set('demo_data_url',  CHARITY_IS_HOPE_THEME_PATH . 'demo/');
		} else {
			charity_is_hope_storage_set('demo_data_url',  esc_url(charity_is_hope_get_protocol().'://demofiles.themerex.net/charity-is-hope/') ); // Demo-site domain
		}

	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'charity_is_hope_add_theme_menus' ) ) {
	//Handler of add_filter( 'charity_is_hope_filter_add_theme_menus', 'charity_is_hope_add_theme_menus' );
	function charity_is_hope_add_theme_menus($menus) {
		//For example:
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'charity_is_hope_add_theme_sidebars' ) ) {
	//Handler of add_filter( 'charity_is_hope_filter_add_theme_sidebars',	'charity_is_hope_add_theme_sidebars' );
	function charity_is_hope_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'charity-is-hope' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'charity-is-hope' )
			);
			if (function_exists('charity_is_hope_exists_woocommerce') && charity_is_hope_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'charity-is-hope' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Add theme required plugins
if ( !function_exists( 'charity_is_hope_add_required_plugins' ) ) {
	//Handler of add_filter( 'charity_is_hope_filter_required_plugins',		'charity_is_hope_add_required_plugins' );
	function charity_is_hope_add_required_plugins($plugins) {
		$plugins[] = array(
			'name' 		=> esc_html__('ThemeREX Utilities', 'charity-is-hope'),
			'version'	=> '3.3.1',					// Minimal required version
			'slug' 		=> 'trx_utils',
			'source'	=> charity_is_hope_get_file_dir('plugins/install/trx_utils.zip'),
			'required' 	=> true
		);
		return $plugins;
	}
}

//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'charity_is_hope_importer_set_options' ) ) {
	add_filter( 'trx_utils_filter_importer_options', 'charity_is_hope_importer_set_options', 9 );
	function charity_is_hope_importer_set_options( $options=array() ) {
		if ( is_array( $options ) ) {

			$rtl_slug = is_rtl() ? '-rtl' : '';
			$rtl_subdomen = is_rtl() ? 'rtl.' : '';

			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			if ( is_dir( CHARITY_IS_HOPE_THEME_PATH . 'demo' . $rtl_slug . '/' ) ) {
				$options['demo_url'] = CHARITY_IS_HOPE_THEME_PATH . 'demo' . $rtl_slug . '/';
			} else {
				$options['demo_url'] = esc_url( charity_is_hope_get_protocol().'://demofiles.themerex.net/charity-is-hope' . $rtl_slug . '/' ); // Demo-site domain
			}

			// Required plugins
			$options['required_plugins'] =  array(
				'essential-grid',
				'revslider',
				'the-events-calendar',
				'give',
				'js_composer',
				'woocommerce',
				'mailchimp-for-wp',
                'contact-form-7'
			);

			$options['theme_slug'] = 'charity_is_hope';

			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__( 'Charity is hope Demo', 'charity-is-hope' );
			$options['files']['default']['domain_dev'] = esc_url(charity_is_hope_get_protocol().'://' . $rtl_subdomen . 'charity-is-hope.themerex.net'); // Developers domain
			$options['files']['default']['domain_demo']= esc_url(charity_is_hope_get_protocol().'://' . $rtl_subdomen . 'charity-is-hope.themerex.net');		// Demo-site domain

		}
		return $options;
	}
}

// Add data to the head and to the beginning of the body
//------------------------------------------------------------------------

// Add theme specified classes to the body tag
if ( !function_exists('charity_is_hope_body_classes') ) {
	//Handler of add_filter( 'body_class', 'charity_is_hope_body_classes' );
	function charity_is_hope_body_classes( $classes ) {

		$classes[] = 'charity_is_hope_body';
		$classes[] = 'body_style_' . trim(charity_is_hope_get_custom_option('body_style'));
		$classes[] = 'top_style_' . trim(charity_is_hope_get_custom_option('top_panel_style'));
		$classes[] = 'body_' . (charity_is_hope_get_custom_option('body_filled')=='yes' ? 'filled' : 'transparent');
		$classes[] = 'article_style_' . trim(charity_is_hope_get_custom_option('article_style'));
		
		$blog_style = charity_is_hope_get_custom_option(is_singular() && !charity_is_hope_storage_get('blog_streampage') ? 'single_style' : 'blog_style');
		$classes[] = 'layout_' . trim($blog_style);
		$classes[] = 'template_' . trim(charity_is_hope_get_template_name($blog_style));
		
		$body_scheme = charity_is_hope_get_custom_option('body_scheme');
		if (empty($body_scheme)  || charity_is_hope_is_inherit_option($body_scheme)) $body_scheme = 'original';
		$classes[] = 'scheme_' . $body_scheme;

		$top_panel_position = charity_is_hope_get_custom_option('top_panel_position');
		if (!charity_is_hope_param_is_off($top_panel_position)) {
			$classes[] = 'top_panel_show';
			$classes[] = 'top_panel_' . trim($top_panel_position);
		} else 
			$classes[] = 'top_panel_hide';
		$classes[] = charity_is_hope_get_sidebar_class();

		if (charity_is_hope_get_custom_option('show_video_bg')=='yes' && (charity_is_hope_get_custom_option('video_bg_youtube_code')!='' || charity_is_hope_get_custom_option('video_bg_url')!=''))
			$classes[] = 'video_bg_show';

		if (!charity_is_hope_param_is_off(charity_is_hope_get_theme_option('page_preloader')))
			$classes[] = 'preloader';

		return $classes;
	}
}


// Add page meta to the head
if (!function_exists('charity_is_hope_head_add_page_meta')) {
	//Handler of add_action('wp_head', 'charity_is_hope_head_add_page_meta', 1);
	function charity_is_hope_head_add_page_meta() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1<?php if (charity_is_hope_get_theme_option('responsive_layouts')=='yes') echo ', maximum-scale=1'; ?>">
		<meta name="format-detection" content="telephone=no">
	
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php
	}
}

// Add page preloader styles to the head
if (!function_exists('charity_is_hope_head_add_page_preloader_styles')) {
	//Handler of add_filter('charity_is_hope_filter_add_styles_inline', 'charity_is_hope_head_add_page_preloader_styles');
	function charity_is_hope_head_add_page_preloader_styles($css) {
		if (($preloader=charity_is_hope_get_theme_option('page_preloader'))!='none') {
			$image = charity_is_hope_get_theme_option('page_preloader_image');
			$bg_clr = charity_is_hope_get_scheme_color('bg_color');
			$link_clr = charity_is_hope_get_scheme_color('text_link');
			$css .= '
				#page_preloader {
					background-color: '. esc_attr($bg_clr) . ';'
					. ($preloader=='custom' && $image
						? 'background-image:url('.esc_url($image).');'
						: ''
						)
				    . '
				}
				.preloader_wrap > div {
					background-color: '.esc_attr($link_clr).';
				}';
		}
		return $css;
	}
}

// Add gtm code to the beginning of the body 
if (!function_exists('charity_is_hope_body_add_gtm')) {
	//Handler of add_action('before', 'charity_is_hope_body_add_gtm');
	function charity_is_hope_body_add_gtm() {
		charity_is_hope_show_layout(charity_is_hope_get_custom_option('gtm_code'));
	}
}

// Add TOC anchors to the beginning of the body 
if (!function_exists('charity_is_hope_body_add_toc')) {
	//Handler of add_action('before', 'charity_is_hope_body_add_toc');
	function charity_is_hope_body_add_toc() {
		// Add TOC items 'Home' and "To top"
		if (charity_is_hope_get_custom_option('menu_toc_home')=='yes' && function_exists('charity_is_hope_sc_anchor'))
			charity_is_hope_show_layout(charity_is_hope_sc_anchor(array(
				'id' => "toc_home",
				'title' => esc_html__('Home', 'charity-is-hope'),
				'description' => esc_html__('{{Return to Home}} - ||navigate to home page of the site', 'charity-is-hope'),
				'icon' => "icon-home",
				'separator' => "yes",
				'url' => esc_url(home_url('/'))
				)
			)); 
		if (charity_is_hope_get_custom_option('menu_toc_top')=='yes' && function_exists('charity_is_hope_sc_anchor'))
			charity_is_hope_show_layout(charity_is_hope_sc_anchor(array(
				'id' => "toc_top",
				'title' => esc_html__('To Top', 'charity-is-hope'),
				'description' => esc_html__('{{Back to top}} - ||scroll to top of the page', 'charity-is-hope'),
				'icon' => "icon-double-up",
				'separator' => "yes")
				)); 
	}
}

// Add page preloader to the beginning of the body
if (!function_exists('charity_is_hope_body_add_page_preloader')) {
	//Handler of add_action('before', 'charity_is_hope_body_add_page_preloader');
	function charity_is_hope_body_add_page_preloader() {
		if ( ($preloader=charity_is_hope_get_theme_option('page_preloader')) != 'none' && ( $preloader != 'custom' || ($image=charity_is_hope_get_theme_option('page_preloader_image')) != '')) {
			?><div id="page_preloader"><?php
				if ($preloader == 'circle') {
					?><div class="preloader_wrap preloader_<?php echo esc_attr($preloader); ?>"><div class="preloader_circ1"></div><div class="preloader_circ2"></div><div class="preloader_circ3"></div><div class="preloader_circ4"></div></div><?php
				} else if ($preloader == 'square') {
					?><div class="preloader_wrap preloader_<?php echo esc_attr($preloader); ?>"><div class="preloader_square1"></div><div class="preloader_square2"></div></div><?php
				}
			?></div><?php
		}
	}
}

// Add theme required plugins
if ( !function_exists( 'charity_is_hope_add_trx_utils' ) ) {
    add_filter( 'trx_utils_active', 'charity_is_hope_add_trx_utils' );
    function charity_is_hope_add_trx_utils($enable=true) {
        return true;
    }
}

// Return text for the "I agree ..." checkbox
if ( ! function_exists( 'charity_is_hope_trx_utils_privacy_text' ) ) {
    add_filter( 'trx_utils_filter_privacy_text', 'charity_is_hope_trx_utils_privacy_text' );
    function charity_is_hope_trx_utils_privacy_text( $text='' ) {
        return charity_is_hope_get_privacy_text();
    }
}

// Add data to the footer
//------------------------------------------------------------------------

// Add post/page views counter
if (!function_exists('charity_is_hope_footer_add_views_counter')) {
	//Handler of add_action('wp_footer', 'charity_is_hope_footer_add_views_counter');
	function charity_is_hope_footer_add_views_counter() {
		// Post/Page views counter
		get_template_part(charity_is_hope_get_file_slug('templates/_parts/views-counter.php'));
	}
}

// Add theme customizer
if (!function_exists('charity_is_hope_footer_add_theme_customizer')) {
	//Handler of add_action('wp_footer', 'charity_is_hope_footer_add_theme_customizer');
	function charity_is_hope_footer_add_theme_customizer() {
		// Front customizer
		if (charity_is_hope_get_custom_option('show_theme_customizer')=='yes') {
			require_once CHARITY_IS_HOPE_FW_PATH . 'core/core.customizer/front.customizer.php';
		}
	}
}

// Add scroll to top button
if (!function_exists('charity_is_hope_footer_add_scroll_to_top')) {
	//Handler of add_action('wp_footer', 'charity_is_hope_footer_add_scroll_to_top');
	function charity_is_hope_footer_add_scroll_to_top() {
		?><a href="#" class="scroll_to_top icon-up" title="<?php esc_attr_e('Scroll to top', 'charity-is-hope'); ?>"></a><?php
	}
}

// Add custom html
if (!function_exists('charity_is_hope_footer_add_custom_html')) {
	//Handler of add_action('wp_footer', 'charity_is_hope_footer_add_custom_html');
	function charity_is_hope_footer_add_custom_html() {
		?><div class="custom_html_section"><?php
			charity_is_hope_show_layout(charity_is_hope_get_custom_option('custom_code'));
		?></div><?php
	}
}

// Add gtm code
if (!function_exists('charity_is_hope_footer_add_gtm2')) {
	//Handler of add_action('wp_footer', 'charity_is_hope_footer_add_gtm2');
	function charity_is_hope_footer_add_gtm2() {
		charity_is_hope_show_layout(charity_is_hope_get_custom_option('gtm_code2'));
	}
}



// Include framework core files
//-------------------------------------------------------------------
require_once trailingslashit( get_template_directory() ) . 'fw/loader.php';
?>