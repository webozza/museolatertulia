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
        <p ><strong> <span class="title"></span></strong></p>
        <p ><strong> <span class="author"></span></strong></p>
        <br>
        <p> <span class="dimension"></span></p>
        <p> <span class="edition"></span></p>
        <p><strong>Técnica : </strong> <span class="technique"></span></p>
        <p><strong>Nacionalidad : </strong> <span class="nationality"></span></p>
        <br>
        <p ><strong>Categoría : </strong> <span class="catagories"></span></p>
        <p ><strong>TAGS : </strong> <span class="tags"></span></p>
        <br>
        <p ><strong>Tipo Documental : </strong> <span class="documents"></span></p>
        <p><strong>Fuente y notas: : </strong> <span class="source"></span></p>
        <br>
        <p><strong>Otras colecciones : </strong> <span class="other-ducuments"></span></p>
      </div>
      <div class="documentWindow">
        <div class="documentData ">
          <div class="obra-documentos">
            <h3 ></h3>
            <div class="gallerie"></div>
          </div>
          <div class="obra-obra_participante_1">            
            <h3 ></h3>
            <div class="gallerie"></div></div>
          <div class="obra-obra_participante_2">
          <h3 ></h3>
            <div class="gallerie"></div>
          </div>
          <div class="obra-obra_participante_3">
          <h3 ></h3>
            <div class="gallerie"></div>
          </div>
          <div class="obra-obra_asociada_1">
          <h3 ></h3>
            <div class="gallerie"></div>
          </div>
          <div class="obra-obra_asociada_2">
          <h3 ></h3>
            <div class="gallerie"></div>
          </div>
          <div class="obra-obra_asociada_3">
          <h3 ></h3>
            <div class="gallerie"></div>
          </div>
        </div>
        <div class="documentSingleImage zoom-container">
        </div>
        <div class="documentWindowNav">
                <div class="closedocumentWindow"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-x.png" alt="" /></div>
                <div class="backArrow"><img src="<?= get_stylesheet_directory_uri(); ?>/popUpIcon/icono _-.png" alt=""></div>
                <div class="documentImgZoom"><img src="<?= get_stylesheet_directory_uri();?>/popUpIcon/icono-lupa+.png" alt="" /></div>
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

<script>

	jQuery(document).ready(function($) {
    $('.drop_down_menu').on('click', function() {
      let parentMenu = $(this).parent().parent().find('.parent_menu').attr('id');
      let id = $(this).attr('id');

			$.ajax({
				url: '/wp-admin/admin-ajax.php', 
				type: 'POST',
				data: {
					action: 'my_ajax_action',
					parentMenu: parentMenu,
          id : id ,
				},

				success: function(response) {
          console.log(response)
          $('.my-masonry-grid').html(response)
          $(".my-masonry-grid").masonryGrid({
            columns: 6,
          });
          ImgPopupFunction()
				}
			});
		});


//----------------------

    function ImgPopupFunction(){
    $(".clickable-thumbnail").on("click", function () {

      const postID = $(this).data("post-id");
      const restApiUrl = `/wp-json/wp/v2/obra/${postID}?_embed`;
      
      $(".popup-box").show();
      $(".pre-loader").show();
      $(".main_image").hide();
      
      $.ajax({
        url: restApiUrl,
        type: "GET",
        dataType: "json",
        success: function(postData) {
          console.log('post data', postData);
          
          if (postData._embedded && postData._embedded["wp:featuredmedia"] && postData._embedded["wp:featuredmedia"][0]) {
            const featuredMedia = postData._embedded["wp:featuredmedia"][0];
            const imgUrl = featuredMedia.source_url; 
            $(".main_image").attr("src", imgUrl);
      
            const image = new Image();
            image.src = imgUrl;
            image.onload = function() {
              $(".main_image").fadeIn("slow");
              $(".pre-loader").fadeOut("slow");
              makeZoom();
            };
          } else {
            console.error("No featured image found for the post.");
          }
        },
        error: function(error) {
          console.error("Error fetching post details:", error);
        },
      });
      
      
      
      $.ajax({
        url: restApiUrl,
        type: "GET",
        dataType: "json",
        success: function async(data) {
          console.log(data);
          // Populate the info elements
          $(".info .title").text(data.acf["obra-titulo_denominacion"]);
          $(".info .author").text(data.acf["obra-nombre_completo"]);
          $(".info .dimension").text(data.acf["obra-dimensiones"]);
          $(".info .edition").text(data.acf["obra-edicion"]);
          $(".info .technique").text(data.acf["obra-tecnica_materiales"]);
          $(".info .nationality").text(data.acf["obra-nacionalidad"]);
  
          // Fetch post categories  here leter*****
  
          $(".info .categories").text();
          $(".info .tags").text();
  
          $(".info .documents").text(data.acf["obra-documentos"]);
          $(".info .source").text(data.acf["obra-fuente_y_notas"]);
          
  
          //------------------------------------------------------
  
          let appnedSidebarGalleries = (fieldName, containerClass) => {
            const imageIds = data.acf[fieldName];
            const $imageContainer = $(containerClass).find('.gallerie'); // Select the container with jQuery
            console.log('imageContainer', $imageContainer);
          
            if (Array.isArray(imageIds)) {
              const imageCount = imageIds.length;
              let loadedImages = 0;
          
              imageIds.forEach((imageId) => {
                $.ajax({
                  url: `/wp-json/wp/v2/media/${imageId}`,
                  type: "GET",
                  dataType: "json",
                  success: function (imageData) {
                    console.log('imageData', imageData);
                    const semiHighResURL = imageData.media_details.sizes.large.source_url;
                    const highResImgURL = imageData.source_url;
                    const imgTag = `<div class="documentImg sidebar-grid-item">
                      <img
                        src="${semiHighResURL}" 
                        data-highres="${highResImgURL}"
                        id="${imageData.id}">
                    </div>`;
                    $imageContainer.find('h3').text('Heading'); // Use $imageContainer to find elements
                    $imageContainer.append(imgTag);
                    loadedImages++;
                    if (loadedImages === imageCount) {
                      $imageContainer.masonryGrid({
                        columns: 3,
                      });
                    }
                    handleDocumentSingleImage();
                  },
                  error: function (error) {
                    console.error("Error fetching image data:", error);
                  },
                });
              });
            } else {
              console.error(`"${fieldName}" is not an array of image IDs.`);
            }
          };
          
          appnedSidebarGalleries("obra-documentos", ".obra-documentos");
          
          appnedSidebarGalleries("obra-obra_participante_1", ".obra-obra_participante_1");
          
          //------------------------------------------------------
        },
  
        error: function (error) {
          console.error("Error fetching post data:", error);
        },
      });
    });
  
  } 

  //------------------
	});

</script>