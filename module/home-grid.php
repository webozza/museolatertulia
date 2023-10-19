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
            the_post_thumbnail('large')
    ?>
</div>
    <?php
    }
    wp_reset_postdata();
} else {
    echo 'No posts found.';
}

function compress_image($source_path, $destination_path, $quality = 75) {
    $info = getimagesize($source_path);
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source_path);
        imagejpeg($image, $destination_path, $quality);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source_path);
        imagepng($image, $destination_path, $quality);
    } else {
        return false;
    }

    imagedestroy($image);
    return true;
}

// Usage
$source_path = 'path/to/original-image.jpg';
$destination_path = 'path/to/compressed-image.jpg';
compress_image($source_path, $destination_path);
?>
</div>
