<?php

namespace IdealBoresh\Domain\Product;

class DiscountCalculator
{
    public static function calculate(float $regularPrice, float $salePrice): int
    {
        if ($regularPrice <= 0) {
            return 0;
        }

        $discount = ($regularPrice - $salePrice) / $regularPrice * 100;

        return (int) ceil(max(0, $discount));
    }
}
