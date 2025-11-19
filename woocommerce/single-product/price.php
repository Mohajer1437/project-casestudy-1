<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;
$dollar_enabled = get_option('dollar_enabled', false); // مقدار پیش‌فرض false

$dollar_price = get_option('dollar_price', '');
$dollar = ($dollar_enabled === 'true') ? $dollar_price : 1;
$dollar = number_format((float) $dollar, 0, '.', '');

if (!function_exists('DiscountCalculation')) {
    function DiscountCalculation($RegularPrice, $SalePrice): int
    {
        return ceil(($RegularPrice - $SalePrice) / $RegularPrice * 100);
    }
}
?>
<?php if ($product->is_in_stock()): ?>
    <div class="w-fit self-end">
        <?php 
        // چک کنیم که محصول طولی هست یا نه
        $price_per_cm = get_post_meta($product->get_id(), '_price_per_cm', true);

        if ($product->is_on_sale()): ?>
            <?php if ($product->is_type('variable')): ?>
                <?php $Regularprice = $product->get_variation_regular_price('max'); ?>
                <?php $SalePrice = $product->get_variation_sale_price('min'); ?>

                <?php if (!($SalePrice == 0 && $price_per_cm !== '')): ?>
                    <div class="flex items-center justify-between font-sansFanumBold">
                        <del class="text-zinc-600 text-[13px] lg:text-[14px]"><?php echo $Regularprice ?></del>
                        <p class="text-white bg-red-600 px-1 py-[2px] rounded-md text-[12px] lg:text-[14px]">
                            <?php echo DiscountCalculation($Regularprice, $SalePrice) . '%'; ?></p>
                    </div>

                    <div class="flex gap-x-1 items-center font-sansFanumBold">
                        <p class="text-black text-[14px] lg:text-base"><?php echo number_format($SalePrice * $dollar); ?></p>
                        <p class="text-mainBlue text-[10px]">تومان</p>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <?php $Regularprice = $product->get_regular_price(); ?>
                <?php $SalePrice    = $product->get_sale_price(); ?>

                <?php if (!($SalePrice == 0 && $price_per_cm !== '')): ?>
                    <div class="flex items-center justify-between font-sansFanumBold">
                        <del class="text-zinc-600 text-[13px] lg:text-[14px]"><?php echo $Regularprice * $dollar ?></del>
                        <p class="text-white bg-red-600 px-1 py-[2px] rounded-md text-[12px] lg:text-[14px]">
                            <?php echo DiscountCalculation($Regularprice, $SalePrice) . '%'; ?></p>
                    </div>

                    <div class="flex gap-x-1 items-center font-sansFanumBold">
                        <p class="text-black text-[14px] lg:text-base"><?php echo number_format($SalePrice * $dollar); ?></p>
                        <p class="text-mainBlue text-[10px]">تومان</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        <?php else: ?>
            <?php if ($product->is_type('variable')): ?>
                <?php $Regularprice = (float) $product->get_variation_regular_price('min'); ?>

                <?php if (!($Regularprice == 0 && $price_per_cm !== '')): ?>
                    <div class="flex gap-x-1 items-center font-sansFanumBold">
                        <p class="text-black text-[14px] lg:text-base"><?php echo number_format($Regularprice * $dollar); ?></p>
                        <p class="text-mainBlue text-[10px]">تومان</p>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <?php $Regularprice = (float) $product->get_regular_price(); ?>

                <?php if (!($Regularprice == 0 && $price_per_cm !== '')): ?>
                    <div class="flex gap-x-1 items-center font-sansFanumBold">
                        <p class="text-black text-[14px] lg:text-base"><?php echo number_format($Regularprice * $dollar); ?></p>
                        <p class="text-mainBlue text-[10px]">تومان</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
