<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Autoload con mapa explícito App\* → carpetas en minúsculas.
 * Así la estructura de carpetas coincide con la guía del proyecto
 * y sigue siendo portable (Linux distingue mayúsculas).
 */
final class Autoloader
{
    /** @var array<string, string> */
    private array $prefixes;

    public function __construct(string $appDir)
    {
        $base = rtrim($appDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        $this->prefixes = [
            'App\\Controllers\\' => $base . 'controllers' . DIRECTORY_SEPARATOR,
            'App\\Models\\'      => $base . 'models' . DIRECTORY_SEPARATOR,
            'App\\Core\\'        => $base . 'core' . DIRECTORY_SEPARATOR,
            'App\\Middleware\\'  => $base . 'middleware' . DIRECTORY_SEPARATOR,
        ];
    }

    public function register(): void
    {
        spl_autoload_register([$this, 'load']);
    }

    public function load(string $class): void
    {
        foreach ($this->prefixes as $prefix => $dir) {
            if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
                continue;
            }

            $relative = substr($class, strlen($prefix));
            $file = $dir . str_replace('\\', DIRECTORY_SEPARATOR, $relative) . '.php';

            if (is_file($file)) {
                require_once $file;
            }

            return;
        }
    }
}
