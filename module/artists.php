<?php
        $args = array(
            'post_type'      => 'obra',
            'posts_per_page' => -1,
        );

        $query       = new WP_Query($args);
        $values      = array();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $field_value = get_field('obra-nombre_completo');
                if (!empty($field_value)) {
                    $values[] = $field_value;
                }
            }
        }
        wp_reset_postdata();
        $value_counts = array_count_values($values);
        ksort($value_counts);

        $result = array();
        foreach ($value_counts as $value => $count) {
            $result[] = array(
                'value' => $value,
                'count' => $count,
            );
        }

        header('Content-Type: application/json');
        echo json_encode($result);
?>
