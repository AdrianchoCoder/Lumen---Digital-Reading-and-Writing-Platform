<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Core\Router;

/** @var Router $router */
$router = $router ?? null;

if (!$router instanceof Router) {
    throw new RuntimeException('El archivo de rutas debe recibirse con una instancia de Router.');
}

$router->get('/', [HomeController::class, 'index']);
