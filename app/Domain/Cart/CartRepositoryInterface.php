<?php

namespace IdealBoresh\Domain\Cart;

interface CartRepositoryInterface
{
    public function addProduct(int $productId, int $quantity = 1): bool;
}
