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

    public function findByIdForAuthor(int $bookId, int $authorId): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM books WHERE id = :id AND author_id = :author_id LIMIT 1'
        );
        $stmt->execute(['id' => $bookId, 'author_id' => $authorId]);
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
    public function allByAuthor(int $authorId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT b.*,
                    (SELECT COUNT(*) FROM chapters c WHERE c.book_id = b.id) AS chapters_count
             FROM books b
             WHERE b.author_id = :author_id
             ORDER BY b.updated_at DESC'
        );
        $stmt->execute(['author_id' => $authorId]);

        return $stmt->fetchAll();
    }

    public function create(int $authorId, string $title, ?string $synopsis, ?string $genre, string $status): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO books (author_id, title, synopsis, genre, status)
             VALUES (:author_id, :title, :synopsis, :genre, :status)'
        );
        $stmt->execute([
            'author_id' => $authorId,
            'title'     => $title,
            'synopsis'  => $synopsis,
            'genre'     => $genre,
            'status'    => $status,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $bookId, int $authorId, string $title, ?string $synopsis, ?string $genre, string $status): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE books
             SET title = :title, synopsis = :synopsis, genre = :genre, status = :status
             WHERE id = :id AND author_id = :author_id'
        );
        $stmt->execute([
            'title'     => $title,
            'synopsis'  => $synopsis,
            'genre'     => $genre,
            'status'    => $status,
            'id'        => $bookId,
            'author_id' => $authorId,
        ]);
    }

    /** @return list<array> */
    public function chaptersForBook(int $bookId, bool $onlyPublished = true): array
    {
        $sql = 'SELECT id, number, title, status, created_at, updated_at
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

    public function findChapterForAuthor(int $bookId, int $chapterId, int $authorId): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT c.*
             FROM chapters c
             INNER JOIN books b ON b.id = c.book_id
             WHERE c.id = :chapter_id AND c.book_id = :book_id AND b.author_id = :author_id
             LIMIT 1'
        );
        $stmt->execute([
            'chapter_id' => $chapterId,
            'book_id'    => $bookId,
            'author_id'  => $authorId,
        ]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function nextChapterNumber(int $bookId): int
    {
        $stmt = $this->pdo->prepare('SELECT COALESCE(MAX(number), 0) + 1 FROM chapters WHERE book_id = :book_id');
        $stmt->execute(['book_id' => $bookId]);

        return (int) $stmt->fetchColumn();
    }

    public function createChapter(int $bookId, int $number, string $title, string $content, string $status): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO chapters (book_id, number, title, content, status)
             VALUES (:book_id, :number, :title, :content, :status)'
        );
        $stmt->execute([
            'book_id' => $bookId,
            'number'  => $number,
            'title'   => $title,
            'content' => $content,
            'status'  => $status,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function updateChapter(int $chapterId, int $bookId, string $title, string $content, string $status): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE chapters
             SET title = :title, content = :content, status = :status
             WHERE id = :id AND book_id = :book_id'
        );
        $stmt->execute([
            'title'   => $title,
            'content' => $content,
            'status'  => $status,
            'id'      => $chapterId,
            'book_id' => $bookId,
        ]);
    }

    /** @return array{books_total:int,books_published:int,books_draft:int,chapters_total:int,library_saves:int} */
    public function statsForAuthor(int $authorId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT
                COUNT(*) AS books_total,
                SUM(CASE WHEN status = \'publicado\' THEN 1 ELSE 0 END) AS books_published,
                SUM(CASE WHEN status = \'borrador\' THEN 1 ELSE 0 END) AS books_draft
             FROM books WHERE author_id = :author_id'
        );
        $stmt->execute(['author_id' => $authorId]);
        $books = $stmt->fetch() ?: [];

        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) FROM chapters c
             INNER JOIN books b ON b.id = c.book_id
             WHERE b.author_id = :author_id'
        );
        $stmt->execute(['author_id' => $authorId]);
        $chapters = (int) $stmt->fetchColumn();

        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) FROM library l
             INNER JOIN books b ON b.id = l.book_id
             WHERE b.author_id = :author_id'
        );
        $stmt->execute(['author_id' => $authorId]);
        $saves = (int) $stmt->fetchColumn();

        return [
            'books_total'     => (int) ($books['books_total'] ?? 0),
            'books_published' => (int) ($books['books_published'] ?? 0),
            'books_draft'     => (int) ($books['books_draft'] ?? 0),
            'chapters_total'  => $chapters,
            'library_saves'   => $saves,
        ];
    }

    /** @return list<array> */
    public function listForAdmin(?string $query = null, int $limit = 40): array
    {
        $limit = max(1, min(100, $limit));
        $sql = 'SELECT b.id, b.title, b.genre, b.status, b.created_at,
                       u.username AS author_username, u.display_name AS author_name
                FROM books b
                INNER JOIN users u ON u.id = b.author_id';
        $params = [];

        if ($query !== null && $query !== '') {
            $sql .= ' WHERE b.title LIKE :q OR u.username LIKE :q OR u.display_name LIKE :q';
            $params['q'] = '%' . $query . '%';
        }

        $sql .= ' ORDER BY b.updated_at DESC LIMIT ' . $limit;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM books WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function setStatus(int $bookId, string $status): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE books SET status = :status WHERE id = :id'
        );
        $stmt->execute([
            'status' => $status,
            'id'     => $bookId,
        ]);
    }

    public function countAll(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM books')->fetchColumn();
    }
}
