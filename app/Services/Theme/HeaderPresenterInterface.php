<?php

namespace IdealBoresh\Services\Theme;

interface HeaderPresenterInterface
{
    /**
     * @return array<string, mixed>
     */
    public function buildContext(): array;
}
