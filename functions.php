<?php

use IdealBoresh\App\Kernel;
use IdealBoresh\Core\Bootstrap;
use IdealBoresh\Core\ContainerResolver;

require_once get_template_directory() . '/bootstrap.php';
require_once get_template_directory() . '/app/Support/Autoloader.php';

if (!defined('IDEALBORESH_AUTOLOADER_REGISTERED')) {
    $autoloader = new \IdealBoresh\Support\Autoloader(get_template_directory());
    $autoloader->register();
    define('IDEALBORESH_AUTOLOADER_REGISTERED', true);
}

$bootstrap = new Bootstrap();
$container = $bootstrap->boot();

ContainerResolver::boot($container);

$kernel = new Kernel($container);
$kernel->boot();

if (!function_exists('DiscountCalculation')) {
    function DiscountCalculation($RegularPrice, $SalePrice): int
    {
        return \IdealBoresh\Domain\Product\DiscountCalculator::calculate((float) $RegularPrice, (float) $SalePrice);
    }
}
