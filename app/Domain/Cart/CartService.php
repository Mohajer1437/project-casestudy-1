<?php

namespace IdealBoresh\Domain\Cart;

class CartService
{
    public function __construct(private CartRepositoryInterface $repository)
    {
    }

    public function addProduct(int $productId): bool
    {
        if ($productId <= 0) {
            return false;
        }

        return $this->repository->addProduct($productId);
    }
}
