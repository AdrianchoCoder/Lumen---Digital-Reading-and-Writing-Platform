<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

/**
 * Portada pública para visitantes sin sesión.
 * Si hay sesión, redirige al Inicio del lector.
 */
final class HomeController extends Controller
{
    public function index(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/inicio');
        }

        $this->view('home/index', [
            'title' => 'Bienvenido',
        ]);
    }
}
