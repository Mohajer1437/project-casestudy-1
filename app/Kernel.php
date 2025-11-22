<?php

namespace IdealBoresh\App;

use IdealBoresh\Application\Cart\AddProductToCartAction;
use IdealBoresh\Application\Cart\CartNonceProvider;
use IdealBoresh\Application\Contact\ContactFormController;
use IdealBoresh\Application\Cron\YoastScheduleRegistrar;
use IdealBoresh\Application\Performance\HttpRequestOptimizer;
use IdealBoresh\Application\Performance\WooCommerceTelemetryDisabler;
use IdealBoresh\Application\Product\DisableRelatedProducts;
use IdealBoresh\Application\Theme\TemplateContextProvider;
use IdealBoresh\Application\Theme\ThemeSetup;
use IdealBoresh\Contracts\RegistersHooks;
use IdealBoresh\Core\Container;
use IdealBoresh\Services\Theme\AssetManagerInterface;
use IdealBoresh\Services\WooCommerce\ProductArchiveInterface;
use IdealBoresh\Services\WooCommerce\ProductAttributeFilterInterface;
use IdealBoresh\Services\WooCommerce\ProductCategoryMetaInterface;

class Kernel
{
    /**
     * @param Container $container
     */
    public function __construct(private Container $container)
    {
    }

    public function boot(): void
    {
        foreach ($this->buildModules() as $module) {
            $module->register();
        }
    }

    /**
     * @return RegistersHooks[]
     */
    private function buildModules(): array
    {
        $modules = [
            $this->container->get(AddProductToCartAction::class),
            $this->container->get(CartNonceProvider::class),
            new DisableRelatedProducts(),
            new YoastScheduleRegistrar(),
            new HttpRequestOptimizer(),
            $this->container->get(WooCommerceTelemetryDisabler::class),
            $this->container->get(ThemeSetup::class),
            $this->container->get(ContactFormController::class),
            $this->container->get(TemplateContextProvider::class),
            $this->container->get(AssetManagerInterface::class),
            $this->container->get(ProductArchiveInterface::class),
            $this->container->get(ProductCategoryMetaInterface::class),
            $this->container->get(ProductAttributeFilterInterface::class),
        ];

        return array_values(array_filter($modules, static function ($module): bool {
            return $module instanceof RegistersHooks;
        }));
    }
}
