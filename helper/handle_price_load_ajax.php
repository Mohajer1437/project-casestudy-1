<?php
// اگر از بیرون صدا زده شد، مطمئن شو وردپرس لود است
defined('ABSPATH') || exit;

global $product;

if (!function_exists('DiscountCalculation')) {
    function DiscountCalculation($RegularPrice, $SalePrice): int
    {
        if (!$RegularPrice) return 0;
        return (int) ceil(($RegularPrice - $SalePrice) / $RegularPrice * 100);
    }
}

/**
 * خروجی HTML قیمت کارت محصول برای رندر از طریق AJAX
 * - اگر محصول سانتیمتری باشد: حداقل قیمت = min_length × price_per_cm × min(TPI factor) × (dollar اگر فعال باشد)
 * - در غیر این صورت، لاجیک قبلی (حراج/عادی، ساده/متغیر) با نمایش تومان
 * - همیشه واحد نمایش: «تومان»
 */
function card_product_ajax()
{
    global $product;

    $content = '';

    if (!$product || !($product instanceof WC_Product)) {
        return $content;
    }

    // دلار: اگر فعال باشد در محاسبه ضرب می‌کنیم، ولی نمایش همیشه «تومان» است
    $dollar_enabled = get_option('dollar_enabled', 'false');
    $dollar_price   = (float) get_option('dollar_price', '1');
    $dollar         = ($dollar_enabled === 'true' && $dollar_price > 0) ? $dollar_price : 1.0;

    if ($product->is_in_stock()) {

        // --- شاخه: محصول سانتیمتری ---
        $price_per_cm = get_post_meta($product->get_id(), '_price_per_cm', true);
        if ($price_per_cm !== '' && $price_per_cm !== null) {

            // حداقل طول
            $min_length = (float) get_post_meta($product->get_id(), '_min_length_cm', true);
            $min_length = $min_length > 0 ? $min_length : 1;

            // کوچک‌ترین ضریب TPI از option سراسری
            $tpi_list   = get_option('wc_pbl_tpi_list', []);
            $min_factor = 1.0;
            if (is_array($tpi_list) && !empty($tpi_list)) {
                $factors    = array_map('floatval', array_column($tpi_list, 'factor'));
                if (!empty($factors)) {
                    $min_factor = min($factors);
                }
            }

            // محاسبه حداقل قیمت قابل نمایش
            $min_price = (float) $price_per_cm * $min_length * $min_factor * $dollar;

            $content  = '<div class="flex gap-x-1 items-center font-sansFanumBold">';
            $content .= '<p class="text-black text-[14px] lg:text-base">' . number_format($min_price) . '</p>';
            $content .= '<p class="text-mainBlue text-[10px]">تومان</p>';
            $content .= '</div>';

            return $content; // چون سانتیمتری است، قیمت عادی/حراج نمایش داده نشود
        }

        // --- شاخه: محصول غیرسانتیمتری (لاجیک قبلی) ---
        if ($product->is_on_sale()) {

            if ($product->is_type('variable')) {
                $RegularPrice = (float) $product->get_variation_regular_price('max');
                $SalePrice    = (float) $product->get_variation_sale_price('min');

                $content  = '<div class="nim flex items-center justify-between font-sansFanumBold">';
                $content .= '<del class="text-zinc-600 text-[13px] lg:text-[14px]">' . number_format($RegularPrice * $dollar) . '</del>';
                $content .= '<p class="text-white bg-red-600 px-1 py-[2px] rounded-md text-[12px] lg:text-[14px]">' . DiscountCalculation($RegularPrice, $SalePrice) . '%</p>';
                $content .= '</div>';

                $content .= '<div class="flex gap-x-1 items-center font-sansFanumBold">';
                $content .= '<p class="text-black text-[14px] lg:text-base">' . number_format($SalePrice * $dollar) . '</p>';
                $content .= '<p class="text-mainBlue text-[10px]">تومان</p>';
                $content .= '</div>';

            } else {
                $RegularPrice = (float) $product->get_regular_price();
                $SalePrice    = (float) $product->get_sale_price();

                $content  = '<div class="flex items-center justify-between font-sansFanumBold">';
                $content .= '<del class="text-zinc-600 text-[13px] lg:text-[14px]">' . number_format($RegularPrice * $dollar) . '</del>';
                $content .= '<p class="text-white bg-red-600 px-1 py-[2px] rounded-md text-[12px] lg:text-[14px]">' . DiscountCalculation($RegularPrice, $SalePrice) . '%</p>';
                $content .= '</div>';

                $content .= '<div class="flex gap-x-1 items-center font-sansFanumBold">';
                $content .= '<p class="text-black text-[14px] lg:text-base">' . number_format($SalePrice * $dollar) . '</p>';
                $content .= '<p class="text-mainBlue text-[10px]">تومان</p>';
                $content .= '</div>';
            }

        } else {

            if ($product->is_type('variable')) {
                $RegularPrice = (float) $product->get_variation_regular_price('min');
            } else {
                $RegularPrice = (float) $product->get_regular_price();
            }

            $content  = '<div class="flex gap-x-1 items-center font-sansFanumBold">';
            $content .= '<p class="text-black text-[14px] lg:text-base">' . number_format($RegularPrice * $dollar) . '</p>';
            $content .= '<p class="text-mainBlue text-[10px]">تومان</p>';
            $content .= '</div>';
        }

    } else {
        // ناموجود
        $content  = '<div class="flex gap-x-1 items-center font-sansFanumBold">';
        $content .= '<p class="text-mainBlue">ناموجود</p>';
        $content .= '</div>';
    }

    return $content;
}
