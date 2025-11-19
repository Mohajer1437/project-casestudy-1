<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined('ABSPATH') || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if (!is_a($product, WC_Product::class) || !$product->is_visible()) {
    return;
}
$inventory = false;
if ($product->is_in_stock()) {
    $inventory = true;
} else {
    $inventory = false;
}



?>
<div <?php wc_product_class('flex flex-col justify-between  bg-white py-2 lg:py-3 space-y-2 lg:space-y-4 px-2 lg:px-3 rounded-xl  h-[300px] lg:h-[450px] product__content', $product); ?> id="<?php echo $product->get_id() ?>">
    <?php $terms = wp_get_post_terms($product->get_id(), 'product_cat'); ?>
    <div
        class="flex flex-col justify-between  bg-white py-2 lg:py-3 space-y-2 lg:space-y-4 px-2 lg:px-3 rounded-xl  h-[300px] lg:h-[450px]">

        <?php

        // ۱) گرفتن ترم‌های برند
        $terms = get_the_terms($product->get_id(), 'product_brand');

        // ۲) چکِ صحیح بودن خروجی
        if (!is_wp_error($terms) && is_array($terms) && !empty($terms)) {

            // ۳) گرفتن اولین برند
            $brand = reset($terms);  // معادل array_shift ولی بدون خطا روی false
        
            // ۴) نمایش فقط وقتی داریم
            ?>
            <div
                class="absolute px-2 py-1 lg:px-3 lg:py-2 bg-nili-200 text-mainBlue text-[12px] lg:text-base w-fit font-sansBold rounded-lg self-end">

                <a href="<?php echo esc_url(get_term_link($brand)); ?>"><?php echo esc_html($brand->name); ?></a>
            </div>
            <?php
        } else {
            echo '<div class="absolute px-2 py-1 lg:px-3 lg:py-2 w-fit"></div>';
        }
        // اگر ترم برند نباشد، اصلاً این بلوک چاپ نمی‌شود و اروری هم نیست.
        ?>

        <a href="<?php echo get_permalink() ?>">
            <img class="max-w-[120px] lg:max-w-[220px]  lg:h-auto lg:max-h-full mx-auto rounded-lg"
                src="<?php echo get_the_post_thumbnail_url() ?>">
        </a>
        <div class="space-y-2 lg:space-y-4">
            <a href="<?php echo get_permalink() ?>">
                <div class="font-sansRegular text-zinc-600">
                    <p style="height: 70px;" class="lg:text-base text-[13px]"><?php echo get_the_title() ?></p>
                </div>
            </a>
            <div class="flex items-center justify-between px-1 lg:px-2 bg-zinc-100  h-[56px] lg:h-[64px] rounded-xl">



                <?php
                $dollar_enabled = get_option('dollar_enabled', false); // مقدار پیش‌فرض false
                
                $dollar_price = get_option('dollar_price', '');
                $dollar = ($dollar_enabled === 'true') ? $dollar_price : 1;
                $dollar = number_format((float) $dollar, 0, '.', '');
                ?>

                <?php if ($inventory): ?>
                    <?php if ($product->is_type('simple')): ?>
                        <a href="#" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-quantity="1"
                            class="bg-nili-100 w-fit p-2 lg:p-3 rounded-xl idealboresh-add-to-cart"
                            aria-label="<?php printf(esc_attr__('Add "%s" to your cart', 'woocommerce'), $product->get_name()); ?>">
                            <svg class="w-4 h-4 lg:w-6 lg:h-6">
                                <use href="#bag"></use>
                            </svg>
                        </a>
                    <?php elseif ($product->is_type('variable')): ?>
                        <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>"
                            class="bg-nili-100 w-fit p-2 lg:p-3 rounded-xl"
                            aria-label="<?php esc_attr_e('View product details', 'woocommerce'); ?>">
                            <svg class="w-4 h-4 lg:w-6 lg:h-6">
                                <use href="#bag"></use>
                            </svg>
                        </a>
                    <?php endif; ?>
                    <div>
                        <?php
                        // چک کنیم آیا محصول سانتیمتری است
                        $price_per_cm = get_post_meta($product->get_id(), '_price_per_cm', true);
                        $min_length = (float) get_post_meta($product->get_id(), '_min_length_cm', true);

                        // اگر سانتیمتری فعال باشد:
                        if ($price_per_cm !== '') {
                            // گرفتن لیست ضرایب TPI از option
                            $tpi_list = get_option('wc_pbl_tpi_list', []);
                            $min_factor = 1.0;
                            if (is_array($tpi_list) && !empty($tpi_list)) {
                                $factors = array_column($tpi_list, 'factor');
                                $factors = array_map('floatval', $factors);
                                $min_factor = min($factors);
                            }

                            // اگر حداقل طول تعیین نشده بود، 1 در نظر بگیریم
                            $min_length = $min_length > 0 ? $min_length : 1;

                            // محاسبه قیمت نهایی بر اساس حداقل طول و ضریب TPI
                            $min_price = $min_length * (float) $price_per_cm * $min_factor;

                            // اگر دلار فعال است، ضرب در نرخ دلار
                            $dollar_enabled = get_option('dollar_enabled', 'false');
                            $dollar_price = (float) get_option('dollar_price', 1);
                            if ($dollar_enabled === 'true' && $dollar_price > 0) {
                                $min_price = $min_price * $dollar_price;
                            }
                            ?>
                            <div class="flex gap-x-1 items-center font-sansFanumBold">
                                <p class="text-black text-[14px] lg:text-base">
                                    <?php echo number_format($min_price); ?>
                                </p>
                                <p class="text-mainBlue text-[10px]">تومان</p>
                            </div>
                            <?php
                        } else {
                            // همین کدی که قبلاً داشتی برای on_sale و regular price
                            if ($product->is_on_sale()): ?>
                                <?php if ($product->is_type('variable')): ?>
                                    <?php $Regularprice = $product->get_variation_regular_price('max'); ?>
                                    <?php $SalePrice = $product->get_variation_sale_price('min') ?>
                                    <div class="flex items-center justify-between font-sansFanumBold">
                                        <del
                                            class="text-zinc-600 text-[13px] lg:text-[14px]"><?php echo $Regularprice * $dollar ?></del>
                                        <p class="text-white bg-red-600 px-1 py-[2px] rounded-md text-[12px] lg:text-[14px]">
                                            <?php echo DiscountCalculation($Regularprice, $SalePrice) . '%'; ?>
                                        </p>
                                    </div>
                                    <div class="flex gap-x-1 items-center font-sansFanumBold">
                                        <p class="text-black text-[14px] lg:text-base">
                                            <?php echo number_format($SalePrice * $dollar); ?>
                                        </p>
                                        <p class="text-mainBlue text-[10px]">تومان</p>
                                    </div>
                                <?php else: ?>
                                    <?php $Regularprice = $product->get_regular_price(); ?>
                                    <?php $SalePrice = $product->get_sale_price(); ?>
                                    <div class="flex items-center justify-between font-sansFanumBold">
                                        <del
                                            class="text-zinc-600 text-[13px] lg:text-[14px]"><?php echo $Regularprice * $dollar ?></del>
                                        <p class="text-white bg-red-600 px-1 py-[2px] rounded-md text-[12px] lg:text-[14px]">
                                            <?php echo DiscountCalculation($Regularprice, $SalePrice) . '%'; ?>
                                        </p>
                                    </div>
                                    <div class="flex gap-x-1 items-center font-sansFanumBold">
                                        <p class="text-black text-[14px] lg:text-base">
                                            <?php echo number_format($SalePrice * $dollar); ?>
                                        </p>
                                        <p class="text-mainBlue text-[10px]">تومان</p>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php
                                // دلار را فقط یک بار بگیریم
                                $dollar_enabled = get_option('dollar_enabled', 'false');
                                $dollar_price = get_option('dollar_price', '1');
                                $dollar = ($dollar_enabled === 'true') ? (float) $dollar_price : 1.0;

                                // قیمت اصلی
                                if ($product->is_type('variable')) {
                                    $Regularprice = (float) $product->get_variation_regular_price('min');
                                } else {
                                    $Regularprice = (float) $product->get_regular_price();
                                }
                                ?>
                                <div class="flex gap-x-1 items-center font-sansFanumBold">
                                    <p class="text-black text-[14px] lg:text-base">
                                        <?php echo number_format($Regularprice * $dollar); ?>
                                    </p>
                                    <p class="text-mainBlue text-[10px]">تومان</p>
                                </div>
                            <?php endif;
                        }
                        ?>


                    </div>
                <?php else: ?>
                    <?php
                    $phone_number = get_option('header_phone_number', '');
                    if (!empty($phone_number)) {
                        // آدرس صفحه تماس
                        $contact_url = home_url('/contact');
                        ?>
                        <div
                            class="price-inquiry-btn cursor-pointer flex w-full items-center justify-center px-1 lg:px-2 bg-[#35394C] h-[56px] rounded-xl font-sansFanumBold">
                            <p class="text-white self-center">استعلام قیمت</p>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                document.querySelectorAll('.price-inquiry-btn').forEach(function (btn) {
                                    btn.addEventListener('click', function (e) {
                                        e.preventDefault();
                                        if (window.innerWidth <= 768) {
                                            // حالت موبایل: باز کردن در تب جدید با لینک tel:
                                            window.open("tel:<?php echo esc_js($phone_number); ?>", '_blank');
                                        } else {
                                            // حالت دسکتاپ: هدایت با location.replace به صفحه تماس
                                            location.replace("<?php echo esc_url($contact_url); ?>");
                                        }
                                    });
                                });
                            });
                        </script>
                        <?php
                    }
                    ?>
                <?php endif; ?>


            </div>

        </div>



    </div>

</div>