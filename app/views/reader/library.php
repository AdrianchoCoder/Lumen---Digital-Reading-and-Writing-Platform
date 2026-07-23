<?php
/** @var string $appUrl */
/** @var list<array> $books */

$count = count($books);
?>
<section class="home-hero library-hero">
    <div class="home-hero-copy">
        <p class="eyebrow">Biblioteca</p>
        <h1>Tu biblioteca</h1>
        <p class="lead">
            <?= $count === 0
                ? 'Las obras que guardes desde Descubrir o la ficha de cada libro aparecerán aquí.'
                : ($count === 1
                    ? 'Tienes 1 historia guardada. Abre una portada para seguir leyendo.'
                    : 'Tienes ' . $count . ' historias guardadas. Abre una portada para seguir leyendo.') ?>
        </p>
        <div class="home-hero-actions">
            <a class="btn" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Descubrir más</a>
        </div>
    </div>
</section>

<section class="stack-section home-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Guardadas</p>
            <h2>Tus historias</h2>
        </div>
        <?php if ($count > 0): ?>
            <a class="section-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Añadir más</a>
        <?php endif; ?>
    </div>

    <?php if ($books === []): ?>
        <div class="empty-panel">
            <p class="empty-panel-title">Tu biblioteca está vacía</p>
            <p class="empty">Explora el catálogo y guarda las historias que quieras leer más tarde.</p>
            <a class="btn btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Ir a Descubrir</a>
        </div>
    <?php else: ?>
        <div class="book-grid">
            <?php foreach ($books as $book): ?>
                <?php
                $bookId = (int) $book['id'];
                $hue = $bookId * 47 % 360;
                $genre = (string) ($book['genre'] ?? '');
                ?>
                <article class="library-card">
                    <a
                        class="story-card"
                        href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/libros/<?= $bookId ?>"
                    >
                        <span class="story-cover" style="--cover-hue: <?= $hue ?>">
                            <span class="story-cover-title"><?= htmlspecialchars(mb_strimwidth($book['title'], 0, 48, '…'), ENT_QUOTES, 'UTF-8') ?></span>
                        </span>
                        <span class="story-meta">
                            <strong><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                            <span><?= htmlspecialchars($book['author_name'], ENT_QUOTES, 'UTF-8') ?></span>
                            <?php if ($genre !== ''): ?>
                                <em class="genre-chip"><?= htmlspecialchars($genre, ENT_QUOTES, 'UTF-8') ?></em>
                            <?php endif; ?>
                        </span>
                    </a>
                    <form
                        class="library-remove"
                        method="post"
                        action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/biblioteca/quitar/<?= $bookId ?>"
                    >
                        <?= \App\Core\Csrf::field() ?>
                        <button type="submit" class="library-remove-btn" title="Quitar de biblioteca">
                            Quitar
                        </button>
                    </form>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
