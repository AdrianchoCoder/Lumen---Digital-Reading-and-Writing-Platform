<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

/**
 * Controlador de prueba del núcleo MVC (módulo 1).
 * Verifica que el Router, las vistas y (opcionalmente) la BD respondan.
 */
final class HomeController extends Controller
{
    public function index(): void
    {
        $dbStatus = 'pendiente (aún no se creó la base lumen)';
        $dbOk = false;

        try {
            Database::getInstance($this->config['db']);
            $dbStatus = 'conexión PDO correcta';
            $dbOk = true;
        } catch (\Throwable $e) {
            // Esperado hasta importar lumen.sql (módulo 2) o si MySQL no está activo.
            if ($this->config['app']['debug']) {
                $dbStatus = $e->getMessage();
            }
        }

        $this->view('home/index', [
            'appName'  => $this->config['app']['name'],
            'dbStatus' => $dbStatus,
            'dbOk'     => $dbOk,
        ]);
    }
}
