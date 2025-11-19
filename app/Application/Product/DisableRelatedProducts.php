<?php

namespace IdealBoresh\Application\Product;

use IdealBoresh\Contracts\RegistersHooks;

class DisableRelatedProducts implements RegistersHooks
{
    public function register(): void
    {
        add_action('woocommerce_after_single_product_summary', [$this, 'removeDefault'], 1);
    }

    public function removeDefault(): void
    {
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    }
}
