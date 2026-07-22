<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Book;

/**
 * Portada pública (landing) para visitantes sin sesión.
 * Si hay sesión, redirige al Inicio del lector.
 */
final class HomeController extends Controller
{
    public function index(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/inicio');
        }

        $books = new Book();

        $this->view('home/index', [
            'title'         => 'Bienvenido',
            'popularBooks'  => $books->latestPublished(12),
        ], 'landing');
    }
}
