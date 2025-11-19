<?php
function add_ajax_script()
{
?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
<?php
}
add_action('wp_footer', 'add_ajax_script');


add_action('wp_ajax_save_slider_settings', 'save_slider_settings_callback');
function save_slider_settings_callback()
{
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'save_slider_data')) {
        wp_send_json_error(['message' => 'خطای امنیتی.']);
        wp_die();
    }
    parse_str($_POST['form_data'], $form_data);
    if (isset($form_data['slider_items'])) {
        $slider_data = array_map(function ($item) {
            return [
                'image' => sanitize_text_field($item['image']),
                'mobile_image' => sanitize_text_field($item['mobile_image']),
                'url' => esc_url_raw($item['url']),
            ];
        }, $form_data['slider_items']);
        update_option('front_page_slider', $slider_data);
        wp_send_json_success(['message' => 'تنظیمات با موفقیت ذخیره شد.']);
    } else {
        wp_send_json_error(['message' => 'داده‌ای ارسال نشده است.']);
    }
    wp_die();
}


function save_shortcuts()
{
    if (isset($_POST['shortcuts'])) {
        $shortcuts = $_POST['shortcuts'];
        update_option('frontpage_shortcuts', $shortcuts);
        wp_send_json_success('ذخیره شد!');
    } else {
        wp_send_json_error('خطا در دریافت داده‌ها!');
    }
}
add_action('wp_ajax_save_shortcuts', 'save_shortcuts');



add_action('wp_ajax_save_floating_contact', function () {
    check_ajax_referer('save_floating_contact', 'security');
    $data = [
        'contact_icon' => sanitize_text_field($_POST['contact_icon'] ?? ''),
        'contact_number' => sanitize_text_field($_POST['contact_number'] ?? ''),
        'contact_url' => esc_url_raw($_POST['contact_url'] ?? ''),
        'whatsapp_icon' => sanitize_text_field($_POST['whatsapp_icon'] ?? ''),
        'whatsapp_number' => sanitize_text_field($_POST['whatsapp_number'] ?? '')
    ];
    update_option('floating_contact', $data);
    wp_send_json_success('تنظیمات ذخیره شد.');
});


function save_header_phone_number()
{
    check_ajax_referer('save_phone_number_nonce', 'security');

    if (!current_user_can('manage_options')) {
        wp_send_json_error('شما دسترسی لازم را ندارید.');
    }

    if (isset($_POST['phone_number'])) {
        $phone_number = sanitize_text_field($_POST['phone_number']);
        update_option('header_phone_number', $phone_number);
        wp_send_json_success('شماره تماس ذخیره شد.');
    } else {
        wp_send_json_error('لطفا شماره تماس را وارد کنید.');
    }
}
add_action('wp_ajax_save_header_phone_number', 'save_header_phone_number');



// افزودن nonce به هدر برای استفاده در فرانت‌اند
function add_search_nonce_meta() {
    echo '<meta name="search_nonce" content="' . wp_create_nonce('search_nonce') . '">';
}
add_action('wp_head', 'add_search_nonce_meta');

// ثبت اکشن‌های AJAX برای کاربران لاگین و مهمان
add_action('wp_ajax_header_product_search', 'handle_header_product_search');
add_action('wp_ajax_nopriv_header_product_search', 'handle_header_product_search');

function handle_header_product_search() {
    // بررسی امنیتی
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'search_nonce')) {
        wp_send_json_error(['message' => 'درخواست نامعتبر'], 400);
    }

    // بررسی مقدار ورودی
    $search_term = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    if (empty($search_term)) {
        wp_send_json_error(['message' => 'عبارت جستجو خالی است'], 400);
    }

    // تنظیمات کوئری
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => 10, // محدود کردن تعداد نتایج
        's'             => $search_term,
    ];

    $query = new WP_Query($args);

    // خروجی نتایج
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <a href="<?php echo get_permalink(); ?>" class="produst-result flex items-center justify-between p-2 gap-2">
                <div class="flex items-center gap-2">
                    <?php if (has_post_thumbnail()): ?>
                        <img width="30" height="30" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>"
                            alt="<?php the_title(); ?>" class="w-[50px] h-auto">
                    <?php endif; ?>
                    <p class="text-[12px] lg:text-[14px] truncate">
                        <?php the_title(); ?>
                    </p>
                </div>
            </a>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<div class="no-results">نتیجه ای یافت نشد</div>';
    }

    wp_die();
}


function save_enamad_code() {
    check_ajax_referer('save_enamad_nonce', 'security');

    if (!current_user_can('manage_options')) {
        wp_send_json_error('دسترسی غیرمجاز');
    }

    $iframe_code = isset($_POST['enamad_code']) ? wp_unslash($_POST['enamad_code']) : '';
    
    update_option('footer_enamad', $iframe_code);

    wp_send_json_success('ذخیره شد!');
}
add_action('wp_ajax_save_enamad_code', 'save_enamad_code');



function save_social_icons()
{
    if (isset($_POST['social_icons'])) {
        update_option('footer_social_icons', json_encode($_POST['social_icons']));
    }
    wp_die();
}
add_action('wp_ajax_save_social_icons', 'save_social_icons');



function save_footer_addresses() {
    check_ajax_referer('save_footer_addresses_nonce', 'security');

    if (!current_user_can('manage_options')) {
        wp_send_json_error('دسترسی غیرمجاز');
    }

    // دریافت و پاکسازی اطلاعات ورودی
    $footer_addresses = isset($_POST['footer_addresses']) ? $_POST['footer_addresses'] : array();
    $footer_addresses['text']  = isset($footer_addresses['text'])  ? wp_unslash($footer_addresses['text'])  : '';
    $footer_addresses['email'] = isset($footer_addresses['email']) ? sanitize_email($footer_addresses['email']) : '';
    $footer_addresses['phone'] = isset($footer_addresses['phone']) ? sanitize_text_field($footer_addresses['phone']) : '';
    
    update_option('footer-addresses', $footer_addresses);

    wp_send_json_success('ذخیره شد!');
}
add_action('wp_ajax_save_footer_addresses', 'save_footer_addresses');



add_action('wp_ajax_save_homepage_first_categories', 'save_homepage_first_categories');
function save_homepage_first_categories() {
    // ذخیره دسته‌بندی‌ها
    if (isset($_POST['categories'])) {
        update_option('hompage-first-categories', $_POST['categories']);
    } else {
        wp_send_json_error('دسته‌بندی انتخاب نشده است.');
    }
    
    // ذخیره عنوان بخش
    if (isset($_POST['section_title'])) {
        update_option('hompage-first-categories-title', sanitize_text_field($_POST['section_title']));
    }

    wp_send_json_success();
}

add_action('wp_ajax_save_homepage_second_categories', 'save_homepage_second_categories');
function save_homepage_second_categories() {
    // ذخیره دسته‌بندی‌ها
    if (isset($_POST['categories'])) {
        update_option('hompage-second-categories', $_POST['categories']);
    } else {
        wp_send_json_error('دسته‌بندی انتخاب نشده است.');
    }
    
    // ذخیره عنوان بخش
    if (isset($_POST['section_title'])) {
        update_option('hompage-second-categories-title', sanitize_text_field($_POST['section_title']));
    }

    wp_send_json_success();
}



add_action('wp_ajax_save_frontpage_category', 'save_frontpage_category');
function save_frontpage_category()
{
    if (isset($_POST['category_id'])) {
        $category_id = sanitize_text_field($_POST['category_id']);
        update_option('frontpage_new_products', $category_id);

        wp_send_json_success(['message' => 'دسته‌بندی با موفقیت ذخیره شد!']);
    } else {
        wp_send_json_error(['message' => 'دسته‌بندی ارسال نشده است.']);
    }
}


function save_selected_brands() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'دسترسی غیرمجاز']);
    }

    $brands = isset($_POST['brands']) ? $_POST['brands'] : array();
    $section_title = isset($_POST['section_title']) ? sanitize_text_field($_POST['section_title']) : '';

    update_option('selected_brands', $brands);
    update_option('brands_section_title', $section_title);

    wp_send_json_success(['message' => 'تنظیمات ذخیره شدند!']);
}
add_action('wp_ajax_save_selected_brands', 'save_selected_brands');



function save_homepage_addresses() {
    if ( ! current_user_can('manage_options') ) {
        wp_send_json_error(['message' => 'دسترسی غیرمجاز']);
    }

    $address       = isset($_POST['address']) ? wp_kses_post($_POST['address']) : '';
    $phone1        = isset($_POST['phone1']) ? sanitize_text_field($_POST['phone1']) : '';
    $phone2        = isset($_POST['phone2']) ? sanitize_text_field($_POST['phone2']) : '';
    $working_hours = isset($_POST['working_hours']) ? wp_kses_post($_POST['working_hours']) : '';
    $latitude      = isset($_POST['latitude']) ? sanitize_text_field($_POST['latitude']) : '';
    $longitude     = isset($_POST['longitude']) ? sanitize_text_field($_POST['longitude']) : '';

    $data = array(
        'address'       => $address,
        'phone1'        => $phone1,
        'phone2'        => $phone2,
        'working_hours' => $working_hours,
        'latitude'      => $latitude,
        'longitude'     => $longitude
    );

    update_option('homepage-addresses', $data);
    wp_send_json_success(['message' => 'تنظیمات با موفقیت ذخیره شدند!']);
}
add_action('wp_ajax_save_homepage_addresses', 'save_homepage_addresses');




add_action('wp_ajax_submit_contact_form', 'handle_contact_form');
add_action('wp_ajax_nopriv_submit_contact_form', 'handle_contact_form');

function handle_contact_form() {
    check_ajax_referer('contact_form_nonce', 'security');

    $response = array();
    
    // اعتبارسنجی فیلدها
    $fullname = sanitize_text_field($_POST['fullname'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');
    $ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ? $_SERVER['REMOTE_ADDR'] : '';

    // اعتبارسنجی شماره تماس
    if(empty($fullname) || empty($phone) || empty($message)) {
        wp_send_json_error('لطفا تمام فیلدها را پر کنید');
    }
    
    if(!preg_match('/^09\d{9}$/', $phone)) {
        wp_send_json_error('شماره تماس معتبر نیست');
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_form';

    $result = $wpdb->insert(
        $table_name,
        array(
            'fullname' => $fullname,
            'phone' => $phone,
            'message' => $message,
            'ip_address' => $ip,
            'created_at' => current_time('mysql'),
        ),
        array('%s', '%s', '%s', '%s', '%s')
    );

    if($result === false) {
        wp_send_json_error('خطا در ذخیره اطلاعات');
    } else {
        wp_send_json_success('پیام شما با موفقیت ارسال شد');
    }
}


function load_contact_messages() {
    global $wpdb;
    $offset = intval($_POST['offset']);
    $table_name = $wpdb->prefix . 'contact_form';
    
    // تعداد کل پیام‌ها
    $total_messages = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    
    // دریافت پیام‌ها با محدودیت و آفست
    $messages = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC LIMIT 10 OFFSET $offset");
    
    // اگر پیامی وجود نداشت، خروجی بده و تابع را پایان بده
    if (empty($messages)) {
        echo 'no_more';
        wp_die();
    }
    
    // نمایش پیام‌ها
    foreach ($messages as $msg) {
        echo "<tr id='message-row-{$msg->id}'>
                <td>{$msg->fullname}</td>
                <td>{$msg->phone}</td>
                <td>{$msg->ip_address}</td>
                <td>" . substr($msg->message, 0, 30) . "...</td>
                <td>
                    <button onclick=\"showMessage('{$msg->message}')\" class='button'>مشاهده</button>
                    <button onclick=\"deleteMessage({$msg->id})\" class='button button-delete'>حذف</button>
                </td>
            </tr>";
    }

    
    wp_die();
}
add_action('wp_ajax_load_contact_messages', 'load_contact_messages');


function delete_contact_message() {
    global $wpdb;
    $id = intval($_POST['id']);
    $table_name = $wpdb->prefix . 'contact_form';
    $deleted = $wpdb->delete($table_name, [ 'id' => $id ]);
    echo $deleted ? 'success' : 'error';
    wp_die();
}
add_action('wp_ajax_delete_contact_message', 'delete_contact_message');


function remove_hompage_customers_logo() {
    check_ajax_referer('remove_logo_nonce', 'security');

    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'دسترسی غیرمجاز']);
    }

    $index = isset($_POST['index']) ? intval($_POST['index']) : -1;
    $logos = get_option('hompage-customers-logo', []);

    if ($index < 0 || !isset($logos[$index])) {
        wp_send_json_error(['message' => 'آیتم یافت نشد']);
    }

    array_splice($logos, $index, 1);
    update_option('hompage-customers-logo', $logos);

    wp_send_json_success();
}
add_action('wp_ajax_remove_hompage_customers_logo', 'remove_hompage_customers_logo');



function save_hompage_customers_logo() {
    check_ajax_referer('save_logo_nonce', 'security');

    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'دسترسی غیرمجاز']);
    }

    $logos = isset($_POST['logos']) ? array_map('esc_url', $_POST['logos']) : [];

    if (count($logos) > 6) {
        wp_send_json_error(['message' => 'حداکثر 6 لوگو مجاز است.']);
    }

    update_option('hompage-customers-logo', $logos);
    wp_send_json_success();
}
add_action('wp_ajax_save_hompage_customers_logo', 'save_hompage_customers_logo');



function save_about_section() {
    check_ajax_referer('save_about_nonce', 'security');

    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'دسترسی غیرمجاز']);
    }

    $about_data = isset($_POST['about_data']) ? $_POST['about_data'] : [];

    if (!is_array($about_data) || !isset($about_data['description']) || !isset($about_data['cards'])) {
        wp_send_json_error(['message' => 'داده‌های نامعتبر']);
    }

    // مرتب‌سازی کارت‌ها بر اساس ترتیب ارسال شده
    $sorted_cards = array_values($about_data['cards']);

    update_option('about-section', [
        'description' => sanitize_textarea_field($about_data['description']),
        'cards' => array_map(function ($card) {
            return [
                'icon' => esc_url($card['icon']),
                'title' => sanitize_text_field($card['title']),
                'description' => sanitize_textarea_field($card['description'])
            ];
        }, $sorted_cards)
    ]);

    wp_send_json_success();
}
add_action('wp_ajax_save_about_section', 'save_about_section');


function save_blog_faqs() {
    check_ajax_referer('save_blog_faqs_nonce', 'security');

    if (isset($_POST['faqs'])) {
        update_option('blog_faqs', $_POST['faqs']);
        wp_send_json_success("سوالات ذخیره شدند");
    } else {
        wp_send_json_error("خطا در ذخیره‌سازی");
    }
}
add_action('wp_ajax_save_blog_faqs', 'save_blog_faqs');


function save_about_first_section() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'دسترسی غیرمجاز']);
    }

    // دریافت داده‌ها از درخواست AJAX
    $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
    $content = isset($_POST['content']) ? sanitize_textarea_field($_POST['content']) : '';
    $image_id = isset($_POST['image_id']) ? absint($_POST['image_id']) : '';

    // ذخیره در wp_options
    update_option('about-first-section', [
        'title' => $title,
        'content' => $content,
        'image_id' => $image_id,
    ]);

    wp_send_json_success(['message' => 'تنظیمات ذخیره شد']);
}
add_action('wp_ajax_save_about_first_section', 'save_about_first_section');


function save_about_original_text() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'دسترسی غیرمجاز']);
    }

    if (!isset($_POST['about_text'])) {
        wp_send_json_error(['message' => 'داده‌ای ارسال نشده است']);
    }

    $about_text = wp_kses_post($_POST['about_text']);
    update_option('about-original-text', $about_text);
    
    wp_send_json_success(['message' => 'متن با موفقیت ذخیره شد']);
}
add_action('wp_ajax_save_about_original_text', 'save_about_original_text');


function save_about_page_faqs() {
    check_ajax_referer('save_about_page_faqs_nonce', 'security');

    if (isset($_POST['faqs'])) {
        update_option('about_page_faqs_data', $_POST['faqs']);
        wp_send_json_success("سوالات ذخیره شدند");
    } else {
        wp_send_json_error("خطا در ذخیره‌سازی");
    }
}
add_action('wp_ajax_save_about_page_faqs', 'save_about_page_faqs');


add_action('wp_ajax_save_dollar_price', 'save_dollar_price');
function save_dollar_price()
{
    if (isset($_POST['dollar_price']) && isset($_POST['dollar_enabled'])) {
        $price = sanitize_text_field($_POST['dollar_price']);
        $enabled = ($_POST['dollar_enabled'] === 'true') ? 'true' : 'false';

        update_option('dollar_price', $price);
        update_option('dollar_enabled', $enabled);

        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}


add_action('wp_ajax_save_group_attributes', function () {
    check_ajax_referer('save_group_attributes_nonce', 'security');

    if (!current_user_can('manage_options')) {
        wp_send_json_error('دسترسی غیرمجاز');
    }

    $group_attributes = isset($_POST['group_attributes']) ? $_POST['group_attributes'] : [];
    if (!is_array($group_attributes)) {
        wp_send_json_error('داده‌های ارسال شده نامعتبر هستند.');
    }

    update_option('group_attributes', $group_attributes);
    wp_send_json_success();
});