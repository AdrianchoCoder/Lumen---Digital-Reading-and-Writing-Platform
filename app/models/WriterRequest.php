<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Solicitudes para convertirse en escritor.
 */
final class WriterRequest
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getInstance()->pdo();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM writer_requests WHERE id = :id LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function latestForUser(int $userId): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM writer_requests
             WHERE user_id = :user_id
             ORDER BY created_at DESC
             LIMIT 1'
        );
        $stmt->execute(['user_id' => $userId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function hasPendingForUser(int $userId): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT 1 FROM writer_requests
             WHERE user_id = :user_id AND status = \'pendiente\'
             LIMIT 1'
        );
        $stmt->execute(['user_id' => $userId]);

        return (bool) $stmt->fetchColumn();
    }

    public function create(int $userId, string $motivation): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO writer_requests (user_id, motivation, status)
             VALUES (:user_id, :motivation, \'pendiente\')'
        );
        $stmt->execute([
            'user_id'    => $userId,
            'motivation' => $motivation,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /** @return list<array> */
    public function historyForUser(int $userId, int $limit = 5): array
    {
        $limit = max(1, min(20, $limit));
        $stmt = $this->pdo->prepare(
            'SELECT id, motivation, status, admin_note, reviewed_at, created_at
             FROM writer_requests
             WHERE user_id = :user_id
             ORDER BY created_at DESC
             LIMIT ' . $limit
        );
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll();
    }
}
