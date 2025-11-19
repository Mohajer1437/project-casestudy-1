<?php

namespace IdealBoresh\Domain\Cart;

class CartService implements CartServiceInterface
{
    public function __construct(private CartRepositoryInterface $repository)
    {
    }

    public function addProduct(int $productId, int $quantity = 1): bool
    {
        if ($productId <= 0) {
            return false;
        }

        return $this->repository->addProduct($productId, $quantity);
    }
}
