<?php

function custom_post_type_services() {
    $labels = array(
        'name'               => 'خدمات',
        'singular_name'      => 'خدمت',
        'menu_name'          => 'خدمات',
        'name_admin_bar'     => 'خدمت',
        'add_new'            => 'افزودن جدید',
        'add_new_item'       => 'افزودن خدمت جدید',
        'new_item'           => 'خدمت جدید',
        'edit_item'          => 'ویرایش خدمت',
        'view_item'          => 'مشاهده خدمت',
        'all_items'          => 'همه خدمات',
        'search_items'       => 'جستجوی خدمات',
        'not_found'          => 'چیزی یافت نشد',
        'not_found_in_trash' => 'چیزی در زباله‌دان یافت نشد',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array(
            'slug'       => 'services',
            'with_front' => false,  // << این خط باعث می‌شود Front (یعنی blog/) حذف شود
        ),
        'has_archive'        => true,   // یا 'services' اگر خواستی آرشیو با همین نام باشد
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'thumbnail'),
        'menu_icon'          => 'dashicons-hammer',
        'show_in_rest'       => true,
    );

    register_post_type('services', $args);
}
add_action('init', 'custom_post_type_services');



// اضافه کردن متاباکس
function services_add_meta_box()
{
    add_meta_box(
        'services_first_description',
        'توضیحات اول صفحه',
        'services_meta_box_callback',
        'services',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'services_add_meta_box');

// نمایش متاباکس
function services_meta_box_callback($post)
{
    wp_nonce_field('services_save_meta_box_data', 'services_meta_box_nonce');

    $first_description = get_post_meta($post->ID, 'first_description', true);
    $first_picture = get_post_meta($post->ID, 'first_picture', true);

    echo '<label for="first_description">توضیحات:</label>';
    wp_editor($first_description, 'first_description', array('textarea_rows' => 5, 'media_buttons' => true));

    echo '<label for="first_picture">تصویر:</label><br>';
    echo '<img id="first_picture_preview" src="' . esc_attr($first_picture) . '" style="width:100px; height:100px; display:' . ($first_picture ? 'block' : 'none') . '; border:1px solid #ccc;" /><br>';
    echo '<input type="hidden" id="first_picture" name="first_picture" value="' . esc_attr($first_picture) . '" />';
    echo '<input type="button" id="first_picture_button" class="button" value="انتخاب تصویر" />';
    echo '<script>
        jQuery(document).ready(function($){
            $("#first_picture_button").click(function(e){
                e.preventDefault();
                var mediaUploader;
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: "انتخاب تصویر",
                    button: {
                        text: "انتخاب"
                    },
                    multiple: false
                });
                mediaUploader.on("select", function(){
                    var attachment = mediaUploader.state().get("selection").first().toJSON();
                    $("#first_picture").val(attachment.url);
                    $("#first_picture_preview").attr("src", attachment.url).show();
                });
                mediaUploader.open();
            });
        });
    </script>';
}

// ذخیره داده‌های متاباکس
function services_add_meta_boxes()
{
    add_meta_box(
        'services_first_description',
        'توضیحات اول صفحه',
        'services_meta_box_callback',
        'services',
        'normal',
        'high'
    );
    add_meta_box(
        'services_first_products',
        'عکس دستگاه های بالایی',
        'services_products_meta_box_callback',
        'services',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'services_add_meta_boxes');

// نمایش متاباکس عکس دستگاه‌ها
function services_products_meta_box_callback($post)
{
    wp_nonce_field('services_save_meta_box_data', 'services_meta_box_nonce');

    // دریافت مقدار maintitle
    $maintitle1 = get_post_meta($post->ID, 'maintitle1', true);

    // دریافت محصولات
    $first_products = get_post_meta($post->ID, 'first_products', true);
    if (!is_array($first_products)) {
        $first_products = [];
    }
    echo '<style>
    .first-product-item , .last-product-item {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-top: 20px;
    }
    </style>';
    // فیلد maintitle
    echo '<label for="maintitle1">عنوان اصلی:</label><br>';
    echo '<input type="text" id="maintitle1" name="maintitle1" value="' . esc_attr($maintitle1) . '" style="width:100%; margin-bottom: 15px;" /><br>';

    echo '<div id="first_products_container">';
    foreach ($first_products as $index => $product) {
        echo '<div class="first-product-item">';
        echo '<input type="text" name="first_products[' . $index . '][title]" placeholder="عنوان محصول" value="' . esc_attr($product['title'] ?? '') . '" /><br>';
        echo '<img class="first-product-preview" src="' . esc_attr($product['image']) . '" style="width:100px; height:100px; border:1px solid #ccc;" /><br>';
        echo '<input type="hidden" name="first_products[' . $index . '][image]" class="first-product-image" value="' . esc_attr($product['image']) . '" />';
        echo '<input type="button" class="button select-product-image" value="انتخاب تصویر" />';
        echo '<input type="url" name="first_products[' . $index . '][url]" placeholder="آدرس لینک" value="' . esc_attr($product['url']) . '" />';
        echo '<input type="button" class="button remove-product-item" value="حذف" /><br><br>';
        echo '</div>';
    }
    echo '</div>';
    echo '<input type="button" id="add_product_button" class="button" value="افزودن مورد" />';

    echo '<script>
        jQuery(document).ready(function($){
            $("#add_product_button").click(function(){
                if ($(".first-product-item").length < 5) {
                    var index = $(".first-product-item").length;
                    $("#first_products_container").append(`
                        <div class="first-product-item">
                            <input type="text" name="first_products[` + index + `][title]" placeholder="عنوان محصول" /><br>
                            <img class="first-product-preview" src="" style="width:100px; height:100px; border:1px solid #ccc; display:none;" /><br>
                            <input type="hidden" name="first_products[` + index + `][image]" class="first-product-image" />
                            <input type="button" class="button select-product-image" value="انتخاب تصویر" />
                            <input type="url" name="first_products[` + index + `][url]" placeholder="آدرس لینک" />
                            <input type="button" class="button remove-product-item" value="حذف" /><br><br>
                        </div>
                    `);
                }
            });
            $(document).on("click", ".remove-product-item", function(){
                $(this).parent().remove();
            });
            $(document).on("click", ".select-product-image", function(e){
                e.preventDefault();
                var button = $(this);
                var mediaUploader = wp.media({
                    title: "انتخاب تصویر",
                    button: { text: "انتخاب" },
                    multiple: false
                });
                mediaUploader.on("select", function(){
                    var attachment = mediaUploader.state().get("selection").first().toJSON();
                    button.siblings(".first-product-image").val(attachment.url);
                    button.siblings(".first-product-preview").attr("src", attachment.url).show();
                });
                mediaUploader.open();
            });
        });
    </script>';
}



// اضافه کردن متاباکس جدید برای توضیحات کامل
function services_add_full_description_meta_box()
{
    add_meta_box(
        'services_full_description',
        'توضیحات کامل',
        'services_full_description_meta_box_callback',
        'services',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'services_add_full_description_meta_box');

// نمایش متاباکس توضیحات کامل
function services_full_description_meta_box_callback($post)
{
    wp_nonce_field('services_save_meta_box_data', 'services_meta_box_nonce');

    $full_description = get_post_meta($post->ID, 'full_description', true);

    echo '<label for="full_description">توضیحات کامل:</label>';
    wp_editor($full_description, 'full_description', array('textarea_rows' => 10, 'media_buttons' => true));
}


// اضافه کردن متاباکس جدید برای عکس دستگاه‌های پایینی
function services_add_last_products_meta_box()
{
    add_meta_box(
        'services_last_products',
        'عکس دستگاه‌های پایینی',
        'services_last_products_meta_box_callback',
        'services',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'services_add_last_products_meta_box');

// نمایش متاباکس عکس دستگاه‌های پایینی
function services_last_products_meta_box_callback($post)
{
    wp_nonce_field('services_save_meta_box_data', 'services_meta_box_nonce');
    $maintitle2 = get_post_meta($post->ID, 'maintitle2', true);

    $last_products = get_post_meta($post->ID, 'last_products', true);
    if (!is_array($last_products)) {
        $last_products = [];
    }

    echo '<label for="maintitle2">عنوان اصلی:</label><br>';
    echo '<input type="text" id="maintitle2" name="maintitle2" value="' . esc_attr($maintitle2) . '" style="width:100%; margin-bottom: 15px;" /><br>';


    echo '<div id="last_products_container">';
    foreach ($last_products as $index => $product) {
        echo '<div class="last-product-item">';
        echo '<input type="text" name="last_products[' . $index . '][title]" placeholder="عنوان محصول" value="' . esc_attr($product['title'] ?? '') . '" /><br>';
        echo '<img class="last-product-preview" src="' . esc_attr($product['image']) . '" style="width:100px; height:100px; border:1px solid #ccc;" /><br>';
        echo '<input type="hidden" name="last_products[' . $index . '][image]" class="last-product-image" value="' . esc_attr($product['image']) . '" />';
        echo '<input type="button" class="button select-last-product-image" value="انتخاب تصویر" />';
        echo '<input type="url" name="last_products[' . $index . '][url]" placeholder="آدرس لینک" value="' . esc_attr($product['url']) . '" />';
        echo '<input type="button" class="button remove-last-product-item" value="حذف" /><br><br>';
        echo '</div>';
    }
    echo '</div>';
    echo '<input type="button" id="add_last_product_button" class="button" value="افزودن مورد" />';

    echo '<script>
        jQuery(document).ready(function($){
            $("#add_last_product_button").click(function(){
                if ($(".last-product-item").length < 5) {
                    var index = $(".last-product-item").length;
                    $("#last_products_container").append(`
                        <div class="last-product-item">
                            <input type="text" name="last_products[` + index + `][title]" placeholder="عنوان محصول" /><br>
                            <img class="last-product-preview" src="" style="width:100px; height:100px; border:1px solid #ccc; display:none;" /><br>
                            <input type="hidden" name="last_products[` + index + `][image]" class="last-product-image" />
                            <input type="button" class="button select-last-product-image" value="انتخاب تصویر" />
                            <input type="url" name="last_products[` + index + `][url]" placeholder="آدرس لینک" />
                            <input type="button" class="button remove-last-product-item" value="حذف" /><br><br>
                        </div>
                    `);
                }
            });
            $(document).on("click", ".remove-last-product-item", function(){
                $(this).parent().remove();
            });
            $(document).on("click", ".select-last-product-image", function(e){
                e.preventDefault();
                var button = $(this);
                var mediaUploader = wp.media({
                    title: "انتخاب تصویر",
                    button: { text: "انتخاب" },
                    multiple: false
                });
                mediaUploader.on("select", function(){
                    var attachment = mediaUploader.state().get("selection").first().toJSON();
                    button.siblings(".last-product-image").val(attachment.url);
                    button.siblings(".last-product-preview").attr("src", attachment.url).show();
                });
                mediaUploader.open();
            });
        });
    </script>';
}



// اضافه کردن متاباکس جدید برای سوالات متداول
function services_add_faq_meta_box()
{
    add_meta_box(
        'services_faq',
        'سوالات متداول',
        'services_faq_meta_box_callback',
        'services',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'services_add_faq_meta_box');

// نمایش متاباکس سوالات متداول
function services_faq_meta_box_callback($post)
{
    wp_nonce_field('services_save_meta_box_data', 'services_meta_box_nonce');
    $faqs = get_post_meta($post->ID, 'faqs', true);
    if (!is_array($faqs)) {
        $faqs = [];
    }

    echo '<div id="faq_container">';
    foreach ($faqs as $index => $faq) {
        echo '<div class="faq-item">';
        echo '<input type="text" name="faqs[' . $index . '][question]" placeholder="سوال" value="' . esc_attr($faq['question']) . '" style="width:100%; margin-bottom:5px;" />';
        echo '<textarea name="faqs[' . $index . '][answer]" placeholder="پاسخ" rows="3" style="width:100%;">' . esc_textarea($faq['answer']) . '</textarea>';
        echo '<input type="button" class="button remove-faq-item" value="حذف" /><br><br>';
        echo '</div>';
    }
    echo '</div>';
    echo '<input type="button" id="add_faq_button" class="button" value="افزودن سوال" />';

    echo '<script>
        jQuery(document).ready(function($){
            $("#add_faq_button").click(function(){
                var index = $(".faq-item").length;
                $("#faq_container").append(`
                    <div class="faq-item">
                        <input type="text" name="faqs[` + index + `][question]" placeholder="سوال" style="width:100%; margin-bottom:5px;" />
                        <textarea name="faqs[` + index + `][answer]" placeholder="پاسخ" rows="3" style="width:100%;"></textarea>
                        <input type="button" class="button remove-faq-item" value="حذف" /><br><br>
                    </div>
                `);
            });
            $(document).on("click", ".remove-faq-item", function(){
                $(this).parent().remove();
            });
        });
    </script>';
}




// ذخیره داده‌های متاباکس
function services_save_meta_box_data($post_id)
{
    if (!isset($_POST['services_meta_box_nonce']) || !wp_verify_nonce($_POST['services_meta_box_nonce'], 'services_save_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['first_description'])) {
        update_post_meta($post_id, 'first_description', $_POST['first_description']);
    }
    if (isset($_POST['first_picture'])) {
        update_post_meta($post_id, 'first_picture', $_POST['first_picture']);
    }
    if (isset($_POST['first_products'])) {
        update_post_meta($post_id, 'first_products', $_POST['first_products']);
    }
    if (isset($_POST['full_description'])) {
        update_post_meta($post_id, 'full_description', $_POST['full_description']);
    }
    if (isset($_POST['last_products'])) {
        update_post_meta($post_id, 'last_products', $_POST['last_products']);
    }
    if (isset($_POST['faqs'])) {
        update_post_meta($post_id, 'faqs', $_POST['faqs']);
    }
    if (isset($_POST['maintitle1'])) {
        update_post_meta($post_id, 'maintitle1', sanitize_text_field($_POST['maintitle1']));
    }
    if (isset($_POST['maintitle2'])) {
        update_post_meta($post_id, 'maintitle2', sanitize_text_field($_POST['maintitle2']));
    }
}
add_action('save_post', 'services_save_meta_box_data');


