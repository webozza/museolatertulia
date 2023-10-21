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
    const imgUrl = $(this).attr("src");
    const restApiUrl = `/wp-json/wp/v2/obra/${postID}`;
    $(".popup-box").show();
    $(".pre-loader").show();
    $(".main_image").hide();
    // Create a new image element and set its source
    const image = new Image();
    image.src = imgUrl;
    $(".main_image").attr("src", imgUrl);
    image.onload = function () {
      $(".main_image").fadeIn("slow");
      $(".pre-loader").fadeOut("slow");
      makeZoom();
    };

    // Fetch post categories

    $.ajax({
      url: restApiUrl,
      type: "GET",
      dataType: "json",
      success: function async (data) {
        console.log(data)
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
        const imageIds = data.acf["obra-obra_participante_1"];
        const imageContainer = $('.documentData');
        
        imageIds.forEach(imageId => {
          $.ajax({
            url: `/wp-json/wp/v2/media/${imageId}`,
            type: "GET",
            dataType: "json",
            success: function (imageData) {
              const imgTag = `<img src="${imageData.source_url}" class="documentImg sidebar-grid-item">`;
              imageContainer.append(imgTag);
            },
            error: function (error) {
              console.error("Error fetching image data:", error);
            }
          });
        });
        
        $(window).on('load', function () {
          // Initialize the Masonry grid after all images are loaded
          $(".sidebar-grid").masonryGrid({
            columns: 3,
          });
        });
        

        // $(function () {

        // });

        //------------------------------------------------------


      },

      error: function (error) {
        console.error("Error fetching post data:", error);
      },
    });
  });

  let handledocumentWindow = () => {
    $(".document, .closedocumentWindow").click(() => {
      $(".documentWindow").toggleClass("slide-in");
      $(".closedocumentWindow").toggleClass("slide-in-btn");


    });
  };
  handledocumentWindow();

  //============================
  //                        zoom effect
  //============================

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

  //============================
  //                        Window Close
  //============================

  let closeWindow = () => {
    $(".cross").on("click", () => {
      $(".pre-loader").hide();
      $(".popup-box").fadeOut();
      $(".main_image").attr("src", "");
      $(".info").hide();
      $(".documentWindow").removeClass("slide-in");
      $(".closedocumentWindow").removeClass("slide-in-btn");
    });
  };

  $(".plus").on("click", () => {
    $(".info").slideToggle();
  });

  // run the function

  closeWindow();
});
