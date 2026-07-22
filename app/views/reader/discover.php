<?php
/** @var string $appUrl */
/** @var string $query */
/** @var list<array> $books */
/** @var list<array> $writers */
?>
<section>
    <p class="eyebrow">Descubrir</p>
    <h1>Explora historias</h1>
    <form class="search-form" method="get" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">
        <input type="search" name="q" value="<?= htmlspecialchars($query, ENT_QUOTES, 'UTF-8') ?>" placeholder="Buscar por título, género o autor">
        <button type="submit" class="btn">Buscar</button>
    </form>
</section>

<section class="stack-section">
    <h2>Historias</h2>
    <?php if ($books === []): ?>
        <p class="empty">No hay resultados de historias.</p>
    <?php else: ?>
        <ul class="card-list">
            <?php foreach ($books as $book): ?>
                <li>
                    <a class="card-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/libros/<?= (int) $book['id'] ?>">
                        <strong><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span><?= htmlspecialchars($book['author_name'], ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars((string) ($book['genre'] ?? ''), ENT_QUOTES, 'UTF-8') ?></span>
                        <?php if (!empty($book['synopsis'])): ?>
                            <em><?= htmlspecialchars(mb_strimwidth($book['synopsis'], 0, 140, '…'), ENT_QUOTES, 'UTF-8') ?></em>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<section class="stack-section">
    <h2>Escritores</h2>
    <?php if ($writers === []): ?>
        <p class="empty">No hay escritores para mostrar.</p>
    <?php else: ?>
        <ul class="card-list">
            <?php foreach ($writers as $writer): ?>
                <li>
                    <a class="card-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/u/<?= htmlspecialchars(rawurlencode($writer['username']), ENT_QUOTES, 'UTF-8') ?>">
                        <strong><?= htmlspecialchars($writer['display_name'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span>@<?= htmlspecialchars($writer['username'], ENT_QUOTES, 'UTF-8') ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
