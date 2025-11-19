<?php

namespace IdealBoresh\Core;

use IdealBoresh\Application\Cart\AddProductToCartAction;
use IdealBoresh\Application\Cron\YoastScheduleRegistrar;
use IdealBoresh\Application\Performance\HttpRequestOptimizer;
use IdealBoresh\Application\Performance\WooCommerceTelemetryDisabler;
use IdealBoresh\Application\Product\DisableRelatedProducts;
use IdealBoresh\Contracts\RegistersHooks;
use IdealBoresh\Domain\Cart\CartService;
use IdealBoresh\Domain\Settings\OptionRepositoryInterface;
use IdealBoresh\Infrastructure\WooCommerce\CartRepository;
use IdealBoresh\Infrastructure\WooCommerce\SettingsRepository;
use IdealBoresh\Infrastructure\WordPress\OptionRepository;
use IdealBoresh\Services\Admin\AdminAssetInterface;
use IdealBoresh\Services\Admin\AdminAssetService;
use IdealBoresh\Services\Admin\AdminUiInterface;
use IdealBoresh\Services\Admin\AdminUiService;
use IdealBoresh\Services\Admin\ThemeSettingsPageInterface;
use IdealBoresh\Services\Admin\ThemeSettingsPageService;
use IdealBoresh\Services\Ajax\ContactAjaxController;
use IdealBoresh\Services\Ajax\ContactAjaxInterface;
use IdealBoresh\Services\Ajax\HeaderSearchAjaxController;
use IdealBoresh\Services\Ajax\HeaderSearchAjaxInterface;
use IdealBoresh\Services\Ajax\SettingsAjaxController;
use IdealBoresh\Services\Ajax\SettingsAjaxInterface;
use IdealBoresh\Services\Assets\AssetManagerInterface;
use IdealBoresh\Services\Assets\AssetManagerService;
use IdealBoresh\Services\Comments\CommentRendererInterface;
use IdealBoresh\Services\Comments\CommentRendererService;
use IdealBoresh\Services\Comments\ThreadedCommentsInterface;
use IdealBoresh\Services\Comments\ThreadedCommentsService;
use IdealBoresh\Services\Contact\ContactAssetsInterface;
use IdealBoresh\Services\Contact\ContactAssetsService;
use IdealBoresh\Services\Contact\ContactTableInterface;
use IdealBoresh\Services\Contact\ContactTableService;
use IdealBoresh\Services\Localization\JalaliDateInterface;
use IdealBoresh\Services\Localization\JalaliDateService;
use IdealBoresh\Services\PostType\ServicePostTypeInterface;
use IdealBoresh\Services\PostType\ServicePostTypeRegistrar;
use IdealBoresh\Services\Search\ProductSearchInterface;
use IdealBoresh\Services\Search\ProductSearchService;
use IdealBoresh\Services\Theme\CustomizerInterface;
use IdealBoresh\Services\Theme\CustomizerService;
use IdealBoresh\Services\Theme\PageInstallerInterface;
use IdealBoresh\Services\Theme\PageInstallerService;
use IdealBoresh\Services\Theme\ThemeSupportInterface;
use IdealBoresh\Services\Theme\ThemeSupportService;
use IdealBoresh\Services\WooCommerce\BreadcrumbInterface;
use IdealBoresh\Services\WooCommerce\BreadcrumbService;
use IdealBoresh\Services\WooCommerce\CardPriceAjaxInterface;
use IdealBoresh\Services\WooCommerce\CardPriceAjaxService;
use IdealBoresh\Services\WooCommerce\CatalogMetaInterface;
use IdealBoresh\Services\WooCommerce\CatalogMetaService;
use IdealBoresh\Services\WooCommerce\ProductArchiveInterface;
use IdealBoresh\Services\WooCommerce\ProductArchiveService;
use IdealBoresh\Services\WooCommerce\DollarPricingInterface;
use IdealBoresh\Services\WooCommerce\DollarPricingService;
use IdealBoresh\Services\WooCommerce\LengthPricingInterface;
use IdealBoresh\Services\WooCommerce\LengthPricingService;
use IdealBoresh\Services\WooCommerce\NoticeControlInterface;
use IdealBoresh\Services\WooCommerce\NoticeControlService;
use IdealBoresh\Services\WooCommerce\ProductAttributeFilterInterface;
use IdealBoresh\Services\WooCommerce\ProductAttributeFilterService;
use IdealBoresh\Services\WooCommerce\ProductAttributeInterface;
use IdealBoresh\Services\WooCommerce\ProductAttributeService;
use IdealBoresh\Services\WooCommerce\ProductCategoryMetaInterface;
use IdealBoresh\Services\WooCommerce\ProductCategoryMetaService;
use IdealBoresh\Services\WooCommerce\ProductFilterAjaxInterface;
use IdealBoresh\Services\WooCommerce\ProductFilterAjaxService;
use IdealBoresh\Services\WooCommerce\ProductTabsInterface;
use IdealBoresh\Services\WooCommerce\ProductTabsService;
use IdealBoresh\Services\WooCommerce\WooAssetsInterface;
use IdealBoresh\Services\WooCommerce\WooAssetsService;

class Bootstrap
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
        $this->registerBindings();
    }

    public function boot(): void
    {
        $modules = $this->buildModules();
        (new HookManager($modules))->register();
    }

    private function registerBindings(): void
    {
        $this->container->set(TemplateLoaderInterface::class, function (): TemplateLoaderInterface {
            return new TemplateLoader(get_template_directory());
        });

        $this->container->set(OptionRepositoryInterface::class, OptionRepository::class);
        $this->container->set(CartService::class, function (): CartService {
            return new CartService(new CartRepository());
        });
        $this->container->set(SettingsRepository::class, fn (): SettingsRepository => new SettingsRepository());

        $this->container->set(AssetManagerInterface::class, fn (): AssetManagerInterface => new AssetManagerService());
        $this->container->set(AdminAssetInterface::class, fn (): AdminAssetInterface => new AdminAssetService());
        $this->container->set(AdminUiInterface::class, fn (): AdminUiInterface => new AdminUiService());
        $this->container->set(ThemeSupportInterface::class, fn (): ThemeSupportInterface => new ThemeSupportService());
        $this->container->set(CustomizerInterface::class, fn (): CustomizerInterface => new CustomizerService());
        $this->container->set(PageInstallerInterface::class, fn (): PageInstallerInterface => new PageInstallerService());
        $this->container->set(ProductSearchInterface::class, fn (): ProductSearchInterface => new ProductSearchService());
        $this->container->set(ContactTableInterface::class, fn (): ContactTableInterface => new ContactTableService());
        $this->container->set(ContactAssetsInterface::class, fn (): ContactAssetsInterface => new ContactAssetsService());
        $this->container->set(ThreadedCommentsInterface::class, fn (): ThreadedCommentsInterface => new ThreadedCommentsService());
        $this->container->set(CommentRendererInterface::class, fn (): CommentRendererInterface => new CommentRendererService());
        $this->container->set(WooAssetsInterface::class, fn (): WooAssetsInterface => new WooAssetsService());
        $this->container->set(ProductTabsInterface::class, fn (): ProductTabsInterface => new ProductTabsService());
        $this->container->set(CardPriceAjaxInterface::class, fn (): CardPriceAjaxInterface => new CardPriceAjaxService());
        $this->container->set(CatalogMetaInterface::class, fn (): CatalogMetaInterface => new CatalogMetaService());
        $this->container->set(NoticeControlInterface::class, fn (): NoticeControlInterface => new NoticeControlService());
        $this->container->set(DollarPricingInterface::class, fn (): DollarPricingInterface => new DollarPricingService());
        $this->container->set(LengthPricingInterface::class, fn (): LengthPricingInterface => new LengthPricingService());
        $this->container->set(ProductFilterAjaxInterface::class, fn (): ProductFilterAjaxInterface => new ProductFilterAjaxService());
        $this->container->set(BreadcrumbInterface::class, fn (): BreadcrumbInterface => new BreadcrumbService());
        $this->container->set(ProductAttributeInterface::class, fn (): ProductAttributeInterface => new ProductAttributeService());
        $this->container->set(ProductArchiveInterface::class, fn (): ProductArchiveInterface => new ProductArchiveService());
        $this->container->set(ProductCategoryMetaInterface::class, fn (): ProductCategoryMetaInterface => new ProductCategoryMetaService());
        $this->container->set(ProductAttributeFilterInterface::class, fn (): ProductAttributeFilterInterface => new ProductAttributeFilterService());
        $this->container->set(ServicePostTypeInterface::class, fn (): ServicePostTypeInterface => new ServicePostTypeRegistrar());
        $this->container->set(JalaliDateInterface::class, fn (): JalaliDateInterface => new JalaliDateService());
        $this->container->set(HeaderSearchAjaxInterface::class, fn (): HeaderSearchAjaxInterface => new HeaderSearchAjaxController());
        $this->container->set(ContactAjaxInterface::class, fn (): ContactAjaxInterface => new ContactAjaxController());
        $this->container->set(SettingsAjaxInterface::class, fn (Container $container): SettingsAjaxInterface => new SettingsAjaxController(
            $container->get(OptionRepositoryInterface::class)
        ));
        $this->container->set(ThemeSettingsPageInterface::class, fn (Container $container): ThemeSettingsPageInterface => new ThemeSettingsPageService(
            $container->get(TemplateLoaderInterface::class)
        ));
    }

    /**
     * @return RegistersHooks[]
     */
    private function buildModules(): array
    {
        $cartService = $this->container->get(CartService::class);
        $settingsRepository = $this->container->get(SettingsRepository::class);

        return [
            new AddProductToCartAction($cartService),
            new DisableRelatedProducts(),
            new YoastScheduleRegistrar(),
            new HttpRequestOptimizer(),
            new WooCommerceTelemetryDisabler($settingsRepository),
            $this->container->get(AssetManagerInterface::class),
            $this->container->get(AdminAssetInterface::class),
            $this->container->get(AdminUiInterface::class),
            $this->container->get(ThemeSupportInterface::class),
            $this->container->get(CustomizerInterface::class),
            $this->container->get(PageInstallerInterface::class),
            $this->container->get(ProductSearchInterface::class),
            $this->container->get(ContactTableInterface::class),
            $this->container->get(ContactAssetsInterface::class),
            $this->container->get(ThreadedCommentsInterface::class),
            $this->container->get(CommentRendererInterface::class),
            $this->container->get(WooAssetsInterface::class),
            $this->container->get(ProductTabsInterface::class),
            $this->container->get(CatalogMetaInterface::class),
            $this->container->get(NoticeControlInterface::class),
            $this->container->get(DollarPricingInterface::class),
            $this->container->get(LengthPricingInterface::class),
            $this->container->get(ProductFilterAjaxInterface::class),
            $this->container->get(BreadcrumbInterface::class),
            $this->container->get(ProductAttributeInterface::class),
            $this->container->get(ProductArchiveInterface::class),
            $this->container->get(ProductCategoryMetaInterface::class),
            $this->container->get(ProductAttributeFilterInterface::class),
            $this->container->get(ServicePostTypeInterface::class),
            $this->container->get(JalaliDateInterface::class),
            $this->container->get(HeaderSearchAjaxInterface::class),
            $this->container->get(ContactAjaxInterface::class),
            $this->container->get(SettingsAjaxInterface::class),
            $this->container->get(CardPriceAjaxInterface::class),
            $this->container->get(ThemeSettingsPageInterface::class),
        ];
    }
}
