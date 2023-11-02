<?php
        $terms = get_terms('categoria');
        if (!empty($terms)) {
            foreach ($terms as $term) {
                echo 'Term Name: ' . $term->name . '<br>';
                echo 'Term ID: ' . $term->term_id . '<br>';
                echo 'Term Slug: ' . $term->slug . '<br>';
                echo '<br>';
            }
        } else {
            echo 'No terms found in the "categoria" taxonomy.';
        }
?>