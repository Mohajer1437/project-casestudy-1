<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array()); ?>


<?php
if (!empty($product_tabs)): ?>
	<div class="gap-x-4 container grid grid-cols-1  lg:grid-cols-5 font-sansFanumRegular mt-6 lg:mt-9 lg:px-0">
		<div class="lg:col-span-4 bg-white rounded-xl px-4 shadow-md">
			<div class="woocommerce-tabs wc-tabs-wrapper mb-3">
				<ul class="tabs wc-tabs flex  overflow-x-auto bg-white shadow-md pt-4 lg:px-9 px-2 rounded-xl gap-x-4 lg:gap-x-10"
					role="tablist">
					<?php foreach ($product_tabs as $key => $product_tab): ?>
						<li class="<?php echo esc_attr($key); ?>_tab " id="tab-title-<?php echo esc_attr($key); ?>" role="tab"
							aria-controls="tab-<?php echo esc_attr($key); ?>">
							<a href="#tab-<?php echo esc_attr($key); ?>">
								<?php echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key)); ?>
							</a>

							<div class="mt-3 ">
								<div class="h-[6px] w-full bg-mainBlue rounded-tl-md rounded-tr-md is__active__tab hidden">
								</div>
							</div>

						</li>
					<?php endforeach; ?>

				</ul>
				<?php foreach ($product_tabs as $key => $product_tab): ?>
					<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab "
						id="tab-<?php echo esc_attr($key); ?>" role="tabpanel"
						aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
						<?php
						if (isset($product_tab['callback'])) {
							call_user_func($product_tab['callback'], $key, $product_tab);
						}
						?>
					</div>
				<?php endforeach; ?>

				<?php do_action('woocommerce_product_after_tabs'); ?>

				<?php
				// دریافت محصول جاری
				global $product;

				if (!$product) {
					return;
				}

				// دریافت محصولات مرتبط (حداکثر 4 محصول)
				$related_products = wc_get_related_products($product->get_id(), 3);

				if (!empty($related_products)): ?>
					<div id="related-products" class="mt-4 col-span-4 bg-[#F2F5FF] px-4 py-5 lg:py-7 rounded-xl shadow-md">
						<div class="mb-5 text-center font-sansFanumBold">محصولات مرتبط</div>
						<?php woocommerce_product_loop_start(); ?>

						<div
							class="grid grid-cols-2 lg:grid-cols-3 gap-y-4 lg:gap-y-6 gap-x-[13px] overflow-x-hidden lg:gap-x-10 mt-8 xl:mt-0">
							<?php foreach ($related_products as $related_product_id): ?>
								<?php
								$post_object = get_post($related_product_id);
								setup_postdata($GLOBALS['post'] = $post_object);

								// نمایش محصول مرتبط با استفاده از قالب ووکامرس
								wc_get_template_part('content', 'product');
								?>
							<?php endforeach; ?>
						</div>

						<?php woocommerce_product_loop_end(); ?>
					</div>
					<?php
					wp_reset_postdata();
				endif;
				?>

			</div>

		</div>
		<div
			class="summary entry-summary lg:sticky top-[5rem] col-span-2 lg:col-span-1 bg-neutral-100 flex flex-col mx-auto w-full p-5 h-fit gap-y-3 lg:gap-y-4 rounded-xl shadow-lg md:w-[286px]">
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
<?php endif; ?>

<script>
	const el = document.querySelector(".tabs.wc-tabs");  // یا سلکتور خودت
	let lastScrollY = window.pageYOffset;

	window.addEventListener("scroll", () => {
		const currentScrollY = window.pageYOffset;

		if (currentScrollY > lastScrollY) {
			// کاربر به پایین اسکرول می‌کنه
			el.style.top = "66px";
		} else {
			// کاربر به بالا اسکرول می‌کنه
			el.style.top = "134px";
		}

		// به‌روزرسانی مقدار آخرین اسکرول
		lastScrollY = currentScrollY;
	}, { passive: true });
</script>