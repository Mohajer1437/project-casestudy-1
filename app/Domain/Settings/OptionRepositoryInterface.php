<?php

namespace IdealBoresh\Domain\Settings;

interface OptionRepositoryInterface
{
    /**
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = false);
}
