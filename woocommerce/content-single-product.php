<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
    <div class="shadow-md lg:pb-10 relative">
        <div class="container grid grid-cols-1 gap-x-5 lg:grid-cols-5 mt-4 lg:mt-6  gap-y-4">
            <?php
            /**
             * Hook: woocommerce_before_single_product_summary.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            do_action('woocommerce_before_single_product_summary');
            ?>



            <?php get_template_part('partials/product-single/review', 'product_ideal') ?>
            <div
                class="summary entry-summary lg:sticky top-[5rem] col-span-2 lg:col-span-1 bg-neutral-100 flex flex-col mx-auto w-full p-5 h-fit gap-y-3 lg:gap-y-4 rounded-xl font-sansRegular shadow-lg md:w-[286px]">
                <div style="width: 100%; height: auto; border-radius: 10px; overflow: hidden;">
                    <?php
                    if (has_post_thumbnail($product->get_id())) {
                        echo $product->get_image('woocommerce_single');
                    }
                    ?>
                </div>
                <?php
                /**
                 * Hook: woocommerce_single_product_summary.
                 *
                 * @hooked woocommerce_template_single_title - 5
                 * @hooked woocommerce_template_single_rating - 10
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked woocommerce_template_single_excerpt - 20
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 * @hooked WC_Structured_Data::generate_product_data() - 60
                 */
                do_action('woocommerce_single_product_summary');
                ?>
            </div>

        </div>
    </div>
    <div class="w-full border-b border-zinc-300 pb-4 lg:pb-6">

        <div class="container mx-auto mt-7">

            <div class="grid  grid-cols-5 gap-x-[6px] font-sansFanumRegular">

                <div class="mx-auto">
                    <div class="flex items-center justify-start gap-x-1">
                        <svg class="w-10 h-9 hidden lg:flex">
                            <use href="#pro1"></use>
                        </svg>
                        <p class="text-[10px] lg:text-base">ارسال سریع</p>
                    </div>
                </div>


                <div class="mx-auto">
                    <div class="flex items-center justify-start gap-x-1">
                        <svg class="w-10 h-9 hidden lg:flex">
                            <use href="#pro2"></use>
                        </svg>
                        <p class="text-[10px] lg:text-base">ارسال سریع</p>
                    </div>
                </div>


                <div class="mx-auto">
                    <div class="flex items-center justify-start gap-x-1">
                        <svg class="w-10 h-9 hidden lg:flex">
                            <use href="#pro3"></use>
                        </svg>
                        <p class="text-[10px] lg:text-base">ارسال سریع</p>
                    </div>
                </div>


                <div class="mx-auto">
                    <div class="flex items-center justify-start gap-x-1">
                        <svg class="w-10 h-9 hidden lg:flex">
                            <use href="#pro4"></use>
                        </svg>
                        <p class="text-[10px] lg:text-base">ارسال سریع</p>
                    </div>
                </div>


                <div class="mx-auto">
                    <div class="flex items-center justify-start gap-x-1">
                        <svg class="w-10 h-9 hidden lg:flex">
                            <use href="#pro1"></use>
                        </svg>
                        <p class="text-[10px] lg:text-base">ارسال سریع</p>
                    </div>
                </div>

            </div>


        </div>

    </div>


    <?php
    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action('woocommerce_after_single_product_summary');
    ?>
    <!--    --><?php // wc_get_template_part('single-product-reviews');  
                ?>
</div>

<?php get_template_part('partials/product-single/comments/get_comments', 'ideal') ?>

<?php do_action('woocommerce_after_single_product'); ?>
<?php //echo get_footer() 
?>