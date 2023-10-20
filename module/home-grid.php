<?php
$args = array(
    'post_type' => 'obra',
    'posts_per_page' => -1,
);

$query = new WP_Query($args);

?>

<div class="popup-box">
        <div class="pre-loader">
            <img src="<?= get_stylesheet_directory_uri(  )?>/popUpIcon/loading.gif" alt="">
        </div>
      <div class="img">
        <img class="main_image" src="" alt="" />
      </div>
      <div class="navigation">
        <div class="plus"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-plus.png" alt="" /></div>
        <div class="cross"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-x.png" alt="" /></div>
        <div class="zoom"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-lupa+.png" alt="" /></div>
        <div class="document"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-documentos.png" alt="" /></div>
      </div>
      <div class="info">
        <p class="title"></p>
        <p class="author"></p>
        <p class="technical-date"></p>
        <p class="year"></p>
        <p class="catagories"></p>
        <p class="country"></p>
        <p class="tags"></p>
      </div>
      <div class="documentWindow">

      </div>
    </div>

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
</div>

