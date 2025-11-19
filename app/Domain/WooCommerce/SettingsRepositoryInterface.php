<?php

namespace IdealBoresh\Domain\WooCommerce;

interface SettingsRepositoryInterface
{
    public function disableTracking(): void;
    public function disableMarketplaceSuggestions(): void;
}
