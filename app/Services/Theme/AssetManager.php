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

        wp_enqueue_style(
            'idealboresh-app',
            IDEALBORESH_THEME_URI . '/assets/css/app.css',
            [],
            IDEALBORESH_THEME_VERSION
        );

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

        if (is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_brand')) {
            wp_enqueue_style(
                'idealboresh-product-archive',
                IDEALBORESH_THEME_URI . '/assets/css/product-category.css',
                ['idealboresh-app'],
                IDEALBORESH_THEME_VERSION
            );
            wp_enqueue_script(
                'idealboresh-archive-filters',
                IDEALBORESH_THEME_URI . '/assets/js/LoadMore_archive.js',
                [],
                IDEALBORESH_THEME_VERSION,
                true
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
