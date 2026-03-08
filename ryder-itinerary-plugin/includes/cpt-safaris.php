<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'ryder_register_safaris_cpt' );
function ryder_register_safaris_cpt() {
    $labels = array(
        'name'                  => _x( 'Safaris', 'Post Type General Name', 'ryder' ),
        'singular_name'         => _x( 'Safari', 'Post Type Singular Name', 'ryder' ),
        'menu_name'             => __( 'Safaris', 'ryder' ),
        'name_admin_bar'        => __( 'Safari', 'ryder' ),
        'archives'              => __( 'Safari Archives', 'ryder' ),
        'attributes'            => __( 'Safari Attributes', 'ryder' ),
        'parent_item_colon'     => __( 'Parent Safari:', 'ryder' ),
        'all_items'             => __( 'All Safaris', 'ryder' ),
        'add_new_item'          => __( 'Add New Safari', 'ryder' ),
        'add_new'               => __( 'Add New', 'ryder' ),
        'new_item'              => __( 'New Safari', 'ryder' ),
        'edit_item'             => __( 'Edit Safari', 'ryder' ),
        'update_item'           => __( 'Update Safari', 'ryder' ),
        'view_item'             => __( 'View Safari', 'ryder' ),
        'view_items'            => __( 'View Safaris', 'ryder' ),
        'search_items'          => __( 'Search Safari', 'ryder' ),
        'not_found'             => __( 'Not found', 'ryder' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'ryder' ),
    );
    $args = array(
        'label'                 => __( 'Safari', 'ryder' ),
        'description'           => __( 'Ryder Signature Safaris', 'ryder' ),
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
        'rewrite'               => array( 'slug' => 'safaris' ),
    );
    register_post_type( 'safaris', $args );
}
