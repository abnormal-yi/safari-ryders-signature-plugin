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
