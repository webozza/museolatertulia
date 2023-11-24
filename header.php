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
        $id = str_replace(' ', '_', $value);
        echo '<li class="drop_down_menu" id="' . $id . '">' . $value;        
        if ($count > 1) {
            echo ' (' . $count . ')';
        }
        echo '</li>';
    }
}


// function query_menu_from_category($menu_category){
//     $args = array(
//         'post_type' => 'orba', 
//         'posts_per_page' => -1,
//         'tax_query' => array(
//             array(
//                 'taxonomy' => 'categoria', 
//                 'field'    => 'term_id', 
//                 'terms'    => $menu_category,
//             ),
//         ),
//     );
    
//     $query = new WP_Query($args);
    
//     $values = array();
    
//     if ($query->have_posts()) {
//         while ($query->have_posts()) {
//             $query->the_post();
//             $field_value = get_field('your_custom_field_name'); // Replace 'your_custom_field_name' with the actual field name you want to retrieve
//             if (!empty($field_value)) {
//                 $values[] = $field_value;
//             }
//         }
//     }
    
//     wp_reset_postdata();
    
//     $value_counts = array_count_values($values);
//     ksort($value_counts);
    
//     foreach ($value_counts as $value => $count) {
//         $id = str_replace(' ', '_', $value);
//         echo '<li class="drop_down_menu" id="' . $id . '">' . $value;        
//         if ($count > 1) {
//             echo ' (' . $count . ')';
//         }
//         echo '</li>';
//     }
// }


?>

<div class="header-left">
    <div class="logo-container">
        <a href="<?= site_url();?>">
            <div class="logo"><h1>1971</h1></div>
        </a>
        <div class="toggle-container">
            <div class='left-toggle-container'>
                <a class="toggle-menu">
                    <span></span>
                </a>
            </div>

            <div id="left-menu">

                  <!--------------------------------------------------- -->

                  <?php
                    $menu_location = 'main-menu';
                    $menu_items = wp_get_nav_menu_items($menu_location);
                    
                    if ($menu_items) {
                        echo '<div class="date-menu"><ul>';
                        $current_year = null;
                        function generate_menu($items, $parent_id = 0) {
                            echo '<ul>';
                            foreach ($items as $menu_item) {
                                $item_title = $menu_item->title;
                                $item_url = $menu_item->url;
                                $menu_parent = $menu_item->menu_item_parent;
                                $item_id = str_replace(' ','_',$item_title);

                                if ($menu_parent == $parent_id) {
                                    echo "<li class='top-level-menu '>";
                                    echo "<a class='$item_id' href='$item_url'>$item_title</a>";
                                    generate_menu($items, $menu_item->ID);
                                    echo '</li>';
                                }
                            }
                            echo '</ul>';
                        }
                        generate_menu($menu_items);
                        echo '</div>';
                    } else {
                        echo "No menu items found.";
                    }
                    ?>

<!------------------------------------------------------------------>      

                <div class="right-menu-for-mobile">
                        <ul class="mobile-menu">
                            <li class="mobile-menu-item">
                                <p class="mobile-parent_menu" id="obra-bienal">Bienales</p>
                                <ul class="mobile-submenu">
                                    <?php querry_menu('obra-bienal')?>
                                </ul>
                            </li>
                            <li class="mobile-menu-item">
                                <p class="mobile-parent_menu" id="obra-nombre_completo">Artistas</p>
                                <ul class="mobile-submenu">
                                    <?php querry_menu('obra-nombre_completo')?>
                                </ul>
                            </li>
                            <li class="mobile-menu-item">
                                <p class="mobile-parent_menu" id="obra-tecnica_materiales">Técnicas</p>
                                <ul class="mobile-submenu">
                                    <?php querry_menu('obra-tecnica_materiales')?>
                                </ul>
                            </li>
                            <li class="mobile-menu-item">
                                <p class="mobile-parent_menu" id="obra-nacionalidad">Nacionalidad</p>
                                <ul class="mobile-submenu">
                                    <?php querry_menu('obra-nacionalidad')?>
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
            <li class="menu-item">
                <p class="parent_menu" id='obra-bienal'>Bienales</p>
                <ul class="submenu">
                    <?php querry_menu('obra-bienal')?>
                </ul>
            </li>
            <li class="menu-item">
            <p class="parent_menu" id='obra-nombre_completo_an'>Artistas</p>
                <ul class="submenu">
                    <?php querry_menu('obra-nombre_completo_an')?> 
                </ul>
            </li>
            <li class="menu-item">
            <p class="parent_menu" id='obra-tecnica_materiales'>Técnicas</p>
                <ul class="submenu">
                    <?php querry_menu('obra-tecnica_materiales')?>
                </ul>
            </li>
            <li class="menu-item">       
            <p class="parent_menu" id='obra-nacionalidad'>Nacionalidad</p>
                <ul class="submenu">
                    <?php querry_menu('obra-nacionalidad')?>
                </ul>
            </li>
        </ul>
    </div>
</div>
    <script>
        let themeDir = '<?= get_stylesheet_directory_uri() ?>'
    </script> 