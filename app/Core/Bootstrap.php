<?php

namespace IdealBoresh\Core;

use IdealBoresh\Application\Cart\AddProductToCartAction;
use IdealBoresh\Application\Cart\CartNonceProvider;
use IdealBoresh\Application\Performance\WooCommerceTelemetryDisabler;
use IdealBoresh\Application\Theme\TemplateContextProvider;
use IdealBoresh\Domain\Cart\CartRepositoryInterface;
use IdealBoresh\Domain\Cart\CartService;
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

class Bootstrap
{
    private Container $container;

    private bool $booted = false;

    public function __construct(?Container $container = null)
    {
        $this->container = $container ?: new Container();
    }

    public function boot(): Container
    {
        if (!$this->booted) {
            $this->registerBindings();
            $this->booted = true;
        }

        return $this->container;
    }

    private function registerBindings(): void
    {
        $this->container->set(OptionRepositoryInterface::class, OptionRepository::class);
        $this->container->set(CartRepositoryInterface::class, CartRepository::class);
        $this->container->set(CartService::class, function (Container $container): CartService {
            return new CartService($container->get(CartRepositoryInterface::class));
        });

        $this->container->set(SettingsRepositoryInterface::class, SettingsRepository::class);

        $this->container->set(HeaderPresenterInterface::class, function (Container $container): HeaderPresenterInterface {
            return new HeaderPresenter($container->get(OptionRepositoryInterface::class));
        });

        $this->container->set(FooterPresenterInterface::class, function (Container $container): FooterPresenterInterface {
            return new FooterPresenter($container->get(OptionRepositoryInterface::class));
        });

        $this->container->set(ProductCardPresenterInterface::class, function (Container $container): ProductCardPresenterInterface {
            return new ProductCardPresenterService($container->get(OptionRepositoryInterface::class));
        });

        $this->container->set(TemplateContextProvider::class, function (Container $container): TemplateContextProvider {
            return new TemplateContextProvider(
                $container->get(HeaderPresenterInterface::class),
                $container->get(FooterPresenterInterface::class),
                $container->get(ProductCardPresenterInterface::class)
            );
        });

        $this->container->set(AssetManagerInterface::class, fn (): AssetManagerInterface => new AssetManager());

        $productsPerPage = (int) get_option('wc_products_per_page', 12);
        $productsPerPage = $productsPerPage > 0 ? $productsPerPage : 12;
        $this->container->set(ProductArchiveInterface::class, fn (): ProductArchiveInterface => new ProductArchiveService($productsPerPage));
        $this->container->set(ProductCategoryMetaInterface::class, fn (): ProductCategoryMetaInterface => new ProductCategoryMetaService());
        $this->container->set(ProductAttributeFilterInterface::class, fn (): ProductAttributeFilterInterface => new ProductAttributeFilterService());

        $this->container->set(AddProductToCartAction::class, function (Container $container): AddProductToCartAction {
            return new AddProductToCartAction($container->get(CartService::class));
        });

        $this->container->set(CartNonceProvider::class, fn (): CartNonceProvider => new CartNonceProvider('ideal_add_to_cart'));

        $this->container->set(WooCommerceTelemetryDisabler::class, function (Container $container): WooCommerceTelemetryDisabler {
            return new WooCommerceTelemetryDisabler($container->get(SettingsRepositoryInterface::class));
        });
    }
}
