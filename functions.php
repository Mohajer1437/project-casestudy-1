<?php
include_once get_template_directory() . '/bootstrap.php';

function ideal_add_to_cart(){
    $product_id = absint($_POST['product_id']);
    $added = WC()->cart->add_to_cart($product_id);
    if($added){
        wp_send_json(['success'=>true]);
    }
}
add_action( 'wp_ajax_ideal_add_to_cart', 'ideal_add_to_cart' );
add_action( 'wp_ajax_nopriv_ideal_add_to_cart', 'ideal_add_to_cart' );


add_action( 'woocommerce_after_single_product_summary', 'remove_default_related_products', 1 );
function remove_default_related_products() {
    // این خط فراخوانی اصلی woocommerce_output_related_products را حذف می‌کند
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
}





// --- 1) ثبت زمان‌بندی 15 دقیقه برای Yoast (حل invalid_schedule) ---
add_filter('cron_schedules', function ($schedules) {
    $schedules['fifteen_minutes'] = [
        'interval' => 15 * 60,
        'display'  => __('Every 15 Minutes', 'your-textdomain'),
    ];
    return $schedules;
});

// --- 2) کاهش ریسک Timeout در کل HTTP و مخصوصاً public-api.wordpress.com ---
add_filter('http_request_args', function ($args, $url) {
    // Timeout معقول عمومی
    $args['timeout'] = 12;

    $host = wp_parse_url($url, PHP_URL_HOST);
    if ($host && stripos($host, 'public-api.wordpress.com') !== false) {
        // برای این هاست خاص سریع‌تر ببُر
        $args['timeout'] = 3;
        // ریترال‌ها یا ریدایرکت‌های اضافه را عملاً محدود کن
        $args['redirection'] = 1;
    }
    return $args;
}, 10, 2);

// --- 3) میان‌بُرِ درخواست‌های Experiments ووکامرس (بدون تایم‌اوت) ---
// پاسخ جعلی/خالی 200 می‌دهیم تا ماژول ووکامرس جلو برود و معطل شبکه نشود.
add_filter('pre_http_request', function ($pre, $args, $url) {
    $host = wp_parse_url($url, PHP_URL_HOST);
    if ($host && stripos($host, 'public-api.wordpress.com') !== false) {
        return [
            'headers'  => [],
            'body'     => wp_json_encode(['assignments' => []]), // پاسخ خالی قابل‌قبول
            'response' => ['code' => 200, 'message' => 'OK'],
            'cookies'  => [],
            'filename' => null,
        ];
    }
    return false; // سایر درخواست‌ها عادی بروند
}, 10, 3);

// --- 4) کم‌کردن درخواست‌های بیرونی ووکامرس (سجیشن/مارکت‌پلیس/ترکینگ) ---
add_action('init', function () {
    // خاموش کردن اجازه ترکینگ
    if (get_option('woocommerce_allow_tracking') !== 'no') {
        update_option('woocommerce_allow_tracking', 'no');
    }
    // پیشنهادهای مارکت‌پلیس
    if (get_option('woocommerce_show_marketplace_suggestions') !== 'no') {
        update_option('woocommerce_show_marketplace_suggestions', 'no');
    }
}, 20);

// برخی فیلترهای عمومی‌تر (اگر موجود باشند) برای کاهش نویز شبکه:
add_filter('woocommerce_allow_tracking', '__return_false');
add_filter('woocommerce_show_marketplace_suggestions', '__return_false');

// --- 5) (اختیاری) اگر اصلاً بخش Analytics جدید ووکامرس لازم نیست: ---
// فعال‌کردن این مورد کل WC Admin را غیرفعال می‌کند (داشبورد/آنالytics جدید).
// اگر نیاز داری، کامنت بماند.
// add_filter('woocommerce_admin_disabled', '__return_true');
if (!function_exists('DiscountCalculation')) {
    function DiscountCalculation($RegularPrice, $SalePrice): int
    {
        if (!$RegularPrice) return 0;
        return (int) ceil(($RegularPrice - $SalePrice) / $RegularPrice * 100);
    }
}
