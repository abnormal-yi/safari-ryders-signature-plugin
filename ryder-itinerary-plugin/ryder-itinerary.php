<?php
/**
 * Plugin Name: Ryder Signature Itineraries
 * Description: Custom Post Type, ACF fields, and Shortcode for Ryder Signature Itineraries.
 * Version: 1.0.0
 * Author: AI Assistant
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'RYDER_ITINERARY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RYDER_ITINERARY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include core files
require_once RYDER_ITINERARY_PLUGIN_DIR . 'includes/cpt-safaris.php';
require_once RYDER_ITINERARY_PLUGIN_DIR . 'includes/shortcode.php';

// Automatically load ACF fields from JSON
add_action( 'acf/init', 'ryder_itinerary_load_acf_fields' );
function ryder_itinerary_load_acf_fields() {
    $json_file = RYDER_ITINERARY_PLUGIN_DIR . 'acf-fields.json';
    if ( file_exists( $json_file ) ) {
        $json_data = file_get_contents( $json_file );
        $field_groups = json_decode( $json_data, true );
        if ( $field_groups ) {
            foreach ( $field_groups as $group ) {
                acf_add_local_field_group( $group );
            }
        }
    }
}

// Force custom template for single safaris
add_filter( 'single_template', 'ryder_itinerary_force_template' );
function ryder_itinerary_force_template( $single_template ) {
    global $post;
    if ( $post->post_type === 'safaris' ) {
        $plugin_template = RYDER_ITINERARY_PLUGIN_DIR . 'templates/single-safaris.php';
        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }
    }
    return $single_template;
}
