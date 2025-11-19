<?php

namespace IdealBoresh\Infrastructure\WordPress;

use IdealBoresh\Domain\Settings\OptionRepositoryInterface;

class OptionRepository implements OptionRepositoryInterface
{
    public function get(string $key, $default = false)
    {
        return get_option($key, $default);
    }
}
