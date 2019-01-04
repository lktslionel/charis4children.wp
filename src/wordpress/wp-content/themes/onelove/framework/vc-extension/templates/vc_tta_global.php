<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $this WPBakeryShortCode_VC_Tta_Accordion|WPBakeryShortCode_VC_Tta_Tabs|WPBakeryShortCode_VC_Tta_Tour|WPBakeryShortCode_VC_Tta_Pageable
 */
$el_class = $css = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->resetVariables( $atts, $content );
extract( $atts );

$this->setGlobalTtaInfo();

$this->enqueueTtaStyles();
$this->enqueueTtaScript();

/* It is required to be before tabs-list-top/left/bottom/right for tabs/tours */
$prepareContent = $this->getTemplateVariable( 'content' );


/* CATANIS CUSTOM */
preg_match_all( '/vc_tta_section([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$main_style = empty($atts['main_style']) ? 'cols-' . count($matches[0]) : ' cols-'. count($matches[0]). ' cata-'. $atts['main_style'];
$curClass = get_class ($this);
if($curClass == 'WPBakeryShortCode_VC_Tta_Tour'){
	$main_style .= ' cata-tour'; 
	
}elseif($curClass == 'WPBakeryShortCode_VC_Tta_Accordion'){
	$main_style .= ' cata-accordion icon-' . $atts['icon_position']; 
}else{
	$main_style .= ' cata-tabs';
}
$main_style .= ' cata-tta';

$class_to_filter = $this->getTtaGeneralClasses() . ' ' . esc_attr($main_style);
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$output = '<div ' . $this->getWrapperAttributes() . '>';
$output .= $this->getTemplateVariable( 'title' );
$output .= '<div class="' . esc_attr( $css_class ) . '">';
$output .= $this->getTemplateVariable( 'tabs-list-top' );
$output .= $this->getTemplateVariable( 'tabs-list-left' );
$output .= '<div class="vc_tta-panels-container">';
$output .= $this->getTemplateVariable( 'pagination-top' );
$output .= '<div class="vc_tta-panels">';
$output .= $prepareContent;
$output .= '</div>';
$output .= $this->getTemplateVariable( 'pagination-bottom' );
$output .= '</div>';
$output .= $this->getTemplateVariable( 'tabs-list-bottom' );
$output .= $this->getTemplateVariable( 'tabs-list-right' );
$output .= '</div>';
$output .= '</div>';

echo ($output);
