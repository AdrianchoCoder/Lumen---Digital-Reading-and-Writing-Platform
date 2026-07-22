<?php

declare(strict_types=1);

/**
 * Front controller de Lumen.
 * Único punto de entrada HTTP: todas las peticiones pasan por aquí.
 */

use App\Core\Autoloader;
use App\Core\Router;

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/app/core/Autoloader.php';

(new Autoloader(BASE_PATH . '/app'))->register();

$config = require BASE_PATH . '/config/config.php';

date_default_timezone_set($config['app']['timezone'] ?? 'UTC');

if (!empty($config['app']['debug'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

$router = new Router();
require BASE_PATH . '/app/routes/web.php';

$router->dispatch(
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    $_SERVER['REQUEST_URI'] ?? '/'
);
