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
use IdealBoresh\Domain\Cart\CartRepositoryInterface;
use IdealBoresh\Domain\Cart\CartService;
use IdealBoresh\Domain\Cart\CartServiceInterface;
use IdealBoresh\Domain\Settings\OptionRepositoryInterface;
use IdealBoresh\Domain\WooCommerce\SettingsRepositoryInterface;
use IdealBoresh\Infrastructure\WooCommerce\CartRepository;
use IdealBoresh\Infrastructure\WooCommerce\SettingsRepository;
use IdealBoresh\Infrastructure\WordPress\OptionRepository;
use IdealBoresh\Services\Theme\AssetManager;
use IdealBoresh\Services\Theme\AssetManagerInterface;
use IdealBoresh\Services\Theme\FooterPresenter;
use IdealBoresh\Services\Theme\FooterPresenterInterface;
use IdealBoresh\Services\Theme\HeaderPresenter;
use IdealBoresh\Services\Theme\HeaderPresenterInterface;
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
    /**
     * Cached module instances keyed by interface.
     *
     * @var RegistersHooks[]
     */
    private array $modules;

    private Container $container;

    public function __construct(?Container $container = null)
    {
        $this->container = $container ?? new Container();
        $this->registerBindings();
        $this->modules = $this->buildModules();
    }

    /**
     * Boot the application modules.
     */
    public function boot(): void
    {
        foreach ($this->modules as $module) {
            $module->register();
        }
    }

    /**
     * Register container bindings for all dependencies.
     */
    private function registerBindings(): void
    {
        $this->container->set(CartRepositoryInterface::class, fn (): CartRepositoryInterface => new CartRepository());
        $this->container->set(CartServiceInterface::class, fn (Container $container): CartServiceInterface => new CartService(
            $container->get(CartRepositoryInterface::class)
        ));
        $this->container->set(AddProductToCartAction::class, fn (Container $container): AddProductToCartAction => new AddProductToCartAction(
            $container->get(CartServiceInterface::class)
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

        $this->container->set(HeaderPresenterInterface::class, fn (Container $container): HeaderPresenterInterface => new HeaderPresenter(
            $container->get(OptionRepositoryInterface::class)
        ));
        $this->container->set(FooterPresenterInterface::class, fn (Container $container): FooterPresenterInterface => new FooterPresenter(
            $container->get(OptionRepositoryInterface::class)
        ));

        $this->container->set(AssetManagerInterface::class, fn (): AssetManagerInterface => new AssetManager());
        $this->container->set(TemplateContextProvider::class, fn (Container $container): TemplateContextProvider => new TemplateContextProvider(
            $container->get(HeaderPresenterInterface::class),
            $container->get(FooterPresenterInterface::class),
            $container->get(ProductCardPresenterInterface::class)
        ));
        $this->container->set(ThemeSetup::class, fn (): ThemeSetup => new ThemeSetup());
        $this->container->set(ContactFormController::class, fn (): ContactFormController => new ContactFormController());

        $this->container->set(WooCommerceTelemetryDisabler::class, fn (Container $container): WooCommerceTelemetryDisabler => new WooCommerceTelemetryDisabler(
            $container->get(SettingsRepositoryInterface::class)
        ));
    }

    /**
     * Instantiate all modules that need to register hooks.
     *
     * @return RegistersHooks[]
     */
    private function buildModules(): array
    {
        return [
            $this->container->get(AssetManagerInterface::class),
            $this->container->get(AddProductToCartAction::class),
            $this->container->get(CartNonceProvider::class),
            $this->container->get(DisableRelatedProducts::class),
            $this->container->get(YoastScheduleRegistrar::class),
            $this->container->get(HttpRequestOptimizer::class),
            $this->container->get(WooCommerceTelemetryDisabler::class),
            $this->container->get(ProductArchiveInterface::class),
            $this->container->get(ProductAttributeFilterInterface::class),
            $this->container->get(ProductCategoryMetaInterface::class),
            $this->container->get(ContactFormController::class),
            $this->container->get(TemplateContextProvider::class),
            $this->container->get(ThemeSetup::class),
        ];
    }
}
