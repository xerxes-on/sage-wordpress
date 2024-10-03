<?php
/**
 * Plugin Name: my_custom_plugin
 * Plugin URI: http://sage.ddev.site
 * Description: Plugin is under Development and created in educational purposes only
 * Version: 1.0
 * Author: Xerxes
 * Author URI: https://xerxes.uz
 **/

add_action( 'init', 'my_custom_post_types' );

function my_custom_post_types(): void {
    // Register the first custom post type (public)
    $args1 = array(
        'labels'       => array(
            'name'          => __( 'My Custom Type 1' ),
            'singular_name' => __( 'My Custom Type 1' ),
        ),
        'public'       => true, // Public post type
        'has_archive'  => true,
        'show_in_rest' => true, // Enable Gutenberg support
        'supports'     => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon'    => 'dashicons-admin-post',
    );
    register_post_type( 'my-custom-type-1', $args1 );

    // Register the second custom post type (private)
    $args2 = array(
        'labels'              => array(
            'name'          => __( 'My Custom Type 2' ),
            'singular_name' => __( 'My Custom Type 2' ),
        ),
        'public'              => false, // Private post type
        'exclude_from_search' => true,
        'show_ui'             => true, // Show in the admin interface
        'show_in_menu'        => true, // Show in admin menu
        'show_in_rest'        => true, // Enable Gutenberg support
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon'           => 'dashicons-hidden',
    );
    register_post_type( 'my-custom-type-2', $args2 );
}

