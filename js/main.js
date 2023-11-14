jQuery(document).ready(function ($) {
  



  //============================
  //                                PopUp
  //============================

  function ImgPopupFunction() {
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
        success: function (postData) {
          console.log("post data", postData);

          if (postData._embedded && postData._embedded["wp:featuredmedia"] && postData._embedded["wp:featuredmedia"][0]) {
            const featuredMedia = postData._embedded["wp:featuredmedia"][0];
            const imgUrl = featuredMedia.source_url;
            $(".main_image").attr("src", imgUrl);

            const image = new Image();
            image.src = imgUrl;
            image.onload = function () {
              $(".main_image").fadeIn("slow");
              $(".pre-loader").fadeOut("slow");
              makeZoom();
            };
          } else {
            console.error("No featured image found for the post.");
          }
        },
        error: function (error) {
          console.error("Error fetching post details:", error);
        },
      });

      $.ajax({
        url: restApiUrl,
        type: "GET",
        dataType: "json",
        success: function async(data) {
          console.log('data',data);
          // Populate the info elements
          $(".info .title").text(data.acf["obra-titulo_denominacion"]);
          $(".info .author").text(data.acf["obra-nombre_completo"]);
          $(".info .dimension").text(data.acf["obra-dimensiones"]);
          $(".info .edition").text(data.acf["obra-edicion"]);
          $(".info .technique").text(data.acf["obra-tecnica_materiales"]);
          $(".info .nationality").text(data.acf["obra-nacionalidad"]);

          // Fetch post categories  here leter*****

          $.ajax({
            url: restApiUrl,
            type: 'GET',
            success: function(post) {
                var categoriaData = [];
                $.each(post.categoria, function(index, categoryId) {
                    $.ajax({
                        url: '/wp-json/wp/v2/categoria/' + categoryId,
                        type: 'GET',
                        success: function(taxonomy) {
                            categoriaData.push(taxonomy.name);
                            console.log('categoryId',taxonomy.name)
                            if (categoriaData.length === post.categoria.length) {
                                $(".info .catagories").text(categoriaData.join(', '));
                            }
                        }
                    });
                });
            }
        });

        $.ajax({
            url: restApiUrl,
            type: 'GET',
            success: function(post) {
                var etiquetaData = [];
                $.each(post.etiqueta, function(index, tagId) {
                    // Fetch the tag name based on the tag ID
                    $.ajax({
                        url: '/wp-json/wp/v2/etiqueta/' + tagId, // Adjust the URL to your taxonomy endpoint
                        type: 'GET',
                        success: function(tag) {
                            etiquetaData.push(tag.name);
                            // Update the content when all names are fetched
                            if (etiquetaData.length === post.etiqueta.length) {
                                $(".info .tags").text(etiquetaData.join(', '));
                            }
                        }
                    });
                });
            }
        });
      
        
          $(".info .documents").text(data.acf["obra-documentos"]);
          $(".info .source").text(data.acf["obra-fuente_y_notas"]);

          //------------------------------------------------------

          let appnedSidebarGalleries = (fieldName, containerClass) => {
            const imageIds = data.acf[fieldName];
            const $imageContainer = $(containerClass).find(".gallerie");
            console.log("imageContainer", $imageContainer);

            if (Array.isArray(imageIds)) {
              const imageCount = imageIds.length;
              let loadedImages = 0;

              imageIds.forEach((imageId) => {
                $.ajax({
                  url: `/wp-json/wp/v2/media/${imageId}`,
                  type: "GET",
                  dataType: "json",
                  success: function (imageData) {
                    console.log("imageData", imageData);
                    const semiHighResURL = imageData.media_details.sizes.large.source_url;
                    const highResImgURL = imageData.source_url;
                    const imgTag = `<div class="documentImg sidebar-grid-item">
                      <img
                        src="${semiHighResURL}" 
                        data-highres="${highResImgURL}"
                        id="${imageData.id}">
                    </div>`;
                    $imageContainer.find("h3").text("Heading"); // Use $imageContainer to find elements
                    $imageContainer.append(imgTag);
                    loadedImages++;
                    if (loadedImages === imageCount) {

                      let windowWidthCalc = $('.documentWindow ').width() / $('body').width();
                      let grid;
                      if (windowWidthCalc == 1) {
                        grid = 1;
                      } else {
                        grid = 3;
                      }
                      $imageContainer.masonryGrid({
                        columns: grid
                      });


                    }
                    handleDocumentSingleImage();
                  },
                  error: function (error) {
                    console.error("Error fetching image data:", error);
                  },
                });
              });
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

  ImgPopupFunction();
  window.ImgPopupFunction = ImgPopupFunction;

  //=========================================
  //                  document single image window popup
  //=========================================

  async function handleDocumentSingleImage() {
    $(".documentImg").on("click", async function () {
      let sidebarLoader = `<div class="sidebarLoader">
      <img src="${themeDir}/popUpIcon/loading.gif" alt="">
      </div>`;
      $(".documentSingleImage").show();

      let imageId = $(this).find("img").attr("id");
      $.ajax({
        url: `/wp-json/wp/v2/media/${imageId}`,
        type: "GET",
        dataType: "json",
        success: function (imageData) {
          let imgURL = imageData.source_url;
          let imgTag = `<img class='sidebar-single-image' src='${imgURL}'> </img>`;
          $(".documentSingleImage").html(imgTag);
          $(".documentSingleImage").prepend(sidebarLoader);
          hideSideLoader();
          documentImgZoom();
        },
        error: function (error) {
          console.error("Error fetching image data:", error);
        },
      });
    });

    function hideSideLoader() {
      $(".documentSingleImage").click(() => {
        $(".sidebarLoader").fadeOut();
      });
    }
    $(".backArrow").on("click", () => {
      $(".documentSingleImage").html("");
      $(".documentSingleImage").fadeOut();
      $(".backArrow").hide();
      $(".documentImgZoom").hide();
      $(".documentWindowZoomout").hide();
    });
  }

  let handledocumentWindow = () => {
    $(".document, .closedocumentWindow").click(() => {
      $(".documentWindow").toggleClass("slide-in");
      $(".documentWindowNav").toggleClass("slide-in-btn");
      $(".documentSingleImage").html("");
      $(".documentSingleImage").fadeOut();
      $(".backArrow").hide();
    });
  };
 
  //=========================================
  //                                    zoom effect
  //=========================================

  $(".zoomOut").hide();



  let makeZoom = () => {
    $(".zoom").show();
    const zoomImage = document.getElementById("zoom-image");
    const zoomContainer = document.getElementsByClassName('zoom-container')[0];
    const panzoom = Panzoom(zoomImage, {
      contain: "outside",
      maxScale: 3,
      minScale: 0.5,
    });
  
    // Add the panzoom instance to the zoom container
    zoomContainer.panzoom = panzoom;
  
    $(".zoom").on("click", () => {
      panzoom.pan(0, 0, { animate: true });
      panzoom.zoom(3, { animate: true });
      $(".zoom").hide();
      $(".zoomOut").show();
    });
  
    $(".zoomOut").on("click", () => {
      panzoom.zoom(1, { animate: true });
      panzoom.pan(0, 0, { animate: true });
  
      $(".zoom").show();
      $(".zoomOut").hide();
    });
  
    // Custom logic to restrict drag within the container
    panzoom.on("pan", (event) => {
      const containerRect = zoomContainer.getBoundingClientRect();
      const imageRect = zoomImage.getBoundingClientRect();
  
      const minX = containerRect.left;
      const minY = containerRect.top;
      const maxX = containerRect.right - imageRect.width;
      const maxY = containerRect.bottom - imageRect.height;
  
      if (imageRect.left < minX) {
        panzoom.pan({ x: minX - imageRect.left, y: 0, animate: false });
      }
  
      if (imageRect.top < minY) {
        panzoom.pan({ x: 0, y: minY - imageRect.top, animate: false });
      }
  
      if (imageRect.right > maxX) {
        panzoom.pan({ x: maxX - imageRect.right, y: 0, animate: false });
      }
  
      if (imageRect.bottom > maxY) {
        panzoom.pan({ x: 0, y: maxY - imageRect.bottom, animate: false });
      }
    });
  };
  
  // let makeZoom = () => {
  //   $(".zoom").show();
  //   const zoomImage = document.getElementById("zoom-image");
  //   const zoomContainer = document.getElementsByClassName('zoom-container')
  //   const panzoom = Panzoom(zoomImage, {
  //     contain: "zoomContainer",
  //     maxScale: 3,
  //     minScale: 0.5,
  //   });

  //   $(".zoom").on("click", () => {
  //     panzoom.pan(0, 0, { animate: true });
  //     panzoom.zoom(3, { animate: true });
  //     $(".zoom").hide();
  //     $(".zoomOut").show();
  //   });

  //   $(".zoomOut").on("click", () => {
  //     panzoom.zoom(1, { animate: true });
  //     panzoom.pan(0, 0, { animate: true });

  //     $(".zoom").show();
  //     $(".zoomOut").hide();
  //   });
  // };

  $(".documentWindowZoomout").hide();
  $(".documentImgZoom").hide();
  $(".backArrow").hide();

  let documentImgZoom = () => {
    $(".backArrow").show();
    $(".documentImgZoom").show();
    let sidebarImg = $(".sidebar-single-image");

    if (sidebarImg.length > 0) {
      const sidebarImgZoom = Panzoom(sidebarImg[0], {
        maxScale: 3,
        minScale: 0.5,
      });

      $(".documentImgZoom").on("click", () => {
        sidebarImgZoom.pan(0, 0, { animate: true });
        sidebarImgZoom.zoom(3, { animate: true });
        console.log("Zoomed in");
        $(".documentImgZoom").hide();
        $(".documentWindowZoomout").show();
      });

      $(".documentWindowZoomout").on("click", () => {
        sidebarImgZoom.pan(0, 0, { animate: true });
        sidebarImgZoom.zoom(1, { animate: true });
        console.log("Zoomed out");
        $(".documentWindowZoomout").hide();
        $(".documentImgZoom").show();
      });
    }
  };

  //====================================
  //                                Window Close
  //====================================

  let closeWindow = () => {
    $(".cross").on("click", () => {
      $(".pre-loader").hide();
      $(".popup-box").fadeOut();
      $(".main_image").attr("src", "");
      $(".info").hide();
      $(".documentWindow").removeClass("slide-in");
      $(".documentWindowNav").removeClass("slide-in-btn");
      $(".gallerie").html("");
      $(".documentSingleImage").html("");
      $(".documentSingleImage").hide();
    });
  };
  $(".plus").on("click", () => {
    $(".info").slideToggle();
  });

  //====================================
  //                                Header Handler
  //====================================

function handleHeader(){
  $('.left-toggle-container').click(function(){
    $('.toggle-menu').toggleClass('on')
    $('#left-menu').toggleClass('active')
    $('#left-menu').fadeToggle(300);
    })

    // Menu Toggler

    $('.date-menu > ul > ul > .top-level-menu').click(function(){
      $('.date-menu > ul > ul > .top-level-menu').not(this).children('ul').slideUp(300);
      $(this).children('ul').slideToggle(300);
     });

    $('.mobile-parent_menu').click(function() {
        $('.mobile-parent_menu').not(this).next('.mobile-submenu').slideUp(300);
        $(this).next('.mobile-submenu').slideToggle(300);
    });

}

  //====================================
  //                           Page template controle 
  //====================================

  function handlePageMenu(){
    $('.page_link ul li').click(function(){
      if($(this).attr('class') == 'el_projecto'){
        console.log($(this).attr('class'))
        $('.home_section').fadeOut()
        $('.equipo_page_popup').hide()
        $('.la_porjecto_page_popup').fadeIn()
        $('.la_porjecto_page_popup').css('display','flex')
        closeMenu()
        scrollToTop()
      }
      if($(this).attr('class') == 'equipo'){
        console.log($(this).attr('class'))
        $('.home_section').fadeOut()
        $('.la_porjecto_page_popup').hide()
        $('.equipo_page_popup').fadeIn()
        $('.equipo_page_popup').css('display','flex')
        closeMenu()
        scrollToTop()
      }
    })

  }

  function closeMenu(){
    $('.left-toggle-container').click()
  }

  function hidePage(){
    $('.top-level-menu li, .mobile-submenu li').click(()=>{
      $('.home_section').fadeIn()
      $('.equipo_page_popup').fadeOut()
      $('.la_porjecto_page_popup').fadeOut()
      scrollToTop()
    })
  }

  function scrollToTop(){
    $('html, body').animate({ scrollTop: 0 }, 'slow');
  }

// run the function
closeWindow();
handleHeader();
handlePageMenu();
handledocumentWindow();
hidePage();

});
