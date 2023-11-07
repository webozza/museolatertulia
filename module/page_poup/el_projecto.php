<?php
$slug = 'el-projecto'; // Replace with the slug of the page you want to retrieve

$page = get_page_by_path($slug);

if ($page) {
    echo '<h1>' . $page->post_title . '</h1>'; // Display the page title
    echo apply_filters('the_content', $page->post_content); // Display the page content
} else {
    echo 'Page not found';
}
?>
