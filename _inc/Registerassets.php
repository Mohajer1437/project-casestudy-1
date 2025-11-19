<?php
function ideal_assets(){

    if (is_product_category()) {
        // فقط در صفحات دسته‌بندی محصول
        wp_register_script('ideal_tabs', get_stylesheet_directory_uri() . '/assets/js/tabs.js', [], '', ['in_footer' => true]);
        wp_enqueue_script('ideal_tabs');
    }

    if (is_product()) {
        // فقط در صفحات محصول
        wp_register_script('single_script', get_stylesheet_directory_uri() . '/assets/js/script-single.js', [], '', ['in_footer' => true]);
        wp_enqueue_script('single_script');
    }
}

add_action('wp_enqueue_scripts','ideal_assets');