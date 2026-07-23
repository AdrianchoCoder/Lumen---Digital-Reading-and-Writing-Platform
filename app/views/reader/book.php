<?php
/** @var string $appUrl */
/** @var array $book */
/** @var list<array> $chapters */
/** @var bool $inLibrary */
/** @var bool $isFollowing */
/** @var bool $isOwnAuthor */

$bookId = (int) $book['id'];
$hue = $bookId * 47 % 360;
$genre = trim((string) ($book['genre'] ?? ''));
$synopsis = trim((string) ($book['synopsis'] ?? ''));
$firstChapter = $chapters[0] ?? null;
$authorProfile = $appUrl . '/u/' . rawurlencode((string) $book['author_username']);
$bookBase = $appUrl . '/libros/' . $bookId;
?>
<section class="story-hero">
    <div class="story-hero-cover" style="--cover-hue: <?= $hue ?>" aria-hidden="true">
        <span class="story-hero-cover-title"><?= htmlspecialchars(mb_strimwidth($book['title'], 0, 56, '…'), ENT_QUOTES, 'UTF-8') ?></span>
    </div>

    <div class="story-hero-copy">
        <?php if ($genre !== ''): ?>
            <p class="eyebrow"><?= htmlspecialchars($genre, ENT_QUOTES, 'UTF-8') ?></p>
        <?php else: ?>
            <p class="eyebrow">Historia</p>
        <?php endif; ?>

        <h1><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></h1>

        <p class="story-byline">
            Por
            <a href="<?= htmlspecialchars($authorProfile, ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($book['author_name'], ENT_QUOTES, 'UTF-8') ?>
            </a>
        </p>

        <?php if ($synopsis !== ''): ?>
            <p class="story-synopsis"><?= nl2br(htmlspecialchars($synopsis, ENT_QUOTES, 'UTF-8')) ?></p>
        <?php endif; ?>

        <div class="story-actions">
            <?php if ($firstChapter !== null): ?>
                <a
                    class="btn"
                    href="<?= htmlspecialchars($bookBase, ENT_QUOTES, 'UTF-8') ?>/capitulos/<?= (int) $firstChapter['id'] ?>"
                >
                    Empezar a leer
                </a>
            <?php endif; ?>

            <?php if ($inLibrary): ?>
                <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/biblioteca/quitar/<?= $bookId ?>">
                    <?= \App\Core\Csrf::field() ?>
                    <button type="submit" class="btn btn-ghost">Quitar de biblioteca</button>
                </form>
            <?php else: ?>
                <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/biblioteca/agregar/<?= $bookId ?>">
                    <?= \App\Core\Csrf::field() ?>
                    <button type="submit" class="btn btn-ghost">Guardar en biblioteca</button>
                </form>
            <?php endif; ?>

            <?php if (!$isOwnAuthor): ?>
                <?php if ($isFollowing): ?>
                    <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/dejar-seguir/<?= (int) $book['author_user_id'] ?>">
                        <?= \App\Core\Csrf::field() ?>
                        <button type="submit" class="btn btn-ghost">Dejar de seguir</button>
                    </form>
                <?php else: ?>
                    <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/seguir/<?= (int) $book['author_user_id'] ?>">
                        <?= \App\Core\Csrf::field() ?>
                        <button type="submit" class="btn btn-ghost">Seguir autor</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="stack-section home-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Índice</p>
            <h2>Capítulos</h2>
        </div>
        <?php if ($chapters !== []): ?>
            <span class="section-meta"><?= count($chapters) === 1 ? '1 capítulo' : count($chapters) . ' capítulos' ?></span>
        <?php endif; ?>
    </div>

    <?php if ($chapters === []): ?>
        <div class="empty-panel">
            <p class="empty-panel-title">Aún no hay capítulos publicados</p>
            <p class="empty">Cuando el autor publique el primero, podrás empezar a leer aquí.</p>
        </div>
    <?php else: ?>
        <ul class="chapter-list">
            <?php foreach ($chapters as $chapter): ?>
                <li>
                    <a
                        class="chapter-row"
                        href="<?= htmlspecialchars($bookBase, ENT_QUOTES, 'UTF-8') ?>/capitulos/<?= (int) $chapter['id'] ?>"
                    >
                        <span class="chapter-num" aria-hidden="true"><?= (int) $chapter['number'] ?></span>
                        <strong class="chapter-title"><?= htmlspecialchars($chapter['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span class="chapter-go">Leer</span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
