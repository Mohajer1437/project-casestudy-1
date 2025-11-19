<?php

$dollar_enabled = get_option('dollar_enabled', false); // مقدار پیش‌فرض false

if ($dollar_enabled === 'true') {
    function custom_variation_loaded_alert()
    {
?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(document).on('woocommerce_variations_loaded', function() {
                    var labels = document.querySelectorAll(".form-row.form-row-first > label");

                    labels.forEach((label) => {
                        // بررسی اینکه لیبل مربوط به اینپوت با کلاس wc_input_price باشد
                        var input = label.closest('.form-row').querySelector('input.wc_input_price');
                        if (input) {
                            label.innerHTML = 'قیمت فروش عادی (دلار)';
                        }
                    });


                    var labels2 = document.querySelectorAll(".form-row.form-row-last > label");

                    labels2.forEach((label) => {
                        // بررسی اینکه لیبل مربوط به اینپوت با آیدی که با #variable_sale_price شروع می‌شود باشد
                        var input = label.closest('.form-row').querySelector('input[id^="variable_sale_price"]');
                        if (input) {
                            label.innerHTML = 'قیمت فروش ویژه (دلار)';
                        }
                    });

                });
            });
        </script>
        <?php
    }
    add_action('admin_footer', 'custom_variation_loaded_alert');



    function custom_product_price_loaded_alert()
    {
        // بررسی اینکه در حال ویرایش یک محصول هستیم
        global $pagenow;
        if ('post.php' === $pagenow && isset($_GET['post'])) {
            $post_id = $_GET['post'];
            $post = get_post($post_id);
            if ($post && 'product' === $post->post_type) {
        ?>
                <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        $("p.form-field._regular_price_field > label").html('قیمت فروش عادی (دلار)');
                        $("p.form-field._sale_price_field > label").html('قیمت فروش ویژه (دلار)');
                    });
                </script>
        <?php
            }
        }
    }
    add_action('admin_footer', 'custom_product_price_loaded_alert');




    function custom_products_list_loading_alert()
    {
        ?>
        <script type="text/javascript">
            var labels3 = document.querySelectorAll("td.price.column-price > span > span")

            labels3.forEach((label) => {
                label.innerHTML = "دلار"
            });

            var labels4 = document.querySelectorAll("td.price.column-price > del > span > span")

            labels4.forEach((label) => {
                label.innerHTML = 'دلار';
            });

            var labels5 = document.querySelectorAll("td.price.column-price > ins > span > span")

            labels5.forEach((label) => {
                label.innerHTML = 'دلار';
            });
        </script>
<?php
    }
    add_action('admin_footer', 'custom_products_list_loading_alert');


    // تغییر قیمت در صفحه محصول
    function modify_product_price_display($price, $product)
    {
        // خواندن مقدار dollar_price از تنظیمات وردپرس
        $dollar_price = get_option('dollar_price', '1'); // مقدار پیش‌فرض 1

        // اطمینان از اینکه مقدار dollar_price عددی باشد
        if (is_numeric($dollar_price)) {
            // ضرب قیمت محصول در dollar_price
            $modified_price = floatval($product->get_price()) * floatval($dollar_price);
            // فرمت کردن قیمت جدید
            $price = wc_price($modified_price);
        }

        return $price;
    }

    // اضافه کردن فیلتر برای صفحه محصول
    add_filter('woocommerce_get_price_html', 'modify_product_price_display', 10, 2);

    // تغییر قیمت در کارت خرید
    function modify_product_price_display_in_cart($price, $cart_item, $cart_item_key)
    {
        // خواندن مقدار dollar_price از تنظیمات وردپرس
        $dollar_price = get_option('dollar_price', '1'); // مقدار پیش‌فرض 1

        // اطمینان از اینکه مقدار dollar_price عددی باشد
        if (is_numeric($dollar_price)) {
            // ضرب قیمت محصول در dollar_price
            $modified_price = floatval($cart_item['data']->get_price()) * floatval($dollar_price);
            // فرمت کردن قیمت جدید
            $price = wc_price($modified_price);
        }

        return $price;
    }

    // اضافه کردن فیلتر برای کارت خرید
    add_filter('woocommerce_cart_item_price', 'modify_product_price_display_in_cart', 10, 3);

    // تغییر قیمت در صفحه سبد خرید (cart) و صفحه تسویه حساب (checkout)
    function modify_cart_and_checkout_price($cart)
    {
        // خواندن مقدار dollar_price از تنظیمات وردپرس
        $dollar_price = get_option('dollar_price', '1'); // مقدار پیش‌فرض 1

        // اطمینان از اینکه مقدار dollar_price عددی باشد
        if (is_numeric($dollar_price)) {
            // تغییر قیمت محصولات در سبد خرید
            foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
                $product = $cart_item['data'];
                $price = floatval($product->get_price()) * floatval($dollar_price);
                $product->set_price($price);
            }
        }
    }

    // اضافه کردن فیلتر برای صفحه سبد خرید و صفحه تسویه حساب
    add_action('woocommerce_before_calculate_totals', 'modify_cart_and_checkout_price');
}