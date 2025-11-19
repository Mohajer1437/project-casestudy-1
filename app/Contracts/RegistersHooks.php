<?php

namespace IdealBoresh\Contracts;

interface RegistersHooks
{
    /**
     * Register all WordPress hooks for the module.
     */
    public function register(): void;
}
