<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if ( ! file_exists( $composer = __DIR__ . '/vendor/autoload.php' ) ) {
    wp_die( __( 'Error locating autoloader. Please run <code>composer install</code>.', 'sage' ) );
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

if ( ! function_exists( '\Roots\bootloader' ) ) {
    wp_die(
        __( 'You need to install Acorn to use this theme.', 'sage' ),
        '',
        [
            'link_url'  => 'https://roots.io/acorn/docs/installation/',
            'link_text' => __( 'Acorn Docs: Installation', 'sage' ),
        ]
    );
}

\Roots\bootloader()->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/


collect( [ 'setup', 'filters' ] )
    ->each( function ( $file ) {
        if ( ! locate_template( $file = "app/{$file}.php", true, true ) ) {
            wp_die(
            /* translators: %s is replaced with the relative file path */
                sprintf( __( 'Error locating <code>%s</code> for inclusion.', 'sage' ), $file )
            );
        }
    } );

function sv_theme_scripts(): void {
    wp_enqueue_style( 'output', get_template_directory_uri() . '/style.css', array() );
}

add_action( 'wp_enqueue_scripts', 'sv_theme_scripts' );

add_filter( 'wp_title', 'display_message_after_title', 10, 2 );

function display_message_after_title( $title, $sep ) {
    if ( is_home() || is_front_page() ) {
        $title .= '-> ' . 'You are on homepage';
    }

    return $title;
}


add_filter( 'the_excerpt', function ( $excerpt ) {
    if ( ! is_single() && ( is_archive() || is_home() ) ) {
        global $post;

        return $excerpt . '<a href="' . get_permalink( $post->ID ) . '">
                                  Learn More</a>';
    }

    return $excerpt;
} );

function critical_css(): void {
    wp_enqueue_style( 'critical', get_template_directory_uri() . '/resources/styles/critical.css', );
}

add_action( 'wp_enqueue_scripts', 'critical_css' );


add_action( 'load_footer_assets', function () {
    wp_enqueue_style( 'footer-styles', get_template_directory_uri() . '/resources/styles/styles.css' );
} );
add_action( 'wp_footer', function () {
    do_action( 'load_footer_assets' );
} );

function single_post_message( $classes ) {
    if ( is_front_page() && is_home() && is_ssl() ) {
        $classes[] = 'hey-dude-it-is-blog';
    }

    return $classes;
}

add_filter( 'body_class', 'single_post_message' );

function add_one_day_function( $output ): string {
    $date = new DateTime( $output );
    $date->modify( '+1 day' );

    return $date->format( 'Y-m-d' );
}

add_filter( 'add_one_day', 'add_one_day_function' );
function display_current_day_with_filter() {
    $current_day = date( 'Y-m-d' );

    return apply_filters( 'add_one_day', $current_day );
}

add_shortcode( 'current_day', 'display_current_day_with_filter' );
function allow_shortcodes_in_title( $title ): string {
    return do_shortcode( $title );
}

add_filter( 'the_title', 'allow_shortcodes_in_title' );

//add a taxonomy

function create_my_custom_taxonomy(): void {
    $labels = array(
        'name'              => _x( 'My custom sections', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Section', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search sections', 'textdomain' ),
        'all_items'         => __( 'All sections', 'textdomain' ),
        'parent_item'       => __( 'Parent section', 'textdomain' ),
        'parent_item_colon' => __( 'Parent section:', 'textdomain' ),
        'edit_item'         => __( 'Edit section', 'textdomain' ),
        'update_item'       => __( 'Update section', 'textdomain' ),
        'add_new_item'      => __( 'Add New section', 'textdomain' ),
        'new_item_name'     => __( 'New sections name', 'textdomain' ),
        'menu_name'         => __( 'Custom Sections', 'textdomain' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_admin_column' => true,
        'query_var'         => true,
    );

    register_taxonomy( 'section', 'my-custom-type-1', $args );

    unset( $args );
    unset( $labels );

}

add_action( 'init', 'create_my_custom_taxonomy' );

if ( file_exists( get_template_directory() . '/options.php' ) ) {
    include get_template_directory() . '/options.php';
}
if ( file_exists( get_template_directory() . '/acf-custom-fields.php' ) ) {
    include get_template_directory() . '/acf-custom-fields.php';
}

// Handle the AJAX
/**
 * @throws Exception
 */
function get_time_in_locale(): void {
    if ( ! check_ajax_referer( 'get_time_nonce', 'nonce', false ) ) {
        wp_send_json_error( 'Invalid nonce' );

        return;
    }
    $timezone     = $_POST['locale'] ?? 'Asia/Tashkent';
    $current_time = wp_date( 'd-m-Y H:i:s', null, new DateTimeZone( $timezone ) );
    wp_send_json_success( $current_time );
}

add_action( 'wp_ajax_get_time_in_locale', 'get_time_in_locale' );
add_action( 'wp_ajax_nopriv_get_time_in_locale', 'get_time_in_locale' );

function enqueue_time_locale_scripts(): void {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'time-ajax', get_template_directory_uri() . '/resources/scripts/time-ajax.js', array( 'jquery' ),
        '1.0', true );
    wp_localize_script( 'time-ajax', 'timeAjax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'get_time_nonce' )
    ) );
}

add_action( 'wp_enqueue_scripts', 'enqueue_time_locale_scripts' );

//task 2
add_action( 'rest_api_init', function () {
    register_rest_route( 'task2', '/concat', [
            'methods'=> 'GET',
            'callback'=> function ( $request ) {
                    $string = $request['string_param'];
                    $int    = $request['int_param'];
                    return rest_ensure_response( $string . $int );
                },
            'permission_callback' => function ( $request ) {
                    return isset( $request['key'] ) && $request['key'] === 'very_secure_key';
                },
            'args'=> [
                'string_param' => [
                    'required' => true,
                    'type' => 'string',
                    'minLength' => 10
                ],
                'int_param'    => [
                    'required'          => true,
                    'type'              => 'integer',
                    'maximum'           => 123,
                ],
            ]
        ]
    );
} );

//https://sage.ddev.site/wp-json/task2/concat?string_param=This_is_my_string&int_param=120&key=my_key


