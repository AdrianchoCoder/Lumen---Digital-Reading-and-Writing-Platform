<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Session;

/**
 * Middleware de roles jerárquicos (lector=1 < escritor=2 < administrador=3).
 *
 * Reglas admitidas al registrar rutas:
 * - "auth"                 → debe haber sesión
 * - "guest"                → no debe haber sesión (login/registro)
 * - "role:escritor"        → nivel mínimo 2
 * - "role:administrador"   → nivel mínimo 3
 * - "role:lector"          → nivel mínimo 1 (equivale a auth con rol válido)
 */
final class RoleMiddleware
{
    public static function handle(string $rule): void
    {
        $config = require dirname(__DIR__, 2) . '/config/config.php';
        $roles = $config['roles'] ?? [];
        $appUrl = rtrim((string) ($config['app']['url'] ?? ''), '/');

        if ($rule === 'auth') {
            if (!self::isLoggedIn()) {
                Session::flash('error', 'Debes iniciar sesión para continuar.');
                self::redirect($appUrl, '/login');
            }
            return;
        }

        if ($rule === 'guest') {
            if (self::isLoggedIn()) {
                self::redirect($appUrl, '/inicio');
            }
            return;
        }

        if (str_starts_with($rule, 'role:')) {
            $minRole = substr($rule, 5);
            if (!isset($roles[$minRole])) {
                throw new \InvalidArgumentException("Rol de middleware desconocido: {$minRole}");
            }

            if (!self::isLoggedIn()) {
                Session::flash('error', 'Debes iniciar sesión para continuar.');
                self::redirect($appUrl, '/login');
            }

            $user = Session::get('user');
            $userRole = is_array($user) ? (string) ($user['role'] ?? '') : '';
            $userLevel = (int) ($roles[$userRole] ?? 0);
            $needed = (int) $roles[$minRole];

            if ($userLevel < $needed) {
                Session::flash('error', 'No tienes permiso para acceder a esta sección.');
                self::redirect($appUrl, '/inicio');
            }

            return;
        }

        throw new \InvalidArgumentException("Regla de middleware no soportada: {$rule}");
    }

    private static function isLoggedIn(): bool
    {
        $user = Session::get('user');

        return is_array($user) && isset($user['id']);
    }

    private static function redirect(string $appUrl, string $path): void
    {
        $target = str_starts_with($path, 'http')
            ? $path
            : $appUrl . '/' . ltrim($path, '/');
        header('Location: ' . $target);
        exit;
    }
}
