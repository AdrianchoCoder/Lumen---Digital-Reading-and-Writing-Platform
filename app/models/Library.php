<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Library
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getInstance()->pdo();
    }

    public function has(int $userId, int $bookId): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT 1 FROM library WHERE user_id = :user_id AND book_id = :book_id LIMIT 1'
        );
        $stmt->execute(['user_id' => $userId, 'book_id' => $bookId]);

        return (bool) $stmt->fetchColumn();
    }

    public function add(int $userId, int $bookId): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT IGNORE INTO library (user_id, book_id) VALUES (:user_id, :book_id)'
        );
        $stmt->execute(['user_id' => $userId, 'book_id' => $bookId]);
    }

    public function remove(int $userId, int $bookId): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM library WHERE user_id = :user_id AND book_id = :book_id'
        );
        $stmt->execute(['user_id' => $userId, 'book_id' => $bookId]);
    }

    /** @return list<array> */
    public function booksForUser(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT b.id, b.title, b.synopsis, b.genre, b.created_at,
                    u.username AS author_username, u.display_name AS author_name,
                    l.created_at AS saved_at
             FROM library l
             INNER JOIN books b ON b.id = l.book_id
             INNER JOIN users u ON u.id = b.author_id
             WHERE l.user_id = :user_id AND b.status = \'publicado\'
             ORDER BY l.created_at DESC'
        );
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll();
    }
}
