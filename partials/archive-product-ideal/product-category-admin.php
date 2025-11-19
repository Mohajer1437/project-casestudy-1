<?php
function custom_admin_script() {
    // فقط در صفحه ویرایش دسته‌بندی محصول در ادمین
    if (isset($_GET['taxonomy']) && $_GET['taxonomy'] === 'product_cat') {
        ?>
        <script type="text/javascript">
            document.querySelector('.term-description-wrap').remove();
        </script>
        <?php
    }
}
add_action('admin_footer', 'custom_admin_script');




// اضافه کردن فیلد توضیحات کامل در ادمین
add_action('product_cat_edit_form_fields', 'add_full_description_field', 10, 2);
function add_full_description_field($term, $taxonomy) {
    $value = get_term_meta($term->term_id, 'full_description', true);
    wp_nonce_field('save_full_description_nonce', 'full_description_nonce');
    ?>
    <tr class="form-field">
        <th scope="row">
            <label for="full_description"><?php _e('توضیحات کامل'); ?></label>
        </th>
        <td>
            <?php 
            wp_editor(
                htmlspecialchars_decode($value), 
                'full_description', 
                array(
                    'textarea_name' => 'full_description',
                    'editor_height' => 200,
                    'media_buttons' => true,
                    'teeny' => false
                )
            ); 
            ?>
        </td>
    </tr>
    <?php
}

// ذخیرهسازی دادهها
add_action('edited_product_cat', 'save_full_description', 10, 2);
function save_full_description($term_id, $tt_id) {
    if (!isset($_POST['full_description_nonce']) || 
        !wp_verify_nonce($_POST['full_description_nonce'], 'save_full_description_nonce')) {
        return;
    }
    
    if (isset($_POST['full_description'])) {
        update_term_meta(
            $term_id,
            'full_description',
            wp_kses_post($_POST['full_description'])
        );
    }
}



// افزودن فیلد "توضیح کوتاه" به دسته‌بندی‌های محصولات
function add_category_short_description_field($taxonomy)
{
    ?>
    <div class="form-field">
        <label for="category_short_description"><?php _e('توضیح کوتاه', 'atrinplus'); ?></label>
        <?php
        // نمایش ویرایشگر وردپرس
        wp_editor(
            '',
            'category_short_description',
            array(
                'textarea_name' => 'category_short_description',
                'media_buttons' => false,
                'textarea_rows' => 5,
                'teeny' => true,
            )
        );
        ?>
        <p class="description"><?php _e('یک توضیح کوتاه برای این دسته‌بندی وارد کنید.', 'atrinplus'); ?></p>
    </div>
    <?php
}
add_action('product_cat_add_form_fields', 'add_category_short_description_field', 10, 1);

// ذخیره مقدار وارد شده
function save_category_short_description_field($term_id)
{
    if (isset($_POST['category_short_description'])) {
        update_term_meta($term_id, 'category_short_description', wp_kses_post($_POST['category_short_description']));
    }
}
add_action('created_product_cat', 'save_category_short_description_field', 10, 1);

// افزودن فیلد به فرم ویرایش دسته‌بندی
function edit_category_short_description_field($term, $taxonomy)
{
    $short_description = get_term_meta($term->term_id, 'category_short_description', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="category_short_description"><?php _e('توضیح کوتاه', 'atrinplus'); ?></label>
        </th>
        <td>
            <?php
            wp_editor(
                $short_description,
                'category_short_description',
                array(
                    'textarea_name' => 'category_short_description',
                    'media_buttons' => false,
                    'textarea_rows' => 5,
                    'teeny' => true,
                )
            );
            ?>
            <p class="description"><?php _e('یک توضیح کوتاه برای این دسته‌بندی وارد کنید.', 'atrinplus'); ?></p>
        </td>
    </tr>
    <?php
}
add_action('product_cat_edit_form_fields', 'edit_category_short_description_field', 10, 2);

// ذخیره مقدار فیلد در ویرایش
function update_category_short_description_field($term_id)
{
    if (isset($_POST['category_short_description'])) {
        update_term_meta($term_id, 'category_short_description', wp_kses_post($_POST['category_short_description']));
    }
}
add_action('edited_product_cat', 'update_category_short_description_field', 10, 1);



// توضیحات کوتاه برای سمت ادمین برند
/**
 * Short Description field for product categories AND brands.
 * - product_cat  -> meta key: category_short_description
 * - brand tax    -> meta key: brand_short_description
 */
add_action('init', function () {

    // 1) فیلدهای مربوط به دسته محصول (مثل کد خودت) — اگر قبلاً داری، این بخش را نادیده بگیر.
    add_action('product_cat_add_form_fields', function($taxonomy){
        ?>
        <div class="form-field">
            <label for="category_short_description"><?php _e('توضیح کوتاه', 'atrinplus'); ?></label>
            <?php
            wp_editor(
                '',
                'category_short_description',
                array(
                    'textarea_name' => 'category_short_description',
                    'media_buttons' => false,
                    'textarea_rows' => 5,
                    'teeny' => true,
                )
            );
            ?>
            <p class="description"><?php _e('یک توضیح کوتاه برای این دسته‌بندی وارد کنید.', 'atrinplus'); ?></p>
        </div>
        <?php
    }, 10, 1);

    add_action('created_product_cat', function($term_id){
        if (isset($_POST['category_short_description'])) {
            update_term_meta($term_id, 'category_short_description', wp_kses_post($_POST['category_short_description']));
        }
    }, 10, 1);

    add_action('product_cat_edit_form_fields', function($term, $taxonomy){
        $short_description = get_term_meta($term->term_id, 'category_short_description', true);
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="category_short_description"><?php _e('توضیح کوتاه', 'atrinplus'); ?></label>
            </th>
            <td>
                <?php
                wp_editor(
                    $short_description,
                    'category_short_description',
                    array(
                        'textarea_name' => 'category_short_description',
                        'media_buttons' => false,
                        'textarea_rows' => 5,
                        'teeny' => true,
                    )
                );
                ?>
                <p class="description"><?php _e('یک توضیح کوتاه برای این دسته‌بندی وارد کنید.', 'atrinplus'); ?></p>
            </td>
        </tr>
        <?php
    }, 10, 2);

    add_action('edited_product_cat', function($term_id){
        if (isset($_POST['category_short_description'])) {
            update_term_meta($term_id, 'category_short_description', wp_kses_post($_POST['category_short_description']));
        }
    }, 10, 1);

    // 2) همان فیلد برای «برندها» (هر تاکسونومی برندی که وجود داشته باشد)
    $possible_brand_taxes = array('product_brand', 'pwb-brand', 'yith_product_brand');
    $brand_taxes = array_filter($possible_brand_taxes, 'taxonomy_exists');

    foreach ($brand_taxes as $tax) {

        // صفحه افزودن برند
        add_action("{$tax}_add_form_fields", function($taxonomy) {
            ?>
            <div class="form-field">
                <label for="brand_short_description"><?php _e('توضیح کوتاه برند', 'atrinplus'); ?></label>
                <?php
                wp_editor(
                    '',
                    'brand_short_description',
                    array(
                        'textarea_name' => 'brand_short_description',
                        'media_buttons' => false,
                        'textarea_rows' => 5,
                        'teeny' => true,
                    )
                );
                ?>
                <p class="description"><?php _e('یک توضیح کوتاه برای این برند وارد کنید.', 'atrinplus'); ?></p>
            </div>
            <?php
        }, 10, 1);

        // ذخیره در ساخت برند
        add_action("created_{$tax}", function($term_id){
            if (isset($_POST['brand_short_description'])) {
                update_term_meta($term_id, 'brand_short_description', wp_kses_post($_POST['brand_short_description']));
            }
        }, 10, 1);

        // صفحه ویرایش برند
        add_action("{$tax}_edit_form_fields", function($term, $taxonomy){
            $short_description = get_term_meta($term->term_id, 'brand_short_description', true);
            ?>
            <tr class="form-field">
                <th scope="row" valign="top">
                    <label for="brand_short_description"><?php _e('توضیح کوتاه برند', 'atrinplus'); ?></label>
                </th>
                <td>
                    <?php
                    wp_editor(
                        $short_description,
                        'brand_short_description',
                        array(
                            'textarea_name' => 'brand_short_description',
                            'media_buttons' => false,
                            'textarea_rows' => 5,
                            'teeny' => true,
                        )
                    );
                    ?>
                    <p class="description"><?php _e('یک توضیح کوتاه برای این برند وارد کنید.', 'atrinplus'); ?></p>
                </td>
            </tr>
            <?php
        }, 10, 2);

        // ذخیره در ویرایش برند
        add_action("edited_{$tax}", function($term_id){
            if (isset($_POST['brand_short_description'])) {
                update_term_meta($term_id, 'brand_short_description', wp_kses_post($_POST['brand_short_description']));
            }
        }, 10, 1);
    }
});




// افزودن فیلد سفارشی به فرم ویرایش دسته‌بندی محصول
function add_product_category_faq_meta_field($term) {
    $category_faqs = get_term_meta($term->term_id, 'product_category_faqs', true);
    if (!is_array($category_faqs)) {
        $category_faqs = [];
    }
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="product_category_faqs">سوالات متداول</label></th>
        <td>
            <div id="product_category_faqs_container">
                <?php foreach ($category_faqs as $index => $faq): ?>
                    <div class="category-faq-item">
                        <input type="text" class="category-faq-question" name="product_category_faqs[<?php echo $index; ?>][question]" placeholder="سوال"
                               value="<?php echo esc_attr($faq['question']); ?>" style="width:100%; margin-bottom:5px;" />
                        <textarea class="category-faq-answer" name="product_category_faqs[<?php echo $index; ?>][answer]" placeholder="پاسخ" rows="3"
                                  style="width:100%;"><?php echo esc_textarea($faq['answer']); ?></textarea>
                        <input type="button" class="button remove-category-faq-item" value="حذف" /><br><br>
                    </div>
                <?php endforeach; ?>
            </div>
            <input type="button" id="add-category-faq-button" class="button" value="افزودن سوال" />
        </td>
    </tr>
    <script>
        jQuery(document).ready(function ($) {
            $("#add-category-faq-button").click(function () {
                let index = $(".category-faq-item").length;
                $("#product_category_faqs_container").append(`
                <div class="category-faq-item">
                    <input type="text" class="category-faq-question" name="product_category_faqs[${index}][question]" placeholder="سوال" style="width:100%; margin-bottom:5px;" />
                    <textarea class="category-faq-answer" name="product_category_faqs[${index}][answer]" placeholder="پاسخ" rows="3" style="width:100%;"></textarea>
                    <input type="button" class="button remove-category-faq-item" value="حذف" /><br><br>
                </div>
                `);
            });

            $(document).on("click", ".remove-category-faq-item", function () {
                $(this).parent().remove();
            });
        });
    </script>
    <?php
}
add_action('product_cat_edit_form_fields', 'add_product_category_faq_meta_field', 10, 2);



function save_product_category_faq_meta_field($term_id) {
    if (isset($_POST['product_category_faqs']) && is_array($_POST['product_category_faqs'])) {
        update_term_meta($term_id, 'product_category_faqs', $_POST['product_category_faqs']);
    } else {
        delete_term_meta($term_id, 'product_category_faqs');
    }
}
add_action('edited_product_cat', 'save_product_category_faq_meta_field', 10, 2);