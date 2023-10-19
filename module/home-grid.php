<?php
$args = array(
    'post_type' => 'obra',
    'posts_per_page' => -1,
);

$query = new WP_Query($args);

?>
<div class="my-masonry-grid">
    <?php
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        ?>
<div class="my-masonry-grid-item">
    <?php
        the_post_thumbnail('large');
    ?>
</div>
    <?php
    }
    wp_reset_postdata();
} else {
    echo 'No posts found.';
}

?>
</div>
