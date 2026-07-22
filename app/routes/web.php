<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\FollowController;
use App\Controllers\HomeController;
use App\Controllers\ReaderController;
use App\Controllers\WriterController;
use App\Controllers\WriterRequestController;
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

$router->get('/solicitar-escritor', [WriterRequestController::class, 'show']);
$router->post('/solicitar-escritor', [WriterRequestController::class, 'store']);

// Escritor (rol mínimo escritor; admin también pasa)
$router->get('/escribir', [WriterController::class, 'hub']);
$router->get('/escribir/libros', [WriterController::class, 'books']);
$router->get('/escribir/libros/nueva', [WriterController::class, 'createBookForm']);
$router->post('/escribir/libros', [WriterController::class, 'storeBook']);
$router->get('/escribir/libros/{id}', [WriterController::class, 'showBook']);
$router->post('/escribir/libros/{id}', [WriterController::class, 'updateBook']);
$router->get('/escribir/libros/{bookId}/capitulos/nuevo', [WriterController::class, 'createChapterForm']);
$router->post('/escribir/libros/{bookId}/capitulos', [WriterController::class, 'storeChapter']);
$router->get('/escribir/libros/{bookId}/capitulos/{chapterId}/editar', [WriterController::class, 'editChapterForm']);
$router->post('/escribir/libros/{bookId}/capitulos/{chapterId}', [WriterController::class, 'updateChapter']);
$router->get('/escribir/comunidades', [WriterController::class, 'communities']);
$router->get('/escribir/comunidades/nueva', [WriterController::class, 'createCommunityForm']);
$router->post('/escribir/comunidades', [WriterController::class, 'storeCommunity']);
$router->post('/escribir/comunidades/{id}/toggle', [WriterController::class, 'toggleCommunity']);
$router->get('/escribir/estadisticas', [WriterController::class, 'stats']);

// Administrador
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/solicitudes', [AdminController::class, 'writerRequests']);
$router->post('/admin/solicitudes/{id}/aprobar', [AdminController::class, 'approveRequest']);
$router->post('/admin/solicitudes/{id}/rechazar', [AdminController::class, 'rejectRequest']);
$router->get('/admin/usuarios', [AdminController::class, 'users']);
$router->post('/admin/usuarios/{id}/toggle', [AdminController::class, 'toggleUser']);
$router->post('/admin/usuarios/{id}/rol', [AdminController::class, 'updateUserRole']);
$router->get('/admin/contenido', [AdminController::class, 'books']);
$router->post('/admin/contenido/{id}/archivar', [AdminController::class, 'archiveBook']);
$router->post('/admin/contenido/{id}/publicar', [AdminController::class, 'publishBook']);
