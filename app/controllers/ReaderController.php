<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Book;
use App\Models\Follow;
use App\Models\Library;
use App\Models\User;

/**
 * Pantallas del rol Lector: Inicio, Descubrir, Biblioteca, Perfil e historias.
 */
final class ReaderController extends Controller
{
    private Book $books;
    private Library $library;
    private Follow $follows;
    private User $users;

    public function __construct()
    {
        parent::__construct();
        $this->books = new Book();
        $this->library = new Library();
        $this->follows = new Follow();
        $this->users = new User();
    }

    public function home(): void
    {
        $user = $this->requireAuth();
        $following = $this->follows->followingUsers((int) $user['id']);
        $latest = $this->books->latestPublished(8);

        $this->view('reader/home', [
            'title'     => 'Inicio',
            'following' => $following,
            'latest'    => $latest,
        ], 'app');
    }

    public function discover(): void
    {
        $this->requireAuth();
        $query = $this->stringInput('q', 'get');
        $books = $this->books->searchPublished($query !== '' ? $query : null);
        $writers = $this->users->searchWriters($query !== '' ? $query : null);

        $this->view('reader/discover', [
            'title'   => 'Descubrir',
            'query'   => $query,
            'books'   => $books,
            'writers' => $writers,
        ], 'app');
    }

    public function library(): void
    {
        $user = $this->requireAuth();
        $books = $this->library->booksForUser((int) $user['id']);

        $this->view('reader/library', [
            'title' => 'Biblioteca',
            'books' => $books,
        ], 'app');
    }

    public function profile(?string $username = null): void
    {
        $auth = $this->requireAuth();
        $username = $username !== null && $username !== '' ? $username : (string) $auth['username'];
        $profile = $this->users->findByUsername($username);

        if ($profile === null || (int) $profile['is_active'] !== 1) {
            Session::flash('error', 'Usuario no encontrado.');
            $this->redirect('/descubrir');
        }

        $profileId = (int) $profile['id'];
        $isOwn = $profileId === (int) $auth['id'];
        $isFollowing = !$isOwn && $this->follows->isFollowing((int) $auth['id'], $profileId);

        $this->view('reader/profile', [
            'title'           => $profile['display_name'],
            'profile'         => $profile,
            'isOwn'           => $isOwn,
            'isFollowing'     => $isFollowing,
            'followersCount'  => $this->follows->countFollowers($profileId),
            'followingCount'  => $this->follows->countFollowing($profileId),
            'authoredBooks'   => $this->books->publishedByAuthor($profileId),
            'errors'          => [],
        ], 'app');
    }

    public function updateProfile(): void
    {
        $auth = $this->requireAuth();

        if (!$this->assertCsrf()) {
            return;
        }

        $displayName = $this->stringInput('display_name');
        $bio = $this->stringInput('bio');
        $errors = [];

        if ($displayName === '' || mb_strlen($displayName) > 100) {
            $errors['display_name'] = 'El nombre visible es obligatorio (máx. 100).';
        }

        if (mb_strlen($bio) > 500) {
            $errors['bio'] = 'La biografía no puede superar 500 caracteres.';
        }

        $profile = $this->users->findById((int) $auth['id']);

        if ($errors !== []) {
            $this->view('reader/profile', [
                'title'          => 'Mi perfil',
                'profile'        => array_merge($profile ?? [], [
                    'display_name' => $displayName,
                    'bio'          => $bio,
                ]),
                'isOwn'          => true,
                'isFollowing'    => false,
                'followersCount' => $this->follows->countFollowers((int) $auth['id']),
                'followingCount' => $this->follows->countFollowing((int) $auth['id']),
                'authoredBooks'  => $this->books->publishedByAuthor((int) $auth['id']),
                'errors'         => $errors,
            ], 'app');
            return;
        }

        $bioValue = $bio === '' ? null : $bio;
        $this->users->updateProfile((int) $auth['id'], $displayName, $bioValue);

        Session::set('user', array_merge($auth, [
            'display_name' => $displayName,
        ]));
        Session::flash('success', 'Se ha actualizado correctamente tu perfil.');
        $this->redirect('/perfil');
    }

    public function showBook(string $id): void
    {
        $auth = $this->requireAuth();
        $bookId = (int) $id;
        $book = $this->books->findPublishedById($bookId);

        if ($book === null) {
            Session::flash('error', 'Historia no encontrada.');
            $this->redirect('/descubrir');
        }

        $chapters = $this->books->chaptersForBook($bookId);
        $inLibrary = $this->library->has((int) $auth['id'], $bookId);
        $isFollowing = $this->follows->isFollowing((int) $auth['id'], (int) $book['author_user_id']);
        $isOwnAuthor = (int) $book['author_user_id'] === (int) $auth['id'];

        $this->view('reader/book', [
            'title'       => $book['title'],
            'book'        => $book,
            'chapters'    => $chapters,
            'inLibrary'   => $inLibrary,
            'isFollowing' => $isFollowing,
            'isOwnAuthor' => $isOwnAuthor,
        ], 'app');
    }

    public function readChapter(string $bookId, string $chapterId): void
    {
        $this->requireAuth();
        $bId = (int) $bookId;
        $cId = (int) $chapterId;

        $book = $this->books->findPublishedById($bId);
        $chapter = $this->books->findChapter($bId, $cId);

        if ($book === null || $chapter === null) {
            Session::flash('error', 'Capítulo no encontrado.');
            $this->redirect('/descubrir');
        }

        $this->view('reader/chapter', [
            'title'   => $chapter['title'],
            'book'    => $book,
            'chapter' => $chapter,
        ], 'app');
    }

    public function addToLibrary(string $bookId): void
    {
        $auth = $this->requireAuth();

        if (!$this->assertCsrf()) {
            return;
        }

        $id = (int) $bookId;
        if ($this->books->findPublishedById($id) === null) {
            Session::flash('error', 'Historia no encontrada.');
            $this->redirect('/descubrir');
        }

        $this->library->add((int) $auth['id'], $id);
        Session::flash('success', 'Historia guardada en tu biblioteca.');
        $this->redirect('/libros/' . $id);
    }

    public function removeFromLibrary(string $bookId): void
    {
        $auth = $this->requireAuth();

        if (!$this->assertCsrf()) {
            return;
        }

        $id = (int) $bookId;
        $this->library->remove((int) $auth['id'], $id);
        Session::flash('success', 'Historia quitada de tu biblioteca.');

        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if (is_string($referer) && str_contains($referer, '/biblioteca')) {
            $this->redirect('/biblioteca');
        }

        $this->redirect('/libros/' . $id);
    }
}
