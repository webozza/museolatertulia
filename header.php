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

                  <!------------------------------------------------------------------ -->


                  <?php
$menu_location = 'main-menu';
$menu_items = wp_get_nav_menu_items($menu_location);

// Check if there are any menu items
if ($menu_items) {
    echo '<div class="date-menu"><ul>';

    $current_year = null;

    // Function to recursively generate menu items
    function generate_menu($items, $parent_id = 0) {
        echo '<ul>';
        foreach ($items as $menu_item) {
            // Access menu item properties
            $item_title = $menu_item->title;
            $item_url = $menu_item->url;
            $menu_date = get_post_meta($menu_item->ID, '_menu_item_menu_date', true); // Assuming there is a custom field named '_menu_item_menu_date'
            $menu_parent = $menu_item->menu_item_parent;

            // Check if the item is a child of the current parent
            if ($menu_parent == $parent_id) {
                // Check if the year has changed
                if ($menu_date !== $GLOBALS['current_year']) {
                    // If it has, close the previous year's submenu and open a new one
                    if ($GLOBALS['current_year'] !== null) {
                        echo '</ul></li>';
                    }
                    // Output the menu item in the specified format
                    echo "<li class='top-level-menu'><p class='menu_date'>$menu_date</p><ul>";
                    $GLOBALS['current_year'] = $menu_date;
                }
                // Output the menu item in the specified format
                echo "<li><a href='$item_url'>$item_title</a>";

                // Recursively call the function for child items
                generate_menu($items, $menu_item->ID);

                echo '</li>';
            }
        }
        echo '</ul>';
    }

    // Call the recursive function with the top-level menu items
    generate_menu($menu_items);

    // Close the last submenu and the overall list
    echo '</div>';
} else {
    echo "No menu items found.";
}
?>


                  <!------------------------------------------------------------------ -->


                <div class="date-menu">
                    <ul>
                        <li class="top-level-menu">
                            <a href="<?= site_url();?>">Start</a>
                        </li>

                        <li class="top-level-menu">
                        <p class='menu_date'>1971</p>
                            <ul class="submenu">
                                <li>map</li>
                                <li>biennial</li>
                                <li>categories</li>
                                <li>artists</li>
                                <!-- <li>resources</li> -->
                            </ul>
                        </li>

                        <li class="top-level-menu">
                        <p class='menu_date'>1973</p>
                            <ul class="submenu">
                                <li>map</li>
                                <li>biennial</li>
                                <li>categories</li>
                                <li>artists</li>
                                <!-- <li>resources</li> -->
                            </ul>
                        </li>
                        <li class="top-level-menu">
                            <p class='menu_date'>1976</p>
                            <ul  class="submenu">
                                <li>map</li>
                                <li>biennial</li>
                                <li>categories</li>
                                <li>artists</li>
                                <!-- <li>resources</li> -->
                            </ul>
                        </li>
                    </ul>
                </div>

                  <!-------------------------------------------------------------------->

                <div class="page_link">
                    <ul>
                        <li class='el_projecto'>El Projecto</li>
                        <li class='equipo'>Epuipo</li>
                    </ul>
                </div>
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