<?php
/**
 * Configuración general de Lumen.
 *
 * Ajusta DB_* según tu instalación de XAMPP / phpMyAdmin.
 * En XAMPP por defecto el usuario es "root" y la contraseña está vacía.
 */

declare(strict_types=1);

return [
    'app' => [
        'name'      => 'Lumen',
        'env'       => 'local',
        'debug'     => true,
        'url'       => 'http://localhost/Lumen---Digital-Reading-and-Writing-Platform/public',
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

    /**
     * Niveles jerárquicos de rol (un solo campo users.role).
     * lector < escritor < administrador
     */
    'roles' => [
        'lector'         => 1,
        'escritor'       => 2,
        'administrador'  => 3,
    ],
];
