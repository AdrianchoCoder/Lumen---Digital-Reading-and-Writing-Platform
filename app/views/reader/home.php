<?php
/** @var string $appUrl */
/** @var array $authUser */
/** @var list<array> $following */
/** @var list<array> $latest */
?>
<section>
    <p class="eyebrow">Inicio</p>
    <h1>Hola, <?= htmlspecialchars($authUser['display_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="lead">Historias recientes y personas que sigues.</p>
</section>

<section class="stack-section">
    <h2>Recién publicadas</h2>
    <?php if ($latest === []): ?>
        <p class="empty">Aún no hay historias publicadas. Ve a Descubrir más tarde.</p>
    <?php else: ?>
        <ul class="card-list">
            <?php foreach ($latest as $book): ?>
                <li>
                    <a class="card-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/libros/<?= (int) $book['id'] ?>">
                        <strong><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span><?= htmlspecialchars($book['author_name'], ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars((string) ($book['genre'] ?? 'Sin género'), ENT_QUOTES, 'UTF-8') ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<section class="stack-section">
    <h2>Siguiendo</h2>
    <?php if ($following === []): ?>
        <p class="empty">Todavía no sigues a nadie. En Descubrir puedes encontrar escritores.</p>
    <?php else: ?>
        <ul class="card-list">
            <?php foreach ($following as $person): ?>
                <li>
                    <a class="card-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/u/<?= htmlspecialchars(rawurlencode($person['username']), ENT_QUOTES, 'UTF-8') ?>">
                        <strong><?= htmlspecialchars($person['display_name'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span>@<?= htmlspecialchars($person['username'], ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars($person['role'], ENT_QUOTES, 'UTF-8') ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
