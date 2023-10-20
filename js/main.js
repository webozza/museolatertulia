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
    const restApiUrl = "/wp-json/wp/v2/obra/" + postID;
    $(".popup-box").show();
    $(".pre-loader").show();
    $(".main_image").attr("src", imgUrl);
    makeZoom()
    $.ajax({
      url: restApiUrl,
      type: "GET",
      dataType: "json",
      success: function (data) {
        console.log(data);
        $(".info title").text();
        $(".info author").text();
        $(".info technical-date").text();
        $(".info year").text();
        $(".info catagories").text();
        $(".info country").text();
        $(".info tags").text(data);
      },
      error: function (error) {
        console.error("Error fetching post data:", error);
      },
    });
  });

  //============================
  //                        zoom effect
  //============================


  let makeZoom = () => {
    const panzoom = Panzoom(zoomImage, {
      maxScale: 2,
      minScale: 0.5,
    });

    $(".zoom").on("click", () => {});
    panzoom.zoom(2);
  };

//============================
//                        Nav Button Click
//============================

$(".cross").on("click", () => {
  $(".pre-loader").hide();
  $(".popup-box").fadeOut();
  $(".main_image").attr("src", "");
  $(".info").hide();
});

$(".plus").on("click", () => {
  $(".info").slideToggle();
});

});
