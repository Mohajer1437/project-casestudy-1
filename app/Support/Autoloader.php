<?php

namespace IdealBoresh\Support;

class Autoloader
{
    private const BASE_NAMESPACE = 'IdealBoresh\\';
    private string $basePath;

    public function __construct(?string $basePath = null)
    {
        $this->basePath = $basePath ?: dirname(__DIR__);
    }

    public function register(): void
    {
        spl_autoload_register(function (string $class): void {
            if (strpos($class, self::BASE_NAMESPACE) !== 0) {
                return;
            }

            $relative = substr($class, strlen(self::BASE_NAMESPACE));
            $path = $this->basePath . '/' . str_replace('\\', '/', $relative) . '.php';

            if (file_exists($path)) {
                require_once $path;
            }
        });
    }
}
