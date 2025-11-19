<?php

namespace IdealBoresh\Services\Theme;

interface FooterPresenterInterface
{
    /**
     * @return array<string, mixed>
     */
    public function buildContext(): array;
}
