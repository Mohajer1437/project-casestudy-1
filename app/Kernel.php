<?php

namespace IdealBoresh\App;

use IdealBoresh\Application\Cart\AddProductToCartAction;
use IdealBoresh\Application\Cron\YoastScheduleRegistrar;
use IdealBoresh\Application\Performance\HttpRequestOptimizer;
use IdealBoresh\Application\Performance\WooCommerceTelemetryDisabler;
use IdealBoresh\Application\Product\DisableRelatedProducts;
use IdealBoresh\Contracts\RegistersHooks;
use IdealBoresh\Domain\Cart\CartService;
use IdealBoresh\Infrastructure\WooCommerce\CartRepository;
use IdealBoresh\Infrastructure\WooCommerce\SettingsRepository;

class Kernel
{
    /** @var RegistersHooks[] */
    private array $modules;

    public function __construct()
    {
        $this->modules = $this->buildModules();
    }

    public function boot(): void
    {
        foreach ($this->modules as $module) {
            $module->register();
        }
    }

    /**
     * @return RegistersHooks[]
     */
    private function buildModules(): array
    {
        $cartService = new CartService(new CartRepository());
        $settings = new SettingsRepository();

        return [
            new AddProductToCartAction($cartService),
            new DisableRelatedProducts(),
            new YoastScheduleRegistrar(),
            new HttpRequestOptimizer(),
            new WooCommerceTelemetryDisabler($settings),
        ];
    }
}
