<?php
$args = array(
    'post_type' => 'obra',
    'posts_per_page' => -1,
);

$query = new WP_Query($args);

?>
<div class="my-masonry-grid">
    
<div class="popup-box">
      <div class="img">
        <img src="el.jpg" alt="" />
      </div>
      <div class="navigation">
        <div class="plus"><img src="popUpIcon/icono-plus.png" alt="" /></div>
        <div class="cross"><img src="popUpIcon/icono-x.png" alt="" /></div>
        <div class="zoom"><img src="popUpIcon/icono-lupa+.png" alt="" /></div>
        <div class="document"><img src="popUpIcon/icono-documentos.png" alt="" /></div>
      </div>
      <div class="documentWindow">

      </div>
    </div>
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

