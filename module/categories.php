<?php
        $terms = get_terms('categoria');
        if (!empty($terms)) {
            echo '<ul>';
            foreach ($terms as $term) {
                // var_dump($term);
                $term_count = $term->count;
                echo '<li id="' . $term->term_id . '">';
                echo  $term->name;
                echo '( ' . $term_count . ')';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo 'No terms found in the "categoria" taxonomy.';
        }
?>