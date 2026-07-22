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

$auth = ['auth'];
$guest = ['guest'];
$writer = ['role:escritor'];
$admin = ['role:administrador'];

$router->get('/', [HomeController::class, 'index']);

$router->get('/login', [AuthController::class, 'showLogin'], $guest);
$router->post('/login', [AuthController::class, 'login'], $guest);
$router->get('/register', [AuthController::class, 'showRegister'], $guest);
$router->post('/register', [AuthController::class, 'register'], $guest);
$router->post('/logout', [AuthController::class, 'logout'], $auth);

$router->get('/inicio', [ReaderController::class, 'home'], $auth);
$router->get('/descubrir', [ReaderController::class, 'discover'], $auth);
$router->get('/biblioteca', [ReaderController::class, 'library'], $auth);
$router->get('/perfil', [ReaderController::class, 'profile'], $auth);
$router->post('/perfil', [ReaderController::class, 'updateProfile'], $auth);
$router->get('/u/{username}', [ReaderController::class, 'profile'], $auth);

$router->get('/libros/{id}', [ReaderController::class, 'showBook'], $auth);
$router->get('/libros/{bookId}/capitulos/{chapterId}', [ReaderController::class, 'readChapter'], $auth);
$router->post('/biblioteca/agregar/{bookId}', [ReaderController::class, 'addToLibrary'], $auth);
$router->post('/biblioteca/quitar/{bookId}', [ReaderController::class, 'removeFromLibrary'], $auth);

$router->post('/seguir/{userId}', [FollowController::class, 'follow'], $auth);
$router->post('/dejar-seguir/{userId}', [FollowController::class, 'unfollow'], $auth);

$router->get('/solicitar-escritor', [WriterRequestController::class, 'show'], $auth);
$router->post('/solicitar-escritor', [WriterRequestController::class, 'store'], $auth);

// Escritor (nivel >= 2; administrador también pasa)
$router->get('/escribir', [WriterController::class, 'hub'], $writer);
$router->get('/escribir/libros', [WriterController::class, 'books'], $writer);
$router->get('/escribir/libros/nueva', [WriterController::class, 'createBookForm'], $writer);
$router->post('/escribir/libros', [WriterController::class, 'storeBook'], $writer);
$router->get('/escribir/libros/{id}', [WriterController::class, 'showBook'], $writer);
$router->post('/escribir/libros/{id}', [WriterController::class, 'updateBook'], $writer);
$router->get('/escribir/libros/{bookId}/capitulos/nuevo', [WriterController::class, 'createChapterForm'], $writer);
$router->post('/escribir/libros/{bookId}/capitulos', [WriterController::class, 'storeChapter'], $writer);
$router->get('/escribir/libros/{bookId}/capitulos/{chapterId}/editar', [WriterController::class, 'editChapterForm'], $writer);
$router->post('/escribir/libros/{bookId}/capitulos/{chapterId}', [WriterController::class, 'updateChapter'], $writer);
$router->get('/escribir/comunidades', [WriterController::class, 'communities'], $writer);
$router->get('/escribir/comunidades/nueva', [WriterController::class, 'createCommunityForm'], $writer);
$router->post('/escribir/comunidades', [WriterController::class, 'storeCommunity'], $writer);
$router->post('/escribir/comunidades/{id}/toggle', [WriterController::class, 'toggleCommunity'], $writer);
$router->get('/escribir/estadisticas', [WriterController::class, 'stats'], $writer);

// Administrador (nivel >= 3)
$router->get('/admin', [AdminController::class, 'dashboard'], $admin);
$router->get('/admin/solicitudes', [AdminController::class, 'writerRequests'], $admin);
$router->post('/admin/solicitudes/{id}/aprobar', [AdminController::class, 'approveRequest'], $admin);
$router->post('/admin/solicitudes/{id}/rechazar', [AdminController::class, 'rejectRequest'], $admin);
$router->get('/admin/usuarios', [AdminController::class, 'users'], $admin);
$router->post('/admin/usuarios/{id}/toggle', [AdminController::class, 'toggleUser'], $admin);
$router->post('/admin/usuarios/{id}/rol', [AdminController::class, 'updateUserRole'], $admin);
$router->get('/admin/contenido', [AdminController::class, 'books'], $admin);
$router->post('/admin/contenido/{id}/archivar', [AdminController::class, 'archiveBook'], $admin);
$router->post('/admin/contenido/{id}/publicar', [AdminController::class, 'publishBook'], $admin);
