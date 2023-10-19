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


<!-- <?php
$args = array(
    'post_type' => 'obra',
    'posts_per_page' => -1,
);

$query = new WP_Query($args);

?>
<div class="my-masonry-grid">
    <?php if ($query->have_posts()) : ?>
    <?php while ($query->have_posts()) : $query->the_post(); ?>
    <?php
            // Get the post ID
            $post_id = get_the_ID();
            ?>
    <div class="my-masonry-grid-item">
        <?php the_post_thumbnail('large', array(
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
</div> -->