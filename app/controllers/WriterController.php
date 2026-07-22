<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Book;
use App\Models\Community;
use App\Models\Follow;
use PDOException;

/**
 * Área del escritor: historias, capítulos, comunidades y estadísticas.
 */
final class WriterController extends Controller
{
    private Book $books;
    private Community $communities;
    private Follow $follows;

    private const BOOK_STATUSES = ['borrador', 'publicado', 'archivado'];
    private const CHAPTER_STATUSES = ['borrador', 'publicado'];

    public function __construct()
    {
        parent::__construct();
        $this->books = new Book();
        $this->communities = new Community();
        $this->follows = new Follow();
    }

    public function hub(): void
    {
        $auth = $this->requireMinRole('escritor');
        $stats = $this->books->statsForAuthor((int) $auth['id']);
        $stats['followers'] = $this->follows->countFollowers((int) $auth['id']);
        $stats['communities'] = $this->communities->countByOwner((int) $auth['id']);

        $this->view('writer/hub', [
            'title' => 'Escribir',
            'stats' => $stats,
            'books' => $this->books->allByAuthor((int) $auth['id']),
        ], 'app');
    }

    public function books(): void
    {
        $auth = $this->requireMinRole('escritor');

        $this->view('writer/books', [
            'title' => 'Mis libros',
            'books' => $this->books->allByAuthor((int) $auth['id']),
        ], 'app');
    }

    public function createBookForm(): void
    {
        $this->requireMinRole('escritor');

        $this->view('writer/book-form', [
            'title'  => 'Nueva historia',
            'mode'   => 'create',
            'book'   => [
                'title'    => '',
                'synopsis' => '',
                'genre'    => '',
                'status'   => 'borrador',
            ],
            'errors' => [],
        ], 'app');
    }

    public function storeBook(): void
    {
        $auth = $this->requireMinRole('escritor');

        if (!$this->assertCsrf()) {
            return;
        }

        [$data, $errors] = $this->validateBookInput();

        if ($errors !== []) {
            $this->view('writer/book-form', [
                'title'  => 'Nueva historia',
                'mode'   => 'create',
                'book'   => $data,
                'errors' => $errors,
            ], 'app');
            return;
        }

        $id = $this->books->create(
            (int) $auth['id'],
            $data['title'],
            $data['synopsis'] !== '' ? $data['synopsis'] : null,
            $data['genre'] !== '' ? $data['genre'] : null,
            $data['status']
        );

        Session::flash('success', 'Historia creada.');
        $this->redirect('/escribir/libros/' . $id);
    }

    public function showBook(string $id): void
    {
        $auth = $this->requireMinRole('escritor');
        $book = $this->books->findByIdForAuthor((int) $id, (int) $auth['id']);

        if ($book === null) {
            Session::flash('error', 'Historia no encontrada.');
            $this->redirect('/escribir/libros');
        }

        $this->view('writer/book-manage', [
            'title'    => $book['title'],
            'book'     => $book,
            'chapters' => $this->books->chaptersForBook((int) $book['id'], false),
            'errors'   => [],
        ], 'app');
    }

    public function updateBook(string $id): void
    {
        $auth = $this->requireMinRole('escritor');

        if (!$this->assertCsrf()) {
            return;
        }

        $bookId = (int) $id;
        $book = $this->books->findByIdForAuthor($bookId, (int) $auth['id']);

        if ($book === null) {
            Session::flash('error', 'Historia no encontrada.');
            $this->redirect('/escribir/libros');
        }

        [$data, $errors] = $this->validateBookInput();

        if ($errors !== []) {
            $this->view('writer/book-manage', [
                'title'    => $book['title'],
                'book'     => array_merge($book, $data),
                'chapters' => $this->books->chaptersForBook($bookId, false),
                'errors'   => $errors,
            ], 'app');
            return;
        }

        $this->books->update(
            $bookId,
            (int) $auth['id'],
            $data['title'],
            $data['synopsis'] !== '' ? $data['synopsis'] : null,
            $data['genre'] !== '' ? $data['genre'] : null,
            $data['status']
        );

        Session::flash('success', 'Historia actualizada.');
        $this->redirect('/escribir/libros/' . $bookId);
    }

    public function createChapterForm(string $bookId): void
    {
        $auth = $this->requireMinRole('escritor');
        $book = $this->books->findByIdForAuthor((int) $bookId, (int) $auth['id']);

        if ($book === null) {
            Session::flash('error', 'Historia no encontrada.');
            $this->redirect('/escribir/libros');
        }

        $this->view('writer/chapter-form', [
            'title'   => 'Nuevo capítulo',
            'mode'    => 'create',
            'book'    => $book,
            'chapter' => [
                'title'   => '',
                'content' => '',
                'status'  => 'borrador',
                'number'  => $this->books->nextChapterNumber((int) $book['id']),
            ],
            'errors'  => [],
        ], 'app');
    }

    public function storeChapter(string $bookId): void
    {
        $auth = $this->requireMinRole('escritor');

        if (!$this->assertCsrf()) {
            return;
        }

        $bId = (int) $bookId;
        $book = $this->books->findByIdForAuthor($bId, (int) $auth['id']);

        if ($book === null) {
            Session::flash('error', 'Historia no encontrada.');
            $this->redirect('/escribir/libros');
        }

        [$data, $errors] = $this->validateChapterInput();

        if ($errors !== []) {
            $this->view('writer/chapter-form', [
                'title'   => 'Nuevo capítulo',
                'mode'    => 'create',
                'book'    => $book,
                'chapter' => array_merge($data, [
                    'number' => $this->books->nextChapterNumber($bId),
                ]),
                'errors'  => $errors,
            ], 'app');
            return;
        }

        $number = $this->books->nextChapterNumber($bId);
        $this->books->createChapter($bId, $number, $data['title'], $data['content'], $data['status']);

        Session::flash('success', 'Capítulo creado.');
        $this->redirect('/escribir/libros/' . $bId);
    }

    public function editChapterForm(string $bookId, string $chapterId): void
    {
        $auth = $this->requireMinRole('escritor');
        $bId = (int) $bookId;
        $cId = (int) $chapterId;

        $book = $this->books->findByIdForAuthor($bId, (int) $auth['id']);
        $chapter = $this->books->findChapterForAuthor($bId, $cId, (int) $auth['id']);

        if ($book === null || $chapter === null) {
            Session::flash('error', 'Capítulo no encontrado.');
            $this->redirect('/escribir/libros');
        }

        $this->view('writer/chapter-form', [
            'title'   => 'Editar capítulo',
            'mode'    => 'edit',
            'book'    => $book,
            'chapter' => $chapter,
            'errors'  => [],
        ], 'app');
    }

    public function updateChapter(string $bookId, string $chapterId): void
    {
        $auth = $this->requireMinRole('escritor');

        if (!$this->assertCsrf()) {
            return;
        }

        $bId = (int) $bookId;
        $cId = (int) $chapterId;
        $book = $this->books->findByIdForAuthor($bId, (int) $auth['id']);
        $chapter = $this->books->findChapterForAuthor($bId, $cId, (int) $auth['id']);

        if ($book === null || $chapter === null) {
            Session::flash('error', 'Capítulo no encontrado.');
            $this->redirect('/escribir/libros');
        }

        [$data, $errors] = $this->validateChapterInput();

        if ($errors !== []) {
            $this->view('writer/chapter-form', [
                'title'   => 'Editar capítulo',
                'mode'    => 'edit',
                'book'    => $book,
                'chapter' => array_merge($chapter, $data),
                'errors'  => $errors,
            ], 'app');
            return;
        }

        $this->books->updateChapter($cId, $bId, $data['title'], $data['content'], $data['status']);
        Session::flash('success', 'Capítulo actualizado.');
        $this->redirect('/escribir/libros/' . $bId);
    }

    public function communities(): void
    {
        $auth = $this->requireMinRole('escritor');

        $this->view('writer/communities', [
            'title'       => 'Comunidades',
            'communities' => $this->communities->byOwner((int) $auth['id']),
        ], 'app');
    }

    public function createCommunityForm(): void
    {
        $this->requireMinRole('escritor');

        $this->view('writer/community-form', [
            'title'     => 'Nueva comunidad',
            'community' => ['name' => '', 'description' => ''],
            'errors'    => [],
        ], 'app');
    }

    public function storeCommunity(): void
    {
        $auth = $this->requireMinRole('escritor');

        if (!$this->assertCsrf()) {
            return;
        }

        $name = $this->stringInput('name');
        $description = $this->stringInput('description');
        $errors = [];

        if ($name === '' || mb_strlen($name) < 3 || mb_strlen($name) > 120) {
            $errors['name'] = 'El nombre debe tener entre 3 y 120 caracteres.';
        } elseif ($this->communities->nameExists($name)) {
            $errors['name'] = 'Ya existe una comunidad con ese nombre.';
        }

        if (mb_strlen($description) > 2000) {
            $errors['description'] = 'La descripción no puede superar 2000 caracteres.';
        }

        if ($errors !== []) {
            $this->view('writer/community-form', [
                'title'     => 'Nueva comunidad',
                'community' => ['name' => $name, 'description' => $description],
                'errors'    => $errors,
            ], 'app');
            return;
        }

        try {
            $this->communities->create(
                (int) $auth['id'],
                $name,
                $description !== '' ? $description : null
            );
        } catch (PDOException) {
            Session::flash('error', 'No se pudo crear la comunidad (¿nombre duplicado?).');
            $this->redirect('/escribir/comunidades/nueva');
        }

        Session::flash('success', 'Comunidad creada.');
        $this->redirect('/escribir/comunidades');
    }

    public function toggleCommunity(string $id): void
    {
        $auth = $this->requireMinRole('escritor');

        if (!$this->assertCsrf()) {
            return;
        }

        $community = $this->communities->findByIdForOwner((int) $id, (int) $auth['id']);

        if ($community === null) {
            Session::flash('error', 'Comunidad no encontrada.');
            $this->redirect('/escribir/comunidades');
        }

        $newActive = !((int) $community['is_active'] === 1);
        $this->communities->setActive((int) $id, (int) $auth['id'], $newActive);

        Session::flash('success', $newActive ? 'Comunidad activada.' : 'Comunidad desactivada.');
        $this->redirect('/escribir/comunidades');
    }

    public function stats(): void
    {
        $auth = $this->requireMinRole('escritor');
        $stats = $this->books->statsForAuthor((int) $auth['id']);
        $stats['followers'] = $this->follows->countFollowers((int) $auth['id']);
        $stats['following'] = $this->follows->countFollowing((int) $auth['id']);
        $stats['communities'] = $this->communities->countByOwner((int) $auth['id']);

        $this->view('writer/stats', [
            'title' => 'Estadísticas',
            'stats' => $stats,
        ], 'app');
    }

    /** @return array{0: array{title:string,synopsis:string,genre:string,status:string}, 1: array<string,string>} */
    private function validateBookInput(): array
    {
        $title = $this->stringInput('title');
        $synopsis = $this->stringInput('synopsis');
        $genre = $this->stringInput('genre');
        $status = $this->stringInput('status');
        $errors = [];

        if ($title === '' || mb_strlen($title) > 200) {
            $errors['title'] = 'El título es obligatorio (máx. 200).';
        }

        if (mb_strlen($synopsis) > 5000) {
            $errors['synopsis'] = 'La sinopsis es demasiado larga.';
        }

        if (mb_strlen($genre) > 80) {
            $errors['genre'] = 'El género no puede superar 80 caracteres.';
        }

        if (!in_array($status, self::BOOK_STATUSES, true)) {
            $errors['status'] = 'Estado inválido.';
            $status = 'borrador';
        }

        return [
            [
                'title'    => $title,
                'synopsis' => $synopsis,
                'genre'    => $genre,
                'status'   => $status,
            ],
            $errors,
        ];
    }

    /** @return array{0: array{title:string,content:string,status:string}, 1: array<string,string>} */
    private function validateChapterInput(): array
    {
        $title = $this->stringInput('title');
        $content = $this->stringInput('content');
        $status = $this->stringInput('status');
        $errors = [];

        if ($title === '' || mb_strlen($title) > 200) {
            $errors['title'] = 'El título es obligatorio (máx. 200).';
        }

        if ($content === '' || mb_strlen($content) < 20) {
            $errors['content'] = 'El contenido debe tener al menos 20 caracteres.';
        }

        if (!in_array($status, self::CHAPTER_STATUSES, true)) {
            $errors['status'] = 'Estado inválido.';
            $status = 'borrador';
        }

        return [
            [
                'title'   => $title,
                'content' => $content,
                'status'  => $status,
            ],
            $errors,
        ];
    }
}
