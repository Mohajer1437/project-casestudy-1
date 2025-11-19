<?php

namespace IdealBoresh\Infrastructure\WooCommerce;

use IdealBoresh\Domain\WooCommerce\SettingsRepositoryInterface;

class SettingsRepository implements SettingsRepositoryInterface
{
    public function disableTracking(): void
    {
        if (get_option('woocommerce_allow_tracking') !== 'no') {
            update_option('woocommerce_allow_tracking', 'no');
        }
    }

    public function disableMarketplaceSuggestions(): void
    {
        if (get_option('woocommerce_show_marketplace_suggestions') !== 'no') {
            update_option('woocommerce_show_marketplace_suggestions', 'no');
        }
    }
}
