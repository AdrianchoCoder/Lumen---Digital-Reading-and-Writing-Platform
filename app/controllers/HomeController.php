<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

/**
 * Portada / smoke test del núcleo + estado de autenticación.
 */
final class HomeController extends Controller
{
    public function index(): void
    {
        $dbStatus = 'pendiente';
        $dbOk = false;

        try {
            Database::getInstance($this->config['db']);
            $dbStatus = 'conexión PDO correcta';
            $dbOk = true;
        } catch (\Throwable $e) {
            if ($this->config['app']['debug']) {
                $dbStatus = $e->getMessage();
            }
        }

        $this->view('home/index', [
            'title'    => $this->config['app']['name'],
            'dbStatus' => $dbStatus,
            'dbOk'     => $dbOk,
        ]);
    }
}
