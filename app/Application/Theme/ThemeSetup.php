<?php

namespace IdealBoresh\Application\Theme;

use IdealBoresh\Contracts\RegistersHooks;

class ThemeSetup implements RegistersHooks
{
    public function register(): void
    {
        add_action('after_setup_theme', [$this, 'boot']);
    }

    public function boot(): void
    {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('woocommerce');
        add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);

        register_nav_menus([
            'header-mega-menu'   => __('هدر مگا منو', 'idealboresh'),
            'footer-menu-right'  => __('فهرست فوتر راست', 'idealboresh'),
            'footer-menu-middle' => __('فهرست فوتر میانی', 'idealboresh'),
            'footer-menu-left'   => __('فهرست فوتر چپ', 'idealboresh'),
        ]);
    }
}
