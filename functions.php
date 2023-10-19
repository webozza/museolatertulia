<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
	$parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
	$theme        = wp_get_theme();
	wp_enqueue_style( $parenthandle,
		get_template_directory_uri() . '/style.css',
		array(), 
		$theme->parent()->get( 'Version' )
	);
	wp_enqueue_style( 'child-style',
		get_stylesheet_uri(),
		array( $parenthandle ),
		$theme->get( 'Version' ) // This only works if you have Version defined in the style header.
	);
}


function custom_image_sizes() {
    add_image_size('custom-masonry-thumbnail', 300, 200, true); // Replace dimensions as needed
}
add_action('after_setup_theme', 'custom_image_sizes');


// connect js file 

function mainJs() {
    wp_enqueue_script('mainJs', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'mainJs');

// create short code 

function homeGrid() {
    include(get_stylesheet_directory() . '/module/home-grid.php');
} 
add_shortcode('home_grid', 'homeGrid'); 