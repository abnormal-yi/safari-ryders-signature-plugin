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

// Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'ryder_itinerary_enqueue_scripts' );
function ryder_itinerary_enqueue_scripts() {
    global $post;
    
    // Check if we are on a single itinerary or a page with the shortcode
    if ( is_singular( 'itinerary' ) || ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'ryder_itinerary' ) ) ) {
        wp_enqueue_style( 'google-fonts-cormorant', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Jost:wght@300;400;500;600;700&display=swap', array(), null );
        wp_enqueue_style( 'leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
        wp_enqueue_style( 'ryder-itinerary-style', RYDER_ITINERARY_PLUGIN_URL . 'assets/css/itinerary.css', array(), '1.0.0' );
        
        wp_enqueue_script( 'leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
        wp_enqueue_script( 'ryder-itinerary-script', RYDER_ITINERARY_PLUGIN_URL . 'assets/js/itinerary.js', array('leaflet-js'), '1.0.0', true );
        
        // Pass dynamic map data to JS
        $post_id = is_singular( 'itinerary' ) ? get_the_ID() : 0;
        
        // If we have ACF installed, fetch the stops
        $stops = function_exists('get_field') ? get_field('ryder_map_stops', $post_id) : false;
        
        if ( ! $stops || empty($stops) ) {
            // Default static stops if ACF is empty
            $stops = array(
                array('id'=>'arusha', 'type'=>'city', 'day'=>'', 'name'=>'Arusha', 'lat'=>-3.3869, 'lng'=>36.6830, 'r'=>0),
                array('id'=>'tarangire', 'type'=>'park', 'day'=>'Day 2', 'name'=>'Tarangire N.P.', 'lat'=>-4.1629, 'lng'=>36.0899, 'r'=>50000),
                array('id'=>'ngorongoro', 'type'=>'park', 'day'=>'Days 3–4', 'name'=>'Ngorongoro Conservation', 'lat'=>-3.1618, 'lng'=>35.5877, 'r'=>27000),
                array('id'=>'serengeti', 'type'=>'park', 'day'=>'Days 4–5', 'name'=>'Serengeti N.P.', 'lat'=>-2.3333, 'lng'=>34.8333, 'r'=>92000)
            );
        }
        
        // Build route from stops
        $route = array();
        foreach($stops as $stop) {
            $route[] = array((float)$stop['lat'], (float)$stop['lng']);
        }
        // Add return to start
        if(count($route) > 0) {
            $route[] = $route[0];
        }
        
        wp_localize_script( 'ryder-itinerary-script', 'ryderItineraryData', array(
            'stops' => $stops,
            'route' => $route
        ) );
    }
}
