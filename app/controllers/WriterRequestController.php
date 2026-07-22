<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\WriterRequest;

/**
 * Solicitud del lector para convertirse en escritor.
 * La aprobación la hará el administrador (módulo 7).
 */
final class WriterRequestController extends Controller
{
    private WriterRequest $requests;

    public function __construct()
    {
        parent::__construct();
        $this->requests = new WriterRequest();
    }

    public function show(): void
    {
        $auth = $this->requireAuth();
        $latest = $this->requests->latestForUser((int) $auth['id']);
        $history = $this->requests->historyForUser((int) $auth['id']);

        $this->view('reader/writer-request', [
            'title'          => 'Ser escritor',
            'role'           => $auth['role'],
            'latest'         => $latest,
            'history'        => $history,
            'canSubmit'      => $this->canSubmit($auth['role'], $latest),
            'motivationOld'  => '',
            'errors'         => [],
        ], 'app');
    }

    public function store(): void
    {
        $auth = $this->requireAuth();

        if (!$this->assertCsrf()) {
            return;
        }

        $latest = $this->requests->latestForUser((int) $auth['id']);

        if (!$this->canSubmit($auth['role'], $latest)) {
            Session::flash('error', 'No puedes enviar una solicitud en este momento.');
            $this->redirect('/solicitar-escritor');
        }

        $motivation = $this->stringInput('motivation');
        $errors = [];

        $length = mb_strlen($motivation);
        if ($length < 30) {
            $errors['motivation'] = 'Cuéntanos un poco más (mínimo 30 caracteres).';
        } elseif ($length > 2000) {
            $errors['motivation'] = 'La motivación no puede superar 2000 caracteres.';
        }

        if ($errors !== []) {
            $this->view('reader/writer-request', [
                'title'         => 'Ser escritor',
                'role'          => $auth['role'],
                'latest'        => $latest,
                'history'       => $this->requests->historyForUser((int) $auth['id']),
                'canSubmit'     => true,
                'motivationOld' => $motivation,
                'errors'        => $errors,
            ], 'app');
            return;
        }

        $this->requests->create((int) $auth['id'], $motivation);
        Session::flash('success', 'Solicitud enviada. Un administrador la revisará pronto.');
        $this->redirect('/solicitar-escritor');
    }

    private function canSubmit(string $role, ?array $latest): bool
    {
        if ($role !== 'lector') {
            return false;
        }

        if ($latest !== null && $latest['status'] === 'pendiente') {
            return false;
        }

        return true;
    }
}
