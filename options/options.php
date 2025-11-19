<?php
function register_theme_settings_page()
{
    add_menu_page(
        'تنظیمات قالب',
        'تنظیمات قالب',
        'manage_options',
        'theme-settings',
        'theme_settings_page',
        'data:image/svg+xml;base64,PHN2ZyB4b...',
        2
    );
}
add_action('admin_menu', 'register_theme_settings_page');

function enqueue_media_scripts()
{
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'enqueue_media_scripts');

function add_theme_settings_to_admin_bar($wp_admin_bar)
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $args = [
        'id' => 'theme-settings',
        'title' => 'تنظیمات قالب',
        'href' => admin_url('admin.php?page=theme-settings'),
        'meta' => ['class' => 'theme-settings-admin-bar']
    ];
    $wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'add_theme_settings_to_admin_bar', 100);

function custom_admin_menu_icon()
{
    ?>
    <style>
        #adminmenu #toplevel_page_theme-settings div.wp-menu-image {
            background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/fiveicon-.png') !important;
            background-size: contain;
            background-repeat: no-repeat;
            width: 30px;
            height: 30px;

        }

        #adminmenu #toplevel_page_theme-settings div.wp-menu-image img {
            display: none;
        }

        /* تنظیمات استایل منو */
        .theme-settings-wrapper {
            display: flex;
            font-family: 'IRANSans', sans-serif;
            background: #f9f9f9;
            border-radius: 8px;
            margin-top: 70px;
        }

        .settings-sidebar {
            width: 250px;
            background: #2c3e50;
            color: #fff;
            padding: 15px;
            min-width: 280px;
        }

        .settings-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .settings-sidebar li {
            cursor: pointer;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 5px;
            position: relative;
            transition: background 0.3s;
        }

        .settings-sidebar li:hover {
            background: #34495e;
        }

        .settings-sidebar .menu-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toggle-arrow {
            width: 10px;
            height: 10px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            display: inline-block;
            transform: rotate(0deg);
            transition: transform 0.3s;
        }

        .has-children.active .toggle-arrow {
            transform: rotate(180deg);
        }

        .sub-menu {
            display: none;
            margin-top: 15px !important;
            padding-right: 15px !important;
        }

        .has-children.active .sub-menu {
            display: block;
        }

        /* تنظیمات استایل محتوا */
        .settings-content {
            flex-grow: 1;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-left: 15px;
        }

        .settings-section {
            display: none;
        }

        .settings-section.active {
            display: block;
        }

        /* زیرمنوی فعال */
        .settings-sidebar .sub-menu li.active {
            background: #1abc9c;
            /* رنگ پس‌زمینه زیرمنوی فعال */
            color: #fff;
            font-weight: bold;
            border-radius: 4px;
            transition: background 0.3s;
        }

        /* زیرمنو هنگام هاور */
        .settings-sidebar .sub-menu li:hover {
            background: #16a085;
            /* رنگ هاور */
        }

        /* منوی اکتیو */
        .settings-sidebar li.active {
            background: #1abc9c;
            /* رنگ بکگراند منوی اکتیو */
            color: #fff;
            font-weight: bold;
            border-radius: 4px;
            transition: background 0.3s;
        }

        /* هاور برای تمامی آیتم‌های منو */
        .settings-sidebar li:hover {
            background: #16a085;
            /* رنگ هاور */
            cursor: pointer;
        }

        .settings-sidebar>ul>li.has-children.active {
            background: #1abc9c00;
            /* رنگ بکگراند منوی اکتیو */
            color: #fff;
            font-weight: bold;
            border: 1px solid white;
        }
    </style>
    <?php
}
add_action('admin_head', 'custom_admin_menu_icon');



// 3. تابع برای رندر یک آیتم
function render_slider_item($index, $item)
{
    ?>
    <div class="slider-item">
        <label>تصویر: </label>
        <input type="text" name="slider_items[<?php echo $index; ?>][image]" value="<?php echo esc_attr($item['image']); ?>"
            placeholder="آدرس تصویر" class="regular-text">
        <button type="button" class="button button-primary upload-slider-image">انتخاب تصویر</button>
        <br>
        <label>لینک: </label>
        <input type="url" name="slider_items[<?php echo $index; ?>][url]" value="<?php echo esc_attr($item['url']); ?>"
            placeholder="آدرس لینک" class="regular-text">
        <br>
        <button type="button" class="button remove-slider-item">حذف</button>
        <hr>
    </div>
    <?php
}


function theme_settings_page()
{
    ?>
    <h1 class="title">تنظیمات قالب</h1>
    <div class="theme-settings-wrapper">
        <!-- منوی سمت راست -->
        <div class="settings-sidebar">
            <ul>
                <li class="has-children">
                    <span class="menu-item">
                        تنظیمات صفحه اصلی
                        <span class="toggle-arrow"></span>
                    </span>
                    <ul class="sub-menu">
                        <li data-section="slider-settings">تنظیمات اسلایدر</li>
                        <li data-section="category-shortcuts-settings">تنظیمات شورت کات‌های دسته‌بندی</li>
                        <li data-section="first-subcategories-settings">زیر دسته های بعد از شورت کات اول</li>
                        <li data-section="new-products-settings">تنظیمات محصولات جدید</li>
                        <li data-section="brands-settings">برند های وسط صفحه</li>
                        <li data-section="second-subcategories-settings">زیر دسته های بعد از برندها</li>
                        <li data-section="customer-logo-settings">لوگوهای مشتریان صفحه اصلی</li>
                    </ul>
                </li>
                <li class="has-children">
                    <span class="menu-item">
                        تنظیمات هدر
                        <span class="toggle-arrow"></span>
                    </span>
                    <ul class="sub-menu">
                        <li data-section="header-phone-number-settings">شماره تماس هدر</li>
                    </ul>
                </li>
                <li data-section="attributes-grouping-settings" class="in-menu">گروه‌بندی ویژگی‌ها</li>
                <li data-section="hompage-addresses-settings" class="in-menu">آدرس و ساعات کاری</li>
                <li data-section="about-section-settings" class="in-menu">بخش کارت های چرا ایده آل برش</li>
                <li data-section="dollar-settings" class="in-menu">قیمت دلار</li>
                <li class="has-children">
                    <span class="menu-item">
                        تنظیمات فوتر
                        <span class="toggle-arrow"></span>
                    </span>
                    <ul class="sub-menu">
                        <li data-section="footer-addresses">آدرس های فوتر</li>
                        <li data-section="footer-enamad">ای نماد</li>
                        <li data-section="social-icons">شبکه های اجتماعی فوتر</li>
                        <li data-section="floating-contact">دکمه های شناور تماس</li>
                    </ul>
                </li>
                <li data-section="contact-form-settings" class="in-menu">فرم تماس</li>
                <li data-section="blog-faqs-settings" class="in-menu">سوالات متداول صفحه بلاگ</li>
                <li class="has-children">
                    <span class="menu-item">
                        تنظیمات درباره ما
                        <span class="toggle-arrow"></span>
                    </span>
                    <ul class="sub-menu">
                        <li data-section="about-first-settings">نوشته و عکس ابتدای درباره ما</li>
                        <li data-section="about-original-text-settings">نوشته های اصلی درباره ما</li>
                        <li data-section="about-faq-settings">سوالات متداول درباره ما</li>
                    </ul>
                </li>

            </ul>
        </div>

        <!-- محتوای تنظیمات -->
        <div class="settings-content">
            <div id="slider-settings" class="settings-section">
                <style>
                    .title {
                        text-align: center;
                        margin-top: 70px;
                    }

                    .wrap h1 {
                        font-size: 24px;
                        margin-bottom: 20px;
                    }

                    #slider-items-container {
                        margin-bottom: 20px;
                        display: grid;
                        grid-template-columns: repeat(3, minmax(0, 1fr));
                        gap: 10px;
                    }

                    .slider-item {
                        background: #f9f9f9;
                        border: 1px solid #ddd;
                        padding: 15px;
                        margin-bottom: 15px;
                        border-radius: 5px;
                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    }

                    .slider-item label {
                        font-weight: bold;
                        display: block;
                        margin-bottom: 5px;
                    }

                    .slider-item input[type="text"],
                    .slider-item input[type="url"] {
                        width: 100%;
                        padding: 8px;
                        margin-bottom: 10px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        box-sizing: border-box;
                        font-size: 14px;
                    }

                    .slider-item button {
                        margin-right: 5px;
                    }

                    .slider-item hr {
                        margin-top: 15px;
                        margin-bottom: 15px;
                        border: 0;
                        border-top: 1px solid #ddd;
                    }

                    #add-slider-item {
                        background: #007cba;
                        color: #fff;
                        padding: 8px 16px;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 14px;
                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    }

                    #add-slider-item:hover {
                        background: #005a99;
                    }

                    .remove-slider-item {
                        background: #dc3232;
                        color: #fff;
                        padding: 6px 12px;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 14px;
                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    }

                    .remove-slider-item:hover {
                        background: #a91f1f;
                    }

                    .upload-slider-image {
                        background: #007cba;
                        color: #fff;
                        padding: 6px 12px;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 14px;
                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    }

                    .upload-slider-image:hover {
                        background: #005a99;
                    }
                </style>
                <?php

                // دریافت داده‌های ذخیره‌شده
                $slider_data = get_option('front_page_slider', []);

                // ذخیره داده‌ها هنگام ارسال فرم
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['slider_items'])) {
                    check_admin_referer('save_slider_data'); // بررسی nonce برای امنیت
            
                    // دریافت و تمیز کردن داده‌ها
                    $slider_data = array_map(function ($item) {
                        return [
                            'image' => isset($item['image']) ? sanitize_text_field($item['image']) : '',
                            'mobile_image' => isset($item['mobile_image']) ? sanitize_text_field($item['mobile_image']) : '',
                            'url' => isset($item['url']) ? esc_url_raw($item['url']) : '',
                        ];
                    }, $_POST['slider_items']);

                    // ذخیره داده‌ها در wp_options
                    update_option('front_page_slider', $slider_data);

                    echo '<div class="updated"><p>تنظیمات با موفقیت ذخیره شد!</p></div>';
                }

                ?>
                <div class="wrap">
                    <h1>تنظیمات اسلایدر صفحه اصلی</h1>
                    <form id="slider-settings-form">
                        <?php wp_nonce_field('save_slider_data', 'slider_nonce'); ?>
                        <div id="slider-items-container">
                            <?php if (!empty($slider_data)): ?>
                                <?php foreach ($slider_data as $index => $item): ?>
                                    <div class="slider-item">
                                        <label>تصویر دسکتاپ:</label>
                                        <input type="text" name="slider_items[<?php echo $index; ?>][image]"
                                            value="<?php echo esc_attr($item['image'] ?? ''); ?>" class="regular-text">
                                        <button type="button" class="button upload-slider-image">انتخاب تصویر</button>

                                        <br>

                                        <label>تصویر موبایل:</label>
                                        <input type="text" name="slider_items[<?php echo $index; ?>][mobile_image]"
                                            value="<?php echo esc_attr($item['mobile_image'] ?? ''); ?>" class="regular-text">
                                        <button type="button" class="button upload-mobile-slider-image">انتخاب تصویر موبایل</button>

                                        <br>

                                        <label>لینک:</label>
                                        <input type="url" name="slider_items[<?php echo $index; ?>][url]"
                                            value="<?php echo esc_attr($item['url'] ?? ''); ?>" class="regular-text">
                                        <br>

                                        <button type="button" class="button remove-slider-item">حذف</button>
                                        <hr>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="button" id="add-slider-item">افزودن آیتم جدید</button>
                        <br><br>
                        <button type="button" class="button button-primary" id="save-slider-settings">ذخیره اسلایدر</button>
                    </form>
                    <div id="ajax-response" style="margin-top: 10px;"></div>
                </div>


                <script>
                    jQuery(document).ready(function ($) {
                        $('#add-slider-item').on('click', function () {
                            const container = $('#slider-items-container');
                            const index = container.children().length;
                            const newItem = `
            <div class="slider-item">
                <label>تصویر دسکتاپ:</label>
                <input type="text" name="slider_items[${index}][image]" class="regular-text">
                <button type="button" class="button upload-slider-image">انتخاب تصویر</button>
                <br>

                <label>تصویر موبایل:</label>
                <input type="text" name="slider_items[${index}][mobile_image]" class="regular-text">
                <button type="button" class="button upload-mobile-slider-image">انتخاب تصویر موبایل</button>
                <br>

                <label>لینک:</label>
                <input type="url" name="slider_items[${index}][url]" class="regular-text">
                <br>

                <button type="button" class="button remove-slider-item">حذف</button>
                <hr>
            </div>
        `;
                            container.append(newItem);
                        });

                        $(document).on('click', '.remove-slider-item', function () {
                            $(this).closest('.slider-item').remove();
                        });

                        $(document).on('click', '.upload-slider-image, .upload-mobile-slider-image', function (event) {
                            event.preventDefault();
                            const button = $(this);
                            const input = button.prev('input');
                            const frame = wp.media({
                                title: 'انتخاب تصویر',
                                button: {
                                    text: 'استفاده'
                                },
                                multiple: false
                            });

                            frame.on('select', function () {
                                const attachment = frame.state().get('selection').first().toJSON();
                                input.val(attachment.url);
                            });

                            frame.open();
                        });

                        $('#save-slider-settings').on('click', function () {
                            const formData = $('#slider-settings-form').serialize();

                            $.ajax({
                                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                                type: 'POST',
                                data: {
                                    action: 'save_slider_settings',
                                    nonce: '<?php echo wp_create_nonce("save_slider_data"); ?>',
                                    form_data: formData
                                },
                                success: function (response) {
                                    if (response.success) {
                                        $('#ajax-response').html('<div class="updated"><p>' + response.data.message + '</p></div>');
                                    } else {
                                        $('#ajax-response').html('<div class="error"><p>' + response.data.message + '</p></div>');
                                    }
                                },
                                error: function () {
                                    $('#ajax-response').html('<div class="error"><p>خطا در ذخیره‌سازی تنظیمات.</p></div>');
                                }
                            });
                        });
                    });
                </script>


            </div>
            <div id="category-shortcuts-settings" class="settings-section">
                <?php
                $shortcuts = get_option('frontpage_shortcuts', array());

                ?>
                <div class="wrap">
                    <h1>افزودن شورت کات‌های دسته‌بندی</h1>

                    <!-- فرم تکرار شونده -->
                    <form id="shortcut-form">
                        <div id="shortcut-container">
                            <?php
                            // اگر شورتکات‌های ذخیره‌شده وجود دارند، آنها را در ردیف‌ها نمایش می‌دهیم
                            if (!empty($shortcuts)) {
                                foreach ($shortcuts as $shortcut) {
                                    ?>
                                    <div class="shortcut-row">
                                        <div class="shortcut-fields">
                                            <!-- فیلد تصویر -->
                                            <div class="shortcut-field">
                                                <input type="text" name="image_url[]" class="upload_image"
                                                    value="<?php echo esc_url($shortcut['image']); ?>" placeholder="انتخاب تصویر" />
                                                <input type="button" class="upload_button button button-primary"
                                                    value="بارگذاری تصویر" />
                                                <div class="image-preview">
                                                    <img src="<?php echo esc_url($shortcut['image']); ?>"
                                                        style="max-width: 100px; max-height: 100px;" />
                                                </div>
                                            </div>

                                            <!-- فیلد URL -->
                                            <div class="shortcut-field">
                                                <input type="text" name="shortcut_url[]"
                                                    value="<?php echo esc_url($shortcut['url']); ?>" placeholder="آدرس URL" />
                                            </div>

                                            <!-- فیلد کپشن -->
                                            <div class="shortcut-field">
                                                <input type="text" name="caption[]"
                                                    value="<?php echo esc_html($shortcut['caption']); ?>" placeholder="کپشن" />
                                            </div>

                                            <div class="shortcut-field">
                                                <button type="button" class="remove-row button">حذف</button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                // اگر شورتکات‌های ذخیره‌شده وجود ندارد، یک ردیف خالی نمایش داده می‌شود
                                ?>
                                <h3> هنوز شورت کاتی وجود ندارد</h3>
                                <?php
                            }
                            ?>
                        </div>

                        <!-- دکمه برای افزودن ردیف جدید -->
                        <input type="button" id="add-row" class="button button-primary" value="افزودن ردیف جدید" />
                        <input type="submit" id="save-shortcut" class="button button-primary" value="ذخیره شورت کات ها" />
                    </form>

                </div>

                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        // افزودن ردیف جدید
                        $('#add-row').on('click', function () {
                            var rowCount = $('.shortcut-row').length; // تعداد ردیف‌های موجود
                            var newRow = `
                                <div class="shortcut-row">
                                    <div class="shortcut-fields">
                                        <div class="shortcut-field">
                                            <input type="text" name="image_url[]" class="upload_image" value="" placeholder="انتخاب تصویر" />
                                            <input type="button" class="upload_button button button-primary" value="بارگذاری تصویر" />
                                            <div class="image-preview"></div>
                                        </div>
                                        <div class="shortcut-field">
                                            <input type="text" name="shortcut_url[]" value="" placeholder="آدرس URL" />
                                        </div>
                                        <div class="shortcut-field">
                                            <input type="text" name="caption[]" value="" placeholder="کپشن" />
                                        </div>
                                        <!-- دکمه حذف -->
                                        <div class="shortcut-field">
                                            <button type="button" class="remove-row button">حذف</button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#shortcut-container').append(newRow);

                        });

                        // مدیریت حذف ردیف
                        $(document).on('click', '.remove-row', function () {
                            $(this).closest('.shortcut-row').remove(); // حذف ردیف مربوطه
                        });

                        // مدیریت بارگذاری تصویر
                        $(document).on('click', '.upload_button', function (e) {
                            e.preventDefault();
                            var button = $(this);
                            var imageField = button.siblings('.upload_image');
                            var imagePreview = button.siblings('.image-preview');

                            // ایجاد یک فریم ورک بارگذاری رسانه وردپرس
                            var frame = wp.media({
                                title: 'انتخاب تصویر',
                                button: {
                                    text: 'استفاده از این تصویر'
                                },
                                multiple: false
                            });

                            // هنگامی که تصویر انتخاب شد
                            frame.on('select', function () {
                                var attachment = frame.state().get('selection').first().toJSON();
                                imageField.val(attachment.url);
                                imagePreview.html('<img src="' + attachment.url + '" style="max-width: 100px; max-height: 100px;" />');
                            });

                            // باز کردن فریم ورک بارگذاری رسانه
                            frame.open();
                        });

                        // ذخیره داده‌ها به صورت Ajax
                        $('#shortcut-form').on('submit', function (e) {
                            e.preventDefault();

                            var shortcuts = [];
                            $('.shortcut-row').each(function () {
                                var image = $(this).find('input[name="image_url[]"]').val();
                                var url = $(this).find('input[name="shortcut_url[]"]').val();
                                var caption = $(this).find('input[name="caption[]"]').val();

                                if (image && url && caption) {
                                    shortcuts.push({
                                        image: image,
                                        url: url,
                                        caption: caption
                                    });
                                }
                            });

                            $.ajax({
                                url: '<?php echo admin_url('admin-ajax.php'); ?>', // آدرس Ajax در وردپرس
                                type: 'POST',
                                data: {
                                    action: 'save_shortcuts', // اکشن مورد نظر برای پردازش در PHP
                                    shortcuts: shortcuts
                                },
                                success: function (response) {
                                    alert('ذخیره شد!');
                                },
                                error: function () {
                                    alert('خطا در ذخیره‌سازی!');
                                }
                            });
                        });
                    });
                </script>

                <style>
                    .shortcut-row {
                        margin-bottom: 15px;
                        display: flex;
                        align-items: center;
                    }

                    .shortcut-fields {
                        display: flex;
                        gap: 10px;
                        width: 100%;
                    }

                    .shortcut-field {
                        flex: 1;
                    }

                    .image-preview {
                        margin-top: 5px;
                        max-width: 100px;
                        max-height: 100px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }

                    .shortcut img {
                        max-width: 100px;
                        max-height: 100px;
                        margin-right: 10px;
                    }

                    #add-row,
                    #save-shortcut {
                        margin-top: 20px;
                        display: block;
                    }

                    #add-row {
                        background: #007cba;
                        color: #fff;
                        padding: 8px 16px;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 14px;
                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    }

                    #shortcut-form {
                        margin-top: 50px;
                    }
                </style>


                <div id="ajax-response" style="margin-top: 10px;"></div>
            </div>
            <div id="new-products-settings" class="settings-section">
                <?php
                $selected_category = get_option('frontpage_new_products', '');
                ?>
                <div class="wrap">
                    <h1>انتخاب دسته‌بندی محصولات</h1>
                    <form id="frontpage-settings-form">
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="product_category">انتخاب دسته‌بندی:</label></th>
                                <td>
                                    <select id="product_category" name="product_category">
                                        <option value="">یک دسته‌بندی انتخاب کنید</option>
                                        <?php
                                        // دریافت دسته‌بندی‌های محصولات ووکامرس
                                        $categories = get_terms(array(
                                            'taxonomy' => 'product_cat',
                                            'hide_empty' => false,
                                        ));

                                        foreach ($categories as $category) {
                                            printf(
                                                '<option value="%s" %s>%s</option>',
                                                esc_attr($category->term_id),
                                                selected($selected_category, $category->term_id, false),
                                                esc_html($category->name)
                                            );
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <button type="button" id="save_category" class="button button-primary">ذخیره دسته بندی</button>
                        </p>
                    </form>
                    <div id="response-message" style="margin-top: 10px;"></div>
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        $('#save_category').on('click', function () {
                            var categoryId = $('#product_category').val();

                            $.ajax({
                                url: ajaxurl,
                                method: 'POST',
                                data: {
                                    action: 'save_frontpage_category',
                                    category_id: categoryId,
                                },
                                success: function (response) {

                                    alert(response.data.message);
                                },
                                error: function () {
                                    alert('خطایی در ذخیره سازی رخ داد. لطفا بعدا دوباره تلاش کنید');
                                }
                            });
                        });
                    });
                </script>

            </div>
            <div id="first-subcategories-settings" class="settings-section">
                <style>
                    span.select2-dropdown.select2-dropdown--below {
                        width: 200px !important;
                    }

                    span.select2-selection.select2-selection--multiple {
                        width: 200px !important;
                    }

                    span.select2.select2-container.select2-container--default.select2-container--below.select2-container--focus.select2-container--open {
                        width: 200px !important;
                    }
                </style>
                <h1>تنظیمات زیردسته‌های بعد از شورت کات اول</h1>

                <label for="homepage-section-title">عنوان بخش:</label>
                <input type="text" id="homepage-section-title" name="homepage-section-title"
                    value="<?php echo esc_attr(get_option('hompage-first-categories-title', '')); ?>" />

                <select id="homepage-first-categories" name="homepage-first-categories[]" multiple="multiple">
                    <?php
                    $saved_categories = get_option('hompage-first-categories', []);
                    $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);

                    foreach ($categories as $category) {
                        $selected = in_array($category->term_id, (array) $saved_categories) ? 'selected' : '';
                        echo "<option value='{$category->term_id}' {$selected}>{$category->name}</option>";
                    }
                    ?>
                </select>
                <button id="save-hompage-first-categories">ذخیره</button>

                <script>
                    jQuery(document).ready(function ($) {
                        // فعال‌سازی Select2
                        $('#homepage-first-categories').select2({
                            placeholder: "دسته‌بندی‌ها را انتخاب کنید",
                            tags: false
                        });

                        // ذخیره اطلاعات با AJAX
                        $('#save-hompage-first-categories').on('click', function () {
                            var selectedCategories = $('#homepage-first-categories').val();
                            var sectionTitle = $('#homepage-section-title').val();

                            $.ajax({
                                url: ajaxurl,
                                type: 'POST',
                                data: {
                                    action: 'save_homepage_first_categories',
                                    categories: selectedCategories,
                                    section_title: sectionTitle
                                },
                                success: function (response) {
                                    alert('تنظیمات ذخیره شدند!');
                                }
                            });
                        });
                    });

                </script>
            </div>
            <div id="brands-settings" class="settings-section">
                <?php
                // دریافت برندهای ذخیره شده و عنوان بخش (در صورت وجود)
                $saved_brands = get_option('selected_brands', array());
                $section_title = get_option('brands_section_title', '');
                ?>
                <div class="wrap">
                    <h2>تنظیمات برندها</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="section-title">عنوان بخش</label></th>
                            <td>
                                <input type="text" id="section-title" name="section-title"
                                    value="<?php echo esc_attr($section_title); ?>" class="regular-text">
                                <p class="description">عنوان مورد نظر برای بخش نمایش برندها</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="brand-select">انتخاب برندها</label></th>
                            <td>
                                <select id="brand-select" multiple="multiple" style="width: 50%;">
                                    <?php
                                    $brands = get_terms(['taxonomy' => 'product_brand', 'hide_empty' => false]);
                                    foreach ($brands as $brand) {
                                        $selected = in_array($brand->term_id, $saved_brands) ? 'selected' : '';
                                        echo "<option value='{$brand->term_id}' $selected>{$brand->name}</option>";
                                    }
                                    ?>
                                </select>
                                <p class="description">با استفاده از این فیلد می‌توانید برندها را انتخاب کنید.</p>
                            </td>
                        </tr>
                    </table>
                    <button id="save-brands" class="button button-primary">ذخیره تنظیمات</button>
                </div>

                <script>
                    jQuery(document).ready(function ($) {
                        $('#brand-select').select2({
                            placeholder: "برندها را انتخاب کنید...",
                            allowClear: true
                        });

                        $('#save-brands').on('click', function () {
                            var selectedBrands = $('#brand-select').val();
                            var sectionTitle = $('#section-title').val();
                            $.ajax({
                                url: ajaxurl,
                                type: 'POST',
                                data: {
                                    action: 'save_selected_brands',
                                    brands: selectedBrands,
                                    section_title: sectionTitle
                                },
                                success: function (response) {
                                    alert(response.data.message);
                                }
                            });
                        });
                    });
                </script>
            </div>
            <div id="second-subcategories-settings" class="settings-section">
                <h1>تنظیمات زیردسته‌های بعد از برندها</h1>

                <label for="second-homepage-section-title">عنوان بخش:</label>
                <input type="text" id="second-homepage-section-title" name="second-homepage-section-title"
                    value="<?php echo esc_attr(get_option('hompage-second-categories-title', '')); ?>" />

                <select id="homepage-second-categories" name="homepage-second-categories[]" multiple="multiple">
                    <?php
                    $saved_categories = get_option('hompage-second-categories', []);
                    $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);

                    foreach ($categories as $category) {
                        $selected = in_array($category->term_id, (array) $saved_categories) ? 'selected' : '';
                        echo "<option value='{$category->term_id}' {$selected}>{$category->name}</option>";
                    }
                    ?>
                </select>
                <button id="save-hompage-second-categories">ذخیره</button>

                <script>
                    jQuery(document).ready(function ($) {
                        // فعال‌سازی Select2
                        $('#homepage-second-categories').select2({
                            placeholder: "دسته‌بندی‌ها را انتخاب کنید",
                            tags: false
                        });

                        // ذخیره اطلاعات با AJAX
                        $('#save-hompage-second-categories').on('click', function () {
                            var selectedCategories = $('#homepage-second-categories').val();
                            var sectionTitle = $('#second-homepage-section-title').val();

                            $.ajax({
                                url: ajaxurl,
                                type: 'POST',
                                data: {
                                    action: 'save_homepage_second_categories',
                                    categories: selectedCategories,
                                    section_title: sectionTitle
                                },
                                success: function (response) {
                                    alert('تنظیمات ذخیره شدند!');
                                }
                            });
                        });
                    });

                </script>

            </div>
            <div id="hompage-addresses-settings" class="settings-section">
                <?php
                $hompage_addresses_saved_data = get_option('homepage-addresses', array());

                $address = isset($hompage_addresses_saved_data['address']) ? $hompage_addresses_saved_data['address'] : '';
                $phone1 = isset($hompage_addresses_saved_data['phone1']) ? $hompage_addresses_saved_data['phone1'] : '';
                $phone2 = isset($hompage_addresses_saved_data['phone2']) ? $hompage_addresses_saved_data['phone2'] : '';
                $working_hours = isset($hompage_addresses_saved_data['working_hours']) ? $hompage_addresses_saved_data['working_hours'] : '';
                $latitude = isset($hompage_addresses_saved_data['latitude']) ? $hompage_addresses_saved_data['latitude'] : '';
                $longitude = isset($hompage_addresses_saved_data['longitude']) ? $hompage_addresses_saved_data['longitude'] : '';
                ?>

                <div class="wrap">
                    <h2>تنظیمات آدرس و شماره تماس</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="homepage-address">آدرس</label></th>
                            <td>
                                <?php wp_editor($address, 'homepage-address', ['textarea_name' => 'homepage-address', 'media_buttons' => false, 'textarea_rows' => 4, 'teeny' => true]); ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="homepage-phone1">شماره تماس 1</label></th>
                            <td>
                                <input style="text-align: left; direction: ltr;" type="text" id="homepage-phone1"
                                    class="regular-text" value="<?php echo esc_attr($phone1); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="homepage-phone2">شماره تماس 2</label></th>
                            <td>
                                <input style="text-align: left; direction: ltr;" type="text" id="homepage-phone2"
                                    class="regular-text" value="<?php echo esc_attr($phone2); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="homepage-working-hours">ساعات کاری</label></th>
                            <td>
                                <?php wp_editor($working_hours, 'homepage-working-hours', ['textarea_name' => 'homepage-working-hours', 'media_buttons' => false, 'textarea_rows' => 4, 'teeny' => true]); ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="homepage-latitude">عرض جغرافیایی</label></th>
                            <td>
                                <input type="text" id="homepage-latitude" class="regular-text"
                                    value="<?php echo esc_attr($latitude); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="homepage-longitude">طول جغرافیایی</label></th>
                            <td>
                                <input type="text" id="homepage-longitude" class="regular-text"
                                    value="<?php echo esc_attr($longitude); ?>">
                            </td>
                        </tr>
                    </table>
                    <button id="save-homepage-addresses" class="button button-primary">ذخیره تنظیمات</button>
                </div>

                <script>
                    jQuery(document).ready(function ($) {
                        $('#save-homepage-addresses').on('click', function (e) {
                            e.preventDefault();

                            // دریافت محتوای TinyMCE
                            var address = tinymce.get('homepage-address') ? tinymce.get('homepage-address').getContent() : $('#homepage-address').val();
                            var working_hours = tinymce.get('homepage-working-hours') ? tinymce.get('homepage-working-hours').getContent() : $('#homepage-working-hours').val();

                            var data = {
                                action: 'save_homepage_addresses',
                                address: address,
                                phone1: $('#homepage-phone1').val(),
                                phone2: $('#homepage-phone2').val(),
                                working_hours: working_hours,
                                latitude: $('#homepage-latitude').val(),
                                longitude: $('#homepage-longitude').val()
                            };

                            $.post(ajaxurl, data, function (response) {
                                if (response.success) {
                                    alert(response.data.message);
                                } else {
                                    alert(response.data.message);
                                }
                            });
                        });
                    });
                </script>

            </div>

            <div id="customer-logo-settings" class="settings-section">
                <style>
                    ul#customers-logo-list {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 10px;
                        background: #1f41a4;
                        border-radius: 8px;
                        padding: 10px;
                    }

                    ul#customers-logo-list li {
                        position: relative;
                        list-style: none;
                    }

                    ul#customers-logo-list img {
                        display: block;
                        border-radius: 6px;
                    }

                    .remove-logo {
                        position: absolute;
                        top: 0;
                        right: 0;
                        background: red;
                        color: white;
                        border: none;
                        border-radius: 50%;
                        padding: 2px 6px;
                        cursor: pointer;
                    }
                </style>

                <div class="wrap">
                    <h1>مدیریت لوگوهای مشتریان</h1>
                    <button id="add-customer-logo" class="button button-primary">افزودن لوگو جدید</button>

                    <ul id="customers-logo-list">
                        <?php
                        $logos = get_option('hompage-customers-logo', []);
                        if (!is_array($logos)) {
                            $logos = [];
                        }
                        foreach ($logos as $index => $logo) {
                            echo '<li><img src="' . esc_url($logo) . '" width="100"><button class="remove-logo" data-index="' . $index . '">×</button></li>';
                        }
                        ?>
                    </ul>

                    <button id="save-customer-logos" class="button button-primary">ذخیره لوگوها</button>
                </div>

                <script>
                    jQuery(document).ready(function ($) {
                        let mediaUploader;
                        let logoArray = <?php
                        $logos = get_option('hompage-customers-logo', []);
                        if (!is_array($logos)) {
                            $logos = [];
                        }
                        echo json_encode(array_values($logos));
                        ?>;

                        console.log("لوگوهای فعلی:", logoArray);

                        $("#add-customer-logo").click(function (e) {
                            e.preventDefault();
                            if (mediaUploader) {
                                mediaUploader.open();
                                return;
                            }

                            mediaUploader = wp.media({
                                title: "افزودن لوگوی مشتری",
                                button: { text: "انتخاب" },
                                multiple: false
                            });

                            mediaUploader.on("select", function () {
                                let attachment = mediaUploader.state().get("selection").first().toJSON();
                                let imageUrl = attachment.url;
                                logoArray.push(imageUrl);

                                $("#customers-logo-list").append(
                                    '<li><img src="' + imageUrl + '" width="100"><button class="remove-logo" data-index="' + (logoArray.length - 1) + '">×</button></li>'
                                );
                            });

                            mediaUploader.open();
                        });

                        // حذف لوگو از لیست و آرایه
                        $("#customers-logo-list").on("click", ".remove-logo", function () {
                            let index = $(this).data("index");
                            logoArray.splice(index, 1);
                            $(this).closest("li").remove();
                            // بازسازی لیست با ایندکس‌های صحیح
                            $("#customers-logo-list").children("li").each(function (i) {
                                $(this).find(".remove-logo").attr("data-index", i);
                            });
                        });

                        // ذخیره از طریق Ajax
                        $("#save-customer-logos").click(function () {
                            $.ajax({
                                url: ajaxurl,
                                type: "POST",
                                data: {
                                    action: "save_hompage_customers_logo",
                                    logos: logoArray,
                                    security: "<?php echo wp_create_nonce('save_logo_nonce'); ?>"
                                },
                                success: function (response) {
                                    if (response.success) {
                                        alert("لوگوها با موفقیت ذخیره شدند!");
                                    } else {
                                        alert("خطا: " + (response.data?.message || "مشکلی پیش آمد"));
                                    }
                                }
                            });
                        });
                    });
                </script>
            </div>

            <div id="attributes-grouping-settings" class="settings-section">
                <style>
                    .selected-attributes {
                        display: grid;
                        grid-template-columns: repeat(3, minmax(0, 1fr));
                        margin-top: 10px;
                        margin-bottom: 10px;
                        gap: 10px;
                    }

                    .group-row {
                        width: fit-content;
                        margin-top: 20px;
                        margin-bottom: 20px;
                        background: #d9d9d9;
                        padding: 10px;
                        border-radius: 8px;
                        min-width: 500px;
                    }

                    span.tag {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        background: #493e99;
                        color: white;
                        border-radius: 4px;
                        padding: 5px;
                        gap: 3px;

                    }

                    span.tag>button {
                        cursor: pointer;
                    }

                    .row-inputs {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                    }
                </style>

                <?php
                global $wpdb;

                // دریافت نام ویژگی‌ها
                $attributes = $wpdb->get_results("SELECT DISTINCT taxonomy FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy LIKE 'pa_%'");
                $attribute_names = [];
                foreach ($attributes as $attribute) {
                    $attribute_names[] = str_replace('pa_', '', $attribute->taxonomy);
                }

                // دریافت داده‌های ذخیره‌شده
                $saved_groups = get_option('group_attributes', []);
                $saved_groups = is_array($saved_groups) ? $saved_groups : [];
                ?>
                <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/assets/css/select2.css'; ?>" />
                <div class="wrap">
                    <h1>مدیریت گروه ویژگی‌ها</h1>
                    <form id="group-attributes-form">
                        <div id="group-attributes-container">
                            <?php foreach ($saved_groups as $index => $data): ?>
                                <div class="group-row" data-index="<?php echo $index; ?>">
                                    <div class="selected-attributes">
                                        <?php if (!empty($data['tags'])): ?>
                                            <?php
                                            // دریافت اطلاعات تمام ویژگی‌ها
                                            $product_attributes = wc_get_attribute_taxonomies();
                                            $attribute_labels = [];

                                            // ایجاد یک آرایه برای دسترسی سریع به نام ویژگی‌ها با اسلاگ
                                            foreach ($product_attributes as $attribute) {
                                                $attribute_labels['pa_' . $attribute->attribute_name] = $attribute->attribute_label;
                                            }
                                            ?>
                                            <?php foreach ($data['tags'] as $tag): ?>
                                                <?php
                                                // تبدیل اسلاگ به نام ویژگی
                                                $tag_name = isset($attribute_labels[$tag]) ? $attribute_labels[$tag] : $tag;
                                                ?>
                                                <span class="tag" data-value="<?php echo esc_attr($tag); ?>">
                                                    <?php echo esc_html($tag_name); ?><button type="button"
                                                        class="remove-tag">×</button>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </div>
                                    <div class="row-inputs">
                                        <input type="text" name="group_name[]" value="<?php echo esc_attr($data['name']); ?>"
                                            placeholder="نام گروه ویژگی">
                                        <select name="group_attribute[]" class="attribute-select">
                                            <?php
                                            // دریافت تمام ویژگی‌های محصول که با "pa_" شروع می‌شوند
                                            $product_attributes = wc_get_attribute_taxonomies();
                                            foreach ($product_attributes as $attribute) {
                                                $attribute_slug = 'pa_' . $attribute->attribute_name; // اسلاگ ویژگی
                                                $attribute_label = $attribute->attribute_label; // نام ویژگی
                                                ?>
                                                <option value="<?php echo esc_attr($attribute_slug); ?>" <?php selected($data['attribute'], $attribute_slug); ?>>
                                                    <?php echo esc_html($attribute_label); ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                        <button type="button" class="remove-row">حذف</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="button button-primary" id="add-group-row">اضافه کردن گروه
                            ویژگی</button>
                        <button type="submit" class="button button-primary" id="save-group-attributes">ذخیره</button>
                    </form>
                    <script src="<?php echo get_template_directory_uri() . '/assets/js/select2.js'; ?>"></script>
                    <script>
                        jQuery(document).ready(function ($) {

                            function initializeSelect2() {
                                $('.attribute-select').select2({
                                    placeholder: 'یک گزینه را انتخاب کنید',
                                    allowClear: true,
                                    width: '100%',
                                });
                            }
                            initializeSelect2();

                            const attributes = <?php echo json_encode($attribute_names); ?>;

                            jQuery(document).ready(function ($) {
                                $('#add-group-row').on('click', function () {
                                    const rowIndex = $('#group-attributes-container .group-row').length;

                                    // ایجاد یک ردیف جدید بر اساس ساختار موجود
                                    const newRow = $(`
                                        <div class="group-row" data-index="${rowIndex}">
                                            <div class="selected-attributes">
                                                <!-- ویژگی‌های انتخاب‌شده در اینجا اضافه خواهند شد -->
                                            </div>
                                            <div class="row-inputs">
                                                <input type="text" name="group_name[]" value="" placeholder="نام گروه ویژگی">
                                                <select name="group_attribute[]" class="attribute-select">
                                                    ${generateAttributeOptions()}
                                                </select>
                                                <button type="button" class="remove-row">حذف</button>
                                            </div>
                                        </div>
                                    `);

                                    $('#group-attributes-container').append(newRow);
                                    initializeSelect2(); // اگر از Select2 استفاده می‌کنید، این تابع را مجددا اجرا کنید.
                                });

                                // حذف یک ردیف
                                $(document).on('click', '.remove-row', function () {
                                    $(this).closest('.group-row').remove();
                                });

                                // تابعی برای ایجاد گزینه‌های ویژگی‌ها
                                function generateAttributeOptions() {
                                    let options = '';
                                    <?php
                                    $product_attributes = wc_get_attribute_taxonomies();
                                    foreach ($product_attributes as $attribute) {
                                        $attribute_slug = 'pa_' . $attribute->attribute_name;
                                        $attribute_label = $attribute->attribute_label;
                                        ?>
                                        options += `<option value="<?php echo esc_attr($attribute_slug); ?>"><?php echo esc_html($attribute_label); ?></option>`;
                                    <?php } ?>
                                    return options;
                                }
                            });


                            // ذخیره‌سازی داده‌ها
                            $('#group-attributes-form').on('submit', function (e) {
                                e.preventDefault();

                                const data = [];
                                $('#group-attributes-container .group-row').each(function () {
                                    const name = $(this).find('input[name="group_name[]"]').val();
                                    const attribute = $(this).find('select[name="group_attribute[]"]').val();
                                    const tags = [];

                                    $(this).find('.selected-attributes .tag').each(function () {
                                        tags.push($(this).data('value'));
                                    });

                                    if (name && attribute) {
                                        data.push({
                                            name,
                                            attribute,
                                            tags
                                        });
                                    }
                                });
                                $.ajax({
                                    url: ajaxurl,
                                    method: 'POST',
                                    data: {
                                        action: 'save_group_attributes',
                                        group_attributes: data,
                                        security: '<?php echo wp_create_nonce("save_group_attributes_nonce"); ?>'
                                    },
                                    success: function (response) {
                                        if (response.success) {
                                            alert('داده‌ها با موفقیت ذخیره شدند.');
                                        } else {
                                            alert('خطایی رخ داده است: ' + response.data);
                                        }
                                    },
                                    error: function () {
                                        alert('خطای ارتباط با سرور.');
                                    }
                                });
                            });

                            // مدیریت نمایش تگ‌های انتخاب‌شده
                            $(document).on('change', '.attribute-select', function () {
                                const selectedValue = $(this).val();
                                const selectedText = $(this).find('option:selected').text();
                                const parentRow = $(this).closest('.group-row');

                                // بررسی اینکه تگ قبلاً اضافه نشده باشد
                                if (parentRow.find(`.selected-attributes .tag[data-value="${selectedValue}"]`).length === 0) {
                                    const tag = $('<span class="tag" data-value="' + selectedValue + '">' +
                                        selectedText + '<button type="button" class="remove-tag">×</button>' +
                                        '</span>');
                                    parentRow.find('.selected-attributes').append(tag);
                                }
                            });

                            $(document).on('click', '.remove-tag', function () {
                                $(this).parent('.tag').remove();
                            });


                        });
                    </script>
                </div>


            </div>
            <div id="dollar-settings" class="settings-section">
                <div id="dollar-price-container">
                    <div class="dollar-price-container">
                        <label for="dollar-price">مقدار دلار:</label>
                        <?php
                        // گرفتن مقدار از wp_options
                        $dollar_price = get_option('dollar_price', '');
                        $dollar_enabled = get_option('dollar_enabled', 'false'); // مقدار پیش‌فرض false
                        ?>
                        <input type="text" id="dollar-price" value="<?php echo esc_attr($dollar_price); ?>" />

                    </div>

                    <div class="dollar-enabled">
                        <label for="dollar-enabled">فعال باشد؟</label>
                        <input type="checkbox" id="dollar-enabled" <?php echo $dollar_enabled === 'true' ? 'checked' : ''; ?> />

                    </div>


                    <button id="save-dollar-price" class="button button-primary">ذخیره</button>
                </div>

                <script>
                    jQuery(document).ready(function ($) {
                        $("#save-dollar-price").on("click", function () {
                            const price = $("#dollar-price").val();
                            const enabled = $("#dollar-enabled").is(":checked") ? "true" : "false";

                            $.ajax({
                                url: ajaxurl,
                                method: "POST",
                                data: {
                                    action: "save_dollar_price",
                                    dollar_price: price,
                                    dollar_enabled: enabled
                                },
                                success: function (response) {
                                    if (response.success) {
                                        alert("مقدار ذخیره شد!");
                                    } else {
                                        alert("مشکلی پیش آمد.");
                                    }
                                },
                            });
                        });
                    });
                </script>

            </div>
            <div id="footer-addresses" class="settings-section">
                <?php
                // دریافت اطلاعات ذخیره‌شده از wp-options
                $footer_addresses = get_option('footer-addresses', array(
                    'text' => '',
                    'email' => '',
                    'phone' => ''
                ));
                ?>
                <div class="wrap">
                    <h2>تنظیمات آدرس‌های فوتر</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="footer_text">متن آدرس</label></th>
                            <td>
                                <textarea id="footer_text" rows="5"
                                    style="width:100%;"><?php echo esc_textarea($footer_addresses['text']); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="footer_email">ایمیل</label></th>
                            <td>
                                <input type="email" id="footer_email"
                                    value="<?php echo esc_attr($footer_addresses['email']); ?>" style="width:100%;" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="footer_phone">شماره تلفن</label></th>
                            <td>
                                <input type="text" id="footer_phone"
                                    value="<?php echo esc_attr($footer_addresses['phone']); ?>" style="width:100%;" />
                            </td>
                        </tr>
                    </table>
                    <button id="save-footer-addresses" class="button button-primary">ذخیره</button>
                    <span id="footer-addresses-message" style="margin-left: 10px;"></span>
                </div>

                <script>
                    jQuery(document).ready(function ($) {
                        $('#save-footer-addresses').on('click', function () {
                            var footerData = {
                                text: $('#footer_text').val(),
                                email: $('#footer_email').val(),
                                phone: $('#footer_phone').val()
                            };
                            $.post(ajaxurl, {
                                action: 'save_footer_addresses',
                                footer_addresses: footerData,
                                security: '<?php echo wp_create_nonce("save_footer_addresses_nonce"); ?>'
                            }, function (response) {
                                alert(response.data);
                            });
                        });
                    });
                </script>



            </div>
            <div id="footer-enamad" class="settings-section">
                <?php
                $enamad_code = get_option('footer_enamad', ''); ?>

                <div class="wrap">
                    <h2>تنظیمات نماد اعتماد</h2>
                    <textarea id="enamad_code" rows="5"
                        style="width:100%;"><?php echo esc_textarea($enamad_code); ?></textarea>
                    <br>
                    <button id="save-enamad" class="button button-primary">ذخیره</button>
                </div>

                <script>
                    jQuery(document).ready(function ($) {
                        $('#save-enamad').on('click', function () {
                            var iframeCode = $('#enamad_code').val();
                            $.post(ajaxurl, {
                                action: 'save_enamad_code',
                                enamad_code: iframeCode,
                                security: '<?php echo wp_create_nonce("save_enamad_nonce"); ?>'
                            }, function (response) {
                                alert(response.data)
                            });
                        });
                    });
                </script>

            </div>
            <div id="social-icons" class="settings-section">
                <?php
                // دریافت داده‌های ذخیره‌شده از wp_options
                $social_icons = get_option('footer_social_icons', '[]');
                $social_icons = json_decode($social_icons, true);
                ?>

                <div id="social-icons-container">
                    <div id="social-icons-list">
                        <?php if (!empty($social_icons)): ?>
                            <?php foreach ($social_icons as $index => $icon): ?>
                                <div class="social-icon-item">
                                    <input type="text" class="social-icon-url" value="<?php echo esc_attr($icon['link']); ?>"
                                        placeholder="لینک شبکه اجتماعی">
                                    <input type="hidden" class="social-icon-image" value="<?php echo esc_url($icon['image']); ?>">
                                    <?php if (!empty($icon['image'])): ?>
                                        <img src="<?php echo esc_url($icon['image']); ?>" class="social-icon-preview" width="50"
                                            height="50">
                                    <?php endif; ?>
                                    <button type="button" class="button button-primary upload-social-icon">انتخاب تصویر</button>
                                    <button type="button" class="button remove-social-icon">حذف</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button button-primary" id="add-social-icon">افزودن آیکن جدید</button>
                    <button type="button" class="button button-primary" id="save_social_icons">ذخیره آیکن‌ها</button>
                </div>

                <script>
                    jQuery(document).ready(function ($) {
                        // اضافه کردن ردیف جدید
                        $('#add-social-icon').click(function () {
                            $('#social-icons-list').append(`
                                <div class="social-icon-item">
                                    <input type="text" class="social-icon-url" placeholder="لینک شبکه اجتماعی">
                                    <input type="hidden" class="social-icon-image">
                                    <img src="" class="social-icon-preview" width="50" height="50" style="display:none;">
                                    <button type="button" class="upload-social-icon button button-primary">انتخاب تصویر</button>
                                    <button type="button" class="button remove-social-icon">حذف</button>
                                </div>
                            `);
                        });

                        // حذف یک ردیف
                        $(document).on('click', '.remove-social-icon', function () {
                            $(this).closest('.social-icon-item').remove();
                        });

                        // انتخاب تصویر از رسانه وردپرس
                        $(document).on('click', '.upload-social-icon', function () {
                            var button = $(this);
                            var imageField = button.siblings('.social-icon-image');
                            var previewImage = button.siblings('.social-icon-preview');

                            var mediaUploader = wp.media({
                                title: 'انتخاب تصویر آیکن',
                                button: {
                                    text: 'انتخاب'
                                },
                                multiple: false
                            });

                            mediaUploader.on('select', function () {
                                var attachment = mediaUploader.state().get('selection').first().toJSON();
                                imageField.val(attachment.url);
                                previewImage.attr('src', attachment.url).show();
                            });

                            mediaUploader.open();
                        });

                        // ذخیره آیکن‌ها با AJAX
                        $('#save_social_icons').click(function () {
                            var socialIcons = [];

                            $('.social-icon-item').each(function () {
                                var link = $(this).find('.social-icon-url').val();
                                var image = $(this).find('.social-icon-image').val();

                                if (link.trim() !== '' && image.trim() !== '') {
                                    socialIcons.push({
                                        link: link,
                                        image: image
                                    });
                                }
                            });

                            $.ajax({
                                url: ajaxurl,
                                type: 'POST',
                                data: {
                                    action: 'save_social_icons',
                                    social_icons: socialIcons
                                },
                                success: function (response) {
                                    alert('آیکن‌های شبکه‌های اجتماعی ذخیره شدند.');
                                }
                            });
                        });
                    });
                </script>
            </div>
            <div id="floating-contact" class="settings-section">
                <?php
                $options = get_option('floating_contact', []);
                ?>
                <div class="wrap">
                    <h2>تنظیمات تماس شناور</h2>
                    <table class="form-table">
                        <tr>
                            <th>آیکن دکمه تماس</th>
                            <td>
                                <input type="hidden" id="contact_icon"
                                    value="<?php echo esc_attr($options['contact_icon'] ?? ''); ?>">
                                <button class="button select-media" data-target="contact_icon">انتخاب آیکن</button>
                                <img id="contact_icon_preview" src="<?php echo esc_url($options['contact_icon'] ?? ''); ?>"
                                    style="max-width:50px; margin-top:10px;" />
                            </td>
                        </tr>
                        <tr>
                            <th>شماره تماس</th>
                            <td><input type="text" id="contact_number"
                                    value="<?php echo esc_attr($options['contact_number'] ?? ''); ?>"></td>
                        </tr>
                        <tr>
                            <th>URL دکمه دوم تماس</th>
                            <td><input type="text" id="contact_url"
                                    value="<?php echo esc_attr($options['contact_url'] ?? ''); ?>"></td>
                        </tr>
                        <tr>
                            <th>آیکن واتساپ</th>
                            <td>
                                <input type="hidden" id="whatsapp_icon"
                                    value="<?php echo esc_attr($options['whatsapp_icon'] ?? ''); ?>">
                                <button class="button select-media" data-target="whatsapp_icon">انتخاب آیکن</button>
                                <img id="whatsapp_icon_preview"
                                    src="<?php echo esc_url($options['whatsapp_icon'] ?? ''); ?>"
                                    style="max-width:50px; margin-top:10px;" />
                            </td>
                        </tr>
                        <tr>
                            <th>شماره واتساپ</th>
                            <td><input type="text" id="whatsapp_number"
                                    value="<?php echo esc_attr($options['whatsapp_number'] ?? ''); ?>"></td>
                        </tr>
                    </table>
                    <button id="save-floating-contact" class="button button-primary">ذخیره</button>
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        $('.select-media').on('click', function (e) {
                            e.preventDefault();
                            let target = $(this).data('target');
                            let frame = wp.media({ title: 'انتخاب تصویر', multiple: false, library: { type: 'image' } });
                            frame.on('select', function () {
                                let attachment = frame.state().get('selection').first().toJSON();
                                $('#' + target).val(attachment.url);
                                $('#' + target + '_preview').attr('src', attachment.url);
                            });
                            frame.open();
                        });

                        $('#save-floating-contact').on('click', function () {
                            let data = {
                                action: 'save_floating_contact',
                                contact_icon: $('#contact_icon').val(),
                                contact_number: $('#contact_number').val(),
                                contact_url: $('#contact_url').val(),
                                whatsapp_icon: $('#whatsapp_icon').val(),
                                whatsapp_number: $('#whatsapp_number').val(),
                                security: '<?php echo wp_create_nonce("save_floating_contact"); ?>'
                            };
                            $.post(ajaxurl, data, function (response) {
                                alert(response.data);
                            });
                        });
                    });
                </script>
            </div>
            <div id="header-phone-number-settings" class="settings-section">

                <?php
                $phone_number = get_option('header_phone_number', '');
                ?>
                <div class="wrap">
                    <h1>تنظیمات شماره تماس</h1>
                    <input type="text" id="header_phone_number" value="<?php echo esc_attr($phone_number); ?>"
                        placeholder="شماره تماس را وارد کنید">
                    <button id="save-header-phone-number" class="button button-primary">ذخیره</button>
                    <div id="response-message"></div>
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        $('#save-header-phone-number').click(function () {
                            var phone_number = $('#header_phone_number').val();
                            $.ajax({
                                url: ajaxurl,
                                type: 'POST',
                                data: {
                                    action: 'save_header_phone_number',
                                    phone_number: phone_number,
                                    security: '<?php echo wp_create_nonce("save_phone_number_nonce"); ?>'
                                },
                                success: function (response) {
                                    alert(response.data)
                                },
                                error: function () {
                                    alert('خطایی رخ داده است!')
                                }
                            });
                        });
                    });
                </script>
            </div>
            <div id="contact-form-settings" class="settings-section">
                <div class="wrap">
                    <h1>پیام‌های تماس</h1>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>نام</th>
                                <th>شماره تماس</th>
                                <th>آی‌پی</th>
                                <th>پیام</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody id="contact-messages-body">
                            <!-- پیام‌ها اینجا با AJAX لود می‌شوند -->
                        </tbody>
                    </table>
                    <button id="load-more" class="button">نمایش بیشتر</button>
                </div>
                <div id="message-popup"
                    style="display:none; position:fixed; top:30%; left:50%; transform:translate(-50%, -50%); background:#fff; padding:20px; border:1px solid #ccc; z-index:1000;">
                    <p id="popup-message"></p>
                    <button onclick="document.getElementById('message-popup').style.display='none'">بستن</button>
                </div>
                <script>
                    // ۱. توابع global برای inline onclick
                    function showMessage(msg) {
                        document.getElementById('popup-message').innerText = msg;
                        document.getElementById('message-popup').style.display = 'block';
                    }
                    function deleteMessage(id) {
                        if (!confirm('آیا از حذف این پیام مطمئن هستید؟')) return;
                        jQuery.post(ajaxurl, { action: 'delete_contact_message', id: id }, function (resp) {
                            if (resp.trim() === 'success') {
                                jQuery('#message-row-' + id).fadeOut(300, function () { jQuery(this).remove(); });
                            } else {
                                alert('خطا در حذف پیام');
                            }
                        });
                    }

                    // ۲. بقیه کد AJAX داخل ready
                    jQuery(document).ready(function ($) {
                        let offset = 0;

                        function loadMessages() {
                            $.post(ajaxurl, { action: 'load_contact_messages', offset: offset }, function (response) {
                                if (response.trim() === 'no_more') {
                                    $('#load-more').hide();
                                    return;
                                }
                                $('#contact-messages-body').append(response);
                                offset += 10;
                            });
                        }

                        // بارگذاری اولیه و دکمه‌ی "نمایش بیشتر"
                        loadMessages();
                        $('#load-more').on('click', loadMessages);
                    });
                </script>

            </div>
            <div id="about-section-settings" class="settings-section">
                <?php

                $about_data = get_option('about-section', ['description' => '', 'cards' => []]);
                ?>
                <div class="wrap">
                    <h1>مدیریت بخش درباره ما</h1>

                    <label for="about-description">توضیحات:</label>
                    <textarea id="about-description" rows="5"
                        style="width:100%;"><?php echo esc_textarea($about_data['description']); ?></textarea>

                    <h2>کارت‌ها</h2>
                    <button id="add-card" class="button">افزودن کارت</button>
                    <div id="cards-container">
                        <?php
                        if (!empty($about_data['cards'])) {
                            foreach ($about_data['cards'] as $index => $card) {
                                ?>
                                <div class="card-item">
                                    <img src="<?php echo esc_url($card['icon']); ?>" class="icon-preview" width="50">
                                    <button class="upload-icon button">انتخاب آیکن</button>
                                    <input type="hidden" class="icon-url" value="<?php echo esc_url($card['icon']); ?>">

                                    <input type="text" class="card-title" placeholder="عنوان"
                                        value="<?php echo esc_attr($card['title']); ?>">
                                    <textarea class="card-description"
                                        placeholder="توضیحات"><?php echo esc_textarea($card['description']); ?></textarea>
                                    <button class="remove-card button button-secondary">حذف</button>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>

                    <button id="save-about-section" class="button button-primary">ذخیره</button>
                </div>

                <script>
                    jQuery(document).ready(function ($) {
                        let aboutData = {
                            description: $("#about-description").val(),
                            cards: []
                        };

                        function updateData() {
                            aboutData.description = $("#about-description").val();
                            aboutData.cards = [];

                            $(".card-item").each(function (index) {
                                let card = {
                                    icon: $(this).find(".icon-url").val(),
                                    title: $(this).find(".card-title").val(),
                                    description: $(this).find(".card-description").val()
                                };
                                aboutData.cards.push(card);
                                $(this).attr("data-index", index);
                            });
                        }

                        function updateIndexes() {
                            $(".card-item").each(function (index) {
                                $(this).attr("data-index", index);
                                $(this).find(".remove-card").attr("data-index", index);
                            });
                        }

                        $("#add-card").click(function () {
                            if ($(".card-item").length >= 5) {
                                alert("شما فقط می‌توانید حداکثر 5 کارت اضافه کنید.");
                                return;
                            }

                            let newIndex = $(".card-item").length;
                            let cardHtml = `
                                <div class="card-item" data-index="${newIndex}">
                                    <img src="" class="icon-preview" width="50">
                                    <button class="upload-icon button">انتخاب آیکن</button>
                                    <input type="hidden" class="icon-url">
                                    <input type="text" class="card-title" placeholder="عنوان">
                                    <textarea class="card-description" placeholder="توضیحات"></textarea>
                                    <button class="remove-card button button-secondary" data-index="${newIndex}">حذف</button>
                                </div>`;
                            $("#cards-container").append(cardHtml);
                            updateIndexes();
                        });


                        $("#cards-container").on("click", ".remove-card", function () {
                            $(this).closest(".card-item").remove();
                            updateIndexes();
                        });

                        $("#cards-container").on("click", ".upload-icon", function (e) {
                            e.preventDefault();
                            let button = $(this);
                            let parentCard = button.closest(".card-item");

                            let mediaUploader = wp.media({
                                title: "انتخاب آیکن",
                                button: { text: "انتخاب" },
                                multiple: false
                            });

                            mediaUploader.on("select", function () {
                                let attachment = mediaUploader.state().get("selection").first().toJSON();
                                parentCard.find(".icon-preview").attr("src", attachment.url);
                                parentCard.find(".icon-url").val(attachment.url);
                            });

                            mediaUploader.open();
                        });

                        $("#save-about-section").click(function () {
                            updateData();

                            $.ajax({
                                url: ajaxurl,
                                type: "POST",
                                data: {
                                    action: "save_about_section",
                                    about_data: aboutData,
                                    security: "<?php echo wp_create_nonce('save_about_nonce'); ?>"
                                },
                                success: function (response) {
                                    if (response.success) {
                                        alert("اطلاعات ذخیره شد.");
                                    } else {
                                        alert("خطا در ذخیره‌سازی");
                                    }
                                }
                            });
                        });
                    });


                </script>

                <style>
                    .card-item {
                        border: 1px solid #ddd;
                        padding: 10px;
                        margin: 10px 0;
                        background: #f9f9f9;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }

                    .icon-preview {
                        display: block;
                        margin-bottom: 10px;
                    }
                </style>

            </div>
            <div id="blog-faqs-settings" class="settings-section">
                <?php
                $faqs = get_option('blog_faqs', []);
                if (!is_array($faqs)) {
                    $faqs = [];
                }
                ?>
                <div class="wrap">
                    <h1>مدیریت سوالات متداول صفحه بلاگ</h1>
                    <div id="faq_container">
                        <?php foreach ($faqs as $index => $faq): ?>
                            <div class="faq-item">
                                <input type="text" class="faq-question" placeholder="سوال"
                                    value="<?php echo esc_attr($faq['question']); ?>" style="width:100%; margin-bottom:5px;" />
                                <textarea class="faq-answer" placeholder="پاسخ" rows="3"
                                    style="width:100%;"><?php echo esc_textarea($faq['answer']); ?></textarea>
                                <input type="button" class="button remove-faq-item" value="حذف" /><br><br>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="button" id="add-faq-button" class="button" value="افزودن سوال" />
                    <input type="button" id="save-blog-faqs-button" class="button button-primary" value="ذخیره سوالات" />
                </div>

                <script>
                    jQuery(document).ready(function ($) {
                        $("#add-faq-button").click(function () {
                            $("#faq_container").append(`
                                <div class="faq-item">
                                    <input type="text" class="faq-question" placeholder="سوال" style="width:100%; margin-bottom:5px;" />
                                    <textarea class="faq-answer" placeholder="پاسخ" rows="3" style="width:100%;"></textarea>
                                    <input type="button" class="button remove-faq-item" value="حذف" /><br><br>
                                </div>
                            `);
                        });

                        $(document).on("click", ".remove-faq-item", function () {
                            $(this).parent().remove();
                        });

                        $("#save-blog-faqs-button").click(function () {
                            var faqs = [];
                            $(".faq-item").each(function () {
                                var question = $(this).find(".faq-question").val();
                                var answer = $(this).find(".faq-answer").val();
                                if (question && answer) {
                                    faqs.push({ question: question, answer: answer });
                                }
                            });

                            $.ajax({
                                url: ajaxurl,
                                type: "POST",
                                data: {
                                    action: "save_blog_faqs",
                                    faqs: faqs,
                                    security: "<?php echo wp_create_nonce('save_blog_faqs_nonce'); ?>"
                                },
                                success: function (response) {
                                    alert('سوالات متداول ذخیره شد');
                                }
                            });
                        });
                    });
                </script>
            </div>
            <div id="about-first-settings" class="settings-section">
                <?php
                $about_data = get_option('about-first-section', []);
                $title = isset($about_data['title']) ? esc_attr($about_data['title']) : '';
                $content = isset($about_data['content']) ? esc_textarea($about_data['content']) : '';
                $image_id = isset($about_data['image_id']) ? absint($about_data['image_id']) : '';
                $image_url = $image_id ? wp_get_attachment_url($image_id) : '';

                ?>
                <div class="wrap">
                    <h1>تنظیمات سکشن اول درباره ما</h1>
                    <table class="form-table">
                        <tr>
                            <th><label for="about_title">عنوان</label></th>
                            <td><input type="text" id="about_title" value="<?php echo $title; ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label for="about_content">محتوا</label></th>
                            <td><textarea id="about_content" style="text-align: right;" class="large-text code"
                                    rows="5"><?php echo $content; ?></textarea></td>
                        </tr>
                        <tr>
                            <th><label for="about_image">تصویر</label></th>
                            <td>
                                <input type="hidden" id="about_image_id" value="<?php echo $image_id; ?>">
                                <img id="about_image_preview" src="<?php echo esc_url($image_url); ?>"
                                    style="max-width: 150px; display: <?php echo $image_url ? 'block' : 'none'; ?>;">
                                <br>
                                <button type="button" class="button button-primary" id="upload_about_image">انتخاب
                                    تصویر</button>
                                <button type="button" class="button button-secondary" id="remove_about_image"
                                    style="display: <?php echo $image_url ? 'inline-block' : 'none'; ?>;">حذف تصویر</button>
                            </td>
                        </tr>
                    </table>
                    <button id="save-about-first-section" class="button button-primary">ذخیره تنظیمات</button>
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        // آپلود تصویر
                        $('#upload_about_image').on('click', function (e) {
                            e.preventDefault();

                            var mediaUploader = wp.media({
                                title: 'انتخاب تصویر',
                                button: { text: 'انتخاب' },
                                multiple: false
                            });

                            mediaUploader.on('select', function () {
                                var attachment = mediaUploader.state().get('selection').first().toJSON();
                                $('#about_image_id').val(attachment.id);
                                $('#about_image_preview').attr('src', attachment.url).show();
                                $('#remove_about_image').show();
                            });

                            mediaUploader.open();
                        });

                        // حذف تصویر
                        $('#remove_about_image').on('click', function () {
                            $('#about_image_id').val('');
                            $('#about_image_preview').hide();
                            $(this).hide();
                        });

                        // ذخیره تنظیمات
                        $('#save-about-first-section').on('click', function () {
                            var data = {
                                action: 'save_about_first_section',
                                title: $('#about_title').val(),
                                content: $('#about_content').val(),
                                image_id: $('#about_image_id').val(),
                            };

                            $.post(ajaxurl, data, function (response) {
                                if (response.success) {
                                    alert(response.data.message)
                                } else {
                                    alert(response.data.message)
                                }
                            });
                        });
                    });

                </script>
            </div>
            <div id="about-original-text-settings" class="settings-section">
                <?php
                $about_text = get_option('about-original-text', '');

                ?>
                <div class="wrap">
                    <h1>متن درباره ما</h1>
                    <form id="about-original-text-form">
                        <?php
                        wp_editor($about_text, 'about-original-text', [
                            'textarea_name' => 'about-original-text',
                            'media_buttons' => true,
                            'textarea_rows' => 10
                        ]);
                        ?>
                        <button type="button" id="save-about-original-text" class="button button-primary">ذخیره</button>
                    </form>
                    <div id="response-message" style="margin-top: 10px;"></div>
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        $('#save-about-original-text').on('click', function () {
                            var aboutText = tinyMCE.get('about-original-text').getContent();

                            $.ajax({
                                url: ajaxurl,
                                type: 'POST',
                                data: {
                                    action: 'save_about_original_text',
                                    about_text: aboutText
                                },
                                success: function (response) {
                                    if (response.success) {
                                        alert(response.data.message);
                                    } else {
                                        alert(response.data.message);
                                    }
                                },
                            });
                        });
                    });
                </script>

            </div>
            <div id="about-faq-settings" class="settings-section">
                <?php
                $about_page_faqs = get_option('about_page_faqs_data', []);
                if (!is_array($about_page_faqs)) {
                    $about_page_faqs = [];
                }
                ?>
                <div class="wrap">
                    <h1>مدیریت سوالات متداول صفحه درباره ما</h1>
                    <div id="about_page_faqs_container">
                        <?php foreach ($about_page_faqs as $index => $faq): ?>
                            <div class="about-faq-item">
                                <input type="text" class="about-faq-question" placeholder="سوال"
                                    value="<?php echo esc_attr($faq['question']); ?>" style="width:100%; margin-bottom:5px;" />
                                <textarea class="about-faq-answer" placeholder="پاسخ" rows="3"
                                    style="width:100%;"><?php echo esc_textarea($faq['answer']); ?></textarea>
                                <input type="button" class="button remove-about-faq-item" value="حذف" /><br><br>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="button" id="add-about-page-faq-button" class="button" value="افزودن سوال" />
                    <input type="button" id="save-about-page-faqs-button" class="button button-primary"
                        value="ذخیره سوالات" />
                </div>

                <script>
                    jQuery(document).ready(function ($) {
                        $("#add-about-page-faq-button").click(function () {
                            $("#about_page_faqs_container").append(`
            <div class="about-faq-item">
                <input type="text" class="about-faq-question" placeholder="سوال" style="width:100%; margin-bottom:5px;" />
                <textarea class="about-faq-answer" placeholder="پاسخ" rows="3" style="width:100%;"></textarea>
                <input type="button" class="button remove-about-faq-item" value="حذف" /><br><br>
            </div>
        `);
                        });

                        $(document).on("click", ".remove-about-faq-item", function () {
                            $(this).parent().remove();
                        });

                        $("#save-about-page-faqs-button").click(function () {
                            var aboutFaqs = [];
                            $(".about-faq-item").each(function () {
                                var question = $(this).find(".about-faq-question").val();
                                var answer = $(this).find(".about-faq-answer").val();
                                if (question && answer) {
                                    aboutFaqs.push({ question: question, answer: answer });
                                }
                            });

                            $.ajax({
                                url: ajaxurl,
                                type: "POST",
                                data: {
                                    action: "save_about_page_faqs",
                                    faqs: aboutFaqs,
                                    security: "<?php echo wp_create_nonce('save_about_page_faqs_nonce'); ?>"
                                },
                                success: function (response) {
                                    alert('سوالات متداول ذخیره شد');
                                }
                            });
                        });
                    });
                </script>
            </div>





        </div>



        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const menuItems = document.querySelectorAll('.settings-sidebar li');
                const otherItems = document.querySelectorAll('.in-menu');
                const sections = document.querySelectorAll('.settings-section');

                document.querySelectorAll('.has-children').forEach(parentMenu => {
                    const menuItem = parentMenu.querySelector('.menu-item');
                    const subMenuItems = parentMenu.querySelectorAll('.sub-menu li');

                    if (menuItem) {
                        menuItem.addEventListener('click', () => {
                            parentMenu.classList.toggle('active');
                        });
                    }

                    subMenuItems.forEach(item => {
                        item.addEventListener('click', (e) => {
                            e.stopPropagation(); // جلوگیری از بسته شدن منوی والد

                            // بستن تمام otherItems قبل از نمایش زیرمنو
                            otherItems.forEach(item => item.classList.remove('active'));

                            // بستن تمامی سایر زیرمنوها
                            document.querySelectorAll('.sub-menu li').forEach(subItem => subItem.classList.remove('active'));

                            // فعال کردن زیرمنوی کلیک‌شده
                            item.classList.add('active');

                            // مدیریت نمایش تنظیمات مرتبط
                            sections.forEach(section => section.classList.remove('active'));

                            const targetSection = document.getElementById(item.dataset.section);
                            if (targetSection) targetSection.classList.add('active');
                        });
                    });
                });

                // مدیریت کلیک روی سایر منوها (غیر از زیرمنوها)
                otherItems.forEach(item => {
                    if (!item.classList.contains('has-children')) {
                        item.addEventListener('click', () => {
                            // بستن تمامی منوها و زیرمنوها
                            otherItems.forEach(section => section.classList.remove('active'));

                            // بستن تمامی زیرمنوها قبل از نمایش otherItems
                            document.querySelectorAll('.sub-menu li').forEach(subItem => subItem.classList.remove('active'));

                            // نمایش تنظیمات مرتبط
                            sections.forEach(section => section.classList.remove('active'));
                            const targetSection = document.getElementById(item.dataset.section);
                            if (targetSection) targetSection.classList.add('active');

                            // فعال کردن منوی کلیک‌شده
                            item.classList.add('active');
                        });
                    }
                });

            });
        </script>
        <?php
        global $wpdb;

        $attributes = $wpdb->get_results("
            SELECT DISTINCT taxonomy
            FROM {$wpdb->prefix}term_taxonomy
            WHERE taxonomy LIKE 'pa_%'
        ");

        $attribute_names = [];
        foreach ($attributes as $attribute) {
            // استخراج نام ویژگی بدون پیشوند pa_
            $attribute_names[] = str_replace('pa_', '', $attribute->taxonomy);
        }

        // ارسال ویژگی‌ها به جاوااسکریپت
        echo '<script>';
        echo 'var productAttributes = ' . json_encode($attribute_names) . ';';
        echo '</script>';
}