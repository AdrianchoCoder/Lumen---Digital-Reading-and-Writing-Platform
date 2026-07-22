<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Follow;
use App\Models\User;

final class FollowController extends Controller
{
    private Follow $follows;
    private User $users;

    public function __construct()
    {
        parent::__construct();
        $this->follows = new Follow();
        $this->users = new User();
    }

    public function follow(string $userId): void
    {
        $auth = $this->requireAuth();

        if (!$this->assertCsrf()) {
            return;
        }

        $targetId = (int) $userId;
        $target = $this->users->findById($targetId);

        if ($target === null || (int) $target['is_active'] !== 1) {
            Session::flash('error', 'Usuario no encontrado.');
            $this->redirect('/descubrir');
        }

        if ($targetId === (int) $auth['id']) {
            Session::flash('error', 'No puedes seguirte a ti mismo.');
            $this->redirect('/perfil');
        }

        $this->follows->follow((int) $auth['id'], $targetId);
        Session::flash('success', 'Ahora sigues a ' . $target['display_name'] . '.');
        $this->redirect('/u/' . rawurlencode($target['username']));
    }

    public function unfollow(string $userId): void
    {
        $auth = $this->requireAuth();

        if (!$this->assertCsrf()) {
            return;
        }

        $targetId = (int) $userId;
        $target = $this->users->findById($targetId);

        if ($target === null) {
            Session::flash('error', 'Usuario no encontrado.');
            $this->redirect('/descubrir');
        }

        $this->follows->unfollow((int) $auth['id'], $targetId);
        Session::flash('success', 'Dejaste de seguir a ' . $target['display_name'] . '.');
        $this->redirect('/u/' . rawurlencode($target['username']));
    }
}
