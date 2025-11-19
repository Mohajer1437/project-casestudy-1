<?php

namespace IdealBoresh\Services\WooCommerce;

use WC_Product;

interface ProductCardPresenterInterface
{
    /**
     * @return array<string, mixed>
     */
    public function buildContext(WC_Product $product): array;
}
