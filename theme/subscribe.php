<?php
function theme_customizer_settings($wp_customize)
{
    // افزودن بخش جدید در تنظیمات قالب
    $wp_customize->add_section('theme_logo_section', array(
        'title' => 'تنظیمات لوگو',
        'priority' => 30,
        'description' => 'در این قسمت می‌توانید لوگوی سایت را آپلود کنید.',
    ));

    // افزودن تنظیم لوگو
    $wp_customize->add_setting('theme_logo', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // افزودن کنترل برای انتخاب لوگو
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_logo', array(
        'label' => 'آپلود لوگو',
        'section' => 'theme_logo_section',
        'settings' => 'theme_logo',
    )));
}

add_action('customize_register', 'theme_customizer_settings');

function theme_facilities_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    register_nav_menus(
        array(
            'header-other-menu' => 'منوی سایر (در موبایل قبل از منوی محصولات و در دسکتاپ بعد از منوی محصولات)',
            'header-mega-menu' => 'مگا منوی محصولات',
            'footer-menu-right' => 'منوی فوتر سمت راست',
            'footer-menu-middle' => 'منوی فوتر وسط',
            'footer-menu-left' => 'منوی فوتر سمت چپ',
        )
    );
}
add_action("after_setup_theme", "theme_facilities_setup");


function hide_contentinfo_in_admin_js()
{
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var contentInfoElement = document.querySelector("#wpfooter");
            if (contentInfoElement) {
                contentInfoElement.style.display = "none";
            }
        });
    </script>';
}
add_action('admin_footer', 'hide_contentinfo_in_admin_js');




function create_required_pages()
{
    $pages = [
        'front' => 'Front',
        'about' => 'About',
        'contact' => 'Contact',
        'blog' => 'Blog',
    ];

    $front_page_id = null;

    foreach ($pages as $slug => $title) {
        // بررسی اینکه آیا برگه از قبل وجود دارد
        $existing_page = get_page_by_path($slug);
        if (!$existing_page) {
            // ایجاد برگه جدید
            $page_id = wp_insert_post([
                'post_title' => $title,
                'post_name' => $slug,
                'post_status' => 'publish',
                'post_type' => 'page',
            ]);

            // اگر این برگه 'front' باشد، شناسه آن را ذخیره می‌کنیم
            if ($slug === 'front') {
                $front_page_id = $page_id;
            }
        } else {
            // اگر برگه 'front' از قبل وجود دارد، شناسه آن را ذخیره کنیم
            if ($slug === 'front') {
                $front_page_id = $existing_page->ID;
            }
        }
    }

    // تنظیم برگه 'front' به عنوان صفحه اصلی
    if ($front_page_id) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page_id);
    }
}

// اتصال تابع به هوک فعال‌سازی قالب
add_action('after_setup_theme', 'create_required_pages');


add_filter('posts_search', 'custom_product_search', 10, 2);
function custom_product_search($search, $wp_query)
{
    if (!empty($wp_query->query_vars['search_terms']) && $wp_query->query_vars['post_type'] === 'product') {
        global $wpdb;

        $search_terms = $wp_query->query_vars['search_terms'];
        $search = '';

        foreach ($search_terms as $term) {
            $term = esc_sql($wpdb->esc_like($term));
            $search .= " AND (
                ({$wpdb->posts}.post_title LIKE '%{$term}%')
                OR ({$wpdb->posts}.post_content LIKE '%{$term}%')
                OR ({$wpdb->posts}.post_excerpt LIKE '%{$term}%')
                OR EXISTS (
                    SELECT 1 FROM {$wpdb->postmeta}
                    WHERE post_id = {$wpdb->posts}.ID
                    AND meta_key IN ('_sku', '_product_attributes')
                    AND meta_value LIKE '%{$term}%'
                )
                OR EXISTS (
                    SELECT 1 FROM {$wpdb->terms}
                    INNER JOIN {$wpdb->term_taxonomy} ON {$wpdb->term_taxonomy}.term_id = {$wpdb->terms}.term_id
                    INNER JOIN {$wpdb->term_relationships} ON {$wpdb->term_relationships}.term_taxonomy_id = {$wpdb->term_taxonomy}.term_taxonomy_id
                    WHERE taxonomy IN ('product_cat', 'product_tag')
                    AND {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id
                    AND {$wpdb->terms}.name LIKE '%{$term}%'
                )
            )";
        }

        return $search;
    }
    return $search;
}


;
function enqueue_select2_for_admin()
{
    wp_enqueue_style('select2-css', get_template_directory_uri() . '/assets/css/select2.css');
    wp_enqueue_script('select2-js', get_template_directory_uri() . '/assets/js/select2.js', ['jquery'], null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_select2_for_admin');




function create_contact_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_form';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        fullname varchar(100) NOT NULL,
        phone varchar(15) NOT NULL,
        message text NOT NULL,
        ip_address varchar(45) NOT NULL,
        status boolean NOT NULL DEFAULT 0,
        created_at datetime NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'create_contact_table');



add_action('wp_enqueue_scripts', 'register_contact_form_scripts');
function register_contact_form_scripts()
{
    wp_enqueue_script('jquery');
    wp_localize_script('jquery', 'contactForm', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('contact_form_nonce')
    ));
}

function enable_threaded_comments()
{
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'enable_threaded_comments');


function custom_comments_list($comment, $args, $depth)
{
    ?>
    <li <?php comment_class('mb-6'); ?> id="li-comment-<?php comment_ID() ?>">
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex items-start gap-x-4 mb-4">
                <?php
                // مسیر تصویر placeholder در پوشه پوسته
                $placeholder = get_template_directory_uri() . '/assets/img/avatar-placeholder.svg';

                echo get_avatar(
                    $comment,              // شناسه یا کامنت
                    48,                    // اندازه آواتار
                    $placeholder,          // آدرس تصویر پیش‌فرض
                    '',                    // متن alt (اختیاری)
                    [                      // آرگومان‌های اضافی
                        'class' => 'w-12 h-12 rounded-full'
                    ]
                );
                ?>
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <span class="font-medium">
                            <?php comment_author_link(); ?>
                        </span>
                        <span class="text-sm text-gray-500">
                            <?php comment_date('Y/m/d'); ?>
                        </span>
                    </div>
                    <div class="comment-text mt-2">
                        <?php comment_text(); ?>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <?php
}


function woocommerce_enqueue_styles()
{
    if (function_exists('is_cart') && is_cart()) {
        wp_enqueue_style('custom-cart-css', get_template_directory_uri() . '/assets/css/cart.css', array(), '1.0.0');
    }

    if (function_exists('is_checkout') && is_checkout()) {
        wp_enqueue_style('custom-checkout-css', get_template_directory_uri() . '/assets/css/checkout.css', array(), '1.0.0');
    }

    if (function_exists('is_wc_endpoint_url') && is_wc_endpoint_url('lost-password')) {
        wp_enqueue_style('custom-lost-password-css', get_template_directory_uri() . '/assets/css/lost-password.css', array(), '1.0.0');
    }

    if (function_exists('is_account_page') && is_account_page()) {
        wp_enqueue_style('custom-login-css', get_template_directory_uri() . '/assets/css/login.css', array(), '1.0.0');
    }
}
add_action('wp', 'woocommerce_enqueue_styles');




// ۱. تغییر ترتیب و محتویات تب‌ها
add_filter('woocommerce_product_tabs', 'custom_product_tabs', 98);
function custom_product_tabs($tabs)
{
    // حذف تب‌های پیش‌فرض
    unset($tabs['additional_information']);
    unset($tabs['reviews']);

    // ۱) تب مشخصات فنی
    $tabs['specs'] = [
        'title' => __('مشخصات فنی', 'idealboresh'),
        'priority' => 5,
        'callback' => 'specs_tab_content_cb',
    ];

    // ۲) تب توضیحات محصول (اضافه یا ویرایش تب پیش‌فرض)
    $tabs['description'] = [
        'title' => __('توضیحات محصول', 'woocommerce'),
        'priority' => 10,
        'callback' => 'woocommerce_product_description_tab',
    ];

    // ۳) تب محصولات مرتبط (فقط تا ۳ محصول)
    $tabs['related_products'] = [
        'title' => __('محصولات مرتبط', 'idealboresh'),
        'priority' => 15,
        'callback' => 'related_products_tab_content_cb',
    ];

    // ۴) تب مشاوره رایگان
    $tabs['free_consultation'] = [
        'title' => __('مشاوره رایگان', 'idealboresh'),
        'priority' => 20,
        'callback' => 'free_consultation_tab_content_cb',
    ];

    // ۵) تب کاتالوگ
    $tabs['catalog'] = [
        'title' => __('کاتالوگ', 'idealboresh'),
        'priority' => 25,
        'callback' => 'catalog_tab_content_cb',
    ];

    // ۶) تب نظرات (بازیابی تب نظرات با اولویت دلخواه)
    $tabs['reviews'] = [
        'title' => __('نظرات', 'woocommerce'),
        'priority' => 30,
        'callback' => '__return_empty_string',
    ];

    return $tabs;
}

// کال‌بک تب «مشخصات فنی»
function specs_tab_content_cb()
{

    global $product;
    echo '<h2 style="margin:1rem 0;" class="text-xl font-bold">' . esc_html($product->get_name()) . '</h2>';
    if ($short_desc = $product->get_short_description()) {
        echo '<div class="product-short-description prose lg:prose-lg my-6">';
        echo wp_kses_post(wpautop($short_desc));
        echo '</div>';
    }
    // اگر فانکشن‌تان برای نمایش ویژگی‌ها را دارید، همین را صدا بزنید:
    if (function_exists('custom_product_attribute')) {
        custom_product_attribute();
    } else {
        echo '<p>مشخصات فنی این محصول موجود نیست.</p>';
    }
}

// کال‌بک تب «محصولات مرتبط»
function related_products_tab_content_cb()
{

}

// کال‌بک تب «مشاوره رایگان»
function free_consultation_tab_content_cb()
{

    $phone_number = get_option('header_phone_number', '');
    if ($phone_number) {

        echo '<div style="display:block; margin: 2rem auto; width: fit-content;" class="tracking-wider">برای مشاوره رایگان با شماره <a href="tel:' . esc_html($phone_number) . '">' . esc_html($phone_number) . '</a> تماس بگیرید</div>';
    }
}

// کال‌بک تب «کاتالوگ»
function catalog_tab_content_cb()
{
    // فرض کنید آدرس PDF کاتالوگ در متای محصول ذخیره شده:
    $media_id = get_post_meta(get_the_ID(), 'catalog_media_id', true);
    if ($media_id && $url = wp_get_attachment_url($media_id)) {
        echo '<style>
            div#tab-catalog {
                padding: 3rem;
            }
            div#tab-catalog a.button {
                padding: 0.75rem 1.25rem;
                background: #e5e5e5;
                color: #282828;
                border-radius: 8px;
                width: fit-content;
                display: flex;
                margin: 0 auto;
                gap: 9px;
            }
        </style>';
        echo '<a href="' . esc_url($url) . '" class="button download flex gap-x-2 lg:px-5 px-4 py-2 lg:py-3 bg-neutral-200 w-fit rounded-xl shadow-md">دانلود کاتالوگ 
                <div>
                    <svg class="w-5 h-5">
                        <use href="#book2"></use>
                    </svg>
                </div>
                </a>';
    } else {
        echo '<p style="display: block !important; margin: 0 auto !important; width: fit-content !important; padding: 2rem !important;">کاتالوگ برای این محصول موجود نیست.</p>';
    }
}



// 1) از رندر پنل «محصولات مرتبط» جلوگیری می‌کنیم
add_filter('woocommerce_product_tabs', 'customize_related_products_tab', 99);
function customize_related_products_tab($tabs)
{
    if (isset($tabs['related_products'])) {
        // کال‌بک را خالی می‌گذاریم
        $tabs['related_products']['callback'] = '__return_empty_string';
    }
    return $tabs;
}

// 2) یک anchor برای اسکرول قرار می‌دهیم (پایین تب‌ها)
//    می‌توانید این div را دقیقاً بالای جایی که محصولات مرتبط را خروجی می‌دهید، مراحل زیر یا جای دلخواه قرار دهید
add_action('woocommerce_product_after_tabs', 'add_related_products_anchor', 5);
function add_related_products_anchor()
{
    echo '<div id="related-products"></div>';
}

add_action('wp_footer', 'custom_related_products_tab_js', 100);
function custom_related_products_tab_js()
{
    if (!is_product()) {
        return;
    }
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var li = document.querySelector('.related_products_tab');
            if (!li) return;

            var a = li.querySelector('a');
            if (a) {
                a.setAttribute('href', '#related-products');

                a.addEventListener('click', function (e) {
                    e.preventDefault();
                    // فقط هش URL رو بدون اسکرول تغییر می‌دهیم
                    history.pushState(null, '', '#related-products');
                });
            }

            // پنهان کردن پنل خالی
            var panel = document.getElementById('tab-related_products');
            if (panel) {
                panel.style.display = 'none';
            }
        });
    </script>
    <?php
}




add_filter('woocommerce_product_tabs', 'customize_related_products_tab2', 99);
function customize_related_products_tab2($tabs)
{
    if (isset($tabs['related_products'])) {
        // خالی کردن callback تا پنل رندر نشود
        $tabs['related_products']['callback'] = '__return_empty_string';
    }
    return $tabs;
}

// 2) قرار دادن anchor برای محصولات مرتبط
add_action('woocommerce_product_after_tabs', 'add_related_products_anchor2', 5);
function add_related_products_anchor2()
{
    echo '<div id="related-products"></div>';
}

add_action('wp_footer', 'idealboresh_custom_tab_behavior_js', 100);
function idealboresh_custom_tab_behavior_js()
{
    if (!is_product()) {
        return;
    }
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // — تب «محصولات مرتبط» بدون اسکرول —
            var relA = document.querySelector('.related_products_tab a');
            if (relA) {
                relA.setAttribute('href', '#related-products');
                relA.addEventListener('click', function (e) {
                    e.preventDefault();
                    history.pushState(null, '', '#related-products');
                });
            }

            // — تب «نظرات» با اسکرول به المان موجود روی صفحه —
            var revA = document.querySelector('.reviews_tab a');
            if (revA) {
                revA.setAttribute('href', '#reviews');
                revA.addEventListener('click', function (e) {
                    e.preventDefault();
                    history.pushState(null, '', '#reviews');
                    var target = document.getElementById('reviews');
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }
        });
    </script>
    <?php
}



add_action('wp_footer', 'mobile_idealboresh_custom_tab_behavior_js', 100);
function mobile_idealboresh_custom_tab_behavior_js()
{
    if (!is_product()) {
        return;
    }
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // فقط در موبایل (مثلاً زیر 768px)
            if (window.innerWidth > 768) return;

            // نگاشت هر تب به سلکتور لینک و المان هدف
            var tabs = [
                { selector: '.specs_tab a', target: document.getElementById('tab-specs') },
                { selector: '.description_tab a', target: document.getElementById('tab-description') },
                { selector: '.related_products_tab a', target: document.getElementById('related-products') },
                { selector: '.free_consultation_tab a', target: document.getElementById('tab-free_consultation') },
                { selector: '.catalog_tab a', target: document.getElementById('tab-catalog') },
                { selector: '.reviews_tab a', target: document.getElementById('reviews') }
            ];

            tabs.forEach(function (tab) {
                var link = document.querySelector(tab.selector);
                var panel = tab.target;
                if (!link || !panel) return;

                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    // تغییر هش آدرس بدون اسکرول خودکار مرورگر
                    history.pushState(null, '', '#' + panel.id);
                    // محاسبه موقعیت مطلق المان
                    var topPos = panel.getBoundingClientRect().top + window.pageYOffset;
                    // اسکرول نرم با آفست 170px
                    window.scrollTo({ top: topPos - 170, behavior: 'smooth' });
                });
            });
        });
    </script>
    <?php
}

add_action('add_meta_boxes', 'ib_register_catalog_metabox');
function ib_register_catalog_metabox()
{
    add_meta_box(
        'ib_catalog_pdf',                // شناسه
        'کاتالوگ محصول',               // عنوان
        'ib_catalog_metabox_callback',  // کال‌بک
        'product',                      // نمایش روی محصول ووکامرس
        'side',                         // موقعیت: ستون کناری
        'default'                       // اولویت
    );
}

// 2) نمایش HTML درون متاباکس
function ib_catalog_metabox_callback($post)
{
    wp_nonce_field('ib_save_catalog_meta', 'ib_catalog_meta_nonce');

    $media_id = get_post_meta($post->ID, 'catalog_media_id', true);
    $url = $media_id ? wp_get_attachment_url($media_id) : '';

    echo '<div id="ib_catalog_preview">';
    if ($url) {
        // اگر فایل قبلاً انتخاب شده، لینک و دکمه حذف را نمایش بده
        printf(
            '<p><a href="%1$s" target="_blank">%2$s</a></p>
             <p><button class="button" id="ib_catalog_remove">حذف فایل</button></p>',
            esc_url($url),
            esc_html(basename($url))
        );
    }
    echo '</div>';

    // فیلد مخفی برای نگهداری attachment ID
    printf(
        '<input type="hidden" id="catalog_media_id" name="catalog_media_id" value="%s">',
        esc_attr($media_id)
    );

    // دکمهٔ انتخاب/تغییر
    echo '<p><button class="button" id="ib_catalog_select">انتخاب فایل کاتالوگ</button></p>';
}

// 3) enqueue کردن اسکریپت رسانه در ادمین
add_action('admin_enqueue_scripts', 'ib_enqueue_media_scripts');
function ib_enqueue_media_scripts($hook)
{
    if (!in_array($hook, ['post.php', 'post-new.php'], true)) {
        return;
    }
    global $post;
    if ($post->post_type !== 'product') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script(
        'ib-catalog-media',
        get_template_directory_uri() . '/assets/js/ib-catalog-media.js',
        ['jquery'],
        false,
        true
    );
}

// 4) ذخیرهٔ متا
add_action('save_post', 'ib_save_catalog_meta');
function ib_save_catalog_meta($post_id)
{
    if (
        !isset($_POST['ib_catalog_meta_nonce']) ||
        !wp_verify_nonce($_POST['ib_catalog_meta_nonce'], 'ib_save_catalog_meta') ||
        defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ||
        'product' !== get_post_type($post_id) ||
        !current_user_can('edit_post', $post_id)
    ) {
        return;
    }

    $media_id = isset($_POST['catalog_media_id']) ? intval($_POST['catalog_media_id']) : '';
    if ($media_id) {
        update_post_meta($post_id, 'catalog_media_id', $media_id);
    } else {
        delete_post_meta($post_id, 'catalog_media_id');
    }
}

function idealboresh_custom_comment_title( $defaults ) {
    // عنوان اصلی را به متن دلخواه تغییر می‌دهیم
    $defaults['title_reply'] = 'نظر خود را در مورد این محصول بنویسید…';
    return $defaults;
}

// ۲) فیلتر را ثبت می‌کنیم
add_filter( 'comment_form_defaults', 'idealboresh_custom_comment_title' );


// غیرفعال‌سازی نمایش همه‌ی نوتیفیکیشن‌ها در نقاط مختلف
function idealboresh_disable_woocommerce_notices() {
    // قبل از صفحه محصول تکی
    remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
    // قبل از لیست محصولات (آرشیو / شاپ)
    remove_action( 'woocommerce_before_shop_loop',     'woocommerce_output_all_notices', 10 );
}
add_action( 'init', 'idealboresh_disable_woocommerce_notices' );

// غیرفعال کردن پیام موفقیت‌آمیزِ افزودن به سبد
add_filter( 'wc_add_to_cart_message_html', '__return_empty_string' );