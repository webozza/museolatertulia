<?php
$args = array(
    'post_type' => 'obra',
    'posts_per_page' => -1,
);
$query = new WP_Query($args);
?>

<div class="popup_page">
    <div class="la_porjecto_page_popup">
              <?php include get_stylesheet_directory() . '/module/page_poup/el_projecto.php'?>
    </div>
    <div class="equipo_page_popup">
              <?php include get_stylesheet_directory() . '/module/page_poup/equipo.php'?>
    </div>
</div>

<div class="home_section">
    <div class="map">
    <?php include get_stylesheet_directory() . '/module/map.php'?>
    </div>
    <div class="artists">
        <ul id="artist-list"></ul>
    </div>
    <div class="categories">
       <?php include get_stylesheet_directory( ) . '/module/categories.php'?> 
    </div>
    <div class="biennial">
      <?php include get_stylesheet_directory(  ) . '/module/biennial.php'?>
    </div>

    <div class="my-masonry-grid">  
    <?php if ($query->have_posts()) : ?>
        <?php
        // Get the posts and shuffle the array
        $posts = $query->get_posts();
        shuffle($posts);
        
        foreach ($posts as $post) : setup_postdata($post);
            $post_id = get_the_ID();
        ?>
            <div class="my-masonry-grid-item">
                <?php the_post_thumbnail('large', 
                    array(
                        'class'         => 'clickable-thumbnail',
                        'data-post-id'  => $post_id, 
                    ));
                ?>
            </div>
        <?php endforeach; ?>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p>No posts found.</p>
    <?php endif; ?>
</div>


</div>

<div class="popup-box  zoom-container">

        <div class="pre-loader">
            <img src="<?= get_stylesheet_directory_uri(  )?>/icon/popUpIcon/loading.gif" alt="">
        </div>

        <div class="img ">
            <img class="main_image" src="" alt="" id="zoom-image">
        </div>

      <div class="navigation">
            <div class="plus"><img src="<?= get_stylesheet_directory_uri();?>/icon/popUpIcon/icono-plus.png" alt="" /></div>
            <div class="cross"><img src="<?= get_stylesheet_directory_uri();?>/icon/popUpIcon/icono-x.png" alt="" /></div>
            <div class="zoom"><img src="<?= get_stylesheet_directory_uri();?>/icon/popUpIcon/icono-lupa+.png" alt="" /></div>
            <div class="zoomOut"><img src="<?= get_stylesheet_directory_uri();?>/icon/popUpIcon/icono-minus.png" alt="" /></div>
            <div class="document"><img src="<?= get_stylesheet_directory_uri();?>/icon/popUpIcon/icono-documentos.png" alt="" /></div>
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
      </div>
      <div class="documentWindow">
        <div class="documentData">
          <div  class="obra-obra_participante_1">
            <h3 class="gallerie-heading">Detalles</h3>
            <div class="gallerie"></div>
          </div>
          <br>
          <div class="obra-obra_participante_2">
            <h3 class="gallerie-heading">Detalles</h3>
            <div class="gallerie"></div>
          </div>
          <br>
          <div class="obra-obra_participante_3">
            <h3 class="gallerie-heading">Detalles</h3>
            <div class="gallerie"></div>
          </div>
          <br>
          <div class="obra-obra_asociada_1">
            <h3 class="gallerie-heading">Detalles</h3>
            <div class="gallerie"></div>
          </div>
          <br>
          <div class="obra-obra_asociada_2">
            <h3 class="gallerie-heading">Detalles</h3>
            <div class="gallerie"></div>
          </div>
          <br>
          <div class="obra-obra_asociada_3">
            <h3 class="gallerie-heading">Detalles</h3>
            <div class="gallerie"></div>
          </div>
          <br>
          <div class="obra-documentos">
            <h3 class="gallerie-heading">Documentos Relacionados</h3>
            <div class="gallerie"></div>
          </div>
        </div>
        <div class="documentSingleImage zoom-container">
        </div>
        <div class="documentWindowNav">
                <div class="closedocumentWindow"><img src="<?= get_stylesheet_directory_uri();?>/icon/popUpIcon/icono-x.png" alt="" /></div>
                <div class="backArrow"><img src="<?= get_stylesheet_directory_uri(); ?>/icon/popUpIcon/icono _-.png" alt=""></div>
                <div class="documentImgZoom"><img src="<?= get_stylesheet_directory_uri();?>/icon/popUpIcon/icono-lupa+.png" alt="" /></div>
                <div class="documentWindowZoomout"><img src="<?= get_stylesheet_directory_uri();?>/icon/popUpIcon/icono-minus.png" alt="" /></div>
        </div>
      </div>

</div>

<div class="poppy">
	
</div>

<script>
    jQuery(document).ready(function($) {

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
            $('.map, .artists, .categories, .biennial').hide()
            $('.navigation .cross').click()
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
            $('.map, .artists, .categories, .biennial').hide()
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


    });
</script>