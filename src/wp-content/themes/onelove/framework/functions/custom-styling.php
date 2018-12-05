<?php
	global $catanis;
	$catanis_optdata = $catanis->optdata;
	
	if( empty($catanis_optdata) ){
		return;
	}
?>
body{
	font-family: '<?php echo esc_attr($catanis_optdata['body_font_family']);?>', sans-serif;
	font-size: <?php echo esc_html($catanis_optdata['body_font_size']) . 'px';?>;
	line-height: <?php echo esc_html($catanis_optdata['body_font_line_height']) . 'px';?>;
	text-transform: <?php echo esc_html($catanis_optdata['body_font_text_transform']);?>;
	letter-spacing: <?php echo esc_html($catanis_optdata['body_font_letter_spacing']) . 'px'; ?>;
	font-weight: <?php echo rtrim($catanis_optdata['body_font_weight'], 'i');?>;
	<?php if( in_array($catanis_optdata['body_font_weight'], array('400i', '600i', '700i') ) ) : ?>
		font-style: italic;
	<?php endif; ?>
	color: <?php echo esc_html($catanis_optdata['content_text_color']); ?>;
	background-color: <?php echo esc_html($catanis_optdata['content_background_color']);?>;
}

a, a:focus, a:visited{color: <?php echo esc_html($catanis_optdata['content_link_regular']);?>; }
a:hover{color: <?php echo esc_html($catanis_optdata['content_link_hover']);?>; }

.cata-header.v1 .header-top{
	background-color: <?php echo esc_html($catanis_optdata['header_top_bg_color']);?>;
}

.cata-header.v1 .header-phone .iconn, .cata-header.v1 .header-email .iconn, 
.cata-header.v1 .header-address .iconn, .cata-header.v1 .cata-socials li a {
    color: <?php echo esc_html($catanis_optdata['header_top_color_icon']);?>;
}

.cata-header.v1 .header-search i, .cata-header.v1 .header-phone i, .cata-header.v1 .header-email i, 
.cata-header.v1 .header-address i, .cata-header.v1 .header-socials >span {
    color: <?php echo esc_html($catanis_optdata['header_top_color_text']);?>;
}

.cata-bg-main-color{
	background-color: <?php echo esc_html($catanis_optdata['main_color']);?>;
    border-color: <?php echo esc_html($catanis_optdata['main_color']);?>;
    color: <?php echo esc_html($catanis_optdata['main_color']);?>;
}
.cata-bg-extra-color-1{
	background-color: <?php echo esc_html($catanis_optdata['extra_color_1']);?>;
    border-color: <?php echo esc_html($catanis_optdata['extra_color_1']);?>;
    color: <?php echo esc_html($catanis_optdata['extra_color_1']);?>;
}
.cata-bg-extra-color-2{
	background-color: <?php echo esc_html($catanis_optdata['extra_color_2']);?>;
    border-color: <?php echo esc_html($catanis_optdata['extra_color_2']);?>;
    color: <?php echo esc_html($catanis_optdata['extra_color_2']);?>;
}
.cata-bg-extra-color-3{
	background-color: <?php echo esc_html($catanis_optdata['extra_color_3']);?>;
    border-color: <?php echo esc_html($catanis_optdata['extra_color_3']);?>;
    color: <?php echo esc_html($catanis_optdata['extra_color_3']);?>;
}

.catanis-main-menu > ul > li > a{
	font-family: '<?php echo esc_attr($catanis_optdata['navigation_font_family']);?>', sans-serif;
	font-size: <?php echo esc_html($catanis_optdata['navigation_font_size']) . 'px';?>;
	text-transform: <?php echo esc_html($catanis_optdata['navigation_font_text_transform']);?>;
	letter-spacing: <?php echo esc_html($catanis_optdata['navigation_font_letter_spacing']) . 'px'; ?>;
	font-weight: <?php echo rtrim($catanis_optdata['navigation_font_weight'], 'i');?>;
	<?php if( in_array($catanis_optdata['navigation_font_weight'], array('400i', '600i', '700i') ) ) : ?>
		font-style: italic;
	<?php endif; ?>
}

.catanis-main-menu ul ul li a{
	font-family: '<?php echo esc_attr($catanis_optdata['navigation_dropdown_font_family']);?>', sans-serif;
	font-size: <?php echo esc_html($catanis_optdata['navigation_dropdown_font_size']) . 'px';?>;
	line-height: <?php echo esc_html($catanis_optdata['navigation_dropdown_font_line_height']) . 'px';?>;
	text-transform: <?php echo esc_html($catanis_optdata['navigation_dropdown_font_text_transform']);?>;
	letter-spacing: <?php echo esc_html($catanis_optdata['navigation_dropdown_font_letter_spacing']) . 'px'; ?>;
	font-weight: <?php echo rtrim($catanis_optdata['navigation_dropdown_font_weight'], 'i');?>;
	<?php if( in_array($catanis_optdata['navigation_dropdown_font_weight'], array('400i', '600i', '700i') ) ) : ?>
		font-style: italic;
	<?php endif; ?>
}

.cata-page-title .page-header-wrap .pagetitle-contents .heading-title.page-title {
	font-family: '<?php echo esc_attr($catanis_optdata['page_header_font_family']);?>', sans-serif;
	font-size: <?php echo esc_html($catanis_optdata['page_header_font_size']) . 'px';?>;
	line-height: <?php echo esc_html($catanis_optdata['page_header_font_line_height']) . 'px';?>;
	text-transform: <?php echo esc_html($catanis_optdata['page_header_font_text_transform']);?>;
	letter-spacing: <?php echo esc_html($catanis_optdata['page_header_font_letter_spacing']) . 'px'; ?>;
	font-weight: <?php echo rtrim($catanis_optdata['page_header_font_weight'], 'i');?>;
	<?php if( in_array($catanis_optdata['page_header_font_weight'], array('400i', '600i', '700i') ) ) : ?>
		font-style: italic;
	<?php endif; ?>
}

.cata-page-title .page-header-wrap .pagetitle-contents .title-subtitle span, 
.cata-page-title .page-header-wrap .pagetitle-contents .title-subtitle .cata-autofade-text {
	font-family: '<?php echo esc_attr($catanis_optdata['page_header_subtitle_font_family']);?>', sans-serif;
	font-size: <?php echo esc_html($catanis_optdata['page_header_subtitle_font_size']) . 'px';?>;
	line-height: <?php echo esc_html($catanis_optdata['page_header_subtitle_font_line_height']) . 'px';?>;
	text-transform: <?php echo esc_html($catanis_optdata['page_header_subtitle_font_text_transform']);?>;
	letter-spacing: <?php echo esc_html($catanis_optdata['page_header_subtitle_font_letter_spacing']) . 'px'; ?>;
	font-weight: <?php echo rtrim($catanis_optdata['page_header_subtitle_font_weight'], 'i');?>;
	<?php if( in_array($catanis_optdata['page_header_subtitle_font_weight'], array('400i', '600i', '700i') ) ) : ?>
		font-style: italic;
	<?php endif; ?>
}

<?php /*Main Color*/ ?>
.cata-backtotop .fa{
	color: <?php echo esc_html($catanis_optdata['main_color']);?>;
}
<?php /*Main Color Light*/ ?>
.cata-timeline .cata-item .cata-timeline-content:hover,
.cata-timeline .cata-content-wrapper::before,
.cata-timeline .cata-timeline-icon,
.cata-backtotop .cata-backtotop-inner{
	background-color: <?php echo esc_html($catanis_optdata['main_color_lighter']);?>;
}

.cata-timeline-top:before, 
.cata-timeline-bottom:before,
.cata-backtotop{
	border-color: <?php echo esc_html($catanis_optdata['main_color_lighter']);?>;
}
.cata-item:nth-child(even) .cata-timeline-content:hover:after{
	border-right-color: <?php echo esc_html($catanis_optdata['main_color_lighter']);?>;
}
.cata-item:nth-child(odd) .cata-timeline-content:hover:after{
	border-left-color: <?php echo esc_html($catanis_optdata['main_color_lighter']);?>;
}


<?php /*===================================================================================
============MENU STYLE LIGHT ==============================================================*/?>
.cata-header.cata-light .header-bottom{
	background-color: <?php echo esc_html($catanis_optdata['mainmenu_light_bg_color']);?>;
	border-color: <?php echo esc_html($catanis_optdata['mainmenu_dark_border_color']);?>;
}
body.header-overlap .cata-header.cata-light .header-bottom{
	border-color: <?php echo esc_html($catanis_optdata['mainmenu_light_border_color']);?>;
}
.cata-header.cata-light.v1 .header-bottom .header-content-right:before, 
.cata-header.cata-light.v3 .header-bottom .header-content-right:before{
	border-color: <?php echo esc_html($catanis_optdata['mainmenu_light_border_color']);?>;
}
.cata-header.cata-light .header-cart .cat-woo-cart-btn p span{
	background-color: <?php echo esc_html($catanis_optdata['mainmenu_light_link_regular']);?>;
	color: <?php echo esc_html($catanis_optdata['mainmenu_light_bg_color']);?>;
}
.cata-header.v5 .header-bottom{
	border-color: <?php echo esc_html($catanis_optdata['mainmenu_dark_border_color']);?>;
}
<?php /* Color for main-menu*/ ?>
.cata-header.cata-light.v4 .social-icons-wrap .ca-social-icons li a,
.cata-header.cata-light .header-sidewidget .iconn,
.cata-header.cata-light .header-cart .cat-woo-cart-btn .iconn,
.cata-header.cata-light .header-search,
.cata-header.cata-light .catanis-main-menu > ul > li.fa-home > a::before,
.cata-header.cata-light .catanis-main-menu > ul > li > a, 
.cata-header.cata-light .catanis-main-menu > ul > li > a{ 
	color: <?php echo esc_html($catanis_optdata['mainmenu_light_link_regular']);?>;
}
.cata-header.cata-light .catanis-main-menu > ul > li:hover > a,
.cata-header.cata-light .catanis-main-menu > ul > li:focus > a, 
.cata-header.cata-light .catanis-main-menu > ul > li:active > a, 
.cata-header.cata-light .catanis-main-menu > ul > li.active > a, 
.cata-header.cata-light .catanis-main-menu > ul > li.current-menu-item > a,
.sticky-wrapper.is-sticky .cata-header.cata-light .catanis-main-menu > ul > li.active > a, 
.sticky-wrapper.is-sticky .cata-header.cata-light .catanis-main-menu > ul > li.active > a {
	color: <?php echo esc_html($catanis_optdata['mainmenu_light_link_hover']);?>;
}
.cata-header.cata-light.v4 #menu, 
.cata-header.cata-light.v4 .catanis-main-menu > ul > li,
.cata-header.cata-light.v4 .catanis-main-menu > ul > li:last-child{
    border-color: <?php echo esc_html($catanis_optdata['mainmenu_light_border_color']);?>;
}

<?php /* -------------- SUB MENU & MEGA MENU -------------- */ ?>
.cata-header.cata-light .catanis-main-menu li.mega-menu-item ul li[class^="ti-"]:before, 
.cata-header.cata-light .catanis-main-menu li.mega-menu-item ul li[class^="fa-"]:before,
.cata-header.cata-light .catanis-main-menu ul ul li a, 
.cata-header.cata-light .catanis-main-menu li.mega-menu-item ul ul a,
.cata-header.cata-light .catanis-main-menu .mega-menu-item > ul > li > a{
  	color: <?php echo esc_html($catanis_optdata['submenu_light_link_regular']);?>;
}
.cata-header.cata-light .catanis-main-menu ul ul li a:hover,
.cata-header.cata-light .catanis-main-menu ul ul .current-menu-item > a,
.cata-header.cata-light .catanis-main-menu ul ul .current-menu-item > a,
.cata-header.cata-light .catanis-main-menu ul ul .current-menu-parent > a,
.cata-header.cata-light .catanis-main-menu ul ul .current-menu-ancestor > a,
.cata-header.cata-light .catanis-main-menu li.mega-menu-item ul li[class^="ti-"]:hover:before, 
.cata-header.cata-light .catanis-main-menu li.mega-menu-item ul li[class^="fa-"]:hover:before, 
.cata-header.cata-light .catanis-main-menu ul ul li[class^="ti-"].current-menu-item:before, 
.cata-header.cata-light .catanis-main-menu ul ul li[class^="fa-"].current-menu-item:before,
.cata-header.cata-light .catanis-main-menu li.mega-menu-item ul ul .current-menu-item > a,
.cata-header.cata-light .catanis-main-menu li.mega-menu-item > ul .container > li > a:hover, <?php // Mega menu parent title ?>
.cata-header.cata-light .catanis-main-menu li.mega-menu-item ul ul li:hover a	<?php // Mega menu children title ?>
{
	color: <?php echo esc_html($catanis_optdata['submenu_light_link_hover']);?>;
}
.cata-header.cata-light .catanis-main-menu ul ul/*,
.cata-header.cata-light .catanis-main-menu li.mega-menu-item > ul */{
	background-color: <?php echo esc_html($catanis_optdata['submenu_light_bg_color']);?>;
}
.cata-header.cata-light .catanis-main-menu ul ul li,
.cata-header.cata-light .catanis-main-menu li.mega-menu-item ul li,
.cata-header.cata-light .catanis-main-menu li.mega-menu-item > ul > li  {
  	border-color: <?php echo esc_html($catanis_optdata['submenu_light_border_color']);?>;
}
.cata-header.cata-light .catanis-main-menu > ul > li:not(.mega-menu-item) ul > li:first-child {
    border-top-color: <?php echo esc_html($catanis_optdata['submenu_light_border_color']);?>;
}

<?php /* -------------- STICKY MENU -------------- */ ?>
.sticky-wrapper.is-sticky .cata-header.cata-light .header-middle,
.sticky-wrapper.is-sticky .cata-header.cata-light .header-bottom,
body.header-overlap .sticky-wrapper.is-sticky .cata-header.cata-light .header-middle,
body.header-overlap .sticky-wrapper.is-sticky .cata-header.cata-light .header-bottom{
	background: <?php echo esc_html($catanis_optdata['mainmenu_light_sticky_color']);?>;
}
.sticky-wrapper.is-sticky .cata-header.cata-light.v4 #menu, 
.sticky-wrapper.is-sticky .cata-header.cata-light.v4 .catanis-main-menu > ul > li{
 	border-color: <?php echo esc_html($catanis_optdata['mainmenu_light_sticky_border_color']);?>;
}
.sticky-wrapper.is-sticky .cata-header.cata-light .header-sidewidget .iconn,
.sticky-wrapper.is-sticky .cata-header.cata-light .header-cart .cat-woo-cart-btn .iconn,
.sticky-wrapper.is-sticky .cata-header.cata-light .header-search,
.sticky-wrapper.is-sticky .cata-header.cata-light .catanis-main-menu > ul > li.fa-home > a::before,
.sticky-wrapper.is-sticky .cata-header.cata-light.v4 .header-cart, 
.sticky-wrapper.is-sticky .cata-header.cata-light.v4 .cat-woo-cart-btn p, 
.sticky-wrapper.is-sticky .cata-header.cata-light .catanis-main-menu > ul > li > a, 
.sticky-wrapper.is-sticky .cata-header.cata-light .catanis-main-menu > ul > li > a{ 
	color: <?php echo esc_html($catanis_optdata['mainmenu_light_sticky_link_color_regular']);?>;
}
.sticky-wrapper.is-sticky .cata-header.cata-light .catanis-main-menu > ul > li:hover > a,
.sticky-wrapper.is-sticky .cata-header.cata-light .catanis-main-menu > ul > li:focus > a, 
.sticky-wrapper.is-sticky .cata-header.cata-light .catanis-main-menu > ul > li:active > a, 
.sticky-wrapper.is-sticky .cata-header.cata-light .catanis-main-menu > ul > li.current-menu-item >a{
	color: <?php echo esc_html($catanis_optdata['mainmenu_light_sticky_link_color_hover']);?>;
}
.sticky-wrapper.is-sticky .cata-header.cata-light .header-cart .cat-woo-cart-btn p span{
	background-color: <?php echo esc_html($catanis_optdata['mainmenu_light_sticky_link_color_regular']);?>;
	color: <?php echo esc_html($catanis_optdata['mainmenu_light_sticky_color']);?>;
}

<?php /*===================================================================================
============MENU STYLE DARK ===============================================================*/?>
.cata-header.cata-dark .header-bottom{
	background-color: <?php echo esc_html($catanis_optdata['mainmenu_dark_bg_color']);?>;
	border-color: <?php echo esc_html($catanis_optdata['mainmenu_dark_border_color']);?>;
}
.cata-header.cata-dark.v1 .header-bottom .header-content-right:before, 
.cata-header.cata-dark.v3 .header-bottom .header-content-right:before{
	border-color: <?php echo esc_html($catanis_optdata['mainmenu_dark_border_color']);?>;
}
.cata-header.cata-dark .header-cart .cat-woo-cart-btn p span {
	background-color: <?php echo esc_html($catanis_optdata['mainmenu_dark_link_regular']);?>;
	color: <?php echo esc_html($catanis_optdata['mainmenu_dark_bg_color']);?>;
}

<?php /* Color for main-menu*/ ?>
.cata-header.cata-dark.v4 .social-icons-wrap .ca-social-icons li a,
.cata-header.cata-dark .header-sidewidget .iconn,
.cata-header.cata-dark .header-cart .cat-woo-cart-btn .iconn,
.cata-header.cata-dark .header-search,
.cata-header.cata-dark .catanis-main-menu > ul > li.fa-home > a::before,
.cata-header.cata-dark .catanis-main-menu > ul > li > a, 
.cata-header.cata-dark .catanis-main-menu > ul > li > a{ 
	color: <?php echo esc_html($catanis_optdata['mainmenu_dark_link_regular']);?>;
}
.cata-header.cata-dark .catanis-main-menu > ul > li:hover > a,
.cata-header.cata-dark .catanis-main-menu > ul > li:focus > a, 
.cata-header.cata-dark .catanis-main-menu > ul > li:active > a, 
.cata-header.cata-dark .catanis-main-menu > ul > li.active > a, 
.cata-header.cata-dark .catanis-main-menu > ul > li.current-menu-item > a,
.sticky-wrapper.is-sticky .cata-header.cata-dark .catanis-main-menu > ul > li.active > a, 
.sticky-wrapper.is-sticky .cata-header.cata-dark .catanis-main-menu > ul > li.active > a {
	color: <?php echo esc_html($catanis_optdata['mainmenu_dark_link_hover']);?>;
}
.cata-header.cata-dark.v4 #menu, 
.cata-header.cata-dark.v4 .catanis-main-menu > ul > li,
.cata-header.cata-dark.v4 .catanis-main-menu > ul > li:last-child{
    border-color: <?php echo esc_html($catanis_optdata['mainmenu_dark_border_color']);?>;
}

<?php /* -------------- SUB MENU & MEGA MENU -------------- */ ?>
.cata-header.cata-dark .catanis-main-menu li.mega-menu-item ul li[class^="ti-"]:before, 
.cata-header.cata-dark .catanis-main-menu li.mega-menu-item ul li[class^="fa-"]:before,
.cata-header.cata-dark .catanis-main-menu ul ul li a, 
.cata-header.cata-dark .catanis-main-menu li.mega-menu-item ul ul a,
.cata-header.cata-dark .catanis-main-menu .mega-menu-item > ul > li > a{
  	color: <?php echo esc_html($catanis_optdata['submenu_dark_link_regular']);?>;
}
.cata-header.cata-dark .catanis-main-menu ul ul li a:hover,
.cata-header.cata-dark .catanis-main-menu ul ul .current-menu-item,
.cata-header.cata-dark .catanis-main-menu ul ul .current-menu-parent,
.cata-header.cata-dark .catanis-main-menu ul ul .current-menu-ancestor,
.cata-header.cata-dark .catanis-main-menu li.mega-menu-item ul li[class^="ti-"]:hover:before, 
.cata-header.cata-dark .catanis-main-menu li.mega-menu-item ul li[class^="fa-"]:hover:before, 
.cata-header.cata-dark .catanis-main-menu ul ul li[class^="ti-"].current-menu-item:before, 
.cata-header.cata-dark .catanis-main-menu ul ul li[class^="fa-"].current-menu-item:before,
.cata-header.cata-dark .catanis-main-menu li.mega-menu-item ul ul .current-menu-item > a,
.cata-header.cata-dark .catanis-main-menu li.mega-menu-item > ul .container > li > a:hover, <?php // Mega menu parent title ?>
.cata-header.cata-dark .catanis-main-menu li.mega-menu-item ul ul li:hover a	<?php // Mega menu children title ?>
{
	color: <?php echo esc_html($catanis_optdata['submenu_dark_link_hover']);?>;
}
.cata-header.cata-dark .catanis-main-menu ul ul/*,
.cata-header.cata-dark .catanis-main-menu li.mega-menu-item > ul*/ {
	background-color: <?php echo esc_html($catanis_optdata['submenu_dark_bg_color']);?>;
}
.cata-header.cata-dark .catanis-main-menu ul ul li,
.cata-header.cata-dark .catanis-main-menu li.mega-menu-item ul li,
.cata-header.cata-dark .catanis-main-menu li.mega-menu-item > ul > li {
  	border-color: <?php echo esc_html($catanis_optdata['submenu_dark_border_color']);?>;
}
.cata-header.cata-dark .catanis-main-menu > ul > li:not(.mega-menu-item) ul > li:first-child {
    border-top-color: <?php echo esc_html($catanis_optdata['submenu_dark_border_color']);?>;
}

<?php /* -------------- STICKY MENU -------------- */ ?>
.sticky-wrapper.is-sticky .cata-header.cata-dark .header-middle,
.sticky-wrapper.is-sticky .cata-header.cata-dark .header-bottom,
body.header-overlap .sticky-wrapper.is-sticky .cata-header.cata-dark .header-middle,
body.header-overlap .sticky-wrapper.is-sticky .cata-header.cata-dark .header-bottom{
	background: <?php echo esc_html($catanis_optdata['mainmenu_dark_sticky_color']);?>;
}
.sticky-wrapper.is-sticky .cata-header.cata-dark.v4 #menu, 
.sticky-wrapper.is-sticky .cata-header.cata-dark.v4 .catanis-main-menu > ul > li{
 	border-color: <?php echo esc_html($catanis_optdata['mainmenu_dark_sticky_border_color']);?>;
}
.sticky-wrapper.is-sticky .cata-header.cata-dark .header-sidewidget .iconn,
.sticky-wrapper.is-sticky .cata-header.cata-dark .header-cart .cat-woo-cart-btn .iconn,
.sticky-wrapper.is-sticky .cata-header.cata-dark .header-search,
.sticky-wrapper.is-sticky .cata-header.cata-dark .catanis-main-menu > ul > li.fa-home > a::before,
.sticky-wrapper.is-sticky .cata-header.cata-dark.v4 .header-cart, 
.sticky-wrapper.is-sticky .cata-header.cata-dark.v4 .cat-woo-cart-btn p, 
.sticky-wrapper.is-sticky .cata-header.cata-dark .catanis-main-menu > ul > li > a, 
.sticky-wrapper.is-sticky .cata-header.cata-dark .catanis-main-menu > ul > li > a{ 
	color: <?php echo esc_html($catanis_optdata['mainmenu_dark_sticky_link_color_regular']);?>;
}
.sticky-wrapper.is-sticky .cata-header.cata-dark .catanis-main-menu > ul > li:hover > a,
.sticky-wrapper.is-sticky .cata-header.cata-dark .catanis-main-menu > ul > li:focus > a, 
.sticky-wrapper.is-sticky .cata-header.cata-dark .catanis-main-menu > ul > li:active > a, 
.sticky-wrapper.is-sticky .cata-header.cata-dark .catanis-main-menu > ul > li.current-menu-item >a{
	color: <?php echo esc_html($catanis_optdata['mainmenu_dark_sticky_link_color_hover']);?>;
}

<?php 
/*=============================================================================================================*/
/*=== I. CUSTOM COLOR & FONT ==================================================================================*/
/*=============================================================================================================*/?>

<?php /*=== MAIN COLOR #E6B1B3
=========================================================*/ ?>
.single-post article.post .item .entry-content .wrap-entry-content a,
#comments ol.commentlist li.comment p.comment-awaiting-moderation,
#respond #commentform .logged-in-as a:first-child,
.cata-widget-twitter .cata-item .author-datetime a,
.cata-widget-testimonials .cata-item .cata-title-occupation a,
.widget_meta ul li:before,
.widget-container ul.menu > li.current-menu-item > a,
#wp-calendar tbody td >a,
/*Default*/
.gallery.gallery-size-large a:before,
.no-items,
.cata-footer .widget_recent_comments li .comment-author-link, 
.cata-footer .widget_recent_comments li .comment-author-link a,
.cata-footer .widget_tag_cloud .tagcloud a:hover, 
.cata-footer .cata-widget-tag-cloud .tagcloud a:hover,
.cata-footer .widget_recent_entries .post-date,
.cata-footer .cata-widget-recent-posts .cata-info-detail > span,
.cata-blog-item .item .tags-links a:hover,
.cata-blog-item .item .tags-links .fa,
.cata-blog-item .entry-meta li.meta-seperate:before,
.cata-blog-item .entry-meta li a:hover, 
.entry-meta li a:hover,
.cata-blog-item .entry-meta li.meta-love .fa,
.cata-blog-item .entry-meta li.meta-comments .fa,
.cata-blog-item .entry-meta li.meta-categories >span,
.cata-blog-item .entry-meta li.meta-categories > a:hover,
.cata-blog-item .entry-meta li.meta-date,
.cata-blog-item .cata-blog-item-title .sticky,
.cata-blog-item .post-quote .top-icon,
.cata-blog-item .post-link .top-icon,
.cata-blog-item .post-link div> a:hover,
.cata-related-post .cata-item .entry-content .entry-meta,
.cata-comments-area ol.commentlist li .meta-datetime,
.cata-comments-area ol.commentlist li div.reply a,
.widget_product_categories ul li a:hover, 
.widget_nav_menu ul li a:hover, 
.widget_categories ul li a:hover,
.cata-widget-twitter .cata-item:before,
.cata-widget-twitter .tweet-content a,
.cata-widget-recent-comments .cata-item .cata-info > a:hover,
.cata-widget-subscriptions .cata-subscribe button.button:hover,
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle:before,
.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle:before,
.woocommerce .widget_layered_nav ul li > a:hover, 
.woocommerce .widget_layered_nav_filters ul li > a:hover,
.woocommerce .widget_layered_nav ul li.chosen > a,
.woocommerce .widget_layered_nav_filters ul li.chosen > a,
.header-cart .cata-mini-cart .total .amount, 
.woocommerce .widget_shopping_cart .total .amount,
.woocommerce.widget_shopping_cart .total .amount,
.header-cart .cata-mini-cart ul.cart_list li a:hover, 
.header-cart .cata-mini-cart ul.product_list_widget li a:hover, 
.woocommerce ul.cart_list li a:hover, 
.woocommerce ul.product_list_widget li a:hover,
.cata-slick-slider .slick-slider .slick-prev:hover, 
.cata-slick-slider .slick-slider .slick-next:hover, 
.slick-dots li.slick-active button:before,
body.error404 article h1,
.woocommerce .cata-product-single .cata-product-wrapper .cata-social-share li a:hover,
/*footer*/
.cata-footer .color-light a:hover,
.cata-footer .color-light .widget_tag_cloud .tagcloud a:hover, 
.cata-footer .color-light .cata-widget-tag-cloud .tagcloud a:hover,
.cata-footer .color-light .widget_recent_entries a:hover,
.cata-footer .color-light .widget_archive li a:hover,
.cata-footer .color-light .widget_meta ul li a:hover,
.cata-footer .color-light .widget_nav_menu ul.menu > li a:hover,
.cata-footer .color-light .widget_nav_menu ul li.current_page_item > a,
.cata-footer .color-light .widget_pages ul li a:hover,
.cata-footer .color-light .widget_pages ul li.current_page_item > a,
.cata-footer .color-light .widget_categories li a:hover,
.cata-footer .color-light .widget_categories li.current-cat > a,
.cata-footer .color-light .widget_text ul.menu > li a:hover,
.cata-footer .color-light .widget_text ul.menu > li.current_page_item > a,
.cata-footer .color-light #wp-calendar tfoot td#prev a:hover,
.cata-footer .color-light #wp-calendar tfoot td#next a:hover,
.cata-footer .color-light .cata-widget-flickr a.cata-see-more:hover,
.cata-footer .color-light .cata-widget-instagram a.cata-see-more:hover,
.cata-footer .color-light .cata-widget-recent-posts .cata-entry-title a:hover,
.cata-footer .color-light .cata-widget-recent-comments .cata-item .cata-info > a:hover,
.cata-footer .color-light .cata-widget-twitter .cata-item:hover::before,
/*woocommerce*/
.woocommerce-message a,
.woocommerce-error:before, 
.woocommerce-info:before, 
.woocommerce-message:before,
.woocommerce-MyAccount-navigation li a,
.woocommerce-MyAccount-content p a, 
.woocommerce-MyAccount-content mark,
.woocommerce-account .addresses .title .edit, 
.woocommerce-account ul.digital-downloads li .count,
.woocommerce-thankyou-order-received,
.cata-before-loop-wrapper .cata-gridlist-toggle a:hover, 
.cata-before-loop-wrapper .cata-gridlist-toggle a.active,
.woocommerce .cata-item .cata-product-wrapper .product-categories a, 
.woocommerce-page .cata-item .cata-product-wrapper .product-categories a,
.cata-products-widget .product-categories a,
.header-cart .cata-mini-cart .buttons a.button:first-child:hover, 
.woocommerce .widget_shopping_cart .buttons a.button:first-child:hover, 
.woocommerce.widget_shopping_cart .buttons a.button:first-child:hover,
.woocommerce .cata-product-single .cata-product-wrapper .woocommerce-product-rating a.woocommerce-review-link:hover, 
.woocommerce-page .cata-product-single .cata-product-wrapper .woocommerce-product-rating a.woocommerce-review-link:hover,
.woocommerce .cata-product-item .cata-product-wrapper a.button:hover, 
.woocommerce-page .cata-product-item .cata-product-wrapper a.button:hover,
.woocommerce .cata-product-single .cata-product-images .cata-image-zoom-btn:hover, 
.woocommerce-page .cata-product-single .cata-product-images .cata-image-zoom-btn:hover,
.woocommerce .cata-product-single .cata-product-wrapper .cata-product-summary .product_meta > div span a:hover, 
.cata-product-shippingbox .cata-cols-wrapper .cata-shippingbox>i,
.woocommerce .cata-product-single .cata-product-wrapper #reviews #comments ol.commentlist li .comment_container .comment-text p.meta, 
.woocommerce-page .cata-product-single .cata-product-wrapper #reviews #comments ol.commentlist li .comment_container .comment-text p.meta,
/*shortcode*/
h3.heading-title.style7 i,
.cata-isotope-filter ul li:after, 
.cata-isotope-filter ul li:hover a,
.cata-isotope-filter ul li.selected a, 
.cata-portfolio .cata-isotope-item:hover .cata-item-info .cata-cates a:hover,
.cata-portfolio .cata-love-counter .cata-love,
.cata-project-detail .cata-project-info .project-info a:hover,
.cata-related-portfolio .cata-isotope-item .entry-content .entry-meta,
.cata-portfolio .cata-item-info .cata-cates,
.cata-portfolio .cata-item-info .cata-cates a,
.cata-socials.cata-style13 li a:hover:after,
.cata-socials.cata-style13 li a .cicon,
.cata-twitter .cicon, 
.cata-twitter .author-datetime a,
.cata-team .team-member .info span.role,
.cata-imagebox.cata-style1:hover .imagebox-wrap h6,
.cata-imagebox.cata-style1:hover .imagebox-wrap h6 a, 
.cata-contactinfo-block .cata-item p a:hover,
.cata-contactinfo-block.cata-style1 .cata-item i,
.cata-pricetable .cata-icon,
.cata-timeline-icon,
.cata-timeline-content .cata-date,
.cata-testimonial .cata-item .cata-info .occupation,
.cata-testimonial.cata-style6 .cata-item .cata-info em,
.cata-testimonial.cata-style6 .cata-item .cata-info .title,
.cata-iconbox:hover .iconbox-wrap h6,
.cata-iconbox:hover .iconbox-wrap h6 a,
.cata-iconbox.cata-style1 .icon,
.cata-iconbox.cata-style2 .icon,
.cata-iconbox.cata-style3 .icon,
.cata-iconbox.cata-style4 .number,
.cata-iconbox.cata-style5 .icon,
.cata-countdown.cata-style1 .is-countdown .countdown-amount,
.cata-countdown.cata-style2 .is-countdown .countdown-amount,
.cata-double-slider .double-slider-nav a:hover,
.cata-content-slider .slick-slider .slick-prev:hover, 
.cata-content-slider .slick-slider .slick-next:hover,
.vc_tta.vc_general .vc_tta-tab>a:hover,
.vc_tta.vc_tta-tabs.cata-tabs.cata-style1 .vc_tta-tabs-list .vc_tta-tab .vc_tta-icon,
.vc_tta.vc_tta-tabs.cata-tabs.cata-style22 .vc_tta-tabs-list .vc_tta-tab .vc_tta-icon,
.vc_tta.vc_tta-tabs.cata-tabs.cata-style33 .vc_tta-tabs-list .vc_tta-tab .vc_tta-icon,
.vc_tta.vc_tta-tabs.cata-tabs.cata-style-icon .vc_tta-tabs-list .vc_tta-tab.vc_active .vc_tta-icon,
.vc_tta.vc_tta-tabs.cata-tour.cata-style33 .vc_tta-tabs-container .vc_tta-tab .vc_tta-icon,
.vc_tta.vc_tta-accordion.cata-accordion .vc_tta-panel .vc_tta-panel-title>a .vc_tta-icon,
.cata-product-categories .cata-item .cata-meta-wrapper>div a:hover,
.cata-product-categories .cata-item .cata-meta-wrapper>div mark
{
  	color: <?php echo esc_html($catanis_optdata['content_link_hover']);?>;
}

.cata-main-color a,
.cata-main-color p{
	color:<?php echo esc_html($catanis_optdata['content_link_hover']);?> !important;
}

<?php /*=== MAIN BACKGROUND COLOR #E6B1B3
=========================================================*/ ?>
#quote-carousel .carousel-control:hover,
#quote-carousel .dots-indicators li.active,
.tp-bullets.custom .tp-bullet:hover, 
.tp-bullets.custom .tp-bullet.selected,
/*Dafault*/
button.button:hover, input.button:hover, a.button:hover, input[type^=submit]:hover,
#slide-out-widget-area,
.cata-footer .widget_tag_cloud .tagcloud a:hover, 
.cata-footer .cata-widget-tag-cloud .tagcloud a:hover,
.video-js .vjs-play-control,
.video-js .vjs-volume-level,
.video-js .vjs-play-progress,
.cata-timeline-top:before,
.cata-timeline-bottom:before,
.cata-music-toggle-btn,
.wp-playlist .mejs-container .mejs-controls,
.cata-audio-mp3 .mejs-controls .mejs-time-rail .mejs-time-loaded, 
.cata-audio-mp3 .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current,
.cata-audio-mp3 .mejs-container .mejs-controls .mejs-fullscreen-button, 
.cata-audio-mp3 .mejs-container .mejs-controls .mejs-playpause-button,
.cata-audio-mp3 .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, 
.single-post article.post .meta-tags a:hover,
.cata-post.cata-isotope .cata-blog-item.format-quote .item,
.cata-post.cata-isotope .cata-blog-item.format-link .item,
.cata-related-post .cata-slick-slider .slick-slider .slick-prev, 
.cata-related-post .cata-slick-slider .slick-slider .slick-next,
.widget-container .cata-slick-slider .slick-slider .slick-prev, 
.widget-container .cata-slick-slider .slick-slider .slick-next,
.cata-related-post .dots-line .slick-dots li.slick-active button, 
.cata-related-post .dots-square .slick-dots li.slick-active button, 
.cata-related-post .dots-catanis-width .slick-dots li.slick-active button, 
.cata-related-post .dots-catanis-height .slick-dots li.slick-active button,
.widget_product_tag_cloud .tagcloud a:hover,
.widget_tag_cloud .tagcloud a:hover, 
.cata-widget-tag-cloud .tagcloud a:hover,
.cata-widget-recent-posts  .cata-thumb-none .cata-num,
.cata-widget-subscriptions .cata-subscribe.cata-style-background form button.button, 
.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
.woocommerce-page .widget_price_filter .ui-slider .ui-slider-range,
.catanis-loader-wraper.cata-style5 .bounce:before,
.dots-line .slick-dots li.slick-active button,
.dots-square .slick-dots li.slick-active button,
.dots-catanis-width .slick-dots li.slick-active button,
.dots-catanis-height .slick-dots li.slick-active button,
.cata-pagination-nextprev .newer-posts > a:hover,
.cata-pagination-nextprev .older-posts >a:hover,
.woocommerce .cata-product-single .cata-product-images > .thumbnails .slick-prev,
.woocommerce-page .cata-product-single .cata-product-images > .thumbnails .slick-prev,
.woocommerce .cata-product-single .cata-product-images > .thumbnails .slick-next,
.woocommerce-page .cata-product-single .cata-product-images > .thumbnails .slick-next,
/*shortcode*/
.heading-title.style5:after,
input[type^=submit],
.cata-contact-form input[type="submit"]:hover,
.cata-gallery-imgs .cata-overlay .icon-circle,
.cata-team.cata-style1 .cata-team-center-slider .cata-item.slick-center .info,
.cata-imagebox.cata-style2 .bgoverlay,
.cata-widget-instagram .cata-insta-items a:before,
.cata-widget-flickr .cata-flickr-items a:before,
.video-js .vjs-play-progress,
.cata-iconbox.cata-style3 .icon:hover,
.cata-single-image.effect-oval > div figure:after,
.cata-image-title.effect-slide-top > div figure figcaption,
.cata-center-slider .content-slider-container .readmore,
#wp-calendar tbody td#today,
#wp-calendar tbody td:not(.pad):hover,
.vc_tta.vc_tta-tabs.cata-tabs.cata-style22 .vc_tta-tabs-list .vc_tta-tab.vc_active,
.vc_tta.vc_tta-tabs.cata-tour.cata-style33 .vc_tta-tabs-container .vc_tta-tab.vc_active,
.vc_tta.vc_tta-tabs.cata-tour.cata-style-icon .vc_tta-tabs-list .vc_tta-tab.vc_active:after,
/*woocommerce*/
.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, 
.woocommerce button.button.alt, .woocommerce input.button.alt,
.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, 
.woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,
html .woocommerce a.button:hover,
html .woocommerce button.button:hover,
html .woocommerce input.button:hover,
html .woocommerce #respond input#submit, 
html .woocommerce #content input.button:hover,
html .woocommerce-page a.button:hover,
html .woocommerce-page button.button:hover, 
html .woocommerce-page input.button:hover,
html .woocommerce-page #respond input#submit:hover, 
html .woocommerce #content table.cart input.button:hover,
.woocommerce div.product form.cart .button:hover,
.woocommerce div.product .single_add_to_cart_button.button:hover,
.woocommerce .cata-product-single .cata-product-wrapper p.availability.stock span, 
.woocommerce-page .cata-product-single .cata-product-wrapper p.availability.stock span
{
	background-color: <?php echo esc_html($catanis_optdata['content_link_hover']);?>;
}

.vc_images_carousel .vc_carousel-indicators li:hover,
.vc_images_carousel .vc_carousel-indicators .vc_active {
    background-color: <?php echo esc_html($catanis_optdata['content_link_hover']);?> !important;
}

<?php /*=== MAIN BORDER COLOR #E6B1B3
=========================================================*/ ?>
#comments ol.commentlist li.comment p.comment-awaiting-moderation,
/*Default*/
.cata-footer .widget_tag_cloud .tagcloud a:hover, 
.cata-footer .cata-widget-tag-cloud .tagcloud a:hover,
.cata-blog-item .cata-blog-item-excerpt a.read-more,
.cata-blog-item .item .tags-links a:hover,
.widget-container .cata-slick-slider .slick-slider .slick-prev, 
.widget-container .cata-slick-slider .slick-slider .slick-next,
.widget_product_tag_cloud .tagcloud a:hover,
.widget_tag_cloud .tagcloud a:hover, 
.widget_product_search form.woocommerce-product-search,
.widget_search form input.search-input,
.cata-widget-tag-cloud .tagcloud a:hover,
.cata-pagination-nextprev .newer-posts > a:hover,
.cata-pagination-nextprev .older-posts >a:hover,
.cata-slick-slider .slick-slider .slick-prev:hover, 
.cata-slick-slider .slick-slider .slick-next:hover,
/*shortcode*/
.cata-loadmore-wrapper>a:hover span,
.cata-imagebox.cata-style1 .readmore,
.cata-video-popup-style.noimg .video-ctent .video-control,
div.wpcf7-mail-sent-ok,
.cata-contactinfo-block .cata-item p a:hover,
.cata-iconbox .readmore,
.cata-double-slider .double-slider-nav a:hover,
.cata-content-slider .slick-slider .slick-prev:hover, 
.cata-content-slider .slick-slider .slick-next:hover,
.cata-columns-slider .content-slider-container .readmore,
/*woocommerce*/
.woocommerce-info, 
.woocommerce-error, 
.woocommerce-message, 
.woocommerce .cata-product-item .cata-product-wrapper a.button, 
.woocommerce-page .cata-product-item .cata-product-wrapper a.button,
.header-cart .cata-mini-cart .buttons a.button:first-child:hover, 
.woocommerce .widget_shopping_cart .buttons a.button:first-child:hover, 
.woocommerce.widget_shopping_cart .buttons a.button:first-child:hover,
.cata-product-shippingbox .cata-cols-wrapper .col,
.woocommerce #content div.product .woocommerce-tabs ul.tabs li a:after, 
.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li a:after, 
.woocommerce .cata-product-single .cata-product-wrapper .woocommerce-tabs ul.tabs li a:after, 
.woocommerce-page .cata-product-single .cata-product-wrapper .woocommerce-tabs ul.tabs li a:after
{
	border-color:<?php echo esc_html($catanis_optdata['content_link_hover']);?>;
}
.cata-team.cata-style1 .cata-team-center-slider .cata-item.slick-center .info:before{
    border-bottom-color:<?php echo esc_html($catanis_optdata['content_link_hover']);?>;
}
.vc_tta.vc_tta-tabs.cata-tabs.cata-style22 .vc_tta-tabs-list .vc_tta-tab.vc_active:after {
    border-top-color:<?php echo esc_html($catanis_optdata['content_link_hover']);?>;
}
.vc_tta.vc_tta-tabs.cata-tour.cata-style2 .vc_tta-tabs-container .vc_tta-tab.vc_active,
body.rtl .cata-list.bullet-numberic-rounded.numlist ul > li:hover:after, .cata-list.bullet-numberic-rounded.numlist ul ul > li:hover:after,
body.rtl .cata-list.bullet-numberic-rounded.numlist ol > li:hover:after, .cata-list.bullet-numberic-rounded.numlist ol ol > li:hover:after,
body.rtl .cata-list.bullet-numberic-rounded.numlist ul ol > li:hover:after, .cata-list.bullet-numberic-rounded.numlist ol ul > li:hover:after{/*color*/
	border-right-color:<?php echo esc_html($catanis_optdata['content_link_hover']);?>;
}
.vc_tta.vc_tta-tabs.cata-tour.cata-style33 .vc_tta-tabs-container .vc_tta-tab.vc_active:after,
.cata-list.bullet-numberic-rounded.numlist ul > li:hover:after, .cata-list.bullet-numberic-rounded.numlist ul ul > li:hover:after,
.cata-list.bullet-numberic-rounded.numlist ol > li:hover:after, .cata-list.bullet-numberic-rounded.numlist ol ol > li:hover:after,
.cata-list.bullet-numberic-rounded.numlist ul ol > li:hover:after, .cata-list.bullet-numberic-rounded.numlist ol ul > li:hover:after {
    border-left-color:<?php echo esc_html($catanis_optdata['content_link_hover']);?>;
}

<?php /*=== COLOR #1A1A1A
=========================================================*/ ?>
ol.commentlist li.comment div.wrap-comment-info cite.fn,
ol.commentlist li.comment div.wrap-comment-info cite.fn a.url,
ol.commentlist li.pingback cite.fn,
#comments ol.commentlist li.comment strong,
/*Default*/
h1, h2, h3, h4, h5, h6, h3.heading-title,
table>thead>tr>th, table>tbody>tr>th,
#wp-calendar caption,
.author-info .author-description .author-socials li a,
.cata-comments-area ol.commentlist li div.reply a:hover,
.widget_recent_comments li .comment-author-link,
.widget_recent_comments li .comment-author-link a,
.cata-widget-twitter .cata-item:hover::before,
.wp-playlist .wp-playlist-current-item .wp-playlist-item-title,
.vc_tta.vc_tta-tabs.cata-tour.cata-style2 .vc_tta-tabs-container .vc_tta-tab.vc_active,
.header-cart .cata-mini-cart .total,
.woocommerce .widget_shopping_cart .total, 
.woocommerce.widget_shopping_cart .total,
/*shortcode*/
.cata-btn,
.cata-tooltip,
.cata-milestone.has-icon .number,
.cata-contactinfo-block .cata-item .cata-fild-name, 
.cata-videobg.cata-text-dark .video-title-wrap .cata-video-title,
.cata-videobg.cata-text-dark .video-title-wrap .cata-video-excerpt,
.cata-message.cata-style3 .ccontent .tbolb,
.cata-message.cata-style4.msg-error .cclose,
.cata-portfolio .cata-isotope-item .cata-item-info .cata-title a,
.cata-project-detail .project-share .cata-social-share li a:hover,
.cata-counter-circle .desc span,
.cata-progress-bars .cata-bar-title em,
.vc_tta.vc_tta-tabs.cata-tour.cata-style1 .vc_tta-tabs-container .vc_tta-tab.vc_active>a,
.vc_tta.vc_tta-tabs.cata-tour.cata-style1 .vc_tta-tabs-container .vc_tta-tab.vc_active>a:before,
.vc_tta.vc_tta-tabs.cata-tour.cata-style-icon .vc_tta-tabs-list .vc_tta-tab .vc_tta-icon,
.vc_tta.vc_tta-tabs.cata-tour.cata-style33 .vc_tta-tabs-container .vc_tta-tab>a,
.vc_tta.vc_tta-tabs.cata-tabs.cata-style33 .vc_tta-tabs-list .vc_tta-tab .vc_tta-title-text,
.vc_tta.vc_tta-tabs.cata-tabs.cata-style22 .vc_tta-tabs-list .vc_tta-tab .vc_tta-title-text,
.vc_tta.vc_tta-tabs.cata-tabs.cata-style1 .vc_tta-tabs-list .vc_tta-tab .vc_tta-title-text,
/*woocommerce*/
.woocommerce .cata-product-item .cata-product-wrapper a.button, 
.woocommerce-page .cata-product-item .cata-product-wrapper a.button,
.woocommerce .cata-item .cata-product-wrapper .price,
.woocommerce-page .cata-item .cata-product-wrapper .price,
.woocommerce .cata-product-single .cata-product-wrapper .cata-product-summary .product_meta > div,
.cata-single-navigation > div > a .product-info > div > span,
.cata-product-shippingbox .cata-cols-wrapper .cata-shippingbox>span,
.woocommerce .cata-product-single .cata-product-wrapper form.cart .group_table td,
.woocommerce .amount, 
.woocommerce-page .amount,
#add_payment_method #payment ul.payment_methods li label, 
.woocommerce-cart #payment ul.payment_methods li label, 
.woocommerce-checkout #payment ul.payment_methods li label,
.woocommerce table.shop_table tfoot th, .woocommerce table.shop_table tfoot td, 
.woocommerce table.shop_table tbody th,.woocommerce table.shop_table tbody td
{
	color: <?php echo esc_html($catanis_optdata['content_link_regular']);?>;
}

<?php /*=== BORDER COLOR #1A1A1A
=========================================================*/ ?>
.cata-pagination ul li span.current, 
.cata-pagination ul li:hover a,
.woocommerce nav.woocommerce-pagination ul li span.current,
.woocommerce-page nav.woocommerce-pagination ul li span.current,
.woocommerce nav.woocommerce-pagination ul li a:hover,
.woocommerce-page nav.woocommerce-pagination ul li a:hover,
.woocommerce nav.woocommerce-pagination ul li a:focus,
.woocommerce-page nav.woocommerce-pagination ul li a:focus
{
	border-color: <?php echo esc_html($catanis_optdata['content_link_regular']);?>;
}

<?php /*=== BACKGROUND COLOR #1A1A1A
=========================================================*/ ?>
button.button, input.button, a.button, input[type^=submit],
.cata-pagination ul li span.current, 
.cata-pagination ul li:hover a,
.cata-store-notice,
/*shortcode*/
.cata-contact-form input[type="submit"],
.cata-message.cata-style6 .cclose,
.cata-contactinfo-block.cata-style2 .cata-item i,
.cata-tooltip + .tooltip .tooltip-inner,
.cata-image-title.effect-blur-overlay > div figure,
/*woocommerce*/
html .woocommerce a.button,
html .woocommerce button.button,
html .woocommerce input.button,
html .woocommerce #respond input#submit, 
html .woocommerce #content input.button,
html .woocommerce-page a.button,
html .woocommerce-page button.button, 
html .woocommerce-page input.button,
html .woocommerce-page #respond input#submit, 
html .woocommerce #content table.cart input.button,
.woocommerce div.product form.cart .button,
.woocommerce div.product .single_add_to_cart_button.button,
.woocommerce nav.woocommerce-pagination ul li span.current,
.woocommerce-page nav.woocommerce-pagination ul li span.current,
.woocommerce nav.woocommerce-pagination ul li a:hover,
.woocommerce-page nav.woocommerce-pagination ul li a:hover,
.woocommerce nav.woocommerce-pagination ul li a:focus,
.woocommerce-page nav.woocommerce-pagination ul li a:focus
{
	background-color:<?php echo esc_html($catanis_optdata['content_link_regular']);?>;
}

<?php /*=== FONT "PT Serif" ===*/?>
h1,h2,h3,h4,h5,h6,.cata-font-ptserif,
#search-outer form input[type=text],
.cata-page-title .page-header-wrap .pagetitle-contents .title-subtitle span,
.cata-page-title .page-header-wrap .pagetitle-contents .title-subtitle .cata-autofade-text,
.cata-blog-item .entry-meta, 
.cata-blog-item .entry-meta li, 
.cata-blog-item .entry-meta li a,
.cata-blog-item .item .tags-links a,
.cata-blog-item .cata-blog-item-title,
.cata-blog-item .post-quote blockquote,
.single-post article.post .entry-header .single-top-meta .title,
.cata-related-post .cata-item .entry-content,
.cata-comments-area ol.commentlist li .meta-datetime,
.cata-products-widget .widgettitle,
.widget-title-wrapper .widget-title,
.cata-widget-recent-posts .cata-entry-title a,
.cata-widget-subscriptions .cata-subscribe.cata-style-background .newsletter,
.header-cart .cata-mini-cart .total .amount, 
.woocommerce .widget_shopping_cart .total .amount,
.woocommerce.widget_shopping_cart .total .amount,
/*woocommerce*/
.header-cart .cata-mini-cart ul.cart_list li .quantity .amount, 
.header-cart .cata-mini-cart ul.product_list_widget li .quantity .amount, 
.woocommerce .widget_shopping_cart .cart_list li .quantity .amount, 
.woocommerce.widget_shopping_cart .cart_list li .quantity .amount,
.woocommerce ul.cart_list li .amount, 
.woocommerce ul.product_list_widget li .amount,
.woocommerce .amount, .woocommerce-page .amount,
.woocommerce .cata-item .cata-product-wrapper .price,
.woocommerce-page .cata-item .cata-product-wrapper .price,
.products .cata-product-item.product-type-simple .cata-product-wrapper .cata-product-sku,
.cata-product-shippingbox .cata-cols-wrapper .cata-shippingbox>span,
.woocommerce .cata-product-single .cata-product-wrapper form.cart .group_table td.label label,
.woocommerce .cata-product-single .cata-product-wrapper #reviews #comments ol.commentlist li .comment_container .comment-text p.meta time, 
.woocommerce-page .cata-product-single .cata-product-wrapper #reviews #comments ol.commentlist li .comment_container .comment-text p.meta time,
.woocommerce .cata-product-single .cata-product-wrapper #reviews #review_form_wrapper #respond #reply-title, 
.woocommerce-page .cata-product-single .cata-product-wrapper #reviews #review_form_wrapper #respond #reply-title,
/*shortcode*/
h3.heading-title,
.cata-project-detail .cata-project-title,
.cata-related-portfolio .cata-isotope-item .entry-content,
.cata-counter-circle .desc span, 
.cata-testimonial .cata-item .cata-info .occupation,
.cata-testimonial.cata-style5 .cata-item .cata-detail,
.cata-testimonial.cata-style6 .cata-item .cata-detail,
.cata-testimonial.cata-style7 .cata-item .cata-detail,
.cata-pricetable .cata-price-unit,
.cata-progress-bars .cata-bar-title em,
.cata-dropcaps,
.cata-milestone .number,
.cata-callaction.cata-style6 .content-wrapper h4,
.cata-image-title > div figure figcaption h3,
.cata-image-title > div figure figcaption h3 a,
.cata-countdown .is-countdown .countdown-amount,
.cata-center-slider .content-slider-container h6.slider-title,
.cata-double-slider .slider-container h3.slider-title,
.cata-content-slider h3.slider-title,
.cata-columns-slider .content-slider-container h6.slider-title,
.vc_tta.vc_tta-tabs.cata-tabs.cata-style1 .vc_tta-tabs-list .vc_tta-tab .vc_tta-title-text,
.vc_tta.vc_tta-tabs.cata-tabs.cata-style22 .vc_tta-tabs-list .vc_tta-tab .vc_tta-title-text,
.vc_tta.vc_tta-tabs.cata-tabs.cata-style33 .vc_tta-tabs-list .vc_tta-tab .vc_tta-title-text,
.vc_tta.vc_tta-tabs.cata-tour.cata-style1 .vc_tta-tabs-container .vc_tta-tab>a,
.vc_tta.vc_tta-tabs.cata-tour.cata-style2 .vc_tta-tabs-container .vc_tta-tab>a,
.vc_tta.vc_tta-accordion.cata-accordion .vc_tta-panel .vc_tta-panel-title>a .vc_tta-title-text
{
	font-family:'<?php echo esc_attr($catanis_optdata['page_header_subtitle_font_family']);?>', sans-serif;
}

<?php /*=== FONT "Playfair Display" ===*/?>
body.error404 article h1,
.cata-page-title .page-header-wrap .pagetitle-contents .heading-title.page-title,
body.coming-soon #main-container-wrapper .cata-large-title,
/*shortcode*/
.cata-iconbox.cata-style4 .number{
    font-family:'<?php echo esc_attr($catanis_optdata['page_header_font_family']);?>';
}


<?php /*=== FONT "Raleway" ===*/?>
.cata-blog-item .post-quote a:last-child,
body.error404 article h3,
body.coming-soon.v2 #main-container-wrapper .cata-large-title,
/*shortcode*/
h3.heading-title.style1 span i,
h3.heading-title.style3 i,
.cata-project-detail .cata-project-info .project-info h5,
.cata-video-title,
.cata-callaction .content-wrapper h4{
	font-family: '<?php echo esc_attr($catanis_optdata['body_font_family']);?>';
}
