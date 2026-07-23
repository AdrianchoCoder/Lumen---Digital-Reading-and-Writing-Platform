<?php
/** @var string $appUrl */
/** @var array $authUser */
/** @var list<array> $following */
/** @var list<array> $latest */

$displayName = (string) ($authUser['display_name'] ?? 'lector');
$firstName = trim(explode(' ', $displayName)[0] ?: $displayName);
?>
<section class="home-hero">
    <div class="home-hero-copy">
        <p class="eyebrow">Tu espacio</p>
        <h1>Hola, <?= htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="lead">Historias frescas y las personas que sigues — todo en un solo lugar.</p>
        <div class="home-hero-actions">
            <a class="btn" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Descubrir</a>
            <a class="btn btn-ghost" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/biblioteca">Biblioteca</a>
        </div>
    </div>
</section>

<section class="stack-section home-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Para ti</p>
            <h2>Recién publicadas</h2>
        </div>
        <a class="section-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Ver más</a>
    </div>

    <?php if ($latest === []): ?>
        <div class="empty-panel">
            <p class="empty-panel-title">Aún no hay historias publicadas</p>
            <p class="empty">Cuando haya novedades aparecerán aquí. Mientras tanto, explora Descubrir.</p>
            <a class="btn btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Ir a Descubrir</a>
        </div>
    <?php else: ?>
        <div class="book-grid">
            <?php foreach ($latest as $book): ?>
                <?php
                $bookId = (int) $book['id'];
                $hue = $bookId * 47 % 360;
                $genre = (string) ($book['genre'] ?? '');
                ?>
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
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<section class="stack-section home-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Comunidad</p>
            <h2>Siguiendo</h2>
        </div>
        <a class="section-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Encontrar autores</a>
    </div>

    <?php if ($following === []): ?>
        <div class="empty-panel">
            <p class="empty-panel-title">Todavía no sigues a nadie</p>
            <p class="empty">Sigue escritores para verlos aquí y no perderte sus historias.</p>
            <a class="btn btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Explorar escritores</a>
        </div>
    <?php else: ?>
        <div class="follow-rail" tabindex="0">
            <?php foreach ($following as $person): ?>
                <?php
                $label = (string) ($person['display_name'] ?? $person['username'] ?? '?');
                $initial = mb_strtoupper(mb_substr($label, 0, 1));
                ?>
                <a
                    class="follow-chip"
                    href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/u/<?= htmlspecialchars(rawurlencode($person['username']), ENT_QUOTES, 'UTF-8') ?>"
                >
                    <span class="follow-avatar" aria-hidden="true"><?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="follow-text">
                        <strong><?= htmlspecialchars($person['display_name'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span>@<?= htmlspecialchars($person['username'], ENT_QUOTES, 'UTF-8') ?></span>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
