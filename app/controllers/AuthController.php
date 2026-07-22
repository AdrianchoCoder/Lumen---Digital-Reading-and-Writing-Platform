<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\User;

/**
 * Registro (como lector), login y logout.
 */
final class AuthController extends Controller
{
    private User $users;

    public function __construct()
    {
        parent::__construct();
        $this->users = new User();
    }

    public function showLogin(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }

        $this->view('auth/login', [
            'title' => 'Iniciar sesión',
            'old'   => [
                'email' => '',
            ],
            'errors' => [],
        ]);
    }

    public function login(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }

        if (!$this->assertCsrf()) {
            return;
        }

        $email = $this->stringInput('email');
        $password = (string) ($_POST['password'] ?? '');

        $errors = [];

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Ingresa un correo válido.';
        }

        if ($password === '') {
            $errors['password'] = 'Ingresa tu contraseña.';
        }

        $user = null;
        if ($errors === []) {
            $user = $this->users->findByEmail($email);

            if (
                $user === null
                || (int) $user['is_active'] !== 1
                || !password_verify($password, $user['password_hash'])
            ) {
                $errors['form'] = 'Correo o contraseña incorrectos.';
            }
        }

        if ($errors !== []) {
            $this->view('auth/login', [
                'title'  => 'Iniciar sesión',
                'old'    => ['email' => $email],
                'errors' => $errors,
            ]);
            return;
        }

        Session::regenerate();
        $this->storeAuthUser($user);
        Session::flash('success', 'Sesión iniciada correctamente.');
        $this->redirect('/');
    }

    public function showRegister(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }

        $this->view('auth/register', [
            'title'  => 'Crear cuenta',
            'old'    => [
                'username'     => '',
                'email'        => '',
                'display_name' => '',
            ],
            'errors' => [],
        ]);
    }

    public function register(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }

        if (!$this->assertCsrf()) {
            return;
        }

        $username = $this->stringInput('username');
        $email = $this->stringInput('email');
        $displayName = $this->stringInput('display_name');
        $password = (string) ($_POST['password'] ?? '');
        $passwordConfirm = (string) ($_POST['password_confirm'] ?? '');

        $errors = $this->validateRegistration($username, $email, $displayName, $password, $passwordConfirm);

        if ($errors === []) {
            if ($this->users->findByEmail($email) !== null) {
                $errors['email'] = 'Este correo ya está registrado.';
            }

            if ($this->users->findByUsername($username) !== null) {
                $errors['username'] = 'Este nombre de usuario ya existe.';
            }
        }

        if ($errors !== []) {
            $this->view('auth/register', [
                'title'  => 'Crear cuenta',
                'old'    => [
                    'username'     => $username,
                    'email'        => $email,
                    'display_name' => $displayName,
                ],
                'errors' => $errors,
            ]);
            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $this->users->createReader($username, $email, $hash, $displayName);
        $user = $this->users->findById($userId);

        Session::regenerate();
        $this->storeAuthUser($user);
        Session::flash('success', 'Cuenta creada. Ya eres lector en Lumen.');
        $this->redirect('/');
    }

    public function logout(): void
    {
        if (!$this->assertCsrf()) {
            return;
        }

        Session::destroy();
        Session::start($this->config['session']['name'] ?? 'lumen_session');
        Session::flash('success', 'Sesión cerrada.');
        $this->redirect('/login');
    }

    private function validateRegistration(
        string $username,
        string $email,
        string $displayName,
        string $password,
        string $passwordConfirm
    ): array {
        $errors = [];

        if ($username === '' || !preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username)) {
            $errors['username'] = 'Usuario: 3-50 caracteres (letras, números o _).';
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190) {
            $errors['email'] = 'Ingresa un correo válido.';
        }

        if ($displayName === '' || mb_strlen($displayName) > 100) {
            $errors['display_name'] = 'El nombre visible es obligatorio (máx. 100).';
        }

        if (strlen($password) < 8) {
            $errors['password'] = 'La contraseña debe tener al menos 8 caracteres.';
        }

        if ($password !== $passwordConfirm) {
            $errors['password_confirm'] = 'Las contraseñas no coinciden.';
        }

        return $errors;
    }

    private function storeAuthUser(?array $user): void
    {
        if ($user === null) {
            return;
        }

        Session::set('user', [
            'id'           => (int) $user['id'],
            'username'     => $user['username'],
            'email'        => $user['email'],
            'display_name' => $user['display_name'],
            'role'         => $user['role'],
        ]);
    }
}
