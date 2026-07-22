<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

final class Community
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getInstance()->pdo();
    }

    /** @return list<array> */
    public function byOwner(int $ownerId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM communities WHERE owner_id = :owner_id ORDER BY created_at DESC'
        );
        $stmt->execute(['owner_id' => $ownerId]);

        return $stmt->fetchAll();
    }

    public function findByIdForOwner(int $id, int $ownerId): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM communities WHERE id = :id AND owner_id = :owner_id LIMIT 1'
        );
        $stmt->execute(['id' => $id, 'owner_id' => $ownerId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(int $ownerId, string $name, ?string $description): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO communities (owner_id, name, description, is_active)
             VALUES (:owner_id, :name, :description, 1)'
        );
        $stmt->execute([
            'owner_id'    => $ownerId,
            'name'        => $name,
            'description' => $description,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function setActive(int $id, int $ownerId, bool $active): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE communities SET is_active = :active WHERE id = :id AND owner_id = :owner_id'
        );
        $stmt->execute([
            'active'   => $active ? 1 : 0,
            'id'       => $id,
            'owner_id' => $ownerId,
        ]);
    }

    public function countByOwner(int $ownerId): int
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM communities WHERE owner_id = :owner_id');
        $stmt->execute(['owner_id' => $ownerId]);

        return (int) $stmt->fetchColumn();
    }

    public function nameExists(string $name, ?int $exceptId = null): bool
    {
        $sql = 'SELECT 1 FROM communities WHERE name = :name';
        $params = ['name' => $name];

        if ($exceptId !== null) {
            $sql .= ' AND id <> :id';
            $params['id'] = $exceptId;
        }

        $sql .= ' LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return (bool) $stmt->fetchColumn();
    }

    /**
     * @throws PDOException
     */
    public function createSafe(int $ownerId, string $name, ?string $description): int
    {
        return $this->create($ownerId, $name, $description);
    }
}
