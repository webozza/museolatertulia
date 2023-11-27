jQuery(document).ready(function ($) {



  var selectedYear
  var selectedCountry

  let selector = $('.top-level-menu .top-level-menu');
  let selected;

  selector.click(function() {
      selected = $(this);
  })

  let returnMenuData = () => {
      let parentMenu = selected.parent().parent().children('a').text()
      let menu = selected.find('a').text()
      return [parentMenu, menu];
  }

    let nonce = '<?=  wp_create_nonce('get_filtered_img'); ?>';
    let preLoader = '<div class="pre-loader-filtered">' +
    '<img src="' + '<?php echo get_stylesheet_directory_uri(); ?>' + '/icon/popUpIcon/loading.gif" alt="">' + '</div>';

    //============================
    //                     Filter from right menu 
    //============================

    $('.menu-right ul .menu-item .submenu li').on('click', function() {
      $('.my-masonry-grid').html('')
      $('.home_section').fadeIn()
      $('.popup_page').fadeOut()
        let parentMenu = $(this).parent().parent().find('.parent_menu').attr('id');
        let id = $(this).attr('id');
        

        $.ajax({
            url: '/wp-admin/admin-ajax.php', 
            type: 'POST',
            data: {
                action: 'my_ajax_action',
                parentMenu: parentMenu,
                id: id,
                year: selectedYear,
                security: nonce, 
            },
            success: function(response) {
                $('.my-masonry-grid').html(response)
                let windowWidthCalc = $('.my-masonry-grid').width() / $('body').width();
                let grid;

                if (windowWidthCalc == 1) {
                  grid = 6;
                } else {
                  grid = 3;
                }

                $(".my-masonry-grid").masonryGrid({
                  columns: grid
                });
                $('.my-masonry-grid').prepend(preLoader)
                $('.pre-loader-filtered').css('position','absolute')
                setTimeout(() => {
                    $('.pre-loader-filtered').fadeOut()
                }, 2000);

                ImgPopupFunction()
            }
        });
    });

    //============================
    //         Filter from right menu  on mobile
    //============================

    $('.mobile-submenu li').on('click', function() {
        let parentMenu = $(this).parent().parent().find('.mobile-parent_menu').attr('id');
        let id = $(this).attr('id');
        $.ajax({
            url: '/wp-admin/admin-ajax.php', 
            type: 'POST',
            data: {
                action: 'my_ajax_action',
                parentMenu: parentMenu,
                id: id,
                security: nonce, 
            },

            success: function(response) {
                $('.my-masonry-grid').html(response)
                let windowWidthCalc = $('.my-masonry-grid').width() / $('body').width();
                let grid;

                if (windowWidthCalc == 1) {
                  grid = 6;
                } else {
                  grid = 3;
                }

                $(".my-masonry-grid").masonryGrid({
                  columns: grid
                });
                $('.my-masonry-grid').prepend(preLoader)
                $('.pre-loader-filtered').css('position','absolute')
                setTimeout(() => {
                    $('.pre-loader-filtered').fadeOut()
                }, 2000);

                ImgPopupFunction()
            }
        });
    });

    //============================
    //          Filter from left menu  on initial load
    //============================

    selector.click(function () {
      let key =  returnMenuData()[1].toLowerCase();
      let date = returnMenuData()[0];
      console.log('key =',key ,'-------------', 'date =' , date)
      selectedYear = date
      // console.log(key);

      // $('.logo h1').text(date)

      gridData = () =>{
          $.ajax({
                  url: '/wp-admin/admin-ajax.php', 
                  type: 'POST',
                  data: {
                      action: 'defaultGrid',
                      value: selectedYear,
                  },
                  success: function(response) {
                      $('.my-masonry-grid').html(response)
                      $(".my-masonry-grid").masonryGrid({
                          columns: 3,
                      });
                      $('.my-masonry-grid').prepend(preLoader)
                      $('.pre-loader-filtered').css('position','absolute')
                      setTimeout(() => {
                          $('.pre-loader-filtered').fadeOut()
                      }, 2000);
                      ImgPopupFunction()
                  }
            });
            $('.masonry-grid-column').css('width','33.33%')
        }
      gridData()

      if (key === 'map') {
        $('.biennial, .categories, .artists').hide()
        $('.map').show()
        $('#zoom-controls').css('width','fit-content')
        $('.my-masonry-grid').html('')
      }

      if (key === 'artists') {
            $('.biennial, .categories, .map').hide()
            $('.artists').show()
            $('.my-masonry-grid').html('')

            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'getMenu',
                    year: selectedYear,
                    menuFilter : 'obra-nombre_completo',
                },
                success: function (data) {
                  console.log(data)
                  $('#artist-list').html(data);
                  getArtists()
                },
                error: function () {
                    $('#artist-list').append('<li>Error fetching data</li>');
                }
            });
      }

      if (key === 'categories') {
        $('.biennial, .map, .artists').hide()
        $('.categories').show()

        $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'getMenu',
                    year: selectedYear,
                    menuFilter : 'categoria',
                },
                success: function (data) {
                  console.log(data)
                  $('#categories-list').html(data);
                  getArtists()
                },
                error: function () {
                    $('#categories-list').append('<li>Error fetching data</li>');
                }
        });

      }

      if (key === 'biennial') {
        $('.map, .artists, .categories').hide()
        $('.biennial').show()
      }

    });

   //============================
    //                        Bienal filter 
    //============================

    $('.biennial ul li').click(function(){
      let key = 'obra-bienal'
      let value = $(this).attr('id')
      $(this).css('fill', '#a4fffa');

        $.ajax({
            url: '/wp-admin/admin-ajax.php', 
            type: 'POST',
            data: {
                action: 'filterData',
                key: key,
                value: value,
                year: selectedYear,
            },
            success: function(response) {
                $('.my-masonry-grid').html(response)
                $(".my-masonry-grid").masonryGrid({
                    columns: 3,
                });
                $('.my-masonry-grid').prepend(preLoader)
                $('.pre-loader-filtered').css('position','absolute')
                setTimeout(() => {
                    $('.pre-loader-filtered').fadeOut()
                }, 2000);
                ImgPopupFunction()
            }
        });

        $('.masonry-grid-column').css('width','33.33%')
    })

    //============================
    //                        Catagories filter 
    //============================

    $('.categories ul li').click(function () {
      let id = $(this).data('id')
      $.ajax({
        url : '/wp-admin/admin-ajax.php',
        type : 'POST',
        data : {
          action : 'catagoryFilter',
          id : id,
          year: selectedYear,
        },
        success : function(response){
                $('.my-masonry-grid').html(response)
                $(".my-masonry-grid").masonryGrid({
                    columns: 3,
                });
                $('.my-masonry-grid').prepend(preLoader)
                $('.pre-loader-filtered').css('position','absolute')
                setTimeout(() => {
                    $('.pre-loader-filtered').fadeOut()
                }, 2000);
                ImgPopupFunction()
        }
      })
      $('.masonry-grid-column').css('width','33.33%')

    })

    //============================
    //                          Map filter 
    //============================

    $('path').click(function () {
      $('path').css('fill', '#ffffff');
      console.log('selectedYear',selectedYear)

      let key = 'obra-nacionalidad'
      let value = $(this).attr('id')
      $(this).css('fill', '#a4fffa');
      selectedCountry = value;
        $.ajax({
            url: '/wp-admin/admin-ajax.php', 
            type: 'POST',
            data: {
                action: 'filterData',
                key: key,
                value: value,
                year: selectedYear,
            },
            success: function(response) {
                $('.my-masonry-grid').html(response)
                $(".my-masonry-grid").masonryGrid({
                    columns: 3,
                });
                $('.my-masonry-grid').prepend(preLoader)
                $('.pre-loader-filtered').css('position','absolute')
                setTimeout(() => {
                    $('.pre-loader-filtered').fadeOut()
                }, 2000);
                ImgPopupFunction()
            }
        });

        $('.masonry-grid-column').css('width','33.33%')

    })

   //============================
    //            Filter Data for Artists name 
    //============================

    getArtists = () =>{

        $('.artists_name').click(function(){
        let key = 'obra-nombre_completo'
        let value = $(this).attr('id')
        console.log(value)
        $(this).css('fill', '#a4fffa');

          $.ajax({
              url: '/wp-admin/admin-ajax.php', 
              type: 'POST',
              data: {
                  action: 'filterData',
                  key: key,
                  value: value,
                  year: selectedYear,
              },
              success: function(response) {
                  $('.my-masonry-grid').html(response)
                  $(".my-masonry-grid").masonryGrid({
                      columns: 3,
                  });
                  $('.my-masonry-grid').prepend(preLoader)
                  $('.pre-loader-filtered').css('position','absolute')
                  setTimeout(() => {
                      $('.pre-loader-filtered').fadeOut()
                  }, 2000);
                  ImgPopupFunction()
              }
          });

          $('.masonry-grid-column').css('width','33.33%')
      })

    }

    //============================
    //                         logo Filter 
    //============================


    $('.logo h1').click(function(){
        let selectedYear = $(this).text();
        
        $.ajax({
                  url: '/wp-admin/admin-ajax.php', 
                  type: 'POST',
                  data: {
                      action: 'logoFilter',
                      value: selectedYear,
                  },
                  success: function(response) {
                      $('.my-masonry-grid').html(response)
                      $(".my-masonry-grid").masonryGrid({
                          columns: 6,
                      });
                      $('.my-masonry-grid').prepend(preLoader)
                      $('.pre-loader-filtered').css('position','absolute')
                      setTimeout(() => {
                          $('.pre-loader-filtered').fadeOut()
                      }, 2000);
                      ImgPopupFunction()
                  }
            });
            // $('.masonry-grid-column').css('width','33.33%')
    })

    //============================
    //                     Main Menu Filter 
    //============================
     
    $('.top-level-menu a').click(function(){
      if($(this).text() == '1971' || $(this).text() == '1973' || $(this).text() == '1976'){
        let selectedYear = $(this).text()
        $.ajax({
                  url: '/wp-admin/admin-ajax.php', 
                  type: 'POST',
                  data: {
                      action: 'logoFilter',
                      value: selectedYear,
                  },
                  success: function(response) {
                      $('.my-masonry-grid').html(response)
                      $(".my-masonry-grid").masonryGrid({
                          columns: 6,
                      });
                      $('.my-masonry-grid').prepend(preLoader)
                      $('.pre-loader-filtered').css('position','absolute')
                      setTimeout(() => {
                          $('.pre-loader-filtered').fadeOut()
                      }, 2000);
                      ImgPopupFunction()
                  }
            });
      }
  })

    //============================
    //                            Map close 
    //============================


    $('#map_close').click(()=>{
      $('.map, .artists, .categories, .biennial').hide()
        $('#zoom-controls').css('width','0')
        $('.masonry-grid-column').css('width','16.66% !important')

        $('.my-masonry-grid').html('')
        $.ajax({
            url: '/wp-admin/admin-ajax.php', 
            type: 'POST',
            data: {
                action: 'defaultGrid',
            },
            success: function(response) {
                $('.my-masonry-grid').html(response)
                $('.my-masonry-grid').prepend(preLoader)
                $(".my-masonry-grid").masonryGrid({
                    columns: 6,
                });
                $('.masonry-grid-column').css('width','16.66%')
                setTimeout(() => {
                    $('.pre-loader-filtered').fadeOut()
                }, 2000);
                ImgPopupFunction()
            }
        });
    })




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
          console.log("data", data);
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
            type: "GET",
            success: function (post) {
              var categoriaData = [];
              $.each(post.categoria, function (index, categoryId) {
                $.ajax({
                  url: "/wp-json/wp/v2/categoria/" + categoryId,
                  type: "GET",
                  success: function (taxonomy) {
                    categoriaData.push(taxonomy.name);
                    console.log("categoryId", taxonomy.name);
                    if (categoriaData.length === post.categoria.length) {
                      $(".info .catagories").text(categoriaData.join(", "));
                    }
                  },
                });
              });
            },
          });

          $.ajax({
            url: restApiUrl,
            type: "GET",
            success: function (post) {
              var etiquetaData = [];
              $.each(post.etiqueta, function (index, tagId) {
                // Fetch the tag name based on the tag ID
                $.ajax({
                  url: "/wp-json/wp/v2/etiqueta/" + tagId, // Adjust the URL to your taxonomy endpoint
                  type: "GET",
                  success: function (tag) {
                    etiquetaData.push(tag.name);
                    // Update the content when all names are fetched
                    if (etiquetaData.length === post.etiqueta.length) {
                      $(".info .tags").text(etiquetaData.join(", "));
                    }
                  },
                });
              });
            },
          });

          $(".info .documents").text(data.acf["obra-documentos"]);
          $(".info .source").text(data.acf["obra-fuente_y_notas"]);

          //------------------------------------------------------

          let appnedSidebarGalleries = (fieldName, containerClass) => {
            const imageIds = data.acf[fieldName];
            const imageContainer = $(containerClass).find(".gallerie");
            console.log("imageContainer", imageContainer);
            $('.gallerie-heading').show()
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
                    // const semiHighResURL = imageData.media_details.sizes.large.source_url;
                    const highResImgURL = imageData.source_url;
                    const imgTag = `<div class="documentImg sidebar-grid-item">
                      <img
                        src="${highResImgURL}" 
                        data-highres="${highResImgURL}"
                        id="${imageData.id}">
                    </div>`;
                    imageContainer.find("h3").text("Heading"); 
                    imageContainer.append(imgTag);
                    setTimeout(()=>{
                      hideEmptyDocumentHeader();
                    },500)
                    // hideEmptyDocumentHeader();
                    loadedImages++;
                    if (loadedImages === imageCount) {
                      let windowWidthCalc = $(".documentWindow ").width() / $("body").width();
                      let grid;
                      if (windowWidthCalc == 1) {
                        grid = 1;
                      } else {
                        grid = 3;
                      }
                      imageContainer.masonryGrid({
                        columns: grid,
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
          appnedSidebarGalleries("obra-obra_participante_2", ".obra-obra_participante_2");
          appnedSidebarGalleries("obra-obra_participante_3", ".obra-obra_participante_3");
          appnedSidebarGalleries("obra-obra_asociada_1", ".obra-obra_asociada_1");
          appnedSidebarGalleries("obra-obra_asociada_2", ".obra-obra_asociada_2");
          appnedSidebarGalleries("obra-obra_asociada_3", ".obra-obra_asociada_3");

          //------------------------------------------------------
        },





        error: function (error) {
          console.error("Error fetching post data:", error);
        },
      });
    });
  }
  function hideEmptyDocumentHeader(){
    $('.gallerie-heading').each(function() {
      // Check if the next sibling (.gallerie) has no child elements
      if ($(this).next('.gallerie').children().length === 0) {
        // Hide the corresponding .gallerie-heading
        $(this).hide();
      }
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
      <img src="${themeDir}/icon/popUpIcon/loading.gif" alt="">
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
      setTimeout(function () {
        $(".sidebarLoader").fadeOut();
        },4000)
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
    const zoomContainer = document.getElementsByClassName("zoom-container")[0];
    let zoomScale = zoomImage.naturalWidth / zoomImage.clientWidth
    const panzoom = Panzoom(zoomImage, {
      contain: "outside",
      maxScale: zoomScale,
      minScale: 0.5,
    });

    // Add the panzoom instance to the zoom container
    zoomContainer.panzoom = panzoom;

    $(".zoom").on("click", () => {
      panzoom.pan(0, 0, { animate: true });
      panzoom.zoom(zoomScale,{ animate: true });
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
  $(".documentImgZoom").hide();
  $(".backArrow").hide();

  let documentImgZoom = () => {
    $(".backArrow").show();
    $(".documentImgZoom").show();
    const sidebarImg = document.getElementsByClassName("sidebar-single-image")[0];
    // let zoomScale = sidebarImg.naturalWidth / sidebarImg.clientWidth

      const panzoom = Panzoom(sidebarImg, {
        maxScale: 3,
        minScale: 0.5,
      });

      $(".documentImgZoom").on("click", () => {
        panzoom.pan(0, 0, { animate: true });
        panzoom.zoom(3, { animate: true });
        console.log("Zoomed in");
        $(".documentImgZoom").hide();
        $(".documentWindowZoomout").show();
      });

      $(".documentWindowZoomout").on("click", () => {
        panzoom.zoom(1, { animate: true });
        panzoom.pan(0, 0, { animate: true });
        console.log("Zoomed out");
        $(".documentWindowZoomout").hide();
        $(".documentImgZoom").show();
      });
    
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

  function handleHeader() {
    $(".left-toggle-container").click(function () {
      $(".toggle-menu").toggleClass("on");
      $("#left-menu").toggleClass("active");
      $("#left-menu").fadeToggle(300);
    });

    // Right Menu Toggler

    $(".menu-item").click(function () {
      $(".menu-item").not(this).find(".submenu").slideUp(300);
      $(this).find(".submenu").slideToggle(300);
    });

    

    // left Menu Toggler

    $(".date-menu > ul > ul > .top-level-menu").click(function () {
      $(".date-menu > ul > ul > .top-level-menu").not(this).children("ul").slideUp(300);
      $(this).children("ul").slideToggle(300);
    });

    $('.top-level-menu .top-level-menu').click(()=>{
      closeMenu()
    })

    $(".mobile-parent_menu").click(function () {
      $(".mobile-parent_menu").not(this).next(".mobile-submenu").slideUp(300);
      $(this).next(".mobile-submenu").slideToggle(300);
    });
  }

  //====================================
  //                           Page template controle
  //====================================

  function handlePageMenu() {
    $(".date-menu > ul > ul > .top-level-menu").click(function () {
      if ($(this).children("a").attr("class") == "El_Projecto") {
        $('.popup_page').show()
        $(".home_section").fadeOut();
        $(".equipo_page_popup").hide();
        $(".la_porjecto_page_popup").fadeIn();
        $(".la_porjecto_page_popup").css("display", "flex");
        closeMenu();
        scrollToTop();
      }
      if ($(this).children("a").attr("class") == "Epuipo") {
        $('.popup_page').show()
        $(".home_section").fadeOut();
        $(".la_porjecto_page_popup").hide();
        $(".equipo_page_popup").fadeIn();
        $(".equipo_page_popup").css("display", "flex");
        closeMenu();
        scrollToTop();
      }
    });
  }

  function closeMenu() {
    $(".left-toggle-container").click();
  }

  function hidePage() {
    $(".top-level-menu li, .mobile-submenu li").click(() => {
      $(".home_section").fadeIn();
      $(".equipo_page_popup").fadeOut();
      $(".la_porjecto_page_popup").fadeOut();
      scrollToTop();
    });
  }

  function scrollToTop() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  // run the function
  closeWindow();
  handleHeader();
  handlePageMenu();
  handledocumentWindow();
  hidePage();
});
