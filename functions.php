<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
	$parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
	$theme        = wp_get_theme();
	wp_enqueue_style( $parenthandle,
		get_template_directory_uri() . '/style.css',
		array(),  // If the parent theme code has a dependency, copy it to here.
		$theme->parent()->get( 'Version' )
	);
	wp_enqueue_style( 'child-style',
		get_stylesheet_uri(),
		array( $parenthandle ),
		$theme->get( 'Version' ) // This only works if you have Version defined in the style header.
	);
}


function homeGrid() {
    include(get_stylesheet_directory() . '/module/home-grid.php');
}

add_shortcode('home_grid', 'homeGrid'); 

function enqueue_masonry() {
    wp_enqueue_script('masonry', 'https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js', array('jquery'), '4.2.2', true);
}
add_action('wp_enqueue_scripts', 'enqueue_masonry');


function custom_theme_image_sizes() {
    add_image_size('small-thumbnail', 150, 150, true);
}

add_action('after_setup_theme', 'custom_theme_image_sizes');
