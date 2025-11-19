<?php

namespace IdealBoresh\Infrastructure\WooCommerce;

use IdealBoresh\Domain\Cart\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function addProduct(int $productId): bool
    {
        if (!function_exists('WC')) {
            return false;
        }

        $cart = WC()->cart;

        if (!$cart) {
            return false;
        }

        return (bool) $cart->add_to_cart($productId);
    }
}
