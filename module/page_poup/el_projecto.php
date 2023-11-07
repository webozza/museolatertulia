<?php
$slug = 'el-projecto'; // Replace with the slug of the page you want to retrieve

$page = get_page_by_path($slug);

if ($page) {
    ?>
    <div class="thumbnail">
        <?php
        if (has_post_thumbnail($page->ID)) {
            echo get_the_post_thumbnail($page->ID, 'large');
        }
        ?>
    </div>
    <div class="content"><?= $apply_filters('the_content', $page->post_content); ?></div>
    <?php
} else {
    echo 'Page not found';
}
?>
