<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- panZoom  CDN-->
    <script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>

    <!-- ======= Icons used for dropdown (you can use your own) ======== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <?php wp_head()?>
</head>
<body <?php body_class()?>>


<?php


function querry_menu($menu_category){
    $args = array(
        'post_type' => 'obra', 
        'posts_per_page' => -1,
    );
    
    $query = new WP_Query($args);
    
    $values = array();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $field_value = get_field($menu_category);
            if (!empty($field_value)) {
                $values[] = $field_value;
            }
        }
    }
    
    wp_reset_postdata();
    
    $value_counts = array_count_values($values);
    ksort($value_counts);
    foreach ($value_counts as $value => $count) {
        echo '<li class="drop_down_menu data-attr="'.$value.'">' . $value;
        if ($count > 1) {
            echo ' (' . $count . ')';
        }
        echo '</li>';
    }
}


?>

<div class="header-left">
    <div class="logo-container">
        <div class="logo"><h1>1971</h1></div>
        <div class="toggle-container">
            <div class='left-toggle-container'>
                <a href='#left-menu' class="toggle-menu">
                    <span></span>
                </a>
            </div>
            <div id="left-menu">
                <div>
                    <ul>
                        <li class="top-level-menu">Start
                        </li>
                        <li class="top-level-menu">1971
                            <ul class="submenu">
                                <li>map</li>
                                <li>biennial</li>
                                <li>categories</li>
                                <li>artists</li>
                                <li>resources</li>
                            </ul>
                        </li>
                        <li class="top-level-menu">1973
                            <ul class="submenu">
                                <li>map</li>
                                <li>biennial</li>
                                <li>categories</li>
                                <li>artists</li>
                                <li>resources</li>
                            </ul>
                        </li>
                        <li class="top-level-menu">1976
                            <ul class="submenu">
                                <li>map</li>
                                <li>biennial</li>
                                <li>categories</li>
                                <li>artists</li>
                                <li>resources</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="header-right">
    <div class="menu-right">
        <ul>
            <li class="menu-item">Bienales
                <ul class="submenu">
                    <?php querry_menu('obra-bienal')?>
                </ul>
            </li>
            <li class="menu-item">Artistas
                <ul class="submenu">
                    <?php querry_menu('obra-nombre_completo')?> 
                </ul>
            </li>
            <li class="menu-item">Técnicas
                <ul class="submenu">
                    <?php querry_menu('obra-tecnica_materiales')?>
                </ul>
            </li>
            <li class="menu-item">Nacionalidad                 
                <ul class="submenu">
                    <?php querry_menu('obra-nacionalidad')?>
                </ul>
            </li>
        </ul>
    </div>
</div>



    <script>

        $(document).ready(function(){
            $('.left-toggle-container').click(function(){
                $('.toggle-menu').toggleClass('on')
                $('#left-menu').toggleClass('active')
                $('#left-menu').fadeToggle(300);
            })
            $('.top-level-menu').on('click', function() {
                $('.top-level-menu').not(this).find('.submenu').slideUp(300);
                $(this).find('.submenu').slideToggle(300);
            });
            $('.menu-item').click(function() {
             $('.menu-item').not(this).find('.submenu').slideUp(300);
                $(this).find('.submenu').slideToggle(300);
            });
            $('.drop_down_menu').click(function(){
                $menu_item = $(this).text()
            })
        })

    </script> 