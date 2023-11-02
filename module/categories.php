<?php
        $terms = get_terms('categoria');
        if (!empty($terms)) {
            echo '<ul>';
            foreach ($terms as $term) {
                $term_count = $term->count;
                echo '<li id="' . $term->id . '">';
                echo  $term->name;
                echo '( ' . $term_count . ')';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo 'No terms found in the "categoria" taxonomy.';
        }
?>