<?php

namespace IdealBoresh\App;

use IdealBoresh\Application\Cart\AddProductToCartAction;
use IdealBoresh\Application\Cart\CartNonceProvider;
use IdealBoresh\Application\Cron\YoastScheduleRegistrar;
use IdealBoresh\Application\Performance\HttpRequestOptimizer;
use IdealBoresh\Application\Performance\WooCommerceTelemetryDisabler;
use IdealBoresh\Application\Product\DisableRelatedProducts;
use IdealBoresh\Contracts\RegistersHooks;
use IdealBoresh\Core\Container;
use IdealBoresh\Domain\Cart\CartRepositoryInterface;
use IdealBoresh\Domain\Cart\CartService;
use IdealBoresh\Domain\Settings\OptionRepositoryInterface;
use IdealBoresh\Domain\WooCommerce\SettingsRepositoryInterface;
use IdealBoresh\Infrastructure\WooCommerce\CartRepository;
use IdealBoresh\Infrastructure\WooCommerce\SettingsRepository;
use IdealBoresh\Infrastructure\WordPress\OptionRepository;
use IdealBoresh\Services\WooCommerce\ProductArchiveInterface;
use IdealBoresh\Services\WooCommerce\ProductArchiveService;
use IdealBoresh\Services\WooCommerce\ProductAttributeFilterInterface;
use IdealBoresh\Services\WooCommerce\ProductAttributeFilterService;
use IdealBoresh\Services\WooCommerce\ProductCardPresenterInterface;
use IdealBoresh\Services\WooCommerce\ProductCardPresenterService;
use IdealBoresh\Services\WooCommerce\ProductCategoryMetaInterface;
use IdealBoresh\Services\WooCommerce\ProductCategoryMetaService;

class Kernel
{
    /** @var RegistersHooks[] */
    private array $modules;

    private Container $container;

    public function __construct(?Container $container = null)
    {
        $this->container = $container ?? new Container();
        $this->registerBindings();
        $this->modules = $this->buildModules();
    }

    public function boot(): void
    {
        foreach ($this->modules as $module) {
            $module->register();
        }
    }

    private function registerBindings(): void
    {
        $this->container->set(CartRepositoryInterface::class, fn (): CartRepositoryInterface => new CartRepository());
        $this->container->set(CartService::class, fn (Container $container): CartService => new CartService(
            $container->get(CartRepositoryInterface::class)
        ));
        $this->container->set(AddProductToCartAction::class, fn (Container $container): AddProductToCartAction => new AddProductToCartAction(
            $container->get(CartService::class)
        ));
        $this->container->set(CartNonceProvider::class, fn (): CartNonceProvider => new CartNonceProvider(
            AddProductToCartAction::NONCE_ACTION
        ));

        $this->container->set(SettingsRepositoryInterface::class, fn (): SettingsRepositoryInterface => new SettingsRepository());
        $this->container->set(OptionRepositoryInterface::class, fn (): OptionRepositoryInterface => new OptionRepository());

        $this->container->set(ProductArchiveInterface::class, fn (): ProductArchiveInterface => new ProductArchiveService());
        $this->container->set(ProductAttributeFilterInterface::class, fn (): ProductAttributeFilterInterface => new ProductAttributeFilterService());
        $this->container->set(ProductCategoryMetaInterface::class, fn (): ProductCategoryMetaInterface => new ProductCategoryMetaService());

        $this->container->set(ProductCardPresenterInterface::class, fn (Container $container): ProductCardPresenterInterface => new ProductCardPresenterService(
            $container->get(OptionRepositoryInterface::class)
        ));

        $this->container->set(WooCommerceTelemetryDisabler::class, fn (Container $container): WooCommerceTelemetryDisabler => new WooCommerceTelemetryDisabler(
            $container->get(SettingsRepositoryInterface::class)
        ));
    }

    /**
     * @return RegistersHooks[]
     */
    private function buildModules(): array
    {
        return [
            $this->container->get(AddProductToCartAction::class),
            $this->container->get(CartNonceProvider::class),
            $this->container->get(DisableRelatedProducts::class),
            $this->container->get(YoastScheduleRegistrar::class),
            $this->container->get(HttpRequestOptimizer::class),
            $this->container->get(WooCommerceTelemetryDisabler::class),
            $this->container->get(ProductArchiveInterface::class),
            $this->container->get(ProductAttributeFilterInterface::class),
            $this->container->get(ProductCategoryMetaInterface::class),
        ];
    }
}
