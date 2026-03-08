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
require_once RYDER_ITINERARY_PLUGIN_DIR . 'includes/cpt-itinerary.php';
require_once RYDER_ITINERARY_PLUGIN_DIR . 'includes/shortcode.php';

// Force custom template for single itinerary
add_filter( 'single_template', 'ryder_itinerary_force_template' );
function ryder_itinerary_force_template( $single_template ) {
    global $post;
    if ( $post->post_type === 'itinerary' ) {
        $plugin_template = RYDER_ITINERARY_PLUGIN_DIR . 'templates/single-itinerary.php';
        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }
    }
    return $single_template;
}
