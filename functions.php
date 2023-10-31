<?php
if (!defined('_T_VERSION')) {
    define('_T_VERSION', '1.0.9');
}

error_reporting(E_ALL);
    ini_set('display_errors', 1);

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



// filter grid 

function get_filtered_img() {
    $parentMenu = $_POST['parentMenu'];
    $menuId = $_POST['menuId'];

    // $art_nonce = $_POST['security']; // Retrieve the nonce value from the request

    // // Verify the nonce
    // if ( ! wp_verify_nonce($art_nonce, 'art_nonce') ) {
    //     // Nonce is invalid; handle the request accordingly, e.g., deny access.
    //     wp_die('Invalid nonce.');
    // }

    // $args = array(
    //     'post_type' => 'obra',
    //     'posts_per_page' => -1,
    //     'meta_query' => array(
    //         array(
    //             'key' => $parentMenu,
    //             // 'value' => $menuId,
    //         ),
    //     ),
    // );

    // $query = new WP_Query($args);

    // if ($query->have_posts()) {
    //     while ($query->have_posts()) {
    //         $query->the_post();
    //         the_title();
    //     }
    // } else {
    //     echo 'No posts found.';
    // }

    echo $parentMenu;

    wp_reset_postdata();

    wp_die();
}
add_action('wp_ajax_get_filtered_img', 'get_filtered_img');

