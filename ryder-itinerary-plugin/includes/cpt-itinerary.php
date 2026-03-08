<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'ryder_register_itinerary_cpt' );
function ryder_register_itinerary_cpt() {
    $labels = array(
        'name'                  => _x( 'Itineraries', 'Post Type General Name', 'ryder' ),
        'singular_name'         => _x( 'Itinerary', 'Post Type Singular Name', 'ryder' ),
        'menu_name'             => __( 'Itineraries', 'ryder' ),
        'name_admin_bar'        => __( 'Itinerary', 'ryder' ),
        'archives'              => __( 'Itinerary Archives', 'ryder' ),
        'attributes'            => __( 'Itinerary Attributes', 'ryder' ),
        'parent_item_colon'     => __( 'Parent Itinerary:', 'ryder' ),
        'all_items'             => __( 'All Itineraries', 'ryder' ),
        'add_new_item'          => __( 'Add New Itinerary', 'ryder' ),
        'add_new'               => __( 'Add New', 'ryder' ),
        'new_item'              => __( 'New Itinerary', 'ryder' ),
        'edit_item'             => __( 'Edit Itinerary', 'ryder' ),
        'update_item'           => __( 'Update Itinerary', 'ryder' ),
        'view_item'             => __( 'View Itinerary', 'ryder' ),
        'view_items'            => __( 'View Itineraries', 'ryder' ),
        'search_items'          => __( 'Search Itinerary', 'ryder' ),
        'not_found'             => __( 'Not found', 'ryder' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'ryder' ),
    );
    $args = array(
        'label'                 => __( 'Itinerary', 'ryder' ),
        'description'           => __( 'Ryder Signature Itineraries', 'ryder' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-location-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    );
    register_post_type( 'itinerary', $args );
}
