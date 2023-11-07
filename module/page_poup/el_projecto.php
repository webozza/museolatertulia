<?php
$page_id = 4450;

$page = get_post($page_id);

if ($page) {
    ?>
    <div class="thumbnail">
        <?php
        if (has_post_thumbnail($page->ID)) {
            echo get_the_post_thumbnail($page->ID, 'large');
        }
        ?>
    </div>
    <div class="content"><?= $page->post_content ?></div>
    <?php
} else {
    echo 'Page not found';
}
?>
