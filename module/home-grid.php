<?php
$args = array(
    'post_type' => 'obra',
    'posts_per_page' => -1,
);

$query = new WP_Query($args);

?>

<div class="popup-box  zoom-container">
        <div class="pre-loader">
            <img src="<?= get_stylesheet_directory_uri(  )?>/popUpIcon/loading.gif" alt="">
        </div>
        <div class="img ">
            <img class="main_image" src="" alt="" id="zoom-image">
        </div>
      <div class="navigation">
        <div class="plus"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-plus.png" alt="" /></div>
        <div class="cross"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-x.png" alt="" /></div>
        <div class="zoom"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-lupa+.png" alt="" /></div>
        <div class="zoomOut"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-minus.png" alt="" /></div>
        <div class="document"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-documentos.png" alt="" /></div>
      </div>
      <div class="info">
        <p ><strong><span class="title"></span></strong></p>
        <p ><strong><span class="author"></span></strong></p>
        <br>
        <p><span class="dimension"></span></p>
        <p><span class="edition"></span></p>
        <p><strong>Técnica : </strong><span class="technique"></span></p>
        <p><strong>Nacionalidad : </strong><span class="nationality"></span></p>
        <br>
        <p ><strong>Categoría : </strong><span class="catagories"></span></p>
        <p ><strong>TAGS : </strong><span class="tags"></span></p>
        <br>
        <p ><strong>Tipo Documental : </strong><span class="documents"></span></p>
        <p><strong>Fuente y notas: : </strong><span class="source"></span></p>
        <br>
        <p><strong>Otras colecciones : </strong><span class="other-ducuments"></span></p>
      </div>
      <div class="documentWindow">
        <div class="documentData sidebar-grid">
        
        </div>
        <div class="documentSingleImage zoom-container"></div>
        <div class="documentWindowNav">
                <div class="closedocumentWindow"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-x.png" alt="" /></div>
                <div class="backArrow"><img src="<?= get_stylesheet_directory_uri(); ?>/popUpIcon/icono _-.png" alt=""></div>
                <div class="documnetImgzoom"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-lupa+.png" alt="" /></div>
                <div class="documentWindowZoomout"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-minus.png" alt="" /></div>
        </div>
      </div>
    </div>

<div class="my-masonry-grid">
    
    <?php if ($query->have_posts()) : ?>
    <?php while ($query->have_posts()) : $query->the_post(); ?>
    <?php
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

