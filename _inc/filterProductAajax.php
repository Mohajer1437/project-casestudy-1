<?php

add_action('wp_ajax_ideal_Lode_more_products', 'ideal_Lode_more_products');
add_action('wp_ajax_nopriv_ideal_Lode_more_products', 'ideal_Lode_more_products');
function ideal_Lode_more_products()
{
    // ۱. دیکد کردن پارامترهای AJAX
    $filter_att = json_decode(stripslashes($_POST['filter_att']), true);
    $page_att = json_decode(stripslashes($_POST['page_att']), true);
    $per_page = (int) apply_filters(
        'loop_shop_per_page',
        wc_get_default_products_per_row() * wc_get_default_product_rows_per_page()
    );
    if ($per_page <= 0) {
        $per_page = (int) get_option('posts_per_page', 12);
    }

    // ۲. ساختن tax_query
    $tax_query = [
        [
            'taxonomy' => $page_att[0]['data_mobile_taxonomy'],
            'field' => 'term_id',
            'terms' => $page_att[0]['data_mobile_termid'],
            'operator' => 'IN',
        ],
    ];
    foreach ($filter_att as $item) {
        $tax_query[] = [
            'taxonomy' => $item['data_product_attribute'],
            'field' => 'term_id',
            'terms' => $item['value_option'],
            'operator' => 'IN',
        ];
    }

    // ۳. آرگومان‌های WP_Query
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $per_page,
        'offset' => max(0, (int) $_POST['offset']),
        'meta_key' => '_stock_status',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => [
            'relation' => 'OR',
            [
                'key' => '_stock_status',
                'value' => 'instock',
                'compare' => '=',
            ],
            [
                'key' => '_stock_status',
                'value' => 'outofstock',
                'compare' => '=',
            ],
        ],
        'tax_query' => $tax_query,
    ];

    // ۴. اجرای کوئری
    $the_query = new WP_Query($args);
    $card_layout = '';

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            // ۵. بافر کردن خروجی content-product.php
            ob_start();
            wc_get_template_part('content', 'product');
            $card_layout .= ob_get_clean();
        }
        wp_reset_postdata();

        // ۶. پاک‌سازی فضاهای اضافی (اختیاری)
        $card_layout = str_replace("\n", "", $card_layout);
        $card_layout = preg_replace('/\s+/', ' ', $card_layout);

        // ۷. برگرداندن JSON با کلیدهای contetnt و founded
        wp_send_json([
            'success' => true,
            'contetnt' => $card_layout,
            'founded' => (int) $the_query->found_posts,
            'per_page' => (int) $per_page,
            'max_pages' => (int) $the_query->max_num_pages,
        ], 200);

    } else {
        wp_send_json([
            'error' => true,
            'contetnt' => '<div class="font-sansRegular p-2 text-zinc-700 bg-zinc-200 rounded-xl col-span-2 lg:col-span-3">محصولی یافت نشد.</div>',
        ], 403);
    }
}
