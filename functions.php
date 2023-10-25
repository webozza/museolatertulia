<?php
if (!defined('_T_VERSION')) {
    define('_T_VERSION', '1.0.1');
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles() {
    $parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme = wp_get_theme();
    wp_enqueue_style($parenthandle,
        get_template_directory_uri() . '/style.css',
        array(),
        $theme->parent()->get('Version')
    );
    wp_enqueue_style('child-style',
        get_stylesheet_uri(),
        array($parenthandle),
        _T_VERSION
    );
}

function add_custom_mime_types($mimes) {
    $mimes['woff'] = 'application/font-woff';
    $mimes['woff2'] = 'application/font-woff2';
    return $mimes;
}
add_filter('upload_mimes', 'add_custom_mime_types');

function custom_image_sizes() {
    add_image_size('custom-masonry-thumbnail', 300, 200, true); // Replace dimensions as needed
}
add_action('after_setup_theme', 'custom_image_sizes');

function mainJs() {
    wp_enqueue_script('mainJs', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), _T_VERSION, true);
}
add_action('wp_enqueue_scripts', 'mainJs');

function homeGrid() {
    include(get_stylesheet_directory() . '/module/home-grid.php');
}
add_shortcode('home_grid', 'homeGrid');
