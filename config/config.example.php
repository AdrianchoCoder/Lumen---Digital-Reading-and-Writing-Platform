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
        'url'       => 'http://localhost/tu-carpeta/public',
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
