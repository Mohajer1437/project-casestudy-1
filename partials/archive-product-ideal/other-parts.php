<?php
// ۱) فیلتر را با ۳ آرگومان (HTML, post, product) ثبت می‌کنیم
add_filter('woocommerce_sale_flash', 'idealboresh_edit_sale_alert', 10, 3);
function idealboresh_edit_sale_alert($html, $post, $product)
{
    // فقط اگر محصول در حال حراج باشد
    if (!$product->is_on_sale()) {
        return $html;
    }

    // ۲) محاسبه درصد تخفیف
    if ($product->is_type('variable')) {
        // برای متغیر: بیشینه قیمت عادی و کمینه قیمت حراج
        $max_regular = (float) $product->get_variation_regular_price('max');
        $min_sale = (float) $product->get_variation_sale_price('min');
        $percentage = $max_regular > 0
            ? round((($max_regular - $min_sale) / $max_regular) * 100)
            : 0;
    } else {
        // برای ساده: قیمت عادی و قیمت حراج
        $regular = (float) $product->get_regular_price();
        $sale = (float) $product->get_sale_price();
        $percentage = $regular > 0
            ? round((($regular - $sale) / $regular) * 100)
            : 0;
    }

    // ۳) خروجی HTML با percent sign فارسی
    return sprintf(
        '<span style="z-index: 29; top: 20px; right: 10px;" class="absolute bg-[#D0082C] font-sansFanumBold text-white px-3 py-2 rounded-xl">٪%d</span>',
        $percentage
    );
}



function custom_loop_shop_per_page($products)
{
    return 12; // تعداد محصولات در هر صفحه
}
add_filter('loop_shop_per_page', 'custom_loop_shop_per_page', 20);


remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);


function ideal_ajax_scripts()
{
    if (is_product_category()) {
        wp_enqueue_script('ideal-ajax-handle', get_template_directory_uri() . '/assets/js/LoadMore_archive.js', array('jquery'), null, true);

        wp_localize_script('ideal-ajax-handle', 'ideal_ajax_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ideal-ajax-nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'ideal_ajax_scripts');


// غیرفعال کردن سورت پیش‌فرض ووکامرس
add_action('init', 'remove_default_woocommerce_sorting');
function remove_default_woocommerce_sorting()
{
    // اگر نسخه‌ی ووکامرس شما priority=30 است:
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    // برای اطمینان می‌توانید این گزینه را هم اضافه کنید:
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
}
