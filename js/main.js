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




//   popup function 


  $('.clickable-thumbnail').on('click', function () {
    const postID = $(this).data('post-id');



    // Define the REST API endpoint for getting post details
    const restApiUrl = '/wp-json/wp/v2/obra/' + postID; // Adjust the URL as per your WordPress setup

    // Make an AJAX request to the REST API endpoint
    $.ajax({
        url: restApiUrl,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Once the data is retrieved, you can log it in the console
            console.log('Post Details:', data);
            
            // You can access specific post properties like title, content, etc. as needed
            console.log('Post Title:', data.title.rendered);
            console.log('Post Content:', data.content.rendered);
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
    

});



});
