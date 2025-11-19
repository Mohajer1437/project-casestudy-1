<?php

namespace IdealBoresh\Application\Performance;

use IdealBoresh\Contracts\RegistersHooks;
use IdealBoresh\Domain\WooCommerce\SettingsRepositoryInterface;

class WooCommerceTelemetryDisabler implements RegistersHooks
{
    public function __construct(private SettingsRepositoryInterface $settings)
    {
    }

    public function register(): void
    {
        add_action('init', [$this, 'disableTelemetry'], 20);
        add_filter('woocommerce_allow_tracking', '__return_false');
        add_filter('woocommerce_show_marketplace_suggestions', '__return_false');
    }

    public function disableTelemetry(): void
    {
        $this->settings->disableTracking();
        $this->settings->disableMarketplaceSuggestions();
    }
}
