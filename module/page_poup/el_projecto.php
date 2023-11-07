<?php
$page_id = 4450;

$page = get_post($page_id);

if ($page) {
    // Display the page title
    echo '<h1>' . $page->post_title . '</h1>';

    // Display the post thumbnail
    if (has_post_thumbnail($page->ID)) {
        echo get_the_post_thumbnail($page->ID, 'large'); // 'large' is the image size, change it if needed
    }

    // Display the page content
    echo $page->post_content;
} else {
    echo 'Page not found';
}
?>
