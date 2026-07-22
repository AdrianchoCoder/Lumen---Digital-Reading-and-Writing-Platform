<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Models\Book;
use App\Models\User;
use App\Models\WriterRequest;
use PDO;
use Throwable;

/**
 * Panel de administración: solicitudes, usuarios y moderación de contenido.
 */
final class AdminController extends Controller
{
    private WriterRequest $requests;
    private User $users;
    private Book $books;
    private PDO $pdo;

    private const ASSIGNABLE_ROLES = ['lector', 'escritor', 'administrador'];

    public function __construct()
    {
        parent::__construct();
        $this->requests = new WriterRequest();
        $this->users = new User();
        $this->books = new Book();
        $this->pdo = Database::getInstance()->pdo();
    }

    public function dashboard(): void
    {
        $this->requireMinRole('administrador');

        $this->view('admin/dashboard', [
            'title' => 'Admin',
            'stats' => [
                'pending_requests' => $this->requests->countByStatus('pendiente'),
                'users'            => $this->users->countAll(),
                'books'            => $this->books->countAll(),
            ],
        ], 'app');
    }

    public function writerRequests(): void
    {
        $this->requireMinRole('administrador');
        $filter = $this->stringInput('estado', 'get');
        if ($filter === '') {
            $filter = 'pendiente';
        }
        if (!in_array($filter, ['pendiente', 'aprobado', 'rechazado', 'todas'], true)) {
            $filter = 'pendiente';
        }

        $status = $filter === 'todas' ? null : $filter;

        $this->view('admin/writer-requests', [
            'title'    => 'Solicitudes de escritor',
            'filter'   => $filter,
            'requests' => $this->requests->listByStatus($status),
        ], 'app');
    }

    public function approveRequest(string $id): void
    {
        $admin = $this->requireMinRole('administrador');

        if (!$this->assertCsrf()) {
            return;
        }

        $requestId = (int) $id;
        $request = $this->requests->findById($requestId);

        if ($request === null || $request['status'] !== 'pendiente') {
            Session::flash('error', 'Solicitud no disponible o ya revisada.');
            $this->redirect('/admin/solicitudes');
        }

        $note = $this->stringInput('admin_note');
        if (mb_strlen($note) > 500) {
            Session::flash('error', 'La nota del admin no puede superar 500 caracteres.');
            $this->redirect('/admin/solicitudes');
        }

        try {
            $this->pdo->beginTransaction();

            $ok = $this->requests->review(
                $requestId,
                'aprobado',
                (int) $admin['id'],
                $note !== '' ? $note : null
            );

            if (!$ok) {
                throw new \RuntimeException('No se pudo actualizar la solicitud.');
            }

            $user = $this->users->findById((int) $request['user_id']);
            if ($user === null) {
                throw new \RuntimeException('Usuario de la solicitud no existe.');
            }

            // No bajar de administrador si ya lo era.
            if ($user['role'] !== 'administrador') {
                $this->users->setRole((int) $request['user_id'], 'escritor');
            }

            $this->pdo->commit();
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            Session::flash('error', 'Error al aprobar: ' . $e->getMessage());
            $this->redirect('/admin/solicitudes');
        }

        Session::flash('success', 'Solicitud aprobada. El usuario ahora es escritor.');
        $this->redirect('/admin/solicitudes');
    }

    public function rejectRequest(string $id): void
    {
        $admin = $this->requireMinRole('administrador');

        if (!$this->assertCsrf()) {
            return;
        }

        $requestId = (int) $id;
        $request = $this->requests->findById($requestId);

        if ($request === null || $request['status'] !== 'pendiente') {
            Session::flash('error', 'Solicitud no disponible o ya revisada.');
            $this->redirect('/admin/solicitudes');
        }

        $note = $this->stringInput('admin_note');
        if (mb_strlen($note) > 500) {
            Session::flash('error', 'La nota del admin no puede superar 500 caracteres.');
            $this->redirect('/admin/solicitudes');
        }

        $ok = $this->requests->review(
            $requestId,
            'rechazado',
            (int) $admin['id'],
            $note !== '' ? $note : null
        );

        if (!$ok) {
            Session::flash('error', 'No se pudo rechazar la solicitud.');
            $this->redirect('/admin/solicitudes');
        }

        Session::flash('success', 'Solicitud rechazada.');
        $this->redirect('/admin/solicitudes?estado=rechazado');
    }

    public function users(): void
    {
        $admin = $this->requireMinRole('administrador');
        $query = $this->stringInput('q', 'get');

        $this->view('admin/users', [
            'title'      => 'Usuarios',
            'query'      => $query,
            'users'      => $this->users->listForAdmin($query !== '' ? $query : null),
            'adminId'    => (int) $admin['id'],
            'roles'      => self::ASSIGNABLE_ROLES,
        ], 'app');
    }

    public function toggleUser(string $id): void
    {
        $admin = $this->requireMinRole('administrador');

        if (!$this->assertCsrf()) {
            return;
        }

        $userId = (int) $id;

        if ($userId === (int) $admin['id']) {
            Session::flash('error', 'No puedes desactivar tu propia cuenta.');
            $this->redirect('/admin/usuarios');
        }

        $user = $this->users->findById($userId);
        if ($user === null) {
            Session::flash('error', 'Usuario no encontrado.');
            $this->redirect('/admin/usuarios');
        }

        $newActive = !((int) $user['is_active'] === 1);
        $this->users->setActive($userId, $newActive);

        Session::flash('success', $newActive ? 'Usuario activado.' : 'Usuario desactivado.');
        $this->redirect('/admin/usuarios');
    }

    public function updateUserRole(string $id): void
    {
        $admin = $this->requireMinRole('administrador');

        if (!$this->assertCsrf()) {
            return;
        }

        $userId = (int) $id;
        $role = $this->stringInput('role');

        if ($userId === (int) $admin['id']) {
            Session::flash('error', 'No puedes cambiar tu propio rol desde aquí.');
            $this->redirect('/admin/usuarios');
        }

        if (!in_array($role, self::ASSIGNABLE_ROLES, true)) {
            Session::flash('error', 'Rol inválido.');
            $this->redirect('/admin/usuarios');
        }

        $user = $this->users->findById($userId);
        if ($user === null) {
            Session::flash('error', 'Usuario no encontrado.');
            $this->redirect('/admin/usuarios');
        }

        $this->users->setRole($userId, $role);
        Session::flash('success', 'Rol actualizado a ' . $role . '.');
        $this->redirect('/admin/usuarios');
    }

    public function books(): void
    {
        $this->requireMinRole('administrador');
        $query = $this->stringInput('q', 'get');

        $this->view('admin/books', [
            'title' => 'Contenido',
            'query' => $query,
            'books' => $this->books->listForAdmin($query !== '' ? $query : null),
        ], 'app');
    }

    public function archiveBook(string $id): void
    {
        $this->requireMinRole('administrador');

        if (!$this->assertCsrf()) {
            return;
        }

        $book = $this->books->findById((int) $id);
        if ($book === null) {
            Session::flash('error', 'Historia no encontrada.');
            $this->redirect('/admin/contenido');
        }

        $this->books->setStatus((int) $id, 'archivado');
        Session::flash('success', 'Historia archivada (ya no aparece en Descubrir).');
        $this->redirect('/admin/contenido');
    }

    public function publishBook(string $id): void
    {
        $this->requireMinRole('administrador');

        if (!$this->assertCsrf()) {
            return;
        }

        $book = $this->books->findById((int) $id);
        if ($book === null) {
            Session::flash('error', 'Historia no encontrada.');
            $this->redirect('/admin/contenido');
        }

        $this->books->setStatus((int) $id, 'publicado');
        Session::flash('success', 'Historia marcada como publicada.');
        $this->redirect('/admin/contenido');
    }
}
