<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;
?>
<?php get_header(); ?>

<?php
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');
get_template_part('partials/icons/icons', 'ideal');
get_template_part('partials/breadcrumb/breadcrumb', 'singleIdeal');

?>
<style>
    ul.page-numbers {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-top: 30px;
    }

    a.page-numbers {
        padding: 5px 10px;
    }

    span.page-numbers.current {
        padding: 5px 10px;
        border-radius: 3px;
        background: #3c4f87;
        color: white;
    }

    select.orderby {
        border: 1px solid #d1d1d1;
        border-radius: 8px;
        padding: 5px;
    }

    #global-loader {
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
    }

    .loader-content {
        text-align: center;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>
<div class="mt-7 lg:mt-5 flex flex-col items-center bg-white pt-4 lg:bg-inherit	">
    <div id="global-loader"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.7); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <!-- محتوای لودر، مثلاً یک SVG انیمیشنی یا متن -->
            <svg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                <circle cx="25" cy="25" r="20" stroke="#333" stroke-width="4" fill="none"
                    stroke-dasharray="31.415, 31.415" stroke-dashoffset="0">
                    <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s"
                        repeatCount="indefinite" />
                </circle>
            </svg>
            <p style="margin-top: 10px; text-align: center;">در حال بارگذاری...</p>
        </div>
    </div>

    <div class="w-[90%] 2xl:container px-3 lg:px-[70px] mx-auto flex flex-col items-center space-y-4">
        <?php
        // دریافت نام دسته‌بندی
        $category_name = single_term_title('', false);

        // نمایش نام دسته‌بندی در تگ <h1>
        if ($category_name) {
            echo '<h1 class="lg:text-[28px] text-[20px] font-sansBold text-black text-center">' . esc_html($category_name) . '</h1>';
        }
        ?>
        <div class="text-base text-zinc-700 font-sansRegular text-center lg:w-3/4 mt-2">
            <?php
            $term_id = get_queried_object_id();
            $short_description = get_term_meta($term_id, 'category_short_description', true);

            if ($short_description) {
                echo wp_kses_post($short_description);
            }
            if (is_tax()) {
                $brand_short_description = get_term_meta($term_id, 'brand_short_description', true);
                if (!empty($brand_short_description)) {
                    echo wp_kses_post(wpautop($brand_short_description));
                }
            }
            ?>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-5">

        </div>
    </div>


    <?php
    // دریافت دسته بندی جاری
    $current_category = get_queried_object();

    // اگر دسته بندی جاری وجود داشت و فرزند داشت
    if ($current_category && $current_category->term_id) {
        // دریافت زیردسته ها
        $subcategories = get_terms(array(
            'taxonomy' => 'product_cat',
            'parent' => $current_category->term_id,
            'hide_empty' => false,
        ));

        // فیلتر زیردسته هایی که تصویر بند انگشتی دارند
        $filtered_subcats = array();
        foreach ($subcategories as $subcat) {
            $thumbnail_id = get_term_meta($subcat->term_id, 'thumbnail_id', true);
            if ($thumbnail_id) {
                $filtered_subcats[] = $subcat;
            }
        }

        if (!empty($filtered_subcats)) {
            // تقسیم بندی برای دسکتاپ (7 تایی)
            $desktop_chunks = array_chunk($filtered_subcats, 7);
            // تقسیم بندی برای موبایل (2 تایی)
            $mobile_chunks = array_chunk($filtered_subcats, 2);

            // نمایش نسخه دسکتاپ
            foreach ($desktop_chunks as $chunk) {
                echo '<div class="hidden lg:flex gap-x-4 items-center mb-4 m-y-2">';
                foreach ($chunk as $subcat) {
                    $thumbnail_id = get_term_meta($subcat->term_id, 'thumbnail_id', true);
                    $image_url = wp_get_attachment_image_url($thumbnail_id, 'thumbnail');
                    $category_link = get_term_link($subcat);
                    ?>
                    <a href="<?php echo esc_url($category_link); ?>" class="space-y-2 flex-1 min-w-[14.2857%]">
                        <div class="p-4 lg:px-9 lg:py-5 rounded-xl bg-nili-200 flex items-center justify-center">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($subcat->name); ?>"
                                class="max-h-12 min-h-12 lg:max-h-16 lg:min-h-16">
                        </div>
                        <p class="font-sansBold text-black text-center text-xs lg:text-base"><?php echo esc_html($subcat->name); ?></p>
                    </a>
                    <?php
                }
                echo '</div>';
            }

            // نمایش نسخه موبایل
            foreach ($mobile_chunks as $chunk) {
                echo '<div class="flex lg:hidden gap-x-4 items-center mb-4 m-y-2">';
                foreach ($chunk as $subcat) {
                    $thumbnail_id = get_term_meta($subcat->term_id, 'thumbnail_id', true);
                    $image_url = wp_get_attachment_image_url($thumbnail_id, 'thumbnail');
                    $category_link = get_term_link($subcat);
                    ?>
                    <a href="<?php echo esc_url($category_link); ?>" class="space-y-2 flex-1 min-w-[45%]">
                        <div class="p-4 lg:px-9 lg:py-5 rounded-xl bg-nili-200 flex items-center justify-center">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($subcat->name); ?>"
                                class="max-h-12 min-h-12 ">
                        </div>
                        <p class="font-sansBold text-black text-center text-xs"><?php echo esc_html($subcat->name); ?></p>
                    </a>
                    <?php
                }
                echo '</div>';
            }
        }
    }
    ?>
</div>
<div class="container mt-12 grid xl:grid-cols-4 lg:gap-x-6 overflow-x-hidden pb-4">

    <!--        filter products for Desktops-->
    <?php get_template_part('partials/archive-product-ideal/ideal', 'filter_archive_desktop') ?>


    <div class="xl:col-span-3 flex flex-col ">
        <?php get_template_part('partials/archive-product-ideal/ideal', 'filter_archive_mobile') ?>
        <?php
        if (woocommerce_product_loop()) {
            /**
             * Hook: woocommerce_before_shop_loop.
             *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action('woocommerce_before_shop_loop'); ?>
            <div
                class="init_render_posts grid grid-cols-2 lg:grid-cols-3 gap-y-4 lg:gap-y-6 gap-x-[13px] lg:gap-x-10 px-[18px]">
                <?php
                //	woocommerce_product_loop_start();
                if (wc_get_loop_prop('total')) {
                    while (have_posts()) {
                        the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action('woocommerce_shop_loop');

                        wc_get_template_part('content', 'product');
                    }
                }

                //	woocommerce_product_loop_end();
                ?>


            </div>


            <?php
            /**
             * Hook: woocommerce_after_shop_loop.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action('woocommerce_after_shop_loop');
        } else {
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action('woocommerce_no_products_found');
        }

        /**
         * Hook: woocommerce_after_main_content.
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action('woocommerce_after_main_content');

        /**
         * Hook: woocommerce_sidebar.
         *
         * @hooked woocommerce_get_sidebar - 10
         */
        do_action('woocommerce_sidebar');
        ?>
    </div>
</div>


<div class="overlay_section transition-all duration-300"></div>

<div class="2xl:container lg:mt-[49px] py-5 lg:py-12 lg:px-[70px] mx-auto rounded-3xl">

    <?php
    $term = get_queried_object();
    $content = get_term_meta($term->term_id, 'full_description', true);

    if (!empty($content)) {
        echo '<div class="mt-3 font-sansFanumRegular text-zinc-600">' . wpautop(do_shortcode($content)) . '</div>';
    }
    if (is_tax()) {
        $term = get_queried_object();
        if (!empty($term->description)) {
            echo '<div class="mt-3 font-sansFanumRegular text-zinc-600">';
            echo wp_kses_post(wpautop($term->description));
            echo '</div>';
        }
    }
    ?>
</div>

<?php
$about_data = get_option('about-section', ['description' => '', 'cards' => []]);
if (!empty($about_data)):
    ?>
    <div class="mt-9 lg:mt-12 bg-white flex flex-col items-center">

        <div class="w-[90%] 2xl:container px-3 lg:px-[70px] mx-auto py-10 flex flex-col items-center">

            <p class="lg:text-[28px] text-[20px] font-sansBold text-mainBlue text-center">چرا ایده‌آل برش؟!</p>
            <p class="text-base text-zinc-700 font-sansRegular text-center lg:w-2/4 mt-2">
                <?php echo $about_data['description'] ? esc_html($about_data['description']) : ''; ?>
            </p>

            <div class="grid grid-cols-2 lg:grid-cols-5">

            </div>

            <button></button>
        </div>


        <div class="w-[90%] 2xl:container mx-auto">

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-x-6 lg:gap-x-10 gap-y-6 px-3 lg:px-[70px]">
                <?php
                if (!empty($about_data['cards'])):
                    foreach ($about_data['cards'] as $index => $card):
                        ?>
                        <div class="p-3 lg:p-5 flex flex-col items-center justify-between border-2 rounded-xl border-nili-100">

                            <img src="<?php echo esc_url($card['icon']); ?>">

                            <p class="text-base font-sansFanumBold text-black mt-2 lg:mt-5">
                                <?php echo esc_html($card['title']); ?>
                            </p>

                            <p class="font-sansRegular text-zinc-600 text-center mt-2">
                                <?php echo esc_html($card['description']); ?>
                            </p>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>

            </div>

        </div>

    </div>
<?php endif; ?>



<div class="py-7 bg-white mt-9 px-5 lg:mt-10 flex flex-col items-center">

    <div class="flex items-center gap-x-1 font-sansBold">

        <svg class="w-6 h-6">
            <use href="#question"></use>
        </svg>
        <p class="lg:text-xl">سوالات متداول</p>
    </div>


    <?php
    $faqs = get_term_meta($term->term_id, 'product_category_faqs', true);
    if (!empty($faqs)):
        ?>
        <div class="w-full lg:w-2/4 mt-6 lg:mt-8">

            <div class="hidden h-16"></div>
            <div class="space-y-3">
                <?php
                foreach ($faqs as $faq):
                    $faq_schema["mainEntity"][] = [
                        "@type" => "Question",
                        "name" => esc_html($faq['question']),
                        "acceptedAnswer" => [
                            "@type" => "Answer",
                            "text" => esc_html($faq['answer'])
                        ]
                    ];
                    ?>
                    <div
                        class="font-sansFanumRegular bg-zinc-100 p-3 lg:p-4 rounded-xl shadow text-black Accordion__parent cursor-pointer relative">
                        <div class="flex items-center justify-between filter__parent_item">
                            <p class="w-4/5"><?php echo esc_html($faq['question']); ?></p>
                            <div>
                                <svg class="w-9 h-9">
                                    <use href="#group"></use>
                                </svg>
                            </div>
                        </div>

                        <div class="filter-items Accordion__content h-0 overflow-hidden transition-all duration-500">
                            <div class="font-sansFanumRegular text-zinc-600 mt-3 text-center">
                                <p><?php echo esc_html($faq['answer']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php


get_footer('shop');