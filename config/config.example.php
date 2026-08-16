<?php
/**
 * Ejemplo de configuración. Copia a config.php y ajusta valores locales.
 */

declare(strict_types=1);

return [
    'app' => [
        'name'      => 'Lumen',
        'env'       => 'local',
        'debug'     => true,
        // Vacío = se detecta solo (esquema + host + carpeta) desde la petición.
        // Solo fija un valor aquí si necesitas forzar un dominio distinto (ej. detrás de un proxy).
        'url'       => '',
        'timezone'  => 'America/Bogota',
    ],

    'db' => [
        'host'     => '127.0.0.1',
        'port'     => '3306',
        'name'     => 'lumen',
        'username' => 'root',
        'password' => '',
        'charset'  => 'utf8mb4',
    ],

    'session' => [
        'name' => 'lumen_session',
    ],

    'roles' => [
        'lector'         => 1,
        'escritor'       => 2,
        'administrador'  => 3,
    ],
];
