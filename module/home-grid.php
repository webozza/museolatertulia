<?php
$args = array(
    'post_type' => 'obra',
    'posts_per_page' => 20,
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        ?>
        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'small-thumbnail'); ?>" >
        <?php
    }
    wp_reset_postdata();
} else {
    echo 'No posts found.';
}
?>
