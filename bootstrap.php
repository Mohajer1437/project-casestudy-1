<?php
defined('ABSPATH') || exit;

$theme_dir = get_template_directory();

// لیست فایل‌های معمول:
$common_files = [
    '/theme/subscribe.php',
    '/theme/ajaxes.php',
    '/theme/menus.php',
    '/options/dollar-convert.php',
    '/options/options.php',
    '/services/services.php',
    '/_inc/Registerassets.php',
    '/_inc/wc-price-by-length.php',
    '/helper/to-jalali.php',
    '/_inc/converterDate.php',
    '/partials/breadcrumb/breadcrumbLogics.php',
    '/partials/archive-product-ideal/product-category-admin.php',
    '/partials/archive-product-ideal/other-parts.php',
    '/partials/archive-product-ideal/ideal-filter-archive_inc.php',
    '/_inc/filterProductAajax.php',
    '/partials/product-single/product-admin.php',
    '/partials/product-single/other-parts.php',
];

// بارگذاری با require_once و بررسی وجود فایل
foreach ( $common_files as $rel_path ) {
    $full = $theme_dir . $rel_path;
    if ( file_exists( $full ) ) {
        require_once $full;
    } else {
        error_log("IdealBoresh: فایل یافت نشد: {$full}");
    }
}

// بارگذاری فایل AJAX فقط در درخواست‌های AJAX:
add_action( 'init', function() use ( $theme_dir ) {
    if ( defined('DOING_AJAX') && DOING_AJAX ) {
        $ajax = $theme_dir . '/helper/handle_price_load_ajax.php';
        if ( file_exists( $ajax ) ) {
            require_once $ajax;
        } else {
            error_log("IdealBoresh: فایل AJAX یافت نشد: {$ajax}");
        }
    }
});
