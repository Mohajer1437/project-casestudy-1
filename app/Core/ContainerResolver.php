<?php

namespace IdealBoresh\Core;

class ContainerResolver
{
    private static ?Container $instance = null;

    public static function boot(Container $container): void
    {
        self::$instance = $container;
    }

    public static function getInstance(): ?Container
    {
        return self::$instance;
    }
}
