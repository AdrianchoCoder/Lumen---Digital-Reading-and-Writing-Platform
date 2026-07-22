<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Acceso a la tabla users.
 */
final class User
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getInstance()->pdo();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, username, email, password_hash, display_name, bio, avatar_path, role, is_active, created_at
             FROM users WHERE id = :id LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, username, email, password_hash, display_name, bio, avatar_path, role, is_active, created_at
             FROM users WHERE email = :email LIMIT 1'
        );
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, username, email, password_hash, display_name, bio, avatar_path, role, is_active, created_at
             FROM users WHERE username = :username LIMIT 1'
        );
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    /**
     * Crea un usuario con rol lector (registro público).
     *
     * @return int ID del nuevo usuario
     */
    public function createReader(string $username, string $email, string $passwordHash, string $displayName): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (username, email, password_hash, display_name, role)
             VALUES (:username, :email, :password_hash, :display_name, \'lector\')'
        );

        $stmt->execute([
            'username'      => $username,
            'email'         => $email,
            'password_hash' => $passwordHash,
            'display_name'  => $displayName,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Actualiza datos básicos del perfil (nombre visible y bio).
     */
    public function updateProfile(int $userId, string $displayName, ?string $bio): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE users SET display_name = :display_name, bio = :bio WHERE id = :id'
        );
        $stmt->execute([
            'display_name' => $displayName,
            'bio'          => $bio,
            'id'           => $userId,
        ]);
    }

    /** @return list<array> */
    public function searchWriters(?string $query = null, int $limit = 12): array
    {
        $limit = max(1, min(30, $limit));
        $sql = 'SELECT id, username, display_name, bio, role
                FROM users
                WHERE is_active = 1 AND role IN (\'escritor\', \'administrador\')';
        $params = [];

        if ($query !== null && $query !== '') {
            $sql .= ' AND (username LIKE :q OR display_name LIKE :q)';
            $params['q'] = '%' . $query . '%';
        }

        $sql .= ' ORDER BY display_name ASC LIMIT ' . $limit;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
