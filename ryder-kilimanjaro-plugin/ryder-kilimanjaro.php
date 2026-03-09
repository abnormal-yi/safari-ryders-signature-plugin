<?php
/**
 * Plugin Name: Ryder Signature Kilimanjaro
 * Description: Custom Post Type and Shortcode for Ryder Signature Kilimanjaro Routes.
 * Version: 1.0.0
 * Author: AI Assistant
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'RYDER_KILIMANJARO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RYDER_KILIMANJARO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include core files
require_once RYDER_KILIMANJARO_PLUGIN_DIR . 'includes/cpt-kilimanjaro.php';
require_once RYDER_KILIMANJARO_PLUGIN_DIR . 'includes/shortcode-kilimanjaro.php';

// Automatically load ACF fields from JSON
add_action( 'acf/init', 'ryder_kilimanjaro_load_acf_fields' );
function ryder_kilimanjaro_load_acf_fields() {
    $json_file = RYDER_KILIMANJARO_PLUGIN_DIR . 'acf-fields.json';
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

// Force custom template for single kilimanjaro
add_filter( 'single_template', 'ryder_kilimanjaro_force_template' );
function ryder_kilimanjaro_force_template( $single_template ) {
    global $post;
    if ( $post->post_type === 'kilimanjaro' ) {
        $plugin_template = RYDER_KILIMANJARO_PLUGIN_DIR . 'templates/single-kilimanjaro.php';
        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }
    }
    return $single_template;
}
