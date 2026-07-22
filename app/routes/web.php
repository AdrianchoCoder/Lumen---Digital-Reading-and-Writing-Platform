<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\FollowController;
use App\Controllers\HomeController;
use App\Controllers\ReaderController;
use App\Core\Router;

/** @var Router $router */
$router = $router ?? null;

if (!$router instanceof Router) {
    throw new RuntimeException('El archivo de rutas debe recibirse con una instancia de Router.');
}

$router->get('/', [HomeController::class, 'index']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/inicio', [ReaderController::class, 'home']);
$router->get('/descubrir', [ReaderController::class, 'discover']);
$router->get('/biblioteca', [ReaderController::class, 'library']);
$router->get('/perfil', [ReaderController::class, 'profile']);
$router->post('/perfil', [ReaderController::class, 'updateProfile']);
$router->get('/u/{username}', [ReaderController::class, 'profile']);

$router->get('/libros/{id}', [ReaderController::class, 'showBook']);
$router->get('/libros/{bookId}/capitulos/{chapterId}', [ReaderController::class, 'readChapter']);
$router->post('/biblioteca/agregar/{bookId}', [ReaderController::class, 'addToLibrary']);
$router->post('/biblioteca/quitar/{bookId}', [ReaderController::class, 'removeFromLibrary']);

$router->post('/seguir/{userId}', [FollowController::class, 'follow']);
$router->post('/dejar-seguir/{userId}', [FollowController::class, 'unfollow']);
