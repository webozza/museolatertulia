<?php
$slug = 'el-projecto';

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
    <div class="content">
        <div class="page-title">
            <h2><?=  $page->post_title ?></h2>
            <div class="divider"></div>
        </div>
        <div class="page-body"><?=  $page->post_content ?></div>
    </div>
    <?php
} else {
    echo 'Page not found';
}
?>
