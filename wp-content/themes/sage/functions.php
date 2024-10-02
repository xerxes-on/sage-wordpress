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

if (! file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
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

if (! function_exists('\Roots\bootloader')) {
    wp_die(
        __('You need to install Acorn to use this theme.', 'sage'),
        '',
        [
            'link_url' => 'https://roots.io/acorn/docs/installation/',
            'link_text' => __('Acorn Docs: Installation', 'sage'),
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


collect(['setup', 'filters'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });

function sv_theme_scripts(): void {
    wp_enqueue_style( 'output', get_template_directory_uri() . '/style.css', array() );
}
add_action( 'wp_enqueue_scripts', 'sv_theme_scripts' );

add_filter('wp_title', 'display_message_after_title', 10, 2);

function display_message_after_title($title, $sep) {
    if (is_home() || is_front_page()) {
        $title .= '-> ' . 'You are on homepage';
    }
    return $title;
}

function learn_more($more) {
    if (!is_single() && (is_archive() || is_home())) {
        global $post;
        return '... <a href="' . get_permalink($post->ID) . '"
        class=" hover:text-blue-50 hover:text-lg">
        Learn More</a>';
    }
    return $more;
}
add_filter('excerpt_more', 'learn_more');

function critical_css():void {
    wp_enqueue_style( 'critical', get_template_directory_uri() . '/resources/styles/critical.css', );
}
add_action( 'wp_enqueue_scripts', 'critical_css' );

function load_assets_in_footer():void {
    wp_enqueue_style( 'styles', get_template_directory_uri() . '/resources/styles/styles.css', );
}
add_action( 'get_footer', 'load_assets_in_footer' );

function single_post_message($classes) {
    if (is_front_page() && is_home() && is_ssl()) {
        $classes[] = 'hey-dude-it-is-blog';
    }
    return $classes;
}
add_filter('body_class', 'single_post_message');

function add_one_day($output): string {
    $date = new DateTime($output);
    $date->modify('+1 day');
    return $date->format('Y-m-d');
}
add_filter('add_one_day_to_current_day', 'add_one_day');
function display_current_day_with_filter() {
    $current_day = date('Y-m-d');
    return apply_filters('add_one_day', $current_day);
}
add_shortcode('current_day', 'display_current_day_with_filter');
function allow_shortcodes_in_title($title): string {
    return do_shortcode($title);
}
add_filter('the_title', 'allow_shortcodes_in_title');



