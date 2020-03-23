<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('charity_is_hope_contact_form_7_theme_setup')) {
    add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_contact_form_7_theme_setup', 1 );
    function charity_is_hope_contact_form_7_theme_setup() {
        if (is_admin()) {
            add_filter( 'charity_is_hope_filter_required_plugins', 'charity_is_hope_contact_form_7_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'charity_is_hope_exists_contact_form_7' ) ) {
    function charity_is_hope_exists_contact_form_7() {
        return defined( 'Contact Form 7' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'charity_is_hope_contact_form_7_required_plugins' ) ) {
    //add_filter('charity_is_hope_filter_required_plugins',    'charity_is_hope_contact_form_7_required_plugins');
    function charity_is_hope_contact_form_7_required_plugins($list=array()) {
        if (in_array('contact_form_7', (array)charity_is_hope_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Contact Form 7', 'charity-is-hope'),
                'slug'         => 'contact-form-7',
                'required'     => false
            );
        return $list;
    }
}
