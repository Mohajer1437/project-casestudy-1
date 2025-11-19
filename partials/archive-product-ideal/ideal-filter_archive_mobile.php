<?php
$category = get_queried_object();
$categoryId = isset($category->term_id) ? (int) $category->term_id : 0;
$attributes = apply_filters('idealboresh/archive/popular_attributes', [], $categoryId, 4);
$current = isset($_GET['orderby'])
    ? wc_clean(wp_unslash($_GET['orderby']))
    : apply_filters(
        'woocommerce_default_catalog_orderby',
        get_option('woocommerce_default_catalog_orderby', 'menu_order')
    );
$orderby_options = apply_filters('woocommerce_catalog_orderby', array(
    'menu_order' => __('مرتب‌سازی پیش‌فرض', 'woocommerce'),
    'popularity' => __('مرتب‌سازی بر اساس محبوبیت', 'woocommerce'),
    'rating' => __('مرتب‌سازی بر اساس امتیاز', 'woocommerce'),
    'date' => __('مرتب‌سازی بر اساس جدیدترین', 'woocommerce'),
    'price' => __('قیمت: کم به زیاد', 'woocommerce'),
    'price-desc' => __('قیمت: زیاد به کم', 'woocommerce'),
));
?>
<div class="grid grid-cols-3 font-sansFanumRegular px-[18px] gap-x-2 gap-y-4 xl:hidden" id="taxonomy-mobile"
    data-mobile_taxonomy="<?php echo esc_attr($category->taxonomy ?? ''); ?>"
    data-mobile_termid="<?php echo esc_attr((string) $categoryId); ?>">
    <!-- خانهٔ اول: سلکت‌باکس سورت کاستوم -->
    <div>
        <select style="width: 100%; max-width: 100%;" id="custom-orderby"
            class="Filter_by_attribute bg-zinc-100 p-2 outline-0 rounded-lg border border-nili-200">
            <?php foreach ($orderby_options as $key => $label): ?>
                <option value="<?php echo esc_attr($key); ?>" <?php selected($current, $key); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- بقیهٔ سلکت‌های فیلتر بر اساس ویژگی -->
    <?php if (!empty($attributes)): ?>
        <?php foreach ($attributes as $attribute => $terms): ?>
            <select data-product_attribute="<?php echo esc_attr($attribute); ?>"
                class="Filter_by_attribute bg-zinc-100 p-2 outline-0 rounded-lg border border-nili-200">
                <option value="" selected disabled>
                    <?php echo esc_html(wc_attribute_label($attribute)); ?>
                </option>
                <?php foreach ($terms as $term): ?>
                    <option value="<?php echo esc_attr((string) $term['id']); ?>">
                        <?php echo esc_html($term['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var orderSelect = document.getElementById('custom-orderby');
        if (!orderSelect) return;

        orderSelect.addEventListener('change', function () {
            var val = this.value;
            var url = new URL(window.location.href);

            // تنظیم پارامتر orderby و حذف paged برای بازگشت به صفحه اول
            url.searchParams.set('orderby', val);
            url.searchParams.delete('paged');

            window.location.href = url.toString();
        });
    });
</script>