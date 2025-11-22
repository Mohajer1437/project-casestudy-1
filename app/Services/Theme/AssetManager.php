<?php

namespace IdealBoresh\Services\Theme;

use IdealBoresh\Contracts\RegistersHooks;

class AssetManager implements AssetManagerInterface, RegistersHooks
{
    public function register(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function enqueueAssets(): void
    {
        if (!defined('IDEALBORESH_THEME_URI')) {
            return;
        }

        $this->enqueueBaseStyles();
        $this->enqueuePageSpecificStyles();
        $this->enqueueWooCommerceStyles();
        $this->enqueueInteractiveScripts();
    }

    private function enqueueBaseStyles(): void
    {
        wp_enqueue_style(
            'idealboresh-app',
            IDEALBORESH_THEME_URI . '/assets/css/app.css',
            [],
            IDEALBORESH_THEME_VERSION
        );
    }

    private function enqueuePageSpecificStyles(): void
    {
        if (is_page_template('page-contact.php')) {
            wp_enqueue_style(
                'idealboresh-contact',
                IDEALBORESH_THEME_URI . '/assets/css/contact.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
        }

        if (is_home()) {
            wp_enqueue_style(
                'idealboresh-blog',
                IDEALBORESH_THEME_URI . '/assets/css/blog.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
        }

        if (is_singular('post')) {
            wp_enqueue_style(
                'idealboresh-blog-post',
                IDEALBORESH_THEME_URI . '/assets/css/blog-post.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
        }

        if (is_page_template('page-about.php') || is_404()) {
            wp_enqueue_style(
                'idealboresh-about',
                IDEALBORESH_THEME_URI . '/assets/css/about.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
            $this->enqueueSwiperAssets();
        }

        if (is_page_template('page-front.php')) {
            $this->enqueueSwiperAssets();
        }

        if (is_page_template('single-services.php') || is_singular('services')) {
            wp_enqueue_style(
                'idealboresh-services',
                IDEALBORESH_THEME_URI . '/assets/css/services.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
        }

        if (function_exists('is_cart') && is_cart()) {
            wp_enqueue_style(
                'idealboresh-cart',
                IDEALBORESH_THEME_URI . '/assets/css/cart.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
        }

        if (function_exists('is_checkout') && is_checkout()) {
            wp_enqueue_style(
                'idealboresh-checkout',
                IDEALBORESH_THEME_URI . '/assets/css/checkout.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
        }

        if (function_exists('is_wc_endpoint_url') && is_wc_endpoint_url('lost-password')) {
            wp_enqueue_style(
                'idealboresh-lost-password',
                IDEALBORESH_THEME_URI . '/assets/css/lost-password.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
        }

        if (function_exists('is_account_page') && is_account_page()) {
            wp_enqueue_style(
                'idealboresh-login',
                IDEALBORESH_THEME_URI . '/assets/css/login.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
        }
    }

    private function enqueueWooCommerceStyles(): void
    {
        if (is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_brand')) {
            wp_enqueue_style(
                'idealboresh-product-archive',
                IDEALBORESH_THEME_URI . '/assets/css/product-category.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
        }

        if (is_singular('product')) {
            wp_enqueue_style(
                'idealboresh-product-single',
                IDEALBORESH_THEME_URI . '/assets/css/product.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
            $this->enqueueSwiperAssets();
        }
    }

    private function enqueueInteractiveScripts(): void
    {
        if (is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_brand')) {
            wp_enqueue_script(
                'idealboresh-archive-filters',
                IDEALBORESH_THEME_URI . '/assets/js/LoadMore_archive.js',
                [],
                IDEALBORESH_THEME_VERSION,
                true
            );
        }

        if (is_product_category()) {
            wp_enqueue_script(
                'idealboresh-tabs',
                IDEALBORESH_THEME_URI . '/assets/js/tabs.js',
                [],
                IDEALBORESH_THEME_VERSION,
                true
            );
        }

        if (is_singular('product')) {
            wp_enqueue_script(
                'idealboresh-single-product',
                IDEALBORESH_THEME_URI . '/assets/js/script-single.js',
                [],
                IDEALBORESH_THEME_VERSION,
                true
            );
        }
    }

    private function enqueueSwiperAssets(): void
    {
        wp_enqueue_style(
            'idealboresh-swiper',
            IDEALBORESH_THEME_URI . '/assets/css/swiper-bundle.min.css',
            ['idealboresh-app'],
            IDEALBORESH_THEME_VERSION
        );

        wp_enqueue_script(
            'idealboresh-swiper',
            IDEALBORESH_THEME_URI . '/assets/js/swiper-bundle.min.js',
            [],
            IDEALBORESH_THEME_VERSION,
            true
        );
    }
}
