<?php global $product;
$ProductName = $product->get_name();
?>




<div class="col-span-2 font-sansRegular text-black px-5">

    <p class="font-sansFanumBold lg:text-[18px]"><?php echo $ProductName; ?></p>


    <div class="flex mt-1 lg:mt-3 border-b border-zinc-200 pb-2 lg:pb-4 font-sansFanumRegular">
        <svg class="w-4 h-4 lg:w-5 lg:h-5 mt-1">
            <use href="#widget"></use>
        </svg>

        <div class="flex flex-col lg:flex-row mr-2 gap-x-1 gap-y-1">
            <p class="font-sansBold">دسته بندی : </p>
            <?php echo $product->get_categories() ?>
        </div>
    </div>

    <div class="lg:mt-5 mt-3 text-black">
        <p>ویژگی های محصول</p>

        <?php
        // ۱. گرفتن ترم‌های برند (از taxonomy «product_brand»)
        $brand_terms = get_the_terms($product->get_id(), 'product_brand');

        // ۲. فیلتر کردن اتربیوت‌های فنیِ قابل نمایش
        $technical_attributes = array_filter(
            $product->get_attributes(),
            function ($attr) {
                return $attr->get_visible() && $attr->get_options();
            }
        );

        // ۳. تعیین تعداد اتربیوت برای slice بر اساس وجود برند
        //    اگر برند داریم، ۳ تا اتربیوت فنی؛ وگرنه ۴ تا
        $slice_count = (!is_wp_error($brand_terms) && !empty($brand_terms)) ? 3 : 4;
        $limited_attrs = array_slice($technical_attributes, 0, $slice_count);

        // ۴. اگر حداقل ۱ مورد داریم، گرید رو باز کن
        if ((!is_wp_error($brand_terms) && !empty($brand_terms)) || !empty($limited_attrs)) {

            echo '<div class="grid grid-cols-2 lg:grid-cols-3 mt-3 gap-x-2 gap-y-[7px] lg:gap-y-[10px] font-sansFanumRegular">';

            // — برند (ردیف اول) فقط اگر وجود داشت
            if (!is_wp_error($brand_terms) && !empty($brand_terms)) {
                $tax = get_taxonomy('product_brand');
                $brand_label = $tax->labels->singular_name;

                echo '<div class="px-4 py-3 bg-nili-100 rounded-[10px]">'
                    . esc_html($brand_label)
                    . '</div>';

                echo '<div class="px-4 py-3 bg-nili-100 lg:col-span-2 rounded-[10px]">';
                $links = array();
                foreach ($brand_terms as $term) {
                    $links[] = sprintf(
                        '<a style="color:blue;" href="%s">%s</a>',
                        esc_url(get_term_link($term)),
                        esc_html($term->name)
                    );
                }
                echo implode(', ', $links);
                echo '</div>';
            }

            // — اتربیوت‌های فنی (۳ یا ۴ ردیف بسته به برند)
            foreach ($limited_attrs as $attribute) {
                $name = $attribute->get_name();
                $label = wc_attribute_label($name);
                $values = wc_get_product_terms(
                    $product->get_id(),
                    $name,
                    ['fields' => 'names']
                );

                echo '<div class="px-4 py-3 bg-nili-100 rounded-[10px]">'
                    . esc_html($label)
                    . '</div>';
                echo '<div class="px-4 py-3 bg-nili-100 lg:col-span-2 rounded-[10px]">'
                    . esc_html(implode(', ', $values))
                    . '</div>';
            }

            echo '</div>';
        }
        ?>





        <div class="mt-4 lg:mt-7 flex justify-between">
            <div class="show-more cursor-pointer flex items-center gap-x-1">
                <p class="font-sansRegular text-mainBlue hidden lg:flex">مشاهده ویژگی های بیشتر</p>
                <p class="font-sansRegular text-mainBlue lg:hidden">بیشتر</p>
                <svg class="w-5 h-5">
                    <use href="#chevronLeft"></use>
                </svg>
            </div>
            <?php
            $media_id = get_post_meta(get_the_ID(), 'catalog_media_id', true);
            if ($media_id && $url = wp_get_attachment_url($media_id)) {
                echo '<a href="' . esc_url($url) . '" class="flex gap-x-2 lg:px-5 px-4 py-2 lg:py-3 bg-neutral-200 w-fit rounded-xl shadow-md">
                <p>دانلود کاتالوگ</p>
                <div>
                    <svg class="w-5 h-5">
                        <use href="#book2"></use>
                    </svg>
                </div>
            </a>';
            } else {
                echo '<p style="display: block !important; margin: 0 auto !important; width: fit-content !important; padding: 2rem !important;">کاتالوگ برای این محصول موجود نیست.</p>';
            }
            ?>


        </div>


    </div>

</div>
<?php

// حذف فیلد وب‌سایت از فرم کامنت
function idealboresh_remove_comment_url_field( $fields ) {
    if ( isset( $fields['url'] ) ) {
        unset( $fields['url'] );
    }
    return $fields;
}
add_filter( 'comment_form_default_fields', 'idealboresh_remove_comment_url_field' );
