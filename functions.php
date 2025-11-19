<?php

require_once get_template_directory() . '/bootstrap.php';
require_once get_template_directory() . '/app/Support/Autoloader.php';

$autoloader = new \IdealBoresh\Support\Autoloader();
$autoloader->register();

$kernel = new \IdealBoresh\App\Kernel();
$kernel->boot();

if (!function_exists('DiscountCalculation')) {
    function DiscountCalculation($RegularPrice, $SalePrice): int
    {
        return \IdealBoresh\Domain\Product\DiscountCalculator::calculate((float) $RegularPrice, (float) $SalePrice);
    }
}
