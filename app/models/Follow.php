<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Follow
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getInstance()->pdo();
    }

    public function isFollowing(int $followerId, int $followedId): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT 1 FROM follows WHERE follower_id = :follower AND followed_id = :followed LIMIT 1'
        );
        $stmt->execute([
            'follower' => $followerId,
            'followed' => $followedId,
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public function follow(int $followerId, int $followedId): void
    {
        if ($followerId === $followedId) {
            return;
        }

        $stmt = $this->pdo->prepare(
            'INSERT IGNORE INTO follows (follower_id, followed_id) VALUES (:follower, :followed)'
        );
        $stmt->execute([
            'follower' => $followerId,
            'followed' => $followedId,
        ]);
    }

    public function unfollow(int $followerId, int $followedId): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM follows WHERE follower_id = :follower AND followed_id = :followed'
        );
        $stmt->execute([
            'follower' => $followerId,
            'followed' => $followedId,
        ]);
    }

    public function countFollowers(int $userId): int
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM follows WHERE followed_id = :id');
        $stmt->execute(['id' => $userId]);

        return (int) $stmt->fetchColumn();
    }

    public function countFollowing(int $userId): int
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM follows WHERE follower_id = :id');
        $stmt->execute(['id' => $userId]);

        return (int) $stmt->fetchColumn();
    }

    /** @return list<array> */
    public function followingUsers(int $followerId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT u.id, u.username, u.display_name, u.role, u.bio
             FROM follows f
             INNER JOIN users u ON u.id = f.followed_id
             WHERE f.follower_id = :id
             ORDER BY f.created_at DESC'
        );
        $stmt->execute(['id' => $followerId]);

        return $stmt->fetchAll();
    }
}
