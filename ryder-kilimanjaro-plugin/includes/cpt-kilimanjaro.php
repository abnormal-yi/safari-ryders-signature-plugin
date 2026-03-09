<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'ryder_register_kilimanjaro_cpt' );
function ryder_register_kilimanjaro_cpt() {
    $labels = array(
        'name'                  => _x( 'Kilimanjaro Routes', 'Post Type General Name', 'ryder' ),
        'singular_name'         => _x( 'Kilimanjaro Route', 'Post Type Singular Name', 'ryder' ),
        'menu_name'             => __( 'Kilimanjaro', 'ryder' ),
        'name_admin_bar'        => __( 'Kilimanjaro Route', 'ryder' ),
        'archives'              => __( 'Route Archives', 'ryder' ),
        'attributes'            => __( 'Route Attributes', 'ryder' ),
        'parent_item_colon'     => __( 'Parent Route:', 'ryder' ),
        'all_items'             => __( 'All Routes', 'ryder' ),
        'add_new_item'          => __( 'Add New Route', 'ryder' ),
        'add_new'               => __( 'Add New', 'ryder' ),
        'new_item'              => __( 'New Route', 'ryder' ),
        'edit_item'             => __( 'Edit Route', 'ryder' ),
        'update_item'           => __( 'Update Route', 'ryder' ),
        'view_item'             => __( 'View Route', 'ryder' ),
        'view_items'            => __( 'View Routes', 'ryder' ),
        'search_items'          => __( 'Search Route', 'ryder' ),
        'not_found'             => __( 'Not found', 'ryder' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'ryder' ),
    );
    $args = array(
        'label'                 => __( 'Kilimanjaro Route', 'ryder' ),
        'description'           => __( 'Ryder Signature Kilimanjaro Routes', 'ryder' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-location-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
        'rewrite'               => array( 'slug' => 'kilimanjaro' ),
    );
    register_post_type( 'kilimanjaro', $args );
}
