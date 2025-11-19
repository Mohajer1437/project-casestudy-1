<?php

namespace IdealBoresh\Domain\Cart;

interface CartServiceInterface
{
    public function addProduct(int $productId, int $quantity = 1): bool;
}
