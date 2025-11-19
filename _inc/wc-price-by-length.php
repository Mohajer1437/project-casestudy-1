<?php
/**
 * WC Length Pricing (Theme-only, Global TPI Repeater)
 * Load from functions.php:
 *   require_once get_stylesheet_directory() . '/inc/wc-length-pricing.php';
 */
if (!defined('ABSPATH'))
    exit;

class WC_Length_Pricing
{
    const OPT_TPI_LIST = 'wc_pbl_tpi_list'; // array: [ ['name'=>'10 TPI','key'=>'10','factor'=>1.10], ... ]
    const META_PRICE_CM = '_price_per_cm';
    const META_MIN_LEN = '_min_length_cm';
    const META_MAX_LEN = '_max_length_cm';

    public function __construct()
    {
        // Admin product fields
        add_action('woocommerce_product_options_pricing', [$this, 'admin_product_fields']);
        add_action('woocommerce_admin_process_product_object', [$this, 'save_admin_product_fields']);

        // Admin submenu: TPI repeater
        add_action('admin_menu', [$this, 'register_tpi_page']);

        // Replace Add to Cart on single product (only for length-priced)
        add_action('wp', [$this, 'override_single_add_to_cart']);

        // Cart pipeline
        add_filter('woocommerce_add_to_cart_validation', [$this, 'validate_add_to_cart'], 10, 2);
        add_filter('woocommerce_add_cart_item_data', [$this, 'store_cart_item_data'], 10, 2);
        add_filter('woocommerce_get_item_data', [$this, 'display_cart_item_data'], 10, 2);
        add_action('woocommerce_checkout_create_order_line_item', [$this, 'store_order_item_meta'], 10, 3);
        add_action('woocommerce_before_calculate_totals', [$this, 'reprice_cart_items'], 50);

        // Price label on single
        add_filter('woocommerce_get_price_html', [$this, 'price_label'], 10, 2);
    }

    /* ---------- Helpers ---------- */
    private static function is_length_product($product)
    {
        if (!$product instanceof WC_Product)
            return false;
        $ppc = get_post_meta($product->get_id(), self::META_PRICE_CM, true);
        return $ppc !== '' && $ppc !== null;
    }
    private static function tpi_list()
    {
        $list = get_option(self::OPT_TPI_LIST, []);
        if (!is_array($list))
            $list = [];
        $clean = [];
        foreach ($list as $row) {
            $name = isset($row['name']) ? trim($row['name']) : '';
            $key = isset($row['key']) ? trim($row['key']) : '';
            $factor = isset($row['factor']) ? (float) $row['factor'] : 0;
            if ($name !== '' && $key !== '' && $factor > 0) {
                $clean[] = ['name' => $name, 'key' => $key, 'factor' => $factor];
            }
        }
        return $clean;
    }
    private static function tpi_map()
    { // key => factor
        $map = [];
        foreach (self::tpi_list() as $r)
            $map[$r['key']] = (float) $r['factor'];
        return $map;
    }

    /* ---------- Admin: product fields ---------- */
    public function admin_product_fields()
    {
        $dollar_enabled = get_option('dollar_enabled', 'false');
        $dollar_price = get_option('dollar_price', '1');

        // اگر دلاری فعال بود، واحد = دلار
        $unit_label = ($dollar_enabled === 'true') ? 'دلار' : 'تومان';
        echo '<div class="options_group">';
        woocommerce_wp_text_input([
            'id' => self::META_PRICE_CM,
            'label' => "قیمت هر سانتیمتر ($unit_label)", // اینجا اصلاح شد
            'type' => 'number',
            'desc_tip' => true,
            'description' => "قیمت نهایی = طول (cm) × قیمت هر cm × ضریب TPI ($unit_label).",
            'custom_attributes' => ['step' => '0.01', 'min' => '0']
        ]);
        woocommerce_wp_text_input([
            'id' => self::META_MIN_LEN,
            'label' => 'حداقل طول (cm)',
            'type' => 'number',
            'custom_attributes' => ['step' => '1', 'min' => '0']
        ]);
        woocommerce_wp_text_input([
            'id' => self::META_MAX_LEN,
            'label' => 'حداکثر طول (cm)',
            'type' => 'number',
            'custom_attributes' => ['step' => '1', 'min' => '0']
        ]);
        echo '</div>';
    }
    public function save_admin_product_fields($product)
    {
        foreach ([self::META_PRICE_CM, self::META_MIN_LEN, self::META_MAX_LEN] as $k) {
            $val = isset($_POST[$k]) ? wc_clean(wp_unslash($_POST[$k])) : '';
            if ($val === '')
                $product->delete_meta_data($k);
            else
                $product->update_meta_data($k, $val);
        }
    }

    /* ---------- Admin: TPI repeater page ---------- */
    public function register_tpi_page()
    {
        add_submenu_page(
            'woocommerce',
            'TPI ها (سراسری)',
            'TPI ها',
            'manage_woocommerce',
            'wc-length-tpi',
            [$this, 'tpi_page_html']
        );
    }
    public function tpi_page_html()
    {
        if (isset($_POST['wc_tpi_nonce']) && wp_verify_nonce($_POST['wc_tpi_nonce'], 'wc_tpi_save')) {
            $rows = isset($_POST['tpi_rows']) ? (array) $_POST['tpi_rows'] : [];
            $clean = [];
            foreach ($rows as $r) {
                $name = isset($r['name']) ? sanitize_text_field($r['name']) : '';
                $key = isset($r['key']) ? sanitize_text_field($r['key']) : '';
                $factor = isset($r['factor']) ? sanitize_text_field($r['factor']) : '';
                if ($name !== '' && $key !== '' && is_numeric($factor)) {
                    $clean[] = ['name' => $name, 'key' => $key, 'factor' => (float) $factor];
                }
            }
            update_option(self::OPT_TPI_LIST, $clean);
            echo '<div class="updated"><p>ذخیره شد.</p></div>';
        }
        $rows = self::tpi_list();
        ?>
        <div class="wrap">
            <h1>تعریف TPI ها</h1>
            <form method="post" id="wc-tpi-form">
                <?php wp_nonce_field('wc_tpi_save', 'wc_tpi_nonce'); ?>
                <table class="widefat striped" id="wc-tpi-table" style="max-width:720px">
                    <thead>
                        <tr>
                            <th style="width:40%">نام TPI (نمایش به مشتری)</th>
                            <th style="width:30%">کلید/مقدار TPI</th>
                            <th style="width:20%">ضریب</th>
                            <th style="width:10%">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rows)): ?>
                            <tr>
                                <td><input type="text" name="tpi_rows[0][name]" class="regular-text"
                                        placeholder="مثلاً 10 دندانه در اینچ" /></td>
                                <td><input type="text" name="tpi_rows[0][key]" class="regular-text"
                                        placeholder="مثلاً 10 یا 6-10" /></td>
                                <td><input type="number" name="tpi_rows[0][factor]" step="0.01" min="0" value="1.00"
                                        class="small-text" /></td>
                                <td><button type="button" class="button wc-tpi-remove">-</button></td>
                            </tr>
                        <?php else:
                            foreach ($rows as $i => $r): ?>
                                <tr>
                                    <td><input type="text" name="tpi_rows[<?php echo esc_attr($i); ?>][name]"
                                            value="<?php echo esc_attr($r['name']); ?>" class="regular-text" /></td>
                                    <td><input type="text" name="tpi_rows[<?php echo esc_attr($i); ?>][key]"
                                            value="<?php echo esc_attr($r['key']); ?>" class="regular-text" /></td>
                                    <td><input type="number" name="tpi_rows[<?php echo esc_attr($i); ?>][factor]" step="0.01" min="0"
                                            value="<?php echo esc_attr($r['factor']); ?>" class="small-text" /></td>
                                    <td><button type="button" class="button wc-tpi-remove">-</button></td>
                                </tr>
                            <?php endforeach; endif; ?>
                    </tbody>
                </table>
                <p style="margin-top:10px">
                    <button type="button" class="button button-secondary" id="wc-tpi-add">+ افزودن</button>
                    <button type="submit" class="button button-primary">ذخیره</button>
                </p>
            </form>
        </div>
        <script>
            (function () {
                const tbody = document.querySelector('#wc-tpi-table tbody');
                document.getElementById('wc-tpi-add')?.addEventListener('click', function () {
                    const idx = tbody.querySelectorAll('tr').length;
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
              <td><input type="text" name="tpi_rows[${idx}][name]" class="regular-text" placeholder="مثلاً 10 دندانه در اینچ" /></td>
              <td><input type="text" name="tpi_rows[${idx}][key]"  class="regular-text" placeholder="مثلاً 10 یا 6-10" /></td>
              <td><input type="number" name="tpi_rows[${idx}][factor]" step="0.01" min="0" value="1.00" class="small-text" /></td>
              <td><button type="button" class="button wc-tpi-remove">-</button></td>
            `;
                    tbody.appendChild(tr);
                });
                tbody.addEventListener('click', function (e) {
                    if (e.target && e.target.classList.contains('wc-tpi-remove')) {
                        const rows = tbody.querySelectorAll('tr');
                        if (rows.length > 1) e.target.closest('tr').remove();
                    }
                });
            })();
        </script>
        <?php
    }

    /* ---------- Front: replace add-to-cart ---------- */
    public function override_single_add_to_cart()
    {
        if (!is_product())
            return;
        add_action('woocommerce_single_product_summary', function () {
            if (is_admin())
                return;
            global $product;
            if (!self::is_length_product($product))
                return;

            // حذف دکمه پیش‌فرض
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_quantity', 29);

            // UI مطابق وایرفریم (Tailwind کلاس‌ها مثل طرح شما)
            $pid = $product->get_id();
            $ppc = (float) get_post_meta($pid, self::META_PRICE_CM, true);
            $min = (float) get_post_meta($pid, self::META_MIN_LEN, true);
            $max = (float) get_post_meta($pid, self::META_MAX_LEN, true);
            $len_default = $min ? $min : 1;
            $tpis = self::tpi_list();
            $map = self::tpi_map();
            ?>
            <form class="cart w-full"
                action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', get_permalink($pid))); ?>"
                method="post" enctype="multipart/form-data">
                <div class="flex flex-col gap-2 w-full">

                    <!-- Select TPI -->
                    <label class="sr-only" for="tpi_<?php echo esc_attr($pid); ?>">تقسیم دندانه‌ها در هر اینچ</label>
                    <select style="margin-top:10px;margin-bottom:5px;" id="tpi_<?php echo esc_attr($pid); ?>" name="tpi"
                        class="w-full rounded-md border border-zinc-300 px-3 py-2 bg-white rounded-xl" required>
                        <?php foreach ($tpis as $r): ?>
                            <option value="<?php echo esc_attr($r['key']); ?>">
                                <?php echo esc_html($r['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Length (cm) -->
                    <input style="margin-top:10px;margin-bottom:5px;" type="number" id="length_cm_<?php echo esc_attr($pid); ?>"
                        name="length_cm" value="<?php echo esc_attr($len_default); ?>" step="1" <?php echo $min ? 'min="' . esc_attr($min) . '"' : ''; ?>             <?php echo $max ? 'max="' . esc_attr($max) . '"' : ''; ?>
                        placeholder="طول تیغ اره (سانتی‌متر)"
                        class="w-full rounded-md border border-zinc-300 px-3 py-2 bg-white rounded-xl" required>

                    <!-- Live total -->
                    <input type="hidden" id="price_per_cm_<?php echo esc_attr($pid); ?>" value="<?php echo esc_attr($ppc); ?>">
                    <div id="wc-pbl-total_<?php echo esc_attr($pid); ?>" class="text-right font-semibold py-3"></div>

                    <!-- Add to cart -->
                    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($pid); ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                        class="single_add_to_cart_button button alt bg-sky-900 w-full text-white py-3 rounded-xl font-sansRegular">
                        افزودن به سبد خرید
                    </button>
                    <button style="margin:10px 0;" class="w-full border border-red-600 rounded-xl font-sansRegular">

                        <a href="tel:09123456788"
                            class="flex items-center justify-center gap-x-2 rounded-xl bg-white py-3 w-full text-black mx-auto">
                            <svg class="w-4 h-4">
                                <use href="#callblack"></use>
                            </svg>
                            <p>مشاوره و استعلام قیمت</p>
                        </a>

                    </button>
                </div>
            </form>

            <script>
                (function () {
                    var pid = "<?php echo esc_js($pid); ?>";
                    var lenEl = document.getElementById('length_cm_' + pid);
                    var unit = parseFloat(document.getElementById('price_per_cm_' + pid).value || '0') || 0;
                    var tpiEl = document.getElementById('tpi_' + pid);
                    var outEl = document.getElementById('wc-pbl-total_' + pid);
                    var MAP = <?php echo wp_json_encode($map); ?>;
                    var dollarEnabled = <?php echo json_encode(get_option('dollar_enabled', 'false')); ?>;
                    var dollarRate = <?php echo json_encode((float) get_option('dollar_price', '1')); ?>;

                    function nf(n) { try { return new Intl.NumberFormat('fa-IR').format(n); } catch (e) { return n; } }
                    function calc() {
                        var len = parseFloat(lenEl.value || '0') || 0;
                        var key = String(tpiEl.value || '');
                        var fac = (key && MAP.hasOwnProperty(key)) ? parseFloat(MAP[key]) || 1 : 1;
                        var total = len * unit * fac;

                        if (dollarEnabled === 'true') {
                            total = total * parseFloat(dollarRate || 1);
                        }

                        outEl.textContent = total > 0 ? ('قیمت نهایی: ' + nf(Math.round(total)) + ' تومان') : '';

                        var pe = document.querySelector('.summary .price, .product .summary p.price');
                        if (pe && total > 0) {
                            pe.setAttribute('data-original', pe.getAttribute('data-original') || pe.innerHTML);
                            pe.innerHTML = nf(Math.round(total)) + ' تومان';
                        }
                        else if (pe && total <= 0 && pe.getAttribute('data-original')) {
                            pe.innerHTML = pe.getAttribute('data-original');
                        }
                    }

                    lenEl.addEventListener('input', calc);
                    tpiEl.addEventListener('change', calc);
                    calc();
                })();
            </script>
            <?php
        }, 30);
    }

    /* ---------- Cart / Order ---------- */
    public function validate_add_to_cart($passed, $product_id)
    {
        $ppc = get_post_meta($product_id, self::META_PRICE_CM, true);
        if ($ppc === '')
            return $passed;

        $len = isset($_POST['length_cm']) ? (float) wc_clean(wp_unslash($_POST['length_cm'])) : 0;
        $min = (float) get_post_meta($product_id, self::META_MIN_LEN, true);
        $max = (float) get_post_meta($product_id, self::META_MAX_LEN, true);
        if ($len <= 0) {
            wc_add_notice('طول معتبر وارد کنید.', 'error');
            return false;
        }
        if ($min && $len < $min) {
            wc_add_notice('طول کمتر از حداقل مجاز است.', 'error');
            return false;
        }
        if ($max && $len > $max) {
            wc_add_notice('طول بیشتر از حداکثر مجاز است.', 'error');
            return false;
        }

        $map = self::tpi_map();
        if (!empty($map)) {
            $tpi = isset($_POST['tpi']) ? (string) wc_clean(wp_unslash($_POST['tpi'])) : '';
            if ($tpi === '' || !isset($map[$tpi])) {
                wc_add_notice('لطفاً TPI معتبر انتخاب کنید.', 'error');
                return false;
            }
        }
        return $passed;
    }
    public function store_cart_item_data($data, $product_id)
    {
        $ppc = get_post_meta($product_id, self::META_PRICE_CM, true);
        if ($ppc === '')
            return $data;
        $len = isset($_POST['length_cm']) ? (float) wc_clean(wp_unslash($_POST['length_cm'])) : 0;
        if ($len > 0) {
            $data['length_cm'] = $len;
            $data['price_per_cm'] = (float) $ppc;
            if (isset($_POST['tpi']))
                $data['tpi'] = (string) wc_clean(wp_unslash($_POST['tpi']));
            $data['unique_key'] = md5(microtime() . rand()); // prevent merge
        }
        return $data;
    }
    public function display_cart_item_data($item_data, $cart_item)
    {
        if (isset($cart_item['tpi']))
            $item_data[] = ['name' => 'TPI', 'value' => wc_clean($cart_item['tpi'])];
        if (isset($cart_item['length_cm']))
            $item_data[] = ['name' => 'طول (cm)', 'value' => wc_clean($cart_item['length_cm'])];
        return $item_data;
    }
    public function store_order_item_meta($item, $key, $values)
    {
        if (isset($values['tpi']))
            $item->add_meta_data('TPI', $values['tpi'], true);
        if (isset($values['length_cm']))
            $item->add_meta_data('طول (cm)', $values['length_cm'], true);
        if (isset($values['price_per_cm']))
            $item->add_meta_data('قیمت هر سانتی‌متر', $values['price_per_cm'], true);
    }
    public function reprice_cart_items($cart)
    {
        if (is_admin() && !wp_doing_ajax())
            return;
        if (empty($cart) || empty($cart->get_cart()))
            return;

        static $once = false;
        if ($once)
            return;
        $once = true;

        $map = self::tpi_map();
        foreach ($cart->get_cart() as $ci) {
            if (isset($ci['length_cm'], $ci['price_per_cm']) && $ci['length_cm'] > 0) {
                $len = (float) $ci['length_cm'];
                $unit = (float) $ci['price_per_cm'];
                $tpi = isset($ci['tpi']) ? (string) $ci['tpi'] : '';
                $fac = ($tpi !== '' && isset($map[$tpi])) ? (float) $map[$tpi] : 1.0;
                $price = $unit * $len * $fac;

                // اگر دلار فعال است
                if (get_option('dollar_enabled', 'false') === 'true') {
                    $rate = (float) get_option('dollar_price', '1');
                    $price = $price * $rate;
                }
                if ($price > 0 && isset($ci['data']) && is_object($ci['data'])) {
                    if ((float) $ci['data']->get_price() !== (float) $price)
                        $ci['data']->set_price($price);
                }
            }
        }
    }

    /* ---------- Price label ---------- */
    public function price_label($html, $product)
    {
        if (self::is_length_product($product)) {
            $ppc = (float) get_post_meta($product->get_id(), self::META_PRICE_CM, true);
            $formatted = function_exists('wc_price') ? strip_tags(wc_price($ppc)) : number_format_i18n($ppc);
            return '<small>قیمت هر سانتیمتر: ' . $formatted . ' تومان</small>';
        }
        return $html;
    }
}

new WC_Length_Pricing();
