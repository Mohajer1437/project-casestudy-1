<?php

namespace IdealBoresh\Application\Theme;

use IdealBoresh\Contracts\RegistersHooks;
use IdealBoresh\Services\Theme\FooterPresenterInterface;
use IdealBoresh\Services\Theme\HeaderPresenterInterface;
use IdealBoresh\Services\WooCommerce\ProductCardPresenterInterface;
use WC_Product;

class TemplateContextProvider implements RegistersHooks
{
    public function __construct(
        private HeaderPresenterInterface $headerPresenter,
        private FooterPresenterInterface $footerPresenter,
        private ProductCardPresenterInterface $productCardPresenter
    ) {
    }

    /** @var array<string, mixed> */
    private array $headerContext = [];

    /** @var array<string, mixed> */
    private array $footerContext = [];

    public function register(): void
    {
        add_action('get_header', [$this, 'shareHeaderContext']);
        add_action('get_footer', [$this, 'shareFooterContext']);
        add_filter('idealboresh/product_card/context', [$this, 'provideProductCardContext'], 10, 2);
    }

    public function shareHeaderContext(): void
    {
        if (!function_exists('set_query_var')) {
            return;
        }

        set_query_var('idealboresh_header_context', $this->getHeaderContext());
    }

    public function shareFooterContext(): void
    {
        if (!function_exists('set_query_var')) {
            return;
        }

        set_query_var('idealboresh_footer_context', $this->getFooterContext());
    }

    /**
     * @param array<string, mixed> $context
     * @return array<string, mixed>
     */
    public function provideProductCardContext(array $context, $product): array
    {
        if ($product instanceof WC_Product) {
            return $this->productCardPresenter->buildContext($product);
        }

        return $context;
    }

    /**
     * @return array<string, mixed>
     */
    private function getHeaderContext(): array
    {
        if ($this->headerContext === []) {
            $this->headerContext = $this->headerPresenter->buildContext();
        }

        return $this->headerContext;
    }

    /**
     * @return array<string, mixed>
     */
    private function getFooterContext(): array
    {
        if ($this->footerContext === []) {
            $this->footerContext = $this->footerPresenter->buildContext();
        }

        return $this->footerContext;
    }
}
