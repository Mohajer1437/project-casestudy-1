<?php
/**
 * Template for displaying product content within loops.
 *
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined('ABSPATH') || exit;

use IdealBoresh\Core\ContainerResolver;
use IdealBoresh\Services\WooCommerce\ProductCardPresenterInterface;
use Throwable;

global $product;

if (!is_a($product, WC_Product::class) || !$product->is_visible()) {
    return;
}

$context = [];
$container = ContainerResolver::getInstance();

if ($container) {
    try {
        /** @var ProductCardPresenterInterface $presenter */
        $presenter = $container->get(ProductCardPresenterInterface::class);
        $context = $presenter->buildContext($product);
    } catch (Throwable $e) {
        $context = [];
    }
}

$productId = (int) ($context['id'] ?? $product->get_id());
$brand = $context['brand'] ?? [];
$pricing = $context['pricing'] ?? [];
$button = $context['button'] ?? [];
$permalink = $context['permalink'] ?? get_permalink($productId);
$title = $context['title'] ?? get_the_title($productId);
$image = $context['thumbnail'] ?? get_the_post_thumbnail_url($productId, 'large');
$inventory = (bool) ($context['inventory'] ?? $product->is_in_stock());
$currencyLabel = $pricing['currency'] ?? __('تومان', 'idealboresh');
?>
<div <?php wc_product_class('flex flex-col justify-between  bg-white py-2 lg:py-3 space-y-2 lg:space-y-4 px-2 lg:px-3 rounded-xl  h-[300px] lg:h-[450px] product__content', $product); ?> id="<?php echo esc_attr((string) $productId); ?>">
    <div class="flex flex-col justify-between  bg-white py-2 lg:py-3 space-y-2 lg:space-y-4 px-2 lg:px-3 rounded-xl  h-[300px] lg:h-[450px]">
        <?php if (!empty($brand['name'])) : ?>
            <div class="absolute px-2 py-1 lg:px-3 lg:py-2 bg-nili-200 text-mainBlue text-[12px] lg:text-base w-fit font-sansBold rounded-lg self-end">
                <?php if (!empty($brand['url'])) : ?>
                    <a href="<?php echo esc_url($brand['url']); ?>"><?php echo esc_html($brand['name']); ?></a>
                <?php else : ?>
                    <?php echo esc_html($brand['name']); ?>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="absolute px-2 py-1 lg:px-3 lg:py-2 w-fit"></div>
        <?php endif; ?>

        <a href="<?php echo esc_url($permalink); ?>">
            <img class="max-w-[120px] lg:max-w-[220px]  lg:h-auto lg:max-h-full mx-auto rounded-lg" src="<?php echo esc_url($image ?: wc_placeholder_img_src('woocommerce_single')); ?>" alt="<?php echo esc_attr($title); ?>">
        </a>
        <div class="space-y-2 lg:space-y-4">
            <a href="<?php echo esc_url($permalink); ?>">
                <div class="font-sansRegular text-zinc-600">
                    <p style="height: 70px;" class="lg:text-base text-[13px]">
                        <?php echo esc_html($title); ?>
                    </p>
                </div>
            </a>
            <div class="flex items-center justify-between px-1 lg:px-2 bg-zinc-100  h-[56px] lg:h-[64px] rounded-xl">
                <?php if ($inventory && ($button['type'] ?? '') === 'ajax') : ?>
                    <a href="#" data-product_id="<?php echo esc_attr((string) ($button['product_id'] ?? $productId)); ?>" data-quantity="1" class="bg-nili-100 w-fit p-2 lg:p-3 rounded-xl idealboresh-add-to-cart" aria-label="<?php echo esc_attr(sprintf(__('Add "%s" to your cart', 'woocommerce'), $title)); ?>">
                        <svg class="w-4 h-4 lg:w-6 lg:h-6">
                            <use href="#bag"></use>
                        </svg>
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url($permalink); ?>" class="bg-nili-100 w-fit p-2 lg:p-3 rounded-xl" aria-label="<?php echo esc_attr__('View product details', 'woocommerce'); ?>">
                        <svg class="w-4 h-4 lg:w-6 lg:h-6">
                            <use href="#bag"></use>
                        </svg>
                    </a>
                <?php endif; ?>
                <div>
                    <?php if (($pricing['type'] ?? '') === 'length') : ?>
                        <div class="flex gap-x-1 items-center font-sansFanumBold">
                            <p class="text-black text-[14px] lg:text-base">
                                <?php echo esc_html(number_format((float) ($pricing['min_price'] ?? 0))); ?>
                            </p>
                            <p class="text-mainBlue text-[10px]">
                                <?php echo esc_html($currencyLabel); ?>
                            </p>
                        </div>
                    <?php else : ?>
                        <?php if (!empty($pricing['on_sale'])) : ?>
                            <div class="flex items-center justify-between font-sansFanumBold">
                                <del class="text-zinc-600 text-[13px] lg:text-[14px]">
                                    <?php echo esc_html(number_format((float) ($pricing['regular_display_price'] ?? 0))); ?>
                                </del>
                                <p class="text-white bg-red-600 px-1 py-[2px] rounded-md text-[12px] lg:text-[14px]">
                                    <?php echo esc_html((string) ($pricing['discount_percent'] ?? 0)) . '%'; ?>
                                </p>
                            </div>
                            <div class="flex gap-x-1 items-center font-sansFanumBold">
                                <p class="text-black text-[14px] lg:text-base">
                                    <?php echo esc_html(number_format((float) ($pricing['sale_display_price'] ?? 0))); ?>
                                </p>
                                <p class="text-mainBlue text-[10px]">
                                    <?php echo esc_html($currencyLabel); ?>
                                </p>
                            </div>
                        <?php else : ?>
                            <div class="flex gap-x-1 items-center font-sansFanumBold">
                                <p class="text-black text-[14px] lg:text-base">
                                    <?php echo esc_html(number_format((float) ($pricing['regular_display_price'] ?? 0))); ?>
                                </p>
                                <p class="text-mainBlue text-[10px]">
                                    <?php echo esc_html($currencyLabel); ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
