<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Resuelve la URL base de la app sin depender del nombre de carpeta en htdocs.
 *
 * Si `config['app']['url']` viene vacío (por defecto), se detecta desde la
 * propia petición (esquema + host + carpeta de public/index.php), igual que
 * Router::dispatch calcula la ruta a partir de SCRIPT_NAME. Así el proyecto
 * funciona igual sin importar cómo se llame la carpeta del clon.
 */
final class AppUrl
{
    public static function detect(?string $configured = null): string
    {
        $configured = trim((string) $configured);
        if ($configured !== '') {
            return rtrim($configured, '/');
        }

        $scheme = (($_SERVER['HTTPS'] ?? 'off') !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $base = in_array($base, ['/', '.'], true) ? '' : rtrim($base, '/');

        return $scheme . '://' . $host . $base;
    }
}
