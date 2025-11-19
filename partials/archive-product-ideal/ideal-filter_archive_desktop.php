<?php
$category = get_queried_object(); // دریافت دسته‌بندی فعلی
$categoryId = isset($category->term_id) ? (int) $category->term_id : 0;
$attributes = apply_filters('idealboresh/archive/popular_attributes', [], $categoryId, 4);
?>
<div class="hidden xl:flex flex-col space-y-5 h-fit bg-white rounded-xl shadow-lg px-7 pt-8 ">
    <div class="flex gap-x-2">
        <div>
            <svg class="w-[26px] h-[26px]">
                <use href="#filter"></use>
            </svg>
        </div>
        <p class="font-sansBold text-black text-[21px]">فیلتر ها</p>
    </div>
    <?php if (!empty($attributes)) : ?>
    <?php foreach ($attributes as $attribute => $terms) : ?>
            <div class="Accordion__parent__filter font-sansFanumBold text-zinc-600 border-b pb-4 cursor-pointer" data-product_attribute="<?php echo esc_attr($attribute); ?>">
                <div class="flex justify-between items-center Accordion__parent__title">
                    <div><?php echo esc_html(wc_attribute_label($attribute)) ?></div>
                    <div>
                        <svg class="w-6 h-6 transition-all duration-500">
                            <use href="#arrowdown2"></use>
                        </svg>
                    </div>
                </div>
                <div class="Accordion__content h-0 overflow-hidden  filter-items transition-all duration-500">
                    <form class="space-y-4 mt-8">
                        <?php foreach ($terms as $term) : ?>
                            <label class="pb-4 flex items-center gap-x-2 item-filter cursor-pointer" for="<?php echo esc_attr((string) $term['id']); ?>">
                                <input class="filter_by_attribute_desk" value="<?php echo esc_attr((string) $term['id']); ?>" type="checkbox"  id="<?php echo esc_attr((string) $term['id']); ?>">
                                <p class="text-[13px]"><?php echo esc_html($term['name']); ?></p>
                            </label>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>