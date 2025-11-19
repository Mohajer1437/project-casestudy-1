<?php

namespace IdealBoresh\Services\WooCommerce;

use IdealBoresh\Domain\Product\DiscountCalculator;
use IdealBoresh\Domain\Settings\OptionRepositoryInterface;
use WC_Product;

class ProductCardPresenterService implements ProductCardPresenterInterface
{
    private const CACHE_GROUP = 'idealboresh_product_brand';

    public function __construct(private OptionRepositoryInterface $options)
    {
    }

    public function buildContext(WC_Product $product): array
    {
        $productId = $product->get_id();

        return [
            'id'          => $productId,
            'permalink'   => get_permalink($productId),
            'title'       => get_the_title($productId),
            'thumbnail'   => get_the_post_thumbnail_url($productId, 'large') ?: wc_placeholder_img_src('woocommerce_single'),
            'brand'       => $this->getBrandData($productId),
            'inventory'   => $product->is_in_stock(),
            'button'      => $this->buildButtonContext($product),
            'pricing'     => $this->buildPricingContext($product),
        ];
    }

    /**
     * @return array{type:string, url?:string, product_id?:int}
     */
    private function buildButtonContext(WC_Product $product): array
    {
        if (!$product->is_in_stock()) {
            return [
                'type' => 'link',
                'url'  => get_permalink($product->get_id()),
            ];
        }

        if ($product->is_type('simple')) {
            return [
                'type'       => 'ajax',
                'product_id' => $product->get_id(),
            ];
        }

        return [
            'type' => 'link',
            'url'  => get_permalink($product->get_id()),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function buildPricingContext(WC_Product $product): array
    {
        $dollarMultiplier = $this->getDollarMultiplier();
        $lengthPricing = $this->resolveLengthPricing($product->get_id(), $dollarMultiplier);
        if ($lengthPricing !== null) {
            return $lengthPricing;
        }

        $pricing = [
            'type'              => 'standard',
            'currency'          => __('تومان', 'idealboresh'),
            'dollar_multiplier' => $dollarMultiplier,
            'on_sale'           => $product->is_on_sale(),
            'discount_percent'  => null,
            'regular_price'     => 0.0,
            'sale_price'        => 0.0,
            'regular_display_price' => 0.0,
            'sale_display_price'    => 0.0,
        ];

        if ($product->is_type('variable')) {
            $pricing['regular_price'] = (float) $product->get_variation_regular_price('max');
            $pricing['sale_price']    = (float) $product->get_variation_sale_price('min');
        } else {
            $pricing['regular_price'] = (float) $product->get_regular_price();
            $pricing['sale_price']    = (float) $product->get_sale_price();
        }

        if (!$pricing['on_sale']) {
            $pricing['sale_price'] = $pricing['regular_price'];
        } else {
            $pricing['discount_percent'] = DiscountCalculator::calculate(
                $pricing['regular_price'],
                $pricing['sale_price']
            );
        }

        $pricing['regular_display_price'] = $pricing['regular_price'] * $dollarMultiplier;
        $pricing['sale_display_price']    = $pricing['sale_price'] * $dollarMultiplier;

        return $pricing;
    }

    /**
     * @return array{name?:string, url?:string}
     */
    private function getBrandData(int $productId): array
    {
        $cacheKey = (string) $productId;
        $cached = wp_cache_get($cacheKey, self::CACHE_GROUP);
        if (is_array($cached)) {
            return $cached;
        }

        $terms = get_the_terms($productId, 'product_brand');
        $brand = [];

        if (!is_wp_error($terms) && !empty($terms)) {
            $term = reset($terms);
            if ($term) {
                $url = get_term_link($term);
                $brand = [
                    'name' => $term->name,
                ];
                if (!is_wp_error($url)) {
                    $brand['url'] = $url;
                }
            }
        }

        wp_cache_set($cacheKey, $brand, self::CACHE_GROUP, HOUR_IN_SECONDS);

        return $brand;
    }

    private function getDollarMultiplier(): float
    {
        $enabled = (string) $this->options->get('dollar_enabled', 'false');
        $price = (float) $this->options->get('dollar_price', 1);

        if ($enabled === 'true' && $price > 0) {
            return $price;
        }

        return 1.0;
    }

    private function resolveLengthPricing(int $productId, float $dollarMultiplier): ?array
    {
        $pricePerCm = (float) get_post_meta($productId, '_price_per_cm', true);
        if ($pricePerCm <= 0) {
            return null;
        }

        $minLength = (float) get_post_meta($productId, '_min_length_cm', true);
        $minLength = $minLength > 0 ? $minLength : 1.0;

        $tpiList = $this->options->get('wc_pbl_tpi_list', []);
        $minFactor = 1.0;
        if (is_array($tpiList) && !empty($tpiList)) {
            $factors = array_map(static function ($item): float {
                if (is_array($item) && isset($item['factor'])) {
                    return (float) $item['factor'];
                }

                return 1.0;
            }, $tpiList);
            $positiveFactors = array_filter($factors, static fn (float $factor): bool => $factor > 0);
            if (!empty($positiveFactors)) {
                $minFactor = (float) min($positiveFactors);
            }
        }

        $minPrice = $minLength * $pricePerCm * $minFactor * $dollarMultiplier;

        return [
            'type'       => 'length',
            'min_price'  => $minPrice,
            'currency'   => __('تومان', 'idealboresh'),
        ];
    }
}
