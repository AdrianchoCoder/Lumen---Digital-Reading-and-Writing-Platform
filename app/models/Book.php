<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Book
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getInstance()->pdo();
    }

    public function findPublishedById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT b.*, u.username AS author_username, u.display_name AS author_name, u.id AS author_user_id
             FROM books b
             INNER JOIN users u ON u.id = b.author_id
             WHERE b.id = :id AND b.status = \'publicado\'
             LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    /** @return list<array> */
    public function searchPublished(?string $query = null, int $limit = 24): array
    {
        $limit = max(1, min(50, $limit));
        $sql = 'SELECT b.id, b.title, b.synopsis, b.genre, b.created_at,
                       u.username AS author_username, u.display_name AS author_name
                FROM books b
                INNER JOIN users u ON u.id = b.author_id
                WHERE b.status = \'publicado\'';
        $params = [];

        if ($query !== null && $query !== '') {
            $sql .= ' AND (b.title LIKE :q OR b.genre LIKE :q OR u.display_name LIKE :q OR u.username LIKE :q)';
            $params['q'] = '%' . $query . '%';
        }

        $sql .= ' ORDER BY b.created_at DESC LIMIT ' . $limit;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /** @return list<array> */
    public function latestPublished(int $limit = 6): array
    {
        return $this->searchPublished(null, $limit);
    }

    /** @return list<array> */
    public function publishedByAuthor(int $authorId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, title, synopsis, genre, created_at
             FROM books
             WHERE author_id = :author_id AND status = \'publicado\'
             ORDER BY created_at DESC'
        );
        $stmt->execute(['author_id' => $authorId]);

        return $stmt->fetchAll();
    }

    /** @return list<array> */
    public function chaptersForBook(int $bookId, bool $onlyPublished = true): array
    {
        $sql = 'SELECT id, number, title, status, created_at
                FROM chapters
                WHERE book_id = :book_id';

        if ($onlyPublished) {
            $sql .= ' AND status = \'publicado\'';
        }

        $sql .= ' ORDER BY number ASC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['book_id' => $bookId]);

        return $stmt->fetchAll();
    }

    public function findChapter(int $bookId, int $chapterId): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, book_id, number, title, content, status
             FROM chapters
             WHERE id = :id AND book_id = :book_id AND status = \'publicado\'
             LIMIT 1'
        );
        $stmt->execute(['id' => $chapterId, 'book_id' => $bookId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }
}
