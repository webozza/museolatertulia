<?php
if (!defined('_T_VERSION')) {
    define('_T_VERSION', '1.0.50');
}


error_reporting(E_ALL);
    ini_set('display_errors', 1);

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles() {
    $parenthandle = 'parent-style'; 
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

function gridJs() {
    wp_enqueue_script('gridJs', get_stylesheet_directory_uri() . '/js/grid.js', array('jquery'), _T_VERSION, true);
}
add_action('wp_enqueue_scripts', 'gridJs');


//===================================
//                              Add shortcode 
//===================================

function homeGrid() {
    include(get_stylesheet_directory() . '/template/home-grid.php');
}
add_shortcode('home_grid', 'homeGrid');

function map() {
    include(get_stylesheet_directory() . '/module/map.php');
}
add_shortcode('map', 'map');

//===================================
//                              Filter Home Grid 
//===================================


function my_ajax_action() {
    $parentMenu = $_POST['parentMenu'];
    $menuId_with_underscore = $_POST['id'];
    $menuId = str_replace( '_' , ' ' , $menuId_with_underscore);

    $data = 'Data fetched from the server'; 

    $args = array(
        'post_type' => 'obra',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => $parentMenu,
                'value' => $menuId,
                'compare' => '=',
            ),
        ),
    );
    $query = new WP_Query($args);

    ?>
            <?php if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php $post_id = get_the_ID();?>
                    <div class="my-masonry-grid-item">
                        <?php the_post_thumbnail('large',
                            array(
                                        'class' => 'clickable-thumbnail',
                                        'data-post-id' => $post_id, 
                            ));
                        ?>
                    </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            <?php else : ?>
            <p>No posts found.</p>
            <?php endif; ?>
    <?php


    wp_die();
}



add_action('wp_ajax_my_ajax_action', 'my_ajax_action');
add_action('wp_ajax_nopriv_my_ajax_action', 'my_ajax_action');



// 


function mapData() {
    $date = $_POST['date'];
    $key = $_POST['key'];

    $args = array(
        'post_type' => 'obra',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'obra-nacionalidad',
                'value' => 'Brasil',
                'compare' => '=',
            ),
        ),
    );
    $query = new WP_Query($args);

    ?>
            <?php if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php $post_id = get_the_ID();?>
                    <div class="my-masonry-grid-item">
                        <?php the_post_thumbnail('large',
                            array(
                                'class' => 'clickable-thumbnail',
                                'data-post-id' => $post_id, 
                            ));
                        ?>
                    </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            <?php else : ?>
            <p>No posts found.</p>
            <?php endif; ?>
    <?php


    wp_die();
}



add_action('wp_ajax_mapData', 'mapData');
add_action('wp_ajax_nopriv_mapData', 'mapData');



//===================================
//             Filter map Grid 
//===================================


function filterData() {
    $key = $_POST['key'];
    $menuId_with_underscore = $_POST['value'];
    $value = str_replace( '_' , ' ' , $menuId_with_underscore);

    $data = 'Data fetched from the server'; 

    $args = array(
        'post_type' => 'obra',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => $key,
                'value' => $value,
                'compare' => '=',
            ),
        ),
    );
    $query = new WP_Query($args);

    ?>
            <?php if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php $post_id = get_the_ID();?>
                    <div class="my-masonry-grid-item">
                        <?php the_post_thumbnail('large',
                            array(
                                        'class' => 'clickable-thumbnail',
                                        'data-post-id' => $post_id, 
                            ));
                        ?>
                    </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            <?php else : ?>
            <p>No posts found.</p>
            <?php endif; ?>
    <?php


    wp_die();
}



add_action('wp_ajax_filterData', 'filterData');
add_action('wp_ajax_nopriv_filterData', 'filterData');


// back to default grid 

function defaultGrid() {

    $args = array(
        'post_type' => 'obra',
        'posts_per_page' => -1,
    );
    $query = new WP_Query($args);

    ?>
            <?php if ($query->have_posts()) : ?>
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php $post_id = get_the_ID();?>
                        <div class="my-masonry-grid-item">
                            <?php the_post_thumbnail('large',
                                array(
                                    'class' => 'clickable-thumbnail',
                                    'data-post-id' => $post_id, 
                                ));
                            ?>
                        </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
                <?php else : ?>
                <p>No posts found.</p>
            <?php endif; ?>
    <?php


    wp_die();
}



add_action('wp_ajax_defaultGrid', 'defaultGrid');
add_action('wp_ajax_nopriv_defaultGrid', 'defaultGrid');


function catagoryFilter(){
    $id = $_POST['id'];
    $args = array(
        'post_type' => 'obra',
        'posts_per_page' => -1,
        'tax_query' => array(  // Use 'tax_query' instead of 'meta_query'
            array(
                'taxonomy' => 'categoria',
                'field' =>'term_id',  
                'terms' => $id,
            ),
        ),
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            ?>
            <div class="my-masonry-grid-item">
                <?php the_post_thumbnail('large',
                    array(
                        'class' => 'clickable-thumbnail',
                        'data-post-id' => $post_id,
                    ));
                ?>
            </div>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo 'No posts found.';
    }
    wp_die();
}

add_action('wp_ajax_catagoryFilter', 'catagoryFilter');
add_action('wp_ajax_nopriv_catagoryFilter', 'catagoryFilter');

 