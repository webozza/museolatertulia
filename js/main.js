// Home Grid Post

jQuery(document).ready(function ($) {
  $.fn.masonryGrid = function (options) {
    // Get options
    var settings = $.extend(
      {
        columns: 3,
        breakpoint: 767,
      },
      options
    );

    var $this = $(this),
      currentColumn = 1,
      i = 1,
      itemCount = 1,
      isDesktop = true;

    // Add class to already existent items
    $this.addClass("masonry-grid-origin");
    $this.children().addClass("masonry-grid-item");

    function createMasonry() {
      currentColumn = 1;

      // Add columns
      for (columnCount = 1; columnCount <= settings.columns; columnCount++) {
        $this.each(function () {
          $(this).append('<div class="masonry-grid-column masonry-grid-column-' + columnCount + '"></div>');
        });
      }

      // Add basic styles to columns
      $this.each(function () {
        $(this).css("display", "flex").find(".masonry-grid-column").css("width", "100%");
      });

      $this.each(function () {
        var currentGrid = $(this);

        currentGrid.find(".masonry-grid-item").each(function () {
          // Reset current column
          if (currentColumn > settings.columns) currentColumn = 1;

          // Add ident to element and put it in a column
          $(this)
            .attr("id", "masonry_grid_item_" + itemCount)
            .appendTo(currentGrid.find(".masonry-grid-column-" + currentColumn));

          // Increase current column and item count
          currentColumn++;
          itemCount++;
        });
      });

      $(".masonry-grid-item").each(function () {
        let thisItem = $(this);
        if (!thisItem.find("img").length) {
          thisItem.remove();
        }
      });
    }

    function destroyMasonry() {
      // Put items back in first level of origin container
      $this.each(function () {
        while (i < itemCount) {
          // Append item to parent container
          $(this)
            .find("#masonry_grid_item_" + i)
            .appendTo($this);

          i++;
        }

        // Remove columns
        $(this).find(".masonry-grid-column").remove();

        // Remove basic styles
        $(this).css("display", "block").find(".masonry-grid-column").css("width", "auto");
      });
    }

    // Call functions
    if ($(window).width() > settings.breakpoint) {
      isDesktop = true;
      createMasonry();
    } else if ($(window).width() <= settings.breakpoint) {
      isDesktop = false;
      destroyMasonry();
    }
    $(window).on("resize", function () {
      if ($(window).width() > settings.breakpoint && isDesktop == false) {
        isDesktop = true;
        createMasonry();
      } else if ($(window).width() <= settings.breakpoint && isDesktop == true) {
        isDesktop = false;
        destroyMasonry();
      }
    });
  };

  $(function () {
    $(".my-masonry-grid").masonryGrid({
      columns: 6,
    });
  });

  //============================
  //                        Grid END
  //============================

  //============================
  //                        PopUp
  //============================

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
          // Check if the featured image data exists
          const featuredMedia = postData._embedded["wp:featuredmedia"][0];
          const imgUrl = featuredMedia.source_url; // Get the URL of the featured image
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
    
    
    

    // Fetch post categories

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

        $(".info .categories").text("categoryNames");
        $(".info .tags").text("tagNames");

        $(".info .documents").text(data.acf["obra-documentos"]);
        $(".info .source").text(data.acf["obra-fuente_y_notas"]);
        $(".info .other-ducuments").text(data.acf["obra-otras_colecciones"]);

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

  //========================================================
  //                                     document single image window popup
  //========================================================

  async function handleDocumentSingleImage() {
    $(".documentImg").on("click", async function () {
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
          documentImgZoom();
        },
        error: function (error) {
          console.error("Error fetching image data:", error);
        },
      });
    });
    $(".backArrow").on("click", () => {
      $(".documentSingleImage").html("");
      $(".documentSingleImage").fadeOut();
      $(".backArrow").hide();
      $(".documnetImgzoom").hide();
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
  handledocumentWindow();

  //=========================================
  //                                          zoom effect
  //=========================================

  $(".zoomOut").hide();
  let makeZoom = () => {
    $(".zoom").show();
    const zoomImage = document.getElementById("zoom-image");
    const panzoom = Panzoom(zoomImage, {
      maxScale: 3,
      minScale: 0.5,
    });

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
  };

  $(".documentWindowZoomout").hide();
  $(".documnetImgzoom").hide();
  $(".backArrow").hide();

  let documentImgZoom = () => {
    $(".backArrow").show();
    $(".documnetImgzoom").show();
    let sidebarImg = $(".sidebar-single-image");

    if (sidebarImg.length > 0) {
      const sidebarImgZoom = Panzoom(sidebarImg[0], {
        maxScale: 3,
        minScale: 0.5,
      });

      $(".documnetImgzoom").on("click", () => {
        sidebarImgZoom.pan(0, 0, { animate: true });
        sidebarImgZoom.zoom(3, { animate: true });
        console.log("Zoomed in");
        $(".documnetImgzoom").hide();
        $(".documentWindowZoomout").show();
      });

      $(".documentWindowZoomout").on("click", () => {
        sidebarImgZoom.pan(0, 0, { animate: true });
        sidebarImgZoom.zoom(1, { animate: true });
        console.log("Zoomed out");
        $(".documentWindowZoomout").hide();
        $(".documnetImgzoom").show();
      });
    }
  };

  //====================================
  //                                 Window Close
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

  // run the function

  closeWindow();
});
