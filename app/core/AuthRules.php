<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Reglas compartidas de validación para login y registro.
 * Deben coincidir con public/assets/js/auth-validation.js
 */
final class AuthRules
{
    /** Dominios de correo permitidos (proyecto escolar + cuentas demo). */
    public const EMAIL_DOMAINS = [
        'gmail.com',
        'hotmail.com',
        'outlook.com',
        'yahoo.com',
        'live.com',
        'icloud.com',
        'msn.com',
        'proton.me',
        'protonmail.com',
        'lumen.local', // admin@lumen.local / escritor@lumen.local
    ];

    public const USERNAME_MIN = 3;
    public const USERNAME_MAX = 20;
    public const DISPLAY_NAME_MIN = 2;
    public const DISPLAY_NAME_MAX = 40;
    public const PASSWORD_MIN = 8;
    public const PASSWORD_MAX = 72;

    /** @return list<string> */
    public static function emailDomains(): array
    {
        return self::EMAIL_DOMAINS;
    }

    public static function emailDomainsHint(): string
    {
        return 'Gmail, Hotmail, Outlook, Yahoo, Live, iCloud, Proton o lumen.local (demo).';
    }

    public static function validateEmail(string $email): ?string
    {
        $email = trim($email);

        if ($email === '') {
            return 'El correo es obligatorio.';
        }

        if (strlen($email) > 190 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Escribe un correo válido con @ (ejemplo: nombre@gmail.com).';
        }

        $at = strrpos($email, '@');
        if ($at === false) {
            return 'El correo debe incluir @ y un dominio.';
        }

        $domain = strtolower(substr($email, $at + 1));
        if (!in_array($domain, self::EMAIL_DOMAINS, true)) {
            return 'Solo se permiten correos de: ' . self::emailDomainsHint();
        }

        return null;
    }

    public static function validatePassword(string $password, bool $requireStrength = true): ?string
    {
        if ($password === '') {
            return 'La contraseña es obligatoria.';
        }

        if (!$requireStrength) {
            return null;
        }

        if (strlen($password) < self::PASSWORD_MIN) {
            return 'Mínimo ' . self::PASSWORD_MIN . ' caracteres.';
        }

        if (strlen($password) > self::PASSWORD_MAX) {
            return 'Máximo ' . self::PASSWORD_MAX . ' caracteres.';
        }

        if (!preg_match('/[a-z]/', $password)) {
            return 'Incluye al menos una letra minúscula.';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return 'Incluye al menos una letra mayúscula.';
        }

        if (!preg_match('/\d/', $password)) {
            return 'Incluye al menos un número.';
        }

        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            return 'Incluye al menos un carácter especial (!@#$%…).';
        }

        return null;
    }

    public static function validatePasswordConfirm(string $password, string $confirm): ?string
    {
        if ($confirm === '') {
            return 'Confirma tu contraseña.';
        }

        if ($password !== $confirm) {
            return 'Las contraseñas no coinciden.';
        }

        return null;
    }

    public static function validateUsername(string $username): ?string
    {
        $username = trim($username);

        if ($username === '') {
            return 'El nombre de usuario es obligatorio.';
        }

        $len = strlen($username);
        if ($len < self::USERNAME_MIN || $len > self::USERNAME_MAX) {
            return 'Usuario: entre ' . self::USERNAME_MIN . ' y ' . self::USERNAME_MAX . ' caracteres.';
        }

        if (preg_match('/^[0-9]/', $username) === 1) {
            return 'No puede empezar con un número.';
        }

        if (preg_match('/^[^a-zA-Z]/', $username) === 1) {
            return 'Debe empezar con una letra (A–Z).';
        }

        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $username)) {
            return 'Solo letras, números y guion bajo (_). Sin espacios ni símbolos.';
        }

        return null;
    }

    public static function validateDisplayName(string $displayName): ?string
    {
        $displayName = trim($displayName);

        if ($displayName === '') {
            return 'El nombre visible es obligatorio.';
        }

        $len = mb_strlen($displayName);
        if ($len < self::DISPLAY_NAME_MIN || $len > self::DISPLAY_NAME_MAX) {
            return 'Nombre visible: entre ' . self::DISPLAY_NAME_MIN . ' y ' . self::DISPLAY_NAME_MAX . ' caracteres.';
        }

        if (!preg_match('/^\p{L}/u', $displayName)) {
            return 'El nombre visible debe empezar con una letra.';
        }

        if (!preg_match('/^[\p{L}][\p{L}\p{N}\s.\'\-]*$/u', $displayName)) {
            return 'Usa letras, espacios y (opcional) punto, apóstrofe o guion.';
        }

        return null;
    }
}
