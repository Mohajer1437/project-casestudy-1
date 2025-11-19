<?php

namespace IdealBoresh\Services\WooCommerce;

class ProductArchiveService implements ProductArchiveInterface
{
    private int $productsPerPage;

    /** @var array<int, string> */
    private array $saleFlashCache = [];

    public function __construct(int $productsPerPage = 12)
    {
        $this->productsPerPage = max(1, $productsPerPage);
    }

    /**
     * Wire WooCommerce archive customizations.
     */
    public function register(): void
    {
        add_filter('loop_shop_per_page', [$this, 'setProductsPerPage'], 20);
        add_filter('woocommerce_sale_flash', [$this, 'renderSaleFlash'], 10, 3);
        add_action('init', [$this, 'customizeLoopHooks']);
    }

    /**
     * Force WooCommerce to always use the configured number of products per page.
     */
    public function setProductsPerPage(int $products): int
    {
        unset($products);
        return $this->productsPerPage;
    }

    /**
     * Remove redundant loop UI that is replaced by custom presenters.
     */
    public function customizeLoopHooks(): void
    {
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
    }

    /**
     * Render a cached sale flash badge showing the discount percentage.
     */
    public function renderSaleFlash(string $html, $post, \WC_Product $product): string
    {
        unset($post);
        if (!$product->is_on_sale()) {
            return $html;
        }

        $cacheKey = (int) $product->get_id();
        if (isset($this->saleFlashCache[$cacheKey])) {
            return $this->saleFlashCache[$cacheKey];
        }

        $regular = 0.0;
        $sale    = 0.0;

        if ($product->is_type('variable')) {
            $regular = (float) $product->get_variation_regular_price('max');
            $sale    = (float) $product->get_variation_sale_price('min');
        } else {
            $regular = (float) $product->get_regular_price();
            $sale    = (float) $product->get_sale_price();
        }

        if ($regular <= 0 || $sale <= 0) {
            return $html;
        }

        $percentage = (int) round((($regular - $sale) / $regular) * 100);
        $percentage = max(0, $percentage);

        $badge = sprintf(
            '<span style="z-index: 29; top: 20px; right: 10px;" class="absolute bg-[#D0082C] font-sansFanumBold text-white px-3 py-2 rounded-xl">٪%s</span>',
            esc_html((string) $percentage)
        );

        $this->saleFlashCache[$cacheKey] = $badge;

        return $badge;
    }
}
