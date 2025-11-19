<?php
function get_popular_attributes_in_category($category_id, $min_products = 4) {
    global $wpdb;

    // 1. دریافت تمام زیردسته‌ها
    $child_terms = get_terms([
        'taxonomy' => 'product_cat',
        'child_of' => $category_id,
        'fields' => 'ids',
        'hide_empty' => false
    ]);
    

    $all_term_ids = array_unique(array_merge([$category_id], $child_terms));
    $term_ids_string = implode(',', array_map('absint', $all_term_ids));

    // 2. کوئری اصلاح شده با لاگ کامل
    $query = "
        SELECT tax.taxonomy, COUNT(DISTINCT p.ID) as product_count
        FROM {$wpdb->posts} AS p
        INNER JOIN {$wpdb->term_relationships} AS cat_rel ON p.ID = cat_rel.object_id
        INNER JOIN {$wpdb->term_taxonomy} AS cat_tax ON cat_rel.term_taxonomy_id = cat_tax.term_taxonomy_id
        INNER JOIN {$wpdb->term_relationships} AS attr_rel ON p.ID = attr_rel.object_id
        INNER JOIN {$wpdb->term_taxonomy} AS tax ON attr_rel.term_taxonomy_id = tax.term_taxonomy_id
        WHERE p.post_type = 'product'
        AND p.post_status = 'publish'
        AND cat_tax.taxonomy = 'product_cat'
        AND cat_tax.term_id IN ($term_ids_string)
        AND tax.taxonomy LIKE 'pa_%'
        GROUP BY tax.taxonomy
        HAVING product_count >= %d
    ";

    $results = $wpdb->get_results($wpdb->prepare($query, $min_products), ARRAY_A);


    $attributes = [];

    foreach ($results as $row) {
        $taxonomy = $row['taxonomy'];
        
        $terms = get_terms([
            'taxonomy'   => $taxonomy,
            'hide_empty' => true,
        ]);


        $attributes[$taxonomy] = array_map(function ($term) {
            return [
                'id'   => $term->term_id,
                'name' => $term->name
            ];
        }, $terms);
    }

    return $attributes;
}