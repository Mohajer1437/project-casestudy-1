<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $product;

if (!$product->is_purchasable()) {
    return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()): ?>

    <?php do_action('woocommerce_before_add_to_cart_form'); ?>
    <style>
        input.minus,
        input.plus {
            width: 20px;
            height: 30px;
            background: transparent !important;
            outline: none;
            color: black !important;
            border-radius: 5px;
            border: none;
            font-size: 17px;
        }

        input.input-text.qty.text::-webkit-outer-spin-button,
        input.input-text.qty.text::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }

        /* Firefox */
        input.input-text.qty.text {
            -moz-appearance: textfield !important;
            appearance: textfield !important;
        }

        input.qty {
            width: 33px !important;
            font-size: larger;
            border: none;
            text-align: center;
        }

        .woocommerce .quantity .qty {
            width: 2.631em !important;
        }

        .quantity {
            background: white;
            width: fit-content;
            border-radius: 12px;
            padding: 0.3rem;
            display: flex;
            align-items: center;
            height: 48px;
        }

        form.cart {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
    <form class="cart"
        action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
        method="post" enctype='multipart/form-data'>
        <?php do_action('woocommerce_before_add_to_cart_button'); ?>

        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
            class="single_add_to_cart_button button alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> bg-sky-900 w-full text-white py-3 rounded-xl font-sansRegular"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
        <?php
        woocommerce_quantity_input(array(
            'input_value' => 1, // مقدار پیش‌فرض
            'min_value' => 1, // مقدار حداقل تعداد
            'max_value' => $product->get_max_purchase_quantity(), // مقدار حداکثر تعداد خرید
        ));
        ?>
        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    </form>
    <?php
    $phone_number = get_option('header_phone_number', '');
    if ($phone_number):
        ?>
        <button class="w-full border border-red-600 rounded-xl font-sansRegular">

            <a href="tel:<?php echo $phone_number ?>"
                class="flex items-center justify-center gap-x-2 rounded-xl bg-white py-3 w-full text-black mx-auto">
                <svg class="w-4 h-4">
                    <use href="#callblack"></use>
                </svg>
                <p>مشاوره و استعلام قیمت</p>
            </a>

        </button>

    <?php endif; ?>

    <?php do_action('woocommerce_after_add_to_cart_form'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.quantity').forEach(function (wrapper) {
                var input = wrapper.querySelector('input.qty');
                var plusBtn = wrapper.querySelector('input.plus');
                var minusBtn = wrapper.querySelector('input.minus');

                plusBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();  // جلوی فراخوانی بقیهٔ listenerها رو می‌گیره
                    var max = parseInt(input.getAttribute('max'), 10) || Infinity;
                    var val = parseInt(input.value, 10) || 0;
                    if (val < max) {
                        input.value = val + 1;
                        input.dispatchEvent(new Event('change'));
                    }
                });

                minusBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();  // جلوی فراخوانی بقیهٔ listenerها رو می‌گیره
                    var min = parseInt(input.getAttribute('min'), 10) || 1;
                    var val = parseInt(input.value, 10) || min;
                    if (val > min) {
                        input.value = val - 1;
                        input.dispatchEvent(new Event('change'));
                    }
                });
            });
        });
    </script>


<?php endif; ?>