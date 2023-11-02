<?php
        $terms = get_terms('categoria');

        if (!empty($terms)) {
            echo '<ul>';
            foreach ($terms as $term) {
                // Get the number of posts associated with the term
                $term_count = $term->count;

                echo '<li class="' . $term->slug . '">';
                echo  $term->name;
                echo '( ' . $term_count . ')';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo 'No terms found in the "categoria" taxonomy.';
        }
?>